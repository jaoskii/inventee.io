<?php

namespace app\models;

use Yii;
use yii\base\Model;


class Pohead extends Model{
  public $newdocno;
	public $trno;

  public $waybilldate;
  public $billlading;
  public $voyage;

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
        public $totaldb;
        public $tax;
        public $totalcr;
        public $createdate;
        public $agentcode;
        public $agent;
        public $whid;
        public $wh;
        public $mop;
        public $modamt;
        public $moddate;
        public $modref;
        public $encodedby;        
        public $header;
        public $islocked;
        public $isposted;
        public $cur;
        public $due;
        public $orderfrom;
        public $overhead;
        public $labor;
        public $deliverydate;
        public $pi;
        public $prc;
        public $salestype;

        public $pricegrp;
        public $route;
        public $routeid;

        public $invoiceno;
        public $invoicedate;
        public $groupid;

        //FOR XANDA TRNX TYPE
        public $trnxtype;
        public $isapproved;

        // XANDABELS
        public $totalcbm=0;
        public $totaltonnage=0;
        public $approvalcode;
        public $transmittalcode;
        public $rfdocno;
        public $rftrno;
        // END XANDA

        public $truck;
        public $checker;
        public $driver;
        public $dispatchdate;
        public $returndate;
        public $isinvoiced;

        public $costcenter;

        public $rtype;
        public $rdate;

        public $purchasetype;
        public $arastre = 0;
        public $freight = 0;
        public $wharffage = 0;

        public $effectivedate;
        public $agentpassword;

        public $ewt;
        public $ewtrate = 0;
        
        public $transtype='';
        public $amountreceived = 0;

        public $contra;
        public $picker;
        public $pickername;
        public $checkeragent;
        public $checkername;

        public $reqdate;
        public $withdrawnum;
        public $equipreleasenum;
        public $breakdownreport;

        public $jodocno = '';
        public $mlcp_freight = 0;
        public $mlcp_freighttotal = 0;
        public $mat_barcode;
        public $pricetype;

        public $pickname;
        public $pickcode;
        public $checkname;
        public $checkcode;

	public function rules(){
		return array(
                    array('docno,client,clientname','required'),
                    array('trno, docno', 'length', 'max'=>15),
                    array('client,whid', 'length', 'max'=>15),
                    array('clientname, address, shipto,wh', 'length', 'max'=>150),
                    array('terms', 'length', 'max'=>30),
                    array('mop,modref', 'length', 'max'=>30),
                    array('rem', 'length', 'max'=>500),
                    array('forex', 'length', 'max'=>18),
                    array('yourref, ourref', 'length', 'max'=>25),
                    array('dateid,agent,agentcode,mop,modamt,moddate,modref', 'safe'),
             );
	}//end f

	public function attributeLabels(){

		return array(
			'trno' => 'Tr No',
			'docno' => 'Doc No',
			'client' => 'Client',
		);
	}//end f

