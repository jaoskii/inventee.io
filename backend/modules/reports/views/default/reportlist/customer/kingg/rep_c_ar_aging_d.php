<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Customer Receivables Aging - DETAILED';
//WTODO: [JLY][2019.08.28][KINGG CONCERNS][EDIT REPORT-ref doc #,concat docno,add sales agent]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('900');

    Yii::$app->reporter->begintable('900');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED CURRENT CUSTOMER RECEIVABLES AGING',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        if($params['client']==''){
        Yii::$app->reporter->col('Customer : ALL','110px',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Customer : '.strtoupper($params['client']),'110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('900');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUSTOMER','80',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','70',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('REF #','50',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('DATE','70',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('0-30 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('31-60 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('61-90 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('91-120 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('120+ days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('AGENT','80',null,false,'1px solid ','B','C','Helvetica','11','B','','');
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
for($i=0;$i<count($data);$i++){

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['clientname'],'80',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'70',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['yourref'],'50',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'70',null,false,'1px solid ','','L','Helvetica','10','','','');
        if ($data[$i]['elapse'] >=0 && $data[$i]['elapse'] < 30){
            $a=$data[$i]['balance'];
            $b=0;
            $c=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['agname'],'80',null,false,'1px solid ','','r','Helvetica','11','','','');

        }
        if ($data[$i]['elapse'] > 31 && $data[$i]['elapse'] < 60){
            $b=$data[$i]['balance'];
            $a=0;
            $c=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['agname'],'80',null,false,'1px solid ','','r','Helvetica','11','','','');
        }
        if ($data[$i]['elapse'] > 61 && $data[$i]['elapse'] < 90){
            $c=$data[$i]['balance'];
            $a=0;
            $b=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['agname'],'80',null,false,'1px solid ','','r','Helvetica','11','','','');
        }
        if ($data[$i]['elapse'] > 91 && $data[$i]['elapse'] < 120){
            $d=$data[$i]['balance'];
            $a=0;
            $c=0;
            $b=0;
            $e=0;
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['agname'],'80',null,false,'1px solid ','','r','Helvetica','11','','','');
        }
        if ($data[$i]['elapse'] > 120){
            $e=$data[$i]['balance'];
            $a=0;
            $c=0;
            $d=0;
            $b=0;
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','r','Helvetica','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Helvetica','10','','','');
        Yii::$app->reporter->col($data[$i]['agname'],'80',null,false,'1px solid ','','r','Helvetica','11','','','');
        }

        Yii::$app->reporter->endrow();
        $tota=$tota+$a;
        $totb=$totb+$b;
        $totc=$totc+$c;
        $totd=$totd+$d;
        $tote=$tote+$e;
        $gt=$gt+$data[$i]['balance'];
        
        
        
        
        
        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

                Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED CURRENT CUSTOMER RECEIVABLES AGING',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        if($params['client']==''){
        Yii::$app->reporter->col('Customer : ALL','110px',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Customer : '.strtoupper($params['client']),'110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('900');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
       Yii::$app->reporter->col('CUSTOMER','80',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','70',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('REF #','50',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('DATE','70',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('0-30 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('31-60 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('61-90 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('91-120 days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('120+ days','90',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('AGENT','80',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;       
}
    }
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','80',null,false,'1px dotted ','T','L','Helvetica','10','','','5px');
        Yii::$app->reporter->col('','70',null,false,'1px dotted ','T','L','Helvetica','10','','','5px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','L','Helvetica','10','','','5px');
        Yii::$app->reporter->col('TOTAL : ','70',null,false,'1px dotted','T','L','Helvetica','10','B','','5px');
        Yii::$app->reporter->col(number_format($tota,2),'90',null,false,'1px dotted ','T','r','Helvetica','10','B','','5px');
        Yii::$app->reporter->col(number_format($totb,2),'90',null,false,'1px dotted ','T','r','Helvetica','10','B','','5px');
        Yii::$app->reporter->col(number_format($totc,2),'90',null,false,'1px dotted ','T','r','Helvetica','10','B','','5px');
        Yii::$app->reporter->col(number_format($totd,2),'90',null,false,'1px dotted ','T','r','Helvetica','10','B','','5px');
        Yii::$app->reporter->col(number_format($tote,2),'90',null,false,'1px dotted ','T','r','Helvetica','10','B','','5px');
        Yii::$app->reporter->col(number_format($gt,2),'100',null,false,'1px dotted ','T','r','Helvetica','10','B','','5px');
        Yii::$app->reporter->col('','80',null,false,'1px dotted ','T','L','Helvetica','10','','','5px');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>