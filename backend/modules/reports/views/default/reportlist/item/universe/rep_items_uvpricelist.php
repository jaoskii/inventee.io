<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Price List';

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;

Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      echo '<br/>';
  	  Yii::$app->reporter->col('PRICE LIST',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  	Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow(null,null,false,'1px solid','','','Helvetica','12','','','');
          if($params['principalid']==''){
            Yii::$app->reporter->col('Principal : ALL','200',null,false,'1px solid ','','L','Helvetica','11','','','');    
          } else {
            Yii::$app->reporter->col('Principal : '.$params['principalid'],'200',null,false,'1px solid ','','L','Helvetica','11','','','');
          }
          
          if($params['divisionid']==''){
            Yii::$app->reporter->col('Division : ALL','300',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Division : '.$params['divisionid'],'300',null,false,'1px solid','','L','Helvetica','11','','','');
          }

          if($params['genericid']==''){
            Yii::$app->reporter->col('Generic : ALL','300',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Generic : '.$params['generic'],'300',null,false,'1px solid','','L','Helvetica','11','','','');
          }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['classid']==''){
            Yii::$app->reporter->col('Classification : ALL','400',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Classification : '.$params['class'],'400',null,false,'1px solid','','L','Helvetica','11','','','');
          }

          if($params['categoryid']==''){
            Yii::$app->reporter->col('Category : ALL','400',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Category : '.$params['category'],'400',null,false,'1px solid','','L','Helvetica','11','','','');
          }
          Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();



Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
  	Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('PRICE','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('DISCOUNT','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('NET PRICE','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');

    $amount=0;
    $discount = '';

    for($i=0;$i<count($data);$i++){

      switch ($params['pricegroup']) {
      case 'W':
        $amount = $data[$i]['amt2'];
        $discount = $data[$i]['disc2'];
      break;
      case 'A':
        $amount = $data[$i]['amt4'];
        $discount = $data[$i]['disc3'];
      break;
      case 'B':
        $amount = $data[$i]['famt'];
        $discount = $data[$i]['disc4'];
      break;
      case 'C':
        $amount = $data[$i]['amt5'];
        $discount = $data[$i]['disc5'];
      break;
      case 'D':
        $amount = $data[$i]['amt6'];
        $discount = $data[$i]['disc6'];
      break;
      case 'E':
        $amount = $data[$i]['amt7'];
        $discount = $data[$i]['disc7'];
      break;
      case 'F':
        $amount = $data[$i]['amt8'];
        $discount = $data[$i]['disc8'];
      break;
      case 'G':
        $amount = $data[$i]['amt9'];
        $discount = $data[$i]['disc9'];
      break;
      case 'H':
        $amount = $data[$i]['amt10'];
        $discount = $data[$i]['disc10'];
      break;
      case 'I':
        $amount = $data[$i]['amt11'];
        $discount = $data[$i]['disc11'];
      break;
      case 'J':
        $amount = $data[$i]['amt12'];
        $discount = $data[$i]['disc12'];
      break;
      case 'K':
        $amount = $data[$i]['amt13'];
        $discount = $data[$i]['disc13'];
      break;
      case 'L':
        $amount = $data[$i]['amt14'];
        $discount = $data[$i]['disc14'];
      break;
      case 'M':
        $amount = $data[$i]['amt15'];
        $discount = $data[$i]['disc15'];
      break;
      default:
        $amount = $data[$i]['amt'];
        $discount = $data[$i]['disc'];
        break;
    }
      $discamt = Yii::$app->sbccommon->Discount($amount,$discount);

      Yii::$app->reporter->startrow();
      Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid ','','L','Helvetica','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'250',null,false,'1px solid ','','L','Helvetica','11','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($amount,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','','','');
        Yii::$app->reporter->col($discount,'100',null,false,'1px solid ','','R','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($discamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','','','');
      Yii::$app->reporter->endrow();


      if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

      	Yii::$app->reporter->begintable('800');
		  $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->startrow();
          echo '<br/>';
  	        Yii::$app->reporter->col('PRICE LIST',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  	      Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow(null,null,false,'1px solid','','','Helvetica','12','','','');
          if($params['principalid']==''){
            Yii::$app->reporter->col('Principal : ALL','200',null,false,'1px solid ','','L','Helvetica','11','','','');    
          } else {
            Yii::$app->reporter->col('Principal : '.$params['principalid'],'200',null,false,'1px solid ','','L','Helvetica','11','','','');
          }
          
          if($params['divisionid']==''){
            Yii::$app->reporter->col('Division : ALL','300',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Division : '.$params['divisionid'],'300',null,false,'1px solid','','L','Helvetica','11','','','');
          }

          if($params['genericid']==''){
            Yii::$app->reporter->col('Generic : ALL','300',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Generic : '.$params['generic'],'300',null,false,'1px solid','','L','Helvetica','11','','','');
          }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['classid']==''){
            Yii::$app->reporter->col('Classification : ALL','400',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Classification : '.$params['class'],'400',null,false,'1px solid','','L','Helvetica','11','','','');
          }

          if($params['categoryid']==''){
            Yii::$app->reporter->col('Category : ALL','400',null,false,'1px solid','','L','Helvetica','11','','','');
          } else {
            Yii::$app->reporter->col('Category : '.$params['category'],'400',null,false,'1px solid','','L','Helvetica','11','','','');
          }
          Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('PRICE','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('DISCOUNT','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('NET PRICE','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
      } 

    }


  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();
?>