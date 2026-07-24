<?php
$this->title = 'Product List';
use yii\helpers\Url;
use yii\base\ErrorException;

switch ($_GET['type']) {
  case 'brand': case 'highlight':
    $this->params['getlane'] = '';
    break;
  
  default:
    $this->params['getlane'] = Yii::$app->frontend->verifyWhatLane($_GET['v']);
    break;
}//end  
?>

<div class="category-title">
<ul class="bxslider">
<?php
  if(!empty($slider)){
    foreach ($slider as $key => $value) {
      $pic = Yii::$app->homeUrl . 'frontendassets/steamlayout/products-images/productlistbanner.jpg';
      if($value['strimg'] != ""){
        $pic = $value['strimg'];
      }//end if
      echo '<li><img src="'.$pic.'"/></li>';
    }//end for each
  }else{
    $pic = Yii::$app->homeUrl . 'frontendassets/steamlayout/products-images/productlistbanner.jpg';
    echo '<li><img src="'.$pic.'"/></li>';
  }//end for each
?>

</ul>
<!-- <h1>TOPS &amp; TEES</h1> -->
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
            <?php
            try {
            if(empty($productlisting)){
              switch (strtoupper($_GET['type'])) {
                case 'BRAND':
                  $type = 'brand.';
                  break;
                
                case 'CATEGORY':
                  $type = 'category.';
                break;

                case 'LANE':
                  $type = 'lane.';
                break;

                case 'HIGHLIGHT':
                  $type = 'highlight.';
                break;
              }//END SWITCH
              //echo $type;
              echo '<h3 style="text-align:center;">No items found under this '.$type.'</h2>';
              echo '<br>';
            }else{
            echo '<ul class="products-grid">';
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
                  
                  echo '<div class="product-image-area"> 
                  <a class="product-image" title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'"> 
                  <img src="'.$pic.'" class="img-responsive" alt="a" /> </a>
                    <div class="hover_fly"> 
                    <a id="'.$value['barcode'].'~'.$value['type'].'~'.$value['md5id'].'" class="add-to-cart exclusive" role="button" title="Add to cart">
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
            echo '</ul>';
            }//end if empty product listing
            } catch (ErrorException $e) {
              echo $e;
            }
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

            
          </div>