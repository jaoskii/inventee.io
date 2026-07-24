<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\Web\Session;
use yii\web\Request;
use yii\base\ErrorException;

//IMPORTED CLASES
use app\models\Common;
use app\models\Lahead;
use app\models\Lastock;
use app\models\Ladetail;
use app\models\Cntnum;
use app\models\Webproc;

class extractify extends Component{
    

    public function getData($filter){
        $qry = "select cart.atrno as trno,cart.trno as clearout_trno from tblcart as cart group by cart.atrno,cart.tablet";
        $data = Yii::$app->sbccommon->openTable($qry);
        return $data;
    }//END IF GET DATA FROM TBLCART


    public function retrieveDatatoExtract($filter){
        if($filter == ''){
            $filtering = '';
        }else{
            $filter = explode('~', $filter);
            $filtering = "where agent.client = '".$filter[0]."' and left(cart.dateid,10) = '".$filter[1]."'";
        }//end if

        $qry = "select cart.id as crtid,cart.disc,item.barcode,item.itemname,customer.client as customercode,customer.clientname as customername,customer.addr,
        cart.atrno as trno,left(cart.dateid,10) as dateid,left(cart.postdateid,10) as postdate,cart.ref,cart.client as clientid,cart.line,
        cart.itemid,cart.qty,cart.iss,cart.rrqty,cart.isqty,cart.amount as amt,cart.isamt,cart.cost,cart.rrcost,cart.uom,cart.ext,
        cart.user,cart.outletid as whcode,wh.clientname as whname,cart.tablet,cart.agent as agentcode from tblcart as cart
        left join item on item.itemid = cart.itemid
        left join client as customer on customer.client = cart.client and customer.iscustomer = 1
        left join client as agent on agent.client = cart.agent and agent.isagent = 1
        left join client as wh on wh.client = cart.outletid and wh.iswarehouse = 1 ".$filtering."
        group by cart.atrno,cart.itemid";
        
        $data = Yii::$app->sbccommon->openTable($qry);
        return $data;
    }//end function

    public function retrieveFilters(){
        $qry = "select concat(agent,'~',left(dateid,10)) as filter from tblcart group by agent,left(dateid,10)";
        
        $data = Yii::$app->sbccommon->openTable($qry);
        return $data;
    }//end action retrieve filters

