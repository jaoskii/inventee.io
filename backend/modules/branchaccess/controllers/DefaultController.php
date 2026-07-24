<?php

namespace backend\modules\branchaccess\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Center;
use app\models\Users;

use yii\web\Response;
class DefaultController extends Controller{

    public $access = array('view' => 651);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        $this->layout = "@app/views/layouts/backend/main";
        $data = Yii::$app->backend->getuserlevels();
        $data2 = Yii::$app->backend->getfirstlevel();
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        return $this->render('index',array('usersdata' => $data,'moduledata' => $data2,'moduleid'=>$moduleid));
    }//END ACTION INDEX


    public function actionRequestuserlevels(){
      $data = Yii::$app->backend->getuserlevels();
      Yii::$app->response->format = Response::FORMAT_JSON;
    return ['usersdata' => $data];
    //echo json_encode(array('usersdata' => $data));
    }//END ACTION REQUEST USERS

    public function actionGetuserlevel(){   
        $id = $_GET['id'];
         $moduleid = $this->module->id;
         $data = Yii::$app->sbccommon->opentable("select * from useraccess where accessid='$id'");
         Yii::$app->response->format = Response::FORMAT_JSON;
            return ['usersdata' => $data];
            echo json_encode(array('usersdata' => $data));
    }//END ACTION INDEX



        public function actionGetthirdlevel(){   
        $code = $_GET['code'];
        $attribute = $_GET['attribute'];
        $idno = $_GET['idno'];
        $moduleid = $this->module->id;
        $data = Yii::$app->backend->getthirdlevelsallow($idno,$code);
        $data2 = Yii::$app->backend->getthirdlevelsnotallow($idno,$code);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['allowmodules' => $data,'notallowmodules' => $data2];
        //echo json_encode(array('allowmodules' => $data,'notallowmodules' => $data2));
    }//END ACTION INDEX


    public function actionGetallowedcenter(){   
        $idno = $_GET['idno'];
        $userid = $_GET['userid'];
        $accessid = $_GET['accessid'];
        $moduleid = $this->module->id;
        $data = Yii::$app->sbccommon->opentable("select userid,center.line, code, center.name, address, tel, warehouse from center
												left join centeraccess on centeraccess.center=center.code
												where userid='$userid'");
        $data2 = Yii::$app->sbccommon->opentable("select center.line, code, center.name, address, tel, warehouse from center where code not in (select code from center left join centeraccess on centeraccess.center=center.code
                                                    where userid='$userid')");
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['allowmodules' => $data,'notallowmodules' => $data2];
        //echo json_encode(array('allowmodules' => $data,'notallowmodules' => $data2));
        // var_dump($data2);
    }//END ACTION INDEX 

    public function actionSetnotallowed(){   
        $center = $_GET['code'];
        $userid = $_GET['userid'];
        $line = $_GET['line'];
        $code = $_GET['code'];

        $center_code= Yii::$app->sbccommon->opentable("select code from center where code='$center'");
        $user= Yii::$app->sbccommon->opentable("select userid,name from useraccess where userid='$userid'");
        $add=false;
            
            if(!empty($user))
            {
            $allowed=Yii::$app->sbccommon->opentable("select userid,center.line, code, center.name, address, tel, warehouse from center
												 left join centeraccess on centeraccess.center=center.code
												 where userid='$userid'");
                if(!empty($allowed))
                {
                        for($i=0;$i<count($allowed);$i++)
                        {
                        	
                           if($center_code!=$center)
                                {
                                Yii::$app->sbccommon->execqry("delete from centeraccess where center='$center' and userid='$userid'");
                                }
                            else
                                {
                                	$add=false;
                                }
                        }
                }

            }

       Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => ''];
        //echo json_encode(array('status' => ''));
    }//END ACTION INDEX   

    public function actionSetallowed(){   
        $center = $_GET['code'];
        $userid = $_GET['userid'];
        $line = $_GET['line'];
        $code = $_GET['code'];

        $center_code= Yii::$app->sbccommon->opentable("select code from center where code='$center'");
        $user= Yii::$app->sbccommon->opentable("select userid,name from useraccess where userid='$userid'");
        $add=false;
            
            if(!empty($user)){
                $allowed=Yii::$app->sbccommon->opentable("select userid,center.line, code, center.name, address, tel, warehouse from center
												//  left join centeraccess on centeraccess.center=center.code
												//  where userid='$userid'");
                if(!empty($allowed)){
               
                for($i=0;$i<count($allowed);$i++){
                    if($center_code!=$allowed[$i]['code'])
                        {
                        $add=true;
                        } else {
                    $add=false;
                    }
                }
                    }
                    else{$add=true;}
	                if($add){
	                   $id=$user[0]['userid'];
	                    $name=$user[0]['name'];
	                    Yii::$app->sbccommon->execqry("insert into centeraccess (center, userid, name) values('$center','$userid','$name')");
	                }
                }

       Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => ''];
        //echo json_encode(array('status' => ''));
    }//END ACTION INDEX  
}
