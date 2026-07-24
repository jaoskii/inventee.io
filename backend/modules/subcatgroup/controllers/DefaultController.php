<?php

namespace backend\modules\subcatgroup\controllers;

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
        $data =  Yii::$app->sbccommon->opentable("select sc.id,ifnull(scat_grp,'') as scat_grp,ifnull(cat_grp,'') as cat_grp from subcatgrp as sc
                left join catgrp as c on c.id=sc.cgid order by sc.id");
        return $this->render('index',array('classdata'=>$data,'moduleid'=>$moduleid));
    }//END ACTION INDEX

    public function actionInsertsubcatgroup(){
        $tgname = $_GET['scgname'];
        $cid = $_GET['cid'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("insert into subcatgrp (scat_grp,cgid) values ('$tgname','$cid')");
    	$data =  Yii::$app->sbccommon->opentable("select sc.id,ifnull(scat_grp,'') as scat_grp,ifnull(cat_grp,'') as cat_grp from subcatgrp as sc
                left join catgrp as c on c.id=sc.cgid order by sc.id");
        echo json_encode(array('classdata' => $data));
    }//END ACTION EDIT

    public function actionComparescglines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST; 
        Yii::$app->sbccontroller->sbcComparescglines($this,$params);
    }//end comparetermslines


    public function actionEditcg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data =  Yii::$app->sbccommon->opentable("select sc.id,ifnull(scat_grp,'') as scat_grp,ifnull(cat_grp,'') as cat_grp from subcatgrp as sc
                left join catgrp as c on c.id=sc.cgid order by sc.id");
        echo json_encode(array('classdata' => $data));
        //var_dump($data);
    }//END ACTION EDIT

    public function actionUpdatescg(){  
        $line = $_GET['line'];
        $catname = $_GET['scgname'];
        $cg = $_GET['cg'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("update subcatgrp set cgid=".$cg.",scat_grp='$catname' where id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("select sc.id,ifnull(scat_grp,'') as scat_grp,ifnull(cat_grp,'') as cat_grp from subcatgrp as sc
                left join catgrp as c on c.id=sc.cgid where sc.id = $line");
        if(!empty($data)){
            $newcatname = $data[0]['scat_grp'];
            $newcatcode = $data[0]['cat_grp'];

            $passjson = array('scgname'=>$newcatname,'cgid'=>$newcatcode);
            echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT

    public function actionDeletescg(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("delete from subcatgrp where id = '$line'");
        $data =  Yii::$app->sbccommon->opentable("select sc.id,ifnull(scat_grp,'') as scat_grp,ifnull(cat_grp,'') as cat_grp from subcatgrp as sc
                left join catgrp as c on c.id=sc.cgid order by sc.id");
        echo json_encode(array('catdata' => $data));
    }//END ACTION EDIT


    public function actionCanceleditscg(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];
        $termsdata =  Yii::$app->sbccommon->opentable("select sc.id,ifnull(scat_grp,'') as scat_grp,ifnull(cat_grp,'') as cat_grp from subcatgrp as sc
                left join catgrp as c on c.id=sc.cgid where sc.id = $line");
        if(!empty($termsdata)){

            $newcatcode = $termsdata[0]['scat_grp'];
            $newcatname = $termsdata[0]['cat_grp'];

            $passjson = array('classcode'=>$newcatcode,'classname'=>$newcatname);
            echo json_encode($passjson);
                
        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }//end cancel edit


        public function actionGetcatgroup(){
        $data = Yii::$app->backend->getCatgroup(); 
        echo json_encode(array('size'=>$data));
    }//end action
}
