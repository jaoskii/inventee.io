<?php

namespace backend\modules\scterritory\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Default controller for the `scterritory` module
 */
class DefaultController extends Controller
{
    public $access = array(
        'view' => 634);

	//TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',['moduleid'=>$moduleid]);
    }

    public function actionLoadterritory() {
    	$sql = "select id,name from scterritory";
    	$query = Yii::$app->db->createCommand($sql)->queryAll();
    	$count = sizeof($query);
    	$data = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
            ]);
    	echo Gridview::widget([
          'dataProvider' => $data,
          'columns' => [
            [
              'label' => 'NAME',
              'attribute' => 'name',
              'value' => function($data) {
                return $data['name'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditterritory btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id'],'name'=>$data['name']]);
                },
                'delete' => function($url,$data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeleteterritory btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id']]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionSaveterritory() {
    	$id = $_REQUEST['id'];
    	$name = $_REQUEST['name'];
    	$type = $_REQUEST['type'];
    	if($type == 'new') {
    		Yii::$app->db->createCommand("insert into scterritory(name) values('$name')")->execute();
    		echo "Saved";
    	} else {
    		Yii::$app->db->createCommand("update scterritory set name = '$name' where id = '$id'")->execute();
    		echo "Updated";
    	}
    }

    public function actionRemoveterritory() {
    	$id = $_REQUEST['id'];
    	Yii::$app->db->createCommand("delete from scterritory where id = '$id'")->execute();
    }
}
