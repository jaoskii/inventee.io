<?php

namespace backend\modules\PV\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\Ladetail;
use app\base\ErrorException;

use yii\web\Response;

class DefaultController extends Controller{

  public $access = array(
        'view' => 371 ,'edit' => 372,'new' => 373,
        'save' => 374,'change' => 375,'delete' => 376,
        'print' => 377,'lock' => 378,'unlock' => 379,
        'post' => 380,'unpost' => 381,
        'clickadditem'=>802,'clickedititem'=>803,'clickdeleteitem'=>804);

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

 //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $return=Yii::$app->sbccontroller->sbcindex($this);        
        //var_dump($return['moduledata']['body']);
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           return $this->render('index',array('moduledata' => $return['moduledata'],'moduleid'=>$return['moduleid']));        
        }
    }//END ACTION INDEX

    public function actionGetdocreference(){
      Yii::$app->backend->AjaxVerification($this);
      $trno = $_GET['trno'];
      $doc = $this->module->id;
      $data = Yii::$app->backend->getDocumentreference($trno,$doc);
      if(empty($data)){ 
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ['data' => ""];
          //echo json_encode(array('data' => ""));  
      }else{
         Yii::$app->response->format = Response::FORMAT_JSON;
        return ['data' => $data];
        //echo json_encode(array('data' => $data));  
      }//END FUNCTION
    }//END FUNCTION
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


    public function actionContrasearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);
    }//END CONTRA

    public function actionDocnolookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateDocnolookup($params); 
    }

