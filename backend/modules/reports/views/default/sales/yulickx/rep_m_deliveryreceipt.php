<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
Yii::$app->reporter->beginreport();

            Yii::$app->reporter->begintable('800');
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('DELIVERY RECEIPT','800',null,false,'1px solid ','','C','Century Gothic','18','B','','');
                Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Customer : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('Date : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Address : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('PO No : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['ourref'])? $data[0]['ourref']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('','520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('Terms : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Item No','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','5px','2px');
            Yii::$app->reporter->col('Quantity','50',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','5px','2px');
            Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','5px','2px');
            Yii::$app->reporter->col('DESCRIPTION','400',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','5px','2px');
            Yii::$app->reporter->col('Unit Price','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','5px','2px');
            Yii::$app->reporter->col('Amount','100',null,false,'1px solid ','LRTB','C','Century Gothic','11','B','5px','2px');

   $totalext=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'50px',null,false,'1px solid ','LRTB','C','Century Gothic','10','','','2px');
        Yii::$app->reporter->col('','50px',null,false,'1px solid ','LRTB','C','Century Gothic','10','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'500px',null,false,'1px solid ','LRTB','C','Century Gothic','10','','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'125px',null,false,'1px solid ','LRTB','L','Century Gothic','10','','','2px');
        Yii::$app->reporter->col('','50px',null,false,'1px solid ','LRTB','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('','125px',null,false,'1px solid ','LRTB','R','Century Gothic','10','','','2px');
        $totalext=$totalext+$data[$i]['ext'];

}   

    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

     Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Received the above goods in good order and condition.','800',null,false,'1px solid ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
            Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
            Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>