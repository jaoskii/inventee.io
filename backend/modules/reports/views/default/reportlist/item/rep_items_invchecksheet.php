<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory Checksheet';
//WTODO: [KIM][2019.10.28][update inventory checksheet layout]
//WTODO: [KIM][2019.11.13][inventory checksheet][update layout for class]

try {
    
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=40;
$page=40;

Yii::$app->reporter->beginreport();

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Inventory Checksheet',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Warehouse : '.$params['wh'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
       
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
       
Yii::$app->reporter->endtable();
$totalbalqty=0;
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('WAREHOUSE/LOCATION','90',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CLASS','110',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('QUANTITY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CHECK','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('REMARKS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');


$whgrp="";
$loc = "";
$totalext=0;

for($i=0;$i<count ($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
    
          if (strtoupper($whgrp)==strtoupper($data[$i]['swh'])){
            if (strtoupper($loc)==strtoupper($data[$i]['loc'])){
                $whgrp="";  
                $loc="";  
            }else {
                $loc=strtoupper($data[$i]['loc']);
                $whgrp=strtoupper($data[$i]['swh']);  
            }  
          }  
          else {
            if (strtoupper($loc)==strtoupper($data[$i]['loc'])){
                $whgrp=strtoupper($data[$i]['swh']);
                $loc="";  
            }else {
                $loc=strtoupper($data[$i]['loc']);
                $whgrp=strtoupper($data[$i]['swh']);  
            }  
          }          

      
         $balance=number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
            if ($balance==0)
            {
            $balance='-';
            }

        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($whgrp,'90',null,false,'1px solid ','','L','Century Gothic','11','Bi','','');
        Yii::$app->reporter->col($loc,'110',null,false,'1px solid ','','L','Century Gothic','11','Bi','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','','','');
        
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','90',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['classname'],'110',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col($balance,'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('[&nbsp&nbsp&nbsp]','50',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','B','C','Century Gothic','11','','','');
        $whgrp=strtoupper($data[$i]['swh']);
        $loc=strtoupper($data[$i]['loc']);
        $totalbalqty=$totalbalqty+$data[$i]['balance'];
   
        
        
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

                Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Inventory Checksheet',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Warehouse : '.$params['wh'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
       
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('WAREHOUSE/LOCATION','90',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CLASS','110',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('QUANTITY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CHECK','50',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('REMARKS','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();
       Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}
  
Yii::$app->reporter->begintable('800');
echo '<br/>';
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','150',null,false,'1px solid ','TB','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('OVERALL STOCKS :','250',null,false,'1px solid ','TB','L','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','TB','R','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($totalbalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'120',null,false,'1px solid ','TB','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','40',null,false,'1px solid ','TB','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','R','Century Gothic','11','','','');
       
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();       

    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


} catch (ErrorException $e) {
    echo $e;
}
?>