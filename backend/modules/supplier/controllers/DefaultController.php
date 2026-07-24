<?php

namespace backend\modules\supplier\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;
use app\models\Client;
use yii\web\Response;

class DefaultController extends Controller{
     public $access = array(
        'view' => 32,'edit' => 33,'new' => 34,'save' => 35,
        'change' => 36,'delete' => 37,'print' => 38);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['verified'=>$return];
        //echo json_encode(array('verified'=>$return)); 
    }

    public function actionGetarealist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateArealookup($this);
    }//end

    public function actionGetcomputeacctg() {
        $clientid = $_GET['clientid'];
        $date = $_GET['date'];
        $type = $_GET['type'];
        switch($type) {
            case 'AP':
                $data2 = Yii::$app->backend->openAPsum($clientid,$date);
            break;
            case 'AR':
                $data2 = Yii::$app->backend->openARsum($clientid,$date);
            break;
            case 'PDC':
                $data2 = Yii::$app->backend->openPDCsum($clientid,$date);
            break;
            case 'RC':
                $data2 = Yii::$app->backend->openRCsum($clientid,$date);
            break;
        }
        if(!empty($data2)) {
            $totaldb = $data2[0]['db'];
            $totalcr = $data2[0]['cr'];
            $totalbal = $data2[0]['balance'];
        } else {
            $totaldb = "0.00";
            $totalcr = "0.00";
            $totalbal = "0.00";
        }

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['totaldb'=>$totaldb, 'totalcr'=>$totalcr, 'totalbal'=>$totalbal];
        //return json_encode(array('totaldb'=>$totaldb, 'totalcr'=>$totalcr, 'totalbal'=>$totalbal));
    }


    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){   
           if(isset(Yii::$app->session['loggeduser'])){
                $data = Yii::$app->weblisting->index($this,$this->access['view']);  
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                $costaccess = Yii::$app->backend->viewcostAccess();
                return $this->render('index',array('moduleid'=>$moduleid,'customerdata'=>$data,'viewcosting'=>$costaccess));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            } //END IF
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }
    }//END ACTION INDEX

    public function actionNewclientdata(){
        $client = $_GET['client'];
        $params = array('client' => $client);
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
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
            $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
            $data = Yii::$app->weblisting->savinghead($this,$this->access['save'],$xxx,$moduleid);

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$data['head']['status'],'clientid'=>$data['head']['clientid'],'client' => $data['head']['client'],'msg'=>$data['head']['msg']];
            //echo json_encode(array('status'=>$data['head']['status'],'clientid'=>$data['head']['clientid'],'client' => $data['head']['client'],'msg'=>$data['head']['msg']));
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function actionLoadstats(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateStats($this,$params);
    }
    
    public function actionGetsupplierstats(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');

        $yearqry = "select DISTINCT year from (select year(head.dateid) as year from glhead as head 
                    left join glstock as stock on stock.trno=head.trno 
                    left join client on client.clientid=head.clientid 
                    left join cntnum on cntnum.trno=head.trno 
                    where head.doc='RR' and head.dateid and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                    and client.client = '".$params['q']."' 
                    group by head.dateid, head.docno, client.client, client.clientname) as a";
                    
        $years = Yii::$app->sbccommon->opentable($yearqry);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['years'=>$years];
        //echo json_encode(array('years'=>$years));   
    }//end ction get stats

    public function actionNavbuttons(){
        $params = $_GET['params'];
        $action = $_GET['action'];
         $data = Yii::$app->weblisting->viewing($this,$this->access['view'],$action,$params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['customerdata' => $data];
        //echo json_encode(array('customerdata' => $data));
    }//END ACTION NAVBUTTONS        

    public function actionDeleteclient(){
        $xxx = $_GET['params'];
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->deleting($this,$this->access['delete'],$xxx);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
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

    public function actionComputeacctg(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputeacctg($params);
    }

    public function actionSupplierlookupsearch(){
         Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSupplierlookup($params);

    } //END ACTION CUSTOMER LOOKUP SEARCH

    public function actionComputeinventory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputeinv($params);   
    }

    public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);
    }

    public function actionGetcategory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateCategorylookup($params);
    }//end action
    
    public function actionAgentlookupsearch(){
        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchagent = Yii::$app->backend->searchagents($this,$this->access['view'],$searchstring);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['searchagent' => $searchagent];
        //echo json_encode(array('searchagent' => $searchagent));
    }//END ACTION CUSTOMER LOOKUP SEARCH
    
    public function actionLoadterms() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateTermslookup($params);
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
    

    public function actionGetclientinfo(){
         $client = new Client;
         $clientid = $_GET['clientid'];
         $type = 'supplier';
         $data = $client->openclient($clientid,$type);
         $origdata = $data[0];

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['clientdata' => ['head'=>$origdata]];
        //echo json_encode(array('clientdata' => array('head'=>$origdata)));
    } // ACTION GET CLIENTINFO

    public function actionGetagentinfo(){
        $client = new Client;
        $agcode = $_GET['agcode'];
        $type = $_GET['type'];
        $data = $client->openclient($agcode,$type);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['clientdata' => $data];
        //echo json_encode(array('clientdata' => $data));
    } // ACTION GET CLIENTINFO

    public function actionGetterms(){
        $data = Yii::$app->backend->loadAvailableterms();

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['terms'=>$data];
        //echo json_encode(array('terms'=>$data));
    }//END GET TERMS

    public function actionGetprovincelist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateProvincelookup($this);
    }//end

    public function actionGetregionlist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateRegionlookup($this);
    }//end
    
    public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientlookup($params);
    }
    
    public function actionLoadclientunpaid(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientunpaid($params);
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


            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$status,'picture'=>$picture,'error'=>$errors];
            //echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end function uploading pic
    
    public function actionGetclientcatlist(){
        $data = Yii::$app->backend->getClientCatlist();

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['category'=>$data];
        //echo json_encode(array('category'=>$data));
    }//end

    public function actionGetclientgrouplist(){
        $data = Yii::$app->backend->getClientGrplist();

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['clientgrp'=>$data];
        //echo json_encode(array('clientgrp'=>$data));
    }//end
    
}//END CONTROLLER