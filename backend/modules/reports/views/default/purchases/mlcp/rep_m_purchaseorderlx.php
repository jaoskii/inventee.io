<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Order Report';
//WTODO: [KIM][2019.11.15][update layout purchase order lx]
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;
echo "<div style='letter-spacing: 5px'>";
Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('P U R C H A S E &nbsp O R D E R','540',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','180',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'80',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'460',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'120',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'460',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('TERMS : ','90',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'110',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CODE','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','375',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('PURCHASE DATE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT PRICE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('NET PRICE','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        

   $totalext=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();

        $date = Yii::$app->sbccommon->opentable("select left(rrstatus.dateid,11) as dateid,rrstatus.itemid,
                                                    item.itemname from glhead as head
                                                left join rrstatus on rrstatus.trno = head.trno
                                                left join item on item.itemid = rrstatus.itemid
                                                where head.doc = 'RR' and item.barcode = '".$data[$i]['barcode']."'
                                                order by rrstatus.dateid desc limit 1");
       
       if($date){
       
        $date=$date[0]['dateid'];
       }
       else{
         $date='';
       }
        

        Yii::$app->reporter->col($data[$i]['barcode'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'375',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
         Yii::$app->reporter->col($date,'100',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['netamt'],Yii::$app->systemsettings->setDecimaldisplay('unitprice')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format(Yii::$app->sbccommon->Discount(floatval($data[$i]['netamt']),$data[$i]['disc']),Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        $totalext=$totalext+$data[$i]['ext'];
        
        
        
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

 Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('P U R C H A S E &nbsp O R D E R','540',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','180',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'80',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SUPPLIER : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'460',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'120',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','130',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'460',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('TERMS : ','90',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'110',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('CODE','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','375',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('PURCHASE DATE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT PRICE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('NET PRICE','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
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
        Yii::$app->reporter->col('','315',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
         Yii::$app->reporter->col('','125',null,false,'1px dotted ','T','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('GRAND ','100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('TOTAL :','110',null,false,'1px dotted ','T','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
       
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($data[0]['rem'],'580',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','140',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Requested By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();
echo "</div>";

?>