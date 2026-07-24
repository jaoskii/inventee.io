<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Lahead;

date_default_timezone_set('Asia/Singapore');
class Webproc {



    function gettranstype($doc) {
        switch ($doc) {
            case 'SP': case 'QA' : case 'PI': case 'PD': case 'SO': case 'PO': 
            case 'PC': case 'KR': case 'EX': case 'PR': 
            case 'QT': case 'RF': case 'TX': case 'TR': case 'JB':
            case 'pscheme': case 'PS': case 'quotation': case 'QT':
              $openhead='Pohead';
            break;
            case'TW':
              $openhead='Taxhead';
            break;
            default:
              $openhead='Lahead';
            break;
        }
        return $openhead;
    }

        function getstocktype($doc){
            switch ($doc){
                case 'QA': case'SP': case'PI': case'PD': case'JO': case'SO': case'PO': case'PC': case'EX': 
                case'PR': case 'TR': case'QT': case'tpshipping': case 'JB':
                case'pscheme': case 'PS': case 'quotation': case 'tphandling': { 
                  $openstock='Postock';        
                  break;  
                }

                case'TW':
                  $openstock ='Taxhead';
                  break;

                default :{
                  $openstock='Lastock';  
                  break;  
                }
            }
         return $openstock;        
    }//end get stock type

    
    
    
    
