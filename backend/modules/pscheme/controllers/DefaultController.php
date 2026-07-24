<?php

namespace backend\modules\pscheme\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use yii\base\ErrorException;
//FOR TESTING PURPOSES
use app\models\Item;

class DefaultController extends Controller
{
   public $access = array(
        'view' => 152 ,'edit' => 153,'new' => 154,
        'save' => 155,'change' => 156,'delete' => 157,
        'print' => 158,'lock' => 159,'unlock' => 160,
        'changeamount' => 161,'crlimit'=>162,'post' => 163,'unpost' => 164,
        'clickadditem'=>805,'clickedititem'=>806,'clickdeleteitem'=>807);
    
    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){  
        // var_dump('sdfdsdf');
      //new
      //4
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }


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

    public function actionDocnolookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateDocnolookup($params); 
    }
    public function actionSearchdocno(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        // var_dump($params);
        $return=Yii::$app->sbccontroller->sbcSearchdocno($this,$params); 
        // var_dump($return);
         // return 0;
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
            echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        }                                       
    }//END SEARCH DOCNO


//FOR BUTTON FUNCTIONS ###################################################################################

    //FOR LOADING DATA FROM NAV BUTTONS
    // public function actionNavbuttons(){
    //     Yii::$app->backend->AjaxVerification($this); 
    //     $params = $_GET;
    //     $return=Yii::$app->sbccontroller->sbcNavbuttons($this,$params);                
    //     if($return['verifyuser']==1){
    //        return $this->redirect(Url::to(['/admin/default/login']));
    //     }elseif($return['verifyaccess']==1){
    //        return $this->redirect(Url::to(['/admin/default/401']));
    //     }else{
    //       echo json_encode(array('moduledata' => $return['data']));
    //     }
    // }//END ACTION NAVBUTTONS


    public function actionNewdocument(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcNewdocument($this,$params);

        // var_dump($return);

        // return 0;                
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
      try {
        
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavehead($this,$params);  
        // var_dump($return);
        // return 0;
        if($return['verifyuser']==1)
        {
           return $this->redirect(Url::to(['/admin/default/login']));
        }
        elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }
        else
        {
          // var_dump($return['']);
          // return 0;
          echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
          'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted']));
        }                               
      } 
      catch (ErrorException $e) {
          echo $e;
      }
    }

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


    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);

        $params = [
            'sql' => $sql,
            'tableid' => 'psstockview',
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
                    'name' => 'isqty',
                    'editable' => true,
                    'default' => '0.00',
                    'label' => 'Qty',
                    'type' => 'text',
                    'class' => 'col-quantity stocktxt txtcompute txtisqty'
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
                    'name' => 'itemname',
                    'editable' => true,
                    'type' => 'text',
                    'width' => '250px',
                    'class'=>'col-description stocktxt',
                ],[
                    'name' => 'isamt',
                    'editable' => true,
                    'default' => '0.00',
                    'label' => 'Price',
                    'type' => 'text',
                    'class' => 'col-currency txtcompute stocktxt txtisamt'
                ],[
                    'name' => 'disc',
                    'editable' => true,
                    'default' => '',
                    'label' => 'Disc',
                    'type' => 'text',
                    'class' => 'col-min stocktxt txtcompute txtisdisc'
                ],[
                    'name' => 'ext',
                    'label' => 'Total',
                    'editable' => true,
                    'readonly' => true,
                    'class' => 'col-currency stocktxt txtext',
                    'type' => 'text',
                    'width' => '150px;'
                ],[
                    'name' => 'qa',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '0',
                    'label' => 'Pending',
                    'type' => 'text',
                    'class' => 'col-min stocktxt txtqa'
                ],[
                    'name' => 'whcode',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '0.00',
                    'label' => 'WH',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'warehouse',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns whlookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'loc',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '',
                    'label' => 'Location',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'location',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns loclookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'expiry',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '1900-01-01',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'expiry',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns expirylookupstock',
                                      'lookuptxtclass'=>'minitxtcombo'],
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
                    'name' => 'iss',
                    'hidden' => true,
                    'class' => 'txtiss txthidden',
                    'default'=>'0.00',
                ],[
                    'name' => 'amt',
                    'hidden' => true,
                    'class' => 'txtamt txthidden',
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
                    'class' => 'showbalance gvbtns btn btn-social-icon btn-github'
                ],
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
      }//end function

    

