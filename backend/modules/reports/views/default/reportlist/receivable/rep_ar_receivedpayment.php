<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Received Payment List';
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

$start=$params['start'];
    $end=$params['end'];
    if($params['username']!=""){
        $user=$params['username'];
    }
    else{
        $user="ALL USERS";
    }
                            //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
 Yii::$app->reporter->startrow();           
    Yii::$app->reporter->col('Received Payment List','1000',null,false,'1px dotted','','','Century Gothic','18','B','30px','8px');
Yii::$app->reporter->endrow(); 
Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('<b>'.'Date Range: '.'</b>'.$start.' to '.$end,null,null,false,'1px solid ','','','Century Gothic','10','','','');
Yii::$app->reporter->endrow();
Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('<b>'.'User: '.'</b>'.$user,null,null,false,'1px solid ','','','Century Gothic','10','','','');
    Yii::$app->reporter->col('Prefix: '.$params['bref'],'125',null,false,'1px solid ','','L','Century Gothic','11','B','false','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted','','','Century Gothic','14','B','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
    Yii::$app->reporter->col('','100',null,false,'1px dotted','','','Century Gothic','14','B','30px','8px');
    // Yii::$app->reporter->col('<b>'.'Printdate: '.'</b>'. date('M-d-Y h:i:s a',time()),'700',null,false,'1px solid ','','R','Century Gothic','10','','','');
Yii::$app->reporter->endrow();    
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

$docno="";
$supplier="";
$debit=0;
$credit=0;
$totaldb=0;
$totalcr=0;
for($i=0;$i<count($data);$i++)
{
    // var_dump($docno!=$data[$i]['docno']);
    // var_dump($debit);

    if($docno!=""&&$docno!=$data[$i]['docno']){

        Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('Total:','100',null,false,'1px dotted','','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col(number_format($debit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','T','C','Century Gothic','10','B','30px','8px');
                Yii::$app->reporter->col(number_format($credit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','T','C','Century Gothic','10','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','1000',null,false,'1px dotted','T','R','Century Gothic','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
    }
    if($docno=="" || $docno!=$data[$i]['docno']) 
    {
        $docno=$data[$i]['docno'];
        $debit=0;
        $credit=0;
        Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<b>'.'Docno#: '.'</b>'.$data[$i]['docno'],'200',null,false,'1px solid ','','','Century Gothic','10','','','2px');
        Yii::$app->reporter->col('<b>'.'Date: '.'</b>'.$data[$i]['dateid'],'100',null,false,'1px solid ','','','Century Gothic','10','','','2px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
        Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');        
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('<b>'.'Customer: '.'</b>'.$data[$i]['hclientname'],'100',null,false,'1px solid ','','','Century Gothic','10','','','2px');
        Yii::$app->reporter->endrow();
         Yii::$app->reporter->endtable();

        Yii::$app->reporter->begintable('1000');
         //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
            Yii::$app->reporter->startrow();           
                Yii::$app->reporter->col('Date', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Check#', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Account', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Title', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Customer/Supplier', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Debit', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Credit', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Notes', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('Reference', '100',null,false,'1px solid ','TB','C','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable(); 
    } 
    Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
            Yii::$app->reporter->col($data[$i]['postdate'],'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['checkno'],'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['acno'],'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['acnoname'],'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['dclient'],'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
             Yii::$app->reporter->col(number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col(number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['rem'],'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
            Yii::$app->reporter->col($data[$i]['ref'],'100',null,false,'10px solid ','','C','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->addline();
        
        if($docno==$data[$i]['docno']) {
            $debit+=$data[$i]['db'];
            $credit+=$data[$i]['cr'];

            $totaldb+=$data[$i]['db'];
            $totalcr+=$data[$i]['cr'];
        }
    Yii::$app->reporter->endtable();

    if($i==count($data)-1)
    {
       Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('Total: ','100',null,false,'1px dotted','','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col(number_format($debit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','T','C','Century Gothic','10','B','30px','8px');
                Yii::$app->reporter->col(number_format($credit,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','T','C','Century Gothic','10','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();
        Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','1000',null,false,'1px dotted','T','R','Century Gothic','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();        
    }
}

        Yii::$app->reporter->begintable('1000');
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('Grand Total: ','100',null,false,'1px dotted','','R','Century Gothic','11','B','30px','8px');
                Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','C','Century Gothic','10','B','30px','8px');
                Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid','','C','Century Gothic','10','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','','Century Gothic','14','B','30px','8px');
                Yii::$app->reporter->col('','100',null,false,'1px dotted','','R','Century Gothic','14','B','30px','8px');
            Yii::$app->reporter->endrow();
        Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>