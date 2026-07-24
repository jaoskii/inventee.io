<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Lastock;

class Lahead extends Model{
        public $newdocno;
	    public $trno;
        public $docno;
        public $client;
        public $clientname;
        public $address;
        public $shipto;
        public $terms;
        public $rem;
        public $forex;
        public $yourref;
        public $ourref;
        public $dateid;
        public $grandtotal;
        public $itemcount;
        public $totalkilo;
        public $createdate;
        public $tax;
        public $contra;
        public $wh;
        public $whid;
        public $wh_address;
        public $agent;
        public $agentcode;
        
        public $pickname;
        public $pickcode;
        public $checkname;
        public $checkcode;

        public $isdeclared;
        public $modeofpayment;
        public $acctname;
        public $acctno;
        public $cardtype;
        public $due;
        public $waybilldate;
        public $billlading;
        public $voyage;
        public $islocked;
        public $totalforex;
        public $isposted;
        public $totaldb;
        public $totalcr;
        public $cur;
        public $vattype;
        public $salestype;
        public $checkno;
        
        public $pricegrp;
        public $route;
        public $routeid;
        public $transtype;
        public $amountreceived;

        public $invoiceno;
        public $invoicedate;
        public $groupid;

        public $totaltonnage;
        public $totalcbm;
        public $transmittalcode;
        
        public $costcenter;

        public $sjtrno;
        public $sjdoc;

        public $purchasetype;

        public $arastre = 0;
        public $freight = 0;
        public $wharffage = 0;
        public $agentpassword;

        public $ewt;
        public $ewtrate = 0;
        public $jodocno = '';
        public $mlcp_freight = 0;
        public $mlcp_freighttotal = 0;
        public $pricetype;
        
