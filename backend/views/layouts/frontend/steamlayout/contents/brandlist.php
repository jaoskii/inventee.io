<?php
use yii\helpers\Url;
$strhtml = "";
$brands = Yii::$app->backend->getBrand(1,'');
if(!empty($brands)){
$strhtml .= '<div class="container">';
      $strhtml .= '<div class="row">';
      $strhtml .= '<div class="col-md-12">';
        $strhtml .= '<div class="category-title">';
          $strhtml .= '<h1>SHOP BY BRAND</h1>';
        $strhtml .= '</div>';
      $strhtml .= '</div>';
      $strhtml .= '</div>';
    $strhtml .= '</div>';

    $strhtml .= '<div class="brand-logo">';
    $strhtml .= '<div class="container">';
          $strhtml .= '<div class="slider-items-products">';
            $strhtml .= '<div id="brand-logo-slider" class="product-flexslider hidden-buttons">';
            $strhtml .= '<div class="slider-items slider-width-col6">';
                if(!empty($brands)){
                  foreach ($brands as $key => $value) {
                      if($value['picture'] == ''){
                        $pic = Yii::$app->homeUrl.'frontendassets/steamlayout/images/b-logo1.png';
                      }else{
                        $pic = $value['picture'];
                      }//end if

                      $strhtml .= '<div class="item"> <a href="'.Url::to(['/frontend/products/', 'type' => 'brand','v'=>$value['brandid']]).'">
                      <img src="'.$pic.'" title="'.$value['brand'].'"></a> 
                      </div>';
                  }//end for each
                }//end if
            $strhtml .= '</div>';
            $strhtml .= '</div>';
          $strhtml .= '</div>';
        $strhtml .= '</div>';
      $strhtml .= '</div>';
echo $strhtml;
}
?>    
