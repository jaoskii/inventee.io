<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Supplier Payables Aging - DETAILED';
//WTODO: [KIM][2019.12.04][update layout for current supplier payables aging]
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
  Yii::$app->reporter->endtable();
  echo '<br/><br/>';

  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('DETAILED CURRENT SUPPLIER PAYABLES AGING',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
      if($params['client']==''){
        Yii::$app->reporter->col('Supplier : ALL','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
      } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['client']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');    
      }

      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
      Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
      Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
      Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->printline();
  
  Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('0-30 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('31-60 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('61-90 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('91-120 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('120+ days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
      Yii::$app->reporter->endrow();
      
        $a=0;
        $b=0;
        $c=0;
        $d=0;
        $e=0;
        $tota=0;
        $totb=0;
        $totc=0;
        $totd=0;
        $tote=0;
        $gt=0;
        $customer="";
        $docno="";

        //WTODO: [KIM][2019.12.04][add subtotal]
        $subtota=0;
        $subtotb=0;
        $subtotc=0;
        $subtotd=0;
        $subtote=0;
        $subgt =0;
        $clientname = "";
        
for($i=0;$i<count($data);$i++){  

        //
          if($clientname != $data[$i]['clientname']){
            if($clientname != ''){
              Yii::$app->reporter->startrow();
              Yii::$app->reporter->col('&nbsp','200',null,false,'1px','B','L','Century Gothic','10','B','','');
              Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','10','B','','');
              Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','10','B','','');
              Yii::$app->reporter->col(number_format($subtota,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
              Yii::$app->reporter->col(number_format($subtotb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
              Yii::$app->reporter->col(number_format($subtotc,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
              Yii::$app->reporter->col(number_format($subtotd,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
              Yii::$app->reporter->col(number_format($subtote,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
              Yii::$app->reporter->col(number_format($subgt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
              Yii::$app->reporter->endrow();
              
              $subtota = 0;
              $subtotb = 0;
              $subtotc = 0;
              $subtotd = 0;
              $subtote = 0;
              $subgt =0;
              // $invcostperitem = 0;
            }//end if

            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px','B','L','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','R','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','10','B','','');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','C','Century Gothic','10','B','','');
            Yii::$app->reporter->endrow();
          }//end if
        //
    
      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
        if ($data[$i]['elapse'] >=0 && $data[$i]['elapse'] < 30){
            $a=$data[$i]['balance'];
            $b=0;
            $c=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');

            $subtota=$subtota+$a;
            $subgt=$subgt+$data[$i]['balance'];

        }
        if ($data[$i]['elapse'] > 31 && $data[$i]['elapse'] < 60){
            $b=$data[$i]['balance'];
            $a=0;
            $c=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');

            $subtotb=$subtotb+$b;
            $subgt=$subgt+$data[$i]['balance'];
        }
        if ($data[$i]['elapse'] > 61 && $data[$i]['elapse'] < 90){
            $c=$data[$i]['balance'];
            $a=0;
            $b=0;
            $d=0;
            $e=0;
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');

            $subtotc=$subtotc+$c;
            $subgt=$subgt+$data[$i]['balance'];
        }
        if ($data[$i]['elapse'] > 91 && $data[$i]['elapse'] < 120){
            $d=$data[$i]['balance'];
            $a=0;
            $c=0;
            $b=0;
            $e=0;
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');

            $subtotd=$subtotd+$d;
            $subgt=$subgt+$data[$i]['balance'];
        }
        if ($data[$i]['elapse'] > 120){
            $e=$data[$i]['balance'];
            $a=0;
            $c=0;
            $d=0;
            $b=0;
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col('-','100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','r','Century Gothic','10','','','');

          $subtote=$subtote+$e;
          $subgt=$subgt+$data[$i]['balance'];
        
        }
        Yii::$app->reporter->endrow();
        $clientname = $data[$i]['clientname'];




        $tota=$tota+$a;
        $totb=$totb+$b;
        $totc=$totc+$c;
        $totd=$totd+$d;
        $tote=$tote+$e;
        $gt=$gt+$data[$i]['balance'];
        $customer=$data[$i]['clientname'];
        if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED CURRENT SUPPLIER PAYABLES  AGING',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');
Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        if($params['client']==''){
        Yii::$app->reporter->col('Supplier : ALL','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['client']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');    
        }
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
         Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('0-30 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('31-60 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('61-90 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('91-120 days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('120+ days','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
} 
        
        
    }

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px','B','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px','B','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($subtota,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($subtotb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($subtotc,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($subtotd,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($subtote,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($subgt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Century Gothic','10','','','5px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col('TOTAL : ','100',null,false,'1px dotted','T','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($tota,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totc,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totd,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($tote,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','r','Century Gothic','10','B','','');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>