<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Per Supplier - Summ';
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
echo '<br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PURCHASE PER SUPPLIER',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');

if (strtoupper($params['vat'])!='ALL'){
    if (strtoupper($params['vat'])=='CASH'){
        $vattype = 'VATABLE';    
    }else{
        $vattype = 'NON-VATABLE';
    }
    
}else{
    $vattype = 'ALL';
}

if ($params['client']!=''){
    $client = $params['client'];
}else{
    $client = 'ALL';
}

if ($params['class']!=''){
    $cla = $params['class'];
}else{
    $cla = 'ALL';
}

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Supplier : '.$client,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Vat : '.$vattype,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Class : '.$cla,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col(strtoupper($params['reporttype']),300,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('SUPPLIER','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('ADDRESS','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('TONS','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();

$item=null;
$totalqty=0;
$totaltons=0;
$totalamt=0;
// //col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();

    $tons = $data[$i]['tons'];
   
   Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
   Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
   Yii::$app->reporter->col($data[$i]['addr'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($tons,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->endrow();


   $totalqty=$totalqty+$data[$i]['isqty'];
   $totaltons=$totaltons+$tons;
   $totalamt=$totalamt+$data[$i]['ext'];

//    if(Yii::$app->reporter->linecounter==$page){
//         Yii::$app->reporter->endtable();
//         Yii::$app->reporter->page_break();

//             Yii::$app->reporter->begintable('800');
// $header=Yii::$app->reporter->letterhead();
// Yii::$app->reporter->endtable();
// echo '<br/><br/>';

//        $page=$page + $count;
//     }
    }

 Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totaltons,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();



Yii::$app->reporter->endreport();

//var_dump($params);
// var_dumsp($data);

?>