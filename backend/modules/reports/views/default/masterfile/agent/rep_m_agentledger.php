<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Agent Ledger Report';
?>

<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=54;
Yii::$app->reporter->beginreport();

 
    $loggeduser = Yii::$app->session['loggeduser']['name'];
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
            $header=Yii::$app->reporter->letterhead();
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();    

Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('AGENT LEDGER - PROFILE ',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        
        Yii::$app->reporter->startrow(null,null,false,'1px solid ','','R','Century Gothic','11','','','');
        Yii::$app->reporter->col('Run Date :'. date('M-d-Y h:i:s a',time()),null,null,false,'1px solid ','','L','Century Gothic','11','','','');
        //Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Agent:','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['clientname'])? $data[0]['clientname']:''),400,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Telephone No/s:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['tel'])? $data[0]['tel']:''),250,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable(); 
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Address:','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['addr'])? $data[0]['addr']:''),400,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Fax No/s:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['fax'])? $data[0]['fax']:''),250,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('TIN #:','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['tin'])? $data[0]['tin']:''),400,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Mobile No/s.:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['tel2'])? $data[0]['tel2']:''),250,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Remarks:','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['rem'])? $data[0]['rem']:''),400,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->col('Email Address:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['email'])? $data[0]['email']:''),250,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->begintable('800');      
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col('',400,null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col('Contact Person:','100',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
        Yii::$app->reporter->col((isset($data[0]['contact'])? $data[0]['contact']:''),250,null,false,'1px solid ','','L','Century Gothic','11','B','','1px');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('','95',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('Started :','50',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
    Yii::$app->reporter->col((isset($data[0]['start'])? $data[0]['start']:''),'150',null,false,'1px solid ','','L','Century Gothic','11','B','','3px');
    
    if ($data[0]['issupplier']==1) {
    Yii::$app->reporter->col('|| SUPPLIER','50',null,false,'1px solid ','','L','Century Gothic','11','B','','2px');
    }else{
    Yii::$app->reporter->col('Supplier','50',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
    }
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('','95',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('Status :','50',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
    Yii::$app->reporter->col((isset($data[0]['status'])? $data[0]['status']:''),'150',null,false,'1px solid ','','L','Century Gothic','11','B','','3px');
    
    if ($data[0]['iscustomer']==1) {
    Yii::$app->reporter->col('|| CUSTOMER','50',null,false,'1px solid ','','L','Century Gothic','11','B','','2px');
    }else{
    Yii::$app->reporter->col('Customer','50',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
    }

    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('','95',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('Quota :','50',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
    Yii::$app->reporter->col(number_format((isset($data[0]['quota'])? $data[0]['quota']:''),2),'150',null,false,'1px solid ','','L','Century Gothic','11','B','','3px');
    
    if ($data[0]['isagent']==1) {
    Yii::$app->reporter->col('|| AGENT','50',null,false,'1px solid ','','L','Century Gothic','11','B','','2px');
    }else{
    Yii::$app->reporter->col('Agent','50',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
    }
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('','95',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('Area :','50',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
    Yii::$app->reporter->col((isset($data[0]['area'])? $data[0]['area']:''),'150',null,false,'1px solid ','','L','Century Gothic','11','B','','3px');
    
        if ($data[0]['isemployee']==1) {
    Yii::$app->reporter->col('|| EMPLOYEE','50',null,false,'1px solid ','','L','Century Gothic','11','B','','2px');
    }else{
    Yii::$app->reporter->col('Employee','50',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
    }
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('','95',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('Province :','50',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
    Yii::$app->reporter->col((isset($data[0]['province'])? $data[0]['province']:''),'150',null,false,'1px solid ','','L','Century Gothic','11','B','','3px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('','95',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('Region :','50',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
    Yii::$app->reporter->col((isset($data[0]['region'])? $data[0]['region']:''),'150',null,false,'1px solid ','','L','Century Gothic','11','B','','3px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('','95',null,false,'1px solid ','','L','Century Gothic','11','','','1px');
    Yii::$app->reporter->col('Group :','50',null,false,'1px solid ','','L','Century Gothic','11','','','3px');
    Yii::$app->reporter->col((isset($data[0]['groupid'])? $data[0]['groupid']:''),'150',null,false,'1px solid ','','L','Century Gothic','11','B','','3px');
    Yii::$app->reporter->col('','50',null,false,'1px solid ','','L','Century Gothic','11','','','2px');
    Yii::$app->reporter->col('','100',null,false,'1px solid ','','L','Century Gothic','11','','','');
    Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();

echo '<br/><br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Prepared By : ','266',null,false,'1px solid ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Received By :','266',null,false,'1px solid ','','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('Approved By :','266',null,false,'1px solid ','','R','Century Gothic','12','','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
    
    echo '<br/>';
    Yii::$app->reporter->begintable('800');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col($prepared,'266',null,false,'1px solid ','','L','Century Gothic','12','B','','');
        Yii::$app->reporter->col($received,'266',null,false,'1px solid ','','C','Century Gothic','12','B','','');
        Yii::$app->reporter->col($approved,'266',null,false,'1px solid ','','R','Century Gothic','12','B','','');
        Yii::$app->reporter->endrow();
    Yii::$app->reporter->endtable();
Yii::$app->reporter->endtable();


//var_dump($data);
//var_dump($params);
Yii::$app->reporter->endreport();


?>
