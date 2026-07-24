<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;
use app\models\UserAccess;
use app\models\Users;
use app\models\Common;
use app\models\Center;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $king_branch; //exclusive var for king george
    public $rememberMe = true;
    public $_user;

    public $ERR_MSG;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            /*['password', 'validatePassword'],*/
        ];
    }



    public function login(){
        //if validate password returns false
        if($this->validatePassword()){
        //IF VALIDATE PASSWORDS RETURNS TRUE
            $this->setCredentials();
            return true;
        }else{
            return false;
        }
    }//END LOGIN

    
/*    public function getUser(){
    $useraccess = new Useraccess;
    $this->_user = $useraccess->getUserAcc($this->username,$this->password);
    return $this->_user;
    }//END GETUSER*/

    
    public function validatePassword(){
            $useraccess = new Useraccess;
            $this->_user = $useraccess->getUserAcc($this->username,$this->password);
            //TODO : DAPAT PAG FAILED lang
            $useraccess->logAttempUser($this->username, $this->password);

            if($this->_user != null){
                //DOUBLE CHECKING IF TYPE PASS AND USERNAME IS EQUAL TO THE DATA RETRIEVED
                if($this->username == $this->_user['username'] && $this->password == $this->_user['pwd']){
                    $this->ERR_MSG = "";
                    return true;
                }else{
                    $this->ERR_MSG = "Username or Password is incorrect!";
                    return false;
                }//END IF ELSE
            }else{
                $this->ERR_MSG = "Username or Password is incorrect!";
                return false;
            }//end if else
    }//END VALIDATE

    public function setCredentials(){
        //SETS LOGGED USER SESSION
        $users = new Users;
        $role= $users->getrole($this->_user['accessid']);
        $costaccess = Yii::$app->backend->viewcostAccess();
        Yii::$app->session['loggeduser'] = [
        'create' => $this->_user['createdate'],
        'usergrp' => $this->_user['usergroup'],
        'username' => $this->_user['username'],
        'userid' => $this->_user['userid'],
        'pic' => $this->_user['picture'],
        'name' => $this->_user['name'],
        'theme' => $this->_user['themecode'],
        'access' => '0'.$role['attributes'],
        'branch_access'=> Yii::$app->systemsettings->setBranchAccess(),
        'isReadonly' => true,
        'viewcost' => $costaccess,
        'useDefaultClient' => false,
        'DclientCode' => '000000000000000',
        'DclientName' => 'Walk-In',
        'branches' => '1',
        'defaultitemprice' => 'client',
        'center' => '',
        'centername' => '',
        'centeradd' => '',
        'centertel' => '',
        'whcode' => '',
        'whname' => '',
        'centerprice' => '',
        'centercomm' => '',
        'centericomm' => ''];
        //SETS LEFT MENU SESSION
        $this->createmenu();
        Yii::$app->session['layoutminimized'] = false;
    }//END SET CRED

    
    public function createmenu(){
        Yii::$app->systemsettings->systemMenuSetup();
        
        $left_menu=Yii::$app->sbccommon->opentable("select menu.ismodalmenu,menu.modalclass,parent.id,parent.name,parent.class as pclass,
        parent.doc as pdoc,menu.doc,menu.url,menu.module,menu.class as mclass,menu.access from left_parent as parent 
        left join left_menu as menu on menu.parent_id=parent.id 
        order by parent.seq,menu.id");
        
        $i = 0;
        
        foreach ($left_menu as $itmindex => $itmdata) {
            if(isset(Yii::$app->session['menu'])){
                if(empty(Yii::$app->session['menu'])){
                   Yii::$app->session['menu'] =[ $i => array('name'=>$itmdata['name'],'pclass'=>$itmdata['pclass'],'pdoc'=>$itmdata['pdoc'],'doc'=>$itmdata['doc'],'url'=>$itmdata['url'],'module'=>$itmdata['module'],'mclass'=>$itmdata['mclass'],'access'=>$itmdata['access'],'ismodalmenu'=>$itmdata['ismodalmenu'],'modalclass'=>$itmdata['modalclass'])];
                }else{
                $newmenu = array('name'=>$itmdata['name'],'pclass'=>$itmdata['pclass'],'pdoc'=>$itmdata['pdoc'],'doc'=>$itmdata['doc'],'url'=>$itmdata['url'],'module'=>$itmdata['module'],'mclass'=>$itmdata['mclass'],'access'=>$itmdata['access'],'ismodalmenu'=>$itmdata['ismodalmenu'],'modalclass'=>$itmdata['modalclass']);
                Yii::$app->session['menu'] = array_merge(Yii::$app->session['menu'], [$i => $newmenu]);

                }//end if(empty(Yii::$app->session['menu'])){
            }else{
               Yii::$app->session['menu'] = [$i => array('name'=>$itmdata['name'],'pclass'=>$itmdata['pclass'],'pdoc'=>$itmdata['pdoc'],'doc'=>$itmdata['doc'],'url'=>$itmdata['url'],'module'=>$itmdata['module'],'mclass'=>$itmdata['mclass'],'access'=>$itmdata['access'],'ismodalmenu'=>$itmdata['ismodalmenu'],'modalclass'=>$itmdata['modalclass'])];
            }//if(isset(Yii::$app->session['menu'])){

            $i=$i+1;
        }//end for each
    }//end createmenu


    public function isLogged(){
        if (isset(Yii::$app->session['loggeduser'])){
            if(Yii::$app->session['loggeduser']['center'] ==""){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }//end if is Logged

    public function updateCredentials($center){
        $center_=Center::checkcenter($center);
        $lastsetcredentials = Yii::$app->session['loggeduser'];
        $lastsetcredentials['center'] = $center_['code'];
        $lastsetcredentials['centername'] = $center_['name'];
        $lastsetcredentials['centeradd'] = $center_['address'];
        $lastsetcredentials['centertel'] = $center_['tel'];
        Yii::$app->session['loggeduser'] = $lastsetcredentials;

        $defaultwh=Common::defaultwarehouse();
        $lastsetcredentials = Yii::$app->session['loggeduser'];
        $lastsetcredentials['whcode'] = $defaultwh['warehouse'];
        $lastsetcredentials['whname'] = $defaultwh['warehousename'];
        $lastsetcredentials['centerprice'] = $defaultwh['sellingprice'];
        $lastsetcredentials['centercomm'] = $defaultwh['commission'];
        $lastsetcredentials['centericomm'] = $defaultwh['icommission'];

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $king_data = Yii::$app->backend->king_VerifyBranch($this->king_branch);
                $lastsetcredentials['king_branch'] = $king_data['king_branch'];
                $lastsetcredentials['king_branchname'] = $king_data['king_branchname'];
            break;
        }//END SWITCH

        //UPDATES SESSION WITH DEFAULT WAREHOUSE AND CENTER;        
        Yii::$app->session['loggeduser'] = $lastsetcredentials;
        return true;
    }

    public function getError(){
        return $this->ERR_MSG;
    }
}
