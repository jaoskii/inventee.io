<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\base\ErrorException;
/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    //E-COMMERCE USE THIS ACTION TO SET IT TO BE A LANDING PAGE
    public function actionIndex(){   //THIS IS FOR FRONTEND INDEX
        switch (Yii::$app->systemsettings->setFrontendBackendRedirection()) {
            case 0:
                return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/login']));
            break;
            
            default:
                switch (Yii::$app->systemsettings->companyfrontendConfig()) {
                    case 'XTZ':
                        $this->layout = 'frontend/xtz/index';
                        return $this->render('index');
                    break;

                    case 'SBC':
                        $this->layout = 'frontend/sbc/index';
                        return $this->render('index');
                    break;

                    case 'BUYMORE':
                        unset(Yii::$app->session['mostreviewed']);
                        unset(Yii::$app->session['personallypicked']);
                        unset(Yii::$app->session['lanes']);
                        //THIS LINE BELOW RETRIEVES LANES
                        if(!isset(Yii::$app->session['lanes'])){
                            Yii::$app->session['lanes'] = Yii::$app->backend->retrieveLanes(1);
                        }//end ssession
                        
                        //THIS LINE BELOW RETRIEVES MOST REVIEWED ITEMS
                        if(!isset(Yii::$app->session['mostreviewed'])){
                            Yii::$app->session['mostreviewed'] = Yii::$app->frontend->getMostReviewedItems();
                        }//end ssession

                        //THIS LINE BELOW RETRIEVES MOST personally picked ITEMS
                        if(!isset(Yii::$app->session['personallypicked'])){
                            Yii::$app->session['personallypicked'] = Yii::$app->frontend->getPersonallyPicked();
                        }//end ssession
                        $this->layout = 'frontend/steamlayout/index';
                    break;
                    
                    case 'HOTELDEMO':
                        Yii::$app->view->params['featroomtypes'] = Yii::$app->frontend->getFeaturedRoomtypes();
                        $this->layout = 'frontend/hoteldemo/index';
                    break;
                }//END SWITCH
            break;
        }//end switch
    }//end action index

    public function action404(){
        $this->layout = "@app/views/layouts/backend/error";
        return $this->render('404');
    }

    public function actionServices(){
        $this->layout = "@app/views/layouts/backend/servicelayout";
        return $this->render('services');
    }//end ufncti

}//end controller site
