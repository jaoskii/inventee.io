<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\web\sessions;

use app\models\weblist;
use app\models\Common;
use app\models\Client;
//EMPLOYEE
use app\models\Employee;
use app\models\Log;  
use app\models\Item;  
use yii\base\ErrorException;

class weblisting extends Component {

//######################################################################  USED FOR INDEX SET UP OF A CLIENT
 
    public function index($controller,$access){
    try {
        if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
           $data = "not allowed";
            return $data;
        }else{
            $doc = $controller->module->id; //GETS PARTICULAR DOC FOR A MODULE

            $common = new Common;
            $weblist = new weblist;
            $filter = "";
            $clientid = $common->navfirst_last($doc,'last'); //GETS CLIENT OF THE LAST CUSTOMER

            $head = $weblist->loadmodel($controller,$clientid);
            return $head;
        }
    } catch (ErrorException $e) {
        echo $e;
    }
    }//END INDEX


//######################################################################  USED FOR AJAX NAV BUTTON TOGGLE
    //FUNCTION USED BY NAVIGATION BUTTONS
    public function viewing($controller,$access,$action,$params){
        try {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
        //IF ACCESS DENIED
            $return = "not allowed";
            return $data;
        }else{
        //IF ACCESS IS ACCEPTED
            $doc = $controller->module->id; //GETS PARTICULAR DOC FOR A MODULE
            $weblist = new weblist; 
            $common = new Common;
            $filter = "";
            //DETERMINES WHICH ACTION DID TAKE PLACE (first / next / prev / last)
            switch($action) {
            case "first": case "last": 
                $uniqueid = $common->navfirst_last($doc,$action); //GETS TRNO OF THE LAST DOCUMENT
            break;
            
            case "next": case "previous": 
                switch ($doc) {
                    //KEYWORD LOCATION&VENDOR
                    case 'customer': case 'agent': case 'warehouse': case 'supplier': case 'location': case 'vendor': case 'assetmaster': case 'branch':
                    //END KEYWORD LOCATION&VENDOR
                        $clientid = $params['trno'];
                        $uniqueid = $common->navnext_prev($params['client'], $clientid, $doc, $action); //GETS TRNO OF THE LAST DOCUMENT
                        break;

                    //EMPLOYEE
                    case 'employee':
                        $clientid = $params['trno'];
                        $uniqueid = $common->navnext_prev($params['client'], $clientid, $doc, $action); //GETS TRNO OF THE LAST DOCUMENT
                        break;    

                    case 'stockcard': case 'itemprofile': case 'posstockcard': case 'FG':
                        $itemid = $params['itemid'];
                        $uniqueid = $common->navnext_prev($params['barcode'], $itemid, $doc, $action); //GETS TRNO OF THE LAST DOCUMENT
                    break;
                    default:
                        # code...
                        break;
                }//END
            break;
            
            default: 
                $uniqueid = $common->navfirst_last($doc,$action); //GETS TRNO OF THE LAST DOCUMENT;
                break;
            }//END ACTION

            $head = $weblist->loadmodel($controller,$uniqueid);
            return array('head' => $head);
        }//end if else

            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END VIEWING

    public function stockcardnewing($controller,$access,$dataparams){
        try {
            if(Yii::$app->session['loggeduser']['access'][$access] != 1){
                //IF NOT ALLOWED FOR CREATING NEW DOCUMENTS
            }else{
                $doc = $controller->module->id;
                $weblist = new weblist; 
                $common = new Common;
                $head = new Client;
                $item = new Item;
                $length=$common->barcodelength();

                if($dataparams['copyprevdata'])
                {
                    //TO LOAD DATA OF AN ITEM 
                    $barcode=$dataparams['barcode'];
                    $itemexist=Item::checkbarcode($barcode);
                    $data = $item->openitem($itemexist);
                    
                    // var_dump($data);
                    // return 0;
                    if($data != null){
                        $item->itemid=$data[0]['itemid'];
                        $item->barcode=$data[0]['barcode'];
                        $item->itemname=$data[0]['itemname'];
                        
                        $item->stockgrpid=$data[0]['stockgrpid'];
                        $item->classid=$data[0]['classid'];
                        $item->modelid=$data[0]['modelid'];
                        $item->partid=$data[0]['partid'];

                        $item->groupid=$data[0]['groupid'];
                        $item->part=$data[0]['part'];
                        $item->itemrem=$data[0]['itemrem'];
                        $item->model=$data[0]['model'];
                        $item->brand=$data[0]['brand'];
                        $item->class=$data[0]['class'];
                        $item->body=$data[0]['body'];
                        $item->sizeid=$data[0]['sizeid'];
                        $item->category=$data[0]['category'];
                        $item->uom=$data[0]['uom'];
                        $item->uvpurchaseuom=$data[0]['purchase_uom'];
                        $item->printuom = $data[0]['gm_printuom'];
                        $item->qty=$data[0]['qty'];
                        $item->minimum=number_format($data[0]['minimum'],2);
                        $item->maximum=number_format($data[0]['maximum'],2);
                        $item->bal=number_format($data[0]['bal'],2);  
                        $item->supplier=$data[0]['supplier'];         
                        $item->amt=number_format($data[0]['amt'],2);
                        $item->amt2=number_format($data[0]['amt2'],2);
                        $item->amt4=number_format($data[0]['amt4'],2);
                        $item->famt=number_format($data[0]['famt'],2);
                        $item->cost=number_format($data[0]['cost'],2);
                        $item->disc=$data[0]['disc'];
                        $item->disc2=$data[0]['disc2'];
                        $item->disc3=$data[0]['disc3'];
                        $item->disc4=$data[0]['disc4'];
                        $item->wh=$data[0]['wh'];
                        $item->isinactive=$data[0]['isinactive'];
                        $item->isimport=$data[0]['isimport'];
                        $item->title=$data[0]['title'];
                        $item->subtitle=$data[0]['subtitle'];
                        $item->picture=$data[0]['picture'];
                        $item->note=$data[0]['note'];
                        $item->specs=$data[0]['specs'];
                        $item->invbal_uom = '';

                        $item->effdate = $data[0]['effectdate'];
                        $item->grp = $data[0]['grp'];
                        $item->packaging = $data[0]['packaging'];
                        $item->linkplu = $data[0]['linkplu'];
                        $item->otherbar = $data[0]['othcode'];
                        $item->supbar = $data[0]['suppcodes'];
                        $item->dateupdated = $data[0]['dateupdated'];
                        $item->quantity = $data[0]['qty'];
                        $item->supplier = $data[0]['supplier'];
                        $item->mode = $data[0]['mode'];
                        $item->istaxable=$data[0]['istaxable'];
                        $item->ispostitem=$data[0]['ispostitem'];
                        $item->issenior=$data[0]['issenior'];
                        $item->iszerorated=$data[0]['iszerorated'];
                        $item->isprintable=$data[0]['isprintable'];
                        $item->hierparent = $data[0]['hierarchy'];
                        $item->linkdept = $data[0]['linkdept'];
                        $item->points = $data[0]['points'];
                        $item->acceptlosses = $data[0]['acceptloss'];
                        $item->currentcost = $data[0]['cost'];
                        $item->cooktime = $data[0]['cooking_time'];
                        $item->preptime = $data[0]['prep_time'];   
                        $item->senior=$data[0]['senior'];
                        $item->pwd=$data[0]['pwd'];

                        $item->reorder=$data[0]['reorder'];
                        $item->critical=$data[0]['critical'];

                        $item->amt5=number_format($data[0]['amt5'],2);
                        $item->amt6=number_format($data[0]['amt6'],2);
                        // $item->amt7=number_format($data[0]['amt7'],2);
                        // $item->amt8=number_format($data[0]['amt8'],2);
                        // $item->amt9=number_format($data[0]['amt9'],2);
                        // $item->amt10=number_format($data[0]['amt10'],2);
                        // $item->amt11=number_format($data[0]['amt11'],2);
                        // $item->amt12=number_format($data[0]['amt12'],2);
                        // $item->amt13=number_format($data[0]['amt13'],2);
                        // $item->amt14=number_format($data[0]['amt14'],2);
                        // $item->amt15=number_format($data[0]['amt15'],2);
                        $item->disc5=$data[0]['disc5'];
                        $item->disc6=$data[0]['disc6'];
                        // $item->disc7=$data[0]['disc7'];
                        // $item->disc8=$data[0]['disc8'];
                        // $item->disc9=$data[0]['disc9'];
                        // $item->disc10=$data[0]['disc10'];
                        // $item->disc11=$data[0]['disc11'];
                        // $item->disc12=$data[0]['disc12'];
                        // $item->disc13=$data[0]['disc13'];
                        // $item->disc14=$data[0]['disc14'];
                        // $item->disc15=$data[0]['disc15'];

                        $item->markup=$data[0]['markup'];
                        $item->markup2=$data[0]['markup2'];
                        $item->markup3=$data[0]['markup3'];
                        $item->markup4=$data[0]['markup4'];
                        $item->markup5=$data[0]['markup5'];
                        $item->markup6=$data[0]['markup6'];

                        $item->markup=$data[0]['uom'];
                        $item->markup2=$data[0]['uom2'];
                        $item->markup3=$data[0]['uom3'];
                        $item->markup4=$data[0]['uom4'];
                        $item->markup5=$data[0]['uom5'];
                        $item->markup6=$data[0]['uom6'];

                        $item->markup=$data[0]['factor1'];
                        $item->markup2=$data[0]['factor2'];
                        $item->markup3=$data[0]['factor3'];
                        $item->markup4=$data[0]['factor4'];
                        $item->markup5=$data[0]['factor5'];
                        $item->markup6=$data[0]['factor6'];

                        $item->uvpriority=$data[0]['uv_priority'];
                        $item->uvdepartment=$data[0]['uv_department'];
                        $item->suppitemcode=$data[0]['uv_suppitemcode'];
                    }//end if 

                    //$seq=substr($barcode, $start) + 1;
                    $pref=$common->GetPrefix($barcode);
                    $last_barcode=$item->getlast_barcode($pref);
                    $start=$common->SearchPosition($last_barcode);
                    $seq=substr($last_barcode, $start) +1;

                    if(Yii::$app->systemsettings->setDefaultBarcodeLength() == 0){
                        $barcode = "";
                    }else{
                        $barcode = $pref . $seq;
                    }//end if

                    $barcode=$common->PadJ($barcode, $length);
                    $item->barcode = $barcode;
                }else{
                    if(empty($dataparams['barcode'])){
                        $pref = "IT";
                    }else{
                        $pref=$common->GetPrefix($dataparams['barcode']);
                    }//end if
                    
                    $last_barcode=$item->getlast_barcode($pref);
                    $start=$common->SearchPosition($last_barcode);
                    $seq=substr($last_barcode, $start) +1;

                    if(Yii::$app->systemsettings->setDefaultBarcodeLength() == 0){
                        $clseq= "";
                    }else{
                        $clseq=$pref.$seq;
                    }
                    $new_barcode=$common->PadJ($clseq, $length);
                    $item->barcode=$new_barcode;
                    $item->uom="PCS";
                    $item->printuom="PCS";
                    $item->uvpurchaseuom='PCS';
                    $item->asset="";
                    $item->liability="";
                    $item->revenue="";
                    $item->expense="";
                    $item->effdate = "";
                    $item->grp = "";
                    $item->packaging = "";
                    $item->linkplu = "";
                    $item->otherbar = "";
                    $item->supbar = "";
                    $item->dateupdated = "";
                    $item->quantity = "";
                    $item->supplier = "";
                    $item->mode = "";
                    $item->istaxable=0;
                    $item->ispostitem=0;
                    $item->issenior=0;
                    $item->iszerorated=0;
                    $item->isprintable=0;
                    $item->hierparent = "";
                    $item->linkdept = "";
                    $item->points = 0;
                    $item->acceptlosses = 0;
                    $item->currentcost = 0;
                    $item->cooktime = 0;
                    $item->preptime = 0;
                }//end if copyprevdata is true
            }//END else access
            return array('head' => $item);
        } catch (ErrorException $e) {
            echo $e;
        }//end try   
    }// END FUNCTION


//EMPLOYEE
    public function newingemployee($controller,$access,$dataparams){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF NOT ALLOWED FOR CREATING NEW DOCUMENTS
        }else{
            $doc = $controller->module->id;
            $moduleid = $controller->module->id;
            $common = new Common;
            $head = new Employee;

        
            $head->paymode = "D";
            $head->teu = "S";
            $length = $common->clientlength();
            $pref = '';


            if (strlen($dataparams['client']) != 0) {
                $pref = $common->GetPrefix($dataparams['client']);
                if(empty($pref)){
                    $pref = $dataparams['client'];
                }//END PREF
            }else{
                $pref=Client::getsingledefaultprefixes($controller->module->id);
            } //end if (strlen($dataparams['client']) != 0) {


            if ($length==0){
                $blnExist = true;
            } else {
                $blnExist = false;
                $prefixes = $head->getPrefixes($doc);//GETS ALL PREFIXES FOR THIS DOC
                $availprefs = explode(",", $prefixes);
                if(!empty($prefixes)){
                    for ($i = 0; $i < count($availprefs); $i++) {
                        if ($pref == $availprefs[$i]) {
                            $blnExist = true;
                        }//END COMPARE
                    }//END FOR LOOP
                }//END IF ELSE
            }//end if if ($length==0){


            if($blnExist){
                if ($length!=0){
                $last_client=Client::getlast_client_($pref,$controller->module->id);
                $start = $common->SearchPosition($last_client);
                $seq = substr($last_client, $start) + 1;
                
                $clseq = $pref . $seq;
                $new_client = $common->PadJ($clseq, $length);
                 
                $head->client = $new_client;
                }//end if ($length!=0){
                  
                return array('head' => $head,'error_msg'=>'');
            }else{
                $weblist = new weblist;
                $prefix = "/";
                $count = count($availprefs);
               
                for($x = 0; $x < $count; $x++){
                    $prefix = $prefix . $availprefs[$x] . " / ";
                }

                return array('head'=>'','error_msg'=>'Invalid prefix , Available prefixes are: ['.$prefix.']');
            }//end prex exist
        }
    }// END FUNCTION


    public function newing($controller,$access,$dataparams){
        try {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF NOT ALLOWED FOR CREATING NEW DOCUMENTS
        }else{
            $doc = $controller->module->id;
            $moduleid = $controller->module->id;
            $common = new Common;
            $head = new Client;

            switch ($doc) {
                case 'customer':
                    $doc = 'CL';
                break;
                
                case 'agent':
                    $doc = 'AG';
                break;

                case 'supplier':
                    $doc = 'SL';
                break;

                case 'warehouse':
                    $doc = 'WH';
                break;
                //KEYWORD LOCATION&VENDOR    
                case 'location':
                    $doc = 'LC';
                break;

                case 'vendor':
                    $doc = 'VD';
                break;

                case 'assetmaster':
                    $doc = 'AM';
                break;   

                case 'branch':
                    $doc = 'BR';
                break;

                //END KEYWORD LOCATION&VENDOR  
            }//end switch

                    $length = $common->clientlength();
                    $pref = '';

                    if (strlen($dataparams['client']) != 0) {
                        $pref = $common->GetPrefix($dataparams['client']);
                        if(empty($pref)){
                            $pref = $dataparams['client'];
                        }//END PREF
                    }else{
                        $pref=Client::getsingledefaultprefixes($controller->module->id);
                    }
                    
                    $blnExist = false;
                    $prefixes = $head->getPrefixes($doc);//GETS ALL PREFIXES FOR THIS DOC
                    $availprefs = explode(",", $prefixes);
                    if(!empty($prefixes)){
                        for ($i = 0; $i < count($availprefs); $i++) {
                            if ($pref == $availprefs[$i]) {
                                $blnExist = true;
                            }//END COMPARE
                        }//END FOR LOOP
                    }//END IF ELSE


                    if($blnExist){
                        $last_client=Client::getlast_client_($pref,$controller->module->id);
                        $start = $common->SearchPosition($last_client);
                        $seq = substr($last_client, $start) + 1;
                        
                        $clseq = $pref . $seq;
                        $new_client = $common->PadJ($clseq, $length);
                         
                        $head->client = $new_client;
                        $head->distributionareaid = 0;
                        $head->collectionareaid = 0;
                        $head->categorynameid = 0;
                        $head->distributionarea = '';
                        $head->collectionarea = '';
                        $head->categoryname = '';
                        switch ($moduleid) {
                            case 'supplier':
                                 $head->IsSupplier = 1;
                                break;
                            case 'agent':
                                $head->IsAgent = 1;
                                $head->uv_ispicker = 0;
                                $head->uv_ischecker = 0;
                                break;
                            case 'warehouse':
                                 $head->IsWarehouse = 1;
                                break;
                            //KEYWORD LOCATION&VENDOR
                            case 'location':
                                $head->isLocation = 1;
                                break;    
                            case 'vendor':
                                $head->isVendor = 1;
                            break; 


                            case 'branch':
                                $head->IsBranch = 1;
                            break;
                            //END KEYWORD LOCATION&VENDOR

                            default:
                                $head->IsCustomer = 1;
                                break;
                        }//end case
                        return array('head' => $head,'error_msg'=>'');
                    }else{
                        $weblist = new weblist;
                        $prefix = "/";
                        $count = count($availprefs);
                       
                        for($x = 0; $x < $count; $x++){
                            $prefix = $prefix . $availprefs[$x] . " / ";
                        }

                        return array('head'=>'','error_msg'=>'Invalid prefix , Available prefixes are: ['.$prefix.']');
                    }//end prex exist
           }

            
        } catch (ErrorException $e) {
            echo $e;
        }
       // return array('head' => $head->client);
       }// END FUNCTION

