<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Journal - Detailed';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=59;
Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('DETAILED PURCHASE JOURNAL',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();


        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        if($params['client']==''){
        Yii::$app->reporter->col('Supplier :'. 'ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Supplier :'. $params['client'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction : '. strtoupper($params['reporttype']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center :'.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('DATE','75',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('SUPPLIER NAME','200',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('INVENTORY DEBIT','75',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('A/P CREDIT','50px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ACCOUNT DESCRIPTION','200',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DEBIT','75',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('CREDIT','75',null,false,'1px solid ','B','C','Century Gothic','11','B','','');

$totalrdb=0;
$totalrcr=0;
$totalsdb=0;
$totalscr=0;
$docno="";
$cname="";
$date="";
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
    if(0==0){
        $amt='';
    }else{
        $amt=0;
    }
    
    if ($docno==$data[$i]['docno']){
    $docno="";
    $date="";
    $clname="";
}else{
    $docno=$data[$i]['docno'];
    $date=$data[$i]['dateid'];
    $clname=$data[$i]['clientname'];
}
    
    
    
            $suncr=number_format($data[$i]['suncr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($suncr==0)
            {
            $suncr='-';
            }
            
            $sundb=number_format($data[$i]['sundb'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($sundb==0)
            {
            $sundb='-';
            }
            
            $regcr=number_format($data[$i]['regcr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($regcr==0)
            {
            $regcr='-';
            }
            
            $regdb=number_format($data[$i]['regdb'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($regdb==0)
            {
            $regdb='-';
            }
      
      Yii::$app->reporter->col($date,'75',null,false,'1px solid ','','C','Century Gothic','10','','','');
      Yii::$app->reporter->col($docno,'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
      Yii::$app->reporter->col($clname,'225',null,false,'1px solid ','','L','Century Gothic','10','','','');
      Yii::$app->reporter->col($regdb,'75',null,false,'1px solid ','','R','Century Gothic','10','','','');
      Yii::$app->reporter->col($regcr,'75',null,false,'1px solid ','','R','Century Gothic','10','','','');
      Yii::$app->reporter->col($data[$i]['sunacctname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
      Yii::$app->reporter->col($sundb,'75',null,false,'1px solid ','','R','Century Gothic','10','','','');
      Yii::$app->reporter->col($suncr,'75',null,false,'1px solid ','','R','Century Gothic','10','','','');
      $totalrdb=$totalrdb+$data[$i]['regdb'];
      $totalrcr=$totalrcr+$data[$i]['regcr'];
      $totalsdb=$totalsdb+$data[$i]['sundb'];
      $totalscr=$totalscr+$data[$i]['suncr'];
      
      $docno=$data[$i]['docno'];
      $date=$data[$i]['dateid'];
      $clname=$data[$i]['clientname'];
      
      Yii::$app->reporter->endrow();
    

    if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('DETAILED PURCHASE JOURNAL',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        //Yii::$app->reporter->col('DETAILED PURCHASE JOURNAL',null,null,false,'1px solid ','','c','Century Gothic','20','b','','');
        Yii::$app->reporter->endrow();


        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        if($params['client']==''){
        Yii::$app->reporter->col('Supplier :'. 'ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Supplier :'. $params['client'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction : '. strtoupper($params['reporttype']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center :'.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('DATE','75',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('SUPPLIER NAME','200',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('INVENTORY DEBIT','75',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('A/P CREDIT','50px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ACCOUNT DESCRIPTION','200',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DEBIT','75',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('CREDIT','75',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->printline();


        Yii::$app->reporter->begintable();

        $page=$page + $count;
    }
}




//    function ($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
    Yii::$app->reporter->startrow();

    
    Yii::$app->reporter->col('','75',null,false,'1px solid ','T','C','Century Gothic','10','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','T','C','Century Gothic','10','B','','');
    Yii::$app->reporter->col('TOTAL :','225',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->col(number_format($totalrdb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->col(number_format($totalrcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->col('','200',null,false,'1px solid ','T','L','Century Gothic','10','B','','');
    Yii::$app->reporter->col(number_format($totalsdb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->col(number_format($totalscr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

 Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>