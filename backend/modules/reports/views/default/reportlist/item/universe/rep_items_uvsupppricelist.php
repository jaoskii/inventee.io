<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Supplier Price List';


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
  	Yii::$app->reporter->col('SUPPLIER PRICE LIST',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow(null,null,false,'1px solid','','','Century Gothic','11','','','');
    if($params['principalid']==''){
      Yii::$app->reporter->col('Principal : ALL','350',null,false,'1px solid ','','L','Century Gothic','11','','','');    
    } else {
      Yii::$app->reporter->col('Principal : '.$params['principalid'],'350',null,false,'1px solid ','','L','Century Gothic','11','','','');
    }

    Yii::$app->reporter->col('Effective Date : '.$params['asof'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  Yii::$app->reporter->endrow();
  Yii::$app->reporter->startrow();
  	
  	if($params['divisionid'] == ''){
    	Yii::$app->reporter->col('Division : ALL','350',null,false,'1px solid','','L','Century Gothic','11','','','');
    }else{
    	Yii::$app->reporter->col('Division : '.$params['divisionid'],'350',null,false,'1px solid','','L','Century Gothic','11','','','');
    }

    if($params['unit'] == 'retail'){
      Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Century Gothic','11','','','');
    }else{
      Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Century Gothic','11','','','');
    }
    Yii::$app->reporter->pagenumber('Page');
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['supplier'] == ''){
    	Yii::$app->reporter->col('Supplier : ALL','350',null,false,'1px solid','','L','Century Gothic','11','','','');
    }else{
    	Yii::$app->reporter->col('Supplier : '.$params['supplier'],'350',null,false,'1px solid','','L','Century Gothic','11','','','');
    }

  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid','B','L','Century Gothic','11','B','','8px');
  Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
  Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
  Yii::$app->reporter->col('SUPPLIER','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
  Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
  Yii::$app->reporter->col('DISCOUNT','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
  Yii::$app->reporter->col('NET COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');

  for($i=0;$i<count($data);$i++){

    $discamt = Yii::$app->sbccommon->Discount($data[$i]['rrcost'],$data[$i]['disc']);

  	Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
      Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
      Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
      Yii::$app->reporter->col(number_format($data[$i]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
      Yii::$app->reporter->col($data[$i]['disc'],'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
      Yii::$app->reporter->col(number_format($discamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();

    if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

      	Yii::$app->reporter->begintable('800');
		  $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->startrow();
          echo '<br/>';
  	        Yii::$app->reporter->col('SUPPLIER PRICE LIST',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
  	      Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
  		  Yii::$app->reporter->startrow(null,null,false,'1px solid','','','Century Gothic','11','','','');
            if($params['principalid']==''){
              Yii::$app->reporter->col('Principal : ALL','350',null,false,'1px solid ','','L','Century Gothic','11','','','');    
    		} else {
      		  Yii::$app->reporter->col('Principal : '.$params['principalid'],'350',null,false,'1px solid ','','L','Century Gothic','11','','','');
            }

            Yii::$app->reporter->col('Effective Date : '.$params['asof'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    
          Yii::$app->reporter->endrow();
          Yii::$app->reporter->startrow();
  	
  		    if($params['divisionid'] == ''){
    		  Yii::$app->reporter->col('Division : ALL','350',null,false,'1px solid','','L','Century Gothic','11','','','');
    	    }else{
    		  Yii::$app->reporter->col('Division : '.$params['divisionid'],'350',null,false,'1px solid','','L','Century Gothic','11','','','');
    	    }

            Yii::$app->reporter->col('Unit : ','350',null,false,'1px solid','','L','Century Gothic','11','','','');
            Yii::$app->reporter->pagenumber('Page');
          Yii::$app->reporter->endrow();

          Yii::$app->reporter->startrow();
            if($params['supplier'] == ''){
            	Yii::$app->reporter->col('Supplier : ALL','350',null,false,'1px solid','','L','Century Gothic','11','','','');
            }else{
            	Yii::$app->reporter->col('Supplier : '.$params['supplier'],'350',null,false,'1px solid','','L','Century Gothic','11','','','');
            }
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid','B','L','Century Gothic','11','B','','8px');
  			Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
  			Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
  			Yii::$app->reporter->col('SUPPLIER','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
  			Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
  			Yii::$app->reporter->col('DISCOUNT','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
  			Yii::$app->reporter->col('NET COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
      } 
    }
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
?>