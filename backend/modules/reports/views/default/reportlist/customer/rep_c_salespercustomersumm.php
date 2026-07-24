<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Per Customer - Summ';
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

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SALES PER CUSTOMER',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
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

if (strtoupper($params['salestype'])=='ALL'){
    $salestype = 'ALL';
}else{
    $salestype = $params['salestype'];
}

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

if ($params['agent']!=''){
    $agent = $params['agent'];
}else{
    $agent = 'ALL';
}

if ($params['class']!=''){
    $cla = $params['class'];
}else{
    $cla = 'ALL';
}

if ($params['area']!=''){
    $ar = $params['area'];
}else{
    $ar = 'ALL';
}

            Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
            Yii::$app->reporter->col('Sales Type : '.$salestype,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
            Yii::$app->reporter->col('Customer : '.$client,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
            Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Vat : '.$vattype,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Agent : '.$agent,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Class : '.$cla,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Area : '.$ar,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col(strtoupper($params['reporttype']),300,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('ADDRESS','300',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('TONS','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
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
   Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
   Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
   Yii::$app->reporter->col($data[$i]['addr'],'300',null,false,'1px solid ','','L','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($tons,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
   Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Century Gothic','10','','','');
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
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','TB','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totaltons,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','TB','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','TB','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();



Yii::$app->reporter->endreport();

//var_dump($params);
// var_dump($data);

?>