<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory Balance';
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
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('INVENTORY BALANCE',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Balance as of : '. $params['asof'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        if($params['item']==''){
        Yii::$app->reporter->col('Items : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Items : '. $params['item'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Group : '. $params['group'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        if($params['category']==''){
        Yii::$app->reporter->col('Category : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Category : '. $params['category'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        if($params['part']==''){
        Yii::$app->reporter->col('Part : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Part :'. $params['part'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Item Type : '. strtoupper($params['itemtype']),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        switch($params['itemstock'])
        {
            case '1':
                $options = 'With Balance';
                break;
            case '0':
                $options = 'Without Balance';
                break;
            case '1,0':
                $options = 'None';
                break;
        }
        Yii::$app->reporter->col('Item Stock : '.strtoupper($options),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
       
Yii::$app->reporter->endtable();
$totalbalqty=0;
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','350',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UOM','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('BALANCE','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('SRP','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('COUNT','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        
//var_dump($data);
$part="";
$scatgrp="";
$totalext=0;
$grandtotal=0;
for($i=0;$i<count ($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
    
           

            if (strtoupper($scatgrp)==strtoupper($data[$i]['category'])){
            $scatgrp="";  
          }  else {
            $scatgrp=strtoupper($data[$i]['category']);  
          }
//        
         $balance=number_format($data[$i]['balance2'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
            if ($balance==0)
            {
            $balance='-';
            }
         $isamt=number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($isamt==0)
            {
            $isamt='-';
            }  

            
        Yii::$app->reporter->col($part,'100',null,false,'1px solid ','','L','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','450',null,false,'1px solid ','','L','Century Gothic','11','Bi','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($scatgrp,'100',null,false,'1px solid ','','R','Century Gothic','11','Bi','','');
        Yii::$app->reporter->col('','450',null,false,'1px solid ','','L','Century Gothic','11','Bi','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        $totalext=$data[$i]['balance2'] * $data[$i]['amt'];
          
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'450',null,false,'1px solid ','','L','Century Gothic','11','','','');
        if($data[$i]['invbal_uom'] == ''){ $uom = $data[$i]['uom']; }else{ $uom = $data[$i]['invbal_uom']; }
        Yii::$app->reporter->col($uom,'75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col($balance,'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col($isamt,'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','B','C','Century Gothic','11','','','');
        $scatgrp=strtoupper($data[$i]['category']);
        $part=$data[$i]['part'];
        $grandtotal=$grandtotal+$totalext; 
        $totalbalqty=$totalbalqty+$data[$i]['balance2'];

//    
        
        
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
                Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('INVENTORY BALANCE',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Balance as of : '. $params['asof'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        if($params['item']==''){
        Yii::$app->reporter->col('Items : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Items : '. $params['item'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Group : '. $params['group'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        if($params['category']==''){
        Yii::$app->reporter->col('Category : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Category : '. $params['category'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        if($params['part']==''){
        Yii::$app->reporter->col('Part : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Part :'. $params['part'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Stocks : '. strtoupper($params['itemtype']),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        switch($params['itemstock'])
        {
            case '1':
                $options = 'With Balance';
                break;
            case '0':
                $options = 'Without Balance';
                break;
            case '1,0':
                $options = 'both';
                break;
        }
        Yii::$app->reporter->col('Options : '.strtoupper($options),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','350',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UOM','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('BALANCE','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('SRP','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('COUNT','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();
       Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}
  
Yii::$app->reporter->begintable('800');
echo '<br/>';
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('OVERALL STOCKS :','350',null,false,'1px solid ','TB','r','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Century Gothic','11','TB','30px','8px');
        Yii::$app->reporter->col(number_format($totalbalqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'75',null,false,'1px solid ','TB','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col(number_format($grandtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','TB','R','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','TB','C','Century Gothic','11','B','30px','8px');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();       

    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


//var_dump($params);
?>