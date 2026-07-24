<?php

namespace backend\modules\employee\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Employee;
use yii\base\ErrorException;

class DefaultController extends Controller{


     public $access = array(
        'view' => 742,'edit' => 743,'new' => 744,'save' => 745,
        'change' => 746,'delete' => 747,'print' => 748);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(isset(Yii::$app->session['loggeduser'])){
            $data = Yii::$app->weblisting->index($this,$this->access['view']);  
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $this->layout = "@app/views/layouts/backend/main";
            return $this->render('index',array('moduleid'=>$moduleid,'customerdata'=>$data));

        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
        
    }//END ACTION INDEX

    public function actionGetclientinfo(){
        try {
            $client = new Employee;
            $clientid = $_GET['clientid'];
            $type = 'employee';
            $data = $client->openemployee($clientid);
            $origdata = $data[0];
            echo json_encode(array('clientdata' => array('head'=>$origdata)));
            
        } catch (ErrorException $e) {
          
          echo $e;
          return 0;  
        }
         

    } // ACTION GET CLIENTINFO

    public function actionNavbuttons(){
        $params = $_GET['params'];
        $action = $_GET['action'];
         $data = Yii::$app->weblisting->viewing($this,$this->access['view'],$action,$params);   
        echo json_encode(array('customerdata' => $data));

    }//END ACTION NAVBUTTONS

    public function actionNewclientdata(){
        try {
            $client = $_GET['employee'];
            $params = array('client' => $client);
            $access = $this->access['new'];
            $data = Yii::$app->weblisting->newingemployee($this,$access,$params);
            echo json_encode(array('moduledata' => $data));
        } catch (ErroException $e) {
            echo $e;
            return 0;    
        }//end try
    }//END NEW DOCUMENT

    public function actionSaveclient(){
        $xxx = $_POST;
               $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $this->layout = "@app/views/layouts/backend/main";
        //$xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->savingheademployee($this,$this->access['save'],$xxx,$moduleid);  
  
        echo json_encode(array('clientid'=>$data['head']['clientid'],'client' => $data['head']['client'],'msg'=>$data['head']['msg']));
    }

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

       //LOADS LAST DOCUMENT
   public function actionLoadlastclient(){
        $data = Yii::$app->weblisting->index($this,$this->access['view']);
        echo json_encode(array('moduledata' => $data));
   }//END ACTION CANCEL

   public function actionSearchdocno(){
        $client = $_GET['docno'];
        $params = array('client' => $client);
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
        $access = array('view' => $this->access['view'],'new' => $this->access['new']);
        $data = Yii::$app->weblisting->searching($this,$access,'search',$params);
        echo json_encode(array('moduledata' => $data));
        // var_dump($data);
    }//END SEARCH DOCNO

    public function actionDeleteclient(){
        $xxx = $_GET['params'];
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->deletingemployee($this,$this->access['delete'],$xxx);
        echo json_encode(array('moduledata' => $data));
        //var_dump($data);
    }

   public function actionLog(){
    $params = array("clientid"=>$_GET['trno']);
    $data = Yii::$app->weblisting->showlogs($this,$params);
    echo json_encode(array('logs'=>$data));
   }//END ACTION LOG  

   public function actionUploadpic(){
        Yii::$app->backend->AjaxVerification($this);
        if(isset($_FILES['image'])){
            $errors="";
            $picture = "";
            $file_name =$_FILES['image']['name'];
            $file_tmp= $_FILES['image']['tmp_name'];
            $file_size=$_FILES['image']['size'];
            $filearray = explode('.',$file_name);
            $file_ext = strtolower(end($filearray));
            $allowed_ext= array('jpg','jpeg','png');

            if(!in_array($file_ext,$allowed_ext)){
                $errors='Extension not allowed , allowed file extensions are (jpg,jpeg,png)';
                $status = 0;
            }else{
                if($file_size > 2097152){
                $errors = 'File size must be under 2mb';
                $status = 0;
                }else{                    
                    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
                    $data = file_get_contents($file_tmp);
                    $primarykey = $_POST['codeid'];
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); //STRING TO BE SAVED TO DATABASE
                    $checking = Yii::$app->sbccommon->opentable('select codeid from empimages where codeid = "'.$primarykey.'"');
                    if(empty($checking)){
                        $qry = "insert into empimages (codeid,picture,filename) values('".$primarykey."','".$base64."','')";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }else{
                        $qry = "update empimages set picture = '".$base64."' where codeid = '".$primarykey."'";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }//end update or insert
                }//end else for file_size validation
            }//end else for extension validation
            
            if($status){
                $data = Yii::$app->sbccommon->opentable('select picture from empimages where codeid = "'.$primarykey.'"');
                $picture = $data[0]['picture'];
            }//end status if

            echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end function uploading pic

}//end controller
