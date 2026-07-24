<?php

namespace app\models;

use Yii;
use yii\base\Model;

//EMPLOYEE
use app\models\Employee;
use app\models\Webproc;
use app\models\Lastock;
use app\models\Ladetail;
use yii\base\ErrorException;

class Common extends Model {
    

   public static function getdefaultwarehouse(){
    return "WH1";
   }

   public static function decimalplaces(){
       return Yii::$app->systemsettings->setDecimaldisplay();
   }

   public static function getdefaultclient() {        
        return 'CL00000001';
    }
    
   public static function getwebpackage(){
       //0 - AIMS
       //1 - MIS
       //2 - AMS
       
       return 0;
       
   } 


    //ALL SETTINGS OF THE SYSTEM WILL BE REDIRECTED TO
    //systemsettings component (press ctrl+P then search for syssettings)

    public static function getcompanyid(){ //THIS FUNCTION WILL SOON BE DEPRECATED [NOTE: DONT USE THIS ANYMORE]
        return 0;
    }//end function

    public function doclength() {
        $length = Yii::$app->systemsettings->setDefaultDocumentLength();
        return $length;
    }//end function

    public function clientlength() {
        $length = Yii::$app->systemsettings->setDefaultClientLength();
        return $length;
    }//end function

    public function barcodelength() {
        $length = Yii::$app->systemsettings->setDefaultBarcodeLength();
        return $length;
    }//end function
    //END SETTINGS ############################################################

    
    public static function allowviewcost(){
       if (Yii::$app->user->access[368] != 1) { // allow change of wh transaction
           return false;
           }else{       
        return true;}
        
    }
    
    public static function adminnotallowview(){
       if (Yii::$app->user->access[361] != 1) { // allow Administrator
           return false;
           }else{       
        return true;}
        
    }
    
    public static function strictWH(){
       if (Yii::$app->user->access[545] != 1) { // allow change of wh transaction
           return true;
           }else{       
        return false;}
    }

    
    public static function strictCenter(){
        return true;
    }

    public static function localhead($doc) {
        switch ($doc) {
            case 'SP': $table='spchead'; break;
            case 'JB': $table='jbhead'; break;
            case 'QA': $table='qahead'; break;
            case 'TX': $table = 'txhead'; break;
            case 'RF': $table = "rfhead"; break;
            case 'PD': $table = "pdhead"; break;
            case 'PI': $table = "pihead"; break;
            case 'KR': $table = "krhead"; break;
            case 'PO': $table = "pohead"; break;
            case 'SO': $table = "sohead"; break;
            case 'PC': $table = "pchead"; break;
            case 'PR': $table = "prhead"; break;
            case 'expenses': case 'EX': $table = "expenses"; break;

            case 'quotation': case 'QT': $table = "quotehead"; break;
            case 'JO': $table = "johead"; break;
            case 'QT': $table = "qthead"; break;    
            case 'TW': $table = "taxhead"; break;
            case 'TR': $table = "trhead"; break;
            case 'pscheme': case 'PS': $table = "pschemehead"; break;
            default: $table = "lahead"; break;
        }
        return $table;
    }

    public static function localhhead($doc) {
        switch ($doc) {
            case 'SP': {
                    $table = "hspchead";
                    break;
                }
            case 'JB': {
                    $table = "hjbhead";
                    break;
                }

            case 'PD': {
                    $table = "hpdhead";
                    break;
                }

            case 'PI': {
                    $table = "hpihead";
                    break;
                }

            case 'quotation': case 'QT':{
                    $table = "hquotehead";
                    break;
            }
            case 'PO': {
                    $table = "hpohead";
                    break;
                }
            case 'RF': {
                    $table = "hrfhead";
                    break;
                }
            case 'TX': {
                    $table = "htxhead";
                    break;
            }//end if
            case 'QA': {
                    $table = "hqahead";
                    break;
            }//end if
            case 'SO': {
                    $table = "hsohead";
                    break;
                }
            case 'PC': {
                    $table = "hpchead";
                    break;
                }
            case 'PR': {
                    $table = "hprhead";
                    break;
                }
                
            case 'JO': {
                    $table = "hjohead";
                    break;
                }
            case 'EX':
               {
                $table='hexpenses';
                break;
               }
            case 'QT':
                {
                $table = "hqthead";
                break;
                }
            //TW KEYWORD    
            case 'TW':
                {
                $table = "htaxhead";
                break;
                }
            // SALON MODIFICATION    
            case 'TR':{
                $table = "htrhead";
                break;
             }       

            case 'pscheme': case 'PS': {
                $table = "hpschemehead";
                break;
            }//end if

            // END SALON        
            case 'KR':{ $table = "hkrhead";}break;    
            default: { $table="glhead"; break;}
        }

        return $table;
    }

    public static function localstock($doc) {
        switch ($doc) {
            case 'SP':
            $table = "spcstock";
            break;

            case 'JB':
                $table = "jbstock";
            break;

            case 'tpshipping':
                $table = "tp_shippingfees";
            break;


            case 'tphandling':
                $table = "tp_handlingfees";
            break;
            
            case 'PS': case 'pscheme':{
                $table = "pschemestock";
            break;
            }//end f

            case 'QA': {
                    $table = "qastock";
                    break;
                }

            case 'quotation': case 'QT':{
                    $table = "quotestock";
                    break;
            }
            case 'PD': {
                    $table = "pdstock";
                    break;
                }
            case 'PI': {
                    $table = "pistock";
                    break;
                }
            case 'PO': {
                    $table = "postock";
                    break;
                }
            case 'SO': {
                    $table = "sostock";
                    break;
                }
            case 'PC': {
                    $table = "pcstock";
                    break;
                }
            case 'PR': {
                    $table = "prstock";
                    break;
                }
                
             case 'JO': {
                 $table = "joservice";
                 break;
             }
             case 'QT':{
                 $table = "qtstock";
                 break;                 
             }

             // SALON MODIFICATION    
            case 'TR':{
                $table = "trstock";
                break;
            }        
            // END SALON
            default: {
                    $table = "lastock";
                    break;
                }
        }
        return $table;
    }

    public static function localhstock($doc) {
        switch ($doc) {
            case 'SP':
            $table = "hspcstock";
            break;

            case 'JB':
                $table = "hjbstock";
            break;

            case 'PS': case 'pscheme':{
                $table = "hpschemestock";
            break;
            }

            case 'QA': {
                $table = "hqastock";
                break;
            }
            case 'PD': {
                $table = "hpdstock";
                break;
            }
            case 'PI': {
                $table = "hpistock";
                break;
            }

            case 'quotation': case 'QT': {
                $table = "hquotestock";
                break;
            }
            case 'PO': {
                $table = "hpostock";
                break;
            }
            case 'SO': {
                $table = "hsostock";
                break;
            }
            case 'PC': {
                $table = "hpcstock";
                break;
            }
            case 'PR': {
                $table = "hprstock";
                break;
            }                
            case 'JO': {
                $table = "hjoservice";
                break;
            }
            
            case 'QT':{
                $table="hqtstock";
                break;
            }

            //TW KEYWORD
            case 'TW':{
                $table="htwstock";
                break;
            }

            // SALON MODIFICATION    
            case 'TR':{
                $table = "htrstock";
                break;
            }        
            // END SALON
                
            default: {
                $table = "glstock";
                break;
            }
        }

        return $table;
    }

