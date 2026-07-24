<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Dispatched TX List';

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport('1200');

Yii::$app->reporter->begintable('1200');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();



Yii::$app->reporter->begintable('1200');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Dispatched TX List','1200',null,false,'1px solid ','','C','Century Gothic','15','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '</br>';

Yii::$app->reporter->begintable('1200');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Date Range: '.$params['startdate'].'~'.$params['enddate'],'1200',null,false,'1px solid ','','L','Century Gothic','13','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

// Yii::$app->reporter->col('Daily Time Record - Employee','800',null,false,'1px solid ','','C','Century Gothic','15','B','','');

//         Yii::$app->reporter->col('Sales Journal Report',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
//         Yii::$app->reporter->col($data[$i]['loc'],'80',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
Yii::$app->reporter->begintable('1200');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('TX Date','120',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('TX No','120',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('RF No','120',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('Route','150',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('Approval Code Date','150',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('Dispatched Date','150',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('Returned Date','150',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('Status','120',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->col('Notes','120',null,false,'1px solid ','TB','C','Century Gothic','13','B','','');  
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
for($i=0;$i<count($data);$i++){

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['dateid'],'120',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['docno'],'120',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['rfdocno'],'120',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['route'],'150',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['appdate'],'150',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['dispatchd'],'150',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['returnd'],'150',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['status'],'120',null,false,'1px solid ','','C','Century Gothic','13','','','');  
    Yii::$app->reporter->col($data[$i]['note'],'120',null,false,'1px solid ','','C','Century Gothic','13','','','');  
 

}
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



Yii::$app->reporter->endreport();


?>