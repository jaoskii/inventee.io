<?php

namespace backend\modules\maingroup\controllers;

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
        $data =  Yii::$app->sbccommon->opentable("select id,main_grp from maingrp order by id");
        return $this->render('index',array('classdata'=>$data,'moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionInsertmaingroup(){
        $mgname = $_GET['mgname'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("insert into maingrp (main_grp) values ('$mgname')");
    	$data =  Yii::$app->sbccommon->opentable("select id,main_grp from maingrp order by id");
        echo json_encode(array('classdata' => $data));
    }//END ACTION EDIT

    public function actionComparemglines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST; 
        Yii::$app->sbccontroller->sbcComparemglines($this,$params);
    }//end comparetermslines


    public function actionEditmg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data = Yii::$app->sbccommon->opentable("select id,main_grp from maingrp order by id");
        echo json_encode(array('classdata' => $data));
        //var_dump($data);
    }//END ACTION EDIT

    public function actionUpdatemg(){  
        $line = $_GET['line'];
        $catname = $_GET['mgname'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("update maingrp set main_grp='$catname' where id = '$line'");
    	$data =  Yii::$app->sbccommon->opentable("select id,main_grp from maingrp where id = $line");
        
        if(!empty($data)){
            $newcatname = $data[0]['main_grp'];

            $passjson = array('mgname'=>$newcatname);
            echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT

    public function actionDeletemg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("delete from maingrp where id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("select id,main_grp from maingrp order by id");
        echo json_encode(array('catdata' => $data));
    }//END ACTION EDIT
}
