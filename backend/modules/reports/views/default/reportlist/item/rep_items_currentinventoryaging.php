<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Inventory Aging';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport();

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CURRENT INVENTORY AGING',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();        

Yii::$app->reporter->begintable('800');        
        Yii::$app->reporter->startrow();
        if($params['barcode']==''){
        Yii::$app->reporter->col('Item : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'. $params['itemname'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if($params['principalid']==''){
        Yii::$app->reporter->col('Principal : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Principal :'. $params['principalid'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if($params['divisionid']==''){
        Yii::$app->reporter->col('Division : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Division :'. $params['divisionid'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if($params['genericid']==''){
        Yii::$app->reporter->col('Generic : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Generic :'. $params['generic'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');         
        Yii::$app->reporter->startrow('100',null,false,'1px solid ','','C','Helvetica','10','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('WH : '. $params['wh'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        if($params['classid']==''){
        Yii::$app->reporter->col('Classification : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Classification :'. $params['class'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
         if($params['categoryid']==''){
        Yii::$app->reporter->col('Category : ALL','200',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Category :'. $params['category'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        Yii::$app->reporter->col('Item Type : '. strtoupper($params['itemtype']),'100',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('ELAPSE','100',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('EXPIRY','100',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('PURCH.QTY','100',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('UOM','50',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('REMAIN QTY','100',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('SOLD QTY','100',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
        Yii::$app->reporter->col('%AGE','50',null,false,'1px solid ','B','C','Helvetica','12','B','20px','8px');
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
$barcode = "";
for($i=0;$i<count($data);$i++){
        $display=$data[$i]['itemname'];
        $date=$data[$i]['dateid'];
        $uom=$data[$i]['uom'];
        $order=$data[$i]['qty'];
        $served=$data[$i]['sold'];
        $remain=$data[$i]['bal'];
        $docno=$data[$i]['docno'];

        $age=($served/$order)*100;
        $tage=number_format($age);
            if ($tage==0)
            {
            $tage='-';
            }
        $torder=number_format($order,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
            if ($torder==0)
            {
            $torder='-';
            }    
        $sserved=number_format($served,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
            if ($sserved==0)
            {
            $sserved='-';
            } 
            $tremain=number_format($remain,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
            if ($tremain==0)
            {
            $tremain='-';
            } 
            $tremtotal=number_format($remtotal,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
            if ($tremtotal==0)
            {
            $tremtotal='-';
            } 



        if ($barcode!=$data[$i]['barcode']){
            $subtotal=0;
            $ordtotal=0;
            $remtotal=0;
            
            Yii::$app->reporter->endtable();  
            Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['itemname'],'800',null,false,'1px dotted ','','L','Helvetica','11','B','','5px');
            
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();  
            Yii::$app->reporter->begintable('800');
             $barcode = $data[$i]['barcode'];
        } 

        
$subtotal=$subtotal+$served;
$ordtotal=$ordtotal+$order;
$remtotal=$remtotal+$remain;
   Yii::$app->reporter->startrow();
   Yii::$app->reporter->addline();
   Yii::$app->reporter->col($date,'100',null,false,'1px solid ','','L','Helvetica','11','','','5px');
   Yii::$app->reporter->col($docno,'100',null,false,'1px solid ','','L','Helvetica','11','','','5px');
   Yii::$app->reporter->col($data[$i]['elapse'].'Day(s)','100',null,false,'1px solid ','','C','Helvetica','11','','','5px');
   Yii::$app->reporter->col($data[$i]['expiry'],'100',null,false,'1px solid ','','R','Helvetica','11','','','5px');
   Yii::$app->reporter->col($torder,'100',null,false,'1px solid ','','R','Helvetica','11','','','5px');
   Yii::$app->reporter->col($uom,'50',null,false,'1px solid ','','C','Helvetica','11','','','5px');
   Yii::$app->reporter->col($tremain,'100',null,false,'1px solid ','','R','Helvetica','11','','','5px');
   Yii::$app->reporter->col($sserved,'100',null,false,'1px solid ','','R','Helvetica','11','','','5px');
   Yii::$app->reporter->col($tage.'%','50',null,false,'1px solid ','','R','Helvetica','11','','','5px');
   Yii::$app->reporter->endrow();
   
  if ($barcode!=$data[$i]['barcode']){
        Yii::$app->reporter->startrow();
   Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Helvetica','11','','','5px');
   Yii::$app->reporter->col('TOTAL :','100',null,false,'1px solid ','','R','Helvetica','11','B','','5px');
   Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Helvetica','11','B','','5px');
   Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Helvetica','11','B','','5px');
   Yii::$app->reporter->col(number_format($ordtotal,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','T','R','Helvetica','11','B','','5px');
   Yii::$app->reporter->col('','50',null,false,'1px solid ','T','C','Helvetica','11','','','5px');
   Yii::$app->reporter->col(number_format($remtotal,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','T','R','Helvetica','11','B','','5px');
   Yii::$app->reporter->col(number_format($subtotal,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','T','R','Helvetica','11','B','','5px');
   Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Helvetica','11','','','5px');
        Yii::$app->reporter->endrow();
   }
   $itemname=$data[$i]['itemname'];
   $amt=$amt+$data[$i]['bal'];
   //$subtotal=$subtotal+$data[$i]['balance'];
    }
           
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);
?>