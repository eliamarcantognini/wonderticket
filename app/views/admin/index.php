<div class="container">
    <section class="mt-3 mb-4">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6 text-center">
          <img src="<?php echo IMAGE_PATH.$data['user']['user_img'] ?>" alt="user_profile" class="rounded-circle img-responsive shadow border border-dark" width=130px height=130px>
        </div>
        <div class="col-3 align-self-end">
          <a class="btn btn-sm btn-secondary" href="<?php echo USER.$data['user']['user_id']."/image"?>" role="button">
            <i class="fa fa-pencil"></i>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="mb-0"><?php echo $data['user']['name']." ".$data['user']['surname'] ?></h2>
          <small><?php echo $data['user']['email'] ?></small>
        </div>
      </div>    
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-4 mb-2">
          <a class="btn btn-primary btn-block" href="<?php echo USER.$data['user']['user_id']."/edit"?>" role="button">Change password</a>
        </div>
      </div>
    </section>
    <section class="mt-5">
      <div class='row'>
        <div class="col-md-6 mb-2">
          <a class="btn btn-secondary btn-block" href="<?php echo ADMIN."approve"?>" role="button">Approvals</a>
        </div>
        <div class="col-md-6 mb-2">
          <a class="btn btn-secondary btn-block" href="<?php echo ADMIN."notification"?>" role="button"> Notification</a>
        </div>
      </div>
      <div class='row'>
        <div class="col-md-6 mb-2">
          <a class="btn btn-secondary btn-block" href="<?php echo ADMIN."events"?>" role="button">Events</a>
        </div>
        <div class="col-md-6">
          <a  class="btn btn-secondary btn-block" href="<?php echo ADMIN."users"?>" role="button"> Users</a>
        </div>
      </div>
    </section>
    <section class="mt-4">
      <div class="jumbotron text-center">
        <div class='row'>
            <div class="col-md-6">
              <p class="lead">Tickets sold </p>
                <canvas id="myChart1" width="400" height="400"></canvas>
              </div>
            <div class="col-md-6" id="">
              <p class="lead">Events for sale</p>
              <canvas id="myChart2" width="400" height="400"></canvas>
            </div>
          </div>
          <hr class="my-4">
          <div class='row'>
            <div class="col-md-6">
              <p class="lead">Users signed up</p>
              <canvas id="myChart3" width="400" height="400"></canvas>
            </div>
            <div class="col-md-6">
              <p class="lead">Notifications sent</p>
              <canvas id="myChart4" width="400" height="400"></canvas>
            </div>
          </div>
      </div>
    </section>
</div>