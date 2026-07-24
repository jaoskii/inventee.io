<?php

namespace backend\modules\categories\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class DefaultController extends Controller{

    public $access = array(
        'view' => 634);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',['moduleid'=>$moduleid]);
    }


    public function actionBuildmasterfilegrid() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateMasterfileGrid($params); 
    }
    
    public function actionSavemaster() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        if($params['line'] == 0) {
            $status = Yii::$app->sbccommon->execqry("insert into category_masterfile(cat_name) values('{$params['Name']}')");
            $data = Yii::$app->sbccommon->opentable("select cat_id as line, cat_code as Code, cat_name as Name from category_masterfile order by cat_id desc limit 1");

            if($status){
                $msg = "Successfully added!";
            }else{
                $msg = "Error inserting category, Please try again.";
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
            //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        } else {

            $qrychecker = "select count(itemid) as counter from item where category = " . $params['line'];
            $counter = Yii::$app->sbccommon->datareader($qrychecker);

            if($counter == 0){
                $status = Yii::$app->sbccommon->execqry("update category_masterfile set cat_name='{$params['Name']}' where cat_id={$params['line']}");
                $data = Yii::$app->sbccommon->opentable("select cat_id as line, cat_code as Code, cat_name as Name from category_masterfile where cat_id = '{$params['line']}'");

                if($status){
                    $msg = "Successfully Updated!";
                }else{
                    $msg = "Error updating category, Please try again.";
                }//end if
            }else{
                $data = Yii::$app->sbccommon->opentable("select cat_id as line, cat_code as Code, cat_name as Name from category_masterfile where cat_id = '{$params['line']}'");
                $status = false;
                $msg = 'Error Updating item part. Already connected to other masterfile.';
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['data'=>$data,'status'=>$status,'msg'=>$msg];
           //return json_encode(['data'=>$data,'status'=>$status,'msg'=>$msg]);
        }//end if
    }//end fn



    public function actionDeletemasteritem() {
        $checkqry="select distinct category from client where category='{$_GET['line']}'";
        $check=Yii::$app->sbccommon->opentable($checkqry);
        if(empty($check)) {
            if(Yii::$app->sbccommon->execqry("delete from category_masterfile where cat_id = '{$_GET['line']}'")) {
                $msg = "Successfully removed category.";
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            }else{
                $msg = "Successfully removed category.";
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //return json_encode(['status'=>true,'msg'=>$msg]);
            }//end if
        }else{
            $status = false;
            $msg = "Can`t delete category. Already referenced to a Masterfile Record.";
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$status,'msg'=>$msg];
            //return json_encode(['status'=>$status,'msg'=>$msg]);
        }//end if        
    }//end fn
    


    

