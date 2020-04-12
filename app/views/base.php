<!doctype html>
<html class="h-100" lang="it">
  <head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/wonderticket/public/css/bootstrap.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
  <!-- CSS -->
  <link rel="stylesheet" href="/wonderticket/public/css/style.css" >

  <script src="<?php echo JS_QUERY ?>"></script>
  <?php if(isset($_SESSION['privilege']) && $_SESSION['privilege'] !== 'admin'): ?>
    <script src="<?php echo JS_NOTIFY ?>"></script>
  <?php endif; ?>
  <?php if(isset($data['scripts'])): foreach ($data['scripts'] as $script): ?>
  <script src=<?=$script?>></script>
  <?php endforeach; endif;?>

  <title><?=$data['page_title']?></title>
</head>
<body class="d-flex flex-column h-100 bg-light">

  <header>
    <nav class="navbar fixed-top navbar-dark navbar-expand-lg bg-primary">
    <div class="container">
      <a class="navbar-brand mr-auto" href="<?php echo HOME ?>">WonderTickets</a>

      <div class="row mr-1">
        
        <?php if(isset($_SESSION['privilege']) && $_SESSION['privilege'] === 'customer'): ?>
        <div class="nav-item">
            <a class="nav-link pr-md-1" href="<?php echo CART ?>"><span id="notifyCart" class="badge rounded-circle badge-danger"></span><i class="fa fa-shopping-cart text-white"></i></a>
        </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['privilege']) && $_SESSION['privilege'] !== 'admin'): ?>
        <div class="dropdown nav-item">
          <a id="notifiesBtn" href="" class="nav-link pl-0 pl-md-3" data-toggle="dropdown"><span id="notifyCounter" class="badge rounded-circle badge-danger"></span><i class="fa fa-bell text-white"></i></a>
          <ul id="notifiesList" class="dropdown-menu dropdown-menu-right p-0">
          </ul>
        </div>
        <?php endif; ?>

      </div>

      <button class="navbar-toggler p-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mt-2 mt-lg-0">
          <?php if(!isset($_SESSION['name'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo LOGIN ?>"><i class="fa fa-sign-in text-white"></i> Log in</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SIGNUP ?>"><i class="fa fa-user-plus text-white"></i> Signup</a>
          </li>
          <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php if(!strcmp($_SESSION['privilege'], 'admin')) {echo ADMIN;} else { echo USER.$_SESSION['user_id'];} ?>">
            <i class="fa fa-user text-white"></i> <?php echo $_SESSION['name'] ?></a>
          </li>
          <?php if(isset($_SESSION['privilege']) && $_SESSION['privilege'] === 'customer'): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo USER.$_SESSION['user_id']."/orders" ?>"><i class="fa fa-ticket text-white"></i> Orders</a>
          </li>
          <?php elseif(isset($_SESSION['privilege']) && $_SESSION['privilege'] === 'seller'): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo USER.$_SESSION['user_id']."/events" ?>"><i class="fa fa-ticket text-white"></i> Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo EVENT."create" ?>"><i class="fa fa-plus-circle text-white"></i> Create event</a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <form action="<?php echo LOGOUT ?>" method="post">
                <input name="_method" type="hidden" value="delete" />
                <button class="nav-link btn btn-link" type="submit"><i class="fa fa-sign-out text-white"></i> Log out</button>
            </form>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    </nav>
  </header>

  <main class="flex-shrink-0" role="main">
      <?php require_once $data['page'] ?>
  </main>

  <footer class="footer bg-primary mt-auto py-3">
    <div class="container">
      <div class="row">
        <div class="col-4">
          <div class="row">
            <div class="col-md-6">
            <span class="text-light">Conditions</span>
            </div>
            <div class="col-md-6">
              <span class="text-light">Privacy</span>
            </div>
          </div>
        </div>
        <div class="col-8 text-right">
          <span  class="text-light">Language:</span><span class="text-light"> Italian</span>
        </div>
      </div>
    </div>
  </footer>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
