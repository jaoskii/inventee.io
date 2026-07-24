<?php

namespace backend\modules\inout\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

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
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateMasterfileGrid($params); 
    }

    public function actionSavemaster() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        if($params['line'] == 0) {
        	$status = Yii::$app->sbccommon->execqry("insert into inout_masterfile(mat_release, name) values('{$params['code']}', '{$params['name']}')");
        	$data = Yii::$app->sbccommon->opentable("select id as line, mat_release as code, name from inout_masterfile order by id desc limit 1");
            if($status) {
                $msg = "Successfully added!";
            } else {
                $msg = "Error inserting Input/Output, Please try again.";
            }//end if
            return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        } else {
        	$status = Yii::$app->sbccommon->execqry("update inout_masterfile set name = '{$params['name']}', mat_release = '{$params['code']}' where id = {$params['line']}");
            $data = Yii::$app->sbccommon->opentable("select id as line, mat_release as code, name from inout_masterfile where id = {$params['line']}");
            if($status) {
                $msg = "Successfully Updated!";
            } else {
                $msg = "Error updating Input/Output, Please try again.";
            }//end if
            return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if
    }


    public function actionDeletemasteritem() {
        if(Yii::$app->sbccommon->execqry("delete from inout_masterfile where id = '{$_GET['line']}'")) {
            $msg = "Successfully removed Input/Output.";
            return json_encode(['status'=>true,'msg'=>$msg]);
        } else {
            $msg = "Error removing Input/Output. Please try again.";
            return json_encode(['status'=>false,'msg'=>$msg]);
        }//end if
    }//end fn
}
