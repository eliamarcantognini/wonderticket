<div class="container pt-4 mb-4">
  <?php if(!empty($data['event']['title'])): ?>
      <h1 class="mb-4">Edit event</h1>
    <?php else: ?>
      <h1 class="mb-4">Create new event</h1>
    <?php endif;?>
  <?php if (!empty($data['error_msg'])): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $data['error_msg']?>
    </div>
  <?php endif; ?>
  <form action="<?php echo EVENT.$data['event']['event_id']?>" method="post" name="event_form" class="m-auto">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="sr-only" for="title">Title</label>
          <input type="title" class="form-control" placeholder="Title" id="title" name="title" value="<?php echo $data['event']['title'] ?>" aria-describedby="titleHelp" required="true">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="sr-only" for="artist">Artist</label>
          <input type="text" class="form-control" placeholder="Artist" id="artist" name="artist" value="<?php echo $data['event']['artist'] ?>" aria-describedby="artistHelp" required="true">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="dropdown form-group">
          <select name="venue_id" class="custom-select">
            <option>Select venue</option>
            <?php foreach ($data['venues'] as $venue): ?>
              <option <?php if($venue['id'] == $data['event']['venue_id']){ echo "selected='true'";} ?> value="<?php echo $venue['id']?>">
                <?=$venue['name']?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="dropdown form-group">
          <select name="category_id" class="custom-select">
            <option>Select category</option>
            <?php foreach ($data['categories'] as $category): ?>
              <option <?php if($category['id'] == $data['event']['category_id']){ echo "selected='true'";} ?> value="<?php echo $category['id']?>">
                <?=$category['name']?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 <?php if(!empty($data['event']['title'])) {echo "col-md-4";} else { echo "col-md-3";}?>">
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white"><i class="fa fa-calendar-o"></i></span>
          </div>
          <label class="sr-only" for="date">Date</label>
          <input type="date" class="form-control" id="date" name="date" value="<?php echo $data['event']['date'] ?>" aria-describedby="dateHelp" required="true">
        </div>
      </div>
      <div class="col-12 <?php if(!empty($data['event']['title'])){echo "col-md-4";} else { echo "col-md-3";} ?>">
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white"><i class="fa fa-clock-o"></i></span>
          </div>
          <label class="sr-only" for="time">Time</label>
          <input type="time" class="form-control" placeholder="Time" id="time" name="time" value="<?php echo $data['event']['time'] ?>" aria-describedby="timelHelp" required="true">
        </div>
      </div>
      <?php if(empty($data['event']['title'])): ?>
      <div class="col-6 col-md-3">
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white"><i class="fa fa-ticket"></i></span>
          </div>              
          <input type="number" class="form-control" min="1" id="seats" name="seats" value="1" aria-describedby="pricelHelp" required="true">
          <label class="sr-only" for="seats">Seats</label>
        </div>
      </div>
      <?php endif; ?>
      <div class="col-6 <?php if(!empty($data['event']['title'])){echo "col-md-4";} else { echo "col-md-3";}?>">
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white"><i class="fa fa-eur"></i></span>
          </div>              
          <input type="number" class="form-control" min="0" placeholder="Price" id="price" name="price" value="<?php echo $data['event']['price'] ?>" aria-describedby="pricelHelp" required="true">
          <label class="sr-only" for="price">Price</label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="sr-only" for="description">Description</label>
      <textarea class="form-control" placeholder="Insert a brief description" name="description" id="description"><?php echo $data['event']['description'] ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-block" id="eventBtn">
      <?php if(!empty($data['event']['title'])): ?>Edit<?php else: ?>Create<?php endif; ?>
    </button>
    <div class="text-center">
      <div class="spinner-border text-center text-primary d-none" id="spinner" role="status">
        <span class="sr-only">Loading...</span>
      </div> 
    </div>
    <?php if(!empty($data['event']['title'])): ?>
      <input name="_method" value="put" type="hidden"/>
    <?php endif; ?>
  </form>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#eventBtn').click(function(event) {
      $('#eventBtn').toggleClass("d-none");
      $("#spinner").toggleClass("d-none");
    });
  });
</script>