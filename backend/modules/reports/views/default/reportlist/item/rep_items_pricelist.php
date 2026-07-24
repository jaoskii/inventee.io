<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Price List';
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
        Yii::$app->reporter->col('PRICE LIST',null,null,false,'1px solid ','','C','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col(date('m/d/Y',time()),null,null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();

//header info
Yii::$app->reporter->begintable('100');
// setup params
if ($params['brand']!=''){
    $brand = $params['brand'];
}else{
    $brand = 'ALL';
}

if ($params['group']!=''){
    $group = $params['group'];
}else{
    $group = 'ALL';
}

if ($params['class']!=''){
    $class = $params['class'];
}else{
    $class = 'ALL';
}

if ($params['category']!=''){
    $category = $params['category'];
}else{
    $category = 'ALL';
}

if ($params['include']=='0'){
    $include ='ACTIVE';
}else if ($params['include']=='1'){
    $include = 'INACTIVE';
}else{
    $include = 'ALL ITEMS';
}
//
Yii::$app->reporter->begintable('800');

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BRAND: '.$brand,'150',null,false,'1px solid ','','','Century Gothic','11','','','3px');
        Yii::$app->reporter->col('CATEGORY: '.$category,'150',null,false,'1px solid ','','','Century Gothic','11','','','3px');
        Yii::$app->reporter->col($include,'100',null,false,'1px solid ','','','Century Gothic','11','','','3px');
        Yii::$app->reporter->endrow(); 

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CLASS: '.$class,'100',null,false,'1px dashed ','B','','Century Gothic','11','','','3px');
        Yii::$app->reporter->col('GROUP: '.$group,'100',null,false,'1px dashed ','B','','Century Gothic','11','','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->endrow(); 
Yii::$app->reporter->endtable();

Yii::$app->reporter->endtable();

//Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','500',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UNIT','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('PRICE','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();
     $part="";
     $brand="";

for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px dashed ','','L','Century Gothic','10','','','3px');
        Yii::$app->reporter->col($data[$i]['itemname'],'500',null,false,'1px dashed ','','L','Century Gothic','10','','','3px');
        Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px dashed ','','L','Century Gothic','10','','','3px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dashed ','','R','Century Gothic','10','','','3px');    
    Yii::$app->reporter->endrow();
}


Yii::$app->reporter->startrow();
Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','500',null,false,'1px dashed ','B','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','R','Century Gothic','11','B','30px','8px').'<br />';
Yii::$app->reporter->endrow();
    //Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>