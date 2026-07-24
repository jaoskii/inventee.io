<?php

namespace backend\modules\province\controllers;

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

    public function actionLoadprovince() {
    	$sql = "select * from province_masterfile";
    	$query = Yii::$app->db->createCommand($sql)->queryAll();
    	$count = sizeof($query);
    	$data = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,
            ]);
    	echo Gridview::widget([
          'dataProvider' => $data,
          'id' => 'provgrid',
          'columns' => [
            [
              'label' => 'NAME',
              'attribute' => 'prov_name',
              'value' => function($data) {
                return $data['prov_name'];
              },
            ],
            [
              'class'=>'yii\grid\ActionColumn',
              'header' => 'OPTION',
              'template' => '{update} {delete}',
              'buttons' => [
                'update' => function($url, $data){
                  $url = Url::toRoute('updateprov');
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i>','javascript:return(0);',['title'=>'Edit','class'=>'btneditprov btn btn-social-icon btn-bitbucket','style'=>'width:18px;height:18px;margin-top:-2px;','urlto'=>$url,'id'=>$data['prov_id'],'provname'=>$data['prov_name'],'provcode'=>$data['prov_code']]);
                },
                'delete' => function($url,$data){
                  $url = Url::toRoute('deleteprov');
                  return Html::a('<i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i>','javascript:return(0);',['title'=>'Delete','class'=>'btndeleteprov btn btn-social-icon btn-google','style'=>'width:18px;height:18px;margin-top:-2px;','id'=>$data['prov_id'],'urlto'=>$url]);
                }
              ]
            ]
          ]
        ]);
    }

    public function actionSaveprov() {
    	$provcode = $_REQUEST['provcode'];
    	$provname = $_REQUEST['provname'];
    	$provid = $_REQUEST['provid'];
    	$type = $_REQUEST['type'];

    	if($type == 'new') {
    		Yii::$app->sbccommon->execqry("insert into province_masterfile (prov_code,prov_name) values('$provcode','$provname')");
    		echo "Province Saved";
    	} else {
    		Yii::$app->sbccommon->execqry("update province_masterfile set prov_code = '$provcode', prov_name = '$provname' where prov_id = '$provid'");
    		echo "Province Updated";
    	}
    }

    public function actionDeleteprov() {
    	$line = $_REQUEST['line'];
        Yii::$app->sbccommon->execqry("delete from province_masterfile where prov_id = '$line'");
        echo "success";
    }
}
