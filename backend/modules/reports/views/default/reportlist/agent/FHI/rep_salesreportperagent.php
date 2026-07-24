<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Report Per Agent';
?>
<!-- //WTODO: [JLY][FHI][12.6.2019][SalesReportPerAgent] -->
<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=26;
$page=26;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');
//WTODO: [JLY][FHI][11.26.2019][UNSERVED PO]
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Sales Report Per Agent','800',null,false,'1px solid ','','C','Century Gothic','16','','','');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('m/d/Y',strtotime($params['start'])).' - '.date('m/d/Y',strtotime($params['end'])),'800',null,false,'1px solid ','','C','Century Gothic','16','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('DOC DATE','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('DOC NO','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('CUSTOMER NAME','300',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('CASH','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('CHARGE','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
$total=0;
Yii::$app->reporter->begintable('800');
for ($i=0; $i <count($data) ; $i++) { 
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['bal'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
        $total=$total+$data[$i]['bal'];
}
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','300',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($total,'100',null,false,'1px solid ','T','L','Century Gothic','11','','','');


    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>