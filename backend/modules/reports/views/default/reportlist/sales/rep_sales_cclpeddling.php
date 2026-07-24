<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Credit Customer List for Peddling';

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
Yii::$app->reporter->col('CREDIT CUSTOMER LIST FOR PEDDLING','800',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Route: '.$route,'800',null,false,'1px solid ','','L','Century Gothic','12','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('CODE','60',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('','20',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  
Yii::$app->reporter->col('CUSTNAME','220',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('CREDIT LIMIT','100',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('TTL UNCLEARED PDC','150',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  
Yii::$app->reporter->col('AVAILABLE CL','150',null,false,'1px solid ','T','C','Century Gothic','12','B','','');  

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';
$acl=0;
Yii::$app->reporter->begintable('800');
for($i=0;$i<count($data);$i++){

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['code'],'60',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','B','','');    
    Yii::$app->reporter->col($data[$i]['name'],'220',null,false,'1px solid ','','L','Century Gothic','12','','','');  
    Yii::$app->reporter->col(number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Century Gothic','12','','','');  
    Yii::$app->reporter->col(number_format($data[$i]['bal'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','C','Century Gothic','12','','','');  
    Yii::$app->reporter->col(number_format($data[$i]['pdc'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','C','Century Gothic','12','','','');  
    $acl=$data[$i]['cr']-($data[$i]['bal']+$data[$i]['pdc']);
    Yii::$app->reporter->col(number_format($acl,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','C','Century Gothic','12','','','');  

 

}
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('No of Customer: '.count($data),'800',null,false,'1px solid ','T','L','Century Gothic','12','B','','');  

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();






Yii::$app->reporter->endreport();


?>