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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico">



	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>


</head>

<script src="//cdn.wordart.com/wordart.min.js" async defer></script>
<script src="<?php echo Yii::$app->homeUrl;?>added/js/client_captcha.js" defer></script>

<style type="text/css">

p.wrong {
        display: none;
    }
    
    p.wrong.shake {
        display: block;
    }
    
    p.wrong.shake {
        animation: shake .4s cubic-bezier(.36, .07, .19, .97) both;
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
        perspective: 1000px;
    }
    
    @keyframes shake {
        10%,
        90% {
            transform: translate3d(-1px, 0, 0);
        }
        20%,
        80% {
            transform: translate3d(1px, 0, 0);
        }
        30%,
        50%,
        70% {
            transform: translate3d(-2px, 0, 0);
        }
        40%,
        60% {
            transform: translate3d(2px, 0, 0);
        }
    }
    
    .controls img {
        height: 20px;
    }
    

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
        <?php require('addons/logo_sphere.php'); ?>
        <?php require('header/navbar.php'); ?>

		<section id="intro" class="box">
		  <div class="container">
			<div class="row">
			  <div class="col-md-12">
				<div class="fancy-title text-center uppercase">
				  <h4 class="text-alpha">ACCOUNTING with INVENTORY<br>MONITORING SOLUTION
				  </h4>
					
				  <h6 class="text-grey text-air">Web-based/Window-based 
				  </h6>
				</div>
			  </div>
			</div> <!-- /.row -->

			<div class="row">
			  <div class="col-sm-4">
				<div class="fancy-features text-right">
				  <div class="row row-fit">
					<div class="col-xs-10">
					  <h6 class="uppercase font-alpha">
					   	<b style="color:#006600;">Data Security
					   	</b>
					  </h6>
					  <p>Every user has its own identity
						(username and password).
						Accessibility for every module
						depends upon on user access set-up.
						It ensures confidentiality of data that
						is stored on a various workstations
					    and server.
					  </p>
					</div>
					
					<div class="col-xs-2">
					  <div class="featured-icon">
						<figure class="shape-square">
						  <i class="fa fa-shield font-2x"></i>
						</figure>
					  </div>
					</div>
				  </div>					
				</div> <!-- /.fancy-features -->

				<div class="fancy-features text-right">
				  <div class="row row-fit">
					<div class="col-xs-10">
					  <h6 class="uppercase font-alpha">
					  	<b style="color:#006600;">General Ledger Management</b>
					  </h6>
					  <p>Enables maintenance and
						processing of accounting
						information, sales, purchases and
						inventory data to prepare
						transactions, documents and
						information useful in decision
						making and hone any unprofitable
						part of your business and
						troubleshoot it until you solve the
						problem. It can easily conduct
						consolidation into complete
						financial statement.
					  </p>
					</div>
					
					<div class="col-xs-2">
					  <div class="featured-icon">
						<figure class="shape-square">
						  <i class="fa fa-database font-2x">
						  </i>
						</figure>
					  </div>
					</div>
				  </div>					
				</div> <!-- /.fancy-features -->
			  </div> <!-- /.col-sm-4 -->
				
			  <div class="col-sm-4">
				<div class="float featured-logo">
				  <div class="bg-alpha shape-square">
				  </div>
				</div>
			  </div> <!-- /.col-sm-4 -->
					
			  <div class="col-sm-4">
				<div class="fancy-features">
				  <div class="row row-fit">
					<div class="col-xs-2">
					  <div class="featured-icon">
						<figure class="shape-square">
						  <i class="fa fa-gear font-2x">
						  </i>
						</figure>
					  </div>
					</div>
					
					<div class="col-xs-10">
					  <h6 class="uppercase font-alpha">
					  	<b style="color:#006600;">Automated Data Processing</b>
					  </h6>
					  <p>
						Develop accounting solutions that allow faster and more reliable processing of account information and help reduce the amount of time you have to spend in monitoring and organizing your account.
					  </p>
					</div>
				  </div>					
				</div> <!-- /.fancy-features -->

				<div class="fancy-features">
				  <div class="row row-fit">
					<div class="col-xs-2">
					  <div class="featured-icon">
						<figure class="shape-square">
						  <i class="fa fa-list font-2x">
						  </i>
						</figure>
					  </div>
					</div>
				    <div class="col-xs-10">
					  <h6 class="uppercase font-alpha">
					  	<b style="color:#006600;">Functional and Technical Training and Support</b>
					  </h6>
					  <p>
					  	<b>We make ourselves available</b> on-site at the retailer’s locations handling client contact, providing functional and technical training and support, and resolving any and all troubleshooting issues that arise when the client initiates software usage in a live setting. In order to meet the individual needs of our clients, SBC maintains a competent and reliable team who excel in SQL databases, Visual Studio, and Crystal reports. 
					  </p>
					</div>
				  </div>					
				</div> <!-- /.fancy-features -->
			  </div> <!-- /.col-sm-4 -->
			</div> <!-- /.row -->
		  </div> <!-- /.container -->
		</section> <!-- /.box -->
		

		<?php 
		  echo '<section class="box" data-box-img="'.Yii::$app->homeUrl.'added/sbc/images/bgbg2.jpg">';
		?>

		<div class="box-img" style="transform: translateY(10.3802px); opacity: 1.10839;"> 
			<?php
				$bg = Yii::$app->homeUrl."added/sbc/images/bgbg2.jpg";
			?>
            <span style="background-image: url(<?php echo $bg; ?>);"></span>
		</div>
		<div class="container">
		  <div class="row">
			<div class="col-md-6">
			  <h6 class="font-alpha uppercase text-white"><b>Introduction video</b></h6>
			  <hr class="hr-10">
				<div class="space-1x"></div>
				  <div class="demo-video">
					<iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fsolutionbasecorp.official%2Fvideos%2Fvb.255099281282913%2F653924691400368%2F%3Ftype%3D3&show_text=0&width=400" width="400" height="400" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true">
					</iframe>
				  </div>
			</div>

			<div class="col-md-6 text-white">
			  <h6 class="font-alpha uppercase">
				<b>Skills we got</b>
			  </h6>
			  <hr class="hr-10">
				<ul class="clean-list loop-progress-bar">
				  <li>
					<h6 class="uppercase">
					  <small>Software development</small>
					</h6>
					<div class="progress-bar-item" data-progress-bar='{"min": 0, "max": 100, "style": "percentage", "current": 95}'>
					  <span class="bg-alpha text-alpha show-progress" style="width: 95%;">

					  </span>
					  <span class="value-progress" data-progress-value="0%" style="left: 95%;">95%
					  </span>
					</div>
				  </li>
					  <li>
						<h6 class="uppercase">
						  <small>Web Development</small>
						</h6>
						<div class="progress-bar-item" data-progress-bar='{"min": 0, "max": 100, "style": "percentage", "current": 90}'>
						  <span class="bg-alpha text-alpha show-progress" style="width: 90%;">
						  </span>
						  <span class="value-progress" data-progress-value="0%" style="left: 90%;">90%
						  </span>
						</div>
					  </li>
					  <li>
						<h6 class="uppercase">
						  <small>Android Development</small>
						</h6>
						<div class="progress-bar-item" data-progress-bar='{"min": 0, "max": 100, "style": "percentage", "current": 80}'>
						  <span class="bg-alpha text-alpha show-progress" style="width: 80%;">
						  </span>
						  <span class="value-progress" data-progress-value="0%" style="left: 80%;">80%</span>
						</div>
					  </li>
					
					  <li>
						<h6 class="uppercase">
						  <small>WAN/LAN Installation</small>
						</h6>
						<div class="progress-bar-item" data-progress-bar='{"min": 0, "max": 100, "style": "percentage", "current": 65}'>
						  <span class="bg-alpha text-alpha show-progress" style="width: 65%">
						  </span>
						  <span class="value-progress" data-progress-value="0%" style="left: 65%">65%</span>
						</div>
					  </li>
				    </ul>
		          </div>
		        </div>
	          </div> <!-- /.container -->
	        </section><!-- /.box -->

	        <section id="about" class="box">
			  <div class="container">
				<div class="row">
				  <div class="col-md-12">
					<div class="fancy-title text-center uppercase">
					  <h4 class="text-alpha">About SBC Corporation
					  </h4>
					  <h6 class="text-grey text-air">O&nbsp&nbspU&nbsp&nbspR
					  </h6>
					</div>
					<div class="space-1x"></div>
				  </div>
				</div> <!-- /.row -->
				<div class="row">
				  <ul class="loop-features clean-list">
					<li class="col-md-3 col-sm-6">
					  <div class="feature-item text-center">
						<div class="featured-icon align-center">
						  <figure class="shape-square">
							<a>
							  <i class="fa fa-heart font-2x"></i>
							</a>
						  </figure>
						</div>			
						
						<h6 class="uppercase">
						  <a class="clickable">Mission</a>
						</h6>
						<p>We aim to provide total customer satisfaction through efficient handling of every stage of installation of solution package from identification of system requirements to after-sales servicing in every <!--solution package we offer to our clients.--></p>
						<!-- <hr class="hr-20 align-center"> -->
						  <!-- <a href="#" class="font-beta uppercase text-alpha">Learn more
						  </a> -->
					  </div>
					</li>
					
					<li class="col-md-3 col-sm-6">
					  <div class="feature-item text-center">
						<div class="featured-icon align-center">
						  <figure class="shape-square">
							<a>
							  <i class="fa fa-eye font-2x"></i>
							</a>
						  </figure>
						</div>			
						<h6 class="uppercase">
						  <a>Vision</a>
						</h6>
						<p>We envision SOLUTIONBASE CORPORATION to be a provider of excellent and affordable products and services in its diverse business interests towards improving the quality of Philippine businesses.
						</p>
						
						<!-- <hr class="hr-20 align-center"> -->
						  <!-- <a href="#" class="font-beta uppercase text-alpha">Learn more
						  </a> -->
					  </div>
					</li>
						
					<li class="col-md-3 col-sm-6">
					  <div class="feature-item text-center">
						<div class="featured-icon align-center">
						  <figure class="shape-square">
							<a>
							  <i class="fa fa-history font-2x"></i>
							</a>
						  </figure>
						</div>			
						
						<h6 class="uppercase">
						  <a>History</a>
						</h6>
						
						<p>SolutionBase Corporation started operations on 2008. It is located at #50 Kapiligan St. Araneta Avenue, Quezon City. SBC provides superior solution to the most important aspects of business operations, <!--particularly for the retail industry to enable the company to generate information and reports vital to decision-making and handle voluminous data that would be very tedious and takes a long time if done manually. Our growing list of clientele are very pleased with our user-friendly/reasonably-priced software/solution that truly helps in enhancing their productivity and efficiency.-->
						</p>
						<!-- <hr class="hr-20 align-center"> -->
						  <!-- <a href="#" class="font-beta uppercase text-alpha">Learn more</a> -->
					  </div>
					</li>
						
					<li class="col-md-3 col-sm-6">
					  <div class="feature-item text-center">
						<div class="featured-icon align-center">
						  <figure class="shape-square">
							<a class="clickable">
							  <i class="fa fa-dropbox font-2x"></i>
							</a>
						  </figure>
						</div>			
						<h6 class="uppercase">
						  <a>Offers</a>
						</h6>
						<p>Package software solutions are available for installation on as-is basis or customizable depending on our client's preferences.</p>
						<!-- <hr class="hr-20 align-center"> -->
						  <!-- <a href="#" class="font-beta uppercase text-alpha">Learn more -->
						  <!-- </a> -->
					  </div>
					</li>
				  </ul>
				</div> <!-- /.row -->
			  </div> <!-- /.container -->
		    </section> <!-- /.box -->


		<?php
		echo '<section class="box" data-box-img="'.Yii::$app->homeUrl.'"added/sbc/images/dreamprojectbg.jpg">';
		?>

		<?php
		$bg = Yii::$app->homeUrl.'added/sbc/images/dreamprojectbg.jpg';
		?>
		  <div class="box-img" style="transform: translateY(53.3062px); opacity: 1.29662;">
			<span style="background-image: url(<?php echo $bg;?>);"></span>
		  </div>
		  <div class="container">
			<div class="row">
			  <div class="col-md-12">
				<div class="promo-message text-center text-white">
				  <div class="text-center text-white">
                    <h3 class="font-alpha">
                      <b>SOLUTIONBASE CORPORATION</b>
                    </h3>
                    
                    <?php 
                      echo '<img class="float" src="'.Yii::$app->homeUrl.'added/sbc/images/cuz.png" data-src="'.Yii::$app->homeUrl.'added/sbc/images/cuz.png" alt="cuz" style="opacity: 1; display: inline;">';
                    ?>

                    <h3 class="no-margin">WHO WE ARE</h3>
                    <br>
                    <p class="uppercase"><b>Solutionbase Corporation (SBC)</b> provides superior solution to the most important aspects of business operations, particularly for the retail industry to enable the company to generate information and reports vital to decision-making and handle voluminous data that would be very tedious and takes a long time if done manually. Our growing list of clientele are very pleased with our user friendly/reasonably-prices softwares / solutions that truly helps in enchancing their productivity and efficiency.</p>
                  </div>
							<!--	<div class="space-3x"></div><a href="#" class="button-md bg-alpha uppercase">View case studies</a>-->
				</div>
			  </div>
			</div>
		  </div> <!-- /.container -->
		</section> <!-- /.box -->

