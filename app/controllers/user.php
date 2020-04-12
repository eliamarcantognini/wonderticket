<?php

require_once('../app/models/Auth.php');

class UserController extends Controller {
  private $model;

  public function __construct($request, $response) {
    parent::__construct($request, $response);
    $this->model = $this->loadModel('User');
  }

  public function show() {
    $userId = $this->request->params()['id'];
    if($this->isMyProfile($userId)){
      $data['user'] = $this->model->getUser($userId)[0];
      $data['page_title'] = "WonderTickets -  User Info";
      if(Auth::isSeller()){
        $data['scripts'] = [JS_LIB_CHART, JS_USER_CHART];
      }
      $data['events_inbound'] = $this->model->getUpcomingSubmitEvents($userId);
      $data['is_seller'] = Auth::isSeller();
      $this->render('user/info', $data);
    } else {
      $this->response->redirect(HOME, $code = 302);
    }
  }

  public function edit() {
    $data['scripts'] = [JS_SHA512, JS_FORMS];
    $userId = $this->request->params()['id'];
    $data['user'] = $this->model->getUser($userId)[0];
    $data['page_title'] = "WonderTickets - Edit User";
    $errorCode = $this->request->paramsGet()['error'];
    $data['error_msg'] = isset($errorCode) ? "Current password is incorrect" : "";
    $this->render('user/user_form', $data);
  }

  public function image() {
    $userId = $this->request->params()['id'];
    $data['user'] = $this->model->getUser($userId)[0];
    $data['page_title'] = "WonderTickets - Edit Profile Image";
    $this->render('user/image_form', $data);
  }

  public function submits() {
    $userId = $this->request->params()['id'];
    $data['user'] = $this->model->getUser($userId)[0];
    $data['page_title'] = "WonderTickets - User Submits";
    $data['events_inbound'] = $this->model->getAllSubmitEvents($userId);
    if(empty($data['events_inbound'])){
      $this->response->redirect(USER.$userId, $code=302);
    } else {
      $this->render('user/submits', $data);
    }
  }

  public function orders() {
    $userId = $this->request->params()['id'];
    $data['user'] = $this->model->getUser($userId)[0];
    $data['event_orders'] = $this->model->getOrders($userId);
    $data['page_title'] = "WonderTickets - User Orders";
    $this->render('user/orders', $data);
  }

  public function removeSubmit(){
    $userId = $_SESSION['user_id'];
    $eventId = $this->request->paramsPost()['event_id'];
    $this->model->remove($eventId, $userId);
    $this->submits();
  }

  public function events() {
    if(Auth::isLogged($this->model->mysqli)) {
      if(Auth::isSeller()) {
        $userId = $this->request->params()['id'];
        $data['user'] = $this->model->getUser($userId)[0];
        $data['events'] = $this->model->getUserOwnEvents($userId);
        $data['notifies'] = $this->model->getNotifies();
        $data['page_title'] = "WonderTickets - User Own Events";
        $data['tickets_sold'] = $this->model->getTicketsSold($userId);
        $this->render('user/events', $data);
      }
  } else {
      $this->response->redirect(HOME, $code = 302);
    }
  }

  public function updatePassword() {
    $userId = $this->request->params()['id'];
    $params = $this->request->paramsPost();
    $errorCode = $this->model->updatePassword($params, $userId);
    $this->response->redirect(($errorCode ? USER.$userId."/edit"."?error=".$errorCode : USER.$userId), $code=302);
  }

  public function updateImage() {
    $userId = $_SESSION['user_id'];
    $image = $_FILES['image']['name'];
    $error = $this->upload();
    /*if($error) {
      $this->model->updateImage($image, $userId);
      $this->response->redirect(USER.$userId, $code=302);
    } else {
      $this->response->redirect(USER.$userId."/image"."?error=".$error, $code=302);
    }*/
    $this->model->updateImage($image, $userId);
    $this->response->redirect(USER.$userId, $code=302);
  }

  public function loadChart() {
    if(Auth::isSeller()){
      $userId = $_SESSION['user_id'];
      echo json_encode($this->model->getTicketChart($userId));
    }
  }

  public function sendNotify() {
    if(Auth::isSeller()) {
      $params = $this->request->paramsPost();
      $this->model->sendNotify($params['event_id'], $params['notify_id']);
      $this->events();
  } else {
      $this->response->redirect(HOME, $code = 302);
  }
  }

  public function delete() {
    $this->render('user/index', []);
  }

  private function isMyProfile($id){
    return $id == $_SESSION['user_id'];
  }

  private function upload() {
    $target_dir = $_SERVER['DOCUMENT_ROOT'].IMAGE_PATH;
    $target_file = $target_dir.basename($_FILES["image"]["name"]);
    var_dump($target_file);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["upload"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    // if everything is ok, try to upload file
    } else {
      move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }
    return $uploadOk;
  }
}

?>
