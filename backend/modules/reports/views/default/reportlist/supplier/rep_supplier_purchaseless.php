<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Purchase Less Return';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=38;
$page=40;
// $header=Yii::$app->reporter->letterhead();


Yii::$app->reporter->beginreport();
    Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PURCHASE LESS RETURN',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

       Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['startdate'])). ' TO ' . date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        Yii::$app->reporter->col('Center :'.$params['center'],null,null,false,'1px solid ','','R','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('Transaction : '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        if($params['sortby']=='docno'){
        Yii::$app->reporter->col('Sort By : Document #','150',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Sort By : Date','150',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        

        if($params['reporttype'] == "detailed"){
            Yii::$app->reporter->col('DATE','60',null,false,'1px solid ','B','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','10px');
            Yii::$app->reporter->col('DOCUMENT #','30px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','10px');
            Yii::$app->reporter->col('REFERENCE #','30px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','','30px','10px');
            Yii::$app->reporter->col('SUPPLIER NAME','70px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
        }else{
            Yii::$app->reporter->col('SUPPLIER NAME','350',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('TIN','150',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
        }//enmd if
        
        
        if($params['vattype'] == 'All'){
            Yii::$app->reporter->col('VATABLE','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('EXEMPT','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('AMOUNT','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');   
        }elseif($params['vattype'] == 'Vat'){
            Yii::$app->reporter->col('VATABLE','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');  
        }else{
            Yii::$app->reporter->col('EXEMPT','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        }
        
    Yii::$app->reporter->endrow();

    //var_dump($data);
        $totalamt=0;
        $totalamt_nonvat=0;
        $totalamt_vat=0;
for($i=0;$i<count($data);$i++){
            $amt=number_format($data[$i]['amount'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            $nonvat_amt=number_format($data[$i]['sum_non_vatable'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            $vat_amt=number_format($data[$i]['sum_vatable'],Yii::$app->systemsettings->setDecimaldisplay('currency'));

            if ($amt==0){
                $amt='-';
            }

            if ($vat_amt==0){
                $vat_amt='-';
            }

            if ($nonvat_amt==0){
                $nonvat_amt='-';
            }
    if(($params['vattype'] == 'All') || ($params['vattype'] == 'Vat' && $vat_amt != '-') || ($params['vattype'] == 'Nvat' && $nonvat_amt != '-')){
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->startrow();
        if($params['reporttype'] == "detailed"){
            Yii::$app->reporter->col($data[$i]['dateid'],'60',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
            
            if($data[$i]['vattype'] == ''){
                $vatprint = '';
            }else{
                if($data[$i]['vattype'] == 'NON-VATABLE'){
                    $vatprint = 'E';
                }else{
                    $vatprint = 'V';
                }//end fi
            }   

            $substring = substr($data[$i]['docno'], 0, 2);
            $docsequence = substr($data[$i]['docno'], 2);
            $docsequence = ltrim($docsequence, '0');
            
            Yii::$app->reporter->col($substring. ' ' . $docsequence . ' - ' . $vatprint,'20px',null,false,'1px solid ','','C','Helvetica','10','','','');
            
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col($data[$i]['yourref'],'30px',null,false,'1px solid ','','C','Helvetica','10','','','');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col($data[$i]['clientname'],'70px',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
        }else{
            Yii::$app->reporter->col($data[$i]['clientname'],'350',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col($data[$i]['tin'],'150',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
        }//enmd if

        
        if($params['vattype'] == 'All'){
            Yii::$app->reporter->col($vat_amt,'20px',null,false,'1px solid ','','R','Helvetica','10','','','');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col($nonvat_amt,'20px',null,false,'1px solid ','','R','Helvetica','10','','','');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','10','','','');
            Yii::$app->reporter->col($amt,'20px',null,false,'1px solid ','','R','Helvetica','10','','','');
        }elseif($params['vattype'] == 'Vat'){
            Yii::$app->reporter->col($vat_amt,'20px',null,false,'1px solid ','','R','Helvetica','10','','','');
        }else{
            Yii::$app->reporter->col($nonvat_amt,'20px',null,false,'1px solid ','','R','Helvetica','10','','','');
        }

    Yii::$app->reporter->endrow();

        $totalamt=$totalamt+$data[$i]['amount'];
        $totalamt_nonvat=$totalamt_nonvat+$data[$i]['sum_non_vatable'];
        $totalamt_vat=$totalamt_vat+$data[$i]['sum_vatable'];
        
        
    
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('PURCHASE LESS RETURN',null,null,false,'1px solid ','','','Helvetica','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['startdate'])). ' TO ' . date('M-d-Y', strtotime($params['enddate'])),null,null,false,'1px solid ','','L','Helvetica','10','','30px','5px');
        Yii::$app->reporter->col('Center :'.$params['center'],null,null,false,'1px solid ','','R','Helvetica','10','','','');
        // Yii::$app->reporter->col('Printdate :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Helvetica','10','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Helvetica','10','','b','');
        Yii::$app->reporter->col('Transaction : '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Helvetica','10','','','');
        if($params['sortby']=='docno'){
        Yii::$app->reporter->col('Sort By : Document #','150',null,false,'1px solid ','','L','Helvetica','10','','','');    
        } else {
        Yii::$app->reporter->col('Sort By : Date','150',null,false,'1px solid ','','L','Helvetica','10','','','');
        }
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        if($params['reporttype'] == "detailed"){
            Yii::$app->reporter->col('DATE','60',null,false,'1px solid ','B','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','10px');
            Yii::$app->reporter->col('DOCUMENT #','30px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','10px');
            Yii::$app->reporter->col('REFERENCE #','30px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','','30px','10px');
            Yii::$app->reporter->col('SUPPLIER NAME','70px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
        }else{
            Yii::$app->reporter->col('SUPPLIER NAME','350',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('TIN','150',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
        }//enmd if
        
        if($params['vattype'] == 'All'){
            Yii::$app->reporter->col('VATABLE','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('EXEMPT','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('AMOUNT','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');   
        }elseif($params['vattype'] == 'Vat'){
            Yii::$app->reporter->col('VATABLE','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');  
        }else{
            Yii::$app->reporter->col('EXEMPT','20px',null,false,'1px solid ','B','C','Helvetica','11','B','30px','8px');
        }
        
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}//end if
}   

        

        Yii::$app->reporter->startrow();
         if($params['reporttype'] == "detailed"){
           Yii::$app->reporter->col('     ','60',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','10px');
            Yii::$app->reporter->col('     ','30px',null,false,'1px solid ','','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','10px');
            Yii::$app->reporter->col('     ','30px',null,false,'1px solid ','','C','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','','30px','10px');
            Yii::$app->reporter->col('GRAND TOTAL:','70px',null,false,'1px solid ','T','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
        }else{
            Yii::$app->reporter->col('GRAND TOTAL','350',null,false,'1px solid ','T','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','150',null,false,'1px solid ','T','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
        }//enmd if
        
         if($params['vattype'] == 'All'){
            Yii::$app->reporter->col(number_format($totalamt_vat,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','T','R','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col(number_format($totalamt_nonvat,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','T','R','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Helvetica','11','B','30px','8px');
            Yii::$app->reporter->col(number_format($totalamt,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','T','R','Helvetica','11','B','30px','8px');
        }elseif($params['vattype'] == 'Vat'){
            Yii::$app->reporter->col(number_format($totalamt_vat,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','T','R','Helvetica','11','B','30px','8px');
        }else{
            Yii::$app->reporter->col(number_format($totalamt_nonvat,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','T','R','Helvetica','11','B','30px','8px');
        }

        Yii::$app->reporter->endrow();
       // Yii::$app->reporter->endtable();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->printline();

        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>