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
$header=$rep->letterhead();
echo '<div style="letter-spacing: 2px;">';
$rep->beginreport();
echo '<br/><br/><br/><br/><br/>';
$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col('','525',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col(''.(isset($data[0]['docno'])? $data[0]['docno']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        $rep->endrow();
$rep->endtable();
$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col(''.(isset($data[0]['clientname'])? $data[0]['clientname']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col(''.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        $rep->endrow();
$rep->endtable();
$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col(''.(isset($data[0]['address'])? $data[0]['address']:''),'550',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col(''.(isset($data[0]['terms'])? $data[0]['terms']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        $rep->endrow();
$rep->endtable();
$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col('&nbsp;CUS. CODE:&nbsp;&nbsp;'.(isset($data[0]['client'])? $data[0]['client']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col(''.(isset($data[0]['agname'])? $data[0]['agname']:''),'150',null,false,'1px solid ','','R','Courier New','12','','','');
        $rep->col(''.(isset($data[0]['yourref'])? $data[0]['yourref']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('','50',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.(isset($data[0]['tin'])? $data[0]['tin']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col('','130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        $rep->endrow();
$rep->endtable();
echo '<br/>';
$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('&nbsp;&nbsp;&nbsp;&nbsp;','50',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col('Ship To:&nbsp;&nbsp;'.(isset($data[0]['shipto'])? $data[0]['shipto']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        $rep->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        $rep->col('','130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        $rep->endrow();
$rep->endtable();
echo '<br/><br/>';
echo '<div id="details" style="height:207px;clear:both;">';

$rep->begintable('840');
    $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col(' ','600',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        //$rep->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        $rep->col(' ','75',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        $rep->col(' ','75',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        $rep->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        $rep->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        $rep->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');

        
   $sales=0;
   $tax=0;
   $totalext=0;
for($i=0;$i<count($data);$i++){
        $rep->startrow();
        $rep->col($data[$i]['itemname'],'600',null,false,'1px dotted ','','L','Courier New','12','','','');
        //$rep->col($data[$i]['sizeid'],'100',null,false,'1px dotted','','L','Courier New','12','','','');
        $rep->col(number_format($data[$i]['qty'],2),'75',null,false,'1px dotted','','R','Courier New','12','','','');
        $rep->col($data[$i]['uom'],'50',null,false,'1px dotted','','C','Courier New','12','','','2px');
        $rep->col(number_format($data[$i]['amt'],2),'100',null,false,'1px dotted','','R','Courier New','12','','','');
        $rep->col($data[$i]['disc'],'100',null,false,'1px dotted','','C','Courier New','12','','','');
        $rep->col('        '.number_format($data[$i]['ext'],2),'100',null,false,'1px dotted','','R','Courier New','12','','','');
        $totalext=$totalext+$data[$i]['ext'];
        $sales=$totalext/1.12;
        $tax=$sales*0.12;
} 
$rep->begintable('800');
 $rep->startrow();
 $rep->col('***************** NOTHING TO FOLLOWS *****************','50',null,false,'1px solid ','','C','Courier New','11','','','');
 $rep->endrow();
 $rep->endtable();
echo '</div><br/>';

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','500px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','125px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','50px',null,false,'1px dotted ','','R','Courier New','12','B','','');
        $rep->col(number_format($sales,2),'125px',null,false,'1px dotted ','','R','Courier New','14','','','');
        $rep->endrow();
$rep->endtable();
$rep->begintable('800');
        $rep->startrow();
        $rep->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','500px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','125px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','50px',null,false,'1px dotted ','','R','Courier New','12','B','','');
        $rep->col(number_format($tax,2),'125px',null,false,'1px dotted ','','R','Courier New','14','','','');
        $rep->endrow();
$rep->endtable();  
$rep->begintable('800');
        $rep->startrow();
        $rep->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','500px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','125px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        $rep->col('','50px',null,false,'1px dotted ','','R','Courier New','12','B','','');
        $rep->col(number_format($totalext,2),'125px',null,false,'1px dotted ','','R','Courier New','15','','','');
        $rep->endrow();
$rep->endtable();    
$rep->endtable();
echo '</div>';

        $rep->endreport();

//var_dump($params);
//var_dump($data);

?>