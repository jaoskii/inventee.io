<?php

namespace backend\modules\CK\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use yii\base\ErrorException;
use app\models\Postdatedchecks;

class DefaultController extends Controller
{
	public $access = array(
        'view' => 701 ,'edit' => 702,'new' => 703,
        'save' => 704,'delete' => 705,
        'void' => 706,'post' => 707,'unpost' => 708,);
	
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

    	
     if(isset(Yii::$app->session['loggeduser'])){
           $this->layout = "@app/views/layouts/backend/main";
           $moduleid = $this->module->id;
           Yii::$app->view->params['moduleid'] = $moduleid;
           $pdc = new Postdatedchecks;

           $data =  $pdc->openPDC($this,date('Y-m-d'),date('Y-m-d'),$this->access['view']);               
           
           return $this->render('index',array('pdcdata'=>$data,'moduleid'=>$moduleid));

         }else{
             return $this->redirect(Url::to(['/admin/default/login']));
         }//END IF
    }//END ACTION INDEX


    public function actionCustomerlookupsearch(){
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

    public function actionInsertpdc(){
        $pdc = new Postdatedchecks;
        $client = $_GET['client'];
        $clientname = $_GET['clientname'];
        $dateid = $_GET['dateid'];
        $checkdate = $_GET['checkdate'];
        $checkno = $_GET['checkno'];
        $notes = $_GET['notes'];
        //$amount = $_GET['amount'];
        $amount = str_replace(',', '', $_GET['amount']);
        $user=Yii::$app->session['loggeduser']['username'];
        $moduleid = $this->module->id;

        Yii::$app->sbccommon->execqry("insert into postdatedchecks (client,clientname,dateid,checkdate,checkno,amount,createby,createdate,notes) values ('$client','$clientname','$dateid','$checkdate','$checkno',$amount,'$user',CURRENT_TIMESTAMP,'$notes')");
        $data =  $pdc->openPDC($this,$dateid,$dateid,$this->access['view']);               
        echo json_encode(array('pdcdata' => $data));
    }

    public function actionUpdatepdc(){
        $pdc = new Postdatedchecks;        
        $moduleid = $this->module->id;
        $result = $pdc->updatepdc($this,$_GET);
    }

    public function actionLoadpdc(){   
          $moduleid = $this->module->id;
           Yii::$app->view->params['moduleid'] = $moduleid;
           $pdc = new Postdatedchecks;
           $dateid1 = $_GET['dateid1'];
           $dateid2 = $_GET['dateid2'];

           $data =  $pdc->openPDC($this,$dateid1,$dateid2,$this->access['view']);               
           echo json_encode(array('pdcdata' => $data));
         
    }//end loadpdc


   public function actionComparepdclines(){     
    try {
      Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;      
        Yii::$app->sbccontroller->sbcComparepdclines($this,$params);   
    } catch (ErrorException $e) {
      echo $e;
    }
    }//end comparepdclines

    public function actionCanceledit(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];
        $pdc = new Postdatedchecks;

        $pdcdata=$pdc->openPDCline($this,$line);  
        

        if(!empty($pdcdata)){

            $newclient = $pdcdata[0]['client'];
            $newclientname = $pdcdata[0]['clientname'];
            $newdateid = $pdcdata[0]['dateid'];
            $newcheckdate = $pdcdata[0]['checkdate'];
            $newcheckno = $pdcdata[0]['checkno'];
            $newamount = $pdcdata[0]['amount'];
            $newline = $pdcdata[0]['line'];
            $createby  = $pdcdata[0]['createby'];

            $passjson = array('client'=>$newclient,'clientname'=>$newclientname,'dateid'=>$newdateid,'checkdate'=>$newcheckdate,'checkno'=>$newcheckno,'amount'=>$newamount,'line'=>$newline,'createby'=>$createby);            
            
                echo json_encode($passjson);
                

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }//end cancel edit

    public function actionDeletepdc(){
        $pdc = new Postdatedchecks;        
        $moduleid = $this->module->id;
        $line = $_GET['line'];
        $dateid = date('Y-m-d');
        
        $pdcline = $pdc->openPDCline($this,$line);
        
        if ($pdcline[0]['refx']!=0 && $pdcline[0]['linex']!=0){

            echo json_encode(array('return'=>'0','pdcdata' => null));
        }else{
          $result = $pdc->deletepdc($this,$line);
          $data =  $pdc->openPDC($this,$dateid,$dateid,$this->access['view']);
          echo json_encode(array('return'=>'1','pdcdata' => $data));
        }
        
    }//deletepdc

    public function actionVoidpdc(){
        $pdc = new Postdatedchecks;        
        $moduleid = $this->module->id;
        $dateid = date('Y-m-d');
        $result = $pdc->voidpdc($this,$_GET);
        $data =  $pdc->openPDC($this,$dateid,$dateid,$this->access['view']);  
        echo json_encode(array('pdcdata' => $data));
    }

    public function actionPostpdc(){
        $pdc = new Postdatedchecks;        
        $moduleid = $this->module->id;        
        $params = $_GET;
        $dateid = $params['dateid'];
        
        $return=Yii::$app->backend->postpdcChecks($params['params']);
        //$data=$pdc->openPDCline($this,$line);  
        $data =  $pdc->openPDC($this,$dateid,$dateid,$this->access['view']);
        echo json_encode(array('pdcdata' => $data));        
                
    }
}
