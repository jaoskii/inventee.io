<?php

namespace backend\modules\audittrail\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Center;
use app\models\Log;

use yii\web\Response;
class DefaultController extends Controller{

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        $data = Yii::$app->sbccommon->opentable("
            select '' as userid,'' as accessid, '' as username,'' as name
            union all
            select userid,accessid,username,name from useraccess;");
        $data2= Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where parent='\\\\' and parentid=0 and allowed <> 1 order by code");
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',array('usersdata' => $data,'moduledata' => $data2,'moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionGetlogsdata(){  
    	$model= new Log;
        $data = null;
        $start = $_POST['start'];
        $end = $_POST['end'];
        $userid = $_POST['userid'];
        $doc = $_POST['alias'];
        $params = $_POST;
        $data = $model->openUserlog($start, $end, $doc, $userid);
        $model->startdate=$start;
        $model->enddate=$end;
        $model->user=$userid;
        $model->modules=$doc;
        return Yii::$app->automator->automateAudittrail($data['sql'],$data['doc']);
    }
}
