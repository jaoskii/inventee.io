<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Stockcard Ledger Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=54;
Yii::$app->reporter->beginreport();

 //if (Yii::$app->backend->getcompanyid() == 1) {
    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('STACKCARD - PO ',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
  
Yii::$app->reporter->begintable('425');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('View Accounts from :','125',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col($params['startdate'].' to '.$params['enddate'],'150',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('View by Unit :','75',null,false,'1px solid ','','R','Century Gothic','11','','','1px');
        Yii::$app->reporter->col($params['uom'],'75',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();           
 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Item Code:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['barcode'])? $data[0]['barcode']:''),'375',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Price Levels','350',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('775');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Item Name:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['itemname'])? $data[0]['itemname']:''),'400',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Retail:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['priceretail'])? number_format($data[0]['priceretail'],2):''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Disc 1:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['discretail'])? $data[0]['discretail']:''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->begintable('770');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Brand:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['brand'])? $data[0]['brand']:''),'400',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Wholesale:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['pricewhole'])? number_format($data[0]['pricewhole'],2):''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Disc 2:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['discwhole'])? $data[0]['discwhole']:''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('770');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Model:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['model'])? $data[0]['model']:''),'400',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Group 1:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['pricegrp1'])? number_format($data[0]['pricegrp1'],2):''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Disc 3:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['discgrp1'])? $data[0]['discgrp1']:''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('773');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Part#:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['part'])? $data[0]['part']:''),'400',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Group 2:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['pricegrp2'])? number_format($data[0]['pricegrp2'],2):''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Disc 4:','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['discgrp2'])? $data[0]['discgrp2']:''),'100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('775');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Size:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['sizeid'])? $data[0]['sizeid']:''),'400',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        if ((isset($data[0]['isinactive'])? $data[0]['isinactive']:'')==1) {
           Yii::$app->reporter->col('Innactive','100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        }else{
            Yii::$app->reporter->col('Innactive','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        }
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        if ((isset($data[0]['isimport'])? $data[0]['isimport']:'')==1) {
           Yii::$app->reporter->col('Imported','100',null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        }else{
            Yii::$app->reporter->col('Imported','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        }
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/>';

Yii::$app->reporter->begintable('800');  
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col('Run Date :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Document #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('Date','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('Supplier Name','400',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('Ordered','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('Received','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
    
    
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
    Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
    Yii::$app->reporter->col($data[$i]['clientname'],'400',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col(number_format($data[$i]['qty'],2),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
    Yii::$app->reporter->col(number_format($data[$i]['qa'],2),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
    Yii::$app->reporter->endrow();
}
Yii::$app->reporter->endtable();

echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->endtable();


//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


?>
