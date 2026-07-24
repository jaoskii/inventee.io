<?php
//WTODO : ALVIN 10.29.2018 
//RTTREPORTS2
date_default_timezone_set('Asia/Manila');
$this->title = 'Supplier Ledger Report - AP';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=54;
//$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport();

$clientqry = "select client, clientname, addr, tel, tel2, tin, mobile, email, contact, fax from client where clientid = '".$params['clientid']."'";
$clientinfo = Yii::$app->sbccommon->opentable($clientqry);

    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;&nbsp;&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Avenir','13','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER LEDGER - ACCOUNTS PAYABLE ',null,null,false,'1px solid ','','','Avenir','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
  
Yii::$app->reporter->begintable('700');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Report Type :','80',null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col(strtoupper($params['reporttype']),'25',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->col('View Accounts from :','150',null,false,'1px solid ','','R','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.$params['startdate'],'100',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        /* Yii::$app->reporter->col('Agent:','70',null,false,'1px solid ','','R','Avenir','11','','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Avenir','11','B','','1px'); */
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();       
 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Supplier:','50',null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['clientname'])? $clientinfo[0]['clientname']:''),400,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->col('Telephone No/s:','100',null,false,'1px solid ','','R','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['tel'])? $clientinfo[0]['tel']:''),250,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address:','50',null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['addr'])? $clientinfo[0]['addr']:''),400,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->col('Fax No/s:','100',null,false,'1px solid ','','R','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['fax'])? $clientinfo[0]['fax']:''),250,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('TIN #:','50',null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['tin'])? $clientinfo[0]['tin']:''),400,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->col('Mobile No/s.:','100',null,false,'1px solid ','','R','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['tel2'])? $clientinfo[0]['tel2']:''),250,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col('',400,null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col('Email Address:','100',null,false,'1px solid ','','R','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['email'])? $clientinfo[0]['email']:''),250,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col('',400,null,false,'1px solid ','','L','Avenir','11','','','1px');
        Yii::$app->reporter->col('Contact Person:','100',null,false,'1px solid ','','R','Avenir','11','','','1px');
        Yii::$app->reporter->col('&nbsp;&nbsp;'.(isset($clientinfo[0]['contact'])? $clientinfo[0]['contact']:''),250,null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');  
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->col('Run Date :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Avenir','11','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Document #','150',null,false,'1px solid ','B','C','Avenir','11','B','','');
    Yii::$app->reporter->col('Date','100',null,false,'1px solid ','B','C','Avenir','11','B','','');
    /* Yii::$app->reporter->col('Agent','100',null,false,'1px solid ','B','C','Avenir','11','B','',''); */
    /* Yii::$app->reporter->col('Notes ','100',null,false,'1px solid ','B','C','Avenir','11','B','',''); */
    Yii::$app->reporter->col('Debit','150',null,false,'1px solid ','B','C','Avenir','11','B','','');
    Yii::$app->reporter->col('Credit','150',null,false,'1px solid ','B','C','Avenir','11','B','','');
    Yii::$app->reporter->col('Balance','100',null,false,'1px solid ','B','C','Avenir','11','B','','');
    Yii::$app->reporter->col('Reference','150',null,false,'1px solid ','B','C','Avenir','11','B','','');
    
    $totaldb=0;
    $totalcr=0;
    $totalbal=0;
    $belence = 0;
    $initial_balance = 0;
    
for($i=0;$i<count($data);$i++){
            if($data[$i]['docno'] == 'Beginning Balance'){
                $credit=number_format($data[$i]['cr'],2);
            }else{
                $credit=number_format($data[$i]['cr'],2);
            }//end if

            if ($credit<1){
                $credit='-';
            }

            $debit=number_format($data[$i]['db'],2);
            
            if ($debit<1){
                $debit='-';
            }//end if

            $balance=number_format($data[$i]['bal'],2);
            if ($balance<1){
                $balance='-';
            }//end if


            if($data[$i]['cr'] != 0){
                if($balance != '-'){
                    $data[$i]['bal'] = $data[$i]['bal'] * -1;
                }//end if
            }//end if

            $belence = $data[$i]['db'] - $data[$i]['cr'];
                
            if($belence < 0){
                //balance if less than zero add to running balance
                $initial_balance += abs($belence);
            }else{
                //balance if greater than 0 subtract to runnign balance
                $initial_balance =  $initial_balance -  abs($belence);
            }//end if

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','','L','Avenir','9','','','');
    Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Avenir','9','','','');
    /* Yii::$app->reporter->col($data[$i]['agent'],'100',null,false,'1px solid ','','C','Avenir','9','','',''); */
    /* Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'1px solid ','','C','Avenir','9','','',''); */
    Yii::$app->reporter->col($debit,'150',null,false,'1px solid ','','R','Avenir','9','','','');
    Yii::$app->reporter->col($credit,'150',null,false,'1px solid ','','R','Avenir','9','','','');
    Yii::$app->reporter->col(number_format($initial_balance,2),'100',null,false,'1px solid ','','R','Avenir','9','','','');
    Yii::$app->reporter->col($data[$i]['ref'],'150',null,false,'1px solid ','','C','Avenir','9','','','');
    $totaldb=$totaldb+$data[$i]['db'];
    $totalcr=$totalcr+$data[$i]['cr'];
    $totalbal=$totalbal+$data[$i]['bal'];
    Yii::$app->reporter->endrow();
}
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','150',null,false,'1px dotted ','T','L','Avenir','9','B','','3px');
    /* Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','C','Avenir','9','B','','3px'); */
    /* Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Avenir','9','B','','3px'); */
    Yii::$app->reporter->col('Grand Total :','100',null,false,'1px dotted ','T','C','Avenir','9','B','','3px');
    Yii::$app->reporter->col(number_format($totaldb,2),'150',null,false,'1px dotted ','T','R','Avenir','9','B','','3px');
    Yii::$app->reporter->col(number_format($totalcr,2),'150',null,false,'1px dotted ','T','R','Avenir','9','B','','3px');
    Yii::$app->reporter->col(number_format($initial_balance,2),'100',null,false,'1px dotted ','T','R','Avenir','9','B','','3px');
    Yii::$app->reporter->col('','150',null,false,'1px dotted ','T','C','Avenir','9','B','','3px');
    Yii::$app->reporter->endrow();
    
Yii::$app->reporter->endtable();


echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Avenir','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Avenir','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Avenir','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->endtable();


//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


?>
