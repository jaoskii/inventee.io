<?php
namespace backend\modules\posstockcard\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

use app\models\Item;
use yii\base\ErrorException;

class DefaultController extends Controller
{
       public $access = array(
        'view' => 12,'edit' => 13,'new' => 14,'save' => 15,
        'change' => 16,'delete' => 17,'print' => 18);


    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    } 

    public function actionUomlookup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['itemid'=>$_POST['x']];
        return Yii::$app->automator->automateUOMlookupGV($params);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }

    public function actionIndex(){   
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $data = Yii::$app->weblisting->index($this,$this->access['view']);         
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                $costaccess = Yii::$app->backend->viewcostAccess();
                return $this->render('index',array('moduleid'=>$moduleid,'stockcarddata'=>$data,'viewcosting'=>$costaccess));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }
    }

    public function actionItemlookupsearch(){                 
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItemlookupGV($params);
    }

    public function actionGetclientinfo(){
        $item = new Item;
        $itemid = $_GET['clientid'];
        $data = $item->openitem($itemid);
        echo json_encode(array('clientdata' => array('head'=>$data)));
    }

    public function actionGetdivision(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        

        $qry = "select stockgrp_id as line, stockgrp_code as Code, stockgrp_name as Name from stockgrp_masterfile where stockgrp_name LIKE '%".$params['x']."%'";
        
        $params = [
            'sql' => $qry,
            'tableid' => 'group-lookup',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                ['name' => 'Name','class' => 'aimslabel col-description']
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'pickgroupid btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name' => 'stockgrp','value'=>'Name'],['name' => 'stockgrpid','value' => 'Code']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionNewdataitem(){
        $barcode = $_GET['barcode'];
        $copy = $_GET['copyprevdata'];
        $params = array('barcode' => $barcode,'copyprevdata'=>$copy);
        $access = $this->access['new'];
        $barcode = Yii::$app->backend->sanitize($barcode,'DEFAULT');
        $data = Yii::$app->weblisting->stockcardnewing($this,$access,$params);
        
        echo json_encode(array('moduledata' => $data));
    }

    public function actionLoadlastdoc(){
        $data = Yii::$app->weblisting->index($this,$this->access['view']);
        echo json_encode(array('moduledata' => $data));
    }

    public function actionSavehead(){
        $xxx = $_POST;
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        // var_dump($xxx);
        // return 0;
        $data = Yii::$app->weblisting->savingitem($this,$this->access['save'],$xxx); 
        echo json_encode(array('itemid' => $data['itemid'],'msg'=>$data['msg'],'err_uom'=>$data['uom_error'],'errstat'=>$data['errstat'],'type'=>$data['type']));
    }

    public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);
    }

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
    }

    public function actionSearchdocno(){
        $barcode = $_GET['docno'];
        $params = array('barcode' => $barcode);
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
        $access = array('view' => $this->access['view'],'new' => $this->access['new']);
        $data = Yii::$app->weblisting->searchingitem($this,$access,'search',$params);
        echo json_encode(array('moduledata' => $data));
    }

    public function actionWarehouselookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateWarehouselookupGV($params);
    }

    public function actionGetuom(){
        $barcode = $_POST['x'];
        $itemid = Yii::$app->backend->requestItemid($barcode);
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['itemid'] = $itemid;
        $params['controller'] = $this;
        $params['type']='temp';
        return Yii::$app->automator->automateUomlookup($params);
    }

    public function actionGetuom2() {
        $barcode = $_GET['barcode'];
        $itemid = Yii::$app->backend->requestItemid($barcode);
        $data = Yii::$app->backend->loadAvailableuom($itemid);
        echo json_encode(array('uom'=>$data));
    }

    public function actionGetreceivingtotal() {
        $itemid = $_GET['itemid'];
        $uom = $_GET['uom'];
        $wh = $_GET['wh'];
      
        $data = Yii::$app->backend->getReceivingTotal($itemid,$wh,$uom);
        if(!empty($data)) {
            $totalin = number_format($data[0]['qty'],2);
            $totalout = number_format($data[0]['iss'],2);
            $totalbal = number_format($data[0]['bal'],2);
        } else {
            $totalin = number_format(0,2);
            $totalout = number_format(0,2);
            $totalbal = number_format(0,2);
        }
        echo json_encode(array('totin'=>$totalin,'totout'=>$totalout,'totbal'=>$totalbal));
    }

    public function actionComputewh(){
        $itemid = $_GET['itemid'];
        $date = $_GET['date'];
        $uom = $_GET['uom'];
        $wh = $_GET['wh'];
        $params = array('itemid'=>$itemid,'date'=>$date,'uom'=>$uom,'wh'=>$wh);
        $data = Yii::$app->backend->computewh($params);
        echo json_encode(array('customerdata' => $data));
    }

  public function actionGetledgertotal() {
        $itemid = $_GET['itemid'];
        $uom = $_GET['uom'];
        $wh = $_GET['wh'];
        $data = Yii::$app->backend->getLedgerTotal($itemid,$wh,$uom);
        if(!empty($data)) {
            $totalin = number_format($data[0]['qty'],2);
            $totalout = number_format($data[0]['iss'],2);
            $totalbal = number_format($data[0]['balance'],2);
        } else {
            $totalin = number_format(0,2);
            $totalout = number_format(0,2);
            $totalbal = number_format(0,2);
        }
        echo json_encode(array('totin'=>$totalin,'totout'=>$totalout,'totbal'=>$totalbal));
    }

    public function actionGetunf(){
        try {
            $itemid = $_GET['itemid'];
        $data = Yii::$app->backend->getunf($itemid);
        echo json_encode(array('uom'=>$data));
        
          } catch (ErrorException $e) {
            echo $e;
          }
        
    }

    public function actionInsertuom(){
        $params = $_GET;
        $data = Yii::$app->backend->insertToUOMtbl($params);
        echo json_encode(array('status'=>$data['status'],'msg'=>$data['msg'],'data'=>$data['data'],'type'=>$data['type']));
    }

    public function actionCheckuomtrans(){
        $itemid = $_GET['itemid'];
        $uom = $_GET['uom'];
        $data = Yii::$app->backend->UOMhastransaction($uom,$itemid);
        echo json_encode(array('status'=>$data));
    }

    public function actionDeleteitemuom(){
        $itemid = $_GET['params']['itemid'];
        $line = $_GET['params']['line'];
        $uom = $_GET['params']['uom'];
        $data = Yii::$app->backend->removeItemUOM($itemid,$uom,$line); 
        echo json_encode(array('status'=>$data['status'],'msg'=>$data['msg']));
    }

    public function actionGetbrand(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateBrandlookup($this);
    }

    public function actionUploadpic(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
        $files = $_FILES;
        $return = Yii::$app->backend->uploadImage($files,'PRIMARY_STOCKCARD',$params);
        $checking = Yii::$app->sbccommon->opentable('select codeid from itimages where codeid = "'.$_POST['codeid'].'"');
        if(empty($checking)) {
            $qry = "insert into itimages (codeid,picture,filename) values('".$_POST['codeid']."','".$return['dbpic']."','')";
            $status =  Yii::$app->sbccommon->execqry($qry);
        } else {
            $qry = "update itimages set picture = '".$return['dbpic']."' where codeid = '".$_POST['codeid']."'";
            $status =  Yii::$app->sbccommon->execqry($qry);
        }
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }

    public function actionUploadgallerypic(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
        $files = $_FILES;
        $return = Yii::$app->backend->uploadImage($files,'ITEMGALLERY',$params);
        $checking = Yii::$app->sbccommon->opentable('select itemid from item_gallery where itemid = "'.$params['codeid'].'"');
        if(empty($checking)) {
            $qry = "insert into item_gallery (itemid,img".$params['index'].") values('".$params['codeid']."','".$return['dbpic']."')";
            $status =  Yii::$app->sbccommon->execqry($qry);
        } else {
            $qry = "update item_gallery set img".$params['index']." = '".$return['dbpic']."' where itemid = '".$params['codeid']."'";
            $status =  Yii::$app->sbccommon->execqry($qry);
        }
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }

    public function actionLoaditembal() {
    Yii::$app->backend->AjaxVerification($this);
    $params = $_POST;
    $params['controller'] = $this;
    return Yii::$app->automator->automateItembal($params);
   }

    public function actionGetitembalance(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcGetitembalance($this,$params);  
      if($return['verifyuser']==1){
         return $this->redirect(Url::to(['/admin/default/login']));
      }elseif($return['verifyaccess']==1){
         return $this->redirect(Url::to(['/admin/default/401']));
      }else{
          echo json_encode(array('postedpobal'=>$return['postedpobal'],
          'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
          'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal']));
      }                                     
   }

   public function actionTagitemtocategory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
        $return = Yii::$app->backend->setFrontendItemCategory($params);
        echo json_encode(array('status'=>$return['status'],'msg'=>$return['msg'],'tagging'=>$return['tagging']));
   }

   public function actionComputediscountedpercent(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $discounted = Yii::$app->backend->computeFrontendDiscount($params['sprice'],$params['ogprice']);
        echo json_encode(array('discounted'=>$discounted));
    }

   public function actionGetsubcategories(){
        Yii::$app->backend->AjaxVerification($this);
        $subcat = Yii::$app->backend->getItemSubcategories();
        echo json_encode(array('subcat'=>$subcat));
   }

   public function actionGetcommissiongrp(){
        Yii::$app->backend->AjaxVerification($this);
        $commgrp = Yii::$app->backend->getItemCommissionGrp();
        echo json_encode(array('commgrp'=>$commgrp));
   }

   public function actionWysiwyg(){
        $params = $_GET;
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $this->layout = "@app/views/layouts/backend/main";
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $qry = "select ".$params['f']." from item where itemid = " . $params['q'];
                $data = Yii::$app->sbccommon->datareader($qry);
                return $this->render('wysiwyg',array('moduleid'=>$moduleid,'key'=>$params['q'],'f'=>$params['f'],'toedit'=>$data));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }
   }

   public function actionUpdatedatawys(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $qry = "update item set ".$params['f']."= '".$params['tinyval']."' where itemid = ".$params['q']."";
        $status = Yii::$app->sbccommon->execqry($qry);
        echo json_encode(['status'=>$status]);
   }



    public function actionClearimg(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $defaultpic = Yii::$app->systemsettings->defaultSystemImage();
        $qry = "select img".$params['i']." from item_gallery where itemid =".$params['q']."";
        $pathtoremoval = Yii::$app->sbccommon->datareader($qry);
        if(!empty($pathtoremoval) || $pathtoremoval != '') {
            $pathtoremoval = str_replace(Yii::$app->homeUrl,'',$pathtoremoval);
            if (file_exists($pathtoremoval)) {
                unlink($pathtoremoval);
                $qryupdate = "update item_gallery set img".$params['i']." = '' where itemid = ".$params['q']."";
                $status =  Yii::$app->sbccommon->execqry($qryupdate);
                if($status) {
                    $msg = "Image has been removed successfully!";
                } else {
                    $msg = "Error occured while removing image. Please try again.";
                }
            } else {
                $msg = "Image is already removed. Please refresh your itemdata.<br>" . $pathtoremoval;
                $status = false;
            }
        } else {
            $msg = "Image is already removed. Please refresh your itemdata.";
            $status = false;
        }
        echo json_encode(['status'=>$status,'msg'=>$msg,'defaultpic'=>$defaultpic]);
    }

    public function actionChangeitembarcode(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $itemid = Item::checkbarcode($params['n']);
        $oldbarcode = Yii::$app->backend->requestItemBarcode($params['i']);
        $truncated = 0;
        if(strlen($params['n']) > Yii::$app->systemsettings->setDefaultBarcodeLength() && Yii::$app->systemsettings->setDefaultBarcodeLength() != 0) {
            $status = false;
            $msg = 'Entered barcode exceeded with maximum barcode length. Please enter exact length.
                    Required barcode length is <b>'.Yii::$app->systemsettings->setDefaultBarcodeLength().'</b>';
        } elseif(strlen($params['n']) < Yii::$app->systemsettings->setDefaultBarcodeLength() && Yii::$app->systemsettings->setDefaultBarcodeLength() != 0) {
            $status = false;
            $msg = 'Entered barcode has insufficient length. Please enter exact length.
                    Required barcode length is <b>'.Yii::$app->systemsettings->setDefaultBarcodeLength().'</b>';
        } elseif(strlen($params['n']) == Yii::$app->systemsettings->setDefaultBarcodeLength() || Yii::$app->systemsettings->setDefaultBarcodeLength() == 0) {
            if($itemid == 0) {
                $status = Yii::$app->backend->changeItemBarcode($params['n'],$oldbarcode);
                if($status) {
                    $msg = 'Item barcode changing success!';
                } else {
                    $msg = 'Update Barcode failed. Something went wrong. Please try again.';
                }
            } else {
                $status = false;
                $msg = 'Barcode is already taken. Please try another one.';
            }
        }

        echo json_encode(['status'=>$status,'msg'=>$msg,'newbarcode'=>$params['n']]);
    }

    public function actionComputeledger(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputeledger($params);
    }

    public function actionComputereceiving(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputereceiving($params);
    }



    public function actionGetpart(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automatePartlookup($this);
    }

    public function actionGetmodel(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateModellookup($this);
    }//end action


    public function actionGetclass(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateClasslookup($this);
    }

