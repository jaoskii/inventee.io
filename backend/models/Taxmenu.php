<?php
namespace app\models;

use Yii;
use yii\base\Model;


class Taxmenu extends Model
{

    public $name;
    public $line;
    public $atc;
    public $rate;
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('line,rate', 'numerical', 'integerOnly'=>true),
			array('name,atc', 'length', 'max'=>500),
                        array('name,atc','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, atc, rate', 'safe', 'on'=>'search'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'line' => 'Line',
			'Name' => 'Name',
			'Atc' => 'Atc',
			'Rate' => 'Rate',
		);
	}

	 public function suggestTerms($keyword,$limit=20)
	{
		$models=Yii::app()->sbccommon->opentable("select terms,line,days, discount from terms where terms LIKE '%$keyword%'");

		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model['terms'],  // label for dropdown list
				'value'=>$model['terms'],  // value for input field
				'id'=>$model['line'],       // return values from autocomplete
				'days'=>$model['days'],
				'discount'=>$model['discount'],
			);
		}
		return $suggest;
	}

    public function openTaxmenu($controller,$access){

    	if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
           $data = "not allowed";
            return $data;
        } else {

        	$models = Yii::$app->sbccommon->opentable("select line,name,atc,rate from taxmenu order by line");
    	}
       return $models;

    }

    public function openTerms2($line){

			return $models="select line,name,atc,rate from taxmenu where line =$line order by name";

       // return $models;

    }


        public function insertTerms($terms){
            $user=Yii::app()->user->username;
            $insert=Yii::app()->sbccommon->execqry("insert into terms (name,atc,rate,createby,editby,viewby) values ('$terms->terms','$terms->days','$user','','')");
            return $insert;
        }

        public function updateTerms($terms){
            $user=Yii::app()->user->username;
            $update=Yii::app()->sbccommon->execqry("update terms
                                                    set terms = '$terms->terms',days='$terms->days',editby='$user',editdate=CURRENT_TIMESTAMP where line = $terms->line");
            return $update;
        }

       
  public function deleteTerms($id){
            $terms = Yii::app()->sbccommon->datareader("select terms from terms where md5(line) = '$id'"); 
            $line = Yii::app()->sbccommon->datareader("select line from terms where md5(line) = '$id'"); 
            $delete=Yii::app()->sbccommon->execqry("delete from terms where md5(line) = '$id'");
            Log::del_log('TERMS', $line, $terms, 'TERMS');
            return $delete;
        }
}