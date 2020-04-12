<?php

require_once('../app/models/Auth.php');

class NotifiesController extends Controller {
    private $model;

    public function __construct($request, $response) {
      parent::__construct($request, $response);
      $this->model = $this->loadModel('Notify');
    }
    
    public function index() {
      $data['notifies'] = $this->model->getUserNotifies($_SESSION['user_id']);
      $data['unread'] = $this->model->getUnreadCount($data['notifies']);
      echo json_encode($data);
    }

    public function read() {
        $alertId = $this->request->paramsPost()['alert_id'];
        $eventId = $this->request->paramsPost()['event_id'];
        if(!empty($alertId) && $eventId == -1) {
          $this->model->readBroadcast($alertId);
        } else if(!empty($alertId)) {
          $this->model->readNotification($alertId);
        } else {
          $this->model->readAllNotifications($_SESSION['user_id']);
        }
    }
}

?>

