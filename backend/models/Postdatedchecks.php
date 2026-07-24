<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Postdatedchecks extends Model
{
   public $line;
   public $client;
   public $clientname;
   public $amount;
   public $checkdate;
   public $dateid;
   public $checkno;
   public $void;


    public function rules()
    {
           

        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
             array('line,void', 'numerical', 'integerOnly'=>true),
            array('client', 'checkno', 'username', 'createby', 'editby', 'viewby', 'length', 'max'=>25),
            array('clientname','max' =>50),
            array('amount','number'),
            array('client,checkno,amount','required'),
            array('checkdate, dateid, createdate, editdate, viewdate', 'safe', 'on'=>'search'),
            // array('line,days', 'numerical', 'integerOnly'=>true),
            // array('client', 'length', 'max'=>15),
            //             array('client,amount','required'),
            // // The following rule is used by search().
            // // Please remove those attributes that should not be searched.
            // array('terms, days, discount', 'safe', 'on'=>'search'),
        );
    }

    
    public function attributeLabels()
    {
        return array(
            'line' => 'Line',
            'client' => 'Client',
            'clientname' => 'Clientname',
            'checkno' => 'Checkno',
            'amount' => 'Amount',
            'checkdate' => 'Checkdate',
            'username' => 'Username',
            'dateid' => 'Dateid',
            'createdate' => 'Createdate',
            'createby' => 'Createby',
            'editby' => 'Editby',
            'editdate' => 'Editdate',
            'viewby' => 'Viewby',
            'viewdate' => 'Viewdate',
            'void'=>'Void',
        );
    }


    public function openPDC($controller,$dateid1,$dateid2,$access){
        if($dateid1 == ''){
            $dateid1 = date('Y-m-d');
        }

        if($dateid2 == ''){
            $dateid2 = date('Y-m-d');
        }

        if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
           $data = "not allowed";
            return $data;
        }else{
            $SQL="select 'U' as tr,line,client,clientname,checkno,amount,left(checkdate,10) as checkdate,left(dateid,10) as dateid,void,createby,left(createdate,10) as createdate,refx,linex,notes from postdatedchecks
            where dateid between '$dateid1' and '$dateid2' union all select 'P' as tr,line,client,clientname,checkno,amount,left(checkdate,10) as checkdate,left(dateid,10) as dateid,void,createby,left(createdate,10) as createdate,refx,linex,notes from hpostdatedchecks
            where dateid between '$dateid1' and '$dateid2' order by createby,line,dateid";
            $models = Yii::$app->sbccommon->opentable($SQL);
        }
       return $models;

    }//end openpdc

    public function openPDCline($controller,$line){
            $sql="select 'U' as tr,client.clientid,pdc.line,pdc.client,pdc.clientname,pdc.checkno,pdc.amount,left(pdc.checkdate,10) as checkdate,
            left(pdc.dateid,10) as dateid,pdc.void,pdc.createby,left(pdc.createdate,10) as createdate,pdc.refx,pdc.linex,pdc.notes from postdatedchecks as pdc 
            left join client on client.client = pdc.client where pdc.line = '$line' 
            union all 
            select 'P' as tr, client.clientid,pdc.line,pdc.client,pdc.clientname,pdc.checkno,pdc.amount,left(pdc.checkdate,10) as checkdate,
            left(pdc.dateid,10) as dateid,pdc.void,pdc.createby,left(pdc.createdate,10) as createdate,pdc.refx,pdc.linex,pdc.notes from hpostdatedchecks as pdc left join client on client.client = pdc.client where pdc.line = '$line'";
            $models = Yii::$app->sbccommon->opentable($sql);
            return $models;

    }//end openpdcline

    public function updatepdc($controller,$data){
        Yii::$app->systemsettings->setDefaultTimeZone();
        $client = $data['client'];
        $clientname = $data['clientname'];
        $dateid = $data['dateid'];
        $checkdate = $data['checkdate'];
        $checkno = $data['checkno'];
        $amount = $data['amount'];
        $line = $data['line'];
        $notes = $data['notes'];
        $editdate  = date('Y-m-d');
        $user=Yii::$app->session['loggeduser']['username'];

         $sql ="update postdatedchecks set client='$client',clientname='$clientname',checkdate='$checkdate',checkno='$checkno',amount =$amount,editby ='$user',editdate='$editdate',notes='$notes' where line= $line";
        
        Yii::$app->sbccommon->execqry($sql);
        $pdcdata =  $this->openPDCline($this,$line);

        if(!empty($pdcdata)){
            $newclient = $pdcdata[0]['client'];
            $newclientname = $pdcdata[0]['clientname'];
            $newdateid = $pdcdata[0]['dateid'];
            $newcheckdate = $pdcdata[0]['checkdate'];
            $newcheckno = $pdcdata[0]['checkno'];
            $newamount = $pdcdata[0]['amount'];
            $newline = $pdcdata[0]['line'];
            $createby  = $pdcdata[0]['createby'];
            $notes  = $pdcdata[0]['notes'];

            $passjson = array('client'=>$newclient,'clientname'=>$newclientname,'dateid'=>$newdateid,'checkdate'=>$newcheckdate,'checkno'=>$newcheckno,'amount'=>$newamount,'line'=>$newline,'createby'=>$createby,'notes'=>$notes);
                echo json_encode($passjson);

        }else{
                echo json_encode(array("error"=>"ERROR RETRIEVAL"));
            }

    }//end updatepdc

    public function deletepdc($controller,$line){
         $sql ="delete from postdatedchecks  where line= $line";
        
        return Yii::$app->sbccommon->execqry($sql);
    }//delete pdc


    public function voidpdc($controller,$data){
        Yii::$app->systemsettings->setDefaultTimeZone();
        $line = $data['line'];
        $voiddate  = date('Y-m-d');
        $user=Yii::$app->session['loggeduser']['username'];

         $sql ="update postdatedchecks set void =1,voiddate ='$voiddate',voidby='$user' where line= $line";
        
        return Yii::$app->sbccommon->execqry($sql);
        //$pdcdata =  $this->openPDCline($this,$line);

        // if(!empty($pdcdata)){
        //     $newclient = $pdcdata[0]['client'];
        //     $newclientname = $pdcdata[0]['clientname'];
        //     $newdateid = $pdcdata[0]['dateid'];
        //     $newcheckdate = $pdcdata[0]['checkdate'];
        //     $newcheckno = $pdcdata[0]['checkno'];
        //     $newamount = $pdcdata[0]['amount'];
        //     $newline = $pdcdata[0]['line'];
        //     $createby  = $pdcdata[0]['createby'];

        //     $passjson = array('client'=>$newclient,'clientname'=>$newclientname,'dateid'=>$newdateid,'checkdate'=>$newcheckdate,'checkno'=>$newcheckno,'amount'=>$newamount,'line'=>$newline,'createby'=>$createby);
        //         echo json_encode($passjson);

        // }else{
        //         echo json_encode(array("error"=>"ERROR RETRIEVAL"));
        //     }

    }//end voidpdc
    
     public function postpdc($line){
        $user=Yii::$app->session['loggeduser']['username'];
            $sql ="insert into hpostdatedchecks (line,client,clientname,checkno,checkdate,amount,username,dateid,createdate,createby,editby,editdate,viewby,viewdate,void,voiddate,voidby,refx,linex,notes) select line,client,clientname,checkno,checkdate,amount,username,dateid,createdate,createby,editby,editdate,viewby,viewdate,void,voiddate,voidby,refx,linex,notes from postdatedchecks where line=$line ";

            Yii::$app->sbccommon->execqry($sql);
            Yii::$app->sbccommon->execqry("delete from postdatedchecks where line = $line");
         
                
    }//end postpdc
   
}