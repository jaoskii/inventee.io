<?php

namespace backend\modules\route\controllers;

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
        $data = new SqlDataProvider([
                'db' => Yii::$app->db,
                'sql' => "select * from route_masterfile ORDER BY cat_id",
                'pagination' => [ 'pageSize' => 10 ],
            ]);
        return $this->render('index',['moduleid'=>$moduleid]);
    }

    public function actionLoadroutes() {
    	$sql = "select * from route_masterfile";
    	$query = Yii::$app->db->createCommand($sql)->queryAll();
    	$count = sizeof($query);
    	$data = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
                // 'key' => 'route_id',
            ]);
      echo '<br>';
    	echo Gridview::widget([
          'dataProvider' => $data,
          'id' => 'routegrid',
          'columns' => [
            [
              'label' => 'NAME',
              'attribute' => 'route_name',
              'contentOptions' => ['class' => 'qqq'],
              'headerOptions' => ['class' => 'zzz'],
              'value' => function($data) {
                return $data['route_name'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  $url = Url::toRoute('updateroute');
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditroute btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','urlto'=>$url,'id'=>$data['route_id'],'routename'=>$data['route_name'],'routecode'=>$data['route_code']]);
                },
                'delete' => function($url,$data){
                  $url = Url::toRoute('deleteroute');
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeleteroute btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['route_id'],'urlto'=>$url]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionSaveroute() {
    	$routecode = $_REQUEST['rcode'];
    	$routename = $_REQUEST['rname'];
    	$routeid = $_REQUEST['rid'];
    	$type = $_REQUEST['type'];

    	if($type == 'new') {
    		Yii::$app->sbccommon->execqry("insert into route_masterfile (route_code,route_name) values('$routecode','$routename')");
    		echo "Route Saved";
    	} else {
    		Yii::$app->sbccommon->execqry("update route_masterfile set route_code = '$routecode', route_name = '$routename' where route_id = '$routeid'");
    		echo "Route Updated";
    	}
    }

    public function actionDeleteroute() {
    	if(isset($_REQUEST['line'])) {
    		$routeid = $_REQUEST['line'];

    		Yii::$app->sbccommon->execqry("delete from route_masterfile where route_id = '$routeid'");
    		echo "success";
    	} else {
    		echo "no record found.";
    	}

    }
}
