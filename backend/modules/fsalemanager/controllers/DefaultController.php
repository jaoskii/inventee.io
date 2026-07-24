<?php

namespace backend\modules\fsalemanager\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use yii\base\ErrorException;

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
    try {
        $this->layout = "@app/views/layouts/backend/main";
     	if(isset(Yii::$app->session['loggeduser'])){
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $items = Yii::$app->backend->getOnSaleItems('');
            return $this->render('index',array('moduleid'=>$moduleid,'saleitems'=>$items));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF       
    } catch (ErrorException $e) {
        echo $e;
    }
    }//END ACTION INDEX

    public function actionGetonsaleitems(){
        $q = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');
        $items = Yii::$app->backend->getOnSaleItems($q);
        echo json_encode(array('onsaleitems'=>$items));
    }//end function

    public function actionGetendsaleitems(){
        $q = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');
        $items = Yii::$app->backend->getEndSaleItems($q);
        echo json_encode(array('endsaleitems'=>$items));
    }//end function

    public function actionSelectedendsale(){
        try {
            foreach ($_GET['params'] as $key => $value) {
                $enddate = date('Y-m-d',strtotime(date('Y-m-d') . ' -1 day'));
                $qry = "update item set promoend = '".$enddate."' where md5(itemid) = '".$value."'";
                $qrytagend = "insert into frontend_endedsale (itemid_md5,dateend) values('".$value."','".$enddate."')";
                Yii::$app->sbccommon->execqry($qry);
                Yii::$app->sbccommon->execqry($qrytagend);
            }//end for each

            echo json_encode(array('status'=>true));
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end function selected end sale

    public function actionSelectedextendsale(){
        try {
            $extenddate = $_GET['extenddate'];
            if($extenddate < date('Y-m-d')){
                $status = false;
                $msg = "Error extending sale date. Extend date must be higher than date today!";
            }else{  
                foreach ($_GET['params'] as $key => $value) {
                    $qry = "update item set promoend = '".$extenddate."' where md5(itemid) = '".$value."'";
                    Yii::$app->sbccommon->execqry($qry);
                }//end for each
                $status = true;
                $msg = "";
            }//end if
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end function selected end sale
}///end CONTROLLER

