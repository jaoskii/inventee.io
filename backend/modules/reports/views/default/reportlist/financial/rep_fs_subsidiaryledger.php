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




//$w=null,$h=null, $bg=false,  $b=false, $b_, $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
Yii::$app->reporter->begintable('800');
Yii::$app->reporter->startrow();
$col=array(
        array( '100',null, false, '1px solid','','L','Century Gothic','9','', '', '','' ,''),
        array( '100',null, false, '1px solid','','L','Century Gothic','9','', '', '','' ,''),
        array( '180', null,  false, '1px solid','','L','Century Gothic','9','', '', '','' ,''),
        array( '170',null, false, '1px solid','','L','Century Gothic','9','', '', '','' ,''),
        array( '75', null, false, '1px solid','','R','Century Gothic','9','', '', '','' ,''),
        array( '75', null, false, '1px solid','','R','Century Gothic','9','', '', '','' ,''),
        array( '100', null, false, '1px solid','','R','Century Gothic','9','', '', '','' ,''),
);
Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->beginreport();

Yii::$app->reporter->begintable('800');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //        $txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
        Yii::$app->reporter->col('SUBSIDIARY LEDGER',300,null,false,'1px solid ','','L','Century Gothic','15','B','','','');
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Accounts:'.$params['paramsacct'].'-'.$params['accname'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('',null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('',null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //        $txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
        Yii::$app->reporter->col('Date','100',null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Document#','100',null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Supplier/Customer','180', null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Particular','170',null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Debit','75', null,false,'1px solid','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Credit','75', null,false,'1px solid','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Balance','100', null,false,'1px solid','B','R','Century Gothic','12','B','','');

        
$totaldb=0;
$totalcr=0;
$totalbal=0;
if ($data==null){
} else {
foreach($data as $key => $data_) {
        Yii::$app->reporter->startrow();
        $value=array($data_['dateid'],$data_['docno'],$data_['clientname'],$data_['rem'],number_format($data_['db'],Yii::$app->systemsettings->setDecimaldisplay('currency')),number_format($data_['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency')),number_format($data_['begbal'],Yii::$app->systemsettings->setDecimaldisplay('currency')));

        $tots=array('','','','','','','');
        Yii::$app->reporter->row($col, $value);
        
        $totaldb=$totaldb+$data_['db'];
        $totalcr=$totalcr+$data_['cr'];
        $totalbal=$totalcr-$totaldb;
        
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
        //        $txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
        Yii::$app->reporter->col('SUBSIDIARY LEDGER',300,null,false,'1px solid ','','L','Century Gothic','15','B','','','');
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col(date('M-d-Y', strtotime($params['start'])) .' TO '. date('M-d-Y', strtotime($params['end'])),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('','200',null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->endrow();

        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Center:'.$params['center'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Accounts:'.$params['account'],null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->col('Transaction: '. strtoupper($params['poststatus']),null,null,false,'1px solid ','','L','Century Gothic','10','','','');
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        //        $txt='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m=''
        Yii::$app->reporter->col('Date','100',null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Document#','100',null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Supplier/Customer','180', null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Particular','170',null,false,'1px solid','B','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Debit','75', null,false,'1px solid','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Credit','75', null,false,'1px solid','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->col('Balance','100', null,false,'1px solid','B','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
        $page=$page+$count;
      
    }

       
}
}
Yii::$app->reporter->begintable('800');
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
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();
//var_dump($params);
//var_dump($data);
?>