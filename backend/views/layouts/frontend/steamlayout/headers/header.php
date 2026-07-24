<?php
use yii\helpers\Url;
?>

<!-- Header -->
  <header class="header-container">
    <div class="header-top">
      <div class="container">
        <div class="row"> 
          <!-- Header Language -->
          <div class="col-xs-6">
            <?php
            if(isset(Yii::$app->session['customerdata'])){
               echo '<div class="welcome-msg hidden-xs"> Welcome, '.Yii::$app->session['customerdata']['customername'].'</div>';
            }else{
               echo '<div class="welcome-msg hidden-xs"> Welcome Guest!</div>';
            }
            ?>
           
          </div>
          <div class="col-xs-6"> 
            
            <!-- Header Top Links -->
            <div class="toplinks">
              <div class="links">
                <?php
                if(isset(Yii::$app->session['customerdata'])){
                  echo '<div class="myaccount"><a title="Dashboard" href="'.Url::to(['/frontend/customerdashboard/']).'"><span class="hidden-xs">Dashboard</span></a></div>';
                  /*echo '<div class="wishlist"><a title="My Wishlist"  href="'.Url::to(['/frontend/customerdashboard/','q'=>'wishlist']).'"><span class="hidden-xs">Wishlist</span></a></div>';*/
                  echo '<div class="check"><a title="Checkout" href="'.Url::to(['/frontend/checkout','step' => 1]).'"><span class="hidden-xs">Checkout</span></a></div>';
                  echo '<div class="logout"><a href="'.Url::to(['/frontend/flogout/']).'" title="Logout">';
                  echo '<span class="hidden-xs">Logout</span></a></div>';
                }else{
                  echo '<div class="login"><a href="'.Url::to(['/frontend/signin/']).'" title="Login">';
                  echo '<span class="hidden-xs">Log In</span></a></div>';
                }
                ?>
                <!-- <div class=""><a title="Contact Us" href="<?php echo Url::to(['/frontend/contact/']);?>"><span class="hidden-xs">Contact us</span></a></div> -->
                <div class=""><a title="About Us" href="<?php echo Url::to(['/frontend/about/']);?>"><span class="hidden-xs">About us</span></a></div>
              </div>
            </div>
            <!-- End Header Top Links --> 
          </div>
        </div>
      </div>
    </div>
    <div class="header container">
      <div class="row">
        <div class="col-lg-2 col-sm-3 col-md-2"> 
          <!-- Header Logo --> 
          <a class="logo" title="SBCommerce" href="<?php echo Url::to(['/']);?>"><img alt="SBCommerce" src="<?php echo Yii::$app->homeUrl; ?>fimages/logo/logo.jpg"></a> 
          <!-- End Header Logo --> 
        </div>
        <div class="col-lg-8 col-sm-6 col-md-8"> 
         
          <!-- Search-col -->
          <div class="search-box">
            <form action="<?php echo Url::to(['/frontend/products']);?>" method="GET" id="search_mini_form" name="searchform">
              <select name="lane" class="cate-dropdown hidden-xs">
                <option value="ALL">All Lanes</option>
                <?php
                foreach (Yii::$app->session['lanes'] as $key => $value) {
                  echo '<option value="'.$value['navid'].'">'.$value['nav_desc'].'</option>';
                }//END FOR EACH
                ?>

              </select>
              <input type="hidden" name="type" value="search">
              <input type="text" placeholder="Search here..." value="" maxlength="70" class="" name="q" id="search">
              <button id="submit-button" class="search-btn-bg"><span>Search</span></button>
            </form>
          </div>
          <!-- End Search-col --> 
        </div>



      </div>
    </div>
  </header>
  <!-- end header --> 