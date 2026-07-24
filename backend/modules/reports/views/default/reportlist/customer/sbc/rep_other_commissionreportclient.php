<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Commission Report - Customer';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('COMMISSION REPORT',800,null,false,'1px solid ','','C','Century Gothic','16','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();


if ($params['client']!=''){
    $client = $params['client'];
}else{
    $client = 'ALL';
}

if ($params['agent']!=''){
    $agent = $params['agent'];
}else{
    $agent = 'ALL';
}


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Customer : '.$client,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Agent : '.$agent,250,null,false,'1px solid ','','C','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Center :'.$params['center'],300,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

       

// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CUTOFF DATE','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AGENT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('BASE AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('STANDARD COMM (%)','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('STANDARD AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('SHARE COMM (%)','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('SHARE AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();

      

$client="";
$date="";
$agent="";
$yourref="";

$standamt=0;
$shareamt=0;

$gstandamt=0;
$gshareamt=0;

$totalstandamt=0;
$totalshareamt=0;

$gsubtotalqty=0;
$gssubtotalqty=0;
$gsubtotalext=0;
$member="";
$grandtotalpv=0;
$grandtotalqty=0;
$grandtotalqty=0;
$gsubtotaltons=0;

$iitem="";
for($i=0;$i<count($data);$i++){

if ($client==""){
      
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['custname'],'200',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
    
        
}


        if (strtoupper($client)==strtoupper($data[$i]['custname'])){
            $client="";
            
    if (strtoupper($agent)==strtoupper($data[$i]['custname'])){
        $agent="";
    }else{
       if ($agent!=''){  
            
           $standamt=0;
           $shareamt=0;
            
           $gstandamt=0;
           $gshareamt=0;
       }
                $client=strtoupper($data[$i]['custname']);  
              }
               
            }
            else {
                        
            if ($agent!=''){  
            
       }

       if ($client!=''){  

            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','200',null,false,'1px dotted ','TB','L','Century Gothic','12','B','','5px');
                Yii::$app->reporter->col('SUB TOTAL : ','100',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
                Yii::$app->reporter->col('','150',null,false,'1px dotted ','TB','C','Century Gothic','10','','','');
                Yii::$app->reporter->col(number_format($standamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','Century Gothic','10','','','');
                Yii::$app->reporter->col(number_format($shareamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
            Yii::$app->reporter->endrow();
        
        }    

             if ($client!=''){  
           
                Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col($data[$i]['custname'],'200',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
                    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Century Gothic','10','','','');
                    Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Century Gothic','10','','','');
        
            
             }  
              
            $standamt=0;
            $shareamt=0;
            
            $gstandamt=0;
            $gshareamt=0;

              $agent=$data[$i]['custname'];
              //$date = $data[$i]['dateid'];
               if (strtoupper($agent)==strtoupper($data[$i]['custname'])){
                $agent="";  
              }  else {
//                 //brand

                $agent=strtoupper($data[$i]['custname']);  
              }
             
            }
            
            
            
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['cutoffdate'],'200',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['agentname'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['baseamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['standardpercent'].'%','100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['standardamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['standardsharepercent'].'%','100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['standardshareamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
    Yii::$app->reporter->endrow();
     

     //$subtotalext=$subtotalext+$data[$i]['baseamt'];
     $standamt=$standamt+$data[$i]['standardamt'];
     $shareamt=$shareamt+$data[$i]['standardshareamt'];

     $gstandamt=$gstandamt+$data[$i]['standardamt'];
     $gshareamt=$gshareamt+$data[$i]['standardshareamt'];
     
     $totalstandamt=$totalstandamt+$data[$i]['standardamt'];
     $totalshareamt=$totalshareamt+$data[$i]['standardshareamt'];
     
     $client=strtoupper($data[$i]['custname']);
     $agent=$data[$i]['custname'];

     
    }
    
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','TB','L','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('SUB TOTAL : ','100',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','TB','C','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($standamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($gshareamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
    Yii::$app->reporter->endrow();

    // echo '<br/>';

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','TB','L','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('GRAND TOTAL : ','100',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','TB','C','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($totalstandamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','L','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($totalshareamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','TB','R','Century Gothic','10','B','','1px');
    Yii::$app->reporter->endrow();



    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>