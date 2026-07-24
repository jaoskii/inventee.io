<?php

namespace backend\modules\managefdeals\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\ErrorException;

class DefaultController extends Controller{
    
    public $access = array('itemview' => 12);

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
	    }//end try catch
    }//END ACTION INDEX

    public function actionManageflashdeal(){
	    try {
	    	$type = Yii::$app->backend->sanitize($_GET['type'],'DEFAULT');
	    	switch ($type) {
	    		case 'DELETE_FLASH_DEAL':
	    			$params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
	    			$return = Yii::$app->backend->deleteFlashDeal($params['q']);
	    			echo json_encode($return);
	    		break;

	    		case 'DELETE_FLASH_DEAL_ITEM':
	    			$params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
	    			$return = Yii::$app->backend->deleteFlashDealItem($params['q'],$params['fditem']);
	    			echo json_encode($return);
	    		break;

	    		case 'INSERT_FLASHDEAL':
	    			$params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
	    			$qry = "insert into frontend_flashdeal (startdate,enddate,discount) 
	    			values('".$params['startdate']."','".$params['enddate']."','".$params['discount']."')";
	    			$status = Yii::$app->sbccommon->execqry($qry);

	    			if($status){
	    				$status = true;
	    				$msg = "Added new flash deal successfull!";
	    			}else{	
	    				$status = false;
	    				$msg = "Error occured while setting up new Flash deal.";
	    			}//end if

	    			echo json_encode(array('status'=>$status,'msg'=>$msg));
	    			break;

	    		case 'INSERT_FLASHDEAL_ITEMS':
	    			$params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
	    			$selectqry = "select flashid from frontend_flashdeal where md5(flashid) = '".$params['fd']."'";
	    			$codeid = Yii::$app->sbccommon->datareader($selectqry);
	    			if(!empty($codeid)){
	    				$qryinsert = "insert into frontend_fdealitems (flashid,itemid,saleprice) values (".$codeid.",".$params['q'].",".$params['saleprice'].")";
	    				$status =  Yii::$app->sbccommon->execqry($qryinsert);
	    			}else{
	    				$status = false;
	    			}//end if
	    			echo json_encode(array('status'=>$status));
	    			break;
	    		
	    		case 'RETRIEVE_FLASHDEAL_LIST':
	    			$params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
	    			
	    			$qry = "select md5(flashid) as flashid,startdate,enddate,discount from frontend_flashdeal where 
	    			startdate like '%".$params['searchstring']."%' OR enddate like '%".$params['searchstring']."%' OR
	    			discount like '%".$params['searchstring']."%'";

	    			$flashdeallist = Yii::$app->sbccommon->opentable($qry);
	    			echo json_encode(array('flashdeals'=>$flashdeallist));
	    			break;

	    		case 'RETRIEVE_FLASHDEAL_DETAIL':
	    			$params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
					$qry = "select md5(flashid) as flashid,startdate,enddate,discount,primarypic,primarybanner from frontend_flashdeal where md5(flashid) = '".$params['q']."'";	    
					$flashdetails = Yii::$app->sbccommon->opentable($qry);

					$qry2 = "select item.itemid,item.itemname,item.barcode,
					round(fdealitem.saleprice,".Yii::$app->systemsettings->setDecimaldisplay('fcurrency').") as saleprice from frontend_fdealitems as fdealitem
					left join item on item.itemid = fdealitem.itemid
					where md5(fdealitem.flashid) = '".$params['q']."'";
					$flashitems = Yii::$app->sbccommon->opentable($qry2);

					echo json_encode(array('flashdetails'=>$flashdetails,'flashitems'=>$flashitems));
	    			break;
	    	}//END SWITCH CASE
	    } catch (ErrorException $e) {
	    	echo $e;
	    }//end try catch
    }//end function manageflash deal


    public function actionUploadpic(){
        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'PRIMARY_FLASHDEAL',$params);
            $selectqry = "select flashid from frontend_flashdeal where md5(flashid) = '".$_POST['codeid']."'";
            $codeid = Yii::$app->sbccommon->datareader($selectqry);
            $qry = "update frontend_flashdeal set primarypic = '".$return['dbpic']."' where flashid = '".$codeid."'";
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
            $return = Yii::$app->backend->uploadImage($files,'FLASHDEAL_BANNER',$params);
            $selectqry = "select flashid from frontend_flashdeal where md5(flashid) = '".$_POST['codeid']."'";
            $codeid = Yii::$app->sbccommon->datareader($selectqry);
            $qry = "update frontend_flashdeal set primarybanner = '".$return['dbpic']."' where flashid = '".$codeid."'";
            $status =  Yii::$app->sbccommon->execqry($qry);
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function action upload lane banner

    public function actionItemlookupsearch(){
        $searchstring = $_GET['searchstring'];
        $searchstring = Yii::$app->backend->sanitize($searchstring,'DEFAULT');
        $searchitems = Yii::$app->backend->searchItem($this,$this->access['itemview'],$searchstring);
        //var_dump($searchstring);
        echo json_encode(array('searchitems' => $searchitems));
    }

}//end controller
