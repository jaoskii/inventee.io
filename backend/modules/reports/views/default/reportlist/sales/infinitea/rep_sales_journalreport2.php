<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$pagenumber=1;
$count=6;
$page=6;
//echo '<div style="letter-spacing: 3px;">';
Yii::$app->reporter->beginreport('800');
Yii::$app->reporter->begintable('800');

$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
//header
    $start=$params['start'];
    $end=$params['end'];
    if($params['username']!=""){
        $user=$params['username'];
    }
    else{
        $user="ALL USERS";
    }
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('SALES JOURNAL REPORT',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','30px','5px');
    Yii::$app->reporter->col('DATE : '.$start.' to '.$end,null,null,false,'1px solid ','','','Century Gothic','11','B','','');
    Yii::$app->reporter->col('USER : '.$user,null,null,false,'1px solid ','','','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$docno="";

Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('PAYMENT TYPE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CHECK DETAILS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('REMARKS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
$amt=null;
$itemname="";
$subtotal=0;
$ordtotal=0;
$remtotal=0;
$cus="";
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$item=null;
$totalamt=0;
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->endrow();

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
   Yii::$app->reporter->col($data[$i]['salestype'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data[$i]['checked'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->endrow();

   $item=$data[$i]['salestype'];
   $totalamt = $totalamt+$data[$i]['amt'];

  } 
  Yii::$app->reporter->begintable('800');     
   Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
    Yii::$app->reporter->col('CASH :<br/> '.number_format($data3[0]['cash'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('CHECK :<br/> '.number_format($data3[0]['check'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('CHARGE :<br/> '.number_format($data3[0]['charge'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('DEPOSIT :<br/> '.number_format($data3[0]['deposit'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('TOTAL : ','100',null,false,'1px solid ','','R','Century Gothic','11','B','','');
    Yii::$app->reporter->col(number_format($totalamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','T','R','Century Gothic','11','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
        
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('PENDING TRANSACTION',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
            Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
               Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('PAYMENT TYPE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CHECK DETAILS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('REMARKS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
//var_dump($data);
$amt=null;
$itemname="";
$subtotal=0;
$ordtotal=0;
$remtotal=0;
$cus="";
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$item=null;
$totalamt2=0;
for($i=0;$i<count($data2);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->endrow();

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col($data2[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data2[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data2[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->col(number_format($data2[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
   Yii::$app->reporter->col($data2[$i]['salestype'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data2[$i]['checked'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->col($data2[$i]['rem'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->endrow();

   $item=$data2[$i]['salestype'];
   $totalamt2 = $totalamt2+$data2[$i]['amt'];

  }      

   Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('TOTAL : ','200',null,false,'1px solid ','','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col(number_format($totalamt2,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','T','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('COLLECTION',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
            Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
               Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('ACCOUNT NAME','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CHECK DETAILS','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
//var_dump($data);
$amt=null;
$itemname="";
$subtotal=0;
$ordtotal=0;
$remtotal=0;
$cus="";
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$item=null;
$totalamt4=0;
for($i=0;$i<count($data4);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data4[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
    Yii::$app->reporter->col($data4[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
    Yii::$app->reporter->col($data4[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->col($data4[$i]['acnoname'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','');
    Yii::$app->reporter->col($data4[$i]['checkno'],'150',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->col(number_format($data4[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();

    $totalamt4 = $totalamt4+$data4[$i]['amt'];

  }      

   Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('TOTAL :','150',null,false,'1px solid ','','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col(number_format($totalamt4,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','T','R','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('DEPOSITS',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
            Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
               Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('PAYMENT TYPE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('CHECK DETAILS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col('REMARKS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
//var_dump($data);
$amt=null;
$itemname="";
$subtotal=0;
$ordtotal=0;
$remtotal=0;
$cus="";
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$item=null;
$totalamt6=0;
for($i=0;$i<count($data6);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->endrow();

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col($data6[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data6[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data6[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->col(number_format($data6[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
   Yii::$app->reporter->col($data6[$i]['salestype'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
   Yii::$app->reporter->col($data6[$i]['checked'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->col($data6[$i]['rem'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
   Yii::$app->reporter->endrow();

   $item=$data6[$i]['salestype'];
   $totalamt6 = $totalamt6+$data6[$i]['amt'];

  }      

   Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('TOTAL : ','200',null,false,'1px solid ','','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col(number_format($totalamt6,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','T','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                    //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('INVENTORY BALANCE - BELOW MINIMUM',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
            Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 


Yii::$app->reporter->begintable('800');   
  
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BARCODE','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','400',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('BALANCE','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('MINIMUM STOCK','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');   
Yii::$app->reporter->startrow();
$totalbal=0;
$totalmin=0;
$part="";
for($i=0;$i<count ($data5);$i++){

  if ($part==strtoupper($data5[$i]['category'])){
              $part=""; 
            }
            else {
              $part=$data5[$i]['category'];
            }   

    Yii::$app->reporter->col($part,'200',null,false,'1px solid ','','L','Century Gothic','10','Bi','','');
    Yii::$app->reporter->col('','200',null,false,'1px solid ','','C','Century Gothic','10','Bi','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','10','Bi','','');
    Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','10','Bi','','');
    Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','10','Bi','','');
    Yii::$app->reporter->endrow();        

  Yii::$app->reporter->col($data5[$i]['barcode'],'200',null,false,'1px solid ','','C','Century Gothic','10','','','');
  Yii::$app->reporter->col($data5[$i]['itemname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
  Yii::$app->reporter->col($data5[$i]['uom'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
  Yii::$app->reporter->col(number_format($data5[$i]['balance']),'150',null,false,'1px solid ','','R','Century Gothic','10','','','');
  Yii::$app->reporter->col(number_format($data5[$i]['minimum']),'150',null,false,'1px solid ','','R','Century Gothic','10','','','');

  $part=$data5[$i]['category'];
  $totalbal=$totalbal+$data5[$i]['balance'];
  $totalmin=$totalmin+$data5[$i]['minimum'];
  

        Yii::$app->reporter->endrow();
}
        Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');   
Yii::$app->reporter->startrow();

  Yii::$app->reporter->col('','200',null,false,'1px solid ','T','R','Century Gothic','10','','','');
  Yii::$app->reporter->col('','200',null,false,'1px solid ','T','R','Century Gothic','10','','','');
  Yii::$app->reporter->col('TOTAL :','100',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
  Yii::$app->reporter->col(number_format($totalbal),'150',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
  Yii::$app->reporter->col(number_format($totalmin),'150',null,false,'1px solid ','T','R','Century Gothic','10','B','','');

        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();



Yii::$app->reporter->endreport();
// echo '</div>';

// //var_dump($params);
// var_dump($data);
 ?>