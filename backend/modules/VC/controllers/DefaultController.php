<?php

namespace backend\modules\VC\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use yii\base\ErrorException;
//FOR TESTING PURPOSES
use app\models\Item;
use app\models\Cntnum;
use app\models\Postock;

class DefaultController extends Controller
{
	public $access = array('view' => 3133);

 
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

   
    public function actionIndex(){   
        if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $this->layout = "@app/views/layouts/backend/main";
                return $this->render('index',array('moduleid'=>$moduleid));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
        }else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }
    }

     public function actionApprovevc(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $stat = Yii::$app->backend->approvevc($params);
        echo json_encode(array('stat'=>$stat['status'],'msg'=>$stat['msg'])); 
    }//END CONTRA

    public function actionUserload(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateUserload($params);
    }//END CONTRA

    public function actionSchedview(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSchedview($params);
    }//END UOM


    public function actionLoadvoucherrelease(){
        Yii::$app->backend->AjaxVerification($this); 
        $params=$_POST;
        $type = 'vc';
        $sql = Yii::$app->backend->retrieveVoucherChecking($params,$type);
        $params = [
            'sql' => $sql,
            'tableid' => 'vcschedview',
            'key' => 'sched_id', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'checkbox' => true,
            'template'=> ['checkbox','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'date1', //FIELD NAME SA QUERY
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'Start Date',
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'date2', //FIELD NAME SA QUERY
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'End Date',
                    'type' => 'text',
                    'width' => '150px',
                    'class'=>'col-codes stocktxt',
                ],[
                    'name' => 'amt',
                    // 'editable' => true,
                    'readonly' => true,
                    'default' => '0.00',
                    'label' => 'Amount',
                    'type' => 'text',
                    'class' => 'col-currency stocktxt'
                ],[
                    'name' => 'clientname',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'Client',
                    'type' => 'label',
                    'class' => 'col-description stocktxt'
                ],[
                    'name' => 'username',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'User',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'sched_desc',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'Description',
                    'type' => 'text',
                    'class' => 'col-description'
                ],[
                    'name' => 'jonumber',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'JO #',
                    'type' => 'text',
                    'class' => 'col-codes'
                ],[
                    'name' => 'approvedby',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'Approved By',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'approvedate',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'Approved Date',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'cutdate',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'Cut Date',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'apvdoc',
                    // 'editable' => true,
                    'readonly' => true,
                    'label' => 'APV Document',
                    'type' => 'text',
                    'class' => 'col-codes stocktxt'
                ],[
                    'name' => 'sched_id',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end function
    


}
