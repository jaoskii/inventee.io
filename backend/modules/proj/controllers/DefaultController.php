<?php

namespace backend\modules\proj\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{
    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){
    	$this->layout = "@app/views/layouts/backend/main";
      $moduleid = $this->module->id;
      Yii::$app->view->params['moduleid'] = $moduleid;
      return $this->render('index',['moduleid'=>$moduleid]);
    }

    public function actionSavecostcenter(){
    	Yii::$app->backend->AjaxVerification($this); 
    	$params = Yii::$app->backend->sanitize($_GET,'ARRAY');
    	if($params['line'] != 0){
    		$qry = "update projectmasterfile set code = '".$params['code']."', name = '".$params['name']."' where line ='".$params['line']."'";
        $status = Yii::$app->sbccommon->execqry($qry);
        $line = $params['line'];
    	}else{
    		$qry = "insert into projectmasterfile (code,name) values('".$params['code']."','".$params['name']."')";
      	$status = Yii::$app->sbccommon->execqry($qry);
        $line = Yii::$app->sbccommon->opentable("select line from projectmasterfile order by line desc limit 1");
        $line = $line[0]['line'];
      }
    	if($status){
    		$msg = "Cost center successfully saved!";
    	}else{
    		$msg = "Error adding/editing this cost center! Please try again.";
    	}//end if

    	echo json_encode(['status'=>$status,'msg'=>$msg,'line'=>$line]);
    }//end

    public function actionGetcostcenters(){
    	Yii::$app->backend->AjaxVerification($this); 
    	$centers = Yii::$app->backend->getCostCenters();
    	echo json_encode(['centers'=>$centers]);
  	}//end function 

    public function actionLoadcostcenters() {
      $qry = "select line,code,name from projectmasterfile";
      $params = [
        'sql' => $qry,
        'tableid' => 'costcentertbl',
        'key' => 'line',
        'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
        'txtclass' => 'costcentertxt',
        'column' => [
          [
            'name' => 'code',
            'editable' => true,
            'type' => 'text',
            'class' => 'col-codes aimslabel'
          ],[
            'name' => 'name',
            'editable' => true,
            'type' => 'text',
            'class' => 'col-codes aimslabel'
          ],[
            'name' => 'line',
            'hidden' => 'true',
            'default' => '0',
            'class' => 'txthidden'
          ]
        ],
        'buttons' => [
          [
            'name' => '',
            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
            'style' => 'width:18px;height:18px;margin-top:-2px;',
            'class' => 'savecostcenter btn btn-social-icon btn-bitbucket'
          ],[
            'name' => '',
            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
            'style' => 'width:18px;height:18px;margin-top:-2px;',
            'class' => 'deletecostcenter btn btn-social-icon btn-google'
          ]
        ]
      ];
      return Yii::$app->tblgenerator->generateGrid($params);
    }

  	public function actionRemovecostcenter(){
  		Yii::$app->backend->AjaxVerification($this); 
  		$params = Yii::$app->backend->sanitize($_GET,'ARRAY');

  		$qry = "delete from projectmasterfile where line = ".$params['q']."";
  		$status = Yii::$app->sbccommon->execqry($qry);

  		if($status){
  			$msg = "Cost center removed successfully!";
  		}else{
  			$msg = "Error removing this cost center. Please try again.";
  		}//end if

  		echo json_encode(['status'=>$status,'msg'=>$msg]);
  	}//end 
}//end controller