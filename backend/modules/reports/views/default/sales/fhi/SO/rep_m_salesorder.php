<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Bodega out per warehouse';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;
//WTODO: [JLY][FHI][11.26.2019][SO reps]
Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

// Yii::$app->reporter->begintable('800');
//         Yii::$app->reporter->startrow();
//         //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
//         Yii::$app->reporter->col('SALES ORDER','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
//         Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
//         Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
//         Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'500',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('SLIP NO : ','60',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'160',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALESMAN : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['agent'])? $data[0]['agent']:''),'500',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Code','100',null,false,'1px dotted ','TB','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Description','500',null,false,'1px dotted ','TB','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Unit','100',null,false,'1px dotted ','TB','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Quantity','100',null,false,'1px dotted ','TB','C','Century Gothic','12','B','30px','8px');
        

        

   $totalext=0;
$counter=0;
for($i=0;$i<count($data);$i++){
    $counter++;
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'500',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        
}   
        
    if($counter<7){
        while ($counter <= 7) {
            $counter++;
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
            Yii::$app->reporter->col('&nbsp','500',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        }

    }
       
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();

   
    
    
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','800',null,false,'1px dotted ','T','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Salesman : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','300',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Released By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col($prepared,'300',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
echo '<br>';    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Approved by : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($approved,'300',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col($received,'300',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('&nbsp','300',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('&nbsp','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Signature over printer name','300',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>