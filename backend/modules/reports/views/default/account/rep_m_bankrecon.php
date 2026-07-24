<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'General Journal Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

Yii::$app->reporter->beginreport('1200');

Yii::$app->reporter->begintable('1200');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('BANK STATEMENT','1200',null,false,'1px solid ','','C','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($start. ' - ' .$end,'1200',null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1200');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ACCOUNT # : ','50',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($contra[0],'520',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BANK : ','80',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col($contra[1],'500',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('BEGINNING BALANCE :','200',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col((isset($data[0]['bal'])? number_format($data[0]['bal'],Yii::$app->systemsettings->setDecimaldisplay('currency')):''),'300',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();

//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1200');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid ','B','L','Century Gothic','12','','20px','2px');
        Yii::$app->reporter->col('DOCUMENT #','150',null,false,'1px solid ','B','L','Century Gothic','12','','20px','2px');
        Yii::$app->reporter->col('PAYEE','250',null,false,'1px solid ','B','L','Century Gothic','12','','20px','2px');
        Yii::$app->reporter->col('PARTICULARS','250',null,false,'1px solid ','B','L','Century Gothic','12','','20px','2px');
        Yii::$app->reporter->col('CHECK #','150',null,false,'1px solid ','B','L','Century Gothic','12','','20px','2px');
        Yii::$app->reporter->col('DEBIT','100',null,false,'1px solid ','B','R','Century Gothic','12','','20px','2px');
        Yii::$app->reporter->col('CREDIT','100',null,false,'1px solid ','B','R','Century Gothic','12','','20px','2px');
        Yii::$app->reporter->col('BALANCE','100',null,false,'1px solid ','B','R','Century Gothic','12','','20px','2px');

    $totaldb=0;
    $totalcr=0;
    $bal = 0;
    
    for($i=0;$i<count($data);$i++){
        
        $debit=number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        
        if ($debit<1){ 
            $debit='-';
        }//end if
         
        $credit=number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
        
        if ($credit<1){
            $credit='-';
        }//end if

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['docno'],'150',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['clientname'],'250',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['rem'],'250',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($data[$i]['checkno'],'250',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($debit,'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
        Yii::$app->reporter->col($credit,'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');

        if($i == 0){
            $bal = $data[$i]['db'] - $data[$i]['cr'];
        }else{
            $bal = abs($bal) + $data[$i]['cr'];
            $bal = $data[$i]['db'] - $bal;
        }//end if
        
        $totaldb=$totaldb+$data[$i]['db'];
        $totalcr=$totalcr+$data[$i]['cr'];

        Yii::$app->reporter->col(number_format($bal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','11','','','2px');
    }//end for each

    Yii::$app->reporter->endtable();
    Yii::$app->reporter->endreport();
?>