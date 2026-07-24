<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Supplier Payables Aging - DETAILED';
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
        Yii::$app->reporter->col('DETAILED CURRENT SUPPLIER PAYABLES AGING',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        if($params['supplier']==''){
        Yii::$app->reporter->col('Supplier : ALL','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['suppliername']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');    
        }
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
         Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOCUMENT #','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DATE','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('0-30 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('31-60 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('61-90 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('91-120 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('120+ days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('TOTAL','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
//($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $a=0;
        $b=0;
        $c=0;
        $d=0;
        $e=0;
        $tota=0;
        $totb=0;
        $totc=0;
        $totd=0;
        $tote=0;
        $gt=0;
        $customer="";
        $docno="";
        
for($i=0;$i<count($data);$i++){  
    
        if ($customer!=$data[$i]['clientname']){
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['clientname'],'110',null,false,'1px dotted ','','L','Century Gothic','10','B','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->endrow();
        }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['docno'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        if ($data[$i]['elapse'] >=0 && $data[$i]['elapse'] < 30){
            $a=$data[$i]['balance'];
            $b=0;
            $c=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');

        }
        if ($data[$i]['elapse'] > 31 && $data[$i]['elapse'] < 60){
            $b=$data[$i]['balance'];
            $a=0;
            $c=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        }
        if ($data[$i]['elapse'] > 61 && $data[$i]['elapse'] < 90){
            $c=$data[$i]['balance'];
            $a=0;
            $b=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        }
        if ($data[$i]['elapse'] > 91 && $data[$i]['elapse'] < 120){
            $d=$data[$i]['balance'];
            $a=0;
            $c=0;
            $b=0;
            $e=0;
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        }
        if ($data[$i]['elapse'] > 120){
            $e=$data[$i]['balance'];
            $a=0;
            $c=0;
            $d=0;
            $b=0;
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','r','Century Gothic','10','','','');

        
        }
        Yii::$app->reporter->endrow();
        $tota=$tota+$a;
        $totb=$totb+$b;
        $totc=$totc+$c;
        $totd=$totd+$d;
        $tote=$tote+$e;
        $gt=$gt+$data[$i]['balance'];
        $customer=$data[$i]['clientname'];
        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED CURRENT SUPPLIER PAYABLES  AGING',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        if($params['supplier']==''){
        Yii::$app->reporter->col('Supplier : ALL','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['suppliername']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');    
        }
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
         Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOCUMENT #','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DATE','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('0-30 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('31-60 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('61-90 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('91-120 days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('120+ days','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('TOTAL','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
} 
        
        
    }
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','110px',null,false,'1px dotted ','T','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col('TOTAL : ','110px',null,false,'1px dotted','T','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($tota,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totc,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totd,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($tote,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>