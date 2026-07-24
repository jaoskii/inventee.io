<?php

namespace backend\modules\colltype\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{
	public $access = array('view' => 11);

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

    public function actionLoadcolltypes() {
      $qry = "select line,colltype_masterfile.acno,colltype_masterfile.acnoname,coa.acnoname as chartname 
              from colltype_masterfile 
              left join coa on coa.acno = colltype_masterfile.acno";
      $params = [
        'sql' => $qry,
        'tableid' => 'colltypetbl',
        'key' => 'line',
        'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
        'txtclass' => 'colltypetbltxt',
        'column' => [
          [
          	'label' => 'Account Code',
            'name' => 'acno',
            'editable' => true,
            'type' => 'lookup',
            'lookupbutton' => ['autocall'=>'uom',
	                          'colw'=>'col-min',
	                          'lookupclass'=>'gvbtns collcontralookup',
	                          'lookuptxtclass'=>'mastertextbox minitxtcombo collacno'],
          ],[
            'label' => 'Chart Account Name',
            'name' => 'chartname',
            'editable' => true,
            'readonly' =>true,
            'type' => 'text',
            'class' => 'col-codes collacnoname stocktxt mastertextbox aimslabel'
          ],[
          	'label' => 'Account Name',
            'name' => 'acnoname',
            'editable' => true,
            'type' => 'text',
            'class' => 'col-codes stocktxt mastertextbox aimslabel'
          ],[
            'name' => 'line',
            'hidden' => 'true',
            'default' => '0',
            'class' => 'mastertextbox txthidden'
          ]
        ],
        'buttons' => [
          [
            'name' => '',
            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
            'style' => 'width:18px;height:18px;margin-top:-2px;margin-right:2px;',
            'class' => 'mastersave btn btn-social-icon btn-bitbucket'
          ],[
            'name' => '',
            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
            'style' => 'width:18px;height:18px;margin-top:-2px;margin-right:2px;',
            'class' => 'masterdelete btn btn-social-icon btn-google'
          ]
        ]
      ];
      return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function actionSavemaster() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        if($params['line'] == 0) {
            Yii::$app->sbccommon->execqry("insert into colltype_masterfile(acno,acnoname) values('\\{$params['acno']}','{$params['acnoname']}')");
            $data = Yii::$app->sbccommon->opentable("select line,acno,acnoname from colltype_masterfile order by line desc limit 1");
            return json_encode($data);
        } else {
            Yii::$app->sbccommon->execqry("update colltype_masterfile 
                                          set acno = '\\".$params['acno']."',acnoname='".$params['acnoname']."' where line = '".$params['line']."'");
            $data = Yii::$app->sbccommon->opentable("select line,acno,acnoname from colltype_masterfile where line = ".$params['line']."");
            return json_encode($data);
        }//end f
    }//end action

    public function actionDeletemasteritem() {
        if(Yii::$app->sbccommon->execqry("delete from colltype_masterfile where line = '{$_GET['line']}'")) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function actionContrasearch(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);                                   
    }//END CONTRA

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