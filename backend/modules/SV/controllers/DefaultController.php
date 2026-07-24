<?php

namespace backend\modules\SV\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;

//FOR TESTING PURPOSES
use app\models\Item;
use app\models\Cntnum;
use app\models\Postock;
use app\models\Lastock;

use yii\base\ErrorException;

class DefaultController extends Controller{

	public $access = array(
        'view' => 3275 ,'edit' => 3276,'new' => 3277,
        'save' => 3278,'change' => 3279,'delete' => 3280,
        'print' => 3281,'lock' => 3282,'unlock' => 3283,
        'changeamount' => 3284,'crlimit'=>3285,'post' => 3286,'unpost' => 3287,
        'clickadditem'=>3288,'clickedititem'=>3289,'clickdeleteitem'=>3290);

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
          echo json_encode(array('moduledata' => $return['data']));
        }
    }//END ACTION NAVBUTTONS


    public function actionNewdocument(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNewdocument($this,$params);                
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
          echo json_encode(array('moduledata' => $return['data']));
        }        
    }//END NEW DOCUMENT

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
          echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
          'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted']));
        }                               
    }

    public function actionDeletedoc(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET['params'];
        $return=Yii::$app->sbccontroller->sbcDeletedoc($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            echo json_encode(array('moduledata' => $return['data'],'istransposted'=>$return['istransposted']));
        }                               
    }

