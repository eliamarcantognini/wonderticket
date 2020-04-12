<div class="container mt-3">
  <h3>Interested Events</h3>
  <div class="list-group">
    <div class="row">
      <?php foreach ($data['events_inbound'] as $event): ?>

        <div class="col-md-9 col-12 mb-md-2">
            <a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action">
                <div class="text-justify">
                  <strong><?php echo $event['title'] ?></strong>
                  <small class="pull-right"><?php echo date_format(date_create($event['date']),"D, F d");?></small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-12 mt-md-3 mb-3">
          <button type="button" class="btn btn-outline-danger mb-0 btn-block" data-toggle="modal" data-target="#eventModal<?php echo $event['event_id']?>">Remove Alert</button>
        </div>
        <div class="modal fade" id="eventModal<?php echo $event['event_id']?>" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Removing...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Confirm <?php echo $event['title']?> ?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="" method="post" name="alert_rem" class="m-auto">
                  <input type="hidden" name="event_id" value="<?php echo $event["event_id"]?>"/>
                  <input type="submit" class="btn btn-secondary" value="Confirm" name="submit"/>
                </form>
              </div>
            </div>
          </div>
        </div>

      <?php endforeach; ?>
    </div>
  </div>
</div>
