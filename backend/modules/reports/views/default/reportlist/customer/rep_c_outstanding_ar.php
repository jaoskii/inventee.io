<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Customer Receivables - DETAILED';
//WTODO: [KIM][2019.12.09][layout for current customer receivables]
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
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('DETAILED CURRENT CUSTOMER RECEIVABLES',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  Yii::$app->reporter->begintable('800');
    $cus="";
    if ($params['customer']==" "){
      $cus='ALL';
    }
    
    Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','11','','','');
    
      if ($params['customer']=='') {
        Yii::$app->reporter->col('Customer : ALL','110px',null,false,'1px solid ','','L','Helvetica','11','','','');    
      }else {
        Yii::$app->reporter->col('Customer : '.strtoupper($params['customername']),'110px',null,false,'1px solid ','','L','Helvetica','11','','','');
      }
    
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','11','','','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','11','','','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','11','','','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','11','','','');
      Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Helvetica','11','','b','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','11','','b','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','11','','','');
      Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('CUSTOMER NAME','110',null,false,'1px solid ','B','C','Helvetica','11','B','','');
      Yii::$app->reporter->col('DATE','110',null,false,'1px solid ','B','C','Helvetica','11','B','','');
      Yii::$app->reporter->col('DOCUMENT #','110',null,false,'1px solid ','B','C','Helvetica','11','B','','');
      Yii::$app->reporter->col('No. of days','110',null,false,'1px solid ','B','C','Helvetica','11','B','','');
      Yii::$app->reporter->col('BALANCE','110',null,false,'1px solid ','B','C','Helvetica','11','B','','');
      Yii::$app->reporter->endrow();
  
      $itemname="";
      $date="";
      $docno="";
      $yourref="";
      $totalext=0;
      $totalqty=0;
      $totaltons=0;
      $subtotalqty=0;
      $subtotalext=0;
      $subtotalpv=0;
      $subtotaltons=0;
      $gsubtotalqty=0;
      $gsubtotalext=0;
      $gsubtotalpv=0;
      $member="";
      $grandtotalpv=0;
      $grandtotalqty=0;
      $gsubtotaltons=0;

      $iitem="";
    
      for($i=0;$i<count($data);$i++){

        $display=$data[$i]['clientname'];
        $docno=$data[$i]['docno'];
        $date=$data[$i]['dateid'];
        $order=$data[$i]['elapse'];
        $served=$data[$i]['balance'];

        if ($itemname==""){
          Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
              Yii::$app->reporter->col($data[$i]['clientname'],'110',null,false,'1px dotted ','B','L','Helvetica','12','B','','5px');
              Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
              Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
              Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
              Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
              Yii::$app->reporter->endrow();   
        }
        
        if (strtoupper($itemname)==strtoupper($data[$i]['clientname'])){
              $itemname="";
              
          if (strtoupper($docno)==strtoupper($data[$i]['clientname'])){
            $docno="";
          }else{
            if ($docno!=''){    
              $subtotalqty=0;
              $subtotalext=0;
            }
            $itemname=strtoupper($data[$i]['clientname']);  
          }
        }
        else{
          if ($docno!=''){  
        }

        if ($itemname!=''){  
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Helvetica','11','B','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Helvetica','11','B','','');
            Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Helvetica','11','B','','');
            Yii::$app->reporter->col('SUB TOTAL :','110',null,false,'1px dotted ','','R','Helvetica','11','B','','');
            Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px dotted ','T','R','Helvetica','13','B','','');
          Yii::$app->reporter->endrow();
        }    

        if ($itemname!=''){      
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['clientname'],'110',null,false,'1px dotted ','B','L','Helvetica','11','B','','5px');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
            Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Helvetica','11','','','');
        }  
         
        $subtotalext=0;      
        $gsubtotalext=0;
        $docno=$data[$i]['clientname'];
        if (strtoupper($docno)==strtoupper($data[$i]['clientname'])){
          $docno="";  
        }else{
          $docno=strtoupper($data[$i]['clientname']);  
        }
      }
                          
      if ($iitem==$data[$i]['clientname']){
        $iitem="";
      }else{
        $iitem=$data[$i]['clientname'];
      }
                    
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','13','','','5px');
        Yii::$app->reporter->col($date,'110',null,false,'1px solid ','','L','Helvetica','13','','','5px');
        Yii::$app->reporter->col($data[$i]['docno'],'110',null,false,'1px solid ','','L','Helvetica','13','','','5px');
        Yii::$app->reporter->col(number_format($order,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'110',null,false,'1px solid ','','C','Helvetica','13','','','5px');
        Yii::$app->reporter->col(number_format($served,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'110',null,false,'1px solid ','','R','Helvetica','13','','','5px');  
      Yii::$app->reporter->endrow();  
       

      $subtotalext=$subtotalext+$data[$i]['balance'];
      $gsubtotalext=$gsubtotalext+$data[$i]['balance'];
      $totalext=$totalext+$data[$i]['balance'];
      $itemname=strtoupper($data[$i]['clientname']);
      $docno=$data[$i]['clientname'];
      $iitem=$data[$i]['clientname'];
    }
  
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Helvetica','11','B','','');
      Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Helvetica','11','B','','');
      Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Helvetica','11','B','','');
      Yii::$app->reporter->col('SUB TOTAL :','110',null,false,'1px dotted ','','R','Helvetica','11','B','','');
      Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px dotted ','T','R','Helvetica','15','B','','');
    Yii::$app->reporter->endrow();

    echo '<br/>';

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Helvetica','11','B','','');
      Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Helvetica','11','B','','');
      Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Helvetica','11','B','','');
      Yii::$app->reporter->col('TOTAL :','110',null,false,'1px dotted ','','R','Helvetica','11','B','','');
      Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px dotted ','T','R','Helvetica','13','B','','');
    Yii::$app->reporter->endrow();

  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>