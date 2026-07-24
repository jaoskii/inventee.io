<?php

namespace backend\modules\pizza\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class DefaultController extends Controller{

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        return $this->render('index');
    }//END ACTION INDEX
}//END CONTROLLER