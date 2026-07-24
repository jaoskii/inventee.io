<?php

namespace backend\modules\categorygroup\controllers;

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
        $data =  Yii::$app->sbccommon->opentable("
            select c.id,cat_grp,t.term_grp from catgrp as c
            left join termgrp as t on t.id=c.tgid order by c.id");
        return $this->render('index',array('classdata'=>$data,'moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionInsertcatgroup(){
        $tgname = $_GET['cgname'];
        $tid = $_GET['tid'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("insert into catgrp (cat_grp,tgid) values ('$tgname','$tid')");
    	$data =  Yii::$app->sbccommon->opentable("
            select c.id,cat_grp,t.term_grp from catgrp as c
            left join termgrp as t on t.id=c.tgid order by c.id");
        echo json_encode(array('classdata' => $data));
    }//END ACTION EDIT

    public function actionComparecglines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST; 
        Yii::$app->sbccontroller->sbcComparecglines($this,$params);
    }//end comparetermslines


    public function actionEditcg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data =  Yii::$app->sbccommon->opentable("
            select c.id,cat_grp,t.term_grp from catgrp as c
            left join termgrp as t on t.id=c.tgid order by c.id");
        echo json_encode(array('classdata' => $data));
        //var_dump($data);
    }//END ACTION EDIT

    public function actionUpdatecg(){  
        $line = $_GET['line'];
        $catname = $_GET['cgname'];
        $tgid = $_GET['tg'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("update catgrp set tgid=".$tgid.",cat_grp='$catname' where id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("
            select c.id,cat_grp,t.term_grp from catgrp as c
            left join termgrp as t on t.id=c.tgid where c.id = $line");
        if(!empty($data)){
            $newcatname = $data[0]['cat_grp'];
            $newcatcode = $data[0]['term_grp'];

            $passjson = array('cgname'=>$newcatname,'tgid'=>$newcatcode);
            echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT

    public function actionDeletecg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("delete from catgrp where id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("
            select c.id,cat_grp,t.term_grp from catgrp as c
            left join termgrp as t on t.id=c.tgid order by c.id");
        echo json_encode(array('catdata' => $data));
    }//END ACTION EDIT


    public function actionCanceleditcg(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];
        $termsdata =  Yii::$app->sbccommon->opentable("
            select c.id,cat_grp,t.term_grp from catgrp as c
            left join termgrp as t on t.id=c.tgid where c.id = $line");
        if(!empty($termsdata)){

            $newcatcode = $termsdata[0]['term_grp'];
            $newcatname = $termsdata[0]['cat_grp'];

            $passjson = array('classcode'=>$newcatcode,'classname'=>$newcatname);
            echo json_encode($passjson);
                
        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }//end cancel edit


    public function actionGettermgroup(){
        $data = Yii::$app->backend->getTermgroup(); 
        echo json_encode(array('size'=>$data));
    }//end action
}
