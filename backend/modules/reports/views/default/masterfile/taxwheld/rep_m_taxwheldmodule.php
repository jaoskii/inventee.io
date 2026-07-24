<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Tax Wheld Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('TAX WHELD','580',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','120',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'320',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('PERIOD : ','70',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col(' TO ','30',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid2'])? $data[0]['dateid2']:''),'150',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'720',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ACCOUNT CODE','150',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('ACCOUNT NAME','350',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('RATE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('INCOME','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('WHELD','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

        

   $totalrate=0;
   $totalincome=0;
   $totalwheld=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['acno'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['acnoname'],'350',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['rate'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['income'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['wheld'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        $totalrate=$totalrate+$data[$i]['rate'];
        $totalincome=$totalincome+$data[$i]['income'];
        $totalwheld=$totalwheld+$data[$i]['wheld'];
        
        
        
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
        Yii::$app->reporter->col('TAX WHELD','580',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','120',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'320',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('PERIOD : ','70',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col(' TO ','30',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid2'])? $data[0]['dateid2']:''),'150',null,false,'1px solid ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'720',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R P T I O N','475',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT PRICE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('(+/-) %','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->endrow();
               Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}   
 Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM(S)','100',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col($i,'50',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','350',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($totalrate,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($totalincome,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($totalwheld,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

   
    Yii::$app->reporter->printline();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>