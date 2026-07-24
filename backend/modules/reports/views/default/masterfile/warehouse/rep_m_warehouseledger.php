<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Warehouse Ledger Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=54;
Yii::$app->reporter->beginreport();


    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            $header=Yii::$app->reporter->letterhead();
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('WAREHOUSE LEDGER - PROFILE ',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('Run Date :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Warehouse:','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col('('.(isset($data[0]['client'])? $data[0]['client']:'').')'.'&nbsp;&nbsp;&nbsp;'.(isset($data[0]['clientname'])? $data[0]['clientname']:''),'750',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address:','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['addr'])? $data[0]['addr']:''),'750',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->endtable();


//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


?>
