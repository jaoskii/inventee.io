<?php

namespace backend\modules\scprovince\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Default controller for the `scprovince` module
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

    public function actionLoadprovince() {
    	$sql = "select prov.id, prov.trid, prov.name as provname, tr.name as trname from scprovince as prov left join scterritory as tr on prov.trid = tr.id";

    	$query = Yii::$app->db->createCommand($sql)->queryAll();
    	$count = sizeof($query);
    	$data = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
                'pagination'=>false
            ]);
    	echo Gridview::widget([
          'dataProvider' => $data,
          'columns' => [
          	[
              'label' => 'TERRITORY',
              'attribute' => 'trname',
              'value' => function($data) {
                return $data['trname'];
              },
            ],
            [
              'label' => 'PROVINCE',
              'attribute' => 'provname',
              'value' => function($data) {
                return $data['provname'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditscprov btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id'], 'trid'=>$data['trid'],'name'=>$data['provname']]);
                },
                'delete' => function($url,$data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeletescprov btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id']]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionLoadscprovtr() {
    	$tr = Yii::$app->db->createCommand("select id,name from scterritory")->queryAll();
    	if(!empty($tr)) {
    		return json_encode($tr);
    	}
    }

    public function actionSavescprov() {
    	$id = $_REQUEST['id'];
    	$trid = $_REQUEST['trid'];
    	$name = $_REQUEST['name'];
    	$type = $_REQUEST['type'];
    	if($type == 'new') {
    		Yii::$app->db->createCommand("insert into scprovince(trid,name) values('$trid','$name')")->execute();
    		echo "Saved";
    	} else {
    		Yii::$app->db->createCommand("update scprovince set trid = '$trid', name = '$name' where id = '$id'")->execute();
    		echo "Updated";
    	}
    }

    public function actionRemovescprovince() {
    	$id = $_REQUEST['id'];
    	Yii::$app->db->createCommand("delete from scprovince where id = '$id'")->execute();
    }
}
