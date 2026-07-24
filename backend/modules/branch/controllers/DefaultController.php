<?php

namespace backend\modules\branch\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Client;
use yii\base\ErrorException;

class DefaultController extends Controller{


     public $access = array(
        'view' => 22,'edit' => 23,'new' => 24,'save' => 25,
        'change' => 26,'delete' => 27,'print' => 28);

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
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $data = Yii::$app->weblisting->index($this,$this->access['view']);  
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                return $this->render('index',array('moduleid'=>$moduleid,'branchdata'=>$data));
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

    // public function actionAgentlookupsearch(){

    //     $searchstring = $_GET['searchstring'];
    //     $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
    //     $searchagent = Yii::$app->backend->searchagents($this,$this->access['view'],$searchstring);
    //     echo json_encode(array('searchagent' => $searchagent));
    //     //var_dump($searchagent);


    // } //END ACTION CUSTOMER LOOKUP SEARCH

    public function actionGetclientinfo(){
         $client = new Client;
         $clientid = $_GET['clientid'];
         $type = 'branch';
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
        $xxx = $_GET['params'];
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->deleting($this,$this->access['delete'],$xxx);
        echo json_encode(array('moduledata' => $data));
        //var_dump($data);
    }

  public function actionComputeacctg(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputeacctg($params);
   }

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
        return json_encode(array('totaldb'=>$totaldb, 'totalcr'=>$totalcr, 'totalbal'=>$totalbal));
    }

   public function actionComputeinventory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputeinv($params);
   }
 public function actionRequestclientposummary() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierposummarized($params);
    }
     public function actionRequestclientpodetailed() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierpodetailed($params);
    }
  public function actionLoadclientunpaid(){
                

        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientunpaid($params);
    }//END ACTION LOAD CLIENT UNPAID

    public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);
    }

    public function actionGetterms(){
    $data = Yii::$app->backend->loadAvailableterms();
    echo json_encode(array('terms'=>$data));
   }//END GET TERMS

   


    // public function actionGetregionlist(){
    //     $data = Yii::$app->backend->getRegionlist();
    //     echo json_encode(array('region'=>$data));
    // }//end

    public function actionGetclientcatlist(){
        $data = Yii::$app->backend->getClientCatlist();
        echo json_encode(array('category'=>$data));
    }//end

    public function actionGetclientgrouplist(){
        $data = Yii::$app->backend->getClientGrplist();
        echo json_encode(array('clientgrp'=>$data));
    }//end

    public function actionGetgroup() {
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateGrouplookup($this);
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
$yearqry = "select DISTINCT year from (select year(head.dateid) as year from glhead as head 
                    left join glstock as stock on stock.trno=head.trno 
                    left join client on client.clientid=head.clientid 
                    left join cntnum on cntnum.trno=head.trno 
                    where head.doc='SJ' and head.dateid and cntnum.center = '".Yii::$app->session['loggeduser']['center']."'
                    and client.client = '".$params['q']."' 
                    group by head.dateid, head.docno, client.client, client.clientname) as a";
                    
        $years = Yii::$app->sbccommon->opentable($yearqry);
        echo json_encode(array('stats'=>$return['stats'],'grandtotal'=>$return['grandtotal'],'years'=>$years));   
        
    }//end ction get stats

    public function actionGetsccity(){
        Yii::$app->backend->AjaxVerification($this);
        $return = Yii::$app->backend->getAvailable_SCcity();
        echo json_encode(array('sccity'=>$return));
    }//end action get sc city

    public function actionSaveremarks(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $updatestring = '';

        foreach ($params as $key => $value) {
            if($updatestring == ''){
                $updatestring .= $key . "='".$value."'";
            }else{
                $updatestring .= ','.$key . "='".$value."'";
            }//end if
        }//end if
        $qry = "update client set ".$updatestring." where clientid = ".$_POST['clientid']."";
        $status = Yii::$app->sbccommon->execqry($qry);

        if($status){
            $msg = 'Other notes updated successfully!';
        }else{
            $msg = 'Error encountered while updating other notes. Please try again.';
        }//end if
        echo json_encode(['msg'=>$msg,'status'=>$status]);
    }//end action

    public function actionGetothernotes(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $fieldstring = '';

        foreach ($params as $key => $value) {
            if($fieldstring == ''){
                $fieldstring .= $key;
            }else{
                $fieldstring .= ','.$key;
            }//end if
        }//end if

        $qry = "select ".$fieldstring." from client where clientid = ".$_POST['clientid']."";
        $data = Yii::$app->sbccommon->opentable($qry);

        echo json_encode(['notes'=>$data]);
    }//end action get other notes

    public function actionLoadterms() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateTermslookup($params);
    }

    public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientlookup($params);
    }

    public function actionAgentlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateAgentlookup($params);
    } //END ACTION CUSTOMER LOOKUP SEARCH

      public function actionGetcategory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateCategorylookup($params);
    }//end

     public function actionGetprovincelist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateProvincelookup($this);
    }

     public function actionGetarealist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateArealookup($this);
    }

     public function actionGetregionlist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateRegionlookup($this);
    }

     public function actionContrasearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);
    }//END CONTRA

    public function actionLoadstats(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateStats($this,$params);
    }

    public function actionBranchwh() {
    	Yii::$app->backend->AjaxVerification($this);
    	$params = $_POST;
    	return Yii::$app->automator->automateBranchwh($this,$params);
    }

    public function actionBranchstation() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateBranchstation($this,$params);
    }

    public function actionGetbrand(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateBrandlookup($this);
    }

    public function actionBranchbrand() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateBranchbrand($this,$params);
    }

    public function actionBranchagent() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateBranchagent($this,$params);
    }

    public function actionBranchusers() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateBranchusers($this,$params);
    }

    public function actionBranchbank() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateBranchbank($this,$params);
    }

     public function actionTables() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateTables($this,$params);
    }

    public function actionLookuptables() {
        Yii::$app->backend->AjaxVerification($this);
        $qry = "select clientid, client, clientname, floor, isinactive from client where istable = 1 and isinactive <> 1 and clientid not in (select clientid from branchtables)";
        $params = [
            'sql' => $qry,
            'tableid' => 'tableslookupgrid',
            'key' => 'clientid',
            'txtclass' => 'tableslookuptextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'clientname',
                    'label' => 'Table',
                    'editable' => false,
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'floor',
                    'label' => 'Floor',
                    'editable' => false,
                    'class' => 'aimslabel col-codes'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-sign-in"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'picktable btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'q','value'=>'clientid'],
                                     ['name'=>'qname','value'=>'clientname'],
                                     ['name'=>'qfloor','value'=>'floor']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end f

    public function actionInserttobranchtables(){
        Yii::$app->backend->AjaxVerification($this);
        $param = $_GET['q'];
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
        $qryinsert = "insert into branchtables (clientid, client, clientname, inactive,dlock)
                      select c.clientid,c.client,c.clientname,
                      0 as inactive,'".$current_timestamp."' from client as c where c.clientid = " . $param;
        $status = Yii::$app->sbccommon->execqry($qryinsert);

        if($status){
            $msg = "Adding table successfully";
        }else{
            $msg = "Error adding tables!";
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end if

    public function actionEnabletables(){
        Yii::$app->backend->AjaxVerification($this);
        $param = $_GET['q'];
        $filter = $_GET['qq'];
        $qryupdate = "update branchtables set inactive = " . $param . " where clientid = " . $filter ;
        $status = Yii::$app->sbccommon->execqry($qryupdate);
        if($status) { $status = '1';}else{ $status = '0';}
        echo json_encode(['status'=>$status]);
    }//end f
    
    public function actionWarehouselookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateWarehouselookupGV($params);
    }


    public function actionSavebranchgrid() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $data = [];
        switch($params['tableid']) {
            case 'branchwhgrid':
                if($params['line'] == '0') { // new record
                    if(Yii::$app->sbccommon->execqry("insert into branchwh(clientid, wh, isdefault, isinactive) values('{$params['clientid']}', '{$params['wh']}', '{$params['isdefault']}', '{$params['isinactive']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, wh, isdefault, isinactive from branchwh where clientid = '{$params['clientid']}' order by line desc limit 1");
                        $msg = "Record Saved";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record";
                        $status = false;
                    }
                } else { // update record
                    if(Yii::$app->sbccommon->execqry("update branchwh set isdefault = '{$params['isdefault']}', isinactive = '{$params['isinactive']}' where line = '{$params['line']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, wh, isdefault, isinactive from branchwh where line = '{$params['line']}'");
                        $msg = "Record Updated";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                }
                return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
            break; // WAREHOUSE TAB
            case 'branchstationgrid':
                if($params['line'] == '0') { // new record
                    if(Yii::$app->sbccommon->execqry("insert into branchstation(clientid, station, ipaddress, localport, localdb, username, password, compname, compaddress, tin, comptel, operatedby, footer1, footer2, footer3, footer4, footer5, serialno, min, permitno, accredno, dateissued, isinactive) values('{$params['clientid']}', '{$params['station']}', '{$params['ipaddress']}', '{$params['localport']}', '{$params['localdb']}', '{$params['username']}', '{$params['password']}', '{$params['compname']}', '{$params['compaddress']}', '{$params['tin']}', '{$params['comptel']}', '{$params['operatedby']}', '{$params['footer1']}', '{$params['footer2']}', '{$params['footer3']}', '{$params['footer4']}', '{$params['footer5']}', '{$params['serialno']}', '{$params['min']}', '{$params['permitno']}', '{$params['accredno']}', '{$params['dateissued']}', '{$params['isinactive']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, station, ipaddress, localport, localdb, username, password, compname, compaddress, tin, comptel, operatedby, footer1, footer2, footer3, footer4, footer5, serialno, min, permitno, accredno, dateissued, isinactive from branchstation where clientid = '{$params['clientid']}' order by line desc limit 1");
                        $msg = "Record Saved";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record";
                        $status = false;
                    }
                } else { // update record
                    if(Yii::$app->sbccommon->execqry("update branchstation set station = '{$params['station']}', ipaddress = '{$params['ipaddress']}', localport = '{$params['localport']}', localdb = '{$params['localdb']}', username = '{$params['username']}', password = '{$params['password']}', compname = '{$params['compname']}', compaddress = '{$params['compaddress']}', tin = '{$params['tin']}', comptel = '{$params['comptel']}', operatedby = '{$params['operatedby']}', footer1 = '{$params['footer1']}', footer2 = '{$params['footer2']}', footer3 = '{$params['footer3']}', footer4 = '{$params['footer4']}', footer5 = '{$params['footer5']}', serialno = '{$params['serialno']}', min = '{$params['min']}', permitno = '{$params['permitno']}', accredno = '{$params['accredno']}', dateissued = '{$params['dateissued']}', isinactive = '{$params['isinactive']}' where line = '{$params['line']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, station, ipaddress, localport, localdb, username, password, compname, compaddress, tin, comptel, operatedby, footer1, footer2, footer3, footer4, footer5, serialno, min, permitno, accredno, dateissued, isinactive from branchstation where line = '{$params['line']}'");
                        $msg = "Record Updated";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                }
                return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
            break; // STATION TAB
            case 'branchbrandgrid':
                if($params['line'] == '0') { // new record
                    if(Yii::$app->sbccommon->execqry("insert into branchbrand(clientid, brand, isinactive) values('{$params['clientid']}', '{$params['brandid']}', '{$params['isinactive']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select b.line, b.clientid, b.brand as brandid, b.isinactive, brands.brand_desc as brand from branchbrand as b left join frontend_ebrands as brands on brands.brandid = b.brand where b.clientid = '{$params['clientid']}' order by b.line desc limit 1");
                        $msg = "Record Saved";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record";
                        $status = false;
                    }
                } else { // update record
                    if(Yii::$app->sbccommon->execqry("update branchbrand set brand = '{$params['brandid']}', isinactive = '{$params['isinactive']}' where line = '{$params['line']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select b.line, b.clientid, b.brand as brandid, b.isinactive, brands.brand_desc as brand from branchbrand as b left join frontend_ebrands as brands on brands.brandid = b.brand where b.line = '{$params['line']}'");
                        $msg = "Record Updated";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                }
                return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
            break; // BRANDS TAB
            case 'branchagentgrid':
                if($params['line'] == '0') { // new record
                    if(Yii::$app->sbccommon->execqry("insert into branchagent(clientid, client, clientname, inactive) values('{$params['clientid']}', '{$params['client']}', '{$params['clientname']}', '{$params['inactive']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, client, clientname, inactive from branchagent where clientid = '{$params['clientid']}' order by line desc limit 1");
                        $msg = "Record Saved";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                } else { // update record
                    if(Yii::$app->sbccommon->execqry("update branchagent set client = '{$params['client']}', clientname = '{$params['clientname']}', inactive = '{$params['inactive']}' where line = '{$params['line']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, client, clientname, inactive from branchagent where line = '{$params['line']}'");
                        $msg = "Record Updated";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                }
                return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
            break; // AGENTS TAB
            case 'branchusersgrid':
                if($params['line'] == '0') { // new record
                    if(Yii::$app->sbccommon->execqry("insert into branchusers(clientid, username, isinactive, type) values('{$params['clientid']}', '{$params['username']}', '{$params['isinactive']}', '{$params['type']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, username, isinactive, type, dlock from branchusers where clientid = '{$params['clientid']}' order by line desc limit 1");
                        $msg = "Record Saved";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record";
                        $status = false;
                    }
                } else { // update record
                    if(Yii::$app->sbccommon->execqry("update branchusers set username = '{$params['username']}', isinactive = '{$params['isinactive']}', type = '{$params['type']}' where line = '{$params['line']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, username, isinactive, type, dlock from branchusers where line = '{$params['line']}'");
                        $msg = "Record Updated";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                }
                return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
            break; // USERS TAB
            case 'branchbankgrid':
                if($params['line'] == '0') { // new record
                    if(Yii::$app->sbccommon->execqry("insert into branchbank(clientid, acno, terminalid, bank, isinactive, charges) values('{$params['clientid']}', '{$params['acno']}', '{$params['terminalid']}', '{$params['bank']}', '{$params['isinactive']}', '{$params['charges']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, acno, terminalid, bank, isinactive, charges from branchbank where clientid = '{$params['clientid']}' order by line desc limit 1");
                        $msg = "Record Saved";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                } else { // update record
                    if(Yii::$app->sbccommon->execqry("update branchbank set acno = '{$params['acno']}', terminalid = '{$params['terminalid']}', bank = '{$params['bank']}', isinactive = '{$params['isinactive']}', charges = '{$params['charges']}' where line = '{$params['line']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select line, clientid, acno, terminalid, bank, isinactive, charges from branchbank where line = '{$params['line']}'");
                        $msg = "Record Updated";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record";
                        $status = false;
                    }
                }
                return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
            break; // BANK TERMINAL TAB
        }
    }


    public function actionGetuser(){
        Yii::$app->backend->AjaxVerification($this);
        $params['controller'] = $this;
        return Yii::$app->automator->automateUsers2($params);
    }//end action
}//END CONTROLLER