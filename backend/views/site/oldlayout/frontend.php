<?php
    /* @var $this yii\web\View */
    // an alias of a file path
    //Yii::setAlias('@foo', '/path/to/foo');
    // an alias of a URL
    //Yii::setAlias('@bar', 'http://www.example.com');
    //Note: The file path or URL being aliased may not necessarily refer to an existing file or resource. 
    //Yii::setAlias('@foobar', '@foo/bar');
use yii\helpers\Html;
use yii\helpers\Url;
?>
   
    <div class="body-content">
        <div class="col-sm-9 padding-right">
        
            <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Top Solutions</h2>
                    <?php
                        foreach($topitems as $topitem){
                        echo ' <div class="col-sm-3 item_box">
                        <div class="product-image-wrapper ">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                     <a href="'.Url::to([''.Yii::$app->homeUrl.'/frontend/default/productdetail','itmb'=>$topitem['barcode']]).'"><img src="'.Yii::$app->homeUrl.'/frontendassets/images/home/product1.jpg" /></a>
                                        <p class="item_desc">'.$topitem['itemname'].'
                                            <h2>Php.'.number_format($topitem['amt'],2).'  <span class="divider">|</span>  <button title="Add to cart" id = "'.$topitem['barcode'].'"class=" btn-success add-to-cart"><i class="fa fa-shopping-cart" ></i>+</button></h2>
                                        </p>
                                    </div>
                                 </div>
                            
                             </div> 
                         </div>';
                        }
                    ?>
                    
            </div><!--features_items-->
            <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">New Solution</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                <?php 
                                for($itemindex = 0; $itemindex < 3; $itemindex += 1){
                                echo '<div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="'.Yii::$app->homeUrl.'/frontendassets/images/home/recommend3.jpg" alt="" />
                                                    <button id = "'.$topitems[$itemindex]['barcode'].'"class="btn btn-success add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                    <h4>php '.number_format($topitems[$itemindex]['amt'],2,".",",").'</h4>
                                                    <p class="text-center">'.$topitems[$itemindex]['itemname'].'</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }?>
                                </div>
                            </div><!--END CAROUSEL -->

                            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>			
                    </div>
            </div><!--/recommended_items-->          
        </div>
    </div>

