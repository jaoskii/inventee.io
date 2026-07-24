<?php

namespace backend\modules\POSRetail\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;
// use app\models\Profile;

class DefaultController extends Controller
{
	 public $access = array(
        'view' => 599);


     public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

   
    public function actionIndex(){   
        if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/posretaillayout";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }
    }

    public function actionLoadposlistsgrid1() {

        if (Yii::$app->session['loggeduser']['access'][$this->access['view']] == 1) {
            $sql = "select 1 as barcode, '' as shortname, '' as qty, '' as amt, '' as disc, '' as ext";
            $params = [
                'sql' => $sql,
                'tableid' => 'POSliststable1',
                'key' => 'barcode',
                'txtclass' => 'POStextbox',
                
                'column' => [
                    [
                        'name' => 'barcode',
                        'label' => 'BARCODE',
                        'class'=>'col-min aimslabel',
                    ],[
                    	'name' => 'shortname',
                        'label' => 'SHORT NAME',
                        'class'=>'col-min aimslabel',
                    ],[
                    	'name' => 'qty',
                        'label' => 'QTY',
                        'class'=>'col-min aimslabel',
                    ],[
                    	'name' => 'amt',
                    	'default' => '0.00',
                        'label' => 'AMOUNT',
                        'type' => 'text',
                        'class'=>'col-currency aimslabel',
                    ],[
                    	'name' => 'disc',
                        'label' => 'DISCOUNT',
                        'class'=>'col-min aimslabel',
                    ],[
                        'name' => 'ext',
                        'label' => 'EXT',
                        'class' => 'col-currency aimslabel'
                    ]
                ],
               
            ];
            return Yii::$app->tblgenerator->generateGrid($params);
        }
    }
}
