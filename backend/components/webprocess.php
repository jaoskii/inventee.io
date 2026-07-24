<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\web\sessions;

use app\models\Webproc;
use app\models\Common;
use app\models\Pohead;
use app\models\Postock;
use app\models\Lahead;
use app\models\Lastock;
use app\models\Apledger;
use app\models\Ladetail;
use app\models\Client;
use app\models\Cntnum;
use app\models\Transnum;
use app\models\Item;
use app\models\Log;  
use app\models\Taxhead;
use app\models\Taxnum;
use app\models\Taxdetail;
use app\models\Trhead;
use app\models\Trstock;
use yii\base\ErrorException;
use yii\web\Response;



class webprocess extends Component{
//######################################################################  USED FOR INDEX SET UP OF A MODULE
    public function index($controller,$access) {
        try {
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) { //IF ACCESS DENIED
            $data = "not allowed";
            return $data;
        } else { //IF ACCESS IS ACCEPTED
            switch ($controller->module->id) {
                case 'SJ2': $doc = 'SJ'; break;

                case 'quotation': $doc = 'QT'; break;
                case 'pscheme': $doc = 'PS'; break;
                default: $doc = $controller->module->id; break;
            }//END SWITCH

            $webproc = new Webproc; 
            $openhead=$webproc->gettranstype($doc); //GETS TABLENAME FOR LOCAL
            switch($openhead) {
                case "Lahead": $head = new Lahead(); break;
                case "Taxhead": $head = new Taxhead(); break;    
                default: $head = new Pohead(); break;
            }
            $common = new Common;
            $filter = "";
            $trno = $common->navfirst_last($doc,'last'); //GETS TRNO OF THE LAST DOCUMENT

            if($trno == "") { //IF THERE IS NO TRANSCATION
                $body = "";
                return array('head' => $head, 'body' => $body);
            } else {
                switch($openhead) { //SETS WHERE TO OPEN TABLE
                    case "Lahead": $data = Lahead::openhead($trno, $doc); break;
                    case "Taxhead": $data = Taxhead::openhead($trno, $doc); break;
                    default: $data = Pohead::openhead($trno, $doc); break;
                }//end switch
                
                if (!empty($data)) { //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
                    $head=$webproc->loadheaddata($head, $data, $doc);
                }//end if

                switch ($doc) {
                    case 'CR': case 'CV': case 'AR': case 'AP': case 'PV': case 'GJ': case 'DS': case 'KR': case 'TW':
                        $gettotal = Ladetail::getgrandtotal($trno,$doc);
                        if(isset($gettotal[0]['totaldb']) || isset($gettotal[0]['totalcr'])) {
                            $runningdb = $gettotal[0]['totaldb'];
                            $runningcr = $gettotal[0]['totalcr'];
                        } else {
                            $runningdb = "0.00";
                            $runningcr = "0.00";
                        }
                        $head->totaldb = $runningdb;
                        $head->totalcr = $runningcr;
                    break; // CR, CV, AR, AP, PV, GJ, DS, KR, TW
                    
                    default:
                        switch($openhead) {
                            case 'Lahead': $grandtotal = Lastock::getgrandtotal($trno, $doc); break;
                            case 'Taxhead': $grandtotal = Taxdetail::getgrandtotal($trno, $doc); break;
                            default: $grandtotal = Postock::getgrandtotal($trno, $doc); break;
                        }//end switch
                        if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) { //IF SET GRAND TOTAL AMOUNT TO 0 IF DOESNT HAVE ANY VALUE
                            $head->grandtotal = 0;
                        } else {
                            $head->grandtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'],
                            Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                        }               
                        if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) { //IF SET GRAND TOTAL ITEM COUNT TO 0 IF DOESNT HAVE ANY VALUE
                            $head->itemcount = 0;
                        } else {
                            $head->itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'],
                            Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                        }
                        if(isset($grandtotal[0]['kilototal']) && $grandtotal[0]['kilototal'] == null) { //IF SET GRAND TOTAL KILO TO 0 IF DOESNT HAVE ANY VALUE
                            $head->totalkilo = 0;
                        } else {
                            $head->totalkilo = isset($grandtotal[0]['kilototal']) ? number_format($grandtotal[0]['kilototal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                        }
                        switch ($doc) {
                            case 'SO': case 'SJ': case 'QA': case 'quotation': case 'QT':
                                switch (Yii::$app->systemsettings->companyConfig()) {
                                    case 'SOUTHCENTRAL':
                                        if (isset($grandtotal[0]['totalcbm']) && $grandtotal[0]['totalcbm'] == null) {
                                            $head->totalcbm = 0;
                                        } else {
                                            $head->totalcbm = isset($grandtotal[0]['totalcbm']) ? number_format($grandtotal[0]['totalcbm'],
                                            Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                                        }
                                        if (isset($grandtotal[0]['totaltonnage']) && $grandtotal[0]['totaltonnage'] == null) {
                                            $head->totaltonnage = 0;
                                        } else {
                                            $head->totaltonnage = isset($grandtotal[0]['totaltonnage']) ? $grandtotal[0]['totaltonnage'] : 0;
                                        }
                                    break;
                                }//end swtich
                            break;
                            case 'RR':
                                if(isset($grandtotal[0]['forexgrandtotal']) && $grandtotal[0]['forexgrandtotal'] == null) {
                                    $head->totalforex = 0;
                                } else {
                                    $head->totalforex = isset($grandtotal[0]['forexgrandtotal']) ? number_format($grandtotal[0]['forexgrandtotal'], Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                                }
                            break;
                        }//END SWTICH CASE
                    break; // DEFAULT
                }//END SWITCH DOC
                $common->setview($trno, $doc); //SETS AND UPDATES VIEW BY AND DATE VIEWED
                $head->islocked = Cntnum::islocked($trno, $doc);
                $head->isposted = Cntnum::isPosted($trno,$doc);
                return array('head' => $head);
            }//ELSE IF TRNO = ""
        }//END IF ACCESS ACCEPTED
        
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END INDEX


    public function viewing($controller,$access,$action,$params) {
        try {
        //added patches for document module viewing - for repatched navigations            
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) {
            $return = "not allowed";
            return $data;
        } else {
            switch ($controller->module->id) {
                case 'SJ2': $doc = 'SJ'; break;
                case 'pscheme': $doc = 'PS'; break;

                case 'quotation': $doc = 'QT'; break;
                default: $doc = $controller->module->id; break;
            }
            $webproc = new Webproc; 
            $openhead=$webproc->gettranstype($doc);
            switch($openhead) {
                case "Lahead": $head = new Lahead(); break;
                case "Taxhead": $head = new Taxhead(); break;
                default: $head = new Pohead(); break;
            }
            $common = new Common;
            $filter = "";

            switch($action) {
                case "first": case "last": 
                    $trno = $common->navfirst_last($doc,$action); //GETS TRNO OF THE LAST DOCUMENT
                break;
                case "next": case "previous": 
                    $trno = $common->navnext_prev($params['docno'], $params['trno'], $doc, $action); //GETS TRNO OF THE LAST DOCUMENT
                break;
                default: 
                    $trno = $common->navfirst_last($doc,$action); //GETS TRNO OF THE LAST DOCUMENT;
                break;
            }

            if($trno == "") {
                return array('head' => $head, 'body' => '');
            } else {
                switch($openhead) {
                    case "Lahead": $data = Lahead::openhead($trno, $doc); break;
                    case "Taxhead": $data = Taxhead::openhead($trno, $doc); break;
                    default: $data = Pohead::openhead($trno, $doc); break;
                }
                switch($openhead) {
                    case 'Lahead': $grandtotal = Lastock::getgrandtotal($trno, $doc); break;
                    case 'Taxhead': $grandtotal = 0; break;
                    default: $grandtotal = Postock::getgrandtotal($trno, $doc); break;
                }

                //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
                if($data != null) {
                    $head=$webproc->loadheaddata($head, $data, $doc);
                }

                switch ($doc) {
                    case 'CR': case 'CV': case 'AR': case 'AP': case 'PV': case 'GJ': case 'DS': case 'TW':
                        $gettotal = Ladetail::getgrandtotal($trno,$doc);
                        if(isset($gettotal[0]['totaldb']) || isset($gettotal[0]['totalcr'])){
                            $runningdb = $gettotal[0]['totaldb'];
                            $runningcr = $gettotal[0]['totalcr'];
                        }else{
                            $runningdb = "0.00";
                            $runningcr = "0.00";
                        }
                            $head->totaldb = $runningdb;
                            $head->totalcr = $runningcr;
                        break;
                    
                    default:
                        switch($openhead) {
                            case 'Lahead':
                                $grandtotal = Lastock::getgrandtotal($trno, $doc);
                                break;
                            default:
                                $grandtotal = Postock::getgrandtotal($trno, $doc);
                                break;
                        }

                        //IF SET GRAND TOTAL AMOUNT TO 0 IF DOESNT HAVE ANY VALUE
                        if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
                            $head->grandtotal = 0;
                        }else{
                            $head->grandtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                        }
                        //IF SET GRAND TOTAL ITEM COUNT TO 0 IF DOESNT HAVE ANY VALUE               
                        if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
                            $head->itemcount = 0;
                        }else{
                            $head->itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                        }

                        //IF SET GRAND TOTAL KILO TO 0 IF DOESNT HAVE ANY VALUE               
                        if(isset($grandtotal[0]['kilototal']) && $grandtotal[0]['kilototal'] == null) {
                            $head->totalkilo = 0;
                        }else{
                            $head->totalkilo = isset($grandtotal[0]['kilototal']) ? number_format($grandtotal[0]['kilototal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                        }

                        switch ($doc) {
                            case 'SO': case 'SJ': case 'QA':
                                switch (Yii::$app->systemsettings->companyConfig()) {
                                    case 'SOUTHCENTRAL':
                                        if (isset($grandtotal[0]['totalcbm']) && $grandtotal[0]['totalcbm'] == null) {
                                            $head->totalcbm = 0;
                                        }else{
                                            $head->totalcbm = isset($grandtotal[0]['totalcbm']) ? number_format($grandtotal[0]['totalcbm'],
                                                Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                                        }

                                        if (isset($grandtotal[0]['totaltonnage']) && $grandtotal[0]['totaltonnage'] == null) {
                                            $head->totaltonnage = 0;
                                        }else{
                                            $head->totaltonnage = isset($grandtotal[0]['totaltonnage']) ? $grandtotal[0]['totaltonnage'] : 0;
                                        }
                                    break;
                                }//end swtich
                                break;

                            case 'RR':
                                if (isset($grandtotal[0]['forexgrandtotal']) && $grandtotal[0]['forexgrandtotal'] == null) {
                                    $head->totalforex = 0;
                                }else{
                                    $head->totalforex = isset($grandtotal[0]['forexgrandtotal']) ? number_format($grandtotal[0]['forexgrandtotal'],
                                        Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                                }//end switch
                            break;
                        }//END SWTICH CASE

                        break;
                }//END SWITCH DOC

                $common->setview($trno, $doc); //SETS AND UPDATES VIEW BY AND DATE VIEWED

                $head->islocked = Cntnum::islocked($trno, $doc);
                $head->isposted = Cntnum::isPosted($trno,$doc);
                return array('head' => $head, 'body' => '');
            }//END IF TRNO == ""
        }
        //code...
        } catch (ErrorException $th) {
            echo $th;
        }
    }//END VIEWING


    public function newing($controller,$access,$dataparams){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            $error = "Not allowed";
            return $error;
        }else{
            switch ($controller->module->id) {
                case 'SJ2':
                    $doc = 'SJ';
                    break;
                
                default:
                    $doc = $controller->module->id;
                    break;
            }//END SWITCH
            $webproc = new Webproc; 
            $openhead=$webproc->gettranstype($doc);

            if($openhead=='Lahead'){$head = new Lahead();}
            else{$head = new Pohead();}       

            $common = new Common();

            if (isset($dataparams['docno']) && strlen($dataparams['docno']) != 0) {
                $pref = $common->GetPrefix($dataparams['docno']);
            }else{
                if ($doc == 'pscheme') { $doc = 'PS'; }

                if ($doc == 'quotation'){ $doc = 'QT';}
                $pref = $common->last_bref($doc);
            }//end if

            $docnolength = $common->doclength();

            if (!$pref) {
                $prefixes = $common->getPrefixes($doc);
                $pref = isset($prefixes[0]) ? $prefixes[0] : $doc;
            }//end if $pref



                $seq = $common->getlastseq($pref,$doc,Yii::$app->session['loggeduser']['center']);
                $poseq = $pref . $seq;
                $newdocno = $common->PadJ($poseq, $docnolength);

                $head->docno = $newdocno;
                $head->dateid = date("Y-m-d");
                $head->due = date("Y-m-d");
                $head->forex = 1.00;
                $head->cur = 'P';
                
                // PANDATOOLS UPDATE
                if (Yii::$app->systemsettings->companyConfig() == "PANDATOOLS"){
                    if ($doc == 'SJ'){
                        $head->waybilldate = date("Y-m-d");
                    }//ed if
                }//end if
                // END PANDA

                if($openhead == 'Lahead'){
                    $head->tax = Yii::$app->backend->getdefaultValues('tax');
                }//end f

                switch ($doc) {
                    case 'SP':
                        $head->effectivedate = date("Y-m-d");
                    break;
                }//end if

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        switch($doc) {
                            case 'SO'; case 'SJ':
                                $head->transtype = 'REGULAR';
                            break;
                        }//end switch
                    break;
                }//end switch
                
                switch($doc) {
                    case 'SV': case'RR':case'DM':case'CA':case'AP':
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            default:
                                $contra='AP1';
                            break;
                        }//end switch
                    break;

                    case'CM':case'AR': 
                        $contra='AR1';
                    break;
                    
                    case 'SJ':
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'INFINITEA':
                                $contra='CA1';
                                $salestype='CASH';
                                $head->salestype = $salestype;
                            break;

                            default:
                                $contra='AR1';
                                $salestype='CHARGE';
                                $head->salestype = $salestype;
                            break;
                        }//end switch case                            
                    break;

                    case 'CH':
                        $contra='CA1';
                    break;

                    case 'PV':
                        $contra='AP2';
                    break;
                    
                    case 'IS':case 'AJ': case 'PK':
                        $contra='IS1';
                    break;
                    
                    case 'CV':case 'DS': 
                        $contra='CB1';
                    break;
                    
                    case 'CR':
                        $contra='CR1';
                    break;
                    
                    default:
                        $contra='';
                    break;
                }//END CASE

                
                if($contra!=''){
                    $head->contra = Ladetail::getacno($contra) . '~' . Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
                }//end if

                if($doc == "DS"){
                    $head->clientname = Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
                }//end f
               
                if($doc=='PC' || $doc=='IS' || $doc=='TS' || $doc=='AJ' || $doc == 'PK'){
                    $head->client = Yii::$app->session['loggeduser']['whcode'];
                    $head->clientname = Yii::$app->session['loggeduser']['whname'];                    
                    $head->whid = Yii::$app->session['loggeduser']['whcode'];
                    $head->wh = Yii::$app->session['loggeduser']['whname'];
                }//end if


                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        switch ($doc) {
                            case 'SO': case 'SJ': case 'CM':
                                $head->whid = 'PC0000000000002';
                                $head->wh = Yii::$app->sbccommon->datareader('select clientname from client where client = "'.$head->whid.'"');
                            break;

                            case 'TS':
                                $head->whid = 'PC0000000000001';
                                $head->wh = Yii::$app->sbccommon->datareader('select clientname from client where client = "'.$head->whid.'"');
                                $head->client = 'PC0000000000002';
                                $head->clientname = Yii::$app->sbccommon->datareader('select clientname from client where client = "'.$head->client.'"');
                            break;
                            
                            default:
                                $head->whid = Yii::$app->session['loggeduser']['whcode'];
                                $head->wh = Yii::$app->session['loggeduser']['whname'];
                            break;
                        }//end switch
                    break;
                    
                    default:
                        $head->whid = Yii::$app->session['loggeduser']['whcode'];
                        $head->wh = Yii::$app->session['loggeduser']['whname'];
                    break;
                }//end switch

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        //THIS CODE BLOCK IS FOR VAT TYPE
                        if($doc == "SJ" || $doc == "RR"){
                            if($doc == 'SJ'){ // FOR SJ VAT TYPE
                                switch ($pref) {
                                    case 'SI': case 'CI': case 'CS':
                                        $head->vattype = '';
                                        $head->tax = 0;
                                    break;
                                    
                                    default:
                                        switch (Yii::$app->systemsettings->companyConfig()) {
                                            case 'PANDATOOLS':
                                                $head->vattype = '';
                                                $head->tax = 0;
                                            break;
                                            
                                            default:
                                                $head->vattype = '';
                                                $head->tax = 0;
                                            break;
                                        }//END SWTCH
                                    break;
                                }//end switch case
                            }else{ //FOR RR VAT TYPE
                                switch ($pref) {
                                    default:
                                        $head->vattype = 'NON-VATABLE';
                                        $head->tax = 0;
                                        break;
                                }//end switch case
                            }//end if else
                        }//END IF sj
                    break;

                    default:
                        //THIS CODE BLOCK IS FOR VAT TYPE
                        if($doc == "SJ" || $doc == "RR"){
                            if($doc == 'SJ'){ // FOR SJ VAT TYPE
                                switch ($pref) {
                                    case 'SI': case 'CI': case 'CS':
                                        $head->vattype = 'VATABLE';
                                        $head->tax = 12;
                                    break;
                                    
                                    default:
                                        switch (Yii::$app->systemsettings->companyConfig()) {
                                            case 'PANDATOOLS':
                                                $head->vattype = 'VATABLE';
                                                $head->tax = 12;
                                            break;
                                            
                                            default:
                                                $head->vattype = 'NON-VATABLE';
                                                $head->tax = 0;
                                            break;
                                        }//END SWTCH
                                    break;
                                }//end switch case
                            }else{ //FOR RR VAT TYPE
                                switch ($pref) {
                                    default:
                                        $head->vattype = 'NON-VATABLE';
                                        $head->tax = 0;
                                        break;
                                }//end switch case
                            }//end if else
                        }//END IF sj
                    break;
                }//end switch
                

        $body = "";
        $head->isposted = false;
        $head->islocked = false;
        

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                switch ($doc) {
                    case 'SO': case 'SJ': case 'CM':
                        $clen = $common->clientlength();
                        $searchclient = $common->PadJ(Yii::$app->session['loggeduser']['username'], $clen);   
                        $qry_checker = "select client,clientname from client where client = '".$searchclient."'";
                        $data = Yii::$app->sbccommon->opentable($qry_checker);

                        if(!empty($data)){
                            $head->agentcode = $data[0]['client'] . '~'.$data[0]['clientname'];
                        }else{
                            $head->agentcode = '';
                        }//end if
                    break;
                }//END SWITCH
            break;
        }//end switch
        return array('head' => $head, 'body' => $body);
        }//END IF
    }

