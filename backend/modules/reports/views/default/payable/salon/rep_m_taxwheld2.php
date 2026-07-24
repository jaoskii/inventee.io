<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Tax Wheld Report';
//RT REPORTS:
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;

switch (Yii::$app->session['loggeduser']['center']) {
    case '001':
        $tin = '003-579-360';
    break;
    
    case '002':
        $tin = '229-570-999';
    break;

    case '003':
        $tin = '409-567-199';
    break;

    case '004':
        $tin = '415-658-947';
    break;

    case '005':
        $tin = '009-445-003';
    break;    

    case '006':
        $tin = '009-444-955';
    break;    
}//end switch

Yii::$app->reporter->beginreport();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('BIR','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('REPUBLIKA NG PILIPINAS','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('CTL NO.: '.(isset($data[0]['docno'])? $data[0]['docno']:''),'266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('FORM NO . 2307','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('KAGAWARAN NG PANANALAPI','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('FORMERLY FORM 1743-750','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('KAWANIHAN NG RENTAS INTERNAS','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CERTIFICATE OF CREDITABLE TAX WITHHELD AT SOURCE','800',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('FOR THE PERIOD ' . (isset($data[0]['dateid'])? $data[0]['dateid']:'') . ' TO ' . (isset($data[0]['dateid2'])? $data[0]['dateid2']:''),'800',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','800',null,false,'1px dotted ','B','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('NAME AND ADDRESS OF PAYEE','500',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('TIN OF PAYEE','300',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'480',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'280',false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'390',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('','390',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('NAME AND ADDRESS OF WITHHOLDING AGENT','500',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('TIN OF WITHHOLDING AGENT','300',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],'480',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col($tin,'280',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col(strtoupper(Yii::$app->session['loggeduser']['centeradd']),'780',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','800',null,false,'1px dotted ','B','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('NATURE OF INCOME PAYMENT','300',null,false,'1px solid ','B','C','Avenir','12','','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','B','C','Avenir','12','','30px','8px');
        Yii::$app->reporter->col('AMOUNT OF INCOME PAYMENT','200',null,false,'1px solid ','B','C','Avenir','12','','30px','8px');
        Yii::$app->reporter->col('AMOUNT OF TAX WITHHELD','200',null,false,'1px solid ','B','C','Avenir','12','','30px','8px');
        


$totalincome=0;
$totalwheld=0;
$counter = 0;

for($i=0;$i<count($data);$i++){
        $counter += 1;
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['acnoname'] ,'300',null,false,'1px solid ','','L','Avenir','11','','','2px');
        Yii::$app->reporter->col($data[$i]['acno'] ,'100',null,false,'1px solid ','','C','Avenir','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['income'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Avenir','11','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['wheld'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Avenir','11','','','2px');
        $totalincome=$totalincome+$data[$i]['income'];
        $totalwheld=$totalwheld+$data[$i]['wheld'];
        Yii::$app->reporter->endrow();
}//end f0r each

if($counter < 21){
    while ($counter != 21) {
        $counter += 1;
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col('&nbsp' ,'300',null,false,'1px solid ','','L','Avenir','11','','','2px');
        Yii::$app->reporter->col('&nbsp','100',null,false,'1px solid ','','C','Avenir','11','','','2px');
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','R','Avenir','11','','','2px');
        Yii::$app->reporter->col('&nbsp','200',null,false,'1px solid ','','R','Avenir','11','','','2px');
        Yii::$app->reporter->endrow();
    }//end while
}//end if

Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','300',null,false,'1px dotted ','','R','Avenir','11','B','','');
    Yii::$app->reporter->col('TOTAL','100',null,false,'1px dotted ','','R','Avenir','11','B','','');
    Yii::$app->reporter->col(number_format($totalincome,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','TB','R','Avenir','11','B','','');
    Yii::$app->reporter->col(number_format($totalwheld,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','TB','R','Avenir','11','B','','');
Yii::$app->reporter->endrow();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('I DECLARE UNDER THE PENALTIES OF PERJURY THAT THIS CERTIFICATE HAS BEEN MADE IN GOOD FAITH, VERIFIED BY ME AND TO THE BEST OF MY KNOWLEDGE AND BELIEF IS TRUE AND CORRECT, PURSUANT TO THE PROVISIONS OF THE NATIONAL INTERNAL REVENUE CODE, AS AMENDED, AND THE REGULATIONS ISSUED UNDER AUTHORITY THEREOF.','800',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','C','Avenir','12','','','');
       
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Conforme:','266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
    echo '<br/>';
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'266',null,false,'1px solid ','','L','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Avenir','12','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Avenir','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();



?>