    public static function localdetail($doc) {
        switch ($doc) {
            case 'QT': {
             $table="qtdetail"; 
             break;
             }
             //TW KEYWORD
             case 'TW': {
             $table="taxdetail"; 
             break;
             }
            default: {
            $table = "ladetail";
            break;
            }
        }

        return $table;
    }

    public static function glhead() {
        $table = "glhead";
        return $table;
    }

    public static function glstock() {
        $table = "glstock";
        return $table;
    }

    public static function gldetail() {
        $table = "gldetail";
        return $table;
    }

    public static function hglhead() {
        $table = "hglhead";
        return $table;
    }

    public static function hglstock() {
        $table = "hglstock";
        return $table;
    }

    public static function hgldetail() {
        $table = "hgldetail";
        return $table;
    }

    public static function getcentername($code) {
        $data = Yii::$app->sbccommon->datareader("select name from center where code='$code'");
        return $data;
    }

    public static function defaultwarehouse() {
        $center = Yii::$app->session['loggeduser']['center'];
        $data = Yii::$app->sbccommon->opentable("select center.warehouse,client.clientname as warehousename,center.sellingprice,center.commission,center.icommission from center left join client on client.client=center.warehouse where center.code='$center'");
        return $data[0];
    }
    
    public static function defaultcenter() {
        $center = Yii::$app->user->center;
        $data = Yii::$app->sbccommon->opentable("select name,code from center where code='$center'");
        return $data[0];
    }

