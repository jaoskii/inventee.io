<?php

namespace backend\modules\companyprefix\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Profile;

class DefaultController extends Controller{

     public $access = array('view' => 599);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        	if(isset(Yii::$app->session['loggeduser'])){
                $this->layout = "@app/views/layouts/backend/main";
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $comprefs = Yii::$app->backend->requestCompanyPrefixes();
                return $this->render('index',array('moduleid'=>$moduleid,'comprefs'=>$comprefs));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
    }//END ACTION INDEX

    public function actionSaveprefix(){
    	$line = $_GET['line'];
    	$company = $_GET['company'];
    	$prefixes = $_GET['prefixdata'];
        $add = $_GET['companyadd'];
        $tel = $_GET['companytel'];
        $alias = '';
    	$prefixes = Yii::$app->backend->sanitize($prefixes,'DEFAULT');

    	if(empty($line)){
    		$qry = "insert into company_prefixes (companyname,availprefs,companyalias,company_add,company_tel) 
            values('".$company."','".$prefixes."','".$alias."','".$add."','".$tel."')";
    	}else{
    		$qry = "update company_prefixes set companyname = '".$company."', availprefs = '".$prefixes."',companyalias = '".$alias."',
            company_add = '".$add."',company_tel = '".$tel."' where line = '".$line."'";
    	}//end if

    	$status =  Yii::$app->sbccommon->execqry($qry);
    	if($status){
    		 $comprefs = Yii::$app->backend->requestCompanyPrefixes();
    		 $msg = "Saving Company Prefixes successful!";
    	}else{
    		$comprefs = "";
    		$msg = 'Error Saving Company Prefix , Please Try Again';
    	}//end function
    	echo json_encode(array('status'=>$status,'comprefs'=>$comprefs,'msg'=>$msg));
    }//end function
}
