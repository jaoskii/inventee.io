<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Receiving Consignment Report';
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
        Yii::$app->reporter->col('RECEIVING CONSIGNMENT REPORT',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Sort by : '.strtoupper($params['sortby']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate:'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('DR #','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('REFERENCE','150',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('SUPPLIER NAME','250',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       
Yii::$app->reporter->begintable('800');
$grandtotal=0;
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
       Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
       Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
       Yii::$app->reporter->col($data[$i]['yourref'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
       Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','10','','','');
       Yii::$app->reporter->col($data[$i]['clientname'],'250',null,false,'1px solid ','','L','Century Gothic','10','','','');
       Yii::$app->reporter->col(number_format($data[$i]['amount'],2),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
       Yii::$app->reporter->endrow();
       $grandtotal=$grandtotal+$data[$i]['amount'];
       
       
                if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('RECEIVING CONSIGNMENT REPORT',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Sort by : '.strtoupper($params['sortby']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate:'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('DR #','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('REFERENCE','150',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('SUPPLIER NAME','250',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','3px');
       Yii::$app->reporter->endrow();
       $page=$page + $count;
        }
}

    Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('','150',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('GRAND TOTAL :','250',null,false,'1px solid ','TB','L','Century Gothic','12','B','','');
       Yii::$app->reporter->col(number_format($grandtotal,2),'100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
    
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();

//var_dump($data);
    //var_dump($params);
Yii::$app->reporter->endreport();


?>
