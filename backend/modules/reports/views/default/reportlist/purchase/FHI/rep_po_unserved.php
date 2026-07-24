<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Agent Report Per Salesman';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=26;
$page=26;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1000');
//WTODO: [JLY][FHI][11.26.2019][UNSERVED PO]
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('P.O. UNSERVED BALANCES','1000',null,false,'1px solid ','','C','Century Gothic','16','','','');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('m/d/Y',strtotime($params['start'])).' - '.date('m/d/Y',strtotime($params['end'])),'1000',null,false,'1px solid ','','C','Century Gothic','16','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PO DATE','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('PO NO','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('Supplier','300',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('Code','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('Description','300',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('Unit','50',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('Qty','50',null,false,'1px dotted ','TB','R','Century Gothic','16','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
for ($i=0; $i <count($data) ; $i++) { 
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['unserved'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','','R','Century Gothic','11','','','');
}


    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>