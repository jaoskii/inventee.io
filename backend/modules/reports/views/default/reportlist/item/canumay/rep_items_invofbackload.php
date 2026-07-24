<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory of Backload';
?>
<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
Yii::$app->reporter->beginreport('800');

echo '<div style="letter-spacing: 2px;">';
Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('INVENTORY OF BACKLOAD',null,null,false,'1px solid ','','C','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col(date('m/d/Y',time()),null,null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

//header info
Yii::$app->reporter->begintable(1000);
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('DATE','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DOC','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEMS DESCRIPTION','200',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();

for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['DATE'],'100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col($data[$i]['DOC'],'100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col($data[$i]['ITEMS'],'200',null,false,'1px dashed ','','L','Century Gothic','11','','30px','7px');
        Yii::$app->reporter->col($data[$i]['CODE'],'100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col(number_format($data[$i]['QTY'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col(number_format($data[$i]['PRICE'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col(number_format($data[$i]['AMOUNT'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
    
}//END FR EACH

Yii::$app->reporter->endrow();
Yii::$app->reporter->endreport();
echo '</div>';

?>