//USED BY SEARCHING OF CUSTOMER ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionSupplierlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierlookup($params);
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
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;
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

    public function actionGetcostcenters(){
      Yii::$app->backend->AjaxVerification($this);
      $params['controller'] = $this;
      return Yii::$app->automator->automateCostcenter($params);
    }//end function 


    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);
        $params = [
            'sql' => $sql,
            'tableid' => 'pvstockview',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'isvat', // this is for header label default
                    'for' => 'isvat', // this is "for" to connect checkbox to what hidden textbox it is connected
                    'label'=>'VAT?', // this is alternative label for header
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkvat'
                ],[
                    'name' => 'isvat',
                    'hidden' => true,
                    'class' => 'txtvat txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'isewt',
                    'for' => 'isewt',
                    'label'=>'EWT?',
                    'editable' => true,
                    'type' => 'checkbox',
                    'class' => 'col-min chkewt'
                ],[
                    'name' => 'isewt',
                    'hidden' => true,
                    'class' => 'txtewt txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'ewtcode',
                    'editable' => true,
                    'label' => 'EWT Code',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'ewt',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns detailewtlookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'ewtrate',
                    'readonly' => true,
                     'editable' => true,
                    'label' => 'EWT Rate (%)',
                    'type' => 'text',
                    'class' => 'col-codes aimslabel stocktxt'
                ],[
                    'name' => 'acno',
                    'editable' => true,
                    'label' => 'Account #',
                    'type' => 'lookup',
                    'lookupbutton' => ['autocall'=>'contra',
                                      'colw'=>'col-codes',
                                      'lookupclass'=>'gvbtns stockcontralookup',
                                      'lookuptxtclass'=>'minitxtcombo'],
                ],[
                    'name' => 'acnoname',
                    'editable' => true,
                    'label' => 'Account Title',
                    'type' => 'text',
                    'class' => 'col-description aimslabel stocktxt'
                ],[
                    'name' => 'db',
                    'editable' => true,
                    'default' => '0.00',
                    'label' => 'Local Debit',
                    'type' => 'text',
                    'class' => 'col-currency aimslabel stocktxt'
                ],[
                    'name' => 'cr',
                    'editable' => true,
                    'default' => '0.00',
                    'label' => 'Local Credit',
                    'type' => 'text',
                    'class' => 'col-currency aimslabel stocktxt'
                ],[
                    'name' => 'postdate',
                    'editable' => true,
                    'label' => 'Date',
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-min aimslabel stocktxt',
                ],[
                    'name' => 'ref',
                    'readonly' => true,
                     'editable' => true,
                    'label' => 'Reference',
                    'type' => 'text',
                    'class' => 'col-codes aimslabel stocktxt'
                ],[
                    'name' => 'rem',
                    'editable' => true,
                    'label' => 'Notes',
                    'type' => 'text',
                    'class' => 'col-description aimslabel stocktxt'
                ],[
                    'name' => 'client',
                    'readonly' => true,
                    'editable' => true,
                    'label' => 'Custmr/Supplr',
                    'type' => 'text',
                    'class' => 'col-codes aimslabel stocktxt'
                ],[
                    'name' => 'checkno',
                    'hidden' => true,
                    'label' => 'Check #',
                    'class' => 'txthidden',
                    'default'=>''
                ],[
                    'name' => 'refx',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'linex',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],[
                    'name' => 'pdcline',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],

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
                ],
                
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
      }//end function


    public function actionGetewts(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateEWTLookupGV();
    }//end get location

    public function actionGenerateewt(){
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_GET;
      $ewtgrandtotal = 0;
      $vatgrandtotal = 0;
      $wt1details = Yii::$app->sbccommon->opentable("select acno,acnoname from coa where coa.alias = 'WT1'");
      $tx1details = Yii::$app->sbccommon->opentable("select acno,acnoname from coa where coa.alias = 'TX1'");


      if(empty($wt1details) || empty($tx1details)){
        $status = false;
        $msg = "Failed to find required Accounts. Please add Accounts on COA with (TX1 and WT1) aliases";
      }else{
        $qrytransdetails = "select db,cr,ewtcode,ewtrate,isewt,isvat from ladetail where trno = " . $params['q'];
        $transdetails = Yii::$app->sbccommon->opentable($qrytransdetails);

        if(!empty($transdetails)){
            foreach ($transdetails as $key => $value) {
              //FOR EWT
              if($value['isewt'] == 1){
                $ewtrateval = floatval($value['ewtrate']) / 100;
                if($value['db'] == 0){ 
                  //FOR CR
                  if($value['cr'] < 0){
                    $db = $value['cr'];
                  }else{
                    $db = floatval($value['cr']) * -1;
                  }//end if

                  $ewtamt = $db * $ewtrateval;
                  $ewtgrandtotal = $ewtgrandtotal + $ewtamt;
                }else{
                  //FOR DB
                  if($value['db'] < 0){
                    $db = floatval($value['db']) * -1;
                  }else{
                    $db = $value['db'];
                  }//end if

                  $ewtamt = $db * $ewtrateval;
                  $ewtgrandtotal = $ewtgrandtotal + $ewtamt;
                } //end if  
              }//end if

              //FOR VAT COMPUTATION
              if($value['isvat'] == 1){
                $vatrateval = .12;
                if($value['db'] == 0){ 
                  //FOR CR
                  if($value['cr'] < 0){
                    $db = $value['cr'];
                  }else{
                    $db = floatval($value['cr']) * -1;
                  }//end if

                  $vatamt = $db * $vatrateval;
                  $vatgrandtotal = $vatgrandtotal + $vatamt;
                }else{
                  //FOR DB
                  if($value['db'] < 0){
                    $db = floatval($value['db']) * -1;
                  }else{
                    $db = $value['db'];
                  }//end if

                  $vatamt = $db * $vatrateval;
                  $vatgrandtotal = $vatgrandtotal + $vatamt;
                } //end if  
              }//end if

            }//end for each
          }else{
            $status = false;
            $msg = 'Cannot find entries with EWT Tagging / Vat Tagging';
          }//end if
      }//end if

      $qryremove_ewt_vat = "delete from ladetail where acno in (select acno from coa where coa.alias in ('TX1','WT1'))";
      Yii::$app->sbccommon->execqry($qryremove_ewt_vat);

      $head_details = Yii::$app->sbccommon->opentable("select left(dateid,10) as dateid,client from lahead where trno= ".$params['q']);
      if($ewtgrandtotal != 0){
        $line=Ladetail::getLastLine($params['q'],'PV') + 1;
        $insertewt = "insert into ladetail (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,checkno,rem,ref,encodedby,project,isewt,isvat,ewtcode,ewtrate)
                      values ('".$params['q']."','".$line."','\\".$wt1details[0]['acno']."','".$wt1details[0]['acnoname']."','".$head_details[0]['client']."',
                      round(0,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                      round(".$ewtgrandtotal.",".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                      '0','0','0','0','".$head_details[0]['dateid']."','','AUTO GENERATED (EWT / VAT Entries)','','".Yii::$app->session['loggeduser']['username']."','',
                      '0','0','','')";
        $insert1 = Yii::$app->sbccommon->execqry($insertewt);


        $headaccnt[0]['dateid'] = Yii::$app->sbccommon->datareader("select left(dateid,10) as dateid from lahead as head where head.trno =".$params['q']);
        $headaccnt2 = Yii::$app->sbccommon->opentable("select acno as contra,acnoname as clientname from coa where alias = 'AP2'");
        $headaccnt[0]['contra'] = $headaccnt2[0]['contra'];
        $headaccnt[0]['clientname'] = $headaccnt2[0]['clientname'];

        $deleter = "delete from ladetail where trno = ".$params['q']." and acno = '\\".$headaccnt[0]['contra']."'";

        Yii::$app->sbccommon->execqry($deleter);

        $dbvalqry = "select sum(db-cr) as db from ladetail where trno = ".$params['q'];
        $dbval = Yii::$app->sbccommon->datareader($dbvalqry);

        
        
        $line=Ladetail::getLastLine($params['q'],'PV') + 1;
        
        $autoinsertqry = "insert into ladetail (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,checkno,rem,ref,encodedby,project,isewt,isvat,ewtcode,ewtrate)
        values(".$params['q'].",".$line.",'\\".$headaccnt[0]['contra']."','".$headaccnt[0]['clientname']."','".$head_details[0]['client']."',
        0,".$dbval.",0,0,0,0,'".$headaccnt[0]['dateid']."','','AUTO ENTRY','','AUTO','',0,0,'','')";
        
        Yii::$app->sbccommon->execqry($autoinsertqry);

      }else{
        $insert1 = true;
      }//end if

      if($vatgrandtotal != 0){
        $line=Ladetail::getLastLine($params['q'],'PV') + 1;
        $insertvat = "insert into ladetail (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,checkno,rem,ref,encodedby,project,isewt,isvat,ewtcode,ewtrate)
                      values ('".$params['q']."','".$line."','\\".$tx1details[0]['acno']."','".$tx1details[0]['acnoname']."','".$head_details[0]['client']."',
                      round('".$vatgrandtotal."',".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                      round(0,".Yii::$app->systemsettings->setDecimaldisplay('currency')."),
                      '0','0','0','0','".$head_details[0]['dateid']."','','AUTO GENERATED (EWT / VAT Entries)','','".Yii::$app->session['loggeduser']['username']."','',
                      '0','0','','')";
        $insert2 = Yii::$app->sbccommon->execqry($insertvat);


        $headaccnt[0]['dateid'] = Yii::$app->sbccommon->datareader("select left(dateid,10) as dateid from lahead as head where head.trno =".$params['q']);
        $headaccnt2 = Yii::$app->sbccommon->opentable("select acno as contra,acnoname as clientname from coa where alias = 'AP2'");
        $headaccnt[0]['contra'] = $headaccnt2[0]['contra'];
        $headaccnt[0]['clientname'] = $headaccnt2[0]['clientname'];


        $deleter = "delete from ladetail where trno = ".$params['q']." and acno = '\\".$headaccnt[0]['contra']."'";

        Yii::$app->sbccommon->execqry($deleter);
        
        $dbvalqry = "select sum(db-cr) as db from ladetail where trno = ".$params['q'];
        $dbval = Yii::$app->sbccommon->datareader($dbvalqry);

        
        
        $line=Ladetail::getLastLine($params['q'],'PV') + 1;
        
        $autoinsertqry = "insert into ladetail (trno,line,acno,acnoname,client,db,cr,fdb,fcr,refx,linex,postdate,checkno,rem,ref,encodedby,project,isewt,isvat,ewtcode,ewtrate)
        values(".$params['q'].",".$line.",'\\".$headaccnt[0]['contra']."','".$headaccnt[0]['clientname']."','".$head_details[0]['client']."',
        0,".$dbval.",0,0,0,0,'".$headaccnt[0]['dateid']."','','AUTO ENTRY','','AUTO','',0,0,'','')";
        
        Yii::$app->sbccommon->execqry($autoinsertqry);

      }else{
        $insert2 = true;
      }//end if

      if($insert1 == false || $insert2 == false){
        $msg = "Error occured while generating automated entries. Please try again";
        $status = false;
      }else{
        $msg = "Successfully generated automated entries EWT/VAT. Refreshing Datagrid..";
        $status = true;
      }//end if

      $gettotal = Ladetail::getgrandtotal($params['q'],'pv');
      
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$status,'msg'=>$msg,'totaldb'=>$gettotal[0]['totaldb'],'totalcr'=>$gettotal[0]['totalcr']];
      //echo json_encode(['status'=>$status,'msg'=>$msg,'totaldb'=>$gettotal[0]['totaldb'],'totalcr'=>$gettotal[0]['totalcr']]);
    }//end fn
}//END DEFAULT CONTROLLER

