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
echo '<div id="details" style="height:75px;clear:both;">';
    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    if ($data[0]['tin'] == ""){
        echo '<br/>';
    } else {
    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['ourref'])? $data[0]['ourref']:''),'200',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
}
    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['rem'])? $data[0]['rem']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','5px');
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','R','Arial','10','B','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


echo '</div>';    
echo '<div id="details" style="margin-top:-11px;height:350px;clear:both;">';


Yii::$app->reporter->begintable('750');

    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        if ($pqty =='1'){
            Yii::$app->reporter->col(number_format($data[$i]['qty2'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','L','Arial','10','B','','');
        } else {
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial','10','B','','');
        }
        //Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
        Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data[$i]['uom'],'100',null,false,'1px solid ','','C','Arial','10','B','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;'.$data[$i]['itemname'],'360',null,false,'1px solid ','','L','Arial','10','B','','');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','R','Arial','10','B','','');
        Yii::$app->reporter->col('','190',null,false,'1px solid ','','R','Arial','10','B','','');
         
}
echo '</div><br/>';
echo '<br/>';
echo '</div>';

    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>