<?php
echo '<section class="box" data-box-img="'.Yii::$app->homeUrl.'added/sbc/images/bgbg_.jpg">';
?>	

<?php
$bg = Yii::$app->homeUrl.'added/sbc/images/bgbg_.jpg';
?>
  <div class="box-img" style="transform: translateY(1.67163px); opacity: 1.29329;">
  	<span style="background-image: url(<?php echo $bg;?>);">
  	</span>
  </div>
  
  <div class="container">
	<div class="row">
	  <div class="col-md-5 col-md-offset-1">
		<div class="device-slider">
		  <div data-liquid="true">
			<!--<div class="layer" data-depth=".50" data-device-slider='{"slides":["http://placehold.it/400x800/222/aaa", "http://placehold.it/400x800/eee/aaa", "http://placehold.it/400x800/222/aaa", "http://placehold.it/400x800/eee/aaa"]}'>
								</div>-->
			<?php 
			  $android = Yii::$app->homeUrl."added/sbc/images/aimsandroid.jpg";
			?>

			<div class="float layer" data-depth=".50" data-device-slider='{"slides":["<?php echo $android ?>", "<?php echo $android ?>", "<?php echo $android ?>", "<?php echo $android ?>"]}'>
			  <span class="active-device-screen" style="background: rgba(0,0,0,0) url(<?php echo $android ?>)
			    no-repeat scroll 0px 0px; transform: translateX(0px);">
			  </span>
			  <span class="velocity-animating" style="background: rgba(0, 0, 0, 0) url(<?php echo $android ?>) no-repeat scroll 0px 0px; transform: translateX(0px);">
			  </span>
			  <span class="" style="background: rgba(0, 0, 0, 0) url(<?php echo $android ?>) no-repeat scroll 0px 0px; transform: translateX(100%);">
			  </span>
			  <span class="velocity-animating active-device-screen" style="background: rgba(0, 0, 0, 0) url(<?php echo $android ?>) no-repeat scroll 0px 0px; transform: translateX(100%);">
			  </span>
			</div>
		  </div>
		</div>
	  </div>
		
	  <div class="col-md-5">
		<div class="box-text text-white">
		  <h4 class=" font-alpha text-white">
		  	<b>A.I.M.S with Android </b>
		  </h4>
		  <h6 class=" font-20">Using your gadgets you can now work wherever you are with just a click.</h6>
		  <br>
							
		  <div class="row">
			<ul class="clean-list device-slider-nav">
			  <li class="col-xs-3">
				<div class="featured-icon align-center">
				  <figure class="shape-square active-nav">
					<a class="bg-alpha">
					  <i class="icon-292 font-2x"></i>
					</a>
				  </figure>
				</div>
			  </li>
			
			  <li class="col-xs-3">
				<div class="featured-icon align-center">
				  <figure class="shape-square">
					<a class="">
					  <i class="icon-502 font-2x"></i>
					</a>
				  </figure>
				</div>
			  </li>
			  <li class="col-xs-3">
				<div class="featured-icon align-center">
				  <figure class="shape-square">
					<a>
					  <i class="icon-473 font-2x"></i>
					</a>
				  </figure>
				</div>
			  </li>
			
			  <li class="col-xs-3">
				<div class="featured-icon align-center">
				  <figure class="shape-square">
					<a class="">
					  <i class="icon-512 font-2x"></i>
					</a>
				  </figure>
				</div>
			  </li>
			</ul>
		  </div>
          <br>

		  <h6 class="uppercase">Android Retail</h6>

		  <p>Android Retail is the agent’s tool to make delivery of stocks and received payments right away from the customer through the use of Android gadgets.All transactions are made without the use of internet, only when transferring of data from AIMS to the Android gadgets to update the inventory balance and Android gadgets to AIMS to transfer all transactions made.

		  In Android Retail we have five modules that will be used for operation outside your office. Features and functions that is more accessible and easy to operate by the user.

		  These are the modules that are used in Android Retail and their functions.

		  </p>
		  <br>
		  <!-- <a href="#" class="button-md button-outline text-white uppercase">Recent works -->
		  </a>
		</div>
	  </div>
	</div>
  </div> <!-- /.container -->
