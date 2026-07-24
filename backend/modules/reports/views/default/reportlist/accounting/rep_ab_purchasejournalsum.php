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
        Yii::$app->reporter->col('SUMMARIZED PURCHASE JOURNAL',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
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
        Yii::$app->reporter->col('ACCOUNT CODE',100,null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ACCOUNT DESCRIPTION',500,null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DEBIT',100,null,false,'1px solid ','B','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('CREDIT',100,null,false,'1px solid ','B','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();

$totalsdb=0;
$totalscr=0;
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
            $cr=number_format($data[$i]['credit'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($cr==0)
            {
            $cr='-';
            }
            $db=number_format($data[$i]['debit'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($db==0)
            {
            $db='-';
            }
            Yii::$app->reporter->col($data[$i]['acno'],100,null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['description'],500,null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col($db,100,null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col($cr,100,null,false,'1px solid ','','R','Century Gothic','10','','','');
            $totalsdb=$totalsdb+$data[$i]['debit'];
            $totalscr=$totalscr+$data[$i]['credit'];
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
        Yii::$app->reporter->col('SUMMARIZED PURCHASE JOURNAL',null,null,false,'1px solid ','','','','','','','');
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
        
        Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ACCOUNT CODE',100,null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('ACCOUNT DESCRIPTION',500,null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DEBIT',100,null,false,'1px solid ','B','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('CREDIT',100,null,false,'1px solid ','B','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
   
        $page=$page + $count;
    }
}


Yii::$app->reporter->startrow();

    Yii::$app->reporter->col('GRAND TOTAL :',100,null,false,'1px solid ','TB','L','Century Gothic','10','B','','');
    Yii::$app->reporter->col('',500,null,false,'1px solid ','TB','L','Century Gothic','10','B','','');
    Yii::$app->reporter->col(NUMBER_FORMAT($totalsdb,Yii::$app->systemsettings->setDecimaldisplay('currency')),100,null,false,'1px solid ','TB','R','Century Gothic','10','B','','');
    Yii::$app->reporter->col(NUMBER_FORMAT($totalsdb,Yii::$app->systemsettings->setDecimaldisplay('currency')),100,null,false,'1px solid ','TB','R','Century Gothic','10','B','','');

    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



 Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>