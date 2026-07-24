<?php
$this->title = 'Book a room!';
use yii\helpers\Url;
?>

<div class="contact-row column9">
		<div class="paragraph">
			<h4>These are the available</h4>
			<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a </p>
		</div>

		<div class="paragraph">
			<h4>Currently Available Rooms!</h4>
			<p></p>
		</div>
		<div class="dark">
		<div class="accomodation3-content">
		<div class="latest mb30"><div class="dark">
			<div class="column5 box">
				<div class="box-img">
					<a href="/ultimatesource/frontend/roomdetails?q=c81e728d9d4c2f636f067f89cc14862c">
					<img src="http://placehold.it/370x240" alt="">
					</a>
					<a href="/ultimatesource/frontend/bookit?q=c81e728d9d4c2f636f067f89cc14862c" class="details">Book Now!</a>
				</div>
				<a href="/ultimatesource/frontend/roomdetails?q=c81e728d9d4c2f636f067f89cc14862c"><h4>BATCAVE</h4></a>
				<p>ggg </p>
				<ul>
					<li>Quality Linens</li>
					<li>Individual Thermostat Control</li>
					<li>Fireplace and jetted tubs</li>
				</ul>
			</div>

			<div class="column5 box">
				<div class="box-img">
					<a href="/ultimatesource/frontend/roomdetails?q=eccbc87e4b5ce2fe28308fd9f2a7baf3">
					<img src="http://placehold.it/370x240" alt="">
					</a>
					<a href="/ultimatesource/frontend/bookit?q=eccbc87e4b5ce2fe28308fd9f2a7baf3" class="details">Book Now!</a>
				</div>
				<a href="/ultimatesource/frontend/roomdetails?q=eccbc87e4b5ce2fe28308fd9f2a7baf3"><h4>BUTCAVE</h4></a>
				<p>&nbsp</p>
				<ul>
					<li>Quality Linens</li>
					<li>Individual Thermostat Control</li>
					<li>Fireplace and jetted tubs</li>
				</ul>
			</div>
	<div class="clear"></div>
	</div>
		</div>	

		<div class="latest mb30"><div class="dark">
			<div class="column5 box">
				<div class="box-img">
					<a href="/ultimatesource/frontend/roomdetails?q=c81e728d9d4c2f636f067f89cc14862c">
					<img src="http://placehold.it/370x240" alt="">
					</a>
					<a href="/ultimatesource/frontend/bookit?q=c81e728d9d4c2f636f067f89cc14862c" class="details">Book Now!</a>
				</div>
				<a href="/ultimatesource/frontend/roomdetails?q=c81e728d9d4c2f636f067f89cc14862c"><h4>BATCAVE</h4></a>
				<p>ggg </p>
				<ul>
					<li>Quality Linens</li>
					<li>Individual Thermostat Control</li>
					<li>Fireplace and jetted tubs</li>
				</ul>
			</div>

			<div class="column5 box">
				<div class="box-img">
					<a href="/ultimatesource/frontend/roomdetails?q=eccbc87e4b5ce2fe28308fd9f2a7baf3">
					<img src="http://placehold.it/370x240" alt="">
					</a>
					<a href="/ultimatesource/frontend/bookit?q=eccbc87e4b5ce2fe28308fd9f2a7baf3" class="details">Book Now!</a>
				</div>
				<a href="/ultimatesource/frontend/roomdetails?q=eccbc87e4b5ce2fe28308fd9f2a7baf3"><h4>BUTCAVE</h4></a>
				<p>&nbsp</p>
				<ul>
					<li>Quality Linens</li>
					<li>Individual Thermostat Control</li>
					<li>Fireplace and jetted tubs</li>
				</ul>
			</div>
	<div class="clear"></div>
	</div>
		</div>	


	<div class="pagenation clearfix">
		<ul>
			<li><a href="#"><</a></li>
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">></a></li>
		</ul>
	</div>

		</div>
		</div>
</div>	


		<aside class="content-aside column3">
			
			<h3>Book Schedule for this room</h3>
			<div class="side-form mb20">
			<form id="bookroomnow" action="<?php echo Url::to(['/frontend/bookingsetup']); ?>" method="post">
					<input type="hidden" name="keyid" value="">

					<label class="reserveform-labels">Checkin Date</label>
					<input name = "checkin" id="datepicker-example1" type="text" value="">

					<label class="reserveform-labels">Checkout Date</label>
					<input name="checkout" id="datepicker-example2" type="text" value="">

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

				<input type="submit" value="RESERVE NOW!">
			</form>
			</div>

		</aside>
		<div class="clear"></div>