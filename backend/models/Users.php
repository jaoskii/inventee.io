<?php

namespace app\models;
use Yii;
use yii\base\Model;

class Users extends Model
{
    public $module;
    public $module_;
    public $access;

    public function rules()
    {
        return [
            [['Attributes'], 'required'],
            [['UserName','PassWord','Class',], 'max' => 20],
            [['Attributes'], 'max' => 4000],
            [['module','module_',], 'safe'],
            [['IDNO','UserName','PassWord','Attributes','Class',], 'safe','on'=>'search'],
            
        ];
    }

/*    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Attributes', 'required'),
            array('UserName, PassWord, Class', 'length', 'max'=>20),
            array('Attributes', 'length', 'max'=>4000),
            array('module,module_', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('IDNO, UserName, PassWord, Attributes, Class', 'safe', 'on'=>'search'),
        );
    }*/

    
    public function attributeLabels()
    {
        return array(
            'IDNO' => 'Idno',
            'UserName' => 'User Name',
            'PassWord' => 'Pass Word',
            'Attributes' => 'Attributes',
            'Class' => 'Class',
        );
    }



        public static function getrole($accessid)
        {
            $role=Yii::$app->sbccommon->opentable("select idno, username, password, attributes, class from users where idno='$accessid'");
            if(!empty($role))
            {
            return $role[0];
            }
        }
        
        
        public static function getFirstLevel($Level) 
        {   
          if($Level!=''){
              $acno='\\\\';
            $useraccess= Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where parent='$acno' and allowed <> 1 and parentid=0 order by code");
          }else{
              $acno='\\';
              $useraccess= Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where parent='$acno' and parentid=0 and allowed <> 1 order by code");
          }
          
            return $useraccess;
        }
        
       public static function getsecondlevel($acno)
       {
              return Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where md5(parent)='$acno' and parentid=0 and allowed <> 1 order by code");
           
       }

       public static function getmoduleattribute($acno){
              return Yii::$app->sbccommon->datareader("select attribute from attributes where md5(code)='$acno' and parentid=0");
           
       }

        public static function getmoduledescription($acno)
       {
              return Yii::$app->sbccommon->datareader("select description from attributes where md5(code)='$acno' and parentid=0");
           
       }
      
       public static function getuserallowedmodule($acno,$user)
       {
              return Yii::$app->sbccommon->opentable("select attributes.attribute,attributes.description,attributes.code  from attributes left join moduleaccess on moduleaccess.attribute=attributes.attribute where md5(attributes.parent)='$acno' and moduleaccess.idno='$user' and attributes.parentid=0 and attributes.allowed <> 1
                  union all
                  select attributes.attribute,attributes.description,attributes.code  from attributes left join moduleaccess on moduleaccess.attribute=attributes.attribute where md5(attributes.code)='$acno' and moduleaccess.idno='$user' and attributes.parentid=0 and attributes.allowed <> 1
                  order by code");
       }

      public static function getusernotallowedmodule($acno,$user)
       {
              return Yii::$app->sbccommon->opentable("select attribute,description,code from attributes where (md5(parent)='$acno' or md5(code)='$acno') and parentid=0 and attribute not in (select attributes.attribute from attributes left join moduleaccess on moduleaccess.attribute=attributes.attribute where md5(attributes.parent)='$acno' and moduleaccess.idno='$user' and attributes.parentid=0 and attributes.allowed <> 1
                             union all
                             select attributes.attribute from attributes left join moduleaccess on moduleaccess.attribute=attributes.attribute where md5(attributes.code)='$acno' and moduleaccess.idno='$user' and attributes.parentid=0 and attributes.allowed <> 1
                             order by attributes.code)");
       }

       
}