<?php

class User extends Model {

  public function __construct() {
      parent::__construct();
  }

  public function getUser($id){
    $stmt = $this->mysqli->prepare("SELECT * FROM User WHERE  user_id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getUpcomingSubmitEvents($id) {
    $stmt = $this->mysqli->prepare(
      "SELECT e.event_id, e.title, e.date
       FROM Event e, Submit s
       WHERE s.user_id = ?
       AND e.cancelled = 0
       AND e.disabled = 0
       AND s.event_id = e.event_id
       ORDER BY e.date
       LIMIT 3");
     $stmt->bind_param('i',$id);
     $stmt->execute();
     $result = $stmt->get_result();

     return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getUserOwnEvents($id) {
    $stmt = $this->mysqli->prepare(
      "SELECT e.event_id, e.title, e.date, e.disabled, e.cancelled, e.tickets,
              v.city, v.state
       FROM Event e, Venue v
       WHERE e.user_id = ?
       AND e.venue_id = v.venue_id
       ORDER BY e.date");
     $stmt->bind_param('i',$id);
     $stmt->execute();
     $result = $stmt->get_result();

     return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getNotifies() {
    $stmt = $this->mysqli->prepare("SELECT * FROM Notify ORDER BY text");
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function sendNotify($event_id, $notify_id) {
    $stmt = $this->mysqli->prepare("SELECT user_id FROM Submit WHERE event_id = ?");
    $stmt->bind_param('s',$event_id);
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_NUM);
    foreach($users as $user_id) {
      $insert_stmt = $this->mysqli->prepare( "INSERT Into Alert(`notify_id`, `event_id`, `user_id`) VALUES (?, ?, ?)");
      $insert_stmt->bind_param('ssi', $notify_id, $event_id, $user_id[0]);
      $insert_stmt->execute();
    }
  }

  public function getAllSubmitEvents($id) {
    $stmt = $this->mysqli->prepare(
      "SELECT e.event_id, e.title, e.date
       FROM Event e, Submit s
       WHERE s.user_id = ?
       AND e.cancelled = 0
       AND e.disabled = 0
       AND s.event_id = e.event_id
       ORDER BY e.date");
     $stmt->bind_param('i',$id);
     $stmt->execute();
     $result = $stmt->get_result();

     return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getOrders($id){
    $stmt = $this->mysqli->prepare(
      "SELECT e.event_id, e.title, e.date, t.purchase_date, t.price
       FROM Ticket t, Event e
       WHERE  t.user_id = ?
       AND t.event_id = e.event_id
       ORDER BY e.date");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getTicketsSold($id) {
      $stmt = $this->mysqli->prepare(
       "SELECT COUNT(ticket_id) as purchased
        FROM Ticket t, Event e
        WHERE t.event_id = e.event_id
        AND e.user_id = ?
        AND t.purchase_date IS NOT NULL
        GROUP BY e.event_id
      ");
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function remove($eId, $uId) {
    $stmt = $this->mysqli->prepare("DELETE FROM Submit WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param('ii', $eId, $uId);
    $stmt->execute();
  }

  public function updatePassword($params, $userId) {
    if($this->isValidPassword($params['p'], $userId)) {
      $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
      $password = hash('sha512', $params['p_new'].$random_salt);
      $query = "UPDATE User SET password = ? , salt = ? WHERE user_id = ?";
      $insert_stmt = $this->mysqli->prepare($query);
      $insert_stmt->bind_param('ssi', $password, $random_salt, $userId);
      $insert_stmt->execute();
      $user_browser = $_SERVER['HTTP_USER_AGENT'];
      $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
      return false;
    }
    return true;
  }

  public function updateImage($image, $userId) {
    $query = "UPDATE User SET user_img = ? WHERE user_id = ?";
    $stmt = $this->mysqli->prepare($query);
    $stmt->bind_param('si', $image, $userId);
    $stmt->execute();
  }

  public function getTicketChart($id){
    $stmt = $this->mysqli->prepare(
      "SELECT DISTINCT e.title
      FROM Ticket t, Event e
      WHERE t.event_id = e.event_id
      AND t.purchase_date IS NOT NULL
      AND e.user_id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $ticketChartX = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    $stmt = $this->mysqli->prepare(
    "SELECT COUNT(*)
    FROM Ticket t, Event e
    WHERE t.event_id = e.event_id
    AND e.user_id = ?
    AND t.purchase_date IS NOT NULL
    GROUP BY e.event_id");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $ticketChartY = $stmt->get_result()->fetch_all(MYSQLI_NUM);

    $charts = ['x' => $ticketChartX, 'y' => $ticketChartY];
    return $charts;
  }

  private function isValidPassword($password, $user_id) {
    $query = "SELECT password, salt FROM User WHERE user_id = ? LIMIT 1";
    if($stmt = $this->mysqli->prepare($query)) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = ($stmt->get_result())->fetch_all(MYSQLI_ASSOC);
        $password = hash('sha512', $password.$result[0]['salt']);
        return $password == $result[0]['password'];
    }
    return false;
  }

}

?>
