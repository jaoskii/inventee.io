<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
echo '<div style="margin-top:-10px;letter-spacing: 5px;">';
$count=60;
$page=58;
Yii::$app->reporter->beginreport('920');

            Yii::$app->reporter->begintable('920');
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('NEW TIANLE ASIA CORPORATION','600',null,false,'1px solid ','','L','Elephant','13','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Bodoni MT Black','9','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
                Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->begintable('920');
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DELIVERY RECEIPT','600',null,false,'1px solid ','','L','Elephant','12','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
                Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();


            Yii::$app->reporter->begintable('920');
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col('','450',null,false,'1px solid ','','L','Century Gothic','18','B','','');
                    Yii::$app->reporter->col('No :','50',null,false,'1px solid ','','L','Verdana','9','','','');
                    Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'170',null,false,'1px solid ','','L','Verdana','9','B','','').'<br />';
                Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('920');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Delivered to : ','160',null,false,'1px solid ','','L','Arial','10','','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'500',null,false,'1px solid ','','L','Verdana','10','B','30px','4px');
            Yii::$app->reporter->col('Date : ','80',null,false,'1px solid ','','L','Arial','10','','','');
            Yii::$app->reporter->col(date_format(date_create($data[0]['dateid']),"F j, Y"),'250',null,false,'1px solid ','','L','Verdana','10','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('920');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('TIN : ','100',null,false,'1px solid ','','L','Arial','10','','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'200',null,false,'1px solid ','','L','Verdana','10','B','30px','2px');
            Yii::$app->reporter->col('Tel : ','100',null,false,'1px solid ','','L','Arial','10','','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['tel'])? $data[0]['tel']:''),'150',null,false,'1px solid ','','L','Verdana','10','B','30px','2px');
            Yii::$app->reporter->col('Terms : ','80',null,false,'1px solid ','','L','Arial','10','','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'200',null,false,'1px solid ','','l','Verdana','10','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('920');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Address : ','100',null,false,'1px solid ','','L','Arial','10','','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'720',null,false,'1px solid ','','L','Verdana','10','B','30px','5px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('920');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','C','Verdana','10','B','','');
            Yii::$app->reporter->col('UOM','50',null,false,'1px solid ','TB','C','Verdana','10','B','30px','5px');
            Yii::$app->reporter->col('DESCRIPTION','300',null,false,'1px solid ','TB','C','Verdana','10','B','30px','5px');
            Yii::$app->reporter->col('PACKAGING','200',null,false,'1px solid ','TB','C','Verdana','10','B','30px','5px');
            Yii::$app->reporter->col('PRICE','100',null,false,'1px solid ','TB','C','Verdana','10','B','30px','5px');
            Yii::$app->reporter->col('DISCOUNT','100',null,false,'1px solid ','TB','C','Verdana','10','B','30px','5px');
            Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','TB','C','Verdana','10','B','30px','5px');

   $totalext=0;
   $totalqty=0;
   $g=0;
   $netamt=0;
   $totalamt=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        $totalamt=$data[$i]['qty']*$data[$i]['amt'];
        Yii::$app->reporter->col(number_format($data[$i]['qty']),'50',null,false,'1px solid ','','C','Verdana','9','','','1px');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Verdana','9','','','1px');
        Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Verdana','9','','','1px');
        Yii::$app->reporter->col($data[$i]['srem'],'200',null,false,'1px solid ','','C','Verdana','9','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],2),'100',null,false,'1px solid ','','R','Verdana','9','','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->col(number_format($totalamt,2),'100',null,false,'1px solid ','','R','Verdana','9','','','1px');
        $totalext=$totalext+$totalamt;
        $totalqty=$totalqty+$data[$i]['qty'];
}   

    //GAWIN FUNCTION 
    $dstring = explode('/', $data[0]['disc']);
    $loop = 0;
    foreach ($dstring as $key => $value) {
         if($loop == 0){
            $loop = $loop + 1;
             $discount = str_replace('%','',$dstring[$key]);
             $disc = $discount / 100;
             $g= $totalext * $disc;
             $netamt = $totalext - $g;
         }else{
             $loop = $loop + 1;
             $discount = str_replace('%','',$dstring[$key]);
             $disc = $discount / 100;
             $g= $netamt * $disc;
             $netamt = $netamt - $g;
        } // END IF LOOP
    }//END FOREACH

    Yii::$app->reporter->begintable('920');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','300',null,false,'1px solid ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','R','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','R','Century Gothic','9','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('920');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col(number_format($totalqty),'50',null,false,'1px dotted ','','C','Verdana','9','B','30px','3px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','300',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('Gross :','100',null,false,'1px dotted ','','R','Verdana','9','B','','');
    Yii::$app->reporter->col(number_format($totalext,2),'100',null,false,'1px dotted ','','R','Verdana','9','B','30px','3px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('920');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Prepared By :','180',null,false,'1px dotted ','','L','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('Approved By :','180',null,false,'1px dotted ','','L','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('Received By :','180',null,false,'1px dotted ','','L','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','90',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('Less Disc :','180',null,false,'1px dotted ','','R','Verdana','9','B','30px','');
    Yii::$app->reporter->col($data[0]['disc'],'100',null,false,'1px dotted ','','R','Verdana','9','','30px','');
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($prepared,'150',null,false,'1px dotted ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col($approved,'150',null,false,'1px dotted ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col($received,'150',null,false,'1px dotted ','B','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','9','B','','');
    Yii::$app->reporter->col('Total  :','100',null,false,'1px solid ','','R','Verdana','9','B','','');
    Yii::$app->reporter->col(number_format($netamt,2),'100',null,false,'1px solid ','TB','R','Verdana','9','B','30px','5px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    

    echo '<br/>';
    Yii::$app->reporter->begintable('920');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col(' ','200',null,false,'1px solid ','','L','Arial','10','','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','9','','','');
    Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Arial','10','','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','9','','','');
    Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Arial','10','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
echo '</div>';

?>