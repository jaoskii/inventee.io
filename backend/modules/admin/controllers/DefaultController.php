<?php
namespace backend\modules\admin\controllers;

use Yii;
use yii\web\Controller;
//exported MODELS
use app\models\Webproc;
use app\models\LoginForm;
use app\models\Lastock;
use app\models\Postock;
use app\models\Center;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\UserAccess;
//for testing
use app\models\Common;
use app\models\Cntnum;
use app\models\Log;  
use yii\base\ErrorException;

use yii\web\Response;
class DefaultController extends Controller
{

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action)
    {
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    

    //FOR DASHBOARD LANDING PAGE
    public function actionIndex(){
        if(Yii::$app->systemsettings->setfrontendOnly()){
            return Yii::$app->getResponse()->redirect(Url::to(['/']));
        }else{
            
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'KINGGEORGE':
                    $model = new LoginForm;
                    Yii::$app->systemsettings->companyConfig();
                    Yii::$app->systemsettings->resellerConfig();
                    if(!$model->isLogged()){
                        $this->layout = "@app/views/layouts/backend/king_g_dashboardlayout";
                        return $this->render('dashboard_king_G');
                    }else{
                        $this->layout = "@app/views/layouts/backend/main";
                        $moduleid = $this->module->id;
                        Yii::$app->view->params['moduleid'] = $moduleid;
                        return $this->render('indexpage');
                    } //end if 
                break;

                default:
                    $model = new LoginForm;
                    Yii::$app->systemsettings->companyConfig();
                    Yii::$app->systemsettings->resellerConfig();
                    if(!$model->isLogged()){
                        return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/login']));
                    }else{
                        $this->layout = "@app/views/layouts/backend/main";
                        $moduleid = $this->module->id;
                        Yii::$app->view->params['moduleid'] = $moduleid;
                        return $this->render('indexpage');
                    } //end if 
                break;
            }//end switch case
        }//end if
    }//END ACTION INDEX


    public function actionShowmsg(){
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('restricted');       
    }//end ac


    //FOR LOGIN AND LOGOUT ACTIONS
    public function actionLogin(){
        if(Yii::$app->systemsettings->setfrontendOnly()){
            return Yii::$app->getResponse()->redirect(Url::to(['/']));
        }else{
            if(isset(Yii::$app->session['king_db_set'])){
                unset(Yii::$app->session['king_db_set']);
            }//end if

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'KINGGEORGE':
                    if(!isset($_GET['q'])){
                        return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                    }else{
                        Yii::$app->session['king_db_set'] = $_GET['q'];
                        Yii::$app->systemsettings->companyConfig();
                        
                        switch ($_GET['q']) {
                            case md5(1):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(2):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(3):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(4):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(5):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(6):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(7):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(8):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(9):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;

                            case md5(10):
                                $model = new LoginForm;
                                if($model->isLogged()){
                                    return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                                }else{
                                    Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                                    $this->layout = "@app/views/layouts/backend/loginpage";
                                    return $this->render('login');
                                }//end if
                            break;
                            
                            default:
                                return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                            break;
                        }///end switch
                    }//end if
                break;

                default:
                    $model = new LoginForm;
                    if($model->isLogged()){
                        return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/index']));
                    }else{
                        Yii::$app->session['wallpaper'] = Yii::$app->backend->getWallpaper();
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'RTT':
                            $this->layout = "@app/views/layouts/backend/loginpage_rtt";
                            return $this->render('login_rtt');
                            break;

                            default:
                            $this->layout = "@app/views/layouts/backend/loginpage";
                            return $this->render('login');
                            break;
                        }//end switch case
                    }//end if
                break;
            }//end switch
        }//end if
    }//END LOGIN

    public function actionRequestlogin(){
        $model = new LoginForm;
        if(isset($_GET['username']) || isset($_GET['password'])){
            $model->username = $_GET['username'];   
            $model->password = $_GET['password'];   

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'KINGGEORGE':
                    if(isset($_GET['q'])){
                        $model->king_branch = $_GET['q'];
                    }else{
                        $model->king_branch = '';
                    }//end if
                break;
                
                default:
                    $model->king_branch = '';
                break;
            }//END SWITCH

            if($model->login()){
                //IF LOGIN SUCCEED
                //$center = new Center();
                if(Yii::$app->systemsettings->setCenterSelection()){
                $centers = Center::getcenters(md5(Yii::$app->session['loggeduser']['userid']));
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['centerselection'=>Yii::$app->systemsettings->setCenterSelection(),
                                                'msg' => $model->ERR_MSG,'centers' =>$centers,'userid'=>Yii::$app->session['debugger']];
                /* echo json_encode(array('centerselection'=>Yii::$app->systemsettings->setCenterSelection(),
                                                'msg' => $model->ERR_MSG,'centers' =>$centers,'userid'=>Yii::$app->session['debugger'])); */
                }else{
                    $centerdata = Yii::$app->systemsettings->setDefaultCenterCode();
                    
                    if($centerdata['error'] != ''){
                        $status = false;
                    }else{
                        $status = $model->updateCredentials($centerdata['code']);
                    }//end if error
                    
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['centerselection'=>Yii::$app->systemsettings->setCenterSelection(),
                                                        'status' => $status,'msg'=>'','centererror'=>$centerdata['error']];
                    /* echo json_encode(array('centerselection'=>Yii::$app->systemsettings->setCenterSelection(),
                                                        'status' => $status,'msg'=>'','centererror'=>$centerdata['error'])); */
                }//end if
            }else{
                //IF LOGIN FAILED
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['msg' => $model->ERR_MSG];
                //echo json_encode(array('msg' => $model->ERR_MSG));
            }//end f
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['msg' => "Please fill up required fields"];
            //echo json_encode(array('msg' => "Please fill up required fields"));
        }//END ISSET
    }//END REQUEST LOGIN


    public function actionGetquickadddata(){
        try {
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qry = "select itemid,uom,itemname,amt from item where barcode = '".$params['barcode']."'";
        $data = Yii::$app->sbccommon->opentable($qry);

        if(!empty($data)){
            $itemid = $data[0]['itemid'];
            $uom = $data[0]['uom'];
            $itemname = $data[0]['itemname'];
            $amt = $data[0]['amt'];
        }else{
            $itemid = '';
            $uom = '';
            $itemname = '';
            $amt = '';
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['itemid'=>$itemid,'uom'=>$uom,'itemname'=>$itemname,'amt'=>$amt];
        //echo json_encode(['itemid'=>$itemid,'uom'=>$uom,'itemname'=>$itemname,'amt'=>$amt]);

            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end action

//USE FOR AJAXIFIED SETTING OF CENTER
   public function actionSetusercenter(){
        //REMOVAL OF DATA FROM LAST LOGIN WITHOUT CENTER
        unset(Yii::$app->session['signnwithoutcenter']);
        $model = new LoginForm();
        $centerid = $_GET['centerid'];
        //IF USER LOGGED IN AND HAS NO CENTER YET AND JUST HAD TO SELECT CENTER FROM THE COMBOBOX
        if(isset(Yii::$app->session['loggeduser']) && $centerid != ""){
            //IF USER HAS BUT DOESNT HAVE USERCENTER
            $status = $model->updateCredentials($centerid);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => $status];
            //echo json_encode(array('status' => $status));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));            
        }
   }

//USE FOR DASHBOARD USERS LOGOUT
    public function actionLogout(){
        Yii::$app->user->logout();
        unset(Yii::$app->session['loggeduser']);
        unset(Yii::$app->session['menu']);
        return $this->redirect(Url::to(['/admin/default/login']));
    }//end logout

    public function actionVerifyadministratorpass(){
    $user = Yii::$app->backend->sanitize($_GET['username'],'DEFAULT');
        $pass = Yii::$app->backend->sanitize($_GET['password'],'DEFAULT');
        $getcreds = Yii::$app->sbccommon->opentable("select administrator_enc from useraccess 
            where username= '".$user."' and administrator_pass <> ''");
        if(empty($getcreds)){
            $status = false;
        }else{  
            if($getcreds[0]['administrator_enc'] == md5(md5($pass))){
                $status = true;
            }else{
                $status = false;
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['verified'=>$status];
        //echo json_encode(array('verified'=>$status));
    }//end action


    public function action404(){
        $this->layout = "@app/views/layouts/backend/error";
        return $this->render('404');
      
    }

    public function action401(){
        $this->layout = "@app/views/layouts/backend/error";
        return $this->render('401');
    }

    public function actionRequestdecimal(){
        Yii::$app->backend->AjaxVerification($this); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['qtydecimal'=>Yii::$app->systemsettings->setDecimaldisplay('quantity'),'amtdecimal'=>Yii::$app->systemsettings->setDecimaldisplay('currency')];
        //echo json_encode(array('qtydecimal'=>Yii::$app->systemsettings->setDecimaldisplay('quantity'),'amtdecimal'=>Yii::$app->systemsettings->setDecimaldisplay('currency')));
    }//end action get

    public function actionRequestcompanyconfig(){
        Yii::$app->backend->AjaxVerification($this); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['cconfig'=>Yii::$app->systemsettings->companyConfig()];
        //echo json_encode(array('cconfig'=>Yii::$app->systemsettings->companyConfig()));
    }//end action get

    public function actionRequestinvoicelimiter(){
        Yii::$app->backend->AjaxVerification($this); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['limiter'=>Yii::$app->systemsettings->invoiceItemLimit()];
        //echo json_encode(array('limiter'=>Yii::$app->systemsettings->invoiceItemLimit()));
    }//end action

    public function actionRequesteditablentrylimiter(){
        Yii::$app->backend->AjaxVerification($this); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['limiter'=>Yii::$app->systemsettings->defaultEditableEntries()];
        //echo json_encode(array('limiter'=>Yii::$app->systemsettings->defaultEditableEntries()));
    }//end action

    public function actionGetitembalance(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetitembalance($this,$params);  
        if($return['verifyuser']==1){
            return $this->redirect(Url::to(['/admin/default/login']));
        } elseif($return['verifyaccess']==1) {
            return $this->redirect(Url::to(['/admin/default/401']));
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['postedpobal'=>$return['postedpobal'],
                        'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
                        'unpostedsobal'=>$return['unpostedsobal']];
            /* echo json_encode(array('postedpobal'=>$return['postedpobal'],
                        'unpostedpobal'=>$return['unpostedpobal'],'postedsobal'=>$return['postedsobal'],
                        'unpostedsobal'=>$return['unpostedsobal'])); */
        }
    }

    public function actionLoaditembal() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItembal($params);
    }

    public function actionItemlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItemlookupGV($params);
    }

    public function actionSetlayoutsetting(){
        $layoutminimized = Yii::$app->session['layoutminimized'];
        unset(Yii::$app->session['layoutminimized']);

        if($layoutminimized){
            Yii::$app->session['layoutminimized'] = false;
        }else{
            Yii::$app->session['layoutminimized'] = true;
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['isminimized'=>Yii::$app->session['layoutminimized']];
        //echo json_encode(array('isminimized'=>Yii::$app->session['layoutminimized']));
    }//end action set layout

    public function actionGetlayoutsetting(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['isminimized'=>Yii::$app->session['layoutminimized']];
        //echo json_encode(array('isminimized'=>Yii::$app->session['layoutminimized']));
    }//end aciton 

    public function actionRequestdefaultvalues(){
        Yii::$app->backend->AjaxVerification($this); 
        $barcode = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $type = Yii::$app->backend->sanitize($_GET['type'],'DEFAULT');

        switch (strtoupper($type)) {
            case 'WAREHOUSE':
                $warehousedata = Yii::$app->backend->getDefaultItemWarehouse($barcode);
                $warehouse = $warehousedata['whname'] . '~' . $warehousedata['whcode'];
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['defaultwh'=>$warehouse];
                //echo json_encode(array('defaultwh'=>$warehouse));
                break;
            
            case 'LOCATION':
                $location = Yii::$app->backend->getDefaultItemLocation($barcode);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['defaultloc'=>$location];
                //echo json_encode(array('defaultloc'=>$location));
                break;
        }//END SWITCH
    }//end action

    public function actionViewcostaccess(){
        Yii::$app->backend->AjaxVerification($this); 
        $costaccess = Yii::$app->backend->viewcostAccess();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['viewcosting'=>$costaccess];
        //echo json_encode(['viewcosting'=>$costaccess]);
    }//end function verf

    public function actionReqstockaccess(){ 
        $params = $_GET;
        Yii::$app->backend->AjaxVerification($this); 
        $stockaccess = Yii::$app->backend->getStockAccess($params['doc']);
        Yii::$app->response->format = Response::FORMAT_JSON;            
        return $stockaccess;
    }//end function verf

    public function actionCheckconfidentialaccess(){
        Yii::$app->backend->AjaxVerification($this);
        $confiaccess = Yii::$app->backend->checkConfidentialAccess();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['confiaccess'=>$confiaccess];
        //echo json_encode(['confiaccess'=>$confiaccess]);
    }//end function check confi access

    public function actionTestchecker(){
        Yii::$app->automator->automateCheckingNotBalanceItems();
    }//end test checker

    public function actionUpdatesyslockdate(){
        Yii::$app->backend->AjaxVerification($this);
        $datex = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $qry = "update profile set pvalue = '".$datex."' where doc = 'SYSL'";
        $status = Yii::$app->sbccommon->execqry($qry);
        if($status){
            $msg = 'System lockdate successfully updated.';
        }else{
            $msg = 'Error setting up system lockdate please try again!';
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>$status,'msg'=>$msg];
        //echo json_encode(['status'=>$status,'msg'=>$msg]);
    }

    public function actionReqsysdate(){
        Yii::$app->backend->AjaxVerification($this); 
        $syslock = Yii::$app->systemsettings->getSystemLockdate();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['syslockdate'=>$syslock];
        //echo json_encode(['syslockdate'=>$syslock]);
    }//end action

    //JLY CHANGE PASS
    public function actionChangepass(){
        Yii::$app->backend->AjaxVerification($this); 
         if($_GET['oldp']!='' && $_GET['newp']!='' && $_GET['retypep']){
            $qry="update useraccess
            set pwd='".$_GET['newp']."',password=md5(md5('".$_GET['retypep']."'))
            where name='".Yii::$app->session['loggeduser']['name']."' and pwd='".$_GET['oldp']."' 
            and '".$_GET['newp']."'='".$_GET['retypep']."'";
        }//end if
        $status = Yii::$app->sbccommon->execqry($qry);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>$status];
        //echo json_encode(['status'=>$status]);
    }//

    public function actionAndroidtransactionposting(){
      $trno = $_POST['x'];
      $doc = $_POST['d'];
      $user = $_POST['u'];      
      $posting = Cntnum::PostTrans($trno,$doc,$user);
        
      Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>$posting];
        //echo json_encode(['status'=>$posting]);
    }//end funciton

    public function actionAndroidgetlogs(){
        $model = new Log();
        $trno = $_POST['x'];
        $doc = $_POST['d'];
        $data = $model->getlogs($doc, $trno);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['logs'=>$data];
        //echo json_encode(['logs'=>$data]);
    }//end function

    public function actionTestjao(){
        echo '<form action="'.Url::to(['/admin/androidtransactionposting']).'" method="post">
                conn <input type="text" name="x"><br>
                username <input type="text" name="d"><br>
                password <input type="text" name="u"><br>
                <input type="submit" value="Submit">
                </form>';
    }//end

    // ========================================= JAD UPDATE 02-25-2018 ============================================= //
    public function actionCheckrecord() {
        try {
            $params = $_GET;
            $webproc = new Webproc;
            $trno = $params['trno'];
            $line = $params['line'];

            $doc = $params['doc'];
            $openstock = $webproc->getstocktype($doc);
            if($openstock == 'Lastock') {
                $data = Lastock::openstockline($doc,$trno,$line);
            } else {
                $data = Postock::openstockline($doc,$trno,$line);
            }
            if(!empty($data)) {
                $changed = false;
                
                foreach ($params as $key2 => $value) {
                    if($key2 != "tr" && $key2 != "doc" && $key2 != "parentrow") {
                        if($key2 == 'isamt' || $key2 == 'amt' || $key2 == 'rrcost' || $key2 == 'cost' || $key2 == 'ext' || $key2 == 'isqty' || $key2 == 'qty' || $key2 == 'rrqty' || $key2 == 'iss') {
                            $params[$key2] = str_replace(',','',$value);
                        }

                        if($key2 != 'itemname' && $key2 != 'original_qty'){
                            if($params[$key2] != $data[0][$key2]) {                            
                                $changed = true;
                            }//end if
                        }//end if
                    }
                }
                $data[0]['changed'] = $changed;
                $key = $params['parentrow'];
                $rows['stocklinedata'][$key] = $data[0];
            } else {
                $key = $params['parentrow'];
                $rows['stocklinedata'][$key] = '';
            }
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $rows;
            //return json_encode($rows);
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    //ALL DASHBOARD FUNCTIONS
    public function actionCounttrans(){
        try {
        $return['expns'] = Yii::$app->backend->GetFrontIndexData('EXPNS');
        $return['collect'] = Yii::$app->backend->GetFrontIndexData('COLLECT');

        $return['slsper'] = Yii::$app->backend->GetFrontIndexData('SLSPER');
        $return['slsper_ls'] = Yii::$app->backend->GetFrontIndexData('SLSPER_LS');
        $return['slsper_lls'] = Yii::$app->backend->GetFrontIndexData('SLSPER_LLS');

        $q=Yii::$app->systemsettings->quota();
        $return['slsper']=number_format(((float)str_replace(',', '', (string)$return['slsper'])/$q)*100,2);
        $return['slsper_ls']=number_format(((float)str_replace(',', '', (string)$return['slsper_ls'])/$q)*100,2);
        $return['slsper_lls']=number_format(((float)str_replace(',', '', (string)$return['slsper_lls'])/$q)*100,2);


        $return['sales'] = Yii::$app->backend->GetFrontIndexData('SALES');
        $return['prchs'] = Yii::$app->backend->GetFrontIndexData('PRCHS');
        $return['outap'] = Yii::$app->backend->GetFrontIndexData('OUTAP');
        $return['outar'] = Yii::$app->backend->GetFrontIndexData('OUTAR');

        $return['paidar'] = Yii::$app->backend->GetFrontIndexData('PAIDAR');
        $return['paidap'] = Yii::$app->backend->GetFrontIndexData('PAIDAP');
        $return['unpostrr'] = Yii::$app->backend->GetFrontIndexData('UNPOSTRR');
        $return['unpostsj'] = Yii::$app->backend->GetFrontIndexData('UNPOSTSJ');
        $return['allar'] = Yii::$app->backend->GetFrontIndexData('ALLAR');
        $return['allap'] = Yii::$app->backend->GetFrontIndexData('ALLAP');

        $return['sls'] = Yii::$app->backend->GetFrontIndexData('SLS');
        $return['unp'] = Yii::$app->backend->GetFrontIndexData('UNP');
        $return['center'] = Yii::$app->backend->GetFrontIndexData('CNTR');

        $arr = [];

        foreach ($return['center'] as $key => $value) {
            $arr[$value['bcode']]['name'] = $value['name'];
            $arr[$value['bcode']]['sales'] = number_format(0,2);
            $arr[$value['bcode']]['unpaid'] = number_format(0,2);
        }//end branches

        foreach ($return['sls'] as $key => $value) {
            $arr[$value['code']]['sales'] = number_format($value['amount'],2);
        }//end for each

        foreach ($return['unp'] as $key => $value) {
            $arr[$value['code']]['unpaid'] = number_format($value['amount'],2);
        }//end for each
        $return['unpaidacc']=$arr;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['value'=>$return];
        //echo json_encode(array('value'=>$return));
        
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END FNC

    public function actionMonthlyrecap(){
        $current = Yii::$app->backend->GetFrontIndexData('CYS');
        $prev = Yii::$app->backend->GetFrontIndexData('LYS');
        $llys = Yii::$app->backend->GetFrontIndexData('LLYS');

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['current'=>$current,'prev'=>$prev,'llys'=>$llys];
        //echo json_encode(array('current'=>$current,'prev'=>$prev,'llys'=>$llys));
    }//END FNC

     public function actionLoadtransgrid1(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateTransGV($params);
    }
    public function actionLoadtransgrid2(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateTrans2GV($params);
    }


    public function actionLoadschedgrid1(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateSchedGV($params);
        
    }


    public function actionLoadschedgrid2(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['now']=Yii::$app->systemsettings->getCurrentTimeStamp();
        $params['controller'] = $this;
        return Yii::$app->automator->automateSched2GV($params);
    }



    public function actionTotalschedusers(){
        $qry=Yii::$app->backend->totalusers();
        $total= Yii::$app->sbccommon->opentable($qry);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['total'=>$total];
        //echo json_encode(array('total'=>$total));
    }


    public function actionLoadunpgrid1(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateUnpGV($params);
    }

    public function actionLoadunpgrid2(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateUnp2GV($params);
    }

    public function actionListopsj(){
        $list = Yii::$app->backend->GetFrontIndexData('LTS');
        return $list;
    }//END FNC

    public function actionQuickaddclient(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;
        $returndata = Yii::$app->quickadd->quickaddClient($params);

        if(!$returndata['status']){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status'=>false,'searchid'=>''];
            //echo json_encode(['status'=>false,'searchid'=>'']);  
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status'=>true,'searchid'=>$returndata['quickaddid']];
            //echo json_encode(['status'=>true,'searchid'=>$returndata['quickaddid']]);
        }//end if
    }//end function


    public function actionGetpriceupdatedates(){
        Yii::$app->backend->AjaxVerification($this); 
        Yii::$app->systemsettings->setDefaultTimeZone();
        
        $datenow = date('Y-m-d');
        $qry = "select left(dateupdated,10) as dateupdate,count(barcode) as updates from itemamthistory 
                where month(dateupdated) >= month('".$datenow."') and month('".$datenow."') >= month('".$datenow."') - 2
                group by left(dateupdated,10) order by left(dateupdated,10) desc";
        
        $dateties = Yii::$app->sbccommon->opentable($qry); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['dates'=>$dateties];
        //echo json_encode(['dates'=>$dateties]);
    }//end if

    public function actionGetitempriceupdates(){
        Yii::$app->backend->AjaxVerification($this); 
        $clickeddate = Yii::$app->backend->sanitize($_POST['clickdate'],'DEFAULT');
        $qry = "select itemamthistory.line,itemamthistory.barcode,item.itemname,itemamthistory.dateupdated,itemamthistory.prevamt,
                itemamthistory.recentamt,itemamthistory.updatedby,itemamthistory.fieldupdate from itemamthistory
                left join item on item.barcode = itemamthistory.barcode
                where left(itemamthistory.dateupdated,10) = '".$clickeddate."' order by itemamthistory.dateupdated desc";
        
        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-priceupdates',
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                'name' => 'barcode',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'itemname',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'prevamt',
                'label' => 'Previous Amt',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'recentamt',
                'label' => 'Updated Amt',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'dateupdated',
                'label' => 'Date Updated',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'updatedby',
                'label' => 'Updated by',
                'class' => 'aimslabel col-codes'
            ]],
        ];
            
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end if

    public function actionCleardatabase(){
    try {
        $status = Yii::$app->backend->clearDatabase();
        if($status){
            echo 'Database Cleared successfully!';
        }else{
            echo "Error clearing database. Please check settings";
        }//end f
    
        
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end f

    public function actionGetdefaultuom(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $sql = "select uom,factor from uom where itemid = ". $params['q']." and factor = 1";
        $uominfo = Yii::$app->sbccommon->opentable($sql);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['uom'=>$uominfo[0]['uom'],'factor'=> $uominfo[0]['factor']];
        //echo json_encode(['uom'=>$uominfo[0]['uom'],'factor'=> $uominfo[0]['factor']]);
    }//end f

    public function actionIteminfo(){
         Yii::$app->backend->AjaxVerification($this);
        $barcode = $_GET['barcode'];
        $length = Yii::$app->systemsettings->setDefaultBarcodeLength();
        $barcode = Yii::$app->sbccommon->PadJ($barcode, $length);
        
        $sql = "select amt from item where barcode='".$barcode."'";
        $data = Yii::$app->sbccommon->opentable($sql);

        if(!empty($data)){
            $status = true;
            $amt = $data[0]['amt'];
        }else{
            $status = false;
            $amt = 0;
        }
     
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['amount'=>$amt,'status'=>$status];
        //// return json_encode($data);
        //return json_encode(array('amount'=>$amt,'status'=>$status));

    }//end act

    public function actionGetlibrary(){
        Yii::$app->backend->AjaxVerification($this); 
        $q = $_GET['q'];

        switch ($q) {
            case 'stockcard':
                $qry = "select distinct itemname as page from item";
            break;
            
            case 'agent':
                $qry = "select distinct clientname as page from client where isagent = 1";
            break;

            case 'supplier':
                $qry = "select distinct clientname as page from client where issupplier = 1";
            break;

            case 'customer':
                $qry = "select distinct clientname as page from client where iscustomer = 1";
            break;

            case 'warehouse':
                $qry = "select distinct clientname as page from client where iswarehouse = 1";
            break;
        }//end switch

        $data = Yii::$app->sbccommon->opentable($qry);

        if(empty($data)){
            $data = '';
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['dataset'=>$data];
        //echo json_encode(['dataset'=>$data]);
    }//end act



    public function actionLinexpnsmonthly(){
        Yii::$app->backend->AjaxVerification($this); 
        $qry=Yii::$app->backend->loadLinExpns();
        $expns = Yii::$app->sbccommon->opentable($qry);
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['expns'=>$expns];
        //echo json_encode(array('expns'=>$expns));
    }

    public function actionLinslsmonthly(){
        Yii::$app->backend->AjaxVerification($this); 
        $qry=Yii::$app->backend->loadLinCollect();
        $sls = Yii::$app->sbccommon->opentable($qry);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['sls'=>$sls];
        //echo json_encode(array('sls'=>$sls));
    }//end fn

    public function actionGeneratedateparameter(){
      Yii::$app->backend->AjaxVerification($this); 
      $params = $_GET; 
      $date = Yii::$app->backend->generateDateparam($params);
      Yii::$app->response->format = Response::FORMAT_JSON;
        return ['date'=>$date];
    //echo json_encode(['date'=>$date]);
    }//end f

    public function actionGetavailableinv(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;
      
      $data = Yii::$app->backend->getAvailableInventory($params);
      if(!empty($data)){
        $status = true;
      }else{
        $status = false;
      }//end if
      
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['inv'=>$data,'status'=>$status];
    //echo json_encode(['inv'=>$data,'status'=>$status]);
    }//end fn

    // WTODO JAD 05-28-2019
    public function actionLoadavailableitems() {
        Yii::$app->backend->AjaxVerification($this);
        $data = Yii::$app->sbccommon->opentable("select barcode,itemname,uom from item order by itemid");
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['data'=>$data];
        //return json_encode(array('data'=>$data));
    }

    public function actionLoaditemname() {
        Yii::$app->backend->AjaxVerification($this);
        $barcode = $_POST['barcode'];
        $trno = $_POST['trno'];
        $doc = $_POST['doc'];
        switch($doc) {
            case 'SO':
                $wh = Yii::$app->sbccommon->datareader("select wh from sohead where trno = $trno");
            break;
        }
        $item = Yii::$app->sbccommon->opentable("select barcode,itemname, uom from item where barcode = '$barcode'");
        $item[0]['wh'] = $wh;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['item'=>$item];
        //return json_encode(array('item'=>$item));
    }//end fn

    public function actionRetrieveserveddocs(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        switch ($params['doc']) {
            case 'PO':
                $qry = "select doc,trno,docno,dateid,sum(rrqty) as qty,uom from (
                        select head.doc,head.trno,head.docno,left(head.dateid,10) as dateid,stock.rrqty,stock.uom from lahead as head
                        left join lastock as stock on stock.trno=head.trno
                        where stock.refx=".$params['x']."
                        UNION ALL
                        select head.doc,head.trno,head.docno,left(head.dateid,10) as dateid,stock.rrqty,stock.uom from glhead as head
                        left join glstock as stock on stock.trno=head.trno
                        where stock.refx=".$params['x'].") as tbl
                        group by trno,uom";
            break;
        }//END SWITHC

        $params = [
            'sql' => $qry,
            'tableid' => 'serveddocs',
            'key' => 'trno', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'docno',
                    'editable' => true,
                    'type' =>'documentlink',
                    'linkdoc'=>'doc',
                    'linkparam'=>'docno',
                    'label' => 'Document #',
                    'class' => 'aimslabel col-codes'
                ],[
                    'name' => 'dateid',
                    'label' => 'Date',
                    'class' => 'aimslabel col-min'
                ],[
                    'name' => 'qty',
                    'label' => 'Served',
                    'viewtype' => 'quantity',
                    'class' => 'aimslabel col-quantity clickable viewservedrr'
                ]
            ]
        ];
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionGetavailagents(){
        try {
            Yii::$app->backend->AjaxVerification($this); 
            $params = $_GET;
            
            switch (strtolower($params['type'])) {
                case 'picker':
                    $qry = "select '' as client ,'' as clientname union all select client,clientname from client where isagent = 1 and uv_ispicker = 1 order by clientname";
                break;

                case 'checker':
                    $qry = "select '' as client ,'' as clientname union all select client,clientname from client where isagent = 1 and uv_ischecker = 1 order by clientname";
                break;
                
                default:
                    $qry = "select '' as client ,'' as clientname union all select client,clientname from client where isagent = 1 order by clientname";
                break;
            }//end swtich

            $data = Yii::$app->sbccommon->opentable($qry);

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['agents' => $data];
            //echo json_encode(['agents' => $data]);
        } catch (ErrorException $e) {
            echo $e;
        }//end swtich
    }//end fn

    public function actionGetavailbleexpiry(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;

        $qry = "select concat(rrstatus.trno,'-',rrstatus.line) as line,
                expiry,sum((bal / ".$params['factor'].")) as bal from rrstatus
                left join client as wh on wh.clientid = rrstatus.whid
                left join item on item.itemid = rrstatus.itemid
                where client = '".$params['x']."' and rrstatus.bal <> 0 
                and item.barcode = '".$params['barcode']."'
                group by rrstatus.expiry
                order by rrstatus.expiry asc";
                
        $params = [
            'sql' => $qry,
            'tableid' => 'tbl-enterqtyexpiry',
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                'label' => 'Available Expiries',
                'name' => 'expiry',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'bal',
                'class' => 'aimslabel col-codes',
                'viewtype' => 'quantity',
            ]],
        ];
            
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn

    public function actionGetlatestspc(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qry = "select concat(stock.rrcost,' (',head.docno,')') as spc
                from hspchead as head
                left join hspcstock as stock on stock.trno = head.trno
                where stock.barcode = '".$params['barcode']."'
                order by head.dateid desc
                limit 1";

        $spc = Yii::$app->sbccommon->datareader($qry);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['spc'=>$spc];
        //echo json_encode(['spc'=>$spc]);
    }//end fn

    public function actionGetprodinqdetailshead(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $qry1 = "select itemname,ifnull(uvp.name,'') as uvprincipal,sizeid as division from item
                left join uv_principal as uvp on uvp.line = item.uv_principal
                left join rrstatus on rrstatus.itemid = item.itemid
                where item.barcode = '".$params['barcode']."'";
        $data = Yii::$app->sbccommon->opentable($qry1);
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['head'=>$data];
        //echo json_encode(['head'=>$data]);
    }//end fn

    public function actionGetprodinqdetailsinv(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_POST;

        $qry2 = "select concat(rrstatus.whid,'-',rrstatus.expiry) as line,ifnull(wh.clientname,'') as wh,
                round(sum(rrstatus.bal),2) as defaultbal,round(sum(rrstatus.bal/uom.factor),2) as puombal,rrstatus.expiry
                from rrstatus
                left join item on item.itemid = rrstatus.itemid
                left join client as wh on wh.clientid = rrstatus.whid
                left join uom on uom.itemid = item.itemid and uom.uom = item.purchase_uom
                where item.barcode = '".$params['x']."' and rrstatus.bal <> 0 
                group by rrstatus.whid,rrstatus.expiry";
        
        $params = [
            'sql' => $qry2,
            'tableid' => 'tbl-quickprodinqry',
            'key' => 'line', //REQUIRED FOR EDITABLE TABLES / NOT REQUIRED FOR VIEWING TABLES
            'txtclass' => 'bodytextbox', // TABLE CLASS REQUIRED FOR DATA SERIALIZATION (EASY SAVING PER ROW)
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspView&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            
            'column' => [[
                'name' => 'wh',
                'label' => 'Warehouse',
                'class' => 'aimslabel col-desscription'
            ],[
                'name' => 'defaultbal',
                'label' => 'Default UOM Bal',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'puombal',
                'label' => 'Purchase UOM Bal',
                'class' => 'aimslabel col-codes'
            ],[
                'name' => 'expiry',
                'label' => 'Expiry',
                'class' => 'aimslabel col-codes'
            ]],
        ];
            
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end fn


    public function actionFixorigqty(){
        $data = Yii::$app->automator->automateHeadCredential('AJ','');
        
        foreach ($data as $key => $value) {
            foreach ($value as $key2 => $value2) {
              $params[$key2] = $value2;
            }//end for each
        }//emd for each

        $return1 = Yii::$app->automator->automateHeadGeneration('AJ','AJ',$params);
        
        if($return1['status']){
            $stockdata = Yii::$app->automator->automateStockCredential('AJ','');
            if(!empty($stockdata)){
                $key2 = 0;
                foreach ($stockdata as $key => $value) {
                    $a_params['q'] = $value['itemid'];
                    $a_params['whid'] = $value['whid'];
                    $a_params['expiry'] = $value['expiry'];

                    $qrycheckinv = "select ifnull(bal,0) as bal from rrstatus where itemid = " . $a_params['q'] . " 
                                    and whid = " . $a_params['whid'] . " and expiry = '" .$a_params['expiry']."'"; 

                    $iteminv = Yii::$app->sbccommon->datareader($qrycheckinv);

                    if(!$iteminv){
                        $iteminv = 0;
                    }//emmd if

                    if($iteminv != 0){
                        $stockdata[$key]['rrqty'] = floatval($stockdata[$key]['rrqty']) - $iteminv;
                    }//end if
                }//end for each

                foreach ($stockdata as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                      $params2[$key2] = $value2;
                      $params2['whcode'] = $params['wh'];
                    }//end for each

                    $last_line = Lastock::getLastLine('AJ',$return1['trno'])+1;
                    Yii::$app->automator->automateStockGeneration('AJ',$return1['trno'],$last_line,$params2);    
                }//emd for each

                $posted = Yii::$app->automator->automateTransactionPosting($return1['trno'],'AJ');
            }//end if
        }else{
            $posted = false;
        }//end if

        try {
            $dataobj = new Lastock();
            $status = false;
            $msg = '';
            $errors = 0;

            Yii::$app->backend->AjaxVerification($this); 
            $datacheck = "select stock.line,stock.trno,stock.line,item.itemname,
            stock.barcode,'' as original_qty,stock.original_qty as isqty,
            stock.uom,stock.iss,stock.isamt,stock.amt,
            stock.disc,stock.wh,stock.loc,stock.expiry,stock.ref,stock.agent,stock.rem,
            stock.refx,stock.linex,head.tax,uom.factor as uomfactor,stock.ext from lahead as head
            left join lastock as stock on stock.trno = head.trno
            left join item on item.barcode = stock.barcode
            left join uom on uom.uom = stock.uom and uom.itemid = item.itemid
            where stock.original_qty <> 0 and stock.isqty = 0 and item.itemid is not null";

            $data = Yii::$app->sbccommon->opentable($datacheck);

            $forpostingqry = "select distinct head.trno from lahead as head
                        left join lastock as stock on stock.trno = head.trno
                        left join item on item.barcode = stock.barcode
                        left join uom on uom.uom = stock.uom and uom.itemid = item.itemid
                        where stock.original_qty <> 0 and stock.isqty = 0 and item.itemid is not null";

            $fposting = Yii::$app->sbccommon->opentable($forpostingqry);

            if(!empty($data)){
                foreach ($data as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if($key2 == "ext" || $key2 == "iss" || $key2 == "amt"){
                            $return = Yii::$app->backend->computestock_Internal($data[$key]['isamt'],$data[$key]['disc'],$data[$key]['isqty'],$data[$key]['uomfactor'],'SJ',$data[$key]['tax']);
                            if($key2 == "ext"){
                                $dataobj->$key2 = str_replace(",", "",$return[$key2]);
                            }else{
                                $dataobj->$key2 = $return[$key2];
                            }//end if
                        }else{
                            if($key2 != "tax"){
                                $dataobj->$key2 = $value2;
                            }//end if
                        }//end if
                    }//end for each
                    
                    $dataobj->wh_ = $dataobj->wh;
                    $dataobj->void = 0;
                    $dataobj->kgs = 0;
                    //var_dump($dataobj);
                    Lastock::updatestocks('SJ', $data[$key]['line'], $data[$key]['trno'], $dataobj);
                }//end for each

                $checker = Yii::$app->sbccommon->opentable($datacheck);

                if(!empty($checker)){
                    $msg = "Fixing finished. End with Errors. Please try again.";    
                }else{
                    $status = true;
                    $updateorigqty = "update lastock set original_qty = 0 where original_qty <> 0";
                    Yii::$app->sbccommon->execqry($updateorigqty);
                    $msg = "Updated all original qty successfully!";
                }//end if
            }else{
                $msg = "Fixing finished. No transactions found";
            }//end fns

            if($status){
                foreach ($fposting as $key => $value) {
                    $user=Yii::$app->session['loggeduser']['username'];
                    Cntnum::PostTrans($value['trno'],'SJ',$user);
                }//end f
            }//end if

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status'=>$status,'msg'=>$msg];
            //echo json_encode(['status'=>$status,'msg'=>$msg]);   
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end fn

    public function actionCheckseries(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $poseq = $params['series'];
        $common = new Common();
        $docnolength = $common->doclength();
        $newdocno = $common->PadJ($poseq, $docnolength);

        $qry = "select docno from cntnum where docno = '".$newdocno."' and center = '".Yii::$app->session['loggeduser']['center']."'";
        $data = Yii::$app->sbccommon->opentable($qry);

        if(!empty($data)){
            $status = false;
            $docno = $data[0]['docno'];
        }else{
            $status = true;
            $docno = '';
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>$status,'docno'=>$docno];
        //echo json_encode(['status'=>$status,'docno'=>$docno]);
    }//end fn

    public function actionGetcustpricegrp(){
        try{
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;

        $clientcode = $params['customer'];

        $qry = "select class as pricegrp from client where iscustomer = 1 and client = '".$clientcode."'";
        $data = Yii::$app->sbccommon->opentable($qry);

        if(!empty($data)){
            $status = true;
            $pricegrp = $data[0]['pricegrp'];
        }else{
            $status = false;
            $pricegrp = '';
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>$status,'pricegrp'=>$pricegrp];
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end fn
}//end controller



