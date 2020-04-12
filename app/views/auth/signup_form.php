<div class="container mt-2 pt-4 mb-3">

  <?php if (!empty($data['error_msg'])): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $data['error_msg']?>
    </div>
  <?php endif; ?>

  <form action="" method="post" name="signup_form" class="m-auto">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="sr-only" for="name">Name</label>
        <input type="text" class="form-control" placeholder="Name" name="name" id="name" required="true">
      </div>
      <div class="form-group col-md-6">
        <label class="sr-only" for="surname">Surname</label>
        <input type="text" class="form-control" placeholder="Surname" name="surname" id="surname">
      </div>
    </div>
    <div class="form-group">
      <label class="sr-only" for="email">Email</label>
      <input type="email" class="form-control" id="email" placeholder="Email" name="email" aria-describedby="emailHelp" required="true">
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="sr-only" for="password">Password</label>
        <input type="password" class="form-control" placeholder="Password" name="p" id="password">
      </div>
      <div class="form-group col-md-6">
        <label class="sr-only" for="password">Confirm password</label>
        <input type="password" class="form-control" placeholder="Confirm password" name="p_confirm" id="p_confirm" required="true">
      </div>
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" name="sellerCheckBox" id="sellerCheckBox">
      <label class="form-check-label" for="sellerCheckBox">I'm a seller</label>
    </div>
    <div id="seller-form" class="form-row">
      <div class="form-group col-md-6">
        <label class="sr-only" for="iva">IVA</label>
        <input type="text" class="form-control" placeholder="IVA" maxlength="11" minlength="9" name="iva" id="iva">
      </div>
      <div class="form-group col-md-6">
        <label class="sr-only" for="company">Company's name</label>
        <input type="text" class="form-control" placeholder="Company's name" name="company" id="company">
      </div>
    </div>
    <button id="signupBtn" type="submit" class="btn btn-secondary btn-block" onclick="validateSignupForm(this.form, this.form.password, this.form.p_confirm);">Signup</button>
    <div class="text-center">
      <div class="spinner-border text-center text-primary d-none" role="status" id="spinner">
        <span class="sr-only">Loading...</span>
      </div> 
    </div>
  </form>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    const sellerForm = $('#seller-form');
    sellerForm.hide();
    $('.form-check input').click(function() { 
        this.checked ? $(sellerForm).fadeIn() : sellerForm.hide();
    });
    loadSpinner($("#signupBtn"));
    addPasswordListener(p_confirm, password);
  });
</script>