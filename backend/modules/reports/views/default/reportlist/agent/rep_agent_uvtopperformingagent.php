<?php
try {
date_default_timezone_set('Asia/Manila');
$this->title = 'Top Performing Agent';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;

Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
  Yii::$app->reporter->startrow();
    echo '<br/>';
    Yii::$app->reporter->col('TOP PERFORMING AGENT',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
    
    Yii::$app->reporter->col('From:'.$params['start'].' to '.$params['end'],'180',null,false,'1px solid','','','Helvetica','11','','','');
    
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    
    Yii::$app->reporter->col('CATEGORY:'.$params['category'],'180',null,false,'1px solid','','','Helvetica','11','','','');
    
    switch($params['salesreporttype'])
    {
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
    if($params['generic'] == ""){
      Yii::$app->reporter->col('GENERIC: ALL','180',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('GENERIC: '.$params['generic'],'180',null,false,'1px solid','','','Helvetica','11','','','');
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
   

    if($params['pref'] == ""){
      Yii::$app->reporter->col('SALES PREF.: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('SALES PREF.: '.$params['pref'],'160',null,false,'1px solid','','','Helvetica','11','','','');
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

    if($params['barcode'] == ""){
      Yii::$app->reporter->col('ITEM: ALL','160',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      /*$qry = "select itemname from item where barcode = '".$params['itemname']."'";
      $itemname =  Yii::$app->sbccommon->datareader($qry);*/
      Yii::$app->reporter->col('ITEM: '.$params['itemname'],'160',null,false,'1px solid','','','Helvetica','11','','','');
    }

    Yii::$app->reporter->col('UOM: ' . strtoupper($params['unit']),'160',null,false,'1px solid','','','Helvetica','11','','','');
    
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
  Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('RANK','60',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
      Yii::$app->reporter->col('CODE','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
      
      switch($params['salesreporttype']){
        case 'report':
          if($params['view-amt-field']){
            Yii::$app->reporter->col('NAME','360',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('SALES QTY','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('SALES AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
          }else{
            Yii::$app->reporter->col('NAME','460',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('SALES QTY','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
          }//end if
        break;

        case 'lessreturn':
          if($params['view-amt-field']){
            Yii::$app->reporter->col('NAME','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('SALES QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('SALES AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('RETURN QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('RETURN AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('NET QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('NET AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
          }else{
            Yii::$app->reporter->col('NAME','400',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('SALES QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('RETURN QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('NET QTY','80',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
          }//end if
        break;

        case 'return':
          if($params['view-amt-field']){
            Yii::$app->reporter->col('NAME','360',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('RETURN QTY','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('RETURN AMT','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
          }else{
            Yii::$app->reporter->col('NAME','460',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('RETURN QTY','100',null,false,'1px solid','B','L','Helvetica','11','B','','8px');
          }//end if
        break;
      }
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

    for ($i=0; $i < count($data); $i++) { 
      Yii::$app->reporter->startrow();
      Yii::$app->reporter->col($data[$i]['rank'],'60',null,false,'1px solid','','C','Helvetica','11','','','8px');
      Yii::$app->reporter->col($data[$i]['agcode'],'100',null,false,'1px solid','','L','Helvetica','11','','','8px');
      
      switch($params['salesreporttype']){
          case 'report':
            if($params['view-amt-field']){
              Yii::$app->reporter->col($data[$i]['agname'],'360',null,false,'1px solid','','L','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalout'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalsales'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
            }else{
              Yii::$app->reporter->col($data[$i]['agname'],'460',null,false,'1px solid','','L','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalout'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
            }//end if

            $sales['qty'] += $data[$i]['totalout'];
            $sales['amt'] += $data[$i]['totalsales'];
          break;

          case 'lessreturn':
            if($params['view-amt-field']){
              Yii::$app->reporter->col($data[$i]['agname'],'100',null,false,'1px solid','','L','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalout'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalsales'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalin'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalreturns'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalqty'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalnet'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
            }else{
              Yii::$app->reporter->col($data[$i]['agname'],'400',null,false,'1px solid','','L','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalout'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalin'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalqty'],2),'80',null,false,'1px solid','','R','Helvetica','11','','','8px');
            }//end if

            $sales['qty'] += $data[$i]['totalout'];
            $sales['amt'] += $data[$i]['totalsales'];
            $return['qty'] += $data[$i]['totalin'];
            $return['amt'] += $data[$i]['totalreturns'];
            $net['qty'] += $data[$i]['totalqty'];
            $net['amt'] += $data[$i]['totalnet'];
          break;

          case 'return':
            if($params['view-amt-field']){
              Yii::$app->reporter->col($data[$i]['agname'],'360',null,false,'1px solid','','L','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalin'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalreturns'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
            }else{
              Yii::$app->reporter->col($data[$i]['agname'],'460',null,false,'1px solid','','L','Helvetica','11','','','8px');
              Yii::$app->reporter->col(number_format($data[$i]['totalin'],2),'100',null,false,'1px solid','','R','Helvetica','11','','','8px');
            }//end if

            $return['qty'] += $data[$i]['totalin'];
            $return['amt'] += $data[$i]['totalreturns'];
          break;
        }//END SWITCH

        Yii::$app->reporter->endrow();
      //$grandtotal += $data[$i]['sales'];
    }//end for each
  
  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('','60',null,false,'1px solid','T','C','Helvetica','11','B','','8px');
  Yii::$app->reporter->col('','100',null,false,'1px solid','T','L','Helvetica','11','B','','8px');

  switch($params['salesreporttype']){
    case 'report':
      if($params['view-amt-field']){
        Yii::$app->reporter->col('GRANDTOTAL:','360',null,false,'1px solid','T','L','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($sales['qty'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($sales['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      }else{
        Yii::$app->reporter->col('GRANDTOTAL:','460',null,false,'1px solid','T','L','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($sales['qty'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      }//end if
    break;
    case 'lessreturn':
      if($params['view-amt-field']){
        Yii::$app->reporter->col('GRANDTOTAL:','100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($sales['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($sales['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($return['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($return['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($net['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($net['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      }else{
        Yii::$app->reporter->col('GRANDTOTAL:','400',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($sales['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($return['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($net['qty'],2),'80',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      }//end if
    break;
    case 'return':
      if($params['view-amt-field']){
        Yii::$app->reporter->col('GRANDTOTAL:','360',null,false,'1px solid','T','L','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($return['qty'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($return['amt'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      }else{
        Yii::$app->reporter->col('GRANDTOTAL:','460',null,false,'1px solid','T','L','Helvetica','11','B','','8px');
        Yii::$app->reporter->col(number_format($return['qty'],2),'100',null,false,'1px solid','T','R','Helvetica','11','B','','8px');
      }//end if
    break;
  }
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

  
} catch (ErrorException $e) {
  echo $e;
}
?>