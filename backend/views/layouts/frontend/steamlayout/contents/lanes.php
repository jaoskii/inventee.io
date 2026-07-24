<style>
  .item_img {
      height:182px;
      width: 285px;
       border: solid 1px #f3f3f3;
    }

    .item_img:hover {
     border: solid 1px #ccc;
    }


    .pricearea {
      text-align: center;
      height:45px;
      width:98%;    
      padding: 10px;
      position:absolute;
      background-color: #f8f8f8 ;
    }

    .pricebefore {
      color: #000;
        font-size: 12px;
        text-decoration: line-through;
    }

    .pricenow {
      color: red;
      font-size: 14px;
    }

    .hid {
      display: none;
    }

.white-text{
  color: #000;
}

</style>

<?php
use yii\helpers\Url;
$strhtml = "";

if(!empty(Yii::$app->session['lanes'])){
$strhtml .= '<div class="container">';
$strhtml .= '<div class="row">';
$strhtml .= '<div class="col-md-12">';
$strhtml .= '<div class="category-title">';
$strhtml .= '<h1>LANES</h1>';
$strhtml .= '</div>';
$strhtml .= '</div>';
$strhtml .= '</div>';
$strhtml .= '</div>';

foreach (Yii::$app->session['lanes'] as $key => $value) {
$lanesliderimg = Yii::$app->homeUrl.'frontendassets/steamlayout/images/slide-img1.jpg';
$f1 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/offer-banner1.jpg';
$f1sku="";
$f2 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/offer-banner1.jpg';
$f2sku="";
$f3 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/offer-banner1.jpg';
$f3sku="";
$f4 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/offer-banner1.jpg';
$f4sku="";
$f5 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/offer-banner1.jpg';
$f5sku="";
$f6 = Yii::$app->homeUrl.'frontendassets/steamlayout/images/offer-banner1.jpg';
$f6sku="";
$sliders = Yii::$app->frontend->getLaneSliderPerLane($value['navid']);
$featured = Yii::$app->frontend->getLaneFeaturedItems($value['navid']);
$fcats = Yii::$app->frontend->getLaneFeaturedCategories($value['navid']); //THIS IS FOR ITEMS  


  //THIS LOOP RETRIEVE AND SETS FEATURE ITEM IMAGES FROM DATABASE FOR THIS LANE
  if(!empty($featured)){
  foreach ($featured as $featkey => $featvalue) {
     if($featvalue['picture'] != ''){
         switch ($featvalue['line']) {
            case '1':
              $f1 = $featvalue['picture'];
              $f1sku = $featvalue['barcode'];
              $f1saleprice = $featvalue['saleprice'];
              $f1amt = $featvalue['amt'];
              $f1issale = $featvalue['issale'];
             break;

            case '2':
              $f2 = $featvalue['picture'];
              $f2sku = $featvalue['barcode'];
              $f2saleprice = $featvalue['saleprice'];
              $f2amt = $featvalue['amt'];
              $f2issale = $featvalue['issale'];
             break;
            
            case '3':
              $f3 = $featvalue['picture'];
              $f3sku = $featvalue['barcode'];
              $f3saleprice = $featvalue['saleprice'];
              $f3amt = $featvalue['amt'];
              $f3issale = $featvalue['issale'];
             break;

            case '4':
              $f4 = $featvalue['picture'];
              $f4sku = $featvalue['barcode'];
              $f4saleprice = $featvalue['saleprice'];
              $f4amt = $featvalue['amt'];
              $f4issale = $featvalue['issale'];
             break;

            case '5':
              $f5 = $featvalue['picture'];
              $f5sku = $featvalue['barcode'];
              $f5saleprice = $featvalue['saleprice'];
              $f5amt = $featvalue['amt'];
              $f5issale = $featvalue['issale'];
             break;

            case '6':
              $f6 = $featvalue['picture'];
              $f6sku = $featvalue['barcode'];
              $f6saleprice = $featvalue['saleprice'];
              $f6amt = $featvalue['amt'];
              $f6issale = $featvalue['issale'];
             break;
         }//end switch
      }//end if picture ''
  }//end for each
}//end if

$strhtml = $strhtml . '<div class="offer-banner-section animated">';

//FOR FEATURED HEADER CATEGORY
$strhtml = $strhtml . '<div class="container">';
$strhtml = $strhtml . '<div class="header-service animated">';
$strhtml = $strhtml . '<div class="col-lg-3 col-sm-6 col-xs-3">';
$strhtml = $strhtml . '<div class="content">';
$strhtml = $strhtml . '<div class="icon-dis">&nbsp;</div>';
$strhtml = $strhtml . '<a href="'.Url::to(['/frontend/products/', 'type' => 'lane','v'=>$value['navid']]).'"><span class="hidden-xs"><strong>'.$value['nav_desc'].'</strong></a> <b>></b></span>';


$strhtml = $strhtml . '</div>';
$strhtml = $strhtml . '</div>';
    
      //########################## THIS IS FOR FEATURED CATEGORIES PER LANE
      foreach ($fcats as $key => $fcatvalue) {
          $strhtml = $strhtml . '<div class="col-lg-2 col-sm-2 col-xs-2">';
          $strhtml = $strhtml . '<div class="content">';
          $strhtml = $strhtml . '<div class="icon-dis">&nbsp;</div>';
          $strhtml = $strhtml . '<a href="'.Url::to(['/frontend/products/', 'type' => 'category','v'=>$fcatvalue['catid']]).'"><span class="hidden-xs"><strong>'.$fcatvalue['cat_desc'].'</strong></span></a></div>';
          $strhtml = $strhtml . '</div>';
      }//end for each

$strhtml = $strhtml . '</div>';
$strhtml = $strhtml . '</div>';
//FOR FEATURED HEADER CATEGORY
$strhtml = $strhtml . '</br>';


$strhtml = $strhtml . '<div class="container">';

//FOR LANE SLIDER
$strhtml = $strhtml . '<div class="row">';

$strhtml = $strhtml . '<div class="col-lg-9 col-xs-12 col-sm-9 animated animated">';
$strhtml = $strhtml . '<div id="rev_slider_4_wrapper" class="rev_slider_wrapper fullwidthbanner-container">';
$strhtml = $strhtml . '<div id="rev_slider_4" class="revsliders rev_slider fullwidthabanner">';
$strhtml = $strhtml . '<ul>';
  
    if(empty($sliders)){
        $strhtml = $strhtml . '<li data-transition="random" data-slotamount="7" data-masterspeed="1000" data-thumb="'.$lanesliderimg.'">';
        $strhtml = $strhtml . '<img src="'.$lanesliderimg.'" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" alt="banner"/>';
        $strhtml = $strhtml . '</li>';

        $strhtml = $strhtml . '<li data-transition="random" data-slotamount="7" data-masterspeed="1000" data-thumb="'.$lanesliderimg.'">';
        $strhtml = $strhtml . '<img src="'.$lanesliderimg.'" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" alt="banner"/>';
        $strhtml = $strhtml . '</li>';
    }else{
        //RETRIEVES AVAILABLE SLIDERS FOR THIS LANE
        foreach ($sliders as $sliderkey => $slidervalue) {
          $lanesliderimg = $slidervalue['strimg'];
          $strhtml = $strhtml . '<li data-transition="random" data-slotamount="7" data-masterspeed="1000" data-thumb="'.$lanesliderimg.'">';
          $strhtml = $strhtml . '<img src="'.$lanesliderimg.'" data-bgposition="left top" data-bgfit="cover" data-bgrepeat="no-repeat" alt="banner"/>';
          $strhtml = $strhtml . '</li>';
        }//end for each for sliders
    }//end if empty sliders for lanes

$strhtml = $strhtml . '</ul>';
$strhtml = $strhtml . '<div class="tp-bannertimer"></div>';
$strhtml = $strhtml . '</div>';
$strhtml = $strhtml . '</div>';
$strhtml = $strhtml . '</div>';


$strhtml = $strhtml . '<div class="col-lg-3 col-xs-12 col-sm-3 animated animated">';

$strhtml = $strhtml . '<a href="'.Url::to(['/frontend/productdetail/', 'sku' => $f1sku]).'"><img class="item_img" src="'.$f1.'" alt="offer banner3"><br>';
$strhtml = $strhtml . '<div class="pricearea col-lg-3 col-xs-12 col-sm-3 animated animated">';
  if($f1issale){
    $strhtml = $strhtml . '<span class="pull-left pricebefore">Before: <b>'.number_format($f1amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    $strhtml = $strhtml . '<b>|</b>';
    $strhtml = $strhtml . '<span class="pull-right pricenow" class="pull-left">Price Now: <b>'.number_format($f1saleprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
  }else{
    $strhtml = $strhtml . '<span class="pricenow white-text" class="pull-left">Price: <b>'.number_format($f1amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
  }//end if
$strhtml = $strhtml . '</div></a>
<br/><br/><br/>';


$strhtml = $strhtml . '<a href="'.Url::to(['/frontend/productdetail/', 'sku' => $f2sku]).'"><img class="item_img" src="'.$f2.'" alt="offer banner3">';
$strhtml = $strhtml . '<div class="pricearea col-lg-3 col-xs-12 col-sm-3 animated animated">';
  if($f2issale){
    $strhtml = $strhtml . '<span class="pull-left pricebefore">Before: <b>'.number_format($f2amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    $strhtml = $strhtml . '<b>|</b>';
    $strhtml = $strhtml . '<span class="pull-right pricenow" class="pull-left">Price Now: <b>'.number_format($f2saleprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
  }else{
    $strhtml = $strhtml . '<span class="pricenow white-text" class="pull-left">Price: <b>'.number_format($f2amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
  }//end if
$strhtml = $strhtml . '</div></a>';



$strhtml = $strhtml . '</div>';
$strhtml = $strhtml . '</div>'; //END 1ST AND 2ND ROW



$strhtml = $strhtml . '<div class="row">';
$strhtml = $strhtml . '<div class="col-lg-3 col-xs-12 col-sm-3 animated animated">';
$strhtml = $strhtml . '<a href="'.Url::to(['/frontend/productdetail/', 'sku' => $f3sku]).'">
<img style="height:227px;" width="285" src="'.$f3.'" alt="offer banner1">';
$strhtml = $strhtml . '<div class="pricearea col-lg-3 col-xs-12 col-sm-3 animated animated">';
    if($f3issale){
      $strhtml = $strhtml . '<span class="pull-left pricebefore">Before: <b>'.number_format($f3amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
      $strhtml = $strhtml . '<b>|</b>';
      $strhtml = $strhtml . '<span class="pull-right pricenow" class="pull-left">Price Now: <b>'.number_format($f3saleprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }else{
      $strhtml = $strhtml . '<span class="pricenow white-text" class="pull-left">Price: <b>'.number_format($f3amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }//end if
$strhtml = $strhtml . '</div></a>';
$strhtml = $strhtml . '</div>';

$strhtml = $strhtml . '<div class="col-lg-3 col-xs-12 col-sm-3 animated animated">';
$strhtml = $strhtml . '<a href="'.Url::to(['/frontend/productdetail/', 'sku' => $f4sku]).'"><img style="height:227px;" width="285" src="'.$f4.'" alt="offer banner1">';
$strhtml = $strhtml . '<div class="pricearea col-lg-3 col-xs-12 col-sm-3 animated animated">';
    if($f4issale){
      $strhtml = $strhtml . '<span class="pull-left pricebefore">Before: <b>'.number_format($f4amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
      $strhtml = $strhtml . '<b>|</b>';
      $strhtml = $strhtml . '<span class="pull-right pricenow" class="pull-left">Price Now: <b>'.number_format($f4saleprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }else{
      $strhtml = $strhtml . '<span class="pricenow white-text" class="pull-left">Price: <b>'.number_format($f4amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }//end if
$strhtml = $strhtml . '</div></a>';
$strhtml = $strhtml . '</div>';

$strhtml = $strhtml . '<div class="col-lg-3 col-xs-12 col-sm-3 animated animated">';
$strhtml = $strhtml . '<a href="'.Url::to(['/frontend/productdetail/', 'sku' => $f5sku]).'"><img style="height:227px;" width="285" src="'.$f5.'" alt="offer banner1">';
$strhtml = $strhtml . '<div class="pricearea col-lg-3 col-xs-12 col-sm-3 animated animated">';
    if($f5issale){
      $strhtml = $strhtml . '<span class="pull-left pricebefore">Before: <b>'.number_format($f5amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
      $strhtml = $strhtml . '<b>|</b>';
      $strhtml = $strhtml . '<span class="pull-right pricenow" class="pull-left">Price Now: <b>'.number_format($f5saleprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }else{
      $strhtml = $strhtml . '<span class="pricenow white-text" class="pull-left">Price: <b>'.number_format($f5amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }//end if
$strhtml = $strhtml . '</div></a>';
$strhtml = $strhtml . '</div>';

$strhtml = $strhtml . '<div class="col-lg-3 col-xs-12 col-sm-3 animated animated">';
$strhtml = $strhtml . '<a href="'.Url::to(['/frontend/productdetail/', 'sku' => $f6sku]).'"><img style="height:227px;" width="285" src="'.$f6.'" alt="offer banner1">';
$strhtml = $strhtml . '<div class="pricearea col-lg-3 col-xs-12 col-sm-3 animated animated">';
    if($f6issale){
      $strhtml = $strhtml . '<span class="pull-left pricebefore">Before: <b>'.number_format($f6amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
      $strhtml = $strhtml . '<b>|</b>';
      $strhtml = $strhtml . '<span class="pull-right pricenow" class="pull-left">Price Now: <b>'.number_format($f6saleprice,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }else{
      $strhtml = $strhtml . '<span class="pricenow white-text" class="pull-left">Price: <b>'.number_format($f6amt,Yii::$app->systemsettings->setDecimaldisplay('fcurrency')).'</b></span>';
    }//end if
$strhtml = $strhtml . '</div></a>';
$strhtml = $strhtml . '</div>';

$strhtml = $strhtml . '</div>'; //ENDS 2ND ROW
//FOR LANE SLIDER

$strhtml = $strhtml . '<br/>';
$strhtml = $strhtml . '<br/>';


$strhtml = $strhtml . '</div>';
$strhtml = $strhtml . '</div>';
}//end for each

echo $strhtml;
}
?>