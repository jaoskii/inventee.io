<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Daily Sales Report';
?>
<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>
<?php
$count=38;
$page=40;
$header=Yii::$app->reporter->letterhead();

//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$rep->beginreport('1000');

$rep->begintable('1000');
        $rep->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        $rep->col('DAILY SALES REPORT',null,null,false,'1px solid ','','','Verdana','18','B','B','','').'<br />';
        $rep->endrow();
        $rep->startrow(null,null,false,'1px solid ','','R','Verdana','11','','','');
        $rep->col('Center :'.$params['center'],null,null,false,'1px solid ','','L','Verdana','11','','','');
        $rep->col(date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','L','Verdana','11','','','');        
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
    $cr=0;
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
    $cr=$cr+1;
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


    $rep->begintable('1000');
        $ptotalamt=0;
for($p=0;$p<count($data);$p++){
    if ($data[$p]['grp']=='pull-out'){
        $rep->startrow();
        $ptotalamt=$ptotalamt+$data[$p]['ext'];
    $rep->endrow();
    }
}
echo '<br/>';    
    $rep->startrow();
 if ($ptotalamt > 0){       
        $rep->col('PULL-OUT',NULL,null,false,'1px solid ','','C','Verdana','11','B','','');
  
    $rep->endrow();
$rep->endtable(); 
$rep->begintable('1000');  
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('PULL-OUT #',50,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
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
$ptotalamt=0;
$cpo=0;
for($p=0;$p<count($data);$p++){
    if ($data[$p]['grp']=='pull-out'){
        $rep->startrow();
        if($data[$p]['bal']==0){
        $rep->col($p+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$p]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$p]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$p]['qty'],0).' x '.$data[$p]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$p]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$p]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$p]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$p]['bal']),30,null,false,'1px solid ','B','R','Verdana','9','','red','2px');
        $rep->col($data[$p]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$p]['cardtype'].'<br/>'.$data[$p]['acctname'].'<br/>'.$data[$p]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$p]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $ptotalamt=$ptotalamt+$data[$p]['ext'];
    $rep->endrow();
    } else {
        $rep->col($p+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$p]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$p]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$p]['qty'],0).' x '.$data[$p]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$p]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$p]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$p]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$p]['bal']),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$p]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$p]['cardtype'].'<br/>'.$data[$p]['acctname'].'<br/>'.$data[$p]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$p]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $ptotalamt=$ptotalamt+$data[$p]['ext'];
    $rep->endrow();
    }
    $cpo=$cpo+1;
}
 }  
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',120,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',10,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('TOTAL P.O :',50,null,false,'1px solid ','','C','Verdana','11','B','','');
        $rep->col(number_format($ptotalamt,2),30,null,false,'1px solid ','B','R','Verdana','9','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();
    
    $rep->endtable();    

 }   
    $rep->begintable('1000');
        $etotalamt=0;
for($e=0;$e<count($data);$e++){
    if ($data[$e]['grp']=='expense'){
    $rep->startrow();
    $etotalamt=$etotalamt+$data[$e]['ext'];
    $rep->endrow();
    }
}
echo '<br/>';    
    $rep->startrow();
 if ($etotalamt > 0){      
        $rep->col('EXPENSE',NULL,null,false,'1px solid ','','C','Verdana','11','B','','');
  
    $rep->endrow();
$rep->endtable(); 
$rep->begintable('1000');  
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('       ',50,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
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
$etotalamt=0;
$ce=0;
for($e=0;$e<count($data);$e++){
    if ($data[$e]['grp']=='expense'){
        $rep->startrow();
        if($data[$e]['bal']==0){
        $rep->col($e+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$e]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$e]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col($data[$e]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$e]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$e]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$e]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$e]['bal']),30,null,false,'1px solid ','B','R','Verdana','9','','red','2px');
        $rep->col($data[$e]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$e]['cardtype'].'<br/>'.$data[$e]['acctname'].'<br/>'.$data[$e]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$e]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $etotalamt=$etotalamt+$data[$e]['ext'];
    $rep->endrow();
    } else {
        $rep->col($e+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$e]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$e]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col($data[$e]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$e]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$e]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$e]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$e]['bal']),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$e]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$e]['cardtype'].'<br/>'.$data[$e]['acctname'].'<br/>'.$data[$e]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$e]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $etotalamt=$etotalamt+$data[$e]['ext'];
    $rep->endrow();
    }
    $ce=$ce+1;
}
 }
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',120,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',10,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('TOTAL EXP :',50,null,false,'1px solid ','','R','Verdana','11','B','','8px');
        $rep->col(number_format($etotalamt,2),30,null,false,'1px solid ','B','R','Verdana','9','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();
   
 }   
    $rep->begintable('1000');
        $ctotalamt=0;
