<?php

namespace backend\modules\services\controllers;

use Yii;
use yii\web\Controller;
use yii\base\ErrorException;
use yii\helpers\Url;

class DefaultController extends Controller{
    
    public function actionIndex(){
        $this->layout = "@app/views/layouts/backend/servicelayout";
        return $this->render('index');
    }//end fuc
}
