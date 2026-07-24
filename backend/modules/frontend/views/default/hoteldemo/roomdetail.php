<?php
use yii\helpers\Url;
if (isset($roomdetails[0]['roomtype'])){
	$this->title = $roomdetails[0]['roomtype'];
}else{
	$this->title = 'Error';
}//end if
?>

<!-- Container -->
	<div class="accomodation6-content column9">
		<!-- Latest Deals -->
		<div class="latest mb30">
			<div class="dark">
			<div class="column12 box">
				<div class="box-img">
					<img src="http://placehold.it/870x400" alt="">
					<a href="#" class="details">Book Now!</a>
				</div>
				<h4><?php echo $roomdetails[0]['roomtype'];?></h4>
				<p><?php echo $roomdetails[0]['rem'];?></p>
			</div>
			<div class="clear"></div>
			</div>
		</div>
		<!-- End Latest Deals -->
		<!-- Latest Deals -->
		<div class="latest mb30">
			<h3>Related Rooms</h3>
			<div class="dark">
			<div class="column4 box">
				<div class="box-img">
					<img src="http://placehold.it/370x240" alt="">
					<a href="#" class="details">Book Now!</a>
				</div>
				<h4>Grand Executive Suite</h4>
				<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis </p>
				<ul>
					<li>Quality Linens</li>
					<li>Individual Thermostat Control</li>
					<li>Fireplace and jetted tubs</li>
				</ul>
			</div>
			<div class="column4 box">
				<div class="box-img">
					<img src="http://placehold.it/370x240" alt="">
					<a href="#" class="details">Book Now!</a>
				</div>
				<h4>Grand Executive Suite</h4>
				<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis </p>
				<ul>
					<li>Plenty of soft and fluffy towels</li>
					<li>High speed Wi-fi access in every room</li>
					<li>Kitchenettes (limited Availability)</li>
				</ul>
			</div>
			<div class="column4 box">
				<div class="box-img">
					<img src="http://placehold.it/370x240" alt="">
					<a href="#" class="details">Book Now!</a>
				</div>
				<h4>Grand Executive Suite</h4>
				<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis </p>
				<ul>
					<li>The beds are extremly comfortable</li>
					<li>Telephone</li>
					<li>Hair Dryer</li>
				</ul>
			</div>
			<div class="clear"></div>
			</div>
		</div>
		<!-- End Latest Deals -->
		
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

	