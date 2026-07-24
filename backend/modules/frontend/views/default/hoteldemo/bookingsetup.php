<?php
use yii\helpers\Url;
$this->title = 'Booking information for '. $roomname;
?>


<!-- Container -->
	<div class="accomodation3-content">
		<!-- Latest Deals -->
		<div class="latest mb30">
			<div class="dark">
			<div class="column8 box">
				<ul class="event-list">
					<?php
					foreach ($roomsdetails as $key => $value) {
						echo '<li>';
								
								if($value['isav'] != 1){
									$availclass = 'notav';
								}else{
									$availclass = '';
								}//end if

								echo'
								<time class="'.$availclass.'">
									<span class="day">'.$value['day'].'</span>
									<span class="month">'.$value['month'].'</span>
									<span class="year">'.$value['year'].'</span>
								</time>';

								echo'<div class="info">
									<h5 style="margin-left:10px;font-size: 15px;margin-bottom: 5px;">'.$value['roomstatus'].'</h5>
									<p style="margin-left:10px;font-size: 13px;" class="descinfo">There Room slots available for this day</p>
									<p style="margin-left:10px;font-size: 13px;" class="descinfo">Rooms Slots Available: '.$value['balance'].'</p>
									<ul>';

								if($value['isav'] != 1){
									echo '<div class="col-md-12" style="margin-bottom: 5px">
											<a class="clickable bookingsuggest"><i class="fa fa-search"></i> Look for Suggestions for this day</a>
										</div>';
								}else{
									echo '<div class="col-md-6"  style="margin-bottom: 5px">
											<a class="clickable bookingsuggest"><i class="fa fa-book"></i> Book just for this day</a>
										</div>

										<div class="col-md-6"  style="margin-bottom: 5px">
											<a class="clickable bookingsuggest"><i class="fa fa-times"></i> Cancel Out this Day</a>
										</div>';
								}//end if

								echo '</ul>
								</div>
							</li>';
					}//end switch

					?>

				</ul>
					


			</div>
			<div class="column4 box">
				<ul>
					<?php
					foreach ($roomsdetails as $key => $value) {
						if($value['isav'] == 1){
							echo '<li>'.$value['month'].' '.$value['day'].' '.$value['year'].' <b class="pull-right">Php: 99,999</b></li>';
						}//end if
					}//end for each
					?>
				</ul>
				<input style="margin-top:10%;height: 80px;" class="btn btn-success form-control" value="FINALIZE BOOKING">
			</div>
			<div class="clear"></div>
			</div>
		</div>
		<!-- End Latest Deals -->
		
	</div>

	