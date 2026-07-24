<?php

namespace backend\modules\assetmaster\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Client;
use yii\base\ErrorException;

class DefaultController extends Controller
{
    public $access = array(
        'view' => 22,'edit' => 23,'new' => 24,'save' => 25,
        'change' => 26,'delete' => 27,'print' => 28);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno=0){ 
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }


    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $data = Yii::$app->weblisting->index($this,$this->access['view']);  
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                // $costaccess = Yii::$app->backend->viewcostAccess();
                return $this->render('index',array('moduleid'=>$moduleid,'assetdata'=>$data));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }
    }//END ACTION INDEX

    public function actionCustomerlookupsearch(){

        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchclient = Yii::$app->backend->searchClient($this,$this->access['view'],$searchstring);
        echo json_encode(array('searchclient' => $searchclient));

    } //END ACTION CUSTOMER LOOKUP SEARCH

    public function actionAgentlookupsearch(){

        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchagent = Yii::$app->backend->searchagents($this,$this->access['view'],$searchstring);
        echo json_encode(array('searchagent' => $searchagent));
        //var_dump($searchagent);


    } //END ACTION CUSTOMER LOOKUP SEARCH

    public function actionGetclientinfo(){
         $client = new Client;
         $clientid = $_GET['clientid'];
         $type = 'customer';
         // ============== JAD UPDATE G
	         if($this->module->id == 'assetmaster') {
	         	$type = 'assetmaster';
	         }
         $data = $client->openclient($clientid,$type);
         $origdata = $data[0];
         if($origdata['agentcode'] != ""){
            $origdata['agentcode'] = $origdata['agentcode'] . '~' . $origdata['agent'];
         }
         //var_dump($origdata['agentcode']);
         echo json_encode(array('clientdata' => array('head'=>$origdata)));

    } // ACTION GET CLIENTINFO

        public function actionGetagentinfo(){
         $client = new Client;
         $agcode = $_GET['agcode'];
         $type = $_GET['type'];
         $data = $client->openclient($agcode,$type);
         echo json_encode(array('clientdata' => $data));

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
        try {
            $xxx = $_POST;
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $this->layout = "@app/views/layouts/backend/main";
            $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
            $data = Yii::$app->weblisting->savinghead($this,$this->access['save'],$xxx);
            echo json_encode(array('clientid'=>$data['head']['clientid'],'client' => $data['head']['client'],'msg'=>$data['head']['msg']));
        }catch(ErrorException $e) {
            echo $e;
            return 0;
        }//end try catch
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
    }//END SEARCH DOCNO

    public function actionDeleteclient(){
    	try {
	        $xxx = $_GET['params'];
	        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
	        $data = Yii::$app->weblisting->deleting($this,$this->access['delete'],$xxx);
	        echo json_encode(array('moduledata' => $data));
	        //var_dump($data);
    	} catch(ErrorException $e) {
    		echo $e;
    	}
    }

    public function actionComputeacctg(){
    $clientid = $_GET['clientid'];
    $date = $_GET['date'];
    $type = $_GET['type'];
    $params = array('clientid'=>$clientid,'date'=>$date,'type'=>$type);
    $data = Yii::$app->backend->computeacctg($params);
    switch ($params['type']) {
        case 'AP':
            $data2 = Yii::$app->backend->openAPsum($params['clientid'],$params['date']);
        break;

        case 'AR':
            $data2 = Yii::$app->backend->openARsum($params['clientid'],$params['date']);
        break;

        case 'PDC':
            $data2 = Yii::$app->backend->openPDCsum($params['clientid'],$params['date']);
        break;

        case 'RC':
            $data2 = Yii::$app->backend->openRCsum($params['clientid'],$params['date']);
        break;    
    }

    if(!empty($data2)){
        $totaldb = $data2[0]['db'];
        $totalcr = $data2[0]['cr'];
        $totalbal = $data2[0]['balance'];
    }else{
        $totaldb = "0.00";
        $totalcr = "0.00";
        $totalbal = "0.00";
    }
    echo json_encode(array('customerdata' => $data,'totaldb'=>$totaldb,'totalcr'=>$totalcr,'totalbal'=>$totalbal));
   }

   public function actionComputeinventory(){
    $clientid = $_GET['clientid'];
    $date = $_GET['date'];
    $filter = $_GET['filter'];
    $params = array('clientid'=>$clientid,'date'=>$date,'filter'=>$filter);
    $data = Yii::$app->backend->computeinvtry($params);
    $costaccess = Yii::$app->backend->viewcostAccess();
    echo json_encode(array('customerdata' => $data,'costaccess'=>$costaccess));
   }

   public function actionLog(){
    $params = array("clientid"=>$_GET['trno']);
    $data = Yii::$app->weblisting->showlogs($this,$params);
    echo json_encode(array('logs'=>$data));
   }//END ACTION LOG

    public function actionGetterms(){
    $data = Yii::$app->backend->loadAvailableterms();
    echo json_encode(array('terms'=>$data));
   }//END GET TERMS

    public function actionGetarealist(){
        $data = Yii::$app->backend->getArealist();
        echo json_encode(array('area'=>$data));
    }//end

    public function actionGetprovincelist(){
        $data = Yii::$app->backend->getProvincelist();
        echo json_encode(array('province'=>$data));
    }//end

    public function actionGetregionlist(){
        $data = Yii::$app->backend->getRegionlist();
        echo json_encode(array('region'=>$data));
    }//end

    public function actionGetclientcatlist(){
        $data = Yii::$app->backend->getClientCatlist();
        echo json_encode(array('category'=>$data));
    }//end

    public function actionGetclientgrouplist(){
        $data = Yii::$app->backend->getClientGrplist();
        echo json_encode(array('clientgrp'=>$data));
    }//end


   	// ================ JAD UPDATE G ====================
   	
   		public function actionGetassetcategorylist() {
   			$data = Yii::$app->backend->getAssetCatList();
   			echo json_encode(array('assetcat'=>$data));
   		}
   		public function actionGetassetlocationlist() {
   			$data = Yii::$app->backend->getAssetLocList();
   			echo json_encode(array('assetloc'=>$data));
   		}
    

    public function actionLoadclientunpaid(){
      Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcLoadclientunpaid($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/showmsg']));
        }else{
           echo json_encode(array('unpaidacc' => $return['unpaidacc']));
        }              
    }//END ACTION LOAD CLIENT UNPAID


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

    public function actionRequestclientpo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcRequestclientpo($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/showmsg']));
        }else{
           echo json_encode(array('clientpo' => $return['clientpo'],'type'=>$return['type']));      
        }                                       
    }//end requestclientpo


    public function actionGetclientdistributionarea(){
        Yii::$app->backend->AjaxVerification($this);
        $data = Yii::$app->backend->getClientDistributionarealist();
        echo json_encode(array('distribution'=>$data));
    }//end if getclient distribution

    public function actionGetclientcollectionarea(){
        Yii::$app->backend->AjaxVerification($this);
        $data = Yii::$app->backend->getClientCollectionarealist();
        echo json_encode(array('collection'=>$data));
    }//end if getclient distribution
    

    public function actionGetavailroutes(){
        Yii::$app->backend->AjaxVerification($this);
        $qry = "select route_id,route_code,route_name from route_masterfile";
        $routes = Yii::$app->sbccommon->openTable($qry);
        echo json_encode(array('routes' => $routes));
    } //end action get avail routes       

    public function actionGetcustomerstats(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $return = Yii::$app->backend->getCustomerStats($params['yfilter'],$params['q'],$params['statview']);
        echo json_encode(array('stats'=>$return['stats'],'grandtotal'=>$return['grandtotal']));
    }//end ction get stats

    public function actionGetsccity(){
        Yii::$app->backend->AjaxVerification($this);
        $return = Yii::$app->backend->getAvailable_SCcity();
        echo json_encode(array('sccity'=>$return));
    }//end action get sc city

    public function actionContrasearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
        $return=Yii::$app->sbccontroller->sbcContrasearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/showmsg']));
        }else{
           echo json_encode(array('searchitems' => $return['searchitems']));
        }                                       
    }//END CONTRA
}
