<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Tax Wheld Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=35;
$page=35;
echo '<div style="margin-top:-10px;letter-spacing: 4px;">';
Yii::$app->reporter->beginreport();
echo '<br/><br/>';
Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('BIR','266',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('REPUBLIKA NG PILIPINAS','266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->col('CTL NO.: '.(isset($data[0]['docno'])? $data[0]['docno']:''),'266',null,false,'1px solid ','','R','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('FORM NO . 2307','266',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('KAGAWARAN NG PANANALAPI','266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('FORMERLY FORM 1743-750','266',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('KAWANIHAN NG RENTAS INTERNAS','266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CERTIFICATE OF CREDITABLE TAX WITHHELD AT SOURCE','800',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('FOR THE PERIOD ' . (isset($data[0]['dateid'])? $data[0]['dateid']:'') . ' TO ' . (isset($data[0]['dateid2'])? $data[0]['dateid2']:''),'800',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','800',null,false,'1px dotted ','B','C','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('NAME AND ADDRESS OF PAYEE','500',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('TIN OF PAYEE','300',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'480',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),'280',false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col((isset($data[0]['address'])? $data[0]['address']:''),'780',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('NAME AND ADDRESS OF WITHHOLDING AGENT','500',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('TIN OF WITHHOLDING AGENT','300',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('RT TRADING','480',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('112-625-341-000','280',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','20',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('#7 MADRIGAL COMPD., MCARTHUR BLVD., CEBU CITY','780',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('','800',null,false,'1px dotted ','B','C','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('NATURE OF INCOME PAYMENT','300',null,false,'1px solid ','B','C','Verdana','9','','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px solid ','B','C','Verdana','9','','30px','8px');
        Yii::$app->reporter->col('AMOUNT OF INCOME PAYMENT','200',null,false,'1px solid ','B','C','Verdana','9','','30px','8px');
        Yii::$app->reporter->col('AMOUNT OF TAX WITHHELD','200',null,false,'1px solid ','B','C','Verdana','9','','30px','8px');
        


   $totalincome=0;
   $totalwheld=0;
for($i=0;$i<count($data);$i++){
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->addline();
        Yii::$app->reporter->col($data[$i]['acnoname'] ,'300',null,false,'1px solid ','','L','Verdana','9','','','2px');
        Yii::$app->reporter->col($data[$i]['acno'] ,'100',null,false,'1px solid ','','C','Verdana','9','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['income'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Verdana','9','','','2px');
        Yii::$app->reporter->col(number_format($data[$i]['wheld'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px solid ','','R','Verdana','9','','','2px');
        $totalincome=$totalincome+$data[$i]['income'];
        $totalwheld=$totalwheld+$data[$i]['wheld'];
        Yii::$app->reporter->endrow();

        
      
}   

    
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','300',null,false,'1px dotted ','','R','Verdana','9','B','','');
        Yii::$app->reporter->col('TOTAL','100',null,false,'1px dotted ','','R','Verdana','9','B','','');
        Yii::$app->reporter->col(number_format($totalincome,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','TB','R','Verdana','9','B','','');
        Yii::$app->reporter->col(number_format($totalwheld,Yii::$app->systemsettings->setDecimaldisplay('currency')),'200',null,false,'1px dotted ','TB','R','Verdana','9','B','','');
        Yii::$app->reporter->endrow();

Yii::$app->reporter->begintable('800');
echo '<br/>';
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('I DECLARE UNDER THE PENALTIES OF PERJURY THAT THIS CERTIFICATE HAS BEEN MADE IN GOOD FAITH, VERIFIED BY ME AND TO THE BEST OF MY KNOWLEDGE AND BELIEF IS TRUE AND CORRECT, PURSUANT TO THE PROVISIONS OF THE NATIONAL INTERNAL REVENUE CODE, AS AMENDED, AND THE REGULATIONS ISSUED UNDER AUTHORITY THEREOF.','800',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();


    echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','9','','','');
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','C','Verdana','9','','','');
       
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    

    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','9','','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

   Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Conforme:','266',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();

    Yii::$app->reporter->begintable('800');
    echo '<br/>';
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),'266',null,false,'1px solid ','','L','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','R','Verdana','9','','','');
        Yii::$app->reporter->col('','266',null,false,'1px solid ','','C','Verdana','9','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
Yii::$app->reporter->endtable();


        Yii::$app->reporter->endreport();
echo '</div>';


?>