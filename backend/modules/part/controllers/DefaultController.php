<?php

namespace backend\modules\part\controllers;

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
            $status = Yii::$app->sbccommon->execqry("insert into part_masterfile(part_name) values('{$params['Name']}')");
            $data = Yii::$app->sbccommon->opentable("select part_id as line, part_code as Code, part_name as Name from part_masterfile order by part_id desc limit 1");

            if($status){
                $msg = "Successfully added!";
            }else{
                $msg = "Error inserting item part, Please try again.";
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        } else {

            $qrychecker = "select count(itemid) as counter from item where part = " . $params['line'];
            $counter = Yii::$app->sbccommon->datareader($qrychecker);

            if($counter == 0){
                $status = Yii::$app->sbccommon->execqry("update part_masterfile set part_name='{$params['Name']}' where part_id={$params['line']}");
                $data = Yii::$app->sbccommon->opentable("select part_id as line, part_code as Code, part_name as Name from part_masterfile where part_id = '{$params['line']}'");

                if($status){
                    $msg = "Successfully Updated!";
                }else{
                    $msg = "Error updating item part, Please try again.";
                }//end if
            }else{
                $data = Yii::$app->sbccommon->opentable("select part_id as line, part_code as Code, part_name as Name from part_masterfile where part_id = '{$params['line']}'");
                $status = false;
                $msg = 'Error Updating item part. Already connected to other masterfile.';
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if
    }//end fn


    public function actionDeletemasteritem() {
        $checkqry="select distinct part from item where part='{$_GET['line']}'";


        $check=Yii::$app->sbccommon->opentable($checkqry);
        if(empty($check)) {
            if(Yii::$app->sbccommon->execqry("delete from part_masterfile where part_id = '{$_GET['line']}'")) {
                $msg = "Successfully removed part.";
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            }else{
                $msg = "Successfully removed part.";

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            }//end if
        }else{
            $status = false;
            $msg = "Can`t delete part. Already referenced to a Stockcard Item.";

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$status,'msg'=>$msg];
            //return json_encode(['status'=>$status,'msg'=>$msg]);
        }//end if        
    }//end fn
}