//########################################## FOR SAVING MODULE HEAD #################################################3
    
    public function savingitem($controller,$access,$moduledata){
        try {
            $message = "";
            if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
                $msg = "INVALID SAVING HEAD.";
            } else {
                $data= new Item;
                $module=$controller->module->id;
                $itemid="";
                $barcode=$moduledata['barcode'];
                $data->itemid = $moduledata['itemid'];
                $moduledata['itemname'] = str_replace('~', ' - ', $moduledata['itemname']);
                $data->itemname = $moduledata['itemname'];
                $data->barcode = $moduledata['barcode'];
                
                if($module != 'FG'){
                    $data->brand = $moduledata['brand'];
                    $data->part = $moduledata['part'];
                    $data->model = $moduledata['model'];
                    $data->partid = $moduledata['partid'];
                    $data->modelid = $moduledata['modelid'];
                    $data->invbal_uom = $moduledata['invbal_uom'];
                }//end if

                switch(Yii::$app->systemsettings->companyConfig()){
                    case 'GAMELINE_POS':
                        if($moduledata['uomprint']!=''){
                            $data->printuom = $moduledata['uomprint'];
                        }else{
                            $data->printuom = '';
                        }//end if
                    break;

                    case 'UNIVERSE':
                        if($moduledata['uompurchase']!=''){
                            $data->uvpurchaseuom = $moduledata['uompurchase'];
                        }else{
                            $data->uvpurchaseuom = '';
                        }//end if
                    break;

                    default:
                        $data->printuom = '';
                        $data->uvpurchaseuom = '';
                    break;
                }//end switch

                switch(Yii::$app->systemsettings->companyConfig()){
                    case 'MLCP':
                        $data->fg_colornum = $moduledata['fg_colornum'];
                        
                        if($module != 'FG'){
                            $data->fg_serial = $moduledata['fg_serial'];
                            $data->fg_diameter = $moduledata['diameter'];
                            
                            if($moduledata['stockcardcustomer'] != ''){
                                $clientstockcard = explode("~", $moduledata['stockcardcustomer']);
                                $data->fg_client = $clientstockcard[0];
                            }else{
                                $data->fg_client = '';
                            }//end if

                            $data->fg_jowidthuom = $moduledata['fg_jowidthuom'];
                            $data->fg_jolengthuom = $moduledata['fg_jolengthuom'];
                            $data->fg_thicknessuom = $moduledata['fg_thicknessuom'];
                            $data->fgunit_diameter = $moduledata['fgunit_diameter'];

                            $data->fg_serial = $moduledata['fg_serial'];
                        }//end if
                        
                        $data->fg_prodtype = $moduledata['fg_prodtype'];
                        $data->fg_combi = $moduledata['fg_combi'];
                        $data->fg_plasticcolor = $moduledata['fg_plasticcolor'];
                        $data->fg_sealing = $moduledata['fg_sealing'];
                        
                        if($module == 'FG'){
                            $data->fg_thickness2 = $moduledata['fg_thickness2'];
                        }//end 

                        $data->fg_jowidth = $moduledata['fg_jowidth'];
                        $data->fg_jolength = $moduledata['fg_jolength'];
                        $data->fg_thickness = $moduledata['fg_thickness'];
                    break;

                    default:
                        $data->fg_numcolors = '';
                        $data->fg_client = '';
                        $data->fg_prodtype = '';
                        $data->fg_combi = '';
                        $data->fg_plasticcolor = '';
                        $data->fg_sealing = '';
                        $data->fg_serial = '';
                        $data->fg_thickness2 = '';
                        $data->fg_jowidth = '';
                        $data->fg_jolength = '';
                        $data->fg_diameter = '';
                        $data->fgunit_width = '';
                        $data->fgunit_length = '';
                        $data->fgunit_diameter = '';
                    break;
                }//end switch

                switch(Yii::$app->systemsettings->companyConfig()){
                    case 'UNIVERSE':
                        $data->uvpriority = $moduledata['priority'];
                        $data->uvdepartment = $moduledata['department'];
                        $data->suppitemcode = $moduledata['suppitemcode'];
                        $data->isvat = $moduledata['isvat'];
                        $data->uvprincipalid=$moduledata['uvprincipalid']; 
                    break;
                    
                    default:
                        if($module != 'FG'){
                            $data->isvat = $moduledata['isvat'];
                        }//end if
                    break;
                }//end switch                

                switch ($controller->module->id) {
                    case 'posstockcard':
                    // var_dump($moduledata);
                    // return 0;
                        if($moduledata['effdate'] == ''){
                            $data->effdate = '0000-00-00 00:00:00';
                        }else{
                            $data->effdate = $moduledata['effdate'];
                        }//end if

                        if($moduledata['dateupdated'] == ''){
                            $data->dateupdated = '0000-00-00 00:00:00';
                        }else{
                            $data->dateupdated = $moduledata['dateupdated'];
                        }//end if


                        $data->groupid = $moduledata['groupid'];
                        $data->stockgrpid = $moduledata['stockgrpid'];
                        $data->packaging = $moduledata['packaging'];
                        $data->linkplu = $moduledata['linkplu'];
                        $data->otherbar = $moduledata['otherbar'];
                        $data->supbar = $moduledata['supbar'];
                        $data->quantity = $moduledata['quantity'];
                        $data->supplier = $moduledata['supplier'];
                        $data->mode = $moduledata['mode'];

                        $data->istaxable=$moduledata['istaxable'];
                        $data->ispostitem=$moduledata['ispostitem'];
                        $data->issenior=$moduledata['issenior'];
                        $data->iszerorated=$moduledata['iszerorated'];
                        $data->isprintable=$moduledata['isprintable'];
                        $data->hierparent = $moduledata['hierparent'];
                        $data->linkdept = $moduledata['linkdept'];

                        $data->points = $moduledata['points'];
                        $data->acceptlosses = $moduledata['acceptlosses'];
                        $data->currentcost = $moduledata['currentcost'];
                        $data->cooktime = $moduledata['cooktime'];
                        $data->preptime = $moduledata['preptime'];
                        //
                        $data->maximum = $moduledata['maximum'];
                        $data->reorder = $moduledata['reorder'];
                        $data->critical = $moduledata['critical'];
                        $data->minimum = $moduledata['minimum'];
                        $data->senior = $moduledata['senior'];
                        $data->pwd = $moduledata['pwd'];

                      
                        break;
                    
                    default:
                     $data->effdate = '0000-00-00 00:00:00';
                     $data->dateupdated = '0000-00-00 00:00:00';
                     $data->istaxable=0;
                     $data->ispostitem=0;
                     $data->issenior=0;
                     $data->iszerorated=0;
                     $data->isprintable=0;
                     $data->quantity = 0;
                     $data->color = '';
                     $data->senior = '';
                     $data->pwd = '';
                     $data->acceptlosses = 0;
                     $data->factor1 = 0;
                     $data->factor2 = 0;
                     $data->factor3 = 0;
                     $data->factor4 = 0;
                     $data->factor5 = 0;
                     $data->factor6 = 0;
                     $data->markup = 0;
                     $data->markup2 = 0;
                     $data->markup3 = 0;
                     $data->markup4 = 0;
                     $data->markup5 = 0;
                     $data->markup6 = 0;
                     $data->currentcost = 0;
                     $data->cooktime = 0;
                     $data->preptime = 0;
                    
                     if($controller->module->id != 'FG') {
                        $data->class = $moduledata['classid'];
                        $data->body = $moduledata['body'];
                        $data->groupid = $moduledata['groupid'];
                        $data->stockgrpid = $moduledata['stockgrpid'];
                    }//end i
                    break;
                }//end switch


                if($controller->module->id == 'FG') {
                    $data->commgrpid = $data->subcatid = 0;
                    $data->fg_revision = $moduledata['fg_revision'];
                    $data->fg_templateno = $moduledata['fg_templateno'];
                    $data->fg_updated = $moduledata['fg_updated'];
                    $data->fg_effective = $moduledata['fg_effective'];
                    $data->fg_client = $moduledata['fg_client'];
                    $data->fg_prodtype = $moduledata['fg_prodtype'];
                    $data->fg_combi = $moduledata['fg_combi'];
                    $data->fg_transform = $moduledata['fg_transform'];
                    $data->fg_addspecs = $moduledata['fg_addspecs'];
                    $data->fg_punchholesize = $moduledata['fg_punchholesize'];
                    $data->fg_sealing = $moduledata['fg_sealing'];
                    $data->fg_plasticcolor = $moduledata['fg_plasticcolor'];
                    $data->fg_bfilmdet = $moduledata['fg_bfilmdet'];
                    $data->fg_treatment = $moduledata['fg_treatment'];
                    
                    if(!is_numeric($moduledata['payrate'])){
                        $data->payrate = '0.00';
                    }else{

                        $data->payrate = $moduledata['payrate'];
                    }//end f

                    if(!is_numeric($moduledata['payqty'])){
                        $data->payqty = '0.00';
                    }else{

                        $data->payqty = $moduledata['payqty'];
                    }//end f

                    $data->fg_jowidth = $moduledata['fg_jowidth'];
                    $data->fg_jowidthuom = $moduledata['fg_jowidthuom'];
                    $data->fg_jolength = $moduledata['fg_jolength'];
                    $data->fg_jolengthuom = $moduledata['fg_jolengthuom'];
                    $data->fg_thickness = $moduledata['fg_thickness'];
                    $data->fg_thicknessuom = $moduledata['fg_thicknessuom'];
                    $data->fg_actualwidth = $moduledata['fg_actualwidth'];
                    $data->fg_actualwidthuom = $moduledata['fg_actualwidthuom'];
                    $data->fg_actuallength = $moduledata['fg_actuallength'];
                    $data->fg_actuallengthuom = $moduledata['fg_actuallengthuom'];
                    $data->fg_colornum = $moduledata['fg_colornum'];
                    $data->fg_repeatlength = $moduledata['fg_repeatlength'];
                    $data->fg_repeatlengthuom = $moduledata['fg_repeatlengthuom'];
                    $data->fg_outnum = $moduledata['fg_outnum'];
                    $data->fg_outnumuom = '';
                    $data->fg_bfilmwidth = $moduledata['fg_bfilmwidth'];
                    $data->fg_bfilmwidthuom = $moduledata['fg_bfilmwidthuom'];
                    $data->fg_thickness2 = $moduledata['fg_thickness2'];
                    $data->fg_thickness2uom = $moduledata['fg_thickness2uom'];
                    $data->fg_gramppiece1 = $moduledata['fg_gramppiece1'];
                    $data->fg_gramppiece2 = $moduledata['fg_gramppiece2'];

                    $data->reorder = $data->critical = 0;
                } else {
                    $data->reorder = $moduledata['reorder'];
                    $data->critical = $moduledata['critical'];
                    $data->payqty = '1';
                    $data->payrate = '0.00';
                }

                //END
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'SOUTHCENTRAL':
                        if($moduledata['subcatid'] == '') { $data->subcatid = 0; } else { $data->subcatid = $moduledata['subcatid']; } 
                        $data->category = '';
                        $data->defaultwh = $moduledata['defwarehouse'];
                        $data->sizeid = '';
                        $data->commgrp = $moduledata['commgrp'];
                        if($moduledata['commgrpid'] == '') { $data->commgrpid = 0; } else { $data->commgrpid = $moduledata['commgrpid']; }
                    break;
                    default:
                        if($controller->module->id != 'FG') {
                            $data->defaultwh = '';
                            $data->commgrp = '';
                            $data->commgrpid = 0;
                            $data->subcatid = 0;
                            if($controller->module->id!='posstockcard') {
                                $data->category = $moduledata['category'];
                            }
                            $data->sizeid = $moduledata['sizeid'];
                        }//end if
                    break;
                }//end swtich

                if($controller->module->id != 'FG') {
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'DAVIDSALON_JOY': case 'UNIVERSE':
                            $data->itemshortname = $moduledata['shortname']; 
                        break;
                        default: 
                            $data->itemshortname = ''; 
                        break;
                    }//END SWITCH CASE
                }//end if

               switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'TENPLUS': 
                        $data->itemcomm = $moduledata['itemcomm'];
                        $data->itemhandling = $moduledata['itemhandling'];
                        $data->itemhandling2 = $moduledata['itemhandling2'];
                    break;

                    default: 
                        $data->itemcomm = ''; 
                        $data->itemhandling = '';
                        $data->itemhandling2 = '';
                    break;
                }//END SWITCH CASE

                switch ($controller->module->id) {
                    case 'posstockcard': case 'FG':
                        $data->daystoexpire=0; 
                    break;

                    default:
                        if(!is_numeric($moduledata['daystoexpire'])) { $data->daystoexpire=0; } else{ $data->daystoexpire = $moduledata['daystoexpire']; }
                    break;
                }//end f 

                if($controller->module->id != 'FG') {
                    $data->uom = $moduledata['uom'];
                    $data->itemrem = $moduledata['itemrem'];
                    $data->maximum = $moduledata['maximum'];
                    $data->minimum = $moduledata['minimum'];
                }//END IF
                
                switch ($controller->module->id) {
                    case 'posstockcard':
                        if($moduledata['amt'] == "") { $data->amt = 0; } else { $data->amt = str_replace(',', '', $moduledata['amt']); }
                        if($moduledata['amt2'] == "") { $data->amt2 = 0; } else { $data->amt2 = str_replace(',', '', $moduledata['amt2']); }
                        if($moduledata['famt'] == "") { $data->famt = 0; } else { $data->famt = str_replace(',', '', $moduledata['famt']); }
                        if($moduledata['amt4'] == "") { $data->amt4 = 0; } else { $data->amt4 = str_replace(',', '', $moduledata['amt4']); }
                        if($moduledata['amt5'] == "") { $data->amt5 = 0; } else { $data->amt5 = str_replace(',', '', $moduledata['amt5']); }
                        if($moduledata['amt6'] == "") { $data->amt6 = 0; } else { $data->amt6 = str_replace(',', '', $moduledata['amt6']); }
                        
                        $data->amt7 = 0; 
                        $data->amt8 = 0;
                        $data->amt9 = 0; 
                        $data->amt10 = 0; 
                        $data->amt11 = 0; 
                        $data->amt12 = 0; 
                        $data->amt13 = 0; 
                        $data->amt14 = 0; 
                        $data->amt15 = 0;  

                        $data->disc = $moduledata['disc'];
                        $data->disc2 = $moduledata['disc2'];
                        $data->disc3 = $moduledata['disc3'];
                        $data->disc4 = $moduledata['disc4'];
                        $data->disc5 = $moduledata['disc5'];
                        $data->disc6 = $moduledata['disc6'];
                        
                        if($moduledata['markup'] == "") { $data->markup = 0; } else { $data->markup = str_replace(',', '', $moduledata['markup']); }
                        if($moduledata['markup2'] == "") { $data->markup2 = 0; } else { $data->markup2 = str_replace(',', '', $moduledata['markup2']); }
                        if($moduledata['markup3'] == "") { $data->markup3 = 0; } else { $data->markup3 = str_replace(',', '', $moduledata['markup3']); }
                        if($moduledata['markup4'] == "") { $data->markup4 = 0; } else { $data->markup4 = str_replace(',', '', $moduledata['markup4']); }
                        if($moduledata['markup5'] == "") { $data->markup5 = 0; } else { $data->markup5 = str_replace(',', '', $moduledata['markup5']); }
                        if($moduledata['markup6'] == "") { $data->markup6 = 0; } else { $data->markup6 = str_replace(',', '', $moduledata['markup6']); }
                        
                        $data->uom1 = $moduledata['uom1'];
                        $data->uom2 = $moduledata['uom2'];
                        $data->uom3 = $moduledata['uom3'];
                        $data->uom4 = $moduledata['uom4'];
                        $data->uom5 = $moduledata['uom5'];
                        $data->uom6 = $moduledata['uom6'];

                        if($moduledata['factor1'] == "") { $data->factor1 = 0; } else { $data->factor1 = str_replace(',', '', $moduledata['factor1']); }
                        if($moduledata['factor2'] == "") { $data->factor2 = 0; } else { $data->factor2 = str_replace(',', '', $moduledata['factor2']); }
                        if($moduledata['factor3'] == "") { $data->factor3 = 0; } else { $data->factor3 = str_replace(',', '', $moduledata['factor3']); }
                        if($moduledata['factor4'] == "") { $data->factor4 = 0; } else { $data->factor4 = str_replace(',', '', $moduledata['factor4']); }
                        if($moduledata['factor5'] == "") { $data->factor5 = 0; } else { $data->factor5 = str_replace(',', '', $moduledata['factor5']); }
                        if($moduledata['factor6'] == "") { $data->factor6 = 0; } else { $data->factor6 = str_replace(',', '', $moduledata['factor6']); }                    

                        $data->color = $moduledata['color'];
                    break;
                    
                    default:
                        if($module != "FG"){
                            if($moduledata['amt'] == "") { $data->amt = 0; } else { $data->amt = str_replace(',', '', $moduledata['amt']); }
                            if($moduledata['amt2'] == "") { $data->amt2 = 0; } else { $data->amt2 = str_replace(',', '', $moduledata['amt2']); }
                            if($moduledata['famt'] == "") { $data->famt = 0; } else { $data->famt = str_replace(',', '', $moduledata['famt']); }
                            if($moduledata['amt4'] == "") { $data->amt4 = 0; } else { $data->amt4 = str_replace(',', '', $moduledata['amt4']); }
                            if($moduledata['amt5'] == "") { $data->amt5 = 0; } else { $data->amt5 = str_replace(',', '', $moduledata['amt5']); }
                            if($moduledata['amt6'] == "") { $data->amt6 = 0; } else { $data->amt6 = str_replace(',', '', $moduledata['amt6']); }
                            
                            if($moduledata['amt7'] == "") { $data->amt7 = 0; } else { $data->amt7 = str_replace(',', '', $moduledata['amt7']); }
                            if($moduledata['amt8'] == "") { $data->amt8 = 0; } else { $data->amt8 = str_replace(',', '', $moduledata['amt8']); }
                            if($moduledata['amt9'] == "") { $data->amt9 = 0; } else { $data->amt9 = str_replace(',', '', $moduledata['amt9']); }
                            if($moduledata['amt10'] == "") { $data->amt10 = 0; } else { $data->amt10 = str_replace(',', '', $moduledata['amt10']); }
                            if($moduledata['amt11'] == "") { $data->amt11 = 0; } else { $data->amt11 = str_replace(',', '', $moduledata['amt11']); }
                            if($moduledata['amt12'] == "") { $data->amt12 = 0; } else { $data->amt12 = str_replace(',', '', $moduledata['amt12']); }
                            if($moduledata['amt13'] == "") { $data->amt13 = 0; } else { $data->amt13 = str_replace(',', '', $moduledata['amt13']); }
                            if($moduledata['amt14'] == "") { $data->amt14 = 0; } else { $data->amt14 = str_replace(',', '', $moduledata['amt14']); }
                            if($moduledata['amt15'] == "") { $data->amt15 = 0; } else { $data->amt15 = str_replace(',', '', $moduledata['amt15']); }
                            $data->disc = $moduledata['disc'];
                            $data->disc2 = $moduledata['disc2'];
                            $data->disc3 = $moduledata['disc3'];
                            $data->disc4 = $moduledata['disc4'];
                            $data->disc5 = $moduledata['disc5'];
                            $data->disc6 = $moduledata['disc6'];
                            $data->disc7 = $moduledata['disc7'];
                            $data->disc8 = $moduledata['disc8'];
                            $data->disc9 = $moduledata['disc9'];
                            $data->disc10 = $moduledata['disc10'];
                            $data->disc11 = $moduledata['disc11'];
                            $data->disc12 = $moduledata['disc12'];
                            $data->disc13 = $moduledata['disc13'];
                            $data->disc14 = $moduledata['disc14'];
                            $data->disc15 = $moduledata['disc15'];    
                        }//end if                    
                    break;
                }//end swtich

                switch ($controller->module->id) {
                    case 'posstockcard':
                        $data->asset=""; 
                        $data->revenue = "";
                        $data->expense = "";
                        $data->liability = "";
                        $data->isimport = 0;
                        $data->cost = 0.00;
                    break;
                    
                    case 'FG':
                        $data->asset = $data->revenue = $data->expense = $data->liability = $data->cost = $data->isimport = 0;
                    break;

                    default:
                        if($moduledata['asset'] == "") { $data->asset = ""; } else { $data->asset = '\\' . $moduledata['asset']; }
                        if($moduledata['revenue'] == "") { $data->revenue = ""; } else { $data->revenue ='\\' . $moduledata['revenue']; }
                        if($moduledata['expense'] == "") { $data->expense = ""; } else { $data->expense ='\\' .  $moduledata['expense']; }
                        if($moduledata['liability'] == "") { $data->liability = ""; } else { $data->liability ='\\' .  $moduledata['liability']; }
                        $data->cost = 0.00;
                        $data->isimport = $moduledata['isimport'];
                    break;
                }//end swtich

                if($controller->module->id == 'FG') {
                    $data->fg_isfinishedgood = "";
                    $data->fg_isequipmenttool = "";
                    $data->isinactive = $data->fqty = $data->fsaleprice = $data->fprodweight = $data->fpackheight = $data->fpackweight = $data->fpacklength = $data->fpackwidth = $data->fminshipping = $data->fmaxshipping = $data->setfrontend = 0;
                    $data->promostart = $data->promoend = '1900-01-01';
                } else {
                    $data->fg_isequipmenttool = $moduledata['isequipmenttool'];
                    $data->fg_isfinishedgood = $moduledata['isfinishedgood'];
                    $data->isinactive = $moduledata['isinactive'];
                    if(!is_numeric($data->minimum)){$data->minimum=0;}
                    if(!is_numeric($data->maximum)){$data->maximum=0;}
                    if($moduledata['frontendqty'] == "") { $data->fqty = 5; } else { $data->fqty = $moduledata['frontendqty']; }
                    if($moduledata['frontendpromostart'] == "") { $data->promostart = '1900-01-01'; } else { $data->promostart = $moduledata['frontendpromostart']; }
                    if($moduledata['frontendpromoend'] == "") { $data->promoend = '1900-01-01'; } else { $data->promoend = $moduledata['frontendpromoend']; }
                    if($moduledata['frontendsaleprice'] == "") { $data->fsaleprice = 0.00; } else { $data->fsaleprice = $moduledata['frontendsaleprice']; }
                    if($moduledata['frontendprodweight'] == "") { $data->fprodweight = 0.00; } else { $data->fprodweight = $moduledata['frontendprodweight']; }
                    if($moduledata['frontendpackageheight'] == "") { $data->fpackheight = 0.00; } else { $data->fpackheight = $moduledata['frontendpackageheight']; }
                    if($moduledata['frontendpackageweight'] == "") { $data->fpackweight = 0.00; } else { $data->fpackweight = $moduledata['frontendpackageweight']; }
                    if($moduledata['frontendpackagelength'] == "") { $data->fpacklength = 0.00; } else { $data->fpacklength = $moduledata['frontendpackagelength']; }
                    if($moduledata['frontendpackagewidth'] == "") { $data->fpackwidth = 0.00; } else { $data->fpackwidth = $moduledata['frontendpackagewidth']; }
                    if($moduledata['frontenddeliveryshippingmin'] == "") { $data->fminshipping = 0.00; } else { $data->fminshipping = $moduledata['frontenddeliveryshippingmin']; }
                    if($moduledata['frontenddeliveryshippingmax'] == "") { $data->fmaxshipping = 0.00; } else { $data->fmaxshipping = $moduledata['frontenddeliveryshippingmax']; }
                    $data->fvideourl = $moduledata['frontendvideourl'];
                    $data->fmainmaterial = $moduledata['frontendmainmat'];
                    $data->ftype = $moduledata['frontendtype'];
                    $data->fdimensions = $moduledata['frontenddimensions'];
                    $data->fdeliveryopt = $moduledata['frontenddeliveryopt'];
                    if($moduledata['setfrontend'] == 1) {
                        if($moduledata['frontendwarrantytype'] == "") { $data->fwarrantytype = "No Warranty"; } else { $data->fwarrantytype = $moduledata['frontendwarrantytype']; }
                    } else { $data->fwarrantytype = $moduledata['frontendwarrantytype']; }
                    if($moduledata['frontendwarrantyperiod'] == "" || $moduledata['frontendwarrantyperiod'] == "") { $data->fwarrantyperiod = '0~Day(s)'; } else { $data->fwarrantyperiod = $moduledata['frontendwarrantyperiod']; }
                    if($moduledata['setfrontend'] == "") { $data->setfrontend = 0; } else { $data->setfrontend = $moduledata['setfrontend']; }
                    if($moduledata['fdiscounted'] == "") { $data->fdiscounted = 0; } else { $data->fdiscounted = $moduledata['fdiscounted']; }
                    $data->fwarrantypolicy = $moduledata['frontendwarrantypolicy'];
                }//end if


                if(strlen($moduledata['barcode'])!=0) {
                    $check=Item::itemid($barcode);
                    if ($check) { //update
                        if($moduledata['barcode']!="") {
                            $barcode=$moduledata['barcode'];
                            
                            if($module != "FG"){
                                $ok=$data->update($data);                      
                            }else{
                                $ok=$data->FG_update($data);                      
                            }//end if

                            return array('itemid' => $ok['itemid'],'msg'=>$ok['msg'],'uom_error'=>$ok['err_uom'],'errstat'=>$ok['errstat'],'type'=>'update');
                        } // end if barcode !=""
                    } else {
                        if($moduledata['barcode']!="") {
                            $barcode=$moduledata['barcode'];
                            if($data->amt==null){$data->amt=0.00; }
                            if($data->amt2==null){$data->amt2=0.00; }
                            if($data->famt==null){$data->famt=0.00; }
                            if($data->amt4==null){$data->amt4=0.00; }
                            if($data->isexempt==null){$data->isexempt=0; }
                            $ok=$data->insertitem($data);
                            $itemid=$data->itemid($barcode);
                            return array('itemid' => $itemid,'msg'=>$ok['msg'],'uom_error'=>'','errstat'=>0,'type'=>'insert');
                        }//END ELSE MODULE BARCODE != 0
                    }//END CHECK
                } // end strlen moduledata barcode
            }//END ELSE
        } catch (ErrorException $e) {
            echo $e;
        }//end try catch
    }//END SAVINGHEAD FUNCtION

    public function savinghead($controller,$access,$moduledata){
        try {
            $message = "";
            if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
                $msg = "INVALID SAVING HEAD.";
            }else{
                $data = new Client;
                $head = new Client;
                $common = new Common;
                $clientid = "";
                $length = $common->clientlength();
                $data = Yii::$app->backend->normalizeHeaddata($data,$moduledata,$controller);
                $clientid = $moduledata['clientid'];
                $client = $data->client;
                     if($clientid != "") {
                        $client = $common->PadJ($client, $length);
                        $check = Client::checkclient($moduledata['client']);
                            if($check!=0) {
                                if(strlen($data->client) !=0) {
                                    $client = $data->client;
                                    //$qrychecker = "select count(clientname) from client where clientname = '".$moduledata['clientname']."'";
                                    //$counterdups = Yii::$app->sbccommon->datareader($qrychecker);
                                    //if($counterdups == 0){                                    
                                        $status = $data->updateclient($clientid, $data);
                                        if(!$status){
                                            return array('head' => array('client'=>'NONE'),'msg'=>'Update Client Failed, Please try again.');
                                        }else{
                                            $msg = "Data saving Successfull!";    
                                        }//end if
                                   /* }else{
                                        $status = false;
                                        $msg = "Duplicate found for the name [".$data->clientname."]";
                                        $client = '';
                                        $clientid = 0;    
                                    }//endif*/
                                }//end if
                            }//end if
                        }else{
                            if(strlen($data->client) !=0) {
                                $client = $data->client;

                                $qrychecker = "select count(clientname) from client where clientname = '".$moduledata['clientname']."'";
                                $counterdups= Yii::$app->sbccommon->datareader($qrychecker);

                                if($counterdups == 0){
                                    $status = $data->insertclient($data);
                                    if($status){
                                        $clientid = Yii::$app->backend->requestClientid($client);
                                        $msg = "Data saving Successfull!";
                                    }else{
                                        $clientid = '';
                                        $msg = "Data saving failed. Please try again.";
                                    }//end if
                                }else{
                                    $status = false;
                                    $msg = "Duplicate found for the name [".$data->clientname."]";
                                    $client = '';
                                    $clientid = 0;
                                }//end if
                            }//end if
                        }//end if
                return array('head' => array('client'=>$client,'clientid'=>$clientid,'msg'=>$msg,'status'=>$status));
            }
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END SAVINGHEAD FUNCtION


    //EMPLOYEE
    public function savingheademployee($controller,$access,$moduledata){
        try {
            $message = "";
            if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
                $msg = "INVALID SAVING HEAD.";
            }else{
                $data = new Employee;
                $head = new Employee;
                $common = new Common;
                $clientid = "";
                $length = $common->clientlength();
                $data = Yii::$app->backend->normalizeHeaddata($data,$moduledata,$controller);

                $clientid = $moduledata['empid'];
                $client = $data->empcode;
                  if ($length!=0){
                        $client = $common->PadJ($client, $length);
                    } 
                     if($clientid != "") {
                        $check = Employee::checkempcode($moduledata['empcode']);

                            if($check!=0) {      //update
                                if (strlen($data->empcode) !=0) {
                                    $client = $data->empcode;
                                    $result = $data->updateEmployee($clientid, $data);

                                    if(!$result){
                                        return array('head' => array('client'=>'NONE'),'msg'=>'Update Client Failed, Please try again.');
                                    }else{
                                        $msg = "Data saving Successfull!";    
                                    } // end result == 0
                                } // end strlen data client
                            }//end if check
                        }else{ 

                            if(strlen($data->empcode) !=0) {
                                $client = $data->empcode;
                                $status = $data->insertemployee($data);
                                if($status){
                                    $clientid = Yii::$app->backend->requestEmpid($client);
                                    $msg = "Data saving Successfull!";
                                }else{
                                    $clientid = '';
                                    $msg = "Data saving failed. Please try again.";
                                }//end if
                            } // end strlen data client
                        } // end else
                return array('head' => array('client'=>$client,'clientid'=>$clientid,'msg'=>$msg));
            }//END ELSE ACCESS ACCEPTED
        } catch (ErrorException $e) {
            echo $e;
            return 0;
        }//end if
    }//END SAVINGHEAD FUNCtION



    public function deletingitem($controller,$accessdelete,$data){

        if(Yii::$app->session['loggeduser']['access'][$accessdelete] != 1){
            //INVALID ACCESS
            return "ACCESS NOT VALID";
        }else {
                $doc = $controller->module->id;
                $item = new Item;
                $weblist = new weblist;
                $common = new Common;
                $barcode=$data['barcode'];
                $itemid=$data['itemid'];

                $count=$item->checkitemtransaction($itemid);
                $action="delete";
                $newitemid=$common->navnext_prev($data['barcode'], $data['itemid'], $doc, $action);
                if($doc=='itemprofile'){
                    if($data['deptname']!=''){
                        $count = 1;
                    }else{
                        $count = 0;
                    }
                    $status = $item->deleteitemfa($itemid, $count);
                }else{
                    $status = $item->deleteitem($itemid);    
                }
                
                $head = $weblist->loadmodel($controller,$newitemid);

                //return array('head' => $status['status'],'del_error'=>'','del_msg'=>'');
                if($status['status'] == 1){
                    return array('head' => $head,'status'=>$status['status'],'del_msg'=>'');
                }else{
                    return array('head' => $head,'status'=>$status['status'],'del_msg'=>$status['del_msg']);
                }
      }//end if

    }//end if deleteing function

