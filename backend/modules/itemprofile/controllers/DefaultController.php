<?php

namespace backend\modules\itemprofile\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Item;

class DefaultController extends Controller{

     public $access = array(
        'view' => 718,'edit' => 719,'new' => 720,'save' => 721,
        'change' => 722,'delete' => 723,'print' => 724);

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
            return $this->render('index',array('moduleid'=>$moduleid,'stockcarddata'=>$data));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionNewdataitem(){
        $barcode = $_GET['barcode'];
        $copy = $_GET['copyprevdata'];
        $params = array('barcode' => $barcode,'copyprevdata'=>$copy);
        $access = $this->access['new'];
        $barcode = Yii::$app->backend->sanitize($barcode,'DEFAULT');
        $data = Yii::$app->weblisting->fixedassetnew($this,$access,$params);

        echo json_encode(array('moduledata' => $data));
    }//END NEW DOCUMENT    

   public function actionSavehead(){
        $xxx = $_POST;
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');      
        $data = Yii::$app->weblisting->savingitemfa($this,$this->access['save'],$xxx);

        echo json_encode(array('itemid' => $data['itemid'],'msg'=>$data['msg'],'err_uom'=>$data['uom_error'],'errstat'=>$data['errstat']));
    } // END ACTION SAVEHEAD    

    public function actionLoadlastdoc(){
        $data = Yii::$app->weblisting->index($this,$this->access['view']);
        echo json_encode(array('moduledata' => $data));
   }//END ACTION CANCEL    

    public function actionSearchdocno(){
        $barcode = $_GET['docno'];
        $params = array('barcode' => $barcode);
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
        $access = array('view' => $this->access['view'],'new' => $this->access['new']);
        $data = Yii::$app->weblisting->searchingitem($this,$access,'search',$params);

        echo json_encode(array('moduledata' => $data));
    }//END SEARCH DOCNO

    public function actionDeleteitem(){
        $xxx = $_GET['params'];
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->deletingitem($this,$this->access['delete'],$xxx);
        echo json_encode(array('moduledata' => $data));
    }    

     public function actionNavbuttons(){
        $params = $_GET['params'];
        $action = $_GET['action'];
        $data = Yii::$app->weblisting->viewing($this,$this->access['view'],$action,$params);
        echo json_encode(array('itemdata' => $data));
    }//END ACTION NAVBUTTONS    

    public function actionItemlookupsearch(){
        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchitems = Yii::$app->backend->searchItem($this,$this->access['view'],$searchstring);

        echo json_encode(array('searchitems' => $searchitems));
    }    

    public function actionGetclientinfo(){
         $item = new Item;
         $itemid = $_GET['clientid'];
         $data = $item->openitemfa($itemid);
         echo json_encode(array('clientdata' => array('head'=>$data)));
    } // ACTION GET CLIENTINFO    

    public function actionGeneralitemlookup(){
        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchitems = Yii::$app->backend->searchGeneralItem($this, $this->access['view'],$searchstring,0);

        echo json_encode(array('searchitems' => $searchitems));
    }//end action  

    public function actionGetitemgendetail(){
        Yii::$app->backend->AjaxVerification($this);
        $itemid = $_GET['itemid'];
        $data = Yii::$app->backend->searchGeneralItem($this, $this->access['view'],'',$itemid);

        echo json_encode(array('genitem' => $data));
    }


    public function actionSupplierlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;        
        $return=Yii::$app->sbccontroller->sbcSupplierlookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('searchclient' => $return['data']));
        }                                       
    }    

    public function actionGetsupplierinfo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetclientinfo($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          echo json_encode(array('clientdata' => $return['data']));
        }     
    } // ACTION GET CLIENTINFO     

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
                    $checking = Yii::$app->sbccommon->opentable('select codeid from faimages where codeid = "'.$primarykey.'"');
                    if(empty($checking)){
                        $qry = "insert into faimages (codeid,picture,filename) values('".$primarykey."','".$base64."','')";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }else{
                        $qry = "update faimages set picture = '".$base64."' where codeid = '".$primarykey."'";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }//end update or insert
                }//end else for file_size validation
            }//end else for extension validation

            if($status){
                $data = Yii::$app->sbccommon->opentable('select picture from faimages where codeid = "'.$primarykey.'"');
                $picture = $data[0]['picture'];
            }//end status if

            echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end function uploading pic    


   

}
