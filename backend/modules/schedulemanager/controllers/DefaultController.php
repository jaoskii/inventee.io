<?php

namespace backend\modules\schedulemanager\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;


class DefaultController extends Controller{
    

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
            $users = Yii::$app->backend->getUsers(); 
            return $this->render('index',array('moduleid'=>$moduleid,'users'=>$users));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF       
    }//END ACTION INDEX


    public function actionRequestclientview(){
    	Yii::$app->backend->AjaxVerification($this); 
        $userid = $_GET['key'];
    	$allowed = Yii::$app->backend->requestClientView($userid,'ALLOWED');
    	$nallowed = Yii::$app->backend->requestClientView($userid,'NALLOWED');
    	echo json_encode(array('allowed'=>$allowed,'notallowed'=>$nallowed));
    }//end function

    public function actionManageclientaccess(){
        Yii::$app->backend->AjaxVerification($this); 
        $clientid = $_GET['key'];
        $type = $_GET['type'];
        $userid = $_GET['key2'];

        switch ($type) {
            case 'ALLOWED': //SETS IT TO ALLOWED
                $qry = "insert into sched_allowedcustomer (userid,clientid) values(".$userid.",".$clientid.")";
                $status = Yii::$app->sbccommon->execqry($qry);
                $allowed = Yii::$app->backend->requestClientView($userid,'ALLOWED');
                $nallowed = Yii::$app->backend->requestClientView($userid,'NALLOWED');
                echo json_encode(array('allowed'=>$allowed,'notallowed'=>$nallowed));
                break;

            case 'NALLOWED': //SETS IT TO NOT ALLOWED
                $qry = "delete from sched_allowedcustomer where userid=".$userid." and clientid = ".$clientid."";
                $status = Yii::$app->sbccommon->execqry($qry);
                $allowed = Yii::$app->backend->requestClientView($userid,'ALLOWED');
                $nallowed = Yii::$app->backend->requestClientView($userid,'NALLOWED');
                echo json_encode(array('allowed'=>$allowed,'notallowed'=>$nallowed));
                break;
        }//END SWITCH CASE 
    }//end action manageaccess

    

}//end controller 
