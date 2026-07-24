<?php

namespace backend\modules\commission\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Default controller for the `commission` module
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

    public function actionLoadcommlookup() {
      $sql = "select id,code,name from commission_masterfile";
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
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{view}',
              'buttons' => [
                'view' => function($url, $data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-eye"></i>','javascript:return(0);',['title'=>'View','class'=>'btnviewcomm btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;', 'id'=>$data['id'],'name'=>$data['name'],'code'=>$data['code']]);
                },
              ]
            ],
            [
              'label' => 'CODE',
              'attribute' => 'code',
              'value' => function($data) {
                return $data['code'];
              },
            ],
            [
              'label' => 'NAME',
              'attribute' => 'name',
              'value' => function($data) {
                return $data['name'];
              },
            ],
          ]
        ]);
    }

    public function actionLoadcommission() {
      $comid = $_REQUEST['comid'];
    	$sql = "select id,comid,`from`,`to`,rate,piece from commission_detail where comid = '$comid'";
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
              'label' => 'FROM',
              'attribute' => 'from',
              'value' => function($data) {
                return $data['from'];
              },
            ],
            [
              'label' => 'TO',
              'attribute' => 'to',
              'value' => function($data) {
                return $data['to'];
              },
            ],
            [
              'label' => 'RATE',
              'attribute' => 'rate',
              'value' => function($data) {
                return $data['rate'];
              },
            ],
            [
              'label' => 'PIECE',
              'attribute' => 'piece',
              'value' => function($data) {
                return $data['piece'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditcommdet btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id'], 'comid'=>$data['comid'], 'from'=>$data['from'],'to'=>$data['to'],'rate'=>$data['rate'],'piece'=>$data['piece']]);
                },
                'delete' => function($url,$data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeletecommdet btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id']]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionRemovecommdet() {
      $id = $_REQUEST['id'];
      Yii::$app->db->createCommand("delete from commission_detail where id = '$id'")->execute();
    }

    public function actionSavecomdetail() {
      $comid = $_REQUEST['comid'];
      $from = $_REQUEST['from'];
      $to = $_REQUEST['to'];
      $rate = $_REQUEST['rate'];
      $piece = $_REQUEST['piece'];
      $type = $_REQUEST['type'];
      $id = $_REQUEST['comdetid'];
      if($type == 'new') {
        Yii::$app->db->createCommand("insert into commission_detail(comid,`from`,`to`,rate,piece) values('$comid','$from','$to','$rate','$piece')")->execute();
      } else {
        Yii::$app->db->createCommand("update commission_detail set `from` = '$from', `to` = '$to', rate = '$rate', piece = '$piece' where id = '$id'")->execute();
      }
    }

    public function actionSearchcom() {
      $code = $_REQUEST['code'];
      $query = Yii::$app->db->createCommand("select id,code,name from commission_masterfile where code = '$code'")->queryAll();
      if(!empty($query)) {
        return json_encode($query);
      } else {
        return "";
      }
    }

    public function actionSavecomm() {
    	$id = $_REQUEST['id'];
    	$code = $_REQUEST['code'];
    	$name = $_REQUEST['name'];
    	$type = $_REQUEST['type'];

    	if($type == 'new') {
    		$sql = "insert into commission_masterfile(code,name) values('$code','$name')";
    		Yii::$app->db->createCommand($sql)->execute();
    		echo "Saved";
    	} else {
    		$sql = "update commission_masterfile set code = '$code', name = '$name' where id = '$id'";
    		Yii::$app->db->createCommand($sql)->execute();
    		echo "Updated";
    	}
    }

    public function actionRemovecomm() {
    	$id = $_REQUEST['id'];
    	Yii::$app->db->createCommand("delete from commission_masterfile where id = '$id'")->execute();
    }
}
