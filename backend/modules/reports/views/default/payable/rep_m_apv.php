<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Accounts Payable Voucher Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=60;
$page=58;

Yii::$app->reporter->beginreport();
Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ACCOUNTS PAYABLE VOUCHER','600',null,false,'1px solid ','','L','Century Gothic','18','B','','');
        Yii::$app->reporter->col('DOCUMENT # :','100',null,false,'1px solid ','','L','Century Gothic','13','B','','');
        Yii::$app->reporter->col((isset($data[0]['docno'])? $data[0]['docno']:''),'100',null,false,'1px solid ','B','L','Century Gothic','13','','','').'<br />';
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('PAID TO : ','70',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'530',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('DATE : ','40',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['dateid'])? $data[0]['dateid']:''),'160',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('ADDRESS : ','70',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'530',null,false,'1px solid ','B','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('REF # :','50',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col((isset($data[0]['ref'])? $data[0]['ref']:''),'150',null,false,'1px solid ','B','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','12','B','30px','4px');
        Yii::$app->reporter->col('','300',null,false,'1px solid ','','L','Century Gothic','12','','30px','4px');
        Yii::$app->reporter->col('INVOICE # :','80',null,false,'1px solid ','','L','Century Gothic','12','B','','4px');
        Yii::$app->reporter->col((isset($data[0]['yourref'])? $data[0]['yourref']:''),'120',null,false,'1px solid ','B','R','Century Gothic','12','','','4px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('P A R T I C U L A R S','650',null,false,'1px solid ','LRTB','C','Century Gothic','12','B','','3px');
        Yii::$app->reporter->col('AMOUNT','150',null,false,'1px solid ','LRTB','R','Century Gothic','12','B','','3px');
        

        

   $totaldb=0;
   $totalcr=0;
   $remarks="";
for($i=0;$i<count($data);$i++){
        
            if ($remarks==$data[0]['rem']){
            $remarks="";
            } else {
            $remarks=$data[0]['rem'];
            }
            $debit=number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($debit<1)
            {
            $debit='';
            }
             $credit=number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($credit<1)
            {
            $credit='';
            }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($remarks,'650',null,false,'1px solid ','LR','L','Century Gothic','11','','','3px');
        Yii::$app->reporter->col($debit,'150',null,false,'1px solid ','LR','R','Century Gothic','11','','','3px');
        $totaldb=$totaldb+$data[$i]['db'];
        $totalcr=$totalcr+$data[$i]['cr'];
            
    if(Yii::$app->reporter->linecounter==$page){
            Yii::$app->reporter->endtable();
            Yii::$app->reporter->page_break();
        Yii::$app->reporter->endrow();
               Yii::$app->reporter->printline();
        $page=$page + $count;
    }
}    

Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('TOTAL','650',null,false,'1px solid ','LRTB','R','Century Gothic','12','B','','3px');
        Yii::$app->reporter->col(number_format($totaldb,2),'150',null,false,'1px solid ','LRTB','R','Century Gothic','12','B','','3px');
Yii::$app->reporter->endrow();

echo '<br>';
//($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
echo '<br/><br/>';
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('ACCOUNTING ENTRY','500',null,false,'1px solid ','LRTB','C','Century Gothic','12','B','','3px');
        Yii::$app->reporter->col('DEBIT','150',null,false,'1px solid ','LRTB','R','Century Gothic','12','B','','3px');
        Yii::$app->reporter->col('CREDIT','150',null,false,'1px solid ','LRTB','R','Century Gothic','12','B','','3px');
        

        

   $totaldb=0;
   $totalcr=0;
   $acname="";
for($i=0;$i<count($data);$i++){
        
            
            $debit=number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($debit<1)
            {
            $debit='';
            }
             $credit=number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
            if ($credit<1)
            {
            $credit='';
            }
            if ($acname==$data[$i]['acnoname']){
            $acname="";
        } else {
              $acname=$data[$i]['acnoname'];
        }
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($acname,'500',null,false,'1px solid ','LR','L','Century Gothic','11','','','3px');
        Yii::$app->reporter->col($debit,'150',null,false,'1px solid ','LR','R','Century Gothic','11','','','3px');
        Yii::$app->reporter->col($credit,'150',null,false,'1px solid ','LR','R','Century Gothic','11','','','3px');
    
}   

    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','500',null,false,'1px solid ','T','C','Century Gothic','12','B','','3px');
        Yii::$app->reporter->col('','150',null,false,'1px solid ','T','R','Century Gothic','12','B','','3px');
        Yii::$app->reporter->col('','150',null,false,'1px solid ','T','R','Century Gothic','12','B','','3px');
    Yii::$app->reporter->endrow();
    
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->printline();
    Yii::$app->reporter->endtable();
    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);
?>