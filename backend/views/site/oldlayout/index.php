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
        <div class="col-md-12">
            <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">New Solution</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                <?php 
                                for($itemindex = 0; $itemindex < 3; $itemindex += 1){
                                if($topitems[$itemindex]['picture'] == "" || $topitems[$itemindex]['barcode'] == null){
                                   $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                }else{
                                   $str = $topitems[$itemindex]['picture'];
                                }
                                
                                echo '<div class="col-sm-4">
                                        <div class="product-image-wrapper ">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                 <a href="'.Url::to(['/frontend/productdetail','itmb'=>$topitems[$itemindex]['barcode']]).'"><img src="'.$str.'" class="prod_pic"/></a>
                                                    <p class="item_desc">'.$topitems[$itemindex]['itemname'].'
                                                        <h2>Php.'.number_format($topitems[$itemindex]['amt'],2).'  <span class="divider">|</span>  <button title="Add to cart" id = "'.$topitems[$itemindex]['barcode'].'"class=" btn-success add-to-cart"><i class="fa fa-shopping-cart" ></i>+</button></h2>
                                                    </p>
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
            
            <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Top Solutions</h2>
                    <?php
                        foreach($topitems as $topitem){
                        if($topitem['picture'] == "" || $topitem['picture'] == null){
                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                        }else{
                            $str = $topitem['picture'];
                        }
                        echo ' <div class="col-sm-3 item_box">
                        <div class="product-image-wrapper ">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                     <a href="'.Url::to(['/frontend/productdetail','itmb'=>$topitem['barcode']]).'"><img src="'.$str.'" class="prod_pic"/></a>
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
            
        </div>
    </div>

    <div class="row">
        <div style="margin-left:46%;">
        <a href="<?php echo Url::to(['/frontend/products']); ?>"><button class="btn btn-flat btn-primary"><i class="fa fa-eye"></i> See More</button></a>
        </div>
    </div>

