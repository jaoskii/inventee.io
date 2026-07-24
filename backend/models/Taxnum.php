<?php
namespace app\models;

use Yii;

use yii\base\Model;
use yii\base\ErrorException;

class Taxnum extends Model {
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
                //array('LockUser, OpenBy, Users, PostedBy', 'length', 'max'=>50),
                //array('CancelledBy, DispatchBy, Driver, PlateNo, center', 'length', 'max'=>45),
                //array('SITrno', 'length', 'max'=>20),
                //array('PostDate, LockDate, Deposit, CancelledDate, DispatchDate', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
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
                case 'TW':
                    $htable = Common::localhhead($doc);
                    $islocked= Yii::$app->sbccommon->datareader("SELECT lockdate from taxhead where trno='$trno' union all SELECT lockdate from htaxhead where trno='$trno'");
                    break;
                default:
                    $islocked= Yii::$app->sbccommon->datareader("SELECT lockdate from taxhead where trno='$trno' union all SELECT lockdate from htaxhead where trno='$trno'");
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

        }

    public static function isPosted($trno,$doc) {
        $table = Common::gettablenum($doc);
        $document = Yii::$app->sbccommon->opentable("select postdate FROM taxnum where trno ='".$trno."' limit 1");
        $blnposted=false;
        if (isset($document[0]['postdate']) && ($document[0]['postdate'])!=null) {
            $blnposted=true;
        }
        return $blnposted;

    }


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
                SELECT stock.trno,".$last_line.",0,0,stock.trno,stock.line,item.barcode, stock.itemname,stock.uom,dest.client,
                stock.loc2,
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

    //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD posting
    public static function PostTrans($trno,$doc,$user){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $date=date("Y-m-d H:i:s");
            $posted=false;
            $docno=Taxnum::getdocno($trno,$doc);

                          
                    if(Yii::$app->sbccommon->execqry("insert into htaxhead(trno,doc,docno,client,clientname,address,dateid,dateid2,createdate,createby,
                        editby,editdate,lockdate,lockuser,quarter)
                        SELECT head.trno,head.doc, head.docno,head.client, head.clientname, head.address, head.dateid,head.dateid2,
                        head.createdate,head.createby,head.editby,
                        head.editdate, head.lockdate,head.lockuser,head.quarter
                        FROM taxhead as head left join taxnum on taxnum.trno=head.trno where head.trno=$trno limit 1")==1){

                        if(Yii::$app->sbccommon->execqry("insert into htaxdetail(trno,line,acno,acnoname,rate,income,wheld,month,encodeddate,encodedby,editdate,editby)
                        SELECT trno, line, acno, acnoname, rate,income,wheld,month,encodeddate,encodedby,editdate,editby
                        FROM taxdetail where trno=$trno")==1){
                            $posted=true;   
                        }else{
                            // Taxnum::deletehead($trno, $doc);
                        }//end if else
                        }//end if insert into FOR PI

            if($posted){
                if(Yii::$app->sbccommon->execqry("update taxnum set postdate='$date',postedby='$user' where trno='$trno'")==1){
                    //Log::writelog($doc, $trno, 'POST', $docno,$user);                                
                    Yii::$app->sbccommon->execqry("DELETE from taxhead where trno='$trno'");
                    Yii::$app->sbccommon->execqry("DELETE from taxdetail where trno='$trno'");
                    return 1;
                }else{
                    //Transnum::deletestock($trno, $doc);
                }//END IF UPDATE TRANS
            }//END IF POSTED

        }//END FUNCTION POSTTRANS


    public static function deletehead($trno,$doc){
        Yii::$app->sbccommon->execqry("DELETE from taxhead where trno='$trno'");
    }    

    //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD unposting
    public static function UnpostTrans($trno,$doc,$user) {
            $sql='';

                    $sql="insert into taxhead(trno,doc,docno,client,clientname,address,dateid,dateid2,createdate,createby,
                        editby,editdate,lockdate,lockuser,quarter)
                        SELECT head.trno,head.doc, head.docno,head.client, head.clientname, head.address, head.dateid,head.dateid2,
                        head.createdate,head.createby,head.editby,
                        head.editdate, head.lockdate,head.lockuser,head.quarter
                        FROM htaxhead as head left join taxnum on taxnum.trno=head.trno where head.trno=$trno limit 1";


             if(Yii::$app->sbccommon->execqry($sql)==1){
                $unposted=true;
                        //unposting stock
                            if(Yii::$app->sbccommon->execqry("insert into taxdetail(trno,line,acno,acnoname,rate,income,wheld,month,encodeddate,encodedby,editdate,editby)
                                SELECT trno, line, acno, acnoname, rate,income,wheld,month,encodeddate,encodedby,editdate,editby
                                FROM htaxdetail where trno=$trno")==1){
                            }else{
                                Taxnum::deletelhead($trno, $doc);
                                return 'Error on unPosting Stocks';
                            }//END IF INSERT LOCALSTOCK
                      
                    } else{
                return 'Error on Unposting Head';
            }//END ELSE UNPOSTING HEAD
            
            if($unposted){
                Yii::$app->sbccommon->execqry("update taxnum set postdate=null, postedby='' where trno='$trno'");
                //Log::writelog($doc, $trno, 'UNPOST', $docno,$user);
                Yii::$app->sbccommon->execqry("delete from htaxhead where trno=$trno");
                Yii::$app->sbccommon->execqry("delete from htaxdetail where trno=$trno");
                return 1;
            }//END IF UNPOSTED IS TRUE
    }
    public static function hasbeenserved($trno) {
        return Yii::$app->sbccommon->datareader("select trno from rrstatus where trno=$trno and bal<>qty");
    }
    public static function hasbeendeposited($trno) {
        return Yii::$app->sbccommon->datareader("select trno from crledger where trno=$trno and depodate is not null");
    }
    public static function hasbeenreturned($trno) {
        return Yii::$app->sbccommon->datareader("select trno from glstock where trno=$trno and qa<>0");
    }
    public static function hasbeencountered($trno) {
        return Yii::$app->sbccommon->datareader("select trno from arledger where trno=$trno and kr<>0 ");
    }
    public static function APpaid($trno) {
        return Yii::$app->sbccommon->datareader("select trno from apledger where trno=$trno and bal<>abs(db+cr) ");
    }
    public static function ARpaid($trno) {
        return Yii::$app->sbccommon->datareader("select trno from arledger where trno=$trno and bal<>abs(db+cr) ");
    }
    public static function deletelhead($trno,$doc) {
        $lhead=Common::localhead($doc);
        Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
    }
    public static function deletelstock($trno,$doc) {
        $lstock=Common::localstock($doc);
        Yii::$app->sbccommon->execqry("DELETE from $lstock where trno='$trno'");
    }
    public static function deleteldetail($trno,$doc) {
        $ldetail=Common::localdetail($doc);
        Yii::$app->sbccommon->execqry("DELETE from $ldetail where trno='$trno'");
    }


    public static function deleteglhead($trno) {
        Yii::$app->sbccommon->execqry("DELETE from htaxhead where trno='$trno'");
    }
    public static function deleteglstock($trno) {
        Yii::$app->sbccommon->execqry("DELETE from glstock where trno='$trno'");
    }
    public static function deletegldetail($trno) {
        Yii::$app->sbccommon->execqry("DELETE from htaxdetail where trno='$trno'");
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
        return Yii::$app->sbccommon->datareader("SELECT docno from taxhead where trno='$trno' limit 1");
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

            default:
                return 0;
            break;
        }//end first level switch case
    }//end if checkitemzero


    public static function IsbalancedTrans($trno,$module) {
        $table=Common::localdetail($module);
        $bal=Yii::$app->sbccommon->datareader("select ifnull(sum(db-cr),0) as bal from $table where trno='$trno'");
        if ($bal!=0) {
            return false;
        }
        else {
            return true;
        }
    }//end fn

}//end class