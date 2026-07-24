<?php

namespace backend\modules\TW\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;

//FOR TESTING PURPOSES
use app\models\Item;
use app\models\Cntnum;
use app\models\Postock;
use yii\base\ErrorException;

use yii\web\Response;
class DefaultController extends Controller{

	public $access = array('view' => 3101,'edit' => 3102,'new' => 3103,'save' => 3104,
        'change' => 3105,'delete' => 3106,'print' => 3107,'lock' => 3108,
        'unlock' => 3109,'post' => 3110,'unpost' => 3111,'clickadditem' => 3102,'clickedititem' => 3102,'clickdeleteitem' => 3102);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

        public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        Yii::$app->response->format = Response::FORMAT_JSON;
         return ['verified'=>$return];
         //echo json_encode(array('verified'=>$return)); 
    }


    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
    	try {
    		$return=Yii::$app->sbccontroller->sbcindex($this); 
          if($return['verifyuser']==1){
	           return $this->redirect(Url::to(['/admin/default/login']));
	        }elseif($return['verifyaccess']==1){
	           return $this->redirect(Url::to(['/admin/default/401']));
	        }else{
	           return $this->render('index',array('moduledata' => $return['moduledata'],'moduleid'=>$return['moduleid']));        
	        }
    	} catch (ErrorException $e) {
    		echo $e;

    	}
        
    }//END ACTION INDEX


//FOR BUTTON FUNCTIONS ###################################################################################

    //FOR LOADING DATA FROM NAV BUTTONS
    public function actionNavbuttons(){
    try {
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNavbuttons($this,$params);                
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data']];
            //echo json_encode(array('moduledata' => $return['data']));
        }
    } catch (ErrorException $e) {
      echo $e;
    }
    }//END ACTION NAVBUTTONS


    public function actionNewdocument(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNewdocument($this,$params);                
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data']];
            //echo json_encode(array('moduledata' => $return['data']));
        }        
    }//END NEW DOCUMENT

    public function actionGetclientinfo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetclientinfo($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          Yii::$app->response->format = Response::FORMAT_JSON;
            return ['clientdata' => $return['data']];
            //echo json_encode(array('clientdata' => $return['data']));
        }               
    }

    public function actionSavehead(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavehead($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],'msg'=>$return['data']['msg'],'head'=>$return['data']['head']];
            //echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],'msg'=>$return['data']['msg'],'head'=>$return['data']['head']));
        }                               
    }

    public function actionDeletedoc(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET['params'];
        $return=Yii::$app->sbccontroller->sbcDeletedoc($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data']];
            //echo json_encode(array('moduledata' => $return['data']));
        }                               
    }

