<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;
Yii::$app->reporter->beginreport();
Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

            // Yii::$app->reporter->begintable('800');
            //     Yii::$app->reporter->startrow();
            //         Yii::$app->reporter->col('CONSIGNMENT RECEIPT','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
            //         Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
            //         Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
            //     Yii::$app->reporter->endrow();
            // Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('DELIVERY REPORT','800',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Customer : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'200',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('DR No : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Address : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'300',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Date : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            $dd=substr($data[0]['dateid'],0,10);
            Yii::$app->reporter->col((isset($dd)? $dd:''),'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();    
 
 
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Quantity','50px',null,false,'1px solid ','TB','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('Unit','50px',null,false,'1px solid ','TB','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('Code','50px',null,false,'1px solid ','TB','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('Description','500px',null,false,'1px solid ','TB','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('Price','125px',null,false,'1px solid ','TB','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('Amount','125px',null,false,'1px solid ','TB','C','Century Gothic','12','B','30px','8px');

   $totalext=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['barcode'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'500px',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col('','125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col('','125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        $totalext=$totalext+$data[$i]['ext'];
        
}   

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('TOTAL :','50px',null,false,'1px dotted ','TB','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','50px',null,false,'1px dotted ','TB','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','500px',null,false,'1px dotted ','TB','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','125px',null,false,'1px dotted ','TB','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','50px',null,false,'1px dotted ','TB','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','125px',null,false,'1px dotted ','TB','R','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();


    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Prepared By : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->col('Received By : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col($received,'200',null,false,'1px solid ','B','C','Century Gothic','12','','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
  
    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>