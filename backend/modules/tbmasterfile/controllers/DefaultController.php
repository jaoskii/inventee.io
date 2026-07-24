<?php

namespace backend\modules\tbmasterfile\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use yii\base\ErrorException;

class DefaultController extends Controller{


     public $access = array(
        'view' => 22,'edit' => 23,'new' => 24,'save' => 25,
        'change' => 26,'delete' => 27,'print' => 28);

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
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                return $this->render('index',array('moduleid'=>$moduleid));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }
    }//END ACTION INDEX

    public function actionLoadtables() {
    	Yii::$app->backend->AjaxVerification($this);
    	// $params['controller'] = $this;
    	return Yii::$app->automator->loadTables();
    }

    public function actionSavetablegrid() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $data = [];
        if($params['clientid'] == '0') { // new record
            if(Yii::$app->sbccommon->execqry("insert into client(client, clientname, floor, isinactive, istable,
                                            location,acquireddate,warrantexpiry,servicedate,solddisposeddate) 
                                            values('{$params['client']}', '{$params['client']}', '{$params['floor']}', 
                                            '{$params['isinactive']}', 1,'','','','','')")) {
                $data = Yii::$app->sbccommon->opentable("select clientid, client, clientname, floor, isinactive from client where istable = 1 order by clientid desc limit 1");
                $msg = "New Table Saved";
                $status = true;
            }else{
                $msg = "Error Saving Table Record";
                $status = false;
            }
        } else { // update Record
            if(Yii::$app->sbccommon->execqry("update client set client = '{$params['client']}', clientname = '{$params['client']}', floor = '{$params['floor']}', isinactive = '{$params['isinactive']}' where clientid = '{$params['clientid']}'")) {
                $data = Yii::$app->sbccommon->opentable("select clientid, client, clientname, floor, isinactive from client where clientid = '{$params['clientid']}'");
                $msg = "Table Record Updated";
                $status = true;
            } else {
                $msg = "Error Updating Table Record";
                $status = false;
            }//end if
        }//end if
        return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
    }
}//END CONTROLLER