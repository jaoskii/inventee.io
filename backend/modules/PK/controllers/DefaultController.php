<?php

namespace backend\modules\PK\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;

//FOR TESTING PURPOSES
use app\models\Item;
use app\models\Cntnum;

class DefaultController extends Controller{

	public $access = array('view' => 683,'edit' => 684,'new' => 685,'save' => 686,
        'change' => 687,'delete' => 688,'print' => 689,'lock' => 670,
        'unlock' => 671,'post' => 672,'unpost' => 673,'denydetails' => 674);

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
          echo json_encode(array('moduledata' => $return['data']));
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
          echo json_encode(array('moduledata' => $return['data']));
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
          echo json_encode(array('clientdata' => $return['data']));
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
          echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
          'msg'=>$return['data']['msg'],'istransposted'=>$return['istransposted']));
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
            echo json_encode(array('moduledata' => $return['data']));
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
            echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
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
           echo json_encode(array('searchitems' => $return['data']));
        }                                       
    }

    //USED BY SEARCHING OF CUSTOMER ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionSupplierlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;        
        $return=Yii::$app->sbccontroller->sbcSupplierlookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('searchclient' => $return['data']));
        }                                       
    }

    //USED BY SEARCHING OF ITEM ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionItemlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcItemlookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('searchitems' => $return['data']));
        }                                       
    }

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
           echo json_encode(array('searchitems' => $return['data']));
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
           echo json_encode(array('moduledata' => $return['data']));
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
    $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);
    $computeddata = Yii::$app->backend->computestock($itemamt,0,$isqty,$uomfactor,$this);
    $primarydata[0]['ext'] = $computeddata['ext'];
    $primarydata[0]['qty'] = $computeddata['qty'];
    $primarydata[0]['iss'] = $computeddata['iss'];
    $primarydata[0]['cost'] = $computeddata['cost'];
    $primarydata[0]['rrcost'] = $itemamt;
    $primarydata[0]['uom'] = $uom;
    $primarydata[0]['uomfactor'] = $uomfactor;
    $primarydata[0]['whcode'] = $whcode;
    $primarydata[0]['whname'] = $whname;
    $primarydata[0]['loc'] = $_GET['loc'];
    $primarydata[0]['expiry'] = $_GET['expiry'];
    $primarydata[0]['rem'] = $_GET['rem'];
    echo json_encode(array('primarydata' => $primarydata));
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
           echo json_encode(array('computeddata' => $return['data']));
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
           echo json_encode(array('stockdata' => $return['data']));
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
            echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal']));
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
           echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']));
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

   public function actionLockunlock(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcLockunlock($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
         echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked']));
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
           echo json_encode(array('logs'=>$return['data']));
        }                                       
   }//END ACTION LOG



   public function actionGetitembalance(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetitembalance($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('whdata'=>$return['data'],'postedpobal'=>$return['postedpobal'],
            'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
            'unpostedsobal'=>$return['unpostedsobal']));
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
           echo json_encode(array('terms'=>$return['data']));
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
           echo json_encode(array('uom'=>$return['data']));
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
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('primarydata' => $return['primarydata'],'errmsg'=>$return['errmsg']));
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
           echo json_encode(array('pricedata'=>$return['pricedata']));
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
           echo json_encode(array('searchitems' => $return['searchitems']));
        }                                       
    }//END CONTRA


   public function actionGetlocation(){
      Yii::$app->backend->AjaxVerification($this);
      $barcode = $_GET['barcode'];
      $data = Yii::$app->backend->getAvailableLocation($barcode);
      echo json_encode(array('locations' => $data));
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
           echo json_encode(array('distro'=>$return['distro']));
        }                                       
    }//end distro


   //USED BY SEARCHING OF DOCNO ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionProdordersearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcProdOrderLookup($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            echo json_encode(array('searchitems' => $return['data']));
        }                                       
    }//end function prod search

    public function actionGetpdinfo(){
    	Yii::$app->backend->AjaxVerification($this);
    	$trno = $_GET['trno'];
    	$wh = $_GET['wh'];
    	$docno = $_GET['docno'];
    	$return = Yii::$app->backend->retrieveProductionOrderDetails($trno);
    	echo json_encode(array('docno'=>$docno,'primarydata'=>$return));
    }//end function get pdinfo

}//END CONTROLLERR