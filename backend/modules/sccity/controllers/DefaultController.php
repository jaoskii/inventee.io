<?php

namespace backend\modules\sccity\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Default controller for the `sccity` module
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

    public function actionLoadsccity() {
    	$sql = "select c.id, c.code, c.provid, c.name as cityname, prov.name as provname from sccity as c left join scprovince as prov on c.provid = prov.id";
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
              'label' => 'CITY CODE',
              'attribute' => 'citycode',
              'value' => function($data) {
                return $data['code'];
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
              'label' => 'CITY',
              'attribute' => 'cityname',
              'value' => function($data) {
                return $data['cityname'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditsccity btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id'], 'code'=>$data['code'], 'provid'=>$data['provid'],'name'=>$data['cityname']]);
                },
                'delete' => function($url,$data){
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeletesccity btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['id']]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionLoadsccityprov() {
    	$tr = Yii::$app->db->createCommand("select id,name from scprovince")->queryAll();
    	if(!empty($tr)) {
    		return json_encode($tr);
    	}
    }

    public function actionSavesccity() {
    	$id = $_REQUEST['id'];
    	$provid = $_REQUEST['provid'];
    	$name = $_REQUEST['name'];
    	$code = $_REQUEST['code'];
    	$type = $_REQUEST['type'];
    	if($type == 'new') {
    		Yii::$app->db->createCommand("insert into sccity(code,provid,name) values('$code','$provid','$name')")->execute();
    		echo "Saved";
    	} else {
    		Yii::$app->db->createCommand("update sccity set code = '$code', provid = '$provid', name = '$name' where id = '$id'")->execute();
    		echo "Updated";
    	}
    }

    public function actionRemovesccity() {
    	$id = $_REQUEST['id'];
    	Yii::$app->db->createCommand("delete from sccity where id = '$id'")->execute();
    }
}
