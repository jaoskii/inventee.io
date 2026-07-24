<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Reports extends Model {
    
    public $report;
    public $title;
    public $center;
    public $whby;
    public $code;
    public $generate;
    public $category;
    public $cname;
    public $attention;
    public $wh;
    public $warehouse;
    public $name;
    
    /*reportlog*/
    public $sectionid;
    public $keyid;
    public $valueid;
    public $userid;
    public $prepared;
    public $received;
    public $approved;
    public $start;
    public $end;
    public $trno;
    public $type;
    public $uom;
    public $barcode;
    public $params;
    public $uomby;
    public $whbycode;
    public $itemid;
    public $clientid;
    
    public $batch;

    /*reportlog end*/

    public $param=array();

    public function rules(){

        return array(
            array('sectionid, keyid,trno, valueid, userid', 'length', 'max'=>50),
        );
    }
    public function attributeLabels(){
            
        return array(
            'sectionid' => 'Sectionid',
            'keyid' => 'Keyid',
            'valueid' => 'Valueid',
            'userid' => 'Userid',
            'line' => 'Line',
        );
    }
        
    public function search(){
            
        
    }

     // SALON MODIFICATION

    public static function rptStocktransferrequest($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select date(head.dateid) as dateid, head.docno,head.wh,wh.clientname as whname, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as cost, stock.disc, stock.ext
                    from trhead as head left join trstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join client as wh on wh.client=head.wh
                    where md5(head.trno)='$trno'
                    union all
                    select date(head.dateid) as dateid, head.docno,head.wh,wh.clientname as whname, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as cost, stock.disc, stock.ext
                    from htrhead as head left join htrstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join client as wh on wh.client=head.wh
                    where md5(head.trno)='$trno'
                    
                ");
        return $result;
    }

    // XANDABELS

    public static function rptCollectionlist() {
        $result = Yii::$app->sbccommon->opentable("
            select detail.line,detail.trno,detail.clientid,detail.docno,detail.docdate,detail.docduedate,
            round(detail.db,2) as db,round(detail.cr,2) as cr,round(detail.amt,2) as amt,
            detail.doc,detail.client,detail.clientname,client.addr,
            (select agentcode from klhead limit 1) as agentcode,
            (select aclient.clientname from client as aclient where aclient.client=(select agentcode from klhead limit 1)) as agentname,(select notes from klhead limit 1) as notes
            from kldetail as detail
            left join client on client.clientid=detail.clientid
            left join klhead as head on head.agentcode = client.agent
            left join client as agent on agent.client=head.agentcode
            order by docdate,clientname");
        return $result;
    }
    

    public static function rptMaterialissueance($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname,stock.ref
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='mi' and md5(head.trno)='$trno'
                    union all
                    select stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, item.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, ag.client as agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname,stock.ref
                    from glhead as head left join glstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=head.whid
                    where head.doc='mi' and md5(head.trno)='$trno'
                ");
        return $result;
    }

    // END SALON
    
        
    //ACCOUNTING BOOKS
    public static function rptA_CashDisbursement($params,$center) /* ALA */ {
            $isposted=$params['poststatus'];
            $isdetailed=$params['reporttype'];
            $start=$params['start'];
            $end=$params['end'];
            

            $filter="";
            if($params['client'] != ""){
            $filter=" and client.client='".$params['client']."'";
            }

            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.client, head.clientname,
                                client.tin, head.dateid, detail.acno, detail.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((lahead as head
                                left join ladetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join client on client.client=detail.client
                                where cntnum.doc='cv' $filter and cntnum.center='$center'
                                and head.dateid between '$start' and '$end' 
                                union all
                                select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.client, head.clientname,
                                client.tin, head.dateid, detail.acno, detail.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((lbhead as head
                                left join lbdetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join client on client.client=detail.client
                                where cntnum.doc='cv' $filter and cntnum.center='$center'
                                and head.dateid between '$start' and '$end'
                                union all
                                select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.client, head.clientname,
                                client.tin, head.dateid, detail.acno, detail.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((lchead as head
                                left join lcdetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join client on client.client=detail.client
                                where cntnum.doc='cv' $filter and cntnum.center='$center'
                                and head.dateid between '$start' and '$end' 
                                order by docno
                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select acno, description, sum(debit) as debit, sum(credit) as credit
                                from (select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.client, head.clientname,
                                client.tin, head.dateid, detail.acno, detail.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((lahead as head
                                left join ladetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join client on client.client=detail.client
                                where cntnum.doc='cv' $filter and cntnum.center='$center' and head.dateid between '$start' and '$end' 
                                union all
                                select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.client, head.clientname,
                                client.tin, head.dateid, detail.acno, detail.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((lbhead as head
                                left join lbdetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join client on client.client=detail.client
                                where cntnum.doc='cv' $filter and cntnum.center='$center' and head.dateid between '$start' and '$end' 
                                union all
                                select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.client, head.clientname,
                                client.tin, head.dateid, detail.acno, detail.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((lchead as head
                                left join lcdetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join client on client.client=detail.client
                                where cntnum.doc='cv' $filter and cntnum.center='$center' and head.dateid between '$start' and '$end' 
                                ) as x where ifnull(acno,'')<>'' group by acno, description
                                order by acno, description

                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
             switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'p' as tr, 'cd' as bk, head.docno, head.rem, client.client, client.clientname,
                                client.tin, head.dateid, coa.acno, coa.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((glhead as head
                                left join gldetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join client on client.clientid=detail.clientid 
                                where cntnum.doc='cv' $filter and cntnum.center='$center'
                                and head.dateid between '$start' and '$end' 
                                union all
                                select 'p' as tr, 'cd' as bk, head.docno, head.rem, client.client, client.clientname,
                                client.tin, head.dateid, coa.acno, coa.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((hglhead as head
                                left join hgldetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join client on client.clientid=detail.clientid 
                                where cntnum.doc='cv' $filter and cntnum.center='$center'
                                and head.dateid between '$start' and '$end' 
                                order by docno
                            ";
                           
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select acno, description, sum(debit) as debit, sum(credit) as credit
                                from (select 'p' as tr, 'cd' as bk, head.docno, head.rem, client.client, client.clientname,
                                client.tin, head.dateid, coa.acno, coa.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((glhead as head
                                left join gldetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join client on client.clientid=detail.clientid where cntnum.doc='cv' $filter and cntnum.center='$center'
                                and head.dateid between '$start' and '$end' 
                                union all
                                select 'p' as tr, 'cd' as bk, head.docno, head.rem, client.client, client.clientname,
                                client.tin, head.dateid, coa.acno, coa.acnoname as description, detail.checkno,detail.ref,
                                detail.db as debit, detail.cr as credit, cntnum.bref,cntnum.center from (((hglhead as head
                                left join hgldetail as detail on detail.trno=head.trno) left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join client on client.clientid=detail.clientid where cntnum.doc='cv' $filter and cntnum.center='$center'
                                and head.dateid between '$start' and '$end' 
                                ) as x where ifnull(acno,'')<>'' group by acno, description
                                order by acno, description

                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptA_CashReceipt($params,$center) /* ALA */ {
            $isposted=$params['poststatus'];
            $isdetailed=$params['reporttype'];
            $start=$params['start'];
            $end=$params['end'];

            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'u' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'u' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'u' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                order by docno

                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select acno, description, sum(debit) as debit, sum(credit) as credit
                                from (select 'u' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'u' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'u' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                                left join coa on coa.acno=detail.acno) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                ) as x where ifnull(acno,'')<>'' group by acno, description
                                order by acno, description

                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                order by docno
                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select acno, description, sum(debit) as debit, sum(credit) as credit
                                from (select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid, coa.acno, coa.acnoname
                                as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid) left join cntnum on cntnum.trno=head.trno
                                where head.doc='cr' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                ) as x where ifnull(acno,'')<>'' group by acno, description
                                order by acno, description
                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptA_JournalVoucher($params,$center) /* ALA */ {
            $isposted=$params['poststatus'];
            $isdetailed=$params['reporttype'];
            $start=$params['start'];
            $end=$params['end'];

            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                               select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.clientname, head.dateid,
                               detail.acno, detail.acnoname as description, cntnum.center, sum(detail.db) as debit,
                               detail.ref, sum(detail.cr) as credit
                               from (((lahead as head left join ladetail as detail on detail.trno=head.trno)
                               left join cntnum on cntnum.trno=head.trno)left join coa on coa.acno=detail.acno)
                               left join client on client.client=head.client
                               where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                               group by detail.acno, detail.acnoname, cntnum.center
                               union all
                               select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.clientname, head.dateid,
                               detail.acno, detail.acnoname as description, cntnum.center, sum(detail.db) as debit,
                               detail.ref, sum(detail.cr) as credit
                               from (((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                               left join cntnum on cntnum.trno=head.trno)left join coa on coa.acno=detail.acno)
                               left join client on client.client=head.client
                               where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                               group by detail.acno, detail.acnoname, cntnum.center
                               union all
                               select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.clientname, head.dateid,
                               detail.acno, detail.acnoname as description, cntnum.center, sum(detail.db) as debit,
                               detail.ref, sum(detail.cr) as credit
                               from (((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                               left join cntnum on cntnum.trno=head.trno)left join coa on coa.acno=detail.acno)
                               left join client on client.client=head.client
                               where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                               group by detail.acno, detail.acnoname, cntnum.center order by description


                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                               select acno, description, sum(debit) as debit, sum(credit) as credit from (
                               select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.clientname, head.dateid,
                               detail.acno, detail.acnoname as description, cntnum.center, sum(detail.db) as debit,
                               detail.ref, sum(detail.cr) as credit
                               from (((lahead as head left join ladetail as detail on detail.trno=head.trno)
                               left join cntnum on cntnum.trno=head.trno)left join coa on coa.acno=detail.acno)
                               left join client on client.client=head.client
                               where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                               group by detail.acno, detail.acnoname, cntnum.center
                               union all
                               select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.clientname, head.dateid,
                               detail.acno, detail.acnoname as description, cntnum.center, sum(detail.db) as debit,
                               detail.ref, sum(detail.cr) as credit
                               from (((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                               left join cntnum on cntnum.trno=head.trno)left join coa on coa.acno=detail.acno)
                               left join client on client.client=head.client
                               where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                               group by detail.acno, detail.acnoname, cntnum.center
                               union all
                               select 'u' as tr, 'cd' as bk, head.docno, head.rem, head.clientname, head.dateid,
                               detail.acno, detail.acnoname as description, cntnum.center, sum(detail.db) as debit,
                               detail.ref, sum(detail.cr) as credit
                               from (((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                               left join cntnum on cntnum.trno=head.trno)left join coa on coa.acno=detail.acno)
                               left join client on client.client=head.client
                               where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                               group by detail.acno, detail.acnoname, cntnum.center order by description
                               ) as x group by acno, description order by  description


                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid,
                                coa.acno, coa.acnoname as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid,
                                coa.acno, coa.acnoname as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                order by docno
                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select acno, description, sum(debit) as debit, sum(credit) as credit from (
                                select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid,
                                coa.acno, coa.acnoname as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                union all
                                select 'p' as tr, 'cr' as bk, head.docno, head.rem, head.clientname, head.dateid,
                                coa.acno, coa.acnoname as description, detail.ref, detail.db as debit, detail.cr as credit
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='gj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                ) as x group by acno, description order by  description
                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptA_PurchaseJournal($params,$center) /*SEAN*/{
            $isposted='posted';
            $isdetailed=$params['reporttype'];
            $start=$params['start'];
            $end=$params['end'];

            $filter="";
            if($params['client'] != ""){
            $filter=" and client.client='".$params['client']."'";
            }
            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="                              
                                select 'u' as tr, 'pj' as bk, head.dateid, concat(left(head.docno,2),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((lahead as head left join ladetail as detail on detail.trno=head.trno)left join coa on coa.acno=detail.acno)
                                left join client on client.client = detail.client
                                left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='rr' and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) in ('ap','in')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'pj' as bk, head.dateid, concat(left(head.docno,2),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(detail.acno, '') as sunaccno, ifnull(detail.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((lahead as head left join ladetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join client on client.client = detail.client
                                left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='rr' and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) not in ('ap','in')
                                group by head.dateid, head.docno, detail.acno, detail.acnoname, head.rem, head.clientname                          
                                union all
                                select 'u' as tr, 'pj' as bk, head.dateid, concat(left(head.docno,2),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)left join coa on coa.acno=detail.acno)
                                left join client on client.client = detail.client                                
                                left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='rr' and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) in ('ap','in')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'pj' as bk, head.dateid, concat(left(head.docno,2),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(detail.acno, '') as sunaccno, ifnull(detail.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join client on client.client = detail.client                                
                                left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='rr' and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) not in ('ap','in')
                                group by head.dateid, head.docno, detail.acno, detail.acnoname, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'pj' as bk, head.dateid, concat(left(head.docno,2),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)left join coa on coa.acno=detail.acno)
                                left join client on client.client = detail.client                
                                left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='rr' and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) in ('ap','in')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'pj' as bk, head.dateid, concat(left(head.docno,2),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(detail.acno, '') as sunaccno, ifnull(detail.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((lchead as head left join lcdetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join client on client.client = detail.client                                
                                left join cntnum on cntnum.trno=head.trno
                                where cntnum.doc='rr' and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) not in ('ap','in')
                                group by head.dateid, head.docno, detail.acno, detail.acnoname, head.rem, head.clientname order by dateid, docno

                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select 'u' as tr, 'pj' as bk, detail.acno, detail.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (lahead as head left join ladetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                left join client on client.client = detail.client                                
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                group by detail.acno, detail.acnoname
                                union all
                                select 'u' as tr, 'pj' as bk, detail.acno, detail.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (lbhead as head left join lbdetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                left join client on client.client = detail.client                               
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                group by detail.acno, detail.acnoname                 
                                union all
                                select 'u' as tr, 'pj' as bk, detail.acno, detail.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (lchead as head left join lcdetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                left join client on client.client = detail.client                                
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                group by detail.acno, detail.acnoname order by description


                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'u' as tr, 'pj' as bk, left(head.dateid,10) as dateid, 
                                concat(left(head.docno,4),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno)left join coa on coa.acnoid=detail.acnoid)
                                left join client on client.clientid = detail.clientid                                
                                left join cntnum on cntnum.trno=head.trno
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) in ('ap','in')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'pj' as bk, left(head.dateid,10) as dateid,  
                                concat(left(head.docno,4),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(coa.acno, '') as sunaccno, ifnull(coa.acnoname,'') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno) left join coa on coa.acnoid=detail.acnoid)
                                left join client on client.clientid = detail.clientid                                
                                left join cntnum on cntnum.trno=head.trno
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) not in ('ap','in')
                                group by head.dateid, head.docno, coa.acno, detail.acnoname, head.rem, head.clientname

                                union all
                                select 'u' as tr, 'pj' as bk,left(head.dateid,10) as dateid, 
                                concat(left(head.docno,4),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)left join coa on coa.acnoid=detail.acnoid)
                                left join client on client.clientid = detail.clientid                                
                                left join cntnum on cntnum.trno=head.trno
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) in ('ap','in')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'pj' as bk,left(head.dateid,10) as dateid, 
                                concat(left(head.docno,4),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(coa.acno, '') as sunaccno, ifnull(coa.acnoname,'') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno) left join coa on coa.acnoid=detail.acnoid)
                                left join client on client.clientid = detail.clientid                                
                                left join cntnum on cntnum.trno=head.trno
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                and left(coa.alias, 2) not in ('ap','in')
                                group by head.dateid, head.docno, coa.acno, detail.acnoname, head.rem, head.clientname
                                order by dateid, docno


                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select 'u' as tr, 'pj' as bk, coa.acno, coa.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (glhead as head left join gldetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid = detail.clientid                                
                                left join coa on coa.acnoid=detail.acnoid
                                where (cntnum.doc='rr' or cntnum.doc='sp' or cntnum.doc='pv') and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                group by coa.acno, detail.acnoname
                                union all
                                select 'u' as tr, 'pj' as bk, coa.acno, detail.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (hglhead as head left join hgldetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid = detail.clientid                                
                                left join coa on coa.acnoid=detail.acnoid
                                where cntnum.doc='rr' and cntnum.center='$center' and head.dateid between '$start' and '$end' $filter
                                group by coa.acno, detail.acnoname order by description
                            ";
                            break;
                        }
                    }
                    break;
                }
            }


            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptA_SalesJournal($params,$center) /* ALA */ {
            $isposted='posted';
            $isdetailed=$params['reporttype'];
            $start=$params['start'];
            $end=$params['end'];
            switch($isposted){
                case 'unposted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((lahead as head left join ladetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'  and left(coa.alias, 2) IN ('AR','SA')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(coa.acno, '') as sunaccno, ifnull(coa.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((lahead as head left join ladetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'  and left(coa.alias, 2) NOT IN ('AR','SA')
                                group by head.dateid, head.docno, detail.acno, detail.acnoname, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'  and left(coa.alias, 2)  IN ('AR','SA')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(coa.acno, '') as sunaccno, ifnull(coa.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'  and left(coa.alias, 2) NOT IN ('AR','SA')
                                group by head.dateid, head.docno, detail.acno, detail.acnoname, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((lchead as head left join lcdetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'  and left(coa.alias, 2) IN ('AR','SA')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(coa.acno, '') as sunaccno, ifnull(coa.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((lchead as head left join lcdetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'  and left(coa.alias, 2) NOT IN ('AR','SA')
                                group by head.dateid, head.docno, detail.acno, detail.acnoname, head.rem, head.clientname
                                order by dateid, docno";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select 'u' as tr, 'sj' as bk, detail.acno, detail.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (lahead as head left join ladetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                group by detail.acno, detail.acnoname
                                union all
                                select 'u' as tr, 'sj' as bk, detail.acno, detail.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (lbhead as head left join lbdetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end' 
                                group by detail.acno, detail.acnoname
                                union all
                                select 'u' as tr, 'sj' as bk, detail.acno, detail.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from (lchead as head left join lcdetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end' 
                                group by detail.acno, detail.acnoname order by description";

                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select 'p' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno) left join coa on coa.acnoid=detail.acnoid)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end' and left(coa.alias, 2) in ('ar','sa')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(coa.acno, '') as sunaccno, ifnull(coa.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno) left join coa on coa.acnoid=detail.acnoid)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end' and left(coa.alias, 2) not in ('ar','sa')
                                group by head.dateid, head.docno, coa.acno, detail.acnoname, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'regular' as type, head.clientname,
                                ifnull(sum(detail.db), 0) as regdb, ifnull(sum(detail.cr), 0) as regcr, '' as sunaccno, '' as sunacctname, 0 as sundb, 0 as suncr
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno) left join coa on coa.acnoid=detail.acnoid)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end' and left(coa.alias, 2) in ('ar','sa')
                                group by head.dateid, head.docno, head.rem, head.clientname
                                union all
                                select 'u' as tr, 'sj' as bk, head.dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, 'sundries' as type, head.clientname,
                                0 as regdb, 0 as regcr, ifnull(coa.acno, '') as sunaccno, ifnull(coa.acnoname, '') as sunacctname,
                                ifnull(sum(detail.db), 0) as sundb, ifnull(sum(detail.cr), 0) as suncr
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno) left join coa on coa.acnoid=detail.acnoid)
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end' and left(coa.alias, 2) not in ('ar','sa')
                                group by head.dateid, head.docno, coa.acno, detail.acnoname, head.rem, head.clientname
                                order by dateid, docno";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select 'u' as tr, 'sj' as bk, coa.acno, coa.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from ((glhead as head left join gldetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                group by coa.acno, detail.acnoname
                                union all
                                select 'u' as tr, 'sj' as bk, coa.acno, coa.acnoname as description, sum(detail.db) as debit, sum(detail.cr) as credit
                                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)left join cntnum on cntnum.trno=head.trno)
                                left join coa on coa.acnoid=detail.acnoid
                                where head.doc='sj' and cntnum.center='$center' and head.dateid between '$start' and '$end'
                                group by coa.acno, coa.acnoname order by description";
                            break;
                        }
                    }
                    break;
                }
            }

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rpt_COA()/*NINING*/{

            $result=Yii::$app->sbccommon->opentable("
               select acno, acnoname, alias, type, levelid from coa order by acno, acnoname
               ");

            return $result;
        }
        
        
    //CHECK MONITORING REPORTS    
    public static function rptCH_Bounced($params,$center) /*LFP*/ {
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select head.clientname, head.dateid as trdate, head.docno, detail.checkno as chkinfo, detail.postdate as chkdate, abs(detail.db-detail.cr) as amount
                        from ((lahead as head left join ladetail as detail on detail.trno=head.trno)left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where left(coa.alias, 2) in ('cr','cb') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        and ifnull((select sum(d.trno) from gjdetail as d left join coa as c on c.acno=d.acno
                        where d.trno=head.trno and c.alias='arb' and d.db>0), 0)>0
                        union all
                        select head.clientname, head.dateid as trdate, head.docno, detail.checkno as chkinfo, detail.postdate as chkdate, abs(detail.db-detail.cr) as amount
                        from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where left(coa.alias, 2) in ('cr','cb') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        and ifnull((select sum(d.trno) from gjdetail as d left join coa as c on c.acno=d.acno
                        where d.trno=head.trno and c.alias='arb' and d.db>0), 0)>0
                        union all
                        select head.clientname, head.dateid as trdate, head.docno, detail.checkno as chkinfo, detail.postdate as chkdate, abs(detail.db-detail.cr) as amount
                        from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where left(coa.alias, 2) in ('cr','cb') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        and ifnull((select sum(d.trno) from gjdetail as d left join coa as c on c.acno=d.acno
                        where d.trno=head.trno and c.alias='arb' and d.db>0), 0)>0
                        order by clientname, trdate, docno

                           ";

                    break;
                }
                case 'posted':{
                    $query="
                        select head.clientname, head.dateid as trdate, head.docno, cr.checkno as chkinfo, cr.checkdate as chkdate, abs(cr.db-cr.cr) as amount
                        from (crledger as cr left join glhead as head on head.trno=cr.trno)left join cntnum on cntnum.trno=cr.trno
                        where head.dateid between '$start' and '$end' and cntnum.center='$center'
                        and ifnull((select sum(detail.trno) from gldetail as detail left join coa as c on c.acnoid=detail.acnoid
                        where detail.trno=head.trno and c.alias='arb' and detail.db>0), 0)>0
                        union all
                        select head.clientname, head.dateid as trdate, head.docno, cb.checkno as chkinfo, cb.checkdate as chkdate, abs(cb.cr-cb.db) as amount
                        from (cbledger as cb left join glhead as head on head.trno=cb.trno)left join cntnum on cntnum.trno=cb.trno
                        where head.dateid between '$start' and '$end' and cntnum.center='$center'
                        and ifnull((select sum(detail.trno) from gldetail as detail left join coa as c on c.acnoid=detail.acnoid
                        where detail.trno=head.trno and c.alias='arb' and detail.db>0), 0)>0
                        union all
                        select head.clientname, head.dateid as trdate, head.docno, cr.checkno as chkinfo, cr.checkdate as chkdate, abs(cr.db-cr.cr) as amount
                        from (crledger as cr left join hglhead as head on head.trno=cr.trno)left join cntnum on cntnum.trno=cr.trno
                        where head.dateid between '$start' and '$end' and cntnum.center='$center'
                        and ifnull((select sum(detail.trno) from hgldetail as detail left join coa as c on c.acnoid=detail.acnoid
                        where detail.trno=head.trno and c.alias='arb' and detail.db>0), 0)>0
                        union all
                        select head.clientname, head.dateid as trdate, head.docno, cb.checkno as chkinfo, cb.checkdate as chkdate, abs(cb.cr-cb.db) as amount
                        from (cbledger as cb left join hglhead as head on head.trno=cb.trno)left join cntnum on cntnum.trno=cb.trno
                        where head.dateid between '$start' and '$end' and cntnum.center='$center'
                        and ifnull((select sum(detail.trno) from hgldetail as detail left join coa as c on c.acnoid=detail.acnoid
                        where detail.trno=head.trno and c.alias='arb' and detail.db>0), 0)>0
                        order by clientname, trdate, docno

                        ";

                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

    public static function rptCH_Issued($params,$center) /*LFP*/ {
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            $checks=$params['reporttransaction'];
            if ($checks=="transactiondate") {
                $ch="head.dateid";
            } else {
                $ch="detail.postdate";
            }
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        
                        select 'issued checks' as type, chkdate as pridate, chkdate as suppdate, clientname, docno, chkinfo, amount
                        from (select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                              head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db - detail.cr) as amount
                              from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                              left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cv' and left(coa.alias, 2)='cb'
                              and $ch between '$start' and '$end'
                              union all
                              select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                              head.dateid as trdate, detail.checkno as chkinfo, abs(detail.cr-detail.db) as amount
                              from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                              left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cv' and left(coa.alias, 2)='cb'
                              and $ch between '$start' and '$end'
                              union all
                              select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                              head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                              from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                              left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cv' and left(coa.alias, 2)='cb'
                              and $ch between '$start' and '$end') as rc
                        order by chkinfo, docno"
;

                    break;
                }
                case 'posted':{
                    $query="
                        select 'issued checks' as type, (case when 'prmbased'='cd' then chkdate else trdate end) as pridate,
                        (case when 'prmbased'='cd' then chkdate else trdate end) as suppdate, clientname, docno, chkinfo, amount from
                        (select cr.checkdate as chkdate, head.clientname, head.docno, head.dateid as trdate,
                        cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((cbledger as cr left join glhead as head on head.trno=cr.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where head.doc='cv' and $ch between '$start' and '$end' and cntnum.center='$center'  
                        union all
                        select cr.checkdate as chkdate, head.clientname, head.docno, head.dateid as trdate,
                        cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((cbledger as cr left join hglhead as head on head.trno=cr.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where head.doc='cv' and $ch between '$start' and '$end' and cntnum.center='$center') as rc
                        order by chkinfo, docno

                        ";

                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rptCH_Received($params,$center) /*LFP*/ {
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            $checks=$params['reporttransaction'];
            switch($isposted)
            {
               case 'unposted':{

                    if ($checks=="transactiondate") {
                        $ch="head.dateid";
                    } else {
                        $ch="detail.postdate";
                    }

                    $query="

                        select 'received checks' as type,  trdate  as pridate, chkdate as suppdate,
                        clientname, docno, chkinfo, amount from
                        (select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where cntnum.doc='cr' and cntnum.center='$center' and left(coa.alias, 2)='cr' and $ch between '$start' and '$end'
                        union all
                        select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where cntnum.doc='cr' and cntnum.center='$center' and  left(coa.alias, 2)='cr' and $ch between '$start' and '$end'
                        union all
                        select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where cntnum.doc='cr' and clientname<>'' and cntnum.center='$center' and  left(coa.alias, 2)='cr' and $ch between '$start' and '$end') as t order by clientname
                           ";

                    break;
                }
                case 'posted':{
                    if ($checks=="transactiondate") {
                        $ch="head.dateid";
                    } else {
                        $ch="cr.checkdate";
                    }

                    $query="
                        select 'received checks' as type, trdate as pridate, chkdate as suppdate,
                         clientname, docno, chkinfo, amount from
                        (select cr.checkdate as chkdate, head.clientname, head.docno, head.dateid as trdate,
                        cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((crledger as cr left join glhead as head on head.trno=cr.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where cntnum.center='$center' and $ch between '$start' and '$end'
                        union all
                        select cr.checkdate as chkdate, head.clientname, head.docno, head.dateid as trdate,
                        cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((crledger as cr left join hglhead as head on head.trno=cr.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where cntnum.center='$center' and $ch between '$start' and '$end') as rc  where clientname<>'' 
                        order by clientname
                        ";

                    break;

                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

    public static function rptCH_Receivedyulick($params,$center) /*LFP*/ {
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            $checks=$params['reporttransaction'];
            $cgrp= $params['cgrp'];
            $compref=$params['companypref'];


            $filter="";
            if($params['client']!=""){
                $filter=$filter." and client.client='".$params['client']."'";
            }

            //###################### SET THIS AS A FUNCTION ######################
            $qry = "select availprefs from company_prefixes where cgrp = '".$cgrp."'";
            $prefx=Yii::$app->sbccommon->opentable($qry);

            $findhere = "";
            if(!empty($prefx)){
                foreach ($prefx as $key => $value) {
                    if (strpos($value['availprefs'], ',') !== false){
                    //if there are multiple prefixes per company
                        $pref = explode(',',$value['availprefs']);
                        foreach ($pref as $key => $vpref) {
                            if(!empty($findhere)){
                                $findhere = $findhere . ',"' . $vpref . '"';
                            }else{
                                $findhere = '"' . $vpref . '"';
                            }//end if
                        }//end if
                    }else{
                        if(!empty($findhere)){
                            $findhere = $findhere . ',"' . $value['availprefs'] . '"';
                        }else{
                            $findhere = '"' . $value['availprefs'] . '"';
                        }//end if
                    }//end if
                }//end if for each
            }//end if



            if ($cgrp == ''){
                if ($compref == ''){
                    $filterz = '';   
                } else {
                $filterz = 'and cntnum.bref in ('.$findhere;  
                }
            } else {
                $filterz = 'and cntnum.bref in ('.$findhere;
                if ($compref != ''){
                 $filterz = $filterz.' and companyname = "'.$compref.'"';
                }
                $filterz = $filterz. ')';
            }
            switch($isposted)
            {
               case 'unposted':{

                    if ($checks=="transactiondate") {
                        $ch="head.dateid";
                    } else {
                        $ch="detail.postdate";
                    }

                    $query="

                        select 'received checks' as type,  trdate  as pridate, chkdate as suppdate,
                        clientname, docno, chkinfo, amount from
                        (select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where cntnum.doc='cr' and cntnum.center='$center' and left(coa.alias, 2)='cr' and $ch between '$start' and '$end' $filterz 
                        $filter
                        
                        union all
                        select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where cntnum.doc='cr' and cntnum.center='$center' and  left(coa.alias, 2)='cr' and $ch between '$start' and '$end'
                        union all
                        select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where cntnum.doc='cr' and clientname<>'' and cntnum.center='$center' and  left(coa.alias, 2)='cr' and $ch between '$start' and '$end' $filterz $filter) as t order by clientname
                           ";

                    break;
                }
                case 'posted':{
                    if ($checks=="transactiondate") {
                        $ch="head.dateid";
                    } else {
                        $ch="cr.checkdate";
                    }

                    $query="
                        select 'received checks' as type, trdate as pridate, chkdate as suppdate,
                         clientname, docno, chkinfo, amount from
                        (select cr.checkdate as chkdate, head.clientname, head.docno, head.dateid as trdate,
                        cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((crledger as cr left join glhead as head on head.trno=cr.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where cntnum.center='$center' and $ch between '$start' and '$end' $filterz $filter
                        union all
                        select cr.checkdate as chkdate, head.clientname, head.docno, head.dateid as trdate,
                        cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((crledger as cr left join hglhead as head on head.trno=cr.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where cntnum.center='$center' and $ch between '$start' and '$end' $filterz $filter) as rc  where clientname<>'' 
                        order by clientname
                        ";

                    break;

                }
            }
            //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

    public static function rptCH_Undeposited($params,$center) /*LFP*/ {
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            switch($isposted)
            {
                case 'unposted':{
                    $query="

                        select chkdate, clientname, concat(left(docno,2),right(docno,5)) as docno, trdate, chkinfo, amount 
                        from (select detail.postdate as chkdate, head.client, head.clientname, head.docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where head.doc='cr' and cntnum.center='$center' and  left(coa.alias, 2)='cr' and detail.postdate between '$start' and '$end'
                        union all
                        select detail.postdate as chkdate, head.client, head.clientname, concat(left(head.docno,2),right(head.docno,5)) as docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.cr-detail.db) as amount
                        from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where head.doc='cr' and cntnum.center='$center' and  left(coa.alias, 2)='cr' and detail.postdate between '$start' and '$end'
                        union all
                        select detail.postdate as chkdate, head.client, head.clientname, concat(left(head.docno,2),right(head.docno,5)) as docno,
                        head.dateid as trdate, detail.checkno as chkinfo, abs(detail.db-detail.cr) as amount
                        from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where head.doc='cr' and cntnum.center='$center' and left(coa.alias, 2)='cr' and detail.postdate between '$start' and '$end' ) as udc
                        order by chkdate, clientname
                           ";

                    break;
                }
                case 'posted':{
                    $query="
                        select cr.checkdate as chkdate, head.clientname, concat(left(head.docno,2),right(head.docno,5)) as docno, head.dateid as trdate, cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((crledger as cr left join glhead as head on head.trno=cr.trno)left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where head.doc='cr' and cntnum.center='$center' and  ifnull(cr.depodate, '')='' and cr.checkdate between '$start' and '$end'
                        union all
                        select cr.checkdate as chkdate, head.clientname, concat(left(head.docno,2),right(head.docno,5)) as docno, head.dateid as trdate, cr.checkno as chkinfo, abs(cr.db-cr.cr) as amount, client.client
                        from ((crledger as cr left join hglhead as head on head.trno=cr.trno)left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=cr.trno
                        where head.doc='cr' and cntnum.center='$center' and  ifnull(cr.depodate, '')='' and cr.checkdate between '$start' and '$end'
                        order by chkdate, clientname
                        ";

                    break;
                }
            }

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
       
    //FINANCIAL STATEMENT
    public static function rptFS_BalanceSheet($params,$center)/*FPY*/ {
        $isposted=$params['poststatus'];
        $start=$params['start'];
        $end=$params['end'];

        $query2="select '' as acno,'' as acnoname,0 as levelid,'' as cat,'' as parent,0 as amt,0 as detail,total";

        $coa=Yii::$app->sbccommon->opentable($query2);
        $amt1=0;
        $amt1b=0;
        $amt2=0;
        $amt3=0;
        $amt2b=0;
        $amt3b=0;
        $a=0;
        Reports::planttree($coa,'\\\\' , 'A',$amt1,$amt1b,$a,$start,$end,$center,$isposted);
        Reports::planttree($coa,'\\\\' , 'L',$amt2,$amt2b,$a,$start,$end,$center,$isposted);
        Reports::planttree($coa,'\\\\' , 'C',$amt3,$amt3b,$a,$start,$end,$center,$isposted);
        $coa[]=array('acno'=>'//4999','acnoname'=>'TOTAL LIABILITIES AND STOCKHOLDERS EQUITY','levelid'=>1,'cat'=>'X','parent'=>'X','amt'=>0,'detail'=>0,'total'=>$amt2b+$amt3b);
        return $coa;
    }

    public static function getBalanceSheetQuery2($cat,$acno,$year1,$year2,$center,$view) /*FMM*/ {
        $field='';
        switch($cat) {
            case 'L':
            case 'R':
            case 'G':
            case 'C':
                $field = " sum(detail.cr-detail.db) " ;
                break;
            default:
                $field = " sum(detail.db-detail.cr) " ;
                break;
        }

        switch ($view) {
            case 'MONTHLY':
                $query1="select acno, acnoname, levelid, cat, parent, detail,
                    ifnull(sum(case when mon=1 then amt else 0 end),0) as monjan,
                    ifnull(sum(case when mon=2 then amt else 0 end),0) as monfeb,
                    ifnull(sum(case when mon=3 then amt else 0 end),0) as monmar,
                    ifnull(sum(case when mon=4 then amt else 0 end),0) as monapr,
                    ifnull(sum(case when mon=5 then amt else 0 end),0) as monmay,
                    ifnull(sum(case when mon=6 then amt else 0 end),0) as monjun,
                    ifnull(sum(case when mon=7 then amt else 0 end),0) as monjul,
                    ifnull(sum(case when mon=8 then amt else 0 end),0) as monaug,
                    ifnull(sum(case when mon=9 then amt else 0 end),0) as monsep,
                    ifnull(sum(case when mon=10 then amt else 0 end),0) as monoct,
                    ifnull(sum(case when mon=11 then amt else 0 end),0) as monnov,
                    ifnull(sum(case when mon=12 then amt else 0 end),0) as mondec, yr, ifnull(sum(amt),0) as amt
                    from (
                    select coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail, tb.mon, tb.yr, ifnull(sum(tb.amt),0) as amt
                    from coa left join (
                    select detail.acnoid, month(head.dateid) as mon,year(head.dateid) as yr, $field as amt from glhead as head left join gldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and year(head.dateid) between '$year1' and '$year2'
                    group by detail.acnoid, month(head.dateid), year(head.dateid)
                    union all
                    select detail.acnoid, month(head.dateid) as mon,year(head.dateid) as yr, $field as amt from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and year(head.dateid) between '$year1' and '$year2'
                    group by detail.acnoid, month(head.dateid), year(head.dateid)) as tb on tb.acnoid=coa.acnoid
                    where coa.parent='$acno' and coa.cat='$cat'
                    group by coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail, tb.mon, tb.yr
                    ) as inc group by acno, acnoname, levelid, cat, parent, detail, yr";
                break;
            
            case "3YEARS":
                $query1="select acno, acnoname, levelid, cat, parent, detail,
                    ifnull(sum(case when yr=$year2-2 then amt else 0 end),0) year1,
                    ifnull(sum(case when yr=$year2-1 then amt else 0 end),0) year2,
                    ifnull(sum(case when yr=$year2 then amt else 0 end),0) year3, yr, ifnull(sum(amt),0) as amt
                    from (
                    select coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail, tb.mon, tb.yr, round(ifnull(sum(tb.amt),0),2) as amt
                    from coa left join (
                    select detail.acnoid, month(head.dateid) as mon,year(head.dateid) as yr, $field as amt from glhead as head left join gldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and year(head.dateid) between '$year1' and '$year2'
                    group by detail.acnoid, month(head.dateid), year(head.dateid)
                    union all
                    select detail.acnoid, month(head.dateid) as mon,year(head.dateid) as yr, $field as amt from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and year(head.dateid) between '$year1' and '$year2'
                    group by detail.acnoid, month(head.dateid), year(head.dateid)) as tb on tb.acnoid=coa.acnoid
                    where coa.parent='$acno' and coa.cat='$cat'
                    group by coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail, tb.mon, tb.yr
                    ) as inc group by acno, acnoname, levelid, cat, parent, detail, yr";
                break;
        }

        return $query1;
    }    

    public static function getBalanceSheetQuery($cat,$acno,$date1,$date2,$center,$status) /*FPY*/ {
        $field='';
        switch($cat) {
            case 'L':
            case 'R':
            case 'G':
            case 'C':
                $field = " sum(round(detail.cr-detail.db,2)) " ;
                break;
            default:
                $field = " sum(round(detail.db-detail.cr,2)) " ;
                break;
        }
        switch ($status) {
            case 'unposted':
                $query1="select tb.alias,tb.acno, tb.acnoname, tb.levelid, tb.cat, tb.parent, tb.detail,sum(tb.amt) as amt from
                            (select coa.alias,coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail,ifnull((select $field from lahead as head left join ladetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and detail.acno=coa.acno and head.dateid between  '$date1' and '$date2'),0) as amt from coa where coa.parent='$acno' and coa.cat='$cat'
                            union all
                            select coa.alias,coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail,ifnull((select $field from lbhead as head left join lbdetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and detail.acno=coa.acno and head.dateid between  '$date1' and '$date2'),0) as amt from coa where coa.parent='$acno' and coa.cat='$cat'
                            union all
                            select coa.alias,coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail,ifnull((select $field from lchead as head left join lcdetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and detail.acno=coa.acno and head.dateid between  '$date1' and '$date2'),0) as amt from coa where coa.parent='$acno' and coa.cat='$cat'
                            ) as tb
                            group by tb.acno, tb.acnoname, tb.levelid, tb.cat, tb.parent, tb.detail";

                break;
            default:
                $query1="select tb.alias,tb.acno, tb.acnoname, tb.levelid, tb.cat, tb.parent, tb.detail,sum(tb.amt) as amt from
                            (select coa.alias,coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail,ifnull((select $field from glhead as head left join gldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and detail.acnoid=coa.acnoid and head.dateid between  '$date1' and '$date2'),0) as amt from coa where coa.parent='$acno' and coa.cat='$cat'
                            union all
                            select coa.alias,coa.acno, coa.acnoname, coa.levelid, coa.cat, coa.parent, coa.detail,ifnull((select $field from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and detail.acnoid=coa.acnoid and head.dateid between  '$date1' and '$date2'),0) as amt from coa where coa.parent='$acno' and coa.cat='$cat'
                            ) as  tb
                            group by tb.acno, tb.acnoname, tb.levelid, tb.cat, tb.parent, tb.detail";

                break;
        }
        return $query1;
    }
    public static function getBalanceSheetdue($entry,$cat,$date1,$date2,$center,$status) /*FPY*/ {
        $field='';
        switch($entry) {
            case 'CREDIT':
                $field=' sum(detail.cr-detail.db) ';
                $query1 = "select  ifnull(sum(tb.cr),0) as amt from  ";
                break;
            default:
                $field=' sum(detail.db-detail.cr) ';
                $query1 = "select  ifnull(sum(tb.cr),0) as amt from ";
                break;
        }
        switch ($status) {
            case 'unposted':
                $query1 = $query1." (select $field as cr from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where  cntnum.center='$center' and head.dateid between  '$date1' and '$date2' and coa.cat in $cat
                        union all
                        select $field from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where  cntnum.center='$center' and head.dateid between  '$date1' and '$date2' and coa.cat in $cat
                        union all
                        select $field from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno
                        where  cntnum.center='$center' and head.dateid between  '$date1' and '$date2' and coa.cat in $cat
                        ) as tb ";

                break;
            default:
                $query1 = $query1." (select $field as cr from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                        left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                        where  cntnum.center='$center' and head.dateid between  '$date1' and '$date2' and coa.cat in $cat
                        union all
                        select $field from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
                        left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                        where  cntnum.center='$center' and head.dateid between  '$date1' and '$date2' and coa.cat in $cat  ) as tb ";

                break;
        }
        $result=Yii::$app->sbccommon->datareader($query1);
        return $result;
    }
    public static function planttree(&$a,$acno,$cat,&$amt1,&$amt9,$z,$date1,$date2,$center,$status,$addtionalparams = []) /*FPY*/ {
        $z=$z+1;
        $amt=0;
        $amt2=0;
        $query2=Reports::getBalanceSheetQuery($cat,$acno,$date1,$date2,$center,$status);
        $result2=Yii::$app->sbccommon->opentable($query2);
        for($b=0;$b<count($result2);$b++) {
            $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>$result2[$b]['acnoname'],'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'amt'=>$result2[$b]['amt'],'detail'=>$result2[$b]['detail'],'total'=>$result2[$b]['amt']);
            $prevamt9= $amt9;
            $amt=$amt+$result2[$b]['amt'];
            $amt1=$amt1+$amt;
            $amt9=$amt9+$result2[$b]['amt'];
            $amt=0;
            if($result2[$b]['detail']==0) {
                if(Reports::planttree($a, '\\'.$result2[$b]['acno'], $result2[$b]['cat'],$amt,$amt9,$z,$date1,$date2,$center,$status)) {
                    if($result2[$b]['levelid']>1) {
                        if($result2[$b]['levelid'] == 2){
                            $level2amt = $amt9 - $prevamt9;
                            //THIS NEXT 3 ROWS IS USED TO ADD NEW ROWS TO THE ARRAY (USED FOR PLOTTING NEW ROWS ON REPORT)
                            $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],
                                'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],
                                'amt'=>$amt2,'detail'=>$result2[$b]['detail'],'total'=> $level2amt);
                        }else{
                            //THIS NEXT 3 ROWS IS USED TO ADD NEW ROWS TO THE ARRAY (USED FOR PLOTTING NEW ROWS ON REPORT)
                            $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],
                                'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],
                                'amt'=>$amt2,'detail'=>$result2[$b]['detail'],'total'=>$amt);
                        }//end if
                    }else {
                        if($cat=='C') {
                            $loss=0;
                            $C="('R','G')";
                            $loss=Reports::getBalanceSheetdue('CREDIT',$C, $date1, $date2, $center, $status);
                            $C="('E','O')";
                            $loss=$loss-Reports::getBalanceSheetdue('DEBIT',$C, $date1, $date2, $center, $status);
                            $amt9=$amt9+$loss;
                            //THIS NEXT 3 ROWS IS USED TO ADD NEW ROWS TO THE ARRAY (USED FOR PLOTTING NEW ROWS ON REPORT)
                            $a[]=array('acno'=>'\3999','acnoname'=>'NET INCOME/LOSS TO BALANCE SHEET',
                                'levelid'=>$result2[$b]['levelid']+1,'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],
                                'amt'=>$loss,'detail'=>$result2[$b]['detail'],'total'=>$loss);
                        }//end if

                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                //THIS NEXT 3 ROWS IS USED TO ADD NEW ROWS TO THE ARRAY (USED FOR PLOTTING NEW ROWS ON REPORT)
                                if($result2[$b]['alias'] == 'SCEX'){
                                    $scamt9 = $amt9 - $prevamt9;
                                    $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],
                                    'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],
                                    'amt'=>$amt2,'detail'=>$result2[$b]['detail'],'total'=>$scamt9);
                                }else{
                                    $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],
                                    'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],
                                    'amt'=>$amt2,'detail'=>$result2[$b]['detail'],'total'=>$amt9);
                                }//end if
                            break;

                            default:
                                //THIS NEXT 3 ROWS IS USED TO ADD NEW ROWS TO THE ARRAY (USED FOR PLOTTING NEW ROWS ON REPORT)
                                $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],
                                    'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],
                                    'amt'=>$amt2,'detail'=>$result2[$b]['detail'],'total'=>$amt9);
                            break;
                        }//end switch case
                        
                        //THIS CODE BLOCK IS TO SHOW (TOTAL INCOME FROM OPERATION) TITLE ROW (COMPUTATION: REVENUE - COST OF SALES)
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                if($result2[$b]['alias'] == 'SCOP'){
                                    if(!empty($addtionalparams)){
                                        $scopval = floatval($addtionalparams['totalrev']) - floatval($amt9);
                                    }else{
                                        $scopval = 0;
                                    }//end if
                                    //THIS NEXT 3 ROWS IS USED TO ADD NEW ROWS TO THE ARRAY (USED FOR PLOTTING NEW ROWS ON REPORT)
                                    $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL INCOME FROM OPERATION',
                                    'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],
                                    'amt'=>0,'detail'=>$result2[$b]['detail'],'total'=>$scopval);
                                }//end if
                            break;
                        }//end switch case

                    }//end if IF LEVELID = 1

                }
            }

        }
        if(count($result2)>0) {
            return true;
        }
        else {
            return false;
        }

    }
    public static function rptFS_IncomeStatement($params,$center) /*FPY*/ {
        $isposted=$params['poststatus'];
        $start=$params['start'];
        $end=$params['end'];

        $query2="select '' as acno,'' as acnoname,0 as levelid,'' as cat,'' as parent,0 as amt,0 as detail,total";

        $coa=Yii::$app->sbccommon->opentable($query2);
        $amt1=0;
        $amt1b=0;
        $amt2=0;
        $amt3=0;
        $amt2b=0;
        $amt3b=0;
        $a=0;

        Reports::planttree($coa,'\\\\' , 'R',$amt1,$amt1b,$a,$start,$end,$center,$isposted);
        Reports::planttree($coa,'\\\\' , 'G',$amt1,$amt1b,$a,$start,$end,$center,$isposted);

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
                //HAVE ADDED THIS LINE TO GET TOTAL REVENUE
                $addedparams = ['totalrev'=>$amt1b];
                Reports::planttree($coa,'\\\\' , 'E',$amt2,$amt2b,$a,$start,$end,$center,$isposted,$addedparams);
            break;

            default:
                Reports::planttree($coa,'\\\\' , 'E',$amt2,$amt2b,$a,$start,$end,$center,$isposted);
            break;
        }//end switch
    
        Reports::planttree($coa,'\\\\' , 'O',$amt3,$amt3b,$a,$start,$end,$center,$isposted);

        $coa[]=array('acno'=>'//4999','acnoname'=>'NET INCOME','levelid'=>1,'cat'=>'X','parent'=>'X','amt'=>0,'detail'=>0,'total'=>$amt1b-$amt2b-$amt3b);
        return $coa;

    }

    public static function rptFS_MonthlyIncomeStatement($params) /*FMM*/ {

        $year1=$params['year'];
        $year2=$params['year'];
        $center=$params['center'];
        $view=$params['viewby'];

        $query2="select '' as acno,'' as acnoname,0 as levelid,'' as cat,'' as parent,0 as detail,0 as monjan,0 as monfeb,0 as monmar,0 as monapr,0 as monmay,0 as monjun,0 as monjul,0 as monaug,0 as monsep,0 as monoct,0 as monnov,0 as mondec,'$year1' as year";
        $coa=Yii::$app->sbccommon->opentable($query2);

        $month=array('mjan'=>0,'mfeb'=>0,'mmar'=>0,'mapr'=>0,'mmay'=>0,'mjun'=>0,'mjul'=>0,'maug'=>0,'msep'=>0,'moct'=>0,'mnov'=>0,'mdec'=>0);
        $month2=array('mjan'=>0,'mfeb'=>0,'mmar'=>0,'mapr'=>0,'mmay'=>0,'mjun'=>0,'mjul'=>0,'maug'=>0,'msep'=>0,'moct'=>0,'mnov'=>0,'mdec'=>0);
        $monthE=array('mjan'=>0,'mfeb'=>0,'mmar'=>0,'mapr'=>0,'mmay'=>0,'mjun'=>0,'mjul'=>0,'maug'=>0,'msep'=>0,'moct'=>0,'mnov'=>0,'mdec'=>0);
        $monthE2=array('mjan'=>0,'mfeb'=>0,'mmar'=>0,'mapr'=>0,'mmay'=>0,'mjun'=>0,'mjul'=>0,'maug'=>0,'msep'=>0,'moct'=>0,'mnov'=>0,'mdec'=>0);
        $monthO=array('mjan'=>0,'mfeb'=>0,'mmar'=>0,'mapr'=>0,'mmay'=>0,'mjun'=>0,'mjul'=>0,'maug'=>0,'msep'=>0,'moct'=>0,'mnov'=>0,'mdec'=>0);
        $monthO2=array('mjan'=>0,'mfeb'=>0,'mmar'=>0,'mapr'=>0,'mmay'=>0,'mjun'=>0,'mjul'=>0,'maug'=>0,'msep'=>0,'moct'=>0,'mnov'=>0,'mdec'=>0);
        Reports::planttree2($coa,'\\\\' , 'R',$year1,$year2,$center,$view,$month,$month2);
        Reports::planttree2($coa,'\\\\' , 'G',$year1,$year2,$center,$view,$month,$month2);
        Reports::planttree2($coa,'\\\\' , 'E',$year1,$year2,$center,$view,$monthE,$monthE2);
        Reports::planttree2($coa,'\\\\' , 'O',$year1,$year2,$center,$view,$monthO,$monthO2);

        $coa[]=array('acno'=>'//4999','acnoname'=>'NET INCOME','levelid'=>1,'cat'=>'X','parent'=>'X','detail'=>2,'monjan'=>$month2['mjan']-$monthE2['mjan']-$monthO2['mjan'],'monfeb'=>$month2['mfeb']-$monthE2['mfeb']-$monthO2['mfeb'],'monmar'=>$month2['mmar']-$monthE2['mmar']-$monthO2['mmar'],'monapr'=>$month2['mapr']-$monthE2['mapr']-$monthO2['mapr'],'monmay'=>$month2['mmay']-$monthE2['mmay']-$monthO2['mmay'],'monjun'=>$month2['mjun']-$monthE2['mjun']-$monthO2['mjun'],'monjul'=>$month2['mjul']-$monthE2['mjul']-$monthO2['mjul'],'monaug'=>$month2['maug']-$monthE2['maug']-$monthO2['maug'],'monsep'=>$month2['msep']-$monthE2['msep']-$monthO2['msep'],'monoct'=>$month2['moct']-$monthE2['moct']-$monthO2['moct'],'monnov'=>$month2['mnov']-$monthE2['mnov']-$monthO2['mnov'],'mondec'=>$month2['mdec']-$monthE2['mdec']-$monthO2['mdec'],'yr'=>$year1);
        return $coa;
    }

    public static function planttree2(&$a,$acno,$cat,$year1,$year2,$center,$view,&$month,&$month2) /*FMM*/ {

        $query2=Reports::getBalanceSheetQuery2($cat,$acno,$year1,$year2,$center,$view);

        $result2=Yii::$app->sbccommon->opentable($query2);                 

        for($b=0;$b<count($result2);$b++) {
            
            switch ($view) {
                case 'MONTHLY':                                        
                    $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>$result2[$b]['acnoname'],'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'detail'=>$result2[$b]['detail'],'monjan'=>number_format((float)$result2[$b]['monjan'], 2, '.', ''),'monfeb'=>number_format((float)$result2[$b]['monfeb'], 2, '.', ''),'monmar'=>number_format((float)$result2[$b]['monmar'], 2, '.', ''),'monapr'=>number_format((float)$result2[$b]['monapr'], 2, '.', ''),'monmay'=>number_format((float)$result2[$b]['monmay'], 2, '.', ''),'monjun'=>number_format((float)$result2[$b]['monjun'], 2, '.', ''),'monjul'=>number_format((float)$result2[$b]['monjul'], 2, '.', ''),'monaug'=>number_format((float)$result2[$b]['monaug'], 2, '.', ''),'monsep'=>number_format((float)$result2[$b]['monsep'], 2, '.', ''),'monoct'=>number_format((float)$result2[$b]['monoct'], 2, '.', ''),'monnov'=>number_format((float)$result2[$b]['monnov'], 2, '.', ''),'mondec'=>number_format((float)$result2[$b]['mondec'], 2, '.', ''),'yr'=>$result2[$b]['yr']);
                    $month['mjan'] = $month['mjan']+number_format((float)$result2[$b]['monjan'], 2, '.', '');
                    $month['mfeb'] = $month['mfeb']+number_format((float)$result2[$b]['monfeb'], 2, '.', '');
                    $month['mmar'] = $month['mmar']+number_format((float)$result2[$b]['monmar'], 2, '.', '');
                    $month['mapr'] = $month['mapr']+number_format((float)$result2[$b]['monapr'], 2, '.', '');
                    $month['mmay'] = $month['mmay']+number_format((float)$result2[$b]['monmay'], 2, '.', '');
                    $month['mjun'] = $month['mjun']+number_format((float)$result2[$b]['monjun'], 2, '.', '');
                    $month['mjul'] = $month['mjul']+number_format((float)$result2[$b]['monjul'], 2, '.', '');
                    $month['maug'] = $month['maug']+number_format((float)$result2[$b]['monaug'], 2, '.', '');
                    $month['msep'] = $month['msep']+number_format((float)$result2[$b]['monsep'], 2, '.', '');
                    $month['moct'] = $month['moct']+number_format((float)$result2[$b]['monoct'], 2, '.', '');
                    $month['mnov'] = $month['mnov']+number_format((float)$result2[$b]['monnov'], 2, '.', '');
                    $month['mdec'] = $month['mdec']+number_format((float)$result2[$b]['mondec'], 2, '.', '');
                    
                    $month2['mjan'] = $month2['mjan']+number_format((float)$result2[$b]['monjan'], 2, '.', '');
                    $month2['mfeb'] = $month2['mfeb']+number_format((float)$result2[$b]['monfeb'], 2, '.', '');
                    $month2['mmar'] = $month2['mmar']+number_format((float)$result2[$b]['monmar'], 2, '.', '');
                    $month2['mapr'] = $month2['mapr']+number_format((float)$result2[$b]['monapr'], 2, '.', '');
                    $month2['mmay'] = $month2['mmay']+number_format((float)$result2[$b]['monmay'], 2, '.', '');
                    $month2['mjun'] = $month2['mjun']+number_format((float)$result2[$b]['monjun'], 2, '.', '');
                    $month2['mjul'] = $month2['mjul']+number_format((float)$result2[$b]['monjul'], 2, '.', '');
                    $month2['maug'] = $month2['maug']+number_format((float)$result2[$b]['monaug'], 2, '.', '');
                    $month2['msep'] = $month2['msep']+number_format((float)$result2[$b]['monsep'], 2, '.', '');
                    $month2['moct'] = $month2['moct']+number_format((float)$result2[$b]['monoct'], 2, '.', '');
                    $month2['mnov'] = $month2['mnov']+number_format((float)$result2[$b]['monnov'], 2, '.', '');
                    $month2['mdec'] = $month2['mdec']+number_format((float)$result2[$b]['mondec'], 2, '.', '');              
                    break;
                
                case '3YEARS':   
                    $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>$result2[$b]['acnoname'],'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'detail'=>$result2[$b]['detail'],'year1'=>number_format((float)$result2[$b]['year1'], 2, '.', ''),'year2'=>number_format((float)$result2[$b]['year2'], 2, '.', ''),'year3'=>number_format((float)$result2[$b]['year3'], 2, '.', ''));
                    $month['year1'] = $month['year1']+number_format((float)$result2[$b]['year1'], 2, '.', '');
                    $month['year2'] = $month['year2']+number_format((float)$result2[$b]['year2'], 2, '.', '');
                    $month['year3'] = $month['year3']+number_format((float)$result2[$b]['year3'], 2, '.', '');
                    
                    $month2['year1'] = $month2['year1']+number_format((float)$result2[$b]['year1'], 2, '.', '');
                    $month2['year2'] = $month2['year2']+number_format((float)$result2[$b]['year2'], 2, '.', '');
                    $month2['year3'] = $month2['year3']+number_format((float)$result2[$b]['year3'], 2, '.', '');
                    break;
            }

            if($result2[$b]['detail']==0) {                
                if(Reports::planttree2($a, '\\'.$result2[$b]['acno'], $result2[$b]['cat'],$year1,$year2,$center,$view,$month,$month2)) {                                                                       
                    if($result2[$b]['levelid']>1) {
                        switch ($view){
                            case 'MONTHLY':
                                $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'detail'=>2,'monjan'=>$month['mjan'],'monfeb'=>$month['mfeb'],'monmar'=>$month['mmar'],'monapr'=>$month['mapr'],'monmay'=>$month['mmay'],'monjun'=>$month['mjun'],'monjul'=>$month['mjul'],'monaug'=>$month['maug'],'monsep'=>$month['msep'],'monoct'=>$month['moct'],'monnov'=>$month['mnov'],'mondec'=>$month['mdec'],'yr'=>$year1);                            
                                $month['mjan'] = 0;
                                $month['mfeb'] = 0;
                                $month['mmar'] = 0;
                                $month['mapr'] = 0;
                                $month['mmay'] = 0;
                                $month['mjun'] = 0;
                                $month['mjul'] = 0;
                                $month['maug'] = 0;
                                $month['msep'] = 0;
                                $month['moct'] = 0;
                                $month['mnov'] = 0;
                                $month['mdec'] = 0;
                            break;
                        
                        case '3YEARS':
                                $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'detail'=>2,'year1'=>$month['year1'],'year2'=>$month['year2'],'year3'=>$month['year3']);                            
                                $month['year1'] = 0;
                                $month['year2'] = 0;
                                $month['year3'] = 0;                            
                            break;
                        }
                    }
                    else {
                        if($cat=='C') {
                            $C="('R','G')";
                            $loss=Reports::getBalanceSheetdue2('CREDIT',$C, $year1, $year2, $center, $view);
                            $C="('E','O')";
                            $loss2=Reports::getBalanceSheetdue2('DEBIT',$C, $year1, $year2, $center, $view);
                            
                            $L1 = $loss[0]['year1'] - $loss2[0]['year1'];
                            $L2 = $loss[0]['year2'] - $loss2[0]['year2'];
                            $L3 = $loss[0]['year3'] - $loss2[0]['year3'];
                            
                            $month2['year1'] = $month2['year1'] + number_format((float)$L1,2,'.','');
                            $month2['year2'] = $month2['year2'] + number_format((float)$L2,2,'.','');
                            $month2['year3'] = $month2['year3'] + number_format((float)$L3,2,'.','');
                            
                            $a[]=array('acno'=>'\3999','acnoname'=>'NET INCOME/LOSS TO BALANCE SHEET','levelid'=>$result2[$b]['levelid']+1,'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'detail'=>1,'year1'=>$L1,'year2'=>$L2,'year3'=>$L3);                            
                        }

                        switch ($view){
                            case 'MONTHLY':
                                $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'detail'=>2,'monjan'=>$month2['mjan'],'monfeb'=>$month2['mfeb'],'monmar'=>$month2['mmar'],'monapr'=>$month2['mapr'],'monmay'=>$month2['mmay'],'monjun'=>$month2['mjun'],'monjul'=>$month2['mjul'],'monaug'=>$month2['maug'],'monsep'=>$month2['msep'],'monoct'=>$month2['moct'],'monnov'=>$month2['mnov'],'mondec'=>$month2['mdec']);                           
                            break;
                        
                            case '3YEARS':
                                $a[]=array('acno'=>$result2[$b]['acno'],'acnoname'=>'TOTAL '.$result2[$b]['acnoname'],'levelid'=>$result2[$b]['levelid'],'cat'=>$result2[$b]['cat'],'parent'=>$result2[$b]['parent'],'detail'=>2,'year1'=>$month2['year1'],'year2'=>$month2['year2'],'year3'=>$month2['year3']);                           
                                break;
                        }
                    }
                }
            }
        }

        if(count($result2)>0) {
            return true;
        }
        else {
            return false;
        }

    }

    public static function getBalanceSheetdue2($entry,$cat,$year1,$year2,$center,$view) /*FMM*/ {
        $field='';
        switch($entry) {
            case 'CREDIT':
                $field=' round(ifnull(sum(detail.cr-detail.db),0),2) ';
                break;
            default:
                $field=' round(ifnull(sum(detail.db-detail.cr),0),2) ';
                break;
        }
        
        switch($view){
            case 'MONTHLY':
                $query1="select yr,ifnull(sum(case when mon=1 then cr else 0 end),0) as monjan,
                ifnull(sum(case when mon=2 then cr else 0 end),0) as monfeb,
                ifnull(sum(case when mon=3 then cr else 0 end),0) as monmar,
                ifnull(sum(case when mon=4 then cr else 0 end),0) as monapr,
                ifnull(sum(case when mon=5 then cr else 0 end),0) as monmay,
                ifnull(sum(case when mon=6 then cr else 0 end),0) as monjun,
                ifnull(sum(case when mon=7 then cr else 0 end),0) as monjul,
                ifnull(sum(case when mon=8 then cr else 0 end),0) as monaug,
                ifnull(sum(case when mon=9 then cr else 0 end),0) as monsep,
                ifnull(sum(case when mon=10 then cr else 0 end),0) as monoct,
                ifnull(sum(case when mon=11 then cr else 0 end),0) as monnov,
                ifnull(sum(case when mon=12 then cr else 0 end),0) as mondec
                from (
                select $field as cr, year(head.dateid) as yr, month(head.dateid) as mon
                from glhead as head left join gldetail as detail on detail.trno=head.trno
                left join coa on coa.acnoid=detail.acnoid left join cntnum on cntnum.trno=head.trno
                where  cntnum.center='$center' and year(head.dateid) between  '$year1' and '$year2' and coa.cat in $cat
                group by year(head.dateid), month(head.dateid)
                union all
                select $field as cr, year(head.dateid) as yr, month(head.dateid) as mon
                from hglhead as head left join hgldetail as detail on detail.trno=head.trno
                left join coa on coa.acnoid=detail.acnoid left join cntnum on cntnum.trno=head.trno
                where  cntnum.center='$center' and year(head.dateid) between  '$year1' and '$year2' and coa.cat in $cat
                group by year(head.dateid), month(head.dateid)
                ) as tb group by yr";
                break;
            
            case '3YEARS':
                $query1="select yr,ifnull(sum(case when yr=$year2-2 then cr else 0 end),0) as year1,
                ifnull(sum(case when yr=$year2-1 then cr else 0 end),0) as year2,
                ifnull(sum(case when yr=$year2 then cr else 0 end),0) as year3
                from (
                select $field as cr, year(head.dateid) as yr, month(head.dateid) as mon
                from glhead as head left join gldetail as detail on detail.trno=head.trno
                left join coa on coa.acnoid=detail.acnoid left join cntnum on cntnum.trno=head.trno
                where  cntnum.center='$center' and year(head.dateid) between  '$year1' and '$year2' and coa.cat in $cat
                group by year(head.dateid), month(head.dateid)
                union all
                select $field as cr, year(head.dateid) as yr, month(head.dateid) as mon
                from hglhead as head left join hgldetail as detail on detail.trno=head.trno
                left join coa on coa.acnoid=detail.acnoid left join cntnum on cntnum.trno=head.trno
                where  cntnum.center='$center' and year(head.dateid) between  '$year1' and '$year2' and coa.cat in $cat
                group by year(head.dateid), month(head.dateid)
                ) as tb";                
                break;
        }
        
        $result=Yii::$app->sbccommon->opentable($query1);
        return $result;
    }
    
    public static function rptFS_ComparativeIncomeStatement($params){

        $year1=$params['year']-2;
        $year2=$params['year'];
        $center=$params['center'];
        $view=$params['viewby'];                

        $query2="select '' as acno,'' as acnoname,0 as levelid,'' as cat,'' as parent,0 as detail,0 as year1,0 as year2,0 as year3";
        $coa=Yii::$app->sbccommon->opentable($query2);
        
        $month=array('year1'=>0,'year2'=>0,'year3'=>0);
        $month2=array('year1'=>0,'year2'=>0,'year3'=>0);        
        $monthE=array('year1'=>0,'year2'=>0,'year3'=>0);
        $monthE2=array('year1'=>0,'year2'=>0,'year3'=>0);
        $monthO=array('year1'=>0,'year2'=>0,'year3'=>0);
        $monthO2=array('year1'=>0,'year2'=>0,'year3'=>0);
        Reports::planttree2($coa,'\\\\' , 'R',$year1,$year2,$center,$view,$month,$month2);
        Reports::planttree2($coa,'\\\\' , 'G',$year1,$year2,$center,$view,$month,$month2);
        Reports::planttree2($coa,'\\\\' , 'E',$year1,$year2,$center,$view,$monthE,$monthE2);
        Reports::planttree2($coa,'\\\\' , 'O',$year1,$year2,$center,$view,$monthO,$monthO2);

        $coa[]=array('acno'=>'//4999','acnoname'=>'NET INCOME','levelid'=>1,'cat'=>'X','parent'=>'X','detail'=>2,'year1'=>$month2['year1']-$monthE2['year1']-$monthO2['year1'],'year2'=>$month2['year2']-$monthE2['year2']-$monthO2['year2'],'year3'=>$month2['year3']-$monthE2['year3']-$monthO2['year3']);        
        return $coa;
        
    }
    
    public static function rptFS_ComparativeBalanceSheet($params)/*FMM*/ {
        $year1=$params['year']-2;
        $year2=$params['year'];
        $center=$params['center'];
        $view=$params['viewby'];                

        $query2="select '' as acno,'' as acnoname,0 as levelid,'' as cat,'' as parent,0 as detail,0 as year1,0 as year2,0 as year3";
        $coa=Yii::$app->sbccommon->opentable($query2);
        
        $month=array('year1'=>0,'year2'=>0,'year3'=>0);
        $month2=array('year1'=>0,'year2'=>0,'year3'=>0);          
        $monthL=array('year1'=>0,'year2'=>0,'year3'=>0);
        $monthL2=array('year1'=>0,'year2'=>0,'year3'=>0);                  
        $monthC=array('year1'=>0,'year2'=>0,'year3'=>0);
        $monthC2=array('year1'=>0,'year2'=>0,'year3'=>0);              
        Reports::planttree2($coa,'\\\\' , 'A',$year1,$year2,$center,$view,$month,$month2);
        Reports::planttree2($coa,'\\\\' , 'L',$year1,$year2,$center,$view,$monthL,$monthL2);
        Reports::planttree2($coa,'\\\\' , 'C',$year1,$year2,$center,$view,$monthC,$monthC2);
        
        $coa[]=array('acno'=>'//4999','acnoname'=>'TOTAL LIABILITIES AND STOCKHOLDERS EQUITY','levelid'=>1,'cat'=>'X','parent'=>'X','detail'=>2,'year1'=>$monthL2['year1']+$monthC2['year1'],'year2'=>$monthL2['year2']+$monthC2['year2'],'year3'=>$monthL2['year3']+$monthC2['year3']);
        return $coa;
    }    

    
    public static function rptFS_SubsidiaryLedger($params,$center) /*FPY*/ {
        $isposted=$params['poststatus'];
        $start=$params['start'];
        $end=$params['end'];
        $acno=$params['account'];

        if($acno == ""){
        $acno = "ALL";    
        }
        $cat=Yii::$app->sbccommon->datareader("select cat from coa where acno='\\".$acno."'");
        switch ($cat) {
            case 'L':
            case 'R':
            case 'C':
            case 'O':
                $field=' ifnull(sum(round(detail.cr-detail.db,2)),0) ';
                break;
            default:
                $field=' ifnull(sum(round(detail.db-detail.cr,2)),0) ';
                break;
        }
        //myconstant
        if ($acno=="ALL") {
            $filter_acno=" ";
        } else {
            //$filter_acno=" and concat(coa.acno,coa.L1,coa.L2,coa.L3,coa.L4,coa.L5,coa.L6,coa.L7) like '%".$acno."%'";
            $filter_acno=" and coa.acno='\\".$acno."'";
        }
        $sql = '';
        //return null;
        switch($isposted) {
            case 'posted': {
            $sql="
                
                select '$start' as dateid,'Beginning Balance' as docno,'' as client,'' as clientname,'' as ref,'' as checkno,'' as rem,'' as acno,'' as acnoname,0 as db,0 as cr,sum(t.bal) as begbal,1 as detail
                from (select $field as bal from
                ((((glhead as head left join gldetail as detail on((detail.trno = head.trno))) left join coa
                on((coa.acnoid = detail.acnoid))) left join client on((client.clientid = head.clientid)))
                 left join client as dclient on((dclient.clientid = detail.clientid))) left join cntnum on cntnum.trno=head.trno where head.dateid<'$start' and cntnum.center='$center'  $filter_acno
                union all
                select $field as bal from
                ((((hglhead as head left join hgldetail as detail on((detail.trno = head.trno))) left join coa
                on((coa.acnoid = detail.acnoid))) left join client on((client.clientid = head.clientid)))
                 left join client as dclient on((dclient.clientid = detail.clientid))) left join cntnum on cntnum.trno=head.trno where head.dateid<'$start' and cntnum.center='$center'  $filter_acno) as t
                union all
                select a.dateid,a.docno,a.client,client.clientname,a.ref,a.checkno,a.rem,coa.acno,coa.acnoname,a.db,a.cr,0 as begbal,coa.detail
                from ( select head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,
                client.client as client,head.clientname as clientname,head.rem as rem,detail.line as line,
                coa.acno as acno,coa.acnoname as acnoname,round(detail.db,2) as db,round(detail.cr,2) as cr,
                coa.alias as alias,detail.ref as ref,detail.postdate as postdate,dclient.client as dclient,
                detail.rem as drem,detail.checkno as checkno,coa.acnoid as acnoid,'p' as tr from
                ((((glhead as head left join gldetail as detail on((head.trno = detail.trno))) left join coa
                on((coa.acnoid = detail.acnoid))) left join client on((client.clientid = head.clientid)))
                 left join client as dclient on((dclient.clientid = detail.clientid))) left join cntnum on cntnum.trno=head.trno where head.dateid between '$start' and '$end' and cntnum.center='$center'  $filter_acno
                union all
                select head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,
                client.client as client,head.clientname as clientname,head.rem as rem,detail.line as line,
                coa.acno as acno,coa.acnoname as acnoname,round(detail.db,2) as db,round(detail.cr,2) as cr,
                coa.alias as alias,detail.ref as ref,detail.postdate as postdate,dclient.client as dclient,
                detail.rem as drem,detail.checkno as checkno,coa.acnoid as acnoid,'p' as tr from
                ((((hglhead as head left join hgldetail as detail on((head.trno = detail.trno))) left join coa
                on((coa.acnoid = detail.acnoid))) left join client on((client.clientid = head.clientid)))
                 left join client as dclient on((dclient.clientid = detail.clientid)))left join cntnum on cntnum.trno=head.trno  where head.dateid between '$start' and '$end' and cntnum.center='$center'  $filter_acno) as a
                left join coa on a.acno=coa.acno left join client on client.client = a.client
                order by  acno,dateid,docno";
                    break;
                }
            case 'unposted': {
                    $sql="
                select '$start' as dateid,'Beginning Balance' as docno,'' as client,'' as clientname,'' as ref,'' as checkno,'' as rem,'' as acno,'' as acnoname,0 as db,0 as cr,sum(t.bal) as begbal,1 as detail
                from (select $field as bal from ((((lahead as head left join ladetail as detail on((detail.trno = head.trno))) 
                      left join coa on ((coa.acno = detail.acno))) left join client on((client.client = head.client)))
                      left join client as dclient on((dclient.client = detail.client)))left join cntnum on cntnum.trno=head.trno 
                      where head.dateid<'$start' and cntnum.center='$center' $filter_acno
                      union all
                      select $field as bal from ((((lbhead as head left join lbdetail as detail on((detail.trno = head.trno))) 
                      left join coa on ((coa.acno = detail.acno))) left join client on((client.client = head.client)))
                      left join client as dclient on((dclient.client = detail.client)))left join cntnum on cntnum.trno=head.trno 
                      where head.dateid<'$start' and cntnum.center='$center' $filter_acno
                      union all
                      select $field as bal from ((((lchead as head left join lcdetail as detail on((detail.trno = head.trno))) 
                      left join coa on ((coa.acno = detail.acno))) left join client on((client.client = head.client)))
                      left join client as dclient on((dclient.client = detail.client)))left join cntnum on cntnum.trno=head.trno 
                      where head.dateid<'$start' and cntnum.center='$center' $filter_acno) as t
                union all
                select a.dateid,a.docno,a.client,client.clientname,a.ref,a.checkno,a.rem,coa.acno,coa.acnoname,a.db,a.cr,0 as begbal,coa.detail
                from (select head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,
                      head.client as client,head.clientname as clientname,head.rem as rem,detail.line as line,
                      detail.acno as acno,detail.acnoname as acnoname,detail.db as db,detail.cr as cr,
                      coa.alias as alias,detail.ref as ref,null as postdate,detail.client as dclient,detail.rem as drem,
                      detail.checkno as checkno ,coa.acnoid as acnoid,'u' as tr from ((lahead as head left join ladetail as detail on ((head.trno = detail.trno)))
                      left join coa on ((coa.acno = detail.acno)))left join cntnum on cntnum.trno=head.trno where head.dateid between '$start' and '$end' and cntnum.center='$center' $filter_acno
                      union all
                      select head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,
                      head.client as client,head.clientname as clientname,head.rem as rem,detail.line as line,
                      detail.acno as acno,detail.acnoname as acnoname,detail.db as db,detail.cr as cr,
                      coa.alias as alias,detail.ref as ref,null as postdate,detail.client as dclient,detail.rem as drem,
                      detail.checkno as checkno ,coa.acnoid as acnoid,'u' as tr from ((lbhead as head left join lbdetail as detail on ((head.trno = detail.trno)))
                      left join coa on ((coa.acno = detail.acno)))left join cntnum on cntnum.trno=head.trno where head.dateid between '$start' and '$end' and cntnum.center='$center' $filter_acno
                      union all
                      select head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,
                      head.client as client,head.clientname as clientname,head.rem as rem,detail.line as line,
                      detail.acno as acno,detail.acnoname as acnoname,detail.db as db,detail.cr as cr,
                      coa.alias as alias,detail.ref as ref,null as postdate,detail.client as dclient,detail.rem as drem,
                      detail.checkno as checkno ,coa.acnoid as acnoid,'u' as tr from ((lchead as head left join lcdetail as detail on ((head.trno = detail.trno)))
                      left join coa on ((coa.acno = detail.acno)))left join cntnum on cntnum.trno=head.trno where head.dateid between '$start' and '$end' and cntnum.center='$center' $filter_acno ) as a
                left join coa on a.acno=coa.acno left join client on client.client = a.client
                order by  acno,dateid,docno

                            ";

                    break;
                }
        }   
        $result=Yii::$app->sbccommon->opentable($sql);
        $bal=0;
        for($i=0;$i<count($result);$i++) {
            if($i==0) {
                $bal=$result[$i]['begbal'];
            }
            else {
                switch ($cat) {
                    case 'L':
                    case 'R':
                    case 'C':
                    case 'O':
                        $bal=$bal + ($result[$i]['cr']-$result[$i]['db']) ;
                        break;
                    default:
                        $bal=$bal + ($result[$i]['db']-$result[$i]['cr']) ;
                        break;
                }
                $result[$i]['begbal']=$bal;
            }
        }

        return $result;
    }
    
    public static function rptFS_TrialBalance($params,$center) /*JR*/ {
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select 'u' as tr, coa.acno, coa.acnoname, coa.levelid, sum(ifnull(tb.db,0)-ifnull(tb.cr,0)) as amt
                        from coa left join (select  detail.acno, ifnull(sum(round(detail.db,2)),0) as db, ifnull(sum(round(detail.cr,2)),0) as cr from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and head.dateid between '$start' and '$end'
                        union all
                        select  detail.acno, ifnull(sum(round(detail.db,2)),0) as db, ifnull(sum(round(detail.cr,2)),0) as cr from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and head.dateid between '$start' and '$end'
                        union all
                        select detail.acno, ifnull(sum(detail.db),0) as db, ifnull(sum(detail.cr),0) as cr from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                        left join coa on coa.acno=detail.acno)left join cntnum on cntnum.trno=head.trno where cntnum.center='$center' and head.dateid between '$start' and '$end') as tb on tb.acno=coa.acno
                        group by coa.acno, coa.acnoname, coa.levelid order by coa.acno, coa.acnoname

                        ";

                    break;
                }
                case 'posted':{
                    $query="
                       select 'p' as tr, coa.acno, coa.acnoname, coa.levelid, sum(ifnull(tb.db,0)-ifnull(tb.cr,0)) as amt 
                       from coa left join (select coa.acno, ifnull(sum(round(detail.db,2)),0) as db, ifnull(sum(round(detail.cr,2)),0) as cr from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                       left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                       where cntnum.center='$center' and head.dateid between  '$start' and '$end'
                       group by coa.acno, coa.acnoname, coa.levelid
                       union all
                       select coa.acno, ifnull(sum(round(detail.db,2)),0) as db, ifnull(sum(round(detail.cr,2)),0) as cr from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
                       left join coa on coa.acnoid=detail.acnoid)left join cntnum on cntnum.trno=head.trno
                       where cntnum.center='$center' and head.dateid between  '$start' and '$end') as tb on tb.acno=coa.acno
                       group by coa.acno, coa.acnoname, coa.levelid  order by acno, acnoname;
                        ";

                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    
    //ITEM
    
    public static function rptITEM_List($params) /*JR*/ {

            $filter = "";
            if($params['item']!=""){
            $filter=  " and barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter=  " and brand='".$params['brand']."'";
            }
            if($params['part']!=""){
            $filter=  " and parts.part_id='".$params['partid']."'";
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                   $order = "order by itemname";
                break;
                default:    
                    $order = "order by part,brand,itemname";
                break;
            }

            $query ="
            select current_timestamp as print_date, 0 as sort, barcode, itemname,
            stockgrp.stockgrp_name as groupid, brand,parts.part_name as part,model,body,class,supplier,cost, amt as price 
            from item 
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
            left join part_masterfile as parts on parts.part_id = item.part
            where barcode <> ''  $filter $order";
            
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }

    public static function rptInventorymovementeport($params,$center) /*JR*/ {
            
            $startdate=$params['startdate'];
            $enddate=$params['enddate'];
            $filter="";
            
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['stockgrpid']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['part']!=""){
            $filter=  " and parts.part_id='".$params['partid']."'";
            }

            $costfilter = "";
            if($params['wh']!=""){
            $costfilter = " and wh.client='".$params['wh']."'";
            $filter = " and wh.client='".$params['wh']."'";
            }else{
                $costfilter = "";
            }//end if

            $query="select barcode,itemname,uom,sum(begbal) as begbal,sum(inqty) as inqty,sum(outqty) as outqty,sum(cost) as cost
                from (select barcode,itemname,uom,0 as begbal,0 as inqty,0 as outqty,
                (select cost from rrstatus 
                left join client as wh on wh.clientid = rrstatus.whid
                where itemid=item.itemid ".$costfilter." order by dateid desc limit 1) as cost from item
                UNION ALL
                select barcode,itemname,uom,(sum(qty)-sum(iss)) as begbal,0 as totin,0 as totout,0 as cost from(
                select item.barcode,item.itemname,item.uom,
                stock.qty,stock.iss
                from lastock as stock
                left join item on item.barcode = stock.barcode
                left join client as wh on wh.client = stock.wh
                left join lahead as head on head.trno=stock.trno
                where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI')
                and head.dateid < '".$startdate."' ".$filter."
                union all
                select item.barcode,item.itemname,item.uom,
                stock.qty,stock.iss
                from glstock as stock
                left join item on item.itemid = stock.itemid
                left join client as wh on wh.clientid = stock.whid
                left join glhead as head on head.trno=stock.trno
                where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI')
                and head.dateid < '".$startdate."' ".$filter.") as begbal group by barcode
                UNION ALL
                select barcode,itemname,uom,0 as begbal,sum(qty) as totin,0 as totout,0 as cost from(
                select item.barcode,item.itemname,item.uom,
                stock.qty,stock.iss
                from lastock as stock
                left join item on item.barcode = stock.barcode
                left join client as wh on wh.client = stock.wh
                left join lahead as head on head.trno=stock.trno
                where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI')
                and head.dateid between '".$startdate."' and '".$enddate."' ".$filter."
                union all
                select item.barcode,item.itemname,item.uom,
                stock.qty,stock.iss
                from glstock as stock
                left join item on item.itemid = stock.itemid
                left join client as wh on wh.clientid = stock.whid
                left join glhead as head on head.trno=stock.trno
                where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI')
                and head.dateid between '2017-09-01' and '2017-09-30' ".$filter.") as tblin group by barcode
                UNION ALL
                select barcode,itemname,uom,0 as begbal,0 as totin,sum(iss) as totout,0 as cost from(
                select item.barcode,item.itemname,item.uom,
                stock.qty,stock.iss
                from lastock as stock
                left join item on item.barcode = stock.barcode
                left join client as wh on wh.client = stock.wh
                left join lahead as head on head.trno=stock.trno
                where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI')
                and head.dateid between '".$startdate."' and '".$enddate."' ".$filter."
                union all
                select item.barcode,item.itemname,item.uom,
                stock.qty,stock.iss
                from glstock as stock
                left join item on item.itemid = stock.itemid
                left join client as wh on wh.clientid = stock.whid
                left join glhead as head on head.trno=stock.trno
                where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI')
                and head.dateid between '".$startdate."' and '".$enddate."' ".$filter."
                ) as tblout group by barcode) as runningcoder group by barcode";

               // echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    
    public static function rptInventory_Balance($params,$center) /*JR*/ {
            
            $asof=$params['asof'];
            $itemtype=$params['itemtype'];
            $itemstock=$params['itemstock'];

            switch($itemtype){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            switch($itemstock){
                case "1":
                    $bal="(1)";
                    break;
                case "0":
                    $bal="(0)";
                    break;
                default :
                    $bal="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['stockgrpid']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['part']!=""){
            $filter=  " and parts.part_id='".$params['partid']."'";
            }
            
            $costfilter = "";
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            $costfilter = " and wh.client='".$params['wh']."'";
            }//end if

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                   $order = "order by itemname";
                break;
                default:
                    $order = "order by part, brand,itemname,sizeid";
                break;
            }
            
                $query="
                select ib.itemid,barcode, itemname, groupid,model, part,brand,sizeid,body, class, ib.uom, swh, whname,
                sum(qty-iss)/(case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)  as balance,cost,ib.amt,
                sum(qty-iss)/(case when ifnull(uom2.factor,0)=0 then 1 else uom2.factor end)  as balance2
                from (
                select item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model,parts.part_name as part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus 
                left join client as wh on wh.clientid = rrstatus.whid
                where itemid=item.itemid ".$costfilter." order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                left join part_masterfile as parts on parts.part_id = item.part)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model, parts.part_name as part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus 
                left join client as wh on wh.clientid = rrstatus.whid
                where itemid=item.itemid ".$costfilter." order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                left join part_masterfile as parts on parts.part_id = item.part)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model,parts.part_name as part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus 
                left join client as wh on wh.clientid = rrstatus.whid
                where itemid=item.itemid ".$costfilter." order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                left join part_masterfile as parts on parts.part_id = item.part)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model,parts.part_name as part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus 
                left join client as wh on wh.clientid = rrstatus.whid
                where itemid=item.itemid ".$costfilter." order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                left join part_masterfile as parts on parts.part_id = item.part)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model,parts.part_name as part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus 
                left join client as wh on wh.clientid = rrstatus.whid
                where itemid=item.itemid ".$costfilter." order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                left join part_masterfile as parts on parts.part_id = item.part)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter)as ib
                left join uom on uom.itemid=ib.itemid and uom.uom=ib.uom
                left join uom as uom2 on uom2.itemid=ib.itemid and uom2.uom=ib.invbal_uom
                group by barcode having (case when balance>0 then 1 else 0 end) in $bal $order";

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }

    // ########################  NEW REPORTS XANDA
    public static function rptQuantityonhand($params,$center) /*JR*/ {
            
            $asof=$params['asof'];
            $itemtype=$params['itemtype'];

            switch($itemtype){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['part']!=""){
            $filter= $filter . " and item.part='".$params['part']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }

           
                $query="
                select ib.itemid,barcode, itemname, groupid,brandname,partname,modelname,
                model, part,brand,sizeid,body, class, ib.uom, swh, whname,
                sum(qty-iss)/(case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)  as balance,cost,ib.amt,
                sum(qty-iss)/(case when ifnull(uom2.factor,0)=0 then 1 else uom2.factor end)  as balance2
                from (
                select brandgrp.brand_desc as brandname,partgrp.part_name as partname,modelgrp.model_name as modelname,
                item.invbal_uom,item.itemid,item.barcode, item.itemname,
                item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join model_masterfile as modelgrp on modelgrp.model_id = item.model
                left join part_masterfile as partgrp on partgrp.part_id = item.part
                left join frontend_ebrands as brandgrp on brandgrp.brandid = item.brand
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select brandgrp.brand_desc as brandname,partgrp.part_name as partname,modelgrp.model_name as modelname,
                item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model, item.part,item.groupid,
                item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join model_masterfile as modelgrp on modelgrp.model_id = item.model
                left join part_masterfile as partgrp on partgrp.part_id = item.part
                left join frontend_ebrands as brandgrp on brandgrp.brandid = item.brand
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select brandgrp.brand_desc as brandname,partgrp.part_name as partname,modelgrp.model_name as modelname,
                item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model, item.part,item.groupid,
                item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join model_masterfile as modelgrp on modelgrp.model_id = item.model
                left join part_masterfile as partgrp on partgrp.part_id = item.part
                left join frontend_ebrands as brandgrp on brandgrp.brandid = item.brand
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select brandgrp.brand_desc as brandname,partgrp.part_name as partname,modelgrp.model_name as modelname,
                item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model, item.part,item.groupid,
                item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join model_masterfile as modelgrp on modelgrp.model_id = item.model
                left join part_masterfile as partgrp on partgrp.part_id = item.part
                left join frontend_ebrands as brandgrp on brandgrp.brandid = item.brand
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select brandgrp.brand_desc as brandname,partgrp.part_name as partname,modelgrp.model_name as modelname,
                item.invbal_uom,item.itemid,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand,
                item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join model_masterfile as modelgrp on modelgrp.model_id = item.model
                left join part_masterfile as partgrp on partgrp.part_id = item.part
                left join frontend_ebrands as brandgrp on brandgrp.brandid = item.brand
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter)as ib
                left join uom on uom.itemid=ib.itemid and uom.uom=ib.uom
                left join uom as uom2 on uom2.itemid=ib.itemid and uom2.uom=ib.invbal_uom
                group by barcode having (case when balance>0 then 1 else 0 end) in (0,1) order by part, brand,itemname,sizeid";

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    // ######################## END

    
//JEAR 091916
    public static function rptInventory_Monthly($params,$center) /*JR*/ {
            
            $start=$params['startdate'];
            $end=$params['enddate'];
            $filter="";


            if($params['item']!=""){
            $filter=$filter ." and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter=$filter ." and item.brand='".$params['brand']."'";
            }
            if($params['part']!=""){
            $filter=$filter ." and item.part='".$params['part']."'";
            }
            if($params['wh']!=""){
            $filter=$filter ." and wh.client='".$params['wh']."'";
            }
            
                $query="
                select category,barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname, cost, amt, sum(qty-iss) as balance, sum(del) as del, sum(dmqty) as dmqty, sum(ajqty) as ajqty, sum(spqty) as spqty, sum(sjqty) as sjqty
                from (
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$start' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$start' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$start' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$start' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$start' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, stock.qty as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='RR' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, stock.qty as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and  head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='RR' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, stock.iss as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='CM' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, stock.iss as dmqty, 0 as ajqty, 0 as sjqty, 0 as spqty
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='CM' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, stock.qty as ajqty, 0 as sjqty, 0 as spqty
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='AJ' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, stock.qty as ajqty, 0 as sjqty, 0 as spqty
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='AJ' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, stock.iss as spqty
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='AJ' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, 0 as sjqty, stock.iss as spqty
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='AJ' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, stock.iss as sjqty, 0 as spqty
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='SJ' $filter
                union all
                select item.category,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, 0 as qty, 0 as iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, 0 as del, 0 as dmqty, 0 as ajqty, stock.iss as sjqty, 0 as spqty
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid > '$start' and head.dateid <= '$end' and ifnull(item.barcode,'')<>'' and head.doc='SJ' $filter
                )as ib
                group by category,itemname,barcode having (case when balance>0 then 1 else 0 end) in (0,1)";

               // echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }


    //** KEYWORD ( 08-06-2016 jr )
    public static function rptCurrentInventory_Balancepersupplier($params,$center) /*JR*/ {
            
            $itemtype=$params['itemtype'];

            switch($itemtype){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
            }
            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['part']!=""){
            $filter= $filter . " and item.part='".$params['part']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }
            
                $query="
                select item.isinactive,client.client,client.clientname,wh.clientname as whname,rr.dateid,
                item.barcode,item.itemname,item.groupid,item.brand,item.class,rr.cost,rr.bal,item.uom,rr.docno
                from rrstatus as rr
                left join item on item.itemid=rr.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                left join client on client.clientid=rr.clientid
                left join client as wh on wh.clientid=rr.whid
                where item.isinactive=0 $filter
                order by itemname       
                ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    //** KEYWORD ( 08-06-2016 jr )
    public static function rptAnalyzeitempurchase($params,$center) /*JR*/ {
            $isposted=$params['poststatus'];
            $year=$params['year'];
            $option=$params['itemtype'];

            switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['class']!=""){
            $filter= $filter . " and item.class='".$params['class']."'";
            }
            if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }
            if ($params['analyzedby']=="unit"){
                $war="stock.qty";
            } else {
                $war="stock.ext";
            }


            switch($isposted)
            {
                case 'unposted':{
                    $query="

                        select tr, groupid,groupid, part, brand, model,body, itemname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                        sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                        sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                        
                        select 'u' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand,
                        ifnull(item.part,'NO PART') as part,ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then  $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then  $war else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then  $war else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then  $war else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then  $war else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then  $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then  $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)left join cntnum on cntnum.trno=head.trno
                        left join center on center.code = cntnum.center
                        left join client as wh on wh.client=stock.wh
                        where head.doc='rr' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.part,''), ifnull(item.model,''),item.body, 
                        ifnull(item.itemname,''), year(head.dateid)
                        union all
                        
                        select 'u' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand,
                        ifnull(item.part,'NO PART') as part,ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then  $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then  $war else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then  $war else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then  $war else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then  $war else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then  $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then  $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid )left join cntnum on cntnum.trno=head.trno
                        left join center on center.code = cntnum.center
                        left join client as wh on wh.client=stock.wh
                        where head.doc='rr' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''),  ifnull(item.part,''), ifnull(item.model,''),item.body, 
                        ifnull(item.itemname,''), year(head.dateid)
                        union all
                        
                        select 'u' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand,
                        ifnull(item.part,'NO PART') as part,ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then  $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then  $war else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then  $war else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then  $war else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then  $war else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then  $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then  $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid )left join cntnum on cntnum.trno=head.trno
                        left join center on center.code = cntnum.center
                        left join client as wh on wh.client=stock.wh
                        where head.doc='rr' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''),  ifnull(item.part,''), ifnull(item.model,''),item.body, 
                        ifnull(item.itemname,''), year(head.dateid)
                        ) as xx group by tr, groupid, part,brand, itemname, yr
                           ";

                    break;
                }
                case 'posted':{
                    $query="
                        select tr, groupid, part, brand, model,body, itemname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                        sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                        sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                        
                        select 'p' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand,
                        ifnull(item.part,'NO PART') as part, ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then $war else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then $war else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then $war else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then $war else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='rr' and year(head.dateid)=$year $filter
                        group by ifnull(item.itemname,''), ifnull(item.groupid,'NO GROUP'), ifnull(item.brand,'NO BRAND'), 
                        ifnull(item.part,'NO PART'), ifnull(item.model,'NO MODEL'),item.body, year(head.dateid)
                        
                        union all
                        select 'p' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand,
                        ifnull(item.part,'NO PART') as part, ifnull(item.model,'NO MODEL') as model,item.body, 
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then $war else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then $war else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then $war else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then $war else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='rr' and year(head.dateid)=$year $filter
                        group by ifnull(item.itemname,''), ifnull(item.groupid,'NO GROUP'), ifnull(item.brand,'NO BRAND'), 
                        ifnull(item.part,'NO PART'), ifnull(item.model,'NO MODEL'),item.body, year(head.dateid)
                        ) as xx group by tr, groupid, part, brand, model, itemname, yr


                        ";

                    break;
                }
            }
            
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptAnalyzeitemsales($params,$center) /*JR*/ {
            $isposted=$params['poststatus'];
            $year=$params['year'];
            $option=$params['itemtype'];

            switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['part']!=""){
            $filter=  " and parts.part_id='".$params['partid']."'";
            }
            if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                    if($params['analyzedby'] =="unit"){
                        $war="stock.iss2";
                    } else {
                        $war="stock.ext";
                    }
                break;

                default:
                    if($params['analyzedby'] =="unit"){
                        $war="stock.iss";
                    } else {
                        $war="stock.ext";
                    }
                break;
            }
           
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select tr, groupid, part, brand, model,body, itemname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                        sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                        sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                        select 'u' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand, 
                        ifnull(item.part,'NO PART') as part, ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then $war  else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war  else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war  else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then $war  else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then $war  else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war  else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then $war  else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war  else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from ((lahead as head left join lastock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                        left join part_masterfile as parts on parts.part_id = item.part)left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.part,''), ifnull(item.model,''),item.body, ifnull(item.itemname,''), year(head.dateid)
                        
                        union all
                        select 'u' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand, 
                        ifnull(item.part,'NO PART') as part, ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then $war  else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war  else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war  else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then $war  else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then $war  else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war  else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then $war  else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war  else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from ((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                        left join part_masterfile as parts on parts.part_id = item.part)left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.part,''), ifnull(item.model,''),item.body, ifnull(item.itemname,''), year(head.dateid)
                        union all
                        select 'u' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand, 
                        ifnull(item.part,'NO PART') as part, ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then $war  else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war  else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war  else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then $war  else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then $war  else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war  else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then $war  else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war  else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from ((lchead as head left join lcstock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                        left join part_masterfile as parts on parts.part_id = item.part)left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.part,''), ifnull(item.model,''),item.body, ifnull(item.itemname,''), year(head.dateid)
                        ) as xx group by tr, groupid, part,brand, itemname, yr
                           ";

                    break;
                }
                case 'posted':{
                    $query="
                        select tr, groupid, part, brand, model,body, itemname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                        sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                        sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                    select 'p' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand, 
                        ifnull(item.part,'NO PART') as part, ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then $war  else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war  else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war  else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then $war  else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then $war  else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war  else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then $war  else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war  else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from ((glhead as head left join glstock as stock on stock.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                        left join part_masterfile as parts on parts.part_id = item.part)left join cntnum on cntnum.trno=head.trno
                        left join client on client.clientid=head.clientid
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='sj' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.part,''), ifnull(item.model,''),item.body, 
                        ifnull(item.itemname,''), year(head.dateid)
                        union all
                        select 'p' as tr, ifnull(item.groupid,'NO GROUP') as groupid, ifnull(item.brand,'NO BRAND') as brand, 
                        ifnull(item.part,'NO PART') as part, ifnull(item.model,'NO MODEL') as model,item.body,
                        ifnull(item.itemname,'') as itemname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then $war else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then $war  else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then $war  else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then $war  else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then $war  else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then $war  else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then $war  else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then $war  else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then $war  else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then $war else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then $war else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then $war else 0 end) as modec
                        from ((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid 
                        left join part_masterfile as parts on parts.part_id = item.part)left join cntnum on cntnum.trno=head.trno
                        left join client on client.clientid=head.clientid
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='sj' and year(head.dateid)=$year $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.part,''), ifnull(item.model,''),item.body, 
                        ifnull(item.itemname,''), year(head.dateid)
                        
                        ) as xx group by tr, groupid, part, brand, model, itemname, yr
                        ";
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptcurrent_inventory_aging($params,$center) /*JR*/ {
           
            $option=$params['itemtype'];
            switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['class']!=""){
            $filter= $filter . " and item.class='".$params['class']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and client.client='".$params['wh']."'";
            }

            $query = "
                select item.barcode, item.itemname, item.part, item. model, item.brand,item.body, item.groupid, 
                date(rrstatus.dateid) as dateid, rrstatus.docno, rrstatus.qty, rrstatus.bal, item.uom, 
                (rrstatus.qty-rrstatus.bal) as sold, datediff(now(),rrstatus.dateid) as elapse from rrstatus 
                left join item on item.itemid=rrstatus.itemid 
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                left join cntnum on cntnum.trno=rrstatus.trno 
                left join client on client.clientid=rrstatus.whid
                where item.isinactive=0 and rrstatus.bal>0 $filter
                order by item.barcode, item.itemname, rrstatus.dateid, rrstatus.docno

            ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptFastMovingItems($params,$center) /*JR*/ {
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            $option=$params['itemtype'];

            switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }
            $top ="";
            $filter = " and item.isimport in $loc";

            if($params['top']!=""){
            $top = " limit ".$params['top']."";
            }

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['class']!=""){
            $filter= $filter . " and item.class='".$params['class']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }
            if($params['uom']!=""){
            $filter= $filter . " and stock.uom='".$params['uom']."'";
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                    $isqty = "stock.isqty2";
                    break;
                default:
                    $isqty = "stock.isqty";
                    break;
            }
           
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select tr,groupid,brand,class,whcode,whname,itemname,barcode,qty,uom,part,model,body from (
                        select 'U' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,stock.wh as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from lahead as head left join lastock as stock on stock.trno=head.trno
                        left join item on item.barcode=stock.barcode 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end'  and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),stock.wh,
                        ifnull(item.part,''),ifnull(item.model,''),item.model,item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),item.barcode,stock.uom
                        union all
                        select 'U' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,stock.wh as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from lbhead as head left join lbstock as stock on stock.trno=head.trno
                        left join item on item.barcode=stock.barcode 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),stock.wh,
                        ifnull(item.part,''),ifnull(item.model,''),ifnull(wh.clientname,''),ifnull(item.itemname,''),item.barcode,stock.uom
                        union all
                        select 'U' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,stock.wh as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from lchead as head left join lcstock as stock on stock.trno=head.trno
                        left join item on item.barcode=stock.barcode 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),stock.wh,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),item.barcode,stock.uom) as FM
                        order by part,brand,qty desc $top ";
                    break;
                }
                case 'posted':{
                    $query="
                        select tr,groupid,brand,class,whcode,whname,itemname,barcode,qty,uom,part,model,body from (
                        select 'P' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,wh.client as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from glhead as head left join glstock as stock on stock.trno=head.trno
                        left join item on item.itemid=stock.itemid 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),wh.client,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),
                        item.barcode,stock.uom
                        union all
                        select 'P' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,wh.client as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from hglhead as head left join hglstock as stock on stock.trno=head.trno
                        left join item on item.itemid=stock.itemid 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),wh.client,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),
                        item.barcode,stock.uom) as FM
                        order by part,brand,qty desc $top";

                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rptAnalyzeitemsaleswithprofitmarkup($params,$center) /*JR*/ {
            
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            $option=$params['itemtype'];

            switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['part']!=""){
            $filter= $filter . " and item.part='".$params['part']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }
            if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
            }
            
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select tr, groupid, brand, part, model,body, itemname, ifnull(sum(gsales),0) as gsales, ifnull(sum(discount),0) as disc,
                        ifnull(sum(sreturn),0) as sreturn, ifnull(sum(sales),0) as sales, ifnull(sum(cogs),0) as cogs, ifnull(sum(qtysold),0) as qty
                        from (select 'u' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client,
                        client.clientname, head.dateid, sum(stock.isamt*stock.isqty) as gsales, sum((stock.isamt*stock.isqty)-stock.ext) as discount, 
                        0 as sreturn, sum(stock.ext) as sales, sum(stock.cost*stock.iss) as cogs, sum(stock.iss) as qtysold
                        from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.client = stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and stock.isamt>0 and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'u' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, 
                        client.clientname, head.dateid, 0 as gsales, 0 as discount, sum(stock.isamt*stock.rrqty) as sreturn, 0 as sales, 
                        (sum(stock.cost*stock.qty)*-1) as cogs, (sum(stock.qty)*-1) as qtysold
                        from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.client = stock.wh
                        where head.doc='cm' and head.dateid between '$start' and '$end' and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'u' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client,
                        client.clientname, head.dateid, sum(stock.isamt*stock.isqty) as gsales, sum((stock.isamt*stock.isqty)-stock.ext) as discount, 
                        0 as sreturn, sum(stock.ext) as sales, sum(stock.cost*stock.iss) as cogs, sum(stock.iss) as qtysold
                        from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.client = stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and stock.isamt>0 and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'u' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, 
                        client.clientname, head.dateid, 0 as gsales, 0 as discount, sum(stock.isamt*stock.rrqty) as sreturn, 0 as sales, 
                        (sum(stock.cost*stock.qty)*-1) as cogs, (sum(stock.qty)*-1) as qtysold
                        from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.client = stock.wh
                        where head.doc='cm' and head.dateid between '$start' and '$end' and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'u' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client,
                        client.clientname, head.dateid, sum(stock.isamt*stock.isqty) as gsales, sum((stock.isamt*stock.isqty)-stock.ext) as discount, 
                        0 as sreturn, sum(stock.ext) as sales, sum(stock.cost*stock.iss) as cogs, sum(stock.iss) as qtysold
                        from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.client = stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and stock.isamt>0 and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'u' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, 
                        client.clientname, head.dateid, 0 as gsales, 0 as discount, sum(stock.isamt*stock.rrqty) as sreturn, 0 as sales, 
                        (sum(stock.cost*stock.qty)*-1) as cogs, (sum(stock.qty)*-1) as qtysold
                        from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.client = stock.wh
                        where head.doc='cm' and head.dateid between '$start' and '$end' and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid) as ais
                        group by tr, groupid, brand, itemname
                        order by groupid, brand, itemname";
                    break;
                }
                case 'posted':{
                    $query="
                        select tr, groupid, brand, part, model,body, itemname, ifnull(sum(gsales),0) as gsales, ifnull(sum(discount),0) as disc,
                        ifnull(sum(sreturn),0) as sreturn, ifnull(sum(sales),0) as sales, ifnull(sum(cogs),0) as cogs, ifnull(sum(qtysold),0) as qty
                        from (select 'p' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client,
                        client.clientname, head.dateid, sum(stock.isamt*stock.isqty) as gsales, sum((stock.isamt*stock.isqty)-stock.ext) as discount,
                        0 as sreturn, sum(stock.ext) as sales, sum(stock.cost*stock.iss) as cogs, sum(stock.iss) as qtysold
                        from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.clientid = stock.whid
                        Where head.doc='sj' and head.dateid between '$start' and '$end' and stock.isamt>0 and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'p' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client,
                        client.clientname, head.dateid, 0 as gsales, 0 as discount, sum(stock.isamt*stock.rrqty) as sreturn, 0 as sales,
                        (sum(stock.cost*stock.qty)*-1) as cogs, (sum(stock.qty)*-1) as qtysold
                        from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.clientid = stock.whid
                        Where head.doc='cm' and head.dateid between '$start' and '$end' and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'p' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client,
                        client.clientname, head.dateid, sum(stock.isamt*stock.isqty) as gsales, sum((stock.isamt*stock.isqty)-stock.ext) as discount,
                        0 as sreturn, sum(stock.ext) as sales, sum(stock.cost*stock.iss) as cogs, sum(stock.iss) as qtysold
                        from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.clientid = stock.whid
                        Where head.doc='sj' and head.dateid between '$start' and '$end' and stock.isamt>0 and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid
                        union all
                        select 'p' as tr, item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client,
                        client.clientname, head.dateid, 0 as gsales, 0 as discount, sum(stock.isamt*stock.rrqty) as sreturn, 0 as sales,
                        (sum(stock.cost*stock.qty)*-1) as cogs, (sum(stock.qty)*-1) as qtysold
                        from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                        left join item on item.itemid=stock.itemid
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno left join client as wh on wh.clientid = stock.whid
                        Where head.doc='cm' and head.dateid between '$start' and '$end' and item.barcode<>'' $filter
                        group by item.barcode, item.itemname, item.groupid, item.brand, item.class, item.part, item.model,item.body, item.isimport, client.client, client.clientname, head.dateid) as ais
                        group by tr, groupid, brand, itemname
                        order by groupid, brand, itemname
                        ";

                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }    
    public static function rptInventory_Balancebybranch($params,$center) /*JR*/ {
            $item=isset($params[30]) && strlen($params[30])!=0? $params[30] : "ALL";
            $group=isset($params[9]) && strlen($params[9])!=0? $params[9] : "ALL";
            $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
            $part=isset($params[19]) && strlen($params[19])!=0? $params[19] : "ALL";
            $option2=isset($params[35]) && strlen($params[35])!=0? $params[35] : "BOTH";
            //$center=isset($center) && strlen($center)!=0? $center : "ALL";
            $option=isset($params[34]) && strlen($params[34])!=0? $params[34] : "BOTH";
            $asof=isset($params[2])? $params[2] : 0;
            
            switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }
        
            //constant
            if ($item=="ALL"){
                $it="";
            } else {
                $it="and item.barcode='$item'";
            }
            if ($group=="ALL"){
                $gr="";
            } else {
                $gr="and item.groupid='$group'";
            }
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            if ($part=="ALL"){
                $pt="";
            } else {
                $pt="and item.part='$part'";
            }
                 
                $query="
                select barcode, itemname, groupid, model, part, brand,body, class, uom, swh, whname, whname as cname, sum(qty-iss) as balance
                from (select item.barcode, item.itemname, item.model, item.part, item.groupid, item.brand,item.body, item.class, item.uom, 
                      wh.client as swh, wh.clientname as whname, stock.qty, stock.iss, center.name as centername, wh.clientname as cname                 
                      from lahead as head left join lastock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode 
                      left join client as wh on wh.client=stock.wh left join cntnum on cntnum.trno=head.trno 
                      left join center on center.code=cntnum.center                   
                      where head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $it $gr $br $pt and item.isimport in $loc   
                      union all                 
                      select item.barcode, item.itemname, item.model, item.part, item.groupid, item.brand,item.body, item.class, item.uom, 
                      wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,  center.name as centername, wh.clientname as cname                  
                      from lbhead as head left join lbstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode 
                      left join client as wh on wh.client=stock.wh left join cntnum on cntnum.trno=head.trno 
                      left join center on center.code=cntnum.center                 
                      where head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $it $gr $br $pt and item.isimport in $loc 
                      union all                 
                      select item.barcode, item.itemname, item.model, item.part, item.groupid, item.brand,item.body, item.class, item.uom, 
                      wh.client as swh, wh.clientname as whname, stock.qty, stock.iss, center.name as centername, wh.clientname as cname                   
                      from lchead as head left join lcstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode 
                      left join client as wh on wh.client=stock.wh left join cntnum on cntnum.trno=head.trno 
                      left join center on center.code=cntnum.center                 
                      where head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $it $gr $br $pt and item.isimport in $loc  
                      union all                 
                      select item.barcode, item.itemname, item.model, item.part, item.groupid, item.brand,item.body, item.class, item.uom, 
                      wh.client as swh, wh.clientname as whname, stock.qty, stock.iss, center.name as centername, wh.clientname as cname                  
                      from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid 
                      left join client as wh on wh.clientid=stock.whid left join cntnum on cntnum.trno=head.trno 
                      left join center on center.code=cntnum.center                 
                      where head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $it $gr $br $pt and item.isimport in $loc     
                      union all                 
                      select item.barcode, item.itemname, item.model, item.part, item.groupid, item.brand,item.body, item.class, item.uom, 
                      wh.client as swh, wh.clientname as whname, stock.qty, stock.iss, center.name as centername, wh.clientname as cname                  
                      from hglhead as head left join hglstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid  
                      left join client as wh on wh.clientid=stock.whid left join cntnum on cntnum.trno=head.trno 
                      left join center on center.code=cntnum.center                 
                      where head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $it $gr $br $pt and item.isimport in $loc   
                )as ib
                group by barcode, itemname, groupid, model, part, brand,body, class, uom, swh, whname
                order by groupid, part, brand, itemname
            ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

    public static function rptInventory_Balancebybranchlist($params,$center) /*FPY*/ {
        switch (Common::getcompanyid()){
            case 1:
            $query='
        select client.clientname as name, center.name as center 
                from client left join center on center.warehouse=client.client 
                where client.iswarehouse=1 and center.name is not null 
                and center.code not in ("003","010","020")
            ';              
                  break;
            case 2:
            case 3:
            default:
            $query='
        select client.clientname as name, center.name as center 
                from client left join center on center.warehouse=client.client 
                where client.iswarehouse=1 and center.name is not null
            ';
                  break;
        }

        $result=Yii::$app->sbccommon->opentable($query);
        return $result;

    }

    public static function rptSlowMovingItems($params,$center) /*JR*/ {
            
            $isposted=$params['poststatus'];
            $start=$params['start'];
            $end=$params['end'];
            $option=$params['itemtype'];

            switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }

            $filter = " and item.isimport in $loc";

            $top="";
            if($params['top']!=""){
            $top = " limit ".$params['top']."";
            }else{$top = " limit 1 ";}



            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['class']!=""){
            $filter= $filter . " and item.class='".$params['class']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }
            if($params['uom']!=""){
            $filter= $filter . " and stock.uom='".$params['uom']."'";
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                    $isqty = "stock.isqty2";
                    break;
                default:
                    $isqty = "stock.isqty";
                    break;
            } 

            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select tr,groupid,brand,class,whcode,whname,itemname,barcode,qty,uom,part,model,body from (
                        
                        select 'U' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,stock.wh as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from lahead as head left join lastock as stock on stock.trno=head.trno
                        left join item on item.barcode=stock.barcode 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),stock.wh,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),item.barcode,stock.uom
                        union all
                        select 'U' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,stock.wh as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from lbhead as head left join lbstock as stock on stock.trno=head.trno
                        left join item on item.barcode=stock.barcode 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),stock.wh,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),item.barcode,stock.uom
                        union all
                        select 'U' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,stock.wh as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from lchead as head left join lcstock as stock on stock.trno=head.trno
                        left join item on item.barcode=stock.barcode 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.client=stock.wh
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),stock.wh,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),item.barcode,stock.uom) as FM
                        order by part,brand,qty asc $top";
                        
                    break;
                }
                case 'posted':{
                    $query="
                        select tr,groupid,brand,class,whcode,whname,itemname,barcode,qty,uom,part,model,body from (
                        select 'P' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,wh.client as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from glhead as head left join glstock as stock on stock.trno=head.trno
                        left join item on item.itemid=stock.itemid 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='sj' and head.dateid between '$start' and '$end' and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),wh.client,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),
                        item.barcode,stock.uom
                        union all
                        select 'P' as tr, ifnull(item.groupid,'') as groupid, ifnull(item.brand,'') as brand,
                        ifnull(item.part,'') as part, ifnull(item.model,'') as model,item.body,
                        ifnull(item.class,'') as class,wh.client as whcode,ifnull(wh.clientname,'') as whname,
                        ifnull(item.itemname,'') as itemname,item.barcode,sum('".$isqty."') as qty,stock.uom
                        from hglhead as head left join hglstock as stock on stock.trno=head.trno
                        left join item on item.itemid=stock.itemid 
                        left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                        left join cntnum on cntnum.trno=head.trno
                        left join client as wh on wh.clientid=stock.whid
                        where head.doc='sj' and head.dateid between '$start' and '$end'and ifnull(item.itemid,'')<>'' $filter
                        group by ifnull(item.groupid,''), ifnull(item.brand,''), ifnull(item.class,''),wh.client,
                        ifnull(item.part,''),ifnull(item.model,''),item.body,ifnull(wh.clientname,''),ifnull(item.itemname,''),
                        item.barcode,stock.uom) as FM
                        order by part,brand,qty asc $top
                        ";
                    break;
                }
            }
            //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptSalesperitempercustomer($params,$center) /*FPY*/ {

        $option=$params['option'];
        $filter="";
        if($params['item']!=""){
            $filter=" and item.barcode='".$params['item']."'";
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                    $isqty = "stock.iss2";
                    break;
                default:
                    $isqty = "stock.iss";
                    break;
            } 

            $query="select barcode, itemname, client, clientname, sum($option) as sales
            from (select 'u' as tr, head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode, item.itemname, ".$isqty." as qty, stock.amt, stock.ext as sales
              from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
              left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno
              where head.doc='sj' $filter
              union all
              select 'u' as tr, head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode, item.itemname, ".$isqty." as qty, stock.amt, stock.ext as sales
              from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
              left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno
              where head.doc='sj' $filter
              union all
              select 'u' as tr, head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode, item.itemname, ".$isqty." as qty, stock.amt, stock.ext as sales
              from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
              left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno
              where head.doc='sj' $filter
              union all
              select 'p' as tr, head.trno, head.doc, head.docno, client.client, head.clientname, item.barcode, item.itemname, ".$isqty." as qty, stock.amt, stock.ext as sales
              from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid
              left join item on item.itemid=stock.itemid left join cntnum on cntnum.trno=head.trno
              where head.doc='sj' $filter
              union all
              select 'p' as tr, head.trno, head.doc, head.docno, client.client, head.clientname, item.barcode, item.itemname, ".$isqty." as qty, stock.amt, stock.ext as sales
              from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid
              left join item on item.itemid=stock.itemid left join cntnum on cntnum.trno=head.trno
              where head.doc='sj' $filter
        ) as sa
        group by barcode, itemname, client, clientname
        order by itemname, clientname";
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptInventoryexpired($center) /*FPY*/ {

        $query="select item.barcode, item.itemname, rr.dateid, rr.docno, rr.qty, rr.bal, rr.expiry as expdate,
        datediff(now(), rr.expiry) as no_day
        from rrstatus as rr left join item on item.itemid=rr.itemid left join client as wh on wh.clientid=rr.whid
        left join client on client.clientid=rr.clientid left join cntnum on cntnum.trno=rr.trno
        where rr.bal<>0 and rr.expiry<=date_add(now(),INTERVAL expiryday DAY) and rr.expiry<>'1900-01-01' 
        order by  no_day, itemname";

        $result=Yii::$app->sbccommon->opentable($query);
        return $result;

    }

    public static function rptItemminimum($params,$center) /*FPY*/ {

            $asof=$params['asof'];
            $itemtype=$params['itemtype'];

            switch($itemtype){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            
            }        
         
            $filter = " and item.isimport in $loc";

            if($params['item']!=""){
            $filter= $filter . " and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }
            if($params['brand']!=""){
            $filter= $filter . " and item.brand='".$params['brand']."'";
            }
            if($params['part']!=""){
            $filter= $filter . " and item.part='".$params['part']."'";
            }
            if($params['wh']!=""){
            $filter= $filter . " and wh.client='".$params['wh']."'";
            }
            
                $query="
                select minimum,barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname, sum(qty-iss) as balance,cost,amt
                from (
                select item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter)as ib 
                group by barcode having balance<minimum order by part, brand,itemname,sizeid              
                ";
                //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;

    } 
    public static function rptAboveMaximum($params) /*FMM*/ {

        $asof=$params['asof'];
        // var_dump($params);
        $filter="";
        if($params['item']!=""){
            $filter=$filter . " and item.barcode='".$params['item']."'";
        }
        if($params['group']!=""){
        $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
        }
        if($params['brand']!=""){
            $filter=$filter . " and item.brand='".$params['brand']."'";
        }
        if($params['part']!=""){
            $filter=$filter . " and item.part='".$params['part']."'";
        }
        if($params['wh']!=""){
            $filter=$filter . " and wh.client='".$params['wh']."'";
        }

        $query="
            select barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname, ifnull(sum(qty-iss),0) as balance,cost,amt,maximum
            from (
            select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
            (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, item.maximum
            from (((lahead as head left join lastock as stock on stock.trno=head.trno)
            left join item on item.barcode=stock.barcode
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
            left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
            where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
            union all
            select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
            (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, item.maximum
            from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
            left join item on item.barcode=stock.barcode
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
            left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
            where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
            union all
            select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
            (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, item.maximum
            from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
            left join item on item.barcode=stock.barcode
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
            left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
            where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
            union all
            select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
            (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, item.maximum
            from (((glhead as head left join glstock as stock on stock.trno=head.trno)
            left join item on item.itemid=stock.itemid
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
            left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
            where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
            union all
            select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
            (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt, item.maximum
            from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
            left join item on item.itemid=stock.itemid
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
            left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
            where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter )as ib
            group by barcode having ifnull(sum(qty-iss),0)>maximum order by part,brand,itemname,sizeid              
                ";

            // echo $query;

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }            
            
    public static function rptConsignmentSalesreport($params,$center){
                $start=isset($params[1])? $params[1] : 0;
                $end=isset($params[2])? $params[2] : 0;
                
                $wh =Center::getwhcenter($center);
                $query="
                        select 'sales' as grp, head.doc, head.trno, head.docno, head.dateid, head.client, head.clientname, head.rem, head.acctname, head.acctno, head.cardtype,
                        stock.barcode, stock.itemname, stock.uom, stock.isqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext, stock.ext as balext,
                        item.sizeid, item.brand, item.groupid, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and wh.client='$wh'),0) as bal, null as tdate
                        from ((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                        left join cntnum on cntnum.trno=head.trno where head.doc='sj' and item.category in ('consign','consignment') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        union all
                        select 'returns' as grp, head.doc, head.trno, head.docno, head.dateid, head.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                        stock.barcode, stock.itemname, stock.uom, stock.rrqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext , stock.ext*-1 as balext,
                        item.sizeid, item.brand, item.groupid, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and wh.client='$wh'),0) as bal, null as tdate
                        from ((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                        left join cntnum on cntnum.trno=head.trno where head.doc='cm' and left(head.docno,2)='cm' and item.category in ('consign','consignment') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        union all               
                        select 'sales' as grp, head.doc, head.trno, head.docno, head.dateid, client.client, head.clientname, head.rem, head.acctname, head.acctno, head.cardtype,
                        item.barcode, stock.itemname, stock.uom, stock.isqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext, stock.ext as balext,
                        item.sizeid, item.brand, item.groupid, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and wh.client='$wh'),0) as bal, null as tdate
                        from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                        left join cntnum on cntnum.trno=head.trno)left join client on client.clientid=head.clientid
                        where head.doc='sj' and item.category in ('consign','consignment') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        union all
                        select 'returns' as grp, head.doc, head.trno, head.docno, head.dateid, client.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                        item.barcode, stock.itemname, stock.uom, stock.rrqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext , stock.ext*-1 as balext,
                        item.sizeid, item.brand, item.groupid, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and wh.client='$wh'),0) as bal, null as tdate
                        from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                        left join cntnum on cntnum.trno=head.trno)left join client on client.clientid=head.clientid 
                        where head.doc='cm' and item.category in ('consign','consignment') and left(head.docno,2)='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        order by docno
                   ";
                //echo $query;
                $result=Yii::$app->sbccommon->opentable($query);
                return $result;
            }
    public static function rptConsignmentSalesreport2($params,$center){    
        $start=isset($params[1])? $params[1] : 0;
        $end=isset($params[2])? $params[2] : 0;

            $query="                
                        select grp, pmode, sum(ext) as ext
                        from (select 'sales' as grp, (case when modeofpayment='' then 'CASH' else modeofpayment end) as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext) as ext, null as tdate
                        from (lahead as head left join lastock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno left join item on item.barcode=stock.barcode
                        where head.doc='sj' and item.category in ('consign','consignment') and head.dateid between '$start' and '$end' and cntnum.center='$center' and stock.isamt<>0 group by (case when modeofpayment='' then 'CASH' else modeofpayment end)
                        union all
                        select 'returns' as grp, 'returns' as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext)*-1 as ext, null as tdate
                        from (lahead as head left join lastock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno left join item on item.barcode=stock.barcode
                        where head.doc='cm' and item.category in ('consign','consignment') and left(head.docno,2)='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        union all
                        select 'sales' as grp, (case when modeofpayment='' then 'CASH' else modeofpayment end) as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext) as ext, null as tdate
                        from (glhead as head left join glstock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno left join item on item.itemid=stock.itemid
                        where head.doc='sj' and item.category in ('consign','consignment') and head.dateid between '$start' and '$end' and cntnum.center='$center' and stock.isamt<>0 group by (case when modeofpayment='' then 'CASH' else modeofpayment end)
                        union all
                        select 'returns' as grp, 'returns' as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext)*-1 as ext, null as tdate
                        from (glhead as head left join glstock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno left join item on item.itemid=stock.itemid
                        where head.doc='cm' and item.category in ('consign','consignment') and left(head.docno,2)='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center') as xx
                        group by grp, pmode
                        having sum(ext)<>0

               ";
            $result1=Yii::$app->sbccommon->opentable($query);
            return $result1;
        }
    public static function rptSalespercustomerperitem($params,$center) /*FPY*/ {

        $option=$params['option'];
        $filter="";
        if($params['client']!=""){
            $filter=" and client.client='".$params['client']."'";
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                    $isqty = "stock.iss2";
                    break;
                default:
                    $isqty = "stock.iss";
                    break;
            } 

            $query="select client, clientname, barcode, itemname, sum($option) as sales
            from (select 'u' as tr, head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode, item.itemname, '".$isqty."' as qty, stock.amt, stock.ext as sales
                  from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                  left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno
                  where head.doc='sj' $filter 
                  union all
                  select 'u' as tr, head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode, item.itemname, '".$isqty."' as qty, stock.amt, stock.ext as sales
                  from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                  left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno
                  where head.doc='sj' $filter 
                  union all
                  select 'u' as tr, head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode, item.itemname, '".$isqty."' as qty, stock.amt, stock.ext as sales
                  from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                  left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno
                  where head.doc='sj' $filter 
                  union all
                  select 'p' as tr, head.trno, head.doc, head.docno, client.client, head.clientname, item.barcode, item.itemname, '".$isqty."' as qty, stock.amt, stock.ext as sales
                  from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid
                  left join item on item.itemid=stock.itemid left join cntnum on cntnum.trno=head.trno
                  where head.doc='sj' $filter 
                  union all
                  select 'p' as tr, head.trno, head.doc, head.docno, client.client, head.clientname, item.barcode, item.itemname, '".$isqty."' as qty, stock.amt, stock.ext as sales
                  from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid
                  left join item on item.itemid=stock.itemid left join cntnum on cntnum.trno=head.trno
                  where head.doc='sj' $filter 
            ) as sa
            group by client, clientname, barcode
            order by clientname, itemname";
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;

    }    

//JEAR 091916
    public static function rptcomparativesalespercustomer($params,$center) /*FPY*/ {

        $start=$params['startdate'];
        $end=$params['enddate'];
        $rttstart=$params['rttstartdate'];
        $rttend=$params['rttenddate'];
        $rttstart3=$params['rttstartdate3'];
        $rttend3=$params['rttenddate3'];

            $filter="";
            if ($params['agent']!=''){
            $filter = " and head.agent = '".$params['agent']."'";
            }
            if ($params['class']!=''){
            $class = " and item.class = '".$params['class']."'";
            }
            if($params['area']!=""){
            $filter= " and client.area='".$params['area']."'";
            }
            if($params['category']!=""){
            $filter= " and client.category='".$params['category']."'";
            }

            $query="
            select sum(una_tons) as una_tons,sum(pangalawa_tons) as pangalawa_tons,sum(pangatlo_tons) as pangatlo_tons,
            sum(una_qty) as una_qty,sum(pangalawa_qty) as pangalawa_qty,sum(pangatlo_qty) as pangatlo_qty,
            code,clientname,addr,sum(una_amt) as una_amt,sum(pangalawa_amt) as pangalawa_amt,sum(pangatlo_amt) as pangatlo_amt 
            from (
            select c.client as code,c.clientname,c.addr,sum(stock.ext) as una_amt, 0 as pangalawa_amt,0 as pangatlo_amt,
            sum(((stock.isqty * uom.kilos) / 1000)) as una_tons,0 as pangalawa_tons,0 as pangatlo_tons,
            stock.isqty as una_qty,0 as pangalawa_qty,0 as pangatlo_qty
            from lahead as head
            left join lastock as stock on stock.trno = head.trno
            left join client as c on c.client = head.client
            left join item on item.barcode = stock.barcode
            left join uom on item.itemid = uom.itemid and uom.uom = stock.uom
            left join cntnum as cnt on cnt.trno = head.trno
            where cnt.doc = 'SJ'
            and head.dateid between '$start' and '$end' $filter
            group by c.client
            UNION ALL
            select c.client as code,c.clientname,c.addr,0 as una_amt, sum(stock.ext) as pangalawa_amt,0 as pangatlo_amt,
            0 as una_tons,sum(((stock.isqty * uom.kilos) / 1000)) as pangalawa_tons,0 as pangatlo_tons,
            0 as una_qty,stock.isqty as pangalawa_qty,0 as pangatlo_qty
            from lahead as head
            left join lastock as stock on stock.trno = head.trno
            left join client as c on c.client = head.client
            left join cntnum as cnt on cnt.trno = head.trno
            left join item on item.barcode = stock.barcode
            left join uom on item.itemid = uom.itemid and uom.uom = stock.uom
            where cnt.doc = 'SJ'
            and head.dateid between '$rttstart' and '$rttend' $filter
            group by c.client
            UNION ALL
            select c.client as code,c.clientname,c.addr,sum(stock.ext) as una_amt, 0 as pangalawa_amt,sum(stock.ext) as pangatlo_amt,
            0 as una_tons,0 as pangalawa_tons,sum(((stock.isqty * uom.kilos) / 1000)) as pangatlo_tons,
            0 as una_qty,0 as pangalawa_qty,stock.isqty as pangatlo_qty
            from lahead as head
            left join lastock as stock on stock.trno = head.trno
            left join client as c on c.client = head.client
            left join cntnum as cnt on cnt.trno = head.trno
            left join item on item.barcode = stock.barcode
            left join uom on item.itemid = uom.itemid and uom.uom = stock.uom
            where cnt.doc = 'SJ'
            and head.dateid between '$rttstart3' and '$rttend3' $filter
            group by c.client
            UNION ALL
            select c.client as code,c.clientname,c.addr,sum(stock.ext) as una_amt, 0 as pangalawa_amt,0 as pangatlo_amt,
            sum(((stock.isqty * uom.kilos) / 1000)) as una_tons,0 as pangalawa_tons,0 as pangatlo_tons,
            stock.isqty as una_qty,0 as pangalawa_qty,0 as pangatlo_qty
            from glhead as head
            left join glstock as stock on stock.trno = head.trno
            left join client as c on c.clientid = head.clientid
            left join cntnum as cnt on cnt.trno = head.trno
            left join item on item.itemid = stock.itemid
            left join uom on item.itemid = uom.itemid and uom.uom = stock.uom
            where cnt.doc = 'SJ'
            and head.dateid between '$start' and '$end' $filter
            group by c.client
            UNION ALL
            select c.client as code,c.clientname,c.addr,0 as una_amt, sum(stock.ext) as pangalawa_amt,0 as pangatlo_amt,
            0 as una_tons,sum(((stock.isqty * uom.kilos) / 1000)) as pangalawa_tons,0 as pangatlo_tons,
            0 as una_qty,stock.isqty as pangalawa_qty,0 as pangatlo_qty
            from glhead as head
            left join glstock as stock on stock.trno = head.trno
            left join client as c on c.clientid = head.clientid
            left join cntnum as cnt on cnt.trno = head.trno
            left join item on item.itemid = stock.itemid
            left join uom on item.itemid = uom.itemid and uom.uom = stock.uom
            where cnt.doc = 'SJ' 
            and head.dateid between '$rttstart' and '$rttend' $filter
            group by c.client
            UNION ALL
            select c.client as code,c.clientname,c.addr,0 as una_amt, 0 as pangalawa_amt,sum(stock.ext) as pangatlo_amt,
            0 as una_tons,0 as pangalawa_tons,sum(((stock.isqty * uom.kilos) / 1000)) as pangatlo_tons,
            0 as una_qty,0 as pangalawa_qty,stock.isqty as pangatlo_qty
            from glhead as head
            left join glstock as stock on stock.trno = head.trno
            left join client as c on c.clientid = head.clientid
            left join cntnum as cnt on cnt.trno = head.trno
            left join item on item.itemid = stock.itemid
            left join uom on item.itemid = uom.itemid and uom.uom = stock.uom
            where cnt.doc = 'SJ'
            and head.dateid between '$rttstart3' and '$rttend3' $filter
            group by c.client
            )as tbl group by code order by clientname";

        $result=Yii::$app->sbccommon->opentable($query);
        return $result;

    }    



   public static function rptSalespercustomerperitemyulick($params,$center) /*FPY*/ {
        
        $option=$params['option'];
        $filter="";
        if($params['client']!=""){
            $filter=" and client.client='".$params['client']."'";
            }

            $compref=$params['companypref'];

            if($compref == ''){
                $filterz = '';
            }else{
                $filterz = 'and cntnum.bref in (select availprefs from company_prefixes where companyname = "'.$compref.'")';
            }//end if

            $query="
            select client, clientname, sa.barcode, itemname,rem,
            (select isamt from
            (select head.dateid,stock.barcode,head.client,stock.disc,stock.isamt from lastock as stock left join lahead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode
            where head.doc='SJ'
            union all
            select head.dateid,item.barcode,client.client,stock.disc,stock.isamt from glstock as stock left join glhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join client on client.clientid=head.clientid
            where head.doc='SJ' ) as a where a.barcode=sa.barcode and a.client=sa.client limit 1) as latestcost,
            sum(sales) as sales from (
            select 'u' as tr,stock.rem,
            head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode, item.itemname, stock.iss as qty,
            stock.amt, stock.ext as sales from lahead as head
            left join lastock as stock on stock.trno=head.trno
            left join client on client.client=head.client
            left join item on item.barcode=stock.barcode
            left join cntnum on cntnum.trno=head.trno
            where head.doc='sj' $filter $filterz
            union all
            select 'u' as tr, stock.rem,head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode,
            item.itemname, stock.iss as qty, stock.amt, stock.ext as sales from lbhead as head
            left join lbstock as stock on stock.trno=head.trno
            left join client on client.client=head.client
            left join item on item.barcode=stock.barcode
            left join cntnum on cntnum.trno=head.trno
            where head.doc='sj' $filter $filterz
            union all
            select 'u' as tr, stock.rem,head.trno, head.doc, head.docno, head.client, head.clientname, stock.barcode,
            item.itemname, stock.iss as qty, stock.amt, stock.ext as sales from lchead as head
            left join lcstock as stock on stock.trno=head.trno
            left join client on client.client=head.client
            left join item on item.barcode=stock.barcode
            left join cntnum on cntnum.trno=head.trno
            where head.doc='sj' $filter $filterz
            union all
            select 'p' as tr, stock.rem,head.trno, head.doc, head.docno, client.client, head.clientname, item.barcode,
            item.itemname, stock.iss as qty, stock.amt, stock.ext as sales from glhead as head
            left join glstock as stock on stock.trno=head.trno
            left join client on client.clientid=head.clientid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='sj' $filter $filterz
            union all
            select 'p' as tr,stock.rem,head.trno, head.doc, head.docno, client.client, head.clientname, item.barcode,
            item.itemname, stock.iss as qty, stock.amt, stock.ext as sales from hglhead as head
            left join hglstock as stock on stock.trno=head.trno
            left join client on client.clientid=head.clientid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='sj' $filter $filterz ) as sa
            group by client, clientname, barcode, itemname
            order by clientname, itemname";

        $result=Yii::$app->sbccommon->opentable($query);
        return $result;

    }    

    public static function rptDeliveryStockreport($params,$center) /* ALA */ {
            $item=isset($params[30]) && strlen($params[30])!=0? $params[30] : "ALL";
            $group=isset($params[9]) && strlen($params[9])!=0? $params[9] : "ALL";
            $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
            $part=isset($params[19]) && strlen($params[19])!=0? $params[19] : "ALL";
            $warehouse=isset($params[12]) && strlen($params[12])!=0? $params[12] : "ALL";
            
            $isdetailed=$params[7]=="detailed"? "DETAILED" : "SUMMARIZED";
            
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            
            if ($item=="ALL"){
                $it="";
            } else {
                $it="and item.barcode='$item'";
            }
            if ($group=="ALL"){
                $gr="";
            } else {
                $gr="and item.groupid='$group'";
            }
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            if ($part=="ALL"){
                $pt="";
            } else {
                $pt="and item.part='$part'";
            }
            if ($warehouse=="ALL"){
                $war="";
            } else {
                $war="and hwh.client='$warehouse'";
            }
            
            switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                                select docno, dateid, client, clientname, yourref, ourref, barcode, itemname, uom, rrcost, rrqty, ext
                                from (select item.part,head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lahead as head left join lastock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=stock.wh
                                      left join item on item.barcode=stock.barcode
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lbhead as head left join lbstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=stock.wh
                                      left join item on item.barcode=stock.barcode
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lchead as head left join lcstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=stock.wh
                                      left join item on item.barcode=stock.barcode
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, client.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from glhead as head left join glstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=stock.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, client.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from hglhead as head left join hglstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=stock.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                ) as xx
                                order by clientname, dateid, docno
                            ";
                           
                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select docno, dateid, client, clientname, yourref, ourref, sum(rrqty) as qty, sum(ext) as amount
                                from (select item.part,head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lahead as head left join lastock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=stock.wh
                                      left join item on item.barcode=stock.barcode
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lbhead as head left join lbstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=stock.wh
                                      left join item on item.barcode=stock.barcode
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lchead as head left join lcstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=stock.wh
                                      left join item on item.barcode=stock.barcode
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, client.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from glhead as head left join glstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=stock.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select item.part,head.trno, head.doc, head.docno, head.dateid, client.client, head.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from hglhead as head left join hglstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=stock.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='d'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                ) as xx
                                group by docno, dateid, client, clientname, yourref, ourref
                                order by clientname, dateid, docno
                            ";
                            break;
                        }
                    }
                         
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rptPulloutStockreport($params,$center) /* ALA */ {
            $item=isset($params[30]) && strlen($params[30])!=0? $params[30] : "ALL";
            $group=isset($params[9]) && strlen($params[9])!=0? $params[9] : "ALL";
            $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
            $part=isset($params[19]) && strlen($params[19])!=0? $params[19] : "ALL";
            $warehouse=isset($params[12]) && strlen($params[12])!=0? $params[12] : "ALL";
            
            $isdetailed=$params[7]=="detailed"? "DETAILED" : "SUMMARIZED";
            
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            
            if ($item=="ALL"){
                $it="";
            } else {
                $it="and item.barcode='$item'";
            }
            if ($group=="ALL"){
                $gr="";
            } else {
                $gr="and item.groupid='$group'";
            }
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            if ($part=="ALL"){
                $pt="";
            } else {
                $pt="and item.part='$part'";
            }
            if ($warehouse=="ALL"){
                $war="";
            } else {
                $war="and hwh.client='$warehouse'";
            }
            
            switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                                select docno, dateid, client, clientname, yourref, ourref, barcode, itemname, uom, rrcost, rrqty, ext
                                from (select head.trno, head.doc, head.docno, head.dateid, head.wh as client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lahead as head left join lastock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, head.wh as client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lbhead as head left join lbstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, head.wh as client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lchead as head left join lcstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, hwh.client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from glhead as head left join glstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=head.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, hwh.client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from hglhead as head left join hglstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=head.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                ) as xx
                                order by clientname, dateid, docno
                            ";
                           
                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select docno, dateid, client, clientname, yourref, ourref, sum(rrqty) as qty, sum(ext) as amount
                                from (select head.trno, head.doc, head.docno, head.dateid, head.wh as client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lahead as head left join lastock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, head.wh as client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lbhead as head left join lbstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, head.wh as client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from lchead as head left join lcstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                                      where head.doc='ts' and ifnull(stock.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, hwh.client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from glhead as head left join glstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=head.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                      union all
                                      select head.trno, head.doc, head.docno, head.dateid, hwh.client, hwh.clientname, head.yourref, head.ourref,
                                      stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                                      stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                                      from hglhead as head left join hglstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                                      left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                                      left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=head.whid
                                      where head.doc='ts' and ifnull(item.barcode,'')<>'' and stock.qty>0 and left(head.docno,1)='p'
                                      and head.dateid between '$start' and '$end' $it $gr $br $pt $war
                                ) as xx
                                group by docno, dateid, client, clientname, yourref, ourref
                                order by clientname, dateid, docno
                            ";
                            break;
                        }
                    }
                    
                  
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }        
    public static function rptITEM_Listexcel($params) /*JR*/ {
         
        $item=isset($params[30]) && strlen($params[30])!=0? $params[30] : "ALL";
        $model=isset($params[9]) && strlen($params[9])!=0? $params[9] : "ALL";
        $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
        $class=isset($params[19]) && strlen($params[19])!=0? $params[19] : "ALL"; 
        
        if ($item=="ALL"){
                $it="";
            } else {
                $it="and item.barcode='$item'";
            }
            if ($model=="ALL"){
                $gr="";
            } else {
                $gr="and item.model='$model'";
            }
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            if ($class=="ALL"){
                $pt="";
            } else {
                $pt="and item.class='$class'";
            }
            $result=Yii::$app->sbccommon->opentable("
                select barcode, part as item, model as unit, class as type, brand, itemname as description, body as color, sizeid as packaging,
                supplier as suppname, cost as suppcost, amt as mainsrp, srpa as cbayala, comma, icomma, srpb as cbbaliwag, commb, icommb,
                srpc as cbcalamba, commc, icommc, srpd as cbdasma, commd, icommd, srpe as cblaspinas, comme, icomme, srpf as cbpampanga,
                commf, icommf, srpg as cbsanpablo, commg, icommg, srph as cbnorthedsa, commh, icommh, srpi as cbsucat, commi, icommi,
                srpj as cbisabela, commj, icommj, srpk as cbapalit, commk, icommk, srpl as cbclark, comml, icomml, srpm as cbstamesa,
                commm, icommm, srpn as cbmanila, commn, icommn, srpo as cbbicutan, commo, icommo, srpp as cbbatangas, commp, icommp,
                srpq as cbrosario, commq, icommq, srpr as cbmuntinlupa, commr, icommr, srps as cbbacoor, comms, icomms, srpt as cbmolino,
                commt, icommt, srpu as sanlazaro, commu, icommu, srpv as cblucena, commv, icommv, srpw as cbnovaliches, commw, icommw,
                srpx as cbvalenzuela, commx, icommx, srpy as cbsanfernando, commy, icommy, srpz as cbpasig, commz, icommz, srpa1 as cbmarilao,
                comma1, icomma1, srpa2 as cbsouth, comma2, icomma2, srpa3 as cbnewbranch, comma3, icomma3
                from item where ''='' $it $gr $br $pt order by item, unit, class, type, description, color, packaging     
               ");
            return $result;
    }
    public static function rptItem_purchasereport($params,$center) /*JR*/ {
            $item=isset($params[8]) && strlen($params[8])!=0? $params[8] : "ALL";
            $group=isset($params[9]) && strlen($params[9])!=0? $params[9] : "ALL";
            $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
            $part=isset($params[19]) && strlen($params[19])!=0? $params[19] : "ALL";
            $warehouse=isset($params[12]) && strlen($params[12])!=0? $params[12] : "ALL";
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            $option=isset($params[34]) && strlen($params[34])!=0? $params[34] : "BOTH";
            
           switch($option){
                case "local":
                    $loc="(0)";
                    break;
                case "import":
                    $loc="(1)";
                    break;
                default :
                    $loc="(0,1)";
            }
           
            //constant
            if ($item=="ALL"){
                $it="";
            } else {
                $it="and item.itemname='$item'";
            }
            if ($group=="ALL"){
                $gr="";
            } else {
                $gr="and item.groupid='$group'";
            }
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            if ($part=="ALL"){
                $pt="";
            } else {
                $pt="and item.part='$part'";
            }
            if ($warehouse=="ALL"){
                $war="";
            } else {
                $war="and wh.client='$warehouse'";
            }
            
                $query="
                    
                
                select barcode, itemname, dateid , qty, price, uom, brand, part,model,sizeid,body,groupid from(
                select item.barcode, item.itemname, head.dateid, sum(stock.qty) as qty, sum(stock.cost) as price, item.uom, item.brand, item.part,item.model,item.sizeid,item.body,item.groupid,wh.client from lahead as head
                left join lastock as stock on stock.trno = head.trno
                left join item on item.barcode = stock.barcode
                left join client as wh on wh.client=head.wh
                where head.doc = 'rr' 
                group by item.barcode, item.itemname, head.dateid, item.uom, item.brand
                union all
                select item.barcode, item.itemname, head.dateid, sum(stock.qty) as qty, sum(stock.cost) as price, item.uom, item.brand, item.part,item.model,item.sizeid,item.body,item.groupid,wh.client from glhead as head
                left join glstock as stock on stock.trno = head.trno
                left join item on item.itemid = stock.itemid
                left join client as wh on wh.clientid=head.whid
                where head.doc = 'rr' and head.dateid between '$start' and '$end' $it $gr $br $pt $war and item.isimport in $loc
                group by item.barcode, item.itemname, head.dateid, item.uom, item.brand) as ip
                order by brand, part, itemname             
                ";
            //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rptItem_valuationreport($params,$center,$barcode) /*JR*/ {
            $item=isset($params[30]) && strlen($params[30])!=0? $params[30] : "ALL";
            $group=isset($params[9]) && strlen($params[9])!=0? $params[9] : "ALL";
            $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
            $class=isset($params[11]) && strlen($params[11])!=0? $params[11] : "ALL";
            $year=isset($params[13])? $params[13] : 0;
            

                         $it="and item.barcode='$barcode'";
             
            if ($group=="ALL"){
                $gr="";
            } else {
                $gr="and item.groupid='$group'";
            }
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            if ($class=="ALL"){
                $cl="";
            } else {
                $cl="and item.class='$class'";
            }
            
                $query="
                    
                select doc,mnth,yr,barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname,
                0 as mojan,0 as mofeb,0 as momar,0 as moapr,0 as momay,0 as mojun,0 mojul,0 as moaug,0 as mosep,0 as mooct,
                0 as monov,0 as modec,cost,amt,sum(qty-iss) as beg
                from (
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0  )as ib
                group by barcode,doc,mnth,yr
                union all
                select doc,mnth,yr,barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname,
                sum(case when mnth=1 then qty-iss else 0 end) as mojan,
                sum(case when mnth=2 then qty-iss else 0 end) as mofeb,
                sum(case when mnth=3 then qty-iss else 0 end) as momar,
                sum(case when mnth=4 then qty-iss else 0 end) as moapr,
                sum(case when mnth=5 then qty-iss else 0 end) as momay,
                sum(case when mnth=6 then qty-iss else 0 end) as mojun,
                sum(case when mnth=7 then qty-iss else 0 end) as mojul,
                sum(case when mnth=8 then qty-iss else 0 end) as moaug,
                sum(case when mnth=9 then qty-iss else 0 end) as mosep,
                sum(case when mnth=10 then qty-iss else 0 end) as mooct,
                sum(case when mnth=11 then qty-iss else 0 end) as monov,
                sum(case when mnth=12 then qty-iss else 0 end) as modec,cost,amt, 0 as beg
                from (
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0  )as ib
                group by itemname,barcode,doc
                order by barcode,itemname,doc
          
                ";
            //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }    

        public static function rptItem_valuationreportsum($params,$center) /*JR*/ {
            $item=isset($params[30]) && strlen($params[30])!=0? $params[30] : "ALL";
            $group=isset($params[9]) && strlen($params[9])!=0? $params[9] : "ALL";
            $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
            $class=isset($params[11]) && strlen($params[11])!=0? $params[11] : "ALL";
            $year=isset($params[13])? $params[13] : 0;
            
           
            //constant
            if ($item=="ALL"){
                $it="";
            } else {
                $it="and item.barcode='$item'";
            }
            if ($group=="ALL"){
                $gr="";
            } else {
                $gr="and item.groupid='$group'";
            }
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            if ($class=="ALL"){
                $cl="";
            } else {
                $cl="and item.class='$class'";
            }
            
                $query="
                    
                select doc,mnth,yr,barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname,
                0 as mojan,0 as mofeb,0 as momar,0 as moapr,0 as momay,0 as mojun,0 mojul,0 as moaug,0 as mosep,0 as mooct,
                0 as monov,0 as modec,cost,amt,sum(qty-iss) as beg
                from (
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = ($year-1) $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0  )as ib
                group by barcode
                union all
                select doc,mnth,yr,barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname,
                sum(case when mnth=1 then qty-iss else 0 end) as mojan,
                sum(case when mnth=2 then qty-iss else 0 end) as mofeb,
                sum(case when mnth=3 then qty-iss else 0 end) as momar,
                sum(case when mnth=4 then qty-iss else 0 end) as moapr,
                sum(case when mnth=5 then qty-iss else 0 end) as momay,
                sum(case when mnth=6 then qty-iss else 0 end) as mojun,
                sum(case when mnth=7 then qty-iss else 0 end) as mojul,
                sum(case when mnth=8 then qty-iss else 0 end) as moaug,
                sum(case when mnth=9 then qty-iss else 0 end) as mosep,
                sum(case when mnth=10 then qty-iss else 0 end) as mooct,
                sum(case when mnth=11 then qty-iss else 0 end) as monov,
                sum(case when mnth=12 then qty-iss else 0 end) as modec,cost,amt, 0 as beg
                from (
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0
                union all
                select head.doc,month(head.dateid) as mnth,year(head.dateid) as yr,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  year(head.dateid) = $year $it $gr $br $cl and ifnull(item.barcode,'')<>'' and item.isinactive=0  )as ib
                group by itemname,barcode
                order by barcode,itemname,doc
          
                ";
             // echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rptPrice_List($params) /*JAC*/ {

            $filter = "";

            if($params['class']!=""){
            $filter= $filter. " and class='".$params['class']."' ";
            }
            
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }

            if($params['brand']!=""){
            $filter= $filter. " and brand='".$params['brand']."' ";
            }

            if($params['category']!=""){
            $filter= $filter.  " and category='".$params['category']."' ";
            }

                        
           $arrangeby = "";
            if ($params['arrangeby'] == "barcode"){
                $arrangeby = " item.barcode";
            }else{
                $arrangeby = " item.itemname";
            }

            $include = $params['include'];
            
            $query ="
            select item.barcode,item.itemname,item.uom,item.amt,item.brand,item.class,item.groupid,item.category from item 
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
            where ''='' and item.isinactive in ($include) $filter order by $arrangeby
            ";
            
            $result=Yii::$app->sbccommon->opentable($query);            
            return $result;
        }

    public static function rptScheduleofInv($params) /*JAC*/ {

            $filter = "";

            if($params['class']!=""){
            $filter= $filter. " and item.class='".$params['class']."' ";
            }
            if($params['group']!=""){
            $filter=  " and stockgrp.stockgrp_id='".$params['stockgrpid']."'";
            }

            if($params['brand']!=""){
            $filter= $filter. " and item.brand='".$params['brand']."' ";
            }

            if($params['category']!=""){
            $filter= $filter.  " and item.category='".$params['category']."' ";
            }

            if($params['wh']!=""){
            $filter= $filter.  " and wh.client='".$params['wh']."'";
            }
                        
            $arrangeby = "";
            if ($params['arrangeby'] == "barcode"){
                $arrangeby = " barcode";
            }else{
                $arrangeby = " itemname";
            }

            $asof = $params['asof'];

            $include = $params['include'];
            
            $query ="select barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname, sum(qty-iss) as balance,cost,amt,kilos,category
                from (
                select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt,uom.kilos,item.category
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join uom on uom.itemid = item.itemid
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt,uom.kilos,item.category
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
                left join item on item.barcode=stock.barcode)
                left join uom on uom.itemid = item.itemid
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt,uom.kilos,item.category
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                left join item on item.barcode=stock.barcode
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join uom on uom.itemid = item.itemid
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt,uom.kilos,item.category
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join uom on uom.itemid = item.itemid
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter
                union all
                select item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt,uom.kilos,item.category
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                left join item on item.itemid=stock.itemid
                left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid)
                left join uom on uom.itemid = item.itemid
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$asof' and ifnull(item.barcode,'')<>'' $filter )as ib
                group by barcode having balance<> 0 order by class,$arrangeby ";
            
            $result=Yii::$app->sbccommon->opentable($query);            
            return $result;
        }    


    //CUSTOMER
    public static function rptcustomer_customercharges($params,$center) /* kevin */ {

            $start=$params['startdate'];
            $end=$params['enddate'];
            $paidunpaid = $params['paidunpaid'];

            $item = "";

            if ($params['item']!=''){
                $item =" and item.barcode = '".$params['item']."'";
            }
            switch ($paidunpaid) {
                case '1':
                    $pua = "and ar.bal = 0";
                    break;
                case '2':
                    $pua = "and ar.bal <> 0";
                    break;
                case '3':
                    $pua = "";
                    break;    
            }

                $query = "select head.docno,head.dateid,customer.clientname as customername,customer.client as clientcode,
                stock.itemname,stock.ext as chargeamt from glhead as head
                left join glstock as stock on stock.trno = head.trno
                left join item on item.itemid = stock.itemid
                left join client as customer on customer.clientid = head.clientid
                left join arledger as ar on ar.trno = head.trno
                left join cntnum as num on num.trno = head.trno
                where num.doc = 'SJ' and ar.bal = 0
                and item.barcode in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                and head.dateid between '$start' and '$end' $item $pua";
               
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

    public static function rptCustomer_List($params,$center) {
        
        $filter="";
        if($params['area']!=""){
            $filter= " and area='".$params['area']."'";
        }

        if($params['province']!=""){
            $filter= " and province='".$params['province']."'";
        }

        if($params['region']!=""){
            $filter= " and region='".$params['region']."'";
        }

        $query="select client,clientname, province,region,area, addr, tel, tin from client where iscustomer=1 and clientname<>'' $filter order by clientname";
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptCOutstandingCustomerreceivables($params,$center) /* kevin */ {

            $filter="";
            if($params['client']!=""){
                $filter= " and client.client='".$params['client']."'";
            }         
        
              $query= " select 'p' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
               date_format(detail.dateid,'%Y-%m-%d') as dateid, detail.docno, datediff(now(), date(detail.dateid)) as elapse,
               (case when detail.db>0 then detail.bal else (detail.bal*-1) end) as balance
               from (arledger as detail left join client on client.clientid=detail.clientid)
               left join cntnum on cntnum.trno=detail.trno where detail.bal<>0 $filter and cntnum.center='$center'
               order by clientname,dateid, docno";
                      
            // echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptCOutstandingCustomerreceivableaging($params,$center) /* kevin */ {

            $filter="";
            if($params['client']!=""){
                $filter= " and client.client='".$params['client']."'";
            }

            $query= "
            select 'p' as tr,  client.clientname, ifnull(client.clientname,'no name') as name, client.addr as address,
            date(detail.dateid) as dateid, detail.docno, datediff(now(), detail.dateid) as elapse,
            (case when detail.db>0 then detail.bal else (detail.bal*-1) end) as balance, date(head.due) as due, head.terms
            from ((glhead as head left join arledger as detail on detail.trno=head.trno)
            left join client on client.clientid=detail.clientid)
            left join cntnum on cntnum.trno=detail.trno
            where detail.bal<>0 and cntnum.center='$center' $filter
            union all
            select 'p' as tr,  client.clientname, ifnull(client.clientname,'no name') as name, client.addr as address,
            date(detail.dateid) as dateid, detail.docno, datediff(now(), detail.dateid) as elapse,
            (case when detail.db>0 then detail.bal else (detail.bal*-1) end) as balancee, date(head.due) as due, head.terms
            from ((hglhead as head left join arledger as detail on detail.trno=head.trno)
            left join client on client.clientid=detail.clientid)
            left join cntnum on cntnum.trno=detail.trno
            where detail.bal<>0 and cntnum.center='$center' $filter
            order by clientname, dateid, docno";
                      
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }

    public static function rptAnalyze_Customersales_INFINITEA($params,$center) /* JAOSKI (MODIFIED 05-31-2017) */ {
        $isposted=$params['poststatus'];
            $year=$params['year'];
            switch($isposted){
                case 'unposted':{
                    $query="
                           select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                           sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                           sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lahead as head 
                                left join lastock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.barcode = stock.barcode
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext <> 0
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.barcode = stock.barcode
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lchead as head left join lcstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.barcode = stock.barcode
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                group by ifnull(client.clientname,''), year(head.dateid)
                           ) as x group by clientname, yr order by clientname, yr";
                }
                break;
                
                case 'posted':{
                    $query="
                           select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                           sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                           sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                                select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((glhead as head left join glstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.itemid = stock.itemid
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.itemid = stock.itemid
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                group by ifnull(client.clientname,''), year(head.dateid)
                                ) as x group by clientname, yr order by clientname, yr";
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }//END INFINITEA

    public static function rptAnalyze_Customersales($params,$center) /* kevin */ {
            $isposted=$params['poststatus'];
            $year=$params['year'];

            switch($isposted)
            {
                case 'unposted':{
                    $query="
                           select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                           sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                           sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lahead as head left join lastock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext <> 0
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lchead as head left join lcstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                group by ifnull(client.clientname,''), year(head.dateid)

                           ) as x group by clientname, yr order by clientname, yr
                        ";
                }
                break;
                case 'posted':{
                    $query="
                           select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                           sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                           sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                                select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((glhead as head left join glstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0
                                group by ifnull(client.clientname,''), year(head.dateid)

                           ) as x group by clientname, yr order by clientname, yr

                        ";
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }    

    public static function rptAnalyze_Customersalesyulick($params,$center) /* kevin */ {
            $isposted=$params['poststatus'];
            $year=$params['year'];
            $compref=$params['companypref'];

            if($compref == ''){
                $filterz = '';
            }else{
                $filterz = 'and cntnum.bref in (select availprefs from company_prefixes where companyname = "'.$compref.'")';
            }//end if
            
            switch($isposted){
                case 'unposted':{
                    $query="
                           select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                           sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                           sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lahead as head left join lastock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0 $filterz
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0 $filterz
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'u' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((lchead as head left join lcstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and stock.ext<>0 $filterz
                                group by ifnull(client.clientname,''), year(head.dateid)

                           ) as x group by clientname, yr order by clientname, yr


                        ";
                }
                //echo $query;
                break;
                case 'posted':{
                    $query="


                           select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                           sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                           sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (

                                select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((glhead as head left join glstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and cntnum.bref in (select availprefs from company_prefixes where companyalias = '$compref')
                                and stock.ext<>0
                                group by ifnull(client.clientname,''), year(head.dateid)
                                union all
                                select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                                sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                                sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                                sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                                sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                                sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                                sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                                sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                                sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                                sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                                sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                                sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                                sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                                from ((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                                and cntnum.bref in (select availprefs from company_prefixes where companyalias = '$compref')
                                and stock.ext<>0
                                group by ifnull(client.clientname,''), year(head.dateid)

                           ) as x group by clientname, yr order by clientname, yr

                        ";
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }    

    public static function rptSales_Reports_INFINITEA($params,$center)/*JAOSKI (MODIFIED 05-31-2017)*/{
            $reporttype=$params['salesreporttype'];
            $isposted=$params['poststatus'];
            $start=$params['startdate'];
            $end=$params['enddate'];
            $sortby=$params['sortby'];
            $filterclient = '';
            
            if(isset($params['client'])){
                if($params['client'] != ''){
                    $filterclient = "and client.client = '".$params['client']."'";
                }else{
                    $filterclient = '';    
                }//end if 
            }else{
                $filterclient = '';
            }


            switch($isposted)
            {
                case 'unposted':{
                    switch($params['salesreporttype']){
                        case'report':{
                            $query="
                                select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.barcode = stock.barcode
                                where head.doc='SJ' 
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'sales' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.barcode = stock.barcode
                                where head.doc='SJ' 
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                                left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.barcode = stock.barcode
                                where head.doc='SJ' 
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order by $sortby";
                            break;
                        }
                        case'lessreturn':{
                            $query="
                                select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                               left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)
                               left join cntnum on cntnum.trno=head.trno
                               left join item on item.barcode = stock.barcode
                               where head.doc in ('sj','cm') 
                               and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                               and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                               left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)
                               left join cntnum on cntnum.trno=head.trno
                               left join item on item.barcode = stock.barcode
                               where head.doc in ('sj','cm') 
                               and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                               and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                               left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)
                               left join cntnum on cntnum.trno=head.trno
                               left join item on item.barcode = stock.barcode
                               where head.doc in ('sj','cm') 
                               and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                               and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               order by $sortby";
                            break;
                        }
                        case 'return':{
                            $query="
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lahead as head left join lastock as stock on stock.trno=head.trno)
                          left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)
                          left join cntnum on cntnum.trno=head.trno
                          left join item on item.barcode = stock.barcode
                          where head.doc='cm' 
                          and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                          and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                          left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)
                          left join cntnum on cntnum.trno=head.trno
                          left join item on item.barcode = stock.barcode
                          where head.doc='cm' 
                          and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                          and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lchead as head left join lcstock as stock on stock.trno=head.trno)
                          left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)
                          left join cntnum on cntnum.trno=head.trno
                          left join item on item.barcode = stock.barcode
                          where head.doc='cm' 
                          and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                          and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          order by $sortby";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($params['salesreporttype']){
                        case'report':{
                             $query="
                            select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.itemid = stock.itemid
                                where head.doc='sj' 
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                                union all
                            select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.itemid = stock.itemid
                                where head.doc='sj' 
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                            order  by $sortby";
                            break;
                        }
                        case'lessreturn':{
                             $query="
                               select head.doc,'sales' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.itemid = stock.itemid
                                where head.doc in ('sj','cm') 
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                union all
                                select head.doc,'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                                left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)
                                left join cntnum on cntnum.trno=head.trno
                                left join item on item.itemid = stock.itemid
                                where head.doc in ('sj','cm') 
                                and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                                and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                order by $sortby";
                            break;
                        }
                        case'return':{
                             $query="
                             select 'sales return' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((glhead as head left join glstock as stock on stock.trno=head.trno)
                              left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)
                              left join cntnum on cntnum.trno=head.trno
                              left join item on item.itemid = stock.itemid
                              where head.doc='cm' 
                              and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                              and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              union all
                              select 'sales return' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                              left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)
                              left join cntnum on cntnum.trno=head.trno
                              left join item on item.itemid = stock.itemid
                              where head.doc='cm' 
                              and item.barcode not in ('cashbond','penalty','renewalfee','adfee','royaltyfee','franchisefee')
                              and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              order by $sortby";
                            break;
                        }
                        break;
                        }
                   
                    break;
                }
            }
           // echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }//END INFINITEA

    public static function rptSales_Reports($params,$center)/*RMG*/{
            $reporttype=$params['salesreporttype'];
            $isposted=$params['poststatus'];
            $start=$params['startdate'];
            $end=$params['enddate'];
            $sortby=$params['sortby'];
            $filterclient = '';
            
            if(isset($params['client'])){
                if($params['client'] != ''){
                    $filterclient = "and client.client = '".$params['client']."'";
                }else{
                    $filterclient = '';    
                }//end if 
            }else{
                $filterclient = '';
            }


            switch($isposted)
            {
                case 'unposted':{
                    switch($params['salesreporttype']){
                        case'report':{
                            $query="
                                select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='SJ'  and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'sales' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='SJ' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='SJ' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order by $sortby";
                            break;
                        }
                        case'lessreturn':{
                            $query="
                                select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               order by $sortby";
                            break;
                        }
                        case 'return':{
                            $query="
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          order by $sortby";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($params['salesreporttype']){
                        case'report':{
                             $query="
                            select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                                union all
                            select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                            order  by $sortby";
                            break;
                        }
                        case'lessreturn':{
                             $query="
                               select head.doc,'sales' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                union all
                                select head.doc,'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                order by $sortby";
                            break;
                        }
                        case'return':{
                             $query="
                             select 'sales return' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              union all
                              select 'sales return' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filterclient
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              order by $sortby";
                            break;
                        }
                        break;
                        }
                   
                    break;
                }
            }
           // echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
   public static function rptSales_Reportsyulick($params,$center)/*RMG*/{
            $reporttype=$params['salesreporttype'];
            $isposted=$params['poststatus'];
            $start=$params['startdate'];
            $end=$params['enddate'];
            $sortby=$params['sortby'];
            $cgrp= $params['cgrp'];
            $compref=$params['companypref'];

            if ($cgrp == ''){
                if ($compref == ''){
                    $filterz = '';   
                } else {
                $filterz = 'and cntnum.bref in (select availprefs from company_prefixes where companyname = "'.$compref.'")' ;  
                }
            } else {
                $filterz = 'and cntnum.bref in (select availprefs from company_prefixes where cgrp="'.$cgrp.'"';
                if ($compref != ''){
                 $filterz = $filterz.' and companyname = "'.$compref.'"';
                }
                $filterz = $filterz. ')';
            }

            $filter="";
            
            if($params['client']!=""){
            $filter =" and client.client='".$params['client']."'";
            }

            switch($isposted)
            {
                case 'unposted':{
                    switch($params['salesreporttype']){
                        case'report':{
                            $query="
                                select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='SJ'  and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                $filterz $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'sales' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,head.yourref,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='SJ' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                $filterz $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='SJ' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                $filterz $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order by clientname,dateid,$sortby";
                            break;
                        }
                        case'lessreturn':{
                            $query="
                                select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               $filterz $filter
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               $filterz $filter
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               $filterz $filter
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               order by clientname,dateid,$sortby";
                            break;
                        }
                        case 'return':{
                            $query="
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          $filterz $filter
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          $filterz $filter
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          $filterz $filter
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          order by clientname,dateid,$sortby";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($params['salesreporttype']){
                        case'report':{
                             $query="
                            select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                $filterz $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                                union all
                            select 'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                $filterz $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                            order  by clientname,dateid,$sortby";
                            break;
                        }
                        case'lessreturn':{
                             $query="
                               select head.doc,'sales' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,head.yourref,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                $filterz $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                union all
                                select head.doc,'sales' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,head.yourref,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                $filterz $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                order by clientname,dateid,$sortby";
                            break;
                        }
                        case'return':{
                             $query="
                             select 'sales return' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,head.yourref,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                              $filterz $filter
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              union all
                              select 'sales return' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,head.yourref,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                              $filterz $filter
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              order by clientname,dateid,$sortby";
                            break;
                        }
                        break;
                        }
                   
                    break;
                }
            }
           //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptpending_Salesorder($params,$center) /* kevin */ {

            $transtype=$params['transtype'];

            $filter="";
            
            if($params['client']!=""){
            $filter =" and client.client='".$params['client']."'";
            }
            if($params['item']!=""){
            $filter =" and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter =" and item.groupid='".$params['group']."'";
            }
            if($params['brand']!=""){
            $filter =" and item.brand='".$params['brand']."'";
            }
            if($params['class']!=""){
            $filter =" and item.class='".$params['class']."'";
            }
                        $result=Yii::$app->sbccommon->opentable("
                        select client.clientname as cgrp, concat(item.groupid,' ',item.brand,' ',item.itemname) as igrp, head.docno,
                        client.clientname, item.itemname, item.groupid, item.brand, item.class, date(head.dateid) as dateid, stock.qa,
                        stock.iss as qty, (stock.iss-stock.qa) as unserved, item.uom,head.ourref,head.yourref
                        from ((sohead as head left join sostock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode)left join client on client.client=head.client
                        left join transnum on transnum.trno=head.trno
                        where stock.void=0 and (stock.iss-stock.qa)>0 $filter
                        and transnum.center='$center'
                        union all
                        select client.clientname as cgrp, concat(item.groupid,' ',item.brand,' ',item.itemname) as igrp, head.docno,
                        client.clientname, item.itemname, item.groupid, item.brand, item.class, date(head.dateid) as dateid, stock.qa,
                        stock.iss as qty, (stock.iss-stock.qa) as unserved, item.uom,head.ourref,head.yourref
                        from ((hsohead as head left join hsostock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode)left join client on client.client=head.client
                        left join transnum on transnum.trno=head.trno
                        where stock.void=0 and (stock.iss-stock.qa)>0 $filter
                        and transnum.center='$center'
                        order by cgrp, igrp, docno"); 
            
            return $result;
        }

    public static function rptpending_Salesorderyulick($params,$center) /* kevin */ {

            $start=$params['start'];
            $end=$params['end'];
            $transtype=$params['transtype'];

            $filter="";
            
            if($params['client']!=""){
            $filter =" and client.client='".$params['client']."'";
            }
            if($params['item']!=""){
            $filter =" and item.barcode='".$params['item']."'";
            }
            if($params['group']!=""){
            $filter =" and item.groupid='".$params['group']."'";
            }
            if($params['brand']!=""){
            $filter =" and item.brand='".$params['brand']."'";
            }
            if($params['class']!=""){
            $filter =" and item.class='".$params['class']."'";
            }
                        $query="
                        select client.client,client.clientname as cgrp, concat(item.groupid,' ',item.brand,' ',item.itemname) as igrp, head.docno,
                        client.clientname, item.itemname, item.groupid, item.brand, item.class, date(head.dateid) as dateid, stock.qa,
                        stock.iss as qty, (stock.iss-stock.qa) as unserved, item.uom,head.ourref,head.yourref,stock.isamt
                        from ((sohead as head left join sostock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode)left join client on client.client=head.client
                        left join transnum on transnum.trno=head.trno
                        where stock.void=0 and (stock.iss-stock.qa)>0 and head.dateid between '$start' and '$end' $filter
                        and transnum.center='$center'
                        union all
                        select client.client,client.clientname as cgrp, concat(item.groupid,' ',item.brand,' ',item.itemname) as igrp, head.docno,
                        client.clientname, item.itemname, item.groupid, item.brand, item.class, date(head.dateid) as dateid, stock.qa,
                        stock.iss as qty, (stock.iss-stock.qa) as unserved, item.uom,head.ourref,head.yourref,stock.isamt
                        from ((hsohead as head left join hsostock as stock on stock.trno=head.trno)
                        left join item on item.barcode=stock.barcode)left join client on client.client=head.client
                        left join transnum on transnum.trno=head.trno
                        where stock.void=0 and (stock.iss-stock.qa)>0 and head.dateid between '$start' and '$end' $filter
                        and transnum.center='$center'
                        order by yourref,ourref,cgrp, igrp, docno"; 
            
            //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }        
    public static function rptSales_Reportssummary($params,$center)/*RMG*/{
            $reporttype=$params[24]=="report"? "REPORT" : "LESS REPORT";
            $isposted=isset($params[0])? $params[0] : "";
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            $sortby=isset($params[25]) && strlen($params[25])!=0? $params[25] : "";
            switch($isposted)
            {
                case 'unposted':{
                    switch($params[24]){
                        case'report':{
                            $query="
                                select dateid, sum(case when center='001' then amt else 0 end) as mainoffice, sum(case when center='002' then amt else 0 end) as smbaguio,
                                sum(case when center='003' then amt else 0 end) as smbicutan, sum(case when center='004' then amt else 0 end) as smcebu,
                                sum(case when center='005' then amt else 0 end) as smclark, sum(case when center='006' then amt else 0 end) as smcalamba,
                                sum(case when center='007' then amt else 0 end) as smdasma, sum(case when center='008' then amt else 0 end) as cmfairview,
                                sum(case when center='009' then amt else 0 end) as smmoa, sum(case when center='010' then amt else 0 end) as smmanila,
                                sum(case when center='011' then amt else 0 end) as smmega, sum(case when center='012' then amt else 0 end) as smnorth,
                                sum(case when center='013' then amt else 0 end) as smpampanga, sum(case when center='014' then amt else 0 end) as smlazaro,
                                sum(case when center='015' then amt else 0 end) as smsouth, sum(case when center='016' then amt else 0 end) as smstamesa,
                                sum(case when center='017' then amt else 0 end) as smtarlac, sum(case when center='018' then amt else 0 end) as smtaytay,
                                sum(case when center='019' then amt else 0 end) as virramal, sum(case when center='020' then amt else 0 end) as smdavao
                                from (select head.dateid, client.clientname, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname
                                union all
                                select head.dateid, client.clientname, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname
                                union all
                                select head.dateid, client.clientname, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname) as xx
                                group by dateid
                            ";
                            break;
                        }
                        case'lessreturn':{
                            $query="
                                select head.doc,'sales less return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                               (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                               (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               union all
                               select head.doc,'sales less return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                               (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                               client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                               sum(case when head.doc='sj' then stock.ext else (stock.ext*-1) end) as amount
                               from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                               left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                               where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                               group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                               order by $sortby
                            ";
                            break;
                        }
                        case 'return':{
                            $query="
                          select 'sales return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                          (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                          (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          union all
                          select 'sales return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                          (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                          client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                          from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                          left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                          where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                          order by $sortby


;
                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($params[24]){
                        case'report':{
                             $query="
                                select dateid, sum(case when center='001' then amt else 0 end) as mainoffice, sum(case when center='002' then amt else 0 end) as smbaguio,
                                sum(case when center='003' then amt else 0 end) as smbicutan, sum(case when center='004' then amt else 0 end) as smcebu,
                                sum(case when center='005' then amt else 0 end) as smclark, sum(case when center='006' then amt else 0 end) as smcalamba,
                                sum(case when center='007' then amt else 0 end) as smdasma, sum(case when center='008' then amt else 0 end) as cmfairview,
                                sum(case when center='009' then amt else 0 end) as smmoa, sum(case when center='010' then amt else 0 end) as smmanila,
                                sum(case when center='011' then amt else 0 end) as smmega, sum(case when center='012' then amt else 0 end) as smnorth,
                                sum(case when center='013' then amt else 0 end) as smpampanga, sum(case when center='014' then amt else 0 end) as smlazaro,
                                sum(case when center='015' then amt else 0 end) as smsouth, sum(case when center='016' then amt else 0 end) as smstamesa,
                                sum(case when center='017' then amt else 0 end) as smtarlac, sum(case when center='018' then amt else 0 end) as smtaytay,
                                sum(case when center='019' then amt else 0 end) as virramal, sum(case when center='020' then amt else 0 end) as smdavao
                                from (select head.dateid, client.clientname, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid, client.clientname, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center) as xx
                                group by dateid
                        ";
                            break;
                        }
                        case'lessreturn':{
                             $query="
                               select head.doc,'sales' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                                (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                union all
                                select head.doc,'sales' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                                (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent,
                                sum(case when head.doc='sj' then (stock.ext) else (stock.ext)*-1 end) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('sj','cm') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname,head.doc
                                order by $sortby

                        ";
                            break;
                        }
                        case'return':{
                             $query="
                             select 'sales return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                              (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              union all
                              select 'sales return' as type, 'u' as tr, (case when '$params[25]'='date' then date(head.dateid) else head.docno end) as sort1,
                              (case when '$params[25]'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                              from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='cm' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                              order by $sortby

                        ";
                            break;
                        }
                        break;
                        }
                   
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptcustomer_performancereport($params,$center) /* kevin */ {
            $start=$params['startdate'];
            $end=$params['enddate'];
            $result=Yii::$app->sbccommon->opentable("
                select client, clientname,sum(amount) as amount from (
                select 'sales' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                union all
                select 'sales' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname) as s
                group by client,clientname
                order  by clientname,client,clisum(s.amount) desc

            ");
            return $result;
    }

    public static function rptcustomer_paid($params,$center) /* kevin */ {
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            $result=Yii::$app->sbccommon->opentable("
                select * from arledger as detail
                left join glhead as head on head.trno = detail.trno
                where detail.bal = 0 and head.doc = 'SJ' and head.dateid between '$start' and '$end'
                order by head.dateid
            ");
            return $result;
    }
            
    public static function rptcustomer_performancereporttotal($params,$center) /* kevin */ {
            $start=$params['startdate'];
            $end=$params['enddate'];
            $result=Yii::$app->sbccommon->opentable("
                select sum(amount) as amount from (
                select 'sales' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname
                union all
                select 'sales' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, sum(stock.ext) as amount
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname) as s

            ");
            return $result;
        }

     public static function rptC_Salesperclass($params) /* ALA */ {
            $isdetailed=$params['reporttype'];
            $start=$params['startdate'];
            $end=$params['enddate'];
        
            $salestype='';

            if (strtoupper($params['salestype'])=='CASH'){
                $salestype = " and head.salestype ='CASH'";
            }else if(strtoupper($params['salestype'])=='CHARGE'){
                $salestype = " and head.salestype = 'CHARGE'";
            }else{
                $salestype = "";
            }

            $vattype ='';
            if (strtoupper($params['vat'])=='VAT'){
                $vattype = " and head.vattype = 'VATABLE' ";
            }else if(strtoupper($params['vat'])=='NVAT'){
                $vattype = " and head.vattype = 'NON-VATABLE' ";
            }else{
                $vattype = "";
            }
            
            $sortby = $params['arrangeby'];

            $client ='';
            $agent ='';
            $class ='';
            if ($params['client']!=''){
                $client =" and client.client = '".$params['client']."'";
            }
            if ($params['agent']!=''){
            $agent = " and agent.client = '".$params['agent']."'";
            }
            if ($params['class']!=''){
            $class = " and item.class = '".$params['class']."'";
            }

             switch($isdetailed){
                        case 'detailed':
                            $query="select sum(tons) as tons,docno,clientname,case ifnull(class,'') when '' then 'No Class' else class end as class,ifnull(barcode,'') as barcode,itemname,uom,sum(isqty) as isqty,sum(ext) as ext,isamt,kilos from (
                                select ((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,stock.isqty,uom.kilos,stock.isamt,stock.ext from lahead as head
                                left join lastock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                union all
                                select ((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,stock.isqty,uom.kilos,stock.isamt,stock.ext from lbhead as head
                                left join lbstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                union all
                                select ((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,stock.isqty,uom.kilos,stock.isamt,stock.ext from lchead as head
                                left join lcstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                union all
                                select ((stock.isqty * uom.kilos) / 1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,stock.isqty,uom.kilos,stock.isamt,stock.ext from glhead as head
                                left join glstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                union all
                                select ((stock.isqty * uom.kilos) / 1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,stock.isqty,uom.kilos,stock.isamt,stock.ext from hglhead as head
                                left join hglstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class) as a 
                                group by a.class,a.barcode
                                order by a.class,a.$sortby";
                            break;
                        case 'summarized':
                            $query="select sum(tons) as tons,docno,client,clientname,case ifnull(class,'') when '' then 'No Class' else class end as class,ifnull(barcode,'') as barcode,itemname,uom,sum(isqty) as isqty,sum(ext) as ext,isamt,kilos from (
                                select ((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,stock.isamt,stock.ext from lahead as head
                                left join lastock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                group by item.class,item.barcode
                                union all
                                select ((stock.isqty * uom.kilos) /  1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,stock.isamt,stock.ext from lbhead as head
                                left join lbstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                group by item.class,item.barcode
                                union all
                                select ((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,stock.isamt,stock.ext from lchead as head
                                left join lcstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                group by item.class,item.barcode
                                union all
                                select ((stock.isqty * uom.kilos) /  1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,stock.isamt,stock.ext from glhead as head
                                left join glstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                group by item.class,item.barcode
                                union all
                                select ((stock.isqty * uom.kilos)/ 1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uomby,sum(stock.isqty) as isqty,uom.kilos,stock.isamt,stock.ext from hglhead as head
                                left join hglstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class
                                group by item.class,item.barcode) as a 
                                group by a.class 
                                order by a.class,a.$sortby";
                            break;
                    }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }    



        public static function rptC_Salespercustomer($params) /* ALA */ {
            $start=$params['startdate'];
            $end=$params['enddate'];
            $isdetailed=$params['reporttype'];
            $salestype='';

            if (strtoupper($params['salestype'])=='CASH'){
                $salestype = " and head.salestype ='CASH'";
            }else if(strtoupper($params['salestype'])=='CHARGE'){
                $salestype = " and head.salestype = 'CHARGE'";
            }else{
                $salestype = "";
            }

            $vattype ='';
            if (strtoupper($params['vat'])=='VAT'){
                $vattype = " and head.vattype = 'VATABLE' ";
            }else if(strtoupper($params['vat'])=='NVAT'){
                $vattype = " and head.vattype = 'NON-VATABLE' ";
            }else{
                $vattype = " ";
            }

            $sortby = $params['arrangeby'];

            $client ='';
            $agent ='';
            $class='';
            $area='';
            if ($params['client']!=''){
                $client =" and client.client = '".$params['client']."'";
            }

            if ($params['agent']!=''){
            $agent = " and agent.client = '".$params['agent']."'";
            }

            if ($params['class']!=''){
            $class = " and item.class = '".$params['class']."'";
            }

            if ($params['area']!=''){
            $area = " and client.area = '".$params['area']."'";
            }


             switch($isdetailed){
                        case 'detailed':
                            $query="
                                select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,
                                head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt from lahead as head
                                left join lastock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area group by client.client,item.barcode,item.class
                                union all
                                select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt from lbhead as head
                                left join lbstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area group by client.client,item.barcode,item.class
                                union all
                                select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt from lchead as head
                                left join lcstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area group by client.client,item.barcode,item.class
                                union all 
                                select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt from glhead as head
                                left join glstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area group by client.client,item.barcode,item.class
                                union all 
                                select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt from hglhead as head
                                left join hglstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area group by client.client,item.barcode,item.class
                                order by clientname,$sortby
                                ";
                            break;
                        case 'summarized':
                            $query="
                                select sum(stock.ext) as ext,sum((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from lahead as head
                                left join lastock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from lbhead as head
                                left join lbstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.isqty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from lchead as head
                                left join lcstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.isqty * uom.kilos) / 1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from glhead as head
                                left join glstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.isqty * uom.kilos) / 1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.isqty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from hglhead as head
                                left join hglstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='sj' and head.dateid between '$start' and '$end' $salestype $vattype $client $agent $class $area
                                group by client.client
                                order by $sortby
                                 ";
                            break;
                    }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }


        
        public static function rptC_Purchasepersupplier($params) /* ALA */ {
            $isdetailed=$params['reporttype'];
            $start=$params['startdate'];
            $end=$params['enddate'];
        
            $vattype ='';
            if (strtoupper($params['vat'])=='VAT'){
                $vattype = " and head.vattype = 'VATABLE' ";
            }else if(strtoupper($params['vat'])=='NVAT'){
                $vattype = " and head.vattype = 'NON-VATABLE' ";
            }else{
                $vattype = " ";
            }

            $sortby = $params['arrangeby'];

            $client ='';
            $agent ='';
            $class='';
            $area='';
            if ($params['client']!=''){
                $client =" and client.client = '".$params['client']."'";
            }

            if ($params['class']!=''){
            $class = " and item.class = '".$params['class']."'";
            }


             // switch($isdetailed){
             //            case 'detailed':
             //                $query="
             //                    select ext,tons,address,docno,client,clientname,agent,agentname,dateid,
             //                    class,barcode,itemname,
             //                    uom,qty,kilos,area,rrcost
             //                from (
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,stock.qty,uom.kilos,client.area,stock.rrcost from lahead as head
             //                    left join lastock as stock on stock.trno = head.trno
             //                    left join client as client on client.client = head.client
             //                    left join client as agent on agent.client = head.agent
             //                    left join item on item.barcode = stock.barcode
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,stock.qty,uom.kilos,client.area,stock.rrcost from lbhead as head
             //                    left join lbstock as stock on stock.trno = head.trno
             //                    left join client as client on client.client = head.client
             //                    left join client as agent on agent.client = head.agent
             //                    left join item on item.barcode = stock.barcode
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,stock.qty,uom.kilos,client.area,stock.rrcost from lchead as head
             //                    left join lcstock as stock on stock.trno = head.trno
             //                    left join client as client on client.client = head.client
             //                    left join client as agent on agent.client = head.agent
             //                    left join item on item.barcode = stock.barcode
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,stock.qty,uom.kilos,client.area,stock.rrcost from glhead as head
             //                    left join glstock as stock on stock.trno = head.trno
             //                    left join client as client on client.clientid = head.clientid
             //                    left join client as agent on agent.clientid = head.agentid
             //                    left join item on item.itemid = stock.itemid
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,stock.qty,uom.kilos,client.area,stock.rrcost from hglhead as head
             //                    left join hglstock as stock on stock.trno = head.trno
             //                    left join client as client on client.clientid = head.clientid
             //                    left join client as agent on agent.clientid = head.agentid
             //                    left join item on item.itemid = stock.itemid
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    order by $sortby ) as tbl group by client
             //                    ";
             //                break;
             //            case 'summarized':
             //                $query="
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,head.address,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,sum(stock.rrcost) as rrcost from lahead as head
             //                    left join lastock as stock on stock.trno = head.trno
             //                    left join client as client on client.client = head.client
             //                    left join client as agent on agent.client = head.agent
             //                    left join item on item.barcode = stock.barcode
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    group by client.client
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,head.address,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,sum(stock.rrcost) as rrcost from lbhead as head
             //                    left join lbstock as stock on stock.trno = head.trno
             //                    left join client as client on client.client = head.client
             //                    left join client as agent on agent.client = head.agent
             //                    left join item on item.barcode = stock.barcode
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    group by client.client
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,head.address,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,sum(stock.rrcost) as rrcost from lchead as head
             //                    left join lcstock as stock on stock.trno = head.trno
             //                    left join client as client on client.client = head.client
             //                    left join client as agent on agent.client = head.agent
             //                    left join item on item.barcode = stock.barcode
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    group by client.client
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,head.address,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,sum(stock.rrcost) as rrcost from glhead as head
             //                    left join glstock as stock on stock.trno = head.trno
             //                    left join client as client on client.clientid = head.clientid
             //                    left join client as agent on agent.clientid = head.agentid
             //                    left join item on item.itemid = stock.itemid
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    group by client.client
             //                    union all
             //                    select stock.ext,((stock.isqty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,head.address,
             //                    item.class,item.barcode,item.itemname,
             //                    stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,sum(stock.rrcost) as rrcost from hglhead as head
             //                    left join hglstock as stock on stock.trno = head.trno
             //                    left join client as client on client.clientid = head.clientid
             //                    left join client as agent on agent.clientid = head.agentid
             //                    left join item on item.itemid = stock.itemid
             //                    left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
             //                    where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
             //                    group by client.client
             //                    order by clientname,$sortby
             //                     ";
             //                break;
             //        }

            switch($isdetailed){
                        case 'detailed':
                            $query="
                                select stock.ext,((stock.qty * uom.kilos) / 1000) as tons,
                                head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt from lahead as head
                                left join lastock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                 group by client.client,item.barcode,item.class
                                union all
                                select stock.ext,((stock.qty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt from lbhead as head
                                left join lbstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                 group by client.client,item.barcode,item.class
                                union all
                                select stock.ext,((stock.qty * uom.kilos) / 1000) as tons,head.address,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt from lchead as head
                                left join lcstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                 group by client.client,item.barcode,item.class
                                union all 
                                select stock.ext,((stock.qty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt from glhead as head
                                left join glstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                 group by client.client,item.barcode,item.class
                                union all 
                                select stock.ext,((stock.qty * uom.kilos) / 1000) as tons,head.address,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                case ifnull(item.class,'') when '' then 'No Class' else item.class end as class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt from hglhead as head
                                left join hglstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                 group by client.client,item.barcode,item.class
                                order by clientname,$sortby
                                ";
                            break;
                        case 'summarized':
                            $query="
                                select sum(stock.ext) as ext,sum((stock.qty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from lahead as head
                                left join lastock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.qty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from lbhead as head
                                left join lbstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.qty * uom.kilos) / 1000) as tons,head.docno,head.client,head.clientname,head.agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from lchead as head
                                left join lcstock as stock on stock.trno = head.trno
                                left join client as client on client.client = head.client
                                left join client as agent on agent.client = head.agent
                                left join item on item.barcode = stock.barcode
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.qty * uom.kilos) / 1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from glhead as head
                                left join glstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                group by client.client
                                union all
                                select sum(stock.ext) as ext,sum((stock.qty * uom.kilos) / 1000) as tons,head.docno,client.client,client.clientname,agent.client as agent,agent.clientname as agentname,head.dateid,
                                item.class,item.barcode,item.itemname,
                                stock.uom,sum(stock.qty) as isqty,uom.kilos,client.area,stock.isamt,client.addr from hglhead as head
                                left join hglstock as stock on stock.trno = head.trno
                                left join client as client on client.clientid = head.clientid
                                left join client as agent on agent.clientid = head.agentid
                                left join item on item.itemid = stock.itemid
                                left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                                where head.doc ='rr' and head.dateid between '$start' and '$end' $vattype $client $class
                                group by client.client
                                order by $sortby
                                 ";
                            break;
                    }

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }      
        
    //SUPPLIER    
    public static function rptSupplier_List($params,$center)/*NINING*/{
        
        $filter="";
        if($params['area']!=""){
            $filter= " and area='".$params['area']."'";
        }

        if($params['province']!=""){
            $filter= " and province='".$params['province']."'";
        }

        if($params['region']!=""){
            $filter= " and region='".$params['region']."'";
        }

        $query="select client,clientname, province,region,area, addr, tel, tin from client where issupplier=1 and clientname<>'' $filter ";
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptCOutstandingSupplierpayables($params,$center) /* kevin */ {
            $isposted=$params['poststatus'];
            $isdetailed=$params['reporttype'];

            $filter="";
            if($params['client']!=""){
                $filter= " and client.client='".$params['client']."'";
            }

            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case'detailed':{
                            $query="
                                select 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lahead as head left join ladetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                union all
                                select 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                union all
                                select 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                order by clientname,dateid, docno

                            ";
                            break;
                        }
                        case'summarized':{
                            $query="
                               select clientname, name, sum(balance) as balance from (
                                    select 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                    date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                    from (((lahead as head left join ladetail as detail on detail.trno=head.trno)
                                    left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                    left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                    and cntnum.center='$center' $filter
                                    union all
                                    select 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                    date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                    from (((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                                    left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                    left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                    and cntnum.center='$center' $filter
                                    union all
                                    select 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                    date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                    from (((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                                    left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                    left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                    and cntnum.center='$center' $filter
                             ) as x group by clientname, name order by clientname

                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($isdetailed){
                        case'detailed':{
                            $query="
                                select 'p' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(detail.dateid) as dateid, detail.docno, datediff(now(), detail.dateid) as elapse,
                                (case when detail.db>0 then (detail.bal*-1) else detail.bal end) as balance
                                from (apledger as detail left join client on client.clientid=detail.clientid)
                                left join cntnum on cntnum.trno=detail.trno where detail.bal<>0
                                and cntnum.center='$center' $filter
                                order by client.clientname, detail.dateid, detail.docno

                            ";
                            break;
                        }
                        case'summarized':{
                            $query="
                               select clientname, name, sum(balance) as balance from (
                                    select 'p' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                    date(detail.dateid) as dateid, detail.docno, datediff(now(), detail.dateid) as elapse,
                                    (case when detail.db>0 then (detail.bal*-1) else detail.bal end) as balance
                                    from (apledger as detail left join client on client.clientid=detail.clientid)
                                    left join cntnum on cntnum.trno=detail.trno where detail.bal<>0
                                    and cntnum.center='$center' $filter
                             ) as x group by clientname, name order by clientname

                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptCOutstandingSupplierpayablesaging($params,$center) /* kevin */ {
            $isposted=$params['poststatus'];
            $isdetailed=$params['reporttype'];
            
            $filter="";
            if($params['client']!=""){
                $filter= " and client.client='".$params['client']."'";
            }

            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case'detailed':{
                            $query="
                               select cntnum.center, 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lahead as head left join ladetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                union all
                                select cntnum.center, 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                union all
                                select cntnum.center, 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                order by clientname, dateid, docno

                            ";
                            break;
                        }
                        case'summarized':{
                            $query="
                                select clientname, name, elapse, sum(balance) as balance
                           from (select cntnum.center, 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lahead as head left join ladetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                union all
                                select cntnum.center, 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                                union all
                                select cntnum.center, 'u' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(head.dateid) as dateid, head.docno, datediff(now(), head.dateid) as elapse, detail.cr as balance
                                from (((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                                left join client on client.client=head.client)left join coa on coa.acno=detail.acno)
                                left join cntnum on cntnum.trno=head.trno where left(coa.alias,2)='ap'
                                and cntnum.center='$center' $filter
                            ) as x group by clientname, name, elapse
                            order by clientname, name

                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($isdetailed){
                        case'detailed':{
                            $query="
                            select 'p' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                date(detail.dateid) as dateid, detail.docno, datediff(now(), detail.dateid) as elapse,
                                (case when detail.db>0 then (detail.bal*-1) else detail.bal end) as balance
                                from (apledger as detail left join client on client.clientid=detail.clientid)
                                left join cntnum on cntnum.trno=detail.trno where detail.bal<>0
                                and cntnum.center='$center' $filter
                                order by client.clientname, detail.dateid, detail.docno
                            ";
                            break;
                        }
                        case'summarized':{
                            $query="
                                    select clientname, name, sum(balance) as balance, elapse from (
                                    select 'p' as tr, client.clientname, ifnull(client.clientname,'no name') as name,
                                    date(detail.dateid) as dateid, detail.docno, datediff(now(), detail.dateid) as elapse,
                                    (case when detail.db>0 then (detail.bal*-1) else detail.bal end) as balance
                                    from (apledger as detail left join client on client.clientid=detail.clientid)
                                    left join cntnum on cntnum.trno=detail.trno where detail.bal<>0
                                    and cntnum.center='$center' $filter
                                    ) as x group by clientname, name, elapse order by clientname

                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptAnalyzesupplierpurchasesmonthly($params,$center) /* kevin */ {
            $isposted=$params['poststatus'];
            $year=$params['year'];

            $filter="";
            if($params['client']!=""){
                $filter= " and client.client='".$params['client']."'";
            }
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                        sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                        sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                        select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                        from ((lahead as head left join lastock as stock on stock.trno=head.trno)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                        where head.doc='rr' and year(head.dateid)=$year and cntnum.center='$center' $filter  and stock.ext<>0
                        group by ifnull(client.clientname,''), year(head.dateid)
                        union all
                        select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                        from ((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                        where head.doc='rr' and year(head.dateid)=$year and cntnum.center='$center' $filter and stock.ext<>0
                        group by ifnull(client.clientname,''), year(head.dateid)
                        union all
                        select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                        from ((lchead as head left join lcstock as stock on stock.trno=head.trno)
                        left join client on client.client=head.client)left join cntnum on cntnum.trno=head.trno
                        where head.doc='rr' and year(head.dateid)=$year and cntnum.center='$center' $filter and stock.ext<>0
                        group by ifnull(client.clientname,''), year(head.dateid)
                        ) as x group by clientname, yr order by clientname, yr
                        ";
                    break;
                }
                case 'posted':{
                    $query="
                        select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                        sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                        sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                        select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                        from ((glhead as head left join glstock as stock on stock.trno=head.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno
                        where head.doc='rr' and year(head.dateid)=$year and cntnum.center='$center' $filter and stock.ext<>0
                        group by ifnull(client.clientname,''), year(head.dateid)
                        union all
                        select 'p' as tr, ifnull(client.clientname,'') as clientname, year(head.dateid) as yr,
                        sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                        sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                        sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                        sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                        sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                        sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                        sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                        sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                        sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                        sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                        sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                        sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                        from ((hglhead as head left join hglstock as stock on stock.trno=head.trno)
                        left join client on client.clientid=head.clientid)left join cntnum on cntnum.trno=head.trno
                        where head.doc='rr' and year(head.dateid)=$year and cntnum.center='$center' $filter and stock.ext<>0
                        group by ifnull(client.clientname,''), year(head.dateid)
                        ) as x group by clientname, yr order by clientname, yr
                        ";
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptPurchase_Reports($params,$center) /*JR*/ {
            $reporttype=$params['purchasereporttype'];
            $isposted=$params['poststatus'];
            $start=$params['startdate'];
            $end=$params['enddate'];
            $sortby=$params['sortby'];

             $filter="";
            if($params['client']!=""){
                $filter= " and client.client='".$params['client']."'";
            }

            switch($isposted)
            {
                case 'unposted':{
                    switch($params['purchasereporttype']){
                        case'report':{
                            $query="
                                select 'purchases' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchases' as type, 'u' as tr,  date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchases' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order by $sortby ";
                            break;
                        }
                        case'lessreturn':{
                            $query="
                                select 'purchase less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, 
                                sum(case when head.doc='rr' then (stock.ext) else (stock.ext*-1) end) as amount
                                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('rr','dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchase less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref,
                                sum(case when head.doc='rr' then (stock.ext) else (stock.ext*-1) end) as amount
                                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('rr','dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchase less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref,
                                sum(case when head.doc='rr' then (stock.ext) else (stock.ext*-1) end) as amount
                                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('rr','dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order by $sortby";
                            break;
                        }
                        case 'return':{
                            $query="
                                select 'purchase return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchase return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchase return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join client on client.client=head.client)
                                left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order by $sortby";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($params['purchasereporttype']){
                        case'report':{
                             $query="
                                
                                select 'purchases' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchases' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order  by $sortby";
                            break;
                        }
                        case'lessreturn':{
                             $query="
                                select 'purchase less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref,
                                sum(case when head.doc='rr' then (stock.ext) else (stock.ext*-1) end) as amount
                                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('rr','dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                union all
                                select 'purchase less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref,
                                sum(case when head.doc='rr' then (stock.ext) else (stock.ext*-1) end) as amount
                                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                                where head.doc in ('rr','dm') and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                                order by $sortby";
                            break;
                        }
                        case'return':{
                             $query="
                              select 'purchase return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                              from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='dm' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                              union all
                              select 'sales less return' as type, 'u' as tr, date(head.dateid) as dateid, head.docno,
                              client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                              from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='dm' and head.dateid between '$start' and '$end' and cntnum.center='$center' $filter
                              group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                              order by $sortby";
                            break;
                        }
                        break;
                        }

                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }    
    public static function rptPending_Purchaseorder($params,$center) /* kevin */ {

        $filter="";
        if($params['client']!=""){
        $filter=" and client.client='".$params['client']."'";
        }
        if($params['item']!=""){
        $filter=" and item.barcode='".$params['item']."'";
        }
        if($params['group']!=""){
        $filter=" and item.groupid='".$params['group']."'";
        }
        if($params['brand']!=""){
        $filter=" and item.brand='".$params['brand']."'";
        }
        if($params['class']!=""){
        $filter=" and item.class='".$params['class']."'";
        }    

            $query="
            select client.clientname as cgrp, concat(item.groupid,' ',item.brand,' ',item.itemname) as igrp,
            head.docno, date(head.dateid) as dateid , client.clientname, item.itemname, item.groupid, item.brand, item.class,
            stock.qty as qty, (stock.qty-stock.qa) as unserved, item.uom,stock.qa
            from ((pohead as head left join postock as stock on stock.trno=head.trno)
            left join item on item.barcode=stock.barcode)left join client on client.client=head.client
            left join transnum on transnum.trno=head.trno
            where stock.void=0 and (stock.qty-stock.qa)>0 and transnum.center='$center' $filter
            union all
            select client.clientname as cgrp, concat(item.groupid,' ',item.brand,' ',item.itemname) as igrp,
            head.docno, date(head.dateid) as dateid, client.clientname, item.itemname, item.groupid, item.brand, item.class,
            stock.qty as qty, (stock.qty-stock.qa) as unserved, item.uom,stock.qa
            from ((hpohead as head left join hpostock as stock on stock.trno=head.trno)
            left join item on item.barcode=stock.barcode)left join client on client.client=head.client
            left join transnum on transnum.trno=head.trno
            where stock.void=0 and (stock.qty-stock.qa)>0 and transnum.center='$center' $filter ";
                    
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptBackrder_Report($params,$center) /* kevin */ {
            $start=$params['startdate'];
            $end=$params['enddate'];
            $supplier="";
            if ($params['client']!= ""){
             $supplier="ALL";   
            }
            if ($supplier=="ALL"){
                $sup='';
            } else {
                $sup=" and client.client='$supplier'";
            }
             $result=Yii::$app->sbccommon->opentable("
                    select clientname,client,docno,date(dateid) as dateid,barcode,itemname,sum(qty) as oqty,sum(pending) as pending from(
                    select client.clientname,client.client,pohead.docno,pohead.dateid,postock.barcode,
                    postock.itemname,postock.qty ,postock.qty - postock.qa as pending from pohead
                    left join postock on postock.trno = pohead.trno left join client on client.client = pohead.client
                    where pohead.dateid between '$start' and '$end' $sup
                    union all
                    select client.clientname,client.client,hpohead.docno,hpohead.dateid,hpostock.barcode,hpostock.itemname,
                    hpostock.qty,hpostock.qty - hpostock.qa as pending from hpohead
                    left join hpostock on hpostock.trno = hpohead.trno
                    left join client on client.client = hpohead.client
                    where hpohead.dateid between '$start' and '$end' $sup
                    ) as newtable  where pending > 0
                    group by docno,dateid,barcode,itemname
            ");
            return $result;
    }  
    public static function rptsupplier_performancereport($params,$center) /* kevin */ {

            $start=$params['startdate'];
            $end=$params['enddate'];

            $result=Yii::$app->sbccommon->opentable("
                select client, clientname,sum(amount) as amount from (
                select 'purchases' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                union all
                select 'purchases' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref) as s
                group by client,clientname
                order  by sum(S.amount) desc");
            return $result;
    }
    public static function rptsupplier_performancereporttotal($params,$center) /* kevin */ {

            $start=$params['startdate'];
            $end=$params['enddate'];
            $result=Yii::$app->sbccommon->opentable("
                select sum(amount) as amount from (
                select 'purchases' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref
                union all
                select 'purchases' as type, 'u' as tr, (case when 'report'='date' then date(head.dateid) else head.docno end) as sort1,
                (case when 'report'='doc' then date(head.dateid) else head.docno end) as sort2, date(head.dateid) as dateid, head.docno,
                client.client, client.clientname, agent.client as agcode, agent.clientname as agent, head.yourref, sum(stock.ext) as amount
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join client on client.clientid=head.clientid)
                left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                where head.doc='rr' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                group by head.dateid, head.docno, client.client, client.clientname, agent.client, agent.clientname, head.yourref) as s");
            return $result;
    }
    public static function rptreceivingconsignment2($params,$center) /* kevin */ {
            
            $start=$params['startdate'];
            $end=$params['enddate'];
            $isposted=$params['poststatus'];
            $sortby=$params['sortby'];
            switch($isposted)
            {
                case 'unposted':{
                    $query="
                        select docno, dateid, client, clientname, yourref, ourref, sum(rrqty) as qty, sum(ext) as amount
                        from (select head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                              stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                              stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                              from lahead as head left join lastock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                              left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                              where head.doc='ca' and ifnull(stock.barcode,'')<>'' and stock.qty>0
                              and head.dateid between '$start' and '$end' and cntnum.center='$center'
                              union all
                              select head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                              stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                              stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                              from lbhead as head left join lbstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                              left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                              where head.doc='ca' and ifnull(stock.barcode,'')<>'' and stock.qty>0
                              and head.dateid between '$start' and '$end' and cntnum.center='$center'
                              union all
                              select head.trno, head.doc, head.docno, head.dateid, head.client, head.clientname, head.yourref, head.ourref,
                              stock.line, stock.refx, stock.linex, stock.barcode, stock.itemname, stock.uom, stock.wh as swh, stock.tstrno, stock.tsline,
                              stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                              from lchead as head left join lcstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                              left join client on client.client=head.client left join client as hwh on hwh.client=head.wh
                              where head.doc='ca' and ifnull(stock.barcode,'')<>'' and stock.qty>0
                              and head.dateid between '$start' and '$end' and cntnum.center='$center'
                        ) as xx
                        group by docno, dateid, client, clientname, yourref, ourref
                        order by $sortby, clientname";    
                    }
                    break;
                case 'posted':{
                    $query="
                    select docno, dateid, client, clientname, yourref, ourref, sum(rrqty) as qty, sum(ext) as amount
                    from (select head.trno, head.doc, head.docno, head.dateid, client.client, head.clientname, head.yourref, head.ourref,
                          stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                          stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                          from glhead as head left join glstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                          left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                          left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=head.whid
                          where head.doc='ca' and ifnull(item.barcode,'')<>'' and stock.qty>0
                          and head.dateid between '$start' and '$end' and cntnum.center='$center'
                          union all
                          select head.trno, head.doc, head.docno, head.dateid, client.client, head.clientname, head.yourref, head.ourref,
                          stock.line, stock.refx, stock.linex, item.barcode, stock.itemname, stock.uom, wh.client as swh, stock.tstrno, stock.tsline,
                          stock.rrcost, stock.cost, stock.rrqty, stock.qty, stock.isamt, stock.amt, stock.isqty, stock.iss, stock.ext
                          from hglhead as head left join hglstock as stock on stock.trno=head.trno left join cntnum on cntnum.trno=head.trno
                          left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                          left join client as wh on wh.clientid=stock.whid left join client as hwh on hwh.clientid=head.whid
                          where head.doc='ca' and ifnull(item.barcode,'')<>'' and stock.qty>0
                          and head.dateid between '$start' and '$end' and cntnum.center='$center'
                    ) as xx
                    group by docno, dateid, client, clientname, yourref, ourref
                    order by $sortby, clientname";
                    }
                    break;
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    } 
//JEAR 091916
    public static function rptPurchaseSumm($params,$center) /* kevin */ {
            
            $start=$params['startdate'];
            $end=$params['enddate'];

            $vattype ='';
            if (strtoupper($params['vattype'])=='VAT'){
                $vattype = " and head.vattype = 'VATABLE' ";
            }else if(strtoupper($params['vattype'])=='NVAT'){
                $vattype = " and head.vattype = 'NON-VATABLE' ";
            }else{
                $vattype = " ";
            }
                    $query="
                    select code,clientname,sum(ext) as total from(
                    select client.client as code,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
                    client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
                    from glstock as stock
                    left join glhead as head on head.trno=stock.trno
                    left join item on item.itemid=stock.itemid
                    left join cntnum on cntnum.trno=head.trno
                    left join client on client.clientid=head.clientid
                    where head.doc='RR' and head.dateid between '$start' and '$end' $vattype
                    union all
                    select client.client as code,head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
                    client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
                    from lastock as stock
                    left join lahead as head on head.trno=stock.trno
                    left join cntnum on cntnum.trno=head.trno
                    left join client on client.client=head.client
                    where head.doc='RR' and head.dateid between '$start' and '$end' $vattype
                    union all
                    select client.client as code,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
                    client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
                    from hglstock as stock
                    left join hglhead as head on head.trno=stock.trno
                    left join item on item.itemid=stock.itemid
                    left join cntnum on cntnum.trno=head.trno
                    left join client on client.clientid=head.clientid
                    where head.doc='RR' and head.dateid between '$start' and '$end' $vattype
                    ) as tbl group by clientname,code";

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    } 


    public static function rptpurchase_reportbybrand($params,$center) /* kevin */ {
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            $brand=isset($params[10]) && strlen($params[10])!=0? $params[10] : "ALL";
            
            if ($brand=="ALL"){
                $br="";
            } else {
                $br="and item.brand='$brand'";
            }
            
            $query="
                    select  date,docno,reference,brand,supplier,sum(amount) as amount from (
                    select head.dateid as date,docno,head.yourref as reference,item.brand,head.clientname as supplier,stock.ext as amount
                    From lahead as head left join lastock as stock on stock.trno = head.trno
                    left join item on item.barcode = stock.barcode
                    where doc = 'RR' and head.dateid between '$start' and '$end'
                    union all
                    select head.dateid as date,docno,head.yourref as reference,item.brand,head.clientname as supplier,stock.ext as amount
                    From lbhead as head left join lbstock as stock on stock.trno = head.trno left join item on item.barcode = stock.barcode
                    where doc = 'RR' and head.dateid between '$start' and '$end'
                    union all
                    select head.dateid as date,docno,head.yourref as reference,item.brand,head.clientname as supplier,stock.ext as amount
                    From lchead as head left join lcstock as stock on stock.trno = head.trno left join item on item.barcode = stock.barcode
                    where doc = 'RR' and head.dateid between '$start' and '$end'
                    union all
                    select head.dateid as date,docno,head.yourref as reference,item.brand,head.clientname as supplier,stock.ext as amount
                    From glhead as head left join glstock as stock on stock.trno = head.trno
                    left join item on item.itemid = stock.itemid
                    where doc = 'RR' and head.dateid between '$start' and '$end' $br order by brand) as newtable group by docno
                    order by brand
            ";
            //echo $query;
            return $result=Yii::$app->sbccommon->opentable($query);
    }

    public static function rpt_SalesReportrttrading($params)/*jac*/
    {
            $start=$params['startdate'];
            $end=$params['enddate'];

            $salestype='';

            if (strtoupper($params['salestype'])=='CASH'){
                $salestype = " and head.salestype ='CASH'";
            }else if(strtoupper($params['salestype'])=='CHARGE'){
                $salestype = " and head.salestype = 'CHARGE'";
            }else{
                $salestype = "";
            }

            $vattype ='';
            if (strtoupper($params['vattype'])=='VAT'){
                $vattype = " and head.vattype = 'VATABLE' ";
            }else if(strtoupper($params['vattype'])=='NVAT'){
                $vattype = " and head.vattype = 'NON-VATABLE' ";
            }else{
                $vattype = " ";
            }

            $sortby = $params['sortby'];

            $client ='';
            $agent ='';
            if ($params['client']!=''){
                $client =" and client.client = '".$params['client']."'";
            }

            if ($params['agent']!=''){
            $agent = " and agent.client = '".$params['agent']."'";
            }
                      
            $sql = "select head.docno,head.dateid,head.yourref,head.ourref,client.client,client.clientname,
                agent.client as agcode,agent.clientname as agentname,sum(stock.ext) as tamt,head.rem,cntnum.postdate,head.vattype
                from lahead as head left join lastock as stock on head.trno = stock.trno
                left join client on client.client = head.client
                left join client as agent on agent.client = head.agent
                left join cntnum on cntnum.trno = head.trno
                where cntnum.doc ='SJ'  and head.dateid between '".$start."' and '".$end."' 
                $salestype $vattype $client $agent 
                group by head.docno,client.client
                union all
                select head.docno,head.dateid,head.yourref,head.ourref,client.client,client.clientname,
                agent.client as agcode,agent.clientname as agentname,sum(stock.ext) as tamt,head.rem,cntnum.postdate,head.vattype
                from lbhead as head left join lbstock as stock on head.trno = stock.trno
                left join client on client.client = head.client
                left join client as agent on agent.client = head.agent
                left join cntnum on cntnum.trno = head.trno
                where cntnum.doc ='SJ' and head.dateid between '".$start."' and '".$end."' $salestype $vattype $client $agent
                group by head.docno,client.client
                union all
                select head.docno,head.dateid,head.yourref,head.ourref,client.client,client.clientname,
                agent.client as agcode,agent.clientname as agentname,sum(stock.ext) as tamt,head.rem,cntnum.postdate,head.vattype
                from lchead as head left join lcstock as stock on head.trno = stock.trno
                left join client on client.client = head.client
                left join client as agent on agent.client = head.agent
                left join cntnum on cntnum.trno = head.trno
                where cntnum.doc ='SJ'  and head.dateid between '".$start."' and '".$end."' $salestype $vattype $client $agent
                group by head.docno,client.client
                union all
                select head.docno,head.dateid,head.yourref,head.ourref,client.client,client.clientname,
                agent.client as agcode,agent.clientname as agentname,sum(stock.ext) as tamt,head.rem,cntnum.postdate,head.vattype
                from glhead as head left join glstock as stock on head.trno = stock.trno
                left join client on client.clientid = head.clientid
                left join client as agent on agent.clientid = head.agentid
                left join cntnum on cntnum.trno = head.trno
                where cntnum.doc ='SJ' and head.dateid between '".$start."' and '".$end."' $salestype $vattype $client $agent
                group by head.docno,client.client
                union all
                select head.docno,head.dateid,head.yourref,head.ourref,client.client,client.clientname,
                agent.client as agcode,agent.clientname as agentname,sum(stock.ext) as tamt,head.rem,cntnum.postdate,head.vattype
                from hglhead as head left join hglstock as stock on head.trno = stock.trno
                left join client on client.clientid = head.clientid
                left join client as agent on agent.clientid = head.agentid
                left join cntnum on cntnum.trno = head.trno
                where cntnum.doc ='SJ'  and head.dateid between '".$start."' and '".$end."' $salestype $vattype $client $agent
                group by head.docno,client.client
                order by $sortby";
            
            $result=Yii::$app->sbccommon->opentable($sql);
            return $result;

    }/*end jac*/
        
    //AGENT
    public static function rptSales_Agentlist($params,$center) /*FRED*/ {
        
        $filter="";
        if($params['area']!=""){
            $filter= " and area='".$params['area']."'";
        }

        if($params['province']!=""){
            $filter= " and province='".$params['province']."'";
        }

        if($params['region']!=""){
            $filter= " and region='".$params['region']."'";
        }

        $query="select client,clientname, province,region,area, addr, tel, tin from client where isagent=1 and clientname<>'' $filter ";
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptAnalyze_agentsales($params,$center) /*FRED*/ {

        $isposted=$params['poststatus'];
        $year=$params['year'];
        switch($isposted) {
            case 'unposted': {
                    $query="
                            select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                            sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                            sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                            select 'u' as tr, ifnull(agent.clientname,'') as clientname, year(head.dateid) as yr,
                            sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                            sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                            sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                            sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                            sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                            sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                            sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                            sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                            sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                            sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                            sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                            sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                            from ((lahead as head left join lastock as stock on stock.trno=head.trno)
                            left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                            and stock.ext<>0
                            group by ifnull(agent.clientname,''), year(head.dateid)
                            union all
                            select 'u' as tr, ifnull(agent.clientname,'') as clientname, year(head.dateid) as yr,
                            sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                            sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                            sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                            sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                            sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                            sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                            sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                            sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                            sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                            sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                            sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                            sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                            from ((lbhead as head left join lbstock as stock on stock.trno=head.trno)
                            left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                            and stock.ext<>0
                            group by ifnull(agent.clientname,''), year(head.dateid)
                            union all
                            select 'u' as tr, ifnull(agent.clientname,'') as clientname, year(head.dateid) as yr,
                            sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                            sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                            sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                            sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                            sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                            sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                            sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                            sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                            sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                            sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                            sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                            sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                            from ((lchead as head left join lcstock as stock on stock.trno=head.trno)
                            left join client as agent on agent.client=head.agent)left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                            and stock.ext<>0 group by ifnull(agent.clientname,''), year(head.dateid)
                            ) as x group by clientname, yr order by clientname, yr";
                    break;
                }
            case 'posted': {
                    $query="
                              select clientname, yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                              sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul,
                              sum(moaug) as moaug,
                              sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                              select 'p' as tr, ifnull(agent.clientname,'') as clientname, year(head.dateid) as yr,
                              sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                              sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                              sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                              sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                              sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                              sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                              sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                              sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                              sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                              sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                              sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                              sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                              from ((glhead as head left join glstock as stock on stock.trno=head.trno)
                              left join client as agent on agent.clientid=head.agentid)left join cntnum on cntnum.trno=head.trno
                              where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                              and stock.ext<>0
                              group by ifnull(agent.clientname,''), year(head.dateid)
                              union all
                              select 'p' as tr, ifnull(agent.clientname,'') as clientname, year(head.dateid) as yr,
                              sum(case when month(head.dateid)=1 then stock.ext else 0 end) as mojan,
                              sum(case when month(head.dateid)=2 then stock.ext else 0 end) as mofeb,
                              sum(case when month(head.dateid)=3 then stock.ext else 0 end) as momar,
                              sum(case when month(head.dateid)=4 then stock.ext else 0 end) as moapr,
                              sum(case when month(head.dateid)=5 then stock.ext else 0 end) as momay,
                              sum(case when month(head.dateid)=6 then stock.ext else 0 end) as mojun,
                              sum(case when month(head.dateid)=7 then stock.ext else 0 end) as mojul,
                              sum(case when month(head.dateid)=8 then stock.ext else 0 end) as moaug,
                              sum(case when month(head.dateid)=9 then stock.ext else 0 end) as mosep,
                              sum(case when month(head.dateid)=10 then stock.ext else 0 end) as mooct,
                              sum(case when month(head.dateid)=11 then stock.ext else 0 end) as monov,
                              sum(case when month(head.dateid)=12 then stock.ext else 0 end) as modec
                              from ((hglhead as head 
                              left join hglstock as stock on stock.trno=head.trno)
                              left join client as agent on agent.clientid=head.agentid)
                              left join cntnum on cntnum.trno=head.trno
                              where head.doc='sj' and year(head.dateid)=$year and cntnum.center='$center'
                              and stock.ext<>0 group by ifnull(agent.clientname,''), year(head.dateid)
                              ) as x group by clientname, yr order by clientname, yr";
                    break;
                }
        }
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }

    public static function rpttaxwheld($params) {
        $start=$params['start'];
        $end=$params['end'];

        $filter="";

        if($params['client']!=""){
            $filter=  " and head.client='".$params['client']."'";
            }

        $query = "select detail.line,head.trno,head.docno,head.client,head.clientname,head.dateid,head.dateid2,head.address,
                    detail.acno,detail.acnoname,detail.rate,detail.income,detail.wheld,client.tin
                    from taxhead as head
                    left join taxnum on taxnum.trno=head.trno
                    left join client on client.client=head.client
                    left join taxdetail as detail on detail.trno=head.trno
                    where head.dateid between '$start' and '$end' $filter
                    union all
                    select detail.line,head.trno,head.docno,head.client,head.clientname,head.dateid,head.dateid2,head.address,
                    detail.acno,detail.acnoname,detail.rate,detail.income,detail.wheld,client.tin
                    from htaxhead as head
                    left join taxnum on taxnum.trno=head.trno
                    left join client on client.client=head.client
                    left join htaxdetail as detail on detail.trno=head.trno
                    where head.dateid between '$start' and '$end' $filter
                    order by line";
                    $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    
    public static function rptSalesreportperstaff($params){ //jac
            $start=$params['startdate'];
            $end=$params['enddate'];

            $client ='';
            $agent ='';
            $group ='';
            
            if ($params['client']!=''){
                $client =" and c.client = '".$params['client']."'";
            }

            if ($params['agent']!=''){
            $agent = " and ag2.client = '".$params['agent']."'";
            }

            if ($params['group']!=''){
            $group = " and g.stockgrp_name = '".$params['group']."'";
            }
                      
            $sql = "select h.docno,date(h.dateid) as dateid,s.barcode,s.itemname,s.isqty,s.isamt,s.ext,g.stockgrp_name as grp, h.clientname,ifnull(ag.clientname,'') as staff,ifnull(ag2.clientname,'') as assistant
                from lahead as h left join lastock as s on s.trno=h.trno 
                left join item on item.barcode=s.barcode
                left join stockgrp_masterfile as g on g.stockgrp_id=item.groupid 
                left join client as ag on ag.client=s.agent
                left join client as ag2 on ag2.client=s.agent2
                left join client as c on c.client=h.client
                left join cntnum as num on num.trno = h.trno
                where h.doc='SJ' and h.dateid between '$start' and '$end' 
                and num.center = '".Yii::$app->session['loggeduser']['center']."' $client $agent $group
                union all
                select h.docno,date(h.dateid) as dateid ,item.barcode,s.itemname,s.isqty,s.isamt,s.ext,g.stockgrp_name as grp, h.clientname,ifnull(ag.clientname,'') as staff,ifnull(ag2.clientname,'') as assistant
                from glhead as h left join glstock as s on s.trno=h.trno 
                left join item on item.itemid=s.itemid
                left join stockgrp_masterfile as g on g.stockgrp_id=item.groupid 
                left join client as ag on ag.clientid=s.agentid
                left join client as ag2 on ag2.clientid=s.agentid2
                left join client as c on c.clientid=h.clientid
                left join cntnum as num on num.trno = h.trno
                where h.doc='SJ' and h.dateid between '$start' and '$end' 
                and num.center = '".Yii::$app->session['loggeduser']['center']."' $client $agent $group order by staff,dateid";
            $result=Yii::$app->sbccommon->opentable($sql);
            return $result;

    }/*end jac*/ 

    
    //OTHERS
    public static function rptStatementOfAccounts($params){
            $isposted=$params['poststatus'];
            $attention=$params['attention'];
            $asof=$params['asof'];

            $filter="";

            if ($params['client'] != ""){
            $filter="and client.client='".$params['client']."'";
            }

              switch($isposted)
            {
                case 'unposted':{
                    $query="
                       select 'u' as tr, 1 as trsort, client.client, client.clientname, client.addr,
                       date(head.dateid) as docdate, head.docno as refno, '' as applied, detail.db as debit,
                       detail.cr as credit, (detail.db-detail.cr) as balance, head.agent, head.due,
                       (case when head.doc='sj' then 'sales' else (case when head.doc='cm' then 'return' else 'adjustment' end) end) as trcode
                       from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                       left join client on client.client=head.client)left join coa on coa.acno=detail.acno
                       where head.doc in ('ar','sj','cm','gj','cr') and left(coa.alias,2)='ar'
                       and head.dateid<='$asof' $filter
                       union all
                       select 'u' as tr, 1 as trsort, client.client, client.clientname, client.addr,
                       date(head.dateid) as docdate, head.docno as refno, '' as applied, detail.db as debit,
                       detail.cr as credit, (detail.db-detail.cr) as balance, head.agent, head.due,
                       (case when head.doc='sj' then 'sales' else (case when head.doc='cm' then 'return' else 'adjustment' end) end) as trcode
                       from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                       left join client on client.client=head.client)left join coa on coa.acno=detail.acno
                       where head.doc in ('ar','sj','cm','gj','cr') and left(coa.alias,2)='ar'
                       and head.dateid<='$asof' $filter
                       union all
                       select 'u' as tr, 1 as trsort, client.client, client.clientname, client.addr,
                       date(head.dateid) as docdate, head.docno as refno, '' as applied, detail.db as debit,
                       detail.cr as credit, (detail.db-detail.cr) as balance, head.agent, head.due,
                       (case when head.doc='sj' then 'sales' else (case when head.doc='cm' then 'return' else 'adjustment' end) end) as trcode
                       from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                       left join client on client.client=head.client)left join coa on coa.acno=detail.acno
                       where head.doc in ('ar','sj','cm','gj','cr') and left(coa.alias,2)='ar'
                       and head.dateid<='$asof' $filter
                       order by clientname, client
                        ";
                    break;
                }
                case 'posted':{
                    $query="
                       select 'p' as tr, 1 as trsort, client.client, client.clientname, client.addr,
                       date(ar.dateid) as docdate, ar.docno as refno, ar.ref as applied, ar.db as debit,
                       ar.cr as credit, (ar.bal) as balance, ag.client as agent, head.due,
                       (case when head.doc='sj' then 'sales' else (case when head.doc='cm' then 'return' else 'adjustment' end) end) as trcode
                       from (((glhead as head left join arledger as ar on ar.trno=head.trno)
                       left join client on client.clientid=head.clientid)left join coa on coa.acnoid=ar.acnoid)
                       left join client as ag on ag.clientid=ar.agentid
                       where head.doc in ('ar','sj','cm','gj','cr') and left(coa.alias,2)='ar'
                       and head.dateid<='$asof' and ar.bal<>0 and ifnull(client.client,'')<>'' $filter
                       union all
                       select 'p' as tr, 1 as trsort, client.client, client.clientname, client.addr,
                       date(ar.dateid) as docdate, ar.docno as refno, ar.ref as applied, ar.db as debit,
                       ar.cr as credit, (ar.bal) as balance, ag.client as agent, head.due,
                       (case when head.doc='sj' then 'sales' else (case when head.doc='cm' then 'return' else 'adjustment' end) end) as trcode
                       from (((hglhead as head left join arledger as ar on ar.trno=head.trno)
                       left join client on client.clientid=head.clientid)left join coa on coa.acnoid=ar.acnoid)
                       left join client as ag on ag.clientid=ar.agentid
                       where head.doc in ('ar','sj','cm','gj','cr') and left(coa.alias,2)='ar'
                       and head.dateid<='$asof' and ar.bal<>0 $filter
                       order by clientname, client ";
                    break;
                }
            }
            // echo $query;    
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }      
    public static function rptothers_itemsalesbybranch($params,$center) /*FPY*/ {
        //$todaydate=isset($params[2])? $params[2] : "%%";
        $item=isset($params[30]) && strlen($params[30])!=0? $params[30] : "ALL";
        $start=isset($params[1])? $params[1] : 0;
        $end=isset($params[2])? $params[2] : 0;
        $options=isset($params[33]) && strlen($params[33]!=0)? $params[33] : "%%";
        $customer=isset($params[29]) && strlen($params[29])!=0? $params[29] : "ALL";
            //$supplier=isset($params[14]) && strlen($params[14]!=0)? $params[14] : "ALL";
        if ($customer=="ALL"){
            $cus="";
        } else {
            $cus=" and client.client='$customer'";
        }
        if($params[33]=='qty'){
            $options1='sum(stock.iss)';
            } else {
            $options1='sum(stock.ext)';
            }
        if ($item=="ALL"){
                $it="";
            } else {
                $it="and item.barcode='$item'";
            }
            //var_dump($_POST);
            
        switch (Common::getcompanyid()){
        case 2:
        case 3:
        default:    
        $query="
            select name, barcode, itemname, sum(qty) as qty,brand,part from (
            select center.name, stock.barcode, stock.itemname, $options1 as qty,item.brand,item.part
            from lastock as stock left join lahead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno 
            left join center on center.code=cntnum.center left join client on client.client=head.client
            where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus group by center.name, stock.barcode, stock.itemname
            union all
            select center.name, stock.barcode, stock.itemname, $options1 as qty,item.brand,item.part
            from lbstock as stock left join lbhead as head on head.trno=stock.trno 
            left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno 
            left join center on center.code=cntnum.center left join client on client.client=head.client
            where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus group by center.name, stock.barcode, stock.itemname
            union all
            select center.name, stock.barcode, stock.itemname, $options1 as qty,item.brand,item.part
            from lcstock as stock left join lchead as head on head.trno=stock.trno 
            left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno 
            left join center on center.code=cntnum.center left join client on client.client=head.client
            where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus group by center.name, stock.barcode, stock.itemname
            union all
            select center.name, item.barcode, stock.itemname, $options1 as qty,item.brand,item.part
            from glstock as stock left join glhead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
            left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid
            where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus group by center.name, item.barcode, stock.itemname
            union all
            select center.name, item.barcode, stock.itemname, $options1 as qty,item.brand,item.part
            from hglstock as stock left join hglhead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
            left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid
            where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus group by center.name, item.barcode, stock.itemname ) as xx
            where ifnull(name,'')<>''
            group by name, barcode, itemname
            order by barcode          
        ";
         break;
        case 1:
        $query="
            select part, brand, barcode, itemname, sum(case when center='001' then qty else 0 end) as mainoffice,
            sum(case when center='002' then qty else 0 end) as smbaguio, sum(case when center='004' then qty else 0 end) as smcebu,
            sum(case when center='005' then qty else 0 end) as smclark, sum(case when center='006' then qty else 0 end) as smcalamba,
            sum(case when center='007' then qty else 0 end) as smdasma, sum(case when center='008' then qty else 0 end) as cmfairview,
            sum(case when center='009' then qty else 0 end) as smmoa, sum(case when center='011' then qty else 0 end) as smmega,
            sum(case when center='012' then qty else 0 end) as smnorth, sum(case when center='013' then qty else 0 end) as smpampanga,
            sum(case when center='014' then qty else 0 end) as smlazaro, sum(case when center='015' then qty else 0 end) as smsouth,
            sum(case when center='016' then qty else 0 end) as smstamesa, sum(case when center='017' then qty else 0 end) as smtarlac,
            sum(case when center='018' then qty else 0 end) as smtaytay, sum(case when center='019' then qty else 0 end) as virramal, sum(case when center='023' then qty else 0 end) as fishermall,
            sum(qty) as balance
            
            from (    select center.name, stock.barcode, stock.itemname, $options1 as qty,item.brand,item.part, cntnum.center
                      from lastock as stock left join lahead as head on head.trno=stock.trno
                      left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno 
                      left join center on center.code=cntnum.center left join client on client.client=head.client
                      where head.doc='sj' and head.dateid between '2014-06-01' and '2014-06-30' 
                      group by center.name, stock.barcode, stock.itemname,item.brand,item.part, cntnum.center
                      union all
                      select center.name, stock.barcode, stock.itemname, $options1 as qty,item.brand,item.part, cntnum.center
                      from lbstock as stock left join lbhead as head on head.trno=stock.trno 
                      left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno 
                      left join center on center.code=cntnum.center left join client on client.client=head.client
                      where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus
                      group by center.name, stock.barcode, stock.itemname, item.brand, item.part, cntnum.center
                      union all
                      select center.name, stock.barcode, stock.itemname, $options1 as qty,item.brand,item.part, cntnum.center
                      from lcstock as stock left join lchead as head on head.trno=stock.trno 
                      left join item on item.barcode=stock.barcode left join cntnum on cntnum.trno=head.trno
                      left join center on center.code=cntnum.center left join client on client.client=head.client
                      where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus
                      group by center.name, stock.barcode, stock.itemname, item.brand, item.part, cntnum.center
                      union all
                      select center.name, item.barcode, stock.itemname, $options1 as qty,item.brand,item.part, cntnum.center
                      from glstock as stock left join glhead as head on head.trno=stock.trno
                      left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                      left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid
                      where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus
                      group by center.name, item.barcode, stock.itemname, item.brand, item.part, cntnum.center
                      union all
                      select center.name, item.barcode, stock.itemname, $options1 as qty,item.brand,item.part, cntnum.center
                      from hglstock as stock left join hglhead as head on head.trno=stock.trno
                      left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                      left join item on item.itemid=stock.itemid left join client on client.clientid=head.clientid
                      where head.doc='sj' and head.dateid between '$start' and '$end' $it $cus
                      group by center.name, item.barcode, stock.itemname, item.brand, item.part, cntnum.center ) as xx
            where ifnull(name,'')<>''
            group by barcode, itemname, brand, part
            order by part, brand, barcode   
        ";    
        break;
        }
        //echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }   
    public static function rptothers_itemsalesbybranchlist($params,$center) /*FPY*/ {
        switch (Common::getcompanyid()){
        case 2:
        case 3:
        default:    
        $query='
            select name from (
                    select center.name
                    from lastock as stock left join lahead as head on head.trno=stock.trno
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" group by center.name
                    union all
                    select center.name
                    from lbstock as stock left join lbhead as head on head.trno=stock.trno 
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" group by center.name
                    union all
                    select center.name
                    from lcstock as stock left join lchead as head on head.trno=stock.trno 
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" group by center.name
                    union all
                    select center.name
                    from glstock as stock left join glhead as head on head.trno=stock.trno  
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" group by center.name
                    union all
                    select center.name
                    from hglstock as stock left join hglhead as head on head.trno=stock.trno
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" group by center.name ) as xx
            where ifnull(name,"")<>""
            group by name

            ';
        break;
        case 2:
        $query='
            select name from (
                    select center.name
                    from lastock as stock left join lahead as head on head.trno=stock.trno
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" and center.code not in ("003","010","020") group by center.name
                    union all
                    select center.name
                    from lbstock as stock left join lbhead as head on head.trno=stock.trno 
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" and center.code not in ("003","010","020") group by center.name
                    union all
                    select center.name
                    from lcstock as stock left join lchead as head on head.trno=stock.trno 
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" and center.code not in ("003","010","020") group by center.name
                    union all
                    select center.name
                    from glstock as stock left join glhead as head on head.trno=stock.trno  
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" and center.code not in ("003","010","020") group by center.name
                    union all
                    select center.name
                    from hglstock as stock left join hglhead as head on head.trno=stock.trno
                    left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                    where head.doc="sj" and center.code not in ("003","010","020") group by center.name ) as xx
            where ifnull(name,"")<>""
            group by name

            ';    
        break;
        }
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptDSR($params,$center){
                $asof=$params['enddate'];
  
                $result=Yii::$app->sbccommon->opentable("
                    select * from (select 'sales' as grp, head.doc, head.trno, head.docno, head.dateid, head.client, head.clientname, head.rem, head.acctname, head.acctno, head.cardtype,
                    stock.barcode, stock.itemname, stock.uom, stock.isqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext, stock.ext as balext,
                    item.sizeid, item.brand, item.groupid, stock.comm, stock.icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid),0) as bal, null as tdate,
                    (case when cntnum.bref='DP' then 2 else 1 end) as sort
                    from ((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                    left join cntnum on cntnum.trno=head.trno where head.doc='sj' and head.dateid='$asof' and cntnum.center='$center'
                    union all
                    select 'returns' as grp, head.doc, head.trno, head.docno, head.dateid, head.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                    stock.barcode, stock.itemname, stock.uom, stock.rrqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext , stock.ext*-1 as balext,
                    item.sizeid, item.brand, item.groupid, stock.comm, stock.icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid ),0) as bal, null as tdate,1 as sort
                    from ((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                    left join cntnum on cntnum.trno=head.trno where head.doc='cm' and left(head.docno,2)='cm' and head.dateid='$asof' and cntnum.center='$center'
                    union all
                    select 'pull-out' as grp, head.doc, head.trno, head.docno, head.dateid, head.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                    stock.barcode, stock.itemname, stock.uom, stock.isqty as qty, 0 as amt, '' as disc, 0 as discamt, 0 as ext, 0 as balext,
                    item.sizeid, item.brand, item.groupid, 0 AS comm, 0 As icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid ),0) as bal, null as tdate,1 as sort
                    from ((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                    left join cntnum on cntnum.trno=head.trno where head.doc='dm' and head.dateid='$asof' and cntnum.center='$center'
                    union all
                    select 'consignment' as grp,head.doc, head.trno, head.docno, head.dateid, head.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                    stock.barcode, stock.itemname, stock.uom, stock.isqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext, stock.ext as balext,
                    item.sizeid, item.brand, item.groupid, 0 AS comm, 0 As icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and ),0) as bal, null as tdate,1 as sort
                    from ((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                    left join cntnum on cntnum.trno=head.trno where head.doc='sj' and item.groupid<>' ' and head.dateid='$asof' and cntnum.center='$center'
                    union all
                    select 'expense' as grp, ex.doc, ex.trno, ex.docno, ex.dateid, '' as client, '' as clientname, ex.description, '' as acctname, '' as acctno, '' as cardtype,
                    '' as barcode, ex.description as itemname, '' as uom, 0 as qty, ex.amount as amt, '' as disc, ex.amount as discamt, ex.amount as ext, ex.amount*-1 as balext,
                    '' as sizeid, '' as brand, '' as groupid, 0 AS comm, 0 As icomm, 0 as bal, null as tdate,1 as sort
                    from expenses as ex left join transnum on transnum.trno=ex.trno where ex.dateid='$asof' and transnum.center='$center'
                    union all
                    select 'sales' as grp, head.doc, head.trno, head.docno, head.dateid, client.client, head.clientname, head.rem, head.acctname, head.acctno, head.cardtype,
                    item.barcode, stock.itemname, stock.uom, stock.isqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext, stock.ext as balext,
                    item.sizeid, item.brand, item.groupid, stock.comm, stock.icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and ),0) as bal, null as tdate,
                    (case when cntnum.bref='DP' then 2 else 1 end) as sort
                    from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                    left join cntnum on cntnum.trno=head.trno)left join client on client.clientid=head.clientid
                    where head.doc='sj' and head.dateid='$asof' and cntnum.center='$center'
                    union all
                    select 'returns' as grp, head.doc, head.trno, head.docno, head.dateid, client.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                    item.barcode, stock.itemname, stock.uom, stock.rrqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext , stock.ext*-1 as balext,
                    item.sizeid, item.brand, item.groupid, stock.comm, stock.icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and ),0) as bal, null as tdate,1 as sort
                    from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                    left join cntnum on cntnum.trno=head.trno)left join client on client.clientid=head.clientid
                    where head.doc='cm' and left(head.docno,2)='cm' and head.dateid='$asof' and cntnum.center='$center'
                    union all
                    select 'pull-out' as grp, head.doc, head.trno, head.docno, head.dateid, client.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                    item.barcode, stock.itemname, stock.uom, stock.isqty as qty, 0 as amt, '' as disc, 0 as discamt, 0 as ext, 0 as balext,
                    item.sizeid, item.brand, item.groupid, 0 AS comm, 0 AS icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and ),0) as bal, null as tdate,1 as sort
                    from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                    left join cntnum on cntnum.trno=head.trno)left join client on client.clientid=head.clientid
                    where head.doc='dm' and head.dateid='$asof' and cntnum.center='$center'
                    union all
                    select 'consignment' as grp,head.doc, head.trno, head.docno, head.dateid, client.client, head.clientname, head.rem, '' as acctname, '' as acctno, '' as cardtype,
                    item.barcode, stock.itemname, stock.uom, stock.isqty as qty, stock.isamt as amt, stock.disc, stock.amt as discamt, stock.ext, stock.ext as balext,
                    item.sizeid, item.brand, item.groupid, 0 AS comm, 0 As icomm, ifnull((select sum(rr.bal) from rrstatus as rr left join client as wh on wh.clientid=rr.whid where rr.itemid=item.itemid and wh.client='$wh'),0) as bal, null as tdate,1 as sort
                    from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                    left join cntnum on cntnum.trno=head.trno)left join client on client.clientid=head.clientid
                    where head.doc='sj' and item.groupid<>' ' and head.dateid='$asof' and cntnum.center='$center'
                    ) as result order by sort, docno, barcode");
                return $result;
    }
    public static function rptDSR2($params,$center){    
        $asof=$params['enddate'];
        
            $result1=Yii::$app->sbccommon->opentable("                
                        select grp, pmode, sum(ext) as ext
                        from (select 'sales' as grp, (case when modeofpayment='' then 'CASH' else modeofpayment end) as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext) as ext, null as tdate
                        from (lahead as head left join lastock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                        where head.doc='sj' and head.dateid='$asof' and cntnum.center='$center' and stock.isamt<>0 group by (case when modeofpayment='' then 'CASH' else modeofpayment end)
                        union all
                        select 'returns' as grp, 'returns' as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext)*-1 as ext, null as tdate
                        from (lahead as head left join lastock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                        where head.doc='cm' and left(head.docno,2)='cm' and head.dateid='$asof' and cntnum.center='$center'
                        union all
                        select 'sales' as grp, (case when modeofpayment='' then 'CASH' else modeofpayment end) as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext) as ext, null as tdate
                        from (glhead as head left join glstock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                        where head.doc='sj' and head.dateid='$asof' and cntnum.center='$center' and stock.isamt<>0 group by (case when modeofpayment='' then 'CASH' else modeofpayment end)
                        union all
                        select 'returns' as grp, 'returns' as pmode, '' as acctname, '' as acctno, '' as cardtype, sum(stock.ext)*-1 as ext, null as tdate
                        from (glhead as head left join glstock as stock on stock.trno=head.trno)left join cntnum on cntnum.trno=head.trno
                        where head.doc='cm' and left(head.docno,2)='cm' and head.dateid='$asof' and cntnum.center='$center'
                        union all
                        select 'returns' as grp, 'expenses' as pmode, '' as acctname, '' as acctno, '' as cardtype, ex.amount*-1 as ext, null as tdate
                        from expenses as ex left join transnum on transnum.trno=ex.trno where ex.dateid='$asof' and transnum.center='$center') as xx
                        group by grp, pmode
                        having sum(ext)<>0
               ");
            return $result1;
        }

        public static function rptChartqry($params,$center){    
        $filter=$params['year'];
        
            $query = "select label,round(sum(y),2) as y from (
                        select 1 as sort,'January' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=1 and year(head.dateid)='".$filter."'
                        union all
                        select 1 as sort,'January' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=1 and year(head.dateid)='".$filter."'
                        union all
                        select 2 as sort,'February' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=2 and year(head.dateid)='".$filter."'
                        union all
                        select 2 as sort,'February' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=2 and year(head.dateid)='".$filter."'
                        union all
                        select 3 as sort,'March' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=3 and year(head.dateid)='".$filter."'
                        union all
                        select 3 as sort,'March' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=3 and year(head.dateid)='".$filter."'
                        union all
                        select 4 as sort,'April' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=4 and year(head.dateid)='".$filter."'
                        union all
                        select 4 as sort,'April' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=4 and year(head.dateid)='".$filter."'
                        union all
                        select 5 as sort,'May' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=5 and year(head.dateid)='".$filter."'
                        union all
                        select 5 as sort,'May' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=5 and year(head.dateid)='".$filter."'
                        union all
                        select 6 as sort,'June' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=6 and year(head.dateid)='".$filter."'
                        union all
                        select 6 as sort,'June' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=6 and year(head.dateid)='".$filter."'
                        union all
                        select 7 as sort,'July' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=7 and year(head.dateid)='".$filter."'
                        union all
                        select 7 as sort,'July' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=7 and year(head.dateid)='".$filter."'
                        union all
                        select 8 as sort,'August' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=8 and year(head.dateid)='".$filter."'
                        union all
                        select 8 as sort,'August' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=8 and year(head.dateid)='".$filter."'
                        union all
                        select 9 as sort,'September' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=9 and year(head.dateid)='".$filter."'
                        union all
                        select 9 as sort,'September' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=9 and year(head.dateid)='".$filter."'
                        union all
                        select 10 as sort,'October' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=10 and year(head.dateid)='".$filter."'
                        union all
                        select 10 as sort,'October' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=10 and year(head.dateid)='".$filter."'
                        union all
                        select 11 as sort,'November' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=11 and year(head.dateid)='".$filter."'
                        union all
                        select 11 as sort,'November' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=11 and year(head.dateid)='".$filter."'
                        union all
                        select 12 as sort,'December' as label,ifnull(stock.ext,0) as y
                        from lahead as head left join lastock as stock on stock.trno=head.trno where month(head.dateid)=12 and year(head.dateid)='".$filter."'
                        union all
                        select 12 as sort,'December' as label,ifnull(stock.ext,0) as y
                        from glhead as head left join glstock as stock on stock.trno=head.trno where month(head.dateid)=12 and year(head.dateid)='".$filter."'
                        ) as t group by label order by sort";
                       
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

        public static function rptSalescomparisonChartqry($params,$center){    
        $filter=$params['year'];
        
            $query= "select client,clientname as label,yr,sum(amt) as y from (
                    select h.client, h.clientname, ifnull(sum(ext),0) as amt, year(h.dateid) as yr
                    from lahead as h left join lastock as s on s.trno=h.trno
                    where h.doc='SJ' and year(h.dateid) between ".$filter."-1 and ".$filter."
                    group by h.client, h.clientname, year(h.dateid)
                    union all
                    select client.client, h.clientname, ifnull(sum(ext),0) as amt, year(h.dateid) as yr
                    from glhead as h left join glstock as s on s.trno=h.trno left join client on client.clientid=h.clientid
                    where h.doc='SJ' and year(h.dateid) between ".$filter."-1 and ".$filter."
                    group by client.client, h.clientname, year(h.dateid)
                    ) as sj group by client,clientname,yr
                    order by clientname";         
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }   
        
    public static function rptA_Expensesreports($params,$center) /* ALA */ {
            $isposted=$params['poststatus'];
            $isdetailed=$params['reporttype'];
            $start=$params['start'];
            $end=$params['end'];

            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select concat(left(docno,3),right(docno,5)) as docno, dateid, clientname as supplier, hnotes as clientname, acno, acnoname, snotes as description, sum(db-cr) as amount
                                from (select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from lahead as head left join ladetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                union all
                                select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from lbhead as head left join lbdetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                union all
                                select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from lchead as head left join lcdetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center') as exp
                                group by docno, dateid, clientname, hnotes, acno, acnoname, snotes
                                order by dateid, docno
                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select acno, acnoname, sum(db-cr) as amount
                                from (select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from lahead as head left join ladetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                union all
                                select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from lbhead as head left join lbdetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                union all
                                select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from lchead as head left join lcdetail as detail on detail.trno=head.trno left join coa on coa.acno=detail.acno
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center') as exp
                                group by acno, acnoname
                                order by acnoname

                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
             switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select concat(left(docno,3),right(docno,5)) as docno, dateid, clientname as supplier, hnotes as clientname, acno, acnoname, snotes as description, sum(db-cr) as amount
                                from (select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                union all
                                select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center') as exp
                                group by docno, dateid, clientname, hnotes, acno, acnoname, snotes
                                order by dateid, docno
                            ";
                           
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select acno, acnoname, sum(db-cr) as amount
                                from (select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                union all
                                select concat(left(head.docno,3),right(head.docno,5)) as docno, head.dateid, head.clientname, head.rem as hnotes, coa.acno, coa.acnoname,
                                detail.db, detail.cr, detail.rem as snotes, detail.postdate
                                from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
                                left join cntnum on cntnum.trno=head.trno
                                where head.doc='cv' and coa.cat='e' and head.dateid between '$start' and '$end' and cntnum.center='$center') as exp
                                group by acno, acnoname
                                order by acnoname

                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }    
    public static function rptA_Cardtransaction($params,$center) /* ALA */ {
            $isposted=isset($params[0])? $params[0] : "ALL";
            $isdetailed=$params[7]=="detailed"? "DETAILED" : "SUMMARIZED";
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                                union all
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                                union all
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                            ";
                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select head.dateid, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, client.clientname, cntnum.center

                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
             switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                                union all
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                            ";

                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select head.dateid, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end' and cntnum.center='$center'
                                group by head.dateid, client.clientname, cntnum.center
                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }    
    public static function rptO_Expensesbybranch($params,$center) /* ALA */ {
            //$isposted=isset($params[0])? $params[0] : "ALL";
            $isdetailed=$params[7]=="detailed"? "DETAILED" : "SUMMARIZED";
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
             switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                                select date(ex.dateid) as dateid, concat(left(ex.docno,4),right(ex.docno,5)) as docno, ex.description, ex.amount, cntnum.center
                                from expenses as ex left join transnum as cntnum on cntnum.trno=ex.trno
                                where ex.dateid between '$start' and '$end' and cntnum.center='$center'
                            ";
                           
                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select date(dateid) as dateid, sum(case when center='001' then amount else 0 end) as mainoffice, sum(case when center='002' then amount else 0 end) as smbaguio,
                                sum(case when center='003' then amount else 0 end) as smbicutan, sum(case when center='004' then amount else 0 end) as smcebu,
                                sum(case when center='005' then amount else 0 end) as smclark, sum(case when center='006' then amount else 0 end) as smcalamba,
                                sum(case when center='007' then amount else 0 end) as smdasma, sum(case when center='008' then amount else 0 end) as cmfairview,
                                sum(case when center='009' then amount else 0 end) as smmoa, sum(case when center='010' then amount else 0 end) as smmanila,
                                sum(case when center='011' then amount else 0 end) as smmega, sum(case when center='012' then amount else 0 end) as smnorth,
                                sum(case when center='013' then amount else 0 end) as smpampanga, sum(case when center='014' then amount else 0 end) as smlazaro,
                                sum(case when center='015' then amount else 0 end) as smsouth, sum(case when center='016' then amount else 0 end) as smstamesa,
                                sum(case when center='017' then amount else 0 end) as smtarlac, sum(case when center='018' then amount else 0 end) as smtaytay,
                                sum(case when center='019' then amount else 0 end) as virramal, sum(case when center='020' then amount else 0 end) as smdavao
                                from (select ex.dateid, ex.docno, ex.description, ex.amount, cntnum.center
                                from expenses as ex left join transnum as cntnum on cntnum.trno=ex.trno
                                where ex.dateid between '$start' and '$end') as xx
                                group by dateid
                            ";
                            break;
                        }
                   
                    break;
 }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rptO_Salesreportperday($params,$center) /* ALA */ {
            $isposted=isset($params[0])? $params[0] : "ALL";
            $isdetailed=$params[7]=="detailed"? "DETAILED" : "SUMMARIZED";
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            $options=isset($params[33]) && strlen($params[33]!=0)? $params[33] : "%%";
            if($params[33]=='qty'){
                $options1='iss';
                } else {
                $options1='amt';
                }
            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                            select dateid, concat(left(docno,4),right(docno,5)) as docno, sum(case when center='001' then $options1 else 0 end) as mainoffice, sum(case when center='002' then $options1 else 0 end) as smbaguio,
                            sum(case when center='003' then $options1 else 0 end) as smbicutan, sum(case when center='004' then $options1 else 0 end) as smcebu,
                            sum(case when center='005' then $options1 else 0 end) as smclark, sum(case when center='006' then $options1 else 0 end) as smcalamba,
                            sum(case when center='007' then $options1 else 0 end) as smdasma, sum(case when center='008' then $options1 else 0 end) as cmfairview,
                            sum(case when center='009' then $options1 else 0 end) as smmoa, sum(case when center='010' then $options1 else 0 end) as smmanila,
                            sum(case when center='011' then $options1 else 0 end) as smmega, sum(case when center='012' then $options1 else 0 end) as smnorth,
                            sum(case when center='013' then $options1 else 0 end) as smpampanga, sum(case when center='014' then $options1 else 0 end) as smlazaro,
                            sum(case when center='015' then $options1 else 0 end) as smsouth, sum(case when center='016' then $options1 else 0 end) as smstamesa,
                            sum(case when center='017' then $options1 else 0 end) as smtarlac, sum(case when center='018' then $options1 else 0 end) as smtaytay,
                            sum(case when center='019' then $options1 else 0 end) as virramal, sum(case when center='020' then $options1 else 0 end) as smdavao
                            from (select head.dateid, head.docno, client.clientname,ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                            from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and head.dateid between '$start' and '$end'
                            group by head.dateid, head.docno, client.clientname
                            union all
                            select head.dateid, head.docno, client.clientname,ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                            from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and head.dateid between '$start' and '$end'
                            group by head.dateid, head.docno, client.clientname
                            union all
                            select head.dateid, head.docno, client.clientname,ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                            from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and head.dateid between '$start' and '$end'
                            group by head.dateid, head.docno, client.clientname) as xx
                            group by dateid, docno    
                            ";
                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select dateid, sum(case when center='001' then $options1 else 0 end) as mainoffice, sum(case when center='002' then $options1 else 0 end) as smbaguio,
                                sum(case when center='003' then $options1 else 0 end) as smbicutan, sum(case when center='004' then $options1 else 0 end) as smcebu,
                                sum(case when center='005' then $options1 else 0 end) as smclark, sum(case when center='006' then $options1 else 0 end) as smcalamba,
                                sum(case when center='007' then $options1 else 0 end) as smdasma, sum(case when center='008' then $options1 else 0 end) as cmfairview,
                                sum(case when center='009' then $options1 else 0 end) as smmoa, sum(case when center='010' then $options1 else 0 end) as smmanila,
                                sum(case when center='011' then $options1 else 0 end) as smmega, sum(case when center='012' then $options1 else 0 end) as smnorth,
                                sum(case when center='013' then $options1 else 0 end) as smpampanga, sum(case when center='014' then $options1 else 0 end) as smlazaro,
                                sum(case when center='015' then $options1 else 0 end) as smsouth, sum(case when center='016' then $options1 else 0 end) as smstamesa,
                                sum(case when center='017' then $options1 else 0 end) as smtarlac, sum(case when center='018' then $options1 else 0 end) as smtaytay,
                                sum(case when center='019' then $options1 else 0 end) as virramal, sum(case when center='020' then $options1 else 0 end) as smdavao
                                from (select head.dateid, client.clientname, ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname
                                union all
                                select head.dateid, client.clientname,ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname
                                union all
                                select head.dateid, client.clientname, ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname) as xx
                                group by dateid

                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
             switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                            select dateid, concat(left(docno,4),right(docno,5)) as docno, sum(case when center='001' then $options1 else 0 end) as mainoffice, sum(case when center='002' then $options1 else 0 end) as smbaguio,
                            sum(case when center='003' then $options1 else 0 end) as smbicutan, sum(case when center='004' then $options1 else 0 end) as smcebu,
                            sum(case when center='005' then $options1 else 0 end) as smclark, sum(case when center='006' then $options1 else 0 end) as smcalamba,
                            sum(case when center='007' then $options1 else 0 end) as smdasma, sum(case when center='008' then $options1 else 0 end) as cmfairview,
                            sum(case when center='009' then $options1 else 0 end) as smmoa, sum(case when center='010' then $options1 else 0 end) as smmanila,
                            sum(case when center='011' then $options1 else 0 end) as smmega, sum(case when center='012' then $options1 else 0 end) as smnorth,
                            sum(case when center='013' then $options1 else 0 end) as smpampanga, sum(case when center='014' then $options1 else 0 end) as smlazaro,
                            sum(case when center='015' then $options1 else 0 end) as smsouth, sum(case when center='016' then $options1 else 0 end) as smstamesa,
                            sum(case when center='017' then $options1 else 0 end) as smtarlac, sum(case when center='018' then $options1 else 0 end) as smtaytay,
                            sum(case when center='019' then $options1 else 0 end) as virramal, sum(case when center='020' then $options1 else 0 end) as smdavao
                            from (select head.dateid, head.docno, client.clientname,ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                            from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and head.dateid between '$start' and '$end'
                            group by head.dateid, head.docno, client.clientname, cntnum.center
                            union all
                            select head.dateid, head.docno, client.clientname,ifnull(sum(stock.iss),0) as iss, ifnull(sum(stock.ext),0) as amt, cntnum.center
                            from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                            where head.doc='sj' and head.dateid between '$start' and '$end'
                            group by head.dateid, head.docno, client.clientname, cntnum.center) as xx
                            group by dateid, docno    
                            ";
                           
                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select dateid, sum(case when center='001' then $options1 else 0 end) as mainoffice, sum(case when center='002' then $options1 else 0 end) as smbaguio,
                                sum(case when center='003' then $options1 else 0 end) as smbicutan, sum(case when center='004' then $options1 else 0 end) as smcebu,
                                sum(case when center='005' then $options1 else 0 end) as smclark, sum(case when center='006' then $options1 else 0 end) as smcalamba,
                                sum(case when center='007' then $options1 else 0 end) as smdasma, sum(case when center='008' then $options1 else 0 end) as cmfairview,
                                sum(case when center='009' then $options1 else 0 end) as smmoa, sum(case when center='010' then $options1 else 0 end) as smmanila,
                                sum(case when center='011' then $options1 else 0 end) as smmega, sum(case when center='012' then $options1 else 0 end) as smnorth,
                                sum(case when center='013' then $options1 else 0 end) as smpampanga, sum(case when center='014' then $options1 else 0 end) as smlazaro,
                                sum(case when center='015' then $options1 else 0 end) as smsouth, sum(case when center='016' then $options1 else 0 end) as smstamesa,
                                sum(case when center='017' then $options1 else 0 end) as smtarlac, sum(case when center='018' then $options1 else 0 end) as smtaytay,
                                sum(case when center='019' then $options1 else 0 end) as virramal, sum(case when center='020' then $options1 else 0 end) as smdavao
                                from 
                                (select head.dateid, client.clientname, ifnull(sum(stock.iss),0) as iss,ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid, client.clientname, ifnull(sum(stock.iss),0) as iss,ifnull(sum(stock.ext),0) as amt, cntnum.center
                                from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center) as xx
                                group by dateid
                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }


        public static function rptDiscountedprice($params) /* ALA */ {
            $start=$params['startdate'];
            $end=$params['enddate'];
            $agent ='';
            
            if ($params['agent']!=''){
            $agent = " and ag.client = '".$params['agent']."'";
            }

        $query="select date(h.dateid) as dateid,h.docno,h.client,h.clientname,h.agent,ifnull(ag.clientname,'') as agname,
            s.barcode,s.itemname,s.uom,s.isqty,s.isamt,s.disc as discount,ifnull(sum(s.ext),0) as net
            from lahead as h left join lastock as s on s.trno=h.trno
            left join client as ag on ag.client=h.agent
            where h.doc='SJ' and h.dateid between '$start' and '$end' $agent and s.disc<>''
            group by h.dateid,h.docno,h.client,h.clientname,h.agent,ag.clientname,s.barcode,s.itemname
            union all
            select date(h.dateid) as dateid,h.docno,client.client,h.clientname,ifnull(ag.agent,'') as agent,ifnull(ag.clientname,'') as agname,
            item.barcode,s.itemname,s.uom,s.isqty,s.isamt,s.disc as discount,ifnull(sum(s.ext),0) as net
            from glhead as h left join glstock as s on s.trno=h.trno left join item on item.itemid=s.itemid
            left join client on client.clientid=h.clientid left join client as ag on ag.clientid=h.agentid
            where h.doc='SJ' and h.dateid between '$start' and '$end' $agent and s.disc<>''
            group by h.dateid,h.docno,client.client,h.clientname,ag.agent,ag.clientname,item.barcode,s.itemname
            order by agname,docno,itemname";

            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

        public static function rptSalesreportpersalesman($params) /* ALA */ {
            $start=$params['startdate'];
            $end=$params['enddate'];
            $agent ='';
            
            if ($params['agent']!=''){
            $agent = " and ag.client = '".$params['agent']."'";
            }

        $query="
            select ifnull(ag.client,'') as agcode,ifnull(ag.clientname,'') as agentname,date(h.dateid) as dateid,h.docno,h.client,h.clientname,h.agent,ifnull(ag.clientname,'') as agname, ifnull(sum(s.ext),0) as ext
            from lahead as h left join lastock as s on s.trno=h.trno
            left join client as ag on ag.client=h.agent
            where h.doc='SJ' and h.dateid between '$start' and '$end' $agent
            group by h.dateid,h.docno,h.client,h.clientname,h.agent,ag.clientname
            union all
            select ifnull(ag.client,'') as agcode,ifnull(ag.clientname,'') as agentname,date(h.dateid) as dateid,h.docno,client.client,h.clientname,ifnull(ag.agent,'') as agent,ifnull(ag.clientname,'') as agname, ifnull(sum(s.ext),0) as ext
            from glhead as h left join glstock as s on s.trno=h.trno
            left join client on client.clientid=h.clientid left join client as ag on ag.clientid=h.agentid
            where h.doc='SJ' and h.dateid between '$start' and '$end' $agent
            group by h.dateid,h.docno,client.client,h.clientname,ag.agent,ag.clientname
            order by agname,docno;
            ";
                 
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }

    public static function rptA_Cardtransactionifallbranch($params,$center) /* ALA */ {
            $isposted=isset($params[0])? $params[0] : "ALL";
            $isdetailed=$params[7]=="detailed"? "DETAILED" : "SUMMARIZED";
            $start=isset($params[1])? $params[1] : 0;
            $end=isset($params[2])? $params[2] : 0;
            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center, center.name
                                from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end'
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                                union all
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center, center.name
                                from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' 
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                                union all
                                select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center, center.name
                                from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' 
                                group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                                order by name,dateid,docno
                            ";
                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select head.dateid,head.docno, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card, center.name,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid,head.docno, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card, center.name,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid,head.docno, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card, center.name,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center
                                order by name,dateid,docno
                            ";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
             switch($isdetailed){
                        case 'DETAILED':{
                            $query="
                            select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center, center.name
                            from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                            where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end'
                            group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                            union all
                            select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.clientname, head.modeofpayment, head.acctname, head.acctno, head.cardtype, ifnull(sum(stock.ext),0) as amt, cntnum.center, center.name
                            from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                            where head.doc='sj' and head.modeofpayment in ('card','cashcard') and head.dateid between '$start' and '$end' 
                            group by head.dateid, head.docno, client.clientname, cntnum.center, head.modeofpayment, head.acctname, head.acctno, head.cardtype
                            order by name,dateid,docno
                            ";

                            break;
                        }
                        case 'SUMMARIZED':{
                            $query="
                                select head.dateid,head.docno, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card, center.name,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center
                                union all
                                select head.dateid,head.docno, client.clientname, cntnum.center, ifnull(sum(case when head.modeofpayment in ('card','cashcard') then stock.ext else 0 end),0) as card, center.name,
                                ifnull(sum(case when head.modeofpayment in ('card','cashcard') then 0 else stock.ext end),0) as cash
                                from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno left join center on center.code=cntnum.center
                                where head.doc='sj' and head.dateid between '$start' and '$end'
                                group by head.dateid, client.clientname, cntnum.center
                                order by name,dateid,docno
                            ";
                            break;
                        }
                    }
                    break;
                }
            }
            //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }    
        
    public static function rptPayslip1($params){    
            
            $result1=Yii::$app->sbccommon->opentable("                
                    SELECT paytran.batch,paytran.empcode,e.emplast,e.empfirst,e.empmiddle,accnt.seq, accnt.codename,
                    paytran.qty, paytran.uom, paytran.db AS Earning, paytran.cr AS deduction,date(paytran.dateid) as dateid
                    FROM paytranCurrent AS paytran left JOIN employee AS emp ON emp.empcode=paytran.empcode
                    left JOIN paccount AS accnt ON accnt.code=paytran.acno
                    LEFT JOIN department ON department.deptcode=emp.dept
                    LEFT JOIN division ON division.divcode=emp.division
                    LEFT JOIN section ON section.sectcode=emp.orgsection
                    LEFT JOIN batch ON batch.batch=paytran.batch
                    left join employee as e on e.empcode=paytran.empcode
                    WHERE  paytran.empcode = '31023'
                    and paytran.acno not in ('PT53','pt54','pt55')
                    and paytran.batch = 'PS20140104'
                    ORDER BY accnt.seq desc
               ");
            return $result1;
        }       
    public static function rptO_Collection_report($params,$center) /* ALA */ {
        $option=isset($params[45]) && strlen($params[45])!=0? $params[45] : "BOTH";
        $customer=isset($params[14]) && strlen($params[14])!=0? $params[29] : "ALL";

        if ($customer=="ALL"){
                $cus="";
            } else {
                $cus="and cl.client='$customer'";
            }

        $start=isset($params[1])? $params[1] : 0;
        $end=isset($params[2])? $params[2] : 0;
        $query="select cl.client,cntnum.trno, cntnum.bref, right(head.docno,4) as docno, date(head.dateid) as dateid, head.clientname, (case when left(coa.alias,2)='CA' then 'CASH' else detail.checkno end) as checkno,
                date(detail.postdate) as postdate, left(coa.alias,2) As alias, detail.db, detail.cr, detail.ref as refdoc, detail.ref, '' as drem, 0 as disc, 0 as wt, 0 as short, 0 as over, 0 as supp, 0 as addback
                from glhead as head left join gldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno left join coa on coa.acnoid=detail.acnoid
                left join client as cl on cl.clientid = head.clientid
                where cntnum.doc='CR' and head.dateid between '$start' and '$end' and left(coa.alias,2) in ('$option') $cus
                union all
                Select cl.client,cntnum.trno, cntnum.bref, right(head.docno,4) as docno, date(head.dateid) as dateid, head.clientname, (case when left(coa.alias,2)='CA' then 'CASH' else detail.checkno end) as checkno,
                date(detail.postdate) as postdate, left(coa.alias,2) As alias, detail.db, detail.cr, detail.ref as refdoc, detail.ref, '' as drem, 0 as disc, 0 as wt, 0 as short, 0 as over, 0 as supp, 0 as addback
                from lahead as head left join ladetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno left join coa on coa.acno=detail.acno
                left join client as cl on cl.clientid = head.client
                where cntnum.doc='CR' and head.dateid between '$start' and '$end' and  left(coa.alias,2)  in ('$option') $cus
                union all
                Select cl.client,cntnum.trno, cntnum.bref, right(head.docno,4) as docno, date(head.dateid) as dateid, head.clientname, '' as checkno, null as postdate, '' as alias, 0 as db, 0 as cr, '' as refdoc, '' as ref, '' as drem, 0 as disc,
                ifnull((Select abs(sum(ladetail.db-ladetail.cr)) from ladetail left join coa on coa.acno=ladetail.acno where ladetail.trno=head.trno and coa.acno='\\520610'),0) as wt,
                ifnull((Select abs(sum(ladetail.db)) from ladetail left join coa on coa.acno=ladetail.acno where ladetail.trno=head.trno and coa.acno='\\110506'),0) as short,
                ifnull((Select (sum(ladetail.cr-ladetail.db)) from ladetail left join coa on coa.acno=ladetail.acno where ladetail.trno=head.trno and coa.acno='\\110505'),0) as over,
                ifnull((Select abs(sum(ladetail.db-ladetail.cr)) from ladetail left join coa on coa.acno=ladetail.acno where ladetail.trno=head.trno and coa.acno not in ('\\110505','\\2112','\\520610','\\45') and left(coa.alias,2) not in ('AP','AR','CB','CA','CR')),0) as supp,
                ifnull((Select abs(sum(ladetail.cr)) from ladetail left join coa on coa.acno=ladetail.acno where ladetail.trno=head.trno and coa.acno='\\110506'),0) as addback
                from lahead as head left join ladetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno left join coa on coa.acno=detail.acno
                left join client as cl on cl.clientid = head.client
                where cntnum.doc='CR' and head.dateid between '$start' and '$end' and coa.alias='CR'
                group by cntnum.trno, cntnum.bref, head.docno, head.clientname
                union all
                Select cl.client,cntnum.trno, cntnum.bref, right(head.docno,4) as docno, date(head.dateid) as dateid, head.clientname, '' as checkno, null as postdate, '' as alias, 0 as db, 0 as cr, '' as refdoc, '' as ref,
                detail.rem as drem, abs(sum(detail.db-detail.cr)) as disc, 0 as wt, 0 as short, 0 as over, 0 as supp, 0 as addback
                from glhead as head left join gldetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno left join coa on coa.acnoid=detail.acnoid
                left join client as cl on cl.clientid = head.clientid
                where cntnum.doc='CR' and head.dateid between '$start' and '$end' and coa.acno='\\45'
                group by cntnum.trno, cntnum.bref, head.docno, head.clientname, detail.rem
                union all
                Select cl.client,cntnum.trno, cntnum.bref, right(head.docno,4) as docno, date(head.dateid) as dateid, head.clientname, '' as checkno, null as postdate, '' as alias, 0 as db, 0 as cr, '' as refdoc, '' as ref,
                detail.rem as drem, abs(sum(detail.db-detail.cr)) as disc, 0 as wt, 0 as short, 0 as over, 0 as supp, 0 as addback
                from lahead as head left join ladetail as detail on detail.trno=head.trno left join cntnum on cntnum.trno=head.trno left join coa on coa.acno=detail.acno
                left join client as cl on cl.clientid = head.client
                where cntnum.doc='CR' and head.dateid between '$start' and '$end' and coa.acno='\\45'
                group by cntnum.trno, cntnum.bref,head.docno,head.clientname,detail.rem
               ";
        // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptO_Collection_reportallbranch($params,$center) /* ALA */ {
        $isposted=isset($params[0])? $params[0] : "ALL";
        $isdetailed=$params[7]=="detailed"? "DETAILED" : "SUMMARIZED";
        $start=isset($params[1])? $params[1] : 0;
        $end=isset($params[2])? $params[2] : 0;
        switch($isposted)
        {
            case 'unposted':{
                switch($isdetailed){
                    case 'DETAILED':{
                        $query="
                            select transnum.center,center.name,head.mop,head.modamt,head.modref,head.moddate,head.docno,head.trno, head.clientname, head.address, date(head.dateid) as dateid, head.terms, head.rem,head.agent,head.wh,
                            stock.barcode, stock.itemname, stock.isamt as gross, stock.amt as netamt, stock.isqty as qty,
                            stock.uom, stock.disc, stock.ext, stock.line,item.brand,client.clientname as whname
                            from sohead as head left join sostock as stock on stock.trno=head.trno
                            left join item on item.barcode=stock.barcode
                            left join client on client.client=head.wh
                            left join transnum on transnum.trno=head.trno
                            left join center on center.code=transnum.center
                            where head.doc='so' and head.dateid between '$start' and '$end'
                            order by center
                        ";
                        break;
                    }
                }
                break;
            }
            case 'posted':{
            switch($isdetailed){
                    case 'DETAILED':{
                        $query="
                        select transnum.center,center.name,head.mop,head.modamt,head.modref,head.moddate,head.docno,head.trno, head.clientname, head.address, date(head.dateid) as dateid, head.terms, head.rem,head.agent,head.wh,
                        stock.barcode, stock.itemname, stock.isamt as gross, stock.amt as netamt, stock.isqty as qty,
                        stock.uom, stock.disc, stock.ext, stock.line,item.brand,client.clientname as whname
                        from hsohead as head left join hsostock as stock on stock.trno=head.trno
                        left join item on item.barcode=stock.barcode
                        left join client on client.client=head.wh
                        left join transnum on transnum.trno=head.trno
                        left join center on center.code=transnum.center
                        where head.doc='so' and head.dateid between '$start' and '$end'
                        order by line
                        ";

                        break;
                    }
                }
                break;
            }
        }
        //echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
            
        
    //MODULES
    public static function rptrequisitionslip($_) {
        $trno=$_;
        $query="
                    select head.trno, head.docno, client.client, head.clientname, head.address, head.yourref, head.ourref, date(head.dateid) as dateid, head.rem,
                    item.barcode, item.itemname, stock.rrqty, stock.uom, stock.qty,stock.qa, stock.rrcost, stock.cost, stock.ext, stock.wh, stock.disc
                    from prhead as head left join prstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode
                    where md5(head.trno)='$trno'
                    union all
                    select head.trno, head.docno, client.client, head.clientname, head.address, head.yourref, head.ourref, date(head.dateid) as dateid, head.rem,
                    item.barcode, item.itemname, stock.rrqty, stock.uom, stock.qty,stock.qa, stock.rrcost, stock.cost, stock.ext, stock.wh, stock.disc
                    from hprhead as head left join hprstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode
                    where md5(head.trno)='$trno'
                ";
        //echo $query;
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    
    public static function rptproduction($_) {
        $trno=$_;
        $query="
                    select head.trno, head.docno, client.client, head.clientname, head.address, head.yourref, head.ourref, head.dateid, head.rem,
                    item.barcode, item.itemname, stock.rrqty, stock.uom, stock.qty, stock.rrcost, stock.cost, stock.ext, stock.wh, stock.disc
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode
                    where head.doc='pu' and stock.rrqty<>0 and md5(head.trno)='$trno'
                    union all
                    select head.trno, head.docno, client.client, head.clientname, head.address, head.yourref, head.ourref, head.dateid, head.rem,
                    item.barcode, item.itemname, stock.rrqty, stock.uom, stock.qty, stock.rrcost, stock.cost, stock.ext, wh.client as wh, stock.disc
                    from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid
                    left join item on item.itemid=stock.itemid left join client as wh on wh.clientid=stock.whid
                    where head.doc='pu' and stock.rrqty<>0 and md5(head.trno)='$trno'
                ";
        //echo $query;
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    
    public static function rptpurchasereport($_) {
        $trno=$_;
        $query="
                    select date(head.dateid) as dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as netamt, stock.disc, stock.ext
                    from pohead as head left join postock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='po' and md5(head.trno)='$trno'
                    union all
                    select date(head.dateid) as dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as netamt, stock.disc, stock.ext
                    from hpohead as head left join hpostock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='po' and md5(head.trno)='$trno'
                ";
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }

    //TAXWHELD MODULE
    public static function rpttaxwheldreport($_) {
        $trno=$_;
        $query="select head.docno,head.client,head.clientname,head.address,head.dateid,head.dateid2,
                detail.acno,detail.acnoname,detail.rate,detail.income,detail.wheld,client.tin
                from taxhead as head
                left join taxdetail as detail on detail.trno=head.trno
                left join client on client.client=head.client
                where md5(head.trno)='$trno'
                union all
                select head.docno,head.client,head.clientname,head.address,head.dateid,head.dateid2,
                detail.acno,detail.acnoname,detail.rate,detail.income,detail.wheld,client.tin
                from htaxhead as head
                left join htaxdetail as detail on detail.trno=head.trno
                left join client on client.client=head.client
                where md5(head.trno)='$trno'";
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    //TAXWHELD MODULE END
    
    public static function rptPurchasereturn($_) {
        $trno=$_;
             $query="
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='dm' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext
                    from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='dm' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext
                    from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='dm' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, item.barcode,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext
                    from glhead as head left join glstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    where head.doc='dm' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, item.barcode,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext
                    from hglhead as head left join hglstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    where head.doc='dm' and md5(head.trno)='$trno'
                    ";
             
             
             
             
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptReceivingreport($_) {

        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line,wh.client as wh
                    from lahead as head 
                    left join lastock as stock on stock.trno=head.trno 
                    left join client as wh on wh.client = stock.wh
                    where md5(head.trno)='$trno'
                    union all
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line,wh.client as wh
                    from lbhead as head 
                    left join lastock as stock on stock.trno=head.trno 
                    left join client as wh on wh.client = stock.wh
                    where md5(head.trno)='$trno'
                    union all
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line,wh.client as wh
                    from lchead as head 
                    left join lastock as stock on stock.trno=head.trno 
                    left join client as wh on wh.client = stock.wh
                    where md5(head.trno)='$trno'
                    union all
                    select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line,wh.client as wh
                    from (glhead as head 
                    left join glstock as stock on stock.trno=head.trno)
                    left join item on item.itemid=stock.itemid
                    left join client as wh on wh.clientid = stock.whid
                    where  md5(head.trno)='$trno'
                    union all
                    select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line,wh.client as wh
                    from (hglhead as head 
                    left join glstock as stock on stock.trno=head.trno)
                    left join client as wh on wh.clientid = stock.whid
                    left join item on item.itemid=stock.itemid
                    where head.doc='rr' and md5(head.trno)='$trno' order by line
                ");
        return $result;
    }
    public static function rptReceivingconsignment($_) {

        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from lahead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                    union all
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from lbhead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                    union all
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from lchead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                    union all
                    select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from (glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid
                    where  md5(head.trno)='$trno'
                    union all
                    select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from (hglhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid
                    where head.doc='rr' and md5(head.trno)='$trno' order by line
                ");
        return $result;
    }
    public static function rptInventoryadjusment($_) {
            $trno=$_;
             $query="
                   select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from lahead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                    union all
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from lbhead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                    union all
                    select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from lchead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                    union all
                    select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from (glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid
                    where  md5(head.trno)='$trno'
                    union all
                    select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                    item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                    stock.uom, stock.disc, stock.ext, stock.line
                    from (hglhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid
                    where head.doc='aj' and md5(head.trno)='$trno' order by line
                    ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptInventorysetup($_) {
            $trno=$_;
             $query="
                   select head.docno, wh.clientname, head.dateid, head.rem, stock.barcode, stock.itemname, stock.cost as gross, stock.rrqty as qty, stock.uom, stock.disc, stock.ext, stock.line
                    from (lahead as head left join lastock as stock on stock.trno=head.trno) left join client as wh on wh.client=head.wh
                    where head.doc='is' and md5(head.trno)='$trno'
                    union all
                    select head.docno, wh.clientname, head.dateid, head.rem, item.barcode, stock.itemname, stock.cost as gross, stock.rrqty as qty, stock.uom, stock.disc, stock.ext, stock.line
                    from ((glhead as head left join glstock as stock on stock.trno=head.trno) left join item on item.itemid=stock.itemid) left join client as wh on wh.clientid=head.whid
                    where head.doc='is' and md5(head.trno)='$trno' order by line
                    ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptGeneraljournal($_) {
            $trno=$_;
             $query="
                   select head.trno, head.dateid, head.docno, head.clientname, head.address, head.yourref, left(coa.alias,2) as alias, coa.acno,
                    coa.acnoname, client.client, detail.ref, date(detail.postdate) as postdate, detail.checkno, detail.db, detail.cr, detail.line
                    from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                    left join coa on coa.acno=detail.acno)left join client on client.client=detail.client
                    where head.doc='gj' and md5(head.trno)='$trno'
                    union all
                    select head.trno, head.dateid, head.docno, head.clientname, head.address, head.yourref, left(coa.alias,2) as alias, coa.acno,
                    coa.acnoname, client.client, detail.ref, date(detail.postdate) as postdate, detail.checkno, detail.db, detail.cr, detail.line
                    from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                    left join coa on coa.acnoid=detail.acnoid)left join client on client.clientid=detail.clientid
                    where head.doc='gj' and md5(head.trno)='$trno' order by line
                    ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptDepositSlip($_) {
            $trno=$_;
             $query="
                   select head.trno, head.dateid, head.docno, coa.acnoname as clientname, coa.acno,
                    coa.acnoname, client.client, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.line,coa.alias
                    from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                    left join coa on coa.acno=detail.acno)left join client on client.client=detail.client
                    where head.doc='ds' and md5(head.trno)='$trno'
                    union all
                    select head.trno, head.dateid, head.docno, hcoa.acnoname as clientname, coa.acno,
                    coa.acnoname, client.client, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.line,coa.alias
                    from (((glhead as head left join gldetail as detail on detail.trno=head.trno)left join coa as hcoa on hcoa.acno=head.contra)
                    left join coa on coa.acnoid=detail.acnoid)left join client on client.clientid=detail.clientid
                    where head.doc='ds' and md5(head.trno)='$trno' order by line

                    ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rpt_po_module($_){
            $trno=$_;
             $query="
                    select head.trno, head.docno, date(head.dateid) as dateid, client.client, head.clientname, head.address,
                    client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, item.barcode,
                    stock.rrqty, stock.qty, stock.uom, stock.itemname, stock.rrcost, stock.cost, stock.ext
                    from ((pohead as head left join postock as stock on stock.trno=head.trno)
                    left join client on client.client=head.client)left join item on item.barcode=stock.barcode
                    where head.doc='po' and md5(head.trno)='$trno'
                    union all
                    select head.trno, head.docno, date(head.dateid) as dateid, client.client, head.clientname, head.address,
                    client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, item.barcode,
                    stock.rrqty, stock.qty, stock.uom, stock.itemname, stock.rrcost, stock.cost, stock.ext
                    from ((hpohead as head left join hpostock as stock on stock.trno=head.trno)
                    left join client on client.client=head.client)left join item on item.barcode=stock.barcode
                    where head.doc='po' and md5(head.trno)='$trno'
                    ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
        }
    public static function rptTransperslip($_) {
        $trno=$_;
             $query="
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,stock.line,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.cost as acost,stock.isamt as cost, stock.disc, stock.ext, stock.wh as swh
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='ts' and stock.tstrno=0 and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,stock.line,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.cost as acost,stock.isamt as cost, stock.disc, stock.ext, stock.wh as swh
                    from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='ts' and stock.tstrno=0 and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,stock.line,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.cost as acost,stock.isamt as cost, stock.disc, stock.ext, stock.wh as swh
                    from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='ts' and stock.tstrno=0 and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, item.barcode,stock.line,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.cost as acost,stock.isamt as cost, stock.disc, stock.ext, wh.client  as swh
                    from glhead as head left join glstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid
                    left join item on item.itemid=stock.itemid left join client as wh on wh.clientid=stock.whid
                    where head.doc='ts' and stock.tstrno=0 and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, item.barcode,stock.line,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.cost as acost,stock.isamt as cost, stock.disc, stock.ext, wh.client as swh
                    from hglhead as head left join hglstock as stock on stock.trno=head.trno left join client on client.clientid=head.clientid
                    left join item on item.itemid=stock.itemid left join client as wh on wh.clientid=stock.whid
                    where head.doc='ts' and stock.tstrno=0 and md5(head.trno)='$trno'
                    order by line
                    ";
             
             //echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }


    public static function rptTXRoutehead($trno){
        $qry="select head.rfdocno,head.dateid,head.rem,head.txchecker,head.txdriver,
                hhead.rf_approval as approval, hhead.client,hhead.clientname,hhead.route from txhead as head
                left join hrfhead as hhead on hhead.trno=head.rftrno
                where head.trno=".$trno."";
                
            $result=Yii::$app->sbccommon->opentable($qry);


            return $result;
    }

    public static function rptTXRoutedetails($trno){
        $qry="select route.client as code,case when route.no = '' then 0 else route.no end as no, route.clientname as customer,route.address,
            case when route.kilometers = '' then 0 else route.kilometers end as kilometers from tx_routeguide as route
            where route.txtrno=".$trno."
            order by no";



            $result=Yii::$app->sbccommon->opentable($qry);

            return $result;
    }

    public static function rptTXDispatch($trno){


        $qry="select head.docno,date(head.dateid) as sjdate,client.client,client.clientname
                ,txhead.txdispatchdate
                ,date(num.screceivedate) as screceivedate,date(num.scconfirmationdate) as scconfirmationdate,date(num.scsettleddate) as scsettleddate,num.scsettlednotes
                from lahead as head
                left join cntnum as num on num.trno = head.trno
                left join txhead on txhead.trno=num.txno
                left join client on client.client = head.client where txhead.txdispatchdate<>'' and num.doc = 'SJ'
                and num.txno =".$trno."
                union all
                select head.docno,date(head.dateid) as sjdate,client.client,client.clientname
                ,txhead.txdispatchdate
                ,date(num.screceivedate) as screceivedate,date(num.scconfirmationdate) as scconfirmationdate,date(num.scsettleddate) as scsettleddate,num.scsettlednotes
                from glhead as head
                left join cntnum as num on num.trno = head.trno
                left join txhead on txhead.trno=num.txno
                left join client on client.clientid = head.clientid where txhead.txdispatchdate<>'' and num.doc = 'SJ'
                and num.txno =".$trno."
                order by client";

            
                

                $txdc=Yii::$app->sbccommon->opentable($qry);

                // var_dump($result);
                // return 0;


        $qry2="select ifnull(hhead.route,'') as route,ifnull(hhead.docno,'') as rfdoc,head.docno,head.dateid,ifnull(concat(client,'~',clientname),'') as
                agent,head.txtruck as truck,head.txdriver as driver,
                head.rem as notes,hhead.yourref as approval,head.txdispatchdate as dispatch,head.txreturndate as returndate
                from txhead as head
                left join hrfhead as hhead on hhead.trno=head.rftrno
                where head.trno=".$trno."";

                // echo $qry2;
                // return 0;
                $head=Yii::$app->sbccommon->opentable($qry2);

                // var_dump($qry2);
                // return 0;

                $result=array('txdc'=>$txdc,'head'=>$head);
                return $result;

    }

public static function rptTXPostdelivery($trno){
        
        $qry='select head.docno,date(head.dateid) as sjdate,client.client,client.clientname,num.scdiscrepancydetails as details,num.scdiscrepancytype as type,num.scdiscrepancynotes as notes
            from lahead as head
            left join cntnum as num on num.trno = head.trno
            left join client on client.client = head.client
            where num.doc = "SJ" and num.txno='.$trno.'
            union all
            select head.docno,date(head.dateid) as sjdate,client.client,client.clientname,num.scdiscrepancydetails as details,num.scdiscrepancytype as type,num.scdiscrepancynotes as notes
            from glhead as head
            left join cntnum as num on num.trno = head.trno
            left join client on client.clientid = head.clientid
            where num.doc = "SJ" and num.txno='.$trno.'
            order by client';

        $txpdr=Yii::$app->sbccommon->opentable($qry);
        // var_dump($txpdr);
        // return 0;


            $qry2="select ifnull(hhead.route,'') as route,ifnull(hhead.docno,'') as rfdoc,head.docno,head.dateid,ifnull(concat(client,'~',clientname),'') as
                agent,head.txtruck as truck,head.txdriver as driver,
                head.rem as notes,hhead.yourref as approval,head.txdispatchdate as dispatch,head.txreturndate as returndate
                from txhead as head
                left join hrfhead as hhead on hhead.trno=head.rftrno
                where head.trno=".$trno."";

                $head=Yii::$app->sbccommon->opentable($qry2);

                // var_dump($head);
                // return 0;


            $result = array('txpdr'=>$txpdr,'head'=>$head);

            return $result;

            
    }

    public static function rptTXTransslip($trno){

         $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,head.client as custcode,head.clientname as custname,
                client.addr,round(sum(ifnull(stock.ext,0)),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as gtotal,
                head.rem from lahead as head
                left join lastock as stock on stock.trno = head.trno
                left join cntnum as num on num.trno = head.trno
                left join client on client.client = head.client
                where num.doc = 'SJ' and num.txno = ".$trno."
                group by num.trno
                UNION ALL
                select head.trno,head.docno,left(head.dateid,10) as dateid,client.client as custcode,head.clientname as custname,
                client.addr,round(sum(ifnull(stock.ext,0)),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as gtotal,
                head.rem from glhead as head
                left join glstock as stock on stock.trno = head.trno
                left join cntnum as num on num.trno = head.trno
                left join client on client.clientid = head.clientid
                where num.doc = 'SJ' and num.txno = ".$trno."
                group by num.trno";

        $invoices = Yii::$app->sbccommon->openTable($qry);


        $qry2 = "select head.docno,ifnull(hhead.docno,'') as rfno,head.dateid,ifnull(CONCAT(hhead.client,'~',hhead.clientname),'') as agent,head.txtruck as truck, head.txdriver as driver, head.rem as notes, ifnull(hhead.yourref,'') as approval,
            head.txdispatchdate as dispatch,head.txchecker as checker,hhead.route as route from txhead as head
            left join hrfhead as hhead on hhead.trno=head.rftrno
            where head.trno=".$trno."";

        
        $head = Yii::$app->sbccommon->openTable($qry2);




        // $grandtotaltons = 0;
        // $grantotalcbm = 0;

        if(!empty($invoices)){
            foreach ($invoices as $key => $value) {
                $invoices[$key]['gtotal'] = number_format($invoices[$key]['gtotal'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $invoices[$key]['gtonage'] = Yii::$app->backend->getGrandTotalTons('SJ',$value['trno']);
                $invoices[$key]['gcbm'] = Yii::$app->backend->getGrandTotalCBM('SJ',$value['trno']);
                // $grandtotaltons += floatval($grandtotaltons) + floatval($invoices[$key]['gtonage']);
                // $grantotalcbm += floatval($grantotalcbm) + floatval($invoices[$key]['gcbm']);
            }//end for each
        }//end if


        

        // $grandtotaltons = number_format($grandtotaltons,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        // $grantotalcbm = number_format($grantotalcbm,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        
        $result=array('invoice'=>$invoices,'head'=>$head);

        return $result;



    }
   
    public static function rptSalesorder($_) {
             $trno=$_;

             switch (Yii::$app->systemsettings->companyConfig()) {
                 case 'SOUTHCENTRAL':
                     $query="select head.docno,head.trno, head.clientname, head.address, date(head.dateid) as dateid, head.terms, head.rem,head.agent,head.wh,
                            stock.barcode, stock.itemname, stock.isamt as gross, stock.amt as netamt, stock.isqty as qty,
                            stock.uom, stock.disc, stock.ext, stock.line,item.brand,client.clientname as whname,ifnull(agent.clientname,'') as salesman,
                            case when stock.iss > stock.wh_currentqty then 1 else 0 end insuffqty
                            from sohead as head left join sostock as stock on stock.trno=head.trno 
                            left join item on item.barcode=stock.barcode
                            left join client as agent on agent.client=head.agent
                            left join client on client.client=stock.wh
                            where md5(head.trno)='$trno' group by client.client
                            union all 
                            select head.docno,head.trno, head.clientname, head.address, date(head.dateid) as dateid, head.terms, head.rem,head.agent,head.wh,
                            stock.barcode, stock.itemname, stock.isamt as gross, stock.amt as netamt, stock.isqty as qty,
                            stock.uom, stock.disc, stock.ext, stock.line,item.brand,client.clientname as whname,ifnull(agent.clientname,'') as salesman,
                            case when stock.iss > stock.wh_currentqty then 1 else 0 end insuffqty
                            from hsohead as head left join hsostock as stock on stock.trno=head.trno
                            left join item on item.barcode=stock.barcode 
                            left join client as agent on agent.client=head.agent
                            left join client on client.client=stock.wh
                            where head.doc='so' and md5(head.trno)='$trno' order by whname,line";
                     break;
                 
                 default:
                     $query="select head.docno,head.trno, head.clientname, head.address, date(head.dateid) as dateid, head.terms, head.rem,head.agent,head.wh,
                            stock.barcode, stock.itemname, stock.isamt as gross, stock.amt as netamt, stock.isqty as qty,
                            stock.uom, stock.disc, stock.ext, stock.line,item.brand,client.clientname as whname
                            from sohead as head left join sostock as stock on stock.trno=head.trno 
                            left join item on item.barcode=stock.barcode
                            left join client on client.client=head.wh
                            where md5(head.trno)='$trno'
                            union all
                            select head.docno,head.trno, head.clientname, head.address, date(head.dateid) as dateid, head.terms, head.rem,head.agent,head.wh,
                            stock.barcode, stock.itemname, stock.isamt as gross, stock.amt as netamt, stock.isqty as qty,
                            stock.uom, stock.disc, stock.ext, stock.line,item.brand,client.clientname as whname
                            from hsohead as head left join hsostock as stock on stock.trno=head.trno
                            left join item on item.barcode=stock.barcode 
                            left join client on client.client=head.wh
                            where head.doc='so' and md5(head.trno)='$trno' order by line";
                     break;
             }//END SWITCH CASEA

            

            $result=Yii::$app->sbccommon->opentable($query);

            if(!empty($result)){
            foreach ($result as $key => $value) {
                $result[$key]['gtonage'] = Yii::$app->backend->getGrandTotalTons('SO',$value['trno']);
                // $grandtotaltons += floatval($grandtotaltons) + floatval($invoices[$key]['gtonage']);
                // $grantotalcbm += floatval($grantotalcbm) + floatval($invoices[$key]['gcbm']);
            }//end for each
            }//end if
            return $result;
    }
    
    public static function rptSalesreturn($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.rem,head.yourref,head.ourref, stock.barcode,item.brand,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, stock.ref,ag.clientname as agname,ag.client as agcode,wh.client as whcode,wh.clientname as whname
                from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                left join client as ag on ag.client=head.agent left join client as wh on wh.client=stock.wh
                left join item on item.barcode=stock.barcode
                where head.doc='cm' and md5(head.trno)='$trno'
                union all
                select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.rem,head.yourref,head.ourref, stock.barcode,item.brand,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, stock.ref,ag.clientname as agname,ag.client as agcode,wh.client as whcode,wh.clientname as whname
                from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                left join client as ag on ag.client=head.agent left join client as wh on wh.client=stock.wh
                left join item on item.barcode=stock.barcode
                where head.doc='cm' and md5(head.trno)='$trno'
                union all
                select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.rem,head.yourref,head.ourref, stock.barcode,item.brand,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, stock.ref,ag.clientname as agname,ag.client as agcode,wh.client as whcode,wh.clientname as whname
                from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                left join client as ag on ag.client=head.agent left join client as wh on wh.client=stock.wh
                left join item on item.barcode=stock.barcode
                where head.doc='cm' and md5(head.trno)='$trno'
                union all
                select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.rem,head.yourref,head.ourref, item.barcode,item.brand,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, stock.ref,ag.clientname as agname,ag.client as agcode,wh.client as whcode,wh.clientname as whname
                from glhead as head left join glstock as stock on stock.trno=head.trno
                left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=stock.whid
                where head.doc='cm' and md5(head.trno)='$trno'
                union all
                select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.rem,head.yourref,head.ourref, item.barcode,item.brand,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, stock.ref,ag.clientname as agname,ag.client as agcode,wh.client as whcode,wh.clientname as whname
                from hglhead as head left join hglstock as stock on stock.trno=head.trno
                left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=stock.whid
                where head.doc='cm' and md5(head.trno)='$trno'
                ");
        return $result;
    }
public static function rptSalesinvoice($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname,stock.ref
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname,stock.ref
                    from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname,stock.ref
                    from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, item.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, ag.client as agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname,stock.ref
                    from glhead as head left join glstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=head.whid
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, item.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, ag.client as agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname,stock.ref
                    from hglhead as head left join hglstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=head.whid
                    where head.doc='sj' and md5(head.trno)='$trno'
                ");

        if(!empty($result)){
            foreach ($result as $key => $value) {
                $result[$key]['discountedamt'] = Yii::$app->sbccommon->Discount($value['amt'],$value['disc']);
            }//end for each
        }//end if
        return $result;
    }

public static function rptSalesinvoiceyulick($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,left(head.dateid,10) as dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.rem as itemname, stock.isqty as qty,stock.isqty2 as qty2, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,left(head.dateid,10) as dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.rem as itemname, stock.isqty as qty,stock.isqty2 as qty2, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,left(head.dateid,10) as dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.rem as itemname, stock.isqty as qty,stock.isqty2 as qty2, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,left(head.dateid,10) as dateid, head.docno, client.client, client.clientname, head.address, head.terms, item.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.rem as itemname, stock.isqty as qty,stock.isqty2 as qty2, stock.uom, stock.isamt as amt, stock.disc, stock.ext, ag.client as agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from glhead as head left join glstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=head.whid
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,left(head.dateid,10) as dateid, head.docno, client.client, client.clientname, head.address, head.terms, item.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.rem as itemname, stock.isqty as qty,stock.isqty2 as qty2, stock.uom, stock.isamt as amt, stock.disc, stock.ext, ag.client as agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from hglhead as head left join hglstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=head.whid
                    where head.doc='sj' and md5(head.trno)='$trno'
                    order by line
                ");
        return $result;
    }


    public static function rptSalesinvoiceinfinitea($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    union all
                    select stock.line,stock.rem as srem,head.rem,date_format(head.dateid,'%m/%d') as monthid,right(year(head.dateid),2) as year,head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='sj' and md5(head.trno)='$trno'
                    order by line
                ");
        return $result;
    }
    public static function rptCashinvoice($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lahead as head left join lastock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='ch' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lbhead as head left join lbstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='ch' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.client, client.clientname, head.address, head.terms, stock.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, head.agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from lchead as head left join lcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    left join item on item.barcode=stock.barcode left join client as ag on ag.client=head.agent left join client as wh on wh.client=head.wh
                    where head.doc='ch' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.client, client.clientname, head.address, head.terms, item.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, ag.client as agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from glhead as head left join glstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=head.whid
                    where head.doc='ch' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, concat(left(head.docno,4),right(head.docno,5)) as docno, client.client, client.clientname, head.address, head.terms, item.barcode, head.shipto, client.tin, head.yourref, head.ourref,
                    stock.itemname, stock.isqty as qty, stock.uom, stock.isamt as amt, stock.disc, stock.ext, ag.client as agent, item.sizeid, ag.clientname as agname, item.brand, wh.client as whcode, wh.clientname as whname
                    from hglhead as head left join hglstock as stock on stock.trno=head.trno
                    left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
                    left join client as ag on ag.clientid=head.agentid left join client as wh on wh.clientid=head.whid
                    where head.doc='ch' and md5(head.trno)='$trno'
                ");
        return $result;
    }
    

     public static function rptCashVoucher($_) {
        $trno=$_;
        $query ="select detail.rem as drem,DATE_FORMAT(left(detail.postdate,10),'%b %d %Y') as pdate,detail.ref,head.trno, head.docno, date(head.dateid) as dateid, date(cntnum.postdate) as postdate,client.client, head.clientname, head.address,
                client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
                detail.acnoname, detail.rem as drem,round(detail.db,2) as db,round(detail.cr,2) as cr, detail.checkno, left(coa.alias,2) as alias
                from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
                left join client on client.client=head.client)left join coa on coa.acno=detail.acno
                left join cntnum on cntnum.trno=head.trno
                where head.doc='cv' and md5(head.trno)='$trno'
                union all
                select detail.rem as drem,DATE_FORMAT(left(detail.postdate,10),'%b %d %Y') as pdate,detail.ref,head.trno, head.docno, date(head.dateid) as dateid, date(cntnum.postdate) as postdate,client.client, head.clientname, head.address,
                client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
                detail.acnoname, detail.rem as drem, round(detail.db,2) as db,round(detail.cr,2) as cr, detail.checkno, left(coa.alias,2) as alias
                from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
                left join client on client.client=head.client)left join coa on coa.acno=detail.acno
                left join cntnum on cntnum.trno=head.trno
                where head.doc='cv' and md5(head.trno)='$trno'
                union all
                select detail.rem as drem,DATE_FORMAT(left(detail.postdate,10),'%b %d %Y') as pdate,detail.ref,head.trno, head.docno, date(head.dateid) as dateid, date(cntnum.postdate) as postdate,client.client, head.clientname, head.address,
                client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
                detail.acnoname, detail.rem as drem, round(detail.db,2) as db,round(detail.cr,2) as cr, detail.checkno, left(coa.alias,2) as alias
                from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
                left join client on client.client=head.client)left join coa on coa.acno=detail.acno
                left join cntnum on cntnum.trno=head.trno
                where head.doc='cv' and md5(head.trno)='$trno'
                union all
                select detail.rem as drem,DATE_FORMAT(left(detail.postdate,10),'%b %d %Y') as pdate,detail.ref,head.trno, head.docno, date(head.dateid) as dateid, date(cntnum.postdate) as postdate,client.client, head.clientname, head.address,
                client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
                detail.acnoname, detail.rem as drem,round(detail.db,2) as db,round(detail.cr,2) as cr, detail.checkno, left(coa.alias,2) as alias
                from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
                left join client on client.clientid=head.clientid)left join coa on coa.acnoid=detail.acnoid
                left join cntnum on cntnum.trno=head.trno
                where head.doc='cv' and md5(head.trno)='$trno'
                union all
                select detail.rem as drem,DATE_FORMAT(left(detail.postdate,10),'%b %d %Y') as pdate,detail.ref,head.trno, head.docno, date(head.dateid) as dateid, date(cntnum.postdate) as postdate,client.client, head.clientname, head.address,
                client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
                detail.acnoname, detail.rem as drem,round(detail.db,2) as db,round(detail.cr,2) as cr, detail.checkno, left(coa.alias,2) as alias
                from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
                left join client on client.clientid=head.clientid)left join coa on coa.acnoid=detail.acnoid
                left join cntnum on cntnum.trno=head.trno
                where head.doc='cv' and md5(head.trno)='$trno'";
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }//end cash voucher

    public static function rptcheckvoucher($_){

            $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
        select head.trno, head.docno, head.dateid, client.client, head.clientname, head.address,
        client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
        detail.acnoname, detail.rem as drem, detail.db, detail.cr, detail.checkno, left(coa.alias,2) as alias
        from ((lahead as head left join ladetail as detail on detail.trno=head.trno)
        left join client on client.client=head.client)left join coa on coa.acno=detail.acno
        where head.doc='cv' and md5(head.trno)='$trno'
        union all
        select head.trno, head.docno, head.dateid, client.client, head.clientname, head.address,
        client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
        detail.acnoname, detail.rem as drem, detail.db, detail.cr, detail.checkno, left(coa.alias,2) as alias
        from ((lbhead as head left join lbdetail as detail on detail.trno=head.trno)
        left join client on client.client=head.client)left join coa on coa.acno=detail.acno
        where head.doc='cv' and md5(head.trno)='$trno'
        union all
        select head.trno, head.docno, head.dateid, client.client, head.clientname, head.address,
        client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
        detail.acnoname, detail.rem as drem, detail.db, detail.cr, detail.checkno, left(coa.alias,2) as alias
        from ((lchead as head left join lcdetail as detail on detail.trno=head.trno)
        left join client on client.client=head.client)left join coa on coa.acno=detail.acno
        where head.doc='cv' and md5(head.trno)='$trno'
        union all
        select head.trno, head.docno, head.dateid, client.client, head.clientname, head.address,
        client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
        detail.acnoname, detail.rem as drem, detail.db, detail.cr, detail.checkno, left(coa.alias,2) as alias
        from ((glhead as head left join gldetail as detail on detail.trno=head.trno)
        left join client on client.clientid=head.clientid)left join coa on coa.acnoid=detail.acnoid
        where head.doc='cv' and md5(head.trno)='$trno'
        union all
        select head.trno, head.docno, head.dateid, client.client, head.clientname, head.address,
        client.tin, '' as busstyle, head.terms, head.yourref, head.ourref, head.rem, coa.acno,
        detail.acnoname, detail.rem as drem, detail.db, detail.cr, detail.checkno, left(coa.alias,2) as alias
        from ((hglhead as head left join hgldetail as detail on detail.trno=head.trno)
        left join client on client.clientid=head.clientid)left join coa on coa.acnoid=detail.acnoid
        where head.doc='cv' and md5(head.trno)='$trno'

                    ");
            return $result;
        }
    public static function rptReceivedpayment($_) {
            $trno=$_;
             $query="
                    select head.trno, head.dateid, head.docno, head.clientname, head.address, head.yourref,head.ourref, left(coa.alias, 2) as alias, coa.acno, coa.acnoname, coa.alias as ali,
                    client.client, detail.ref, date(detail.postdate) as postdate, detail.checkno, detail.db, detail.cr, detail.line
                    from ((lahead as head left join ladetail as detail on detail.trno=head.trno) left join coa on coa.acno=detail.acno) left join client on client.client=detail.client
                    where head.doc='cr' and md5(head.trno)='$trno'
                    union all
                    select head.trno, head.dateid, head.docno, head.clientname, head.address, head.yourref,head.ourref, left(coa.alias, 2) as alias, coa.acno, coa.acnoname, coa.alias as ali,
                    client.client, detail.ref, date(detail.postdate) as postdate, detail.checkno, detail.db, detail.cr, detail.line
                    from ((glhead as head left join gldetail as detail on detail.trno=head.trno) left join coa on coa.acnoid=detail.acnoid)
                    left join client on client.clientid=detail.clientid where head.doc='cr' and md5(head.trno)='$trno' order by line
                    ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptCounterreceipt($_) {
            $trno=$_;
             $query="
                   select head.client,date(head.dateid) as dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, head.clientname, head.address, head.yourref, head.ourref,
            coa.acno, coa.acnoname, ar.db, ar.cr, date(ar.dateid) as postdate, ar.docno as ref
            from (krhead as head left join arledger as ar on ar.kr=head.trno)left join coa on coa.acnoid=ar.acnoid
            where md5(head.trno)='$trno'
            union all
            select head.client,date(head.dateid) as dateid, concat(left(head.docno,3),right(head.docno,5)) as docno, head.clientname, head.address, head.yourref, head.ourref,
            coa.acno, coa.acnoname, ar.db, ar.cr, date(ar.dateid) as postdate, ar.docno as ref
            from (hkrhead as head left join arledger as ar on ar.kr=head.trno)left join coa on coa.acnoid=ar.acnoid
            where md5(head.trno)='$trno' order by postdate,dateid, docno
                    ";
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }
    public static function rptPhysicalcount($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select date(head.dateid) as dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as cost, stock.disc, stock.ext
                    from pchead as head left join pcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='pc' and md5(head.trno)='$trno'
                    union all
                    select date(head.dateid) as dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                    stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as cost, stock.disc, stock.ext
                    from hpchead as head left join hpcstock as stock on stock.trno=head.trno left join client on client.client=head.client
                    where head.doc='pc' and md5(head.trno)='$trno'
                    
                ");
        return $result;
    }
    public static function rptAccountspayablevoucher($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,detail.rem, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, detail.postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lahead as head left join ladetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='pv' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,detail.rem, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, detail.postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lbhead as head left join lbdetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='pv' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,detail.rem, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, detail.postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lchead as head left join lcdetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='pv' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,detail.rem, head.yourref, head.ourref,
                    coa.acno, coa.acnoname, detail.ref, detail.postdate, detail.db, detail.cr, dclient.client as dclient, detail.checkno
                    from glhead as head left join gldetail as detail on detail.trno=head.trno left join client on client.clientid=head.clientid
                    left join coa on coa.acnoid=detail.acnoid left join client as dclient on dclient.clientid=detail.clientid
                    where head.doc='pv' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms,detail.rem, head.yourref, head.ourref,
                    coa.acno, coa.acnoname, detail.ref, detail.postdate, detail.db, detail.cr, dclient.client as dclient, detail.checkno
                    from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join client on client.clientid=head.clientid
                    left join coa on coa.acnoid=detail.acnoid left join client as dclient on dclient.clientid=detail.clientid
                    where head.doc='pv' and md5(head.trno)='$trno'
                ");
        return $result;
    }
    public static function rptAPsetup($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lahead as head left join ladetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='ap' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lbhead as head left join lbdetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='ap' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lchead as head left join lcdetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='ap' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    coa.acno, coa.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, dclient.client as dclient, detail.checkno
                    from glhead as head left join gldetail as detail on detail.trno=head.trno left join client on client.clientid=head.clientid
                    left join coa on coa.acnoid=detail.acnoid left join client as dclient on dclient.clientid=detail.clientid
                    where head.doc='ap' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    coa.acno, coa.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, dclient.client as dclient, detail.checkno
                    from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join client on client.clientid=head.clientid
                    left join coa on coa.acnoid=detail.acnoid left join client as dclient on dclient.clientid=detail.clientid
                    where head.doc='ap' and md5(head.trno)='$trno'
                ");
    
        return $result;
    }
    public static function rptARsetup($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lahead as head left join ladetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='ar' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lbhead as head left join lbdetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='ar' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    detail.acno, detail.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, detail.client as dclient, detail.checkno
                    from lchead as head left join lcdetail as detail on detail.trno=head.trno left join client on client.client=head.client
                    where head.doc='ar' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    coa.acno, coa.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, dclient.client as dclient, detail.checkno
                    from glhead as head left join gldetail as detail on detail.trno=head.trno left join client on client.clientid=head.clientid
                    left join coa on coa.acnoid=detail.acnoid left join client as dclient on dclient.clientid=detail.clientid
                    where head.doc='ar' and md5(head.trno)='$trno'
                    union all
                    select head.dateid, head.docno, client.client, client.clientname, head.address, head.terms, head.yourref, head.ourref,
                    coa.acno, coa.acnoname, detail.ref, date(detail.postdate) as postdate, detail.db, detail.cr, dclient.client as dclient, detail.checkno
                    from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join client on client.clientid=head.clientid
                    left join coa on coa.acnoid=detail.acnoid left join client as dclient on dclient.clientid=detail.clientid
                    where head.doc='ar' and md5(head.trno)='$trno'
                ");
        
        return $result;
    }
    public static function rptexpenses($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select trno,docno,date_format(dateid,'%m/%d/%y')as dateid,amount,description from expenses
                    where trno='$trno'
                    union all
                    select trno,docno,date_format(dateid,'%m/%d/%y')as dateid,amount,description from hexpenses
                    where trno='$trno'
                    ");
        return $result;
    }
    public static function rptagentledger($_) {
       $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select client.client,client.clientname,client.addr,client.tel,client.tel2,client.tin,client.mobile,client.rem,
                    client.email,client.contact,client.fax,client.start,client.status,client.quota,
                    client.area,client.province,client.region,client.groupid,client.issupplier,client.iscustomer,
                    client.isagent,client.isemployee
                    from client where md5(client.clientid)='$trno'
                    ");
        return $result;
    }




    public static function rptwarehouse($_) {
        $trno=$_;
        $result = Yii::$app->sbccommon->opentable("
                    select client.client,client.clientname,client.addr,client.tel,client.tin,client.rem,
                    client.mobile,client.email,client.contact,client.fax,
                    client.start,client.status,client.area,client.province,client.region,
                    client.groupid,client.issupplier,client.iscustomer,client.iswarehouse
                    from client where md5(client.clientid)='$trno'
                    ");
        return $result;
    }
    
    public static function rptsupplierledger($_,$params,$center) {  
        $clientid=$_;
        $start=$params['startdate'];
        $type=$params['reporttype'];

        //var_dump($_POST);
        switch($params['reporttype']){
                        case 'ar':{
                            $query="
                                    select t.trno, t.line, t.doc, t.docno, date_format(t.dateid,'%m/%d/%y') as dateid, t.db, t.cr, t.bal, t.ref,
                                    t.agent, t.rem, t.status,client.client,client.clientname,client.addr,client.tel,client.tel2,client.tin,client.mobile,
                                    client.email,client.contact,client.fax from
                                    (
                                    select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,
                                    `arledger`.`line` as `line`,`arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,
                                    `arledger`.`cr` as `cr`,arledger.bal,
                                    `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
                                    (`detail`.`rem`) as `rem`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
                                    0 as `fbal`,`head`.`ourref` as `reference`,'posted' as `status` from ((((`arledger`
                                    left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
                                    on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
                                    left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
                                    on((`agent`.`clientid` = `arledger`.`agentid`))) left join client on client.clientid = arledger.clientid where md5(arledger.clientid)= '$clientid'  and arledger.dateid>='$start'
                                    union all
                                    select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                    `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                    `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                    abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                    from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                    left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                    left join cntnum on cntnum.trno = head.trno where md5(client.clientid)= '$clientid'  and head.dateid>='$start' and
                                    left(`coa`.`alias`,2) = 'ar'                                     union all
                                    select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                    `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                    `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                    abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status` from
                                    (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                                    on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                    left join cntnum on cntnum.trno = head.trno where md5(client.clientid)= '$clientid'  and head.dateid>='$start'
                                    and left(`coa`.`alias`,2) = 'ar'
                                    union all
                                    select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                    `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                    `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                    abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                    from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                    left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                    left join cntnum on cntnum.trno = head.trno where md5(client.clientid)= '$clientid'  and head.dateid>='$start' and
                                    left(`coa`.`alias`,2) = 'ar'
                                    union all
                                    select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
                                    `arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,`arledger`.`cr` as `cr`,arledger.bal,
                                    `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,(`detail`.`rem`) as `rem`,
                                    ((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,0 as `fbal`,
                                    `head`.`ourref` as `reference`,'posted' as `status` from hglhead as head
                                    left join hgldetail as detail on detail.trno = head.trno left join `cntnum` on `cntnum`.`trno` = `head`.`trno`
                                    left join arledger on arledger.trno = detail.trno and arledger.line = detail.line
                                    left join `client` `agent` on `agent`.`clientid` = `arledger`.`agentid` left join client on client.clientid = arledger.clientid where
                                    md5(arledger.clientid)= '$clientid'  and arledger.dateid>='$start'
                                    ) as t left join client on client.clientid = t.clientid  order by dateid, docno
                            ";
                            break;
                        }
                        case 'ap':{
                            $query="
                                select t.trno, t.line, t.doc, t.docno, date_format(t.dateid,'%m/%d/%y') as dateid, t.db, t.cr, t.bal, t.ref, t.rem, t.status,client.client,client.agent,client.clientname,client.addr,client.tel,client.tel2,client.tin,client.mobile,client.email,client.contact,client.fax from
                                (select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
                                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as agent,
                                (`detail`.`rem`) as `rem`,((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,
                                0 as `fbal`,`head`.`ourref` as `reference`,'posted' as `status` from ((((`apledger`
                                left join `cntnum` on((`cntnum`.`trno` = `apledger`.`trno`))) left join `gldetail` as detail
                                on(((`detail`.`trno` = `apledger`.`trno`) and (`detail`.`line` = `apledger`.`line`))))
                                left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`)))) left join client on client.clientid = apledger.clientid where md5(apledger.clientid)='$clientid' and apledger.dateid>='$start'
                                union all
                                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                left join cntnum on cntnum.trno = head.trno where md5(client.clientid)='$clientid' and head.dateid>='$start' and
                                left(`coa`.`alias`,2) = 'ap'  
                                union all
                                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status` from
                                (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                                on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                left join cntnum on cntnum.trno = head.trno where md5(client.clientid)='$clientid'  and head.dateid>='$start'
                                and left(`coa`.`alias`,2) = 'ap' 
                                union all
                                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                left join cntnum on cntnum.trno = head.trno where md5(client.clientid)='$clientid' and head.dateid>='$start' and
                                left(`coa`.`alias`,2) = 'ap' 
                                union all
                                select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
                                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as `agent`,(`detail`.`rem`) as `rem`,
                                ((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,0 as `fbal`,
                                `head`.`ourref` as `reference`,'posted' as `status` from hglhead as head
                                left join hgldetail as detail on detail.trno = head.trno left join `cntnum` on `cntnum`.`trno` = `head`.`trno`
                                left join apledger on apledger.trno = detail.trno and apledger.line = detail.line left join client on client.clientid = apledger.clientid
                                where  md5(apledger.clientid)='$clientid'  and apledger.dateid>='$start'
                                ) as t left join client on client.clientid = t.clientid  order by dateid, docno
                            ";
                            break;
                        }
                        case 'pdc':{
                            $query="
                                select customerpdc.trno, customerpdc.doc, customerpdc.docno, customerpdc.checkno, customerpdc.checkdate, customerpdc.db, customerpdc.cr,ifnull(customerpdc.rem,'') as rem,client.client,client.clientname,client.addr,client.tel,client.tel2,client.tin,client.mobile,client.email,client.contact,client.bal,client.fax from (
                                select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno, gldetail.postdate as checkdate, gldetail.db,
                                gldetail.cr,crledger.depodate,concat(`gldetail`.`rem`,'  ',`deposit`.`docno`) as rem,client.clientid
                                from glhead left join gldetail on gldetail.trno=glhead.trno  left join crledger on crledger.trno=gldetail.trno
                                left join client on client.clientid = gldetail.clientid left join coa on coa.acnoid=gldetail.acnoid left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line where left(coa.alias,2)='cr' and crledger.depodate is null and glhead.doc='cr'
                                union
                                select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate, ladetail.db,
                                ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid
                                from lahead left join ladetail on ladetail.trno=lahead.trno left join client on client.client = ladetail.client
                                left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='cr'
                                union all
                                select lbhead.doc,coa.alias,lbhead.trno, lbhead.docno, lbdetail.checkno, lbdetail.postdate, lbdetail.db,
                                lbdetail.cr,null as depodate,lbdetail.rem as rem,client.clientid
                                from lbhead left join lbdetail on lbdetail.trno=lbhead.trno left join client on client.client = lbdetail.client
                                left join coa on coa.acno=lbdetail.acno where left(coa.alias,2)='cr'
                                union all
                                select lchead.doc,coa.alias,lchead.trno, lchead.docno, lcdetail.checkno, lcdetail.postdate, lcdetail.db,
                                lcdetail.cr,null as depodate,lcdetail.rem as rem,client.clientid
                                from lchead left join lcdetail on lcdetail.trno=lchead.trno left join client on client.client = lcdetail.client
                                left join coa on coa.acno=lcdetail.acno where left(coa.alias,2)='cr') as customerpdc left join client on client.clientid = customerpdc.clientid where md5(client.clientid) ='$clientid' and  checkdate>='$start'
                            ";
                            break;
                        }
                        case 'rc':{
                            $query="
                                select `cntnum`.`doc` as `doc`,`arledger`.`docno` as `docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,`arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,
                                `arledger`.`cr` as `cr`,(case when (`arledger`.`bal` = 0) then 'applied' else ltrim(`arledger`.`bal`) end) as `bal`,`arledger`.`clientid` as `clientid`,
                                arledger.ref as `ref`,agent.client as `agent`,`gldetail`.`rem` as `rem`,
                                `arledger`.`bal` as `balance` from (((`arledger` left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`)))
                                left join `coa` on((`coa`.`acnoid` = `arledger`.`acnoid`))) left join `gldetail` on(((`gldetail`.`trno` = `arledger`.`trno`)
                                and (`gldetail`.`line` = `arledger`.`line`)))) left join client as agent on agent.clientid = arledger.agentid where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and glhead.dateid>='$start' and cntnum.center = '$center'
                                union all
                                select `lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,`lahead`.`trno` as `trno`,`ladetail`.`line` as `line`,`lahead`.`dateid` as `dateid`,`ladetail`.`db` as `db`,
                                `ladetail`.`cr` as `cr`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`ladetail`.`ref` as `ref`,'' as `agent`,
                                `ladetail`.`rem` as `rem`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `balance`
                                from (((`lahead` left join `ladetail` on((`ladetail`.`trno` = `lahead`.`trno`)))
                                left join `client` on((`client`.`client` = `ladetail`.`client`)))
                                left join `coa` on((`coa`.`acno` = `ladetail`.`acno`))) where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and lahead.dateid>='$start' and cntnum.center = '$center'
                                union all
                                select `lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,`lbhead`.`trno` as `trno`,`lbdetail`.`line` as `line`,`lbhead`.`dateid` as `dateid`,`lbdetail`.`db` as `db`,
                                `lbdetail`.`cr` as `cr`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lbdetail`.`ref` as `ref`,'' as `agent`,
                                `lbdetail`.`rem` as `rem`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `balance`
                                 from (((`lbhead` left join `lbdetail` on((`lbdetail`.`trno` = `lbhead`.`trno`)))
                                 left join `client` on((`client`.`client` = `lbdetail`.`client`)))
                                 left join `coa` on((`coa`.`acno` = `lbdetail`.`acno`))) where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and lbhead.dateid>='$start' and cntnum.center = '$center'
                                 union all
                                 select `lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,`lchead`.`trno` as `trno`,`lcdetail`.`line` as `line`,`lchead`.`dateid` as `dateid`,`lcdetail`.`db` as `db`,
                                `lcdetail`.`cr` as `cr`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lcdetail`.`ref` as `ref`,'' as `agent`,
                                `lcdetail`.`rem` as `rem`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `balance`
                                from (((`lchead` left join `lcdetail` on((`lcdetail`.`trno` = `lchead`.`trno`)))
                                left join `client` on((`client`.`client` = `lcdetail`.`client`)))
                                left join `coa` on((`coa`.`acno` = `lcdetail`.`acno`))) where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and lbhead.dateid>='$start' and cntnum.center = '$center'
                            ";
                            break;
                        }
                        case 'stock':{
                            $query="
                                select `glhead`.`trno` as `trno`,`glhead`.`doc` as `doc`,`glhead`.`clientid` as `clientid`,
                                `glhead`.`docno` as `docno`,`glhead`.`dateid` as `dateid`,
                                `item`.`barcode` as `barcode`,`glstock`.`itemname` as `itemname`,`glstock`.`uom` as `uom`,
                                `glstock`.`disc` as `disc`,`glstock`.`cost` as `cost`,`glstock`.`isamt` as `isamt`,
                                `glstock`.`isqty` as `isqty`,`glstock`.`rrqty` as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,
                                client.mobile,client.contact,client.rem,client.fax
                                from ((`glstock` left join `glhead` on((`glstock`.`trno` = `glhead`.`trno`)))
                                left join `item` on((`item`.`itemid` = `glstock`.`itemid`)))
                                left join client on client.clientid = glhead.clientid
                                left join cntnum on cntnum.trno = glhead.trno
                                where  md5(client.clientid) ='$clientid' and glhead.dateid>='$start' and cntnum.center ='$center'
                                union all
                                select `lahead`.`trno` as `trno`,`lahead`.`doc` as `doc`,`client`.`clientid` as `clientid`,
                                `lahead`.`docno` as `docno`,`lahead`.`dateid` as `dateid`,`lastock`.`barcode` as `barcode`,
                                `lastock`.`itemname` as `itemname`,`lastock`.`uom` as `uom`,`lastock`.`disc` as `disc`,
                                `lastock`.`cost` as `cost`,`lastock`.`isamt` as `isamt`,`lastock`.`isqty` as `isqty`,lastock.rrqty as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                from ((`lastock` left join `lahead` on((`lastock`.`trno` = `lahead`.`trno`)))
                                left join `client` on((`client`.`client` = `lahead`.`client`))) left join cntnum on cntnum.trno = lahead.trno
                                where  md5(client.clientid) ='$clientid' and lahead.dateid>='$start' and cntnum.center ='$center'
                                union all
                                select `lbhead`.`trno` as `trno`,`lbhead`.`doc` as `doc`,`client`.`clientid` as `clientid`,
                                `lbhead`.`docno` as `docno`,`lbhead`.`dateid` as `dateid`,`lbstock`.`barcode` as `barcode`,
                                `lbstock`.`itemname` as `itemname`,`lbstock`.`uom` as `uom`,`lbstock`.`disc` as `disc`,
                                `lbstock`.`cost` as `cost`,`lbstock`.`isamt` as `isamt`,`lbstock`.`isqty` as `isqty`,lbstock.rrqty as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                from ((`lbstock` left join `lbhead` on((`lbstock`.`trno` = `lbhead`.`trno`)))
                                left join `client` on((`client`.`client` = `lbhead`.`client`))) left join cntnum on cntnum.trno = lbhead.trno
                                where  md5(client.clientid) ='$clientid' and lbhead.dateid>='$start' and cntnum.center ='$center'
                                union all
                                select `lchead`.`trno` as `trno`,`lchead`.`doc` as `doc`,`client`.`clientid` as `clientid`,
                                `lchead`.`docno` as `docno`,`lchead`.`dateid` as `dateid`,`lcstock`.`barcode` as `barcode`,
                                `lcstock`.`itemname` as `itemname`,`lcstock`.`uom` as `uom`,`lcstock`.`disc` as `disc`,
                                `lcstock`.`cost` as `cost`,`lcstock`.`isamt` as `isamt`,`lcstock`.`isqty` as `isqty`,lcstock.rrqty as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                from ((`lcstock` left join `lchead` on((`lcstock`.`trno` = `lchead`.`trno`)))
                                left join `client` on((`client`.`client` = `lchead`.`client`))) left join cntnum on cntnum.trno = lchead.trno
                                where md5(client.clientid) ='$clientid' and lchead.dateid>='$start' and cntnum.center ='$center' group by barcode

                            ";
                            break;
                        
                        }
        }
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
        
    }
    public static function rptcustomerledger($_,$params,$center) {
        $clientid=$_;
        $start=$params['startdate'];
        $type=$params['reporttype'];
        switch($params['reporttype']){
                        case 'ar':{
                            $query="
                                    select t.trno, t.line, t.doc, t.docno, date_format(t.dateid,'%m/%d/%y') as dateid, t.db, t.cr, t.bal, t.ref,
                                    t.agent, t.rem, t.status,client.client,client.clientname,client.addr,client.tel,client.tel2,client.tin,client.mobile,
                                    client.email,client.contact,client.fax from
                                    (
                                    select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,
                                    `arledger`.`line` as `line`,`arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,
                                    `arledger`.`cr` as `cr`,arledger.bal,
                                    `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
                                    (`detail`.`rem`) as `rem`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
                                    0 as `fbal`,`head`.`ourref` as `reference`,'posted' as `status` from ((((`arledger`
                                    left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
                                    on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
                                    left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
                                    on((`agent`.`clientid` = `arledger`.`agentid`))) left join client on client.clientid = arledger.clientid where md5(arledger.clientid)= '$clientid'  and arledger.dateid>='$start'
                                    and cntnum.center = '$center'
                                    union all
                                    select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                    `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                    `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                    abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                    from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                    left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                    left join cntnum on cntnum.trno = head.trno where md5(client.clientid)= '$clientid'  and head.dateid>='$start' and
                                    left(`coa`.`alias`,2) = 'ar'  and cntnum.center = '$center'
                                    union all
                                    select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                    `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                    `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                    abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status` from
                                    (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                                    on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                    left join cntnum on cntnum.trno = head.trno where md5(client.clientid)= '$clientid'  and head.dateid>='$start'
                                    and left(`coa`.`alias`,2) = 'ar'  and cntnum.center = '$center'
                                    union all
                                    select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                    `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                    `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                    abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                    from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                    left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                    left join cntnum on cntnum.trno = head.trno where md5(client.clientid)= '$clientid'  and head.dateid>='$start' and
                                    left(`coa`.`alias`,2) = 'ar'  and cntnum.center= '$center'
                                    union all
                                    select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
                                    `arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,`arledger`.`cr` as `cr`,arledger.bal,
                                    `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,(`detail`.`rem`) as `rem`,
                                    ((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,0 as `fbal`,
                                    `head`.`ourref` as `reference`,'posted' as `status` from hglhead as head
                                    left join hgldetail as detail on detail.trno = head.trno left join `cntnum` on `cntnum`.`trno` = `head`.`trno`
                                    left join arledger on arledger.trno = detail.trno and arledger.line = detail.line
                                    left join `client` `agent` on `agent`.`clientid` = `arledger`.`agentid` left join client on client.clientid = arledger.clientid where
                                    md5(arledger.clientid)= '$clientid'  and arledger.dateid>='$start'  and cntnum.center = '$center'
                                    ) as t left join client on client.clientid = t.clientid  order by dateid, docno
                            ";
                            break;
                        }
                        case 'ap':{
                            $query="
                                select t.trno, t.line, t.doc, t.docno, date_format(t.dateid,'%m/%d/%y') as dateid, t.db, t.cr, t.bal, t.ref, t.rem, t.status,client.client,client.agent,client.clientname,client.addr,client.tel,client.tel2,client.tin,client.mobile,client.email,client.contact,client.fax from
                                (select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
                                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as agent,
                                (`detail`.`rem`) as `rem`,((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,
                                0 as `fbal`,`head`.`ourref` as `reference`,'posted' as `status` from ((((`apledger`
                                left join `cntnum` on((`cntnum`.`trno` = `apledger`.`trno`))) left join `gldetail` as detail
                                on(((`detail`.`trno` = `apledger`.`trno`) and (`detail`.`line` = `apledger`.`line`))))
                                left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`)))) left join client on client.clientid = apledger.clientid where md5(apledger.clientid)='$clientid' and apledger.dateid>='$start'
                                and cntnum.center='$center'
                                union all
                                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                left join cntnum on cntnum.trno = head.trno where md5(client.clientid)='$clientid' and head.dateid>='$start' and
                                left(`coa`.`alias`,2) = 'ap'  and md5(cntnum.center) = '$center'
                                union all
                                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status` from
                                (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                                on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                left join cntnum on cntnum.trno = head.trno where md5(client.clientid)='$clientid'  and head.dateid>='$start'
                                and left(`coa`.`alias`,2) = 'ap'  and md5(cntnum.center)='$center'
                                union all
                                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                                `detail`.`db` as `db`,`detail`.`cr` as `cr`,round(abs((`detail`.`db` - `detail`.`cr`)),2) as `bal`,
                                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                                from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                                left join cntnum on cntnum.trno = head.trno where md5(client.clientid)='$clientid' and head.dateid>='$start' and
                                left(`coa`.`alias`,2) = 'ap'  and md5(cntnum.center) = '$center'
                                union all
                                select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
                                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as `agent`,(`detail`.`rem`) as `rem`,
                                ((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,0 as `fbal`,
                                `head`.`ourref` as `reference`,'posted' as `status` from hglhead as head
                                left join hgldetail as detail on detail.trno = head.trno left join `cntnum` on `cntnum`.`trno` = `head`.`trno`
                                left join apledger on apledger.trno = detail.trno and apledger.line = detail.line left join client on client.clientid = apledger.clientid
                                where  md5(apledger.clientid)='$clientid'  and apledger.dateid>='$start'  and md5(cntnum.center) = '$center'
                                ) as t left join client on client.clientid = t.clientid  order by dateid, docno
                            ";
                            break;
                        }
                        case 'pdc':{
                            $query="
                                select customerpdc.trno, customerpdc.doc, customerpdc.docno, customerpdc.checkno, customerpdc.checkdate, customerpdc.db, customerpdc.cr,ifnull(customerpdc.rem,'') as rem,client.client,client.clientname,client.addr,client.tel,client.tel2,client.tin,client.mobile,client.email,client.contact,client.bal,client.fax from (
                                select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno, gldetail.postdate as checkdate, gldetail.db,
                                gldetail.cr,crledger.depodate,concat(`gldetail`.`rem`,'  ',`deposit`.`docno`) as rem,client.clientid
                                from glhead left join gldetail on gldetail.trno=glhead.trno  left join crledger on crledger.trno=gldetail.trno
                                left join client on client.clientid = gldetail.clientid left join coa on coa.acnoid=gldetail.acnoid left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line where left(coa.alias,2)='cr' and crledger.depodate is null and glhead.doc='cr'
                                union
                                select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate, ladetail.db,
                                ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid
                                from lahead left join ladetail on ladetail.trno=lahead.trno left join client on client.client = ladetail.client
                                left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='cr'
                                union all
                                select lbhead.doc,coa.alias,lbhead.trno, lbhead.docno, lbdetail.checkno, lbdetail.postdate, lbdetail.db,
                                lbdetail.cr,null as depodate,lbdetail.rem as rem,client.clientid
                                from lbhead left join lbdetail on lbdetail.trno=lbhead.trno left join client on client.client = lbdetail.client
                                left join coa on coa.acno=lbdetail.acno where left(coa.alias,2)='cr'
                                union all
                                select lchead.doc,coa.alias,lchead.trno, lchead.docno, lcdetail.checkno, lcdetail.postdate, lcdetail.db,
                                lcdetail.cr,null as depodate,lcdetail.rem as rem,client.clientid
                                from lchead left join lcdetail on lcdetail.trno=lchead.trno left join client on client.client = lcdetail.client
                                left join coa on coa.acno=lcdetail.acno where left(coa.alias,2)='cr') as customerpdc left join client on client.clientid = customerpdc.clientid where md5(client.clientid) ='$clientid' and  checkdate>='$start'
                            ";
                            break;
                        }
                        case 'rc':{
                            $query="
                                select `cntnum`.`doc` as `doc`,`arledger`.`docno` as `docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,`arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,
                                `arledger`.`cr` as `cr`,(case when (`arledger`.`bal` = 0) then 'applied' else ltrim(`arledger`.`bal`) end) as `bal`,`arledger`.`clientid` as `clientid`,
                                arledger.ref as `ref`,agent.client as `agent`,`gldetail`.`rem` as `rem`,
                                `arledger`.`bal` as `balance` from (((`arledger` left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`)))
                                left join `coa` on((`coa`.`acnoid` = `arledger`.`acnoid`))) left join `gldetail` on(((`gldetail`.`trno` = `arledger`.`trno`)
                                and (`gldetail`.`line` = `arledger`.`line`)))) left join client as agent on agent.clientid = arledger.agentid where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and glhead.dateid>='$start' and cntnum.center = '$center'
                                union all
                                select `lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,`lahead`.`trno` as `trno`,`ladetail`.`line` as `line`,`lahead`.`dateid` as `dateid`,`ladetail`.`db` as `db`,
                                `ladetail`.`cr` as `cr`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`ladetail`.`ref` as `ref`,'' as `agent`,
                                `ladetail`.`rem` as `rem`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `balance`
                                from (((`lahead` left join `ladetail` on((`ladetail`.`trno` = `lahead`.`trno`)))
                                left join `client` on((`client`.`client` = `ladetail`.`client`)))
                                left join `coa` on((`coa`.`acno` = `ladetail`.`acno`))) where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and lahead.dateid>='$start' and cntnum.center = '$center'
                                union all
                                select `lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,`lbhead`.`trno` as `trno`,`lbdetail`.`line` as `line`,`lbhead`.`dateid` as `dateid`,`lbdetail`.`db` as `db`,
                                `lbdetail`.`cr` as `cr`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lbdetail`.`ref` as `ref`,'' as `agent`,
                                `lbdetail`.`rem` as `rem`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `balance`
                                 from (((`lbhead` left join `lbdetail` on((`lbdetail`.`trno` = `lbhead`.`trno`)))
                                 left join `client` on((`client`.`client` = `lbdetail`.`client`)))
                                 left join `coa` on((`coa`.`acno` = `lbdetail`.`acno`))) where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and lbhead.dateid>='$start' and cntnum.center = '$center'
                                 union all
                                 select `lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,`lchead`.`trno` as `trno`,`lcdetail`.`line` as `line`,`lchead`.`dateid` as `dateid`,`lcdetail`.`db` as `db`,
                                `lcdetail`.`cr` as `cr`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lcdetail`.`ref` as `ref`,'' as `agent`,
                                `lcdetail`.`rem` as `rem`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `balance`
                                from (((`lchead` left join `lcdetail` on((`lcdetail`.`trno` = `lchead`.`trno`)))
                                left join `client` on((`client`.`client` = `lcdetail`.`client`)))
                                left join `coa` on((`coa`.`acno` = `lcdetail`.`acno`))) where (`coa`.`alias` = 'arb')  and md5(client.clientid)= '$clientid'  and lbhead.dateid>='$start' and cntnum.center = '$center'
                            ";
                            break;
                        }
                        case 'stock':{
                            $query="
                                select `glhead`.`trno` as `trno`,`glhead`.`doc` as `doc`,`glhead`.`clientid` as `clientid`,
                                `glhead`.`docno` as `docno`,`glhead`.`dateid` as `dateid`,
                                `item`.`barcode` as `barcode`,`glstock`.`itemname` as `itemname`,`glstock`.`uom` as `uom`,
                                `glstock`.`disc` as `disc`,`glstock`.`cost` as `cost`,`glstock`.`isamt` as `isamt`,
                                `glstock`.`isqty` as `isqty`,`glstock`.`rrqty` as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,
                                client.mobile,client.contact,client.rem,client.fax
                                from ((`glstock` left join `glhead` on((`glstock`.`trno` = `glhead`.`trno`)))
                                left join `item` on((`item`.`itemid` = `glstock`.`itemid`)))
                                left join client on client.clientid = glhead.clientid
                                left join cntnum on cntnum.trno = glhead.trno
                                where md5(client.clientid) ='$clientid' and glhead.dateid>='$start' and cntnum.center ='$center'
                                union all
                                select `lahead`.`trno` as `trno`,`lahead`.`doc` as `doc`,`client`.`clientid` as `clientid`,
                                `lahead`.`docno` as `docno`,`lahead`.`dateid` as `dateid`,`lastock`.`barcode` as `barcode`,
                                `lastock`.`itemname` as `itemname`,`lastock`.`uom` as `uom`,`lastock`.`disc` as `disc`,
                                `lastock`.`cost` as `cost`,`lastock`.`isamt` as `isamt`,`lastock`.`isqty` as `isqty`,lastock.rrqty as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                from ((`lastock` left join `lahead` on((`lastock`.`trno` = `lahead`.`trno`)))
                                left join `client` on((`client`.`client` = `lahead`.`client`))) left join cntnum on cntnum.trno = lahead.trno
                                where  md5(client.clientid) ='$clientid' and lahead.dateid>='$start' and cntnum.center ='$center'
                                union all
                                select `lbhead`.`trno` as `trno`,`lbhead`.`doc` as `doc`,`client`.`clientid` as `clientid`,
                                `lbhead`.`docno` as `docno`,`lbhead`.`dateid` as `dateid`,`lbstock`.`barcode` as `barcode`,
                                `lbstock`.`itemname` as `itemname`,`lbstock`.`uom` as `uom`,`lbstock`.`disc` as `disc`,
                                `lbstock`.`cost` as `cost`,`lbstock`.`isamt` as `isamt`,`lbstock`.`isqty` as `isqty`,lbstock.rrqty as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                from ((`lbstock` left join `lbhead` on((`lbstock`.`trno` = `lbhead`.`trno`)))
                                left join `client` on((`client`.`client` = `lbhead`.`client`))) left join cntnum on cntnum.trno = lbhead.trno
                                where  md5(client.clientid) ='$clientid' and lbhead.dateid>='$start' and cntnum.center ='$center'
                                union all
                                select `lchead`.`trno` as `trno`,`lchead`.`doc` as `doc`,`client`.`clientid` as `clientid`,
                                `lchead`.`docno` as `docno`,`lchead`.`dateid` as `dateid`,`lcstock`.`barcode` as `barcode`,
                                `lcstock`.`itemname` as `itemname`,`lcstock`.`uom` as `uom`,`lcstock`.`disc` as `disc`,
                                `lcstock`.`cost` as `cost`,`lcstock`.`isamt` as `isamt`,`lcstock`.`isqty` as `isqty`,lcstock.rrqty as `rrqty`,
                                client.client,client.clientname,client.addr,client.tel,client.tel2,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                from ((`lcstock` left join `lchead` on((`lcstock`.`trno` = `lchead`.`trno`)))
                                left join `client` on((`client`.`client` = `lchead`.`client`))) left join cntnum on cntnum.trno = lchead.trno
                                where md5(client.clientid) ='$clientid' and lchead.dateid>='$start' and cntnum.center ='$center' group by barcode

                            ";
                            break;
                        
                        }
        }
        // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptstockcard($_,$params,$center) {
        $itemid=$_;
        $start=$params['startdate'];
        $end=$params['enddate'];
        $reporttype=$params['reporttype'];
        $whby=$params['warehouse'];
        $uom=$params['uom'];

        switch($params['reporttype']){
                        case 'ledger':{
                            $query="
                                   select '' as posted,item.itemname,item.barcode,head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,stock.cost as cost,stock.rrcost as rrcost,stock.qty as qty,
                                    head.yourref as yourref,head.ourref as ourref,stock.amt as amt,iss as iss,stock.disc as disc,item.itemid as itemid,wh.client as wh,stock.loc as loc,0 as type,
                                    head.isimport as isimport,stock.line as line,head.cur as cur,head.forex as forex,head.factor as factor,stock.rem as rem,stock.encodeddate as encoded,
                                    client.client,client.clientname,client.addr,client.tel,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                    from glhead as head left join glstock as stock on stock.trno=head.trno left join item on item.itemid=stock.itemid
                                    left join client as wh on wh.clientid=stock.whid left join cntnum on cntnum.trno=head.trno left join client on client.clientid=head.clientid
                                    where md5(item.itemid)='$itemid' and head.dateid between '$start' and '$end' and wh.client='$whby' and cntnum.center='$center'
                                    union all
                                    select '' as posted,item.itemname,item.barcode,head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,stock.cost as cost,stock.rrcost as rrcost,stock.qty as qty,
                                    head.yourref as yourref,head.ourref as ourref,stock.amt as amt,iss as iss,stock.disc as disc,item.itemid as itemid,stock.wh as wh,stock.loc as loc,0 as type,
                                    head.isimport as isimport,stock.line as line,head.cur as cur,head.forex as forex,head.factor as factor,stock.rem as rem,stock.encodeddate as encoded,
                                    client.client,client.clientname,client.addr,client.tel,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                    from lahead as head left join lastock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
                                    left join cntnum on cntnum.trno=head.trno left join client on client.client=head.client left join client as wh on wh.client=stock.wh
                                    where md5(item.itemid)='$itemid' and head.dateid between '$start' and '$end' and wh.client='$whby' and cntnum.center='$center'
                                    union all
                                    select '' as posted,item.itemname,item.barcode,head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,stock.cost as cost,stock.rrcost as rrcost,stock.qty as qty,
                                    head.yourref as yourref,head.ourref as ourref,stock.amt as amt,iss as iss,stock.disc as disc,item.itemid as itemid,stock.wh as wh,stock.loc as loc,0 as type,
                                    head.isimport as isimport,stock.line as line,head.cur as cur,head.forex as forex,head.factor as factor,stock.rem as rem,stock.encodeddate as encoded,
                                    client.client,client.clientname,client.addr,client.tel,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                    from lbhead as head left join lbstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
                                    left join cntnum on cntnum.trno=head.trno left join client on client.client=head.client left join client as wh on wh.client=stock.wh
                                    where md5(item.itemid)='$itemid' and head.dateid between '$start' and '$end' and wh.client='$whby' and cntnum.center='$center'
                                    union all
                                    select '' as posted,item.itemname,item.barcode,head.trno as trno,head.doc as doc,head.docno as docno,head.dateid as dateid,stock.cost as cost,stock.rrcost as rrcost,stock.qty as qty,
                                    head.yourref as yourref,head.ourref as ourref,stock.amt as amt,iss as iss,stock.disc as disc,item.itemid as itemid,stock.wh as wh,stock.loc as loc,0 as type,
                                    head.isimport as isimport,stock.line as line,head.cur as cur,head.forex as forex,head.factor as factor,stock.rem as rem,stock.encodeddate as encoded,
                                    client.client,client.clientname,client.addr,client.tel,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
                                    from lchead as head left join lcstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
                                    left join cntnum on cntnum.trno=head.trno left join client on client.client=head.client left join client as wh on wh.client=stock.wh
                                    where md5(item.itemid)='$itemid' and head.dateid between '$start' and '$end' and wh.client='$whby' and cntnum.center='$center'
                                    order by dateid,trno
                            ";
                            break;
                        }
                        case 'receiving':{
                            $query="
                                
                                select cntnum.doc, rrstatus.trno, rrstatus.line, client.clientname, rrstatus.cost,
                                (rrstatus.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
                                cast((case when rrstatus.bal=0 then 'applied' else round((rrstatus.bal / (case when ifnull(uom.factor, 0)=0 then 1
                                else uom.factor end)),2) end) as char(50)) as status, date(rrstatus.dateid) as dateid, rrstatus.whid, rrstatus.uom, rrstatus.disc,
                                rrstatus.docno, rrstatus.loc, wh.clientname as whname, stock.rrcost, head.cur, head.forex, item.isinactive, item.isimport, 
                                item.barcode, item.itemname, item.brand, item.model, item.part, item.brand, item.sizeid, 
                                item.amt as priceretail, item.disc as discretail, item.amt2 as pricewhole, item.disc2 as discwhole, 
                                item.famt as pricegrp1, item.disc3 as discgrp1, item.amt4 as pricegrp2, item.disc as discgrp2
                                from ((((((rrstatus left join client on client.clientid=rrstatus.clientid) left join client as wh on wh.clientid=rrstatus.whid) 
                                left join item on item.itemid=rrstatus.itemid) left join uom on uom.itemid=rrstatus.itemid and uom.uom='$uom') 
                                left join cntnum on cntnum.trno=rrstatus.trno) left join glhead as head on head.trno=rrstatus.trno)
                                left join glstock as stock on stock.trno=rrstatus.trno and stock.line=rrstatus.line 
                                where md5(rrstatus.itemid)='$itemid' and wh.client='$whby' and rrstatus.dateid between '$start' and '$end'  
                                order by rrstatus.dateid
                                    
                            ";
                            break;
                        }
                        case 'po':{
                            $query="
                                select pohead.trno, pohead.doc, pohead.docno, date(pohead.dateid) as dateid, clientname,
                                (postock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
                                (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa, item.isinactive, item.isimport,
                                item.barcode, item.itemname, item.brand, item.model, item.part, item.brand, item.sizeid,
                                item.amt as priceretail, item.disc as discretail, item.amt2 as pricewhole, item.disc2 as discwhole,
                                item.famt as pricegrp1, item.disc3 as discgrp1, item.amt4 as pricegrp2, item.disc as discgrp2
                                from ((postock left join pohead on pohead.trno=postock.trno) left join item
                                on item.barcode=postock.barcode) left join uom on uom.itemid=item.itemid
                                and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = pohead.trno where md5(item.itemid)='$itemid' and postock.wh ='$whby'
                                and pohead.dateid between '$start' and '$end' 
                                union all
                                select hpohead.trno, hpohead.doc, hpohead.docno, date(hpohead.dateid) as dateid, clientname,
                                (hpostock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
                                (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa, item.isinactive, item.isimport,
                                item.barcode, item.itemname, item.brand, item.model, item.part, item.brand, item.sizeid,
                                item.amt as priceretail, item.disc as discretail, item.amt2 as pricewhole, item.disc2 as discwhole,
                                item.famt as pricegrp1, item.disc3 as discgrp1, item.amt4 as pricegrp2, item.disc as discgrp2
                                from ((hpostock left join hpohead on hpohead.trno=hpostock.trno) left join item
                                on item.barcode=hpostock.barcode) left join uom on uom.itemid=item.itemid
                                and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = hpohead.trno where md5(item.itemid)='$itemid' and hpostock.wh ='$whby'
                                and hpohead.dateid between '$start' and '$end'  order by dateid
                            ";
                            break;
                        }
                        case 'so':{
                            $query="
                                select sohead.trno, sohead.doc, sohead.docno, date(sohead.dateid) dateid, clientname,
                                (sostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
                                (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa, item.isinactive, item.isimport,
                                item.barcode, item.itemname, item.brand, item.model, item.part, item.brand, item.sizeid,
                                item.amt as priceretail, item.disc as discretail, item.amt2 as pricewhole, item.disc2 as discwhole,
                                item.famt as pricegrp1, item.disc3 as discgrp1, item.amt4 as pricegrp2, item.disc as discgrp2 
                                from ((sostock left join sohead on sohead.trno=sostock.trno) left join item on item.barcode=sostock.barcode)
                                left join uom on uom.itemid=item.itemid and uom.uom='$uom'
                                left join transnum as cntnum on cntnum.trno = sohead.trno where md5(item.itemid)='$itemid'
                                and sostock.wh ='$whby' and sohead.dateid between '$start' and '$end' 
                                union all
                                select hsohead.trno, hsohead.doc, hsohead.docno, date(hsohead.dateid) as dateid,
                                clientname, (hsostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
                                (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qa, item.isinactive, item.isimport,
                                item.barcode, item.itemname, item.brand, item.model, item.part, item.brand, item.sizeid,
                                item.amt as priceretail, item.disc as discretail, item.amt2 as pricewhole, item.disc2 as discwhole,
                                item.famt as pricegrp1, item.disc3 as discgrp1, item.amt4 as pricegrp2, item.disc as discgrp2
                                from ((hsostock left join hsohead on hsohead.trno=hsostock.trno) left join item on item.barcode=hsostock.barcode)
                                left join uom on uom.itemid=item.itemid and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = hsohead.trno
                                where md5(item.itemid)='$itemid' and hsostock.wh ='$whby' and hsohead.dateid between '$start' and '$end'  order by dateid
                            ";
                            break;
                        }
        }
        // echo $query;

        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
        
       }
    
    public static function rptjoborder($_) { 
        $trno=$_;
        //$center=isset($_POST['Reportlog']['center']) ? $_POST['Reportlog']['center'] : "ALL";
        $center_=isset(Yii::$app->user->center) && strlen(Yii::$app->user->center)!=0? Yii::$app->user->center : "ALL";
        $center=md5($center_);
        $type=isset($_POST['Reportlog']['type']) ? $_POST['Reportlog']['type'] : "";
        switch($type){
                        case 'StoreReceived':{
                            $query="
                                select head.docno,date(service.sreceiveddate) as sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join joservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.sreceiveddate is not null and service.deltoho is not null 
                                and service.hreceiveddate is null and fromstocdate is null and md5(transnum.center) = '$center'
                                union all
                                select head.docno,date(service.sreceiveddate) as sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join hjoservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.sreceiveddate is not null  and service.deltoho is not null
                                and service.hreceiveddate is null and fromstocdate is null and md5(transnum.center) = '$center'
                            ";
                        break;
                        }
                        case 'Released2Cus':{
                            $query="
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join joservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.sreceiveddate is not null
                                 and fromstocdate is null and md5(transnum.center) = '$center'
                                union all
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join hjoservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.sreceiveddate is not null
                                and  fromstocdate is null and md5(transnum.center) = '$center'
                            ";
                        break;
                        }
                        case 'HOReceved':{
                            $query="
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join joservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where hreceiveddate is not null and service.sureceiveddate is null and service.rettostore is null
                                and md5(transnum.center) = '$center'
                                union all
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join hjoservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where hreceiveddate is not null and service.sureceiveddate is null and service.rettostore is null and md5(transnum.center) = '$center'
                            ";
                        break;
                        }
                        case 'Send2Supp':{
                            $query="
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join joservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.sureceiveddate is not null and service.retdatesutoho is null
                                 and md5(transnum.center) = '$center'
                                union all
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join hjoservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.sureceiveddate is not null and service.retdatesutoho is null and md5(transnum.center) = '$center'
                            ";
                        break;
                        }
                        case 'HOReceivednot':{
                            $query="
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join joservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.hreceiveddate is not null and service.rettostore is null
                                 and md5(transnum.center) = '$center'
                                union all
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join hjoservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.hreceiveddate is not null and service.rettostore is null and md5(transnum.center) = '$center'
                            ";
                        break;
                        }
                        case 'HOReceivedfrom':{
                            $query="
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join joservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.retdatesutoho is not null and service.rettostore is null
                                 and md5(transnum.center) = '$center'
                                union all
                                select head.docno,service.sreceiveddate,head.clientname,head.yourref,head.sku,head.itemname,service.problem,center.code as center,
                                center.name as branch,center.address as branchaddr,center.tel as branchtel from
                                hjohead as head left join hjoservice as service on service.trno = head.trno
                                left join transnum on transnum.trno = head.trno left join center on center.code = transnum.center
                                where service.retdatesutoho is not null and service.rettostore is null and md5(transnum.center) = '$center'
                            ";
                        break;
                        }
        }
                        
        $result=Yii::$app->sbccommon->opentable($query);
        
        return $result;
    }
    public static function rptquotation($_) {
        $trno=$_;
        $query="select item.picture,head.docno,head.client,head.clientname,head.address,date(head.dateid) as dateid,head.rem,client.contact,stock.itemname,stock.barcode,
                stock.isqty,stock.uom,stock.isamt,stock.ext,stock.addremarks,item.note,item.specs,detail.header1,detail.header2,detail.header3,detail.footer1,
                detail.footer2,detail.footer3,ua.name,ua.position from qthead as head left join qtstock as stock on stock.trno = head.trno
                left join qtdetail as detail on detail.trno = head.trno
                left join client on client.client = head.client left join item on item.barcode=stock.barcode
                left join useraccess as ua on ua.username = head.createby
                where md5(head.trno) = '$trno'
                union all
                select item.picture,head.docno,head.client,head.clientname,head.address,date(head.dateid) as dateid,head.rem,client.contact,stock.itemname,stock.barcode,
                stock.isqty,stock.uom,stock.isamt,stock.ext,stock.addremarks,item.note,item.specs,detail.header1,detail.header2,detail.header3,detail.footer1,
                detail.footer2,detail.footer3,ua.name,ua.position from hqthead as head left join hqtstock as stock on stock.trno = head.trno
                left join hqtdetail as detail on detail.trno = head.trno
                left join client on client.client = head.client left join item on item.barcode=stock.barcode
                left join useraccess as ua on ua.username = head.createby
                where md5(head.trno) = '$trno'
                ";
        //echo $query;
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }


    //TRANSACTION LIST

        public static function rptPurchase_ReturnReport($params) /*JTG*/ {
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=stock.whid
            where head.doc='DM' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=stock.wh
            where head.doc='DM' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=stock.whid
            where head.doc='DM' and head.dateid between '$start' and '$end' $filter";

            $result=Yii::$app->sbccommon->opentable($strSQL);
            // var_dump($result);
            // return 0;
            return $result;
    }
    public static function rptInventory_PhysicalCountReport($params) /*JTG*/ {
         $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.docno,client.clientname,head.dateid,stock.barcode,stock.rrqty,stock.uom,stock.itemname,stock.rrcost,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from pcstock as stock
            left join pchead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=head.client
            where head.doc='PC' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,client.clientname,head.dateid,stock.barcode,stock.rrqty,stock.uom,stock.itemname,stock.rrcost,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from hpcstock as stock
            left join hpchead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=head.client;
            where head.doc='PC' and head.dateid between '$start' and '$end' $filter";

            $result=Yii::$app->sbccommon->opentable($strSQL);
            // var_dump($result);
            // return 0;
            return $result;
    }
    public static function rptInventory_TransferSlipReport($params) /*JTG*/ {
         $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,stock.barcode,stock.iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join client as source on source.client=head.wh
            left join cntnum on cntnum.trno=head.trno
            where head.doc='TS' and stock.iss<>0 and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,item.barcode,stock.iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join client as source on source.clientid=head.whid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='TS' and stock.iss<>0 and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,item.barcode,stock.iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join client as source on source.clientid=head.whid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='TS' and stock.iss<>0 and head.dateid between '$start' and '$end' $filter";

            $result=Yii::$app->sbccommon->opentable($strSQL);
            // var_dump($result);
            // return 0;
            return $result;
    }

   public static function rptInventory_TransferSlipReportyulick($params) /*JTG*/ {
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $yourref = $params['yourref'];
        $ourref = $params['ourref'];

        $destination = $params['destination'];
        $source = $params['source'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        if($ourref!=""){
            $filter=$filter." and head.ourref='$ourref' ";
        }

        if($yourref!=""){
            $filter=$filter." and head.yourref='$yourref' ";
        }

        $whfilter = "";

        if($source != ''){
            $whfilter = ' and source.client = "'.$source.'"';
        }//end if

        if($destination != ''){
            $whfilter = ' and destination.client = "'.$destination.'"';
        }//end if

        $strSQL="select head.yourref,head.ourref,head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,stock.barcode,stock.iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join client as source on source.client=head.wh
            left join client as destination on destination.client=head.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='TS' and stock.iss<>0 and head.dateid between '$start' and '$end' $filter $whfilter
            union all
            select head.yourref,head.ourref,head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,item.barcode,stock.iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join client as source on source.clientid=head.whid
            left join client as destination on destination.clientid=head.clientid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='TS' and stock.iss<>0 and head.dateid between '$start' and '$end' $filter $whfilter
            union all
            select head.yourref,head.ourref,head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,item.barcode,stock.iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem
            from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join client as source on source.clientid=head.whid
            left join client as destination on destination.clientid=head.clientid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='TS' and stock.iss<>0 and head.dateid between '$start' and '$end' $filter $whfilter";
            $result=Yii::$app->sbccommon->opentable($strSQL);

            return $result;
    }

    public static function rptInventory_AdjustmentReport($params) /*JTG*/ {
         $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,stock.barcode,(stock.qty-stock.iss) as iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem,stock.rrqty,stock.rrcost
            from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join client as source on source.client=head.wh
            left join cntnum on cntnum.trno=head.trno
            where head.doc='AJ' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,item.barcode,(stock.qty-stock.iss) as iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem,stock.rrqty,stock.rrcost
            from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join client as source on source.clientid=head.whid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='AJ' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,source.clientname as whsource,head.clientname as whdestination,
            head.dateid,item.barcode,(stock.qty-stock.iss) as iss,stock.uom,stock.itemname,stock.isamt,
            stock.ext,stock.loc,stock.expiry,stock.rem,stock.rrqty,stock.rrcost
            from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join client as source on source.clientid=head.whid
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='AJ' and head.dateid between '$start' and '$end' $filter";

            $result=Yii::$app->sbccommon->opentable($strSQL);
            // var_dump($result);
            // return 0;
            return $result;
    }
    public static function rptInventory_SetupReport($params) /*JTG*/ {
         $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=stock.whid
            where head.doc='IS' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=stock.wh
            where head.doc='IS' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=stock.whid
            where head.doc='IS' and head.dateid between '$start' and '$end' $filter";

            $result=Yii::$app->sbccommon->opentable($strSQL);
            // var_dump($result);
            // return 0;
            return $result;
    }
    public static function rptPurchase_ReceivingReport($params) /*JTG*/ {
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];
        $supp=$params['supplier'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }

        if($supp!=""){
            $filter=$filter." and supp.client='$supp' ";
        }

        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=stock.whid
            left join client as supp on supp.clientid=head.clientid
            where head.doc='RR' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=stock.wh
            left join client as supp on supp.client = head.client
            where head.doc='RR' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=stock.whid
            left join client as supp on supp.clientid=head.clientid
            where head.doc='RR' and head.dateid between '$start' and '$end' $filter";
            
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }
    public static function rptPurchase_OrderReport($params) /*JTG*/ {

        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.loc,stock.rem,head.dateid,stock.ref
            from postock as stock
            left join pohead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=stock.wh
            where head.doc='PO' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.loc,stock.rem,head.dateid,stock.ref
            from hpostock as stock
            left join hpohead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=stock.wh
            where head.doc='PO' and head.dateid between '$start' and '$end' $filter";
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }
    
    public static function rptSales_OrderReport($params) /*JTG*/ {
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }
        if($params['client']!=""){
            $filter= $filter . " and head.client='".$params['client']."'";
            }

        $strSQL="select a.yourref, a.docno, a.supplier, a.barcode, a.itemname, a.uom, a.iss, a.isamt, a.disc, 
            a.ext, a.clientname,a.createby, a.loc, a.rem, a.dateid, a.qa
            from (select head.yourref,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.iss,stock.isamt,stock.disc,stock.ext,
            client.clientname,head.createby,stock.loc,stock.rem,head.dateid,
            round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as qa
            from sostock as stock
            left join sohead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode
            left join transnum on transnum.trno=head.trno
            left join client on client.client=stock.wh
            left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
            where head.doc='SO' and head.dateid between '$start' and '$end' $filter
            union all
            select head.yourref,head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.iss,stock.isamt,stock.disc,stock.ext,
            client.clientname,head.createby,stock.loc,stock.rem,head.dateid,
            round((stock.iss-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as qa
            from hsostock as stock
            left join hsohead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode
            left join transnum on transnum.trno=head.trno
            left join client on client.client=stock.wh
            left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
            where head.doc='SO' and head.dateid between '$start' and '$end' $filter ) as a
            order by a.docno";
            
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }

    public static function rptSales_JournalReport($params) /*JTG*/ {
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];
        $isposted=$params['poststatus'];
        $isdetailed = $params['reporttype'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
        } 

          switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                    $isqty = "stock.iss2";
                    break;
                default:
                    $isqty = "stock.iss";
                    break;
            }


            switch($isposted)
            {
                case 'unposted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select head.yourref,head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,".$isqty." as iss,
                                stock.isamt,stock.disc,stock.ext,wh.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
                                left(head.dateid,10) as dateid,stock.ref from lastock as stock
                                left join lahead as head on head.trno=stock.trno
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.client=head.client
                                left join client as wh on wh.client = head.wh
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'

                            ";
                            break;
                        }
                        case 'summarized':{
                            $query="select 'UNPOSTED' as status ,head.yourref,
                                head.docno,head.clientname as supplier,
                                sum(stock.ext) as ext, wh.clientname,head.createby,
                                left(head.dateid,10) as dateid from lastock as stock
                                left join lahead as head on head.trno=stock.trno
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.client=head.client
                                left join client as wh on wh.client = head.wh
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                                group by head.docno,head.trno";
                            break;
                        }
                    }
                    break;
                }
                case 'posted':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select head.yourref,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,".$isqty." as iss,
                                stock.isamt,stock.disc,stock.ext, wh.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
                                left(head.dateid,10) as dateid,stock.ref from glstock as stock
                                left join glhead as head on head.trno=stock.trno
                                left join item on item.itemid=stock.itemid
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid=head.clientid
                                left join client as wh on wh.clientid = head.whid
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                                union all
                                select head.yourref,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,".$isqty." as iss,
                                stock.isamt,stock.disc,stock.ext, wh.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
                                left(head.dateid,10) as dateid,stock.ref from hglstock as stock
                                left join hglhead as head on head.trno=stock.trno
                                left join item on item.itemid=stock.itemid
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid=head.clientid
                                left join client as wh on wh.clientid = head.whid
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                            ";
                           
                            break;
                        }
                        case 'summarized':{
                            $query = "select 'POSTED' as status,head.docno,
                            head.clientname as supplier,sum(stock.ext) as ext, wh.clientname, head.createby,
                            left(head.dateid,10) as dateid from glstock as stock
                            left join glhead as head on head.trno=stock.trno
                            left join item on item.itemid=stock.itemid
                            left join cntnum on cntnum.trno=head.trno
                            left join client on client.clientid=head.clientid 
                            left join client as wh on wh.clientid = head.whid
                            where head.doc='sj'
                            and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                            group by head.docno,head.trno,cntnum.center
                            union all 
                            select 'POSTED' as status,head.docno,
                            head.clientname as supplier,sum(stock.ext) as ext, wh.clientname, head.createby,
                            left(head.dateid,10) as dateid from glstock as stock
                            left join hglhead as head on head.trno=stock.trno
                            left join item on item.itemid=stock.itemid
                            left join cntnum on cntnum.trno=head.trno
                            left join client on client.clientid=head.clientid 
                            left join client as wh on wh.clientid = head.whid
                            where head.doc='sj'
                            and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                            group by head.docno,head.trno,cntnum.center";
                            break;
                        }
                    }
                    break;
                }
                case 'all':{
                    switch($isdetailed){
                        case 'detailed':{
                            $query="
                                select head.yourref,head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,".$isqty." as iss,
                                stock.isamt,stock.disc,stock.ext, wh.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
                                head.dateid,stock.ref from lastock as stock
                                left join lahead as head on head.trno=stock.trno
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.client=head.client
                                left join client as wh on wh.client = head.wh
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                                union
                                select head.yourref,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,".$isqty." as iss,
                                stock.isamt,stock.disc,stock.ext, wh.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
                                head.dateid,stock.ref from glstock as stock
                                left join glhead as head on head.trno=stock.trno
                                left join item on item.itemid=stock.itemid
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid=head.clientid
                                left join client as wh on wh.clientid = head.whid
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                                union all
                                select head.yourref,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,".$isqty." as iss,
                                stock.isamt,stock.disc,stock.ext, wh.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
                                head.dateid,stock.ref from hglstock as stock
                                left join hglhead as head on head.trno=stock.trno
                                left join item on item.itemid=stock.itemid
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid=head.clientid
                                left join client as wh on wh.clientid = head.whid
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                            ";
                           
                            break;
                        }
                        case 'summarized':{
                            $query="
                                select 'UNPOSTED' as status,head.docno,head.clientname as supplier,sum(stock.ext) as ext,client.clientname,
                                head.createby,head.dateid
                                from lastock as stock left join lahead as head on head.trno=stock.trno
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.client=head.client
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                                group by head.docno,head.trno
                                union all
                                select 'POSTED' as status ,head.docno,head.clientname as supplier,sum(stock.ext) as ext, client.clientname,
                                head.createby,head.dateid
                                from glstock as stock left join glhead as head on head.trno=stock.trno
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid=head.clientid
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                                group by head.docno,head.trno
                                union all
                                select 'POSTED' as status ,head.docno,head.clientname as supplier,sum(stock.ext) as ext, client.clientname,
                                head.createby,head.dateid
                                from hglstock as stock left join hglhead as head on head.trno=stock.trno
                                left join cntnum on cntnum.trno=head.trno
                                left join client on client.clientid=head.clientid
                                where head.doc='sj' and head.dateid between '$start' and '$end' $filter and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                                group by head.docno,head.trno";
                            break;
                        }
                    }
                    break;
                }

            }
            // echo $query;
            $result=Yii::$app->sbccommon->opentable($query);
            return $result;
    }


      public static function rptSales_JournalReportyulick($params) /*JTG*/ {
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
        } 

        if($params['yourref']!=""){
            $filter=$filter." and head.yourref='".$params['yourref']."' ";
        }

        if($params['ourref']!=""){
            $filter=$filter." and head.ourref='".$params['ourref']."' ";
        }

          switch (Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                    $isqty = "stock.iss2";
                    break;
                default:
                    $isqty = "stock.iss";
                    break;
            }


        $strSQL="
            select  a.yourref,a.ourref, a.docno, a.supplier, a.barcode, a.itemname,
            a.uom, a.iss, a.isamt, a.disc, a.ext, a.clientname, a.createby, a.expiry, a.loc, a.rem, a.dateid, a.ref from
            (select head.yourref,head.ourref,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,".$isqty." as iss,
            stock.isamt,stock.disc,stock.ext, client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
            head.dateid,stock.ref from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=head.clientid
            where head.doc='sj' and head.dateid between '$start' and '$end' $filter
            union all
            select head.yourref,head.ourref,head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,".$isqty." as iss,
            stock.isamt,stock.disc,stock.ext, client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
            head.dateid,stock.ref from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=head.client
            where head.doc='sj' and head.dateid between '$start' and '$end' $filter
            union all
            select head.yourref,head.ourref,head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,".$isqty." as iss,
            stock.isamt,stock.disc,stock.ext, client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,
            head.dateid,stock.ref from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=head.clientid
            where head.doc='sj' and head.dateid between '$start' and '$end' $filter)
            as a order by a.docno";
            
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }

        public static function rptSales_JournalReportinfinitea($params) /*JTG*/ {
        $username=$params['username'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.rem,head.checked,head.dateid,head.docno,head.clientname,head.salestype,sum(stock.ext) as amt from glhead as head
                left join glstock as stock on stock.trno=head.trno
                left join cntnum as num on num.trno = head.trno
                where head.doc='SJ' and head.salestype in ('CHARGE','CHECK','CASH') and left(num.postdate,10) between '$start' and '$end' $filter 
                group by head.dateid,head.docno,head.clientname,head.salestype
                order by head.dateid,head.docno;";
            //echo $strSQL;
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }

    public static function rptSales_JournalReportinfinitea6($params) /*JTG*/ {
        $username=$params['username'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.rem,head.checked,head.dateid,head.docno,head.clientname,head.salestype,sum(stock.ext) as amt from glhead as head
                left join glstock as stock on stock.trno=head.trno
                left join cntnum as num on num.trno = head.trno
                where head.doc='SJ' and head.salestype in ('DEPOSIT') and left(num.postdate,10) between '$start' and '$end' $filter 
                group by head.dateid,head.docno,head.clientname,head.salestype
                order by head.dateid,head.docno;";
            //echo $strSQL;
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }

    public static function rptSales_JournalReportinfinitea2($params) /*JTG*/ {
        $username=$params['username'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select head.rem,head.checked,head.dateid,head.docno,head.clientname,head.salestype,sum(stock.ext) as amt from lahead as head
                left join lastock as stock on stock.trno=head.trno
                left join cntnum as num on num.trno = head.trno
                where head.doc='SJ' $filter
                group by head.dateid,head.docno,head.clientname,head.salestype
                order by head.dateid,head.docno;";
         
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }

    public static function rptSales_JournalReportinfinitea3($params) /*JTG*/ {
        $username=$params['username'];
        $start=$params['start'];
        $end=$params['end'];
        $filter="";
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="

        select ifnull(sum(totalcash),0) as cash,ifnull(sum(totalcharge),0) as charge,ifnull(sum(totalcheck),0) as `check`,
        ifnull(sum(totaldeposit),0) as `deposit` from (
        select head.salestype,sum(stock.ext) as totalcash,0 as totalcharge,
        0 as totalcheck , 0 as totaldeposit from glhead as head
        left join glstock as stock on stock.trno=head.trno
        left join cntnum as num on num.trno = head.trno
        where head.doc='SJ' and
        left(num.postdate,10) between '$start' and '$end' and head.salestype = 'cash'
        group by head.salestype
        union all
        select head.salestype,0 as totalcash,sum(stock.ext) as totalcharge, 0 as totalcheck, 0 as totaldeposit
        from glhead as head
        left join glstock as stock on stock.trno=head.trno
        left join cntnum as num on num.trno = head.trno
        where head.doc='SJ' and left(num.postdate,10) between '$start' and '$end' and head.salestype = 'charge'
        group by head.salestype
        union all
        select head.salestype,0 as totalcash, 0 as totalcheck , 0 as totalcharge ,sum(stock.ext) as totaldeposit
        from glhead as head
        left join glstock as stock on stock.trno=head.trno
        left join cntnum as num on num.trno = head.trno
        where head.doc='SJ' and left(num.postdate,10) between '$start' and '$end' and head.salestype = 'deposit'
        group by head.salestype
        union all
        select head.salestype,0 as totalcash,0 as totalcharge, sum(stock.ext) as totalcheck,0 as totaldeposit
        from glhead as head
        left join glstock as stock on stock.trno=head.trno
        left join cntnum as num on num.trno = head.trno
        where head.doc='SJ' and left(num.postdate,10) between '$start' and '$end' and head.salestype = 'check'
        group by head.salestype) as tbl
";
            //echo $strSQL;
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }

    public static function rptSales_JournalReportinfinitea4($params) /*JTG*/ {
        $username=$params['username'];
        $start=$params['start'];
        $end=$params['end'];
        $filter="";
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select h.docno, h.dateid, h.client, h.clientname, coa.acnoname, d.checkno, d.db as amt
                from lahead as h left join ladetail as d on d.trno=h.trno left join coa on coa.acno=d.acno
                where h.dateid between '$start' and '$end ' $filter and h.doc='CR' and left(coa.alias,2) in ('CA','CR','CB')
                union all
                select h.docno, h.dateid, h.client, h.clientname, coa.acnoname, d.checkno, d.db as amt
                from lbhead as h left join lbdetail as d on d.trno=h.trno left join coa on coa.acno=d.acno
                where h.dateid between  '$start' and '$end ' $filter and h.doc='CR' and left(coa.alias,2) in ('CA','CR','CB')
                union all
                select h.docno, h.dateid, h.client, h.clientname, coa.acnoname, d.checkno, d.db as amt
                from lchead as h left join lcdetail as d on d.trno=h.trno left join coa on coa.acno=d.acno
                where h.dateid between  '$start' and '$end ' $filter and h.doc='CR' and left(coa.alias,2) in ('CA','CR','CB')
                union all
                select h.docno, h.dateid, client.client, client.clientname, coa.acnoname, d.checkno, d.db as amt
                from glhead as h 
                left join gldetail as d on d.trno=h.trno 
                left join coa on coa.acnoid=d.acnoid
                left join client on client.clientid=h.clientid
                where h.dateid between  '$start' and '$end ' $filter and h.doc='CR' and left(coa.alias,2) in ('CA','CR','CB')
                union all
                select h.docno, h.dateid, client.client, client.clientname, coa.acnoname, d.checkno, d.db as amt
                from hglhead as h left join hgldetail as d on d.trno=h.trno left join coa on coa.acnoid=d.acnoid
                left join client on client.clientid=h.clientid
                where h.dateid between  '$start' and '$end ' $filter and h.doc='CR' and left(coa.alias,2) in ('CA','CR','CB')";

            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }

    public static function rptSales_JournalReportinfinitea5($params) /*JTG*/ {
        $username=$params['username'];
        $start=$params['start'];
        $end=$params['end'];
        $filter="";
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }

        $strSQL="select category,minimum,barcode, itemname, groupid,model, part,brand,sizeid,body, class, uom, swh, whname, sum(qty-iss) as balance,cost,amt
                from (
                select item.category,item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lahead as head left join lastock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$end' and ifnull(item.barcode,'')<>''
                union all
                select item.category,item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lbhead as head left join lbstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$end' and ifnull(item.barcode,'')<>''
                union all
                select item.category,item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((lchead as head left join lcstock as stock on stock.trno=head.trno)left join item on item.barcode=stock.barcode)
                left join client as wh on wh.client=stock.wh)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$end' and ifnull(item.barcode,'')<>''
                union all
                select item.category,item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$end' and ifnull(item.barcode,'')<>''
                union all
                select item.category,item.minimum,item.barcode, item.itemname,item.model, item.part,item.groupid, item.brand, item.sizeid,item.body, item.class, item.uom, wh.client as swh, wh.clientname as whname, stock.qty, stock.iss,
                (select cost from rrstatus where itemid=item.itemid order by dateid desc limit 1) as cost, item.amt
                from (((hglhead as head left join hglstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid)
                left join client as wh on wh.clientid=stock.whid)left join cntnum on cntnum.trno=head.trno
                where  head.dateid<='$end' and ifnull(item.barcode,'')<>'' )as ib
                group by category,barcode having balance<minimum order by category,part, brand,itemname,sizeid";
         
            $result=Yii::$app->sbccommon->opentable($strSQL);
            return $result;
    }
    
    
    public static function rptSales_ReturnReport($params) /*JTG*/ {
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }
        if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
        } 

        $strSQL="select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty as iss,stock.isamt,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from glstock as stock
            left join glhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=head.clientid
            where head.doc='CM' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.rrqty as iss,stock.isamt,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from lastock as stock
            left join lahead as head on head.trno=stock.trno
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=head.client
            where head.doc='CM' and head.dateid between '$start' and '$end' $filter
            union all
            select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty as iss,stock.isamt,stock.disc,stock.ext,
            client.clientname,head.createby,stock.expiry,stock.loc,stock.rem,head.dateid,stock.ref
            from hglstock as stock
            left join hglhead as head on head.trno=stock.trno
            left join item on item.itemid=stock.itemid
            left join cntnum on cntnum.trno=head.trno
            left join client on client.clientid=head.clientid
            where head.doc='CM' and head.dateid between '$start' and '$end' $filter";
            
            $result=Yii::$app->sbccommon->opentable($strSQL);
            // var_dump($result);
            // return 0;
            return $result;
    }
    
    public static function rptPurchase_RequisitionReport($params) /*JTG*/ {
        $username=$params['username'];
        $start=$params['start'];
        $end=$params['end'];

        $filter="";
        if($username!=""){
            $filter=$filter." and head.createby='$username' ";
        }
        if($params['client']!=""){
            $filter= $filter . " and client.client='".$params['client']."'";
        } 

        $strSQL="select head.docno,head.clientname as supplier,item.barcode,item.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.loc,stock.rem,head.dateid,stock.ref
            from prstock as stock
            left join prhead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=stock.wh
            where head.doc='PR' and head.dateid between '$start' and '$end'
            union all
            select head.docno,head.clientname as supplier,stock.barcode,stock.itemname,stock.uom,stock.rrqty,stock.rrcost,stock.disc,stock.ext,
            client.clientname,head.createby,stock.loc,stock.rem,head.dateid,stock.ref
            from hprstock as stock
            left join hprhead as head on head.trno=stock.trno
            left join item on item.barcode=stock.barcode
            left join cntnum on cntnum.trno=head.trno
            left join client on client.client=stock.wh
            where head.doc='PR' and head.dateid between '$start' and '$end' $filter";
            // var_dump($strSQL);
            // return 0;
            $result=Yii::$app->sbccommon->opentable($strSQL);
            // var_dump($result);
            // return 0;
            return $result;
    }
        //PAYABLES MODULE
    public static function rptAPsetup_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }


        $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ap' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ap' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ap' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";

            // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptAPVoucher_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }


       $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='pv' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='pv' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='pv' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";

            // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }     
    public static function rptCashCheckVoucher_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }


         $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cv' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cv' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cv' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";

            // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    //RECEIVABLES MODULE
    public static function rptARsetup_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }


        $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ar' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ar' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ar' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";

             // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    
    public static function rptReceivedPayment_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }

         $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cr' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cr' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cr' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";
       
            // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }

    public static function rptReceivedPayment_Listyulick($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];

       
        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }

        if($params['client'] != ""){
            $filter=" and hclient.client='".$params['client']."'";
            }

         $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cr' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cr' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='cr' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";
       
            // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptCounterReceipt_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }

                $query="select head.createby,head.docno,head.client as hclient,head.clientname as hclientname,head.dateid as hdateid,date_format(ar.dateid,'%Y-%m-%d') as ddateid,coa.acno,coa.acnoname,concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.checkno,detail.db,detail.cr,detail.rem,detail.ref from krhead as head
                    left join arledger as ar on ar.kr=head.trno
                    left join gldetail as detail on detail.trno=ar.trno and detail.line=ar.line
                    left join client as dclient on dclient.clientid=ar.clientid
                    left join coa on coa.acnoid=ar.acnoid
                    left join cntnum on cntnum.trno=head.trno
                    where doc='kr' and head.dateid between '$start' and '$end' $filter 
                    union all
                    select head.createby,head.docno,head.client as hclient,head.clientname as hclientname,head.dateid as hdateid,date_format(ar.dateid,'%Y-%m-%d') as ddateid,coa.acno,coa.acnoname,concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.checkno,detail.db,detail.cr,detail.rem,detail.ref from hkrhead as head
                    left join arledger as ar on ar.kr=head.trno
                    left join gldetail as detail on detail.trno=ar.trno and detail.line=ar.line
                    left join client as dclient on dclient.clientid=ar.clientid
                    left join coa on coa.acnoid=ar.acnoid
                    left join cntnum on cntnum.trno=head.trno
                    where doc='kr' and head.dateid between '$start' and '$end' $filter 
                    order by hdateid,docno";

             //echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    //ACCOUNTING MODULE                
    public static function rptGeneralJournal_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }


        $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='gj' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='gj' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='gj' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";

            // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    }
    public static function rptDepositSlip_List($params)/*Peter*/{
        
        $username=$params['username'];
        $bref=$params['bref'];
        $start=$params['start'];
        $end=$params['end'];


        $filter="";
        if($bref!=""){
            $filter=$filter." and cntnum.bref='$bref' ";
        }
        if($params['username']!=""){
            $filter= " and head.createby='".$params['username']."'";
        }


        $query="select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,detail.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from lahead as head
            left join ladetail as detail on detail.trno=head.trno left join client as hclient on hclient.client=head.client
            left join client as dclient on dclient.client=detail.client
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ds' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from glhead as head
            left join gldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ds' and head.dateid between '$start' and '$end' $filter 
            union all
            select head.createby,head.docno,hclient.client as hclient,hclient.clientname as hclientname,head.dateid,date_format(detail.postdate,'%Y-%m-%d') as postdate,detail.checkno,coa.acno,detail.acnoname,
            concat(left(dclient.client,2),right(dclient.client,7)) as dclient,dclient.clientname as dclientname,detail.db,detail.cr,detail.rem,detail.ref from hglhead as head
            left join hgldetail as detail on detail.trno=head.trno left join client as hclient on hclient.clientid=head.clientid
            left join client as dclient on dclient.clientid=detail.clientid left join coa on coa.acnoid=detail.acnoid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='ds' and head.dateid between '$start' and '$end' $filter 
            order by dateid,docno";

            // echo $query;
        $result=Yii::$app->sbccommon->opentable($query);
        return $result;
    } 

    // PRODUCTION

    public static function rptproductionins($_) {
        $trno=$_;
        $query="
                select head.due,head.labor,head.overhead,date(head.dateid) as dateid, head.docno, head.client,
                head.clientname, head.address, head.terms,head.rem, stock.barcode,stock.uom,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as netamt, stock.disc, stock.ext,
                round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as qa
                from pihead as head
                left join pistock as stock on stock.trno=head.trno
                left join client on client.client=head.client
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where head.doc='pi' and md5(head.trno)='$trno'
                union all
                select head.due,head.labor,head.overhead,date(head.dateid) as dateid, head.docno, head.client,
                head.clientname, head.address, head.terms,head.rem, stock.barcode,stock.uom,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as netamt, stock.disc, stock.ext,
                round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom.factor end,2) as qa
                from hpihead as head left join hpistock as stock on stock.trno=head.trno
                left join client on client.client=head.client
                left join item on item.barcode=stock.barcode left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where head.doc='pi' and md5(head.trno)='$trno'
                ";

        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }                    

    public static function rptproductionorder($_) {
        $trno=$_;
        $query="
                select head.pi,head.prc,date(head.due) as due,date(head.dateid) as dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as netamt, stock.disc, stock.ext
                from pdhead as head left join pdstock as stock on stock.trno=head.trno left join client on client.client=head.client
                where head.doc='pd' and md5(head.trno)='$trno'
                union all
                select head.pi,head.prc,date(head.due) as due,date(head.dateid) as dateid, head.docno, client.client, client.clientname, head.address, head.terms,head.rem, stock.barcode,
                stock.itemname, stock.rrqty as qty, stock.uom, stock.rrcost as netamt, stock.disc, stock.ext
                from hpdhead as head left join hpdstock as stock on stock.trno=head.trno left join client on client.client=head.client
                where head.doc='pd' and md5(head.trno)='$trno'
                ";
                
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }                    

    public static function rptproductioncom($_) {
        $trno=$_;
        $query="
                select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                stock.uom, stock.disc, stock.ext, stock.line
                from lahead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                union all
                select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                stock.uom, stock.disc, stock.ext, stock.line
                from lbhead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                union all
                select head.docno,head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                stock.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                stock.uom, stock.disc, stock.ext, stock.line
                from lchead as head left join lastock as stock on stock.trno=head.trno where md5(head.trno)='$trno'
                union all
                select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                stock.uom, stock.disc, stock.ext, stock.line
                from (glhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid
                where  md5(head.trno)='$trno'
                union all
                select head.docno, head.trno, head.clientname, head.address, head.dateid, head.terms, head.rem,
                item.barcode, stock.itemname, stock.rrcost as gross, stock.cost as netamt, stock.rrqty as qty,
                stock.uom, stock.disc, stock.ext, stock.line
                from (hglhead as head left join glstock as stock on stock.trno=head.trno)left join item on item.itemid=stock.itemid
                where head.doc='pk' and md5(head.trno)='$trno' order by line
                ";
                
        $result = Yii::$app->sbccommon->opentable($query);
        return $result;
    }        

    public static function getCustomerFloatingBalance($cid){
        $sql = "select client, clientname, crlimit, sum(bal) as bal from (
        select client.clientid,client.client, client.clientname, client.crlimit, (detail.db-detail.cr) as bal
        from lahead as head left join ladetail as detail on detail.trno=head.trno
        left join coa on coa.acno=detail.acno left join client on client.client=detail.client
        where left(coa.alias,2)='AR' and client.client='$cid'
        union all
        select client.clientid,client.client, client.clientname, client.crlimit, (arledger.bal) as bal
        from glhead as head left join gldetail as detail on detail.trno=head.trno
        left join coa on coa.acnoid=detail.acnoid left join client on client.clientid=detail.clientid
        left join arledger on arledger.trno=detail.trno and arledger.line=detail.line where client.client='$cid'
        ) as ar
        group by client, clientname, crlimit order by clientname";
        return Yii::$app->sbccommon->opentable($sql);
  }//end func        

  public static function rptCCLPeddling($route,$date){

        $qry='select clientid,client as code,clientname as name,route_masterfile.route_name,client.crlimit as cr from client
                left join route_masterfile on route_masterfile.route_id=client.scroute
                where iscustomer=1 and client.crlimit>0 and scroute='.$route.'';

                $result = Yii::$app->sbccommon->opentable($qry);



                   if(!empty($result)){
                    foreach ($result as $key => $value) {         


                        $data1 = Yii::$app->backend->openPDCsum($result[$key]['clientid'],$date);
                        $data2 = Yii::$app->backend->openARsum($result[$key]['clientid'],$date);

                        // echo 'pdc '.$result[$key]['clientid'].' '.$data1[0]['db'].' '.$data1[0]['cr'].' '.$data1[0]['bal'];
                        // echo '</br>';
                        // echo 'ar '.$result[$key]['clientid'].' '.$data2[0]['db'].' '.$data2[0]['cr'].' '.$data2[0]['bal'];
                        // echo '</br>';
                        // if($result[$key]['clientid']=254){
                        //     var_dump($data1);
                        //     return 0;

                        // }

                        if(empty($data1[0]['db'])){
                            $data1[0]['db']=0;
                        }
                        if(empty($data2[0]['balance'])){
                            $data2[0]['balance']=0;
                        }

                        $result[$key]['pdc'] = $data1[0]['db'];
                        $result[$key]['bal'] = $data2[0]['balance'];
                    }//end for each
                }//end if
                // echo '</br>';
                // echo '//////////////////////////////////////////';
                // var_dump($result);
                // return 0;
                            

                return $result;

  }

  public static function rptrfunserved($trno){
        $sql="select docno,date(dateid) as date,concat(client,'~',clientname) as salesman,
        rf_approval as appcode,route from hrfhead
        where trno=".$trno."";


        $head = Yii::$app->sbccommon->openTable($sql);



        $sql2="select hshead.docno,date(hshead.dateid) as date,hshead.client as ccode,hshead.clientname as customer,
                hstock.iss as quantity,hstock.uom,
                hstock.barcode,hstock.itemname as description,hstock.amt as price,hstock.ext as total
                from hsohead as hshead
                left join hsostock as hstock on hstock.trno=hshead.trno
                where hstock.iss<>hstock.qa
                and hstock.void<>1
                and hshead.rfno=".$trno."
                order by docno
                ";
        $body = Yii::$app->sbccommon->openTable($sql2);

        $result=array('head'=>$head,'body'=>$body);        



        return $result;
        // $result
    }

  //JLY route form
  public static function rptRFRouteform($trno){

        $qry2= "select head.route,head.trno,head.docno as rfno,left(head.dateid,10) as dateid,head.rem as notes,
                ifnull(CONCAT(head.client,'~',head.clientname),'') as client,ifnull(head.address,'') as address,head.yourref as approval 
                from rfhead as head where head.trno = ".$trno."
                UNION ALL
                select head.route,head.trno,head.docno as rfno,left(head.dateid,10) as dateid,head.rem as notes,
                ifnull(CONCAT(head.client,'~',head.clientname),'') as client,ifnull(head.address,'') as address,
                head.yourref as approval from hrfhead as head
                where head.trno = ".$trno."";
        $head = Yii::$app->sbccommon->openTable($qry2);


        $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,
                round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,head.rem,
                head.client,head.clientname,head.address,head.yourref from hsohead as head
                left join hsostock as stock on stock.trno = head.trno
                where head.isapproved = 1 and stock.void <> 1  and rfno = ".$trno."
                group by stock.trno,head.docno,head.dateid";

        $rfso = Yii::$app->sbccommon->openTable($qry);
    

        if(!empty($rfso)){
            foreach ($rfso as $key => $value) {
                $rfso[$key]['totalcbm'] = Yii::$app->backend->getGrandTotalCBM('SO',$value['trno']);
                $rfso[$key]['totaltonnage'] = Yii::$app->backend->getGrandTotalTons('SO',$value['trno']);
            }//end for each
        }//end if
        
        $result=array('rfso'=>$rfso,'head'=>$head);
        return $result;
        
        

    }

  public static function rptTransList($params){

        $filter='';

        $start=$params['startdate'];
        $end=$params['enddate'];


        if($start!='' && $end!=''){
            $filter=$filter."where head.dateid between '".$params['startdate']."' and '".$params['enddate']."'";
        }
        //         echo $filter;
        // return 0;

        $qry="select 'POSTED' as status,head.dateid,head.docno,head.rfdocno,ifnull(hhead.route,'') as route,
                ifnull(hhead.yourref,'') as approval,
                date(ifnull(hhead.dateid,'')) as appdate,ifnull(head.txdispatchdate,'') as dispatchd,ifnull(head.txreturndate,'') as returnd,
                ifnull(head.rem,'') as note from htxhead as head
                left join hrfhead as hhead on hhead.docno=head.rfdocno and hhead.trno=head.rftrno
                ".$filter."
                union all
                select 'UNPOSTED' as status,head.dateid,head.docno,head.rfdocno,ifnull(hhead.route,'') as route,
                ifnull(hhead.yourref,'') as approval,
                date(ifnull(hhead.dateid,'')) as appdate,ifnull(head.txdispatchdate,'') as dispatchd,ifnull(head.txreturndate,'') as returnd,
                ifnull(head.rem,'') as note from txhead as head
                left join hrfhead as hhead on hhead.docno=head.rfdocno and hhead.trno=head.rftrno
                ".$filter."";

                $result=Yii::$app->sbccommon->opentable($qry);

                return $result;



    }





  public static function rptAnalyzeCustomerCollectionMonthly($params){
        $isposted = $params['poststatus'];
        $filter="";
            if($params['client'] != ""){
            $filter=$filter." and client.client='".$params['client']."'";
            }
            if($params['center'] != ""){
            $filter=$filter." and cntnum.center='".$params['center']."'";       
            }
            
        switch($isposted){
            case 'posted':
            if($params['year'] != ""){
            $filter=$filter." and year(glhead.dateid)='".$params['year']."'";       
            }
                $sql="select glhead.doc,glhead.docno,client.client,client.clientname,glhead.dateid,cntnum.center,coa.acno,coa.acnoname,year(glhead.dateid) as yr,
                    sum(case when month(glhead.dateid)=1 then gldetail.db else 0 end) as mojan,
                    sum(case when month(glhead.dateid)=2 then gldetail.db else 0 end) as mofeb,
                    sum(case when month(glhead.dateid)=3 then gldetail.db else 0 end) as momar,
                    sum(case when month(glhead.dateid)=4 then gldetail.db else 0 end) as moapr,
                    sum(case when month(glhead.dateid)=5 then gldetail.db else 0 end) as momay,
                    sum(case when month(glhead.dateid)=6 then gldetail.db else 0 end) as mojun,
                    sum(case when month(glhead.dateid)=7 then gldetail.db else 0 end) as mojul,
                    sum(case when month(glhead.dateid)=8 then gldetail.db else 0 end) as moaug,
                    sum(case when month(glhead.dateid)=9 then gldetail.db else 0 end) as mosep,
                    sum(case when month(glhead.dateid)=10 then gldetail.db else 0 end) as mooct,
                    sum(case when month(glhead.dateid)=11 then gldetail.db else 0 end) as monov,
                    sum(case when month(glhead.dateid)=12 then gldetail.db else 0 end) as modec
                    from ((glhead
                    left join gldetail on glhead.trno=gldetail.trno)
                    left join client on glhead.clientid=client.clientid)
                    left join cntnum on glhead.trno=cntnum.trno
                    left join coa on gldetail.acnoid=coa.acnoid where (coa.alias like '%ca%' or coa.alias like '%cr%') and glhead.doc='cr' ".$filter."
                    group by ifnull(client.client,''), year(glhead.dateid)";
            break;

            case 'unposted':

            if($params['year'] != ""){
            $filter=$filter." and year(lahead.dateid)='".$params['year']."'";       
            }
                $sql="select lahead.doc,lahead.docno,client.client,client.clientname,lahead.dateid,cntnum.center,coa.acno,coa.acnoname,year(lahead.dateid) as yr,
                    sum(case when month(lahead.dateid)=1 then ladetail.db else 0 end) as mojan,
                    sum(case when month(lahead.dateid)=2 then ladetail.db else 0 end) as mofeb,
                    sum(case when month(lahead.dateid)=3 then ladetail.db else 0 end) as momar,
                    sum(case when month(lahead.dateid)=4 then ladetail.db else 0 end) as moapr,
                    sum(case when month(lahead.dateid)=5 then ladetail.db else 0 end) as momay,
                    sum(case when month(lahead.dateid)=6 then ladetail.db else 0 end) as mojun,
                    sum(case when month(lahead.dateid)=7 then ladetail.db else 0 end) as mojul,
                    sum(case when month(lahead.dateid)=8 then ladetail.db else 0 end) as moaug,
                    sum(case when month(lahead.dateid)=9 then ladetail.db else 0 end) as mosep,
                    sum(case when month(lahead.dateid)=10 then ladetail.db else 0 end) as mooct,
                      sum(case when month(lahead.dateid)=11 then ladetail.db else 0 end) as monov,
                    sum(case when month(lahead.dateid)=12 then ladetail.db else 0 end) as modec
                    from ((lahead
                    left join ladetail on lahead.trno=ladetail.trno)
                    left join client on lahead.client=client.client)
                    left join cntnum on lahead.trno=cntnum.trno
                    left join coa on ladetail.acno=coa.acno where (coa.alias like '%ca%' or coa.alias like '%cr%') and lahead.doc='CR' ".$filter."
                    group by ifnull(client.client,''),year(lahead.dateid)";
            break;
        }
        
        $result = Yii::$app->sbccommon->opentable($sql);
        return $result;
    }//end function

}