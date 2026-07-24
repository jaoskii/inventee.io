<?php

namespace app\modules\logtracer\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use yii\base\ErrorException;

use yii\web\Response;
/**
 * Default controller for the `logtracer` module
 */
class DefaultController extends Controller
{
    public $access = array('view' => 3307);

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
      echo json_encode(array('verified'=>$return)); 
    }

   /* public function actionIndex(){
        try {
            $this->layout = "@app/views/layouts/backend/main";
            $data = Yii::$app->sbccommon->opentable("
                select '' as userid,'' as accessid, '' as username,'' as name
                union all
                select userid,accessid,username,name from useraccess;");
            $data2= Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where parent='\\\\' and parentid=0 and allowed <> 1 order by code");
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            return $this->render('index',array('usersdata' => $data,'moduledata' => $data2,'moduleid'=>$moduleid));            
        } catch (\Exception $e) {
            echo $e;
        }
    }//END ACTION INDEX*/

    public function actionIndex(){
      $return=Yii::$app->sbccontroller->sbcindex($this);        
      if($return['verifyuser']==1){
          return $this->redirect(Url::to(['/admin/default/login']));
      }elseif($return['verifyaccess']==1){
          return $this->redirect(Url::to(['/admin/default/401']));
      }else{
        $data = Yii::$app->sbccommon->opentable("
            select '' as userid,'' as accessid, '' as username,'' as name
            union all
            select userid,accessid,username,name from useraccess;");
        $data2= Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where parent='\\\\' and parentid=0 and allowed <> 1 order by code");

        return $this->render('index',array('usersdata' => $data,'moduledata' => $data2,'moduleid'=>$return['moduleid']));
      }
    }//END ACTION INDEX


    public function actionTracelogs(){
        try {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $filter = '';

        if(isset($params['user']) && $params['user'] != ""){
            $filter .= " and loggers.userid = ". $params['user']." ";
        } //end if

        if(isset($params['logtype']) && $params['logtype'] != ""){
            if(strtoupper($params['logtype']) == "MODULE"){
                $filter .= " and loggers.uni_key <> 0 ";
            }else{
                $filter .= " and loggers.uni_key = 0 ";
            }//end if
        } //end if

        if(isset($params['x'])){
            $search_sanitized = Yii::$app->backend->sanitize($params['x'],'DEFAULT');

            if($params['x'] != ''){
                $filter .= " and (
                users.username like '%".$search_sanitized."%' 
                or loggers.code like '%".$search_sanitized."%' 
                or loggers.log_title like '%".$search_sanitized."%' 
                or loggers.log_description like '%".$search_sanitized."%') "; 
            }//end if
        }//end if

        $qry = "select case when loggers.code = '' then '---' else loggers.code end as code,
                loggers.id,loggers.log_title,users.username,loggers.log_description,
                left(loggers.dateid,10) as dateid from tbl_logtracer as loggers
                left join useraccess as users on users.userid = loggers.userid
                where left(loggers.dateid,10) between '".$params['startdate']."' and '".$params['enddate']."'
                ".$filter."
                order by loggers.dateid desc";

        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-customerlookup',
            'key' => 'id', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                    'name' => 'code',
                    'label' => 'Unique Code',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'username',
                    'label' => 'User',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'log_title',
                    'label' => 'Description',
                    'class' => 'aimslabel col-descriptions'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-codes'
                ]],
            
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i style="font-size:12px; margin-top:-8px;" class="fa fa-eye"></i>',
                    'style' => 'width:18px;height:18px;margin-top:-2px;margin-left:2px;',
                    'class' => 'btnviewlogtrace btn btn-social-icon btn-github',
                    'attributes'=>[['name'=>'log_details','value'=>'log_description']],
                ]
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);

            
        } catch (\Exception $e) {
            echO $e;
        }
    }//end fn
}
