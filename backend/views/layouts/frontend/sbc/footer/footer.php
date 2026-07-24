<?php
use yii\base\ErrorException;


try {
?>
<footer class="main-footer">
			<section class="footer-social bg-alpha">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<ul class="inline-list social-networks align-center text-white">
								<li class="facebook-network">
									<a href="https://www.facebook.com/solutionbasecorp.official/" target="_blank"><i class="icon-182"></i></a>
								</li>
								<!-- <li class="instagram-network">
									<a href="#instagram"><i class="icon-271"></i></a>
								</li>
								<li class="twitter-network">
									<a href="#twitter"><i class="icon-510"></i></a>
								</li>
								<li class="youtube-network">
									<a href="#youtube"><i class="icon-548"></i></a>
								</li>
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
									<li>
										<a href="#">Featured</a>
									</li>
									<li>
										<a href="#">About</a>
									</li>
									<li>
										<a href="#">Services</a>
									</li>
								
									
									<li>
										<a href="#">Solutions</a>
									</li>
									
										<a href="#">Contact</a>
									</li>
									
							</ul>
						</div>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</section> <!-- /.footer-menu -->

			<section class="footer-copyright">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<p class="copyright align-center text-center uppercase">
								<span>copyright@2008 solutionbasecorp </span>						
							</p>
						</div>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</section> <!-- /.footer-copyright -->
		</footer> <!-- /.main-footer -->
		<?php

	
} catch (ErrorException $e) {
	echo $e;
}
		?>