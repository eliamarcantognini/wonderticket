<?php 

class AuthController extends Controller {
    private $scripts = [JS_SHA512, JS_FORMS];
    private $auth;

    public function __construct($request, $response) {
      parent::__construct($request, $response);
      $this->auth = $this->loadModel('Auth');
    }

    public function index() {
      if(Auth::isLogged($this->auth->mysqli)) {
        $this->response->redirect(HOME, $code = 302);
      } else {
        $data['page_title'] = "WonderTickets -  Login";
        $data['scripts'] = $this->scripts;
        $errorCode = $this->request->paramsGet()['error'];
        $data['error_msg'] = isset($errorCode) ? login_errors[$errorCode] : "";
        $this->render('auth/login_form', $data);
      }
    }

    public function login() {
      $params = $this->request->paramsPost();
      $errorCode = $this->auth->login($params['email'], $params['p']);
      $this->response->redirect($errorCode ? LOGIN."?error=".$errorCode : HOME, $code = 302);
    }

    public function create() {
      if(Auth::isLogged($this->auth->mysqli)) {
        $this->response->redirect(HOME, $code = 302);
      } else {
        $data['page_title'] = "WonderTickets -  Signup";
        $data['scripts'] = $this->scripts;
        $errorCode = $this->request->paramsGet()['error'];
        $data['error_msg'] = isset($errorCode) ? signup_errors[$errorCode] : "";
        $this->render('auth/signup_form', $data);
      }
    }

    public function store() {
      $params = $this->request->paramsPost();
      $errorCode = $this->auth->signup($params);
      $this->response->redirect(($errorCode ? SIGNUP."?error=".$errorCode : HOME), $code=302);
    }

    public function delete() {
      if(Auth::isLogged($this->auth->mysqli)) {
          $this->auth->logout();
      }
      $this->auth->logout();
      $this->response->redirect(HOME, $code = 302);
    }
}

?>