        public function suggest($keywords,$limit=20,$module=''){
            $center=Yii::$app->user->center;
            
            $head=Common::localhead($module);
            $hhead=Common::localhhead($module);
            $keyword=explode(",",$keywords);
            $sql ="select c.docno, c.trno ,p.client,p.clientname,p.address, p.yourref, p.ourref, p.shipto, left(p.dateid,10) as dateid, p.terms, p.rem
                    from $head as p
                    left join transnum as c on c.trno=p.trno where c.doc='$module' and";
            $criteria="";

            for($i=0;$i<count($keyword);$i++){
                if ($criteria==""){
                        $criteria = "(c.docno LIKE '%".$keyword[$i]."%' OR client LIKE '%".$keyword[$i]."%' OR clientname LIKE '%".$keyword[$i]."%')";
                    }
                else{
                        $criteria = $criteria." and "."(c.docno LIKE '%".$keyword[$i]."%' OR client LIKE '%".$keyword[$i]."%' OR clientname LIKE '%".$keyword[$i]."%')";
                    }
                    $criteria= $criteria ." and  center='$center'";
            }

            $query1=$sql." ".$criteria;

            $sql2 ="select c.docno, c.trno ,p.client,p.clientname,p.address, p.yourref, p.ourref, p.shipto, left(p.dateid,10) as dateid, p.terms, p.rem
                    from $hhead as p
                    left join transnum as c on c.trno=p.trno where c.doc='$module' and";
            $criteria2="";

            for($i=0;$i<count($keyword);$i++){
                if ($criteria2=="")
                    {
                        $criteria2 = "(c.docno LIKE '%".$keyword[$i]."%' OR client LIKE '%".$keyword[$i]."%' OR clientname LIKE '%".$keyword[$i]."%')";
                    }
                else
                    {
                        $criteria2 = $criteria2." and "."(c.docno LIKE '%".$keyword[$i]."%' OR client LIKE '%".$keyword[$i]."%' OR clientname LIKE '%".$keyword[$i]."%')";
                    }

                    $criteria2= $criteria2 ." and  center='$center'";
            }

            $query2=$sql2." ".$criteria2;

            $models=Yii::$app->sbccommon->opentable($query1 . " union all " . $query2 . " order by trno desc limit $limit");

            $suggest=array();
            foreach($models as $model) {
                        $suggest[] = array(
                                            'label'=> $model['docno'] .' - '. $model['client']  .' - '. $model['clientname'], // label for dropdown list
                                            'value'=>"",  // value for input field

                                            'trno'=>$model['trno'],
                                          );
            }
            return $suggest;
	}
        public static function updatehead($trno, $docno, $data,$doc){
          if ($doc == 'pscheme') {
            $doc = 'PS';
          }//end if

            switch($doc){
                case 'SP': case 'QA': case 'PI': case 'PO': case 'RF':
                case 'PC': case 'PR': case 'SO': case 'KR':
                case 'TX': case 'PS': case'TR': case 'JB':
                case 'quotation': case 'QT': {
                    $table=Common::localhead($doc);
                    return Pohead::update($trno, $doc, $data,$table);
                    break;
                }//END CASE kr
            }//END SWITCH
        }//END UPDATE HEAD

