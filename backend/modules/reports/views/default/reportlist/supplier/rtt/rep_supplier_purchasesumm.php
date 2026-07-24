<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Summary';
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
echo '<br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PURCHASE SUMMARY',800,null,false,'1px solid ','','C','Century Gothic','16','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['startdate'])) .' TO '. date('M-d-Y', strtotime($params['enddate'])),800,null,false,'1px solid ','','C','Century Gothic','14','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->printline();



Yii::$app->reporter->begintable('800');


if (strtoupper($params['vattype'])!='ALL'){
    if (strtoupper($params['vattype'])=='CASH'){
        $vattype = 'VATABLE';    
    }else{
        $vattype = 'NON-VATABLE';
    }
    
}else{
    $vattype = 'ALL';
}


        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','b','');
        Yii::$app->reporter->col('Vat : '.$vattype,250,null,false,'1px solid ','','L','Century Gothic','11','','b','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();


// //($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('SUPPLIER','400',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->col('AMOUNT','200',null,false,'1px dotted ','TB','C','Century Gothic','11','B','','3px');
        Yii::$app->reporter->endrow();

      
$totalamt=$totalamt=0;
for($i=0;$i<count($data);$i++){
            
    Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['code'],'200',null,false,'1px solid ','','C','Century Gothic','10','','','1px');
        Yii::$app->reporter->col($data[$i]['clientname'],'400',null,false,'1px solid ','','L','Century Gothic','10','','','1px');
        Yii::$app->reporter->col(number_format($data[$i]['total'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Century Gothic','10','','','1px');
        $totalamt=$totalamt+$data[$i]['total'];
        
    Yii::$app->reporter->endrow();

     
    }
    

   

    Yii::$app->reporter->startrow();
     echo '<br/>';
       Yii::$app->reporter->col('','200',null,false,'1px dotted ','T','C','Century Gothic','11','B','','3px');
       Yii::$app->reporter->col('','400',null,false,'1px dotted ','T','C','Century Gothic','11','B','','3px');
       Yii::$app->reporter->col(number_format($totalamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','T','R','Century Gothic','11','B','','3px');
    Yii::$app->reporter->endrow();



    Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

// ?>