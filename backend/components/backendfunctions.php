<?php
namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\Web\Session;
use yii\helpers\Url;

use app\models\Common;
use app\models\Webproc;
//EMPLOYEE
use app\models\Employee;
use app\models\Postock;
use app\models\Lahead;
use app\models\Pohead;
use app\models\Lastock;
use app\models\Ladetail;
use app\models\Postdatedchecks;
use app\models\Log;
use app\models\Taxdetail;
use app\models\Taxhead;
use app\models\Cntnum;

use yii\base\ErrorException;

use yii\web\Response;

class backendfunctions extends Component{
    //TODO: fix navigations for stockcard and other masterfiles
    public function getCurrentVattype($trno){
      $qry = "select vattype from lahead where trno =" . $trno;
      $vattype = Yii::$app->sbccommon->datareader($qry);
      return $vattype;
    }//end fn

    public function getPreviousAndCurrentVattype($trno){
      $qry = "select vattype from tbl_transaction_vattype_history where trno = ".$trno." order by id desc limit 2";
      $data = Yii::$app->sbccommon->opentable($qry);

      if(!empty($data)){
        return ['current' => $data[0]['vattype'], 'previous' => $data[1]['vattype']];
      }else{
        return ['current' => $this->getCurrentVattype($trno), 'previous' => null];
      }//end if
    }//end function
    
    public function generateReportLog($params, $title ,$key = 0, $type = '',$doc = ''){
      $username = Yii::$app->session['loggeduser']['username'];

      $insertfields = [
        "log_title" => $title,
        "log_description" => '',
        "userid" => Yii::$app->session['loggeduser']['userid'],
        "dateid" => Yii::$app->systemsettings->getCurrentTimeStamp(),
        "code" => '',
        "uni_key" => $key,
      ];

      if($key == 0){
        $desc = '<b>' . $username . '</b> has printed <b>' . $title . '</b><br><br>';
        $desc .= '<b>PARAMETERS:</b><br>';

        foreach ($params as $key => $value) {
          $desc .= strtoupper($key) . ':' . $value . '<br>';
        }//end for each\


        $insertfields['log_description'] = $desc;
      }else{
        //var_dump($params);
        $code = $this->searchForCode($key, $type, $doc);

        /*var_dump($code);*/
        $desc = '<b>' . $username . '</b> has printed <b>' . $title. ' ('.$code.')</b>. <br><br>';
        $desc .= '<b>PARAMETERS:</b><br>';

        foreach ($params as $key => $value) {
          $desc .= strtoupper($key) . ':' . $value . '<br>';
        }//end for each\

        $insertfields['code'] = $code;
        $insertfields['log_description'] = $desc;
      }//end fn

      $qry_fields = "";
      $qry_values = "";

      foreach ($insertfields as $key => $value) {
        if($qry_fields == ""){
          $qry_fields = $key;
        }else{
          $qry_fields .= ",".$key;
        }//end if

        if($qry_values == ""){
          $qry_values = "'".$value."'";
        }else{
          $qry_values .= ",'".$value."'";
        }//end if
      }//end for each


      $qryfinal = "insert into tbl_logtracer (".$qry_fields.") values(".$qry_values.")";
      $status = Yii::$app->sbccommon->execqry($qryfinal);

      return $status;
    }//end nf

    private function searchForCode($key, $type, $doc){
      if($type == 'module'){
        $webproc = new Webproc;
        $openhead=$webproc->gettranstype($doc); //GETS TABLENAME FOR LOCAL

        switch($openhead) {
            case "Lahead": 
              $qry = "select docno from cntnum where trno = " . $key;
            break;

            case "Taxhead": 
              $qry = "select docno from taxnum where trno = " . $key;
            break; 

            default: 
              $qry = "select docno from transnum where trno = " . $key;
            break;
        }//END SWITCH
        
        $found = Yii::$app->sbccommon->datareader($qry);
        return $found;
      }else if ($type == 'client'){
        $qry = "select client from client where clientid = " . $key;
        $found = Yii::$app->sbccommon->datareader($qry);
        return $found;
      }else{
        $qry = "select barcode from item where itemid = " . $key;
        $found = Yii::$app->sbccommon->datareader($qry);
        return $found;
      }//end if
    }//end nf

    public function getStockAccess($doc){
      switch ($doc) {
        case 'SJ':
          $defaultaccess = ['changeamt'=>180];
          
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
              $defaultaccess['changedisc'] = 3301;
            break;
          }//end switch
        break;

        case 'SO':
          $defaultaccess = ['changeamt'=>161];
          
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
              $defaultaccess['changedisc'] = 3302;
            break;
          }//end switch
        break;

        case 'CM':
          $defaultaccess = ['changeamt'=>202];
          
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
              $defaultaccess['changedisc'] = 3303;
            break;
          }//end switch
        break;
      }//end switch

      foreach ($defaultaccess as $key => $value) {
        if(Yii::$app->sbccontroller->verifyaccess($value)){
          $defaultaccess[$key] = true;
        }else{
          $defaultaccess[$key] = false;
        }//end if
      }//end if
        
      return $defaultaccess;
      //echo json_encode($defaultaccess);
    }//end fn

    //WTODO: [JLY][2019.08.17][KINGG CONCERNS][ADD GROUP FILTER START]
     public function searchClientgroup($controller,$access,$x) {
      $filter='';
      if($x!=''){
        $filter="where groupid like '%".$x."%' or clientname like '%".$x."%'";
      }//end if
   
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      }else{
        return "select '' as groupid,'' as clientgroup
                UNION ALL
                select groupid, groupid as clientgroup from client ".$filter." group by groupid asc";
      }//end if
    }//end fn

    public function getAvailableInventory($params){
      switch (Yii::$app->systemsettings->companyConfig()) {
        case 'UNIVERSE':
          $qry = "select rrstatus.expiry,rrstatus.loc,wh.client as wh,sum(rrstatus.bal) as bal from rrstatus
          left join item on item.itemid = rrstatus.itemid
          left join client as wh on wh.clientid = rrstatus.whid
          where rrstatus.itemid = ".$params['q']." 
          and wh.client = '".$params['wh']."' and rrstatus.bal <> 0 
          group by expiry 
          order by expiry asc";
        break;
        
        case 'MLCP':
          $qry = "select rrstatus.expiry,rrstatus.loc,wh.client as wh,rrstatus.bal,rrstatus.cost from rrstatus
          left join item on item.itemid = rrstatus.itemid
          left join client as wh on wh.clientid = rrstatus.whid
          where rrstatus.itemid = ".$params['q']." 
          and wh.client = '".$params['wh']."' and rrstatus.bal <> 0 order by rrstatus.dateid asc";
        break;
      }//END SWITCH
      
      $data = Yii::$app->sbccommon->opentable($qry);
      return $data;
    }//end fn 

    public function copytransactionDetails($controller,$params){
      $message = "";
      $webproc = new Webproc; 
      $doc = $controller->module->id;
      $openhead=$webproc->gettranstype($doc);
      if($openhead=='Lahead'){$head = new Lahead();}else{$head = new Pohead();}
      $common = new Common();
      $docnolength = $common->doclength();
      
      if(strlen($params['docno']) == 2){
        $pref = $params['docno'];
        $seq = $common->getlastseq($pref,$doc,Yii::$app->session['loggeduser']['center']);
        $poseq = $pref . $seq;
        $newdocno = $common->PadJ($poseq, $docnolength);
      }else{
        $poseq = $params['docno'];
        $newdocno = $common->PadJ($poseq, $docnolength);
      }//end if

      $head->docno = $newdocno;
      
      switch($params['copydoc']){
        case 'SO':
          $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,
          head.client,head.clientname,head.address,head.agent,
          head.wh,wh.clientname as whname,head.rem,head.shipto,head.yourref,head.ourref,
          head.uv_picker,head.uv_checker,head.due,head.terms,head.uv_transtype,
          head.salestype,head.uv_amountreceived from hsohead as head
          left join hsostock as stock on stock.trno = head.trno 
          left join client as wh on wh.client = head.wh and wh.iswarehouse = 1
          where head.trno =".$params['copytrans'];
        break;
      }//end switch
      
      $data = Yii::$app->sbccommon->opentable($qry);
     
      $head->dateid = $data[0]['dateid'];
      $head->client = $data[0]['client'];
      $head->clientname = $data[0]['clientname'];
      $head->due = $data[0]['dateid'];
      $head->forex = 1.00;
      $head->cur = 'P';
      $head->address = $data[0]['address'];
      $head->agent = $data[0]['agent'];
      $head->rem = $data[0]['rem'];
      $head->shipto = $data[0]['shipto'];
      $head->yourref = $data[0]['yourref'];
      $head->ourref = $data[0]['docno'];
      
      $head->checkcode = $data[0]['uv_checker'];
      $head->pickcode = $data[0]['uv_picker'];
      $head->waybilldate = $data[0]['dateid'];

      if($openhead == 'Lahead'){
          $head->tax = Yii::$app->backend->getdefaultValues('tax');
      }//end f

      $head->transtype = $data[0]['uv_transtype'];
      $head->amountreceived = $data[0]['uv_amountreceived'];
      
      switch($doc) {
          case'RR':
            $contra='AP1';
          break;

          case 'SJ':
            switch($data[0]['salestype']){
              case 'CHARGE':
                $contra = 'AR1';
              break;

              case 'CASH':
                $contra = 'CA1';
              break;

              case 'CHECK':
                $contra = 'CR1';
              break;
            }//end switch
          break;
      }//END case

      $head->salestype = $data[0]['salestype'];
      
      if($contra!=''){
          $head->contra = Ladetail::getacno($contra)  ;
      }//end if

      $head->whid = $data[0]['wh'];
      $head->wh = $data[0]['whname'];
      $head->vattype = '';
      $head->tax = 0;

      $body = "";
      $head->isposted = false;
      $head->islocked = false;

      $common = new Common();
      $trno = "";

     
      $prefixes = $common->getPrefixes($doc);//GETS ALL PREFIXES FOR THIS DOC
      $blnExist = true;


      $docnolength = $common->doclength();
      $docno = $head->docno;
      if ($docnolength != strlen($docno)) { $docno = $common->PadJ($docno, $docnolength); }
      $bref = $common->GetPrefix($docno);
      $seq = (substr($docno, $common->SearchPosition($docno), strlen($docno)));

      $insertcntnum = $common->insertcntnum($doc, $docno, $seq, $bref,Yii::$app->session['loggeduser']['center']);

      if($insertcntnum==0) {
          while ($insertcntnum == 0) { //IF TRANSACTION IS SAME DOCUMENT IT CREATES ANOTHER UNTIL IT COULD BE VALID DOCNO
              $pref = $common->GetPrefix($docno);
              $docnolength = $common->doclength();
              $seq = $common->getlastseq($doc,$doc,Yii::$app->session['loggeduser']['center']);
              $poseq = $pref . $seq;
              $newdocno = $common->PadJ($poseq, $docnolength);

              
              $insertcntnum = $common->insertcntnum($doc, $newdocno, $seq, $bref,Yii::$app->session['loggeduser']['center']);
              
              if (($docno != $newdocno) && ($trno == "") && ($insertcntnum !=0) ) {
                  $docno = $newdocno;
                  $head->docno = $newdocno;
                  $title = 'Document number taken';
                  $message = 'Your transaction has been saved under document # ' . $newdocno;
              }
          }//end white insertcntnum
      }//END insertcntnum 0

      $trno_ = Cntnum::getTrnodocno($docno,$doc,Yii::$app->session['loggeduser']['center']);
      $trno = $trno_[0]['trno'];
      $docno = $trno_[0]['docno'];
      $head->trno = $trno;
      $i=2;


      a:                      
        if($i>0) {
          if($openhead=='Lahead'){
              $insert = Lahead::inserthead($docno,$doc, $trno, $head);
          }else{
              $insert = Pohead::inserthead($docno,$doc, $trno, $head);
          }//endi f            


         
          switch($openhead) {
              case "Lahead": $headdata = Lahead::openhead($trno,$doc); break;
              default: $headdata = Pohead::openhead($trno,$doc); break;
          }//ed swtcj
        }//end if $i >0
    
        if(!empty($headdata)) { //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
            $head=$webproc->loadheaddata($head, $headdata,$doc);
            $i=-1;
        }else{
            $message = 'Error Saving head please try again!';
            $i=$i-1;
            if($i>0) {
                goto a;
            } else {
                $tablenum = Common::gettablenum($doc);
                $qrydeletecntnum = "delete from ".$tablenum." where trno = ".$trno."";
                Yii::$app->sbccommon->execqry($qrydeletecntnum);
            }//end if if($i>0)
        }//end if


        $qrystock = "select head.docno,".$trno." as trno,stock.itemname,stock.barcode,stock.uom,stock.wh,wh.clientname as whname,
                    stock.disc,stock.rem,stock.isamt,stock.isqty,stock.amt,stock.iss,stock.ext,uom.factor as uomfactor,
                    stock.trno as refx,stock.line as linex,stock.loc,stock.expiry,item.itemid
                    from hsostock as stock
                    left join client as wh on wh.client = stock.wh and wh.iswarehouse = 1
                    left join hsohead as head on head.trno = stock.trno
                    left join item on item.barcode = stock.barcode
                    left join uom on uom.uom = stock.uom and uom.itemid = item.itemid
                    where stock.trno = '".$params['copytrans']."' and stock.void <> 1 and stock.qa <> stock.iss";
       
        $stockdata = Yii::$app->sbccommon->opentable($qrystock);
        $tempdata = [];

        if(Yii::$app->systemsettings->companyConfig() == 'UNIVERSE'){
          foreach ($stockdata as $key => $value) {
            $liner = $key;
            $tempdatarow = [];
            switch (Yii::$app->systemsettings->companyConfig()) {
              case 'UNIVERSE':
                  if($doc == "SJ" || $doc == "TS" || $doc == "MX" || $doc == "MI"){
                    $params['q'] = $value['itemid'];
                    $params['wh'] = $value['wh'];
                    $invdata = $this->getAvailableInventory($params);

                    if(!empty($invdata)){
                        for ($i=0; $i < count($invdata) ; $i++) { 
                          if(floatval($invdata[$i]['bal']) > floatval($value['iss'])){
                            foreach ($value as $key2 => $value2) {
                                switch ($key2) {
                                  case 'expiry': case 'loc':
                                    $tempdatarow[$key2] = $invdata[$i][$key2];
                                  break;
                                  
                                  case 'ext': case 'amt':
                                    $computeddata = $this->computestock_Internal($value['isamt'],$value['disc'],$value['isqty'],$value['uomfactor'],$doc);
                                    $tempdatarow['ext'] = $computeddata['ext'];
                                    $tempdatarow['amt'] = $computeddata['amt'];
                                  break;

                                  default:
                                    $tempdatarow[$key2] = $value2;
                                  break;
                                }//end swith
                            }//end for each 2

                            if(isset($tempdata[$liner])){
                              $liner += 1;
                              $tempdata[$liner] = $tempdatarow;
                            }else{
                              $tempdata[$liner] = $tempdatarow;
                            }//end if

                            break; //used to EXIT LOOP
                          }else{
                            foreach ($value as $key2 => $value2) {
                                switch ($key2) {
                                  case 'iss':
                                    $value[$key2] = floatval($value[$key2]) - floatval($invdata[$i]['bal']);
                                    $tempdatarow[$key2] = floatval($invdata[$i]['bal']);
                                  break;

                                  case 'isqty':
                                    $value[$key2] = (floatval($value[$key2]) - floatval($invdata[$i]['bal'])) / floatval($value['uomfactor']); 
                                    $tempdatarow[$key2] = floatval($invdata[$i]['bal']) / floatval($value['uomfactor']); 
                                  break;

                                  case 'expiry': case 'loc':
                                    $tempdatarow[$key2] = $invdata[$i][$key2];
                                  break;
                                  
                                  case 'ext': case 'amt':
                                    $computeddata = $this->computestock_Internal($value['isamt'],$value['disc'],$value['isqty'],$value['uomfactor'],$doc);
                                    $tempdatarow['ext'] = $computeddata['ext'];
                                    $tempdatarow['amt'] = $computeddata['amt'];
                                  break;

                                  default:
                                    $tempdatarow[$key2] = $value2;
                                  break;
                                }//end swith
                            }//end for each 2
                            
                            if(isset($tempdata[$liner])){
                              $tempdata[($liner + 1)] = $tempdatarow;
                            }else{
                              $tempdata[$liner] = $tempdatarow;
                            }//end if

                            $liner += 1;
                          }//end if
                        }//end for
                    }else{
                      Log::writelog($doc,$head->trno,'OUT OF STOCK','['.$value['barcode'].'] [SO Line: '.$value['linex'].']',Yii::$app->session['loggeduser']['username']); 
                    }//end if else
                  }//end if
              break;
            }//end switch
          }//end for each

        }//END IF


       foreach ($tempdata as $key => $value) {
          $moduledata["barcode"]= $value['barcode'];
          $moduledata["itemname"]= $value['itemname'];
          $moduledata["itemid"]= $value['itemid'];
          $moduledata["uom"]= $value['uom'];
          $moduledata["uomfactor"]= $value['uomfactor'];
          $moduledata["isamt"]= $value['isamt'];
          $moduledata["ext"]= $value['ext'];
          $moduledata["disc"]= $value['disc'];
          $moduledata["rem"]= $value['rem'];
          $moduledata["iss"]= $value['iss'];
          $moduledata["isqty"]= $value['isqty'];
          $moduledata["amt"]= $value['amt'];
          $moduledata["whcode"]= $value['wh'];
          $moduledata["whname"]= $value['whname'];
          $moduledata["loc"]= $value['loc'];
          $moduledata["expiry"]= $value['expiry'];
          $moduledata["trno"]= $value['trno'];
          $moduledata["line"]= 0;
          $moduledata["refx"]= $value['refx'];
          $moduledata["linex"]= $value['linex'];
          $moduledata["ref"]= $value['docno'];

          $returndata = Yii::$app->webprocess->savingstock($controller,$controller->access['save'],$moduledata);
        }//end for each
        
        return array('trno' => $trno, 'docno'=> $newdocno,'msg'=>$message,'type'=>'new','head'=>$data);
    }//end fn

    public function generateDateparam($params){
      if(isset($params['type'])){
        $type = $params['type'];
      }else{
        $type = 'CURRENT';
      }//end if

      if($type == 'LESS_X'){
        if(isset($params['counter'])){
          $counter = $params['counter'];
        }else{
          $counter = 0;
        }//end if
      }else{
        $counter = 0;
      }//end if

      switch ($type) {
        case 'LESS_X':
          $current = date("Y-m-d");
          $date = strtotime($current .' -'.$counter.' months');
          $date = date('Y-m-d', $date);
        break;
        
        default:
          $date = date("Y-m-d");
        break;
      }//END SWITCH


      return $date;
    }//end fn


        public function loadAccountdetails($controller,$access,$params){
          

          $qry = "select 1 as prio,'UNPOSTED' as `status`,head.trno, left(head.dateid,10) as dateid, head.doc,head.docno,
                  head.client as hclient,
                  head.clientname as hclientname, head.rem as hrem,detail.line, detail.acno,detail.acnoname, 
                  detail.db,detail.cr,coa.alias,detail.ref as dref, detail.client as dclient, detail.rem as drem, 
                  detail.checkno,coa.acnoid
                  from lahead as head
                  left join ladetail as detail on detail.trno = head.trno
                  left join coa on coa.acno = detail.acno
                  left join cntnum on cntnum.trno = head.trno
                  where coa.acnoid = ".$params['x']." and head.dateid >= '".$params['date']."' 
                  and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  UNION ALL
                  select 2 as prio,'POSTED' as `status`,head.trno,left(head.dateid,10) as dateid, head.doc,head.docno,
                  hclient.client as hclient, 
                  head.clientname as hclientname, head.rem as hrem,detail.line,coa.acno,detail.acnoname, 
                  detail.db,detail.cr,coa.alias, detail.ref as dref,dclient.client as dclient,detail.rem as drem, 
                  detail.checkno,coa.acnoid
                  from glhead as head
                  left join gldetail as detail on detail.trno = head.trno
                  left join client as hclient on hclient.clientid = head.clientid
                  left join client as dclient on dclient.clientid = detail.clientid
                  left join coa on coa.acnoid = detail.acnoid
                  left join cntnum on cntnum.trno = head.trno
                  where coa.acnoid = ".$params['x']." and head.dateid >= '".$params['date']."' 
                  and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'";

          return $qry;

        }//kim end

      public function loadLinCollect(){ //QUERY FOR COLLECTION
        return "select  yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                select year(head.dateid) as yr,
                ifnull(sum(case when month(head.dateid)=1 then (detail.db-detail.cr) else 0 end),'') as mojan,
                ifnull(sum(case when month(head.dateid)=2 then (detail.db-detail.cr) else 0 end),'') as mofeb,
                ifnull(sum(case when month(head.dateid)=3 then (detail.db-detail.cr) else 0 end),'') as momar,
                ifnull(sum(case when month(head.dateid)=4 then (detail.db-detail.cr) else 0 end),'') as moapr,
                ifnull(sum(case when month(head.dateid)=5 then (detail.db-detail.cr) else 0 end),'') as momay,
                ifnull(sum(case when month(head.dateid)=6 then (detail.db-detail.cr) else 0 end),'') as mojun,
                ifnull(sum(case when month(head.dateid)=7 then (detail.db-detail.cr) else 0 end),'') as mojul,
                ifnull(sum(case when month(head.dateid)=8 then (detail.db-detail.cr) else 0 end),'') as moaug,
                ifnull(sum(case when month(head.dateid)=9 then (detail.db-detail.cr) else 0 end),'') as mosep,
                ifnull(sum(case when month(head.dateid)=10 then (detail.db-detail.cr) else 0 end),'') as mooct,
                ifnull(sum(case when month(head.dateid)=11 then (detail.db-detail.cr) else 0 end),'') as monov,
                ifnull(sum(case when month(head.dateid)=12 then (detail.db-detail.cr) else 0 end),'') as modec
                from lahead as head
                left join ladetail as detail on head.trno=detail.trno
                left join coa on detail.acno=coa.acno where left(coa.alias,2) in ('CA','CR') and head.doc='CR' and year(head.dateid)=year(now())
                group by year(head.dateid)
                union all
                select year(head.dateid) as yr,
                ifnull(sum(case when month(head.dateid)=1 then (detail.db-detail.cr) else 0 end),'') as mojan,
                ifnull(sum(case when month(head.dateid)=2 then (detail.db-detail.cr) else 0 end),'') as mofeb,
                ifnull(sum(case when month(head.dateid)=3 then (detail.db-detail.cr) else 0 end),'') as momar,
                ifnull(sum(case when month(head.dateid)=4 then (detail.db-detail.cr) else 0 end),'') as moapr,
                ifnull(sum(case when month(head.dateid)=5 then (detail.db-detail.cr) else 0 end),'') as momay,
                ifnull(sum(case when month(head.dateid)=6 then (detail.db-detail.cr) else 0 end),'') as mojun,
                ifnull(sum(case when month(head.dateid)=7 then (detail.db-detail.cr) else 0 end),'') as mojul,
                ifnull(sum(case when month(head.dateid)=8 then (detail.db-detail.cr) else 0 end),'') as moaug,
                ifnull(sum(case when month(head.dateid)=9 then (detail.db-detail.cr) else 0 end),'') as mosep,
                ifnull(sum(case when month(head.dateid)=10 then (detail.db-detail.cr) else 0 end),'') as mooct,
                ifnull(sum(case when month(head.dateid)=11 then (detail.db-detail.cr) else 0 end),'') as monov,
                ifnull(sum(case when month(head.dateid)=12 then (detail.db-detail.cr) else 0 end),'') as modec
                from glhead as head
                left join gldetail as detail on head.trno=detail.trno
                left join coa on detail.acnoid=coa.acnoid where left(coa.alias,2) in ('CA','CR') and head.doc='CR' and year(head.dateid)=year(now())
                group by year(head.dateid)
                ) as x group by yr order by yr";
      }
  
      public function loadLinExpns(){
        return "select  yr, sum(mojan) as mojan, sum(mofeb) as mofeb, sum(momar) as momar,
                sum(moapr) as moapr, sum(momay) as momay, sum(mojun) as mojun, sum(mojul) as mojul, sum(moaug) as moaug,
                sum(mosep) as mosep, sum(mooct) as mooct, sum(monov) as monov, sum(modec) as modec from (
                select year(head.dateid) as yr,
                ifnull(sum(case when month(head.dateid)=1 then (detail.db - detail.cr) else 0 end),'') as mojan,
                ifnull(sum(case when month(head.dateid)=2 then (detail.db - detail.cr) else 0 end),'') as mofeb,
                ifnull(sum(case when month(head.dateid)=3 then (detail.db - detail.cr) else 0 end),'') as momar,
                ifnull(sum(case when month(head.dateid)=4 then (detail.db - detail.cr) else 0 end),'') as moapr,
                ifnull(sum(case when month(head.dateid)=5 then (detail.db - detail.cr) else 0 end),'') as momay,
                ifnull(sum(case when month(head.dateid)=6 then (detail.db - detail.cr) else 0 end),'') as mojun,
                ifnull(sum(case when month(head.dateid)=7 then (detail.db - detail.cr) else 0 end),'') as mojul,
                ifnull(sum(case when month(head.dateid)=8 then (detail.db - detail.cr) else 0 end),'') as moaug,
                ifnull(sum(case when month(head.dateid)=9 then (detail.db - detail.cr) else 0 end),'') as mosep,
                ifnull(sum(case when month(head.dateid)=10 then (detail.db - detail.cr) else 0 end),'') as mooct,
                ifnull(sum(case when month(head.dateid)=11 then (detail.db - detail.cr) else 0 end),'') as monov,
                ifnull(sum(case when month(head.dateid)=12 then (detail.db - detail.cr) else 0 end),'') as modec
                from lahead as head
                left join ladetail as detail on head.trno=detail.trno
                left join coa on detail.acno=coa.acno where coa.cat='E' and head.doc in ('PV','CV') and year(head.dateid)=year(now())
                group by year(head.dateid)
                union all
                select year(head.dateid) as yr,
                ifnull(sum(case when month(head.dateid)=1 then (detail.db - detail.cr) else 0 end),'') as mojan,
                ifnull(sum(case when month(head.dateid)=2 then (detail.db - detail.cr) else 0 end),'') as mofeb,
                ifnull(sum(case when month(head.dateid)=3 then (detail.db - detail.cr) else 0 end),'') as momar,
                ifnull(sum(case when month(head.dateid)=4 then (detail.db - detail.cr) else 0 end),'') as moapr,
                ifnull(sum(case when month(head.dateid)=5 then (detail.db - detail.cr) else 0 end),'') as momay,
                ifnull(sum(case when month(head.dateid)=6 then (detail.db - detail.cr) else 0 end),'') as mojun,
                ifnull(sum(case when month(head.dateid)=7 then (detail.db - detail.cr) else 0 end),'') as mojul,
                ifnull(sum(case when month(head.dateid)=8 then (detail.db - detail.cr) else 0 end),'') as moaug,
                ifnull(sum(case when month(head.dateid)=9 then (detail.db - detail.cr) else 0 end),'') as mosep,
                ifnull(sum(case when month(head.dateid)=10 then (detail.db - detail.cr) else 0 end),'') as mooct,
                ifnull(sum(case when month(head.dateid)=11 then (detail.db - detail.cr) else 0 end),'') as monov,
                ifnull(sum(case when month(head.dateid)=12 then (detail.db - detail.cr) else 0 end),'') as modec
                from glhead as head
                left join gldetail as detail on head.trno=detail.trno
                left join coa on detail.acnoid=coa.acnoid where coa.cat='E' and head.doc in ('PV','CV') and year(head.dateid)=year(now())
                group by year(head.dateid)
                ) as x group by yr order by yr";
      }
      public function panda_appendItemname($barcode,$itemname){
        $query = "select ifnull(mm.model_name,'') as model,item.brand,item.sizeid from item
        left join model_masterfile as mm on mm.model_id = item.model
        where item.barcode='".$barcode ."'";
        
        $temp = Yii::$app->sbccommon->opentable($query);
        
        $str = '';
        
        if(!empty($temp)){
          if($temp[0]['brand'] != ''){
            $brand = ''.$temp[0]['brand'].' ';
            $itemname = $brand.$itemname;
          }//end if

          if($temp[0]['model'] != ''){
            $model = ' '.$temp[0]['model'].'';
            $itemname = $itemname.$model;
          }//end if

          if($temp[0]['sizeid'] != ''){
            $size = ' '.$temp[0]['sizeid'].'';
            $itemname = $itemname.$size;
          }//end if
        }//end if

        return $itemname;
      }//end if

      public function king_VerifyBranch($key){
        //exclusive function for king george
        //to verify what branch is logged in
        switch ($key) {
          case md5(1):
            $branchname = "Housegem Construction";
          break;

          case md5(2):
            $branchname = "Iba Stalh";
          break;

          case md5(3):
            $branchname = "Century Ply";
          break;

          case md5(4):
            $branchname = "Royalturn";
          break;

          case md5(5):
            $branchname = "Tomjens Rise";
          break;

          case md5(6):
            $branchname = "Taita Falcon";
          break;

          case md5(7):
            $branchname = "Temple Win";
          break;

          case md5(8):
            $branchname = "Tom Towers";
          break;

          case md5(9):
            $branchname = "T4triump";
          break;
          
          case md5(10):
            $branchname = "Tonbridge Steel";
          break;
        }//end switch

        return ['king_branchname'=>$branchname,'king_branch'=>$key];
      }//end if

      public function POSPrint($type,$string = []){
        switch ($type) {
            case 'multicol':
                $stringfull = "";
                $arrcount = count($string);

                for ($i=1; $i <= $arrcount; $i++) { 
                    $diff = floatval($string['col'.$i]['len']) - floatval(strlen($string['col'.$i]['txt']));
                    if(abs($diff) != 0){
                        if($i == $arrcount || $i == $arrcount-1){
                          for ($x=0; $x < abs($diff); $x++) { 
                              $string['col'.$i]['txt'] = " " . $string['col'.$i]['txt'];
                          }//end for loop
                        }else{
                          for ($x=0; $x < abs($diff); $x++) { 
                              $string['col'.$i]['txt'] .= " ";
                          }//end for loop
                        }//end if
                    }//end if
                }//end for

                for ($i=1; $i <= $arrcount; $i++) { 
                    $stringfull .= $string['col'.$i]['txt'];
                }//end for

                return $stringfull;
            break;

            case 'col-2':
            //col1 = 0-19
            //col2 = 20-40
            $col1 = $string['col1'];
            $col2 = $string['col2'];
            $string1 = $col1;
            $string2 = $col2;

            //FOR COLUMN 1
            $strlen = strlen($col1);
            $diff = floatval(22) - floatval($strlen);

            if($diff > 0){
                //IF POSITIVE (remaining spaces / didnt occupy all spaces)
                for ($i=0; $i < $diff; $i++) { 
                    $string1 .= " ";
                }//end for loop
            }else{
                //IF NEGATIVE / ZERO (occupied all spaces / string exceeds max length)
                $string1 = substr($col1, 0,22);
            }//end if

            //FOR COLUMN 2
            $strlen = strlen($col2);
            $diff = floatval(18) - floatval($strlen);

            if($diff > 0){
                //IF POSITIVE (remaining spaces / didnt occupy all spaces)
                for ($i=0; $i < $diff; $i++) { 
                    $string2 = " ".$string2;
                }//end for loop
            }else{
                //IF NEGATIVE / ZERO (occupied all spaces / string exceeds max length)
                $string2 = substr($col1, 0,18);
            }//end if

            return $string1 . $string2;
            break;

            case 'newline':
                $string = "\n";
            break;

            case 'linebreaker':
                $string = "----------------------------------------";
            break;

            default:
                if(strlen($string) <= 40){
                    $string = $string;
                }else{
                    $string = substr($string,40);
                }//end if
            break;
        }//end switch

        return $string;
      }//end f

      public function searchPriority($controller,$access,$searchstring) {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          switch($controller->module->id) {
            case 'stockcard': case 'reportlist': case 'posstockcard': 
              if($searchstring == ""){
                $qry = "select distinct uv_priority as priority from item order by uv_priority asc";
              }else{
                $qry = "select distinct uv_priority as priority from item where uv_priority like '%".$searchstring."%' order by uv_priority asc";
              }//end function
            break;
         }
          return $qry;
        }
      }//end f


      public function searchDepartment($controller,$access,$searchstring) {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          switch($controller->module->id) {
            case 'stockcard': case 'reportlist': case 'posstockcard': 
              if($searchstring == ""){
                $qry = "select distinct uv_department as department from item order by uv_department asc";
              }else{
                $qry = "select distinct uv_department as department from item where uv_department like '%".$searchstring."%' order by uv_department asc";
              }//end function
            break;
         }
          return $qry;
        }
      }//end f

      public function searchSuppItemCode($controller,$access,$searchstring) {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          switch($controller->module->id) {
            case 'stockcard': case 'reportlist': case 'posstockcard': 
              if($searchstring == ""){
                $qry = "select distinct uv_suppitemcode as suppitemcode from item order by uv_suppitemcode asc";
              }else{
                $qry = "select distinct uv_suppitemcode as suppitemcode from item where uv_suppitemcode like '%".$searchstring."%' order by uv_suppitemcode asc";
              }//end function
            break;
         }
          return $qry;
        }
      }//end f
    
    public function clearDatabase(){
      if(Yii::$app->systemsettings->enableClearDatabase()){
          $qry = "truncate rrstatus;
                    truncate lahead;
                    truncate lastock;
                    truncate ladetail;
                    truncate pohead;
                    truncate postock;
                    truncate hpohead;
                    truncate hpostock;
                    truncate sohead;
                    truncate krhead;
                    truncate hkrhead;
                    truncate sostock;
                    truncate hsohead;
                    truncate hsostock;
                    truncate pchead;
                    truncate pcstock;
                    truncate hpchead;
                    truncate hpcstock;
                    truncate prhead;
                    truncate prstock;
                    truncate hprhead;
                    truncate hprstock;
                    truncate pihead;
                    truncate pistock;
                    truncate hpihead;
                    truncate hpistock;
                    truncate pdhead;
                    truncate pdstock;
                    truncate hpdhead;
                    truncate hpdstock;
                    truncate arledger;
                    truncate apledger;
                    truncate crledger;
                    truncate caledger;
                    truncate nonledger;
                    truncate transnum;
                    truncate cntnum;
                    truncate glhead;
                    truncate glstock;
                    truncate gldetail;
                    truncate krhead;
                    truncate costing;
                    truncate payment;
                    truncate gjhead;
                    truncate gjdetail;
                    truncate payment;
                    truncate itimages;
                    truncate uom;
                    truncate client;
                    truncate item;
                    truncate table_log;
                    truncate transnum_log;
                    truncate del_item_log;
                    truncate del_table_log;
                    truncate del_transnum_log;
                    truncate frontend_logs;
                    truncate item_log;
                    truncate member_schedule;
                    truncate sched_allowedcustomer;
                    truncate company_prefixes;
                    truncate scheduler_anon;
                    truncate member_schedule;
                    truncate schedule_notes;
                    truncate notes_comments;
                    truncate event_comments;
                    truncate member_notification;
                    truncate member_timein;
                    truncate sched_allowedcustomer;
                    truncate sched_alloweduser;
                    truncate sched_projects;
                    truncate schedule_logs;
                    truncate scheduler_reminder;
                    truncate frontend_categories;
                    truncate frontend_images;
                    truncate frontend_logs;
                    truncate frontend_subcategories;
                    truncate frontend_lanetree;
                    truncate frontend_laneslider;
                    truncate frontend_lanes;
                    truncate frontend_laneitems;
                    truncate frontend_itemviews;
                    truncate frontend_catbanner;
                    truncate frontend_brbanner;
                    truncate frontend_banner;
                    truncate frontend_addressbook;
                    truncate item_gallery;
                    truncate execution_log;
                    truncate taxhead;
                    truncate taxdetail;
                    truncate htaxhead;
                    truncate htaxdetail;
                    truncate taxnum;
                    truncate taxmenu;
                    truncate item_class;
                    truncate distribution_area;
                    truncate collection_area;
                    truncate category_masterfile;
                    truncate stype;
                    truncate trhead;
                    truncate trstock;
                    truncate htrhead;
                    truncate htrstock;
                    truncate frontend_fdealitems;
                    truncate frontend_flashdeal;
                    truncate frontend_dod;
                    truncate frontend_doditems;
                    truncate frontend_highlights;
                    truncate frontend_highlightitems;
                    truncate postdatedchecks;
                    truncate hpostdatedchecks;
                    truncate sbc_so_attachments;
                    truncate sbc_so_notes;
                    truncate route_masterfile;
                    truncate tblcart;
                    truncate tblcarthistory;
                    truncate androidpayments;
                    truncate hrfhead;
                    truncate rfhead;
                    truncate spstock;
                    truncate hspstock;
                    truncate scterritory;
                    truncate sccity;
                    truncate scprovince;
                    truncate status_masterfile;
                    truncate commission_masterfile;
                    truncate stockgrp_masterfile;
                    truncate city_masterfile;
                    truncate androidpayments;
                    truncate class_masterfile;
                    truncate model_masterfile;
                    truncate part_masterfile;
                    truncate maingrp;
                    truncate termgrp;
                    truncate catgrp;
                    truncate subcatgrp;
                    truncate itemamthistory;
                    truncate frontend_ebrands;
                    truncate bptrans;
                    truncate jbhead;
                    truncate jbstock;
                    truncate hjbhead;
                    truncate hjbstock;
                    truncate fgi_colors;
                    truncate fgi_material;
                    truncate fgi_process;
                    truncate fgi_cylinder;
                    truncate fg_colors;
                    truncate fg_material;
                    truncate fg_process;
                    truncate jb_processtab;
                    truncate fg_input;
                    truncate fg_output;
                    truncate fg_reject;
                    truncate fg_processstat;
                    truncate itemdlock;
                    truncate prodtype_masterfile;
                    truncate transform_masterfile;
                    truncate sealing_masterfile;
                    truncate plastic_masterfile;
                    truncate prodspec_masterfile;
                    truncate reject_masterfile;
                    truncate inout_masterfile;
                    truncate jbu_processinputtab;
                    truncate jbu_processoutputtab;
                    truncate jbu_processrejecttab;
                    truncate jbu_processinktab;
                    truncate jbu_processinktab;";
                    
        $status = Yii::$app->sbccommon->execqry($qry);
        return $status;
      }else{
        return 0;
      }//end if
    }//end f

    public function invoicedata() {
      return "select tp.cutoff,tp.line, tp.trno, tp.docno, tp.customer_code as client,
              tp.customer_name as clientname,
              tp.agent,tp.shipfee,cntnum.postdate from tp_shippingfees as tp
              left join cntnum on cntnum.trno=tp.trno";
    }//end if


    public function invoicehandling() {
      return "select tp.cutoff,tp.line, tp.trno, tp.docno, tp.customer_code as client,
              tp.customer_name as clientname,
              tp.agent,tp.handlingfee,cntnum.postdate from tp_handlingfees as tp
              left join cntnum on cntnum.trno=tp.trno";
    }//end if


    public function pullHeaderhandling($trno){
      $query = "select head.trno, head.docno, client.client, client.clientname,0 as handlingfee,'' as cutoff,agent.client as agent
                from cntnum
                left join glhead as head on cntnum.trno = head.trno
                left join client on head.clientid = client.clientid
                left join client as agent on head.agentid = client.clientid
                where cntnum.trno = '".$trno."' and cntnum.shandling = 0";

      $data = Yii::$app->sbccommon->opentable($query);
      return $data;
    }//end if    

    public function pullHeaderdata($trno){
      $query = "select head.trno, head.docno, client.client, client.clientname,0 as shipfee,'' as cutoff,agent.client as agent
                from cntnum
                left join glhead as head on cntnum.trno = head.trno
                left join client on head.clientid = client.clientid
                left join client as agent on head.agentid = client.clientid
                where cntnum.trno = '".$trno."' and cntnum.sbill = 0";

      $data = Yii::$app->sbccommon->opentable($query);
      return $data;
    }//end if

    public function searchMenu($controller,$access) {
      // var_dump($controller->module->id);
      // return 0;
      if($controller->module->id == 'changeitem') {
        return "select '' as groupid 
                UNION ALL
                select distinct groupid from item order by groupid";
      } else {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          if($controller->module->id == 'stockcard' || $controller->module->id == 'manageitem' || $controller->module->id == 'posstockcard'){
            return "select 0 as menuid , '' as menuname
                    UNION ALL
                    select itemid as menuid,itemname as menuname from item";
          } else {
            return "select '' as groupid 
                    UNION ALL
                    select distinct groupid from client order by groupid";
          }
        }
      }
    }//end f

    public function getunf($itemid){
      $qry='select uom,uom2,uom3,uom4,uom5,uom6,factor1,factor2,factor3,factor4,factor5,factor6 from item where itemid='.$itemid.'';
      $data = Yii::$app->sbccommon->opentable($qry);
      return $data;
    }//end f

    public function searchComputeunposted($controller,$access,$itemid,$date,$uom,$wh) {
        // var_dump(Yii::$app->session['loggeduser']['access'][$access]);
        // return 0;
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        $query = "";
        return $query;
      }
    }//end f

    public function searchComputesupplier($controller,$access,$itemid,$date,$uom,$wh) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1){

      }else{
        $query = "select client.client, rrstatus.trno, rrstatus.line, client.clientname, 
                  round(rrstatus.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
                  round((rrstatus.qty / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
                  cast((case when rrstatus.bal=0 then 'applied' else round((rrstatus.bal / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") end) as char(50)) as status,left(rrstatus.dateid,10) as dateid, rrstatus.whid, rrstatus.uom, rrstatus.disc, rrstatus.docno, rrstatus.loc,rrstatus.expiry,rrstatus.isimport,stock.rem 
                  from rrstatus 
                  left join client on client.clientid=rrstatus.clientid 
                  left join client as wh on wh.clientid=rrstatus.whid
                  left join item on item.itemid=rrstatus.itemid 
                  left join uom on uom.itemid=rrstatus.itemid and uom.uom='".$uom."'
                  left join cntnum on cntnum.trno=rrstatus.trno
                  left join glstock as stock on stock.trno = rrstatus.trno and stock.line = rrstatus.line
                  where rrstatus.itemid=".$itemid." and wh.clientname='".$wh."' 
                  group by rrstatus.trno,rrstatus.line
                  order by rrstatus.dateid desc";
        // echo $query;
        // return 0;
        return $query;
      }
    }//end f

    public function searchComputecomponents($controller,$access,$itemid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } 
      else 
      {
        $center=Yii::$app->session['loggeduser']['center'];
        // var_dump($center);
        // return 0;
        $query = "select itemid,line, barcode, itemname, isqty, uom 
                  from component where itemid='".$itemid."'";
        // echo($query);
        // return 0;
        return $query;
      }
    }//end f

    public function searchComputepacking($controller,$access,$itemid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select pack.packaging, item.amt, pack.disc
                  from packingdisc as pack
                  left join item on item.itemid=pack.itemid
                  order by pack.packaging";
        return $query;
      }//end if
    }//end f

    public function searchTables($access,$clientid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      }else{
        return "select line, clientid, client, clientname, inactive as isinactive,dlock from branchtables";
      }//end if
    }//end f

    public function getSetchoices($access,$itemid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select line, choices, itemid, qty from setmenu where itemid = $itemid";
      }
    }//end f

    public function getComponentitems($access,$itemid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      }else{
        return "select line, itemid, barcode, itemname, isqty, qty, uom, uomfactor from component where itemid = $itemid";
      }//end if
    }//end f`

    public function getSetmenuchoices($access,$itemid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {

        return "select m.choices, m.qty, item.itemname, m.line, item.itemid from setmenu as m
         left join item on m.itemid = item.itemid where item.itemid = $itemid";
      }
    }//end f

    public function getSetmenuchoicesmenu($access,$itemid,$choices,$menuid) {

      if($choices!=''){
        $filter="and choices ='".$choices."'";
      }else{
        $filter='';
      }
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
          return "select setmenuchoices.line,item.barcode,item.itemname from setmenuchoices
          left join item on item.itemid=setmenuchoices.itemid
          where setmenuid=$menuid $filter";
      }
    }//end f

    public function getManageitems() {
      return "select item.itemid,item.barcode, cat.cl_name as category, grp.stockgrp_name as groupings, 
        item.kds, item.itemname, round(item.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt from item
        left join part_masterfile as part on part.part_id = item.part 
        left join item_class as cat on cat.cl_id = item.class
        left join stockgrp_masterfile as grp on grp.stockgrp_id = item.groupid
        where part.part_name = 'menu'";
    }//end f

    public function getStockcardDatafield($itemid,$field){
      $qry = "select ".$field." from item where itemid = ". $itemid;
      return Yii::$app->sbccommon->datareader($qry);
    }//end funtion

    public function getTables() {
        return "select clientid, client, clientname, floor, isinactive from client where istable = 1";
    }//END FUNC
      


  public function loadTransg1(){
    return "select distinct case(doc) when 'PR' then 'PURCHASE REQUISITION'
                                              when 'PO' then 'PURCHASE ORDER'
                                              when 'RR' then 'RECEIVING REPORT'
                                              when 'DM' then 'PURCHASE RETURN'
                                              when 'SO' then 'SALES ORDER'
                                              when 'SJ' then 'SALES JOURNAL'
                                              when 'CM' then 'SALES RETURN'
                                              when 'IS' then 'INVENTORY SETUP'
                                              when 'PC' then 'PHYSICAL COUNT'
                                              when 'TS' then 'TRANSFER SLIP'
                                              when 'AJ' then 'INVENTORY ADJUSTMENT'
                                              when 'GJ' then 'GENERAL JOURNAL'
                                              when 'DS' then 'DEPOSIT SLIP'
                                              when 'AR' then 'AR SETUP'
                                              when 'CR' then 'RECEIVED PAYMENT'
                                              when 'KR' then 'COUNTER RECEIPT'
                                              when 'AP' then 'AP SETUP'
                                              when 'PV' then 'AP VOUCHER'
                                              when 'CV' then 'CASH/CHECK VOUCHER'
                                              when 'MI' then 'MATERIAL ISSUANCE'
                                              when 'SI' then 'SALES INVOICE'
                                              else '' end as doc,
                count(trno) as counts, trno, doc as doc2
                    from(
                        select head.trno,head.dateid,head.clientname as customername,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from pohead as head
                        UNION ALL
                        select head.trno,head.dateid,head.clientname as customername,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from hpohead as head
                        UNION ALL
                        select head.trno,head.dateid,head.clientname as customername,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from lahead as head
                        UNION ALL
                        select head.trno,head.dateid,head.clientname as customername,head.doc as doc ,
                        head.dateid as datex , head.docno as docno from glhead as head

                        ) as countx
                        where month(date(dateid))=month(date(now())) and year(date(dateid))=year(date(now()))
                        group by doc
                        order by doc";
  }
  public function loadTransg2($doc){
    switch ($doc) {
           case 'PR': case 'PO': case 'SO': case 'PC': case 'KR':
                return "
                  select head.doc,date(head.dateid) as dateid,head.trno,head.docno as doc2, clientname,cnt.name as centername,'data' as type,'POSTED' as trans,'2' as ordtype
                  from hpohead as head
                  left join cntnum on head.trno=cntnum.trno
                  left join center as cnt on cntnum.center=cnt.code
                  where head.doc='".$doc."' and month(date(head.dateid))=month(date(now()))
                  and year(date(head.dateid))=year(date(now()))
                  union all
                  select head.doc,date(head.dateid) as dateid,head.trno,head.docno as doc2, clientname,cnt.name as centername,'data' as type,'UNPOSTED' as trans,'2' as ordtype
                  from pohead as head
                  left join cntnum on head.trno=cntnum.trno
                  left join center as cnt on cntnum.center=cnt.code
                  where head.doc='".$doc."' and month(date(head.dateid))=month(date(now()))
                  and year(date(head.dateid))=year(date(now()))
                  order by dateid desc";
            break;

            default:
                return "
                  select head.doc,date(head.dateid) as dateid,head.trno,head.docno as doc2, clientname,cnt.name as centername,'data' as type,'POSTED' as trans,'2' as ordtype
                  from glhead as head
                  left join cntnum on head.trno=cntnum.trno
                  left join center as cnt on cntnum.center=cnt.code
                  where head.doc='".$doc."' and month(date(head.dateid))=month(date(now()))
                  and year(date(head.dateid))=year(date(now()))
                  union all
                  select head.doc,date(head.dateid) as dateid,head.trno,head.docno as doc2, clientname,cnt.name as centername,'data' as type,'UNPOSTED' as trans,'2' as ordtype
                  from lahead as head
                  left join cntnum on head.trno=cntnum.trno
                  left join center as cnt on cntnum.center=cnt.code
                  where head.doc='".$doc."' and month(date(head.dateid))=month(date(now()))
                  and year(date(head.dateid))=year(date(now())) 
                  order by dateid desc";
            break;
        }
  } 

  public function loadSchedg1(){

    return "select useraccess.username,useraccess.userid, member_schedule.sched_type, member_schedule.event_tagging
            from member_schedule
            left join useraccess on useraccess.userid = member_schedule.userid
            where (date(member_schedule.date1))=(date(now())) and year(date(member_schedule.date1))=year(date(now()))
            group by useraccess.userid";
  }
  
    public function loadSchedg2($params){
    $schedfilter = "";
    $userfilter = "";
    if($params['event_tagging'] != "")
    {
        switch ($params['event_tagging']) 
        {
          case 'UNPLOTTED':
            $schedfilter = $schedfilter."and isplotted = 0 ";
          break;
          default:
            $schedfilter = $schedfilter."and event_tagging = '".$params['event_tagging']."' ";
          break;
        }//end switch
    }//end if

    if(!empty($params['username']))
    {
        $userfilter = "and member_schedule.userid ='".$params['username']."' ";
        if($params['sched_type'] != "")
        {
          $schedfilter = " and sched_type='" . $params['sched_type']."' ";
        }//end if
        
        return "select uacc.username,uacc.name,client.clientname,sched_id,sched_type,sched_desc,date1,date2,isplotted,
        sched_seq,date(member_schedule.createdate) as createdate,member_schedule.event_tagging from member_schedule
        left join client on client.clientid = member_schedule.clientid
        left join useraccess as uacc on uacc.userid = member_schedule.userid
        where sched_seq <> '' and (date(member_schedule.date1))=(date(now())) and year(date(member_schedule.date1))=year(date(now())) ".$schedfilter." ".$userfilter." order by member_schedule.date1";
    }
    
      
  }

    public function totalusers(){
     return "select count(username) as count from(
      select useraccess.username,useraccess.userid, member_schedule.sched_type, member_schedule.event_tagging
            from member_schedule
            left join useraccess on useraccess.userid = member_schedule.userid
            where (date(member_schedule.date1))=(date(now())) and year(date(member_schedule.date1))=year(date(now()))
            group by useraccess.userid) as a"; 
  }

     public function loadUnpostedg2($doc){
      switch ($doc) {
              case 'PR':
                  return "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                  left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from prhead as head
                  left join transnum on transnum.trno = head.trno
                  left join center on center.code = transnum.center
                  order by dateid asc";
              break;

              case 'PO':
                  return "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                  left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from pohead as head
                  left join transnum on transnum.trno = head.trno
                  left join center on center.code = transnum.center
                  where head.doc='$doc' 
                  order by dateid asc";
              break;

              case 'SO':
                  return "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                  left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from sohead as head
                  left join transnum on transnum.trno = head.trno
                  left join center on center.code = transnum.center
                  where head.doc='$doc' 
                  order by dateid asc";
              break;

              case 'PC':
                  return "select center.name as centername,transnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                  left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from pchead as head
                  left join transnum on transnum.trno = head.trno
                  left join center on center.code = transnum.center
                  where head.doc='$doc' 
                  order by dateid asc";
              break;
              
              default:
                  return "select center.name as centername,cntnum.center,head.trno,head.clientname as clientname,head.client,head.doc as doc ,
                  left(head.dateid,10) as dateid , head.docno as docno  , 'UNPOSTED' as status from lahead as head
                  left join cntnum on cntnum.trno = head.trno
                  left join center on center.code = cntnum.center
                  where head.doc='$doc'
                  order by dateid asc";
              break;
          }
    }
    public function loadUnpostedg1(){
    return "select distinct case(doc) when 'PR' then 'PURCHASE REQUISITION'
                                              when 'PO' then 'PURCHASE ORDER'
                                              when 'RR' then 'RECEIVING REPORT'
                                              when 'DM' then 'PURCHASE RETURN'
                                              when 'SO' then 'SALES ORDER'
                                              when 'SJ' then 'SALES JOURNAL'
                                              when 'CM' then 'SALES RETURN'
                                              when 'IS' then 'INVENTORY SETUP'
                                              when 'PC' then 'PHYSICAL COUNT'
                                              when 'TS' then 'TRANSFER SLIP'
                                              when 'AJ' then 'INVENTORY ADJUSTMENT'
                                              when 'GJ' then 'GENERAL JOURNAL'
                                              when 'DS' then 'DEPOSIT SLIP'
                                              when 'AR' then 'AR SETUP'
                                              when 'CR' then 'RECEIVED PAYMENT'
                                              when 'KR' then 'COUNTER RECEIPT'
                                              when 'AP' then 'AP SETUP'
                                              when 'PV' then 'AP VOUCHER'
                                              when 'CV' then 'CASH/CHECK VOUCHER'
                                              when 'MI' then 'MATERIAL ISSUANCE'
                                              when 'SI' then 'SALES INVOICE'
                                              else '' end as doc,
                count(trno) as counts, trno, doc as doc2
                    from(
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
                        head.dateid as datex , head.docno as docno from lahead as head) as countx group by doc
                    order by doc";
  }

    private function listcenter(){
      $qry="select code as bcode,name from center order by bcode";
            return Yii::$app->sbccommon->opentable($qry);
    }//end if

    //NOTE: TRANSFER ALL THIS FUNCTION TO dashboardfuntion.php (components)
    public function getFrontIndexData($type){
        switch ($type) {
          case 'SALES'://sales            
              return $this->TotalSales();
          break;

          case 'PRCHS'://purchases
              return $this->TotalPurchases();  
          break;

          case 'OUTAR'://outstanding AR
            return $this->outstandingar();  
          break;

          case 'OUTAP'://outstanding AP
              return $this->outstandingap();  
          break;

          case 'CYS'://current year sales
              return $this->cysales();
          break;

          case 'LYS'://last year sales
              return $this->lysales();
          break;

          case 'LLYS'://last year sales
              return $this->llysales();
          break;

          case 'EXPNS':
            $data = $this->listexpns();
            return $data;
          break;

          case 'COLLECT':
            $data = $this->listcollections();
            return $data;
          break;

          case 'SLS':
            $data = $this->listsales();
            return $data;
          break;

          case 'UNP':
            $data = $this->listunpaid();
            return $data;
          break;

          case 'SLSPER':
            $data = $this->listsalesper();
            return $data;
          break; 
          
          case 'SLSPER_LLS':
            $data = $this->listsalesper_lls();
            return $data;
          break; 

          case 'SLSPER_LS':
            $data = $this->listsalesper_ls();
            return $data;
          break;

          case 'LTS'://List total SJ
            $data = $this->listotalsj();
              return $data;
          break;

          case 'PAIDAR'://List paid AR
            $data = $this->listpaidar();
              return $data;
          break;

          case 'PAIDAP'://List paid AP
            $data = $this->listpaidap();
              return $data;
          break;

          case 'UNPOSTRR'://List UNPOSTED RR
            $data = $this->listunpostedrr();
              return $data;
          break;

          case 'UNPOSTSJ'://List UNPOSTED SJ
            $data = $this->listunpostedsj();
              return $data;
          break;

          case 'ALLAR'://List UNPOSTED SJ
            $data = $this->listallar();
              return $data;
          break;

          case 'ALLAP'://List UNPOSTED SJ
            $data = $this->listallap();
              return $data;
          break;

          case 'CNTR':
            $data = $this->listcenter();
            return $data;
          break;
        }//end switch
    }//end function

    private function listunpaid(){
      $qry="select center.code, center.name, sum(round(ar.bal,2)) as amount
            from arledger as ar left join coa on coa.acnoid=ar.acnoid left join cntnum on cntnum.trno=ar.trno
            left join center on center.code=cntnum.center where ar.bal<>0 and ar.dateid<date(now())
            group by center.code, center.name order by center.code";
            return Yii::$app->sbccommon->opentable($qry);
    }

    private function listsales(){
      $qry="select code, name, sum(amount) as amount from (
            select head.docno, ifnull(stock.ext,0) as amount, '' as alias, cntr.code, cntr.name
            from lahead as head left join lastock as stock on head.trno=stock.trno left join cntnum as c on c.trno=head.trno
            left join center as cntr on cntr.code=c.center where head.doc='SJ' and year(head.dateid)=year(now())
            union
            select head.docno, ifnull(detail.cr-detail.db,0) as sales, coa.alias, cntr.code, cntr.name
            from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
            left join cntnum as c on c.trno=head.trno left join center as cntr on cntr.code=c.center
            where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())) as j
            group by code, name";
            return Yii::$app->sbccommon->opentable($qry);
    }
    
     public function listotalsj(){
      $qry="select trno,left(dateid,10) as dateid,docno,client,clientname,
            case status
            when 'Outstanding' then '<span class=\"label label-warning\">Outstanding</span>'
            when 'Unposted' then '<span class=\"label label-danger\">Unposted</span>'
            when 'Paid' then '<span class=\"label label-success\">Paid</span>'
            end as status from(
            select trno,dateid,docno,client,clientname,'Unposted' as status from lahead where doc='SJ'
            UNION ALL
            select head.trno,head.dateid,head.docno,head.clientname,client.client,'Outstanding' as status from glhead as head
            left join client on client.clientid=head.clientid
            left join arledger as arled on arled.trno=head.trno
            where arled.bal<>0
            UNION ALL
            select head.trno,head.dateid,head.docno,head.clientname,client.client,'Paid' as status from glhead as head
            left join client on client.clientid=head.clientid
            left join arledger as arled on arled.trno=head.trno
            where arled.bal=0
            ) as x
            order by status,dateid desc limit 10";
      
      $columns = [
            [
                'name' => 'dateid',
                'label' => 'Date',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'docno',
                'label' => 'Name',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'clientname',
                'label' => 'Name',
                'class' => 'aimslabel col-description'
            ],[
                'name' => 'status',
                'label' => 'Status',
                'class' => 'aimslabel col-description'
            ],
        ];

        $params = [
            'sql' => $qry,
            'tableid' => 'recentsjtrans',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => $columns
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//END FUNCTION

    private function listallar(){
      $qry = "select count(trno) as counter from arledger";
      return Yii::$app->sbccommon->datareader($qry);
    }//end funciton 

    private function listallap(){
      $qry = "select count(trno) as counter from arledger";
      return Yii::$app->sbccommon->datareader($qry);
    }//end funciton 


    private function listpaidar(){
      $qry = "select count(trno) as counter from arledger where bal = 0";
      return Yii::$app->sbccommon->datareader($qry);
    }//end funciton 

    private function listpaidap(){
      $qry = "select count(trno) as counter from apledger where bal = 0";
      return Yii::$app->sbccommon->datareader($qry);
    }//end funciton 

    private function listunpostedrr(){
      $qry = "select count(trno) as counter from cntnum where doc = 'RR' and postdate is null";
      return Yii::$app->sbccommon->datareader($qry);
    }//end funciton 

    private function listunpostedsj(){
      $qry = "select count(trno) as counter from cntnum where doc = 'SJ' and postdate is null";
      return Yii::$app->sbccommon->datareader($qry);
    }//end funciton 

    public function cysales(){
        $qry="select yr, sum(case when mo=1 then sales else 0 end) as mojan, sum(case when mo=2 then sales else 0 end) as mofeb, sum(case when mo=3 then sales else 0 end) as momar,
        sum(case when mo=4 then sales else 0 end) as moapr, sum(case when mo=5 then sales else 0 end) as momay, sum(case when mo=6 then sales else 0 end) as mojun,
        sum(case when mo=7 then sales else 0 end) as mojul, sum(case when mo=8 then sales else 0 end) as moaug, sum(case when mo=9 then sales else 0 end) as mosep,
        sum(case when mo=10 then sales else 0 end) as mooct, sum(case when mo=11 then sales else 0 end) as monov, sum(case when mo=12 then sales else 0 end) as modec
        from (select 'p' as tr, head.docno, year(head.dateid) as yr, month(head.dateid) as mo, ifnull(client.clientname,'') as clientname, ifnull(detail.cr-detail.db,0) as sales, coa.alias
        from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
        where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())
        union all
        select 'p' as tr, head.docno, year(head.dateid) as yr, month(head.dateid) as mo, ifnull(client.clientname,'') as clientname, ifnull(detail.cr-detail.db,0) as sales, coa.alias
        from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
        where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())
        ) as a group by yr order by yr";
        $data = Yii::$app->sbccommon->opentable($qry);
        return $data;
    }//end fnc

    public function lysales(){
        $qry="select yr, sum(case when mo=1 then sales else 0 end) as mojan, sum(case when mo=2 then sales else 0 end) as mofeb, sum(case when mo=3 then sales else 0 end) as momar,
        sum(case when mo=4 then sales else 0 end) as moapr, sum(case when mo=5 then sales else 0 end) as momay, sum(case when mo=6 then sales else 0 end) as mojun,
        sum(case when mo=7 then sales else 0 end) as mojul, sum(case when mo=8 then sales else 0 end) as moaug, sum(case when mo=9 then sales else 0 end) as mosep,
        sum(case when mo=10 then sales else 0 end) as mooct, sum(case when mo=11 then sales else 0 end) as monov, sum(case when mo=12 then sales else 0 end) as modec
        from (select 'p' as tr, head.docno, year(head.dateid) as yr, month(head.dateid) as mo, ifnull(client.clientname,'') as clientname, ifnull(detail.cr-detail.db,0) as sales, coa.alias
        from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
        where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())-1
        union all
        select 'p' as tr, head.docno, year(head.dateid) as yr, month(head.dateid) as mo, ifnull(client.clientname,'') as clientname, ifnull(detail.cr-detail.db,0) as sales, coa.alias
        from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
        where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())-1
        ) as a group by yr order by yr";
        $data = Yii::$app->sbccommon->opentable($qry);
        return $data;
    }//end fnc

    public function llysales(){
        $qry="select yr, sum(case when mo=1 then sales else 0 end) as mojan, sum(case when mo=2 then sales else 0 end) as mofeb, sum(case when mo=3 then sales else 0 end) as momar,
        sum(case when mo=4 then sales else 0 end) as moapr, sum(case when mo=5 then sales else 0 end) as momay, sum(case when mo=6 then sales else 0 end) as mojun,
        sum(case when mo=7 then sales else 0 end) as mojul, sum(case when mo=8 then sales else 0 end) as moaug, sum(case when mo=9 then sales else 0 end) as mosep,
        sum(case when mo=10 then sales else 0 end) as mooct, sum(case when mo=11 then sales else 0 end) as monov, sum(case when mo=12 then sales else 0 end) as modec
        from (select 'p' as tr, head.docno, year(head.dateid) as yr, month(head.dateid) as mo, ifnull(client.clientname,'') as clientname, ifnull(detail.cr-detail.db,0) as sales, coa.alias
        from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
        where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())-2
        union all
        select 'p' as tr, head.docno, year(head.dateid) as yr, month(head.dateid) as mo, ifnull(client.clientname,'') as clientname, ifnull(detail.cr-detail.db,0) as sales, coa.alias
        from hglhead as head left join hgldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid left join client on client.clientid=head.clientid left join cntnum on cntnum.trno=head.trno
        where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())-2
        ) as a group by yr order by yr";

        $data = Yii::$app->sbccommon->opentable($qry);
        return $data;
    }//end fnc


    private function listsalesper(){
      $qry="select format(sum(sales),2) as sales from (
            select head.docno,ifnull(stock.ext,0) as sales, '' as alias
            from lahead as head left join lastock as stock on head.trno=stock.trno
            where head.doc='SJ' and year(head.dateid)=year(now())
            union
            select head.docno, ifnull(detail.cr-detail.db,0) as sales, coa.alias
            from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
            where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())
            ) as j";
      return Yii::$app->sbccommon->datareader($qry);
    }

  private function listsalesper_ls(){
      $qry="select format(sum(sales),2) as sales from (
            select head.docno,ifnull(stock.ext,0) as sales, '' as alias
            from lahead as head left join lastock as stock on head.trno=stock.trno
            where head.doc='SJ' and year(head.dateid)=year(now())
            union
            select head.docno, ifnull(detail.cr-detail.db,0) as sales, coa.alias
            from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
            where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())-1
            ) as j";
      return Yii::$app->sbccommon->datareader($qry);
    }

  private function listsalesper_lls(){
      $qry="select format(sum(sales),2) as sales from (
            select head.docno,ifnull(stock.ext,0) as sales, '' as alias
            from lahead as head left join lastock as stock on head.trno=stock.trno
            where head.doc='SJ' and year(head.dateid)=year(now())
            union
            select head.docno, ifnull(detail.cr-detail.db,0) as sales, coa.alias
            from glhead as head left join gldetail as detail on detail.trno=head.trno left join coa on coa.acnoid=detail.acnoid
            where head.doc='sj' and left(coa.alias,2)='sa' and year(head.dateid)=year(now())-2
            ) as j";
      return Yii::$app->sbccommon->datareader($qry);
    }

    private function listexpns(){
      $qry = "select format(sum(db),2) as db, format(sum(cr),2) as cr, format(sum(db-cr),2) as expenses from (
            select head.docno, head.dateid, coa.cat, coa.acno, coa.acnoname, detail.db, detail.cr from ladetail as detail
            left join lahead as head on head.trno=detail.trno
            left join coa on detail.acno=coa.acno where coa.cat='E' and head.doc in ('PV','CV') and year(head.dateid)=year(now())
            union all
            select head.docno, head.dateid, coa.cat, coa.acno, coa.acnoname, detail.db, detail.cr from gldetail as detail
            left join glhead as head on head.trno=detail.trno
            left join coa on detail.acnoid=coa.acnoid where coa.cat='E' and head.doc in ('PV','CV') and year(head.dateid)=year(now())
            ) as j";
      return Yii::$app->sbccommon->opentable($qry);
    }

    private function listcollections(){
      $qry = "select format(sum(db),2) as db, format(sum(cr),2) as cr, format(sum(db-cr),2) as collections from (
            select head.docno, head.dateid, coa.cat, coa.acno, coa.acnoname, detail.db, detail.cr from ladetail as detail
            left join lahead as head on head.trno=detail.trno
            left join coa on detail.acno=coa.acno where left(coa.alias,2) in ('CA','CR') and head.doc='CR' and year(head.dateid)=year(now())
            union all
            select head.docno, head.dateid, coa.cat, coa.acno, coa.acnoname, detail.db, detail.cr from gldetail as detail
            left join glhead as head on head.trno=detail.trno
            left join coa on detail.acnoid=coa.acnoid where left(coa.alias,2) in ('CA','CR') and head.doc='CR' and year(head.dateid)=year(now())
            ) as j";
      return Yii::$app->sbccommon->opentable($qry);
    }
    
    public function TotalSales(){
        $qry="select count(docno) as sales from
        (select docno from lahead where doc='SJ'
        union all
        select docno from glhead where doc='SJ') as t";
        $data = Yii::$app->sbccommon->opentable($qry);
        return $data[0]['sales'];
    }//emd fnc

    public function TotalPurchases(){
        $qry="select count(docno) as purchases from
        (select docno from lahead where doc='RR'
        union all
        select docno from glhead where doc='RR') as t";
        $data = Yii::$app->sbccommon->opentable($qry);
        return $data[0]['purchases'];
    }//end fnc

    public function outstandingap(){
        $qry="select format(sum(bal),2) as outap from apledger where bal<>0";
        $data = Yii::$app->sbccommon->opentable($qry);
        return $data[0]['outap'];
    }//end function

    public function outstandingar(){
        $qry="select format(sum(bal),2) as outar from arledger where bal<>0";
        $data = Yii::$app->sbccommon->opentable($qry);
        return $data[0]['outar'];
    }//end funciton

    //END NOTE: TRANSFER ALL THIS FUNCTION TO dashboardfuntion.php (components)

  public function searchModelrep($searchthis) {
        return "select model_id,model_code,model_name from model_masterfile where model_name like '%".$searchthis."%'";
  }//end search model rep

  public function searchSjtag($controller,$access,$params){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      //IF VIEW ACCESS IS NOT AVAILABLE
      return $data = '';
    }else{
      $qry="select 0 as trno , '' as docno , '' as clientname, '' as client, '' as dateid,
            '' as postedby , '' as postdate,'' as yourref,  '' as ourref,'' as rem , 0 as cmtrans
            UNION ALL
            select cntnum.trno,cntnum.docno,head.clientname,cl.client,date(head.dateid) as dateid,
            cntnum.postedby,cntnum.postdate, head.yourref,
            head.ourref,head.rem,head.cmtrans
            from glhead as head
            left join cntnum on head.trno = cntnum.trno
            left join client as cl on cl.clientid = head.clientid
            where head.doc = 'SJ'
            and cntnum.center = '".Yii::$app->session['loggeduser']['center']."' and cl.client='".$params['clientcode']."'
            and (cntnum.docno like '%".$params['x']."%' or head.clientname like '%".$params['x']."%' or head.yourref like '%".$params['x']."%' or head.ourref like '%".$params['x']."%')
            order by docno LIMIT 50";
      return $qry;  
    }//end if yii app access
  }//end function 

  //THIS FUNCTION 
  public function recomputeStock($amt,$disc,$qty,$uomfactor,$doc,$vat = 0){
    if(empty($disc) || $disc == ""){
      $disc = 0;
    }//end if

    if(empty($vat) || $vat == ""){
      $vat = 0;
    }//end if

    return $this->stockCompute($amt,$disc,$qty,$uomfactor,$doc,$vat);
  }//end function

  public function useraccessLog($trno){
      $qry ="select trno,field,oldversion,userid,dateid,pic from(
            select trno, field, oldversion, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
            from useraccess_log as log
            left join useraccess as u on u.username=log.userid
            where trno='$trno'
            union all
            select trno, concat('DELETE',' ',field), docno, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
            from  del_useraccess_log as log
            left join useraccess as u on u.username=log.userid
            where trno='$trno') as tbl order by dateid desc";
      return $qry;
   }//end function

  public function appendArrays(&$multiarray,$appendarray){
      foreach ($appendarray as $key => $value) {
        array_push($multiarray, $appendarray[$key]);
      }//end for each
  }//end function

  //JAOSKIMOD: revised isbbelowcost function
  //added new params (line,barcode)
  public function isbelowcost($isamt,$cost,$line=0,$barcode='') {
      if($barcode != '' && $line != 0){
        $errmsg = 'Line: ['.$line.'] <br> Barcode: ['.$barcode.'] <br> is BELOW COST';
      }else{
        $errmsg = 'BELOW COST...';
      }//end if

      $cost = str_replace(',', '', $cost);
      $isamt = str_replace(',', '', $isamt);
      
      if($cost>$isamt){
        return ['status'=>true,'msg'=>$errmsg];
      } else {
        return ['status'=>false,'msg'=>''];
      }//end if
  }//end function

  public function checkMinimumMaximumBalance($barcode,$wh){
      $sumbal = 0 ;
      $min = 0 ;
      $max = 0;
      $title ='WARNING!';
      $iname = '';
      $uom = '';
      $whcode = '';
      $whname ='';
      $message = "";
      $strRRStatus ="select ifnull(sum(rrstatus.bal),0) as bal,item.maximum,item.minimum,
      item.barcode,item.itemname,item.uom,client.client as whcode,
      client.clientname as whname from rrstatus 
      left join client on client.clientid=rrstatus.whid 
      left join item on item.itemid=rrstatus.itemid 
      where item.barcode='".$barcode."' and client.client='".$wh."' 
      and rrstatus.bal<>0 group by item.maximum,item.minimum,item.barcode,
      item.itemname,item.uom,client.client,client.clientname ";
      $dt = Yii::$app->sbccommon->opentable($strRRStatus);
      if ($dt!=null){
          $min = $dt[0]['minimum'];
          $max = $dt[0]['maximum'];
          $iname =$dt[0]['itemname'];
          $uom =$dt[0]['uom'];
          $whcode = $dt[0]['whcode'];
          $whname = $dt[0]['whname'];                
          $sumbal = $dt[0]['bal'];
      }else{
          $sumbal = 0;
      }//END IF
      if($max!=0){
          if($sumbal >= $max){
              $message=$title.'<br/>'.'Item Code : '.$barcode.'<br/>
              '.'Item Name : '.$iname.'<br/>
              '.'Warehouse : '.$whname.' ('.$whcode.')'.'<br/>
              '.'Uom : '.$uom.'<br/>
              '.'Warning : You Reached the MAXIMUM level of '.number_format($max).'<br>';
          }//end if
      }//end if
      if($min!=0){
         if ($sumbal<=$min){
              $message = $title.'<br />'.$message.'Item : '.$barcode.'<br/>
              '.'Itemname : '.$iname.'<br/>
              '.'Warehouse : '.$whname.' ('.$whcode.')'.'<br/>
              '.'Uom : '.$uom.'<br/>
              '.'Warning : You Reached the MINIMUM level of '.number_format($min);
         }//end if
      }//end if         
      return $message;
  }//end function


  public function changeItemBarcode($newbarcode,$oldbarcode){
    $updateqry = [];
    $statusupdates = [];
    $status = true;

    $updateqry[] = "update item set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update postock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update hpostock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update pcstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update hpcstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update sostock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update hsostock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update lastock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update prstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update hprstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";

    $updateqry[] = "update pistock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update hpistock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update pdstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update hpdstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";

    $updateqry[] = "update trstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update htrstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";

    $updateqry[] = "update spcstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";
    $updateqry[] = "update hspcstock set barcode = '".$newbarcode."' where barcode = '".$oldbarcode."'";


    foreach ($updateqry as $key => $value) {
      $statusupdates[] = Yii::$app->sbccommon->execqry($value);
    }//end if

    foreach ($statusupdates as $key => $value) {
      if(!$statusupdates){
        $status = false;
        break;
      }//end if
    }//end for each checking of ITEM UPDATES

    return $status;
  } //end function changei tem barcode     

  public function searchCostcenter() {
    return "select line,code,name from projectmasterfile";
  }

  public function searchChecks($controller,$access,$ccode) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      return $qry = $this->requestChecks($ccode);
    }
  }

  public function getCostCenters(){
    $qry = "select line,code,name from projectmasterfile";
    return $centers = Yii::$app->sbccommon->opentable($qry);
  }//end function

  public function checkItemIsDownloaded($itemid){
    $qry = "select isdownloaded from item where itemid = ".$itemid."";
    $isdown = Yii::$app->sbccommon->datareader($qry);

    if($isdown){
      return true;
    }else{
      return false;
    }//end if
  } //end if

  public function checkClientIsDownloaded($client){
    $qry = "select isdownloaded from client where client = '".$client."'";
    $isdown = Yii::$app->sbccommon->datareader($qry);

    if($isdown){
      return true;
    }else{
      return false;
    }//end if
  } //end if

  public function checkForFlaginformation($flagtype,$transkey,$doc){
    switch (strtoupper($flagtype)) {
        case 'DISAPPROVED':
            $reason1 = '';
            switch ($doc) {
                case 'SO':
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                          $qry = "select reason1 as reason from hsohead as head where head.trno = ".$transkey."";
                          $data = Yii::$app->sbccommon->datareader($qry);
                          if(!empty($data)){
                              $reasons = explode("\n", $data);
                              foreach ($reasons as $key => $value) {
                                  if($reason1 == ''){
                                      $reason1 = $value;
                                  }else{
                                      $reason1 = $reason1 . "\r\n"  . $value;
                                  }//end if
                              }//end if
                          }//end if
                          $data = $reason1;
                        break;
                    }//END switch
                break;
            }//END switch
        break;

        case 'APPROVED':
            $reason1 = '';
            switch ($doc) {
                case 'SO':
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                          $qry = "select reason2 as reason from hsohead as head where head.trno = ".$transkey."";
                          $data = Yii::$app->sbccommon->datareader($qry);
                          if(!empty($data)){
                              $reasons = explode("\n", $data);
                              foreach ($reasons as $key => $value) {
                                  if($reason1 == ''){
                                      $reason1 = $value;
                                  }else{
                                      $reason1 = $reason1 . "\r\n"  . $value;
                                  }//end if
                              }//end if
                          }//end if
                          $data = $reason1;
                        break;
                    }//END switch
                break;
            }//END switch
        break;
    }//END SWTICH

    return $data;
  }//end function

  public function checkTransctionDateApproval($transdate){
    $datetoday = strtotime(Yii::$app->systemsettings->getSystemLockdate());
    $transdate = strtotime($transdate);
    if($datetoday == ''){
      return true;
    }else{
      if ($transdate < $datetoday) {
          return false;
      }else{
          return true;
      }//end if
    }//end if
  }//end function

  public function getOverallUnpaidTransactions($clientid){
    $center=Yii::$app->session['loggeduser']['center'];
    Yii::$app->systemsettings->setDefaultTimeZone();
    $datefilter = date('Y-m-d');
    $data=Yii::$app->sbccommon->opentable("select 
            round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") AS db,
            round(sum(cr),".Yii::$app->systemsettings->setDecimaldisplay('currency').") AS cr, 
            round(sum(balance),".Yii::$app->systemsettings->setDecimaldisplay('currency').") AS balance from
            (select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
            `arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,`arledger`.`cr` as `cr`,arledger.bal,
            `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
            (`detail`.`rem`) as `rem`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
            0 as `fbal`,`head`.`ourref` as `reference`,'posted' as `status` from ((((`arledger`
            left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
            on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
            left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
            on((`agent`.`clientid` = `arledger`.`agentid`))) where arledger.clientid= $clientid and cntnum.center = '$center'
            union all
            select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
            sum(detail.ext) as `db`,0 as `cr`,sum(detail.ext) as `bal`,
            `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
            sum(detail.ext) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
            from `lahead` as head
            left join `lastock` as detail on `detail`.`trno` = `head`.`trno`
            left join `client` on `client`.`client` = `head`.`client`
            left join cntnum on cntnum.trno = head.trno
            where cntnum.doc = 'SJ' and client.clientid= $clientid' and cntnum.center = '$center'
            group by head.docno) as t");
            return $data;
  }//end func

  public function countTrnxTagged($doc,$trno){
    switch ($doc) {
      case 'TX':
        $qry = "select ifnull(count(docno),0) as count from (
                select head.docno from lahead as head
                left join cntnum as num on num.trno = head.trno
                where num.doc = 'SJ' and num.txno = ".$trno."
                UNION ALL
                select head.docno from glhead as head
                left join cntnum as num on num.trno = head.trno
                where num.doc = 'SJ' and num.txno = ".$trno.") as tbl";
        break;

      case 'RF':
        $qry = "select count(head.docno) as docno from hsohead as head
                left join client on client.client = head.client
                where head.isapproved = 1 and rfno = ".$trno;
      break;
    }//END SWITCH CASE

    return Yii::$app->sbccommon->datareader($qry);
  }//end function 

  public function countCustomersOnTrans($doc,$trno){
    switch ($doc) {
      case 'TX':
        $qry = "select ifnull(count(distinct client),0) as count from (
                select head.client from lahead as head
                left join cntnum as num on num.trno = head.trno
                where num.doc = 'SJ' and num.txno = ".$trno."
                group by head.clientname,head.client
                UNION ALL
                select client.client from glhead as head
                left join cntnum as num on num.trno = head.trno
                left join client on client.clientid = head.clientid
                where num.doc = 'SJ' and num.txno = ".$trno."
                group by client.clientname,client.client) as tbl";
        break;

      case 'RF':
        $qry = "select count(distinct head.client) as customer from hsohead as head
                left join client on client.client = head.client
                where head.isapproved = 1 and rfno = ".$trno;
      break;
    }//end switch case 

    return Yii::$app->sbccommon->datareader($qry);
  }//end function count customer on trans

  public function getGrandtotalAmount($doc,$trno){
    switch ($doc) {
      case 'TX':
      $qry = "select sum(ifnull(ext,0)) as ext from (
              select head.docno,sum(ifnull(stock.ext,0)) as ext from lahead as head
              left join cntnum as num on num.trno = head.trno
              left join lastock as stock on stock.trno = head.trno
              where num.doc = 'SJ' and num.txno = ".$trno."
              group by head.docno
              UNION ALL
              select head.docno,sum(ifnull(stock.ext,0)) as ext from glhead as head
              left join cntnum as num on num.trno = head.trno
              left join glstock as stock on stock.trno = head.trno
              where num.doc = 'SJ' and num.txno = ".$trno."
              group by head.docno) as tbl";    
      break;

      case 'RF':
      $qry = "select sum(stock.ext) as ext from hsohead as head
              left join hsostock as stock on stock.trno = head.trno
              left join client on client.client = head.client
              where head.isapproved = 1 and stock.void <> 1 and rfno = ".$trno."";
      break;
    }//END SWITCH
    return Yii::$app->sbccommon->datareader($qry);
  }//end function

  public function getStocklineCBM($doc,$trno,$line){
    $cbm = 0;

    switch ($doc) {
      case 'SO':
        $qry = "select stock.isqty,uom.cbm from sostock as stock
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."
                UNION ALL 
                select stock.isqty,uom.cbm from hsostock as stock
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."";
        break;
      
      case 'SJ':
        $qry = "select stock.isqty,uom.cbm from lastock as stock
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."
                UNION ALL 
                select stock.isqty,uom.cbm from glstock as stock
                left join item on item.itemid=stock.itemid
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."";
        break;
    }//end switch

    $itmdata = Yii::$app->sbccommon->opentable($qry);
    $cbm += floatval($itmdata[0]['isqty']) * floatval($itmdata[0]['cbm']);
  }//end funciton

  public function getStocklineTons($doc,$trno,$line){
    $tons = 0;

    switch ($doc) {
      case 'SO':
        $qry = "select stock.isqty,uom.kilos from sostock as stock
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."
                UNION ALL
                select stock.isqty,uom.kilos from hsostock as stock
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."";
        break;
      
      case 'SJ':
        $qry = "select stock.isqty,uom.kilos from lastock as stock
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."
                UNION ALL
                select stock.isqty,uom.kilos from glstock as stock
                left join item on item.itemid=stock.itemid
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno and line = ".$line."";
        break;
    }//END SWITCH

    $itemton = Yii::$app->sbccommon->opentable($qry);
    $tons = floatval($itemton[0]['isqty']) * floatval($itemton[0]['kilos']) / 1000;

    return $tons;
  }//end function

  public function getGrandTotalCBM($doc,$trno){
      $totalcbm = 0;
      switch ($doc) {
        case 'SJ':
          $qry = "select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                      from lastock as stock
                      left join item on item.barcode=stock.barcode
                      left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                      where trno=$trno
                      UNION ALL 
                      select stock.trno,item.barcode,stock.isqty,uom.cbm,uom.kilos
                      from glstock as stock
                      left join item on item.itemid=stock.itemid
                      left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                      where trno=$trno";
          break;
        
        case 'SO':
          $qry = "select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                  from sostock as stock
                  left join item on item.barcode=stock.barcode
                  left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                  where trno=$trno
                  UNION ALL 
                  select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                  from hsostock as stock
                  left join item on item.barcode=stock.barcode
                  left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                  where trno=$trno";
          break;
      }//end switch case
      $data = Yii::$app->sbccommon->opentable($qry);
      

      if(!empty($data)){
          foreach ($data as $itmindex => $itmdata) {
              $totalcbm += floatval($itmdata['isqty']) * floatval($itmdata['cbm']);
          }//end for each
      }else{
          $totalcbm = 0;
      }//end if
  
      return $totalcbm;
  } //end function 

  public function getGrandTotalTons($doc,$trno){
      $totaltonnage=0;
      
      switch ($doc) {
        case 'SJ':
          $qry ="select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                from lastock as stock
                left join item on item.barcode=stock.barcode
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno
                UNION ALL
                select stock.trno,item.barcode,stock.isqty,uom.cbm,uom.kilos
                from glstock as stock
                left join item on item.itemid=stock.itemid
                left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                where trno=$trno";
          break;
        
        case 'SO':
          $qry ="select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                    from sostock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno
                    UNION ALL
                    select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                    from hsostock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno";
        break;

        case 'QA':
          $qry ="select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                    from qastock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno
                    UNION ALL
                    select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                    from hqastock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno";
        break;
      }//END SWITCH

      $data2 = Yii::$app->sbccommon->opentable($qry);
      if(!empty($data2)){
        foreach ($data2 as $itmindex => $itemton) {
          $totaltonnage += ((floatval($itemton['isqty']) * floatval($itemton['kilos'])) / 1000);
        }//end for each
      }else{
        $totaltonnage = 0;
      }//end if
     
     return $totaltonnage;
  }//end function

  public function hadGeneratedRouteGuide($txtrno){
    $qry = "select generatedrg from txhead as head where trno =".$txtrno."
            UNION ALL
            select generatedrg from htxhead as head where trno = ".$txtrno."";
    $isrg = Yii::$app->sbccommon->datareader($qry);

    if($isrg){
      return true;
    }else{
      return false;
    }//end if
  }//end function 

  public function requestWarehouseItemInventory($barcode,$whcode){
    $whid = $this->requestClientid($whcode);
    $itemid = $this->requestItemid($barcode);
    $qry = "select ifnull(sum(bal),0) as currentbal from rrstatus where whid = ".$whid." and itemid = ".$itemid." and bal <> 0";

    return Yii::$app->sbccommon->datareader($qry);
  }//end funtion per warehouse

  public function requestCustomerPriceGroup($client){
      $pricegroup = Yii::$app->sbccommon->datareader("select class from client where client ='".$client."' limit 1");
      return $pricegroup;
  } //end function

  public function requestAgentPriceGroup($client){
      $pricegroup = Yii::$app->sbccommon->datareader("select class from client where client ='".$client."' limit 1");
      return $pricegroup;
  } //end function

  public function checkApprovalStatus($trno){
    $qry = "select isapproved from hsohead where trno =".$trno."";
    return Yii::$app->sbccommon->datareader($qry);
  }//

  public function isApproved($doc,$keyid){
    try {
    switch($doc){
      case 'SO':
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
                //RETRIEVES FIRST ADDITIONAL DETAILS OF THE TRANSACTION
                $reason = [];
                $isapproved = 1;
                Yii::$app->systemsettings->setDefaultTimeZone();
                $mainqry = "select client,docno from hsohead where trno = ".$keyid."";
                $mainqrydetails = Yii::$app->sbccommon->openTable($mainqry);
                $client = $mainqrydetails[0]['client'];
                $docno = $mainqrydetails[0]['docno'];
                $clientid = $this->requestClientid($client);
                $crlimitqry = "select crlimit from client where clientid = ".$clientid."";
                $crlimit = Yii::$app->sbccommon->datareader($crlimitqry);
                $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
                $datefilter = date('Y-m-d');

                //CHECK IF THERE IS DISCOUNT IN ONE OF THE STOCK ROW OF THE MODULE
                $discqry = "select disc from hsostock where trno = ".$keyid."";
                $stocks = Yii::$app->sbccommon->openTable($discqry);
                $hasdisc = 0;
                
                //LOOP ALL STOCK ROWS TO CHECK IF THERE IS DISC
                if(!empty($stocks)){
                  foreach ($stocks as $key => $value) {
                      if($value['disc'] != ''){
                        $hasdisc = 1;
                        break 1;
                      }//end for each
                  }//end for each
                }//end if

                if($hasdisc == 1){
                    $reason[] = "PRICE ISSUE";
                }//end if has disc

                //CHECKS FOR 1 MONTH UNPAID
                $qry31unpaid = "select left(dateid,10) as dateid from arledger 
                                where clientid = ".$clientid." and bal <> 0 order by dateid desc limit 1";
                $floatingunpaid_date = Yii::$app->sbccommon->datareader($qry31unpaid);
                $floatingdaysqry = "select abs(datediff((select left(cntnum.screceivedate,10) as dateid from arledger 
                                left join cntnum on cntnum.trno = arledger.trno
                                where clientid = 398 and bal <> 0 order by dateid desc limit 1),
                                left('".$datefilter."',10))) as floatingdays";
                $floatingdays = Yii::$app->sbccommon->datareader($floatingdaysqry);

                if($floatingdays > 31){
                  $reason[] = $floatingdays. ' UNPAID';
                }//end if

                //CHECKS IF CUSTOMER IS INACTIVE
                $notactiveqry = "select case when status <> 'ACTIVE' then 1 else 0 end as isinactive from client where clientid = ".$clientid."";
                $isinactive = Yii::$app->sbccommon->datareader($notactiveqry);

                if($isinactive == 1){
                    $reason[] = "NOT ACTIVE";
                }//end if IS INACTIVE

                //CHECKS FOR 180 DAYS (NO SALES ORDER)
                $qry180 = "select abs(datediff(left('".$datefilter."',10),
                          (select dateid from sohead
                          left join client on client.client = sohead.client
                          where sohead.trno not in ('".$keyid."')
                          and client.clientid = ".$clientid."
                          UNION ALL
                          select left(dateid,10) from hsohead
                          left join client on client.client = hsohead.client
                          where client.clientid = ".$clientid." and hsohead.trno not in ('".$keyid."')
                          order by left(dateid,10) desc limit 1))) as numdays";
                $numdays180 = Yii::$app->sbccommon->datareader($qry180);

                $is180days = 0;
                if($numdays180 > 180){
                  $is180days = 1;
                  $reason[] = $numdays180 . " LAPSED";
                }//END IF

                //GETS TOTAL OUTSTANDING BALANCE
                $outstandingbalqry = "select ifnull(sum(case when cr > 0 then (bal * -1) else bal end),0) as outstanding from arledger 
                                      where bal <> 0 and clientid = ".$clientid."";
                
                //GETS TOTAL UNSERVED SO
                $unservedsoqry = "select ifnull(sum((stock.isqty - (stock.qa / uom.factor)) * stock.isamt),0) as pendingso from hsohead as head
                              left join hsostock as stock on stock.trno = head.trno
                              left join client on client.client = head.client
                              left join item on item.barcode = stock.barcode
                              left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                              where (stock.qa / uom.factor) <> (stock.iss/uom.factor) and client.clientid = ".$clientid."";
                
                //GETS TOTAL PDC OF CUSTOMER
                $pdcqry = "select ifnull(round(sum(db),2),0) as db from
                          (select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno,
                          left(gldetail.postdate,10) as checkdate, gldetail.db, gldetail.cr,crledger.depodate,
                          case when crledger.depodate = null then concat(`gldetail`.`rem`) else
                          concat(`gldetail`.`rem`,' ',`deposit`.`docno`) end as rem,
                          client.clientid from glhead
                          left join gldetail on gldetail.trno=glhead.trno
                          left join crledger on crledger.trno=gldetail.trno and crledger.line = gldetail.line
                          left join client on client.clientid = gldetail.clientid
                          left join coa on coa.acnoid=gldetail.acnoid
                          left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line
                          where left(coa.alias,2)='cr' and glhead.doc='cr'
                          union all
                          select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate,
                          ladetail.db, ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid from lahead
                          left join ladetail on ladetail.trno=lahead.trno
                          left join client on client.client = ladetail.client
                          left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='cr' and ladetail.refx=0
                          and ladetail.linex=0) as customerpdc where clientid = ".$clientid." and checkdate >='".$datefilter."'";

                $outstandingbal = Yii::$app->sbccommon->datareader($outstandingbalqry);
                $unservedso = Yii::$app->sbccommon->datareader($unservedsoqry);
                $pdc = Yii::$app->sbccommon->datareader($pdcqry);
                //THIS LINE SUMS THEM UP AND THE COMPARES IT TO THE CUSTOMER CR LIMIT GOT FROM ABOVE
                $total_comparebal = floatval($outstandingbal) + floatval($unservedso) + floatval($pdc);
                $exceedcrlimit = 0;

                if($crlimit != 0){
                    if($total_comparebal > $crlimit){
                        $exceedcrlimit = 1;
                        $reason[] = "EXC CR LIMIT";
                    }//end if COMPARE CR LIMIT
                }//end if

                if($exceedcrlimit == 1 || $is180days == 1 || $isinactive == 1 || $hasdisc == 1){
                    $isapproved = 0;
                }//end if

                $reasoning = "";
                foreach ($reason as $key => $value) {
                    $reasoning = $reasoning . $value."\n";
                }//end for each

                $updateqry = "update hsohead set isapproved = ".$isapproved.",reason1 = '".$reasoning."' where trno =".$keyid."";
                if($isapproved){
                  $logmsg = "APPROVED";
                }else{
                  $logmsg = "DISAPPROVED";
                }//end if

                Log::writelog($doc,$keyid,'APPROVAL',$docno.' => '.$logmsg,Yii::$app->session['loggeduser']['username']);
                Yii::$app->sbccommon->execqry($updateqry);
            break;
          }//end switch case company
      break;
    }//end switch case MODULE DOC
    } catch (ErrorException $e) {
      echo $e;
    }
  } //end function 

  public function checkConfidentialAccess(){
    $loggeduser = Yii::$app->session['loggeduser'] ?? null;
    if (!is_array($loggeduser) || !isset($loggeduser['access'][898])) {
      return false;
    }
    return $loggeduser['access'][898];
  } //end function

  public function getCopyDocuments($doc,$trno){
    switch ($doc) {
      case 'TS':
        $qry = "select trno,doc,docno,client,wh,rem from lahead as head
                where head.doc = 'TS' and head.trno <> ".$trno."
                union all
                select trno,doc,docno,client.client as client,wh.client as wh,head.rem from glhead as head
                left join client on client.clientid = head.clientid
                left join client as wh on wh.clientid = head.whid
                where head.doc = 'TS' and head.trno <> ".$trno."";
      break;
      
      case 'TR':
        $qry = "select trno,doc,docno,client,wh,rem from trhead as head where head.trno <> ".$trno."
                union all
                select trno,doc,docno,client,wh,rem from htrhead as head where head.trno <> ".$trno."";
      break;
    }//END SWITCH CASE

    return Yii::$app->sbccommon->openTable($qry);
  }//end function

  public function copyStockItemsFrom($doc,$trno){
    switch ($doc) {
        case 'TR':
          $qry = "select stock.rrqty ,stock.qty,stock.cost,stock.rrcost,
                  item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,uom.factor as uomfactor,
                  stock.ext,stock.disc,stock.rem,stock.expiry,stock.loc,stock.wh as whcode
                  from trstock as stock
                  left join item on item.barcode = stock.barcode
                  left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                  where stock.trno = ".$trno."
                  union all
                  select stock.rrqty,stock.qty,stock.cost,stock.rrcost,
                  item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,uom.factor as uomfactor,
                  stock.ext,stock.disc,stock.rem,stock.expiry,stock.loc,wh.client as whcode 
                  from htrstock as stock
                  left join item on item.barcode = stock.barcode
                  left join client as wh on wh.client = stock.wh
                  left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                  where stock.trno = ".$trno . "";
        break;
        
        case 'TS':
            switch (Yii::$app->systemsettings->companyConfig()) {
              case 'SOUTHCENTRAL':
                 $qry = "select stock.rrqty ,stock.qty,stock.iss,stock.isqty as qty,stock.amt as cost,stock.isamt as rrcost,
                        item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,uom.factor as uomfactor,
                        stock.ext,stock.disc,stock.rem,stock.expiry,stock.loc,head.client as whcode
                        from lastock as stock
                        left join lahead as head on head.trno = stock.trno
                        left join item on item.barcode = stock.barcode
                        left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                        where stock.trno = ".$trno." and tstrno = 0
                        union all
                        select stock.rrqty,stock.qty,stock.iss,stock.isqty as qty,stock.amt as cost,stock.isamt as rrcost,
                        item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,uom.factor as uomfactor,
                        stock.ext,stock.disc,stock.rem,stock.expiry,stock.loc,whhead.client as whcode 
                        from glstock as stock
                        left join glhead as head on head.trno = stock.trno
                        left join item on item.itemid = stock.itemid
                        left join client as wh on wh.clientid = stock.whid
                        left join client as whhead on whhead.clientid = head.clientid
                        left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                        where stock.trno = ".$trno." and tstrno = 0";
                break;
              
              default:
                $qry = "select stock.rrqty ,stock.qty,stock.iss,stock.isqty as qty,stock.amt as cost,stock.isamt as rrcost,
                        item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,uom.factor as uomfactor,
                        stock.ext,stock.disc,stock.rem,stock.expiry,stock.loc,stock.wh as whcode
                        from lastock as stock
                        left join item on item.barcode = stock.barcode
                        left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                        where stock.trno = ".$trno." and tstrno = 0
                        union all
                        select stock.rrqty,stock.qty,stock.iss,stock.isqty as qty,stock.amt as cost,stock.isamt as rrcost,
                        item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,uom.factor as uomfactor,
                        stock.ext,stock.disc,stock.rem,stock.expiry,stock.loc,wh.client as whcode 
                        from glstock as stock
                        left join item on item.itemid = stock.itemid
                        left join client as wh on wh.clientid = stock.whid
                        left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
                        where stock.trno = ".$trno." and tstrno = 0";
                break;
            }//END SWITCH
        break;
    }//end switch

    return Yii::$app->sbccommon->openTable($qry);
  } //end function

  public function getDefaultItemLocation($barcode){
    $qry = "select ifnull(item_class.cl_name,'') from item
    left join item_class on item_class.cl_code = item.class
    where barcode ='".$barcode."';";
    return $location = Yii::$app->sbccommon->datareader($qry);
  } //end function get default item location;

  public function getDefaultItemWarehouse($barcode){
    $qry = "select ifnull(client.client,'') as whcode,ifnull(client.clientname,'') as whname from item
    left join client on client.client = item.defaultwh and client.IsWarehouse = 1
    where barcode ='".$barcode."';";

    $warehouse = Yii::$app->sbccommon->openTable($qry);
    return $warehouse[0];
  } //end function get default item location;

  public function getAvailable_SCcity(){
    $qry = "select sccity.id,sccity.code,sccity.name as cityname,scprovince.name as provname,scterritory.name as terrname from sccity
    left join scprovince on scprovince.id = sccity.provid
    left join scterritory on scterritory.id = scprovince.trid";

    $data = Yii::$app->sbccommon->openTable($qry);
    return $data;
  } //end function 
  //THIS FUNCTION IS FOR SOUTHCENTRAL (CEBU-JOY)
  public function getItemCommissionGrp(){
    $qry = "select id,code,name from commission_masterfile";
    $data = Yii::$app->sbccommon->openTable($qry);
    return $data;
  } //end function commission grp 

  //THIS FUNCTION IS FOR SOUTHCENTRAL (CEBU-JOY)
  public function getItemSubcategories(){
    $qry = "select sgrp.id as id,sgrp.scat_grp as sgrp,ifnull(cgrp.cat_grp,'') as catgrp,ifnull(tgrp.term_grp,'') as termgrp,
    ifnull(mgrp.main_grp,'') as maingrp from subcatgrp as sgrp
    left join catgrp as cgrp on cgrp.id = sgrp.cgid
    left join termgrp as tgrp on tgrp.id = cgrp.tgid
    left join maingrp as mgrp on mgrp.id = tgrp.mgid";

    $data = Yii::$app->sbccommon->openTable($qry);
    return $data;
  }//end fucntion subcategories

  public function getCustomerStats($yearfilter,$clientfilter,$statview){
    try {
      if ($yearfilter == ''){
        $filteryr = "";
      }else{
        $filteryr = " and year(head.dateid) = '".$yearfilter."'";
      }

      if($statview == ''){
        $statview = 'MONTHLY';
      }

      switch (strtoupper($statview)) {
        case 'MONTHLY':
          $grp = "CONCAT(monthname(head.dateid),' ',year(head.dateid))";
          break;
        
        case 'ANNUAL':
          $grp = "year(head.dateid)";
          break;
      }//end switch

      $qry = "select grp,client,clientname,sum(amount) as stats from (
              select ".$grp." as grp,date(head.dateid) as dateid, head.docno,
              client.client, client.clientname, sum(stock.ext) as amount
              from glhead as head
              left join glstock as stock on stock.trno=head.trno
              left join client on client.clientid=head.clientid
              left join cntnum on cntnum.trno=head.trno
              where head.doc='SJ' and head.dateid and cntnum.center='".Yii::$app->session['loggeduser']['center']."'
              and client.client = '".$clientfilter."'".$filteryr."
              group by head.dateid, head.docno, client.client, client.clientname
              union all
              select ".$grp." as grp,date(head.dateid) as dateid, head.docno,
              client.client, client.clientname, sum(stock.ext) as amount
              from hglhead as head
              left join hglstock as stock on stock.trno=head.trno
              left join client on client.clientid=head.clientid
              left join cntnum on cntnum.trno=head.trno
              where head.doc='SJ' and cntnum.center='".Yii::$app->session['loggeduser']['center']."' and client.client = '".$clientfilter."'".$filteryr."
              group by head.dateid, head.docno, client.client, client.clientname) as stats group by client,grp";
          
      $stats = Yii::$app->sbccommon->openTable($qry);

      $grandtotal = 0;
      foreach ($stats as $key => $value) {
          $grandtotal = $grandtotal + $value['stats'];
          $stats[$key]['stats'] = number_format($value['stats'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
      }//end function 

      $grandtotal = number_format($grandtotal,Yii::$app->systemsettings->setDecimaldisplay('currency'));
      return array('stats'=>$stats,'grandtotal'=>$grandtotal);
    } catch (ErrorException $e) {
      echo $e;
    }
  } //end function  

  public function deleteFlashDeal($flashid){
    $qry = "delete from frontend_flashdeal where md5(flashid) = '".$flashid."'";
    $status = Yii::$app->sbccommon->execqry($qry);

    if($status){
      $return = $this->deleteFlashDealItem($flashid);
      if($return['status']){
        $status = $return['status'];
        $msg = "Flash deal removed successfully!";
      }else{
        $msg = "Error occured while removing this flash deal. Please try again!";
      }//end if
    }else{
      $status = false;
      $msg = "Error occured while removing this flash deal. Please try again!";
    }//end if

    return array('status'=>$status,'msg'=>$msg);
  }//end function delete flash deal

  public function deleteFlashDealItem($flashid,$itemid = 0){
    if($itemid == 0){
      $qry="delete from frontend_fdealitems where md5(flashid) = '".$flashid."'";
    }else{
      $qry="delete from frontend_fdealitems where md5(flashid) = '".$flashid."' and itemid = ".$itemid."";
    }//end if

    $status = Yii::$app->sbccommon->execqry($qry);

    if($status){
      $msg = "Flash deal item removed successfully!";
    }else{
      $status = false;
      $msg = "Error occured while removing this flash deal item! Please try again";
    }//end if

    return array('status'=>$status,'msg'=>$msg);
  }//end function delete flash deal item

  /*THIS IS JUST A TEST FUNCTION IF TRANSFERRER OF DATA FORGOT TO PAD CLIENT CODES
  public function padd(){
    $qry = "select client,clientid from client where issupplier = 1";
    $codes = Yii::$app->sbccommon->openTable($qry);
    $common = new Common();
    foreach ($codes as $key => $value) {
      $newdocno = $common->PadJ('SL'.$value['client'], 13);
      $qryupdate = "update client set client = '".$newdocno."' where clientid = ".$value['clientid']."";
      Yii::$app->sbccommon->execqry($qryupdate);
    }//end for each
  }//end function*/

  //FUNCTION USED TO UPDATE ALL PAYMENT CREDENTIAL ON FRONTEND / E-COMMERCE
  public function updateOnlinePaymentCredentials($params){
    $qry = "update transnum set 
    op_payref='".$params['payref']."',
    op_ord='".$params['ord']."',
    op_sourceip='".$params['sourceip']."',
    op_paymethod='".$params['paymethod']."',
    op_txtime = '".$params['transtime']."'
    where docno = '".$params['docno']."'";

    return $status = Yii::$app->sbccommon->execqry($qry);
  }//end 

  //TO FIND WHAT VALUE IS NEED TO PRINT IN THE CHECK REGARDLESS OF POSITION OR LINE
  public function findChequeValue($trno){
      $qry = "select cr from ladetail as detail
      left join coa on coa.acno = detail.acno
      where trno = ".$trno." and left(coa.alias,2) = 'CB'
      UNION ALL
      select cr from gldetail as detail
      left join coa on coa.acnoid = detail.acnoid
      where trno = ".$trno."
      and left(coa.alias,2) = 'CB'";

      $chequevalue = Yii::$app->sbccommon->datareader($qry);
      if(empty($chequevalue)){
          $chequevalue = 0;
      }

      return $chequevalue;
  }//end find checkque value
  
  public function getCustomerFloatingBalance($cid){
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

  

  public function inquireProducts($searchstring){
    return $this->itemSearch($searchstring);
  }//end a citon inquire products

  // RTT MODIFICATIONS
  public function comparecategorylines($controller,$data){
    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    
    $categorydata = Yii::$app->sbccommon->openTable("select cat_id,cat_code,cat_name from category_masterfile where cat_id = $line");


      if($categorydata[0]['cat_code'] == $data['catcode'] && $categorydata[0]['cat_name'] == $data['catcode'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'categorydata'=>$categorydata);

  }  

  public function compareclasslines($controller,$data){
    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    
    $classdata = Yii::$app->sbccommon->openTable("select cl_id,cl_code,cl_name from item_class where cl_id = $line");


      if($classdata[0]['cl_code'] == $data['classcode'] && $classdata[0]['cl_name'] == $data['classcode'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'classdata'=>$classdata);

  }  

  public function comparecollectionlines($controller,$data){
    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    $cllcdata = Yii::$app->sbccommon->openTable("select cllc_id,cllc_code,cllc_name from collection_area where cllc_id = $line");


      if($cllcdata[0]['cllc_code'] == $data['cllccode'] && $cllcdata[0]['cllc_name'] == $data['cllcname'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'cllcdata'=>$cllcdata);

  }  

   public function comparedistributionlines($controller,$data){
    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    $cllcdata = Yii::$app->sbccommon->openTable("select dist_id,dist_code,dist_name from distribution_area where dist_id = $line");


      if($cllcdata[0]['dist_code'] == $data['distcode'] && $cllcdata[0]['dist_name'] == $data['distname'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'distdata'=>$cllcdata);

  }   

//END
  
  public function modifyFrontendDOD($itemid,$type){
    Yii::$app->systemsettings->setDefaultTimeZone();
    $dodcheck = "select dodid from frontend_dod where dod_date = '".date('Y-m-d')."' and itemid = ".$itemid."";
    $dodrecord = Yii::$app->sbccommon->opentable($dodcheck);
    
      switch ($type) {
        case 'add':
            if(empty($dodrecord)){
            $dodqry = "insert into frontend_dod (dod_date,itemid) values('".date('Y-m-d')."',".$itemid.")";
            Yii::$app->sbccommon->execqry($dodqry);
            }//end if
          break;
        
        case 'remove':
          if(!empty($dodrecord)){
            $dodqry = "delete from frontend_dod where dod_date = '".date('Y-m-d')."' and itemid = ".$itemid."";
            Yii::$app->sbccommon->execqry($dodqry);
          }//end if
          break;
      }//end switch

      return true;
  }//end insert to frontend

    // YOURREF YULICK 120116
  public function getyourref($searchstring){
        $qry = "select distinct yourref from lahead where doc='TS' and yourref is not null and yourref <>''
                and yourref like '%".$searchstring."%'
                union all
                select distinct yourref from glhead where doc='TS' and yourref is not null and yourref <>''
                and yourref like '%".$searchstring."%'
                order by yourref asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getyourref2($searchstring){
        $qry = "select distinct yourref from lahead where doc='SJ' and yourref is not null and yourref <>'' 
                and yourref like '%".$searchstring."%'
                union all
                select distinct yourref from glhead where doc='SJ' and yourref is not null and yourref <>''
                and yourref like '%".$searchstring."%'
                order by yourref asc limit 50";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getourref($searchstring){
        $qry = "select distinct ourref from lahead where doc='TS' and ourref is not null and ourref <>''
                and ourref like '%".$searchstring."%'
                union all
                select distinct ourref from glhead where doc='TS' and ourref is not null and ourref <>''
                and ourref like '%".$searchstring."%'
                order by ourref asc limit 50";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getourref2($searchstring){
        $qry = "select distinct ourref from lahead where doc='SJ' and ourref is not null and ourref <>''
                and ourref like '%".$searchstring."%'
                union all
                select distinct ourref from glhead where doc='SJ' and ourref is not null and ourref <>''
                and ourref like '%".$searchstring."%'
                order by ourref asc limit 50";

         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end
// END YOURREF YULICK 120116
    
    public function retrieveItemsPerHighlight($highlight){
      $qry = "select md5(fhighlight.highid) as highid,hitems.itemid,item.barcode,item.itemname,item.amt,
      hitems.highamt as fhamount,item.fqty from frontend_highlightitems as hitems
      left join item on item.itemid = hitems.itemid
      left join frontend_highlights as fhighlight on fhighlight.highid = hitems.highid
      where md5(hitems.highid) = '".$highlight."'";
      return Yii::$app->sbccommon->opentable($qry);
    }//end function retrieve items per highlight

    public function insertItemtoHighlight($highlightkey,$itemid){
      $getdiscqry = "select discount from frontend_highlights where highid = ".$highlightkey."";
      $getamtqry = "select amt from item where itemid = ".$itemid."";
      $discount = Yii::$app->sbccommon->datareader($getdiscqry);
      $org_amt = Yii::$app->sbccommon->datareader($getamtqry);
      
      $discountedval = Yii::$app->sbccommon->Discount($org_amt,$discount);
      $discamt = number_format($discountedval,Yii::$app->systemsettings->setDecimaldisplay('currency'));
      
      $qry = "insert into frontend_highlightitems (highid,itemid,highamt) values(".$highlightkey.",".$itemid.",".$discountedval.")";
      $status = Yii::$app->sbccommon->execqry($qry);
      return $status;
    }//end function

    public function checkForHighlights($itemid){
        $qry = "select highlights.highid,highlights.high_desc,highlights.promostart,highlights.promoend
        from frontend_highlightitems as highitems
        left join frontend_highlights as highlights on highlights.highid = highitems.highid
        where md5(highitems.itemid) = md5(".$itemid.")";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function checkForConflictingHighlights($availablehighlightdata,$currenthighlightdata){
        if(!empty($availablehighlightdata)){
          //CHECKING HERE FOR CONFLICTING
          $countconflicts = 0;
          foreach ($availablehighlightdata as $key => $value) {
            //CHECKS FIRST IF START DATE IS CONFLICTING WITH ANOTHER PROMO
            if($value['promostart'] <= $currenthighlightdata['startdate'] && $value['promoend'] >= $currenthighlightdata['startdate']){
                $countconflicts += 1;                
                //ENCODES OR ADDS CONFLICTING PROMO TO LIST
                $conflicting_highlights[$value['highid']] = array('promostart'=>$value['promostart'],'promoend'=>$value['promoend'],'high_desc'=>$value['high_desc']);
            }else{
              //CHECKS FIRST IF END DATE IS CONFLICTING WITH ANOTHER PROMO
              if($value['promostart'] <= $currenthighlightdata['enddate'] && $value['promoend'] >= $currenthighlightdata['enddate']){
                $countconflicts += 1;
                //ENCODES OR ADDS CONFLICTING PROMO TO LIST
                $conflicting_highlights[$value['highid']] = array('promostart'=>$value['promostart'],'promoend'=>$value['promoend'],'high_desc'=>$value['high_desc']);
              }else{
                $status = false;
              }//end function
            }//end if
          }//end for each

          //IF THERE ARE HIGHLIGHTS BUT NO CONFLICTS
          if($countconflicts == 0){
            $status = false;
            $conflicting_highlights = '';
          }else{
          //IF THERE ARE HIGHLIGHTS AND SOME CONFLICTS
            $status = true;
          }//end if
        }else{
          $status = false; 
          $conflicting_highlights = '';
        }//end if

        return array('status'=>$status,'conflicting_highlights'=>$conflicting_highlights);
    }//end function 

    public function getHighlights($status,$searchstring){
      switch ($status) {
        case '1': case '0':
          $where_clause = " where isenabled  = ".$status."";
          break;
        
        case '2':
          $where_clause = " ";
          break;
      }//end switch

      if($searchstring != ''){
        if($where_clause == " "){
            $where_clause = " where high_desc like '%".$searchstring."%'";
        }else{
            $where_clause = $where_clause . " and high_desc like '%".$searchstring."%'";
        }//end if
      }//end if

      $qry = "select isfeatured,isenabled as status,md5(highid) as highkey,high_desc from frontend_highlights" . $where_clause;
      return Yii::$app->sbccommon->opentable($qry);
    }//end function highlights


    public function retrieveHighlightInfo($md5highid){
      $qry = "select high.highid as q,case when high.promostart = '0000-00-00' then '' else high.promostart end as promostart,
      case when high.promoend = '0000-00-00' then '' else high.promoend end as promoend,
      high.high_desc,high.isenabled,high.primarypic,high.primarybanner,high.discount
      from frontend_highlights as high
      where md5(high.highid) = '".$md5highid."'";
      return Yii::$app->sbccommon->opentable($qry);
    }//end function 

    public function ftNumberToWordsConverter($number) {
          if($number == 0){
            return 'Zero';
          }else{
              $hyphen      = ' ';
              $conjunction = ' ';
              $separator   = ' ';
              $negative    = 'negative ';
              $decimal     = ' and ';
              $dictionary  = array(
                  0                   => '',
                  1                   => 'One',
                  2                   => 'Two',
                  3                   => 'Three',
                  4                   => 'Four',
                  5                   => 'Five',
                  6                   => 'Six',
                  7                   => 'Seven',
                  8                   => 'Eight',
                  9                   => 'Nine',
                  10                  => 'Ten',
                  11                  => 'Eleven',
                  12                  => 'Twelve',
                  13                  => 'Thirteen',
                  14                  => 'Fourteen',
                  15                  => 'Fifteen',
                  16                  => 'Sixteen',
                  17                  => 'Seventeen',
                  18                  => 'Eighteen',
                  19                  => 'Nineteen',
                  20                  => 'Twenty',
                  30                  => 'Thirty',
                  40                  => 'Forty',
                  50                  => 'Fifty',
                  60                  => 'Sixty',
                  70                  => 'Seventy',
                  80                  => 'Eighty',
                  90                  => 'Ninety',
                  100                 => 'Hundred',
                  1000                => 'Thousand',
                  1000000             => 'Million',
                  1000000000          => 'Billion',
                  1000000000000       => 'Trillion',
                  1000000000000000    => 'Quadrillion',
                  1000000000000000000 => 'Quintillion');
       
              if (!is_numeric($number)) {
                  return false;
              }
       
              if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                  // overflow
                  return false;
              }

              if ($number < 0) {
                  return $negative . $this->ftNumberToWordsConverter(abs($number));
              }
       
              $string = $fraction = null;
       
              if (strpos($number, '.') !== false) {
                  $fractionvalues = explode('.', $number);
                  if($fractionvalues[1] != '00' || $fractionvalues[1] != '0'){
                      list($number, $fraction) = explode('.', $number);
                  }//end if
              }
              

              switch (true) {
                  case $number < 21:
                      $string = $dictionary[$number];
                      break;

                  case $number < 100:
                      $tens   = ((int) ($number / 10)) * 10;
                      $units  = $number % 10;
                      $string = $dictionary[$tens];
                      if ($units) {
                          $string .= $hyphen . $dictionary[$units];
                      }
                      break;

                  case $number < 1000:
                      $hundreds  = $number / 100;
                      $remainder = $number % 100;
                      $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                      if ($remainder) {
                          $string .= $conjunction . $this->ftNumberToWordsConverter($remainder);
                      }
                      break;

                  default:
                      $baseUnit = pow(1000, floor(log($number, 1000)));
                      $numBaseUnits = (int) ($number / $baseUnit);
                      $remainder = $number % $baseUnit;
                      $string = $this->ftNumberToWordsConverter($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                      if ($remainder) {
                          $string .= $remainder < 100 ? $conjunction : $separator;
                          $string .= $this->ftNumberToWordsConverter($remainder);
                      }
                      break;
              }//end switch
       
            if (null !== $fraction && is_numeric($fraction)) {
                $string .= $decimal . ' ' . $fraction .  '/100';
                $words = array();

                /*if($number < 21){
                  $words[] = $dictionary[$number];
                }else{
                  $tens   = ((int) ($fraction / 10)) * 10;
                  $units  = $fraction % 10;
                  $fractstr = $dictionary[$tens];

                  if ($units) {
                      $fractstr .= $hyphen . $dictionary[$units];
                  }//end if

                  $words[] = $fractstr . ' cents';
                }*/

                $string .= implode(' ', $words);
            }
           
            return strtoupper($string);
        }//end
    }//end function convert to words

    public function checkDataIfPosted($trno,$doc){
      if($trno == '' || empty($trno)){
        return false;
      } 

      $tablenum = Common::gettablenum($doc);
      $qry = "select case when postdate is null then 0 else 1 end as status from ".$tablenum." where trno = ".$trno." and doc = '".$doc."'";
      $status = Yii::$app->sbccommon->datareader($qry);

      if($status == 1){
        return true;
      }else{
        return false;
      }//end if
    }//end function if check data if posted 


    public function searchUom($controller,$access,$str) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return $data = $this->uomsearch($str);
      }
    }

    public function uomsearch($str) {
      return "select 0 as isfromitem,uom,uom as prevuom,factor,amt,line,kilos,ifnull(uom_desc,'') as uom_desc,cbm from uom where itemid = ".$str." order by line";
    }

    public function getItemsAvailableForVoid($doc,$trno,$searchstring){
      $stock = Common::localhstock($doc);
      $head = Common::localhhead($doc);

      switch ($doc) {
        case 'SO': case 'SJ':
          $qty = 'isqty';
          break;
        
        case 'PO': case 'RR': case 'TR':
          $qty = 'rrqty';
          break;
      }//END SWITCH CASE

      if($searchstring == ''){
        $filtersearch = "where head.trno = ".$trno." and stock.void = 0";
      }else{
        $filtersearch = "where head.trno = ".$trno." and stock.void = 0 and stock.itemname like '%".$searchstring."%' 
        or head.trno = ".$trno." and stock.void = 0 and stock.barcode like '%".$searchstring."%' 
        or head.trno = ".$trno." and stock.void = 0 and stock.uom like '%".$searchstring."%' ";
      }//end if searchstring

      $qry = "select stock.trno,stock.line,stock.barcode,stock.itemname,
      stock.".$qty." as qty,stock.uom,(stock.".$qty." - stock.qa) as bal
      from ".$head." as head
      left join ".$stock." as stock on stock.trno = head.trno " . $filtersearch;
     
      return $qry;
      // return Yii::$app->sbccommon->opentable($qry);  
    }//end function

    public function getOnSaleItems($searchstring){
        Yii::$app->systemsettings->setDefaultTimeZone();
        //TODO: FIX THIS QUERY IT MUST HAVE SINGLE ITEM SALE AND HIGHLIGHT ITEM SALE AND CAN BE FILTERS ON DATES
        $qry = "select itemid,barcode,itemname,highlight,qty,amt,saleprice,underhighlight,promostart,promoend from
        (select md5(item.itemid) as itemid,item.barcode,item.itemname,highlights.high_desc as highlight,item.fqty as qty,
        item.amt,item.saleprice,1 as underhighlight,highlights.promostart,highlights.promoend from frontend_highlightitems as hitem
        left join item on item.itemid = hitem.itemid
        left join frontend_highlights as highlights on highlights.highid = hitem.highid
        where highlights.promostart <= '".date('Y-m-d')."' and highlights.promoend >= '".date('Y-m-d')."'
        and (item.itemname like '%".$searchstring."%' or item.barcode like '%".$searchstring."%' or highlights.promostart like '%".$searchstring."%' 
        or highlights.promoend like '%".$searchstring."%')
        UNION ALL
        select md5(item.itemid) as itemid,item.barcode,item.itemname,'' as highlight,item.fqty as qty,
        item.amt,item.saleprice,0 as underhighlight,item.promostart,item.promoend from item
        where item.promostart <= '".date('Y-m-d')."' and item.promoend <= '".date('Y-m-d')."'
        and (item.itemname like '%".$searchstring."%' or item.barcode like '%".$searchstring."%' 
        or item.promostart like '%".$searchstring."%' or item.promoend like '%".$searchstring."%')
        and item.itemid not in (select highitemselect.itemid from frontend_highlights as highselect
        left join frontend_highlightitems as highitemselect on highitemselect.highid = highselect.highid
        where highselect.promostart <= '".date('Y-m-d')."' and highselect.promoend >= '".date('Y-m-d')."')) as tbl order by itemname asc";
        return Yii::$app->sbccommon->opentable($qry);
    }//end function 

    public function getEndSaleItems($searchstring){
        Yii::$app->systemsettings->setDefaultTimeZone();
        $qry = "select md5(item.itemid) as itemid,item.itemname,item.barcode,endedsale.datestart,endedsale.dateend,
          case when endedsale.highlight <> 0 then 1 else 0 end as fromhighlight,
          case when endedsale.highlight <> 0 then highlight.high_desc else '' end as highlight
          from frontend_endedsale as endedsale
          left join item on item.itemid = endedsale.itemid
          left join frontend_highlights as highlight on highlight.highid = endedsale.highlight
          where (item.itemname like '%".$searchstring."%' or item.saleprice like '%".$searchstring."%' 
          or item.barcode like '%".$searchstring."%' or highlight.high_desc like '%".$searchstring."%')
          order by endedsale.dateend desc";

        $endeditems = Yii::$app->sbccommon->opentable($qry);  

        foreach ($endeditems as $key => $value) {
          if($value['dateend'] == date('Y-m-d')){
            $endeditems[$key]['endedtoday'] = 1;
          }else{
            $endeditems[$key]['endedtoday'] = 0;
          }//end if
        }//end for each

        return $endeditems;
    }//end function 

    public function getFBRBrandDetails($keyid){
      $qry = "select ifnull(ebrand.picture,'') as picture,md5(ebrand.brandid) as brandid,ebrand.brand_desc as brand,ebrand.isenabled as status from frontend_ebrands as ebrand 
      where md5(ebrand.brandid) = '".$keyid."'";
      return Yii::$app->sbccommon->opentable($qry);
    }//end function 


    //MODIFED FUNCTION BEFORE POSTING (ONLY FOR YULICK)
    public function checkQtyBeforePosting($trno){
      $qry = "select trno,line,barcode,isqty,isqty2 from lastock where trno = ".$trno."";
      $stockdata = Yii::$app->sbccommon->opentable($qry);
      $notbalance = array();
      $status = true;
      if(!empty($stockdata)){
          foreach ($stockdata as $key => $value) {
            if($value['isqty2'] < $value['isqty']){
              $status = false;
              $isqty = $value['isqty'];
              $isqty2 = $value['isqty2'];
              $barcode = $value['barcode'];
              $line = $value['line'];
              if(!empty($notbalance)){
                $notbaldata = array('line'=>$line,'barcode'=>$barcode,'cqty'=>$isqty2,'origqty'=>$isqty);
                $notbalance = array_merge($notbalance, [$line => $notbaldata]);  
              }else{
                $notbalance = [$line => array('line'=>$line,'barcode'=>$barcode,'cqty'=>$isqty2,'origqty'=>$isqty)];  
              }//end if not empty
            }//end if
          }//end function
      }else{
          $notbalance = '';
      }//end if empty

      return array('status'=>$status,'notbalanced'=>$notbalance);
    }//end function

    //FOR STOCK CARD COMPUTATION OF DISCOUNTED PRICE IN PERCENT
    public function computeFrontendDiscount($salesprice,$normalprice){
        
      if($normalprice != 0){
        if($normalprice == ''){
          $$normalprice = 0;
        }
        if($salesprice == ''){
          $salesprice = 0;
        }
        $discountpercentage = number_format(-1*((1 - ($salesprice / $normalprice)) * 100),1);
      }else{
        $discountpercentage = 100;
      }//end if
      return $discountpercentage . '%';
    }//end computer frontend discount

    public function retrieveFrontendOrder($searchstring,$status){
        $filterstatus = " and stock.fstatus = '".$status."'";

        if(!$searchstring == ''){
          $filter = " where num.fromfrontend = 1 and head.clientname like '%".$searchstring."%' ".$filterstatus." or 
          num.fromfrontend = 1 and stock.fstatus like '%".$searchstring."%' ".$filterstatus." or 
          num.fromfrontend = 1 and num.docno like '%".$searchstring."%' ".$filterstatus." or
          num.fromfrontend = 1 and stock.barcode like '%".$searchstring."%' ".$filterstatus." or
          num.fromfrontend = 1 and stock.itemname like '%".$searchstring."%' ".$filterstatus." or
          num.fromfrontend = 1 and stock.isamt like '%".$searchstring."%' ".$filterstatus." or
          num.fromfrontend = 1 and stock.isqty like '%".$searchstring."%' ".$filterstatus." ";
        }else{
          $filter = ' where num.fromfrontend = 1' . $filterstatus;
        }//end if

        $qry = "select head.clientname,stock.fstatus,num.trno,stock.line,num.docno,stock.barcode,
            stock.itemname,stock.isqty as qty,
            stock.isamt as amt from transnum as num
            left join sohead as head on head.trno = num.trno
            left join sostock as stock on head.trno = stock.trno" . $filter . " order by num.trno desc";

        return Yii::$app->sbccommon->opentable($qry);
    }//retrieve frontend order

    ############################## FRONTEND MANAGER UPDATE 10-05-2016
    public function uploadImage($files,$type,$params){
      try {
          if(isset($files['image'])){
              $errors= array();
              $file_name = $this->setFileNamingConvention($type,$params);
              $file_size =$files['image']['size'];
              $file_tmp =$files['image']['tmp_name'];
              $file_type=$files['image']['type'];   
              $file_ext=strtolower(end((explode('.',$files['image']['name']))));

              $expensions= array("jpeg","jpg","png");         
              if(in_array($file_ext,$expensions)=== false){
              $errors[]="extension not allowed, please choose a JPEG or PNG file.";
              }
              if($file_size > 5097152){
              $errors[]='Image must not be over 2MB of size.';
              }               
              
              $directory = Yii::$app->backend->setPictureDir($type,$params);
              if(empty($errors)==true){
                  
                  if (!file_exists($directory)) {
                      mkdir($directory, 0777, true);
                  }//end if file directory exist
                  $filedirectory = $directory.$file_name.".jpg";
                  move_uploaded_file($file_tmp,$filedirectory);
              }//end if no erros
          }//end if image2wbmp(image)
          $picdirectory = Yii::$app->homeUrl.$filedirectory;
          return array('src'=>$picdirectory,'dbpic'=>$picdirectory,'errors'=>$errors,'status'=>true);
      } catch (ErrorException $e) {
        echo $e; 
      }//end try catch
    }//end function upload image

    public function setFileNamingConvention($type,$params){
      switch ($type) {
        case 'LANESLIDER': case 'ITEMGALLERY': case 'CATSLIDER': case 'BRANDSLIDER': case 'BRANDLOGO':
          return $params['codeid'].'-'.$params['index'];
        break;

        case 'BANNERSLIDER':
          return "banner".$params['index'];
        break;

        case 'PRIMARY_STOCKCARD': case 'PRIMARY_BRAND': case 'PRIMARY_HIGHLIGHT': case 'HIGHLIGHT_BANNER': case 'LANEHEADER': 
        case 'DOD_BANNER': case 'PRIMARY_DOD': case 'PRIMARY_FLASHDEAL': case 'FLASHDEAL_BANNER':
          return $params['codeid'];
        break;

        case 'FRONTEND_LOGO':
          return 'logo';
        break;

        default:

        break;
      }//end switch case
    }//end function

    public function setPictureDir($type,$params){
      switch ($type) {
        case 'FRONTEND_LOGO':
          $dir = "fimages/logo/";
        break;

        case 'LANEHEADER':
          $dir = "fimages/laneheaders/";
        break;

        case 'PRIMARY_DOD':
          $dir = "fimages/dod/";
        break;

        case 'DOD_BANNER':
          $dir = "fimages/dod/banners/";
        break;

        case 'PRIMARY_FLASHDEAL': 
          $dir = "fimages/flashdeal/";
        break;
        
        case 'FLASHDEAL_BANNER':
          $dir = "fimages/flashdeal/banners/";
        break;

        case 'LANESLIDER':
          $dir = "fimages/lanesliders/".$params['codeid']."/";
        break;
        
        case 'CATSLIDER':
          $dir = "fimages/catsliders/".$params['codeid']."/";
        break;

        case 'ITEMGALLERY':
          $dir = "fimages/itemgallery/".$params['codeid']."/";
        break;

        case 'BANNERSLIDER':
          $dir = "fimages/bannersliders/";
        break;

        case 'BRANDSLIDER':
          $dir = "fimages/brand/brandslider/";
        break;

        case 'PRIMARY_BRAND':
          $dir = "fimages/brand/brandlogo/";
        break;

        case 'PRIMARY_STOCKCARD':
          $dir = "fimages/stockcard/";
        break;

        case 'PRIMARY_HIGHLIGHT':
          $dir = "fimages/highlights/";
        break;

        case 'HIGHLIGHT_BANNER':
          $dir = "fimages/highlight_banners/";
        break;

        default:

        break;
      }//END FUNCTION
      return $dir;
    }//end function setpicturedir

    public function setFrontendItemCategory($params){
      $qry = "update item set f_cattagging = ".$params['catid']." where itemid = ".$params['itemid']."";
      $status = Yii::$app->sbccommon->execqry($qry);
      if($status){
        $msg = "Frontend Item tagging updated!";
        $qrygettagging = "select cat.cat_desc,cat.catid from item 
        left join frontend_categories as cat on cat.catid = item.f_cattagging
        where item.itemid = ".$params['itemid']."";
        $tagging = Yii::$app->sbccommon->opentable($qrygettagging);

        $params = array('f_cattagging'=>$tagging[0]['catid']);
        $tagging = Yii::$app->frontend->generateBreadcrumbs('STOCKCARD',$params);
      }else{
        $msg = "Frontend Item tagging updating failed! Please try again!";
        $tagging = "";
      }//end if status

      return array('status'=>$status,'msg'=>$msg,'tagging'=>$tagging);
    }//end function

    public function retrieveLaneSliders($laneid){
      $sliderqry = "select ifnull(strimg,'') as strimg,line from frontend_laneslider where laneid = ".$laneid."";
      return $slider = Yii::$app->sbccommon->opentable($sliderqry);
    }//end function 

    public function retrieveCatSliders($catid){
      $sliderqry = "select ifnull(strimg,'') as strimg,line from frontend_catbanner where catid = ".$catid."";
      return $slider = Yii::$app->sbccommon->opentable($sliderqry);
    }//end function 

    public function retrieveBrandSliders($brandid){
      $sliderqry = "select ifnull(strimg,'') as strimg,line from frontend_brbanner where brandid = '".$brandid."'";
      return $slider = Yii::$app->sbccommon->opentable($sliderqry);
    }//end function 

    public function insertNewLane($params){
      $lane = $params['lane'];
        $isenabled = $params['isenabled'];  
        $qry = "insert into frontend_lanes (nav_desc,nav_tag,isparent,isenabled)
                values ('".$lane."','',1,".$isenabled.")";
        $status = Yii::$app->sbccommon->execqry($qry);

        if($status){
          $lanes = $this->retrieveLanes();
          $msg = "Lane successfully added!";
        }else{
          $msg = "Adding new Lane failed! Please try again.";
          $lanes = "";
        }//end function

        return array('lanes'=>$lanes,'msg'=>$msg,'status'=>$status);
    }//end function

     public function insertNewSubcat($params){
        $category = $params['category'];
        $isenabled = $params['isenabled'];  
        $parenttype = $params['parenttype'];
        $parentid = $params['parent'];
        $laneid = $params['laneid'];

        if($parenttype == "LANE"){
          $qry = "insert into frontend_categories (nav_parent,cat_desc,isparent,isenabled,parent)
                  values (".$parentid.",'".$category."',1,".$isenabled.",0)";
        }else{
          $qry = "insert into frontend_categories (nav_parent,cat_desc,isparent,isenabled,parent)
                  values (0,'".$category."',1,".$isenabled.",".$parentid.")";
        }//end parent type
        
        $status = Yii::$app->sbccommon->execqry($qry);

        if($status){
          $subcategory = $this->retrieveSubcategory($parenttype,$parentid);
              foreach ($subcategory as $key => $value) {
                  $qrylanetree = "insert into frontend_lanetree (catid,laneid) values(".$value['catid'].",".$laneid.")";
                  Yii::$app->sbccommon->execqry($qrylanetree);
              }//end function
          $msg = "Sub category  successfully added!";
        }else{
          $msg = "Adding new sub category failed! Please try again.";
          $lanes = "";
        }//end function

        return array('subcategory'=>$subcategory,'msg'=>$msg,'status'=>$status);
    }//end function

    public function retrieveLanes($isenabled = ''){
      $filter = "";
      if($isenabled != ''){
        $filter = ' where lanes.isenabled ='.$isenabled;
      }//end function
      $qry = "select lanes.navid,lanes.nav_desc,lanes.isparent,lanes.isenabled from frontend_lanes as lanes" .  $filter .' order by arrange_index';
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function retrieve lanes


    public function retrieveSubcategoryDetail($catid){
      $qry = "select catid,nav_parent,cat_desc,isenabled from frontend_categories where catid = ".$catid."";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function 

    public function retrieveSubcategory($type,$parent){
        switch ($type) {
            case 'LANE':
                $qry = "select cat.catid,cat.nav_parent as parentid,cat.cat_desc,cat.isparent,cat.isenabled,lanes.nav_desc as parentname 
                from frontend_categories as cat
                left join frontend_lanes as lanes on lanes.navid = cat.nav_parent
                where cat.nav_parent = ".$parent."
                order by cat.catid";
                break;
            
            case 'CATEGORY':
                $qry = "select cat.catid,cat.parent as parentid,cat.cat_desc,cat.isparent,cat.isenabled,parent.cat_desc as parentname
                from frontend_categories as cat
                left join frontend_categories as parent on parent.catid = cat.parent
                where cat.parent = ".$parent."
                order by cat.catid";
                break;
        }//END SWITCH CASE

        return $data = Yii::$app->sbccommon->opentable($qry);
    }//end retrieve subcategory
    ############################## FRONTEND MANAGER UPDATE 10-05-2016
    public function create_Elog($query){
      $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
      $qry = 'insert into execution_log (e_detail,date_executed,querystring) values("ERROR QUERY","'.$current_timestamp.'","'.$query.'")';
      Yii::$app->db->createCommand($qry)->query();
    }//end e log function 

    //JEAR SEPTEMBER 26
    public function getprefixes($doc){
        $qry = "select line,psection,pvalue from profile where doc='SED' and psection='$doc'";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getcompGroup(){
        $qry = "select distinct cgrp from company_prefixes order by cgrp asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function checkOngoingSchedule($project = ""){
      if($project == ""){
        $qry = "select count(sched_id) as counter from member_schedule where event_tagging = 'ONGOING'";
      }else{
        $qry = "select count(sched_id) as counter from member_schedule where project_tagging = ".$project." and event_tagging = 'ONGOING'";
      }//end if project == ""

      return $counter = Yii::$app->sbccommon->datareader($qry);
    }//end checkschedulecount
    ##################################### YULICK FUNCTIONS FOR INVOICING
    ##################################### YULICK FUNCTIONS FOR INVOICING
    ##################################### YULICK FUNCTIONS FOR INVOICING

    public function customerQTYOrderChecker($refx,$linex,$customerqty){
      $qry = "select iss-qa as bal from hsostock where trno = ".$refx." and line = ".$linex."";
      $sobal = Yii::$app->sbccommon->datareader($qry);

      if($customerqty > $sobal){
        return true;
      }else{
        return false;
      }//end if
    }//end function
    
    public function retainEncodedOrderQuantity($params){
      /*$qry = "update lastock set isqty = ".$params['isqty']." , isqty2 = ".$params['isqty2'].",
      iss= ".$params['iss'].",iss2 = ".$params['iss2']."
      where trno = ".$params['trno']." and line = ".$params['line']."";*/
      $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
      Postock::resetQuantity($params['line'], $params['trno'], 'SJ2');
      Postock::setserveditems($params['linex'],$params['refx'], 'SJ2');
      Lastock::deletecosting($params['trno'], $params['line']);
      $grandtotal = Lastock::getgrandtotal($params['trno'], 'SJ');
      $status = Yii::$app->sbccommon->execqry("update hsostock set isqty=0,iss=0,ext=0,editby='COMPUTER',
      editdate='".$current_timestamp."' where trno=".$params['trno']." and line=".$params['line']."");
      
      return array('status'=>$status,'grandtotal'=>$grandtotal);
    }//end function
    
    ##################################### END YULICK FUNCTIONS FOR INVOICING

    public function getDefaultEwt($trno){
     $qry = 'select ewt,ewtrate from lahead as head where head.trno='.$trno;
     return Yii::$app->sbccommon->openTable($qry);
    }//end f

    public function savingStockLooping($controller,$arrayvalues){
      try {
        $transposted = false;
        foreach ($arrayvalues as $key => $postvalues) {
          $postvalues = Yii::$app->backend->sanitize($postvalues,'ARRAY');
          if($this->checkDataIfPosted($postvalues['trno'],$controller->module->id)){
            $transposted = true;
            
            //Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['istransposted'=>true];
            //echo json_encode(array('istransposted'=>true));
          }else{
            $returnstockline = Yii::$app->webprocess->savingstock($controller,$controller->access['save'],$postvalues);
            $return['stockline'][$key] = $returnstockline;
          }
        }

        if(!$transposted) { 
          //Yii::$app->response->format = Response::FORMAT_JSON;                    
          return $return;
          //echo json_encode($return); 
        }
      } catch (ErrorException $e) {
        echo $e;
      }
    }


    public function savingDetailLooping($controller,$arrayvalues){
      $transposted = false;
      try{
        foreach ($arrayvalues as $key => $postvalues) {
          $postvalues = Yii::$app->backend->sanitize($postvalues,'ARRAY');        
          
          //CHECKS IF TRANSACTION IS POSTED BEFORE SAVING ANY ITEMS
          if($this->checkDataIfPosted($postvalues['trno'],$controller->module->id)){
            $transposted = true;
            //Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['istransposted'=>true];
            //echo json_encode(array('istransposted'=>true));
            break;
          }else{
            $returndetailline = Yii::$app->webprocess->savingdetail($controller,$controller->access['save'],$postvalues);
            //var_dump($returndetailline);
            $return['stockline'][$key] = $returndetailline;
          }//end if trans posted
        }//end for each

        //THIS WILL ONLY BE EXECUTED IF TRANSACTION IS NOT POSTED
        if(!$transposted){
          //Yii::$app->response->format = Response::FORMAT_JSON;          
          return $return;
          //echo json_encode($return);
        }//end if
      }catch (ErrorException $e){
        echo $e;
        return 0;
      }//end catch
    }//end function savingstock looping
    
   
    //################ UPDATE ANNOUNCEMENTS
    public function getAnnouncementListing(){
      $qry = "select anon.anonid,uaccess.name as createdby,uaccess.userid,
      anon.anon_desc as description,anon.anon_title as title,
      date(anon.createdate) as createdate,anon.date1,anon.date2
      from scheduler_anon as anon
      left join useraccess as uaccess on uaccess.userid = anon.userid
      where anon.userid = ".Yii::$app->session['loggeduser']['userid']."
      order by anon.anonid desc";
      return $qry;
      // return $anons = Yii::$app->sbccommon->opentable($qry);
    }//end function

     //################ UPDATE ANNOUNCEMENTS
    public function getReminderListing(){
      $qry = "select reminder.reminderid,uaccess.name as createdby,uaccess.userid,
      reminder.reminder_desc as description,reminder.reminder_title as title,
      reminder.createdate,reminder.date1,reminder.date2
      from scheduler_reminder as reminder
      left join useraccess as uaccess on uaccess.userid = reminder.userid
      where reminder.userid = ".Yii::$app->session['loggeduser']['userid']."
      order by reminder.reminderid desc";
      return $qry;
      // return $anons = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getActiveAnnouncement(){
      $qry = "select * from scheduler_anon
      where date1 <= now() and date2 > now()
      order by anonid desc";

      return $anons = Yii::$app->sbccommon->opentable($qry);
    }//end function 
    //################ UPDATE ANNOUNCEMENTS


    public function getActiveReminders(){
      $qry = "select * from scheduler_reminder
      where date1 <= now() and date2 > now()
      and userid = ".Yii::$app->session['loggeduser']['userid']."
      order by date1 desc";

      return $anons = Yii::$app->sbccommon->opentable($qry);
    }//end function 

    public function setDocPrefixLog($desc){
      $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
      $qry = "insert into docprefix_log (log_description,userid,logdate) 
      values('".$desc."',".Yii::$app->session['loggeduser']['userid'].",'".$current_timestamp."')";
      Yii::$app->sbccommon->execqry($qry);
    }//end function

    //KEYWORD LOCATION&VENDOR
    public function searchlocations($controller,$access,$searchstring){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF VIEW ACCESS IS NOT AVAILABLE
        }else{
            return $data = $this->locationSearch($searchstring);
        }//END ACCESS VALIDATION
    }//END SEARCH WAREHOUSE
    //KEYWORD LOCATION&VENDOR

    public function setLeftSideMenu($moduleid){
      if(isset(Yii::$app->session['loggeduser'])){
        $menuaccess = Yii::$app->session['loggeduser']['access'];
      }else{
        $menuaccess = "";
      }//end if

      $parent="";  
      $menu="";
        foreach (Yii::$app->session['menu'] as $itmindex[0] => $itmdata) {
          //##### FOR CHILD MENUS
          if($parent==$itmdata['name']){
            here:
              
              if($menuaccess[$itmdata['access']] == 1){
                if($itmdata['ismodalmenu'] == '1'){
                  $menu = $menu."<li class='".$itmdata['modalclass']."'><a class='clickable'><i class='".$itmdata['mclass']."'></i> ".$itmdata['module']."</a></li>";
                }else{
                    $menu = $menu."<li class='";
                    if($moduleid == $itmdata['doc']){ $menu = $menu.'active'; }
                    $menu=$menu."'><a href='".Url::to([$itmdata['url']])."'><i class='".$itmdata['mclass']."'></i> ".$itmdata['module']."</a></li>";
                }//end if
              }
              //end if($menuaccess[$itmdata['access']] == 1){
          }else{//end if($parent==)
            if($menu!=""){
                $menu = $menu."</ul>";
                //$menu = $menu."</li>";
                echo $menu;
                $menu="";//ECHO ROWS OF MENU PER PARENT 
            }//end uf
          //##### FOR PARENT MENUS
            $parent=$itmdata['name'];
            $menu=$menu."<li class='";

            $waw = explode(',',$itmdata['pdoc']);
            
            if(array_search($moduleid, $waw)) {
              $menu=$menu."active treeview fixed'>"; 
            } else {
              $menu=$menu."treeview fixed'>";
            }//end if

            /*if(stripos($itmdata['pdoc'],','.$moduleid)!==false){
               $menu=$menu."active treeview fixed'>"; 
            }else{
              $menu=$menu."treeview fixed'>";
            }//end if(stripos($itmdata['pdoc'],','.$moduleid)!==false){*/

            $menu = $menu."<a href='#'>"; 
            $menu = $menu."<i class='fa fa-angle-right'></i>&nbsp<i class='".$itmdata['pclass']."'></i><span>".$parent."</span></a>";
            $menu = $menu."<ul class='treeview-menu'>";
            $fromparent = 1;
            goto here;
            }//end else
        }///end foreach

        $menu = $menu."</ul>";
        $menu = $menu."</li>";

        echo $menu;
        echo '<li class="treeview">
        <a href="'.Url::to(['/reportlist/default/index']).'"><i class="reportlist_ico fa fa-list"></i> 
        <span>&nbsp&nbsp&nbsp&nbsp REPORT LIST</span></a>
        </li>';

        if(Yii::$app->session['loggeduser']['branch_access'] == 1){
          echo '<li class="treeview">
          <a href="'.Url::to(['/branchmasterfile/index']).'"><i class="productions_sub_ico fa fa-list"></i> 
          <span>&nbsp&nbsp&nbsp&nbsp BRANCH MASTERFILE</span></a>
          </li>';
        }//FOR MENU ACCESS PO

        if(Yii::$app->systemsettings->companyConfig() == "YULICK"){ //ADDING COMPANY PREFIX UTILITY FOR PARANAQUE
          echo '<li class="treeview">
          <a href="'.Url::to(['/comprefix/index']).'"><i class="fa fa-institution productions_sub_ico fa fa-list"></i> 
          <span>&nbsp&nbsp&nbsp&nbsp COMPANY PREFIXES</span></a>
          </li>';
        }//FOR MENU ACCESS PO
    }//end function
    

    public function setSchedulerLog($desc){
      try {
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
        $qry = "insert into schedule_logs (log_description,userid,logdate) 
        values('".$desc."',".Yii::$app->session['loggeduser']['userid'].",'".$current_timestamp."')";
        Yii::$app->sbccommon->execqry($qry);
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end function

    public function getSchedulerLogs(){
      $qry = "select scheduler.logid,scheduler.log_description,scheduler.userid,scheduler.logdate,
                'SCHEDULER' as level,uacc.username
                from schedule_logs as scheduler
                left join useraccess as uacc on uacc.userid = scheduler.userid
                where scheduler.userid = ".Yii::$app->session['loggeduser']['userid']."
                order by scheduler.logid desc";
      return $logs = Yii::$app->sbccommon->opentable($qry);
    }//end function


    public function getdocPrefixLogs(){
      $qry = "select scheduler.logid,scheduler.log_description,scheduler.userid,scheduler.logdate,
                'PREFIXES' as level,uacc.username
                from docprefix_log as scheduler
                left join useraccess as uacc on uacc.userid = scheduler.userid
                where scheduler.userid = ".Yii::$app->session['loggeduser']['userid']."
                order by scheduler.logid desc";
      return $logs = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveSchedulerNotifications(){
      $qry = "select member_notification.notifid,toview.username as usertoview,
      member_notification.notificationtype,member_notification.isread,
      uacc.username,scheds.sched_seq from member_notification
      left join useraccess as uacc on uacc.userid = member_notification.userid
      left join useraccess as toview on toview.userid = member_notification.usertoview
      left join member_schedule as scheds on scheds.sched_id = member_notification.schedid
      where member_notification.userid = ".Yii::$app->session['loggeduser']['userid']." and isread = 0
      group by member_notification.schedid";
      return $notifications = Yii::$app->sbccommon->opentable($qry);
    }//end function 

    // WTODO JAD 06-03-2019
    public function getFilteredSchedules($params) {
      if($params['schedtype'] == "") {
        $schedfilter = "";
      } else {
        switch ($params['schedtype']) {
          case 'FINISHED': case 'CANCELLED': case 'ONGOING':
            $schedfilter = "event_tagging = '".$params['schedtype']."' ";
          break;
          case 'UNPLOTTED':
            $schedfilter = "isplotted = 0 ";
          break;
        }//end switch
      }//end if
      if($params['schedtype'] == 'UNPLOTTED') {
        $date1 = $date2 = "";
      } else {
        if($params['date1'] == "") {
          $date1 = "";
        } else {
          $date1 = " and date1 >= '".$params['date1']."' and date2 >= '".$params['date1']."' ";
        }//end if

        if($params['date2'] == "") {
          $date2 = "";
        } else {
          $date2 = " and date1 <= '".$params['date2']."' and date2 <= '".$params['date2']."' ";
        }//end if
      }

      if(empty($params['userid'])) {
        $userfilter = "member_schedule.userid =".$params['userid']." ";
        if($params['schedtype'] != "") {
          $schedfilter = " and " . $schedfilter;
        }//end if
        $qry = "select uacc.username,uacc.name,client.clientname,sched_id,sched_type,sched_desc,date1,date2,isplotted,
        sched_seq,member_schedule.createdate,member_schedule.event_tagging from member_schedule
        left join client on client.clientid = member_schedule.clientid
        left join useraccess as uacc on uacc.userid = member_schedule.userid
        where sched_seq <> ''" . $schedfilter . $date1 . $date2. ' 
        order by member_schedule.date1';
      } else {
        if($params['userid'] == "") {
          $userfilter = "";
        } else {
          $userfilter = "member_schedule.userid =".$params['userid']." ";
          if($params['schedtype'] != "") {
            $schedfilter = " and " . $schedfilter;
          }//end if
        }//end if

        $qry = "select uacc.username,uacc.name,client.clientname,sched_id,sched_type,sched_desc,date1,date2,isplotted,
        sched_seq,member_schedule.createdate,member_schedule.event_tagging from member_schedule
        left join client on client.clientid = member_schedule.clientid
        left join useraccess as uacc on uacc.userid = member_schedule.userid
        where ".$userfilter . $schedfilter . $date1 . $date2 . '
        order by member_schedule.date1';
      }//end if
      return $scheddata = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveTimeIn($params){
      if($params['timetype'] == ""){
        $typefilter = "";
      }else{
        if($params['timetype']== "APPROVED"){
          $typefilter = " and approvedby <> '' and approvaldate <> '' ";
        }else{
          $typefilter = " and approvedby = '' and approvaldate = '' ";
        }//end if
      }//end if

      if($params['dateid'] == ""){
        $datefilter = "";
      }else{
        $datefilter = " and date <= left(now(),10) and date >= '".$params['dateid']."' ";
      }//end if


      if(empty($params['userid'])){
        $qry = "select logid,timein,timeout,member_timein.userid,date as datelog,uacc.name,uacc.username 
        from member_timein
        left join useraccess as uacc on uacc.userid = member_timein.userid
        where member_timein.userid <> ''" . $typefilter . $datefilter;
      }else{
        $qry = "select logid,timein,timeout,member_timein.userid,date as datelog,uacc.name,uacc.username from member_timein
        left join useraccess as uacc on uacc.userid = member_timein.userid
        where member_timein.userid = ".$params['userid']."" . $typefilter . $datefilter;
      }//end if

      return $timedata = Yii::$app->sbccommon->opentable($qry);
    }//end function
    
    public function generateCustomerCharges(){ //INFINITEA [FOR GENERATING OF CUSTOMER CHARGES MONTHLY]
      $qry1 = 'select client,charge1,charge2,terms from client where iscustomer = 1 and charge1 <> 0 or iscustomer = 1
      and charge2 <> 0 order by client';
      $customers = Yii::$app->sbccommon->opentable($qry1);

      if(!empty($customers)){

      }else{

      }//end if
    }//end function

    //JAC 2016.08.20

  public function comparegenitemlines($controller,$data){
      $doc = $controller->module->id;
      $bcode = $data['bcode'];    
      $ischanged = 0;
      $genitem = Yii::$app->sbccommon->opentable("select line,bcode,itemdesc,itembrand,itempart,itemuom,itemshortname,itemgroup,itemcolor,itemmodel,itemclass,itemsize from generalitem where bcode = '$bcode'");
      

        if($genitem[0]['itemdesc'] == $data['itemdesc'] && $genitem[0]['itemshortname'] == $data['itemshortname'] && $genitem[0]['itemuom'] == $data['itemuom'] &&  $genitem[0]['itembrand'] == $data['itembrand'] &&  $genitem[0]['itemcolor'] == $data['itemcolor'] &&  $genitem[0]['itemgroup'] == $data['itemgroup'] &&  $genitem[0]['itempart'] == $data['itempart'] &&  $genitem[0]['itemmodel'] == $data['itemmodel'] &&  $genitem[0]['itemclass'] == $data['itemclass'] &&  $genitem[0]['itemsize'] == $data['itemsize']){
                  $ischanged = 0;
                }else{
                    $ischanged = 1;
                }//END IF
       
        return array('ischanged' => $ischanged,'genitem'=>$genitem);

    }

//END GENITEM

//jac  pdc
    public function retrieveSelectedpdcChecks($ccode,$params){
        foreach ($params as $key => $value) {
         $data[$key] = $this->retrievepdcdata($ccode,$params[$key]['line']);
        }//END FOR EACH
        
        return $data;
    }//END RETRIEVESELECTED

    private function retrievepdcdata($ccode,$line){
      $qry = "select *,(select acno from coa where alias ='cr1')  as acno,(select acnoname from coa where alias ='cr1') as acnoname from hPostdatedchecks where line = $line";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end postdated retrieve

    public function postpdcChecks($params){
       $pdc= new Postdatedchecks;
     
        foreach ($params as $key => $value) {
          $pdc->postpdc($params[$key]['line']);
        }//END FOR EACH
        
    }//END postpdc

    public function comparepdclines($controller,$data){
      $doc = $controller->module->id;
      $line = $data['line'];
      $ischanged = 0;
      $amount = number_format(str_replace(",","",$data['amount']),4);
      $pdcdata = $this->returnPdcline($controller,$line);
      
        if($pdcdata[0]['client'] == $data['client'] && $pdcdata[0]['checkno'] == $data['checkno'] && number_format($pdcdata[0]['amount'],4) == $amount && $pdcdata[0]['checkdate'] == $data['checkdate'] && $pdcdata[0]['notes'] == $data['notes']){
            $ischanged = 0;
        }else{
            $ischanged = 1;
        }//END IF
      return array('ischanged' => $ischanged,'pdcdata'=>$pdcdata);
  }//END PDC LINES

  public function returnPdcline($controller,$line){
    $doc = $controller->module->id;
    $model = new Postdatedchecks;   
    return $model->openPDCline($controller,$line);
  }//end return pdclines

  public function comparetaxmenulines($controller,$data){
    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    
    $termsdata = Yii::$app->sbccommon->openTable("select line,name,atc,rate from taxmenu where line = $line");


      if($termsdata[0]['name'] == $data['name'] && $termsdata[0]['atc'] == $data['atc'] && $termsdata[0]['atc'] == $data['rate'] ){
        $ischanged = 0;
      }else{
        $ischanged = 1;
      }//END IF

      return array('ischanged' => $ischanged,'termsdata'=>$termsdata);

  }

  public function comparetermslines($controller,$data){
    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    
    $termsdata = Yii::$app->sbccommon->openTable("select line,terms,days from terms where line = $line");


      if($termsdata[0]['terms'] == $data['terms'] && $termsdata[0]['days'] == $data['nodays'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'termsdata'=>$termsdata);

  }
  

//end jac pdc

    public function getContraPartnerbasedOnSalestype($stype){
      switch ($stype) {
        case 'CASH':
          $alias = 'CA1';
          break;
        case 'CHARGE':
          $alias = 'AR1';
          break;
        case 'CHECK': case 'DEPOSIT':
          $alias = 'CR1';
          break;
      }//END FUNCTION

      $qry = "select acno,acnoname from coa where alias = '".$alias."'";
      $contra = Yii::$app->sbccommon->opentable($qry);

      if(empty($contra)){
        return array('contra'=>'','status'=>0,'msg'=>'COA Table doesn`t have Account with ' . $alias . ' alias.');
      }else{
        return array('contra'=>$contra,'status'=>1,'msg'=>'');
      }//end else
    }//end function

    
    public function voidItem($doc,$trno,$line,$voidval,$approvedby){
      try {
          $table=Common::localhstock($doc);
          //COMPARES QTY AND QA
          switch ($doc) {
            case 'SO': case 'quotation': case 'PO': case 'TR': case 'PR':
                $logdoc = $doc; 
                if($doc == 'SO'){
                  $qry = "select void,$table.barcode,".$table.".iss,qa,
                  round(($table.iss - $table.qa) / uom.factor,
                  ".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal from $table
                  left join item on item.barcode = $table.barcode
                  left join uom on uom.itemid = item.itemid
                  where trno = ".$trno." and $table.line = ".$line."";
                  $itmdata=Yii::$app->sbccommon->opentable($qry);
                  
                  if($itmdata[0]['void'] == 1 && $voidval == 1){
                    $msg = 'This is already voided, Please refresh data!';
                    $isserved = 1;
                  }else{
                    if($itmdata[0]['iss'] == $itmdata[0]['qa']){
                      $isserved = 1;
                    }else{
                      $isserved = 0;
                    }//end if
                  }//end if void
                }else{
                  $qry = "select void,$table.barcode,".$table.".qty,qa,
                  round(($table.qty - $table.qa) / uom.factor,
                  ".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal from $table
                  left join item on item.barcode = $table.barcode
                  left join uom on uom.itemid = item.itemid
                  where trno = ".$trno." and $table.line = ".$line."";
                  
                  $itmdata=Yii::$app->sbccommon->opentable($qry);

                  
                  if($itmdata[0]['void'] == 1 && $voidval == 1){
                      $msg = 'This is already voided, Please refresh data!';
                      $isserved = 1;
                  }else{
                    if($itmdata[0]['qty'] == $itmdata[0]['qa']){
                      $msg = 'All qty is already served.';
                      $isserved = 1;
                    }else{
                      $isserved = 0;
                    }//end if
                  }//end if void
                }//end if

                //CHECKS IF IT IS SERVED OR NOT , IF NOT VOIDS ITEM
                if($isserved == 1){
                  $status = 0;
                }else{
                  $status = Yii::$app->sbccommon->execqry("update $table set void=".$voidval." where trno='$trno' and line=".$line."");
                }//end if
            break; 
            
            case 'SJ': case 'RR': case 'SJ2':
                if($doc == 'SJ' || $doc == 'SJ2'){
                  $table = 'hsostock';
                  $qty = 'iss';
                  $logdoc = 'SO';
                }else{
                  $table = 'hpostock';
                  $qty = 'qty';
                  $logdoc = 'PO';
                }//end if

                if($line == 0){
                  $status = Yii::$app->sbccommon->execqry("update $table set void=".$voidval." where trno='$trno'");
                }else{
                  $qry = "select void,$table.barcode,round(($table.$qty - $table.qa) / uom.factor,
                          ".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal from $table
                          left join item on item.barcode = $table.barcode
                          left join uom on uom.itemid = item.itemid
                          where trno = ".$trno." and $table.line = ".$line."";
                  $itmdata=Yii::$app->sbccommon->opentable($qry);
                  $status = Yii::$app->sbccommon->execqry("update $table set void=".$voidval." where trno='$trno' and line=".$line."");
                }//end function
            break;
          }//END SWITCH

        if($status == 1){
          if($voidval){
            $msg = 'Voiding item successfull!';
            $voiddetails = $itmdata[0]['barcode'] . '=>Balance: ['.$itmdata[0]['bal'].'] | ' . 'Line: ['.$line.']';
            Log::writelog($logdoc, $trno,"VOID ITEM=>APPROVAL=>" . $approvedby ,$voiddetails,Yii::$app->session['loggeduser']['username']);
          }else{
            $msg = 'Unvoiding item successfull!';
            $voiddetails = $itmdata[0]['barcode'] . '=>Balance: ['.$itmdata[0]['bal'].'] | ' . 'Line: ['.$line.']';
            Log::writelog($logdoc, $trno,"UNVOID ITEM=>APPROVAL=>" . $approvedby ,$voiddetails,Yii::$app->session['loggeduser']['username']);
          }//end if void val
        }else{
          if(isset($msg) && $msg != ''){

          }else{
            $msg = 'Error voiding this item , please check transaction';
          }//end if msg
        }//endfunction
        return array('status'=>$status,'msg'=>$msg,'trno'=>$trno,'line'=>$line);
      } catch (ErrorException $e) { ######### START CATCHING
          //echo json_encode($e);
      }//end try catch
    }//end function 

    public function memberHasTimeinToday(){
      $qry = "select logid from member_timein where date = left(now(),10) and userid = ".Yii::$app->session['loggeduser']['userid']."";
      $count = Yii::$app->sbccommon->datareader($qry);
        if(empty($count)){
          return true;
        }else{  
          return false;
        }//end function
    }//end function 

    public function memberScheduleTimein(){
        $timenow = Yii::$app->backend->getLocalTime();
        $qry = "insert into member_timein (timein,userid,date) values('".$timenow."',".Yii::$app->session['loggeduser']['userid'].",left(now(),10))";
        $status = Yii::$app->sbccommon->execqry($qry);
        return $status;
    }//end function

    public function getcompanyprefix(){ //JR
      return Yii::$app->sbccommon->openTable("select line,companyname,availprefs,companyalias from company_prefixes order by line");
    }//end function

    // COMPANY GROUP
    public function getcompanyprefixgroup(){ //JR
      return Yii::$app->sbccommon->openTable("select line,companyname,availprefs,companyalias,cgrp from company_prefixes order by line");
    }//end function

    

    public function requestCompanyPrefixes(){
      $qry = "select * from company_prefixes";
      return $return = Yii::$app->sbccommon->opentable($qry);
    }//end function


    public function searchComputeinv($controller,$access,$clientid,$date,$filter) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        $center=Yii::$app->session['loggeduser']['center'];
          return "select * from (
          select `glhead`.`trno` as `trno`,`glhead`.`doc` as `doc`,`glhead`.`clientid` as `clientid`,
          `glhead`.`docno` as `docno`,left(`glhead`.`dateid`,10) as `dateid`,
          `item`.`barcode` as `barcode`,`glstock`.`itemname` as `itemname`,`glstock`.`uom` as `uom`,
          `glstock`.`disc` as `disc`,`glstock`.`cost` as `cost`,`glstock`.`isamt` as `isamt`,
          `glstock`.`isqty` as `isqty`,`glstock`.`rrqty` as `rrqty`,glstock.loc as `loc`,
          client.client,client.clientname,client.addr,client.tel,client.email,client.tin,
          client.mobile,client.contact,client.rem,client.fax
          from ((`glstock` 
          left join `glhead` on((`glstock`.`trno` = `glhead`.`trno`)))
          left join `item` on((`item`.`itemid` = `glstock`.`itemid`)))
          left join client on client.clientid = glhead.clientid
          left join cntnum on cntnum.trno = glhead.trno
          where (`glhead`.`doc` in ('rr','dm','sj','cm','aj','cf','pu','cs','es','er')) 
          and client.clientid =$clientid and glhead.dateid >= '$date' and cntnum.center ='$center' 
          and (glhead.docno like '%".$filter."%' or glhead.dateid like '%".$filter."%' or item.itemname like '%".$filter."%' or item.barcode like '%".$filter."%' or glstock.uom like '%".$filter."%')
          UNION ALL
          select `lahead`.`trno` as `trno`,`lahead`.`doc` as `doc`,`client`.`clientid` as `clientid`,
          `lahead`.`docno` as `docno`,left(`lahead`.`dateid`,10) as `dateid`,`lastock`.`barcode` as `barcode`,
          `lastock`.`itemname` as `itemname`,`lastock`.`uom` as `uom`,`lastock`.`disc` as `disc`,
          `lastock`.`cost` as `cost`,`lastock`.`isamt` as `isamt`,`lastock`.`isqty` as `isqty`,lastock.rrqty as `rrqty`,lastock.loc as `loc`,
          client.client,client.clientname,client.addr,client.tel,client.email,
          client.tin,client.mobile,client.contact,client.rem,client.fax
          from ((`lastock` 
          left join `lahead` on((`lastock`.`trno` = `lahead`.`trno`)))
          left join `client` on((`client`.`client` = `lahead`.`client`))) 
          left join cntnum on cntnum.trno = lahead.trno
          where lahead.doc in ('rr','dm','sj','cm','aj','cf','pu','cs','es','er')
          and client.clientid =$clientid and lahead.dateid >= '$date' and cntnum.center ='$center'
          and (lahead.docno like '%".$filter."%' or lahead.dateid like '%".$filter."%' or lastock.itemname like '%".$filter."%' or lastock.barcode like '%".$filter."%' or lastock.uom like '%".$filter."%')
          ) as tbl order by dateid desc";
      }
    }

    public function requestClientView($userid,$type){
      switch ($type) {
        case 'ALLOWED':
          $qry = "select ".$userid." as userid,customer.clientname,customer.clientid,customer.client
          from sched_allowedcustomer as allowed
          left join client as customer on customer.clientid = allowed.clientid
          where allowed.userid=".$userid." order by customer.clientname";
          break;

        case 'NALLOWED':
          $qry = "select ".$userid." as userid,customer.clientname,customer.clientid,customer.client from client as customer
          where clientid not in(select clientid from sched_allowedcustomer where sched_allowedcustomer.userid=".$userid.")
          and iscustomer = 1  order by customer.clientname";
          break;
      }///END SWITCH CASE 
      return $return = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function viewcostAccess(){
      $loggeduser = Yii::$app->session['loggeduser'] ?? null;
      if (!is_array($loggeduser) || !isset($loggeduser['access'][368])) {
        return false;
      }
      return $loggeduser['access'][368];
    }//end viewcostaccess

    public function getLocalTime(){
      Yii::$app->systemsettings->setDefaultTimeZone();
      $date = new \DateTime(date('h:i:s A'), new \DateTimeZone('Asia/Singapore'));
      return $date->format('h:i:s A');
      /*$qry = "select TIME_FORMAT(date_sub(now(), INTERVAL 12 MINUTE),concat('%h',':','%i',' %p')) as datex";
      return $count = Yii::$app->sbccommon->datareader($qry);*/
    }//end function 

    public function checkClientTransactions($clientcode){
        $qry = "select count(trno) as transaction from(
        select trno from sohead where client = '".$clientcode."'
        union all
        select trno from pohead where client = '".$clientcode."'
        union all
        select trno from pihead where client = '".$clientcode."'
        union all
        select trno from pdhead where client = '".$clientcode."'
        union all
        select trno from pchead where client = '".$clientcode."'
        union all
        select trno from hsohead where client = '".$clientcode."'
        union all
        select trno from hpohead where client = '".$clientcode."'
        union all
        select trno from hpihead where client = '".$clientcode."'
        union all
        select trno from hpdhead where client = '".$clientcode."'
        union all
        select trno from hpchead where client = '".$clientcode."'
        union all
        select trno from lahead where client = '".$clientcode."'
        union all
        select trno from glhead
        left join client on client.clientid  = glhead.clientid
        where glhead.doc NOT IN('DS')
        and client.client = '".$clientcode."') as tbl";

        return $count = Yii::$app->sbccommon->datareader($qry);
    }//end function check client transaction

    public function checkCOAalias(){
      $qry = "select 'SA' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='SA'
              union all
              select 'IS' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='IS'
              union all
              select 'IN' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='IN'
              union all
              select 'AR' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='AR'
              union all
              select 'AP' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='AP'
              union all
              select 'CA' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CA'
              union all
              select 'CR' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CR'
              union all
              select 'CB' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CB'
              union all
              select 'TX' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='TX'
              union all
              select 'SD' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='SD'
              union all
              select 'SR' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='SR'
              union all
              select 'CG' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CG'
              union all
              select 'PD' as alias,'---' as type,'---' as acno,'---' as acnoname
              union all
              select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='PD'";
      return $return = Yii::$app->sbccommon->opentable($qry);        
    }//end function

  

    //function used to check if a stock or detail table has rows or not
    public function hasDataRows($trno,$table){
      switch ($table) {
        case 'spstock':
          $qry = 'select count(sptrno) as count from '.$table.' where sptrno = '.$trno.'';
          break;
        
        default:
          $qry = 'select count(trno) as count from '.$table.' where trno = '.$trno.'';
          break;
      }//end switch case
      
      $count = Yii::$app->sbccommon->datareader($qry);

      if($count == 0){
        $booleanity = false;
      }else{
        $booleanity = true;
      }//end

      return $booleanity;
    }//end function

    public function retrievePriceHistory($doc,$barcode,$ccode){
      switch($doc){
        case 'SJ':
        $qry = "select clientname,trans.docno,left(trans.dateid,10) as dateid,
        round(trans.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round(trans.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,trans.disc,
        round(trans.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,loc,expiry from
        (select head.docno,head.dateid,head.client,head.clientname,stock.barcode,stock.itemname,stock.isqty,
        stock.isamt,stock.disc,stock.ext,stock.expiry,stock.loc
        from lahead as head left join lastock as stock on stock.trno=head.trno
        where head.doc='SJ' and head.client='".$ccode."' and stock.barcode='".$barcode."'
        union all
        select head.docno,head.dateid,client.client,head.clientname,item.barcode,stock.itemname,stock.isqty as qty,
        stock.isamt ,stock.disc,stock.ext,stock.expiry,stock.loc
        from glhead as head left join glstock as stock on stock.trno=head.trno
        left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
        where head.doc='SJ' and client.client='".$ccode."' and item.barcode='".$barcode."') as trans 
        order by trans.dateid desc limit 10";
        break;

        default:
        $qry = "select clientname,trans.docno,left(trans.dateid,10) as dateid,
        round(trans.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round(trans.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,trans.disc,
        round(trans.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,loc,expiry from 
        (select head.docno,head.dateid,head.client,head.clientname,stock.barcode,stock.rrqty,
        stock.rrcost,stock.disc,stock.ext,stock.loc,stock.expiry
        from lahead as head left join lastock as stock on stock.trno=head.trno
        where head.doc='RR' and head.client='".$ccode."' and stock.barcode='".$barcode."'
        union all
        select head.docno,head.dateid,client.client,head.clientname,item.barcode,stock.rrqty,stock.rrcost as amt,
        stock.disc,stock.ext,stock.loc,stock.expiry
        from glhead as head left join glstock as stock on stock.trno=head.trno
        left join client on client.clientid=head.clientid left join item on item.itemid=stock.itemid
        where head.doc='RR' and client.client='".$ccode."' and item.barcode='".$barcode."') as trans 
        order by trans.dateid desc limit 10";
        break;
      }//end switch case

      return $return = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getWallpaper(){
      try{
        $qry = "select picture from itimages where filename = 'WALLPAPER'";
        return $wallpaper = Yii::$app->sbccommon->datareader($qry);
      }catch (\Exception $e){
        var_dump($e);
        return 0;
      }//end catch
      
    }//end wallpaper

    public function retrieveThemes(){
      $qry = "select * from themelist";
      return $return = Yii::$app->sbccommon->opentable($qry);
    }//return themes

    public function retrieveProductionOrderDetails($trno){
      $qry = "select stock.trno,stock.line,head.docno,stock.barcode,stock.itemname,stock.rrqty,stock.uom,stock.qty,stock.rrcost,stock.cost,stock.iss,stock.ext,stock.rem,stock.disc,stock.loc,'' as expiry,head.docno as ref,stock.wh as whcode from hpdhead as head
      left join hpdstock as stock on stock.trno = head.trno where head.trno = ".$trno."";

      return $details = Yii::$app->sbccommon->opentable($qry);
    }//emd function retrieveproductionorder
    
    public function retrieveInstructionDetails($instruction,$trno,$params){
        $updatehead = "delete from pdstock where trno = ".$trno."";
        Yii::$app->sbccommon->execqry($updatehead);
        //selecting from HPISTOCK
        $qry = "select head.client as barcode,
        head.clientname as itemname,'".$params['uom']."' as uom,'".$params['wh']."' as wh,0 as disc,'' as rem,
        0 as cost,".$params['qty']." as rrqty,0 as rrcost,".$params['qty']." * ".$params['factor']." as qty,0 as iss,0 as void,0 as ext,0 as qa,0 as refx ,0 as linex , '' as ref,
        CURRENT_TIMESTAMP as encodeddate,'sbc' as encodedby,CURRENT_TIMESTAMP as editdate,'' as editby,'' as sku, '' as loc
        from hpihead as head where head.docno = '".$instruction."'
        UNION ALL
        select stock.barcode,
        stock.itemname,stock.uom,stock.wh,stock.disc,stock.rem,stock.cost,concat('-',(stock.rrqty * ".$params['qty'].")) as rrqty,
        stock.rrcost,0 as qty,(stock.qty * ".$params['qty'].") as iss, 0 as void, stock.ext, 0 as qa,0 as refx , 0 as linex , '' as ref,
        CURRENT_TIMESTAMP as encodeddate,'sbc' as encodedby,CURRENT_TIMESTAMP as editdate,'' as editby,'' as sku, '' as loc
        from hpihead as head
        left join hpistock as stock on stock.trno = head.trno
        where head.docno = '".$instruction."'";
        $data = Yii::$app->sbccommon->opentable($qry);
        
        $updatehead = "update pdhead set pi='".$instruction."' where trno = ".$trno."";
        Yii::$app->sbccommon->execqry($updatehead);
        //TRANSFERRING TO PDSTOCK
        $line = 0;
        foreach ($data as $key => $value) {
          $line +=1;
          $insert = "insert into pdstock (trno,line,barcode,itemname,uom,wh,disc,rem,cost,rrqty,rrcost,qty,iss,ext,qa,void,refx,
          linex,ref,encodeddate,encodedby,editdate,editby,sku,loc)
          values('".$trno."','".$line."','".$data[$key]['barcode']."','".$data[$key]['itemname']."','".$data[$key]['uom']."',
          '".$data[$key]['wh']."','".$data[$key]['disc']."','".$data[$key]['rem']."','".$data[$key]['cost']."','".$data[$key]['rrqty']."',
          '".$data[$key]['rrcost']."','".$data[$key]['qty']."','".$data[$key]['iss']."','".$data[$key]['ext']."','".$data[$key]['qa']."',
          '".$data[$key]['void']."','".$data[$key]['refx']."','".$data[$key]['linex']."','".$data[$key]['ref']."',
          '".$data[$key]['encodeddate']."','".$data[$key]['encodedby']."','".$data[$key]['editdate']."','".$data[$key]['editby']."',
          '".$data[$key]['sku']."','".$data[$key]['loc']."')";
          
          Yii::$app->sbccommon->execqry($insert);
        }//end

        $final = "select item.itemid,stock.barcode,stock.line,stock.rrqty,stock.uom,stock.itemname,stock.rrcost,stock.ext,
        stock.qa from pdhead as head left join pdstock as stock on stock.trno = head.trno 
        left join item on item.barcode = stock.barcode where stock.trno = ".$trno."";

        $finaldata = Yii::$app->sbccommon->opentable($final);
        $postock = new Postock;
        $grandtotal = $postock->getgrandtotal($trno, 'PD');
        //IF SET GRAND TOTAL AMOUNT TO 0 IF DOESNT HAVE ANY VALUE
        if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
         $finaldata[0]['grandtotal'] = 0;
        }else{
          $finaldata[0]['grandtotal'] = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], 2) : 0;
        }
        //IF SET GRAND TOTAL ITEM COUNT TO 0 IF DOESNT HAVE ANY VALUE               
        if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
          $head->itemcount = 0;
        }else{
         $finaldata[0]['itemcount'] =  isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], 2) : 0;    
        }

        return $finaldata;
    } //end function 

    public function retrieveUnfinishedScheds($userid){
      if($userid == ""){
        $qry = "select member_schedule.*,useraccess.name from member_schedule
        left join useraccess on useraccess.userid = member_schedule.userid
        where event_tagging = 'ONGOING'
        and clientid in (select clientid from sched_allowedcustomer where userid = ".Yii::$app->session['loggeduser']['userid'].")";
      }else{
        $qry = "select member_schedule.*,useraccess.name from member_schedule
        left join useraccess on useraccess.userid = member_schedule.userid 
        where member_schedule.event_tagging = 'ONGOING' and useraccess.userid = ".$userid."
        and clientid in (select clientid from sched_allowedcustomer where userid = ".Yii::$app->session['loggeduser']['userid'].")";
      }//end if $ccode == ""

      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveSchedInfo($seq){
      $qry = "select member_schedule.*,c.client,c.clientname,u.name,u.username,ifnull(projects.project_title,'') as prjname from member_schedule 
      left join client as c on c.clientid = member_schedule.clientid 
      left join useraccess as u on u.userid = member_schedule.userid 
      left join sched_projects as projects on projects.projectid = member_schedule.project_tagging
      where sched_seq = '".$seq."'";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end funcion

    public function countEventComments($eventid){
      $qry = "select count(commentid) as num from event_comments as head
      left join itimages on itimages.codeid = head.userid
      left join useraccess as users on users.userid = head.userid
      where eventid = ".$eventid." order by head.commentid";

      return $num = Yii::$app->sbccommon->datareader($qry);
    }//end function count event comments

    public function countEventNotes($eventid){
      $qry = "select count(noteid) as notecount from schedule_notes where schedid = ".$eventid."";
      return $num = Yii::$app->sbccommon->datareader($qry);
    }//end function count event comments

    public function retrieveMemberSchedule($userid,$monthfilter = ''){
      if($monthfilter == ''){
        $monthfilter = date('m');
      }//end if

      $firstfilter = $monthfilter - 1;
      $lastfilter = $monthfilter + 1;
      
      if($userid == ""){
        $qry = "select member_schedule.*,u.name from member_schedule 
        left join useraccess as u on u.userid = member_schedule.userid 
        where isplotted = 1 
        and month(date1) between '".$firstfilter."' and '".$lastfilter."'
        order by member_schedule.sched_id asc";
      }else{
        $qry = "select member_schedule.*,u.name from member_schedule
        left join useraccess as u on u.userid = member_schedule.userid
        where member_schedule.userid = ".$userid." and member_schedule.isplotted = 1
        and month(date1) between '".$firstfilter."' and '".$lastfilter."'
        order by member_schedule.sched_id asc";
      }
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end funcion

    public function retrieveFilteredSchedules($tagging,$type,$searchstring){
         switch ($type) {
            case 'ALL':
                if($searchstring == ''){
                  $qry = "select * from member_schedule where event_tagging = '".$tagging."'";
                }else{
                  $qry = "select * from member_schedule 
                  where event_tagging = '".$tagging."' and sched_desc like '%".$searchstring."%'
                  or event_tagging = '".$tagging."' and starttime like '%".$searchstring."%'";
                }//end if
                break;
            
            default:
                $key = Yii::$app->session['loggeduser']['userid'];
                if($searchstring ==''){
                  $qry = "select * from member_schedule where event_tagging = '".$tagging."' and userid = ".$key."";
                }else{
                  $qry = "select * from member_schedule 
                  where event_tagging = '".$tagging."' and userid = ".$key." and sched_desc like '%".$searchstring."%'
                  or event_tagging = '".$tagging."' and userid = ".$key." and starttime like '%".$searchstring."%'";
                }//end if
                break;
        }//end switch case
        return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveSchedules($userid,$monthfilter = ''){
      if($monthfilter == ''){
        $monthfilter = date('m');
      }//end if

      $firstfilter = $monthfilter - 1;
      $lastfilter = $monthfilter + 1;
      $qry = "select * from member_schedule where userid = ".$userid." and isplotted = 1 
      and month(date1) between '".$firstfilter."' and '".$lastfilter."'
      order by sched_id asc";
      
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function retrieveUnplottedschedules($userid){
      if($userid == ""){
        $qry = "select member_schedule.*,user.name from member_schedule 
        left join useraccess as user on user.userid = member_schedule.userid
        where isplotted <> 1 order by sched_id desc";
      }else{
        $qry = "select member_schedule.*,user.name from member_schedule 
        left join useraccess as user on user.userid = member_schedule.userid
        where isplotted <> 1 and member_schedule.userid = ".$userid." order by sched_id desc";
      }//end if
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function deleteFrontendLogs($logids,$type,$params){
      switch ($type) {
        case 'SWIPE':
        $qry = "delete from frontend_logs";
        $status =  Yii::$app->sbccommon->execqry($qry);
          break;
        
        case 'SELECTED':
          foreach ($logids as $key => $value) {
            $qry = "delete from frontend_logs where logid = ".$value."";    
            $status =  Yii::$app->sbccommon->execqry($qry);
          }        
          break;

        case 'FILTERED':
           switch ($params['logtype']) {
            case 'EMAIL':
              $where_clause = " logtype like '%".$params['logtype']."%' "; 
              break;
            
            default:
              $where_clause = " logtype = '".$params['logtype']."' "; 
              break;
          }//END IF
          
          $qry = "delete from frontend_logs where".$where_clause."and occurance <= '".$params['date1']."' and occurance >= '".$params['date2']."'";
          $status =  Yii::$app->sbccommon->execqry($qry);
          break;

        case 'SINGLE':
        $qry = "delete from frontend_logs where logid = ".$logids."";
        $status =  Yii::$app->sbccommon->execqry($qry);
          break;   
      }//END SWITCH CASE
      
      if($status){
            $msg = "Successfully deleted log!";
      }else{
            $msg = "Error occured while deleting logs, Please try again.";
      }

      return array('status'=>$status,'msg'=>$msg);
    }//END FUNCTION

    public function retrieveFrontendLogs($date1st,$date2nd,$logtype){
        switch ($logtype) {
          case 'EMAIL':
            $where_clause = " logtype like '%".$logtype."%' "; 
            break;
          
          default:
            $where_clause = " logtype = '".$logtype."' "; 
            break;
        }//END IF

        $qry = "select * from frontend_logs where".$where_clause."
                and left(occurance,10) >= '".$date1st."' and left(occurance,10) <= '".$date2nd."'";
        return $logs = Yii::$app->sbccommon->opentable($qry);
    }//end function get frontend logs

    function getDocumentreference($trno,$doc){
       switch ($doc) {
          case 'PR':
            $qry = 'select concat("Stock reference:",head.docno) as docno from pohead as head 
            left join postock as stock on stock.trno=head.trno where stock.refx='.$trno.'
            union all select concat("Stock reference:",head.docno) from hpohead as head 
            left join hpostock as stock on stock.trno=head.trno where stock.refx='.$trno; 
            return $data = Yii::$app->sbccommon->opentable($qry);
          break;

          case 'PV':
            $qry = 'select concat("Doc reference: ",head.docno) as docno from lahead as head
            left join ladetail as detail on detail.trno=head.trno
            where detail.refx = '.$trno .'
            union all
            select concat("Doc reference:",head.docno) as docno from glhead as head
            left join gldetail as detail on detail.trno=head.trno
            where detail.refx = '.$trno;
            return $data = Yii::$app->sbccommon->opentable($qry);
          break;
        
          case 'RR': case 'SJ': case 'DM': case 'CM': case 'SJ2': case 'SV':
            $qry = 'select concat(apledger.docno," - ",apledger.db+apledger.cr,"  -  ","BALANCE: ",apledger.bal) as docno 
            from apledger where trno='.$trno.'
            union all
            select concat(arledger.docno," - ",arledger.db+arledger.cr,"  -  ","BALANCE: ",arledger.bal) from arledger 
            where trno='.$trno.'
            union all
            select concat(head.docno," - ",head.dateid," - ",detail.db+detail.cr) from lahead as head 
            left join ladetail as detail on detail.trno=head.trno where detail.refx='.$trno.'
            union all
            select concat(head.docno," - ",head.dateid," - ",detail.db+detail.cr) from glhead as head 
            left join gldetail as detail on detail.trno=head.trno where detail.refx='.$trno.'
            union all 
            select concat("Stock reference:",head.docno) from lahead as head 
            left join lastock as stock on stock.trno=head.trno where stock.refx='.$trno.'
            union all
            select concat("Stock reference:",head.docno) from glhead as head 
            left join glstock as stock on stock.trno=head.trno where stock.refx='.$trno.'
            union all
            select concat("Counter Receipt: ",num.docno , " (" ,num.center,")") from transnum as num
            left join arledger as ledger on ledger.kr = num.trno 
            and num.doc = "KR" where ledger.trno = "'.$trno.'"';
            return $data = Yii::$app->sbccommon->opentable($qry);  
          break;
          
          case 'PO': case 'SO': case 'pscheme': case 'PS': case 'TR':
            $qry ='
            select concat("Stock reference:",head.docno) as docno from lahead as head left join lastock as stock on stock.trno=head.trno where stock.refx='.$trno.'
            union all
            select concat("Stock reference:",head.docno) from glhead as head left join glstock as stock on stock.trno=head.trno where stock.refx='.$trno;
            return $data = Yii::$app->sbccommon->opentable($qry);            
          break;

          case 'CR':
            $qry = "select concat('DEPOSIT REFERENCE: ',head.docno) as docno from lahead as head
            left join ladetail as detail on detail.trno = head.trno
            where detail.refx = ".$trno."
            UNION ALL
            select concat('DEPOSIT REFERENCE: ',head.docno) as docno from glhead as head
            left join gldetail as detail on detail.trno = head.trno
            where detail.refx = ".$trno."";
            return $data = Yii::$app->sbccommon->opentable($qry);            
          break;
       }//END SWITCH
    }//end function get document reference

    function getIncomingItemBalance($itemid){
        $qry = "select sum(unpostedpo) as unpostedpo , sum(postedpo) as postedpo,sum(unpostedso) as unpostedso,sum(postedso) as postedso from
          (
          select ifnull(sum(stock.qty),0) as unpostedpo,0 as postedpo,0 as unpostedso,0 as postedso from postock as stock
          left join item on item.barcode = stock.barcode where item.itemid = ".$itemid."
          union all
          select 0 as unpostedpo, ifnull(sum(stock.qty - qa),0) as postedpo,0 as unpostedso,0 as postedso from hpostock as stock
          left join item on item.barcode = stock.barcode where item.itemid = ".$itemid."
          union all
          select 0 as unpostedpo,0 as postedpo,ifnull(sum(stock.iss),0) as unpostedso,0 as postedso from sostock as stock
          left join item on item.barcode = stock.barcode where item.itemid = ".$itemid."
          union all
          select 0 as unpostedpo, 0 as postedpo,0 as unpostedso,ifnull(sum(stock.iss),0) as postedso from hsostock as stock
          left join item on item.barcode = stock.barcode where item.itemid = ".$itemid.") as tbl";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function


    function sanitize($str,$strtype){ //THIS FUNCTIONS STRIPS HTML TAGGING CHARATERS,STRIPS SLASHES AND ALSO REPLACES QUOTES WITH `
      switch ($strtype) {
        case 'ARRAY':
            $acnocodes = array('contra','acno','asset','liability','revenue','expense');
            $qty = array('isqty','isqty2','iss','rrqty','qty');
          

          foreach ($str as $key => $strval) {

            if(!in_array($key, $acnocodes)){
              $str[$key] = strip_tags($str[$key]);
              $str[$key] = stripslashes($str[$key]);
              //JAO REVISED: SPECIAL CHARACTERS LIKE THE OLD ONES 
              //HAS ERRORS ON THE WEB SERVICE WHILE RETRIEVING
              /*$str[$key] = str_replace ("'","´",$str[$key]);
              $str[$key] = str_replace ('"',"”",$str[$key]);*/
              $str[$key] = str_replace ("'","`",$str[$key]);
              $str[$key] = str_replace ('"',"`",$str[$key]);
            }

              if(in_array($key, $qty)){
                 if($str[$key]==''||empty($str[$key])){
                    $str[$key]=0;
                 }
            }
          }//end foreach
          return $str;
          break;
        
        default:
          $str = strip_tags($str);
          $str = stripslashes($str);
          //JAO REVISED: SPECIAL CHARACTERS LIKE THE OLD ONES 
          //HAS ERRORS ON THE WEB SERVICE WHILE RETRIEVING
          /*$str = str_replace("'","´",$str);
          $str = str_replace ('"',"”",$str);*/
          $str = str_replace("'","`",$str);
          $str = str_replace ('"',"`",$str);
          return $str;
          break;
      }//END SWITCH CASE
    }//end function sanitize

    function getReceivingTotal($itemid,$wh,$uom){
        $qry = "select sum(rr.qty / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as qty,
        sum((rr.qty-rr.bal) / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as iss,
        sum(rr.bal / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) as bal
        from rrstatus as rr left join client on client.clientid=rr.clientid left join client as wh on wh.clientid=rr.whid
        left join item on item.itemid=rr.itemid 
        left join uom on uom.itemid=rr.itemid and uom.uom='".$uom."'
        left join cntnum on cntnum.trno=rr.trno
        where rr.itemid=".$itemid." and wh.client='".$wh."'
        order by rr.dateid";
        return $data = Yii::$app->sbccommon->opentable($qry);    
    }//end function

    function getLedgerTotal($itemid,$wh,$uom){
        $qry = "select itemid, wh, sum(qty) as qty, sum(iss) as iss, sum(balance) as balance
      from (select '' as posted, head.trno, head.doc, head.docno, head.dateid, stock.wh, item.itemid,
      ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as qty,
      ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as iss,
      ifnull((case when stock.iss>0 then (ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)-ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)) else 0 end),0) as balance
      from lahead as head left join lastock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
      left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
      where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and item.itemid=".$itemid." and stock.wh='".$wh."'
      union all
      select '' as posted, head.trno, head.doc, head.docno, head.dateid, stock.wh, item.itemid,
      ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as qty,
      ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as iss,
      ifnull((case when stock.iss>0 then (ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)-ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)) else 0 end),0) as balance
      from lbhead as head left join lbstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
      left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
      where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and item.itemid=".$itemid." and stock.wh='".$wh."'
      union all
      select '' as posted, head.trno, head.doc, head.docno, head.dateid, stock.wh, item.itemid,
      ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as qty,
      ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as iss,
      ifnull((case when stock.iss>0 then (ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)-ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)) else 0 end),0) as balance
      from lchead as head left join lcstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
      left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
      where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and item.itemid=".$itemid." and stock.wh='".$wh."'
      union all
      select 'POSTED' as posted, head.trno, head.doc, head.docno, head.dateid, wh.client as wh, stock.itemid,
      ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as qty,
      ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as iss,
      (ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)-ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)) as balance
      from glhead as head left join glstock as stock on stock.trno=head.trno 
      left join uom on uom.itemid=stock.itemid and uom.uom='".$uom."'
      left join client as wh on wh.clientid=stock.whid
      where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and stock.itemid=".$itemid." and wh.client='".$wh."'
      union all
      select 'POSTED' as posted, head.trno, head.doc, head.docno, head.dateid, wh.client as wh, stock.itemid,
      ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as qty,
      ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) as iss,
      (ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)-ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)) as balance
      from hglhead as head left join hglstock as stock on stock.trno=head.trno 
      left join uom on uom.itemid=stock.itemid and uom.uom='".$uom."'
      left join client as wh on wh.clientid=stock.whid
      where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and stock.itemid=".$itemid." and wh.client='".$wh."'
    ) as sk
    group by itemid, wh";

    return $data = Yii::$app->sbccommon->opentable($qry);    
    }//end function


    function computeduedate($terms,$dateid){
      Yii::$app->systemsettings->setDefaultTimeZone();
      $date = strtotime("+".intval($terms)." days", strtotime($dateid));
      $date = date("Y-m-d", $date);
      return $date;
    }//end function

    public function getBrand($type,$searchstring){
        
        switch ($type) {
          case '0': case '1':
            $filter = " where isenabled = ".$type." ";
            break;
          
          case '2':
            //for all brand for frontend
            $filter = " ";
            break;
        }//end switch case

        if($searchstring != ''){
          if($filter = " "){
            $filter = " where brand_desc like '%".$searchstring."%' ";
          }else{
            $filter = $filter . "and brand_desc like '%".$searchstring."%' ";
          }//end if
        }//end if search string

        $qry = "select ifnull(picture,'') as picture,md5(brandid) as brandid,brand_desc as brand,isenabled as status from frontend_ebrands".$filter."order by brand asc";
        return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

     public function getClass(){
        $qry = "select 0 as classid , '' as class UNION ALL
        select cl_code as classid,cl_name as class from item_class order by class asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getBody(){
        $qry = "select distinct body from item order by body asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getSize(){
        $qry = "select distinct sizeid from item order by sizeid asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end


    //JEAR 091916
    public function getCategory2($searchstring = ""){
      if($searchstring == ""){
        $qry = "select distinct category from client order by category asc";
      }else{
        $qry = "select distinct category from client where category like '%".$searchstring."%' order by category asc";
      }//end function

      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getAssetCategory2($searchstring = ""){
      if($searchstring == ""){
        $qry = "select distinct category2 from client order by category2 asc";
      }else{
        $qry = "select distinct category2 from client where category2 like '%".$searchstring."%' order by category2 asc";
      }//end function

      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end
    
    public function getCategory($searchstring = ""){
      if($searchstring == ""){
        $qry = "select distinct category from item order by category asc";
      }else{
        $qry = "select distinct category from item where category like '%".$searchstring."%' order by category asc";
      }//end function

      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getGroupid(){
        $qry = "select 0 as id , '' as code , '' as stockgrp UNION ALL
        select stockgrp_id as id,stockgrp_code as code,stockgrp_name as stockgrp from stockgrp_masterfile order by stockgrp_name";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getPart(){
        $qry = "select 0 as id ,'' as code, '' as part UNION ALL
        select part_id as id,part_code as code,part_name as part from part_masterfile order by part_name";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getModel(){
        $qry = "select 0 as id, '' as code , '' as model UNION ALL
        select model_id as id,model_code as code,model_name as model from model_masterfile order by model_name";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getCenters(){
        return "select line,name,code from center";
    }//end

    public function removeItemUOM($itemid,$uom,$line){
        try {
          $params = array('itemid'=>$itemid,'uom'=>$uom,'line'=>$line);
          $parametersfinal = array('params'=>$params);
          $checkdata = $this->uomValidation($params,'DELETING');
            if(!$checkdata['isdeleteready']){
                $status = false;
                if(!isset($checkdata[0]['msg']) || empty($checkdata[0]['msg'])){
                  $msg = "This UOM is the default UOM. Cannot be removed.";
                }else{
                  $msg = $checkdata[0]['msg'];
                }//end if
            }else{
                $qry = "delete from uom where itemid = ".$itemid." and uom = '".$uom."' and line = ".$line."";
                $status =  Yii::$app->sbccommon->execqry($qry);
                $msg = "";
            }//end if checker uom

            if($status){
              $msg = "Delete UOM successfully!";
            }else{
              if(!isset($msg)){
                $msg = "An Error Occured while removing UOM. Please try again.";
              }//end isset $msg
            }//end if status

            return array('status'=>$status,'msg'=>$msg,'invbal_uom'=>$checkdata['invbal_uom']);
        } catch (ErrorException $e) {
          echo $e;
        }
    }//end function

    public function UOMhastransaction($uom,$itemid){
        $qry = "select item.itemid,stock.uom from postock as stock
            left join item on item.barcode = stock.barcode
            where item.itemid = ".$itemid." and stock.uom = '".$uom."'
            UNION ALL
            select item.barcode,stock.uom from sostock as stock
            left join item on item.barcode = stock.barcode
            where item.itemid = ".$itemid." and stock.uom = '".$uom."'
            UNION ALL
            select item.itemid,stock.uom from pcstock as stock
            left join item on item.barcode = stock.barcode
            where item.itemid = ".$itemid." and stock.uom = '".$uom."'
            UNION ALL
            select item.itemid,stock.uom from prstock as stock
            left join item on item.barcode = stock.barcode
            where item.itemid = ".$itemid." and stock.uom = '".$uom."'
            UNION ALL
            select item.itemid,stock.uom from lastock as stock
            left join item on item.barcode = stock.barcode
            where item.itemid = ".$itemid." and stock.uom = '".$uom."'
            UNION ALL
            select stock.itemid,stock.uom from glstock as stock
            where stock.itemid = ".$itemid." and stock.uom = '".$uom."'";
        $data = Yii::$app->sbccommon->opentable($qry);

        if(empty($data)){
          $qry2 = "select gm_printuom from item where itemid=".$itemid." and gm_printuom='".$uom."'";
          $data2 = Yii::$app->sbccommon->opentable($qry2);
          
            
          if(empty($data2)){
              return false;
          }else{
              return true;
          }
        }else{
            return true;
        }
    }//END FUNCTON

//###################### REPORT LIST UPDATE
    public function getDistributionlist($trno){
        $qry = "select detail.line,detail.acnoname,coa.acno,
        round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
        detail.checkno from gldetail as detail
        left join coa on coa.acnoid = detail.acnoid
        where detail.trno = ".$trno."";
        return $qry;
    }//end if
    
    public function getReportlistParents(){
        $qry = "select * from menu where parent = '\\\\9'";
        return $qry = Yii::$app->sbccommon->opentable($qry);
    }//END 


    public function getReportChildren($code){
        $query = "select * from menu where parent = '\\".$code."' order by attribute";

       /* foreach ($data as $reportdata) {
            $attribute = $reportdata['attribute'];   
            if(Yii::$app->session['loggeduser']['access'][$attribute] == 1){
            echo '<li disabled>
            <a class="reportparents clickable" id="'.$reportdata['attribute'].'-'.$reportdata['code'].'">' .$reportdata['description'].'</a>';
            echo '<ul id="child'.$reportdata['attribute'].'"></ul>';
            echo '</li>';
            }
        }//END FOR EACH*/     
        $data = Yii::$app->sbccommon->opentable($query);
        
        foreach ($data as $key => $value) {
          if(Yii::$app->session['loggeduser']['access'][$value['attribute']] == 1){
              $data[$key]['isallowed'] = 1;
          }else{
              $data[$key]['isallowed'] = 0;
          }//end if
        }//end if
        
        return $data;
    }//END GET CHILDREN


    public function searchBranchwh($controller,$access,$clientid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select line, clientid, wh, isdefault, isinactive, dlock, isok from branchwh where clientid = $clientid";
      }
    }

    public function searchBranchstation($controller,$access,$clientid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select line, clientid, station, ipaddress, localport, localdb, username, password, compname, compaddress, tin, comptel,
          operatedby, footer1, footer2, footer3, footer4, footer5, serialno, min, permitno, accredno, dateissued, validuntil, isinactive, sync
          from branchstation where clientid = $clientid";
      }
    }

    public function searchBranchbrand($controller,$access,$clientid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        // return "select line, clientid, brand, isinactive from branchbrand where clientid = $clientid";
        return "select b.line, b.clientid, b.brand as brandid, b.isinactive, brands.brand_desc as brand from branchbrand as b left join frontend_ebrands as brands on b.brand = brands.brandid where b.clientid = $clientid";
      }
    }

    public function searchBranchagent($controller,$access,$clientid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select line, clientid, client, clientname, inactive from branchagent where clientid = $clientid";
      }
    }

    public function searchBranchusers($access,$clientid) {
      try {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          return "select line, clientid, username, isinactive, type, dlock from branchusers where clientid = $clientid";
        }
      } catch (ErrorException $e) {
        echo $e;
      }
    }

    public function searchBranchbank($access,$clientid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select line, clientid, acno, terminalid, bank, isinactive, charges from branchbank where clientid = $clientid";
      }
    }

    public function searchArea($controller,$access) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select distinct area from client order by area";
      }
    }

    public function searchRegion($controller,$access) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select distinct region from client order by area";
      }
    }

    public function searchProvince($controller,$access) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

      } else {
        return "select distinct province from client order by area";
      }
    }


    public function getArealist(){
      $qry = "select distinct area from client order by area";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }

    public function getClientCatlist(){
      $qry = "select cat_id as catid,cat_name as category from category_masterfile order by cat_name asc";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getClientDistributionarealist(){
      $qry = "select distroid,distroname from(
      select 0 as distroid,'' as distroname
      union all
      select dist_id as distroid,dist_name as distroname from distribution_area) as tbl order by distroname asc";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getClientCollectionarealist(){
      $qry = "select collectid,collectname from  (
      select 0 as collectid,'' as collectname
      UNION ALL
      select cllc_id as collectid,cllc_name as collectname from collection_area ) as tbl order by collectname asc";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getClientGrplist($str){
      if($str != ''){
        $strfilter = "  where groupid like '%".$str."%' ";
      }else{
        $strfilter = " ";
      }//end if

      $qry = "select distinct groupid as stockgrp from client ".$strfilter." order by groupid";
      return $qry;
      // return $data = Yii::$app->sbccommon->opentable($qry);
    }//end function

    public function getRegionlist(){
        $qry = "select distinct region from client order by area";
        return $data = Yii::$app->sbccommon->opentable($qry);
    }

    public function getProvincelist(){
        $qry = "select distinct province from client order by area";
        return $data = Yii::$app->sbccommon->opentable($qry);
    }

//###################### REPORT LIST UPDATE

    public function uomValidation($params,$type){
        switch ($type) {
          case 'DELETING': case 'UPDATING':
            $checkuomtbl = [];  
          break;
          default:
            $qrycheckavailable = 'select uom from uom where itemid = "'.$params['itemid'].'" 
            and uom = "'.$params['uom'].'" and line = "'.$params['line'].'"';
            $checkuomtbl = Yii::$app->sbccommon->opentable($qrycheckavailable);
          break;
        }
        
        if(!empty($checkuomtbl)){
            $status = false;
            $msg = 'UOM is already in this item, Please choose another.';
        }else{
            switch ($type) {
              case 'INSERTING':
                $qryitmtbl = Yii::$app->sbccommon->opentable('select uom from item where itemid = "'.$params['itemid'].'"'); 
                if($qryitmtbl[0]['uom'] == $params['uom']){
                  $status = false;
                  $msg = 'UOM Name "'.$params['uom'].'" is used as default. Please choose another.';
                }else{
                  $status = true;
                  $msg = '';
                }
                return array('status'=>$status,'msg'=>$msg);
              break;
              case 'UPDATING':
                $qry = "select uom,factor from uom where itemid=".$params['itemid']." and line = ".$params['line']."";
                $uomdata = Yii::$app->sbccommon->opentable($qry);
                if($uomdata[0]['factor'] == 1){
                  $isdefaultfactor = true;
                }else{
                  $isdefaultfactor = false;
                }
                $status = true;
                $msg = "";
                return array('status'=>$status,'msg'=>$msg,'isdefaultfactor'=>$isdefaultfactor);
              break;

              case 'DELETING':
                $qryuomchecker = 'select uom,factor from uom where itemid ='.$params['itemid'].' and line ='.$params['line'].'';
                $uomdata = Yii::$app->sbccommon->opentable($qryuomchecker);
                $qryitemchecker = "select uom,invbal_uom from item where itemid = ".$params['itemid']."";
                $itemdata = Yii::$app->sbccommon->opentable($qryitemchecker);
                if($this->UOMhastransaction($itemdata[0]['uom'],$params['itemid'])){
                  $msg = "UOM  ".$itemdata[0]['uom']." already has transaction. Cannot remove this UOM.";
                  $status = false;
                  $isdeleteready = true;
                }else{
                  if($itemdata[0]['uom'] == $uomdata[0]['uom'] && $uomdata[0]['factor'] == 1){
                    $isdeleteready = false;
                  }else{
                    if($itemdata[0]['invbal_uom'] == $uomdata[0]['uom']){
                      $qryupdateitemtbl = "update item set invbal_uom = '' where itemid = ".$params['itemid']."";
                      Yii::$app->sbccommon->execqry($qryupdateitemtbl);
                      $qryretrieve = "select uom,invbal_uom from item where itemid = ".$params['itemid']."";
                      $itemdata = Yii::$app->sbccommon->opentable($qryretrieve);
                    }
                    $isdeleteready = true;
                  }
                  $status = true;
                  return array('isdeleteready'=>$isdeleteready,'status'=>$status,'invbal_uom'=>$itemdata[0]['invbal_uom']);
                }
              break;
            }
        }
    }

    // XANDABLE
    public function insertToUOMtbl($params){
      try {
      if($params['line'] == 0) { // #### FOR INSERTION OF NEW UOM
        $returnvalues = $this->uomValidation($params,'INSERTING');
        $type = 'add';
        if($returnvalues['status']){
          
          if(isset($params['kilos'])){
            $kilos = $params['kilos'];
          }else{
            $kilos = 0;
          }//end if

          $qry = "insert into uom (itemid,uom,factor,amt,discount,kilos,uom_desc) values('".$params['itemid']."','".$params['uom']."','".$params['factor']."',".$params['amt'].",'','".$kilos."','".$params['uom_desc']."')";
          $status =  Yii::$app->sbccommon->execqry($qry);
          $data = Yii::$app->sbccommon->opentable("select line,itemid,uom,factor,amt,discount,kilos,uom_desc from uom order by line desc limit 1");
          if($status){
              $msg = "UOM Inserting Sucessfully!";
          }else{
              $msg = "UOM Inserting Failed , please try again.";
          }//end if $status
        }else{
          $data = [];
          $msg = $returnvalues['msg'];
          $status = $returnvalues['status'];
        }//EMD IF
      }else{ //############# FOR UPDATING
        $type = 'edit';
        
        if(isset($params['kilos'])){
          $kilos = $params['kilos'];
        }else{
          $kilos = 0;
        }//end if

        if($this->UOMhastransaction($params['prevuom'],$params['itemid'])){
            $msg = "UOM Already have transaction, please try again.";
            $status = 0;
            $data = '';
        }else{
          $returnvalues = $this->uomValidation($params,'UPDATING');
          if($returnvalues['status']){
            if($returnvalues['isdefaultfactor']){
              $qry = "update uom set uom = '".$params['uom']."',kilos = '".$kilos."', uom_desc = '".$params['uom_desc']."',amt = ".$params['amt']." where line = '".$params['line']."' and itemid = '".$params['itemid']."'";
              $status =  Yii::$app->sbccommon->execqry($qry);
              if($status){
                $qryitemupdate = "update item set uom = '".$params['uom']."' where itemid = ".$params['itemid']."";
                $status =  Yii::$app->sbccommon->execqry($qryitemupdate);
              }//end if

              $data = Yii::$app->sbccommon->opentable("select line,itemid,uom,factor,amt,discount,kilos,uom_desc from uom where line = {$params['line']} and itemid = {$params['itemid']}");
            }else{
              $qry = "update uom set factor = '".$params['factor']."', uom = '".$params['uom']."',kilos = '".$kilos."',uom_desc = '".$params['uom_desc']."',amt = ".$params['amt']." where line = '".$params['line']."' and itemid = '".$params['itemid']."'";
              $status =  Yii::$app->sbccommon->execqry($qry);
            }//end if
            if($status){ 
                $msg = "UOM updated Sucessfully!";
            }else{
                $msg = "UOM update Failed , please try again.";
            }//end
            $data = Yii::$app->sbccommon->opentable("select line,itemid,uom,factor,amt,discount,kilos,uom_desc from uom where line = {$params['line']} and itemid = {$params['itemid']}");
          }else{
            $msg = $returnvalues['msg'];
            $status = $returnvalues['status'];
            $data = '';
          }//end if
        }
      }//end ##################### UPDATE
        return array('status' => $status , 'msg'=>$msg, 'data' => $data, 'type' => $type);

        
      } catch (ErrorException $e) {
          echo $e;
      }
    }//end insert
    // END XANDA


    public function searchComputeledger($controller,$access,$itemid,$date,$uom,$wh) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      $center=Yii::$app->session['loggeduser']['center'];
      $query = "select '' as posted, 
        CASE
        WHEN stock.init_vat_value = 1 THEN 'VATABLE'
        WHEN stock.init_vat_value = 0 THEN 'VAT EXEMPT'
        ELSE '---' end as vat_status,
        head.trno, head.doc, head.docno, date(head.dateid) as dateid, head.clientname, round(ifnull(stock.rrcost,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.wh, 
        round(case when uom.factor <= 1 then ifnull((stock.cost / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as cost,
        round(case when uom.factor <= 1 then ifnull((stock.qty * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as qty,
        round(case when uom.factor <= 1 then ifnull((stock.amt / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.amt * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
        round(case when uom.factor <= 1 then ifnull((stock.iss * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as iss,
        stock.disc, head.yourref, head.ourref, ifnull(head.cur,'P') as cur, ifnull(head.forex,1) as forex,
        (case when stock.iss<>0 then 1 else 0 end) as type, head.isimport, head.factor, stock.rem, 0 as balance, item.itemid,
        stock.loc,stock.expiry from lahead as head 
        left join lastock as stock on stock.trno=head.trno 
        left join item on item.barcode=stock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and item.itemid=".$itemid." and head.dateid>='".$date."'
        and stock.wh='".$wh."'
        UNION ALL
        select 'POSTED' as posted,
        CASE
        WHEN stock.init_vat_value = 1 THEN 'VATABLE'
        WHEN stock.init_vat_value = 0 THEN 'VAT EXEMPT'
        ELSE '---' end as vat_status,
        head.trno, head.doc, head.docno, date(head.dateid) as dateid, head.clientname, round(ifnull(stock.rrcost,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
        wh.client as wh, 
        round(case when uom.factor <= 1 then ifnull((stock.cost / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as cost,
        round(case when uom.factor <= 1 then ifnull((stock.qty * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as qty,
        round(case when uom.factor <= 1 then ifnull((stock.amt / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.amt * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
        round(case when uom.factor <= 1 then ifnull((stock.iss * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) else ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0) end,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as iss,
        stock.disc, head.yourref, head.ourref, ifnull(head.cur,'P') as cur, ifnull(head.forex,1) as forex,
        (case when stock.iss<>0 then 1 else 0 end) as type, head.isimport, head.factor, stock.rem, 0 as balance, stock.itemid, stock.loc,stock.expiry
        from glhead as head left join glstock as stock on stock.trno=head.trno 
        left join uom on uom.itemid=stock.itemid and uom.uom='".$uom."'
        left join client as wh on wh.clientid=stock.whid
        where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and stock.itemid=".$itemid." and head.dateid>='".$date."' and wh.client='".$wh."'
        order by dateid desc,trno desc";
      return $query;
    }
  }

  public function searchCustomerStat($yearfilter,$clientfilter,$statview){    
    if ($yearfilter == ''){
      $filteryr = "";
    }else{
      $filteryr = " and year(head.dateid) = '".$yearfilter."'";
    }

    if($statview == ''){
      $statview = 'MONTHLY';
    }

    switch (strtoupper($statview)) {
      case 'MONTHLY':
        $grp = "CONCAT(monthname(head.dateid),' ',year(head.dateid))";
        break;
      
      case 'ANNUAL':
        $grp = "year(head.dateid)";
        break;
    }//end switch

    $qry = "select trno,grp,client,clientname,sum(amount) as stats from (
            select head.trno,".$grp." as grp,date(head.dateid) as dateid, head.docno,
            client.client, client.clientname, sum(stock.ext) as amount
            from glhead as head
            left join glstock as stock on stock.trno=head.trno
            left join client on client.clientid=head.clientid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='SJ' and head.dateid and cntnum.center='".Yii::$app->session['loggeduser']['center']."'
            and client.client = '".$clientfilter."'".$filteryr."
            group by head.dateid, head.docno, client.client, client.clientname
            union all
            select head.trno,".$grp." as grp,date(head.dateid) as dateid, head.docno,
            client.client, client.clientname, sum(stock.ext) as amount
            from hglhead as head
            left join hglstock as stock on stock.trno=head.trno
            left join client on client.clientid=head.clientid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='SJ' and cntnum.center='".Yii::$app->session['loggeduser']['center']."' and client.client = '".$clientfilter."'".$filteryr."
            group by head.dateid, head.docno, client.client, client.clientname) as stats group by client,grp";
        
    return $qry;

  } //end function 


  public function searchSupplierStat($yearfilter,$clientfilter,$statview){    
    if ($yearfilter == ''){
      $filteryr = "";
    }else{
      $filteryr = " and year(head.dateid) = '".$yearfilter."'";
    }

    if($statview == ''){
      $statview = 'MONTHLY';
    }

    switch (strtoupper($statview)) {
      case 'MONTHLY':
        $grp = "CONCAT(monthname(head.dateid),' ',year(head.dateid))";
        break;
      
      case 'ANNUAL':
        $grp = "year(head.dateid)";
        break;
    }//end switch

    $qry = "select trno,grp,client,clientname,sum(amount) as stats from (
            select head.trno,".$grp." as grp,date(head.dateid) as dateid, head.docno,
            client.client, client.clientname, sum(stock.ext) as amount
            from glhead as head
            left join glstock as stock on stock.trno=head.trno
            left join client on client.clientid=head.clientid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='RR' and head.dateid and cntnum.center='".Yii::$app->session['loggeduser']['center']."'
            and client.client = '".$clientfilter."'".$filteryr."
            group by head.dateid, head.docno, client.client, client.clientname
            union all
            select head.trno,".$grp." as grp,date(head.dateid) as dateid, head.docno,
            client.client, client.clientname, sum(stock.ext) as amount
            from hglhead as head
            left join hglstock as stock on stock.trno=head.trno
            left join client on client.clientid=head.clientid
            left join cntnum on cntnum.trno=head.trno
            where head.doc='RR' and cntnum.center='".Yii::$app->session['loggeduser']['center']."' and client.client = '".$clientfilter."'".$filteryr."
            group by head.dateid, head.docno, client.client, client.clientname) as stats group by client,grp";
        
    return $qry;

  } //end function 


  public function searchClass($controller,$access,$x) {
    $filter='';
      if($x!=''){
        $filter="where cl_id like '%".$x."%' or cl_name like '%".$x."%'";
      }
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    }else{
      return "select 0 as classid,'' as classic ,'' as fontcolor,'' as skincolor
            UNION ALL 
            select cl_id as classid, cl_name as classic,fontcolor,skincolor from item_class ".$filter."
            order by classic asc";
    }//end if
  }//end f



  public function searchBody($controller,$access,$x) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      return "select distinct body from item where body like '%".$x."%' order by body asc";
    }
  }//end f



  public function searchCategory($controller,$access,$searchstring) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      switch($controller->module->id) {
        case 'stockcard': case 'reportlist': case 'posstockcard': 
          if($searchstring == ""){
            $qry = "select distinct category from item order by category asc";
          }else{
            $qry = "select distinct category from item where category like '%".$searchstring."%' order by category asc";
          }//end function
        break;
        case 'customer': case 'supplier':
          if($searchstring == '') {
            $qry = "select cat_id as catid,cat_name as category from category_masterfile order by cat_name asc";
          } else {
            $qry = "select cat_id as catid, cat_name as category from category_masterfile where cat_name like '%".$searchstring."%' order by cat_name asc";
          }
        break;
      }
      return $qry;
    }
  }//end f


  public function searchComputeso($controller,$access,$itemid,$date,$uom,$wh) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      $center=Yii::$app->session['loggeduser']['center'];
      $query = "select sohead.rem,sohead.trno, sohead.doc, sohead.docno, left(sohead.dateid,10) as dateid,
        clientname, 
        round(sostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        round(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round((sostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (sostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,
        round(sostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa, case(sostock.void) when 1 then 'YES' else 'NO' end as void
        from sostock
        left join sohead on sohead.trno=sostock.trno
        left join item on item.barcode=sostock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        left join transnum as cntnum on cntnum.trno = sohead.trno
        where item.itemid=".$itemid." and sostock.wh ='".$wh."' and sohead.dateid>='".$date."' and cntnum.center ='".$center."'
        union all
        select hsohead.rem,hsohead.trno, hsohead.doc, hsohead.docno, left(hsohead.dateid,10) as dateid,
        clientname, 
        round(hsostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        round(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round((hsostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (hsostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,
        round(hsostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,case(hsostock.void) when 1 then 'YES' else 'NO' end as void from hsostock
        left join hsohead on hsohead.trno=hsostock.trno
        left join item on item.barcode=hsostock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        left join transnum as cntnum on cntnum.trno = hsohead.trno
        where item.itemid=".$itemid." and hsostock.wh ='".$wh."'
        and hsohead.dateid>='".$date."' and cntnum.center ='".$center."' order by dateid desc";
      return $query;
    }
  }
  public function searchComputepo($controller,$access,$itemid,$date,$uom,$wh) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      $center=Yii::$app->session['loggeduser']['center'];
      $query = "select pohead.trno, pohead.doc, pohead.docno,left(pohead.dateid,10) as dateid, clientname,
        round((postock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round((qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
        round((postock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,
        pohead.rem, case(postock.void) when 1 then 'YES' else 'NO' end as void
        from ((postock left join pohead on pohead.trno=postock.trno) 
        left join item on item.barcode=postock.barcode) 
        left join uom on uom.itemid=item.itemid and uom.uom='$uom' 
        left join transnum as cntnum on cntnum.trno = pohead.trno 
        where item.itemid=$itemid and postock.wh ='$wh'
        and pohead.dateid>='$date' and cntnum.center ='$center'
        UNION ALL
        select hpohead.trno, hpohead.doc, hpohead.docno,left(hpohead.dateid,10) as dateid, clientname,
        round((hpostock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round((qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
        round((hpostock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,hpohead.rem, case(hpostock.void) when 1 then 'YES' else 'NO' end as void
        from ((hpostock left join hpohead on hpohead.trno=hpostock.trno) 
        left join item on item.barcode=hpostock.barcode) left join uom on uom.itemid=item.itemid
        and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = hpohead.trno where item.itemid=$itemid and hpostock.wh ='$wh'
        and hpohead.dateid>='$date' and cntnum.center ='$center' order by dateid desc";
      return $query;
    }
  }

  public function searchComputespc($controller,$access,$itemid,$date) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      $center=Yii::$app->session['loggeduser']['center'];
      $query = "select head.trno,head.docno,left(head.dateid,10) as dateid,left(head.effectdate,10) as effectdate,head.clientname as supp,
                round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost2,round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext2,
                stock.disc as disc2 from hspchead as head
                left join hspcstock as stock on stock.trno = head.trno
                left join item on item.barcode = stock.barcode
                where item.itemid = ".$itemid. " order by left(head.effectdate,10) desc";
      return $query;
    }
  }

  public function searchComputereceiving($controller,$access,$itemid,$date,$uom,$wh) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      $query = "select cntnum.doc, rrstatus.trno, rrstatus.line, client.clientname, 
      CASE
      WHEN stock.init_vat_value = 1 THEN 'VATABLE'
      WHEN stock.init_vat_value = 0 THEN 'VAT EXEMPT'
      ELSE '---' end as vat_status,
      round(
      case when uom.factor <= 1 then
      ifnull((stock.cost / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)
      else
      ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0)
      end
      ,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as cost,
      
      round(
      case when uom.factor <= 1 then
      (rrstatus.qty * (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end))
      else
      (rrstatus.qty / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end))
      end
      ,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
      cast(
      case when rrstatus.bal = 0 then
        'applied'
      else
        round(
          case when uom.factor = 1 then
          (rrstatus.bal * (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end))
          else
          (rrstatus.bal / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end))
          end
        ,".Yii::$app->systemsettings->setDecimaldisplay('quantity').")
      end
      as char(50)) as status,
      left(rrstatus.dateid,10) as dateid, 
      rrstatus.whid, rrstatus.uom, rrstatus.disc, rrstatus.docno,
      round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
      rrstatus.loc,rrstatus.expiry,rrstatus.isimport,stock.rem,
      (stock.rrcost) as rrcostvat,
      (stock.ext / stock.rrqty) as rrcostgross,
      head.yourref
      from rrstatus 
      left join client on client.clientid=rrstatus.clientid 
      left join client as wh on wh.clientid=rrstatus.whid
      left join item on item.itemid=rrstatus.itemid 
      left join uom on uom.itemid=rrstatus.itemid and uom.uom='".$uom."'
      left join cntnum on cntnum.trno=rrstatus.trno
      left join glhead as head on head.trno = rrstatus.trno
      left join glstock as stock on stock.trno = rrstatus.trno and stock.line = rrstatus.line
      where rrstatus.itemid=".$itemid." and rrstatus.dateid >= '".$date."' 
      and wh.client='".$wh."' group by rrstatus.trno,rrstatus.line
      order by rrstatus.dateid desc";

      return $query;
    }
  }

  public function searchClientunpaid($controller,$access,$searchstring,$clientcode,$type) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      if($controller->module->id == "KR"){
        return $this->clientunpaidsearch_KR($searchstring,$clientcode);
      }else{
        return $this->clientunpaidsearch($searchstring,$clientcode,$type);
      }//end f
    }
  }

  public function searchRoutes($access) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      return "select route_id,route_code,route_name from route_masterfile";
    }
  }

 
  
    public function getAvailableLocation2($barcode,$factor){
      $query = "select stat.expiry, wh.client as whcode, wh.clientname as whname, stat.loc, 
      round((sum(stat.bal) / ".$factor."),'".Yii::$app->systemsettings->setDecimaldisplay('currency')."') as bal 
      from rrstatus as stat 
      left join client as wh on wh.clientid = stat.whid 
      left join item on item.itemid = stat.itemid 
      where item.barcode = '".$barcode."' 
      and stat.bal <> 0 group by wh.client, stat.loc, stat.expiry";
      
      return $query;
    } //end function 

    public function getAvailableLocationForFilter($barcode,$factor){
      $query = "select '' as expiry, '' as whcode, '' as whname, '' as loc , '-' as bal
      UNION ALL
      select stat.expiry, wh.client as whcode, wh.clientname as whname, stat.loc, 
      round((sum(stat.bal) / ".$factor."),'".Yii::$app->systemsettings->setDecimaldisplay('currency')."') as bal 
      from rrstatus as stat 
      left join client as wh on wh.clientid = stat.whid 
      left join item on item.itemid = stat.itemid 
      where item.barcode = '".$barcode."' 
      group by wh.client, stat.loc, stat.expiry";
      
      return $query;
    } //end function 
    
    public function searchagents($controller,$access,$searchstring){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF VIEW ACCESS IS NOT AVAILABLE
        }else{
            return $data = $this->agentSearch($searchstring);
        }//END ACCESS VALIDATION
    }//END SEARCH WAREHOUSE

    public function searchagentpicker($controller,$access,$searchstring){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF VIEW ACCESS IS NOT AVAILABLE
        }else{
            return $data = $this->agentpickerSearch($searchstring);
        }//END ACCESS VALIDATION
    }//END SEARCH 

    public function searchagentchecker($controller,$access,$searchstring){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF VIEW ACCESS IS NOT AVAILABLE
        }else{
            return $data = $this->agentcheckerSearch($searchstring);
        }//END ACCESS VALIDATION
    }//END SEARCH 

   private function agentpickerSearch($searchthis){
      return "select clientid as agid,client as agcode, clientname as agname , addr as agadd,tel as agtel from client
      where isagent = 1 and uv_ispicker = 1 and 
      (clientname like '%".$searchthis."%' or client like '%".$searchthis."%' or addr like '%".$searchthis."%' or tel like '%".$searchthis."%')
      order by clientname LIMIT 50";
   }//end agent picker search

   private function agentcheckerSearch($searchthis){
      return "select clientid as agid,client as agcode, clientname as agname , addr as agadd,tel as agtel from client
      where isagent = 1 and uv_ischecker = 1 and 
      (clientname like '%".$searchthis."%' or client like '%".$searchthis."%' or addr like '%".$searchthis."%' or tel like '%".$searchthis."%')
      order by clientname LIMIT 50";
   }//ed fn agent checker



    public function search_uvpickers($controller,$access,$searchstring){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF VIEW ACCESS IS NOT AVAILABLE
        }else{
            return $data = $this->uvpickerSearch($searchstring);
        }//END ACCESS VALIDATION
    }//END SEARCH WAREHOUSE


    public function search_uvcheckers($controller,$access,$searchstring){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF VIEW ACCESS IS NOT AVAILABLE
        }else{
            return $data = $this->uvcheckerSearch($searchstring);
        }//END ACCESS VALIDATION
    }//END SEARCH WAREHOUSE

     public function getAvailableLocation($barcode){
        $query = 'select stat.expiry, wh.client as whcode,wh.clientname as whname,stat.loc,sum(stat.bal) as bal from rrstatus as stat
        left join client as wh on wh.clientid = stat.whid
        left join item on item.itemid = stat.itemid
        where item.barcode = "'.$barcode.'" and stat.bal <> 0
        group by wh.client,stat.loc,stat.expiry';
        return $query;
        // return $data = Yii::$app->sbccommon->opentable($query);
    } //end function 


// ##################################### JR UPDATE 04-25-2016 
 public function computesupacctg($params){ // UPDATE JEAR
    //COMPUTATION FOR ISS, AMT AND EXT
        $date =$params['date'];
        $clientid = $params['clientid'];

        switch($params['type']){
            case 'AP':
                return $AP = $this->opensupAP($params['date'],$params['clientid']);
                break;
            case 'AR':
                return $AR = $this->opensupAR($params['date'],$params['clientid']);
                break;
            case 'PDC':
                return $AR = $this->opensupPDC($params['date'],$params['clientid']);
                break;     
            default:
            // $model = new Postock;
            // return $model->openstockline($doc,$trno,$line);
                break;
        }//end switch    
}
// ################################ COMPUTE SUPPLIER ACCTG

  
  private function clientunpaidsearch_KR($searchparam,$ccode) {
    $center=Yii::$app->session['loggeduser']['center'];
    if(!empty($searchparam)){
      $query = "
        select arledger.docno,0 as order1,arledger.trno,arledger.line,
        arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, 
        round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal ,
        left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where cntnum.center = '".$center."' and arledger.kr = 0 and ctbl.client = '".$ccode."'
        and arledger.bal<>0 and (arledger.docno like '%".$searchparam."%' 
        or glhead.yourref like '%".$searchparam."%') order by dateid";
    }else{
        $query = "select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,
        coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
        round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal ,
        left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where cntnum.center = '".$center."' and arledger.kr = 0 and ctbl.client = '".$ccode."' and arledger.bal<>0 order by dateid";
    }

    return $query;
  }

  private function clientunpaidsearch($searchparam,$ccode,$type) {
    if($type == "group"){
      $strclientfilter = "ctbl.grpcode='".$ccode."'";
    }else{
      $strclientfilter = "ctbl.client='".$ccode."'";
    }//end if

    if(!empty($searchparam)){
      $query = "select apledger.docno,0 as order1,apledger.trno,apledger.line,apledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        apledger.clientid,round(apledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(apledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(apledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').")as bal ,left(apledger.dateid,10) as dateid,
        abs(apledger.fdb-apledger.fcr) as fdb,ifnull(glhead.yourref,'') as yourref,gldetail.rem as rem,glhead.rem as hrem from (apledger
        left join coa on coa.acnoid=apledger.acnoid)
        left join glhead on glhead.trno = apledger.trno
        left join gldetail on gldetail.trno=apledger.trno and gldetail.line=apledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = apledger.clientid
        where ".$strclientfilter." and apledger.bal<>0 and (apledger.docno like '%".$searchparam."%' or glhead.yourref like '%".$searchparam."%')
        union all
        select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal ,left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ".$strclientfilter." and arledger.bal<>0 and (arledger.docno like '%".$searchparam."%' or glhead.yourref like '%".$searchparam."%') order by dateid";
    }else{
      $query = "select apledger.docno,0 as order1,apledger.trno,apledger.line,apledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        apledger.clientid,round(apledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(apledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(apledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal ,left(apledger.dateid,10) as dateid,
        abs(apledger.fdb-apledger.fcr) as fdb,ifnull(glhead.yourref,'') as yourref,gldetail.rem as rem,glhead.rem as hrem from (apledger
        left join coa on coa.acnoid=apledger.acnoid)
        left join glhead on glhead.trno = apledger.trno
        left join gldetail on gldetail.trno=apledger.trno and gldetail.line=apledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = apledger.clientid
        where ".$strclientfilter." and apledger.bal<>0
        union all
        select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") ,left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ".$strclientfilter." and arledger.bal<>0 order by dateid";
    }
    return $query;
  }



  public function loadEquiptoolqry($controller,$access){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    }else{
      return "select barcode, itemname,uom, groupid,model,part,category from item where fg_isequipmenttool = 1";
    }
  }//end fn

public function loadMasterqry($controller,$access,$x = '') {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      switch($controller->module->id) {
        case 'fg_colors':
          return "select id as line, code as Code, name as Name,unit,amt from fg_colors";
        break;
        case 'fg_material':
          return "select id as line, code as Code, name as Name from fg_material";
        break;

        //WTODO: [KIM][2019.10.30][add case for mlocation]
        case 'mlocation':
          return "select id as line, code as Code, name as Name from fg_location";
        break;
        
        case 'fg_process':
          return "select id as line, code as Code, name as Name from fg_process";
        break;

        case 'fg_cylinder':
          return "select id as line, code as Code, name as Name from fg_cylinder";
        break;

        case 'part':
          return "select part_id as line, part_code as Code, part_name as Name from part_masterfile
                  where part_code like '%".$x."%' or part_name like '%".$x."%' order by part_id";
        break;

        case 'model':
          return "select model_id as line, model_code as Code, model_name as Name from model_masterfile 
          where model_code like '%".$x."%' or model_name like '%".$x."%' order by model_id";
        break;

        case 'stockgrp':
          return "select stockgrp_id as line, stockgrp_code as Code, stockgrp_name as Name from stockgrp_masterfile
                  where stockgrp_code like '%".$x."%' or stockgrp_name like '%".$x."%' order by stockgrp_id";
        break;
        case 'collection':
          return "select cllc_id as line,cllc_code as Code,cllc_name as Name from collection_area order by cllc_id";
        break;
        case 'distribution':
          return "select dist_id as line,dist_code as Code,dist_name as Name from distribution_area order by dist_id";
        break;
        case 'taxmenu':
          return 'select line,name,atc,rate from taxmenu order by line';
        break;

        case 'categories':
           return "select cat_id as line,cat_name as Name,cat_code as Code from category_masterfile
                   where cat_name like '%".$x."%' order by cat_id";
        break;

        case 'itemclass':
           return "select cl_id as line,cl_code as Code,cl_name as Name from item_class
                   where cl_code like '%".$x."%' or cl_name like '%".$x."%' order by cl_id";
        break;
        case 'stype':
          return "select line,type from stype";
        break;

        case 'prodtype':
          if($x != '') {
            return "select id as line, code, name from prodtype_masterfile where code like '%$x%' or name like '%$x%'";
          } else {
            return "select id as line, code, name from prodtype_masterfile";
          }
        break;
        case 'transform':
          if($x != '') {
            return "select id as line, code, name from transform_masterfile where code like '%$x%' or name like '%$x%'";
          } else {
            return "select id as line, code, name from transform_masterfile";
          }
        break;
        case 'sealing':
          if($x != '') {
            return "select id as line, code, name from sealing_masterfile where code like '%$x%' or name like '%$x%'";
          } else {
            return "select id as line, code, name from sealing_masterfile";
          }
        break;
        case 'plastic':
          if($x != '') {
            return "select id as line, code, name from plastic_masterfile where code like '%$x%' or name like '%$x%'";
          } else {
            return "select id as line, code, name from plastic_masterfile";
          }
        break;

        case 'prodspec':
          if($x != '') {
            return "select id as line, code, name from prodspec_masterfile where code like '%$x%' or name like '%$x%'";
          } else {
            return "select id as line, code, name from prodspec_masterfile";
          }
        break;
        case 'inout':
          if($x != '') {
            return "select id as line, mat_release as code, name from inout_masterfile where mat_release like '%$x%' or name like '%$x%'";
          } else {
            return "select id as line, mat_release as code, name from inout_masterfile";
          }
        break;
        case 'reject':
          if($x != '') {
            return "select id as line, type as code, name from reject_masterfile where type like '%$x%' or name like '%$x%'";
          } else {
            return "select id as line, type as code, name from reject_masterfile";
          }
        break;
      }  
    }
  }

private function opensupAP($date,$clientid){
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid, round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db, round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, 
          round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal, ref, rem, status from
            (select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
            `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
            `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as agent,
            (`detail`.`rem`) as `rem`,((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,
            0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status` from ((((`apledger`
            left join `cntnum` on((`cntnum`.`trno` = `apledger`.`trno`))) left join `gldetail` as detail
            on(((`detail`.`trno` = `apledger`.`trno`) and (`detail`.`line` = `apledger`.`line`))))
            left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`)))) where apledger.clientid= $clientid  and apledger.dateid>='$date'
            and cntnum.center = '$center'
            union all
            select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
            0 as `db`,sum(detail.ext) as `cr`,sum(detail.ext) as `bal`,
            `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
            sum(detail.ext) as `balance`,0 as `fbal`,'' as `reference`,'UNPOSTED' as `status`
            from `lahead` as head
            left join `lastock` as detail on `detail`.`trno` = `head`.`trno`
            left join `client` on `client`.`client` = `head`.`client`
            left join cntnum on cntnum.trno = head.trno 
            where cntnum.doc = 'RR' and client.clientid= $clientid and head.dateid>='$date' and cntnum.center = '$center'
            group by head.docno
            ) as t  order by dateid desc,docno";
        return $data = Yii::$app->sbccommon->opentable($query);
    }//end opensAP    

private function opensupAR($date,$clientid){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid,
                  round(db,2) as db, round(cr,2) as cr,round(bal,2) as bal, ref, agent, rem, status from(
                  select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
                  `arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,`arledger`.`cr` as `cr`,arledger.bal,
                  `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
                  (`detail`.`rem`) as `rem`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
                  0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status` from ((((`arledger`
                  left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
                  on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
                  left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
                  on((`agent`.`clientid` = `arledger`.`agentid`))) where arledger.clientid= $clientid  and arledger.dateid>='$date'
                  and cntnum.center = '$center'
                  union all
                  select head.doc,head.docno,head.trno,stock.line,head.dateid,sum(stock.ext) as db,0 as cr,
                  sum(stock.ext) as bal,client.clientid,'' as ref,'' as agent,
                  stock.rem,sum(stock.ext) as balance,0 as fbal,'' as reference,'UNPOSTED' as status from lahead as head
                  left join lastock as stock on stock.trno = head.trno
                  left join client on client.client = head.client
                  left join cntnum on cntnum.trno = head.trno
                  where head.doc = 'SJ' and client.clientid = $clientid
                  and head.dateid>='$date' and cntnum.center = '$center'
                  group by head.docno) as t  order by dateid desc, docno";

        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openAP    

private function opensupPDC($date,$clientid){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select trno, doc, docno, checkno, checkdate, 
        round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db, 
        round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,ifnull(rem,'') as rem from (
        select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno, gldetail.postdate as checkdate, gldetail.db,
        gldetail.cr,crledger.depodate,concat(`gldetail`.`rem`,'  ',`deposit`.`docno`) as rem,client.clientid
        from glhead left join gldetail on gldetail.trno=glhead.trno  left join crledger on crledger.trno=gldetail.trno
        left join client on client.clientid = gldetail.clientid left join coa on coa.acnoid=gldetail.acnoid left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line
        where left(coa.alias,2)='cr'  and glhead.doc='cr'
        union all
        select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate, ladetail.db,
        ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid
        from lahead left join ladetail on ladetail.trno=lahead.trno left join client on client.client = ladetail.client
        left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='cr' and ladetail.refx=0 and ladetail.linex=0
        union all
        select lbhead.doc,coa.alias,lbhead.trno, lbhead.docno, lbdetail.checkno, lbdetail.postdate, lbdetail.db,
        lbdetail.cr,null as depodate,lbdetail.rem as rem,client.clientid
        from lbhead left join lbdetail on lbdetail.trno=lbhead.trno left join client on client.client = lbdetail.client
        left join coa on coa.acno=lbdetail.acno where left(coa.alias,2)='cr' and lbdetail.refx=0 and lbdetail.linex=0
        union all
        select lchead.doc,coa.alias,lchead.trno, lchead.docno, lcdetail.checkno, lcdetail.postdate, lcdetail.db,
        lcdetail.cr,null as depodate,lcdetail.rem as rem,client.clientid
        from lchead left join lcdetail on lcdetail.trno=lchead.trno left join client on client.client = lcdetail.client
        left join coa on coa.acno=lcdetail.acno where left(coa.alias,2)='cr' and lcdetail.refx=0 and lcdetail.linex=0) as customerpdc where clientid = $clientid and  checkdate >='$date'";

        return Yii::$app->sbccommon->opentable($query);
    }//end openAP        
//####################################### END JR UPDATE

//########################################################### CUSTOMER UPDATE JAOSKI
    //########################################################### CUSTOMER UPDATE JAOSKI
    //USERACCESS

    public function getuserlevels(){
        $data = Yii::$app->sbccommon->opentable("select * from users");
        return $data;
    }

    public function getuseraccess($id){   
        $useraccess= Yii::$app->sbccommon->opentable("select * from useraccess where accessid='$id'");
        return $useraccess;
    }

    public function getuser1($id){   
        $useraccess= Yii::$app->sbccommon->opentable("select * from useraccess 
        left join itimages on itimages.codeid = useraccess.userid and itimages.filename = 'USER'
        where userid='$id'");
        return $useraccess;
    }    

    public function getfirstlevel(){   

           $useraccess= Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where parent='\\\\' and parentid=0 and allowed <> 1 order by code");
              return $useraccess;
        } 

    public function getsecondlevel($code){
        
         return Yii::$app->sbccommon->opentable("select attribute,description,code,parent from attributes where parent='\\".$code."' and parentid=0 and allowed <> 1 order by code");
       }

    public function getthirdlevelsallow($idno,$code){

             return Yii::$app->sbccommon->opentable("
            select attributes.attribute,attributes.description,attributes.code  from attributes
            left join moduleaccess on moduleaccess.attribute=attributes.attribute
            where attributes.parent='\\".$code."' and moduleaccess.idno='$idno'
            and attributes.parentid=0 and attributes.allowed <> 1
            union all
            select attributes.attribute,attributes.description,attributes.code  from attributes
            left join moduleaccess on moduleaccess.attribute=attributes.attribute
            where attributes.code='\\".$code."' and moduleaccess.idno='$idno'
            and attributes.parentid=0 and attributes.allowed <> 1
            order by code");
    }

    public function getthirdlevelsnotallow($idno,$code){

            return  Yii::$app->sbccommon->opentable("
            select attr1.attribute,attr1.description,attr1.code from attributes as attr1
            where (attr1.parent='\\".$code."' or attr1.code='\\".$code."')
            and attr1.parentid=0 and attr1.attribute
            not in (select attr2.attribute from attributes as attr2
            left join moduleaccess on moduleaccess.attribute=attr2.attribute
            where attr2.parent='\\".$code."' and moduleaccess.idno='$idno' and attr2.parentid=0
            and attr2.allowed <> 1
            union all
            select attr3.attribute from attributes as attr3
            left join moduleaccess on moduleaccess.attribute=attr3.attribute
            where attr3.code='\\".$code."' and moduleaccess.idno='$idno'
            and attr3.parentid=0 and attr3.allowed <> 1
            order by code)");
    }   

     

    //END USERACCESS    
    
    public function requestClientid($client){
      return $clientid = Yii::$app->sbccommon->datareader("select clientid from client where client = '".$client."'");
    }//END REQUEST ITEMID

    //EMPLOYEE
    public function requestEmpid($client){
        return $clientid = Yii::$app->sbccommon->datareader("select empid from employee where empcode = '".$client."'");
    }//END REQUEST ITEMID    
    
    public function computeacctg($params){
    //COMPUTATION FOR ISS, AMT AND EXT
    
        $date =$params['date'];
        $clientid = $params['clientid'];

        switch($params['type']){
            case 'AP':
                return $AP = $this->openAP($params['date'],$params['clientid']);
                break;
            case 'AR':
                return $AR = $this->openAR($params['date'],$params['clientid']);
                break;
            case 'PDC':
                return $AR = $this->openPDC($params['date'],$params['clientid']);
                break;
            case 'RC':
                return $AR = $this->openRC($params['date'],$params['clientid']);
                break;          
            default:
                break;
        }//end switch
    }

    public function computeinvtry($params){
    //COMPUTATION FOR ISS, AMT AND EXT
      return $AR = $this->openCStock($params['date'],$params['clientid'],$params['filter']);
    }

    public function computereceiving($params){
    //COMPUTATION FOR ISS, AMT AND EXT
        $date =$params['date'];
        $itemid = $params['itemid'];
        $uom = $params['uom'];
        $wh = $params['wh'];
        return $AR = $this->openRR($params['date'],$params['itemid'],$params['wh'],$params['uom']);
            
    }

    public function computepo($params){
    //COMPUTATION FOR ISS, AMT AND EXT
        $date =$params['date'];
        $itemid = $params['itemid'];
        $uom = $params['uom'];
        $wh = $params['wh'];
        return $AR = $this->openPO($params['date'],$params['itemid'],$params['wh'],$params['uom']);
            
    }

    public function computeso($params){
    //COMPUTATION FOR ISS, AMT AND EXT
        $date =$params['date'];
        $itemid = $params['itemid'];
        $uom = $params['uom'];
        $wh = $params['wh'];
        return $AR = $this->openSO($params['date'],$params['itemid'],$params['wh'],$params['uom']);
            
    }   

    public function computeWh($controller,$access,$itemid){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {
        } else {
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'GALANG': case 'MLCP':
              $qry= "select client.clientname as whname,whid,itemid,round(sum(bal),2) as bal,loc from rrstatus
              left join client on client.clientid = rrstatus.whid
              where itemid =$itemid and bal <> 0 group by whid,loc";
            break;

            case 'UNIVERSE':
              $qry= "select client.clientname as whname,
              rrstatus.whid,rrstatus.loc,rrstatus.itemid,
              case when item.purchase_uom = '' then round((sum(rrstatus.bal) / 1),2) else round((sum(rrstatus.bal) / uom.factor),2) end as purchasebal,
              round(sum(rrstatus.bal),2) as bal from rrstatus
              left join client on client.clientid = rrstatus.whid
              left join item on item.itemid = rrstatus.itemid
              left join uom on uom.uom = item.purchase_uom
              where rrstatus.itemid = ".$itemid."
              group by rrstatus.expiry,rrstatus.loc,rrstatus.whid";
            break;
            
            default:
              $qry= "select client.clientname as whname,whid,itemid,round(sum(bal),2) as bal from rrstatus
              left join client on client.clientid = rrstatus.whid
              where itemid =$itemid group by whid";
            break;
          }//end switch 

          return $qry;
        }
    }//end fn

    public function computeledger($params){
    //COMPUTATION FOR ISS, AMT AND EXT
        $date =$params['date'];
        $itemid = $params['itemid'];
        $uom = $params['uom'];
        $wh = $params['wh'];
        $AR = $this->openLEDGER($params['date'],$params['itemid'],$params['wh'],$params['uom']);

        return $AR;
    }

    private function openAP($date,$clientid){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid, 
            round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db, 
            round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
            round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,
            ref, rem, status from (select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,
            `apledger`.`line` as `line`,
            `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
            `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as agent,
            (`detail`.`rem`) as `rem`,((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,
            0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status` from ((((`apledger`
            left join `cntnum` on((`cntnum`.`trno` = `apledger`.`trno`))) left join `gldetail` as detail
            on(((`detail`.`trno` = `apledger`.`trno`) and (`detail`.`line` = `apledger`.`line`))))
            left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`)))) where apledger.clientid= $clientid  and apledger.dateid>='$date'
            and cntnum.center = '$center'
            union all
            select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
            0 as `db`,sum(detail.ext) as `cr`,sum(detail.ext) as `bal`,
            `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
            sum(detail.ext) as `balance`,0 as `fbal`,'' as `reference`,'UNPOSTED' as `status`
            from `lahead` as head
            left join `lastock` as detail on `detail`.`trno` = `head`.`trno`
            left join `client` on `client`.`client` = `head`.`client`
            left join cntnum on cntnum.trno = head.trno 
            where cntnum.doc = 'RR' and client.clientid= $clientid and head.dateid>='$date' and cntnum.center = '$center'
            group by head.docno) as t  order by dateid desc,docno";

        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openAP


    public static function openAPsum($clientid,$date){
        $center=Yii::$app->session['loggeduser']['center'];
        $data=Yii::$app->sbccommon->opentable("select 
            round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
            round(sum(cr),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
            round(sum(balance),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as balance from
            (select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
            `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
            `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as agent,
            (`detail`.`rem`) as `rem`,((case when (`apledger`.`db` > 0) then -(1) else 1 end) * `apledger`.`bal`) as `balance`,
            0 as `fbal`,`head`.`ourref` as `reference`,'posted' as `status` from ((((`apledger`
            left join `cntnum` on((`cntnum`.`trno` = `apledger`.`trno`))) left join `gldetail` as detail
            on(((`detail`.`trno` = `apledger`.`trno`) and (`detail`.`line` = `apledger`.`line`))))
            left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`)))) where apledger.clientid= $clientid  and apledger.dateid>='$date'
            and cntnum.center = '$center'
            union all
            select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
            0 as `db`,sum(detail.ext) as `cr`,sum(detail.ext) as `bal`,
            `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
            sum(detail.ext) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
            from `lahead` as head
            left join `lastock` as detail on `detail`.`trno` = `head`.`trno`
            left join `client` on `client`.`client` = `head`.`client`
            left join cntnum on cntnum.trno = head.trno
            where cntnum.doc = 'RR' and client.clientid= $clientid  and head.dateid>='$date' and cntnum.center = '$center'
            group by head.docno) as t  order by dateid desc,docno");
             return $data;

    }

    private function openAR($date,$clientid){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid, 
            round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
            round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
            round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,
            ref, agent, rem1,rem2,status,krdoc from
            (select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
            `arledger`.`dateid` as `dateid`,`arledger`.`db`,`arledger`.`cr`,arledger.bal,
            `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
            (`detail`.`rem`) as `rem1`,(`head`.`rem`) as `rem2`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
            0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status`,ifnull(`kr`.`docno`,'') as `krdoc` from ((((`arledger`
            left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
            on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
            left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
            on((`agent`.`clientid` = `arledger`.`agentid`))) left join `transnum` as `kr` on `kr`.`trno` = `arledger`.`kr` where arledger.clientid= $clientid  and arledger.dateid>='$date'
            and cntnum.center = '$center'
            UNION ALL
            select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
            sum(detail.ext) as db,0 as `cr`,sum(detail.ext) as `bal`,
            `client`.`clientid` as `clientid`,'' as `ref`,head.agent as `agent`,`detail`.`rem` as `rem1`,`head`.`rem` as `rem2`,
            sum(detail.ext) as `balance`,0 as `fbal`,'' as `reference`,'UNPOSTED' as `status`,'' as krdoc
            from `lahead` as head
            left join `lastock` as detail on `detail`.`trno` = `head`.`trno`
            left join `client` on `client`.`client` = `head`.`client`
            left join cntnum on cntnum.trno = head.trno
            where cntnum.doc = 'SJ' and client.clientid= $clientid and head.dateid>='$date' and cntnum.center = '$center'
            group by head.docno) as t  order by dateid desc, docno";
        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openAR


    public function openARsum($clientid,$date){
        $center=Yii::$app->session['loggeduser']['center'];
        $qry = "select 
            round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") AS db,
            round(sum(cr),".Yii::$app->systemsettings->setDecimaldisplay('currency').") AS cr, 
            round(sum(balance),".Yii::$app->systemsettings->setDecimaldisplay('currency').") AS balance from
            (select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
            `arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,`arledger`.`cr` as `cr`,arledger.bal,
            `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
            (`detail`.`rem`) as `rem`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
            0 as `fbal`,`head`.`ourref` as `reference`,'posted' as `status` from ((((`arledger`
            left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
            on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
            left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
            on((`agent`.`clientid` = `arledger`.`agentid`))) where arledger.clientid= $clientid  and arledger.dateid>='$date'
            and cntnum.center = '$center'
            union all
            select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
            sum(detail.ext) as `db`,0 as `cr`,sum(detail.ext) as `bal`,
            `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
            sum(detail.ext) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
            from `lahead` as head
            left join `lastock` as detail on `detail`.`trno` = `head`.`trno`
            left join `client` on `client`.`client` = `head`.`client`
            left join cntnum on cntnum.trno = head.trno
            where cntnum.doc = 'SJ' and client.clientid= $clientid  and head.dateid>='$date' and cntnum.center = '$center'
            group by head.docno) as t";
          $data=Yii::$app->sbccommon->opentable($qry);
        return $data;
    }

    private function openPDC($date,$clientid){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select trno, doc, docno, checkno, checkdate, 
        round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,ifnull(rem,'') as rem from (
        select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno,
        left(gldetail.postdate,10) as checkdate, gldetail.db,
        gldetail.cr,crledger.depodate,case when crledger.depodate = null then concat(`gldetail`.`rem`) else concat(`gldetail`.`rem`,'  ',`deposit`.`docno`) end as rem,
        client.clientid from glhead 
        left join gldetail on gldetail.trno=glhead.trno  
        left join crledger on crledger.trno=gldetail.trno and crledger.line = gldetail.line
        left join client on client.clientid = gldetail.clientid 
        left join coa on coa.acnoid=gldetail.acnoid 
        left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line
        where left(coa.alias,2)='cr'  and glhead.doc='cr'
        union all
        select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate, ladetail.db,
        ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid
        from lahead left join ladetail on ladetail.trno=lahead.trno left join client on client.client = ladetail.client
        left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='cr' and ladetail.refx=0 and ladetail.linex=0
        union all
        select lbhead.doc,coa.alias,lbhead.trno, lbhead.docno, lbdetail.checkno, lbdetail.postdate, lbdetail.db,
        lbdetail.cr,null as depodate,lbdetail.rem as rem,client.clientid
        from lbhead left join lbdetail on lbdetail.trno=lbhead.trno left join client on client.client = lbdetail.client
        left join coa on coa.acno=lbdetail.acno where left(coa.alias,2)='cr' and lbdetail.refx=0 and lbdetail.linex=0
        union all
        select lchead.doc,coa.alias,lchead.trno, lchead.docno, lcdetail.checkno, lcdetail.postdate, lcdetail.db,
        lcdetail.cr,null as depodate,lcdetail.rem as rem,client.clientid
        from lchead left join lcdetail on lcdetail.trno=lchead.trno left join client on client.client = lcdetail.client
        left join coa on coa.acno=lcdetail.acno where left(coa.alias,2)='cr' and 
        lcdetail.refx=0 and lcdetail.linex=0) as customerpdc where clientid = $clientid and  checkdate >='$date'";
        
        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openPDC

    public static function openPDCsum($clientid,$date){
        $center=Yii::$app->session['loggeduser']['center'];
        $data=Yii::$app->sbccommon->opentable("select round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(sum(cr),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
        round(0,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as balance  from (
        select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno, gldetail.postdate as checkdate, gldetail.db,
        gldetail.cr,crledger.depodate,concat(`gldetail`.`rem`,'  ',`deposit`.`docno`) as rem,client.clientid
        from glhead 
        left join gldetail on gldetail.trno=glhead.trno  left join crledger on crledger.trno=gldetail.trno and crledger.line = gldetail.line
        left join client on client.clientid = gldetail.clientid 
        left join coa on coa.acnoid=gldetail.acnoid 
        left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line
        where left(coa.alias,2)='cr' and glhead.doc='cr'
        union all
        select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate, ladetail.db,
        ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid
        from lahead 
        left join ladetail on ladetail.trno=lahead.trno 
        left join client on client.client = ladetail.client
        left join coa on coa.acno=ladetail.acno 
        where left(coa.alias,2)='cr' and ladetail.refx=0 and ladetail.linex=0
        union all
        select lbhead.doc,coa.alias,lbhead.trno, lbhead.docno, lbdetail.checkno, lbdetail.postdate, lbdetail.db,
        lbdetail.cr,null as depodate,lbdetail.rem as rem,client.clientid
        from lbhead 
        left join lbdetail on lbdetail.trno=lbhead.trno 
        left join client on client.client = lbdetail.client
        left join coa on coa.acno=lbdetail.acno 
        where left(coa.alias,2)='cr' and lbdetail.refx=0 and lbdetail.linex=0
        union all
        select lchead.doc,coa.alias,lchead.trno, lchead.docno, lcdetail.checkno, lcdetail.postdate, lcdetail.db,
        lcdetail.cr,null as depodate,lcdetail.rem as rem,client.clientid
        from lchead left join lcdetail on lcdetail.trno=lchead.trno left join client on client.client = lcdetail.client
        left join coa on coa.acno=lcdetail.acno where left(coa.alias,2)='cr' and lcdetail.refx=0 and lcdetail.linex=0) as customerpdc where clientid = $clientid and  checkdate >='$date'");
        return $data;
    }//open pdc sum

    private function openRC($date,$clientid){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select docno,dateid,rem,round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,ref from (select `cntnum`.`doc` as `doc`,`arledger`.`docno` as `docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,`arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,
            `arledger`.`cr` as `cr`,(case when (`arledger`.`bal` = 0) then 'applied' else ltrim(`arledger`.`bal`) end) as `bal`,`arledger`.`clientid` as `clientid`,
            arledger.ref as `ref`,agent.client as `agent`,`gldetail`.`rem` as `rem`,
            `arledger`.`bal` as `balance` from (((`arledger` left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`)))
            left join `coa` on((`coa`.`acnoid` = `arledger`.`acnoid`))) left join `gldetail` on(((`gldetail`.`trno` = `arledger`.`trno`)
            and (`gldetail`.`line` = `arledger`.`line`)))) left join client on client.clientid= arledger.clientid left join client as agent on agent.clientid = arledger.agentid where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and arledger.dateid>='$date' and cntnum.center = '$center'
            union all
            select `lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,`lahead`.`trno` as `trno`,`ladetail`.`line` as `line`,`lahead`.`dateid` as `dateid`,`ladetail`.`db` as `db`,
            `ladetail`.`cr` as `cr`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`ladetail`.`ref` as `ref`,'' as `agent`,
            `ladetail`.`rem` as `rem`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `balance`
            from (((`lahead` left join `ladetail` on((`ladetail`.`trno` = `lahead`.`trno`)))
            left join `client` on((`client`.`client` = `ladetail`.`client`)))
            left join `coa` on((`coa`.`acno` = `ladetail`.`acno`))) left join cntnum on cntnum.trno = lahead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lahead.dateid>='$date' and cntnum.center = '$center' and ladetail.refx=0 and ladetail.linex=0
            union all
            select `lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,`lbhead`.`trno` as `trno`,`lbdetail`.`line` as `line`,`lbhead`.`dateid` as `dateid`,`lbdetail`.`db` as `db`,
            `lbdetail`.`cr` as `cr`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lbdetail`.`ref` as `ref`,'' as `agent`,
            `lbdetail`.`rem` as `rem`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `balance`
             from (((`lbhead` left join `lbdetail` on((`lbdetail`.`trno` = `lbhead`.`trno`)))
             left join `client` on((`client`.`client` = `lbdetail`.`client`)))
             left join `coa` on((`coa`.`acno` = `lbdetail`.`acno`))) left join cntnum on cntnum.trno = lbhead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lbhead.dateid>='$date' and cntnum.center = '$center' and lbdetail.refx=0 and lbdetail.linex=0
             union all
             select `lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,`lchead`.`trno` as `trno`,`lcdetail`.`line` as `line`,`lchead`.`dateid` as `dateid`,`lcdetail`.`db` as `db`,
            `lcdetail`.`cr` as `cr`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lcdetail`.`ref` as `ref`,'' as `agent`,
            `lcdetail`.`rem` as `rem`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `balance`
            from (((`lchead` left join `lcdetail` on((`lcdetail`.`trno` = `lchead`.`trno`)))
            left join `client` on((`client`.`client` = `lcdetail`.`client`)))
            left join `coa` on((`coa`.`acno` = `lcdetail`.`acno`))) left join cntnum on cntnum.trno = lchead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lchead.dateid>='$date' and cntnum.center = '$center' and lcdetail.refx=0 and lcdetail.linex=0) as T";

        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openRC


    public function searchComputeacctg($controller,$access,$clientid,$date,$type) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      $center=Yii::$app->session['loggeduser']['center'];
      switch($controller->module->id) {
        case 'customer':
          switch($type) {
            case 'AP':
              return "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid, dateid as orderdate,
                round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db, 
                round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
                round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,
                ref, rem, status from (select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,
                `apledger`.`line` as `line`,
                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as agent,
                (`detail`.`rem`) as `rem`,((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,
                0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status` from ((((`apledger`
                left join `cntnum` on((`cntnum`.`trno` = `apledger`.`trno`))) left join `gldetail` as detail
                on(((`detail`.`trno` = `apledger`.`trno`) and (`detail`.`line` = `apledger`.`line`))))
                left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`)))) where apledger.clientid= $clientid  and apledger.dateid>='$date'
                and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ap' and detail.refx=0 and detail.linex=0 and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status` from
                (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date'
                and left(`coa`.`alias`,2) = 'ap' and detail.refx=0 and detail.linex=0 and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ap' and detail.refx=0 and detail.linex=0  and cntnum.center = '$center'
                union all
                select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as `agent`,(`detail`.`rem`) as `rem`,
                ((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,0 as `fbal`,
                `head`.`ourref` as `reference`,'POSTED' as `status` from hglhead as head
                left join hgldetail as detail on detail.trno = head.trno left join `cntnum` on `cntnum`.`trno` = `head`.`trno`
                left join apledger on apledger.trno = detail.trno and apledger.line = detail.line
                where  apledger.clientid= $clientid  and apledger.dateid>='$date'  and cntnum.center = '$center'
                ) as t order by orderdate desc";
            break;
            case 'AR':
              return "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid, dateid as trdate, 
                round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
                round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
                round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,
                ref, agent, rem1,rem2,status,krdoc,yourref from
                (select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
                `arledger`.`dateid` as `dateid`,`arledger`.`db`,`arledger`.`cr`,arledger.bal,
                `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
                (`detail`.`rem`) as `rem1`,(`head`.`rem`) as `rem2`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
                0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status`,ifnull(`kr`.`docno`,'') as `krdoc`,head.yourref from ((((`arledger`
                left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
                on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
                left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
                on((`agent`.`clientid` = `arledger`.`agentid`))) left join `transnum` as `kr` on `kr`.`trno` = `arledger`.`kr` where arledger.clientid= $clientid  and arledger.dateid>='$date'
                and cntnum.center = '$center'
                UNION ALL
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db`,`detail`.`cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem1`,`head`.`rem` as `rem2`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`,'' as krdoc,head.yourref
                from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ar' and detail.refx=0 and detail.linex=0  and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db`,`detail`.`cr` ,abs((`detail`.`db` - `detail`.`cr`)) as bal,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem1`,`head`.`rem` as `rem2`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`,'' as krdoc,head.yourref from
                (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date'
                and left(`coa`.`alias`,2) = 'ar' and detail.refx=0 and detail.linex=0 and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db`,`detail`.`cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem1`,`head`.`rem` as `rem2`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`,'' as krdoc,head.yourref
                from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ar' and detail.refx=0 and detail.linex=0  and cntnum.center = '$center') as t  order by trdate desc";
            break;
            case 'PDC':
              return "select trno, doc, docno, checkno, checkdate, round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db, round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,ifnull(rem,'') as rem from (
                select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno, left(gldetail.postdate,10) as checkdate, gldetail.db,
                gldetail.cr,crledger.depodate,concat(`gldetail`.`rem`,'  ',`deposit`.`docno`) as rem,client.clientid
                from glhead left join gldetail on gldetail.trno=glhead.trno  left join crledger on crledger.trno=gldetail.trno
                left join client on client.clientid = gldetail.clientid left join coa on coa.acnoid=gldetail.acnoid left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line
                where left(coa.alias,2)='cr'  and glhead.doc='cr'
                union all
                select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate, ladetail.db,
                ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid
                from lahead left join ladetail on ladetail.trno=lahead.trno left join client on client.client = ladetail.client
                left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='cr' and ladetail.refx=0 and ladetail.linex=0
                union all
                select lbhead.doc,coa.alias,lbhead.trno, lbhead.docno, lbdetail.checkno, lbdetail.postdate, lbdetail.db,
                lbdetail.cr,null as depodate,lbdetail.rem as rem,client.clientid
                from lbhead left join lbdetail on lbdetail.trno=lbhead.trno left join client on client.client = lbdetail.client
                left join coa on coa.acno=lbdetail.acno where left(coa.alias,2)='cr' and lbdetail.refx=0 and lbdetail.linex=0
                union all
                select lchead.doc,coa.alias,lchead.trno, lchead.docno, lcdetail.checkno, lcdetail.postdate, lcdetail.db,
                lcdetail.cr,null as depodate,lcdetail.rem as rem,client.clientid
                from lchead left join lcdetail on lcdetail.trno=lchead.trno left join client on client.client = lcdetail.client
                left join coa on coa.acno=lcdetail.acno where left(coa.alias,2)='cr' and lcdetail.refx=0 and lcdetail.linex=0) as customerpdc 
                where clientid = $clientid and  checkdate >='$date' order by checkdate desc";
            break;
            case 'RC':
              return "select docno,dateid,rem,round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
                round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,ref from (select `cntnum`.`doc` as `doc`,`arledger`.`docno` as `docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,`arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,
                `arledger`.`cr` as `cr`,(case when (`arledger`.`bal` = 0) then 'applied' else ltrim(`arledger`.`bal`) end) as `bal`,`arledger`.`clientid` as `clientid`,
                arledger.ref as `ref`,agent.client as `agent`,`gldetail`.`rem` as `rem`,
                `arledger`.`bal` as `balance` from (((`arledger` left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`)))
                left join `coa` on((`coa`.`acnoid` = `arledger`.`acnoid`))) left join `gldetail` on(((`gldetail`.`trno` = `arledger`.`trno`)
                and (`gldetail`.`line` = `arledger`.`line`)))) left join client on client.clientid= arledger.clientid left join client as agent on agent.clientid = arledger.agentid where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and arledger.dateid>='$date' and cntnum.center = '$center'
                union all
                select `lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,`lahead`.`trno` as `trno`,`ladetail`.`line` as `line`,`lahead`.`dateid` as `dateid`,`ladetail`.`db` as `db`,
                `ladetail`.`cr` as `cr`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`ladetail`.`ref` as `ref`,'' as `agent`,
                `ladetail`.`rem` as `rem`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `balance`
                from (((`lahead` left join `ladetail` on((`ladetail`.`trno` = `lahead`.`trno`)))
                left join `client` on((`client`.`client` = `ladetail`.`client`)))
                left join `coa` on((`coa`.`acno` = `ladetail`.`acno`))) left join cntnum on cntnum.trno = lahead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lahead.dateid>='$date' and cntnum.center = '$center' and ladetail.refx=0 and ladetail.linex=0
                union all
                select `lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,`lbhead`.`trno` as `trno`,`lbdetail`.`line` as `line`,`lbhead`.`dateid` as `dateid`,`lbdetail`.`db` as `db`,
                `lbdetail`.`cr` as `cr`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lbdetail`.`ref` as `ref`,'' as `agent`,
                `lbdetail`.`rem` as `rem`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `balance`
                 from (((`lbhead` left join `lbdetail` on((`lbdetail`.`trno` = `lbhead`.`trno`)))
                 left join `client` on((`client`.`client` = `lbdetail`.`client`)))
                 left join `coa` on((`coa`.`acno` = `lbdetail`.`acno`))) left join cntnum on cntnum.trno = lbhead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lbhead.dateid>='$date' and cntnum.center = '$center' and lbdetail.refx=0 and lbdetail.linex=0
                 union all
                 select `lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,`lchead`.`trno` as `trno`,`lcdetail`.`line` as `line`,`lchead`.`dateid` as `dateid`,`lcdetail`.`db` as `db`,
                `lcdetail`.`cr` as `cr`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lcdetail`.`ref` as `ref`,'' as `agent`,
                `lcdetail`.`rem` as `rem`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `balance`
                from (((`lchead` left join `lcdetail` on((`lcdetail`.`trno` = `lchead`.`trno`)))
                left join `client` on((`client`.`client` = `lcdetail`.`client`)))
                left join `coa` on((`coa`.`acno` = `lcdetail`.`acno`))) left join cntnum on cntnum.trno = lchead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lchead.dateid>='$date' and cntnum.center = '$center' and lcdetail.refx=0 and lcdetail.linex=0) as T
                order by dateid desc";
            break;
          }
        break;
        case 'supplier':
          switch($type) {
            case 'AP':
              return "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid, dateid as orderdate,
                round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db, 
                round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, 
                round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal, ref, rem, status from
                (select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as agent,
                (`detail`.`rem`) as `rem`,((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,
                0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status` from ((((`apledger`
                left join `cntnum` on((`cntnum`.`trno` = `apledger`.`trno`))) left join `gldetail` as detail
                on(((`detail`.`trno` = `apledger`.`trno`) and (`detail`.`line` = `apledger`.`line`))))
                left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`)))) where apledger.clientid= $clientid  and apledger.dateid>='$date'
                and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= 21  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ap' and detail.refx=0 and detail.linex=0 and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status` from
                (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= 21  and head.dateid>='$date'
                and left(`coa`.`alias`,2) = 'ap' and detail.refx=0 and detail.linex=0 and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `head`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= 21  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ap' and detail.refx=0 and detail.linex=0  and cntnum.center = '$center'
                union all
                select `cntnum`.`doc` as `doc`,apledger.`docno`,`apledger`.`trno` as `trno`,`apledger`.`line` as `line`,
                `apledger`.`dateid` as `dateid`,`apledger`.`db` as `db`,`apledger`.`cr` as `cr`,apledger.bal,
                `apledger`.`clientid` as `clientid`,`apledger`.`ref` as `ref`,'' as `agent`,(`detail`.`rem`) as `rem`,
                ((case when (`apledger`.`db` > 0) then 1 else -(1) end) * `apledger`.`bal`) as `balance`,0 as `fbal`,
                `head`.`ourref` as `reference`,'POSTED' as `status` from hglhead as head
                left join hgldetail as detail on detail.trno = head.trno left join `cntnum` on `cntnum`.`trno` = `head`.`trno`
                left join apledger on apledger.trno = detail.trno and apledger.line = detail.line
                where  apledger.clientid= $clientid  and apledger.dateid>='$date'  and cntnum.center = '$center'
                ) as t order by orderdate desc";
            break;
            case 'AR':
              return "select trno, line, doc, docno, date_format(dateid,'%m/%d/%y') as dateid, dateid as orderdate ,
                round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
                round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, 
                round(bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal, ref, agent, rem, status from
                (select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
                `arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,`arledger`.`cr` as `cr`,arledger.bal,
                `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,
                (`detail`.`rem`) as `rem`,((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,
                0 as `fbal`,`head`.`ourref` as `reference`,'POSTED' as `status` from ((((`arledger`
                left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`))) left join `gldetail` as detail
                on(((`detail`.`trno` = `arledger`.`trno`) and (`detail`.`line` = `arledger`.`line`))))
                left join `glhead` as head on((`head`.`trno` = `cntnum`.`trno`))) left join `client` `agent`
                on((`agent`.`clientid` = `arledger`.`agentid`))) where arledger.clientid= $clientid  and arledger.dateid>='$date'
                and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `detail`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ar' and detail.refx=0 and detail.linex=0  and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status` from
                (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `client`
                on((`client`.`client` = `detail`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date'
                and left(`coa`.`alias`,2) = 'ar' and detail.refx=0 and detail.linex=0 and cntnum.center = '$center'
                union all
                select `head`.`doc` as `doc`,head.docno,`head`.`trno` as `trno`,`detail`.`line` as `line`,`head`.`dateid` as `dateid`,
                `detail`.`db` as `db`,`detail`.`cr` as `cr`,abs((`detail`.`db` - `detail`.`cr`)) as `bal`,
                `client`.`clientid` as `clientid`,'' as `ref`,'' as `agent`,`detail`.`rem` as `rem`,
                abs((`detail`.`db` - `detail`.`cr`)) as `balance`,0 as `fbal`,'' as `reference`,'' as `status`
                from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`)))
                left join `client` on((`client`.`client` = `detail`.`client`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
                left join cntnum on cntnum.trno = head.trno where client.clientid= $clientid  and head.dateid>='$date' and
                left(`coa`.`alias`,2) = 'ar' and detail.refx=0 and detail.linex=0  and cntnum.center = '$center'
                union all
                select `cntnum`.`doc` as `doc`,arledger.`docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,
                `arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,`arledger`.`cr` as `cr`,arledger.bal,
                `arledger`.`clientid` as `clientid`,`arledger`.`ref` as `ref`,`agent`.`client` as `agent`,(`detail`.`rem`) as `rem`,
                ((case when (`arledger`.`db` > 0) then 1 else -(1) end) * `arledger`.`bal`) as `balance`,0 as `fbal`,
                `head`.`ourref` as `reference`,'POSTED' as `status` from hglhead as head
                left join hgldetail as detail on detail.trno = head.trno left join `cntnum` on `cntnum`.`trno` = `head`.`trno`
                left join arledger on arledger.trno = detail.trno and arledger.line = detail.line
                left join `client` `agent` on `agent`.`clientid` = `arledger`.`agentid` where
                arledger.clientid= $clientid  and arledger.dateid>='$date'  and cntnum.center = '$center'
                ) as t  order by orderdate desc ";
            break;
            case 'PDC':
              return "select trno, doc, docno, checkno, checkdate, 
                round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db, 
                round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,ifnull(rem,'') as rem from (
                select glhead.doc,coa.alias,glhead.trno, glhead.docno, gldetail.checkno, gldetail.postdate as checkdate, gldetail.db,
                gldetail.cr,crledger.depodate,concat(`gldetail`.`rem`,'  ',`deposit`.`docno`) as rem,client.clientid
                from glhead left join gldetail on gldetail.trno=glhead.trno  left join crledger on crledger.trno=gldetail.trno
                left join client on client.clientid = gldetail.clientid left join coa on coa.acnoid=gldetail.acnoid left join deposit on deposit.refx = crledger.trno and deposit.linex = crledger.line
                where left(coa.alias,2)='cr'  and glhead.doc='cr'
                union all
                select lahead.doc,coa.alias,lahead.trno, lahead.docno, ladetail.checkno, ladetail.postdate, ladetail.db,
                ladetail.cr,null as depodate,ladetail.rem as rem,client.clientid
                from lahead left join ladetail on ladetail.trno=lahead.trno left join client on client.client = ladetail.client
                left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='cr' and ladetail.refx=0 and ladetail.linex=0
                union all
                select lbhead.doc,coa.alias,lbhead.trno, lbhead.docno, lbdetail.checkno, lbdetail.postdate, lbdetail.db,
                lbdetail.cr,null as depodate,lbdetail.rem as rem,client.clientid
                from lbhead left join lbdetail on lbdetail.trno=lbhead.trno left join client on client.client = lbdetail.client
                left join coa on coa.acno=lbdetail.acno where left(coa.alias,2)='cr' and lbdetail.refx=0 and lbdetail.linex=0
                union all
                select lchead.doc,coa.alias,lchead.trno, lchead.docno, lcdetail.checkno, lcdetail.postdate, lcdetail.db,
                lcdetail.cr,null as depodate,lcdetail.rem as rem,client.clientid
                from lchead left join lcdetail on lcdetail.trno=lchead.trno left join client on client.client = lcdetail.client
                left join coa on coa.acno=lcdetail.acno where left(coa.alias,2)='cr' and lcdetail.refx=0 and lcdetail.linex=0) as customerpdc where clientid = $clientid and  checkdate >='$date'
                order by checkdate desc";
            break;
          }
        break;
      }
    }
  }


    public static function openRCsum($clientid,$date){
        $center=Yii::$app->session['loggeduser']['center'];
        $data=Yii::$app->sbccommon->opentable("select round(sum(db),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(sum(cr),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,round(0,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as balance from (select `cntnum`.`doc` as `doc`,`arledger`.`docno` as `docno`,`arledger`.`trno` as `trno`,`arledger`.`line` as `line`,`arledger`.`dateid` as `dateid`,`arledger`.`db` as `db`,
            `arledger`.`cr` as `cr`,(case when (`arledger`.`bal` = 0) then 'applied' else ltrim(`arledger`.`bal`) end) as `bal`,`arledger`.`clientid` as `clientid`,
            arledger.ref as `ref`,agent.client as `agent`,`gldetail`.`rem` as `rem`,
            `arledger`.`bal` as `balance` from (((`arledger` left join `cntnum` on((`cntnum`.`trno` = `arledger`.`trno`)))
            left join `coa` on((`coa`.`acnoid` = `arledger`.`acnoid`))) left join `gldetail` on(((`gldetail`.`trno` = `arledger`.`trno`)
            and (`gldetail`.`line` = `arledger`.`line`)))) left join client on client.clientid= arledger.clientid left join client as agent on agent.clientid = arledger.agentid where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and arledger.dateid>='$date' and cntnum.center = '$center'
            union all
            select `lahead`.`doc` as `doc`,`lahead`.`docno` as `docno`,`lahead`.`trno` as `trno`,`ladetail`.`line` as `line`,`lahead`.`dateid` as `dateid`,`ladetail`.`db` as `db`,
            `ladetail`.`cr` as `cr`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`ladetail`.`ref` as `ref`,'' as `agent`,
            `ladetail`.`rem` as `rem`,abs((`ladetail`.`db` - `ladetail`.`cr`)) as `balance`
            from (((`lahead` left join `ladetail` on((`ladetail`.`trno` = `lahead`.`trno`)))
            left join `client` on((`client`.`client` = `ladetail`.`client`)))
            left join `coa` on((`coa`.`acno` = `ladetail`.`acno`))) left join cntnum on cntnum.trno = lahead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lahead.dateid>='$date' and cntnum.center = '$center' and ladetail.refx=0 and ladetail.linex=0
            union all
            select `lbhead`.`doc` as `doc`,`lbhead`.`docno` as `docno`,`lbhead`.`trno` as `trno`,`lbdetail`.`line` as `line`,`lbhead`.`dateid` as `dateid`,`lbdetail`.`db` as `db`,
            `lbdetail`.`cr` as `cr`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lbdetail`.`ref` as `ref`,'' as `agent`,
            `lbdetail`.`rem` as `rem`,abs((`lbdetail`.`db` - `lbdetail`.`cr`)) as `balance`
             from (((`lbhead` left join `lbdetail` on((`lbdetail`.`trno` = `lbhead`.`trno`)))
             left join `client` on((`client`.`client` = `lbdetail`.`client`)))
             left join `coa` on((`coa`.`acno` = `lbdetail`.`acno`))) left join cntnum on cntnum.trno = lbhead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lbhead.dateid>='$date' and cntnum.center = '$center' and lbdetail.refx=0 and lbdetail.linex=0
             union all
             select `lchead`.`doc` as `doc`,`lchead`.`docno` as `docno`,`lchead`.`trno` as `trno`,`lcdetail`.`line` as `line`,`lchead`.`dateid` as `dateid`,`lcdetail`.`db` as `db`,
            `lcdetail`.`cr` as `cr`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `bal`,`client`.`clientid` as `clientid`,`lcdetail`.`ref` as `ref`,'' as `agent`,
            `lcdetail`.`rem` as `rem`,abs((`lcdetail`.`db` - `lcdetail`.`cr`)) as `balance`
            from (((`lchead` left join `lcdetail` on((`lcdetail`.`trno` = `lchead`.`trno`)))
            left join `client` on((`client`.`client` = `lcdetail`.`client`)))
            left join `coa` on((`coa`.`acno` = `lcdetail`.`acno`))) left join cntnum on cntnum.trno = lchead.trno where (`coa`.`alias` = 'arb')  and client.clientid= $clientid  and lchead.dateid>='$date' and cntnum.center = '$center' and lcdetail.refx=0 and lcdetail.linex=0) as T");
             return $data;
      }


      public function convertForex($forex,$floatamt,$qty){
        $forex = (floatval($floatamt) * floatval($forex)) * floatval($qty);
        return $forex;
      }//end function


    private function openCStock($date,$clientid,$filter){
        try {
        //TODO
        $filterstring = "";

        if($filter != ''){
          $keyword = explode(",", $filter);
          foreach ($keyword as $key) {
            $filterstring = $filterstring . " and (head.docno like '%".$key."%' or item.barcode like '%".$key."%' or stock.itemname like '%".$key."%')";
          }//end for each
        }//end if

        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select salestype,transtype,agent,agent2,trno,doc,clientid,docno,left(dateid,10) as dateid,
        barcode,itemname,uom,disc,cost,isamt,isqty,rrqty,loc,client,clientname,addr,tel,email,tin,mobile,
        contact,rem,fax from (
        select head.salestype,
        case cntnum.transtype
        when 'R' then 'Regular Transaction'
        when 'S' then 'Senior Transaction'
        when 'RT' then 'Return Transaction - Regular'
        when 'ST' then 'Return Transaction - Senior' 
        when '' then '' end as transtype,ifnull(agent.clientname,'') as agent,ifnull(agent2.clientname,'') as agent2,
        head.trno,head.doc,head.clientid,head.docno,head.dateid, item.barcode,
        stock.itemname,stock.uom,stock.disc,stock.cost,stock.isamt,stock.isqty,stock.rrqty,stock.loc,
        client.client,client.clientname,client.addr,client.tel,client.email,client.tin, client.mobile,client.contact,client.rem,
        client.fax from glstock as stock
        left join glhead as head on head.trno = stock.trno
        left join item on item.itemid = stock.itemid
        left join client on client.clientid = head.clientid
        left join client as agent on agent.clientid = stock.agentid
        left join client as agent2 on agent2.clientid = stock.agentid2
        left join cntnum on cntnum.trno = head.trno
        where head.doc in ('rr','dm','sj','cm','aj','ts','cf','pu','cs','es','er')
        and client.clientid =".$clientid." and head.dateid>='".$date."' and cntnum.center ='".$center."'".$filterstring."
        union all
        select head.salestype,case cntnum.transtype
        when 'R' then 'Regular Transaction'
        when 'S' then 'Senior Transaction'
        when 'RT' then 'Return Transaction - Regular'
        when 'ST' then 'Return Transaction - Senior' 
        when '' then '' end as transtype,ifnull(agent.clientname,'') as agent,ifnull(agent2.clientname,'') as agent2,
        head.trno,head.doc,client.clientid,head.docno,head.dateid,stock.barcode,stock.itemname,stock.uom,stock.disc,
        stock.cost,stock.isamt,stock.isqty,stock.rrqty,stock.loc, client.client,client.clientname,client.addr,
        client.tel,client.email,client.tin,client.mobile,client.contact,client.rem,client.fax
        from lastock as stock
        left join lahead as head on head.trno = stock.trno
        left join item on item.barcode = stock.barcode
        left join client on client.client = head.client
        left join client as agent on agent.client = stock.agent
        left join client as agent2 on agent2.client = stock.agent2
        left join cntnum on cntnum.trno = head.trno
        where head.doc in ('rr','dm','sj','cm','aj','ts','cf','pu','cs','es','er') 
        and client.clientid =".$clientid." and head.dateid>='".$date."' and cntnum.center ='".$center."'".$filterstring.") as tbl
        order by dateid desc";
        
        return $data = Yii::$app->sbccommon->opentable($query);
        } catch (ErrorException $e) {
          echo $e;
        }
    }//end openCStock


    private function openRR($date,$itemid,$wh,$uom){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];

        $query = "select cntnum.doc, rrstatus.trno, rrstatus.line, client.clientname, 
        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
        round(ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as cost,
        round((rrstatus.qty / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        cast((case when rrstatus.bal=0 then 'applied' else round((rrstatus.bal / (case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") end) as char(50)) as status,left(rrstatus.dateid,10) as dateid, rrstatus.whid, rrstatus.uom, rrstatus.disc, rrstatus.docno, rrstatus.loc,rrstatus.expiry,rrstatus.isimport,stock.rem from rrstatus 
        left join client on client.clientid=rrstatus.clientid 
        left join client as wh on wh.clientid=rrstatus.whid
        left join item on item.itemid=rrstatus.itemid 
        left join uom on uom.itemid=rrstatus.itemid and uom.uom='".$uom."'
        left join cntnum on cntnum.trno=rrstatus.trno
        left join glstock as stock on stock.trno = rrstatus.trno and stock.line = rrstatus.line
        where rrstatus.itemid=".$itemid." and wh.client='".$wh."' group by rrstatus.trno,rrstatus.line
        order by rrstatus.dateid desc";
        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openCStock

    private function openPO($date,$itemid,$wh,$uom){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select pohead.trno, pohead.doc, pohead.docno,left(pohead.dateid,10) as dateid, clientname,
            round((postock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
            round((qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
            round((postock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,
            pohead.rem,postock.void
            from ((postock left join pohead on pohead.trno=postock.trno) 
            left join item on item.barcode=postock.barcode) 
            left join uom on uom.itemid=item.itemid and uom.uom='$uom' 
            left join transnum as cntnum on cntnum.trno = pohead.trno 
            where item.itemid=$itemid and postock.wh ='$wh'
            and pohead.dateid>='$date' and cntnum.center ='$center'
            UNION ALL
            select hpohead.trno, hpohead.doc, hpohead.docno,left(hpohead.dateid,10) as dateid, clientname,
            round((hpostock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
            round((qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
            round((hpostock.qty/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,hpohead.rem,hpostock.void from ((hpostock left join hpohead on hpohead.trno=hpostock.trno) 
            left join item on item.barcode=hpostock.barcode) left join uom on uom.itemid=item.itemid
            and uom.uom='$uom' left join transnum as cntnum on cntnum.trno = hpohead.trno where item.itemid=$itemid and hpostock.wh ='$wh'
            and hpohead.dateid>='$date' and cntnum.center ='$center' order by dateid";
        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openCStock


    private function openSO($date,$itemid,$wh,$uom){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select sohead.rem,sohead.trno, sohead.doc, sohead.docno, left(sohead.dateid,10) as dateid,
        clientname, 
        round(sostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        round(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round((sostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (sostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,
        round(sostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,sostock.void from sostock
        left join sohead on sohead.trno=sostock.trno
        left join item on item.barcode=sostock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        left join transnum as cntnum on cntnum.trno = sohead.trno
        where item.itemid=".$itemid." and sostock.wh ='".$wh."' and sohead.dateid>='".$date."' and cntnum.center ='".$center."'
        union all
        select hsohead.rem,hsohead.trno, hsohead.doc, hsohead.docno, left(hsohead.dateid,10) as dateid,
        clientname, 
        round(hsostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        round(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round((hsostock.iss/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)) - (hsostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end)),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as balance,
        round(hsostock.qa/(case when ifnull(uom.factor, 0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,hsostock.void from hsostock
        left join hsohead on hsohead.trno=hsostock.trno
        left join item on item.barcode=hsostock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        left join transnum as cntnum on cntnum.trno = hsohead.trno
        where item.itemid=".$itemid." and hsostock.wh ='".$wh."'
        and hsohead.dateid>='".$date."' and cntnum.center ='".$center."' order by dateid";

        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openCStock

    private function openWH($date,$itemid,$wh,$uom){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "select wh.client,wh.clientname,sum(rrstatus.bal) as balance from rrstatus left join client as wh on wh.clientid=rrstatus.whid where
            rrstatus.itemid=$itemid and rrstatus.bal>0 group by wh.client,wh.clientname";

        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openCStock

    private function openLEDGER($date,$itemid,$wh,$uom){
        //TODO : 
        $center=Yii::$app->session['loggeduser']['center'];
        $query = "
        select '' as posted, head.trno, head.doc, head.docno, left(head.dateid,10) as dateid, head.clientname,
        round(ifnull(stock.rrcost,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
        stock.wh, 
        round(ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
        round(ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round(ifnull((stock.amt * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
        round(ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        stock.disc, head.yourref, head.ourref, ifnull(head.cur,'P') as cur, ifnull(head.forex,1) as forex,
        (case when stock.iss<>0 then 1 else 0 end) as type, head.isimport, head.factor, head.rem, 0 as balance, item.itemid,
        stock.loc,stock.expiry from lahead as head 
        left join lastock as stock on stock.trno=head.trno 
        left join item on item.barcode=stock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and item.itemid=".$itemid." and head.dateid>='".$date."'
        and stock.wh='".$wh."'
        UNION ALL
        select '' as posted, head.trno, head.doc, head.docno,left(head.dateid,10) as dateid, head.clientname,
        round(ifnull(stock.rrcost,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
        stock.wh, 
        round(ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
        round(ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round(ifnull((stock.amt * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
        round(ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        stock.disc, head.yourref, head.ourref, ifnull(head.cur,'P') as cur, ifnull(head.forex,1) as forex,
        (case when stock.iss<>0 then 1 else 0 end) as type, head.isimport, head.factor, head.rem, 0 as balance, item.itemid, stock.loc,stock.expiry
        from lbhead as head 
        left join lbstock as stock on stock.trno=head.trno 
        left join item on item.barcode=stock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and item.itemid=".$itemid." and head.dateid>='".$date."' and stock.wh='".$wh."'
        UNION ALL
        select '' as posted, head.trno, head.doc, head.docno, left(head.dateid,10) as dateid, head.clientname, round(ifnull(stock.rrcost,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
        stock.wh, 
        round(ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
        round(ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round(ifnull((stock.amt * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
        round(ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        stock.disc, head.yourref, head.ourref, ifnull(head.cur,'P') as cur, ifnull(head.forex,1) as forex,
        (case when stock.iss<>0 then 1 else 0 end) as type, head.isimport, head.factor, head.rem, 0 as balance, item.itemid, stock.loc,stock.expiry
        from lchead as head left join lcstock as stock on stock.trno=head.trno left join item on item.barcode=stock.barcode
        left join uom on uom.itemid=item.itemid and uom.uom='".$uom."'
        where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and item.itemid=".$itemid." and head.dateid>='".$date."' and stock.wh='".$wh."'
        UNION ALL
        select 'POSTED' as posted, head.trno, head.doc, head.docno, left(head.dateid,10) as dateid, head.clientname,
        round(ifnull(stock.rrcost,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,wh.client as wh, 
        round(ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
        round(ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round(ifnull((stock.amt * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
        round(ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        stock.disc, head.yourref, head.ourref, ifnull(head.cur,'P') as cur, ifnull(head.forex,1) as forex,
        (case when stock.iss<>0 then 1 else 0 end) as type, head.isimport, head.factor, head.rem, 0 as balance, stock.itemid, stock.loc,stock.expiry
        from glhead as head left join glstock as stock on stock.trno=head.trno 
        left join uom on uom.itemid=stock.itemid and uom.uom='".$uom."'
        left join client as wh on wh.clientid=stock.whid
        where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and stock.itemid=".$itemid." and head.dateid>='".$date."' and wh.client='".$wh."'
        UNION ALL
        select 'POSTED' as posted, head.trno, head.doc, head.docno,left(head.dateid,10) as dateid, head.clientname, round(ifnull(stock.rrcost,0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
        wh.client as wh, 
        round(ifnull((stock.cost * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
        round(ifnull((stock.qty / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
        round(ifnull((stock.amt * (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
        round(ifnull((stock.iss / (case when ifnull(uom.factor,0)=0 then 1 else uom.factor end)),0),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
        stock.disc, head.yourref, head.ourref, ifnull(head.cur,'P') as cur, ifnull(head.forex,1) as forex,
        (case when stock.iss<>0 then 1 else 0 end) as type, head.isimport, head.factor, head.rem, 0 as balance, stock.itemid, stock.loc,stock.expiry
        from hglhead as head left join hglstock as stock on stock.trno=head.trno 
        left join uom on uom.itemid=stock.itemid and uom.uom='".$uom."'
      and uom.uom=stock.uom left join client as wh on wh.clientid=stock.whid
      where head.doc in ('RR','DM','SJ','CM','IS','AJ','TS','PK','MI') and stock.itemid=".$itemid." and head.dateid>='".$date."' and wh.client='".$wh."' order by dateid desc,trno desc";
        return $data = Yii::$app->sbccommon->opentable($query);
    }//end openCStock
//########################################################### CUSTOMER UPDATE JAOSKI

//########################################################## GJ UPDATE JAOSKI
    public function retrieveSelectedUnpaid($ccode,$params,$lookuptype = ''){
      try {
        foreach ($params as $key => $value) {
            $data[$key] = $this->retrieveUnpaidData($ccode,$params[$key]['trno'],$params[$key]['line'],$lookuptype);
        }//END FOR EACH
        return $data;

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//END RETRIEVESELECTED

  public function requestUnpaidAccounts($doc,$ccode,$searchparam){
        switch ($doc) {
            case 'KR':
                return $unpaidlist = $this->requestUnpaidKR($ccode);
                break;

            case 'KL':
                return $unpaidlist = $this->requestUnpaidKL($ccode,$searchparam);
            break;

            default:
                return $unpaidlist = $this->requestUnpaid($ccode,$searchparam);
                break;
        }//END SWITCH
  }//END UNPAID



    public function setKRref($params,$kr,$type){
        switch($type){
            case 'SETKR': //VARIABLES IS USED IS A LOOP
                foreach ($params as $key => $value) {
                    $qry = "update arledger set kr = ".$kr." where trno = '".$params[$key]['trno']."' and line = ".$params[$key]['line']."";
                    Yii::$app->sbccommon->execqry($qry);
                }//end for each

                return $updateddata = $this->retrieveKRreceivables($kr);
                //return array('issues'=>$params);
            break;

            case 'DELETEENTRY': //VARIABLES IS USED SINGULARLY
                $qry = "update arledger set kr = 0 where trno = '".$params['trno']."'";
                $status = Yii::$app->sbccommon->execqry($qry);
                return $status;
            break;
        }//end switch
    }//end setKRref

    public function searchGroup($controller,$access,$x) {
      $filter='';
      if($x!=''){
        $filter="where stockgrp_id like '%".$x."%' or stockgrp_code like '%".$x."%' or stockgrp_name like '%".$x."%'";
      }

      if($controller->module->id == 'changeitem' || $controller->module->id == 'stockcard' || $controller->module->id == 'manageitem' || $controller->module->id == 'posstockcard' || $controller->module->id == 'reportlist') {
        return "select 0 as groupid , '' as code , '' as stockgrp 
                UNION ALL 
                select stockgrp_id as groupid,stockgrp_code as code,stockgrp_name as stockgrp from stockgrp_masterfile ".$filter;
      } else {
        return "select '' as groupid 
                UNION ALL
                select distinct groupid from client order by groupid";
      }
    }//end fn

    public function searchUomprint($id,$access) {
      
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          if($id!=''){
            return "select '' as itemid,'' as uom
                  UNION ALL
                  select itemid as itemid,uom as uom from uom where itemid=".$id." order by itemid";
          }else{
            return "select '' as itemid,'' as uom";
          }
          
        }  
    }//end f
    
    //WTODO: [JLY][2019.08.17][KINGG CONCERNS][ADD GROUP FILTER END]
    public function searchBrand($controller,$access,$x) {
      $filter='';
      if($x!=''){
        $filter="where brandid like '%".$x."%' or brand_desc like '%".$x."%'";
      }
      if($controller->module->id == 'changeitem') {
        return "select '' as brandid,'' as brand
                UNION ALL
                select md5(brandid) as brandid,brand_desc as brand from frontend_ebrands order by brand asc";
      } else if($controller->module->id == 'manageitem'|| $controller->module->id == 'branch') {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          return "select 0 as brandid,'' as brand
                  UNION ALL
                  select brandid, brand_desc as brand from frontend_ebrands group by brand asc";
        }
      } else {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          return "select '' as brandid,'' as brand
                  UNION ALL
                  select md5(brandid) as brandid,brand_desc as brand from frontend_ebrands ".$filter." order by brand asc";
        }  
      }
    }//end fn

    public function searchSize($controller,$access,$x) {
      $filter='';
      if($x!=''){
        $filter="where sizeid like '%".$x."%'";
      }
      if($controller->module->id == 'changeitem') {
        return "select distinct sizeid from item order by sizeid asc";
      } else {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          return "select distinct sizeid from item ".$filter." order by sizeid asc";
        } 
      }
    }

    public function searchModel($controller,$access,$x) {
      $filter='';
      if($x!=''){
        $filter="where model_id like '%".$x."%' or model_name like '%".$x."%'";
      }
      
      if($controller->module->id == 'changeitem' || $controller->module->id == 'stockcard' || $controller->module->id == 'manageitem' || $controller->module->id == 'posstockcard') {
          return "select 0 as modelid , '' as model 
                  UNION ALL 
                  select model_id as modelid, model_name as model from model_masterfile ".$filter."  order by model asc";
      } else {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {
        } else {
          return "select '' as model UNION ALL select distinct model from item order by model asc";
        }//end if 2
      }
    }

    public function searchPart($controller,$access,$x) {
      $filter='';
      if($x!=''){
        $filter="where part_id like '%".$x."%' or part_name like '%".$x."%'";
      }//end if


      if($controller->module->id == 'changeitem' || $controller->module->id == 'stockcard' || $controller->module->id == 'posstockcard' || $controller->module->id == 'reportlist') {
          return "select part_id as partid, part_name as part from part_masterfile ".$filter." order by part_name";
      } else {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

        } else {
          return "select distinct part from item ".$filter." order by part asc";
        }
      }
    }

    public function retrieveChangeitemdata($txt) {
      if($txt == '') {
        return "select itemid,barcode,itemname,ifnull(gg.stockgrp_name,'') as groupid,ifnull(pp.part_name,'') as part,
                ifnull(mm.model_name,'') as model,
                brand,sizeid,uom,minimum,maximum,amt,
                item.groupid as grpid,item.model as modelid,item.part as partid,
                '' as search from item
                left join model_masterfile as mm on mm.model_id = item.model
                left join part_masterfile as pp on pp.part_id = item.part
                left join stockgrp_masterfile as gg on gg.stockgrp_id = item.groupid
                order by barcode limit 50";
      } else {
        $qry = "select itemid,barcode,itemname,ifnull(gg.stockgrp_name,'') as groupid,ifnull(pp.part_name,'') as part,ifnull(mm.model_name,'') as model,
                brand,sizeid,uom,minimum,maximum,amt,
                item.groupid as grpid,item.model as modelid,item.part as partid,
                '' as search from item
                left join model_masterfile as mm on mm.model_id = item.model
                left join part_masterfile as pp on pp.part_id = item.part
                left join stockgrp_masterfile as gg on gg.stockgrp_id = item.groupid";

         $keyword = explode(",", $txt);
         $criteria="";

          /*foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive <> 1 and (item.itemname like '%".$key."%' or item.barcode like '%".$key."%'
                                or item.uom like '%".$key."%' 
                                or brand like '%".$key."%' 
                                or gg.stockgrp_name like '%".$key."%' 
                                or mm.model_name like '%".$key."%' 
                                or pp.part_name like '%".$key."%' 
                                or item.sizeid like '%".$key."%') ";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and (item.itemname like '%".$key."%' or item.barcode like '%".$key."%'
                              or item.uom like '%".$key."%' 
                              or brand like '%".$key."%' 
                              or gg.stockgrp_name like '%".$key."%' 
                              or mm.model_name like '%".$key."%' 
                              or pp.part_name like '%".$key."%' 
                              or item.sizeid like '%".$key."%') ";
              }
          } //foreach*/

           foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      mm.model_name LIKE '%" . $key. "%' or
                                      pp.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      gg.stockgrp_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      mm.model_name LIKE '%" . $key. "%' or
                                      pp.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      gg.stockgrp_name LIKE '%" . $key. "%' or    
                                      item.body LIKE '%" . $key. "%' or                                
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          } //end for each

          return $qry.$criteria. "order by item.barcode limit 50";

      }
    }//end if
    

    public function retrieveKRreceivables($kr){
      if($kr == '' || $kr == 0) {
        $kr = "1 <> 1";
      } else {
        $kr = "ledger.kr = ".$kr;
      }
      $qry = "select ctbl.client,ledger.docno as ref,ledger.trno,
        ledger.trno as line,ledger.acnoid,coa.acno,coa.acnoname,cntnum.center,ledger.clientid,
          round(ledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db , round(ledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,left(ledger.dateid,10) as dateid,
          ifnull(head.ourref,'') as yourref ,head.rem from arledger as ledger
          left join coa on coa.acnoid = ledger.acnoid
          left join glhead as head on head.trno = ledger.trno
          left join gldetail as detail on detail.trno = ledger.trno and detail.line = ledger.line
          left join cntnum on cntnum.trno = head.trno
          left join client as ctbl on ctbl.clientid = ledger.clientid
          where $kr order by dateid";
      return $qry;
    }//end retrieve KR


    private function retrieveUnpaidData($ccode,$trno,$line,$type = ''){
        if($type == '' || $type == 'single'){
          $filter = " ctbl.client='".$ccode."' ";
        }else{
          $filter = " ctbl.grpcode='".$ccode."' ";
        }//end if
        
        $qry = "select ctbl.client,left(apledger.dateid,10) as postdate,coa.acno,coa.acnoname,
        round(apledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(apledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
        ifnull(gldetail.rem,'') as rem,ifnull(apledger.docno,'') as ref, apledger.line as linex , 
        apledger.trno as refx,apledger.bal from (apledger
        left join coa on coa.acnoid=apledger.acnoid)
        left join glhead on glhead.trno = apledger.trno
        left join gldetail on gldetail.trno=apledger.trno and gldetail.line=apledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = apledger.clientid
        where ".$filter." and apledger.trno = ".$trno." and apledger.line = ".$line." and apledger.bal<>0
        UNION ALL
        select ctbl.client,left(arledger.dateid,10) as postdate,coa.acno,coa.acnoname,
        round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
        ifnull(gldetail.rem,'') as rem,ifnull(arledger.docno,'') as ref,
        arledger.line as linex , arledger.trno as refx,arledger.bal
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ".$filter." and arledger.trno = ".$trno." 
        and arledger.line = ".$line." and arledger.bal<>0 order by postdate";

        return $data = Yii::$app->sbccommon->opentable($qry);
    }//end



  private function requestUnpaid($ccode,$searchparam){
    // or glstock.ref like '%".$searchparam."%'
    if(!empty($searchparam)){
      $query = "select apledger.docno,0 as order1,apledger.trno,apledger.line,apledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        apledger.clientid,round(apledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(apledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(apledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').")as bal ,left(apledger.dateid,10) as dateid,
        abs(apledger.fdb-apledger.fcr) as fdb,ifnull(glhead.yourref,'') as yourref,gldetail.rem as rem,glhead.rem as hrem from (apledger
        left join coa on coa.acnoid=apledger.acnoid)
        left join glhead on glhead.trno = apledger.trno
        left join gldetail on gldetail.trno=apledger.trno and gldetail.line=apledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = apledger.clientid
        where ctbl.client='".$ccode."' and apledger.bal<>0 and (apledger.docno like '%".$searchparam."%' or glhead.yourref like '%".$searchparam."%')
        union all
        select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal ,left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ctbl.client='".$ccode."' and arledger.bal<>0 and (arledger.docno like '%".$searchparam."%' or glhead.yourref like '%".$searchparam."%') order by dateid";
    }else{
      $query = "select apledger.docno,0 as order1,apledger.trno,apledger.line,apledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        apledger.clientid,round(apledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(apledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(apledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal ,left(apledger.dateid,10) as dateid,
        abs(apledger.fdb-apledger.fcr) as fdb,ifnull(glhead.yourref,'') as yourref,gldetail.rem as rem,glhead.rem as hrem from (apledger
        left join coa on coa.acnoid=apledger.acnoid)
        left join glhead on glhead.trno = apledger.trno
        left join gldetail on gldetail.trno=apledger.trno and gldetail.line=apledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = apledger.clientid
        where ctbl.client='".$ccode."' and apledger.bal<>0
        union all
        select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") ,left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ctbl.client='".$ccode."' and arledger.bal<>0 order by dateid";
    }


    return $data = Yii::$app->sbccommon->opentable($query);
  }//END GJ UNPAID

  private function requestUnpaidKL($ccode,$searchparam){
    if(!empty($searchparam)){
      $query = "select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, 
        round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ctbl.client='".$ccode."' and arledger.bal<>0 
        and arledger.trno not in (select trno from kldetail)
        and (arledger.docno like '%".$searchparam."%' or glhead.yourref like '%".$searchparam."%') order by dateid";
    }else{
      $query = "select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, 
        round(arledger.bal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as bal,
        left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ctbl.client='".$ccode."' and arledger.bal<>0 
        and arledger.trno not in (select trno from kldetail) order by dateid";
    }

    return $data = Yii::$app->sbccommon->opentable($query);
  }//END GJ UNPAID

    private function requestUnpaidKR($ccode){
        $query = "select arledger.docno,0 as order1,arledger.trno,arledger.line,arledger.acnoid,coa.acno,coa.acnoname,cntnum.center,
        arledger.clientid,round(arledger.db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,round(arledger.cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr, arledger.bal ,left(arledger.dateid,10) as dateid,
        0 as fdb,ifnull(glhead.ourref,'') as yourref,gldetail.rem,glhead.rem as hrem
        from (arledger
        left join coa on coa.acnoid=arledger.acnoid)
        left join glhead on glhead.trno = arledger.trno
        left join gldetail on gldetail.trno=arledger.trno and gldetail.line=arledger.line
        left join cntnum on cntnum.trno = glhead.trno
        left join client as ctbl on ctbl.clientid = arledger.clientid
        where ctbl.client='".$ccode."' and arledger.bal<>0 and arledger.kr = 0 order by dateid";
        return $data = Yii::$app->sbccommon->opentable($query);
    }//END GJ UNPAID



    public function requestloadchecks($doc,$ccode){
         return $checklist = $this->requestChecks($ccode);
    } //end checks

    public function retrieveSelectedChecks($ccode,$params){
        foreach ($params as $key => $value) {
            $data[$key] = $this->retrieveCheckdata($ccode,$params[$key]['trno'],$params[$key]['line']);
        }//END FOR EACH
         return $data;
    }//END RETRIEVESELECTED

    private function retrieveCheckdata($ccode,$trno,$line){
      if($ccode == ''){
          $qry = "select crledger.docno as ref, crledger.trno as refx, crledger.line as linex, crledger.checkno,left(crledger.checkdate,10) as postdate,
          crledger.db as cr, crledger.cr as db,coa.acno, coa.acnoname, client.client, client.clientname
          from crledger left join coa on coa.acnoid=crledger.acnoid left join client on client.clientid=crledger.clientid
          left join cntnum on cntnum.trno=crledger.trno
          where depodate is null and crledger.trno = ".$trno." and crledger.line = ".$line."
          union all
          select caledger.docno as ref, caledger.trno as refx, caledger.line as linex, concat('CASH' , checkno) as checkno,left(caledger.dateid,10) as postdate,
          caledger.db, caledger.cr, coa.acno, coa.acnoname, client.client, client.clientname
          from caledger left join coa on coa.acnoid=caledger.acnoid left join client on client.clientid=caledger.clientid
          left join cntnum on cntnum.trno=caledger.trno
          where depodate is null and caledger.trno = ".$trno." and caledger.line = ".$line."";
      }else{
        $qry = "select crledger.docno as ref,crledger.trno as refx,crledger.line as linex,crledger.checkno,left(crledger.checkdate,10) as postdate,
                crledger.db as cr,crledger.cr as db,coa.acno,coa.acnoname,client.client,client.clientname from ((crledger
                left join coa on coa.acnoid=crledger.acnoid)
                left join client on client.clientid=crledger.clientid)
                left join cntnum on cntnum.trno=crledger.trno
                where depodate is null and not cntnum.postdate is null
                and  crledger.trno='".$trno."' and crledger.line ='".$line."'
                union all
                select caledger.docno as ref,caledger.trno as refx,caledger.line as linex,case caledger.checkno when '' then
                (case gldetail.checkno when '' then 'cash' else gldetail.checkno end)
                else caledger.checkno end as checkno,left(caledger.dateid,10) as postdate,
                caledger.db,caledger.cr,coa.acno,coa.acnoname,client.client,client.clientname from ((caledger
                left join coa on coa.acnoid=caledger.acnoid)
                left join client on client.clientid=caledger.clientid)
                left join gldetail on gldetail.trno = caledger.trno and gldetail.line = caledger.line
                left join cntnum on cntnum.trno=caledger.trno where depodate is null and not cntnum.postdate is null
                and  caledger.trno='".$trno."' and caledger.line ='".$line."'";
      }//end if
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    private function requestChecks($ccode){
      if($ccode == ""){ //FOR DS
        $query = "select * from (select crledger.docno, crledger.trno, crledger.line, crledger.checkno,left(crledger.checkdate,10) as checkdate,
        crledger.db, crledger.cr,coa.acno, coa.acnoname, client.client, client.clientname
        from crledger left join coa on coa.acnoid=crledger.acnoid left join client on client.clientid=crledger.clientid
        left join cntnum on cntnum.trno=crledger.trno
        where depodate is null
        union all
        select caledger.docno, caledger.trno, caledger.line, concat('CASH' , checkno) as checkno, left(caledger.dateid,10) as checkdate,
        caledger.db, caledger.cr, coa.acno, coa.acnoname, client.client, client.clientname
        from caledger left join coa on coa.acnoid=caledger.acnoid left join client on client.clientid=caledger.clientid
        left join cntnum on cntnum.trno=caledger.trno
        where depodate is null";
      }else{ // FOR OTHER TRANS
        $query = "select * from (
                  select crledger.docno,crledger.trno,crledger.line,crledger.checkno,left(crledger.checkdate,10) as checkdate,
                  crledger.db,crledger.cr,coa.acno,coa.acnoname,client.client,client.clientname from
                  ((crledger
                  left join coa on coa.acnoid=crledger.acnoid)
                  left join client on client.clientid=crledger.clientid)
                  left join cntnum on cntnum.trno=crledger.trno
                  where depodate is null and not cntnum.postdate is null";

        if(!empty($ccode)){
          $query = $query." and client.client = '".$ccode."' " ;
        }//end if empty

        $query = $query."union all
        select caledger.docno,caledger.trno,caledger.line,case caledger.checkno when '' then
        (case gldetail.checkno when '' then 'cash' else gldetail.checkno end)
        else caledger.checkno end as checkno,left(caledger.dateid,10) as checkdate,
         caledger.db,caledger.cr,coa.acno,coa.acnoname,client.client,client.clientname from
        ((caledger
        left join coa on coa.acnoid=caledger.acnoid)
        left join client on client.clientid=caledger.clientid)
        left join gldetail on gldetail.trno = caledger.trno and gldetail.line = caledger.line
        left join cntnum on cntnum.trno=caledger.trno where depodate is null and not cntnum.postdate is null ";

        if(!empty($ccode)){
          $query = $query."  and client.client = '".$ccode."'";
        }//end if emppty cc$code

      }//end if emppty cc$code for DS  
      // return $data = Yii::$app->sbccommon->opentable($query);
      $query .= ") as tbl order by checkdate";

      return $query;
    }//end request gj checks
//########################################################## GJ UPDATE JAOSKI

  
#################################### UPDATES FOR COA ############################################################
  public function getAccountGrandparents(){
    $query = "select acnoid,acno,acnoname,alias,parent,cat,detail from coa where levelid = 1 order by acnoid";
    return $data = Yii::$app->sbccommon->opentable($query);
  }//END GET GRANDPARENTS

  public function getAccountChildren($acno){
    $query = "select acnoid,acno,acnoname,alias,parent,cat,detail from coa where parent = '\\".$acno."' order by acnoid";
    return $data = Yii::$app->sbccommon->opentable($query);
  }//END GET CHILDREN

  public function getAccountAttributes($acnoid){
    $query = "select head.acnoid,head.acno,head.acnoname,head.alias,head.cat,head.parent,head.detail,
        ifnull(parentx.acnoname,'') as pname from coa as head
        left join coa as parentx on parentx.acno = head.parent where head.acnoid=".$acnoid."";
    $data = Yii::$app->sbccommon->opentable($query);
    if(!empty($data)){
      if($this->checkContraTransaction($data[0]['acno'])){
        $data[0]['hastrans'] = 0;
      }else{
        $data[0]['hastrans'] = 1;
      }//end if
    }//end if
    return $data[0];
  }//END GET ACCOUNT ATTRIBUTES

  public function automateNextAcno($acno,$type){
    if($type == "PARENT"){
      $query = "select acno,acnoname,acnoid,cat,levelid,parent as pcode from coa where levelid=1 order by acnoid desc limit 1";
      $data = Yii::$app->sbccommon->opentable($query);    
      $cat = "";
      $pname = "";

      if(empty($data)){
        $pcode = '\\';
        $newacno = 1;
        $levelid = 1;
      }else{
        $pcode = $data[0]['pcode'];
        $newacno = $data[0]['acno'];
        $newacno = str_replace('\\','', $newacno);
        $newacno += 1;
        $levelid = $data[0]['levelid'];
      }//end if data

    }else{
      $query = "select head.acno,head.cat,parentinfo.acnoname as pname,head.parent as pcode,head.levelid from coa as head
          left join coa as parentinfo on parentinfo.acno = head.parent
          where head.parent = '\\".$acno."' order by head.acnoid desc limit 1";
      $data = Yii::$app->sbccommon->opentable($query);    
      if($data == null){
        $query = "select acno,acnoname,acnoid,cat,levelid from coa where acno = '\\".$acno."'";
        $data = Yii::$app->sbccommon->opentable($query);
        $cat = $data[0]['cat'];
        $pname = $data[0]['acnoname'];
        $pcode = $data[0]['acno'];
        $newacno = $acno . "01";
        $levelid = $data[0]['levelid'] +1;
        $newacno = str_replace('\\','', $newacno);
      }else{
        $cat = $data[0]['cat'];
        $pname = $data[0]['pname'];
        $pcode = $data[0]['pcode'];
        $newacno = $data[0]['acno'];
        $newacno = str_replace('\\','', $newacno);
        $newacno += 1;
        $levelid = $data[0]['levelid'];
      }//END IF
    }//end if type
    return array('newacno'=>"\\".$newacno,'cat'=>$cat,'parentcode'=>$pcode,'parentname'=>$pname,'levelid'=>$levelid);
  }//END AUTOMATE NEXT ACNO

  public function modifyChartofAccount($params){
    $refreshacnoid = null;
    $refreshacno = null;
    $err_msg = "";
    $msg="";

        if($params['acnoid'] != ""){
          $qry = "update coa set alias = '".$params['alias']."', acnoname = '".$params['acnoname']."' where acnoid = '".$params['acnoid']."'";
          $status = Yii::$app->sbccommon->execqry($qry);
          
          if($status){
              $getparent = "select parent.acno,parent.acnoid from coa
                          left join coa as parent on parent.acno = coa.parent
                          where coa.acno = '\\".$params['parent']."'";
              
              $parentdata = Yii::$app->sbccommon->opentable($getparent); //GETS PARENT DATA THAT NEEDS TO BE REFRESHED
              $refreshacnoid = $parentdata[0]['acnoid'];
              $refreshacno = $parentdata[0]['acno'];
              $err_msg = "";
              $msg="Account updated successfully!";
          }else{
              $err_msg = "Error updating account.";
              $msg="";
          }//end if
          
        }else{
            $duplicatequery = "select count(acno) as duplicates from coa where acno = '\\".$params['acno']."'";
            $data = Yii::$app->sbccommon->opentable($duplicatequery);
            $duplicates = $data[0]['duplicates'];
            if($duplicates == 1){
                $err_msg = "Account Number, ".$params['acno']. " is already in use kindly choose another..";
            }else{
                if($params['savingtype'] =="PARENT"){
                    $query1 = "insert into coa (levelid,acno,acnoname,alias,bal,seq,sdb,scr,parent,cat,isaccal,isexpanded,type,
                            detail,mark,avail,logid,hd,viewid,comm,groupid,icon,isforeign,parentid)
                            values (".$params['levelid'].",'\\".$params['acno']."','".$params['acnoname']."',
                            '".$params['alias']."',0,0,0,0,'\\".$params['parent']."','".$params['type']."',
                            0,0,'',1,'',0,'','',0,0,'','',0,0)";
                    $status1 = Yii::$app->sbccommon->execqry($query1);
                    $msg="Sucessfully saved Parent contra.";
                }else{
                    $checkquery = "select distinct coa.acno from gldetail
                                   left join coa on coa.acnoid=gldetail.acnoid
                                   left join hgldetail on hgldetail.acnoid=coa.acnoid
                                   left join ladetail on ladetail.acno=coa.acno
                                   left join lbdetail on lbdetail.acno=coa.acno
                                   left join lcdetail on lcdetail.acno=coa.acno
                                   where coa.acno='".$params['parent']."'";
                    $parentready = Yii::$app->sbccommon->execqry($checkquery);
                        if($parentready){
                                    //FOR INSERTING NEW ACCOUNT
                                    $query1 = "insert into coa (levelid,acno,acnoname,alias,bal,seq,sdb,scr,parent,cat,isaccal,isexpanded,type,
                                        detail,mark,avail,logid,hd,viewid,comm,groupid,icon,isforeign,parentid)
                                        values (".$params['levelid'].",'\\".$params['acno']."','".$params['acnoname']."',
                                        '".$params['alias']."',0,0,0,0,'\\".$params['parent']."','".$params['type']."',
                                        0,0,'',1,'',0,'','',0,0,'','',0,0)";
                                    $status1 = Yii::$app->sbccommon->execqry($query1);
                                    $query2 = "update coa set detail=0 where acno='\\".$params['parent']."'";
                                    $status2 = Yii::$app->sbccommon->execqry($query2);
                                    if($status1 == 1 && $status2 == 1){
                                        $getparent = "select parent.acno,parent.acnoid from coa
                                                    left join coa as parent on parent.acno = coa.parent
                                                    where coa.acno = '\\".$params['parent']."'";
                                        
                                        
                                        $parentdata = Yii::$app->sbccommon->opentable($getparent); //GETS PARENT DATA THAT NEEDS TO BE REFRESHED
                                        $refreshacnoid = $parentdata[0]['acnoid'];
                                        $refreshacno = $parentdata[0]['acno'];
                                        $msg="Sucessfully saved contra.";
                                    }else{
                                        $err_msg = "ERROR => INSERTING CONTRA(" .$status1 .")  -  UPDATING PARENT(". $status2.")"; //throws error
                                    }//END
                        }else{
                            $err_msg = "CANT BE A PARENT, IM VERY SORRY" . $parentready;
                        }//END IF PARENT READY
                }//end if saving type
            }//END DUPLICATION FILTER
        }//end if acnoid != ""
      return array('refreshthis'=>$refreshacnoid,'error_msg'=>$err_msg,'refreshacno'=>$refreshacno,'msg'=>$msg);
  }//END MODIFY CHART OF ACCOUNT

  public function checkContraTransaction($acno){
    $query = 'select ladetail.acno from ladetail where ladetail.acno = "\\'.$acno.'" group by acno
        UNION ALL
        select coa.acno from gldetail left join coa on coa.acnoid = gldetail.acnoid 
        where coa.acno = "\\'.$acno.'" group by coa.acno';
    $data = Yii::$app->sbccommon->opentable($query);
    if(empty($data)){
      return true;  
    }else{
      return false;
    }//END IF
  }//END check contra transaction

  public function contrahasChildren($acno){
    $haschild = $this->getAccountChildren($acno);
    if(empty($haschild)){
      return false;
    }else{
      return true;
    }//END IF
  }//END ACCOUNT

  public function deleteContra($params){
  $refreshacnoid = null;
  $refreshacno = null;
    if($this->checkContraTransaction($params['acno'])){
      $data = $this->getAccountAttributes($params['acnoid']);
      //if($data['detail'] ==){//CHECKS IF CONTRA IS A PARENT
        if(!$this->contrahasChildren($params['acno'])){ //IF PARENT DOES NOT HAVE CHILDREN
          $query = "delete from coa where acnoid = ".$params['acnoid']."";
          $status = Yii::$app->sbccommon->execqry($query);
          if($status){
            if(!$this->contrahasChildren($params['parent'])){
              $updateqry = "update coa set detail = 1 where acno = '\\".$params['parent']."'";
              $statusupdate = Yii::$app->sbccommon->execqry($updateqry);
            }//end if contra has children
            $getparent = "select parent.acno,parent.acnoid from coa
                  left join coa as parent on parent.acno = coa.parent
                  where coa.acno = '\\".$params['parent']."'";
            $parentdata = Yii::$app->sbccommon->opentable($getparent); //GETS PARENT DATA THAT NEEDS TO BE REFRESHED
            if(!empty($parentdata)){
            $refreshacnoid = $parentdata[0]['acnoid'];
            $refreshacno = $parentdata[0]['acno'];
            }
            return array('msg'=>'Contra '.$params['acnoname'].' successfully removed.','error'=> 0,
                  'refreshacnoid'=>$refreshacnoid,'refreshacno'=>$refreshacno);
          }else{
            return array('msg'=>'Removing failed, Database Error.','error'=> 1,
              'refreshacnoid'=>'','refreshacno'=>'');
          }//END IF ERROR DATABASE
        }else{
          return array('msg'=>'Cannot delete a parent account with child accounts. Please Try again.','error'=> 1,
            'refreshacnoid'=>'','refreshacno'=>''); 
        }//END IF PARENT CHECKING HAS CHILDREN
      //}//END DETAIL ==
    }else{
      return array('msg'=>'Cannot delete Contra Account, Already been used.','error'=> 1,
            'refreshacnoid'=>'','refreshacno'=>'');
    }//END IF
  }//end delete contra


#################################### UPDATES FOR COA ############################################################

  public function getClientOrder($whcode,$doc,$clientcode,$type,$searchparam){
    switch ($doc) {
            case 'PO':
                switch ($type) {
                    case 'summary':
                        if(!empty($searchparam)){
                          $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
                          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
                          head.yourref
                          from hprhead as head
                          right join hprstock as stock on stock.trno = head.trno 
                          left join transnum on transnum.trno = head.trno
                          where stock.qty>stock.qa and head.docno like '%".$searchparam."%' 
                          and stock.void <> 1 
                          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                          group by stock.trno,head.docno,head.dateid";
                        }else{
                          $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
                          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
                          head.yourref from hprhead as head
                          right join hprstock as stock on stock.trno = head.trno 
                          left join transnum on transnum .trno = head.trno
                          where stock.qty>stock.qa 
                          and stock.void <> 1 
                          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                          group by stock.trno,head.docno,head.dateid";
                        }//searchparams
                        break;

                    case 'detail':
                      if(!empty($searchparam)){
                        $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
                        round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                        round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
                        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        stock.disc,
                        round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
                        round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
                        round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
                        stock.loc,head.yourref from hprhead as head
                        right join hprstock as stock on stock.trno = head.trno 
                        left join item on item.barcode=stock.barcode 
                        left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                        left join transnum on transnum .trno = head.trno 
                        where stock.qty>stock.qa and head.docno like '%".$searchparam."%'
                        and stock.void <> 1 
                        and transnum.center = '".Yii::$app->session['loggeduser']['center']."'";
                        
                      }else{
                        $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
                        round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                        round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
                        round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,
                        stock.disc,
                        round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
                        round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
                        round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                        round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
                        stock.loc,head.yourref from hprhead as head
                        right join hprstock as stock on stock.trno = head.trno 
                        left join item on item.barcode=stock.barcode 
                        left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
                        left join transnum on transnum .trno = head.trno
                        where stock.qty>stock.qa and stock.void <> 1 
                        and transnum.center = '".Yii::$app->session['loggeduser']['center']."'";
                      }//searchparams
                        break;
                }//END CASE
            break;      

      case 'RR':
        switch ($type) {
          case 'summary':
            if(!empty($searchparam)){
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from hpohead as head
              right join hpostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and stock.qty>stock.qa and head.docno like '%".$searchparam."%' 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1
              group by stock.trno,head.docno,head.dateid";
            }else{
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from hpohead as head
              right join hpostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and  stock.qty>stock.qa 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1
              group by stock.trno,head.docno,head.dateid";
            }//searchparams
            break;

          case 'detail':
            if(!empty($searchparam)){
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
              round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
              round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,stock.disc,
              round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from hpohead as head
              right join hpostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum .trno = head.trno
              where head.client = '".$clientcode."' 
              and stock.qty>stock.qa and head.docno like '%".$searchparam."%'
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1";
            }else{
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
              round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
              round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,stock.disc,
              round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from hpohead as head
              right join hpostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum .trno = head.trno
              where head.client = '".$clientcode."' and stock.qty>stock.qa
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1";
            }//searchparams
            break;
        }//END CASE

        break;      
      case 'SJ': case 'SJ2':
        switch ($type) {
          case 'summary':
            if(!empty($searchparam)){
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' 
              and stock.iss>stock.qa and head.docno like '%".$searchparam."%' 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1
              or 
              head.client = '".$clientcode."' 
              and stock.iss>stock.qa
              and head.yourref like '%".$searchparam."%' 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1
              group by stock.trno,head.docno,head.dateid";
            }else{
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1
              and stock.iss>stock.qa group by stock.trno,head.docno,head.dateid";
            }//searchparams
            break;
          case 'detail':
            if(!empty($searchparam)){
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and stock.iss >stock.qa 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and head.docno like '%".$searchparam."%'
              and stock.void <> 1
              or 
              head.client = '".$clientcode."' and stock.iss >stock.qa 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and head.yourref like '%".$searchparam."%' 
              and stock.void <> 1";
            }else{
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and stock.iss >stock.qa
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.void <> 1";
            }//searchparams
            break;
        }//END CASE       
        break;

        // SALON MODIFICATION
        case 'TS':
        switch ($type) {
          case 'summary':
            if(!empty($searchparam)){
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from htrhead as head
              right join htrstock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and head.wh = '".$whcode."' and stock.qty>stock.qa and head.docno like '%".$searchparam."%' 
              and stock.void <> 1
              group by stock.trno,head.docno,head.dateid";
            }else{
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from htrhead as head
              right join htrstock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and head.wh = '".$whcode."' and  stock.qty>stock.qa 
              and stock.void <> 1
              group by stock.trno,head.docno,head.dateid";
            }//searchparams
            
            break;

          case 'detail':
            if(!empty($searchparam)){
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
              round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
              round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,stock.disc,
              round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from htrhead as head
              right join htrstock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum .trno = head.trno
              where head.client = '".$clientcode."' and head.wh = '".$whcode."' 
              and stock.qty>stock.qa and head.docno like '%".$searchparam."%'
              and stock.void <> 1";
            }else{
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
              round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
              round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,stock.disc,
              round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from htrhead as head
              right join htrstock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum .trno = head.trno
              where head.client = '".$clientcode."' and head.wh = '".$whcode."' and stock.qty>stock.qa
              and stock.void <> 1";
            }//searchparams
            break;
        }//END CASE
        break;  
        // END SALON


      case 'customer':
        switch ($type) {
          case 'summary':
            if(!empty($searchparam)){
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from sohead as head
              right join sostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' 
              and stock.iss>stock.qa and head.docno like '%".$searchparam."%' 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              group by stock.trno,head.docno,head.dateid
              union all
              select stock.trno,head.docno,head.dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref
              from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' 
              and stock.iss>stock.qa and head.docno like '%".$searchparam."%'
              and stock.void <> 1 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              group by stock.trno,head.docno,head.dateid";
            }else{
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref from sohead as head
              right join sostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.iss>stock.qa group by stock.trno,head.docno,head.dateid
              union all
              select stock.trno,head.docno,head.dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' 
              and stock.void <> 1 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              and stock.iss>stock.qa group by stock.trno,head.docno,head.dateid";
            }//searchparams
            break;

          case 'detail':
            if(!empty($searchparam)){
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,
              head.yourref
              from sohead as head
              right join sostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and stock.iss >stock.qa and head.docno like '%".$searchparam."%'
              and stock.void <> 1 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              UNION ALL
              select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and stock.iss >stock.qa and head.docno like '%".$searchparam."%'
              and stock.void <> 1 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'";
            }else{
              $query = "
              select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from sohead as head
              right join sostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and stock.iss >stock.qa
              and stock.void <> 1 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              UNION ALL
              select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref
              from hsohead as head
              right join hsostock as stock on stock.trno = head.trno 
              left join item on item.barcode=stock.barcode 
              left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
              left join transnum on transnum.trno = head.trno
              where head.client = '".$clientcode."' and stock.iss >stock.qa
              and stock.void <> 1 
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'";
            }//searchparams
            break;
        }//END CASE       
        break;

      case 'DM':
        switch ($type) {
          case 'summary':
            if(!empty($searchparam)){
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref from glhead as head
              right join glstock as stock on stock.trno = head.trno 
              left join client on client.clientid=head.clientid  
              left join cntnum on cntnum.trno = head.trno
              where head.doc='RR' and client.client = '".$clientcode."' and 
              stock.qty>stock.qa and head.docno like '%".$searchparam."%' 
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
              group by stock.trno,head.docno,head.dateid";
            }else{
              $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
              round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
              head.yourref from glhead as head
              right join glstock as stock on stock.trno = head.trno 
              left join client on client.clientid=head.clientid  
              left join cntnum on cntnum.trno = head.trno
              where head.doc='RR' and client.client = '".$clientcode."' 
              and stock.qty>stock.qa 
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
              group by stock.trno,head.docno,head.dateid";
            }//searchparams
            break;
          case 'detail':
            if(!empty($searchparam)){
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,wh.client as wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
              stock.loc,head.yourref from glhead as head
              right join glstock as stock on stock.trno = head.trno 
              left join item on item.itemid=stock.itemid 
              left join client on client.clientid=head.clientid 
              left join client as wh on wh.clientid=stock.whid 
              left join uom on uom.itemid=stock.itemid and uom.uom=stock.uom 
              left join cntnum on cntnum.trno = head.trno
              where head.doc='RR' and client.client = '".$clientcode."' and stock.qty>stock.qa 
              and head.docno like '%".$searchparam."%'
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'";
            }else{
              $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
              round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
              round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
              round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as isamt,stock.disc,
              round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
              round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,wh.client as wh,
              round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
              round((stock.qty-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
              stock.loc,head.yourref from glhead as head
              right join glstock as stock on stock.trno = head.trno 
              left join item on item.itemid=stock.itemid 
              left join client on client.clientid=head.clientid 
              left join client as wh on wh.clientid=stock.whid 
              left join uom on uom.itemid=stock.itemid and uom.uom=stock.uom 
              left join cntnum on cntnum.trno = head.trno
              where head.doc='RR' and client.client = '".$clientcode."' and stock.qty>stock.qa
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'";
            }//searchparams
            break;
        }//END CASE       
        break;

      case 'CM':
        switch ($type) {
          case 'summary':
            if(!empty($searchparam)){
                $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
                round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
                head.yourref
                from glhead as head
                right join glstock as stock on stock.trno = head.trno 
                left join client on client.clientid=head.clientid  
                left join cntnum on cntnum.trno = head.trno
                where head.doc='SJ' 
                and client.client = '".$clientcode."' and stock.iss>stock.qa 
                and head.docno like '%".$searchparam."%' 
                and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                group by stock.trno,head.docno,head.dateid";
              }else{
                $query = "select stock.trno,head.docno,left(head.dateid,10) as dateid,
                round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
                head.yourref
                from glhead as head
                right join glstock as stock on stock.trno = head.trno 
                left join cntnum on cntnum.trno = head.trno
                left join client on client.clientid=head.clientid  where head.doc='SJ' 
                and client.client = '".$clientcode."' and stock.iss>stock.qa 
                and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                group by stock.trno,head.docno,head.dateid";
              }//searchparams
            break;
          case 'detail':
              if(!empty($searchparam)){
                $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
                round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
                round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,stock.disc,
                round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
                stock.ext,wh.client as wh,
                round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
                stock.loc,head.yourref from glhead as head
                right join glstock as stock on stock.trno = head.trno 
                left join cntnum on cntnum.trno = head.trno
                left join client on client.clientid=head.clientid left join client as wh on wh.clientid=stock.whid 
                left join item on item.itemid=stock.itemid 
                left join uom on uom.itemid=stock.itemid and uom.uom=stock.uom where head.doc='SJ' 
                and client.client = '".$clientcode."' and stock.iss>stock.qa and head.docno like '%".$searchparam."%'
                and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'";
              }else{
                $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
                round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
                round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('unitprice').") as rrcost,stock.disc,
                round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
                stock.ext,wh.client as wh,
                round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
                round((stock.iss-stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
                stock.loc,head.yourref from glhead as head
                right join glstock as stock on stock.trno = head.trno 
                left join cntnum on cntnum.trno = head.trno
                left join client on client.clientid=head.clientid left join client as wh on wh.clientid=stock.whid 
                left join item on item.itemid=stock.itemid 
                left join uom on uom.itemid=stock.itemid and uom.uom=stock.uom where head.doc='SJ' 
                and client.client = '".$clientcode."' and stock.iss>stock.qa
                and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'";
              }//searchparams
            break;
        }//END CASE       
        break;
        

    }//switch ($doc) {
    return $data = Yii::$app->sbccommon->opentable($query);
  }//END GETCLIENTPO

 

 public function retrieveOrderdatasummary($doc,$params) {
    $stock = new Postock;
    $doc2 = '';
    
    switch($doc) {
      case 'SO':
        $doc2 = 'QA';
      break;
      case 'RR':
        $doc2 = 'PO';
      break;
      case 'SJ': case 'SJ2':
        $doc2 = 'SO';
      break;
      case 'DM':
        $doc2 = 'RR';
      break;
      case 'CM':
        $doc2 = 'SJ';
      break;
      case 'PO':
        $doc2 = 'PR';
      break;
      case 'TS':
        $doc2 = 'TR';
      break;
      case 'MX':
        $doc2 = 'PR';
      break;
    }//end switch
    
    foreach ($params as $key => $value) {
      $return = $stock->getsummarystock($doc2,$value['value']);
      $liner = 1;
      foreach ($return as $itmindex => $itmdata) {
        switch (Yii::$app->systemsettings->companyConfig()) {
        case 'UNIVERSE':
          if($doc == "SJ" || $doc == "TS" || $doc == "MX" || $doc == "MI"){
            $tempdata = $stock->getdetailstock($doc2,$itmdata['trno'],$itmdata['line']);
                  foreach ($tempdata as $key => $value) {
                    $params['q'] = $value['itemid'];
                    $params['wh'] = $value['whcode'];
                    $invdata = Yii::$app->backend->getAvailableInventory($params);
                    
                    if(!empty($invdata)){
                      for ($i = 0; $i < count($invdata) ; $i++) { 
                        if(floatval($invdata[$i]['bal']) >= floatval($value['iss'])){
                          $tempdata3 = [];
                          foreach ($value as $keyx => $valuex) {
                            if($keyx == 'expiry' || $keyx == 'loc' || $keyx == 'ext'){
                              switch ($keyx) {
                                case 'ext': case 'isamt': case 'amt':
                                  $computeddata = Yii::$app->backend->computestock_Internal($value['isamt'],$value['disc'],$value['isqty'],$value['uomfactor'],$doc);
                                  $tempdata2['ext'] = $computeddata['ext'];
                                  $tempdata2['amt'] = $computeddata['amt'];
                                break;

                                case 'expiry': case 'loc':
                                  $tempdata2[$keyx] = $invdata[$i][$keyx];
                                break;
                              }//end switch
                            }else{
                              $tempdata2[$keyx] = $valuex;
                            }//end if
                          }//end for lvl 2
                          
                          $tempdata3[] = $tempdata2;
                          
                          if(isset($data[$itmdata['trno'].'-'.$liner])){
                            $liner += 1;
                            $data[$itmdata['trno'].'-'.$liner] = $tempdata3;
                          }else{
                            $data[$itmdata['trno'].'-'.$liner] = $tempdata3;
                          }//end if
                          break; //used to EXIT LOOP
                        }else{
                          $tempdata3 = [];
                          foreach ($value as $keyx => $valuex) {
                            if($keyx == 'isqty' || $keyx == 'iss' || $keyx == 'expiry' || $keyx == 'loc' || $keyx == 'ext'){
                              switch ($keyx) {
                                case 'ext': case 'isamt': case 'amt':
                                  $computeddata = Yii::$app->backend->computestock_Internal($value['isamt'],$value['disc'],floatval($invdata[$i]['bal']),$value['uomfactor'],$doc);
                                  $tempdata2['ext'] = $computeddata['ext'];
                                  $tempdata2['amt'] = $computeddata['amt'];
                                break;

                                case 'iss':
                                  $value[$keyx] = floatval($value[$keyx]) - floatval($invdata[$i]['bal']);
                                  $tempdata2[$keyx] = floatval($invdata[$i]['bal']);
                                break;

                                case 'isqty':
                                  $value[$keyx] = floatval($value[$keyx]) - (floatval($invdata[$i]['bal']) / floatval($value['uomfactor'])); 
                                  $tempdata2[$keyx] = floatval($invdata[$i]['bal']) / floatval($value['uomfactor']); 
                                break;
                                
                                case 'expiry': case 'loc':
                                  $tempdata2[$keyx] = $invdata[$i][$keyx];
                                break;
                              }//end swith
                            }else{
                              $tempdata2[$keyx] = $valuex;
                            }//end if
                          }//end for lvl 2
                        }//end if 2nd lvl
                        $tempdata3[] = $tempdata2;
                        $liner+= 1;
                        if(isset($data[$itmdata['trno'].'-'.$liner])){
                          $liner += 1;
                          $data[$itmdata['trno'].'-'.$liner] = $tempdata3;
                        }else{
                          $data[$itmdata['trno'].'-'.$liner] = $tempdata3;
                        }//end if
                      }//end for 
                    }else{
                      foreach ($value as $keyx => $valuex) {
                        $tempdata2[$keyx] = $valuex;
                      }//end for lvl 2

                      $liner += 1;
                      $tempdata3[] = $tempdata2;
                      $data[$itmdata['trno'].'-'.$liner] = $tempdata3;
                    }//end if        
                  }//end for each
          }else{
            $data[$itmdata['trno'].'-'.$itmdata['line']] = $stock->getdetailstock($doc2,$itmdata['trno'],$itmdata['line']);          
          }//end if
        break;

        default:
          $data[$itmdata['trno'].'-'.$itmdata['line']] = $stock->getdetailstock($doc2,$itmdata['trno'],$itmdata['line']);          
        break;
      }//end switch

      }//end for each
    }//end for each

    return $data;
  }//end if

public function retrieveOrderdatadetailed($doc,$params) {
  try {
    $stock = new Postock;
    $doc2 = '';
    
    switch($doc) {
      case 'RR':
        $doc2 = 'PO';
      break;
      case 'SJ': case 'SJ2':
        $doc2 = 'SO';
      break;
      case 'DM':
        $doc2 = 'RR';
      break;
      case 'CM':
        $doc2 = 'SJ';
      break;
      case 'PO':
        $doc2 = 'PR';
      break;
      case 'TS':
        $doc2 = 'TR';
      break;
      case 'MX':
        $doc2='PR';
      break;
      case 'SO':
        $doc2='QA';
      break;
    }//end switch

    ###ORIGINAL
    foreach ($params as $keyer => $value) {
        switch (Yii::$app->systemsettings->companyConfig()) {
          case 'UNIVERSE':
            if($doc == "SJ" || $doc == "TS" || $doc == "MX" || $doc == "MI"){
              $tempdata = $stock->getdetailstock($doc2,$value['trno'],$value['line']);
                    foreach ($tempdata as $key => $value) {
                      $params['q'] = $value['itemid'];
                      $params['wh'] = $value['whcode'];
                      $invdata = Yii::$app->backend->getAvailableInventory($params);
                      $liner = $keyer;
                      
                      if(!empty($invdata)){
                        for ($i = 0; $i < count($invdata) ; $i++) { 
                          if(floatval($invdata[$i]['bal']) > floatval($value['iss'])){
                            $tempdata3 = [];
                            foreach ($value as $keyx => $valuex) {
                              if($keyx == 'expiry' || $keyx == 'loc' || $keyx == 'ext'){
                                switch ($keyx) {
                                  case 'ext': case 'isamt': case 'amt':
                                    $computeddata = Yii::$app->backend->computestock_Internal($value['isamt'],$value['disc'],$value['isqty'],$value['uomfactor'],$doc);
                                    $tempdata2['ext'] = $computeddata['ext'];
                                    $tempdata2['amt'] = $computeddata['amt'];
                                  break;

                                  case 'expiry': case 'loc':
                                    $tempdata2[$keyx] = $invdata[$i][$keyx];
                                  break;
                                }//end switch
                              }else{
                                $tempdata2[$keyx] = $valuex;
                              }//end if
                            }//end for lvl 2
                            
                            $tempdata3[] = $tempdata2;
                            if(isset($data[$value['trno'].'-'.$liner])){
                              $data[$value['trno'].'-'.($liner + 1)] = $tempdata3;
                            }else{
                              $data[$value['trno'].'-'.$liner] = $tempdata3;
                            }//end if
                            break;
                          }else{
                            $tempdata3 = [];
                            foreach ($value as $keyx => $valuex) {
                              if($keyx == 'isqty' || $keyx == 'iss' || $keyx == 'expiry' || $keyx == 'loc' || $keyx == 'ext'){
                                switch ($keyx) {
                                  case 'ext': case 'isamt': case 'amt':
                                    $computeddata = Yii::$app->backend->computestock_Internal($value['isamt'],$value['disc'],floatval($invdata[$i]['bal']),$value['uomfactor'],$doc);
                                    $tempdata2['ext'] = $computeddata['ext'];
                                    $tempdata2['amt'] = $computeddata['amt'];
                                  break;

                                  case 'iss':
                                    $value[$keyx] = floatval($value[$keyx]) - floatval($invdata[$i]['bal']);
                                    $tempdata2[$keyx] = floatval($invdata[$i]['bal']);
                                  break;

                                  case 'isqty':
                                    $value[$keyx] = floatval($value[$keyx]) - (floatval($invdata[$i]['bal']) / floatval($value['uomfactor'])); 
                                    $tempdata2[$keyx] = floatval($invdata[$i]['bal']) / floatval($value['uomfactor']); 
                                  break;
                                  
                                  case 'expiry': case 'loc':
                                    $tempdata2[$keyx] = $invdata[$i][$keyx];
                                  break;
                                }//end swith
                              }else{
                                $tempdata2[$keyx] = $valuex;
                              }//end if
                            }//end for lvl 2
                          }//end if 2nd lvl
                          $tempdata3[] = $tempdata2;
                          if(isset($data[$value['trno'].'-'.$liner])){
                            echo $value['trno'].'-'.$liner . ' oo ';
                            $data[$value['trno'].'-'.($liner + 1)] = $tempdata3;
                          }else{
                            $data[$value['trno'].'-'.$liner] = $tempdata3;
                          }//end if
                          $liner += 1;
                        }//end for 
                      }else{
                        foreach ($value as $keyx => $valuex) {
                          $tempdata2[$keyx] = $valuex;
                        }//end for lvl 2

                        $tempdata3[] = $tempdata2;
                        $data[$value['trno'].'-'.$liner] = $tempdata3;
                      }//end if        
                    }//end for each
            }else{
              $data[$value['trno'].'-'.$value['line']] = $stock->getdetailstock($doc2,$value['trno'],$value['line']);
            }//end if
          break;

          default:
            $data[$value['trno'].'-'.$value['line']] = $stock->getdetailstock($doc2,$value['trno'],$value['line']);
          break;
        }//end switch
    }//end if

    return $data;

    
  } catch (ErrorException $e) {
    echo $e;
  }
  }//END IF
  
  public function retrieveOrderdata($doc,$params,$type){
    $stock = new Postock;
    $doc2='';
        switch ($doc) {
          case 'RR':
            $doc2='PO';
            break;
          case 'SJ': case 'SJ2':
            $doc2='SO';
            break;
          case 'DM':
            $doc2='RR';
            break;
          case 'CM':
            $doc2='SJ';
            break;   
            case 'PO':
                $doc2='PR';
                break;
            // SALON MODIFICATION    
            case 'TS':
              $doc2='TR';
                break;
            // END SALON                                
        }//END switch
        
        foreach ($params as $key => $value) {
                if($type == "summary"){
                    $return = $stock->getsummarystock($doc2,$params[$key]['trno']);
                     
                     foreach ($return as $itmindex => $itmdata) {
                      $data[$itmdata['trno'].'-'.$itmdata['line']] = $stock->getdetailstock($doc2,$itmdata['trno'],$itmdata['line']);
                     }                     
                }else{
                    $data[$key] = $stock->getdetailstock($doc2,$params[$key]['trno'],$params[$key]['line']);
                }//END IF
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
              switch ($doc) {
                case 'TS':
                  $qryupdate = "update lahead set trpricegrp='".$data[$key2][0]['trpricegrp']."',
                  trroute='".$data[$key2][0]['routeid']."',agent='".$data[$key2][0]['agent']."' where trno='".$optionaltrno."'";
                  $sql2=Yii::$app->sbccommon->execqry($qryupdate);
                  break;
              }//END SWITCH
            break;
        }//end switch case

        }//END 1ST LEVEL FOR EACH
    return $data;
  }//END RETRIEVEPODATA

  public function getdefaultValues($type){
    switch ($type) {
      case 'tax':
        return '12';
        break;
      
      default:
        return "invalid";
        break;
    }//END CASE
  }//END GETTAXAMOUNT

  public function AjaxVerification($controller){
    if(!Yii::$app->request->isAjax){
          return $controller->redirect(Url::to(['/admin/default/index']));
      }//END IS AJAX
  }//END IS AJAX

  public function compareStocklines($controller,$data){
    $doc = $controller->module->id;
    $trno = $data['trno'];
    $line = $data['line'];
    $ischanged = 0;
    $ext = number_format(str_replace(",","",$data['ext']),Yii::$app->systemsettings->setDecimaldisplay('currency')); 
    $stockdata = $this->returnStockline($controller,$trno,$line);
      switch ($doc) {
        case 'PO': case 'RR':
          $qty = number_format(str_replace(",","",$data['qty']));
          $cost = number_format(str_replace(",","",$data['cost']),Yii::$app->systemsettings->setDecimaldisplay('currency')); 
          
            if($stockdata[0]['barcode'] == $data['barcode'] && $stockdata[0]['uom'] == $data['uom'] && $stockdata[0]['whcode'] == $data['whcode'] &&  number_format($stockdata[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $ext && $stockdata[0]['rem'] == $data['rem'] && $stockdata[0]['ref'] == $data['ref'] &&  number_format($stockdata[0]['qty']) == $qty &&  number_format($stockdata[0]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $cost){
                $ischanged = 0;
              }else{
                $ischanged = 1;
              }//END IF
          break;

        case 'CM':
          $qty = number_format(str_replace(",","",$data['qty']));
          $cost = number_format(str_replace(",","",$data['amt']),Yii::$app->systemsettings->setDecimaldisplay('currency')); 
            if($stockdata[0]['barcode'] == $data['barcode'] && $stockdata[0]['uom'] == $data['uom'] && $stockdata[0]['whcode'] == $data['whcode'] &&  number_format($stockdata[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $ext && $stockdata[0]['rem'] == $data['rem'] && $stockdata[0]['ref'] == $data['ref'] &&  number_format($stockdata[0]['qty']) == $qty &&  number_format($stockdata[0]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $cost){
                $ischanged = 0;
              }else{
                $ischanged = 1;
              }//END IF
          break;

        case 'SO': case 'SJ': case 'DM': case 'MX': case 'MI':
          $iss = number_format(str_replace(",","",$data['iss']));
          $amt = number_format(str_replace(",","",$data['amt']),Yii::$app->systemsettings->setDecimaldisplay('currency')); 

            if($stockdata[0]['barcode'] == $data['barcode'] && $stockdata[0]['uom'] == $data['uom'] && $stockdata[0]['whcode'] == $data['whcode'] &&  number_format($stockdata[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $ext && $stockdata[0]['loc'] == $data['loc'] &&  number_format($stockdata[0]['iss']) == $iss &&  number_format($stockdata[0]['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $amt){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF
        break;
        
        case 'IS':
          $qty = number_format(str_replace(",","",$data['qty']));
          $cost = number_format(str_replace(",","",$data['cost']),Yii::$app->systemsettings->setDecimaldisplay('currency')); 
            if($stockdata[0]['barcode'] == $data['barcode'] && $stockdata[0]['uom'] == $data['uom'] && $stockdata[0]['whcode'] == $data['whcode'] &&  number_format($stockdata[0]['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $ext && number_format($stockdata[0]['qty']) == $qty &&  number_format($stockdata[0]['cost'],Yii::$app->systemsettings->setDecimaldisplay('currency')) == $cost){
                $ischanged = 0;
              }else{
                $ischanged = 1;
              }//END IF
          break;

        default:
          # code...
          break;
      }//END SWITCH

      return array('ischanged' => $ischanged,'stockdata'=>$stockdata);
  }//END STOCKLINES


    public function compareDetaillines($controller,$data){
        $doc = $controller->module->id;
        $trno = $data['trno'];
        $line = $data['line'];
        $ischanged = 0;
        $detaildata = $this->returnDetailline($controller,$trno,$line);
        
        switch ($doc) {
            case 'RR':
                $db = number_format(str_replace(",","",$data['db']),4);
                $cr = number_format(str_replace(",","",$data['cr']),4); 
                    
                    if($detaildata[0]['postdate'] == $data['postdate'] && $detaildata[0]['checkno'] == $data['checkno'] && $detaildata[0]['acno'] == $data['acno'] && $detaildata[0]['rem'] == $data['rem'] && $detaildata[0]['ref'] == $data['ref'] && $detaildata[0]['client'] == $data['client']){
                        $ischanged = 0;
                    }else{
                        $ischanged = 1;
                    }//END IF

                break;
        }//END SWITCH

        return array('ischanged' => $ischanged,'detaildata'=>$detaildata);
    }//END STOCKLINES


  public function requestLine($name){
    return $itemid = Yii::$app->sbccommon->datareader("select line from taxmenu where name = '".$name."'");
  }//END REQUEST ITEMID

  public function itemQuickaddtax($controller,$params){
    try {

    $type ='taxmenu';
    $doc = $controller->module->id;
    $line = Yii::$app->backend->requestLine($params['name']);

    $primarydata = $this->pullDatainfo($controller,$type,$line);

    if(!empty($primarydata)){
        $error= "";
        $primarydata[0]['name'];
        $primarydata[0]['atc'] ;
        $primarydata[0]['rate'];
        $primarydata[0]['tdb'];
        $primarydata[0]['acno'];
        $primarydata[0]['acnoname'];
    }else{
        $error = "ERROR ITEM NOT FOUND";
    }//end if

    $dataobj = new Taxdetail();
    
    $dataobj->acnoname = $primarydata[0]['name'];
    $dataobj->acno = $primarydata[0]['atc'];

    if($params['rate'] == ''){
       $dataobj->rate =  0.00;
    }else{
       $dataobj->rate =  $params['rate'];
    }//end if

    if($params['taxincome'] == ''){
       $dataobj->income = 0.00;
    }else{
       $dataobj->income = $params['taxincome'];
    }//end if

    $dataobj->wheld = $params['taxwheld'];
    $dataobj->trno = $params['trno'];
    $dataobj->month = $params['taxmonth'];


    if($params['line'] == 0){
      $status = Taxdetail::insertdetail($params['trno'], $dataobj,'taxdetail', 'TW');
    }else{
      $status = Taxdetail::updatedetail($params['trno'], $params['line'], $dataobj, 'TW');
    }//end if
    
    return $status;
    } catch (ErrorException $e) {
      echo $e;
    return 0;
    }
  }//END ITEM QUICK ADD

  public function searchdistro($controller,$access,$str) {
      $qry = "select detail.line,detail.acnoname,coa.acno,
        round(db,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as db,
        round(cr,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cr,
        detail.checkno from gldetail as detail
        left join coa on coa.acnoid = detail.acnoid
        where detail.trno = ".$str."";
      return $qry;
    }

  public function itemQuickadd($controller,$params){
    $type ='item';
    $doc = $controller->module->id;
    $itemid = Yii::$app->backend->requestItemid($params['barcode']);
    $primarydata = $this->pullDatainfo($controller,$type,$itemid);
    if(!empty($primarydata)){
            $error= "";
            $primarydata[0]['loc'] = "";
            $primarydata[0]['loc2'] = "";
            $primarydata[0]['expiry'] = "";

            switch ($doc) {
              case 'SP':
                $computeddata = $this->computestock($primarydata[0]['rrcost'],$primarydata[0]['disc'],1,1,$controller);
                $primarydata[0]['rrqty'] = 1;
                $primarydata[0]['ext'] = $computeddata['ext'];
                $primarydata[0]['qty'] = $computeddata['qty'];
                $primarydata[0]['cost'] = $computeddata['cost'];
                $primarydata[0]['whcode'] = 'WH0000000000001';
                $primarydata[0]['whname'] = '';
                $primarydata[0]['uomfactor'] = 1;
              break;//

              case 'RR': case 'PO': case 'PC': case 'IS': case 'PR': case 'PI':
                $computeddata = $this->computestock($primarydata[0]['rrcost'],$primarydata[0]['disc'],1,1,$controller);
                $primarydata[0]['rrqty'] = 1;
                $primarydata[0]['ext'] = $computeddata['ext'];
                $primarydata[0]['qty'] = $computeddata['qty'];
                $primarydata[0]['cost'] = $computeddata['cost'];
                $primarydata[0]['whcode'] = $params['whcode'];
                $primarydata[0]['whname'] = $params['whname'];
                $primarydata[0]['uomfactor'] = 1;               
              break;
              case 'AJ': case 'PK':
                $computeddata = $this->computestock($primarydata[0]['rrcost'],$primarydata[0]['disc'],1,1,$controller);
                $primarydata[0]['rrqty'] = 1;
                $primarydata[0]['ext'] = $computeddata['ext'];
                $primarydata[0]['qty'] = $computeddata['qty'];
                $primarydata[0]['iss'] = 0;
                $primarydata[0]['cost'] = $computeddata['cost'];
                $primarydata[0]['whcode'] = $params['whcode'];
                $primarydata[0]['whname'] = $params['whname'];
                $primarydata[0]['uomfactor'] = 1;               
              break;
              case 'CM':
                $computeddata = $this->computestock($primarydata[0]['isamt'],$primarydata[0]['disc'],1,1,$controller); 
                $primarydata[0]['amt'] = $computeddata['amt'];
                $primarydata[0]['rrqty'] = 1;
                $primarydata[0]['ext'] = $computeddata['ext'];
                $primarydata[0]['qty'] = $computeddata['qty'];
                $primarydata[0]['whcode'] = $params['whcode'];
                $primarydata[0]['whname'] = $params['whname'];
                $primarydata[0]['uomfactor'] = 1;               
              break; 
              case 'TW':
                $primarydata[0]['name'] = $computeddata['name'];
                $primarydata[0]['atc'] = $computeddata['atc'];
                $primarydata[0]['rate'] = $computeddata['rate'];
              break;
              default:
                $computeddata = $this->computestock($primarydata[0]['isamt'],$primarydata[0]['disc'],1,1,$controller);
                $primarydata[0]['isqty'] = 1;
                $primarydata[0]['ext'] = $computeddata['ext'];
                $primarydata[0]['iss'] = $computeddata['iss'];
                $primarydata[0]['amt'] = $computeddata['amt'];
                $primarydata[0]['whcode'] = $params['whcode'];
                $primarydata[0]['qa'] = 1;
                $primarydata[0]['whname'] = $params['whname'];
                $primarydata[0]['uomfactor'] = 1;               
              break;
            }//end switch
        }else{
            $error = "ERROR ITEM NOT FOUND";
        }
        return array('primarydata' => $primarydata,'errmsg'=>$error);
  }//END ITEM QUICK ADD


// XANDABELS
public function loadAvailableuom($itemid,$doc){
    $query = "select 0 as isfromitem,uom,factor,amt,line,kilos,cbm,ifnull(uom_desc,'') as uom_desc from uom where itemid = ".$itemid." order by line";
    $data = Yii::$app->sbccommon->opentable($query);

    if(empty($data)){ 
      switch (Yii::$app->systemsettings->companyConfig()) {
        case 'UNIVERSE':
          switch ($doc) {
            case 'PR': case 'PO': case 'RR': case 'DM':
            case 'IS': case 'AJ': case 'TR': case 'TS': case 'PC': case 'stockcard':
              $query = "select 1 as isfromitem,item.purchase_uom as uom,uom.factor,uom.amt,
                        uom.line,uom.kilos,uom.cbm,ifnull(uom.uom_desc,'') as uom_desc from item
                        left join uom on uom.itemid = item.itemid and uom.uom = item.purchase_uom
                        where item.itemid = " . $itemid;
            break;
            
            case 'SO': case 'SJ': case 'CM': case 'MI':
              $query = "select 1 as isfromitem,1 as kilos,'' as uom_desc,uom,1 as factor,amt,1 as line,cbm from item where itemid = ".$itemid."";
            break;
          }//END SWITCH
        break;
        
        default:
          $query = "select 1 as isfromitem,1 as kilos,'' as uom_desc,uom,1 as factor,amt,1 as line,cbm from item where itemid = ".$itemid."";
        break;
      }//END SWITCH

      $data = Yii::$app->sbccommon->opentable($query);
    }//end if data empty

    return $data;
  }//END AVAILABLE UOM

  private function getPriceviaTerms($bcode,$terms){
    switch (intval($terms)) {
      case 30:
        $grp = 'W';
      break;

      case 60:
        $grp = 'A';
      break;

      case 90:
        $grp = 'B';
      break;
      
      default:
        $grp = 'R';
      break;
    }//end switch
    
    return $this->getItemPricePerPriceGrp($bcode,$grp);
  }//end f

  public function requestItemprice($params){    
    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'KINGGEORGE':
        switch ($params['doc']) {
          case 'SO': case 'SJ': case 'CM':
            $head=Common::localhead($params['doc']);
            $qry = "select terms from ".$head." where trno = " . $params['trno'];
            $trans_terms = Yii::$app->sbccommon->datareader($qry);
            $iteminfo = $this->getPriceviaTerms($params['barcode'],$trans_terms);

            $latestprice[0]['computeramt'] = $iteminfo[0]['computeramt'];
            $latestprice[0]['uom'] = "";
            $latestprice[0]['disc'] = $iteminfo[0]['disc'];
            $latestprice[0]['rem'] = "";
          break;

          default:
            $latestprice = $this->getCustomerLatestPrice($params['doc'],$params['barcode'],$params['ccode']);
          break;
        }//END SWITCH
      break;

      case 'GAMELINE_POS':
        switch ($params['doc']) {
          case 'TS': case 'AJ':
            $iteminfoqry = "select (stock.rrcost / uom.factor) as computeramt from rrstatus as rrs
            left join item on item.itemid = rrs.itemid
            left join client as wh on wh.clientid = rrs.whid
            left join glstock as stock on stock.trno = rrs.trno and stock.line = rrs.line
            left join uom on uom.itemid = rrs.itemid and uom.uom = rrs.uom
            where item.barcode = '".$params['barcode']."'
            and rrs.bal <> 0 and wh.iswarehouse = 1 and wh.client = '".$params['ccode']."'
            order by rrs.dateid asc,rrs.trno asc limit 1";

            $iteminfo = Yii::$app->sbccommon->opentable($iteminfoqry);
            if(!empty($iteminfo)) {
              $latestprice[0]['computeramt'] = $iteminfo[0]['computeramt'];
            } else {
              $latestprice[0]['computeramt'] = 0;
            }//end switch
            
            $latestprice[0]['uom'] = "";
            $latestprice[0]['disc'] = "";
            $latestprice[0]['rem'] = "";
          break;          
          
          default:
            $latestprice = $this->getCustomerLatestPrice($params['doc'],$params['barcode'],$params['ccode']);
          break;
        }//END SWTICH
      break;

      case 'TENPLUS':
        switch ($params['doc']) {
          case 'SJ':
            $pricegrp = $this->requestAgentPriceGroup($params['agcode']);
            $iteminfo = $this->getItemPricePerPriceGrp($params['barcode'],$pricegrp);

            $latestprice[0]['computeramt'] = $iteminfo[0]['computeramt'];
            $latestprice[0]['uom'] = "";
            $latestprice[0]['disc'] = $iteminfo[0]['disc'];
            $latestprice[0]['rem'] = "";
          break;          
          
          default:
            $latestprice = $this->getCustomerLatestPrice($params['doc'],$params['barcode'],$params['ccode']);
          break;
        }//END SWTICH
      break;


      case 'UNIVERSE':
        switch ($params['doc']) {
          case 'RR': case 'SP': case 'PO': case 'DM':
            $latestprice = $this->getCustomerLatestPrice($params['doc'],$params['barcode'],$params['ccode']);
            $qry = "select purchase_uom,factor from item
            left join uom on uom.uom = item.purchase_uom
            and uom.itemid = item.itemid
            where barcode = '".$params['barcode']."'";
            
            $purchaseuom = Yii::$app->sbccommon->opentable($qry);
            if($purchaseuom != ''){
              $latestprice[0]['uom'] = $purchaseuom[0]['purchase_uom'];
              $latestprice[0]['factor'] = $purchaseuom[0]['factor'];
            }//end if
          break;          

          case 'TS': case 'AJ': case 'TR': case 'SJ': case 'SO': case 'CM':
            $latestprice = $this->getCustomerLatestPrice($params['doc'],$params['barcode'],$params['ccode'],$params['wh']);

            switch ($params['doc']) {
              case 'SJ':  case 'SO': case 'CM':
                $qry = "select item.uom as purchase_uom,factor from item
                left join uom on uom.uom = item.uom
                and uom.itemid = item.itemid
                where barcode = '".$params['barcode']."'";
                
                $purchaseuom = Yii::$app->sbccommon->opentable($qry);
              break;

              default:
                $qry = "select purchase_uom,factor from item
                left join uom on uom.uom = item.purchase_uom
                and uom.itemid = item.itemid
                where barcode = '".$params['barcode']."'";
                
                $purchaseuom = Yii::$app->sbccommon->opentable($qry);
              break;
            }//end switch

            if($purchaseuom != ''){
              $latestprice[0]['uom'] = $purchaseuom[0]['purchase_uom'];
              $latestprice[0]['factor'] = $purchaseuom[0]['factor'];
            }//end if

            if($params['doc'] == "TS"){
              $latestprice[0]['disc'] = '';
              $latestprice[0]['computeramt'] = '0';
            }//end if
          break;
          
          default:
            $latestprice = $this->getCustomerLatestPrice($params['doc'],$params['barcode'],$params['ccode'],$params['wh']);
          break;
        }//END SWTICH
      break;

      default:
        $latestprice = $this->getCustomerLatestPrice($params['doc'],$params['barcode'],$params['ccode']);
      break;
    }//END SWITCH CASE

    return $latestprice;
  }//END ITEM PRICE

  public function requestItemid($barcode){;
   $itemid = Yii::$app->sbccommon->datareader("select itemid from item where barcode = '".$barcode."'");
   
   if(empty($itemid)){
    $itemid = 0;
   }//end

   return $itemid;
  }//END REQUEST ITEMID

  public function requestItemBarcode($itemid){
   $barcode = Yii::$app->sbccommon->datareader("select barcode from item where itemid = '".$itemid."'");
   if(empty($itemid)){
    $barcode = '';
   }//end
   return $barcode;
  }//END REQUEST ITEMID

  public function searchItembal($controller,$access,$itemid,$factor = 1) {
    if($controller->module->id == 'admin') {
      $query = "select rrstatus.itemid, wh.clientname as whname, rrstatus.loc, 
      round((sum(rrstatus.bal)/".$factor."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal,
      rrstatus.expiry from rrstatus left join client as wh on wh.clientid = rrstatus.whid  
      where rrstatus.itemid = ".$itemid." and rrstatus.bal>0 
      group by wh.clientname,rrstatus.loc,rrstatus.expiry";
      return $query;
    } else {
      if(Yii::$app->session['loggeduser']['access'][$access] == 1) {
        $query = "select rrstatus.itemid, wh.clientname as whname, rrstatus.loc,
        round((sum(rrstatus.bal)/".$factor."),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as bal, 
        rrstatus.expiry from rrstatus 
        left join client as wh on wh.clientid = rrstatus.whid  
        where rrstatus.itemid = ".$itemid." and rrstatus.bal>0 
        group by wh.clientname,rrstatus.loc,rrstatus.expiry";
        return $query;
      }
    }
  }


  public function getItembalance($itemid,$factor = 1){
    $center = Yii::$app->session['loggeduser']['center'];
    $query = "select wh.clientname as whname,rrstatus.loc,(sum(rrstatus.bal) / ".$factor.") as bal,rrstatus.expiry from rrstatus
              left join client as wh on wh.clientid = rrstatus.whid 
              where rrstatus.itemid = ".$itemid." 
              and rrstatus.bal>0 group by wh.clientname,rrstatus.loc,rrstatus.expiry";

    return $data = Yii::$app->sbccommon->opentable($query);
  }//END VIEW STOCK

  

  //FOR COMPUTATION OF STOCK  
  //FUNCTION WAS EXTENDED AND ROOT FUNCTION WAS SET TO PRIVATE TO BE REUSED (to disregard controller parameter and less change to every function)
  //edited by jaoskipogi 3/21/2018 4:23:15 PM
  public function computestock($amt,$disc,$qty,$uomfactor,$controller,$vat = 0){
    $doc = $controller->module->id; // viewmoduleid
    if (empty($disc)){
      $disc=0;
    }//end if
    //end alvin
    
    return $this->stockCompute($amt,$disc,$qty,$uomfactor,$doc,$vat);
  }//END COMPUTE STOCK

  public function computestock_Internal($amt,$disc,$qty,$uomfactor,$doc,$vat = 0){
    if (empty($disc)){
      $disc=0;
    }//end if
    //end alvin
    //echo "gg <br>";
    return $this->stockCompute($amt,$disc,$qty,$uomfactor,$doc,$vat);
  }//END COMPUTE STOCK

  private function stockCompute($amt,$disc,$qty,$uomfactor,$doc,$vat){
    //COMPUTATION FOR PRICES AND EXT
    //echo "gg <br>";
    //echo "[".$amt."] [".$qty."] [".$disc."] [". $uomfactor. "] [" .$qty."]";

    if($qty == 0){
       $hiddenqty = 0 * $uomfactor; //[ISS / QTY]
       $hiddenamt = 0;
    }else{
          //REFACTORED : 1/6/2020 11:54:15 AM
          //(QTY - DISC) * QTY
          //$hiddenqty = abs($qty) * $uomfactor; //[ISS / QTY].
          //$hiddenamt = (Yii::$app->sbccommon->Discount($amt * $qty,$disc) / $uomfactor) / $qty; //[ISAMT / RRCOST]
          $hiddenqty = abs($qty) * $uomfactor; //[ISS / QTY]
          $hiddenamt = Yii::$app->sbccommon->Discount($amt,$disc) * $qty; 
          $hiddenamt = ($hiddenamt / $uomfactor) / $qty; //[ISAMT / RRCOST]
    }//END IF

    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'SOUTHCENTRAL': case 'DAVISALON_JOY': case 'GALANG':
          $ext = Yii::$app->sbccommon->Discount($amt,$disc) * $qty; //[ISAMT / RRCOST]
      break;

      case 'UNIVERSE': case 'FHI':
        $ext =  number_format(round(Yii::$app->sbccommon->Discount($amt,$disc),Yii::$app->systemsettings->setDecimaldisplay('unitprice')) * $qty,Yii::$app->systemsettings->setDecimaldisplay('currency')) ; //[ISAMT / RRCOST]
      break;
 
      default:
        $ext = Yii::$app->sbccommon->Discount(floatval($amt),$disc); //[ISAMT / RRCOST]
        $ext = str_replace(',', '', $ext);
        $ext = floatval($ext)*floatval($qty);
        $ext = number_format($ext,Yii::$app->systemsettings->setDecimaldisplay('currency'));
      break;
    }//end switch case

    switch ($doc) {
      case 'SO': case 'QA': case 'JB':
        return array('iss'=>$hiddenqty,'amt'=>$hiddenamt,'ext'=>$ext,'qa' => $qty);
      break;

      case 'RR': case 'IS': case 'PO': case 'PC': case 'PR': case 'PI': case 'TR': case 'SP':
        if($doc == 'RR'){
            if($vat != 0){
              $hiddenamt = floatval($hiddenamt) / 1.12;
            }//end if
        }//end 

        return array('qty'=>$hiddenqty,'cost'=>$hiddenamt,'ext'=>$ext);
      break;
      
      case 'SJ': case 'DM':
        return array('iss'=>$hiddenqty,'amt'=>$hiddenamt,'ext'=>$ext);
      break;
      
      case 'CM':
        return array('qty'=>$hiddenqty,'amt'=>$hiddenamt,'ext'=>$ext);        
      break;
      
      case 'AJ': case 'PK':
          if($qty>0){
            return array('qty'=>$hiddenqty,'iss'=>0,'cost'=>$hiddenamt,'ext'=>$ext);        
          }else{
            return array('qty'=>0,'iss'=>$hiddenqty,'cost'=>$hiddenamt,'ext'=>$ext);        
          }//end if
      break;
                
      default:
        return array('iss'=>$hiddenqty,'amt'=>$hiddenamt,'ext'=>$ext,'qa' => $qty);
      break;
    }//END SWITCH
  }//end private function


  public function computestock2($amt,$disc,$qty,$qty2,$uomfactor,$controller){
    $doc = $controller->module->id; // viewmoduleid
    
    //COMPUTATION FOR PRICES AND EXT
    if($qty == 0){
      $hiddenqty = 0; //[ISS / QTY]
    }else{
      $hiddenqty = abs($qty) * $uomfactor; //[ISS / QTY]
    }

    if($qty2 == 0){
       $hiddenqty2 = 0; //[ISS / QTY]
       $hiddenamt = 0;
    }else{
      $hiddenqty2 = abs($qty2) * $uomfactor; //[ISS / QTY].
      $hiddenamt = (Yii::$app->sbccommon->Discount($amt * $qty2,$disc) / $uomfactor) / $qty2; //
    }

    $ext = Yii::$app->sbccommon->Discount($amt * $qty2,$disc); //[ISAMT / RRCOST]

    return array('iss'=>$hiddenqty,'iss2'=>$hiddenqty2,'amt'=>$hiddenamt,'ext'=>$ext);
  }//END COMPUTE STOCK


  //FOR PULLING DATA AND RETURN SOMETHING TO THE MODULE WHEN CANCELLING ON BODY [ACCOUNTING OR INVENTORY TABS]
  public function returnStockline($controller,$trno,$line){
    $Webproc = new Webproc;
    switch ($controller->module->id) {
      case 'SJ2':
          $doc = 'SJ';
          break;
      
      default:
          $doc = $controller->module->id;
          break;
  }//END SWITCH
    $stock = $Webproc->getstocktype($doc);

    if($doc == 'SP'){
        $model = new Lastock;
        return $model->openstockline($doc,$trno,$line);
    }else{
        switch($stock){
          case 'Lastock':
          $model = new Lastock;
          return $model->openstockline($doc,$trno,$line);
            break;
          
          default:
          $model = new Postock;
          return $model->openstockline($doc,$trno,$line);
            break;
        }//end switch
    }//end if
    
  }//END RETURN BODY DATA

  public function returnDetailline($controller,$trno,$line){
        $doc = $controller->module->id;
        if ($doc == 'TW'){
        $model = new Taxdetail;
        return  $model->opendetailline($trno,$line,$doc);
        } else {
        $model = new Ladetail;
        return  $model->opendetailline($trno,$line,$doc);
        }
  }//end function

  //WILL BE USED FOR CLIENT , ITEM TABLES (TO PULL A SPECIFIC DATA WITH A PRIMARY KEY) [ON LOOKUP]
  public function pullDatainfo($controller,$type,$datastring){
    switch($type) {
      case 'client':
        # code...
        break;
      case 'warehouse':
        # code...
        break;
      case 'agent':
        # code...
        break;
      case 'supplier':
        # code...
        break;
       case 'taxmenu':
        return $data = $this->pullTaxdata($datastring,$controller);
        break;  
      default: 
        //FOR ITEM
        return $data = $this->pullItemdata($datastring,$controller);
      break;
    }
  }//END PULL DATA INFO

  
  private function pullTaxdata($searchstring,$controller){
      $query = "select line,name,atc,rate,0 as tdb,'' as acno,'' as acnoname from taxmenu where line = ".$searchstring."";
      $data = Yii::$app->sbccommon->opentable($query);
      return $data;
  }

  public function searchProdInstruction($controller,$access,$searchstring){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      //IF VIEW ACCESS IS NOT AVAILABLE
      return $data = '';
    }else{
      $qry = "select head.trno,head.docno,item.itemid,head.client,head.clientname,head.client,head.dateid,
                transnum.postdate,transnum.postedby 
                from hpihead as head
                left join item as item on item.barcode = head.client
                left join transnum on transnum.trno = head.trno
                where head.doc = 'PI'
                and head.docno like '%".$searchstring."%' or head.clientname like '%".$searchstring."%' 
                and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                order by docno LIMIT 50";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end if yii app access
  }//end function 

  public function loadAvailableterms(){
    $query = "select line,terms,days from terms";
    return $query;
    // return $data = Yii::$app->sbccommon->opentable($query);
  }//END AVAILABLE TERMS

  public function searchSupplierNoAccess($controller,$searchstring) {
    return $data = $this->supplierSearch($searchstring,$controller->module->id);
  }//end function

  public function searchSupplier($controller,$access,$searchstring) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {
    }else{
      return $data = $this->supplierSearch($searchstring,$controller->module->id);
    }//end if
  }

  public function searchProdOrder($controller,$access,$searchstring){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      //IF VIEW ACCESS IS NOT AVAILABLE
      return $data = '';
    }else{
        $qry = "select head.trno,head.docno,head.client,head.clientname,head.client,head.dateid,
                transnum.postdate,transnum.postedby 
                from hpdhead as head
                left join transnum on transnum.trno = head.trno
                where head.docno like '%".$searchstring."%' and head.prc = '' 
                and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                or head.clientname like '%".$searchstring."%' and head.prc = '' 
                and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                order by docno LIMIT 50";
      return $data = Yii::$app->sbccommon->opentable($qry);
    }//end if yii app access
  }//end function 

  //FUNCTION USED TO SEARCH AND LOOKUP DOCUMENTS FROM LOOK UP MODALS
  public function searchDocument($controller,$access,$searchstring){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      return $data = '';
    }else{
      switch ($controller->module->id) {
        case 'SJ2':
          $doc = 'SJ';
        break;

        case 'quotation':
          $doc = 'QT';
        break;

        default:
          $doc = $controller->module->id;
        break;
      }//end switch

      if($doc=='SOApproval'){
        return $data = $this->google('',$searchstring,$doc);
      } elseif ($doc=="tpshipping") {
        return $data = $this->google('',$searchstring,$doc);

      } elseif ($doc=="tphandling") {
        return $data = $this->google('',$searchstring,$doc);
      }else{

        $head=Common::localhead($doc);
        $hhead=Common::localhhead($doc);
        $headparams = array('head' => $head, 'hhead' => $hhead);
        return $data = $this->google($headparams,$searchstring,$doc);
      }//end if
    }//end if access
  }//end f

//############################################## CLIENT SEARCHING ############################################################

    public function ReportsearchClient($access,$searchstring,$type){
        switch ($type) {
            case 'customer':
                return $data = $this->customerSearch($searchstring);
                break;
            case 'supplier':
                return $data = $this->supplierSearch($searchstring);
                break;
            case 'warehouse':    
                return $data = $this->warehouseSearch($searchstring);
                break;                
            case 'agent':
                return $data = $this->agentSearch($searchstring);
                break;
        }//END SWITCH
    }//end function 

  public function searchClient($controller,$access,$searchstring){
      switch ($controller->module->id) {
        case 'SJ2':
          $doc = 'SJ';
        break;
        default:
          $doc = $controller->module->id;
          if ($doc == 'pscheme') {
            $doc = 'PS';
          }//end if
        break;
      }//END SWITCH

      switch ($doc) {
        case 'MX':
          return $data = $this->WarhouseMXSearch($searchstring);
        break;
        //END 
        case 'MI':
          return $data = $this->CustomerAssetSearch($searchstring);
        break;

        case 'branch':
          return $data = $this->branchSearch($searchstring);
        break;

        case 'PS':
          return $data = $this->clientSearch($searchstring);
        break;

        case 'QA': case 'SO': case 'SJ': case 'CM': case 'customer': case 'CR': case 'KR': case 'stockcard':
        case 'PD': case 'CK': case 'KL': case 'reportlist': case 'quickcollect':
        case 'FG': case 'quotation': case 'JB':
          return $data = $this->customerSearch($searchstring);
        break;
        case 'assetmaster':
          return $data = $this->assetSearch($searchstring);
        break;
        case 'scheduler':
          return $data = $this->SchedulercustomerSearch($searchstring);
        break;
        case 'RR': case 'DM': case 'PO': case 'supplier': case 'PV': case 'PR': case 'itemprofile':  case 'TW': case 'SP':
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
              switch ($doc) {
                case 'PR': case 'PO': case 'SP': case 'DM':
                  $allowviewconfi = $this->checkConfidentialAccess();
                  $additionalparams = ['allowviewconfi'=>$allowviewconfi];
                  $data = $this->supplierSearch($searchstring,$additionalparams);
                break;    
                default:
                  $data = $this->supplierSearch($searchstring);
                break;
              }//end switch
            break;
            default:
              $data = $this->supplierSearch($searchstring);
            break;
          }//end switch
          return $data;
        break;
        case 'GJ': case 'AP': case 'AR': case 'CV':
          return $data = $this->allClientSearch($searchstring);
        break;
        case 'warehouse':    
          return $data = $this->warehouseSearch($searchstring);
        break;                
        case 'agent':
          return $data = $this->agentSearch($searchstring);
        break;
        case 'location':
          return $data = $this->locationSearch($searchstring);
        break;  
        case 'vendor':
          return $data = $this->vendorSearch($searchstring);
        break;   
        default:
        
        break;
      }//END SWITCH   
  }//END SEARCH DOCUMENT

//############################################## CLIENT SEARCHING #####################################################

//############################################## ITEM SEARCHING #######################################################

  public function searchSupplierPODetailed($controller,$access,$searchstring,$clientcode) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      switch($controller->module->id) {
        case 'SO':
          $doc2 = 'QA'; 
        break; 
        case 'CM':
          $doc2 = 'SJ';
        break;
        case 'SJ':
          $doc2 = 'SO';
        break;
        case 'PO':
          $doc2 = 'PR';
        break;
        case 'RR':
          $doc2 = 'PO';
        break;
        case 'DM':
          $doc2 = 'RR';
        break;
        case 'TS':
          $doc2 = 'TR';
        break;
        case 'customer':
          $doc2 = 'customer';
        break;
        case 'MX':
          $doc2='PR';
        break;
      }
      return $data = $this->supplierPOsearchDetailed($searchstring,$clientcode,$doc2);
    }
  }

    private function supplierPOsearchDetailed($searchthis,$clientcode,$doc2) {
    switch($doc2) {
      case 'RR':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,wh.client as wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from glhead as head
          right join glstock as stock on stock.trno = head.trno 
          left join item on item.itemid=stock.itemid 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join cntnum on cntnum.trno = head.trno
          left join client as wh on wh.clientid=stock.whid
          left join client on client.clientid=head.clientid
          where client.client = '".$clientcode."' and stock.qty >stock.qa 
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.docno like '%".$searchthis."%'
          and stock.void <> 1
          or 
          client.client = '".$clientcode."' and stock.iss >stock.qa 
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.yourref like '%".$searchthis."%' 
          and stock.void <> 1
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,wh.client as wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from glhead as head right join glstock as stock on stock.trno = head.trno left join item on item.itemid=stock.itemid 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join cntnum on cntnum.trno = head.trno left join client as wh on wh.clientid=stock.whid
          left join client on client.clientid=head.clientid
          where client.client = '".$clientcode."' and stock.qty >stock.qa
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          order by head.dateid desc";
        }//searchparams
      break;
      case 'PO':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hpohead as head
          right join hpostock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.qty >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.docno like '%".$searchthis."%'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' and stock.iss >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.yourref like '%".$searchthis."%' 
          and stock.void <> 1
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hpohead as head
          right join hpostock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.qty >stock.qa
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          order by head.dateid desc";
        }//searchparams
      break;
      case 'PR':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.qty >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.docno like '%".$searchthis."%'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' and stock.iss >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.yourref like '%".$searchthis."%' 
          and stock.void <> 1
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.qty >stock.qa
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          order by head.dateid desc";
        }//searchparams
      break;
      case 'PR':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.qty >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.docno like '%".$searchthis."%'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' and stock.qty >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.yourref like '%".$searchthis."%' 
          and stock.void <> 1
          order by head.dateid desc";
          return $query;
        }else{
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.qty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.cost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.qty >stock.qa
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          order by head.dateid desc";
        }//searchparams
      break;
      case 'SJ':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
          round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          stock.ext,wh.client as wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
          stock.loc,head.yourref,stock.uom from glhead as head
          right join glstock as stock on stock.trno = head.trno 
          left join cntnum on cntnum.trno = head.trno
          left join client on client.clientid=head.clientid left join client as wh on wh.clientid=stock.whid 
          left join item on item.itemid=stock.itemid 
          left join uom on uom.itemid=stock.itemid and uom.uom=stock.uom where head.doc='SJ' 
          and client.client = '".$clientcode."' and stock.iss>stock.qa and head.docno like '%".$searchthis."%'
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,item.barcode,
          round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
          round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qty,
          round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,stock.disc,
          round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as cost,
          stock.ext,wh.client as wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
          stock.loc,head.yourref,stock.uom from glhead as head
          right join glstock as stock on stock.trno = head.trno 
          left join cntnum on cntnum.trno = head.trno
          left join client on client.clientid=head.clientid left join client as wh on wh.clientid=stock.whid 
          left join item on item.itemid=stock.itemid 
          left join uom on uom.itemid=stock.itemid and uom.uom=stock.uom where head.doc='SJ' 
          and client.client = '".$clientcode."' and stock.iss>stock.qa
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          order by head.dateid desc";
        }//searchparams
      break;
      case 'QA':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
          round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
          round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
          round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hqahead as head
          right join hqastock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.iss >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.docno like '%".$searchthis."%'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' and stock.iss >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.yourref like '%".$searchthis."%' 
          and stock.void <> 1
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
          round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
          round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
          round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hqahead as head
          right join hqastock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.iss >stock.qa
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          order by head.dateid desc";
        }//searchparams
      break;
      case 'SO':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
          round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
          round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
          round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hsohead as head
          right join hsostock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.iss >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.docno like '%".$searchthis."%'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' and stock.iss >stock.qa 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and head.yourref like '%".$searchthis."%' 
          and stock.void <> 1
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
          round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
          round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
          round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
          round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
          round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
          round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
          from hsohead as head
          right join hsostock as stock on stock.trno = head.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' and stock.iss >stock.qa
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          order by head.dateid desc";
        }//searchparams
      break;
      case 'TR':
        if(!empty($searchthis)) {
          $query = "select 0 as rrqty, 0 as qty, 0 as amt,htrhead.docno, date(htrhead.dateid) as dateid, htrhead.yourref,item.itemid,stock.trno, stock.line,stock.trno, stock.barcode, 
          stock.itemname, stock.uom, stock.cost, (stock.qty-stock.qa) as iss,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty, 
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
          uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
          left(stock.encodeddate,10) as encodeddate, stock.disc, stock.void,
          round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom
          .factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
          stock.ref,stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
          stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor,
          '' as expiry,htrhead.trpricegrp,rmas.route_name as route,rmas.route_id as routeid,
          tragent.client as agent,tragent.clientname as agentname
          FROM htrhead 
          left join htrstock as stock on stock.trno=htrhead.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join client as warehouse on warehouse.client=stock.wh
          left join client as tragent on tragent.client=htrhead.agent
          left join route_masterfile as rmas on rmas.route_id = htrhead.trroute
          where stock.void <> 1 and stock.qty>stock.qa and htrhead.docno like '%".$searchthis."%'
          order by htrhead.dateid desc";
        } else {
          $query = "select 0 as rrqty, 0 as qty, 0 as amt,htrhead.docno, htrhead.yourref, date(htrhead.dateid) as dateid, item.itemid,stock.trno, stock.line, stock.barcode, 
          stock.itemname, stock.uom, stock.cost, (stock.qty-stock.qa) as iss,
          round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as rrcost,
          round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty, 
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else 
          uom.factor end) * stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,
          left(stock.encodeddate,10) as encodeddate, stock.disc, stock.void,
          round((stock.qty-stock.qa)/ case when ifnull(uom.factor,0)=0 then 1 else uom
          .factor end,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
          round(((stock.qty-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,
          stock.ref,stock.wh as whcode,warehouse.clientname as wh,stock.loc,item.brand,
          stock.rem,case when ifnull(uom.factor,0)=0 then 1 else uom.factor end as uomfactor,
          '' as expiry,htrhead.trpricegrp,rmas.route_name as route,rmas.route_id as routeid,
          tragent.client as agent,tragent.clientname as agentname
          FROM htrhead 
          left join htrstock as stock on stock.trno=htrhead.trno 
          left join item on item.barcode=stock.barcode 
          left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
          left join client as warehouse on warehouse.client=stock.wh
          left join client as tragent on tragent.client=htrhead.agent
          left join route_masterfile as rmas on rmas.route_id = htrhead.trroute
          where stock.void <> 1 and stock.qty>stock.qa
          order by htrhead.dateid desc";
        }
      break;
      case 'customer':
        if(!empty($searchthis)){
          $query = "select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
            round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
            round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
            round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
            round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
            round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
            round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
            round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,
            head.yourref,stock.uom
            from sohead as head
            right join sostock as stock on stock.trno = head.trno 
            left join item on item.barcode=stock.barcode 
            left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' and stock.iss >stock.qa and head.docno like '%".$searchthis."%'
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            UNION ALL
            select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
            round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
            round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
            round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
            round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
            round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
            round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
            round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
            from hsohead as head
            right join hsostock as stock on stock.trno = head.trno 
            left join item on item.barcode=stock.barcode 
            left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' and stock.iss >stock.qa and head.docno like '%".$searchthis."%'
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            order by head.dateid desc";
        }else{
          $query = "
            select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
            round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
            round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
            round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
            round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
            round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
            round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
            round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
            from sohead as head
            right join sostock as stock on stock.trno = head.trno 
            left join item on item.barcode=stock.barcode 
            left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' and stock.iss >stock.qa
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            UNION ALL
            select stock.trno,stock.line,stock.itemname,head.docno,stock.barcode,
            round(stock.isqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as isqty,
            round(stock.iss,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as iss,
            round(stock.isamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as isamt,stock.disc,
            round(stock.amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as amt,
            round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as ext,stock.wh,
            round((stock.qa / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as qa,
            round(((stock.iss-stock.qa) / case when ifnull(uom.factor,0)=0 then 1 else uom.factor end),".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as pending,stock.loc,head.yourref,stock.uom
            from hsohead as head
            right join hsostock as stock on stock.trno = head.trno 
            left join item on item.barcode=stock.barcode 
            left join uom on uom.itemid=item.itemid and uom.uom=stock.uom 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' and stock.iss >stock.qa
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            order by head.dateid desc";
        }//searchparams
      break;
    }
    return $query;
  }
  
   public function searchSupplierPOSummarized($controller,$access,$searchstring,$clientcode) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      switch($controller->module->id) {
        case 'SO': 
          $doc2 = 'QA';
        break;
        case 'SJ':
          $doc2 = 'SO';
        break;
        case 'CM':
          $doc2 = 'SJ';
        break;
        case 'PO':
          $doc2 = 'PR';
        break;
        case 'RR':
          $doc2 = 'PO';
        break;
        case 'DM':
          $doc2 = 'RR';
        break;
        case 'TS':
          $doc2 = 'TR';
        break;
        case 'MX':
          $doc2 = 'PR';
        break;
        case 'customer':
          $doc2 = 'customer';
        break;
      }
      return $data = $this->supplierPOsearchSummarized($searchstring,$clientcode,$doc2);
    }
  }
  private function supplierPOsearchSummarized($searchthis,$clientcode,$doc2) {
    switch($doc2) {
      case 'QA':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from hqahead as head
            right join hqastock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and stock.iss>stock.qa and head.docno like '%".$searchthis."%' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.void <> 1
            or 
            head.client = '".$clientcode."' 
            and stock.iss>stock.qa
            and head.yourref like '%".$searchthis."%' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.void <> 1
            group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from hqahead as head
            right join hqastock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.void <> 1
            and stock.iss>stock.qa group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }//searchparams
      break;
      case 'PR':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' 
          and stock.qty>stock.qa and head.docno like '%".$searchthis."%' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' 
          and stock.qty>stock.qa
          and head.yourref like '%".$searchthis."%' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          and stock.qty>stock.qa group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }//searchparams
      break;
      case 'SO':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from hsohead as head
            right join hsostock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and stock.iss>stock.qa and head.docno like '%".$searchthis."%' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.void <> 1
            or 
            head.client = '".$clientcode."' 
            and stock.iss>stock.qa
            and head.yourref like '%".$searchthis."%' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.void <> 1
            group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from hsohead as head
            right join hsostock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.void <> 1
            and stock.iss>stock.qa group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }//searchparams
      break;
      case 'SJ':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from glhead as head
            right join glstock as stock on stock.trno = head.trno 
            left join client on client.clientid=head.clientid  
            left join cntnum on cntnum.trno = head.trno
            where head.doc='SJ' 
            and client.client = '".$clientcode."' and stock.iss>stock.qa 
            and head.docno like '%".$searchthis."%' 
            and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
            group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from glhead as head
            right join glstock as stock on stock.trno = head.trno 
            left join cntnum on cntnum.trno = head.trno
            left join client on client.clientid=head.clientid  where head.doc='SJ' 
            and client.client = '".$clientcode."' and stock.iss>stock.qa 
            and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
            group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }//searchparams
      break;
      case 'TR':
        if(!empty($searchthis)) {
          $query = "select htrhead.doc,htrhead.docno, date(htrhead.dateid) as dateid,htrhead.trno,
            sum(round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').")) as totalamt,htrhead.yourref
            FROM htrhead 
            left join htrstock as stock on stock.trno = htrhead.trno 
            left join item on item.barcode = stock.barcode left join uom on uom.itemid=item.itemid and uom.uom = stock.uom 
            left join client as warehouse on warehouse.client = stock.wh 
            where stock.qty>stock.qa and htrhead.docno like '%".$searchthis."%'
            group by htrhead.docno
            order by htrhead.dateid desc";
        } else {
          $query = "select htrhead.doc,htrhead.docno, date(htrhead.dateid) as dateid,htrhead.trno,
            sum(round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('currency').")) as totalamt, htrhead.yourref
            FROM htrhead 
            left join htrstock as stock on stock.trno = htrhead.trno 
            left join item on item.barcode = stock.barcode 
            left join uom on uom.itemid=item.itemid and uom.uom = stock.uom 
            left join client as warehouse on warehouse.client=stock.wh where stock.qty>stock.qa
            group by htrhead.docno
            order by htrhead.dateid desc";
        }
      break;
      case 'PR':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' 
          and stock.qty>stock.qa and head.docno like '%".$searchthis."%' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' 
          and stock.iss>stock.qa
          and head.yourref like '%".$searchthis."%' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from hprhead as head
          right join hprstock as stock on stock.trno = head.trno 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          and stock.qty>stock.qa group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }//searchparams
      break;
      case 'PO':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from hpohead as head
          right join hpostock as stock on stock.trno = head.trno 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' 
          and stock.qty>stock.qa and head.docno like '%".$searchthis."%' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          or 
          head.client = '".$clientcode."' 
          and stock.iss>stock.qa
          and head.yourref like '%".$searchthis."%' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from hpohead as head
          right join hpostock as stock on stock.trno = head.trno 
          left join transnum on transnum.trno = head.trno
          where head.client = '".$clientcode."' 
          and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          and stock.qty>stock.qa group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }//searchparams
      break;
      case 'RR':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from glhead as head
          right join glstock as stock on stock.trno = head.trno 
          left join cntnum on cntnum.trno = head.trno
          left join client on client.clientid=head.clientid
          where head.client = '".$clientcode."' 
          and stock.qty>stock.qa and head.docno like '%".$searchthis."%' 
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          or 
          client.client = '".$clientcode."' 
          and stock.iss>stock.qa
          and head.yourref like '%".$searchthis."%' 
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
          round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
          head.yourref
          from glhead as head
          right join glstock as stock on stock.trno = head.trno 
          left join cntnum on cntnum.trno = head.trno
          left join client on client.clientid=head.clientid
          where client.client = '".$clientcode."' 
          and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
          and stock.void <> 1
          and stock.qty>stock.qa group by stock.trno,head.docno,head.dateid
          order by head.dateid desc";
        }//searchparams
      break;
      case 'customer':
        if(!empty($searchthis)){
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from sohead as head
            right join sostock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and stock.iss>stock.qa and head.docno like '%".$searchthis."%' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            group by stock.trno,head.docno,head.dateid
            union all
            select stock.trno,head.doc,head.docno,head.dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref
            from hsohead as head
            right join hsostock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and stock.iss>stock.qa and head.docno like '%".$searchthis."%'
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }else{
          $query = "select stock.trno,head.doc,head.docno,left(head.dateid,10) as dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref from sohead as head
            right join sostock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.iss>stock.qa group by stock.trno,head.docno,head.dateid
            union all
            select stock.trno,head.doc,head.docno,head.dateid,
            round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
            head.yourref from hsohead as head
            right join hsostock as stock on stock.trno = head.trno 
            left join transnum on transnum.trno = head.trno
            where head.client = '".$clientcode."' 
            and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
            and stock.iss>stock.qa group by stock.trno,head.docno,head.dateid
            order by head.dateid desc";
        }//searchparams
      break;
    }
      return $query;
  }

    public function loadAvailableuom2($itemid){
      if($itemid == '') {
        $query = "select uom, 0 as isfromitem, factor, amt, line, kilos, ifnull(uom_desc,'') as uom_desc from uom group by uom";
      } else {
        $query = "select 0 as isfromitem,uom,factor,amt,line,kilos,ifnull(uom_desc,'') as uom_desc from uom where itemid = ".$itemid." order by line";
        $data = Yii::$app->sbccommon->opentable($query);
        if(empty($data)){
          $query = "select 1 as isfromitem,1 as kilos,'' as uom_desc,uom,1 as factor,amt,1 as line from item where itemid = ".$itemid."";
        }
      }
      return $query;
    }
  
  public function searchLog($controller,$trno){
    $model = new Log();
    switch ($controller->module->id) {
      case 'SJ2': $doc = 'SJ'; break;
      
      case 'pscheme':
        $doc ='PS';
      break;


      case 'quotation':
        $doc = 'QT';
      break;

      default: $doc = $controller->module->id; break;
    }//end switch

    $data = $model->getlogs($doc, $trno);
    return $data;
  }


  public function searchItem($controller,$access,$searchstring, $addedparams = []){
    if($controller->module->id == 'admin') {
      return $data = $this->itemSearch($searchstring);
    } else {
        $doc = $controller->module->id;
        switch ($doc) {
          case 'itemprofile': case 'TA':
              return $data = $this->itemSearchfa($searchstring);
            break;
          
          case 'fmanager':
              return $data = $this->fmanageritemSearch($searchstring);
          break;

          case 'TW':
              return $data = $this->taxmenuitemSearch($searchstring);
          break;

          case 'FG':
            return $data = $this->finishedgoodsearch($searchstring);
          break;

          case 'managefdeals':
              return $data = $this->fFlashDealItemSearch($searchstring);
          break;

          default:
              return $data = $this->itemSearch($searchstring , $addedparams);
          break;
      }//end else lvl 3
    }//end else lvl 2
  }//end else 1

  public function searchFGItem($controller,$access,$searchstring){
      $doc = $controller->module->id;
      $sql = "select sizeid,barcode,itemid,category,grp.stockgrp_name as groupid, itemname, 
              uom, round(amt,2) as amt, brand, ifnull(cls.cl_name,'') as class, disc,body,
              ifnull(part.part_name,'') as part,ifnull(model.model_name,'') as model from item 
              left join item_class as cls on cls.cl_id=item.class 
              left join stockgrp_masterfile as grp on grp.stockgrp_id = item.groupid
              left join model_masterfile as model on model.model_id = item.model
              left join part_masterfile as part on part.part_id = item.part
              left join uv_principal on uv_principal.line = item.uv_principal";
      
      $keyword = explode(",", $searchstring);
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where fg_isfinishedgood = 1 and item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and fg_isfinishedgood = 1 and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or    
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or                                
                                      item.sizeid LIKE '%" . $key. "%')";
              }//end if
          }//end for each
      return $sql . " " . $criteria . " order by item.itemname asc limit 1000";
  }//end else 1

  public function searchWarehouse($controller,$access,$searchstring){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      //IF VIEW ACCESS IS NOT AVAILABLE
    }else{
      return $data = $this->warehouseSearch($searchstring);
    }//END ACCESS VALIDATION
  }//END SEARCH WAREHOUSE

    public function searchBranchWarehouse($searchstring){
        return $data = $this->warehouseSearch($searchstring);
    }//end search branch warehouse

  public function searchCostcenters($controller,$access) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      return "select line,code,name from projectmasterfile";
    }
  }

  public function searchContra($controller,$access,$searchstring){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      //IF VIEW ACCESS IS NOT AVAILABLE
    }else{
        switch ($controller->module->id) {
            case 'SJ2':
                $doc = 'SJ';
                break;
            
            default:
                $doc = $controller->module->id;
                break;
        }//END SWITCH
        //return $data = $this->contraBankSearch($searchstring);
        return $data = $this->contraSearch($searchstring,$doc);           
    }//END ACCESS VALIDATION
  }//END SEARCH WAREHOUSE



  private function google($headparams,$searchthis,$doc){
    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'YULICK': case 'UNIVERSE':
        $order = 'order by dateid desc ';
      break;
      
      default:
        $order = 'order by docno ';
      break;
    }//end switch

    switch ($doc) {
      case 'QA': case 'SO': case 'PO': case 'PC':  case 'KR': case 'PR': case 'PI': 
      case 'PD': case 'RF': case 'TX': case 'TR':  case 'pscheme': case 'PS':
      case 'SP': case 'quotation': case 'QT': case 'JB':
        switch (Yii::$app->systemsettings->companyConfig()) {
          case 'SOUTHCENTRAL':
            switch ($doc) {
              case 'TX':
                $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,
                  yourref,ourref,rem from (
                  select transnum.trno,transnum.docno,'' as clientname,'' as client,
                  head.dateid,transnum.postdate,transnum.postedby, '' as yourref,'' as ourref,head.rem from transnum
                  left join txhead as head on head.trno = transnum.trno
                  where transnum.doc = '".$doc."' and transnum.postdate is null and transnum.center = '001'
                  UNION ALL
                  select transnum.trno,transnum.docno,'' as clientname,'' as client,head.dateid,transnum.postdate,
                  transnum.postedby, '' as yourref,'' as ourref,head.rem from transnum
                  left join htxhead as head on head.trno = transnum.trno
                  where transnum.doc = '".$doc."'
                  and transnum.postdate is not null and transnum.center = '001') as tbl
                  where docno like '%%' order by docno LIMIT 50";
              break;
              case 'RF':
                $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,yourref,ourref,rem from
                  (select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem
                  from transnum
                  left join rfhead as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  UNION ALL
                  select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem
                  from transnum
                  left join hrfhead as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is not null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
                  where docno like '%".$searchthis."%' 
                  or clientname like '%".$searchthis."%' 
                  or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
              break;
              case 'PO':
                if($this->checkConfidentialAccess()) {$filter = "";} else { $filter = " and groupid <> 'CONFI'";}
                $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,yourref,ourref,rem from
                  (select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem
                  from transnum
                  left join ".$headparams['head']." as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  $filter
                  UNION ALL
                  select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem
                  from transnum
                  left join ".$headparams['hhead']." as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is not null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  $filter) as tbl
                  where docno like '%".$searchthis."%' 
                  or clientname like '%".$searchthis."%' 
                  or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
              break;
              case 'PR':
                if($this->checkConfidentialAccess()) {$filter = "";} else {$filter = " and groupid <> 'CONFI'";}
                $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,yourref,ourref,rem from
                  (select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem from transnum
                  left join ".$headparams['head']." as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  $filter
                  UNION ALL
                  select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem from transnum
                  left join ".$headparams['hhead']." as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is not null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  $filter) as tbl
                  where docno like '%".$searchthis."%' 
                  or clientname like '%".$searchthis."%' 
                  or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
              break;

              case 'JB':
                  $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,yourref,ourref,rem from
                  (select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem
                  from transnum
                  left join ".$headparams['head']." as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  UNION ALL
                  select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem
                  from transnum
                  left join ".$headparams['hhead']." as head on head.trno = transnum.trno
                  left join client on client.client = head.client
                  where transnum.doc = '".$doc."' and transnum.postdate is not null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
                  where docno like '%".$searchthis."%' 
                  or clientname like '%".$searchthis."%' 
                  or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
              break;

              default:
                $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,yourref,ourref,rem from
                  (select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem 
                  from transnum
                  left join ".$headparams['head']." as head on head.trno = transnum.trno
                  where transnum.doc = '".$doc."' and transnum.postdate is null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  UNION ALL
                  select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem
                  from transnum
                  left join ".$headparams['hhead']." as head on head.trno = transnum.trno
                  where transnum.doc = '".$doc."' and transnum.postdate is not null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
                  where docno like '%".$searchthis."%' 
                  or clientname like '%".$searchthis."%' 
                  or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
              break;
            }
          break;        

          default:

            if($doc=='pscheme'){
              $doc='PS';
            }//end if

            $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,yourref,ourref,rem from
              (select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
              head.yourref,head.ourref,head.rem 
              from transnum
              left join ".$headparams['head']." as head on head.trno = transnum.trno
              where transnum.doc = '".$doc."' and transnum.postdate is null
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
              UNION ALL
              select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
              head.yourref,head.ourref,head.rem
              from transnum
              left join ".$headparams['hhead']." as head on head.trno = transnum.trno
              where transnum.doc = '".$doc."' and transnum.postdate is not null
              and transnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
              where docno like '%".$searchthis."%' 
              or clientname like '%".$searchthis."%' 
              or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
          break;
        } 
      break;
      case 'TW':
        $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,ifnull(postdate,'') as postdate,postedby,yourref,ourref,rem from
          (select head.trno,head.docno,head.clientname,head.client,head.dateid,taxnum.postedby,taxnum.postdate,
          head.yourref,head.ourref,head.rem
          from taxhead as head
          left join taxnum on taxnum.trno = head.trno
          where head.doc = 'TW'
          and taxnum.center = '".Yii::$app->session['loggeduser']['center']."'
          UNION ALL
          select head.trno,head.docno,head.clientname,cl.client,head.dateid,taxnum.postedby,taxnum.postdate,
          head.yourref,head.ourref,head.rem
          from htaxhead as head
          left join client as cl on cl.clientid = head.clientid
          left join taxnum on taxnum.trno = head.trno
          where head.doc = 'TW'
          and taxnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
          where docno like '%".$searchthis."%' or clientname like '%".$searchthis."%'
          or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%'
          ".$order." LIMIT 50";
      break;

      case 'SOApproval':
        $qry="select docno,left(dateid,10) as dateid,client,clientname,reason1 as rem from hsohead 
          where (docno like '%".$searchthis."%' or clientname like '%".$searchthis."%' or reason1 like '%".$searchthis."%') 
          and isapproved=0 order by docno desc";
      break;

      case 'tpshipping':
        $qry ="select head.trno,head.doc, head.docno, client.client, client.clientname,cntnum.postdate, cntnum.postedby
              from cntnum
              left join glhead as head on cntnum.trno = head.trno
              left join client on head.clientid = client.clientid
              left join client as agent on head.agentid = client.clientid
              where cntnum.sbill = 0 and head.doc ='SJ' and (head.docno like '%".$searchthis."%' or head.clientname like '%".$searchthis."%'
              or head.yourref like '%".$searchthis."%' or head.ourref like '%".$searchthis."%')";
      break;


      case 'tphandling':
        $qry ="select head.trno,head.doc, head.docno, client.client, client.clientname,cntnum.postdate, cntnum.postedby
              from cntnum
              left join glhead as head on cntnum.trno = head.trno
              left join client on head.clientid = client.clientid
              left join client as agent on head.agentid = client.clientid
              where cntnum.shandling = 0 and head.doc ='SJ' and (head.docno like '%".$searchthis."%' or head.clientname like '%".$searchthis."%'
              or head.yourref like '%".$searchthis."%' or head.ourref like '%".$searchthis."%')";
      break;

      default:
        switch (Yii::$app->systemsettings->companyConfig()) {
          case 'UNIVERSE':
          switch ($doc) {
                case 'SP': 
                   $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,postedby,ifnull(postdate,'') as postdate,yourref,ourref,rem from
                  (select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem ,head.effectdate
                  from transnum
                  left join ".$headparams['head']." as head on head.trno = transnum.trno
                  where transnum.doc = '".$doc."' and transnum.postdate is null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                  UNION ALL
                  select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,transnum.postdate,transnum.postedby,
                  head.yourref,head.ourref,head.rem,head.effectdate
                  from transnum
                  left join ".$headparams['hhead']." as head on head.trno = transnum.trno
                  where transnum.doc = '".$doc."' and transnum.postdate is not null
                  and transnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
                  where docno like '%".$searchthis."%' 
                  or clientname like '%".$searchthis."%' 
                  or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";

              break;

              default:
              $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,ifnull(postdate,'') as postdate,postedby,yourref,ourref,rem from
              (select head.trno,head.docno,head.clientname,head.client,head.dateid,cntnum.postedby,cntnum.postdate,
              head.yourref,head.ourref,head.rem
              from cntnum
              left join ".$headparams['head']." as head on head.trno = cntnum.trno
              where cntnum.doc = '".$doc."' and cntnum.postdate is null
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
              UNION ALL
              select cntnum.trno,cntnum.docno,head.clientname,cl.client,head.dateid,cntnum.postedby,cntnum.postdate,
              head.yourref,head.ourref,head.rem
              from cntnum
              left join ".$headparams['hhead']." as head on head.trno = cntnum.trno
              left join client as cl on cl.clientid = head.clientid
              where cntnum.doc = '".$doc."' and cntnum.postdate is not null
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
              where docno like '%".$searchthis."%' or clientname like '%".$searchthis."%'
              or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' or rem like '%".$searchthis."%' ".$order." LIMIT 50";
              break;
              }

          break; //

          case 'SOUTHCENTRAL':
            switch ($doc) {
              case 'SP':
                  if($this->checkConfidentialAccess()) {$filter = "";} else {$filter = " and cl.groupid <> 'CONFI'";}
                $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,ifnull(postdate,'') as postdate,postedby,yourref,ourref,rem from
                  (select head.trno,head.docno,head.clientname,head.client,head.dateid,cntnum.postedby,cntnum.postdate,
                  head.yourref,head.ourref,head.rem
                  from cntnum
                  left join ".$headparams['head']." as head on head.trno = cntnum.trno
                  left join client as cl on cl.client = head.client
                  where cntnum.doc = '".$doc."' and cntnum.postdate is null
                  and cntnum.center = '".Yii::$app->session['loggeduser']['center']."' $filter
                  UNION ALL
                  select cntnum.trno,cntnum.docno,head.clientname,cl.client,head.dateid,cntnum.postedby,cntnum.postdate,
                  head.yourref,head.ourref,head.rem
                  from cntnum
                  left join ".$headparams['hhead']." as head on head.trno = cntnum.trno
                  left join client as cl on cl.clientid = head.clientid
                  where cntnum.doc = '".$doc."' and cntnum.postdate is not null
                  and cntnum.center = '".Yii::$app->session['loggeduser']['center']."' $filter) as tbl
                  where docno like '%".$searchthis."%' or clientname like '%".$searchthis."%'
                  or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
              break;
              default:
                $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,
                ifnull(postdate,'') as postdate,postedby,yourref,ourref,rem from
                (select head.trno,head.docno,head.clientname,head.client,head.dateid,cntnum.postedby,cntnum.postdate,
                head.yourref,head.ourref,head.rem
                from cntnum
                left join ".$headparams['head']." as head on head.trno = cntnum.trno
                where cntnum.doc = '".$doc."' and cntnum.postdate is null
                and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                UNION ALL
                select cntnum.trno,cntnum.docno,head.clientname,cl.client,head.dateid,cntnum.postedby,cntnum.postdate,
                head.yourref,head.ourref,head.rem
                from cntnum
                left join ".$headparams['hhead']." as head on head.trno = cntnum.trno
                left join client as cl on cl.clientid = head.clientid
                where cntnum.doc = '".$doc."' and cntnum.postdate is not null
                and cntnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
                where docno like '%".$searchthis."%' or clientname like '%".$searchthis."%'
                or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
              break;
            }
          break;

          default:
              $qry = "select trno,docno,clientname,client,left(dateid,10) as dateid,ifnull(postdate,'') as postdate,
              postedby,yourref,ourref,rem from
              (select head.trno,head.docno,head.clientname,head.client,head.dateid,cntnum.postedby,cntnum.postdate,
              head.yourref,head.ourref,head.rem
              from cntnum
              left join ".$headparams['head']." as head on head.trno = cntnum.trno
              where cntnum.doc = '".$doc."' and cntnum.postdate is null
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
              UNION ALL
              select cntnum.trno,cntnum.docno,head.clientname,cl.client,head.dateid,cntnum.postedby,cntnum.postdate,
              head.yourref,head.ourref,head.rem
              from cntnum
              left join ".$headparams['hhead']." as head on head.trno = cntnum.trno
              left join client as cl on cl.clientid = head.clientid
              where cntnum.doc = '".$doc."' and cntnum.postdate is not null
              and cntnum.center = '".Yii::$app->session['loggeduser']['center']."') as tbl
              where docno like '%".$searchthis."%' or clientname like '%".$searchthis."%'
              or yourref like '%".$searchthis."%' or ourref like '%".$searchthis."%' ".$order." LIMIT 50";
          break;
        }
      break;
    }
    return $qry;
  }

    private function taxmenuitemSearch($searchthis){
    try {
      //Yii::$app->session['nodes'] = Yii::$app->session['nodes'] . " - " . 'itemSearch(backendfunctions)';
      $sql = "select line,name,atc,rate from taxmenu ";   
      //echo $sql;
      $keyword = explode(",", $searchthis);
          //$sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item where ";    
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where (
                                      name LIKE '%" . $key. "%' or
                                      atc LIKE '%" . $key. "%' or
                                      rate LIKE '%" . $key. "%'
                                     )";
              } else {
                  $criteria = $criteria . " and " . "(
                                      ame LIKE '%" . $key. "%' or
                                      atc LIKE '%" . $key. "%' or
                                      rate LIKE '%" . $key. "%')";
              }
          } 
          return $data = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by name asc limit ". Yii::$app->systemsettings->querySearchLimit());

    } catch (ErrorException  $e) {
        
    }//end catch
  }//end search

//############################################## FOR SEARCHING OF CLIENT

  private function customerSearch($searchthis){
    return $data = "select clientid,clientname,client,contact,addr,tel,'customer' as type from client
      where (clientname like '%".$searchthis."%' and iscustomer = 1) 
      or (client like '%".$searchthis."%' and iscustomer = 1) 
      or (addr like '%".$searchthis."%' and iscustomer = 1) 
      or (tel like '%".$searchthis."%' and iscustomer = 1)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
  }

  private function WarhouseMXSearch($searchthis){
    return $data = "select type,clientid,clientname,client,contact,addr,tel from (
      select 'warehouse' as type, clientid,clientname,client,contact,addr,tel from client
      where (clientname like '%".$searchthis."%' and IsWarehouse = 1) 
      or (client like '%".$searchthis."%' and IsWarehouse = 1)
      or (addr like '%".$searchthis."%' and IsWarehouse = 1)
      or (tel like '%".$searchthis."%' and IsWarehouse = 1)) as tbl group by client order by clientname limit ". Yii::$app->systemsettings->querySearchLimit();
  }

  private function assetSearch($searchthis) {
    return $data = Yii::$app->sbccommon->opentable("select clientid,clientname,client,contact,
      addr,tel from client where (clientname like '%".$searchthis."%' and isasset = 1) 
      or (client like '%".$searchthis."%' and isasset = 1) order by clientname LIMIT 50");
  }

  private function CustomerAssetSearch($searchthis){
    return $data = "select type,clientid,clientname,client,contact,addr,tel from (
      select 'customer' as type, clientid,clientname,client,contact,addr,tel from client
      where (clientname like '%".$searchthis."%' and iscustomer = 1) 
      or (client like '%".$searchthis."%' and iscustomer = 1)
      or (addr like '%".$searchthis."%' and iscustomer = 1)
      or (tel like '%".$searchthis."%' and iscustomer = 1)
      UNION ALL
      select 'assetmaster' as type, clientid,clientname,client,contact,addr,tel from client
      where (clientname like '%".$searchthis."%' and isasset = 1) 
      or (client like '%".$searchthis."%' and isasset = 1)
      or (addr like '%".$searchthis."%' and isasset = 1)
      or (tel like '%".$searchthis."%' and isasset = 1)) as tbl
      group by client order by clientname LIMIT 50";
  }

  private function SchedulercustomerSearch($searchthis){
    return "select clientid,clientname,client,contact,addr,tel, 'customer' as type from client
    where (clientname like '%".$searchthis."%' and iscustomer = 1) or (client like '%".$searchthis."%' and iscustomer = 1) 
    or (addr like '%".$searchthis."%' and iscustomer = 1) or (tel like '%".$searchthis."%' and iscustomer = 1) order by clientname LIMIT 50";
    // return $data = Yii::$app->sbccommon->opentable($qry);
  }

  private function warehouseSearch($searchthis){
    return "select clientid as whid,client as whcode, clientname as whname , addr as whadd,
  tel as whtel from client where (clientname like '%".$searchthis."%' and iswarehouse = 1) or (client like '%".$searchthis."%' 
  and iswarehouse = 1) or (addr like '%".$searchthis."%' and iswarehouse = 1) or (tel like '%".$searchthis."%' and iswarehouse = 1)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();

  // return $data = Yii::$app->sbccommon->opentable("select clientid as whid,client as whcode, clientname as whname , addr as whadd,
  // tel as whtel from client where (clientname like '%".$searchthis."%' and iswarehouse = 1) or (client like '%".$searchthis."%' 
  // and iswarehouse = 1) or (addr like '%".$searchthis."%' and iswarehouse = 1) or (tel like '%".$searchthis."%' and iswarehouse = 1)  order by clientname LIMIT 50");
  }

  private function agentSearch($searchthis){
      return "select clientid as agid,client as agcode, clientname as agname , addr as agadd,tel as agtel from client
      where isagent = 1 and 
      (clientname like '%".$searchthis."%' or client like '%".$searchthis."%' or addr like '%".$searchthis."%' or tel like '%".$searchthis."%')
      order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
   }

   private function uvpickerSearch($searchthis){
      return "select clientid as agid,client as agcode, clientname as agname , addr as agadd,tel as agtel from client
      where isagent = 1 and uv_ispicker = 1 and 
      (clientname like '%".$searchthis."%' or client like '%".$searchthis."%' or addr like '%".$searchthis."%' or tel like '%".$searchthis."%')
      order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
   }

   private function uvcheckerSearch($searchthis){
      return "select clientid as agid,client as agcode, clientname as agname , addr as agadd,tel as agtel from client
      where isagent = 1 and uv_ischecker = 1 and 
      (clientname like '%".$searchthis."%' or client like '%".$searchthis."%' or addr like '%".$searchthis."%' or tel like '%".$searchthis."%')
      order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
   }

  //KEYWORD LOCATION&VENDOR

  private function locationSearch($searchthis){
  return $data = Yii::$app->sbccommon->opentable("select clientid as agid,client as agcode, clientname as agname , addr as agadd,tel as agtek from client
  where (clientname like '%".$searchthis."%' and islocation = 1) or (client like '%".$searchthis."%' and islocation = 1) 
  or (addr like '%".$searchthis."%' and islocation = 1) or (tel like '%".$searchthis."%' and islocation = 1)  order by client LIMIT ". Yii::$app->systemsettings->querySearchLimit());
  }

  private function vendorSearch($searchthis){
  return $data = Yii::$app->sbccommon->opentable("select clientid,contact,clientname,client,addr,tel from client
  where (clientname like '%".$searchthis."%' and isvendor = 1) or (client like '%".$searchthis."%' and isvendor = 1) 
  or (addr like '%".$searchthis."%' and isvendor = 1)
  or (tel like '%".$searchthis."%' and isvendor = 1)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit());
  }  

  //END KEYWORD LOCATION&VENDOR


  private function supplierSearch($searchthis,$module,$additionalparams = []){
    if(!empty($additionalparams)){
        switch (Yii::$app->systemsettings->companyConfig()) {
          case 'SOUTHCENTRAL':
            if($additionalparams['allowviewconfi']){
              $filter = "";  
            }else{
              $filter = " and groupid <> 'CONFI'";  
            }//end function
            $qry = "select clientid,contact,clientname,client,addr,tel, 'supplier' as type from client
                    where (clientname like '%".$searchthis."%' and issupplier = 1 $filter) or (client like '%".$searchthis."%' and issupplier = 1 $filter) 
                    or (addr like '%".$searchthis."%' and issupplier = 1 $filter)
                    or (tel like '%".$searchthis."%' and issupplier = 1 $filter)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
          break;
          
          default:
            $qry = "select clientid,contact,clientname,client,addr,tel, 'supplier' as type from client
                    where (clientname like '%".$searchthis."%' and issupplier = 1) or (client like '%".$searchthis."%' and issupplier = 1) 
                    or (addr like '%".$searchthis."%' and issupplier = 1)
                    or (tel like '%".$searchthis."%' and issupplier = 1)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
          break;
        }//end swtich case
    }else{
          switch($module) {
          case 'GJ':
            return "select clientid,clientname,contact,client,addr,tel,type from(
              select clientid,clientname,contact,client,addr,tel,'customer' as type from client
                  where (clientname like '%".$searchthis."%' and iscustomer = 1) or (client like '%".$searchthis."%' and iscustomer = 1) 
                  or (addr like '%".$searchthis."%' and iscustomer = 1) 
                  or (tel like '%".$searchthis."%' and iscustomer = 1)
              UNION ALL 
              select clientid,clientname,contact,client,addr,tel,'supplier' as type from client
                  where (clientname like '%".$searchthis."%' and issupplier = 1) or (client like '%".$searchthis."%' and issupplier = 1) 
                  or (addr like '%".$searchthis."%' and issupplier = 1) 
                  or (tel like '%".$searchthis."%' and issupplier = 1)
              UNION ALL
              select clientid,clientname,'---' as contact,client,addr,tel,'agent' as type from client
                  where (clientname like '%".$searchthis."%' and isagent = 1) or (client like '%".$searchthis."%' and isagent = 1) 
                  or (addr like '%".$searchthis."%' and isagent = 1) 
                  or (tel like '%".$searchthis."%' and isagent = 1)) as tbl order by clientname,client LIMIT ". Yii::$app->systemsettings->querySearchLimit();
          break;

          case 'PR':
            return "select clientid,contact,clientname,client,addr,tel,'supplier' as type from client
            where (clientname like '%".$searchthis."%' and iswarehouse=1) or (client like '%".$searchthis."%' and iswarehouse=1) 
            or (addr like '%".$searchthis."%' and iswarehouse=1)
            or (tel like '%".$searchthis."%' and iswarehouse=1)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
          break; 

          default:
            return "select clientid,contact,clientname,client,addr,tel,'supplier' as type from client
            where (clientname like '%".$searchthis."%' and issupplier = 1) or (client like '%".$searchthis."%' and issupplier = 1) 
            or (addr like '%".$searchthis."%' and issupplier = 1)
            or (tel like '%".$searchthis."%' and issupplier = 1)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
          break;
        }//switch($module)
    }//end if
    return $qry;
  }//end function

  private function clientSearch($searchthis){
    // var_dump($searchthis);
    // return 0;
    return $data = "select clientid,clientname,client,contact,addr,tel,'branch' as type from client
      where (clientname like '%".$searchthis."%' and isbranch = 1) 
      or (client like '%".$searchthis."%' and isbranch = 1) 
      or (addr like '%".$searchthis."%' and isbranch = 1) 
      or (tel like '%".$searchthis."%' and isbranch = 1)  order by clientname LIMIT ". Yii::$app->systemsettings->querySearchLimit();;
  }

  private function allClientSearch($searchthis){
    return $data = "select clientid,clientname,contact,client,addr,tel,type from(
    select clientid,clientname,contact,client,addr,tel,'customer' as type from client
        where (clientname like '%".$searchthis."%' and iscustomer = 1) or (client like '%".$searchthis."%' and iscustomer = 1) 
        or (addr like '%".$searchthis."%' and iscustomer = 1) 
        or (tel like '%".$searchthis."%' and iscustomer = 1)
    UNION ALL 
    select clientid,clientname,contact,client,addr,tel,'supplier' as type from client
        where (clientname like '%".$searchthis."%' and issupplier = 1) or (client like '%".$searchthis."%' and issupplier = 1) 
        or (addr like '%".$searchthis."%' and issupplier = 1) 
        or (tel like '%".$searchthis."%' and issupplier = 1)
    UNION ALL
    select clientid,clientname,'---' as contact,client,addr,tel,'agent' as type from client
        where (clientname like '%".$searchthis."%' and isagent = 1) or (client like '%".$searchthis."%' and isagent = 1) 
        or (addr like '%".$searchthis."%' and isagent = 1) 
        or (tel like '%".$searchthis."%' and isagent = 1)) as tbl order by clientname,client LIMIT ". Yii::$app->systemsettings->querySearchLimit();
  }//end function all client


  public function searchInactiveItem($searchthis){
    $sql = "select sizeid,barcode,item.itemid,category,grp.stockgrp_name as groupid,
      itemname,item.uom,uom1.factor,round(item.amt,2) as amt,brand,ifnull(cls.cl_name,'') as class,body,
      ifnull(part.part_name,'') as part,ifnull(model.model_name,'') as model,disc,
      round(item.amt - (item.amt * (REPLACE(disc,'%','')/100)),2) as netprice,uv_priority,ifnull(uv_principal.name,'') as uv_principal from item
      left join item_class as cls on cls.cl_id=item.class 
      left join uom as uom1 on item.itemid = uom1.itemid and uom1.uom = item.uom
      left join stockgrp_masterfile as grp on grp.stockgrp_id = item.groupid
      left join model_masterfile as model on model.model_id = item.model
      left join part_masterfile as part on part.part_id = item.part
      left join uv_principal on uv_principal.line = item.uv_principal";

      $keyword = explode(",", $searchthis);
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive = 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or    
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or                                
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          }//end for each
      return $sql . " " . $criteria . " order by item.itemname asc limit ". Yii::$app->systemsettings->querySearchLimit();
  }//end if

  private function itemSearch($searchthis, $addedparams = []){
      if(isset($addedparams['clientcode'])){
        $qry = "select class as pricegrp from client where iscustomer = 1 and client = '".$addedparams['clientcode']."'";
        $data = Yii::$app->sbccommon->opentable($qry);
        
        if(!empty($data)){
            $pricegrp = $data[0]['pricegrp'];
            switch ($pricegrp) {
              case 'R': 
                $pricestr = "item.amt";
                $discstr = "disc";
                break;
              case 'W': 
                $pricestr = "item.amt2";
                $discstr = "disc2";
                break;
              case 'A': 
                $pricestr = "item.amt3";
                $discstr = "disc3";
                break;
              case 'B': 
                $pricestr = "item.amt4";
                $discstr = "disc4";
                break;
              case 'C': 
                $pricestr = "item.amt5";
                $discstr = "disc5";
                break;
              case 'D': 
                $pricestr = "item.amt6";
                $discstr = "disc6";
                break;
              case 'E': 
                $pricestr = "item.amt7";
                $discstr = "disc7";
                break;
              case 'F': 
                $pricestr = "item.amt8";
                $discstr = "disc8";
                break;
              case 'G': 
                $pricestr = "item.amt9";
                $discstr = "disc9";
                break;
              case 'H': 
                $pricestr = "item.amt10";
                $discstr = "disc10";
                break;
              case 'I': 
                $pricestr = "item.amt11";
                $discstr = "disc11";
                break;
              case 'J': 
                $pricestr = "item.amt12";
                $discstr = "disc12";
                break;
              case 'K': 
                $pricestr = "item.amt13";
                $discstr = "disc13";
                break;
              case 'L': 
                $pricestr = "item.amt14";
                $discstr = "disc14";
                break;
              case 'M': 
                $pricestr = "item.amt15";
                $discstr = "disc15";
                break;
              default: 
                $pricestr = "item.amt";
                $discstr = "disc";
                break;
            }//END SWITCH
        }else{
            $pricestr = "item.amt";
            $discstr = "disc";
        }//end if
      }else{
        $pricestr = "item.amt";
        $discstr = "disc";
      }//end if

      $pricefield = "round(".$pricestr.",2) as amt";
      $netpricefield = "round(".$pricestr." - (".$pricestr." * (REPLACE(".$discstr.",'%','')/100)),2) as netprice";
      $discfield = $discstr . " as disc";

      $sql = "select shortname,sizeid,barcode,item.itemid,category,grp.stockgrp_name as groupid,
      itemname,item.uom,uom1.factor,
      ".$pricefield.",
      brand,ifnull(cls.cl_name,'') as class,body,
      ifnull(part.part_name,'') as part,ifnull(model.model_name,'') as model,
      ".$discfield.",
      ".$netpricefield.",
      round(amt2 - (amt2 * (REPLACE(disc2,'%','')/100)),2) as wholesale_net,
      uv_priority,ifnull(uv_principal.name,'') as uv_principal from item
      left join item_class as cls on cls.cl_id=item.class 
      left join uom as uom1 on item.itemid = uom1.itemid and uom1.uom = item.uom
      left join stockgrp_masterfile as grp on grp.stockgrp_id = item.groupid
      left join model_masterfile as model on model.model_id = item.model
      left join part_masterfile as part on part.part_id = item.part
      left join uv_principal on uv_principal.line = item.uv_principal";

          $keyword = explode(",", $searchthis);
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%' or
                                      uv_principal.name LIKE '%" . $key. "%' or
                                      item.uv_priority LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or    
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or                                
                                      item.sizeid LIKE '%" . $key. "%' or
                                      uv_principal.name LIKE '%" . $key. "%' or
                                      item.uv_priority LIKE '%" . $key. "%')";
              }
          } 

         return $sql . " " . $criteria . " order by item.itemname asc limit ". Yii::$app->systemsettings->querySearchLimit();
  }//end search

  public function fHighlightItemSearch($searchthis,$highid){
    try {
      //Yii::$app->session['nodes'] = Yii::$app->session['nodes'] . " - " . 'itemSearch(backendfunctions)';
      $sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item  ";   
      //echo $sql;
      $keyword = explode(",", $searchthis);
          //$sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item where ";    
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or                                    
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          }

          $sql = $sql . " " . $criteria . " and item.setfrontend = 1 and item.itemid 
          not in (select hitem.itemid from frontend_highlightitems as hitem where md5(hitem.highid) = '".$highid."') order by item.itemname asc limit ". Yii::$app->systemsettings->querySearchLimit(); 
          return $data = Yii::$app->sbccommon->opentable($sql);

    } catch (ErrorException  $e) {
        
    }//end catch
  }//end search

  public function fFlashDealItemSearch($searchthis){
    try {
      //Yii::$app->session['nodes'] = Yii::$app->session['nodes'] . " - " . 'itemSearch(backendfunctions)';
      $sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item  ";   
      //echo $sql;
      $keyword = explode(",", $searchthis);
          //$sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item where ";    
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or                                    
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          }

          $sql = $sql . " " . $criteria . " and item.setfrontend = 1 and item.itemid 
          order by item.itemname asc limit 50"; 
          return $data = Yii::$app->sbccommon->opentable($sql);

    } catch (ErrorException  $e) {
        
    }//end catch
  }//end search

  public function fDODItemSearch($searchthis,$dodid){
    try {
      //Yii::$app->session['nodes'] = Yii::$app->session['nodes'] . " - " . 'itemSearch(backendfunctions)';
      $sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item  ";   
      //echo $sql;
      $keyword = explode(",", $searchthis);
          //$sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item where ";    
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or                                    
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          }

          $sql = $sql . " " . $criteria . " and setfrontend = 1 and item.itemid 
          not in (select doditems.itemid from frontend_doditems as doditems where doditems.dodid = ".$dodid.") order by item.itemname asc limit 50"; 
          return $data = Yii::$app->sbccommon->opentable($sql);

    } catch (ErrorException  $e) {
        
    }//end catch
  }//end search

private function fmanageritemSearch($searchthis){
    try {
      //Yii::$app->session['nodes'] = Yii::$app->session['nodes'] . " - " . 'itemSearch(backendfunctions)';
      $sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item  ";   
      //echo $sql;
      $keyword = explode(",", $searchthis);
          //$sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item where ";    
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      item.model LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      item.groupid LIKE '%" . $key. "%' or                                    
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          } 
          return $data = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " and item.setfrontend = 1 order by item.itemname asc limit ". Yii::$app->systemsettings->querySearchLimit());

    } catch (ErrorException  $e) {
        
    }//end catch
  }//end search

 
  private function contraSearch($searchthis,$doc = ''){
  
  switch ($doc) {  
    case 'quickcollect':
      $filter = " and left(alias,2) in ('CA','CR') ";
    break;

    case 'RR': case 'DM':
      $filter = " and left(alias,2) = 'AP' ";
      break;

    case 'DS': case 'bankrecon':
      $filter = " and left(alias,2) = 'CB' ";
      break;

    case 'CM':
      $filter = " and left(alias,2) in ('AR','CA','CB') ";
      break;

    case 'SJ':
      $filter = " and left(alias,2) in ('AR','CR','CA') ";
      break;

    default:
      $filter = "";
      break;
  }//end switch 
  
  $qry = "select '' as acno , 0 as acnoid,'' as acnoname,'' as alias 
  UNION ALL
  select acno,acnoid,acnoname,left(alias,2) as alias 
  from coa where detail = 1 and acnoname like '%".$searchthis."%' ".$filter." 
  or detail = 1 and acno like '%\\".$searchthis."%' ".$filter." 
  order by acnoname LIMIT ". Yii::$app->systemsettings->querySearchLimit();
  
  return $qry;
  // return $data = Yii::$app->sbccommon->opentable($qry);
  }//END SWITCH CONTRA SEARCH

  /*private function contraBankSearch($searchthis){
  return $data = Yii::$app->sbccommon->opentable("select acno,acnoid,acnoname,left(alias,2) as alias from coa where acnoname like '%".$searchthis."%' and left(alias,2) = 'CB' or acno like '%\\".$searchthis."%' and left(alias,2) = 'CB' order by acnoname LIMIT 50");
  }//end funciton*/

//############################################## FOR SPECIFIC PULLING OF ITEM DATA PER PRIMARY KEY

  private function pullItemdata($searchstring,$controller){
  switch ($controller->module->id) {
      case 'SJ2':
          $doc = 'SJ';
          break;
      
      default:
          $doc = $controller->module->id;
          break;
  }//END SWITCH

  switch ($doc) {
    case 'SO': case 'SJ': case 'QA':
            $query ="select item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,stock.isamt,stock.ext,
            stock.disc,stock.rem from glhead as head 
            left join glstock as stock on stock.trno=head.trno 
            left join item on item.itemid=stock.itemid
            where head.doc='SJ' 
            and item.itemid=".$searchstring." and stock.isamt<>0 order by head.dateid desc limit 1";
            $data = Yii::$app->sbccommon->opentable($query);
          
            if(empty($data)){
              $query = "select barcode,itemid,category,groupid,itemname,uom,amt as isamt,0 as ext, disc,'' as rem 
              from item where itemid = ".$searchstring."";
              $data = Yii::$app->sbccommon->opentable($query);
            }//end if empty data
      break;
      
    case 'RR': case 'IS': case 'PO': case 'AJ': case 'PC': case 'PR': case 'PI': case 'PK': case 'TR': case 'SP':
            $query ="select item.barcode,item.itemid,item.category,item.groupid,item.itemname,stock.uom,stock.rrcost,
            stock.ext,stock.disc,stock.rem from glhead as head left join glstock as stock on stock.trno=head.trno 
            left join item on item.itemid=stock.itemid where head.doc='RR'
            and item.itemid=".$searchstring." and stock.rrcost<>0 order by head.dateid desc limit 1";
            
            $data = Yii::$app->sbccommon->opentable($query);
            
            if(empty($data)){
            $query = "select barcode,itemid,category,groupid,itemname,uom,0 as rrcost,0 as ext,'' as disc,'' as rem 
            from item where itemid = ".$searchstring."";
            $data = Yii::$app->sbccommon->opentable($query);
            } //end if empty data
      break;
    default:
          $query = "select barcode,itemid,category,groupid,itemname,uom,0 as isamt,0 as ext,'' as disc, '' as rem 
          from item where itemid = ".$searchstring."";
          $data = Yii::$app->sbccommon->opentable($query);
      break;
  }
  return $data;
  }

//############################################## GETTING LATEST PRICE GIVEN TO A CUSTOMER PER ITEM AND UOM
    private function getPriceBasedFromUOM($doc,$barcode){
      $itemid = Yii::$app->backend->requestItemid($barcode);
      $finduom = Yii::$app->sbccommon->datareader('select uom from item where itemid = '.$itemid);
      $qry = "select round(amt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as computeramt,
      discount as disc,uom,uom_desc as rem from uom where itemid = ".$itemid." and uom = '".$finduom."'";
      $data = Yii::$app->sbccommon->opentable($qry);

      if(empty($data)){
          $data[0]['computeramt'] = "0.00";
          $data[0]['uom'] = '';
          $data[0]['disc'] = "";
          $data[0]['rem'] = "";
      }//end if
      return $data;
    }//end function

    private function getCustomerLatestPrice($doc,$barcode,$customercode,$wh = ''){
      //TODO : ADD QUERY FOR POSTED TRANSACTIONS 
      $query='';
      switch ($doc) {
        case 'MX': case 'MI': case 'QA': case 'SJ': 
        case 'SO': case 'CM': case 'TS': case 'JB':
        case 'PD': case 'pscheme': case 'PS': case 'QT':
            switch (Yii::$app->systemsettings->companyConfig()) {
              case 'UNIVERSE':
                  $iteminfo = $this->getPricefromItemtbl($barcode,$customercode);
                  $data[0]['computeramt'] = $iteminfo[0]['computeramt'];
                  $data[0]['uom'] = "";
                  $data[0]['disc'] = $iteminfo[0]['disc'];
                  $data[0]['rem'] = "";

                  switch ($doc) {
                    case 'SJ': case 'TS': case 'MX': case 'MI':
                      if($wh != ""){
                        $whfilter = " and wh.client = '".$wh."' ";
                      }else{
                        $whfilter = "";
                      }//end if

                      $qryadder = "select rrstatus.expiry,rrstatus.loc,wh.client as wh,
                                  wh.clientname as whname from rrstatus
                                  left join item on item.itemid = rrstatus.itemid
                                  left join client as wh on wh.clientid = rrstatus.whid
                                  where item.barcode = '".$barcode."' and rrstatus.bal <> 0 ".$whfilter."
                                  order by expiry asc";

                      $added_data = Yii::$app->sbccommon->opentable($qryadder);

                      if(!empty($added_data)){
                        $data[0]['expiry'] = $added_data[0]['expiry'];
                        $data[0]['loc'] = $added_data[0]['loc'];
                        $data[0]['wh_rrstat'] = "";
                      }else{
                        $data[0]['expiry'] = "";
                        $data[0]['loc'] = "";
                        $data[0]['wh_rrstat'] = "";
                      }//end if
                    break;
                  }//end swtch
                  return $data;
              break;
              
              default:
                  //GET PRICE FROM LATEST PREVIOUS TRANSACTION
                  $data = $this->getPricefromLasttrans($barcode,$customercode);
                    
                  if(empty($data)){
                      $iteminfo = $this->getPricefromItemtbl($barcode,$customercode);
                      $data[0]['computeramt'] = $iteminfo[0]['computeramt'];
                      $data[0]['uom'] = "";
                      $data[0]['disc'] = $iteminfo[0]['disc'];
                      $data[0]['rem'] = "";
                  }//end if

                  return $data;
              break;
            }//end switch
        break;

        case 'RR': case 'PO': case 'AJ': case 'PC': case 'IS':
        case 'PR': case 'DM': case 'PI': case 'PK': 
        case 'TR': case 'SP':
          $query = "select computeramt,disc,uom,rem from(select head.dateid,
                    stock.rrcost as computeramt,stock.uom,stock.disc,
                    stock.rem from lahead as head
                    left join lastock as stock on stock.trno = head.trno
                    where head.doc in ('RR','IS','AJ') 
                    and stock.barcode = '".$barcode."' and head.client = '".$customercode."'
                    and stock.rrcost <> 0
                    UNION ALL
                    select head.dateid,stock.rrcost as computeramt,
                    stock.uom,stock.disc,stock.rem from glhead as head
                    left join glstock as stock on stock.trno = head.trno
                    left join item on item.itemid = stock.itemid
                    left join client on client.clientid = head.clientid
                    where head.doc in ('RR','IS','AJ') 
                    and item.barcode = '".$barcode."' and client.client = '".$customercode."'
                    and stock.rrcost <> 0
                    order by dateid desc limit 5) as tbl order by dateid desc limit 1";

            $data = Yii::$app->sbccommon->opentable($query);

            if(empty($data)){
                $data[0]['computeramt'] = "0.00";
                $data[0]['uom'] = "";
                $data[0]['disc'] = "";
                $data[0]['rem'] = "";
            }//end if
            
            return $data;
        break;
          
        default:
          return $data = "";
        break;
      }//end switch
    }//end getcustomerlatestprice

    private function getPricefromLasttrans($barcode,$customercode){
      $query = "select computeramt,disc,uom,rem from(
                    select head.trno,head.dateid,stock.isamt as computeramt,stock.uom,stock.disc,stock.rem from lahead as head
                    left join lastock as stock on stock.trno = head.trno
                    where head.doc = 'SJ' and stock.barcode = '".$barcode."' and head.client = '".$customercode."'
                    and stock.isamt <> 0
                    UNION ALL
                    select head.trno,head.dateid,stock.isamt as computeramt,stock.uom,stock.disc,stock.rem from glhead as head
                    left join glstock as stock on stock.trno = head.trno
                    left join item on item.itemid = stock.itemid
                    left join client on client.clientid = head.clientid
                    where head.doc = 'SJ' and item.barcode = '".$barcode."' and client.client = '".$customercode."'
                    and stock.isamt <> 0) as tbl order by left(dateid,10) desc,trno desc limit 1";
                    
      $data = Yii::$app->sbccommon->opentable($query);
      return $data;
    }//end function

    public function getPricePerPriceGroup($barcode,$customercode){
      return $this->getPricefromItemtbl($barcode,$customercode);
    }//end fn

    private function getPricefromItemtbl($barcode,$customercode){
      $pricegroup = $this->requestCustomerPriceGroup($customercode);
      switch ($pricegroup) {
        case 'R': return Yii::$app->sbccommon->opentable("select amt as computeramt,disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'W': return Yii::$app->sbccommon->opentable("select amt2 as computeramt,disc2 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'A': return Yii::$app->sbccommon->opentable("select amt4 as computeramt,disc3 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'B': return Yii::$app->sbccommon->opentable("select famt as computeramt,disc4 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'C': return Yii::$app->sbccommon->opentable("select amt5 as computeramt,disc5 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'D': return Yii::$app->sbccommon->opentable("select amt6 as computeramt,disc6 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'E': return Yii::$app->sbccommon->opentable("select amt7 as computeramt,disc7 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'F': return Yii::$app->sbccommon->opentable("select amt8 as computeramt,disc8 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'G': return Yii::$app->sbccommon->opentable("select amt9 as computeramt,disc9 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'H': return Yii::$app->sbccommon->opentable("select amt10 as computeramt,disc10 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'I': return Yii::$app->sbccommon->opentable("select amt11 as computeramt,disc11 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'J': return Yii::$app->sbccommon->opentable("select amt12 as computeramt,disc12 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'K': return Yii::$app->sbccommon->opentable("select amt13 as computeramt,disc13 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'L': return Yii::$app->sbccommon->opentable("select amt14 as computeramt,disc14 as disc from item where barcode ='".$barcode."' limit 1"); break;
        case 'M': return Yii::$app->sbccommon->opentable("select amt15 as computeramt,disc15 as disc from item where barcode ='".$barcode."' limit 1"); break;
        default: return Yii::$app->sbccommon->opentable("select amt as computeramt,disc from item where barcode ='".$barcode."' limit 1"); break;
      }//END SWITCH
    }//END GETPRICE xxxxxFROM ITEMTBL

    private function getItemPricePerPriceGrp($barcode,$pricegrp){
      switch ($pricegrp) {
        case 'R':
          return Yii::$app->sbccommon->opentable("select amt as computeramt,disc from item where barcode ='".$barcode."' limit 1");
          break;
        
        case 'W':
          return Yii::$app->sbccommon->opentable("select amt2 as computeramt,disc2 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'A':
          return Yii::$app->sbccommon->opentable("select amt4 as computeramt,disc3 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'B':
          return Yii::$app->sbccommon->opentable("select famt as computeramt,disc4 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'C':
          return Yii::$app->sbccommon->opentable("select amt5 as computeramt,disc5 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'D':
          return Yii::$app->sbccommon->opentable("select amt6 as computeramt,disc6 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'E':
          return Yii::$app->sbccommon->opentable("select amt7 as computeramt,disc7 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'F':
          return Yii::$app->sbccommon->opentable("select amt8 as computeramt,disc8 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'G':
          return Yii::$app->sbccommon->opentable("select amt9 as computeramt,disc9 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'H':
          return Yii::$app->sbccommon->opentable("select amt10 as computeramt,disc10 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'I':
          return Yii::$app->sbccommon->opentable("select amt11 as computeramt,disc11 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'J':
          return Yii::$app->sbccommon->opentable("select amt12 as computeramt,disc12 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'K':
          return Yii::$app->sbccommon->opentable("select amt13 as computeramt,disc13 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'L':
          return Yii::$app->sbccommon->opentable("select amt14 as computeramt,disc14 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        case 'M':
          return Yii::$app->sbccommon->opentable("select amt15 as computeramt,disc15 as disc from item where barcode ='".$barcode."' limit 1");
          break;

        default:
          return Yii::$app->sbccommon->opentable("select amt as computeramt,disc from item where barcode ='".$barcode."' limit 1");
          break;
    }//END SWITCH

    }//END GETPRICE xxxxxFROM ITEMTBL

    //#BOSS DIRECT ITEM QUERY
    private function getItemPrice($doc,$barcode,$customercode){
      //TODO : ADD QUERY FOR POSTED TRANSACTIONS 
      $query='';
      switch ($doc) {
        case 'SJ': case 'SO': case 'CM': case 'TS': case 'PD':
          //GET PRICE FROM ITEM                
              $iteminfo = $this->getPricefromItemtbl($barcode,$customercode);
              $data[0]['computeramt'] = $iteminfo[0]['computeramt'];
              $data[0]['uom'] = "";
              $data[0]['disc'] = $iteminfo[0]['disc'];
              $data[0]['rem'] = "";

           return $data;
           break;
        case 'RR': case 'PO': case 'AJ': case 'PC': case 'IS': case 'PR': case 'DM': case 'PI': case 'PK':
                $data[0]['computeramt'] = "0.00";
                $data[0]['uom'] = "";
                $data[0]['disc'] = "";
                $data[0]['rem'] = "";
            return $data;
            break;
          
        default:
          return $data = "";
          break;
      }//end switch
    }//end getcustomerlatestprice



//############################################## NORMALIZE DATA FOR MODEL INSERTION (PER MODULE)

  public function checkHeadRequiredData($doc,$datafield){
    switch ($doc) {
      case 'SO': case 'SJ': case 'DM': case 'PO': case 'RR': case 'CM': case 'PR': 
      case 'IS': case 'AJ': case 'TS': case 'PC': case 'AP': case 'PV': case 'CV':
      case 'AR': case 'CR': case 'GJ': case 'KR':
      case 'MX': case 'MI': case 'pscheme':
        if(isset($datafield['dateid']) && isset($datafield['client']) && isset($datafield['clientname'])){
          if(empty($datafield['dateid']) || empty($datafield['client']) || empty($datafield['clientname'])){
            return false;
          }else{
            return true;
          }//end if
        }else{
          return false;
        }//end if
        break;
      
      case 'DS':
        if(isset($datafield['dateid'])){
          if(empty($datafield['dateid'])){
            return false;
          }else{
            return true;
          }//end if
        }else{
          return false;
        }//end if
      break;

      default:
        return true;
        break;
    }//end switch case
  }//end function 

  public function normalizeStockdata($doc,$dataobj,$moduledata,$controller){
    $doc = $controller->module->id;
    if(isset($moduledata['isamt'])) { $moduledata['isamt'] = str_replace(',','',$moduledata['isamt']); }
    if(isset($moduledata['isqty'])) { $moduledata['isqty'] = str_replace(',','',$moduledata['isqty']); }
    if(isset($moduledata['rrcost'])) { $moduledata['rrcost'] = str_replace(',','',$moduledata['rrcost']); }
    if(isset($moduledata['cost'])) { $moduledata['cost'] = str_replace(',','',$moduledata['cost']); }
    if(isset($moduledata['amt'])) { $moduledata['amt'] = str_replace(',','',$moduledata['amt']); }
    if(isset($moduledata['rrqty'])) { $moduledata['rrqty'] = str_replace(',','',$moduledata['rrqty']); }
    if(isset($moduledata['db'])) { $moduledata['db'] = str_replace(',','',$moduledata['db']); }
    if(isset($moduledata['cr'])) { $moduledata['cr'] = str_replace(',','',$moduledata['cr']); }
    if(isset($moduledata['ext'])) { $moduledata['ext'] = str_replace(',','',$moduledata['ext']); }

    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'KINGGEORGE':
        if(isset($moduledata['kgs'])) { $moduledata['kgs'] = str_replace(',','',$moduledata['kgs']); }
      break;
    }//END SWITCH

    $dataobj->trno = $moduledata['trno'];

    if ($doc == 'TW'){

    } elseif ($doc == 'tpshipping' || $doc == 'tphandling'){
      $dataobj->docno = $moduledata['docno'];
    } else {  
      $dataobj->barcode = $moduledata['barcode'];
      $dataobj->itemname = $moduledata['itemname'];
    } 

    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'TENPLUS':
        switch ($doc) {
          case 'SJ':
            $dataobj->itemcomm = $moduledata['itemcomm'];
            $dataobj->itemhandling = $moduledata['itemhandling'];
          break;

          default:
            $dataobj->itemcomm = '';
            $dataobj->itemhandling = '';
          break;
        }//end switch
      break;
      
      default:
        $dataobj->itemcomm = '';
        $dataobj->itemhandling = '';
      break;
    }//END SWITCH

    
    switch ($doc) {
      case 'PO': case 'SO': case 'QA': case 'pscheme': case 'PS':
        $dataobj->void = 0; 
        break;
      default:
        $dataobj->void = 0; 
      break;
    }
    
    if ($doc == 'TW'){
      $dataobj->acno = $moduledata['acno'];
      $dataobj->acnoname = $moduledata['acnoname'];
      $dataobj->rate = $moduledata['rate'];
      $dataobj->income = $moduledata['income'];
      $dataobj->wheld = $moduledata['wheld'];  
    }//end switc

    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'NEWTIANLE':
            $dataobj->iscomponent = 0;
            $dataobj->outputid = 0;
            switch ($doc) {
              case 'SJ': case 'AJ': case 'SO': case 'QA': case 'pscheme': case 'PS':
                $uomstring = explode('~', $moduledata['uom']);
                $dataobj->uom = $uomstring[0];
                break;
              
              default:
                $dataobj->uom = $moduledata['uom'];
                break;
            }//end switch case
        break;

        case 'PANDATOOLS':
            switch ($doc) {
              case 'SJ': 
                $dataobj->iscomponent = 0;
                $dataobj->outputid = 0;
                $dataobj->uom = $moduledata['uom'];
              break;

              default:
                $dataobj->iscomponent = 0;
                $dataobj->outputid = 0;
                $dataobj->uom = $moduledata['uom'];
              break;
            }  
        break;
      
      default:
          switch ($doc) {

            case 'tpshipping': case 'tphandling':
                $dataobj->iscomponent = 0;
                $dataobj->outputid = 0;
            break;

            //WTODO: [KIM][2019.11.29][add case for quotation]
            case 'quotation':
                $dataobj->iscomponent = 0;
                $dataobj->outputid = 0;
            break;
            
            default:
                $dataobj->iscomponent = 0;
                $dataobj->outputid = 0;
                $dataobj->uom = $moduledata['uom'];
              break;
          }//end switch
        break;
    }//end switch 

    switch ($doc) {
      case 'SJ':
        switch (Yii::$app->systemsettings->companyConfig()) {
          case 'UNIVERSE':
            if(isset($moduledata['agent'])){
              $dataobj->agent = $moduledata['agent'];
            }else{
              $dataobj->agent ='';
            }//end if
            break;
        }//end switch
        break;
    }//end switch

    switch ($doc) {
      case 'tpshipping':       
        $dataobj->line = $moduledata['line'];
        $dataobj->customer_name = $moduledata['clientname'];
        $dataobj->customer_code = $moduledata['client'];
        $dataobj->agent = $moduledata['agent'];
        $dataobj->shipfee = $moduledata['shipfee'];   
        if(isset($moduledata['cutoff'])){
          $dataobj->cutoff = $moduledata['cutoff'];   
        }else{
          $dataobj->cutoff = '';   
        }//end if
      break;


      case 'tphandling':
        $dataobj->line = $moduledata['line'];
        $dataobj->customer_name = $moduledata['clientname'];
        $dataobj->customer_code = $moduledata['client'];
        $dataobj->agent = $moduledata['agent'];
        $dataobj->handlingfee = $moduledata['handlingfee'];   
        if(isset($moduledata['cutoff'])){
          $dataobj->cutoff = $moduledata['cutoff'];   
        }else{
          $dataobj->cutoff = '';   
        }//end if
      break;

      case 'SP':
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $dataobj->loc='';
                $dataobj->wh_ = 'WH0000000000001';
                $dataobj->whname = ''; 
                $dataobj->line = $moduledata['line'];
                $dataobj->uomfactor = $moduledata['uomfactor'];
                $dataobj->ext = $moduledata['ext'];
              break;
        }////end switch
      break; //SP


      //WTODO: [KIM][2019.11.27][quote]
      case 'quotation':
        if(isset($moduledata['wh'])) {
          $dataobj->whname = $moduledata['wh']; 
        }else{ 
          $dataobj->whname = '';
        }//END FIF

        $dataobj->line = $moduledata['line'];
        $dataobj->uomfactor = $moduledata['uomfactor'];
        $dataobj->ext = '';
        $dataobj->loc=$moduledata['loc'];
      break;

      default:
        $dataobj->wh_ = $moduledata['whcode'];
        if(isset($moduledata['wh'])) {
          $dataobj->whname = $moduledata['wh']; 
        }else{ 
          $dataobj->whname = '';
        }//END FIF
        $dataobj->line = $moduledata['line'];
        $dataobj->uomfactor = $moduledata['uomfactor'];
        $dataobj->ext = $moduledata['ext'];
        $dataobj->loc=$moduledata['loc'];
      break;
    }//end switch

    
    if($doc == "TS"){
      if($moduledata['loc2'] == ""){
        $dataobj->loc2=$moduledata['loc'];
      }else{
        $dataobj->loc2=$moduledata['loc2'];
      }//end if $dataobj->loc=$moduledata['loc2'];
    }//end loc 2

    switch ($doc) {
      case 'tpshipping': case 'tphandling':
          $dataobj->line = $moduledata['line'];
      break;

       //WTODO: [KIM][2019.11.29][add case for quotation]
      case 'quotation':
        $dataobj->disc = 0;
        $dataobj->rem = "";
      break;
      
      default:
        $dataobj->disc = $moduledata['disc'];
        $dataobj->rem = $moduledata['rem'];
      break;
    }//end switch

    //added dataobj for msako,tsako
    if($doc == "RR"){
      switch (Yii::$app->systemsettings->companyConfig()) {
        case 'CANUMAY':
          if(isset($moduledata['msako'])){
            if($moduledata['msako'] == ''){
              $dataobj->msako= 0;
            }else{
              $dataobj->msako = $moduledata['msako'];
            }//end if
          }else{
            $dataobj->msako= 0;
          }//end if

          if(isset($moduledata['tsako'])){
            if($moduledata['tsako'] == ''){
              $dataobj->tsako = 0;
            }else{
              $dataobj->tsako = $moduledata['tsako'];
            }//end if
          }else{
            $dataobj->tsako = 0;
          }//end if
        break;

        default:
          $dataobj->tsako = 0;
          $dataobj->msako= 0;
        break;
      }//end switch case
    }//end RR

    //TODO EXPIRYJAOSKI
    switch ($doc) {
      case 'PO': case 'PR': case 'PI':
          $dataobj->expiry='1900-01-01';
      break;
      
      case 'tpshipping': case 'tphandling':
          $dataobj->line = $moduledata['line'];
      break;

      case 'SP':

      break;

      default:
        if($moduledata['expiry'] == ""){
          $dataobj->expiry = "";
        }else{
          $dataobj->expiry=$moduledata['expiry'];
        }//end if
      break;
    }//end switch

    switch ($doc) {
      case 'MX': case 'RR': case 'SJ': case 'DM': case 'CM': case 'PO': case 'PI': case 'SJ2':{
         $dataobj->refx = $moduledata['refx'];
         $dataobj->linex = $moduledata['linex'];
         $dataobj->ref = $moduledata['ref'];
        break;
      }
    }//end switch

    switch ($doc) {
      case 'QA': case 'MX': case 'MI': case 'SO': case 'SJ': case 'DM':  case 'TS': case 'SJ2': case 'pscheme': case 'PS': case 'JB':
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
              switch ($doc) {
                case 'SJ': case 'DM': case 'TS':
                  $dataobj->kgs = $moduledata['kgs'];
                break;
                
                default:
                  $dataobj->kgs = 0.00;
                break;
              }//END SWITCH
            break;

            default:
              $dataobj->kgs = 0.00;
            break;
        }//end switch

        //NEED TO FIND HOW TO GET COMPUTED QTY AND AMT
        if($doc == 'SJ2'){
          $dataobj->isqty2 = $moduledata['isqty2'];
          $dataobj->iss2 = $moduledata['iss2'];  
        }

        // JAOPOGI
        if ($doc == 'TS'){
        $dataobj->ref = $moduledata['ref'];
        $dataobj->refx = $moduledata['refx'];
        $dataobj->linex = $moduledata['linex'];  
        }
        // END POGI

        $dataobj->isqty = $moduledata['isqty'];
        $dataobj->iss = $moduledata['iss'];
        $dataobj->isamt = $moduledata['isamt'];
        $dataobj->amt = $moduledata['amt'];
        $dataobj->rrqty = 0;
        $dataobj->rrcost = 0;
        $dataobj->cost = 0;
        $dataobj->qty = 0;
      break;

        
      //WTODO: [KIM][2019.11.27][add case for quotation]
      case 'quotation':
        $dataobj->kgs = 0.00;
        // $dataobj->isqty = "";
        $dataobj->isqty = $moduledata['isqty'];  
        $dataobj->iss = $moduledata['iss']; 
        $dataobj->isamt = $moduledata['isamt']; 
        $dataobj->amt = $moduledata['amt']; 
        $dataobj->rrqty = ""; 
        $dataobj->rrcost = ""; 
        $dataobj->cost = ""; 
        $dataobj->qty = ""; 
        //WTODO: [KIM][2019.11.28][add item]
        $dataobj->item = $moduledata['item'];
      break;
      
      case 'CM':
        $dataobj->rrqty = $moduledata['rrqty'];
        $dataobj->qty = $moduledata['qty'];
        $dataobj->isamt = $moduledata['isamt'];
        $dataobj->amt = $moduledata['amt'];
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
              $dataobj->kgs = $moduledata['kgs'];
            break;

            default:
              $dataobj->kgs = 0.00;
            break;
        }//end switch

        if(isset($moduledata['cost'])){
        $dataobj->cost = $moduledata['cost'];
        }else{
          $dataobj->cost = 0;
        }//end if

        $dataobj->cost = $moduledata['cost'];
        $dataobj->isqty = 0;
        $dataobj->iss = 0;
        $dataobj->rrcost = 0;   
      break;  
      
      case 'PO': case 'RR': case 'PR': case 'PC': case 'PI': case 'SP': case 'TR':
        //NEED TO FIND HOW TO GET COMPUTED QTY AND AMT
        /*if($doc == "PO"){
          $dataobj->ref = $moduledata['ref'];
        }*/
        $dataobj->rrqty = $moduledata['rrqty'];

        $dataobj->qty = $moduledata['qty'];
        $dataobj->rrcost = $moduledata['rrcost'];
        $dataobj->cost = $moduledata['cost'];
        $dataobj->isqty = 0;
        $dataobj->iss = 0;
        $dataobj->isamt = 0;
        $dataobj->amt = 0;

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
              switch ($doc) {
                case 'RR':
                  $dataobj->kgs = $moduledata['kgs'];
                break;
                
                default:
                  $dataobj->kgs = 0.00;
                break;
              }//END SWITCH
            break;

            default:
              $dataobj->kgs = 0.00;
            break;
        }//end switch

      break;        

      case 'IS':
        //$dataobj->disc = 0;
        $dataobj->rrqty = $moduledata['rrqty'];
        $dataobj->qty = $moduledata['qty'];
        $dataobj->rrcost = $moduledata['rrcost'];
        $dataobj->cost = $moduledata['cost'];
        $dataobj->isqty = 0;
        $dataobj->iss = 0;
        $dataobj->isamt = 0;
        $dataobj->amt = 0;
        $dataobj->qa = 0;
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
              $dataobj->kgs = $moduledata['kgs'];
            break;

            default:
              $dataobj->kgs = 0.00;
            break;
        }//end switch
      break;

      case 'AJ':
        $dataobj->rrqty = $moduledata['rrqty'];
        $dataobj->qty = $moduledata['qty'];
        $dataobj->rrcost = $moduledata['rrcost'];
        $dataobj->cost = $moduledata['cost'];
        $dataobj->isqty = 0;  
        $dataobj->iss = $moduledata['iss'];
        $dataobj->isamt = 0;
        $dataobj->amt = 0;
        $dataobj->qa = 0;   

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
              $dataobj->kgs = $moduledata['kgs'];
            break;

            default:
              $dataobj->kgs = 0.00;
            break;
        }//end switch  
      break; 

      case 'PK':
        $dataobj->rrqty = $moduledata['rrqty'];
        $dataobj->qty = $moduledata['qty'];
        $dataobj->rrcost = $moduledata['rrcost'];
        $dataobj->cost = $moduledata['cost'];
        $dataobj->isqty = 0;  
        $dataobj->iss = $moduledata['iss'];
        $dataobj->isamt = 0;
        $dataobj->amt = 0;
        $dataobj->qa = 0;    
        $dataobj->ref = $moduledata['ref']; 
        $dataobj->refx = $moduledata['refx'];
        $dataobj->linex = $moduledata['linex'];
      break; 
    }//END SWITCH
  }//END NORMALIZE STOCK DATA


  public function searchRequiredcoa($controller,$access) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      return $data = $this->requiredcoasearch();
    }
  }


  public function requiredcoasearch() {
    $qry = "select 'IS' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='IS'
      union all
      select 'IN' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='IN'
      union all
      select 'AR' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='AR'
      union all
      select 'AP' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='AP'
      union all
      select 'CA' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CA'
      union all
      select 'CR' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CR'
      union all
      select 'CB' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CB'
      union all
      select 'TX' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='TX'
      union all
      select 'SA' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='SA'
      union all
      select 'SD' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='SD'
      union all
      select 'SR' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='SR'
      union all
      select 'CG' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='CG'
      union all
      select 'PR' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='PR'
      union all
      select 'PD' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='PD'
      union all
      select 'WT' as alias,'---' as type,'---' as acno,'---' as acnoname
      union all
      select alias as alias,cat as type,acno,acnoname from coa where left(alias,2)='WT'";
    return $qry;
  }


  public function normalizeHeaddata($dataobj,$moduledata,$controller){
    try {
      $doc = $controller->module->id;
      
      if ($doc =='pscheme') {
        $doc='PS';
      }//end if


      if ($doc =='quotation') {
        $doc='QT';
      }//end if

      switch (Yii::$app->systemsettings->companyConfig()) {
        case 'MLCP':
          switch($doc){
            case 'SJ':
              if($moduledata['freightcharge'] != ""){
                $dataobj->mlcp_freight = $moduledata['freightcharge'];
              }else{
                $dataobj->mlcp_freight = 0;
              }//end if
            break;
          }//end switch
        break;
        
        default:
          switch($doc){
            case 'SJ':
              $dataobj->mlcp_freight = 0;
            break;
          }//end switch
        break;
      }//end swithc

      switch (Yii::$app->systemsettings->companyConfig()) {
          case 'PANDATOOLS':
                  switch ($doc) {
                    case 'SJ':
                      if($moduledata['waybilldate'] != ""){
                            $dataobj->waybilldate = $moduledata['waybilldate'];    
                          }else{
                            $dataobj->waybilldate = '0000-00-00';
                          }//HIHIHI

                      $dataobj->voyage = $moduledata['voyage'];    
                      $dataobj->billlading = $moduledata['billlading'];
                    break;
                  }//end switch
          break;

        default:
          switch ($doc) {
            case 'SJ': case 'MI': case 'MX':
              $dataobj->waybilldate = '0000-00-00';
              $dataobj->voyage = '';    
              $dataobj->billlading = '';
            break;
          }//end switch
        break;
      }//end switch            
        
      switch ($doc) {
        case 'agent':
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $dataobj->agentpassword = $moduledata['pass'];
              break;
              default:
              $dataobj->agentpassword ='';
              break;
          }//end funct
        break;
      }//end f

      switch($doc) {
        case 'branch':
          $dataobj->clientid = $moduledata['clientid'];
          $dataobj->client = $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          $dataobj->addr = $moduledata['addr'];
          $dataobj->tin = $moduledata['tin'];
          $dataobj->rem = $moduledata['rem'];
          $dataobj->tel = $moduledata['tel'];
          $dataobj->tel2 = $moduledata['mobile'];
          $dataobj->fax = $moduledata['fax'];
          $dataobj->email = $moduledata['email'];
          $dataobj->contact = $moduledata['contact'];
          $dataobj->acno = $moduledata['acno'];
          $dataobj->isallitems = $moduledata['isallitems'];
          $dataobj->isallwh = $moduledata['isallwh'];
          $dataobj->issyncbranch = $moduledata['issyncbranch'];
          $dataobj->isLocation = 0;
          $dataobj->isVendor = 0;
          $dataobj->isasset = 0;
          $dataobj->distributionarea = 0;
          $dataobj->collectionarea = 0;
          $dataobj->routeid = 0;
          $dataobj->sccityid = 0;
          $dataobj->IsInactive = 0;
          $dataobj->IsCustomer = 0;
          $dataobj->IsAgent = 0;
          $dataobj->IsSupplier = 0;
          $dataobj->IsWarehouse = 0;
          $dataobj->IsEmployee = 0;
          $dataobj->IsBranch = 1;
          $dataobj->IsExempt = 0;
          $dataobj->charge1 = 0;
          $dataobj->charge2 = 0;
          $dataobj->crlimit = 0;
          $dataobj->category = 0;
        break;

        case 'warehouse': case 'customer': case 'supplier': case 'agent':

        switch ($doc) {
          case 'agent':
            switch (Yii::$app->systemsettings->companyConfig()) {
              case 'UNIVERSE':
                  $dataobj->agentpassword = $moduledata['pass'];
                break;
                default:
                $dataobj->agentpassword ='';
                break;
            }//end switch
          break;
          
          default:
            $dataobj->agentpassword ='';
          break;
        }//end switch
        
          $dataobj->isLocation = 0;
          $dataobj->isVendor = 0;
          $dataobj->isasset = 0;
          $dataobj->IsBranch = 0;
          $dataobj->isallitems = 0;
          $dataobj->isallwh = 0;
          $dataobj->issyncbranch = 0;
          $dataobj->distributionarea = 0;
          $dataobj->collectionarea = 0;
          $dataobj->routeid = 0;
          $dataobj->sccityid = 0;
          // $dataobj->trno = $moduledata['trno'];
          $dataobj->clientid = $moduledata['clientid'];
          $dataobj->client = $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          $dataobj->addr = $moduledata['addr'];
          $dataobj->IsInactive = $moduledata['ishold'];
          $dataobj->IsCustomer = $moduledata['iscustomer'];
          $dataobj->IsAgent = $moduledata['isagent'];
          $dataobj->IsSupplier = $moduledata['issupplier'];
          $dataobj->IsWarehouse = $moduledata['iswarehouse'];
          $dataobj->IsEmployee = $moduledata['isemployee'];

          $dataobj->uv_ispicker = $moduledata['uv_ispicker'];
          $dataobj->uv_ischecker = $moduledata['uv_ischecker'];
          
          if(isset($moduledata['started'])){
            if($moduledata['started'] == ''){
              $dataobj->start = Yii::$app->systemsettings->getCurrentTimeStamp();
            }else{
              $started = $moduledata['started'];
              $dataobj->start = $started;
            }//end if
          }else{
            $started = Yii::$app->systemsettings->getCurrentTimeStamp();
            $dataobj->start = $started;
          }//end if

          if($doc != 'warehouse') { // customer - supplier - agent
            $dataobj->area = $moduledata['area'];
            $dataobj->province = $moduledata['province'];
            $dataobj->region = $moduledata['region'];
           
            if(!isset($moduledata['status'])){
              $dataobj->status = '';
            }else{
              $dataobj->status = $moduledata['status'];
            }//end if
            $dataobj->contact = $moduledata['contact'];
            $dataobj->tel = $moduledata['tel'];
            $dataobj->tel2 = $moduledata['tel2'];
            $dataobj->groupid = $moduledata['groupid'];
            $dataobj->fax = $moduledata['fax'];
            $dataobj->email = $moduledata['email'];
            $dataobj->tin = $moduledata['tin'];

            if($doc == 'customer') {
              $dataobj->IsExempt = $moduledata['isexempt'];
              $dataobj->grpcode = $moduledata['grpcode'];
              $dataobj->bstyle = $moduledata['bstyle'];
            } else {
              $dataobj->IsExempt = 0;
              $dataobj->charge1 = 0;
              $dataobj->charge2 = 0;
              $dataobj->crlimit = 0;
              $dataobj->category = 0;
              $dataobj->bstyle = '';
            }//end if

            if($doc == 'customer' || $doc == 'supplier') {
              if($doc == 'customer') { // customer
                if($moduledata['crlimit'] != "") { $dataobj->crlimit = $moduledata['crlimit']; } else { $dataobj->crlimit = '0.00'; }
                if($moduledata['charge1'] != "") { $dataobj->charge1 = $moduledata['charge1']; } else { $dataobj->charge1 = '0.00'; }
                if($moduledata['charge2'] != "") { $dataobj->charge2 = $moduledata['charge2']; } else { $dataobj->charge2 = '0.00'; }
                $agent = explode("~" ,$moduledata['agentcode']);
                $dataobj->agent = $agent[0];
                $dataobj->rev = $moduledata['rev'];
              } else { // supplier
                $dataobj->disc = $moduledata['disc'];
                $dataobj->type = $moduledata['type'];
                $dataobj->rem = $moduledata['rem'];
              }
              if($moduledata['categoryid'] != "") { $dataobj->category = $moduledata['categoryid']; } else { $dataobj->category = 0; }
              $dataobj->terms = $moduledata['terms'];
            }
            if($doc == 'customer' || $doc == 'agent') {
              if($doc == 'agent') { // agent
                $dataobj->rem = $moduledata['rem'];
                $dataobj->quota = $moduledata['quota'];
              }
              $dataobj->pricegroup = $moduledata['pricegroup'];
            }
          } else { // end not warehouse
            $dataobj->IsExempt = 0;
            $dataobj->charge1 = 0;
            $dataobj->charge2 = 0;
            $dataobj->crlimit = 0;
            $dataobj->category = 0;
          } // end warehouse
        break; // case warehouse, customer, supplier, agent

        case 'SP': 
        case 'QA': case 'MX': case 'PR': case 'PO': case 'RR': case 'DM': case 'SO': 
        case 'SJ': case 'CM': case 'MI': case 'PS': case 'QT':
          $dataobj->trno = $moduledata['trno'];
          $dataobj->docno = $moduledata['docno'];
          $dataobj->client = $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          
          if($doc != 'QT'){
            $dataobj->yourref = $moduledata['yourref'];
            $dataobj->ourref = $moduledata['ourref'];
          }//end if

          $dataobj->address = $moduledata['addr'];
          $dataobj->dateid = $moduledata['dateid'];
          
        
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'MEGASTEEL':
              if(isset($moduledata['arastre'])){
                if($moduledata['arastre'] == ''){
                  $dataobj->arastre = 0;
                }else{
                  $dataobj->arastre = $moduledata['arastre'];
                }//end f
              }else{
                $dataobj->arastre = 0;
              }//end

              if(isset($moduledata['freight'])){
                if($moduledata['freight'] == ''){
                  $dataobj->freight = 0;
                }else{
                  $dataobj->freight = $moduledata['freight'];
                }//end f
              }else{
                $dataobj->freight = 0;
              }//end

              if(isset($moduledata['wharffage'])){
                if($moduledata['wharffage'] == ''){
                  $dataobj->wharffage = 0;
                }else{
                  $dataobj->wharffage = $moduledata['wharffage'];
                }//end f
              }else{
                $dataobj->wharffage = 0;
              }//end
            break;
          }//end switch

          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'GAMELINE_POS':
              if($doc == 'RR'){
                $dataobj->purchasetype = $moduledata['purchasetype'];
              }else{
                $dataobj->purchasetype = '';
              }//end if
            break;

            default:          
              if($doc == 'RR'){
                $dataobj->purchasetype = '';
              }//end if
            break;
          }//end switch

          switch ($doc) { 
              case 'SP':
                $dataobj->effectivedate=$moduledata['effectdate'];
                $dataobj->due = '1900-01-01';
                break;
          }//end switch

          if(!empty($moduledata['warehouse'])) {
            $whdata = explode("~" ,$moduledata['warehouse']);
            $dataobj->wh = $whdata[0];
            $dataobj->whid = $whdata[1];
          } else {
            $dataobj->wh = '';
            $dataobj->whid = 0;
          }//end if

          $dataobj->rem = $moduledata['rem'];

          if($doc != 'MI' && $doc !='MX' && $doc !='QT'){
            $dataobj->terms = $moduledata['terms'];
          }//end if

          if($doc == 'SO'){
            $dataobj->rtype = $moduledata['rtype'];
            $dataobj->rdate = $moduledata['rdate'];
          }//end if

          switch($doc) {
            case 'MI': case 'MX': case 'PO': case 'RR': case 'DM': case 'SO': case 'SJ': 
            case 'CM': case 'QA': case 'pscheme': case 'PS':

              if($doc != 'MI' && $doc !='MX'){
                $dataobj->forex = $moduledata['forex'];
              }//end if

              switch($doc) {
                case 'PO': case 'RR': case 'DM':
                  $dataobj->cur = $moduledata['cur'];
                break;
                default:
                  $dataobj->cur = "";
                break;
              }//END SWTICH

              switch($doc) {
                case 'DM': case 'CM':
                  $dataobj->due = '1900-01-01';
                  
                  if($doc == 'DM'){
                    $dataobj->tax = $moduledata['tax'];
                    $dataobj->sjtrno = '';
                  }else{
                    switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'CANUMAY':
                        $dataobj->sjtrno = $moduledata['sjtrno']; 
                      break;

                      default:
                        $dataobj->sjtrno = '';
                      break;
                    }//end switch
                    $dataobj->tax = 0;
                  }//end if

                  if(!empty($moduledata['contra'])) {
                    $contradata = explode("~" ,$moduledata['contra']);
                    $dataobj->contra = $contradata[0];
                  }else{
                    $dataobj->contra = '';
                  }//ennd if


                  if($doc=='DM' || $doc=='CM'){
                    $dataobj->shipto= $moduledata['shipto'];
                  }//end if

                  if($doc=='DM' || $doc=='CM'){
                    $dataobj->shipto= $moduledata['shipto'];
                  }//end if

                  if($doc == 'CM'){
                    $dataobj->transtype = $moduledata['transtype'];
                  }//end if
                break; // DM, CM

                case 'QA': case 'MX': case 'PO': case 'RR': case 'SO': case 'SJ': case 'MI': case 'pscheme': case 'PS':
                  switch($doc) {
                    case 'PO': case 'SO': case 'QA': case 'pscheme': case 'PS':
                      $dataobj->tax = 0;
                      if($doc == 'SO') { $dataobj->shipto = $moduledata['shipto']; }
                      if($doc == 'QA') { $dataobj->shipto = $moduledata['shipto']; }
                      if($doc == 'pscheme') { $dataobj->shipto = $moduledata['shipto']; }
                    break; // PO, SO

                    default:
                      switch($doc) {
                        case 'RR': case 'SJ':
                          $dataobj->vattype = $moduledata['vattype'];
                        break;
                      }

                      if($doc != 'MI' && $doc !='MX'){
                        $dataobj->shipto = $moduledata['shipto'];
                        $dataobj->tax = $moduledata['tax'];
                      }//end if
                      
                      if(!empty($moduledata['contra'])) {
                        $contradata = explode("~" ,$moduledata['contra']);
                        $dataobj->contra = $contradata[0];
                      } else {
                        $dataobj->contra = '';
                      }
                    break; // RR, SJ
                  }//END SWITCH

                  $dataobj->salestype = $moduledata['salestype'];
                  
                  if($doc == 'SJ') {
                    $dataobj->checkno = $moduledata['checkno'];
                  }//END IF
                  
                  if(!empty($moduledata['due'])) { $dataobj->due = $moduledata['due']; } else { $dataobj->due = '1900-01-01'; }

                  switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                      switch ($doc) {
                        case 'SO':
                          $dataobj->transtype = $moduledata['transtype'];
                          $dataobj->amountreceived = $moduledata['amtrec'];
                        break;

                        case 'SJ':
                          $dataobj->transtype = $moduledata['transtype'];
                          $dataobj->amountreceived = $moduledata['amtrec'];  
                        break;
                        
                        default:
                          $dataobj->transtype = '';
                          $dataobj->amountreceived = '';  
                        break;
                      }// END
                    break;
                    
                    case 'MLCP':
                      switch ($doc) {
                        case 'SJ':
                          $dataobj->transtype = $moduledata['transtype'];
                          $dataobj->amountreceived = '';  
                        break;
                        
                        default:
                          $dataobj->transtype = '';
                          $dataobj->amountreceived = '';  
                        break;
                      }// END
                    break;

                    default:
                      $dataobj->transtype = '';
                      $dataobj->amountreceived = '';
                    break;
                  }//END SWITCH
                  
                  switch($doc) {
                    case 'SO': case 'SJ': case 'MX': case 'MI': case 'QA': case 'pscheme': case 'PS':
                      if(!empty($moduledata['agentcode'])) {
                        $agentdata = explode("~", $moduledata['agentcode']);
                        $dataobj->agent = $agentdata[0];
                        $dataobj->agentcode = $agentdata[1];
                      }//end if

                      if(!empty($moduledata['picker'])){
                        $pickerdata = explode("~", $moduledata['picker']);
                        $dataobj->picker = $pickerdata[0];
                        $dataobj->pickername = $pickerdata[1];
                      }//end if

                      if(!empty($moduledata['checkeragent'])){
                        $checkerdata = explode("~", $moduledata['checkeragent']);
                        $dataobj->checkeragent = $checkerdata[0];
                        $dataobj->checkername = $checkerdata[1];
                      }//end if

                      if(!empty($moduledata['pickcode'])) {
                        $pickdata = explode("~", $moduledata['pickcode']);
                        $dataobj->pickcode = $pickdata[0];
                        $dataobj->pickname = $pickdata[1];
                      }//end if

                      if(!empty($moduledata['checkcode'])) {
                        $checkdata = explode("~", $moduledata['checkcode']);
                        $dataobj->checkcode = $checkdata[0];
                        $dataobj->checkname = $checkdata[1];
                      }//end if
                    break; // SO, SJ
                  }
                break; // PO, RR, SO, SJ
              }
            break; // PO, RR, DM, SO, SJ, CM
          }
        break; // case PR, PO, RR, DM, SO, SJ, CM

        case 'IS': case 'PC': case 'TS': case 'AJ': case 'TR':
          $dataobj->trno = $moduledata['trno'];
          $dataobj->docno = $moduledata['docno'];
          $dataobj->dateid = $moduledata['dateid'];
          $dataobj->address = $moduledata['addr'];
          $dataobj->ourref = $moduledata['ourref'];
          $dataobj->rem = $moduledata['rem'];
          $dataobj->due = '1900-01-01';
          if($doc != 'PC') {$dataobj->yourref = $moduledata['yourref'];}
          $dataobj->client = $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          switch($doc) {
            case 'IS': case 'AJ':
              if(!empty($moduledata['contra'])) {
                $contradata = explode("~", $moduledata['contra']);
                $dataobj->contra = $contradata[0];
              } else {
                $dataobj->contra = '';
              }
            break; // IS, AJ
            case 'TS': case 'TR':
              switch (Yii::$app->systemsettings->companyConfig()) {
                case 'SOUTHCENTRAL':
                  if($moduledata['agentcode'] != '') {
                    $agentdata = explode("~", $moduledata['agentcode']);
                    $dataobj->agent = $agentdata[0];
                    $dataobj->agentcode = $agentdata[1];
                  } else {
                    $dataobj->agent = '';
                    $dataobj->agentcode = 0;
                  }
                  if($moduledata['pricegrp'] == '') { $dataobj->pricegrp = ''; } else { $dataobj->pricegrp = $moduledata['pricegrp']; }
                  if($moduledata['routeid'] == '') {
                    $dataobj->routeid = 0;
                  } else {
                      $dataobj->routeid = $moduledata['routeid'];
                  }//end if
                  $dataobj->route = $moduledata['route'];
                break; // case SOUTHCENTRAL
                default:
                  $dataobj->route = '';
                  $dataobj->routeid = 0;
                break; // DEFAULT
              }
              if($moduledata['warehouse'] != "") {
                $whdata = explode("~", $moduledata['warehouse']);
                $dataobj->wh = $whdata[0];
                $dataobj->whid = $whdata[1];
              } else {
                $dataobj->wh = 0;
                $dataobj->whid = '';
              }
              $dataobj->client = $moduledata['client'];
              $dataobj->clientname = $moduledata['clientname'];
            break; // TS, TR
          }
        break; // case IS, PC, TS, AJ, TR

        case 'SV':
          $dataobj->trno = $moduledata['trno'];
          $dataobj->docno = $moduledata['docno'];
          $dataobj->client =  $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          $dataobj->dateid = $moduledata['dateid'];
          $dataobj->yourref = $moduledata['yourref'];
          $dataobj->ourref = $moduledata['ourref'];
          $dataobj->address = $moduledata['addr'];
          $dataobj->rem = $moduledata['rem'];
          $dataobj->due = $moduledata['due'];
          $dataobj->terms = $moduledata['terms'];
          $dataobj->forex = $moduledata['forex'];
          $dataobj->shipto = $moduledata['shipto'];
          $dataobj->tax = $moduledata['tax'];
          $dataobj->vattype = $moduledata['vattype'];
          $dataobj->cur = $moduledata['cur'];
          
          if(!empty($moduledata['contra'])) {
            $contradata = explode("~", $moduledata['contra']);
            $dataobj->contra = $contradata[0];
          } else {
            $dataobj->contra = '';
          }//END IF

          $dataobj->invoiceno = $moduledata['invoiceno'];
          $dataobj->invoicedate = $moduledata['invoicedateid'];

          if(!empty($moduledata['warehouse'])) {
            $whdata = explode("~" ,$moduledata['warehouse']);
            $dataobj->wh = $whdata[0];
            $dataobj->whid = $whdata[1];
          } else {
            $dataobj->wh = '';
            $dataobj->whid = 0;
          }//end if


        break;

        case 'AP': case 'PV': case 'CV': case 'AR': case 'CR': case 'KR':
          $dataobj->trno = $moduledata['trno'];
          $dataobj->docno = $moduledata['docno'];
          $dataobj->client =  $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          $dataobj->dateid = $moduledata['dateid'];
          $dataobj->yourref = $moduledata['yourref'];
          $dataobj->ourref = $moduledata['ourref'];
          $dataobj->address = $moduledata['addr'];
          $dataobj->rem = $moduledata['rem'];
          $dataobj->due = '1900-01-01';
          
          switch ($doc) {
            case 'PV':
              $dataobj->ewt = $moduledata['ewthead'];
              $dataobj->ewtrate = $moduledata['ewtratehead'];
            break;
            
            default:
              $dataobj->ewt = '';
              $dataobj->ewtrate = 0;
            break;
          }//end switch

          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
              switch ($doc) {
                case 'AR':
                  $dataobj->terms = $moduledata['terms'];
                  if(!empty($moduledata['agentcode'])) {
                    $agentdata = explode("~", $moduledata['agentcode']);
                    $dataobj->agent = $agentdata[1];
                    $dataobj->agentcode = $agentdata[0];
                  }//end if
                break;
              }//END SWITCH
            break;
          }//END SWITCH

          switch($doc) {
            case 'AP': case 'PV': case 'CV':
              $cdetails = explode('~', $moduledata['costcenter']);
              $dataobj->costcenter = $cdetails[0];
            break;
            case 'KR':
              $dataobj->shipto = $moduledata['shipto'];
            break;
          }
        break; // AP, PV, CV, AR, CR, KR

        case 'JB':
          $dataobj->trno = $moduledata['trno'];
          $dataobj->docno = $moduledata['docno'];
          $dataobj->client =  $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          $dataobj->dateid = $moduledata['dateid'];
          $dataobj->due = $moduledata['dateid'];
          $dataobj->reqdate = $moduledata['reqdate'];
          $dataobj->yourref = $moduledata['yourref'];
          $dataobj->ourref = $moduledata['ourref'];
          $dataobj->shipto= $moduledata['shipto'];
          //$dataobj->transtype = $moduledata['transtype'];
          //$head->salestype = $salestype;
          $dataobj->trnxtype = $moduledata['trnxtype'];
          $dataobj->salestype = $moduledata['salestype'];
          $dataobj->pricetype = $moduledata['pricetype'];
          
          $dataobj->rem = $moduledata['rem'];
          if(!empty($moduledata['warehouse'])) {
            $whdata = explode("~" ,$moduledata['warehouse']);
            $dataobj->wh = $whdata[0];
            $dataobj->whid = $whdata[1];
          } else {
            $dataobj->wh = '';
            $dataobj->whid = 0;
          }//end if
        break;

        //TW KEYWORD
        //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD normalize
        case 'TW':
          $dataobj->trno = $moduledata['trno'];
          $dataobj->docno = $moduledata['docno'];
          $dataobj->client = $moduledata['client'];
          $dataobj->clientname = $moduledata['clientname'];
          $dataobj->address = $moduledata['addr'];
          $dataobj->dateid = $moduledata['dateid'];
          $dataobj->dateid2 = $moduledata['dateid2'];
          $dataobj->quarter = intval($moduledata['viewbyquarter']);
        break;

        case 'GJ': case 'DS':
          $dataobj->trno = $moduledata['trno'];
          $dataobj->docno = $moduledata['docno'];
          $dataobj->yourref = $moduledata['yourref'];
          $dataobj->ourref = $moduledata['ourref'];
          $dataobj->dateid = $moduledata['dateid'];
          $dataobj->rem = $moduledata['rem'];
          $dataobj->due = '1900-01-01';
          switch($doc) {
            case 'GJ':
              $dataobj->client = $moduledata['client'];
              $dataobj->clientname = $moduledata['clientname'];
              $dataobj->address = $moduledata['addr'];
              $cdetails = explode('~', $moduledata['costcenter']);
              $dataobj->costcenter = $cdetails[0];
              $dataobj->terms = $moduledata['terms'];
            break;
            case 'DS':
              if(!empty($moduledata['contra'])) {
                $contradata = explode("~" ,$moduledata['contra']);
                $dataobj->contra = $contradata[0];
              } else {
                $dataobj->contra = '';
              }
              $dataobj->clientname = $moduledata['bank'];
            break;
          }
        break;
      }
      return $dataobj;
    } catch (ErrorException $e) {
      echo $e;
    }
    
  }//END normalize head data

  public function checkDatabeforeSaving($openhead,$dataobj){
    if($openhead == "Lahead"){
          $dataobj->agent= !is_null($dataobj->agent) ?  $dataobj->agent : '';
          $dataobj->tax= !is_null($dataobj->tax) ?  $dataobj->tax : 0;
          $dataobj->shipto= !is_null($dataobj->shipto) ?  $dataobj->shipto : '';
    }

    $dataobj->wh= !is_null($dataobj->wh) ?  $dataobj->wh : '';
        $dataobj->terms= !is_null($dataobj->terms) ?  $dataobj->terms : '';
        $dataobj->yourref= !is_null($dataobj->yourref) ?  $dataobj->yourref : '';
        $dataobj->ourref= !is_null($dataobj->ourref) ?  $dataobj->ourref : '';
        $dataobj->terms= !is_null($dataobj->terms) ?  $dataobj->terms : '';
        $dataobj->forex= !is_null($dataobj->forex) ?  $dataobj->forex : 1;
        
    return $dataobj;
  }//END CHECK DATA BEFORE SAVING



   // WTODO JAD 06-03-2019
  public function getUsers2($administrator = false){
    if($administrator){
      $query ="select '' as userid,'' as accessid, '' as username,'' as name union all
      select userid,accessid,username,name from useraccess where administrator_pass <> ''";
    }else{
      $query ="select '' as userid,'' as accessid, '' as username,'' as name union all
      select userid,accessid,username,name from useraccess";
    }//end if void
    // $result = $data = Yii::$app->sbccommon->opentable($query);
    return $query;
  }

  public function searchContra2($controller,$access,$searchstring,$contratype) {
    if(Yii::$app->session['loggeduser']['access'][$access] != 1) {

    } else {
      if($contratype != '') {
        $qry = "select '' as acno , 0 as acnoid,'' as acnoname,'' as alias UNION ALL select acno,acnoid,acnoname,left(alias,2) as alias from coa where detail = 1 and acnoname like '%".$searchstring."%' and left(alias,2) = 'CB' or detail = 1 and acno like '%\\".$searchstring."%' and left(alias,2) = 'CB' order by acnoname LIMIT 50";
      } else {
        $qry = "select '' as acno , 0 as acnoid,'' as acnoname,'' as alias UNION ALL select acno,acnoid,acnoname,left(alias,2) as alias from coa where detail = 1 and acnoname like '%".$searchstring."%' or detail = 1 and acno like '%\\".$searchstring."%' order by acnoname LIMIT 50";
      }
      return $qry;
    }
  }

  public function getUsers($administrator = false){
    if($administrator){
      $query ="select '' as userid,'' as accessid, '' as username,'' as name union all
      select userid,accessid,username,name from useraccess where administrator_pass <> ''";
    }else{
      $query ="select '' as userid,'' as accessid, '' as username,'' as name union all
      select userid,accessid,username,name from useraccess";
    }//end if void
    $result = $data = Yii::$app->sbccommon->opentable($query);
    return $result;
  }



     public function openBankrecon($date1,$date2,$clearday,$acno){
        $sql= " 
        select sort,trno,line,brecon.type,docno,left(dateid,10) as dateid,brecon.acno,left(postdate,10) as postdate,db,cr,checkno,rem,acnoname,0.00 as bal,clientname,clearday from
        (select 'p' as `type`,1 as `sort`,`gldetail`.`trno` as `trno`,`gldetail`.`line` as `line`,left(ifnull(`gldetail`.`clearday`,''),10)  as `clearday`,
         `glhead`.`docno` as `docno`,`glhead`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`gldetail`.`postdate` as `postdate`,
         `gldetail`.`db` as `db`,`gldetail`.`cr` as `cr`, `gldetail`.`checkno` as `checkno`,`gldetail`.`rem` as `rem`,`client`.`client` as `client`,`glhead`.`clientname` as `clientname`
         from (((`glhead` left join `gldetail` on((`gldetail`.`trno` = `glhead`.`trno`))) left join `coa` on((`coa`.`acnoid` = `gldetail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `gldetail`.`clientid`)))  where (`glhead`.`doc` in ('ds','cv','cr','gj','ar','ap'))
         union all
         select 'p' as `type`,2 as `sort`,0 as `trno`,0 as `line`,left(ifnull(`brecon`.`dateid`,''),10) as `clearday`,'Recon' as `docno`,
        `brecon`.`dateid` as `dateid`,`brecon`.`acno` as `acno`,coa.acnoname,`brecon`.`dateid` as `postdate`,
        `brecon`.`bal` as `db`,0 as `cr`,'Recon' as `checkno`,concat('Recon-' , date_format(`brecon`.`dateid`,'%b %d %Y')) as `rem`,'' as `client`, '' as `clientname`
        from `brecon` left join coa on coa.acno = brecon.acno where (`brecon`.`line` <> 2)) as brecon
        where postdate between '$date1' and '$date2' and (clearday ='$clearday' or clearday ='') and acno='\\".$acno."'";

        $data = Yii::$app->sbccommon->openTable($sql);
        return $data;
     
    }

 public static function getfromBrecon($acno,$clearday,$field=''){
        $sql = "select ifnull($field,'') as $field from brecon where line=3 and acno='\\".$acno."' and dateid='$clearday'";
        $data = Yii::$app->sbccommon->datareader($sql);
       //Webproc::showmsg('a',$sql);
       return $data;
       
    }

    public static function getfromBrecon2($acno,$field=''){
        $sql = "Select ifnull($field,'') as $field from brecon where line=2 and acno='\\".$acno."'";

        $data = Yii::$app->sbccommon->datareader($sql);
       return $data;
    }

    public static function openDepwithdraw($date1,$date2,$clearday,$acno){

        $sql = "select sum(db) as dep,sum(cr) as withdraw from(
        select sort,trno,line,brecon.type,docno,left(dateid,10) as dateid,brecon.acno,left(postdate,10) as postdate,db,cr,checkno,rem,acnoname,0.00 as bal,clientname,clearday from
        (select 'p' as `type`,1 as `sort`,`gldetail`.`trno` as `trno`,`gldetail`.`line` as `line`,`gldetail`.`clearday` as `clearday`,
         `glhead`.`docno` as `docno`,`glhead`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`gldetail`.`postdate` as `postdate`,
         `gldetail`.`db` as `db`,`gldetail`.`cr` as `cr`, `gldetail`.`checkno` as `checkno`,`gldetail`.`rem` as `rem`,`client`.`client` as `client`,`glhead`.`clientname` as `clientname`
         from (((`glhead` left join `gldetail` on((`gldetail`.`trno` = `glhead`.`trno`))) left join `coa` on((`coa`.`acnoid` = `gldetail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `gldetail`.`clientid`)))  where (`glhead`.`doc` in ('ds','cv','cr','gj'))
         union all
         select 'p' as `type`,2 as `sort`,0 as `trno`,0 as `line`,`brecon`.`dateid` as `clearday`,'Recon' as `docno`,
        `brecon`.`dateid` as `dateid`,`brecon`.`acno` as `acno`,coa.acnoname,`brecon`.`dateid` as `postdate`,
        `brecon`.`bal` as `db`,0 as `cr`,'Recon' as `checkno`,concat('Recon-' , date_format(`brecon`.`dateid`,'%b %d %Y')) as `rem`,'' as `client`, '' as `clientname`
        from `brecon` left join coa on coa.acno = brecon.acno where (`brecon`.`line` <> 2)) as brecon
        ) as A where acno='\\".$acno."' and clearDay is not null and sort<>5 and ClearDay > '$date1' and ClearDay <= '$date2'";
        $data = Yii::$app->sbccommon->openTable($sql);
        return $data;
    }

       public static function openBankBookSummary($acno,$date1,$date2){

        $sql= "select left(dateid,10)as dateid, bal,adjust from brecon where acno='\\".$acno."' and dateid between '$date1' and '$date2' and line=3 order by dateid";
        return $data = Yii::$app->sbccommon->openTable($sql);
        
   }

     public static function openBankBook($date1,$date2,$acno,$filter,$mode,$searchby){
        $strfilter = '';
        switch (strtoupper($filter)){
          case "DATEID":
            $strfilter = "head.dateid";
            break;
          case "CHECKDATE":
            $strfilter = "detail.postdate";
            break;
          case "CLEARDAY":
            $strfilter = "detail.clearday";
            break;
        }

        $strsearch = '';
        if ($mode!=''){
        switch (strtoupper($mode)) {
          case 'CHECKNO':
            $strsearch = " and detail.checkno like '%".$searchby."%'";
            break;
          case 'CLIENTNAME':
            $strsearch = " and head.clientname like '%".$searchby."%'";
            break;
        }
      }

        $sql= " select 0 as sort,0 as trno,0 as line,0 as type,'Beggining Balance' as docno,'' as dateid,'' as acno,'' as postdate,0 as db,0 as cr,'' as checkno,'' as rem,'' as acnoname,ifnull(sum(db-cr),0) as bal,'' as clientname,'' as clearday from
        (
        select 'P' as `type`,1 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,`detail`.`clearday` as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,`detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname`  from (((`glhead` as head left join `gldetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acnoid` = `detail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `detail`.`clientid`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter." <'$date1' and detail.clearday is not null and coa.acno ='\\".$acno."'
        union all
        select 'P' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,`detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname` from (((`glhead` as head left join `gldetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acnoid` = `detail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `detail`.`clientid`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " . $strfilter . " <'$date1' and detail.clearday is null and coa.acno ='\\".$acno."'
        union all
        select 'U' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,`detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname` from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
         left join `client` on((`client`.`client` = `detail`.`client`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter. " <'$date1' and coa.acno ='\\".$acno."'
        union all
        select 'U' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,
         `detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname`
         from (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
         left join `client` on((`client`.`client` = `detail`.`client`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter. " <'$date1' and coa.acno ='\\".$acno."'
        union all
        select 'U' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,
         `detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname`
         from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
         left join `client` on((`client`.`client` = `detail`.`client`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter. " <'$date1' and coa.acno ='\\".$acno."'
         union all
         select 'P' as `type`,2 as `sort`,0 as `trno`,0 as `line`,`brecon`.`dateid` as `clearday`,'Recon' as `docno`,
        `brecon`.`dateid` as `dateid`,`brecon`.`acno` as `acno`,coa.acnoname,`brecon`.`dateid` as `postdate`,
        `brecon`.`bal` as `db`,0 as `cr`,'Recon' as `checkno`,concat('Recon-' , date_format(`brecon`.`dateid`,'%b %d %Y')) as `rem`,'' as `client`, '' as `clientname`
        from `brecon` left join coa on coa.acno = brecon.acno where (`brecon`.`line` <> 2) and brecon.dateid <'$date1' and coa.acno ='\\".$acno."'
        ) as brecon
        union all 
        select sort,trno,line,brecon.type,docno,left(dateid,10) as dateid,brecon.acno,left(postdate,10) as postdate,db,cr,checkno,rem,acnoname,0.00 as bal,clientname,clearday from
        (
        select 'P' as `type`,1 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,`detail`.`clearday` as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,`detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname`  from (((`glhead` as head left join `gldetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acnoid` = `detail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `detail`.`clientid`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter." between '$date1' and '$date2' and detail.clearday is not null and coa.acno ='\\".$acno."'". $strsearch ."
        union all
        select 'P' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,`detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname` from (((`glhead` as head left join `gldetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acnoid` = `detail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `detail`.`clientid`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " . $strfilter . " between '$date1' and '$date2' and detail.clearday is null and coa.acno ='\\".$acno."'". $strsearch ."
        union all
        select 'U' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,`detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname` from (((`lahead` as head left join `ladetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
         left join `client` on((`client`.`client` = `detail`.`client`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter. " between '$date1' and '$date2' and coa.acno ='\\".$acno."'". $strsearch ."
        union all
        select 'U' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,
         `detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname`
         from (((`lbhead` as head left join `lbdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
         left join `client` on((`client`.`client` = `detail`.`client`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter. " between '$date1' and '$date2' and coa.acno ='\\".$acno."'". $strsearch ."
        union all
        select 'U' as `type`,3 as `sort`,`detail`.`trno` as `trno`,`detail`.`line` as `line`,ifnull(`detail`.`clearday`,'') as `clearday`,`head`.`docno` as `docno`,`head`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`detail`.`postdate` as `postdate`,
         `detail`.`db` as `db`,`detail`.`cr` as `cr`, `detail`.`checkno` as `checkno`,`detail`.`rem` as `rem`,`client`.`client` as `client`,`head`.`clientname` as `clientname`
         from (((`lchead` as head left join `lcdetail` as detail on((`detail`.`trno` = `head`.`trno`))) left join `coa` on((`coa`.`acno` = `detail`.`acno`)))
         left join `client` on((`client`.`client` = `detail`.`client`)))  where (`head`.`doc` in ('ds','cv','cr','gj','ar','ap')) and " .$strfilter. " between '$date1' and '$date2' and coa.acno ='\\".$acno."'". $strsearch ."
         union all
         select 'P' as `type`,2 as `sort`,0 as `trno`,0 as `line`,`brecon`.`dateid` as `clearday`,'Recon' as `docno`,
        `brecon`.`dateid` as `dateid`,`brecon`.`acno` as `acno`,coa.acnoname,`brecon`.`dateid` as `postdate`,
        `brecon`.`bal` as `db`,0 as `cr`,'Recon' as `checkno`,concat('Recon-' , date_format(`brecon`.`dateid`,'%b %d %Y')) as `rem`,'' as `client`, '' as `clientname`
        from `brecon` left join coa on coa.acno = brecon.acno where (`brecon`.`line` <> 2) and brecon.dateid between '$date1' and '$date2' and coa.acno ='\\".$acno."'
        ) as brecon order by sort,postdate,dateid";
        $data = Yii::$app->sbccommon->openTable($sql);
        return $data;
    }

    public static function insertBRecon($acno,$dateid,$bal=0,$adjust=0,$mode='1'){
        if ($acno!=""){

        switch ($mode){
            case '1':
            break;
            case '2':
              return Yii::$app->sbccommon->execqry("insert into brecon(line,acno,bal,adjust)values('2','\\".$acno."',0,0)");
              break;
            case '3':
              Yii::$app->sbccommon->execqry("insert into brecon(line,dateid,acno,bal,adjust)values('$mode','$dateid','\\".$acno."',$bal,$adjust)");
              return Yii::$app->sbccommon->execqry("update brecon set dateid = '$dateid' where line =2 and acno = '\\".$acno."'");
            
            break;

            case '4':
              Yii::$app->sbccommon->execqry("update brecon set bal = $bal,adjust=$adjust where line = 3 and dateid = '$dateid' and acno = '\\".$acno."'");
              return Yii::$app->sbccommon->execqry("update brecon set dateid = '$dateid' where line =2 and acno = '\\".$acno."'");
            
            break;

            case '5':
              Yii::$app->sbccommon->execqry("update brecon set bal = $bal where line = 3 and dateid = '$dateid' and acno = '\\".$acno."'");
              return Yii::$app->sbccommon->execqry("update brecon set dateid = '$dateid' where line =2 and acno = '\\".$acno."'");
                                    
            break;

        }
      }
    }

    //jac breconclearing
public function clearbrecon($params,$cleardate){
       
       foreach ($params as $key => $value) {
          $this->updatecleardate($params[$key]['trno'],$params[$key]['line'],$cleardate);
        }//END FOR EACH
        
    }//END postpdc

public function updatecleardate($trno,$line,$cleardate){
    $qry = "update gldetail set clearday='$cleardate' where trno = $trno and line= $line and clearday is null";
    return $data = Yii::$app->sbccommon->execqry($qry);
}

public static function getBal($acno){

        $sql = "select sum(db)-sum(cr) as bal from(
        select sort,trno,line,brecon.type,docno,left(dateid,10) as dateid,brecon.acno,left(postdate,10) as postdate,db,cr,checkno,rem,acnoname,0.00 as bal,clientname,clearday from
        (select 'p' as `type`,1 as `sort`,`gldetail`.`trno` as `trno`,`gldetail`.`line` as `line`,`gldetail`.`clearday` as `clearday`,
         `glhead`.`docno` as `docno`,`glhead`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`gldetail`.`postdate` as `postdate`,
         `gldetail`.`db` as `db`,`gldetail`.`cr` as `cr`, `gldetail`.`checkno` as `checkno`,`gldetail`.`rem` as `rem`,`client`.`client` as `client`,`glhead`.`clientname` as `clientname`
         from (((`glhead` left join `gldetail` on((`gldetail`.`trno` = `glhead`.`trno`))) left join `coa` on((`coa`.`acnoid` = `gldetail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `gldetail`.`clientid`)))  where (`glhead`.`doc` in ('ds','cv','cr','gj'))
         union all
         select 'p' as `type`,2 as `sort`,0 as `trno`,0 as `line`,`brecon`.`dateid` as `clearday`,'Recon' as `docno`,
        `brecon`.`dateid` as `dateid`,`brecon`.`acno` as `acno`,coa.acnoname,`brecon`.`dateid` as `postdate`,
        `brecon`.`bal` as `db`,0 as `cr`,'Recon' as `checkno`,concat('Recon-' , date_format(`brecon`.`dateid`,'%b %d %Y')) as `rem`,'' as `client`, '' as `clientname`
        from `brecon` left join coa on coa.acno = brecon.acno where (`brecon`.`line` <> 2)) as brecon
        ) as A where acno='\\".$acno."' and clearDay is not null";
        $data = Yii::$app->sbccommon->datareader($sql);
        return $data;
    }

public static function getUnclear($acno,$date){

        $sql = "select sum(db)-sum(cr) as bal from(
        select sort,trno,line,brecon.type,docno,left(dateid,10) as dateid,brecon.acno,left(postdate,10) as postdate,db,cr,checkno,rem,acnoname,0.00 as bal,clientname,clearday from
        (select 'p' as `type`,1 as `sort`,`gldetail`.`trno` as `trno`,`gldetail`.`line` as `line`,`gldetail`.`clearday` as `clearday`,
         `glhead`.`docno` as `docno`,`glhead`.`dateid` as `dateid`,`coa`.`acno` as `acno`,coa.acnoname,`gldetail`.`postdate` as `postdate`,
         `gldetail`.`db` as `db`,`gldetail`.`cr` as `cr`, `gldetail`.`checkno` as `checkno`,`gldetail`.`rem` as `rem`,`client`.`client` as `client`,`glhead`.`clientname` as `clientname`
         from (((`glhead` left join `gldetail` on((`gldetail`.`trno` = `glhead`.`trno`))) left join `coa` on((`coa`.`acnoid` = `gldetail`.`acnoid`)))
         left join `client` on((`client`.`clientid` = `gldetail`.`clientid`)))  where (`glhead`.`doc` in ('ds','cv','cr','gj','ar','ap'))
         union all
         select 'p' as `type`,2 as `sort`,0 as `trno`,0 as `line`,`brecon`.`dateid` as `clearday`,'Recon' as `docno`,
        `brecon`.`dateid` as `dateid`,`brecon`.`acno` as `acno`,coa.acnoname,`brecon`.`dateid` as `postdate`,
        `brecon`.`bal` as `db`,0 as `cr`,'Recon' as `checkno`,concat('Recon-' , date_format(`brecon`.`dateid`,'%b %d %Y')) as `rem`,'' as `client`, '' as `clientname`
        from `brecon` left join coa on coa.acno = brecon.acno where (`brecon`.`line` <> 2)) as brecon
        ) as A where acno='\\".$acno."' and clearDay is null and postdate <='$date'";
        $data = Yii::$app->sbccommon->datareader($sql);
        return $data;
    }

//end brecon


//====================== ITEM PROFILE FMM ==================================
  private function finishedgoodsearch($searchthis) {
      /*sizeid,barcode,itemid,category,grp.stockgrp_name as groupid,
      itemname,uom,round(amt,2) as amt,brand,ifnull(cls.cl_name,'') as class,body,
      ifnull(part.part_name,'') as part,ifnull(model.model_name,'') as model,disc,
      round((amt * (REPLACE(disc,'%','')/100)),2) as netprice,uv_priority,ifnull(uv_principal.name,'') as uv_principal from item*/
      $sql = "select sizeid,barcode,itemid,category,grp.stockgrp_name as groupid, itemname, 
              uom, round(amt,2) as amt, brand, ifnull(cls.cl_name,'') as class, disc,body,
              ifnull(part.part_name,'') as part,ifnull(model.model_name,'') as model from item 
              left join item_class as cls on cls.cl_id=item.class 
              left join stockgrp_masterfile as grp on grp.stockgrp_id = item.groupid
              left join model_masterfile as model on model.model_id = item.model
              left join part_masterfile as part on part.part_id = item.part
              left join uv_principal on uv_principal.line = item.uv_principal";
      
      $keyword = explode(",", $searchthis);
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where fg_isfinishedgood = 1 and item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and fg_isfinishedgood = 1 and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or    
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or                                
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          } 
         return $sql . " " . $criteria . " order by item.itemname asc limit 1000";
    }
    
  private function itemSearchfa($searchthis){

    $sql = "select barcode,itemid,category,groupid,itemname,uom,itemprice from fasset as fa ";   

    $keyword = explode(",", $searchthis);
    //$sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item where ";    
    $criteria="";

    foreach($keyword as $key){
        if ($criteria == "") {
            $criteria = " where (
                                fa.itemname LIKE '%" . $key. "%' or
                                fa.barcode LIKE '%" . $key. "%' or
                                fa.brand LIKE '%" . $key. "%' or
                                fa.model LIKE '%" . $key. "%' or
                                fa.category LIKE '%" . $key. "%' or
                                fa.groupid LIKE '%" . $key. "%' or
                                fa.sizeid LIKE '%" . $key. "%')";
        } else {
            $criteria = $criteria . " and " . "(
                                fa.itemname LIKE '%" . $key. "%' or
                                fa.barcode LIKE '%" . $key. "%' or
                                fa.brand LIKE '%" . $key. "%' or
                                fa.model LIKE '%" . $key. "%' or
                                fa.category LIKE '%" . $key. "%' or
                                fa.groupid LIKE '%" . $key. "%' or                                    
                                fa.sizeid LIKE '%" . $key. "%')";
        }
    } 

    return $data = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by fa.itemname asc limit ". Yii::$app->systemsettings->querySearchLimit());
  }

  public function searchGeneralItem($controller,$access,$searchstring,$itemid){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      //IF VIEW ACCESS IS NOT AVAILABLE
    }else{

      return $data = $this->genItemSearch($searchstring,$itemid);

    }//END IF ELSE
  }//END SEARCH DOCUMENT  

  public function searchEmployee($controller,$access,$searchstring,$empid){
    if(Yii::$app->session['loggeduser']['access'][$access] != 1){
      //IF VIEW ACCESS IS NOT AVAILABLE
    }else{
      return $data = $this->getEmployee($searchstring,$empid);

    }//END IF ELSE
  }//END SEARCH DOCUMENT      
  
    private function genItemSearch($searchthis,$itemid){

      if($itemid==0){
          $sql = "select line as itemid,bcode,itemdesc,itembrand,itempart,itemuom as uom,itemshortname,itemgroup,itemcolor,itemmodel,itemclass,itemsize from generalitem as fa ";   
          $keyword = explode(",", $searchthis);
          $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where (
                                      fa.itemdesc LIKE '%" . $key. "%' or
                                      fa.bcode LIKE '%" . $key. "%' or
                                      fa.itembrand LIKE '%" . $key. "%' or
                                      fa.itemmodel LIKE '%" . $key. "%' or
                                      fa.itemcolor LIKE '%" . $key. "%' or
                                      fa.itemclass LIKE '%" . $key. "%' or
                                      fa.itemgroup LIKE '%" . $key. "%' or
                                      fa.itemsize LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and " . "(
                                      fa.itemdesc LIKE '%" . $key. "%' or
                                      fa.bcode LIKE '%" . $key. "%' or
                                      fa.itembrand LIKE '%" . $key. "%' or
                                      fa.itemmodel LIKE '%" . $key. "%' or
                                      fa.itemcolor LIKE '%" . $key. "%' or
                                      fa.itemclass LIKE '%" . $key. "%' or
                                      fa.itemgroup LIKE '%" . $key. "%' or                                    
                                      fa.itemsize LIKE '%" . $key. "%')";
              }
          } 

          return $data = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by fa.itemdesc asc limit ". Yii::$app->systemsettings->querySearchLimit());

      }else{

        $sql = "select line as itemid,bcode,itemdesc,itembrand,itempart,itemuom,itemshortname,itemgroup,itemcolor,itemmodel,itemclass,itemsize from generalitem as fa where fa.line='".$itemid."'";   

          return $data = Yii::$app->sbccommon->opentable($sql);
      }

  }

//EMPLOYEE
  private function getEmployee($searchthis,$empid){

    if($empid==0){
        $sql="select emp.empid,emp.empcode,concat(emp.emplast,', ',emp.empfirst,' ',emp.empmiddle) as empname,client.client as loccode,client.clientname as locname,empfirst,empmiddle,emplast from employee as emp left join client on client.client = emp.dept ";
        $keyword = explode(",", $searchthis);
        $criteria="";

        foreach($keyword as $key){
            if ($criteria == "") {
                $criteria = " where (
                                    emp.empcode LIKE '%" . $key. "%' or
                                    emp.emplast LIKE '%" . $key. "%' or
                                    emp.empfirst LIKE '%" . $key. "%' or
                                    emp.empmiddle LIKE '%" . $key. "%' or
                                    client.clientname LIKE '%" . $key. "%')";
            } else {
                $criteria = $criteria . " and " . "(
                                    emp.empcode LIKE '%" . $key. "%' or
                                    emp.emplast LIKE '%" . $key. "%' or
                                    emp.empfirst LIKE '%" . $key. "%' or                                  
                                    emp.empmiddle LIKE '%" . $key. "%' or
                                    client.clientname LIKE '%" . $key. "%')";
            }
        } 
        return $data = Yii::$app->sbccommon->opentable($sql . " " . $criteria . "  order by emp.emplast asc limit 50");

    }else{
      $sql="select empimg.picture,emp.empid,emp.empcode,concat(emp.emplast,', ',emp.empfirst,' ',emp.empmiddle) as empname,client.client as loccode,client.clientname as locname,emp.zipcode,emp.empid,emp.empcode,emp.emplast,emp.empfirst,emp.empmiddle,emp.address,emp.city,emp.country,emp.telno,emp.mobileno,
        emp.email,emp.citizenship,emp.religion,emp.status,emp.gender,emp.alias,emp.bday,emp.idbarcode,emp.tin,emp.sss,emp.hdmf,emp.phic,
        emp.bankacct,emp.atm,emp.paymode,emp.jobtitle,emp.jobcode,emp.jobdesc,date(emp.hired) as hired,date(emp.regular) as regular ,date(emp.resigned) as resigned,emp.division,emp.dept,
        emp.orgsection,emp.supervisor,emp.teu,emp.nodeps,emp.isactive,emp.classrate,emp.maidname,emp.isconfidential,emp.shiftcode,
        emp.ecola,emp.spclallow,emp.transpo,emp.mealallow,emp.sssdef,emp.philhdef,emp.pibigdef,emp.wtaxdef,emp.dyear,
        emp.chktin,emp.chksss,emp.chkphealth,emp.chkpibig,emp.lastbatch,emp.fullname,emp.provaddress,emp.age,emp.remarks,emp.emprate,
        emp.level,emp.iscba,emp.trans,emp.trans1,cont.contact1,cont.relation1,cont.addr1,cont.homeno1,cont.mobileno1,cont.officeno1,cont.ext1,
        cont.notes1,cont.contact2,cont.relation2,cont.addr2,cont.homeno2,cont.mobileno2,cont.officeno2,cont.ext2,cont.notes2
         from employee as emp left join client on client.client = emp.dept
           left join contacts as cont on cont.empcode=emp.empcode 
           left join empimages as empimg on empimg.codeid=emp.empid where emp.empid=".$empid;

      return $data = Yii::$app->sbccommon->opentable($sql);
    }
  }


//====================== END ITEM PROFILE ==================================

//TA
 
    public function insertSelectedfaitem($params){
        if(!empty($params) && isset($params)){          
          $ccode = $params['ccode'];
          $dateid = $params['dateid'];
          $rem = $params['rem'];
          $ref = $params['ref'];
          $fa = $params['params'];
          
          foreach ($fa as $key => $value){
           $data[$key] = $this->insertfaitemdata($ccode,$dateid,$rem,$ref,$fa[$key]['line']);
          }//END FOR EACH
        }      
         return $data;
    }//END RETRIEVESELECTED

    private function insertfaitemdata($ccode,$dateid,$rem,$ref,$line){

          $user=Yii::$app->session['loggeduser']['username'];
          $qry = "insert into trans_asset (itemid,barcode,itemname,employee,department,dcode,empcode,dateid,createdby,rem,empid,createdon,ref)
          select fa.itemid,fa.barcode,fa.itemname,concat(emp.emplast,', ',emp.empfirst,' ',emp.empmiddle) as employee,dept.clientname as deptname,emp.dept,emp.empcode,'".$dateid."','".$user."','".$rem."',emp.empid,now(),'".$ref."' from fasset as fa left join employee as emp on emp.empcode = '$ccode'
        left join client as dept on dept.client = emp.dept where fa.itemid = $line";

        $data = Yii::$app->sbccommon->execqry($qry);

       if ($data==1){
        
        $sql = "select ta.line,ta.itemid,ta.barcode,ta.itemname,ta.employee,ta.department,ta.dcode,ta.empcode,left(ta.dateid,10) as dateid,ta.createdby,
        ta.rem,ta.empid,ta.ref,fa.bcode,ta.createdon,fa.shortname from trans_asset as ta left join fasset as fa on fa.itemid =ta.itemid
        where ta.empcode ='".$ccode."' and ta.itemid = $line and ta.ref='$ref'";

        $datum= Yii::$app->sbccommon->opentable($sql);
        if (!empty($datum)){
          $empid= $datum[0]['empid'];
          $dept = $datum[0]['dcode'];
          $deptname = $datum[0]['department'];
          $employee = $datum[0]['employee'];
          Yii::$app->sbccommon->execqry("update fasset set dtetransfer='$dateid',empid=".$empid.",deptname ='$deptname',department='$dept',employee='$employee' where itemid = $line");  
        }      
        return $datum;
       }else{
        return $data;
       }
    }//end

  public function openTransasset($ref){
    $sql = "select 'U' as tr,ta.line,ta.itemid,ta.barcode,ta.itemname,ta.employee,ta.department,ta.dcode,ta.empcode,left(ta.dateid,10) as dateid,ta.createdby,
        ta.rem,ta.empid,ta.ref,fa.bcode,ta.createdon,fa.shortname from trans_asset as ta left join fasset as fa on fa.itemid =ta.itemid
        where ta.ref='$ref'
        union all
        select 'P' as tr,ta.line,ta.itemid,ta.barcode,ta.itemname,ta.employee,ta.department,ta.dcode,ta.empcode,left(ta.dateid,10) as dateid,ta.createdby,
        ta.rem,ta.empid,ta.ref,fa.bcode,ta.createdon,fa.shortname from htrans_asset as ta left join fasset as fa on fa.itemid =ta.itemid
        where ta.ref='$ref'";
        
        //return $sql;
        return Yii::$app->sbccommon->opentable($sql);
  }

  public function postFaitem($ref){
    $sql = "insert into htrans_asset select * from trans_asset
        where ref='$ref'";
        
        //return $sql;
        $transfer= Yii::$app->sbccommon->execqry($sql);

        if ($transfer ==1){
         return Yii::$app->sbccommon->execqry("delete from trans_asset where ref = '$ref'");
        }
  }
  // END TA


  
  public function computeTax($rate,$income){

    $computation = ($rate/100)*$income;

    return $computation;

  }

  // SC MODIFICATION

    public function comparemglines($controller,$data){

    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    $classdata = Yii::$app->sbccommon->openTable("select id,main_grp from maingrp where id = $line");

      if($classdata[0]['id'] == $data['line'] && $classdata[0]['main_grp'] == $data['line'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'classdata'=>$classdata);
  } 

  public function comparetglines($controller,$data){

    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    $classdata = Yii::$app->sbccommon->openTable("select t.mgid,t.id,m.main_grp,t.term_grp,t.terms from termgrp as t 
            left join maingrp as m on m.id=t.mgid where t.id = $line");

      if($classdata[0]['main_grp'] == $data['line'] && $classdata[0]['term_grp'] == $data['line'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'classdata'=>$classdata);
  } 

  public function comparecglines($controller,$data){
    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    $classdata = Yii::$app->sbccommon->openTable("select c.tgid,c.id,cat_grp,t.term_grp from catgrp as c
    left join termgrp as t on t.id=c.tgid where c.id = $line");

      if($classdata[0]['term_grp'] == $data['line'] && $classdata[0]['cat_grp'] == $data['line'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'classdata'=>$classdata);
   
  } 

    public function comparescglines($controller,$data){

    $doc = $controller->module->id;
    $line = $data['line'];
    $ischanged = 0;
    $classdata = Yii::$app->sbccommon->openTable("select sc.id,ifnull(scat_grp,'') as scat_grp,ifnull(cat_grp,'') as cat_grp from subcatgrp as sc
                left join catgrp as c on c.id=sc.cgid where sc.id = $line");

      if($classdata[0]['cat_grp'] == $data['line'] && $classdata[0]['scat_grp'] == $data['line'] ){
                $ischanged = 0;
              }else{
                  $ischanged = 1;
              }//END IF

      return array('ischanged' => $ischanged,'classdata'=>$classdata);
  }


  // SC END 

  // SC MODIFICATION

    public function getMaingroup(){
        $qry = "select id,main_grp from maingrp order by main_grp asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

     public function getTermgroup(){
        $qry = "select id,term_grp from termgrp order by term_grp asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    public function getCatgroup(){
        $qry = "select id,cat_grp from catgrp order by cat_grp asc";
         return $data = Yii::$app->sbccommon->opentable($qry);
    }//end

    // SC END


    // XANDABELS

        public function gettotalCBM($trno){

            $data = Yii::$app->sbccommon->opentable("
                    select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                    from sostock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno
                    UNION ALL 
                    select stock.trno,stock.barcode,stock.isqty,uom.cbm,uom.kilos
                    from hsostock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno");

             $totalcbm = 0;

             foreach ($data as $itmindex => $itmdata) {
                $totalcbm += floatval($itmdata['isqty']) * floatval($itmdata['cbm']);
             }//end for each
            
             return $totalcbm;
        
        } // end fucntion


        public function gettotalTonnage($trno){

            $data2 = Yii::$app->sbccommon->opentable("select stock.trno,stock.barcode,
                    stock.isqty,uom.cbm,uom.kilos
                    from sostock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno
                    UNION ALL
                    select stock.trno,stock.barcode,
                    stock.isqty,uom.cbm,uom.kilos
                    from hsostock as stock
                    left join item on item.barcode=stock.barcode
                    left join uom on uom.itemid=item.itemid and uom.uom=stock.uom
                    where trno=$trno");
            
             $totaltonnage=0;

             foreach ($data2 as $itmindex => $itemton) {
                $totaltonnage += ((floatval($itemton['isqty']) * floatval($itemton['kilos'])) / 1000);
             }//end for each
             
             return $totaltonnage;
        
        } // end fucntion

    // END XANDA
        
    private function branchSearch($searchthis) {
      if($searchthis != '') {
        return $data = "select clientid, clientname, client, addr, contact, tel, 'branch' as type from client
          where (clientname like '".$searchthis."' and isbranch = 1)
          or (client like '".$searchthis."' and isbranch = 1)
          or (addr like '".$searchthis."' and isbranch = 1)
          or (tel like '".$searchthis."' and isbranch = 1) order by clientname LIMIT 50";
      } else {
        return $data = "select clientid, clientname, client, addr, contact, tel, 'branch' as type from client
          where isbranch = 1 order by clientname LIMIT 50";
      }
    }//end fs

    public function searchSonote($controller,$access,$str) {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {  } else { return $data = $this->sonoteSearch($str); }
    }//end nf
    
    public function sonoteSearch($str) {
        return "select station,serialno,rem,others,line from sbc_so_notes where trno = ".$str."";
    }//end fn

    public function searchcommdata($controller,$access,$str) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {  } else { return $data = $this->commdataSearch($str); }
    }//end if

    public function commdataSearch($str) {
      return "select line,agenttbl.clientname as agentname,sj_comm.agent,
        round(grandtotal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal,
        round(baseamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as baseamt,
        concat(standardpercent,'%') as standardpercent,
        round(standardamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardamt,
        concat(standardsharepercent,'%') as standardsharepercent,
        round(standardshareamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardshareamt,cutoffdate  from sj_comm
        left join client as agenttbl on agenttbl.client = sj_comm.agent
        where sj_comm.trno = ".$str."";
    }//end if

    public function searchClientactnotes($controller,$access,$clientid) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) { } else { return "select line,actnote,dateid,user from c_actnotes where clientid = ".$clientid.""; }
    }//end fn


    public function searchPrincipals($controller,$access,$x){
        $qry = "select line,code,name from uv_principal where code like '%".$x."%' or name like '%".$x."%' order by line";
        return $qry;
    }//end fn

    // WTODO JAD 06-03-2019
    public function retrieveVoucherRelease($params,$type){
      if($type == 'vr') {
        $id = $_POST['id'];
        $stat = $_POST['stat'];
        $date = $_POST['date'];
        $filter='';
        if($id != '') { $filter = 'and ms.userid="'.$id.'"'; }
        if($stat != '') {
          if($stat == 'nya') {
              $filter = $filter.' and ms.approvedate = ""';
          } elseif($stat == 'app') {
              $filter = $filter.' and ms.approvedate <> ""';
          }
        }//end if
        if($date!='') { $filter=$filter.' and ms.date1 <= "'.$date.'"'; }//end if
      } else {
        $from = $params['from'];
        $to = $params['to'];
        $id = Yii::$app->session['loggeduser']['userid'];
        $filter = 'and ms.date1 >= "'.$from.'" and ms.date1 <= "'.$to.'" and ms.userid = "'.$id.'"';
        $app = $params['app'];
        if($app == 'approved') {
          $filter.= " and ms.apvdoc <> ''";
        } else {
          $filter.= " and ms.apvdoc = ''";
        }//end if
      }
      return 'select ms.sched_seq,ms.sched_id,ms.userid,ms.sched_desc,ms.date1,ms.date2,ms.isplotted,ms.sched_type,
              ms.clientid,cl.clientname,ms.amt,ua.name as username,
              ms.approvedby,ms.approvedate,ms.cutdate,ms.apvdoc
              from member_schedule as ms
              left join useraccess as ua on ua.userid=ms.userid
              left join client as cl on cl.clientid=ms.clientid where ua.supplier <> "" and ms.amt <> 0 and event_tagging = "FINISHED" 
              and ms.acctg_approvedate<>""'.$filter;
    }//end fn

    // WTODO JAD 06-03-2019
    public function retrieveVoucherChecking($params,$type){
      if($type == 'vc') {
        $id = $_POST['id'];
        $stat = $_POST['stat'];
        $date = $_POST['date'];
        $filter = '';
        if($id != '') { $filter='and ms.userid="'.$id.'"'; }
        if($stat != '') {
          if($stat == 'nya') {
              $filter = $filter.' and ms.acctg_approvedate =""';
          } elseif($stat == 'app') {
              $filter = $filter.' and ms.acctg_approvedate <>""';
          }
        }//end if
        if($date != '') { $filter = $filter.' and ms.date1 <= "'.$date.'"'; }
      } else {
        $from = $params['from'];
        $to = $params['to'];
        $id = Yii::$app->session['loggeduser']['userid'];
        $filter = 'and ms.date1 >= "'.$from.'" and ms.date1 <= "'.$to.'" and ms.userid = "'.$id.'"';
        $app = $params['app'];
        if($app == 'approved'){
          $filter.=" and ms.apvdoc = ''";
        }
      }
      return 'select ms.jonumber,ms.sched_seq,ms.sched_id,ms.userid,ms.sched_desc,ms.date1,ms.date2,ms.isplotted,ms.sched_type,
              ms.clientid,cl.clientname,ms.amt,ua.name as username,
              ms.approvedby,ms.approvedate,ms.cutdate,ms.apvdoc
              from member_schedule as ms
              left join useraccess as ua on ua.userid=ms.userid
              left join client as cl on cl.clientid=ms.clientid where ua.supplier <> "" and ms.amt <> 0 and event_tagging = "FINISHED" and ms.approvedate = ""'.$filter;
    }//end fn

     public function retrieveVoucherReleaseTotal($params,$type){
      if($type == 'vr') {
        $id = $_POST['id'];
        $stat = $_POST['stat'];
        $date = $_POST['date'];
        $filter = '';
        if($id!='') { $filter = 'and ms.userid="'.$id.'"'; }
        if($stat != '') {
          if($stat == 'nya') {
              $filter = $filter.' and ms.approvedate = ""';
          } elseif($stat =='app') {
              $filter = $filter.' and ms.approvedate <> ""';
          }
        }//end if
        if($date != '') { $filter = $filter.' and ms.date1 <= "'.$date.'"'; }//end if
      } else {
        $from = $params['from'];
        $to = $params['to'];
        $id = Yii::$app->session['loggeduser']['userid'];
        $filter = 'and ms.date1 >= "'.$from.'" and ms.date1 <= "'.$to.'" and ms.userid = "'.$id.'"';
        $app = $params['app'];
        if($app == 'approved') {
          $filter.= " and ms.apvdoc <> ''";
        } else {
          $filter.= " and ms.apvdoc = ''";
        }//end if
      }
      $qry =  'select sum(amt) as amt from (
                select ms.sched_seq,ms.sched_id,ms.userid,ms.sched_desc,ms.date1,ms.date2,ms.isplotted,ms.sched_type,
                ms.clientid,cl.clientname,ms.amt,ua.name as username,
                ms.approvedby,ms.approvedate,ms.cutdate,ms.apvdoc
                from member_schedule as ms
                left join useraccess as ua on ua.userid=ms.userid
                left join client as cl on cl.clientid=ms.clientid where ua.supplier <> "" and ms.amt <> 0 and event_tagging = "FINISHED" '.$filter .
                ") as tbl";
      return Yii::$app->sbccommon->datareader($qry);
    }//end fn

    // WTODO JAD 06-03-2019
    public function approvevr($get) {
      try {
        $errors = 0;
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
        $filterevents = '';
        foreach ($get['params'] as $key => $value) {
          if($filterevents == '') {
            $filterevents .= "'".$value['id']."'";
          } else {
            $filterevents .= ','."'".$value['id']."'";
          }//end if
        }//end for each
        $qrygetscheds = "select sched_id,userid from member_schedule as scheds
                      where scheds.sched_id in (".$filterevents.")
                      order by scheds.userid,date1";
        $scheddata = Yii::$app->sbccommon->opentable($qrygetscheds);
        foreach($scheddata as $key => $value) {
          $schedtoloop[$value['userid']][] = $value['sched_id'];
        }//end for each
        foreach($schedtoloop as $key => $value) { //create automater of document head
          $params['userid'] = $key;
          $datahead = Yii::$app->automator->createDocumentHead('VR',$params);
          if($datahead['status']) {
            $params2['trno'] = $datahead['trno'];
            $params2['filter'] = '';
            foreach($value as $key2 => $value2) {
              if($params2['filter'] == '') {
                $params2['filter'] .= "'".$value2."'";
              } else {
                $params2['filter'] .= ",'".$value2."'";
              }//end if
            }//end for each
            $datadetails = Yii::$app->automator->createDocumentDetail('VR',$params2);  
            Yii::$app->automator->automateTransactionPosting($datahead['trno'],'PV');
          } else {
            $errors += 1;  
          }//end if
        }//end for each

        if($errors == 0) {
          $msg = 'Success';
          $status = true;
          $apvsql = "update member_schedule set apvdoc='".$datahead['docno']."' where sched_id in (".$filterevents.")";
          $qrystatusapv = Yii::$app->sbccommon->execqry($apvsql);
          $sql = "update member_schedule 
                set approvedby='".Yii::$app->session['loggeduser']['username']."',approvedate='".$current_timestamp."' 
                where sched_id in (".$filterevents.")";
          $qrystatus = Yii::$app->sbccommon->execqry($sql);
        } else {
          $msg = 'Error encountered while approving selected Reimbursements.';
          $status = false;
          foreach($get['params'] as $key => $value) { //dapat ma revert ung selected reimbursements
            $qryupdaterevert = "update member_schedule set approvedby='',approvedate='',apvdoc='' where sched_id='".$value['id']."'";
            Yii::$app->sbccommon->execqry($qryupdaterevert);
          }//end 
        }//end function
        return ['status'=>$status,'msg'=>$msg];
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end function

    public function approvevc($get){
      try {
        $errors = 0;
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
        $filterevents = '';
        foreach($get['params'] as $key => $value) { //generates report filter for another query (for getting list of users)
          if($filterevents == '') {
            $filterevents.="'".$value['id']."'";
          } else {
            $filterevents.=','."'".$value['id']."'";
          }//end if
        }//end for each
        $sql = "update member_schedule set acctg_approvedate='".$current_timestamp."' where sched_id in (".$filterevents.")";
         $qrystatus = Yii::$app->sbccommon->execqry($sql);
         if($qrystatus){
          $status =true;
          $msg = 'Success!';
        } else {
          $status = false;
          $msg = 'Error!';
        }
        return ['status'=>$status,'msg'=>$msg];
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end function

     public function loadUser($controller,$access) {
      if(Yii::$app->session['loggeduser']['access'][$access] != 1) {
      } else {
        return $qry="select '' as userid,'' as username,'' as name union all select userid,username,name from useraccess";
      }
    }//end fn

    // WTODO JAD 06-03-2019
    public function searchEventproject($controller,$access,$searchstring){
      return $data = $this->eventprojectSearch($searchstring);
    }//end fn
    
    private function eventprojectSearch($searchthis){
      return "select projectid,project_title, project_description, status,createdate from sched_projects 
            where (project_description like '%".$searchthis."%' or project_title like '%".$searchthis."%' or status like '%".$searchthis."%')
            order by projectid";
    }//end fn
}//END COMPONENTS
?>
