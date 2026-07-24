<?php

date_default_timezone_set('Asia/Manila');
$this->title = 'DR with Batch';
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

// Yii::$app->reporter->begintable('800');
//         Yii::$app->reporter->startrow();
//         Yii::$app->reporter->col('','100',null,false,'1px dotted ','','L','Helvetica','13','B','','');
//         Yii::$app->reporter->col('','250',null,false,'1px dotted ','','L','Helvetica','13','B','30px','4px');
//         Yii::$app->reporter->col('','107',null,false,'1px dotted ','','L','Helvetica','13','B','','');
//         $docno = substr($data[0]['docno'], 0,2) . substr($data[0]['docno'], 10,5);
//         Yii::$app->reporter->col((isset($data[0]['docno'])? $docno:''),'243',null,false,'1px dotted ','','L','Helvetica','13','B','','');
//         Yii::$app->reporter->endrow();
// Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CUSTOMER: ','100',null,false,'1px dotted ','','L','Helvetica','13','B','','');
        Yii::$app->reporter->col(' '.(isset($data[0]['clientname'])? $data[0]['clientname']:''),'480',null,false,'1px solid ','','L','Helvetica','13','B','30px','4px');
        Yii::$app->reporter->col(' ','40',null,false,'1px dotted ','','L','Helvetica','13','B','','');
         $dateid = date_create($data[0]['dateid']);
        $dateid = date_format($dateid,'m-d-Y');
        Yii::$app->reporter->col('DATE: ','60',null,false,'1px dotted ','','L','Helvetica','13','B','','');
        Yii::$app->reporter->col($dateid,'120',null,false,'1px solid ','','R','Helvetica','13','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS: ','100',null,false,'1px solid ','','L','Helvetica','13','B','','');
        Yii::$app->reporter->col(' '.(isset($data[0]['address'])? $data[0]['address']:''),'480',null,false,'1px solid ','','L','Helvetica','13','B','30px','4px');
        Yii::$app->reporter->col(' ','40',null,false,'1px dotted ','','L','Helvetica','13','B','','');
        Yii::$app->reporter->col('PO NO: ','60',null,false,'1px dotted ','','L','Helvetica','13','B','','');
        // Yii::$app->reporter->col(' '.(isset($data[0]['yourref'])? $data[0]['yourref']:''),'100',null,false,'1px solid ','B','R','Helvetica','13','B','','');
        Yii::$app->reporter->col(substr($data[0]['docno'], -3).'-'.substr($data[0]['agent'],-3).'-'.substr($data[0]['pickcode'],-3).'-'.substr($data[0]['checkcode'],-3),'120',null,false,'1px solid ','','R','Helvetica','13','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();    


// Yii::$app->reporter->printline();

echo '<br/>';

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('QTY','50',null,false,'1px solid ','TB','C','Helvetica','13','B','30px','1px');
        Yii::$app->reporter->col('UNIT','50',null,false,'1px solid ','TB','C','Helvetica','13','B','30px','1px');
        Yii::$app->reporter->col('D E S C R I P T I O N','350',null,false,'1px solid ','TB','C','Helvetica','13','B','30px','1px');
        Yii::$app->reporter->col('GROSS','100',null,false,'1px solid ','TB','C','Helvetica','13','B','30px','1px');
        Yii::$app->reporter->col('DISC','50',null,false,'1px solid ','TB','C','Helvetica','13','B','30px','1px');
        Yii::$app->reporter->col('NET PRICE','100',null,false,'1px solid ','TB','C','Helvetica','13','B','30px','1px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','TB','C','Helvetica','13','B','30px','1px');

   $totalext=0;
   $rowcounter = 0;
   $datacounter = count($data);
for($i=0;$i<count($data);$i++){

        Yii::$app->reporter->startrow();
            Yii::$app->reporter->addline();
            
            Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col($data[$i]['itemname'],'350',null,false,'1px dotted ','','L','Helvetica','13','','','2px');
            Yii::$app->reporter->col(number_format($data[$i]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col($data[$i]['disc'],'50',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
        Yii::$app->reporter->endrow();

        $totalext = $totalext + $data[$i]['ext'];
        
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->addline();
            
            Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');

            $sqler = "select rem,expiry,loc from glstock where trno =".$data[$i]['rrstat_trno']." and line = ". $data[$i]['rrstat_line'];
            $batchdata = Yii::$app->sbccommon->opentable($sqler);

            $batch = $data[$i]['srem'];
            if($batch == ""){
                $batch = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            }//end if

            $batchloc = $batchdata[0]['loc'];
            $batchexpiry = $batchdata[0]['expiry'];

            if(strlen($batchexpiry) == 10){
                $batchexpiry = date_create($batchexpiry);
                $batchexpiry = date_format($batchexpiry,'m / Y');
            }//end if

            Yii::$app->reporter->col('EXPIRY : '.$batchexpiry.'   &nbsp&nbsp&nbsp&nbsp&nbsp   - '.'BATCH : '.$batch,'350',null,false,'1px dotted ','','L','Helvetica','13','I','','2px');


            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
        Yii::$app->reporter->endrow();
        $rowcounter += 1;
    
}      

    if($datacounter <= 6){
        $addrowcounter = 6;
    }else{
        $addrowcounter = 19;
    }//end if

    if($rowcounter != $addrowcounter){
        $rowadd = $addrowcounter - $rowcounter;
        for ($i=0; $i < $rowadd; $i++) { 
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->addline();
            Yii::$app->reporter->col('&nbsp','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','350',null,false,'1px dotted ','','L','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','50',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->endrow();

            Yii::$app->reporter->startrow();
            Yii::$app->reporter->addline();
            Yii::$app->reporter->col('&nbsp','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','350',null,false,'1px dotted ','','L','Helvetica','13','I','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','50',null,false,'1px dotted ','','C','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','','R','Helvetica','13','','','2px');
            Yii::$app->reporter->endrow();
        }//end for
    }//end if
    
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','450',null,false,'1px dotted ','T','R','Helvetica','13','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'350',null,false,'1px dotted ','T','R','Helvetica','17','U','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

   
    
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('NOTE : ','50',null,false,'1px dotted ','','L','Helvetica','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['rem'])? $data[0]['rem']:''),'750',null,false,'1px dotted ','','L','Helvetica','13','I','','');
        
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    echo '<br/>';
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Received merchandise in good order and condition:    ','400',null,false,'1px dotted ','','R','Helvetica','13','B','','');
        Yii::$app->reporter->col(' ','20',null,false,'1px dotted ','','R','Helvetica','13','B','','');
        Yii::$app->reporter->col('','380',null,false,'1px dotted ','B','L','Helvetica','13','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
   
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();


?>