<?php

namespace backend\modules\managedod\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{

   	//TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionVerifyaccess($accesstype,$trno){      
        Yii::$app->backend->AjaxVerification($this); 
        $return = Yii::$app->sbccontroller->jverifyaccess($this,$this->access[$accesstype],$accesstype,$trno);
        echo json_encode(array('verified'=>$return)); 
    }//end functions

    public function actionIndex(){
    try {
        //if(Yii::$app->sbccontroller->verifyaccess($this->access['view'])){
            if(isset(Yii::$app->session['loggeduser'])){
                $this->layout = "@app/views/layouts/backend/main";
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                return $this->render('index',array('moduleid'=>$moduleid));
            }else{
                    return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF
        /*}else{
            return $this->redirect(Url::to(['/admin/default/401']));
        }*/
    } catch (ErrorException $e) {
    	echo $e;
    }
    }//END ACTION INDEX

    public function actionModifydod(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
            switch ($params['type']) {
                case 'INSERT_DOD':
                    $checker = "select dod_date from frontend_dod where dod_date = '".$params['dod']."'";
                    $doditems = Yii::$app->sbccommon->datareader($checker);

                    if(!empty($doditems)){
                        //RETURNS ERROR MESSSAGE
                        $msg = "Deal for Date (".$params['dod'].") already exsist. Please check your date.";
                        $status = 0;
                    }else{
                        $dodqry = "insert into frontend_dod (dod_date) values('".$params['dod']."')";
                        $status = Yii::$app->sbccommon->execqry($dodqry);
                    }//END IF !EMPTY $DODITEMS
                    
                    if($status){
                        $status = true;
                        $msg = 'Deal for date ('.$params['dod'].') has been created successfully!';
                    }else{
                        $msg = "Error occured while adding new DOD, Please try again.";
                        $status = false;
                    }//end function

                    echo json_encode(array('status'=>$status,'msg'=>$msg));
                break;

                case 'REMOVE_DOD':
                    $qry = "delete from frontend_dod where dodid = ".$params['dod']."";
                    $status =  Yii::$app->sbccommon->execqry($qry);
                    if($status){
                        $qry = "delete from frontend_doditems where dodid = ".$params['dod']."";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                        $status = true;
                        if($status){
                            $msg = "Removal successfull!";
                        }else{
                            $mmsg = "Something went wrong while removing DOD and DOD Items.";
                        }//end if
                    }else{
                        $status = false;
                        $msg = "Error occured while removing this item from DOD, Please try again.";
                    }//end if

                    echo json_encode(array('msg'=>$msg,'status'=>$status));
                break;

                case 'REMOVE_DOD_ITEM':
                    $qry = "delete from frontend_doditems where dodid = ".$params['dod']." and md5(itemid) = '".$params['q']."'";
                    $status =  Yii::$app->sbccommon->execqry($qry);
                    if($status){
                        $status = true;
                        $msg = "Removal successfull!";
                    }else{
                        $status = false;
                        $msg = "Error occured while removing this DOD, Please try again.";
                    }//end if

                    echo json_encode(array('msg'=>$msg,'status'=>$status));
                break;
                
                case 'RETRIEVE_DODLIST':
                    $qry = "select dodid,dod_date,primarypic,primarybanner from frontend_dod where dod_date like '%".$params['dod']."%' order by dod_date desc";
                    $dodlist = Yii::$app->sbccommon->opentable($qry);
                    echo json_encode(array('dodlist'=>$dodlist));
                    break;

                case 'RETRIEVE_DOD_DETAIL':
                    $qry = "select dod.dod_date,dod.primarypic,dod.primarybanner from frontend_dod as dod where dodid = ".$params['dod']."";
                    $dodinfo = Yii::$app->sbccommon->opentable($qry);
                    echo json_encode(array('dodinfo'=>$dodinfo));
                    break;

                case 'RETRIEVE_DOD_ITEMS':
                    $qry = "select item.barcode,item.itemname,md5(item.itemid) as itemid,doditems.saleprice,
                    dod.dod_date,item.fqty from frontend_doditems as doditems
                    left join frontend_dod as dod on dod.dodid = doditems.dodid
                    left join item on item.itemid = doditems.itemid
                    where doditems.dodid = ".$params['dod']."";
                    $doditems = Yii::$app->sbccommon->opentable($qry);
                    echo json_encode(array('doditems'=>$doditems));
                    break;

                case 'INSERT_DOD_ITEM':
                    $qry = "insert into frontend_doditems (dodid,itemid,saleprice) values(".$params['dodk'].",".$params['v'].",".$params['price'].")";
                    $status =  Yii::$app->sbccommon->execqry($qry);
                    if($status){
                        $status = true;
                        $msg = "";
                    }else{
                        $status = false;
                        $msg = "Error adding this item into DOD. Please try again.";
                    }//end if

                    echo json_encode(array('msg'=>$msg,'status'=>$status));
                break;
            }//END SWITCH

        } catch (ErrorException $e) {
            echo $e;
        }
    }//end action manage dod

    public function actionUploadpic(){
        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'PRIMARY_DOD',$params);
            $qry = "update frontend_dod set primarypic = '".$return['dbpic']."' where  dodid = '".$_POST['codeid']."'";
            $status =  Yii::$app->sbccommon->execqry($qry);
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function uploading pic

    public function actionUploadbannerslider(){
        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'DOD_BANNER',$params);
                $qry = "update frontend_dod set primarybanner = '".$return['dbpic']."' where dodid = '".$params['codeid']."'";
                $status =  Yii::$app->sbccommon->execqry($qry);
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function action upload lane banner

    //USED BY SEARCHING OF ITEM ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionItemlookupsearch(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $searchstring = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');
            $dodid = Yii::$app->backend->sanitize($_GET['additionals'],'DEFAULT');
            $searchitems = Yii::$app->backend->fDODItemSearch($searchstring,$dodid);
            echo json_encode(array('searchitems' => $searchitems));
        } catch (ErrorException $e) {
            echo $e;
        }                                       
    }
}//end controller
