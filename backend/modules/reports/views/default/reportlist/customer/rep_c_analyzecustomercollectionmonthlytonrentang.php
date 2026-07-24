<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Analyze Sales (Monthly)';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ANALYZE SALES (MONTHLY)',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1100');
        Yii::$app->reporter->startrow('200',null,false,'1px solid ','','C','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Year : '.strtoupper($params['year']),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Center : '.$params['center'],'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Month','200','','','1px solid ','TB','C','century gothic','15','B','','');
        Yii::$app->reporter->col(isset($data[0]['yr1'])?$data[0]['yr1'].' Sales':'0 Sales' ,'200','','','1px solid ','TB','C','century gothic','15','B','','');
        Yii::$app->reporter->col(isset($data[0]['yr'])?$data[0]['yr'].' Sales':'0 Sales' ,'200','','','1px solid ','TB','C','century gothic','15','B','','');
        Yii::$app->reporter->col('Remarks' ,'200','','','1px solid ','TB','C','century gothic','15','B','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

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
    $totalmojan1=0;
    $totalmofeb1=0;
    $totalmomar1=0;
    $totalmoapr1=0;
    $totalmomay1=0;
    $totalmojun1=0;
    $totalmojul1=0;
    $totalmoaug1=0;
    $totalmosep1=0;
    $totalmooct1=0;
    $totalmonov1=0;
    $totalmodec1=0;
for($i=0;$i<count($data);$i++){
    
    $totalmojan=$totalmojan+$data[$i]['mojan'];
    $totalmofeb=$totalmofeb+$data[$i]['mofeb'];
    $totalmomar=$totalmomar+$data[$i]['momar'];
    $totalmoapr=$totalmoapr+$data[$i]['moapr'];
    $totalmomay=$totalmomay+$data[$i]['momay'];
    $totalmojun=$totalmojun+$data[$i]['mojun'];
    $totalmojul=$totalmojul+$data[$i]['mojul'];
    $totalmoaug=$totalmoaug+$data[$i]['moaug'];
    $totalmosep=$totalmosep+$data[$i]['mosep'];
    $totalmooct=$totalmooct+$data[$i]['mooct'];
    $totalmonov=$totalmonov+$data[$i]['monov'];
    $totalmodec=$totalmodec+$data[$i]['modec'];
    $totalmojan1=$totalmojan1+$data[$i]['mojan1'];
    $totalmofeb1=$totalmofeb1+$data[$i]['mofeb1'];
    $totalmomar1=$totalmomar1+$data[$i]['momar1'];
    $totalmoapr1=$totalmoapr1+$data[$i]['moapr1'];
    $totalmomay1=$totalmomay1+$data[$i]['momay1'];
    $totalmojun1=$totalmojun1+$data[$i]['mojun1'];
    $totalmojul1=$totalmojul1+$data[$i]['mojul1'];
    $totalmoaug1=$totalmoaug1+$data[$i]['moaug1'];
    $totalmosep1=$totalmosep1+$data[$i]['mosep1'];
    $totalmooct1=$totalmooct1+$data[$i]['mooct1'];
    $totalmonov1=$totalmonov1+$data[$i]['monov1'];
    $totalmodec1=$totalmodec1+$data[$i]['modec1'];
    }
        
     
   

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('January','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmojan1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmojan,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','B','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Febuary','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmofeb1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmofeb,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('March','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmomar1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmomar,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('April','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmoapr1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmoapr,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('May','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmomay1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmomay,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('June','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmojun1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmojun,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('July','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmojul1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmojul,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('August','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmoaug1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmoaug,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('September','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmosep1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmosep,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('October','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmooct1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmooct,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('November','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmonov1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmonov,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('December','200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmodec1,2),'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col(number_format($totalmodec,2) ,'200','','','1px solid ','','C','century gothic','15','','','');
        Yii::$app->reporter->col('&nbsp;' ,'200','','','1px solid ','B','C','century gothic','15','','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



 $total = $totalmojan+
    $totalmofeb+
    $totalmomar+
    $totalmoapr+
    $totalmomay+
    $totalmojun+
    $totalmojul+
    $totalmoaug+
    $totalmosep+
    $totalmooct+
    $totalmonov+
    $totalmodec;
    
$total1 = $totalmojan1+
    $totalmofeb1+
    $totalmomar1+
    $totalmoapr1+
    $totalmomay1+
    $totalmojun1+
    $totalmojul1+
    $totalmoaug1+
    $totalmosep1+
    $totalmooct1+
    $totalmonov1+
    $totalmodec1;


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Total','200','','','1px solid ','TB','C','century gothic','15','B','','');
        Yii::$app->reporter->col(number_format($total1,2),'200','','','1px solid ','TB','C','century gothic','15','B','','');
        Yii::$app->reporter->col(number_format($total,2) ,'200','','','1px solid ','TB','C','century gothic','15','B','','');
        Yii::$app->reporter->col('' ,'200','','','1px solid ','TB','C','century gothic','15','B','','');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>