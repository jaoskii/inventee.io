<?php
use yii\base\ErrorException;
date_default_timezone_set('Asia/Manila');
$this->title = 'Income Statement';
try {
    
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=57;
$page=57;

Yii::$app->reporter->beginreport();

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('INCOME STATEMENT',null,null,false,'1px solid ','','','Century Gothic','15','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('','200');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();


Yii::$app->reporter->begintable();
$totalgrossprofit = 0;
$afteroperation = false;
$netprofit = 0;
$incomelossfromop = 0;
$opex = 0;
for($i=0;$i<count($data);$i++){
    if(isset($data[$i]['alias'])){ 
        if($data[$i]['alias'] == "OPX"){
            $opex = $data[$i]['total'];
        }//end if
    }//end if

    if(isset($data[$i]['keycode'])){
        if($data[$i]['keycode'] == "KGP"){
            $totalgrossprofit = $data[$i]['total'];
        }//END IF

        if($data[$i]['keycode'] == "ILFO"){
            $data[$i]['total'] = $totalgrossprofit - $opex;
            $incomelossfromop = $data[$i]['total'];
            $afteroperation = true;
        }//END IF

        if($data[$i]['keycode'] == "NETPROF"){
            $data[$i]['total'] = $netprofit;
        }//END IF
    }//end if

    if($afteroperation){
        $netprofit = $incomelossfromop + $data[$i]['total'];
    }//end if

    Yii::$app->reporter->startrow();
    //$txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
    $indent='5' * ($data[$i]['levelid'] * 3);
    Yii::$app->reporter->addline();
    
    Yii::$app->reporter->col($data[$i]['acnoname'],'280',null,false,'1px solid ','','','Century Gothic','10','','','0px 0px 0px '. $indent.'px');
    if($data[$i]['amt']==0){
        $amt='';
    }else{
        $amt=number_format($data[$i]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
    }
    Yii::$app->reporter->col($amt,'100',null,false,'1px solid ','','r','Century Gothic','10','','','2px');
    
    if($data[$i]['total']==0){
        $total='';
    }else{
        if($amt==0){
        $total=number_format($data[$i]['total'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        }else{$total='';}
    }//END 

    if($total != ""){
        if(isset($data[$i]['doubleline'])){
            Yii::$app->reporter->col('<div style="border-bottom:solid 1px;">'.$total.'</div>','100',null,false,'1px solid ','BT','r','Century Gothic','10','b','','2px');
        }else{
            Yii::$app->reporter->col($total,'100',null,false,'1px solid ','BT','r','Century Gothic','10','b','','2px');
        }//end if
    }//end if

    Yii::$app->reporter->endrow();
// }
    if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();

        Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('INCOME STATEMENT',null,null,false,'1px solid ','','','Century Gothic','15','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('','200');
        
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->printline();

        Yii::$app->reporter->begintable();
        $page=$page + $count;
    }
}
Yii::$app->reporter->endtable();


Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

} catch (ErrorException $e) {
    echo $e;
}
?>