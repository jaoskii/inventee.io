<?php

namespace backend\modules\status\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Default controller for the `status` module
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

    public function actionLoadstatus() {
    	$sql = "select * from status_masterfile";
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
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditstatus btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id'],'name'=>$data['name'],'code'=>$data['code']]);
                },
                'delete' => function($url,$data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeletestatus btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id']]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionSavestatus() {
    	$id = $_REQUEST['id'];
    	$code = $_REQUEST['code'];
    	$name = $_REQUEST['name'];
    	$type = $_REQUEST['type'];
    	if($type == 'new') {
    		Yii::$app->db->createCommand("insert into status_masterfile values(0,'$code','$name')")->execute();
    		echo "Saved";
    	} else {
    		$sql = "update status_masterfile set code = '$code', name = '$name' where id = '$id'";
    		Yii::$app->db->createCommand($sql)->execute();
    		echo "Updated";
    	}
    }

    public function actionRemovestatus() {
    	$id = $_REQUEST['id'];
    	Yii::$app->db->createCommand("delete from status_masterfile where id = '$id'")->execute();
    }
}
