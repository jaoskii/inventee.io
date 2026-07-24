<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Non-Vat SI';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;
echo '<div style="margin-top:-15px;">';
Yii::$app->reporter->beginreport('850');
echo '<div style="margin-left:-20px;">';
Yii::$app->reporter->begintable('870');
$loggeduser = Yii::$app->session['loggeduser']['name'];
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;&nbsp;'.strtoupper($loggeduser).' '.date('m/d/Y h:i:s a',time()) . '&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Verdana','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col('','70',null,false,'1px solid ','','L','Verdana','12','B','10px','');
            Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'80',null,false,'1px solid ','','R','Verdana','12','B','','');
            Yii::$app->reporter->col('','90',null,false,'1px solid ','','L','Verdana','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    if ($data[0]['ref'] == ""){
    Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'70',null,false,'1px solid ','','L','Verdana','12','B','10px','');
            Yii::$app->reporter->col('','80',null,false,'1px solid ','','L','Verdana','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'90',null,false,'1px solid ','','L','Verdana','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    } else {
    Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'70',null,false,'1px solid ','','L','Verdana','12','B','10px','');
            Yii::$app->reporter->col((isset($data[0]['ref'])? $data[0]['ref']:''),'80',null,false,'1px solid ','','R','Verdana','12','B','','');
            Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'150',null,false,'1px solid ','','L','Verdana','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
}

    Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'70',null,false,'1px solid ','','L','Verdana','12','B','10px','');
            Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'80',null,false,'1px solid ','','L','Verdana','12','B','','');
            Yii::$app->reporter->col((isset($data[0]['terms'])? $data[0]['terms']:''),'90',null,false,'1px solid ','','L','Verdana','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
   

    Yii::$app->reporter->begintable('900');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','12','','10px','');
            Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'150',null,false,'1px solid ','','L','Verdana','12','B','10px','');
            Yii::$app->reporter->col('','5',null,false,'1px solid ','','L','Verdana','12','','','');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Verdana','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


Yii::$app->reporter->endtable();

echo '<div id="details" style="height:220px;clear:both;margin-top:2px;">';
echo '<br>';
    Yii::$app->reporter->begintable('720');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Verdana','12','','30px','8px');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','C','Verdana','12','','30px','8px');
            Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Verdana','12','','30px','8px');
            Yii::$app->reporter->col('','220',null,false,'1px solid ','','C','Verdana','12','','30px','8px');
            Yii::$app->reporter->col('','60',null,false,'1px solid ','','C','Verdana','12','','30px','8px');
            Yii::$app->reporter->col('','60',null,false,'1px solid ','','C','Verdana','12','','30px','8px');
            Yii::$app->reporter->col('','40',null,false,'1px solid ','','C','Verdana','12','','30px','8px');
            
   $totalext=0;
   $totalqty=0;
   
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('','5',null,false,'1px solid ','','C','Verdana','11','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['qty']),'40',null,false,'1px solid ','','C','Verdana','11','','','1px');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Verdana','11','','','1px');
        Yii::$app->reporter->col($data[$i]['itemname'],'220',null,false,'1px solid ','','L','Verdana','11','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['amt'],2),'60',null,false,'1px solid ','','R','Verdana','11','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],2),'60',null,false,'1px solid ','','R','Verdana','11','','','1px');
        
        $totalext=$totalext+$data[$i]['ext'];
        $totalqty=$totalqty+$data[$i]['qty'];
}   

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','5',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col(number_format($totalqty),'40',null,false,'1px dotted ','T','C','Verdana','12','','','');
    Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('TOTAL :','220',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','60',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col(number_format($totalext,2),'60',null,false,'1px dotted ','T','R','Verdana','12','','','');
    
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->endtable();

    

echo '</div><br/>';
    
    if ($data[0]['rem'] == ""){
        echo '<br/>';
    } else {
    Yii::$app->reporter->begintable('720');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','80',null,false,'1px dotted ','','C','Verdana','12','','','');
        Yii::$app->reporter->col('** '.$data[0]['rem'],'640',null,false,'1px dotted ','','L','Verdana','11','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    }

    echo '<br/>';

    Yii::$app->reporter->begintable('720');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','5',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','40',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','30',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col(number_format($totalext,2),'170',null,false,'1px dotted ','','R','Verdana','12','','30px','1px');
    Yii::$app->reporter->col('','60',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','60',null,false,'1px dotted ','','R','Verdana','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    echo '<br/><br/><br/><br/><br/>';

    Yii::$app->reporter->begintable('720');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','5',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','40',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','30',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('','60',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->col('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.number_format($totalext,2),'60',null,false,'1px dotted ','','C','Verdana','12','','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    
 
Yii::$app->reporter->endreport();
echo '</div>';
echo '</div>';

?>