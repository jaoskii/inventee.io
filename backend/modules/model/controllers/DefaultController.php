<?php

namespace backend\modules\model\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

use yii\web\Response;

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
            $status = Yii::$app->sbccommon->execqry("insert into model_masterfile(model_name) values('{$params['Name']}')");
            $data = Yii::$app->sbccommon->opentable("select model_id as line, model_code as Code, model_name as Name from model_masterfile order by model_id desc limit 1");
            
            if($status){
                $msg = "Successfully added!";
            }else{
                $msg = "Error inserting model, Please try again.";
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        } else {
            $qrychecker = "select count(itemid) as counter from item where model = " . $params['line'];
            $counter = Yii::$app->sbccommon->datareader($qrychecker);

            if($counter == 0){
                $status = Yii::$app->sbccommon->execqry("update model_masterfile set model_name='{$params['Name']}' where model_id={$params['line']}");
                $data = Yii::$app->sbccommon->opentable("select model_id as line, model_code as Code, model_name as Name from model_masterfile where model_id = '{$params['line']}'");
                
                if($status){
                    $msg = "Successfully Updated!";
                }else{
                    $msg = "Error updating model, Please try again.";
                }//end if
            }else{
                $data = Yii::$app->sbccommon->opentable("select model_id as line, model_code as Code, model_name as Name from model_masterfile where model_id = '{$params['line']}'");
                $status = false;
                $msg = 'Error Updating Model. Already connected to other masterfile.';
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if
    }


    public function actionDeletemasteritem() {
        $checkqry="select distinct model from item where model='{$_GET['line']}'";
        $check=Yii::$app->sbccommon->opentable($checkqry);

        if(empty($check)) {
            if(Yii::$app->sbccommon->execqry("delete from model_masterfile where model_id = '{$_GET['line']}'")) {
                $msg = "Successfully removed model.";

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            } else {
                $msg = "Error removing model. Please try again.";

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>false,'msg'=>$msg]);
            }//end if
        }else{
            $status = false;
            $msg = "Can`t delete model. Already referenced to a Stockcard Item.";

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$status,'msg'=>$msg];
            //return json_encode(['status'=>$status,'msg'=>$msg]);
        }//end if
        
    }//end fn
}
