<?php

namespace backend\modules\termgroup\controllers;

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
            select t.id,m.main_grp,t.term_grp,t.terms from termgrp as t 
            left join maingrp as m on m.id=t.mgid order by id");
        return $this->render('index',array('classdata'=>$data,'moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionInserttermgroup(){
        $tgname = $_GET['mgname'];
        $mgid = $_GET['mgid'];
        $terms = $_GET['terms'];
        $moduleid = $this->module->id;
        
    	Yii::$app->sbccommon->execqry("insert into termgrp (term_grp,mgid,terms) values ('$tgname','$mgid','$terms')");
    	$data =  Yii::$app->sbccommon->opentable("
            select t.id,m.main_grp,t.term_grp,t.terms from termgrp as t 
            left join maingrp as m on m.id=t.mgid order by id");
        echo json_encode(array('classdata' => $data));
    }//END ACTION EDIT

    public function actionComparetglines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST; 
        Yii::$app->sbccontroller->sbcComparetglines($this,$params);
    }//end comparetermslines


    public function actionEditmg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data =  Yii::$app->sbccommon->opentable("
            select t.id,m.main_grp,t.term_grp from termgrp as t 
            left join maingrp as m on m.id=t.mgid order by id");
        echo json_encode(array('classdata' => $data));
        //var_dump($data);
    }//END ACTION EDIT

    public function actionUpdatetg(){  
        $line = $_GET['line'];
        $catname = $_GET['tgname'];
        $terms = $_GET['terms'];
        $mgid = $_GET['mgrp'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("update termgrp set mgid='$mgid',terms = '$terms', term_grp='$catname' where id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("
            select t.id,m.main_grp,t.term_grp,t.terms from termgrp as t 
            left join maingrp as m on m.id=t.mgid where t.id = $line");
        
        if(!empty($data)){
            $newcatname = $data[0]['term_grp'];
            $newcatcode = $data[0]['main_grp'];
            $newterms = $data[0]['terms'];
            $passjson = array('tgname'=>$newcatname,'mgid'=>$newcatcode,'terms'=>$newterms);
            echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT

    public function actionDeletetg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("delete from termgrp where id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("
            select t.id,m.main_grp,t.term_grp from termgrp as t 
            left join maingrp as m on m.id=t.mgid order by id");
        echo json_encode(array('catdata' => $data));
    }//END ACTION EDIT

    public function actionCanceledittg(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];
        $termsdata =  Yii::$app->sbccommon->opentable("
            select t.id,m.main_grp,t.term_grp from termgrp as t 
            left join maingrp as m on m.id=t.mgid where t.id = $line");
        if(!empty($termsdata)){

            $newcatcode = $termsdata[0]['term_grp'];
            $newcatname = $termsdata[0]['main_grp'];


            $passjson = array('classcode'=>$newcatcode,'classname'=>$newcatname);
            echo json_encode($passjson);
                
        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }//end cancel edit


        public function actionGetmaingroup(){
        $data = Yii::$app->backend->getMaingroup(); 
        echo json_encode(array('size'=>$data));
    }//end action

    public function actionGetterms(){
        Yii::$app->backend->AjaxVerification($this);
        $return=Yii::$app->sbccontroller->sbcGetterms($this);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('terms'=>$return['data']));
        }                                               
   }//END GET TERMS
}
