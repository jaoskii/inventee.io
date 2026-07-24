<?php

namespace backend\modules\SJ\controllers;

use Yii;
use yii\web\Controller;
use yii\base\ErrorException;
use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use app\models\Lastock;
//FOR TESTING PURPOSES
use app\models\Item;
use app\models\Log;
use app\models\Common;

use yii\web\Response;

class DefaultController extends Controller{
//TODO: MAKE THIS CONTROLLER ACCESS AVAIALABLE ON JAVASCRIPT TO BE USED ON EVENTS
//THESE ACCESS ARRAY IS USED TO DETERMINE ACCESS INDEX ON ATTRIBUTES
	 public $access = array('view' => 169,'edit' => 170,'new' => 171,
  'save' => 172,'change' => 173,'delete' => 174,'print' => 175,
  'lock' => 176,'unlock' => 177,'post' => 178,'unpost' => 179,
  'viewdetails' => 183,'changeamount' => 180,'changedisc'=>3301,
  'autocompute' => 182,'crlimit' =>181,
  'clickadditem'=>802,'clickedititem'=>803,'clickdeleteitem'=>804);
    
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

  public function actionLoaditembal() {
    Yii::$app->backend->AjaxVerification($this);
    $params = $_POST;
    $params['controller'] = $this;
    return Yii::$app->automator->automateItembal($params);
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
      }catch (ErrorException $e) {
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
          
          switch (Yii::$app->systemsettings->companyConfig()) {
            default:
              $moduledata["itemname"]= $primarydata[0]["itemname"];
            break;
          }//end if
      
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
          $moduledata["kgs"]= 0;
          
          switch (Yii::$app->systemsettings->companyConfig()) {      
            default:
              $moduledata['itemcomm'] = '';
              $moduledata['itemhandling'] = '';
            break;
          }//END SWITCH

          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $moduledata['agent']='';
            break;
          }//end if

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


    public function actionComputestock() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcComputestock($this,$params);
      
