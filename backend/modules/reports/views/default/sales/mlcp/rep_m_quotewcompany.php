<?php
//WTODO: [KIM][2019.09.20][quotewcompany layout]
date_default_timezone_set('Asia/Manila');
$this->title = 'Quotation Report';
//WTODO: [KIM][2019.11.28][update layout for quotation]
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
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('DATE ','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col(': '.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'250',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
       
        Yii::$app->reporter->col('QUOTATION NO ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col(': '.(isset($data[0]['docno'])? $data[0]['docno']:''),'250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ATTN : '.(isset($data[0]['contact'])? $data[0]['contact']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['tel'])? $data[0]['tel']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Sir/Miss/Madam : ','800',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('We are pleased to submit to you our price quotation for the following items :','750',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','500px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('MINIMUM ORDER','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('PRICE','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');

   $totalext=0;
  
for($i=0;$i<count($data);$i++){

    if($data[$i]['isqty'] == ""){
        $isqty = $data[$i]['isqty'];
    }else{
        $isqty = $data[$i]['isqty'];
    }

    if($data[$i]['isamt'] == ""){
        $amt = $data[$i]['isamt'];
    }else{
        $amt = $data[$i]['isamt'];
    }

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['item'],'50px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['itemname'],'500px',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($isqty,'125px',null,false,'1px solid ','','C','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($amt,'125px',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
       
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('DATE ','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col(': '.(isset($data[0]['dateid'])? $data[0]['dateid']:''),'250',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
       
        Yii::$app->reporter->col('QUOTATION NO ','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col(': '.(isset($data[0]['docno'])? $data[0]['docno']:''),'250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ATTN : '.(isset($data[0]['contact'])? $data[0]['contact']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['tel'])? $data[0]['tel']:''),'350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Sir/Miss/Madam : ','800',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('We are pleased to submit to you our price quotation for the following items :','750',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM','50px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('D E S C R I P T I O N','500px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('MINIMUM ORDER','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('PRICE','125px',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
       
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}   
      

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('All prices are based on material cost at the time of quotation and are subject to change without prior notice.','760',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Quoted By : ','350',null,false,'1px solid ','','L','Century Gothic','12','','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($quoted,'250',null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Approved By :','350',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
     echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'250',null,false,'1px solid ','T','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','350',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($position,'250',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>