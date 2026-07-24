<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Stockcard Ledger Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

if(!isset($data[1])){
    echo 'No Data Found. Please double check Item Data Tabs.';
    return 0;
}//end if

$count=55;
$page=54;
Yii::$app->reporter->beginreport();

 //if (Yii::$app->backend->getcompanyid() == 1) {
    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';//}    

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('STOCKCARD LEDGER  ',null,null,false,'1px solid ','','','Avenir','18','','','').'<br />';
Yii::$app->reporter->endrow();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BARCODE :'.(isset($data[1]['barcode'])? $data[1]['barcode']:''),'200',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->col('','525',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM NAME :','75',null,false,'1px solid ','','L','Avenir','11','B','','1px');
        Yii::$app->reporter->col((isset($data[1]['itemname'])? $data[1]['itemname']:'').'','450',null,false,'1px solid ','','L','Avenir','11','B','','1px');
         Yii::$app->reporter->col('DATE RANGE: '.$params['startdate'].' TO '.$params['enddate'],'225',null,false,'1px solid ','','L','Avenir','11','B','','1px');
         Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->col('WAREHOUSE: ','75',null,false,'1px solid ','','L','Avenir','11','B','','1px');
Yii::$app->reporter->col($params['warehouse'],'200',null,false,'1px solid ','','L','Avenir','11','B','','1px');
Yii::$app->reporter->col('UOM: '.$params['uom'],'325',null,false,'1px solid ','','L','Avenir','11','B','','1px');

$sql="select factor from uom where itemid = " . $data[1]['itemid2'] . " and uom ='".$params['uom']."'";
$uomfactor=Yii::$app->sbccommon->datareader($sql);

Yii::$app->reporter->col('FACTOR: '.number_format($uomfactor,2),'200',null,false,'1px solid ','','L','Avenir','11','B','','1px');
Yii::$app->reporter->endtable();



Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();



Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('DATE','75',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('CLIENT NAME','230',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('EXPIRY','70',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('QTY IN ','75',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('QTY OUT ','75',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    Yii::$app->reporter->col('PARTICULAR','95',null,false,'1px solid ','LRTB','C','Avenir','11','B','','1px');
    
$bal=0;
$totaliss = 0;
$totalqty = 0; 
$tobal = 0;
$bal = 0;

for($i=0;$i<count($data);$i++){

    $qty=$data[$i]['qty'];
    
    if ($qty<1){
        $qty='-';
    }//end if

    $iss=$data[$i]['iss'];
    
    if ($iss==0){
        $iss='-';
    }//end if

    /*if($bal==0){
        $bal = number_format($data[$i]['bal'],2);
    }//end if*/

    //$bal=$bal+($data[$i]['qty']-$data[$i]['iss']);
    
    if($i == 0){
        $bal = $data[$i]['bal'];
    }else{
        $bal = $bal - $iss;
        $bal = $bal + $qty;
    }//end if 

    $tobal=$bal;

    if($tobal==0){
        $tobal='-';
    }else{
        $tobal = number_format($tobal,2);
    }//end if
    

    Yii::$app->reporter->startrow();
    if ($data[$i]['docno'] == 'beginning bal.'){
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','C','Avenir','11','','','');
        Yii::$app->reporter->col('','230',null,false,'1px solid ','','L','Avenir','11','','','');
        Yii::$app->reporter->col('','70',null,false,'1px solid ','','L','Avenir','11','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Avenir','11','','','');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['bal'],2),'70',null,false,'1px solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->col('','95',null,false,'1px solid ','','R','Avenir','11','','','');
    } else {
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['dateid'],'75',null,false,'1px solid ','','C','Avenir','11','','','');
        Yii::$app->reporter->col('&nbsp;'.$data[$i]['clientname'],'230',null,false,'1px solid ','','L','Avenir','11','','','');
        Yii::$app->reporter->col($data[$i]['expiry'],'70',null,false,'1px solid ','','C','Avenir','11','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Avenir','11','','','');
        Yii::$app->reporter->col($qty,'65',null,false,'1px solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->col($iss,'75',null,false,'1px solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->col($tobal,'70',null,false,'1px solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->col($data[$i]['rem'],'95',null,false,'1psx solid ','','R','Avenir','11','','','');
        Yii::$app->reporter->endrow();
    }//end if
    $totaliss = $totaliss+$iss;
    $totalqty = $totalqty+$qty;
}

Yii::$app->reporter->endtable();

 Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','75',null,false,'1px solid ','T','C','Avenir','11','','','');
    Yii::$app->reporter->col('&nbsp;','230',null,false,'1px solid ','T','L','Avenir','11','','','');
    Yii::$app->reporter->col('&nbsp;','70',null,false,'1px solid ','T','L','Avenir','11','','','');
    Yii::$app->reporter->col('TOTAL QTY : ','100',null,false,'1px solid ','T','L','Avenir','11','','','');
  
    Yii::$app->reporter->col(number_format($totalqty,2),'65',null,false,'1px solid ','T','R','Avenir','11','','','');
  
    Yii::$app->reporter->col(number_format($totaliss,2),'75',null,false,'1px solid ','T','R','Avenir','11','','','');
    Yii::$app->reporter->col($tobal,'70',null,false,'1px solid ','T','R','Avenir','11','','','');
    Yii::$app->reporter->col('&nbsp;','95',null,false,'1px solid ','T','R','Avenir','11','','','');

    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


echo '<br/><br/>';
    Yii::$app->reporter->begintable('800'); 
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Avenir','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Avenir','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Avenir','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>
