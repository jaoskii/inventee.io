<?php

namespace backend\modules\coa\controllers;

use Yii;
use yii\web\Controller;

use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
use yii\base\ErrorException;
use yii\web\Response;

class DefaultController extends Controller{

    public $access = array(
        'view' => 190,'edit' => 191,'new' => 192,'save' => 193,'change' => 194,
        'delete' => 195,'print' => 196,'lock' => 197,'unlock' => 198,
        'post' => 199,'unpost' => 200,'denydetails' => 201,'denyamount' => 202);


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
        if(isset(Yii::$app->session['loggeduser'])){
            if(Yii::$app->session['loggeduser']['access'][2] == 1){
                $data = Yii::$app->backend->getAccountGrandparents();
                $this->layout = "@app/views/layouts/backend/main";
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                return $this->render('index',array('moduledata' => $data,'moduleid'=>$moduleid));        
            }else{
                return $this->redirect(Url::to(['/admin/default/401']));
            }//emd if
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionGetacctgchildren(){
        $acno = $_GET['acno'];
        $datachild = Yii::$app->backend->getAccountChildren($acno);
        
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['child'=>$datachild];
        //echo json_encode(array('child'=>$datachild));
    }//end get acctg children

    public function actionGetacctgattrib(){
        $acnoid = $_GET['acnoid'];
        $data = Yii::$app->backend->getAccountAttributes($acnoid);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['accdata'=>$data];
        //echo json_encode(array('accdata'=>$data));
    }//end get acctg ATTRIBUTES

    public function actionNewchild(){
        $acno = $_GET['acno'];
        $data = Yii::$app->backend->automateNextAcno($acno,'CHILD');

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['acno'=>$data['newacno'],'type'=>$data['cat'],'pname'=>$data['parentname'],
                'pcode'=>$data['parentcode'],'levelid'=>$data['levelid']];
        /* echo json_encode(array('acno'=>$data['newacno'],'type'=>$data['cat'],'pname'=>$data['parentname'],
                        'pcode'=>$data['parentcode'],'levelid'=>$data['levelid'])); */
    }//END ACTION NEW CHILD

     public function actionNewparent(){
        try {
        $data = Yii::$app->backend->automateNextAcno('','PARENT');

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['acno'=>$data['newacno'],'type'=>$data['cat'],'pname'=>$data['parentname'],
                'pcode'=>$data['parentcode'],'levelid'=>$data['levelid']];
        /* echo json_encode(array('acno'=>$data['newacno'],'type'=>$data['cat'],'pname'=>$data['parentname'],
                        'pcode'=>$data['parentcode'],'levelid'=>$data['levelid'])); */
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END ACTION NEW CHILD

    public function actionSavecontra(){
        $params = $_POST;
        $data = Yii::$app->backend->modifyChartofAccount($params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['refreshthis'=>$data['refreshthis'],'refreshacno'=>$data['refreshacno'],
                'error_msg'=>$data['error_msg'],'msg'=>$data['msg']];
        /* echo json_encode(array('refreshthis'=>$data['refreshthis'],'refreshacno'=>$data['refreshacno'],
                        'error_msg'=>$data['error_msg'],'msg'=>$data['msg'])); */
    }//END ACTION SAVE

    public function actionDeletecontra(){
        $params = $_GET;
        $data = Yii::$app->backend->deleteContra($params);

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['msg'=>$data['msg'],'errorstatus'=>$data['error'],'refreshacno'=>$data['refreshacno'],
                'refreshacnoid'=>$data['refreshacnoid']];
        /* echo json_encode(array('msg'=>$data['msg'],'errorstatus'=>$data['error'],'refreshacno'=>$data['refreshacno'],
                        'refreshacnoid'=>$data['refreshacnoid'])); */
    }//END ACTION DELETE 

    public function actionGetgrandparents(){
        $data = Yii::$app->backend->getAccountGrandparents();

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['grandparents'=>$data];
        //echo json_encode(array('grandparents'=>$data));
    }//END GETGRAND PARENTS

    public function actionCheckrequiredcoa(){
        Yii::$app->backend->AjaxVerification($this);
        $params['controller'] = $this;
        return Yii::$app->automator->automateRequiredcoa($params);
    }//end action

     public function actionContrasearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateContralookup($params);
    }//END CONTRA
    //ALVIN END
        
    public function actionLoadaccountdetails() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateAccountdetailslookup($params);
    }//kim end
}//END CONTROLLERR