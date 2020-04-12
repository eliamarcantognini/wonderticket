<div class="container mb-4 mt-5">
  <div class="card">
    <div class="card-header bg-secondary">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i><span> Shopping Cart</span>
    </div>
    <div class="card-body p-4">
      <?php if (!(empty($data['tickets']))): ?>
        <?php foreach($data['tickets'] as $ticket): ?>
        <div class="ticketInCart">
          <div class="row  align-items-center">
            <div class="col-12 col-sm-8">
              <h5 class="card-title mb-0"><?php echo $ticket['title'] ?></h5>
            </div>
            <div class="col-8 col-sm-2">Price: <span class='price'><?php echo $ticket['price'] ?></span>€</div>
            <div class="col-4 col-sm-2 text-right">
              <button href='<?php echo CART."/".$ticket['ticket_id'] ?>' type="button" class="btn btn-outline-danger removeTicketBtn">
                <i class="fa fa-trash"> </i>
              </button>
            </div>
          </div>
          <div class="row mt-2 align-items-center">
            <div class="col-6 col-sm-3 col-lg-2"> 
              <small class="card-text"><i class="fa fa-map-marker"></i> <?php echo $ticket['place'];?></small>
            </div>
            <div class="col-6 col-sm-9 col-lg-10">
              <small class="card-text"><i class="fa fa-calendar-o"></i> <?php echo date_format(date_create($ticket['date']),"D, F d");?></small>
            </div>
            <!--<div class="col-4 col-sm-4 col-lg-6 text-right"> 
              <p class="card-text text-muted"><#?php echo $ticket['available'] ? "available" : "not available" ?></p>
            </div>-->
          </div>
        </div>
        <?php endforeach; ?>
        <?php endif ?>
    </div>
    <?php if (!(empty($data['tickets']))): ?>
      <div class="card-footer text-muted">
        <div class="row text-right">
          <div class="col-12">
            <text>Taxable <strong id="taxable"></strong> </text>
          </div>
          <div class="col-12">
            <text>VAT 22% <strong id="vat"></strong> </text>
          </div>
          <div class="col-12">
            <text>Total price <strong id="total"></strong> </text>
          </div>
          <div class="col-12 mt-3">
            <form action="" method="POST">
              <input type="submit" value="Checkout" class="btn btn-outline-primary"/>
              <input name="_method" value="put" type="hidden"/>
            </form>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>