<?php

namespace app\models;

use Yii;
use yii\base\Model;


class Log extends Model
{
	public $trno;
        public $field;
        public $startdate;
        public $enddate;
        public $user;
        public $modules;
        
	public function rules()
	{
		return array(
			array('oldversion, newversion', 'required'),
			array('trno', 'length', 'max'=>10),
			array('field, userid', 'length', 'max'=>45),
			array('oldversion, newversion', 'length', 'max'=>300),
			array('dateid', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('trno, field, oldversion, newversion, userid, dateid', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'trno' => 'Transaction #',
			'field' => 'Field',
			'oldversion' => 'From: ',
			'newversion' => 'To: ',
			'userid' => 'User',
			'dateid' => 'Date',
		);
	}
        
        
  public static function del_log($doc, $trno, $docno, $field = 'TRANSACTION') {
        $user = Yii::$app->session['loggeduser']['username'];
            switch (strtoupper($doc)) {
                case'PO':case'PC':case'SO':case'KR':case'EX':case'JO':case'PR': case 'SP':{
                        $table = ' del_transnum_log ';
                        break;
                    }
                case'CUSTOMER':case'SUPPLIER':case'WAREHOUSE':case'AGENT': {
                        $table = ' del_client_log ';
                        break;
                    }
                 case 'ITEMS':{
                        $table = ' del_item_log ';
                        $field = 'STOCKCARD';
                        break;
                     
                 }
                case'TERMS':{
                     $table='del_terms_log';
                     break;
                }
               case'USERACCESS':{
                     $table='del_useraccess_log';
                     break;
                }

                 case 'CENTER':{
                     $table='del_center_log';
                     break;
                 }
                default: {
                        $table = ' del_table_log ';
                        break;
                    }
            }//end switch

            $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
            $insert_log = Yii::$app->sbccommon->execqry("insert into $table (trno,docno,field,userid,dateid)
            values('$trno','$docno','$field','$user','".$current_timestamp."')");
            
            if ($insert_log == 1) {
                return 1;
            }else{
                return "Error on Deletion logging ";
            }///end if
    }//end fn

        
        public static function writelog($doc,$trno,$field,$oldvalue,$userencoded){ // added user encoded
            switch($doc){
                case'PO':case'PC':case'SO':case'KR':case'JO':case'EX':case'PR': 
                case 'quotation': case 'QT': case 'JB': case 'SP': case 'TR':{ 
                    $table='transnum_log'; 
                    //$del_table=' del_transnum_log'; 
                    break;
                }

                case'customer': case'supplier': case'warehouse': case'agent': {
                    $table='client_log'; 
                    //$del_table=' del_item_log'; 
                    break;
                }
                
                case'stockcard': case 'posstockcard':{
                     $table='item_log';
                     //$del_table='del_item_log';
                     break;
                 }

                 case'TERMS':{
                     $table='terms_log';
                     break;
                 }

                 case'USERACCESS':{
                     $table='useraccess_log';
                     break;
                 }

                 case 'CENTER':{
                     $table='center_log';
                     break;
                 }

                default :{ 
                    $table='table_log'; 
                    //$del_table=' del_table_log'; 
                    break;
                }
            }//end switch
              
              $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();

              Yii::$app->sbccommon->execqry("INSERT into $table (trno,field,oldversion,userid,dateid) values('$trno','$field','$oldvalue','$userencoded','".$current_timestamp."')");

            return 'ok';                    

        }//END WRITE LOG

        
        public function getlogsuseraccess(){
            $sql = "
                select trno, field, oldversion, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
                from useraccess_log as log
                left join useraccess as u on u.username=log.userid                
                union all
                select trno, concat('DELETE',' ',field), docno, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
                from  del_useraccess_log as log
                left join useraccess as u on u.username=log.userid 
                union all
                select userid,'CREATE',username,createby,createdate,if(pic='','blank_user.png',pic) as pic from useraccess";
            $sql=$sql." order by dateid desc";
            $data=Yii::$app->sbccommon->opentable($sql);
            if(!empty($data)){
                return $data;
            }else{
                return false;
            }            
        }
        
        public function getlogsterms(){
            $sql = "
                select trno, field, oldversion, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
                from terms_log as log
                left join useraccess as u on u.username=log.userid                
                union all
                select trno, concat('DELETE',' ',field), docno, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
                from  del_terms_log as log
                left join useraccess as u on u.username=log.userid
                union all
                select line,'CREATE',terms,createby,createdate, if(pic='','blank_user.png',pic) as pic
                from terms as log left join useraccess as u on u.username=log.createby";

            $sql=$sql." order by dateid desc";
            
            $data=Yii::$app->sbccommon->opentable($sql);
            if(!empty($data)){
                return $data;
            }else{
                return false;
            }            
        }
        
        
        public function getlogs($doc,$trno,$level='ALL'){
          switch($level){
            case'H':{ $filter=' field = HEAD'; break; }
            case'S':{ $filter=' field = STOCK'; break; }
            case'D':{ $filter=' field = DETAIL'; break; }
            case'C':{ $filter=' field = CREATE'; break; }
            case'P':{ $filter=' field = POST'; break; }
            case'U':{ $filter=' field = UNPOST'; break; }
            default:{ $filter=' 1 '; break; }
          }//end switch
          
          switch(strtoupper($doc)){
            case 'RF': case'PO': case'PC': case'SO': case'KR': case'JO': case'EX': case'EXPENSES': case'PR': 
            case 'TX': case 'SP': case 'QT':case 'JB': case 'TR':
              $table='transnum_log'; 
              $del_table=' del_transnum_log'; 
            break;
            case'CUSTOMER': case'SUPPLIER': case'WAREHOUSE': case'AGENT': case'LOCATION': case'VENDOR':
              $table='client_log';
              $del_table=' del_client_log';
            break;                
            case'STOCKCARD':
              $table='item_log';
              $del_table='del_item_log';
            break;
            case 'TERMS':
              $table='terms_log';
              $del_table='del_terms_log';
            break;
            case 'CENTER':
              $table='center_log';
              $del_table='del_center_log';
            break;
            default :
              $table='table_log'; 
              $del_table=' del_table_log'; 
            break;
          }
          
          $sql = "select trno, field, oldversion, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
            from $table as log
            left join useraccess as u on u.username=log.userid
            where trno='$trno' and $filter
            union all
            select trno, concat('DELETE',' ',field), docno, log.userid, dateid, if(pic='','blank_user.png',pic) as pic
            from  $del_table as log
            left join useraccess as u on u.username=log.userid
            where trno='$trno' and $filter";

          switch(strtoupper($doc)){
            
            case 'SP':
            case 'PO': case 'PR': case 'SO': case 'PC': case 'KR': case 'RR': case 'CA': 
            case 'DM': case 'SJ': case 'CM': case 'IS': case 'AJ': case 'TS': case 'PV': 
            case 'CV': case 'CR': case 'DS': case 'AP': case 'AR': case 'GJ': case 'quotation': case 'QT':
              $sql = $sql.""; 
            break;

            case'CUSTOMER': case'SUPPLIER': case'WAREHOUSE': case'AGENT':
            case 'quotation': case 'QT': 
              $sql = $sql." union all select s.clientid,'CREATE',concat(s.client,'-',s.clientname),s.createby,s.createdate,if(u.pic='','blank_user.png',pic) as pic from client as s left join useraccess as u on u.username=s.createby where s.clientid='$trno'";
            break;
          }//end switich

          $sql=$sql." order by dateid desc";
          return $sql;
        }

      public function openUserlog($date1,$date2,$doc='',$userid=''){
        $sql="";
        $module="";
        $username="";
        if ($userid=="") { $username = ""; }
        if ($doc!="") { $module = " and cntnum.doc ='$doc'"; }
        if ($userid!="") { $username = " and tl.userid ='$userid'"; }
        switch ($doc) {
          case "ALL":
            $sql = "select cntnum.doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid, '' as clientname, '' as client
            from table_log as tl left join cntnum on cntnum.trno = tl.trno
            where  date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d')
            and date_format('$date2','%Y-%m-%d') $username
            union all
            select 'CL' as doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid,client.clientname,client.client
            from client_log as tl left join client on client.clientid = tl.trno
            where  date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d')
            and date_format('$date2','%Y-%m-%d')  $username
            union all
            select 'SK' as doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid,item.itemname as clientname,item.barcode as client
            from item_log as tl left join item on item.itemid = tl.trno
            where  date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d')
            and date_format('$date2','%Y-%m-%d')  $username
            union all
            select cntnum.doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid, '' as clientname, '' as client
            from transnum_log as tl left join transnum as cntnum on cntnum.trno = tl.trno
            where date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d')
            and date_format('$date2','%Y-%m-%d') $username
            order by dateid";
          break;
          case "PO": case "SO": case "JO": case "PC": case "KR": case "EX": case "JO":
            $sql ="select cntnum.doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid
            from transnum_log as tl left join transnum as cntnum on cntnum.trno = tl.trno where date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d') and date_format('$date2','%Y-%m-%d') $module $username order by dateid";
          break;
          case "SJ": case "CM": case "DM": case "RR": case "IS": case "CV": case "CR": case "AR": case "AP": case "TS": case "PV": case "AJ": case "DS": case "GJ":
            $sql ="select cntnum.doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid
            from table_log as tl left join cntnum on cntnum.trno = tl.trno where  date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d') and date_format('$date2','%Y-%m-%d') $module $username order by dateid";
          break;
          case "CL":
            $sql="select 'CL' as doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid,client.clientname,client.client
            from client_log as tl left join client on client.clientid = tl.trno where  date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d') and date_format('$date2','%Y-%m-%d')  $username order by tl.dateid";
          break;
          case "SK":
            $sql="select 'SK' as doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid,item.itemname as clientname,item.barcode as client
            from item_log as tl left join item on item.itemid = tl.trno where  date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d') and date_format('$date2','%Y-%m-%d')  $username order by tl.dateid";
          break;
          default:
            $sql ="select cntnum.doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid
            from transnum_log as tl left join transnum as cntnum on cntnum.trno = tl.trno where date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d') and date_format('$date2','%Y-%m-%d') $module $username
            union all
            select cntnum.doc,tl.field as task,tl.oldversion,tl.userid,tl.dateid
            from table_log as tl left join cntnum on cntnum.trno = tl.trno where date_format(tl.dateid,'%Y-%m-%d') between date_format('$date1','%Y-%m-%d') and date_format('$date2','%Y-%m-%d') $module $username order by dateid";
          break;
        }
        return array('sql'=>$sql,'doc'=>$doc);
        // $data = Yii::$app->sbccommon->opentable($sql);
        // if(!empty($data)){
        //     return $data;
        // }else{
        //     return false;
        // }
      }
}