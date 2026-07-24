<?php
//WTODO : ALVIN 10.29.2018 
//RTTREPORTS2
date_default_timezone_set('Asia/Manila');
$this->title = 'Counter Receipt Report';

use app\models\Reports;
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;
 $bals = Reports::getCustomerFloatingBalance($data[0]['client']);
Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('COUNTER RECEIPT','800',null,false,'1px solid ','','C','Avenir','18','B','','');
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DATE : '.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'100',null,false,'1px solid ','','C','Avenir','12','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER : ','100',null,false,'1px solid ','','L','Avenir','13','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'700',null,false,'1px solid ','','L','Avenir','12','','30px','4px');
       
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','100',null,false,'1px solid ','','L','Avenir','13','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','','L','Avenir','12','','30px','4px');
        Yii::$app->reporter->col('BALANCE :','80',null,false,'1px solid ','','L','Avenir','13','B','','');
        Yii::$app->reporter->col(number_format($bals[0]['bal'],2),'100',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOC DATE','100',null,false,'1px solid ','B','L','Avenir','13','B','30px','8px');
        Yii::$app->reporter->col('DOC NUMBER','150',null,false,'1px solid ','B','L','Avenir','13','B','30px','8px');
        Yii::$app->reporter->col('REFERENCE #','150',null,false,'1px solid ','B','L','Avenir','13','B','30px','8px');
        Yii::$app->reporter->col('DEBIT','100',null,false,'1px solid ','B','R','Avenir','13','B','30px','8px');
        Yii::$app->reporter->col('CREDIT','100',null,false,'1px solid ','B','R','Avenir','13','B','30px','8px');
        Yii::$app->reporter->col('REMARKS','200',null,false,'1px solid ','B','L','Avenir','13','B','30px','8px');
        

        

   $totaldb=0;
   $totalcr=0;
   $gtotal=0;
for($i=0;$i<count($data);$i++){
    
            $debit=number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($debit<1)
            {
            $debit='-';
            }
             $credit=number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($credit<1)
            {
            $credit='-';
            }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['postdate'],'75',null,false,'1px solid ','','L','Avenir','12','','','2px');
        Yii::$app->reporter->col($data[$i]['ref'],'150',null,false,'1px solid ','','L','Avenir','12','','','2px');
        Yii::$app->reporter->col($data[$i]['krourref'],'150',null,false,'1px solid ','','L','Avenir','12','','','2px');
        Yii::$app->reporter->col($debit,'100',null,false,'1px solid ','','R','Avenir','12','','','2px');
        Yii::$app->reporter->col($credit,'100',null,false,'1px solid ','','R','Avenir','12','','','2px');
        Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Avenir','12','','','2px');
        $totaldb=$totaldb+$data[$i]['db'];
        $totalcr=$totalcr+$data[$i]['cr'];
        $gtotal=$totaldb-$totalcr;
        
}       
        
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('TOTAL :','75',null,false,'1px dotted ','T','C','Avenir','12','B','','2px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','R','Avenir','12','B','30px','2px');
        Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Avenir','12','B','','2px');
        Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Avenir','12','B','','2px');
        Yii::$app->reporter->col(number_format($gtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','T','R','Avenir','12','B','','2px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','50',null,false,'1px solid ','','L','Avenir','12','B','','');
        Yii::$app->reporter->col($data[0]['rem'],'650',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Avenir','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();



    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Verified By : ','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('Receipt Acknoledged By :','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('Date :','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','B','L','Avenir','13','B','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','13','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','B','C','Avenir','13','B','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','13','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','B','L','Avenir','13','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>