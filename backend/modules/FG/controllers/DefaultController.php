<?php

namespace backend\modules\FG\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

use app\models\Item;
use yii\base\ErrorException;

class DefaultController extends Controller{

    public $access = array(
        'view' => 3201,'edit' => 3202,'new' => 3203,'save' => 3204,
        'change' => 3205,'delete' => 3206,'print' => 3207);

    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
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
                return $this->render('index',array('moduleid'=>$moduleid,'data'=>$data));
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

    public function actionItemlookupequipment(){
        try {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        $sql = "select sizeid,barcode,item.itemid,category,grp.stockgrp_name as groupid,
        itemname,item.uom,uom1.factor,round(item.amt,2) as amt,brand,ifnull(cls.cl_name,'') as class,body,
        ifnull(part.part_name,'') as part,ifnull(model.model_name,'') as model,disc,
        round(item.amt - (item.amt * (REPLACE(disc,'%','')/100)),2) as netprice,uv_priority,ifnull(uv_principal.name,'') as uv_principal from item
        left join item_class as cls on cls.cl_id=item.class 
        left join uom as uom1 on item.itemid = uom1.itemid and uom1.uom = item.uom
        left join stockgrp_masterfile as grp on grp.stockgrp_id = item.groupid
        left join model_masterfile as model on model.model_id = item.model
        left join part_masterfile as part on part.part_id = item.part
        left join uv_principal on uv_principal.line = item.uv_principal";

        $keyword = explode(",", $params['x']);
        $criteria="";

          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.isinactive <> 1 and (
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or
                                      item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.isinactive <> 1 and " . "(
                                      item.itemname LIKE '%" . $key. "%' or
                                      item.barcode LIKE '%" . $key. "%' or
                                      item.brand LIKE '%" . $key. "%' or
                                      model.model_name LIKE '%" . $key. "%' or
                                      part.part_name LIKE '%" . $key. "%' or
                                      item.category LIKE '%" . $key. "%' or
                                      grp.stockgrp_name LIKE '%" . $key. "%' or    
                                      cls.cl_name LIKE '%" . $key. "%' or
                                      item.body LIKE '%" . $key. "%' or                                
                                      item.sizeid LIKE '%" . $key. "%')";
              }
          }//end if 

         $qry = $sql . " " . $criteria . " order by item.itemname asc limit 1000";

        $buttons = [
            [
                'name' => '',
                'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'stockaddthisitem btn btn-social-icon btn-bitbucket',
                'attributes'=>[['name'=>'ukey',
                               'value'=>'itemid'],
                               ['name'=>'barcode',
                               'value'=>'barcode'],
                               ['name'=>'itemname',
                               'value'=>'itemname'],
                               ['name'=>'uom',
                               'value'=>'uom'],
                               ['name'=>'amt',
                               'value'=>'amt'],
                              ],
            ],[
                'name' => '',
                'caption' => '<i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i>',
                'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                'class' => 'showbalance btn btn-social-icon btn-github'
            ]
        ];
            
        $fields = [[
            'name' => 'barcode',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'itemname',
            'class' => 'aimslabel col-description'
        ],[
            'name' => 'uom',
            'label' => 'UOM',
            'class' => 'aimslabel col-min'
        ],[
            'name' => 'amt',
            'label' => 'Retail',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'disc',
            'label' => 'Discount',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'netprice',
            'label' => 'Net Price',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'uv_priority',
            'label' => 'Priority',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'uv_principal',
            'label' => 'Principal',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'sizeid',
            'label' => 'Bin',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'model',
            'label' => 'Generic',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'body',
            'label' => 'Form',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'part',
            'label' => 'Category',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'class',
            'label' => 'Classification',
            'class' => 'aimslabel col-codes'
        ],[
            'name' => 'itemid',
            'hidden' => true,
            'class' => 'txtstockitemid txthidden',
            'default'=>'0',
        ]];

        $params = [
            'sql' => $qry,
            'tableid' => 'item-lookup',
            'key' => 'itemid',
            'txtclass' => 'bodytextbox',
            'checkbox' => false, //OPT
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => $fields,
            'buttons' => $buttons
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);

            
        } catch (ErrorException $e) {
            echo $e;
        }//end catch
    }//end fn

    /*public function actionGetclientinfo(){
        $item = new Item;
        $itemid = $_GET['clientid'];
        $data = $item->openitem($itemid);
        echo json_encode(array('clientdata' => array('head'=>$data)));
    }*/

    public function actionGetclientinfo(){
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
    }//end if

    public function actionLoadlastdoc(){
        $data = Yii::$app->weblisting->index($this,$this->access['view']);
        echo json_encode(array('moduledata' => $data));
    }

    public function actionSavehead(){
        $xxx = $_POST;
        $xxx = Yii::$app->backend->sanitize($xxx,'ARRAY');
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

    public function actionUomlookup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['itemid'=>$_POST['x']];
        return Yii::$app->automator->automateUOMlookupGV($params);
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

    public function actionInsertuom(){
        $params = $_GET;
        $data = Yii::$app->backend->insertToUOMtbl($params);
        echo json_encode(array('status'=>$data['status'],'msg'=>$data['msg'],'data'=>$data['data'],'type'=>$data['type']));
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

    public function actionSetimgblank(){
        try {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $qry = "update item_gallery set img".$params['i']." = '' where itemid = '".$params['q']."'";
        $status =  Yii::$app->sbccommon->execqry($qry);

        if($status){
            $pic = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';
        }else{
            $pic = '';
        }//end if

        echo json_encode(['status'=>$status,'img'=>$pic]);

            
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
        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }

    public function actionGetrelateditem(){
        Yii::$app->backend->AjaxVerification($this);
        $itemid = $_GET['i'];
        $qry = "select frontend_itemrelated.line,frontend_itemrelated.tagitemid,item.barcode,
                item.itemname from frontend_itemrelated
                left join item on item.itemid = frontend_itemrelated.tagitemid";
        $relateditems = Yii::$app->sbccommon->opentable($qry);
        echo json_encode(['relateditems'=>$relateditems]);
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
        echo json_encode(['status'=>$status,'msg'=>$msg]);
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


    public function actionComputepo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputepo($params);
    }

      public function actionComputeso(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateComputeso($params);
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
        return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
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
        return json_encode(array('data'=>$data,'msg'=>$msg,'status'=>$status));
    }//end f
    //ALVIN END

    public function actionGetprincipal(){
      try{
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automatePrincipallookup($this);
      }catch(ErrorException $e){
        echo $e;
      }
    }

    public function actionClientlookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateClientlookup($params);
    }

    public function actionLoaditemdetails() {
    	Yii::$app->backend->AjaxVerification($this);
    	$itemid = $_POST['itemid'];
    	$item = Yii::$app->sbccommon->opentable("select item.itemid, item.barcode, item.itemname, item.fg_revision, item.fg_templateno, item.fg_updated, item.fg_effective, item.fg_customer, item.fg_prodtype, item.fg_combi, item.fg_transform, item.fg_addspecs, item.fg_punchholesize, item.fg_sealing, item.fg_plasticcolor, item.fg_bfilmdet, item.fg_treatment, item.fg_rate, item.fg_quantity, item.fg_jowidth, item.fg_jowidthuom, item.fg_jolength, item.fg_jolengthuom, item.fg_thickness, item.fg_thicknessuom, item.fg_actualwidth, item.fg_actualwidthuom, item.fg_actuallength, item.fg_actuallengthuom, item.fg_colornum, item.fg_repeatlength, item.fg_repeatlengthuom, item.fg_outnum, item.fg_outnumuom, item.fg_bfilmwidth, item.fg_bfilmwidthuom, item.fg_thickness2, item.fg_thickness2uom, item.fg_gramppiece1, item.fg_gramppiece2, item.fg_isfinishedgood, concat(item.fg_customer,'~',c.clientname) as fgcustomer from item left join client as c on c.client = item.fg_customer where item.itemid = $itemid");
    	return json_encode(array('item'=>$item));
    }

    public function actionBuildfgstock() {
        Yii::$app->backend->AjaxVerification($this);
        $type = $_POST['type'];
        $itemid = $_POST['itemid'];
        
        if($itemid == ""){
            $itemid = 0;
        }//ed

        switch($type){
            case 'colors':
                $qry = "select 'colors' as tablename, i.line, i.color as id, c.name as color 
                        from fgi_colors as i 
                        left join fg_colors as c on c.id = i.color 
                        where i.itemid = $itemid order by i.line";
                $params = [
                    'sql' => $qry,
                    'tableid' => 'fgstockgrid1',
                    'key' => 'line',
                    'txtclass' => 'fgtextbox1',
                    'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                    'column' => [
                        [
                            'name' => 'color',
                            'editable' => true,
                            'type' => 'lookup',
                            'lookupbutton' => ['autocall'=>'',
                                              'colw'=>'col-description',
                                              'lookupclass'=>'btncolorlookup gvbtns',
                                              'lookuptxtclass'=>'minitxtcombo'],
                        ],[
                            'name' => 'id',
                            'hidden' => true,
                            'default' => '0'
                        ],[
                            'name' => 'line',
                            'hidden' => true,
                            'default' => '0'
                        ],[
                            'name' => 'tablename',
                            'hidden' => true,
                            'default' => 'colors'
                        ]
                    ],
                    'buttons' => [
                        [
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btnsavefggrid btn btn-social-icon btn-bitbucket'
                        ],[
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btndeletefggrid btn btn-social-icon btn-github'
                        ]
                    ]
                ];
            break;
            case 'material': 
                $qry = "select 'material' as tablename, fgi_material.line,
                        material2.name as material,
                        fgi_material.width,fgi_material.thickness,material2.id
                        from fgi_material 
                        left join fg_material as material2 on material2.id = fgi_material.material
                        where fgi_material.itemid = $itemid order by fgi_material.line";

                $params = [
                    'sql' => $qry,
                    'tableid' => 'fgstockgrid2',
                    'key' => 'line',
                    'txtclass' => 'fgtextbox2',
                    'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                    'column' => [
                        [
                            'name' => 'material',
                            'editable' => true,
                            'type' => 'lookup',
                            'lookupbutton' => ['autocall'=>'waw',
                                              'colw'=>'col-description',
                                              'lookupclass'=>'btnmateriallookup gvbtns',
                                              'lookuptxtclass'=>'minitxtcombo']
                        ],[
                            'name' => 'width',
                            'editable' => true,
                            'type' => 'text',
                            'class' => 'col-codes stocktxt'
                        ],[
                            'name' => 'thickness',
                            'editable' => true,
                            'type' => 'text',
                            'class' => 'col-codes stocktxt'
                        ],[
                            'name' => 'line',
                            'hidden' => true,
                            'default' => '0'
                        ],[
                            'name' => 'id',
                            'hidden' => true,
                            'default' => '0'
                        ],[
                            'name' => 'tablename',
                            'hidden' => true,
                            'default' => 'material'
                        ]
                    ],
                    'buttons' => [
                        [
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btnsavefggrid btn btn-social-icon btn-bitbucket'
                        ],[
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btndeletefggrid btn btn-social-icon btn-github'
                        ]
                    ]
                ];
            break;
            case 'cylinder':
                $qry = "select 'cylinder' as tablename, i.line, c.barcode as code, 
                        c.itemname as cylinder,i.cylinder as id from fgi_cylinder as i 
                        left join item as c on c.itemid = i.code
                        where i.itemid = $itemid order by i.line";

                $params = [
                    'sql' => $qry,
                    'tableid' => 'fgstockgrid3',
                    'key' => 'line',
                    'txtclass' => 'fgtextbox3',
                    'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                    'column' => [
                        [
                            'name' => 'code',
                            'label' => 'Barcode',
                            'editable' => true,
                            'readonly' => true,
                            'type' => 'text',
                            'class' => 'col-codes stocktxt'
                        ],[
                            'name' => 'cylinder',
                            'label' => 'Equipment/Tool Name',
                            'editable' => true,
                            'readonly' => true,
                            'type' => 'text',
                            'class' => 'col-description stocktxt'
                        ],[
                            'name' => 'id',
                            'hidden' => true,
                            'default' => '0'
                        ],[
                            'name' => 'line',
                            'hidden' => true,
                            'default' => '0'
                        ],[
                            'name' => 'tablename',
                            'hidden' => true,
                            'default' => 'cylinder'
                        ]
                    ],
                    'buttons' => [
                        [
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btnsavefggrid btn btn-social-icon btn-bitbucket'
                        ],[
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btndeletefggrid btn btn-social-icon btn-github'
                        ]
                    ]
                ];
            break;
            case 'process': 
                $qry = "select 'process' as tablename, fgi_process.line,fgi_process.code,
                    fgi_process.process,fgi_process.instructions,process2.id
                    from fgi_process
                    left join fg_process as process2 on process2.id = fgi_process.processid
                    where fgi_process.itemid = $itemid order by fgi_process.line";

                $params = [
                    'sql' => $qry,
                    'tableid' => 'fgstockgrid4',
                    'key' => 'line',
                    'txtclass' => 'fgtextbox4',
                    'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                    'column' => [
                        [
                            'name' => 'code',
                            'editable' => true,
                            'type' => 'lookup',
                            'lookupbutton' => ['autocall'=>'',
                                              'colw'=>'col-codes',
                                              'lookupclass'=>'btnprocesslookup gvbtns',
                                              'lookuptxtclass'=>'minitxtcombo'],
                        ],[
                            'name' => 'process',
                            'editable' => true,
                            'type' => 'text',
                            'readonly' => true,
                            'class' => 'col-codes stocktxt'
                        ],[
                            'name' => 'instructions',
                            'editable' => true,
                            'type' => 'text',
                            'class' => 'col-description stocktxt'
                        ],[
                            'name' => 'line',
                            'hidden' => true,
                            'default' => '0'
                        ],[
                            'name' => 'tablename',
                            'hidden' => true,
                            'default' => 'process'
                        ],[
                            'name' => 'id',
                            'hidden' => true,
                            'default' => '0'
                        ]
                    ],
                    'buttons' => [
                        [
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btnsavefggrid btn btn-social-icon btn-bitbucket'
                        ],[
                            'name' => '',
                            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-trash"></i>',
                            'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                            'class' => 'btndeletefggrid btn btn-social-icon btn-github'
                        ]
                    ]
                ];
            break;
        }
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function actionLoadfgcolors() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $qry = "select id, code, name from fg_colors where (name like '%".$params['q']."%' or code like '%".$params['q']."%') order by id";
        $params = [
            'sql' => $qry,
            'tableid' => 'fgcolorsgrid',
            'key' => 'id',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'class' => 'col-codes'
                ],[
                    'name' => 'name',
                    'class' => 'col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnselectfgcolors btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'color','value'=>'name'],['name'=>'colorid','value'=>'id']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }
    public function actionLoadfgmaterial() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $qry = "select id, name from fg_material where (name like '%".$params['q']."%' or code like '%".$params['q']."%') order by id";
        $params = [
            'sql' => $qry,
            'tableid' => 'fgmaterialgrid',
            'key' => 'id',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'name',
                    'class' => 'col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnselectfgmaterial btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'material','value'=>'name'],['name'=>'materialid','value'=>'id']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }
    public function actionLoadfgcylinder() {
        Yii::$app->backend->AjaxVerification($this);
        $qry = "select id, code, name from fg_cylinder order by id";
        $params = [
            'sql' => $qry,
            'tableid' => 'fgcylindergrid',
            'key' => 'id',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'class' => 'col-codes'
                ],[
                    'name' => 'name',
                    'class' => 'col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnselectfgcylinder btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'cylinder','value'=>'name'],['name'=>'cylinderid','value'=>'id'],['name'=>'cylindercode','value'=>'code']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }
    public function actionLoadfgprocess() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $qry = "select id, code, name from fg_process where (name like '%".$params['q']."%' or code like '%".$params['q']."%') order by id";
        $params = [
            'sql' => $qry,
            'tableid' => 'fgprocessgrid',
            'key' => 'id',
            'txtclass' => 'bodytextbox',
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'code',
                    'class' => 'col-codes'
                ],[
                    'name' => 'name',
                    'class' => 'col-description'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-save"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnselectfgprocess btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'process','value'=>'name'],['name'=>'processid','value'=>'id'],['name'=>'processcode','value'=>'code']]
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function actionSavefggrid() {
        try {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
        
        $data = [];
        switch($params['tablename']) {
            case 'colors':
                if($params['line'] == '0') {
                    if(Yii::$app->sbccommon->execqry("insert into fgi_colors(itemid,color) values('{$params['itemid']}', '{$params['id']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.color as id, c.name as color from fgi_colors as i left join fg_colors as c on c.id = i.color order by i.line desc limit 1");
                        $msg = "Record Saved.";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record.";
                        $status = false;
                    }
                } else {
                    if(Yii::$app->sbccommon->execqry("update fgi_colors set color = '{$params['id']}' where line = '{$params['line']}' and itemid = '{$params['itemid']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.color as id, c.name as color from fgi_colors as i left join fg_colors as c on c.id = i.color where i.line = '{$params['line']}' and i.itemid = '{$params['itemid']}'");
                        $msg = "Record Updated.";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record.";
                        $status = false;
                    }
                }
            break;
            case 'material':
                if($params['line'] == '0') {
                    if($params['thickness'] == ''){
                        $params['thickness'] = 0;
                    }//end if

                    if($params['width'] == ''){
                        $params['width'] = 0;
                    }//end if

                    $strqry = "insert into fgi_material(itemid, material, width, thickness) 
                              values(".$params['itemid'].", ".$params['id'].", ".$params['width'].",".$params['thickness'].")";

                    if(Yii::$app->sbccommon->execqry($strqry)){
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.material as id, i.width, i.thickness, m.name as material from fgi_material as i left join fg_material as m on m.id = i.material order by i.line desc limit 1");
                        $msg = "Record Saved.";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record.";
                        $status = false;
                    }
                } else {
                    $strqry = "update fgi_material set material = ".$params['id'].", width = ".$params['width'].", 
                               thickness = ".$params['thickness']." 
                               where line = ".$params['line']." and itemid = ".$params['itemid'];

                    if(Yii::$app->sbccommon->execqry($strqry)){
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.material as id, i.width, i.thickness, m.name as material from fgi_material as i left join fg_material as m on m.id = i.material where i.line = '{$params['line']}' and i.itemid = '{$params['itemid']}'");
                        $msg = "Record Updated.";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record.";
                        $status = false;
                    }
                }
            break;
            case 'cylinder':
                if($params['line'] == '0') {
                    if(Yii::$app->sbccommon->execqry("insert into fgi_cylinder(itemid, code, cylinder) 
                        values('{$params['itemid']}', '{$params['code']}', '{$params['id']}')")) {
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.code, c.name as cylinder, i.cylinder as id from fgi_cylinder as i left join fg_cylinder as c on c.id = i.cylinder order by i.line desc limit 1");
                        $msg = "Record Saved.";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record.";
                        $status = false;
                    }
                } else {
                    if(Yii::$app->sbccommon->execqry("update fgi_cylinder set code = '{$params['code']}', cylinder = '{$params['id']}' where line = '{$params['line']}' and itemid = '{$params['itemid']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.code, c.name as cylinder, i.cylinder as id from fgi_cylinder as i left join fg_cylinder as c on c.id = i.cylinder where i.line = '{$params['line']}' and i.itemid = '{$params['itemid']}'");
                        $msg = "Record Updated.";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record.";
                        $status = false;
                    }
                }
            break;
            case 'process':
                if($params['line'] == '0') {
                    if(Yii::$app->sbccommon->execqry("insert into fgi_process(itemid, code, process, instructions,processid) 
                        values('{$params['itemid']}', '{$params['code']}', '{$params['process']}','{$params['instructions']}',
                        '{$params['id']}')")) {
                        
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.code, i.process as id,process, i.instructions 
                                                                from fgi_process as i 
                                                                order by i.line desc limit 1");
                        $msg = "Record Saved.";
                        $status = true;
                    } else {
                        $msg = "Error Saving Record.";
                        $status = false;
                    }
                } else {
                    if(Yii::$app->sbccommon->execqry("update fgi_process set code = '{$params['code']}', process = '{$params['code']}', instructions = '{$params['instructions']}' where line = '{$params['line']}' and itemid = '{$params['itemid']}'")) {
                        $data = Yii::$app->sbccommon->opentable("select i.line, i.code, i.process as id, p.name as process, i.instructions from fgi_process as i left join fg_process as p on p.id = i.process where i.line = '{$params['line']}' and i.itemid = '{$params['itemid']}'");
                        $msg = "Record Saved.";
                        $status = true;
                    } else {
                        $msg = "Error Updating Record.";
                        $status = false;
                    }
                }
            break;
        }
        return json_encode(array('msg'=>$msg,'status'=>$status,'data'=>$data));
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function actionDeletefggrid() {
        try {
            Yii::$app->backend->AjaxVerification($this);
            $id = $_POST['id'];
            $type = $_POST['type'];
            switch($type) {
                case 'colors': $qry = "delete from fgi_colors where line = $id"; break;
                case 'material': $qry = "delete from fgi_material where line = $id"; break;
                case 'cylinder': $qry = "delete from fgi_cylinder where line = $id"; break;
                case 'process': $qry = "delete from fgi_process where line = $id"; break;
                default: $qry = ""; break;
            }
            if(Yii::$app->sbccommon->execqry($qry)) {
                $msg = "Record Deleted.";
                $status = true;
            } else {
                $msg = "Error Deleting Record.";
                $status = false;
            }
            return json_encode(array('msg'=>$msg,'status'=>$status));
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function actionInsertfgequiptab(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qry = "insert into fgi_cylinder (itemid,code,cylinder) values(".$params['fg_itemid'].",".$params['e_itemid'].",'".$params['e_itemname']."')";
        $status =  Yii::$app->sbccommon->execqry($qry);

        if($status){
            $msg = '';
        }else{
            $msg = 'Error inserting Equipment/Tool. Please try again.';
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action

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

    public function actionGetfgtransform() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['x'] != ""){
            $where = "where name like '%".$params['x']."%'";
        }else{
            $where = "";
        }//end if

        $qry = "select id,code,name from transform_masterfile " .$where;

        $params = [
            'sql' => $qry,
            'tableid' => 'fgtransformtbl',
            'key' => 'id', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
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
                                'class' => 'pickfgtransform btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'transform','value'=>'name'],['name' => 'transformid','value' => 'id']]
                            ]
                        ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

     //WTODO: [KIM][2019.10.31]
    public function actionGetfgaddspecs() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['x'] != ""){
            $where = "where name like '%".$params['x']."%'";
        }else{
            $where = "";
        }//end if

        $qry = "select id,code,name from prodspec_masterfile " .$where;

        $params = [
            'sql' => $qry,
            'tableid' => 'fgaddspecstbl',
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
                                'class' => 'pickfgaddspecs btn btn-social-icon btn-bitbucket',
                                'attributes' => [['name' => 'addspecs','value'=>'name'],['name' => 'addspecsid','value' => 'id']]
                            ]
                        ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn
}//END CONTROLLER