    public function createExtractionDocument($filters){
    try {
        $head = new Lahead;
        $stock = new Lastock;
        $detail = new Ladetail;
        $common = new Common;
        $webproc = new Webproc; 
        //ADD CHECKING FOR ZERO ITEM VALUES
        //NOTE: DONT PROCEED WITH EXTRACTION IF THERE ARE ZERO QTY.

        //$data_to_extract = $this->retrieveDatatoExtract($filters);
        $data_to_extract = $this->getData($filters);
        $clearout_trno = $data_to_extract[0]['clearout_trno'];

        foreach ($data_to_extract as $key => $value) {            
            $headreturn = $this->createExtractionHead($head,$value['trno'],'SJ','SJ');
            if($headreturn['status']){
                $stock->trno = $headreturn['trno'];
                $invoicetrno = $stock->trno;
                if($this->createExtractionStock($stock,$value['trno'],'SJ')){
                    //POSTING OF INVOICE
                    $postingstatus = $this->postExtractedInvoice($invoicetrno);
                    //CHECK POSTING STATUS OF THE INVOICE
                    if($postingstatus){
                        //CREATION OF PAYMENT OF POSTED INVOICES
                        //PAYMENT (cart.atrno,SJtrno)
                        $headreturn2 = $this->createExtractionHead($head,$invoicetrno,'CR','CR');
                        $detail->trno = $headreturn2['trno'];
                        $params = array('invoicetrno'=>$invoicetrno,'paymentref'=>$value['trno']);
                        $this->createExtractionDetail($detail,$params);

                        //FINALIZING PART
                        //FINALIZING OF EXTRACTION DATA (TRANSFERRING FROM TBLCART TO TBLCARTHISTORY)
                        $extractstatus = $this->finalizeExtraction($value['trno']);
                    }else{
                        $extractstatus = false;
                        break;    
                    }//end if
                }else{
                    $extractstatus = false;
                    break;
                }//end if create extraction stock
            }else{
                $extractstatus = false;
                break;
            }//end if create extraction head
        }//end data to extract for each


        /*if($extractstatus){
            $qry = "select head.docno,wh.client as wh,wh.clientname as whname from glhead as head
                    left join glstock as stock on stock.trno = head.trno
                    left join client as wh on wh.clientid = stock.whid
                    where stock.trno = $clearout_trno and stock.tstrno = 0 group by wh.client";
            
            $warehouses = Yii::$app->sbccommon->openTable($qry);

            foreach ($warehouses as $key => $value) {
                $params = ['wh'=>$value['wh'],'whname'=>$value['whname'],'orgts'=>$value['docno']];
                $headreturn3 = $this->createExtractionHead($head,$clearout_trno,'TS','TS',$params);
                $stock->trno = $headreturn3['trno'];
                $this->createExtractionStock($stock,$clearout_trno,'TS',$params);
            }//end for each

        }*///end if true extract status clear all stock return to main warehouse

        return $extractstatus;
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end fucntion createExtractionDocument
    
    public function createTransactionHead($dataobj,$extractionkey,$prefix,$bref,$addedparams = []){
        return $this->createExtractionHead($dataobj,$extractionkey,$prefix,$bref,$addedparams);
    }//end function

    public function createTransactionStock($dataobj,$extractionkey,$doc,$addedparams = []){
        return $this->createExtractionStock($dataobj,$extractionkey,$doc,$addedparams);
    }//end function

    private function createExtractionHead($dataobj,$extractionkey,$prefix,$bref,$addedparams = []){
    try {
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
                switch ($prefix) {
                    case 'SJ':
                        $qry = "select customer.client as customercode,customer.clientname as customername,customer.addr,
                        left(cart.dateid,10) as dateid,cart.ref,cart.outletid as whcode,wh.clientname as whname,cart.tablet,
                        cart.agent as agentcode,cart.atrno as trno from tblcart as cart
                        left join item on item.itemid = cart.itemid
                        left join client as customer on customer.client = cart.client
                        left join client as agent on agent.client = cart.agent
                        left join client as wh on wh.client = cart.outletid 
                        where atrno = ".$extractionkey;
                    break;

                    case 'CR':
                        $qry = "select customer.client as customercode,customer.clientname as customername,customer.addr,
                        head.dateid,head.yourref,head.rem,agent.client as agentcode,agent.clientname as agentname
                        from glhead as head
                        left join client as customer on customer.clientid = head.clientid
                        left join client as agent on agent.clientid = head.agentid
                        left join client as wh on wh.clientid = head.whid
                        where head.doc = 'SJ' and head.trno = '".$extractionkey."'";
                    break;

                    case 'TS':
                        $qry = "select left('".Yii::$app->systemsettings->getCurrentTimeStamp()."',10) as dateid,
                        '".$addedparams['destinationwh']."' as destinationcode,'".$addedparams['destinationwhname']."' as destinationname,
                        '".$addedparams['sourcewh']."' as sourcecode,'".$addedparams['sourcewhname']."' as sourcename";
                    break;
                }//END SWITCH
            break;
            
            default:
                return 0;
            break;
        }//END SWITCH CASE

        $extractedhead = Yii::$app->sbccommon->openTable($qry);
        $head = new Lahead;
        $stock = new Lastock;
        $common = new Common;
        $webproc = new Webproc;
        $seq = $common->getlastseq($bref,$prefix,Yii::$app->session['loggeduser']['center']);
        
        switch ($prefix) {
            case 'TS':
                $poseq = $bref . $seq;
                break;
            
            default:
                $poseq = $prefix . $seq;
                break;
        }//END SWITCH

        $docnolength = $common->doclength();
        $newdocno = $common->PadJ($poseq, $docnolength);

        $dataobj->docno = $newdocno;
        $dataobj->dateid = $extractedhead[0]['dateid'];
        $dataobj->forex = 1.00;
        $dataobj->cur = 'P';
        $dataobj->tax = Yii::$app->backend->getdefaultValues('tax');
        
        switch($prefix) {
            case'RR':case'DM':case'CA':case'AP': {
                $contra='AP1';
                break;}
            case'CM':case'AR': {
                $contra='AR1';
                break;}
            case 'SJ':{
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'INFINITEA':
                        $contra='CA1';
                        $salestype='CASH';
                        $dataobj->salestype = $salestype;
                    break;

                    default:
                        $contra='AR1';
                        $salestype='CHARGE';
                        $dataobj->salestype = $salestype;
                    break;
                }//end switch case                            
                break;}                         
            case 'CH':{
                    $contra='CA1';
                    break; }          
            case 'PV': {
                    $contra='AP2';
                    break;}
            case 'IS':case 'AJ': case 'MI': case 'PK':{
                    $contra='IS1';
                    break;}
            case 'CV':case 'DS': {
                    $contra='CB1';
                    break;}
            case 'CR': {
                    $contra='CR1';
                    break;}
            default: {
                    $contra='';
                    break;}
        }//END CASE                          

        if($contra!=''){
            if($prefix != 'DS'){
                $dataobj->contra = Ladetail::getacno($contra) . '~' . Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
            }else{
                $dataobj->contra = Ladetail::getacno($contra);
            }
        }

        if($prefix == "DS"){
            $dataobj->clientname = Ladetail::getacnoname('\\'.Ladetail::getacno($contra));
        }


        //THIS CODE BLOCK IS FOR VAT TYPE
        if($prefix == "SJ" || $prefix == "RR"){
            if($prefix == 'SJ'){ // FOR SJ VAT TYPE
                switch ($bref) {
                    case 'SI': case 'CI': case 'CS':
                        $dataobj->vattype = 'VATABLE';
                        $dataobj->tax = 12;
                        break;
                    
                    default:
                        $dataobj->vattype = 'NON-VATABLE';
                        $dataobj->tax = 0;
                        break;
                }//end switch case
            }else{ //FOR RR VAT TYPE
                switch ($bref) {
                    default:
                        $dataobj->vattype = 'NON-VATABLE';
                        $dataobj->tax = 0;
                        break;
                }//end switch case
            }//end if else
        }//END IF sj
        
        if(!empty($dataobj->contra)){
          $contradata = explode("~" ,$dataobj->contra);
          $dataobj->contra = $contradata[0];
        }else{
          $dataobj->contra = '';
        }//end if

        switch ($prefix) {
            case 'SJ':
                $dataobj->client = $extractedhead[0]['customercode'];
                $dataobj->clientname = $extractedhead[0]['customername'];
                $dataobj->address = $extractedhead[0]['addr'];
                $dataobj->due = $extractedhead[0]['dateid'];
                $dataobj->agentcode = $extractedhead[0]['agentcode'];
                $dataobj->whid =  $extractedhead[0]['whcode'];
                $dataobj->wh = $extractedhead[0]['whname'];
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'SOUTHCENTRAL':
                    $dataobj->yourref = $extractedhead[0]['ref'];
                    $dataobj->rem = "Transaction from Tablet: " . $extractedhead[0]['tablet'] . " / A-TRNO: ". $extractedhead[0]['trno'];
                    break;

                    default:
                    $dataobj->yourref = '';
                    $dataobj->rem = '';
                    break;
                }//END SWITCH
                break;

            case 'CR':
                $dataobj->whid = Yii::$app->session['loggeduser']['whcode'];
                $dataobj->wh = Yii::$app->session['loggeduser']['whname'];
                $dataobj->client = $extractedhead[0]['customercode'];
                $dataobj->clientname = $extractedhead[0]['customername'];
                $dataobj->address = $extractedhead[0]['addr'];
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'SOUTHCENTRAL':
                    $dataobj->yourref = $extractedhead[0]['yourref'];
                    $dataobj->rem = $extractedhead[0]['rem'];
                    $dataobj->agentcode = $extractedhead[0]['agentcode'];
                    break;

                    default:
                    $dataobj->yourref = '';
                    $dataobj->rem = '';
                    $dataobj->agentcode = '';
                    break;
                }//END SWITCH
            break;

            case 'TS':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'SOUTHCENTRAL':
                    $dataobj->whid = $extractedhead[0]['sourcecode'];
                    $dataobj->wh = $extractedhead[0]['sourcename'];
                    $dataobj->client = $extractedhead[0]['destinationcode'];
                    $dataobj->clientname = $extractedhead[0]['destinationname'];                    
                    $dataobj->agentcode = '';
                    $dataobj->routeid = 0;
                    $dataobj->pricegrp = 'A';
                    $dataobj->yourref = '';
                    $dataobj->due = '1900-01-01';
                    $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
                    $dataobj->rem = 'AUTO CLEAROUT TS ('.$current_timestamp.') for ['.$extractedhead[0]['sourcename'].']';
                    break;

                    default:
                    $dataobj->whid = Yii::$app->session['loggeduser']['whcode'];
                    $dataobj->wh = Yii::$app->session['loggeduser']['whname'];
                    $dataobj->client = Yii::$app->session['loggeduser']['whcode'];
                    $dataobj->clientname = Yii::$app->session['loggeduser']['whname'];                    
                    $dataobj->yourref = '';
                    $dataobj->rem = '';
                    $dataobj->due = '1900-01-01';
                    break;
                }//END SWITCH CASE 
            break;
            
