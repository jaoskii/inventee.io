<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Comparison (Graph)';
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

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1200');
       
Yii::$app->reporter->endtable();
        Yii::$app->reporter->startrow();
       // Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','LRTB','C','Verdana','18','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
echo '<br/>';
 Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SALES COMPARISON',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->begintable('1200');

echo '<br/>';

    echo '<div id="chartContainer" style="height: 250px; width: 100%;"> </div>';


     
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
//

//var_dump($data2);

?>