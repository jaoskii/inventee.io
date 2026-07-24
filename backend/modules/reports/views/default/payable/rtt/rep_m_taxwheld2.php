<?php
//WTODO: JLY 2019.1.26 TW PRINTOUT 
//WTODO : ALVIN 10.29.2018 
//RTTREPORTS2
date_default_timezone_set('Asia/Manila');
$this->title = 'Tax Wheld Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>


<!-- <div style="position: absolute; z-index:9999; margin-left: 25%; top: 5%;"><img src="<?php echo Yii::$app->homeUrl.'fimages/reports/bir-logo-2.png';?>"></div>
<div style="position: absolute; z-index:9999; margin-left: 31%; top: 6%; font-size:10px;">Republica ng Pilipinas</div>
<div style="position: absolute; z-index:9999; margin-left: 31%; top: 9%; font-size:10px;">Kagawaran ng Pananalapi</div>
<div style="position: absolute; z-index:9999; margin-left: 31%; top: 12%; font-size:10px;">Kawanihan ng Rentas Internas</div>
<div style="position: absolute; z-index:9999; margin-left: 40%; top: 5%; font-size:25px; font-weight: bold;">Certificate of Credible Tax</div>
<div style="position: absolute; z-index:9999; margin-left: 43%; top: 9%; font-size:25px; font-weight: bold;">Withheld at Source</div>
<div style="position: absolute; z-index:9999; margin-left: 68%; top: 5%; font-size:45px; font-weight: bold;">2307</div>
<div style="position: absolute; z-index:9999; margin-left: 68%; top: 13%; font-size:10px; ">September 2005 (ECNS)</div>
 -->

<?php

$count=35;
$page=35;

