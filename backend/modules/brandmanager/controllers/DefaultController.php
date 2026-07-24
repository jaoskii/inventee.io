<?php

namespace backend\modules\brandmanager\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;
use yii\web\Response;

class DefaultController extends Controller{

     public $access = array('view' => 599);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        	if(isset(Yii::$app->session['loggeduser'])){
                $this->layout = "@app/views/layouts/backend/main";
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $brandlist = Yii::$app->backend->getBrand(2,'');
                return $this->render('index',array('moduleid'=>$moduleid,'brandlist'=>$brandlist));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
    }//END ACTION INDEX

    public function actionManagebrand(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        switch (strtoupper($params['type'])){
            case 'NEW':
                //CODE FOR INSERTING NEW BRAND ON EBRANDS TABLE
                $qry = "insert into frontend_ebrands (brand_desc) values('".$params['brand']."')";
                $status = Yii::$app->sbccommon->execqry($qry);
                if($status){
                    $msg = "Successfully added new brand: '".$params['brand']."'";
                }else{
                    $msg = "Error adding new brand: '".$params['brand']."'";
                }//end if 

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //echo json_encode(array('status'=>$status,'msg'=>$msg));
            break;
            
            case 'EDIT':
                //UPDATING BRAND ON EBRANDS TABLE
                $qrygetter = "select brand_desc from frontend_ebrands where md5(brandid) = '".$params['q']."'";
                $brander = Yii::$app->sbccommon->datareader($qrygetter);

                $qrychecker = "select count(itemid) as counter from item where brand = '" . $brander . "'";
                $counter = Yii::$app->sbccommon->datareader($qrychecker);

                if($counter == 0){
                    $qry = "update frontend_ebrands set brand_desc = '".$params['brand']."' where md5(brandid) = '".$params['q']."'";
                    $status = Yii::$app->sbccommon->execqry($qry);
                    
                    if($status){
                        $msg = "Successfully update brand to: '".$params['brand']."'";
                        $brdetails = Yii::$app->backend->getFBRBrandDetails($_GET['q']); 
                    }else{
                        $brdetails = '';
                        $msg = "Error updating brand to : '".$params['brand']."'";
                    }//end if 
                }else{
                    $status = false;
                    $msg = "Error updating brand, Data are connected to other modules.";
                    $brdetails = [];
                }//end if

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg,'brdetails'=>$brdetails];
                //echo json_encode(array('status'=>$status,'msg'=>$msg,'brdetails'=>$brdetails));
            break;

            case 'FENABLE':
                //FENABLE (ENABLES THIS BRAND TO BE SHOWN ON FRONTEND)
                $qry = "update frontend_ebrands set isenabled = 1 where md5(brandid) = '".$params['q']."'";
                $status = Yii::$app->sbccommon->execqry($qry);
                if($status){
                    $status = 1;
                }else{
                    $status = 0;
                }//end if 

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status];
                //echo json_encode(array('status'=>$status));
            break;

            case 'FDISABLE':
                //FENABLE (DISABLES THIS BRAND TO BE HIDDEN ON FRONTEND)
                $qry = "update frontend_ebrands set isenabled = 0 where md5(brandid) = '".$params['q']."'";
                $status = Yii::$app->sbccommon->execqry($qry);
                if($status){
                    $status = 0;
                }else{
                    $status = 1;
                }//end if 

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status];
                //echo json_encode(array('status'=>$status));
            break;

            case 'REMOVE':
            try {
                //REMOVES AND DELETES BRAND ON DATABASE
                $qrycheck="select distinct brand from item where brand='".$params['brand']."'";
                $check=Yii::$app->sbccommon->opentable($qrycheck);
                if(empty($check)){
                    $qry = "delete from frontend_ebrands where md5(brandid) = '".$params['q']."'";
                    $status = Yii::$app->sbccommon->execqry($qry);
                    if($status){
                        $msg = "Successfully removed brand: '".$params['brand']."'";
                    }else{
                        $msg = "Failed to remove brand: '".$params['brand']."'.";
                    }//end if 
                }else{
                    $status=0;
                    $msg = "Could not Delete. Brand already in use.";
                }

                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['status'=>$status,'msg'=>$msg];
                //echo json_encode(array('status'=>$status,'msg'=>$msg));
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            case 'RETRIEVE':
                $brandlist = Yii::$app->backend->getBrand($params['tag'],$params['v']);
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['brands'=>$brandlist];
                //echo json_encode(array('brands'=>$brandlist));
            break;
        }//end switch case
    }//end action managebrand


    public function actionRetrievebrdetails(){
        Yii::$app->backend->AjaxVerification($this); 
        $brdetails = Yii::$app->backend->getFBRBrandDetails($_GET['q']); 
        $brbanners = Yii::$app->backend->retrieveBrandSliders($_GET['q']);
        
        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['brdetails'=>$brdetails,'brbanners'=>$brbanners];
        //echo json_encode(array('brdetails'=>$brdetails,'brbanners'=>$brbanners));
    }//end action 

    
    public function actionUploadbrandbanner(){
         try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'BRANDSLIDER',$params);
            $checking = Yii::$app->sbccommon->opentable('select bannerid from frontend_brbanner where brandid = "'.$params['codeid'].'" and line = '.$params['index'].'');
                
            if(empty($checking)){
                $qry = "insert into frontend_brbanner (brandid,strimg,line) values('".$params['codeid']."','".$return['dbpic']."',".$params['index'].")";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }else{
                $qry = "update frontend_brbanner set strimg = '".$return['dbpic']."' where brandid = '".$params['codeid']."' and line = ".$params['index']."";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }//end update or insert
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']];
        //echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function action upload lane banner

    public function actionUploadpic(){

        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'PRIMARY_BRAND',$params);
            $qry = "update frontend_ebrands set picture = '".$return['dbpic']."' where md5(brandid) = '".$_POST['codeid']."'";
            $status =  Yii::$app->sbccommon->execqry($qry);
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    

        Yii::$app->response->format = Response::FORMAT_JSON;                    
        return ['status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']];
        //echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function uploading pic
}//end default controller
