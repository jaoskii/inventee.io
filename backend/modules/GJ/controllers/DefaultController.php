<?php

namespace backend\modules\GJ\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use yii\web\Response;
class DefaultController extends Controller{

	public $access = array(
        'view' => 344 ,'edit' => 345,'new' => 346,
        'save' => 347,'change' => 348,'delete' => 349,
        'print' => 350,'lock' => 351,'unlock' => 352,
        'post' => 353,'unpost' => 354,
        'clickadditem'=>802,'clickedititem'=>803,'clickdeleteitem'=>804);

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
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
                        'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted']];
            /* echo json_encode(array('trno' => $return['data']['trno'],'docno'=>$return['data']['docno'],
                        'msg'=>$return['data']['msg'],'head'=>$return['data']['head'],'istransposted'=>$return['istransposted'])); */
          }              
      } catch (ErrorException $e) {
        echo $e;
      }
    }


    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
        $params = [
            'sql' => $sql,
            'tableid' => 'gjstockview',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'acno',
                    'editable' => true,
                    'readonly' => true,
                    'label' => 'Account #',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'contra',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns stockcontralookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                  'name' => 'acnoname',
                  'label' => 'Account Title',
                  'editable' => true,
                  'readonly' => true,
                  'type' => 'text',
                  'class' => 'col-description stocktxt'
                ],[
                  'name' => 'db',
                  'label' => 'Local Debit',
                  'editable' => true,
                  'type' => 'text',
                  'class' => 'col-currency stocktxt'
                ],[
                  'name' => 'cr',
                  'label' => 'Local Credit',
                  'editable' => true,
                  'type' => 'text',
                  'class' => 'col-currency stocktxt'
                ],[
                  'name' => 'checkno',
                  'label' => 'Check #',
                  'editable' => true,
                  'readonly' => true,
                  'type' => 'text',
                  'class' => 'col-codes stocktxt'
                ],[
                  'name' => 'postdate',
                  'label' => 'Date',
                  'editable' => true,
                  'readonly' => true,
                  'type' => 'text',
                  'class'=>'col-min stocktxt'
                ],[
                  'name' => 'ref',
                  'editable' => true,
                  'readonly' => true,
                  'label' => 'Reference',
                  'type' => 'text',
                  'class' => 'col-codes stocktxt'
                ],[
                  'name' => 'rem',
                  'editable' => true,
                  'label' => 'Notes',
                  'type' => 'text',
                  'class' => 'col-description stocktxt'
                ],[
                  'name' => 'client',
                  'label' => 'Custmr/Supplr',
                  'editable' => true,
                  'readonly' => true,
                  'type' => 'text',
                  'class' => 'col-codes stocktxt'
                ],[
                  'name' => 'line',
                  'hidden' => true,
                  'default' => '0',
                  'class' => 'txthidden stocktxt'
                ],[
                  'name' => 'refx',
                  'hidden' => true,
                  'default' => '0',
                  'class' => 'txthidden stocktxt'
                ],[
                  'name' => 'linex',
                  'hidden' => true,
                  'default' => '0',
                  'class' => 'txthidden stocktxt'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stocksavebtn btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn btn btn-social-icon btn-google'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
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
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data'],'istransposted'=>$return['istransposted']];
            //echo json_encode(array('moduledata' => $return['data'],'istransposted'=>$return['istransposted']));
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
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => '','access'=> 0];
            //echo json_encode(array('moduledata' => '','access'=> 0));
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['moduledata' => $return['data'],'access'=> 1];
            //echo json_encode(array('moduledata' => $return['data'],'access'=> 1));
        }                                       
    }//END SEARCH DOCNO


    //USED BY SEARCHING OF DOCNO ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionDocnolookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateDocnolookup($params);
    }

    public function actionSupplierlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierlookup($params);
    }

    public function actionLoadterms() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateTermslookup($params);
    }

    //USED BY SEARCHING OF CUSTOMER ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionDetailclientlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;        
        $return=Yii::$app->sbccontroller->sbcDetailclientlookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['searchclient' => $return['data']];
            //echo json_encode(array('searchclient' => $return['data']));
        }                                       
    }


    public function actionClientlookupsearch() {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateClientlookup($params);
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
   }//END ACTION CANCEL

 

   public function actionSavedetail(){
    Yii::$app->backend->AjaxVerification($this);    
        $params = $_POST;
        $return=Yii::$app->sbccontroller->sbcSavedetail($this,$params);  
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
            return ['detailline' => $return['data']];
            //echo json_encode(array('detailline' => $return['data']));
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
            //Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;
            //echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal']));
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
   }//END ACTION LOCK UNLOCK


    public function actionLog(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      return Yii::$app->automator->automateLog($this,$params);
    }


   public function actionGetterms(){
        Yii::$app->backend->AjaxVerification($this);
        $return=Yii::$app->sbccontroller->sbcGetterms($this);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['terms'=>$return['data']];
            //echo json_encode(array('terms'=>$return['data']));
        }                                               
   }//END GET TERMS


   public function actionComparedetaillines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;   
        Yii::$app->sbccontroller->sbcComparedetaillines($this,$params);          
    }//END COMPARE STOCK LINE


    public function actionContrasearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateContralookup($params);
    }



//########################################################## GJ UPDATE JAOSKI

    public function actionLoadclientunpaid(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateClientunpaid($params);
    }//END ACTION LOAD CLIENT UNPAID

    public function actionRetrieveunpaid(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcRetrieveunpaid($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['primarydata' => $return['unpaid']];
            //echo json_encode(array('primarydata' => $return['unpaid']));
        }              
    }//END action

//########################################################## GJ UPDATE JAOSKI



public function actionLoadchecks(){
  Yii::$app->backend->AjaxVerification($this);
  $params = $_POST;
  $params['controller'] = $this;
  return Yii::$app->automator->automateCheckslookup($params);
}//end action


  public function actionRetrievechecks(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return=Yii::$app->sbccontroller->sbcRetrievechecks($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           Yii::$app->response->format = Response::FORMAT_JSON;
            return ['primarydata' => $return['checksdata']];
            //echo json_encode(array('primarydata' => $return['checksdata']));
        }              
    }//END action

  public function actionGetcostcenters(){
    Yii::$app->backend->AjaxVerification($this);
    $params['controller'] = $this;
    return Yii::$app->automator->automateCostcenter($params);
  }
    
  public function actionGenerateendingentries(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      $return = Yii::$app->automator->automateEndingEntries($this->module->id,$params['d'],$params['q']);
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$return['status'],'msg'=>$return['msg'],'entries'=>$return['data']];
      //echo json_encode(['status'=>$return['status'],'msg'=>$return['msg'],'entries'=>$return['data']]);
  } //end funct   
}//END DEFAULT CONTROLLER
