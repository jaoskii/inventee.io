<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Cash/Check Voucher Report - A';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=30;
$page=30;
echo '<div style="margin-top:-15px;">';
Yii::$app->reporter->beginreport('850');
Yii::$app->reporter->begintable('650');
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


Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('VOUCHER','450',null,false,'1px solid ','','L','Verdana','18','','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','','L','Verdana','11','','','').'<br />';
        Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','100',null,false,'1px solid ','','L','Verdana','11','','20px','2px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'350',null,false,'1px solid ','','L','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('DATE : ','50',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','100',null,false,'1px solid ','','L','Verdana','11','','20px','2px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'350',null,false,'1px solid ','','L','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('YOURREF # :','100',null,false,'1px solid ','','R','Verdana','12','','','');
        Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'150',null,false,'1px solid ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Verdana','10','','','4px');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
echo '<div id="details" style="height:180px;clear:both;margin-top:2px;">';
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('650');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ACCOUNT','100',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('ACCOUNT NAME','150',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('CHECK DETAILS','150',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('REF. #','100',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('REMARKS','100',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('DEBIT','50',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        Yii::$app->reporter->col('CREDIT','50',null,false,'1px solid ','B','C','Verdana','11','','20px','2px');
        

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
        Yii::$app->reporter->col($data[$i]['acnoname'],'150',null,false,'1px solid ','','L','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['checkno'],'150',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['ref'],'100',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['postdate'],'100',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['drem'],'100',null,false,'1px solid ','','C','Verdana','11','','','2px');
        Yii::$app->reporter->col($debit,'50',null,false,'1px solid ','','R','Verdana','11','','','2px');
        Yii::$app->reporter->col($credit,'50',null,false,'1px solid ','','R','Verdana','11','','','2px');
        $totaldb=$totaldb+$data[$i]['db'];
        $totalcr=$totalcr+$data[$i]['cr'];
        
}          
    Yii::$app->reporter->endtable();  

    Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Verdana','11','B','','2px');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','T','C','Verdana','11','','','2px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','R','Verdana','11','B','30px','2px');
        Yii::$app->reporter->col('AMOUNT : ','100',null,false,'1px dotted ','T','C','Verdana','11','','','2px');
        Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','T','R','Verdana','11','','','2px');
        Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','T','R','Verdana','11','','','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTES : ','80',null,false,'1px solid ','','L','Verdana','12','','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['rem'])? $data[0]['rem']:''),'720',null,false,'1px solid ','','L','Verdana','12','','30px','4px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();  
    echo '</div>';
           
    Yii::$app->reporter->endtable();
    echo '<br/>';
    Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    
    Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Verdana','12','','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';
    Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Checked By : ','266',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col('OR No. :','266',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col('Date','266',null,false,'1px solid ','','C','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('650');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($checked,'266',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
        Yii::$app->reporter->endreport();
echo '</div>';

//var_dump($params);
// var_dump($data);

?>