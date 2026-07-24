<div id="print_btn" class="btn_a">
    <?php
    echo CHtml::link(CHtml::image('images/print.png','print',array( 'class'=>'btn_icon')).'Print','#',array('onClick'=>"window.print();"));
    ?>
</div>

<?php
Yii::import('application.report.css_reports.*');
$count=60;
$page=58;
$rep= new sbcpdf();
$rep->beginreport();
echo '<div style="margin-top:-5px;">';
$rep->begintable('480');
        $rep->startrow();
        $rep->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','50',null,false,'1px solid ','','L','Courier','12','','','');
        $rep->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'300',null,false,'1px solid ','','L','Courier','15','B','30px','4px');
        $rep->col(''.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'100',null,false,'1px solid ','','L','Courier','15','B','30px','4px');
        $rep->endrow();
$rep->endtable();
echo '</div>';
$rep->begintable('480');
        $rep->startrow();
        $rep->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','50',null,false,'1px solid ','','L','Courier','12','','30px','4px');
        $rep->col((isset($data[0]['address'])? $data[0]['address']:''),'450',null,false,'1px solid ','','L','Courier','12','B','30px','4px');
        $rep->endrow();
$rep->endtable();
echo '<br/>';
echo '<div id="details" style="height:480px;clear:both;">';
$rep->begintable('475','');
    $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('<br/><br/><br/><br/>','50',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        $rep->col('<br/><br/><br/><br/>','50',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        $rep->col('<br/><br/><br/><br/>','230',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        $rep->col('<br/><br/><br/><br/>','70',null,false,'1px solid ','','C','Courier','10','','30px','4px');
        $rep->col('<br/><br/><br/><br/>','75',null,false,'1px solid ','','C','Courier','10','','30px','4px');
   $totalext=0;
   $totalqty=0;
for($i=0;$i<count($data);$i++){
        $rep->startrow();
        $rep->addline();
        
        $rep->col(number_format($data[$i]['qty']),'50',null,false,'1px dotted ','B','C','Courier','15','B','','');
        $rep->col($data[$i]['uom'],'50',null,false,'1px dotted ','B','C','Courier','15','B','','','');
        $rep->col($data[$i]['barcode'].'/'.$data[$i]['itemname'],'230',null,false,'1px dotted','B','L','Courier','15','B','','');
        $rep->col(number_format($data[$i]['cost'],2),'70',null,false,'1px dotted ','B','R','Courier','15','B','','');
        $rep->col(number_format($data[$i]['ext'],2),'75',null,false,'1px dotted ','B','R','Courier','15','B','','');
        $totalext=$totalext+$data[$i]['ext'];
        $totalqty=$totalqty+$data[$i]['qty'];
}   
 $rep->endtable();
 $rep->begintable('480');
 $rep->startrow();
 $rep->col('******** NOTHING TO FOLLOW ********','50',null,false,'1px solid ','','C','Courier','15','B','','');
 $rep->endrow();
 $rep->endtable();
 echo '</div>';
 echo '<br/>';
 echo '<div ="footer" style="width:500px;height:200px;margin-top:70px;position:absolute;">';

 $rep->begintable('480');
        $rep->startrow();
        $rep->col(number_format($totalqty,2).'PC(S)','150',null,false,'1px dotted ','','C','Courier','15','B','','');
        $rep->col($i.'  ITEM(S)','250',null,false,'1px dotted ','','C','Courier','15','B','','');
        $rep->col('','75',null,false,'1px dotted ','','R','Courier','15','B','','');
        $rep->col(number_format($totalext,2),'75px',null,false,'1px dotted ','','R','Courier','15','B','','');
        $rep->endrow();
 $rep->endtable();
 echo '<br/>';
     $rep->begintable('480');
        $rep->startrow();
        $rep->col((isset($data[0]['docno'])? $data[0]['docno']:''),'480',null,false,'1px solid ','','C','Courier','15','B','','');
        $rep->endrow();
    $rep->endtable();     
     echo '<div style="position:fixed;">';   
    echo '<br/>';
    $rep->begintable('480');
        $rep->startrow();
        $rep->col($prepared,'200',null,false,'1px solid ','','C','Courier','15','','','');
        $rep->col('','100',null,false,'1px solid ','','C','Courier','15','10','','','');
        $rep->col($received,'200',null,false,'1px solid ','','C','Courier','15','','','');
        $rep->endrow();
    $rep->endtable();
       echo '</div>';
       
$rep->endtable();
echo '</div>';

        $rep->endreport();

//var_dump($params);
//var_dump($data);

?>