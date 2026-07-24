<?php
use yii\helpers\Url;
if($rooms == ''){
	$this->title = 'Book a room now!';	
}else{
	$this->title = 'Booking Results';
}//end if
?>
<div class="latest mb30">
	<div class="dark" style="border:solid 1px;background-color: grey;">
	
	</div>
</div>

<div class="accomodation5-content">
<div class="latest mb30">
	<!-- PUT CONTENTS HERE -->
	
			<?php
			foreach ($rooms as $key => $i) {
				echo '<div class="box mb20">
				<div class="box-img">
					<img src="'.Yii::$app->homeUrl.'/frontendassets/hoteldemo/images/x_img.jpg" alt="">
					<a href="'.Url::to(['/frontend/roomdetails','q'=>$i['roomid'],'s'=>$startdate,'e'=>$enddate]).'" class="details">Book Now!</a>
				</div>
				<div class="box-text">
					<h4>'.$i['roomtype'].'</h4>
					<p>'.mb_strimwidth($i['rem'], 0, 415, "...").'</p>
				<ul>';
				$msg = '<span style="color:green;font-weight:bold;">This room is AVAILABLE for from ('.$startdate.') until ('.$enddate.').</span>';
				echo '<li>'.$msg.'</li>';
				echo '</ul>
				</div>
				<div class="clear"></div>
				</div>';
			}//end if
			?>
</div>
</div>




