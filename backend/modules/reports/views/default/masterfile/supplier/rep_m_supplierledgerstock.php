<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Supplier Ledger Report - INVENTORY'; ?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=54;
Yii::$app->reporter->beginreport();

 
    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            $header=Yii::$app->reporter->letterhead();
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER LEDGER - POSTDATED CHECKS ',null,null,false,'1px solid ','','','Verdana','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
  
Yii::$app->reporter->begintable('700');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Report Type :','80',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col(strtoupper($params['reporttype']),'25',null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('View Accounts from :','150',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col($params['startdate'],'100',null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Agent:','70',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();      
 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Supplier:','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),400,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Telephone No/s.:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['tel'])? $data[0]['tel']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address:','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['addr'])? $data[0]['addr']:''),400,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Fax No/s:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['fax'])? $data[0]['fax']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('TIN #:','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),400,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Mobile No/s.:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['tel2'])? $data[0]['tel2']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('',400,null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('Email Address:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['email'])? $data[0]['email']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('',400,null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('Contact Person:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['contact'])? $data[0]['contact']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');  
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Verdana','11','','','');
        Yii::$app->reporter->col('Run Date :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Document #','75',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Date','75',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Item Code','50',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Description','200',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Discount ','50',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Unit Cost ','75',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Price','75',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('In','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Out','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    
    $totaldb=0;
    $totalcr=0;
    $totalbal=0;
for($i=0;$i<count($data);$i++){
    $cost=number_format($data[$i]['cost'],2);
            if ($cost<1)
            {
            $cost='-';
            }
            $rrqty=number_format($data[$i]['rrqty'],2);
            if ($rrqty<1)
            {
            $rrqty='-';
            }
            $isqty=number_format($data[$i]['isqty'],2);
            if ($isqty<1)
            {
            $isqty='-';
            }
            $rrcost=number_format($data[$i]['cost'],2);
            if ($rrcost<1)
            {
            $rrcost='-';
            }
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['docno'],'75',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['dateid'],'75',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['barcode'],'50',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['disc'],'50',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($rrcost,'75',null,false,'1px solid ','','R','Verdana','9','','','');
    Yii::$app->reporter->col($cost,'75',null,false,'1px solid ','','R','Verdana','9','','','');
    Yii::$app->reporter->col($rrqty,'100',null,false,'1px solid ','','R','Verdana','9','','','');
    Yii::$app->reporter->col($isqty,'100',null,false,'1px solid ','','R','Verdana','9','','','');
    Yii::$app->reporter->endrow();
}
    
    
Yii::$app->reporter->endtable();


echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Verdana','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Verdana','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Verdana','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>
