<?php

namespace backend\modules\fhighlights\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use yii\base\ErrorException;

class DefaultController extends Controller{

    public $access = array('view' => 12);

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
            $this->layout = "@app/views/layouts/backend/main";
         	if(isset(Yii::$app->session['loggeduser'])){
                $moduleid = $this->module->id;
                Yii::$app->view->params['moduleid'] = $moduleid;
                $highlights = Yii::$app->backend->getHighlights(2,'');
                return $this->render('index',array('moduleid'=>$moduleid,'highlights'=>$highlights));
            }else{
                return $this->redirect(Url::to(['/admin/default/login']));
            }//END IF       
        } catch (ErrorException $e) {
            echo $e;
        }//end
    }//END ACTION INDEX

    public function actionModifyhighlight(){
    try {
    	$type = Yii::$app->backend->sanitize($_GET['type'],'DEFAULT');
    	switch (strtoupper($type)) {
    		case 'NEW':
                    $params = Yii::$app->backend->sanitize($_GET['hnew'],'ARRAY');
	    			$qry = "insert into frontend_highlights(high_desc,isenabled,promostart,promoend,discount) 
                    values('".$params['highlight']."',1,'".$params['promostart']."','".$params['promoend']."','".$params['discount']."')";
	    			$status = Yii::$app->sbccommon->execqry($qry);
	    			
                    if($status){
	    				$msg = "Inserting new Highlight successfull!";
	    			}else{
	    				$msg = "Error inserting new Highlight!";
	    			}//end if
	    			echo json_encode(array('status'=>$status,'msg'=>$msg));
    			break;
    		
    		case 'EDIT':
        			$params = Yii::$app->backend->sanitize($_GET['hupdate'],'ARRAY');
                    if($params['promostart'] == ''){
                        $promostart = '0000-00-00';
                    }else{
                        $promostart = $params['promostart'];
                    }

                    if($params['promoend'] == ''){
                        $promoend = '0000-00-00';
                    }else{
                        $promoend = $params['promoend'];
                    }

                    $qry = "update frontend_highlights set high_desc = '".$params['highlight']."',isenabled = 1,promostart='".$promostart."',
                    promoend='".$promoend."',discount='".$params['discount']."' where md5(highid) = '".$params['highkey']."'";
                    
                    $status = Yii::$app->sbccommon->execqry($qry);
                    if($status){
                        $msg = "Updating highlight successfull!";
                    }else{
                        $msg = "Error updating Highlight! Please try again.";
                    }//end if
                    echo json_encode(array('status'=>$status,'msg'=>$msg));
    			break;

    		case 'RETRIEVE':
                $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
    			$highlights = Yii::$app->backend->getHighlights($params['tag'],$params['v']);
    			echo json_encode(array('highlights'=>$highlights));
    			break;

            case 'SETFEATURED':
                $params = Yii::$app->backend->sanitize($_GET,'ARRAY');

                if($params['isfeatured']){
                    $qrycheckerlimiter = "select count(highid) as count from frontend_highlights where isfeatured = 1";
                    $counterchecker = Yii::$app->sbccommon->datareader($qrycheckerlimiter);
                }else{
                    $counterchecker = 0;
                }//end if
                
                if($counterchecker == 2){
                    $status = false;
                    $msg = 'Maximum of 2 featured highlights only. Please untagged other highlights.';
                }else{
                    $qry = "update frontend_highlights set isfeatured = ".$params['isfeatured']." where md5(highid) = '".$params['q']."'";
                    $status = Yii::$app->sbccommon->execqry($qry);
                    if($status){
                        $msg = '';
                    }else{  
                        $msg = 'Error setting this highlight to featured. Please try again.';
                    }//end if
                }//ene if
                echo json_encode(array('status'=>$status,'msg'=>$msg));
                break;

            case 'HIGHLIGHT_REMOVE':
                $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
                $highlightinfo = Yii::$app->backend->retrieveHighlightInfo($params['q']);
                if($highlightinfo[0]['promostart'] <= date('Y-m-d') && $highlightinfo[0]['promoend'] >= date('Y-m-d')){
                    $status = false;
                    $msg = 'Cannot remove highlight. Highlight is still ongoing';
                }else{
                    $qrydeleteitems = "delete from frontend_highlightitems where md5(highid) = '".$params['q']."'";
                    $qrydeletehighlight = "delete from frontend_highlights where md5(highid) = '".$params['q']."'";
                    $statusitems =  Yii::$app->sbccommon->execqry($qrydeleteitems);
                    if($statusitems){
                        $statushighlight =  Yii::$app->sbccommon->execqry($qrydeletehighlight);
                        if($statushighlight){
                            $status = true;
                            $msg = 'Successfully removed highlight!';
                        }else{
                            $status = false;
                            $msg = "Error encountered while removing highlight.";
                        }//end if
                    }else{
                        $status = false;
                        $msg = "Error encountered while removing highlight items. <br> Removing highlight cancelled.";
                    }//end if
                }//end if

                echo json_encode(array('status'=>$status,'msg'=>$msg));
                break;

            case 'RETRIEVEINFO':
                $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
                $info = Yii::$app->backend->retrieveHighlightInfo($params['highkey']);
                echo json_encode(array('highinfo'=>$info));
                break;

            case 'ITEM_REMOVE':
                $params = $_GET['params'];
                $counterrors = 0;
                foreach ($params as $key => $value) {
                    $qry = "delete from frontend_highlightitems where itemid = ".$value."";
                    $status =  Yii::$app->sbccommon->execqry($qry);

                    if(!$status){
                        $counterrors = round($counterrors) + 1;
                    }//end if
                }//end if

                if($counterrors == 0){
                    $status = true;
                    $msg = 'Successfully remove selected items from this Highlight.';
                }else{
                    $status = false;
                    $msg = 'Failed to remove all selected items from this highlight. Please try again.';
                }//end if

                echo json_encode(array('status'=>$status,'msg'=>$msg));
                break;

            case 'ITEM_INSERT':
                $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
                $itemhighlights = Yii::$app->backend->checkForHighlights($params['q']);
                $conflictinghighlights = Yii::$app->backend->checkForConflictingHighlights($itemhighlights,$params);
                if($conflictinghighlights['status']){
                    $status = false;
                    $hasconflict = true;
                    $msg = 'Failed to add this item to this highlight.<br>  
                    <span style="color:black;">'.$params['highdesc'].' ['.$params['startdate'].' until '.$params['enddate'].']</span><br>
                    There are conflicting highlights:';
                }else{
                    $hasconflict = false;
                    $info = Yii::$app->backend->retrieveHighlightInfo($params['highcode']);
                    $status = Yii::$app->backend->insertItemtoHighlight($info[0]['q'],$params['q']);
                    if($status){
                        $msg = 'Item has been added to this Highlight';
                    }else{
                        $msg = 'Failed to add this item to this highlight.';
                    }//end if
                }//end if
                echo json_encode(array('status'=>$status,'msg'=>$msg,'hasconflict'=>$hasconflict,'conflictingscheds'=>$conflictinghighlights['conflicting_highlights']));
                break;
    	}//END SWITCH CASE
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end action modify highlight


    //USED BY SEARCHING OF ITEM ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionItemlookupsearch(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $searchstring = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');
            $highid = Yii::$app->backend->sanitize($_GET['additionals'],'DEFAULT');
            $searchitems = Yii::$app->backend->fHighlightItemSearch($searchstring,$highid);
            echo json_encode(array('searchitems' => $searchitems));
        } catch (ErrorException $e) {
            echo $e;
        }                                       
    }

    public function actionRetrievehighlightitems(){
        try {
            $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
            $items = Yii::$app->backend->retrieveItemsPerHighlight($params['q']);
            $highlightinfo = Yii::$app->backend->retrieveHighlightInfo($params['q']);

            foreach ($items as $key => $value) {
                $items[$key]['fhamount'] = number_format($value['fhamount'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $items[$key]['amt'] = number_format($value['amt'],Yii::$app->systemsettings->setDecimaldisplay('currency'));
                $items[$key]['fqty'] = number_format($value['fqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));
            }//end for each
            
            echo json_encode(array('hitems'=>$items));
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch
    }//end aciton 

    public function actionUploadpic(){

        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'PRIMARY_HIGHLIGHT',$params);
            $qry = "update frontend_highlights set primarypic = '".$return['dbpic']."' where md5(highid) = '".$_POST['codeid']."'";
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
            $return = Yii::$app->backend->uploadImage($files,'HIGHLIGHT_BANNER',$params);
                $qry = "update frontend_highlights set primarybanner = '".$return['dbpic']."' where md5(highid) = '".$params['codeid']."'";
                $status =  Yii::$app->sbccommon->execqry($qry);
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
      
    }//end function action upload lane banner
}///end CONTROLLER
