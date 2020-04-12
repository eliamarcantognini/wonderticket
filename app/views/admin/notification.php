<div class="container mt-2 py-4">

  <div class="card text-center">
    <div class="card-header text-white bg-primary">Broadcast notification</div>
  	<div class="card-body">
    	<h5 class="card-title">Send a broadcast notification</h5>
    	<form action="" method="post" name="broadcast" class="">
				<div>						
          <textarea class="form-control" id="broadcastTxtArea" name="text" rows="4"></textarea>
          <small for="broadcastTxtArea" class="pull-right pb-2" id="count_br"></small>
				</div>
        <input type="hidden" name="op" value="b"/>	
        <input type="submit" class="btn btn-secondary btn-block" name="submit" value="Send">
			</form>
    </div>
  </div>
  <div class="card text-center mt-3">
    <div class="card-header text-white bg-primary">User notification</div>
    <div class="card-body">
      <h5 class="card-title">Send a message to one user.</h5>
			<form action="" method="post" name="user" class="">
        <div class="dropdown form-group">
          <select name="user_id" class="custom-select">
            <option>Select user</option>
            <?php foreach ($data['users'] as $user): ?>
            <option value="<?php echo $user['user_id']?>">
              <?=$user['name']?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
				<div id="display" class="collpase m-auto">
					<ul id="search-list" class="list-group list-group-flush text-left"></ul>
				</div>
				<div>
					<textarea class="form-control mt-2" id="userTxtArea" name="text" rows="4"></textarea>
					<small for="userTxtArea" class="pull-right pb-2" id="count_us"></small>
				</div>
        <input type="hidden" name="op" value="u"/>	
        <input type="submit" class="btn btn-secondary btn-block" name="submit" value="Send">
      </form>
    </div>
  </div>


</div>