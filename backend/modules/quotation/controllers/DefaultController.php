<?php

namespace backend\modules\quotation\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use yii\base\ErrorException;
//FOR TESTING PURPOSES
use app\models\Item;

class DefaultController extends Controller
{
	public $access = array(
        'view' => 3213 ,'edit' => 3214,'new' => 3215,
        'save' => 3216,'change' => 3217,'delete' => 3218,
        'print' => 3219,'lock' => 3220,'unlock' => 3221,
        'changeamount' => 3222,'crlimit'=>3223,'post' => 3224,'unpost' => 3225,
        'clickadditem'=>3226,'clickedititem'=>3227,'clickdeleteitem'=>3228);

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

    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
        
        $type = "";
        if(isset($_POST['type'])){
          $type = $_POST['type'];
        }//end if
        return Yii::$app->automator->generateQuoteStockview($sql,$type);
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

    public function actionSavehead(){
      try {
        
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
      } catch (ErrorException $e) {
          echo $e;
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
            echo json_encode(array('moduledata' => $return['data'],'istransposted'=>$return['istransposted']));
        }                               
    }

    public function actionItemlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateItemlookupGV($params);
    }


    public function actionReqprice(){
      try {
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
        
      } catch (ErrorException $e) {
        echo $e;
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
           echo json_encode(array('uom'=>$return['data']));
        }                                       
    }


    public function actionPulldata(){

      try {
        Yii::$app->backend->AjaxVerification($this);

        $primarykey =$_GET['primarykey'];
        $type = $_GET['type'];
        $isqty = $_GET['qty'];
        // $whcode = $_GET['whcode'];
        $whname = $_GET['wh'];
        $itemamt =str_replace(",","",$_GET['amt']); 
        // $disc = $_GET['disc'];
        $trno = $_GET['trno'];
        $uomfactor = $_GET['uomfactor'];
        // $uom = $_GET['uom'];


        $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);

        $computeddata = Yii::$app->backend->computestock($itemamt,$disc,$isqty,$uomfactor,$this);


        $primarydata[0]['trno'] = $trno;
        // $primarydata[0]['ext'] = $computeddata['ext'];
        $primarydata[0]['iss'] = $computeddata['iss'];
        $primarydata[0]['isqty'] = $isqty;
        $primarydata[0]['amt'] = $computeddata['amt'];
        //WTODO: [KIM][2019.11.29][remove disc, uom, ext]
        // $primarydata[0]['disc'] = $disc;
        $primarydata[0]['isamt'] = $itemamt;
        // $primarydata[0]['uom'] = $uom;
        $primarydata[0]['uomfactor'] = $uomfactor;
        // $primarydata[0]['whcode'] = $whcode;
        $primarydata[0]['whname'] = $whname;
        $primarydata[0]['loc'] = $_GET['loc'];
        $primarydata[0]['expiry'] = $_GET['expiry'];
        $primarydata[0]['rem'] = $_GET['rem'];
        
        $moduledata["barcode"]= $primarydata[0]["barcode"];
        $moduledata["itemid"]= $primarydata[0]["itemid"];
        $moduledata["category"]= $primarydata[0]["category"];
        $moduledata["groupid"]= $primarydata[0]["groupid"];
      
        $moduledata["itemname"]= $primarydata[0]["itemname"];
      
        // $moduledata["uom"]= $primarydata[0]["uom"];
        $moduledata["isamt"]= $primarydata[0]["isamt"];
        // $moduledata["ext"]= $primarydata[0]["ext"];
        //WTODO: [KIM][2019.11.29][remove disc,ext,uom]
        // $moduledata["disc"]= $primarydata[0]["disc"];
        $moduledata["rem"]= $primarydata[0]["rem"];
        $moduledata["iss"]= $primarydata[0]["iss"];
        $moduledata["isqty"]= $primarydata[0]["isqty"];
        $moduledata["amt"]= $primarydata[0]["amt"];
        $moduledata["uomfactor"]= $primarydata[0]["uomfactor"];
        // $moduledata["whcode"]= $primarydata[0]["whcode"];
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
        echo json_encode($return);
      }catch (ErrorException $e) {
          echo json_encode(array('sbcerror' => 1,'stacktrace'=>$e));
      }//end try
    }//END PULL DATA

    public function actionComputestock(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        
        $return = Yii::$app->sbccontroller->sbcComputestock($this,$params);  
        // echo 'controller';
        // return 9;

        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('computeddata' => $return['data']));
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
            echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']));
        }                                       
    }//END DELETE

    public function actionSavestock(){
      Yii::$app->backend->AjaxVerification($this);    
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavestock($this,$params);  
        
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }                                       
    }//END 

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
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'SOUTHCENTRAL':
                  echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'isapproved'=>$return['isapproved'],
                    'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
                break;

                default:
                    echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
                    'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
                break;
            }//end swtich
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

   public function actionVoiditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcVoidItem($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('voiding'=>$return['data']));
        }//end function
    }//end function

    public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);  
                                         
    }


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

}
