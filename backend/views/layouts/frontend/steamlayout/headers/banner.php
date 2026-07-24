<?php
use yii\helpers\Url;
?>
<div class="offer-banner-section animated">
    <div class="container">
      

      <div class="row">
          <div id="myCarousel" class="carousel slide">
            <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                  <?php
                  $strhtml = "";
                  $banners = Yii::$app->frontend->getAvailableBanners();

                  if(empty($banners)){
                      $strhtml = $strhtml . '<div class="item active">';
                      $strhtml = $strhtml . '<img src="'.$bannerputter.'" width="" height="">';
                      $strhtml = $strhtml . '<div class="hid carousel-caption">';
                      $strhtml = $strhtml . '<h3></h3>';
                      $strhtml = $strhtml . '<p></p>';
                      $strhtml = $strhtml . '</div>';
                      $strhtml = $strhtml . '</div>';
                  }else{
                      foreach ($banners as $key => $banner) {
                      $bannerputter = Yii::$app->homeUrl . "frontendassets/steamlayout/images/slide-img2.jpg";
                          if($banner['strimg'] != ""){
                            $bannerputter = $banner['strimg'];
                          }//end if
                          
                          if($key == 0){
                            $strhtml = $strhtml . '<div class="item active">';
                          }else{
                            $strhtml = $strhtml . '<div class="item">';
                          }//end if

                          $strhtml = $strhtml . '<img src="'.$bannerputter.'" width="" height="">';
                          $strhtml = $strhtml . '<div class="hid carousel-caption">';
                          $strhtml = $strhtml . '<h3></h3>';
                          $strhtml = $strhtml . '<p></p>';
                          $strhtml = $strhtml . '</div>';
                          $strhtml = $strhtml . '</div>';
                      }//end for each
                  }//end if

                  echo $strhtml;
                  ?>

              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" role="button">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" role="button">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
                  <!-- Indicators -->
              <ol class="carousel-indicators">
              <?php
                $indices = 0;
                $slideto = 0;
                 if(empty($banners)){
                      $indices += 1;
                      echo '<li slideto="'.$slideto.'" class="bannerindicator bannerindicator'.$indices.' active"></li>';
                }else{
                    foreach ($banners as $key => $banner) {
                      $indices += 1;
                      if($indices == 1){
                        echo '<li slideto="'.$slideto.'" class="bannerindicator bannerindicator'.$indices.' active"></li>';
                      }else{
                        echo '<li slideto="'.$slideto.'" class="bannerindicator bannerindicator'.$indices.'"></li>';
                      }//end if
                      $slideto += 1;
                    }//end for each
                }//end if
              ?>
              </ol>
            </div>
   
      </div>


     
<!-- 
      <div class="row" style="border: solid 1px green;">
        <div class="pull-left animated animated" >
        <?php
        //$dod = Yii::$app->frontend->getAvailableDODHeader();
        //if(!empty($dod)){
          //echo '<a href="'.Url::to(['/frontend/products/', 'type' => 'dod','v'=>$dod[0]['dodid']]).'">
          //<img style="height:227px;" width="" src="'.$dod[0]['primarypic'].'" alt="offer banner3">
          //</a>';
        //}else{
          //echo '<a href="'.Url::to(['/frontend/mycart/']).'">
          //<img style="height:227px;" width="573" src="'.Yii::$app->homeUrl .'frontendassets/steamlayout/images/viewmycart.jpg" alt="offer banner3">
          //</a>';
        //}//end if 
        ?>
        </div>

        <div class="pull-right animated animated">
        <a href="#"><img style="height:227px;" width="573" src="<?php //echo Yii::$app->homeUrl; ?>frontendassets/steamlayout/images/flashdeal.jpg" alt="offer banner3"></a>
        </div>
      </div> -->

    </div> <!-- END CONTAINER -->
  </div> <!-- END OFF BANNER SECTION -->