<?php

namespace backend\modules\stockcard\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

use app\models\Item;
use app\models\Log;
use yii\base\ErrorException;
use yii\web\Response;

class DefaultController extends Controller{

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
        
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['verified'=>$return];
        //echo json_encode(array('verified'=>$return)); 
    }

    public function actionIndex(){   
        if(!isset(Yii::$app->session['loggeduser'])){
            return $this->redirect(Url::to(['/admin/default/login']));
        }
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            $data = Yii::$app->weblisting->index($this,$this->access['view']);         
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $this->layout = "@app/views/layouts/backend/main";
            $costaccess = Yii::$app->backend->viewcostAccess();

            return $this->render('index',array('moduleid'=>$moduleid,'stockcarddata'=>$data,'viewcosting'=>$costaccess));
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

    public function actionItemlookupinactivesearch(){                 
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItemlookup_inactiveGV($params);
    }

    public function actionGetclientinfo(){
        $item = new Item;
        $itemid = $_GET['clientid'];
        $data = $item->openitem($itemid);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['clientdata' => ['head'=>$data]];
        //echo json_encode(array('clientdata' => array('head'=>$data)));
    }

    public function actionNewdataitem(){
        $barcode = $_GET['barcode'];
        $copy = $_GET['copyprevdata'];
        $params = array('barcode' => $barcode,'copyprevdata'=>$copy);
        $access = $this->access['new'];
        $barcode = Yii::$app->backend->sanitize($barcode,'DEFAULT');
        $data = Yii::$app->weblisting->stockcardnewing($this,$access,$params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
    }

    public function actionLoadlastdoc(){
        $data = Yii::$app->weblisting->index($this,$this->access['view']);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
    }

    public function actionSavehead(){
        $xxx = $_POST;
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
        $data = Yii::$app->weblisting->savingitem($this,$this->access['save'],$xxx); 

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['itemid' => $data['itemid'],'msg'=>$data['msg'],'err_uom'=>$data['uom_error'],'errstat'=>$data['errstat'],'type'=>$data['type']];
        //echo json_encode(array('itemid' => $data['itemid'],'msg'=>$data['msg'],'err_uom'=>$data['uom_error'],'errstat'=>$data['errstat'],'type'=>$data['type']));
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

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
    }

    public function actionNavbuttons(){
        $params = $_GET['params'];
        $action = $_GET['action'];
        $data = Yii::$app->weblisting->viewing($this,$this->access['view'],$action,$params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['itemdata' => $data];
        //echo json_encode(array('itemdata' => $data));
    }

    public function actionSearchdocno(){
        $barcode = $_GET['docno'];
        $params = array('barcode' => $barcode);
        $params = Yii::$app->backend->sanitize($params,'ARRAY');
        $access = array('view' => $this->access['view'],'new' => $this->access['new']);
        $data = Yii::$app->weblisting->searchingitem($this,$access,'search',$params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['moduledata' => $data];
        //echo json_encode(array('moduledata' => $data));
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
        try {
            $barcode = $_GET['barcode'];
            $itemid = Yii::$app->backend->requestItemid($barcode);
            $data = Yii::$app->backend->loadAvailableuom($itemid,$this->module->id);

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['uom'=>$data];
            //echo json_encode(array('uom'=>$data));  
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function actionGetlocation(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['barcode'=>$_POST['x'],'factor'=>$_POST['factor']];
        return Yii::$app->automator->automateLocationlookupFilterGV($params);
    }//end get location

    public function actionGetreceivingtotal() {
        $itemid = $_GET['itemid'];
        $uom = $_GET['uom'];
        $wh = $_GET['wh'];
      
        $data = Yii::$app->backend->getReceivingTotal($itemid,$wh,$uom);
        if(!empty($data)) {
            $totalin = number_format((float)$data[0]['qty'],2);
            $totalout = number_format((float)$data[0]['iss'],2);
            $totalbal = number_format((float)$data[0]['bal'],2);
        } else {
            $totalin = number_format(0,2);
            $totalout = number_format(0,2);
            $totalbal = number_format(0,2);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['totin'=>$totalin,'totout'=>$totalout,'totbal'=>$totalbal];
        //echo json_encode(array('totin'=>$totalin,'totout'=>$totalout,'totbal'=>$totalbal));
    }

    public function actionComputewh(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputewh($params);
    }//end action
    
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

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['totin'=>$totalin,'totout'=>$totalout,'totbal'=>$totalbal];
        //echo json_encode(array('totin'=>$totalin,'totout'=>$totalout,'totbal'=>$totalbal));
    }

    public function actionInsertuom(){
        $params = $_GET;
        $data = Yii::$app->backend->insertToUOMtbl($params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$data['status'],'msg'=>$data['msg'],'data'=>$data['data'],'type'=>$data['type']];
        //echo json_encode(array('status'=>$data['status'],'msg'=>$data['msg'],'data'=>$data['data'],'type'=>$data['type']));
    }

    public function actionGetpriority(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automatePrioritylookup($params);
    }//end action

    public function actionGetuomprint(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateUomprintlookup($this,$_POST['x']);
    }

    public function actionGetsuppitemcode(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSuppItemCodelookup($params);
    }//end action
    
    public function actionGetdepartment(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateDepartmentlookup($params);
    }//end action
    
    public function actionCheckuomtrans(){
        $itemid = $_GET['itemid'];
        $uom = $_GET['uom'];
        $data = Yii::$app->backend->UOMhastransaction($uom,$itemid);
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$data];
        //echo json_encode(array('status'=>$data));
    }

    public function actionDeleteitemuom(){
        $itemid = $_GET['params']['itemid'];
        $line = $_GET['params']['line'];
        $uom = $_GET['params']['uom'];
        $data = Yii::$app->backend->removeItemUOM($itemid,$uom,$line); 

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$data['status'],'msg'=>$data['msg']];
        //echo json_encode(array('status'=>$data['status'],'msg'=>$data['msg']));
    }

    public function actionGetbrand(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateBrandlookup($params);
    }//end fn

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

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']];
        //echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
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

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']];
        //echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }

    public function actionSetimgblank(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
            $qry = "update item_gallery set img".$params['i']." = '' where itemid = '".$params['q']."'";
            $status =  Yii::$app->sbccommon->execqry($qry);

            if($status){
                $pic = Yii::$app->homeUrl.'fimages/inventee/png/placeholder.png';
            }else{
                $pic = '';
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ['status'=>$status,'img'=>$pic];
            //echo json_encode(['status'=>$status,'img'=>$pic]);
        } catch (ErrorException $e) {
            echo $e;
        }//end try
    }//end if

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
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['postedpobal'=>$return['postedpobal'],
        'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
        'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal']];

        /* echo json_encode(array('postedpobal'=>$return['postedpobal'],
        'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
        'unpostedsobal'=>$return['unpostedsobal'],'bal'=>$return['bal'])); */
      }                                     
   }

   public function actionTagitemtocategory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
        $return = Yii::$app->backend->setFrontendItemCategory($params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$return['status'],'msg'=>$return['msg'],'tagging'=>$return['tagging']];
        //echo json_encode(array('status'=>$return['status'],'msg'=>$return['msg'],'tagging'=>$return['tagging']));
   }

   public function actionComputediscountedpercent(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $discounted = Yii::$app->backend->computeFrontendDiscount($params['sprice'],$params['ogprice']);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['discounted'=>$discounted];
        //echo json_encode(array('discounted'=>$discounted));
    }

   public function actionGetsubcategories(){
        Yii::$app->backend->AjaxVerification($this);
        $subcat = Yii::$app->backend->getItemSubcategories();

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['subcat'=>$subcat];
        //echo json_encode(array('subcat'=>$subcat));
   }

   public function actionGetcommissiongrp(){
        Yii::$app->backend->AjaxVerification($this);
        $commgrp = Yii::$app->backend->getItemCommissionGrp();

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['commgrp'=>$commgrp];
        //echo json_encode(array('commgrp'=>$commgrp));
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

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status];
        //echo json_encode(['status'=>$status]);
   }

 

    public function actionTagrelateditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $checkqry = "select itemid,tagitemid from frontend_itemrelated where itemid = ".$params['i']." and tagitemid = ".$params['q']."";
        $checkitems = Yii::$app->sbccommon->opentable($checkqry);
        if(!empty($checkitems)) {
            $status = false;
            $msg = "Item is already tagged as related to this item. Please select check you list.";
        } else {
            $qry = "insert into frontend_itemrelated (itemid,tagitemid) values(".$params['i'].",".$params['q'].")";
            $status =  Yii::$app->sbccommon->execqry($qry);
            $msg = '';
        }

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status,'msg'=>$msg];
        //echo json_encode(['status'=>$status,'msg'=>$msg]);
    }

    public function actionGetrelateditem(){
        Yii::$app->backend->AjaxVerification($this);
        $itemid = $_GET['i'];
        $qry = "select frontend_itemrelated.line,frontend_itemrelated.tagitemid,item.barcode,
                item.itemname from frontend_itemrelated
                left join item on item.itemid = frontend_itemrelated.tagitemid";
        $relateditems = Yii::$app->sbccommon->opentable($qry);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['relateditems'=>$relateditems];
        //echo json_encode(['relateditems'=>$relateditems]);
    }
    
    public function actionRemoveitemrelation(){
        Yii::$app->backend->AjaxVerification($this);
        $itemid = $_GET['i'];
        $tagitemid = $_GET['q'];
        $line = $_GET['line'];
        $qry = "delete from frontend_itemrelated where itemid = ".$itemid." and tagitemid = ".$tagitemid." and line = ".$line."";
        $status =  Yii::$app->sbccommon->execqry($qry);
        if($status) {
            $msg = "";
        } else {
            $msg = "Error removing this related item. Please try again!";
        } 

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status,'msg'=>$msg];
        //echo json_encode(['status'=>$status,'msg'=>$msg]);
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

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status,'msg'=>$msg,'defaultpic'=>$defaultpic];
        //echo json_encode(['status'=>$status,'msg'=>$msg,'defaultpic'=>$defaultpic]);
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
                    $itemidd = Yii::$app->backend->requestItemid($params['n']);
                    Log::writelog("stockcard", $itemidd, "Item Details Updated - Changed Barcode", $params['n'],Yii::$app->session['loggeduser']['username']);
                    //UPDATES FOR DLOCK TABLE (MIDDLEWARE DOWNLOADING)
                    $qry = "delete from itemdlock where itemid = " . $itemidd;
                    Yii::$app->sbccommon->execqry($qry);
                    $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
                    $qry2 = "insert into itemdlock (itemid,dlock) values(".$itemidd.",'".$timeupdate."')";
                    Yii::$app->sbccommon->execqry($qry2);
                } else {
                    $msg = 'Update Barcode failed. Something went wrong. Please try again.';
                }
            } else {
                $status = false;
                $msg = 'Barcode is already taken. Please try another one.';
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status,'msg'=>$msg,'newbarcode'=>$params['n']];
        //echo json_encode(['status'=>$status,'msg'=>$msg,'newbarcode'=>$params['n']]);
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


    public function actionComputepo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputepo($params);
    }

    public function actionComputespc(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputespc($params);
    }

      public function actionComputeso(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputeso($params);
    }

    public function actionGetpart(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automatePartlookup($params);
    }

    public function actionGetmodel(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateModellookup($params);
    }//end action

    public function actionGetclass(){
        Yii::$app->backend->AjaxVerification($this);
         $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClasslookup($params);
    }

    public function actionGetbody(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateBodylookup($params);
    }//end action

     public function actionGetsize(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSizelookup($params);
    }//end action

    public function actionGetcategory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateCategorylookup($params);
    }//end action

     public function actionGetgroup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateGrouplookup($params);
    }//end action

    public function actionContrasearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);
    }//END CONTRA

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
            if(Yii::$app->sbccommon->execqry("insert into component(itemid, barcode, itemname, isqty, qty, uom,uomfactor) values('{$params['itemid']}', '{$params['barcode']}', '{$params['itemname']}', '{$params['qty']}', '{$params['qty']}', '{$params['uom']}', '{$params['uomfactor']}')")) {
                $data = Yii::$app->sbccommon->opentable("select line, itemid from component where itemid = '{$params['itemid']}' order by line desc limit 1");
                $msg = "Component Saved";
                $status = true;
            } else {
                $msg = "Error Saving Component";
                $status = false;
            }
        } else { // update record
            if(Yii::$app->sbccommon->execqry("update component set qty = '{$params['qty']}', isqty = '{$params['qty']}',uom='{$params['uom']}',uomfactor='{$params['uomfactor']}' where line = '{$params['line']}'")) {
                $msg = "Component Updated";
                $status = true;
            } else {
                $msg = "Error Updating Component";
                $status = false;
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['data'=>$data,'msg'=>$msg,'status'=>$status];
        //return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
    }//end f

    public function actionDeletecomponentitem() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $data = [];
            if(Yii::$app->sbccommon->execqry("delete from component where itemid={$params['itemid']} and line={$params['line']}")) {
                $msg = "Component Deleted";
                $status = true;
            } else {
                $msg = "Error Deleting Component";
                $status = false;
            }

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['data'=>$data,'msg'=>$msg,'status'=>$status];
        //return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
    }//end f
    //ALVIN END

    public function actionGetprincipal(){
      try{
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automatePrincipallookup($params);
      }catch(ErrorException $e){
        echo $e;
      }
    }//end fn

    public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientlookup($params);
    }//end fn

    public function actionGetfgprodtype() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['x'] != ""){
            $where = "where name like '%".$params['x']."%'";
        }else{
            $where = "";
        }//end if

        $qry = "select id,code,name from prodtype_masterfile ".$where;

        $params = [
            'sql' => $qry,
            'tableid' => 'fgprodtypetbl',
            'key' => 'id', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'label' => 'Code',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'name',
                    'label' => 'Name',
                    'class' => 'aimslabel col-description'
                ]
            ],
            'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickfgprodtype btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'prodtype','value'=>'name'],['name' => 'prodtypeid','value' => 'id']]
                            ]
                        ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionGetfgplasticcolor() {
        try {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['x'] != ""){
            $where = "where name like '%".$params['x']."%'";
        }else{
            $where = "";
        }//end if

        $qry = "select id,code,name from plastic_masterfile " .$where;

        $params = [
            'sql' => $qry,
            'tableid' => 'fgplasticcolortbl',
            'key' => 'id', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'label' => 'Code',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'name',
                    'label' => 'Name',
                    'class' => 'aimslabel col-description'
                ]
            ],

            'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickfgplasticcolor btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'plasticcolor','value'=>'name'],['name' => 'plasticcolorid','value' => 'id']]
                            ]
                        ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);

            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end fn

    public function actionGetfgsealing() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['x'] != ""){
            $where = "where name like '%".$params['x']."%'";
        }else{
            $where = "";
        }//end if

        $qry = "select id,code,name from sealing_masterfile " .$where;

        $params = [
            'sql' => $qry,
            'tableid' => 'fgsealingtbl',
            'key' => 'id', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'label' => 'Code',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'name',
                    'label' => 'Name',
                    'class' => 'aimslabel col-description'
                ]
            ],

            'buttons' => [
                            [
                                'name' => '',
                                'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-download"></i>',
                                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                                'class' => 'pickfgsealing btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'sealing','value'=>'name'],['name' => 'sealingid','value' => 'id']]
                            ]
                        ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionGetmovementdetails() {
        try {
            
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET['params'];

        switch($params['whcode']){
            case 'PC0000000000001':
                $doc_filters = "('SJ','TS')";
            break;

            case 'PC0000000000002':
                $doc_filters = "('SJ')";
            break;

            default:
                $doc_filters = "('')";
            break;
        }//end switch

        //FOR QTY OUT
        $qry_totalout = "select round(qty,2) as qty_out from (
            select ifnull(sum(stock.iss/uom.factor),0) as qty from lahead as head
            left join lastock as stock on stock.trno = head.trno
            left join item on item.barcode = stock.barcode
            left join client as wh on wh.client = stock.wh
            left join uom on uom.itemid = item.itemid and uom.uom = '".$params['uom']."'
            where head.doc IN ".$doc_filters." and item.itemid = '".$params['itemid']."'
            and head.dateid >= '".$params['viewdate']."' and wh.client = '".$params['whcode']."'
            group by item.barcode
            UNION ALL
            select ifnull(sum(stock.iss/uom.factor),0) as qty from glhead as head
            left join glstock as stock on stock.trno = head.trno
            left join item on item.itemid = stock.itemid
            left join client as wh on wh.clientid = stock.whid
            left join uom on uom.itemid = item.itemid and uom.uom = '".$params['uom']."'
            where head.doc IN ".$doc_filters." and item.itemid = '".$params['itemid']."'
            and head.dateid >= '".$params['viewdate']."' and wh.client = '".$params['whcode']."'
            group by item.barcode
        ) as tbl";

        $data_totalout = Yii::$app->sbccommon->opentable($qry_totalout);


        //FOR QTY IN
        $qry_totalin = "select round(qty,2) as qty_in from (
            select ifnull(sum(stock.qty/uom.factor),0) as qty from lahead as head
            left join lastock as stock on stock.trno = head.trno
            left join item on item.barcode = stock.barcode
            left join client as wh on wh.client = stock.wh
            left join uom on uom.itemid = item.itemid and uom.uom = '".$params['uom']."'
            where head.doc IN ('RR','TS') and item.itemid = '".$params['itemid']."'
            and head.dateid >= '".$params['viewdate']."' and wh.client = '".$params['whcode']."'
            group by item.barcode
            UNION ALL
            select ifnull(sum(stock.qty/uom.factor),0) as qty from glhead as head
            left join glstock as stock on stock.trno = head.trno
            left join item on item.itemid = stock.itemid
            left join client as wh on wh.clientid = stock.whid
            left join uom on uom.itemid = item.itemid and uom.uom = '".$params['uom']."'
            where head.doc IN ('RR','TS') and item.itemid = '".$params['itemid']."'
            and head.dateid >= '".$params['viewdate']."' and wh.client = '".$params['whcode']."'
            group by item.barcode
        ) as tbl";

        $data_totalin = Yii::$app->sbccommon->opentable($qry_totalin);

        //FOR ONHAND BALANCE
        $qry_QoH = "
            select
            item.itemid,item.barcode,item.itemname,
            round((sum(rrstatus.bal)/uom.factor),2) as balance,
            round(uom.factor) as factor from rrstatus
            left join item on item.itemid = rrstatus.itemid
            left join stockgrp_masterfile as stockgrp on stockgrp.stockgrp_id = item.groupid
            left join uv_principal on item.uv_principal = uv_principal.line
            left join uom on uom.uom='".$params['uom']."' and uom.itemid = item.itemid
            left join client as wh on wh.clientid = rrstatus.whid
            where rrstatus.bal <> 0 and rrstatus.itemid = ".$params['itemid']."
            and wh.client = '".$params['whcode']."' 
            group by item.barcode,rrstatus.whid";

        $data_QoH = Yii::$app->sbccommon->opentable($qry_QoH);

        if(!empty($data_QoH)){
            $return['onhand'] = number_format($data_QoH[0]['balance'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        }else{
            $return['onhand'] = 0;
        }//end if

        if(!empty($data_totalin)){
            $return['total_in'] = number_format($data_totalin[0]['qty_in'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        }else{
            $return['total_in'] = 0;
        }//end if

        if(!empty($data_totalout)){
            $return['total_out'] = number_format($data_totalout[0]['qty_out'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        }else{
            $return['total_out'] = 0;
        }//end if
        
        $return['movement'] = 0;
        $return['mon_togo'] = 0;

        if(!empty($return['total_out'])){
            // creates DateTime objects
            $datetime1 = date_create($params['viewdate']);
            $datetime2 = date_create(Yii::$app->systemsettings->getCurrentTimeStamp());
            
            // calculates the difference between DateTime objects
            $interval = date_diff($datetime1, $datetime2);
            
            // printing result in days format
            $day_diff =  $interval->format('%R%a');

            if($day_diff != 0){
                if($day_diff != 0){
                    $month_value = abs($day_diff) / 30;
                }else{
                    $month_value = 0;
                }//end if
                
                if($month_value != 0 && $return['total_out'] != 0){
                    $return['movement'] = $return['total_out'] / $month_value;
                    $return['movement'] = round($return['movement'],2);
                }//end if

                if($return['onhand'] != 0 && $return['movement'] != 0){
                    $return['mon_togo'] = $return['onhand'] / $return['movement'];
                }//end if
            }//end if
        }//end if

        $return['movement'] = number_format($return['movement'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
        $return['mon_togo'] = number_format($return['mon_togo'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));

        Yii::$app->response->format = Response::FORMAT_JSON;    
        return $return;

        } catch (\Exception $e) {
            echo $e;
        }
    }//end fn


    private function fixitem($barcode){
            $itemid = Yii::$app->sbccommon->datareader("select itemid from item where barcode='".$barcode."'");
            Yii::$app->sbccommon->execqry("delete from costing where itemid=".$itemid);
            Yii::$app->sbccommon->execqry("update rrstatus set bal=qty where itemid=".$itemid);
            //posted and unposted
            //$qry = "
            //    select trno,line,expiry,loc,wh,iss,docno,doc,dateid from
            //    (select stock.trno,stock.line,stock.expiry,stock.loc,wh.client as 
            //    wh,stock.iss,head.docno,head.doc,head.dateid from glhead as head left join glstock as stock on 
            //    stock.trno=head.trno left join item on item.itemid=stock.itemid left join client as wh on 
            //    wh.clientid=stock.whid
            //    where item.barcode='IT0000000000256' and stock.iss<>0
            //    union all
            //    select stock.trno,stock.line,stock.expiry,stock.loc,stock.wh,stock.iss,head.docno,head.doc,
            //    head.dateid from lahead as head left join lastock as stock on stock.trno=head.trno
            //    where stock.barcode='IT0000000000256' and stock.iss<>0) as t order by t.trno;
            //";

            //posted only
            $qry = "
            select item.itemid,head.docno,stock.trno,stock.line,stock.expiry,stock.loc,wh.client as 
            wh,stock.iss,head.docno,head.doc,head.dateid from glhead as head 
            left join glstock as stock on stock.trno=head.trno 
            left join item on item.itemid=stock.itemid 
            left join client as wh on wh.clientid=stock.whid 
            where item.barcode='".$barcode."' and stock.iss<>0 order by head.dateid";

            $error_trans1 = $this->recalctrans($barcode,$qry);

            //unposted only 
            $qry = "select item.itemid,head.docno,stock.trno,stock.line,stock.expiry,stock.loc,
            stock.wh,stock.iss,head.docno,head.doc,head.dateid from lahead as head 
            left join lastock as stock on stock.trno=head.trno 
            left join item on item.barcode=stock.barcode 
            where stock.barcode='".$barcode."' and stock.iss<>0 order by head.dateid";

            $error_trans2 = $this->recalctrans($barcode,$qry);

            $error_trans = array_merge($error_trans1, $error_trans2);
            
            if(count($error_trans) == 0){
                $msg = "Recalculate successfully!";
                $status = true;
            }else{
                $msg = 'Recalculate not successful. Some of the ff. transactions cannot be served properly: <br><br>';
                foreach ($error_trans as $key => $value) {
                    $msg .= 'Docno: ' . $value['docno'] . ' - Line: '. $value['line'] . '<br>';
                }//end for each
                $status = false;
            }//end if

            Log::writelog("stockcard", $itemid,'RECALCULATE',$msg,Yii::$app->session['loggeduser']['username']); 

            return ['msg'=> $msg , 'status'=> $status];
    }//end fn

    public function actionItemrecalc(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        
        //$this->fixdisbalanceall();
        Yii::$app->response->format = Response::FORMAT_JSON;    
        return $this->fixitem($params['barcode']);        
    }//end fn


    private function recalctrans($barcode,$qry){
        $data = Yii::$app->sbccommon->opentable($qry);
        $error_trans = [];
        
        if ($data!=null){
            try {
                for ($i=0;$i<count($data);$i++){
                    $cost=$this->computecosting($barcode, $data[$i]['wh'],$data[$i]['loc'],$data[$i]['expiry'], $data[$i]['trno'], $data[$i]['line'], $data[$i]['iss'], $data[$i]['doc']);
                    if($cost == -1){
                        $error_trans[] = ['trno' => $data[$i]['trno'] , 'line' => $data[$i]['line'], 'docno' => $data[$i]['docno']];
                    }//end if
                }//end for

                return $error_trans;
            }catch (ErrorException $e) {                 
                echo $e;
            }//end for each
        }else{
            return $error_trans;
        }//end if
    }//end fn


    private function computecosting($barcode, $wh,$loc,$expiry, $trno, $line, $qty, $doc){
        $itemid = Yii::$app->sbccommon->datareader("select itemid from item where barcode='".$barcode."'");
        $whid = Yii::$app->sbccommon->datareader("select clientid from client where client='".$wh."'");
    

        if($itemid!=0 and $whid!=0){
            $ret = $this->computecostingactual($itemid, $whid,$loc,$expiry, $trno, $line, abs($qty), $doc);

            if ($ret==-1){
                $ret = $this->computecostingactual($itemid, $whid,$loc,$expiry, $trno, $line, abs($qty), $doc);
            }

            return $ret;
        }           
    }//end computecosting



    private function computecostingactual($itemid, $whid,$loc,$expiry,$trno, $line, $qty, $doc){
        $origqty = $qty;
        $aveqty = 0;
        $costvalue=0;
        $sumbal = 0 ;
        $message = '';
        $bal=0;
        $error_trans = [];

        Yii::$app->sbccommon->execqry("delete from costing where trno=".$trno." and line=".$line);

        $strRRStatus ="select rrstatus.trno, rrstatus.line, rrstatus.cost, ifnull(rrstatus.bal,0) as bal,
        rrstatus.itemID, rrstatus.whID,item.minimum,item.maximum,client.client as whcode,
        client.clientname as whname from rrstatus 
        left join client on client.clientid=rrstatus.whid 
        left join item on item.itemid=rrstatus.itemid 
        where rrstatus.itemid=".$itemid." and rrstatus.whid=".$whid." and rrstatus.loc='".$loc."'";

        if($expiry=='1900-01-01' || $expiry ==''){
            $strRRStatus =  $strRRStatus." and (rrstatus.expiry='1900-01-01' or rrstatus.expiry='0000-0-0' or rrstatus.expiry='') ";  
        }else{
            $strRRStatus =  $strRRStatus." and rrstatus.expiry='".$expiry."'"; 
        }  

        $strRRStatus =  $strRRStatus." and rrstatus.bal<>0 order by rrstatus.encoded";  
        
        $data = Yii::$app->sbccommon->opentable($strRRStatus);
        
        //Yii::$app->backend->create_Elog('RRstatus - '.$strRRStatus);        
        if($data!=null){
            for ($i=0;$i<count($data);$i++){
                $bal =$data[$i]['bal'];

                    //Yii::$app->backend->create_Elog("1 ".$origqty.">".$bal);
                    if(round($origqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')) > round($bal,Yii::$app->systemsettings->setDecimaldisplay('quantity')) && $origqty<>0){

                        //Yii::$app->backend->create_Elog("2 insert into ".$trno." - line - ".$line);
                        if (Yii::$app->sbccommon->execqry("INSERT INTO costing (trno, line, refx, linex, served, itemID, whID,bal, doc, IsPosted) 
                            SELECT ".$trno.",".$line.", ".$data[$i]['trno'].",".$data[$i]['line'].",".$data[$i]['bal'].",".$itemid.",".$whid.", 0,'".$doc."',
                            (select (case when IfNull(postdate, '') = '' then 0 else 1 end) FROM cntnum WHERE trno = ".$trno.")")==1){
                            $costvalue = $costvalue + $data[$i]['cost'] * $data[$i]['bal'];
                            //$aveqty = $qty; //original by lysa
                            $aveqty = $aveqty + $data[$i]['bal'];
                            // echo 'A  '.$origqty;
                            $origqty = $origqty - $data[$i]['bal'];

                            //echo 'O-QTY: ' . $origqty . ' - QTY SAVED: ' . $data[$i]['bal'].'<br>';
                        }else{
                            $message=$message.'Error in ComputeStock function...';
                            Yii::$app->session['warning']=Yii::$app->session['warning'].$message;
                            //echo 'ERROR A' . '<br>';
                            return -1;
                            //exit();
                        }
                    }elseif(round($origqty,Yii::$app->systemsettings->setDecimaldisplay('quantity')) <= round($bal,Yii::$app->systemsettings->setDecimaldisplay('quantity')) && $origqty<>0){

                        if(Yii::$app->sbccommon->execqry("INSERT INTO costing (trno, line, refx, linex, served, itemID, whID,bal, doc, IsPosted) 
                            SELECT ".$trno.",".$line.",".$data[$i]['trno'].",".$data[$i]['line'].",".$origqty.",".$itemid.",".$whid.", 0,'".$doc."',
                            (select (case when IfNull(postdate, '') = '' then 0 else 1 end) FROM cntnum WHERE trno = ".$trno.")")==1){
                                $costvalue = $costvalue + $data[$i]['cost'] * $origqty;
                                $aveqty = $aveqty + $origqty;
                                $origqty = 0;
                            
                            //echo 'O-QTY: ' . $origqty . ' - QTY SAVED: ' . $origqty.'<br>';  
                        }else{
                            $message=$message.'Error in ComputeStock function...';
                            Yii::$app->session['warning']=Yii::$app->session['warning'].'<br/>'.$message;
                            //echo 'ERROR B' . '<br>';
                            return -1;
                            //exit();
                        }
                    }//$origqty>$bal && $origqty<>0
                //echo $origqty . 'running subtration';
                if($origqty==0){ goto here;}     
            }// for ($i=0;$i<count($data);$i++){
                
            here:
            //echo $origqty . 'LAST origqty';
            if (round($origqty,Yii::$app->systemsettings->setDecimaldisplay('quantity'))>0){
                //Yii::$app->backend->create_Elog("3 delete from costing where trno=$trno and line=$line");
                $error_trans[] = ['trno' => $trno , 'line' => $line, 'requested_qty' => $origqty, 'current_bal' => $bal];
                Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
                //echo 'TRNO: '.$trno.' LINE: '.$line.' QTY: ' .$origqty. ' ' .'CURRENT BAL: '.$bal. ' = ERROR C' . '<br>';
                return -1;
                //exit();
            }

            $strsql="DELETE FROM costing WHERE refx = 0 AND linex = 0 AND served = 0 AND bal = 0";
            Yii::$app->sbccommon->execqry($strsql);
            if ($costvalue<>0 and round($aveqty,Yii::$app->systemsettings->setDecimaldisplay('quantity'))<>0){
                return $costvalue/$aveqty;
            }else{
                return 0;
            }
        }else{
            //Yii::$app->backend->create_Elog("4 no inv - "."delete from costing where trno=$trno and line=$line");

            Yii::$app->sbccommon->execqry("delete from costing where trno=$trno and line=$line");
            return -1;
        }
    }

    public function actionGetdivision(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateDivisionlookup($this,$params);
    }//end f
}//END CONTROLLER