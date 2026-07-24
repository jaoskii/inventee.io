<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory Movement Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->startrow();
  	echo '<br/>';
  	Yii::$app->reporter->col('INVENTORY MOVEMENT REPORT',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
  Yii::$app->reporter->startrow();
  	
  	if($params['start'] == "" and $params['end'] == ""){
      YIi::$app->reporter->col('DATE RANGE : --','350',null,false,'1px solid','','','Century Gothic','11','','','');
    }
    else{
      Yii::$app->reporter->col('DATE RANGE '.$params['start'].'-'.$params['end'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    }
  	
  	if($params['class'] == ""){
  		Yii::$app->reporter->col('CLASS : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}else{
  		Yii::$app->reporter->col('CLASS : '.$params['class'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
  	if($params['principalid'] == ""){
  	  Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}else{
  	  Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}
  	Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
  	if($params['divisionid'] == ""){
  	  Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}else{
  	  Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}
  	
  	if($params['uvcategoryid'] == ""){
  	  Yii::$app->reporter->col('CATEGORY : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}else{
  	  Yii::$app->reporter->col('CATEGORY : '.$params['uvcategoryid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  	}


    Yii::$app->reporter->pagenumber('Page');
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1000');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('D E S C R I P T I O N','250',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('IN QTY','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('OUT QTY','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');

    $totalcost=0;
    $grandtotal=0;

    for($i=0;$i<count($data);$i++){
      $balance = (floatval($data[$i]['begbal']) + floatval($data[$i]['totin'])) - floatval($data[$i]['totout']);
      $totalcost = number_format(floatval($data[$i]['cost']) * floatval($balance),Yii::$app->systemsettings->setDecimaldisplay('currency'));

      Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['itemname'],'250',null,false,'1px solid','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['totin'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['totout'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['begbal'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($totalcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');

          $grandtotal= $grandtotal+$totalcost;
      Yii::$app->reporter->endrow();

      if(Yii::$app->reporter->linecounter==$page){
      	//
      	Yii::$app->reporter->page_break();

      	Yii::$app->reporter->begintable('1000');
      	  $header=Yii::$app->reporter->letterhead();
      	  Yii::$app->reporter->startrow();
            echo '<br/>';
            Yii::$app->reporter->col('INVENTORY MOVEMENT REPORT',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
      	  Yii::$app->reporter->endrow();
      	Yii::$app->reporter->endtable();
      	echo '<br/><br/>';

      	Yii::$app->reporter->begintable('1000');
  		  Yii::$app->reporter->startrow();
  			
  			if($params['start'] == "" and $params['end'] == ""){
      			YIi::$app->reporter->col('DATE RANGE : --','350',null,false,'1px solid','','','Century Gothic','11','','','');
    		}
    		else{
      			Yii::$app->reporter->col('DATE RANGE '.$params['start'].'-'.$params['end'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    		}
  	
  			if($params['class'] == ""){
  				Yii::$app->reporter->col('CLASS : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  			}else{
  				Yii::$app->reporter->col('CLASS : '.$params['class'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  			}
  		  Yii::$app->reporter->endrow();

  		  Yii::$app->reporter->startrow();
  		  	if($params['principalid'] == ""){
  		  	  Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  		  	}else{
  		  	  Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  		  	}
  		  	Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  		  Yii::$app->reporter->endrow();

  		  Yii::$app->reporter->startrow();
  		  	if($params['divisionid'] == ""){
  		  	  Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  		  	}else{
  		  	  Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  		  	}
  		  	if($params['uvcategoryid'] == ""){
  	  		  Yii::$app->reporter->col('CATEGORY : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');
  	        }else{
  	          Yii::$app->reporter->col('CATEGORY : '.$params['uvcategoryid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
  	        }
  		    Yii::$app->reporter->pagenumber('Page');
  		  Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('1000');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    		Yii::$app->reporter->col('D E S C R I P T I O N','250',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    		Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    		Yii::$app->reporter->col('IN QTY','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    		Yii::$app->reporter->col('OUT QTY','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    		Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    		Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    		Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;

      }
    }

  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1000');   
  Yii::$app->reporter->startrow();

    Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
    Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Century Gothic','11','','','');
    Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Century Gothic','11','','','');
    Yii::$app->reporter->col(number_format($grandtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','B','','');
   
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();
?>