<section class="container">
  <div class="list-group mt-4 ">
    <?php foreach ($data['users'] as $user): ?>
      <div class="row align-items-center mb-3">
        <div class="col-md-5 ">
          <a href="<?php echo USER.$user['user_id']?>" class="list-group-item d-flex list-group-item-action ">
            <div class="d-flex w-100 justify-content-between align-items-center">
              <p class="mb-1"><?php echo $user['name'] ?></p>
              <p class="mb-1"><?php echo $user['surname'] ?></p>
            </div>
          </a>
        </div>
        <div class="col-md-5">
          <a href="<?php echo USER.$user['user_id']?>" class="list-group-item d-flex list-group-item-action ">
            <div class="d-flex w-100 justify-content-between align-items-center">
              <p class="mb-1"><?php echo $user['email'] ?></p>
              <span class="badge badge-secondary badge-pill"><?php echo strtoupper($user['privilege'][0]);?></span>
            </div>
          </a>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#userModal<?php echo $user['user_id']?>">
            Disable
          </button>
        </div>
          <div class="modal fade" id="userModal<?php echo $user['user_id']?>" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="userModalLabel">Disabling...</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Disable <?php echo $user['name'] . " " . $user['surname']?> ?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <form action="" method="post" name="user_appr" class="m-auto">
                    <input type="hidden" name="user_id" value="<?php echo $user["user_id"]?>"/> 
                    <input type="submit" class="btn btn-danger" value="Confirm" name="submit"/>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>