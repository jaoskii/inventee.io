<?php
//JAOSKI REVISED : 12/16/2019 11:06:45 AM : MISSING UPDATE
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';

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
            Yii::$app->reporter->col('D E L I V E R Y &nbsp R E C E I P T','720',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('NO:','30',null,false,'1px solid ','','L','Century Gothic','13','B','','');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<span style = "line-height:9px;">';
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CUSTOMER : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'480',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('DATE : ','110',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'100',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('ADDRESS : ','115',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'420',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('JOB NO : ','90',null,false,'1px solid ','','R','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['mlcp_jonum'])? $data[0]['mlcp_jonum']:''),'120',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('TERMS : ','90',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'380',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('P.O. NO : ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'110',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</span>';

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CODE','50px',null,false,'1px solid ','BT','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('D E S C R I P T I O N','500px',null,false,'1px solid ','BT','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('QTY','50px',null,false,'1px solid ','BT','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('UNIT','50px',null,false,'1px solid ','BT','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('UNIT PRICE','125px',null,false,'1px solid ','BT','C','Century Gothic','12','B','30px','8px');
            
            Yii::$app->reporter->col('TOTAL','125px',null,false,'1px solid ','BT','C','Century Gothic','12','B','30px','8px');

   $totalext=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'50px',null,false,'1px solid ','','L','Century Gothic','11','','','');
        
        Yii::$app->reporter->col($data[$i]['itemname'],'500px',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        $totalext=$totalext+$data[$i]['ext'];
        
    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();


    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
           Yii::$app->reporter->col('D E L I V E R Y &nbsp R E C E I P T','540',null,false,'1px solid ','','L','Century Gothic','18','B','','');
            Yii::$app->reporter->col('DOCUMENT # :','180',null,false,'1px solid ','','L','Century Gothic','13','B','','');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'80',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CUSTOMER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'480',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('DATE : ','70',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'140',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('ADDRESS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'480',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('JOB NO : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['mlcp_jonum'])? $data[0]['mlcp_jonum']:''),'130',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('TERMS : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'480',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','30',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('P.O. NO : ','90',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'120',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();



    Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('CODE','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
    
    Yii::$app->reporter->col('D E S C R P T I O N','500px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('QTY','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('UNIT','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
    
    Yii::$app->reporter->col('UNIT PRICE','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('TOTAL','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->endrow();

    $page=$page + $count;
    }
}   

    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','500px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','125px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','50px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
      Yii::$app->reporter->endrow();

   
Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('1000');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(nl2br($data[0]['rem']),'50px',null,false,'1px dotted ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','500px',null,false,'1px dotted ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','125px',null,false,'1px dotted ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50px',null,false,'1px dotted ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','125px',null,false,'1px dotted ','','R','Century Gothic','12','B','','');
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('<div style="margin-top:-32px;">Received the above goods in good order and condition.</div>','400',null,false,'1px solid ','t','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('Note: This delivery receipt at the same time serves as temporary receipt. Our official invoice will be issued upon return of this receipt and fully signed by the customer.','600',null,false,'1px solid ','T','L','Century Gothic','12','','','');
        
    Yii::$app->reporter->endrow();
    // Yii::$app->reporter->endtable();
    echo '<br/>';

    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<div style="margin-top:-15px;">By :</div>','40',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($received,'180',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','570',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Signature over printed name','290',null,false,'1px solid ','T','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','459',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

echo "</div>";
?>