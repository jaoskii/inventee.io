<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Job Order Listing';
//WTODO: [KIM][2019.11.28][job order listing layout]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php


$count=55;
$page=55;
Yii::$app->reporter->beginreport('400');

  Yii::$app->reporter->begintable('400');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER LISTING',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  
    Yii::$app->reporter->begintable('400');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PRODUCT TYPE','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        
      $total=0;

      for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['fg_prodtype'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Century Gothic','11','','','');
          Yii::$app->reporter->endrow();
          $total = $total + $data[$i]['ext'];

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();
   Yii::$app->reporter->begintable('400');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER LISTING',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(); 
      Yii::$app->reporter->col(''.$params['start'].' - '.$params['end'],null,null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  

    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('400');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PRODUCT TYPE','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
      $page=$page + $count;
    } 
    

  }//END FOR LOOKP

    Yii::$app->reporter->col('TOTAL:','200',null,false,'1px dotted ','T','R','Century Gothic','11','B','30px','4px');
    Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','T','R','Century Gothic','11','B','30px','4px');

Yii::$app->reporter->endtable();
// Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


?>