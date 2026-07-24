<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Inventory Movement Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=40;
$page=40;

Yii::$app->reporter->beginreport('1000');

    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('INVENTORY MOVEMENT REPORT',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br /><br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow('1000',null,'','1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),null,null,'','1px solid ','','l','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        if($params['part']==''){
        Yii::$app->reporter->col('Part : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Part : '. $params['part'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        if($params['group']==''){
        Yii::$app->reporter->col('Group : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Group : '. $params['group'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Brand :'. $params['brand'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }

         if($params['category']==''){
        Yii::$app->reporter->col('Category : ALL',null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Category :'. $params['category'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');    
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();

        
       
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','200',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('BEG. QTY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('IN QTY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('OUT QTY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('COST','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
     
// var_dump($data);
$part="";
$brand="";
$totalext=0;
$costgtotal = 0;
for($i=0;$i<count ($data);$i++){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
              if (strtoupper($brand)==strtoupper($data[$i]['category'])){
                $brand="";  
              }  else {
                $brand=strtoupper($data[$i]['category']);  
              }


              Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($brand,'100',null,false,'1px solid ','','R','Century Gothic','11','Bi','','');
                Yii::$app->reporter->col('','450',null,false,'1px solid ','','L','Century Gothic','11','Bi','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','11','','','');
                Yii::$app->reporter->col('','75',null,false,'1px solid ','','C','Century Gothic','11','','','');
                Yii::$app->reporter->col('','75',null,false,'1px solid ','','C','Century Gothic','11','','','');
                Yii::$app->reporter->endrow();
                Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col(number_format($data[$i]['begbal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col(number_format($data[$i]['inqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col(number_format($data[$i]['outqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
            $balance = (floatval($data[$i]['begbal']) + floatval($data[$i]['inqty'])) - floatval($data[$i]['outqty']);
            Yii::$app->reporter->col(abs($balance),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col(number_format($data[$i]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
            $totalext = number_format(floatval($data[$i]['cost']) * floatval($balance),Yii::$app->systemsettings->setDecimaldisplay('currency'));
            $costgtotal = $costgtotal + floatval(floatval($data[$i]['cost']) * floatval($balance));
            Yii::$app->reporter->col($totalext,'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

         $brand=strtoupper($data[$i]['category']);
}
  
Yii::$app->reporter->begintable('1000');
echo '<br/>';
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','11','Bi','','');
        Yii::$app->reporter->col('','450',null,false,'1px solid ','','L','Century Gothic','11','Bi','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('Grand Total: ','75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col(number_format($costgtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','','R','Century Gothic','11','Bi','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();       

    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();


//var_dump($params);
?>