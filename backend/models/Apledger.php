<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Apledger extends Model {
	   public $trno;
        public $line;
        public $dateid;
        public $acnoid;
        public $clientid;
        public $db;
        public $cr;
        public $bal;
        public $docno;
        public $fdb;
        public $fcr;
        public $ref;

	public function tableName(){
	
		return 'apledger';
	}
	public function rules(){
	
		return array(
			array('docno', 'required'),
			array('line, acnoid, clientid', 'numerical', 'integerOnly'=>true),
			array('trno, docno', 'length', 'max'=>20),
			array('db, cr, bal, fdb, fcr', 'length', 'max'=>19),
			array('ref', 'length', 'max'=>50),
			array('dateid', 'safe'),
		);
	}
	public function attributeLabels(){
	
		return array(
			'trno' => 'Trno',
			'line' => 'Line',
			'dateid' => 'Dateid',
			'acnoid' => 'Acnoid',
			'clientid' => 'Clientid',
			'db' => 'Db',
			'cr' => 'Cr',
			'bal' => 'Bal',
			'docno' => 'Docno',
			'fdb' => 'Fdb',
			'fcr' => 'Fcr',
			'ref' => 'Ref',
		);
	}
        
        public static function deletedscheck($trno,$line){
            $table='crledger';
            return Yii::$app->sbccommon->execqry("update $table set depodate=null where trno='$trno' and line='$line'");
        }

        public static function updatebal($trno,$line,$acno,$module,$reset=0){////refx, linex,data(object), module->id
            $bal=Apledger::recomputebal($trno, $line);//payment amt
            $arap=Apledger::recomputearap($trno, $line);//ar/ap amt
            
            $reference=Apledger::getpaymentreference($trno, $line);
            $alias=ApLedger::getalias($acno);
            
            if ($bal<=$arap){
            switch($alias){               
                case'AP':{
                    $table='apledger';
                      $updated=Yii::$app->sbccommon->execqry("update $table set bal=(db+cr)-$bal,ref='$reference' where trno='$trno' and line='$line'");
                      break;
                }

                case'AR':{
                    $table='arledger';
                      $updated = Yii::$app->sbccommon->execqry("update $table set bal=(db+cr)-$bal,ref='$reference' where trno='$trno' and line='$line'");
                    break;
                }

                case'CR':
                     $table='crledger';
                      if($reset==0){
                          $updated = Yii::$app->sbccommon->execqry("update $table set depodate = CURRENT_TIMESTAMP where trno='$trno' and line='$line'");
                      }else{
                          $updated = Yii::$app->sbccommon->execqry("update $table set depodate=null where trno='$trno' and line='$line'");
                      }
                    break;

                case'CA':
                     $table='caledger';
                      if($reset==0){
                          $updated=Yii::$app->sbccommon->execqry("update $table set depodate=CURRENT_TIMESTAMP where trno='$trno' and line='$line'");
                      }else{
                          $updated=Yii::$app->sbccommon->execqry("update $table set depodate=null where trno='$trno' and line='$line'");
                      }
                    break;                    
            }
           
           return $updated;
          }else{
              return false;
          }
          
        }

        public static function resetdb($trno,$line,$module){
            $table=Common::localdetail($module);
            Yii::$app->sbccommon->execqry("update $table set db=0, cr=0 where trno='$trno' and line='$line'");
        }
        public static function recomputebal($trno,$line){
            $bal= Yii::$app->sbccommon->datareader("
                    select ifnull(round(sum(db+cr),".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0) as bal 
                    from (select db,cr from ladetail where refx='$trno' and linex='$line'
                    union all
                    select db,cr from lbdetail where refx='$trno' and linex='$line'
                    union all
                    select db,cr from lcdetail where refx='$trno' and linex='$line'
                    union all
                    select db,cr from gldetail where refx='$trno' and linex='$line'
                    union all
                    select db,cr from hgldetail where refx='$trno' and linex='$line') as t");
            if($bal==null){
                return 0;
            }else{
                return $bal;
            }
        }

        public static function recomputearap($trno,$line){
            $bal= Yii::$app->sbccommon->datareader("
                    select ifnull(round(sum(db+cr),".Yii::$app->systemsettings->setDecimaldisplay('currency')."),0) as bal 
                    from (
                    select db,cr from ladetail where trno='$trno' and line='$line'
                    union all
                    select db,cr from lbdetail where trno='$trno' and line='$line'
                    union all
                    select db,cr from lcdetail where trno='$trno' and line='$line'
                    union all
                    select db,cr from gldetail where trno='$trno' and line='$line'
                    union all
                    select db,cr from hgldetail where trno='$trno' and line='$line'
                    ) as t
                ");
            if($bal==null){
                return 0;
            }else{
                return $bal;
            }
        }

        public static function getalias($acno){
            return Yii::$app->sbccommon->datareader("select left(alias,2) as alias from coa where acno='\\\\".$acno."'");
        }

        
        public static function getpaymentreference($trno,$line){
            $ref= Yii::$app->sbccommon->opentable("
                    select head.docno,left(head.dateid,10) as dateid from lahead as head left join ladetail as d on d.trno=head.trno where d.refx='$trno' and d.linex='$line'
                    union all
                    select head.docno,left(head.dateid,10) as dateid from lahead as head left join lbdetail as d on d.trno=head.trno where d.refx='$trno' and d.linex='$line'
                    union all
                    select head.docno,left(head.dateid,10) as dateid from lahead as head left join lcdetail as d on d.trno=head.trno where d.refx='$trno' and d.linex='$line'
                    union all
                    select head.docno,left(head.dateid,10) as dateid from lahead as head left join gldetail as d on d.trno=head.trno where d.refx='$trno' and d.linex='$line'
                    union all
                    select head.docno,left(head.dateid,10) as dateid from lahead as head left join hgldetail as d on d.trno=head.trno where d.refx='$trno' and d.linex='$line'
                ");
            $reference="";
            foreach($ref as $ref_){
                $reference .=" ".$ref_['docno']." ".$ref_['dateid'];
            }

            if(strlen($reference)==0){
                return '';
            }else{
                return $reference;
            }
        }

        public static function updateARledger_kr($trno,$line,$krtrno){
            $update=Yii::$app->sbccommon->execqry("update arledger set kr='$krtrno' where trno='$trno' and line='$line'");
            if($update==1){
                return true;
            }else{return false;}
        }
        public static function resetARledger($trno,$line){
            $update=Yii::$app->sbccommon->execqry("update arledger set kr=0 where trno='$trno' and line='$line'");
        }

}