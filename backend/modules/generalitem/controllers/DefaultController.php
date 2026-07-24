<?php

namespace backend\modules\generalitem\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Item;

class DefaultController extends Controller
{
	public $access = array(
        'view' => 710,'edit' => 711,'new' => 712,'save' => 713,
        'change' => 714,'delete' => 715,'print' => 716);

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
     if(isset(Yii::$app->session['loggeduser'])){
           $this->layout = "@app/views/layouts/backend/main";
           $moduleid = $this->module->id;
           Yii::$app->view->params['moduleid'] = $moduleid;
           $item = new Item;
           
           $data =  $item->openGeneralItem();               
           // var_dump($data);
           // return 0;
           return $this->render('index',array('generalitem'=>$data,'moduleid'=>$moduleid));

         }else{
             return $this->redirect(Url::to(['/admin/default/login']));
         }//END IF
    }//END ACTION INDEX

    public function actionNewgenitem(){
        $barcode = $_GET['barcode'];
        $access = $this->access['new'];        
        $barcode = Yii::$app->backend->sanitize($barcode,'DEFAULT');
        $data = Yii::$app->weblisting->genitemnewing($this,$access,$barcode);

        echo json_encode(array('generalitem' => $data));
    }//END NEW 

    public function actionSavegenitem(){
        $barcode = $_POST;
        $access = $this->access['save'];        
        $barcode = Yii::$app->backend->sanitize($barcode,'ARRAY');
        
        $data = Yii::$app->weblisting->genitemsaving($this,$access,$barcode);

        if ($barcode['line']==0){
           	echo json_encode(array('generalitem' => $data));	
    	}
        
    }//END SAVE

    public function actionComparegenitemlines(){     
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;  
        Yii::$app->sbccontroller->sbcComparegenitemlines($this,$params);
    }//end compare

    public function actionDeletegenitem(){
        $item = new Item;        
        $moduleid = $this->module->id;
        $bcode = $_GET['bcode'];
        
        $genitem = $item->checkserveasset($bcode);

        if (!empty($genitem)){
            echo json_encode(array('return'=>'0','generalitem' => null));
        }else{
          $result = $item->deletegenitem($bcode);
          $data =  $item->openGeneralItem();
          echo json_encode(array('return'=>'1','generalitem' => $data));
        }
        
    }

    public function actionCanceleditgenitem(){
        Yii::$app->backend->AjaxVerification($this);
        $bcode = $_GET['bcode'];
        $line = $_GET['line'];
        $item = new Item;
        
        $genitem=$item->openGeneralItemline($bcode);  
        

        if(!empty($genitem)){

            $newbcode = $genitem[0]['bcode'];
            $itemdesc = $genitem[0]['itemdesc'];
            $itemshortname = $genitem[0]['itemshortname'];
            $itembrand = $genitem[0]['itembrand'];
            $itempart = $genitem[0]['itempart'];
            $itemuom = $genitem[0]['itemuom'];
            $itemcolor = $genitem[0]['itemcolor'];
            $itemgroup  = $genitem[0]['itemgroup'];
            $itemclass  = $genitem[0]['itemclass'];
            $itemsize  = $genitem[0]['itemsize'];
            $itemmodel  = $genitem[0]['itemmodel'];

             $passjson = array('bcode'=>$newbcode,'itemdesc'=>$itemdesc,'itemshortname'=>$itemshortname,'itembrand'=>$itembrand,'itempart'=>$itempart,'itemuom'=>$itemuom,'itemcolor'=>$itemcolor,'itemgroup'=>$itemgroup,'itemclass'=>$itemclass,'itemsize'=>$itemsize,'itemmodel'=>$itemmodel,'line'=>$line);
               echo json_encode($passjson); 
        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }
                                          
   }
}// end class
