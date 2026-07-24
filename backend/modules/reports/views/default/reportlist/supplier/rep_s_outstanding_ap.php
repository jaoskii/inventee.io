<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Supplier Payables - DETAILED';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED CURRENT SUPPLIER PAYABLES',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        if($params['supplier']==''){
        Yii::$app->reporter->col('Supplier : ALL','110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['suppliername']),'110',null,false,'1px solid ','','L','Helvetica','10','','b','');    
        }
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
         Yii::$app->reporter->col('Center : '.$params['center'],'110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DATE','200',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','200',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('YOURREF','200',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('No. of days','100',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->endrow();

$amt=null;
$customer="";
$subtotal=0;
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')

for($i=0;$i<count($data);$i++){

        $display=$data[$i]['clientname'];
        $docno=$data[$i]['docno'];
        $yourref=$data[$i]['yourref'];
        $date=$data[$i]['dateid'];
        $order=$data[$i]['elapse'];
        $served=$data[$i]['balance'];

        if ($customer!=$data[$i]['clientname']){
            if($customer != ""){
                Yii::$app->reporter->startrow();
                $dis=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
                $dis2=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
                $dis4=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
                $dis6=Yii::$app->reporter->col('SUBTOTAL: ','100',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
                $dis7=Yii::$app->reporter->col(number_format($subtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Helvetica','10','B','','');
                Yii::$app->reporter->endrow();
            }
            $subtotal=0;

            Yii::$app->reporter->startrow();
            $dis=Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
            $dis2=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','B','10','B','','');
            $dis3=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','B','10','B','','');
            $dis4=Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','L','B','10','B','','');
            $dis5=Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','L','B','10','B','','');
            Yii::$app->reporter->endrow();
        }

$subtotal=$subtotal+$served;
   Yii::$app->reporter->startrow();
   Yii::$app->reporter->addline();
   Yii::$app->reporter->col('&nbsp;&nbsp;'. $date,'200',null,false,'1px solid ','','L','Helvetica','10','','','');
   Yii::$app->reporter->col($docno,'200',null,false,'1px solid ','','L','Helvetica','10','','','');
   Yii::$app->reporter->col($yourref,'200',null,false,'1px solid ','','L','Helvetica','10','','','');
   Yii::$app->reporter->col(number_format($order,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Helvetica','10','','','');
   Yii::$app->reporter->col(number_format($served,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','10','','','');
   Yii::$app->reporter->endrow();

   $customer=$data[$i]['clientname'];
   $amt=$amt+$data[$i]['balance'];
   //$subtotal=$subtotal+$data[$i]['balance'];
    
   if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

                Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DETAILED CURRENT SUPPLIER PAYABLES',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        if($params['supplier']==''){
        Yii::$app->reporter->col('Supplier : ALL','110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['suppliername']),'110',null,false,'1px solid ','','L','Helvetica','10','','b','');    
        }
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
         Yii::$app->reporter->col('Center : '.$params['center'],'110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DATE','200',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('DOCUMENT #','200',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('YOURREF','200',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('No. of days','100',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->endrow();
            Yii::$app->reporter->printline();
        $page=$page + $count;
   }
   
   
   
   }

   Yii::$app->reporter->startrow();
    $dis=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
    $dis2=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
    $dis3=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
    $dis6=Yii::$app->reporter->col('SUBTOTAL: ','100',null,false,'1px dotted ','T','L','Helvetica','10','B','','');
    $dis7=Yii::$app->reporter->col(number_format($subtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Helvetica','10','B','','');
    Yii::$app->reporter->endrow();
   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Helvetica','10','','','');
   Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Helvetica','10','','','');
   Yii::$app->reporter->col('TOTAL : ','200',null,false,'1px solid ','T','L','Helvetica','10','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Helvetica','10','','','');
   Yii::$app->reporter->col(number_format($amt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','T','R','Helvetica','10','b','','');
   Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>