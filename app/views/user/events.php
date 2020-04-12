<div class="container">
  <?php if(!empty($data['events'])): ?>
  <section>
    <div class="card mb-3 mt-4">
      <div class="card-body">
        <div class="row">
          <div class="col">
          </div>
          <div class="col-4 col-md-2">
            <span class="col badge badge-warning">Disabled</span>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <strong>My Events</strong>
          </div>
          <div class="col-4 col-md-2">
            <span class="col badge badge-danger">Cancelled</span>
          </div>
        </div>
        <div class="row">
          <div class="col">
          </div>
          <div class="col-4 col-md-2">
            <span class="col badge badge-success">Sold Out</span>
          </div>
        </div>
      </div>
    </div>
    <div class="list-group">
      <div class="row">
          <?php foreach ($data['events'] as $event): ?>
            <div class="col-md-6">
              <a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action mb-2">
                <div class="row">
                  <div class="col-2 text-center">
                    <span class="fa fa-calendar-o"></span>
                  </div>
                  <div class="col">
                    <strong><?php echo $event['title'] ?></strong>
                  </div>
                  <div class="col-1">
                    <?php if($event['disabled']): ?>
                      <span class="badge badge-warning">D</span>
                    <?php endif; ?>
                  </div>
                  <div class="col-2">

                  </div>
                </div>
                <div class="row">
                  <div class="col-2 text-center">
                    <small><?php echo date_format(date_create($event['date']),"M"); ?></small>
                  </div>
                  <div class="col">
                    <small><?php echo date_format(date_create($event['date']),"l"); ?></small>
                  </div>
                  <div class="col-1">
                    <?php if($event['cancelled']): ?>
                      <span class="badge badge-danger">C</span>
                    <?php endif; ?>
                  </div>
                  <div class="col-2">
                    <small class="badge badge-pill badge-primary">
                      <span class="fa fa-ticket"></span>
                      <?php if(!empty($data['tickets_sold'][$event['event_id']-1])): ?>
                        <?php echo $data['tickets_sold'][$event['event_id']-1]['purchased'] ?>
                      <?php else: ?>
                        0
                      <?php endif; ?>
                    </small>
                  </div>
                </div>
                <div class="row">
                  <div class="col-2 text-center">
                    <small><?php echo date_format(date_create($event['date']),"d"); ?></small>
                  </div>
                  <div class="col">
                    <small><?php echo $event['city'].", ".$event['state'] ?></small>
                  </div>
                  <div class="col-1">
                    <?php if(!empty($data['tickets_sold'][$event['event_id']-1]) && $event['tickets'] == $data['tickets_sold'][$event['event_id']-1]['purchased']): ?>
                      <span class="badge badge-success">S</span>
                    <?php endif; ?>
                  </div>
                  <div class="col-2">

                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
  </section>
  <section>
    <div class="card text-center mt-3 mb-2">
      <div class="card-header text-white bg-secondary">Event notification</div>
      <div class="card-body">
        <h5 class="card-title">Send message to users interested in the event selected.</h5>
        <form action="" method="post" name="user" class="">
          <div class="dropdown form-group">
            <select name="event_id" class="custom-select">
              <option>Select event</option>
              <?php foreach ($data['events'] as $event): ?>
              <option value="<?php echo $event['event_id']?>">
                <?=$event['title']?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div id="display" class="collpase m-auto">
            <ul id="search-list" class="list-group list-group-flush text-left"></ul>
          </div>
          <select name="notify_id" class="custom-select">
              <option>Select notify</option>
              <?php foreach ($data['notifies'] as $notify): ?>
              <option value="<?php echo $notify['notify_id']?>">
                <?=$notify['text']?>
              </option>
              <?php endforeach; ?>
          </select>
          <input type="submit" class="btn btn-primary btn-block mt-2" name="submit" value="Send">
        </form>
      </div>
    </div>
  </section>
  <?php else: ?>
  <section class="mt-3">
    <h3>Any Event Created Yet</h3>
    <div class="row">
      <div class="col">
          <a class="btn btn-primary btn-block" href="<?php echo EVENT."create"?>" role="button">Create One</a>
      </div>
    </div>
  </section>
  <?php endif; ?>
</div>
