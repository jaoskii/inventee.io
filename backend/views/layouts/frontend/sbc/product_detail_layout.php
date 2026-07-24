<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Solutionbase Corporation';
use backend\assets\NewfrontAsset;
NewfrontAsset::register($this);
?>

<?php $this->beginPage() ?>


<!DOCTYPE html>
<html class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">
	<!-- add
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Varela">
	<link rel="stylesheet" href="styles/screen.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudfare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.svg">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="scripts/components/jquery.js" data-main="scripts/options"></script>
	<script src="scripts/components/require.js" data-main="scripts/options"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="scripts/components/jquery.pagenav.js" data-main="scripts/options" ></script>
	<script src="scripts/components/navscroll.js" data-main="scripts/options"></script>
	<script src="//cdn.wordart.com/wordart.min.js" async="" defer=""></script> -->



	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>


</head>

<script src="//cdn.wordart.com/wordart.min.js" async defer></script>
<style type="text/css">

.text-green{
	color: #006600;
}
.float {
	animation: float 6s ease-in-out infinite;
	}

@keyframes float {
	0% {
		/*box-shadow: 0 5px 15px 0px rgba(0,0,0,0.6);*/
		transform: translatey(0px);
	}
	50% {
		/*box-shadow: 0 25px 15px 0px rgba(0,0,0,0.2);*/
		transform: translatey(-20px);
	}
	100% {
		/*box-shadow: 0 5px 15px 0px rgba(0,0,0,0.6);*/
		transform: translatey(0px);
	}
}

	animation: float 6s ease-in-out infinite;


</style>

<!-- add -->
<!-- <script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="options" src="scripts/options.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="modernizr" src="scripts/components/modernizr.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="velocity" src="scripts/components/velocity.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="browser" src="scripts/components/browser.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="domready" src="scripts/components/domReady.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="smooth-scroll" src="scripts/components/smooth-scroll.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="progress-bar" src="scripts/components/progress-bar.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="device-slider" src="scripts/components/device-slider.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="sudo-slider" src="scripts/components/sudo-slider.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="strip" src="scripts/components/strip.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="isotype" src="scripts/components/isotype.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="bridget" src="scripts/components/bridget.js"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="imagesloaded" src="scripts/components/imagesloaded.js"></script> -->
<!-- end add -->


<?php $this->beginBody() ?> 
	<!-- 1 -->
<body class="dom-loaded">
	 
	<!-- IPAPASOK DITO -->
	<div id="home" data-smooth-scroll="on">
        <?php require('header/navbar_less.php'); ?>
        <br>
        <br>
        <?php echo $content; ?>
        <br>
        <br>
		<?php require('footer/footer_less.php'); ?>

	</div> <!-- /#home -->
	<!-- ipapapsok end -->
</body>
<?php $this->endBody() ?>
<?php $this->endPage() ?>