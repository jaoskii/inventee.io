<?php

namespace backend\modules\fsitedetails\controllers;

use Yii;
use yii\web\Controller;
use yii\base\ErrorException;

class DefaultController extends Controller{
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',array('moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionWysiwyg(){
        $params = $_GET;
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;

            $qry = "select ".$params['f']." from fsitedetails";
            $data = Yii::$app->sbccommon->datareader($qry);
            return $this->render('wysiwyg',array('moduleid'=>$moduleid,'f'=>$params['f'],'toedit'=>$data));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
   }//end function

   	public function actionUpdatedatawys(){
   	try {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $tinyval = str_replace("'", "`",$params['tinyval']);
        $qry = "update fsitedetails set ".$params['f']."='".$tinyval."'";
        $status = Yii::$app->sbccommon->execqry($qry);
        echo json_encode(['status'=>$status]);
   	} catch (ErrorException $e) {
   		echo $e;
   	}
   	}//end function
}
