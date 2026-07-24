<?php

namespace backend\modules\quickcollect\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{
	public $access = array('view' => 3152);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){
    	$this->layout = "@app/views/layouts/backend/main";
      $moduleid = $this->module->id;
      Yii::$app->view->params['moduleid'] = $moduleid;
      return $this->render('index',['moduleid'=>$moduleid]);
    }

    public function actionBuildstockview(){
    	try {
        Yii::$app->backend->AjaxVerification($this); 
        $sql = 'select acno,acnoname,db,cr,checkno,postdate,ref,rem,client,refx,linex,line,pdcline from ladetail where trno = 0';
        $params = [
            'sql' => $sql,
            'tableid' => 'crstockview',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => true,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
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
                    'name' => 'checkno',
                    'editable' => true,
                    'label' => 'Check #',
                    'type' => 'text',
                    'class' => 'col-codes aimslabel stocktxt'
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

    		
    	} catch (ErrorException $e) {
    		echo $e;
    	}
      }//end function

        public function actionClientlookupsearch() {
            Yii::$app->backend->AjaxVerification($this);
            $params = $_POST;
            $params['controller'] = $this;
            return Yii::$app->automator->automateClientlookup($params);
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
          echo json_encode(array('clientdata' => $return['data']));
        }               
    }

    public function actionContrasearch(){
       Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);                                   
    }//END CONTRA

    public function actionLoadcolltypes() {
      $qry = "select line,acno,acnoname from colltype_masterfile";
      $params = [
        'sql' => $qry,
        'tableid' => 'colltypetbl',
        'key' => 'line',
        'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
        'txtclass' => 'colltypetbltxt',
        'column' => [[
            'name' => 'acnoname',
            'label' => 'Account Name',
            'class' => 'aimslabel col-description'
          ]
        ],
        'buttons' => [
          [
            'name' => '',
            'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-plus"></i>',
            'style' => 'width:18px;height:18px;margin-top:-2px;margin-right:2px;',
            'class' => 'colltypeselect btn btn-social-icon btn-bitbucket',
            'attributes' => [['name'=>'cacno','value'=>'acno'],['name'=>'cacnoname','value'=>'acnoname']]
          ]
        ]
      ];
      return Yii::$app->tblgenerator->generateGrid($params);
    }

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
           echo json_encode(array('primarydata' => $return['unpaid']));
        }              
    }//END action
}//end controller