</section> <!-- /.box -->

<section id="services" class="box box-title">
  <div class="container">
	<div class="row">
	  <div class="col-md-12">
		<div class="fancy-title text-center uppercase">
		  <h4 class="text-alpha">Services we offer</h4>
		  <h6 class="text-grey text-air">What can we do for you</h6>
		</div>
	  </div>
	</div> <!-- /.row -->
  </div> <!-- /.container -->
</section> <!-- /.box -->
		
<?php 
  echo '<section class="box box-no-bottom" data-box-img="'.Yii::$app->homeUrl.'"added/sbc/images/.jpg">';
?>

<div class="box-img" style="transform: translateY(1.83325px); opacity: 0.651834;">
	<span style="background-image: url(added/sbc/images/.jpg);"></span>
</div>
<div class="container">
  <div class="row">
	<div class="col-md-12">
	  <!-- <div id="big-tabs-nav" class="slide-navigation align-center">
		<ul class= "inline-list">
		  <li>
			<a href="#" class="bg-white" data-target="prev">
			  <i class="icon-110"></i>
			</a>
		  </li>
		  <li>
			<a href="#" class="bg-white" data-target="next">
			  <i class="icon-111"></i>
			</a>
		  </li>
		</ul>
	  </div> -->

	  <div class="big-tabs" data-sudo-slider='{"slideCount":5, "moveCount":1, "customLink":"#big-tabs-nav a, .big-tabs li", "continuous":true}' style="overflow: hidden; display: block;">
		<ul class="clean-list slidesContainer" style="display: block; position: relative; margin: 0px; transform: translate(0px, 0px); width: 9000000px; height: 100%; transition-property: transform; transition-timing-function: ease-in-out; transition-delay: 0s;">
		  
		   <li class="slide" data-target="2" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 228px;" data-slide="4">
			<div class="tab-item uppercase text-center">
			  <div class="shape-square bg-white">
				<i class="fa fa-android font-6x">
				</i>
			  </div>
			  <h6 class="font-alpha">
			  	<small>Android Development</small>
			  </h6>
			</div>
		  </li>

		  <li class="slide" data-target="3" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 228px;" data-slide="5">
			<div class="tab-item uppercase text-center">
			  <div class="shape-square bg-white">
				<i class="fa fa-bookmark-o font-6x">
				</i>
			  </div>
			  <h6 class="font-alpha">
			  	<small>Branding</small>
			  </h6>
			</div>
		  </li>

		  <li class="slide current active-big-tab" data-target="4" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 228px;" data-slide="1">
			<div class="tab-item uppercase text-center">
			  <div class="shape-square bg-white">
				<i class="fa fa-globe font-7x">
				</i>
			  </div>
			  <h6 class="font-alpha">
			  	<small>Web Design & Solution</small>
			  </h6>
			</div>
		  </li>

		  
		  <li class="slide" data-target="5" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 228px;" data-slide="2">
			<div class="tab-item uppercase text-center">
			  <div class="shape-square bg-white">
				<i class="fa fa-link font-6x"></i>
			  </div>
			  <h6 class="font-alpha">
			  	<small>WAN/LAN Installation</small>
			  </h6>
			</div>
		  </li>
		  <li class="slide" data-target="1" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 228px;" data-slide="3">
			<div class="tab-item uppercase text-center">
			  <div class="shape-square bg-white">
				<i class="fa fa-check-circle-o font-10x">
				</i>
			  </div>
			  <h6 class="font-alpha">
			  	<small>Software Development</small>
			  </h6>
			</div>
		  </li>
		 
		  
		</ul>
	  </div>

	  <div class="big-tabs-content" data-sudo-slider='{"customLink":"#big-tabs-nav a, .big-tabs li", "continuous":true}' style="overflow: hidden; display: block;">
		<ul class="inline-list slidesContainer" style="display: block; position: relative; margin: 0px; transform: translate(-2280px, 0px); width: 9000000px; height: 100%; transition-property: transform; transition-timing-function: ease-in-out; transition-delay: 0s;">
		 
		<li class="row slide" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 1140px;" data-slide="2">
		  <div class="col-md-7">
			<figure class="text-center no-margin">
			  <?php
				echo '<img class="float" src="'.Yii::$app->homeUrl."added/sbc/images/android.jpg".'" alt="big tabs">';
			  ?>
			</figure>
		  </div>
		  <div class="col-md-5">
			<h4 class="text-green">Android Development</h4>
			<p>Ut molestie ultricies quam. Donec at sem. Praesent pretium. Maorbi quis nulla vehicula felsd laoreet. Sed ullamcorper arcu eul ante. Sed tempus tempor cild  Nulla vierra ultrices magnal Nam rutrum congue diam.</p>
			<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utdi eni ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exe commodo consequat. Duis aute irure dolor reprehenderit.</p>
			<hr class="hr-10">
			  <!-- <a href="#" class="uppercase text-alpha">Learn more</a> -->
		  </div>
		</li>

		<li class="row slide" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 1140px;" data-slide="3">
		  <div class="col-md-5">
			<h4 class="text-green">Branding</h4>
			  <p>
				<b>IDENTITY DESIGN</b>
				We design logo that helps your company to create its own distinct identity in the minds of your customers which is easy to recall and reminds them as to what kind of business your company offers as well as recall their transactions with your company… Let SBC help in creating this identity design for you <br/>
				<b>BRANDING DESIGN</b>
				We offer creation, designing of your materials such as IDs, brochures, flyers, etc. Let professionals handle your branding design needs to make these professional looking done in a shorter period of time. We help you focus on your business and we tinker with the help you manage your library of images.
				</p>
				<hr class="hr-10">
				<!-- <a href="#" class="uppercase text-alpha">Learn more</a> -->
			  </div>
			  <div class="col-md-7">
				<figure class="text-center no-margin">
				  <?php 
				    echo '<img class="float" src="'.Yii::$app->homeUrl."added/sbc/images/branding.jpg".'" alt="big tabs">';
				  ?>
				</figure>
			  </div>
			</li>

			<li class="row slide active-big-tab-content" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 1140px" data-slide="4">
			  <div class="col-md-5">
				<h4 class="text-green">Web Design & Development</h4>
				<p>
				The effectiveness of a website design is ultimately measured by its ability to catch the client’s attention in a matter of seconds and to create the good impression of reliability, credibility, and professionalism. It is shared by both artistic endeavors and methodical processes. 

				In website designing, the goal is to create a visual representation using not only aesthetically appealing web graphics, styles, and layouts, but also psychologically proven principles in business marketing and consumer advertising. The internet is a colossal battleground of advertisers and marketers, and our effective website design will be your only weapon. 

				SBC can handle your web design /development in accordance with your objectives, from Static Web Design Package comprised of 4 pages (Home, About Us, Products, and Contact Us Pages) to customized Content Management System (CMS) which can be designed per desired features and specifications.
				</p>
				<hr class="hr-10">
				  <!-- <a href="#" class="uppercase text-alpha">Learn more
				  </a> -->
			  </div>
			  <div class="col-md-7">
				<figure class="text-center no-margin">
				  <?php
					echo '<img class="float" src="'.Yii::$app->homeUrl."added/sbc/images/web.jpg".'" alt="big tabs">';
				  ?>
				</figure>
			  </div>
			</li>
			

		<li class="row slide" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 1140px;" data-slide="5">
			  <div class="col-md-5">
				<h4>WAN & LAN Installation</h4>
				<p>
				With the availability of affordable solution packages that enables automated data processing and data integration, LAN/WAN is becoming a must among companies. 

				SBC offers installation of wired or wireless networking inclusive of assistance in the planning, security analysis, design development and implementation/insttallation, integra-tion, maintenance testing, configura-tion, modification, and management of networked systems for the transmission of data.
				</p>
				<hr class="hr-10">
				<!-- <a href="#" class="uppercase text-alpha">Learn more</a> -->
			  </div>
			  <div class="col-md-7">
				<figure class="text-center no-margin">
				  <?php
					echo '<img src="'.Yii::$app->homeUrl."added/sbc/images/wanlan.jpg".'" alt="big tabs">';
				  ?>
				</figure>
			  </div>
			</li>

			<li class="row slide" style="position: relative; float: left; list-style: outside none none; display: block; margin: 0px; width: 1140px" data-slide="1">
			<div class="col-md-5">
			  <h4 class="text-green">Software Development</h4>
			  <p>The following package solutions/software available for installation on as-is basis or customizable depending on our clients’ preference: Accounting with Inventory Management System (AIMS), Inventory Solution, Billing and Collection System, Payroll and Timekeeping Solution, Human Resource Information System and Point of Sales Solution. SBC makes sure that every stage of the software/solution selection/ definition/implementation/training/use is properly handled from definition of system requirement/selection of system software to implementation. We exert extra efforts to understand the clients’ solution needs; provide easy to understand/follow manuals; and train end-users on how to use the solutions/software. We discuss with our clients extensively if there are customizations that need to be done to our existing packaged software/solution. We also provide after-sales servicing to the solutions installed.
			  </p>
			<hr class="hr-10">
			  <!-- <a href="#" class="uppercase">Learn more
			  </a> -->
		  </div>
		  <div class="col-md-7">
			<figure class="text-center no-margin">
			  <?php
				echo '<img class="float" src="'.Yii::$app->homeUrl."added/sbc/images/software.jpg".'" alt="big tabs">';
			  ?>
			</figure>
		  </div>
		</li>


		
		  </ul>
		</div>
	  </div>
	</div> <!-- /.row -->
  </div> <!-- /.container -->
