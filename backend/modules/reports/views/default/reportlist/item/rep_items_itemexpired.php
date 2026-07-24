<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Item to Expired';
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
        Yii::$app->reporter->col('ITEM TO EXPIRED',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();        

Yii::$app->reporter->begintable('800');        
        Yii::$app->reporter->startrow();
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('BARCODE','150',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('ITEMNAME','350',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('BALANCE','150',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('EXPIRED DATE','150',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
    Yii::$app->reporter->endrow();    
Yii::$app->reporter->endtable();  

Yii::$app->reporter->begintable('800');


for($i=0;$i<count($data);$i++){

   Yii::$app->reporter->startrow();
   Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','0px 0px 0px 40px');
   Yii::$app->reporter->col($data[$i]['itemname'],'350',null,false,'1px solid ','','L','Century Gothic','11','','','5px');
   Yii::$app->reporter->col(number_format($data[$i]['bal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Century Gothic','11','','','5px');
   Yii::$app->reporter->col($data[$i]['expdate'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','5px');
   Yii::$app->reporter->endrow();
  
  }      
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

// //var_dump($params);
// var_dump($data);
 ?>