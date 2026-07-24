<?php

namespace backend\modules\distribution\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class DefaultController extends Controller{

    public $access = array(
        'view' => 634);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $data =  Yii::$app->sbccommon->opentable("select dist_id,dist_code,dist_name from distribution_area order by dist_id");
        return $this->render('index',array('distdata'=>$data,'moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionInsertdistribution(){
        $classcode = $_GET['distcode'];
        $classname = $_GET['distname'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("insert into distribution_area (dist_code,dist_name) values ('$classcode','$classname')");
    	$data =  Yii::$app->sbccommon->opentable("select dist_id,dist_code,dist_name from distribution_area order by dist_id");
        echo json_encode(array('distdata' => $data));
    }//END ACTION EDIT

    public function actionEditdistribution(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data = Yii::$app->sbccommon->opentable("select dist_id,dist_code,dist_name from distribution_area where distid ='$line' order by dist_id");
        echo json_encode(array('distdata' => $data));
        //var_dump($data);
    }//END ACTION EDIT

    public function actionUpdatedistribution(){  
    	
        $line = $_GET['line'];
        $catcode = $_GET['distcode'];
        $catname = $_GET['distname'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("update distribution_area set dist_code ='$catcode',dist_name='$catname' where dist_id = '$line'");
    	$data =  Yii::$app->sbccommon->opentable("select dist_id,dist_code,dist_name from distribution_area where dist_id = $line");
        
        if(!empty($data)){
            $newcatcode = $data[0]['dist_code'];
            $newcatname = $data[0]['dist_name'];

            $passjson = array('distcode'=>$newcatcode,'distname'=>$newcatname);
            echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT

    public function actionComparedistributionlines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        Yii::$app->sbccontroller->sbcComparedistributionlines($this,$params);
    }//end comparetermslines


    public function actionDeletedistribution(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("delete from distribution_area where dist_id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("select dist_id,dist_code,dist_name from distribution_area order by dist_id");
        echo json_encode(array('distdata' => $data));
    }//END ACTION EDIT


    public function actionCanceleditdistribution(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];
        $termsdata=Yii::$app->sbccommon->opentable("select dist_id,dist_code,dist_name from distribution_area where dist_id = $line");

        if(!empty($termsdata)){

            $newcatcode = $termsdata[0]['dist_code'];
            $newcatname = $termsdata[0]['dist_name'];


            $passjson = array('distcode'=>$newcatcode,'distname'=>$newcatname);
            echo json_encode($passjson);
                
        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }//end cancel edit


}