</section> <!-- /.box -->

<section id="works" class="box">
  <div class="container">
	<div class="row">
	  <div class="col-md-12">
		<div class="fancy-title text-center uppercase">
		  <h4 class="text-alpha">Software Solutions</h4>
		  <h6 class="text-grey text-air">Think Solution and making technology works!
		  </h6>
		</div>
	  </div>
	</div> <!-- /.row -->

	<div class="row">
	  <div class="col-md-12">
		<div class="space-3x"></div>
		  <div class="portfolio-filters uppercase clearfix">
			<ul class="inline-list">
			  <li>
				<label>
				  <input name="isotope_filter" value="*" checked=""  type="radio">
					<span>AVAILABLE SYSTEM / SOLUTIONS</span>
				</label>
			  </li>
			  <!-- <li>
				<label>
				  <input name="isotope_filter" value=".web-design" type="radio">
					<span>Accounting Solution
					</span>
				</label>
			  </li>
			  <li>
			    <label>
				  <input name="isotope_filter" value=".artworks" type="radio">
					<span>Monitoring Solution</span>
				</label>
			  </li>
			  <li>
				<label>
				  <input name="isotope_filter" value=".photography" type="radio">
				    <span>POS Solution</span>
				</label>
			  </li>
			  <li>
				<label>
				  <input name="isotope_filter" value=".photography" type="radio">
					<span>More Solutions</span>
				</label>
			  </li> -->
			</ul>

			
			</div>
		  </div>
		</div> <!-- /.row -->

		<div class="row row-fit">
		  <ul class="clean-list portfolio-loop" data-masonry="li" style="position: relative; height: 680px">
			<?php
			try {
				$qry = "select item.itemname,md5(item.barcode) as barcode,itimages.picture,item.category from item
						left join itimages on itimages.codeid = item.itemid";
				$data = Yii::$app->sbccommon->opentable($qry);

				if(!empty($data)){
					$counter = 1;
					$top = 0;

					foreach ($data as $key => $value) {
						switch ($counter) {
							case 1:
								$left = '0px';
							break;

							case 2:
								$left = '190px';
							break;

							case 3:
								$left = '380px';
							break;

							case 4:
								$left = '570px';
							break;

							case 5:
								$left = '760px';
							break;

							case 6:
								$left = '950px';
							break;

						}//end switch


						if($counter == 7){
							$counter = 1;
							$left = '0px';
							$top += 190;
						}//end if

						$styler = 'style="position: absolute; left: '.$left.'; top: '.$top.'px;"';

						echo '<li class="col-md-2 col-sm-4 col-xs-6 artworks" '.$styler.'>
							  <div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img class="" src="'.$value['picture'].'" data-src="'.$value['picture'].'" alt="portfolio image" style="opacity: 1; display: inline;">
								</figure>

								<div class="portfolio-front">
								  <div class="bg-alpha">
									<div class="featured-icon">
									<figure class="shape-square">';
					 ?>				
									<a href="<?php echo Url::to(['/frontend/productdetail','sku'=>$value['barcode']]); ?>" class="bg-white zoom-img" data-strip-group="portfolioSBC" data-strip-options="side:'top'">
									  <i class="icon-367 font-2x">
									  </i>
									</a>
					<?php
									echo '</figure>
									</div>
								  </div>
								  <div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha">
									  <a href="'.Url::to(['/frontend/productdetail','sku'=>$value['barcode']]).'">
									  	<b>'.$value['itemname'].'</b>
									  </a>
									</h6>
									<span class="font-beta">'.$value['category'].'</span>
								  </div>
								</div>
							  </div>
							</li>';

						$counter += 1;
					}//end f
				}//end if

			} catch (ErrorException $e) {
				echo $e;
			}
			?>
			

			
		</ul>
	  </div> <!-- /.row -->
	</div> <!-- /.container -->
  </section> <!-- /.box -->

		<section id="contact" class="box" style="/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#299a0b+0,299a0b+32,017206+71;Green+Flat+%231 */
