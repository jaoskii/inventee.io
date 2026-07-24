<?php
use yii\helpers\Url;
$this->title = "All Available Brands";
$defaultimg = Yii::$app->homeUrl.'frontendassets/steamlayout/images/b-logo1.png';
?>

  <section class="content-wrapper">
    <div class="container">
      <div class="std">
      	<br>
      	<br>
        	<?php
		      $counter = 0;
		      $strhtml = '';
			    if(!empty($brands)){
			    $strhtml .= '<div class="row">';
			        foreach ($brands as $key => $value) {
			          	$strhtml .= '<div class="col-md-3">';
			          	$strhtml .= '<a href="'.Url::to(['/frontend/products/', 'type' => 'brand','v'=>$value['brandid']]).'">';
			          	if($value['picture'] == ''){
			          		$strhtml .= '<img src="'.$defaultimg.'">';
			          	}else{
			          		$strhtml .= '<img src="'.$value['picture'].'">';
			          	}//end if11
			          	$strhtml .= '</a>';
			            $strhtml .= '</div>';
			            $counter = $counter + 1;
			            if($counter == 4){
			            	$strhtml .= '</div>';
			            	$strhtml .= '<br>';
			            	$strhtml .= '<br>';
			            	$strhtml .= '<br>';
			            	$strhtml .= '<div class="row">';
			            	$counter = 0;
			            }//end counter

			        }//end for each
			    $strhtml .= '</div>';
			    }//end if not empty
			echo $strhtml;
		    ?>    
	    <br>
	    <br>

      </div>
    </div>
  </section>