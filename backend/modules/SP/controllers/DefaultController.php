<?php
namespace backend\modules\SP\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;

//FOR TESTING PURPOSES
use app\models\Item;
use app\models\Cntnum;

use yii\web\Response;

class DefaultController extends Controller
{
   	public $access = array('view' => 3184,'edit' => 3185,'new' => 3186,'save' => 3187,
        'change' => 3188,'delete' => 3189,'print' => 3190,'lock' => 3191,
        'unlock' => 3192,'post' => 3194,'unpost' => 3195,'changeamount' => 3193,
        'clickadditem'=>3196,'clickedititem'=>3197,'clickdeleteitem'=>3198);

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

    public function actionAutogenerate(){
      $qry = "select distinct supplier from sp_transfer.spprices as sp";
    }//end action

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $return=Yii::$app->sbccontroller->sbcindex($this);        
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           return $this->render('index',array('moduledata' => $return['moduledata'],'moduleid'=>$return['moduleid']));        
        }
    }//END ACTION INDEX

    //FOR BUTTON FUNCTIONS ###################################################################################

    public function actionDeletedoc(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET['params'];
        $return=Yii::$app->sbccontroller->sbcDeletedoc($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data'],'istransposted'=>$return['istransposted']];
            //echo json_encode(array('moduledata' => $return['data'],'istransposted'=>$return['istransposted']));
        }                               
    }

    public function actionStockdelete(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcStockdelete($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']];
            //echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']));
        }                                       
    }

    //FOR LOADING DATA FROM NAV BUTTONS
    public function actionNavbuttons(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNavbuttons($this,$params);                
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data']];
            //echo json_encode(array('moduledata' => $return['data']));
        }
    }//END ACTION NAVBUTTONS

    public function actionGetitembalance(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetitembalance($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['postedpobal'=>$return['postedpobal'],
            'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
            'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal']];
    /* echo json_encode(array('postedpobal'=>$return['postedpobal'],
            'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
            'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal'])); */
        }
    }//END SHOW STOCK

    public function actionUomlookup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['itemid'=>$_POST['x']];
        return Yii::$app->automator->automateUOMlookupGV($params);
    }//end function

   public function actionGetuom(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetuom($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['uom'=>$return['data']];
            //echo json_encode(array('uom'=>$return['data']));
        }                                       
    }//END UOM

    public function actionPulldata(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $primarykey =$_GET['primarykey'];
            $type = $_GET['type'];
            $isqty = $_GET['qty'];
            $uom = $_GET['uom'];
            $whcode = $_GET['whcode'];
            $whname = $_GET['wh'];
            $itemamt =str_replace(",","",$_GET['amt']); 
            $uomfactor = $_GET['uomfactor'];
            $disc = $_GET['disc'];
            $forex = $_GET['forex'];
            $trno = $_GET['trno'];
            $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);

            $computeddata = Yii::$app->backend->computestock($itemamt,$disc,$isqty,$uomfactor,$this);

            $primarydata[0]['trno'] = $trno;  
            $primarydata[0]['ext'] = $computeddata['ext'];
            $primarydata[0]['qty'] = $computeddata['qty'];
            $primarydata[0]['rrqty'] = $isqty;
            $primarydata[0]['cost'] = $computeddata['cost'] * $forex;
            $primarydata[0]['disc'] = $disc;
            $primarydata[0]['rrcost'] = $itemamt;
            $primarydata[0]['uom'] = $uom;
            $primarydata[0]['uomfactor'] = $uomfactor;
            $primarydata[0]['whcode'] = $whcode;
            $primarydata[0]['whname'] = $whname;

            $moduledata["barcode"]= $primarydata[0]["barcode"];
            $moduledata["itemid"]= $primarydata[0]["itemid"];
            $moduledata["category"]= $primarydata[0]["category"];
            $moduledata["groupid"]= $primarydata[0]["groupid"];
            $moduledata["itemname"]= $primarydata[0]["itemname"];
            $moduledata["uom"]= $primarydata[0]["uom"];
            $moduledata["rrcost"]= $primarydata[0]["rrcost"];
            $moduledata["ext"]= $primarydata[0]["ext"];
            $moduledata["disc"]= $primarydata[0]["disc"];
            $moduledata["rem"]= $primarydata[0]["rem"];
            $moduledata["qty"]= $primarydata[0]["qty"];
            $moduledata["rrqty"]= $primarydata[0]["rrqty"];
            $moduledata["cost"]= $primarydata[0]["cost"];
            $moduledata["uomfactor"]= $primarydata[0]["uomfactor"];
            $moduledata["whcode"]= $primarydata[0]["whcode"];
            $moduledata["whname"]= $primarydata[0]["whname"];
            

            $moduledata["trno"]= $primarydata[0]["trno"];
            $moduledata["line"]= 0;
            $moduledata["refx"]= 0;
            $moduledata["linex"]= 0;
            $moduledata["ref"]= '';
            $returndata = Yii::$app->webprocess->savingstock($this,$this->access['save'],$moduledata);

            $return['stockline']['gvrow-'.$returndata['line']] = $returndata;
            $return['line'] = $returndata['line'];          
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;
            //echo json_encode($return);
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END PULL DATA

    public function actionSavestock(){
        Yii::$app->backend->AjaxVerification($this);    
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavestock($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;
        }            
    }

    public function actionCanceledit(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcCanceledit($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['stockdata' => $return['data']];
            //echo json_encode(array('stockdata' => $return['data']));
        }                                       
    }

    //FOR COMPUTATION OF STOCK
    public function actionComputestock(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;

        $return=Yii::$app->sbccontroller->sbcComputestock($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['computeddata' => $return['data']];
            //echo json_encode(array('computeddata' => $return['data']));
        }                                       
    }

    public function actionComparestocklines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;   
        Yii::$app->sbccontroller->sbcComparestocklines($this,$params);          
    }

    public function actionQuickadditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcQuickadditem($this,$params);  
    }

    public function actionUnpost(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcUnpost($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']];
            //echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']));
        }                                       
    }

	public function actionPost(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcPost($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
            'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']];
            /* echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
            'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted'])); */
        }                                       
    }

    public function actionReqprice(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcReqprice($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['pricedata'=>$return['pricedata']];
            //echo json_encode(array('pricedata'=>$return['pricedata']));
        }                                       
    }

    public function actionLoaduoms() {
        $barcode = $_POST['x'];
        $itemid = Yii::$app->backend->requestItemid($barcode);
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['itemid'] = $itemid;
        $params['controller'] = $this;
        return Yii::$app->automator->automateUomlookup($params);
    }
  
    public function actionLockunlock(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcLockunlock($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'istransposted'=>$return['istransposted']];
            //echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'istransposted'=>$return['istransposted']));
        }                                       
    }

    public function actionLoaditembal() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItembal($params);
    }
    
    public function actionDocnolookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateDocnolookup($params);
    }

    public function actionItemlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItemlookupGV($params);
    }

    public function actionSavehead(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavehead($this,$params);  

        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
            'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted']];
            /* echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
            'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted'])); */
        }                               
    }

   //LOADS LAST DOCUMENT
    public function actionLoadlastdoc(){
        Yii::$app->backend->AjaxVerification($this);
        $return=Yii::$app->sbccontroller->sbcLoadlastdoc($this);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data']];
            //echo json_encode(array('moduledata' => $return['data']));
        }                                       
    }

    public function actionSupplierlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSupplierlookup($params);
    }

    public function actionGetclientinfo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetclientinfo($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['clientdata' => $return['data']];
            //echo json_encode(array('clientdata' => $return['data']));
        }               
    }

    public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);                         
    }

    public function actionNewdocument(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNewdocument($this,$params);   
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data']];
            //echo json_encode(array('moduledata' => $return['data']));
        }        
    }//END NEW DOCUMENT

    public function actionSearchdocno(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcSearchdocno($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => '','access'=> 0];
            //echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data'],'access'=> 1];
            //echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        }                                       
    }//END SEARCH DOCNO

    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');

        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
        
        $params = [
            'sql' => $sql,
            'tableid' => 'spstockview',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'itemname',
                    'editable' => true,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],[
                    'name' => 'uom',
                    'editable' => true,
                    'label' => 'UOM',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'uom',
                                        'colw'=>'col-min',
                                        'lookupclass'=>'gvbtns stockuomlookup',
                                        'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'rrcost2',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '0.00',
                    'label' => 'Prev Cost',
                    'type' => 'text',
                    'class' => 'col-currency  stocktxt txtisamt'
                ],[
                    'name' => 'disc2',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '',
                    'label' => 'Prev Disc',
                    'type' => 'text',
                    'class' => 'col-min stocktxt  txtisdisc'
                ],[
                    'name' => 'ext2',
                    'label' => 'Prev Net',
                    'editable' => true,
                    'readonly' => true,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],[
                    'name' => 'rrcost',
                    'editable' => true,
                    'default' => '0.00',
                    'label' => 'New Cost',
                    'type' => 'text',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
                ],[
                    'name' => 'disc',
                    'editable' => true,
                    'default' => '',
                    'label' => 'New Disc',
                    'type' => 'text',
                    'class' => 'col-min stocktxt txtcompute txtisdisc'
                ],[
                    'name' => 'ext',
                    'label' => 'New Net',
                    'editable' => true,
                    'readonly' => true,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],[
                    'name' => 'rem',
                    'editable' => true,
                    'default' => '----',
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description stocktxt txtrem'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'qty',
                    'hidden' => true,
                    'class' => 'txtqty txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'cost',
                    'hidden' => true,
                    'class' => 'txtcost txthidden',
                    'default'=>'0',
                ],
                [
                    'name' => 'cost2',
                    'hidden' => true,
                    'class' => 'txtcost2 txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'itemid',
                    'hidden' => true,
                    'class' => 'txtstockitemid txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'uomfactor',
                    'hidden' => true,
                    'class' => 'txtstockfactor txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtstockrefx txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtstocklinex txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'void',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => '0'
                ],[
                    'name' => 'tr',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google'
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'showbalance  gvbtns btn btn-social-icon btn-github'
                ]
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

}
