<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Transnum extends model
{
        public $trno;
        public $seq;
        public $doc;
        public $docno;
        public $bref;
        public $createdate;
        public $module;

        public $date;
        public $keyword;
        public $action;

        public function rules(){

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
        public static function gettrno($docno)
        {
          $center=Yii::$app->user->center;
          $check= Yii::$app->sbccommon->datareader("select trno from transnum where docno='$docno' and center='$center'");
          return $check;
        }
        public static function getTrnodocno($docno)
        {
           $center=Yii::$app->user->center;
           $trno= Yii::$app->sbccommon->opentable("SELECT trno,docno from transnum where docno='$docno' and center='$center'");
           return $trno;
        }
        public static function checkdocno($pref)
        {   $center=Yii::$app->user->center;
            $docno = Yii::$app->sbccommon->opentable("SELECT docno FROM transnum where bref ='$pref' and center='$center'");
            return $docno;
        }
        public static function isPosted($trno)
        {
            $document = Yii::$app->sbccommon->opentable("SELECT postdate FROM transnum where trno ='$trno'");
            if (!empty($document))
                {
                if ($document[0]['postdate']==0)
                    {
                    return false;
                    }
                else
                    {
                    return true;
                    }
                }
        }
        public static function isUnPostedJOservice($trno)
        {
            $document = Yii::$app->sbccommon->opentable("SELECT count(line) as line FROM joservice where trno ='$trno'");
            if (!empty($document))
                {
                if ($document[0]['line']==0)
                    {
                    return false;
                    }
                else
                    {
                    return true;
                    }
                }
        }
        public static function isPostedJOservice($trno,$line)
        {
            $document = Yii::$app->sbccommon->opentable("SELECT postdate FROM hjoservice where md5(trno) ='$trno' and md5(line) ='$line'");
            if (!empty($document))
                {
                if ($document[0]['postdate']==0)
                    {
                    return false;
                    }
                else
                    {
                    return true;
                    }
                }
        }

        public static function getclientname($client)
        {
            return Yii::$app->sbccommon->datareader("SELECT clientname from transnum where client='$client' limit 1");
        }
        public static function updatedocno($docno,$trno,$doc)
        {
            $common=new Common();
            $lhead=$common->localhead($doc);
            $pref = $common->GetPrefix($docno);
            $seq=substr($docno,$common->SearchPosition($docno),strlen($docno));
            Yii::$app->sbccommon->execqry("Update transnum set docno='$docno', seq='$seq' where trno='$trno'");
            Yii::$app->sbccommon->execqry("Update $lhead set docno='$docno' where trno='$trno'");
        }
        public static function insertcntnum($doc, $docno, $seq, $bref)
        {
            $user=Yii::$app->user->username;
            $center=Yii::$app->user->center;
            return Yii::$app->sbccommon->execqry("INSERT into transnum (doc, docno, seq, bref, center) values ('$doc','$docno','$seq','$bref','$center')");
        }
        public static function delete($doc,$trno)   //for deleting
        {
            switch ($doc)
            {
                case 'PO':
                case 'SO':
                case 'QA':
                    {
                    $stock=Common::localstock($doc);
                    $head=Common::localhead($doc);
                    Transnum::deleteTrans($stock, $head, $trno);
                    break;
                    }
            }
        }
        public static function deleteTrans($stock, $head, $trno)
        {
            Yii::$app->sbccommon->execqry("DELETE from $stock where trno='$trno'");
            Yii::$app->sbccommon->execqry("DELETE from $head where trno='$trno'");
            Yii::$app->sbccommon->execqry("DELETE from transnum where trno='$trno'");
        }
        public static function getlastseq($prefix)
        {
            $center=Yii::$app->user->center;
            return Yii::$app->sbccommon->datareader("select max(seq)+1 as seq from transnum where bref='$prefix' and center='$center'");
        }
        public static function last_bref($module)
        {
            $center=Yii::$app->user->center;
            $last = Yii::$app->sbccommon->datareader("SELECT bref FROM transnum where doc ='$module' and center='$center' order by trno desc limit 1");
            return $last;
        }
        public static function navnext_prev($docno,$trno,$doc,$action)
        {
            switch ($doc)
            {   
                // SALON MODIFICATION
                case 'TR':
                // END SALON
                case 'PO':case 'PC':
                case 'SO':case 'KR':
                case 'EX':case 'JO':
                case 'QA':
                    {
                        switch ($action)
                            {
                                case 'next':{
                                    $trno= Transnum::nextdoc($docno,$doc, $trno);
                                    return $trno;
                                    break;
                                }
                                case 'previous':{
                                    $trno= Transnum::previousdoc($docno,$doc, $trno);
                                    return $trno;
                                    break;
                                }
                                case 'delete':{
                                    $newtrno= Transnum::nextdoc($docno,$doc, $trno);
                                    if ($newtrno==$trno){
                                        $newtrno= Transnum::previousdoc($docno,$doc, $trno);
                                        if ($newtrno==$trno){
                                            $newtrno="";
                                        }
                                    }
                                    return $newtrno;
                                    break;
                                }
                            }
                    }

                case 'Customer':
                    {
                    $clientid=$trno;
                        switch ($action)
                            {
                                case 'next':
                                    {   $clientid= Transnum::nextfile($clientid);
                                        return $clientid;
                                        break;
                                    }
                                case 'previous':
                                    {   $clientid= Transnum::previousfile($clientid);
                                        return $clientid;
                                        break;
                                    }
                            }
                    }
            }
        }
        public static function nextdoc($docno,$doc,$trno)
        {
            $center= Yii::$app->user->center;
            $records=Yii::$app->sbccommon->opentable("select trno from transnum where doc='$doc' and center='$center' order by docno asc");
            $lastrecord=Yii::$app->sbccommon->datareader("select trno from transnum where doc='$doc' and center='$center' order by docno desc limit 1");
            $last=count($records)-1;
            if( !empty($lastrecord))
            {
                if($trno==$lastrecord  && !empty($lastrecord))
                {
                    $trno=$records[$last]['trno'];
                    return $trno;
                }
                else
                {
                    for($i=0;$i<count($records);$i++)
                    {
                        if($trno==$records[$i]['trno'])
                            {
                                $id=$i+1;
                                $trno= $records[$id]['trno'];
                                return $trno;
                            }
                    }
                }
            }
        }
        public static function previousdoc($docno,$doc,$trno)
        {
            $center= Yii::$app->user->center;
            $records=Yii::$app->sbccommon->opentable("select trno from transnum where doc='$doc' and center='$center' order by docno asc");
            $firstrecord=Yii::$app->sbccommon->datareader("select trno from transnum where doc='$doc' and center='$center' order by docno asc limit 1");
            if( !empty($firstrecord))
            {
                if($trno==$firstrecord)
                {
                    $trno=$records[0]['trno'];
                    return $trno;
                }
                else
                {
                    for($i=0;$i<count($records);$i++)
                    {
                        if($trno==$records[$i]['trno'])
                            {
                                $id=$i-1;
                                $trno= $records[$id]['trno'];
                                return $trno;
                            }
                    }
                }
            }
        }
        public static function navfirst_last($docno,$trno,$doc,$action)
        {
            switch ($doc)
            {
                // SALON MODIFICATION
                case 'TR':
                // END SALON
                case 'PO':case 'PC':
                case 'SO':case 'KR':case 'JO':
                case 'EX':
                    {
                        $trno = Transnum::first_lastdoc($docno,$doc, $trno, $action);
                        return $trno;
                        break;
                    }
                 case 'Customer':
                    {
                        $clientid=$trno;
                        $clientid = Transnum::first_lastfile($action);
                        return $clientid;
                        break;
                    }
            }
        }
        public static function first_lastdoc($docno,$doc,$trno,$action)
        {
            $center= Yii::$app->user->center;
            if($action=="first")
                {
                    $trno=Yii::$app->sbccommon->datareader("select trno from transnum where doc='$doc' and center='$center' order by docno asc limit 1");
                    return $trno;
                }
           if($action=="last")
                {
                    $trno=Yii::$app->sbccommon->datareader("select trno from transnum where doc='$doc' and center='$center' order by docno desc limit 1");
                    return $trno;
                }
        }
        public static function PostTrans($trno,$doc,$user){
            $date=date("Y-m-d H:i:s");
            $posted=false;
            $lhead=Common::localhead($doc);
            $lstock=Common::localstock($doc);
            $hhead=Common::localhhead($doc);
            $hstock=Common::localhstock($doc);
            $docno=Cntnum::getdocno($trno,$doc);
            
            switch ($doc) {
                case 'EX':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,description,dateid,amount,createdate,createby,editby,
                    editdate,viewby,viewdate,lockuser,lockdate) select trno,doc,docno,description,dateid,amount,createdate,
                    createby,editby,editdate,viewby,viewdate,lockuser,lockdate from $lhead where trno=$trno")==1){
                                          Transnum::deletelhead($trno, $doc);
                        if(Yii::$app->sbccommon->execqry("update transnum set postdate='$date',postedby='$user' where trno='$trno'")==1){
                            Log::writelog($doc, $trno, 'POST', $docno,$user);
                            Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
                            return 1;
                        }//END IF UPDATE TRANSNUM
                }//end if insert into for EX
                    break;

                case 'JO':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,itemname,tel,dateid,due,barcode,
                    sku,rem,yourref,ourref,invdate,approvedby,approveddate,createdate,createby,editby,editdate,viewby,viewdate,lockuser,lockdate)
                    select trno,doc,docno,client,clientname,address,itemname,tel,dateid,due,barcode,sku,rem,yourref,ourref,invdate,approvedby,
                    approveddate,createdate,createby,editby,editdate,viewby,viewdate,lockuser,lockdate from $lhead where trno=$trno")==1){
                        Transnum::deletelhead($trno, $doc);
                        if(Yii::$app->sbccommon->execqry("update transnum set postdate='$date',postedby='$user' where trno='$trno'")==1){
                            Log::writelog($doc, $trno, 'POST', $docno,$user);
                            Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
                            return 1;
                        }//end if update trans num
                }//END IF INSERT INTO FOR JO
                    break;

                case 'PI':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,
                    rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,agent,wh,due,cur,overhead,labor)
                    SELECT head.trno,head.doc, head.docno,head.client, head.clientname, head.address, head.shipto,head.dateid as dateid,
                    head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,head.createby,head.editby,
                    head.editdate, head.lockdate,head.lockuser,head.agent,head.wh,head.due,head.cur,head.overhead,head.labor
                    FROM $lhead as head left join cntnum on cntnum.trno=head.trno where head.trno=$trno limit 1")==1){

                        if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,cost,qty,void,
                        rrcost,rrqty,ext,encodeddate,qa,encodedby,editdate,editby,sku)
                        SELECT trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void,
                        rrcost, rrqty, ext, encodeddate,qa, encodedby,editdate,editby,sku
                        FROM $lstock where trno =$trno")==1){
                            $posted=true;
                        }else{
                            Transnum::deletehead($trno, $doc);
                        }//end if else
                }//end if insert into FOR PI
                      break;  

                case 'PD':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,
                    rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,agent,wh,due,cur,delivdate,pi,prc)
                    SELECT head.trno,head.doc, head.docno,head.client, head.clientname, head.address, head.shipto,head.dateid as dateid,
                    head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,head.createby,head.editby,
                    head.editdate, head.lockdate,head.lockuser,head.agent,head.wh,head.due,head.cur,head.delivdate,head.pi,''
                    FROM $lhead as head left join cntnum on cntnum.trno=head.trno where head.trno=$trno limit 1")==1){

                        if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,cost,qty,void,
                        rrcost,rrqty,ext,encodeddate,qa,encodedby,editdate,editby,sku,iss)
                        SELECT trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void,
                        rrcost, rrqty, ext, encodeddate,qa, encodedby,editdate,editby,sku,iss
                        FROM $lstock where trno =$trno")==1){
                            $posted=true;
                        }else{
                            Transnum::deletehead($trno, $doc);
                        }//end if else
                    }//end if insert into FOR PI
                      break;

                case 'RF':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,
                    dateid,terms,rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,
                    lockuser,agent,wh,mop,moddate,modamt,modref,salestype,trnx_type,route,routeid) SELECT head.trno,head.doc, head.docno,client.client,
                    head.clientname, head.address, head.shipto,head.dateid as dateid, head.terms, head.rem, head.forex,
                    head.yourref, head.ourref, head.createdate,head.createby,head.editby,head.editdate,
                    head.lockdate,head.lockuser,head.agent,head.wh,head.mop, head.moddate,head.modamt,head.modref,head.salestype,
                    head.trnx_type,head.route,head.routeid
                    FROM $lhead as head left join transnum on transnum.trno=head.trno 
                    left join client on head.client=client.client
                    where head.trno=$trno limit 1")==1){
                        $soapprovalcode = Yii::$app->sbccommon->datareader("select yourref from hrfhead where trno = ".$trno."");
                        $qryupdateso = "update hsohead set rf_approval = '".$soapprovalcode."' where rf_no = ".$trno."";
                        Yii::$app->sbccommon->execqry($qryupdateso); 
                        $posted=true;                                        
                    }else{
                        Transnum::deletehead($trno, $doc);
                    }//END INSERT 
                    break;

                case 'TX':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead (trno,docno,rfdocno,rftrno,dateid,rem,createdby,viewby,viewdate,invoiced,generatedrg,
                    txtruck,txchecker,txdriver,txdispatchdate,txreturndate,lockdate,lockuser)
                    select trno,docno,rfdocno,rftrno,dateid,rem,createdby,viewby,viewdate,invoiced,generatedrg,txtruck,txchecker,
                    txdriver,txdispatchdate,txreturndate,lockdate,lockuser from $lhead where $lhead.trno = ".$trno." limit 1")==1){
                        $posted=true;                                        
                    }else{
                        Transnum::deletehead($trno, $doc);
                    }//END INSERT //end if insert to hhead for SO
                break;

                case 'SO': case 'QA': case 'QT': 
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,
                    dateid,terms,rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,
                    lockuser,agent,wh,mop,moddate,modamt,modref,salestype,trnx_type,rdate,rtype,uv_amountreceived,uv_transtype,uv_picker,uv_checker) 
                    SELECT head.trno,head.doc, head.docno,client.client,
                    head.clientname, head.address, head.shipto,head.dateid as dateid, head.terms, head.rem, head.forex,
                    head.yourref, head.ourref, head.createdate,head.createby,head.editby,head.editdate,
                    head.lockdate,head.lockuser,head.agent,head.wh,head.mop, head.moddate,head.modamt,head.modref,head.salestype,head.trnx_type,
                    head.rdate,head.rtype,head.uv_amountreceived,head.uv_transtype,head.uv_picker,head.uv_checker
                    FROM $lhead as head 
                    left join transnum on transnum.trno=head.trno 
                    left join client on head.client=client.client
                    where head.trno=$trno limit 1")==1){

                        if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,disc,amt,iss,
                        void,loc,expiry,isamt,isqty,ext,encodeddate,qa,encodedby,editdate,editby,rem,wh_currentqty)
                        SELECT trno, line, barcode, itemname, uom,wh,disc,amt, iss,void,loc,expiry,
                        isamt, isqty, ext, encodeddate,qa, encodedby,editdate,editby,rem,wh_currentqty FROM $lstock where trno =$trno")==1){
                            $posted=true;                                        
                        }else{
                            Transnum::deletehead($trno, $doc);
                        }//END INSERT 
                    }//end if insert to hhead for SO
                break;

                case 'JB':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,
                    dateid,terms,rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,
                    lockuser,agent,wh,mop,moddate,modamt,modref,salestype,trnx_type,rdate,rtype,uv_amountreceived,uv_transtype,
                    uv_picker,uv_checker,
                    reqdate,breakdownreport,withdrawnum,equipreleasenum,pricetype) 
                    SELECT head.trno,head.doc, head.docno,client.client,
                    head.clientname, head.address, head.shipto,head.dateid as dateid, head.terms, head.rem, head.forex,
                    head.yourref, head.ourref, head.createdate,head.createby,head.editby,head.editdate,
                    head.lockdate,head.lockuser,head.agent,head.wh,head.mop, head.moddate,head.modamt,head.modref,head.salestype,head.trnx_type,
                    head.rdate,head.rtype,head.uv_amountreceived,head.uv_transtype,head.uv_picker,head.uv_checker,
                    head.reqdate,head.breakdownreport,head.withdrawnum,head.equipreleasenum,head.pricetype
                    FROM $lhead as head 
                    left join transnum on transnum.trno=head.trno 
                    left join client on head.client=client.client
                    where head.trno=$trno limit 1")==1){

                        if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,disc,amt,iss,
                        void,loc,expiry,isamt,isqty,ext,encodeddate,qa,encodedby,editdate,editby,rem,wh_currentqty)
                        SELECT trno, line, barcode, itemname, uom,wh,disc,amt, iss,void,loc,expiry,
                        isamt, isqty, ext, encodeddate,qa, encodedby,editdate,editby,rem,wh_currentqty FROM $lstock where trno =$trno")==1){
                            $posted=true;                                        
                        }else{
                            Transnum::deletehead($trno, $doc);
                        }//END INSERT 
                    }//end if insert to hhead for SO
                break;

                case 'TR':
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,dateid,
                    terms,rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,agent,wh,due,cur,trroute,trpricegrp)
                    SELECT head.trno,head.doc, head.docno,head.client, head.clientname, head.address,head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex,head.yourref, head.ourref,
                    head.createdate,head.createby,head.editby,head.editdate, head.lockdate,head.lockuser,head.agent,head.wh,
                    head.due,head.cur,head.trroute,head.trpricegrp FROM $lhead as head left join cntnum on cntnum.trno=head.trno
                    where head.trno=$trno limit 1")==1){
                        if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,
                            disc,cost,qty,void,rrcost,rrqty,ext,encodeddate,qa,encodedby,editdate,editby,loc,rem,expiry)
                            SELECT trno, line, barcode, itemname, uom,wh,disc,cost, qty,void,
                            rrcost, rrqty, ext, encodeddate,qa, encodedby,editdate,editby,loc,rem,expiry  
                            FROM $lstock where trno =$trno")==1){
                            $posted=true;
                        }else{
                            Transnum::deletehead($trno, $doc);
                        }//END IF INSERT
                    }//END IF
                break;

                case 'SP':
                 if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,dateid,
                    terms,rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,agent,wh,due,cur,effectdate)
                    SELECT head.trno,head.doc, head.docno,head.client, head.clientname, head.address,head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex,head.yourref, head.ourref,
                    head.createdate,head.createby,head.editby,head.editdate, head.lockdate,head.lockuser,head.agent,head.wh,
                    head.due,head.cur,head.effectdate FROM $lhead as head left join cntnum on cntnum.trno=head.trno
                    where head.trno=$trno limit 1")==1){
                                    if(Yii::$app->sbccommon->execqry("
                                    insert into $hstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,cost,qty,void,rrcost,rrqty,ext,
                                    encodeddate,qa,encodedby,editdate,editby,sku,refx,linex,rrcost2,cost2,ext2,disc2)
                                    SELECT trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void,rrcost, rrqty, ext,
                                    encodeddate,qa, encodedby,editdate,editby,sku,refx,linex,rrcost2,cost2,ext2,disc2 FROM $lstock where trno =$trno")==1){
                                        $posted=true;
                                    }else{
                                        Transnum::deletehead($trno, $doc);
                                    }//END IF INSERT
                    }
                break;

                default:
                    if(Yii::$app->sbccommon->execqry("insert into $hhead(trno,doc,docno,client,clientname,address,shipto,dateid,
                    terms,rem,forex,yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,agent,wh,due,cur)
                    SELECT head.trno,head.doc, head.docno,head.client, head.clientname, head.address,head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex,head.yourref, head.ourref,
                    head.createdate,head.createby,head.editby,head.editdate, head.lockdate,head.lockuser,head.agent,head.wh,
                    head.due,head.cur FROM $lhead as head left join cntnum on cntnum.trno=head.trno
                    where head.trno=$trno limit 1")==1){
                            
                        switch ($doc){
                                case 'SP':{
                                    if(Yii::$app->sbccommon->execqry("
                                    insert into $hstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,cost,qty,void,rrcost,rrqty,ext,
                                    encodeddate,qa,encodedby,editdate,editby,sku,refx,linex,rrcost2,cost2,ext2,disc2)
                                    SELECT trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void,rrcost, rrqty, ext,
                                    encodeddate,qa, encodedby,editdate,editby,sku,refx,linex,rrcost2,cost2,ext2,disc2 FROM $lstock where trno =$trno")==1){
                                        $posted=true;
                                    }else{
                                        Transnum::deletehead($trno, $doc);
                                    }//END IF INSERT
                                    break;
                                } //END FOR PO

                                case 'PO':{
                                    if(Yii::$app->sbccommon->execqry("
                                    insert into $hstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,cost,qty,void,rrcost,rrqty,ext,
                                    encodeddate,qa,encodedby,editdate,editby,sku,refx,linex)
                                    SELECT trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void,rrcost, rrqty, ext,
                                    encodeddate,qa, encodedby,editdate,editby,sku,refx,linex FROM $lstock where trno =$trno")==1){
                                        $posted=true;
                                    }else{
                                        Transnum::deletehead($trno, $doc);
                                    }//END IF INSERT
                                    break;
                                } //END FOR PO

                                case 'PR':{
                                    if(Yii::$app->sbccommon->execqry("
                                    insert into $hstock(trno,line,barcode,itemname,uom,wh,disc,cost,qty,void,loc,rrcost,rrqty,ext,
                                    encodeddate,qa,tsqa,rem,encodedby,editdate,editby)
                                    SELECT trno, line, barcode, itemname, uom,wh,disc,cost, qty,void,loc,
                                    rrcost, rrqty, ext, encodeddate,qa,tsqa,rem, encodedby,editdate,editby
                                    FROM $lstock where trno =$trno")==1){
                                        $posted=true;
                                    }else{
                                        Transnum::deletehead($trno, $doc);
                                    }//END IF INSERT
                                    break;
                                }//END FOR PR
                                
                                case 'TR': case 'PC':{
                                    if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,
                                    disc,cost,qty,void,rrcost,rrqty,ext,encodeddate,qa,encodedby,editdate,editby,loc,rem,expiry)
                                    SELECT trno, line, barcode, itemname, uom,wh,disc,cost, qty,void,
                                    rrcost, rrqty, ext, encodeddate,qa, encodedby,editdate,editby,loc,rem,expiry  
                                    FROM $lstock where trno =$trno")==1){
                                        $posted=true;
                                    }else{
                                        Transnum::deletehead($trno, $doc);
                                    }//END IF INSERT
                                break;
                                }//END PC
                                
                                case 'QT':{
                                    if(Yii::$app->sbccommon->execqry("insert into $hstock(trno,line,barcode,itemname,uom,wh,
                                    disc,amt,iss,void,loc,addremarks,isamt,isqty,ext,encodeddate,qa,encodedby,editdate,editby)
                                    SELECT trno, line, barcode, itemname, uom,wh,disc,amt, iss,void,loc,addremarks,
                                    isamt, isqty, ext, encodeddate,qa, encodedby,editdate,editby FROM $lstock where trno =$trno")==1){
                                          
                                        if(Yii::$app->sbccommon->execqry("insert into hqtdetail(trno,line,header1,header2,header3,
                                            footer1,footer2,footer3) SELECT trno,line,header1,header2,header3,footer1,footer2,footer3
                                            FROM qtdetail where trno =$trno")==1){
                                            $posted=true;
                                        }//END IF INSERT HQTDETAIL

                                    }else{
                                        Transnum::deletehead($trno, $doc);
                                    }//END IF INSERT HSTOCK
                                    break;
                                }//END QT

                                case 'KR':{
                                    $posted=true;
                                    break;
                                }//END KR
                            }//END SWITCH CASE
                }//END IF INSERT into HHEAD
             break;
            }//END SWITCH CASE 1ST LEVEL

            if($posted){
                if(Yii::$app->sbccommon->execqry("update transnum set postdate='$date',postedby='$user' where trno='$trno'")==1){
                    Log::writelog($doc, $trno, 'POST', $docno,$user);                                
                    Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
                    Yii::$app->sbccommon->execqry("DELETE from $lstock where trno='$trno'");
                    return 1;
                }else{
                    Transnum::deletestock($trno, $doc);
                }//END IF UPDATE TRANS
            }//END IF POSTED
        }//END FUNCTION POSTTRANS

        
        public static function IsbalancedSO($trno,$module) {
        $stable=Common::localstock($module);
        $htable=Common::localhead($module);
        $amount = Yii::$app->sbccommon->datareader("select modamt as bal from $htable where trno='$trno'");
        $bal=Yii::$app->sbccommon->datareader("select sum(ext) as bal from $stable where trno='$trno'");
        if ($bal<>$amount) {
            return false;
        }
        else {
            return true;
        }
        }

        
        public static function UnpostTrans($trno,$doc,$user){
            $date=date("Y-m-d H:i:s");
            $lhead=Common::localhead($doc);
            $lstock=Common::localstock($doc);
            $hhead=Common::localhhead($doc);
            $hstock=Common::localhstock($doc);
            $unposted=false;
            $docno=Cntnum::getdocno($trno,$doc);
            $sql='';

            switch ($doc) {
                case 'EX':
                    $sql="insert into $lhead(trno,doc,docno,description,dateid,amount,createdate,createby,editby,
                    editdate,viewby,viewdate,lockuser,lockdate) select trno,doc,docno,description,dateid,amount,
                    createdate,createby,editby,editdate,viewby,viewdate,lockuser,lockdate
                    from $hhead as head where head.trno=$trno limit 1";
                    break;

                case 'JO':
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,itemname,tel,dateid,due,
                    barcode,sku,rem,yourref,ourref,invdate,approvedby,approveddate,createdate,createby,editby,
                    editdate,viewby,viewdate,lockuser,lockdate) select trno,doc,docno,client,clientname,address,
                    itemname,tel,dateid,due,barcode,sku,rem,yourref,ourref,invdate,approvedby,approveddate,
                    createdate,createby,editby,editdate,viewby,viewdate,lockuser,lockdate
                    from $hhead where trno=$trno";
                    break;

                case 'PI':
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,rem,forex,
                    yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,wh,due,cur,overhead,labor)
                    select head.trno, head.doc, head.docno, head.client, head.clientname, head.address, head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,
                    head.createby, head.editby, head.editdate, head.lockdate, head.lockuser,head.wh,head.due,head.cur,head.overhead,head.labor
                    from ($hhead as head left join cntnum on cntnum.trno=head.trno)
                    where head.trno=$trno limit 1";
                    break;

                case 'PD':
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,rem,forex,
                    yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,wh,due,cur,delivdate,pi)
                    select head.trno, head.doc, head.docno, head.client, head.clientname, head.address, head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,
                    head.createby, head.editby, head.editdate, head.lockdate, head.lockuser,head.wh,head.due,head.cur,head.delivdate,head.pi
                    from ($hhead as head left join cntnum on cntnum.trno=head.trno)
                    where head.trno=$trno limit 1";
                    break;

                case 'SO': case 'QA': case 'quotation': 
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,rem,forex,
                    yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,wh,mop,moddate,modamt,
                    modref,salestype,trnx_type,agent,rdate,rtype,uv_transtype,uv_amountreceived,uv_picker,uv_checker)
                    select head.trno, head.doc, head.docno, client.client, head.clientname, head.address, head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,
                    head.createby, head.editby, head.editdate, head.lockdate, head.lockuser,head.wh,head.mop,head.moddate,
                    head.modamt,head.modref,head.salestype,head.trnx_type,head.agent,head.rdate,head.rtype,head.uv_transtype,
                    head.uv_amountreceived,head.uv_picker,head.uv_checker from ($hhead as head left join cntnum on cntnum.trno=head.trno)
                    left join client on client.client=head.client where head.trno=$trno limit 1";
                break;

                case 'JB':
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,rem,forex,
                    yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,wh,mop,moddate,modamt,
                    modref,salestype,trnx_type,agent,rdate,rtype,uv_transtype,uv_amountreceived,uv_picker,uv_checker,
                    reqdate,breakdownreport,withdrawnum,equipreleasenum,pricetype)
                    select head.trno, head.doc, head.docno, client.client, head.clientname, head.address, head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,
                    head.createby, head.editby, head.editdate, head.lockdate, head.lockuser,head.wh,head.mop,head.moddate,
                    head.modamt,head.modref,head.salestype,head.trnx_type,head.agent,head.rdate,head.rtype,head.uv_transtype,
                    head.uv_amountreceived,head.uv_picker,head.uv_checker,
                    head.reqdate,head.breakdownreport,head.withdrawnum,head.equipreleasenum,head.pricetype
                    from ($hhead as head left join cntnum on cntnum.trno=head.trno)
                    left join client on client.client=head.client where head.trno=$trno limit 1";
                break;

                case 'RF':
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,rem,forex,
                    yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,wh,mop,moddate,modamt,modref,salestype,trnx_type,route,routeid)
                    select head.trno, head.doc, head.docno, client.client, head.clientname, head.address, head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,
                    head.createby, head.editby, head.editdate, head.lockdate, head.lockuser,head.wh,head.mop,head.moddate,
                    head.modamt,head.modref,head.salestype,head.trnx_type,head.route,head.routeid from ($hhead as head left join cntnum on cntnum.trno=head.trno)
                    left join client on client.client=head.client where head.trno=$trno limit 1";
                break;

                case 'SP':
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,rem,forex,
                    yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,wh,due,cur,effectdate)
                    select head.trno, head.doc, head.docno, client.client, head.clientname, head.address, head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,
                    head.createby, head.editby, head.editdate, head.lockdate, head.lockuser,head.wh,head.due,head.cur,
                    head.effectdate
                    from ($hhead as head left join cntnum on cntnum.trno=head.trno)left join client on client.client=head.client
                    where head.trno=$trno limit 1";
                break; //end for case default


                case 'TX':
                    $sql = "insert into $lhead(trno,docno,rfdocno,rftrno,dateid,rem,createdby,viewby,viewdate,invoiced,generatedrg,
                    txtruck,txchecker,txdriver,txdispatchdate,txreturndate,lockdate,lockuser)
                    select trno,docno,rfdocno,rftrno,dateid,rem,createdby,viewby,viewdate,invoiced,generatedrg,txtruck,txchecker,
                    txdriver,txdispatchdate,txreturndate,lockdate,lockuser from $hhead where $hhead.trno = ".$trno."";
                break;

                default:
                    $sql="insert into $lhead(trno,doc,docno,client,clientname,address,shipto,dateid,terms,rem,forex,
                    yourref,ourref,createdate,createby,editby,editdate,lockdate,lockuser,wh,due,cur)
                    select head.trno, head.doc, head.docno, client.client, head.clientname, head.address, head.shipto,
                    head.dateid as dateid, head.terms, head.rem, head.forex, head.yourref, head.ourref, head.createdate,
                    head.createby, head.editby, head.editdate, head.lockdate, head.lockuser,head.wh,head.due,head.cur
                    from ($hhead as head left join cntnum on cntnum.trno=head.trno)left join client on client.client=head.client
                    where head.trno=$trno limit 1";
                break; //end for case default
            }//end switch case doc

            //unposting head
             if(Yii::$app->sbccommon->execqry($sql)==1){
                $unposted=true;
                switch($doc){
                    case 'RF':
                        $qrytxdocno = "select txdocno from transnum where doc = 'RF' and trno = ".$trno."";
                        $txdocno = Yii::$app->sbccommon->datareader($qrytxdocno);
                        if($txdocno != ""){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been tagged to a TX Document.";
                        }//end if
                    break;
                    case 'JO':{
                        if(Transnum::hasbeenissued($trno)){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been ISSUED. ";
                        }//END CANNOT UNPOST
                        break;
                    }//end case JO

                    case 'JB': case 'SO': case 'QA': case 'quotation':{ 
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                $qryrfno = "select rfno from hsohead where trno = ".$trno."";
                                $rfno = Yii::$app->sbccommon->datareader($qryrfno);
                            break;
                            
                            default:
                                $rfno = '';
                            break;
                        }//end swtich

                        switch ($doc) {
                            case 'JB':
                                $qry = "select ifnull(count(trno),0) as counter from (
                                        select trno from lastock where isfromjo = 1 and refx = ".$trno."
                                        UNION ALL
                                        select trno from glstock where isfromjo = 1 and refx = ".$trno.")
                                        as tbl";

                                $counter = Yii::$app->sbccommon->datareader($qry);

                                if($counter != 0){
                                    return "This Transaction cannot be UNPOSTED. <br/> there are items that are invoiced.";
                                }//end if
                            break;
                        }//END SWITCH

                        if($rfno != 0){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been tagged to an RF Document.";
                        }else{
                            if(Transnum::hasbeeninvoiced($trno)){
                                Transnum::deletelhead($trno, $doc);
                                return "This Transaction cannot be UNPOSTED,<br /> it has already been INVOICED ";
                            }else{
                                //ADD JAOSKI
                                if(Transnum::checkforvoideditems($doc,$trno)){
                                    Transnum::deletelhead($trno, $doc);
                                    return "This Transaction cannot be UNPOSTED,<br /> there are items that are voided.";
                                }else{
                                    switch ($doc) {
                                        case 'quotation':
                                            $itemfilter = ',item';
                                        break;
                                        
                                        default:
                                            $itemfilter = '';
                                        break;
                                    }//end switch
                                    //unposting stock
                                    if(Yii::$app->sbccommon->execqry("
                                    insert into $lstock(trno,line,barcode,itemname,uom,wh,disc,amt,iss,void,isamt,isqty,ext,
                                    encodeddate,qa,rem,encodedby,editdate,editby,loc,expiry,wh_currentqty".$itemfilter.")
                                    select trno, line, barcode, itemname, uom, wh, disc, amt, iss, void, isamt, isqty, ext,
                                    encodeddate, qa,rem,encodedby, editdate, editby,loc,expiry,wh_currentqty".$itemfilter." from $hstock where trno=$trno")==1){
                                        $unposted=true;
                                    }else{
                                        Transnum::deletelhead($trno, $doc);
                                        return 'Error on Unposting Stocks';
                                    }//END IF INSERT LOCALSTOCK
                                }//end if
                            }//END CANNOT UNPOST
                        }//end SOUTHCENTRAL CANT UNPOST
                        break;
                    }//end case SO

                    case 'QT':{
                        //unposting stock
                            if(Yii::$app->sbccommon->execqry("insert into qtstock(trno,line,barcode,
                            itemname,uom,wh,disc,amt,iss,void,isamt,addremarks,
                            isqty,ext,encodeddate,qa,rem,encodedby,editdate,editby)
                            select trno, line, barcode, itemname, uom, wh, disc, amt, iss, void, isamt,addremarks,isqty,
                            ext, encodeddate, qa,rem,encodedby, editdate, editby
                            from $hstock where trno=$trno")==1){
                                if(Yii::$app->sbccommon->execqry("insert into qtdetail(trno,line,header1,header2,header3,footer1,footer2,
                                footer3) select trno,line,header1,header2,header3,footer1,footer2,footer3 from hqtdetail 
                                where trno=$trno")==1){
                                    $unposted=true;
                                }//END QT DETAIL INSERTION
                            }else{
                                Transnum::deletelhead($trno, $doc);
                                return 'Error on Unposting Stocks';
                            }//END IF INSERT LOCALSTOCK
                        break;
                    } //END CASE QT
                    

                    case 'SP': {
                        //checking if received
                        if(Transnum::hasbeenreceived($trno)){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been RECEIVED ";
                        }else{
                            
                            //ADD JAOSKI
                            if(Transnum::checkforvoideditems($doc,$trno)){
                                Transnum::deletelhead($trno, $doc);
                                return "This Transaction cannot be UNPOSTED,<br /> there are items that are voided.";
                            }else{
                                //unposting stock
                                if(Yii::$app->sbccommon->execqry("insert into $lstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,
                                cost,qty,void,rrcost,rrqty,ext,rem,encodeddate,qa,encodedby,editdate,editby,sku,refx,linex,
                                rrcost2,cost2,disc2,ext2)
                                select trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void, rrcost, rrqty,
                                ext,rem, encodeddate, qa, encodedby, editdate, editby,sku,refx,linex,rrcost2,cost2,disc2,ext2
                                from $hstock where trno=$trno")==1){
                                    $unposted=true;
                                }else{
                                    Transnum::deletelhead($trno, $doc);
                                    return 'Error on Unposting Stocks';
                                }//END IF INSERT LOCALSTOCK
                            }//end if

                        }//END CANNOT UNPOST
                        break;
                    }//END CASE PO / PI
                    
                    case 'PO': case 'PI': {
                        //checking if received
                        if(Transnum::hasbeenreceived($trno)){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been RECEIVED ";
                        }else{
                            
                            //ADD JAOSKI
                            if(Transnum::checkforvoideditems($doc,$trno)){
                                Transnum::deletelhead($trno, $doc);
                                return "This Transaction cannot be UNPOSTED,<br /> there are items that are voided.";
                            }else{
                                //unposting stock
                                if(Yii::$app->sbccommon->execqry("insert into $lstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,
                                cost,qty,void,rrcost,rrqty,ext,rem,encodeddate,qa,encodedby,editdate,editby,sku,refx,linex)
                                select trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void, rrcost, rrqty,
                                ext,rem, encodeddate, qa, encodedby, editdate, editby,sku,refx,linex
                                from $hstock where trno=$trno")==1){
                                    $unposted=true;
                                }else{
                                    Transnum::deletelhead($trno, $doc);
                                    return 'Error on Unposting Stocks';
                                }//END IF INSERT LOCALSTOCK
                            }//end if

                        }//END CANNOT UNPOST
                        break;
                    }//END CASE PO / PI

                     case 'PD': {
                        //checking if received
                        if(Transnum::hasbeenreceived($trno)){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been RECEIVED ";
                        }else{
                            //unposting stock
                            if(Yii::$app->sbccommon->execqry("insert into $lstock(trno,line,barcode,itemname,uom,wh,loc,ref,disc,
                            cost,qty,void,rrcost,rrqty,ext,rem,encodeddate,qa,encodedby,editdate,editby,sku,iss)
                            select trno, line, barcode, itemname, uom,wh,loc,ref,disc,cost, qty,void, rrcost, rrqty,
                            ext,rem, encodeddate, qa, encodedby, editdate, editby,sku,iss
                            from $hstock where trno=$trno")==1){
                                $unposted=true;
                            }else{
                                Transnum::deletelhead($trno, $doc);
                                return 'Error on Unposting Stocks';
                            }//END IF INSERT LOCALSTOCK
                        }//END CANNOT UNPOST
                        break;
                    }//END CASE PD
                     // SALON MODIFICATION
                    case 'TR':
                    // END SALON
                    case 'PC': {
                        //checking if received
                        if(Transnum::hasbeenadjustpc($trno)){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been ADJUSTED ";
                        }else{
                            //unposting stock
                            if(Yii::$app->sbccommon->execqry("
                            insert into $lstock(trno,line,barcode,itemname,uom,wh,disc,cost,qty,void,rrcost,
                            rrqty,ext,encodeddate,qa,rem,encodedby,editdate,editby,loc,expiry)
                            select trno, line, barcode, itemname, uom,wh,disc,cost, qty,void, rrcost,
                            rrqty, ext, encodeddate, qa,rem, encodedby, editdate, editby,loc,expiry 
                            from $hstock where trno=$trno")==1){
                                $unposted=true;
                            }else{
                                Transnum::deletelhead($trno, $doc);
                                return 'Error on Unposting Stocks';
                            }//END insert local stock
                        }//END CANNOT UNPOST
                        break;
                    }//END PC

                    case 'PR': {
                        //checking if received
                        if(Transnum::hasbeenreceivedprpo($trno) ||Transnum::hasbeenreceivedprts($trno)){
                            Transnum::deletelhead($trno, $doc);
                            return "This Transaction cannot be UNPOSTED,<br /> it has already been served ";
                        }else{
                            //unposting stock
                            if(Yii::$app->sbccommon->execqry("insert into $lstock(trno,line,barcode,itemname,uom,wh,disc,cost,qty,void,
                            rrcost,rrqty,ext,encodeddate,qa,tsqa,rem,encodedby,editdate,editby)
                            select trno, line, barcode, itemname, uom,wh,disc,cost, qty,void, rrcost, rrqty, ext, encodeddate,
                            qa,tsqa,rem, encodedby, editdate, editby
                            from $hstock where trno=$trno")==1){
                                $unposted=true;
                            }else{
                                Transnum::deletelhead($trno, $doc);
                                return 'Error on Unposting Stocks';
                            }//END insert lstock
                        }//END CANNOT UNPOST
                        break;
                    }//end PC
                    
                }//END SWITCH CASE
            }else{
                return 'Error on Unposting Head';
            }//END ELSE UNPOSTING HEAD
            
            if($unposted){
                Yii::$app->sbccommon->execqry("update transnum set postdate=null where trno='$trno'");
                Log::writelog($doc, $trno, 'UNPOST', $docno,$user);
                Yii::$app->sbccommon->execqry("delete from $hhead where trno=$trno");
                
                //ADDITIONAL UPDATES ON UNPOSTING
                switch ($doc) {
                    case 'SO': case 'QA':
                        Yii::$app->sbccommon->execqry("update hsohead set rf_approval = '' where rfno = ".$trno."");
                    break;
                }//END ADDITIONAL UPDATES ON UNPOSTING

                //ADDITIONAL UPDATES ON UNPOSTING
                switch ($doc) {
                    case 'EX':
                    case 'KR':
                    //NO EXECUTION
                    break;

                    default:
                        Yii::$app->sbccommon->execqry("delete from $hstock where trno=$trno");
                    break;
                }//END ADDITIONAL UPDATES ON UNPOSTING

                return 1;
            }//END IF UNPOSTED IS TRUE
        }//END UNPOSTING TRANS

        public static function hasbeeninvoiced($trno){
            $trno=Yii::$app->sbccommon->datareader("select trno from hsostock where trno = ".$trno." and qa<>0 or trno = ".$trno." and void = 1");
            return $trno;
        }

        public static function checkforvoideditems($doc,$trno){
            $hstock=Common::localhstock($doc);
            $qry = "select barcode from ".$hstock." where trno = ".$trno." and void = 1";
            $items= Yii::$app->sbccommon->opentable($qry);
            
            if(!empty($items)) {
                return true;
            }else{
                return false;
            }//end if
        }//end function

        public static function hasbeenissued($trno,$line=''){
            $sql ="select trno from joservice where sissuedby<>'' and trno=$trno union all select trno from hjoservice where sissuedby<>'' and trno=$trno";
            if ($line!=''){
                $sql = $sql. " and md5(line)='$line'";
            }
            $trno=Yii::$app->sbccommon->datareader($sql);
            return $trno;
        }
        
        public static function hasbeenadjustpc($trno){
            $trno=Yii::$app->sbccommon->datareader("select trno from hpchead where trno=".$trno." and ourref<>'' ");
            return $trno;
        }

        public static function hasbeenreceivedprpo($trno){
            $trno=Yii::$app->sbccommon->datareader("select trno from hprstock where trno=$trno and qa<>0 or tsqa<>0");
            return $trno;
        }
        public static function hasbeenreceivedprts($trno){
            $trno=Yii::$app->sbccommon->datareader("select trno from hprstock where trno=$trno and tsqa<>0");
            return $trno;
        }
        
        public static function hasbeenreceived($trno){
            $trno=Yii::$app->sbccommon->datareader("select trno from hpostock where qa<>0 and trno=$trno");
            return $trno;
        }
        
        public static function deletehead($trno,$doc){
            $hhead=Common::localhhead($doc);
            Yii::$app->sbccommon->execqry("DELETE from $hhead where trno='$trno'");
        }
        public static function deletestock($trno,$doc){
            $hstock=Common::localhstock($doc);
            Yii::$app->sbccommon->execqry("DELETE from $hstock where trno='$trno'");
        }
         public static function deletelstock($trno,$doc){
            $hstock=Common::localhstock($doc);
            Yii::$app->sbccommon->execqry("DELETE from $hstock where trno='$trno'");
        }
        public static function deletelservice($trno,$line,$doc){
            $hstock=Common::localstock($doc);
            Yii::$app->sbccommon->execqry("DELETE from $hstock where trno='$trno' and md5(line)='$line'");
        }
        public static function deletehservice($trno,$line,$doc){
            $hstock=Common::localhstock($doc);
            $sql="DELETE from $hstock where trno='$trno' and md5(line)='$line'";
            Yii::$app->sbccommon->execqry("DELETE from $hstock where trno='$trno' and md5(line)='$line'");
            return $sql;
        }
        public static function deletelhead($trno,$doc){
            $lhead=Common::localhead($doc);
            Yii::$app->sbccommon->execqry("DELETE from $lhead where trno='$trno'");
        }
        

            public static function post($post,$controller){
                if(!empty($post)){
                    $controller->redirect(array('//site/index'));
                }else{
                    $controller->redirect(array('//site/modules'));
                }


            }

        public static function PostJOservice($trno,$line,$doc)
        {
            $date=date("Y-m-d H:i:s");
            $user=Yii::$app->user->username;
            $posted=false;
            $lhead=Common::localhead($doc);
            $lstock=Common::localstock($doc);
            $hhead=Common::localhhead($doc);
            $hstock=Common::localhstock($doc);
            $docno=Cntnum::getdocno($trno,$doc);

            $sql="insert into $hstock(trno,line,sreceivedby,sreceiveddate,problem,accessories,contact,fax,email,hreceivedby,hreceiveddate,hremarks,
                                      sureceivedby,sureceiveddate,suremarks,retdatesutoho,retremarks,recfromsutoho,fromhtosdate,recfromhtosby,fromstocdate,sissuedby,deltoho,rettostore,issuedtostoreby)
                                      select trno,line,sreceivedby,sreceiveddate,problem,accessories,contact,fax,email,hreceivedby,hreceiveddate,hremarks,
                                      sureceivedby,sureceiveddate,suremarks,retdatesutoho,retremarks,recfromsutoho,fromhtosdate,recfromhtosby,fromstocdate,sissuedby ,deltoho,rettostore,issuedtostoreby from $lstock where trno=$trno and md5(line) ='$line'";
           // webproc::showmsg('Postservice',$sql.$doc);
                 if(Yii::$app->sbccommon->execqry($sql)==1){
                    $posted=true;
                    if(strlen(Transnum::hasbeenissued($trno,$line))==0){
                        Transnum::deletehservice($trno,$line,$doc);
                        return "This Transaction cannot be POSTED,<br /> not yet issued. ";                        
                    }else if(Transnum::isposted($trno)!=1){
                        Transnum::deletehservice($trno,$line,$doc);
                        return "This Transaction cannot be POSTED,<br /> head not yet posted. ";                       
                    }else{
                        Transnum::deletelservice($trno,$line,$doc);
                    }
                                          
                    if(Yii::$app->sbccommon->execqry("update hjoservice set postdate='$date' where trno='$trno' and md5(line) ='$line'")==1){
                        Yii::$app->sbccommon->execqry("INSERT into transnum_log
                         (trno,field,oldversion,newversion,userid,dateid)
                         values('$trno','POST',concat($docno,'-',$line),'','$user',CURRENT_TIMESTAMP)
                         ");
                      return 1;
                    }
                 }else{
                     Transnum::deletehservice($trno,$line,$doc);
                     return "Error on posting.";
                 }
        }

        public static function UnpostJOservice($trno,$line,$doc)
        {
            $date=date("Y-m-d H:i:s");
            $user=Yii::$app->user->username;
            $posted=false;
            $lhead=Common::localhead($doc);
            $lstock=Common::localstock($doc);
            $hhead=Common::localhhead($doc);
            $hstock=Common::localhstock($doc);
            $docno=Cntnum::getdocno($trno,$doc);

            $sql="insert into $lstock(trno,line,sreceivedby,sreceiveddate,problem,accessories,contact,fax,email,hreceivedby,hreceiveddate,hremarks,
                                      sureceivedby,sureceiveddate,suremarks,retdatesutoho,retremarks,recfromsutoho,fromhtosdate,recfromhtosby,fromstocdate,sissuedby,deltoho,rettostore,issuedtostoreby)
                                      select trno,line,sreceivedby,sreceiveddate,problem,accessories,contact,fax,email,hreceivedby,hreceiveddate,hremarks,
                                      sureceivedby,sureceiveddate,suremarks,retdatesutoho,retremarks,recfromsutoho,fromhtosdate,recfromhtosby,fromstocdate,sissuedby ,deltoho,rettostore,issuedtostoreby from $hstock where trno=$trno and md5(line) ='$line'";
           // webproc::showmsg('Postservice',$sql.$doc);
                 if(Yii::$app->sbccommon->execqry($sql)==1){
                    $unposted=true;
                    if(strlen(Transnum::hasbeenissued($trno,$line))!=0){
                        Transnum::deletelservice($trno,$line,$doc);
                        return "This Transaction cannot be UNPOSTED,<br /> not yet issued. ";
                    }else{
                        Transnum::deletehservice($trno,$line,$doc);
                    }

                    if(Yii::$app->sbccommon->execqry("update joservice set postdate=null where trno='$trno' and md5(line) ='$line'")==1){
                        Yii::$app->sbccommon->execqry("INSERT into transnum_log
                         (trno,field,oldversion,newversion,userid,dateid)
                         values('$trno','UNPOST',concat($docno,'-',$line),'','$user',CURRENT_TIMESTAMP)
                         ");
                      return 1;
                    }
                 }else{
                     Transnum::deletelservice($trno,$line,$doc);
                     return "Error on Unposting.";
                 }
        }
        
        
}