      switch (Yii::$app->systemsettings->companyConfig()) {
        case 'TENPLUS':
          if($params['itemhandling'] != '' && $params['itemcomm'] != ''){
            $lesshandling = floatval($params['displayamt']) * floatval($params['itemhandling']) * floatval($return['data']['iss']); 
            $lesscomm = 0;
            //$lesscomm = floatval($params['displayamt']) * floatval($params['itemcomm']) * floatval($return['data']['iss']); 
            $totalless = floatval($lesshandling) + floatval($lesscomm);

            $return['data']['ext'] = str_replace(',', '', $return['data']['ext']);
            $return['data']['ext'] = floatval($return['data']['ext']) - floatval($totalless);
            $return['data']['ext'] = number_format($return['data']['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
          }//end if
        break;
      }//end switch

      if($return['verifyuser']==1) {
         return $this->redirect(Url::to(['/admin/default/login']));
      } elseif($return['verifyaccess']==1) {
         return $this->redirect(Url::to(['/admin/default/401']));
      } else {
         Yii::$app->response->format = Response::FORMAT_JSON;
         return ['computeddata' => $return['data']];
          //echo json_encode(array('computeddata' => $return['data']));
      }
    }

   public function actionSavestock(){
    try {
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
      
    } catch (ErrorException $e) {
      echo $e;
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
      
    
    public function actionGettabinfo(){
      Yii::$app->backend->AjaxVerification($this);
      $params = Yii::$app->backend->sanitize($_GET,'ARRAY');

      switch (strtoupper($params['tabkey'])) {
          case 'SC_RECEIVE':
            $qry = "select screceivedate,screceivenotes from cntnum where trno = ".$params['q']."";
          break;

          case 'SC_POSTDEV':
            $qry = "select sctruck,scshippingline,scdestination,sccheckerdriver,screceivedby,scpostdevnotes from cntnum where trno = ".$params['q']."";
          break;

          case 'SC_DISPATCHDISC':
            $qry = "select scdiscrepancytype,scdiscrepancydetails,scdiscrepancynotes from cntnum where trno = ".$params['q']."";
          break;

          case 'SC_DISPATCHCONFIRM':
            $qry = "select scconfirmationdate,scconfirmationnotes from cntnum where trno = ".$params['q']."";
          break;

          case 'SC_SETTLED':
            $qry = "select scsettleddate,scsettlednotes from cntnum where trno = ".$params['q']."";
          break;
      }//END SWITCH CASE

      $details = Yii::$app->sbccommon->opentable($qry);
      
      if(!empty($details)){
        $status = true;
      }else{
        $status = false;
      }//end if

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['details'=>$details,'status'=>$status];
      //echo json_encode(['details'=>$details,'status'=>$status]);
    }//end function get tab info

    public function actionUpdatetabs(){
    try {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        
        switch (strtoupper($params['tabkey'])) {
            case 'SC_RECEIVE':
              $qry = "update cntnum set screceivedate = '".$params['rdate']."',screceivenotes = '".$params['rnotes']."' where trno = ".$params['q']."";
              $status =  Yii::$app->sbccommon->execqry($qry);

              if($status){
                  $qryupdatecustomer = "update client set status = 'ACTIVE' where client = '".$params['qc']."'";
                  Yii::$app->sbccommon->execqry($qryupdatecustomer);
              }//end if
            break;

            case 'SC_POSTDEV':
              $qry = "update cntnum set sctruck = '".$params['truck']."',scshippingline = '".$params['shippingline']."',
                      scdestination = '".$params['destination']."',sccheckerdriver = '".$params['checkerdriver']."',
                      screceivedby = '".$params['receivedby']."',scpostdevnotes = '".$params['notes']."'
                      where trno = ".$params['q']."";
              $status =  Yii::$app->sbccommon->execqry($qry);
            break;

            case 'SC_DISPATCHDISC':
              $qry = "update cntnum set scdiscrepancytype = '".$params['dtype']."',
                      scdiscrepancydetails = '".$params['ddetails']."',scdiscrepancynotes = '".$params['dnotes']."' where trno = ".$params['q']."";
              $status =  Yii::$app->sbccommon->execqry($qry);
            break;

            case 'SC_DISPATCHCONFIRM':
              $qry = "update cntnum set scconfirmationdate = '".$params['ddate']."',scconfirmationnotes = '".$params['dnotes']."' where trno = ".$params['q']."";
              $status =  Yii::$app->sbccommon->execqry($qry);
            break;

            case 'SC_SETTLED':
              $qry = "update cntnum set scsettleddate = '".$params['sdate']."',scsettlednotes = '".$params['snotes']."' where trno = ".$params['q']."";
              $status =  Yii::$app->sbccommon->execqry($qry);
            break;
        }//END SWITCH CASE

        
        
        if($status){
          $msg = "Updating Succeed!";
        }else{
          $msg = "Updating Failed! Please try again!";
        }//end if status

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>$status,'msg'=>$msg];
        //echo json_encode(['status'=>$status,'msg'=>$msg]);
      } catch (ErrorException $e) {
      echo $e;
    }
    }//end action receive tab

    public function actionRetriveitemcomponents(){

        Yii::$app->backend->AjaxVerification($this);
        $outputid = $_GET['q'];
        $sjqty = $_GET['qty'];
        $whcode = Yii::$app->session['loggeduser']['whcode'];
        $sql = "
        select 1 as status,comp.barcode,comp.itemname,(".$sjqty." * comp.isqty) as isqty,comp.uom,comp.outputid,'".$whcode."' as whcode,1 as iscomponent from item
        left join component as comp on comp.outputid=item.itemid
        where item.itemid='".$outputid."'";

        $return =Yii::$app->sbccommon->opentable($sql);    
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['podata'=>$return];
        //echo json_encode(array('podata'=>$return));          
   }// retriveitemcomponents

   public function actionAndroidtransactionposting(){
      $posting = Cntnum::PostTrans($trno,$doc,$user);
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$posting];
      //echo json_encode(['status'=>$posting]);
   }//end funciton

   //ALvin
    public function actionBuildstockview(){
      Yii::$app->backend->AjaxVerification($this); 
      $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
      $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
      
      $type = "";
      if(isset($_POST['type'])){
        $type = $_POST['type'];
      }//end if

      return Yii::$app->automator->generateSJStockview($sql,$type,$this);
    }//end function

      
    public function actionDocnolookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateDocnolookup($params);
    }
        public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientlookup($params);
      }

    public function actionContrasearch(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);                                   
    }//END CONTRA


    public function actionPickerlookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      $params['type'] = 'uv_picker';
      return Yii::$app->automator->automateAgentlookup($params);
    }

    public function actionCheckerlookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      $params['type'] = 'uv_checker';
      return Yii::$app->automator->automateAgentlookup($params);
    }

    public function actionAgentlookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateAgentlookup($params);
    }


    public function actionWarehouselookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateWarehouselookupGV($params);
    }

    public function actionLoadterms() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateTermslookup($params);
    }


      public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);
      }

    public function actionItemlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateItemlookupGV($params);
    }

      public function actionRequestdistro(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateAcctg($this,$params);  
                                          
    }//end distro

    public function actionLoaduoms() {
      $barcode = $_POST['x'];
      $itemid = Yii::$app->backend->requestItemid($barcode);
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['itemid'] = $itemid;
      $params['controller'] = $this;
      return Yii::$app->automator->automateUomlookup($params);
    }


    public function actionUomlookup(){
      Yii::$app->backend->AjaxVerification($this);
      $params = ['itemid'=>$_POST['x']];
      return Yii::$app->automator->automateUOMlookupGV($params);
    }//end function

    public function actionGetlocation(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['barcode'=>$_POST['x'],'factor'=>$_POST['factor']];
        return Yii::$app->automator->automateLocationlookupGV($params);
    }//end get location


    public function actionRequestclientposummary() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierposummarized($params);
    }
    public function actionRequestclientpodetailed() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierpodetailed($params);
    }


    public function actionRetrieveorderdatasummary() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return = Yii::$app->sbccontroller->sbcRetrieveorderdatasummary($this,$params);
      if($return['verifyuser'] == 1) {
        return $this->redirect(Url::to(['/admin/default/login']));
      } else if($return['verifyaccess'] == 1) {
        return $this->redirect(Url::to(['/admin/default/401']));
      } else {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['primarydata'=>$return['podata']];
        //echo json_encode(array('primarydata'=>$return['podata']));
      }
    }

    public function actionRetrieveorderdatadetailed() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return = Yii::$app->sbccontroller->sbcRetrieveorderdatadetailed($this,$params);
      if($return['verifyuser'] == 1) {
        return $this->redirect(Url::to(['/admin/default/login']));
      } else if($return['verifyaccess'] == 1) {
        return $this->redirect(Url::to(['/admin/default/401']));
      } else {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['primarydata'=>$return['podata']];
        //echo json_encode(array('primarydata'=>$return['podata']));
      }
    }

    public function actionUvinvoicetagger(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_GET;

      $qry = "select head.docno,head.uv_transtype,head.uv_picker as pickcode,ifnull(pick.clientname,'') as pickname,
                head.uv_checker as checkcode,ifnull(chick.clientname,'') as checkname,
              head.agent,ifnull(ag.clientname,'') as agname from hsohead as head
              left join client as ag on ag.client = head.agent
              left join client as pick on pick.client = head.uv_picker
              left join client as chick on chick.client = head.uv_checker
              where trno = " . $params['st'];

      $data = Yii::$app->sbccommon->opentable($qry);

      if(empty($data)){
        $status = false;
        $stdocno = '';
        $st_transtype = '';
        $pickcode= '';
        $pickname = '';
        $picker = '';
        $checkcode = '';
        $checkname = '';
        $checker = '';
        $agcode = '';
        $agname = '';
        $ag = '';
      }else{
        $stdocno = $data[0]['docno'];
        $st_transtype = $data[0]['uv_transtype'];
        
        switch ($st_transtype) {
          case 'REGULAR':
            $transtype = 'R';
          break;
          
          case '':
            $transtype = '';
          break;

          default:
            $transtype = 'S';
          break;
        }//END SWITCH

        $pickcode= $data[0]['pickcode'];
        $pickname = $data[0]['pickname'];
        $picker = $pickcode . '~' . $pickname;
        $checkcode = $data[0]['checkcode'];
        $checkname = $data[0]['checkname'];
        $checker = $checkcode . '~' . $checkname;
        $agcode = $data[0]['agent'];
        $agname = $data[0]['agname'];
        $ag = $agcode . '~' .$agname;

        $updateqry = "update lahead set ourref = '".$stdocno."',agent = '".$agcode."',
                      checkby = '".$checkcode."',pickby = '".$pickcode."' where trno = ". $params['q'];
        $updateqry2 = "update cntnum set transtype = '".$transtype."' where trno = ". $params['q'];

        $status =  Yii::$app->sbccommon->execqry($updateqry);
        $status =  Yii::$app->sbccommon->execqry($updateqry2);
      }//end if

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$status,'stdocno'=>$stdocno,'st_transtype'=>$st_transtype,'picker'=>$picker,'checker'=>$checker];
      //echo json_encode(['status'=>$status,'stdocno'=>$stdocno,'st_transtype'=>$st_transtype,'picker'=>$picker,'checker'=>$checker]);
        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end if

    public function actionRetrievesonote() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automatesonote($params);
    }

    public function actionSavesonote() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $qryline = "select line from sbc_so_notes where trno = ". $params['trno'] . " order by line desc limit 1";
      $line = Yii::$app->sbccommon->datareader($qryline);
      if(empty($line)) { $line = 1; } else { $line += 1; }//end if
      $qry = "insert into sbc_so_notes (trno,station,serialno,rem,others,line) values(".$params['trno'].",'".$params['sonotestation']."','".$params['sonoteserial']."', '".$params['sonoteremarks']."','".$params['sonoteothers']."',".$line.");";
      $status = Yii::$app->sbccommon->execqry($qry);
      if($status) { $msg = "Notes added successfully!"; } else { $msg = "Add notes failed!"; }//end if
      
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$status,'msg'=>$msg];
      //echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end action save so note

    public function actionDeletesonote() {
      Yii::$app->backend->AjaxVerification($this);
      $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
      $qry = "delete from sbc_so_notes where trno = ".$params['q']." and line = ".$params['line']."";
      $status = Yii::$app->sbccommon->execqry($qry);
      if($status) { $msg = "Delete note successfully!"; } else { $msg = "Delete note failed! Please try again!"; }//end if status

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$status,'msg'=>$msg];
      //echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end action delete so note
    
    public function actionRetrievecommdata(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automatecommdata($params);
    }//end function

    public function actionRemovecommdata(){
      $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
      $line = Yii::$app->backend->sanitize($_GET['l'],'DEFAULT');
      $qryselect = "select line,agenttbl.clientname as agentname,sj_comm.agent,
                  round(grandtotal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal,
                  round(baseamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as baseamt,
                  concat(standardpercent,'%') as standardpercent,
                  round(standardamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardamt,
                  concat(standardsharepercent,'%') as standardsharepercent,
                  round(standardshareamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardshareamt,cutoffdate from sj_comm
                  left join client as agenttbl on agenttbl.client = sj_comm.agent
                  where sj_comm.trno = ".$trno." and sj_comm.line = ".$line."";
      $commdatadel = Yii::$app->sbccommon->openTable($qryselect);
      $qry = "delete from sj_comm where trno = ".$trno." and line = ".$line."";
      $status = Yii::$app->sbccommon->execqry($qry);
      if($status) {
        $msg = 'Successfully removed commdata';
        $qry = "select line,agenttbl.clientname as agentname,sj_comm.agent,
                  round(grandtotal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal,
                  round(baseamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as baseamt,
                  concat(standardpercent,'%') as standardpercent,
                  round(standardamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardamt,
                  concat(standardsharepercent,'%') as standardsharepercent,
                  round(standardshareamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardshareamt,cutoffdate from sj_comm
                  left join client as agenttbl on agenttbl.client = sj_comm.agent
                  where sj_comm.trno = ".$trno."";
        $commdata = Yii::$app->sbccommon->openTable($qry);
        $commsharetotal = Yii::$app->sbccommon->datareader("select sum(standardshareamt) from sj_comm where trno = ".$trno."");
      } else {
        $msg = 'Remove commdata failed. Please try again.';
        $commdata = [];
        $commsharetotal = 0.00;
      }//end if
      Log::writelog('SJ', $trno, 'DELETED COMM',$commdatadel[0]['agentname'] . '<br>Base Amt: '. $commdatadel[0]['baseamt'] .'<br>'.'Standard %: '. $commdatadel[0]['standardpercent'].'%<br>'.'Standard Amt: ' . $commdatadel[0]['standardamt'].'<br>'.'Share %: '.$commdatadel[0]['standardsharepercent'].'%<br>'.'Share Amt: ' .$commdatadel[0]['standardshareamt'].'<br>'.'Cutoff Date: ' .$commdatadel[0]['cutoffdate'],Yii::$app->session['loggeduser']['username']);

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['msg'=>$msg,'status'=>$status,'commdata'=>$commdata,'commsharetotal'=>$commsharetotal];
      //echo json_encode(['msg'=>$msg,'status'=>$status,'commdata'=>$commdata,'commsharetotal'=>$commsharetotal]);
    }//end funciton
    
    public function actionGetinvoicegrandtotal(){
      try {
      $trno = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
      $grandtotal = Lastock::getgrandtotal($trno, 'SJ');
      if(empty($grandtotal)){
        $grandtotal = 0;
      }else{
        $grandtotal = $grandtotal[0]['grandtotal'];
      }//end if

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['grandtotal'=>$grandtotal];
      //echo json_encode(['grandtotal'=>$grandtotal]);
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action get invoice grantotal

    public function actionInsertcommdata(){
      $params = $_GET;
      $agentdetails = explode('~', $params['ag']);
      $agentcode = $agentdetails[0];
      $qry = "insert into sj_comm (trno,agent,grandtotal,baseamt,standardpercent,standardamt,standardsharepercent,standardshareamt,cutoffdate)
              values(".$params['q'].",'".$agentcode."',".$params['gtotal'].",".$params['bamt'].",'".$params['spercent']."',".$params['samt'].",
              '".$params['sspercent']."',".$params['ssamt'].",'".$params['cdate']."')";

      $status = Yii::$app->sbccommon->execqry($qry);
      
      if($status){
        $qry = "select line,agenttbl.clientname as agentname,sj_comm.agent,
                round(grandtotal,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as grandtotal,
                round(baseamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as baseamt,
                concat(standardpercent,'%') as standardpercent,
                round(standardamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardamt,
                concat(standardsharepercent,'%') as standardsharepercent,
                round(standardshareamt,".Yii::$app->systemsettings->setDecimaldisplay('currency').") as standardshareamt,cutoffdate from sj_comm
                left join client as agenttbl on agenttbl.client = sj_comm.agent
                where sj_comm.trno = ".$params['q']."";
        $commdata = Yii::$app->sbccommon->openTable($qry);
        $commsharetotal = Yii::$app->sbccommon->datareader("select sum(standardshareamt) from sj_comm where trno = ".$params['q']."");

        Log::writelog('SJ', $params['q'], 'ADD COMM',$agentdetails[1] . '<br>Base Amt: '. $params['bamt'] .'<br>'.'Standard %: '. $params['spercent'].'%<br>'.'Standard Amt: ' . $params['samt'].'<br>'.'Share %: '.$params['sspercent'].'%<br>'.'Share Amt: ' .$params['ssamt'].'<br>'.'Cutoff Date: '.$params['cdate'],Yii::$app->session['loggeduser']['username']);
      }else{
        $commdata = [];
        $commsharetotal = 0.00;
      }//end if

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$status,'commdata'=>$commdata,'commsharetotal'=>$commsharetotal];
      //echo json_encode(['status'=>$status,'commdata'=>$commdata,'commsharetotal'=>$commsharetotal]);
    }//end function

    public function actionGetlast10trans(){
      Yii::$app->backend->AjaxVerification($this);
      $params = ['client'=>$_POST['x']];
      $params['clientid'] = Yii::$app->backend->requestClientid($params['client']);
      return Yii::$app->automator->fnGetLast10Trans($params['clientid'],$params['client']);
    }//end if

    public function actionCopytrans(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      return Yii::$app->automator->generateCopytransGrid($this,$params);
    }//end if

    public function actionCopytransdetails(){
      try {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $dater = Yii::$app->backend->copytransactionDetails($this,$params);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['trno'=>$dater['trno'],'docno'=>$dater['docno'],'msg'=>$dater['msg']];
        //echo json_encode(['trno'=>$dater['trno'],'docno'=>$dater['docno'],'msg'=>$dater['msg']]);
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end if

    public function actionGetfgprodtype() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['x'] != ""){
            $where = "where name like '%".$params['x']."%'";
        }else{
            $where = "";
        }//end if

        $qry = "select id,code,name from prodtype_masterfile ".$where;

        $params = [
            'sql' => $qry,
            'tableid' => 'fgprodtypetbl',
            'key' => 'id', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'label' => 'Code',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'name',
                    'label' => 'Name',
                    'class' => 'aimslabel col-description'
                ]
            ],
            'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickfgprodtype btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'prodtype','value'=>'name'],['name' => 'prodtypeid','value' => 'id']]
                            ]
                        ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionLookupjbdocs(){
      Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['x'] != ""){
            $where = "and (head.docno like '%".$params['x']."%' or head.dateid like '%".$params['x']."%' or head.clientname like '%".$params['x']."%'
                      or head.trnx_type like '%".$params['x']."%' or head.salestype like '%".$params['x']."%' 
                      or head.yourref like '%".$params['x']."%' or head.ourref like '%".$params['x']."%'
                      or head.shipto like '%".$params['x']."%')";
        }else{
            $where = "";
        }//end if

        //WTODO: [KIM][2019.11.22][update query]
        $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,
        head.clientname,head.trnx_type, head.salestype, head.yourref,
        head.ourref, head.shipto from hjbhead as head
        left join hjbstock as stock on stock.trno = head.trno
        where head.breakdownreport = '' " . $where . " group by head.docno";

        $params = [
            'sql' => $qry,
            'tableid' => 'jonumtbl',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'label' => 'Doc #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'clientname',
                    'label' => 'Customer',
                    'class' => 'aimslabel col-description'
                ],[
                    'name' => 'trnx_type',
                    'label' => 'Trans type',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'salestype',
                    'label' => 'Sales type',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'yourref',
                    'label' => 'Yourref',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'ourref',
                    'label' => 'Ourref',
                    'class' => 'aimslabel col-min'
                ]
            ],
            'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickjonum btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'trno','value'=>'trno']]
                            ]
                        ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end action


    public function actionGetjoborderdetails(){
    try {
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_GET;

      $qry = "select count(trno) from (
              select trno from lastock where trno <> ".$params['qq']." and refx = ".$params['q']."
              UNION ALL
              select trno from glstock where trno <> ".$params['qq']." and refx = ".$params['q'].")
              as tbl";

      $counter = Yii::$app->sbccommon->datareader($qry);

      if($counter == 0){
        $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,head.clientname,head.client,
        head.trnx_type,head.salestype,head.yourref,head.ourref,head.shipto,
        stock.barcode,stock.itemname,stock.isqty,stock.uom,stock.isamt,
        stock.iss,stock.amt,stock.disc,stock.qa,stock.loc,stock.expiry,item.itemid,stock.ext,uom.factor as uomfactor,
        stock.wh,stock.trno as refx,stock.line as linex
        from hjbhead as head
        left join hjbstock as stock on stock.trno = head.trno
        left join item on item.barcode = stock.barcode
        left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
        where stock.trno = " . $params['q'];
      }else{
        //do nothing for now
        $qry = "select head.trno,head.docno,left(head.dateid,10) as dateid,head.clientname,head.client,
        head.trnx_type,head.salestype,head.yourref,head.ourref,head.shipto,
        stock.barcode,stock.itemname,(stock.iss - stock.qa) as isqty,stock.uom,stock.isamt,
        stock.iss,stock.amt,stock.disc,stock.qa,stock.loc,stock.expiry,item.itemid,stock.ext,uom.factor as uomfactor,
        stock.wh,stock.trno as refx,stock.line as linex
        from hjbhead as head
        left join hjbstock as stock on stock.trno = head.trno
        left join item on item.barcode = stock.barcode
        left join uom on uom.itemid = item.itemid and uom.uom = stock.uom
        where stock.trno = " . $params['q'];
      }//end if

      $stockdata = Yii::$app->sbccommon->opentable($qry);

      //DELETES STOCK WITH THE SAME TRNO THAT THE JO WILL BE LOOKED UP
      $qrycheckdeleter = "select stock.trno,stock.line from lastock as stock 
      where stock.trno = " . $params['qq'] . " and stock.refx = " . $params['q'];

      $deletestocks = Yii::$app->sbccommon->opentable($qrycheckdeleter);

      if(!empty($deletestocks)){
        foreach ($deletestocks as $key => $value) {
          $model = new Lastock;
          $model->deletestocks('SJ',$value['trno'], $value['line']);
        }//end if
      }//end if

      if(!empty($stockdata)){

        $updateheadqry = "update lahead set mlcp_jonum = '".$stockdata[0]['docno']."',
                          dateid = '".$stockdata[0]['dateid']."',client = '".$stockdata[0]['client']."',
                          clientname = '".$stockdata[0]['clientname']."',uv_transtype = '".$stockdata[0]['trnx_type']."',
                          salestype = '".$stockdata[0]['salestype']."',yourref = '".$stockdata[0]['yourref']."',
                          ourref = '".$stockdata[0]['ourref']."',shipto = '".$stockdata[0]['shipto']."'
                          where lahead.trno = '".$params['qq']."'";

        Yii::$app->sbccommon->execqry($updateheadqry);
        /*$('.txtjonumber').val(data.jodata[0].docno);*/

        $updatedheader = 0;
        foreach ($stockdata as $key => $value) {
            $moduledata["barcode"]= $value['barcode'];
            $moduledata["itemname"]= $value['itemname'];
            $moduledata["itemid"]= $value['itemid'];
            $moduledata["uom"]= $value['uom'];
            $moduledata["uomfactor"]= $value['uomfactor'];
            $moduledata["isamt"]= $value['isamt'];
            $moduledata["ext"]= $value['ext'];
            $moduledata["disc"]= $value['disc'];
            $moduledata["iss"]= $value['iss'];
            $moduledata["isqty"]= $value['isqty'];
            $moduledata["amt"]= $value['amt'];
            $moduledata["whcode"]= $value['wh'];
            $moduledata["loc"]= $value['loc'];
            $moduledata["expiry"]= $value['expiry'];
            $moduledata["line"]= 0;
            $moduledata["refx"]= 0;
            $moduledata["linex"]= 0;
            $moduledata["ref"]= $value['docno'];
            $moduledata["trno"]= $params['qq'];
            $moduledata["rem"]= '';

            $statdata = Yii::$app->webprocess->savingstock($this,$this->access['save'],$moduledata);

            $last_line = Lastock::getLastLine('SJ',$params['qq']);
            
            if(!$updatedheader){
              $qrygetfgnotes = "select fg_combi,fg_plasticcolor,fg_sealing,
              concat(fg_colornum , ' ',
              case fg_colornum
              when fg_colornum = '' then 'PLAIN'
              when fg_colornum = 0 then 'PLAIN'
              when fg_colornum > 1 then 'COLOR'
              when 23 then 'COLORS'
              else 'PLAIN'
              end) as colorstr,
              concat(fg_jowidth,' X ',fg_jolength,' X ' ,fg_thickness,' MIC') as measurestr
              from item where barcode = '".$value['barcode']."'";
              
              $fgnotes = Yii::$app->sbccommon->opentable($qrygetfgnotes);
              $notes = $fgnotes[0]['fg_combi'] . ' ' . $fgnotes[0]['fg_plasticcolor'] . ' ' . $fgnotes[0]['fg_sealing'] . ' ' . $fgnotes[0]['colorstr'] . '\n'.$fgnotes[0]['measurestr']. '\n\n\n'. 'TOTAL GROSS WT:\nLESS SACK/SPOOL WT:\nTOTAL NET WT:';

              $qryupdateheader = 'update lahead set rem = "'.$notes.'" where trno = '.$params['qq'].'';
              Yii::$app->sbccommon->execqry($qryupdateheader);
            }//end if

            $refxupdaterqry = "update lastock set isfromjo = 1,refx = '".$value['refx']."', linex = '".$value['linex']."'
                               where trno = '".$params['qq']."' and line = '".$last_line."'";

            $status = Yii::$app->sbccommon->execqry($refxupdaterqry);
            if($status){
              $servedupdater = "update hjbstock set qa = qa + " . $value['iss'] . " where trno = " . $value['refx'] . " and line = " . $value['linex'];
              $status = Yii::$app->sbccommon->execqry($servedupdater);
            }//end if
        }//end for each
      }//end if
    } catch (ErrorException $e) {
      echo $e;
    }
    }//end action

    public function actionGetstocknotes(){
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_GET;

      $qry = "select rem from (
              select rem from lastock as stock
              where stock.trno = " . $params['q'] . " and stock.line = " . $params['qq'] . "
              UNION ALL
              select rem from glstock as stock
              where stock.trno = " . $params['q'] . " and stock.line = " . $params['qq'].") as tbl";
      $stockrem = Yii::$app->sbccommon->datareader($qry);

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['stockrem'=>$stockrem,'stockline'=>$params['qq']];
      //echo json_encode(['stockrem'=>$stockrem,'stockline'=>$params['qq']]);
    }//end action

    public function actionUpdatestocknotes(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      
      $params = $_GET;
      $params['rem'] = Yii::$app->backend->sanitize($params['rem'],'DEFAULT');

      $qry = "update lastock set rem = '".$params['rem']."' where lastock.trno = " . $params['q'] . " and lastock.line = " . $params['qq'];
      $status =  Yii::$app->sbccommon->execqry($qry);

      if($status){
        $msg = 'Successfully updated stock remarks.';
      }else{
        $msg = 'Failed to update stock remarks. Please try again.';
      }//end if

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$status,'msg'=>$msg];
      //echo json_encode(['status'=>$status,'msg'=>$msg]);

      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action

    public function actionComputefreight(){
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_GET;
      $grandtotal = Lastock::getgrandtotal($params['qq'], $this->module->id);
      $params['q'] = str_replace(',','',$params['q']);

      if(!empty($total)){
        $total = str_replace(',','',$grandtotal[0]['grandtotal']);
      }else{
        $total = 0;
      }//end if
      
      $amt = floatval($total) + floatval($params['q']);
      number_format($amt,Yii::$app->systemsettings->setDecimaldisplay('currency'));

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['amt'=>$amt];
      //echo json_encode(['amt'=>$amt]);
    }//end action

    public function actionAvailprefixes(){
      Yii::$app->backend->AjaxVerification($this); 
      $common = new Common;
      $prefixes = $common->getPrefixes($this->module->id);
      
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['prefixes'=> $prefixes];
      //echo json_encode(['prefixes'=> $prefixes]);
    }//end fn
}//END CONTROLLER




