<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory of Backload - Summary';

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
echo '<div style="letter-spacing: 2px;">';
Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('INVENTORY OF BACKLOAD - SUMMARY',null,null,false,'1px solid ','','C','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col($params['startdate']. ' to ' .$params['enddate'],null,null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();


        // Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        // Yii::$app->reporter->col($params['startdate'].' to '.$params['enddate'],null,null,false,'1px solid ','','C','Century Gothic','12','B','','');
        // Yii::$app->reporter->endrow();

        

Yii::$app->reporter->endtable();

//header info
Yii::$app->reporter->begintable(1000);
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        // Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        // Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEMS DESCRIPTION','400',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('QTY','150',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
        // Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dashed ','','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','150',null,false,'1px dashed ','','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();
//      $part="";
//      $brand="";  

for($i=0;$i<count($data);$i++){

// LINE 72
    Yii::$app->reporter->startrow();
        // Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        // Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col($data[$i]['items'],'400',null,false,'1px dashed ','','L','Century Gothic','11','','30px','7px');
        Yii::$app->reporter->col($data[$i]['code'],'100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','C','Century Gothic','9','','30px','7px');

        // Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        // Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
    
        // Yii::$app->reporter->col(number_format($data[$i]['PRICE'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dashed ','','C','Century Gothic','9','','30px','7px');
        Yii::$app->reporter->col(number_format($data[$i]['amount'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dashed ','','R','Century Gothic','9','','30px','7px');
    
}
Yii::$app->reporter->endrow();

Yii::$app->reporter->endreport();
echo '</div>';
?>