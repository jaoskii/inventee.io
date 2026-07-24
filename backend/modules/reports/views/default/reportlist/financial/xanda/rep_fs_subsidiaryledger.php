<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Subsidiary Ledger';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=50;
$page=50;


Yii::$app->reporter->beginreport('1000');
Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //        $txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
        Yii::$app->reporter->col('SUBSIDIARY LEDGER',300,null,false,'1px solid ','','L','Century Gothic','15','B','','','');
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Accounts:'.$params['paramsacct'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Cost Center:'.$params['costcenter'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        //        $txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
        Yii::$app->reporter->col('DATE','100',null,false,'1px solid','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('DOCUMENT #','100',null,false,'1px solid','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('SUPPLIER / CUSTOMER','200', null,false,'1px solid','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('P A R T I C U L A R','350',null,false,'1px solid','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('DEBIT','75', null,false,'1px solid','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('CREDIT','75', null,false,'1px solid','B','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col('BALANCE','100', null,false,'1px solid','B','C','Century Gothic','12','B','','');

$part = "";
$brand = "";
$totaldb=0;
$totalcr=0;
$totalbal=0;

$subtotaldb=0;
$subtotalcr=0;
$subtotalbal=0;
$grandtotal = 0;
$stillempty = 1;

for($i=0;$i<count($data);$i++){

    if(strtoupper($data[$i]['name']) == ''){
        if($stillempty == 1){
            $stillempty = 0;
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col('-----','200',null,false,'1px solid','','L','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','200', null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','350',null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','75', null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','75', null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100', null,false,'1px solid','','C','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();        
        }//end if
    }else{
        if($part != strtoupper($data[$i]['name'])){
            Yii::$app->reporter->startrow(); 
                Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col('','200', null,false,'1px solid','','C','Century Gothic','10','B','','');
                Yii::$app->reporter->col('SUB TOTAL : ','350',null,false,'1px dotted','TB','R','Century Gothic','10','B','','');
                Yii::$app->reporter->col(number_format($subtotaldb,2),'75',null,false,'1px dotted','TB','R','Century Gothic','10','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($subtotalcr,2),'75',null,false,'1px dotted','TB','R','Century Gothic','10','Bi','30px','0px');
                Yii::$app->reporter->col(number_format($subtotalbal,2),'100',null,false,'1px dotted','TB','R','Century Gothic','10','Bi','30px','0px');
            Yii::$app->reporter->endrow(); 
            
            $part = strtoupper($data[$i]['name']);
            Yii::$app->reporter->startrow();
                Yii::$app->reporter->col($part,'200',null,false,'1px solid','','L','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','200', null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','350',null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','75', null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','75', null,false,'1px solid','','C','Century Gothic','11','B','','');
                Yii::$app->reporter->col('','100', null,false,'1px solid','','C','Century Gothic','11','B','','');
            Yii::$app->reporter->endrow();
        }//end if
    }//end if

     Yii::$app->reporter->startrow();
       Yii::$app->reporter->col($data[$i]['dateid'],'100',null,false,'1px solid ','','C','Century Gothic','10','','',' ');
       Yii::$app->reporter->col($data[$i]['docno'],'100',null,false,'1px solid ','','C','Century Gothic','10','','',' ');
       Yii::$app->reporter->col($data[$i]['clientname'],'200',null,false,'1px solid ','','L','Century Gothic','10','','',' ');
       Yii::$app->reporter->col($data[$i]['rem'],'350',null,false,'1px solid ','','L','Century Gothic','10','','',' ');
       Yii::$app->reporter->col(number_format($data[$i]['db'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','','R','Century Gothic','10','','',' ');
       Yii::$app->reporter->col(number_format($data[$i]['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'75',null,false,'1px solid ','','R','Century Gothic','10','','',' ');
       Yii::$app->reporter->col(number_format($data[$i]['begbal'],Yii::$app->systemsettings->setDecimaldisplay('currency')),'100',null,false,'1px solid ','','R','Century Gothic','10','','','');
        
        $totaldb=$totaldb+$data[$i]['db'];
        $totalcr=$totalcr+$data[$i]['cr'];
        $totalbal=$totalcr-$totaldb;

        $subtotaldb=$subtotaldb+$data[$i]['db'];
        $subtotalcr=$subtotalcr+$data[$i]['cr'];
        $subtotalbal=$subtotalcr-$subtotaldb;

        $brand=strtoupper($data[$i]['name']);
        $part=strtoupper($data[$i]['name']);
        
        Yii::$app->reporter->endrow();

        

       
}


Yii::$app->reporter->begintable('1000');

    Yii::$app->reporter->startrow(); 
        Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','100',null,false,'1px solid','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('','200', null,false,'1px solid','','C','Century Gothic','10','B','','');
        Yii::$app->reporter->col('SUB TOTAL : ','350',null,false,'1px dotted','TB','R','Century Gothic','10','B','','');
        Yii::$app->reporter->col(number_format($subtotaldb,2),'75',null,false,'1px dotted','TB','R','Century Gothic','10','Bi','30px','0px');
        Yii::$app->reporter->col(number_format($subtotalcr,2),'75',null,false,'1px dotted','TB','R','Century Gothic','10','Bi','30px','0px');
        Yii::$app->reporter->col(number_format($subtotalbal,2),'100',null,false,'1px dotted','TB','R','Century Gothic','10','Bi','30px','0px');
    Yii::$app->reporter->endrow(); 


    Yii::$app->reporter->startrow();
        Yii::$app->reporter->col( '','100',null, false, '1px dotted','T','L','Century Gothic','9','', '', '','' ,'');
        Yii::$app->reporter->col('', '100',null, false, '1px dotted','T','L','Century Gothic','9','', '', '','' ,'');
        Yii::$app->reporter->col('' ,'250', null,  false, '1px dotted','T','L','Century Gothic','9','', '', '','' ,'');
        Yii::$app->reporter->col('', '100',null, false, '1px dotted','T','L','Century Gothic','9','', '', '','' ,'');
        Yii::$app->reporter->col(number_format($totaldb,Yii::$app->systemsettings->setDecimaldisplay('currency')), '75', null, false, '1px dotted','T','R','Century Gothic','9','B', '', '','' ,'');
        Yii::$app->reporter->col(number_format($totalcr,Yii::$app->systemsettings->setDecimaldisplay('currency')), '75', null, false, '1px dotted','T','R','Century Gothic','9','B', '', '','' ,'');
        Yii::$app->reporter->col(number_format($totalbal,Yii::$app->systemsettings->setDecimaldisplay('currency')), '100', null, false, '1px dotted','T','R','Century Gothic','9','B', '', '','' ,'');
    Yii::$app->reporter->endrow();

Yii::$app->reporter->endtable();
    

  Yii::$app->reporter->endtable();
        Yii::$app->reporter->endtable();

Yii::$app->reporter->endreport();

?>