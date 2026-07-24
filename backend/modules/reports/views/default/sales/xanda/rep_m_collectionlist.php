<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Collection List';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=11;
$page=11;
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
        Yii::$app->reporter->col('COLLECTION LIST',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Salesman : '.strtoupper($data[0]['agentname']),250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOC DATE','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DOC #','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DATE DUE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CREDIT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT PAID','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('REMARKS','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
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
$duedate=0; 

$iitem="";
for($i=0;$i<count($data);$i++){

if ($itemname==""){
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Customer : ' . $data[$i]['client'] . ' - ' . $data[$i]['clientname'],null,null,false,'1px dotted ','','L','Century Gothic','12','','','5px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();    

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Address : ' . $data[$i]['addr'] ,null,null,false,'1px dotted ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();    
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
               
    }else{
       if ($docno!=''){  
            
       }


       if ($itemname!=''){  
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($gsubtotalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($gsubtotaltons,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
            Yii::$app->reporter->endrow();
        }    

        if ($itemname!=''){  
            
             Yii::$app->reporter->begintable('800');
                Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Customer : ' . $data[$i]['client'] . ' - ' . $data[$i]['clientname'],null,null,false,'1px dotted ','','L','Century Gothic','12','','','5px');
                Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();    

                Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Address : ' . $data[$i]['addr'] ,null,null,false,'1px dotted ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();   
        }  
         
             
              
            $subtotalqty=0;
            $subtotalext=0;
            $subtotaltons=0;
            
            $gsubtotalqty=0;
            $gsubtotalext=0;
            $gsubtotaltons=0;
              $docno=$data[$i]['clientname'];
               if (strtoupper($docno)==strtoupper($data[$i]['clientname'])){
                $docno="";  
              }  else {
                $docno=strtoupper($data[$i]['clientname']);  
              }
             
            }
            
                
if ($iitem==$data[$i]['clientname']){
    $iitem="";
}else{
    $iitem=$data[$i]['clientname'];
}

    if($data[$i]['docduedate'] == "1900-01-01") {
        $duedate = "------";
    } else {
        $duedate = $data[$i]['docduedate'];
    }
          
     Yii::$app->reporter->begintable('800');        
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['docdate'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($duedate,'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        Yii::$app->reporter->col('_________________________','100',null,false,'1px solid','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col('__________________________________','200',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        
    Yii::$app->reporter->endrow();
     
      
            


     $subtotalext=$subtotalext+$data[$i]['cr'];
     $subtotalqty=$subtotalqty+$data[$i]['db'];
     $subtotaltons=$subtotalqty-$subtotalext;
     
   
     $gsubtotalext=$gsubtotalext+$data[$i]['cr'];
     $gsubtotalqty=$gsubtotalqty+$data[$i]['db'];
     $gsubtotaltons=$gsubtotalqty-$gsubtotalext;
     
     $totalext=$totalext+$data[$i]['cr'];
     $totalqty=$totalqty+$data[$i]['db'];
     $totaltons=$totalqty + $totalext;

     $itemname=strtoupper($data[$i]['clientname']);
     $docno=$data[$i]['clientname'];

     $iitem=$data[$i]['clientname'];


      if(Yii::$app->reporter->linecounter==$page){

        Yii::$app->reporter->begintable('800');
         echo '</br>';
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col('This is to acknowledge receipt of the original copy/copies of the above documents. Please check and read carefully before signing.',null,null,false,'1px dotted ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();   


         echo '<br/><br/>';
        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Collection By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('Verified By :','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        
        echo '<br/>';
        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col($received,'266',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col($verified,'266',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

            Yii::$app->reporter->endtable();

            Yii::$app->reporter->page_break();

 Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('COLLECTION LIST',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Salesman : '.strtoupper($data[0]['agentname']),250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',300,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOC DATE','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DOC #','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DATE DUE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CREDIT','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT PAID','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('REMARKS','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();
               Yii::$app->reporter->printline();
        $page=$page + $count;

    }
     


    }
    
    Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotaltons,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','200',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 


    

    Yii::$app->reporter->begintable('800');
    echo '<br/><br/><br/><br/>';
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Total Balance :' . number_format($totaltons,Yii::$app->systemsettings->setDecimaldisplay('currency')),'250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Total Collection :','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Total Paid : P ___________________','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Cash : P ____________________','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 


    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('Check : P ___________________','250',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 



    Yii::$app->reporter->begintable('800');
         echo '</br>';
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col('This is to acknowledge receipt of the original copy/copies of the aboive documents. Please check and read carefully before signing.',null,null,false,'1px dotted ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();   


         echo '<br/><br/>';
        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('Collection By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('Verified By :','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        
        echo '<br/>';
        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col($verified,'266',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
            Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col($received,'266',null,false,'1px solid ','B','L','Century Gothic','12','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>