<?php
try {
date_default_timezone_set('Asia/Manila');
$this->title = 'Partial Served Job Order';
//WTODO: [KIM][2019.10.03][partial served job order layout]

?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

$count=55;
$page=55;
Yii::$app->reporter->beginreport('1000');
$start=$params['start'];
$end=$params['end'];
  Yii::$app->reporter->begintable('1000');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('PARTIAL SERVED JOB ORDER',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(); 
      Yii::$app->reporter->col(''.$start.' - '.$end,null,null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        if($params['client']==''){
          Yii::$app->reporter->col('Customer : ALL',null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');
        }else {
          Yii::$app->reporter->col('Customer :'. $params['client'],null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');    
        }
       
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
      Yii::$app->reporter->endtable();
      Yii::$app->reporter->printline();


    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('JO Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('JO No','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Code','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Customer Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Item Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Qty','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Req Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Comments','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

      $docno="";
      $totalbal=0;

      for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();

        if (strtoupper($docno)==strtoupper($data[$i]['docno'])){
            $docno="";  
        }else {
            $docno=strtoupper($data[$i]['docno']);  
        }
        
        $qry = "select head.docno,stock.isqty,left(head.dateid,10) as dateid from lahead as head
        left join lastock as stock on stock.trno = head.trno
        where head.doc = 'SJ' and isfromjo = 1 and stock.refx = ".$data[$i]['trno']."
        UNION ALL
        select head.docno,stock.isqty,left(head.dateid,10) as sjdocno from glhead as head
        left join glstock as stock on stock.trno = head.trno
        where head.doc = 'SJ' and isfromjo = 1 and stock.refx = " . $data[$i]['trno'];
        
        $linktrans=Yii::$app->sbccommon->opentable($qry);


        if(!empty($linktrans)){
          $balance=$data[$i]['iss'];
          if ($balance==0){ $balance='-';}
          Yii::$app->reporter->startrow();
          Yii::$app->reporter->col($data[$i]['dateid'],'80',null,false,'1px solid ','','C','Century Gothic','10','B','','');
          Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Century Gothic','10','B','','');
          Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','L','Century Gothic','10','B','','');
          Yii::$app->reporter->col($data[$i]['clientname'],'230',null,false,'1px solid ','','L','Century Gothic','10','B','','');
          Yii::$app->reporter->col($data[$i]['itemname'],'230',null,false,'1px solid ','','L','Century Gothic','10','B','','');
          Yii::$app->reporter->col(number_format($data[$i]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','C','Century Gothic','10','B','','');
          Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','10','B','','');
          Yii::$app->reporter->col($data[$i]['reqdate'],'80',null,false,'1px solid ','','C','Century Gothic','10','B','','');
          Yii::$app->reporter->col($data[$i]['rem'],'80',null,false,'1px solid ','','L','Century Gothic','10','B','','');
          Yii::$app->reporter->endrow();

          //WTODO: [KIM][2019.11.28][update formula for balance]
          foreach ($linktrans as $key => $value) {
            Yii::$app->reporter->startrow();
            $balance = $balance - $value['isqty'];
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col($value['docno'],'230',null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col($value['dateid'],'80',null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col(number_format($value['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col(number_format($balance,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'70',null,false,'1px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','130',null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Century Gothic','10','','','');
            $docno=strtoupper($data[$i]['docno']);
            Yii::$app->reporter->endrow();

          }//end for each
        }//end if

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();
   Yii::$app->reporter->begintable('1000');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('PARTIAL SERVED JOB ORDER',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(); 
      Yii::$app->reporter->col(''.$start.' - '.$end,null,null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        if($params['client']==''){
          Yii::$app->reporter->col('Customer : ALL',null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');
        }else {
          Yii::$app->reporter->col('Customer :'. $params['client'],null,null,false,'1px solid ','','L','Century Gothic','12','B','30px','5px');    
        }
       
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
      Yii::$app->reporter->endtable();

    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('JO Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('JO No','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Code','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Customer Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Item Name','230',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Order Qty','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Unit','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Req Date','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('Comments','80',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
      $page=$page + $count;
    } 
    

  }//END FOR LOOKP


Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

  
} catch (ErrorException $e) {
  echo $e;
}

?>