<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
echo '<div style="letter-spacing: 4px;">';
Yii::$app->reporter->beginreport('750');
echo '<br/><br/>';
echo '<div id="details" style="height:80px;clear:both;">';
    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col(' ','40',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial Rounded MT Bold','12','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial Rounded MT Bold','12','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial Rounded MT Bold','12','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial Rounded MT Bold','12','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial Rounded MT Bold','12','B','30px','2px');
            Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['ourref'])? $data[0]['ourref']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','5px');
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial Rounded MT Bold','12','B','30px','5px');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


echo '</div>';    
echo '<div id="details" style="height:350px;clear:both;">';
    Yii::$app->reporter->begintable('750');
echo '<br/>';
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
        Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;'.$data[$i]['uom'],'100',null,false,'1px solid ','','C','Arial','10','B','30px','2px');
        Yii::$app->reporter->col('&nbsp;'.$data[$i]['itemname'],'400',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->col('','170',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
         
}
echo '</div><br/>';
echo '<br/>';
echo '</div>';
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>