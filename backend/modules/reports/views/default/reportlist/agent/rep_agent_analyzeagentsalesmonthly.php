<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Analyze Agent Sales (Monthly)';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();

Yii::$app->reporter->beginreport('1000');
    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ANALYZE AGENT SALES ( MONTHLY ) ','','','','1px solid ','','','century gothic','15','B','','','');
        Yii::$app->reporter->endrow();
        
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('1000');
     Yii::$app->reporter->startrow('200',null,false,'1px solid ','','L','Century Gothic','10','','b','');
        Yii::$app->reporter->col('Transaction: '.strtoupper($params['poststatus']),'200','','','1px solid ','','','century gothic','10','','','','');
        Yii::$app->reporter->col('Center: '.$params['center'] ,'','','','1px solid ','','','century gothic','10','','','','');
        Yii::$app->reporter->col('Print Date: '.date('m/d/Y h:m:s') ,'','','','1px solid ','','R','century gothic','10','','','','');
        //Yii::$app->reporter->pagenumber('Page');
     Yii::$app->reporter->endrow();
     
     Yii::$app->reporter->startrow(); 
     Yii::$app->reporter->col('<br>');
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('1000');
     Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('AGENT NAME','120','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('JAN' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('FEB' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('MAR' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('APR' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('MAY' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('JUN' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('JUL' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('AUG' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('SEP' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('OCT' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('NOV' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('DEC' ,'65','','','1px solid ','TB','C','century gothic','10','B','','','');
        Yii::$app->reporter->col('AMOUNT' ,'100','','','1px solid ','TB','C','century gothic','10','B','','','');
     Yii::$app->reporter->endrow();

$jan=0;
$feb=0;
$mar=0;
$apr=0;
$may=0;
$jun=0;
$jul=0;
$aug=0;
$sep=0;
$oct=0;
$nov=0;
$dec=0;
$gtotal=0;
for($i=0;$i<count($data);$i++) {
    $sumrow=0;
        Yii::$app->reporter->startrow();
        if ($data[$i]['clientname']=='') {
           Yii::$app->reporter->col('No Agent','120','','','1px solid ','','L','century gothic','9','','','',''); 
        }else{
            Yii::$app->reporter->col($data[$i]['clientname'],'120','','','1px solid ','','L','century gothic','9','','','','');
        }
        
        if ($data[$i]['mojan']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['mojan'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['mojan'];
            $jan=$jan+$data[$i]['mojan'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['mofeb']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['mofeb'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['mofeb'];
            $feb=$feb+$data[$i]['mofeb'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['momar']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['momar'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['momar'];
            $mar=$mar+$data[$i]['momar'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['moapr']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['moapr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['moapr'];
            $apr=$apr+$data[$i]['moapr'];
        }else{
             Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['momay']!=0){
             Yii::$app->reporter->col(number_format($data[$i]['momay'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['momay'];
            $may=$may+$data[$i]['momay'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
       
        if ($data[$i]['mojun']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['mojun'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['mojun'];
            $jun=$jun+$data[$i]['mojun'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['mojul']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['mojul'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['mojul'];
            $jul=$jul+$data[$i]['mojul'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['moaug']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['moaug'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['moaug'];
            $aug=$aug+$data[$i]['moaug'];
        }else{
           Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['mosep']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['mosep'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['mosep'];
            $sep=$sep+$data[$i]['mosep'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['mooct']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['mooct'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['mooct'];
            $oct=$oct+$data[$i]['mooct'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
        if ($data[$i]['monov']!=0){
           Yii::$app->reporter->col(number_format($data[$i]['monov'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['monov'];
            $nov=$nov+$data[$i]['monov']; 
        }else{
           Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
            
        if ($data[$i]['modec']!=0){
            Yii::$app->reporter->col(number_format($data[$i]['modec'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'65','','','1px solid ','','R','century gothic','9','','','','');
            $sumrow=$sumrow+$data[$i]['modec'];
            $dec=$dec+$data[$i]['modec'];
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }    
        
        if ($sumrow!=0){
            Yii::$app->reporter->col(number_format($sumrow,Yii::$app->systemsettings->setDecimaldisplay('currency')),'130','','','1px solid ','','R','century gothic','9','','','','');
            $gtotal=$gtotal+$sumrow;
        }else{
            Yii::$app->reporter->col('-','','','','','','C','','','','','','');
        }
        
     Yii::$app->reporter->endrow();
}     

Yii::$app->reporter->startrow(); 
     Yii::$app->reporter->col('<br>');
Yii::$app->reporter->endrow();

Yii::$app->reporter->startrow(); 
        Yii::$app->reporter->col('GRAND TOTAL','120','','','1px solid ','T','L','century gothic','9','B','','');
        
        if ($jan!=0){
            Yii::$app->reporter->col(number_format($jan,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($feb!=0){
            Yii::$app->reporter->col(number_format($feb,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($mar!=0){
            Yii::$app->reporter->col(number_format($mar,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($apr!=0){
            Yii::$app->reporter->col(number_format($apr,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($may!=0){
            Yii::$app->reporter->col(number_format($may,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($jun!=0){
            Yii::$app->reporter->col(number_format($jun,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($jul!=0){
            Yii::$app->reporter->col(number_format($jul,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($aug!=0){
            Yii::$app->reporter->col(number_format($aug,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($sep!=0){
            Yii::$app->reporter->col(number_format($sep,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($oct!=0){
            Yii::$app->reporter->col(number_format($oct,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($nov!=0){
            Yii::$app->reporter->col(number_format($nov,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($dec!=0){
            Yii::$app->reporter->col(number_format($dec,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'65','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-' ,'65','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
        if ($gtotal!=0){
            Yii::$app->reporter->col(number_format($gtotal,Yii::$app->systemsettings->setDecimaldisplay('currency')) ,'100','','','1px solid ','T','R','century gothic','9','B','','');
        }else{
            Yii::$app->reporter->col('-','100','','','1px solid ','T','C','century gothic','9','B','','');
        }
        
Yii::$app->reporter->endrow();


Yii::$app->reporter->endtable();
//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();
?>