Yii::$app->reporter->beginreport('800');
    
    echo '
    <div style="border:solid 1px;"><br>
        <img style="margin-left:10px;" src="'.Yii::$app->homeUrl.'fimages/reports/bir-logo-png-7.png">
        <p style="margin-left:81%;margin-top:-10%;">BIR Form No.</p>
        <p style="margin-left:12%;">Republica ng Pilipinas<br>Kagawaran ng Pananalapi<br>Kawanihan ng Rentas Internas</p>
        <h3 style="font-weight:bold;margin-left:33%;margin-top:-9%">Certificate of Credible Tax<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspWithheld at Source</h3>
        <h2 style="font-size:45px;font-weight:bold;margin-left:81%;margin-top:-7%">2307</h2>
        <h6 style="margin-left:81%;margin-top:1%">September 2005 (ECNS)</h6>
    </div>';    
    /*Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','LR','R','Avenir','12','','',''); 
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','LR','R','Avenir','12','','',''); 
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','LR','R','Avenir','12','','',''); 
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','LR','R','Avenir','12','','',''); 
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','LR','R','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

*/
    Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('1.   For the Period','400',null,'#D6D6D6','1px solid ','L','L','Avenir','12','','',''); 
            Yii::$app->reporter->col('','400',null,'#D6D6D6','1px solid ','R','R','Avenir','12','','',''); 
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('FROM','100',null,'#D6D6D6','1px solid ','LTB','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($data[0]['d1m'],'34',null,false,'1px solid ','TRBL','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($data[0]['d1d'],'33',null,false,'1px solid ','TRBL','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($data[0]['d1y'],'45',null,false,'1px solid ','TRBL','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('(MM/DD/YYYY)','100',null,'#D6D6D6','1px solid ','TB','L','Avenir','10','','',''); 
            Yii::$app->reporter->col('','50',null,'#D6D6D6','1px solid ','TB','L','Avenir','12','','',''); 
            Yii::$app->reporter->col('','100',null,'#D6D6D6','1px solid ','TB','L','Avenir','12','','',''); 
            Yii::$app->reporter->col('TO','50',null,'#D6D6D6','1px solid ','TB','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($data[0]['d2m'],'34',null,false,'1px solid ','TRBL','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($data[0]['d2d'],'33',null,false,'1px solid ','TRBL','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($data[0]['d2y'],'45',null,false,'1px solid ','TRBL','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('(MM/DD/YYYY)','100',null,'#D6D6D6','1px solid ','TB','L','Avenir','10','','','');   
            Yii::$app->reporter->col('','100',null,'#D6D6D6','1px solid ','TB','L','Avenir','12','','',''); 
            Yii::$app->reporter->col('','100',null,'#D6D6D6','1px solid ','BTR','L','Avenir','12','','',''); 
            Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PART I','100',null,'#D6D6D6','0.5px solid ','L','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('Payee Information','700',null,'#D6D6D6','1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    $tax[0] = '-';
    $tax[1] = '-';
    $tax[2] = '-';
    $tax[3] = '-';

    if(strlen($data[0]['tin']) > 12){
        $a = $data[0]['tin'];
        $tax[0] = '-';
        $tax[1] = '-';
        $tax[2] = '-';
        $tax[3] = '-';

        if(strstr($a,'-')){
          $tax=explode('-', $a);
        }elseif(strstr($a,' ')){
          $tax=explode(' ', $a);
        }else{
          $tax = str_split($a,3);
        }//end if


        if(!isset($tax[0])){
          $tax[0] = '-';
        }

        if(!isset($tax[1])){
          $tax[1] = '-';
        }

        if(!isset($tax[2])){
          $tax[2] = '-';
        }

        if(!isset($tax[3])){
          $tax[3] = '-';
        }
    }//end if

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('2.','20',null,'#D6D6D6','1px solid ','TL','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Taxpayer Identification Number ','180',null,'#D6D6D6','1px solid ','T','C','Avenir','12','','',''); 
        Yii::$app->reporter->col($tax[0],'34',null,false,'1px solid ','LT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col($tax[1],'34',null,false,'1px solid ','LT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col($tax[2],'34',null,false,'1px solid ','LT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col($tax[3],'34',null,false,'1px solid ','LT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','467',null,'#D6D6D6','1px solid ','TLR','L','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('3.','20',null,'#D6D6D6','1px solid ','TL','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Payee's Name",'120',null,'#D6D6D6','1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->col($data[0]['clientname'],'480',null,false,'1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('','30',null,'#D6D6D6','1px solid ','T','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('(Registered Name)','130',null,'#D6D6D6','1px solid ','T','L','Avenir','10','','',''); 
        Yii::$app->reporter->col('','20',null,'#D6D6D6','1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('4.','20',null,'#D6D6D6','1px solid ','TL','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Registered Address",'120',null,'#D6D6D6','1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->col($data[0]['address'],'639',null,false,'1px solid ','T','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('','10',null,'','1px solid ','T','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('','10',null,'','1px solid ','T','R','Avenir','10','','',''); 
        Yii::$app->reporter->col('','1',null,'#D6D6D6','1px solid ','TRB','','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PART II','100',null,'#D6D6D6','0.5px solid ','TL','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('Payor Information','700',null,'#D6D6D6','0.5px solid ','TR','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('5.','20',null,'#D6D6D6','1px solid ','TL','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Taxpayer Identification Number ','180',null,'#D6D6D6','1px solid ','T','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('112','34',null,false,'1px solid ','LRT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('625','34',null,false,'1px solid ','LT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('341','34',null,false,'1px solid ','LT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('000','34',null,false,'1px solid ','LRT','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','467',null,'#D6D6D6','1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('6.','20',null,'#D6D6D6','1px solid ','TL','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Payor's Name",'120',null,'#D6D6D6','1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('RT TRADING','180',null,false,'1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('','30',null,'#D6D6D6','1px solid ','T','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('(Registered Name)','330',null,'#D6D6D6','1px solid ','T','L','Avenir','10','','',''); 
        Yii::$app->reporter->col('','120',null,'#D6D6D6','1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('7.','20',null,'#D6D6D6','1px solid ','TL','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Registered Address",'120',null,'#D6D6D6','1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('WAREHOUSE #7, MADRIGAL COMPOUND S. OSMEÑA BOULEVARD,PIER 1 AREA CEBU CITY','530',null,false,'1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('','30',null,'#D6D6D6','1px solid ','T','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('ZIP CODE','50',null,'#D6D6D6','1px solid ','TR','','Avenir','10','','',''); 
        Yii::$app->reporter->col('6000','50',null,false,'1px solid ','TR','L','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

     Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PART III','50',null,'#D6D6D6','0.5px solid ','TLB','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('','50',null,'#D6D6D6','0.5px solid ','TB','L','Avenir','12','','',''); 
        Yii::$app->reporter->col('Details of Monthly Income Payments and Tax Withheld for the Quarter','700',null,'#D6D6D6','0.5px solid ','BTR','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();


     Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Income Statements','150',null,'#D6D6D6','1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','100',null,'#D6D6D6','1px solid ','LR','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Amount of Income Statements','350',null,'#D6D6D6','1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Tax Withheld','200',null,'#D6D6D6','1px solid ','LR','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Subject to Expanded Withholding Tax','150',null,'#D6D6D6','1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('ATC','100',null,'#D6D6D6','1px solid ','LR','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('1st Month of the Quarter','88',null,'#D6D6D6','1px solid ','TR','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('2nd Month of the Quarter','87',null,'#D6D6D6','1px solid ','TR','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('3rd Month of the Quarter','87',null,'#D6D6D6','1px solid ','TR','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Total','88',null,'#D6D6D6','1px solid ','T','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('for the Quarter','200',null,'#D6D6D6','1px solid ','LR','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    $count=0;
    $sub1=0;
    $sub2=0;
    $sub3=0;
    $total=0;
    $wheldtotal = 0;
    Yii::$app->reporter->begintable('800');
    for ($i=0; $i <count($data) ; $i++) { 
        if($count<9){
            $count++;
            
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['acnoname'],'150',null,false,'1px solid ','TL','L','Avenir','12','','',''); 
            Yii::$app->reporter->col($data[$i]['acno'],'100',null,false,'1px solid ','LTR','C','Avenir','12','','',''); 
            switch ($data[$i]['month']) {
                case '1':
                    Yii::$app->reporter->col(number_format($data[$i]['income'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'88',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    $sub1=$sub1+$data[$i]['income'];
                    break;
                
                case '2':
                    Yii::$app->reporter->col('','88',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    Yii::$app->reporter->col(number_format($data[$i]['income'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    $sub2=$sub2+$data[$i]['income'];
                    break;
                case '3':
                    Yii::$app->reporter->col('','88',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    Yii::$app->reporter->col(number_format($data[$i]['income'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                    $sub3=$sub3+$data[$i]['income'];
                    break;
                
            }
            
            Yii::$app->reporter->col(number_format($data[$i]['income'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'88',null,false,'1px solid ','T','C','Avenir','12','','',''); 
            Yii::$app->reporter->col(number_format($data[$i]['wheld'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','TLR','C','Avenir','12','','',''); 
            Yii::$app->reporter->endrow();
            $wheldtotal += floatval($data[$i]['wheld']);
        }
    }

    for ($a=$count; $a < 9; $a++) { 
        if($a<9){
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','150',null,false,'1px solid ','TL','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','100',null,false,'1px solid ','LTR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','88',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','88',null,false,'1px solid ','T','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','200',null,false,'1px solid ','TLR','C','Avenir','12','','',''); 
            Yii::$app->reporter->endrow();
        }    # code...
    }
    $total=$sub1+$sub2+$sub3;
    if($sub1 == 0){
        $sub1 = '-';
    }else{
        $sub1 = number_format($sub1,Yii::$app->systemsettings->setDecimaldisplay('currency'));
    }//end if

    if($sub2 == 0){
        $sub2 = '-';
    }else{
        $sub2 = number_format($sub2,Yii::$app->systemsettings->setDecimaldisplay('currency'));
    }//end if

    if($sub3 == 0){
        $sub3 = '-';
    }else{
        $sub3 = number_format($sub3,Yii::$app->systemsettings->setDecimaldisplay('currency'));
    }//end if

            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Total','150',null,'#D6D6D6','1px solid ','TL','L','Avenir','12','','',''); 
            Yii::$app->reporter->col('','100',null,false,'1px solid ','LTR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($sub1,'88',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($sub2,'87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col($sub3,'87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'88',null,false,'1px solid ','T','C','Avenir','12','','',''); 
            Yii::$app->reporter->col(number_format($wheldtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','TLR','C','Avenir','12','','',''); 
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Money Payments Subject to Withholding of Business Tax (Government & Private)','150',null,'#D6D6D6','1px solid ','TL','C','Avenir','10','','',''); 
            Yii::$app->reporter->col('','100',null,'#D6D6D6','1px solid ','LTR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','88',null,'#D6D6D6','1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','87',null,'#D6D6D6','1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','87',null,'#D6D6D6','1px solid ','TR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','88',null,'#D6D6D6','1px solid ','T','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','200',null,'#D6D6D6','1px solid ','TLR','C','Avenir','12','','',''); 
            Yii::$app->reporter->endrow();
        for ($b=0; $b < 6; $b++) { 
            if($b<6){
                Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('&nbsp','150',null,false,'1px solid ','TL','C','Avenir','12','','',''); 
                Yii::$app->reporter->col('','100',null,false,'1px solid ','LTR','C','Avenir','12','','',''); 
                Yii::$app->reporter->col('','88',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                Yii::$app->reporter->col('','87',null,false,'1px solid ','TR','C','Avenir','12','','',''); 
                Yii::$app->reporter->col('','88',null,false,'1px solid ','T','C','Avenir','12','','',''); 
                Yii::$app->reporter->col('','200',null,false,'1px solid ','TLR','C','Avenir','12','','',''); 
                Yii::$app->reporter->endrow();
            }    # code...
        }
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Total','150',null,'#D6D6D6','1px solid ','TBL','L','Avenir','12','','',''); 
            Yii::$app->reporter->col('','100',null,false,'1px solid ','BLTR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','88',null,false,'1px solid ','BTR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','87',null,false,'1px solid ','BTR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','87',null,false,'1px solid ','BTR','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','88',null,false,'1px solid ','BT','C','Avenir','12','','',''); 
            Yii::$app->reporter->col('','200',null,false,'1px solid ','BTLR','C','Avenir','12','','',''); 
            Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<br>We declare, under the penalties of perjury, that this certificate has been made in good faith, verified by me, and to the best of my knowledge and belief,','800',null,false,'1px solid ','LR','C','Avenir','11','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('is true and correct, pursuant to the provisions of the National Internal Revenue Code, as amended, and the regulations issued under authority thereof.','800',null,false,'1px solid ','LR','C','Avenir','11','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<br>','800',null,false,'1px solid ','LR','C','Avenir','11','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col($prepared,'280',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('112-625-341-000','130',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col($approved,'140',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col(date('m/d/Y'),'100',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Payor's Authorized Representative/Accredited Tax Agent",'280',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('TIN of Signatory','130',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Title/Position of Signatory','140',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Date Signed','100',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','280',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','130',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','60',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','140',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Tax Agent Accreditation No./Attorney's Roll No.(If applicable)",'280',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Date of Issuance','130',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','60',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Date of Expiry','140',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','10',null,false,'1px solid ','L','L','Avenir','12','I','',''); 
        Yii::$app->reporter->col('<br>Conforme:','790',null,false,'1px solid ','R','L','Avenir','12','I','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

     Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','280',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','130',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','140',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','100',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Payee's Authorized Representative/Accredited Tax Agent",'280',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','30',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('TIN of Signatory','130',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Title/Position of Signatory','140',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Date Signed','100',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','20',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','280',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','130',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','60',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('','140',null,false,'1px solid ','B','C','Avenir','14','B','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','40',null,false,'1px solid ','L','C','Avenir','12','','',''); 
        Yii::$app->reporter->col("Tax Agent Accreditation No./Attorney's Roll No.(If applicable)",'280',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Date of Issuance','130',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','60',null,false,'1px solid ','','C','Avenir','12','','',''); 
        Yii::$app->reporter->col('Date of Expiry','140',null,false,'1px solid ','','C','Avenir','10','','',''); 
        Yii::$app->reporter->col('','40',null,false,'1px solid ','R','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','LBR','C','Avenir','12','','',''); 
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();



    // Yii::$app->reporter->begintable('800');
    //     Yii::$app->reporter->startrow();
    //     Yii::$app->reporter->col('1.   For the Period','800',null,'#D6D6D6','1px solid ','TLR','L','Avenir','12','','',''); 
    //     Yii::$app->reporter->endrow();
    // Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();



?>