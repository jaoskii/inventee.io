<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory Market Value';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;

Yii::$app->reporter->beginreport('800');
Yii::$app->reporter->begintable('800');
echo '<span class="header"></span>';
  Yii::$app->reporter->startrow();
    echo '<br/>';
    Yii::$app->reporter->col('Universe Pharmacy',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
echo '<span class="header"></span>';
  Yii::$app->reporter->startrow();
  	echo '<br/>';
  	Yii::$app->reporter->col('INVENTORY MARKET VALUE',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Balance as of : '.$params['asof'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    if($params['principalid'] == ''){
      Yii::$app->reporter->col('Principal : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');	
    }else{
      Yii::$app->reporter->col('Principal : '.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Warehouse : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    if($params['divisionid'] == ''){
      Yii::$app->reporter->col('Division : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');	
    }else{
      Yii::$app->reporter->col('Division : '.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['unit'] == 'retail'){
      Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Helvetica','11','','','');
    }
    Yii::$app->reporter->col('','350',null,false,'1px solid','','','Helvetica','11','','','');
    Yii::$app->reporter->pagenumber('Page');
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
  	Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('NET RETAIL PRICE','150',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('QTY','150',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  	Yii::$app->reporter->col('VALUE','150',null,false,'1px solid','B','R','Helvetica','11','B','','8px');

    
    $totalvalue = 0;
    $val=0;

  	for($i=0;$i<count($data);$i++){

      $discamt = Yii::$app->sbccommon->Discount($data[$i]['amt'],$data[$i]['disc']);
      $val= $discamt * $data[$i]['qty'];

  	  Yii::$app->reporter->startrow();
  	  Yii::$app->reporter->addline();
  	  	Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid ','','L','Helvetica','11','','','');
      	Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Helvetica','11','','','');
      	Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Helvetica','11','','','');
      	Yii::$app->reporter->col(number_format($discamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','','','');
      	Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Helvetica','11','','','');
      	Yii::$app->reporter->col(number_format($val,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','','','');

        $totalvalue = $totalvalue + $val;
  	  Yii::$app->reporter->endrow();

  	  if(Yii::$app->reporter->linecounter==$page){
  	  	Yii::$app->reporter->endtable();
  	  	Yii::$app->reporter->page_break();
  	  	Yii::$app->reporter->begintable('800');
		  $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->startrow();
          echo '<br/>';
  	        Yii::$app->reporter->col('INVENTORY RETAIL MARKET VALUE',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  	      Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
  		  Yii::$app->reporter->startrow();
  		    Yii::$app->reporter->col('Balance as of : '.$params['asof'],'350',null,false,'1px solid','','','Helvetica','11','','','');
  		    if($params['principalid'] == ''){
  		      Yii::$app->reporter->col('Principal : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');	
  		    }else{
  		      Yii::$app->reporter->col('Principal : '.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
  		    }
  		  Yii::$app->reporter->endrow();

          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Warehouse : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','11','','','');
            if($params['divisionid'] == ''){
              Yii::$app->reporter->col('Division : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');	
            }else{
              Yii::$app->reporter->col('Division : '.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
            }
          Yii::$app->reporter->endrow();

          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Unit : ','350',null,false,'1px solid','','','Helvetica','11','','','');
            Yii::$app->reporter->col('','350',null,false,'1px solid','','','Helvetica','11','','','');
          Yii::$app->reporter->pagenumber('Page');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('NET RETAIL PRICE','150',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('QTY','150',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  			Yii::$app->reporter->col('VALUE','150',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
  	  }
  	}
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');   
  Yii::$app->reporter->startrow();

    Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','','L','Helvetica','11','B','','');
    Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Helvetica','11','','','');
    Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Helvetica','11','','','');
    Yii::$app->reporter->col(number_format($totalvalue,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','B','','');
   
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>