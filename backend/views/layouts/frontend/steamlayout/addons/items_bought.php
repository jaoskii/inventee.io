<!-- PERSONALLY PICKED MENU -->
<?php 
use yii\helpers\Url;
?>
  
          
          <?php
          if(!empty(Yii::$app->session['personallypicked'])){
            echo '<section class="featured-pro container wow bounceInUp animated">
                    <div class="slider-items-products">
                      <div class="new_title center">
                        <h2>PEOPLE WHO BOUGHT THIS ITEM ALSO BOUGHT</h2>
                      </div>
                      <div id="featured-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col4">';
          foreach (Yii::$app->session['personallypicked'] as $key => $value) {
            $pic = Yii::$app->homeUrl . 'frontendassets/steamlayout/products-images/product1.jpg';
            if($value['picture'] != ""){
              $pic = $value['picture'];
            }//end if
            echo '<!-- Item -->';
            echo '<div class="item" style="margin-bottom:3px;">';
              echo '<div class="col-item">';
                 if($value['issale']){
                  echo '<div class="sale-label sale-top-right">Sale</div>';
                  }
                echo '<div class="product-image-area"> <a class="product-image" title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'"> <img src="'.$pic.'" class="img-responsive" alt="a" /> </a>';
              /*    echo '<div class="actions-links"><span class="add-to-links"> 
                  <a title="magik-btn-quickview" class="magik-btn-quickview" href="quick_view.html"><span>quickview</span></a> 
                  <a title="Add to Wishlist" class="link-wishlist" href="wishlist.html"><span>Add to Wishlist</span></a> 
                  <a title="Add to Compare" class="link-compare" href="compare.html"><span>Add to Compare</span></a></span> </div>';*/
                echo '</div>';
                echo '<div class="info">';
                  echo '<div class="info-inner">';
                    echo '<div class="item-title"> <a title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'">'.$value['itemname'].'</a> </div>';
                    echo '<!--item-title-->';
                    echo '<div class="item-content">';
                      /*echo '<div class="ratings">';
                        echo '<div class="rating-box">';
                          echo '<div class="rating"></div>';
                        echo '</div>';
                      echo '</div>';*/
                      echo '<div class="price-box">';
                        if($value['issale']){
                          echo '<p class="special-price"> <span class="price">'.$value['saleprice'].'</span> </p><br>';
                          echo '<p class="old-price"> <span class="price-sep">-</span> <span class="price">'.$value['amt'].'</span> <label style="font-size:9px;">('.$value['fdiscounted'].')</label></p>
                          ';
                        }else{
                          echo '<p class="special-price"> <span class="price">'.$value['amt'].'</span> </p><br>';
                          echo '<p class="old-price"><label style="font-size:9px;">&nbsp</label></p>';
                        }//end if is sale
                      echo '</div>';
                    echo '</div>';
                    echo '<!--item-content--> ';
                  echo '</div>';
                  echo '<!--info-inner-->';
                  echo '<div class="actions">';
                    echo '<button id="'.$value['barcode'].'" type="button" title="Add to Cart" class="button add-to-cart btn-cart"><span>Add to Cart</span></button>';
                  echo '</div>';
                  echo '<!--actions-->';
                  
                  echo '<div class="clearfix"> </div>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
            echo '<!-- End Item --> ';
          }
          echo '</div>
            </div>
          </div>
        </section>
        <br>
        <br>';
        }//end if

          ?>
  <!-- End PERSNOLLAY PICKED  --> 