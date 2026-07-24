<?php
$this->title = 'Product List';
use yii\helpers\Url;
$this->params['getlane'] = '';
?>
<div class="category-title">
<h1>You have searched for "<?php echo $_GET['q'];?>"</h1>
</div>

          <div class="category-products">
 <!--            <div class="toolbar">
              <div id="sort-by">
                <label class="left">Sort By: </label>
                <ul>
                  <li><a href="#">Position<span class="right-arrow"></span></a>
                    <ul>
                      <li><a href="#">Name</a></li>
                      <li><a href="#">Price</a></li>
                      <li><a href="#">Position</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div id="limiter">
                  <label>View: </label>
                  <ul>
                    <li><a href="#">15<span class="right-arrow"></span></a>
                      <ul>
                        <li><a href="#">20</a></li>
                        <li><a href="#">30</a></li>
                        <li><a href="#">35</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
            </div> -->


            <ul class="products-grid">

            <?php
            if(!empty($productlisting)){
                 foreach ($productlisting as $key => $value) {
                    $pic = Yii::$app->homeUrl . 'frontendassets/steamlayout/products-images/product1.jpg';
                    if($value['picture'] != ''){
                        $pic = $value['picture'];
                    }//end 

                    echo '<li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6">
                      <div class="col-item">';
                        if($value['issale']){
                        echo '<div class="sale-label sale-top-right">Sale</div>';
                        }
                        echo '<div class="product-image-area"> <a class="product-image" title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'"> <img src="'.$pic.'" class="img-responsive" alt="a" /> </a>
                          <div class="hover_fly"> 
                          <a id="'.$value['barcode'].'" class="add-to-cart exclusive" role="button" title="Add to cart">
                            <div><i class="icon-shopping-cart"></i><span>Add to cart</span></div>
                          </a> 
                          <a class="quick-view" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'">
                            <div><i class="icon-eye-open"></i><span>Quick view</span></div>
                          </a> 
                          </div>
                        </div>
                        <div class="info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'">'.$value['itemname'].'</a> </div>
                            <!--item-title-->
                            <div class="item-content">
                              
                              <div class="price-box">';
                                if($value['issale']){
                                  echo '<p class="special-price"> <span class="price">'.$value['saleprice'].'</span> </p>';
                                  echo '<p class="old-price"> <span class="price-sep">-</span> <span class="price">'.$value['amt'].'</span> </p>';
                                }else{
                                  echo '<p class="special-price"> <span class="price">'.$value['amt'].'</span> </p>';
                                }//end is is sale
                              echo '</div>
                            </div>
                            <!--item-content--> 
                          </div>
                          <!--info-inner-->
                          
                          <div class="clearfix"> </div>
                        </div>
                      </div>
                    </li>';
                  }//end for each
            }else{
                echo '<h3 style="text-align:center;">No search results for "'.$_GET['q'].'"</h2>';
            }//end if empty
            ?>


            <!-- <div class="ratings">
                          <div class="rating-box">
                            <div class="rating"></div>
                          </div>
                        </div> -->

            <!-- <a class="add_to_compare" href="compare.html">
                      <div><i class="icon-random"></i><span>Add to compare</span></div>
                    </a> 
                    <a class="addToWishlist wishlistProd_5" href="wishlist.html" >
                      <div><i class="icon-heart"></i><span>Add to Wishlist</span></div>
                    </a>  -->

            </ul>
          </div>