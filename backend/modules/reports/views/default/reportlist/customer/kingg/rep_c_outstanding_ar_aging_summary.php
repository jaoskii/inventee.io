<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Current Customer Receivables Aging - Summary';
//WTODO: [JLY][2019.08.19][KINGG CONCERNS][EDIT REPORT]
//WTODO: [JLY][2019.08.28][KINGG CONCERNS][EDIT REPORT SHOW AGENT]
//WTODO: [JLY][2019.09.6][KINGG CONCERNS][EDIT REPORT NET AMOUNT REFLECTING BALANCE]
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
        Yii::$app->reporter->col('CURRENT CUSTOMER RECEIVABLES AGING SUMMARY',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
$cus="";
if ($params['client']==" "){
    $cus='ALL';
}
    Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','11','','','');
    if ($params['client']=='') {
    Yii::$app->reporter->col('Customer : ALL','110px',null,false,'1px solid ','','L','Century Gothic','11','','','');    
    } else {
    Yii::$app->reporter->col('Customer : '.strtoupper($params['client']),'110px',null,false,'1px solid ','','L','Century Gothic','11','','','');
    }
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->col('Center : '.$params['center'],'110px',null,false,'1px solid ','','L','Century Gothic','11','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','11','','b','');
    Yii::$app->reporter->col('','110px',null,false,'1px solid ','','L','Century Gothic','11','','','');
    // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),'110px',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->pagenumber('Page');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$granddb=0;
$grandcr=0;
$grandnet=0;
$subdb=0;
$subcr=0;
$subnet=0;
$group='';
for($i=0;$i<count($data);$i++){

  if($data[$i]['groupid']=='' && $group==''){
    $group='NO GROUP';
    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
          //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
          
          Yii::$app->reporter->col($group,'700',null,false,'1px solid ','TLRB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          
          Yii::$app->reporter->endrow();
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
          //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
          Yii::$app->reporter->col('DR DATE','100',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('DOCNO','100',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('CUSTOMER NAME','170',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('DR AMT','110',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('SALES RETURN','110',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('NET AMOUNT','110',null,false,'1px solid ','TLBR','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->endrow();
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
  }elseif ($data[$i]['groupid']!='' && $group!=$data[$i]['groupid']) {
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
          //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
          Yii::$app->reporter->col('','126',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('Subtotal','140',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          
          
          Yii::$app->reporter->col(number_format($subdb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($subcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($subnet,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','126',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->endrow();
          $granddb=$granddb+$subdb;
          $grandcr=$grandcr+$subcr;
          $grandnet=$grandnet+$subnet;
          $subdb=0;
          $subcr=0;
          $subnet=0;
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    $group=$data[$i]['groupid'];
    Yii::$app->reporter->printline();
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
          //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
          
          Yii::$app->reporter->col($group,'700',null,false,'1px solid ','TLRB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->endrow();
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
          //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
          Yii::$app->reporter->col('DR DATE','100',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('DOCNO','100',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('CUSTOMER NAME','170',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('DR AMT','110',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('SALES RETURN','110',null,false,'1px solid ','TLB','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('NET AMOUNT','110',null,false,'1px solid ','TLBR','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->endrow();
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
  }

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        $currentnet=$data[$i]['bal'];
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','LB','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','LB','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['clientname'],'170',null,false,'1px solid ','LB','L','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px solid ','LB','L','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px solid ','LB','L','Century Gothic','10','','','');
        Yii::$app->reporter->col(number_format($currentnet,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px solid ','LBR','L','Century Gothic','10','','','');
        if($data[$i]['agname']<>''){
          Yii::$app->reporter->col($data[$i]['agname'],'100',null,false,'1px solid ','TLRB','L','Century Gothic','11','B','','');  
        }else{
          Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
        }
        
        $subdb=$subdb+$data[$i]['db'];
        $subcr=$subcr+$data[$i]['cr'];
        $subnet=$subnet+$currentnet;
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();


}
  Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
          //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
          Yii::$app->reporter->col('','126',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          
          Yii::$app->reporter->col('Subtotal','140',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($subdb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($subcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($subnet,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','126',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->endrow();
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    $granddb=$granddb+$subdb;
    $grandcr=$grandcr+$subcr;
    $grandnet=$grandnet+$subnet;
    echo '<br>';
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
          //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
          Yii::$app->reporter->col('','126',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          
          Yii::$app->reporter->col('Grandtotal','140',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($granddb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($grandcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','10',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->col(number_format($grandnet,Yii::$app->systemsettings->setDecimaldisplay('currency')),'126',null,false,'1px solid ','B','C','Century Gothic','11','B','','');
          Yii::$app->reporter->col('','126',null,false,'1px solid ','','L','Century Gothic','11','B','','');
          Yii::$app->reporter->endrow();
      Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();





Yii::$app->reporter->printline();

// $itemname="";
// $date="";
// $docno="";
// $yourref="";
// $totalext=0;
// $totalqty=0;
// $totaltons=0;
// $subtotalqty=0;
// $subtotalext=0;
// $subtotalpv=0;
// $subtotaltons=0;
// $gsubtotalqty=0;
// $gsubtotalext=0;
// $gsubtotalpv=0;
// $member="";
// $grandtotalpv=0;
// $grandtotalqty=0;
// $gsubtotaltons=0;

// $iitem="";
// for($i=0;$i<count($data);$i++){

//   $display=$data[$i]['clientname'];
//   $docno=$data[$i]['docno'];
//   $date=$data[$i]['dateid'];
//   $order=$data[$i]['elapse'];
//   $served=$data[$i]['balance'];

// if ($itemname==""){
      
 
//  Yii::$app->reporter->begintable('800');

//         Yii::$app->reporter->startrow();
//         //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
//         Yii::$app->reporter->col($data[$i]['clientname'],'110',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
//         Yii::$app->reporter->endrow();

    
        
// }
//         if (strtoupper($itemname)==strtoupper($data[$i]['clientname'])){
//             $itemname="";
            
//     if (strtoupper($docno)==strtoupper($data[$i]['clientname'])){
//         $docno="";
//     }else{
//        if ($docno!=''){  
            
//             $subtotalqty=0;
//             $subtotalext=0;
//          //   $subtotalpv=0;
//        }
            

//                 $itemname=strtoupper($data[$i]['clientname']);  
//               }
               
//             }
//             else {
                        
//             if ($docno!=''){  
            
//        }


//        if ($itemname!=''){  
        
//             Yii::$app->reporter->startrow();
//                 Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','B','','');
//                 Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
//                 Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','B','','');
//                 Yii::$app->reporter->col('SUB TOTAL :','110',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
//                 Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
//             Yii::$app->reporter->endrow();
//         }    

//              if ($itemname!=''){  
           
//         Yii::$app->reporter->startrow();
//         //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
//         Yii::$app->reporter->col($data[$i]['clientname'],'110',null,false,'1px dotted ','B','L','Century Gothic','11','B','','5px');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        
            
//              }  
         
             
              
//             $subtotalext=0;
            
//             $gsubtotalext=0;
//               $docno=$data[$i]['clientname'];
//               //$date = $data[$i]['dateid'];
//                if (strtoupper($docno)==strtoupper($data[$i]['clientname'])){
//                 $docno="";  
//               }  else {
// //                 //brand

//                 $docno=strtoupper($data[$i]['clientname']);  
//               }
             
//             }
            
                
// if ($iitem==$data[$i]['clientname']){
//     $iitem="";
// }else{
//     $iitem=$data[$i]['clientname'];
// }
            
            
//     Yii::$app->reporter->startrow();
//     Yii::$app->reporter->addline();
//     Yii::$app->reporter->col('','110',null,false,'1px solid ','','L','Century Gothic','11','','','5px');
//     Yii::$app->reporter->col($date,'110',null,false,'1px solid ','','L','Century Gothic','11','','','5px');
//     Yii::$app->reporter->col($data[$i]['docno'],'110',null,false,'1px solid ','','L','Century Gothic','11','','','5px');
//     Yii::$app->reporter->col(number_format($order,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'110',null,false,'1px solid ','','C','Century Gothic','11','','','5px');
//     Yii::$app->reporter->col(number_format($served,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'110',null,false,'1px solid ','','R','Century Gothic','11','','','5px');
        
//     Yii::$app->reporter->endrow();
     
    


//      $subtotalext=$subtotalext+$data[$i]['balance'];
//      $gsubtotalext=$gsubtotalext+$data[$i]['balance'];
//      $totalext=$totalext+$data[$i]['balance'];
//      $itemname=strtoupper($data[$i]['clientname']);
//      $docno=$data[$i]['clientname'];
//      $iitem=$data[$i]['clientname'];

//      }
    
 
   
//     Yii::$app->reporter->startrow();
//         Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','B','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
//         Yii::$app->reporter->col('SUB TOTAL :','110',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
//         Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
//     Yii::$app->reporter->endrow();

//     echo '<br/>';

//     Yii::$app->reporter->startrow();
//         Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','B','','');
//         Yii::$app->reporter->col('','110',null,false,'1px solid ','','C','Century Gothic','11','B','','');
//         Yii::$app->reporter->col('','110',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
//         Yii::$app->reporter->col('TOTAL :','110',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
//         Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'110',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
//     Yii::$app->reporter->endrow();



//     Yii::$app->reporter->endtable();
//     Yii::$app->reporter->printline();
// Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>