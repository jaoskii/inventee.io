<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Per Class';
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
echo '<br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SALES PER CLASS',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();



Yii::$app->reporter->begintable('800');

if (strtoupper($params['salestype'])=='ALL'){
    $salestype = 'ALL';
}else{
    $salestype = $params['salestype'];
}

if (strtoupper($params['vat'])!='ALL'){
    if (strtoupper($params['vat'])=='CASH'){
        $vattype = 'VATABLE';    
    }else{
        $vattype = 'NON-VATABLE';
    }
    
}else{
    $vattype = 'ALL';
}

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

if ($params['class']!=''){
    $cla = $params['class'];
}else{
    $cla = 'ALL';
}



        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Sales Type : '.$salestype,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Customer : '.$client,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Vat : '.$vattype,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Agent : '.$agent,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Class : '.$cla,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col(strtoupper($params['reporttype']),300,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','150',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DESCRIPTION','350',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('UNIT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('TOT TONS','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();

      

$itemname="";
$date="";
$docno="";
$yourref="";
$totalext=0;
$totalqty=0;
$totaltons=0;
$subtotalqty=0;
$subtotalext=0;
$subtotalpv=0;
$subtotaltons=0;
$gsubtotalqty=0;
$gsubtotalext=0;
$gsubtotalpv=0;
$member="";
$grandtotalpv=0;
$grandtotalqty=0;
$gsubtotaltons=0;

$iitem="";
for($i=0;$i<count($data);$i++){

$tons = $data[$i]['tons'];

if ($itemname==""){
            Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['class'],'150',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('','350',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Century Gothic','10','','','');
        
}
    if (strtoupper($itemname)==strtoupper($data[$i]['class'])){
            $itemname="";
            
        if (strtoupper($docno)==strtoupper($data[$i]['itemname'])){
            $docno="";
        }else{
           if ($docno!=''){  
                
                $subtotalqty=0;
                $subtotalext=0;
             //   $subtotalpv=0;
            }
                

            $itemname=strtoupper($data[$i]['class']);  
        }
               
    }else{
       if ($docno!=''){  
            
       }


       if ($itemname!=''){  
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','350',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($gsubtotalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($gsubtotaltons,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
            Yii::$app->reporter->endrow();
        }    

        if ($itemname!=''){  
            
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col($data[$i]['class'],'150',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
            Yii::$app->reporter->col('','350',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Century Gothic','10','','','');    
        }  
         
             
              
            $subtotalqty=0;
            $subtotalext=0;
            $subtotaltons=0;
            
            $gsubtotalqty=0;
            $gsubtotalext=0;
            $gsubtotaltons=0;
              $docno=$data[$i]['class'];
              //$date = $data[$i]['dateid'];
               if (strtoupper($docno)==strtoupper($data[$i]['itemname'])){
                $docno="";  
              }  else {
//                 //brand

                $docno=strtoupper($data[$i]['class']);  
              }
             
            }
            
                
if ($iitem==$data[$i]['itemname']){
    $iitem="";
}else{
    $iitem=$data[$i]['itemname'];
}
            
            
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['itemname'],'350',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($tons,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        
    Yii::$app->reporter->endrow();
     
    


     $subtotalext=$subtotalext+$data[$i]['ext'];
     $subtotalqty=$subtotalqty+$data[$i]['isqty'];
     $subtotaltons=$subtotaltons+$tons;
     //$subtotalpv=$subtotalpv+$data[$i]['pvpoints'];
   
     $gsubtotalext=$gsubtotalext+$data[$i]['ext'];
     $gsubtotalqty=$gsubtotalqty+$data[$i]['isqty'];
     $gsubtotaltons=$gsubtotaltons+$tons;
      
     $totaltons=$totaltons+$tons;  
     $totalext=$totalext+$data[$i]['ext'];
     $totalqty=$totalqty+$data[$i]['isqty'];
     //$totalpv=$totalpv+$data[$i]['pvpoints'];
     
     $itemname=strtoupper($data[$i]['class']);
     $docno=$data[$i]['itemname'];

     $iitem=$data[$i]['itemname'];

     
    }
    
 
   
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','350',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotaltons,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();

    echo '<br/>';

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('TOTAL :','350',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();



    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>