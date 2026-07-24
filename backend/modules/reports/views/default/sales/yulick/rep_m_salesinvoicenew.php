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
echo '<br/><br/><br/><br/>';
echo '<div id="details" style="height:70px;clear:both;">';
    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','20px','3px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            //Yii::$app->reporter->col(' ','40',null,false,'1px solid ','','L','Arial','10','B','','');
            Yii::$app->reporter->col(''.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','','R','Arial','10','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','20px','4px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','L','Arial','10','B','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'110',null,false,'1px solid ','','R','Arial','10','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
echo '<br/>';
    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','20px','3px');
            Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.(isset($data[0]['rem'])? $data[0]['rem']:''),'280',null,false,'1px solid ','','L','Arial','10','B','30px','2px');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Arial','10','B','','');
            Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'250',null,false,'1px solid ','','R','Arial','10','B','','');
             Yii::$app->reporter->col('','70',null,false,'1px solid ','','L','Arial','10','B','','');
            Yii::$app->reporter->col(''.(isset($data[0]['ourref'])? $data[0]['ourref']:''),'130',null,false,'1px solid ','','R','Arial','10','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
echo '</div>'; 
echo '<br/>';
echo '<div id="details" style="margin-top:-24px;height:350px;clear:both;">';
    Yii::$app->reporter->begintable('750');

    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        if ($pqty =='1'){
            Yii::$app->reporter->col(number_format($data[$i]['qty2'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'75',null,false,'1px solid ','','C','','10','B','','1px');
        } else {
            Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','','10','B','','1px');
        }
        //Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','','10','B','15px','2px');
        Yii::$app->reporter->col(''.$data[$i]['uom'],'100',null,false,'1px solid ','','C','Arial','10','B','','1px');
        Yii::$app->reporter->col(''.$data[$i]['itemname'],'430',null,false,'1px solid ','','L','Arial','10','B','','1px');
        Yii::$app->reporter->col(''.number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Arial','10','B','','1px');
        Yii::$app->reporter->col('','70',null,false,'1px solid ','','R','Arial','10','B','','1px');
         
}
echo '</div><br/>';
echo '<br/>';
echo '</div>';
   
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>