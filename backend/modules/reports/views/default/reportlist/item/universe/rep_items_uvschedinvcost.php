<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Schedule Of Inventory (Average Cost)';


?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

try {
  
$count=38;
$page=40;

Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->startrow();
    echo '<br/>';
    Yii::$app->reporter->col('SCHEDULE OF INVENTORY (Average Cost)',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    
    Yii::$app->reporter->col('BALANCE AS OF : '.$params['asof'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    
    if($params['unit'] == 'retail'){
      Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Helvetica','11','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['principalid'] == ""){
      Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    }
    Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','11','','','');
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['divisionid'] == ""){
      Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
    }
    Yii::$app->reporter->col('','350',null,false,'1px solid','','','Helvetica','11','','','');
    Yii::$app->reporter->pagenumber('Page');
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('D E S C R I P T I O N','150',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('UNIT','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('QTY','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('LATEST COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('LATEST AMOUNT','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('AVERAGE COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
    Yii::$app->reporter->col('INV COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
    

    $totalcost=0;
    $totalgcost=0;
    $totalgavecost=0;
    $totalginvcost=0;

    $avecost =0;

    for($i=0;$i<count($data);$i++){

      if($params['unit'] == 'retail'){
        $uom = ' item.uom ';
      }else{
        $uom = ' item.purchase_uom ';
      }

      if($params['wh']!=""){
        $whid = Yii::$app->sbccommon->opentable("select clientid from client where client = '".$params['wh']."'");
        $whid1 = " and rrstatus.whid = '".$whid[0]['clientid']."'";
        $wh = " and stock.wh = '".$params['wh']."'";
      }//END IF

      $qry = "select item.barcode,item.itemname,$uom as uom,
              rrstatus.docno,LEFT(rrstatus.dateid,10) AS dateid, rrstatus.expiry,rrstatus.loc,
              (rrstatus.bal / uom.factor) AS qty,uom.factor, rrstatus.disc,glstock.rrcost,rrstatus.cost FROM rrstatus 
              LEFT JOIN glstock ON glstock.trno = rrstatus.trno AND glstock.itemid = rrstatus.itemid AND glstock.line = rrstatus.line 
              LEFT JOIN item ON rrstatus.itemid = item.itemid
              LEFT JOIN uom ON uom.uom =  ".$uom." AND uom.itemid = rrstatus.itemid 
              WHERE item.isinactive <> '1' 
              AND item.barcode <> 'PA' 
              AND rrstatus.bal <> 0 
              AND rrstatus.dateid <= '".$params['asof']."'
              $whid1
              AND rrstatus.itemid = ".$data[$i]['itemid']."
              ORDER BY item.itemname,rrstatus.dateid";

      $awiter = Yii::$app->sbccommon->opentable($qry);

      $costqty = 0;
      $invcost = 0;
      $invqty = 0;
      $avecost = 0;
      $fin_invcost = 0;
      
      if(!empty($awiter)){
        foreach ($awiter as $key => $value) {
          if($data[$i]['isvat'] == 1){
            $costqty = ($value['cost'] * 1.12) * $value['factor'];
          }else{
            $costqty = ($value['cost']) * $value['factor'];
          }//end if
         
          $invcost += $costqty * $value['qty'];
          $invqty += $value['qty'];
        }//end for each

        if($invqty != 0){
          $avecost = $invcost / $invqty; 
        }//end if
      }//end if

      $fin_invcost = $avecost * $data[$i]['qty'];

      if($params['unit'] == 'retail'){
        $uom = 'item.uom';
      }else{
        $uom = 'item.purchase_uom';
      }//END IF

      /*$strRRStatus ="select stock.rrqty,stock.rrcost,stock.disc,head.doc,uom2.factor,uom.factor as vfactor,
      rrstatus.trno, rrstatus.line, rrstatus.cost,
      ifnull(rrstatus.bal,0) as bal, rrstatus.itemID, rrstatus.whID from rrstatus 
      left join client on client.clientid=rrstatus.whid 
      left join item on item.itemid=rrstatus.itemid 
      left join client as wh on wh.clientid = rrstatus.whid
      left join glhead as head on head.trno = rrstatus.trno
      left join glstock as stock on stock.trno = rrstatus.trno and stock.line = rrstatus.line 
      left join uom as uom2 on uom2.uom = stock.uom and uom2.itemid = stock.itemid
      left join uom on uom.uom = ".$uom." and uom.itemid = stock.itemid
      where item.barcode = '".$data[$i]['barcode']."' and wh.client='".$params['wh']."' 
      and rrstatus.bal<>0 order by rrstatus.encoded limit 1";

      $awiter = Yii::$app->sbccommon->opentable($strRRStatus);
      $computed = Yii::$app->backend->computestock_Internal($awiter[0]['rrcost'],$awiter[0]['disc'],floatval($awiter[0]['rrqty']),$awiter[0]['factor'],$awiter[0]['doc']);*/
      
      //echo $avecost. '---'. $data[$i]['barcode'] .'<br><br>';

      if(isset($data[$i]['cost'])){
        if($data[$i]['isvat'] == 1){
          $vatinclusive_cost = $data[$i]['cost'] * 1.12;
          $vatincl_total = $vatinclusive_cost * $data[$i]['qty'];
        }else{
          $vatinclusive_cost = $data[$i]['cost'];
          $vatincl_total = $vatinclusive_cost * $data[$i]['qty'];
        }//end if
      }else{
        if($data[$i]['isvat'] == 1){
          $vatinclusive_cost = $data[$i]['cost'] * 1.12;
          $vatincl_total = $vatinclusive_cost * $data[$i]['qty'];
        }else{
          $vatinclusive_cost = $data[$i]['cost'];
          $vatincl_total = $vatinclusive_cost * $data[$i]['qty'];
        }//end if
      }//end if

      Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
          Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid','','L','Helvetica','11','','','');
          Yii::$app->reporter->col($data[$i]['itemname'],'250',null,false,'1px solid','','L','Helvetica','11','','','');
          Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid','','C','Helvetica','11','','','');
          Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','C','Helvetica','11','','','');
          Yii::$app->reporter->col(number_format($vatinclusive_cost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
          Yii::$app->reporter->col(number_format($vatincl_total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
          Yii::$app->reporter->col(number_format($avecost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
          Yii::$app->reporter->col(number_format($fin_invcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');

          $totalcost= $totalcost+$vatinclusive_cost;
          $totalgcost = $totalgcost + $vatincl_total;

          $totalgavecost= $totalgavecost+$avecost;
          $totalginvcost = $totalginvcost + $fin_invcost;

      Yii::$app->reporter->endrow();

      if(Yii::$app->reporter->linecounter==$page){
        //
        Yii::$app->reporter->page_break();
        Yii::$app->reporter->begintable('800');
          $header=Yii::$app->reporter->letterhead();
          Yii::$app->reporter->startrow();
            echo '<br/>';
            Yii::$app->reporter->col('SCHEDULE OF INVENTORY (Average Cost)',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('BALANCE AS OF '.$params['asof'],'350',null,false,'1px solid','','','Helvetica','11','','','');
        
        if($params['unit'] == 'retail'){
          Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Helvetica','11','','','');
        }else{
          Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Helvetica','11','','','');
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['principalid'] == ""){
            Yii::$app->reporter->col('PRINCIPAL : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');
          }else{
            Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
          }
          Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'350',null,false,'1px solid','','','Helvetica','11','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['divisionid'] == ""){
            Yii::$app->reporter->col('DIVISION : ALL','350',null,false,'1px solid','','','Helvetica','11','','','');
          }else{
            Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'350',null,false,'1px solid','','','Helvetica','11','','','');
          }
          Yii::$app->reporter->col('','350',null,false,'1px solid','','','Helvetica','11','','','');
          Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('800');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','150',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
        Yii::$app->reporter->col('LATEST COST','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
        Yii::$app->reporter->col('LATEST AMOUNT','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col('AVERAGE COST','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
        Yii::$app->reporter->col('INV COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;

      }
    }

  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');   
  Yii::$app->reporter->startrow();

    Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid','','L','Helvetica','11','','','');
    Yii::$app->reporter->col('','250',null,false,'1px solid','','L','Helvetica','11','','','');
    Yii::$app->reporter->col('','50',null,false,'1px solid','','C','Helvetica','11','','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Helvetica','11','','','');
    Yii::$app->reporter->col(number_format($totalcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
    Yii::$app->reporter->col(number_format($totalgcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
    Yii::$app->reporter->col(number_format($totalgavecost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
    Yii::$app->reporter->col(number_format($totalginvcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
   
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();

} catch (\Exception $e) {
  echo $e;
}

?>