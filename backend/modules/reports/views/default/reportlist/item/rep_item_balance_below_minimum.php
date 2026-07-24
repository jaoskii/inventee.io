<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Item Balance - Below Minimum';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

Yii::$app->reporter->beginreport();

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='') 
        Yii::$app->reporter->col('Item Balance - Below Minimum','400',null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Balance as of : '. $params['asof'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        if($params['barcode']==''){
        Yii::$app->reporter->col('Items : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Items : '. $params['itemname'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        if($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Brand : '. $params['brand'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        if($params['categoryid']==''){
        Yii::$app->reporter->col('Category : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Category : '. $params['category'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
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
        
        if($params['genericid']==''){
        Yii::$app->reporter->col('Generic : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        } else {
        Yii::$app->reporter->col('Generic : '. $params['genericid'],null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');    
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        //Yii::$app->reporter->col('Center :'.$cname,null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        Yii::$app->reporter->col('WH : '.$params['wh'],null,null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Item Type : '. strtoupper($params['itemtype']),null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        /* switch($params['itemstock'])
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
        } */
        /* Yii::$app->reporter->col('Item Stock : '.strtoupper($options),null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');     */
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
          
        Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');   
Yii::$app->reporter->printline();     
Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BARCODE','200',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('ITEM DESCRIPTION','400',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('BALANCE','150',null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('MINIMUM STOCK','150',null,false,'1px solid ','','L','Helvetica','10','','','');
        
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->printline();


Yii::$app->reporter->begintable('800');   
$totalbal=0;
$totalmin=0;
$principal = "";

for($i=0;$i<count ($data);$i++){
    if($principal != $data[$i]['principal']){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('800');   
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','800',null,false,'1px solid ','','L','Helvetica','11','B','','');
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['principal'],'800',null,false,'1px solid ','','L','Helvetica','11','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('800');   
        $principal = $data[$i]['principal'];
    }//end if

    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col($data[$i]['barcode'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
    Yii::$app->reporter->col($data[$i]['itemname'],'200',null,false,'1px solid ','','L','Helvetica','10','','','');
    Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','R','Helvetica','10','','','');
    Yii::$app->reporter->col(number_format($data[$i]['balance'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Helvetica','10','','','');
    Yii::$app->reporter->col(number_format($data[$i]['minimum'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Helvetica','10','','','');
    $totalbal=$totalbal+$data[$i]['balance'];
    $totalmin=$totalmin+$data[$i]['minimum'];
    Yii::$app->reporter->endrow();
}


Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');   
Yii::$app->reporter->startrow();

  Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Helvetica','10','','','');
  Yii::$app->reporter->col('','200',null,false,'1px solid ','','R','Helvetica','10','','','');
  Yii::$app->reporter->col('Total','100',null,false,'1px solid ','','R','Helvetica','10','','','');
  Yii::$app->reporter->col(number_format($totalbal,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Helvetica','10','','','');
  Yii::$app->reporter->col(number_format($totalmin,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'150',null,false,'1px solid ','','R','Helvetica','10','','','');

        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();
?>