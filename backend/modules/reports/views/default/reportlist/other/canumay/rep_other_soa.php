<?php
 //DESCRIPTION:Buong Report
date_default_timezone_set('Asia/Manila');
$this->title = 'Statement Of Account';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport();
echo '<div style="letter-spacing: 2.5px;">';
Yii::$app->reporter->begintable('800');
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/></br></br></br>';
//CLIENTNAME | DATE
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','45',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'555',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col('&nbsp','30',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['asof'])),'170',null,false,'1px solid ','','R','Courier New','14','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
//ADDRESS | DOC #
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','45',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col((isset($data[0]['addr'])? $data[0]['addr']:''),'555',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col('&nbsp;','30',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col('&nbsp;','170',null,false,'1px solid ','','R','Courier New','14','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Courier New','14','B','','');
        // Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
 Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();

//DETAIL
$balance=0;
$datacount=0;
 for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('&nbsp;','150',null,false,'1px solid ','','C','Courier New','14','B','','2px');
        Yii::$app->reporter->col($data[$i]['docdate'],'400',null,false,'1px solid ','','L','Courier New','14','B','','2px');
        Yii::$app->reporter->col('&nbsp;','120',null,false,'1px solid ','','R','Courier New','14','B','','2px');
        Yii::$app->reporter->col($data[$i]['refno'],'50',null,false,'1px solid ','','R','Courier New','14','B','','2px');
        Yii::$app->reporter->col('&nbsp;','30',null,false,'1px solid ','','R','Courier New','14','B','','2px');
        Yii::$app->reporter->col('<span style="margin-right:-45px;">'.number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</span>','50',null,false,'1px solid ','','R','Courier New','14','B','','');
     
       if($data[$i]['debit']!=0){
           $balance = $balance + $data[$i]['balance'];
          }else{
           $balance = $balance - $data[$i]['balance'];
        }  
        
 if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();


    Yii::$app->reporter->begintable('800');
Yii::$app->reporter->endtable();
//HEAD AGAIN
echo '<br/><br/></br></br></br>';
//CLIENTNAME | DATE
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','45',null,false,'1px solid ','','L','Courier New','14','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'555',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col('&nbsp','30',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['asof'])),'170',null,false,'1px solid ','','R','Courier New','14','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
//ADDRESS | DOC #
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','45',null,false,'1px solid ','','L','Courier New','14','B','','4px');
        Yii::$app->reporter->col((isset($data[0]['addr'])? $data[0]['addr']:''),'555',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col('&nbsp;','30',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->col('&nbsp;','170',null,false,'1px solid ','','R','Courier New','14','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Courier New','14','B','','4px');
        // Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


    //
 Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','14','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

        $page=$page + $count;
    }
     $datacount++;
}   

     
       //TOTAL NET AMOUNT
   Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','750',null,false,'1px dotted ','','R','Courier New','14','B','','');
    Yii::$app->reporter->col('<span style="margin-right:-45px;">'.number_format($balance,Yii::$app->systemsettings->setDecimaldisplay('currency')).'</span>','50',null,false,'1px dotted ','','R','Courier New','14','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 

     //
    for($i=0;$i<=2;$i++){
     Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','14','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    }

    //NOTE
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','150',null,false,'1px dotted ','','C','Courier New','14','B','','');
    Yii::$app->reporter->col(isset($params['attention'])?$params['attention']:'&nbsp;','400',null,false,'1px dotted ','','L','Courier New','14','B','','');
    Yii::$app->reporter->col('&nbsp;','150',null,false,'1px dotted ','','C','Courier New','14','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','R','Courier New','14','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','R','Courier New','14','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
echo '</div>';
        Yii::$app->reporter->endreport();
   //LINE 154

?>