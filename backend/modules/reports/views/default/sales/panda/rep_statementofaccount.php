<div id="print_btn" class="btn_a">
    <?php
    echo CHtml::link(CHtml::image('images/print.png','print',array( 'class'=>'btn_icon')).'Print','#',array('onClick'=>"window.print();"));
    ?>
</div>

<?php
Yii::import('application.report.css_reports.*');
$count=38;
$page=38;
$rep= new sbcpdf();

$rep->beginreport();
$rep->begintable('800');
        $rep->startrow();
        $rep->col('<br>');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('PANDA CONSTRUCTION SUPPLY INC.',null,null,false,'1px solid ','','C','Courier New','23','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('STATEMENT OF ACCOUNTS',null,null,false,'1px solid ','','C','Courier New','19','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('For the Period Of '. date('M-d-Y', strtotime($params[1])) . ' TO '  . date('M-d-Y', strtotime($params[2])),null,null,false,'1px solid ','','C','Courier New','17','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('');
        $rep->startrow();
        $rep->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','75',null,false,'1px solid ','','C','Courier New','14','B');
        $rep->col('CUSTOMER : '. (isset($params[14])? $params[14]:''). ' ( '. (isset($data[0]['client'])? $data[0]['client']:'') . ' ) ',null,null,false,'1px solid ','','L','Courier New','17','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','75',null,false,'1px solid ','','C','Courier New','14','B');
        $rep->col('ADDRESS  &nbsp;: '. (isset($data[0]['addr'])? $data[0]['addr']:'') ,null,null,false,'1px solid ','','L','Courier New','17','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('');
        $rep->startrow();
        $rep->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow(null,null,false,'1px solid ','','L','Courier New','13','B');
        $rep->col('','75',null,false,'1px solid ','','C','Courier New','14','B');
        $rep->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Courier New','13','B');
        
		$rep->endrow();
$rep->endtable();

$rep->begintable('');
        $rep->startrow();
        $rep->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
        $rep->col('DATE','100',null,false,'1px solid ','TB','L','Courier New','17','B');
        $rep->col('DOCUMENT #','150',null,false,'1px solid ','TB','L','Courier New','17','B');
        $rep->col('AMOUNT','150',null,false,'1px solid ','TB','R','Courier New','17','B');
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
        
$totalbal=0;       
for($i=0;$i<count($data);$i++){
        $rep->startrow();
		$rep->addline();
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
        $rep->col($data[$i]['docdate'],'100',null,false,'1px solid ','','L','Courier New','17','B');
        $rep->col($data[$i]['refno'],'150',null,false,'1px solid ','','L','Courier New','17','B');
        $rep->col(number_format($data[$i]['balance'],2),'150',null,false,'1px solid ','','R','Courier New','17','B');
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
        $totalbal=$totalbal+$data[$i]['balance'];
        $rep->endrow();
		
		if($rep->linecounter==$page){
            $rep->endtable();
            $rep->page_break();
        $rep->begintable('800');
        $rep->startrow();
        $rep->col('PANDA CONSTRUCTION SUPPLY INC.',null,null,false,'1px solid ','','C','Courier New','23','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('STATEMENT OF ACCOUNTS',null,null,false,'1px solid ','','C','Courier New','19','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('For the Period Of '. date('M-d-Y', strtotime($params[1])) . ' TO '  . date('M-d-Y', strtotime($params[2])),null,null,false,'1px solid ','','C','Courier New','17','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('');
        $rep->startrow();
        $rep->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','75',null,false,'1px solid ','','C','Courier New','14','B');
        $rep->col('CUSTOMER : '. (isset($params[14])? $params[14]:''). ' ( '. (isset($data[0]['client'])? $data[0]['client']:'') . ' ) ',null,null,false,'1px solid ','','L','Courier New','17','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','75',null,false,'1px solid ','','C','Courier New','14','B');
        $rep->col('ADDRESS  &nbsp;: '. (isset($data[0]['addr'])? $data[0]['addr']:'') ,null,null,false,'1px solid ','','L','Courier New','17','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('');
        $rep->startrow();
        $rep->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow(null,null,false,'1px solid ','','L','Courier New','13','B');
        $rep->col('','75',null,false,'1px solid ','','C','Courier New','14','B');
        $rep->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Courier New','13','B');
        
		$rep->endrow();
$rep->endtable();

$rep->begintable('');
        $rep->startrow();
        $rep->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('');
        $rep->startrow();
        $rep->col('<br> ',null,null,false,'1px solid ','','L','Courier New','12','B');
        $rep->endrow();
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
        $rep->col('DATE','100',null,false,'1px solid ','TB','L','Courier New','17','B');
        $rep->col('DOCUMENT #','150',null,false,'1px solid ','TB','L','Courier New','17','B');
        $rep->col('AMOUNT','150',null,false,'1px solid ','TB','R','Courier New','17','B');
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
        $rep->endrow();

            $page=$page + $count;
        }
		
		
		
}      
$rep->endtable();

$rep->begintable('800');
        $rep->startrow();
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
        $rep->col('TOTAL : ','100',null,false,'1px solid ','TB','L','Courier New','17','B');
        $rep->col('','150',null,false,'1px solid ','TB','L','Courier New','17','B');
        $rep->col(number_format($totalbal,2),'150',null,false,'1px solid ','TB','R','Courier New','17','B');
        $rep->col('','50',null,false,'1px solid ','','C','Courier New','17','B');
$rep->endtable();

echo '<br/><br/><br/>';

$rep->begintable('800');
        $rep->startrow();
        $rep->col('DATE OF PAYMENT :','120',null,false,'1px solid ','','C','Courier New','17','B');
        $rep->col('_________________','150',null,false,'1px solid ','','L','Courier New','17','B');
        $rep->col('','100',null,false,'1px solid ','','L','Courier New','17','B');
        $rep->col('RECEIVED BY :','90',null,false,'1px solid ','','L','Courier New','17','B');
        $rep->col('_________________','100',null,false,'1px solid ','','L','Courier New','17','B');
$rep->endtable();

echo '<br/><br/><br/>';

$rep->begintable('800');
        $rep->startrow();
        $rep->col('&nbsp;DATE RECEIVED : _________________ ',null,null,false,'1px solid ','','C','Courier New','17','B');
$rep->endtable();

$rep->endreport();
//var_dump($params);
//var_dump($data);

?>
