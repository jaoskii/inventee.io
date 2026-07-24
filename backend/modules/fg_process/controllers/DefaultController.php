<?php

namespace backend\modules\fg_process\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\base\ErrorException;

class DefaultController extends Controller
{
	public $access = array('view' => 11);

	//TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
    	$this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',['moduleid'=>$moduleid]);
    }

    public function actionBuildmasterfilegrid() {
        Yii::$app->backend->AjaxVerification($this);
        $params['controller'] = $this;
        $params['x'] = '';
        return Yii::$app->automator->automateMasterfileGrid($params); 
    }

    public function actionSavemaster() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        if($params['line'] == 0) {
        	$status = Yii::$app->sbccommon->execqry("insert into fg_process(code,name) values('{$params['Code']}', '{$params['Name']}')");
            $data = Yii::$app->sbccommon->opentable("select id as line, code as Code, name as Name from fg_process order by id desc limit 1");
            
            if($status){
                $msg = "Successfully added!";
            }else{
                $msg = "Error inserting FG Process, Please try again.";
            }//end if

            return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);

        } else {
        	$status = Yii::$app->sbccommon->execqry("update fg_process set code = '{$params['Code']}', name = '{$params['Name']}' where id = '{$params['line']}'");
        	$data = Yii::$app->sbccommon->opentable("select id as line, code as Code, name as Name from fg_process where id = '{$params['line']}'");
            
            if($status){
                $msg = "Successfully Updated!";
            }else{
                $msg = "Error updating FG Process, Please try again.";
            }//end if

            return jsn_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if
    }


    public function actionDeletemasteritem() {
    	if(Yii::$app->sbccommon->execqry("delete from fg_process where id = '{$_GET['line']}'")) {
    		return "success";
    	} else {
    		return "failed";
    	}
    }
}
