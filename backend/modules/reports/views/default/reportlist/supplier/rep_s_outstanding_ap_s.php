<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Supplier Payables - SUMMARY';
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
        Yii::$app->reporter->col('CURRENT SUPPLIER PAYABLES - SUMMARY',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        if($params['supplier']==''){
        Yii::$app->reporter->col('Supplier : ALL','110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['suppliername']),'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');    
        }
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
         Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SUPPLIER','110px',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('BALANCE','110px',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->endrow();
  
$amt=null;
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')

for($i=0;$i<count($data);$i++){
    
        $display=$data[$i]['clientname'];
        $served=$data[$i]['balance'];
       
   Yii::$app->reporter->startrow();
   Yii::$app->reporter->addline();
   Yii::$app->reporter->col($display,'110px',null,false,'1px solid ','','L','Helvetica','10','','','');
   Yii::$app->reporter->col(number_format($served,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','','R','Helvetica','10','','','');
   Yii::$app->reporter->endrow();
   
   $amt=$amt+$data[$i]['balance'];
   
   
   
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
        Yii::$app->reporter->col('CURRENT SUPPLIER PAYABLES - SUMMARY',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        if($params['supplier']==''){
        Yii::$app->reporter->col('Supplier : ALL','110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        } else {
        Yii::$app->reporter->col('Supplier : '.strtoupper($params['suppliername']),'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');    
        }
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
         Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Helvetica','10','','b','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SUPPLIER','110px',null,false,'1px solid ','B','L','Helvetica','11','B','','');
        Yii::$app->reporter->col('BALANCE','110px',null,false,'1px solid ','B','C','Helvetica','11','B','','');
        Yii::$app->reporter->endrow();
          Yii::$app->reporter->printline();
        $page=$page + $count;
} 
    }
   Yii::$app->reporter->startrow();
   
   Yii::$app->reporter->col('GRAND TOTAL : ','110px',null,false,'1px solid ','T','L','Helvetica','11','B','','');
   Yii::$app->reporter->col(number_format($amt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110px',null,false,'1px solid ','T','R','Helvetica','11','B','','');
   Yii::$app->reporter->endrow();
        
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>