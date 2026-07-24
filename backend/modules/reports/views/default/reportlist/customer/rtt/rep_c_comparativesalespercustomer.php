<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Comparative Sales per Customer';
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
echo '<br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('COMPARATIVE SALES PER CUSTOMER',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
Yii::$app->reporter->printline();

if ($params['category']!=''){
    $category = $params['category'];
}else{
    $category = 'ALL';
}

if ($params['agent']!=''){
    $agent = $params['agent'];
}else{
    $agent = 'ALL';
}

if ($params['class']!=''){
    $cla = $params['class'];
}else{
    $cla = 'ALL';
}

if ($params['area']!=''){
    $area = $params['area'];
}else{
    $area = 'ALL';
}


switch ($params['option']) {
    case 'amt':
        $opt='AMOUNT';
        break;
    case 'qty':
        $opt='QUANTITY';
        break; 
    case 'tons':
        $opt='TONS';
        break;          
    
    
}



        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Class : '.$cla,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Agent : '.$agent,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Category : '.$category,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Area : '.$area,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col(strtoupper($opt),300,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


// // //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('ADDRESS','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col($params['startdate'] .'<br>'. $params['enddate'],'100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col($params['rttstartdate'].'<br>'.$params['rttenddate'],'100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col($params['rttstartdate3'] .'<br>'. $params['rttenddate3'],'100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();

    
$totaluna=0;
$totalpangalawa=0;
$totalpangatlo=0;
for($i=0;$i<count($data);$i++){
            
    Yii::$app->reporter->startrow();

switch ($params['option']) {
    case 'amt':
        $display1 = number_format($data[$i]['una_amt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $display2 = number_format($data[$i]['pangalawa_amt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $display3 = number_format($data[$i]['pangatlo_amt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        break;
    case 'qty':
        $display1 = number_format($data[$i]['una_qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        $display2 = number_format($data[$i]['pangalawa_qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        $display3 = number_format($data[$i]['pangatlo_qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        break; 
    case 'tons':
        $display1 = number_format($data[$i]['una_tons'],3);
        $display2 = number_format($data[$i]['pangalawa_tons'],3);
        $display3 = number_format($data[$i]['pangatlo_tons'],3);
        break;          
    
    
}
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['code'],'150',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['clientname'],'350',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['addr'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($display1,'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($display2,'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($display3,'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
    Yii::$app->reporter->endrow();


    switch ($params['option']) {
        case 'amt':
            $totaluna = $totaluna + $data[$i]['una_amt'];
            $totalpangalawa = $totalpangalawa + $data[$i]['pangalawa_amt'];
            $totalpangatlo = $totalpangatlo + $data[$i]['pangatlo_amt'];
            break;
        case 'qty':
            $totaluna = $totaluna + $data[$i]['una_qty'];
            $totalpangalawa = $totalpangalawa + $data[$i]['pangalawa_qty'];
            $totalpangatlo = $totalpangatlo + $data[$i]['pangatlo_qty'];
            break; 
        case 'tons':
            $totaluna = $totaluna + $data[$i]['una_tons'];
            $totalpangalawa = $totalpangalawa + $data[$i]['pangalawa_tons'];
            $totalpangatlo = $totalpangatlo + $data[$i]['pangatlo_tons'];
            break;          
    }
    
    }


     Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('TOTAL','200',null,false,'1px dotted ','T','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totaluna,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalpangalawa,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalpangatlo,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>