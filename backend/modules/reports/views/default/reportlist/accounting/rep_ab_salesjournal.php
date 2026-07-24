<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal - Detailed';
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

Yii::$app->reporter->begintable('800',null,'','1px solid ','','','Century Gothic','','','','');
        Yii::$app->reporter->startrow();
         //($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED SALES JOURNAL',null,null,'','1px solid ','','l','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','','10','','','');
            
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,'','1px solid ','','l','','10','','','');
            Yii::$app->reporter->col('Center: '.$params['center'],null,null,'','1px solid ','','l','','10','','','');
            Yii::$app->reporter->col('Transaction: '. strtoupper($params['reporttype']),null,null,'','1px solid ','','l','','10','','','');
            Yii::$app->reporter->pagenumber('Page');

        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow('',null,'','1px solid ','','','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('','75',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','100',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','175',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','75',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','75',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('','150',null,'','1px solid ','B','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('SUNDRIES','75',null,'','1px solid ','B','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('','75',null,'','1px solid ','B','c','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow('',null,'','1px solid ','','','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DATE','75',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DOCUMENT #','100',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('COSTUMER NAME','175',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('A/R DEBIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('SALES CREDIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('ACCOUNT DESCRIPTION','150',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DEBIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('CREDIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        $totalrdb=0;
	    $totalrcr=0;
	    $totaldb=0;
	    $totalcr=0;
            $docno="";
            $date="";
            $cname="";
            $db=0;
            $cr=0;
            $totalsundb=0;
            $totalsuncr=0;
   //for($i=0;$i<35;$i++){
   for($i=0;$i<count($data);$i++){

if ($docno==$data[$i]['docno']){
    $docno="";
    $date="";
    $clname="";
}else{
    $docno=$data[$i]['docno'];
    $date=$data[$i]['dateid'];
    $clname=$data[$i]['clientname'];
}
        
      $regdb=number_format($data[$i]['regdb'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($regdb==0)
            {
            $regdb='-';
            }
      
       $regcr=number_format($data[$i]['regcr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($regcr==0)
            {
            $regcr='-';
            }

              $sundb=number_format($data[$i]['sundb'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($sundb==0)
            {
            $sundb='-';
            }

       $suncr=number_format($data[$i]['suncr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($suncr==0)
            {
            $suncr='-';
            }

         Yii::$app->reporter->startrow();
              Yii::$app->reporter->addline();
                 Yii::$app->reporter->col($date,'75',null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($docno,'100',null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($clname,'175',null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($regdb,'75',null,'','1px solid ','','r','Century Gothic','10','','','');
                 Yii::$app->reporter->col($regcr,'75',null,'','1px solid ','','r','Century Gothic','10','','','');
                 Yii::$app->reporter->col($data[$i]['sunacctname'],'150',null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($sundb,'75',null,'','1px solid ','','r','Century Gothic','10','','','');
                 Yii::$app->reporter->col($suncr,'75',null,'','1px solid ','','r','Century Gothic','10','','','');

            // $totaldb=$totaldb + $data[$i]['regdb'];
            // $totalcr=$totalcr + $data[$i]['regcr'];

            $totalsundb=$totalsundb + $data[$i]['sundb'];
            $totalsuncr=$totalsuncr + $data[$i]['suncr'];
            $totalrdb=$totalrdb + $data[$i]['regdb'];
            $totalrcr=$totalrcr + $data[$i]['regcr'];
            
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

Yii::$app->reporter->begintable('800',null,'','1px solid ','','','Century Gothic','','','','');
        Yii::$app->reporter->startrow();
         //($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED SALES JOURNAL',null,null,'','1px solid ','','l','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','','10','','','');
                
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,'','1px solid ','','l','','10','','','');
            Yii::$app->reporter->col('Center: '.$params['center'],null,null,'','1px solid ','','l','','10','','','');
            Yii::$app->reporter->col('Transaction: '. strtoupper($params['reporttype']),null,null,'','1px solid ','','l','','10','','','');
            Yii::$app->reporter->pagenumber('Page');

        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow('',null,'','1px solid ','','','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('','75',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','100',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','175',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','75',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col(' ','75',null,'','1px solid ','','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('','150',null,'','1px solid ','B','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('SUNDRIES','75',null,'','1px solid ','B','c','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('','75',null,'','1px solid ','B','c','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow('',null,'','1px solid ','','','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DATE','75',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DOCUMENT #','100',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('COSTUMER NAME','175',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('A/R DEBIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('SALES CREDIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('ACCOUNT DESCRIPTION','150',null,'','1px solid ','B','l','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('DEBIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
                 Yii::$app->reporter->col('CREDIT','75',null,'','1px solid ','B','r','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();

            $page=$page + $count;
        }
    }


    Yii::$app->reporter->startrow('',null,'','1px solid ','','B','Century Gothic','B','12','','');

 Yii::$app->reporter->col('','75',null,'','1px solid ','T','r','Century Gothic','11','B','','');
 Yii::$app->reporter->col('','100',null,'','1px solid ','T','r','Century Gothic','11','B','','');
 Yii::$app->reporter->col('GRAND TOTAL: ','175',null,'','1px solid ','T','c','Century Gothic','10','B','','');
 Yii::$app->reporter->col(number_format($totalrdb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,'','1px solid ','T','r','Century Gothic','10','B','','');
 Yii::$app->reporter->col(number_format($totalrcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,'','1px solid ','T','r','Century Gothic','10','B','','');
 Yii::$app->reporter->col('','150',null,'','1px solid ','T','c','Century Gothic','11','B','','');
 Yii::$app->reporter->col(number_format($totalsundb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,'','1px solid ','T','r','Century Gothic','10','B','','');
 Yii::$app->reporter->col(number_format($totalsuncr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,'','1px solid ','T','r','Century Gothic','10','B','','');

    Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
//
////var_dump($params);
////var_dump($data);

?>