//FOR SEARCHING FUNCTIONS ###################################################################################
    //THIS FUNCTION IS USED WHEN DIRECTLY LOOKING FOR DOCNO [WITHOUT THE USE OF LOOKUP BUTTON]
    public function actionSearchdocno(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcSearchdocno($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => '','access'=> 0];
            //echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data'],'access'=> 1];
            //echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        }                                       
    }//END SEARCH DOCNO


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
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['searchitems' => $return['data']];
            //echo json_encode(array('searchitems' => $return['data']));
        }                                       
    }

    public function actionSupplierlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierlookup($params);
    }

    //USED BY SEARCHING OF ITEM ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionItemlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateTWItemlookupGV($params);
    }//end action

    //USED BY SEARCHING OF WAREHOUSE ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionWarehouselookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcWarehouselookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['searchitems' => $return['data']];
            //echo json_encode(array('searchitems' => $return['data']));
        }                                       
    }
   
   //LOADS LAST DOCUMENT
   public function actionLoadlastdoc(){
        Yii::$app->backend->AjaxVerification($this);
        $return=Yii::$app->sbccontroller->sbcLoadlastdoc($this);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data']];
            //echo json_encode(array('moduledata' => $return['data']));
        }                                       
   }//END ACTION CANCEL

   //FOR SPECIFIC DATA WITH PRIMARY KEY
   public function actionPulldata(){
    Yii::$app->backend->AjaxVerification($this);
    $primarykey =$_GET['primarykey'];
    $type = $_GET['type'];
    $isqty = $_GET['qty'];
    $uom = $_GET['uom'];
    $whcode = $_GET['whcode'];
    $whname = $_GET['wh'];
    $itemamt =str_replace(",","",$_GET['amt']); 
    $uomfactor = $_GET['uomfactor'];
    $disc = $_GET['disc'];
    $forex = $_GET['forex'];
    $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);
    $computeddata = Yii::$app->backend->computestock($itemamt,$disc,$isqty,$uomfactor,$this);
    $primarydata[0]['ext'] = $computeddata['ext'];
    $primarydata[0]['qty'] = $computeddata['qty'];
    $primarydata[0]['cost'] = $computeddata['cost'] * $forex;
    $primarydata[0]['disc'] = $disc;
    $primarydata[0]['rrcost'] = $itemamt;
    $primarydata[0]['uom'] = $uom;
    $primarydata[0]['uomfactor'] = $uomfactor;
    $primarydata[0]['whcode'] = $whcode;
    $primarydata[0]['whname'] = $whname;
    $primarydata[0]['loc'] = $_GET['loc'];
    $primarydata[0]['expiry'] = $_GET['expiry'];
    $primarydata[0]['rem'] = $_GET['rem'];

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['primarydata' => $primarydata];
      //echo json_encode(array('primarydata' => $primarydata));
   }//END PULL DATA

   //FOR COMPUTATION OF STOCK
   public function actionComputestock(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcComputestock($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['computeddata' => $return['data']];
            //echo json_encode(array('computeddata' => $return['data']));
        }                                       
   }

   public function actionSavestock(){
    Yii::$app->backend->AjaxVerification($this);    
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavestock($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }                                       
   }

   public function actionCanceledit(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcCanceledit($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['detailline' => $return['data']];
            //echo json_encode(array('detailline' => $return['data']));
        }                                   
   }

   public function actionStockdelete(){
    try {  
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcStockdelete($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;
        }                                       
      } catch (ErrorException $e) {
      echo $e;
    }
   }

   public function actionPost(){

    try {
       Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcPost($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']];
            //echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']));
        }    

         } catch (ErrorException $e) {
        echo $e;
        return 0;
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
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']];
            //echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']));
        }                                       
   }

   public function actionLockunlock(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcLockunlock($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
         Yii::$app->response->format = Response::FORMAT_JSON;
         return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked']];
         //echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked']));
        }                                       
   }//END ACTION LOCK UNLOCK


   public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcLog($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['logs'=>$return['data']];
            //echo json_encode(array('logs'=>$return['data']));
        }                                       
   }

   public function actionGetitembalance(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetitembalance($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['whdata'=>$return['data'],'postedpobal'=>$return['postedpobal'],
                        'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
                        'unpostedsobal'=>$return['unpostedsobal']];
            /* echo json_encode(array('whdata'=>$return['data'],'postedpobal'=>$return['postedpobal'],
                        'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
                        'unpostedsobal'=>$return['unpostedsobal'])); */
        }                                       
   }//END SHOW STOCK

   public function actionGetterms(){
        Yii::$app->backend->AjaxVerification($this);
        $return=Yii::$app->sbccontroller->sbcGetterms($this);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['terms'=>$return['data']];
            //echo json_encode(array('terms'=>$return['data']));
        }                                               
   }//END GET TERMS

   public function actionGetuom(){
    Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetuom($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['uom'=>$return['data']];
            //echo json_encode(array('uom'=>$return['data']));
        }                                       
   }//END UOM

   public function actionComparestocklines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
         /* Yii::$app->response->format = Response::FORMAT_JSON;
         return ['ischanged'=>0,'stockdata'=>$_POST];
         //echo json_encode(array('ischanged'=>0,'stockdata'=>$_POST)); */
        Yii::$app->sbccontroller->sbcComparestocklines($this,$params);          
    }//END COMPARE STOCK LINE

    public function actionQuickadditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcQuickaddtax($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['data'=>$return];
            //echo json_encode(array('data'=>$return));
        }                                       
    }//END ACTION QUICK ADD

    public function actionReqprice(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcReqprice($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['pricedata'=>$return['pricedata']];
            //echo json_encode(array('pricedata'=>$return['pricedata']));
        }                                       
    }//END REQ PRICE

    public function actionContrasearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcContrasearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['searchitems' => $return['searchitems']];
            //echo json_encode(array('searchitems' => $return['searchitems']));
        }                                       
    }//END CONTRA

    public function actionRequestclientpo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcRequestclientpo($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['clientpo' => $return['clientpo'],'type'=>$return['type']];
            //echo json_encode(array('clientpo' => $return['clientpo'],'type'=>$return['type']));      
        }                                       
    }//end requestclientpo

    public function actionRetrieveorderdata(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcRetrieveorderdata($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['returntype'=>$return['returntype'],'podata'=>$return['podata']];
            //echo json_encode(array('returntype'=>$return['returntype'],'podata'=>$return['podata']));
        }                                       
}//end action retrievedata


   public function actionGetlocation(){
      Yii::$app->backend->AjaxVerification($this);
      $barcode = $_GET['barcode'];
      $data = Yii::$app->backend->getAvailableLocation($barcode);

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['locations' => $data];
      //echo json_encode(array('locations' => $data));
    }//end get location

    public function actionRequestdistro(){
      Yii::$app->backend->AjaxVerification($this);
      $params=$_GET;
      $return=Yii::$app->sbccontroller->sbcrequestDistro($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['distro'=>$return['distro']];
            //echo json_encode(array('distro'=>$return['distro']));
        }                                       
    }//end distro

    public function actionComputeduedate(){
      $date = Yii::$app->backend->computeduedate($_GET['terms'],$_GET['dateid']);
      
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['duedate' => $date];
      //echo json_encode(array('duedate' => $date));
    }

    public function actionGetdocreference(){
      Yii::$app->backend->AjaxVerification($this);
      $trno = $_GET['trno'];
      $doc = $this->module->id;
      $data = Yii::$app->backend->getDocumentreference($trno,$doc);
      if(empty($data)){ 
          Yii::$app->response->format = Response::FORMAT_JSON;
            return ['data' => ""];
            //echo json_encode(array('data' => ""));  
      }else{
         Yii::$app->response->format = Response::FORMAT_JSON;
         return ['data' => $data];
         //echo json_encode(array('data' => $data));  
      }
    }//END FUNCTION

    public function actionRetrievepricehistory(){
      Yii::$app->backend->AjaxVerification($this);
      $doc = $this->module->id;
      $ccode = Yii::$app->backend->sanitize($_GET['ccode'],'DEFAULT');
      $barcode = Yii::$app->backend->sanitize($_GET['barcode'],'DEFAULT');

      $history = Yii::$app->backend->retrievePriceHistory($doc,$barcode,$ccode);
      
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['pricehistory'=>$history];
      //echo json_encode(array('pricehistory'=>$history));
    }//end function
    

    public function actionVoiditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcVoidItem($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['voiding'=>$return['data']];
            //echo json_encode(array('voiding'=>$return['data']));
        }//end function
    }//end function

    public function actionGetuser(){
        $data = Yii::$app->backend->getUsers(true); 
        Yii::$app->response->format = Response::FORMAT_JSON;
         return ['uzer'=>$data];
         //echo json_encode(array('uzer'=>$data));
    }//end action


    public function actionSavedetail(){
    Yii::$app->backend->AjaxVerification($this);    
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavedetail($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;
        }              
   }

   public function actionComparedetaillines(){   
      try {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;   
        Yii::$app->sbccontroller->sbcComparedetaillines($this,$params);          

        } catch (ErrorException $e) {
          echo $e;
        }  
    }//END COMPARE STOCK LINE


     public function actionComputetax(){
      try {
          Yii::$app->backend->AjaxVerification($this);
          $params = $_GET;
          $rate=$_GET['rate'];
          $income=$_GET['income'];
          $comptax = Yii::$app->backend->computeTax($rate,$income);

          Yii::$app->response->format = Response::FORMAT_JSON;
         return ['comptax'=>$comptax];
         //echo json_encode(array('comptax'=>$comptax));                       
      } catch (ErrorException $e) {
        echo $e;
      }
   }

   public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
        $type = "";
        if(isset($_POST['type'])){
          $type = $_POST['type'];
        }//end if

        return Yii::$app->automator->generateTWStockview($sql,$type);
    }//end function
    
}//END CONTROLLERR
