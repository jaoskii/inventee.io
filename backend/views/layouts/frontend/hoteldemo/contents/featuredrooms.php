<?php
use yii\helpers\Url;
?>
<!-- Latest Deals -->
		<div class="latest mb30">
			<h3>Latest Room Deals</h3>
			<div class="dark">
			
			<?php
			foreach ($this->params['featroomtypes'] as $key => $value) {
				echo '<div class="column4 box">
					<div class="box-img">
						<img src="'.Yii::$app->homeUrl.'/frontendassets/hoteldemo/images/r1.jpg" alt="">
						<a href="#" class="details">Book Now!</a>
					</div>
					<a href="'.Url::to(['/frontend/roomdetails','q'=>$value['roomid']]).'"><h4>'.$value['roomtype'].'</h4></a>
					<p>'.mb_strimwidth($value['rem'], 0, 415, "...").'</p>
					<ul>
						<li>Quality Linens</li>
						<li>Individual Thermostat Control</li>
						<li>Fireplace and jetted tubs</li>
					</ul>
				</div>';						
			}//end switch
			?>

			<div class="clear"></div>
			</div>
		</div>
		<!-- End Latest Deals -->