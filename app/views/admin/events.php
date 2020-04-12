<div class="container pt-3 pb-3 mt-4">
	<section class="mb-5">
	<div class="card text-center">
        
		<div class="card-body">
			<div class="list-group">
				<div class="row">
					<?php foreach ($data['going_events'] as $event): ?>

						<div class="col-md-6">
							<a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action">
								<div class="d-flex w-100 justify-content-between">
									<h5 class="mb-1"><?php echo $event['title'] ?></h5>
									<small><?php echo date_format(date_create($event['date']),"D, F d");?></small>
								</div>
								<div class="d-flex w-100 justify-content-between">
									<p class="mb-1"><?php echo substr($event['description'], 0, 20). "..."?></p>
									<small><?php echo $event['city'];?></small>
								</div>
							</a>
							<button type="button" class="btn btn-danger col-md-12 mb-2" data-toggle="modal" data-target="#eventDisableModal<?php echo $event['event_id']?>">
								Disable
							</button>
							<div class="modal fade" id="eventDisableModal<?php echo $event['event_id']?>" tabindex="-1" role="dialog" aria-labelledby="eventDisableModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="eventDisableModalLabel"> Disabling... </h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											Disable <?php echo $event['title']?> ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
											<form action="" method="post" name="event_dis" class="m-auto">
												<input type="hidden" name="op" value="d"/>
												<input type="hidden" name="event_id" value="<?php echo $event["event_id"]?>"/>
												<input type="submit" class="btn btn-danger" value="Confirm" name="submit"/>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="row justify-content-end mt-0">
				<h5><span class="badge badge-primary badge-pill mr-3"> Events available </span></h5>
			</div>
		</div>
		</div>
	</section>


	<section class="mb-5">
		<div class="card text-center">
        
		<div class="card-body">
			<div class="list-group">
				<div class="row">
					<?php foreach ($data['disabled_events'] as $event): ?>

						<div class="col-md-6">
							<a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action">
								<div class="d-flex w-100 justify-content-between">
									<h5 class="mb-1"><?php echo $event['title'] ?></h5>
									<small><?php echo date_format(date_create($event['date']),"D, F d");?></small>
								</div>
								<div class="d-flex w-100 justify-content-between">
									<p class="mb-1"><?php echo substr($event['description'], 0, 20). "..."?></p>
									<small><?php echo $event['city'];?></small>
								</div>
							</a>
							<button type="button" class="btn btn-secondary col-md-12 mb-2" data-toggle="modal" data-target="#eventEnableModal<?php echo $event['event_id']?>">
								Enable
							</button>
							<div class="modal fade" id="eventEnableModal<?php echo $event['event_id']?>" tabindex="-1" role="dialog" aria-labelledby="eventEnableModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="eventEnableModalLabel">Enabling...</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											Enable <?php echo $event['title']?> ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
											<form action="" method="post" name="event_ena" class="m-auto">
												<input type="hidden" name="op" value="e"/>
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
			<div class="row justify-content-end mt-0">
				<h5><span class="badge badge-primary badge-pill mr-3"> Events disabled </span></h5>
			</div>
		</div>
		</div>
	</section>
	<section>
	<div class="card text-center">  
		<div class="card-body">
			<div class="list-group">
				<div class="row">
				<?php foreach ($data['cancelled_events'] as $event): ?>
					<div class="col-md-6 mb-2">
					<a href="<?php echo EVENT.$event['event_id']?>" class="list-group-item list-group-item-action">
					<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1"><?php echo $event['title'] ?></h5>
					<small><?php echo date_format(date_create($event['date']),"D, F d");?></small>
					</div>
					<div class="d-flex w-100 justify-content-between">
					<p class="mb-1"><?php echo substr($event['description'], 0, 20). "..."?></p>
					<small><?php echo $event['city'];?></small>
					</div>
					</a>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="row justify-content-end mt-0">
				<h5><span class="badge badge-primary badge-pill mr-3"> Events cancelled </span></h5>
			</div>
		</div>
		</div>
	</section>
</div>