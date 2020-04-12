<?php

class Auth extends Model {
  
  public function __construct() {
      parent::__construct();
  }

  public function login($email, $password) {
    $query = "SELECT user_id, name, password, salt, privilege, approved FROM User WHERE email = ? LIMIT 1";
    if(isset($email, $password) && ($stmt = $this->mysqli->prepare($query))) {
        $stmt->bind_param('s', $email); 
        $stmt->execute(); 
        $stmt->store_result();
        $stmt->bind_result($user_id, $name, $db_password, $salt, $privilege, $approved); 
        $stmt->fetch();
        $password = hash('sha512', $password.$salt); // encrypt password with a unique key (salt). 
        if($stmt->num_rows == 1) {
            if(!$approved) {
                return APPR_ERR;
            } else if($this->checkbrute($user_id, $this->mysqli) == true) {
                return BRUTE_ERR;
            } else if($db_password == $password) { 
                $this->setAuthSession($user_id, $name, $password, $privilege);
                return 0;
            } else {
                /* wrong password */
                $this->addInvalidAttempt($user_id);
                return PASSW_ERR;
            }
        } else {
            return USER_ERR;
        }
    }
    return LOGIN_ERR;
  }

  public function signup($user) {
      if($this->userAlreadyExist($user['email'])) {
          return USER_EXS;
      } else if(!$this->checkSignup($user)) {
          $name = ucfirst(strtolower($user['name'])); 
          $surname = ucfirst(strtolower($user['surname'])); 
          if(!isset($user['sellerCheckBox'])) {
              $user['company'] = NULL;
              $user['iva'] = NULL;
              $privilege = 'customer';
              $approved = 1;
          } else {
              if(empty($user['company']) || empty($user['iva'])) {
                return SIGNUP_ERR;
              }
              $privilege = 'seller';
              $approved = 0;
          }
          /* create a random key */
          $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
          /* encrypt password with the key which has just been created */
          $password = hash('sha512', $user['p'].$random_salt);
          $query = "INSERT INTO User (name, surname, email, password, company, vat, salt, privilege, approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $insert_stmt = $this->mysqli->prepare($query);
          if (!$insert_stmt->errno) { 
            $insert_stmt->bind_param('ssssssssi', $name, $surname, $user['email'], $password, $user['company'], $user['iva'], $random_salt, $privilege, $approved); 
            $insert_stmt->execute();
            if($insert_stmt->errno) {
              return SIGNUP_ERR;
            }
            if($approved) {
              $this->setAuthSession($this->mysqli->insert_id, $name, $password, $privilege);
            }
            return 0;
          }
      }
      return SIGNUP_ERR;
  }

  public static function isLogged($mysqli) {
      $isLoggedIn = false;
      /* Verify all session's variables */
      if(isset($_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $name = $_SESSION['name'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];  
        if ($stmt = $mysqli->prepare("SELECT password FROM User WHERE user_id = ? LIMIT 1")) {
          $stmt->bind_param('i', $user_id); 
          $stmt->execute(); 
          $stmt->store_result();
          if($stmt->num_rows == 1) { 
              $stmt->bind_result($password); 
              $stmt->fetch();
              $login_check = hash('sha512', $password.$user_browser);
              if($login_check == $login_string) {
                $isLoggedIn = true;
              } 
          }
        }
      }
      return $isLoggedIn;
  }
  
  public function logout() {
      sec_session_start();
      /* remove all session's params */
      $_SESSION = array();
      $params = session_get_cookie_params();
      /* remove current cookies */
      setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
      session_destroy();
  }

  public static function isSeller() {
      return !strcmp($_SESSION['privilege'], 'seller');
  }

  public static function isCustomer() {
      return !strcmp($_SESSION['privilege'], 'customer');
  }

  public static function isAdmin() {
      return !strcmp($_SESSION['privilege'], 'admin');
  }
  
  private function checkbrute($user_id, $conn) {
      $now = time();
      $valid_attempts = $now - (30 * 60); /* maxium num of wrong attempts in last 30 minutes */
      if ($stmt = $conn->prepare("SELECT time FROM Login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 4) {
            return true;
        } else {
            return false;
        }
      }
  }

  private function setAuthSession($user_id, $name, $password, $privilege) {
      $user_browser = $_SERVER['HTTP_USER_AGENT']; 
      $user_id = preg_replace("/[^0-9]+/", "", $user_id); // protect us from a XSS attack.
      $_SESSION['user_id'] = $user_id;
      $name = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $name); // protect us from XSS attack.
      $_SESSION['name'] = $name;
      $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
      $_SESSION['privilege'] = $privilege;
  }

  private function addInvalidAttempt($user_id) {
      $now = time();
      $query = "INSERT INTO Login_attempts (user_id, time) VALUES (?, ?)";
      $insert_stmt = $this->mysqli->prepare($query);

      $insert_stmt->bind_param('is', $user_id, $now); 
      $insert_stmt->execute();
  }

  private function checkSignup($user) {
      return strcmp($user['p'], $user['p_confirm']) 
          || strlen($user['p']) < 1
          || empty($user['email'])
          || empty($user['name'])
          || empty($user['surname']);
  }

  private function userAlreadyExist($email) {
      $query = "SELECT email FROM User WHERE email = ? LIMIT 1";
      $stmt = $this->mysqli->prepare($query);
      $stmt->bind_param('s', $email); 
      $stmt->execute(); 
      $stmt->store_result();
      return $stmt->num_rows == 1;
  }
}
?>