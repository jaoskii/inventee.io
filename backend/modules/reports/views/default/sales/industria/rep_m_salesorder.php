<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Client Order Sheet';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
echo "<div class='pull-left'>"; 
echo "<img style='width:350px;' src='".Yii::$app->homeUrl . "fimages/reportheaders/industria.jpg'><br>";
echo "<center><label style='font-weight:normal;font-family:Brooklyn Light;font-size:15px;letter-spacing:5px;'>www.industriaedition.com</label></center>";
echo "</div>";

echo "<div class='pull-right'>
<label class='pull-right' style='font-family:Brooklyn Light;font-size:17px;letter-spacing:1px;'>INDUSTRIA EDITION GALLERY, INC.</label><br>
<label class='pull-right' style='font-weight:normal;font-family:Brooklyn Light;font-size:15px;letter-spacing:1px;'>Mobile Nos. 0917-6281928 Globe / 0939-9361922 Smart</label><br>
<label class='pull-right' style='font-weight:normal;font-family:Brooklyn Light;font-size:15px;letter-spacing:1px;'>Email : gallery@industriaedition.com</label><br>
<label class='pull-right' style='font-weight:normal;font-family:Brooklyn Light;font-size:15px;letter-spacing:1px;'>galleryinfo@industriaedition.com</label>
</div>";
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CLIENT ORDER SHEET&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp','600',null,false,'1px solid ','','R','Century Gothic','18','B','','');
        Yii::$app->reporter->col('COS # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'500',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('&nbsp ','20',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('DATE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','80',null,false,'1px solid ','','L','Century Gothic','12','B','10px','2px');
        Yii::$app->reporter->col('&nbsp','500',null,false,'1px solid ','','L','Century Gothic','12','','10px','2px');
        Yii::$app->reporter->col('&nbsp','20',null,false,'1px solid ','','L','Century Gothic','12','B','10px','2px');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

$ddate = '';
$pdate = '';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','70',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'450',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('&nbsp ','10',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        
        if($data[0]['rtype'] == 'PICKUP'){
            $pdate = $data[0]['rdate'];
            Yii::$app->reporter->col('x','10',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','','13px');
            Yii::$app->reporter->col('Pick up','40',null,false,'1px solid ','','R','Century Gothic','12','','','');
            Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','B','','0px');
            Yii::$app->reporter->col('','10',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','','13px');
            Yii::$app->reporter->col('Delivery','40',null,false,'1px solid ','','R','Century Gothic','12','','','');
        }elseif($data[0]['rtype'] == 'DELIVERY'){
            $ddate = $data[0]['rdate'];
            Yii::$app->reporter->col('','10',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','','13px');
            Yii::$app->reporter->col('Pick up','40',null,false,'1px solid ','','R','Century Gothic','12','','','');
            Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','B','','0px');
            Yii::$app->reporter->col('x','10',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','','13px');
            Yii::$app->reporter->col('Delivery','40',null,false,'1px solid ','','R','Century Gothic','12','','','');
        }else{
            Yii::$app->reporter->col('','10',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','','13px');
            Yii::$app->reporter->col('Pick up','40',null,false,'1px solid ','','R','Century Gothic','12','','','');
            Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','12','B','','0px');
            Yii::$app->reporter->col('','10',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','','13px');
            Yii::$app->reporter->col('Delivery','40',null,false,'1px solid ','','R','Century Gothic','12','','','');
        }//end if
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CONTACT# : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['tel2']:''),'500',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('&nbsp ','20',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('Pick up Date:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($pdate,'100',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('EMAIL : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['email']:''),'500',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('&nbsp ','20',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('Delivery Date:','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($ddate,'100',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R P T I O N','400',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('UNIT PRICE','100',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
$totalext=0;

for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','LBR','L','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','RB','C','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','RB','L','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col($data[$i]['itemname'],'400',null,false,'1px solid ','RB','L','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col(number_format($data[$i]['gross'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','RB','R','Century Gothic','12','','30px','8px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','RB','R','Century Gothic','12','','30px','8px');
        $totalext=$totalext+$data[$i]['ext'];  
}//END F0R EACH

Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('TOTAL:','100',null,false,'1px solid ','RLBT','L','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','BT','C','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','BT','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','400',null,false,'1px solid ','BT','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','BT','R','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','BTLR','R','Century Gothic','12','B','30px','8px');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Special Remarks:','400',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[0]['rem'],'800',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','400',null,false,'1px solid ','B','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','B','C','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','B','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','R','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','R','Century Gothic','12','','30px','8px');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('MODE OF PAYMENT','400',null,false,'1px solid ','','L','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','400',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','12','','30px','8px');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','15',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('CASH','145',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('Amount:','100',null,false,'1px solid ','','R','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','L','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('Acknowledgment Receipt No:','200',null,false,'1px solid ','','R','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','150',null,false,'1px solid ','B','L','Century Gothic','12','','30px','0px');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','15',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('CHEQUE','145',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('Details:','100',null,false,'1px solid ','','R','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','L','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('Collection Receipt No:','200',null,false,'1px solid ','','R','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','150',null,false,'1px solid ','B','L','Century Gothic','12','','30px','0px');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','15',null,false,'1px solid ','BTLR','L','Century Gothic','12','B','30px','8px');
    Yii::$app->reporter->col('CREDIT CARD','145',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('Trace#:','100',null,false,'1px solid ','','R','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','B','L','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('Sales Invoice No:','200',null,false,'1px solid ','','R','Century Gothic','12','','30px','0px');
    Yii::$app->reporter->col('','150',null,false,'1px solid ','B','L','Century Gothic','12','','30px','0px');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Prepared By : ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('CONFIRMED BY:','400',null,false,'1px solid ','','R','Century Gothic','15','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('&nbsp','300',null,false,'1px solid ','','R','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col($received,'300',null,false,'1px solid ','','R','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Checked and Approved by : ','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col($approved,'200',null,false,'1px solid ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('Client`s Signature over Printed Name/Date','300',null,false,'1px solid ','T','R','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


/*
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
Yii::$app->reporter->endtable();*/
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>