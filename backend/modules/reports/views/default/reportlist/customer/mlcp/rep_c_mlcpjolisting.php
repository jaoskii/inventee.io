<?php
use yii\base\ErrorException;
date_default_timezone_set('Asia/Manila');
$this->title = 'Job Order Listing';
//WTODO: [KIM][2019.11.28][job order listing layout]
//WTODO: [KIM][2019.12.04][update job order listing layout]
try {
  
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

$count=55;
$page=55;
Yii::$app->reporter->beginreport('800');

  Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER LISTING',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col($params['start'].' &nbsp - &nbsp '.$params['end'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  echo '<br/>';

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      
        Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('JO DATE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('JO NO','120',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CODE','120',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CUSTOMER NAME','210',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','B','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('PRODUCT TYPE','150',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

      $total=0;

      for($i=0;$i<count($data);$i++){

        $query = "select sum(ext) as ext from hjbstock where trno = " . $data[$i]['trno'];
        $sj = Yii::$app->sbccommon->opentable($query);
        
       


        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();

          Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['docno'],'120',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['client'],'120',null,false,'1px solid ','','C','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['clientname'],'210',null,false,'1px solid ','','L','Century Gothic','11','','','');
          if($sj[0]['ext'] == 0){
            $ext = "";
          }else{
            $ext = number_format($sj[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            
          }
          Yii::$app->reporter->col($ext,'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
          Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->col($data[$i]['fg_prodtype'],'130',null,false,'1px solid ','','L','Century Gothic','11','','','');
          Yii::$app->reporter->endrow();
          $total = $total + $sj[0]['ext'];

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();
   
   Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JOB ORDER LISTING',null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col($params['start'].' &nbsp - &nbsp '.$params['end'],null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    
  Yii::$app->reporter->endtable();
  echo '<br/>';

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      
        Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('JO DATE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('JO NO','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CUSTOMER NAME','250',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','B','L','Century Gothic','11','','','');
        Yii::$app->reporter->col('PRODUCT TYPE','150',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
       

      Yii::$app->reporter->endrow();
      $page=$page + $count;
    } 
    
  }//END FOR LOOKP


    Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Century Gothic','11','','','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Century Gothic','11','','','');
    Yii::$app->reporter->col('GRAND TOTAL :','250',null,false,'1px dotted ','T','L','Century Gothic','11','B','','');
    Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','30px','4px');
    Yii::$app->reporter->col('','20',null,false,'1px dotted ','T','L','Century Gothic','11','','','');
    Yii::$app->reporter->col('','150',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');


Yii::$app->reporter->endtable();
// Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

} catch (ErrorException $e) {
  echo $e;
}

?>