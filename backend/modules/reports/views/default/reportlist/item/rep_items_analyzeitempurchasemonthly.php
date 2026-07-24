<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Analyze Item Purchase (Monthly)';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();
//($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->beginreport('1000');

    Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();   
Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ANALYZE ITEM PURCHASE (MONTHLY)',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        if ($params['supplier']==''){
            Yii::$app->reporter->col('Supplier : ALL',NULL,null,false,'1px solid ','','L','Helvetica','10','','','');
        } else {
        Yii::$app->reporter->col('Supplier : '. strtoupper($params['suppliername']),NULL,null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if ($params['barcode']==''){
        Yii::$app->reporter->col('Item : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Item :'. strtoupper($params['itemname']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if ($params['principalid']==''){
        Yii::$app->reporter->col('Principal : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Principal :'. strtoupper($params['principalid']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        }

        if ($params['divisionid']==''){
        Yii::$app->reporter->col('Division : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Division :'. strtoupper($params['divisionid']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        }

        if ($params['brand']==''){
        Yii::$app->reporter->col('Brand : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Brand : '. strtoupper($params['brand']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if ($params['class']==''){
        Yii::$app->reporter->col('Class : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Class :'.strtoupper($params['class']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->col('Transaction : '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Analyze By : '. strtoupper($params['analyzedby']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        if ($params['categoryid']==''){
        Yii::$app->reporter->col('Category : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Category :'. strtoupper($params['category']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        if ($params['genericid']==''){
        Yii::$app->reporter->col('Generic : ALL',null,null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Generic :'. strtoupper($params['generic']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        //Yii::$app->reporter->col('Center : '.$cname,null,null,false,'1px solid ','','L','Helvetica','10','','','');
        Yii::$app->reporter->col('Item Type : '.strtoupper($params['itemtype']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ITEM DESCRIPTION','120','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('JAN' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('FEB' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('MAR' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('APR' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('MAY' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('JUN' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('JUL' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('AUG' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('SEP' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('OCT' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('NOV' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        Yii::$app->reporter->col('DEC' ,'65','','','1px solid ','TB','C','Helvetica','9','B','','');
        if(strtoupper($params['analyzedby'])=="UNIT"){
        Yii::$app->reporter->col('QUANTITY' ,'100','','','1px solid ','TB','C','Helvetica','9','B','','');    
        }else{
        Yii::$app->reporter->col('AMOUNT' ,'100','','','1px solid ','TB','C','Helvetica','9','B','','');
        }

        
        if(strtoupper($params['analyzedby'])=="UNIT"){
        $ab = Yii::$app->systemsettings->setDecimaldisplay('quantity');
        }else{
        $ab = Yii::$app->systemsettings->setDecimaldisplay('currency');    
        }

    $totalmojan=0;
    $totalmofeb=0;
    $totalmomar=0;
    $totalmoapr=0;
    $totalmomay=0;
    $totalmojun=0;
    $totalmojul=0;
    $totalmoaug=0;
    $totalmosep=0;
    $totalmooct=0;
    $totalmonov=0;
    $totalmodec=0;
    $amt=0;
    $totalamt=0;
    
    $part="";
    $brand="";
    //brand
    $subjan=0;
    $subfeb=0;
    $submar=0;
    $subapr=0;
    $submay=0;
    $subjun=0;
    $subjul=0;
    $subaug=0;
    $subsep=0;
    $suboct=0;
    $subnov=0;
    $subdec=0;
    $subamt=0;
    //part
    $gsubjan=0;
    $gsubfeb=0;
    $gsubmar=0;
    $gsubapr=0;
    $gsubmay=0;
    $gsubjun=0;
    $gsubjul=0;
    $gsubaug=0;
    $gsubsep=0;
    $gsuboct=0;
    $gsubnov=0;
    $gsubdec=0;
    $gsubamt=0;

for($i=0;$i<count($data);$i++){
                        $mojan=number_format($data[$i]['mojan'],$ab);
                        if ($mojan==0)
                        {
                        $mojan='-';
                        }
                        $mofeb=number_format($data[$i]['mofeb'],$ab);
                        if ($mofeb==0)
                        {
                        $mofeb='-';
                        }
                        $momar=number_format($data[$i]['momar'],$ab);
                        if ($momar==0)
                        {
                        $momar='-';
                        }
                        $moapr=number_format($data[$i]['moapr'],$ab);
                        if ($moapr==0)
                        {
                        $moapr='-';
                        }
                        $momay=number_format($data[$i]['momay'],$ab);
                        if ($momay==0)
                        {
                        $momay='-';
                        }
                        $mojun=number_format($data[$i]['mojun'],$ab);
                        if ($mojun==0)
                        {
                        $mojun='-';
                        }
                        $mojul=number_format($data[$i]['mojul'],$ab);
                        if ($mojul==0)
                        {
                        $mojul='-';
                        }
                        $moaug=number_format($data[$i]['moaug'],$ab);
                        if ($moaug==0)
                        {
                        $moaug='-';
                        }
                        $mosep=number_format($data[$i]['mosep'],$ab);
                        if ($mosep==0)
                        {
                        $mosep='-';
                        }
                        $mooct=number_format($data[$i]['mooct'],$ab);
                        if ($mooct==0)
                        {
                        $mooct='-';
                        }
                        $monov=number_format($data[$i]['monov'],$ab);
                        if ($monov==0)
                        {
                        $monov='-';
                        }
                        $modec=number_format($data[$i]['modec'],$ab);
                        if ($modec==0)
                        {
                        $modec='-';
                        }
                        
    $amt=$data[$i]['mojan'] + $data[$i]['mofeb'] + $data[$i]['momar'] + $data[$i]['moapr'] + $data[$i]['momay'] + $data[$i]['mojun'] + $data[$i]['mojul'] + $data[$i]['moaug'] + $data[$i]['mosep'] + $data[$i]['mooct'] + $data[$i]['monov'] + $data[$i]['modec'];
    
   
        if ($part==strtoupper($data[$i]['part'])){
               $part=""; 
              if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";
                
                
              }  else {
              if ($brand!=''){   
                Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($brand.' '.'SUB TOTAL:','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($subjan,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subfeb,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submar,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subapr,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submay,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subjun,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subjul,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subaug,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subsep,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($suboct,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subnov,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subdec,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subamt,$ab),'100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col('&nbsp','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
             } 
                //brand
    $subjan=0;
    $subfeb=0;
    $submar=0;
    $subapr=0;
    $submay=0;
    $subjun=0;
    $subjul=0;
    $subaug=0;
    $subsep=0;
    $suboct=0;
    $subnov=0;
    $subdec=0;
    $subamt=0;
    
                $brand=strtoupper($data[$i]['brand']);  
              }
               
        } else {
            
             if ($brand!=''){   
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col($brand.' '.'SUB TOTAL:','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($subjan,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subfeb,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submar,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subapr,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submay,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subjun,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subjul,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subaug,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subsep,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($suboct,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subnov,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subdec,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subamt,$ab),'100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col('&nbsp','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
             }
              if ($part!=''){   
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col($part.' '.'SUB TOTAL:','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($gsubjan,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubfeb,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubmar,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubapr,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubmay,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubjun,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubjul,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubaug,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubsep,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsuboct,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubnov,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubdec,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubamt,$ab),'100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col('&nbsp','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
             }  
              //part
              $gsubjan=0;
              $gsubfeb=0;
              $gsubmar=0;
              $gsubapr=0;
              $gsubmay=0;
              $gsubjun=0;
              $gsubjul=0;
              $gsubaug=0;
              $gsubsep=0;
              $gsuboct=0;
              $gsubnov=0;
              $gsubdec=0;
              $gsubamt=0;
              $part=$data[$i]['part'];
              
              
               if (strtoupper($brand)==strtoupper($data[$i]['brand'])){
                $brand="";  
              }  else {
                //brand
    $subjan=0;
    $subfeb=0;
    $submar=0;
    $subapr=0;
    $submay=0;
    $subjun=0;
    $subjul=0;
    $subaug=0;
    $subsep=0;
    $suboct=0;
    $subnov=0;
    $subdec=0;
    $subamt=0;
   
                $brand=strtoupper($data[$i]['brand']);  
              }
             
            }
   
    
    
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($part,'120',null,false,'1px solid ','','L','Helvetica','9','B','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
    
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($brand,'120',null,false,'1px solid ','','L','Helvetica','9','Bi','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
    Yii::$app->reporter->endrow();    
            
            
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['itemname'],'120',null,false,'1px solid ','','L','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($mojan,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($mofeb,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($momar,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($moapr,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($momay,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($mojun,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($mojul,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($moaug,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($mosep,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($mooct,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($monov,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        Yii::$app->reporter->col($modec,'65',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');       
        Yii::$app->reporter->col(number_format($amt,$ab),'100',null,false,'1px solid ','','R','Helvetica','9','','30px','0px');
        
        $subjan=$subjan + $data[$i]['mojan'];
        $subfeb=$subfeb + $data[$i]['mofeb'];
        $submar=$submar + $data[$i]['momar'];
        $subapr=$subapr + $data[$i]['moapr'];
        $submay=$submay + $data[$i]['momay'];
        $subjun=$subjun + $data[$i]['mojun'];
        $subjul=$subjul + $data[$i]['mojul'];
        $subaug=$subaug + $data[$i]['moaug'];
        $subsep=$subsep + $data[$i]['mosep'];
        $suboct=$suboct + $data[$i]['mooct'];
        $subnov=$subnov + $data[$i]['monov'];
        $subdec=$subdec + $data[$i]['modec'];
        $subamt=$subamt + $data[$i]['mojan'] + $data[$i]['mofeb'] + $data[$i]['momar'] + $data[$i]['moapr'] + $data[$i]['momay'] + $data[$i]['mojun'] + $data[$i]['mojul'] + $data[$i]['moaug'] + $data[$i]['mosep'] + $data[$i]['mooct'] + $data[$i]['monov'] + $data[$i]['modec'];
        
        //part
        $gsubjan=$gsubjan + $data[$i]['mojan'];
        $gsubfeb=$gsubfeb + $data[$i]['mofeb'];
        $gsubmar=$gsubmar + $data[$i]['momar'];
        $gsubapr=$gsubapr + $data[$i]['moapr'];
        $gsubmay=$gsubmay + $data[$i]['momay'];
        $gsubjun=$gsubjun + $data[$i]['mojun'];
        $gsubjul=$gsubjul + $data[$i]['mojul'];
        $gsubaug=$gsubaug + $data[$i]['moaug'];
        $gsubsep=$gsubsep + $data[$i]['mosep'];
        $gsuboct=$gsuboct + $data[$i]['mooct'];
        $gsubnov=$gsubnov + $data[$i]['monov'];
        $gsubdec=$gsubdec + $data[$i]['modec'];
        $gsubamt=$gsubamt + $data[$i]['mojan'] + $data[$i]['mofeb'] + $data[$i]['momar'] + $data[$i]['moapr'] + $data[$i]['momay'] + $data[$i]['mojun'] + $data[$i]['mojul'] + $data[$i]['moaug'] + $data[$i]['mosep'] + $data[$i]['mooct'] + $data[$i]['monov'] + $data[$i]['modec'];
        
        $totalmojan=$totalmojan + $data[$i]['mojan'];
        $totalmofeb=$totalmofeb + $data[$i]['mofeb'];
        $totalmomar=$totalmomar + $data[$i]['momar'];
        $totalmoapr=$totalmoapr + $data[$i]['moapr'];
        $totalmomay=$totalmomay + $data[$i]['momay'];
        $totalmojun=$totalmojun + $data[$i]['mojun'];
        $totalmojul=$totalmojul + $data[$i]['mojul'];
        $totalmoaug=$totalmoaug + $data[$i]['moaug'];
        $totalmosep=$totalmosep + $data[$i]['mosep'];
        $totalmooct=$totalmooct + $data[$i]['mooct'];
        $totalmonov=$totalmonov + $data[$i]['monov'];
        $totalmodec=$totalmodec + $data[$i]['modec'];
        $totalamt=$totalamt + $amt;
        
        $brand=strtoupper($data[$i]['brand']);
        $part=$data[$i]['part'];
        
        Yii::$app->reporter->endrow();

        
    }
    
        Yii::$app->reporter->startrow(); 
        
                Yii::$app->reporter->col($brand.' '.'SUB TOTAL:','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($subjan,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subfeb,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submar,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subapr,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($submay,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subjun,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subjul,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subaug,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subsep,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($suboct,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subnov,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subdec,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($subamt,$ab),'100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col('&nbsp','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
        Yii::$app->reporter->endrow(); 
       
        Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col($part.' '.'SUB TOTAL:','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($gsubjan,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubfeb,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubmar,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubapr,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubmay,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubjun,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubjul,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubaug,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubsep,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsuboct,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubnov,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubdec,$ab),'65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col(number_format($gsubamt,$ab),'100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col('&nbsp','120',null,false,'1px solid ','','R','Helvetica','9','Bi','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','65',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->col('&nbsp','100',null,false,'1px dotted ','T','R','Helvetica','9','','30px','0px');
                Yii::$app->reporter->endrow(); 
        Yii::$app->reporter->endrow(); 
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('GRAND TOTAL :','120',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmojan,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmofeb,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmomar,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmoapr,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmomay,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmojun,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmojul,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmoaug,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmosep,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmooct,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmonov,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalmodec,$ab),'65',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        Yii::$app->reporter->col(number_format($totalamt,$ab),'100',null,false,'1px solid ','TB','R','Helvetica','9','b','','');
        
        Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>