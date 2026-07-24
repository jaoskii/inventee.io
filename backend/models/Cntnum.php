<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Cntnum extends Model {
    public $trno;
    public $seq;
    public $doc;
    public $docno;
    public $bref;
    public $createdate;
    public $module;
    public $keyword;
    public $date;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('seq, createdate', 'required'),
                array('seq, isonline, isposted', 'numerical', 'integerOnly'=>true),
                array('bref', 'length', 'max'=>4),
                array('doc', 'length', 'max'=>2),
                array('docno', 'length', 'max'=>10),
                array('trno, seq, bref, doc, docno, createdate', 'safe', 'on'=>'search'),
        );
    }
    
    public static function setisdeclared($trno,$data){
        Yii::$app->sbccommon->execqry("update cntnum set isdeclared= 0 where trno=$trno");
    }

    public static function isdeclared($trno){
        return Yii::$app->sbccommon->datareader("select isdeclared from cntnum where trno=$trno");
    }

    public static function getTrnodocno($docno,$doc,$center) { //ADD CENTER PARAMETER SO IT CAN BE CHANGED ON OTHER CLASS CALLING IT
        //$center=Yii::$app->user->center;
        $table = Common::gettablenum($doc);
        $trno= Yii::$app->sbccommon->opentable("select trno,docno from ".$table." where doc='".$doc."' and docno='".$docno."' and center='".$center."'");
        return $trno;
    }

    public static function checkdocno($pref,$doc) {
        $center=Yii::$app->user->center;
        
        $table = Common::gettablenum($doc);
        $docno = Yii::$app->sbccommon->opentable("SELECT docno FROM $table where bref ='$pref' and center='$center'");
        return $docno;
    }
    


    public static function islocked($trno,$doc){
            $table=Common::localhead($doc);
            switch ($doc) {
                // SALON MODIFICATION
                case 'TR':
                // END SALON
                case 'PO':case 'SO':case 'PC':case 'KR':case 'PR': case 'TX':
                    $htable = Common::localhhead($doc);
                    $islocked= Yii::$app->sbccommon->datareader("SELECT lockdate from $table where trno='$trno' union all SELECT lockdate from $htable where trno='$trno'");
                    break;
                default:
                    $islocked= Yii::$app->sbccommon->datareader("SELECT lockdate from $table where trno='$trno' union all SELECT lockdate from glhead where trno='$trno' union all SELECT lockdate from hglhead where trno='$trno'");
                    break;
            }
            
            
            if ($islocked!=null)
                {
                return true;
                }
            else
                {
                return false;
                }

    }//end islocked

    public static function isPosted($trno,$doc) {
        $table = Common::gettablenum($doc);
        $document = Yii::$app->sbccommon->opentable("select postdate FROM ".$table." where trno ='".$trno."' limit 1");
        $blnposted=false;
        if (isset($document[0]['postdate']) && ($document[0]['postdate'])!=null) {
            $blnposted=true;
        }
        return $blnposted;
    }//end 


    public static function tsreverse($doc,$trno){

        Yii::$app->sbccommon->execqry("delete from lastock where trno=".$trno." and tstrno<>0");
        
        $qry="select trno,stock.line,refx,linex,tstrno,tsline,itemid, stock.itemname,stock.uom,client.clientid as whid,stock.loc,
              stock.disc, stock.cost, stock.qty,stock.rrcost,stock.rrqty, stock.ext, stock.isqty,stock.iss,stock.amt,stock.isamt,
              stock.qa, stock.ref,stock.encodeddate,stock.encodedby,stock.editdate,stock.editby,stock.rem,stock.comm,stock.icomm,stock.expiry
               FROM lastock as stock left join item on item.barcode=stock.barcode left join client on client.client=stock.wh
             where trno =".$trno." and tstrno=0";

        $data = Yii::$app->sbccommon->opentable($qry);
        $last_line = Lastock::getLastLine($doc,$trno)+1;
        
        foreach ($data as $itmindex => $itmdata) {
            $qryc="insert into lastock(trno,line,refx,linex,tstrno,tsline,barcode, itemname,uom,wh,loc,disc,cost,qty,rrcost,
                rrqty,ext,isqty,iss,amt,isamt,qa,ref,encodeddate,encodedby,editdate,editby,rem,comm,icomm,expiry)
                SELECT stock.trno,".$last_line.",0,0,stock.trno,stock.line,item.barcode, stock.itemname,stock.uom,dest.client,stock.loc2,
                stock.disc, stock.cost, stock.iss,stock.rrcost,stock.isqty, stock.ext, 0,0,stock.amt,stock.isamt,
                0, stock.ref,stock.encodeddate,stock.encodedby,stock.editdate,stock.editby,stock.rem,stock.comm,stock.icomm,stock.expiry
                FROM lastock as stock
                left join lahead as head on head.trno=stock.trno
                left join item on item.barcode=stock.barcode
                left join client on client.client=stock.wh
                left join client as dest on dest.client=head.client
                where stock.trno =".$trno." and stock.line=".$itmdata['line'];
            Yii::$app->sbccommon->execqry($qryc);
            $last_line = $last_line + 1;
        }//end for each
    }


    public static function PostTrans($trno,$doc,$user) {        
        Yii::$app->systemsettings->setDefaultTimeZone();
        $lhead=Common::localhead($doc);
        $lstock=Common::localstock($doc);
        $glhead=Common::glhead();
        $glstock=Common::glstock();
        $ldetail=Common::localdetail($doc);
        $gldetail=Common::gldetail();
        $date=date("Y-m-d H:i:s");
        $docno=  Cntnum::getdocno($trno,$doc);
        $sku=' ';

        switch ($doc) {
            case 'TS':
                //for glhead
                $posthead=Yii::$app->sbccommon->execqry("
                insert into $glhead(trno,doc,docno,clientid,clientname,address,shipto,dateid,terms,
                whid,rem,forex,yourref,ourref,contra,agentid,tax,createdate,createby,editdate,editby,
                lockuser,lockdate,viewdate,viewby,
                modeofpayment,acctname,acctno,cardtype,salestype,trroute,trpricegrp)
                SELECT
                head.trno,head.doc, head.docno,client.clientid,client.clientname,
                address, shipto, head.dateid , head.terms,
                warehouse.clientid as whid,head.rem,head.forex, head.yourref, head.ourref,
                head.contra,ifNull(agent.clientid,0) as agent,
                head.tax , head.createdate,head.createby,head.editdate,head.editby,head.lockuser,
                head.lockdate,head.viewdate,head.viewby,head.modeofpayment,head.acctname,
                head.acctno,head.cardtype,'',head.trroute,head.trpricegrp
                FROM $lhead as head
                left join cntnum on cntnum.trno=head.trno
                left join client  on client.client=head.client
                left join client  as warehouse on warehouse.client=head.wh
                left join client  as agent on agent.client=head.agent
                where head.trno=".$trno);

                Cntnum::tsreverse($doc,$trno);
                    break;
            default:
                //for glhead
                $qry = "
                insert into $glhead(trno,doc,docno,clientid,clientname,address,shipto,dateid,terms,whid,rem,forex,
                yourref,ourref,contra,agentid,tax,
                createdate,createby,editdate,editby,lockuser,lockdate,viewdate,viewby,modeofpayment,acctname,acctno,
                cardtype,waybilldate,
                billlading,voyage,due,cur,vattype,salestype,checked,project,cmtrans,pickby,checkby,
                gm_purchasetype,ms_arastre,ms_freight,ms_wharffage,picker,checker,
                ewt,ewtrate,mlcp_jonum,mlcp_freight,invoiceno,invoicedate,uv_transtype,uv_amountreceived)
                SELECT
                head.trno,head.doc, head.docno,ifNull(client.clientid,0) as clientid,ifNull(client.clientname,'') as clientname,
                address, shipto,
                head.dateid , head.terms,
                ifnull(warehouse.clientid,0) as whid,head.rem,head.forex, head.yourref, head.ourref,head.contra,
                ifNull(agent.clientid,0) as agent,
                head.tax , head.createdate,head.createby,head.editdate,head.editby,head.lockuser,head.lockdate,
                head.viewdate,head.viewby,
                head.modeofpayment,head.acctname,head.acctno,head.cardtype,head.waybilldate,head.billlading,
                head.voyage,head.due,head.cur,head.vattype,head.salestype,head.checked,head.project,head.cmtrans,
                head.pickby,head.checkby,head.gm_purchasetype,
                head.ms_arastre,head.ms_freight,head.ms_wharffage,head.picker,head.checker,head.ewt,head.ewtrate,
                head.mlcp_jonum,head.mlcp_freight,head.invoiceno,head.invoicedate,head.uv_transtype,head.uv_amountreceived
                FROM $lhead as head
                left join cntnum on cntnum.trno=head.trno
                left join client  on head.client=client.client
                left join client  as warehouse on warehouse.client=head.wh
                left join client  as agent on agent.client=head.agent
                where head.trno=".$trno;

                $posthead=Yii::$app->sbccommon->execqry($qry);
                break;
        }//end switch

        //for glhead
        if($posthead==1) {
            //for glstock
            switch ($doc) {
                case 'SV':
                    $qrypost_stock = "insert into hspstock select * from spstock where sptrno =".$trno;
                break;

                default:
                    $qrypost_stock = "insert into $glstock(trno,line,refx,linex,tstrno,tsline,itemid,
                    itemname,uom,whid,loc,loc2,disc,cost,qty,rrcost,rrqty,ext,isqty,iss,amt,isamt,qa,ref,encodeddate,
                    encodedby,editdate,editby,rem,comm,icomm,expiry,isqty2,iss2,iscomponent,outputid,msako,tsako,itemhandling,itemcomm,
                    agentid,kgs,isfromjo, init_vat_value)
                    SELECT trno,stock.line,refx,linex,tstrno,tsline,itemid, stock.itemname,stock.uom,client.clientid as whid,stock.loc,stock.loc2,
                    stock.disc, stock.cost, stock.qty,stock.rrcost,stock.rrqty, stock.ext, stock.isqty,stock.iss,stock.amt,stock.isamt,
                    stock.qa, stock.ref,stock.encodeddate,stock.encodedby,stock.editdate,stock.editby,stock.rem,stock.comm,stock.icomm,stock.expiry,stock.isqty2,stock.iss2,stock.iscomponent,stock.outputid,stock.msako,stock.tsako,stock.itemhandling,stock.itemcomm,
                    ifnull(agent.clientid,0) as agentid,stock.kgs,stock.isfromjo, stock.init_vat_value
                    FROM $lstock as stock
                    left join item on item.barcode=stock.barcode
                    left join client on client.client=stock.wh
                    left join client as agent on agent.client = stock.agent
                    where trno =".$trno;
                    break;
            }//END SWITCH CASE

            if(Yii::$app->sbccommon->execqry($qrypost_stock)==1) {

                //for gldetail
                if(Yii::$app->sbccommon->execqry("
                    insert into $gldetail(postdate,trno,line,acnoid,acnoname,clientid,db,cr,fdb,fcr,refx,linex,encodeddate,encodedby,editdate,
                    editby,ref,checkno,rem,clearday,pdcline,project,isewt,isvat,ewtcode,ewtrate)
                    select d.postdate,d.trno,d.line,coa.acnoid,d.acnoname,
                    ifNull(client.clientid,0),d.db,d.cr,d.fdb,d.fcr,d.refx,d.linex,
                    d.encodeddate,d.encodedby,d.editdate,d.editby,d.ref,d.checkno,d.rem,d.clearday,d.pdcline,d.project,
                    d.isewt,d.isvat,d.ewtcode,d.ewtrate
                    from $lhead as h
                    left join $ldetail as d on d.trno=h.trno
                    left join client on client.client=d.client
                    left join coa on coa.acno=d.acno
                    where  d.trno=$trno
                        ")==1) {
                    //for apledger
                    if(Yii::$app->sbccommon->execqry("
                        insert into apledger(dateid,trno,line,acnoid,clientid,db,cr,bal,fdb,fcr,docno,ref)
                        select d.postdate,d.trno,line,coa.acnoid,ifNull(client.clientid,0),round(db,2),
                        round(cr,2),round(db,2)+round(cr,2) as bal,d.fdb,d.fcr,head.docno,d.ref
                        from $lhead as head
                        left join $ldetail as d on head.trno=d.trno
                        left join coa on coa.acno=d.acno
                        left join client on client.client=d.client
                        where left(coa.alias,2)='AP' and d.trno=$trno and d.refx=0")==1) {
                        //for arledger
                        if(Yii::$app->sbccommon->execqry("
                            insert into arledger(dateid,trno,line,acnoid,clientid,db,cr,bal,docno,ref,agentid)
                            select d.postdate,d.trno,line,coa.acnoid,ifNull(client.clientid,0),d.db,d.cr,d.db+d.cr as bal,head.docno,d.ref,ifnull(agent.clientid,0)
                            from $lhead as head
                            left join $ldetail as d on head.trno=d.trno
                            left join coa on coa.acno=d.acno
                            left join client on client.client=d.client
                            left join client as agent on agent.client=head.agent
                            where left(coa.alias,2)='AR' and d.trno=$trno and d.refx=0")==1) {
                            //for crledger
                            if(Yii::$app->sbccommon->execqry("
                                insert into crledger(checkdate,trno,line,acnoid,clientid,db,cr,docno,checkno)
                                select d.postdate,d.trno,line,coa.acnoid,ifNull(client.clientid,0),round(d.db,2),round(d.cr,2),head.docno,d.checkno
                                from $lhead as head
                                left join $ldetail as d on head.trno=d.trno
                                left join coa on coa.acno=d.acno
                                left join client on client.client=d.client
                                where left(coa.alias,2)='CR' and d.trno='$trno' and d.refx=0")==1) {
                                //for caledger                            
                                $isok=Yii::$app->sbccommon->execqry("
                                    insert into caledger(dateid,trno,line,acnoid,clientid,db,cr,docno)
                                    select d.postdate,d.trno,line,coa.acnoid,ifNull(client.clientid,0),round(d.db,2),round(d.cr,2),head.docno
                                    from $lhead as head
                                    left join $ldetail as d on head.trno=d.trno
                                    left join coa on coa.acno=d.acno
                                    left join client on client.client=d.client
                                    where left(coa.alias,2)='CA' and d.trno='$trno' and d.refx=0 ");
                                if($isok==1) {
                                    //for cbledger
                                   if($doc=='CV'){
                                        if(Yii::$app->sbccommon->execqry("
                                            insert into cbledger(checkdate,trno,line,acnoid,clientid,db,cr,docno,checkno)
                                            select d.postdate,d.trno,line,coa.acnoid,ifNull(client.clientid,0),round(d.db,2),round(d.cr,2),head.docno,d.checkno
                                            from $lhead as head
                                            left join $ldetail as d on head.trno=d.trno
                                            left join coa on coa.acno=d.acno
                                            left join client on client.client=d.client
                                            where left(coa.alias,2)='CB' and d.trno='$trno' and d.refx=0")==1) {

                                        }else {
                                            Cntnum::deletecaledger($trno);
                                            Cntnum::deletearledger($trno);
                                            Cntnum::deleteapledger($trno);
                                            Cntnum::deleteglstock($trno);
                                            Cntnum::deletegldetail($trno);
                                            Cntnum::deleteglhead($trno);
                                            return 'Error on Posting CBledger';
                                        }
                                   }//end cv

                                }else {
                                    Cntnum::deletecrledger($trno);
                                    Cntnum::deletearledger($trno);
                                    Cntnum::deleteapledger($trno);
                                    Cntnum::deleteglstock($trno);
                                    Cntnum::deletegldetail($trno);
                                    Cntnum::deleteglhead($trno);
                                    return 'Error on Posting CAledger';
                                }




                                if($doc=='PV' || $doc=='CV' || $doc=='CR' || $doc=='GJ' || $doc=='DS' || $doc=='KR' || $doc=='AR' || $doc=='AP') {

                                    Yii::$app->sbccommon->execqry("update cntnum set postdate='$date', postedby='$user' where trno='$trno'");
                                    
                                    Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
                                    Yii::$app->sbccommon->execqry("DELETE from $lstock where trno='$trno'");
                                    Yii::$app->sbccommon->execqry("DELETE from $ldetail where trno='$trno'");
                                    $result = Log::writelog($doc, $trno, 'POST', $docno,$user);
                                    return 1;

                                }else {
                                    $qtyfield='qty';
                                        switch ($doc) {
                                        case 'TS':case 'PU':
                                            $postrrstatus=Yii::$app->sbccommon->execqry("insert into rrstatus(trno,line,clientid,itemid,cost,qty,bal,dateid,whid,uom,disc,docno,loc,expiry)
                                            select stock.trno,stock.line,client.clientid,item.itemid,stock.cost,stock.qty,stock.qty,head.dateid,client.clientid,stock.uom,stock.disc,head.docno,stock.loc,stock.expiry 
                                            from $lhead as head
                                            left join $lstock  as stock on stock.trno=head.trno
                                            left join client on client.client=head.client
                                            left join item on item.barcode=stock.barcode
                                            left join client as wh on wh.client=stock.wh
                                            where head.trno=$trno and stock.qty<>0 and stock.iss=0");
                                        break;

                                        case 'RR':case 'CM':case 'IS':case 'AJ':case 'CA': case 'MI': case 'PK':
                                            $postrrstatus=Yii::$app->sbccommon->execqry("
                                            insert into rrstatus(trno,line,clientid,itemid,cost,qty,bal,dateid,whid,uom,disc,docno,loc,expiry)
                                            select stock.trno,stock.line,client.clientid,item.itemid,stock.cost,stock.".$qtyfield.",stock.".$qtyfield.",head.dateid,wh.clientid,stock.uom,stock.disc,head.docno,stock.loc,stock.expiry 
                                            from $lhead as head
                                            left join $lstock  as stock on stock.trno=head.trno
                                            left join client on client.client=head.client
                                            left join item on item.barcode=stock.barcode
                                            left join client as wh on wh.client=stock.wh
                                            where head.trno=$trno and stock.qty<>0 and stock.iss=0");
                                        break;
                                        default : 
                                            $postrrstatus=1;
                                        break;
                                        }//end case
                                }//end else on acctg;

                                if($postrrstatus==1){
                                    Yii::$app->sbccommon->execqry("update cntnum set postdate='$date',postedby='$user' where trno='$trno'");
                                    Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
                                    Yii::$app->sbccommon->execqry("DELETE from $lstock where trno='$trno'");
                                    Yii::$app->sbccommon->execqry("DELETE from $ldetail where trno='$trno'");

                                    if($doc == 'SV'){
                                        Yii::$app->sbccommon->execqry("DELETE from spstock where sptrno='$trno'"); //DELETES SP STOCK
                                    }//END IF
                                    
                                    $return = Log::writelog($doc, $trno, 'POST', $docno,$user);                          
                                    return 1;

                                }else {
                                    Cntnum::deletecrledger($trno);
                                    Cntnum::deletearledger($trno);
                                    Cntnum::deleteapledger($trno);
                                    Cntnum::deleteglstock($trno);
                                    Cntnum::deletegldetail($trno);
                                    Cntnum::deleteglhead($trno);
                                    return 'Error on Posting RRstatus';
                                }//end if post rrstatus = 1


                            }else {
                                Cntnum::deletearledger($trno);
                                Cntnum::deleteapledger($trno);
                                Cntnum::deleteglstock($trno);
                                Cntnum::deletegldetail($trno);
                                Cntnum::deleteglhead($trno);
                                return 'Error on Posting CRledger';
                            }

                        }else {
                            Cntnum::deleteapledger($trno);
                            Cntnum::deleteglstock($trno);
                            Cntnum::deletegldetail($trno);
                            Cntnum::deleteglhead($trno);
                            return 'Error on Posting ARledger';
                        }

                    }else {
                        Cntnum::deleteglstock($trno);
                        Cntnum::deletegldetail($trno);
                        Cntnum::deleteglhead($trno);
                        return 'Error on Posting APledger';
                    }
                }else{
                    Cntnum::deleteglstock($trno);
                    Cntnum::deleteglhead($trno);
                    return 'Error on Posting Details';
                }

            }else {
                Cntnum::deleteglhead($trno);
                return 'Error on Posting Stocks';
            }
        }else {
            return 'Error on Posting Head';
        }

        return 'ok';
    }//end function


    public static function PostTransTS($trno,$doc) {
        Yii::$app->systemsettings->setDefaultTimeZone();
        $lhead=Common::localhead($doc);
        $lstock=Common::localstock($doc);
        $glhead=Common::glhead();
        $glstock=Common::glstock();
        $ldetail=Common::localdetail($doc);
        $gldetail=Common::gldetail();
        $date=date("Y-m-d H:i:s");
        //for glhead
        Yii::$app->sbccommon->execqry("
            insert into $glhead(trno,doc,docno,clientid,clientname,address,shipto,dateid,terms,whid,rem,forex,yourref,ourref,contra,agentid,tax,createdate,createby,editdate,editby,lockuser,lockdate,viewdate,viewby)
            SELECT
            head.trno,head.doc, head.docno,client.clientid,client.clientname,address, shipto, head.dateid , head.terms,
            warehouse.clientid as whid,head.rem,head.forex, head.yourref, head.ourref,head.contra,ifNull(agent.clientid,0) as agent,
            head.tax , createdate,createby,editdate,editby,lockuser,lockdate,viewdate,viewby
            FROM $lhead as head
            left join cntnum on cntnum.trno=head.trno
            left join client  on head.client=client.client
            left join client  as warehouse on head.wh=warehouse.client
            left join client  as agent on head.agent=agent.client
            where head.trno=$trno limit 1
                ");
        //for glstock
        Yii::$app->sbccommon->execqry("
            insert into $glstock(trno,line,refx,linex,tstrno,tsline,itemid, itemname,uom,whid,loc,disc,cost,qty,rrcost,rrqty,ext,isqty,iss,amt,isamt,qa,ref,encodeddate,encodedby,editdate,editby)
            SELECT trno,stock.line,refx,linex,tstrno,tsline,itemid, stock.itemname,stock.uom,client.clientid as whid,stock.loc,
            stock.disc, stock.cost, stock.qty,rrcost,rrqty, ext, isqty,iss,stock.amt,isamt,
            qa, ref,encodeddate,encodedby,stock.editdate,stock.editby
            FROM $lstock as stock
            left join item on item.barcode=stock.barcode
            left join client on client.client=stock.wh
            where trno =$trno
                ");
        //for rrstatus
        Yii::$app->sbccommon->execqry("insert into rrstatus(trno,line,clientid,itemid,cost,qty,bal,dateid,whid,uom,disc,docno)
            select stock.trno,stock.line,client.clientid,item.itemid,stock.cost,stock.qty,stock.qty,head.dateid,client.clientid,stock.uom,stock.disc,head.docno
            from $lhead as head
            left join $lstock  as stock on stock.trno=head.trno
            left join client on client.client=head.client
            left join item on item.barcode=stock.barcode
            left join client as wh on wh.client=stock.wh
            where head.trno=$trno");
        
        Yii::$app->sbccommon->execqry("update cntnum set postdate='$date' where trno='$trno'");

        Yii::$app->sbccommon->execqry("delete from ".$lhead." where trno=".$trno);
        Yii::$app->sbccommon->execqry("delete from ".$lstock." where trno=".$trno);
        Yii::$app->sbccommon->execqry("delete from ".$ldetail." where trno=".$trno);
        return 1;
    }

    public static function UnpostTrans($trno,$doc,$user) {
        Yii::$app->systemsettings->setDefaultTimeZone();
        $lhead=Common::localhead($doc);
        $lstock=Common::localstock($doc);

        $glhead=Common::glhead();
        $glstock=Common::glstock();

        $ldetail=Common::localdetail($doc);
        $gldetail=Common::gldetail();
        $date=date("Y-m-d H:i:s");
        $docno=  Cntnum::getdocno($trno,$doc);
        
        
        if(Cntnum::hasbeendeposited($trno)) {
            return "This Transaction cannot be UNPOSTED, It has already been DEPOSITED";
        }else {
            if(Cntnum::hasbeenreturned($trno)) {
                return "This Transaction cannot be UNPOSTED, It has already been RETURNED";
            }else {
                if(Cntnum::hasbeencountered($trno)) {
                    return "This Transaction cannot be UNPOSTED, A COUNTER RECEIPT has already been Issued";
                }else {
                    if(Cntnum::hasbeenserved($trno)) {
                        return "This Transaction cannot be UNPOSTED, It has already been SERVED";
                    }else {
                        switch ($doc) {
                            case 'MI':
                                $appaid = 0;
                                break;
                            
                            default:
                                $appaid = Cntnum::APpaid($trno);
                                break;
                        }//END IF

                        if($appaid) {
                            return "This Transaction cannot be UNPOSTED, It has already been PAID";
                        }else {
                            switch ($doc) {
                                case 'MI':
                                    $arpaid = 0;
                                    break;
                                
                                default:
                                    $arpaid = Cntnum::ARpaid($trno);
                                    break;
                            }//END IF
                            if($arpaid) {
                                return "This Transaction cannot be UNPOSTED, It has already been PAID";
                            }
                            else {
                                //unposting head
                                if(Yii::$app->sbccommon->execqry("
                                        insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,wh,rem,forex,yourref,ourref,
                                        contra,agent,tax,createdate,createby,editdate,editby,lockuser,lockdate,viewdate,
                                        viewby,modeofpayment,acctname,acctno,cardtype,waybilldate,billlading,voyage,due,cur,vattype,salestype,
                                        checked,trpricegrp,trroute,project,cmtrans,pickby,checkby,gm_purchasetype,ms_arastre,
                                        ms_freight,ms_wharffage,picker,checker,
                                        ewt,ewtrate,mlcp_jonum,mlcp_freight,invoiceno,invoicedate,uv_transtype,uv_amountreceived)
                                        select head.trno,head.doc, head.docno, ifnull(client.client,'') as client, ifnull(client.clientname,'') as clientname,
                                        head.address, head.shipto, head.dateid, head.terms, ifnull(warehouse.client,'') as wh, head.rem, head.forex,
                                        head.yourref, head.ourref, head.contra, ifNull(agent.client,'') as agent, head.tax , head.createdate,head.createby,
                                        head.editdate, head.editby, head.lockuser, head.lockdate, head.viewdate, head.viewby,head.modeofpayment,
                                        head.acctname,head.acctno,head.cardtype,head.waybilldate,head.billlading,head.voyage,head.due,head.cur,
                                        head.vattype,head.salestype,head.checked,head.trpricegrp,head.trroute,head.project,head.cmtrans,
                                        head.pickby,head.checkby,head.gm_purchasetype,
                                        head.ms_arastre,head.ms_freight,head.ms_wharffage,head.picker,head.checker,head.ewt,
                                        head.ewtrate,head.mlcp_jonum,head.mlcp_freight,head.invoiceno,head.invoicedate,head.uv_transtype,head.uv_amountreceived
                                        from glhead as head left join cntnum on cntnum.trno=head.trno
                                        left join client  on head.clientid=client.clientid
                                        left join client  as warehouse on head.whid=warehouse.clientid
                                        left join client  as agent on head.agentid=agent.clientid
                                        where head.trno=$trno limit 1")==1) {
                                    //unposting stocks
                                    switch ($doc) {
                                        case 'SV':
                                            $qryunpost_stock = "insert into spstock select * from hspstock where sptrno = " . $trno;
                                        break;
                                        
                                        default:
                                            $qryunpost_stock = "insert into $lstock(trno,line,refx,linex,barcode, itemname,uom,wh,loc,loc2,expiry,
                                            disc,cost,qty,rrcost,rrqty,ext,isqty,iss,amt,isamt,qa,ref,encodeddate,encodedby,editdate,editby,
                                            rem,comm,icomm,tstrno,tsline,iss2,isqty2,iscomponent,outputid,msako,tsako,itemhandling,itemcomm,agent,kgs,isfromjo, init_vat_value)
                                            SELECT stock.trno, stock.line, stock.refx, stock.linex, item.barcode, stock.itemname,
                                            stock.uom, client.client as wh,stock.loc,stock.loc2,stock.expiry,
                                            stock.disc, stock.cost, stock.qty, stock.rrcost, stock.rrqty, stock.ext, stock.isqty, stock.iss, stock.amt,
                                            stock.isamt, stock.qa, stock.ref, encodeddate, encodedby, stock.editdate, 
                                            stock.editby,stock.rem,stock.comm,stock.icomm,stock.tstrno,stock.tsline,
                                            stock.iss2,stock.isqty2,stock.iscomponent,stock.outputid,stock.msako,stock.tsako,
                                            stock.itemhandling,stock.itemcomm,ifnull(agent.client,'') as agent,stock.kgs,stock.isfromjo, stock.init_vat_value FROM glstock as stock 
                                            left join item on item.itemid=stock.itemid
                                            left join client on client.clientid=stock.whid
                                            left join client as agent on agent.clientid=stock.agentid
                                            where trno =".$trno." and tstrno=0";
                                            //echo $qryunpost_stock;
                                        break;
                                    }//end switch
                                   

                                    if(Yii::$app->sbccommon->execqry($qryunpost_stock)==1) {
                                        
                                        //unposting details
                                        if(Yii::$app->sbccommon->execqry("insert into $ldetail
                                        (postdate,trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,
                                        ref,encodeddate,encodedby,editdate,editby,checkno,rem,clearday,pdcline,project,
                                        isewt,isvat,ewtcode,ewtrate)
                                        select d.postdate, d.trno, d.line, coa.acno, d.acnoname, ifNull(client.client,''), 
                                        d.db, d.cr, d.fdb, d.fcr, d.refx, d.linex, d.ref, d.encodeddate, d.encodedby, 
                                        d.editdate, d.editby,d.checkno,d.rem,d.clearday,d.pdcline,d.project,
                                        d.isewt,d.isvat,d.ewtcode,d.ewtrate
                                        from glhead as h 
                                        left join gldetail as d on h.trno=d.trno 
                                        left join client on d.clientid=client.clientid 
                                        left join coa on d.acnoid=coa.acnoid
                                        where d.trno=$trno")==1) {

                                            Yii::$app->sbccommon->execqry("update cntnum set postdate=null where trno='$trno'");
                                            if($doc == 'SV'){
                                                Yii::$app->sbccommon->execqry("delete from hspstock where sptrno = ".$trno);
                                            }//end if
                                            Cntnum::deletegldetail($trno);
                                            Cntnum::deleteglstock($trno);
                                            Cntnum::deleteglhead($trno);
                                            Cntnum::deleterrstatus($trno);
                                            Cntnum::deleteapledger($trno);
                                            Cntnum::deletearledger($trno);
                                            Cntnum::deletecrledger($trno);
                                            Cntnum::deletecaledger($trno);
                                            Cntnum::deletecbledger($trno);
                                            Cntnum::deletepayment($trno);
                                            Cntnum::deletedeposit($trno);

                                            switch ($doc) {
                                                case 'RR': case 'DM': case 'SJ': case 'CM': case 'IS': case 'AJ': case 'CH': case 'PK': case 'SV': case 'MI':
                                                    $result = Ladetail::deletedetail($doc, $trno);
                                                    break;                                                
                                            }

                                            $result = Log::writelog($doc, $trno, 'UNPOST', $docno,$user);
                                            return 1;

                                        }else {
                                            Cntnum::deletelstock($trno, $doc);
                                            Cntnum::deletelhead($trno, $doc);
                                            return 'Error on unPosting Details';
                                        }
                                    }else {
                                        Cntnum::deletelhead($trno, $doc);
                                        return 'Error on unPosting Stocks';
                                    }

                                }else {
                                    return 'Error on unPosting Head';
                                }


                            }
                        }
                    }
                }
            }
        }
    }//end f

    public static function hasbeenserved($trno) {
        return Yii::$app->sbccommon->datareader("select trno from rrstatus where trno=$trno and bal<>qty");
    }//end f

    public static function hasbeendeposited($trno) {
        $crstat = Yii::$app->sbccommon->datareader("select trno from crledger where trno=$trno and depodate is not null");
        $castat = Yii::$app->sbccommon->datareader("select trno from caledger where trno=$trno and depodate is not null");

        if(!empty($crstat) || !empty($castat)){
            return 1;
        }else{
            return 0;
        }//end if
    }//end f

    public static function hasbeenreturned($trno) {
        return Yii::$app->sbccommon->datareader("select trno from glstock where trno=$trno and qa<>0");
    }//end f

    public static function hasbeencountered($trno) {
        return Yii::$app->sbccommon->datareader("select trno from arledger where trno=$trno and kr<>0 ");
    }//end f

    public static function APpaid($trno) {
        return Yii::$app->sbccommon->datareader("select trno from apledger where trno=$trno and bal<>abs(db+cr) ");
    }//end f

    public static function ARpaid($trno) {
        return Yii::$app->sbccommon->datareader("select trno from arledger where trno=$trno and bal<>abs(db+cr) ");
    }//end f

    public static function deletelhead($trno,$doc) {
        $lhead=Common::localhead($doc);
        Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
    }//end f

    public static function deletelstock($trno,$doc) {
        $lstock=Common::localstock($doc);
        Yii::$app->sbccommon->execqry("DELETE from $lstock where trno='$trno'");
    }//end f

    public static function deleteldetail($trno,$doc) {
        $ldetail=Common::localdetail($doc);
        Yii::$app->sbccommon->execqry("DELETE from $ldetail where trno='$trno'");
    }//end f


    public static function deleteglhead($trno) {
        Yii::$app->sbccommon->execqry("DELETE from glhead where trno='$trno'");
    }
    public static function deleteglstock($trno) {
        Yii::$app->sbccommon->execqry("DELETE from glstock where trno='$trno'");
    }
    public static function deletegldetail($trno) {
        Yii::$app->sbccommon->execqry("DELETE from gldetail where trno='$trno'");
    }
    public static function deleteapledger($trno) {
        Yii::$app->sbccommon->execqry("DELETE from apledger where trno='$trno'");
    }
    public static function deletearledger($trno) {
        Yii::$app->sbccommon->execqry("DELETE from arledger where trno='$trno'");
    }
    public static function deletecrledger($trno) {
        Yii::$app->sbccommon->execqry("DELETE from crledger where trno='$trno'");
    }
    public static function deletecaledger($trno) {
        Yii::$app->sbccommon->execqry("DELETE from caledger where trno='$trno'");
    }
    public static function deletecbledger($trno) {
        Yii::$app->sbccommon->execqry("DELETE from cbledger where trno='$trno'");
    }
    public static function deletepayment($trno) {
        Yii::$app->sbccommon->execqry("DELETE from payment where trno='$trno'");
    }
    public static function deletedeposit($trno) {
        Yii::$app->sbccommon->execqry("DELETE from deposit where trno='$trno'");
    }
    public static function deleterrstatus($trno) {
        Yii::$app->sbccommon->execqry("DELETE from rrstatus where trno='$trno'");
    }
    
    public static function getdocno($trno,$doc) {
        $table = Common::gettablenum($doc);
        return Yii::$app->sbccommon->datareader("SELECT docno from $table where trno='$trno' limit 1");
    }
    public static function updatedocno($docno,$trno,$doc) {
        $lhead=Common::localhead($doc);
        $common=new Common();
        $pref = $common->GetPrefix($docno);
        $table = Common::gettablenum($doc);
        $seq=substr($docno,$common->SearchPosition($docno),strlen($docno));
        Yii::$app->sbccommon->execqry("Update $table set docno='$docno',bref='$pref', seq='$seq' where trno='$trno'");
        Yii::$app->sbccommon->execqry("Update $lhead set docno='$docno' where trno='$trno'");
    }


public static function checkitemzero($trno,$doc){
    $table = Common::localstock($doc);
    switch ($doc) {
        case 'RR': case 'DM': case 'SJ': case 'CM': case 'IS': case 'AJ': case 'TS': case 'PK':
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'INFINITEA':
                    return 0;
                break;
                  
                default:
                    $q = Yii::$app->sbccommon->opentable("select trno from ".$table." where trno=".$trno." and iss=0 and qty=0 limit 1");
                    Yii::$app->sbccommon->execqry("delete from lastock where trno=".$trno." and tstrno<>0");
                    if(empty($q)){
                      return 0;
                    }else{
                    return 1;
                    }//END IF
                break;
            }//end INFINITEA
        break;

        case 'SP':
            $q = Yii::$app->sbccommon->opentable("select sptrno as trno from spstock where sptrno=".$trno." and iss=0 and qty=0 limit 1");
            Yii::$app->sbccommon->execqry("delete from lastock where trno=".$trno." and tstrno<>0");
            if(empty($q)){
              return 0;
            }else{
            return 1;
            }//END IF
        break;

        default:
            return 0;
        break;
    }//end first level switch case
}//end if checkitemzero


    public static function IsbalancedTrans($trno,$module) {
        $table=Common::localdetail($module);
        $qry = "select ifnull(sum(db-cr),0) as bal from $table where trno='$trno'";
        
        $bal=Yii::$app->sbccommon->datareader($qry);
        
        if ($bal!=0) {
            return false;
        }else {
            return true;
        }//end if
    }





}