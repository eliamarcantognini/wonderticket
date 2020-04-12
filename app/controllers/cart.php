<?php

require_once('../app/models/Auth.php');

class CartController extends Controller {
    private $model;

    public function __construct($request, $response) {
      parent::__construct($request, $response);
      $this->model = $this->loadModel('Cart');
    }
    
    public function index() {
      $data['page_title'] = "WonderTickets - Cart";
      $data['scripts'] = [JS_CART];
      $data['tickets'] = $this->model->getCartTickets();
      //$data['total_price'] = $this->getTotalPrice($data['tickets']);
      $this->render('cart/index', $data);
    }

    public function delete() {
      $this->model->removeTicketFromCart($this->request->params()['id']);
    }

    public function update() {
      $this->model->purchase();
      $this->response->redirect(USER.$_SESSION['user_id']."/orders", $code = 302);
    }

    public function store() {
      $this->model->addTicketToCart($this->request->paramsPost()['event_id']);
    }
  
    public function count() {
      echo $this->model->getCatItemsCount();
    }

    private function getTotalPrice($tickets) {
      $price = 0.0;
      foreach($tickets as $ticket) {
        $price+=$ticket['price'];
      }
      return $price;
    }

}

?>

