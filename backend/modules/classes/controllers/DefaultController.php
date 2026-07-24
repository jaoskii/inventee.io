<?php

namespace backend\modules\classes\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

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

   	public function actionLoadclasses() {
   		$sql = "select * from class_masterfile";
    	$query = Yii::$app->db->createCommand($sql)->queryAll();
    	$count = sizeof($query);
    	$data = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
                // 'key' => 'route_id',
            ]);
    	echo Gridview::widget([
          'dataProvider' => $data,
          'id' => 'routegrid',
          'columns' => [
            [
              'label' => 'NAME',
              'attribute' => 'class_name',
              'value' => function($data) {
                return $data['class_name'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditclass btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['class_id'],'classname'=>$data['class_name'],'classcode'=>$data['class_code']]);
                },
                'delete' => function($url,$data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeleteclassmaster btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['class_id']]);
                }
              ]
            ]
          ]
        ]);
   	}

   	public function actionSaveclass() {
   		$classid = $_REQUEST['classid'];
   		$classcode = $_REQUEST['classcode'];
   		$classname = $_REQUEST['classname'];
   		$type = $_REQUEST['type'];

   		if($type == 'new') {
   			Yii::$app->sbccommon->execqry("insert into class_masterfile(class_code,class_name) values('$classcode','$classname')");
   			echo "Class Saved";
   		} else {
   			Yii::$app->sbccommon->execqry("update class_masterfile set class_code = '$classcode', class_name = '$classname' where class_id = '$classid'");
   			echo "Class Updated";
   		}
   	}

   	public function actionRemoveclass() {
   		$classid = $_REQUEST['line'];
   		Yii::$app->sbccommon->execqry("delete from class_masterfile where class_id = '$classid'");
   		echo "Class Deleted";
   	}
}