public function actionGetbody(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateBodylookup($this);
    }//end action
     public function actionGetsize(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateSizelookup($this);
    }//end action
    public function actionGetcategory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateCategorylookup($params);
    }//end action

     public function actionGetgroup(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateGrouplookup($this);
    }//end action

    public function actionContrasearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);
    }//END CONTRA


    
    //ALVIN END
    public function actionComputepacking(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        // var_dump($params);
        // return 0;
        $params['controller'] = $this;
        
        return Yii::$app->automator->automateComputepacking($params);
    }

    public function actionComputesupplier(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        // var_dump($params);
        // return 0;
        $params['controller'] = $this;
        
        return Yii::$app->automator->automateComputesupplier($params);
    }
    
    public function actionComputeunposted(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        // var_dump($params);
        // return 0;
        $params['controller'] = $this;
        
        return Yii::$app->automator->automateComputeunposted($params);
    }


    public function actionLoadcomponentitems() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComponentitems($params);
    }//end f

    public function actionSavecomponentitem() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $data = [];
        if($params['line'] == '0') { // new record
            if(Yii::$app->sbccommon->execqry("insert into component(itemid, barcode, itemname, isqty, qty, uom) values('{$params['itemid']}', '{$params['barcode']}', '{$params['itemname']}', '{$params['qty']}', '{$params['qty']}', '{$params['uom']}')")) {
                $data = Yii::$app->sbccommon->opentable("select line, itemid from component where itemid = '{$params['itemid']}' order by line desc limit 1");
                $msg = "Component Saved";
                $status = true;
            } else {
                $msg = "Error Saving Component";
                $status = false;
            }
        } else { // update record
            if(Yii::$app->sbccommon->execqry("update component set qty = '{$params['qty']}', isqty = '{$params['qty']}' where line = '{$params['line']}'")) {
                $msg = "Component Updated";
                $status = true;
            } else {
                $msg = "Error Updating Component";
                $status = false;
            }
        }
        return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
    }//end f
}
