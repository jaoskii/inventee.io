<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Unserved Job Order Report';
//WTODO: [KIM][2019.12.09][unserved job order report layout]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

$count=55;
$page=55;
Yii::$app->reporter->beginreport('1000');
$start=$params['start'];
$end=$params['end'];
  Yii::$app->reporter->begintable('1000');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('UNSERVED JOB ORDER REPORT',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(); 
      Yii::$app->reporter->col(''.$start.' - '.$end,null,null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        if($params['client']==''){
          Yii::$app->reporter->col('Customer : ALL',null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');
        }else {
          Yii::$app->reporter->col('Customer :'. $params['client'],null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');    
        }
       
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
      Yii::$app->reporter->endtable();
      Yii::$app->reporter->printline();


    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('JO Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('JO No','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Code','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Customer Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Item Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Qty','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Req Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Comments','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');


      for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['dateid'],'80',null,false,'1px solid ','','C','Century Gothic','10','','','');
          Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
          Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
          Yii::$app->reporter->col($data[$i]['clientname'],'230',null,false,'1px solid ','','L','Century Gothic','10','','','');
          Yii::$app->reporter->col($data[$i]['itemname'],'230',null,false,'1px solid ','','L','Century Gothic','10','','','');
          Yii::$app->reporter->col(number_format($data[$i]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Century Gothic','10','','','');
          Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','10','','','');
          Yii::$app->reporter->col($data[$i]['reqdate'],'80',null,false,'1px solid ','','C','Century Gothic','10','','','');
          Yii::$app->reporter->col($data[$i]['rem'],'80',null,false,'1px solid ','','L','Century Gothic','10','','','');
          Yii::$app->reporter->endrow();

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();
     Yii::$app->reporter->begintable('1000');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('UNSERVED JOB ORDER REPORT',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(); 
      Yii::$app->reporter->col(''.$start.' - '.$end,null,null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        if($params['client']==''){
          Yii::$app->reporter->col('Customer : ALL',null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');
        }else {
          Yii::$app->reporter->col('Customer :'. $params['client'],null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');    
        }
       
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
      Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('JO Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('JO No','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Code','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Customer Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Item Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Order Qty','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Req Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Comments','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
      $page=$page + $count;
    } 
    

  }//END FOR LOOKP


Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


?>