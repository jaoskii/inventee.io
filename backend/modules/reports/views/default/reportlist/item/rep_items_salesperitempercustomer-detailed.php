<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Per Item Per Customer';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport();

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SALES PER ITEM PER CUSTOMER',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();        

Yii::$app->reporter->begintable('800');        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('From:'.$params['start'].' to '.$params['end'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');   
        if($params['barcode']==''){
        Yii::$app->reporter->col('Item : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'. $params['itemname'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if($params['option']=='sales'){
        Yii::$app->reporter->col('Option : AMOUNT','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Option :'. strtoupper($params['option']),'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEMNAME','100',null,false,'1px solid ','TB','L','Helvetica','10','B','','');
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','L','Helvetica','10','B','','');
        Yii::$app->reporter->col('DR #','100',null,false,'1px solid ','TB','L','Helvetica','10','B','','');
        Yii::$app->reporter->col('CUSTOMER','210',null,false,'1px solid ','TB','L','Helvetica','10','B','','');
        Yii::$app->reporter->col('UOM','50',null,false,'1px solid ','TB','L','Helvetica','10','B','','');
        Yii::$app->reporter->col('QTY','80',null,false,'1px solid ','TB','R','Helvetica','10','B','','');
        Yii::$app->reporter->col('AMT','80',null,false,'1px solid ','TB','R','Helvetica','10','B','','');
        Yii::$app->reporter->col('TOTAL','80',null,false,'1px solid ','TB','R','Helvetica','10','B','','');
    Yii::$app->reporter->endrow();    
Yii::$app->reporter->endtable();  

Yii::$app->reporter->begintable('800');
//var_dump($data);
$amt=null;
$itemname="";
$subtotal=0;
$ordtotal=0;
$remtotal=0;
$cus="";
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$item="";
for($i=0;$i<count($data);$i++){

    if ($item != $data[$i]['barcode']){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['itemname'],'800',null,false,'1px dotted ','TB','L','Helvetica','10','B','b','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('800');
        $item =  $data[$i]['barcode'];
    }//end fn

   Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['clientname'],'210',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'80',null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'80',null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'80',null,false,'1px solid ','','R','Helvetica','10','','','');
   Yii::$app->reporter->endrow();
   $ordtotal += $data[$i]['ext'];
}      

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','L','Helvetica','10','','','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','Helvetica','10','B','b','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','Helvetica','10','B','b','');
    Yii::$app->reporter->col('','210',null,false,'1px dotted ','TB','L','Helvetica','10','B','b','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','TB','L','Helvetica','10','B','b','');
    Yii::$app->reporter->col('GRAND','80',null,false,'1px dotted ','TB','R','Helvetica','10','B','b','');
    Yii::$app->reporter->col('TOTAL:','80',null,false,'1px dotted ','TB','R','Helvetica','10','B','b','');
    Yii::$app->reporter->col(number_format($ordtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'80',null,false,'1px dotted ','TB','R','Helvetica','10','B','b','');
   Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

// //var_dump($params);
// //var_dump($data);
 ?>