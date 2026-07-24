<?php

namespace backend\modules\tpshipping\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{
//TODO: MAKE THIS CONTROLLER ACCESS AVAIALABLE ON JAVASCRIPT TO BE USED ON EVENTS
//THESE ACCESS ARRAY IS USED TO DETERMINE ACCESS INDEX ON ATTRIBUTES
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
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }//end if


    public function actionIndex(){
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionDocnolookupsearch(){
      
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      // var_dump($params);
      // return 0;
      return Yii::$app->automator->automateDocnolookup($params); 
    }

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

    public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $trno = Yii::$app->backend->sanitize($_POST['x'],'DEFAULT');
        $sql = Yii::$app->tblgenerator->getStockViewQuery($this->module->id,$trno);

        if($_POST['date1']!='' && $_POST['date2']!=''){
            $sql=$sql.' where cntnum.postdate between "'.$_POST['date1'].'" and "'.$_POST['date2'].'"';
        }

        $params = [
            'sql' => $sql,
            'tableid' => 'invoicestockview',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                   'name' => 'docno',
                    'editable' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'client',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '0.00',
                    'label' => 'Customer Code',
                    'type' => 'text',
                    'class' => 'col-quantity stocktxt txtcompute txtcustomer_code'
               
                ],[
                    'name' => 'clientname',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '0.00',
                    'label' => 'Customer Name',
                    'type' => 'text',
                    'class' => 'col-currency txtcompute stocktxt txtcustomer_name'
                ],[
                    'name' => 'agent',
                    'editable' => true,
                    'readonly' => true,
                    'default' => '',
                    'label' => 'Agent',
                    'type' => 'text',
                    'class' => 'col-min stocktxt txtcompute txtagent'
                
                ],[
                    'name' => 'shipfee',
                    'editable' => true,
                   
                    'default' => '0',
                    'label' => 'Shipping Fee',
                    'type' => 'text',
                    'class' => 'col-min stocktxt txtshipfee'
                ],[
                    'name' => 'cutoff',
                    'editable' => true,
                    'default' => '',
                    'label' => 'Cutoff Date',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt txtcutoff'
                ],[
                   
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default' => 0
                
                ],[
                    'name' => 'trno',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => 0
                ]
            ],
            
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'invoicesavebtn gvbtns btn btn-social-icon btn-bitbucket',
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'stockdeletebtn gvbtns btn btn-social-icon btn-google',
                ],
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
      }//end function


       public function actionStockdelete()
       {
          Yii::$app->backend->AjaxVerification($this);
          $params = $_GET;
          $return=Yii::$app->sbccontroller->sbcStockdelete($this,$params);  
          
          if($return['verifyuser']==1)
          {
            return $this->redirect(Url::to(['/admin/default/login']));
          }
          elseif($return['verifyaccess']==1)
          {
            return $this->redirect(Url::to(['/admin/default/401']));
          }
          else
          {
            echo json_encode(array('itemcount' => $return['itemcount'],'grandtotal'=>$return['grandtotal'],'istransposted'=>$return['istransposted']));
          }                                       
        }//END DELETE



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

    public function actionPulldata(){
     try {
       
      Yii::$app->backend->AjaxVerification($this);

      $type = $_GET['type'];
      $trno = $_GET['trno'];
     
      $primarydata = Yii::$app->backend->pullHeaderdata($trno);
      
      $moduledata['line']=0;
      $moduledata['trno']=$primarydata[0]['trno'];

      $moduledata['docno']=$primarydata[0]['docno'];
      $moduledata['client']=$primarydata[0]['client'];
      $moduledata['clientname']=$primarydata[0]['clientname'];
      $moduledata['shipfee']=$primarydata[0]['shipfee'];
      $moduledata['agent']=$primarydata[0]['agent'];

      $returndata = Yii::$app->webprocess->savingstock($this,$this->access['save'],$moduledata);

      $return['stockline']['gvrow-'.$returndata['line']] = $returndata;
      $return['line'] = $returndata['line']; 
     
      echo json_encode($return);

     
      }catch (ErrorException $e) {
          echo json_encode(array('sbcerror' => 1,'stacktrace'=>$e));
      }//end try
  
   
   }//END PULL DATA   

}//end controller
