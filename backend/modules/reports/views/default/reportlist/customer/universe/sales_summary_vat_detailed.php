<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Summary per Vat Type';
//RT REPORTS:
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$pagenumber=1;
$count=35;
$page=35;
$start=$params['start'];
$end=$params['end'];
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
//


Yii::$app->reporter->beginreport('800');
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SALES SUMMARY PER VAT TYPE (DETAILED)',null,null,false,'1px solid ','','c','Helvetica','13','','','').'<br />';
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('From <b>' .$start . '</b> to <b>' . $end.'</b>','150',null,false,'1px solid ','','L','Helvetica','13','','','');
Yii::$app->reporter->col('Trnx type :' . $params['trnxtype'],'100',null,false,'1px solid ','','L','Helvetica','11','B','','');
Yii::$app->reporter->col('Vat type :' . $params['vattype'],'100',null,false,'1px solid ','','l','Helvetica','11','B','','');
Yii::$app->reporter->col('Sales type :' . $params['salestype'],'100',null,false,'1px solid ','','l','Helvetica','11','B','','');
Yii::$app->reporter->col('Prefix :' . $params['pref'],'100',null,false,'1px solid ','','l','Helvetica','11','B','','');
Yii::$app->reporter->col('Price Group :' . $params['pricegroup'],'100',null,false,'1px solid ','','l','Helvetica','11','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('DOC #','100',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
       Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
       Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
       Yii::$app->reporter->col('CUST. NAME','150',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
       Yii::$app->reporter->col('TIN','100',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
       Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','TB','R','Helvetica','12','B','','');
       Yii::$app->reporter->col('VAT','50',null,false,'1px solid ','TB','R','Helvetica','12','B','','');
       Yii::$app->reporter->col('VATEX','100',null,false,'1px solid ','TB','R','Helvetica','12','B','','');
Yii::$app->reporter->endtable();

$totalext=0;
$totalvat=0;
$totalvatex=0;
$totalbal=0;
//Sales with Return Report
Yii::$app->reporter->begintable('800');
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px dashed ','B','L','Helvetica','11','','','');
       Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px dashed ','B','L','Helvetica','11','','','');
       Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px dashed ','B','L','Helvetica','11','','','');
       Yii::$app->reporter->col($data[$i]['supplier'],'150',null,false,'1px dashed ','B','L','Helvetica','11','','','');
       Yii::$app->reporter->col($data[$i]['tin'],'100',null,false,'1px dashed ','B','L','Helvetica','11','','','');
       Yii::$app->reporter->col('<div style="margin-right:0;">'.number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</div>','100',null,false,'0.5px dashed ','B','R','Helvetica','11','','','');
       Yii::$app->reporter->col(number_format($data[$i]['vatamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dashed ','B','R','Helvetica','11','','','');
       Yii::$app->reporter->col(number_format($data[$i]['vatex'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dashed ','B','R','Helvetica','11','','','');
       $totalext=$totalext+$data[$i]['ext'];
       $totalvat=$totalvat+$data[$i]['vatamt'];
       $totalvatex=$totalvatex+$data[$i]['vatex'];
       //$totalbal=$totalbal+$data[$i]['bal'];
       Yii::$app->reporter->endrow();

      /*  if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->beginreport('800');
            Yii::$app->reporter->begintable('800');
        $header=Yii::$app->reporter->letterhead();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALES SUMMARY PER VAT TYPE (DETAILED)',null,null,false,'1px solid ','','c','Helvetica','13','','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('From <b>' .$start . '</b> to <b>' . $end.'</b>','150',null,false,'1px solid ','','L','Helvetica','13','','','');
        Yii::$app->reporter->col('Trnx type :' . $params['trnxtype'],'100',null,false,'1px solid ','','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('Vat type :' . $params['vattype'],'100',null,false,'1px solid ','','l','Helvetica','11','B','','');
        Yii::$app->reporter->col('Sales type :' . $params['salestype'],'100',null,false,'1px solid ','','l','Helvetica','11','B','','');
        Yii::$app->reporter->col('Prefix :' . $params['bref'],'100',null,false,'1px solid ','','l','Helvetica','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->endtable();
        Yii::$app->reporter->printline();
        //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
               Yii::$app->reporter->startrow();
               Yii::$app->reporter->col('DOC #','100',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
               Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
               Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
               Yii::$app->reporter->col('CUST. NAME','200',null,false,'1px solid ','TB','L','Helvetica','12','B','','');
               Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','TB','R','Helvetica','12','B','','');
               Yii::$app->reporter->col('VAT','100',null,false,'1px solid ','TB','R','Helvetica','12','B','','');
               Yii::$app->reporter->col('VATEX','100',null,false,'1px solid ','TB','R','Helvetica','12','B','','');
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
        $page=$page + $count;
       }//end if */

}

Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('','100',null,false,'2px solid ','TB','L','Helvetica','10','','','');
       Yii::$app->reporter->col('','100',null,false,'2px solid ','TB','L','Helvetica','10','','','');
       Yii::$app->reporter->col('','100',null,false,'2px solid ','TB','L','Helvetica','10','','','');
       Yii::$app->reporter->col('','100',null,false,'2px solid ','TB','L','Helvetica','10','','','');
       Yii::$app->reporter->col('GRAND TOTAL :','200',null,false,'2px solid ','TB','L','Helvetica','10','b','','');
       Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'2px solid ','TB','R','Helvetica','12','B','','');
       Yii::$app->reporter->col(number_format($totalvat,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'2px solid ','TB','R','Helvetica','10','B','','');
       Yii::$app->reporter->col(number_format($totalvatex,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'2px solid ','TB','R','Helvetica','10','B','','');
Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>
