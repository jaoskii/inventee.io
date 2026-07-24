<?php

namespace backend\modules\fbmanager\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;


class DefaultController extends Controller{

//TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }//end functions

    public function actionIndex(){
     	if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $banners = Yii::$app->frontend->getAvailableBanners();
            return $this->render('index',array('moduleid'=>$moduleid,'banners'=>$banners));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF       
    }//END ACTION INDEX


    public function actionUploadbannerslider(){
        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'BANNERSLIDER',$params);
            $checking = Yii::$app->sbccommon->opentable('select bannerid from frontend_banner where line = '.$params['index'].'');
                
            if(empty($checking)){
                $qry = "insert into frontend_banner (strimg,line,isenabled) values('".$return['dbpic']."',".$params['index'].",1)";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }else{
                $qry = "update frontend_banner set strimg = '".$return['dbpic']."' where line = ".$params['index']."";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }//end update or insert
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function action upload lane banner

}//end controller

