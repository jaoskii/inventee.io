<?php

namespace backend\modules\taxmenu\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Taxmenu;
use yii\base\ErrorException;
use yii\web\Response;

class DefaultController extends Controller{

   public $access = array(
        'view' => 3099);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
    if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $terms = new Taxmenu;
             $data =  $terms->openTaxmenu($this,$this->access['view']);  
            return $this->render('index',array('termsdata'=>$data,'moduleid'=>$moduleid));

        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionEditterms(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data = Yii::$app->sbccommon->opentable("selectline,name,atc,rate from taxmenu where line ='$line' order by line");

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['termsdata' => $data];
        //echo json_encode(array('termsdata' => $data));
    }//END ACTION EDIT

    public function actionInserttax(){

        $name = $_GET['name'];
        $atc = $_GET['atc'];
        $rate = $_GET['rate'];
        $moduleid = $this->module->id;
        
    	$status = Yii::$app->sbccommon->execqry("insert into taxmenu (name,atc,rate,createby) values ('$name','$atc','$rate','".Yii::$app->session['loggeduser']['username']."')");

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status];
    	//echo json_encode(['status'=>$status]);
    }//END ACTION EDIT    

    public function actionUpdatetaxmenu(){  

        $line = $_GET['line'];
        $name = $_GET['name'];
        $atc = $_GET['atc'];
        $rate = $_GET['rate'];
        $moduleid = $this->module->id;
    	$status = Yii::$app->sbccommon->execqry("update taxmenu set name ='$name',atc='$atc',rate='$rate' where line = '$line'");

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status];
        //echo json_encode(['status'=>$status]);
    }//END ACTION EDIT

    public function actionDeletetaxmenu(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$status = Yii::$app->sbccommon->execqry("delete from taxmenu where line = '$line'");

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$status];
        //echo json_encode(['status'=>$status]);
    }//END ACTION EDIT

    public function actionComparetermslines(){     
        try {
            Yii::$app->backend->AjaxVerification($this);
            $params = $_POST; 
            Yii::$app->sbccontroller->sbcComparetaxmenulines($this,$params);
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end comparetermslines

    public function actionCanceledittax(){
        Yii::$app->backend->AjaxVerification($this);

        $line = $_GET['line'];
        $termsdata=Yii::$app->sbccommon->opentable("select line,name,atc,rate from taxmenu where line = $line");
      
          if(!empty($termsdata)){
            $name = $termsdata[0]['name'];
            $atc = $termsdata[0]['atc'];
            $rate = $termsdata[0]['rate'];
            $passjson = array('name'=>$name,'atc'=>$atc,'rate'=>$rate);      
            
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return $passjson;
            //echo json_encode($passjson);
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;                    
            return ["error"=>"ERROR RETRIEVAL"];
            //echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }
   }//end cancel edit

   public function actionBuildstockview(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = [
            'sql' => "select line,name,atc,rate from taxmenu",
            'tableid' => 'taxmenustockview',
            'key' => 'line',
            'txtclass' => 'bodytextbox',
            'checkbox' => false,
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'name',
                    'label' => 'Tax Title',
                    'class' => 'col-description taxname aimslabel stocktxt'
                ], [
                    'name' => 'atc',
                    'label' => 'ATC',
                    'class' => 'col-codes taxatc aimslabel stocktxt'
                ], [
                    'name' => 'rate',
                    'label' => 'Rate',
                    'class' => 'col-codes taxrate aimslabel stocktxt'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txtline txthidden',
                    'default'=>'0',
                ],
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-edit" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'btnedittaxmenu btn btn-social-icon btn-bitbucket',
                    'attributes'=>[['name'=>'line','value'=>'line'],
                                  ['name'=>'taxname','value'=>'name'],
                                  ['name'=>'atc','value'=>'atc'],
                                  ['name'=>'rate','value'=>'rate']],
                ],[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'btndeletetaxmenu btn btn-social-icon btn-google',
                    'attributes'=>[['name'=>'line','value'=>'line']],
                ],
                
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
      }//end function
}//END CONTROLLER
