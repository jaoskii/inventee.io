<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Journal Voucher - Summary';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=45;
$page=45;

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800',null,'','1px solid ','','','Century Gothic','','','','');
        Yii::$app->reporter->startrow();
         //($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SUMMARIZED JOURNAL VOUCHER',null,null,'','1px solid ','','l','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','Century Gothic','10','','','');
            
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,'','1px solid ','','l','Century Gothic','10','','','');
            Yii::$app->reporter->col('Transaction: '. strtoupper($params['reporttype']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
             Yii::$app->reporter->col('Center: '.$params['center'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
            Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

//var_dump($params);
//var_dump($data);
Yii::$app->reporter->begintable('800');

        Yii::$app->reporter->startrow();
                 Yii::$app->reporter->col('ACCOUNT CODE',null,null,'','1px solid ','B','l','Century Gothic','11','b','','');
                 Yii::$app->reporter->col('ACCOUNT DESCRIPTION',null,null,'','1px solid ','B','C','Century Gothic','11','b','','');
                 Yii::$app->reporter->col('DEBIT',null,null,'','1px solid ','B','r','Century Gothic','11','b','','');
                 Yii::$app->reporter->col('CREDIT',null,null,'','1px solid ','B','r','Century Gothic','11','b','','');
        
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
                 Yii::$app->reporter->col($data[$i]['acno'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($data[$i]['description'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
                 Yii::$app->reporter->col($debit,null,null,'','1px solid ','','r','Century Gothic','10','','','');
                 Yii::$app->reporter->col($credit,null,null,'','1px solid ','','r','Century Gothic','10','','','');

            $totaldb=$totaldb + $data[$i]['debit'];
            $totalcr=$totalcr + $data[$i]['credit'];

                

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
         //($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SUMMARIZED JOURNAL VOUCHER',null,null,'','1px solid ','','l','Century Gothic','18','','b','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','Century Gothic','10','','','');
           
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,'','1px solid ','','l','Century Gothic','10','','','');
            Yii::$app->reporter->col('Transaction: '. strtoupper($params['reporttype']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
             Yii::$app->reporter->col('Center: '.$params['center'],null,null,'','1px solid ','','l','Century Gothic','10','','','');
            $app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

//var_dump($params);
//var_dump($data);
Yii::$app->reporter->begintable('800',null,'','1px solid ','','','','Century Gothic','','','');

        Yii::$app->reporter->startrow();
                 Yii::$app->reporter->col('ACCOUNT CODE',null,null,'','1px solid ','B','l','Century Gothic','11','b','','');
                 Yii::$app->reporter->col('ACCOUNT DESCRIPTION',null,null,'','1px solid ','B','C','Century Gothic','11','b','','');
                 Yii::$app->reporter->col('DEBIT',null,null,'','1px solid ','B','r','Century Gothic','11','b','','');
                 Yii::$app->reporter->col('CREDIT',null,null,'','1px solid ','B','r','Century Gothic','11','b','','');
        Yii::$app->reporter->endrow();


            $page=$page + $count;
        }
    }


    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow('',null,'','1px solid ','','B','Century Gothic','','12','','');

                 Yii::$app->reporter->col('',null,null,'','1px solid ','T','c','','Century Gothic','','','');
                 Yii::$app->reporter->col('GRAND TOTAL: ',null,null,'','1px solid ','T','C','Century Gothic','10','b','','');
                 Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')),null,null,'','1px solid ','T','r','Century Gothic','10','b','','');
                 Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),null,null,'','1px solid ','T','r','Century Gothic','10','b','','');
    Yii::$app->reporter->endrow();



Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
//
////var_dump($params);
////var_dump($data);

?>