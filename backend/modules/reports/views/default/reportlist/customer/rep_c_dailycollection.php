<?php
date_default_timezone_set('Asia/Manila');
$this->title = 'Daily Collection List';

?>
<input type="hidden" value = "Daily Collection (Victory Mall)" id="rptname">
<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php

$count=55;
$page=55;
Yii::$app->reporter->beginreport('1000');

Yii::$app->reporter->begintable('1000');
$header=Yii::$app->reporter->letterhead();
Yii::$app->reporter->endtable();
echo '<br/><br/>';

Yii::$app->reporter->begintable('1000');
        Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('Daily Collection',null,null,false,'1px solid ','','','Century Gothic','18','B','','').'<br />';
        Yii::$app->reporter->endrow();
        Yii::$app->reporter->startrow();

       
        Yii::$app->reporter->startrow(NULL,null,false,'1px solid ','','R','Century Gothic','11','','30px','5px');
        
        Yii::$app->reporter->pagenumber('Page');
        Yii::$app->reporter->endrow();
Yii::$app->reporter->endtable();
Yii::$app->reporter->printline();


Yii::$app->reporter->begintable('1000');
    Yii::$app->reporter->startrow();
        //($txt='',$w=null,$h=null, $bg=false,$b=false,$b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='')
        Yii::$app->reporter->col('CODE','100',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('CUSTOMER NAME','300',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('ADDRESS','300',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TELEPHONE #','150',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');
        Yii::$app->reporter->col('TIN #','150',null,false,'1px solid ','B','C','Century Gothic','12','B','30px','8px');    
    Yii::$app->reporter->endrow();

    $resultcustomerqry = "select release_vicz.client.client,release_vicz.client.clientname,release_vicz.client.clientid from client where release_vicz.client.iscustomer = 1";
    $customs =  Yii::$app->sbccommon->opentable($resultcustomerqry);
    for($i=0;$i<count($customs);$i++){
        ini_set('memory_limit', '-1');
        $qry = "select CR.dateid,CR.docno,CR.doc,CR.seq,CR.client,CR.clientname,CR.yourref,CR.ourref,sum(CR.db) as amt,CR.posted, CR.Tr,CR.compname,CR.ctin,CR.caddr,CR.agent,CR.project,cr.checkno,cr.bank,CR.rem,CR.Users,CR.prep from (
            select head.trno,0 as posted,head.docno,cntnum.bref as doc,cntnum.seq as seq,
            head.client,head.clientname,head.address,head.yourref,head.project,detail.bank,detail.checkno,
            head.ourref,head.dateid,head.cur,head.forex,head.rem,sum(detail.db) as db, 'UNPOSTED' as Tr,
            center.name as compname,center.tin as ctin,center.addr as caddr,agent.client as agent, cntnum.users,
            '' as prep from (CRhead as head 
            left join CRdetail as detail on detail.trno = head.trno) 
            LEFT join coa on coa.acno = detail.acno
            left join client on client.client = head.client 
            left join client as agent on agent.client = client.agent and agent.center = '004'
            left join cntnum on cntnum.trno = head.trno 
            left join center on center.code = cntnum.center 
            where head.dateid between '2012-01-01' and '2012-12-31'
            and cntnum.users = 'anna' and client.client = 'VTCSJ0000000001' 
            and head.doc in ('CR') and left(coa.alias,2)='CA' and cntnum.center = '004'
            and cntnum.type in ('A','B','') and head.project in ('cash','cheque','') 
            group by head.trno,head.doc,head.docno,head.client,head.clientname,head.address,head.yourref,head.ourref,head.dateid,head.cur,head.forex,head.rem
            UNION ALL
            select head.trno,1 as posted,head.docno,cntnum.bref as doc,cntnum.seq as seq,client.client,head.clientname, head.address,head.yourref,
            head.project,detail.bank,detail.checkno, head.ourref,head.dateid,head.cur,head.forex,head.rem,sum(detail.db) as db,'POSTED' as Tr,
            center.name as compname,center.tin as ctin,center.addr as caddr,agent.client as agent,cntnum.users,'' as prep
            from (GLhead as head 
            left join GLDetail as detail on detail.trno = head.trno) 
            left join client on client.clientid=head.clientid
            left join client as agent on agent.client = client.agent and agent.center = '004' 
            LEFT join coa on coa.acnoid = detail.acnoid
            left join cntnum on cntnum.trno = head.trno 
            left join center on center.code = cntnum.center 
            Where head.dateid between '2012-01-01' and '2012-12-31'
            and cntnum.users = 'anna' and client.client = 'VTCSJ0000000001' 
            and head.doc in ('CR') and left(coa.alias,2)='CA'
            and cntnum.center = '004' and cntnum.type in ('A','B','') 
            and head.project in ('cash','cheque','') 
            group by head.trno,head.doc,head.docno,client.client,head.clientname,head.address,head.yourref,head.ourref, head.dateid,head.cur,head.forex,head.rem) as CR
            WHERE CR.Tr = CR.Tr  group by CR.dateid,CR.docno,CR.client,CR.clientname,CR.yourref,CR.ourref,CR.posted,CR.Tr order by CR.seq";
        echo $qry . '<br><br>';
        //$data[] =  Yii::$app->sbccommon->opentable($qry);
    }//END FOR LOOKP
    //var_dump($data);

    //Yii::$app->reporter->printline();
Yii::$app->reporter->endtable();
//Yii::$app->reporter->printline();
Yii::$app->reporter->endreport();

//var_dump($params);
//var_dump($data);

?>
