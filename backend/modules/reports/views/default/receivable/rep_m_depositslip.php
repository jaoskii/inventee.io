<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Deposit Slip Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
$header=Yii::$app->reporter->letterhead();

Yii::$app->reporter->beginreport();



    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;&nbsp;&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Century Gothic','13','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DEPOSIT SLIP','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BANK NAME : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        for($i=0;$i<count($data);$i++){
        if(substr($data[$i]['alias'],0,-1)=='CB'){
        Yii::$app->reporter->col($data[$i]['acnoname'],'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        }
        }
        Yii::$app->reporter->col('DATE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','','Century Gothic','10','','','4px');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ACCT.#','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('ACCOUNT NAME','350',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('REFERENCE #','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DATE','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DEBIT','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CREDIT','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CLIENT','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

        

   $totaldb=0;
   $totalcr=0;
for($i=0;$i<count($data);$i++){
    
        $debit=number_format($data[$i]['db'],2);
            if ($debit<1)
            {
            $debit='-';
            }
             $credit=number_format($data[$i]['cr'],2);
            if ($credit<1)
            {
            $credit='-';
            }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['acno'],'75',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['acnoname'],'350',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['ref'],'75',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['postdate'],'75',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($debit,'75',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($credit,'75',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['client'],'75',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        $totaldb=$totaldb+$data[$i]['db'];
        $totalcr=$totalcr+$data[$i]['cr'];
        
        
        
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

 if (Yii::$app->backend->getcompanyid() == 1) {
    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;&nbsp;&nbsp;RSSC','600',null,false,'1px solid ','','L','Century Gothic','13','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
}    

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DEPOSIT SLIP','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BANK NAME : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        for($i=0;$i<count($data);$i++){
        if(substr($data[$i]['alias'],0,-1)=='CB'){
        Yii::$app->reporter->col($data[$i]['acnoname'],'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        }
        }
        Yii::$app->reporter->col('DATE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ACCT.#','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('ACCOUNT NAME','350',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('REFERENCE #','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DATE','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DEBIT','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CREDIT','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CLIENT','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->endrow();
               Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}   
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','C','Century Gothic','12','B','','2px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','C','Century Gothic','12','B','','2px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','C','Century Gothic','12','B','','2px');
        Yii::$app->reporter->col('GRAND TOTAL :','350',null,false,'1px dotted ','T','R','Century Gothic','12','B','30px','2px');
        Yii::$app->reporter->col(number_format($totaldb,2),'75',null,false,'1px dotted ','T','R','Century Gothic','12','B','','2px');
        Yii::$app->reporter->col(number_format($totalcr,2),'75',null,false,'1px dotted ','T','R','Century Gothic','12','B','','2px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>