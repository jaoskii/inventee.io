<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';
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
                    Yii::$app->reporter->col('CONSIGNMENT RECEIPT','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
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
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('TERMS : ','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('SALESMAN : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col((isset($data[0]['agent'])? $data[0]['agent']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('','150',null,false,'1px solid ','','R','Century Gothic','12','','','');
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
            Yii::$app->reporter->col('QTY','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('UNIT','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('BARCODE','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('D E S C R P T I O N','500px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('UNIT PRICE','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('TOTAL','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

   $totalext=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['barcode'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'500px',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['discountedamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        $totalext=$totalext+$data[$i]['ext'];
        
}   

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','50px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','500px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','125px',null,false,'1px dotted ','T','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('GRAND TOTAL :','50px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'125px',null,false,'1px dotted ','T','R','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','70',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('<b>ALL PAYMENTS SHOULD BE ISSUED IN CHECKS PAYABLE TO Xanda Traders AND MUST BE CROSSED CHECKS.</b> &nbsp Check payments are not','570',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

     Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('considered payments unless cleared by the company`s bank. We will not be responsible for any alleeged cash or check payments never received by our company.
                            &nbsp;&nbsp;Seller reserves the right to pull-out merchandise unless fully paid.','800',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('It is understood that the above merchandise remains the property of <b>Xanda Traders</b>. until fully paid for and consignee agrees to
                assume complete responsibility in case of lost due to fire, theft, etc. Interest at a rate of 24% per annum will be charged on all overdue accounts. Consignee agrees to submit the jurisdiction
                of the Court of Cebu or Suburban area should any legal action  arise of this transaction. An additional sum of twenty-five percent (25%) of the amount due will be charged to consignee as attorney`s fees and cost of collection.','800',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Received the above goods in good order and condition subject to the terms and condition of stipulated hereon.','800',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','266',null,false,'1px solid ','B','C','Century Gothic','12','','','');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','266',null,false,'1px solid ','B','R','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('Customer`s Name & Signature','266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('Checker`s Name & Signature','266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/>';
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('Date : _______________________________','266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','B','','');
    Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();


?>