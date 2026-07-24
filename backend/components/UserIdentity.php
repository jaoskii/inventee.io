<?php

namespace app\components;
use Yii;
use yii\web\User;

class UserIdentity extends yii\web\User {
    private $id;
	public function authenticate() {
            $username=$this->username;
            $user= Useraccess::getuser($username,md5($this->password));
            Useraccess::logAttempUser($username, $this->password);
            
            if ($user==null)
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
            elseif ($user['username']!==$this->username)
                     $this->errorCode=self::ERROR_USERNAME_INVALID;
            else if($user['password']!==md5(md5($this->password)))
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else
                {
                $this->username=$user['username'];
                $this->id=$user['userid'];
                $role=Users::getrole($user['accessid']);
                $this->setState('username',$user['username']);
                $this->setState('password',md5(md5($this->password)));
                $this->setState('name',$user['name']);
                //$qq= preg_split('//', '0'.$role['attributes'], -1, PREG_SPLIT_NO_EMPTY);
                $this->setState('access','0'.$role['attributes']);
                //$this->setState('access',$qq);
                $this->setState('isReadonly',true);     //to set warehouse to readonly => true/false
                $this->setState('useDefaultClient',false);       //set to true to use default client only
                $this->setState('DclientCode','000000000000000');  //@todo create a function to call default client from db
                $this->setState('DclientName','Walk-In');

                

                $this->setState('branches','1');        //set to '0' to use only one warehouse :
                                                        //  '1' to have branch selection
                                                        //  
                //$this->setState('center','1/001');    //uncomment this when setting branches to '0'
                                                        //set to existing warehouse line slash code to be used ex. '1/001'
                
                $this->setState('defaultitemprice','client');  //

                $this->errorCode=self::ERROR_NONE;
                }
            return $this->errorCode == self::ERROR_NONE;

          
	}
         public function getId()
        {
            return $this->id;
         }
}