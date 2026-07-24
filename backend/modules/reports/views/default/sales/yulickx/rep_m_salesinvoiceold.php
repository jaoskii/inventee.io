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
echo '<div id="details" style="height:63px;clear:both;">';
    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Arial','10','B','30px','');
            Yii::$app->reporter->col(''.(isset($data[0]['clientname'])? $data[0]['clientname']:''),'390',null,false,'1px solid ','','L','Arial','11','B','320px','');
            Yii::$app->reporter->col(' ','50',null,false,'1px solid ','','L','Arial','10','B','20px','');
            Yii::$app->reporter->col(''.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'110',null,false,'1px solid ','','R','Arial','11','B','30px','');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','R','Arial','11','B','30px','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    

    Yii::$app->reporter->begintable('750');
   
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','85',null,false,'1px solid ','','L','Arial','10','B','30px','');
            Yii::$app->reporter->col(''.(isset($data[0]['address'])? $data[0]['address']:''),'400',null,false,'1px solid ','','L','Arial','11','B','30px','');
            Yii::$app->reporter->col(' ','50',null,false,'1px solid ','','L','Arial','10','B','','');
            Yii::$app->reporter->col((isset($data[0]['ourref'])? $data[0]['ourref']:''),'130',null,false,'1px solid ','','R','Arial','11','B','30px','');
            Yii::$app->reporter->col('','180',null,false,'1px solid ','','R','Arial','11','B','30px','');
        Yii::$app->reporter->endrow();


    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('750');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','130',null,false,'1px solid ','','L','Arial','10','B','','2px');
            Yii::$app->reporter->col(''.(isset($data[0]['rem'])? $data[0]['rem']:''),'300',null,false,'1px solid ','','L','Arial','11','B','','2px');
            Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'100',null,false,'1px solid ','','L','Arial','11','B','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'110',null,false,'1px solid ','','R','Arial','11','B','','');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','R','Arial','11','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

echo '</div>';    
echo '<div id="details" style="height:350px;clear:both;">';
    Yii::$app->reporter->begintable('750');

    $totalext=0;
    $vatable=0;
    $vatexempt=0;
    $vatzero=0;
    $vatamt=0;
    $totalsales=0;
    $lessvat=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Arial','11','B','','');
        Yii::$app->reporter->col(''.$data[$i]['uom'],'150',null,false,'1px solid ','','C','Arial','11','B','','');
        Yii::$app->reporter->col(''.$data[$i]['itemname'],'460',null,false,'1px solid ','','L','Arial','11','B','','');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','R','Arial','11','B','','');
        Yii::$app->reporter->col('','40',null,false,'1px solid ','','R','Arial','11','B','','');
        $totalext=$totalext+$data[$i]['ext'];
        $vatamt=$totalext/1.11*.11;
         
}
echo '</div><br/>';
echo '<br/>';
echo '</div>';

    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
?>