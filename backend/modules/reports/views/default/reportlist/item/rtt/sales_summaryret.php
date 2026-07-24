<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales - SUMMARY';
//RT REPORTS:
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$pagenumber=1;
$count=6;
$page=6;
$start=$params['start'];
$end=$params['end'];
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('SALES SUMMARY',null,null,false,'1px solid ','','c','Avenir','13','','','').'<br />';
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col($start . ' - ' . $end,null,null,false,'1px solid ','','c','Avenir','13','','','').'<br />';
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Trnx type :' . $params['trnxtype'],null,null,false,'1px solid ','','C','Avenir','11','B','','').'<br />';
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Vat type :' . $params['vattype'],null,null,false,'1px solid ','','C','Avenir','11','B','','').'<br />';
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Prefix :' . $params['rttpref'],null,null,false,'1px solid ','','C','Avenir','11','B','','').'<br />';
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('CUSTOMER CODE','130',null,false,'1px solid ','TB','L','Avenir','12','B','','');
       Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px solid ','TB','L','Avenir','12','B','','');
       Yii::$app->reporter->col('ADDRESS','200',null,false,'1px solid ','TB','L','Avenir','12','B','','');
       Yii::$app->reporter->col('TIN','100',null,false,'1px solid ','TB','L','Avenir','12','B','','');
       Yii::$app->reporter->col('AMOUNT','70',null,false,'1px solid ','TB','C','Avenir','12','B','','');
       Yii::$app->reporter->col('RETURN','100',null,false,'1px solid ','TB','R','Avenir','12','B','','');
$totalext=0;
$totalbal=0;
//Sales with Return Report
Yii::$app->reporter->begintable('800');
for($i=0;$i<count($data);$i++){
    $qryreturn = "select ifnull(sum(ext),0) as ext from (
    select supp.client,stock.ext from lahead as head
    left join lastock as stock on stock.trno = head.trno
    left join cntnum on cntnum.trno=head.trno
    left join client as supp on supp.client = head.client
    where head.doc='CM' and head.dateid between '".$start."' and '".$end."'
    and supp.client = '".$data[$i]['client']."'
    UNION ALL
    select supp.client,stock.ext from glhead as head
    left join glstock as stock on stock.trno = head.trno
    left join client on client.clientid = head.clientid
    left join item on item.itemid=stock.itemid
    left join cntnum on cntnum.trno=head.trno
    left join client as supp on supp.clientid=head.clientid
    where head.doc='CM' and head.dateid between '".$start."' and '".$end."'
    and supp.client = '".$data[$i]['client']."'
    ) as tbl group by client";

    $return = Yii::$app->sbccommon->datareader($qryreturn);

    Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['client'],'130',null,false,'1px dashed ','B','L','Avenir','11','','','');
       Yii::$app->reporter->col($data[$i]['supplier'],'200',null,false,'1px dashed ','B','L','Avenir','11','','','');
       Yii::$app->reporter->col($data[$i]['addr'],'200',null,false,'1px dashed ','B','L','Avenir','11','','','');
       Yii::$app->reporter->col($data[$i]['tin'],'100',null,false,'1px dashed ','B','L','Avenir','11','','','');
       Yii::$app->reporter->col('<div style="margin-right:0;">'.number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</div>','70',null,false,'0.5px dashed ','B','R','Avenir','11','','','');
       Yii::$app->reporter->col(number_format($return,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dashed ','B','R','Avenir','11','','','');
       $totalext=$totalext+$data[$i]['ext'];
       //$totalbal=$totalbal+$data[$i]['bal'];
       Yii::$app->reporter->endrow();

}

       Yii::$app->reporter->col('','130',null,false,'2px solid ','TB','C','Avenir','10','','','');
       Yii::$app->reporter->col('','200',null,false,'2px solid ','TB','C','Avenir','10','','','');
       Yii::$app->reporter->col('','200',null,false,'2px solid ','TB','C','Avenir','10','','','');
       Yii::$app->reporter->col('TOTAL :','100',null,false,'2px solid ','TB','R','Avenir','10','','','');
       Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'70',null,false,'2px solid ','TB','R','Avenir','12','B','','');
       Yii::$app->reporter->col('','100',null,false,'2px solid ','TB','C','Avenir','10','','','');

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>
