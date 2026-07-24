<?php

namespace backend\modules\CM\controllers;

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

	public $access = array(
        'view' => 190,'edit' => 191,'new' => 192,'save' => 193,'change' => 194,
        'delete' => 195,'print' => 196,'lock' => 197,'unlock' => 198,
        'post' => 199,'unpost' => 200,'denydetails' => 201,
        'changeamount' => 202,'changedisc'=>3303,
        'clickadditem'=>817,'clickedititem'=>818,'clickdeleteitem'=>819);


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


    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
        // echo $sql; return 0;
        $type = "";
        if(isset($_POST['type'])){
          $type = $_POST['type'];
        }//end if

        return Yii::$app->automator->generateCMStockview($sql,$type);
    }//end function


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

    //USED BY SEARCHING OF WAREHOUSE ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionWarehouselookupsearch(){
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
    $uom = $_GET['uom'];
    $whcode = $_GET['whcode'];
    $whname = $_GET['wh'];
    $itemamt =str_replace(",","",$_GET['amt']); 
    $uomfactor = $_GET['uomfactor'];
    $disc = $_GET['disc'];
    $trno = $_GET['trno'];

    $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);
    $computeddata = Yii::$app->backend->computestock($itemamt,$disc,$isqty,$uomfactor,$this);
    $primarydata[0]['ext'] = $computeddata['ext'];
    $primarydata[0]['rrqty'] = $computeddata['qty'];
    $primarydata[0]['qty'] = $isqty;
    $primarydata[0]['amt'] = $computeddata['amt'];
    
    $sql = "select rrstatus.cost from rrstatus where 
            rrstatus.itemid = ".$primarykey." and rrstatus.cost <> 0 
            order by rrstatus.trno desc limit 1"; 

    $latestcost = Yii::$app->sbccommon->datareader($sql);
              
    if(empty($latestcost)){
      $primarydata[0]['cost'] = 0;
    }else{
      $primarydata[0]['cost'] = $latestcost;
    }//end if
    
    $primarydata[0]['disc'] = $disc;
    $primarydata[0]['isamt'] = $itemamt;
    $primarydata[0]['uom'] = $uom;
    $primarydata[0]['uomfactor'] = $uomfactor;
    $primarydata[0]['whcode'] = $whcode;
    $primarydata[0]['whname'] = $whname;
    $primarydata[0]['loc'] = $_GET['loc'];
    $primarydata[0]['expiry'] = $_GET['expiry'];
    $primarydata[0]['rem'] = $_GET['rem'];
    $primarydata[0]['trno'] = $trno;


    $moduledata["barcode"]= $primarydata[0]["barcode"];
    $moduledata["itemid"]= $primarydata[0]["itemid"];
    $moduledata["category"]= $primarydata[0]["category"];
    $moduledata["groupid"]= $primarydata[0]["groupid"];

    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'PANDATOOLS':
        $moduledata["itemname"] = Yii::$app->backend->panda_appendItemname($moduledata['barcode'],$primarydata[0]["itemname"]);
      break;
      
      default:
        $moduledata["itemname"]= $primarydata[0]["itemname"];
      break;
    }//end if
      
    $moduledata["uom"]= $primarydata[0]["uom"];
    $moduledata["isamt"]= $primarydata[0]["isamt"];
    $moduledata["ext"]= $primarydata[0]["ext"];
    $moduledata["disc"]= $primarydata[0]["disc"];
    $moduledata["rem"]= $primarydata[0]["rem"];
    $moduledata["qty"]= $primarydata[0]["qty"];
    $moduledata["rrqty"]= $primarydata[0]["rrqty"];
    $moduledata["amt"]= $primarydata[0]["amt"];
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
    $moduledata["kgs"]= 0;

    $returndata = Yii::$app->webprocess->savingstock($this,$this->access['save'],$moduledata);
    $return['stockline']['gvrow-'.$returndata['line']] = $returndata;
    $return['line'] = $returndata['line'];          
    
    
    Yii::$app->response->format = Response::FORMAT_JSON;
    return $return;
   //echo json_encode($return);

        
    } catch (ErrorException $e) {
        echo $e;
    }
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
   }//END SHOW STOCK

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

   
   public function actionLoaditembal() {
    Yii::$app->backend->AjaxVerification($this);
    $params = $_POST;
    $params['controller'] = $this;
    return Yii::$app->automator->automateItembal($params);
   }

  public function actionLoadterms() {
    Yii::$app->backend->AjaxVerification($this);
    $params = $_POST;
    $params['controller'] = $this;
    return Yii::$app->automator->automateTermslookup($params);
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


    public function actionRequestdistro() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateDistro($params);
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
    
    public function actionSjtaglookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        // var_dump($params);
        // return 0;
        return Yii::$app->automator->automateSjtaglookup($params);
    }//end action

}//END CONTROLLERR