//########################################## FOR SAVING MODULE HEAD #################################################3
    public function savinghead($controller,$access,$moduledata){
        try {
            $message = "";
            if (Yii::$app->session['loggeduser']['access'][$access] != 1) { //ACCESS DENIED
                $error = "Not allowed";
                return $error;
            } else { //IF ACCESS ACCEPTED
                
                switch ($controller->module->id) {
                    case 'SJ2': $doc = 'SJ'; break;
                    case 'pscheme': $doc ='PS'; break;

                    case 'quotation': $doc = 'QT'; break;
                    default: $doc = $controller->module->id; break;
                }//END SWITCH

                $webproc = new Webproc;
                $openhead=$webproc->gettranstype($doc);
                
                if($doc=='DS') {
                    $data = new Lahead();
                } else {
                    if($openhead=='Lahead'){ $data = new Lahead(); } else { $data = new Pohead(); }
                }//end if

                if($doc=='TW') { $data = new Taxhead(); } //end if

                $common = new Common();
                $trno = "";


                $data = Yii::$app->backend->normalizeHeaddata($data,$moduledata,$controller);
                $data = Yii::$app->backend->checkDatabeforeSaving($openhead,$data);
                
                $clientid = Client::checkclient($data->client);
                if(empty($clientid)) { $clientid = 0; }
                if($clientid=='') { $clientid = 0; }
                if($doc == 'SO') { $data->modamt = 0; }
                if($doc == 'PS') { $data->modamt = 0; }
                if($doc == 'QA') { $data->modamt = 0; }
                if ($doc!='DS' && $doc!='PI'){
                    if($clientid==0){
                        $data->client='';
                        $data->clientname='';
                    }//END IF CLIENT ID
                }//END IF DOC != "DS"
                $pref = $common->GetPrefix($moduledata['docno']);
                $docnolength = $common->doclength();
                $seq = $common->getlastseq($pref,$doc,Yii::$app->session['loggeduser']['center']);
                $poseq = $pref . $seq;
                $newdocno = $common->PadJ($poseq, $docnolength);
                $prefixes = $common->getPrefixes($doc);//GETS ALL PREFIXES FOR THIS DOC
                $blnExist = false;

                if(!empty($prefixes)){
                    for ($i = 0; $i < count($prefixes); $i++) {
                    if ($pref == $prefixes[$i]) {
                        $blnExist = true;
                        }//END COMPARE
                    }//END FOR LOOP
                }//END IF else


                if($blnExist) {
                    if($data->trno != "") {
                        $trno = $data->trno;
                        if($doc =='TW') {
                            if($openhead=='Taxhead') {
                            $update=Taxhead::updatehead($trno, $moduledata['docno'], $data, $doc);
                            }
                        } else {
                            if($openhead=='Lahead') {
                                $update=Lahead::updatehead($trno, $moduledata['docno'], $data, $doc);
                            } else {
                                $update=Pohead::updatehead($trno, $moduledata['docno'], $data, $doc);
                            }//end if
                        }//end doc
                        
                        switch($openhead) {
                            case "Lahead": $headdata = Lahead::openhead($trno, $doc); break;
                            case "Taxhead": $headdata = Taxhead::openhead($trno, $doc); break;
                            default: $headdata = Pohead::openhead($trno, $doc); break;
                        }           

                        if (!empty($headdata)) { //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
                            $head=$webproc->loadheaddata($data, $headdata, $doc);
                        }

                        return array('trno' => $trno, 'docno'=> $moduledata['docno'],'msg'=>$message,'type'=>'update','head'=>$head);
                    } else {
                        $docnolength = $common->doclength();
                        $docno = $moduledata['docno'];
                        if ($docnolength != strlen($docno)) { $docno = $common->PadJ($docno, $docnolength); }
                        $bref = $common->GetPrefix($docno);
                        $seq = (substr($docno, $common->SearchPosition($docno), strlen($docno)));

                        if ($doc =='TW') { //TW KEYWORD
                            $insertcntnum = $common->inserttaxnum($doc, $docno, $seq, $bref,Yii::$app->session['loggeduser']['center']);   
                        } else {
                            $insertcntnum = $common->insertcntnum($doc, $docno, $seq, $bref,Yii::$app->session['loggeduser']['center']);
                        }
                        
                        if($insertcntnum==0) {
                            while ($insertcntnum == 0) { //IF TRANSACTION IS SAME DOCUMENT IT CREATES ANOTHER UNTIL IT COULD BE VALID DOCNO
                                $pref = $common->GetPrefix($docno);
                                $docnolength = $common->doclength();
                                $seq = $common->getlastseq($pref,$doc,Yii::$app->session['loggeduser']['center']);
                                $poseq = $pref . $seq;
                                $newdocno = $common->PadJ($poseq, $docnolength);
                                if ($doc =='TW') { //TW KEYWORD
                                    $insertcntnum = $common->inserttaxnum($doc, $newdocno, $seq, $bref,Yii::$app->session['loggeduser']['center']);  
                                } else {
                                    $insertcntnum = $common->insertcntnum($doc, $newdocno, $seq, $bref,Yii::$app->session['loggeduser']['center']);
                                }
                                if (($docno != $newdocno) && ($trno == "") && ($insertcntnum !=0) ) {
                                    $docno = $newdocno;
                                    $data->docno = $newdocno;
                                    $title = 'Document number taken';
                                    $message = 'Your transaction has been saved under document # ' . $newdocno;
                                }
                            }//end white insertcntnum
                        }//END insertcntnum 0

                        if($doc == "TW") {
                            $trno_ = Taxnum::getTrnodocno($docno,$doc,Yii::$app->session['loggeduser']['center']);
                        } else {
                            $trno_ = Cntnum::getTrnodocno($docno,$doc,Yii::$app->session['loggeduser']['center']);
                        }//end if
                        $trno = $trno_[0]['trno'];
                        $docno = $trno_[0]['docno'];
                        $data->trno = $trno;


                        $i=2;
                        a:                      
                            if($i>0) {
                                if ($doc =='TW') { //TW KEYWORD
                                    if($openhead=='Taxhead') { $insert = Taxhead::inserthead($docno, $doc, $trno, $data); }
                                } else {
                                    if($openhead=='Lahead'){$insert = Lahead::inserthead($docno, $doc, $trno, $data);
                                    }else{
                                        $insert = Pohead::inserthead($docno, $doc, $trno, $data);
                                    }//endi f
                                }
                                switch($openhead) {
                                    case "Lahead": $headdata = Lahead::openhead($trno, $doc); break;
                                    case "Taxhead": $headdata = Taxhead::openhead($trno, $doc); break;
                                    default: $headdata = Pohead::openhead($trno, $doc); break;
                                }
                            }//end if $i >0
                            



                            if (!empty($headdata)) { //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
                                $head=$webproc->loadheaddata($data, $headdata, $doc);
                                $i=-1;
                            } else {
                                $message = 'Error Saving head please try again!';
                                $i=$i-1;
                                if($i>0) {
                                    goto a;
                                } else {
                                    $tablenum = Common::gettablenum($doc);
                                    $qrydeletecntnum = "delete from ".$tablenum." where trno = ".$trno."";
                                    Yii::$app->sbccommon->execqry($qrydeletecntnum);
                                }//end if if($i>0)
                            }//end if
                            return array('trno' => $trno, 'docno'=> $newdocno,'msg'=>$message,'type'=>'new','head'=>$data);
                    }//END IF ELSE if trno != ""
                } else {
                    $prefix = "/";
                    for ($x = 0; $x < count($prefixes); $x++) {
                        $prefix .= $prefixes[$x] . " / ";
                    }//END FOR EACH
                    $message = 'Invalid prefix , Available prefixes are: ['.$prefix.']';
                    return array('trno' => '', 'docno'=> '','msg'=>$message,'type'=>'');
                }//end if lbnexist
            }//END ELSE ACCESS ACCEPTED
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END SAVINGHEAD FUNCtION


    public function savingstock($controller,$access,$moduledata){
        try {
            if(Yii::$app->session['loggeduser']['access'][$access] != 1) {
                $error = "Not allowed";
                
                Yii::$app->response->format = Response::FORMAT_JSON;                    
                return ['msg'=>$error,'status'=>false];
                //echo json_encode(array('msg'=>$error,'status'=>false));
            } else {
                
                $doc = $controller->module->id;
                $webproc = new Webproc;
                $openstock = $webproc->getstocktype($doc);
                

                switch ($openstock) {
                    case 'Lastock':
                        $dataobj = new Lastock;
                        Yii::$app->backend->normalizeStockdata($doc,$dataobj,$moduledata,$controller);
                    break;
                    default:
                        $dataobj = new Postock;
                        Yii::$app->backend->normalizeStockdata($doc,$dataobj,$moduledata,$controller);
                    break;
                }//end if

                //this will overwrite the rrcost based on RRCOST * KG
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'KINGGEORGE':
                        switch ($doc) {
                            case 'IS': case 'RR': case 'AJ':
                                $kgs = $dataobj->kgs;
                                $rrcost = $dataobj->rrcost;
                                $rrcost = str_replace(',','',$rrcost);
                                $rrcost = $rrcost * str_replace(',','',$kgs);
                                //$rrcost = number_format($rrcost,Yii::$app->systemsettings->setDecimaldisplay('currency'));
                            break;

                            case 'SJ': case 'CM': case 'DM': case 'TS':
                                $kgs = $dataobj->kgs;
                                $isamt = $dataobj->isamt;
                                $isamt = str_replace(',','',$isamt);
                                $isamt = $isamt * str_replace(',','',$kgs);
                                //$isamt = number_format($isamt,Yii::$app->systemsettings->setDecimaldisplay('currency'));
                            break;
                        }//end switch
                    break;
                }//end switch

                switch($doc){
                case 'SJ': case 'SO': case 'MX': case 'MI':
                case 'TS': case 'DM':
                case 'quotation': case 'QT': case 'QA': case 'pscheme': case 'PS':
                        $itemid = Yii::$app->backend->requestItemid($dataobj->barcode);
                        
                        if($itemid == 0){
                            $factor = 1;
                        }else{
                            $uomfactorqry = "select factor from uom where itemid = ".$itemid." and uom='".$dataobj->uom."'";
                            $factor = Yii::$app->sbccommon->datareader($uomfactorqry);
                        }//end if

                        //WILL PASS ORIGINAL ISAMT OR OVERWRITTEN ISAMT depends on the company config
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'KINGGEORGE':
                                $computedata = Yii::$app->backend->computestock($isamt,$dataobj->disc,$dataobj->isqty,$factor,$controller);
                            break;
                            
                            default:
                                $computedata = Yii::$app->backend->computestock($dataobj->isamt,$dataobj->disc,$dataobj->isqty,$factor,$controller);
                            break;
                        }//end switch

                        switch ($doc) {
                            case 'DM':
                                $headtable = Common::localhead($doc);
                                $qryforex = "select forex from ".$headtable." as head where head.trno = " . $dataobj->trno;
                                $forex = Yii::$app->sbccommon->datareader($qryforex);
                                $computedata['amt']=$computedata['amt'] * $forex;
                            break;
                        }//end switch

                        if($doc != 'quotation'){
                            foreach ($computedata as $key => $value) {
                                $val = str_replace(',','',$value);
                                $dataobj->$key = $val;
                            }//end for each
                        }//end if

                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'TENPLUS':
                            if($doc == 'SJ'){
                                $lesshandling = floatval($dataobj->isamt) * floatval($dataobj->itemhandling) * floatval($dataobj->iss); 
                                $lesscomm = 0;
                                //$lesscomm = floatval($dataobj->isamt) * floatval($dataobj->itemcomm) * floatval($dataobj->iss); 
                                $totalless = floatval($lesshandling) + floatval($lesscomm);
                                $dataobj->ext = str_replace(',', '', $dataobj->ext);
                                $dataobj->ext = floatval($dataobj->ext) - floatval($totalless);
                            }//end if
                            break;
                        }//END SWITCH
                break;
                
                case 'PR': case 'PO': case 'RR':
                case 'IS': case 'AJ': case 'PC': case 'TR':
                    $itemid = Yii::$app->backend->requestItemid($dataobj->barcode);
                    $uomfactorqry = "select factor from uom where itemid = ".$itemid." and uom='".$dataobj->uom."'";

                    $factor = Yii::$app->sbccommon->datareader($uomfactorqry);

                    if($doc == 'RR'){
                        $tax_lhead=Common::localhead($doc);
                        $taxqry = "select tax from ".$tax_lhead." where trno = ".$dataobj->trno;
                        $tax = Yii::$app->sbccommon->datareader($taxqry);

                        if(empty($tax)){
                            $tax = 0;
                        }//end if

                        //WILL PASS ORIGINAL RRCOST OR OVERWRITTEN RRCOST depends on the company config
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'KINGGEORGE':
                                $computedata = Yii::$app->backend->computestock($rrcost,$dataobj->disc,$dataobj->rrqty,$factor,$controller,$tax);
                            break;
                            
                            default:
                                $computedata = Yii::$app->backend->computestock($dataobj->rrcost,$dataobj->disc,$dataobj->rrqty,$factor,$controller,$tax);
                            break;
                        }//end switch
                    }else{
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'KINGGEORGE':
                                $computedata = Yii::$app->backend->computestock($rrcost,$dataobj->disc,$dataobj->rrqty,$factor,$controller);
                            break;
                            
                            default:
                                $computedata = Yii::$app->backend->computestock($dataobj->rrcost,$dataobj->disc,$dataobj->rrqty,$factor,$controller);
                            break;
                        }//end switch
                    }//end if


                    switch ($doc) {
                        case 'RR': case 'PO':
                            $headtable = Common::localhead($doc);
                            $qryforex = "select forex from ".$headtable." as head where head.trno = " . $dataobj->trno;
                            $forex = Yii::$app->sbccommon->datareader($qryforex);
                            $computedata['cost']=$computedata['cost'] * $forex;
                        break;
                    }//end switch

                    foreach ($computedata as $key => $value) {
                        $val = str_replace(',','',$value);
                        $dataobj->$key = $val;
                    }//end for each

                break;

                case 'CM':
                    $itemid = Yii::$app->backend->requestItemid($dataobj->barcode);
                    $uomfactorqry = "select factor from uom where itemid = ".$itemid." and uom='".$dataobj->uom."'";

                    $factor = Yii::$app->sbccommon->datareader($uomfactorqry);
                    

                    //WILL PASS ORIGINAL ISAMT OR OVERWRITTEN ISAMT depends on the company config
                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'KINGGEORGE':
                            $computedata = Yii::$app->backend->computestock($isamt,$dataobj->disc,$dataobj->rrqty,$factor,$controller);
                        break;
                        
                        default:
                            $computedata = Yii::$app->backend->computestock($dataobj->isamt,$dataobj->disc,$dataobj->rrqty,$factor,$controller);
                        break;
                    }//end switch

                    foreach ($computedata as $key => $value) {
                        $val = str_replace(',','',$value);
                        $dataobj->$key = $val;
                    }//end for each
                break;
                }//EMD SWITCH


                if($moduledata['line'] == 0) {
                    if ($openstock == 'Lastock') {
                        return Lastock::insertstock($doc, $moduledata['trno'], $dataobj,true);
                    }elseif($openstock=='Postock') {
                        return Postock::insertstock($doc, $moduledata['trno'], $dataobj);  
                    }else{
                        return Qtdetail::insert($moduledata['trno'], $dataobj);
                    }
                } else {
                    if($openstock == 'Lastock') {
                        if ($doc == 'SJ' || $doc == 'SJ2') {
                            return Lastock::updatestocks($doc, $moduledata['line'], $moduledata['trno'], $dataobj);
                        } else {
                            return Lastock::updatestocks($doc, $moduledata['line'], $moduledata['trno'], $dataobj);
                        }//end if
                    } else {
                        return Postock::updatestock($doc, $moduledata['line'], $moduledata['trno'], $dataobj);
                    }//end if
                }//end if
            }
        } catch (ErrorException $e) {
            echo $e;
        }
    }


   function savingdetail($controller,$access,$moduledata) {
        switch ($controller->module->id) {
            case 'SJ2':
                $doc = 'SJ';
            break;
            default:
                $doc = $controller->module->id;
            break;
        }//END SWITCH
        $line = $moduledata['line'];
        $trno = $moduledata['trno'];
        $table = Common::localdetail($doc);
        if ($doc == 'TW'){
            $dataobj = new Taxdetail();
        } else {
            $dataobj = new Ladetail();
        }
        $common = new Common();

        if ($doc == 'TW'){
            $dataobj->acnoname = $moduledata['name'];
            $dataobj->acno = $moduledata['atc'];
            $dataobj->rate = $moduledata['rate'];
            $dataobj->income = $moduledata['income'];
            $dataobj->wheld = $moduledata['wheld'];
            $dataobj->trno = $moduledata['trno'];
        } else {            
            switch ($doc) {
                case 'AP': case 'PV': case 'CV': case 'GJ':
                    if(!empty($moduledata['costcenter'])){
                        $cdetails = explode('~', $moduledata['costcenter']);
                        $dataobj->costcenter = $cdetails[0];
                    }else{
                      $dataobj->costcenter = '';
                    }//end if
                break;

                default:
                    $dataobj->costcenter = '';
                break;
            }//end switch

            switch ($doc) {
                case 'PV':
                    $ewtreturn = Yii::$app->backend->getDefaultEwt($moduledata['trno']);
                    if($moduledata['ewtcode']==''){
                        $dataobj->ewtcode = $ewtreturn[0]['ewt'];
                        $dataobj->ewtrate=$ewtreturn[0]['ewtrate'];
                    }else{
                        $dataobj->ewtcode = $moduledata['ewtcode'];
                        $dataobj->ewtrate = $moduledata['ewtrate']; 
                    }//end switch
                    $dataobj->isewt = $moduledata['isewt'];
                    $dataobj->isvat = $moduledata['isvat'];
                break;
                
                default:
                    $dataobj->isewt = 0;
                    $dataobj->isvat = 0;
                    $dataobj->ewtcode = '';
                    $dataobj->ewtrate = '';
                break;
            }///end switch

            if($moduledata['postdate'] == ""){
                $dataobj->postdate = $moduledata['headdate'];
            }else{
                $dataobj->postdate = $moduledata['postdate'];
            }//end if

            $dataobj->trno = $moduledata['trno'];
            $dataobj->checkno = $moduledata['checkno'];
            $dataobj->acno = $moduledata['acno'];
            $dataobj->acnoname = $moduledata['acnoname'];
            $dataobj->client = $moduledata['client'];
            $dataobj->db = $moduledata['db'];
            $dataobj->cr = $moduledata['cr'];
            $dataobj->refx = $moduledata['refx'];
            $dataobj->linex = $moduledata['linex'];
            $dataobj->rem = $moduledata['rem'];
            $dataobj->ref = $moduledata['ref'];

            $dataobj->db = str_replace(',','',$dataobj->db);
            $dataobj->cr = str_replace(',','',$dataobj->cr);
        }//end if
        if($doc=='CR'){
            $dataobj->pdcline = $moduledata['pdcline'];
        }
        if ($line == 0){ // insert new detail in ladetail
            if ($doc == 'TW'){
                return Taxdetail::insertdetail($trno, $dataobj, $table, $doc);
            } else {
                return Ladetail::insertdetail($trno, $dataobj, $table, $doc);
            }
        }else{
            if ($doc == 'TW'){
                return Taxdetail::updatedetail($trno, $line, $dataobj, $doc);
            } else {
                return Ladetail::updatedetail($trno, $line, $dataobj, $doc);
            }    
        }//END ELSE
    }//END SAVING DETAIL


    public function deleting($controller,$accessdelete,$data){
        switch ($controller->module->id) {
            case 'SJ2': $doc = 'SJ'; break;
            case 'pscheme': $doc = 'PS'; break;

            case 'quotation': $doc = 'QT'; break;
            default: $doc = $controller->module->id; break;
        }//END SWITCH
        $filter = "";
        $webproc = new Webproc; 
        $openhead=$webproc->gettranstype($doc);
        switch ($openhead) {
            case 'Taxhead': $head = new Taxhead(); break;
            case 'Lahead': $head = new Lahead(); break;
            default: $head = new Pohead(); break;
        }
        $trno = $data['trno'];
        if(Yii::$app->session['loggeduser']['access'][$accessdelete] != 1){ // ACCESS DENIED
            $error = "Not allowed";
            return $error;
        } else {
            $docno = Cntnum::getdocno($trno,$doc);
            $common = new Common();
            $action="delete";
            $newtrno=Common::navnext_prev($docno,$trno, $doc, $action);
            
            if($common->delete($doc, $trno)) {
                Log::del_log($doc,$trno,$docno,'TRANSACTION');
                Yii::$app->session['trno'.$doc]=$newtrno;
            }//END IF COMMON DELETE

            if($newtrno == "") { //IF THERE ITEMS ARE NOT AVAILABLE
                $body = "";
                return array('head' => $head, 'body' => $body);
            } else {
                switch($openhead) { //SETS WHERE TO OPEN TABLE
                    case "Lahead": $data = Lahead::openhead($newtrno, $doc); break;
                    case "Taxhead": $data = Taxhead::openhead($newtrno, $doc); break;
                    default: $data = Pohead::openhead($newtrno, $doc); break;
                }//end switch

                switch($doc) {
                    case 'CV': case 'CR': case 'GJ': case 'DS': case 'PV': case 'AP': case 'AR':
                        $body = Ladetail::opendetail($newtrno, $doc);
                    break;
                    case 'KR':
                        $body = Ladetail::openkrdetail($newtrno);
                    break;    
                    case 'TW':
                        $body = Taxdetail::opendetail($newtrno, $doc);
                    break;  
                    case 'RF':
                        $body = '';
                    break;

                    case 'quotation': case 'QT':
                        $body = '';
                    break;
                    default: 
                        if($openhead=='Lahead') { $body = Lastock::openstock($newtrno, $doc,''); }
                        else{ $body = Postock::openstock($doc,$newtrno,$filter); }
                    break;
                }//end switch

                switch($openhead) {
                    case 'Lahead':
                        $grandtotal = Lastock::getgrandtotal($newtrno, $doc);
                        break;
                    //TW KEYWORD    
                    case 'Taxhead':
                        $grandtotal = 0;
                    break;    
                    default:

                        switch($doc){
                            case 'QT': case 'quotation':
                                $grandtotal = 0;
                            break;
                            default:
                                $grandtotal = Postock::getgrandtotal($newtrno, $doc);        
                            break;
                        }//end swtich
                        $grandtotal = Postock::getgrandtotal($newtrno, $doc);
                    break;
                }//end switch

                //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
                if ($data != null) {
                    $head=$webproc->loadheaddata($head, $data, $doc);
                }

                //IF SET GRAND TOTAL AMOUNT TO 0 IF DOESNT HAVE ANY VALUE
                if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
                    $head->grandtotal = 0;
                }else{
                    $head->grandtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                }
                
                //IF SET GRAND TOTAL ITEM COUNT TO 0 IF DOESNT HAVE ANY VALUE               
                if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
                    $head->itemcount = 0;
                }else{
                    $head->itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                }

                //IF SET GRAND TOTAL KILO TO 0 IF DOESNT HAVE ANY VALUE               
                if(isset($grandtotal[0]['kilototal']) && $grandtotal[0]['kilototal'] == null) {
                    $head->totalkilo = 0;
                }else{
                    $head->totalkilo = isset($grandtotal[0]['kilototal']) ? number_format($grandtotal[0]['kilototal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                }

                switch ($doc) {
                    case 'SO': case 'QA':
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                if (isset($grandtotal[0]['totalcbm']) && $grandtotal[0]['totalcbm'] == null) {
                                    $head->totalcbm = 0;
                                }else{
                                    $head->totalcbm = isset($grandtotal[0]['totalcbm']) ? number_format($grandtotal[0]['totalcbm'],
                                        Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                                }

                                if (isset($grandtotal[0]['totaltonnage']) && $grandtotal[0]['totaltonnage'] == null) {
                                    $head->totaltonnage = 0;
                                }else{
                                    $head->totaltonnage = isset($grandtotal[0]['totaltonnage']) ? $grandtotal[0]['totaltonnage'] : 0;
                                }
                            break;
                        }//end swtich
                        break;
                }//END SWTICH CASE

                $common->setview($trno, $doc); //SETS AND UPDATES VIEW BY AND DATE VIEWED
                $head->islocked = Cntnum::islocked($head->trno, $doc);
                $head->isposted = Cntnum::isPosted($head->trno,$doc);
                return array('head' => $head, 'body' => $body);
            }//ELSE IF TRNO = ""
        }//END IF ACCESS IS VALID
    }

    public function locking($controller,$access,$params){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            $error = "Not allowed";
            return $error;
        }else{
            switch ($controller->module->id) {
                case 'SJ2':
                    $doc = 'SJ';
                    break;
                
                default:
                    $doc = $controller->module->id;
                    break;
            }//END SWITCH
            $webproc = new Webproc;
            $trno = $params['trno'];
            $openhead=$webproc->gettranstype($doc);
            //TW KEYWORD
            switch ($openhead) {
                case 'Lahead':
                    Lahead::lock($trno,$doc);
                    break;
                case 'Taxhead':
                    Taxhead::lock($trno,$doc);
                    break;
                default:
                    Pohead::lock($doc,$trno);
                    break;
            }
        
        $islocked = Cntnum::islocked($trno, $doc);
        $isposted = Cntnum::isPosted($trno, $doc);
        $error = "";
        return array('islocked' => $islocked,'isposted'=>$isposted,'error'=>$error);
        }//END ACCESS VALIDATION
    }//END FUNCTION LOCKING

    public function unlocking($controller,$access,$params){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            $error = "Not allowed";
            return $error;
        }else{
            switch ($controller->module->id) {
                case 'SJ2':
                    $doc = 'SJ';
                    break;
                
                default:
                    $doc = $controller->module->id;
                    break;
            }//END SWITCH
            $webproc = new Webproc;
            $trno = $params['trno'];
            $openhead=$webproc->gettranstype($doc);
            if($openhead == "Lahead"){
                Lahead::unlock($trno,$doc);
            }else{
                Pohead::unlock($doc,$trno);
            }//END IF openhead
        $islocked = Cntnum::islocked($trno, $doc);
        $isposted = Cntnum::isPosted($trno, $doc);
        $error = "";
        return array('islocked' => $islocked,'isposted'=>$isposted,'error'=>$error);
        }//END ACCESS VALIDATION
    }


