<?php

namespace backend\modules\city\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Default controller for the `city` module
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

    public function actionLoadcity() {
    	$sql = "select * from city_masterfile";
    	$query = Yii::$app->db->createCommand($sql)->queryAll();
    	$count = sizeof($query);
    	$data = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
                // 'key' => 'route_id',
            ]);
    	echo Gridview::widget([
          'dataProvider' => $data,
          'columns' => [
            [
              'label' => 'NAME',
              'attribute' => 'city_name',
              'value' => function($data) {
                return $data['city_name'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditcity btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['city_id'],'cityname'=>$data['city_name'],'citycode'=>$data['city_code']]);
                },
                'delete' => function($url,$data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeletecity btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['city_id']]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionSavecity() {
    	$code = $_REQUEST['code'];
    	$name = $_REQUEST['name'];
    	$type = $_REQUEST['type'];
    	$id = $_REQUEST['id'];
    	if($type == 'new') {
    		Yii::$app->db->createCommand("insert into city_masterfile(city_code,city_name) values('$code','$name')")->execute();
    		echo "Saved";
    	} else {
    		Yii::$app->db->createCommand("update city_masterfile set city_code = '$code', city_name = '$name' where city_id = '$id'")->execute();
    		echo "Updated";
    	}
    }

    public function actionRemovecity() {
    	if(isset($_REQUEST['id'])) {
    		$id = $_REQUEST['id'];
    		Yii::$app->db->createCommand("delete from city_masterfile where city_id = '$id'")->execute();
    	}
    }
}
