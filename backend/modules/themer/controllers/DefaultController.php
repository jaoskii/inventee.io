<?php

namespace backend\modules\themer\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

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

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $this->layout = "@app/views/layouts/backend/main";
        $return = Yii::$app->backend->retrieveThemes();
        return $this->render('index',array('moduleid'=>$moduleid,'themes'=>$return));
    }

    public function actionSetusertheme(){
        $themecode = $_GET['code'];
        $userid = Yii::$app->session['loggeduser']['userid'];
        $checkqry = "select themecode from user_themer where userid =".$userid."";
        $check = Yii::$app->sbccommon->datareader($checkqry);

        if(!empty($check)){
            $updateqry = "update user_themer set themecode = '".$themecode."' where userid = ".$userid."";
        }else{
            $updateqry = "insert into user_themer (userid,themecode) values (".$userid.",'".$themecode."')";
        }//check
        $currentdata = Yii::$app->session['loggeduser'];
        $currentdata['theme'] = $themecode;
        Yii::$app->session['loggeduser'] = $currentdata;
        Yii::$app->sbccommon->execqry($updateqry);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status'=>true];
        //echo json_encode(array('status'=>true));
    }//end

    public function actionUploadpic(){
        Yii::$app->backend->AjaxVerification($this);
        if(isset($_FILES['image'])){
            $errors="";
            $picture = "";
            $file_name =$_FILES['image']['name'];
            $file_tmp= $_FILES['image']['tmp_name'];
            $file_size=$_FILES['image']['size'];
            $filearray = explode('.',$file_name);
            $file_ext = strtolower(end($filearray));
            $allowed_ext= array('jpg','jpeg','png');

            if(!in_array($file_ext,$allowed_ext)){
                $errors='Extension not allowed , allowed file extensions are (jpg,jpeg,png)';
                $status = 0;
            }else{
                if($file_size > 2097152){
                $errors = 'File size must be under 2mb';
                $status = 0;
                }else{                    
                    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
                    $data = file_get_contents($file_tmp);
                    $primarykey = $_POST['codeid'];
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); //STRING TO BE SAVED TO DATABASE
                    $checking = Yii::$app->sbccommon->opentable('select codeid from itimages where codeid = "'.$primarykey.'"');
                    if(empty($checking)){
                        $qry = "insert into itimages (codeid,picture,filename) values('0','".$base64."','WALLPAPER')";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }else{
                        $qry = "update itimages set picture = '".$base64."' where codeid = '".$primarykey."'";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }//end update or insert
                }//end else for file_size validation
            }//end else for extension validation

            if($status){
                $data = Yii::$app->sbccommon->opentable('select picture from itimages where codeid = "'.$primarykey.'"');
                $picture = $data[0]['picture'];
            }//end status if

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status'=>$status,'picture'=>$picture,'error'=>$errors];
            //echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end function uploading pic
}//end controller


