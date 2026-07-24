<?php
use yii\helpers\Url;
?>
<section class="middle-slider container animated">
    <div class="row">

      <div class="col-md-8">
        <div class="category-title">
          <h1>HIGHLIGHTS</h1>
        </div>
      </div>

       <div class="col-md-4">
        <div class="category-title">
          <h1>MOST REVIEWED</h1>
        </div>
      </div>

      <?php
        $fhighlights = Yii::$app->frontend->retrieveHighlights('featured');
        $counthiglight = 0;
        if(!empty($fhighlights)){
          foreach ($fhighlights as $key => $value) {
            echo '<div class="col-lg-4 col-xs-12 col-sm-4 animated animated">
            <a href="'.Url::to(['/frontend/products/', 'type' => 'highlight','v'=>$value['highkey']]).'">
            <img style="height:370px;" width="380" src="'.$value['primarypic'].'" alt="offer banner3">
            </a>
            </div>';
          $counthiglight += 1;
          }//end for each
          
          if($counthiglight != 2){
            $a = array(0,1);
            $random = array_rand($a,1);
            
            switch ($random) {
              case '0': //WILL SHOW (SHOW ALL CATEGORIES) LINK
                $src = Yii::$app->homeUrl.'frontendassets/steamlayout/images/viewallbrands.jpg';
                $url = Url::to(['/frontend/listing/', 'z' => 'brands']);
                break;
              case '1': //WILL SHOW (SHOW ALL BRANDS) LINK
                $url = Url::to(['/frontend/listing/', 'z' => 'category']);
                $src = Yii::$app->homeUrl.'frontendassets/steamlayout/images/viewallcat.jpg';
                break;
            }//end switch

            echo '<div class="col-lg-4 col-xs-12 col-sm-4 animated animated">
            <a href="'.$url.'">
            <img style="height:370px;" width="380" src="'.$src.'" alt="offer banner3">
            </a>
            </div>'; 
          }//end if
        }else{
            $src1 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/viewallbrands.jpg';
            $src2 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/viewallcat.jpg';
            
            echo '<div class="col-lg-4 col-xs-12 col-sm-4 animated animated">
            <a href="'.Url::to(['/frontend/listing/', 'z' => 'brands']).'">
            <img style="height:370px;" width="380" src="'.$src1.'" alt="offer banner3">
            </a>
            </div>'; 

            echo '<div class="col-lg-4 col-xs-12 col-sm-4 animated animated">
            <a href="'.Url::to(['/frontend/listing/', 'z' => 'category']).'">
            <img style="height:370px;" width="380" src="'.$src2.'" alt="offer banner3">
            </a>
            </div>'; 
        }//end if
      ?>

      <div class="col-md-4">
        <div class="shoes-product-slider small-pr-slider cat-section">
          <div class="slider-items-products">
            <div class="new_title center">
              
            </div>
            <div id="shoes-slider" class="product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col3"> 
                <?php
                foreach (Yii::$app->session['mostreviewed'] as $key => $value) {
                  $pic = Yii::$app->homeUrl . 'frontendassets/steamlayout/products-images/product1.jpg';
                  if($value['picture'] != ""){
                    $pic = $value['picture'];
                  }//end if

                  echo '<!-- Item -->';
                  echo '<div class="item">';
                    echo '<div class="col-item">';
                      if($value['issale']){
                      echo '<div class="sale-label sale-top-right">Sale</div>';
                      }
                      echo '<div class="product-image-area"> 
                      <a class="product-image" title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'"> 
                      <img src="'.$pic.'" class="img-responsive" alt="a" /></a>';
                        /*echo '<div class="actions-links"><span class="add-to-links"> 
                        <a title="magik-btn-quickview" class="magik-btn-quickview" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'"><span>quickview</span></a> 
                        <a title="Add to Wishlist" id="btnwishlist-'.$value['barcode'].'" class="btnwishlist link-wishlist clickable"><span>Add to Wishlist</span></a> 
                        <a title="Add to Compare" id="btncompare-'.$value['barcode'].'" class="btncompare link-compare clickable"><span>Add to Compare</span></a></span> 
                        </div>';*/
                      echo '</div>';
                      echo '<div class="info">';
                        echo '<div class="info-inner">';
                          echo '<div class="item-title"> 
                          <a title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'">'.$value['itemname'].'</a>
                          </div>';
                          echo '<!--item-title-->';
                          echo '<div class="item-content">';
                           /* echo '<div class="ratings">';
                              echo '<div class="rating-box">';
                                echo '<div class="rating"></div>';
                              echo '</div>';
                            echo '</div>';*/
                            echo '<div class="price-box">';
                              if($value['issale']){
                                echo '<p class="special-price"> <span class="price">'.$value['saleprice'].'</span> </p><br>';
                                echo '<p class="old-price"> <span class="price-sep">-</span><span class="price">'.$value['amt'].'</span>
                                <label style="font-size:9px;">('.$value['fdiscounted'].')</label></p>';
                              }else{
                                echo '<p class="special-price"> <span class="price">'.$value['amt'].'</span> </p><br>';
                                echo '<p class="old-price"><label style="font-size:9px;">&nbsp</label><br>
                                </p>';
                              }//end if is sale
                            echo '</div>';
                          echo '</div>';
                          echo '<!--item-content--> ';
                        echo '</div>';
                        echo '<!--info-inner-->';
                        echo '<div class="actions">';
                          echo '<button id="'.$value['barcode'].'" type="button" title="Add to Cart" class="add-to-cart button btn-cart"><span>Add to Cart</span></button>';
                        echo '</div>';
                        echo '<!--actions-->';
                        
                        echo '<div class="clearfix"> </div>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                  echo '<!-- End Item --> ';
                }//end for each
                ?>

                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>