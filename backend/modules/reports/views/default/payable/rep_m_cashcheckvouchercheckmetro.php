<?php
use yii\base\ErrorExeception;
date_default_timezone_set('Asia/Manila');
$this->title = 'Metrobank Check';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

try {
$count=1;
$page=30;
$cc=Yii::$app->backend->findChequeValue($data[0]['trno']);
$getpostdate = "select DATE_FORMAT(left(postdate,10),'%b %d, %Y') from ladetail as detail
                left join coa on coa.acno = detail.acno
                where trno = ".$data[0]['trno']." and left(coa.alias,2) = 'CB'
                UNION ALL
                select DATE_FORMAT(left(postdate,10),'%b %d, %Y') from gldetail as detail
                left join coa on coa.acnoid = detail.acnoid
                where trno = ".$data[0]['trno']."
                and left(coa.alias,2) = 'CB'";

$cdate = Yii::$app->sbccommon->datareader($getpostdate);

echo '<div style="margin-top:-2px;letter-spacing: 3px;">';
Yii::$app->reporter->beginreport('900');

Yii::$app->reporter->begintable('920');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Verdana','13','B','30px','4px');
            Yii::$app->reporter->col('','670',null,false,'1px solid ','','L','Verdana','10','','30px','4px');
            Yii::$app->reporter->col((''.isset($cdate)? $cdate:''),'180',null,false,'1px solid ','','L','Verdana','10','','30px','4px');
            Yii::$app->reporter->col('','120',null,false,'1px solid ','','C','Verdana','13','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('920');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Verdana','13','B','30px','4px');
            Yii::$app->reporter->col($client2,'720',null,false,'1px solid ','','L','Verdana','10','','30px','4px');
            Yii::$app->reporter->col((isset($cc)? number_format($cc,Yii::$app->systemsettings->setDecimaldisplay('currency')):''),'150',null,false,'1px solid ','','C','Verdana','10','','30px','4px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Verdana','13','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('920');
            $dd = number_format((float)$cc, 2, '.', '');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Verdana','13','B','30px','4px');
            Yii::$app->reporter->col(Yii::$app->backend->ftNumberToWordsConverter($dd). ' ONLY','900',null,false,'1px solid ','','L','Verdana','10','','30px','4px');
         
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

        Yii::$app->reporter->endreport();
echo '</div>';
//var_dump($params);
// var_dump($data);

    
} catch (ErrorException $e) {
    echo $e;
}
?>