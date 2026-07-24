<?php

namespace backend\modules\location\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Client;

class DefaultController extends Controller{


     public $access = array(
        'view' => 734,'edit' => 735,'new' => 736,'save' => 737,
        'change' => 738,'delete' => 739,'print' => 740);

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

    public function actionLocationlookupsearch(){

        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchclient = Yii::$app->backend->searchlocations($this,$this->access['view'],$searchstring);
        echo json_encode(array('searchlocation' => $searchclient));

    } //END ACTION CUSTOMER LOOKUP SEARCH

    public function actionGetclientinfo(){
         $client = new Client;
         $clientid = $_GET['clientid'];
         $type = 'location';
         $data = $client->openclient($clientid,$type);
         $origdata = $data[0];
         echo json_encode(array('clientdata' => array('head'=>$origdata)));

    } // ACTION GET CLIENTINFO

    public function actionNavbuttons(){
        $params = $_GET['params'];
        $action = $_GET['action'];
         $data = Yii::$app->weblisting->viewing($this,$this->access['view'],$action,$params);   
        echo json_encode(array('customerdata' => $data));

    }//END ACTION NAVBUTTONS

    public function actionNewclientdata(){
        $client = $_GET['client'];
        $params = array('client' => $client);
        $access = $this->access['new'];
        $data = Yii::$app->weblisting->newing($this,$access,$params);
        echo json_encode(array('moduledata' => $data));
    }//END NEW DOCUMENT

    public function actionSaveclient(){
        $xxx = $_POST;
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $this->layout = "@app/views/layouts/backend/main";
        //$xxx = Yii::$app->backendend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->savinghead($this,$this->access['save'],$xxx,$moduleid);   
        echo json_encode(array('clientid'=>$data['head']['clientid'],'client' => $data['head']['client'],'msg'=>$data['head']['msg']));
    }

       //LOADS LAST DOCUMENT
   public function actionLoadlastclient(){
        $data = Yii::$app->weblisting->index($this,$this->access['view']);
        echo json_encode(array('moduledata' => $data));
   }//END ACTION CANCEL

   public function actionSearchdocno(){
        $client = $_GET['docno'];
        $params = array('client' => $client);
        //$params = Yii::$app->backend->sanitize($params,'ARRAY');
        $access = array('view' => $this->access['view'],'new' => $this->access['new']);
        $data = Yii::$app->weblisting->searching($this,$access,'search',$params);
        echo json_encode(array('moduledata' => $data));
        // var_dump($data);
    }//END SEARCH DOCNO

    public function actionDeleteclient(){
        $xxx = $_GET['params'];
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->deleting($this,$this->access['delete'],$xxx);
        echo json_encode(array('moduledata' => $data));
        //var_dump($data);
    }

   public function actionLog(){
    $params = array("clientid"=>$_GET['trno']);
    $data = Yii::$app->weblisting->showlogs($this,$params);
    echo json_encode(array('logs'=>$data));
   }//END ACTION LOG    

    public function actionGetregionlist(){
        $data = Yii::$app->backend->getRegionlist();
        echo json_encode(array('region'=>$data));
    }//end

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
                    $checking = Yii::$app->sbccommon->opentable('select codeid from itimages where codeid = "'.$primarykey.'"');
                    if(empty($checking)){
                        $qry = "insert into itimages (codeid,picture,filename) values('".$primarykey."','".$base64."','')";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }else{
                        $qry = "update itimages set picture = '".$base64."' where codeid = '".$primarykey."'";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }//end update or insert
                }//end else for file_size validation
            }//end else for extension validation

            if($status){
                $data = Yii::$app->sbccommon->opentable('select picture from itimages where codeid = "'.$primarykey.'"');
                $picture = $data[0]['picture'];
            }//end status if

            echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end function uploading pic
    
}//END CONTROLLER