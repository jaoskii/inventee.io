<?php
namespace app\models;

use Yii;
use yii\base\Model;


class Terms extends Model
{

    public $terms;
    public $days;
    public $line;
    
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('line,days', 'numerical', 'integerOnly'=>true),
			array('terms', 'length', 'max'=>25),
                        array('days,terms','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terms, days, discount', 'safe', 'on'=>'search'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'line' => 'Line',
			'Terms' => 'Terms',
			'Days' => 'Days',
			'Discount' => 'Discount',
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

        // public function openTerms($id){
        //     if ($id==0){
        //         $models=Yii::app()->sbccommon->opentable("select terms,line,days,discount from terms order by terms");
        //     }else{
        //         $models=Yii::app()->sbccommon->opentable("select terms,line,days,discount from  terms where md5(line) ='$id' order by terms");
        //     }
        //    return $models;

        // }

    public function openTerms($controller,$access){

    	if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
           $data = "not allowed";
            return $data;
        } else {

        	$models = Yii::$app->sbccommon->opentable("select terms,line,days,discount from terms order by terms");
    	}
       return $models;

    }

    public function openTerms2($line){

			return $models="select terms,line,days,discount from  terms where line =$line order by terms";

       // return $models;

    }


        public function insertTerms($terms){
            $user=Yii::app()->user->username;
            $insert=Yii::app()->sbccommon->execqry("insert into terms (terms,days,createby,editby,viewby) values ('$terms->terms','$terms->days','$user','','')");
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