//FOR SEARCHING FUNCTIONS ###################################################################################
    //THIS FUNCTION IS USED WHEN DIRECTLY LOOKING FOR DOCNO [WITHOUT THE USE OF LOOKUP BUTTON]
    public function actionSearchdocno(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcSearchdocno($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        }                                       
    }//END SEARCH DOCNO


    //USED BY SEARCHING OF DOCNO ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionDocnolookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateDocnolookup($params);
    }

    public function actionSvrrdocnolookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;

      $qry = "select num.trno,num.docno,supp.clientname,supp.client,
      left(head.dateid,10) as dateid,num.postedby,left(num.postdate,10) as postdate,
      head.yourref,head.ourref from glhead as head
      left join cntnum as num on num.trno = head.trno
      left join client as supp on supp.clientid = head.clientid
      where num.doc = 'RR' and num.svnum = 0 
      and (head.docno like '%".$params['x']."%' or supp.clientname like '%".$params['x']."%' 
      or head.yourref like '%".$params['x']."%' or head.ourref like '%".$params['x']."%')";

      
      $params = [
          'sql' => $qry,
          'tableid' => 'tbl-docnolookup',
          'key' => 'trno',
          'txtclass' => 'bodytextbox',
          'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
          'column' => [[
                  'name' => 'dateid',
                  'label' => 'Date',
                  'class' => 'aimslabel col-min'
              ],[
                  'name' => 'docno',
                  'label' => 'Document #',
                  'class' => 'aimslabel col-description'
              ],[
                  'name' => 'clientname',
                  'label' => 'Supplier',
                  'class' => 'aimslabel col-description'
              ],[
                  'name' => 'yourref',
                  'class' => 'aimslabel col-codes'
              ],[
                  'name' => 'ourref',
                  'class' => 'aimslabel col-codes'
              ],[
                  'name' => 'postdate',
                  'class' => 'aimslabel col-description'
              ],[
                  'name' => 'postedby',
                  'label' => 'Posted by',
                  'class' => 'aimslabel col-description'
              ]],
          'buttons' => [
              [
                  'name' => '',
                  'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-download"></i>',
                  'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                  'class' => 'picksvrr btn btn-social-icon btn-bitbucket',
                  'attributes' => [['name'=>'trno','value'=>'trno']]
              ]
          ]
      ];

      return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionSupplierlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSupplierlookup($params);
    }//end fn


    public function actionWarehouselookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateWarehouselookupGV($params);
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
           echo json_encode(array('moduledata' => $return['data']));
        }                                       
   }//END ACTION CANCEL


   public function actionCanceledit(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcCanceledit($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('stockdata' => $return['data']));
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
           echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
          'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
        }                                       
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
         echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']));
        }                                       
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
         echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'istransposted'=>$return['istransposted']));
        }                                       
   }//END ACTION LOCK UNLOCK


   public function actionLog(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateLog($this,$params);
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
           echo json_encode(array('whdata'=>$return['data'],'postedpobal'=>$return['postedpobal'],
            'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
            'unpostedsobal'=>$return['unpostedsobal']));
        }                                       
   }//END SHOW STOCK

   public function actionLoadterms() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateTermslookup($params);
      }

   public function actionGetuom(){
    Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetuom($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('uom'=>$return['data']));
        }                                       
   }//END UOM

   public function actionComparestocklines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;   
        //echo json_encode(array('ischanged'=>0,'stockdata'=>$_POST));
        Yii::$app->sbccontroller->sbcComparestocklines($this,$params);          
    }//END COMPARE STOCK LINE

    public function actionQuickadditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcQuickadditem($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('primarydata' => $return['primarydata'],'errmsg'=>$return['errmsg']));
        }                                       
    }//END ACTION QUICK ADD

    public function actionReqprice(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcReqprice($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('pricedata'=>$return['pricedata']));
        }                                       
    }//END REQ PRICE

    public function actionContrasearch(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);                                   
    }//END CONTRA

    public function actionRequestclientpo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcRequestclientpo($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('clientpo' => $return['clientpo'],'type'=>$return['type']));      
        }                                       
    }//end requestclientpo

    public function actionRetrieveorderdata(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcRetrieveorderdata($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('returntype'=>$return['returntype'],'podata'=>$return['podata']));
        }                                       
}//end action retrievedata


   public function actionGetlocation(){
      Yii::$app->backend->AjaxVerification($this);
      $barcode = $_GET['barcode'];
      $data = Yii::$app->backend->getAvailableLocation($barcode);
      echo json_encode(array('locations' => $data));
    }//end get location

    public function actionRequestdistro(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateAcctg($this,$params);  
                                          
    }//end distro

    public function actionComputeduedate(){
      $date = Yii::$app->backend->computeduedate($_GET['terms'],$_GET['dateid']);
      echo json_encode(array('duedate' => $date));
    }

    public function actionGetdocreference(){
      Yii::$app->backend->AjaxVerification($this);
      $trno = $_GET['trno'];
      $doc = $this->module->id;
      $data = Yii::$app->backend->getDocumentreference($trno,$doc);
      if(empty($data)){ 
          echo json_encode(array('data' => ""));  
      }else{
         echo json_encode(array('data' => $data));  
      }
    }//END FUNCTION

    public function actionRetrievepricehistory(){
      Yii::$app->backend->AjaxVerification($this);
      $doc = $this->module->id;
      $ccode = Yii::$app->backend->sanitize($_GET['ccode'],'DEFAULT');
      $barcode = Yii::$app->backend->sanitize($_GET['barcode'],'DEFAULT');

      $history = Yii::$app->backend->retrievePriceHistory($doc,$barcode,$ccode);
      echo json_encode(array('pricehistory'=>$history));
    }//end function
    

    public function actionVoiditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcVoidItem($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('voiding'=>$return['data']));
        }//end function
    }//end function

    public function actionGetuser(){
        Yii::$app->backend->AjaxVerification($this); 
        $data = Yii::$app->backend->getUsers(true); 
        echo json_encode(array('uzer'=>$data));
    }//end action
    
    public function actionGetavailablerr(){
        Yii::$app->backend->AjaxVerification($this); 
        $searchthis = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');

        if(Yii::$app->backend->checkConfidentialAccess()){
          $filter = "";
        }else{
          $filter = " and supp.groupid <> 'CONFI'";
        }//end if

        $qry = "select num.trno,num.docno,supp.clientname,supp.client,head.dateid,num.postedby,
        num.postdate,head.yourref,head.ourref from glhead as head
        left join cntnum as num on num.trno = head.trno
        left join client as supp on supp.clientid = head.clientid
        where num.doc = 'RR' and is_sp = 0 ".$filter." and (head.docno like '%".$searchthis."%' 
        or supp.clientname like '%".$searchthis."%' 
        or head.yourref like '%".$searchthis."%' or head.ourref like '%".$searchthis."%')";

        $data = Yii::$app->sbccommon->opentable($qry);
        echo json_encode(array('searchitems' => $data));
    }//end action get avail rr

    public function actionTransferitemssp(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      $params = Yii::$app->backend->sanitize($_GET,'ARRAY');

      $qry = "select ".$params['spt'].",stock.trno,stock.itemname,item.barcode,stock.uom,wh.client as wh,
              stock.disc,stock.rem,stock.rrcost,stock.rrqty,stock.cost,stock.qty,stock.ext,stock.void,
              stock.encodedby,stock.editby,stock.ref,stock.refx,stock.line,stock.loc,stock.expiry 
              from glstock as stock
              left join client as wh on wh.clientid = stock.whid
              left join item on item.itemid = stock.itemid
              where stock.trno = ".$params['qq'];

      $items = Yii::$app->sbccommon->opentable($qry);
      $count = Yii::$app->sbccommon->datareader("select count(line) as count from spstock where sptrno =".$params['spt']);

      foreach ($items as $key => $value) {
        $count += 1;
        $insertqry = "insert into spstock 
                      (line,sptrno, trno, itemname, barcode, uom, wh, disc, rem, rrcost, rrqty,cost, 
                      qty,ext,void,encodedby,editby,ref,refx,linex,loc,expiry)
                      values(".$count.",'".$params['spt']."','".$value['trno']."','".$value['itemname']."',
                      '".$value['barcode']."','".$value['uom']."','".$value['wh']."',
                      '".$value['disc']."','".$value['rem']."','".$value['rrcost']."','".$value['rrqty']."',
                      '".$value['cost']."','".$value['qty']."','".$value['ext']."','".$value['void']."',
                      '".$value['encodedby']."','".$value['editby']."','".$value['ref']."','".$value['refx']."',
                      '".$value['line']."','".$value['loc']."','".$value['expiry']."')";

        $status = Yii::$app->sbccommon->execqry($insertqry);    
      }//for each
      
      if($status){
        $qry2 = "update cntnum set svnum = 1 where cntnum.doc = 'RR' and cntnum.trno =".$params['qq'];
        $status = Yii::$app->sbccommon->execqry($qry2);

        if($status){
          $itemqry = "select stock.sptrno,item.itemid,stock.line,stock.trno,stock.itemname,stock.barcode,
                  stock.uom,stock.wh,stock.disc,stock.rem,
                  round(stock.rrcost,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrcost,
                  round(stock.rrqty,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as rrqty,
                  stock.cost,stock.qty,round(stock.ext,".Yii::$app->systemsettings->setDecimaldisplay('quantity').") as ext,
                  stock.void,stock.encodedby,stock.editby,
                  stock.ref,stock.refx,stock.linex,stock.loc,stock.expiry from spstock as stock
                  left join item on item.barcode = stock.barcode
                  where stock.sptrno = ".$params['spt']." and stock.trno = ".$params['qq'];
          $msg = '';
        }else{
          $msg = "Error Updating MAIN TABLE TAGGING [Please contact support]";
        }//end if
      }else{
        $msg = "Error Copying RR Items to Supplier Invoice, Please try again.";
      }//end if

      $grandtotal = Lastock::getgrandtotal($params['spt'], 'SV');

      if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
          $gtotal = 0;
      }else{
          $gtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
      }//end if

      //IF SET GRAND TOTAL ITEM COUNT TO 0 IF DOESNT HAVE ANY VALUE               
      if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
          $itemcount = 0;
      }else{
          $itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
      }//END IF

      echo json_encode(['status'=>$status,'msg'=>$msg,'gtotal'=>$gtotal,'itemcount'=>$itemcount]);

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end function


    public function actionShowlinkeddocuments(){
      try {
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;

        $qry = "select stock.trno,head.docno,left(head.dateid,10) as dateid from spstock as stock
                left join glhead as head on head.trno = stock.trno
                where head.trno in (select distinct spt.trno from spstock as spt where spt.sptrno =".$params['x'].")
                group by stock.trno
                UNION ALL
                select stock.trno,head.docno,left(head.dateid,10) as dateid from hspstock as stock
                left join glhead as head on head.trno = stock.trno
                where head.trno in (select distinct spt.trno from hspstock as spt where spt.sptrno =".$params['x'].")
                group by stock.trno";

        $islocked = Cntnum::islocked($params['x'], 'SV');
        $isposted = Cntnum::isPosted($params['x'],'SV');

        $readonly = false;
        $editable = false;
        $gridcheckbox = false;
        $id = 'svrrlist';
        
        $btnset = [[
                      'name' => '',
                      'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                      'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                      'class' => 'removesptdocno gvbtns btn btn-social-icon btn-google',
                      'attributes' => [['name'=>'trno','value'=>'trno']]
                  ]];

        $params = [
            'sql' => $qry,
            'tableid' => $id,
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => $gridcheckbox,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-min'
                ]
            ],
            
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end function

    public function actionRemovelinkdocno(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      $q = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
      $spt = Yii::$app->backend->sanitize($_GET['spt'],'DEFAULT');

      $qry = "delete from spstock where trno = ".$q;
      $status = Yii::$app->sbccommon->execqry($qry);
      
      if($status){
        $msg = "";
        $qrycnt = "update cntnum set svnum = 0 where trno = ".$q;
        Yii::$app->sbccommon->execqry($qrycnt);
      }else{
        $msg = "Failed to remove linking. Please try again.";
      }//end function

      $grandtotal = Lastock::getgrandtotal($spt, 'SV');

      if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
          $gtotal = 0;
      }else{
          $gtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
      }//end if

      //IF SET GRAND TOTAL ITEM COUNT TO 0 IF DOESNT HAVE ANY VALUE               
      if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
          $itemcount = 0;
      }else{
          $itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
      }//END IF

      echo json_encode(array('status'=>$status,'msg'=>$msg,'gtotal'=>$gtotal,'itemcount'=>$itemcount));
        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action

    public function actionBuildstockview(){
	    Yii::$app->backend->AjaxVerification($this); 
	    $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
	    $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
	    
	    $type = "";
	    if(isset($_POST['type'])){
	      $type = $_POST['type'];
	    }//end if

	    return Yii::$app->automator->generateSVStockview($sql,$type);
	}//end function
}//END CONTROLLERR
