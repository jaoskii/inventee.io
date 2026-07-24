<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Sales Journal Report - SUMMARY';
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
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
//header
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
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
            //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
            Yii::$app->reporter->col('Status: '.strtoupper($params['poststatus']),null,null,false,'1px solid ','','','Century Gothic','10','B','','');
            Yii::$app->reporter->col('Report Type: '.strtoupper($params['reporttype']),null,null,false,'1px solid ','','','Century Gothic','10','B','','');
            // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','B','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
       Yii::$app->reporter->startrow();
       Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('CUSTOMER','300',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
      // Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');
       Yii::$app->reporter->col('STATUS','100',null,false,'1px solid ','TB','C','Century Gothic','12','B','','');

     
$totalext=0;
$totalbal=0;
//Sales with Return Report
Yii::$app->reporter->begintable('800');
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->addline();
    Yii::$app->reporter->startrow();
    
       Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
       Yii::$app->reporter->col($data[$i]['supplier'],'300',null,false,'1px solid ','','L','Century Gothic','11','','','');
       Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
       Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
       //Yii::$app->reporter->col(number_format($data[$i]['bal'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
       Yii::$app->reporter->col($data[$i]['status'],'100',null,false,'1px solid ','','C','Century Gothic','11','','','');
       
       $totalext=$totalext+$data[$i]['ext'];
       //$totalbal=$totalbal+$data[$i]['bal'];
       Yii::$app->reporter->endrow();

}

       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','10','','','');
       Yii::$app->reporter->col('','300',null,false,'1px solid ','TB','C','Century Gothic','10','','','');
       Yii::$app->reporter->col('TOTAL :','100',null,false,'1px solid ','TB','R','Century Gothic','10','','','');
       Yii::$app->reporter->col(number_format($totalext,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','TB','R','Century Gothic','10','B','','');
       //Yii::$app->reporter->col(number_format($totalbal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','TB','R','Century Gothic','10','B','','');
       Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','10','','','');

Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();


?>
