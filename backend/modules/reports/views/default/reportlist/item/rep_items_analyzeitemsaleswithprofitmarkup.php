<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Analyze Item Sales with Profit Markup';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1000');
    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ANALYZE ITEM SALES WITH PROFIT MARKUP',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow(null,null,'','1px solid ','','r','Century Gothic','10','','');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,'','1px solid ','','r','Century Gothic','10','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('1000');

        Yii::$app->reporter->startrow();
        if($params['client']==''){
        Yii::$app->reporter->col('Customer : ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Customer : '.strtoupper($params['client']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['item']==''){
        Yii::$app->reporter->col('Item :'.' ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'.strtoupper($params['item']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Group : '.strtoupper($params['group']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand : '.strtoupper($params['brand']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['part']==''){
        Yii::$app->reporter->col('Part :'.' ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Part :'.strtoupper($params['part']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->col('Status: '. strtoupper($params['itemtype']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        //Yii::$app->reporter->col('Center: '. strtoupper($cname),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->col('Warehouse: '. strtoupper($params['wh']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<BR>ITEM DESCRIPTION','175','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('GROSS<BR>SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AMOUNT<BR>DISCOUNT' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('<BR>RETURNS' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('NET<BR>SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('COST OF<BR>SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('GROSS<BR>PROFIT' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('%MARGIN<BR>vs COST' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('%MARGIN<BR>vs SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('UNITS<BR>SOLD' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AVERAGE<BR>PRICE' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AVERAGE<BR>COST' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');

$totalgrosssales=0;
$totalamountdiscount=0;
$totalreturns=0;
$totalnetsales=0;
$totalcostsales=0;
$totalgrossprofit=0;
$totalmarginvscost=0;
$totalmarginvssales=0;
$totalunitsold=0;
$totalaverageprice=0;
$totalaveragecost=0;
 
$group="";
$brand="";

$netsales=0;
$grossprofit=0;
$marginvscost=0;
$marginvssales=0;
$averageprice=0;
$averagecost=0;

$subgrosssales=0;
$subamountdiscount=0;
$subreturns=0;
$subnetsales=0;
$subcostsales=0;
$subgrossprofit=0;
$submarginvscost=0;
$submarginvssales=0;
$subunitsold=0;
$subaverageprice=0;
$subaveragecost=0;
//part
$gsubgrosssales=0;
$gsubamountdiscount=0;
$gsubreturns=0;
$gsubnetsales=0;
$gsubcostsales=0;
$gsubgrossprofit=0;
$gsubmarginvscost=0;
$gsubmarginvssales=0;
$gsubunitsold=0;
$gsubaverageprice=0;
$gsubaveragecost=0;

for($i=0;$i<count($data);$i++){
        
        if ($group==strtoupper($data[$i]['groupid'])){
               $group=""; 
              if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";                
              }  else {
              if ($brand!=''){   
                Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($brand.' '.'SUB TOTAL:','175',null,false,'1px solid ','','R','Century Gothic','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($subgrosssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subamountdiscount,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subreturns,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subnetsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subcostsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subgrossprofit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submarginvscost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submarginvssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
             } 
                //brand
    $subgrosssales=0;
    $subamountdiscount=0;
    $subreturns=0;
    $subnetsales=0;
    $subcostsales=0;
    $subgrossprofit=0;
    $submarginvscost=0;
    $submarginvssales=0;
    $subunitsold=0;
    $subaverageprice=0;
    $subaveragecost=0;
    //part
    $gsubgrosssales=0;
    $gsubamountdiscount=0;
    $gsubreturns=0;
    $gsubnetsales=0;
    $gsubcostsales=0;
    $gsubgrossprofit=0;
    $gsubmarginvscost=0;
    $gsubmarginvssales=0;
    $gsubunitsold=0;
    $gsubaverageprice=0;
    $gsubaveragecost=0;
                $brand=strtoupper($data[$i]['brand']);  
              }
               
            }
            else {
            
             if ($brand!=''){   
                Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($brand.' '.'SUB TOTAL:','175',null,false,'1px solid ','','R','Century Gothic','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($subgrosssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subamountdiscount,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subreturns,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subnetsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subcostsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subgrossprofit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submarginvscost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submarginvssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
             }
              if ($group!=''){   
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col($group.' '.'SUB TOTAL:','175',null,false,'1px solid ','','R','Century Gothic','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($gsubgrosssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubamountdiscount,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubreturns,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubnetsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubcostsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubgrossprofit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubmarginvscost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubmarginvssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
             }  
              $group=$data[$i]['groupid'];
               if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";  
              }  else {
                //brand
                $subgrosssales=0;
                $subamountdiscount=0;
                $subreturns=0;
                $subnetsales=0;
                $subcostsales=0;
                $subgrossprofit=0;
                $submarginvscost=0;
                $submarginvssales=0;
                $subunitsold=0;
                $subaverageprice=0;
                $subaveragecost=0;
                //part
                $gsubgrosssales=0;
                $gsubamountdiscount=0;
                $gsubreturns=0;
                $gsubnetsales=0;
                $gsubcostsales=0;
                $gsubgrossprofit=0;
                $gsubmarginvscost=0;
                $gsubmarginvssales=0;
                $gsubunitsold=0;
                $gsubaverageprice=0;
                $gsubaveragecost=0;
                $brand=strtoupper($data[$i]['brand']);  
              }
             
            }
   
    
    
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($group,'175',null,false,'1px solid ','','L','Century Gothic','9','B','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        
    Yii::$app->reporter->endrow();
        
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($brand,'175',null,false,'1px solid ','','L','Century Gothic','9','Bi','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px solid ','','R','Century Gothic','9','','30px','0px');
    Yii::$app->reporter->endrow();  
        
    
    
        $gsales=number_format($data[$i]['gsales'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $sales=number_format($data[$i]['sales'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $disc=number_format($data[$i]['disc'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $sreturn=number_format($data[$i]['sreturn'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $cogs=number_format($data[$i]['cogs'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        
        $netsales= $data[$i]['sales'] - $data[$i]['sreturn'] ;
        $grossprofit = $netsales - $data[$i]['cogs'];
        if($cogs!=0){
        $marginvscost= ($grossprofit/$data[$i]['cogs']) *100;    
        } else {
        $marginvscost=0;    
        }
        if($netsales!=0){
        $marginvssales= ($grossprofit/$netsales) *100;    
        } else {
        $marginvssales=0;    
        }
        if($data[$i]['qty']!=0){
        $averageprice=$netsales/$data[$i]['qty'];    
        } else {
        $averageprice=0;    
        }
        if($data[$i]['qty']!=0){
        $averagecost=$cogs/$data[$i]['qty'];    
        } else {
        $averagecost=0;    
        }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['itemname'],'175','','','1px solid ','','L','century gothic','9','','','');
        Yii::$app->reporter->col($gsales,'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col($disc,'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col($sreturn,'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col(number_format($netsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col($cogs,'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col(number_format($grossprofit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col(number_format($marginvscost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col(number_format($marginvssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col(number_format($averageprice,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','','R','century gothic','9','','','');
        Yii::$app->reporter->col(number_format($averagecost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','','R','century gothic','9','','','');
        
        $gsales=number_format($data[$i]['gsales'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $sales=number_format($data[$i]['sales'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $disc=number_format($data[$i]['disc'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $sreturn=number_format($data[$i]['sreturn'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        $cogs=number_format($data[$i]['cogs'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        
        $netsales= $data[$i]['sales'] - $data[$i]['sreturn'] ;
        $grossprofit = $netsales - $data[$i]['cogs'];
        if($cogs!=0){
        $marginvscost= ($grossprofit/$data[$i]['cogs']) *100;    
        } else {
        $marginvscost=0;    
        }
        if($netsales!=0){
        $marginvssales= ($grossprofit/$netsales) *100;    
        } else {
        $marginvssales=0;    
        }
        if($data[$i]['qty']!=0){
        $averageprice=$netsales/$data[$i]['qty'];    
        } else {
        $averageprice=0;    
        }
        if($data[$i]['qty']!=0){
        $averagecost=$cogs/$data[$i]['qty'];    
        } else {
        $averagecost=0;    
        }
        
        $totalgrosssales=$totalgrosssales + $data[$i]['gsales'];
        $totalamountdiscount=$totalamountdiscount + $data[$i]['disc'];
        $totalreturns=$totalreturns + $data[$i]['sreturn'];
        $totalnetsales=$totalnetsales + $netsales;
        $totalcostsales=$totalcostsales + $data[$i]['cogs'];
        $totalgrossprofit=$totalgrossprofit + $grossprofit;
        $totalmarginvscost=$totalmarginvscost + $marginvscost;
        $totalmarginvssales=$totalmarginvssales + $marginvssales;
        $totalunitsold=$totalunitsold + $data[$i]['qty'];
        $totalaverageprice=$totalaverageprice + $averageprice;
        $totalaveragecost=$totalaveragecost + $averagecost;
        
        
        $subgrosssales=$subgrosssales + $data[$i]['gsales'];
        $subamountdiscount=$subamountdiscount + $data[$i]['disc'];
        $subreturns=$subreturns + $data[$i]['sreturn'];
        $subnetsales=$subnetsales + $netsales;
        $subcostsales=$subcostsales + $data[$i]['cogs'];
        $subgrossprofit=$subgrossprofit + $grossprofit;
        $submarginvscost=$submarginvscost + $marginvscost;
        $submarginvssales=$submarginvssales + $marginvssales;
        $subunitsold=$subunitsold + $data[$i]['qty'];
        $subaverageprice=$subaverageprice + $averageprice;
        $subaveragecost=$subaveragecost + $averagecost;
        //part
        $gsubgrosssales=$subgrosssales + $gsales;
        $gsubamountdiscount=$subamountdiscount + $disc;
        $gsubreturns=$subreturns + $sreturn;
        $gsubnetsales=$subnetsales + $netsales;
        $gsubcostsales=$subcostsales + $cogs;
        $gsubgrossprofit=$subgrossprofit + $grossprofit;
        $gsubmarginvscost=$submarginvscost + $marginvscost;
        $gsubmarginvssales=$submarginvssales + $marginvssales;
        $gsubunitsold=$subunitsold + $data[$i]['qty'];
        $gsubaverageprice=$subaverageprice + $averageprice;
        $gsubaveragecost=$subaveragecost + $averagecost;
        
        
        $brand=strtoupper($data[$i]['brand']);
        $group=$data[$i]['groupid'];
      
    
if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();

                Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ANALYZE ITEM SALES WITH PROFIT MARKUP',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow(null,null,'','1px solid ','','r','Century Gothic','10','','');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,'','1px solid ','','r','Century Gothic','10','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('1000');

        Yii::$app->reporter->startrow();
        if($params['client']==''){
        Yii::$app->reporter->col('Customer : ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Customer : '.strtoupper($params['client']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['item']==''){
        Yii::$app->reporter->col('Item :'.' ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'.strtoupper($params['item']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Group : '.strtoupper($params['group']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand : '.strtoupper($params['brand']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        if($params['part']==''){
        Yii::$app->reporter->col('Part :'.' ALL',null,null,'','1px solid ','','l','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Part :'.strtoupper($params['part']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        }
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->col('Status: '. strtoupper($params['itemtype']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        //Yii::$app->reporter->col('Center: '. strtoupper($cname),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->col('Warehouse: '. strtoupper($params['wh']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<BR>ITEM DESCRIPTION','175','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('GROSS<BR>SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AMOUNT<BR>DISCOUNT' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('<BR>RETURNS' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('NET<BR>SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('COST OF<BR>SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('GROSS<BR>PROFIT' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('%MARGIN<BR>vs COST' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('%MARGIN<BR>vs SALES' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('UNITS<BR>SOLD' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AVERAGE<BR>PRICE' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->col('AVERAGE<BR>COST' ,'75','','','1px solid ','TB','C','century gothic','9','B','','');
        Yii::$app->reporter->endrow();
        $page=$page + $count;
        }
    }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($brand.' '.'SUB TOTAL:','175',null,false,'1px solid ','','R','Century Gothic','9','Bi','30px','0px');
        Yii::$app->reporter->col(number_format($subgrosssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($subamountdiscount,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($subreturns,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($subnetsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($subcostsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($subgrossprofit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($submarginvscost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($submarginvssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->endrow(); 

        Yii::$app->reporter->startrow(); 
        Yii::$app->reporter->col($group.' '.'SUB TOTAL:','175',null,false,'1px solid ','','R','Century Gothic','9','Bi','30px','0px');
        Yii::$app->reporter->col(number_format($gsubgrosssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($gsubamountdiscount,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($gsubreturns,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($gsubnetsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($gsubcostsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($gsubgrossprofit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($gsubmarginvscost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col(number_format($gsubmarginvssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->col('','75',null,false,'1px dotted ','T','R','Century Gothic','9','','30px','0px');
        Yii::$app->reporter->endrow(); 
    
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('GRAND TOTAL :','175','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalgrosssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalamountdiscount,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalreturns,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalnetsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalcostsales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalgrossprofit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmarginvscost,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col(number_format($totalmarginvssales,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col('','75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col('','75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->col('','75','','','1px solid ','TB','R','century gothic','9','B','','');
        Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);


?>