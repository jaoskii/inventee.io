<?php

namespace backend\modules\MI\controllers;

use Yii;
use yii\web\Controller;
use yii\base\ErrorException;
use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;

//FOR TESTING PURPOSES
use app\models\Item;

use yii\web\Response;

class DefaultController extends Controller{
//TODO: MAKE THIS CONTROLLER ACCESS AVAIALABLE ON JAVASCRIPT TO BE USED ON EVENTS
//THESE ACCESS ARRAY IS USED TO DETERMINE ACCESS INDEX ON ATTRIBUTES
   public $access = array('view' => 769,'edit' => 770,'new' => 771,
        'save' => 772,'change' => 773,'delete' => 774,'print' => 775,
        'lock' => 776,'unlock' => 777,'post' => 778,'unpost' => 779,
        'viewdetails' => 783,'changeamount' => 780,'autocompute' => 782,'crlimit' =>781,
        'clickadditem'=>3292,'clickedititem'=>3293,'clickdeleteitem'=>3294);
    
    public function actionUomlookup(){
      Yii::$app->backend->AjaxVerification($this);
      $params = ['itemid'=>$_POST['x']];
      return Yii::$app->automator->automateUOMlookupGV($params);
    }//end function


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

     public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientlookup($params);
      }

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

    //USED BY SEARCHING OF DOCNO ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionDocnolookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateDocnolookup($params); 
    }

    //USED BY SEARCHING OF CUSTOMER ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionCustomerlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;        
        $return=Yii::$app->sbccontroller->sbcSupplierlookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
           return ['searchclient' => $return['data']];
            //echo json_encode(array('searchclient' => $return['data']));
        }                                       
    }

    //USED BY SEARCHING OF ITEM ON MODAL GENERATED BY LOOKUP BUTTON
   public function actionItemlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateItemlookupGV($params);
    }

  
   public function actionWarehouselookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateWarehouselookupGV($params);
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
       try {
          Yii::$app->backend->AjaxVerification($this);

          $primarykey =$_GET['primarykey'];
          $type = $_GET['type'];
          $isqty = $_GET['qty'];
          $whcode = $_GET['whcode'];
          $whname = $_GET['wh'];
          $itemamt =str_replace(",","",$_GET['amt']); 
          $disc = $_GET['disc'];
          $trno = $_GET['trno'];

          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'NEWTIANLE':
              $uomvalue = explode('~', $_GET['uomfactor']);
              $uomstring = explode('~', $_GET['uom']);
              $uomfactor = $uomvalue[0];
              $uom = $uomstring[0];
              break;
            
            default:
              $uomfactor = $_GET['uomfactor'];
              $uom = $_GET['uom'];
              break;
          }//end switch 

          $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);
          $computeddata = Yii::$app->backend->computestock($itemamt,$disc,$isqty,$uomfactor,$this);
          
          $primarydata[0]['trno'] = $trno;      
          $primarydata[0]['ext'] = $computeddata['ext'];
          $primarydata[0]['iss'] = $computeddata['iss'];
          $primarydata[0]['isqty'] = $isqty;
          $primarydata[0]['amt'] = $computeddata['amt'];
          $primarydata[0]['disc'] = $disc;
          $primarydata[0]['isamt'] = $itemamt;
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
          $moduledata["isamt"]= $primarydata[0]["isamt"];
          $moduledata["ext"]= $primarydata[0]["ext"];
          $moduledata["disc"]= $primarydata[0]["disc"];
          $moduledata["rem"]= $primarydata[0]["rem"];
          $moduledata["iss"]= $primarydata[0]["iss"];
          $moduledata["isqty"]= $primarydata[0]["isqty"];
          $moduledata["amt"]= $primarydata[0]["amt"];
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
        }catch (ErrorException $e) {
            //Yii::$app->response->format = Response::FORMAT_JSON;
            //echo json_encode(array('sbcerror' => 1,'stacktrace'=>$e));
        }//end try
   }//END PULL DATA

   public function actionBuildstockview(){
      Yii::$app->backend->AjaxVerification($this); 
      $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
      $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
      // echo $sql; return 0;
      $type = "";
      if(isset($_POST['type'])){
         $type = $_POST['type'];
      }//end if

      return Yii::$app->automator->generateMIStockview($sql,$type);
   }//end function

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
   }//END POGI

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
   }//END POGI

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
            return ['itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']];
            //echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']));
        }
    } catch (ErrorException $e) {
      echo $e;
    }                                       
   }//END DELETE

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
   }//END ACTION LOCK UNLOCK


   public function actionLog(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      return Yii::$app->automator->automateLog($this,$params);
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
        Yii::$app->sbccontroller->sbcComparestocklines($this,$params);          
    }//END COMPARE STOCK LINE

    public function actionQuickadditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcQuickadditem($this,$params);  
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
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);                                   
    }//END CONTRA


   public function actionGetlocation(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['barcode'=>$_POST['x'],'factor'=>$_POST['factor']];
        return Yii::$app->automator->automateLocationlookupGV($params);
    }//end get location

   public function actionRequestdistro(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      return Yii::$app->automator->automateAcctg($this,$params);  
    }//end distro

   public function actionAgentlookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateAgentlookup($params);
   }

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

    public function actionStypecontra(){
      Yii::$app->backend->AjaxVerification($this);
      $salestype = Yii::$app->backend->sanitize($_GET['salestype'],'DEFAULT');
      $contra = Yii::$app->backend->getContraPartnerbasedOnSalestype($salestype);

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['contradata'=>$contra];
      //echo json_encode(array('contradata'=>$contra));
    }//end function

    public function actionGetuser(){
        $data = Yii::$app->backend->getUsers(true); 

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['uzer'=>$data];
         //echo json_encode(array('uzer'=>$data));
    }//end action

    public function actionLoaditembal() {
    Yii::$app->backend->AjaxVerification($this);
    $params = $_POST;
    $params['controller'] = $this;
    return Yii::$app->automator->automateItembal($params);
   }

