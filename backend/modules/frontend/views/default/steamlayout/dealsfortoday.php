<?php
use yii\helpers\Url;
$this->title = "Deals for Today";
$defaultimg = Yii::$app->homeUrl.'frontendassets/steamlayout/images/b-logo1.png';
?>



  <section class="content-wrapper">
    <div class="container">
      <div class="std">
      	<br>
      	<br>
      	<div class="category-title">
      		<ul class="bxslider">
			<?php
			if(!empty($slider)){
				$pic = $slider[0]['strimg'];
			}else{
				$pic = Yii::$app->homeUrl . 'frontendassets/steamlayout/images/slide-img2.jpg';
			}//end if
			echo '<li><img src="'.$pic.'"/></li>';
			?>
			</ul>
			<!-- <div id="flashdeal-timer"></div> -->
      	</div>

      	<div class="category-products">
        	<?php
        	  if(!empty($productlisting)){
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
	                  echo '<div class="product-image-area"> <a class="product-image" title="'.$value['itemname'].'" href="'.Url::to(['/frontend/productdetail/', 'sku' => $value['barcode']]).'"> <img src="'.$pic.'" class="img-responsive" alt="a" /> </a>
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
	            }else{
	            	echo '<h3 style="text-align:center;">No available deals for today!</h2>';
              		echo '<br>'; 	
	            }//end if !empty
		    ?>    
		  	</div>
	    <br>
	    <br>

      </div>
    </div>
  </section>

