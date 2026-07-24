<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Profile extends Model
{
    public $psection;
    public $pvalue;
    public $doc;
    public $title;
    public $line;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pvalue', 'required'),
			array('doc', 'length', 'max'=>5),
			array('psection, puser', 'length', 'max'=>25),
			array('pvalue', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('doc, psection, pvalue, puser, line', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'doc' => 'Doc',
			'psection' => 'Psection',
			'pvalue' => 'Pvalue',
			'puser' => 'Puser',
			'line' => 'Line',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('doc',$this->doc,true);
		$criteria->compare('psection',$this->psection,true);
		$criteria->compare('pvalue',$this->pvalue,true);
		$criteria->compare('puser',$this->puser,true);
		$criteria->compare('line',$this->line,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function themes()
	{
		$mytheme=Yii::$app->sbccommon->opentable('
                    select * from profile where doc=1;
                    ');
                return $mytheme;
	}
        public static function usertheme()
	{
            $path='/css/STYLE.css';
		$utheme=Yii::$app->sbccommon->opentable('
                    select * from profile where doc="theme" and puser<>"";
                    ');
                if (!empty($utheme)){
                    for($i=0;$i<count($utheme);$i++){
                        if(Yii::$app->user->name==$utheme[$i]['puser']){
                            $path=$utheme[$i]['pvalue'];
                        }
                    }

                } else {
                    $path='/css/STYLE.css';
                }
                return $path;
	}
        public static function master()
	{
            //$path='/css/masterfile.css';
            $path='';
		$utheme=Yii::$app->sbccommon->opentable('
                    select * from profile where doc="theme" and puser<>"";
                    ');
                if (!empty($utheme)){
                    for($i=0;$i<count($utheme);$i++){
                        if(Yii::$app->user->name==$utheme[$i]['puser']){
                            $path=$utheme[$i]['master'];
                        }
                    }

                } else {
                    $path='/css/masterfile.css';
                }
                return $path;
	}

        public static function themestyle()
	{
            $path='/themes/default/THEMING.css';
		$utheme=Yii::$app->sbccommon->opentable("select * from profile where doc='theme' and puser='".Yii::$app->user->name."'");
                if (!empty($utheme)){
                    for($i=0;$i<count($utheme);$i++){
                        if(Yii::$app->user->name==$utheme[$i]['puser']){
                            $path=$utheme[$i]['themestyle'];
                        }
                    }
                } else {
                    $path='/themes/bismac/THEMING.css';
                }
                return $path;
	}

        
        public function openPrefAll($controller,$access){
        	if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
            $data = "not allowed";
            return $data;
        	} else {
            return Yii::$app->sbccommon->opentable("select line,doc,psection,pvalue from profile  where doc = 'SED'");
        	}
        }
        
        public function openPref($line){
                return Yii::$app->sbccommon->opentable("select pvalue,psection,doc,line from profile where doc = 'SED' and line ='$line'");
        }

          public function updateDoc($data){
              $models=Yii::$app->sbccommon->execqry("update profile set pvalue = '$data->pvalue'  where doc = 'SED' and psection = '$data->psection'");
              
              return $models;
        }

}