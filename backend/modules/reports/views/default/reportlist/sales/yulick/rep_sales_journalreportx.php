<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$pagenumber=1;
$count=6;
$page=6;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');
Yii::$app->reporter->begintable('800');

$docno="";
    $start=$params['start'];
    $end=$params['end'];
    if($params['username']!=""){
        $user=$params['username'];
    }
    else{
        $user="ALL USERS";
    }
    Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Sales Journal Report',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Date Range: '.$start.' to '.$end,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('User: '.$user,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('Prefix: '.$params['bref'],null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','B','Century Gothic','10','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');



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
               Yii::$app->reporter->col($data[$i]['supplier'],'800',null,false,'1px dotted ','','C','Century Gothic','18','B','','');
          Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        }


    //    if ($params['client']!=""){
    //     Yii::$app->reporter->begintable('800');
    //       Yii::$app->reporter->startrow();
    //            Yii::$app->reporter->col($data[$i]['supplier'],'800',null,false,'1px dotted ','','C','Century Gothic','18','B','','');
    //       Yii::$app->reporter->endrow();
    //     Yii::$app->reporter->endtable();
    // }    


if ($itemname==""){
      

 
 Yii::$app->reporter->begintable('800');

        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['docno'],'250',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('Yourref :<br> ' . $data[$i]['yourref'],'350',null,false,'1px dotted ','B','C','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('Ourref :<br> ' . $data[$i]['ourref'],'100',null,false,'1px dotted ','B','C','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('Date :<br> ' . $data[$i]['dateid'],'100',null,false,'1px dotted ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();

    
        
}
        if (strtoupper($itemname)==strtoupper($data[$i]['docno'])){
            $itemname="";
            
    if (strtoupper($docno)==strtoupper($data[$i]['docno'])){
        $docno="";
    }else{
       if ($docno!=''){  
            
            $subtotalqty=0;
            $subtotalext=0;
         //   $subtotalpv=0;
       }
            

                $itemname=strtoupper($data[$i]['docno']);  
              }
               
            }
            else {
                        
            if ($docno!=''){  
            
       }


       if ($itemname!=''){  
        
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','250',null,false,'1px solid ','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','350',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','150',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();
        }    

             if ($itemname!=''){  

                  Yii::$app->reporter->begintable('800');
          if ($params['client']!=''){
          } else {        
          Yii::$app->reporter->startrow();
               Yii::$app->reporter->col($data[$i]['supplier'],'800',null,false,'1px dotted ','','C','Century Gothic','18','B','','');
          Yii::$app->reporter->endrow();
        }
        Yii::$app->reporter->endtable();
           
           Yii::$app->reporter->begintable('800');
                Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['docno'],'250',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('Yourref :<br>' . $data[$i]['yourref'],'350',null,false,'1px dotted ','B','C','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('Ourref :<br> ' . $data[$i]['ourref'],'100',null,false,'1px dotted ','B','C','Century Gothic','12','B','','5px');
        Yii::$app->reporter->col('Date :<br> ' . $data[$i]['dateid'],'100',null,false,'1px dotted ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','11','','','');
        
            
             }  
         
             
              
            $subtotalqty=0;
            $subtotalext=0;
            $subtotaltons=0;
            
            $gsubtotalqty=0;
            $gsubtotalext=0;
            $gsubtotaltons=0;
              $docno=$data[$i]['docno'];
              //$date = $data[$i]['dateid'];
               if (strtoupper($docno)==strtoupper($data[$i]['docno'])){
                $docno="";  
              }  else {
//                 //brand

                $docno=strtoupper($data[$i]['docno']);  
              }
             
            }
            
                
if ($iitem==$data[$i]['docno']){
    $iitem="";
}else{
    $iitem=$data[$i]['docno'];
}
            
            
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col(number_format($data[$i]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'250',null,false,'1px solid ','','C','Century Gothic','11','','','1px');
        Yii::$app->reporter->col($data[$i]['itemname'],'350',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Century Gothic','11','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','1px');
        Yii::$app->reporter->col($data[$i]['ref'],'150',null,false,'1px solid ','','C','Century Gothic','11','','','1px');
        
    Yii::$app->reporter->endrow();
     
    


     $subtotalext=$subtotalext+$data[$i]['ext'];
     $subtotalqty=$subtotalqty+$data[$i]['isamt'];
   
     $gsubtotalext=$gsubtotalext+$data[$i]['ext'];
     $gsubtotalqty=$gsubtotalqty+$data[$i]['isamt'];
      
     $totalext=$totalext+$data[$i]['ext'];
     $totalqty=$totalqty+$data[$i]['isamt'];
     //$totalpv=$totalpv+$data[$i]['pvpoints'];
     
     $itemname=strtoupper($data[$i]['docno']);
     $docno=$data[$i]['docno'];

     $iitem=$data[$i]['itemname'];

     }
    
 
   
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','250',null,false,'1px solid ','','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','350',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();

    echo '<br/>';

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','250',null,false,'1px solid ','','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('TOTAL :','350',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px dotted ','T','R','Century Gothic','11','B','','');
    Yii::$app->reporter->endrow();



    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

// var_dump($data);
?>