//FOR SEARCHING FUNCTIONS ###################################################################################
    //THIS FUNCTION IS USED WHEN DIRECTLY LOOKING FOR DOCNO [WITHOUT THE USE OF LOOKUP BUTTON]
   


   
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
  

   // public function actionPost(){
   //     Yii::$app->backend->AjaxVerification($this);
   //      $params = $_GET;
   //      $return=Yii::$app->sbccontroller->sbcPost($this,$params);  
   //      if($return['verifyuser']==1){
   //         return $this->redirect(Url::to(['/admin/default/login']));
   //      }elseif($return['verifyaccess']==1){
   //         return $this->redirect(Url::to(['/admin/default/401']));
   //      }else{
   //          switch (Yii::$app->systemsettings->companyConfig()) {
   //              case 'SOUTHCENTRAL':
   //                echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'isapproved'=>$return['isapproved'],
   //                  'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
   //              break;

   //              default:
   //                  echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],
   //                  'islocked'=>$return['islocked'],'status'=>$return['status'],'istransposted'=>$return['istransposted']));
   //              break;
   //          }//end swtich
   //      }                                       
   // }


   // public function actionUnpost(){
   //      Yii::$app->backend->AjaxVerification($this);
   //      $params = $_GET;
   //      $return=Yii::$app->sbccontroller->sbcUnpost($this,$params);  
   //      if($return['verifyuser']==1){
   //         return $this->redirect(Url::to(['/admin/default/login']));
   //      }elseif($return['verifyaccess']==1){
   //         return $this->redirect(Url::to(['/admin/default/401']));
   //      }else{
   //       echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'status'=>$return['status']));
   //      }                                       
   // }

   // public function actionLockunlock(){
   //      Yii::$app->backend->AjaxVerification($this);
   //      $params = $_GET;
   //      $return=Yii::$app->sbccontroller->sbcLockunlock($this,$params);  
   //      if($return['verifyuser']==1){
   //         return $this->redirect(Url::to(['/admin/default/login']));
   //      }elseif($return['verifyaccess']==1){
   //         return $this->redirect(Url::to(['/admin/default/401']));
   //      }else{
   //       echo json_encode(array('error_msg'=>$return['error_msg'],'isposted' => $return['isposted'],'islocked'=>$return['islocked'],'istransposted'=>$return['istransposted']));
   //      }                                       
   // }//END ACTION LOCK UNLOCK



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

   // public function actionGetterms(){
   //      Yii::$app->backend->AjaxVerification($this);
   //      $return=Yii::$app->sbccontroller->sbcGetterms($this);  
   //      if($return['verifyuser']==1){
   //         return $this->redirect(Url::to(['/admin/default/login']));
   //      }elseif($return['verifyaccess']==1){
   //         return $this->redirect(Url::to(['/admin/default/401']));
   //      }else{
   //         echo json_encode(array('terms'=>$return['data']));
   //      }                                               
   // }//END GET TERMS

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

   // public function actionComparestocklines(){     
   //      Yii::$app->backend->AjaxVerification($this);
   //      $params = $_POST;   
   //      Yii::$app->sbccontroller->sbcComparestocklines($this,$params);          
   //  }//END COMPARE STOCK LINE

    // public function actionQuickadditem(){
    //     Yii::$app->backend->AjaxVerification($this);
    //     $params = $_GET;
    //     $return=Yii::$app->sbccontroller->sbcQuickadditem($this,$params);  
    // }//END ACTION QUICK ADD

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
      }//END FUNCTION
    }//END FUNCTION

    // public function actionVoiditem(){
    //     Yii::$app->backend->AjaxVerification($this);
    //     $params = $_GET;
    //     $return=Yii::$app->sbccontroller->sbcVoidItem($this,$params);  
    //     if($return['verifyuser']==1){
    //        return $this->redirect(Url::to(['/admin/default/login']));
    //     }elseif($return['verifyaccess']==1){
    //        return $this->redirect(Url::to(['/admin/default/401']));
    //     }else{
    //        echo json_encode(array('voiding'=>$return['data']));
    //     }//end function
    // }//end function

    // public function actionGetuser(){
    //     $data = Yii::$app->backend->getUsers(true); 
    //     echo json_encode(array('uzer'=>$data));
    // }//end action
    

   

    // public function actionVoidmultipleitems(){
    //   try {
    //     Yii::$app->backend->AjaxVerification($this);
    //     $params = $_GET;
    //     $doc = $this->module->id;

    //       foreach ($params['params'] as $key => $value) {
    //         $trno = $params['params'][$key]['trno'];
    //         $line = $params['params'][$key]['line'];

    //         $voiding = Yii::$app->backend->voidItem($doc,$trno,$line,1,'sbc');
    //         $return[$key] = $voiding;
    //       }//end function
    //     echo json_encode(array('return'=>$return));
    //   } catch (ErrorException $e) {
    //      echo $e;
    //   } 
    // }//end action void multiple

    // public function actionGetflaginfo(){
    //   try {
    //       Yii::$app->backend->AjaxVerification($this);
    //       $params = $_GET;
    //       $doc = $this->module->id;
    //       $data = Yii::$app->backend->checkForFlaginformation($params['flagtype'],$params['q'],$doc);

    //       if(!empty($data)){
    //         $hasfinfo = true;
    //       }else{
    //         $hasfinfo = false;
    //       }//end if

    //       echo json_encode(['hasinfo'=>$hasfinfo,'flaginfo'=>$data]);
    //   } catch (ErrorException $e) {
    //     echo $e;
    //   }
    // }//end function

   

    

    public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        // var_dump($params['controller']);
        // return 0;
        return Yii::$app->automator->automateClientlookup($params);
      }


      public function actionAgentlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        // var_dump($params);
        // return 0;
        return Yii::$app->automator->automateAgentlookup($params);
      }

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

       public function actionItemlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      // var_dump($params);
      // return 0;
      return Yii::$app->automator->automateItemlookupGV($params);
    }


    public function actionGetlocation(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['barcode'=>$_POST['x']];
        return Yii::$app->automator->automateLocationlookupGV($params);
    }//end get location



//      public function actionRetrieveavailvoid(){
//         Yii::$app->backend->AjaxVerification($this);
//         $params = $_POST;
//         $params['controller'] = $this;
//         return Yii::$app->automator->automateMultivoid($params);
//     }//end if action retrieve  


    public function actionLoaduoms() {
      $barcode = $_POST['x'];
      $itemid = Yii::$app->backend->requestItemid($barcode);
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['itemid'] = $itemid;
      $params['controller'] = $this;
      return Yii::$app->automator->automateUomlookup($params);
    }

}



