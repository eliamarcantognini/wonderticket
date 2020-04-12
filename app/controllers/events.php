<?php

require_once('../app/models/Auth.php');

class EventsController extends Controller {
    private $model;

    public function __construct($request, $response) {
      parent::__construct($request, $response);
      $this->model = $this->loadModel('Event');
    }
    
    public function index() {
      $params = $this->request->params();
      $index = $params['index'];
      $limit = $params['limit'];
      $offset = $index * $limit;
      $result = $this->model->getFilteredEvents($params['category'], $params['venue'], $params['period'], $limit, $offset);
      echo json_encode($result);
    }

    public function show() {
      $eventId = $this->request->params()['id'];
      $data['event'] = $this->model->getEvent($eventId)[0];
      $data['event']['available']  = $this->model->getAvailableTickets($eventId);
      $data['event']['purchased']  = $this->model->getPurchasedTickets($eventId);
      $data['event']['interested'] = $this->model->getInterestedCustomers($eventId);
      $data['event']['price'] = $this->model->getCurrentEventPrice($eventId);
      if(Auth::isLogged($this->model->mysqli)) {
        $data['scripts'] = [JS_ALERT, JS_CART];
        $data['isowner'] = $this->isEventOwner($data['event']);
        $data['is_interested'] = $this->model->isOnAlertList($eventId, $_SESSION['user_id']);
      } else {
        $data['isowner'] = 0;
        $data['is_interested'] = 0;
      }
      $data['page_title'] = "WonderTickets -  Event";
      $this->render('events/event', $data);
    }

    public function edit() {
      $eventId = $this->request->params()['id'];
      $data['event'] = $this->model->getEvent($eventId)[0];
      if($this->isEventOwner($data['event'])) {
        $data['page_title'] = "WonderTickets - Edit Form";
        $data['categories'] = $this->model->getCategories();
        $data['venues'] = $this->model->getVenues();
        $data['event']['price'] = $this->model->getCurrentEventPrice($eventId);
        //$data['scripts'] = [JS_SHA512, JS_FORMS];
        $this->render('events/event_form', $data);
      } else {
        $this->response->redirect(HOME, $code = 302);
      }
    }

    public function create() {
      if(Auth::isSeller()) {
        $data['event'] = $this->getEmptyEvent();
        $data['page_title'] = "WonderTickets - Create Form";
        $data['categories'] = $this->model->getCategories();
        $data['venues'] = $this->model->getVenues();
        //$data['scripts'] = [JS_SHA512, JS_FORMS];
        $this->render('events/event_form', $data);
      } else {
        $this->response->redirect(HOME, $code = 302);
      }
    }

    public function store() {
      if(Auth::isLogged($this->model->mysqli)) {
        $eventId = $this->model->createEvent($this->request->paramsPost(), $_SESSION['user_id']);
        $this->response->redirect(EVENT.$eventId, $code = 302);
      } else {
        $this->response->redirect(HOME, $code = 302);
      }
    }

    public function update() {
      if(Auth::isLogged($this->model->mysqli)) {
        $event = $this->request->paramsPost();
        $event['event_id'] = $this->request->params()['id'];
        $this->model->updateEvent($event);
        $this->response->redirect(EVENT.$event['event_id'], $code = 302);
      } else {
        $this->response->redirect(HOME, $code = 302);
      }
    }

    public function delete() {
        if(Auth::isLogged($this->model->mysqli)) {
          $eventId = $this->request->params()['id'];
          $this->model->cancelEvent($eventId);
          $this->response->redirect(EVENT.$eventId, $code = 302);
        } else {
          $this->response->redirect(HOME, $code = 302);        
        }
    }

    public function subscribe() {
      if(Auth::isLogged($this->model->mysqli)) {   
        $eventId = $this->request->params()['id'];
        $this->model->subscribeForTicketAllerts($eventId, $_SESSION['user_id']);
        //$this->response->redirect(EVENT.$eventId, $code = 302);
      } else {
        $this->response->redirect(LOGIN, $code = 302);               
      }
    }

    public function unsubscribe() {
      if(Auth::isLogged($this->model->mysqli)) {   
        $eventId = $this->request->params()['id'];
        $minchia = $this->model->unsubscribeFromTicketAllerts($eventId, $_SESSION['user_id']);
        //$this->response->redirect(EVENT.$eventId, $code = 302);
      } else {
        $this->response->redirect(HOME, $code = 302);               
      }
    }

    public function search() {
        $title = $this->request->paramsPost()['search'];
        echo json_encode($this->model->getEventFromTitle($title));
    }

    private function isEventOwner($event) {
      return $event['user_id'] == $_SESSION['user_id'];
    }

    private function getEmptyEvent() {
      return array('event_id' => '', 'title' => '', 'artist' => '', 'price' => 0, 'description' => '', 'category_id' => 0, 'venue_id' => 0);
    }
}

?>