    function checkcreditlimit($controller,$get,$post){
        $action = "";
        $doc = $controller->module->id;
        if (isset($get['action'])) {
            $action = $get['action'];
        }
        if ((Yii::$app->session['posted' . $doc] && ($action != "new")) || (Yii::$app->session['locked' . $doc] && ($action != "new"))) {
            $controller->redirect(array('index'));
        }
        $Openhead=$this->gettranstype($doc);
        if($Openhead=='Lahead'){$head = new Lahead();}
        else{$head = new Pohead();}       
        $head->unsetAttributes();
        if (isset($post[$Openhead])) {
           $head->attributes = $post[$Openhead];   
           if(strlen($head->client)!=0){
               if(!Client::iscreditlimit($head->client,0,0,$doc)){
                   $head->client="";
                   $head->clientname="";
                   $head->address="";
                   $head->terms="";
                   $head->agent="";
                   $head->agentcode="";
               }
           }
           $controller->render('head', array('head' => $head));
        }else{$controller->render('index');}
            
        //var_dump($post);
        
        
    }

 
    function checkdocno($controller, $post, $accessview, $accessnew) {

        if (isset($post) && empty($post)) {
            $title = 'Unauthorsized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        
        $doc = $controller->module->id;
         $Openhead=$this->gettranstype($doc);
        //if (Yii::$app->session['posted' . $module]) {
        // $this->redirect(array('index'));
        //}
        Yii::$app->session['trno' . $doc] = "";
        Yii::$app->session['locked' . $doc] = false;
        Yii::$app->session['posted' . $doc] = false;

        if($Openhead=='Lahead'){
            $head = new Lahead();
            }
        else{
            $head = new Pohead();
            }
        
        $common = new Common();
        $queryString = "";
        $docnolength = $common->doclength();
        $prefixes = $common->getPrefixes($doc);
        $blnExist = false;

        if (isset($post['docno'])) {
            $queryString = $post['docno'];
        }
        
        $pref = $common->GetPrefix($queryString);
        $seq = substr($queryString, $common->SearchPosition($queryString), strlen($queryString));

        if ($seq == 0 || empty($pref)) {
            if(empty($pref)) {
                $pref = strtoupper($queryString);
            }
            $seq = $common->getlastseq($pref,$doc);
        }

        if (empty($prefixes)) {
            $blnExist = true;
        } else {
            for($i = 0; $i < count($prefixes); $i++) {
                if ($pref == $prefixes[$i]) {
                    $blnExist = true;
                }
            }
        }

        if ($blnExist) {
            $poseq = $pref . $seq;
            $newdocno = $common->PadJ($poseq, $docnolength);
            $trno = $common->gettrno($newdocno,$doc);
            $head->docno = $newdocno;

            if($Openhead=='Lahead'){
                $data = Lahead::openhead($trno, $doc);
                /*switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'MLCP':
                        switch ($doc) {
                            case 'SJ':
                                $qrysumgetter = "select ifnull(ext,0) as ext from (
                                select sum(ext) as ext from lastock where trno = ".$trno."
                                union all
                                select sum(ext) as ext from glstock where trno = ".$trno."
                                ) as tbl";
                        
                                $data[0]['mlcp_freighttotal'] = Yii::$app->sbccommon->datareader($qrysumgetter);
                            break;
                        }//end switch
                    break;
                }//END SWITCH*/
            }else{
                $data = Pohead::openhead($trno, $doc);
            }//end ifs
            
            if ($data != null) {
                $this->loadheaddata($head, $data, $doc);
            }//end if

            if ($trno == "") {
                if (Yii::$app->user->access[$accessnew] != 1) { // allow new  transactions
                    $title = 'Unauthorized';
                    $message = 'Sorry, You are not allowed to Create New Transactions';
                    $message .= '<br />';
                    $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
                    Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    $controller->redirect(array('index'));
                } else {
                    $head->docno = $newdocno;
                    $head->dateid = date("Y-m-d");
                    $head->forex = 1.00;
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
                            switch(Common::getcompanyid()){
                                case 3://cellboy
                                case 1:    
                                  $contra='CA2';
                                  $head->client = Common::getdefaultclient();
                                  $head->clientname='Walk In';
                                    break;
                                default :
                                    $contra='AR1';
                                    break;
                            }
                            break;
                         }
                        case 'AJ':case 'IS': case 'MI':{
                                $contra='IN1';
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
                    
                    if($Openhead=='Lahead'){
                    $head->contra = Ladetail::getacno($contra);
                    $head->tax = 0;
                    // $defaultwh=Common::defaultwarehouse();
                    $head->wh = Yii::$app->user->whname;
                    $head->whid =Yii::$app->user->whcode; 
                    if($doc=='AJ' || $doc=='IS' || $doc == 'MI') {
                        $head->client=Yii::$app->user->whcode;                        
                        $head->clientname=Yii::$app->user->whname;
                    }
                      if($doc=='TS') {
                        $head->whid = Yii::$app->user->whcode;
                        $head->wh = Yii::$app->user->whname;
                      }else if($doc=='PU') {
                        $head->whid = Yii::$app->user->whcode;
                        $head->wh = Yii::$app->user->whname;
                      }
                    }else{
                        $head->wh = Yii::$app->user->whname;
                        $head->whid =Yii::$app->user->whcode; 

                        if($doc=='PR'){
                        $head->client=Yii::$app->user->whcode;                        
                        $head->clientname=Yii::$app->user->whname;
                        }
                    }
                    
                    $controller->render('head', array('head' => $head));
                }
            }
            //$stock = Lastock::openstock($trno,$module);

            

            if ($trno != "") {
                if (Yii::$app->user->access[$accessview] != 1) { // allow viewing of  transactions
                    $title = 'Unauthorized';
                    $message = 'Sorry, You are not allowed to View transactions';
                    $message .= '<br />';
                    $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
                    Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    $controller->redirect(array('index'));
                } else {
                    Yii::$app->session['trno' . $doc] = $trno;
                    Yii::$app->session['locked' . $doc] = Lahead::islocked($trno, $doc);
                    Yii::$app->session['posted' . $doc] = Cntnum::isPosted($trno,$doc);
                    $controller->redirect(array('index'));
                }
            }



        } else {
           
            $prefix = " : ";
            for ($x = 0; $x < count($prefixes); $x++) {
                $prefix .= $prefixes[$x] . " / ";
            }

            $title = 'Invalid prefix';
            $message = 'You may use ' . $prefix;
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        }

    }//END CHANGE DOCNO

    function loadheaddata($head, $data, $doc) {
        switch($doc){
            case 'SP':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                    $head->effectivedate = $data[0]['effectdate'];
                    break;
                }
            break;

            case 'CM':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'CANUMAY':
                        $head->sjdoc = $data[0]['sjdoc'];
                        $head->sjtrno = $data[0]['cmtrans'];        
                    break;
                }//end switch
            break;

            case 'SJ':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'MLCP':
                        $head->mlcp_freight = $data[0]['mlcp_freight'];  
                        //$head->mlcp_freighttotal =  number_format($data[0]['mlcp_freight'] + $data[0]['mlcp_freighttotal'],Yii::$app->systemsettings->setDecimaldisplay('currency'));        
                    break;
                }//end switch
            break;
        }//end switch

        
        //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD
        switch ($doc) {
            case 'TW':
            $head->quarter = $data[0]['quarter'];
            break;
        }//END SWITCH

        switch ($doc) {
            case 'SJ':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'MLCP':
                        $head->jodocno = $data[0]['mlcp_jonum'];
                    break;
                }//END SWITCH
            break;
        }//END SWITCH

        switch($doc){
            case 'SO':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                    $head->amountreceived = $data[0]['uv_amountreceived'];
                    $head->transtype = $data[0]['uv_transtype'];
                    break;

                    default:
                    $head->amountreceived = 0;
                    $head->transtype = '';
                    break;
                }//end switch
            break;

            case 'SJ':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                    $head->amountreceived = $data[0]['uv_amountreceived'];
                    break;

                    default:
                    $head->amountreceived = 0;
                    break;
                }//end switch
            break;
        }//end switch

        switch ($doc) {
            case 'TW':
            //NO DO
            break;

            default:
                $head->invoiceno = '';
                $head->invoicedate = '';
            break;
        }//END SWITCH

        
        switch ($doc) {
            case 'MI': case 'CV': case 'PV': case 'AP': case 'GJ': 
                $head->costcenter = $data[0]['costcenter']; 
                $head->ewt = $data[0]['ewt'];
                $head->ewtrate = $data[0]['ewtrate'];
            break;
            
            case 'TW':
            //NO DO
            break;

            default: 
                $head->costcenter = ''; 
                $head->ewt = '';
                $head->ewtrate = 0;
            break;
        }//END SWITCH CASE

        
        switch ($doc) {
            case 'MI': case 'CV': case 'PV': case 'AP': case 'GJ': 
                $head->costcenter = $data[0]['costcenter']; 
            break;

            case 'TW':

            break;

            default: 
                $head->costcenter = ''; 
            break;
        }//END SWITCH CASE

        switch ($doc) {
            case 'MI': case 'SJ': case 'RR': 
                $head->vattype=$data[0]['vattype']; 
            break;
        }//END SWITCH CASE

        switch ($doc) {
            case 'SJ': case 'MI':
                $head->salestype=$data[0]['salestype'];
                $head->checkno=$data[0]['checked'];
            break;
        }//END SWITCH CASE

        switch ($doc) {
            case 'SJ':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE': case 'MLCP':
                        $head->transtype = $data[0]['uv_transtype'];
                    break;

                    default:
                        $head->transtype = $data[0]['transtype'];
                    break;
                }//end switch

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'SOUTHCENTRAL':
                        $head->transmittalcode = $data[0]['txdocno'];
                    break;
                }//end switch
            break;

            case 'CM':
                $head->transtype = $data[0]['uv_transtype'];
            break;
        }//end case

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'MEGASTEEL':
                switch ($doc) {
                    case 'SJ':
                        $head->arastre = $data[0]['arastre'];
                        $head->freight = $data[0]['freight'];
                        $head->wharffage = $data[0]['wharffage'];
                    break;
                }//END SWITCH CASE
            break;

            default:
                switch ($doc) {
                    case 'SJ':
                        $head->arastre = 0;
                        $head->freight = 0;
                        $head->wharffage = 0;
                    break;

                    case 'TW':
                        //no going
                    break;
                }//END SWITCH CASE
            break;
        }//end switch

        switch ($doc) {
            case 'SJ':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                    if($data[0]['checkcode'] == ""){
                        $head->checkcode = '';
                    }else{
                        $head->checkcode = $data[0]['checkcode'] . '~' . $data[0]['checkname'];
                    }//end if

                    if($data[0]['pickcode'] == ""){
                        $head->pickcode = '';
                    }else{
                        $head->pickcode = $data[0]['pickcode']. '~' . $data[0]['pickname'];
                    }//end if
                    break;
                }//end switch
            break;
        }//end switch
        
        switch ($doc) {
            case 'MI': case 'SJ': case 'CH':
                $head->modeofpayment=$data[0]['modeofpayment'];
                $head->acctname=$data[0]['acctname'];
                $head->acctno=$data[0]['acctno'];
                $head->cardtype=$data[0]['cardtype'];
                
                $head->waybilldate=$data[0]['waybilldate'];
                $head->billlading=$data[0]['billlading'];
                $head->voyage=$data[0]['voyage'];
            break;
        } // end switch

        switch ($doc) {
            case'TR': case'KR': case'PO': case'PC': case'PR': case'QT': case 'SP':
                if($doc == 'TR'){
                    $head->agent=$data[0]['agent'] . '~' . $data[0]['agentname'];
                    $head->agentcode=$data[0]['agent'] . '~' . $data[0]['agentname'];
                    $head->pricegrp=$data[0]['trpricegrp'];
                    $head->route=$data[0]['route'];
                    $head->routeid=$data[0]['routeid'];
                }//end doc

                if($doc=='SP'){
                    $head->effectivedate = $data[0]['effectdate'];
                }

                $head->trno=$data[0]['trno'];
                $head->docno=$data[0]['docno'];
                $head->client=$data[0]['client'];
                $head->clientname=$data[0]['clientname'];
                $head->address=$data[0]['address'];
                $head->shipto=$data[0]['shipto'];
                $head->terms=$data[0]['terms'];
                
                if($doc != 'QT'){
                    $head->cur=$data[0]['cur'];
                    $head->due=$data[0]['due'];
                }//end if
                
                $head->yourref=$data[0]['yourref'];
                $head->ourref=$data[0]['ourref'];
                
                $head->rem=$data[0]['rem'];
                $head->forex=$data[0]['forex'];
                $head->dateid=$data[0]['dateid'];
                $head->wh = $data[0]['wh'];
                $head->whid = $data[0]['whid'];
                $head->groupid = $data[0]['groupid'];
            break;

            case 'PS': case 'pscheme':
                $head->trno = $data[0]['trno'];
                $head->docno = $data[0]['docno'];
                $head->client = $data[0]['client'];
                $head->terms = $data[0]['terms'];
                $head->cur = $data[0]['cur'];
                $head->forex = $data[0]['forex'];
                $head->yourref = $data[0]['yourref'];
                $head->ourref = $data[0]['ourref'];
                $head->dateid = $data[0]['dateid'];
                $head->clientname = $data[0]['clientname'];
                $head->address = $data[0]['address'];
                $head->shipto = $data[0]['shipto'];
                $head->createdate = $data[0]['createdate'];
                $head->rem = $data[0]['rem'];
                $head->agent = $data[0]['agent'];
                $head->whid = $data[0]['whid'];
                $head->wh = $data[0]['wh'];

                if (strlen($head->wh)==0) {
                  $wh=Common::defaultwarehouse();
                  $head->wh=$wh['warehousename'];
                  $head->whid=$wh['warehouse'];
                } //end if

                $head->due = $data[0]['due'];
                $head->groupid = $data[0]['groupid'];

            break;
            
            case'PI':
                $head->trno=$data[0]['trno'];
                $head->docno=$data[0]['docno'];
                $head->client=$data[0]['client'];
                $head->clientname=$data[0]['clientname'];
                $head->address=$data[0]['address'];
                $head->shipto=$data[0]['shipto'];
                $head->agent=$data[0]['agent'];
                $head->terms=$data[0]['terms'];
                $head->cur=$data[0]['cur'];
                $head->due=$data[0]['due'];
                $head->rem=$data[0]['rem'];
                $head->forex=$data[0]['forex'];
                $head->yourref=$data[0]['yourref'];
                $head->ourref=$data[0]['ourref'];
                $head->dateid=$data[0]['dateid'];
                $head->wh = $data[0]['wh'];
                $head->whid = $data[0]['whid'];
                $head->overhead = $data[0]['overhead'];
                $head->labor = $data[0]['labor'];
            break;

            case 'JB':
                $head->trno = $data[0]['trno'];
                $head->docno = $data[0]['docno'];
                $head->client =  $data[0]['client'];
                $head->clientname = $data[0]['clientname'];
                $head->dateid = $data[0]['dateid'];
                $head->yourref = $data[0]['yourref'];
                $head->ourref = $data[0]['ourref'];
                $head->shipto= $data[0]['shipto'];
                $head->trnxtype = $data[0]['trnx_type'];
                $head->salestype = $data[0]['salestype'];
                $head->pricetype = $data[0]['pricetype'];
                $head->rem = $data[0]['rem'];
                $head->wh = $data[0]['wh'];
                $head->whid = $data[0]['whid'];
                $head->reqdate = $data[0]['reqdate'];
                $head->withdrawnum = $data[0]['withdrawnum'];
                $head->equipreleasenum = $data[0]['equipreleasenum'];
                $head->breakdownreport = $data[0]['breakdownreport'];
                $head->mat_barcode = $data[0]['mat_barcode'];
            break;

            case'PD':
                $head->trno=$data[0]['trno'];
                $head->docno=$data[0]['docno'];
                $head->client=$data[0]['client'];
                $head->clientname=$data[0]['clientname'];
                $head->address=$data[0]['address'];
                $head->shipto=$data[0]['shipto'];
                $head->agent=$data[0]['agent'];
                $head->terms=$data[0]['terms'];
                $head->cur=$data[0]['cur'];
                $head->pi=$data[0]['pi'];
                $head->due=$data[0]['due'];
                $head->rem=$data[0]['rem'];
                $head->forex=$data[0]['forex'];
                $head->yourref=$data[0]['yourref'];
                $head->ourref=$data[0]['ourref'];
                $head->dateid=$data[0]['dateid'];
                $head->wh = $data[0]['wh'];
                $head->whid = $data[0]['whid'];
                $head->prc = $data[0]['prc'];
                $head->deliverydate = $data[0]['delivdate'];
            break;

            case 'SO': case 'QA':
                $head->trno=$data[0]['trno'];
                $head->docno=$data[0]['docno'];
                $head->client=$data[0]['client'];
                $head->clientname=$data[0]['clientname'];
                $head->address=$data[0]['address'];
                $head->shipto=$data[0]['shipto'];
                
                $head->rdate=$data[0]['rdate'];
                $head->rtype=$data[0]['rtype'];

                if($data[0]['agent'] == ""){
                    $head->agentcode='';
                }else{
                    $head->agentcode=$data[0]['agent'].'~'.$data[0]['agname'];
                }//end if

                if($data[0]['uv_picker'] == ""){
                    $head->picker='';
                }else{
                    $head->picker=$data[0]['uv_picker'].'~'.$data[0]['uv_pickername'];
                }//end if

                if($data[0]['uv_checker'] == ""){
                    $head->checkeragent='';
                }else{
                    $head->checkeragent=$data[0]['uv_checker'].'~'.$data[0]['uv_checkername'];
                }//end if

                $head->terms=$data[0]['terms'];
                $head->rem=$data[0]['rem'];
                $head->forex=$data[0]['forex'];
                $head->yourref=$data[0]['yourref'];
                $head->ourref=$data[0]['ourref'];
                $head->dateid=$data[0]['dateid'];
                $head->wh = $data[0]['wh'];
                $head->whid = $data[0]['whid'];
                $head->mop = $data[0]['mop'];
                $head->modamt=$data[0]['modamt'];
                $head->modref=$data[0]['modref'];
                $head->moddate=$data[0]['moddate'];
                $head->due=$data[0]['due'];
                $head->salestype=$data[0]['salestype'];
                $head->groupid = $data[0]['groupid'];
                $head->trnxtype=$data[0]['trnx_type'];
                $head->isapproved=$data[0]['isapproved'];
                $head->approvalcode=$data[0]['approvalcode'];
                $head->rfdocno=$data[0]['rfdocno'];
            break;

            case 'TW':
                $head->trno = $data[0]['trno'];
                $head->docno = $data[0]['docno'];
                $head->client = $data[0]['client'];
                $head->clientname = $data[0]['clientname'];
                $head->address = $data[0]['address'];
                $head->dateid = $data[0]['dateid'];
                $head->dateid2 = $data[0]['dateid2'];
            break;

            case 'quotation': case 'QT':
                $head->trno=$data[0]['trno'];
                $head->docno=$data[0]['docno'];
                $head->client=$data[0]['client'];
                $head->clientname=$data[0]['clientname'];
                $head->address=$data[0]['address'];
                $head->rem=$data[0]['rem'];
                $head->dateid=$data[0]['dateid'];
            break;
            

            case 'RF':
                $head->trno = $data[0]['trno'];
                $head->docno = $data[0]['docno'];
                $head->client = $data[0]['client'];
                $head->clientname = $data[0]['clientname'];
                $head->dateid = $data[0]['dateid'];
                $head->agent=$data[0]['client'] . '~' . $data[0]['clientname'];
                $head->agentcode=$data[0]['client'] . '~' . $data[0]['clientname'];
                $head->approvalcode = $data[0]['yourref'];
                $head->transmittalcode = $data[0]['txdocno'];
                $head->rem = $data[0]['rem'];
                $head->route=$data[0]['route'];
                $head->trnxtype = $data[0]['trnx_type'];
                $head->routeid=$data[0]['routeid'];
            break;

            case 'TX':
                $head->trno = $data[0]['trno'];
                $head->docno = $data[0]['docno'];
                $head->dateid = $data[0]['dateid'];
                $head->rftrno = $data[0]['rftrno'];
                $head->rfdocno = $data[0]['rfdocno'];
                $head->rem = $data[0]['rem'];
                $head->agent = $data[0]['agentcode'] . '~' . $data[0]['agentname'];
                $head->agentcode = $data[0]['agentcode'] . '~' . $data[0]['agentname'];
                $head->route = $data[0]['route'];
                $head->routeid = $data[0]['routeid'];
                $head->approvalcode = $data[0]['approvalcode'];
                $head->isinvoiced = $data[0]['invoiced'];
            break;

            case'TS': case 'PU':
                if($doc == 'TS') { // SC MODIFICATION
                    $head->agent=$data[0]['agent'] . '~' . $data[0]['agentname'];
                    $head->agentcode=$data[0]['agent'] . '~' . $data[0]['agentname'];
                    $head->pricegrp=$data[0]['trpricegrp'];
                    $head->route=$data[0]['route'];
                    $head->routeid=$data[0]['routeid'];
                }//end doc // SC END
                $head->address = $data[0]['address'];
                $head->trno = $data[0]['trno'];
                $head->docno = $data[0]['docno'];
                $head->client = $data[0]['client'];
                $head->clientname = $data[0]['clientname'];
                $head->rem =$data[0]['rem'];
                $head->forex = $data[0]['forex'];
                $head->yourref = $data[0]['yourref'];
                $head->ourref = $data[0]['ourref'];
                $head->dateid = $data[0]['dateid'];
                $head->wh = $data[0]['wh'];
                $head->whid = $data[0]['whid'];
                if (strlen($head->wh)==0) {
                    $wh=Common::defaultwarehouse();
                    $head->wh=$wh['warehousename'];
                    $head->whid=$wh['warehouse'];
                }
            break;

            default:
                $head->trno = $data[0]['trno'];
                $head->docno = $data[0]['docno'];
                $head->client = $data[0]['client'];
                $head->clientname = $data[0]['clientname'];
                $head->address = $data[0]['address'];
                $head->shipto = $data[0]['shipto'];
                $head->terms = $data[0]['terms'];
                $head->rem =$data[0]['rem'];
                $head->purchasetype =$data[0]['purchasetype'];
                if($doc == "RR" || $doc == "DM"){
                $head->cur = $data[0]['cur'];
                }else{
                $head->cur = '';    
                }

                if($doc == 'SV'){
                    $head->vattype=$data[0]['vattype'];
                    $head->invoiceno = $data[0]['invoiceno'];
                    $head->invoicedate = $data[0]['invoicedate'];
                    $head->cur=$data[0]['cur'];
                }//end if 

                $head->forex = $data[0]['forex'];
                $head->yourref = $data[0]['yourref'];
                $head->ourref = $data[0]['ourref'];
                $head->dateid = $data[0]['dateid'];
                
                if($data[0]['agentcode'] == ""){
                    $head->agentcode='';
                }else{
                    $head->agentcode=$data[0]['agentcode'] . '~' . $data[0]['agent'];
                }

                $head->agent=$data[0]['agent'];        

                if($data[0]['contra'] == ""){
                    $head->contra='';
                }else{
                    $head->contra=$data[0]['contra'] . '~' . $data[0]['acnoname'];
                }//END IF

                $head->tax = $data[0]['tax'];
                $head->wh = $data[0]['wh'];
                $head->whid = $data[0]['whid'];
                $head->due = $data[0]['due'];

                if (strlen($head->wh)==0) {
                  $wh=Common::defaultwarehouse();
                  $head->wh=$wh['warehousename'];
                  $head->whid=$wh['warehouse'];
                } 

                $head->isdeclared = Cntnum::isdeclared($head->trno);
                $head->groupid = $data[0]['groupid'];
            break;
        }
        return $head;
    }
    
    function managestock($controller, $get, $post, $accessedit) {

        
        $doc = $controller->module->id;        
        if (Yii::$app->session['posted' . $doc]) {
            $controller->redirect(array('index'));
        }

        $Openstock=$this->getstocktype($doc);
        
        $common= new Common();
        //$trans = null;
        if($Openstock=='Lastock'){
           $data_ = new Lastock();
           $model_ = new Lastock();
        }
        else{
           $data_ = new Postock();
           $model_ = new Postock();
        }

        $action = "";
        $stock = "";
        $filter="";
        $blnitemrepeated = "";
        $forex= 1;
        $trno = Yii::$app->session['trno' . $doc]; //GET TRNO

        /** forex **/
        $head = Lahead::openhead($trno, $doc);
        if ($head != null) {
           $forex = isset($head[0]['forex'])? $head[0]['forex'] : 1;
        }
       

      if(isset($post[$Openstock]['action'])){  
        if (((isset($get['action']) && $get['action']=='edit') || (isset($get['action']) && $get['action']=='delete')) && ($post[$Openstock]['action']!='cancel' && $post[$Openstock]['action']!='Save' && $post[$Openstock]['action']!='compute')) {
            $action = $get['action'];
        }else{
            if(strlen($post[$Openstock]['action'])!=0){
            $action=$post[$Openstock]['action'];}
            else{
                $action = $get['action'];
            } 
        }
      }else
      {
        if (((isset($get['action']) && $get['action']=='edit') || (isset($get['action']) && $get['action']=='delete') || (isset($get['action']) && $get['action']=='adjust'))) {
            $action = $get['action'];
        } 
      }

    
//$model_->action=$action;
        if (Yii::$app->user->access[$accessedit] != 1) { // allow editing of transactions
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to Edit transactions';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {
                 if (isset($post[$Openstock])) {
                    
                    $model_->attributes = $post[$Openstock];           
                    $model_->action=$action;
                    
                    if ($doc!='QT'){
                    $filter = $post[$Openstock]['keyword'];
                    }
                    
                    if($action=='add'){
                        $price = Item::getLatestPrice($doc,$model_->barcode,Yii::$app->session['supplier' . $doc]);                          
                        
                            switch ($doc) {
                              case 'PO':
                              case 'RR':
                              case 'PC':
                              case 'IS':
                              case 'AJ':
                              case 'MI':    
                              case 'CA':    
                              case 'PR':
                                  if ($doc != 'MI'){
                                  $model_->rrcost=number_format($price['rrcost'],2);
                                  $model_->cost=$price['cost'];
                                  $model_->uom=$price['uom'];
                                  $model_->disc=$price['disc'];
                                  switch(Common::getcompanyid()){
                                      case 3://cellboy
                                          $model_->rem=$price['supplier'];
                                          break;
                                  }
                                  }
                                break;  
                             case 'DM':
                                  $model_->isamt=number_format($price['rrcost'],2);
                                  $model_->amt=$price['cost'];
                                  $model_->uom=$price['uom'];
                                  $model_->disc=$price['disc'];
                                 break;
                             
                              default :
                                  if (Common::getcompanyid()==4){
                                  if($price['amt']!=0){
                                  $model_->isamt=number_format($price['amt'],2);
                                  //$model_->amt=$price['amt'];
                                  $model_->uom=$price['uom'];
                                  $model_->disc=$price['discount'];}
                                  } else {
                                  if($price['isamt']!=0){
                                  $model_->isamt=number_format($price['isamt'],2);
                                  $model_->amt=$price['amt'];
                                  $model_->uom=$price['uom'];
                                  $model_->disc=$price['disc'];}    
                                  }
                                  break;
                            } 
                             
                            //var_dump($action);
                    }
                    $this->unsaveitem($post,$model_,$doc,$trno,$Openstock,$action,$forex);
                 }
                 
             //$this->showmsg($action, $trno);
                 
            if ($action == "Save" || $action == "Insert") {
               
                $this->saveinsertstock($controller,$model_,$doc,$trno);
               
            } elseif ($action == "delete") {
                $this->deleteitem($controller,$common,$get,$doc,$trno);
            }elseif ($action == "quickadd") {                    
                $this->quickadd($controller,$post,$trno,$doc);                 
            } elseif ($action == "adjust") {    
               
                $this->adjustitem($trno);
                $action='';
                $controller->redirect(array('stocks'));

            } elseif ($action == "produce") {    
               
                $this->produceitem($trno);
                $action='';
                //$controller->redirect(array('stocks'));

            }

            if ($action == "cancel" || $action == "Save" || $action == "Insert") {
                $model_->unsetAttributes();
                if ($action == "cancel") {
                     $controller->redirect(array('stocks'));
                }
            }
            
            if (isset($get['id'])) {
                $line = $get['id'];
            } else {
                $line = 0;
            }

            
            if($Openstock=='Lastock'){
              $stock = Lastock::openstock($trno, $doc,$filter);
            }else{$stock = Postock::openstock($doc, $trno,$filter);}            
            
             
            
            if ($action == "edit") {
              if($Openstock=='Lastock'){
                 $stock2 = Lastock::openstockline($trno,$line, $doc);                                  
               }else{$stock2 = Postock::openstockline($doc, $trno,$line);}                            
                 $this->editstock($controller,$doc,$model_,$stock2,$accessedit,$trno,$line);                 
            }
            

            Yii::$app->session['barcode']=$model_->barcode;
            Yii::$app->session['whcode']=$model_->wh_;
            
            if ($action == "item" || $action == "add" || $action=='edit' || $action=='compute' ) {
               if($action!='edit'){
                   if($action=='compute' && $model_->line!=0){$model_->action='edit';}else{
                   $model_->action='item';
                   }                  
               }
               else {$model_->action=$action;}
            }
        }
        

        $balance = Item::getItembal($model_->barcode);
        $client = Yii::$app->session['supplier' . $doc];
        if ($action == "edit" || $action=='add' || $action=='item' || $action=='compute') {
            $trans = Postock::getpreviousTrans_($doc, $model_->barcode, $client);
        }else{
            $trans="";
        }
        $grandtotal = Lastock::getgrandtotal($trno, $doc);

        $model_->itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], 2) : 0;
        $model_->grandtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], 2) : 0;
        if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
            $model_->grandtotal = 0;
        }
        if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
            $model_->itemcount = 0;
        }
        if (strlen($blnitemrepeated) != 0) {
            $model_->keyword = $blnitemrepeated;
        }     
        
        $controller->render('stocks', array('data' => $stock,
                                            'model_' => $model_,
                                            'action' => $action,
                                            'balance' => $balance,
                                            'trans' => $trans));
    }
    
    
    
      function produceitem($trno){
        $qry="select lahead.dateid,component.uom,component.barcode,component.itemname,sum(component.qty*lastock.qty) * -1 as rrqty,sum(component.qty*lastock.qty)   as iss,lahead.wh,lahead.docno ,0 as qty from lahead left join lastock on lastock.trno=lahead.trno  left join item on item.barcode=lastock.barcode left join component on component.itemid=item.itemid  where lastock.qty>0 and lastock.trno=".$trno." group by lahead.dateid,lahead.docno,component.barcode,component.itemname,lahead.wh,component.uom;";
        $b = Yii::$app->sbccommon->datareader("select line  from lastock where trno=".$trno."  order by line desc limit 1");
        $models=Yii::$app->sbccommon->opentable($qry);
        $wh = $models[0]['wh'];
                                      
       
          
          
            $user=Yii::$app->user->username;

             Yii::$app->sbccommon->execqry("delete from lastock where iss>0  and trno=$trno");
             Yii::$app->sbccommon->execqry("delete from costing where  trno=$trno");

              
               if ($models!=null)
               {
               for ($i=0;$i<count($models);$i++)
                 {
                   $b= $b + 1;
                   $docno = $models[$i]['docno'];
                   $uom=$models[$i]['uom'];
                   $iss=$models[$i]['iss'];
                   $barcode=$models[$i]['barcode'];
                   $itemname=$models[$i]['itemname'];
                   $rrqty=$models[$i]['rrqty'];
                    if($iss>0){
                       
                          Yii::$app->sbccommon->execqry("insert into lastock(trno,line,barcode,itemname,uom,rrqty,iss,wh,encodedby)  
                                values('$trno','$b','$barcode','$itemname','$uom',$rrqty,abs($iss),'$wh','$user')                           
                                 ");
                          
                          $curcost= Lastock::computecosting($barcode, $wh, '',$trno, $b, abs($iss), 'MI');
                          if($curcost!=-1){
                             Yii::$app->sbccommon->execqry("update lastock set cost=$curcost where trno=$trno and line=$b");
                          }else{ Yii::$app->sbccommon->execqry("update lastock set rrqty=0,iss=0,ext=0 where trno=$trno and line=$b");}
              
                          }
                   
            } 
               }
                Log::writelog('MI', $trno, 'PRODUCE', $docno.' WAREHOUSE - '.$wh);
             $this->showmsg($user,  $docno);
            
    }
    
    function adjustitem($trno){
        $qry="select head.docno,head.dateid,head.yourref,stock.line,stock.barcode,stock.itemname,stock.uom,stock.loc,stock.wh,stock.rrcost,stock.cost,stock.rrqty,stock.qty from pchead as head left join pcstock as stock on stock.trno=head.trno where stock.trno=$trno";
        $models=Yii::$app->sbccommon->opentable($qry);
        $wh = $models[0]['wh'];
        $dateid = $models[0]['dateid'];
        $pcdocno = $models[0]['docno'];
        $yourref = $models[0]['yourref'];
        $contra = Yii::$app->sbccommon->datareader("select acno from coa where alias='IN1' limit 1"); 
        $whname = Yii::$app->sbccommon->datareader("select clientname from client where client='$wh'");  
        
            $common = new Common(); 
            $docnolength = $common->doclength();
            $insertcntnum=0;
           while ($insertcntnum == 0) {
                $pref ='AJ';             
                $seq = $common->getlastseq($pref,'AJ');
               $poseq = $pref . $seq;
               $newdocno = $common->PadJ($poseq, $docnolength);
               if(strlen($yourref)!=0){
                   $center = Yii::$app->user->center;
                   $ajtrno = Yii::$app->sbccommon->datareader("select ifnull(trno,0) as trno from cntnum where docno='$yourref' and center='$center'"); 
                   $newdocno=$yourref;
                   if($ajtrno==0){
                    $insertcntnum =$common->insertcntnum('AJ', $yourref, $seq, 'AJ');
                   }else{$insertcntnum=1;}
               }else{
                   $insertcntnum =$common->insertcntnum('AJ', $newdocno, $seq, 'AJ');
                 }
            }
          
            $trno_ = Cntnum::getTrnodocno($newdocno,'AJ');
            $ajtrno = $trno_[0]['trno'];
           $docno = $trno_[0]['docno'];
          
            $user=Yii::$app->user->username;

             Yii::$app->sbccommon->execqry("update pchead set yourref='$newdocno' where trno=$trno");
             Yii::$app->sbccommon->execqry("delete from lahead where trno=$ajtrno");
             Yii::$app->sbccommon->execqry("delete from lastock where trno=$ajtrno");
             Yii::$app->sbccommon->execqry("delete from costing where trno=$ajtrno");
             Yii::$app->sbccommon->execqry("INSERT into lahead
                    (docno, doc, client, clientname, address, yourref, ourref, forex, dateid, rem, shipto, terms,trno,createby,contra,tax,wh,agent)
                    values(
                       '$docno','AJ', '$wh', '$whname',
                       '', '$pcdocno', '',
                        '0', '$dateid', '',
                        '', '', '$ajtrno','$user','\\$contra','0','$wh','')");
            

                  Log::writelog('AJ', $ajtrno, 'CREATE', $docno.' WAREHOUSE - '.$wh);
               $b=1;
               if ($models!=null)
               {
               for ($i=0;$i<count($models);$i++)
                 {
                   $bal=  Item::getbalbydate($models[$i]['barcode'], $models[$i]['wh'], $models[$i]['dateid']);
                   $onhand = Item::getcurrentbal($models[$i]['barcode'], $models[$i]['wh']);
                   $factor = Item::getitemuom($models[$i]['barcode'], $models[$i]['uom']);
                   $curbal = $models[$i]['qty']-$bal;
                   $barcode=$models[$i]['barcode'];
                   $itemname=$models[$i]['itemname'];
                   $loc = $models[$i]['loc'];
                   $uom=$models[$i]['uom'];
                   $rrcost=$models[$i]['rrcost'];
                   $cost=$models[$i]['cost'];
                   $ext = $rrcost*$curbal;
                   $line=$models[$i]['line'];
                   $displaycurbal=$curbal/$factor;
                   
                   if($curbal>0){
                        Yii::$app->sbccommon->execqry("insert into lastock(trno,line,barcode,itemname,uom,rrcost,cost,rrqty,qty,ext,wh,encodedby)  
                                values('$ajtrno','$b','$barcode','$itemname','$uom','$rrcost','$cost',$displaycurbal,$curbal,$ext,'$wh','$user')                                
                                 ");
                        $b++;
                   }elseif($curbal<0){
                       if($onhand>=$bal){
                          Yii::$app->sbccommon->execqry("insert into lastock(trno,line,barcode,itemname,uom,rrcost,cost,rrqty,iss,ext,wh,encodedby)  
                                values('$ajtrno','$b','$barcode','$itemname','$uom','$rrcost','$cost',$displaycurbal,abs($curbal),$ext,'$wh','$user')                           
                                 ");
                          
                          $curcost= Lastock::computecosting($barcode, $wh, $ajtrno,$loc, $b, abs($curbal), 'AJ');
                          if($curcost!=-1){
                             Yii::$app->sbccommon->execqry("update lastock set cost=$curcost where trno=$ajtrno and line=$b");
                          }else{ Yii::$app->sbccommon->execqry("update lastock set rrqty=0,iss=0,ext=0 where trno=$ajtrno and line=$b");}
                          $b++;
                          $y=Yii::$app->sbccommon->execqry("update pcstock set rem='' where trno=$trno and line=$line");    
                     }else{
                         $rem="Cannot be adjusted.";
                        $y=Yii::$app->sbccommon->execqry("update pcstock set rem='$rem' where trno=$trno and line=$line");    
                     }
                       
                   }
                   
            } 
               }
             $this->showmsg($user,  $newdocno);
            
    }
    
    
    function deleteitem_OLD_JAC($controller,$common,$get,$doc,$trno){
                if (isset($get['id']) && isset($get['refx'])) {
                    $line = $get['id'];
                    $refx = $get['refx'];
                    $linex = $get['linex'];
                }
                $itembarcode=$common->getItem($doc, $trno, $line);
                Lastock::deletestocks($doc, $trno, $line);
                if(strlen($refx)!=0 && $refx!=0){
                   if(!Postock::setserveditems($linex,$refx,$doc)){
                     Postock::resetQuantity($line, $trno, $doc);
                     Postock::setserveditems($linex, $refx,$doc);
                     //Lastock::deletecosting($trno, $line);
                     }
                  }
                
                Log::del_log($doc, $trno, $itembarcode, 'STOCK');
                $Opentable = $this->gettranstype($doc);
                if($Opentable=='Lahead'){
                if ($trno != "" && !Yii::$app->session['posted' . $doc]) {
                    $trno_ = md5($trno);    
                    $controller->actiondistribute($trno_);
                }
                }
                $controller->redirect(array('stocks'));
        
    }
    
   function unsaveitem($post,$model_,$doc,$trno,$Openstock,$action,$forex)
                {
              
                if (isset($post[$Openstock])) {
                    if (isset($post['void'])) {
                        $model_->void = $post['void'];
                    }
                        $uom = strtoupper($model_->uom);
                        $barcode = $model_->barcode;
                        $olduom=strtoupper($model_->olduom);
                        $oldfactor=1;
                        $olddisc=$model_->olddisc;
                        $disc= $model_->disc;
                        //var_dump ($Openstock);

                        $model_->olduom=$uom;
                        $factor = Item::getFactor($barcode, $uom);
                        
                        

                        if ($factor == "") {
                            $factor = 1;
                        }
                        
                        
                if ($action == "editstock"){
                    $uom = strtoupper($post[$Openstock]['edituom']);
                    $barcode = $post[$Openstock]['editbarcode'];
                    //$disc =$post[$Openstock]['editdisc'];
                    $itemname = $post[$Openstock]['editname'];

                switch ($doc){
                    case 'PR':
                        $rem = $post[$Openstock]['rem'];
                        $disc =$post[$Openstock]['editdisc'];
                        break;
                    case 'RR':
                        $loc =$post[$Openstock]['editloc'];
                        $rem = $post[$Openstock]['rem'];
                        $disc =$post[$Openstock]['editdisc'];
                        break;
                    case 'CA':
                    case 'CM':
                    case 'TS':    
                    case 'SJ':
                    case 'DM':
                    case 'CH':    
                        $loc =$post[$Openstock]['editloc'];
                        $ref = $post[$Openstock]['ref'];
                        $disc =$post[$Openstock]['editdisc'];
                        break;
                    case 'MI':case 'PU':    
                        $loc =$post[$Openstock]['editloc'];
                        $ref = "";
                        $disc =$post[$Openstock]['editdisc'];
                        break;
                    case'SO':
                    $loc =$post[$Openstock]['editloc'];
                    $disc =$post[$Openstock]['editdisc'];    
                     break;
                     case 'QT':
                    $loc ="";
                    $disc =$post[$Openstock]['editdisc'];    
                     break;
                    case'IS':
                        $disc ="";
                        break;
                     case'PO':
                        $loc = "";
                        $ref = "";
                        $disc = $post[$Openstock]['editdisc'];
                        break;
                
                }
                
                
                switch ($doc) {
                case 'RR':case 'CA': case 'IS': case'AJ': case 'PO': case'PR': case 'PC': case'MI': {
                        $displayamt = 'editrrcost';
                        $displayqty = 'editrrqty';
                        $computeamt = 'cost';
                        $computeqty = 'qty';
                        break;
                    }
                case 'CM':
                    $displayamt = 'editisamt';
                    $displayqty = 'editrrqty';
                    $computeamt = 'amt';
                    $computeqty = 'qty';
                    break;

                case 'SJ':case'DM':case'TS':case'SO':case'PU': case 'CH': case 'QT': {
                        $displayamt = 'editisamt';
                        $displayqty = 'editisqty';
                        $computeamt = 'amt';
                        $computeqty = 'iss';
                        break;
                    }
            }
                
            }else{
                $uom = strtoupper($model_->uom);
                $barcode = $model_->barcode;
                $loc = $model_->loc;
                $rem = $model_->rem;
                $disc = $model_->disc;
                $itemname = $model_->itemname;
                
                switch ($doc) {
                case 'RR':case 'CA': case 'IS': case'AJ': case 'PO': case'PC': case'PR': case'MI':{
                        $displayamt = 'rrcost';
                        $displayqty = 'rrqty';
                        $computeamt = 'cost';
                        $computeqty = 'qty';
                        break;
                    }
                case 'CM':
                    $displayamt = 'isamt';
                    $displayqty = 'rrqty';
                    $computeamt = 'amt';
                    $computeqty = 'qty';
                    break;

                case 'SJ':case'DM':case'TS':case'SO':case'PU': case 'CH': case 'QT': {
                        $displayamt = 'isamt';
                        $displayqty = 'isqty';
                        $computeamt = 'amt';
                        $computeqty = 'iss';
                        break;
                    }
            }
                
            }
                        
                        $discount="";
                        $discount=$disc;
//                         if (Common::getcompanyid()==4){ //pioneer setting
//                              switch($doc){
//                                  case 'SJ':case 'SO':case 'CH':
//                                    
//                                    $ItemUomPrice = Item::getItemUomSellingPrice($barcode, $uom);
//                                    if(!$ItemUomPrice==null){
//                                        //var_dump($ItemUomPrice);
//                                        if($ItemUomPrice[0]['amt']<>0){
//                                            $model_->$displayamt=$ItemUomPrice[0]['amt'];
//                                            $discount=$ItemUomPrice[0]['discount'];
//                                            $model_->uom=$uom;
//                                        }else{
//                                            $model_->$displayamt=0;
//                                            $discount=""; 
//                                            $model_->uom=$uom;
//                                 
//                                        }
//                                    }else{
//                                        $discount = $disc;
//                                        $model_->uom=$uom;
//                                    }                                                 
//                                      break;
//                              }
//                        
//                        } else {
//                            $discount=$disc;
//                        }

                        
                        
                        
//                         $this->showmsg('wwww', $action);
                        if ($action == 'quickadd') {    
                          if ($model_->$displayqty == 0) {
                            $model_->$displayqty = 1;
                            }                            
                        }
                        
                        $model_->$displayamt=  str_replace(",", "", $model_->$displayamt);
                        $model_->$displayqty=  str_replace(",", "", $model_->$displayqty);
                        $model_->$computeamt=  str_replace(",", "", $model_->$computeamt);
                        $model_->$computeqty=  str_replace(",", "", $model_->$computeqty);
                        
                         //$disc = $model_->disc;
                        if($uom!=$olduom) {
                            $oldfactor=Item::getFactor($barcode, $olduom);
                            if (Common::getcompanyid()==4){ //pioneer setting
                              switch($doc){
                                  case 'SJ':case 'SO': case 'CH': case 'QT':
                                      break;
                                  default:
                                      $model_->$displayamt=($model_->$displayamt/$oldfactor)*$factor;
                                      break;
                              }
                                
                            }else{
                               $model_->$displayamt=($model_->$displayamt/$oldfactor)*$factor;    
                            }
                            
                            
                            if($model_->$displayqty!=0){                             
                                $model_->$computeamt=((Yii::$app->sbccommon->Discount($model_->$displayamt,$discount)*abs($model_->$displayqty))/$factor)/abs($model_->$displayqty)*$forex;
                            }
                            else
                            {
                                $model_->$computeamt=((Yii::$app->sbccommon->Discount($model_->$displayamt,$discount)*abs($model_->$displayqty))/$factor)*$forex;
                            }
                        }else {
                            if($model_->$displayqty!=0){                             
                              $model_->$computeamt=((Yii::$app->sbccommon->Discount($model_->$displayamt,$discount)*abs($model_->$displayqty))/$factor)/abs($model_->$displayqty)*$forex;
                            }
                            else
                            {
                              $model_->$computeamt=((Yii::$app->sbccommon->Discount($model_->$displayamt,$discount)*abs($model_->$displayqty))/$factor)*$forex;
                            }
                        }
                        if($Openstock=='Lastock'){
                             $model_->qty=0;
                             $model_->iss=0;                            
                        }
                        else{
                            $model_->$computeqty=0;
                        }
                        switch($doc){                        
                            case'AJ':case'MI':case'IS':
                            {
                                if($model_->$displayqty<0){
                                    $model_->iss = abs($model_->$displayqty) * $factor;
                                }else{
                                    $model_->$computeqty = abs($model_->$displayqty) * $factor;}
                                break;
                            }
                            default :
                            {
                                $model_->$computeqty = abs($model_->$displayqty) * $factor;
                                break;
                            }
                        }

                        $model_->ext = ((Yii::$app->sbccommon->Discount($model_->$displayamt,$discount)*$model_->$displayqty));
                         
                        $model_->disc = $discount;


                        if (($model_->$displayamt) != 0 && ($model_->$displayqty) != 0) {
                            
                        } else {
                            $model_->$computeamt = 0;
                        }
                        if(strlen($model_->wh_)==0){
                            $head_warehouse = Lastock::getheadwarehouse($trno, $doc);
                            $model_->wh = $head_warehouse['wh'];
                           $model_->wh_ = $head_warehouse['whcode'];
                        }    

                        if($Openstock=='Lastock'){
                           if(strlen($model_->refx)==0 || $model_->refx==0 || is_null($model_->refx)){$model_->refx=0;}
                           if(strlen($model_->linex)==0 || $model_->linex==0 || is_null($model_->linex)){$model_->linex=0;}
                           if(strlen($model_->line)==0 || $model_->line==0 || is_null($model_->line)){$model_->line=0;}
                           if(strlen($model_->void)==0 || $model_->void==0 || is_null($model_->void)){$model_->void=0;}
                           if(strlen($model_->disc)==0 || is_null($model_->disc)){$model_->disc='';}  
                           if(strlen($model_->rrcost)==0 || $model_->rrcost==0 || is_null($model_->rrcost)){$model_->rrcost=0;}
                           if(strlen($model_->cost)==0 || $model_->cost==0 || is_null($model_->cost)){$model_->cost=0;}
                           if(strlen($model_->isqty)==0 || $model_->isqty==0 || is_null($model_->isqty)){$model_->isqty=0;}
                           if(strlen($model_->rrqty)==0 || $model_->rrqty==0 || is_null($model_->rrqty)){$model_->rrqty=0;}
                           if(strlen($model_->qa)==0 || $model_->qa==0 || is_null($model_->qa)){$model_->qa=0;}
                           if(strlen($model_->comm)==0 || $model_->comm==0 || is_null($model_->comm)){$model_->comm=0;}
                           if(strlen($model_->icomm)==0 || $model_->icomm==0 || is_null($model_->icomm)){$model_->icomm=0;}
                        }else{
                           if(strlen($model_->line)==0 || $model_->line==0 || is_null($model_->line)){$model_->line=0;}
                           if(strlen($model_->void)==0 || $model_->void==0 || is_null($model_->void)){$model_->void=0;}
                           if(strlen($model_->disc)==0 || is_null($model_->disc)){$model_->disc='';}  
                           if(strlen($model_->rrqty)==0 || $model_->rrqty==0 || is_null($model_->rrqty)){$model_->rrqty=0;}
                           if(strlen($model_->rrcost)==0 || $model_->rrcost==0 || is_null($model_->rrcost)){$model_->rrcost=0;}
                           if(strlen($model_->cost)==0 || $model_->cost==0 || is_null($model_->cost)){$model_->cost=0;}
                           if(strlen($model_->$displayamt)==0 || $model_->$displayamt==0 || is_null($model_->$displayamt)){$model_->$displayamt=0;}
                           if(strlen($model_->$computeamt)==0 || $model_->$computeamt==0 || is_null($model_->$computeamt)){$model_->$computeamt=0;}
                           if(strlen($model_->$displayqty)==0 || $model_->$displayqty==0 || is_null($model_->$displayqty)){$model_->$displayqty=0;}
                        }
                        
                   
                }
        }
        
        
    
function saveinsertstock_old($controller,$data_,$doc,$trno)
    {
        if ($data_->validate()) {
                   //$itemid=$data_->itemid;
                   $line=$data_->line;
                   $Openstock=$this->getstocktype($doc);
                   
                   if($line==0){   //insert new item in stock
                       if($Openstock=='Lastock'){
                           //$client = Yii::$app->session['supplier' . $doc];
                           if($doc=='SJ'){                              
                               
                               if(Client::iscreditlimit(Yii::$app->session['supplier' . $doc],0,$data_->ext,$doc)){
                                   Lastock::insertstock($doc,$trno,$data_);
                               }
                           }else{
                           Lastock::insertstock($doc,$trno,$data_);                           
                           }
                           
                           if ($trno!="" && !Yii::$app->session['posted' .$doc]) {
                             $trno_=md5($trno);
                             $controller->actiondistribute($trno_);
                            }
                           }else{Postock::insertstock($doc,$trno,$data_);}
                        $controller->redirect(array('stocks'));
                   }
                   else  //edit item in stock
                   {                      
                       
                          if($Openstock=='Lastock'){
                           if($doc=='SJ'){
                               
                               $stock2 = Lastock::openstockline($trno,$line, $doc);                               
                               if(Client::iscreditlimit(Yii::$app->session['supplier' . $doc],$stock2[0]['ext'],$data_->ext,$doc)){                                                                      
                                   Lastock::updatestocks($doc,$line, $trno, $data_);  
                               }
                           }else{
                               Lastock::updatestocks($doc,$line, $trno, $data_);  
                           }
                              
                            
                            if ($trno!="" && !Yii::$app->session['posted' .$doc]) {
                                $trno_=md5($trno);
                                $controller->actiondistribute($trno_);
                            }                              
                          }else{
                              Postock::updatestock($doc, $line, $trno, $data_);
                          } 
                   } //end edit item in stock
        }else{
            var_dump($data_->getErrors());
        }
    }
    
    
function editstock($controller,$doc,$model_,$stock,$accessedit,$trno,$line){
   if (Yii::$app->user->access[$accessedit] != 1) { // allow editing of transactions
          $title = 'Unauthorized';
          $message = 'Sorry, You are not allowed to perform this action';
          $message .= '<br />';
          $message .= CHtml::Button('Ok', array('submit' => array('stocks')));
          Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
          $controller->redirect(array('index'));
      } else {
          for ($i = 0; $i < count($stock); $i++) {
              $line_ = $stock[$i]['line'];
              if ($line == $line_) {
                  $model_->barcode = $stock[$i]['barcode'];
                  $model_->itemname = $stock[$i]['itemname'];
                  $model_->uom = $stock[$i]['uom'];
                  $model_->olduom=$stock[$i]['uom'];
                  $model_->line = $line;
                  switch ($doc) {
                      case 'QT':
                          $model_->addremarks=$stock[$i]['addremarks'];
                          break;
                      case 'RR':
                          $model_->rem=$stock[$i]['rem'];
                           $model_->refx = $stock[$i]['refx'];
                            $model_->linex = $stock[$i]['linex'];
                       case 'PO':
                           $model_->rrqty = $stock[$i]['rrqty'];
                           $model_->qty = $stock[$i]['qty'];
                           $model_->rrcost = number_format($stock[$i]['rrcost'],2);
                           $model_->cost = $stock[$i]['cost'];                           
                           $model_->refx = $stock[$i]['refx'];
                           $model_->linex = $stock[$i]['linex'];
                        break;
                      case 'PC': case 'PR':
                       $model_->rrqty = $stock[$i]['rrqty'];
                       $model_->qty = $stock[$i]['qty'];
                       $model_->rrcost = number_format($stock[$i]['rrcost'],2);
                       $model_->cost = $stock[$i]['cost'];
                       
                          break;
                      case 'SO':
                        $model_->isqty =  number_format($stock[$i]['isqty'],2);
                        $model_->iss = $stock[$i]['iss'];
                        $model_->amt = $stock[$i]['amt'];
                        $model_->isamt = number_format($stock[$i]['isamt'],2);

                          break;
                      case 'CM':
                  $model_->rrcost = number_format($stock[$i]['rrcost'],2);
                  if($model_->cost==0){        
                  $model_->cost = $stock[$i]['cost'];}
                  
                  $model_->rrqty = $stock[$i]['rrqty'];
                  $model_->qty = $stock[$i]['qty'];
                  $model_->isqty = $stock[$i]['isqty'];
                  $model_->iss = $stock[$i]['iss'];
                  $model_->amt = $stock[$i]['amt'];
                  $model_->isamt = number_format($stock[$i]['isamt'],2);
                  $model_->refx = $stock[$i]['refx'];
                  $model_->linex = $stock[$i]['linex'];
                  $model_->sku = $stock[$i]['sku'];
                          
                          break;
                      default:
                  $model_->rrcost = number_format($stock[$i]['rrcost'],2);
                  $model_->cost = $stock[$i]['cost'];
                  $model_->rrqty = number_format($stock[$i]['rrqty'],2);
                  $model_->qty = $stock[$i]['qty'];
                  $model_->isqty = number_format($stock[$i]['isqty'],2);
                  $model_->iss = $stock[$i]['iss'];
                  $model_->amt = $stock[$i]['amt'];
                  $model_->isamt = number_format($stock[$i]['isamt'],2);
                  $model_->refx = $stock[$i]['refx'];
                  $model_->linex = $stock[$i]['linex'];
                  $model_->sku = $stock[$i]['sku'];
                          break;
                  }
                  switch ($doc) {
                      case 'SJ':
                      case 'AJ':
                      case 'MI':    
                      case 'DM':
                      case 'TS':case 'PU': case 'CH':
                          if($stock[$i]['iss']!=0){$model_->iss_=$stock[$i]['iss'];}
                          break;
                  }
                  
                  switch ($doc) {
                      case 'SJ':case 'CH':
                      case 'CM':
                          $model_->comm = $stock[$i]['comm'];
                          $model_->icomm = $stock[$i]['icomm'];
                          break;
                  }                  
                     
                  $model_->loc = $stock[$i]['loc'];   
                  $model_->disc = $stock[$i]['disc'];
                  $model_->ext = number_format($stock[$i]['ext'],2);
                  $model_->qa = $stock[$i]['qa'];                  
                  $model_->void = $stock[$i]['void'];
                  $model_->trno = $trno;
                  $model_->wh = $stock[$i]['wh'];
                  $model_->wh_ = $stock[$i]['whcode'];
                  
                   if (strlen($model_->wh)==0 || is_null($model_->wh))
                          {
                        $head_warehouse = Lastock::getheadwarehouse($trno, $doc);
                       $model_->wh = $head_warehouse['wh'];
                       $model_->wh_ = $head_warehouse['whcode'];
                         }
              }
          }
          //var_dump($stock);
      } 
    }
    
    
    
function quickadd($controller,$post,$trno,$doc){
            $Openstock=$this->getstocktype($doc);   
           if (isset($post[$Openstock]['quickadd'])) {
            
            $forex="";
            $display="";
            $key = $post[$Openstock]['quickadd'];
            $item = Item::getItem($key);

            if (!empty($item)) {
                if($Openstock=='Lastock'){$quickmodel = new Lastock();}
                else{$quickmodel = new Postock();}
                
                $isamt=0;
                $amt=0;
                $disc='';
                
                $quickmodel->barcode = $item[0]['barcode'];
                $quickmodel->itemname = $item[0]['itemname'];
                $quickmodel->uom = strtoupper($item[0]['uom']);
                $quickmodel->disc = $item[0]['disc'];
                    $head_warehouse = Lastock::getheadwarehouse($trno, $doc);
                    $quickmodel->wh_ = $head_warehouse['whcode'];
                    $quickmodel->wh = $head_warehouse['wh'];
                    
                switch ($doc){
                    case 'CM':case 'SJ':case'TS':case'SO':case'PU': case 'CH':{
                        //$head_client=Lastock::getheadclient($trno, $doc);
                        switch (Common::getcompanyid())
                        {
                   default:                       
                        $price = Item::getLatestPrice($doc,$item[0]['barcode'],Yii::$app->session['supplier' . $doc]);                          
                        $isamt=$price['isamt'];
                        $amt=$price['amt'];
                        $disc=$price['disc'];  
                        if($isamt==0){$isamt=$item[0]['amt'];}
                        if($disc==''){$disc=$item[0]['disc'];}
                        if($amt==0){$isamt=$item[0]['amt'];}
                        $quickmodel->sku = '';
                        break;
                  case 4:
                        $price = Item::getLatestPrice($doc,$item[0]['barcode'],Yii::$app->session['supplier' . $doc]);                          
                        $isamt=$price['isamt'];
                        $amt=$price['amt'];
                        $disc=$price['discount'];  
                        if($isamt==0){$isamt=$item[0]['amt'];}
                        if($disc==""){$disc=$item[0]['discount'];}
                        if($amt==0){$isamt=$item[0]['amt'];}
                        $quickmodel->sku = '';
                        break;
                        }     
                        break;}
                   case 'DM':case 'RR':case'PO':case'AJ':case'IS':case'CA':{
                        $price = Item::getLatestPrice($doc,$item[0]['barcode'],Yii::$app->session['supplier' . $doc]);      
                        $isamt=$price['rrcost'];
                        $amt=$price['cost'];
                        $disc=$price['disc'];  
                        //if($isamt==0){$isamt=$item[0]['amt'];}
                        //if($disc==''){$disc=$item[0]['disc'];}
                        //if($amt==0){$isamt=$item[0]['amt'];}
                       break;
                   }     
                }

                switch ($doc) {
                    case'CM':{
                       $quickmodel->rrqty = 1; 
                       $quickmodel->isqty = 0;
                       $quickmodel->qty = 1;
                       $quickmodel->iss = 0;
                       $quickmodel->rrcost = 0;
                       $quickmodel->cost = 0;
                      $quickmodel->amt = $amt;
                      $quickmodel->isamt =$isamt;
                      $quickmodel->refx = 0;
                      $quickmodel->ref = '';
                      $quickmodel->linex = 0;
                      $quickmodel->ext =  number_format($quickmodel->rrqty * $quickmodel->isamt,2);
                      $quickmodel->void = 0;
                      $quickmodel->qa = 0;
                        break;
                    }
                    case 'SJ':case'TS':case'DM':case'PU': case 'CH':{
                       $quickmodel->rrqty = 0; 
                       $quickmodel->isqty = 1;
                       $quickmodel->qty = 0;
                       $quickmodel->iss = 1;
                       $quickmodel->rrcost = 0;
                       $quickmodel->cost = 0;
                      $quickmodel->amt = $amt;
                      $quickmodel->isamt =$isamt;
                      $quickmodel->refx = 0;
                      $quickmodel->ref = '';
                      $quickmodel->linex = 0;
                      $quickmodel->ext = number_format($quickmodel->isqty * $quickmodel->isamt,2);
                      $quickmodel->void = 0;
                      $quickmodel->qa = 0;
                      //$quickmodel->ref=$p;
                        break;
                    }
                         
                    case 'RR':case'CA':
                    {
                       $quickmodel->rrqty = 1; 
                       $quickmodel->isqty = 0;
                       $quickmodel->qty = 1;
                       $quickmodel->iss = 0;
                       $quickmodel->rrcost = $isamt;
                       $quickmodel->cost = $amt;
                      $quickmodel->amt = 0;
                      $quickmodel->isamt =0;
                      $quickmodel->refx = 0;
                      $quickmodel->ref = '';
                      $quickmodel->linex = 0;
                      $quickmodel->ext =  number_format($quickmodel->rrqty * $quickmodel->rrcost,2);
                      $quickmodel->void = 0;
                      $quickmodel->qa = 0;
                        break;
                    }
                    case 'PO': case 'PC': case 'PR':
                    case 'IS': case 'AJ': case'MI':
                       $quickmodel->rrqty = 1; 
                       $quickmodel->qty = 1;
                       $quickmodel->rrcost = $isamt;
                       $quickmodel->cost = $amt;
                       $quickmodel->ext =  number_format($quickmodel->rrqty * $quickmodel->rrcost,2);
                       $quickmodel->void = 0;
                        break;
                    case 'SO':
                       $quickmodel->isqty = 1;
                       $quickmodel->iss = 1;
                      $quickmodel->amt = $amt;
                      $quickmodel->isamt = $isamt;
                      $quickmodel->ext =  number_format($quickmodel->isqty * $quickmodel->isamt,2);
                        break;                    
                        
                    default:
                    {
                       $quickmodel->rrqty = 0; 
                       $quickmodel->isqty = 1;
                       $quickmodel->qty = 0;
                       $quickmodel->iss = 1;
                       $quickmodel->rrcost = 0;
                       $quickmodel->cost = 0;
                      $quickmodel->amt = $item[0]['amt'];
                      $quickmodel->isamt = $item[0]['amt'];
                      $quickmodel->refx = 0;
                      $quickmodel->ref = '';
                      $quickmodel->linex = 0;
                      $quickmodel->ext = 0;
                      $quickmodel->void = 0;
                      $quickmodel->qa = 0; 
                        break;
                    }
                }
                                
                if($Openstock=='Lastock'){$itemcount = Lastock::checkstock($trno, $quickmodel->barcode,$doc);}
                else{$itemcount = Postock::checkstock($trno, $quickmodel->barcode,$doc);}
                //$this->showmsg($quickmodel->uom, $quickmodel->olduom);
                $this->unsaveitem($post,$quickmodel,$doc,$trno,$Openstock,'quickadd',$forex); 
                
                if ($itemcount > 0) {
                    
                    //$nth = $itemcount + 1;
                    $title = "Repeat Item";
                    $message = $quickmodel->barcode . " item has been previously added in this Transaction ";
                    $message .='<br>';
                    //Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    // var_dump($quickmodel);
                    $this->showmsg($title, $message);
                }
                    if($Openstock=='Lastock'){
                        Lastock::insertstock($doc, $trno, $quickmodel,1);
                            if ($trno!="" && !Yii::$app->session['posted' .$doc]) {
                                $trno_=md5($trno);
                                $controller->actiondistribute($trno_);
                            }                              
                        }
                    else{Postock::insertstock($doc, $trno, $quickmodel);}
                   //$controller->redirect(array('stocks&action=quickadd'));
                   
                
            }
        }
    }
    
    
    function deletetrans($controller, $post, $accessdelete) {

        if (isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        $doc = $controller->module->id;
        $Openhead=$this->gettranstype($doc);
        if($Openhead=='Lahead'){$head = new Lahead();}
        else{$head = new Pohead();}
        
        $trno = $post[$Openhead]['trno'];
        if (Yii::$app->user->access[$accessdelete] != 1) { // allow deleting of transactions
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to Delete transactions';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {

            $head->attributes = $post[$Openhead];
            $docno = Cntnum::getdocno($trno,$doc);
            $common = new Common();
            $action="delete";

            $newtrno=Common::navnext_prev($docno,$trno, $doc, $action);
            if($common->delete($doc, $trno)) {
                Log::del_log($doc,$trno,$docno,'TRANSACTION');
                Yii::$app->session['trno'.$doc]=$newtrno;
                $controller->redirect(array('index'));
            }
        }

        $controller->redirect(array('index'));
    }
    function lockunlock($controller, $get, $post, $accesslock, $accessunlock) {
        if (!isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            
        }
        $doc=$controller->module->id;
        $trno = Yii::$app->session['trno' . $doc];
        if (isset($get['action'])) {
            $action = $get['action'];
        }
        //$this->showmsg($action, $doc);
        if ($action == 'mLock' || $action == 'mUnlock') {
            if ($action == 'mLock') {
                if (Yii::$app->user->access[$accesslock] != 1) { // allow lock 
                    $title = 'Unauthorized';
                    $message = 'Sorry, You are not allowed to Lock transactions';
                    $message .= '<br />';
                    $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
                    Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    $controller->redirect(array('index'));
                } else {
                    Lahead::lock($trno,$doc);
                    Yii::$app->session['locked' . $doc] = Lahead::islocked($trno,$doc);
                }
            } elseif ($action == 'mUnlock') {
                if (Yii::$app->user->access[$accessunlock] != 1) { // allow unlock of RR transactions
                    $title = 'Unauthorized';
                    $message = 'Sorry, You are not allowed to Unlock transactions';
                    $message .= '<br />';
                    $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
                    Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    $controller->redirect(array('index'));
                } else {
                    Lahead::unlock($trno,$doc);
                    Yii::$app->session['locked' . $doc] = Lahead::islocked($trno,$doc);
                }
            }
            $controller->redirect(array('index'));
        }

        if ($action == 'hLock' || $action == 'hUnlock') {
            Yii::$app->session['trno' . $doc] = $post[$Openhead]['trno'];
            $trno = Yii::$app->session['trno' . $doc];
            if ($action == 'hLock') {
                Lahead::lock($trno,$doc);
                Yii::$app->session['locked' . $doc] = Lahead::islocked($trno,$doc);
            } elseif ($action == 'hUnlock') {
                Lahead::unlock($trno,$doc);
                Yii::$app->session['locked' . $doc] = Lahead::islocked($trno,$doc);
            }
            $controller->redirect(array('menu'));
        }
    }
    function changedocno($controller, $post, $accesschange) {

        if (isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        if (Yii::$app->user->access[$accesschange] != 1) { // allow change docno of RR transactions
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to change Document Number of  transactions under this module';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {
            $doc = $controller->module->id;
            $Openhead = $this->gettranstype($doc);
            if($Openhead=='Lahead'){$head = new Lahead();}
            else{$head = new Pohead();}
            
            $common = new Common();
            
            $trno = Yii::$app->session['trno' . $doc];
            $data = Lahead::openhead($trno, $doc);
            $prefixes = $common->getPrefixes($doc);
            $newdocno = "";
            $blnExist = false;
            if (isset($post[$Openhead])) {
                $queryString = $post[$Openhead]['newdocno'];
                $pref = $common->GetPrefix($queryString);
                $seq = substr($queryString, $common->SearchPosition($queryString), strlen($queryString));
                if ($seq == 0 || empty($pref)) {
                    if (empty($pref)) {
                        $pref = strtoupper($queryString);
                    }
                    $seq = $common->getlastseq($pref,$doc);
                }
                $poseq = $pref . $seq;
                $docno = $post[$Openhead]['docno'];
                $docnolength = $common->doclength();
                $newdocno = $common->PadJ($poseq, $docnolength);

                if (empty($prefixes)) {
                    $blnExist = true;
                } else {
                    for ($i = 0; $i < count($prefixes); $i++) {
                        if ($pref == $prefixes[$i]) {
                            $blnExist = true;
                        }
                    }
                }
            }
            
            if ($blnExist) {
                $check = $common->gettrno($newdocno,$doc);
                //$this->showmsg($check, $newdocno);
                if ($check) {
                    if ($newdocno == $docno) {
                        $title = 'Same Document #';
                        $message = 'You have entered the same document # ' . $newdocno;
                        $message .= '<br />';
//                        $message .= CHtml::Button('Ok', array('submit' => array('index')));
                        Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    } else {
                        $title = 'Existing Document #';
                        $message = 'Sorry, ' . $newdocno . ' is already in use.';
                        $message .= '<br />';
//                        $message .= CHtml::Button('Ok', array('submit' => array('index')));
                        Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    }
                } else {
                    Cntnum::updatedocno($newdocno, $trno, $doc);
                    Log::writelog($doc,$trno,'CHANGE',$docno.'=>'.$newdocno);
                    //$data = Lahead::openhead($trno, $module);
                    $title="";
                    $message="";
                    $controller->redirect(array('index'));
                }
            } else {
                $prefix = " : ";
                for ($x = 0; $x < count($prefixes); $x++) {
                    $prefix .= $prefixes[$x] . " / ";
                }
                $title = 'Invalid prefix';
                $message = 'You may use ' . $prefix;
                $message .= '<br />';
//                $message .= CHtml::Button('Ok', array('submit' => array('index')));
                Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            }
            $head->trno = $data[0]['trno'];
            $head->docno = $data[0]['docno'];
            $head->client = $data[0]['client'];
            $head->clientname = $data[0]['clientname'];
            $head->address = $data[0]['address'];
            $head->shipto = $data[0]['shipto'];
            $head->terms = $data[0]['terms'];
            $head->rem = $data[0]['rem'];
            $head->forex = $data[0]['forex'];
            $head->yourref = $data[0]['yourref'];
            $head->ourref = $data[0]['ourref'];
            $head->dateid = $data[0]['dateid'];


            $controller->render('head', array('head' => $head,)); // 'stock'=>$stock));
        }
    }

    
    
        function managedetaildelete($controller, $get, $post, $accessviewdetails) {
            $data = "";
            $doc = $controller->module->id;
            $trno = Yii::$app->session['trno' . $doc];
            $table = Common::localdetail($doc);
            $model = new Lahead();
            $datamodel = new Ladetail();
            $common = new Common();
            $action = "";

            if (isset($get['action'])) {
                $action = $get['action'];
            }
            
            $datamodel->client = Yii::$app->session['supplier' . $doc];
            $datamodel->clientname = Common::getclientname(Yii::$app->session['supplier' . $doc]);
            
            if (isset($get['id'])) {
                $line = $get['id'];
            } else {
                $line = 0;
            }
            $detail = Ladetail::opendetailline($trno,$line);
            
            if ($action == "delete") {
                    if (isset($get['id'])) {
                        $line = $get['id'];
                        Ladetail::deletedetail_($doc, $trno, $line);
                        //$this->showmsg($datamodel->refx,$datamodel->linex );
                   if($detail[0]['refx']!=0){
                       $datamodel->refx=$detail[0]['refx'];
                       $datamodel->linex=$detail[0]['linex'];              
                       $datamodel->acno=$detail[0]['acno'];
                     if(Apledger::updatebal($datamodel->refx, $datamodel->linex, $datamodel, $doc,1)==1){
                        }
                      }
                        
                    }
                }
                
                
            if(empty($datamodel->postdate)){
               $datamodel->postdate = Yii::$app->session['headdate' . $doc];            
            }
            
            $data = Ladetail::opendetail($trno);
            $debit = 0;
            $credit = 0;
            $olddb = 0;
            $oldcr = 0;
            for ($j = 0; $j < count($data); $j++) {
                if ($line == $data[$j]['line']) {
                    $olddb = $data[$j]['db'];
                    $oldcr = $data[$j]['cr'];
                }
                $debit = $debit + ($data[$j]['db'] - $olddb);
                $credit = $credit + ($data[$j]['cr'] - $oldcr);
            }
            $datamodel->fdb = $debit;
            $datamodel->fcr = $credit;
            $datamodel->runningdb = $debit;
            $datamodel->runningcr = $credit;

                
            $controller->render('details', array('data' => $data, 'model' => $model, 'datamodel' => $datamodel));
                
    }

    
    
    function managedetailonly($controller, $get, $post, $accessviewdetails) {
            $doc = $controller->module->id;
            $trno = Yii::$app->session['trno' . $doc];
            $table = Common::localdetail($doc);
            $model = new Lahead();
            $datamodel = new Ladetail();
            $common = new Common();
            $action = "";

            if (isset($get['action'])) {
                $action = $get['action'];
            }

            if($action=='edit'){
                $post='';
            }
            if(isset($post['Ladetail'])){$datamodel->attributes = $post['Ladetail'];}
            
            $datamodel->client = Yii::$app->session['supplier' . $doc];
            $datamodel->clientname = Common::getclientname(Yii::$app->session['supplier' . $doc]);
            
            if (isset($get['id'])) {
                $line = $get['id'];
            } else {
                $line = 0;
            }
            $detail = Ladetail::opendetailline($trno,$line);
            
            if (isset($post['Lahead'])) {
                $model->trno = $trno;
                $model->docno = isset($post['Lahead']['docno']) ? $post['Lahead']['docno'] : '';
                $model->dateid = isset($post['Lahead']['dateid']) ? $post['Lahead']['docno'] : date('Y-m-d');;
                $model->contra = isset($post['Lahead']['contra']) ? $post['Lahead']['contra'] : '';
                $model->tax = isset($post['Lahead']['tax']) ? $post['Lahead']['tax'] : 0;
            } 
            else 
            {
                if ($action == "edit") {
                    for ($i = 0; $i < count($detail); $i++) {
                        $line_ = $detail[$i]['line'];
                        if ($line == $line_) {
                            $datamodel->acno = $detail[$i]['acno'];
                            $datamodel->acnoname = $detail[$i]['acnoname'];
                            $datamodel->client = $detail[$i]['client'];
                            $datamodel->clientname = $detail[$i]['clientname'];
                            $datamodel->db = round(floor($detail[$i]['db']*100)/100,2);
                            $datamodel->cr = round(floor($detail[$i]['cr']*100)/100,2);   // 10//$detail[$i]['cr'];
                            $datamodel->fdb = $detail[$i]['fdb'];
                            $datamodel->fcr = $detail[$i]['fcr'];
                            $datamodel->ref = $detail[$i]['ref'];
                            $datamodel->rem = $detail[$i]['rem'];
                            $datamodel->refx = $detail[$i]['refx'];
                            $datamodel->linex = $detail[$i]['linex'];
                            $datamodel->postdate = $detail[$i]['postdate'];
                            $datamodel->checkno = $detail[$i]['checkno'];
                            $datamodel->line = $line;
                        }
                    }

                    if (isset($get['unsaved'])) {
                        if (isset($post['Ladetail'])) {
                            $datamodel->attributes = $post['Ladetail'];
                            $datamodel->client = $detail[$i]['client'];
                            $datamodel->clientname = $detail[$i]['clientname'];
                        }
                    }
                } elseif ($action == "delete") {
                    if (isset($get['id'])) {
                        $line = $get['id'];
                        Ladetail::deletedetail_($doc, $trno, $line);
                        //$this->showmsg($datamodel->refx,$datamodel->linex );
                   if($detail[0]['refx']!=0){
                       $datamodel->refx=$detail[0]['refx'];
                       $datamodel->linex=$detail[0]['linex'];              
                       $datamodel->acno=$detail[0]['acno'];
                     if(Apledger::updatebal($datamodel->refx, $datamodel->linex, $datamodel, $doc,1)==1){
                        }
                      }
                        
                    }
                }
            }
            if(empty($datamodel->postdate)){
               $datamodel->postdate = Yii::$app->session['headdate' . $doc];            
            }
            
            $data = Ladetail::opendetail($trno);
            $debit = 0;
            $credit = 0;
            $olddb = 0;
            $oldcr = 0;
            for ($j = 0; $j < count($data); $j++) {
                if ($line == $data[$j]['line']) {
                    $olddb = $data[$j]['db'];
                    $oldcr = $data[$j]['cr'];
                }
                $debit = $debit + ($data[$j]['db']);
                $credit = $credit + ($data[$j]['cr']);
            }
                 $debit = $debit - $olddb;
                $credit = $credit - $oldcr;

            $datamodel->fdb = $debit;
            $datamodel->fcr = $credit;
            $datamodel->runningdb = $debit;
            $datamodel->runningcr = $credit;

            if (isset($post['Ladetail'])) {
                $datamodel->acno = $post['Ladetail']['acno'];
                $datamodel->client = $post['Ladetail']['client'];
                $datamodel->clientname = isset($post['Ladetail']['clientname']) ? $post['Ladetail']['clientname'] : '';
                $datamodel->line = $post['Ladetail']['line'];
                $datamodel->acnoname = $post['Ladetail']['acnoname'];
                $datamodel->checkno = $post['Ladetail']['checkno'];
                $datamodel->postdate = $post['Ladetail']['postdate'];
                $datamodel->ref = $post['Ladetail']['ref'];
                $datamodel->refx = $post['Ladetail']['refx'];
                $datamodel->field_focus = $post['Ladetail']['field_focus'];
                $datamodel->linex = $post['Ladetail']['linex'];
                $datamodel->db = strlen($post['Ladetail']['db']) == 0 ? 0 : $post['Ladetail']['db'];
                $datamodel->cr = strlen($post['Ladetail']['cr']) == 0 ? 0 : $post['Ladetail']['cr'];
                $datamodel->runningdb = $post['Ladetail']['fdb'] + $datamodel->db;
                $datamodel->runningcr = $post['Ladetail']['fcr'] + $datamodel->cr;
                
                $line = $datamodel->line;
            }
            //  var_dump($datamodel);
            if ($action == "balance") {
                    $ftotal=$debit-$credit;
                    //echo $ftotal;
                    if($ftotal>=0){Ladetail::insertgl($doc, $trno, $datamodel->client, '\\'.$post['Lahead']['contra'], 0, $ftotal, $datamodel->postdate);}
                    else{Ladetail::insertgl($doc, $trno, $datamodel->client, '\\'.$post['Lahead']['contra'], abs($ftotal), 0, $datamodel->postdate);}
                    $controller->redirect(array('details'));
                }
                
            if ($action == "Save") {
                if ($datamodel->validate()) {
                    // var_dump($line);
                    
                    if ($line == 0) { // insert new detail in ladetail
                        $line = Ladetail::getLastLine($doc,$trno) + 1;
                        Ladetail::insertdetail($trno, $datamodel, $table, $doc);

                        $controller->redirect(array('details'));
                    } else {   //edit detail in ladetail
                        $db = $datamodel->db;
                        $cr = $datamodel->cr;
                        Ladetail::updatedetail($trno, $line, $datamodel, $doc);

                        //$controller->redirect(array('details'));
                        //trigger for userlog
                    }
                } else {                    
                    echo "validation failed";
                }
            }
            if ($action == "cancel") {
                $datamodel->acno = "";
                $datamodel->acnoname = "";
                $datamodel->db = "";
                $datamodel->cr = "";
                $datamodel->runningdb = $datamodel->fdb;
                $datamodel->runningcr = $datamodel->fcr;
            }
            if ($action == "Insert") {
                if (strlen($datamodel->acno) < 2) {
                    $title = 'Account number required';
                    $message = 'Please select an account number';
                    //Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                    //$this->redirect(array('details&action=add'));
                } else {
                    Ladetail::insertdetail($trno, $datamodel, $table, $doc);
                    //$controller->redirect(array('details'));
                }
            }

            //if(isset($post['Ladetail']['field_focus'])){
            //$this->showmsg($datamodel->field_focus, $post['Ladetail']['field_focus']);}
            //var_dump($post);
            $controller->render('details', array('data' => $data, 'model' => $model, 'datamodel' => $datamodel));
                
    }
    
    function ajaxmanagedetail($controller, $get, $post, $accessviewdetails) {
            $data = "";
            $doc = $controller->module->id;
            unset(Yii::$app->session['message'.$doc]);
            $trno = Yii::$app->session['trno' . $doc];
            $table = Common::localdetail($doc);
            $model = new Lahead();
            $datamodel = new Ladetail();
            $common = new Common();
            $action = "";

            if (isset($post['Ladetail']['action'])) {
                $action = $post['Ladetail']['action'];
            }
            
            if(isset($post['Ladetail'])){$datamodel->attributes = $post['Ladetail'];}
            
            $datamodel->client = Yii::$app->session['supplier' . $doc];
            $datamodel->clientname = Common::getclientname(Yii::$app->session['supplier' . $doc]);
            
            if (isset($post['Ladetail']['line'])) {
                $line = $post['Ladetail']['line'];
            }else {
                $line = 0;
            }
            
            $detail = Ladetail::opendetailline($trno,$line);
            
            if(empty($datamodel->postdate)){
               $datamodel->postdate = Yii::$app->session['headdate' . $doc];            
            }
            
            $data = Ladetail::opendetail($trno);
            $debit = 0;
            $credit = 0;
            $olddb = 0;
            $oldcr = 0;
            for ($j = 0; $j < count($data); $j++) {
                if ($line == $data[$j]['line']) {
                    $olddb = $data[$j]['db'];
                    $oldcr = $data[$j]['cr'];
                }
                $debit = $debit + ($data[$j]['db']);
                $credit = $credit + ($data[$j]['cr']);
            }
                $debit = $debit - $olddb;
                $credit = $credit - $oldcr;

            $datamodel->fdb = $debit;
            $datamodel->fcr = $credit;
            $datamodel->runningdb = $debit;
            $datamodel->runningcr = $credit;

            if (isset($post['Ladetail'])) {
                $datamodel->acno = $post['Ladetail']['acno'];
                $datamodel->client = $post['Ladetail']['client'];
                $datamodel->clientname = isset($post['Ladetail']['clientname']) ? $post['Ladetail']['clientname'] : '';
                $datamodel->line = $post['Ladetail']['line'];
                $datamodel->acnoname = $post['Ladetail']['acnoname'];
                $datamodel->checkno = $post['Ladetail']['checkno'];
                $datamodel->postdate = $post['Ladetail']['postdate'];
                $datamodel->ref = $post['Ladetail']['ref'];
                $datamodel->refx = $post['Ladetail']['refx'];
                $datamodel->field_focus = $post['Ladetail']['field_focus'];
                $datamodel->linex = $post['Ladetail']['linex'];
                $datamodel->db = strlen($post['Ladetail']['db']) == 0 ? 0 : $post['Ladetail']['db'];
                $datamodel->cr = strlen($post['Ladetail']['cr']) == 0 ? 0 : $post['Ladetail']['cr'];
                $datamodel->runningdb = $post['Ladetail']['fdb'] + $datamodel->db;
                $datamodel->runningcr = $post['Ladetail']['fcr'] + $datamodel->cr;
                
                $line = $datamodel->line;
                
                if ($line != 0 && $action=='Save'){
                        $datamodel->editacno = $post['Ladetail']['editacno'];
                        $datamodel->editacnoname = $post['Ladetail']['editacnoname'];                
                        $datamodel->editpostdate = $post['Ladetail']['editpostdate'];
                        $datamodel->editref = $post['Ladetail']['editref'];
                        $datamodel->editrem = $post['Ladetail']['editrem'];
                        $datamodel->editdb = strlen($post['Ladetail']['editdb']) == 0 ? 0 : $post['Ladetail']['editdb'];
                        $datamodel->editcr = strlen($post['Ladetail']['editcr']) == 0 ? 0 : $post['Ladetail']['editcr'];
                        switch ($doc)
                        {
                            case "CV": case "GJ": case "CR":
                                $datamodel->editcheckno = $post['Ladetail']['editcheckno'];
                                break;
                        }
                }
              
            }
            
                
            if ($action == "Save") {
                
                    if ($line == 0) { // insert new detail in ladetail
                        if ($datamodel->validate()) {
                            $line = Ladetail::getLastLine($doc,$trno) + 1;                            
                            Ladetail::insertdetail($trno, $datamodel, $table, $doc);    
                                                      
                        }
                    } else {   //edit detail in ladetail
                        $datamodel->acno = $datamodel->editacno;
                        $datamodel->acnoname = $datamodel->editacnoname;
                        $datamodel->postdate = $datamodel->editpostdate;
                        $datamodel->ref = $datamodel->editref;
                        $datamodel->rem = $datamodel->editrem;                        
                        $datamodel->db = str_replace(",","",$datamodel->editdb);
                        $datamodel->cr = str_replace(",","",$datamodel->editcr);
                        $datamodel->fdb = str_replace(",","",$datamodel->editfdb);
                        $datamodel->fcr = str_replace(",","",$datamodel->editfcr);
                        //$datamodel->refx = str_replace(",","",$datamodel->editrefx);
                        //$datamodel->linex = str_replace(",","",$datamodel->editlinex);
                        
                        switch ($doc)
                        {
                            case "CV": case "GJ": case "CR":
                                $datamodel->checkno = $datamodel->editcheckno;
                                break;
                        }

                        
                        if ($datamodel->validate()) {
                            $db = $datamodel->db;
                            $cr = $datamodel->cr;
                            Ladetail::updatedetail($trno, $line, $datamodel, $doc);                            $cr = $datamodel->cr;

                        }
                    }
                
            }
            
            if ($action == "Insert") {
                if (strlen($datamodel->acno) < 2) {
                    $title = 'Account number required';
                    $message = 'Please select an account number';
                    //echo $title.' '.$message;
                    Yii::$app->session['message'.$doc] = Yii::$app->session['message'.$doc] . '<br />' . $title. '<br />' .$message;
                } else {
                    Ladetail::insertdetail($trno, $datamodel, $table, $doc);
                }
            }
            
            if ($action == "delete") {
                    if ($line != 0) {
                        Ladetail::deletedetail_($doc, $trno, $line);                        
                   if(!empty($detail)){
                    if($detail[0]['refx']!=0){
                       $datamodel->refx=$detail[0]['refx'];
                       $datamodel->linex=$detail[0]['linex'];              
                       $datamodel->acno=$detail[0]['acno'];
                     if(Apledger::updatebal($datamodel->refx, $datamodel->linex, $datamodel, $doc,1)==1){
                         
                        }
                      }
                    }  
                        
                    }
                }
                
    }
    
    function managedetail($controller, $get, $post, $accessviewdetails) {
        if (Yii::$app->user->access[$accessviewdetails] != 1) { // unallow viewing of accounting transactions   
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to View Accounting Transactions under this module';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('//site/index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {
            
            $this->managedetailonly($controller, $get, $post, $accessviewdetails);
        }          
    }
    
    function lookup($controller, $post,$allbranch) {
        if (!isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        if (isset($post) && !empty($post)) {
            $doc = $controller->module->id;
            switch ($doc) {
                // SALON MODIFICATION
                case 'PO':case'SO':case'PC': case 'PR': case 'QT':case 'TR':
                // END SALON
                   $table='Transnum';
                   $model = new Transnum();
                    break;
                default:
                    $table='Cntnum';
                    $model = new Cntnum();
                    break;
            }
            
            if (isset($post[$table]['keyword'])) {
                $model->keyword = $_POST[$table]['keyword'];
            }
            if (isset($post[$table]['date'])) {
                $model->date = $post[$table]['date'];
            }
           
            $controller->render('//site/lookup_', array('model' => $model,'allbranch'=>Yii::$app->user->access[$allbranch]));
        } else {
            $controller->redirect(array('//site/index'));
        }
    }
    
    function qtlookup($controller, $post,$get) {
        if (!isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        if (isset($post) && !empty($post)) {
            $doc = $controller->module->id;
            $table='Transnum';
            $model = new Transnum();
    
            if (isset($post[$table]['keyword'])) {
                $model->keyword = $_POST[$table]['keyword'];
            }
            if (isset($post[$table]['date'])) {
                $model->date = $post[$table]['date'];
            }
            
            if (isset($get['inputid'])){
                $model->action = $get['inputid'];
                
            }
          
            $controller->render('//site/lookup_', array('model' => $model));
        } else {
            $controller->redirect(array('//site/index'));
        }
    }
    
        function customlookup($controller, $post,$doc,$allbranch) {
        if (!isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        if (isset($post) && !empty($post)) {
            switch ($doc) {
                case 'PO':case'SO':case'PC': case 'PR':
                   $table='Transnum';
                   $model = new Transnum();
                    break;
                default:
                    $table='Cntnum';
                    $model = new Cntnum();
                    break;
            }
            
            if (isset($post[$table]['keyword'])) {
                $model->keyword = $_POST[$table]['keyword'];
            }
            if (isset($post[$table]['date'])) {
                $model->date = $post[$table]['date'];
            }
           
            $controller->render('//site/customlookup_', array('model' => $model,'doc'=>$doc,'allbranch'=>Yii::$app->user->access[$allbranch]));
        } else {
            $controller->redirect(array('//site/index'));
        }
    }
    
    function printmodule($controller) {
            $model = new Reports();
            $controller->render('//site/_reportparams',array('model'=>$model));
    }
    
    function post($controller,$post,$accesspost) {
        if (!isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        if (Yii::$app->user->access[$accesspost] == 1) {

            $doc=$controller->module->id;
            $Openhead=$this->gettranstype($doc);
            if (empty($post) || !isset($post)) {
                $controller->redirect(array('//site/index'));
            } else {
                $trno = Yii::$app->session['trno' . $doc];
                if($Openhead=='Lahead'){
                    switch ($doc) {
                        case 'RR':case 'DM':case 'PV':case 'CV':case 'SJ':case 'CM':case 'CR':case 'AJ':case 'GJ':case 'IS':case 'AR':case 'AP': case 'CH':
                            case 'MI':
                             if (Cntnum::IsbalancedTrans($trno, $doc)) {
                                 $posting = Cntnum::PostTrans($trno, $doc);
                                 if ($posting != 1) {
                                   $title = 'Error';
                                   $message = $posting;
                                    $message .= '<br />';
                                    Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                                    $controller->redirect(array('index'));                                     
                                 }else{
                                     Yii::$app->session['posted' . $doc] = Cntnum::isPosted($trno,$doc);
                                     $controller->redirect(array('index'));                                     
                                 }

                             }else{
                                  $title = 'Unbalance';
                                  $message = 'Sorry, unbalanced transactions cannot be posted ';
                                  $message .= '<br />';
                                  Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                                  $controller->redirect(array('index'));
                             }
                            break;
                      default:  
                                $posting = Cntnum::PostTrans($trno, $doc);                         
                                if ($posting != 1) {
                                  $title = 'Error';
                                  $message = $posting;
                                  $message .= '<br />';
                                  Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                                  $controller->redirect(array('index'));
                                 }else
                                 {
                                   Yii::$app->session['posted' . $doc] = Cntnum::isPosted($trno,$doc);
                                   $controller->redirect(array('index'));
                                     
                                 }
                            break;
                    }
                }
                else
                    {
                            if (Common::getcompanyid()==5){
                                if ($doc =='SO'){
                                    if (Transnum::isbalancedSO($trno,$doc)){
                                        goto posting;
                                    }else{
                                        $title = 'Unpaid';
                                        $message = 'Sorry, unpaid transactions cannot be posted ';
                                        $message .= '<br />';
                                        $this->showmsg($title,$message);
                                        $controller->redirect(array('index'));
                                    }
                                        
                                }
                            }
                                posting:
                                $posting = Transnum::PostTrans($trno, $doc);                         
                                if ($posting != 1) {
                                  $title = 'Error';
                                  $message = $posting;
                                  $message .= '<br />';
                                  Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
                                    $controller->redirect(array('index'));
                                 }else{
                                    Yii::$app->session['posted' . $doc] = Cntnum::isPosted($trno,$doc);
                                    $controller->redirect(array('index'));
                                     
                                 }
                                 
                }
                
            }
        } else {
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to Post Transactions ';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        }
    }
    
    function unpost($controller,$post,$accessunpost) {
        if (!isset($post) && empty($post)) {
            $title = 'Unauthorized';
            $message = 'Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        $doc = $controller->module->id;
        if (Yii::$app->user->access[$accessunpost] == 1) {
            $trno = Yii::$app->session['trno' . $doc];
             $Openhead=$this->gettranstype($doc);
             if($Openhead=='Lahead'){
                 $unposting = Cntnum::UnpostTrans($trno, $doc);
             }else{
                 $unposting = Transnum::UnpostTrans($trno, $doc);
             }

            if ($unposting != 1) {
                $title = 'Error';
                $message = $unposting;
                $message .= '<br />';
                Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            }
            Yii::$app->session['posted' . $doc] = Cntnum::isPosted($trno,$doc);

            $controller->redirect(array('index'));
            
        } else {
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to UnPost Transactions ';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        }
    }
    
    function accept($controller, $gpost) {
        
        if (isset($gpost) && !empty($gpost)) {
            $doc = $controller->module->id;
            $Openhead = $this->gettranstype($doc);
            if($Openhead=='Lahead'){
                $stock_ = new Lastock();
                $tablenum ='Cntnum';
                }
            else{
                $stock_ = new Postock();
                $tablenum='Transnum';
                }
            
            $trno = Yii::$app->session['trno' . $doc];
            

            $done = false;

            foreach ($gpost as $post => $key) {
                $voidthisitem['line']=0;
                     $voidthisitem['trno']=0;
                if ($post != $tablenum && $post != 'OK') {
                    $item = explode('-', $post);
                    if (preg_match("/void/", $post)) {
                        $voidthisitem = Lookup::openthisitem($item[1], $item[2], $doc);
                        Postock::voiditem($voidthisitem['line'], $voidthisitem['trno'], $doc);
                        //VAR_DUMP($item);
                    } elseif (isset($gpost[$post]) && !isset($gpost['void-' . $item[0] . '-' . $item[1]])) {

                        $thisitem = Lookup::openthisitem($item[0], $item[1], $doc);

                        if ($thisitem) {
                            //$line++;
                            $stock_->barcode = $thisitem['barcode'];
                            $stock_->itemname = $thisitem['itemname'];
                            $factor = Item::getFactor($thisitem['barcode'], $thisitem['uom']);
                            $stock_->rrqty=0;
                            $stock_->qty=0;
                            $stock_->isqty=0;
                            $stock_->iss=0;
                            $stock_->comm=0;
                            $stock_->icomm=0;
                            switch ($doc) {
                                case 'PO':
                                case 'RR':
                                case 'CA':    
                                   $stock_->rrcost = $thisitem['rrcost'];                            
                                   $stock_->cost = $thisitem['cost'];
                                   $stock_->rrqty = $thisitem['pending'] / $factor;
                                   $stock_->qty = $thisitem['pending'];                                  
                                    break;
                                 case 'SJ': case 'DM': case 'TS':case'PU':case 'CH':
                                  $stock_->isamt=$thisitem['rrcost'];
                                  $stock_->amt=$thisitem['cost'];                                     
                                  $stock_->isqty=$thisitem['pending']/$factor;
                                  $stock_->iss=$thisitem['pending'];
                                  $stock_->loc = $thisitem['loc']; 
                                     break;
                                 case 'CM':
                                  $stock_->isamt=$thisitem['rrcost'];
                                  $stock_->amt=$thisitem['cost'];                                     
                                  $stock_->rrqty=$thisitem['pending']/$factor;
                                  $stock_->qty=$thisitem['pending'];
                                  $stock_->cost=$thisitem['cost2'];
                                     break;
                                default:
                                   $stock_->rrcost = $thisitem['rrcost'];                            
                                   $stock_->cost = $thisitem['cost'];
                                  $stock_->isamt=$thisitem['rrcost'];
                                  $stock_->amt=$thisitem['cost'];                                     
                                    break;
                            }

                            $stock_->ext =  $thisitem['cost']*$thisitem['pending'];

                            $stock_->disc = $thisitem['disc'];
                            
                            $stock_->uom = $thisitem['uom'];
                            
                            switch ($doc) {
                                case 'RR':
                                    $stock_->loc = $thisitem['loc'];                                  
                                    break;
                                case 'TS':case'PU':
                                    $stock_->loc = $thisitem['locname'];                                                                  
                            }
                            
                            switch ($doc) {
                                case 'PO':
                                    $stock_->wh_ =Lahead::rrwarehouse($doc,$trno);
                                    $stock_->loc =$thisitem['locname'];
                                    break;
                                default:
                                    $stock_->wh_ =Lahead::rrwarehouse($doc,$trno);
                                    break;
                            }
                            
                            
                            $stock_->ref =$thisitem['docno'];
                           
                                  $stock_->refx = $thisitem['trno'];
                                  $stock_->linex = $thisitem['line'];                                    

                                  $stock_->qa = 0;
                            $stock_->void = 0;
                            
                            if($Openhead=='Lahead'){
                                Lastock::insertstock($doc, $trno, $stock_,0);
                                $done = true;
                            }else{
                                Postock::insertstockaccept($doc, $trno, $stock_);
                                $done = false;
                                //Postock::setserveditems($stock_->linex, $stock_->refx, $doc);
                            }
                            
                        }
                    }
                } else {

                }
            }
            if ($done) {
                if ($trno != "" && !Yii::$app->session['posted' . $doc]) {
                    $trno_ = md5($trno);
                    $controller->actiondistribute($trno_);
                }
                $controller->redirect(array('stocks'));
            } else {
                $controller->redirect(array('stocks'));
            }
        } else {
            $controller->redirect(array('//site/logout'));
        }
    }
    

    
   function customaccept($controller, $gpost,$doc2) {        
        if (isset($gpost) && !empty($gpost)) {
            $doc = $controller->module->id;
            $Openhead = $this->gettranstype($doc);
            if($Openhead=='Lahead'){
                $stock_ = new Lastock();
                $tablenum ='Cntnum';
                }
            else{
                $stock_ = new Postock();
                $tablenum='Transnum';
                }
            
            $trno = Yii::$app->session['trno' . $doc];
            

            $done = false;

            foreach ($gpost as $post => $key) {
                if ($post != $tablenum && $post != 'OK') {
                    $item = explode('-', $post);
                    if (isset($gpost[$post]) && !isset($gpost['void-' . $item[0]])) {
                        $thisitem = Lookup::openthistrans($item[0], $doc2);
                        for ($i=0; $i<count($thisitem); $i++)
                        {
                            
                            $stock_->barcode = $thisitem[$i]['barcode'];
                            $stock_->itemname = $thisitem[$i]['itemname'];
                            $factor = Item::getFactor($thisitem[$i]['barcode'], $thisitem[$i]['uom']);
                            $stock_->rrqty=0;
                            $stock_->qty=0;
                            $stock_->isqty=0;
                            $stock_->iss=0;
                            $stock_->comm=0;
                            $stock_->icomm=0;
                            switch ($doc) {
                                case 'RR':
                                case 'CA':    
                                   $stock_->rrcost = $thisitem[$i]['rrcost'];                            
                                   $stock_->cost = $thisitem[$i]['cost'];
                                   $stock_->rrqty = $thisitem[$i]['pending'] / $factor;
                                   $stock_->qty = $thisitem[$i]['pending'];                                  
                                    break;
                                 case 'SJ': case 'DM': case 'TS':case'PU':
                                  $stock_->isamt=$thisitem[$i]['rrcost'];
                                  $stock_->amt=$thisitem[$i]['cost'];                                     
                                  $stock_->isqty=$thisitem[$i]['pending']/$factor;
                                  $stock_->iss=$thisitem[$i]['pending'];
                                     break;
                                 case 'CM':
                                  $stock_->isamt=$thisitem[$i]['rrcost'];
                                  $stock_->amt=$thisitem[$i]['cost'];                                     
                                  $stock_->rrqty=$thisitem[$i]['pending']/$factor;
                                  $stock_->qty=$thisitem[$i]['pending'];
                                  $stock_->cost=$thisitem[$i]['cost2'];
                                     break;
                                default:
                                   $stock_->rrcost = $thisitem[$i]['rrcost'];                            
                                   $stock_->cost = $thisitem[$i]['cost'];
                                  $stock_->isamt=$thisitem[$i]['rrcost'];
                                  $stock_->amt=$thisitem[$i]['cost'];                                     
                                    break;
                            }

                            $stock_->ext =  $thisitem[$i]['cost']*$thisitem[$i]['pending'];

                            $stock_->disc = $thisitem[$i]['disc'];
                            
                            $stock_->uom = $thisitem[$i]['uom'];
                            
                            switch ($doc) {
                                case 'RR':
                                    $stock_->loc = $thisitem[$i]['loc'];                                  
                                    break;
                                case 'TS':case'PU':
                                    $stock_->loc = $thisitem[$i]['locname'];                                                                  
                            }
                            
                            switch ($doc) {
                                case 'PO':
                                    $stock_->wh_ =Lahead::rrwarehouse($doc,$trno);
                                    $stock_->loc =$thisitem[$i]['locname'];
                                    break;
                                default:
                                    $stock_->wh_ =Lahead::rrwarehouse($doc,$trno);
                                    break;
                            }
                            
                            
                            $stock_->ref =$thisitem[$i]['docno'];
                           
                                  $stock_->refx = $thisitem[$i]['trno'];
                                  $stock_->linex = $thisitem[$i]['line'];                                    
                                  $stock_->qa = 0;
                            $stock_->void = 0;
                            
                            if($Openhead=='Lahead'){
                                Lastock::insertstock($doc, $trno, $stock_,0);
                                $done = true;
                            }else{
                                Postock::insertstockaccept($doc, $trno, $stock_);
                                $done = false;
                            }
                            
                        } 
                        
                    }
                } else {

                }
            }
            if ($done) {
                if ($trno != "" && !Yii::$app->session['posted' . $doc]) {
                    $trno_ = md5($trno);
                    $controller->actiondistribute($trno_);
                }
                $controller->redirect(array('stocks'));
            } else {
                //$controller->redirect(array('stocks'));
            }
        } else {
            $controller->redirect(array('//site/logout'));
        }
    }

    
    function detaillookup($controller,$POST)
    {
        if (isset($POST) && !empty($POST)) {
            $model=new Cntnum();

            if (isset($POST['Cntnum']['keyword'])) {
                $model->keyword=$POST['Cntnum']['keyword'];
            }
            if (isset($POST['Cntnum']['date'])) {
                $model->date=$POST['Cntnum']['date'];
            }
            $controller->render('//site/lookup_',array('model'=>$model));
        }
        else {
            $controller->redirect(array('//site/index'));
        }
    }    
    
    function detailaccept($controller,$POST,$GET){
        if (isset($POST) && !empty($POST)) {
            $action="";
            if(isset($GET['action'])) {
                $action=$GET['action'];
            }
            $module=$controller->module->id;
            $detail=new Ladetail();
            $detail->depodate=Yii::$app->session['headdate' . $controller->module->id];
            $detail->postdate=Yii::$app->session['headdate' . $controller->module->id];
            $trno=Yii::$app->session['trno' . $controller->module->id];
            $client=Yii::$app->session['supplier' . $module];
            $line=Lastock::getLastLine($controller->module->id,$trno)+1;

            $done=false;
            $totcheck = 0;
            $db=0;
            $cr=0;
            if($action=='unpaid' || $action=='checks') {
                foreach($POST as $post1 => $key) {
                    if($post1!='Cntnum' && $post1!='OK') {
                        $item=explode('-', $post1);
                        $thisitem=Lookup::openthisitem($item[0], $item[1], $module,$action);

                        $detail->docno=Cntnum::getdocno($trno,$controller->module->id);
                        $detail->acno=Ladetail::getacno_($thisitem['acnoid']);
                        $detail->acnoname=$thisitem['acnoname'];
                        $detail->client=Client::getclient($thisitem['clientid']);
                        $detail->alias=$thisitem['alias_'];
                        $db=$thisitem['db'];
                        $cr=$thisitem['cr'];
                        $bal_=$db-$cr;
                        if($action=='checks'){
                            if(strlen($thisitem['depodate'])==0){
                            $detail->db=$thisitem['cr'];
                            $detail->cr=$thisitem['db'];
                            $detail->postdate=$thisitem['checkdate'];
                            $detail->checkno=$thisitem['checkno'];
                            }
                        }else{
                         $detail->dateid=$thisitem['dateid'];    
                         $detail->postdate=$thisitem['dateid'];    
                        if($bal_>0) {
                            $detail->db=0;
                            $detail->cr=$thisitem['bal'];
                        }
                        else {
                            $detail->db=$thisitem['bal'];
                            $detail->cr=0;                            
                            }
                        }
                        $detail->ref=$thisitem['docno'];
                        $detail->refx=$thisitem['trno'];
                        $detail->linex=$thisitem['line'];
                        $done=Ladetail::insert($trno, $detail,$module);
                        
                        
                        if(!$done){
                            $this->showmsg('Warning', 'Failed to add accounts...');
                        }
                    }
                $totcheck = $totcheck + ($db-$cr);    
                }
                
                if ($module=='DS'){
                    $dshead= Lahead::openhead($trno,'Lahead');
                    if(!empty($dshead)){
                        $detail->acno = $dshead[0]['contra'];
                        $detail->acnoname = $dshead[0]['clientname'];
                        $detail->postdate = $dshead[0]['dateid'];
                        $detail->ref='';
                        $detail->refx=0;
                        $detail->linex=0;
                        $detail->cr=0;
                        $detail->checkno='';
                        $detail->client ='';
                        
                        $exist = Ladetail::getdetailbank($trno,$detail->acno);
                        
                        if (!empty($exist)){
                            $tc = Ladetail::getdstotal($trno,$module);
                            
                            if(!empty($tc)){
                                $totcheck=$tc[0]['totalcr']-$tc[0]['totaldb'];
                                $this->showmsg('a',$totcheck);
                                $detail->db = $totcheck;
                                $done=Ladetail::updatedetail($trno,$exist[0]['line'],$detail,$module);
                            }                            
                            
                        }else{
                            $detail->db = $totcheck;
                            $done=Ladetail::insert($trno, $detail,$module);    
                        }
                        
                    }                   
                }
            }

            $controller->redirect(array('details'));
        }
        else {
            $controller->redirect(array('//site/logout'));
        }

        }
    
    function logs($controller,$post,$module='') {
        if(!isset($post) && empty($post)) {
            $title='Unauthorized';
            $message='Invalid URL';
            $message .= '<br />';
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('//site/index'));
        }
        $controller->layout = '//layouts/slayout';
        $model = new Log();
        $doc = $controller->module->id;        
        
        if($module==''){
        $trno = Yii::$app->session['trno' . $doc];
        $data = $model->getlogs($doc, $trno);        
        }
        elseif($module=='TERMS'){
            $data = $model->getlogsterms();        
        }
        elseif($module=='USERACCESS'){
            $data = $model->getlogsuseraccess();        
        }       
        
        else{
            $doc=$module;
            if($module=='items'){
                $trno = $post['Item']['itemid'];
            }else{
               $trno =Yii::$app->session['clientid' . $doc];
            }
            $data = $model->getlogs($doc, $trno);
            
            }        
        $controller->render('//site/logs', array('model' => $model, 'data' => $data,'doc'=>$doc));
    }
    
    
    function checkitemexist($controller,$get) {

        $barcode = $get['barcode'];
        $doc = $controller->module->id;
        $trno = Yii::$app->session['trno' . $doc];
        $itemcount=0;
        $itemcount = Lastock::checkstock($trno, $barcode,$doc);

        if ($itemcount == 0) {
            return false;
        } else {
            return true;
        }

    }


   public static function autodistribute($controller,$trno) {
        $doc = $controller->module->id;
        $head = Lahead::openhead($trno, $doc);
        $contra = "";
        $tax = 0;
        $dateid = "";
        if ($head != null) {
            $contra = $head[0]['contra'];
            $tax = isset($head[0]['tax'])? $head[0]['tax'] : 0;
            $dateid = $head[0]['dateid'];
        }
        
        $result = Ladetail::deletedetail($doc, $trno);
        $w=Ladetail::autoinsertdetail($doc, $trno, $contra, $tax, $dateid); 
        return $w;
    }
    
    public static function showmsg($title,$message){
              $message .= '<br />';
    }//

    
 public static function sanitize($poster) {
	$poster = trim($poster);
//this line needs mysql connection
//$poster = mysql_real_escape_string($poster);
  if(function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc())
{
$poster = stripslashes($poster);
}
  $poster = strip_tags($poster);
  $poster = str_replace(array("\n", "'", "‘", "’", "'", "“", "�?", "„", "?", '"'), array("", "\’", "\’", "\’", "\’", "\"", "\"", "\"", "\"", "\""), $poster);
    return $poster;    
}


public function main_List_of_Unposted($i)
{
    $sql="Select 'Purchase Order' as module,count(trno) as total from transnum where doc='PO' and postdate is null
          union all
          Select 'Receiving Report' as module,count(trno) as total from cntnum where doc='RR' and postdate is null
          union all
          Select 'Purchase Return' as module,count(trno) as total from cntnum where doc='DM' and postdate is null
          union all
          Select 'Sales Order' as module,count(trno) as total from transnum where doc='SO' and postdate is null
          union all
          Select 'Sales Journal' as module,count(trno) as total from cntnum where doc='SJ' and postdate is null
          union all
          Select 'Sales Return' as module,count(trno) as total from cntnum where doc='CM' and postdate is null
          union all
          Select 'Account Payable Voucher' as module,count(trno) as total from cntnum where doc='PV' and postdate is null
          union all
          Select 'Check Voucher' as module,count(trno) as total from cntnum where doc='CV' and postdate is null
          union all
          Select 'Receive Payment' as module,count(trno) as total from cntnum where doc='CR' and postdate is null
          union all
          Select 'General Journal' as module,count(trno) as total from cntnum where doc='GJ' and postdate is null

          
";
    
      $data= Yii::$app->sbccommon->opentable($sql);
      if(count($data)>0){
              echo '<div class="index_table" id="table'.$i.'">';
              echo '<div class="index_table_head">List of Unposted Modules <img src="images/see_more_btn.png" class="see_more_btn alt" title="Expand Table" ></div>';
              echo '<table class="sample_table">';

          for($i=0;$i<count($data);$i++){
              echo '<tr>';
              echo '<td  style=text-align:left;width:50px >'.$data[$i]['module'].'</td>';
              echo '<td>'.$data[$i]['total'].'</td>';
              echo '</tr>';
          }
           echo '</table>';
           echo '</div>';
      }                

}


public function main_List_of_customerAR($i)
{
    $sql="select lahead.client,lahead.clientname,sum(ladetail.db) as bal from lahead left join ladetail on ladetail.trno=lahead.trno left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='AR'
         union all
         select client.client,client.clientname,arledger.db from arledger left join client on client.clientid=arledger.clientid where arledger.bal<>0 limit 20";
    
    $sql ="select client,clientname,sum(bal) as bal from (".$sql.") as t group by client,clientname";
          $data= Yii::$app->sbccommon->opentable($sql);
      if(count($data)>0){
              echo '<div class="index_table" id="table'.$i.'">';
              echo '<div class="index_table_head">List of Outstanding Customer Receivable <img src="images/see_more_btn.png" class="see_more_btn alt" title="Expand Table" ></div>';
              echo '<table class="sample_table">';

          for($i=0;$i<count($data);$i++){
              echo '<tr>';
              echo '<td  style=text-align:left;width:50px >'.$data[$i]['clientname'].'</td>';
              echo '<td>'.$data[$i]['bal'].'</td>';
              echo '</tr>';
          }
           echo '</table>';
           echo '</div>';
      }                
}


public function main_List_of_SupplierAP($i)
{
    $sql="select client,clientname,sum(bal) as bal from (select lahead.client,lahead.clientname,sum(ladetail.db) as bal from lahead left join ladetail on ladetail.trno=lahead.trno left join coa on coa.acno=ladetail.acno where left(coa.alias,2)='AP'
         union all
         select client.client,client.clientname,apledger.cr from apledger left join client on client.clientid=apledger.clientid where apledger.bal<>0 limit 20) as t";

    $sql ="select client,clientname,sum(bal) as bal from (".$sql.") as t group by client,clientname";
    
          $data= Yii::$app->sbccommon->opentable($sql);
      if(count($data)>0){
              echo '<div class="index_table" id="table'.$i.'">';
              echo '<div class="index_table_head">List of Outstanding Supplier Payables <img src="images/see_more_btn.png" class="see_more_btn alt" title="Expand Table" ></div>';
              echo '<table class="sample_table">';

          for($i=0;$i<count($data);$i++){
              echo '<tr>';
              echo '<td  style=text-align:left;width:50px >'.$data[$i]['clientname'].'</td>';
              echo '<td>'.$data[$i]['bal'].'</td>';
              echo '</tr>';
          }
           echo '</table>';
           echo '</div>';
      }                
}

    public function addnewitemsIS($controller) {
        $doc = $controller->module->id;
        $trno= Yii::$app->session['trno' . $doc];
        $doc = $controller->module->id;
        $last_line = Lastock::getLastLine($doc,$trno)+1;
        $stocku="select '$trno' as trno,'$last_line' as line, item.barcode, concat(item.part,' ',item.model,' ',item.class,' ',item.brand,' ',item.itemname,' ',item.body) as itemname, item.uom
                from item where IfNull((select barcode from lastock where lastock.trno='$trno' and lastock.barcode=item.barcode),'')='' order by itemname
                ";
        $datas= Yii::$app->sbccommon->opentable($stocku);
        
        for($i=0;$i<count($datas);$i++){
            
            $ret = Yii::$app->sbccommon->execqry("insert into lastock(trno,line, barcode, itemname, uom) values (". $datas[$i]['trno'] . "," .$last_line. ",'" .$datas[$i]['barcode']. "','" .$datas[$i]['itemname']. "','" .$datas[$i]['uom']. "')");
            //$sql="insert into lastock(trno,line, barcode, itemname, uom) values ($trno ," .$last_line. ",'" .$datas[$i]['barcode']. "','" .$datas[$i]['itemname']. "','" .$datas[$i]['uom']. "')";
            $last_line=$last_line+1;
        }
       //var_dump($ret);
        $controller->redirect(array('index'));
    }
    
    
//start here <new stock encoding-JAC>
function ajaxmanagestock($controller, $get, $post, $accessedit) {
    
        $doc = $controller->module->id;
        if (Yii::$app->session['posted' . $doc]) {
            $controller->redirect(array('index'));
        }
        $Openstock = $this->getstocktype($doc);
        $common = new Common();
        //$trans = null;
      
        if ($Openstock == 'Lastock') {
            $data_ = new Lastock();
            $model_ = new Lastock();
          
            
        } else {
            $data_ = new Postock();
            $model_ = new Postock();
           
        }
        
        $action = "";
        $stock = "";
        $filter="";
        $blnitemrepeated = "";
        $forex= 1;
        $trno = Yii::$app->session['trno' . $doc];

        /** forex **/
        $head = Lahead::openhead($trno, $doc);
        if ($head != null) {
           $forex = isset($head[0]['forex'])? $head[0]['forex'] : 1;
        }



        if (isset($post[$Openstock]['action'])) {          
            if (((isset($get['action']) && $get['action'] == 'edit') || (isset($get['action']) && $get['action'] == 'delete')) && ($post[$Openstock]['action'] != 'cancel' && $post[$Openstock]['action'] != 'Save' && $post[$Openstock]['action'] != 'compute')) {
                $action = $get['action'];
            } else {
                if (strlen($post[$Openstock]['action']) != 0) {
                    $action = $post[$Openstock]['action'];
                } else {
                    $action = $get['action'];
                }
            }
        } else {            
            if (((isset($get['action']) && $get['action'] == 'edit') || (isset($get['action']) && $get['action'] == 'delete') || (isset($get['action']) && $get['action'] == 'adjust'))) {
                $action = $get['action'];
            }
        }
        //$model_->action=$action;

        if (Yii::$app->user->access[$accessedit] != 1) { // allow editing of transactions
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to Edit transactions';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        } else {
            if (isset($post[$Openstock])) {
                
                $model_->attributes = $post[$Openstock];
                $model_->action = $action;
                $filter = $post[$Openstock]['keyword'];
                
                if ($action=='add'){
                        $price = Item::getLatestPrice($doc,$model_->barcode,Yii::$app->session['supplier' . $doc]);  
                       // if(!empty($price)){
                            switch ($doc) {
                              case 'PO':
                              case 'RR':
                              case 'PC':
                              case 'IS':
                              case 'AJ':
                              case 'MI':    
                              case 'CA':    
                              case 'PR':

                        if ($doc != 'MI'){
                        $model_->rrcost=number_format($price['rrcost'],2);
                        $model_->cost=$price['cost'];
                        $model_->uom=$price['uom'];
                        $model_->disc=$price['disc'];
                            switch(Common::getcompanyid()){
                            case 3://cellboy
                                $model_->rem=$price['supplier'];
                            break;
                            }
                        }//

                        $model_->ext = ((Yii::$app->sbccommon->Discount($model_->rrcost,$price['disc'])*$model_->rrqty));
                        $arr = array ('cost'=>$price['cost'],'uom'=>$price['uom'],'rrcost'=>$price['rrcost'],'disc'=>$price['disc'],'total'=>$model_->ext);
                        echo json_encode($arr);
                        break;  

                             case 'DM':
                                  $model_->isamt=number_format($price['rrcost'],2);
                                  $model_->amt=$price['cost'];
                                  $model_->uom=$price['uom'];
                                  $model_->disc=$price['disc'];
                                  $model_->ext = ((Yii::$app->sbccommon->Discount($model_->isamt,$price['disc'])*$model_->isqty));
                                  $arr = array ('amt'=>$price['cost'],'uom'=>$price['uom'],'isamt'=>$price['rrcost'],'disc'=>$price['disc'],'total'=>$model_->ext);
                                  echo json_encode($arr);
                                 break;
                             case 'TS':
                                 $this->unsaveitem_new($post, $model_, $doc, $trno, $Openstock, $action);
                                 break;
                             default :
//                                  if (Common::getcompanyid()==4){
//                                  if($price['amt']!=0){
//                                  $model_->isamt=number_format($price['amt'],2);
//                                  //$model_->amt=$price['amt'];
//                                  $model_->uom=$price['uom'];
//                                  $model_->disc=$price['discount'];}
//                                  } else {
                                  if($price['isamt']!=0){
                                  $model_->isamt=number_format($price['isamt'],2);
                                  $model_->amt=$price['amt'];
                                  $model_->uom=$price['uom'];
                                  $model_->disc=$price['disc'];
                                  //}
                                  $model_->ext = ((Yii::$app->sbccommon->Discount($model_->isamt,$price['disc'])*$model_->isqty));
                                  $arr = array ('amt'=>$price['amt'],'uom'=>$price['uom'],'isamt'=>$price['isamt'],'disc'=>$price['disc'],'total'=>$model_->ext);
                                  echo json_encode($arr);
                                  }
                                  break;
                                  
                            } 
                       // }    
                }
                
                $this->unsaveitem($post, $model_, $doc, $trno, $Openstock, $action,$forex);
                
            }
            
            if($action == "compute" || $action =="editstock"){
               $this->unsaveitem_new($post, $model_, $doc, $trno, $Openstock, $action);
            }
            
            if ($action == "Save" || $action == "Insert") {
                $this->saveinsertstock($controller, $model_, $doc, $trno);             
                
            } elseif ($action == "delete") {
               $line = $post[$Openstock]['line'];
                $linex = $post[$Openstock]['linex'];
                $refx = $post[$Openstock]['refx'];
                $this->deleteitem($controller,$common,$doc, $trno,$line,$refx,$linex);
               
            } elseif ($action == "quickadd") {
                $this->quickadd($controller, $post, $trno, $doc);
            } elseif ($action == "adjust") {

                $this->adjustitem($trno);
                $action = '';
                $controller->redirect(array('stocks'));
            }

            if ($action == "cancel" || $action == "Save" || $action == "Insert") {
                $model_->unsetAttributes();
                if ($action == "cancel") {
                    $controller->redirect(array('stocks'));
                }
            }

            if (isset($get['id'])) {
                $line = $get['id'];
            } else {
                $line = 0;
            }


            if ($Openstock == 'Lastock') {
                $stock = Lastock::openstock($trno, $doc, $filter);
            } else {
                $stock = Postock::openstock($doc, $trno, $filter);
            }



            if ($action == "editstock") {
                if ($Openstock == 'Lastock') {
                    $stock2 = Lastock::openstockline($trno, $line, $doc);
                } else {
                    $stock2 = Postock::openstockline($doc, $trno, $line);
                }
                $this->editstock($controller, $doc, $model_, $stock2, $accessedit, $trno, $line);
            }


            Yii::$app->session['barcode'] = $model_->barcode;
            Yii::$app->session['whcode'] = $model_->wh_;

            if ($action == "item" || $action == "add" || $action == 'edit' || $action == 'compute') {
                if ($action != 'edit') {
                    if ($action == 'compute' && $model_->line != 0) {
                        $model_->action = 'edit';
                    } else {
                        $model_->action = 'item';
                    }
                } else {
                    $model_->action = $action;
                }
            }
        }
        
                        
        $client = Yii::$app->session['supplier' . $doc];
        
        $grandtotal = Lastock::getgrandtotal($trno, $doc);

        $model_->itemcount = isset($grandtotal[0]['itemcount']) ? number_format($grandtotal[0]['itemcount'], 2) : 0;
        $model_->grandtotal = isset($grandtotal[0]['grandtotal']) ? number_format($grandtotal[0]['grandtotal'], 2) : 0;
        if (isset($grandtotal[0]['grandtotal']) && $grandtotal[0]['grandtotal'] == null) {
            $model_->grandtotal = 0;
        }
        if (isset($grandtotal[0]['itemcount']) && $grandtotal[0]['itemcount'] == null) {
            $model_->itemcount = 0;
        }
        if (strlen($blnitemrepeated) != 0) {
            $model_->keyword = $blnitemrepeated;
        }
        
    }

function ajaxGetStat($controller, $get, $post, $accessedit){
        
        $doc = $controller->module->id;
        unset(Yii::$app->session['message' . $doc]);
        $client = Yii::$app->session['supplier' . $doc];
        if (Yii::$app->session['posted' . $doc]) {
            $controller->redirect(array('index'));
        }
        $Openstock = $this->getstocktype($doc);
        $common = new Common();
        //$trans = null;
      
        if ($Openstock == 'Lastock'){
            $data_ = new Lastock();
            $model_ = new Lastock();          
            
        }else {
            $data_ = new Postock();
            $model_ = new Postock();
           
        }
        
        
        $balance = Item::getItembal($post['barcode']);
        $trans = Postock::getpreviousTrans_($doc, $post['barcode'], $client);
        if (count($balance)==0 && count($trans)==0){
            echo "No data to display.";
        }
        if (count($balance)<>0){
                echo '<table>';
                echo '<thead><tr>';
                echo '<td>Warehouse</td>';
                echo '<td>Name</td>';
                echo '<td class="right_digit">Balance</td></tr>';
                echo '</thead>';    
            for ($j = 0; $j < count($balance); $j++) {
                echo '<tr>';
                echo '<td>' . $balance[$j]['client'] . '&nbsp;</td>';
                echo '<td>' . $balance[$j]['clientname'] . '&nbsp;</td>';
                echo '<td class="right_digit">' . $balance[$j]['bal'] . '&nbsp;</td>';
                echo '</tr>';
            
            }
                echo '</table><br><br>';
        }
        
        if  (count($trans)<>0){
                
                echo '<table>';
                echo '<thead><tr>';
                echo '<td>Date</td>';
                echo '<td>Document#</td>';
                echo '<td class="right_digit">Qty</td>';
                echo '<td class="right_digit">Amount</td>';
                echo '<td class="right_digit">Discount</td>';
                echo '<td class="right_digit">Total Price</td></tr>';
                echo '</thead>';
                
            for ($i = 0; $i < count($trans); $i++) {
                echo '<tr>';
                echo '<td>' . $trans[$i]['dateid'] . '&nbsp;</td>';
                echo '<td>' . $trans[$i]['docno'] . '&nbsp;</td>';
                echo '<td class="right_digit">' . $trans[$i]['qty'] . '&nbsp;</td>';
                switch ($doc){
                    case'RR':case'IS':case'AJ':case'TS':case'MI':
                echo '<td class="right_digit">' . $trans[$i]['rrcost'] . '&nbsp;</td>';
                        break;
                    case'SJ':case'DM':case'PU': case 'CH':
                echo '<td class="right_digit">' . $trans[$i]['isamt'] . '&nbsp;</td>';        
                        break;
                    
                }
                echo '<td class="right_digit">' . $trans[$i]['disc'] . '&nbsp;</td>';
                echo '<td class="right_digit">' . $trans[$i]['ext'] . '&nbsp;</td>';
                echo '</tr>';
            }
             echo '</table><br><br>';
        }
        
    }
    
function unsaveitem_new($post, $model_, $doc, $trno, $Openstock, $action) {
        if (isset($post[$Openstock])) {
            if (isset($post['void'])) {
                $model_->void = $post['void'];
            }
            $uom = strtoupper($model_->uom);
            $barcode = $model_->barcode;
            $olduom = strtoupper($model_->olduom);
            $oldfactor = 1;

            $model_->olduom = $uom;
            $factor = Item::getFactor($barcode, $uom);

            if ($factor == "") {
                $factor = 1;
            }
            
            if ($action == "editstock"){
                $uom = strtoupper($post[$Openstock]['edituom']);
                $barcode = $post[$Openstock]['editbarcode'];
                //$disc =$post[$Openstock]['editdisc'];
                $itemname = $post[$Openstock]['editname'];
                
                switch ($doc){ 
                case 'RR':
                    $loc =$post[$Openstock]['editloc'];
                    $ref = $post[$Openstock]['editref'];
                    $rem = $post[$Openstock]['editrem'];
                    $disc =$post[$Openstock]['editdisc'];
                    break;
                case 'IS':
                    $rem = $post[$Openstock]['editrem'];
                    $loc = $post[$Openstock]['editloc'];
                    $disc ="";
                    break;
                case 'PR':
                    $rem = $post[$Openstock]['editrem'];
                    $disc =$post[$Openstock]['editdisc'];
                    break;
                case 'CA':
                case 'CM':
                case 'TS':
                case 'DM':     
                    $loc =$post[$Openstock]['editloc'];
                    $ref = $post[$Openstock]['editref'];
                    $disc =$post[$Openstock]['editdisc'];
                    break;
                case 'MI':     
                    $loc =$post[$Openstock]['editloc'];
                    $ref = "";
                    $disc =$post[$Openstock]['editdisc'];
                    break;
                case 'AJ':   
                    $loc =$post[$Openstock]['editloc'];
                    $ref = "";
                    $disc = "";
                    break;
                case'PU':
                    $loc =$post[$Openstock]['editloc'];
                    $rem = $post[$Openstock]['editrem'];
                    $ref = "";
                    $disc =$post[$Openstock]['editdisc'];
                    break;                
                case 'SJ': case 'CH':
                    $loc =$post[$Openstock]['editloc'];
                    $comm = $post[$Openstock]['editcomm'];
                    $icomm = $post[$Openstock]['editicomm'];
                    $ref = $post[$Openstock]['editref'];
                    $disc =$post[$Openstock]['editdisc'];
                    break;
                case'SO': 
                     $loc =$post[$Openstock]['editloc'];
                     $disc =$post[$Openstock]['editdisc'];
                     break;
                 case 'QT':
                     $loc ="";
                     $disc =$post[$Openstock]['editdisc'];
                     break;
                case'PO': case'PC':
                     $disc =$post[$Openstock]['editdisc'];
                     break; 
                }             
                
                
                switch ($doc) {
                case 'RR':case 'CA': case 'IS': case'AJ': case 'PO': case'PC': case'PR':case'MI': {
                        $displayamt = 'editrrcost';
                        $displayqty = 'editrrqty';
                        $computeamt = 'cost';
                        $computeqty = 'qty';
                        break;
                    }
                case 'CM':
                    $displayamt = 'editisamt';
                    $displayqty = 'editrrqty';
                    $computeamt = 'amt';
                    $computeqty = 'qty';
                    break;

                case 'SJ':case'DM':case'TS':case'SO':case'PU': case 'CH': case 'QT': {
                        $displayamt = 'editisamt';
                        $displayqty = 'editisqty';
                        $computeamt = 'amt';
                        $computeqty = 'iss';
                        break;
                    }
            }
                
            }else{
                $uom = strtoupper($model_->uom);
                $barcode = $post[$Openstock]['barcode'];
                //$disc = $post[$Openstock]['disc'];
                $itemname = $post[$Openstock]['itemname'];
                switch ($doc){
                    case 'PR':
                        $rem = $post[$Openstock]['rem'];
                        $disc = $post[$Openstock]['disc'];
                        break;
                    case'IS':
                        $rem = $post[$Openstock]['rem'];
                        $loc = $post[$Openstock]['loc'];
                        $disc = "";
                        break;
                    case'SO':
                        $loc = $post[$Openstock]['loc'];
                        $disc = $post[$Openstock]['disc'];
                        break;
                     case 'QT':
                        $loc = "";
                        $disc = $post[$Openstock]['disc'];
                        break;
                    case'PO':case'PC':
                        $disc = $post[$Openstock]['disc'];
                        break; 
                    case 'CA': case 'CM': case'TS':case 'DM':
                        $ref = $post[$Openstock]['ref'];
                        $loc = $post[$Openstock]['loc'];
                        $disc = $post[$Openstock]['disc'];
                        break;
                    case'MI':
                        $ref = "";
                        $loc = $post[$Openstock]['loc'];
                        $disc = $post[$Openstock]['disc'];
                        break;
                    case'AJ':
                        $ref = "";
                        $loc = $post[$Openstock]['loc'];
                        $disc = "";
                        break;    
                    case 'SJ': case 'CH':
                        $comm = $post[$Openstock]['comm'];
                        $icomm = $post[$Openstock]['icomm'];
                        $ref = $post[$Openstock]['ref'];
                        $loc = $post[$Openstock]['loc'];
                        $disc = $post[$Openstock]['disc'];
                        break;
                    case'RR':
                        $rem = $post[$Openstock]['rem'];
                        $ref = $post[$Openstock]['ref'];   
                        $loc = $post[$Openstock]['loc'];
                        $disc = $post[$Openstock]['disc'];
                        break;
                    case 'PU':
                        $rem = $post[$Openstock]['rem'];
                        $ref = "";   
                        $loc = $post[$Openstock]['loc'];
                        $disc = $post[$Openstock]['disc'];
                        break;
                }
                switch ($doc) {
                case 'RR':case 'CA': case 'IS': case'AJ': case 'PO': case'PC': case'PR':case'MI': {
                    $displayamt = 'rrcost';
                    $displayqty = 'rrqty';
                    $computeamt = 'cost';
                    $computeqty = 'qty';
                    break;
                    }
                case 'CM':
                    $displayamt = 'isamt';
                    $displayqty = 'rrqty';
                    $computeamt = 'amt';
                    $computeqty = 'qty';
                    break;

                case 'SJ':case'DM':case'TS':case'SO':case'PU': case 'CH': case 'QT': {
                    $displayamt = 'isamt';
                    $displayqty = 'isqty';
                    $computeamt = 'amt';
                    $computeqty = 'iss';
                    break;
                    }
            }
                
            }
               
            if ($action == 'quickadd') {
                if ($model_->$displayqty == 0) {
                    $model_->$displayqty = 1;
                }
            }

            $post[$Openstock][$displayamt] = str_replace(",", "", $post[$Openstock][$displayamt]);
            $post[$Openstock][$displayqty] = str_replace(",", "", $post[$Openstock][$displayqty]);
            $post[$Openstock][$computeamt] = str_replace(",", "", $post[$Openstock][$computeamt]);
            $post[$Openstock][$computeqty]= str_replace(",", "", $post[$Openstock][$computeqty]);
            

            
            //$disc = $model_->disc;
            if ($uom != $olduom) {
                $oldfactor = Item::getFactor($barcode, $olduom);
                $post[$Openstock][$displayamt] = ($post[$Openstock][$displayamt] / $oldfactor) * $factor;
                if ($post[$Openstock][$displayqty] != 0) {
                    $post[$Openstock][$computeamt] = ((Yii::$app->sbccommon->Discount($post[$Openstock][$displayamt], $disc) * abs($post[$Openstock][$displayqty])) / $factor) / abs($post[$Openstock][$displayqty]);
                } else {
                    $post[$Openstock][$computeamt] = ((Yii::$app->sbccommon->Discount($post[$Openstock][$displayamt], $disc) * abs($post[$Openstock][$displayqty])) / $factor);
                }
            } else {
                if ($model_->$displayqty != 0) {
                    $post[$Openstock][$computeamt] = ((Yii::$app->sbccommon->Discount($post[$Openstock][$displayamt], $disc) * abs($post[$Openstock][$displayqty])) / $factor) / abs($post[$Openstock][$displayqty]);
                } else {
                    $post[$Openstock][$computeamt] = ((Yii::$app->sbccommon->Discount($post[$Openstock][$displayamt], $disc) * abs($post[$Openstock][$displayqty])) / $factor);
                }
            }
            if ($Openstock == 'Lastock') {
                $model_->qty = 0;
                $model_->iss = 0;
            } else {
               $post[$Openstock][$computeqty] = 0;
            }
            switch ($doc) {
                case'AJ':case'MI':case'IS': {
                        if ($post[$Openstock][$displayqty] < 0) {
                            $model_->iss = abs($post[$Openstock][$displayqty]) * $factor;
                        } else {
                           $post[$Openstock][$computeqty] = abs($post[$Openstock][$displayqty]) * $factor;
                        }
                        break;
                    }
                default : {
                       $post[$Openstock][$computeqty] = abs($post[$Openstock][$displayqty]) * $factor;
                        break;
                    }
            }

            $model_->ext = ((Yii::$app->sbccommon->Discount($post[$Openstock][$displayamt], $disc) * $post[$Openstock][$displayqty]));


            if (($post[$Openstock][$displayamt]) != 0 && ($post[$Openstock][$displayqty]) != 0) {
                
            } else {
                $post[$Openstock][$computeamt] = 0;
            }
            if (strlen($model_->wh_) == 0) {
                $head_warehouse = Lastock::getheadwarehouse($trno, $doc);
                $model_->wh = $head_warehouse['wh'];
                $model_->wh_ = $head_warehouse['whcode'];
            }
            
             $rrcost =  $post[$Openstock][$displayamt];
             $total =  $model_->ext;
             $cost =  $post[$Openstock][$computeamt];
             $rrqty =  $post[$Openstock][$displayqty];
             $qty =  $post[$Openstock][$computeqty];   
             $wh =  $model_->wh_;
             $whname =  $model_->wh;
             
             
             switch ($doc){
                case 'RR':
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'amt'=>$cost,'isamt'=>$rrcost,'rrqty'=>$rrqty,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'rem'=>$rem,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc,'ref'=>$ref);
                    echo json_encode($arr);
                    break;
                case 'IS':
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'amt'=>$cost,'isamt'=>$rrcost,'rrqty'=>$rrqty,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc,'rem'=>$rem);
                    echo json_encode($arr);
                    break;
                case 'AJ':case 'TS':
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'amt'=>$cost,'isamt'=>$rrcost,'rrqty'=>$rrqty,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);
                    break;
                case 'SJ':case 'CH':
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'amt'=>$cost,'isamt'=>$rrcost,'rrqty'=>$rrqty,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc,'comm'=>$comm,'icomm'=>$icomm);
                    echo json_encode($arr);
                    break;
                case 'MI':
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'amt'=>$cost,'isamt'=>$rrcost,'rrqty'=>$rrqty,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);
                    break;
                case 'CA':
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'ref'=>$ref,'amt'=>$cost,'isamt'=>$rrcost,'rrqty'=>$rrqty,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);
                    break;
                case 'CM':
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'amt'=>$cost,'isamt'=>$rrcost,'rrqty'=>$rrqty,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);     
                    break;  
                case 'TS':
                case 'AJ':
                    $arr = array ('total'=>$total,'wh'=>$whname,'uom'=>$uom,'olduom'=>$olduom,'amt'=>$cost,'isamt'=>$rrcost,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'rem'=>$rem,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);    
                    break;
                 case 'DM':    
                    $arr = array ('total'=>$total,'wh'=>$whname,'uom'=>$uom,'olduom'=>$olduom,'amt'=>$cost,'isamt'=>$rrcost,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'ref'=>$ref,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);    
                    break;
                case 'PU':    
                    $arr = array ('total'=>$total,'wh'=>$whname,'uom'=>$uom,'olduom'=>$olduom,'amt'=>$cost,'isamt'=>$rrcost,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc,'rem'=>$rem);
                    echo json_encode($arr);    
                    break;
                case "PO": case "PC":
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'rrqty'=>$rrqty,'qty'=>$qty,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);
                    break;
                case "PR":
                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'rrqty'=>$rrqty,'qty'=>$qty,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc,'rem'=>$rem);
                    echo json_encode($arr);
                    break;
//                 case "PR":
//                    $arr = array ('total'=>$total,'wh'=>$whname,'rrcost'=>$rrcost,'uom'=>$uom,'olduom'=>$olduom,'cost'=>$cost,'rrqty'=>$rrqty,'qty'=>$qty,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc,'loc'=>$loc);
//                    echo json_encode($arr);
//                    break;
                case "SO": case "QT":
                    $arr = array ('total'=>$total,'wh'=>$whname,'uom'=>$uom,'olduom'=>$olduom,'amt'=>$cost,'isamt'=>$rrcost,'qty'=>$qty,'isqty'=>$rrqty,'iss'=>$qty,'loc'=>$loc,'barcode'=>$barcode,'itemname'=>$itemname,'disc'=>$disc);
                    echo json_encode($arr);    
                    break;
            }            
        }
    }
function saveinsertstock($controller, $data_, $doc, $trno) {
    $line = $data_->line;
    $openstock = $this->getstocktype($doc);
        if ($line == 0) {   //insert new item in stock        
                if ($Openstock == 'Lastock') {                    
                        Lastock::insertstock($doc, $trno, $data_,1);
                        $barcode = $data_->barcode;
                        $rrqty = number_format($data_->rrqty, 2); //.number_format($data[$i]['rrcost'],2)
                        $itemname = $data_->itemname;
                        $uom = $data_->uom;
                        $wh_ = $data_->wh;
                        $cost = number_format($data_->cost, 2);
                        $ext = number_format($data_->ext, 2);
                        $disc = $data_->disc;
                        $loc = $data_->loc;
                        $rem = $data_->rem;
                        
                        unset(Yii::$app->session['message' . $doc]);
                        
                        if ($trno != "" && !Yii::$app->session['posted' . $doc]) {
                            $trno_ = md5($trno);
                            $controller->actiondistribute($trno_);
                        } 

                }elseif($Openstock=='Postock') {
                    Postock::insertstock($doc, $trno, $data_);
                }else{
                    Qtdetail::insert($trno, $data_);
                }            
        }else{
          //edit item in stock
                if ($Openstock == 'Lastock') {
                    if ($doc == 'SJ') {
                       
                        $stock2 = Lastock::openstockline($trno, $line, $doc);
                        if (Client::iscreditlimit(Yii::$app->session['supplier' . $doc], $stock2[0]['ext'], $data_->ext,$doc)) {
                            Lastock::updatestocks($doc, $line, $trno, $data_);
                            unset(Yii::$app->session['message' . $doc]) ;
                        }
                    } else {
                        Lastock::updatestocks($doc, $line, $trno, $data_);
                        unset(Yii::$app->session['message' . $doc]);
                    }


                    if ($trno != "" && !Yii::$app->session['posted' . $doc]) {
                        $trno_ = md5($trno);
                        $controller->actiondistribute($trno_);
                    }
                } else {
                     
                    Postock::updatestock($doc, $line, $trno, $data_);
                  
                }
            } //end edit item in stock
        
    }
    
function saveinsertquotation($controller, $data_, $doc, $trno,$inputid) {
        if ($data_->validate()) {
            $Openquote = Qtdetail::openqtdetail($trno);
            
            if (empty($Openquote) || $Openquote = null){
                Qtdetail::insertquotation($trno,$data_,$inputid);
                
            }else{
                Qtdetail::updatequotation($trno,$data_,$inputid);
            }           
            
        } else {
       
        }
       
    }
    
    function deleteitem($controller,$common,  $doc, $trno,$line,$refx,$linex) {
        $itembarcode = $common->getItem($doc, $trno, $line);
        Lastock::deletestocks($doc, $trno, $line);
        if (strlen($refx) != 0 && $refx != 0) {
            if (!Postock::setserveditems($linex, $refx, $doc)) {
                Postock::resetQuantity($line, $trno, $doc);
                Postock::setserveditems($linex, $refx, $doc);
                //Lastock::deletecosting($trno, $line);
            }
        }

        Log::del_log($doc, $trno, $itembarcode, 'STOCK');
        $Opentable = $this->gettranstype($doc);
        if ($Opentable == 'Lahead') {
            if ($trno != "" && !Yii::$app->session['posted' . $doc]) {
                $trno_ = md5($trno);
                $controller->actiondistribute($trno_);
            }
        }
       // $controller->redirect(array('stocks'));
    }
    
    function managequotation($controller, $get, $post, $accessedit) {
        if (Yii::$app->user->access[$accessedit] != 1) { // allow editing of transactions
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to Edit transactions';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        }else{
        $doc = $controller->module->id;        
        if (Yii::$app->session['posted' . $doc]) {
            $controller->redirect(array('index'));
        }
        
        $common= new Common();
        $model_ = new Qtdetail();
        $Openstock = "Qtdetail";
        
        $model_->unsetAttributes();
        
        $action = "";
        $qtdetail = "";
        $inputid="";
        $trno = Yii::$app->session['trno' . $doc];

            if (isset($get['action'])){
            $action = $get['action'];
            } 

            if (isset($get['inputid'])){
                $inputid = $get['inputid'];
        }

                 if (isset($post[$Openstock])) {
                    $model_->attributes = $post[$Openstock];           
                    $model_->action=$action;
                 }
                
             
            if ($action == "save") {                
               $this->saveinsertquotation($controller,$model_,$doc,$trno,$inputid);
                 
            }
               
            if ($action == "edit"){
                $qtdetail = QTDetail::openqtdetail($trno);
                if ($qtdetail!=null){
                    $model_->header1 = $qtdetail[0]['header1'];
                    $model_->header2 = $qtdetail[0]['header2'];
                    $model_->header3 = $qtdetail[0]['header3'];
                    $model_->footer1 = $qtdetail[0]['footer1'];
                    $model_->footer2 = $qtdetail[0]['footer2'];
                    $model_->footer3 = $qtdetail[0]['header3'];
                }
               
            }


            if ($action == "cancel" || $action == "Save" || $action == "Insert") {
                $model_->unsetAttributes();
                if ($action == "cancel") {
                     $controller->redirect(array('quotation'));
                }
            }
            

            if (isset($get['id'])) {
                $line = $get['id'];
            } else {
                $line = 0;
            }
        }       
       $controller->render('quotation', array('model' => $model_,'inputid'=>$inputid));
    }

    function qtaccept($controller, $gpost,$gget) {
            
        if (isset($gpost) && !empty($gpost)) {
            $doc = $controller->module->id;
            $qtdetail = new Qtdetail();
            $tablenum='Transnum';
            
            $trno = Yii::$app->session['trno' . $doc];
             
            $done = false;
            $field ="";
                     
            if(isset($gget)){
                $field =$gget['inputid'];
            }
            
            foreach ($gpost as $post => $key) {
                if ($post != $tablenum && $post != 'OK') {
                    $item = explode('-', $post);
                    
                    if (isset($gpost[$post]) && !isset($gpost['void-' . $item[0]])) {

                        $thisitem = Lookup::openthistemplate($item[0]);
                        $field = $item[1];
                        if ($thisitem) {
                            $qtdetail->$field = $thisitem['note'];                          
                            $Openquote = Qtdetail::openqtdetail($trno);
            
                            if (empty($Openquote) || $Openquote = null){
                            Qtdetail::insertquotation($trno,$qtdetail,$field);  
                            $done= true;
                            }else{
                                Qtdetail::updatequotation($trno,$qtdetail,$field);
                                $done = true;
                            }
                            //Qtdetail::insertquotation($trno,$qtdetail,$field);                          
            
            
                        }
                    }
                }
                 else {
                   
                }
            }
            
            if ($done){
              $controller->render('quotation', array('model' => $qtdetail,'inputid'=>$field));  
            }else{
                $controller->redirect(array('quotation/quotation','action'=>'edit','inputid'=>$field));
            }
       
            //$controller->redirect(array('quotation'));
            
        } else {
            $controller->redirect(array('//site/logout'));
        }
    }
        
    function manageremarks($controller, $get, $post, $accessedit) {
        if (Yii::$app->user->access[$accessedit] != 1) { // allow editing of transactions
            $title = 'Unauthorized';
            $message = 'Sorry, You are not allowed to Edit transactions';
            $message .= '<br />';
            $message .= CHtml::Button('Ok', array('submit' => array('index')));
            Yii::$app->user->setflash(1, array('title' => $title, 'content' => $message));
            $controller->redirect(array('index'));
        }else{
            $doc = $controller->module->id;        
            if (Yii::$app->session['posted' . $doc]) {
                $controller->redirect(array('index'));
    }
        
            $common= new Common();
            $model_ = new Postock();
            $Openstock = "Postock";

            $model_->unsetAttributes();

            $action = "";
            $qtstock = "";
            $inputid="";
            $trno = Yii::$app->session['trno' . $doc];

            if (isset($get['action'])){
                $action = $get['action'];
}


            if (isset($post[$Openstock])) {
                $model_->attributes = $post[$Openstock];           
                $model_->action=$action;
            }           


            if (isset($get['id'])) {
                    $line = $get['id'];
                }else {
                    $line = $post[$Openstock]['line'];
                }
                
                
                
            if ($action == "save") {
               Postock::updateremarks($model_,$trno,$line);
            }
            
            
            if ($action == "remarks") {
                $qtstock = Postock::openstockline($doc,$trno,$line);
                $this->editstock($controller,$doc,$model_,$qtstock,$accessedit,$trno,$line);        
               
            }
            
                       

            if ($action == "cancel" || $action == "Save" || $action == "Insert") {
                $model_->unsetAttributes();
                if ($action == "cancel") {
                     $controller->redirect(array('quotation'));
                }
            }


        }       
       $controller->render('addremarks', array('model' => $model_));
    }
}