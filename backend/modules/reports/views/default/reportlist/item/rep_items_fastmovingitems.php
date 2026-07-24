<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Fast Moving Item';
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
        Yii::$app->reporter->col('FAST MOVING ITEMS',null,null,false,'1px solid ','','','Verdana','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,'','1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800'); 
        Yii::$app->reporter->startrow();
        if($params['item']==''){
        Yii::$app->reporter->col('Item : ALL','150',null,false,'1px solid ','','L','Verdana','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'.$params['item'],'150',null,false,'1px solid ','','L','Verdana','10','','','');
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Group :'. $params['group'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['class']==''){
        Yii::$app->reporter->col('Class : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Class'.$params['class'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['uom']==''){
        Yii::$app->reporter->col('Uom : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Uom : '.$params['uom'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        }
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(null,null,'','1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Item Type : '.strtoupper($params['itemtype']),null,null,'','1px solid ','','L','Century Gothic','10','','','');
        //Yii::$app->reporter->col('Center : '.$cname,null,null,'','1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PRODUCT CODE','150',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        Yii::$app->reporter->col('PRODUCT DESCRIPTION','500',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        Yii::$app->reporter->col('UOM','50',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        
$part="";
$brand="";
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
    if ($part==strtoupper($data[$i]['part'])){
              $part=""; 
              if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";  
              }  else {
                $brand=strtoupper($data[$i]['brand']);  
              }
            }
            else {
              $part=$data[$i]['part'];
               if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";  
              }  else {
                $brand=strtoupper($data[$i]['brand']);  
              }
            }
        Yii::$app->reporter->col($part,'150',null,false,'1px solid ','','L','Verdana','10','B','','');
        Yii::$app->reporter->col('','500',null,false,'1px solid ','','C','Verdana','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Verdana','10','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Verdana','10','B','','');
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($brand,'150',null,false,'1px solid ','','C','Verdana','10','Bi','','');
        Yii::$app->reporter->col('','500',null,false,'1px solid ','','C','Verdana','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Verdana','10','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Verdana','10','B','','');
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['barcode'],'150',null,false,'1px solid ','','C','Verdana','10','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'500',null,false,'1px solid ','','L','Verdana','11','','','');
        Yii::$app->reporter->col(number_format($data[$i]['qty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Verdana','11','','','');
        Yii::$app->reporter->col($data[$i]['uom'],'50',null,false,'1px solid ','','C','Verdana','11','','','');
        
        $brand=strtoupper($data[$i]['brand']);
        $part=$data[$i]['part'];
        Yii::$app->reporter->endrow();
        
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
        Yii::$app->reporter->col('FAST MOVING ITEMS',null,null,false,'1px solid ','','','Verdana','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,'','1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800'); 
        Yii::$app->reporter->startrow();
        if($params['item']==''){
        Yii::$app->reporter->col('Item : ALL','150',null,false,'1px solid ','','L','Verdana','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'.$params['item'],'150',null,false,'1px solid ','','L','Verdana','10','','','');
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Group :'. $params['group'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL','200',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['class']==''){
        Yii::$app->reporter->col('Class : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Class'.$params['class'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        }
        if($params['uom']==''){
        Yii::$app->reporter->col('Uom : ALL',null,null,'','1px solid ','','L','Century Gothic','10','','','');    
        } else {
        Yii::$app->reporter->col('Uom : '.$params['uom'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        }
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(null,null,'','1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Item Type : '.strtoupper($params['itemtype']),null,null,'','1px solid ','','L','Century Gothic','10','','','');
        //Yii::$app->reporter->col('Center : '.$cname,null,null,'','1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,'','1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PRODUCT CODE','150',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        Yii::$app->reporter->col('PRODUCT DESCRIPTION','500',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        Yii::$app->reporter->col('UOM','50',null,false,'1px solid ','B','C','Verdana','11','B','30px','8px');
        Yii::$app->reporter->endrow();
       Yii::$app->reporter->printline();
        $page=$page + $count;
    }   
        
}
    
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>