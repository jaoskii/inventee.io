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


Yii::$app->reporter->beginreport('800');
if (!empty($data)){
echo '<div style="letter-spacing: 2px;">';
Yii::$app->reporter->beginreport();
// echo '<br/>';
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Courier New','11','','','');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Courier New','11','B','','');
    Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'200',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
    Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Courier New','11','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
    Yii::$app->reporter->col(''.(isset($data[0]['clientname'])? strtoupper($data[0]['clientname']):''),'250',null,false,'1px solid ','','L','Courier New','12','','','');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Courier New','11','B','','');
    Yii::$app->reporter->col(''.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','','R','Courier New','12','','','');
    Yii::$app->reporter->col('','350',null,false,'1px solid ','','R','Courier New','11','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


echo '<br/>';
echo '<div id="details" style="margin-left:-10px;height:425px;clear:both;">';

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(' ','20',null,false,'1px solid ','','C','Courier New','11','B','30px','3px');
        Yii::$app->reporter->col(' ','30',null,false,'1px solid ','','C','Courier New','11','B','30px','3px');
        Yii::$app->reporter->col(' ','250',null,false,'1px solid ','','C','Courier New','11','B','30px','3px');
        Yii::$app->reporter->col(' ','100',null,false,'1px solid ','','C','Courier New','11','B','30px','3px');
        Yii::$app->reporter->col(' ','100',null,false,'1px solid ','','C','Courier New','11','B','30px','3px');
        Yii::$app->reporter->col(' ','150',null,false,'1px solid ','','C','Courier New','11','B','30px','3px');
        Yii::$app->reporter->col(' ','150',null,false,'1px solid ','','C','Courier New','11','B','30px','3px');

       
   $sales=0;
   $tax=0;
   $totalext=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(number_format($data[$i]['qty']),'20',null,false,'1px dotted','','L','Courier New','12','','30px','2px');
        Yii::$app->reporter->col(strtolower($data[$i]['uom']),'30',null,false,'1px dotted','','L','Courier New','12','','30px','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'250',null,false,'1px dotted ','','L','Courier New','12','','30px','2px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','','R','Courier New','12','','30px','2px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','','R','Courier New','12','','30px','2px');
        Yii::$app->reporter->col('','125',null,false,'1px dotted','','R','Courier New','12','','','');
        Yii::$app->reporter->col('','125',null,false,'1px dotted','','R','Courier New','12','','','');
        $totalext=$totalext+$data[$i]['ext'];
        $sales=$totalext/1.11;
        $tax=$sales*0.11;
} 
Yii::$app->reporter->begintable('800');
 Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col('********* NOTHING TO FOLLOWS ***********','350',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->endrow();
 Yii::$app->reporter->endtable();
echo '</div>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','20',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col('','30',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col('','250',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','','R','Courier New','12','','','');
        Yii::$app->reporter->col('','125',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->col('','125',null,false,'1px dotted ','','C','Courier New','11','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();    
// Yii::$app->reporter->endtable();
echo '</div><br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'200',null,false,'1px dotted ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col($approved,'200',null,false,'1px dotted ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col($received,'200',null,false,'1px dotted ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();    
} else {
echo '<br/><br/><br/>';    
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('TRANSACTION POSTED','800',null,false,'1px solid ','','C','Courier New','20','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
}
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($prepared);

?>