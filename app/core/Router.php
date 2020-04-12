<?php

require_once('../app/utils/klein.php');
require_once('../app/controllers/Controller.php');

$klein = new \Klein\Klein();

/* HOME ROUTES */
$homeRoute = function($request, $response) {
  require_once('../app/controllers/home.php');
  $controller = new HomeController($request, $response);
  $controller->index();
};

$klein->respond('GET', '/home', $homeRoute);
$klein->respond('GET', '/', $homeRoute);

/* AUTH ROUTES */
$klein->with('/auth', function () use ($klein) {
  require_once('../app/controllers/auth.php');
  /* get login form */
  $klein->respond('GET', '/?', function($request, $response) {
      $controller = new AuthController($request, $response);
      $controller->index();
  });

  /* get signup form */
  $klein->respond('GET', '/create', function($request, $response) {
      $controller = new AuthController($request, $response);
      $controller->create();
  });

  /* log in */
  $klein->respond('POST', '/?', function($request, $response) {
      $controller = new AuthController($request, $response);
      $controller->login();
  });

  /* log in */
  $klein->respond('POST', '/create', function($request, $response) {
      $controller = new AuthController($request, $response);
      $controller->store();
  });

  /* log out */
  $klein->respond('DELETE', '/?', function($request, $response) {
    $controller = new AuthController($request, $response);
    $controller->delete();
  });

});

/* EVENTS ROUTES */

$klein->with('/events', function () use ($klein) {

  require_once('../app/controllers/events.php');

  $klein->respond('GET', '/?', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->index();
  });

  $klein->respond('GET', '/[i:id]', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->show();
  });

  $klein->respond('GET', '/[i:id]/edit', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->edit();
  });

  $klein->respond('GET', '/create', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->create();
  });

  $klein->respond('POST', '/?', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->store();
  });

  $klein->respond('PUT', '/[i:id]', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->update();
  });

  $klein->respond('DELETE', '/[i:id]', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->delete();
  });

  $klein->respond('POST', '/search', function($request, $response) {
    $controller = new EventsController($request, $response);
    $controller->search();
  });

  $klein->respond('POST', '/[i:id]/alert', function($request, $response) {
    $controller = new EventsController($request, $response);
    $controller->subscribe();
  });

  $klein->respond('DELETE', '/[i:id]/alert', function($request, $response) {
      $controller = new EventsController($request, $response);
      $controller->unsubscribe();
  });
});

/* USER ROUTES */
$klein->with('/users', function () use ($klein) {

    require_once('../app/controllers/user.php');

    $klein->respond('GET', '/[i:id]/orders', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->orders();
    });

    $klein->respond('GET', '/[i:id]/events', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->events();
    });

    $klein->respond('GET', '/[i:id]', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->show();
    });

    $klein->respond('GET', '/chart', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->loadChart();
    });

    $klein->respond('GET', '/[i:id]/edit', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->edit();
    });

    $klein->respond('GET', '/[i:id]/image', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->image();
    });

    $klein->respond('GET', '/[i:id]/submits', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->submits();
    });

    $klein->respond('POST', '/[i:id]/submits/?', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->removeSubmit();
    });

    $klein->respond('PUT', '/[i:id]/pass', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->updatePassword();
    });

    $klein->respond('PUT', '/img', function($request, $response) {
      $controller = new UserController($request, $response);
      $controller->updateImage();
    });
  /*
    $klein->respond('DELETE', '/[i:id]', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->delete();
    });
    */

    $klein->respond('POST', '/[i:id]/events/?', function($request, $response) {
        $controller = new UserController($request, $response);
        $controller->sendNotify();
    });

  });

/* ADMIN ROUTES */
$klein->with('/admin', function () use ($klein) {

    require_once('../app/controllers/admin.php');

    $klein->respond('GET', '/?', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->index();
    });

    $klein->respond('GET', '/events', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->events();
    });

    $klein->respond('GET', '/users', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->users();
    });

    $klein->respond('GET', '/approve', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->approve();
    });

    $klein->respond('GET', '/notification', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->notification();
    });

    $klein->respond('GET', '/charts', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->charts();
    });

    $klein->respond('POST', '/search/?', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->search();
    });

    $klein->respond('POST', '/approve/?', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->updateApprovals();
    });

    $klein->respond('POST', '/events/?', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->updateEvents();
    });

    $klein->respond('POST', '/notification/?', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->sendNotify();
    });

    $klein->respond('POST', '/users/?', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->updateUsers();
    });

    $klein->respond('DELETE', '/[i:id]', function($request, $response) {
        $controller = new AdminController($request, $response);
        $controller->delete();
    });
  });

/* Notifies routes */
$klein->with('/notifies', function () use ($klein) {

  require_once('../app/controllers/notifies.php');

  $klein->respond('GET', '/?', function($request, $response) {
      $controller = new NotifiesController($request, $response);
      $controller->index();
  });

  $klein->respond('PUT', '/?', function($request, $response) {
      $controller = new NotifiesController($request, $response);
      $controller->read();
  });
});

$klein->with('/cart', function () use ($klein) {

    require_once('../app/controllers/cart.php');

    $klein->respond('GET', '/?', function($request, $response) {
        $controller = new CartController($request, $response);
        $controller->index();
    });

    $klein->respond('GET', '/count', function($request, $response) {
      $controller = new CartController($request, $response);
      $controller->count();
    });

    $klein->respond('POST', '/?', function($request, $response) {
      $controller = new CartController($request, $response);
      $controller->store();
    });

    $klein->respond('DELETE', '/[i:id]', function($request, $response) {
        $controller = new CartController($request, $response);
        $controller->delete();
    });

    $klein->respond('PUT', '/?', function($request, $response) {
        $controller = new CartController($request, $response);
        $controller->update();
    });
});

$klein->dispatch();

?>
