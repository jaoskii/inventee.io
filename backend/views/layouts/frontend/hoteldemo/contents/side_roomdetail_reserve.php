<?php
use yii\helpers\Url;
?>

	<h3>Book Schedule for this room</h3>
	<div class="side-form mb20">
	<form id="bookroomnow" action="<?php echo Url::to(['/frontend/bookingsetup']); ?>" method="post">
			<input type="hidden" name="keyid" value="<?php echo $this->params['keyid'];?>">

			<label class="reserveform-labels">Checkin Date</label>
			<input name = "checkin" id="datepicker-example1" type="text" value="<?php echo date('Y-m-d');?>">

			<label class="reserveform-labels">Checkout Date</label>
			<input name="checkout" id="datepicker-example2" type="text" value="<?php echo date('Y-m-d');?>">

			<label class="reserveform-labels"># of Rooms</label>
			<div class="input-group">
	          <span class="input-group-btn">
	              <button type="button" style="margin-top:15px;" class="btn btn-danger btn-number"  data-type="minus" data-field="numrooms">
	                <span class="glyphicon glyphicon-minus"></span>
	              </button>
	          </span>
	          <input type="text" name="numrooms" class="form-control input-number" value="1" min="1" max="100" style="width:100%;" readonly>
	          <span class="input-group-btn">
	              <button type="button" style="margin-top:15px;" class="btn btn-success btn-number" data-type="plus" data-field="numrooms">
	                  <span class="glyphicon glyphicon-plus"></span>
	              </button>
	          </span>
	      	</div>

			<label class="reserveform-labels">Enter # of Adults</label>
			<div class="input-group">
	          <span class="input-group-btn">
	              <button type="button" style="margin-top:15px;" class="btn btn-danger btn-number"  data-type="minus" data-field="adults">
	                <span class="glyphicon glyphicon-minus"></span>
	              </button>
	          </span>
	          <input type="text" name="adults" class="form-control input-number" value="1" min="1" max="100" style="width:100%;" readonly>
	          <span class="input-group-btn">
	              <button type="button" style="margin-top:15px;" class="btn btn-success btn-number" data-type="plus" data-field="adults">
	                  <span class="glyphicon glyphicon-plus"></span>
	              </button>
	          </span>
	      	</div>

	      	<label class="reserveform-labels">Enter # of Children</label>
			<div class="input-group">
	          <span class="input-group-btn">
	              <button type="button" style="margin-top:15px;" class="btn btn-danger btn-number"  data-type="minus" data-field="children">
	                <span class="glyphicon glyphicon-minus"></span>
	              </button>
	          </span>
	          <input type="text" name="children" class="form-control input-number" value="1" min="1" max="100" style="width:100%;" readonly>
	          <span class="input-group-btn">
	              <button type="button" style="margin-top:15px;" class="btn btn-success btn-number" data-type="plus" data-field="children">
	                  <span class="glyphicon glyphicon-plus"></span>
	              </button>
	          </span>
	      	</div>

			<button style="border:solid 2px;margin-top: 20px;width:100%;" class="btn btn-primary" id="submit" type="submit">Refresh Booking Info</button>
	</form>
	</div>