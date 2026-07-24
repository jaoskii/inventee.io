<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Receiving Report';
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
        Yii::$app->reporter->col('Receiving Report',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Date Range: '.$start.' to '.$end,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('User: '.$user,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
                Yii::$app->reporter->col('Prefix: '.$params['bref'],'125',null,false,'1px solid ','','L','Century Gothic','11','B','false','8px');

        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','B','Century Gothic','10','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

// Yii::$app->reporter->printline();
Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
                Yii::$app->reporter->col('Date','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Supplier','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Item','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                 Yii::$app->reporter->col('CARTEL#','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('PLATE#','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Net','75',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Total Sako','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Minus Sako','50',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Total Net','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Price','100',null,false,'1px solid ','B','R','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Amount','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
                
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
// $docno="";
// var_dump(count($data));
Yii::$app->reporter->begintable('800');
    // Yii::$app->reporter->startrow();
// var_dump($data);
// return 0;
$gtotal=0;
for($i=0;$i<count($data);$i++)
{
$str = $data[$i]['rem'];
$str=explode(",",$str);
                Yii::$app->reporter->startrow();
                $net=$data[$i]['msako']+$data[$i]['rrqty'];
                Yii::$app->reporter->col($data[$i]['dateid'],'50',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col($data[$i]['supplier'],'100',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col($data[$i]['itemname'],'100',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                
                Yii::$app->reporter->col($data[$i]['cartelnum'],'50',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col($data[$i]['platenum'],'75',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');

                Yii::$app->reporter->col(number_format($net,Yii::$app->systemsettings->setDecimaldisplay('quantity')),'75',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col(number_format($data[$i]['tsako'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col(number_format($data[$i]['msako'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'50',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col(number_format($data[$i]['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')),'100',null,false,'1px solid ','','C','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col(number_format($data[$i]['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','30px','8px');
                Yii::$app->reporter->col(number_format($data[$i]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','30px','8px');
                $gtotal=$gtotal+$data[$i]['ext'];
}
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 

Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','600',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','8px');
                Yii::$app->reporter->col('Grand Total','100',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','8px');

                Yii::$app->reporter->col(number_format($gtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','TB','R','Century Gothic','12','B','30px','8px');
                
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 


?>