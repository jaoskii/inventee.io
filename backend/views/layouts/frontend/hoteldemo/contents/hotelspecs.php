<?php
use yii\helpers\Url;
?>

<div class="row3 dark mb30">
	<div class="accordion column6">
		<?php require_once('hotelfeatures.php');?>
	</div>
	<!-- End Accordion -->

	<!-- Client Testimonials -->
	<div class="testimonials column6">
		<a href="<?php echo Url::to(['/frontend/roomtypes']);?>"><button style="height:230px;width:100%;font-size: 40px;" class="btn btn-primary">BOOK NOW!</button></a>
	</div>

	<!-- End Client Testimonials -->
	<div class="clear"></div>
</div>
		<!-- End Row3 -->