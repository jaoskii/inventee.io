<?php
use yii\helpers\Url;
?>

<nav id="nav">
	<ul id="navlist" class="sf-menu clearfix">
		<li class="current"><a href="<?php echo Url::to(['/'])?>">Home</a></li>
		<li><a href="<?php echo Url::to(['/frontend/roomtypes'])?>">Room Types</a></li>
		<li><a href="<?php echo Url::to(['/frontend/siteinfo','q'=>'aboutus'])?>">About</a></li>
		<li><a href="<?php echo Url::to(['/frontend/gallery'])?>">Gallery</a></li>
		<li><a href="<?php echo Url::to(['/frontend/siteinfo','q'=>'other10'])?>">Contact Us</a></li>
	</ul>
</nav>