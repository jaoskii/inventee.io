<?php

namespace backend\modules\collection\controllers;

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
        $data =  Yii::$app->sbccommon->opentable("select cllc_id,cllc_code,cllc_name from collection_area order by cllc_id");
        return $this->render('index',array('cllcdata'=>$data,'moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionInsertcollection(){
        $classcode = $_GET['cllccode'];
        $classname = $_GET['cllcname'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("insert into collection_area (cllc_code,cllc_name) values ('$classcode','$classname')");
    	$data =  Yii::$app->sbccommon->opentable("select cllc_id,cllc_code,cllc_name from collection_area order by cllc_id");
        echo json_encode(array('cllcdata' => $data));
    }//END ACTION EDIT

    public function actionEditclass(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data = Yii::$app->sbccommon->opentable("elect cllc_id,cllc_code,cllc_name from collection_area where cllc_id ='$line' order by cllc_id");
        echo json_encode(array('classdata' => $data));
        //var_dump($data);
    }//END ACTION EDIT

    public function actionUpdatecollection(){  

        $line = $_GET['line'];
        $catcode = $_GET['cllccode'];
        $catname = $_GET['cllcname'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("update collection_area set cllc_code ='$catcode',cllc_name='$catname' where cllc_id = '$line'");
    	$data =  Yii::$app->sbccommon->opentable("select cllc_id,cllc_code,cllc_name from collection_area where cllc_id = $line");
        
        if(!empty($data)){
            $newcatcode = $data[0]['cllc_code'];
            $newcatname = $data[0]['cllc_name'];

            $passjson = array('cllccode'=>$newcatcode,'cllcname'=>$newcatname);
            echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT

    public function actionComparecollectionlines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        Yii::$app->sbccontroller->sbcComparecollectionlines($this,$params);
    }//end comparetermslines


    public function actionDeletecollection(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("delete from collection_area where cllc_id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("select cllc_id,cllc_code,cllc_name from collection_area order by cllc_id");
        echo json_encode(array('cllcdata' => $data));
    }//END ACTION EDIT


    public function actionCanceleditcollection(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];
        $termsdata=Yii::$app->sbccommon->opentable("select cllc_id,cllc_code,cllc_name from collection_area where cllc_id = $line");

        if(!empty($termsdata)){

            $newcatcode = $termsdata[0]['cllc_code'];
            $newcatname = $termsdata[0]['cllc_name'];


            $passjson = array('cllccode'=>$newcatcode,'cllcname'=>$newcatname);
            echo json_encode($passjson);
                
        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }//end cancel edit


}