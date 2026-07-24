<?php

namespace backend\modules\ewtsetup\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

use yii\web\Response;
class DefaultController extends Controller{

    public $access = array('view' => 634);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionBuildstockview() {
        $sql = "select line,code,rate,description from ewtlist order by description";
        $params = [
            'sql' => $sql,
            'tableid' => 'ewtstockview',
            'key' => 'line',
            'txtclass' => 'ewttextbox',
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'editable' => true,
                    'type' => 'text',
                    'class'=>'col-codes ewttxt',
                ],[
                    'name' => 'rate',
                    'editable' => true,
                    'label' => 'Rates (%) [Note: Please enter rate in numbers / decimals]', 
                    'type' => 'text',
                    'default' => 0.00,
                    'class'=>'col-codes ewttxt',
                ],[
                    'name' => 'description',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes ewttxt'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'saveewt gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'deleteewt gvbtns btn btn-social-icon btn-google'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function actionSaveewt() {
        try {
            $params = $_GET;
            if($params['line'] == 0) {
            	$qry = "select code from ewtlist where code = '".$params['code']."'";
            	$code = Yii::$app->sbccommon->opentable($qry);
            	if(!empty($code)){
            		$status = false;
            		$line = 0;
	                $msg = "Error Inserting EWT Code. Duplicate code found";
            	}else{
            		$status = Yii::$app->sbccommon->execqry("insert into ewtlist (code,rate,description) 
                							  values('{$params['code']}', '{$params['rate']}','{$params['description']}')");
	                if($status){
	                	$data = Yii::$app->sbccommon->opentable("select line from ewtlist order by line desc limit 1");
	                	$line = $data[0]['line'];
	                	$msg = "";
	                }else{
	                	$line = 0;
	                	$msg = "Error Inserting EWT Code. Check Encoded Info";
	                }//end if
            	}//end if
            } else {
                $status = Yii::$app->sbccommon->execqry("update ewtlist 
                							   set description = '{$params['description']}', rate = '{$params['rate']}', code = '{$params['code']}'
                							   where line = '{$params['line']}'");
                if($status){
                	$line = $params['line'];
                	$msg = "";
                }else{
                	$line = 0;
                	$msg = "Error Updating EWT Code";
                }//end if
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['msg'=>$msg,'line'=>$line,'status'=>$status];
            //echo json_encode(['msg'=>$msg,'line'=>$line,'status'=>$status]);
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end if

    public function actionDeleteewt(){   
        $line = $_GET['line'];
        Yii::$app->sbccommon->execqry("delete from ewtlist where line = '$line'");
        echo 'success';
    }//END ACTION EDIT
}//END CONTROLLER
