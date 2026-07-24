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
        Yii::$app->reporter->col('Receiving Report (SUMMARIZED)',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','10','','30px','5px');
        //Yii::$app->reporter->col('Sort By : ' .strtoupper($sortby),NULL,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Date Range: '.$start.' to '.$end,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
        Yii::$app->reporter->col('User: '.$user,null,null,false,'1px solid ','','','Century Gothic','10','B','','');
                Yii::$app->reporter->col('Prefix: '.$params['bref'],'125',null,false,'1px solid ','','L','Century Gothic','11','B','false','8px');

        // Yii::$app->reporter->col('Printdate: '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','B','Century Gothic','10','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
$docno="";
$total = 0;

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('Document No.','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('Date','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('Name','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('Warehouse','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('Amount','150',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('Remarks','100',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 

for($i=0;$i<count($data);$i++)
{

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','B','C','Century Gothic','11','','30px','8px');
                Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','B','C','Century Gothic','11','','30px','8px');
                Yii::$app->reporter->col($data[$i]['supplier'],'150',null,false,'1px solid ','B','C','Century Gothic','11','','30px','8px');
                Yii::$app->reporter->col($data[$i]['whname'],'150',null,false,'1px solid ','B','C','Century Gothic','11','','30px','8px');
                Yii::$app->reporter->col(number_format($data[$i]['amount'],2),'150',null,false,'1px solid ','B','C','Century Gothic','11','','30px','8px');
                Yii::$app->reporter->col($data[$i]['hrem'],'100',null,false,'1px solid ','B','C','Century Gothic','11','','30px','8px');
                
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->addline();
        $total = $total + $data[$i]['amount'];
    Yii::$app->reporter->endtable();
    if($i==count($data)-1){
        Yii::$app->reporter->begintable('800');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('Total: '.number_format($total,2),'800',null,false,'1px solid','','R','Century Gothic','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
    }
}

?>