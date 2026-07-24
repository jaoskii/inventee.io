<?php
use yii\helpers\Url;
$this->title = 'Available Room Types';
?>

	<div class="accomodation3-content">
		<?php
			$counter = 0;
			$str = '';
			$series = count($roomtypes);
			$counterloop = 0;

			foreach ($roomtypes as $key => $value) {
				if($value['rem']){
					$rem = mb_strimwidth($value['rem'], 0, 415, "...");
				}else{
					$rem = '&nbsp';
				}//end if

				$counterloop += 1;
				if($counter == 0){
						$str .= '<div class="latest mb30"><div class="dark">';
						$str .= '<div class="column3 box">
								
								<div class="box-img">
									<a href="'.Url::to(['/frontend/roomdetails','q'=>$value['roomid']]).'">
									<img src="http://placehold.it/370x240" alt="">
									</a>
									<a href="'.Url::to(['/frontend/roomdetails','q'=>$value['roomid']]).'" class="details">Book Now!</a>
								</div>

								<a href="'.Url::to(['/frontend/roomdetails','q'=>$value['roomid']]).'"><h4>'.$value['roomtype'].'</h4></a>
								
								<p>'.$rem.'</p>

								<ul>
									<li>Quality Linens</li>
									<li>Individual Thermostat Control</li>
									<li>Fireplace and jetted tubs</li>
								</ul>
								
							</div>';
						$counter += 1;
				}elseif($counter == 5){
						$counter = 0;
						$str .= '<div class="clear"></div>
								</div></div>';
				}else{
					$str .= '<div class="column3 box">
								
								<div class="box-img">
									<a href="'.Url::to(['/frontend/roomdetails','q'=>$value['roomid']]).'">
									<img src="http://placehold.it/370x240" alt="">
									</a>
									<a href="'.Url::to(['/frontend/roomdetails','q'=>$value['roomid']]).'" class="details">Book Now!</a>
								</div>

								<a href="'.Url::to(['/frontend/roomdetails','q'=>$value['roomid']]).'"><h4>'.$value['roomtype'].'</h4></a>
								
								<p>'.$rem.'</p>

								<ul>
									<li>Quality Linens</li>
									<li>Individual Thermostat Control</li>
									<li>Fireplace and jetted tubs</li>
								</ul>
								
							</div>';
					if($counterloop == $series){
						$str .= '<div class="clear"></div></div></div>';
					}//end if
				}//end if
			}//end fpr each
			echo $str;
		?>
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