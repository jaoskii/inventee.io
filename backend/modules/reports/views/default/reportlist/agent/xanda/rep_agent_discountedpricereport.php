<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Discounted Price Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=26;
$page=26;
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
        Yii::$app->reporter->col('DISCOUNTED PRICE REPORT',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

if ($params['agent']!=''){
    $agent = $params['agent'];
}else{
    $agent = 'ALL';
}


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Agent : '. $agent,800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');




Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SJ NO.','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CUSTOMER NAME','150',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DESCRIPTION','150',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('QTY SOLD','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('PRICE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DISC','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('NET PRICE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();


$docno="";
$cname="";

for($i=0;$i<count($data);$i++){


    if ($docno==$data[$i]['docno']){
        $docno="";
        $cname="";
    }else{
        $docno=$data[$i]['docno'];
        $cname=$data[$i]['clientname'];
    }

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($docno,'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($cname,'150',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['itemname'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['discount'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['net'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        
        $docno=$data[$i]['docno'];
        $cname=$data[$i]['clientname'];

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
        Yii::$app->reporter->col('DISCOUNTED PRICE REPORT',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

if ($params['agent']!=''){
    $agent = $params['agent'];
}else{
    $agent = 'ALL';
}


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Agent : '. $agent,800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');




Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SJ NO.','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CUSTOMER NAME','150',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DESCRIPTION','150',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('QTY SOLD','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('PRICE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DISC','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('NET PRICE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();

            $page=$page + $count;
        }
          
    }

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>