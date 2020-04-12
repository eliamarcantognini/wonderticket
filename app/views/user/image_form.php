<section class="container mt-3">
  <h2 class="mb-4">Change Profile Image</h2>
  <div class="row m-auto">
    <div class="col-12 col-md-6 mb-3 text-center">
      <img src="<?php echo IMAGE_PATH.$data['user']['user_img'] ?>" alt=" " class="rounded-circle img-responsive thumbnail shadow border border-dark" width=130px height=130px>
    </div>
    <div class="col align-self-center">
      <div class="row">
        <form action="<?php echo USER."img" ?>" method="post" name="user_form" class="w-100" enctype="multipart/form-data">
          <input name="_method" value="put" type="hidden"/>
          <div class="input-group input-group-sm col-md align-self-center">
            <div class="input-group-prepend">
              <button class="btn btn-outline-secondary" type="submit" value="img" name="upload">Change</button>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="image"/>
              <label class="custom-file-label">Choose Image</label>
            </div>
          </div>
        </form>
      </div>
      <div class="row m-auto">
        <a class="btn btn-outline-secondary btn-block mt-3" href="<?php echo USER.$data['user']['user_id']?>" role="button">Cancel</a>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function(e) {
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
  });
</script>
