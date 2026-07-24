<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'XTZ Business PH';


use backend\assets\XtzAsset;
XtzAsset::register($this);

?>

<?php $this->beginPage() ?>


<!DOCTYPE html>
<html class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients no-cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="<?= Yii::$app->language ?>">

<head>
	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
	<link rel="shortcut icon" href="/favicon.ico">



	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>


</head>
<script src="<?php echo Yii::$app->homeUrl;?>added/config/ajax_config.js"></script>
<script src="<?php echo Yii::$app->homeUrl;?>added/xtz/scripts/components/require.js" data-main="<?php echo Yii::$app->homeUrl;?>added/xtz/scripts/options"></script>
<script src="//cdn.wordart.com/wordart.min.js" async defer></script>
<link rel="stylesheet" href="<?php echo Yii::$app->homeUrl;?>added/xtz/styles/screen.css">
<script src="<?php echo Yii::$app->homeUrl;?>added/js/client_captcha.js" defer></script>


<style type="text/css">
	.txt_xzt{
		font-size: 30px;
	} 
	.fancy-features p{
		font-size: 18px;
	} 


.about_ico {
	float: all;
	margin: -75px 0px -15px 5px ;
}

</style>

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

<?php $this->beginBody() ?> 
	<!-- 1 -->


<body data-preloader="on">
    <!--[if lt IE 9]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->



    <div id="home">
    	<div class="mobile-top">
    	<div class="row"><div class="col-md-12">
	    	<div class="mobile-bg" style="/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ec5027+32,db1f1e+70 */
				background: #ec5027; /* Old browsers */
				background: -moz-radial-gradient(center, ellipse cover, #ec5027 32%, #db1f1e 70%); /* FF3.6-15 */
				background: -webkit-radial-gradient(center, ellipse cover, #ec5027 32%,#db1f1e 70%); /* Chrome10-25,Safari5.1-6 */
				background: radial-gradient(ellipse at center, #ec5027 32%,#db1f1e 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ec5027', endColorstr='#db1f1e',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
				<a href="#"><img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/load.svg" data-src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/logo-intro.png" alt="logo intro" class="mobile-logo"></a>
				<img class="mobile-pic" alt="Theme logo" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/slides1/s1_.png">
			</div>
		</div></div>
		</div>

		<div class="desk-top">
        <section class="box-intro-large">
            <div class="page-loader">
                <div class="text-center">
                    <h1 class="uppercase font-alpha no-margin loading-text">XTZ</h1>
                </div>
            </div>
            <div class="intro-container" style="/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ec5027+32,db1f1e+70 */
			background: #ec5027; /* Old browsers */
			background: -moz-radial-gradient(center, ellipse cover, #ec5027 32%, #db1f1e 70%); /* FF3.6-15 */
			background: -webkit-radial-gradient(center, ellipse cover, #ec5027 32%,#db1f1e 70%); /* Chrome10-25,Safari5.1-6 */
			background: radial-gradient(ellipse at center, #ec5027 32%,#db1f1e 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ec5027', endColorstr='#db1f1e',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
            <div class="box-img"><span>
                </span></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="intro-logo">
                                <a href="#"><img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/load.svg" data-src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/logo-intro.png" alt="logo intro"></a>
                            </div>
                        </div>
                    </div> <!-- /.row -->                        
                </div> <!-- /.container -->

                <div class="container intro-center">
                       							    <div class="slider-box">
							        <div class="slider" id="slider">
							            <div class="slider__item">
							              <img alt="Theme logo" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/slides1/s1_.png">
							                <h2 class="slider__item__title"></h2>
							            </div>
							            <div class="slider__item">
							                <img alt="Theme logo" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/slides1/s1_.png">
							                <h2 class="slider__item__title"></h2>
							            </div>
							        </div>

							        <div class="slider-nav">
							            <div class="slider-nav__prev" id="prev"><i class="fa fa-angle-left"></i></div>
							            <div class="slider-nav__next" id="next"><i class="fa fa-angle-right"></i></div>
							            <div class="slider-nav__dots" id="dots"></div>
							        </div>
							    </div>
                
                </div>
            </div>
        </section>
    	</div>



        <header class="main-header" data-sticky="true">
            <section class="header-navbar bg-alpha" data-menu-scroll="true">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2 col-xs-4">
                            <figure class="identity">
                            	<a href="#home">
                            		<img alt="Theme logo" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/logo-intro2.png" style="height:50px;">
                            	</a>
                            </figure>
                        </div> <!-- /.col-2 -->
                        <div class="col-sm-10 col-xs-8">
                            <nav class="main-nav">
                            	<a href="#" class="responsive-menu align-right"><i class="icon-333 font-2x text-white"></i></a>
                            	<ul class="inline-list align-right uppercase"> 
                            		<li>
                            			<a href="#home">Home</a>
<!--                             			<ul>
                            				<li>
                            					<a href="home-two.html">Home multi-page</a>
                            				</li>
                            			</ul> -->
                            		</li>
                      <!--       		<li><a href="#intro">Intro</a></li> -->
                            		<li><a href="#about">About</a></li>
                            		<li><a href="#products">Products</a></li>
<!--                             		<li><a href="#team">Team</a></li>
                            		<li><a href="#history">History</a></li> -->
                     <!--        		<li><a href="#works">Works</a></li>
                            		<li><a href="#prices">Prices</a></li> -->
                            		<li><a href="#contact">Contact</a></li>
                       <!--      		<li>
                            			<a href="blog.html">Blog</a>
                            			<ul>
                            				<li>
                            					<a href="blog-no-sidebar.html">Blog without sidebar</a>
                            				</li>
                            				<li>
                            					<a href="single-blog.html">Blog post page</a>
                            				</li>
                            				<li>
                            					<a href="single-blog-full.html">Blog post page two</a>
                            				</li>
                            			</ul>
                            		</li> -->
                            	</ul>
                            </nav><!-- /.main-nav -->
                        </div> <!-- /.col-10 -->
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </section> <!-- /.header-navbar -->
        </header> <!-- /.main-header -->


		<section id="about" class="box" style="background-image: url('<?php echo Yii::$app->homeUrl;?>added/xtz/images/xbg.jpg')">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="fancy-title text-center uppercase">
							<h4 class="text-alpha">ABOUT <b>XTZ ENTERPRISES</b></h4>
						</div>
						<br>
					</div>
				</div> <!-- /.row -->

				<div class="row">
					<div class="col-sm-5">
						<div class="fancy-features text-right">
							<div class="row row-fit">
								<div class="">
								
									<h6 class="col-xs-12 uppercase font-alpha"><img class="about_ico" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/mission_ico.png" alt=""> <b class="txt_xzt">Mission</b></h6>
									<p>
								Our organization achieve worldwide success. As a <b>SYSTEM INTEGRATOR</b>, we are driven by a mission to deliver the highest standard of product quality, performance, and customer value in the industry.</p>
																</div>
																<div class="hid col-xs-2">
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
								<div class="">
								<br/>
									<h6 class="col-xs-12 uppercase font-alpha"><img class="about_ico" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/vision_ico.png" alt="">  <b class="txt_xzt">Vision</b></h6>
									<p>
								<b>XTZ Enterprises</b> together with leading technology, strategic, and channel partners, provide an outstanding customer experience offering solutions with the depth and breadth required in today’s dynamic enterprise and service provider environments. </p>
								</div>
								<div class="hid col-xs-2">
									<div class="featured-icon">
										<figure class="shape-square">
											<i class="fa fa-database font-2x"></i>
										</figure>
									</div>
								</div>
							</div>					
						</div> <!-- /.fancy-features -->
					</div> <!-- /.col-sm-4 -->

					<div class=" col-sm-2">
						<div class="hid featured-logo">
							<div class="bg-alpha shape-square"></div>
						</div>
					</div> <!-- /.col-sm-4 -->
					<div class="col-sm-5">
						<div class="fancy-features">
							<div class="row row-fit">
								<div class="hid col-xs-2">
									<div class="featured-icon">
										<figure class="shape-square">
											<i class="fa fa-gear font-2x"></i>
										</figure>
									</div>
								</div>
								<div class="">
								
									<h6 class="col-xs-12 uppercase font-alpha "><img class="about_ico" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/offer_ico.png" alt="">  <b class="txt_xzt">Offer</b></h6>
									<p>
We are proud to offer standard and custom products from our <b>PARTNER</b> as well as <b>PRINCIPAL</b> as well as local distributors to help you create a brand identity for your business.</p>
								</div>
							</div>					
						</div> <!-- /.fancy-features -->

						<div class="fancy-features">
							<div class="row row-fit">
								<div class="hid col-xs-2">
									<div class="featured-icon">
										<figure class="shape-square">
											<i class="fa fa-list font-2x"></i>
										</figure>
									</div>
								</div>
								<div class="">
								
									<h6 class="col-xs-12 uppercase font-alpha "><img class="about_ico" src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/history_ico.png" alt="">  <b class="txt_xzt">&nbsp; &nbsp; History</b></h6>
									<p>
Since our founding, We have always been at the forefront of innovative ideas. That tradition continues today with our <b>vision, technology, ability, and focused dedication</b> to deliver an inclusive solution that spans the converged edge to the enterprise core and beyond. </p>
								</div>
							</div>					
						</div> <!-- /.fancy-features -->
					</div> <!-- /.col-sm-4 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</section> <!-- /.box -->

		<section id="products" class="box" style="background: #f0eceb;">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="fancy-title text-center uppercase">
							<h4 class="text-alpha">Products</h4>
						<!-- 	<h6 class="text-grey text-air">Lum elit sit amet est aenean dui</h6> -->
						</div>
					</div>
				</div> <!-- /.row -->

			

				<div class="row row-fit">
					<ul class="clean-list portfolio-loop" data-masonry="li">
						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/avaya.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.avaya.com" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.avaya.com"><b>www.avaya.com</b></a></h6>
									<span class="font-beta">VOIP SOLUTIONS</span>
									<br><p class = "xtz-alphatext"> Avaya is known as a leader in helping organizations around the world succeed by integrating communications with business strategy and operations. In fact, Avaya came about as an independent company so it could bring even more focus to innovating in business communications.</p>
								</div>
								</div>
							</div>
						</li>


						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/unify.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.unify.com" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.unify.com"><b>www.unify.com</b></a></h6>
									<span class="font-beta">VOIP SOLUTIONS</span>
									<br> <p class = "xtz-alphatext">Unify’s portfolio provides organizations with communications tools to foster rich and meaningful conversations across channels, platforms and media for a mobile, real-time and collaborative way to work. </p>
								</div>
								</div>
							</div>
						</li>

						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/gdata.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.gdatasoftware.com" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.gdatasoftware.com"><b>www.gdatasoftware.com</b></a></h6>
									<span class="font-beta">SECURITY SOLUTIONS</span>
									<p class = "xtz-alphatext">G DATA SOftware, with its head office in Bochum, is an innnovative and quickly expanding software house focusing on antivirus security solutions.</p>
								</div>
								</div>
							</div>
						</li>

						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/esset.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.eset.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.eset.com"><b>www.eset.com
</b></a></h6>
									<span class="font-beta">SECURITY SOLUTIONS</span>
									<p class = "xtz-alphatext">ESET is an IT security company that offers anti-virus and firewall products such as ESET NOD32. ESET is headquartered in Bratislava, Slovakia, and was awarded the recognition of the most successful Slovak company in 2008, 2009 and in 2010. It plays a significant role in overall Cybersecurity.</p>
								</div>
								</div>
							</div>
						</li>

						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/avigilon.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.avigilon.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.avigilon.com"><b>www.avigilon.com
</b></a></h6>
									<span class="font-beta">DATA BACKUP AND RECOVERY SOLUTIONS </span>
									<br><p class = "xtz-alphatext"><b>Avigilon</b> a Motorola Solutions company, designs, develops and manufactures advanced AI, video analytics, network video management software and hardware, surveillance cameras, and access control solutions.</p>
								</div>
								</div>
							</div>
						</li>

						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/dell.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.dell.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.dell.com"><b>www.dell.com
</b></a></h6>
									<span class="font-beta">ENTERPRISE SOLUTIONS </span>
									<br><p class = "xtz-alphatext">Many innovations begin in-house, led by a global team of top engineers, product designers and technical experts. Others begin as a team effort with Dell's strategic partners. </p>
								</div>
								</div>
							</div>
						</li>

						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/asus.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.asus.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.asus.com"><b>www.asus.com
</b></a></h6>
									<span class="font-beta">ENTERPRISE SOLUTIONS </span>
									<br><p class = "xtz-alphatext">ASUS continues to deliver on our In Search of Incredible promise as we strive to become the world’s most admired leading enterprise in the new digital era. Our In Search of Incredible campaign, launched in 2011, symbolizes our Design Thinking – Start with People philosophy. </p>
								</div>
								</div>
							</div>
						</li>
						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/hp.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.hp.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.hp.com"><b>www.hp.com
</b></a></h6>
									<span class="font-beta">ENTERPRISE SOLUTIONS </span>
									<p class = "xtz-alphatext">HP is passionate about making our research real – driving technology to commercialization in the areas most important to our customers and society. We are driven to create solutions that transform data into value, bytes into experiences, noise into knowledge.</p>
								</div>
								</div>
							</div>
						</li>

						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/lenovo.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.lenovo.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.lenovo.com"><b>www.lenovo.com
</b></a></h6>
									<span class="font-beta">ENTERPRISE SOLUTIONS </span>
									<p class = "xtz-alphatext">Lenovo is one of the world’s largest makers of personal computers and makes the world's most innovative PCs, including the renowned ThinkPad® notebook as well as products carrying the ThinkCentre®, ThinkStation®, ThinkServer®, IdeaCentre® and IdeaPad® sub-brands.</p>
								</div>
								</div>
							</div>
						</li>


						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/eaton.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.eaton.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.eaton.com"><b>www.eaton.com
</b></a></h6>
									<span class="font-beta">
POWER MANAGEMENT SOLUTIONS  </span>
<p class = "xtz-alphatext">power quality portfolio encompasses a comprehensive offering of power management solutions from a single-source provider. This includes uninterruptible power supplies (UPSs), DC power solutions, surge protective devices, switchgear, power distribution units (PDUs), remote monitoring, meters, software, connectivity, enclosures and services.</p>
								</div>
								</div>
							</div>
						</li>


						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/hikvision.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.hikvision.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.hikvision.com"><b>www.hikvision.com
</b></a></h6>
									<span class="font-beta">CCTV SOLUTIONS   </span>
									<p class = "xtz-alphatext">Hangzhou Hikvision Digital Technology Co., Ltd. is a Chinese manufacturer and world's largest supplier of video surveillance products based in Hangzhou, China. Its controlling shares are owned by the Chinese government.</p>
								</div>
								</div>
							</div>
						</li>

												<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/sangfor.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.sangfor.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.sangfor.com"><b>www.sangfor.com
</b></a></h6>
									<span class="font-beta">
END-TO-END: NETWORK SECURITY SOLUTION </span> 
<p class = "xtz-alphatext">Founded in 2000, Sangfor is the leading and largest vendor of Network Security, Management & Optimization solutions in Asia and is committed to provide continuous innovative                                 	    network solutions.</p>
								</div>
								</div>
							</div>
						</li>

													<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/sundray.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.sundray.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.sundray.com"><b>www.sundray.com
</b></a></h6>
									<span class="font-beta">
END-TO-END: NETWORK SECURITY SOLUTION</span>
<p class = "xtz-alphatext">Sundray Technology Co., Ltd. is the best aa-in-one Enterprise WLAN vendor(3500+employees), the Chinese top 3 Enterprise WLAN vendor, the fastest-growing WLAN vendor.</p>
								</div>
								</div>
							</div>
						</li>


						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/appliansys.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.appliansys.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.appliansys.com"><b>www.appliansys.com
</b></a></h6>
									<span class="font-beta">
END-TO-END: NETWORK SECURITY SOLUTION</span>
<p class = "xtz-alphatext">ApplianSys, founded in 2000, is a privately held venture capital-backed technology company based in Coventry, United Kingdom. It designs, builds and markets Internet server appliances that are deployed in more than 150 countries.</p>
								</div>
								</div>
							</div>
						</li>


						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/commoscope.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.commoscope.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.commoscope.com"><b>www.commoscope.com
</b></a></h6>
									<span class="font-beta">
STRUCTURED CABLING SOLUTIONS </span> <p class = "xtz-alphatext">CommScope Inc., which opened in 1976, is a multi-national network infrastructure provider company based in Hickory, North Carolina, United States. CommScope is a 1997 spin-off of General Instrument and has over 20,000 employees worldwide, with customers in over 130 countries. </p>
								</div>
								</div>
							</div>
						</li>

						<li class="col-md-3 col-sm-4 col-xs-6 artworks">
							<div class="portfolio-item text-center" data-portfolio-date="1" data-portfolio-type="video">
								<figure>
									<img src="<?php echo Yii::$app->homeUrl;?>added/xtz/images/product_logo/siemon.png" alt="">
								</figure>
								<div class="portfolio-front">
									<div class="bg-alpha-xzt">
									</div>
										<div class="featured-icon">
											<figure class="shape-square">
												<a href="https://www.siemon.com
" class="bg-white zoom-img" data-strip-group="" data-strip-options="side: 'top'"><i class="icon-367 font-2x"></i></a>
											</figure>
										</div>
								<div class="text-center uppercase bg-white">
									<h6 class="no-margin font-alpha"><a href="https://www.siemon.com"><b>www.siemon.com
</b></a></h6>
									<span class="font-beta">
STRUCTURED CABLING SOLUTIONS </span> <p class = "xtz-alphatext">The Siemon Company, which opened in 1903, designs and manufactures IT infrastructure solutions and services for Data Centers, Local Area Networks and Intelligent Buildings. The Siemon Company offers copper and optical fiber cabling systems, cabinets, racks, cable management, data center power and cooling systems.</p>
								</div>
								</div>
							</div>
						</li>
					</ul>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</section> <!-- /.box -->




		<section id="contact" class="box">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="fancy-title text-center">
							<h4 class="text-alpha">CONTACT XTZ</h4>
							<h6 style ="font-size: 15px;" class="text-grey text-air">YOU COULD CONTACT US ON THE FF. DETAILS</h6>
							<h5 style ="font-size: 15px;">Telephone #: (02)796-6294 / (02)904-4711</h6>
							<h6 style ="font-size: 15px;"class="text-grey">OR</h6>
							<h5 style ="font-size: 15px;">Mobile #: +639778090906 / +639338124841 / +639175022321</h6>
								<h6 style ="font-size: 15px;" class="text-grey">OR EMAIL US @</h6>
							<h5 style ="font-size: 15px;">sales@xtzbusiness.ph</h6>
							<h6  style ="font-size: 15px;"class="text-grey">OR YOU COULD VISIT US @</h6>
							<h5 style ="font-size: 15px;">2F, Unit 201, BFB Bldg., 1575 JP Laurel St., San Miguel, Manila</h6>
							
							<h6 style ="font-size: 15px;" class="text-grey">OR YOU COULD CONTACT US VIA THIS FORM</h6>
							
						
					</div>
				</div> <!-- /.row -->

				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="space-2x"></div>
						<h6 class="font-alpha uppercase text-center"><b>Send us your thoughts</b></h6>
						<hr class="hr-10 align-center">
						<form action="<?php echo Url::to(['/frontend/sendconcern']);?>" method="POST" class="slim-form full-inputs row">
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
								
							</p>

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
						</form>
					</div>
				</div> <!-- /.row -->

				<div class="hid row">
					<div class="col-md-12">
						<div class="space-4x"></div>
						<div class="vector-map">
							<div class="map"></div>
						</div>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</section> <!-- /.box -->

		<footer class="main-footer">
			<section class="footer-social bg-alpha">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<ul class="inline-list social-networks align-center text-white">
								<li class="facebook-network">
									<a href="#facebook"><i class="icon-182"></i></a>
								</li>
								<li class="instagram-network">
									<a href="#instagram"><i class="icon-271"></i></a>
								</li>
								<li class="twitter-network">
									<a href="#twitter"><i class="icon-510"></i></a>
								</li>
								<li class="youtube-network">
									<a href="#youtube"><i class="icon-548"></i></a>
								</li><!-- 
								<li class="vimeo-network">
									<a href="#vimeo"><i class="icon-526"></i></a>
								</li>
								<li class="dribbble-network">
									<a href="#dribbble"><i class="icon-158"></i></a>
								</li> -->
							</ul>
						</div>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</section> <!-- /.footer-social  -->

			<section class="footer-menu-box">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<ul class="inline-list footer-menu align-center uppercase">
									<li>
										<a href="#">Home</a>
									</li>
		<!-- 							<li>
										<a href="#">Intro</a>
									</li> -->
									<li>
										<a href="#about">About</a>
									</li>
<!-- 									<li>
										<a href="#">Services</a>
									</li>
									<li>
										<a href="#">Team</a>
									</li> -->
<!-- 									<li>
										<a href="#">History</a>
									</li> -->
									<li>
										<a href="#products">Product</a>
									</li>
<!-- 									<li>
										<a href="#">Prices</a>
									</li> -->
									<li>
										<a href="#contact">Contact</a>
									</li>
<!-- 									<li>
										<a href="#">Blog</a>
									</li>
 -->							</ul>
						</div>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</section> <!-- /.footer-menu -->

			<section class="footer-copyright">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<p class="copyright align-center text-center uppercase">
								<span>copyright 2014 </span>
								<a style="color: #fff;" href="#">XTZ </a>
								<span> designed by </span>
								<a href="http://Solutionbase Corp.com" style="color: #fff;">Solutionbase Corp</a>	
							</p>
						</div>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</section> <!-- /.footer-copyright -->
		</footer> <!-- /.main-footer -->

	</div> <!-- /#home -->
	

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

</body>
<?php $this->endBody() ?>
<?php $this->endPage() ?>

