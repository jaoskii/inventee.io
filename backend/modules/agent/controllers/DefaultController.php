<?php

namespace backend\modules\agent\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;
use app\models\Client;

use yii\web\Response;

class DefaultController extends Controller{


     public $access = array(
        'view' => 42,'edit' => 43,'new' => 44,'save' => 45,
        'change' => 46,'delete' => 47,'print' => 48);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    public function actionGetarealist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateArealookup($this);
    }//end

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['verified'=>$return];
        //echo json_encode(array('verified'=>$return)); 
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){   
            if(isset(Yii::$app->session['loggeduser'])){
                $data = Yii::$app->weblisting->index($this,$this->access['view']);  
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                return $this->render('index',array('moduleid'=>$moduleid,'customerdata'=>$data));

            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }
    }//END ACTION INDEX

    public function actionGetclientinfo(){
         $client = new Client;
         $clientid = $_GET['clientid'];
         $type = 'agent';
         $data = $client->openclient($clientid,$type);
         $origdata = $data[0];

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['clientdata' => ['head'=>$origdata]];
        //echo json_encode(array('clientdata' => array('head'=>$origdata)));
    } // ACTION GET CLIENTINFO

    public function actionGetclientgrouplist(){
        $data = Yii::$app->backend->getClientGrplist();

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['clientgrp'=>$data];
        //echo json_encode(array('clientgrp'=>$data));
    }//end

    public function actionNavbuttons(){
        $params = $_GET['params'];
        $action = $_GET['action'];
         $data = Yii::$app->weblisting->viewing($this,$this->access['view'],$action,$params); 
         
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['customerdata' => $data];
        //echo json_encode(array('customerdata' => $data));
    }//END ACTION NAVBUTTONS

    public function actionNewclientdata(){
        $client = $_GET['client'];
        $params = array('client' => $client);
        $access = $this->access['new'];
        $data = Yii::$app->weblisting->newing($this,$access,$params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
    }//END NEW DOCUMENT

    public function actionSaveclient(){
        try {
            $xxx = $_POST;
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $this->layout = "@app/views/layouts/backend/main";
            $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
            $data = Yii::$app->weblisting->savinghead($this,$this->access['save'],$xxx,$moduleid);            

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$data['head']['status'],'clientid'=>$data['head']['clientid'],'client' => $data['head']['client'],'msg'=>$data['head']['msg']];
            //echo json_encode(array('status'=>$data['head']['status'],'clientid'=>$data['head']['clientid'],'client' => $data['head']['client'],'msg'=>$data['head']['msg']));
        } catch (ErrorException $e) {
            echo $e;
        }
    }

       //LOADS LAST DOCUMENT
   public function actionLoadlastclient(){
        $data = Yii::$app->weblisting->index($this,$this->access['view']);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
   }//END ACTION CANCEL

   public function actionSearchdocno(){
        $client = $_GET['docno'];
        $params = array('client' => $client);
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
        $access = array('view' => $this->access['view'],'new' => $this->access['new']);
        $data = Yii::$app->weblisting->searching($this,$access,'search',$params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
    }//END SEARCH DOCNO

    public function actionDeleteclient(){
        $xxx = $_GET['params'];
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $checkval=0;
        for ($i=0; $i <4 ; $i++) { 
            switch ($i) {
                case '0':
                    $qry="select * from client where agent='".$xxx['client']."'";
                    break;
                case '1':
                    $qry="select * from lahead where agent='".$xxx['client']."'";
                    break;
                case '2':
                    $qry="select * from glhead where agentid='".$xxx['clientid']."'";
                    break;
                case '3':
                    $qry="select * from sohead where agent='".$xxx['client']."'";
                    break;

            }

            $check = Yii::$app->sbccommon->opentable($qry);
            if(!empty($check)){
                    $checkval=+1;
            }
            
        }
        
        if($checkval==1){
            $data=['msg'=>'Agent has Records/is looked up. Cannot Delete.'];
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['moduledata' => $data];
            //echo json_encode(array('moduledata' => $data));    
        }else{
            $data = Yii::$app->weblisting->deleting($this,$this->access['delete'],$xxx);

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['moduledata' => $data];
            //echo json_encode(array('moduledata' => $data));    
        }
    }//end fn

    public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);
    }


    public function actionGetprovincelist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateProvincelookup($this);
    }//end
    
    public function actionAgentlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateAgentlookup($params);
    }
    

    public function actionGetgroup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        
        $params['controller']=$this;
        if(isset($params['x'])){
            return Yii::$app->automator->automateGrouplookup($params,$params['x']);
        }else{
            return Yii::$app->automator->automateGrouplookup($this);
        }//end if
    }//end acts

    public function actionGetregionlist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateRegionlookup($this);
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


            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$status,'picture'=>$picture,'error'=>$errors];
            //echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end function uploading pic
    
}//END CONTROLLER