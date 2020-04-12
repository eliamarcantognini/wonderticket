<h2>Events</h2>
<p>Eventi raccomandati</p>
<div class="row">
  <?php foreach ($data['events'] as $event): ?>
  <div class="col-md-4">
    <div id="event-card" class="card mb-3">
      <img src="<?php echo IMAGE_PATH.$event['event_img']?>" class="card-img-top img-fluid max-width: 100%" alt="immagine di un concerto">
      <div class="card-body">
        <h5 class="card-title"><?php echo $event['title'] ?></h5>
        <small class="text-muted"><i class="fa fa-map-marker"></i> <?php echo $event['venue'];?></small>
        <p class="card-text"><?php echo $event['description'] ?></p>
      </div>
      <div class="card-footer d-flex justify-content-between align-items-center <?php if($event['cancelled']) {echo "bg-danger";} ?>">
        <small class="<?php if($event['cancelled']) {echo "text-white";} else {echo "text-muted";} ?>"><i class="fa fa-calendar-o"></i> <?php echo date_format(date_create($event['date']),"D, F d");?></small>
        <a href="<?php echo EVENT.$event['event_id']?>" class="btn btn-sm <?php if($event['cancelled']) {echo "btn-outline-light";} else {echo "btn-outline-secondary";} ?>">View</a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
