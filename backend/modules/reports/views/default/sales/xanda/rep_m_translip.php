<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Transmittal Slip';

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Transmittal Slip','800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['head'][0]['route'],'800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
echo '</br>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('TX NO:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['docno'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('RF NO:','10',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['rfno'],'10',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('TX DATE:','110',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['dateid'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('APPROVAL CODE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['approval'],'100',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SALESMAN:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['agent'],'300',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('DISPATCH DATE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['dispatch'],'130',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('TRUCK:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['truck'],'300',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('DRIVER:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['driver'],'300',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('NOTES:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['notes'],'300',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Code','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Customer','175',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('SJ No','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('SJ Date','70',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Ourref','80',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Amount','80',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Tonnage','80',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('CBM','70',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Notes','125',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
$totalton=0;
$totalcbm=0;
for($i=0;$i<count($data['invoice']);$i++){

Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['invoice'][$i]['custcode'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['custname'],'175',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['dateid'],'70',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['sjourref'],'70',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['gtotal'],'80',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['gtonage'],'80',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['gcbm'],'70',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['invoice'][$i]['rem'],'125',null,false,'1px solid ','','C','Century Gothic','10','','','');  

$totalton=floatval($totalton) + floatval($data['invoice'][$i]['gtonage']);
$totalcbm=floatval($totalcbm) + floatval($data['invoice'][$i]['gcbm']);


}
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


//645
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('No of Customers: ','135',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($totalcustomer,'50',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('No of Trnx: ','100',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($grandtotaltrnx,'50',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','125',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($grandtotalamt,'50',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($totalton,'100',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col($totalcbm,'50',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','140',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';
//prepared,checked
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Prepared By:','200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('Checked By:','200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($checked,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';
echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Received the above documents and','800',null,false,'1px solid ','','L','Century Gothic','12','','','');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('goods for delivery','800',null,false,'1px solid ','','L','Century Gothic','12','','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['head'][0]['checker'],'200',null,false,'1px solid ','B','C','Century Gothic','12','','','');
Yii::$app->reporter->col('','600',null,false,'1px solid ','','L','Century Gothic','12','B','','');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('CHECKER','200',null,false,'1px solid ','','C','Century Gothic','12','','','');
Yii::$app->reporter->col('','600',null,false,'1px solid ','','L','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','B','','');
Yii::$app->reporter->col('FOR OFFICE USE ONLY','300',null,false,'1px solid ','','R','Century Gothic','12','B','','');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','B','','');
Yii::$app->reporter->col('Received original signed documents','300',null,false,'1px solid ','','R','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['head'][0]['driver'],'200',null,false,'1px solid ','B','C','Century Gothic','12','','','');
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');
Yii::$app->reporter->col('','200',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Driver','200',null,false,'1px solid ','','C','Century Gothic','12','','','');
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');
Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
// $totalcustomer,grandtotaltrnx,grandtotalamt

Yii::$app->reporter->endreport();


?>