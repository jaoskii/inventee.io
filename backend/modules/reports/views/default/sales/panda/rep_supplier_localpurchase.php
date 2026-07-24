<div id="print_btn" class="btn_a">
    <?php
    echo CHtml::link(CHtml::image('images/print.png','print',array( 'class'=>'btn_icon')).'Print','#',array('onClick'=>"window.print();"));
    ?>
</div>

<?php
Yii::import('application.report.css_reports.*');
$rep= new sbcpdf();

$date = $params[1];
$mons = date("m", strtotime($date));
switch ($mons){
    
    case 1:
        $month = "JANUARY";
        break;
    case 2:
        $month = "FEBRUARY";
        break;
    case 3:
        $month = "MARCH";
        break;
    case 4:
        $month = "APRIL";
        break;
    case 5:
        $month = "MAY";
        break;
    case 6:
        $month = "JUNE";
        break;
    case 7:
        $month = "JULY";
        break;
    case 8:
        $month = "AUGUST";
        break;
    case 9:
        $month = "SEPTEMBER";
        break;
    case 10:
        $month = "OCTOBER";
        break;
    case 11:
        $month = "NOVEMBER";
        break;
    case 12:
        $month = "DECEMBER";
        break;
}

$rep->beginreport('800');
    $rep->begintable('800');
        $rep->startrow();
        echo '<br/><br/>';
        $rep->col('PANDA CONSTRUCTION SUPPLY, INC.',null,null,false,'1px solid ','','L','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();
    
    $rep->begintable('800');
        $rep->startrow();
        $rep->col('LOCAL PURCHASE SUBJECT TO WITHHOLDING TAX',null,null,false,'1px solid ','','L','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();
    
    $rep->begintable('800');
        $rep->startrow();
        $rep->col('FOR THE MONTH OF '. $month . ' '. date("Y"),null,null,false,'1px solid ','','L','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();
    
    $rep->begintable('800');
    echo '<br/>';
        $rep->startrow();
        $rep->col('SUPPLIER`S OF GOOD',200,null,false,'1px solid ','LT','C','Century Gothic','12','B','','');
        $rep->col('INV. DATE',100,null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        $rep->col('INV. NO',100,null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        $rep->col('AMOUNT',100,null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        $rep->col('NET OF VAT',100,null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        $rep->col('1%EWT',100,null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        $rep->col('AMOUNT',100,null,false,'1px solid ','TR','C','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();   
    $rep->begintable('800');
        $rep->startrow();
        $rep->col('',200,null,false,'1px solid ','LB','C','Century Gothic','12','B','','');
        $rep->col('',100,null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->col('',100,null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->col('PER INV.',100,null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->col('',100,null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->col('',100,null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        $rep->col('NET PAID',100,null,false,'1px solid ','RB','C','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();   
    

$netofvat=0;
$ewt=0;
$netpaid=0;
$totalext=0;
$totalnet=0;
$totalewt=0;
$totalnetpaid=0;

$client='';
echo '<br/>';
for($i=0;$i<count($data);$i++){
    
    $ext=number_format($data[$i]['ext'],2);
    if ($ext==0){
        $ext='-';
    }
    $netofvat=$data[$i]['ext'] / 1.12;
    $ewt=$netofvat * .01;
    $netpaid=$data[$i]['ext']-$ewt;
    $rep->begintable('800');
    
if ($client==$data[$i]['clientname']){
$client="";
}else{
$client=$data[$i]['clientname'];
}
        $rep->startrow();
        $rep->col($client,200,null,false,'1px solid ','','L','Century Gothic','12','','','');
        $rep->col($data[$i]['dateid'],100,null,false,'1px solid ','','C','Century Gothic','12','','','');
        $rep->col($data[$i]['docno'],100,null,false,'1px solid ','','c','Century Gothic','12','','','');
        $rep->col(number_format($data[$i]['ext'],2),100,null,false,'1px solid ','','R','Century Gothic','12','','','');
        $rep->col(number_format($netofvat,2),100,null,false,'1px solid ','','R','Century Gothic','12','','','');
        $rep->col(number_format($ewt,2),100,null,false,'1px solid ','','R','Century Gothic','12','','','');
        $rep->col(number_format($netpaid,2),100,null,false,'1px solid ','','R','Century Gothic','12','','','');
        $rep->endrow();
        
        $totalext=$totalext+$data[$i]['ext'];
        $totalnet=$totalnet+$netofvat;
        $totalewt=$totalewt+$ewt;
        $totalnetpaid=$totalnetpaid+$netpaid;
        
        $client=$data[$i]['clientname'];
        
    $rep->endtable();
    
    
}
$rep->printline();
$rep->begintable('800');
        $rep->startrow();
        $rep->col('TOTAL :',200,null,false,'1px solid ','','L','Century Gothic','12','B','','');
        $rep->col('',100,null,false,'1px solid ','','C','Century Gothic','12','B','','');
        $rep->col('',100,null,false,'1px solid ','','c','Century Gothic','12','B','','');
        $rep->col(number_format($totalext,2),100,null,false,'1px solid ','','R','Century Gothic','12','B','','');
        $rep->col(number_format($totalnet,2),100,null,false,'1px solid ','','R','Century Gothic','12','B','','');
        $rep->col(number_format($totalewt,2),100,null,false,'1px solid ','','R','Century Gothic','12','B','','');
        $rep->col(number_format($totalnetpaid,2),100,null,false,'1px solid ','','R','Century Gothic','12','B','','');
        $rep->endrow();
    $rep->endtable();

        $rep->endreport();

//var_dump($params);
//var_dump($data);

?>