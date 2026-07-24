<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'PO Warehouse';
//WTODO: [KIM][2019.11.08][update layout]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;
//WTODO: [JLY][FHI][11.26.2019][PO MOD FORMAT]
Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PO NO : '.(isset($data[0]['docno'])? $data[0]['docno']:''),'800',null,false,'1px solid ','','L','Century Gothic','13','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PO DATE : '.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'400',null,false,'1px solid ','','L','Century Gothic','13','','','');
        Yii::$app->reporter->col('TERMS : '.(isset($data[0]['terms'])? $data[0]['terms']:''),'400',null,false,'1px solid ','','L','Century Gothic','13','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : '.(isset($data[0]['clientname'])? $data[0]['clientname']:''),'800',null,false,'1px solid ','','L','Century Gothic','13','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Code','200',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','');  
        Yii::$app->reporter->col('Description','300',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','');  
        Yii::$app->reporter->col('Unit','150',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','');  
        Yii::$app->reporter->col('QTY','150',null,false,'1px dotted ','TB','R','Century Gothic','11','B','','');  
        
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

$counter=0;
Yii::$app->reporter->begintable('800');
    for ($i=0; $i <count($data) ; $i++) {        
        $counter++;
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['barcode'],'200',null,false,'1px dotted ','','L','Century Gothic','10','','','');  
            Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px dotted ','','L','Century Gothic','10','','','');  
            Yii::$app->reporter->col($data[$i]['uom'],'150',null,false,'1px dotted ','','l','Century Gothic','10','','','');  
            Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px dotted ','','R','Century Gothic','10','','','');  
            
    }
    if($counter<7){
        while ($counter <= 7) {
            $counter++;
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','200',null,false,'1px dotted ','','L','Century Gothic','10','','','');  
            Yii::$app->reporter->col('&nbsp','300',null,false,'1px dotted ','','L','Century Gothic','10','','','');  
            Yii::$app->reporter->col('&nbsp','150',null,false,'1px dotted ','','l','Century Gothic','10','','','');  
            Yii::$app->reporter->col('&nbsp','150',null,false,'1px dotted ','','R','Century Gothic','10','','','');  
            
        }

    }
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','');  
        Yii::$app->reporter->col('&nbsp','600',null,false,'1px dotted ','TB','R','Century Gothic','11','B','',''); 
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('REMARKS : ','80',null,false,'1px dotted ','','L','Century Gothic','11','','','');  
        Yii::$app->reporter->col($data[0]['rem'],'720',null,false,'1px dotted ','','L','Century Gothic','11','','','');  
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared by : ','100',null,false,'1px dotted ','','L','Century Gothic','11','','','');  
        Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','B','C','Century Gothic','11','','','');  
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','L','Century Gothic','11','','','');  
        Yii::$app->reporter->col('Approved by : ','100',null,false,'1px dotted ','','L','Century Gothic','11','','','');  
        Yii::$app->reporter->col($approved,'200',null,false,'1px solid ','B','C','Century Gothic','11','','','');  
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>