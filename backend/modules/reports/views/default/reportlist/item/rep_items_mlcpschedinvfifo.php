<?php
Yii::$app->systemsettings->fixMemoryBandError();
date_default_timezone_set('Asia/Manila');
$this->title = 'Schedule Of Inventory (FIFO)';
//WTODO: [KIM][2019.10.03][layout for schedule of inventory fifo for mlcp]
//WTODO: [KIM][2019.11.13][update layout for schedule of inventory fifo]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;

Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->startrow();
    echo '<br/>';
    Yii::$app->reporter->col('SCHEDULE OF INVENTORY (FIFO)',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
  Yii::$app->reporter->startrow();
    
    Yii::$app->reporter->col('BALANCE AS OF : '.$params['asof'],'1000',null,false,'1px solid','','','Century Gothic','11','','','');
    
  Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Warehouse : '.$params['wh'],null,null,false,'1px solid ','','L','Century Gothic','11','','','');
       
        Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1000');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('CLASS','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('UNIT','50',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('DOC NO','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('DATE','50',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('LOCATION','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('BAL PER ITEM','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
    Yii::$app->reporter->col('INV COST','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');

    $totalcost=0;
    $barcode = '';
    $balperitem = 0;
    $invcostperitem = 0;
    for($i=0;$i<count($data);$i++){
      $invcost = $data[$i]['cost'] * $data[$i]['qty'];
      if($barcode != $data[$i]['barcode']){
        if($barcode != ''){
          Yii::$app->reporter->startrow();
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col('&nbsp','200',null,false,'1px','B','L','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col('&nbsp','50',null,false,'1px','B','C','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col('&nbsp','50',null,false,'1px','B','C','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','R','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col(number_format($balperitem,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid','T','R','Century Gothic','11','B','','8px');
          Yii::$app->reporter->col(number_format($invcostperitem,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','T','R','Century Gothic','11','B','','8px');
          Yii::$app->reporter->endrow();
          $balperitem = 0;
          $invcostperitem = 0;
        }//end if

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('&nbsp','50',null,false,'1px','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('&nbsp','50',null,false,'1px','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
      }//end if

      Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['classname'],'100',null,false,'1px solid','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['dateid'],'50',null,false,'1px solid','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['loc'],'100',null,false,'1px solid','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col(number_format($invcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Century Gothic','11','','','');

          $totalcost=$totalcost+$invcost;
          $invcostperitem=$invcostperitem+$invcost;
          $balperitem=$balperitem+$data[$i]['qty'];

      Yii::$app->reporter->endrow();
      $barcode = $data[$i]['barcode'];

      if(Yii::$app->reporter->linecounter==$page){
        //
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('1000');
          $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->startrow();
            echo '<br/>';
            Yii::$app->reporter->col('SCHEDULE OF INVENTORY (FIFO)',null,null,false,'1px solid','','C','Century Gothic','18','B','','').'<br/>';
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
    
    Yii::$app->reporter->col('BALANCE AS OF : '.$params['asof'],'1000',null,false,'1px solid','','','Century Gothic','11','','','');
    
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'1000',null,false,'1px solid','','','Century Gothic','11','','','');
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['class']==''){
        Yii::$app->reporter->col('Classification : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
    }else {
      Yii::$app->reporter->col('Classification :'. $params['class'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
    }
    Yii::$app->reporter->col('','450',null,false,'1px solid','','','Century Gothic','11','','','');
    Yii::$app->reporter->pagenumber('Page');
  Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('1000');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CLASS','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('UNIT','50',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('DOC NO','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('DATE','50',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('LOCATION','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('BALANCE PER ITEM','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
            Yii::$app->reporter->col('INV COST','100',null,false,'1px solid','B','C','Century Gothic','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;

      }
    }

  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1000');   
  Yii::$app->reporter->startrow();

    Yii::$app->reporter->col('GRAND TOTAL','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
    Yii::$app->reporter->col('','400',null,false,'1px solid ','','R','Century Gothic','11','','','');
    Yii::$app->reporter->col('','400',null,false,'1px solid ','','R','Century Gothic','11','','','');
    Yii::$app->reporter->col(number_format($totalcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','B','','');
   
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();
?>