<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Report per Salesman';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=26;
$page=26;
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
        Yii::$app->reporter->col('SALES REPORT PER SALESMAN',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

if ($params['agent']!=''){
    $agent = $params['agent'];
}else{
    $agent = 'ALL';
}


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Agent : '. $agent,800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');




Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('',250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DATE','100',null,false,'1px dotted ','TB','L','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('DOCUMENT #','150',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CODE','100',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('CUSTOMER NAME','300',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','150',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
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


if ($itemname==""){
      
            Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['agcode'] . '  ' . $data[$i]['agentname'] ,'800',null,false,'1px dotted ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    
        
}

        if (strtoupper($itemname)==strtoupper($data[$i]['agentname'])){
            $itemname="";
            
    if (strtoupper($docno)==strtoupper($data[$i]['agentname'])){
        $docno="";
    }else{
       if ($docno!=''){  
            
            $subtotalqty=0;
            $subtotalext=0;
         //   $subtotalpv=0;
       }
                $itemname=strtoupper($data[$i]['agentname']);  
              }
               
            }
            else {
                        
            if ($docno!=''){  
       }


       if ($itemname!=''){  
        
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','150',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','300',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
            Yii::$app->reporter->endrow();
        }    

             if ($itemname!=''){  
           
                Yii::$app->reporter->startrow();
                //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col($data[$i]['agcode'] . '  ' . $data[$i]['agentname'] ,'100',null,false,'1px dotted ','B','L','Century Gothic','12','B','','5px');
                Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
                Yii::$app->reporter->col('','100',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
                Yii::$app->reporter->col('','300',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
                Yii::$app->reporter->col('','150',null,false,'1px dotted ','B','C','Century Gothic','10','','','');
            
             }  
         
            $subtotalext=0;
            $gsubtotalext=0;
            $docno=$data[$i]['agentname'];
              
               if (strtoupper($docno)==strtoupper($data[$i]['agentname'])){
                $docno="";  
              }  else {
               //brand

                $docno=strtoupper($data[$i]['agentname']);  
              }
             
            }
            
                
if ($iitem==$data[$i]['agentname']){
    $iitem="";
}else{
    $iitem=$data[$i]['agentname'];
}
            
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['client'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['clientname'],'300',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        
    Yii::$app->reporter->endrow();
     
    


     $subtotalext=$subtotalext+$data[$i]['ext'];
     $gsubtotalext=$gsubtotalext+$data[$i]['ext'];
     $totalext=$totalext+$data[$i]['ext'];
     $itemname=strtoupper($data[$i]['agentname']);
     $docno=$data[$i]['agentname'];
     $iitem=$data[$i]['agentname'];

     
    }
    
 
   
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($gsubtotalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();

    // echo '<br/>';

    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px dotted ','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'150',null,false,'1px dotted ','T','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();



    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();
?>