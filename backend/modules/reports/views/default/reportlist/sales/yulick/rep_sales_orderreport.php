<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Order Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$pagenumber=1;
$count=38;
$page=38;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
//header
// var_dump($params);
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
        Yii::$app->reporter->col('Sales Order Report',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Date Range: '.$start.' to '.$end,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('User: '.$user,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('Prefix: '.$params['bref'],null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','B','Century Gothic','10','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
$docno="";
// var_dump(count($data));
for($i=0;$i<count($data);$i++)
{
    
    if($docno!=""&&$docno!=$data[$i]['docno']){

        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('','300',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('TOTAL :','100',null,false,'1px solid ','','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
    }
    if($docno=="" || $docno!=$data[$i]['docno']) 
    {
        $docno=$data[$i]['docno'];
        $total=0;
        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Doc#: '.$data[$i]['docno'] . '&nbsp;&nbsp;/&nbsp;&nbsp;'.'Yourref: '.$data[$i]['yourref'],'125',null,false,'1px solid ','','L','Century Gothic','11','B','false','8px');
                Yii::$app->reporter->col('Date: '.$data[$i]['dateid'],'125',null,false,'1px solid ','','L','Century Gothic','11','B','false','8px');
            Yii::$app->reporter->endrow();
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Customer: '.$data[$i]['supplier'],'125',null,false,'1px solid ','','L','Century Gothic','11','B','false','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('PENDING QTY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('ITEM NAME','300',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('QTY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('UOM','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('PRICE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('TOTAL','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
    } 
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col(number_format($data[$i]['qa'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['itemname'],'300',null,false,'1px solid ','','L','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['iss'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col($data[$i]['uom'],'100',null,false,'1px solid ','','C','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['isamt'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
            Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','30px','8px');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->addline();
        
        if($docno==$data[$i]['docno']) {
            $total+=$data[$i]['ext'];
        }
    Yii::$app->reporter->endtable();
    if($i==count($data)-1)
    {
        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col('','300',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('','100',null,false,'1px solid ','','C','Century Gothic','11','B','30px','8px');
            Yii::$app->reporter->col('TOTAL :','100',null,false,'1px solid ','','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->col(number_format($total,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','12','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 

    }
}
    
?>