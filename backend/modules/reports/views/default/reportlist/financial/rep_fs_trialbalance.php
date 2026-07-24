<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Trial Balance';
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
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('TRIAL BALANCE',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center :'.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Transaction :'. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])). ' TO ' . date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        //Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ACCOUNT #','20px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('     ','30px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','10px');
        Yii::$app->reporter->col('ACCOUNT TITLE','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DEBIT','20px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CREDIT','20px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        

        //var_dump($data);
        $totaldb=0;
  	    $totalcr=0;
for($i=0;$i<count($data);$i++){

        if ($data[$i]['amt']<0){
            $cr=$data[$i]['amt'] * -1;
            } else {
            $cr=0;
            }

            if ($data[$i]['amt']>0){
            $db=$data[$i]['amt'];
            } else {
            $db=0;
            }
            
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->addline();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col($data[$i]['acno'],'20px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('     ','30px',null,false,'1px solid ','','L','Century Gothic','10','','30px','');
        Yii::$app->reporter->col($data[$i]['acnoname'],'110px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Century Gothic','10','','','');
        if($db==0){
            Yii::$app->reporter->col('-','20px',null,false,'1px solid ','','R','Century Gothic','10','','','');    
        }else{
            Yii::$app->reporter->col(number_format($db,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','','R','Century Gothic','10','','','');    
        }
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Century Gothic','10','','','');    
        if($cr==0){
            Yii::$app->reporter->col('-','20px',null,false,'1px solid ','','R','Century Gothic','10','','','');
        }else{
            Yii::$app->reporter->col(number_format($cr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','','R','Century Gothic','10','','','');    
        }
        
        $totaldb=$totaldb + $cr;
        $totalcr=$totalcr + $db;
        Yii::$app->reporter->endrow();
        
        
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
        Yii::$app->reporter->col('TRIAL BALANCE',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center :'.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Transaction :'. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Century Gothic','10','','30px','5px');
        Yii::$app->reporter->col('Date Period : '.date('M-d-Y', strtotime($params['start'])). ' TO ' . date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        //Yii::$app->reporter->col('Printdate : '. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','R','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ACCOUNT #','20px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('     ','30px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','10px');
        Yii::$app->reporter->col('ACCOUNT TITLE','110px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('DEBIT','20px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','','L','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->col('CREDIT','20px',null,false,'1px solid ','B','C','Century Gothic','11','B','30px','8px');
        Yii::$app->reporter->endrow();
       Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}
    
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','20px',null,false,'1px solid ','TB','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('     ','30px',null,false,'1px solid ','TB','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col('GRAND TOTAL :','110px',null,false,'1px solid ','TB','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','TB','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','TB','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col('     ','20px',null,false,'1px solid ','TB','L','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'20px',null,false,'1px solid ','TB','R','Century Gothic','10','B','','');
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>