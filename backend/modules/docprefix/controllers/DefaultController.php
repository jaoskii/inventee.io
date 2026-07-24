<?php

namespace backend\modules\docprefix\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;
use app\models\Profile;

use yii\web\Response;
class DefaultController extends Controller{

    public $access = array(
        'view' => 599);
    
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $profile = new Profile();
            $data =  $profile->openPrefAll($this,$this->access['view']);  
            return $this->render('index',array('prefixdata'=>$data,'moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }
    }

    public function actionEditdocprefix(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data = Yii::$app->sbccommon->opentable("select line,doc,psection,pvalue from profile  where doc = 'SED' and line ='$line'");
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['prefixdata' => $data];
        //echo json_encode(array('prefixdata' => $data));
    }

    public function actionUpdateprefix(){  
        $line = $_GET['line'];
        $pvalue = $_GET['pvalue'];
        $moduleid = $this->module->id;
        $beforeupdate = Yii::$app->sbccommon->opentable("select line,doc,psection,pvalue from profile  where doc = 'SED' and line ='$line'");
    	$status = Yii::$app->sbccommon->execqry("update profile set pvalue = '$pvalue'  where doc = 'SED' and line = '$line'");
        if($status){
            Yii::$app->backend->setDocPrefixLog('UPDATED PREFIX for ['.$beforeupdate[0]['psection'].'] from ['.$beforeupdate[0]['pvalue'].'] to ['.$pvalue.']');
        }
    	$profile = new Profile();
        $data =  $profile->openPref($line);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['prefixdata' => $data];
        //echo json_encode(array('prefixdata' => $data));
    }

    public function actionDocprefixlogs(){
        Yii::$app->backend->AjaxVerification($this);
        $logs = Yii::$app->backend->getdocPrefixLogs();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['logs'=>$logs];
        //echo json_encode(array('logs'=>$logs));
    }

    public function actionLoaddocprefix() {
        if (Yii::$app->session['loggeduser']['access'][$this->access['view']] == 1) {
            $sql = "select 
                            line,
                            doc,
                            case(psection)
                                when 'PO' then 'PURCHASE ORDER'
                                when 'RR' then 'RECEIVING REPORT'
                                when 'DM' then 'PURCHASE RETURN'
                                when 'CV' then 'CASH/CHECK VOUCHER'
                                when 'PV' then 'PAYABLE VOUCHER'
                                when 'AP' then 'AP SETUP'
                                when 'SO' then 'SALES ORDER'
                                when 'SJ' then 'SALES JOURNAL'
                                when 'CM' then 'SALES RETURN'
                                when 'CR' then 'CASH RECEIPT'
                                when 'AR' then 'AR SETUP'
                                when 'IS' then 'INVENTORY SETUP'
                                when 'AJ' then 'INVENTORY ADJUSTMENT'
                                when 'TS' then 'TRANSFER SLIP'
                                when 'PC' then 'PHYSICAL COUNT'
                                when 'GJ' then 'GENERAL JOURNAL'
                                when 'DS' then 'DEPOSIT SLIP'
                                when 'CA' then 'RECEIVING CONSIGNMENT'
                                when 'CL' then 'CUSTOMER'
                                when 'SL' then 'SUPPLIER'
                                when 'WH' then 'WAREHOUSE'
                                when 'AG' then 'AGENT'
                                when 'PR' then 'PURCHASE REQUISITION'
                                when 'PI' then 'PRODUTION INSTRUCTION'
                                when 'PD' then 'PRODUTION ORDER'
                                when 'PK' then 'PRODUCTION COMPLETION'
                                when 'KR' then 'COUNTER RECEIPT'
                                else ''
                            end as psection,
                            pvalue from profile  where doc = 'SED'";
            $params = [
                'sql' => $sql,
                'tableid' => 'docpreftbl',
                'key' => 'line',
                'txtclass' => 'docpreftext',
                'template'=> ['checkbox','buttons','columns'],
                'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
                'column' => [
                    [
                        'name' => 'psection',
                        'label' => 'Module',
                        'editable' => true,
                        'readonly' => true,
                        'type' => 'text',
                        'class'=>'col-codes docpreftext',
                    ],[
                        'name' => 'pvalue',
                        'label' => 'Prefix',
                        'editable' => true,
                        'type' => 'text',
                        'class' => 'col-codes docpreftext'
                    ],[
                        'name' => 'line',
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
                        'class' => 'savedocpref gvbtns btn btn-social-icon btn-bitbucket',
                    ]
                ]
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }
    }

    public function actionSavedocpref() {
        $params = $_GET;
        $beforeupdate = Yii::$app->sbccommon->opentable("select line,doc,psection,pvalue from profile  where doc = 'SED' and line ='{$params['line']}'");
        $status = Yii::$app->sbccommon->execqry("update profile set pvalue = '{$params['pvalue']}' where doc = 'SED' and line = '{$params['line']}'");
        if($status){
            Yii::$app->backend->setDocPrefixLog('UPDATED PREFIX for ['.$beforeupdate[0]['psection'].'] from ['.$beforeupdate[0]['pvalue'].'] to ['.$params['pvalue'].']');
        }
    }
}
