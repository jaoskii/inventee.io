<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Order Report';
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
        Yii::$app->reporter->col('SALES ORDER','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'500',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('TERMS : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALESMAN : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['salesman'])? $data[0]['salesman']:''),'250',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('','470',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
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
    Yii::$app->reporter->col('','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QTY','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

        Yii::$app->reporter->col('BARCODE','150px',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','250px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('WHS CODE','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('NET PRICE','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

        

   $totalext=0;
   $wh='';

for($i=0;$i<count($data);$i++){


 


                
if ($wh==$data[$i]['whname']||$wh==''){
    $wh=''; 
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        if($data[$i]['insuffqty']==1){
            Yii::$app->reporter->col('<b>*</b>','30px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        }else{
            Yii::$app->reporter->col('<b></b>','30px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        }//end if
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['barcode'],'150px',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col($data[$i]['itemname'],'250px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['whname'],'50px',null,false,'1px solid ','','C','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col(number_format($data[$i]['gross'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
}else {
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50px',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','150px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','250px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','125px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($data[0]['rem'],'600',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','160',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    $totalext=0;



echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';


Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SALES ORDER','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'500',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('TERMS : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALESMAN : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['salesman'])? $data[0]['salesman']:''),'250',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('','470',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
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
        Yii::$app->reporter->col('','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QTY','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

        Yii::$app->reporter->col('BARCODE','150px',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','250px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('WHS CODE','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('NET PRICE','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

        
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        if($data[$i]['insuffqty']==1){
            Yii::$app->reporter->col('<b>*</b>','30px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        }else{
            Yii::$app->reporter->col('<b></b>','30px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        }//end if
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['barcode'],'150px',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col($data[$i]['itemname'],'250px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['whname'],'50px',null,false,'1px solid ','','C','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col(number_format($data[$i]['gross'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
}



        

        $wh=$data[$i]['whname'];

        $totalext=$totalext+$data[$i]['ext'];  
}   
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50px',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','150px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','250px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','125px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($data[0]['rem'],'600',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','160',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>
