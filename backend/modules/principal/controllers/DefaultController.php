<?php

namespace backend\modules\principal\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

use app\models\Principal;
use yii\web\Response;

class DefaultController extends Controller
{
	public $access = array(
        'view' => 634,'save' => 172);

	public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }

    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automatePrincipal2lookup($params);
    }//end 

    public function actionSaveprincipal() {
        try {
            $params = $_GET;
            if($params['line'] == 0) {
            	if ($params['name']) 
            	{
            		$qry ="select name from uv_principal where name = '".$params['name']."'";
            		$name = Yii::$app->sbccommon->opentable($qry);
            		
            		if (empty($name))
            		{
            			Yii::$app->sbccommon->execqry("insert into uv_principal(code, name) values('{$params['code']}', '{$params['name']}')");
            			$nameqry = '0';
            		}
            		else
            		{
            			$nameqry = '1'; 
            			
            		}

            	}    
            	$data = Yii::$app->sbccommon->opentable("select line from uv_principal order by line desc limit 1");
                $line = $data[0]['line'];            
                
            } else {
            	if ($params['name']) 
            	{
            		$qry ="select name from uv_principal where name = '".$params['name']."' and line <>'".$params['line']."'";
            		$name = Yii::$app->sbccommon->opentable($qry);

            		if (empty($name)){

            			Yii::$app->sbccommon->execqry("update uv_principal set code = '{$params['code']}', name = '{$params['name']}' where line = '{$params['line']}'");
            			$nameqry = '0';
            		}
            		else
            		{

            			$nameqry = '1'; 
            			
            		}

            	}
                $line = $params['line'];
            }
            
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['line' => $line,'name'=>$nameqry];
            //echo json_encode(array('line' => $line,'name'=>$nameqry));
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function actionDeleteprincipal(){   
        $line = $_GET['line'];
        
        Yii::$app->sbccommon->execqry("delete from uv_principal where line = '$line'");
        echo 'success';
    }//END ACTION EDIT
}
