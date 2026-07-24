<?php

namespace backend\modules\TX\controllers;


use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use app\models\Cntnum;
use yii\base\ErrorException;

class DefaultController extends Controller{
//TODO: MAKE THIS CONTROLLER ACCESS AVAIALABLE ON JAVASCRIPT TO BE USED ON EVENTS
//THESE ACCESS ARRAY IS USED TO DETERMINE ACCESS INDEX ON ATTRIBUTES
    public $access = array(
        'view' => 152 ,'edit' => 153,'new' => 154,
        'save' => 155,'change' => 156,'delete' => 157,
        'print' => 158,'lock' => 159,'unlock' => 160,
        'changeamount' => 161,'crlimit'=>162,'post' => 163,'unpost' => 164,
        'clickadditem'=>805,'clickedititem'=>806,'clickdeleteitem'=>807);
    
    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }


    public function actionIndex(){
      $return=Yii::$app->sbccontroller->sbcindex($this);        
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          return $this->render('index',array('moduledata' => $return['moduledata'],'moduleid'=>$return['moduleid']));
        }
    }//END ACTION INDEX

    public function actionNewdocument(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNewdocument($this,$params);                
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          echo json_encode(array('moduledata' => $return['data']));
        }        
    }//END NEW DOCUMENT

    public function actionSavehead(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavehead($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
          'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted']));
        }                               
    }
  
    public function actionRetrievedocnolist(){
        Yii::$app->backend->AjaxVerification($this);
        $searchthis = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');
        $qry = "select transnum.trno,transnum.docno,head.clientname,head.client,head.dateid,
                transnum.postdate,transnum.postedby,head.yourref,head.ourref from transnum
                left join hrfhead as head on head.trno = transnum.trno
                left join client on client.client = head.client
                where transnum.doc = 'RF' and transnum.postdate is not null and transnum.center = '".Yii::$app->session['loggeduser']['center']."'
                and transnum.txdocno = '' and (transnum.docno like '%".$searchthis."%' 
                or head.clientname like '%".$searchthis."%' 
                or head.yourref like '%".$searchthis."%' or head.ourref like '%".$searchthis."%') order by docno LIMIT 50";
      $searchitems = Yii::$app->sbccommon->openTable($qry);

      echo json_encode(['searchitems'=>$searchitems]);
    }//end aciton

    public function actionRetrieverfdetails(){
        Yii::$app->backend->AjaxVerification($this);
        $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');

        $qry = "select head.docno,head.trno,head.client as agentcode,head.clientname as agentname,
                head.yourref as approvalcode,head.route,head.routeid from hrfhead as head where head.trno = ".$trno."";
        $rfdata = Yii::$app->sbccommon->openTable($qry);

        echo json_encode(['rfdata'=>$rfdata]);
    }//end action

    //LOADS LAST DOCUMENT
   public function actionLoadlastdoc(){
        Yii::$app->backend->AjaxVerification($this);
        $return=Yii::$app->sbccontroller->sbcLoadlastdoc($this);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('moduledata' => $return['data']));
        }                                       
   }//END ACTION CANCEL

   //THIS FUNCTION IS USED WHEN DIRECTLY LOOKING FOR DOCNO [WITHOUT THE USE OF LOOKUP BUTTON]
    public function actionSearchdocno(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcSearchdocno($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        }                                       
    }//END SEARCH DOCNO


    //FOR LOADING DATA FROM NAV BUTTONS
    public function actionNavbuttons(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNavbuttons($this,$params);                
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          echo json_encode(array('moduledata' => $return['data']));
        }
    }//END ACTION NAVBUTTONS

    public function actionGeneratetxsj(){
        try {
        Yii::$app->backend->AjaxVerification($this); 
        //TODO: PLEASE CREATE VALIDATION OF INVOICED = 1 , SO IT CANT CREATE DOUBLE ENTRY INVOICES
        $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $generatelist = Yii::$app->automator->automateHeadCredential($this->module->id,$trno);
        $status = true;
        $msg = "Successfully created SJ Transactions using this TX!<br><i><b>Please double check generated transactions.</b></i>";
        foreach ($generatelist as $key => $value) {
            
            $params = ['dateid'=>$value['dateid'],'customercode'=>$value['customercode'],'customername'=>$value['customername'],
            'addr'=>$value['address'],'agentcode'=>$value['agentcode'],'whcode'=>$value['wh'],
            'whname'=>$value['whname'],'sodocno'=>$value['sdocno'],'terms'=>$value['terms']];
            
            $return = Yii::$app->automator->automateHeadGeneration('SJ','SJ',$params);
            if($return['status']){
                $addparams = ['termgrp'=>$value['termgrp'],'sotrno'=>$value['sotrno']];
                $generate_stocklist = Yii::$app->automator->automateStockCredential($this->module->id,$trno,$addparams);
                $line = 0;
                $headtrno = $return['trno'];

                foreach ($generate_stocklist as $stock_key => $stock_value) {
                    $line += 1;
                    $stockparams = ['barcode'=>$stock_value['barcode'],'itemname'=>$stock_value['itemname'],'uom'=>$stock_value['uom'],'whcode'=>$stock_value['wh'],
                                    'isamt'=>$stock_value['isamt'],'amt'=>$stock_value['amt'],'iss'=>$stock_value['iss'],'isqty'=>$stock_value['isqty'],
                                    'ext'=>$stock_value['ext'],'refx'=>$stock_value['refx'],'linex'=>$stock_value['linex'],'ref'=>$stock_value['ref'],
                                    'loc'=>$stock_value['loc'],'expiry'=>$stock_value['expiry'],'disc'=>$stock_value['disc']];
                    
                    Yii::$app->automator->automateStockGeneration('SJ',$headtrno,$line,$stockparams);
                    
                    $qrycntnumupdate = "update cntnum set txno = ".$trno." where trno = ".$headtrno."";
                    $updatetxhead = "update txhead set invoiced = 1 where trno = ".$trno."";

                    Yii::$app->sbccommon->execqry($qrycntnumupdate);
                    Yii::$app->sbccommon->execqry($updatetxhead);
                }//end for each
                 $status = true;
            }else{
                $status = false;
            }//end if

            if($status){
                $msg = "Successfully created SJ Transactions using this TX!<br><i><b>Please double check generated transactions.</b></i>";
            }else{
                $msg = "An error occured while creating transaction using this TX. Please try again.";
            }//end if
        }//end for each
        echo json_encode(['status'=>$status,'msg'=>$msg]);
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end function


    public function actionRetrievetaggedinvoices(){
    try {
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $qry = "select ourref,trno,docno,dateid,custcode,custname,addr,gtotal,rem from (
                select head.ourref,head.trno,head.docno,left(head.dateid,10) as dateid,head.client as custcode,head.clientname as custname,
                client.addr,round(sum(ifnull(stock.ext,0)),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as gtotal,head.rem from lahead as head
                left join lastock as stock on stock.trno = head.trno
                left join cntnum as num on num.trno = head.trno
                left join client on client.client = head.client
                where num.doc = 'SJ' and num.txno = ".$trno."
                group by num.trno
                UNION ALL
                select head.ourref,head.trno,head.docno,left(head.dateid,10) as dateid,client.client as custcode,head.clientname as custname,
                client.addr,round(sum(ifnull(stock.ext,0)),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as gtotal,head.rem from glhead as head
                left join glstock as stock on stock.trno = head.trno
                left join cntnum as num on num.trno = head.trno
                left join client on client.clientid = head.clientid
                where num.doc = 'SJ' and num.txno = ".$trno."
                group by num.trno) as tbl order by docno";
        $invoices = Yii::$app->sbccommon->openTable($qry);


        $grandtotaltons = 0;
        $grantotalcbm = 0;

        $islocked = Cntnum::islocked($trno, $this->module->id);
        $isposted = Cntnum::isPosted($trno, $this->module->id);

        if(!empty($invoices)){
            foreach ($invoices as $key => $value) {
                $invoices[$key]['gtotal'] = number_format($invoices[$key]['gtotal'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $invoices[$key]['gtonage'] = Yii::$app->backend->getGrandTotalTons('SJ',$value['trno']);
                $invoices[$key]['gcbm'] = Yii::$app->backend->getGrandTotalCBM('SJ',$value['trno']);
                $grandtotaltons += floatval($grandtotaltons) + floatval($invoices[$key]['gtonage']);
                $grantotalcbm += floatval($grantotalcbm) + floatval($invoices[$key]['gcbm']);
            }//end for each
        }//end if

        $grandtotaltons = number_format($grandtotaltons,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        $grantotalcbm = number_format($grantotalcbm,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        $totalcustomers = Yii::$app->backend->countCustomersOnTrans('TX',$trno);
        $grandtotaltrnx = Yii::$app->backend->countTrnxTagged('TX',$trno);
        $grandtotalamt = Yii::$app->backend->getGrandtotalAmount('TX',$trno);
        $grandtotalamt = number_format($grandtotalamt,Yii::$app->systemsettings->setDecimaldisplay('currency'));
        echo json_encode(['islocked'=>$islocked,'isposted'=>$isposted,'invoices'=>$invoices,
                        'grantotalcbm'=>$grantotalcbm,'grandtotaltons'=>$grandtotaltons,'grandtotalcustomer'=>$totalcustomers,
                        'grandtotaltrnx'=>$grandtotaltrnx,'grandtotalamt'=>$grandtotalamt]);
        } catch (ErrorException $e) {
        echo $e;
    }
    }//end aciton retrievetaggedinvoices

    public function actionRemovetxtagging(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');

        $qry = "update cntnum set txno = 0 where trno = ".$trno."";
        $status = Yii::$app->sbccommon->execqry($qry);

        if($status){
            $msg = "Successfully removed SJ from this TX #.";
        }else{
            $msg = "Error occured while removing SJ from this TX #.";
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end function remove tx tagging

    //USED BY SEARCHING OF DOCNO ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionDocnolookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcDocnolookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            echo json_encode(array('searchitems' => $return['data']));
        }                                       
    }

    public function actionRetrieveexinvoices(){
        Yii::$app->backend->AjaxVerification($this);
        $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
                /*select num.trno,left(head.dateid,10) as dateid,head.docno,head.clientname,
                head.yourref,head.ourref,ifnull(num.postdate,'') as postdate,ifnull(num.postedby,'') as postedby from lahead as head
                left join cntnum as num on num.trno = head.trno
                where num.doc = 'SJ' and (num.txno <> ".$trno." or num.txno = 0)
                UNION ALL*/
        $qry = "select num.trno,left(head.dateid,10) as dateid,head.docno,head.clientname,
                head.yourref,head.ourref,ifnull(num.postdate,'') as postdate,ifnull(num.postedby,'') as postedby from glhead as head
                left join cntnum as num on num.trno = head.trno
                where num.doc = 'SJ' and (num.txno <> ".$trno." or num.txno = 0)";

        $searchitems = Yii::$app->sbccommon->openTable($qry);
        echo json_encode(['searchitems'=>$searchitems]);
    }//end function retrieve ex invoices

    public function actionTagtotxdocument(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');

        $qry = "update cntnum set txno = ".$params['tagger']." where trno = ".$params['q']."";
        $status = Yii::$app->sbccommon->execqry($qry);

        if($status){
            $msg = "Successfully tagged another external SJ Document";
        }else{
            $msg = "Error occured while tagging another external SJ Document.";
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end aciton   


    public function actionGeneraterouteguide(){
        Yii::$app->backend->AjaxVerification($this); 
        $txtrno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        
        $qry = "insert into tx_routeguide (client,clientname,address,txtrno)
                select client,clientname,address,".$txtrno." from (
                select head.client,head.clientname,head.address from lahead as head
                left join cntnum as num on num.trno = head.trno
                where num.doc = 'SJ' and num.txno = ".$txtrno."
                group by head.clientname,head.client
                UNION ALL
                select client.client,client.clientname,head.address from glhead as head
                left join cntnum as num on num.trno = head.trno
                left join client on client.clientid = head.clientid
                where num.doc = 'SJ' and num.txno = ".$txtrno."
                group by client.clientname,client.client) as tbl group by client,clientname";

        $status = Yii::$app->sbccommon->execqry($qry);
        
        if($status){
            $qryselectrg = "select txtrno from tx_routeguide where txtrno =".$txtrno;
            $txrg = Yii::$app->sbccommon->openTable($qryselectrg);
            if(!empty($txrg)){
                $qryupdateisrg = "update txhead set generatedrg = 1 where trno = ".$txtrno;
                Yii::$app->sbccommon->execqry($qryupdateisrg);
            }//end if
            $msg = "";
        }else{
            $msg = "Error occured while generating a route guide for this Transmittal Slip.";
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end function

    public function actionRetrieverouteguide(){
        Yii::$app->backend->AjaxVerification($this); 
        $txtrno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        
        $qryretrieve = "select txtrno,client,clientname,address,case when kilometers = '' then 0 else kilometers end as kilometers,
        case when no = '' then 0 else no end as no from tx_routeguide where txtrno = ".$txtrno."";
        $routeguide = Yii::$app->sbccommon->openTable($qryretrieve);
        $hasgenrg = Yii::$app->backend->hadGeneratedRouteGuide($txtrno);
        echo json_encode(['routeguide'=>$routeguide,'isrg'=>$hasgenrg]);
    }//end public action retrieve route guide


    public function actionRetrieverginfo(){
        Yii::$app->backend->AjaxVerification($this); 
        $txtrno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $ccode = Yii::$app->backend->sanitize($_GET['ccode'],'DEFAULT');
        $qryretrieve="select case when kilometers = '' then 0 else kilometers end as kilometers,case when no = '' then 0 else no end as no from
                      tx_routeguide where txtrno = ".$txtrno." and client = '".$ccode."'";
        $rginfo = Yii::$app->sbccommon->openTable($qryretrieve);

        if(!empty($rginfo)){
            $rgkm = $rginfo[0]['kilometers'];
            $rgno = $rginfo[0]['no'];
        }else{
            $rgkm = 0;
            $rgno = 0;
        }//end if

        echo json_encode(['rgkm'=>$rgkm,'rgno'=>$rgno]);
    }//end action

    public function actionUpdaterouteguide(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $qry = "update tx_routeguide set kilometers = '".$params['rgkm']."',no='".$params['rgno']."' where txtrno = ".$params['q']." and client = '".$params['ccode']."'";
        $status = Yii::$app->sbccommon->execqry($qry);
        if($status){
            $qryretrieve="select case when kilometers = '' then 0 else kilometers end as kilometers,case when no = '' then 0 else no end as no from
                          tx_routeguide where txtrno = ".$params['q']." and client = '".$params['ccode']."'";
            $rginfo = Yii::$app->sbccommon->openTable($qryretrieve);

            if(!empty($rginfo)){
                $rgkm = $rginfo[0]['kilometers'];
                $rgno = $rginfo[0]['no'];
            }else{
                $rgkm = 0;
                $rgno = 0;
            }//end if

            $msg = "Route guide has been Successfully updated (".$params['ccode'].")";
        }else{
            $msg = "Error occured while updating route guide for (".$params['ccode'].")";
            $rgkm = 0;
            $rgno = 0;
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg,'rgkm'=>$rgkm,'rgno'=>$rgno]);
    }//end action update route guide

    public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcLog($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('logs'=>$return['data']));
        }                                       
   }//END ACTION LOG

   public function actionLockunlock(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcLockunlock($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
         echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'istransposted'=>$return['istransposted']));
        }                                       
   }//END ACTION LOCK UNLOCK

    public function actionPost(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcPost($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
            'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
        }                                       
    }//end action post


    public function actionUnpost(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcUnpost($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
         echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']));
        }                                       
    }

}//end controller

