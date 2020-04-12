<div class="container">
	<div class="row mt-3">
    <div class="col">
    </div>
		<div class="col-6 text-center">
      <img src="<?php echo IMAGE_PATH.$data['user']['user_img'] ?>" alt=" " class="rounded-circle shadow border border-dark" width=130px height=130px>
    </div>
    <div class="col-3 align-self-end">
      <a class="btn btn-sm btn-secondary" href="<?php echo USER.$data['user']['user_id']."/image"?>" role="button">
        <i class="fa fa-pencil"></i>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-12 text-center">
      <h2><?php echo $data['user']['name']." ".$data['user']['surname'] ?></h2>
      <small><?php echo $data['user']['email'] ?></small>
    </div>
  </div>
  <div class="card mb-3 mt-3 p-0">
    <div class="card-body">
      <?php if($data['is_seller']): ?>
        <canvas id="chart"></canvas>
      <?php else: ?>
      <?php if(empty($data['events_inbound'])): ?>
      <strong>Any Events On Alert</strong>
      <?php else: ?>
      <div class="row mb-3">
        <div class="col-6 mt-1 align-self-center">
          <strong>Events On Alert</strong>
        </div>
        <div class="col-4 ml-auto">
          <a class="btn btn-outline-secondary btn-block" href="<?php echo USER.$data['user']['user_id']."/submits"?>" role="button">All</a>
        </div>
      </div>
      <div class="list-group">
        <div class="row">
          <?php foreach ($data['events_inbound'] as $event): ?>
						<a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action mb-2">
                <div class="col-12 text-justify">
                  <strong><?php echo $event['title'] ?></strong>
                  <small class="pull-right"><?php echo date_format(date_create($event['date']),"D, F d");?></small>
                </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    <?php endif; ?>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-6">
        <a class="btn btn-secondary btn-block" href="<?php echo USER.$data['user']['user_id']."/edit"?>" role="button">Change Password</a>
    </div>
    <div class="col-6">
      <?php if($data['is_seller']): ?>
        <a class="btn btn-secondary btn-block" href="<?php echo USER.$data['user']['user_id']."/events"?>" role="button">My Events</a>
      <?php else: ?>
        <a class="btn btn-secondary btn-block" href="<?php echo USER.$data['user']['user_id']."/orders"?>" role="button">Orders</a>
      <?php endif; ?>
    </div>
  </div>
</div>
