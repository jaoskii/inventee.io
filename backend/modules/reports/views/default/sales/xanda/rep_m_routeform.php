<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Route Formation';

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
Yii::$app->reporter->col('Route Formation','800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  

Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['head'][0]['route'],'800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
echo '</br>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('RF NO:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['rfno'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('APPROVAL CODE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['approval'],'100',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('RF DATE:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['dateid'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('DISPATCH DATE:','150',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','100',null,false,'1px solid ','B','L','Century Gothic','12','','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SALESMAN:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['client'],'300',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('RF NOTES:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($data['head'][0]['notes'],'300',null,false,'1px solid ','','L','Century Gothic','12','','','');  
Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Code','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Customer','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Address','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('SO No','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('SO Date','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Amount','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('Tonnage','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->col('CBM','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
$totalton=0;
$totalcbm=0;
for($i=0;$i<count($data['rfso']);$i++){

Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data['rfso'][$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['rfso'][$i]['clientname'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['rfso'][$i]['address'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['rfso'][$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['rfso'][$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['rfso'][$i]['totalamt'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['rfso'][$i]['totaltonnage'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  
Yii::$app->reporter->col($data['rfso'][$i]['totalcbm'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');  

$totalton=floatval($totalton) + floatval($data['rfso'][$i]['totaltonnage']);
$totalcbm=floatval($totalcbm) + floatval($data['rfso'][$i]['totalcbm']);


}
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('No of Customers: ','135',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($totalcustomer,'50',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  						  
Yii::$app->reporter->col('No of Trnx: ','100',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($grandtotaltrnx,'50',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','125',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','40',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col($grandtotalamt,'100',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col($totalton,'100',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col($totalcbm,'100',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br></br>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Submitted By:','390px',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->col('','10px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Approved By:','400px',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
Yii::$app->reporter->col($submitted,'390px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('','10px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col($approved,'400px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>