<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Order Report';
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
        Yii::$app->reporter->col('PURCHASE ORDER','580',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','120',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('TERMS : ','60',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'140',null,false,'1px solid ','B','R','Century Gothic','12','','','');
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
        Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R P T I O N','475',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT PRICE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('(+/-) %','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

        

   $totalext=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','13','B','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','C','Century Gothic','13','B','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','13','B','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'475',null,false,'1px solid ','','L','Century Gothic','13','B','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['netamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','13','B','','2px');
        Yii::$app->reporter->col($data[$i]['disc'],'75',null,false,'1px solid ','','C','Century Gothic','13','B','','');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','13','B','','2px');
        $totalext=$totalext+$data[$i]['ext'];
        
        
        
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
        Yii::$app->reporter->col('PURCHASE ORDER','580',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','120',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('TERMS : ','60',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'140',null,false,'1px solid ','B','R','Century Gothic','12','','','');
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

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM(S)','50',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col($i,'50',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','440',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','110',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','60',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($data[0]['rem'],'600',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','140',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Checked By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'257',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','15',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'260',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','12',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received2,'260',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received3,'260',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','12',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received4,'260',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($approved,'257',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','15',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','260',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','12',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','260',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>