    public static function isBalanced($trno, $table) {
        $data = Yii::$app->sbccommon->opentable("select sum(db) as db, sum(cr) as cr from $table where trno=$trno");
        if (($data[0]['db'] - $data[0]['cr']) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function isBalanced_kr($trno) {
        $data = Yii::$app->sbccommon->opentable("select sum(db) as db, sum(cr) as cr from arledger where kr='$trno'");
        if (($data[0]['db'] - $data[0]['cr']) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function SearchPosition($Search) {
        
        for ($i = 0; $i <= strlen($Search); $i++) {
            if (strspn(substr($Search, $i, 1), '1234567890')) {
                return $i;
            }
        }
        
    }

        public function SearchPositionNonZero($Search) {
        
        for ($i = 0; $i <= strlen($Search); $i++) {
            if (strspn(substr($Search, $i, 1), '123456789')) {
                return $i;
            }
        }
        
        }

        public function SearchPositionChar($Search,$char) {
        for ($i = 0; $i <= strlen($Search); $i++) {
            if (strspn(substr($Search, $i, 1), $char)) {
                return $i;
            }
        }
        }

    
// end SearchPosition

    public function GetPrefix($PadString) {
        $Prefix = strtoupper(substr($PadString, 0, $this->SearchPosition($PadString)));
        return $Prefix;
    }

//GetPrefix

    public function getlastseq($prefix,$doc,$center){ //ADDED CENTER PARAMETER SO IT CAN BE CHANGED FROM OTHER FUNCTION CALLING IT
        $table = Common::gettablenum($doc);
        return Yii::$app->sbccommon->datareader("select ifnull(max(seq),0) + 1 as seq from $table where bref='$prefix' and center='$center'");
    }

    function PadJ($PadString, $Len) {
        if ($Len == 0) {
            return $PadString;
        }
        
        $Prefix = strtoupper(substr($PadString, 0, $this->SearchPosition($PadString)));
        if ($Prefix == '') {
            $Prefix = $PadString;
        }
        
        $Number = floatval(substr($PadString, $this->SearchPosition($PadString), strlen($PadString)));
        if ($Number == 0) {
            $Number = 1;
        }
        if ((strlen($Prefix) + strlen($Number)) < $Len) {
            $Return = strtoupper($Prefix) . str_pad($Number, $Len - (strlen($Prefix)), '0', STR_PAD_LEFT);
        } else {
            $Return = $PadString;
        }
        return $Return;
    }

//PadJ

    public function gettrno($docno,$doc) {
        $center = Yii::$app->session['loggeduser']['center'];
        $table = Common::gettablenum($doc);        
        $check = Yii::$app->sbccommon->datareader("select trno from $table where doc='".$doc."'and docno='".$docno."' and center='".$center."'");

        return $check;
    }

   
    
    public static function getclientname($client) {
        return Yii::$app->sbccommon->datareader("select clientname from client where client='".$client."'");
    }
    public static function getclientnamebyid($clientid) {
        return Yii::$app->sbccommon->datareader("select clientname from client where clientid=".$clientid);
    }

    public static function checkserveditems($trno) {
        return Yii::$app->sbccommon->datareader("select sum(round(qa,0)) as served from postock where trno='".$trno."'");
    }

    public static function navnext_prev($code, $uniqueid, $doc, $action) {
        try {
        switch ($doc) {
            //KEYWORD LOCATION&VENDOR
            case 'customer': case 'supplier':
            case 'warehouse': case 'agent': case 'location': case 'vendor': case 'assetmaster':
            case 'branch':
            //END KEYWORD LOCATION&VENDOR
            //added patches for client masterfiles - for repatched navigation
                switch ($action) {
                    case 'next': {
                        $clientid = Common::nextfile($uniqueid, $doc);
                        return $clientid;
                        break;
                    }
                    
                    case 'previous': {
                        $clientid = Common::previousfile($uniqueid, $doc);
                        return $clientid;
                        break;
                    }
                    
                    case 'delete': {
                        $newclientid = Common::nextfile($uniqueid, $doc);
                        if ($newclientid == $uniqueid) {
                            $newclientid = Common::previousfile($uniqueid, $doc);
                        }
                        return $newclientid;
                        break;
                    }
                }//end switch

            //EMPLOYEE
            case 'employee':
                switch ($action) {
                    case 'next': {
                        $clientid = Common::nextfileemployee($uniqueid, $doc);
                        return $clientid;
                        break;
                    }
                    
                    case 'previous': {
                        $clientid = Common::previousfileemployee($uniqueid, $doc);
                        return $clientid;
                        break;
                    }
                    
                    case 'delete': {
                        $newclientid = Common::nextfileemployee($uniqueid, $doc);
                        if ($newclientid == $uniqueid) {
                            $newclientid = Common::previousfileemployee($uniqueid, $doc);
                        }
                        return $newclientid;
                        break;
                    }
                }//end switch
            break;
            
            case 'FG':
                switch ($action) {
                    case 'next': $itemid = Common::nextitem2($uniqueid, $doc); return $itemid; break;
                    case 'previous': $itemid = Common::previousitem2($uniqueid, $doc); return $itemid; break;
                    case 'delete':
                        $newitemid = Common::nextitem2($uniqueid, $doc);
                        if($newitemid == $uniqueid) {
                            $newitemid = Common::previousitem2($uniqueid, $doc);
                        }
                        return $newitemid;
                    break;
                }//end switch
            break;

            case 'stockcard': case 'posstockcard':
                //added patches for stockcard - for repatched navigation
                switch ($action) {
                    case 'next':
                        $itemid = Common::nextitem($uniqueid, $doc);
                        return $itemid;
                    break;
                    
                    case 'previous':
                        $itemid = Common::previousitem($uniqueid, $doc);
                        return $itemid;
                    break;
                    
                    case 'delete':
                        $newitemid = Common::nextitem($uniqueid, $doc);
                        if ($newitemid == $uniqueid) {
                            $newitemid = Common::previousitem($uniqueid, $doc);
                        }
                        return $newitemid;
                    break;
                }//END SWITCH
            break; //END stockcard

            case 'itemprofile':
                switch ($action) {
                    case 'next': {
                        $itemid = Common::nextitemfa($uniqueid, $doc);
                        return $itemid;
                        break;
                    }
                    
                    case 'previous': {
                        $itemid = Common::previousitemfa($uniqueid, $doc);
                        return $itemid;
                        break;
                    }
                    
                    case 'delete': {
                        $newitemid = Common::nextitemfa($uniqueid, $doc);
                        if ($newitemid == $uniqueid) {
                            $newitemid = Common::previousitemfa($uniqueid, $doc);
                        }
                        return $newitemid;
                        break;
                    }
                }
            break;            

            default:{
                switch ($action) {
                    case 'next': {
                        $trno = Common::nextdoc($code, $doc, $uniqueid);
                        return $trno;
                        break;
                    }//end next
                    
                    case 'previous': {
                        $trno = Common::previousdoc($code, $doc, $uniqueid);
                        return $trno;
                        break;
                    }//end previ
                    
                    case 'delete': {
                        $newtrno = Common::nextdoc($code, $doc, $uniqueid);
                        
                        if ($newtrno == $uniqueid) {
                            $newtrno = Common::previousdoc($code, $doc, $uniqueid);    
                            if ($newtrno == $uniqueid) {
                                $newtrno = "";
                            }
                        }//end new trno === trno 
                        return $newtrno;
                        break;
                    }//end delete
                }
            }//end default
        }//END NAV NEXT SWITCH
          //code...
         } catch (ErrorException $th) {
            echo $th;
        }
    }//END COMMON NAV NEXT PREV

    public static function nextfile($clientid, $type) {
        switch ($type) {
            case 'customer': {
                    $condition = ' where iscustomer=1 ';
                    break;
                }
            case 'supplier': {
                    $condition = ' where issupplier=1 ';
                    break;
                }
            case 'warehouse': {
                    $condition = ' where iswarehouse=1 ';
                    break;
                }
            case 'agent': {
                    $condition = ' where isagent=1 ';
                    break;
                }
            case 'location': {
                    $condition = ' where islocation=1 ';
                    break;
                }    
            case 'vendor': {
                    $condition = ' where isvendor=1 ';
                    break;
                }        
            case 'assetmaster': {
                    $condition = ' where isasset=1 ';
                    break;
                }        

            case 'branch': $condition = ' where isbranch=1 '; break;
        }
        $records = Yii::$app->sbccommon->opentable("select clientid from client ".$condition." order by client asc");
        $lastrecord = Yii::$app->sbccommon->datareader("select clientid from client  ".$condition." order by client desc limit 1");
        $last = count($records) - 1;
      if(!empty($lastrecord)||$lastrecord!=0){
        if ($clientid == $lastrecord) {
            $clientid = $records[$last]['clientid'];
            return $clientid;
        } else {
            for ($i = 0; $i < count($records); $i++) {
                if ($clientid == $records[$i]['clientid']) {
                    $id = $i + 1;
                    $clientid = $records[$id]['clientid'];
                    return $clientid;
                }
            }
        }
      }else{return 0;}
    }

//EMPLOYEE
    public static function nextfileemployee($clientid, $type) {
        
        $records = Yii::$app->sbccommon->opentable("select empid from employee order by empcode asc");
        $lastrecord = Yii::$app->sbccommon->datareader("select empid from employee order by empcode desc limit 1");
        $last = count($records) - 1;
      if(!empty($lastrecord)||$lastrecord!=0){
        if ($clientid == $lastrecord) {
            $clientid = $records[$last]['empid'];
            return $clientid;
        } else {
            for ($i = 0; $i < count($records); $i++) {
                if ($clientid == $records[$i]['empid']) {
                    $id = $i + 1;
                    $clientid = $records[$id]['empid'];
                    return $clientid;
                }
            }
        }
      }else{return 0;}
    }

    public static function previousfile($clientid, $type) {
        switch ($type) {
            case 'customer': {
                    $condition = ' where iscustomer=1 ';
                    break;
                }
            case 'supplier': {
                    $condition = ' where issupplier=1 ';
                    break;
                }
            case 'warehouse': {
                    $condition = ' where iswarehouse=1 ';
                    break;
                }
            case 'agent': {
                    $condition = ' where isagent=1 ';
                    break;
                }
            //KEYWORD LOCATION&VENDOR    
            case 'location': {
                    $condition = ' where islocation=1 ';
                    break;
                } 
            case 'vendor': {
                    $condition = ' where isvendor=1 ';
                    break;
                }
            case 'assetmaster': {
                    $condition = ' where isasset=1 ';
                    break;
                }
            //END KEYWORD LOCATION&VENDOR
            case 'branch': $condition = ' where isbranch=1 '; break;
        }
        $records = Yii::$app->sbccommon->opentable("select clientid from client ".$condition." order by client asc");
        $firstrecord = Yii::$app->sbccommon->datareader("select clientid from client ".$condition." order by client asc limit 1");
        $last = count($records) - 1;
        if(!empty($firstrecord)||$firstrecord!=0){
        if ($clientid == $firstrecord) {
            $clientid = $records[$last]['clientid'];
            return $clientid;
        } else {
            for ($i = 0; $i < count($records); $i++) {
                if ($clientid == $records[$i]['clientid']) {
                    $id = $i - 1;
                    $clientid = $records[$id]['clientid'];
                    return $clientid;
                }
            }
        }
        }else{Return 0;}
    }

    //EMPLOYEE
    public static function previousfileemployee($clientid, $type) {
        
        $records = Yii::$app->sbccommon->opentable("select empid from employee order by empcode asc");
        $firstrecord = Yii::$app->sbccommon->datareader("select empid from employee order by empcode asc limit 1");
        $last = count($records) - 1;
        if(!empty($firstrecord)||$firstrecord!=0){
            if ($clientid == $firstrecord) {
                $clientid = $records[$last]['empid'];
                return $clientid;
            } else {
                for ($i = 0; $i < count($records); $i++) {
                    if ($clientid == $records[$i]['empid']) {
                        $id = $i - 1;
                        $clientid = $records[$id]['empid'];
                        return $clientid;
                    }
                }
            }//end if 
        }else{
            return 0;
        }//end if
    }
    
    public static function gettablenum($doc){
        switch ($doc) {
            case 'QA': case 'PD': case 'PI': case 'PO': case 'SO': case 'PC': case 'PR': case 'SP':
            case 'EX': case 'KR': case 'JO': case 'QT': case 'TR': case 'RF': case 'TX': case 'pscheme': case 'PS':
            case 'quotation': case 'QT': 
            case 'JB':
                $table='transnum';
            break;
            case 'TW':
                $table='taxnum';
            break;
            
            default:
                $table='cntnum';
            break;
        }   

        
        return $table;
    }
    
    public static function nextdoc($docno, $doc, $trno) {
        $center = Yii::$app->session['loggeduser']['center'];
        $table = Common::gettablenum($doc);
        $d = new Webproc();
        
        //PUT VALIDATION HERE
        switch ($doc) {
            case 'PO':
                 $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                if(Yii::$app->backend->checkConfidentialAccess()){
                    $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno >= ".$trno." and bref = '".$bref."' order by docno asc";
                    $lastrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref='".$bref."' order by docno desc limit 1";
                }else{
                    $recordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join pohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno >= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hpohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno >= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc limit 1000";
                    
                    $lastrecordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join pohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hpohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."'
                    and client.groupid <> 'CONFI') as tbl
                    order by docno desc limit 1";
                }//end if
            break;

            case 'PR':
                $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                if(Yii::$app->backend->checkConfidentialAccess()){
                    $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno >= ".$trno." and bref = '".$bref."' order by docno asc";
                    $lastrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref='".$bref."' order by docno desc limit 1";
                }else{
                    $recordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join prhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno >= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hprhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno >= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc limit 1000";
                    
                    $lastrecordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join prhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."'
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hprhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."'
                    and client.groupid <> 'CONFI') as tbl
                    order by docno desc limit 1";
                }//end if
            break;

            case 'SP': case 'DM':
                $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                if(Yii::$app->backend->checkConfidentialAccess()){
                    $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno >= ".$trno." and bref = '".$bref."' order by docno asc";
                    $lastrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref='".$bref."' order by docno desc limit 1";
                }else{
                    $recordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join lahead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno >= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join glhead as head on head.trno = ".$table.".trno
                    left join client on client.clientid = head.clientid
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno >= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc limit 1000";
                    
                    $lastrecordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join lahead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."'
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join glhead as head on head.trno = ".$table.".trno
                    left join client on client.clientid = head.clientid
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."'
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc limit 1";
                }//end if
            break;
            
            default:
                $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno >= ".$trno." and bref = '".$bref."' order by docno asc";
                $lastrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref='".$bref."' order by docno desc limit 1";
            break;
        }//END SWITCH CASE


        $records = Yii::$app->sbccommon->opentable($recordqry);
        $lastrecord = Yii::$app->sbccommon->datareader($lastrecordqry);
        $last = count($records) - 1;
        
        if (!empty($lastrecord)) {
            if ($trno == $lastrecord && !empty($lastrecord)) {
                $trno = $records[$last]['trno'];
                return $trno;
            } else {
                for ($i = 0; $i < count($records); $i++) {
                    if ($trno == $records[$i]['trno']) {
                        $id = $i + 1;
                        $trno = $records[$id]['trno'];
                        return $trno;
                    }
                }//end for each
            }//end if trno last record
        }//end if empty(lastrecord)
    }//end if next doc

    public static function previousdoc($docno, $doc, $trno) {
        try { 
        $center = Yii::$app->session['loggeduser']['center'];
        $table = Common::gettablenum($doc);
        //PUT VALIDATION HERE
        switch ($doc) {
            case 'PO':
                $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                if(Yii::$app->backend->checkConfidentialAccess()){
                    $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno <= ".$trno." and bref = '".$bref."' order by docno asc";
                    $firstrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref = '".$bref."' order by docno asc limit 1";
                }else{
                    $recordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join pohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno <= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hpohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno <= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno desc limit 1000";
                    
                    $firstrecordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join pohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hpohead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc limit 1";
                }//end if
            break;

            case 'PR':
                $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                if(Yii::$app->backend->checkConfidentialAccess()){
                    $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno <= ".$trno." and bref = '".$bref."' order by docno asc";
                    $firstrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref = '".$bref."' order by docno asc limit 1";
                }else{
                    $recordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join prhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno <= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hprhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno <= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc";
                    
                    $firstrecordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join prhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join hprhead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc limit 1";
                }//end if
            break;

            case 'SP': case 'DM':
                $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                if(Yii::$app->backend->checkConfidentialAccess()){
                    $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno <= ".$trno." and bref = '".$bref."' order by docno asc";
                    $firstrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref = '".$bref."' order by docno asc limit 1";
                }else{
                    $recordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join lahead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno <= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join glhead as head on head.trno = ".$table.".trno
                    left join client on client.clientid = head.clientid
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".trno <= ".$trno." and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc";
                    
                    $firstrecordqry = "select trno from (
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join lahead as head on head.trno = ".$table.".trno
                    left join client on client.client = head.client
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI'
                    UNION ALL
                    select ".$table.".trno,".$table.".docno from ".$table."
                    left join glhead as head on head.trno = ".$table.".trno
                    left join client on client.clientid = head.clientid
                    where ".$table.".doc='".$doc."' and ".$table.".center='".$center."' and ".$table.".bref = '".$bref."' 
                    and client.groupid <> 'CONFI') as tbl
                    order by docno asc limit 1";
                }//end if
            break;
            
            default:    
                ini_set('memory_limit', '-1'); 
                ini_set('max_execution_time', '-1');
                $bref = Common::getDocumentBref($table, $doc, $center, $trno);
                $firstrecordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and bref = '".$bref."' order by docno asc limit 1";
                $recordqry = "select trno from ".$table." where doc='".$doc."' and center='".$center."' and trno <= ".$trno." and bref = '".$bref."' order by docno asc";
            break;
        }//END SWITCH CASE
        
        $records = Yii::$app->sbccommon->opentable($recordqry);
        $firstrecord = Yii::$app->sbccommon->datareader($firstrecordqry);

        if (!empty($firstrecord)) {
            if ($trno == $firstrecord) {
                $trno = $records[0]['trno'];
                return $trno;
            } else {
                for ($i = 0; $i < count($records); $i++) {
                    if ($trno == $records[$i]['trno']) {
                        $id = $i - 1;
                        $trno = $records[$id]['trno'];
                        return $trno;
                    }//end if
                }//end for
            }//end if
        }//end fi

        } catch (ErrorException $th) {
            echo $th;
        }
    }

    public static function getDocumentBref($table, $doc, $center, $trno){
        $qry = "select bref from ".$table." where doc='".$doc."' and center='".$center."' and trno = ". $trno . " limit 1";
        $documentbref = Yii::$app->sbccommon->datareader($qry);
        return $documentbref;
    }//end f

    public static function nextitem2($itemid, $type) {
        $records = Yii::$app->sbccommon->opentable("select itemid from item where fg_isfinishedgood = 1 order by barcode asc");
        $lastrecord = Yii::$app->sbccommon->datareader("select itemid from item where fg_isfinishedgood = 1 order by barcode desc limit 1");
        $last = count($records) - 1;
        if($itemid == $lastrecord) {
            $itemid = $records[$last]['itemid'];
            return $itemid;
        } else {
            for($i = 0; $i < count($records); $i++) {
                if($itemid == $records[$i]['itemid']) {
                    $id = $i + 1;
                    $itemid = $records[$id]['itemid'];
                    return $itemid;
                }//end if
            }//end for each
        }//end if
    }//end fn

    public static function nextitem($itemid, $type) {

        $records = Yii::$app->sbccommon->opentable("select itemid from item order by barcode asc");
        $lastrecord = Yii::$app->sbccommon->datareader("select itemid from item  order by barcode desc limit 1");
        $last = count($records) - 1;
        if ($itemid == $lastrecord) {
            $itemid = $records[$last]['itemid'];
            return $itemid;
        } else {
            for ($i = 0; $i < count($records); $i++) {
                if ($itemid == $records[$i]['itemid']) {

                    $id = $i + 1;
                    $itemid = $records[$id]['itemid'];
                    return $itemid;
                }
            }
        }
    }//end fn


    public static function previousitem2($itemid, $type) {
        $records = Yii::$app->sbccommon->opentable("select itemid from item where fg_isfinishedgood = 1 order by barcode asc");
        $firstrecord = Yii::$app->sbccommon->datareader("select itemid from item where fg_isfinishedgood = 1 order by barcode asc limit 1");
        if($itemid == $firstrecord) {
            return $itemid;
        } else {
            for($i = 0; $i < count($records); $i++) {
                if($itemid == $records[$i]['itemid']) {
                    $id = $i - 1;
                    $itemid = $records[$id]['itemid'];
                    return $itemid;
                }
            }
        }
    }//end fn

    public static function previousitem($itemid, $type) {
        $records = Yii::$app->sbccommon->opentable("select itemid from item  order by barcode asc");
        $firstrecord = Yii::$app->sbccommon->datareader("select itemid from item  order by barcode asc limit 1");
        if ($itemid == $firstrecord) {
//            $itemid=$records[$last]['itemid'];
            return $itemid;
        } else {
            for ($i = 0; $i < count($records); $i++) {
                if ($itemid == $records[$i]['itemid']) {
                    $id = $i - 1;
                    $itemid = $records[$id]['itemid'];
                    return $itemid;
                }
            }
        }
    }//end fn

    public static function navfirst_last($doc, $action) {
            switch ($doc) {
                case 'QA': case 'MX': case 'SP':
                case 'PI': case 'PK': case 'PD': case 'SO': case 'PO':
                case 'SJ': case 'RR': case 'CA': case 'DM': case 'CM':
                case 'AJ': case 'TS': case 'PU': case 'PV': case 'CV':
                case 'CR': case 'GJ': case 'DS': case 'IS': case 'AP':
                case 'AR': case 'KR': case 'PC': case 'PR': case 'EX':    
                case 'JO': case 'MI': case 'CH': case 'QT': case 'TR':
                case 'TW': case 'SP': case 'RF': case 'TX':
                case 'PS': case 'pscheme': case 'JB': case 'SV':
                case 'quotation': case 'QT':
                    $trno = Common::first_lastdoc($doc, $action);
                    return $trno;
                break;
                
                case 'employee':
                    $empid = Common::first_lastemp($doc, $action);
                    return $empid;
                break;

                case 'customer': case 'supplier': case 'warehouse':
                case 'agent': case 'location': case 'vendor': case 'assetmaster':
                case 'branch':
                    $clientid = Common::first_lastfile($action, $doc);
                    return $clientid;
                break;
                    
                case 'stockcard':  case 'posstockcard': case 'FG':
                    $itemid = Common::first_lastitem($action, $doc);
                    return $itemid;
                break;

                case 'itemprofile':
                    $itemid = Common::first_lastitemfa($action, $doc);
                    return $itemid;
                break;                        
            }//end switch case
    } //END navfirst_last

        public static function first_lastfile($action, $type) {
        switch ($type) {
            case 'customer': {
                    $condition = ' where iscustomer=1 ';
                    break;
                }
            case 'supplier': {
                    $condition = ' where issupplier=1 ';
                    break;
                }
            case 'warehouse': {
                    $condition = ' where iswarehouse=1 ';
                    break;
                }
            case 'agent': {
                    $condition = ' where isagent=1 ';
                    break;
                }
             //KEYWORD LOCATION&VENDOR    
            case 'location': {
                    $condition = ' where islocation=1 ';
                    break;
                }
            case 'vendor': {
                    $condition = ' where isvendor=1 ';
                    break;
                }    
            case 'assetmaster': {
                $condition = ' where isasset=1' ;
                break;
            }

            case 'branch': $condition = ' where isbranch = 1 '; break;
            //END KEYWORD LOCATION&VENDOR
        }
        if ($action == "first") {
            $clientid = Yii::$app->sbccommon->datareader("select clientid from client $condition order by client asc limit 1");
            return $clientid;
        }
        if ($action == "last") {
            $clientid = Yii::$app->sbccommon->datareader("select clientid from client $condition order by client desc limit 1");
            return $clientid;
        }
    }

    public static function first_lastdoc($doc, $action) {
        $center = Yii::$app->session['loggeduser']['center'];
        $table = Common::gettablenum($doc);

        if ($doc == 'pscheme') {
            $doc ='PS';
        }//end if


        if($doc == 'quotation'){
            $doc = 'QT';
        }
        
        if ($action == "first") {
            switch ($doc) {
                case 'PO':
                    if(Yii::$app->backend->checkConfidentialAccess()){
                        $qryfirst = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno asc limit 1";
                    }else{
                        /*$qryfirst = "select trno from $table 
                        where doc='".$doc."' 
                        and center='".$center."' order by docno asc limit 1";*/
                        $qryfirst = "select trno from (
                                        select $table.trno,$table.docno from $table
                                        left join pohead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                        UNION ALL
                                        select $table.trno,$table.docno from $table
                                        left join hpohead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                    ) as tbl order by docno asc limit 1";
                    }//end if
                break;

                case 'PR':
                    if(Yii::$app->backend->checkConfidentialAccess()){
                        $qryfirst = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno asc limit 1";
                    }else{
                        /*$qryfirst = "select trno from $table 
                        where doc='".$doc."' 
                        and center='".$center."' order by docno asc limit 1";*/
                        $qryfirst = "select trno from (
                                        select $table.trno,$table.docno from $table
                                        left join prhead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                        UNION ALL
                                        select $table.trno,$table.docno from $table
                                        left join hprhead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                    ) as tbl order by docno asc limit 1";
                    }//end if
                break;

                case 'SP': case 'DM':
                    if(Yii::$app->backend->checkConfidentialAccess()) {
                        $qryfirst = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno asc limit 1";
                    } else {
                        $qryfirst = "select trno from (
                                        select $table.trno,$table.docno from $table
                                        left join lahead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                        UNION ALL
                                        select $table.trno,$table.docno from $table
                                        left join glhead as head on head.trno = $table.trno
                                        left join client on client.clientid = head.clientid
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                    ) as tbl order by docno asc limit 1";
                    }
                break;
                
                default:
                    $qryfirst = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno asc limit 1";
                break;
            }
            $trno = Yii::$app->sbccommon->datareader($qryfirst);
            return $trno;
        }


        if ($action == "last") {
            switch ($doc) {
                case 'PO':
                    if(Yii::$app->backend->checkConfidentialAccess()){
                        $qrylast = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno desc limit 1";
                    }else{
                        /*$qryfirst = "select trno from $table 
                        where doc='".$doc."' 
                        and center='".$center."' order by docno asc limit 1";*/
                        $qrylast = "select trno from (
                                        select $table.trno,$table.docno from $table
                                        left join pohead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                        UNION ALL
                                        select $table.trno,$table.docno from $table
                                        left join hpohead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                    ) as tbl order by docno desc limit 1";
                    }//end if
                break;

                case 'PR':
                    if(Yii::$app->backend->checkConfidentialAccess()){
                        $qrylast = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno desc limit 1";
                    }else{
                        /*$qryfirst = "select trno from $table 
                        where doc='".$doc."' 
                        and center='".$center."' order by docno asc limit 1";*/
                        $qrylast = "select trno from (
                                        select $table.trno,$table.docno from $table
                                        left join prhead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                        UNION ALL
                                        select $table.trno,$table.docno from $table
                                        left join hprhead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                    ) as tbl order by docno desc limit 1";
                    }//end if
                break;

                case 'SP': case 'DM':
                    if(Yii::$app->backend->checkConfidentialAccess()){
                        $qrylast = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno desc limit 1";
                    }else{
                        /*$qryfirst = "select trno from $table 
                        where doc='".$doc."' 
                        and center='".$center."' order by docno asc limit 1";*/
                        $qrylast = "select trno from (
                                        select $table.trno,$table.docno from $table
                                        left join lahead as head on head.trno = $table.trno
                                        left join client on client.client = head.client
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                        UNION ALL
                                        select $table.trno,$table.docno from $table
                                        left join glhead as head on head.trno = $table.trno
                                        left join client on client.clientid = head.clientid
                                        where $table.doc='".$doc."' and $table.center='".$center."' and client.groupid <> 'CONFI'
                                    ) as tbl order by docno desc limit 1";
                    }//end if
                break;
                
                default:
                    $qrylast = "select trno from $table where doc='".$doc."' and center='".$center."' order by docno desc limit 1";
                break;
            }//END SWITCH

            $trno = Yii::$app->sbccommon->datareader($qrylast);
            return $trno;
        }
    }

    public static function first_lastitem($action, $type) {
        if($type == 'FG') { $fg = ' where fg_isfinishedgood = 1 '; } else { $fg = ''; }

        if ($action == "first") {
            $itemid = Yii::$app->sbccommon->datareader("select itemid from item $fg order by itemid asc limit 1");
            return $itemid;
        }
        if ($action == "last") {
            $itemid = Yii::$app->sbccommon->datareader("select itemid from item $fg order by itemid desc limit 1");
            return $itemid;
        }
    }//END

    public function last_bref($doc) {
        $center = Yii::$app->session['loggeduser']['center'];
        $table = Common::gettablenum($doc);
        $last = Yii::$app->sbccommon->datareader("select bref FROM ".$table." where doc='".$doc."' and center='".$center."' order by trno desc limit 1");
        return $last;
    }

    public function getPrefixes($doc) {

        $prefixes = Common::Prefixes($doc);
        if (isset($prefixes[0]) && $prefixes[0] == "") {
            return empty($prefixes);
        } else {
            return $prefixes;
        }
    }

    public static function Prefixes($pref) {
        $prefixes = "";
        $valid_prefixes = Yii::$app->sbccommon->opentable("select pvalue FROM profile where psection ='".$pref."' and doc ='SED'");
        for ($i = 0; $i < count($valid_prefixes); $i++) {
            $prefixes = explode(",", $valid_prefixes[$i]['pvalue']);
        }
        return $prefixes;
    }//end prefixes



    function delete($doc, $trno) {

        $stock = Common::localstock($doc);
        $detail = Common::localdetail($doc);
        $head = Common::localhead($doc);
        
        $numtable = "cntnum";
        $filter = "";
        $delete = false;
        switch ($doc) {
            case 'MX':
            case 'RR': case 'MI':case 'CA':
            case 'DM': case 'TS':case 'AJ':case 'PU':
            case 'SJ': case 'IS':
            case 'CM': case 'PK': case 'SV':{     
                    $data = new Lastock();                            
                    $stock2 = Lastock::openstock($trno, $doc, $filter); 
                    $stock2 = Yii::$app->sbccommon->opentable($stock2);
                    $docno=Cntnum::getdocno($trno, $doc);

                    if (Yii::$app->sbccommon->execqry("delete from ".$detail." where trno='".$trno."'") == 1) {
                        if (Yii::$app->sbccommon->execqry("delete from ".$stock." where trno='".$trno."'") == 1) {
                            if (Yii::$app->sbccommon->execqry("delete from ".$head." where trno='".$trno."' and doc='".$doc."'") == 1) {
                                if (Yii::$app->sbccommon->execqry("delete from costing where trno='".$trno."'") == 1) {
                                      $common = New Common();
                                   if($stock2!=null){   
                                   foreach ($stock2 as $key=> $det) {                                
                                            switch (Yii::$app->systemsettings->companyConfig()) {
                                                case 'MLCP':
                                                    switch ($doc) {
                                                        case 'SJ':
                                                            if($det['isfromjo']){
                                                                $servedupdater = "update hjbstock set qa = qa - " .$det['iss']. "
                                                                where trno = " . $det['refx'] . " and line = " . $det['linex'];
                                                                $status = Yii::$app->sbccommon->execqry($servedupdater);
                                                            }else{
                                                                if($det['refx']!=0 && $det['linex']!=0){                                    
                                                                     Lastock::deletestocks($doc, $det['trno'], $det['line']);
                                                                     if(strlen($det['refx'])!=0 && $det['refx']!=0){
                                                                        if(!Postock::setserveditems($det['linex'],$det['refx'],$doc)){
                                                                          Postock::resetQuantity($det['line'], $det['trno'], $doc);
                                                                          Postock::setserveditems($det['linex'], $det['refx'],$doc); 
                                                                        }
                                                                        Log::del_log($doc, $trno, $docno, $det['barcode']);
                                                                     }
                                                                }//end if det refx              
                                                            }//end if
                                                        break;

                                                        default:
                                                            if($det['refx']!=0 && $det['linex']!=0){                                    
                                                                 Lastock::deletestocks($doc, $det['trno'], $det['line']);
                                                                 if(strlen($det['refx'])!=0 && $det['refx']!=0){
                                                                    if(!Postock::setserveditems($det['linex'],$det['refx'],$doc)){
                                                                      Postock::resetQuantity($det['line'], $det['trno'], $doc);
                                                                      Postock::setserveditems($det['linex'], $det['refx'],$doc); 
                                                                    }
                                                                    Log::del_log($doc, $trno, $docno, $det['barcode']);
                                                                 }
                                                            }//end if det refx                
                                                        break;
                                                    }//END SWITHC
                                                break;
                                                
                                                default:
                                                    if($det['refx']!=0 && $det['linex']!=0){                                                                         
                                                         Lastock::deletestocks($doc, $det['trno'], $det['line']);
                                                         if(strlen($det['refx'])!=0 && $det['refx']!=0){
                                                            if(!Postock::setserveditems($det['linex'],$det['refx'],$doc)){
                                                              Postock::resetQuantity($det['line'], $det['trno'], $doc);
                                                              Postock::setserveditems($det['linex'], $det['refx'],$doc); 
                                                            }
                                                            Log::del_log($doc, $trno, $docno, $det['barcode']);
                                                         }
                                                    }//end if det refx               
                                                break;
                                            }//END switch
                                   }//end for each
                                   }//end if stock2
                                    $delete = true;
                                }//end delete costing
                            }//end delete 1
                        }//end delete 2
                    }//end delete 1
                    
                    //SECOND COMMAND TO DELETE ALL REFERENCE OF DELETED TRANSACTION
                    switch ($doc) {
                        case 'PK':
                            $qry2 = "update hpdhead set prc = '' where prc = '".$docno."'";
                            Yii::$app->sbccommon->execqry($qry2);
                            break;

                        case 'SV':
                            $qry = "update cntnum set svnum = 0 where cntnum.trno in (select distinct trno from spstock where sptrno = ".$trno.")";
                            Yii::$app->sbccommon->execqry($qry);
                            $qry2 = "delete from spstock where sptrno = ".$trno;
                            Yii::$app->sbccommon->execqry($qry2);
                            break;
                        break;

                        case 'AJ':
                            $qry2 = "update hpchead set yourref = '' where yourref = '".$docno."'";
                            Yii::$app->sbccommon->execqry($qry2);
                            break;
                    }//END SWITCH
                    
                    break;
                }//end case when 
            case 'PV': case 'CV': case 'CR':
            case 'GJ': case 'AP': case 'AR': case 'DS': {

                            $data = new Ladetail();
                            $data->alias = null;
                            
                            $details = Ladetail::opendetail($trno,$doc);
                            $details = Yii::$app->sbccommon->opentable($details);
                            $detail_=array();
                            if($details!=null){
                            foreach ($details as $key=> $det) {
                               // Apledger::updatebal($detail['refx'], $detail['linex'], $data, $doc);
                                Yii::$app->sbccommon->execqry("delete from $detail where trno=".$det['trno']." and line=".$det['line']);
                                $detail_[$key]['acno']=$det['acno'];
                                $detail_[$key]['refx']=$det['refx'];
                                $detail_[$key]['linex']=$det['linex'];

                                if($doc=='CR' && $det['pdcline']){
                                    Yii::$app->sbccommon->execqry("update hpostdatedchecks set refx=0,linex=0 where line =". $det['pdcline']);
                                }//end cr

                                if($det['refx']!=0 && $det['linex']!=0){
                                    switch (substr($det['alias'],0,2))
                                    {
                                        case 'AR':{
                                            $bal=Apledger::recomputebal($det['trno'], $det['line']);
                                            $reference=Apledger::getpaymentreference($det['trno'], $det['line']);
                                             $updated=   Yii::$app->sbccommon->execqry("update arledger set bal=(db+cr)-$bal,ref='$reference' where trno=".$det['refx']." and line=".$det['linex']);
                                        }
                                        case 'AP':{
                                             $bal=Apledger::recomputebal($det['trno'], $det['line']);
                                            $reference=Apledger::getpaymentreference($det['trno'], $det['line']);
                                             $updated=   Yii::$app->sbccommon->execqry("update apledger set bal=(db+cr)-$bal,ref='$reference' where trno=".$det['refx']." and line=".$det['linex']);
  
                                        }    
                                        case 'CR':case 'CA':{
                                            $updated=   Yii::$app->sbccommon->execqry("update crledger set depodate=null where trno=".$det['refx']." and line=".$det['linex']);

                                        }       
                                    }
                                }
                            }}
                        
                
                    if (Yii::$app->sbccommon->execqry("DELETE from $head where trno='$trno' and doc='$doc'") == 1) {
                            $delete = true;
                    }
                    break;
                }
            
            case 'SO': case 'QT':  case 'PS': case 'TR': case 'PC': case 'PR': case 'JB':{
                $numtable = "transnum";
                if (Yii::$app->sbccommon->execqry("DELETE from $stock where trno='$trno'") == 1) {
                    if (Yii::$app->sbccommon->execqry("DELETE from $head where trno='$trno' and doc='$doc'") == 1) {
                        $delete = true;

                        switch($doc) {
                            case 'JB':
                                $qrymaterial = "delete from jb_materialtab where trno = " . $trno;
                                $qryprocess = "delete from jb_processtab where trno = " . $trno;
                                Yii::$app->sbccommon->execqry($qrymaterial);
                                Yii::$app->sbccommon->execqry($qryprocess);
                            break;
                        }//end switch
                    }//END IF
                }//End if
                break;
            }//end switch

            case 'SP': case 'PD': case 'PI': case 'PO':{

                    $numtable = "transnum";
                    //alvin 
                    $stock2 = Postock::openstock($doc,$trno,$filter); 
                    $stock2=Yii::$app->sbccommon->opentable($stock2);
                    
                        if (Yii::$app->sbccommon->execqry("DELETE from $stock where trno='$trno'") == 1) {
                            if (Yii::$app->sbccommon->execqry("DELETE from $head where trno='$trno' and doc='$doc'") == 1) { 

                               if($stock2!=null){   
                                               
                                foreach ($stock2 as $key=> $det) {                                
                                     if($det['refx']!=0 && $det['linex']!=0){                                                                         
                                         if(strlen($det['refx'])!=0 && $det['refx']!=0){
                                            if(!Postock::setserveditems($det['linex'],$det['refx'],$doc)){
                                              Postock::resetQuantity($det['line'], $det['trno'], $doc);
                                              Postock::setserveditems($det['linex'], $det['refx'],$doc);                                              
                                            }
                                            $docno=Cntnum::getdocno($trno, $doc);
                                            Log::del_log($doc, $trno, $docno, $det['barcode']);
                                         }
                                     }
                                   }
                               }
                                    $delete = true;                                
                            }
                        }                                                    
                break;
            }    

            //TW KEYWORD
            case 'TW': {
                    $numtable = "taxnum";
                    if (Yii::$app->sbccommon->execqry("DELETE from taxdetail where trno='$trno'") == 1) {
                        if (Yii::$app->sbccommon->execqry("DELETE from taxhead where trno='$trno' and doc='$doc'") == 1) {
                            $delete = true;
                        }
                    }
                    break;
            }

            case 'EX': {
                    $numtable = "transnum";
                    if (Yii::$app->sbccommon->execqry("DELETE from $head where trno='$trno' and doc='$doc'") == 1) {
                        $delete = true;
                    }
                    break;
                }
            case 'JO': {
            $numtable = "transnum";
                if (Yii::$app->sbccommon->execqry("DELETE from $head where trno='$trno' and doc='$doc'") == 1) {
                    $delete = true;
                }
                break;
            }
            case 'KR': {
            $numtable = "transnum";
                if (Yii::$app->sbccommon->execqry("DELETE from $head where trno='$trno' and doc='$doc'") == 1) {
                    Yii::$app->sbccommon->execqry("update arledger set kr=0 where kr=".$trno."");
                    $delete = true;
                }
                break;
            }
        }
        if ($delete) {
            if (Yii::$app->sbccommon->execqry("DELETE from $numtable where trno='$trno' and doc='$doc'") == 1) {
                return true;
            }
        }
    }
    //end alvin





    public static function getItem($doc, $trno, $line) {
        $stock = Common::localstock($doc);
        return Yii::$app->sbccommon->datareader("
                select barcode
                from $stock
                where trno='$trno' and line='$line' limit 1
                ");
    }

    

    function deleteclient($client) {
        $isdownloaded = Yii::$app->backend->checkClientIsDownloaded($client);

        if($isdownloaded){
            return $client . 'is already downloaded. Cannot be deleted.'; 
        }else{
            //@todo la,lb,lchead,glhgl if client='$client' wh='$client' agent='$agent'
            //@todo check 
            $sql="select trno from lahead where client='$client' or agent='$client' or wh='$client'
            union all select trno from lbhead where client='$client' or agent='$client' or wh='$client'
            union all select trno from lchead where client='$client' or agent='$client' or wh='$client'
            union all select trno from pohead where client='$client'
            union all select trno from pihead where client='$client'
            union all select trno from pdhead where client='$client'
            union all select trno from hpdhead where client='$client'
            union all select trno from hpihead where client='$client'
            union all select trno from hpohead where client='$client'   
            union all select trno from sohead where client='$client'   
            union all select trno from hsohead where client='$client'   
            union all select trno from glhead left join client on client.clientid=glhead.clientid where client.client='$client'
            union all select trno from hglhead left join client on client.clientid=hglhead.clientid where client.client='$client'
            union all select trno from glhead left join client on client.clientid=glhead.agentid where client.client='$client'
            union all select trno from hglhead left join client on client.clientid=hglhead.agentid where client.client='$client'                  
            union all select trno from glhead left join client on client.clientid=glhead.whid where client.client='$client'
            union all select trno from hglhead left join client on client.clientid=hglhead.whid where client.client='$client'";
            
            $sql2 ="select count(trno) as t from ($sql) as t";
               
            $t = Yii::$app->sbccommon->datareader($sql2);
            $exist=true;
           
           if(!empty($t)){
               if($t!=0){
                    $exist=false;
               }//end i
           }//if end
        }//end f

        if($exist){
            $clientid=Client::checkclient($client);
            Log::del_log('customer', $clientid, $client,'CLIENT');
            $keyid = Yii::$app->backend->requestClientid($client);
            Yii::$app->sbccommon->execqry('delete from sched_allowedcustomer where clientid='.$keyid);
            return Yii::$app->sbccommon->execqry("DELETE from client where client='$client'");
        }else{
            $web = new Webproc();
            return $client. ' already have transaction...';
        }//end if
    }

    //EMPLOYEE
    function deleteemployee($client) {
       
            $clientid=Employee::checkempcode($client);
            Log::del_log('employee', $clientid, $client,'CLIENT');
            $keyid = Yii::$app->backend->requestEmpid($client);
            return Yii::$app->sbccommon->execqry("DELETE from employee where empcode='$client'");
    }

    public function insertcntnum($doc, $docno, $seq, $bref,$center,$fromfrontend=0)  { //ADDED CENTER PARAMETERS SO IT CAN BE CHANGES WHEN OTHER FUNCTIONS ARE CALLING IT
        $table = Common::gettablenum($doc);
        if(!empty($center) || $center!=''){
            $qry="INSERT into $table (doc, docno, seq, bref, center,fromfrontend) values('$doc','$docno','$seq','$bref','$center','$fromfrontend')";
            return Yii::$app->sbccommon->execqry($qry);
        }else{
            return -1;
        }//end if empty center
    }

     public function inserttaxnum($doc, $docno, $seq, $bref,$center)  { //ADDED CENTER PARAMETERS SO IT CAN BE CHANGES WHEN OTHER FUNCTIONS ARE CALLING IT
            try {
                
            if(!empty($center) || $center!=''){
                $qry="INSERT into taxnum (doc, docno, seq, bref, center) values('$doc','$docno','$seq','$bref','$center')";
                return Yii::$app->sbccommon->execqry($qry);
            }else{
                return -1;
            }//end if empty center

        } catch (ErrorException $e) {
                echo $e;
                return 0;
            }
        }

    public function setedit($trno, $doc) {
        $user = Yii::$app->user->username;
        $table = Common::localhead($doc);
        Yii::$app->sbccommon->execqry("update $table set editby='$user', editdate=CURRENT_TIMESTAMP where trno='$trno'");
    }

    public function setview($trno, $doc) {
        $table = Common::localhead($doc);
        $user = Yii::$app->session['loggeduser']['username'];
        Yii::$app->sbccommon->execqry("update $table set viewby='$user', viewdate=CURRENT_TIMESTAMP where trno='$trno'");
    }


    //FMM
    public static function first_lastitemfa($action, $type) {

        if ($action == "first") {
            $itemid = Yii::$app->sbccommon->datareader("select itemid from fasset order by itemid asc limit 1");
            return $itemid;
        }
        if ($action == "last") {
            $itemid = Yii::$app->sbccommon->datareader("select itemid from fasset order by itemid desc limit 1");
            return $itemid;
        }
    }  

    //EMPLOYEE
    public static function first_lastemp($action, $type) {
        if ($type == "first") {
            $empid = Yii::$app->sbccommon->datareader("select empid from employee order by empid asc limit 1");
            return $empid;
        }
        if ($type == "last") {
            $empid = Yii::$app->sbccommon->datareader("select empid from employee order by empid desc limit 1");
            return $empid;
        }
    }   
    //END KEYWORD EMPLOYEE 

    public static function nextitemfa($itemid, $type) {

        $records = Yii::$app->sbccommon->opentable("select itemid from fasset  order by barcode asc");
        $lastrecord = Yii::$app->sbccommon->datareader("select itemid from fasset  order by barcode desc limit 1");
        $last = count($records) - 1;
        if ($itemid == $lastrecord) {
            $itemid = $records[$last]['itemid'];
            return $itemid;
        } else {
            for ($i = 0; $i < count($records); $i++) {
                if ($itemid == $records[$i]['itemid']) {

                    $id = $i + 1;
                    $itemid = $records[$id]['itemid'];
                    return $itemid;
                }
            }
        }
    }      

    public static function previousitemfa($itemid, $type) {
        $records = Yii::$app->sbccommon->opentable("select itemid from fasset  order by barcode asc");
        $firstrecord = Yii::$app->sbccommon->datareader("select itemid from fasset  order by barcode asc limit 1");
        if ($itemid == $firstrecord) {
            return $itemid;
        } else {
            for ($i = 0; $i < count($records); $i++) {
                if ($itemid == $records[$i]['itemid']) {
                    $id = $i - 1;
                    $itemid = $records[$id]['itemid'];
                    return $itemid;
                }
            }
        }
    }     

    //END FMM
    
    
    

}