<div class="container mt-2 pt-4">

  <?php if (!empty($data['error_msg'])): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $data['error_msg']?>
    </div>
  <?php endif; ?>

  <form action="" method="post" name="login_form" class="m-auto">
    <div class="form-group">
      <label class="sr-only" for="email">Email</label>
      <input type="email" class="form-control" placeholder="Email" id="email" name="email" aria-describedby="emailHelp" required="true">
    </div>
    <div class="form-group">
      <label class="sr-only" for="password">Password</label>
      <input type="password" class="form-control" placeholder="Password" name="p" id="password">
    </div>
    <button type="submit" class="btn btn-secondary btn-block" id="loginBtn" onclick="validateLoginForm(this.form, this.form.password);">Login</button>
    <div class="text-center">
      <div class="spinner-border text-center text-primary d-none" id="spinner" role="status">
        <span class="sr-only">Loading...</span>
      </div> 
    </div>
    <small id="register" class="text-center form-text text-muted">New customer? <a href="<?php echo SIGNUP ?>">Start here</a>.</small>
  </form>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    loadSpinner($("#loginBtn"));
  });
</script>