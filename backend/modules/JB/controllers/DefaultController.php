<?php

namespace backend\modules\JB\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use app\models\Lastock;
use app\models\Log;

use yii\base\ErrorException;
//FOR TESTING PURPOSES
use app\models\Item;


class DefaultController extends Controller{
    
    public $access = array('view' => 3263,'edit' => 3263,'new' => 3263,
        'save' => 3263,'change' => 3263,'delete' => 3263,'print' => 3263,
        'lock' => 3263,'unlock' => 3263,'post' => 3263,'unpost' => 3263,
        'viewdetails' => 3263,'changeamount' => 3263,'autocompute' => 3263,'crlimit' =>3263,
        'clickadditem'=>3263,'clickedititem'=>3263,'clickdeleteitem'=>3263);

    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }//end fn 

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

    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);

        $type = "";
        if(isset($_POST['type'])){
          $type = $_POST['type'];
        }//end if

        return Yii::$app->automator->generateJBStockview($sql,$type);
    }//end function

    public function actionShowavailmaterials(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');

        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'updatematerialitem gvbtns btn btn-social-icon btn-bitbucket',
        ],[
          'name' => '',
          'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'removematerialitem gvbtns btn btn-social-icon btn-google',
        ]];

        //WTODO: [KIM][2019.10.30][add for uom]
        $sql = "select tab.trno,tab.line,tab.barcode,item.itemname,
                tab.qty,item.uom,tab.`process` from jb_materialtab as tab
                left join item on item.barcode = tab.barcode
                where trno = ".$trno;

        $params = [
            'sql' => $sql,
            'tableid' => 'jbshowmaterialtbl',
            'key' => 'line',
            'txtclass' => 'jbmaterialtxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'barcode',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class'=>'col-codes stocktxt txtgridbarcode',
                ],[
                    'name' => 'itemname',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class'=>'col-description stocktxt txtgridbarcode',
                ],[
                    'name' => 'qty',
                    'editable' => true,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class'=>'col-codes stocktxt txtgridbarcode',
                //WTODO: [KIM][2019.10.30][additional column for uom material tab]
                ],[
                    'name' => 'uom',
                    'editable' => true,
                    'readonly' => true,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class'=>'col-codes stocktxt txtgridbarcode',
                ],[
                    'name' => 'process',
                    'editable' => true,
                    'readonly' => true,
                    'label' => 'Process',
                    'type' => 'lookup',
                    'class' => 'col-codes aimslabel',
                    'lookupbutton' => ['autocall'=>'',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns jblookup_process',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function actionShowavailprocess(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $btnset = [[
          'name' => '',
          'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'updateprocessjb gvbtns btn btn-social-icon btn-bitbucket',
        ],[
          'name' => '',
          'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
          'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
          'class' => 'removeprocessjb gvbtns btn btn-social-icon btn-google',
        ]];

        $sql = "select line,trno,seq as sequence,code,`process`,
                instruct as instruction from jb_processtab where trno =" . $trno . " order by barcode,seq";

        $params = [
            'sql' => $sql,
            'tableid' => 'jbshowmaterialtbl',
            'key' => 'line',
            'txtclass' => 'jbprocesstxt',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'sequence',
                    'editable' => true,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class'=>'col-codes stocktxt txtgridbarcode',
                ],[
                    'name' => 'code',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class'=>'col-description stocktxt txtgridbarcode',
                ],[
                    'name' => 'process',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'class'=>'col-description stocktxt txtgridbarcode',
                ],[
                    'name' => 'instruction',
                    'editable' => true,
                    //'readonly' => $readonly,
                    'type' => 'text',
                    'class'=>'col-codes stocktxt txtgridbarcode',
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ]
            ],
            'buttons' => $btnset
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function

    public function actionInsertjbmaterial(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      //QTY CHECKER
      $qry = "select bal from rrstatus
              left join item on item.itemid = rrstatus.itemid
              left join client as wh on wh.clientid = rrstatus.whid
              where item.barcode = '".$params['q']."' and wh.client = '".$params['wh']."'";
      $balance = Yii::$app->sbccommon->datareader($qry);

      if(!empty($balance)){
        $getlastlineqry = "select line from jb_materialtab where trno = '".$params['qq']."' order by line desc limit 1";
        $last_line = Yii::$app->sbccommon->datareader($getlastlineqry);

        if(empty($last_line)){
          $last_line = 1;
        }else{
          $last_line += 1;
        }//end if

        $qryinsert = "insert into jb_materialtab (line,trno,barcode,qty) values(".$last_line.",".$params['qq'].",'".$params['q']."','".$params['qty']."')";
        $status = Yii::$app->sbccommon->execqry($qryinsert);

        if($status){
          $msg = 'Material inserted successfully!';
        }else{
          $msg = 'Material inserting failed. Please try again later.';
        }//end if
      }else{
        $status = false;
        $msg = "Material is out of stock. Please check stock thanks.";
        Log::writelog('JB',$params['qq'],'MAT_OUT_STOCK','Material out of stock >' . $params['q'],Yii::$app->session['loggeduser']['username']);
      }//end if
      echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end fn

    public function actionClientlookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateClientlookup($params);
    }//END FN

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
    }//END FN


    public function actionSavehead(){
      try {
        
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
      } catch (ErrorException $e) {
          echo $e;
      }
    }//end fn

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

    public function actionItemlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateItemJBMateriallookupGV($params);
    }//end f

    public function actionItemfglookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateItemFGlookupGV($params);
    }//endd fn

    public function actionReqprice(){
      try {
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
        
        
      } catch (ErrorException $e) {
        echo $e;
      }                                   
    }//END REQ PRICE


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

   //FOR SPECIFIC DATA WITH PRIMARY KEY
    public function actionPulldata(){
     try {
      Yii::$app->backend->AjaxVerification($this);

      $primarykey =$_GET['primarykey'];
      $type = $_GET['type'];
      $isqty = $_GET['qty'];
      $whcode = $_GET['whcode'];
      $whname = $_GET['wh'];
      $itemamt =str_replace(",","",$_GET['amt']); 
      $disc = $_GET['disc'];
      $trno = $_GET['trno'];

    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'NEWTIANLE':
        $uomvalue = explode('~', $_GET['uomfactor']);
        $uomstring = explode('~', $_GET['uom']);
        $uomfactor = $uomvalue[0];
        $uom = $uomstring[0];
        break;
      
      default:
        $uomfactor = $_GET['uomfactor'];
        $uom = $_GET['uom'];
        break;
    }//end switch 

      $primarydata = Yii::$app->backend->pullDatainfo($this,$type,$primarykey);
      $computeddata = Yii::$app->backend->computestock($itemamt,$disc,$isqty,$uomfactor,$this);
      
      $primarydata[0]['trno'] = $trno;
      $primarydata[0]['ext'] = $computeddata['ext'];
      $primarydata[0]['iss'] = $computeddata['iss'];
      $primarydata[0]['isqty'] = $isqty;
      $primarydata[0]['amt'] = $computeddata['amt'];
      $primarydata[0]['disc'] = $disc;
      $primarydata[0]['isamt'] = $itemamt;
      $primarydata[0]['uom'] = $uom;
      $primarydata[0]['uomfactor'] = $uomfactor;
      $primarydata[0]['whcode'] = $whcode;
      $primarydata[0]['whname'] = $whname;
      $primarydata[0]['loc'] = $_GET['loc'];
      $primarydata[0]['expiry'] = $_GET['expiry'];
      $primarydata[0]['rem'] = $_GET['rem'];
        
      $moduledata["barcode"]= $primarydata[0]["barcode"];
      $moduledata["itemid"]= $primarydata[0]["itemid"];
      $moduledata["category"]= $primarydata[0]["category"];
      $moduledata["groupid"]= $primarydata[0]["groupid"];
      
      $moduledata["itemname"]= $primarydata[0]["itemname"];
      
      $moduledata["uom"]= $primarydata[0]["uom"];
      $moduledata["isamt"]= $primarydata[0]["isamt"];
      $moduledata["ext"]= $primarydata[0]["ext"];
      $moduledata["disc"]= $primarydata[0]["disc"];
      $moduledata["rem"]= $primarydata[0]["rem"];
      $moduledata["iss"]= $primarydata[0]["iss"];
      $moduledata["isqty"]= $primarydata[0]["isqty"];
      $moduledata["amt"]= $primarydata[0]["amt"];
      $moduledata["uomfactor"]= $primarydata[0]["uomfactor"];
      $moduledata["whcode"]= $primarydata[0]["whcode"];
      $moduledata["whname"]= $primarydata[0]["whname"];
      $moduledata["loc"]= $primarydata[0]["loc"];
      $moduledata["expiry"]= $primarydata[0]["expiry"];
      $moduledata["trno"]= $primarydata[0]["trno"];
      $moduledata["line"]= 0;
      $moduledata["refx"]= 0;
      $moduledata["linex"]= 0;
      $moduledata["ref"]= '';


      $returndata = Yii::$app->webprocess->savingstock($this,$this->access['save'],$moduledata);
      $return['stockline']['gvrow-'.$returndata['line']] = $returndata;
      $return['line'] = $returndata['line'];          
      echo json_encode($return);
    }catch (ErrorException $e) {
      echo json_encode(array('sbcerror' => 1,'stacktrace'=>$e));
    }//end try
   }//END PULL DATA

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
           echo json_encode(array('computeddata' => $return['data']));
        }                                       
   }//END COMPUTE STOCK

   public function actionSavestock(){
    Yii::$app->backend->AjaxVerification($this);    
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavestock($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }                                       
   }//END POGI

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
   }//END POGI


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

  public function actionStockdelete(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcStockdelete($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']));
        }                                       
  }//END DELETE

  public function actionPost(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcPost($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'SOUTHCENTRAL':
                  echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'isapproved'=>$return['isapproved'],
                    'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
                break;

                default:
                    echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
                    'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
                break;
            }//end swtich
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
   }//END SHOW STOCK
   public function actionLoaditembal() {
    Yii::$app->backend->AjaxVerification($this);
    $params = $_POST;
    $params['controller'] = $this;
    return Yii::$app->automator->automateItembal($params);
   }

   public function actionGetterms(){
        Yii::$app->backend->AjaxVerification($this);
        $return=Yii::$app->sbccontroller->sbcGetterms($this);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('terms'=>$return['data']));
        }                                               
   }//END GET TERMS

   public function actionComparestocklines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;   
        Yii::$app->sbccontroller->sbcComparestocklines($this,$params);          
    }//END COMPARE STOCK LINE

    public function actionQuickadditem(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcQuickadditem($this,$params);  
    }//END ACTION QUICK ADD


    public function actionGetdocreference(){
      Yii::$app->backend->AjaxVerification($this);
      $trno = $_GET['trno'];
      $doc = $this->module->id;
      $data = Yii::$app->backend->getDocumentreference($trno,$doc);
      if(empty($data)){ 
          echo json_encode(array('data' => ""));  
      }else{
         echo json_encode(array('data' => $data));  
      }//END FUNCTION
    }//END FUNCTION

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
        $data = Yii::$app->backend->getUsers(true); 
        echo json_encode(array('uzer'=>$data));
    }//end action

    public function actionDocnolookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateDocnolookup($params); 
    }//fn

    public function actionWarehouselookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateWarehouselookupGV($params);
    }

      public function actionLog(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      return Yii::$app->automator->automateLog($this,$params);  
                                       
    }

    public function actionUomlookup(){
      Yii::$app->backend->AjaxVerification($this);
      $params = ['itemid'=>$_POST['x']];
      return Yii::$app->automator->automateUOMlookupGV($params);
    }//end function

    public function actionLoadterms() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateTermslookup($params);
    }

    public function actionGetlocation(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['barcode'=>$_POST['x']];
        return Yii::$app->automator->automateLocationlookupGV($params);
    }//end get location


    public function actionLoaduoms() {
      $barcode = $_POST['x'];
      $itemid = Yii::$app->backend->requestItemid($barcode);
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['itemid'] = $itemid;
      $params['controller'] = $this;
      return Yii::$app->automator->automateUomlookup($params);
    }
    

    public function actionUpdatematerialtab(){
    	Yii::$app->backend->AjaxVerification($this);
      	$params = $_GET;
      	
      	$qryupdated = "update jb_materialtab set process = '".$params['pcode']."' , qty = ".$params['qty']." 
      				where trno = " . $params['q']. " and line = ". $params['line'];
      	$status = Yii::$app->sbccommon->execqry($qryupdated);

      	if($status){
      		$msg = "Material tab updating successfully!";
      	}else{
      		$msg = "Material tab updating failed. Please try again.";
      	}//end f

      	echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action

    public function actionUpdateprocesstab(){
    	Yii::$app->backend->AjaxVerification($this);
      	$params = $_GET;
      	
      	$qryupdated = "update jb_processtab set seq = '".$params['seq']."' , code = '".$params['code']."',
      				process = '".$params['proc']."',instruct = '".$params['instruct']."'
      				where trno = " . $params['q']. " and line = ". $params['line'];
      	$status = Yii::$app->sbccommon->execqry($qryupdated);

      	if($status){
      		$msg = "Process tab updating successfully!";
      	}else{
      		$msg = "Process tab updating failed. Please try again.";
      	}//end f

      	echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action

    public function actionRemovematerial(){
    	Yii::$app->backend->AjaxVerification($this);
      	$params = $_GET;
      	
      	$qryremove = "delete from jb_materialtab where trno = ".$params['q']." and line =".$params['line'];
      	$status = Yii::$app->sbccommon->execqry($qryremove);

      	if($status){
      		$msg = "Material item removed successfully!";
      	}else{
      		$msg = "Material removal failed. Please try again.";
      	}//end f

      	echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action

    public function actionRemoveprocess(){
    	Yii::$app->backend->AjaxVerification($this);
      	$params = $_GET;
      	
      	$qryremove = "delete from jb_processtab where trno = ".$params['q']." and line =".$params['line'];
      	$status = Yii::$app->sbccommon->execqry($qryremove);

      	if($status){
      		$msg = "Process removed successfully!";
      	}else{
      		$msg = "Process removal failed. Please try again.";
      	}//end f

      	echo json_encode(['status'=>$status,'msg'=>$msg]);
    }//end action

    public function actionLoadfgprocess() {
      try {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;

        if($params['q'] != ''){
          $where = " where code like '%".$params['q']."%' or name like '%".$params['q']."%' ";
        }else{
          $where = '';
        }//end if

        $qry = "select id, code, name from fg_process ".$where." order by id";

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

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }

    public function actionInsertprocesstab(){
    	try {
    	Yii::$app->backend->AjaxVerification($this); 
    	$params = $_GET;

    	$getlastlineqry = "select line from jb_processtab where trno = '".$params['q']."' order by line desc limit 1";
        $liner = Yii::$app->sbccommon->datareader($getlastlineqry);

        if(empty($liner)){
            $liner = 1;
        }else{
            $liner += 1;
        }//end if

        $qryinsertprocess = "insert into jb_processtab (trno,line,code,process)
                            values (".$params['q'].",".$liner.",'".$params['code']."','".$params['proc']."')";
        $status = Yii::$app->sbccommon->execqry($qryinsertprocess);

        if($status){
        	$msg = "Inserting process successfully!";
        }else{
        	$msg = "Inserting process failed. Please try again.";
        }//end if

        echo json_encode(['status'=>$status,'msg'=>$msg]);

    		
    	} catch (ErrorException $e) {
    		echo $e;
    	}
    }//end action

    public function actionViewmaterialguide(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_POST;
      $qry = "select 'material' as tablename, fgi_material.line,
              material2.name as material,
              fgi_material.width,fgi_material.thickness,material2.id
              from fgi_material 
              left join fg_material as material2 on material2.id = fgi_material.material
              left join item on item.itemid = fgi_material.itemid
              where item.barcode = '".$params['x']."' order by line";

      $params = [
          'sql' => $qry,
          'tableid' => 'fguitbl',
          'key' => 'line',
          'txtclass' => 'fguitxt',
          'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
          'column' => [
              [
                  'name' => 'material',
                  'editable' => false,
                  'type' => 'text',
                  'class' => 'col-codes'
              ],[
                  'name' => 'width',
                  'editable' => false,
                  'type' => 'text',
                  'class' => 'col-min'
              ],[
                  'name' => 'thickness',
                  'editable' => false,
                  'type' => 'text',
                  'class' => 'col-min'
              ]
          ],
          'buttons' => ""
      ];

      return Yii::$app->tblgenerator->generateGrid($params);

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action

    public function actionViewcolorguide(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_POST;

      $qry = "select 'colors' as tablename, i.line, i.color as id, c.name as color 
              from fgi_colors as i 
              left join fg_colors as c on c.id = i.color 
              left join item on item.itemid = i.itemid
              where item.barcode = '".$params['x']."' order by i.line";


      $params = [
          'sql' => $qry,
          'tableid' => 'fguitbl2',
          'key' => 'line',
          'txtclass' => 'fguitxt',
          'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
          'column' => [
              [
                  'name' => 'color',
                  'editable' => false,
                  'type' => 'text',
                  'class' => 'col-description'
              ]
          ],
          'buttons' => ""
      ];

      return Yii::$app->tblgenerator->generateGrid($params);

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action

    public function actionViewfgheader(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_GET;

      $qry = "select item.barcode,item.itemname,item.uom,item.fg_sealing as sealing,
      item.fg_transform as transformation,item.fg_plasticcolor as plasticcolor,
      item.fg_jowidth,item.fg_jowidthuom,item.fg_jolength,item.fg_jolengthuom,
      item.fg_thickness,item.fg_colornum from item
      left join fg_transformation as fg_trans on fg_trans.id = item.fg_transform
      left join fg_plasticcolor as fg_plastic on fg_plastic.id = item.fg_plasticcolor
      where item.barcode = '".$params['q']."'";

      $data = Yii::$app->sbccommon->opentable($qry);

      echo json_encode(['data'=>$data]);
      
        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action

    public function actionGeneratemi(){
      try {
      Yii::$app->backend->AjaxVerification($this); 
      $q = $_GET['q'];

      $data = Yii::$app->automator->automateHeadCredential('JB',$q);
      
      foreach ($data as $key => $value) {
        foreach ($value as $key2 => $value2) {
          $params[$key2] = $value2;
        }//end for each
      }//emd for each

      $return1 = Yii::$app->automator->automateHeadGeneration('MI','MI',$params);

      if($return1['status']){
        $stockdata = Yii::$app->automator->automateStockCredential('JB',$q);
        
        if(!empty($stockdata)){
          $key2 = 0;
          foreach ($stockdata as $key => $value) {
            $a_params['q'] = $value['itemid'];
            $a_params['wh'] = $params['wh'];

            $a_inv = Yii::$app->backend->getAvailableInventory($a_params);

            for ($i=0; $i < count($a_inv); $i++) { 
              
              if($a_inv[$i]['bal'] > ($value['isqty'] * $value['factor'])){
                $stockdata[$key2]['itemid'] = $value['itemid'];
                $stockdata[$key2]['barcode'] = $value['barcode'];
                $stockdata[$key2]['itemname'] = $value['itemname'];
                $stockdata[$key2]['uom'] = $value['uom'];
                $stockdata[$key2]['rem'] = $value['rem'];
                $stockdata[$key2]['ref'] = $value['ref'];

                $stockdata[$key2]['isqty'] = $value['isqty'];
                $stockdata[$key2]['expiry'] = $a_inv[$i]['expiry'];
                $stockdata[$key2]['loc'] = $a_inv[$i]['loc'];

                $addedstockdata = Yii::$app->backend->computestock_Internal(str_replace(',', '',$a_inv[$i]['cost']),'',$value['isqty'],1,'MI');

                $stockdata[$key2]['isamt'] = str_replace(',', '',$a_inv[$i]['cost']);
                $stockdata[$key2]['iss'] = str_replace(',', '',$addedstockdata['iss']);
                $stockdata[$key2]['amt'] = str_replace(',', '',$addedstockdata['amt']);
                $stockdata[$key2]['qa'] = $addedstockdata['qa'];
                $stockdata[$key2]['ext'] = str_replace(',', '',$addedstockdata['ext']);
                $stockdata[$key2]['factor'] = 1;
                $stockdata[$key2]['disc'] = '';
                break; //exits loop
              }else{
                $currentqty = $value['isqty'];
                $stockdata[$key2]['itemid'] = $value['itemid'];
                $stockdata[$key2]['barcode'] = $value['barcode'];
                $stockdata[$key2]['itemname'] = $value['itemname'];
                $stockdata[$key2]['uom'] = $value['uom'];
                $stockdata[$key2]['rem'] = $value['rem'];
                $stockdata[$key2]['ref'] = $value['ref'];

                $stockdata[$key2]['isqty'] = floatval($a_inv[$i]['bal']);
                $stockdata[$key2]['expiry'] = $a_inv[$i]['expiry'];
                $stockdata[$key2]['loc'] = $a_inv[$i]['loc'];

                $addedstockdata = Yii::$app->backend->computestock_Internal(str_replace(',', '',$a_inv[$i]['cost']),'',$a_inv[$i]['bal'],1,'MI');

                $stockdata[$key2]['isamt'] = str_replace(',', '',$a_inv[$i]['cost']);
                $stockdata[$key2]['iss'] = str_replace(',', '',$addedstockdata['iss']);
                $stockdata[$key2]['amt'] = str_replace(',', '',$addedstockdata['amt']);
                $stockdata[$key2]['qa'] = $addedstockdata['qa'];
                $stockdata[$key2]['ext'] = str_replace(',', '',$addedstockdata['ext']);
                $stockdata[$key2]['factor'] = 1;
                $stockdata[$key2]['disc'] = '';

                $value['isqty'] =  floatval($value['isqty'] * $value['factor']) - floatval($a_inv[$i]['bal']);  
                $key2 += 1;
              }//end if
            }//end for loop

            $key2 += 1;
          }//end for each 1st

          foreach ($stockdata as $key => $value) {
            foreach ($value as $key2 => $value2) {
              $params2[$key2] = $value2;
              $params2['whcode'] = $params['wh'];
            }//end for each

           

            $last_line = Lastock::getLastLine('MI',$return1['trno'])+1;
            Yii::$app->automator->automateStockGeneration('MI',$return1['trno'],$last_line,$params2);    
          }//emd for each

          $generatestatus = true;
        }//end ! empty
      }else{
        $generatestatus = false;
      }//end if

      $qrygetter = "select docno from cntnum where trno = " . $return1['trno'];
      $docno = Yii::$app->sbccommon->datareader($qrygetter);

      if($generatestatus){
        $qryupdater1 = "update hjbhead as head set head.withdrawnum = " . $return1['trno']." where trno =".$q;
        Yii::$app->sbccommon->execqry($qryupdater1);

        Log::writelog('JB', $q, 'Withdrawal #','Generated Withdrawal # ['.$docno.']',Yii::$app->session['loggeduser']['username']);
      }//end if

      echo json_encode(['status'=>$generatestatus,'trno'=>$return1['trno'],'docno'=>$docno]);
      
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end fn


    public function actionGeneratets(){
      Yii::$app->backend->AjaxVerification($this); 
      $q = $_GET['q'];

      $data = Yii::$app->automator->automateHeadCredential('JB',$q);
      foreach ($data as $key => $value) {
        foreach ($value as $key2 => $value2) {
          $params[$key2] = $value2;
        }//end for each
      }//emd for each

      $return1 = Yii::$app->automator->automateHeadGeneration('TS','TS',$params);

      if($return1['status']){
        $stockdata = Yii::$app->automator->automateStockCredential('JB_TS',$q);
        
        if(!empty($stockdata)){
          $key2 = 0;
          
          foreach ($stockdata as $key => $value) {
            $a_params['q'] = $value['itemid'];
            $a_params['wh'] = $params['wh'];

            $a_inv = Yii::$app->backend->getAvailableInventory($a_params);

            if(!empty($a_inv)){
              for($i=0; $i < count($a_inv); $i++) { 
                if($a_inv[$i]['bal'] >= (1 * $value['factor'])){
                  $stockdata[$key2]['itemid'] = $value['itemid'];
                  $stockdata[$key2]['barcode'] = $value['barcode'];
                  $stockdata[$key2]['itemname'] = $value['itemname'];
                  $stockdata[$key2]['uom'] = $value['uom'];
                  $stockdata[$key2]['rem'] = $value['rem'];
                  $stockdata[$key2]['ref'] = $value['ref'];

                  $stockdata[$key2]['isqty'] = 1;
                  $stockdata[$key2]['expiry'] = $a_inv[$i]['expiry'];
                  $stockdata[$key2]['loc'] = $a_inv[$i]['loc'];

                  $stockdata[$key2]['isamt'] = str_replace(',', '',0.00);
                  $stockdata[$key2]['iss'] = str_replace(',', '',1);
                  $stockdata[$key2]['amt'] = str_replace(',', '',1);
                  $stockdata[$key2]['qa'] = 1;
                  $stockdata[$key2]['ext'] = str_replace(',', '',0.00);
                  $stockdata[$key2]['factor'] = 1;
                  $stockdata[$key2]['disc'] = '';
                  break; //exits loop
                }else{
                  $currentqty = $value['isqty'];
                  $stockdata[$key2]['itemid'] = $value['itemid'];
                  $stockdata[$key2]['barcode'] = $value['barcode'];
                  $stockdata[$key2]['itemname'] = $value['itemname'];
                  $stockdata[$key2]['uom'] = $value['uom'];
                  $stockdata[$key2]['rem'] = $value['rem'];
                  $stockdata[$key2]['ref'] = $value['ref'];

                  $stockdata[$key2]['isqty'] = floatval($a_inv[$i]['bal']);
                  $stockdata[$key2]['expiry'] = $a_inv[$i]['expiry'];
                  $stockdata[$key2]['loc'] = $a_inv[$i]['loc'];

                  $stockdata[$key2]['isamt'] = str_replace(',', '',0.00);
                  $stockdata[$key2]['iss'] = str_replace(',', '',1);
                  $stockdata[$key2]['amt'] = str_replace(',', '',1);
                  $stockdata[$key2]['qa'] = 1;
                  $stockdata[$key2]['ext'] = str_replace(',', '',0.00);
                  $stockdata[$key2]['factor'] = 1;
                  $stockdata[$key2]['disc'] = '';

                  $value['isqty'] =  floatval(1 * $value['factor']) - floatval($a_inv[$i]['bal']);  
                  $key2 += 1;
                }//end if
              }//end for loop
            }else{
              $stockdata[$key2]['itemid'] = $value['itemid'];
              $stockdata[$key2]['barcode'] = $value['barcode'];
              $stockdata[$key2]['itemname'] = $value['itemname'];
              $stockdata[$key2]['uom'] = $value['uom'];
              $stockdata[$key2]['rem'] = $value['rem'];
              $stockdata[$key2]['ref'] = $value['ref'];

              $stockdata[$key2]['isqty'] = 0;
              $stockdata[$key2]['expiry'] = '';
              $stockdata[$key2]['loc'] = '';

              $stockdata[$key2]['isamt'] = str_replace(',', '',0.00);
              $stockdata[$key2]['iss'] = str_replace(',', '',1);
              $stockdata[$key2]['amt'] = str_replace(',', '',1);
              $stockdata[$key2]['qa'] = 0;
              $stockdata[$key2]['ext'] = str_replace(',', '',0.00);
              $stockdata[$key2]['factor'] = 1;
              $stockdata[$key2]['disc'] = '';
            }//end if
            $key2 += 1;
          }//end if

          foreach ($stockdata as $key => $value) {
            foreach ($value as $key2 => $value2) {
              $params2[$key2] = $value2;
              $params2['whcode'] = $params['wh'];
            }//end for each

            $last_line = Lastock::getLastLine('TS',$return1['trno'])+1;
            Yii::$app->automator->automateStockGeneration('TS',$return1['trno'],$last_line,$params2);    
          }//emd for each

          $generatestatus = true;
        }//end ! empty
      }else{
        $generatestatus = false;
      }//end if

      $qrygetter = "select docno from cntnum where trno = " . $return1['trno'];
      $docno = Yii::$app->sbccommon->datareader($qrygetter);

      if($generatestatus){
        $qryupdater1 = "update hjbhead as head set head.equipreleasenum = " . $return1['trno'] . " where trno =" .$q;
        Yii::$app->sbccommon->execqry($qryupdater1);

        Log::writelog('JB', $q, 'Equipment Release #','Generated Equipment Release # ['.$docno.']',Yii::$app->session['loggeduser']['username']);
      }//end if

      echo json_encode(['status'=>$generatestatus,'trno'=>$return1['trno'],'docno'=>$docno]);
    }//end fn

    function actionUpdatebreakdown(){
      try {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $errors = 0;
      $qry1 = "update hjbhead as head set breakdownreport = '".$params['body']."' where trno = " . $params['q'];
      $qry2 = "update jbhead as head set breakdownreport = '".$params['body']."' where trno = " . $params['q'];

      $status1 = Yii::$app->sbccommon->execqry($qry1);
      $status2 = Yii::$app->sbccommon->execqry($qry2);

      if(!$status2){
        $errors += 1;
      }//end if

      if(!$status1){
        $errors += 1;
      }//end if


      if($errors == 0){
        $msg = "Successfully updated Breakdown Report!";
        $status = 1;
        Log::writelog('JB', $params['q'], 'BREAKDOWN Update',$params['body'],Yii::$app->session['loggeduser']['username']);
      }else{
        $msg = "Updating Breakdown Report failed. Please try again.";
        $status = 0;
      }//end if

      echo json_encode(['status'=>$status,'msg'=>$msg]);

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action
}//end fn


