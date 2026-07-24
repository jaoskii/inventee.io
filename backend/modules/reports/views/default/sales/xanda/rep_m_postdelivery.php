<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Post Delivery Report';

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
Yii::$app->reporter->col('Post Delivery Report','800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
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
Yii::$app->reporter->col('APPROVAL CODE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['approval'],'100',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('TX DATE:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['dateid'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('DISPATCH DATE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['dispatch'],'100',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SALESMAN:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['agent'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('RETURNED DATE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['returndate'],'100',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('TRUCK:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['truck'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','260',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('RF NO:','140',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['rfdoc'],'100',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
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
Yii::$app->reporter->col('Customer','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('SJ No','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('SJ Date','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Details','150',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Discrepancy Type','150',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Notes','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
for($i=0;$i<count($data['txpdr']);$i++){

Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['txpdr'][$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
Yii::$app->reporter->col($data['txpdr'][$i]['clientname'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
Yii::$app->reporter->col($data['txpdr'][$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
Yii::$app->reporter->col($data['txpdr'][$i]['sjdate'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
Yii::$app->reporter->col($data['txpdr'][$i]['details'],'150',null,false,'1px solid ','','C','Century Gothic','10','','','');
Yii::$app->reporter->col($data['txpdr'][$i]['type'],'150',null,false,'1px solid ','','C','Century Gothic','10','','','');
Yii::$app->reporter->col($data['txpdr'][$i]['notes'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');


}
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('No of Customers: ','100',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($totalcustomer,'50',null,false,'1px solid ','T','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('No of Trnx: ','70',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($grandtotaltrnx,'50',null,false,'1px solid ','T','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','530',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  


Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br></br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Submitted By: ','300',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('Approved By','300',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($submitted,'300',null,false,'1px solid ','B','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($approved,'300',null,false,'1px solid ','B','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','',''); 
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br></br>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Received Transmittal','800',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('and attachment by: ','140',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($attached,'160',null,false,'1px solid ','B','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('checked by: ','140',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($checked,'160',null,false,'1px solid ','B','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('noted by: ','140',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($noted,'160',null,false,'1px solid ','B','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>