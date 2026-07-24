<?php

date_default_timezone_set('Asia/Manila');
$this->title = 'Pick Slip';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
echo '<span class="header"></span>';
Yii::$app->reporter->endtable();

// echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('PICK SLIP','600',null,false,'1px solid ','','L','Helvetica','18','B','','');
        Yii::$app->reporter->col('REF ID:','80',null,false,'1px solid ','','L','Helvetica','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'120',null,false,'1px solid ','B','L','Helvetica','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER : ','100',null,false,'1px solid ','','L','Helvetica','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'500',null,false,'1px solid ','B','L','Helvetica','12','','30px','4px');
                 $dateid = date_create($data[0]['dateid']);
        $dateid = date_format($dateid,'m-d-Y');
        Yii::$app->reporter->col('DATE : ','80',null,false,'1px solid ','','L','Helvetica','12','B','','');
        Yii::$app->reporter->col($dateid,'120',null,false,'1px solid ','B','R','Helvetica','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
// Yii::$app->reporter->begintable('800');
//         Yii::$app->reporter->startrow();
//         Yii::$app->reporter->col('ADDRESS : ','100',null,false,'1px solid ','','L','Helvetica','12','B','30px','4px');
//         Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'500',null,false,'1px solid ','B','L','Helvetica','12','','30px','4px');
//         Yii::$app->reporter->col('TERMS : ','80',null,false,'1px solid ','','L','Helvetica','12','B','','');
//         Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'120',null,false,'1px solid ','B','R','Helvetica','12','','','');
//         Yii::$app->reporter->endrow();
// Yii::$app->reporter->endtable();

// Yii::$app->reporter->begintable('800');
//         Yii::$app->reporter->startrow();
//         Yii::$app->reporter->col(' ','80',null,false,'1px solid ','','L','Helvetica','12','B','30px','4px');
//         Yii::$app->reporter->col('','500',null,false,'1px solid ','','L','Helvetica','12','','30px','4px');
//         Yii::$app->reporter->col('PICKER: ','50',null,false,'1px solid ','','L','Helvetica','12','B','','');
//         Yii::$app->reporter->col('','150',null,false,'1px solid ','B','R','Helvetica','12','','','');
//         Yii::$app->reporter->endrow();
// Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Helvetica','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

// Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','600',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('BIN &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp NOTES','200',null,false,'1px solid ','B','L','Helvetica','12','B','30px','8px');

        

   $totalext=0;

for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','C','Helvetica','14','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Helvetica','14','','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'600',null,false,'1px solid ','','L','Helvetica','14','','','2px');
        Yii::$app->reporter->col($data[$i]['bin'],'200',null,false,'1px solid ','','L','Helvetica','14','','','2px');
        
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALES INVOICE','600',null,false,'1px solid ','','L','Helvetica','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Helvetica','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Helvetica','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER : ','80',null,false,'1px solid ','','L','Helvetica','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','B','L','Helvetica','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','40',null,false,'1px solid ','','L','Helvetica','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Helvetica','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Helvetica','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'500',null,false,'1px solid ','B','L','Helvetica','12','','30px','4px');
        Yii::$app->reporter->col('TERMS : ','50',null,false,'1px solid ','','L','Helvetica','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','B','R','Helvetica','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Helvetica','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','600',null,false,'1px solid ','B','L','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->col('BIN &nbsp NOTES','200',null,false,'1px solid ','B','L','Helvetica','12','B','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}   
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','C','Helvetica','14','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','T','C','Helvetica','14','B','','');
        Yii::$app->reporter->col('','600',null,false,'1px dotted ','T','C','Helvetica','14','B','','');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','C','Helvetica','14','B','','');
        Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();

    // Yii::$app->reporter->printline();
      echo '<br/>';
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','50',null,false,'1px solid ','','L','Helvetica','12','B','','');
        Yii::$app->reporter->col($data[0]['rem'],'600',null,false,'1px solid ','','L','Helvetica','12','','','');
        Yii::$app->reporter->col('','160',null,false,'1px solid ','','L','Helvetica','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/>';
    // Yii::$app->reporter->begintable('800');
    //     Yii::$app->reporter->startrow();
    //     Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Helvetica','12','','','');
    //     Yii::$app->reporter->col('Picked By :','266',null,false,'1px solid ','','C','Helvetica','12','','','');
    //     Yii::$app->reporter->col('Checked By :','266',null,false,'1px solid ','','R','Helvetica','12','','','');
    //     Yii::$app->reporter->endrow();
    // Yii::$app->reporter->endtable();
    
    // // echo '<br/>';
    // Yii::$app->reporter->begintable('800');
    //     Yii::$app->reporter->startrow();
    //     Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Helvetica','12','B','','');
    //     Yii::$app->reporter->col($picked,'266',null,false,'1px solid ','','C','Helvetica','12','B','','');
    //     Yii::$app->reporter->col($checked,'266',null,false,'1px solid ','','R','Helvetica','12','B','','');
    //     Yii::$app->reporter->endrow();
    // Yii::$app->reporter->endtable();


        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','120',null,false,'1px solid ','','R','Helvetica','12','','','');
        Yii::$app->reporter->col($prepared,'120',null,false,'1px solid ','','L','Helvetica','12','B','','');
        Yii::$app->reporter->col('Picked By :','120',null,false,'1px solid ','','R','Helvetica','12','','','');
        Yii::$app->reporter->col($picked,'120',null,false,'1px solid ','','L','Helvetica','12','B','','');
        Yii::$app->reporter->col('Checked By :','120',null,false,'1px solid ','','R','Helvetica','12','','','');
        Yii::$app->reporter->col($checked,'120',null,false,'1px solid ','','L','Helvetica','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>