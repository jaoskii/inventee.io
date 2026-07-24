<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Cash/Check Voucher Report';
//WTODO: [JLY][8.23.2019][KINGG][EDIT REPORTS]
try {
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=30;
$page=30;

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        
        Yii::$app->reporter->col('CHECK VOUCHER','800',null,false,'1px solid ','','R','Century Gothic','18','B','','');
        Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');

        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('No. :','100',null,false,'1px solid ','','R','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','R','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PAYEE : ','80',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'520',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('DATE : ','100',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'100',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
echo '<br>';
$crsum=0;
$bank='';
$checkno='';
// var_dump($data);
// return 0;
for ($s=0; $s <count($data) ; $s++) { 
    
    if($data[$s]['alias']=='CB'){
        $crsum=$crsum+$data[$s]['cr'];    
        $bank=$data[$s]['checkno'];
        
        if(strpos($bank, ',')){
            $checkno=explode(',',$bank);                
        }//end if
        
    }//end switch
}//end for each


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','TBL','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('PARTICULARS','500',null,false,'1px solid ','TB','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('AMOUNT','200',null,false,'1px solid ','LTRB','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','L','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['rem'])? $data[0]['rem']:''),'500',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col(number_format($crsum,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','Lr','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->endrow();


        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','L','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','500',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','LR','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','L','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','500',null,false,'1px solid ','R','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','RB','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->endrow();

         Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','Lb','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('(pls. see attached)','500',null,false,'1px solid ','b','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('<p style="text-decoration-line:underline;border-bottom: double 1px;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.number_format($crsum,Yii::$app->systemsettings->setDecimaldisplay('currency')).'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>','200',null,false,'1px solid ','LRb','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->endrow();

        /*Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','100',null,false,'1px solid ','L','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('(pls. see attached)','500',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','10',null,false,'1px solid ','L','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('<div style="border-bottom: 1px solid;">'.number_format($crsum,Yii::$app->systemsettings->setDecimaldisplay('currency')).'</div>','160',null,false,'1px solid ','RBT','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','30',null,false,'1px solid ','R','C','Century Gothic','12','B','30px','4px');

        Yii::$app->reporter->endrow();*/
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('AMOUNT IN WORDS:','200',null,false,'1px solid ','LB','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col(Yii::$app->backend->ftNumberToWordsConverter($crsum).' PESOS ONLY','600',null,false,'1px solid ','BR','L','Century Gothic','12','','30px','4px');
        
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('ACCOUNT TITLE','500',null,false,'1px solid ','LB','C','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('DEBIT','150',null,false,'1px solid ','LB','C','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('CREDIT','150',null,false,'1px solid ','RLB','C','Century Gothic','12','B','30px','4px');
        for ($i=0; $i < count($data); $i++) { 
            if($data[$i]['db']<>0){
                $db= number_format($data[$i]['db'],2);
            }else{
                $db= '&nbsp';
            }
            if($data[$i]['cr']<>0){
                $cr= number_format($data[$i]['cr'],2);
            }else{
                $cr= '&nbsp';
            }
            Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['acnoname'],'500',null,false,'1px solid ','L','L','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col($db,'150',null,false,'1px solid ','L','C','Century Gothic','12','','30px','4px');
            Yii::$app->reporter->col($cr,'150',null,false,'1px solid ','RL','C','Century Gothic','12','','30px','4px');
        }
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col('&nbsp','500',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp','150',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','4px');
            Yii::$app->reporter->col('&nbsp','150',null,false,'1px solid ','T','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
        
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('BANK','75',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        if($checkno == ''){
            Yii::$app->reporter->col($checkno,'275',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','4px');
        }else{
            Yii::$app->reporter->col($checkno[0],'275',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','4px');
        }//end
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('Receive Payment By:','200',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('CHECK NO.','75',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        
        if($checkno == ''){
            Yii::$app->reporter->col($checkno,'275',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','4px');
        }else{
            Yii::$app->reporter->col($checkno[1],'275',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','4px');
        }//end
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','B','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('&nbsp','75',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        
        Yii::$app->reporter->col('&nbsp','275',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('Signature Over Printed Name','200',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();



Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','200',null,false,'1px solid ','','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('Certified Correct By: ','200',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Approved By','200',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'200',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col($approved,'200',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col($checked,'200',null,false,'1px solid ','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();

//var_dump($params);

    
} catch (ErrorException $e) {
    echo $e;
}
?>