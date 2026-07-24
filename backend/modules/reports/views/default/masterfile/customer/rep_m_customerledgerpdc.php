<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Customer Ledger Report - PDC';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=54;
//$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport();

 
    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;&nbsp;&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Verdana','13','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER LEDGER - POSTDATED CHECKS ',null,null,false,'1px solid ','','','Verdana','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
  
Yii::$app->reporter->begintable('700');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Report Type :','80',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col(strtoupper($params['reporttype']),'25',null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('View Accounts from :','150',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.$params['startdate'],'100',null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Agent:','70',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();              
 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Customer:','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['clientname'])? $data[0]['clientname']:''),400,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Telephone No/s:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['tel'])? $data[0]['tel']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address:','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['addr'])? $data[0]['addr']:''),400,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Fax No/s:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['fax'])? $data[0]['fax']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('TIN #:','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['tin'])? $data[0]['tin']:''),400,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->col('Mobile No/s.:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['tel2'])? $data[0]['tel2']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('',400,null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('Email Address:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['email'])? $data[0]['email']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('',400,null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col('Contact Person:','100',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($data[0]['contact'])? $data[0]['contact']:''),250,null,false,'1px solid ','','L','Verdana','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');  
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Verdana','11','','','');
        Yii::$app->reporter->col('Run Date :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Document #','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Date','50',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Agent','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Notes ','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Debit','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Credit','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Balance','100',null,false,'1px solid ','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('Reference','150',null,false,'1px solid ','B','C','Verdana','11','B','','');
    
    $totaldb=0;
    $totalcr=0;
    $totalbal=0;
for($i=0;$i<count($data);$i++){
            $credit=number_format($data[$i]['cr'],2);
            if ($credit<1)
            {
            $credit='-';
            }
            $debit=number_format($data[$i]['db'],2);
            if ($debit<1)
            {
            $debit='-';
            }
            $balance=number_format($data[$i]['bal'],2);
            if ($balance<1)
            {
            $balance='-';
            }
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['dateid'],'50',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['agent'],'100',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'1px solid ','','C','Verdana','9','','','');
    Yii::$app->reporter->col($debit,'100',null,false,'1px solid ','','R','Verdana','9','','','');
    Yii::$app->reporter->col($credit,'100',null,false,'1px solid ','','R','Verdana','9','','','');
    Yii::$app->reporter->col($balance,'100',null,false,'1px solid ','','R','Verdana','9','','','');
    Yii::$app->reporter->col($data[$i]['ref'],'150',null,false,'1px solid ','','C','Verdana','9','','','');
    $totaldb=$totaldb+$debit;
    $totalcr=$totalcr+$credit;
    $totalbal=$totalbal+$data[$i]['bal'];
    Yii::$app->reporter->endrow();
}
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','L','Verdana','9','B','','3px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','C','Verdana','9','B','','3px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Verdana','9','B','','3px');
    Yii::$app->reporter->col('Grand Total :','100',null,false,'1px dotted ','T','C','Verdana','9','B','','3px');
    Yii::$app->reporter->col(number_format($totaldb,2),'100',null,false,'1px dotted ','T','R','Verdana','9','B','','3px');
    Yii::$app->reporter->col(number_format($totalcr,2),'100',null,false,'1px dotted ','T','R','Verdana','9','B','','3px');
    Yii::$app->reporter->col(number_format($totalbal,2),'100',null,false,'1px dotted ','T','R','Verdana','9','B','','3px');
    Yii::$app->reporter->col('','150',null,false,'1px dotted ','T','C','Verdana','9','B','','3px');
    Yii::$app->reporter->endrow();
    
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


//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


?>
