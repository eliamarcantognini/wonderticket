<div id="carouselExampleCaptions" class="carousel slide fluid parent-div" data-ride="carousel">

  <ol class="carousel-indicators mb-1">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <?php $first=reset($data['events']); ?>
    <?php foreach($data['events'] as $event): ?>
      <?php if($event == $first): ?>
        <div class="carousel-item active">
          <div class="carousel-vignette">
            <img src="<?php echo IMAGE_PATH.$event['event_img']; ?>" class="d-block w-100 carouselImg" alt="Event Image">
          </div>
          <div class="carousel-caption pb-1 d-none d-md-block">
            <h5 class="mb-1"><?php echo $event['title']; ?></h5>
            <p class="mb-0"><?php echo $event['description']; ?></p>
          </div>
        </div>
      <div class="carousel-content">
        <div class="container carousel-home">
          <h1 class="py-3 mb-2 hidden-md">Enjoy the live!</h1>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-white"><i class="fa fa-search"></i></span>
            </div>
            <input type="text" id="search" class="form-control border-left-0 pl-2 pr-2" placeholder="Search events" aria-label="Search events">
          </div>
          <div id="display" class="collpase m-auto">
            <ul id="search-list" class="list-group list-group-flush text-left"></ul>
          </div>
        </div>
      </div>
      <?php else: ?>
        <div class="carousel-item">
          <div class="carousel-vignette">
            <img src="<?php echo IMAGE_PATH.$event['event_img']; ?>" class="d-block w-100 carouselImg" alt="Event Image">
          </div>
            <div class="carousel-caption pb-1 d-none d-md-block">
            <h5 class="mb-1"><?php echo $event['title']; ?></h5>
            <p class="mb-0"><?php echo $event['description']; ?></p>
          </div>
        </div>
      <?php endif; ?>
      <?php endforeach ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<section class="container mt-3">
  <div class="row mb-4">
  <div class="col-md-4 mb-2 mb-md-0">
      <div class="card">
          <a id="categoryBtn" href="" class="card-body py-2 px-3 list-group-item-action">
            <div class="row">
              <div class='col-2 m-auto'>
                <h5><i class="fa fa-tag"></i></h5>
              </div>
              <div class='col-8'>
                <h5 class="m-0">Category</h5>
                <small id="selectedCategory">Any</small>
              </div>
              <div class='col-2'>
                <h5><i class="fa fa-angle-down"></i></h5>
              </div>
            </div>
          </a>
          <div id="displayCategories" class="collapse">
            <ul id="categoryList" class="list-group list-group-flush text-left">
              <?php foreach($data['categories'] as $category): ?>
                <a href=""  class="list-group-item list-group-item-action" categoryId="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></a>
              <?php endforeach; ?>
              <a href="" class="list-group-item list-group-item-action" categoryId="undefined">Any</a>
            </ul>
          </div>
      </div>
    </div>

    <div class="col-md-4 mb-2 mb-md-0">
      <div class="card">
          <a id="periodBtn" href="" class="card-body py-2 px-3 list-group-item-action">
            <div class="row">
              <div class='col-2 m-auto'>
                <h5><i class="fa fa-calendar-o"></i></h5>
              </div>
              <div class='col-8'>
              <h5 class="m-0">Period</h5>
                <small id="selectedPeriod">Anytime</small>
              </div>
              <div class='col-2'>
                <h5><i class="fa fa-angle-down"></i></h5>
              </div>
            </div>
          </a>
          <div id="displayPeriod" class="collapse">
            <ul id="periodList" class="list-group list-group-flush text-left">
              <a href="" class="list-group-item list-group-item-action" periodId="0">Today</a>
              <a href="" class="list-group-item list-group-item-action" periodId="1">Tomorrow</a>
              <a href="" class="list-group-item list-group-item-action" periodId="2">This week</a>
              <a href="" class="list-group-item list-group-item-action" periodId="3">Next week</a>
              <a href="" class="list-group-item list-group-item-action" periodId="4">This month</a>
              <a href="" class="list-group-item list-group-item-action" periodId="undefined">Anytime</a>
            </ul>
          </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
          <a id="venueBtn" href="" class="card-body py-2 px-3 list-group-item-action">
            <div class="row">
              <div class='col-2 m-auto'>
                <h5><i class="fa fa-map-marker"></i></h5>
              </div>
              <div class='col-8'>
                <h5 class="m-0">Venue</h5>
                <small id="selectedVenue">Any</small>
              </div>
              <div class='col-2'>
                <h5><i class="fa fa-angle-down"></i></h5>
              </div>
            </div>
          </a>
          <div id="displayVenues" class="collapse">
            <ul id="venuesList" class="list-group list-group-flush text-left">
              <?php foreach($data['venues'] as $venue): ?>
                <a href="" class="list-group-item list-group-item-action" venueId="<?php echo $venue['id'] ?>"><?php echo $venue['name'] ?></a>
              <?php endforeach; ?>
              <a href="" class="list-group-item list-group-item-action" venueId="undefined">Any</a>
            </ul>
          </div>
      </div>
    </div>
  </div>
  <div id="events-container">
    <h2>Events</h2>
    <p>Highlighted events</p>
    <div class="row">
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
       
      </ul>
    </nav>
  </div>
</section>