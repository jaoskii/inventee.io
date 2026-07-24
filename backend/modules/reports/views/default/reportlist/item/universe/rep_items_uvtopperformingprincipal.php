<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Top Performing Principal';
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
    Yii::$app->reporter->col('TOP PERFORMING PRINCIPAL',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    
    Yii::$app->reporter->col('From:'.$params['start'].' to '.$params['end'],'180',null,false,'1px solid','','','Helvetica','11','','','');
    
    switch($params['salesreporttype'])
    {
      case 'report':
        Yii::$app->reporter->col('TYPE OF REPORT: SALES','160',null,false,'1px solid','','','Helvetica','11','','','');
      break;
      case 'lessreturn':
        Yii::$app->reporter->col('TYPE OF REPORT: SALES NET OF RETURN','160',null,false,'1px solid','','','Helvetica','11','','','');
      break;
      case 'return':
        Yii::$app->reporter->col('TYPE OF REPORT: RETURNS','160',null,false,'1px solid','','','Helvetica','11','','','');
      break;
    }

    if($params['principalid'] == ""){
      Yii::$app->reporter->col('PRINCIPAL: ALL','140',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('PRINCIPAL: '.$params['principalid'],'140',null,false,'1px solid','','','Helvetica','11','','','');
    }

    if($params['divisionid'] == ""){
      Yii::$app->reporter->col('DIVISION: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('DIVISION: '.$params['divisionid'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }

    if($params['class'] == ""){
      Yii::$app->reporter->col('CLASSIFICATION: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('CLASSIFICATION: '.$params['class'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }
    
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['generic'] == ""){
      Yii::$app->reporter->col('GENERIC: ALL','180',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('GENERIC: '.$params['generic'],'180',null,false,'1px solid','','','Helvetica','11','','','');
    }

    if($params['brand'] == ""){
      Yii::$app->reporter->col('BRAND: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('BRAND: '.$params['brand'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }

    if($params['department'] == ""){
      Yii::$app->reporter->col('DEPT.: ALL','140',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('DEPT.: '.$params['department'],'140',null,false,'1px solid','','','Helvetica','11','','','');
    }

    if($params['salestype'] == ""){
      Yii::$app->reporter->col('SALES TYPE: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('SALES TYPE: '.$params['salestype'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }
    
    if($params['trnxtype'] == ""){
      Yii::$app->reporter->col('TRNX TYPE: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('TRNX TYPE: '.$params['trnxtype'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
   

    if($params['pref'] == ""){
      Yii::$app->reporter->col('SALES PREF.: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('SALES PREF.: '.$params['pref'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }

    if($params['customer'] == ""){
      Yii::$app->reporter->col('CUSTOMER: ALL','140',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('CUSTOMER: '.$params['customername'],'140',null,false,'1px solid','','','Helvetica','11','','','');
    }
    
    if($params['agent'] == ""){
      Yii::$app->reporter->col('AGENT: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('AGENT: '.$params['agentname'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('R A N K I N G','150',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('PRINCIPAL CODE','150',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('PRINCIPAL NAME','300',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('V A L U E','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
    Yii::$app->reporter->endrow();

$grandtotal = 0;
for ($i=0; $i < count($data); $i++) { 
  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col($data[$i]['rank'],'150',null,false,'1px solid','','C','Helvetica','11','','','8px');
  Yii::$app->reporter->col($data[$i]['code'],'150',null,false,'1px solid','','L','Helvetica','11','','','8px');
  Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Helvetica','11','','','8px');
  Yii::$app->reporter->col($data[$i]['category'],'300',null,false,'1px solid','','L','Helvetica','11','','','8px');
  Yii::$app->reporter->col(number_format($data[$i]['sales'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
  Yii::$app->reporter->endrow();
  $grandtotal += $data[$i]['sales'];
}//end for each
  
  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('','150',null,false,'1px solid','','C','Helvetica','11','','','8px');
  Yii::$app->reporter->col('','150',null,false,'1px solid','','L','Helvetica','11','','','8px');
  Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Helvetica','11','','','8px');
  Yii::$app->reporter->col('GRAND TOTAL:','300',null,false,'1px dotted','T','R','Helvetica','11','B','','8px');
  Yii::$app->reporter->col(number_format($grandtotal,2),'100',null,false,'1px dotted','T','R','Helvetica','11','B','','8px');
  Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
?>