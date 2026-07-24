<?php
$this->title = 'Current Customer Receivables - SUMMARY';
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
        Yii::$app->reporter->col('CURRENT CUSTOMER RECEIVABLES - SUMMARY',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');

$cus="";
if ($params['customer']==""){
    $cus='ALL';
}
     Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','','');
    if ($params['customer']=='') {
    Yii::$app->reporter->col('Customer : ALL','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');    
    } else {
    Yii::$app->reporter->col('Customer : '.strtoupper($params['customername']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    }
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUSTOMER NAME','110px',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('BALANCE','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
  
$amt=null;
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')

for($i=0;$i<count($data);$i++){
    
            $bal=number_format($data[$i]['balance'],2);
            if ($bal==0)
            {
            $bal='-';
            }
    
        $display=$data[$i]['clientname'];
        $served=$data[$i]['balance'];
       
   Yii::$app->reporter->startrow();
   Yii::$app->reporter->addline();
   Yii::$app->reporter->col($display,'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
   Yii::$app->reporter->col($bal,'110px',null,false,'1px solid ','','R','Century Gothic','10','','','');
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
        Yii::$app->reporter->col('CURRENT CUSTOMER RECEIVABLES - SUMMARY',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
if ($params['customer']==" "){
    $cus='ALL';
}
     Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','','');
    if ($params['customer']=='') {
    Yii::$app->reporter->col('Customer : ALL','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');    
    } else {
    Yii::$app->reporter->col('Customer : '.strtoupper($params['customer']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    }
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('Transaction : '.strtoupper($params['poststatus']),'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
    //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUSTOMER NAME','110px',null,false,'1px solid ','B','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('BALANCE','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->printline();
        $page=$page + $count;
            
            
   }
   
   
    }
   Yii::$app->reporter->startrow();
   
   Yii::$app->reporter->col('GRAND TOTAL : ','110px',null,false,'1px solid ','T','L','Century Gothic','10','B','','');
   Yii::$app->reporter->col(number_format($amt,2),'110px',null,false,'1px solid ','T','R','Century Gothic','10','B','','');
   Yii::$app->reporter->endrow();
        
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>