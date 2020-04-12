<?php

class HomeController extends Controller {

    public function __construct($request, $response) {
      parent::__construct($request, $response);
    }
    
    public function index() {
        $eventModel = $this->loadModel('Event');
        $data['page_title']  = "WonderTickets -  Home";
        $data['events'] = $eventModel->getRandEvents();
        $data['scripts'] = [JS_SEARCH];
        $data['venues'] = $eventModel->getVenues();
        $data['categories'] = $eventModel->getCategories();
        $this->render('home/index', $data);
    }

}

?>

