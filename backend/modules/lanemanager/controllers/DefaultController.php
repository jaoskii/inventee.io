<?php

namespace backend\modules\lanemanager\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\Item;
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
     	if(isset(Yii::$app->session['loggeduser'])){
            $this->layout = "@app/views/layouts/backend/main";
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;

            return $this->render('index',array('moduleid'=>$moduleid));
        }else{
            return $this->redirect(Url::to(['/admin/default/login']));
        }//END IF       
    }//END ACTION INDEX

    public function actionSavelane(){
        $params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
        $return = Yii::$app->backend->insertNewLane($params);
        echo json_encode(array('status'=>$return['status'],'msg'=>$return['msg'],'lanes'=>$return['lanes']));
    }//end function save lane

    public function actionSavesubcat(){
        $params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
        $return = Yii::$app->backend->insertNewSubcat($params);
        echo json_encode(array('status'=>$return['status'],'msg'=>$return['msg'],'subcategory'=>$return['subcategory']));
    }//end function save lane

    public function actionGetlanes(){
        $status = Yii::$app->backend->sanitize($_GET['status'],'DEFAULT');
        $lanes = Yii::$app->backend->retrieveLanes($status);
        echo json_encode(array('lanes'=>$lanes));
    }//end function 

    public function actionGetchildcategories(){
        $parent = Yii::$app->backend->sanitize($_GET['prt'],'DEFAULT');
        $type = Yii::$app->backend->sanitize($_GET['type'],'DEFAULT');
        $data = Yii::$app->backend->retrieveSubcategory($type,$parent);
        echo json_encode(array('childcat'=>$data));
    }//end action get lane child

    public function actionUploadbannerslider(){
        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'LANESLIDER',$params);

            $checking = Yii::$app->sbccommon->opentable('select bannerid from frontend_laneslider where laneid = '.$params['codeid'].' and line = '.$params['index'].'');

            if(empty($checking)){
                $qry = "insert into frontend_laneslider (laneid,strimg,line) values(".$params['codeid'].",'".$return['dbpic']."',".$params['index'].")";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }else{
                $qry = "update frontend_laneslider set strimg = '".$return['dbpic']."' where laneid = ".$params['codeid']." and line = ".$params['index']."";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }//end update or insert
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
      
    }//end function action upload lane banner


    public function actionUploadcatslider(){
         try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'CATSLIDER',$params);
            $checking = Yii::$app->sbccommon->opentable('select bannerid from frontend_catbanner where catid = '.$params['codeid'].' and line = '.$params['index'].'');
                
            if(empty($checking)){
                $qry = "insert into frontend_catbanner (catid,strimg,line) values(".$params['codeid'].",'".$return['dbpic']."',".$params['index'].")";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }else{
                $qry = "update frontend_catbanner set strimg = '".$return['dbpic']."' where catid = ".$params['codeid']." and line = ".$params['index']."";
                $status =  Yii::$app->sbccommon->execqry($qry);
            }//end update or insert
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end function action upload lane banner

    public function actionRetrievelanedetails(){
        $laneid = $_GET['keyid'];
        $featuredqry = "select frontend_laneitems.barcode,frontend_laneitems.line,img.picture as feapic from frontend_laneitems
                        left join item on item.barcode = frontend_laneitems.barcode
                        left join itimages as img on img.codeid = item.itemid
                        where frontend_laneitems.laneid =".$laneid."";
        
        $detailqry = "select navid,nav_desc,nav_tag,isenabled from frontend_lanes where navid = ".$laneid."";
        $slider = Yii::$app->backend->retrieveLaneSliders($laneid);
        $featured = Yii::$app->sbccommon->opentable($featuredqry);
        $details = Yii::$app->sbccommon->opentable($detailqry);
        echo json_encode(array('detail'=>$details,'slider'=>$slider,'featured'=>$featured));
    }//end function end lane data

    public function actionRetrievecatdetails(){
        $catid = $_GET['keyid'];

        $detailqry = "select catid,cat_desc,isparent,isenabled from frontend_categories where catid = ".$catid."";
        $slider = Yii::$app->backend->retrieveCatSliders($catid);
        $details = Yii::$app->sbccommon->opentable($detailqry);
        echo json_encode(array('detail'=>$details,'slider'=>$slider));
    }//end function end lane data


    public function actionItemlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $searchstring = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');
        $laneid = Yii::$app->backend->sanitize($_GET['additionals'],'DEFAULT');
        $sql = "select barcode,itemid,category,groupid,itemname,uom,amt from item ";       
        $keyword = explode(",", $searchstring);
        $criteria="";
          foreach($keyword as $key){
              if ($criteria == "") {
                  $criteria = " where item.f_cattagging in (select catid from frontend_lanetree where laneid = ".$laneid.") and
                                    item.isinactive <> 1 and (
                                    item.itemname LIKE '%" . $key. "%' or
                                    item.barcode LIKE '%" . $key. "%' or
                                    item.brand LIKE '%" . $key. "%' or
                                    item.model LIKE '%" . $key. "%' or
                                    item.category LIKE '%" . $key. "%' or
                                    item.groupid LIKE '%" . $key. "%' or
                                    item.sizeid LIKE '%" . $key. "%')";
              } else {
                  $criteria = $criteria . " and item.f_cattagging in (select catid from frontend_lanetree where laneid = ".$laneid.") 
                                    and item.isinactive <> 1 and " . "(
                                    item.itemname LIKE '%" . $key. "%' or
                                    item.barcode LIKE '%" . $key. "%' or
                                    item.brand LIKE '%" . $key. "%' or
                                    item.model LIKE '%" . $key. "%' or
                                    item.category LIKE '%" . $key. "%' or
                                    item.groupid LIKE '%" . $key. "%' or                                    
                                    item.sizeid LIKE '%" . $key. "%')";
              }
          } 
        $data = Yii::$app->sbccommon->opentable($sql . " " . $criteria . " order by item.itemname asc limit 50");
        echo json_encode(array('searchitems' => $data));
    }//END FUNCTION

    public function actionGetclientinfo(){
         $item = new Item;
         $itemid = $_GET['clientid'];
         $data = $item->openitem($itemid);
         echo json_encode(array('clientdata' => array('head'=>$data)));
    } // ACTION GET CLIENTINFO

    public function actionManagelane(){
        $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
        $updateqry = "update frontend_lanes set isenabled = ".$params['isenabled'].",nav_desc='".$params['lanetitle']."' where navid = ".$params['managelaneid']."";
        Yii::$app->sbccommon->execqry($updateqry);
        for ($i=1; $i <= 6; $i++) { //THIS SETS NUMBER OF LOOPS FOR UPDATING AND INSERTING
            $checkerfeatured = Yii::$app->sbccommon->opentable("select recordid from frontend_laneitems where laneid = ".$params['managelaneid']." and line=".$i."");
            if(empty($checkerfeatured)){
                $mqry = "insert into frontend_laneitems (laneid,barcode,line) 
                values(".$params['managelaneid'].",'".$params['featured'.$i]."',".$i.")";
            }else{    
                $mqry = "update frontend_laneitems set barcode = '".$params['featured'.$i]."' where laneid = ".$params['managelaneid']." and line = ".$i."";
            }//end if
        $status =  Yii::$app->sbccommon->execqry($mqry);
        }//end for each

        if($status){
            $msg = "Updating lane successful!";
        }else{
            $msg = "Updating lane failed! Please try again!";
        }//end else

        echo json_encode(array('status'=>$status,'msg'=>$msg));
        
    }//end action manage lane

    public function actionRemovelane(){
        $id = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');
        $checkerqry = "select catid from frontend_categories where nav_parent = ".$id."";
        $child = Yii::$app->sbccommon->datareader($checkerqry);
        
        if(empty($child)){
            $qry = "delete from frontend_lanes where navid = ".$id."";
            $status =  Yii::$app->sbccommon->execqry($qry);
        }else{
            $status = false;
        }//end else 

        if($status){
            $msg = "Removal successful!";
        }else{ 
            $msg = "ERLN1: Error removal please try again.";
        }//end if

        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end action action remove lane

    public function actionRemovecategory(){
        $id = Yii::$app->backend->sanitize($_GET['q'],'DEFAULT');

        $checkerqry = "select catid from frontend_categories where parent = ".$id."";
        $child = Yii::$app->sbccommon->datareader($checkerqry);

        if(empty($child)){
            $qry = "delete from frontend_categories where catid = ".$id."";
            $status =  Yii::$app->sbccommon->execqry($qry);
        }else{
            $status = false;
        }//end else 

        if($status){
            $msg = "Removal successful!";
        }else{ 
            $msg = "ERLN1: Error removal please try again.";
        }//end if

        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end action action remove lane

    public function actionUploadheaderimage(){
        try{  
            Yii::$app->backend->AjaxVerification($this);
            $params = Yii::$app->backend->sanitize($_POST,'ARRAY');
            $files = $_FILES;
            $return = Yii::$app->backend->uploadImage($files,'LANEHEADER',$params);

            $qry = "update frontend_lanes set headerpic = '".$return['dbpic']."' where navid = ".$params['codeid']."";
            
            $status =  Yii::$app->sbccommon->execqry($qry);
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch    
        echo json_encode(array('status'=>$return['status'],'picture'=>$return['src'],'errors'=>$return['errors']));
    }//end action upoload header

    public function actionRearrangelanes(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $params = $_GET['arrangement'];
            foreach ($params as $key => $value) {
                $updateqry = "update frontend_lanes set arrange_index = ".$value." where navid = ".$key."";
                Yii::$app->sbccommon->execqry($updateqry);
            }//end for each
            $msg = "Lanes rearranged!";
            echo json_encode(['status'=>1,'msg'=>$msg]);
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch
    }//end action
}//end controller