            case 'PC': case 'IS': case 'AJ': case 'PK':
                $dataobj->whid = Yii::$app->session['loggeduser']['whcode'];
                $dataobj->wh = Yii::$app->session['loggeduser']['whname'];
                $dataobj->client = Yii::$app->session['loggeduser']['whcode'];
                $dataobj->clientname = Yii::$app->session['loggeduser']['whname'];                    
                $dataobj->yourref = '';
                $dataobj->rem = '';
            break;
        }//END SWITCH CASE

        $dataobj->isposted = false;
        $dataobj->islocked = false;
        $insertcntnum = $common->insertcntnum($prefix, $dataobj->docno, $seq, $bref,Yii::$app->session['loggeduser']['center']);

        if($insertcntnum==0){
        //IF TRANSACTION IS SAME DOCUMENT IT CREATES ANOTHER UNTIL IT COULD BE VALID DOCNO
            while ($insertcntnum == 0) {
                $pref = $common->GetPrefix($dataobj->docno);
                $docnolength = $common->doclength();
                $seq = $common->getlastseq($pref,$prefix,Yii::$app->session['loggeduser']['center']);
                $poseq = $pref . $seq;
                $newdocno = $common->PadJ($poseq, $docnolength);
                $insertcntnum = $common->insertcntnum($prefix, $newdocno, $seq, $bref,Yii::$app->session['loggeduser']['center']);
                if (($dataobj->docno != $newdocno) && ($trno == "") && ($insertcntnum !=0) ) {
                    $docno = $newdocno;
                    $data->docno = $newdocno;
                }//end if
            }//end white insertcntnum --
        }//END insertcntnum 0

        $trno_ = Cntnum::getTrnodocno($dataobj->docno,$prefix,Yii::$app->session['loggeduser']['center']);
        $trno = $trno_[0]['trno'];
        $docno = $trno_[0]['docno'];
        $dataobj->trno = $trno;
        
        $i=2;
        a:                      
            if($i>0){
                $insertstatus = Lahead::inserthead($docno,$prefix, $trno, $dataobj);
                //RETURNS NORMALIZED HEAD DATA FROM OPEN HEAD
                //SETS WHERE TO OPEN TABLE
            }//end if $i >0

            //PROCESS HEAD DATA SO IT CAN FILTERED PER DOC
            if ($insertstatus) {
                $i=-1;
                $extractstatus = true;
            }else{
                $i=$i-1;
                if($i>0){
                    goto a;
                }else{
                    $tablenum = Common::gettablenum($prefix);
                    $qrydeletecntnum = "delete from ".$tablenum." where trno = ".$trno."";
                    Yii::$app->sbccommon->execqry($qrydeletecntnum);
                    $extractstatus = false;
                }//end if if($i>0)
            }//end if

        return array('status'=>$extractstatus,'trno'=>$trno);
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end fucntion

    public function createExtractionDetail($dataobj,$params){
    try {
        $dataobj->line = 0;

        $qry = "select left(ar.dateid,10) as postdate,'' as checkno,coa.acno,coa.acnoname,
        customer.client,ar.cr as db,ar.db as cr,ifnull(gldetail.rem,'') as rem,ar.docno as ref,
        ar.line as linex,ar.trno as refx from arledger as ar
        left join client as customer on customer.clientid = ar.clientid
        left join coa on coa.acnoid = ar.acnoid
        left join gldetail on gldetail.trno = ar.trno and gldetail.line = ar.line
        where ar.trno = ".$params['invoicetrno']." and ar.bal <> 0
        group by ar.docno,ar.line,ar.trno
        UNION ALL
        select CASE WHEN apayments.checkdate = '' THEN left(cart.dateid,10) else apayments.checkdate END as postdate,apayments.checkno,
        (select coa.acno from coa where coa.alias = CASE WHEN apayments.payment = 'CASH' THEN 'CA2' ELSE 'CR1' END limit 1) as acno,
        (select coa.acnoname from coa where coa.alias = CASE WHEN apayments.payment = 'CASH' THEN 'CA2' ELSE 'CR1' END limit 1) as acnoname,
        cart.client,amt as db,0 as cr,'' as rem,'' as ref,0 as linex,0 as refx from androidpayments as apayments
        left join tblcart as cart on cart.atrno = apayments.atrno
        where apayments.atrno = ".$params['paymentref']."
        group by apayments.atrno,apayments.line";
        
        $extracteddetails = Yii::$app->sbccommon->openTable($qry);        

        foreach ($extracteddetails as $key => $value) {
            $dataobj->line = $dataobj->line + 1;
            $dataobj->postdate = $value['postdate'];
            $dataobj->templine = 0;
            $dataobj->checkno = $value['checkno'];
            $dataobj->acno = $value['acno'];
            $dataobj->acnoname = $value['acnoname'];
            $dataobj->client = $value['client'];
            $dataobj->db = $value['db'];
            $dataobj->cr = $value['cr'];
            $dataobj->refx = $value['refx'];
            $dataobj->linex = $value['linex'];
            $dataobj->rem = $value['rem'];
            $dataobj->ref = $value['ref'];
            $dataobj->pdcline = 0;
            Ladetail::insertdetail($dataobj->trno, $dataobj, 'ladetail', 'CR');
        }//end for each $extractedstock

        return true;
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end function extraction detail

    private function createExtractionStock($dataobj,$extractionkey,$doc,$addedparams = []){
    try {
        $dataobj->line = 0;
        
        switch ($doc) {
            case 'SJ':
                $qry = "select cart.disc,item.barcode,item.itemname,
                cart.atrno as trno,cart.itemid,cart.qty,cart.iss,cart.rrqty,cart.isqty,
                cart.amount as amt,cart.isamt,cart.cost,cart.rrcost,cart.uom,cart.ext,
                cart.user,cart.outletid as whcode,wh.clientname as whname from tblcart as cart
                left join item on item.itemid = cart.itemid
                left join client as wh on wh.client = cart.outletid and wh.iswarehouse = 1
                where cart.atrno = ".$extractionkey;
                break;
            
            case 'TS':
                $qry = "select item.barcode,item.itemname,rrstatus.uom,wh.client as whcode,(rrstatus.cost * rrstatus.bal) as isamt,
                        rrstatus.bal as iss,(rrstatus.bal * uom.factor) as isqty,rrstatus.cost as amt,
                        ((rrstatus.cost * uom.factor) * (rrstatus.bal * uom.factor)) as ext,rrstatus.disc from rrstatus
                        left join item on item.itemid = rrstatus.itemid
                        left join uom on uom.uom = rrstatus.uom and uom.itemid = rrstatus.itemid
                        left join client as wh on wh.clientid = rrstatus.whid
                        left join client as wh2 on wh2.client = item.defaultwh
                        where wh.client = '".$addedparams['sourcewh']."' and item.defaultwh = '".$addedparams['destinationwh']."'
                        and rrstatus.bal <> 0";
            break;
        }//END SWITCH CASE
        
        $extractedstock = Yii::$app->sbccommon->openTable($qry);

        foreach ($extractedstock as $key => $value) {
            $dataobj->line = $dataobj->line + 1;
            $dataobj->itemname = $value['itemname'];
            $dataobj->barcode = $value['barcode'];
            $dataobj->uom = $value['uom'];
            $dataobj->wh_ = $value['whcode'];
            $dataobj->rem = '';
            $dataobj->isamt = $value['isamt'];
            $dataobj->isqty = $value['isqty'];
            $dataobj->amt = $value['amt'];
            $dataobj->iss = $value['iss'];
            $dataobj->ext = $value['ext'];
            $dataobj->qty = 0;
            $dataobj->void = 0;
            $dataobj->refx = 0;
            $dataobj->linex = 0;
            $dataobj->ref = '';
            $dataobj->loc = '';
            $dataobj->expiry = '1900-01-01';
            $dataobj->iss2 = 0;
            $dataobj->isqty2 = 0;
            $dataobj->disc = $value['disc'];
            $dataobj->outputid = 0;
            $dataobj->iscomponent = 0;
            Lastock::insertstock($doc, $dataobj->trno, $dataobj,true);
        }//end for each $extractedstock

        return true;
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end function 

    private function finalizeExtraction($extractionkey){
        try {
            $current_timestamp = Yii::$app->systemsettings->getCurrentTimeStamp();
            $qry = "insert into tblcarthistory(id,atrno,adoc,dateid,postdateid,ref,client,
                    docno,line,itemid,qty,iss,actualqty,amount,pricetypecode,uom,ext,user,uploadeddate,outletid,isqty,isamt,rrcost,
                    cost,rrqty,isok,tablet,agent,cashamt,checkamt,checkno,checkdate,disc,discamt,generateso,trno)
                    select id,atrno,adoc,dateid,postdateid,ref,client,
                    docno,line,itemid,qty,iss,actualqty,amount,pricetypecode,uom,ext,
                    user,uploadeddate,outletid,isqty,isamt,rrcost,
                    cost,rrqty,isok,tablet,agent,cashamt,checkamt,checkno,checkdate,disc,discamt,'".$current_timestamp."',trno from tblcart
                    where atrno = ".$extractionkey;
            if(Yii::$app->sbccommon->execqry($qry)){
                $qry2 = "delete from tblcart where atrno = ".$extractionkey;
                $status = Yii::$app->sbccommon->execqry($qry2);
            }else{
                $status = false;
            }//end if


            return $status;
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end function

    private function postExtractedInvoice($trno){
    try {
        Yii::$app->webprocess->computeduedate('SJ',$trno);
        //SO DISTRIBUTION WONT HAPPEN EVEN IF DOCUMENT IS VATABLE WITH NO ITEMS
        
        if(Yii::$app->backend->hasDataRows($trno,'lastock')){
            $head = Lahead::openhead($trno, 'SJ');
            $contra = "";
            $tax = 0;
            $dateid = "";
            if ($head != null) {
                $contra = $head[0]['contra'];
                $tax = isset($head[0]['tax'])? $head[0]['tax'] : 0;
                $dateid = $head[0]['dateid'];
            }
            $result = Ladetail::deletedetail('SJ', $trno);
            $w=Ladetail::autoinsertdetail('SJ', $trno, $contra, $tax, $dateid,1); 
        }

        if(Cntnum::checkitemzero($trno,'SJ') == 0){ 
            if(Cntnum::IsbalancedTrans($trno, 'SJ')){
                $user=Yii::$app->session['loggeduser']['username'];
                $posting = Cntnum::PostTrans($trno, 'SJ',$user);
                if ($posting != 1) {
                    //ERROR POSTING
                    $status = false;
                }else{
                    //CNTNUM POSTING OK!
                    $status = true;
                }//end
            }else{                                 
                 $status = false;
                 Ladetail::deletedetail('SJ', $trno);
            }
        }else{
            $status = false;
        }//END IF

        return $status;
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end function post extracted invoice
}//END COMPONENTS
?>

