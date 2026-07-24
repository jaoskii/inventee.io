<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Trust Receipt';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
echo '<div style="margin-top:-15px;">';
Yii::$app->reporter->beginreport('850');

Yii::$app->reporter->begintable('720');
$loggeduser = Yii::$app->session['loggeduser']['name'];
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;&nbsp;'.strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Verdana','10','','','');
        Yii::$app->reporter->endrow();  
Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('720');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Verdana','18','B','','');
            Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Verdana','11','B','','');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'300',null,false,'1px solid ','','L','Verdana','11','','','').'<br />';
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('720');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('CUSTOMER : ','85',null,false,'1px solid ','','L','Verdana','11','','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'320',null,false,'1px dotted ','','L','Verdana','11','','30px','2x');
            Yii::$app->reporter->col('DATE : ','50',null,false,'1px solid ','','L','Verdana','11','','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px dotted ','','L','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('720');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('ADDRESS : ','100',null,false,'1px solid ','','L','Verdana','11','','30px','2px');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'620',null,false,'1px solid ','','L','Verdana','11','','30px','2px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<div id="details" style="height:280px;clear:both;margin-top:2px;">';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Verdana','10','','','2px');
            //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('650');

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('BARCODE','70',null,false,'0.1px dotted #999','B','C','Verdana','11','','30px','2px');
            Yii::$app->reporter->col('QTY','50',null,false,'0.1px dotted #999','B','C','Verdana','11','','ß','2px');
            Yii::$app->reporter->col('UNIT','80',null,false,'0.1px dotted #999','B','C','Verdana','11','','30px','2px');
            Yii::$app->reporter->col('DESCRPTION','340',null,false,'0.1px dotted #999','B','C','Verdana','11','','30px','2px');
            Yii::$app->reporter->col('PRICE','100',null,false,'0.1px dotted #999','B','C','Verdana','11','','30px','2px');
            Yii::$app->reporter->col('TOTAL','100',null,false,'0.1px dotted #999','B','C','Verdana','11','','30px','2px');

   $totalext=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'70',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],2),'50',null,false,'1px solid ','','R','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['uom'],'80',null,false,'1px solid ','','L','Verdana','11','','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'340',null,false,'1px solid ','','L','Verdana','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],2),'100',null,false,'1px solid ','','R','Verdana','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],2),'100',null,false,'1px solid ','','R','Verdana','11','','','2px');
        $totalext=$totalext+$data[$i]['ext'];
}   
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '</div>';
    Yii::$app->reporter->begintable('650');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'0.1px dotted #999','T','C','Verdana','11','B','','');
    Yii::$app->reporter->col('','50',null,false,'0.1px dotted #999','T','C','Verdana','11','B','','');
    Yii::$app->reporter->col('','80',null,false,'0.1px dotted #999','T','C','Verdana','11','B','','');
    Yii::$app->reporter->col('','320',null,false,'0.1px dotted #999','T','C','Verdana','11','B','','');
    Yii::$app->reporter->col('','100',null,false,'0.1px dotted #999','T','R','Verdana','11','B','','');
    Yii::$app->reporter->col(number_format($totalext,2),'100',null,false,'0.1px dotted #999','T','R','Verdana','11','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('650');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('NOTE : ','50',null,false,'1px solid ','','L','Verdana','11','B','','');
    Yii::$app->reporter->col('','570',null,false,'1px solid ','','L','Verdana','11','B','','');
        
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->begintable('650');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('Prepared By : ','200',null,false,'1px solid ','','L','Verdana','11','','','');
    Yii::$app->reporter->col('','99',null,false,'1px solid ','','L','Verdana','11','B','','');
    Yii::$app->reporter->col('Approved By :','200',null,false,'1px solid ','','L','Verdana','11','','','');
    Yii::$app->reporter->col('','99',null,false,'1px solid ','','L','Verdana','11','B','','');
    Yii::$app->reporter->col('Received By :','200',null,false,'1px solid ','','L','Verdana','11','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
  
    Yii::$app->reporter->begintable('650');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($prepared,'200',null,false,'0.1px dotted #999','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('','99',null,false,'0.1px dotted #999','','L','Verdana','11','B','','');
    Yii::$app->reporter->col($approved,'200',null,false,'0.1px dotted #999','B','C','Verdana','11','B','','');
    Yii::$app->reporter->col('','99',null,false,'0.1px dotted #999','','L','Verdana','11','B','','');
    Yii::$app->reporter->col($received,'200',null,false,'0.1px dotted #999','B','C','Verdana','11','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();
echo '</div>';
echo '</div>';

?>