<?php
//WTODO: [KIM][2019.09.04][inventory balance isamt for universe]
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory Balance';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=28;
$page=28;
// $header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->beginreport();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('Inventory Balance',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Balance as of : '. $params['asof'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        if($params['barcode']==''){
        Yii::$app->reporter->col('Items : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Items : '. $params['itemname'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        
        if($params['category']==''){
        Yii::$app->reporter->col('Category : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Category :'. $params['category'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }


        

        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        
        if($params['principalid']==''){
        Yii::$app->reporter->col('Principal : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Principal : '. $params['principalid'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        if($params['divisionid']==''){
        Yii::$app->reporter->col('Division : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Division : '. $params['divisionid'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        
        if($params['class']==''){
        Yii::$app->reporter->col('Classification : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Classification :'. $params['class'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }

        
        
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        
        if($params['modelid']==''){
        Yii::$app->reporter->col('Model : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Model :'. $params['model'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }

        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Item Type : '. strtoupper($params['itemtype']),null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
       
Yii::$app->reporter->endtable();
$totalbalqty=0;
Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ITEM CODE','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','350',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('UOM','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('BALANCE','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('SRP','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('COUNT','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        
//var_dump($data);
$part="";
$scatgrp="";
$totalext=0;
$grandtotal=0;
for($i=0;$i<count ($data);$i++){
    if (strtoupper($scatgrp)==strtoupper($data[$i]['category'])){
    $scatgrp="";  
    }  else {
    $scatgrp=strtoupper($data[$i]['category']);  
    }

    $balance=number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
    if ($balance==0)
    {
    $balance='-';
    }
    $isamt=number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
    if ($isamt==0)
    {
    $isamt='-';
    }  
        Yii::$app->reporter->addline();
        $totalext=$data[$i]['balance'] * $data[$i]['amt'];

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'75',null,false,'1px solid ','','C','Helvetica','14','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'350',null,false,'1px solid ','','L','Helvetica','14','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'75',null,false,'1px solid ','','C','Helvetica','14','','','');
        Yii::$app->reporter->col($balance,'75',null,false,'1px solid ','','R','Helvetica','14','','','');
        Yii::$app->reporter->col($isamt,'75',null,false,'1px solid ','','R','Helvetica','14','','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','','R','Helvetica','14','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','B','C','Helvetica','14','','','');
        $scatgrp=strtoupper($data[$i]['category']);
        $part=$data[$i]['partname'];
        $grandtotal=$grandtotal+$totalext; 
        $totalbalqty=$totalbalqty+$data[$i]['balance'];

    if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();
        Yii::$app->reporter->begintable('800');
        
        $header=Yii::$app->reporter->letterhead();
        Yii::$app->reporter->endtable();
        echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        
        Yii::$app->reporter->col('Inventory Balance',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Balance as of : '. $params['asof'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        if($params['barcode']==''){
        Yii::$app->reporter->col('Items : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Items : '. $params['itemname'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        
        if($params['category']==''){
        Yii::$app->reporter->col('Category : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Category :'. $params['category'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }


        

        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        
        if($params['principalid']==''){
        Yii::$app->reporter->col('Principal : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Principal : '. $params['principalid'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        if($params['divisionid']==''){
        Yii::$app->reporter->col('Division : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Division : '. $params['divisionid'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        
        if($params['class']==''){
        Yii::$app->reporter->col('Classification : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Classification :'. $params['class'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }

        
        
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        
        if($params['modelid']==''){
        Yii::$app->reporter->col('Model : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Model :'. $params['model'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }

        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Item Type : '. strtoupper($params['itemtype']),null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
       
Yii::$app->reporter->endtable();

        Yii::$app->reporter->printline();
        //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','350',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('UOM','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('BALANCE','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('SRP','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('COUNT','75',null,false,'1px solid ','B','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
        }
}//enf for each
  
Yii::$app->reporter->begintable('800');
echo '<br/>';
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('OVERALL STOCKS :','350',null,false,'1px solid ','TB','r','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Helvetica','14','TB','30px','8px');
        Yii::$app->reporter->col(number_format($totalbalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'75',null,false,'1px solid ','TB','R','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col(number_format($grandtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','TB','R','Helvetica','14','B','30px','8px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Helvetica','14','B','30px','8px');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();       

    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


?>