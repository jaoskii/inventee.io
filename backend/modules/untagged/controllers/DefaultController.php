<?php

namespace backend\modules\untagged\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

// use app\models\Terms;

class DefaultController extends Controller{

    public $access = array(
        'view' => 634);

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
        $data = Yii::$app->sbccommon->opentable("select client,clientname,iscustomer,issupplier,isagent,iswarehouse from client where iscustomer='0' and issupplier='0' and isagent='0' and iswarehouse='0'");
            return $this->render('index',array('untaggeddata'=>$data,'moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionChangeitemsaving(){
        $params = $_POST;
        $client=$params['client'];
        $data = Yii::$app->sbccommon->execqry('update client set iscustomer ="'.$params['iscustomer'].'",
            issupplier = "'.$params['issupplier'].'",isagent = "'.$params['isagent'].'",iswarehouse = "'.$params['iswarehouse'].'"
            where client = "'.$params['client'].'"');
         // $returnval = Yii::$app->sbccommon->opentable("select client,clientname,iscustomer,issupplier,isagent,iswarehouse from client where iscustomer='0' and issupplier='0' and isagent='0' and iswarehouse='0'");
        $returnval = Yii::$app->sbccommon->opentable("select client,clientname,iscustomer,issupplier,isagent,iswarehouse from client where  client='$client' ");
        echo json_encode(array('changeditem'=>$returnval));
    }//end funciton

    public function actionSearchuntaggedclientinfo(){
        $params = $_GET;
        $data = Yii::$app->sbccommon->opentable("
    	select client,clientname,iscustomer,issupplier,isagent,iswarehouse,'' as search from client 
    	where client like '%".$params['searchstring']."%'
		or clientname like '%".$params['searchstring']."%'
		order by client");
        echo json_encode(array('changeditem'=>$data));
    }//end function

    public function actionGetuntaggedclientinfo(){
        $params = $_GET;
        $client=$params['client'];
        $returnval = Yii::$app->sbccommon->opentable("select client,clientname,iscustomer,issupplier,isagent,iswarehouse from client where  client='$client' ");
        echo json_encode(array('changeditem'=>$returnval));
    }//end function
}
