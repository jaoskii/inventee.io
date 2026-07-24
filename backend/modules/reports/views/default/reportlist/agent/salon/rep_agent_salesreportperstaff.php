<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Report per Staff';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1200');

Yii::$app->reporter->begintable('1200');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/>';

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('SALES REPORT PER STAFF',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1200');

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

if ($params['group']!=''){
    $cla = $params['group'];
}else{
    $cla = 'ALL';
}

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Customer : '.$client,null,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Staff : '.$agent,null,null,false,'1px solid ','','C','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Group : '.$cla,null,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOC #','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DATE','50',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('QTY','50',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DESCRIPTION','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('GROUP','50',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CUSTOMER','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('STAFF','150',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('ASSISTANT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();

    


$itemname="";
$date="";
$docno="";
$yourref="";
$totalext=0;
$totalqty=0;
$totaltons=0;
$totalpv=0;
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

if ($itemname==""){
            Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        
}



    if (strtoupper($itemname)==strtoupper($data[$i]['staff'])){
            $itemname="";
            
        if (strtoupper($docno)==strtoupper($data[$i]['staff'])){
            $docno="";
        }else{
           if ($docno!=''){  
                
                $subtotalqty=0;
                $subtotalext=0;
             //   $subtotalpv=0;
            }
                

            $itemname=strtoupper($data[$i]['staff']);  
        }
               
    }else{
       if ($docno!=''){  
            
       }


if ($itemname!=''){  
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('TOTAL :','100',null,false,'1px dotted ','','L','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col(number_format($gsubtotalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col(number_format($gsubtotalpv,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->endrow();
        }    

   

        if ($itemname!=''){  
            
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','L','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');  
        }  
         
             
            $subtotalqty=0;
            $subtotalext=0;
            $subtotalpv=0;
            
            $gsubtotalqty=0;
            $gsubtotalext=0;
            $gsubtotalpv=0;
              $docno=$data[$i]['staff'];
              //$date = $data[$i]['dateid'];
               if (strtoupper($docno)==strtoupper($data[$i]['staff'])){
                $docno="";  
              }  else {
//                 //brand

                $docno=strtoupper($data[$i]['staff']);  
              }
             
            }
            
                
if ($iitem==$data[$i]['staff']){
    $iitem="";
}else{
    $iitem=$data[$i]['staff'];
}    
            
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['docno'],'50',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['dateid'],'50',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['grp'],'50',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['staff'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['assistant'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        
        
        
    Yii::$app->reporter->endrow();
     
   


     $subtotalext=$subtotalext+$data[$i]['ext'];
     $subtotalqty=$subtotalqty+$data[$i]['isqty'];
     $subtotalpv=$subtotalpv+$data[$i]['isamt'];
   
     $gsubtotalext=$gsubtotalext+$data[$i]['ext'];
     $gsubtotalqty=$gsubtotalqty+$data[$i]['isqty'];
     $gsubtotalpv=$gsubtotalpv+$data[$i]['isamt'];
      
     $totalext=$totalext+$data[$i]['ext'];
     $totalqty=$totalqty+$data[$i]['isqty'];
     $totalpv=$totalpv+$data[$i]['isamt'];
     
     $itemname=strtoupper($data[$i]['staff']);
     $docno=$data[$i]['staff'];

     $iitem=$data[$i]['staff'];

     
    }
    
 
   
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('TOTAL :','100',null,false,'1px dotted ','','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($gsubtotalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($gsubtotalpv,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
    Yii::$app->reporter->endrow();

    echo '<br/>';

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('GRAND TOTAL :','100',null,false,'1px dotted ','','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalpv,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','50',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','11','B','','3px');
    Yii::$app->reporter->endrow();



    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>