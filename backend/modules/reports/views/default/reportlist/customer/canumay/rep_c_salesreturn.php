<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Return';
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
        Yii::$app->reporter->col('SALES '.strtoupper($params['salesreporttype']),null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('',null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center : '.strtoupper($params['center']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        if($params['sortby']=='docno'){
        Yii::$app->reporter->col('Sort By : Document #','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Sort By : Date','150',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('CLIENT','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('CLIENT NAME','200',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('TOTAL AMOUNT','200',null,false,'1px solid ','TB','R','Century Gothic','11','B','','');
       Yii::$app->reporter->col('STATUS','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       
$Tot=0;
$amt=0;
//Sales with Return Report
if ($params['salesreporttype']=='lessreturn')
 {

 }
//Sales Report and Sales Return
else {
Yii::$app->reporter->begintable('800');
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();
    
       Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
       Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
       Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
       Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
       Yii::$app->reporter->col(number_format($data[$i]['amount'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Century Gothic','10','','','');
              Yii::$app->reporter->col($data[$i]['tr']=='p'?'Posted':'Unposted','100',null,false,'1px solid ','','C','Century Gothic','10','','','');
    
       Yii::$app->reporter->endrow();
       $Tot = $Tot + $data[$i]['amount'];

       if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

                Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
         Yii::$app->reporter->col('SALES '.strtoupper($params['salesreporttype']),null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('',null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center : '.strtoupper($params['center']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        if($params['sortby']=='docno'){
        Yii::$app->reporter->col('Sort By : Document #','150',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Sort By : Date','150',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('CLIENT','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('CLIENT NAME','200',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('TOTAL AMOUNT','200',null,false,'1px solid ','TB','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('STATUS','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       $page=$page + $count;
    }
}

       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','10','','','');
       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','10','','','');
       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','10','','','');
       Yii::$app->reporter->col('GRAND TOTAL :','300',null,false,'1px solid ','TB','L','Century Gothic','10','B','','');
       Yii::$app->reporter->col(number_format($Tot,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200px',null,false,'1px solid ','TB','R','Century Gothic','10','B','','');
       Yii::$app->reporter->col('','100px',null,false,'1px solid ','TB','C','Century Gothic','10','','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();

}
//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


?>
