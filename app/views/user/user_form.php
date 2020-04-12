<div class="container pt-4 mb-4">

  <h2 class="mb-4">Change Password</h2>

  <?php if (!empty($data['error_msg'])): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $data['error_msg']?>
    </div>
  <?php endif; ?>

  <form action="pass" method="post" name="login_form" class="m-auto">
    <div class="form-row">
      <div class="form-group col-12">
        <label class="sr-only" for="password">Current password</label>
        <input type="password" class="form-control" placeholder="Current password" name="p" id="password">
      </div>
      <div class="form-group col-12">
        <label class="sr-only" for="password">New password</label>
        <input type="password" class="form-control" placeholder="New password" name="p_new" id="new_password">
      </div>
      <div class="form-group col-12">
        <label class="sr-only" for="password">Confirm new password</label>
        <input type="password" class="form-control" placeholder="Confirm new password" name="p_confirm" id="confirm_password" required="true">
      </div>
    </div>
    <input name="_method" value="put" type="hidden"/>
    <div class="row">
      <div class="col-6">
        <a class="btn btn-outline-secondary btn-block" href="<?php echo USER.$data['user']['user_id']?>" role="button">Cancel</a>
      </div>
      <div class="col-6 text-center">
        <button type="submit" class="btn btn-primary btn-block" id="changePassBtn" onclick="validateUserPasswordForm(this.form, this.form.password, this.form.new_password, this.form.confirm_password);">Submit</button>
        <div class="spinner-border text-center text-primary d-none" role="status" id="spinner">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
$(document).ready(function (){
  /*$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });*/
  loadSpinner($('#changePassBtn'));
  addPasswordListener(confirm_password, new_password);
});

</script>
