<div class="container mt-3">
  <?php if(!empty($data['event_orders'])): ?>
    <h3>Your Orders (<?php echo count($data['event_orders']) ?>)</h3>
    <div class="list-group">
      <div class="row">
        <?php foreach ($data['event_orders'] as $event): ?>

          <div class="col-md-6">
              <a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action mb-2">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo $event['title'] ?></h5>
                    <small><?php echo date_format(date_create($event['date']),"D, F d");?></small>
                  </div>
                  <div class="d-flex w-100 justify-content-between">
                    <small class="badge"><?php echo "Purchased on:"." ".date_format(date_create($event['purchase_date']),"D, F d");?></small>
                    <small class="badge badge-pill"><?php echo "Price:"." ".$event['price'];?></small>
                  </div>
              </a>
          </div>

        <?php endforeach; ?>
      </div>
    </div>
  <?php else: ?>
    <section>
      <h3>Any Order Made Yet</h3>
      <div class="row">
        <div class="col">
            <a class="btn btn-primary btn-block" href="<?php echo HOME?>" role="button">See Events</a>
        </div>
      </div>
    </section>
  <?php endif; ?>
</div>
