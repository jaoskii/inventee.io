<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Quantity On Hand';
//WTODO: [KIM][2019.11.07][change alignment for bal]
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
    Yii::$app->reporter->col('QUANTITY ON HAND',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Balance as of : '.$params['asof'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    if($params['principalid'] == ''){
      Yii::$app->reporter->col('Principal : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');  
    }else{
      Yii::$app->reporter->col('Principal : '.$params['principalid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Warehouse : '.$params['wh'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    if($params['divisionid'] == ''){
      Yii::$app->reporter->col('Division : ALL','350',null,false,'1px solid','','','Century Gothic','11','','',''); 
    }else{
      Yii::$app->reporter->col('Division : '.$params['divisionid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['unit'] == 'retail'){
      Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Century Gothic','11','','','');
    }else{
      Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Century Gothic','11','','','');
    }
    
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('BARCODE','200',null,false,'1px solid','B','L','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('D E S C R I P T I O N','300',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('UNIT','150',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('BALANCE','150',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');

    for($i=0;$i<count($data);$i++){
      Yii::$app->reporter->startrow();
      Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['bal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Century Gothic','11','','','');
      Yii::$app->reporter->endrow();

      if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();
        Yii::$app->reporter->begintable('800');
      $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->startrow();
          echo '<br/>';
            Yii::$app->reporter->col('QUANTITY ON HAND',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->col('Balance as of : '.$params['asof'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
          if($params['principalid'] == ''){
            Yii::$app->reporter->col('Principal : ALL','350',null,false,'1px solid','','','Century Gothic','11','','','');  
          }else{
            Yii::$app->reporter->col('Principal : '.$params['principalid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
          }
        Yii::$app->reporter->endrow();

          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Warehouse : '.$params['wh'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
            if($params['divisionid'] == ''){
              Yii::$app->reporter->col('Division : ALL','350',null,false,'1px solid','','','Century Gothic','11','','',''); 
            }else{
              Yii::$app->reporter->col('Division : '.$params['divisionid'],'350',null,false,'1px solid','','','Century Gothic','11','','','');
            }
          Yii::$app->reporter->endrow();

          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Unit : ','350',null,false,'1px solid','','','Century Gothic','11','','','');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','200',null,false,'1px solid','B','L','Century Gothic','11','B','','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','300',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
        Yii::$app->reporter->col('UNIT','150',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
        Yii::$app->reporter->col('BALANCE','150',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
      }
    }
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
?>