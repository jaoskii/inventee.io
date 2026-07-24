<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Expenses Report - Summary';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=20;
$page=20;
// $header=Yii::$app->reporter->letterhead();

//var_dump($data);
//var_dump($_POST);
Yii::$app->reporter->beginreport();

// Yii::$app->reporter->page_break();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('EXPENSES REPORT SUMMARY',null,null,'','1px solid ','LRTB','C','Verdana','18','B','','<br/>');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','LRTB','C','Verdana','18','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
echo '<br/>';
Yii::$app->reporter->begintable('800');
$totalsum=0;
for($sum=0;$sum<count ($data);$sum++){
        Yii::$app->reporter->startrow();
        $sumamt=number_format($data[$sum]['amount'],2);
            if ($sumamt==0)
            {
            $sumamt='-';
            } 
                 Yii::$app->reporter->col($data[$sum]['acnoname'],null,null,'','1px solid ','LRTB','C','Verdana','15','','','5px');
                 Yii::$app->reporter->col($sumamt,null,null,'','1px solid ','LRTB','R','Verdana','15','','','5px');
                 $totalsum=$totalsum + $data[$sum]['amount'];
                 Yii::$app->reporter->endrow();
}

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('TOTAL : ',null,null,'','1px solid ','LRTB','R','Verdana','15','B','','5px');
        Yii::$app->reporter->col(number_format($totalsum,2),null,null,'','1px solid ','LRTB','R','Verdana','15','B','','5px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
//

//var_dump($data2);

?>