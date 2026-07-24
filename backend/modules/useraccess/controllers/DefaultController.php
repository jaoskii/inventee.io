<?php

namespace backend\modules\useraccess\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

use app\models\Center;
use app\models\Users;
use yii\base\ErrorException;

use yii\web\Response;
class DefaultController extends Controller{

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(isset(Yii::$app->session['loggeduser'])){
          if(Yii::$app->session['loggeduser']['access'][362] == 1){
              $this->layout = "@app/views/layouts/backend/main";
              $data = Yii::$app->backend->getuserlevels();
              $data2 = Yii::$app->backend->getfirstlevel();
              $moduleid = $this->module->id;
              Yii::$app->view->params['moduleid'] = $moduleid;
              return $this->render('index',array('usersdata' => $data,'moduledata' => $data2,'moduleid'=>$moduleid));
          }else{
              return $this->redirect(Url::to(['/admin/default/401']));
          }//emd if
        }else{
          return $this->redirect(Url::to(['/admin/default/login']));
        }//end if
    }//END ACTION INDEX

    public function actionRequestuserlevels(){
      $data = Yii::$app->backend->getuserlevels();
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['usersdata' => $data];
      //echo json_encode(array('usersdata' => $data));
    }//END ACTION REQUEST USERS


    public function actionGetidno(){   
        $id = $_GET['id'];
        $moduleid = $this->module->id;
        $data = Yii::$app->backend->getuseraccess($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['usersdata' => $data];
        //echo json_encode(array('usersdata' => $data));
       // var_dump($data);
    }//END ACTION INDEX

    public function actionGetsecondlevel(){   
        $code = $_GET['code'];
        $attribute = $_GET['attribute'];
        $moduleid = $this->module->id;
        $data = Yii::$app->backend->getsecondlevel($code);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['seconddata' => $data];
        //echo json_encode(array('seconddata' => $data));
      // var_dump($data);
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


    public function actionSetallowed(){   
        $code = $_GET['code'];
        $idno = $_GET['idno'];
        $attribute = $_GET['attribute'];
        $moduleid = $this->module->id;

        $user = new Users();
        $first='';
        $second='';
        $data='';
        $data2='';
        $acno='';
        $left=0;
        $right=0;

        $accessname = Yii::$app->sbccommon->opentable("select description from attributes where attribute='$attribute'");
        $users = Yii::$app->session['loggeduser']['username'];
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
       
        $first=$user->getFirstLevel($code); 
 
        $moduleAttribute=$user->getmoduleattribute(md5($code));
        Yii::$app->sbccommon->execqry("insert into moduleaccess(idno,attribute)values('$idno','$attribute')");
        
        if($moduleAttribute!=0){
            $left = $moduleAttribute-1;
            $right = $moduleAttribute+1;
            $status = Yii::$app->sbccommon->execqry("update users set attributes = concat(left(attributes,$left), '1',
            substr(attributes,$right,length(attributes))),editby='$users',editdate='$current_timestamp'  where idno='$idno'");                     
          }else{
            $status = Yii::$app->sbccommon->execqry("update users set attributes = concat('1',
            substr(attributes,1,length(attributes))),editby='$users',editdate='$current_timestamp'  where idno='$idno'");
        }//end if module attributes

        if($status){
          $return =  Yii::$app->sbccommon->execqry("insert into useraccess_log(trno,field,oldversion,userid,dateid) 
                    values('$idno','USERACCESS',concat('Update Access for `". $accessname[0]['description']."` - ',
                    'Not Allow',' to Allow'),'$users','$current_timestamp')");
        }else{
          $return =  Yii::$app->sbccommon->execqry("insert into useraccess_log(trno,field,oldversion,userid,dateid)
                  values('$idno','USERACCESS',concat('Update Failed for `".$accessname[0]['description']."` - ',
                  'Not Allow',' to Allow'),'$users','$current_timestamp')");
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => $status];
        //echo json_encode(array('status' => $status));
    }//END ACTION INDEX

    public function actionSetnotallowed(){   
        $code = $_GET['code'];
        $idno = $_GET['idno'];
        $attribute = $_GET['attribute'];
        $moduleid = $this->module->id;

        $user = new Users();
        $first='';
        $second='';
        $third='';
        $fourth='';
        $acno='';
        $left=0;
        $right=0;

        $first=$user->getFirstLevel($code);  
        $notallow = Yii::$app->backend->getthirdlevelsallow($idno,$code);
         
        $accessname = Yii::$app->sbccommon->opentable("select description from attributes where  attribute='$attribute'");
        $user = Yii::$app->session['loggeduser']['username'];

        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
          
        if(!empty($notallow)){
          for($i=0;$i<count($notallow);$i++){     
             Yii::$app->sbccommon->execqry("delete from moduleaccess where idno='$idno' and attribute='$attribute'");
             if($attribute!=0){
             $left = $attribute-1;
             $right = $attribute+1;
              $status = Yii::$app->sbccommon->execqry("update users set attributes = concat(left(attributes,$left), '0',substr(attributes,$right,length(attributes))),editby='$user',editdate='$current_timestamp'  where idno='$idno'");                     
             }else{
            $status = Yii::$app->sbccommon->execqry("update users set attributes = concat('1',substr(attributes,0,length(attributes))),editby='$user',editdate='$current_timestamp'  where idno='$idno'");
             }                           
          }//end for loop
        }//end if not empty

      
        if($status){
          $return=  Yii::$app->sbccommon->execqry("insert into useraccess_log(trno,field,oldversion,userid,dateid) 
          values('$idno','USERACCESS',concat('Update Access for `". $accessname[0]['description']."` - ','Allow',' to Not Allow'),'$user','$current_timestamp')");
        }else{
          $return= Yii::$app->sbccommon->execqry("insert into useraccess_log(trno,field,oldversion,userid,dateid) 
          values('$idno','USERACCESS',concat('Update Failed for `".$accessname[0]['description']."` - ','Allow',' to Not Allow'),'$user','$current_timestamp')");
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => $status];
        //echo json_encode(array('status' => $status));
    }//END ACTION INDEX


      public function actionInsertlevel(){   
          $moduleid = $this->module->id;
          $user = $_GET['user'];
          $checker = Yii::$app->sbccommon->opentable("select username from users where username = '".$user."'");
          if(empty($checker)){
            $attr = "";
            $attr = str_pad($attr, 6000, 0, STR_PAD_LEFT);
            $return = Yii::$app->sbccommon->execqry("insert into users (username,attributes,editdate,viewdate) VALUES ('$user','$attr','00-00-00','00-00-00')");
            if($return){
              $msg = "Userlevel added successfully!";
            }else{
              $msg = "Failed to add level please try again.";
            }
          }else{
            $return = 0;
            $msg = "Name of level already in use , Please choose another.";
          }
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ['status' => $return,'msg'=>$msg];
          //echo json_encode(array('status' => $return,'msg'=>$msg));
      }//END ACTION INDEX


      public function actionDeletelevel(){   
        $moduleid = $this->module->id;
        $idno = $_GET['idno'];
        $qry = "select count(userid) as usercount from useraccess where accessid=".$idno;
        $accounts = Yii::$app->sbccommon->datareader($qry);
          if(!empty($accounts)){
             Yii::$app->response->format = Response::FORMAT_JSON;
            return ['userslevel' => '','status'=>0,'msg'=>'Kindly remove all users first before removing this group.'];
            //echo json_encode(array('userslevel' => '','status'=>0,'msg'=>'Kindly remove all users first before removing this group.'));
          }else{
            Yii::$app->sbccommon->execqry("delete from users where idno='$idno'");
            $data2 = Yii::$app->backend->getuserlevels();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['userslevel' => $data2,'status'=>1,'msg'=>'User group deleted successfully!'];
            //echo json_encode(array('userslevel' => $data2,'status'=>1,'msg'=>'User group deleted successfully!'));
          }
      }//END ACTION INDEX

    public function actionInsertuseraccess(){   
        $moduleid = $this->module->id;
        $username = Yii::$app->backend->sanitize($_POST['username'],'DEFAULT');
        $password = Yii::$app->backend->sanitize($_POST['password'],'DEFAULT');
        $adminpass = Yii::$app->backend->sanitize($_POST['adminpass'],'DEFAULT');
        $supplier = Yii::$app->backend->sanitize($_POST['supplier'],'DEFAULT');
        
        $username = str_replace (" ","",$username);
        $password = str_replace (" ","",$password);
        $adminpass = str_replace (" ","",$adminpass);
        $supplier = str_replace (" ","",$supplier);

        $params = array('idno'=>$_POST['idno'],'pwd'=>$password,
          'user'=>$username,'name'=>$_POST['name'],
          'encrpt'=>md5(md5($_POST['password'])),
          'adminpassenc'=>md5(md5($adminpass)),'adminpass'=>$adminpass,
          'isinactive'=>$_POST['isinactive'],
          'usertime'=>$_POST['usertime'],'starttime'=>$_POST['starttime'],
          'endtime'=>$_POST['endtime'],'supplier'=>$_POST['supplier']);

        $checker = Yii::$app->sbccommon->opentable("select username from useraccess where username = '".$params['user']."'");

        if(empty($checker)){
          $status = Yii::$app->sbccommon->execqry("INSERT into useraccess (accessid,username,password,name,pwd,position,createby,editby,viewby,
          administrator_pass,administrator_enc,isinactive,istime,starttime,endtime,supplier)
          values(".$params['idno'].",'".$params['user']."','".$params['encrpt']."','".$params['name']."','".$params['pwd']."','',
          '".Yii::$app->session['loggeduser']['username']."','','','".$params['adminpass']."','".$params['adminpassenc']."',
          ".$params['isinactive'].",".$params['usertime'].",'".$params['starttime']."','".$params['endtime']."','".$params['supplier']."')");

          if($status){
            $data = Yii::$app->backend->getuseraccess($params['idno']);
            $msg = "Adding user successfully!";
          }else{
            $data = '';
            $msg = "Failed to add new user , please try again.";
          }

        }else{
          $data = '';
          $status = 0;
          $msg = "Username already in use , Please choose another!";
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['usersdata'=>$data,'status'=>$status,'msg'=>$msg];
        //echo json_encode(array('usersdata'=>$data,'status'=>$status,'msg'=>$msg));
    }//END ACTION INDEX


    public function actionDeleteuseraccess(){   
      $moduleid = $this->module->id;
      $id = $_GET['id'];
      $idno = $_GET['idno'];
      $checker = Yii::$app->sbccommon->datareader("select ifnull(client.client,'') as client from useraccess 
                                                  left join client on client.client = useraccess.supplier 
                                                  where useraccess.userid='".$id."' limit 1");
      if($checker == ""){
        Yii::$app->sbccommon->execqry("DELETE from useraccess where userid='$id'");
        $data = Yii::$app->backend->getuseraccess($idno);
        $status = true;
        $msg = 'Delete Successfully';
      }else{
        $data = '';
        $status = false;
        $msg='This User Access was Link to Supplier';
      }//end if
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['usersdata' => $data,'status'=>$status,'msg'=>$msg];
      //echo json_encode(array('usersdata' => $data,'status'=>$status,'msg'=>$msg));
    }//END ACTION INDEX

    public function actionEdituseraccess(){   
        $moduleid = $this->module->id;
        $id = $_GET['id'];
        $data = Yii::$app->backend->getuser1($id);
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['usersdata'=>$data[0]];
      //echo json_encode(array('usersdata'=>$data[0]));
    }//END ACTION INDEX

    public function actionUpdateuseraccess(){   
        $moduleid = $this->module->id;
        $username = Yii::$app->backend->sanitize($_POST['username'],'DEFAULT');
        $password = Yii::$app->backend->sanitize($_POST['password'],'DEFAULT');
        $adminpass = Yii::$app->backend->sanitize($_POST['adminpass'],'DEFAULT');
        $supplier = Yii::$app->backend->sanitize($_POST['supplier'],'DEFAULT');


        $username = str_replace (" ","",$username);
        $password = str_replace (" ","",$password);
        $adminpass = str_replace (" ","",$adminpass);
        $supplier = str_replace (" ","",$supplier);

        $idno = $_POST['idno'];
        $params = array('id'=>$_POST['userid'],'pwd'=>$password,'user'=>$username,
        'name'=>$_POST['name'],'encrpt'=>md5(md5($password)),'adminpassenc'=>md5(md5($_POST['adminpass'])),
        'adminpass'=>$adminpass,'isinactive'=>$_POST['isinactive'],'usertime'=>$_POST['usertime'],
        'starttime'=>$_POST['starttime'],'endtime'=>$_POST['endtime'], 'supplier'=>$_POST['supplier']);
        $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();

        $status = Yii::$app->sbccommon->execqry("UPDATE useraccess set username='".$params['user']."',
        pwd='".$params['pwd']."',password='".$params['encrpt']."',name='".$params['name']."',
        editdate='".$current_timestamp."',editby='".Yii::$app->session['loggeduser']['username']."',
        administrator_pass = '".$params['adminpass']."',
        administrator_enc = '".$params['adminpassenc']."',isinactive = ".$params['isinactive'].",
        istime = ".$params['usertime'].",starttime='".$params['starttime']."',endtime='".$params['endtime']."',
        supplier='".$params['supplier']."' where userid=".$params['id']."");

        if($status){
          $data = Yii::$app->backend->getuseraccess($idno);
          $msg = "User updated successfully!"; 
        }else{
          $data = '';
          $msg = "Failed to update user , please try again."; 
        }//end if

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['usersdata'=>$data,'status'=>$status,'msg'=>$msg];
        //echo json_encode(array('usersdata'=>$data,'status'=>$status,'msg'=>$msg));
    }//END ACTION INDEX

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
                    $checking = Yii::$app->sbccommon->opentable('select codeid from itimages where codeid = "'.$primarykey.'" and filename = "USER"');
                    if(empty($checking)){
                        $qry = "insert into itimages (codeid,picture,filename) values('".$primarykey."','".$base64."','USER')";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }else{
                        $qry = "update itimages set picture = '".$base64."' where codeid = '".$primarykey."' and filename = 'USER'";
                        $status =  Yii::$app->sbccommon->execqry($qry);
                    }//end update or insert
                }//end else for file_size validation
            }//end else for extension validation

            if($status){
                $data = Yii::$app->sbccommon->opentable('select picture from itimages where codeid = "'.$primarykey.'" and filename ="USER"');
                $picture = $data[0]['picture'];
            }//end status if
            
            $prevsession = Yii::$app->session['loggeduser'];
            $prevsession['pic'] = $picture;
            Yii::$app->session['loggeduser'] = $prevsession;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status'=>$status,'picture'=>$picture,'error'=>$errors];
            //echo json_encode(array('status'=>$status,'picture'=>$picture,'error'=>$errors));
        }//end if isset
    }//end function uploading pic

    public function actionSupplierlookupsearch(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      $params['controller'] = $this;
      return Yii::$app->automator->automateSupplierlookup($params);
    }//end if

    public function actionLog(){
      Yii::$app->backend->AjaxVerification($this);
      $params = $_POST;
      return Yii::$app->automator->automateLog($this,$params);
    }//end function

    public function actionUnivcreateagent(){
      try {
      Yii::$app->backend->AjaxVerification($this);
      $params = $_GET;

      //CHECKER
      $qry_checker = "select client from client where client = '".$params['username']."'";
      $data = Yii::$app->sbccommon->opentable($qry_checker);

      if(!empty($data)){
        $params['username'] = substr($params['username'], 0,2) . ltrim(substr($params['username'], 3,15),0);
        $qry_checker2 = "select username from useraccess where username = '".$params['username']."'";
        $data2 = Yii::$app->sbccommon->opentable($qry_checker2);        
        
        if(empty($data2)){
          $qry_insert = "insert into useraccess (accessid,username,`password`,name,pwd,administrator_pass,administrator_enc,isinactive) 
                        values ('110','".$params['username']."','".md5(md5($params['password']))."','".$params['name']."','".$params['password']."','','',0)";

          $status = Yii::$app->sbccommon->execqry($qry_insert);

          if($status){
            $msg = "Successfully created user for agent <b>[".$params['username']."]</b>.";
          }else{
            $msg = "<b>[Error UA103]:</b> Error occured while creating user for this agent. Please try again.";
            $status = false;
          }//end if
        }else{
          $msg = "<b>[Error UA102]:</b> Agent already has account on User List. Please try again.";
          $status = false;
        }//end if
      }else{
        $msg = "<b>[Error UA101]:</b> Not valid agentcode. Please try again.";
        $status = false;
      }//end if

      Yii::$app->response->format = Response::FORMAT_JSON;
      return ['status'=>$status,'msg'=>$msg];
      //echo json_encode(['status'=>$status,'msg'=>$msg]);

        
      } catch (ErrorException $e) {
        echo $e;
      }
    }//end action
}//END CONTROLLER