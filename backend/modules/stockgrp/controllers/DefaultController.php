<?php

namespace backend\modules\stockgrp\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\base\ErrorException;
use yii\grid\GridView;
use yii\helpers\Html;

use yii\web\Response;

/**
 * Default controller for the `stockgrp` module
 */
class DefaultController extends Controller{
    public $access = array('view' => 11);

	//TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionBuildmasterfilegrid() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateMasterfileGrid($params); 
    }

    public function actionIndex()
    {
    	$this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',['moduleid'=>$moduleid]);
    }

    public function actionSavemaster() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        if($params['line'] == 0) {
            $status = Yii::$app->sbccommon->execqry("insert into stockgrp_masterfile(stockgrp_name) values('{$params['Name']}')");
            $data = Yii::$app->sbccommon->opentable("select stockgrp_id as line,stockgrp_code as Code,stockgrp_name as Name from stockgrp_masterfile order by stockgrp_id desc limit 1");

            if($status){
                $msg = "Successfully added!";
            }else{
                $msg = "Error inserting item group, Please try again.";
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        } else {

            $qrychecker = "select count(itemid) as counter from item where groupid = " . $params['line'];
            $counter = Yii::$app->sbccommon->datareader($qrychecker);

            if($counter == 0){
                $status = Yii::$app->sbccommon->execqry("update stockgrp_masterfile set stockgrp_name='{$params['Name']}' where stockgrp_id={$params['line']}");
                $data = Yii::$app->sbccommon->opentable("select stockgrp_id as line, stockgrp_code as Code, stockgrp_name as Name from stockgrp_masterfile where stockgrp_id = '{$params['line']}'");

                if($status){
                    $msg = "Successfully Updated!";
                }else{
                    $msg = "Error updating item group, Please try again.";
                }//end if

            }else{
                $data = Yii::$app->sbccommon->opentable("select stockgrp_id as line, stockgrp_code as Code, stockgrp_name as Name from stockgrp_masterfile where stockgrp_id = '{$params['line']}'");
                $status = false;
                $msg = 'Error Updating item group. Already connected to other masterfile.';
            }//end if
            
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if

    }


    public function actionDeletemasteritem() {
        $checkqry="select distinct groupid from item where groupid='{$_GET['line']}'";
        $check=Yii::$app->sbccommon->opentable($checkqry);
        if(empty($check)) {
            if(Yii::$app->sbccommon->execqry("delete from stockgrp_masterfile where stockgrp_id = '{$_GET['line']}'")) {
                $msg = "Successfully removed Group.";
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            } else {
                $msg = "Error removing group. Please try again.";
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>false,'msg'=>$msg]);
            }//end if
        }else{
            $status = false;
            $msg = "Can`t delete Group. Already referenced to a Stockcard Item.";

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$status,'msg'=>$msg];
            //return json_encode(['status'=>$status,'msg'=>$msg]);
        }//end if
    }//end fn
}
