<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Summary Per Principal/Division';
//WTODO: [KIM][2019.10.30][update layout for sales summary per principal/division]
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
    Yii::$app->reporter->col('SALES SUMMARY PER PRINCIPAL/DIVISION',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Sales : '.$params['start'].'-'.$params['end'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    Yii::$app->reporter->col('','350',null,false,'1px solid','','','Helvetica','11','','','');
    
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('D I V I S I O N','600',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
Yii::$app->reporter->col('','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
Yii::$app->reporter->col('A M O U N T','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
Yii::$app->reporter->endrow();

$principal = '';
$subtotal = 0;
$gtotal = 0;
for ($i=0; $i < count($data); $i++) { 
  
  if($principal == ""){
      Yii::$app->reporter->endtable();
      Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper($data[$i]['principal']),'800',null,false,'1px dotted','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->endtable();
      Yii::$app->reporter->begintable('800');
      $principal = $data[$i]['principal'];
  }else{
    if($principal != $data[$i]['principal']){
      Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','600',null,false,'1px dotted','','C','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('SUBTOTAL:','100',null,false,'1px dotted','TB','C','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($subtotal,2),'100',null,false,'1px dotted','TB','R','Helvetica','11','','','8px');
      Yii::$app->reporter->endrow();
      $subtotal = 0;

      Yii::$app->reporter->endtable();
      Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(strtoupper($data[$i]['principal']),'800',null,false,'1px dotted','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->endrow();
      $principal = $data[$i]['principal'];
      Yii::$app->reporter->endtable();
      Yii::$app->reporter->begintable('800');
    }//end if if
  }//end if

  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('&nbsp;&nbsp;'.$data[$i]['division'],'600',null,false,'1px solid','','L','Helvetica','11','','','8px');
  Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Cetury Gothic','11','','','8px');
  Yii::$app->reporter->col(number_format($data[$i]['sales'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
  Yii::$app->reporter->endrow();
  $subtotal += $data[$i]['sales'];
  $gtotal += $data[$i]['sales'];
}//end for each

Yii::$app->reporter->startrow();
Yii::$app->reporter->col('','600',null,false,'1px dotted','','C','Helvetica','11','','','8px');
Yii::$app->reporter->col('SUBTOTAL:','100',null,false,'1px dotted','T','C','Helvetica','11','B','','8px');
Yii::$app->reporter->col(number_format($subtotal,2),'100',null,false,'1px dotted','T','r','Helvetica','11','B','','8px');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
Yii::$app->reporter->col('','600',null,false,'1px dotted','','C','Helvetica','11','','','8px');
Yii::$app->reporter->col('GRAND TOTAL:','100',null,false,'1px dotted','T','C','Helvetica','11','B','','8px');
Yii::$app->reporter->col(number_format($gtotal,2),'100',null,false,'1px dotted','T','r','Helvetica','11','B','','8px');
Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();



Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

?>