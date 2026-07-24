<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Unserved Sales Order';

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('UNSERVED SALES ORDER','800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['head'][0]['route'],'800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
echo '</br>';

Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('RF NO:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['docno'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('APPROVAL CODE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['appcode'],'100',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('RF DATE:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['date'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SALESMAN:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['salesman'],'300',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','12','B','','');  

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';
Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SO No','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('SO Date','60',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Code','130',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Customer','160',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  

Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('DESCRIPTION','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('PRICE','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

$total=0;
Yii::$app->reporter->begintable('1000');
for($i=0;$i<count($data['body']);$i++){

Yii::$app->reporter->startrow();
// Yii::$app->reporter->col($data['txdc'][$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
// Yii::$app->reporter->col($data['txdc'][$i]['clientname'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
// Yii::$app->reporter->col($data['txdc'][$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
// Yii::$app->reporter->col($data['txdc'][$i]['sjdate'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
// Yii::$app->reporter->col($data['txdc'][$i]['screceivedate'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
// Yii::$app->reporter->col($data['txdc'][$i]['scconfirmationdate'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
// Yii::$app->reporter->col($data['txdc'][$i]['scsettleddate'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
// Yii::$app->reporter->col($data['txdc'][$i]['scsettlednotes'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');

Yii::$app->reporter->col($data['body'][$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');  
Yii::$app->reporter->col($data['body'][$i]['date'],'60',null,false,'1px solid ','','C','Century Gothic','11','','','');  
Yii::$app->reporter->col($data['body'][$i]['ccode'],'130',null,false,'1px solid ','','C','Century Gothic','11','','','');  
Yii::$app->reporter->col($data['body'][$i]['customer'],'160',null,false,'1px solid ','','C','Century Gothic','11','','','');  
Yii::$app->reporter->col(number_format($data['body'][$i]['quantity'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Century Gothic','11','','','');  
Yii::$app->reporter->col($data['body'][$i]['uom'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');  
Yii::$app->reporter->col($data['body'][$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');  
Yii::$app->reporter->col($data['body'][$i]['description'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
Yii::$app->reporter->col(number_format($data['body'][$i]['price'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');  


Yii::$app->reporter->col(number_format($data['body'][$i]['total'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');  
$total=$total+$data['body'][$i]['total'];
}
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('TOTAL: '.number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'1000',null,false,'1px solid ','T','R','Century Gothic','11','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
 
echo '</br></br>';
Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Submitted By: ','300',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('Approved By','300',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($submitted,'300',null,false,'1px solid ','B','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($approved,'300',null,false,'1px solid ','B','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','',''); 
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>