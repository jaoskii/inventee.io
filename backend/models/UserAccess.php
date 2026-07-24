<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\base\NotSupportedException;
use yii\helpers\Security;


/**
 * This is the model class for table "useraccess".
 *
 * @property integer $userid
 * @property integer $accessid
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $pwd
 * @property string $pic
 * @property string $createdate
 * @property string $createby
 * @property string $editdate
 * @property string $editby
 * @property string $viewdate
 * @property string $viewby
 * @property string $position
 */
class UserAccess extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'useraccess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accessid'], 'integer'],
            [['username', 'password', 'pwd'], 'required'],
            [['createdate', 'editdate', 'viewdate'], 'safe'],
            [['username', 'password'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 500],
            [['pwd', 'pic', 'createby', 'editby', 'viewby'], 'string', 'max' => 45],
            [['position'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'Userid',
            'accessid' => 'Accessid',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'pwd' => 'Pwd',
            'pic' => 'Pic',
            'createdate' => 'Createdate',
            'createby' => 'Createby',
            'editdate' => 'Editdate',
            'editby' => 'Editby',
            'viewdate' => 'Viewdate',
            'viewby' => 'Viewby',
            'position' => 'Position',
        ];
    }

 

    public function getUserAcc($username,$password){
        Yii::$app->systemsettings->setDefaultTimeZone();
        $user=Yii::$app->sbccommon->opentable("select users.username as usergroup,useraccess.pwd,
        useraccess.userid, useraccess.username, useraccess.password,
        useraccess.accessid,left(useraccess.createdate,10) as createdate,useraccess.name,
        themer.themecode,itimages.picture,useraccess.starttime,useraccess.endtime,useraccess.istime from useraccess 
        left join user_themer as themer on themer.userid = useraccess.userid
        left join users on users.idno = useraccess.accessid
        left join itimages on itimages.codeid = useraccess.userid and itimages.filename = 'USER'
        where md5(useraccess.username)=md5('".$username."') 
        and md5(useraccess.pwd)=md5('".$password."') and useraccess.isinactive=0");
        
        if(empty($user)){
            return null;
        }else{
            if($user[0]['istime']){
                $starttime = strtotime($user[0]['starttime']);
                $endtime = strtotime($user[0]['endtime']);
                $timenow = strtotime(Yii::$app->backend->getLocalTime());
                //return $user[0];
                if($starttime <= $timenow && $endtime >= $timenow){ //COMPARING OF TIME
                    return $user[0];      
                }else{
                    return null;
                }//end if

            }else{
                return $user[0];
            }//end uf         
        }//end 
    }

    public function logAttempUser($username,$password){
            //$ip=Yii::$app->request->userHostAddress; YII1
            $ip = Yii::$app->getRequest()->getUserIP();
            Yii::$app->sbccommon->execqry("insert into attemptolog(ip,username,password)values('$ip','$username','$password')");
        }


    
    

}

