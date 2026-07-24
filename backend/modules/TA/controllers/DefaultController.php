<?php

namespace backend\modules\TA\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;


class DefaultController extends Controller
{
	public $access = array(
        'view' => 750 ,'edit' => 751,'new' => 752,
        'save' => 753,'delete' => 754,
        'void' => 755,'post' => 756,'unpost' => 757,);
	
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }


    public function actionIndex(){

    	
     if(isset(Yii::$app->session['loggeduser'])){
           $this->layout = "@app/views/layouts/backend/main";
           $moduleid = $this->module->id;
           Yii::$app->view->params['moduleid'] = $moduleid;              
           
           return $this->render('index',array('moduleid'=>$moduleid));

         }else{
             return $this->redirect(Url::to(['/admin/default/login']));
         }//END IF
    }//END ACTION INDEX

     public function actionEmplookupsearch(){
        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchitems = Yii::$app->backend->searchEmployee($this,$this->access['view'],$searchstring,0);

        echo json_encode(array('searchclient' => $searchitems));
    }       

    public function actionGetempinfo(){
        Yii::$app->backend->AjaxVerification($this);
        $empid = $_GET['empid'];
        $data = Yii::$app->backend->searchEmployee($this, $this->access['view'],'',$empid);

        echo json_encode(array('genemp' => $data));
    }   

    public function actionSearchref(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcSearchtaref($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        }                                       
    }//END SEARCH DOCNO     

    public function actionItemlookupsearch(){
        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchitems = Yii::$app->backend->searchItem($this,$this->access['view'],$searchstring);

        echo json_encode(array('searchitems' => $searchitems));
    }

    public function actionRetrievefaitem(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcRetrievefaitem($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('faitem' => $return['faitem']));
        }              
    }//end retireve faitem

    public function actionPostfaitem(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcPostfaitem($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('faitem' => $return['faitem']));
        }              
    }//end post faitem

}
