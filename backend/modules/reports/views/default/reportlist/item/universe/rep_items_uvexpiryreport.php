<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Expiry Report';

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
    Yii::$app->reporter->col('EXPIRY REPORT',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    if($params['start'] == "" and $params['end'] == ""){
      YIi::$app->reporter->col('EXPIRY : --','350',null,false,'1px solid','','','Helvetica','14','','','');
    }
    else{
      Yii::$app->reporter->col('EXPIRY '.$params['start'].'-'.$params['end'],'350',null,false,'1px solid','','','Helvetica','14','','','');
    }
    if($params['unit'] == 'retail'){
      Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Helvetica','14','','','');
    }else{
      Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Helvetica','14','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['principalid'] == ""){
      Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Helvetica','14','','','');
    }else{
      Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','14','','','');
    }
    Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','14','','','');
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['divisionid'] == ""){
      Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Helvetica','14','','','');
    }else{
      Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','14','','','');
    }
    Yii::$app->reporter->col('','350',null,false,'1px solid','','','Helvetica','14','','','');
    Yii::$app->reporter->pagenumber('Page');
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('EXPIRY','100',null,false,'1px solid','B','C','Helvetica','14','B','','8px');
    Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','L','Helvetica','14','B','','8px');
    Yii::$app->reporter->col('D E S C R I P T I O N','350',null,false,'1px solid','B','C','Helvetica','14','B','','8px');
    Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Helvetica','14','B','','8px');
    Yii::$app->reporter->col('QTY','100',null,false,'1px solid','B','R','Helvetica','14','B','','8px');

    $totalitems =0;

    for($i=0;$i<count($data);$i++){
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['expiry'],'100',null,false,'1px solid','','C','Helvetica','14','','','');
          Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid','','L','Helvetica','14','','','');
          Yii::$app->reporter->col($data[$i]['itemname'],'350',null,false,'1px solid','','L','Helvetica','14','','','');
          Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid','','C','Helvetica','14','','','');
          Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','14','','','');

          $totalitems = $totalitems + $data[$i]['qty'];
      Yii::$app->reporter->endrow();

      if(Yii::$app->reporter->linecounter==$page){
        //
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('800');
          $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->startrow();
            echo '<br/>';
            Yii::$app->reporter->col('EXPIRY REPORT',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        if($params['start'] == "" and $params['end'] == ""){
          YIi::$app->reporter->col('EXPIRY : --','350',null,false,'1px solid','','','Helvetica','14','','','');
        }
        else{
          Yii::$app->reporter->col('EXPIRY '.$params['start'].'-'.$params['end'],'350',null,false,'1px solid','','','Helvetica','14','','','');
        }
        if($params['unit'] == 'retail'){
          Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Helvetica','14','','','');
        }else{
          Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Helvetica','14','','','');
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['principalid'] == ""){
            Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Helvetica','14','','','');
          }else{
            Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','14','','','');
          }
          Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','14','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['divisionid'] == ""){
            Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Helvetica','14','','','');
          }else{
            Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','14','','','');
          }
          Yii::$app->reporter->col('','350',null,false,'1px solid','','','Helvetica','14','','','');
          Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('EXPIRY','100',null,false,'1px solid','B','C','Helvetica','14','B','','8px');
            Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','L','Helvetica','14','B','','8px');
            Yii::$app->reporter->col('D E S C R I P T I O N','350',null,false,'1px solid','B','C','Helvetica','14','B','','8px');
            Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Helvetica','14','B','','8px');
            Yii::$app->reporter->col('QTY','100',null,false,'1px solid','B','R','Helvetica','14','B','','8px');
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

    Yii::$app->reporter->col('NO. OF ITEMS : ' . count($data),'100',null,false,'1px solid ','','L','Helvetica','14','B','','');
    Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Helvetica','14','','','');
    Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Helvetica','14','','','');
    Yii::$app->reporter->col(number_format($totalitems,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','14','B','','');
   
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>