/*SBC EXCLUSIVE ATTACHMENT UPLOADING*/
    public function actionUploadattachment(){
      Yii::$app->backend->AjaxVerification($this);
        if(isset($_FILES['image'])){
            $errors="";
            $picture = "";
            $file_name =$_FILES['image']['name'];
            $file_tmp= $_FILES['image']['tmp_name'];
            $file_size=$_FILES['image']['size'];
            $filearray = explode('.',$file_name);
            $file_ext = strtolower(end($filearray));
            $allowed_ext= array('jpg','jpeg','png');

            if(!in_array($file_ext,$allowed_ext)){
                $errors='Extension not allowed , allowed file extensions are (jpg,jpeg,png)';
                $status = 0;
            }else{
                if($file_size > 2097152){
                $errors = 'File size must be under 2mb';
                $status = 0;
                }else{                    
                    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
                    $data = file_get_contents($file_tmp);
                    $primarykey = $_POST['codeid'];
                    $index = $_POST['index'];
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); //STRING TO BE SAVED TO DATABASE
                    $checking = Yii::$app->sbccommon->opentable('select trno from sbc_so_attachments where trno = "'.$primarykey.'"');
                    if(empty($checking)){
                        $qry = "insert into sbc_so_attachments (trno) values(".$primarykey.")";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }//end update or insert

                    $qry = "update sbc_so_attachments set attach_".$index." = '".$base64."' where trno = '".$primarykey."'";
                    $status =  Yii::$app->sbccommon->execqry($qry);
                }//end else for file_size validation
            }//end else for extension validation

            if($status){
                $data = Yii::$app->sbccommon->opentable('select attach_'.$index.' from sbc_so_attachments where trno = "'.$primarykey.'"');
                $picture = $data[0]['attach_'.$index];
            }//end status if

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status'=>$status,'picture'=>$picture,'error'=>$errors];
            //echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end action upload attachments

    public function actionRetrieveattachments(){
        Yii::$app->backend->AjaxVerification($this);
        $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $qry = "select ifnull(attach_1,'') as attach_1,ifnull(attach_2,'') as attach_2,
        ifnull(attach_3,'') as attach_3,ifnull(attach_4,'') as attach_4 from sbc_so_attachments where trno = ".$trno."";
        $attachments = Yii::$app->sbccommon->opentable($qry);
    
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['attachments'=>$attachments];
      //echo json_encode(array('attachments'=>$attachments));
    }//end if action retrieve attachments
/*SBC EXCLUSIVE ATTACHMENT UPLOADING*/
  
  public function actionGetcostcenters(){
    Yii::$app->backend->AjaxVerification($this); 
    $centers = Yii::$app->backend->getCostCenters();
    
    Yii::$app->response->format = Response::FORMAT_JSON;
    return ['centers'=>$centers];
   //echo json_encode(['centers'=>$centers]);
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

}//END CONTROLLER




