<?php

namespace backend\modules\frontendmanager\controllers;

use Yii;
use yii\web\Controller;

//exported MODELS
use app\models\LoginForm;
use app\models\Center;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\UserAccess;

//for testing
use app\models\Common;


class DefaultController extends Controller
{

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    

//FOR DASHBOARD LANDING PAGE
    public function actionIndex(){
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',array('moduleid'=>$moduleid));
    }//END ACTION INDEX


     public function actionUploadpic(){

        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'FRONTEND_LOGO',$params);

           
            /*$checking = Yii::$app->sbccommon->opentable('select codeid from itimages where codeid = "'.$_POST['codeid'].'"');
            if(empty($checking)){
                $qry = "insert into itimages (codeid,picture,filename) values('".$_POST['codeid']."','".$return['dbpic']."','')";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }else{
                $qry = "update itimages set picture = '".$return['dbpic']."' where codeid = '".$_POST['codeid']."'";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }//end update or insert*/
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function uploading pic
    
}//end controller

