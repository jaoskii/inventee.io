<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Schedule of Inventory';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SCHEDULE OF INVENTORY',null,null,false,'1px solid ','','C','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col(date('m/d/Y',time()),null,null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();

//header info
Yii::$app->reporter->begintable(1000);
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

$wh ='';
$whname ='';
$whtitle='';
if($params['wh']!=""){
    $wh = Yii::$app->sbccommon->datareader("select client from client where client ='".$params['wh']."'");
    $whname = Yii::$app->sbccommon->datareader("select clientname from client where client ='".$params['wh']."'");

    $whtitle = $wh.'-'.$whname;
}else{
    $whtitle = "All";
}


        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BRAND: '.$brand,'150',null,false,'1px solid ','','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->col('CATEGORY: '.$category,'150',null,false,'1px solid ','','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->col($include,'50',null,false,'1px solid ','','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->endrow(); 

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('WAREHOUSE: '.$whtitle,'150',null,false,'1px dashed ','B','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->col('GROUP: '.$group,'150',null,false,'1px dashed ','B','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->col('','150',null,false,'1px dashed ','B','','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->endrow(); 

Yii::$app->reporter->endtable();

//Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','150',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','500',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UNIT','150',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('COST','150',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('QUANTITY','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('INV COST','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('TON','100',null,false,'1px dashed ','B','C','Century Gothic','11','B','30px','8px');
        
     $part="";
     $brand="";

$classgrp="";
$gtotalcost =0;
$gtotalton =0;

for($i=0;$i<count($data);$i++){

    if ($classgrp != $data[$i]['class']){
		if ($gtotalcost!=0 || $gtotalton!=0){
    		Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','150',null,false,'1px dashed ','','L','Century Gothic','10','','','3px');
            Yii::$app->reporter->col('','500',null,false,'1px dashed ','','L','Century Gothic','10','','','3px');
            Yii::$app->reporter->col('','150',null,false,'1px dashed ','','L','Century Gothic','10','','','3px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','10','','','3px');    
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','10','','','3px');
            Yii::$app->reporter->col($gtotalcost,'100',null,false,'1px dashed ','T','R','Century Gothic','10','','','3px');    
            Yii::$app->reporter->col($gtotalton,'100',null,false,'1px dashed ','T','R','Century Gothic','10','','','3px');    
        	Yii::$app->reporter->endrow(); 
    	}

    	$gtotalcost = 0;
    	$gtotalton = 0;

        $classgrp = $data[$i]['class']; 

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($classgrp,'150',null,false,'1px dashed ','','L','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();  

        $totalcost = $data[$i]['balance'] * $data[$i]['cost'];
        $ton = $data[$i]['balance'] * $data[$i]['kilos'];

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px dashed ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px dashed ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['uom'],'150',null,false,'1px dashed ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');    
            Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($totalcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');    
            Yii::$app->reporter->col(number_format($ton,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'200',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');    
        Yii::$app->reporter->endrow(); 
    
    }else{
        $totalcost = $data[$i]['balance'] * $data[$i]['cost'];
        $ton = $data[$i]['balance'] * $data[$i]['kilos'];
        
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px dashed ','','L','Century Gothic','10','','30px','8px');
            Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px dashed ','','L','Century Gothic','10','','30px','8px');
            Yii::$app->reporter->col($data[$i]['uom'],'150',null,false,'1px dashed ','','L','Century Gothic','10','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','30px','8px');    
            Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','30px','8px');
            Yii::$app->reporter->col(number_format($totalcost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Century Gothic','10','','30px','8px');    
            Yii::$app->reporter->col(number_format($ton,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'200',null,false,'1px solid ','','R','Century Gothic','10','','30px','8px');    
        Yii::$app->reporter->endrow();
    }  

     
	

    $gtotalcost = number_format($gtotalcost + $totalcost,Yii::$app->systemsettings->setDecimaldisplay('currency'));
    $gtotalton = number_format($gtotalton + $ton,Yii::$app->systemsettings->setDecimaldisplay('quantity'));



	$classgrp = $data[$i]['class'];

}

if ($gtotalcost!=0 || $gtotalton!=0){
    		Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','150',null,false,'1px dashed ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col('','300',null,false,'1px dashed ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col('','150',null,false,'1px dashed ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');    
            Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($gtotalcost,'200',null,false,'1px dashed ','T','R','Century Gothic','11','','30px','8px');    
            Yii::$app->reporter->col($gtotalton,'200',null,false,'1px dashed ','T','R','Century Gothic','11','','30px','8px');    
        	Yii::$app->reporter->endrow(); 
    	}



Yii::$app->reporter->startrow();
Yii::$app->reporter->col('','150',null,false,'1px dashed ','B','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','500',null,false,'1px dashed ','B','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','150',null,false,'1px dashed ','B','L','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','R','Century Gothic','11','B','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','R','Century Gothic','11','','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','R','Century Gothic','11','','30px','8px');
Yii::$app->reporter->col('','100',null,false,'1px dashed ','B','R','Century Gothic','11','B','30px','8px').'<br />';
Yii::$app->reporter->endrow();
    //Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>