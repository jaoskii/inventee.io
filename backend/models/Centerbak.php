<?php

namespace app\models;

use Yii;
use yii\base\Model;

//for branch masterfile  under masterfile module
class Center extends Model
{
        public $allow;
	    public $line;
        public $code;
        public $name;
        public $address;
        public $tel;
        public $warehouse;
        public $mainmodule;
        public $selectmodule;
        public $sellingprice;
        public $commission;
        public $icommission;
        
	public function rules()
	{
		return array(
                        array('code,name,address,warehouse','required'),
			array('code', 'length', 'max'=>45),
			array('name,mainmodule,selectmodule', 'length', 'max'=>400),
                        array('address', 'length', 'max'=>150),
                        array('tel', 'length', 'max'=>100),
                        array('warehouse', 'length', 'max'=>20),
                        array('allow','numerical', 'integerOnly'=>true),
			array('line, code, name,mainmodule,selectmodule', 'safe', 'on'=>'search'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'line' => 'Line',
			'code' => 'Code',
			'name' => 'Name',
		);
	}
       

          public static function getbranches_() {
            //$data=Yii::$app->sbccommon->opentable("select center.line, code, center.name, address, tel, warehouse from center");
            $data=Yii::$app->sbccommon->opentable("select concat(line, '/', code) as id,code,name,address,tel,line, warehouse from center");
            return $data;
            if(!empty($data))
                {
                    $centers=array("");
                    foreach($data as $key => $data_)
                    {
                    $center=array('id'=>strtoupper($data_['line']."/".$data_['code']),'code'=>$data_['code'],'name'=>$data_['name'],'line'=>$data_['line'],'address'=>$data_['address'],'tel'=>$data_['tel'],'warehouse'=>$data_['warehouse']);
                    array_push($centers, $center);
                    }

                    return $centers;
                }
                else
                {
                    return $data;
                }
        }


        public static function getbranches_line($line) {
            $data=Yii::$app->sbccommon->opentable("select center.line, code, center.name, address, tel, warehouse from center where line = '$line'");
            if(!empty($data))
                {
                    $centers=array("");
                    foreach($data as $key => $data_)
                    {
                    $center=array('id'=>strtoupper($data_['line']."/".$data_['code']),'code'=>$data_['code'],'name'=>$data_['name'],'line'=>$data_['line'],'address'=>$data_['address'],'tel'=>$data_['tel'],'warehouse'=>$data_['warehouse']);
                    array_push($centers, $center);
                    }

                    return $centers;
                }
                else
                {
                    return $data;
                }
        }

        public static function getcenters($userid) //with one empty selection on return // this is for center access upon login
        {
            $data=Yii::$app->sbccommon->opentable("select center.line, code, center.name, address, tel, warehouse,sellingprice,commission,icommission from center
                                                    left join centeraccess on centeraccess.center=center.code
                                                    where md5(userid)='$userid'");
            if(!empty($data))
                {
                    $centers=array();
                    foreach($data as $key => $data_)
                    {
                    $center=array('id'=>strtoupper($data_['line']."/".$data_['code']),'code'=>$data_['code'],'name'=>$data_['name']);
                    array_push($centers, $center);
                    }
                    
                    return $centers; 
                }
                else
                {
                    return $data;
                }
        }

        public static function getcenters_($userid) //without empty selection on return // this is for reports 
        {
            $data=Yii::$app->sbccommon->opentable("select center.line, code, center.name, address, tel, warehouse from center
                                                        left join centeraccess on centeraccess.center=center.code
                                                    where md5(userid)='$userid'");
            if(!empty($data))
                {
                    $centers=array();
                    foreach($data as $key => $data_)
                    {
                    $center=array('id'=>strtoupper($data_['code']),'code'=>$data_['code'],'name'=>$data_['name']);
                    array_push($centers, $center);
                    }

                    return $centers;
                }
                else
                {
                    return $data;
                }
        }

     public static function getcenter_report($userid){
            $models=Yii::$app->sbccommon->opentable("select center.line, code, center.name, address, tel, warehouse from center
                                                        left join centeraccess on centeraccess.center=center.code
                                                    where md5(userid)='$userid'");


        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['name'],
                'center' => $model['code'],
                'value' => $model['name'],
                'id' => $model['code'],
                'default' => "",
                'title' => $model['name'],
            );
        }
        return $suggest;
         
     }

     
   public static function getwhcenter($center){
     return Yii::$app->sbccommon->datareader("select warehouse from center where code='$center'");       
   }  
     
   public static function getcenterwh_report($userid){
                        $models=Yii::$app->sbccommon->opentable("select wh.client as code, wh.clientname as name from center
                                                        left join centeraccess on centeraccess.center=center.code left join client as wh on wh.client=center.warehouse 
                                                    where md5(userid)='$userid'");
       
        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['name'],
                'center' => $model['code'],
                'value' => $model['name'],
                'id' => $model['code'],
                'default' => "",
                'title' => $model['name'],
            );
        }
        return $suggest;
         
     }

        public static function checkcenter($center){ // if center is existing during login @ index
            if(Yii::$app->systemsettings->setCenterSelection()){
                $id=explode("/",$center);
                $qry = "SELECT line, code, name,address,tel from center where code='$id[1]' and line=$id[0]";
            }else{
                $qry = "SELECT line, code, name,address,tel from center where code='$center'";
            }//end center selection

            $data=Yii::$app->sbccommon->opentable($qry);
            if($data!=null){
                return $data[0];
            }
            else{
                return false;
            }
        }//end function check center

        public static function isexisting($center_code){
            $data=Yii::$app->sbccommon->opentable("SELECT  line, code, name  from center where code='$center_code'");
            if(!empty($data))
                {
                return true;
                }
            else
                {
                return false;
                }
        }//end function isexisting

        public static function insertcenter($data)
        {
            Yii::$app->sbccommon->execqry("insert into center (code, name, address, tel, warehouse, sellingprice,commission,icommission) values ('$data->code','$data->name','$data->address','$data->tel', '$data->warehouse', '$data->sellingprice', '$data->commission', '$data->icommission')");
        }
        public static function Editcenter($id)
        {
            $data=Yii::$app->sbccommon->opentable("SELECT line, name, code, address, tel, warehouse,sellingprice,commission,icommission from center where code='$id[1]' and line=$id[0]");
            return $data;
        }
        public static function updatecenter($data)
        {
             Yii::$app->sbccommon->execqry("update center set code='$data->code', name='$data->name', address='$data->address', tel='$data->tel', warehouse='$data->warehouse', sellingprice='$data->sellingprice', commission='$data->commission', icommission='$data->icommission' where line='$data->line' and code='$data->code'");
        }
        
        public static function deletecenter($center_code)
        {
            Yii::$app->sbccommon->execqry("delete from centeraccess where center='$center_code'");
            Yii::$app->sbccommon->execqry("delete from center where code='$center_code'");
        }
        public static function getwarehouses()
        {
            $data=Yii::$app->sbccommon->opentable("select clientid, client, clientname,iswarehouse from client where iswarehouse=1 ");
            if(!empty($data))
                {
                        
                           $wh=array();
                        foreach($data as $key => $data_)
                            {

                            $wh1=array('id'=>strtoupper($data_['client']),'clientid'=>strtoupper($data_['clientid']),'clientname'=>$data_['clientname']);
                            array_push($wh, $wh1);
                            }
                             return $wh;
                        
                        
                }
                else
                    {
                    return $data;
                    }
        }
	
}