<?php
use yii\helpers\Url;
$this->title = 'Highlights';
?>

<br>
<br>

<div class="container">
    <div class="row">

        <?php
        if(!empty($featured)){
            $fcount = 0;
            echo '<div class="col-md-12">';
            foreach ($featured as $key => $value) {                
                $fcount += 1;
                echo '<a href="'.Url::to(['/frontend/products/', 'type' => 'highlight','v'=>$value['highkey']]).'">
                <div class="seemegreen col-lg-6 col-xs-12 col-sm-6 animated animated" style="margin-bottom: 2.5%;">
                    <img src="'.$value['primarypic'].'" style="height:400px;width: 540px">
                </div>
                </a>';
            }//end for each

            if($fcount!= 2){
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

            echo '<a href="'.$url.'">
            <div class="seemegreen col-lg-6 col-xs-12 col-sm-6 animated animated" style="margin-bottom: 2.5%;">
                <img src="'.$src.'" style="height:400px;width: 540px">
            </div>
            </a>';

            }//end if != 2

            echo '</div>';


        }else{

        }//end if
        ?>

        <?php
        if(!empty($highlights)){
            echo '<div class="col-md-12">';
                foreach ($highlights as $key => $value) {
                    echo '<a href="'.Url::to(['/frontend/products/', 'type' => 'highlight','v'=>$value['highkey']]).'">
                    <img src="'.$value['primarypic'].'" style="height:260px;margin-right: 14px;">
                    </a>';   
                }//end for each
            echo '</div>';
        }//end if
        ?>
    </div>
</div>

<br>
<br>