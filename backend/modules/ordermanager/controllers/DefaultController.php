<?php

namespace backend\modules\ordermanager\controllers;

use Yii;
use yii\web\Controller;

//exported MODELS
use yii\helpers\Url;
use yii\base\ErrorException; 


class DefaultController extends Controller
{

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


/*    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action)
    {
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    */

//FOR DASHBOARD LANDING PAGE
    public function actionIndex(){
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $orders = Yii::$app->backend->retrieveFrontendOrder('','');
        return $this->render('index',array('moduleid'=>$moduleid,'orders'=>$orders));
    }//END ACTION INDEX

    public function actionRetrievefrontendorders(){
        try {
            $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
            $orders = Yii::$app->backend->retrieveFrontendOrder($params['searchstring'],$params['status']);
            echo json_encode(array('orders'=>$orders));
        } catch (ErrorException $e) {
         echo $e;   
        }
    }//end aciton rretrieve order

    public function actionUpdateorderstatuses(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $orders = $_GET['orders'];
            $fstatus = $_GET['status'];
            $error = 0;
            foreach ($orders as $key => $value) {
                $qry = "update sostock set fstatus = '".$fstatus."' where trno = ".$value['trno']." and line = ".$value['line']."";
                $status = Yii::$app->sbccommon->execqry($qry);
                
                if(!$status){
                    $error = $error + 1;
                }//end status

            }//end for each
        $msg = '';
        if($error != 0){
            $msg = 'Something went wrong while updating. Please check order data.';
        }//end if error != 0

        echo json_encode(array('msg'=>$msg));

        } catch (ErrorException $e) {
            echo $e;
        }//end try catch
    }//end fcuntion update order statuses
   
}//end controller

