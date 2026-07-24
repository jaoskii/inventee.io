<div id="print_btn" class="btn_a">
    <?php
    echo CHtml::link(CHtml::image('images/print.png','print',array( 'class'=>'btn_icon')).'Print','#',array('onClick'=>"window.print();"));
    ?>
</div>

 <?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('application.report.css_reports.*');
$count=55;
$page=54;
$rep= new sbcpdf();
$header=$rep->letterhead();
$rep->beginreport('1600');


$rep->begintable('1600');
    $rep->startrow();
        $rep->col('SALES TRANSACTION',null,null,false,'1px solid ','','','Century Gothic','10','B','','');
    $rep->endrow();  
    $rep->startrow();
        $rep->col('RECONCILIATION OF LISTING FOR ENFORCEMENT',null,null,false,'1px solid ','','','Century Gothic','10','B','','');
    $rep->endrow();
$rep->endtable();

$rep->begintable('1600');
    echo '<br/><br/><br/>';
    $rep->startrow();
        $rep->col('TIN : 000326384',null,null,false,'1px solid ','','','Century Gothic','10','B','','');
    $rep->endrow();  
    $rep->startrow();
        $rep->col('OWNER`S NAME : PANDA CONSTRUCTION SUPPLY INC.',null,null,false,'1px solid ','','','Century Gothic','10','B','','');
    $rep->endrow();
    $rep->startrow();
        $rep->col('OWNER`S TRADE NAME : PANDA CONSTRUCTION SUPPLY INC.',null,null,false,'1px solid ','','','Century Gothic','10','B','','');
    $rep->endrow();
    $rep->startrow();
        $rep->col('OWNER`S ADDRESS : 405 NUEVA 289 ZONE 27 111 BINONDO MANILA 1006',null,null,false,'1px solid ','','','Century Gothic','10','B','','');
    $rep->endrow();

$rep->endtable();


$rep->begintable('1600');
    echo '<br/><br/>';
    $rep->startrow();
        $rep->col('TAXABLE<br/>MONTH',100,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('TAXPAYER<br/>IDENTIFICATION<br/>NUMBER',200,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('REGISTERED NAME',200,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('NAME OF CUSTOMER<br/>(Last Name,First Name,Middle Name)',200,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('CUSTOMER`S ADDRESS',200,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('AMOUNT OF<br/>GROSS SALES',100,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('AMOUNT OF<br/>EXEMPT SALES',100,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('AMOUNT OF<br/>ZERO RATED SALES',100,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('AMOUNT OF<br/>TAXABLE SALES',100,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('AMOUNT OF<br/>OUTPUT TAX',100,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('AMOUNT OF<br/>GROSS TAXABLE SALES',120,null,false,'1px solid ','','','Century Gothic','10','B','','');
    $rep->endrow();  
$rep->endtable();
echo '<br/>';
$ext=0;
$ext1=0;
$grossales=0;
$amttaxsales=0;
$amtoutput=0;

$totalgrosssales=0;
$totalext=0;
$totalext1=0;
$totalamtsales=0;
$totalamtoutput=0;
for($i=0;$i<count($data);$i++){
    
    $ext1=number_format($data[$i]['ext'],2);
    $ext=number_format($data[$i]['ext'],2);
    $grossales=$data[$i]['ext'] / 1.12;
    $amttaxsales=$data[$i]['ext'] / 1.12;
    $amtoutput=$data[$i]['ext'] - $amttaxsales;

    $rep->begintable('1600');
    
    $rep->startrow();
        $rep->col($params[2],100,null,false,'1px solid ','','L','Century Gothic','10','B','','');
        $rep->col($data[$i]['tin'],200,null,false,'1px solid ','','L','Century Gothic','10','B','','');
        $rep->col($data[$i]['clientname'],200,null,false,'1px solid ','','L','Century Gothic','10','B','','');
        $rep->col('',200,null,false,'1px solid ','','L','Century Gothic','10','B','','');
        $rep->col($data[$i]['address'],200,null,false,'1px solid ','','L','Century Gothic','10','B','','');
        if ($data[$i]['iszerorated']==1){
        $rep->col('',100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col('',100,null,false,'1px solid ','','','Century Gothic','10','B','','');    
        $rep->col($ext1,100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col('',100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col('',100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col('',120,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        } else {
        $rep->col(number_format($grossales,2),100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col('',100,null,false,'1px solid ','','','Century Gothic','10','B','','');    
        $rep->col('',100,null,false,'1px solid ','','R','Century Gothic','10','B','','');    
        $rep->col(number_format($amttaxsales,2),100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col(number_format($amtoutput,2),100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col($ext,120,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        }
    $rep->endrow();   
    $rep->endtable();
    
    if ($data[$i]['iszerorated']==1){
    $totalext1=$totalext1+$data[$i]['ext'];
    } else {
    $totalgrosssales=$totalgrosssales+$grossales;
    $totalext=$totalext+$data[$i]['ext'];
    $totalamtsales=$totalamtsales+$amttaxsales;
    $totalamtoutput=$totalamtoutput+$amtoutput;
    }
}

$rep->begintable('1600');
    echo '<br/><br/>';
    $rep->startrow();
        $rep->col('GRAND TOTAL :',100,null,false,'1px solid ','','','Century Gothic','10','B','','');
        $rep->col('',200,null,false,'1px solid ','','','Century Gothic','10','','','');
        $rep->col('',200,null,false,'1px solid ','','','Century Gothic','10','','','');
        $rep->col('',200,null,false,'1px solid ','','','Century Gothic','10','','','');
        $rep->col('',200,null,false,'1px solid ','','','Century Gothic','10','','','');
        $rep->col(number_format($totalgrosssales,2),100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col('',100,null,false,'1px solid ','','','Century Gothic','10','','','');
        $rep->col(number_format($totalext1,2),100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col(number_format($totalamtsales,2),100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col(number_format($totalamtoutput,2),100,null,false,'1px solid ','','R','Century Gothic','10','B','','');
        $rep->col(number_format($totalext,2),120,null,false,'1px solid ','','R','Century Gothic','10','B','','');
    $rep->endrow();  
$rep->endtable();

                
$rep->endtable();
$rep->endreport();
//var_dump($data);
?>