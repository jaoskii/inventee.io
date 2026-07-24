<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Top Performing Item';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
  Yii::$app->systemsettings->setDefaultTimeZone();
  $count=38;
  $page=40;

  Yii::$app->reporter->beginreport('1200');

  Yii::$app->reporter->begintable('1200');
  Yii::$app->reporter->letterhead();
  Yii::$app->reporter->startrow();
  echo '<br>';
  Yii::$app->reporter->col('TOP PERFORMING ITEM',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br>';
  Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br><br>';

  Yii::$app->reporter->begintable('1200');
  Yii::$app->reporter->startrow();

  Yii::$app->reporter->col('From:'.$params['start'].' to '.$params['end'],'180',null,false,'1px solid','','','Helvetica','11','','','');
      
      switch($params['typeofreport']){
        case 'report':
          Yii::$app->reporter->col('TYPE OF REPORT: SALES','160',null,false,'1px solid','','','Helvetica','11','','','');
        break;
        case 'lessreturn':
          Yii::$app->reporter->col('TYPE OF REPORT: SALES NET OF RETURN','160',null,false,'1px solid','','','Helvetica','11','','','');
        break;
        case 'return':
          Yii::$app->reporter->col('TYPE OF REPORT: RETURNS','160',null,false,'1px solid','','','Helvetica','11','','','');
        break;
      }

      if($params['principalid'] == ""){
        Yii::$app->reporter->col('PRINCIPAL: ALL','140',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('PRINCIPAL: '.$params['principalid'],'140',null,false,'1px solid','','','Helvetica','11','','','');
      }

      if($params['divisionid'] == ""){
        Yii::$app->reporter->col('DIVISION: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('DIVISION: '.$params['divisionid'],'160',null,false,'1px solid','','','Helvetica','11','','','');
      }

      if($params['class'] == ""){
        Yii::$app->reporter->col('CLASSIFICATION: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('CLASSIFICATION: '.$params['class'],'160',null,false,'1px solid','','','Helvetica','11','','','');
      }
      
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      if($params['model'] == ""){
        Yii::$app->reporter->col('GENERIC: ALL','180',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('GENERIC: '.$params['model'],'180',null,false,'1px solid','','','Helvetica','11','','','');
      }

      if($params['brand'] == ""){
        Yii::$app->reporter->col('BRAND: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('BRAND: '.$params['brand'],'160',null,false,'1px solid','','','Helvetica','11','','','');
      }

      if($params['department'] == ""){
        Yii::$app->reporter->col('DEPT.: ALL','140',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('DEPT.: '.$params['department'],'140',null,false,'1px solid','','','Helvetica','11','','','');
      }

      if($params['salestype'] == ""){
        Yii::$app->reporter->col('SALES TYPE: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('SALES TYPE: '.$params['salestype'],'160',null,false,'1px solid','','','Helvetica','11','','','');
      }
      
      if($params['trnxtype'] == ""){
        Yii::$app->reporter->col('TRNX TYPE: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('TRNX TYPE: '.$params['trnxtype'],'160',null,false,'1px solid','','','Helvetica','11','','','');
      }
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      if($params['sales_prefix'] == ""){
        Yii::$app->reporter->col('SALES PREF.: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('SALES PREF.: '.$params['sales_prefix'],'160',null,false,'1px solid','','','Helvetica','11','','','');
      }

      if($params['customer'] == ""){
        Yii::$app->reporter->col('CUSTOMER: ALL','140',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('CUSTOMER: '.$params['customername'],'140',null,false,'1px solid','','','Helvetica','11','','','');
      }
      
      if($params['agent'] == ""){
        Yii::$app->reporter->col('AGENT: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('AGENT: '.$params['agentname'],'160',null,false,'1px solid','','','Helvetica','11','','','');
      }

      if($params['viewfield'] == "sales"){
        Yii::$app->reporter->col('OPTION: AMOUNT','160',null,false,'1px solid','','','Helvetica','11','','','');
      }else{
        Yii::$app->reporter->col('OPTION: QTY','160',null,false,'1px solid','','','Helvetica','11','','','');
      }

      
      Yii::$app->reporter->col('UOM: ' . strtoupper($params['unit']),'160',null,false,'1px solid','','','Helvetica','11','','','');
      
  Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();

  Yii::$app->reporter->begintable('1200');
  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('RANK','60',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
  Yii::$app->reporter->col('BARCODE','200',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
  
  switch($params['typeofreport']){
    case 'report':
      Yii::$app->reporter->col('ITEMNAME','660',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('SALES QTY','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('SALES AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
    break;

    case 'lessreturn':
      Yii::$app->reporter->col('ITEMNAME','400',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('SALES QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('SALES AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('RETURN QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('RETURN AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('NET QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('NET AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
    break;

    case 'return':
      Yii::$app->reporter->col('ITEMNAME','660',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('RETURN QTY','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('RETURN AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
    break;
  }
  
  /* Yii::$app->reporter->col('V A L U E','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');

  if ($params["viewfield"] == "sales") {
  Yii::$app->reporter->col('QTY','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  } else {
  Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
  } */

  Yii::$app->reporter->endrow();

  $grandtotal = 0;
  $sales = [
    'qty' => 0,
    'amt' => 0
  ];

  $return = [
    'qty' => 0,
    'amt' => 0
  ];

  $net = [
    'qty' => 0,
    'amt' => 0
  ];

  for ($i=0; $i < count($data); $i++){ 
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['rank'],'60',null,false,'1px solid','','C','Helvetica','11','','','8px');
    Yii::$app->reporter->col($data[$i]['barcode'],'200',null,false,'1px solid','','L','Helvetica','11','','','8px');
   
    if($params['unit'] == 'retail'){
      $uom = " item.uom ";
    }
    else{
      $uom = " item.purchase_uom ";
    }

    $sub_filter = '';

    if($params['classid'] != ""){
      $sub_filter .= " and item.class = ".$params['classid']." ";
    }//end if

    if($params['principalid'] != ""){
      $sub_filter .= " and item.uv_principal = ".$params['stockprincipalid']." ";
    }//end if

    if($params['divisionid'] != ""){
      $sub_filter .= " and item.groupid = ".$params['stockdivisionid']." ";
    }//end if

    if($params['brand'] != ""){
      $sub_filter .= " and item.brand = '".$params['brand']."' ";
    }//end if

    if($params['modelid'] != ""){
      $sub_filter .= " and item.model = ".$params['modelid']." ";
    }//end if

    if($params['customer'] != ""){
      $sub_filter .= " and cust.client = '".$params['customer']."' ";
    }//end if

    if($params['agent'] != ""){
      $sub_filter .= " and ag.client = '".$params['agent']."' ";
    }//end if

    if($params['partid'] != ""){
      $sub_filter .= " and item.part = '".$params['partid']."' ";
    }//end if

    if($params['sales_prefix'] != ""){
      $sub_filter .= " and num.bref = '".$params['sales_prefix']."' ";
    }//end if

    if($params['department'] != ""){
      $sub_filter .= " and item.uv_department = '".$params['department']."' ";
    }//end if

     switch (strtolower($params['salestype'])) {
      case 'Cash':
        $sub_filter .= " and head.salestype='CASH' ";
      break;
      
      case 'Charge':
        $sub_filter .= " and head.salestype='CHARGE' ";
      break;

      case 'Check':
        $sub_filter .= " and head.salestype='CHECK' ";
      break;

      case 'Deposit':
        $sub_filter .= " and head.salestype='DEPOSIT' ";
      break;
    }//end switch

    switch (strtolower($params['trnxtype'])) {
      case 'regular':
        $sub_filter .= " and head.uv_transtype='Regular' ";
      break;
      
      case 'pwd':
        $sub_filter .= " and head.uv_transtype='P.W.D.' ";
      break;

      case 'senior':
        $sub_filter .= " and head.uv_transtype='Senior' ";
      break;

      case 'diplomat':
        $sub_filter .= " and head.uv_transtype='Diplomat' ";
      break;
    }//end switch

    $salesqry = "select sum(qty_out) as qty_out, sum(qty_amt) as qty_amt from (
                select ifnull(sum(stock.iss / case when item.purchase_uom = '' then 1 else uom.factor end),0) as qty_out, 
                ifnull(sum(stock.ext),0) as qty_amt from lahead as head
                left join lastock as stock on stock.trno = head.trno 
                left join cntnum as num on num.trno = head.trno
                left join item on item.barcode = stock.barcode
                left join client as cust on cust.client = head.client
                left join client as ag on ag.client = head.agent
                left join uom on uom.uom = $uom and uom.itemid = item.itemid
                where head.doc = 'SJ'
                and item.barcode = '".$data[$i]['barcode']."'
                and head.dateid between '".$params['start']."' and '".$params['end']."' ".$sub_filter."
                UNION ALL
                select ifnull(sum(stock.iss / case when item.purchase_uom = '' then 1 else uom.factor end),0) as qty_out, ifnull(sum(stock.ext),0) as qty_amt from glhead as head
                left join glstock as stock on stock.trno = head.trno 
                left join cntnum as num on num.trno = head.trno
                left join item on item.itemid = stock.itemid
                left join client as cust on cust.clientid = head.clientid
                left join client as ag on ag.clientid = head.agentid
                left join uom on uom.uom = $uom and uom.itemid = item.itemid
                where head.doc = 'SJ' 
                and item.barcode = '".$data[$i]['barcode']."'
                and head.dateid between '".$params['start']."' and '".$params['end']."' ".$sub_filter."
                ) as tbl";
    
    $returnqty = "select sum(qty_in) as qty_in, sum(qty_amt) as qty_amt from (
                  select ifnull(sum(stock.qty / case when item.purchase_uom = '' then 1 else uom.factor end),0) as qty_in,
                  ifnull(sum(stock.ext),0) as qty_amt from lahead as head
                  left join lastock as stock on stock.trno = head.trno 
                  left join cntnum as num on num.trno = head.trno
                  left join item on item.barcode = stock.barcode
                  left join client as cust on cust.client = head.client
                  left join client as ag on ag.client = head.agent
                  left join uom on uom.uom = $uom and uom.itemid = item.itemid
                  where head.doc = 'CM'
                  and item.barcode = '".$data[$i]['barcode']."'
                  and head.dateid between '".$params['start']."' and '".$params['end']."' ".$sub_filter."
                  UNION ALL
                  select ifnull(sum(stock.qty / case when item.purchase_uom = '' then 1 else uom.factor end),0) as qty_in,
                  ifnull(sum(stock.ext),0) as qty_amt from glhead as head
                  left join glstock as stock on stock.trno = head.trno 
                  left join cntnum as num on num.trno = head.trno
                  left join item on item.itemid = stock.itemid
                  left join client as cust on cust.clientid = head.clientid
                  left join client as ag on ag.clientid = head.agentid
                  left join uom on uom.uom = $uom and uom.itemid = item.itemid
                  where head.doc = 'CM' 
                  and item.barcode = '".$data[$i]['barcode']."'
                  and head.dateid between '".$params['start']."' and '".$params['end']."' ".$sub_filter."
                  ) as tbl";

    switch($params['typeofreport']){
      case 'report':
        Yii::$app->reporter->col($data[$i]['itemname'],'660',null,false,'1px solid','','L','Helvetica','11','','','8px');

        $sales_vals = Yii::$app->sbccommon->opentable($salesqry);
        Yii::$app->reporter->col(number_format($sales_vals[0]['qty_out'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
        Yii::$app->reporter->col(number_format($sales_vals[0]['qty_amt'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
        $sales['qty'] += $sales_vals[0]['qty_out'];
        $sales['amt'] += $sales_vals[0]['qty_amt'];
      break;
      case 'lessreturn':
        Yii::$app->reporter->col($data[$i]['itemname'],'400',null,false,'1px solid','','L','Helvetica','11','','','8px');

        $sales_vals = Yii::$app->sbccommon->opentable($salesqry);
        $return_vals = Yii::$app->sbccommon->opentable($returnqty);

        Yii::$app->reporter->col(number_format($sales_vals[0]['qty_out'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
        Yii::$app->reporter->col(number_format($sales_vals[0]['qty_amt'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
        Yii::$app->reporter->col(number_format($return_vals[0]['qty_in'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
        Yii::$app->reporter->col(number_format($return_vals[0]['qty_amt'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
        
        $netcomp_qty = floatval($sales_vals[0]['qty_out']) - floatval($return_vals[0]['qty_in']);
        $netcomp_amt = floatval($sales_vals[0]['qty_amt']) - floatval($return_vals[0]['qty_amt']);

        Yii::$app->reporter->col(number_format($netcomp_qty,2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
        Yii::$app->reporter->col(number_format($netcomp_amt,2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');

        $sales['qty'] += $sales_vals[0]['qty_out'];
        $sales['amt'] += $sales_vals[0]['qty_amt'];
        $return['qty'] += $return_vals[0]['qty_in'];
        $return['amt'] += $return_vals[0]['qty_amt'];
        $net['qty'] += $netcomp_qty;
        $net['amt'] += $netcomp_amt;
      break;
      case 'return':
        Yii::$app->reporter->col($data[$i]['itemname'],'660',null,false,'1px solid','','L','Helvetica','11','','','8px');
        $return_vals = Yii::$app->sbccommon->opentable($returnqty);
        Yii::$app->reporter->col(number_format($return_vals[0]['qty_in'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
        Yii::$app->reporter->col(number_format($return_vals[0]['qty_amt'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
        $return['qty'] += $return_vals[0]['qty_in'];
        $return['amt'] += $return_vals[0]['qty_amt'];
      break;
    }

    /* Yii::$app->reporter->col(number_format($data[$i]['sales'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
    Yii::$app->reporter->col(number_format($data[$i]['qty'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px'); */

    Yii::$app->reporter->endrow();
    //$grandtotal += $data[$i]['sales'];
  }//end for each
    
  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('','60',null,false,'1px solid','T','C','Helvetica','11','B','','8px');
  Yii::$app->reporter->col('','200',null,false,'1px solid','T','L','Helvetica','11','B','','8px');

  switch($params['typeofreport']){
    case 'report':
      Yii::$app->reporter->col('GRANDTOTAL:','660',null,false,'1px solid','T','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($sales['qty'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($sales['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
    break;
    case 'lessreturn':
      Yii::$app->reporter->col('GRANDTOTAL:','400',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($sales['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($sales['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($return['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($return['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($net['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($net['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
    break;
    case 'return':
      Yii::$app->reporter->col('GRANDTOTAL:','660',null,false,'1px solid','T','L','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($return['qty'],2),'180',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      Yii::$app->reporter->col(number_format($return['amt'],2),'180',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
    break;
  }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->endtable();
  Yii::$app->reporter->endreport();
?>