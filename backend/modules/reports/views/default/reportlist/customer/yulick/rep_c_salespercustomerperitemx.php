<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Per Customer Per Item';
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
        Yii::$app->reporter->col('SALES PER CUSTOMER PER ITEM ',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();        

Yii::$app->reporter->begintable('800');        
        Yii::$app->reporter->startrow();
        if($params['yulick']==''){
        Yii::$app->reporter->col('Company : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Company : ' . $params['yulick'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['client']==''){
        Yii::$app->reporter->col('Customer : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Customer :'. $params['client'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
// Yii::$app->reporter->begintable('800');         
//         Yii::$app->reporter->startrow('100',null,false,'1px solid ','','C','Century Gothic','10','','30px','5px');
//         //Yii::$app->reporter->col('Center :'.$cname,'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
//         Yii::$app->reporter->col('WH : '. $params['wh'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
//         Yii::$app->reporter->col('Class'. $params['class'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
//         Yii::$app->reporter->col('Option : '. strtoupper($params['itemtype']),'100',null,false,'1px solid ','','L','Century Gothic','10','','','');
//         //Yii::$app->reporter->pagenumber('Page');
//         Yii::$app->reporter->endrow();
// Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();


if(strtoupper($params['option'])=="QTY"){
        $ab = Yii::$app->systemsettings->setDecimaldisplay('quantity');
        }else{
        $ab = Yii::$app->systemsettings->setDecimaldisplay('currency');    
        }


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUSTOMER NAME','300',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('ITEM NAME ','300',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('SALES/QUANTITY','200',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
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
        if ($item==$data[$i]['clientname']){
            $dis="";
        } else {
            $dis=Yii::$app->reporter->col($data[$i]['clientname'].' ( '.$data[$i]['client'].' ) ','300',null,false,'1px dotted ','T','L','Century Gothic','10','B','b','');
            $dis2=Yii::$app->reporter->col('','300',null,false,'1px dotted ','T','L','B','10','B','','');
            $dis3=Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','L','B','10','B','','');

        }
        echo $dis;
   Yii::$app->reporter->endrow();

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','10','','','0px 0px 0px 50px');
   Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Century Gothic','10','','','5px');
   Yii::$app->reporter->col(number_format($data[$i]['sales'],$ab),'200',null,false,'1px solid ','','R','Century Gothic','10','','','5px');
   Yii::$app->reporter->endrow();

   $item=$data[$i]['clientname'];
  }      
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

// //var_dump($params);
// //var_dump($data);
 ?>