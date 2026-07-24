
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
echo '<div style="letter-spacing: 2px;">';
Yii::$app->reporter->begintable('800');
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/></br></br>';
   //CLIENTNAME | DATE
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;','65',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['clientname'])? $data[0]['clientname']:''):'&nbsp;','555',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp;','10',null,false,'1px solid ','','L','Courier New','12','B','','');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['dateid'])? $data[0]['dateid']:''):'&nbsp;','170',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    //ADDRESS | DOC #
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;','65',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['address'])? $data[0]['address']:''):'&nbsp;','555',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp;','10',null,false,'1px solid ','','L','Courier New','12','B','','');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['yourref'])? $data[0]['yourref']:''):'&nbsp;','170',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    //SHIPTO | 
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;','65',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['shipto'])? $data[0]['shipto']:''):'&nbsp','550',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp;','10',null,false,'1px solid ','','L','Courier New','12','B','','');
            Yii::$app->reporter->col('&nbsp;','170',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Courier New','12','B','','4px');
        // Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

    //
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    //DETAIL
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
           
   $totalext=0;
   $totalnet=0;
   $datacount=0;
    for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($outputtype=='items'? number_format($data[$i]['qty']):'&nbsp;','50',null,false,'1px solid ','','L','Courier New','12','B','','2px');
        Yii::$app->reporter->col($outputtype=='items'?$data[$i]['uom']:'&nbsp;','60',null,false,'1px solid ','','L','Courier New','12','B','','2px');
        Yii::$app->reporter->col('&nbsp;','15',null,false,'1px solid ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col($outputtype=='items'?$data[$i]['itemname']:'&nbsp;','460',null,false,'1px solid ','','L','Courier New','12','B','','2px');
        Yii::$app->reporter->col($outputtype=='withvalue'?'<span style="margin-right:-10px;">'.number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</span>':'&nbsp;','150',null,false,'1px solid ','','R','Courier New','12','B','','2px');
        Yii::$app->reporter->col('&nbsp;','5',null,false,'1px solid ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col($outputtype=='withvalue'?'<span style="margin-right:-60px;">'.number_format($data[$i]['qty']*$data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</span>':'&nbsp;','50',null,false,'1px solid ','','R','Courier New','12','B','','2px');

        $totalext=$totalext+$data[$i]['ext'];
        $totalnet=$totalnet+$data[$i]['qty']*$data[$i]['amt'];
    if(Yii::$app->reporter->linecounter==$page){
    

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->page_break();


    Yii::$app->reporter->begintable('800');
Yii::$app->reporter->endtable();

//HEAD AGAIN
echo '<br/><br/></br></br>';
   //CLIENTNAME | DATE
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;','45',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['clientname'])? $data[0]['clientname']:''):'&nbsp;','555',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp;','30',null,false,'1px solid ','','L','Courier New','12','B','','');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['dateid'])? $data[0]['dateid']:''):'&nbsp;','170',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    //ADDRESS | DOC #
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;','45',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['address'])? $data[0]['address']:''):'&nbsp;','555',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp;','30',null,false,'1px solid ','','L','Courier New','12','B','','');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['docno'])? $data[0]['docno']:''):'&nbsp;','170',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    //SHIPTO | 
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp;','45',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col($outputtype=='items'?(isset($data[0]['shipto'])? $data[0]['shipto']:''):'&nbsp','550',null,false,'1px solid ','','L','Courier New','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp;','30',null,false,'1px solid ','','L','Courier New','12','B','','');
            Yii::$app->reporter->col('&nbsp;','170',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


    // Yii::$app->reporter->printline();

    //
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();  
    $page=$page + $count;
    }


    $datacount++;
}   

    //TOTAL AMOUNT
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','450',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','150',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->col($outputtype=='withvalue'?'<span style="margin-right:-60px;">'.number_format($totalnet,Yii::$app->systemsettings->setDecimaldisplay('currency')).'</span>':'&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();   

    //DISCOUNT
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','450',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','150',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->col($outputtype=='withvalue'?'<span style="margin-right:-60px;">'.$data[0]['disc'].'</span>':'&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 
 
    //CASE RETURN SALES
    if($data[0]['less']!=0){
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','450',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','150',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->col($outputtype=='withvalue'?'<span style="margin-right:-60px;">'.number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')).'</span>':'&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 

    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','450',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col($outputtype=='withvalue'?'LESS =)':'&nbsp;','100',null,false,'1px dotted ','','L','Courier New','12','B','','');
    Yii::$app->reporter->col($outputtype=='withvalue'?number_format($data[0]['less'],Yii::$app->systemsettings->setDecimaldisplay('currency')):'&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    $datacount=$datacount+2;
    }

    $totalext = $totalext - $data[0]['less'];

    //TOTAL AMOUNT
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','50',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','450',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dotted ','','C','Courier New','12','B','','');
    Yii::$app->reporter->col('&nbsp;','100',null,false,'1px dotted ','','L','Courier New','12','B','','');
    Yii::$app->reporter->col($outputtype=='withvalue'?'<span style="margin-right:-60px;">'.number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')).'</span>':'&nbsp;','50',null,false,'1px dotted ','','R','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    //
    for($i=0;$i<=2;$i++){
     Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    }

    //NOTE
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','150',null,false,'1px solid ','','L','Courier New','12','B','','');
    Yii::$app->reporter->col($outputtype=='items'?$data[0]['rem']:'&nbsp;','650',null,false,'1px solid ','','L','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    //SPACING
    for($i=$datacount;$i<24;$i++){
   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    }

     //DISIGNATIONS
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($outputtype=='items'?$prepared:'&nbsp;','160',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col($outputtype=='items'?$approved:'&nbsp;','160',null,false,'1px solid ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('&nbsp;','160',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->col('&nbsp;','160',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->col('&nbsp;','160',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    //     
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('&nbsp;','800',null,false,'1px solid ','','L','Courier New','12','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($outputtype=='items'?$delivered:'&nbsp;','160',null,false,'1px solid ','','L','Courier New','12','B','','');
        Yii::$app->reporter->col($outputtype=='items'?$checked:'&nbsp;','160',null,false,'1px solid ','','C','Courier New','12','B','','');
        Yii::$app->reporter->col('&nbsp;','160',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->col('&nbsp;','160',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->col('&nbsp;','160',null,false,'1px solid ','','R','Courier New','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '</div>';
Yii::$app->reporter->endreport();


?>