public function computeduedate($doc,$trno){
    $lhead=Common::localhead($doc);
    $head = Yii::$app->sbccommon->opentable("select dateid,terms from ".$lhead." where trno=".$trno);
    if(!empty($head)){
        $date = strtotime("+".intval($head[0]['terms'])." days", strtotime($head[0]['dateid'])); //COMPUTTATION FOR DUE DATE
        Yii::$app->sbccommon->execqry("update ".$lhead." set due='".date("Y-m-d", $date)."' where trno='".$trno."'");
    }
}


   public static function addDayswithdate($date,$days){
        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d", $date);
    }




    public function posting($controller,$access,$params){
         if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //INVALID ACCESS
            $error = "Not allowed";
            return '0';
         }else{
            switch ($controller->module->id) {
                case 'SJ2':
                    $doc = 'SJ';
                break;
                case 'pscheme': $doc = 'PS'; break;

                case 'quotation': 
                    $doc= 'QT';
                break;
                default:
                    $doc = $controller->module->id;
                    break;
            }//END SWITCH

            $webproc = new Webproc;
            $openhead=$webproc->gettranstype($doc);
            $trno = $params['trno'];
            $posting=0;


            if($openhead=='Lahead'){
                        switch ($doc) {
                        case 'PV': case 'CV':  case 'CR': case 'GJ': case 'AR':case 'AP': case 'DS':
                                if(Cntnum::IsbalancedTrans($trno, $doc)) {
                                    $user=Yii::$app->session['loggeduser']['username'];
                                    
                                    $posting = Cntnum::PostTrans($trno,$doc,$user);
                                    
                                    if ($posting != 1) {
                                        //ERROR POSTING
                                        $error = "1.Error Posting..Check the transaction.";
                                    }else{
                                        //CNTNUM POSTING OK!
                                        //$returnvalue =true; //Cntnum::isPosted($trno,$doc);  
                                        $error = "Posted Successfully";                                  
                                    }
                                }else{                                 
                                     $error = "Account not Balanced..Please check the transaction.";
                                }                         
                           break;

                        case 'RR': case 'DM': case 'SJ': case 'CM': case 'AJ': case 'IS': case 'CH': case 'MI': case 'MX': case 'SV': 
                            switch($doc){
                                case 'RR': case 'DM': case 'SO': case 'SJ': case 'SV':
                                  Yii::$app->webprocess->computeduedate($doc,$trno);          
                                  break; 
                            }//end doc

                            //SO DISTRIBUTION WONT HAPPEN EVEN IF DOCUMENT IS VATABLE WITH NO ITEMS
                            //NEED TO DISABLE FOR XANDA (RR TO BE USED ON SUPPLIER INVOICE)
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'MLCP': case 'FHI':
                                    switch ($doc) {
                                        case 'RR':
                                            //NOTHING HAPPENS
                                        break;
                                        
                                        case 'SV':
                                            if(Yii::$app->backend->hasDataRows($trno,'spstock')){
                                                $result = Webproc::autodistribute($controller,$trno);
                                            }//END FUNCTION HAS DATA ROWS
                                        break;

                                        default:
                                            if(Yii::$app->backend->hasDataRows($trno,'lastock')){
                                                $result = Webproc::autodistribute($controller,$trno);
                                            }//END FUNCTION HAS DATA ROWS
                                            break;
                                    }//END SWITCH
                                break;
                                
                                default:
                                    if(Yii::$app->backend->hasDataRows($trno,'lastock')){
                                        $result = Webproc::autodistribute($controller,$trno);
                                    }//END FUNCTION HAS DATA ROWS
                                break;
                            }//end switch case

                            if(Cntnum::checkitemzero($trno,$doc) == 0){ 
                                if(Cntnum::IsbalancedTrans($trno, $doc)){ 
                                    $user=Yii::$app->session['loggeduser']['username'];
                                    $posting = Cntnum::PostTrans($trno,$doc,$user);
                                    if ($posting != 1) {
                                        //ERROR POSTING
                                        $error = "2.Error Posting..Check the transaction.";
                                    }else{
                                        //CNTNUM POSTING OK!
                                        //$returnvalue =true; //Cntnum::isPosted($trno,$doc);  
                                        $error = "Posted Successfully";                                  
                                    }//end
                                }else{                                 
                                     $error = "Account not Balanced..Please check the transaction.";
                                     Ladetail::deletedetail($doc, $trno);
                                }
                            }else{
                                $error = "Some item have zero qty , Please retype the quantity of each item...";                      
                            }  
                        break;

                        default:{

                            if(Cntnum::checkitemzero($trno,$doc)==0){ 
                                $user=Yii::$app->session['loggeduser']['username'];
                                $posting = Cntnum::PostTrans($trno,$doc,$user);                        
                                if ($posting != 1) {
                                    //ERROR POSTING
                                    $error = "3.Error Posting..Check the transaction.";
                                }else{
                                    //CNTNUM POSTING OK! ORAYYT!                                
                                    $error = "Posted Successfully";
                                }
                            }else{
                                 $error = "Some item have zero qty,Pls retype the quantity of each item...";                      
                            }  
                            break;
                        }//end default
                    }//END SWITCH
            }else{

                //TW KEYWORD
                    if ($doc == 'TW'){
                        $user=Yii::$app->session['loggeduser']['username'];
                        $posting = Taxnum::PostTrans($trno,$doc,$user);                      
                        if ($posting != 1) {
                            //ERROR POSTING
                            $error = "4.Error Posting..Check the transaction.";
                        }else{
                            $error="Posted Successfully";
                        }
                    } else {
                        $user=Yii::$app->session['loggeduser']['username'];
                        $posting = Transnum::PostTrans($trno,$doc,$user);
                        if ($posting != 1) {
                            //ERROR POSTING
                            $error = "4.Error Posting..Check the transaction.";
                        }else{
                            //THIS CODE BLOCK IS USED TO UPDATE SOHEAD IF APPROVED OR NOT
                            switch ($doc) {
                                case 'SO': case 'QA':
                                    switch (Yii::$app->systemsettings->companyConfig()) {
                                        case 'SOUTHCENTRAL':                
                                        //CHECKS IF SO IS APPROVED OR NOT
                                        Yii::$app->backend->isApproved($doc,$trno);
                                        break;
                                    }//end switch
                                    $error="Posted Successfully";
                                break;
                                
                                case 'JB':
                                    //GETS FIRST ITEM ON JO STOCK (FG)
                                    $qrygetfirst = "select barcode from hjbstock where trno = ".$trno." order by line asc limit 1";
                                    $mat_barcode = Yii::$app->sbccommon->datareader($qrygetfirst);                                   

                                    //UPDATES JOHEADER WITH SET MAT BARCODE
                                    $qryupdatemat = "update hjbhead set mat_barcode = '".$mat_barcode."' where trno =" . $trno;
                                    Yii::$app->sbccommon->execqry($qryupdatemat);

                                    //UPDATES ALL PROCESS TABS WITH BARCODE SET IN HEADER
                                    $qryupdateprocesstab = "update jb_processtab set barcode = '".$mat_barcode."' where trno =" . $trno;
                                    Yii::$app->sbccommon->execqry($qryupdateprocesstab);

                                    //GETS COLOR LISTED ON FG (MAT_BARCODE)
                                    $qrygetcolors = "select c.code,c.name as color from fgi_colors
                                                    left join item on item.itemid = fgi_colors.itemid
                                                    left join fg_colors as c on c.id = fgi_colors.color
                                                    where item.barcode = '".$mat_barcode."'";

                                    $availcolors = Yii::$app->sbccommon->opentable($qrygetcolors);

                                    $lastline = 1;
                                    foreach ($availcolors as $key => $value) {
                                        $qryinsert = "insert into jbu_processinktab (line,colorcode,color,wt,returned,trno,transline,barcode)
                                                     values (".$lastline.",'".$value['code']."','".$value['color']."',0,0,".$trno.",1,'".$mat_barcode."')";

                                        Yii::$app->sbccommon->execqry($qryinsert);
                                        $lastline += 1;
                                    }//end for each                   

                                    $error="Posted Successfully";
                                break;

                                default:
                                    $error="Posted Successfully";
                                break;
                            }//END SWITCH
                        }//END IF ELSE  
                    }//END IF $DOC TW

            }//END IF LAHEAD
                    $islocked = Cntnum::islocked($trno, $doc);
                    $isposted = Cntnum::isPosted($trno, $doc);

                    switch (Yii::$app->systemsettings->companyConfig()) {
                        case 'SOUTHCENTRAL':
                                switch ($doc) {
                                    case 'SO': case 'QA':
                                        $isapproved = Yii::$app->backend->checkApprovalStatus($trno);
                                        return array('islocked' => $islocked,'isposted'=>$isposted,'isapproved'=>$isapproved,'error'=>$error,'status'=>$posting);
                                    break;
                                    
                                    default:
                                        return array('islocked' => $islocked,'isposted'=>$isposted,'error'=>$error,'status'=>$posting);
                                    break;
                                }//END SWITCH
                            break;
                        
                        default:
                            return array('islocked' => $islocked,'isposted'=>$isposted,'error'=>$error,'status'=>$posting);
                        break;
                    }//END SWTICH

         }//END ACCESS VALIDATION
    }//END POSTING


    //USED FOR UNPOSTING PROCESS
    public function unposting($controller,$access,$params){
        switch ($controller->module->id) {
            case 'SJ2':
                $doc = 'SJ';
                break;
            case 'pscheme':
                $doc = 'PS';
            break;
            default:
                $doc = $controller->module->id;
                break;
        }//END SWITCH
        $error = "";
        if(Yii::$app->session['loggeduser']['access'][$access] != 1){
            //INVALID ACCESS
            $error = "Not allowed";
            return 0;
         }else{

            $trno = $params['trno'];
            $webproc = new Webproc;
            $openhead = $webproc->gettranstype($doc);
            if($openhead=='Lahead'){
                $user=Yii::$app->session['loggeduser']['username'];
                $unposting = Cntnum::UnpostTrans($trno, $doc,$user);
            }else{
                switch ($doc) {
                    case 'PD':
                        $qry = "select prc from hpdhead where trno = ".$trno." limit 1";
                        $prc = Yii::$app->sbccommon->datareader($qry);
                        if($prc != ""){
                            $error = "Transaction already served in a PRC. Check Transaction";
                            $unposting = 0;   
                        }else{
                            $user=Yii::$app->session['loggeduser']['username'];
                            $unposting = Transnum::UnpostTrans($trno, $doc,$user);    
                        }
                        break;
                    
                    //TW KEYWORD
                        case 'TW':
                        $user=Yii::$app->session['loggeduser']['username'];
                        $unposting = Taxnum::UnpostTrans($trno, $doc,$user);
                        break;

                    default:
                        $user=Yii::$app->session['loggeduser']['username'];
                        $unposting = Transnum::UnpostTrans($trno, $doc,$user);
                        break;
                }//END SWITCH CASE
            }//end if lahead

            if ($unposting != 1) {
                if($error == ""){
                    $error = $unposting;   
                }//end if
            }else{
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'SOUTHCENTRAL':
                        if($doc == "TS"){
                            $qryupdate = "update cntnum set isok = 0 where trno = ".$trno."";
                            Yii::$app->sbccommon->execqry($qryupdate);
                        }//END IF
                    break;

                    case 'MLCP':
                        if($doc == "JB"){
                            $qryupdateprocesstab = "update jb_processtab set barcode = '' where trno =" . $trno;
                            Yii::$app->sbccommon->execqry($qryupdateprocesstab);

                            $qryremoveink = "delete from jbu_processinktab where trno =" . $trno;
                            Yii::$app->sbccommon->execqry($qryremoveink);
                        }//end if
                    break;
                }//end switch
                


                $error= "Unposted Successfully!!!";
            }

            $isposted = Cntnum::isPosted($trno,$doc);
            $islocked = Cntnum::islocked($trno,$doc);

            return array('status'=>$unposting,'islocked' => $islocked,'isposted'=>$isposted,'error'=>$error);
            
         }//END VALIDATION ACCESS
    }//end function unposting




    //THIS IS USED WHEN SEARCHING DOCNO FROM THE DOCNO TEXTBOX
    public function searching($controller,$accessparams,$action,$params){
        
        $webproc = new Webproc; 
        switch ($controller->module->id) {
            case 'SJ2':
                $doc = 'SJ';
                break;
            case 'pscheme':
                $doc = 'PS';
            break;                

            case 'quotation':
                $doc = 'QT';
            break;
            default:
                $doc = $controller->module->id;
            break;
        }//END SWITCH
        $openhead=$webproc->gettranstype($doc);

        //TW KEYWORD
        switch ($openhead) {
            case 'Taxhead':
                $head = new Taxhead();
                break;
            case 'Lahead':
                $head = new Lahead();
                break;    
            
            default:
                 $head = new Pohead();
                break;
        }

        $common = new Common();
        $queryString = "";
        $docnolength = $common->doclength();
        $prefixes = $common->getPrefixes($doc);//GETS ALL PREFIXES FOR THIS DOC
        $blnExist = false;
        

        if (isset($params['docno'])) {
            $queryString = $params['docno'];
        }

        $pref = $common->GetPrefix($queryString);
        $seq = substr($queryString, $common->SearchPosition($queryString), strlen($queryString));

        if($seq == 0 || empty($pref)) {
            if (empty($pref)) {
                $pref = strtoupper($queryString);
            }
            $seq = $common->getlastseq($pref,$doc,Yii::$app->session['loggeduser']['center']);
        }

        if(!empty($prefixes)){
            for ($i = 0; $i < count($prefixes); $i++) {
            if ($pref == $prefixes[$i]) {
                $blnExist = true;
                }//END COMPARE
            }//END FOR LOOP
        }//END IF ELSE
        

        if($blnExist){  //STATEMENT WHEN blnExsist is TRUE [MEANS PREFIX TYPED BY USER IS VALID]
            $poseq = $pref . $seq; //CREATES A VALID DOCNO BUT WITHOUT THE NATIVE LENGTH
            $newdocno = $common->PadJ($poseq, $docnolength); //CREATES A MORE VALID DOCNO BASED ON THE SYSTEM 
            $trno = $common->gettrno($newdocno,$doc); // GETS THE TRNO OF THE DOCNO IT COULD RETURN NULL / "" OR A VALID TRNO
            $head->docno = $newdocno;

            if($trno == ""){
                //THIS IS WHEN DOCNO IS NOT VALID , IT WOULD CREATE A NEW TRANSACTION
                if(Yii::$app->session['loggeduser']['access'][$accessparams['new']] != 1){
                    //SHOW ACCESS DENIED MESSAGE
                        $error = "Document does not exist. Creation of new document not allowed.";
                        return array('head' => [], 'body' => [],'error_msg'=>$error);
                    }else{ //END IF ACCESS DENIED
                    //THIS IS FOR CREATING NEW DOCNO TRANSACTION IF TRNO IS NOT FOUND
                        $head->docno = $newdocno;
                        $head->dateid = date("Y-m-d");
                        $head->forex = 1.00;

                        switch ($doc) {
                            case 'SP':
                                $head->effectivedate = date("Y-m-d");
                            break;
                        }//end switch
                        
                        switch($doc) {
                            case'RR':case'DM':case'CA': {
                                    $contra='AP1';
                                    break;
                                }
                             case'CM':case'AR':case'AP': {
                                    $contra='AR1';
                                    break;
                                }
                            case 'SJ': case 'CH':{
                                switch (Yii::$app->systemsettings->companyConfig()) {
                                    case 'INFINITEA':
                                        $contra='CA1';
                                        $salestype='CASH';
                                        $head->salestype = $salestype;
                                    break;

                                    default:
                                        $contra='AR1';
                                        $salestype='CHARGE';
                                        $head->salestype = $salestype;
                                    break;
                                }//end switch case                            
                                break;
                             }//END CASE SJ
                            case 'AJ':case 'IS': case 'MI': case 'PK': case 'MX':{
                                    $contra='IS1';
                                    break;
                                }
                            case 'PV': {
                                    $contra='AP2';
                                    break;
                                }
                            case 'CV':case 'DS': {
                                $contra='CB1';
                                break;
                            }
                            case 'CR': {
                                    $contra='CR1';
                                    break;
                                }
                            default: {
                                    $contra='';
                                    break;
                                }
                        }
                        
                        if($openhead=='Lahead'){
                        if($doc != 'DS'){
                            $head->contra = Ladetail::getacno($contra) . '~' . Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
                        }else{
                            $head->contra = Ladetail::getacno($contra);
                        }


                        if($doc == "DS"){
                            $head->clientname = Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
                        }
                        
                        $head->tax = 0;
                        // $defaultwh=Common::defaultwarehouse();
                        $head->wh = Yii::$app->session['loggeduser']['whname'];
                        $head->whid =Yii::$app->session['loggeduser']['whcode'];

                        if($doc=='AJ' || $doc=='IS' ||$doc=='MX'|| $doc == 'MI' || $doc == 'PK') {
                            $head->client=Yii::$app->session['loggeduser']['whcode'];                      
                            $head->clientname=Yii::$app->session['loggeduser']['whname'];
                        }
                          if($doc=='TS') {
                            $head->whid = Yii::$app->session['loggeduser']['whcode'];
                            $head->wh = Yii::$app->session['loggeduser']['whname'];
                          }else if($doc=='PU') {
                            $head->whid = Yii::$app->session['loggeduser']['whcode'];
                            $head->wh = Yii::$app->session['loggeduser']['whname'];
                          }
                        }else{

                            // SALON MODIFICATION
                            if($doc=='TR') {
                            $head->client=Yii::$app->session['loggeduser']['whcode'];                      
                            $head->clientname=Yii::$app->session['loggeduser']['whname'];
                            }
                            // END SALON

                            $head->wh = Yii::$app->session['loggeduser']['whname'];
                            $head->whid =Yii::$app->session['loggeduser']['whcode'];
                        }//END IF OPENHEAD LAHEAD
                    
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'UNIVERSE':
                                switch ($doc) {
                                    case 'SO': case 'SJ': case 'CM':
                                        $head->whid = 'PC0000000000002';
                                        $head->wh = Yii::$app->sbccommon->datareader('select clientname from client where client = "'.$head->whid.'"');
                                    break;

                                    case 'TS':
                                        $head->whid = 'PC0000000000001';
                                        $head->wh = Yii::$app->sbccommon->datareader('select clientname from client where client = "'.$head->whid.'"');
                                        $head->client = 'PC0000000000002';
                                        $head->clientname = Yii::$app->sbccommon->datareader('select clientname from client where client = "'.$head->client.'"');
                                    break;
                                    
                                    default:
                                        $head->whid = Yii::$app->session['loggeduser']['whcode'];
                                        $head->wh = Yii::$app->session['loggeduser']['whname'];
                                    break;
                                }//end switch
                            break;
                            
                            default:
                                $head->whid = Yii::$app->session['loggeduser']['whcode'];
                                $head->wh = Yii::$app->session['loggeduser']['whname'];
                            break;
                        }//end switch

                        //TW KEYWORD
                        $body = "";
                        if ($doc == 'TW'){
                        $head->islocked = Taxnum::islocked($trno, $doc);
                        $head->isposted = Taxnum::isPosted($trno,$doc);    
                        } else {
                        $head->islocked = Cntnum::islocked($trno, $doc);
                        $head->isposted = Cntnum::isPosted($trno,$doc);
                        }
                        
                        if($doc == "RR" || $doc == "PO" || $doc == "DM"){
                            $head->cur= "P";
                        }

                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'UNIVERSE':
                                //THIS CODE BLOCK IS FOR VAT TYPE
                                if($doc == "SJ" || $doc == "RR"){
                                    if($doc == 'SJ'){ // FOR SJ VAT TYPE
                                        switch ($pref) {
                                            case 'SI': case 'CI': case 'CS':
                                                $head->vattype = '';
                                                $head->tax = 0;
                                                break;
                                            
                                            default:
                                                $head->vattype = '';
                                                $head->tax = 0;
                                                break;
                                        }//end switch case
                                    }else{ //FOR RR VAT TYPE
                                        switch ($pref) {
                                            default:
                                                $head->vattype = 'NON-VATABLE';
                                                $head->tax = 0;
                                                break;
                                        }//end switch case
                                    }//end if else
                                }//END IF sj
                            break;

                            default:
                                //THIS CODE BLOCK IS FOR VAT TYPE
                                if($doc == "SJ" || $doc == "RR"){
                                    if($doc == 'SJ'){ // FOR SJ VAT TYPE
                                        switch ($pref) {
                                            case 'SI': case 'CI': case 'CS':
                                                $head->vattype = 'VATABLE';
                                                $head->tax = 12;
                                                break;
                                            
                                            default:
                                                $head->vattype = 'NON-VATABLE';
                                                $head->tax = 0;
                                                break;
                                        }//end switch case
                                    }else{ //FOR RR VAT TYPE
                                        switch ($pref) {
                                            default:
                                                $head->vattype = 'NON-VATABLE';
                                                $head->tax = 0;
                                                break;
                                        }//end switch case
                                    }//end if else
                                }//END IF sj
                            break;
                        }//end switch

                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'UNIVERSE':
                                switch ($doc) {
                                    case 'SO': case 'SJ': case 'CM':
                                        $clen = $common->clientlength();
                                        $searchclient = $common->PadJ(Yii::$app->session['loggeduser']['username'], $clen);   
                                        $qry_checker = "select client,clientname from client where client = '".$searchclient."'";
                                        $data = Yii::$app->sbccommon->opentable($qry_checker);

                                        if(!empty($data)){
                                            $head->agentcode = $data[0]['client'] . '~'.$data[0]['clientname'];
                                        }else{
                                            $head->agentcode = '';
                                        }//end if
                                    break;
                                }//END SWITCH
                            break;
                        }//end switch

                        return array('head' => $head, 'body' => $body,'error_msg'=>'');
                    }//END DOCNO CREATION
            }else{

                //THIS CASE WHEN IS USED TO GET DATA FROM DATABASE WHEN TRNO IS AVAILABLE , RETURNS VALUE IF TRNO IS VALID
                switch($openhead) { 
                //TW KEYWORD    
                    case "Lahead": $data = Lahead::openhead($trno, $doc); break;
                    case "Taxhead": $data = Taxhead::openhead($trno, $doc); break;
                    default: $data = Pohead::openhead($trno, $doc); break; 
                }//end switch

                $filter = "";   
         
                //CHOOSES WHAT TO OPEN [BY TYPE OF DOC]
                switch($doc) {
                case 'CV': case 'CR': case 'GJ': case 'DS': case 'PV': case 'AP': case 'AR':
                    $body = Ladetail::opendetail($trno, $doc);
                    break;
                 //TW KEYWORD    
                case 'TW':
                    $body = Taxdetail::opendetail($trno, $doc); 
                    break;
                case 'KR':
                    $body = Yii::$app->backend->retrieveKRreceivables($trno);
                    break;
                
                case 'RF': case 'TX':
                    $body = "";
                break;


                case 'QT':
                    $body = "";
                break;

                default: 
                    if($openhead=='Lahead'){$body = Lastock::openstock($trno, $doc,'');}
                    else{$body = Postock::openstock($doc,$trno,$filter);}
                break;
            }//end switch


            if($data != null){$webproc->loadheaddata($head, $data, $doc);} //IF DATA IS NOT NULL
            switch($openhead) {
                case 'Lahead':
                    $grandtotal = Lastock::getgrandtotal($trno, $doc);
                    break;
                //TW KEYWORD    
                case 'Taxhead':
                    $grandtotal = 0;
                    break;    
                default:
                    $grandtotal = Postock::getgrandtotal($trno, $doc);
                    break;
            }

            
            switch ($doc) {
                    case 'CR': case 'CV': case 'AR': case 'AP': case 'PV': case 'GJ': case 'DS': case 'TW':
                        $gettotal = Ladetail::getgrandtotal($trno,$doc);
                        if(isset($gettotal[0]['totaldb']) || isset($gettotal[0]['totalcr'])){
                            $runningdb = $gettotal[0]['totaldb'];
                            $runningcr = $gettotal[0]['totalcr'];
                        }else{
                            $runningdb = "0.00";
                            $runningcr = "0.00";
                        }
                            $head->totaldb = $runningdb;
                            $head->totalcr = $runningcr;
                        break;
                    
                    default:
                        switch($openhead) {
                            case 'Lahead':
                                $grandtotal = Lastock::getgrandtotal($trno, $doc);
                                break;
                            default:

                                switch($doc){
                                    case 'QT':
                                        $grandtotal = 0;
                                    break;
                                    default:
                                        $grandtotal = Postock::getgrandtotal($trno, $doc);    
                                    break;
                                }//end switch
                            break;
                        }//end switch

                        //IF SET GRAND TOTAL AMOUNT TO 0 IF DOESNT HAVE ANY VALUE
                        if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
                            $head->grandtotal = 0;
                        }else{
                            $head->grandtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                        }
                        //IF SET GRAND TOTAL ITEM COUNT TO 0 IF DOESNT HAVE ANY VALUE               
                        if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
                            $head->itemcount = 0;
                        }else{
                            $head->itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                        }

                        //IF SET GRAND TOTAL KILO TO 0 IF DOESNT HAVE ANY VALUE               
                        if(isset($grandtotal[0]['kilototal']) && $grandtotal[0]['kilototal'] == null) {
                            $head->totalkilo = 0;
                        }else{
                            $head->totalkilo = isset($grandtotal[0]['kilototal']) ? number_format($grandtotal[0]['kilototal'],Yii::$app->systemsettings->setDecimaldisplay('quantity')) : 0;
                        }

                        switch ($doc) {
                            case 'SO': case 'SJ': case 'QA':
                                switch (Yii::$app->systemsettings->companyConfig()) {
                                    case 'SOUTHCENTRAL':
                                        if (isset($grandtotal[0]['totalcbm']) && $grandtotal[0]['totalcbm'] == null) {
                                            $head->totalcbm = 0;
                                        }else{
                                            $head->totalcbm = isset($grandtotal[0]['totalcbm']) ? number_format($grandtotal[0]['totalcbm'],
                                                Yii::$app->systemsettings->setDecimaldisplay('currency')) : 0;
                                        }

                                        if (isset($grandtotal[0]['totaltonnage']) && $grandtotal[0]['totaltonnage'] == null) {
                                            $head->totaltonnage = 0;
                                        }else{
                                            $head->totaltonnage = isset($grandtotal[0]['totaltonnage']) ? $grandtotal[0]['totaltonnage'] : 0;
                                        }
                                break;
                                }//end swtich
                            break;
                            
                        }//END SWTICH CASE
                                
                        break;
                }//END SWITCH DOC

            $common->setview($trno, $doc);

                //THIS IS WHEN VALID DOCNO IS AVAILBLE AND SYSTEM GOT ITS TRNO
                if(Yii::$app->session['loggeduser']['access'][$accessparams['view']] != 1){
                    //SHOW ACCESS DENIED MESSAGE
                        $error = "Viewing not allowed";
                        return array('head' => [], 'body' => [],'error_msg'=>$error);
                    }else{//END IF ACCESS DENIED
                    //THIS IS FOR CREATING NEW DOCNO TRANSACTION IF TRNO IS NOT FOUND
                        //TW KEYWORD
                        if ($doc == 'TW'){
                        $head->islocked = Taxnum::islocked($trno, $doc);
                        $head->isposted = Taxnum::isPosted($trno,$doc);    
                        } else {
                        $head->islocked = Cntnum::islocked($trno, $doc);
                        $head->isposted = Cntnum::isPosted($trno,$doc);
                        }
                        return array('head' => $head, 'body' => $body,'error_msg'=>'');
                }//END DOCNO VIEWING
            }//END $trno == ""
        }else{
        //WHEN USER TYPED PREFIX IS NOT VALID
            $prefix = "/";
            for ($x = 0; $x < count($prefixes); $x++){
                $prefix .= $prefixes[$x] . " / ";
            }
            return array('error_msg'=>'Invalid prefix , Available prefixes are: ['.$prefix.']');
        }//END IF BLNEXIXST

    }//END SEARCHING


    public function deletestock($controller,$access,$params){
        if(Yii::$app->session['loggeduser']['access'][$access] != 1) { // INVALID ACCESS
            $error = "Not allowed";
            return $error;
        } else {
            switch ($controller->module->id) {
                case 'SJ2': $doc = 'SJ'; break;
                default: $doc = $controller->module->id; break;
            }//END SWITCH
            $trno = $params['trno'];
            $line = $params['line'];
            $webproc = new Webproc;

            switch ($doc) {
                case 'TW': $detail = new Taxdetail; break;
                default: $detail = new Ladetail; break;
            }//TW KEYWORD

            $openstock=$webproc->getstocktype($doc); //GETS TABLENAME FOR LOCA
            switch ($doc) {
                case 'GJ': case 'CR': case 'DS': case 'PV': case 'CV': case 'AR': case 'AP':
                    $data = Ladetail::opendetailline($trno, $line,$doc);
                    $returnvalues = Ladetail::deletedetail_($doc, $trno, $line);
                    
                    if($data[0]['refx']!=0) {
                        if(Apledger::updatebal($data[0]['refx'], $data[0]['linex'], $data[0]['acno'], $doc,1)==1){}
                    }
                
                    if ($doc=='CR' && $data[0]['pdcline']!=0) {
                        $pdcline = $data[0]['pdcline'];
                        Yii::$app->sbccommon->execqry("update hpostdatedchecks set refx=0,linex=0 where line = $pdcline");
                    }

                    return $returnvalues;
                break;

                case 'TW':
                    $returnvlaues = Taxdetail::deletedetail_($doc, $trno, $line);
                    return $returnvalues;
                break;
                
                case 'KR':
                    return $status = Yii::$app->backend->setKRref($params,0,'DELETEENTRY');
                break;
                
                default:
                    if($openstock == "Postock") {
                        $model = new Postock;
                        
                        switch ($doc) {

                            case 'tpshipping': case 'tphandling':
                                $model->deletestock($doc,$trno, $line);
                            break;
                            
                            default:
                                $model->deletestock($doc,$trno, $line);
                                return $model->getgrandtotal($trno,$doc);
                            break;
                        }//end switch
                    } else {
                        $model = new Lastock;
                        $model->deletestocks($doc,$trno, $line);
                        return $model->getgrandtotal($trno,$doc);
                    }//END OPENSTOCK
                break;
            }//end case when

        }//END ACCESS VALIDATION
    }//END DELETESTOCK

    public function showlogs($controller,$params){
       
        $model = new Log();
        switch ($controller->module->id) {
            case 'SJ2':
                $doc = 'SJ';
                break;
            
            default:
                $doc = $controller->module->id;
                break;
        }//END SWITCH
        $trno = $params['trno'];

        switch($doc){      

            default:
            $data = $model->getlogs($doc, $trno);
            break;
        }

        return $data;
    }//END SHOWLOGS




