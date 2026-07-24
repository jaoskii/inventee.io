<?php

namespace backend\modules\chatsupport\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{
    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }//end 

    public function actionIndex(){
    	try {
    		$this->layout = "@app/views/layouts/backend/main";
	    	$moduleid = $this->module->id;
	      	Yii::$app->view->params['moduleid'] = $moduleid;
	      	return $this->render('index',array('moduleid'=>$moduleid));
    	} catch (ErrorException $e) {
    		echo $e;
    	}//end try catch
    }//END ACTION INDEX

}//end controller
