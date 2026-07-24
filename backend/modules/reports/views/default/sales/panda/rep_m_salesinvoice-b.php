<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Invoice - B Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
echo '<div style="letter-spacing: 2px;">';
Yii::$app->reporter->beginreport();
echo '<br/><br/><br/><br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col('','525',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col(''.(isset($data[0]['docno'])? $data[0]['docno']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col(''.(isset($data[0]['clientname'])? $data[0]['clientname']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col(''.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col(''.(isset($data[0]['address'])? $data[0]['address']:''),'550',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col(''.(isset($data[0]['terms'])? $data[0]['terms']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col('&nbsp;CUS. CODE:&nbsp;&nbsp;'.(isset($data[0]['client'])? $data[0]['client']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col(''.(isset($data[0]['agname'])? $data[0]['agname']:''),'150',null,false,'1px solid ','','R','Courier New','12','','','');
        Yii::$app->reporter->col(''.(isset($data[0]['yourref'])? $data[0]['yourref']:''),'130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.(isset($data[0]['tin'])? $data[0]['tin']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col('','130',null,false,'1px solid ','','R','Courier New','12','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;','50',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('Ship / Deliver To:&nbsp;&nbsp;'.(isset($data[0]['shipto'])? $data[0]['shipto']:''),'525',null,false,'1px solid ','','L','Courier New','12','','','');
        Yii::$app->reporter->col('Prepared By :','150',null,false,'1px solid ','','R','Courier New','12','','','');
        Yii::$app->reporter->col((isset($prepared)? $prepared:''),'150',null,false,'1px solid ','','R','Courier New','12','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
echo '<br/>';
echo '<div id="details" style="height:207px;clear:both;">';

Yii::$app->reporter->begintable('840');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(' ','600',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        //Yii::$app->reporter->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        Yii::$app->reporter->col(' ','75',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        Yii::$app->reporter->col(' ','75',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        Yii::$app->reporter->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        Yii::$app->reporter->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');
        Yii::$app->reporter->col(' ','100',null,false,'1px solid ','','C','Courier New','12','B','30px','3px');

        
   $sales=0;
   $tax=0;
   $totalext=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['itemname'],'600',null,false,'1px dotted ','','L','Courier New','12','','','');
        //Yii::$app->reporter->col($data[$i]['sizeid'],'100',null,false,'1px dotted','','L','Courier New','12','','','');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],2),'75',null,false,'1px dotted','','R','Courier New','12','','','');
        Yii::$app->reporter->col(strtolower($data[$i]['uom']),'50',null,false,'1px dotted','','C','Courier New','12','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],2),'100',null,false,'1px dotted','','R','Courier New','12','','','');
        Yii::$app->reporter->col($data[$i]['disc'],'100',null,false,'1px dotted','','C','Courier New','12','','','');
        Yii::$app->reporter->col('        '.number_format($data[$i]['ext'],2),'100',null,false,'1px dotted','','R','Courier New','12','','','');
        $totalext=$totalext+$data[$i]['ext'];
        $sales=$totalext/1.12;
        $tax=$sales*0.12;
} 
Yii::$app->reporter->begintable('800');
 Yii::$app->reporter->startrow();
 Yii::$app->reporter->col('***************** NOTHING TO FOLLOWS *****************','50',null,false,'1px solid ','','C','Courier New','11','','','');
 Yii::$app->reporter->endrow();
 Yii::$app->reporter->endtable();
echo '</div><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','500px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','125px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','R','Courier New','12','B','','');
        Yii::$app->reporter->col(number_format($totalext,2),'125px',null,false,'1px dotted ','','R','Courier New','14','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','500px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','125px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','R','Courier New','12','B','','');
        Yii::$app->reporter->col('<br>','125px',null,false,'1px dotted ','','R','Courier New','14','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();  
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','500px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','125px',null,false,'1px dotted ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','R','Courier New','12','B','','');
        Yii::$app->reporter->col(number_format($totalext,2),'125px',null,false,'1px dotted ','','R','Courier New','15','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();    
Yii::$app->reporter->endtable();
echo '</div>';

        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>