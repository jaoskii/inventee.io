<?php

namespace backend\modules\PR\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use yii\base\ErrorException;

//FOR TESTING PURPOSES
use app\models\Item;
use app\models\Cntnum;
use yii\web\Response;

class DefaultController extends Controller{

  public $access = array('view' => 619,'edit' => 620,'new' => 621,'save' => 622,
        'change' => 623,'delete' => 624,'print' => 625,'lock' => 626,
        'unlock' => 627,'post' => 630,'unpost' => 631,'changeamount' => 628,
        'clickadditem'=>814,'clickedititem'=>815,'clickdeleteitem'=>816);

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
      $return=Yii::$app->sbccontroller->sbcindex($this);    
      if($return['verifyuser']==1){
         return $this->redirect(Url::to(['/admin/default/login']));
      }elseif($return['verifyaccess']==1){
         return $this->redirect(Url::to(['/admin/default/401']));
      }else{
         return $this->render('index',array('moduledata' => $return['moduledata'],'moduleid'=>$return['moduleid']));        
      }
   }//END ACTION INDEX

   //FOR BUTTON FUNCTIONS ###################################################################################

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
         Yii::$app->response->format = Response::FORMAT_JSON;                    
         return ['moduledata' => $return['data']];
         //echo json_encode(array('moduledata' => $return['data']));
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


   public function actionSavehead() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $return=Yii::$app->sbccontroller->sbcSavehead($this,$params);  
      if($return['verifyuser']==1) {
         return $this->redirect(Url::to(['/admin/default/login']));
      } elseif($return['verifyaccess']==1) {
         return $this->redirect(Url::to(['/admin/default/401']));
      } else {

      Yii::$app->response->format = Response::FORMAT_JSON;                    
      return ['trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
            'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted']];
      /* echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
      'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted'])); */
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
         return ['moduledata' => $return['data'],'istransposted'=>$return['istransposted']];
         //echo json_encode(array('moduledata' => $return['data'],'istransposted'=>$return['istransposted']));
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
   }

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
        $trno = $_GET['trno'];

        $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);
        $computeddata = Yii::$app->backend->computestock($itemamt,$disc,$isqty,$uomfactor,$this);

        $primarydata[0]['trno'] = $trno;  
        $primarydata[0]['ext'] = $computeddata['ext'];
        $primarydata[0]['rrqty'] = $computeddata['qty'];
        $primarydata[0]['qty'] = $computeddata['qty'];
        $primarydata[0]['cost'] = $computeddata['cost'];
        $primarydata[0]['disc'] = $disc;
        $primarydata[0]['rrcost'] = $itemamt;
        $primarydata[0]['uom'] = $uom;
        $primarydata[0]['uomfactor'] = $uomfactor;
        $primarydata[0]['whcode'] = $whcode;
        $primarydata[0]['whname'] = $whname;
        $primarydata[0]['loc'] = $_GET['loc'];
        $primarydata[0]['expiry'] = $_GET['expiry'];
        $primarydata[0]['rem'] = $_GET['rem'];
        
        $moduledata["barcode"]= $primarydata[0]["barcode"];
        $moduledata["itemid"]= $primarydata[0]["itemid"];
        $moduledata["category"]= $primarydata[0]["category"];
        $moduledata["groupid"]= $primarydata[0]["groupid"];
        $moduledata["itemname"]= $primarydata[0]["itemname"];
        $moduledata["uom"]= $primarydata[0]["uom"];
        $moduledata["rrcost"]= $primarydata[0]["rrcost"];
        $moduledata["ext"]= $primarydata[0]["ext"];
        $moduledata["disc"]= $primarydata[0]["disc"];
        $moduledata["rem"]= $primarydata[0]["rem"];
        $moduledata["qty"]= $primarydata[0]["qty"];
        $moduledata["rrqty"]= $primarydata[0]["rrqty"];
        $moduledata["cost"]= $primarydata[0]["cost"];
        $moduledata["uomfactor"]= $primarydata[0]["uomfactor"];
        $moduledata["whcode"]= $primarydata[0]["whcode"];
        $moduledata["whname"]= $primarydata[0]["whname"];
        $moduledata["loc"]= $primarydata[0]["loc"];
        $moduledata["expiry"]= $primarydata[0]["expiry"];
        $moduledata["trno"]= $primarydata[0]["trno"];
        $moduledata["line"]= 0;
        $moduledata["refx"]= 0;
        $moduledata["linex"]= 0;
        $moduledata["ref"]= '';

        $returndata = Yii::$app->webprocess->savingstock($this,$this->access['save'],$moduledata);
        $return['stockline']['gvrow-'.$returndata['line']] = $returndata;
        $return['line'] = $returndata['line'];      
        
         Yii::$app->response->format = Response::FORMAT_JSON;                    
         return $return;
         //echo json_encode($return);
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
      }else{
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
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
            return ['stockdata' => $return['data']];
            //echo json_encode(array('stockdata' => $return['data']));
        }                                       
   }



   public function actionStockdelete(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcStockdelete($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']];
            //echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']));
        }                                       
   }



   public function actionPost(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcPost($this,$params);  
      if($return['verifyuser']==1){
         return $this->redirect(Url::to(['/admin/default/login']));
      }elseif($return['verifyaccess']==1){
         return $this->redirect(Url::to(['/admin/default/401']));
      }else{
         Yii::$app->response->format = Response::FORMAT_JSON;                    
         return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
               'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']];
         /* echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
         'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted'])); */
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
            return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'istransposted'=>$return['istransposted']];
            //echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'istransposted'=>$return['istransposted']));
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
         return ['postedpobal'=>$return['postedpobal'],
         'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
         'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal']];
         /* echo json_encode(array('postedpobal'=>$return['postedpobal'],
         'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
         'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal'])); */
      }
   }

   public function actionLoaditembal() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateItembal($params);
   }

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
   }



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
      Yii::$app->sbccontroller->sbcComparestocklines($this,$params);          
   }

   public function actionQuickadditem(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcQuickadditem($this,$params);  
   }

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
   }

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
   }

   public function actionGetlocation(){
      Yii::$app->backend->AjaxVerification($this);
      $barcode = $_GET['barcode'];
      $data = Yii::$app->backend->getAvailableLocation($barcode);

      Yii::$app->response->format = Response::FORMAT_JSON;                    
      return ['locations' => $data];
      //echo json_encode(array('locations' => $data));
   }//end get location

    //alvin 
   public function actionBuildstockview(){
      Yii::$app->backend->AjaxVerification($this); 
      $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');

      $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
      $type = "";
      if(isset($_POST['type'])){
         $type = $_POST['type'];
      }//end if

      return Yii::$app->automator->generatePRStockview($sql,$type);
   }

   public function actionWarehouselookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateWarehouselookupGV($params);
   }

   //USED BY SEARCHING OF DOCNO ON MODAL GENERATED BY LOOKUP BUTTON
   public function actionDocnolookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateDocnolookup($params);
   }

   public function actionSupplierlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierlookup($params);
   }

   public function actionLoadterms() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateTermslookup($params);
   }

   public function actionItemlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateItemlookupGV($params);
   }

   public function actionLog(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      return Yii::$app->automator->automateLog($this,$params);                                  
   }

   public function actionUomlookup(){
      Yii::$app->backend->AjaxVerification($this);
      $params = ['itemid'=>$_POST['x']];
      return Yii::$app->automator->automateUOMlookupGV($params);
   }//end function

   public function actionLoaduoms() {
      $barcode = $_POST['x'];
      $itemid = Yii::$app->backend->requestItemid($barcode);
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['itemid'] = $itemid;
      $params['controller'] = $this;
      return Yii::$app->automator->automateUomlookup($params);
   }
    //alvin end
}//END CONTROLLERR