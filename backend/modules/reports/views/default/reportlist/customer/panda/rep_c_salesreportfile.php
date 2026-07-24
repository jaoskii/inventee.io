<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Report File Report';
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
        Yii::$app->reporter->col('SALES REPORT FILE',null,null,false,'1px solid ','','','Century Gothic','24','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','12','','30px','5px');
        Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('CLIENT NAME','400',null,false,'1px solid ','TB','L','Century Gothic','14','B','','');
	   Yii::$app->reporter->col('TIN','200',null,false,'1px solid ','TB','L','Century Gothic','14','B','','');
       Yii::$app->reporter->col('AMOUNT','200',null,false,'1px solid ','TB','R','Century Gothic','14','B','','');
       $page=$page + $count;
$Tot=0;
$amt=0;
//Sales with Return Report

Yii::$app->reporter->begintable('800');
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();
       Yii::$app->reporter->col($data[$i]['clientname'],'400',null,false,'1px solid ','','L','Century Gothic','12','','','');
	   Yii::$app->reporter->col($data[$i]['tin'],'200',null,false,'1px solid ','','L','Century Gothic','12','','','');
       Yii::$app->reporter->col(number_format($data[$i]['amount'],2),'200',null,false,'1px solid ','','R','Century Gothic','12','','','');
       Yii::$app->reporter->endrow();
       $Tot = $Tot + $data[$i]['amount'];

       if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
            Yii::$app->reporter->header($header);
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALES REPORT FILE',null,null,false,'1px solid ','','','Century Gothic','24','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params[1])) .' TO '. date('M-d-Y', strtotime($params[2])),null,null,false,'1px solid ','','L','Century Gothic','12','','30px','5px');
        Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('CLIENT NAME','400',null,false,'1px solid ','TB','L','Century Gothic','14','B','','');
	   Yii::$app->reporter->col('TIN','200',null,false,'1px solid ','TB','L','Century Gothic','14','B','','');
       Yii::$app->reporter->col('AMOUNT','200',null,false,'1px solid ','TB','R','Century Gothic','14','B','','');
       $page=$page + $count;
    }
}

Yii::$app->reporter->printline();
       Yii::$app->reporter->col('GRAND TOTAL :','400',null,false,'1px solid ','TB','L','Century Gothic','12','B','','');
	   Yii::$app->reporter->col('','200',null,false,'1px solid ','TB','L','Century Gothic','12','B','','');
       Yii::$app->reporter->col(number_format($Tot,2),'200',null,false,'1px solid ','TB','R','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>
