<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Back Order Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('800');

Yii::$app->reporter->beginreport();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PANDA CONSTRUCTION SUPPLY INC.','600',null,false,'1px solid ','','L','Century Gothic','16','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('450 E.T. Yuchengco St.,(Formerly Nueva St.) Binondo,Manila','600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Tels.:242-61-54 to 56* Fax: (63-2)241-2860','600',null,false,'1px solid ','','L','Century Gothic','13','B','','1px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('BACK ORDER REPORT',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Supplier : '.$params['client'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])). ' TO ' . date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DATE','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM CODE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ITEM DESCRIPTION','400',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('ORDER QTY','75',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('PENDING QTY','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        
    //var_dump($data);
        $totalamt=0;
for($i=0;$i<count($data);$i++){
    Yii::$app->reporter->startrow();
            $oqty=number_format($data[$i]['oqty'],2);
            if ($oqty==0)
            {
            $oqty='-';
            }
            $pending=number_format($data[$i]['pending'],2);
            if ($pending==0)
            {
            $pending='-';
            }
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['dateid'],'75',null,false,'1px solid ','','C','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['barcode'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($data[$i]['itemname'],'400',null,false,'1px solid ','','L','Century Gothic','11','','','');
        Yii::$app->reporter->col($oqty,'75',null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col($pending,'100',null,false,'1px solid ','','R','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
}   
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>