background: #299a0b; /* Old browsers */
background: -moz-linear-gradient(-45deg, #299a0b 0%, #299a0b 32%, #017206 71%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg, #299a0b 0%,#299a0b 32%,#017206 71%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg, #299a0b 0%,#299a0b 32%,#017206 71%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#299a0b', endColorstr='#017206',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="fancy-title text-center uppercase">
							<h4 class=" text-white">Contact US</h4>
							<h6 class="text-grey text-air">Connect with Us</h6>
						</div>
					</div>
				</div> <!-- /.row -->

				<div class="row">
					<div class="text-white col-md-10 col-md-offset-1">
						<div class="space-2x"></div>
						<h6 class="text-grey uppercase text-center"><b>Send us your thoughts</b></h6>
						<hr class="hr-10 align-center">
					
						<?php
						echo '<form action="'.Url::to(['/frontend/sendconcern']).'" s class="slim-form full-inputs row">
               				<p class="col-md-4">
               					<label>Your Name</label>
								<input required type="text" name="name">
							</p>
							<p class="col-md-4">
								<label>Email</label>
								<input required type="email" name="email">
							</p>
							<p class="col-md-4">
								<label>Subject</label>
								<input required type="text" name="subject">
							</p>
							<p class="col-md-12">
								<label>Your Message</label>
								<textarea required name="message"></textarea>
							</p>
							<p class="col-md-12" id="submitbtn">
								
							</p>';

						?>

						<div class="row captcharow">
					    <div class="col-md-4">
					    </div>
					    <div class="col-md-4">
					        <div class="captcha-chat">
					            <div class="captcha-container media">
					                <div class="media-body">
					                    <p class="security">Security Check:</p>
					                </div>
					                
					                <div id="captcha">
					                    <div class="controls">
					                        <div class="row">
					                          <div class="col-md-12">
					                          <p class="wrong info">Wrong!, please try again.</p>
					                          </div>
					                        </div>
					                        <div class="row">
					                          <div class="col-md-12">
					                            <input style="width:245px;" class="input-xs user-text btn-common form-control" placeholder="Type here" type="text" />
					                          </div>
					                        </div>
					                        <br>
					                        <div class="row">
					                            <div class="col-md-6">
					                              <input type="button" class="btn btn-xs btn-primary validate btn-common" value="Validate Captcha">
					                            </div>
					                            <div class="col-md-6">
					                              <input type="button" class="btn refresh btn-xs btn-success btn-common" value="Refresh Captcha">
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="col-md-4">
					    </div>
					    </div>


					</div>
					</form>

				</div> <!-- /.row -->


			</div> <!-- /.container -->
		</section> <!-- /.box -->

<script>
        document.addEventListener("DOMContentLoaded", function() {
        document.body.scrollTop; //force css repaint to ensure cssom is ready

        var timeout; //global timout variable that holds reference to timer

        var captcha = new $.Captcha({
            onFailure: function() {

                $(".captcha-chat .wrong").show({
                    duration: 30,
                    done: function() {
                        var that = this;
                        clearTimeout(timeout);
                        $(this).removeClass("shake");
                        $(this).css("animation");
                        //Browser Reflow(repaint?): hacky way to ensure removal of css properties after removeclass
                        $(this).addClass("shake");
                        var time = parseFloat($(this).css("animation-duration")) * 1000;
                        timeout = setTimeout(function() {
                            $(that).removeClass("shake");
                        }, time);
                    }
                });

            },

            onSuccess: function() {
                $('.captcharow').css('display','none');
                $('#submitbtn').html('<button type="submit" value="Submit" class="button-lg button-outline make-full uppercase">Send message</button>');
            }
        });

        captcha.generate();
    });
</script>

<?php require('footer/footer.php'); ?>
</div> <!-- /#home -->
	<!-- ipapapsok end -->

<?php echo $content; ?>
</body>
<?php $this->endBody() ?>
<?php $this->endPage() ?>

