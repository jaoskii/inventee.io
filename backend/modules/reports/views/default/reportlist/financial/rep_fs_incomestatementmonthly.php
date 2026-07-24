<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Monthly Income Statement';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=57;
$page=57;

Yii::$app->reporter->beginreport('800');

    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('MONTHLY INCOME STATEMENT',null,null,false,'1px solid ','','','Century Gothic','15','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Center :  '.$params['center'],100,null,false,'1px solid ','','','Century Gothic','12','B','','');
// Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),100,null,false,'1px solid ','','','Century Gothic','12','','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('Year :  '.$params['year'],100,null,false,'1px solid ','','','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
Yii::$app->reporter->col('POSTED',100,null,false,'1px solid ','','','Century Gothic','12','B','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','12','','','4px');
Yii::$app->reporter->pagenumber('Page');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('ACCOUNTS','280',null,false,'1px solid ','B','','Century Gothic','12','B','','');
    Yii::$app->reporter->col('JAN','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('FEB','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('MAR','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('APR','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('MAY','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('JUN','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('JUL','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('AUG','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('SEP','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('OCT','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('NOV','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('DEC','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->col('TOTAL','120',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
    Yii::$app->reporter->endrow();
    
//    var_dump($data);

 for($i=0;$i<count($data);$i++){

    $lineTotal=0;
    $bold='';
    
    if($data[$i]['detail']==1 and ($data[$i]['monjan']==0 and $data[$i]['monfeb']==0 and $data[$i]['monmar']==0 and $data[$i]['monapr']==0 and $data[$i]['monmay']==0 and $data[$i]['monjun']==0 and $data[$i]['monjul']==0 and $data[$i]['monaug']==0 and $data[$i]['monsep']==0 and $data[$i]['monoct']==0 and $data[$i]['monnov']==0 and $data[$i]['mondec']==0)){
    }else{
        
        if($data[$i]['acnoname']!=''){

                $indent='5' * ($data[$i]['levelid'] * 3);
                Yii::$app->reporter->startrow();
                Yii::$app->reporter->addline();

                if($data[$i]['detail']==2){
                    $bold='B';
                }
                Yii::$app->reporter->col($data[$i]['acnoname'],'280',null,false,'1px solid ','','','Century Gothic','12',$bold,'','0px 0px 0px '. $indent.'px');

                if($data[$i]['detail']!=0){                
                    if($data[$i]['monjan']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic',  $bold,'','');       
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monjan'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');       
                    }
                    if($data[$i]['monfeb']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');       
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monfeb'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');           
                    }
                    if($data[$i]['monmar']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12','','','');            
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monmar'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');        
                    }
                    if($data[$i]['monapr']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monapr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }
                    if($data[$i]['monmay']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12','','','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monmay'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }                
                    if($data[$i]['monjun']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monjun'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }
                    if($data[$i]['monjul']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monjul'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }                
                    if($data[$i]['monaug']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monaug'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }
                    if($data[$i]['monsep']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monsep'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }                
                    if($data[$i]['monoct']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monoct'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }                
                    if($data[$i]['monnov']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['monnov'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }    
                    if($data[$i]['mondec']==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($data[$i]['mondec'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    } 

                    $lineTotal = $data[$i]['monjan'] + $data[$i]['monfeb'] + $data[$i]['monmar'] + $data[$i]['monapr'] + $data[$i]['monmay'] + $data[$i]['monjun'] + $data[$i]['monjul'] + $data[$i]['monaug'] + $data[$i]['monsep'] + $data[$i]['monoct'] + $data[$i]['monnov'] + $data[$i]['mondec'];                           
                    if($lineTotal==0){
                        Yii::$app->reporter->col('-','90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }else{
                        Yii::$app->reporter->col(number_format($lineTotal,Yii::$app->systemsettings->setDecimaldisplay('currency')),'90',null,false,'1px solid ','','R','Century Gothic','12',$bold,'','');               
                    }                
                }

            Yii::$app->reporter->endrow();     

        }        
        
    }
    
    if(Yii::$app->reporter->linecounter==$page){
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->page_break();
        
        // $header=Yii::$app->reporter->letterhead();
        
        Yii::$app->reporter->beginreport('800');

            Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('MONTHLY INCOME STATEMENT',null,null,false,'1px solid ','','','Century Gothic','15','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Center :  '.$params['center'],100,null,false,'1px solid ','','','Century Gothic','12','B','','');
        // Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),100,null,false,'1px solid ','','','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Year :  '.$params['year'],100,null,false,'1px solid ','','','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','12','','','4px');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

        Yii::$app->reporter->printline();

        Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ACCOUNTS','280',null,false,'1px solid ','B','','Century Gothic','12','B','','');
        Yii::$app->reporter->col('JAN','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('FEB','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('MAR','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('APR','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('MAY','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('JUN','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('JUL','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('AUG','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('SEP','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('OCT','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('NOV','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('DEC','90',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('TOTAL','120',null,false,'1px solid ','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();  
        
        $page=$page + $count;      
    }
}

Yii::$app->reporter->endtable();
Yii::$app->reporter->endreport();

//echo 'rounded '.number_format((float)$month2['mjun'], 2, '.', '').'</br>';

?>