<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Per Item Per Customer';
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
        Yii::$app->reporter->col('SALES PER ITEM PER CUSTOMER',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();        

Yii::$app->reporter->begintable('800');        
        Yii::$app->reporter->startrow();
        if($params['item']==''){
        Yii::$app->reporter->col('Item : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'. $params['item'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['option']=='sales'){
        Yii::$app->reporter->col('Option : AMOUNT','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Option :'. strtoupper($params['option']),'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEMNAME','200',null,false,'1px solid ','TB','L','Century Gothic','10','B','','0px 0px 0px 50px');
        Yii::$app->reporter->col('DATE','50',null,false,'1px solid ','TB','L','B','10','B','','');
        Yii::$app->reporter->col('DR #','100',null,false,'1px solid ','TB','L','B','10','B','','');
        Yii::$app->reporter->col('CUSTOMER','150',null,false,'1px solid ','TB','L','B','10','B','','');
        Yii::$app->reporter->col('UOM','50',null,false,'1px solid ','TB','L','B','10','B','','');
        Yii::$app->reporter->col('QTY','75',null,false,'1px solid ','TB','L','B','10','B','','');
        Yii::$app->reporter->col('AMT','75',null,false,'1px solid ','TB','L','B','10','B','','');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','TB','L','B','10','B','','');
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
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->endrow();

   Yii::$app->reporter->startrow();
        if ($item==$data[$i]['itemname']){
            $dis="";
        } else {
            $dis=Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px dotted ','TB','L','Century Gothic','10','B','b','');
            $dis2=Yii::$app->reporter->col('','50',null,false,'1px dotted ','TB','L','B','10','B','','');
            $dis2=Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','B','10','B','','');
            $dis2=Yii::$app->reporter->col('','150',null,false,'1px dotted ','TB','L','B','10','B','','');
            $dis3=Yii::$app->reporter->col('','50',null,false,'1px dotted ','TB','L','B','10','B','','');
            $dis3=Yii::$app->reporter->col('','75',null,false,'1px dotted ','TB','L','B','10','B','','');
            $dis3=Yii::$app->reporter->col('','75',null,false,'1px dotted ','TB','L','B','10','B','','');
            $dis3=Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','B','10','B','','');

        }//end fn
        echo $dis;
   Yii::$app->reporter->endrow();

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','10','','','0px 0px 0px 50px');
    Yii::$app->reporter->col($data[$i]['dateid'],'50',null,false,'1px dotted ','','L','B','10','B','','');
    Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px dotted ','','L','B','10','B','','');
    Yii::$app->reporter->col($data[$i]['clientname'],'150',null,false,'1px dotted ','','L','B','10','B','','');
    Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px dotted ','','L','B','10','B','','');
    Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','','L','B','10','B','','');
    Yii::$app->reporter->col(number_format($data[$i]['sales'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','','L','B','10','B','','');
    Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','','L','B','10','B','','');
   Yii::$app->reporter->endrow();
   $ordtotal += $data[$i]['ext'];
   $item=$data[$i]['itemname'];
  
  }      

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','Century Gothic','10','','','0px 0px 0px 50px');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','L','B','10','B','','');
    Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','L','B','10','B','','');
    Yii::$app->reporter->col('','150',null,false,'1px dotted ','T','L','B','10','B','','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','L','B','10','B','','');
    Yii::$app->reporter->col('GRAND','75',null,false,'1px dotted ','T','L','B','10','B','','');
    Yii::$app->reporter->col('TOTAL:','75',null,false,'1px dotted ','T','L','B','10','B','','');
    Yii::$app->reporter->col(number_format($ordtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','L','B','10','B','','');
   Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

// //var_dump($params);
// //var_dump($data);
 ?>