<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Receiving Report';
//WTODO: [KIM][2019.11.25][update layout for PO Service Receiving]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>


<?php

$count=35;
$page=35;

echo "<div style='letter-spacing: 5px'>";

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SERVICE RECEIVING REPORT','700',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','200',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['clientname'])?$data[0]['clientname']:''),'650',null,false,'1px solid ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('DATE : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'190',null,false,'1px solid ','B','R','Century Gothic','12','','','');
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'650',null,false,'1px solid ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('PO # : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'190',null,false,'1px solid ','B','R','Century Gothic','12','','','');
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','420',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT PRICE','125',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DISC','50',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','125',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');

        
      $totalext=0;
      for($i=0;$i<count($data);$i++){
        $ext=number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        if ($ext<1)
        {
            $ext='-';
        }
        $netamt=number_format($data[$i]['netamt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        if ($netamt<1)
        {
            $netamt='-';
        }
        
      Yii::$app->reporter->startrow();
      Yii::$app->reporter->addline();
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'80',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'420',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['netamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['disc'],'50',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($ext,'125',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        $totalext=$totalext+$data[$i]['ext'];
        
        
        
      if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();

    Yii::$app->reporter->begintable('1000');
      $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';

     Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SERVICE RECEIVING REPORT','700',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','200',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['clientname'])?$data[0]['clientname']:''),'650',null,false,'1px solid ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('DATE : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'190',null,false,'1px solid ','B','R','Century Gothic','12','','','');
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'650',null,false,'1px solid ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('PO # : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'190',null,false,'1px solid ','B','R','Century Gothic','12','','','');
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','420',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT PRICE','125',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DISC','50',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','125',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}   

        Yii::$app->reporter->startrow();

        Yii::$app->reporter->col('','50',null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','80',null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('GRAND TOTAL : ','420',null,false,'1px solid ','T','L','Century Gothic','12','B','','8px');
        Yii::$app->reporter->col('','125',null,false,'1px solid ','T','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','T','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'125',null,false,'1px solid ','T','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($data[0]['rem'],'760',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','160',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Checked By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('&nbsp','66',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'200',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('&nbsp','66',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'200',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

echo '</div>';
?>