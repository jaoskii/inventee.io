<?php

namespace backend\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
    	$categs = Yii::$app->dashboard->getItemCategories();
    	$items = Yii::$app->frontend->getItems();    	
    	$this->layout = "@app/views/layouts/backend/main";
        return $this->render('index',array('categories' => $categs,'items'=>$items));
    }
}