//EMPLOYEE
    public function deletingemployee($controller,$accessdelete,$data){
        if(Yii::$app->session['loggeduser']['access'][$accessdelete] != 1){
            //INVALID ACCESS
            return "ACCESS NOT VALID";
        } else {

            $client = $data['client'];
            $clientid = $data['clientid'];
            $doc = $controller->module->id;
            $action = "delete";
            
            $common = new Common();
            $weblist = new weblist();
            $clientid = $common->navnext_prev($client, $clientid, $doc, $action); //GETS TRNO OF THE LAST DOCUMENT
            $msg = $common->deleteemployee($client);
            $head = $weblist->loadmodel($controller,$clientid);
            return array('head' => $head,'msg'=>$msg);
      }
    }//END DELETE

    public function deleting($controller,$accessdelete,$data){
        if(Yii::$app->session['loggeduser']['access'][$accessdelete] != 1){
            //INVALID ACCESS
            return "ACCESS NOT VALID";
        } else {
            $client = $data['client'];
            $clientid = $data['clientid'];
            $doc = $controller->module->id;
            $action = "delete";
            
            $common = new Common();
            $weblist = new weblist();
            $clientid = $common->navnext_prev($client, $clientid, $doc, $action); //GETS TRNO OF THE LAST DOCUMENT
            $msg = $common->deleteclient($client);
            $head = $weblist->loadmodel($controller,$clientid);
            return array('head' => $head,'msg'=>$msg);
      }
    }//END DELETE

     public function searchingitem($controller,$accessparams,$action,$params){
        
            $head=new Item;
            $barcode = $params['barcode'];
            $common=new Common;
            $weblist=new weblist;
            $doc=$controller->module->id;
            $length=$common->barcodelength(); 

            if ($doc=='itemprofile'){
                $itemexist=Item::checkbarcodefa($barcode);
            }else{
                $itemexist=Item::checkbarcode($barcode);    
            }

            if($itemexist!=0){
                    $head = $weblist->loadmodel($controller,$itemexist);
                    return array('head' => $head,'error_msg'=>'');
            }else{

                if(empty($barcode)){
                    //FOR EMPTY BARCODE / OR PARAMETER BARCODE
                    $pref = 'IT';
                    if ($doc=='itemprofile'){
                        $pref = 'FA';
                        $last_barcode=$head->getlast_barcode2($pref);
                    }else{
                        $last_barcode=$head->getlast_barcode($pref);    
                    }

                    $start=$common->SearchPosition($last_barcode);
                    $seq=substr($last_barcode, $start) +1;
                    if(Yii::$app->systemsettings->setDefaultBarcodeLength() == 0){
                        $barcode = "";
                    }else{
                        $barcode = $pref . $seq;
                    }
                    $barcode=$common->PadJ($barcode, $length);
                    if ($doc=='itemprofile'){
                        $itemexist=Item::checkbarcodefa($barcode);
                    }else{
                        $itemexist=Item::checkbarcode($barcode);    
                    }

                    if($itemexist!=0){
                        $head = $weblist->loadmodel($controller,$itemexist);
                        return array('head' => $head,'error_msg'=>'');
                    }else{
                        $head->barcode=$barcode;
                        $head->uom='PC(s)';
                        return array('head' => array(0=>$head),'error_msg'=>'');
                    }//end item exisit
                }else{
                    //FOR PREF ONLY PARAMETER
                    $pref=$common->GetPrefix($barcode);

                    if(empty($pref)){
                        $pref = $barcode;
                        if($doc=='itemprofile'){
                            $last_barcode=$head->getlast_barcode2($pref);
                        }else{
                            $last_barcode=$head->getlast_barcode($pref);    
                        }          

                        $start=$common->SearchPosition($last_barcode);
                        $seq=substr($last_barcode, $start) +1;

                        if(Yii::$app->systemsettings->setDefaultBarcodeLength() == 0){
                            $barcode = $pref;
                        }else{
                            $barcode = $pref . $seq;
                        }
                        //$barcode = $pref . $seq;
                        $barcode=$common->PadJ($barcode, $length);
                        if($doc=='itemprofile'){
                            $itemexist=Item::checkbarcodefa($barcode);
                        }else{
                            $itemexist=Item::checkbarcode($barcode);    
                        }
                        
                        if($itemexist!=0){
                            $head = $weblist->loadmodel($controller,$itemexist);
                            return array('head' => $head,'error_msg'=>'');
                        }else{
                            $head->barcode=$barcode;
                            $head->uom='PC(s)';
                            return array('head' => array(0=>$head),'error_msg'=>'');
                        }//end item exisit
                    }else{ 
                        //FOR [WITH PREF FROM BARCODE]                        

                        $barcode=$common->PadJ($barcode, $length);
                        $start=$common->SearchPosition($barcode);                        

                        if(Yii::$app->systemsettings->setDefaultBarcodeLength() == 0){
                            $barcode = $pref;
                        }else{
                            $seq=substr($barcode, $start);
                            $barcode = $pref . $seq;
                        }

                        $barcode=$common->PadJ($barcode, $length);

                        if($doc=='itemprofile'){
                            $itemexist=Item::checkbarcodefa($barcode);
                        }else{
                            $itemexist=Item::checkbarcode($barcode);    
                        }
                        if($itemexist !=0){
                            $head = $weblist->loadmodel($controller,$itemexist);
                            return array('head' => $head,'error_msg'=>'');
                        }else{
                            $head->barcode=$barcode;
                            $head->uom='PC(s)';
                            return array('head' => array(0=>$head),'error_msg'=>'');
                        }//end if item exist
                    }//end if empty [ref]
                }//END
            }//end exact searching
                   
    }//END SEARCHING


    //THIS IS USED WHEN SEARCHING DOCNO FROM THE DOCNO TEXTBOX
    public function searching($controller,$accessparams,$action,$params){
        $client = new Client();
        $common = new Common();
        $doc = $controller->module->id;
        $moduleid = $controller->module->id;
        
            switch ($doc) {
                case 'customer':
                    $moduleid = 'CL';
                    break;
                
                case 'agent':
                    $moduleid = 'AG';
                    break;

                case 'supplier':
                    $moduleid = 'SL';
                    break;

                case 'warehouse':
                    $moduleid = 'WH';
                    break;
                //KEYWORD LOCATION&VENDOR    
                case 'location':
                    $moduleid = 'LC';
                    break; 

                case 'vendor':
                    $moduleid = 'VD';
                    break; 

                 case 'assetmaster':
                    $moduleid = 'AM';
                    break; 
                //END KEYWORD LOCATION&VENDOR
            }

        $params['client'] = strtoupper($params['client']);
        $length = $common->clientlength();

        $pref = '';
        if(strlen($params['client']) != 0){
        $pref = $common->GetPrefix($params['client']);
            if(empty($pref)){
                $pref = $params['client'];
            }//END PREF
        }else{
            $pref=Client::getsingledefaultprefixes($controller->module->id);
        }

        $seq = substr($params['client'],$common->SearchPosition($params['client']),strlen($params['client']));
        

        if(!is_numeric($seq)){
            $seq = 0;
        }        

        if(empty($seq) || $seq==0){
            $sql = "select client from client where left(client,length('".$pref."'))='".$pref."' order by client desc limit 1";
            $searchclient= Yii::$app->sbccommon->datareader($sql);
            if(!empty($searchclient)){
                $seq = substr($searchclient,$common->SearchPosition($searchclient),strlen($searchclient));
                $seq = $seq+1;
                $clseq = $pref . $seq;        
            }else{
                $seq = $seq+1;
                $clseq = $pref . $seq; 
            }   
        }else{
            $seq = $seq;
            $clseq = $pref . $seq;  
        }//end if

        $new_client = $common->PadJ($clseq, $length);
        $pogi = $client->checkclient($new_client);
        
        if($pogi){
            $clientid= Yii::$app->sbccommon->datareader("select clientid from client where client='$new_client'");
            $tunay = $client->openclient($clientid,$doc);
             return array('head' => $tunay[0],'error_msg'=>'');
        }else{

            $blnExist = false;
            $prefixes = $client->getPrefixes($moduleid);//GETS ALL PREFIXES FOR THIS DOC
            $availprefs = explode(",", $prefixes);
           
                if(!empty($prefixes)){
                    for ($i = 0; $i < count($availprefs); $i++) {
                        if ($pref == $availprefs[$i]) {
                            $blnExist = true;
                        }//END COMPARE
                    }//END FOR LOOP
                }//END IF ELSE
           
            if($blnExist){
            $client->client = $new_client;
            switch ($doc) {
                    case 'supplier':
                         $client->IsSupplier = 1;
                        break;
                    case 'agent':
                         $client->IsAgent = 1;
                        break;
                    case 'warehouse':
                         $client->IsWarehouse = 1;
                        break;

                    //KEYWORD LOCATION&VENDOR    
                    case 'location':
                         $client->isLocation = 1;
                        break;
                    case 'vendor':
                         $client->isVendor = 1;
                        break;        
                    //END KEYWORD LOCATION&VENDOR

                    default:
                        $client->IsCustomer = 1;
                        break;
                }//END SWITCH
            return array('head' => $client,'error_msg'=>'');
            }else{
                $weblist = new weblist;
                $prefix = "/";
                $count = count($availprefs);
                for($x = 0; $x < $count; $x++){
                    $prefix = $prefix . $availprefs[$x] . " / ";
                }
                return array('head'=>'','error_msg'=>'Invalid prefix , Available prefixes are: ['.$prefix.']');
            }//end if blnexist
        }
    }//END SEARCHING

    public function showlogs($controller,$params){
        $model = new Log();
        $doc = $controller->module->id;        
        switch($doc){         
            case 'stockcard': case 'posstockcard':
            $itemid = $params['itemid'];
            $data = $model->getlogs($doc, $itemid,'');
            break;

            default:
            $clientid = $params['clientid'];
            $data = $model->getlogs($doc, $clientid,'');
            break;
        }
        return $data;
    }//END SHOWLOGS

    //JAC GEN ITEM 2016.08.20
    public function genitemnewing($controller,$access,$barcode){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF NOT ALLOWED FOR CREATING NEW DOCUMENTS
        }else{
            $doc = $controller->module->id;
            $weblist = new weblist; 
            $common = new Common;
            $head = new Client;
            $item = new Item;
            $length=$common->barcodelength();

            
                if(empty($barcode)){
                    $pref = "IT";
                }else{
                    $pref=$common->GetPrefix($barcode);
                }//end if
                $last_barcode=$item->getlast_bcode($pref);
                $start=$common->SearchPosition($last_barcode);
                $seq=substr($last_barcode, $start) +1;
                if(Yii::$app->systemsettings->setDefaultBarcodeLength() == 0){
                    $clseq= "";
                }else{
                    $clseq=$pref.$seq;
                }
                $new_barcode=$common->PadJ($clseq, $length);
                $item->bcode=$new_barcode;
                $item->itemuom="PCS";
                
        }//END else access
        return array('head' => $item);
    }// END new general item

    public function genitemsaving($controller,$access,$barcode){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //IF NOT ALLOWED FOR saving DOCUMENTS
        }else{
            $doc = $controller->module->id;
            $weblist = new weblist; 
            $common = new Common;
            $item = new Item;

            $item->bcode = $barcode['bcode'];
            $item->itemdesc = $barcode['itemdesc'];
            $item->itemshortname = $barcode['itemshortname'];
            $item->itembrand = $barcode['itembrand'];
            $item->itempart = $barcode['itempart'];
            $item->itemuom = $barcode['itemuom'];
            $item->itemgroup = $barcode['itemgroup'];
            $item->itemcolor = $barcode['itemcolor'];
            $item->itemclass = $barcode['itemclass'];
            $item->itemmodel = $barcode['itemmodel'];
            $item->itemsize = $barcode['itemsize'];
            $item->line = $barcode['line'];
            $line = $barcode['line'];
            
            if ($line == 0){
            $ret = $weblist->insertgenitem($item);    
            }else{
            $ret = $weblist->updategenitem($item,$line);   
            }          
            
            
            $genitem = $item->openGeneralItemline($item->bcode);
            
            if (!empty($genitem)){
                $item->bcode = $genitem[0]['bcode'];
                $item->itemdesc = $genitem[0]['itemdesc'];
                $item->itemshortname = $genitem[0]['itemshortname'];
                $item->itembrand = $genitem[0]['itembrand'];
                $item->itempart = $genitem[0]['itempart'];
                $item->itemuom = $genitem[0]['itemuom'];
                $item->itembrand = $genitem[0]['itembrand'];
                $item->itemgroup = $genitem[0]['itemgroup'];
                $item->itemcolor = $genitem[0]['itemcolor'];
                $item->itemclass = $genitem[0]['itemclass'];
                $item->itemsize = $genitem[0]['itemsize'];
                $item->itemmodel = $genitem[0]['itemmodel'];
                $item->line = $genitem[0]['line'];
            } 
            
                
        }//END else access

        if ($line == 0){
             return array('genitem' => $item);
         }else{
            $passjson = array('bcode'=>$item->bcode,'itemdesc'=>$item->itemdesc,'itemshortname'=>$item->itemshortname,'itembrand'=>$item->itembrand,'itempart'=>$item->itempart,'itemuom'=>$item->itemuom,'itemcolor'=>$item->itemcolor,'itemgroup'=>$item->itemgroup,'itemclass'=>$item->itemclass,'itemsize'=>$item->itemsize,'itemmodel'=>$item->itemmodel,'line'=>$item->line);
               echo json_encode($passjson);
         }
        
       
    }
    //END JAC


    //FMM
    public function fixedassetnew($controller,$access,$dataparams){
            if(Yii::$app->session['loggeduser']['access'][$access] != 1){
                //IF NOT ALLOWED FOR CREATING NEW DOCUMENTS
            }else{
                $doc = $controller->module->id;
                $weblist = new weblist; 
                $common = new Common;
                $head = new Client;
                $item = new Item;
                $length=$common->barcodelength();

                if($dataparams['copyprevdata']){
                    $barcode=$dataparams['barcode'];
                    $itemexist=Item::checkbarcodefa($barcode);
                    $data = $item->openitemfa($itemexist);

                    if($data!=null){
                        $item->itemid=$data[0]['itemid'];
                        $item->bcode=$data[0]['bcode'];
                        $item->itemname=$data[0]['itemname'];
                        $item->shortname=$data[0]['shortname'];
                        $item->groupid=$data[0]['groupid'];
                        $item->part=$data[0]['part'];
                        $item->itemrem=$data[0]['itemrem'];
                        $item->model=$data[0]['model'];
                        $item->brand=$data[0]['brand'];
                        $item->class=$data[0]['class'];
                        $item->color=$data[0]['color'];
                        $item->sizeid=$data[0]['sizeid'];
                    }

                    $start=$common->SearchPosition($barcode);
                    $seq=substr($barcode, $start) + 1;
                    $pref=$common->GetPrefix($barcode);
                    $barcode = $pref . $seq;
                    $barcode=$common->PadJ($barcode, $length);
                    $item->barcode = $barcode;                
                }else{
                    if(empty($dataparams['barcode'])){
                        $pref = "FA";
                    }else{
                        $pref=$common->GetPrefix($dataparams['barcode']);
                    }//end if

                    $last_barcode=$item->getlast_barcode2($pref);
                    $start=$common->SearchPosition($last_barcode);
                    $seq=substr($last_barcode, $start) +1;
                    $clseq=$pref.$seq;
                    
                    $new_barcode=$common->PadJ($clseq, $length);
                    $item->barcode=$new_barcode;
                    $item->uom="PCS";                     
                }
               
            }  

            return array('head' => $item);      
        }


