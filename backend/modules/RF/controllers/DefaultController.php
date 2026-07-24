<?php

namespace backend\modules\RF\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use yii\base\ErrorException;
use app\models\Cntnum;

class DefaultController extends Controller
{
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

    public function actionAgentlookupsearch(){
        $searchstring = $_GET['searchstring'];
        $searchagent = Yii::$app->backend->searchagents($this,$this->access['view'],$searchstring);
        echo json_encode(array('searchagent' => $searchagent));
    } //END ACTION CUSTOMER LOOKUP SEARCH

    public function actionGetavailroutes(){
        Yii::$app->backend->AjaxVerification($this);
        $qry = "select route_id,route_code,route_name from route_masterfile";
        $routes = Yii::$app->sbccommon->openTable($qry);
        echo json_encode(array('routes' => $routes));
    } //end action get avail routes       

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


    public function actionRetrieverfso(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        switch ($params['otype']) {
            case 'routed':
                $filter = "and client.scroute = '".$params['route']."' and head.trnx_type = '".$params['trnx']."' ";
                break;
            
            case 'unrouted':
                $filter = "and client.scroute <> '".$params['route']."'";
                break;
        }//end switch

        $qry = "select head.trno,head.clientname as customername,head.docno,left(head.dateid,10) as dateid,
                round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,
                head.yourref from hsohead as head
                left join hsostock as stock on stock.trno = head.trno
                left join client on client.client = head.client
                where head.isapproved = 1 and stock.void <> 1
                and head.rfno = 0 ".$filter."
                group by stock.trno,head.docno,head.dateid";


        $sodata = Yii::$app->sbccommon->opentable($qry);
        
        echo json_encode(['clientpo'=>$sodata]);
    }//end action


    public function actionTagsotorf(){
    try {
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $error = [];
        foreach ($params['q'] as $key => $value) {
            //echo $value['trno']
            $qry = "update hsohead set rfno = '".$params['rf']."' where trno = ".$value['trno']."";
            Yii::$app->sbccommon->execqry($qry);
        }//end for each   

        if(!empty($error)){
            foreach ($params['q'] as $key => $value) {
                $qryrevert = "update hsohead set rfno = '' where trno = ".$value['trno']."";
                Yii::$app->sbccommon->execqry($qryrevert);
            }//end of each
            $msg = "Error occured while tagging Sales Orders to this Route Formation";
            $status = false;
        }else{
            $msg = "SO has been tag with this Route Formation";
            $status = true;
        }//end if status
        echo json_encode(['status'=>$status,'msg'=>$msg]);
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end function 

    public function actionGetsorf(){
    try {
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qryget = "select head.trno,head.docno,left(head.dateid,10) as dateid,
                round(sum(stock.ext),".Yii::$app->systemsettings->setDecimaldisplay('currency').") as totalamt,head.rem,
                head.client,head.clientname,head.yourref from hsohead as head
                left join hsostock as stock on stock.trno = head.trno
                left join client on client.client = head.client
                where head.isapproved = 1 and stock.void <> 1  and rfno = ".$params['rf']."
                group by stock.trno,head.docno,head.dateid";
        $rfso = Yii::$app->sbccommon->openTable($qryget);

        $grandtotaltons = 0;
        $grantotalcbm = 0;

        if(!empty($rfso)){
            foreach ($rfso as $key => $value) {
                $rfso[$key]['totalcbm'] = Yii::$app->backend->getGrandTotalCBM('SO',$value['trno']);
                $rfso[$key]['totaltonnage'] = Yii::$app->backend->getGrandTotalTons('SO',$value['trno']);
                $grandtotaltons = floatval($grandtotaltons) + floatval($rfso[$key]['totaltonnage']);
                $grantotalcbm = floatval($grantotalcbm) + floatval($rfso[$key]['totalcbm']);
            }//end for each
        }//end if

        $islocked = Cntnum::islocked($params['rf'], $this->module->id);
        $isposted = Cntnum::isPosted($params['rf'], $this->module->id);
        $grandtotaltons = number_format($grandtotaltons,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        $grantotalcbm = number_format($grantotalcbm,Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        $totalcustomers = Yii::$app->backend->countCustomersOnTrans('RF',$params['rf']);
        $grandtotaltrnx = Yii::$app->backend->countTrnxTagged('RF',$params['rf']);
        $grandtotalamt = Yii::$app->backend->getGrandtotalAmount('RF',$params['rf']);
        $grandtotalamt = number_format($grandtotalamt,Yii::$app->systemsettings->setDecimaldisplay('currency'));

        echo json_encode(['islocked'=>$islocked,'isposted'=>$isposted,'rfso'=>$rfso,'grantotalcbm'=>$grantotalcbm,
                        'grandtotaltons'=>$grandtotaltons,'grandtotalcustomer'=>$totalcustomers,
                        'grandtotaltrnx'=>$grandtotaltrnx,'grandtotalamt'=>$grandtotalamt]);
        } catch (ErrorException $e) {
        echo $e;
        }//end try
    }//end function

    public function actionRemoverftagging(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qryremove = "update hsohead set rfno = '' where trno=".$params['q']."";
        $status = Yii::$app->sbccommon->execqry($qryremove);

        if($status){
            $msg = "SO has been successfully untagged to this RF #";
        }else{
            $msg = "Error occured while untagging SO to this RF #";
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end function remove rf tagging

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

   public function actionDeletedoc(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET['params'];
        $return=Yii::$app->sbccontroller->sbcDeletedoc($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            echo json_encode(array('moduledata' => $return['data'],'istransposted'=>$return['istransposted']));
        }                               
    }//end action

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
    }


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
}//end action
