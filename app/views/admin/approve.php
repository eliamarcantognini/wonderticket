<div class="container mt-4">
  <section class="mb-5">
		<div class="card text-center">    
      <div class="card-header text-black bg-secondary">Events to be approved</div>
        <div class="card-body">
    			<div class="list-group">
        		<?php foreach ($data['disabled_events'] as $event): ?>
            	<div class="row align-items-center mb-3">
                <div class="col-md-4 ">
              	  <a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1"><?php echo $event['title'] ?></h5>
                	    <small><?php echo date_format(date_create($event['date']),"D, F d");?></small>
                    </div>
               		</a>
                </div>
                <div class="col-md-4 ">
               	  <a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                      <p class="mb-1"><?php echo substr($event['description'], 0, 20). "..."?></p>
                      <small><?php echo $event['city'];?></small>
                    </div>
                	</a>
                </div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-primary mb-0 btn-block" data-toggle="modal" data-target="#eventModal<?php echo $event['event_id']?>">
                    Enable event
                  </button>
                </div>
                <div class="modal fade" id="eventModal<?php echo $event['event_id']?>" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Approving...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Confirm <?php echo $event['title']?> ?
                      </div>
                      <div class="modal-footer">
                	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="" method="post" name="event_appr" class="m-auto">
                          <input type="hidden" name="event_id" value="<?php echo $event["event_id"]?>"/> 
                          <input type="submit" class="btn btn-secondary" value="Confirm" name="submit"/>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          <?php endforeach; ?>
 		    </div>
      </div>
  	</div>
  </section>

  <section>
    <div class="card text-center mb-3">    
      <div class="card-header text-black bg-secondary">Users to be approved</div>
        <div class="card-body">
        <div class="list-group">
          <?php foreach ($data['disabled_users'] as $user): ?>
            <div class="row align-items-center mb-3">
              <div class="col-md-4 ">
                <a href="<?php echo USER.$user['user_id']?>" class="list-group-item d-flex list-group-item-action ">
                  <div class="d-flex w-100 justify-content-between align-items-center">
                    <p class="mb-1"><?php echo $user['name'] ?></p>
                    <p class="mb-1"><?php echo $user['surname'] ?></p>
                  </div>
                </a>
              </div>
              <div class="col-md-4 ">
                <a href="<?php echo USER.$user['user_id']?>" class="list-group-item d-flex list-group-item-action ">
                  <div class="d-flex w-100 justify-content-between align-items-center">
                    <p class="mb-1"><?php echo $user['email'] ?></p>
                    <span class="badge badge-primary badge-pill"><?php echo strtoupper($user['privilege'][0]);?></span>
                  </div>
                </a>
              </div>
              <div class="col-md-4 ">
                <button type="button" class="btn btn-primary mb-0 btn-block" data-toggle="modal" data-target="#exampleModal<?php echo $user['user_id']?>">
                  Enable user
                </button>
              </div>
              <div class="modal fade" id="exampleModal<?php echo $user['user_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Approving...</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Confirm <?php echo $user['name'] . " " . $user['surname']?> ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <form action="" method="post" name="user_appr" class="m-auto">
                        <input type="hidden" name="user_id" value="<?php echo $user["user_id"]?>"/> 
                        <input type="submit" class="btn btn-secondary" value="Confirm" name="submit"/>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
</div>