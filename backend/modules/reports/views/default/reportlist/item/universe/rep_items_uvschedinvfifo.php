<?php
use yii\base\ErrorException;
Yii::$app->systemsettings->fixMemoryBandError();
date_default_timezone_set('Asia/Manila');

try {
$this->title = 'Schedule Of Inventory (FIFO)';

//WTODO: [KIM][2019.11.07][schedule of inventory (FIFO)]
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
    Yii::$app->reporter->col('SCHEDULE OF INVENTORY (FIFO)',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
  Yii::$app->reporter->startrow();
    
    Yii::$app->reporter->col('BALANCE AS OF : '.$params['asof'],'450',null,false,'1px solid','','','Helvetica','11','','','');
    
    if($params['unit'] == 'retail'){
      Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Helvetica','11','','','');
    }
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['principalid'] == ""){
      Yii::$app->reporter->col('PRINCIPAL : ALL','450',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'450',null,false,'1px solid','','','Helvetica','11','','','');
    }
    Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'450',null,false,'1px solid','','','Helvetica','11','','','');
  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
    if($params['divisionid'] == ""){
      Yii::$app->reporter->col('DIVISION : ALL','450',null,false,'1px solid','','','Helvetica','11','','','');
    }else{
      Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'450',null,false,'1px solid','','','Helvetica','11','','','');
    }
    Yii::$app->reporter->col('','450',null,false,'1px solid','','','Helvetica','11','','','');
    Yii::$app->reporter->pagenumber('Page');
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1000');
  Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('BARCODE','120',null,false,'1px solid','B','C','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid','B','C','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('UNIT','80',null,false,'1px solid','B','C','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('DOC NO','100',null,false,'1px solid','B','C','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('DATE','75',null,false,'1px solid','B','C','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('EXPIRY','75',null,false,'1px solid','B','C','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('QUANTITY','100',null,false,'1px solid','B','R','Helvetica','11','B','','4px');
    Yii::$app->reporter->col('INV COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','4px');

    $totalcost=0;

    $name ="";
    $code="";
    $subtotal = 0;
    $subqty = 0;
    $iitem ="";

    for($i=0;$i<count($data);$i++){
      $display = $data[$i]['itemname'];
      //$rrcostcomputed = Yii::$app->sbccommon->Discount($data[$i]['rrcost'] / $data[$i]['factor'],$data[$i]['disc']);
      if($data[$i]['isvat'] == 1){
        $costqty = ($data[$i]['cost'] * 1.12) * $data[$i]['factor'];
      }else{
        $costqty = ($data[$i]['cost']) * $data[$i]['factor'];
      }//end if
      $invcost = $costqty * $data[$i]['qty'];

      if ($name==""){
        Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'120',null,false,'1px solid','','L','Helvetica','11','B','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'250',null,false,'1px solid','','L','Helvetica','11','B','','');
        Yii::$app->reporter->col($data[$i]['uom'],'80',null,false,'1px solid','','C','Helvetica','11','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Helvetica','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid','','R','Helvetica','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid','','R','Helvetica','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid','','R','Helvetica','11','','','');
        Yii::$app->reporter->endrow();
      }//end if
      
      if (strtoupper($name)==strtoupper($data[$i]['itemname'])){
        $name="";    
      }else {
        if($name!=''){  
          Yii::$app->reporter->startrow();
          Yii::$app->reporter->col('','120',null,false,'1px solid','','L','Helvetica','11','','','');
          Yii::$app->reporter->col('','250',null,false,'1px solid','','L','Helvetica','11','','','');
          Yii::$app->reporter->col('','80',null,false,'1px solid','','C','Helvetica','11','','','');
          Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Helvetica','11','','','');
          Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
          Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
          Yii::$app->reporter->col('SUB-TOTAL :','100',null,false,'1px solid','','R','Helvetica','11','B','','');
          Yii::$app->reporter->col(number_format($subqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted','T','R','Helvetica','11','b','','');
          Yii::$app->reporter->col(number_format($subtotal,Yii::$app->systemsettings->setDecimaldisplay('unitprice')),'100',null,false,'1px dotted','T','R','Helvetica','11','b','','');
          Yii::$app->reporter->endrow();
        }//end if    

        if ($name!=''){     
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['barcode'],'120',null,false,'1px solid','','L','Helvetica','11','B','','');
            Yii::$app->reporter->col($data[$i]['itemname'],'250',null,false,'1px solid','','L','Helvetica','11','B','','');
            Yii::$app->reporter->col($data[$i]['uom'],'80',null,false,'1px solid','','C','Helvetica','11','B','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Helvetica','11','','','');
            Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
            Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid','','R','Helvetica','11','','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid','','R','Helvetica','11','','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid','','R','Helvetica','11','','','');

        }  
        $subtotal=0;
        $subqty=0;
        $code=$data[$i]['itemname'];
        
        if (strtoupper($code)==strtoupper($data[$i]['itemname'])){
          $code="";  
        } else 
        {
          $code=strtoupper($data[$i]['itemname']);  
        }
      }
                      
      if ($iitem==$data[$i]['itemname']){
        $iitem="";
      }else{
        $iitem=$data[$i]['itemname'];
      }//end if


      Yii::$app->reporter->startrow();
      Yii::$app->reporter->addline();
      Yii::$app->reporter->col('','120',null,false,'1px solid','','L','Helvetica','11','','','');
      Yii::$app->reporter->col('','250',null,false,'1px solid','','L','Helvetica','11','','','');
      Yii::$app->reporter->col('','80',null,false,'1px solid','','C','Helvetica','11','','','');
      Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid','','L','Helvetica','11','','','');
      Yii::$app->reporter->col($data[$i]['dateid'],'75',null,false,'1px solid','','C','Helvetica','11','','','');
      Yii::$app->reporter->col($data[$i]['expiry'],'75',null,false,'1px solid','','C','Helvetica','11','','','');
      Yii::$app->reporter->col(number_format($costqty,Yii::$app->systemsettings->setDecimaldisplay('unitprice')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
      Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid','','R','Helvetica','11','','','');
      Yii::$app->reporter->col(number_format($invcost,Yii::$app->systemsettings->setDecimaldisplay('unitprice')),'100',null,false,'1px solid','','R','Helvetica','11','','','');

      $totalcost=$totalcost+$invcost;

      $subtotal=$subtotal+$invcost;
      $subqty=$subqty+$data[$i]['qty'];
      $name=strtoupper($data[$i]['itemname']);
      $code=$data[$i]['itemname'];
      $iitem=$data[$i]['itemname'];

      Yii::$app->reporter->endrow();

      if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->page_break();
        Yii::$app->reporter->begintable('1000');
        $header=Yii::$app->reporter->letterhead();
        Yii::$app->reporter->startrow();
        echo '<br/>';
        Yii::$app->reporter->col('SCHEDULE OF INVENTORY (FIFO)',null,null,false,'1px solid','','C','Helvetica','18','B','','').'<br/>';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('BALANCE AS OF '.$params['asof'],'450',null,false,'1px solid','','','Helvetica','11','','','');
        if($params['unit'] == 'retail'){
          Yii::$app->reporter->col('Unit : RETAIL','350',null,false,'1px solid','','','Helvetica','11','','','');
        }else{
          Yii::$app->reporter->col('Unit : PURCHASING','350',null,false,'1px solid','','','Helvetica','11','','','');
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['principalid'] == ""){
            Yii::$app->reporter->col('PRINCIPAL : ALL','450',null,false,'1px solid','','','Helvetica','11','','','');
          }else{
            Yii::$app->reporter->col('PRINCIPAL :'.$params['principalid'],'450',null,false,'1px solid','','','Helvetica','11','','','');
          }
          Yii::$app->reporter->col('WAREHOUSE : '.$params['wh'],'450',null,false,'1px solid','','','Helvetica','11','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
          if($params['divisionid'] == ""){
            Yii::$app->reporter->col('DIVISION : ALL','450',null,false,'1px solid','','','Helvetica','11','','','');
          }else{
            Yii::$app->reporter->col('DIVISION :'.$params['divisionid'],'450',null,false,'1px solid','','','Helvetica','11','','','');
          }
          Yii::$app->reporter->col('','450',null,false,'1px solid','','','Helvetica','11','','','');
          Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('1000');
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','120',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('DESCRIPTION','250',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('UNIT','80',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('DOC NO','100',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('DATE','75',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('EXPIRY','75',null,false,'1px solid','B','C','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('QUANTITY','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
            Yii::$app->reporter->col('INV COST','100',null,false,'1px solid','B','R','Helvetica','11','B','','8px');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;

      }
    }

  Yii::$app->reporter->endrow();

  Yii::$app->reporter->startrow();
  Yii::$app->reporter->col('','120',null,false,'1px solid','','L','Helvetica','11','','','');
  Yii::$app->reporter->col('','250',null,false,'1px solid','','L','Helvetica','11','','','');
  Yii::$app->reporter->col('','80',null,false,'1px solid','','C','Helvetica','11','','','');
  Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Helvetica','11','','','');
  Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
  Yii::$app->reporter->col('','75',null,false,'1px solid','','C','Helvetica','11','','','');
  Yii::$app->reporter->col('SUB-TOTAL :','100',null,false,'1px solid','','R','Helvetica','11','B','','');
  Yii::$app->reporter->col(number_format($subqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted','T','R','Helvetica','11','b','','');
  Yii::$app->reporter->col(number_format($subtotal,Yii::$app->systemsettings->setDecimaldisplay('unitprice')),'100',null,false,'1px dotted','T','R','Helvetica','11','b','','');
  Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1000');   
  Yii::$app->reporter->startrow();

    Yii::$app->reporter->col('GRAND TOTAL','100',null,false,'1px solid ','','L','Helvetica','11','B','','');
    Yii::$app->reporter->col('','400',null,false,'1px solid ','','R','Helvetica','11','','','');
    Yii::$app->reporter->col('','400',null,false,'1px solid ','','R','Helvetica','11','','','');
    Yii::$app->reporter->col(number_format($totalcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','B','','');
   
  Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();

} catch (ErrorException $e) {
  echo $e;
}
?>