for($c=0;$c<count($data);$c++){
    if ($data[$c]['grp']=='consignment'){
        $rep->startrow();
        $ctotalamt=$ctotalamt+$data[$c]['ext'];
    $rep->endrow();
    }
}
echo '<br/>';    
    $rep->startrow();
 if ($ctotalamt > 0){    
        $rep->col('CONSIGNMENT',NULL,null,false,'1px solid ','','C','Verdana','11','B','','10px');
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
        $rep->col('TOTAL<br/>BALANCE',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('REMARKS',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('CREDIT CARD',60,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
        $rep->col('ENCODED<br/>DATE',30,null,false,'1px solid ','LRTB','C','Verdana','11','B','','');
    $rep->endrow();
$ctotalamt=0;
$cc=0;
for($c=0;$c<count($data);$c++){
    if ($data[$c]['grp']=='consignment'){
        $rep->startrow();
        $rep->addline();
        if($data[$c]['bal']==0){
        $rep->col($c+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$c]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$c]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$c]['qty'],0).' x '.$data[$c]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$c]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$i]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$c]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$c]['bal']),30,null,false,'1px solid ','B','R','Verdana','9','','red','2px');
        $rep->col($data[$c]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$c]['cardtype'].'<br/>'.$data[$c]['acctname'].'<br/>'.$data[$c]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$c]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $ctotalamt=$ctotalamt+$data[$c]['ext'];
    $rep->endrow();
    } else {
        $rep->col($c+1,30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$c]['docno'],50,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$c]['barcode'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','','');
        $rep->col(number_format($data[$c]['qty'],0).' x '.$data[$c]['itemname'],120,null,false,'1px solid ','LRTB','L','Verdana','9','','','2px');
        $rep->col(number_format($data[$c]['amt'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$i]['disc'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col(number_format($data[$c]['ext'],2),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col(number_format($data[$c]['bal']),30,null,false,'1px solid ','LRTB','R','Verdana','9','','','2px');
        $rep->col($data[$c]['rem'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','2px');
        $rep->col($data[$c]['cardtype'].'<br/>'.$data[$c]['acctname'].'<br/>'.$data[$c]['acctno'],60,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $rep->col($data[$c]['tdate'],30,null,false,'1px solid ','LRTB','C','Verdana','9','','','');
        $ctotalamt=$ctotalamt+$data[$c]['ext'];
    $rep->endrow();
    }
    
$cc=$cc+1;
}
 }
    $rep->startrow();
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',50,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',120,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',10,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('TOTAL CONS :',50,null,false,'1px solid ','','R','Verdana','11','B','','8px');
        $rep->col(number_format($ctotalamt,2),30,null,false,'1px solid ','B','R','Verdana','9','B','','8px');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',60,null,false,'1px solid ','','C','Verdana','11','','','');
        $rep->col('',30,null,false,'1px solid ','','C','Verdana','11','','','');
    $rep->endrow();

 }
   $rep->startrow();
   $grandtotal=0; 
   $grandtotal=$grandtotal+$stotalamt+$ptotalamt-$etotalamt+$ctotalamt;
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