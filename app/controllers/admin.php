<?php

require_once('../app/models/Auth.php');

class AdminController extends Controller {
    private $model;
    private $chartScripts = [JS_LIB_CHART, JS_CHARTS];
    private $notifyScripts = [JS_ADMIN_NOTIFY];

    public function __construct($request, $response) {
      parent::__construct($request, $response);
      $this->model = $this->loadModel('Admin');
    }
    
    public function index() {
        if(Auth::isLogged($this->model->mysqli)) {
            if (Auth::isAdmin()) {
                $data['user'] = $this->loadModel('User')->getUser($_SESSION['user_id'])[0];
                $data['scripts'] = $this->chartScripts;
                $data['page_title'] = "WonderTickets -  Admin";
                $this->render('admin/index', $data); 
            }
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function events() {
        if(Auth::isLogged($this->model->mysqli)) {
            if(Auth::isAdmin()) {
                $data['going_events'] = $this->model->getGoingEvents();
                $data['disabled_events'] = $this->model->getDisabledEvents();
                $data['cancelled_events'] = $this->model->getCancelledEvents();
                $data['page_title'] = "WonderTickets -  Events management";
                $this->render('admin/events', $data);
            }
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function users() {
        if(Auth::isLogged($this->model->mysqli)) {
            if(Auth::isAdmin()) {
                $data['users'] = $this->model->getAllUsers();
                $data['page_title'] = "WonderTickets -  Users management";
                $this->render('admin/users', $data);
            }
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function approve() {
        if(Auth::isLogged($this->model->mysqli)) {
            if(Auth::isAdmin()) {
                $data['disabled_users'] = $this->model->getUsersToBeApproved();
                $data['disabled_events'] = $this->model->getDisabledEvents();
                $data['page_title'] = "WonderTickets -  Manage approvals";
                $this->render('admin/approve', $data); 
            }
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function notification() {
        if(Auth::isLogged($this->model->mysqli)) {
            if(Auth::isAdmin()) {
                $data['users'] = $this->model->getAllUsers();
                $data['scripts'] = $this->notifyScripts;
                $data['page_title'] = "WonderTickets -  Manage notification";
                $this->render('admin/notification', $data);
            }
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function updateApprovals() {
        if(Auth::isAdmin()) {
            $params = $this->request->paramsPost();
            if (isset($params['user_id'])) {
                $this->model->enableUser($params['user_id']);
            } else if (isset($params['event_id'])) {
                $this->model->enableEvent($params['event_id']);
            }
            $this->approve();
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }
    public function updateEvents() {
        if(Auth::isAdmin()) {
            $params = $this->request->paramsPost();
            if ($params['op'] == "d") {
                $this->model->disableEvent($params['event_id']);
            } else if ($params['op'] == "e") {
                $this->model->enableEvent($params['event_id']);
            }
            $this->events();
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function updateUsers() {
        if(Auth::isAdmin()) {
            $params = $this->request->paramsPost();
            $this->model->disableUser($params['user_id']);
            $this->users();
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function sendNotify() {
        if(Auth::isAdmin()) {
            $params = $this->request->paramsPost();
            if ($params['op'] == "b") {
                $this->model->sendBroadcast($params['text']);
            } else if ($params['op'] == "u") {
                $this->model->sendNotify($params['user_id'], $params['text']);
            }
            $this->notification();
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function delete() {
        if (Auth::isAdmin) {
            $this->render('admin/index', []);
        } else {
            $this->response->redirect(HOME, $code = 302);
        }
    }

    public function search() {
        $name = $this->request->paramsPost()['search'];
        echo json_encode($this->model->getUserByName($name));
    }

    public function charts() {
        echo json_encode($this->model->getCharts());
    }
}
?>

