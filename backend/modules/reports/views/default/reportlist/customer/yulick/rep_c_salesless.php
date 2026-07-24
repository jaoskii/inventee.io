<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Less Return';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('SALES LESS RETURN',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        if($params['yulick']==''){
        Yii::$app->reporter->col('Company : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Company : ' . $params['yulick'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['cgrp']==''){
        Yii::$app->reporter->col('Company Group : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Company Group : ' . $params['cgrp'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Yourref : '.strtoupper($params['yourref']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
         Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction : '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center : '.strtoupper($params['center']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Sort By : '.strtoupper($params['sortby']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        
        Yii::$app->reporter->col('Ourref : '.strtoupper($params['ourref']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       
       Yii::$app->reporter->col('DATE','300',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('DOCUMENT #','150',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('REFERENCE','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('PO #','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
       Yii::$app->reporter->col('TOTAL AMOUNT','150',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
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

if ($itemname==""){
      
 
 Yii::$app->reporter->begintable('800');

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px dotted ','B','L','Century Gothic','11','B','','5px');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();

    
        
}
        if (strtoupper($itemname)==strtoupper($data[$i]['clientname'])){
            $itemname="";
            
    if (strtoupper($docno)==strtoupper($data[$i]['clientname'])){
        $docno="";
    }else{
       if ($docno!=''){  
            
            $subtotalqty=0;
            $subtotalext=0;
         //   $subtotalpv=0;
       }
            

                $itemname=strtoupper($data[$i]['clientname']);  
              }
               
            }
            else {
                        
            if ($docno!=''){  
            
       }


       if ($itemname!=''){  
        
            Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px solid ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('SUB TOTAL :','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->endrow();
        }    

             if ($itemname!=''){  
           
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px dotted ','B','L','Century Gothic','11','B','','5px');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        
            
             }  
         
             
              
            $subtotalext=0;
            
            $gsubtotalext=0;
              $docno=$data[$i]['clientname'];
              //$date = $data[$i]['dateid'];
               if (strtoupper($docno)==strtoupper($data[$i]['clientname'])){
                $docno="";  
              }  else {
//                 //brand

                $docno=strtoupper($data[$i]['clientname']);  
              }
             
            }
            
                
if ($iitem==$data[$i]['clientname']){
    $iitem="";
}else{
    $iitem=$data[$i]['clientname'];
}
            
            
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['dateid'],'300',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['yourref'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['ourref'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['amount'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        
    Yii::$app->reporter->endrow();
     
    


     $subtotalext=$subtotalext+$data[$i]['amount'];
   
     $gsubtotalext=$gsubtotalext+$data[$i]['amount'];
      
     $totalext=$totalext+$data[$i]['amount'];
     
     $itemname=strtoupper($data[$i]['clientname']);
     $docno=$data[$i]['clientname'];

     $iitem=$data[$i]['clientname'];

     }
    
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px solid ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('SUB TOTAL :','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();

    echo '<br/>';

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px solid ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('TOTAL :','150',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();



    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>
