<?php

namespace backend\modules\stype\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

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
   
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $data =  Yii::$app->sbccommon->opentable("select line,type from stype");
        return $this->render('index',array('typedata'=>$data,'moduleid'=>$moduleid));

    }//END ACTION INDEX


    public function actionInserttype(){

        $stype = $_GET['stype'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("insert into stype (type) values ('$stype')");
        $data =  Yii::$app->sbccommon->opentable("select line,type from stype order by line");
        echo json_encode(array('stypedata' => $data));
    }//END ACTION EDIT

    public function actionUpdatetype(){  

        $line = $_GET['line'];
        $stype = $_GET['stype'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("update stype set type ='$stype' where line = '$line'");
        $data =  Yii::$app->sbccommon->opentable("select line,type from stype where line = $line");
        
        if(!empty($data)){
            $newstype = $data[0]['type'];
            $line = $data[0]['line'];

            $passjson = array('newstype'=>$newstype,'line'=>$line);
            echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT

    public function actionComparetypelines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST; 
        Yii::$app->sbccontroller->sbcComparetypelines($this,$params);
    }//end comparetermslines

    public function actionDeletetype(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
        Yii::$app->sbccommon->execqry("delete from stype where line = '$line'");
        $data =  Yii::$app->sbccommon->opentable("select line,type from stype order by line");
        echo json_encode(array('stypedata' => $data));
    }//END ACTION EDIT


    public function actionCanceledittype(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];
        $termsdata=Yii::$app->sbccommon->opentable("select line,type from stype where line = $line");

        if(!empty($termsdata)){

            $newcatcode = $termsdata[0]['line'];
            $newcatname = $termsdata[0]['type'];


            $passjson = array('line'=>$newcatcode,'type'=>$newcatname);
            echo json_encode($passjson);
                
        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }//end cancel edit

}