	public function rules(){
		return array(
                    //array('whid','required','except'=>'accounting'),
                    array('whid,client,clientname','required','except'=>'ds'),
                    array('docno','required'),
                    array('trno, docno', 'length', 'max'=>15),
                    array('client', 'length', 'max'=>15),
                    array('clientname, address, shipto', 'length', 'max'=>150),
                    array('terms', 'length', 'max'=>30),                    
                    array('rem', 'length', 'max'=>500),
                    array('forex', 'length', 'max'=>18),
                    array('isdeclared', 'length', 'max'=>1),
                    array('yourref, ourref', 'length', 'max'=>25),
                    array('dateid,due,contra,wh,agent,agentcode,whid,modeofpayment,acctname,acctno,cardtype,waybilldate,billlading,voyage', 'safe'),
                    array('tax,trno', 'numerical', 'integerOnly'=>true),
             );
	}
        public function suggest($keywords,$limit=20,$module=''){
            $center=Yii::$app->user->center;
            $keyword=explode(",",$keywords);
            $table=Common::localhead($module);
            $glhead=Common::glhead();
            $sql ="select c.docno, c.trno ,cl.client,cl.clientname,cl.addr as address, p.yourref, p.ourref, p.shipto,
                    left(p.dateid,10) as dateid, p.terms, p.rem
                    from $table as p
                    left join  cntnum as c on c.trno=p.trno left join client as cl on cl.client=p.client where c.doc='$module' and";
            $criteria="";
            
            for($i=0;$i<count($keyword);$i++){
                if ($criteria=="")
                    {
                    $criteria = "(c.docno LIKE '%".$keyword[$i]."%' OR cl.client LIKE '%".$keyword[$i]."%' OR cl.clientname LIKE '%".$keyword[$i]."%')";
                    }
                else
                    {
                    $criteria = $criteria." and "."(c.docno LIKE '%".$keyword[$i]."%' OR cl.client LIKE '%".$keyword[$i]."%' OR cl.clientname LIKE '%".$keyword[$i]."%')";
                    }
                    $criteria= $criteria ." and  c.center='$center'";
            }//end for

            $query1=$sql." ".$criteria;

            $sql2 ="select c.docno, c.trno ,cl.client,cl.clientname,cl.addr as address, p.yourref, p.ourref, p.shipto,
                    left(p.dateid,10) as dateid, p.terms, p.rem
                    from $glhead as p
                    left join cntnum as c on c.trno=p.trno left join client as cl on cl.clientid=p.clientid where c.doc='$module' and";
            $query2=$sql2." ".$criteria;

            
                $models=Yii::$app->sbccommon->opentable($query1." union all ".$query2." order by trno desc limit $limit");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=> $model['docno'] .' - '. $model['client']  .' - '. $model['clientname'] . ' - '. $model['yourref'].' - '.$model['ourref'], // label for dropdown list
				'value'=>"", 'trno'=>$model['trno'],);
		}//end for

		return $suggest;
	}//end f




        public static function updatehead($trno, $docno, $data,$doc){
            switch($doc){
                case 'TS':{
                    $data->wh=$data->whid;
                    break;
                }//end case 
            }//end switch

            $table=Common::localhead($doc);
            
            if($doc=='RR'){
                Cntnum::setisdeclared($trno, $data->isdeclared);
            }//end if rr

            $update=Lahead::update($trno, $docno, $data,$table,$doc);
            
            return $update;
        }//end updatehead

        public static function update($trno, $docno, $data,$table,$doc){
           
            $data->client=preg_replace( "/'/", "`", $data->client );
            $data->clientname=preg_replace( "/'/", "`", $data->clientname );
            $data->address=preg_replace( "/'/", "`", $data->address );
            $data->yourref=preg_replace( "/'/", "`", $data->yourref );
            $data->ourref=preg_replace( "/'/", "`", $data->ourref );
            $data->rem=preg_replace( "/'/", "`", $data->rem );
            $data->shipto=preg_replace( "/'/", "`", $data->shipto );
            $data->terms=preg_replace( "/'/", "`", $data->terms );
            $data->whid=preg_replace( "/'/", "`", $data->whid );
            $data->agent=preg_replace( "/'/", "`", $data->agent );

            $data->pickcode=preg_replace( "/'/", "`", $data->pickcode );
            $data->checkcode=preg_replace( "/'/", "`", $data->checkcode );

            
            $user=Yii::$app->session['loggeduser']['username'];
            if (strlen($data->tax)==0){
            $data->tax=0;
            }

            if (strlen($data->contra)==0)
            {
               $data->contra='\\'.Ladetail::getacno('AP1');
            }
            
            $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
            $prev_vattype = "";

            switch($doc){
                case 'SJ': case 'MI': case 'MX':
                    $qry = "update $table
                    SET client='$data->client', clientname='$data->clientname',
                    address='$data->address', yourref='$data->yourref',
                    ourref='$data->ourref', forex='$data->forex',
                    dateid='$data->dateid',due = '$data->due',
                    rem='$data->rem', shipto='$data->shipto', 
                    terms='$data->terms',
                    contra='\\$data->contra',tax='$data->tax',
                    wh='$data->whid',agent='$data->agent',
                    vattype = '$data->vattype',salestype = '$data->salestype',
                    editby='$user',editdate='".$timeupdate."',
                    Checked = '$data->checkno',project='$data->costcenter',
                    pickby='$data->pickcode',
                    checkby='$data->checkcode',
                    ms_arastre='$data->arastre',
                    ms_freight='$data->freight',ms_wharffage='$data->wharffage',
                    waybilldate='$data->waybilldate',billlading='$data->billlading',
                    voyage='$data->voyage',uv_transtype='$data->transtype',
                    mlcp_freight='$data->mlcp_freight',
                    uv_amountreceived = '".$data->amountreceived."'
                    where trno='$trno'";

                    if($doc == "SJ"){
                        $prev_vattype =  Yii::$app->backend->getCurrentVattype($trno);
                    }//end if

                    Yii::$app->sbccommon->execqry($qry);
                break;

                case 'TS':
                    $qry = "update $table
                        SET client='$data->client', clientname='$data->clientname',
                        address='$data->address', yourref='$data->yourref',
                        ourref='$data->ourref', cur='$data->cur',forex='$data->forex', dateid='$data->dateid',
                        due = '$data->due',rem='$data->rem', shipto='$data->shipto', terms='$data->terms',
                        contra='\\$data->contra',tax='$data->tax',wh='$data->whid',agent='$data->agentcode',
                        editby='$user',editdate='".$timeupdate."',vattype = '$data->vattype',
                        trpricegrp = '$data->pricegrp',trroute='$data->routeid',agent='$data->agent'
                        where trno='$trno'";
                    Yii::$app->sbccommon->execqry($qry);
                break;

                case 'SV':
                    $qry = "update $table
                        SET client='$data->client', clientname='$data->clientname',
                        address='$data->address', yourref='$data->yourref',
                        ourref='$data->ourref', cur='$data->cur',forex='$data->forex', dateid='$data->dateid',
                        due = '$data->due',rem='$data->rem', shipto='$data->shipto', terms='$data->terms',
                        contra='\\$data->contra',tax='$data->tax',wh='$data->whid',agent='$data->agentcode',
                        editby='$user',editdate='".$timeupdate."',vattype = '$data->vattype',
                        invoiceno = '$data->invoiceno',invoicedate='$data->invoicedate' 
                        where trno='$trno'";
                    Yii::$app->sbccommon->execqry($qry);
                break;
                
                case 'CM':
                    $qry = "update $table
                        SET client='$data->client', clientname='$data->clientname',
                        address='$data->address', yourref='$data->yourref',
                        ourref='$data->ourref', cur='$data->cur',forex='$data->forex', dateid='$data->dateid',
                        due = '$data->due',rem='$data->rem', shipto='$data->shipto', terms='$data->terms',
                        contra='\\$data->contra',tax='$data->tax',wh='$data->whid',agent='$data->agentcode',
                        editby='$user',editdate='".$timeupdate."',vattype = '$data->vattype',project='$data->costcenter',
                        gm_purchasetype = '$data->purchasetype',ewt='$data->ewt',ewtrate='$data->ewtrate',
                        uv_transtype='$data->transtype'
                        where trno='$trno'";

                    $status = Yii::$app->sbccommon->execqry($qry);
                break;

                default:
                    $qry = "update $table
                        SET client='$data->client', clientname='$data->clientname',
                        address='$data->address', yourref='$data->yourref',
                        ourref='$data->ourref', cur='$data->cur',forex='$data->forex', dateid='$data->dateid',
                        due = '$data->due',rem='$data->rem', shipto='$data->shipto', terms='$data->terms',
                        contra='\\$data->contra',tax='$data->tax',wh='$data->whid',agent='$data->agentcode',
                        editby='$user',editdate='".$timeupdate."',vattype = '$data->vattype',project='$data->costcenter',
                        gm_purchasetype = '$data->purchasetype',ewt='$data->ewt',ewtrate='$data->ewtrate' where trno='$trno'";

                    if($doc == "RR"){
                        $prev_vattype =  Yii::$app->backend->getCurrentVattype($trno);
                    }//end if
                    
                    $status = Yii::$app->sbccommon->execqry($qry);

                    if($status){
                        switch(Yii::$app->systemsettings->companyConfig()){
                            case 'CANUMAY':
                                if($doc=='CM'){
                                    $qry2="update lahead SET cmtrans='0' where trno='$trno'";
                                    $status2 = Yii::$app->sbccommon->execqry($qry2);
                                    $qry3="update lahead SET cmtrans='$data->sjtrno' where trno='$trno'";
                                    $status3 = Yii::$app->sbccommon->execqry($qry3);
                                }//end if
                            break;
                        }//end switch

                        if($doc == "RR"){
                            $hiddenqty = "qty";
                            $hiddentamt = "cost";
                            if(Yii::$app->backend->hasDataRows($trno,'lastock')){
                                $stockqry = Lastock::openstock($trno, $doc,'');
                                $stockitems = Yii::$app->sbccommon->opentable($stockqry);
                                //LOOPS ALL ITEMS ON THE STOCKPART
                                foreach ($stockitems as $key => $value) {
                                    //RECOMPUTE ALL ITEMS PER ROW
                                    $computeddata = Yii::$app->backend->recomputeStock($value['rrcost'],$value['disc'],$value['rrqty'],$value['uomfactor'],$doc,$data->tax);
                                    //REPLACES ALL COMMAS
                                    $ext = str_replace(",","",$computeddata['ext']);
                                    $cost = str_replace(",","",$computeddata['cost']);
                                    $qty = str_replace(",","",$computeddata['qty']);
                                    //AFTER COMPUTATION WILL MULTIPLY THE HIDDEN AMOUNT TO THE VALUE OF HEADER FOREX regardless of value
                                    $cost = floatval($cost) * floatval($data->forex);
                                    $qryrecomputestock = "update lastock set 
                                    ".$hiddenqty." = ".$qty.",
                                    ".$hiddentamt." = ".$cost.",ext = ".$ext."
                                    where trno = ".$trno." and line = ".$value['line']."";
                                    Yii::$app->sbccommon->execqry($qryrecomputestock);
                                }//end for each
                            }//end if
                        }//end if
                    }//end if
                break;
            }
            
            if($doc == "SJ" || $doc == "RR"){
                $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
                
                //checks tbl_transaction_vattype_history for records
                $qry = "select count(id) as counter from tbl_transaction_vattype_history where trno = " . $trno;
                $history_records = Yii::$app->sbccommon->datareader($qry);

                if($history_records == 0){
                    //inserts past vattype and new vattype
                    $qry_insert = "insert into tbl_transaction_vattype_history (vattype, trno , updated_at) values('".$prev_vattype."',".$trno.",'".$timeupdate."')";
                    Yii::$app->sbccommon->execqry($qry_insert);
                }//end if

                $qry_insert2 = "insert into tbl_transaction_vattype_history (vattype, trno , updated_at) values('".$data->vattype."',".$trno.",'".$timeupdate."')";
                Yii::$app->sbccommon->execqry($qry_insert2);
            }//end if
            
            return true;
        }//end function update

        public static function inserthead($docno, $doc, $trno,$data){
            $table=Common::localhead($doc);
            
            if($doc=='RR'){
                Cntnum::setisdeclared($trno, $data->isdeclared);
            }

            return Lahead::insert($docno, $doc, $trno,$data,$table);
        }

        public static function insert($docno, $doc, $trno,$data,$table){
            $data->client=preg_replace( "/'/", "`", $data->client);
            $data->clientname=preg_replace( "/'/", "`", $data->clientname);
            $data->address=preg_replace( "/'/", "`", $data->address);
            $data->yourref=preg_replace( "/'/", "`", $data->yourref);
            $data->ourref=preg_replace( "/'/", "`", $data->ourref);
            $data->rem=preg_replace( "/'/", "`", $data->rem);
            $data->shipto=preg_replace( "/'/", "`", $data->shipto);
            $data->terms=preg_replace( "/'/", "`", $data->terms);
            $data->whid=preg_replace( "/'/", "`", $data->whid);
            $data->pickcode=preg_replace( "/'/", "`", $data->pickcode);
            $data->checkcode=preg_replace( "/'/", "`", $data->checkcode);

            switch($doc){
                case 'TS': $data->wh=$data->whid; break;
            }//end switch

            if (strlen($data->tax)==0) { $data->tax=0; }

            $user=Yii::$app->session['loggeduser']['username'];
            switch ($doc) {
                case 'SJ': case 'MI': case 'MX':
                    if($data->contra != ''){ 
                        $contra = "\\" . $data->contra; 
                    }else{
                        $contra = "";
                    }//end if

                    $qry = "insert into $table
                    (docno, doc, client, clientname, address, yourref, ourref,
                    forex, dateid, rem,shipto,terms,trno,contra,tax,createby,wh,agent,
                    due,vattype,salestype,Checked,project,checkby,pickby,
                    ms_arastre,ms_freight,ms_wharffage,
                    waybilldate,billlading,voyage,uv_transtype,mlcp_freight,uv_amountreceived)
                    values(
                    '$docno','$doc', '$data->client', '$data->clientname',
                    '$data->address', '$data->yourref', '$data->ourref',
                    '$data->forex', '$data->dateid', '$data->rem',
                    '$data->shipto', '$data->terms', '$trno','$contra',
                    '$data->tax','$user','$data->whid','$data->agent',
                    '$data->due','$data->vattype','$data->salestype',
                    '$data->checkno','$data->costcenter',
                    '$data->checkcode','$data->pickcode','$data->arastre',
                    '$data->freight','$data->wharffage',
                    '$data->waybilldate','$data->billlading','$data->voyage','$data->transtype','$data->mlcp_freight','$data->amountreceived')";
                    $insert= Yii::$app->sbccommon->execqry($qry);
                break;   

                case 'DS':
                    $qry = "insert into $table
                            (docno, doc,clientname, yourref, ourref,dateid, rem,trno,contra,createby,salestype)
                                values(
                                '$docno','$doc','$data->clientname',
                                '$data->yourref', '$data->ourref',
                                '$data->dateid', '$data->rem',
                                '$trno','\\$data->contra','$user','$data->salestype')";
                    $insert= Yii::$app->sbccommon->execqry($qry);
                break;

                case 'TS':
                    if($data->contra != "") { $contra = '\\'.$data->contra; } else { $contra = ""; }
                    $qry = "insert into $table (docno, doc, client, clientname, address, yourref,ourref,cur,
                    forex, dateid, rem, shipto, terms,trno,createby,wh,contra,
                    due,vattype,salestype,trpricegrp,trroute,agent)
                    values('$docno','$doc', '$data->client', '$data->clientname','$data->address',
                    '$data->yourref', '$data->ourref',
                    '$data->cur','$data->forex', '$data->dateid', '$data->rem', '$data->shipto',
                    '$data->terms', '$trno','$user',
                    '$data->whid','$contra','$data->due','$data->vattype','$data->salestype',
                    '$data->pricegrp','$data->routeid','$data->agentcode')";

                    $insert= Yii::$app->sbccommon->execqry($qry);
                break;

                case 'SV':
                    if($data->contra != "") { $contra = '\\'.$data->contra; } else { $contra = ""; }
                    $qryinsert = "insert into $table (docno, doc, client, clientname, address, yourref, ourref,cur,
                    forex, dateid, rem, shipto, terms,trno,createby,wh,contra,due,vattype,salestype,agent,invoiceno,invoicedate)
                    values('$docno','$doc', '$data->client', '$data->clientname','$data->address',
                    '$data->invoiceno', '$data->ourref',
                    '$data->cur','$data->forex', '$data->dateid', '$data->rem', '$data->shipto',
                    '$data->terms', '$trno','$user',
                    '$data->whid','$contra','$data->due','$data->vattype','$data->salestype',
                    '$data->agentcode','$data->invoiceno','$data->invoicedate')";
                    $insert= Yii::$app->sbccommon->execqry($qryinsert);
                break;

                case 'CM':
                    if($data->contra != "") { $contra = '\\'.$data->contra; } else { $contra = ""; }
                    
                    $qryinsert = "insert into $table (docno, doc, client, clientname, address, yourref, ourref,cur,
                    forex, dateid, rem, shipto, terms,trno,createby,wh,contra,due,vattype,salestype,agent,project,tax,gm_purchasetype,ewt,ewtrate, uv_transtype)
                    values('$docno','$doc', '$data->client', '$data->clientname','$data->address', '$data->yourref', '$data->ourref',
                    '$data->cur','$data->forex', '$data->dateid', '$data->rem', '$data->shipto','$data->terms', '$trno','$user',
                    '$data->whid','$contra','$data->due','$data->vattype','$data->salestype','$data->agentcode','$data->costcenter','$data->tax',
                    '$data->purchasetype','$data->ewt','$data->ewtrate' ,'$data->transtype')";
                    
                    $insert= Yii::$app->sbccommon->execqry($qryinsert);
                break;

                default:
                    if($data->contra != "") { $contra = '\\'.$data->contra; } else { $contra = ""; }
                    
                    $qryinsert = "insert into $table (docno, doc, client, clientname, address, yourref, ourref,cur,
                    forex, dateid, rem, shipto, terms,trno,createby,wh,contra,due,vattype,salestype,agent,project,tax,gm_purchasetype,ewt,ewtrate)
                    values('$docno','$doc', '$data->client', '$data->clientname','$data->address', '$data->yourref', '$data->ourref',
                    '$data->cur','$data->forex', '$data->dateid', '$data->rem', '$data->shipto','$data->terms', '$trno','$user',
                    '$data->whid','$contra','$data->due','$data->vattype','$data->salestype','$data->agentcode','$data->costcenter','$data->tax',
                    '$data->purchasetype','$data->ewt','$data->ewtrate')";
                    
                    $insert= Yii::$app->sbccommon->execqry($qryinsert);
                break;
            }//END SWITCH DOC
            
            if($insert==1) {
                Log::writelog($doc, $trno, 'CREATE', $docno.' CLIENT - '.$data->client.' - '.$data->clientname,Yii::$app->session['loggeduser']['username']);
                switch(Yii::$app->systemsettings->companyConfig()){
                    case 'CANUMAY':
                        if($doc=='CM'){
                            $qry2="update lahead SET cmtrans='0' where trno='$trno'";
                            $status2 = Yii::$app->sbccommon->execqry($qry2);
                            $qry3="update lahead SET cmtrans='$data->sjtrno' where trno='$trno'";
                            $status3 = Yii::$app->sbccommon->execqry($qry3);
                        }//end if
                    break;
                }//end switch
                return true;
            } else {
                Log::writelog($doc, $trno, 'CREATE', $docno.'FAILED CLIENT - '.$data->client.' - '.$data->clientname,Yii::$app->session['loggeduser']['username']);
                return false;
            }
        }//END FUNCTION INSERT

        public static function openhead($trno,$doc){
            switch($doc){
                case'TS':
                    $table=Common::localhead($doc);
                    $head=Lahead::TShead($trno,$table);
                    return $head;
                break;

                case 'KR':
                    $table=Common::localhead($doc);
                    $htable=Common::localhhead($doc);
                    $head=Pohead::head($trno,$table,$htable);
                    return $head;
                break;
                
                default:
                    $table=Common::localhead($doc);
                    $head=Lahead::head($trno,$table);
                    if($doc == "CM"){
                        if(!empty($head)){
                            $cmtrans = Yii::$app->sbccommon->datareader("select docno from glhead where trno= ".$head[0]['cmtrans']."");
                            if(!empty($cmtrans)){
                                $head[0]['sjdoc'] = $cmtrans;
                            }//end if
                        }//end if
                    }//end if
                    return $head;
                break;
            }//end switch
        }//END OPEN HEAD

        public static function head($trno,$lahead){
            $center=Yii::$app->session['loggeduser']['center'];
            $glhead=Common::glhead();
            $qry = "select 
            txnum.docno as txdocno,cntnum.center,head.trno, head.docno,head.client,head.clientname, head.terms,head.cur,head.forex, 
            head.yourref, head.ourref,head.wh as whid, warehouse.clientname as wh,warehouse.addr as wh_address,
            left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createdate, '%Y-%m-%d') as createdate, 
            head.rem,head.contra,head.tax,agent.client as agentcode,agent.clientname as agent,
            head.modeofpayment,head.acctname,head.acctno,head.cardtype,head.waybilldate,head.billlading,
            head.voyage,left(head.due,10) as due,head.vattype,head.salestype,coa.acnoname,head.checked,
            head.invoiceno,left(head.invoicedate,10) as invoicedate,client.groupid,
            case cntnum.transtype
            when 'R' then 'Regular Transaction'
            when 'S' then 'Senior Transaction'
            when 'RT' then 'Return Transaction - Regular'
            when 'ST' then 'Return Transaction - Senior' 
            when '' then '' end as transtype,concat(head.project,'~',projects.name) as costcenter,head.cmtrans,'' as sjdoc,
            pick.client as pickcode,pick.clientname as pickname,checked.client as checkcode,checked.clientname as checkname,
            head.gm_purchasetype as purchasetype,ms_arastre as arastre,ms_freight as freight,ms_wharffage as wharffage,
            head.ewt,head.ewtrate,head.uv_transtype,head.mlcp_jonum,head.mlcp_freight,head.uv_amountreceived
            FROM $lahead as head
            left join cntnum on cntnum.trno=head.trno
            left join transnum as txnum on txnum.trno = cntnum.txno
            left join coa on coa.acno = head.contra
            left join client  on head.client=client.client
            left join client  as agent on agent.client=head.agent
            left join client as pick on pick.client = head.pickby
            left join client as checked on checked.client = head.checkby
            left join client  as warehouse on warehouse.client=head.wh
            left join projectmasterfile as projects on projects.code = head.project
            where head.trno=$trno and cntnum.center='$center'
            union all
            SELECT
            txnum.docno as txdocno,cntnum.center,head.trno, head.docno,client.client,head.clientname, head.terms,head.cur, 
            head.forex, head.yourref, head.ourref,warehouse.client as whid,warehouse.clientname as wh,warehouse.addr as wh_address,
            left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createdate, '%Y-%m-%d'), 
            head.rem,head.contra,head.tax,agent.client as agentcode,agent.clientname as agent,
            head.modeofpayment,head.acctname,head.acctno,head.cardtype,head.waybilldate,head.billlading,head.voyage,left(head.due,10) as due,
            head.vattype,head.salestype,coa.acnoname,head.checked,head.invoiceno,left(head.invoicedate,10) as invoicedate,client.groupid,
            case cntnum.transtype
            when 'R' then 'Regular Transaction'
            when 'S' then 'Senior Transaction'
            when 'RT' then 'Return Transaction - Regular'
            when 'ST' then 'Return Transaction - Senior' 
            when '' then '' end as transtype,concat(head.project,'~',projects.name) as costcenter,head.cmtrans,'' as sjdoc,
            pick.client as pickcode,pick.clientname as pickname,checked.client as checkcode,checked.clientname as checkname,
            head.gm_purchasetype as purchasetype,ms_arastre as arastre,ms_freight as freight,ms_wharffage as wharffage,
            head.ewt,head.ewtrate,head.uv_transtype,head.mlcp_jonum,head.mlcp_freight,head.uv_amountreceived
            FROM $glhead as head
            left join cntnum on cntnum.trno=head.trno
            left join transnum as txnum on txnum.trno = cntnum.txno
            left join coa on coa.acno = head.contra
            left join client on head.clientid=client.clientid
            left join client  as agent on agent.clientid=head.agentid
            left join client as pick on pick.client = head.pickby
            left join client as checked on checked.client = head.checkby
            left join client as warehouse on warehouse.clientid=head.whid
            left join projectmasterfile as projects on projects.code = head.project
            where head.trno=$trno and cntnum.center='$center'";

            //echo $qry;
            $head = Yii::$app->sbccommon->opentable($qry);
            return $head;
        }//end function


        public static function TShead($trno,$lahead){
            $glhead=Common::glhead();
            $qry = "select
            head.trno, head.docno,head.client,client.clientname, head.terms, head.forex, head.yourref, head.ourref,head.contra,warehouse.client as whid, warehouse.clientname as wh,warehouse.addr as wh_address,
            left(head.dateid,10) as dateid, head.clientname, head.address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d'), head.rem,head.contra,head.tax,agent.clientname as agentname,
            head.trpricegrp,rmas.route_name as route,rmas.route_id as routeid,head.agent
            FROM $lahead as head
            left join cntnum on cntnum.trno=head.trno
            left join client  on head.client=client.client
            left join client  as agent on head.agent=agent.client
            left join client  as warehouse on head.wh=warehouse.client
            left join route_masterfile as rmas on rmas.route_id = head.trroute
            where head.trno=$trno
            union all
            SELECT
            head.trno, head.docno,client.client,client.clientname, head.terms, head.forex, head.yourref, head.ourref,head.contra,warehouse.client as whid,warehouse.clientname as wh,warehouse.addr as wh_address,
            left(head.dateid,10) as dateid, head.clientname, head.address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d'), head.rem,head.contra,head.tax,agent.clientname as agentname,
            head.trpricegrp,rmas.route_name as route,rmas.route_id as routeid,ifnull(agent.client,'') as agent
            FROM $glhead as head
            left join cntnum on cntnum.trno=head.trno
            left join client on head.clientid=client.clientid
            left join client  as agent on head.agentid=agent.clientid
            left join client as warehouse on head.whid=warehouse.clientid
            left join route_masterfile as rmas on rmas.route_id = head.trroute
            where head.trno=$trno";
            $head = Yii::$app->sbccommon->opentable($qry);
            return $head;
        }//end function
        
        public static function lock($trno,$doc){
            Yii::$app->systemsettings->setDefaultTimeZone();
            $date=date("Y-m-d H:i:s");
            $user=Yii::$app->session['loggeduser']['username'];
            $table=Common::localhead($doc);
            $docno=Cntnum::getdocno($trno,$doc);
            //Webproc::showmsg('1', "Update $table SET lockdate='$date', lockuser='$user' where trno='$trno'");
            Yii::$app->sbccommon->execqry("Update $table SET lockdate='$date', lockuser='$user' where trno='$trno'");
            Log::writelog($doc,$trno,'LOCK',$docno,$user);
        }
        public static function unlock($trno,$doc)
        {
            $table=Common::localhead($doc);
            $docno=Cntnum::getdocno($trno,$doc);
            $user=Yii::$app->session['loggeduser']['username'];
            Yii::$app->sbccommon->execqry("Update $table SET lockdate=null, lockuser='' where trno='$trno'");
            Log::writelog($doc,$trno,'UNLOCK',$docno,$user);
        }
        public static function islocked($trno,$doc)
        {
            $table=Common::localhead($doc);
            switch ($doc) {
                case 'PO':case 'SO':case 'PC': case 'QT':
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

        }
                
                
                
        public static function rrwarehouse($doc,$trno)           //returns the warehouse of the transaction's head
        {
            $table=Common::localhead($doc);
            $warehouse= Yii::$app->sbccommon->datareader("SELECT wh from $table where trno='$trno'");
                return $warehouse;
        }

        public static function getunpostedtrans()           //returns the warehouse of the transaction's head
        {
        //ON LOAD
        $gotdata = Yii::$app->sbccommon->opentable('select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from prhead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from pohead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from sohead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid , head.docno as docno from pchead as head
                                                    UNION ALL
                                                    select head.trno,head.clientname as customername,head.client,head.doc as doc , head.dateid, head.docno as docno from lahead as head
                                                    ');
        return $gotdata;
        }

                // JEAR UPDATE

        public function getmodulecounts($controller,$access){

        if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
           $data = "not allowed";
            return $data;
        } else {
            $data= Yii::$app->sbccommon->opentable("
            select distinct doc, count(trno) as counts from(
            select head.trno,head.clientname as customername,head.client,head.doc as doc ,
            head.dateid as datex , head.docno as docno from prhead as head
            UNION ALL
            select head.trno,head.clientname as customername,head.client,head.doc as doc ,
            head.dateid as datex , head.docno as docno from pohead as head
            UNION ALL
            select head.trno,head.clientname as customername,head.client,head.doc as doc ,
            head.dateid as datex , head.docno as docno from sohead as head
            UNION ALL
            select head.trno,head.clientname as customername,head.client,head.doc as doc ,
            head.dateid as datex , head.docno as docno from pchead as head
            UNION ALL
            select head.trno,head.clientname as customername,head.client,head.doc as doc ,
            head.dateid as datex , head.docno as docno from lahead as head)
            as countx group by doc
            order by doc");
            return $data;
        }
        return $data;

        }

        public static function getunpostedtransaction($doc){
            switch ($doc) {
                case 'PR':
                    $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                    left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from prhead as head
                    left join transnum on transnum.trno = head.trno
                    left join center on center.code = transnum.center
                    order by dateid asc";
                    break;

                case 'PO':
                    $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                    left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from pohead as head
                    left join transnum on transnum.trno = head.trno
                    left join center on center.code = transnum.center
                    where head.doc='$doc'
                    order by dateid asc";
                    break;

                case 'SO':
                    $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                    left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from sohead as head
                    left join transnum on transnum.trno = head.trno
                    left join center on center.code = transnum.center
                    where head.doc='$doc'
                    order by dateid asc";
                    break;

                case 'PC':
                    $qry = "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                    left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from pchead as head
                    left join transnum on transnum.trno = head.trno
                    left join center on center.code = transnum.center
                    where head.doc='$doc'
                    order by dateid asc";
                    break;
                
                default:
                    $qry = "select center.name as centername,cntnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                    left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from lahead as head
                    left join cntnum on cntnum.trno = head.trno
                    left join center on center.code = cntnum.center
                    where head.doc='$doc'
                    order by dateid asc";
                    break;
            }//end swtich

            $data= Yii::$app->sbccommon->opentable($qry);
            return $data;
        }

}