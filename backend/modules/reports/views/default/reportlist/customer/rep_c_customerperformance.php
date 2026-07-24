<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Customer Performance Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER PERFORMANCE REPORT',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),'300',null,false,'1px solid ','','L','Century Gothic','11','','30px','2px');
        //Yii::$app->reporter->col('Center : '.strtoupper($cname),'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();
$totalsales=number_format($data1[0]['amount'],2);
Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('CUSTOMER NAME','400',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('AMOUNT','150',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('PERCENT','150',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       
     $percent=0; 
     $total=0;
     $tpercent=0;
Yii::$app->reporter->begintable('800');
if(!empty($data)){
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
       $percent=($data[$i]['amount'] / $data1[0]['amount'])*100;
       
       Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','1px');
       Yii::$app->reporter->col($data[$i]['clientname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
       Yii::$app->reporter->col(number_format($data[$i]['amount'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','R','Century Gothic','11','','','1px');
       Yii::$app->reporter->col(number_format($percent,Yii::$app->systemsettings->setDecimaldisplay('currency')).'%','150',null,false,'1px solid ','','R','Century Gothic','11','','','1px');
       Yii::$app->reporter->endrow();
       $total=$total+$data[$i]['amount'];
       $tpercent=$tpercent+$percent;
       
}//end for each

}//end if

       Yii::$app->reporter->col('GRAND TOTAL :','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','1px');
       Yii::$app->reporter->col('','400',null,false,'1px solid ','TB','C','Century Gothic','11','B','','1px');
       Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','TB','R','Century Gothic','11','B','','1px');
       Yii::$app->reporter->col(number_format($tpercent,Yii::$app->systemsettings->setDecimaldisplay('currency')).'%','150',null,false,'1px solid ','TB','R','Century Gothic','11','B','','1px');
       

    Yii::$app->reporter->begintable('800');
    echo '<br/><br/>';
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
     Yii::$app->reporter->begintable('800');
    echo '<br/>';
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($params['prepared'],'266',null,false,'1px solid ','B','C','Century Gothic','12','B','','3px');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($params['approved'],'266',null,false,'1px solid ','B','C','Century Gothic','12','B','','3px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();       
       
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();

//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


?>
