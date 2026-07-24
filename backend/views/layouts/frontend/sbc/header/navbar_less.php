<?php
use yii\helpers\Url;
?>

<header class="main-header" data-sticky="true" style="height: auto;">
          <section class="header-navbar bg-alpha" data-menu-scroll="true">
            <div class="container">
              <div class="row">
                <div class="col-sm-2 col-xs-4">
                  <figure class="identity">
                    <a href="<?php echo Url::to(['/']); ?>">
                      <?php 
                        echo '<img alt="Theme logo" src="'.Yii::$app->homeUrl."added/sbc/images/logo.png".'">';
                      ?>
                    </a>
                  </figure>
                </div> <!-- /.col-2 -->
                
                <div class="col-sm-10 col-xs-8">
                  <nav class="main-nav">
                    <a href="#" class="responsive-menu align-right">
                      <i class="seemered icon-333 font-2x text-white">
                      </i>
                    </a>
                    <ul class="inline-list align-right uppercase"> 
                      <li>
                        <a href="<?php echo Url::to(['/']); ?>">Home</a>
                      </li>
                      <!-- <li>
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