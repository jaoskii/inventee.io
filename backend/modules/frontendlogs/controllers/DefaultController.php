<?php
namespace backend\modules\frontendlogs\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class DefaultController extends Controller{
//TODO: MAKE THIS CONTROLLER ACCESS AVAIALABLE ON JAVASCRIPT TO BE USED ON EVENTS
//THESE ACCESS ARRAY IS USED TO DETERMINE ACCESS INDEX ON ATTRIBUTES
	public $access = array(
        'view' => 152 ,'edit' => 153,'new' => 154,
        'save' => 155,'change' => 156,'delete' => 157,
        'print' => 158,'lock' => 159,'unlock' => 160,
        'denyamount' => 161,'crlimit'=>162,'post' => 163,'unpost' => 164,);
    
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
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            //$data =  Yii::$app->backend->retrieveFrontendLogs('2016-01-01','2016-12-31','VIEW_ITM_DETAIL');  
            //var_dump($data);
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionLoadflogs(){
        $params = $_GET;
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
        $data =  Yii::$app->backend->retrieveFrontendLogs($params['dateone'],$params['datetwo'],$params['type']);  
        echo json_encode(array('logdata'=>$data));
    }//end function

    public function actionRemovelogs(){
        $params = $_GET;
        
        if($params['type'] == "SELECTED"){
            $params['logid'] = Yii::$app->backend->sanitize($params['logid'],'ARRAY');
            $params['type'] = Yii::$app->backend->sanitize($params['type'],'DEFAULT');
        }else{
            $params = Yii::$app->backend->sanitize($params,'ARRAY');
        }

        if($params['type'] == "FILTERED"){
            $additionalparams = array('date1'=>$params['date1'],'date2'=>$params['date2'],'logtype'=>$params['logtype']);
        }else{
            $additionalparams = "";
        }

        $data = Yii::$app->backend->deleteFrontendLogs($params['logid'],$params['type'],$additionalparams);
        echo json_encode(array('status'=>$data['status'],'msg'=>$data['msg']));
    }

}//end controller
