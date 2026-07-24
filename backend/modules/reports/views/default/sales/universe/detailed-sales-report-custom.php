<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Detailed Sales - Transaction Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
ini_set("memory_limit", "-1");
$pagenumber=1;
$count=6;
$page=6;

// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('2200');
    Yii::$app->reporter->begintable('2200');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('2000');
//header
    $start=$params['start'];
    $end=$params['end'];

    Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Detailed Sales - Transaction Report',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        Yii::$app->reporter->col('Date Range: '.$start.' to '.$end,null,null,false,'1px solid ','','','Helvetica','10','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        if($params['barcode'] == ""){
            Yii::$app->reporter->col('Item: ALL',null,null,false,'1px solid ','','','Helvetica','10','B','','');
        }else{
            Yii::$app->reporter->col('Item: ' . $params['itemname'] . ' - ' . $params['barcode'],null,null,false,'1px solid ','','','Helvetica','10','B','','');
        }//end if
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        Yii::$app->reporter->col('Warehouse: ' . $params['wh'],null,null,false,'1px solid ','','','Helvetica','10','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        Yii::$app->reporter->col('Post Status: '. $params['poststatus'],null,null,false,'1px solid ','','','Helvetica','10','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        if($params['principalid'] == ""){
            Yii::$app->reporter->col('Principal: ALL',null,null,false,'1px solid ','','','Helvetica','10','B','','');
        }else{
            Yii::$app->reporter->col('Principal: ' . $params['principalid'],null,null,false,'1px solid ','','','Helvetica','10','B','','');
        }//end if
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        if($params['divisionid'] == ""){
            Yii::$app->reporter->col('Division: ALL',null,null,false,'1px solid ','','','Helvetica','10','B','','');
        }else{
            Yii::$app->reporter->col('Division: ' . $params['divisionid'],null,null,false,'1px solid ','','','Helvetica','10','B','','');
        }//end if
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');    
        Yii::$app->reporter->col('Price Group: ' . $params['pricegroup'],null,null,false,'1px solid ','','','Helvetica','10','B','','');
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Helvetica','10','','30px','5px');
        Yii::$app->reporter->col('Transaction Type: ' . $params['trnxtype'],null,null,false,'1px solid ','','','Helvetica','10','B','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$docno="";
$total=0;
    Yii::$app->reporter->begintable('2400');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->col('Customer Name','450',null,false,'1px solid ','B','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Transaction Date','200',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Document #','200',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Yourref #','200',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Ourref #','200',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Barcode','200',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Itemname','450',null,false,'1px solid ','B','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Gross Price','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Discount','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Net Price','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('Total Amount','100',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable(); 
// var_dump(count($data));
for($i=0;$i<count($data);$i++){
    /* if($docno!=""&&$docno!=$data[$i]['docno']){
        Yii::$app->reporter->begintable('2200');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Total: '.number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'900',null,false,'1px solid','','R','Helvetica','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
    } */
    //if($docno=="" || $docno!=$data[$i]['docno']) 
    //{
      //  $docno=$data[$i]['docno'];
        
       /*  Yii::$app->reporter->begintable('2200');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Doc#: '.$data[$i]['docno'],'125',null,false,'1px solid ','','L','Helvetica','11','B','false','8px');
                Yii::$app->reporter->col('Date: '.$data[$i]['dateid'],'125',null,false,'1px solid ','','L','Helvetica','11','B','false','8px');
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Customer: '.$data[$i]['supplier'],'125',null,false,'1px solid ','','L','Helvetica','11','B','false','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); */

        
    //} 

    Yii::$app->reporter->begintable('2400');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['supplier'],'450',null,false,'1px solid ','','L','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['dateid'],'200',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['docno'],'200',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['yourref'],'200',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['ourref'],'200',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['barcode'],'200',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['itemname'],'450',null,false,'1px solid ','','L','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['isqty'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['disc'],'100',null,false,'1px solid ','','C','Helvetica','11','','30px','8px');
            if($data[$i]['isqty'] == 0){
                Yii::$app->reporter->col(0.00,'100',null,false,'1px solid ','','R','Helvetica','11','','30px','8px');
            }else{
                Yii::$app->reporter->col(number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','','30px','8px');
            }//end if
            Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Helvetica','11','','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->addline();
        $total+=$data[$i]['ext'];

    Yii::$app->reporter->endtable();
    if($i==count($data)-1)
    {
        Yii::$app->reporter->begintable('2400');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Total: '.number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'900',null,false,'1px solid','','R','Helvetica','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
    }
}
?>