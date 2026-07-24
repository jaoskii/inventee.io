<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Pending Sales Order';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PENDING SALES ORDERS',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

if($params['client']==''){
    $cus='ALL';
} else {
    $cus=$params['client'];
}
if($params['item']==''){
    $item='ALL';
} else {
     $item=$params['item'];
}
if($params['group']==''){
    $group='ALL';
} else {
    $group=$params['group'];
}
if($params['brand']==''){
    $brand='ALL';
} else {
    $brand=$params['brand'];
}
if($params['class']==''){
    $class='ALL';
} else {
    $class=$params['class'];
}
if($params['transtype']=='client'){
    $sorty='CUSTOMER';
} else {
    $sorty='ITEM';
}
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Customer : '.strtoupper($cus),NULL,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Item : '.strtoupper($item),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Group :'. strtoupper($group),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','b','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Brand : '. strtoupper($brand),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Class : '. strtoupper($class),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Sort By : '. strtoupper($sorty),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Center : '.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUSTOMER NAME','110',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('REFERENCE #','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DATE','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ORDERED','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('SERVED','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('BALANCE','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('UOM','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();

$item=null;
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
    Yii::$app->reporter->endrow();
        $display=$data[$i]['itemname'];
        $docno=$data[$i]['docno'];
        $date=$data[$i]['dateid'];
        $order=$data[$i]['qty'];
        $served=$data[$i]['qa'];
        $bal=$data[$i]['unserved'];
        $uom=$data[$i]['uom'];
   Yii::$app->reporter->startrow();
    if ($item==$data[$i]['clientname']){
        $dis="";
    } else {
        $dis=Yii::$app->reporter->col($data[$i]['clientname'],'110px',null,false,'1px dotted ','T','L','Century Gothic','10','B','','');
        $dis2=Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','B','10','','','');
        $dis3=Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','B','10','','','');
        $dis3=Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','B','10','','','');
        $dis4=Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','B','10','','','');
        $dis5=Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','B','10','','','');
        $dis6=Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','B','10','','','');
        $dis7=Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','B','10','','','');
    }
   echo $dis;
   Yii::$app->reporter->endrow();
   Yii::$app->reporter->startrow();

   Yii::$app->reporter->col($display,'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
   Yii::$app->reporter->col($docno,'110px',null,false,'1px solid ','','C','Century Gothic','10','','','');
   Yii::$app->reporter->col($data[$i]['yourref'],'110px',null,false,'1px solid ','','C','Century Gothic','10','','','');
   Yii::$app->reporter->col($date,'110px',null,false,'1px solid ','','C','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($order,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'110px',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($served,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'110px',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($bal,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'110px',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->col($uom,'110px',null,false,'1px solid ','','C','Century Gothic','10','','','');
   Yii::$app->reporter->endrow();
   $item=$data[$i]['clientname'];

   if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

            Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PENDING SALES ORDERS',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

if($params['client']==''){
    $cus='ALL';
} else {
    $cus=$params['client'];
}
if($params['item']==''){
    $item='ALL';
} else {
     $item=$params['item'];
}
if($params['group']==''){
    $group='ALL';
} else {
    $group=$params['group'];
}
if($params['brand']==''){
    $brand='ALL';
} else {
    $brand=$params['brand'];
}
if($params['class']==''){
    $class='ALL';
} else {
    $class=$params['class'];
}
if($params['transtype']=='client'){
    $sorty='CUSTOMER';
} else {
    $sorty='ITEM';
}
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Customer : '.strtoupper($cus),NULL,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Item : '.strtoupper($item),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Group :'. strtoupper($group),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','b','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Brand : '. strtoupper($brand),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Class : '. strtoupper($class),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Sort By : '. strtoupper($sorty),null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Center : '.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUSTOMER NAME','110',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('REFERENCE #','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DATE','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ORDERED','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('SERVED','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('BALANCE','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('UOM','110',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        $page=$page + $count;
    }
    }

Yii::$app->reporter->endreport();

//var_dump($params);
// var_dump($data);

?>