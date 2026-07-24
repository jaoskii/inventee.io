<?php
use yii\helpers\Url;
?>

<form id="bookroomnow" action="<?php echo Url::to(['/frontend/bookingsetup']); ?>" method="post">
<input type="hidden" name="keyid" value="<?php echo $this->params['keyid'];?>">
<div class="container book-form mb30" style="background-color: #6C727F; border:2px solid;">
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-md-2">
					<label class="reserveform-labels">Check-IN Date</label>
					<input id="datepicker-example1" name="checkin" type="text" class="form-control" value="<?php if(isset($this->params['startdate'])){ echo $this->params['startdate'];}else{ echo date('Y-m-d');}?>">
				</div>

				<div class="col-md-2">
					<label class="reserveform-labels">Check-OUT Date</label>
					<input id="datepicker-example2" name="checkout" type="text" class="form-control" value="<?php if(isset($this->params['enddate'])){ echo $this->params['enddate'];}else{ echo date('Y-m-d');}?>">
				</div>

				<div class="col-md-2">
					<label class="reserveform-labels"># of Rooms</label>
					<div class="input-group">
					<span class="input-group-btn">
		              	<button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="numrooms">
		                	<span class="glyphicon glyphicon-minus"></span>
		              	</button>
		          	</span>
	          		
	          		<input type="text" name="numrooms" class="form-control input-number" value="<?php if(isset($this->params['roomqty'])){ echo $this->params['roomqty'];}else{ echo 1;}?>" min="1" max="100" readonly>
	          		
	          		<span class="input-group-btn">
	              	<button type="button" class="btn btn-success btn-number" data-type="plus" data-field="numrooms">
	                  	<span class="glyphicon glyphicon-plus"></span>
	              	</button>
	          		</span>
	          		</div>
				</div>

				<div class="col-md-2">
					<label class="reserveform-labels">Adults</label>
					<div class="input-group">
					<span class="input-group-btn">
		              	<button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="adults">
		                	<span class="glyphicon glyphicon-minus"></span>
		              	</button>
		          	</span>
	          		
	          		<input type="text" name="adults" class="form-control input-number" value="<?php if(isset($this->params['adults'])){ echo $this->params['adults'];}else{ echo 1;}?>" min="1" max="100" readonly>
	          		
	          		<span class="input-group-btn">
	              	<button type="button" class="btn btn-success btn-number" data-type="plus" data-field="adults">
	                  	<span class="glyphicon glyphicon-plus"></span>
	              	</button>
	          		</span>
	          		</div>
				</div>

				<div class="col-md-2">
					<label class="reserveform-labels">Children</label>
					<div class="input-group">
					<span class="input-group-btn">
			              <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="children">
			                <span class="glyphicon glyphicon-minus"></span>
			              </button>
			        </span>
			        <input type="text" name="children" class="form-control input-number" value="<?php if(isset($this->params['children'])){ echo $this->params['children'];}else{ echo 1;}?>" min="1" max="100" readonly>
			        <span class="input-group-btn">
		              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="children">
		                  <span class="glyphicon glyphicon-plus"></span>
		              </button>
			        </span>
	          		</div>
				</div>

				<div class="col-md-2">
					<button style="border:solid 2px;margin-top: 20px;" class="btn btn-primary" id="submit" type="submit">Refresh Booking Info</button>
					<!-- <input style="border:solid 2px; width: 300px;text-align:center;" id="submit" type="submit" value="Refresh Room Booking Details"> -->
				</div>

		    
	        </div>
	    	</div>
</form>