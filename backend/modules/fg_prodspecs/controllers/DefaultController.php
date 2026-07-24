<?php

namespace backend\modules\fg_prodspecs\controllers;

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
    public $access = array('view' => 11,'edit' => 12,
		'save' => 14, 'delete' => 16);

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

	public function actionBuildproductiongrid() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateProductionGrid($params); 
    }

    public function actionSaveprod() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');

        if($params['line'] == 0) {
        	$status = Yii::$app->sbccommon->execqry("insert into fg_prodspecs(code,prodspecs) values('{$params['code']}', '{$params['name']}')");
            $data = Yii::$app->sbccommon->opentable("select id as line, code, prodspecs as name from fg_prodspecs order by id desc limit 1");
            
            if($status){
                $msg = "Successfully added!";
            }else{
                $msg = "Error inserting FG Product Specifications, Please try again.";
            }//end if

            return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        } else {
            
        	$status = Yii::$app->sbccommon->execqry("update fg_prodspecs set code = '{$params['code']}', prodspecs = '{$params['name']}' where id = '{$params['line']}'");
        	$data = Yii::$app->sbccommon->opentable("select id as line, code, prodspecs as name from fg_prodspecs where id = '{$params['line']}'");
            if($status){
                $msg = "Successfully Updated!";
            }else{
                $msg = "Error updating FG Product Specifications, Please try again.";
            }//end if

            return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if
    }

    public function actionDeleteproditem() {
    	
    	if($_GET['line'] != ""){
    		$status = Yii::$app->sbccommon->execqry("delete from fg_prodspecs where id = '{$_GET['line']}'");

    		if($status){
                $msg = "Deleted Successfully!";
                return json_encode(['status'=>'success','msg'=>$msg]);
            }else{
                $msg = "Error deleting FG Product Specifications, Please try again.";
                return json_encode(['status'=>'failed','msg'=>$msg]);
            }//end if

    	}
    }
}
