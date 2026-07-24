<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'PO Listing';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=26;
$page=26;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');
//WTODO: [JLY][FHI][11.26.2019][PO LIST]
Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PO DATE','100',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('PO NO','150',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('Supplier','500',null,false,'1px dotted ','TB','L','Century Gothic','16','','','');
        Yii::$app->reporter->col('Amount','50',null,false,'1px dotted ','TB','C','Century Gothic','16','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    for ($i=0; $i <count($data) ; $i++) { 
        
    
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['date'],'100',null,false,'1px dotted ','','L','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px dotted ','','L','Century Gothic','11','','','');
            Yii::$app->reporter->col($data[$i]['clientname'],'500',null,false,'1px dotted ','','L','Century Gothic','11','','','');
            Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','','R','Century Gothic','11','','','');
    }
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
// var_dump($data);
// return 0;
Yii::$app->reporter->endreport();
?>