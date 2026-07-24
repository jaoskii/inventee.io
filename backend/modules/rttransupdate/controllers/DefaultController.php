<?php

namespace app\modules\rttransupdate\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class DefaultController extends Controller{
    
    public $access = array('view' => 4001);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }//end f

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['verified'=>$return];
    }//end f

   /* public function actionIndex(){
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX*/

    public function actionIndex(){
        try {
            $return=Yii::$app->sbccontroller->sbcindex($this);        
            if($return['verifyuser']==1){
                return $this->redirect(Url::to(['/admin/default/login']));
            }elseif($return['verifyaccess']==1){
                return $this->redirect(Url::to(['/admin/default/401']));
            }else{
                return $this->render('index',array('moduleid'=>$return['moduleid']));
            }
        } catch (\Exception $e) {
            echo $e;
        }
    }//END ACTION INDEX


    public function actionGetdocuments(){
        try {
        $params = $_POST;
        $qry = "select * from (
                select head.dateid,head.trno,head.docno,head.clientname,head.vattype,head.yourref,head.ourref from lahead as head
                where head.doc = '".$params['d']."' and 
                (head.docno like '%".$params['x']."%' or head.clientname like '%".$params['x']."%'
                or head.vattype like '%".$params['x']."%' or head.yourref like '%".$params['x']."%')
                UNION ALL
                select head.dateid,head.trno,head.docno,head.clientname,head.vattype,head.yourref,head.ourref from glhead as head
                where head.doc = '".$params['d']."' and 
                (head.docno like '%".$params['x']."%' or head.clientname like '%".$params['x']."%'
                or head.vattype like '%".$params['x']."%' or head.yourref like '%".$params['x']."%')) AS tbl order by dateid desc limit 1000";

        $params = [
            'sql' => $qry,
            'tableid' => 'tblrttransupdate',
            'key' => 'trno',
            'txtclass' => 'userstxt',
            'actionheader' => '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'clientname',
                    'label' => 'Customer Name',
                    'class' => 'col-description'
                ],[
                    'name' => 'vattype',
                    'label' => 'Vat type',
                    'class' => 'col-codes'
                ],[
                    'name' => 'yourref',
                    'label' => 'Yourref',
                    'class' => 'col-codes'
                ],[
                    'name' => 'ourref',
                    'label' => 'OurRef',
                    'class' => 'col-codes'
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px;margin-top:-8px;" class="fa fa-refresh"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'updatethistrans btn btn-social-icon btn-bitbucket',
                    'attributes' => [
                        ['name'=>'docno','value'=>'docno'],
                        ['name'=>'clientname','value'=>'clientname'],
                        ['name'=>'vattype','value'=>'vattype'],
                        ['name'=>'yourref','value'=>'yourref'],
                        ['name'=>'ourref','value'=>'ourref'],
                        ['name'=>'trno','value'=>'trno'],
                    ]
                ]
            ]
        ];

        return Yii::$app->tblgenerator->generateGrid($params);

            
        } catch (\Exception $e) {
            echo $e;
        }
    }//end f

    public function actionUpdatetransaction(){
        try {
        $params = $_GET;
        
        $qryselect = "select postdate from cntnum where trno = ".$params['q'];
        $status = Yii::$app->sbccommon->datareader($qryselect);
        
        if($status == null){
            $tablehead = "lahead";    
        }else{
            $tablehead = "glhead";
        }//end if

        $qry="update " . $tablehead . " set yourref = '".$params['qq']['yref']."',
        ourref = '".$params['qq']['oref']."',vattype = '".$params['qq']['vtype']."',uv_transtype='".$params['qq']['ttype']."' where trno =".$params['q'];

        $status = Yii::$app->sbccommon->execqry($qry);

        if($status){
          /*   $qrydoc = "select doc from cntnum where trno = '".$params['q']."'";
            $doc = Yii::$app->sbccommon->datareader($qrydoc);

            if($doc == "SJ" || $doc == "RR"){
                $timeupdate = Yii::$app->systemsettings->getCurrentTimeStamp();
                
                //checks tbl_transaction_vattype_history for records
                $qry = "select count(id) as counter from tbl_transaction_vattype_history where trno = " . $params['q'];
                $history_records = Yii::$app->sbccommon->datareader($qry);

                if($history_records == 0){
                    //inserts past vattype and new vattype
                    $qry_insert = "insert into tbl_transaction_vattype_history (vattype, trno , updated_at) values('".$prev_vattype."',".$params['q'].",'".$timeupdate."')";
                    Yii::$app->sbccommon->execqry($qry_insert);
                }//end if

                $qry_insert2 = "insert into tbl_transaction_vattype_history (vattype, trno , updated_at) values('".$params['qq']['vtype']."',".$params['q'].",'".$timeupdate."')";
                Yii::$app->sbccommon->execqry($qry_insert2);
            }//end if */

            $msg = "Transaction Successfully Updated.";
        }else{
            $msg = "Transaction updating failed.";
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>$status,'msg'=>$msg];


        } catch (\Exception $e) {
            echo $e;
        }
    }//end f
}