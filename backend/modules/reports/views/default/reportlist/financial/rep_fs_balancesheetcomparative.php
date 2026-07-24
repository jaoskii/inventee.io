<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Comparative Balance Sheet';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=50;
$page=50;

Yii::$app->reporter->beginreport();

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('COMPARATIVE BALANCE SHEET',null,null,false,'1px solid ','','','Century Gothic','15','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Center :  '.$params['center'],400,null,false,'1px solid ','','','Century Gothic','12','B','','');
//Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),400,null,false,'1px solid ','','R','Century Gothic','10','','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Year :  '.$params['year'],100,null,false,'1px solid ','','','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('POSTED',100,null,false,'1px solid ','','','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
Yii::$app->reporter->pagenumber('Page');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('ACCOUNTS','300',null,false,'1px solid ','B','','Century Gothic','12','B','','');
Yii::$app->reporter->col($params['year']-2,'110',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
Yii::$app->reporter->col($params['year']-1,'110',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
Yii::$app->reporter->col($params['year'],'110',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
Yii::$app->reporter->col('TOTAL','170',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
    
//var_dump($data);

for($i=0;$i<count($data);$i++){

    $lineTotal=0;
    $bold='';
    
//    if($data[$i]['detail']==1 and ($data[$i]['year1']==0 and $data[$i]['year2']==0 and $data[$i]['year3']==0)){
//    }else{
        
        if($data[$i]['acnoname']!=''){

                $indent='5' * ($data[$i]['levelid'] * 3);
                Yii::$app->reporter->startrow();
                Yii::$app->reporter->addline();

                if($data[$i]['detail']==2){
                    $bold='B';
                }
                Yii::$app->reporter->col($data[$i]['acnoname'],'280',null,false,'1px solid ','','','Century Gothic','10',$bold,'','0px 0px 0px '. $indent.'px');

                if($data[$i]['detail']!=0){                
                    if($data[$i]['year1']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','10',$bold,'','');       
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['year1'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','10',$bold,'','');       
                    }
                    if($data[$i]['year2']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','10',$bold,'','');       
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['year2'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','10',$bold,'','');           
                    }
                    if($data[$i]['year3']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','10','','','');            
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['year3'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','10',$bold,'','');        
                    }

                    $lineTotal = $data[$i]['year1'] + $data[$i]['year2'] + $data[$i]['year3'];
                    if($lineTotal==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','10',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($lineTotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','10',$bold,'','');               
                    }                
                }

            Yii::$app->reporter->endrow();     

        }        
        
//    }
    
    if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();
        
        

        Yii::$app->reporter->beginreport();

            Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('COMPARATIVE BALANCE SHEET',null,null,false,'1px solid ','','','Century Gothic','15','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Center :  '.$params['center'],100,null,false,'1px solid ','','','Century Gothic','12','B','','');
       // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),100,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Year :  '.$params['year'],100,null,false,'1px solid ','','','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
Yii::$app->reporter->col('POSTED',100,null,false,'1px solid ','','','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
            Yii::$app->reporter->endtable();

        Yii::$app->reporter->printline();

        Yii::$app->reporter->begintable();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ACCOUNTS','300',null,false,'1px solid ','B','','Century Gothic','12','B','','');
        Yii::$app->reporter->col($params['year']-2,'110',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col($params['year']-1,'110',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col($params['year'],'110',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('TOTAL','170',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
        
        $page=$page + $count;        
    }
}

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

//echo 'rounded '.number_format((float)$month2['mjun'], 2, '.', '').'</br>';

?>