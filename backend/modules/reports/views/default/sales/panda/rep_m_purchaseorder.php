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

//var_dump($data);
//var_dump($_POST);
$rep->beginreport();
$rep->header($header);
echo '<br/>';
$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('Purchase Order','600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        $rep->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        $rep->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        $rep->endrow();
$rep->endtable();
$rep->begintable('800');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('No. '.(isset($data[0]['docno'])? $data[0]['docno']:''),'600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        $rep->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        $rep->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        $rep->endrow();
$rep->endtable();
echo '<br/>';
$rep->begintable('800');
        $rep->startrow();
        $rep->col('Supplier : ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        $rep->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        $rep->col('Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->col('&nbsp;&nbsp;'.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->endrow();
$rep->endtable();
$rep->endtable();
$rep->begintable('800');
        $rep->startrow();
        $rep->col('Address&nbsp;&nbsp;&nbsp;&nbsp;: ','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        $rep->col((isset($data[0]['address'])? $data[0]['address']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        $rep->col('Forex&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->col('&nbsp;&nbsp;'.(isset($data[0]['yourref'])? $data[0]['yourref']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->endrow();
$rep->endtable();
$rep->begintable('800');
        $rep->startrow();
        $rep->col('Ship To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:','75',null,false,'1px solid ','','L','Century Gothic','12','','30px','1px');
        $rep->col((isset($data[0]['shipto'])? $data[0]['shipto']:''),'450',null,false,'1px solid ','','L','Century Gothic','12','','','1px');
        $rep->col('Note&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ','65',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->col('&nbsp;&nbsp;'.(isset($data[0]['rem'])? $data[0]['rem']:''),'210',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->endrow();
$rep->endtable();

$rep->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$rep->begintable('800');
    $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('Item Code','100',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        $rep->col('Item Description','400',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        $rep->col('Purchase<br>Cost','50',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        $rep->col('Quantity ','50',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        $rep->col('Unit','75',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->col('Discount','50',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        $rep->col('Total','75',null,false,'1px solid ','B','R','Century Gothic','12','B','','');

        

   $totalext=0;
for($i=0;$i<count($data);$i++){
        $rep->startrow();
        $rep->addline();
        $rep->col($data[$i]['barcode'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        $rep->col($data[$i]['itemname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
        $rep->col(number_format($data[$i]['netamt'],2),'50',null,false,'1px solid ','','R','Century Gothic','11','','','');
        $rep->col(number_format($data[$i]['qty'],2),'50',null,false,'1px solid ','','R','Century Gothic','11','','','');
        $rep->col($data[$i]['uom'],'75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        $rep->col($data[$i]['disc'],'50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        $rep->col(number_format($data[$i]['ext'],2),'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        $totalext=$totalext+$data[$i]['ext'];
}   
    
        $rep->startrow();
        $rep->col('Total','100',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        $rep->col('','400',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        $rep->col('','50',null,false,'1px solid ','T','R','Century Gothic','11','','','');
        $rep->col('','50',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        $rep->col('','75',null,false,'1px solid ','T','R','Century Gothic','11','','','');
        $rep->col('','50',null,false,'1px solid ','T','L','Century Gothic','11','','','');
        $rep->col(number_format($totalext,2),'75',null,false,'1px solid ','T','R','Century Gothic','11','B','','');
        $rep->endrow();

    $rep->endtable();
    
    
$rep->endtable();
echo '<br/><br/><br/>';
    $rep->begintable('800');
        $rep->startrow();
        $rep->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->col('','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        $rep->col('Approved By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        $rep->endrow();
    $rep->endtable();
    
echo '<br/>';
    $rep->begintable('800');
        $rep->startrow();
        $rep->col($prepared,'266',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->col('','266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        $rep->col($approved,'266',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();

        $rep->endreport();

//var_dump($params);
//var_dump($data);

?>