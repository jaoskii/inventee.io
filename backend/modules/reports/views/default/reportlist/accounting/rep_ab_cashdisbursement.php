<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Cash Disbursement Book - Detailed';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=40;
$page=40;

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('DETAILED CASH DISBURSEMENT BOOK',null,null,'','1px solid ','','l','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow('');
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','Century Gothic','10','','','');
            Yii::$app->reporter->col('Center:'.$params['center'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col('Transaction: '. strtoupper($params['reporttype']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
            if($params['client']==''){
            Yii::$app->reporter->col('Supplier: ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
            } else {
            Yii::$app->reporter->col('Supplier: '.$params['client'],null,null,'','1px solid ','','l','Century Gothic','10','','','');    
            }
            //Yii::$app->reporter->pagenumber('Page',null,null,'','1px solid ','','l','Century Gothic','','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                 Yii::$app->reporter->col('DOCUMENT #',null,null,'','1px solid ','B','l','Century Gothic','11','B','','5px,10px,20px,30px');
                 Yii::$app->reporter->col('PAYEE NAME PARTICULARS',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DATE',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('ACCOUNT CODE',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('ACCOUNT DESCRIPTION',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('REFFERENCE #',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                  Yii::$app->reporter->col('DEBIT',null,null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('CREDIT',null,null,'','1px solid ','B','r','Century Gothic','11','B','','');
        




      $totalardb=0;
	    $totalrcr=0;
	    $totaldb=0;
	    $totalcr=0;
            $docno="";
            $date="";
            $cname="";
            $db=0;
            $cr=0;
   // for($i=0;$i<10;$i++){
   for($i=0;$i<count($data);$i++){
if ($docno==$data[$i]['docno']){
    $docno="";
    $date="";
    $cname="";
}else{
    $docno=$data[$i]['docno'];
    $date=$data[$i]['dateid'];
    $cname=$data[$i]['clientname'];
}

            $debit=number_format($data[$i]['debit'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($debit==0)
            {
            $debit='-';
            }
             $credit=number_format($data[$i]['credit'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($credit==0)
            {
            $credit='-';
            }


         Yii::$app->reporter->startrow();
              Yii::$app->reporter->addline();
                 Yii::$app->reporter->col($docno,null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($cname,null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($date,null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($data[$i]['acno'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($data[$i]['description'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($data[$i]['ref'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($debit,null,null,'','1px solid ','','r','Century Gothic','10','','','');
                 Yii::$app->reporter->col($credit,null,null,'','1px solid ','','r','Century Gothic','10','','','');

                
            $totaldb=$totaldb + $data[$i]['debit'];
            $totalcr=$totalcr + $data[$i]['credit'];

            $docno=$data[$i]['docno'];
            $date=$data[$i]['dateid'];
            $cname=$data[$i]['clientname'];

                 Yii::$app->reporter->endrow();

        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

            Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

        Yii::$app->reporter->begintable('800',null,'','1px solid ','','','Century Gothic','','b','','');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('DETAILED CASH DISBURSEMENT BOOK',null,null,'','1px solid ','','l','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','','10','','','');
            Yii::$app->reporter->col('Center:'.$params['center'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col('Transaction: '. strtoupper($params['reporttype']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
            if($params['client']==''){
            Yii::$app->reporter->col('Supplier: ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
            } else {
            Yii::$app->reporter->col('Supplier: '.$params['client'],null,null,'','1px solid ','','l','Century Gothic','10','','','');    
            }
            
            //Yii::$app->reporter->pagenumber('Page',null,null,'','1px solid ','','l','Century Gothic','','','','');,null,null,'','1px solid ','','l','Century Gothic','','','','');
        Yii::$app->reporter->endrow();
         Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                 Yii::$app->reporter->col('DOCUMENT #',null,null,'','1px solid ','B','l','Century Gothic','11','B','','5px,10px,20px,30px');
                 Yii::$app->reporter->col('PAYEE NAME PARTICULARS',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DATE',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('ACCOUNT CODE',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('ACCOUNT DESCRIPTION',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('REFFERENCE #',null,null,'','1px solid ','B','l','Century Gothic','11','B','','');
                  Yii::$app->reporter->col('DEBIT',null,null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('CREDIT',null,null,'','1px solid ','B','r','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();

            $page=$page + $count;
        }
    }


    Yii::$app->reporter->startrow('',null,'','1px solid ','','B','Century Gothic','12','B','','');
                 Yii::$app->reporter->col('',null,null,'','1px solid ','T','c','','Century Gothic','','','');
                 Yii::$app->reporter->col('',null,null,'','1px solid ','T','c','','Century Gothic','','','');
                 Yii::$app->reporter->col('',null,null,'','1px solid ','T','c','','Century Gothic','','','');
                 Yii::$app->reporter->col('',null,null,'','1px solid ','T','c','','Century Gothic','','','');
                 Yii::$app->reporter->col('GRAND TOTAL: ',null,null,'','1px solid ','T','c','','10','','');
                 Yii::$app->reporter->col('',null,null,'','1px solid ','T','c','','Century Gothic','','','');
                 Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')),null,null,'','1px solid ','T','r','Century Gothic','10','','');
                 Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),null,null,'','1px solid ','T','r','Century Gothic','10','','');
    Yii::$app->reporter->endrow();



Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
//
//var_dump($params);
//var_dump($data);

?>