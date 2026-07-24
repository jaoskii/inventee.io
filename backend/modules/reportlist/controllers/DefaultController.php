<?php

namespace backend\modules\reportlist\controllers;

use Yii;
use yii\web\Controller;
use yii\base\ErrorException;
use yii\helpers\Url;
use app\models\Webproc;
use app\models\Client;
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

    public function actionGetmodel(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateModelreplookup($params);
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
        $data = Yii::$app->backend->getReportlistParents();
        $this->layout = "@app/views/layouts/backend/main";
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',array('moduledata' => $data,'moduleid'=>$moduleid));        
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF
    }//END ACTION INDEX

    public function actionGetreportchildren(){
        $code = $_GET['code'];
        $user = Yii::$app->session['loggeduser']['access'];
        $datachild = Yii::$app->backend->getReportChildren($code);
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['child'=>$datachild,'access'=>$user];
    }//end get acctg children


    public function actionGetarealist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateArealookup($this);
    }

    public function actionGetprovincelist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateProvincelookup($this);
    }

    public function actionGetregionlist(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateRegionlookup($this);
    }


    public function actionUomlookup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = ['itemid'=>$_POST['x']];
        return Yii::$app->automator->automateUOMlookupGV($params);
    }

    public function actionGetcompanyprefix(){
        $data = Yii::$app->backend->getcompanyprefix();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['compref'=>$data];
        //echo json_encode(array('compref'=>$data));
    }//end    

    public function actionGetavailroutes(){
        Yii::$app->backend->AjaxVerification($this);
        $qry = "select route_id,route_code,route_name from route_masterfile";
        $routes = Yii::$app->sbccommon->openTable($qry);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['routes' => $routes];
        //echo json_encode(array('routes' => $routes));
    } //end action get avail routes

    public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientlookup($params);
    }

    public function actionSupplierlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierlookup($params);
    }

    public function actionCustomersupplierlookup(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $params = $_POST;
            $params['controller'] = $this;
            return Yii::$app->automator->automateCustomerSupplierlookup($params);    
        } catch (ErrorException $e) {
            echo $e;
        }
    }

    public function actionAgentlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateAgentlookup($params);
    }


    public function actionWarehouselookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateWarehouselookupGV($params);
    }


    public function actionGetclientinfo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetclientinfo($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/showmsg']));
        }else{
          Yii::$app->response->format = Response::FORMAT_JSON;
            return ['clientdata' => $return['data']];
            //echo json_encode(array('clientdata' => $return['data']));
        }               
    }    

    public function actionItemlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateItemlookupGV($params);
    }//end fn

    //WTODO: [KIM][2019.11.11][fgitemlookupsearch]
    public function actionFgitemlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateFgitemlookupGV($params);
    }//end fn

    public function actionGetcenters(){
        return Yii::$app->automator->loadCenters();
    }

    public function actionGetcostcenters(){
        $centers = Yii::$app->backend->getCostcenters();
        //var_dump($searchstring);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['centers' => $centers];
        //echo json_encode(array('centers' => $centers));
    }

    public function actionGetbrand(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateBrandlookup($params);
    }

    public function actionGetpart(){
        Yii::$app->backend->AjaxVerification($this);

        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automatePartlookup($params);
    }//end act


    public function actionGetclass(){
        Yii::$app->backend->AjaxVerification($this);
        $params['controller'] = $this;
        $params['x'] = $_POST['x'];
        return Yii::$app->automator->automateClasslookup($params);
    }//end fn

    //WTODO: [KIM][2019.10.28][getloc]
    public function actionGetloc(){
        Yii::$app->backend->AjaxVerification($this);
        $params['controller'] = $this;
        $params['x'] = $_POST['x'];
        
        return Yii::$app->automator->automateLoclookup($params);
    }//end fn

    //WTODO: [KIM][2019.10.03][getjobno]
    public function actionGetjobno(){
        Yii::$app->backend->AjaxVerification($this);
        $params['controller'] = $this;
        $params['x'] = $_POST['x'];
        return Yii::$app->automator->automateJobnolookup($params);
    }//end 

    public function actionGetbody(){
        $data = Yii::$app->backend->getBody(); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['body'=>$data];
        //echo json_encode(array('body'=>$data));
    }//end action

    public function actionGetsize(){
        $data = Yii::$app->backend->getSize(); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['size'=>$data];
        //echo json_encode(array('size'=>$data));
    }//end action

    
    public function actionGetcategory(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateCategorylookup($params);
    }

    public function actionGetcategory2(){
        $data = Yii::$app->backend->getCategory2(); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['category2'=>$data];
        //echo json_encode(array('category2'=>$data));
    }//end action

    public function actionGetassetcategory(){
        $data = Yii::$app->backend->getAssetCategory2(); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['category2'=>$data];
        //echo json_encode(array('category2'=>$data));
    }//end action

    public function actionGetgroup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateGrouplookup($params);
    }

    // WTODO JAD 06-03-2019
    public function actionGetusers() {
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateUsers();
    }


    public function actionGetprefixes(){
        $doc = $_GET['doc'];
        $data = Yii::$app->backend->getprefixes($doc); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['bref'=>$data];
        //echo json_encode(array('bref'=>$data));
    }


    public function actionGetprefgroup(){
        $data = Yii::$app->backend->getcompGroup(); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['compgroup'=>$data];
        //echo json_encode(array('compgroup'=>$data));
    }//end action

    public function actionGetyourref(){
        $searchourref=$_GET['searchstring'];
        $data = Yii::$app->backend->getyourref($searchourref); 
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['yourref'=>$data];
        //echo json_encode(array('yourref'=>$data));
    }//end action

    public function actionGetyourref2(){
            $searchyourref=$_GET['searchstring'];
            $data = Yii::$app->backend->getyourref2($searchyourref); 
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['yourref2'=>$data];
            //echo json_encode(array('yourref2'=>$data));
    }//end action

    public function actionGetourref(){
            $searchourref=$_GET['searchstring'];
            $data = Yii::$app->backend->getourref($searchourref); 
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['ourref'=>$data];
            //echo json_encode(array('ourref'=>$data));
    }//end action

    public function actionGetourref2(){
            $searchourref=$_GET['searchstring'];
            $data = Yii::$app->backend->getourref2($searchourref); 
            Yii::$app->response->format = Response::FORMAT_JSON;
        return ['ourref2'=>$data];
        //echo json_encode(array('ourref2'=>$data));
    }//end action

    public function actionContrasearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateContralookup($params);
    }

    public function actionContrabanksearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateContrabanklookup($params);
    }

    public function actionGetprincipal(){
        Yii::$app->backend->AjaxVerification($this);
        //WTODO: [KIM][2019.11.07][add params]
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automatePrincipallookup($params);
    }//end f

    public function actionGetdivision(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        return Yii::$app->automator->automateDivisionlookup($this,$params);
    }//end f

    public function actionGetuvcategory(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateUvcategorylookup($this);
    }//end f

    //WTODO JAD 06-03-2019
    public function actionEventprojectlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateEventprojectlookup($params);
    }//end fn

    //WTODO: [JLY][2019.08.17][KINGG CONCERNS][ADD GROUP FILTER]
    public function actionGetclientgroup(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientgrouplookup($params);
    }//end fn

    //WTODO: [KIM][2019.09.16][getprodtype]
    public function actionGetprodtype(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateProdtypelookup($this);
    }//end 

    //WTODO: [KIM][2019.09.17][getmaterial]
    public function actionGetmaterial(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateMateriallookup($this);
    }//end 

     public function actionLoadclasscheckbox(){
        Yii::$app->backend->AjaxVerification($this);
        
        $data = Yii::$app->sbccommon->opentable("select cl_id,cl_name from item_class");
        
        $class = "";
        $classall ="";
        $title = "CLASSIFICATION : </br>";

        $classall .= '<input type="checkbox" id="checkallclassbox" class ="class itemboxes" /> <label>MARK ALL</label></br>';

        for($i=0;$i<count ($data);$i++){
            $class .= '<input name = "cb-'.$data[$i]['cl_id'].'" value="'.$data[$i]['cl_id'].'" style="margin-right:5px;" class ="class itemboxes repsons repobj mlcpcheckboxclass customer-checkboxclass"  type="checkbox">&nbsp 
                       <label class="repsons repobj customer-checkboxclass aimslabel">'.$data[$i]['cl_name'].' </label></br>';
            
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['classcheckbox'=>$class, 'classtitle'=>$title, 'classall'=>$classall];
        //echo json_encode(array('classcheckbox'=>$class, 'classtitle'=>$title, 'classall'=>$classall));
        
    }//end

    public function actionGetdepartment(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateDepartmentlookup($params);
    }//end action
}//END CONTROLLER



