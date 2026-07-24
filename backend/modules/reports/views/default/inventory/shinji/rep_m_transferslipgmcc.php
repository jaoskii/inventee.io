<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Transfer Slip Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport();
echo '<div style="margin-top:-5px;">';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','50',null,false,'1px solid ','','L','Courier','12','','','');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'300',null,false,'1px solid ','','L','Courier','15','B','30px','4px');
        Yii::$app->reporter->col(''.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'100',null,false,'1px solid ','','L','Courier','15','B','30px','4px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '</div>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','50',null,false,'1px solid ','','L','Courier','12','','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'450',null,false,'1px solid ','','L','Courier','12','B','30px','4px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/>';
echo '<div id="details" style="height:480px;clear:both;">';
Yii::$app->reporter->begintable('475','');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('<br/><br/><br/><br/>','50',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        Yii::$app->reporter->col('<br/><br/><br/><br/>','50',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        Yii::$app->reporter->col('<br/><br/><br/><br/>','230',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        Yii::$app->reporter->col('<br/><br/><br/><br/>','70',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        Yii::$app->reporter->col('<br/><br/><br/><br/>','75',null,false,'1px solid ','','C','Courier','10','','30px','4px');
   $totalext=0;

   $totalqty=0;
   for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        
        Yii::$app->reporter->col(number_format($data[$i]['qty']),'50',null,false,'1px dotted ','B','C','Courier','15','B','','');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px dotted ','B','C','Courier','15','B','','','');
        Yii::$app->reporter->col($data[$i]['barcode'].'/'.$data[$i]['itemname'],'230',null,false,'1px dotted','B','L','Courier','15','B','','');
        Yii::$app->reporter->col(number_format($data[$i]['cost'],2),'70',null,false,'1px dotted ','B','R','Courier','15','B','','');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],2),'75',null,false,'1px dotted ','B','R','Courier','15','B','','');
        $totalext=$totalext+$data[$i]['ext'];
        $totalqty=$totalqty+$data[$i]['qty'];
}   
 Yii::$app->reporter->endtable();
 Yii::$app->reporter->begintable('480');
 Yii::$app->reporter->startrow();
 Yii::$app->reporter->col('******** NOTHING TO FOLLOW ********','50',null,false,'1px solid ','','C','Courier','15','B','','');
 Yii::$app->reporter->endrow();
 Yii::$app->reporter->endtable();
 echo '</div>';
echo '<br/>';
echo '<div ="footer" style="width:500px;height:200px;margin-top:70px;position:absolute;">';

 Yii::$app->reporter->begintable('480');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(number_format($totalqty,2).'PC(S)','150',null,false,'1px dotted ','','C','Courier','15','B','','');
        Yii::$app->reporter->col($i.'  ITEM(S)','250',null,false,'1px dotted ','','C','Courier','15','B','','');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','','R','Courier','15','B','','');
        Yii::$app->reporter->col(number_format($totalext,2),'75px',null,false,'1px dotted ','','R','Courier','15','B','','');
        Yii::$app->reporter->endrow();
 Yii::$app->reporter->endtable();
 echo '<br/>';
 Yii::$app->reporter->begintable('480');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'480',null,false,'1px solid ','','C','Courier','15','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();     
     echo '<div style="position:fixed;">';   
    echo '<br/>';
    Yii::$app->reporter->begintable('480');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','','C','Courier','15','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Courier','15','10','','','');
        Yii::$app->reporter->col($received,'200',null,false,'1px solid ','','C','Courier','15','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
       echo '</div>';
       
Yii::$app->reporter->endtable();
echo '</div>';
Yii::$app->reporter->endreport();

?>