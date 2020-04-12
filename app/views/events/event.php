<div class="carousel mb-3 text-center" data-ride="carousel">
  <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="carousel-vignette">
          <img src="<?php echo IMAGE_PATH.$data['event']['event_img'];?>" class="w-100 carouselImg" alt="Event Image">
        </div>
        <div class="carousel-caption">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h3 class="pb-0 mb-0"><?php echo $data['event']['title'] ?></h1>
              </div>
              <div class="col-12">
                <p class="pb-1 mb-0"> <?php echo $data['event']['artist']; ?></p>
              </div>
            </div>
            <div class="row">
              <?php if ($data['event']['price']!=="nd"): ?>
                <div class="col-6 col-sm-12">
                  <p class="card-text"><i class="fa fa-dollar"></i> <?php echo $data['event']['price']; ?></p>
                </div>
                <div class="col-6 col-sm-4">
                  <p class="card-text"><i class="fa fa-clock-o"></i> <?php echo date('H:i',strtotime($data['event']['time'])) ?></p>
                </div>
              <?php else: ?>
                <div class="col-12 col-sm-4">
                  <p class="card-text"><i class="fa fa-clock-o"></i> <?php echo date('H:i',strtotime($data['event']['time'])) ?></p>
                </div>
              <?php endif; ?>
              <div class="col-12 col-sm-4">
                <p class="card-text"><i class="fa fa-calendar-o"></i> <?php echo date_format(date_create($data['event']['date']),"D, F d");?></p>
              </div>
              <div class="col-12 col-sm-4">
                <p class="card-text"><i class="fa fa-map-marker"></i> <?php echo $data['event']['venue'];?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="container">
<?php if($data['event']['cancelled']): ?>
<div class="alert alert-danger" role="alert">
  The event has been cancelled!
</div>
<?php else: ?>
<div class='row mb-3'>
  <div class="text-center col-4">
    <h5 class="font-weight-bold"><?php echo $data['event']['available'] ?></h5>
    <p>Available</p>
  </div>
  <div class="text-center col-4">
    <h5 class="font-weight-bold"><?php echo $data['event']['purchased'] ?></h5>
    <p>Purchased</p>
  </div>
  <div class="text-center col-4">
    <h5 class="font-weight-bold"><?php echo $data['event']['interested'] ?></h5>
    <p>Interested</p>
  </div>
</div>
<div class='row'>
  <div class="col-md-6 mb-2">
    <?php if($data['isowner']): ?>
    <form action="<?php echo $data['event']['event_id']."/edit"?>" method="get">
      <button type="submit" class="btn btn-outline-secondary btn-block" id="modifyBtn">Modify</button>
    </form>
    <?php elseif ((isset($_SESSION['privilege']))&&($_SESSION['privilege']==='customer')&&($data['event']['price']!=="nd")): ?>
    <div class="text-center">
      <div class="spinner-border text-center text-primary d-none" id="spinner2" role="status">
        <span class="sr-only">Loading...</span>
      </div> 
    </div>
    <button type="submit" href="<?php echo CART ?>" event_id="<?php echo $data['event']['event_id']; ?>" class="btn btn-secondary btn-block" id="addCartBtn">Add to cart</button>
    <?php endif; ?>
  </div>
  <div class="col-md-6">
    <?php if($data['isowner']): ?>
      <form action="" method="post">
      <input name="_method" value="delete" type="hidden"/>
      <button type="submit mb-2" class="btn btn-primary btn-block" id="cancelBtn" onclick="">Cancel</button>
      </form>
    <?php elseif ((isset($_SESSION['privilege']))&&($_SESSION['privilege'] === 'customer')&&($data['event']['price']!=="nd")): ?>
      <div class="text-center">
        <div class="spinner-border text-center text-primary d-none" id="spinner" role="status">
          <span class="sr-only">Loading...</span>
        </div> 
      </div>
      <button type="submit" href="<?php echo EVENT.$data['event']['event_id'].'/alert'?>" class="btn btn-outline-danger btn-block <?php if(!$data['is_interested']) { echo "d-none"; } ?>" id="removeAlert">Remove ticket alerts</button>
      <button type="submit" href="<?php echo EVENT.$data['event']['event_id'].'/alert'?>" class="btn btn-primary btn-block mt-0 <?php if($data['is_interested']) { echo "d-none"; } ?>" id="addAlert">Receive ticket alerts</button>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>
<div class="mt-4 pb-2">
  <h4>Event's informations</h4>
  <p><?php echo $data['event']['description'];?></p>
</div>
</section>