public function savingitemfa($controller,$access,$moduledata){//fixedasset
        $message = "";

        if (Yii::$app->session['loggeduser']['access'][$access] != 1) {
            $msg = "INVALID SAVING HEAD.";
        }else{
            $data= new Item;
            $module=$controller->module->id;
            $itemid="";
            $barcode=$moduledata['barcode'];
            $data->itemid = $moduledata['itemid'];            
            $data->itemname = $moduledata['itemname'];
            $data->barcode = $moduledata['barcode'];
            $data->bcode = $moduledata['bcode'];
            $data->shortname = $moduledata['shortname'];
            $data->groupid = $moduledata['groupid'];                              
            $data->category = $moduledata['category'];
            $data->model = $moduledata['model'];
            $data->brand = $moduledata['brand'];
            $data->color = $moduledata['color'];
            $data->part = $moduledata['part'];
            $data->class = $moduledata['class'];            
            $data->subcode = $moduledata['subcode'];            
            $data->sizeid = $moduledata['sizeid'];
            $data->itemrem = $moduledata['itemrem'];
            $data->depamt = $moduledata['depamt'];
            $data->depsalvage = $moduledata['depsalvage'];
            $data->deplife = $moduledata['deplife'];
            $data->supp = $moduledata['supp'];
            $data->suppname = $moduledata['suppname'];
            $data->buyer = $moduledata['buyer'];
            $data->buyername = $moduledata['buyername'];
            $data->inv = $moduledata['inv'];
            $data->po = $moduledata['po'];
            $data->itemprice = $moduledata['itemprice'];
            $data->plate = $moduledata['plate'];
            $data->man = $moduledata['man'];
            $data->fuel = $moduledata['fuel'];
            $data->insurance = $moduledata['insurance'];
            $data->vin = $moduledata['vin'];
            $data->manyr = $moduledata['manyr'];
            $data->engine = $moduledata['engine'];            
            $data->vehicleexp = $moduledata['vehicleexp']; 
            $data->isnew = $moduledata['isnew']; 
            $data->isused = $moduledata['isused']; 
            $data->islease = $moduledata['islease']; 

            $data->dtedisposal = $moduledata['dtedisposal']; 
            $data->dteinv = $moduledata['dteinv']; 
            $data->dtepo = $moduledata['dtepo']; 
            $data->dtewarranty = $moduledata['dtewarranty']; 
            $data->dtelease = $moduledata['dtelease']; 
            $data->dteacq = $moduledata['dteacq']; 

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'TENPLUS':
                    $data->itemhandling = $moduledata['itemhandling']; 
                    $data->itemcomm = $moduledata['itemcomm']; 
                break;

                default:
                    $data->itemhandling = ''; 
                    $data->itemcomm = ''; 
                break;
            }//end switch

            if(strlen($moduledata['barcode'])!=0){
                $check=Item::itemid2($barcode);  
                if ($check){
                    if($moduledata['barcode']!=""){
                        $barcode=$moduledata['barcode'];
                        $ok=$data->updatefa($data);                      
                        return array('itemid' => $ok['itemid'],'msg'=>$ok['msg'],'uom_error'=>$ok['err_uom'],'errstat'=>$ok['errstat']);                    
                    }
                }else{
                    if($moduledata['barcode']!=""){
                        $barcode=$moduledata['barcode'];
                        $ok=$data->insertitemfa($data);
                        $itemid=$data->itemid2($barcode);                                    
                        return array('itemid' => $itemid,'msg'=>$ok['msg'],'uom_error'=>'','errstat'=>0);                    
                    }
                }                
            }   
        }
    }        



    //END FMM

}//END COMPONENTS
?>
