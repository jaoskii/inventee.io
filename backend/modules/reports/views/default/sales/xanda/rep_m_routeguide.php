<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Route Guide';

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('ROUTE GUIDE','125px',null,false,'1px solid ','','C','Century Gothic','15','B','30px','8px');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data[0]['route'],'125px',null,false,'1px solid ','','C','Century Gothic','15','B','30px','8px');  

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('RF NO','100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col($data[0]['rfdocno'],'100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('APPROVAL CODE','100px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col($data[0]['approval'],'100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');

Yii::$app->reporter->startrow();
Yii::$app->reporter->col('RF DATE','100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col($data[0]['dateid'],'100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');

Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SALESMAN','100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col($data[0]['client'].'~'.$data[0]['clientname'],'100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');

Yii::$app->reporter->startrow();
Yii::$app->reporter->col('NOTES','100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col($data[0]['rem'],'100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','200px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');


Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('No','50px',null,false,'1px solid ','TB','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Codes','50px',null,false,'1px solid ','TB','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Customer','300px',null,false,'1px solid ','TB','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Address','200px',null,false,'1px solid ','TB','R','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Kilometers','200px',null,false,'1px solid ','TB','R','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
$totalkilo=0;
for($i=0;$i<count($data2);$i++){
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data2[$i]['no'],'50px',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->col($data2[$i]['code'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->col($data2[$i]['customer'],'300px',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->col($data2[$i]['address'],'200px',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->col($data2[$i]['kilometers'],'200px',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');  
$totalkilo=$totalkilo+$data2[$i]['kilometers'];


}
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('','50px',null,false,'1px solid ','T','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('','50px',null,false,'1px solid ','T','C','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('','300px',null,false,'1px solid ','T','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Total','200px',null,false,'1px solid ','T','R','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col($totalkilo,'200px',null,false,'1px solid ','T','C','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '</br>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Prepared By:','390px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('','10px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Noted By:','400px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
Yii::$app->reporter->col($prepared,'390px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('','10px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col($noted,'400px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


echo '</br>';
echo '</br>';
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($data[0]['txchecker'],'50px',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->col('','50px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col($data[0]['txdriver'],'50px',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');  
Yii::$app->reporter->col('','650px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Checker','50px',null,false,'1px solid ','t','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('','50px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('Driver','50px',null,false,'1px solid ','t','L','Century Gothic','11','B','30px','8px');  
Yii::$app->reporter->col('','650px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
// Yii::$app->reporter->col('','50px',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');  
// Yii::$app->reporter->col($data[0]['txdriver'],'50px',null,false,'1px solid ','B','L','Century Gothic','11','B','30px','8px');  
// Yii::$app->reporter->col('','300px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');  
// Yii::$app->reporter->col('','350px',null,false,'1px solid ','','R','Century Gothic','11','B','30px','8px');  

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>