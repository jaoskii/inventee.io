<?php

namespace backend\modules\terms\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

use app\models\Terms;

use yii\web\Response;
class DefaultController extends Controller{

    public $access = array(
        'view' => 634);

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
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionBuildstockview() {
        $sql = "select terms,line,days,discount from terms order by terms";
        $params = [
            'sql' => $sql,
            'tableid' => 'termsstockview',
            'key' => 'line',
            'txtclass' => 'termstextbox',
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'terms',
                    'editable' => true,
                    'type' => 'text',
                    'class'=>'col-codes termstxt',
                ],[
                    'name' => 'days',
                    'editable' => true,
                    'type' => 'text',
                    'class' => 'col-codes termstxt'
                ],[
                    'name' => 'line',
                    'hidden' => true,
                    'class' => 'txthidden',
                    'default' => ''
                ]
            ],
            'buttons' => [[
                    'name' => '',
                    'caption' => '<i class="fa fa-trash" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'deleteterms gvbtns btn btn-social-icon btn-google',
                    'attributes'=>[['name'=>'line','value'=>'line']]
            ]]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }

    public function actionSaveterms() {
        try {
            $params = $_GET;
            if($params['line'] == 0) {
                Yii::$app->sbccommon->execqry("insert into terms(terms, days, createby, editby, editdate, viewdate, viewby) values('{$params['terms']}', '{$params['days']}', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'aa')");
                $data = Yii::$app->sbccommon->opentable("select line from terms order by line desc limit 1");
                $line = $data[0]['line'];
            } else {
                Yii::$app->sbccommon->execqry("update terms set terms = '{$params['terms']}', days = '{$params['days']}', editdate = CURRENT_TIMESTAMP where line = '{$params['line']}'");
                $line = $params['line'];
            }
            return $line;
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function actionEditterms(){   
        $line = $_GET['line'];
        $moduleid = $this->module->id;
     	$data = Yii::$app->sbccommon->opentable("select terms,line,days,discount from  terms where line ='$line' order by terms");
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['termsdata' => $data];
        //echo json_encode(array('termsdata' => $data));
        //var_dump($data);
    }//END ACTION EDIT

    public function actionInsertterms(){
        $terms = $_GET['terms'];
        $days = $_GET['days'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("insert into terms (terms,days,createby,editby,editdate,viewdate,viewby) values ('$terms','$days','','','0000-00-00 00:00:00','0000-00-00 00:00:00','aa')");
    	$data =  Yii::$app->sbccommon->opentable("select terms,line,days,discount from terms order by terms");
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['termsdata' => $data];
        //echo json_encode(array('termsdata' => $data));
    }//END ACTION EDIT    

    public function actionUpdateterms(){  
        $line = $_GET['line'];
        $terms = $_GET['terms'];
        $days = $_GET['nodays'];
        $moduleid = $this->module->id;
    	Yii::$app->sbccommon->execqry("update terms set terms ='$terms',days='$days',editdate=CURRENT_TIMESTAMP where line = '$line'");
    	$data =  Yii::$app->sbccommon->opentable("select terms,line,days,discount from terms where line = $line");
        
        if(!empty($data)){
            $newterms = $data[0]['terms'];
            $newdays = $data[0]['days'];

            $passjson = array('terms'=>$newterms,'nodays'=>$newdays);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $passjson;
            //echo json_encode($passjson);

        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ["error"=>"ERROR RETRIEVAL"];
            //echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }

        
    }//END ACTION EDIT


    public function actionDeleteterms(){   
        $line = $_GET['line'];
        $checkval=0;
        for ($i=0; $i <4 ; $i++) { 

            
            switch ($i) {
                case '0':
                    $qry="select head.terms from client as head left join terms as t on t.terms=head.terms where t.line='".$line."'";
                    break;
                case '1':
                    $qry="select head.terms from pohead as head left join terms as t on t.terms=head.terms where t.line='".$line."'";
                    break;
                case '2':
                    $qry="select head.terms from sohead as head left join terms as t on t.terms=head.terms where t.line='".$line."'";
                    break;
                case '3':
                    $qry="select head.terms from lahead as head left join terms as t on t.terms=head.terms where t.line='".$line."'";
                    break;
                case '4':
                    $qry="select head.terms from glhead as head left join terms as t on t.terms=head.terms where t.line='".$line."'";
                    break;


            }
            $check = Yii::$app->sbccommon->opentable($qry);
            if(!empty($check)){
                    $checkval=+1;
            }
            
        }
        if ($checkval==0) {
            Yii::$app->sbccommon->execqry("delete from terms where line = '$line'");
            echo 'success';

        }else{
            echo 'fail';
        }
        
    }//END ACTION EDIT

    public function actionComparetermslines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST; 
        Yii::$app->sbccontroller->sbcComparetermslines($this,$params);
    }//end comparetermslines

    public function actionCanceledit(){
        Yii::$app->backend->AjaxVerification($this);
        $line = $_GET['line'];

        $termsdata=Yii::$app->sbccommon->opentable("select terms,line,days,discount from terms where line = $line");
        

        if(!empty($termsdata)){

            $newterms= $termsdata[0]['terms'];
            $newdays = $termsdata[0]['days'];

            $passjson = array('terms'=>$newterms,'nodays'=>$newdays);            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $passjson;
            //echo json_encode($passjson);
                

        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ["error"=>"ERROR RETRIEVAL"];
            //echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        }
                                          
   }//end cancel edit
}//END CONTROLLER