public function adjustitem($trno){
        //GETS QUERY STOCK FROM Physic Count
        $qry="select head.docno,head.dateid,head.yourref,stock.line,stock.barcode,stock.itemname,stock.uom,stock.loc,
        stock.wh,stock.rrcost,stock.cost,stock.rrqty,stock.qty,stock.expiry 
        from hpchead as head 
        left join hpcstock as stock on stock.trno=head.trno where stock.trno=".$trno;
        $models=Yii::$app->sbccommon->opentable($qry); //USE GENERIC OPEN TABLE

        //passes data to variables
        $wh = $models[0]['wh'];
        $dateid = $models[0]['dateid'];
        $pcdocno = $models[0]['docno'];
        $yourref = $models[0]['yourref'];

        switch (Yii::$app->systemsettings->resellerConfig()) {
            case 'JOYCEBU':
                $alias = "CG1";
                break;
            
            default:
                $alias = "IS1";
                break;
        }//end swutch

        //GETS ACCOUNT ENTRY , WAREHOUSE NAME , AND CENTER USING query
        $contra = Yii::$app->sbccommon->datareader("select acno from coa where alias='".$alias."' limit 1"); //USE GENERIC OPEN TABLE
        $whname = Yii::$app->sbccommon->datareader("select clientname from client where client='".$wh."'");  //USE GENERIC OPEN TABLE
        $center = Yii::$app->session['loggeduser']['center'];

        $common = new Common(); 
        $docnolength = $common->doclength();
        $insertcntnum=0;

           while ($insertcntnum == 0) {
                $pref ='AJ';             
                $seq = $common->getlastseq($pref,'AJ',$center);
                if($seq==''){
                    $seq=1;
                }
               $poseq = $pref . $seq;
               $newdocno = $common->PadJ($poseq, $docnolength);

               if(strlen($yourref)!=0){
                   $ajtrno = Yii::$app->sbccommon->datareader("select ifnull(trno,0) as trno from cntnum where docno='".$yourref."' and center='".$center."'"); 
                   $newdocno=$yourref;
                   if($ajtrno==0){
                    $insertcntnum =$common->insertcntnum('AJ', $yourref, $seq, 'AJ',$center);
                   }else{$insertcntnum=1;}
               }else{
                   $insertcntnum =$common->insertcntnum('AJ', $newdocno, $seq, 'AJ',$center);
                 }
            }

            $trno_ = Cntnum::getTrnodocno($newdocno,'AJ',$center);
            $ajtrno = $trno_[0]['trno'];
            $docno = $trno_[0]['docno'];
          
            $user= Yii::$app->session['loggeduser']['username'];

             Yii::$app->sbccommon->execqry("update hpchead set yourref='".$newdocno."' where trno=".$trno);
             Yii::$app->sbccommon->execqry("delete from lahead where trno=".$ajtrno);
             Yii::$app->sbccommon->execqry("delete from lastock where trno=".$ajtrno);
             Yii::$app->sbccommon->execqry("delete from costing where trno=".$ajtrno);
             Yii::$app->sbccommon->execqry("insert into lahead (docno, doc, client, clientname, address, yourref, ourref,
                                            forex, dateid, rem, shipto, terms,trno,createby,contra,tax,wh,agent)
                                            values('".$docno."','AJ', '".$wh."', '".$whname."','', '".$pcdocno."', '',
                                            '0', '".$dateid."', '','', '', '".$ajtrno."','".$user."','\\$contra','0','$wh','')");
            
            
            Log::writelog('AJ', $ajtrno, 'CREATE', $docno.' WAREHOUSE - '.$wh,$user);
               $b=1;
               if(!empty($models)){

                foreach($models as $model){
                   $bal=  Item::getbalbydate($model['barcode'], $model['wh'],$model['loc'], $model['dateid']);
                   $onhand = Item::getcurrentbal($model['barcode'], $model['wh'],$model['loc']);
                   $factor = Item::getitemuom($model['barcode'], $model['uom']);
                   $curbal = $model['qty']-$bal;
                   $barcode=$model['barcode'];
                   $itemname=$model['itemname'];
                   $loc = $model['loc'];
                   $uom=$model['uom'];
                   $rrcost=$model['rrcost'];
                   $expiry=$model['expiry'];
                   $cost=$model['cost'];
                   
                   $line=$model['line'];
                   if($curbal == 0){
                    $ext = 0;
                    $displaycurbal=0;
                   }else{
                    $ext = $rrcost*$curbal;
                    $displaycurbal=$curbal/$factor;
                   }
                       /*
                       echo $bal . '<br>';
                       echo $onhand . '<br>';
                       echo $curbal . '<br>';

                       return 0;*/

                   if($curbal>0){
                        Yii::$app->sbccommon->execqry("insert into lastock(trno,line,barcode,itemname,uom,rrcost,cost,rrqty,qty,ext,wh,loc,encodedby,expiry)  
                            values('$ajtrno','$b','$barcode','$itemname','$uom','$rrcost',
                            '$cost',$displaycurbal,$curbal,$ext,'$wh','$loc','$user','$expiry')");
                        $b++;
                   }elseif($curbal<0){
                        if($onhand>=$bal){
                              Yii::$app->sbccommon->execqry("insert into lastock(trno,line,barcode,itemname,uom,rrcost,cost,rrqty,iss,ext,wh,loc,encodedby,expiry)  
                                    values('$ajtrno','$b','$barcode','$itemname','$uom','$rrcost',
                                    '$cost',$displaycurbal,abs($curbal),$ext,'$wh','$loc','$user','$expiry')");
   
                              $curcost= Lastock::computecosting($barcode, $wh,$loc,$expiry,$ajtrno,$b,abs($curbal), 'AJ');
                              if($curcost!=-1){
                                 Yii::$app->sbccommon->execqry("update lastock set cost=$curcost where trno=$ajtrno and line=$b");
                              }else{ Yii::$app->sbccommon->execqry("update lastock set rrqty=0,iss=0,ext=0 where trno=$ajtrno and line=$b");}
                              $b++;
                              
                              $y=Yii::$app->sbccommon->execqry("update hpcstock set rem='' where trno=$trno and line=$line");    
                        }elseif(floatval(floatval($model['qty']) - floatval((floatval($bal) - floatval($onhand)))) > 0){
                              
                              $newbalance = floatval($model['qty']) - floatval($bal);
                              if($newbalance < 0){
                                  $ext = $ext * -1;
                                  Yii::$app->sbccommon->execqry("insert into lastock(trno,line,barcode,itemname,uom,rrcost,cost,rrqty,iss,ext,wh,loc,encodedby,expiry)  
                                    values('$ajtrno','$b','$barcode','$itemname','$uom','$rrcost',
                                    '$cost',$newbalance,abs($newbalance),$ext,'$wh','$loc','$user','$expiry')");

                                  $curcost= Lastock::computecosting($barcode, $wh,$loc,$expiry,$ajtrno,$b,abs($newbalance), 'AJ');
                                  
                                  if($curcost!=-1){
                                     Yii::$app->sbccommon->execqry("update lastock set cost=$curcost where trno=$ajtrno and line=$b");
                                  }else{ 
                                    Yii::$app->sbccommon->execqry("update lastock set rrqty=0,iss=0,ext=0 where trno=$ajtrno and line=$b");
                                  }
                                $b++;
                                  
                                  $y=Yii::$app->sbccommon->execqry("update hpcstock set rem='' where trno=$trno and line=$line");    
                              }//end newbalance < 0
                        }else{
                            $rem="Cannot be adjusted.";
                            $y=Yii::$app->sbccommon->execqry("update hpcstock set rem='$rem' where trno=$trno and line=$line");    
                        }//end onhand >= bal
                   }//end if
                   
            } //foreach($models as $model) 
            }//if(!empty($models))

            Yii::$app->session['warning'] = Yii::$app->session['warning']." Adjustment# : " .$newdocno;
            return $newdocno;
            
    }

}//END COMPONENTS
?>