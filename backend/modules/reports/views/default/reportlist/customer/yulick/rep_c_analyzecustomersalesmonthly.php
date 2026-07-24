<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Analyze Customer Sales (Monthly)';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1000');

    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ANALYZE CUSTOMER SALES (MONTHLY)',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        if($params['yulick']==''){
        Yii::$app->reporter->col('Company : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Company : ' . $params['yulick'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        Yii::$app->reporter->startrow('200',null,false,'1px solid ','','C','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Year : '.strtoupper($params['year']),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Center : '.$params['center'],'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CLIENT NAME','120','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('JAN' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('FEB' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('MAR' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('APR' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('MAY' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('JUN' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('JUL' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AUG' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('SEP' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('OCT' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('NOV' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('DEC' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AMOUNT' ,'100','','','1px solid ','TB','C','century gothic','9','B','','');
        

    $totalmojan=0;
    $totalmofeb=0;
    $totalmomar=0;
    $totalmoapr=0;
    $totalmomay=0;
    $totalmojun=0;
    $totalmojul=0;
    $totalmoaug=0;
    $totalmosep=0;
    $totalmooct=0;
    $totalmonov=0;
    $totalmodec=0;
    $amt=0;
    $totalamt=0;
for($i=0;$i<count($data);$i++){
    $mojan=number_format($data[$i]['mojan'],2);
                        if ($mojan<1)
                        {
                        $mojan='-';
                        }
                        $mofeb=number_format($data[$i]['mofeb'],2);
                        if ($mofeb<1)
                        {
                        $mofeb='-';
                        }
                        $momar=number_format($data[$i]['momar'],2);
                        if ($momar<1)
                        {
                        $momar='-';
                        }
                        $moapr=number_format($data[$i]['moapr'],2);
                        if ($moapr<1)
                        {
                        $moapr='-';
                        }
                        $momay=number_format($data[$i]['momay'],2);
                        if ($momay<1)
                        {
                        $momay='-';
                        }
                        $mojun=number_format($data[$i]['mojun'],2);
                        if ($mojun<1)
                        {
                        $mojun='-';
                        }
                        $mojul=number_format($data[$i]['mojul'],2);
                        if ($mojul<1)
                        {
                        $mojul='-';
                        }
                        $moaug=number_format($data[$i]['moaug'],2);
                        if ($moaug<1)
                        {
                        $moaug='-';
                        }
                        $mosep=number_format($data[$i]['mosep'],2);
                        if ($mosep<1)
                        {
                        $mosep='-';
                        }
                        $mooct=number_format($data[$i]['mooct'],2);
                        if ($mooct<1)
                        {
                        $mooct='-';
                        }
                        $monov=number_format($data[$i]['monov'],2);
                        if ($monov<1)
                        {
                        $monov='-';
                        }
                        $modec=number_format($data[$i]['modec'],2);
                        if ($modec<1)
                        {
                        $modec='-';
                        }
                        
                        $amt=$data[$i]['mojan'] + $data[$i]['mofeb'] + $data[$i]['momar'] + $data[$i]['moapr'] + $data[$i]['momay'] + $data[$i]['mojun'] + $data[$i]['mojul'] + $data[$i]['moaug'] + $data[$i]['mosep'] + $data[$i]['mooct'] + $data[$i]['monov'] + $data[$i]['modec'];
    
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['clientname'],'120px',null,false,'1px solid ','','L','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($mojan,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($mofeb,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($momar,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($moapr,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($momay,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($mojun,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($mojul,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($moaug,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($mosep,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($mooct,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($monov,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col($modec,'65',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($amt,2),'100px',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        
        $totalmojan=$totalmojan + $data[$i]['mojan'];
        $totalmofeb=$totalmofeb + $data[$i]['mofeb'];
        $totalmomar=$totalmomar + $data[$i]['momar'];
        $totalmoapr=$totalmoapr + $data[$i]['moapr'];
        $totalmomay=$totalmomay + $data[$i]['momay'];
        $totalmojun=$totalmojun + $data[$i]['mojun'];
        $totalmojul=$totalmojul + $data[$i]['mojul'];
        $totalmoaug=$totalmoaug + $data[$i]['moaug'];
        $totalmosep=$totalmosep + $data[$i]['mosep'];
        $totalmooct=$totalmooct + $data[$i]['mooct'];
        $totalmonov=$totalmonov + $data[$i]['monov'];
        $totalmodec=$totalmodec + $data[$i]['modec'];
        $totalamt=$totalamt + $amt;
        
        Yii::$app->reporter->endrow();
        
        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
            
                Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
       Yii::$app->reporter->col('ANALYZE CUSTOMER SALES (MONTHLY)',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow('200',null,false,'1px solid ','','C','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Year : '.strtoupper($params['year']),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Center : '.$params['center'],'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        // Yii::$app->reporter- >col('Printdate : '. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CLIENT NAME','120','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('JAN' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('FEB' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('MAR' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('APR' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('MAY' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('JUN' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('JUL' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AUG' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('SEP' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('OCT' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('NOV' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('DEC' ,'65','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AMOUNT' ,'100','','','1px solid ','TB','C','century gothic','9','B','','');
           
            Yii::$app->reporter->printline();
        $page=$page + $count;
        }
        
    }
        
        Yii::$app->reporter->startrow();

        Yii::$app->reporter->col('GRAND TOTAL :','120',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmojan,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmofeb,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmomar,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmoapr,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmomay,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmojun,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmojul,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmoaug,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmosep,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmooct,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmonov,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmodec,2),'65',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalamt,2),'100',null,false,'1px solid ','TB','R','Century Gothic','9','B','','');
        Yii::$app->reporter->endrow();
        
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>