        public static function update($trno, $doc, $data,$table){
          $data->client=preg_replace( "/'/", "`", $data->client );
          $data->clientname=preg_replace( "/'/", "`", $data->clientname );
          $data->address=preg_replace( "/'/", "`", $data->address );
          $data->yourref=preg_replace( "/'/", "`", $data->yourref );
          $data->ourref=preg_replace( "/'/", "`", $data->ourref );
          $data->rem=preg_replace( "/'/", "`", $data->rem );
          $data->shipto=preg_replace( "/'/", "`", $data->shipto );
          $data->terms=preg_replace( "/'/", "`", $data->terms );
          $data->agent=preg_replace( "/'/", "`", $data->agent );
          $user=Yii::$app->session['loggeduser']['username'];
          if($data->agent==null) { $data->agent=""; }
          
          $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
          
          switch($doc){
            case 'SP':
              return  Yii::$app->sbccommon->execqry( "update $table
              SET client='$data->client', clientname='$data->clientname',
              address='$data->address', yourref='$data->yourref',
              ourref='$data->ourref',cur = '$data->cur',forex='$data->forex',due ='$data->due',
              dateid='$data->dateid', rem='$data->rem',agent='$data->agent',effectdate='$data->effectivedate',
              shipto='$data->shipto', terms='$data->terms', editby='$user',editdate='".$timeupdate."'
              where trno='$trno'");
            break;

            // SALON MODIFICATION
            case 'TR':
              return  Yii::$app->sbccommon->execqry("update ".$table."
              SET client='".$data->client."', clientname='".$data->clientname."',
              address='".$data->address."', yourref='".$data->yourref."',
              ourref='".$data->ourref."', forex='".$data->forex."',
              dateid='".$data->dateid."', rem='".$data->rem."',
              shipto='".$data->shipto."', wh='".$data->whid."', editby='".$user."',editdate='".$timeupdate."',
              trpricegrp = '".$data->pricegrp."',trroute='".$data->routeid."',agent='".$data->agent."'
              where trno='".$trno."'");
            break;
            // END SALON


            case 'QT': 
                return  Yii::$app->sbccommon->execqry("update ".$table." 
                SET client='".$data->client."', clientname='".$data->clientname."',
                address='".$data->address."', 
                dateid='".$data->dateid."', rem='".$data->rem."'
                where trno='".$trno."'");
            break;

            case 'PC': case 'PR':
              return  Yii::$app->sbccommon->execqry("update ".$table."
              SET client='".$data->client."', clientname='".$data->clientname."',
              address='".$data->address."', yourref='".$data->yourref."',
              ourref='".$data->ourref."', forex='".$data->forex."',
              dateid='".$data->dateid."', rem='".$data->rem."', terms='".$data->terms."',
              shipto='".$data->shipto."', wh='".$data->whid."', editby='".$user."',editdate='".$timeupdate."'
              where trno='".$trno."'");
            break;

            case 'RF':
              return  Yii::$app->sbccommon->execqry("update ".$table." 
                SET client='".$data->client."', clientname='".$data->clientname."',yourref='".$data->approvalcode."',ourref='".$data->transmittalcode."',
                dateid='".$data->dateid."',rem='".$data->rem."', editby='".$user."',editdate='".$timeupdate."',trnx_type = '".$data->trnxtype."',
                route = '".$data->route."',routeid = '".$data->routeid."'
                where trno='".$trno."'");
            break;

            case 'TX':
              $qrychecker = "select invoiced from txhead where trno = ".$trno."";
              $isinvoiced = Yii::$app->sbccommon->datareader($qrychecker);
              
              if($isinvoiced){
                $qry = "update ".$table." SET rem = '".$data->rem."',
                txchecker = '".$data->checker."',txtruck = '".$data->truck."',txdriver = '".$data->driver."',
                txdispatchdate = '".$data->dispatchdate."',txreturndate = '".$data->returndate."' 
                where trno='".$trno."'";

                $status = Yii::$app->sbccommon->execqry($qry);
              }else{
                $qry = "update ".$table." SET rftrno='".$data->rftrno."',rfdocno='".$data->rfdocno."',rem = '".$data->rem."',
                txchecker = '".$data->checker."',txtruck = '".$data->truck."',txdriver = '".$data->driver."',
                txdispatchdate = '".$data->dispatchdate."',txreturndate = '".$data->returndate."'
                where trno='".$trno."'";

                $status = Yii::$app->sbccommon->execqry($qry);
                $qryselect = "select docno from transnum where trno = ".$trno." and doc = 'TX'";
                $txdocno= Yii::$app->sbccommon->datareader($qryselect);

                if($status){
                    $qry1 = "update transnum set txdocno = '' where txdocno = '".$txdocno."'";
                    $qry2 = "update transnum set txdocno = '".$txdocno."' where trno = ".$data->rftrno."";
                    Yii::$app->sbccommon->execqry($qry1);
                    Yii::$app->sbccommon->execqry($qry2);
                }//end if
              }//end if

              return $status;
            break;

            case 'SO': case 'QA':
                if(strlen($data->moddate) ==0){
                  $moddate = 'NULL';
                }else{
                  $moddate = date('Y-m-d', strtotime($data->moddate));
                }

                return  Yii::$app->sbccommon->execqry("update ".$table." 
                SET client='".$data->client."', clientname='".$data->clientname."',
                address='".$data->address."', yourref='".$data->yourref."',wh='".$data->whid."',
                ourref='".$data->ourref."', forex='".$data->forex."',
                dateid='".$data->dateid."',due = '".$data->due."', rem='".$data->rem."',agent='".$data->agent."',
                mop = '".$data->mop."',modamt='".$data->modamt."',modref='".$data->modref."',
                shipto='".$data->shipto."', terms='".$data->terms."', editby='".$user."',editdate='".$timeupdate."',
                salestype='".$data->salestype."',trnx_type = '".$data->trnxtype."',
                rtype='".$data->rtype."',rdate='".$data->rdate."',
                uv_transtype='".$data->transtype."',uv_amountreceived = '".$data->amountreceived."',
                uv_picker='".$data->picker."', uv_pickername = '".$data->pickername."',
                uv_checker = '".$data->checkeragent."', uv_checkername = '".$data->checkername."'
                where trno='".$trno."'");
            break;

            case 'JB':
                return  Yii::$app->sbccommon->execqry("update ".$table." 
                SET client='".$data->client."', clientname='".$data->clientname."',
                yourref='".$data->yourref."',wh='".$data->whid."',
                ourref='".$data->ourref."', forex='".$data->forex."',
                dateid='".$data->dateid."',due = '".$data->due."', rem='".$data->rem."',agent='".$data->agent."',
                shipto='".$data->shipto."', terms='".$data->terms."', editby='".$user."',editdate='".$timeupdate."',
                salestype = '".$data->salestype."',trnx_type = '".$data->trnxtype."',
                reqdate = '".$data->reqdate."',pricetype = '".$data->pricetype."'
                where trno='".$trno."'");
            break;

            case 'PI':
                return  Yii::$app->sbccommon->execqry("update ".$table."
                SET client='".$data->client."', clientname='".$data->clientname."',
                address='".$data->address."', yourref='".$data->yourref."',
                ourref='".$data->ourref."', forex='".$data->forex."',
                dateid='".$data->dateid."', rem='".$data->rem."',
                overhead='".$data->overhead."', labor='".$data->labor."',
                shipto='".$data->shipto."', wh='".$data->whid."', editby='".$user."',editdate='".$timeupdate."'
                where trno='".$trno."'");
            break;

            default:
              return  Yii::$app->sbccommon->execqry("UPDATE $table
              SET client='$data->client', clientname='$data->clientname',
              address='$data->address', yourref='$data->yourref',
              ourref='$data->ourref',cur = '$data->cur',forex='$data->forex',due ='$data->due',
              dateid='$data->dateid', rem='$data->rem',agent='$data->agent',wh='$data->whid', 
              shipto='$data->shipto', terms='$data->terms', editby='$user',editdate='$timeupdate'
              where trno='$trno'");
            break;
          }//end switch

        }//END UPDATE
        
        public static function inserthead($docno, $doc, $trno,$data){
            if ($doc =='pscheme') {
              $doc='PS';
            }//end if

            switch($doc){
                case 'SP': case 'JB':
                case 'QA': case 'PI': case 'PD':
                case 'PO': case 'SO': case 'PC':
                case 'PS': case 'PR': case 'KR': case 'QT':
                case 'TR': case 'RF': case 'TX':
                case 'QT':
                    $table=Common::localhead($doc);
                    return Pohead::insert($docno, $doc, $trno,$data,$table);
                    break;
            }//END SWITCH
        }//end insert head
        
        public static function insert($docno, $doc, $trno,$data,$table){
           $data->client=preg_replace( "/'/", "`", $data->client );
           $data->clientname=preg_replace( "/'/", "`", $data->clientname );
           $data->address=preg_replace( "/'/", "`", $data->address );
           $data->yourref=preg_replace( "/'/", "`", $data->yourref );
           $data->ourref=preg_replace( "/'/", "`", $data->ourref );
           $data->rem=preg_replace( "/'/", "`", $data->rem );
           $data->shipto=preg_replace( "/'/", "`", $data->shipto );
           $data->terms=preg_replace( "/'/", "`", $data->terms );
           $data->agent=preg_replace( "/'/", "`", $data->agent );

          if($data->agent==null) { $data->agent="";}

          if($data->orderfrom == "ONLINE"){
             $user=$data->clientname; // replaced by data encodedby
          }else{
             $user=Yii::$app->session['loggeduser']['username']; // replaced by data encodedby
          }
           

          switch ($doc) {
            case 'SP':
              $qry = "insert into $table (docno, doc, client, clientname, address, yourref,
                ourref,cur, forex, dateid, rem,agent, shipto, terms,trno,createby,wh,due,effectdate)
                values('$docno','$doc', '$data->client', '$data->clientname', '$data->address','$data->yourref',
                '$data->ourref','$data->cur', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
                '$data->shipto', '$data->terms', '$trno','$user','$data->whid','$data->due','$data->effectivedate')";
              $insert=Yii::$app->sbccommon->execqry($qry);
            break;

            case 'PC': case 'PR':
              $qry = "insert into $table
              (docno, doc, client, clientname, address, yourref, ourref, forex, dateid, rem,agent, shipto, terms,trno,createby,wh)
              values('$docno','$doc', '$data->client', '$data->clientname', '$data->address',
                     '$data->yourref', '$data->ourref', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
                     '$data->shipto', '$data->terms', '$trno','$user','$data->whid')";
              $insert=Yii::$app->sbccommon->execqry($qry);
            break;

            case 'TR':
              $qry = "insert into $table
              (docno, doc, client, clientname, address, yourref, ourref, forex, dateid,
              rem,agent, shipto, terms,trno,createby,wh,trpricegrp,trroute)
              values('$docno','$doc', '$data->client', '$data->clientname', '$data->address',
                     '$data->yourref', '$data->ourref', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
                     '$data->shipto', '$data->terms', '$trno','$user','$data->whid','$data->pricegrp','$data->routeid')";
              $insert=Yii::$app->sbccommon->execqry($qry);
            break;


            case 'QT': 
               $sql="INSERT into $table (docno, doc, client, clientname, address, dateid, rem, trno)
              values('$docno','$doc', '$data->client', '$data->clientname', '$data->address',
               '$data->dateid', '$data->rem', '$trno')";
              
               $insert=Yii::$app->sbccommon->execqry($sql);
            break;

            case 'SO': case 'QA': case 'PS':
              if(strlen($data->moddate) ==0) { $moddate = 'NULL'; } else { $moddate = date('Y-m-d', strtotime($data->moddate)); } //end strlen moddate
              $sql="INSERT into $table (docno, doc, client, clientname, address, yourref, ourref, forex, dateid, rem,agent, shipto,
              terms,trno,createby,wh,mop,modamt,moddate,modref,due,salestype,trnx_type,rtype,rdate,uv_amountreceived,uv_transtype,
              uv_picker,uv_checker,uv_checkername,uv_pickername)
              values('$docno','$doc', '$data->client', '$data->clientname', '$data->address',
              '$data->yourref', '$data->ourref', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
              '$data->shipto', '$data->terms', '$trno','$user','$data->whid','$data->mop','$data->modamt',$moddate,
              '$data->modref','$data->due','$data->salestype','$data->trnxtype','$data->rtype','$data->rdate',
              '$data->amountreceived','$data->transtype','$data->picker','$data->checkeragent','$data->checkername','$data->pickername')";

              $insert=Yii::$app->sbccommon->execqry($sql);
            break;

            case 'JB':
              $sql="INSERT into $table (docno, doc, client, clientname, address, yourref, ourref, forex, dateid, rem,agent, shipto,
              terms,trno,createby,wh,mop,salestype,trnx_type,reqdate,pricetype)
              values('$docno','$doc', '$data->client', '$data->clientname', '$data->address',
              '$data->yourref', '$data->ourref', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
              '$data->shipto', '$data->terms', '$trno','$user','$data->whid','$data->mop',
              '$data->salestype','$data->trnxtype','$data->reqdate','$data->pricetype')";

              $insert=Yii::$app->sbccommon->execqry($sql);
            break;

            case 'PI':
              $qry = "insert into $table (docno, doc, client, clientname, address, yourref,
                ourref,cur, forex, dateid, rem,agent, shipto, terms,trno,createby,wh,due,overhead,labor)
                values('$docno','$doc', '$data->client', '$data->clientname', '$data->address','$data->yourref',
                '$data->ourref','$data->cur', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
                '$data->shipto', '$data->terms', '$trno','$user','$data->whid','$data->due',$data->overhead,$data->labor)";
              $insert=Yii::$app->sbccommon->execqry($qry);
            break;

            case 'PD':
              $qry = "insert into $table (docno, doc, client, clientname, address, yourref,
                ourref,cur, forex, dateid, rem,agent, shipto, terms,trno,createby,wh,due,delivdate,prc)
                values('$docno','$doc', '$data->client', '$data->clientname', '$data->address','$data->yourref',
                '$data->ourref','$data->cur', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
                '$data->shipto', '$data->terms', '$trno','$user','$data->whid','$data->due','$data->deliverydate','')";
              $insert=Yii::$app->sbccommon->execqry($qry);
            break;

            case 'RF':
              $qry = "insert into $table (docno, doc, client, clientname, yourref,ourref, dateid, rem,
                trno,createby,trnx_type,route,routeid)
                values('$docno','$doc', '$data->client', '$data->clientname','$data->approvalcode','$data->transmittalcode', '$data->dateid', '$data->rem',
                '$trno','$user','$data->trnxtype','$data->route','$data->routeid')";
              $insert=Yii::$app->sbccommon->execqry($qry);
            break;

            case 'TX':
              $insert=Yii::$app->sbccommon->execqry("insert into $table (docno, dateid, rem,trno,createdby) values('$docno','$data->dateid', '$data->rem','$trno','$user')");
            break;

            default:
              $qry = "insert into $table (docno, doc, client, clientname, address, yourref,
                ourref,cur, forex, dateid, rem,agent, shipto, terms,trno,createby,wh,due)
                values('$docno','$doc', '$data->client', '$data->clientname', '$data->address','$data->yourref',
                '$data->ourref','$data->cur', '$data->forex', '$data->dateid', '$data->rem','$data->agent',
                '$data->shipto', '$data->terms', '$trno','$user','$data->whid','$data->due')";
              $insert=Yii::$app->sbccommon->execqry($qry);
            break;
          }//end switch
          if($insert==1) {
              switch ($doc) {
                case 'TX':
                  Log::writelog($doc, $trno, 'CREATE', $docno,$user);
                break;
                
                default:
                  Log::writelog($doc, $trno, 'CREATE', $docno.' CLIENT - '.$data->client.' - '.$data->clientname,$user);
                break;
              }//END SWITCH
            return true;
          } else {
              return false;
          }//end if insert == 1
        }//END INSERT HEAD
        
        public static function openhead($trno,$doc){
            $table=Common::localhead($doc);
            $htable=Common::localhhead($doc);
            $head=Pohead::head($trno,$table,$htable,$doc);
            return $head;
        }//END FUNC TION

        public static function head($trno,$table,$htable,$doc){
            $center=Yii::$app->session['loggeduser']['center'];
            switch($doc){
              case 'TX':
              $qry = "select head.invoiced,head.rfdocno,head.rftrno,rhead.route,rhead.routeid,rhead.client as agentcode,rhead.clientname as agentname,
                      transnum.center,head.trno,head.docno,head.dateid,head.rem,rhead.yourref as approvalcode from txhead as head
                      left join transnum on transnum.trno = head.trno
                      left join hrfhead as rhead on rhead.trno = head.rftrno
                      where head.trno = ".$trno." and transnum.center='".$center."'
                      UNION ALL
                      select head.invoiced,head.rfdocno,head.rftrno,rhead.route,rhead.routeid,rhead.client as agentcode,rhead.clientname as agentname,
                      transnum.center,head.trno,head.docno,head.dateid,head.rem,rhead.yourref as approvalcode from htxhead as head
                      left join transnum on transnum.trno = head.trno
                      left join hrfhead as rhead on rhead.trno = head.rftrno
                      where head.trno = ".$trno." and transnum.center='".$center."'";
              break;

              case 'SP':
              $qry = "select
              transnum.center,head.trno, head.docno,client.client, head.terms,head.cur,head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,head.agent,head.wh as whid, 
              warehouse.clientname as wh,left(head.due,10) as due,client.groupid,head.effectdate
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT
              transnum.center, head.trno, head.docno,client.client, head.terms,head.cur, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,head.agent,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,client.groupid,head.effectdate
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno."  and transnum.center='$center'";
              break;

              case 'PI':
              $qry = "select transnum.center,head.trno, head.docno,head.client, head.terms,head.cur,head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate,
              head.rem,head.agent,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,head.overhead,head.labor
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT
              transnum.center, head.trno, head.docno,head.client, head.terms,head.cur, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,head.agent,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,head.overhead,head.labor
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno."  and transnum.center='$center'";
              break;

              case 'PD':
              $qry = "select transnum.center,head.trno, head.docno,head.client, head.terms,head.cur,head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate,
              head.rem,head.agent,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,head.delivdate,head.pi,head.prc
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT
              transnum.center, head.trno, head.docno,head.client, head.terms,head.cur, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,head.agent,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,head.delivdate,head.pi,head.prc
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno."  and transnum.center='$center'";
              break;

              case 'TR':
              $qry = "select
              transnum.center,head.trno, head.docno,client.client, head.terms,head.cur,head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,
              head.agent,agent.clientname as agentname,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,head.trpricegrp,
              rmas.route_name as route,rmas.route_id as routeid,client.groupid
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              left join route_masterfile as rmas on rmas.route_id = head.trroute
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT
              transnum.center, head.trno, head.docno,client.client, head.terms,head.cur, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,
              head.agent,agent.clientname as agentname,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,head.trpricegrp,
              rmas.route_name as route,rmas.route_id as routeid,client.groupid
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              left join route_masterfile as rmas on rmas.route_id = head.trroute
              where head.trno=".$trno."  and transnum.center='$center'";
              break;

              case 'RF':
              $qry = "select transnum.txdocno,transnum.center,head.trno, head.docno,client.client, head.terms, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, 
              head.rem,head.agent,agent.clientname as agname ,head.wh as whid, warehouse.clientname as wh,
              head.mop,head.modamt,head.modref,left(head.moddate,10) as moddate,left(head.due,10) as due,head.salestype,client.groupid,trnx_type,0 as isapproved,
              head.route,head.routeid
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT transnum.txdocno,transnum.center, head.trno, head.docno,client.client, head.terms, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate,
              head.rem,head.agent,agent.clientname as agname ,head.wh as whid, warehouse.clientname as wh,
              head.mop,head.modamt,head.modref,left(head.moddate,10) as moddate,left(head.due,10) as due,head.salestype,client.groupid,trnx_type,isapproved,
              head.route,head.routeid
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno."  and transnum.center='$center'";
              break;

              case 'SO': case 'QA': case 'QT':
              $qry = "select head.rdate,head.rtype,transnum.center,head.trno, head.docno,client.client, head.terms, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, 
              head.rem,head.agent,agent.clientname as agname ,head.wh as whid, warehouse.clientname as wh,
              head.mop,head.modamt,head.modref,left(head.moddate,10) as moddate,left(head.due,10) as due,head.salestype,client.groupid,trnx_type,0 as isapproved,
              '' as approvalcode,'' as  rfdocno,uv_transtype,uv_amountreceived,head.uv_picker, head.uv_pickername, head.uv_checker, head.uv_checkername
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT head.rdate,head.rtype,transnum.center, head.trno, head.docno,client.client, head.terms, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate,
              head.rem,head.agent,agent.clientname as agname ,head.wh as whid, warehouse.clientname as wh,
              head.mop,head.modamt,head.modref,left(head.moddate,10) as moddate,left(head.due,10) as due,head.salestype,client.groupid,trnx_type,isapproved,
              ifnull((select rfhead.yourref from rfhead where rfhead.trno = head.rfno 
              UNION ALL 
              select hrfhead.yourref from hrfhead where hrfhead.trno = head.rfno),'') as approvalcode,
              ifnull((select rfhead.docno from rfhead where rfhead.trno = head.rfno 
              UNION ALL 
              select hrfhead.docno from hrfhead where hrfhead.trno = head.rfno),'') as rfdocno,
              uv_transtype,uv_amountreceived,head.uv_picker, head.uv_pickername,head.uv_checker, head.uv_checkername
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno."  and transnum.center='$center'";
              break;

              case 'JB':
              $qry = "select head.mat_barcode,head.rdate,head.rtype,transnum.center,head.trno, head.docno,client.client, head.terms, 
              head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, 
              head.rem,head.agent,agent.clientname as agname ,head.wh as whid, warehouse.clientname as wh,
              head.mop,head.modamt,head.modref,left(head.moddate,10) as moddate,left(head.due,10) as due,
              head.salestype,client.groupid,trnx_type,0 as isapproved,
              '' as approvalcode,'' as  rfdocno,uv_transtype,uv_amountreceived,
              head.uv_picker, head.uv_pickername, head.uv_checker,
              head.uv_checkername,head.reqdate,ifnull(mi.docno,'') as withdrawnum,
              ifnull(ts.docno,'') as equipreleasenum,head.breakdownreport,head.pricetype
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              left join cntnum as ts on ts.trno = head.equipreleasenum and ts.doc = 'TS'
              left join cntnum as mi on mi.trno = head.withdrawnum and mi.doc = 'MI'
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT head.mat_barcode,head.rdate,head.rtype,transnum.center, head.trno, head.docno,client.client,
              head.terms, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,
              DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate,
              head.rem,head.agent,agent.clientname as agname ,head.wh as whid, warehouse.clientname as wh,
              head.mop,head.modamt,head.modref,left(head.moddate,10) as moddate,left(head.due,10) as due,head.salestype,client.groupid,trnx_type,isapproved,
              ifnull((select rfhead.yourref from rfhead where rfhead.trno = head.rfno 
              UNION ALL 
              select hrfhead.yourref from hrfhead where hrfhead.trno = head.rfno),'') as approvalcode,
              ifnull((select rfhead.docno from rfhead where rfhead.trno = head.rfno 
              UNION ALL 
              select hrfhead.docno from hrfhead where hrfhead.trno = head.rfno),'') as rfdocno,
              uv_transtype,uv_amountreceived,head.uv_picker, head.uv_pickername,
              head.uv_checker, head.uv_checkername,head.reqdate,
              ifnull(mi.docno,'') as withdrawnum,ifnull(ts.docno,'') as equipreleasenum,head.breakdownreport,head.pricetype
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              left join cntnum as ts on ts.trno = head.equipreleasenum and ts.doc = 'TS'
              left join cntnum as mi on mi.trno = head.withdrawnum and mi.doc = 'MI'
              where head.trno=".$trno."  and transnum.center='$center'";
              break;

              default:
              $qry = "select
              transnum.center,head.trno, head.docno,client.client, head.terms,head.cur,head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,head.agent,head.wh as whid, 
              warehouse.clientname as wh,left(head.due,10) as due,client.groupid
              FROM $table as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno." and transnum.center='$center'
              union all
              SELECT
              transnum.center, head.trno, head.docno,client.client, head.terms,head.cur, head.forex, head.yourref, head.ourref,
              left(head.dateid,10) as dateid, head.clientname, address, shipto,DATE_FORMAT(head.createDate, '%Y-%m-%d') as createdate, head.rem,head.agent,head.wh as whid, warehouse.clientname as wh,left(head.due,10) as due,client.groupid
              FROM $htable as head
              left join transnum on transnum.trno=head.trno
              left join client on head.client=client.client
              left join client as agent on head.agent=agent.client
              left join client as warehouse on warehouse.client=head.wh
              where head.trno=".$trno."  and transnum.center='$center'";
              break;
            }//end case
            $head = Yii::$app->sbccommon->opentable($qry);
            return $head;
        }

       /* public static function sohead($trno,$table,$htable){

            $center=Yii::$app->session['loggeduser']['center'];            
            
            
            $head = Yii::$app->sbccommon->opentable($qry);
            
            return $head;
        }*/

        public static function lock($doc,$trno){
            $date=date("Y-m-d H:i:s");
            $table=Common::localhead($doc);
            $user=Yii::$app->session['loggeduser']['username'];
            $docno=Cntnum::getdocno($trno,$doc);
            Yii::$app->sbccommon->execqry("update $table SET lockdate='".$date."', lockuser='".$user."' where trno='".$trno."'");
            Log::writelog($doc,$trno,'LOCK',$docno,$user);
        }

        public static function unlock($doc,$trno){
            $table=Common::localhead($doc);
            $docno=Cntnum::getdocno($trno,$doc);
            $user=Yii::$app->session['loggeduser']['username'];
            Yii::$app->sbccommon->execqry("update $table SET lockdate=null, lockuser='' where trno='$trno'");
            Log::writelog($doc,$trno,'UNLOCK',$docno,$user);
        }

        public static function islocked($doc,$trno){
            $table=Common::localhead($doc);
            $htable=Common::localhhead($doc);
            $islocked= Yii::$app->sbccommon->datareader("
                    SELECT lockdate from $table where trno='$trno' and doc='$doc'
                    union all
                    SELECT lockdate from $htable where trno='$trno' and doc='$doc'
                    ");
            if ($islocked!=null){
                return true;
            }else{
                return false;
            }
        }//end function is locked
}