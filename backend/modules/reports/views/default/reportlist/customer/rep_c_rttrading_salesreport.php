<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'SALES REPORT';
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

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SALES REPORT',null,null,false,'1px solid ','','C','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col(date('m/d/Y', strtotime($params['startdate'])).' to '.date('m/d/Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();

//header info
Yii::$app->reporter->begintable(1000);
// setup params
if (strtoupper($params['salestype'])=='ALL'){
    $salestype = 'ALL';
}else{
    $salestype = $params['salestype'];
}

if (strtoupper($params['vattype'])!='ALL'){
    if (strtoupper($params['vattype'])=='CASH'){
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


        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALES TYPE: '.$salestype,'150',null,false,'1px solid ','','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->col('CUSTOMER : '.$client,'150',null,false,'1px solid ','','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->endrow(); 

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('VAT : '.$vattype,'150',null,false,'1px dashed ','B','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->col('AGENT : '.$agent,'150',null,false,'1px dashed ','B','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->endrow(); 

Yii::$app->reporter->endtable();

//Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOC DATE','90',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DOC NO','90',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CODE','90',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CUSTOMER NAME','250',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('NOTES','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('POSTDATE','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        
$totalamt =0;

for($i=0;$i<count($data);$i++){

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['dateid'],'90',null,false,'1px dashed ','','C','Century Gothic','10','','','3px');
            Yii::$app->reporter->col($data[$i]['docno'],'90',null,false,'1px dashed ','','C','Century Gothic','10','','','3px');
            Yii::$app->reporter->col($data[$i]['client'],'90',null,false,'1px dashed ','','C','Century Gothic','10','','','3px');
            Yii::$app->reporter->col($data[$i]['clientname'],'250',null,false,'1px solid ','','L','Century Gothic','10','','','3px');    
            Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['postdate'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','3px');    
            Yii::$app->reporter->col(number_format($data[$i]['tamt'],2),'100',null,false,'1px solid ','','R','Century Gothic','10','','','3px');    
        Yii::$app->reporter->endrow();
$totalamt=$totalamt + $data[$i]['tamt'];
}


Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Total:','90',null,false,'1px dashed ','T','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','90',null,false,'1px dashed ','T','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','90',null,false,'1px dashed ','T','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','250',null,false,'1px dashed ','T','R','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','T','R','Century Gothic','11','','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','T','R','Century Gothic','11','','30px','8px');
Yii::$app->reporter->col(number_format($totalamt,2),'100',null,false,'1px dashed ','T','R','Century Gothic','11','B','30px','8px').'<br />';
Yii::$app->reporter->endrow();
    //Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>