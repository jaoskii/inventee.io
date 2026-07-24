<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Pending Sales Order - VOID';
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
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PENDING SALES ORDERS',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/><br/>';
// if ($params['client'] != ""){
// Yii::$app->reporter->begintable('800');
//         Yii::$app->reporter->startrow();
//         //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
//         Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),null,null,false,'1px solid ','','C','Century Gothic','14','B','','').'<br />';
//         Yii::$app->reporter->endrow();
// Yii::$app->reporter->endtable();
// } else {
// }
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
$item=null;
$item2=null;
$client="";
//col($txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
    Yii::$app->reporter->endrow();
        $display=$data[$i]['itemname'];
        $docno=$data[$i]['docno'];
        $date=$data[$i]['dateid'];
        $order=$data[$i]['qty'];
        //$served=$data[$i]['isamt'];
        $bal=$data[$i]['unserved'];
        $uom=$data[$i]['uom'];
   Yii::$app->reporter->startrow();
    if ($item==$data[$i]['yourref']){
          $dis="";

          if ($client==$data[$i]['clientname'])
        { 
         $dis2="";
        } else  {
        Yii::$app->reporter->begintable('500');
        Yii::$app->reporter->startrow();
        $dis2=Yii::$app->reporter->col($data[$i]['clientname'],'400',null,false,'1px dotted ','','L','Century Gothic','13','B','','5px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','LRTB','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($data[$i]['docno'],'200',null,false,'1px dotted ','LRTB','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px dotted ','LRTB','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','B','10','','','');
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','L','B','10','','',''); 
        }
        echo $dis2;
        
    } else {

        if ($client==$data[$i]['clientname'])
        { 
         $dis2="";
        } else  {
        Yii::$app->reporter->begintable('500');
        Yii::$app->reporter->startrow();
        $dis2=Yii::$app->reporter->col($data[$i]['clientname'],'400',null,false,'1px dotted ','','L','Century Gothic','13','B','','5px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        }
        echo $dis2;
        $dis=Yii::$app->reporter->col($data[$i]['yourref'],'100',null,false,'1px dotted ','LRTB','C','Century Gothic','12','B','','');
        $dis2=Yii::$app->reporter->col($data[$i]['docno'],'200',null,false,'1px dotted ','LRTB','L','Century Gothic','12','B','','');
        $dis3=Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px dotted ','LRTB','C','Century Gothic','12','B','','');
        $dis3=Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','B','10','','','');
        $dis4=Yii::$app->reporter->col('','300',null,false,'1px dotted ','','L','B','10','','','');
    }
   
   echo $dis;
   Yii::$app->reporter->endrow();
   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','3px');
   Yii::$app->reporter->col($display,'200',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
   Yii::$app->reporter->col(number_format($data[$i]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','3px');
   Yii::$app->reporter->col(number_format($data[$i]['unserved'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','3px');
   Yii::$app->reporter->col('','300',null,false,'1px solid ','','C','Century Gothic','11','','','');
 
   Yii::$app->reporter->endrow();
   $item=$data[$i]['yourref'];
   $client=$data[$i]['clientname'];

         
    }
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

?>