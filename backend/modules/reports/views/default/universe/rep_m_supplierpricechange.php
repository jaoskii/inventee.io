<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Supplier Price Change Report';

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
        Yii::$app->reporter->col('SUPPLIER PRICE CHANGE','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CUSTOMER : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'180',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('DATE : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'240',null,false,'1px solid ','B','R','Century Gothic','12','','','');
            Yii::$app->reporter->col('EFFECT DATE : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['effectdate'])? $data[0]['effectdate']:''),'220',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


    Yii::$app->reporter->printline();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','110',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('DESCRIPTION','140',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('UNIT','70',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('PREV COST','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('PREV DISC','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('PRIV NET','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('NEW COST','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('NEW DISC','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('NEW NET','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            $totalext=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();


           Yii::$app->reporter->col($data[$i]['barcode'],'110',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
            Yii::$app->reporter->col($data[$i]['itemname'],'140',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
            Yii::$app->reporter->col($data[$i]['uom'],'70',null,false,'1px solid ','','C','Century Gothic','12','','30px','8px');
            
            Yii::$app->reporter->col(number_format($data[$i]['rrcost2'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'80',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
            Yii::$app->reporter->col((isset($data[0]['disc2'])? $data[0]['disc2']:''),'80',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['ext2'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'80',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'80',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
            Yii::$app->reporter->col((isset($data[0]['disc'])? $data[0]['disc']:''),'80',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'80',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');

        // Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
  
        $totalext=$totalext+1;
        
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
        Yii::$app->reporter->col('SUPPLIER PRICE CHANGE','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CUSTOMER : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'180',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('DATE : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'240',null,false,'1px solid ','B','R','Century Gothic','12','','','');
            Yii::$app->reporter->col('EFFECT DATE : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['effectdate'])? $data[0]['effectdate']:''),'220',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('TERMS : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

    Yii::$app->reporter->printline();

    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','110',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('DESCRIPTION','140',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('UNIT','70',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('PREV COST','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('PREV DISC','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('PRIV NET','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('NEW COST','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('NEW DISC','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('NEW NET','80',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->printline();
    $page=$page + $count;
    }
}   

    Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('TOTAL ITEMS: ','110',null,false,'1px solid ','T','L','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'140',null,false,'1px solid ','T','L','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('','70',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(' ','80',null,false,'1px solid ','T','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(' ','80',null,false,'1px solid ','T','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(' ','80',null,false,'1px solid ','T','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(' ','80',null,false,'1px solid ','T','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(' ','80',null,false,'1px solid ','T','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(' ','80',null,false,'1px solid ','T','R','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('NOTE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','160',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
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


?>