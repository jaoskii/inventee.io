<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Cash/Check Voucher Report';
//WTODO: [KIM][2019.11.22][update layout from voucher lx]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=30;
$page=30;
echo "<div style='letter-spacing: 5px'>";
Yii::$app->reporter->beginreport('1100');
Yii::$app->reporter->begintable('1100');
$loggeduser = Yii::$app->session['loggeduser']['name'];
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;&nbsp;'.strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Verdana','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_companyname'],null,null,false,'1px solid ','','c','Verdana','11','','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_contact'],null,null,false,'1px solid ','','c','Verdana','11','','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_address'],null,null,false,'1px solid ','','c','Verdana','11','','','').'<br />';
        Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('1100');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('V O U C H E R','750',null,false,'1px solid ','','L','Verdana','18','','','');
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Verdana','12','B','','');
        Yii::$app->reporter->col('No. &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:','160',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'160',null,false,'1px solid ','','R','Verdana','11','','','').'<br />';
    Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1100');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','150',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'578',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Verdana','11','B','','');
        Yii::$app->reporter->col('DATE &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','172',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'170',null,false,'1px solid ','','R','Verdana','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1100');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','150',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'600',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Verdana','11','B','','');
        Yii::$app->reporter->col('YOURREF #:','160',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'160',null,false,'1px solid ','','R','Verdana','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Verdana','10','','','4px');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
// echo '<div id="details" style="height:180px;clear:both;margin-top:2px;">';
Yii::$app->reporter->begintable('1100');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ACCOUNT','100',null,false,'1px solid ','TB','C','Verdana','11','','','4px');
        Yii::$app->reporter->col('ACCOUNT NAME','350',null,false,'1px solid ','TB','C','Verdana','11','','','');
        Yii::$app->reporter->col('CHECK DETAILS','200',null,false,'1px solid ','TB','C','Verdana','11','','','');
        Yii::$app->reporter->col('REF. #','150',null,false,'1px solid ','TB','C','Verdana','11','','','');
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','C','Verdana','11','','','');
        Yii::$app->reporter->col('REMARKS','100',null,false,'1px solid ','TB','C','Verdana','11','','','');
        Yii::$app->reporter->col('DEBIT','50',null,false,'1px solid ','TB','C','Verdana','11','','','');
        Yii::$app->reporter->col('CREDIT','50',null,false,'1px solid ','TB','C','Verdana','11','','','');
        

   $totaldb=0;
   $totalcr=0;
for($i=0;$i<count($data);$i++){
    
            $debit=number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($debit<1)
            {
            $debit='-';
            }
             $credit=number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($credit<1)
            {
            $credit='-';
            }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['acno'],'100',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['acnoname'],'350',null,false,'1px solid ','','L','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['checkno'],'200',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['invoiceno'],'150',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['postdate'],'100',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['drem'],'100',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($debit,'50',null,false,'1px solid ','','R','Verdana','11','','','2px');
        Yii::$app->reporter->col($credit,'50',null,false,'1px solid ','','R','Verdana','11','','','2px');
        $totaldb=$totaldb+$data[$i]['db'];
        $totalcr=$totalcr+$data[$i]['cr'];
        
}          
    Yii::$app->reporter->endtable();  

    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Verdana','11','B','','2px');
        Yii::$app->reporter->col('','350',null,false,'1px dotted ','T','C','Verdana','11','','','2px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','R','Verdana','11','B','30px','2px');
        Yii::$app->reporter->col('AMOUNT : ','150',null,false,'1px dotted ','T','C','Verdana','11','','','2px');
        Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','T','R','Verdana','11','','','2px');
        Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','T','R','Verdana','11','','','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTES : ','80',null,false,'1px solid ','','L','Verdana','11','','','8px');
        Yii::$app->reporter->col((isset($data[0]['rem'])? $data[0]['rem']:''),'720',null,false,'1px solid ','','L','Verdana','11','','','8px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();  
    
           
    Yii::$app->reporter->endtable();
    echo '<br/>';
    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','366',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('Approved By :','510',null,false,'1px solid ','','CL','Verdana','11','','','');
        Yii::$app->reporter->col('Received By :','222',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','366',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('&nbsp','366',null,false,'1px solid ','','C','Verdana','11','','','');
        Yii::$app->reporter->col('&nbsp','366',null,false,'1px solid ','','R','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'366',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col($approved,'366',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('&nbsp','150',null,false,'1px solid ','','R','Verdana','11','','','');
        Yii::$app->reporter->col($received,'216',null,false,'1px solid ','B','R','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';
    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Checked By : ','366',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('OR No. :','366',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('Date','366',null,false,'1px solid ','','C','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','366',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('&nbsp','366',null,false,'1px solid ','','C','Verdana','11','','','');
        Yii::$app->reporter->col('&nbsp','366',null,false,'1px solid ','','R','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($checked,'266',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Verdana','11','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
        Yii::$app->reporter->endreport();
echo '</div>';


?>