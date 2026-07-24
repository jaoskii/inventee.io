<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Inventory Aging';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport('1200');

    Yii::$app->reporter->begintable('1200');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CURRENT INVENTORY BALANCE PER SUPPLIER',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();        

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
         Yii::$app->reporter->col('Client :'. $params['client'],'200',null,false,'1px solid ','','L','Helvetica','14','','','');        
        if($params['item']==''){
        Yii::$app->reporter->col('Item : ALL','200',null,false,'1px solid ','','L','Helvetica','14','','','');    
        } else {
        Yii::$app->reporter->col('Item :'. $params['item'],'200',null,false,'1px solid ','','L','Helvetica','14','','','');
        }
        Yii::$app->reporter->col('Group : '. $params['group'],'200',null,false,'1px solid ','','L','Helvetica','14','','','');
        Yii::$app->reporter->col('Brand : '. $params['brand'],'200',null,false,'1px solid ','','L','Helvetica','14','','',''); 
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),'200',null,false,'1px solid ','','R','Helvetica','14','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1200');         
        Yii::$app->reporter->startrow('100',null,false,'1px solid ','','C','Helvetica','14','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,'200',null,false,'1px solid ','','L','Helvetica','14','','','');
        Yii::$app->reporter->col('WH : '. $params['wh'],'200',null,false,'1px solid ','','L','Helvetica','14','','','');
        Yii::$app->reporter->col('Part :'. $params['part'],'200',null,false,'1px solid ','','L','Helvetica','14','','','');
        Yii::$app->reporter->col('Option : '. strtoupper($params['itemtype']),'100',null,false,'1px solid ','','L','Helvetica','14','','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1200');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('DESCRIPTION','300',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('COST','100',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
        Yii::$app->reporter->col('SUPPLIER','300',null,false,'1px solid ','B','C','Century Gothic','12','B','20px','8px');
    Yii::$app->reporter->endrow();    
Yii::$app->reporter->endtable();  
Yii::$app->reporter->begintable('1200');

$itemname="";
$date="";
$docno="";
$yourref="";
$totalext=0;
$totalqty=0;
$totalpv=0;
$subtotalqty=0;
$subtotalext=0;
$subtotalpv=0;
$gsubtotalqty=0;
$gsubtotalext=0;
$gsubtotalpv=0;
$member="";
$grandtotalpv=0;
$grandtotalqty=0;
$iitem="";
for($i=0;$i<count($data);$i++){

        $ext = $data[$i]['bal']*$data[$i]['cost'];

        if ($itemname==""){
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col($data[$i]['itemname'],'100',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
            Yii::$app->reporter->col('','300',null,false,'1px dotted ','B','C','Helvetica','14','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Helvetica','14','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Helvetica','14','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Helvetica','14','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Helvetica','14','','','');
            Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Helvetica','14','','','');
            Yii::$app->reporter->col('','300',null,false,'1px dotted ','B','L','Helvetica','14','','','');
        }


        if (strtoupper($itemname)==strtoupper($data[$i]['itemname'])){
            $itemname="";
            
    if (strtoupper($docno)==strtoupper($data[$i]['itemname'])){
        $docno="";
    }else{
       if ($docno!=''){  
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Helvetica','14','B','','');
                Yii::$app->reporter->col('SUB TOTAL :','300',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col(number_format($subtotalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col(number_format($subtotalqty,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col(number_format($subtotalpv,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Helvetica','14','B','','');
                Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Helvetica','14','B','','');
                

            Yii::$app->reporter->endrow();  
            
            $subtotalqty=0;
            $subtotalext=0;
            $subtotalpv=0;
       }
            
            $docno = strtoupper($data[$i]['itemname']);
            //$date = $data[$i]['dateid'];
                //client
                $itemname=strtoupper($data[$i]['itemname']);  
              }
               
            }
            else {
                        
            if ($docno!=''){  
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Helvetica','14','B','','');
                Yii::$app->reporter->col('SUB TOTAL :','300',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col(number_format($subtotalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col(number_format($subtotalqty,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col(number_format($subtotalpv,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Helvetica','14','B','','');
                Yii::$app->reporter->col('','300',null,false,'1px solid ','','R','Helvetica','14','B','','');
                
            Yii::$app->reporter->endrow();  
            
   
       }

             if ($itemname!=''){  
            
                Yii::$app->reporter->startrow();
                //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col($data[$i]['itemname'],'100',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
                Yii::$app->reporter->col('','300',null,false,'1px dotted ','B','C','Helvetica','14','','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Helvetica','14','','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Helvetica','14','','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Helvetica','14','','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Helvetica','14','','','');    
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','L','Helvetica','14','','','');    
                Yii::$app->reporter->col('','300',null,false,'1px dotted ','B','L','Helvetica','14','','','');    
             }  
         
             
              
            $subtotalqty=0;
            $subtotalext=0;
            $subtotalpv=0;
            
            $gsubtotalqty=0;
            $gsubtotalext=0;
            $gsubtotalpv=0;
              $docno=$data[$i]['itemname'];
               if (strtoupper($docno)==strtoupper($data[$i]['itemname'])){
                $docno="";  
              }  else {
                //brand

                $docno=strtoupper($data[$i]['itemname']);  
              }
             
            }
            
                
if ($iitem==$data[$i]['itemname']){
    $iitem="";
}else{
    $iitem=$data[$i]['itemname'];
}
            
            
    Yii::$app->reporter->startrow();
       Yii::$app->reporter->addline();
       Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','5px');
       Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','5px');
       Yii::$app->reporter->col(number_format($data[$i]['bal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','5px');
       Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','5px');
       Yii::$app->reporter->col(number_format($data[$i]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','5px');
       Yii::$app->reporter->col(number_format($ext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','5px');
       Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','5px');
       Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','5px');
        
    Yii::$app->reporter->endrow();
       
     $subtotalext=$subtotalext+$data[$i]['bal'];
     $subtotalqty=$subtotalqty+$data[$i]['cost'];
     $subtotalpv=$subtotalpv+$ext;
   
     $gsubtotalext=$gsubtotalext+$data[$i]['bal'];
     $gsubtotalqty=$gsubtotalqty+$data[$i]['cost'];
     $gsubtotalpv=$gsubtotalpv+$ext;
       
     $totalext=$totalext+$data[$i]['bal'];
     $totalqty=$totalqty+$data[$i]['cost'];
     $totalpv=$totalpv+$ext;
     
     $itemname=strtoupper($data[$i]['itemname']);
     $docno=$data[$i]['itemname'];

     $iitem=$data[$i]['itemname'];

    }
    
    
   //  Yii::$app->reporter->startrow();
   //              Yii::$app->reporter->col('','150',null,false,'1px solid ','','C','Helvetica','14','B','','');
   //              Yii::$app->reporter->col('SUB - TOTAL :','350',null,false,'1px dotted ','','R','Helvetica','14','B','','');
   //              Yii::$app->reporter->col(number_format($subtotalqty),'100',null,false,'1px dotted ','TB','C','Helvetica','14','B','','');
   //              Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Helvetica','14','B','','');
   //              Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Helvetica','14','B','','');
   //              Yii::$app->reporter->col(number_format($subtotalpv),'100',null,false,'1px dotted ','TB','C','Helvetica','14','B','','');
                
   // Yii::$app->reporter->endrow();  
   
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Helvetica','14','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','300',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','TB','C','Helvetica','14','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
        Yii::$app->reporter->col(number_format($totalqty,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','TB','R','Helvetica','14','B','','');
        Yii::$app->reporter->col(number_format($totalpv,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','TB','C','Helvetica','14','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Helvetica','14','B','','');
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','R','Helvetica','14','B','','');
    Yii::$app->reporter->endrow();  


    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>