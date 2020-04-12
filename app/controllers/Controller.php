<?php

require_once('../app/core/config.php');
require_once('../app/models/Model.php');

class Controller {

  protected $request;
  protected $response;

  public function __construct($request, $response) {
      $this->request = $request;
      $this->response = $response;
  }

  protected function loadModel($model) {
      require_once('../app/models/' . $model . '.php');
      return new $model();
  }

  protected function render($view, $data = []) {
      $data['page'] = '../app/views/' . $view . '.php';
      require_once('../app/views/base.php');
  }

}

?>

