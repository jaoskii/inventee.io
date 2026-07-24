<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Report By Brand Report';
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

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PURCHASE REPORT BY BRAND',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Brand : '. strtoupper($params['brand']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])). ' TO ' . date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','C','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('REFERENCE #','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('SUPPLIER NAME','250',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('BRAND','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('AMOUNT','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
       
    //var_dump($data);
        $totalamt=0;
for($i=0;$i<count($data);$i++){
            $amt=number_format($data[$i]['amount'],2);
            if ($amt==0)
            {
            $amt='-';
            }      
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['date'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['reference'],'150',null,false,'1px solid ','','C','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['supplier'],'250',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col($data[$i]['brand'],'100',null,false,'1px solid ','','C','Century Gothic','10','','','');
        Yii::$app->reporter->col($amt,'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
        $totalamt=$totalamt+$data[$i]['amount'];
        
}   

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','150',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col('','250',null,false,'1px solid ','TB','R','Century Gothic','11','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
        Yii::$app->reporter->col(number_format($totalamt,2),'100',null,false,'1px solid ','TB','R','Century Gothic','11','B','','');
        Yii::$app->reporter->endrow();
       // Yii::$app->reporter->endtable();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();

        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>