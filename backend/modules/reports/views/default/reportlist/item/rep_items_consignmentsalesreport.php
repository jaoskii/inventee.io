<div id="print_btn" class="btn_a">
    <?php
    echo CHtml::link(CHtml::image('images/print.png','print',array( 'class'=>'btn_icon')).'Print','#',array('onClick'=>"window.print();"));
    ?>
</div>

<?php
Yii::import('application.report.css_reports.*');
$count=15;
$page=14;
$rep= new sbcpdf();

//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$rep->beginreport('1000');

$rep->begintable('1000');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('CONSIGNMENT SALES REPORT',null,null,false,'1px solid ','','','Verdana','18','B','B','','').'<br />';
        $rep->endrow();
        $rep->startrow(null,null,false,'1px solid ','','R','Verdana','11','','','');
        $rep->col('Center :'.$cname,null,null,false,'1px solid ','','L','Verdana','11','','','');
        $rep->col(date('M-d-Y', strtotime($asof)),null,null,false,'1px solid ','','L','Verdana','11','','','');        
        //$rep->pagenumber('Page');
        $rep->endrow();
$rep->endtable();

$rep->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$rep->begintable('1000');

$stotalamt=0;
for($s=0;$s<count($data);$s++){
    if ($data[$s]['grp']=='sales'){
        $rep->startrow();
        $stotalamt=$stotalamt+$data[$s]['ext'];
    $rep->endrow();
    }
}

    $rep->startrow();
     if ($stotalamt > 0){ 
        $rep->col('SALES',null,null,false,'1px solid ','','C','Verdana','11','B','','');
  
    $rep->endrow();
$rep->endtable(); 
$rep->begintable('1000');  
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('INVOICE #',50,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('PLU',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('QTY SOLD X DESCRIPTION',120,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('SRP',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('DISCOUNT',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('TOTAL<br/>AMOUNT',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('QTY<br/>BALANCE',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('REMARKS',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('CREDIT CARD',60,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('ENCODED<br/>DATE',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
    $rep->endrow();
$stotalamt=0;
for($s=0;$s<count($data);$s++){
    if ($data[$s]['grp']=='sales'){
        $rep->startrow();
        $rep->addline();
        if($data[$s]['bal']==0){
        $rep->col($s+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','');
        $rep->col($data[$s]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$s]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$s]['qty'],0).' x '.$data[$s]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$s]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$s]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$s]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$s]['bal']),30,null,false,'1px solid ','B','R','Verdana','9','','red','2px');
        $rep->col($data[$s]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$s]['cardtype'].'<br/>'.$data[$s]['acctname'].'<br/>'.$data[$s]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$s]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $stotalamt=$stotalamt+$data[$s]['ext'];
        $rep->endrow();
        }else {
        $rep->col($s+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','');
        $rep->col($data[$s]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$s]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$s]['qty'],0).' x '.$data[$s]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$s]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$s]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$s]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$s]['bal']),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$s]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$s]['cardtype'].'<br/>'.$data[$s]['acctname'].'<br/>'.$data[$s]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$s]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $stotalamt=$stotalamt+$data[$s]['ext'];
    $rep->endrow();
    }
    }

}
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',120,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',10,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('TOTAL SALES :',50,null,false,'1px solid ','','C','Verdana','11','B','','8px');
        $rep->col(number_format($stotalamt,2),30,null,false,'1px solid ','B','R','Verdana','9','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();

    $rep->endtable();
}    
$rep->begintable('1000');
// here try open
$sumrtotalamt=0;
for($r=0;$r<count($data);$r++){
    if ($data[$r]['grp']=='returns'){
        $rep->startrow();
        $sumrtotalamt=$sumrtotalamt+$data[$r]['qty'];
    $rep->endrow();
    }
}
//here try close

       
echo '<br/>';    
    $rep->startrow();
 if ($sumrtotalamt > 0){   
        $rep->col('RETURNS',NULL,null,false,'1px solid ','','C','Verdana','11','B','','');
  
    $rep->endrow();
$rep->endtable(); 

$rep->begintable('1000');

    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('RETURN #',50,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('PLU',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('QTY SOLD X DESCRIPTION',120,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('SRP',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('DISCOUNT',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('TOTAL<br/>AMOUNT',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('QTY<br/>BALANCE',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('REMARKS',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('CREDIT CARD',60,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('ENCODED<br/>DATE',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
    $rep->endrow();
    $rtotalamt=0;
for($r=0;$r<count($data);$r++){
    if ($data[$r]['grp']=='returns'){
        $rep->startrow();
        if($data[$r]['bal']==0){
        $rep->col($r+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$r]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$r]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$r]['qty'],0).' x '.$data[$r]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$r]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$r]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','red','2px');
        $rep->col(number_format($data[$r]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$r]['bal']),30,null,false,'1px solid ','B','R','Verdana','9','','red','2px');
        $rep->col($data[$r]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$r]['cardtype'].'<br/>'.$data[$r]['acctname'].'<br/>'.$data[$r]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$r]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rtotalamt=$rtotalamt+$data[$r]['ext'];
    $rep->endrow();
    } else {
        $rep->col($r+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$r]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$r]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$r]['qty'],0).' x '.$data[$r]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$r]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$r]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$r]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$r]['bal']),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$r]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$r]['cardtype'].'<br/>'.$data[$r]['acctname'].'<br/>'.$data[$r]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$r]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rtotalamt=$rtotalamt+$data[$r]['ext'];
    $rep->endrow();
    }
}
}
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',120,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',10,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('TOTAL RET. :',50,null,false,'1px solid ','','R','Verdana','11','B','','8px');
        $rep->col(number_format($rtotalamt,2),30,null,false,'1px solid ','B','R','Verdana','9','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();
    $rep->endtable();    

 }
   $rep->startrow();
   $grandtotal=0; 
   $grandtotal=$grandtotal+$stotalamt;
   $rep->endrow();
    
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',120,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',10,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('DAILY SALES <br/>TOTAL :',50,null,false,'1px solid ','','R','Verdana','11','B','','8px');
        $rep->col(number_format($grandtotal,2),30,null,false,'1px solid ','B','R','Verdana','9','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();
   
    $rep->begintable('1000'); 
    echo '<br/>'; 
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('MODE OF PAYMENT',120,null,false,'1px solid ','B','C','Verdana','11','B','','');
        $rep->col('AMOUNT',50,null,false,'1px solid ','B','C','Verdana','11','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','R','Verdana','11','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();
    //var_dump($data1);
    $totalmode=0;
    for($g=0;$g<count($data1);$g++){
        $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col(strtoupper($data1[$g]['pmode']),120,null,false,'1px solid ','LRTB','C','Verdana','11','B','','8px');
        $rep->col(number_format($data1[$g]['ext'],2),50,null,false,'1px solid ','LRTB','R','Verdana','11','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','R','Verdana','11','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $totalmode = $totalmode + $data1[$g]['ext'];
 
   $rep->endrow();
        
    }
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('TOTAL AMOUNT',120,null,false,'1px solid ','LRTB','R','Verdana','11','B','','');
        $rep->col(number_format($totalmode,2),50,null,false,'1px solid ','LRTB','R','Verdana','11','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','R','Verdana','11','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();
//    
 $rep->endtable();    
    //$rep->printline();
$rep->endtable();
//$rep->printline();
$rep->endreport();

//var_dump($params);
//var_dump($data);

?>