//OLD FUNCTIONS
    // public function actionIndex(){   
    //     $this->layout = "@app/views/layouts/backend/main";
    //     $moduleid = $this->module->id;
    //     Yii::$app->view->params['moduleid'] = $moduleid;
    //     $data =  Yii::$app->sbccommon->opentable("select cat_id,cat_code,cat_name from category_masterfile order by cat_id");
    //     return $this->render('index',array('catdata'=>$data,'moduleid'=>$moduleid));
    // }//END ACTION INDEX

    // public function actionBuildmasterfilegrid() {
    //     Yii::$app->backend->AjaxVerification($this);
    //     return Yii::$app->automator->automateMasterfileGrid($this); 
    // }

    // public function actionSavemaster() {
    //     Yii::$app->backend->AjaxVerification($this);
    //     $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
    //     if($params['line'] == 0) {
    //         Yii::$app->sbccommon->execqry("insert into category_masterfile(cat_code,cat_name) values('{$params['Code']}','{$params['Name']}')");
    //         $data = Yii::$app->sbccommon->opentable("select cat_id as line,cat_code as Code,cat_name as Name from category_masterfile order by cat_id desc limit 1");
    //         return json_encode($data);
    //     } else {

    //         Yii::$app->sbccommon->execqry("update category_masterfile set cat_code='{$params['Code']}',cat_name='{$params['Name']}' where cat_id={$params['line']}");
    //         $data = Yii::$app->sbccommon->opentable("select cat_id as line,cat_code as Code,cat_name as Name from category_masterfile where cat_id = '{$params['line']}'");
    //         return json_encode($data);
    //     }
    // }

    // public function actionDeletemasteritem() {
    //     if(Yii::$app->sbccommon->execqry("delete from category_masterfile where cat_id = '{$_GET['line']}'")) {
    //         return "success";
    //     } else {
    //         return "failed";
    //     }
    // }
   //  public function actionInsertcategory(){
   //      $catcode = $_GET['catcode'];
   //      $catname = $_GET['catname'];
   //      $moduleid = $this->module->id;
   //      Yii::$app->sbccommon->execqry("insert into category_masterfile (cat_code,cat_name) values ('$catcode','$catname')");
   //      $data =  Yii::$app->sbccommon->opentable("select cat_id,cat_code,cat_name from category_masterfile order by cat_id");
   //      echo json_encode(array('catdata' => $data));
   //  }//END ACTION EDIT   

   //  public function actionEditcategory(){   
   //      $line = $_GET['line'];
   //      $moduleid = $this->module->id;
   //      $data = Yii::$app->sbccommon->opentable("select terms,line,days,discount from  terms where line ='$line' order by terms");
   //      echo json_encode(array('termsdata' => $data));
   //      //var_dump($data);
   //  }//END ACTION EDIT

   //  public function actionUpdatecategory(){  
   //      $line = $_GET['line'];
   //      $catcode = $_GET['catcode'];
   //      $catname = $_GET['catname'];
   //      $moduleid = $this->module->id;
   //      Yii::$app->sbccommon->execqry("update category_masterfile set cat_code ='$catcode',cat_name='$catname' where cat_id = '$line'");
   //      $data =  Yii::$app->sbccommon->opentable("select cat_id,cat_code,cat_name from category_masterfile where cat_id = $line");
        
   //      if(!empty($data)){
   //          $newcatcode = $data[0]['cat_code'];
   //          $newcatname = $data[0]['cat_name'];

   //          $passjson = array('catcode'=>$newcatcode,'catname'=>$newcatname);
   //          echo json_encode($passjson);

   //      }else{
   //              echo json_encode(array("error"=>"ERROR RETRIEVAL"));
   //      }

        
   //  }//END ACTION EDIT

   //  public function actionComparecategorylines(){     
   //      Yii::$app->backend->AjaxVerification($this);
   //      $params = $_POST; 
        
   //      Yii::$app->sbccontroller->sbcComparecategorylines($this,$params);
   //  }//end comparetermslines

   //  public function actionDeletecategory(){   
   //      $line = $_GET['line'];
   //      $moduleid = $this->module->id;
   //      Yii::$app->sbccommon->execqry("delete from category_masterfile where cat_id = '$line'");
   //      $data =  Yii::$app->sbccommon->opentable("select cat_id,cat_code,cat_name from category_masterfile order by cat_id");
   //      echo json_encode(array('catdata' => $data));
   //  }//END ACTION EDIT


   //  public function actionCanceleditcategory(){
   //      Yii::$app->backend->AjaxVerification($this);
   //      $line = $_GET['line'];

   //      $termsdata=Yii::$app->sbccommon->opentable("select cat_id,cat_code,cat_name from category_masterfile where cat_id = $line");

   //      if(!empty($termsdata)){

   //          $newcatcode = $termsdata[0]['cat_code'];
   //          $newcatname = $termsdata[0]['cat_name'];


   //          $passjson = array('catcode'=>$newcatcode,'catname'=>$newcatname);
   //          echo json_encode($passjson);
                

   //      }else{
   //              echo json_encode(array("error"=>"ERROR RETRIEVAL"));
   //          }
                                          
   // }//end cancel edit


}
