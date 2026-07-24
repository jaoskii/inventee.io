<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Invoice';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
// echo '<div style="margin-top:-15px;">';
//WTODO: [JLY][FHI][11.25.2019][SJ reps]
Yii::$app->reporter->beginreport('800');

    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[0]['clientname'],'500',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->col($data[0]['dateid'],'300',null,false,'1px solid','','R','Verdana','11','B','','');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[0]['address'],'500',null,false,'1px solid','','L','Verdana','11','B','','');
    Yii::$app->reporter->col($data[0]['yourref'],'300',null,false,'1px solid','','R','Verdana','11','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br>';

    $total=0;
    Yii::$app->reporter->begintable('800');
    for ($i=0; $i <count($data) ; $i++) { 
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'800',null,false,'1px solid','','L','Verdana','11','B','','');
            Yii::$app->reporter->col($data[$i]['uom'],'800',null,false,'1px solid','','L','Verdana','11','B','','');
            Yii::$app->reporter->col($data[$i]['barcode'],'800',null,false,'1px solid','','L','Verdana','11','B','','');
            Yii::$app->reporter->col($data[$i]['itemname'],'800',null,false,'1px solid','','L','Verdana','11','B','','');
            Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'800',null,false,'1px solid','','R','Verdana','11','B','','');
            Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'800',null,false,'1px solid','','R','Verdana','11','B','','');
            $total=$total+$data[$i]['ext'];
    }
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br>';
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','800',null,false,'1px solid','','L','Verdana','11','B','','');
        Yii::$app->reporter->col('','800',null,false,'1px solid','','L','Verdana','11','B','','');
        Yii::$app->reporter->col('','800',null,false,'1px solid','','L','Verdana','11','B','','');
        Yii::$app->reporter->col('','800',null,false,'1px solid','','L','Verdana','11','B','','');
        Yii::$app->reporter->col('','800',null,false,'1px solid','','L','Verdana','11','B','','');
        Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'800',null,false,'1px solid','','R','Verdana','11','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
// echo '</div>';
echo '</div>';

?>