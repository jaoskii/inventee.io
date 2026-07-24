<?php

namespace backend\modules\itemclass\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;
use yii\web\Response;

class DefaultController extends Controller{

    public $access = array('view' => 11);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',array('moduleid'=>$moduleid));
    }//END ACTION INDEX
    
    public function actionBuildmasterfilegrid() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateMasterfileGrid($params); 
    }

    public function actionSavemaster() {
        try {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        
        if($params['line'] == 0) {
            $status = Yii::$app->sbccommon->execqry("insert into item_class(cl_name) values('{$params['Name']}')");
            $data = Yii::$app->sbccommon->opentable("select cl_id as line,cl_code as Code,cl_name as Name from item_class order by cl_id desc limit 1");

            if($status){
                $msg = "Successfully added!";
            }else{
                $msg = "Error inserting item class, Please try again.";
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        } else {
            $qrychecker = "select count(itemid) as counter from item where class = " . $params['line'];
            $counter = Yii::$app->sbccommon->datareader($qrychecker);
            
            if($counter == 0){
                $status = Yii::$app->sbccommon->execqry("update item_class set cl_name='{$params['Name']}' where cl_id={$params['line']}");
                $data = Yii::$app->sbccommon->opentable("select cl_id as line,cl_code as Code,cl_name as Name from item_class where cl_id = '{$params['line']}'");

                if($status){
                    $msg = "Successfully Updated!";
                }else{
                    $msg = "Error updating item class, Please try again.";
                }//end if
            }else{
                $data = Yii::$app->sbccommon->opentable("select cl_id as line,cl_code as Code,cl_name as Name from item_class where cl_id = '{$params['line']}'");
                $status = false;
                $msg = 'Error Updating item class. Already connected to other masterfile.';
            }//end if
            
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if

            
        } catch (ErrorException $e) {
            echo $e;
        }
    }


    public function actionDeletemasteritem() {
        $checkqry="select distinct class from item where class='{$_GET['line']}'";


        $check=Yii::$app->sbccommon->opentable($checkqry);
        if(empty($check)) {
            if(Yii::$app->sbccommon->execqry("delete from item_class where cl_id = '{$_GET['line']}'")) {
                $msg = "Successfully removed item class.";
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            } else {
                $msg = "Error removing item class. Please try again.";
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            }//end if
        }else{
            $status = false;
            $msg = "Can`t delete Item Class. Already referenced to a Stockcard Item.";
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>[],'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>[],'status'=>$status,'msg'=>$msg]);
        }//end if
        
    }//end f
}
