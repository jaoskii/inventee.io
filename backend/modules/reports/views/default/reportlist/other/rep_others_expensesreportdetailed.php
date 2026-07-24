<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Expenses Report - Detailed';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=20;
$page=20;
// $header=Yii::$app->reporter->letterhead();

Yii::$app->reporter->beginreport();

// Yii::$app->reporter->page_break();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('EXPENSES REPORT DETAILED',null,null,'','1px solid ','LRTB','C','Verdana','18','B','','<br/>');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','LRTB','C','Verdana','18','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                 Yii::$app->reporter->col('DATE','100',null,'','1px solid ','LRTB','C','Verdana','13','B','','3px');
                 Yii::$app->reporter->col('PCV#','100',null,'','1px solid ','LRTB','C','Verdana','13','B','','3px');
                 Yii::$app->reporter->col('NAME','150',null,'','1px solid ','LRTB','C','Verdana','13','B','','3px');
                 Yii::$app->reporter->col('ACCT NAME','100',null,'','1px solid ','LRTB','C','Verdana','13','B','','3px');
                 Yii::$app->reporter->col('DESCRIPTION','250',null,'','1px solid ','LRTB','C','Verdana','13','B','','3px');
                 Yii::$app->reporter->col('AMOUNT','100',null,'','1px solid ','LRTB','C','Verdana','13','B','','3px');
$totaldet=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        $detamt=number_format($data[$i]['amount'],2);
            if ($detamt==0)
            {
            $detamt='-';
            } 
                 Yii::$app->reporter->col($data[$i]['dateid'],'100',null,'','1px solid ','LRTB','C','Verdana','11','','','');
                 Yii::$app->reporter->col($data[$i]['docno'],'100',null,'','1px solid ','LRTB','C','Verdana','11','','','');
                 Yii::$app->reporter->col($data[$i]['clientname'],'150',null,'','1px solid ','LRTB','L','Verdana','11','','','');
                 Yii::$app->reporter->col($data[$i]['acnoname'],'100',null,'','1px solid ','LRTB','L','Verdana','11','','','');
                 Yii::$app->reporter->col($data[$i]['description'],'250',null,'','1px solid ','LRTB','L','Verdana','11','','','');
                 Yii::$app->reporter->col($detamt,'100',null,'','1px solid ','LRTB','R','Verdana','11','','','');
                 $totaldet=$totaldet + $data[$i]['amount'];
                 Yii::$app->reporter->endrow();
                 
}
                    
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,'','1px solid ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','100',null,'','1px solid ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('','150',null,'','1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->col('TOTAL :','350',null,'','1px solid ','LRTB','R','Verdana','12','B','','');
        Yii::$app->reporter->col(number_format($totaldet,2),'100',null,'','1px solid ','LRTB','R','Verdana','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
//

//var_dump($data);

?>