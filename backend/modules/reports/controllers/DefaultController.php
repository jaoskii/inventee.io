<?php
namespace backend\modules\reports\controllers;
require 'escpos/autoload.php';
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\Reports;
use yii\base\ErrorException;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use app\models\Ladetail;


use yii\web\Response;
class DefaultController extends Controller{

    // public $access = array(
    //     'po' => 152 ,'' => 153,'new' => 154,
    //     'save' => 155,'change' => 156,'delete' => 157,
    //     'print' => 158,'lock' => 159,'unlock' => 160,
    //     'denyamount' => 161,'crlimit'=>162,'post' => 163,'unpost' => 164,);
//check on table attributes

    public $access = array(
        //ACCOUNTING BOOKS
        'CDB'=>3002,//CASH DISBURSEMENT BOOK
        'CRB'=>3003,//CASH RECEIPT BOOK
        'JV'=>3004,//JOURNAL VOUCHER1
        'PJ'=>3005,//PURCHASE JOURNAL
        'SJ'=>3006,//SALES JOURNAL
        'COA'=>3007,//CHART OF ACCOUNTS
        //CHECK MONITORING
        'BC'=>3009,//BOUNCED CHECKS
        'IS'=>3010,//ISSUED CHECKS
        'RC'=>3011,//RECEIVED CHECKS
        'UC'=>3012,//UNDEPOSITED CHECKS
        //FINANCIAL STATEMENT
        'BS'=>3014,//BALANCE SHEET
        'IS'=>3015,//INCOME STATEMENT
        'SL'=>3016,//SUBSIDIARY LEDGER
        'TB'=>3017,//TRIAL BALANCE
        'TB'=>3017,//TRIAL BALANCE

        //ITEM
        'IB'=>3019,//INVENTORY BALANCE
        'IBXAN'=>3112,//INVENTORY BALANCE
        'AIPM'=>3020,//ANALYZED ITEM PURCHASE (MONTHLY)
        'AISM'=>3021,//ANALYZED ITEM SALES (MONTHLY)
        'IL'=>3022,//ITEM LIST
        'CIA'=>3023,//CURRENT INVENTORY AGING
        'FMI'=>3024,//FAST MOVING ITEM
        'AISPM'=>3025,//ANALYZED ITEM SALES WITH PROFITE MARKUP
        'SMI'=>3027,//SLOW MOVING ITEM
        'SPIPC'=>3028,//SALES PER ITEM PER CUSTOMER
        'IE'=>3079,//ITEM EXPIRED
        'BM'=>3030,// INVENTORY BALANCE - BELOW MINIMUM
        'AM'=>3031,// INVENTORY BALANCE - ABOVE MAXIMUM
        'IPL'=>3087,//PRICE LIST
        'PIS'=>3088,//PHYSICAL INVENTORY SHEET
        'SOI'=>3089,//SCHEDULE OF INVENTORY
        'CIBPS'=>3094,//CURRENT INVENTORY BALANCE PER SUPPLIER
        'IM'=>3095,//INVENTORY MONTHLY
        'CL'=>3033,//CUSTOMER LIST
        'CCR'=>3034, //CURRENT CUSTOMER RECEIVABLE AGING(SUMMARY)
        'CCRA'=>3035, //CURRENT CUSTOMER RECEIVABLE AGING(DETAILED)
        'CCR'=>3034,//CURRENT CUSTOMER RECEIVABLE
        'CCRA'=>3035,//CURRENT CUSTOMER RECEIVABLE AGING
        'ACSM'=>3036,//ANALYZE CUSTOMER SALES (MONTHLY)
        'CSR'=>3037,//CUSTOMER SALES REPORT
        'PSO'=>3038,//PENDING SALES ORDER
        'CPR'=>3053,//CUSTOMER PERFORMANCE REPORT
        'SPCPI'=>3082,//SALES PER CUSTOMER PER ITEM
        'MSR'=>3039,//MONTHLY SALES REPORT(GRAPH)
        'SCOM'=>3086,//SALES COMPARISON(GRAPH)
        'SPC'=>3090,//sales per class report
        'SPCR'=>3091,//sales per customerreport
        'SRP'=>3092,//sales report.
        //JEAR 091916
        'CSPC'=>3096,//COMPARATIVE SALES PER CUSTOMER
        //SUPPLIER
        'SL'=>3041,//SUPPLIER LIST
        'CSP'=>3042,//CURRENT SUPPLIER PAYABLE
        'CSPA'=>3043,//CURRENT SUPPLIER PAYABLE AGING
        'ASPM'=>3044,//ANALYZE SUPPLIER PURCHASES (MONTHLY)
        'SPR'=>3045,//SUPPLIER PURCHASE REPORT
        'PPO'=>3046,//PENDING PURCHASE ORDER
        'SPPR'=>3054,//SUPPLIER PERFORMANCE REPORT
        'RCR'=>3055,//RECEIVING CONSIGNMENT REPORT
        'PPS'=>3093,//RECEIVING CONSIGNMENT REPORT
        //JEAR 091916
        'PS'=>3097,//PURCHASE SUMMARY
        //AGEMT
        'SAL'=>3048,//SALES AGENT LIST
        'AASM'=>3049,//ANALYZE AGENT SALES (MONTHLY)
        //OTHERS
        'SOA'=>3051,//STATEMENT OF ACCOUNTS
        'EX'=>3052,//EXPENSES REPORT
        //TRANSACTION LIST
        'TL'=>3056,
        'PUR'=>3057,
        'RR'=>3058,
        'PRR'=>3059,
        'POR'=>3060,
        'PURR'=>3061,
        'SAL'=>3062,
        'SO'=>3063,
        'SJR'=>3064,
        'SRR'=>3065,
        'INV'=>3066,
        'ISR'=>3067,
        'PCR'=>3068,
        'TSR'=>3069,
        'IAR'=>3070,
        'PAY'=>3071,
        'ARS'=>3072,
        'APVS'=>3073,
        'CCV'=>3074,
        'REC'=>3075,
        'ARS'=>3076,
        'RP'=>3077,
        'CRD'=>3078,
        'ACC'=>3079,
        'GSJ'=>3080,
        'DS'=>3081,
        );

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    // MASTERFILE

    //TAXWHELD MODULE
    //TAXWHELD MODULE


    // SALON MODIFICATION

    public function actionModulereporttr(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        Yii::$app->backend->generateReportLog($_POST, 'Printed Default TR Printout' ,$_POST['trno'], 'module','TR');
        $result=Reports::rptStocktransferrequest($_); //query result
        return $this->render('salon/rep_m_stocktransferrequest',
        array('data'=>$result, 'prepared'=>$prepared,'approved'=>$approved, 'received'=>$received));
    }//END PC INDEX

    //WTODO: [KIM][2019.11.11][add option for withdrawal form]
    public function actionModulereportmi(){
        try{
            $this->layout = "@app/views/layouts/backend/printlayout";
            $_ = md5($_POST['trno']);
            
            switch ($_POST['type']) {
                case 'MIssue':
                    $prepared=$_POST['prepared'];
                    $approved=$_POST['approved'];
                    $received=$_POST['received'];
                    Yii::$app->backend->generateReportLog($_POST, 'Printed Default MI Printout' ,$_POST['trno'], 'module','MI');
                    $result=Reports::rptMaterialissueance($_); //query result
                    return $this->render('sales/mlcp/rep_m_materialissuance',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
                break;

                case 'WSlip':
                  $checked=$_POST['checked'];
                  $approved=$_POST['approved'];
                  Yii::$app->backend->generateReportLog($_POST, 'Printed Custom MI Printout (Withdrawal Slip)' ,$_POST['trno'], 'module','MI');
                  $result=Reports::rptMaterialissueance($_); //query result
                  return $this->render('sales/mlcp/rep_m_miwithdrawalslip',array('data'=>$result,'checked'=>$checked,'approved'=>$approved));
                break;
            }

        } catch (ErrorException $e) {
            echo $e;
        }
    }//END PC INDEX

    // END SALON

    public function actionModulereportkl(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $received=$_POST['received'];
        $verified=$_POST['verified'];
        $result=Reports::rptCollectionlist(); //query result
        return $this->render('sales/xanda/rep_m_collectionlist',array('data'=>$result,'prepared'=>$prepared,'received'=>$received,'verified'=>$verified));
    }//end fn
    
    public function actionModulereporttw(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['authorized'];
        $approved=$_POST['possition'];
        $_ = md5($_POST['trno']);
        $result=Reports::rpttaxwheldreport($_); //query result

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
                $view = 'payable/xanda/rep_m_taxwheld2';
            break;

            case 'DAVIDSALON_JOY':
                $view = 'payable/salon/rep_m_taxwheld2';
            break;
            
            case 'RTT':
                $view = 'payable/rtt/rep_m_taxwheld2';
            break;

            case 'UNIVERSE':
                $view = 'payable/universe/rep_m_taxwheld2';
            break;
        }//end swtich

        return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved));
    }//END TAXWHELD MODULE

    public function actionModulereportagent(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['clientid']);
        Yii::$app->backend->generateReportLog($_POST, 'Printed Default AGENT Printout' ,$_POST['clientid'],'client');
        $result=Reports::rptagentledger($_); //query result
        return $this->render('masterfile/agent/rep_m_agentledger',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END SO AGENT

    public function actionModulereportwarehouse(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['clientid']);
        Yii::$app->backend->generateReportLog($_POST, 'Printed Default WAREHOUSE Printout' ,$_POST['clientid'],'client');
        $result=Reports::rptagentledger($_); //query result
        return $this->render('masterfile/warehouse/rep_m_warehouseledger',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END WAREHOUSE
    
    public function actionModulereportcustomer(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $center = Yii::$app->session['loggeduser']['center'];
        $params = array('startdate'=>$_POST['startdate'],'reporttype'=>$_POST['customer-reporttype'], 'clientid' => $_POST['clientid']);
        $_ = md5($_POST['clientid']);
        

        $result=Reports::rptcustomerledger($_,$params,$center); //query result

        switch($params['reporttype']){
            case 'ar':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (AR)' ,$_POST['clientid'],'client');
                $view = 'masterfile/customer/rep_m_customerledgerar';
                break;
            case 'ap':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (AP)' ,$_POST['clientid'],'client');
                $view = 'masterfile/customer/rep_m_customerledgerap';
                break;
            case 'pdc':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (PDC)' ,$_POST['clientid'],'client');
                $view = 'masterfile/customer/rep_m_customerledgerpdc';
                break;
            case 'rc':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (RC)' ,$_POST['clientid'],'client');
                $view = 'masterfile/customer/rep_m_customerledgerrc';
                break;
            case 'stock':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (INV)' ,$_POST['clientid'],'client');
                $view = 'masterfile/customer/rep_m_customerledgerstock';
                break;
        }
        return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'params'=>$params));
    }//END CUSTOMER
    
    public function actionModulereportsupplier(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $center = Yii::$app->session['loggeduser']['center'];
        $params = array('startdate'=>$_POST['startdate'],'reporttype'=>$_POST['customer-reporttype'], 'clientid' => $_POST['clientid']);
        $_ = md5($_POST['clientid']);
        $result=Reports::rptsupplierledger($_,$params,$center); //query result

        switch($params['reporttype']){
            case 'ar':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (AR)' ,$_POST['clientid'],'client');
                $view = 'masterfile/supplier/rep_m_supplierledgerar';
                break;
            case 'ap':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (AP)' ,$_POST['clientid'],'client');
                $view = 'masterfile/supplier/rep_m_supplierledgerap';
                break;
            case 'pdc':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (PDC)' ,$_POST['clientid'],'client');
                 $view = 'masterfile/supplier/rep_m_supplierledgerpdc';
                break;
            case 'stock':
                Yii::$app->backend->generateReportLog($_POST, 'Printed Default CUSTOMER Printout (INV)' ,$_POST['clientid'],'client');
                 $view = 'masterfile/supplier/rep_m_supplierledgerstock';
                break;
        }//END SWITCH
        
        return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'params'=>$params));
    }//END SUPPLIER

    public function actionModulereportstockcard(){
        try {
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $center = Yii::$app->session['loggeduser']['center'];
        $params = array('startdate'=>$_POST['startdate'],
        'enddate'=>$_POST['enddate'],
        'warehouse'=>$_POST['warehouse'],
        'uom'=>$_POST['uom'],
        'loc'=>$_POST['loc'],
        'reporttype'=>$_POST['customer-reporttype']);

        $_ = md5($_POST['itemid']);

        $result=Reports::rptstockcard($_,$params,$center); //query result
        
        if(!empty($result)){
            switch($params['reporttype']){
                case 'ledger':
                    Yii::$app->backend->generateReportLog($_POST, 'Printed Default STOCKCARD Printout (LEDGER)' ,$_POST['itemid'],'item');
                    $view = 'masterfile/stockcard/rep_m_stockcardledger';
                    break;
                case 'receiving':
                    Yii::$app->backend->generateReportLog($_POST, 'Printed Default STOCKCARD Printout (RECEIVING)' ,$_POST['itemid'],'item');
                    $view = 'masterfile/stockcard/rep_m_stockcardreceiving';
                    break;
                case 'po':
                    Yii::$app->backend->generateReportLog($_POST, 'Printed Default STOCKCARD Printout (PO)' ,$_POST['itemid'],'item');
                     $view = 'masterfile/stockcard/rep_m_stockcardpo';
                    break;
                case 'so':
                    Yii::$app->backend->generateReportLog($_POST, 'Printed Default STOCKCARD Printout (SO)' ,$_POST['itemid'],'item');
                     $view = 'masterfile/stockcard/rep_m_stockcardso';
                    break;
            }
            return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'params'=>$params));
        }else{
            return 'No Data Found. Please double check Item Data Tabs.';
        }//end if

        } catch (ErrorException $e) {
            echo $e;
        }
    }//END CUSTOMER

    //JLY route form
    public function actionModulereportrf(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $submitted=$_POST['submitted'];
        $approved=$_POST['approved'];
        $trno=$_POST['trno'];



        $totalcustomers = Yii::$app->backend->countCustomersOnTrans('RF',$trno);
        $grandtotaltrnx = Yii::$app->backend->countTrnxTagged('RF',$trno);
        $grandtotalamt = Yii::$app->backend->getGrandtotalAmount('RF',$trno);
        $grandtotalamt = number_format($grandtotalamt,Yii::$app->systemsettings->setDecimaldisplay('currency'));

        $type=$_POST['reporttype'];
        $view='';
        switch ($type) {
            case 'unserved':
                $result=Reports::rptrfunserved($trno);        
                
                $view='sales\xanda\rep_m_unservedso';
                break;
            
            case 'default':
                $result=Reports::rptRFRouteform($trno);     
                $view='sales/xanda/rep_m_routeform';
                break;
        }

         


        return $this->render($view,array('data'=>$result,'grandtotaltrnx'=>$grandtotaltrnx,'approved'=>$approved,'submitted'=>$submitted,'grandtotalamt'=>$grandtotalamt,'totalcustomer'=>$totalcustomers));

    }


    public function actionModulereporttx(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $noted=$_POST['noted'];
        $trno=$_POST['trno'];
        $result=Reports::rptTXRoutehead($trno);
        $result2=Reports::rptTXRoutedetails($trno);

        return $this->render('sales/xanda/rep_m_routeguide',array('data'=>$result,'data2'=>$result2,'prepared'=>$prepared,'noted'=>$noted));
    }

    public function actionModulereporttx2(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        
        $trno=$_POST['trno'];

        $totalcustomers = Yii::$app->backend->countCustomersOnTrans('TX',$trno);
        $grandtotaltrnx = Yii::$app->backend->countTrnxTagged('TX',$trno);
        $grandtotalamt = Yii::$app->backend->getGrandtotalAmount('TX',$trno);
        $grandtotalamt = number_format($grandtotalamt,Yii::$app->systemsettings->setDecimaldisplay('currency'));


        $type=$_POST['reporttype'];
        $view='';

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
                switch($type){
                    case 'dispatch':
                        $submitted=$_POST['patchsubmitted'];
                        $approved=$_POST['patchapproved'];
                        $view='sales/xanda/rep_m_dispatch';
                        $result=Reports::rptTXDispatch($trno);
                        $arr=array('data'=>$result,'submitted'=>$submitted,
                        'approved'=>$approved,'totalcustomer'=>$totalcustomers,'grandtotaltrnx'=>$grandtotaltrnx);
                        break;

                    case 'default':
                        $prepared=$_POST['prepared'];
                        $checked=$_POST['checked'];
                        $view='sales/xanda/rep_m_translip';
                        $result=Reports::rptTXTransslip($trno);

                        $arr=array('data'=>$result,'prepared'=>$prepared,'checked'=>$checked,'totalcustomer'=>$totalcustomers,'grandtotaltrnx'=>$grandtotaltrnx,'grandtotalamt'=>$grandtotalamt);
                        break;

                    case 'postdelivery':

                        $submitted=$_POST['postdelsubmitted'];
                        $approved=$_POST['postdelapproved'];
                        $attached=$_POST['attached'];
                        $checked=$_POST['postdelchecked'];
                        $noted=$_POST['noted'];
                        $view='sales/xanda/rep_m_postdelivery';
                        $result=Reports::rptTXPostdelivery($trno);

                        $arr=array('data'=>$result,'submitted'=>$submitted,'approved'=>$approved,'attached'=>$attached,'checked'=>$checked,'noted'=>$noted,'totalcustomer'=>$totalcustomers,'grandtotaltrnx'=>$grandtotaltrnx);

                        break;

                }//END SWITCH
                break;
            
            default:
                $view='sales/xanda/rep_m_translip';
                $result=Reports::rptTXTransslip($trno);

                $arr=array('data'=>$result,'prepared'=>$prepared,'checked'=>$checked,'totalcustomer'=>$totalcustomers,'grandtotaltrnx'=>$grandtotaltrnx,'grandtotalamt'=>$grandtotalamt);
                break;
        }//end switch        


        

        
        return $this->render($view,$arr);


    }

     public function actionModulereportqa(){

        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $type=$_POST['reporttype'];
        $_ = md5($_POST['trno']);
        $result=Reports::rptQuotation($_); //query result
       
        $view='';
                
        switch (Yii::$app->systemsettings->companyConfig()) {
            default:
                $view='sales/rep_m_quotation';
            break;
        }//end switch        

        return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END SO INDEX
    
    // SALES

    public function actionModulereportso(){
        
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $type=$_POST['reporttype'];
        $_ = md5($_POST['trno']);
        $result=Reports::rptSalesorder($_); //query result
        $view='';
        
        Yii::$app->backend->generateReportLog($_POST, 'Printed Default SO Printout' ,$_POST['trno'], 'module','SO');

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SOUTHCENTRAL':
                switch($type){
                    case 'warehouse':
                        $view='sales/xanda/rep_m_salesbywh';
                    break;

                    default:
                        $view='sales/xanda/rep_m_salesorder';
                    break;
                }//END SWITCH
            break;
            
            case 'INDUSTRIA':
                $view='sales/industria/rep_m_salesorder';
            break;

            case 'UNIVERSE':
                $view='sales/universe/rep_m_salesorder';
            break;

            case 'PANDATOOLS':
                $view='sales/panda/rep_m_salesorder';
            break;

            /*case 'FHI':
                $view='sales/FHI/SO/rep_m_salesorder';
            break;*/

            default:
                $view='sales/rep_m_salesorder';
            break;
        }//end switch        

        return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END SO INDEX

    public function actionModulereportsj(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $_ = md5($_POST['trno']);
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];

        Yii::$app->backend->generateReportLog($_POST, 'Printed DEFAULT SJ Printout' ,$_POST['trno'], 'module','SJ');

        //WTODO: [KIM][2019.11.20][add switch case for additional option for sj printout]
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'MLCP':
                $sjtype=$_POST['sjtype'];
            break;
        }//END SWITCH

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'TENPLUS':
                $reportlabel = $_POST['sjreportlabel'];
                break;
            
            default:
                $reportlabel = '';    
            break;
        }//END SWWITCH

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'CANUMAY':
                $delivered=$_POST['delivered'];
                $checked=$_POST['checked'];
                $outputtype = $_POST['outputtype'];
            break;
            
            default:
                $received=$_POST['received'];
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'YULICK':
                        $pqty = $_POST['sjamountlabel'];
                    break;

                    default:
                        $pqty = "";
                        break;
                }//end switch
            break;
        }//end swtich

         
         switch (Yii::$app->systemsettings->companyConfig()) {
            case 'INFINITEA':
                $result=Reports::rptSalesinvoiceinfinitea($_); //query result
            break;
            
            case 'YULICK':
                $result=Reports::rptSalesinvoiceyulick($_); //query result
            break;
            
            case 'FHI':
                if($_POST['sjreportlabel'] == 5){
                    $wh = explode('~',$_POST['fhiwh']);
                    $whcode = $wh[1];
                    $result=Reports::rptSalesinvoice_BodegaWH($_,$whcode); //query result
                }else{
                    $result=Reports::rptSalesinvoice($_); //query result
                }//end if
            break;

            default:
                $result=Reports::rptSalesinvoice($_); //query result
            break;
         }//END SWTICH 

        switch (Yii::$app->systemsettings->companyConfig()) {
            // PANDATOOLS UPDATE
            case 'PANDATOOLS':
                $sj="sales/panda/rep_m_salesinvoice";
            break;

            case 'TONRENTANG':
                $sj="sales/tonrentang/rep_m_salesinvoice";
            break;

            case 'CANUMAY':
                $sj="sales/canumay/rep_m_salesinvoice";
            break;

            case 'TENPLUS':
                $sj="sales/tenplus/rep_m_salesinvoice";
            break;

            case 'UNIVERSE':
                switch ($_POST['sjreportlabel']) {
                    case 1:
                        $sj="sales/universe/rep_m_salesinvoice"; 
                        break;
                    case 2:
                        $sj="sales/universe/rep_m_drwcbatch";
                    break;
                }//end swtich
            break;

            //WTODO: [JLY][FHI][11.25.2019][SJ reps]
            case 'FHI':
                switch ($_POST['sjreportlabel']) {
                    case 1:
                        $sj="sales/fhi/SJ/rep_m_cashinvoice"; 
                        break;
                    case 2:
                        $sj="sales/fhi/SJ/rep_m_deliveryreceipt";
                        break;  
                    case 3:
                        $sj="sales/fhi/SJ/rep_m_salesinvoice"; 
                        break;
                    case 4:
                        $sj="sales/fhi/SJ/rep_m_ssdr"; 
                    break;

                    case 5:
                        $sj="sales/fhi/SJ/rep_m_bodegawh"; 
                    break;
                }//end swtich
            break;

           //WTODO: [KIM][2019.09.19][add case for MLCP]
            case 'MLCP':
                //WTODO: [KIM][2019.11.20][add switch case for additional option for sj]
                switch ($sjtype) {
                    case 'sjlx':
                        $sj="sales/mlcp/rep_m_mlcpsalesinvoicelx";
                    break;
                    
                    default:
                        $sj="sales/rep_m_mlcpsalesinvoice";
                    break;
                }//end switch
            break;

             //WTODO:[JLY][2019.09.16][DR REPORT]
            case 'KINGGEORGE': 
                $sj="sales/hgc/rep_m_salesinvoice";
            break;
            
            default: 
                $sj="sales/rep_m_salesinvoice";
            break;
        }//END SWITCH CASE
        
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'TENPLUS':
                $arrparams = ['data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'sjlabel'=>$reportlabel];
            break;

            case 'CANUMAY':
                $arrparams = ['data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'delivered'=>$delivered,'checked'=>$checked,'outputtype'=>$outputtype];
            break;

            case 'FHI':
                if($_POST['sjreportlabel'] == 5){
                    $wh = $_POST['fhiwh'];
                    $arrparams = ['data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'wh'=>$wh];
                }else{
                    $arrparams = ['data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received];
                }//end if
            break;
            
            default:
                $arrparams = ['data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'pqty'=>$pqty];
            break;
        }//END SWITCH CASE

        return $this->render($sj,$arrparams);
    }//END SJ INDEX

   //WTODO: [KIM][2019.10.06][actionModulereportJB]
    public function actionModulereportjb(){
        try {
        $this->layout = "@app/views/layouts/backend/printlayout";

        $trno = $_POST['trno'];

        switch ($_POST['type']) {
            case 'JBjoborder':
                $prepared = $_POST['prepared'];
                $reviewed = $_POST['reviewed'];
                $approved = $_POST['approved'];
                $noted = $_POST['noted'];
                
                $result = Reports::rptJBJobOrder($trno);
                
                return $this->render('production/rep_m_jbjoborder',array('data'=>$result,'prepared'=>$prepared,'reviewed'=>$reviewed,'approved'=>$approved,'noted'=>$noted));
            break;
            case 'JBblowing':
                $prepared = $_POST['prepared'];
                $approved = $_POST['approved'];
                $operator = $_POST['operator'];

                $result = Reports::rptJBBlowing($trno);
                return $this->render('production/rep_m_jbblowing',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'operator'=>$operator));
            break;
            case 'JBmatreq':
                $prepared = $_POST['prepared'];
                $received = $_POST['received'];
                $released = $_POST['released'];
                $approved = $_POST['approved'];

                $result = Reports::rptJBMatRequest($trno);
                return $this->render('production/rep_m_jbmatreq',array('data'=>$result,'prepared'=>$prepared,'received'=>$received,'released'=>$released,'approved'=>$approved));
            break;
            case 'JBdailydel':
                $prepared = $_POST['prepared'];

                $result = Reports::rptJBDailyDelivery($trno);
                return $this->render('production/rep_m_jbdailydel',array('data'=>$result,'prepared'=>$prepared));
            break;
            case 'JBslitlaminate':
                $prepared = $_POST['prepared'];
                $operator = $_POST['operator'];
                $reported = $_POST['reported'];
                $leadman = $_POST['leadman'];

                $result = Reports::rptJBSlitLaminate($trno);
                return $this->render('production/rep_m_jbslitlaminate',array('data'=>$result,'prepared'=>$prepared,'operator'=>$operator,'reported'=>$reported,'leadman'=>$leadman));
            break;
            case 'JBprinting':
                $prepared = $_POST['prepared'];
                $operator = $_POST['operator'];
                $leadman = $_POST['leadman'];
                $result = Reports::rptJBPrinting($trno);
                return $this->render('production/rep_m_jbprinting',array('data'=>$result,'prepared'=>$prepared,'operator'=>$operator,'leadman'=>$leadman));
            break;
            case 'JBcuttingreject':
                $prepared = $_POST['prepared'];
                $checked = $_POST['checked'];
                $result = Reports::rptJBCuttingReject($trno);
                return $this->render('production/rep_m_jbcuttingreject',array('data'=>$result,'prepared'=>$prepared,'checked'=>$checked));
            break;
            case 'JBinspect':
                
                $prepared = $_POST['prepared'];
                $checked = $_POST['checked'];
                $leadman = $_POST['leadman'];
                $released = $_POST['released'];
                $received = $_POST['received'];

                $result = Reports::rptJBInspect($trno);
                return $this->render('production/rep_m_jbinspect',array('data'=>$result,'prepared'=>$prepared,'checked'=>$checked,'leadman'=>$leadman,'released'=>$released,'received'=>$received));
            break;
            
         }//end swithc   
            
        } catch (ErrorException $e) {
            echo $e;
        }
        
    }//end fn for JB

    public function actionModulereportcm(){
        try {
            
        $this->layout = "@app/views/layouts/backend/printlayout";
        $_ = md5($_POST['trno']);
        switch(Yii::$app->systemsettings->companyConfig()){
            case 'CANUMAY':
                $checked=$_POST['checked'];
                $customer=$_POST['customer'];
            break;

            default:
                $prepared=$_POST['prepared'];
                $approved=$_POST['approved'];
                $received=$_POST['received'];
            break;
        }//end switch
        
        Yii::$app->backend->generateReportLog($_POST, 'Printed CUSTOM CM Printout' ,$_POST['trno'], 'module','CM');
        $result=Reports::rptSalesreturn($_); //query result
            
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'CANUMAY':
                return $this->render('sales/canumay/rep_m_salesreturn',array('data'=>$result,'checked'=>$checked,'customer'=>$customer));
            break;
            
            case 'PANDATOOLS':
                return $this->render('sales/panda/rep_m_salesreturn',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
            break;

            case 'MLCP':
                return $this->render('sales/mlcp/rep_m_salesreturn',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
            break;

            default:
                return $this->render('sales/rep_m_salesreturn',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
            break;
        }//END SWTICH
        
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END CM INDEX    


    // PURCHASES

    public function actionModulereportpr(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        Yii::$app->backend->generateReportLog($_POST, 'Printed Default PR Printout' ,$_POST['trno'], 'module','PR');
        $result=Reports::rptrequisitionslip($_); //query result
        return $this->render('purchases/rep_m_requisitionslip',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END PR INDEX

    public function actionModulereportpo(){
        try {
            
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default PO Printout' ,$_POST['trno'], 'module','PO');
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'DAVIDSALON_JOY':
                $received2=$_POST['received2'];
                $received3=$_POST['received3'];
                $received4=$_POST['received4'];    
            break;

            case 'UNIVERSE': case 'MLCP':
                $potype=$_POST['potype'];
            break;

            //WTODO: [JLY][FHI][11.26.2019][PO MOD FORMAT]
            case 'FHI':
                $potype=$_POST['poopt'];
            break;
        }//END SWITCH

        $_ = md5($_POST['trno']);
        
        $result=Reports::rptpurchasereport($_); //query result
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                return $this->render('purchases/universe/rep_m_purchaseorder',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'potype'=>$potype));
            break;

            case 'PANDATOOLS':
                return $this->render('purchases/pandatools/rep_m_purchaseorder',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
            break;

            case 'MLCP':
                switch ($potype) {
                    case 'service':
                        $rpt = 'purchases/mlcp/rep_m_purchaseorderservice';
                    break;

                    case 'servicelx':
                        $rpt = 'purchases/mlcp/rep_m_purchaseorderservicelx';
                    break;

                    //WTODO: [KIM][2019.11.15][add option for PO printout]
                    case 'polx':
                        $rpt = 'purchases/mlcp/rep_m_purchaseorderlx';
                    break;

                    default:
                        $rpt = 'purchases/mlcp/rep_m_purchaseorder';
                    break;
                }//end switch

                $rep_params = array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received);
                return $this->render($rpt,$rep_params);
            break;

            //WTODO: [JLY][FHI][11.26.2019][PO MOD FORMAT]
            case 'FHI':
                switch ($potype) {
                    case 'wh':
                        $rpt = 'purchases/fhi/rep_m_po_wh';
                    break;
                    
                    default:
                        $rpt = 'purchases/fhi/rep_m_po_opis';
                    break;
                }
                
                $rep_params = array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received);
                return $this->render($rpt,$rep_params);
            break;

            default:
                return $this->render('purchases/rep_m_purchaseorder',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
            break;    
        }//end switch case   

        } catch (ErrorException $e) {
            echo $e;
        }     
    }//END PO INDEX

    public function actionModulereportrr(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default RR Printout' ,$_POST['trno'], 'module','RR');
 
        $result=Reports::rptReceivingreport($_); //query result

        switch (Yii::$app->systemsettings->companyConfig()) {
            
            case 'SOUTHCENTRAL': 
                $rr='purchases/xanda/rep_m_receivingreport';
                    break;

            case 'TENPLUS':
                $rr='purchases/tenplus/rep_m_receivingreport';
            break;

            case 'TONRENTANG':
                $rr='purchases/tonrentang/rep_m_receivingreport';
            break;

            case 'PANDATOOLS':
                $rr='purchases/pandatools/rep_m_receivingreport';
            break;

            case 'UNIVERSE':
                $rr='purchases/universe/rep_m_receivingreport';
            break;

            case 'MLCP': 
                $rr='purchases/mlcp/rep_m_receivingreport';
            break;        

            default: 
                $rr='purchases/rep_m_receivingreport';
            break;        

        }//end switch

        return $this->render($rr,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END RR INDEX

    public function actionModulereportdm(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        Yii::$app->backend->generateReportLog($_POST, 'Printed Default DM Printout' ,$_POST['trno'], 'module','DM');
        $result=Reports::rptPurchasereturn($_); //query result
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'UNIVERSE':
                $rpt = "purchases/universe/rep_m_purchasereturn";
            break;
        
            case 'PANDATOOLS':
                $rpt = "purchases/pandatools/rep_m_purchasereturn";
            break;

            default:
                $rpt = "purchases/rep_m_purchasereturn";
            break;
        }//end switch
        return $this->render($rpt,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END DM INDEX


    // INVENTORY

    public function actionModulereportis(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default IS Printout' ,$_POST['trno'], 'module','IS');
        $result=Reports::rptInventorysetup($_); //query result

        switch(Yii::$app->systemsettings->companyConfig()){
            case 'PANDATOOLS':
                $rpt = 'inventory/pandatools/rep_m_inventorysetup';
            break;
            
            default:
                $rpt = 'inventory/rep_m_inventorysetup';
            break;
        }//end switch

        return $this->render($rpt,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END IS INDEX

    public function actionModulereportpc(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default PC Printout' ,$_POST['trno'], 'module','PC');
        $result=Reports::rptPhysicalcount($_); //query result
        return $this->render('inventory/rep_m_physicalcount',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END PC INDEX

    public function actionModulereportaj(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default AJ Printout' ,$_POST['trno'], 'module','AJ');
        $result=Reports::rptInventoryadjusment($_); //query result

        switch(Yii::$app->systemsettings->companyConfig()){
            case 'PANDATOOLS':
                $rpt = 'inventory/pandatools/rep_m_inventoryadjustment';
            break;
            
            default:
                $rpt = 'inventory/rep_m_inventoryadjustment';
            break;
        }//end switch

        return $this->render($rpt,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END AJ INDEX

    public function actionModulereportts(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        $result=Reports::rptTransperslip($_); //query result

        switch(Yii::$app->systemsettings->companyConfig()){
            case 'GAMELINE_POS':
                $view='inventory/shinji/rep_m_transferslipgmcc';
            break;

            case 'MLCP':
                $view='inventory/mlcp/rep_m_transferslip';
            break;

            default:
                $view='inventory/rep_m_transferslip';
            break;
        }//end switch

        return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END TS INDEX    


    //PAYABLES

    public function actionModulereportap(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default AP Printout' ,$_POST['trno'], 'module','AP');
        $result=Reports::rptAPsetup($_); //query result
        return $this->render('payable/rep_m_apsetup',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END AP INDEX 

    public function actionModulereportpv(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default PV Printout' ,$_POST['trno'], 'module','PV');
        $result=Reports::rptAccountspayablevoucher($_); //query result
        
        return $this->render('payable/rep_m_apv',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END PV INDEX  

    public function actionModulereportbir(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        // $received=$_POST['received'];
        $_ = md5($_POST['trno']);

       
        $result=Reports::rptAccountspayablevoucher_bir($_); //query result
        return $this->render('payable/rep_m_bir',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved));
    }//END BIR INDEX  


    public function actionModulereportquoteqw(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $quoted = $_POST['quoted'];
        $approved = $_POST['approved'];
        $position = $_POST['position'];
        $trno = $_POST['trno'];
        $result = Reports::rptQuotationWCompany($trno);
        return $this->render('sales/mlcp/rep_m_quotewcompany',array('data'=>$result,'quoted'=>$quoted,'approved'=>$approved,'position'=>$position));
    }//end act


    public function actionModulereportquoteqwo(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $quoted = $_POST['quoted'];
        $approved = $_POST['approved'];
        $position = $_POST['position'];
        $trno = $_POST['trno'];

        $result = Reports::rptQuotationWOCompany($trno);
        return $this->render('sales/mlcp/rep_m_quotewocompany',array('data'=>$result,'quoted'=>$quoted,'approved'=>$approved,'position'=>$position));
        
    }//end act

    //WTODO: [KIM][2019.11.20][update function for modulereportcv]
    public function actionModulereportcv(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $_ = md5($_POST['trno']);

        //WTODO: [KIM][2019.11.20][add switch case for additional option for cv printout]
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'MLCP':
                $cvtype=$_POST['cvtype'];
            break;
        }//END SWITCH
      
        //WTODO: [JLY][8.22.2019][KINGG][EDIT QRY REPORTS START]
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'KINGGEORGE':
                $result=Reports::rptCashVoucherkingg($_); //query result
            break;
            default:
                $result=Reports::rptCashVoucher($_); //query result
            break;
        }//end switch
        //WTODO: [JLY][8.22.2019][KINGG][EDIT QRY REPORTS END]

       
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'RTT':
                $prepared=$_POST['prepared'];
                $approved=$_POST['approved'];
                $received=$_POST['received'];
                $checked=$_POST['checked'];
               switch ($_POST['cvreportlabel']) {
                    case 1:
                        $cv="payable/rtt/rep_m_cashcheckvouchera";
                        break;
                    case 2:
                        $cv="payable/rtt/rep_m_cashcheckvoucherb";
                        break;
                    case 3:
                        $cv="payable/rtt/rep_m_cashcheckvouchercheck";
                        break;    
                }//end switch case for sjreportlabel

                return $this->render($cv,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'checked'=>$checked));
            break;

            case 'UNIVERSE': 
                switch ($_POST['cvreportlabel']) {
                    case 1:
                        $prepared=$_POST['prepared'];
                        $approved=$_POST['approved'];
                        $received=$_POST['received'];
                        $checked=$_POST['checked'];

                        Yii::$app->backend->generateReportLog($_POST, 'Printed Default CV Printout (Voucher)' ,$_POST['trno'], 'module','CV');
                        $cv="payable/universe/rep_m_cashcheckvouchera";

                        return $this->render($cv,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'checked'=>$checked));
                    break;
                    
                    case 2:
                        $client2 = $result[0]['clientname']; 
                        Yii::$app->backend->generateReportLog($_POST, 'Printed Default CV Printout (Check)' ,$_POST['trno'], 'module','CV');
                        $cv="payable/rep_m_cashcheckvouchercheckchina";
                        return $this->render($cv,array('data'=>$result,'client2'=>$client2));
                    break;
                }//end switch
            break;

            //WTODO: [KIM][2019.11.20][add case for MLCP]
            case 'MLCP':
                switch ($cvtype) {
                    case 2:
                        $prepared=$_POST['prepared'];
                        $approved=$_POST['approved'];
                        $received=$_POST['received'];
                        $checked=$_POST['checked'];

                        $cv="payable/mlcp/rep_m_cashcheckvoucherlx";
                        return $this->render($cv,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,
                        'received'=>$received,'checked'=>$checked));
                    break;

                    case 3:             
                        //WTODO: [KIM][2019.11.25][add textbox]
                        if ($_POST["opt2paramstextbox"] != ""){
                            $client2 = $_POST['opt2paramstextbox'];
                        }else{
                            $client2 = $result[0]['clientname']; 
                        }//end 

                        switch ($_POST["optparamslabel"]) {
                            case 1: //Chinabank
                                $cv="payable/rep_m_cashcheckvouchercheckchina";
                            break;
                            case 2://MetroBank
                                $cv="payable/rep_m_cashcheckvouchercheckmetro";
                            break;
                            case 3://BusinessBank
                               $cv="payable/rep_m_cashcheckvouchercheckbusinessbank";
                            break;
                        }//end 2nd lvl switch

                        return $this->render($cv,array('data'=>$result,'client2'=>$client2));
                    break;

                    case 4:
                        //WTODO: [KIM][2019.11.25][add textbox]
                        if ($_POST["opt2paramstextbox"] != ""){
                            $client2 = $_POST['opt2paramstextbox'];
                        }else{
                            $client2 = $result[0]['clientname']; 
                        }//end 

                        switch ($_POST["opt2paramslabel"]) {
                            case 1: //Chinabank
                                $cv="payable/mlcp/rep_m_cashcheckvouchercheckchinalx";
                            break;
                            case 2://MetroBank
                                $cv="payable/mlcp/rep_m_cashcheckvouchercheckmetrolx";
                            break;
                            case 3://BusinessBank
                               $cv="payable/mlcp/rep_m_cashcheckvouchercheckbusinessbanklx";
                            break;
                        }//end 2nd lvl switch

                        return $this->render($cv,array('data'=>$result,'client2'=>$client2));
                    break;
                    
                    default:
                        $prepared=$_POST['prepared'];
                        $approved=$_POST['approved'];
                        $received=$_POST['received'];
                        $checked=$_POST['checked'];

                        $cv="payable/mlcp/rep_m_cashcheckvoucher";
                        return $this->render($cv,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'checked'=>$checked));
                    break;
                }//end switch

            break;

            default: 
            try {
                switch ($_POST['cvreportlabel']) {
                    case 1:
                        $prepared=$_POST['prepared'];
                        $approved=$_POST['approved'];
                        $received=$_POST['received'];
                        $checked=$_POST['checked'];
                        //WTODO: [JLY][8.22.2019][KINGG][EDIT REPORTS START]
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'KINGGEORGE':
                                $cv="payable/kingg/rep_m_cashcheckvoucher";
                            break;
                            default:
                                $cv="payable/rep_m_cashcheckvoucher";
                            break;
                        }//end switch

                        return $this->render($cv,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'checked'=>$checked));
                        //WTODO: [JLY][8.22.2019][KINGG][EDIT REPORTS END]
                    break;
                    
                    case 2:
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'KINGGEORGE':
                                $cv="payable/rep_m_cashcheckvouchercheckchina";
                                $client2 = $result[0]['clientname']; 
                            break;

                            case 'MLCP':
                                switch ($_POST['optparamslabel']) {
                                    case 1: //Chinabank
                                        $cv="payable/rep_m_cashcheckvouchercheckchina";
                                    break;
                                    case 2://MetroBank
                                        $cv="payable/rep_m_cashcheckvouchercheckmetro";
                                    break;
                                    case 3://BusinessBank
                                       $cv="payable/rep_m_cashcheckvouchercheckbusinessbank";
                                    break;
                                }//end 2nd lvl switch
                            break;

                            case 'GALANG':
                                $cv="payable/rep_m_cashcheckvouchercheckchina";
                                $client2 = $result[0]['clientname']; 
                            break;
                        }//end switch

                        return $this->render($cv,array('data'=>$result,'client2'=>$client2));
                    break;
                }//end switch

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;
        }//END SWITCH CASE
        // return $this->render($cv,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received,'checked'=>$checked));
    }//END CV INDEX           


    //RECEIVABLE

    public function actionModulereportar(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default AR Printout' ,$_POST['trno'], 'module','AR');
        $result=Reports::rptARsetup($_); //query result
        return $this->render('receivable/rep_m_arsetup',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END AR INDEX 

    public function actionModulereportkr(){
        try {
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default KR Printout' ,$_POST['trno'], 'module','KR');
        $result=Reports::rptCounterreceipt($_); //query result
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'MLCP':
                $kr='receivable/mlcp/rep_m_counterreceipt';
            break;

            case 'GALANG':
                $kr='receivable/galang/rep_m_counterreceipt';
            break;

            case 'RTT': 
                $kr='receivable/rtt/rep_m_counterreceipt';
            break;

            case 'UNIVERSE': 
                $kr='receivable/universe/rep_m_counterreceipt';
            break;

            default:
                $kr='receivable/rep_m_counterreceipt';
            break;
        }
        return $this->render($kr,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
        
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//END KR INDEX

    public function actionModulereportcr(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default CR Printout' ,$_POST['trno'], 'module','CR');
        $result=Reports::rptReceivedpayment($_); //query result
        return $this->render('receivable/rep_m_receivedpayment',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END CR INDEX

    public function actionModulereportds(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default DS Printout' ,$_POST['trno'], 'module','DS');
        $result=Reports::rptDepositSlip($_); //query result
        return $this->render('account/rep_m_depositslip',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END CR INDEX

    //ACCOUNTS         

    public function actionModulereportbankrecon(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $start=$_POST['startdate'];
        $end=$_POST['enddate'];
        $contra = explode('~',$_POST['contra']);
        $acno = $contra[0];
        $gby=$_POST['gatherby'];
        $result = Yii::$app->backend->openBankBook($start,$end,$acno,$gby,'','');
        return $this->render('account/rep_m_bankrecon',array('contra'=>$contra,'data'=>$result,'gby'=>$gby,'acno'=>$acno,'end'=>$end,'start'=>$start));     
    }//END SO AGENT
    
    public function actionModulereportgj(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);

        Yii::$app->backend->generateReportLog($_POST, 'Printed Default GJ Printout' ,$_POST['trno'], 'module','GJ');
        //WTODO: [JLY][2019.08.19][KINGG CONCERNS][EDIT REPORT]
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'KINGGEORGE':
                        $result=Reports::rptGeneraljournalkingg($_); //query result
                        $view='account/kingg/rep_m_generaljournalkingg';
                    break;
                    default:
                        $result=Reports::rptGeneraljournal($_); //query result
                        $view='account/rep_m_generaljournal';
                    break;

                }//end switch
        
        return $this->render($view,array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END GJ INDEX

    // PRODUCTION

    public function actionModulereportpi(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        $result=Reports::rptproductionins($_); //query result
        return $this->render('production/rep_m_productioninstruction',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END SO INDEX

    public function actionModulereportpd(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        $result=Reports::rptproductionorder($_); //query result
        return $this->render('production/rep_m_productionorder',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END SO INDEX

    public function actionModulereportpk(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        $result=Reports::rptproductioncom($_); //query result
        return $this->render('production/rep_m_productioncompletion',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END SO INDEX

    public function actionModulereportsp(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared=$_POST['prepared'];
        $approved=$_POST['approved'];
        $received=$_POST['received'];
        $_ = md5($_POST['trno']);
        Yii::$app->backend->generateReportLog($_POST, 'Printed Default SPC Printout' ,$_POST['trno'], 'module','SP');
        $result=Reports::rptSupplierPriceChange($_); //query result
        return $this->render('universe/rep_m_supplierpricechange',array('data'=>$result,'prepared'=>$prepared,'approved'=>$approved,'received'=>$received));
    }//END SP INDEX
    

    public function actionModulereportdr(){
        try {
        $this->layout = "@app/views/layouts/backend/printlayout";
        $trno = $_POST['trno'];
        Yii::$app->backend->generateReportLog($_POST, 'Printed CUSTOM SJ Printout (without BATCH)' ,$_POST['trno'], 'module','SJ');
        $result = Reports::rptSalesDRbatch($trno);
        return $this->render('sales/universe/rep_m_drwobatch',array('data'=>$result));
        } catch (ErroException $e) {
            echo $e;
        }
    }//end fn


    public function actionModulereportwdr(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $trno = $_POST['trno'];
        Yii::$app->backend->generateReportLog($_POST, 'Printed CUSTOM SJ Printout (with BATCH)' ,$_POST['trno'], 'module','SJ');
        $result = Reports::rptSalesDRwbatch($trno);
        return $this->render('sales/universe/rep_m_drwbatch',array('data'=>$result));
    }//end fn


     public function actionModulereportdrcharge(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $trno = $_POST['trno'];
        Yii::$app->backend->generateReportLog($_POST, 'Printed CUSTOM SJ Printout (Charge Sales Invoice)' ,$_POST['trno'], 'module','SJ');
        $result = Reports::rptSalesDRchargesales($trno);
        return $this->render('sales/universe/rep_m_drchargesales',array('data'=>$result));
    }//end fn


    public function actionModulereportdrpickslip(){
        $this->layout = "@app/views/layouts/backend/printlayout";
        $prepared = $_POST['prepared'];
        $picked = $_POST['picked'];
        $checked = $_POST['checked'];
        $trno = $_POST['trno'];

        Yii::$app->backend->generateReportLog($_POST, 'Printed CUSTOM SJ Printout (Pick Slip)' ,$_POST['trno'], 'module','SJ');
        $result = Reports::rptSalesDRpickslip($trno);
        
        return $this->render('sales/universe/rep_m_drpickslip',array('data'=>$result,'prepared'=>$prepared,'picked'=>$picked,'checked'=>$checked));
    }


    //ACTION FOR PRINTING REPORT ON REPORT LIST
    public function actionPrintreport(){
        Yii::$app->view->params['printing_type'] = $_POST['printing_type'];
        $this->layout = "@app/views/layouts/backend/printlayout";
        $report = $_POST['reportname'];
        Yii::$app->session['reportname'] = $report;

        switch ($report) {
            //ITEM
            case 'Daily Collection (Victory Mall)':
                return $this->render('reportlist/customer/rep_c_dailycollection');
            break;

            case 'Tax Wheld':
                $params = array('client'=>$_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'autorep'=>$_POST['autorep'],'possition'=>$_POST['possition']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rpttaxwheld($params); //query result
                return $this->render('masterfile/taxwheld/rep_m_taxwheld',array('data'=>$result,'params'=>$params));
            break;

            //KINGGEORGES
            case 'Sales Item Per Report Per DR':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSalesItemPerReportPerDR_KINGG($params); //query result
                return $this->render('reportlist/item/kinggeorge/rep_items_salesitemperreportperdr',array('data'=>$result,'params'=>$params));
            break;

            case 'Sales Agent Report':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'agent'=>$_POST['agent'],'poststatus'=>$_POST['poststatus']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptSalesAgentReport_KINGG($params); //query result

                return $this->render('reportlist/agent/kinggeorge/rep_salesagentreport',array('data'=>$result,'params'=>$params));
            break;

            case 'Item List':
            try {
                $params = array('itemtype'=>$_POST['itemtype'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'status'=>$_POST['customer-itemstatus']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptITEM_List($params); //query result

                return $this->render('reportlist/item/rep_items_itemlist',array('data'=>$result,'params'=>$params));
            } catch (ErrorException $e) {
                echo $e;
            }//end if
            break;
            
            case 'Inventory Balance':
            try {
                $params = array('asof'=>$_POST['enddate2'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'category'=>$_POST['part'],
                'categoryid'=>$_POST['partid'],
                'itemtype'=>$_POST['itemtype'],'itemstock'=>$_POST['itemstock'],
                'amountformat'=>$_POST['amountformat'],'wh'=>$_POST['warehouse'],
                'model'=>$_POST['modelname'],'modelid'=>$_POST['modelid'],'brand'=>$_POST['repbrand'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid']);
                
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptInventory_Balance($params,$center); //query result
                $amtformat = $params['amountformat'];
               
               switch($amtformat){
                case 'isamt':
                     $view = 'reportlist/item/universe/rep_items_uniinventorybalanceisamt';
                    break;

                case 'rrcost':
                    $view = 'reportlist/item/universe/rep_items_uniinventorybalancerrcost';
                    break;

                 case 'none':
                    $view = 'reportlist/item/universe/rep_items_uniinventorybalance';
                   break;
                }//end switch
                
                return $this->render($view,array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            case 'Analyze Item Purchase (Monthly)':
            try {
               $params = array('year'=>$_POST['year'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'brand'=>$_POST['repbrand'],
                'itemtype'=>$_POST['itemtype'],'analyzedby'=>$_POST['analyzedby'],
                'wh'=>$_POST['warehouse'],'poststatus'=>$_POST['poststatus'],'unit'=>$_POST['item-unit']);


                $center = Yii::$app->session['loggeduser']['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAnalyzeitempurchase($params,$center); //query result
                $rpt = 'reportlist/item/rep_items_analyzeitempurchasemonthly';
               
                return $this->render($rpt,array('data'=>$result,'params'=>$params));
            } catch (ErrorException $e) {
                echo $e;
            }
                break;

            case 'Analyze Item Sales (Monthly)':
            try {
                $params = array('year'=>$_POST['year'],'brand'=>$_POST['repbrand'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'itemtype'=>$_POST['itemtype'],'analyzedby'=>$_POST['analyzedby'],'wh'=>$_POST['warehouse'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'poststatus'=>$_POST['poststatus'],'unit'=>$_POST['item-unit']);
        
                $center = Yii::$app->session['loggeduser']['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAnalyzeitemsales($params,$center); //query result
    
                $rpt = 'reportlist/item/rep_items_analyzeitemsalesmonthly';    

                return $this->render($rpt,array('data'=>$result,'params'=>$params));
                
                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;
            
            case 'Current Inventory Aging':
            try {
                $params = array('itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'itemtype'=>$_POST['itemtype'],'wh'=>$_POST['warehouse'],'unit'=>$_POST['item-unit']);
                
                
                $center = Yii::$app->session['loggeduser']['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptcurrent_inventory_aging($params,$center); //query result

                $rpt = 'reportlist/item/rep_items_currentinventoryaging';
                return $this->render($rpt,array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;   
            }
            break;               

            case 'Fast Moving Items':
               $params = array('top'=>$_POST['top'],'item'=>$_POST['item'],'stockgrpid'=>$_POST['stockgrpid'],'group'=>$_POST['groupid'],
                'brand'=>$_POST['repbrand'],'class'=>$_POST['class'],'itemtype'=>$_POST['itemtype'],'wh'=>$_POST['warehouse'],'start'=>$_POST['startdate'],
                'end'=>$_POST['enddate'],'uom'=>$_POST['uom'],'poststatus'=>$_POST['poststatus']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptFastMovingItems($params,$center); //query result
                
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'PANDATOOLS':
                        $rpt = 'reportlist/item/panda/rep_items_fastmovingitems';
                    break;
                    
                    default:
                        $rpt = 'reportlist/item/rep_items_fastmovingitems';
                    break;
                }//END SWITCH

                return $this->render($rpt,array('data'=>$result,'params'=>$params));
            break;       

            case 'Analyze Item Sales with Profit Markup':
                $params = array('client'=>$_POST['client'],'item'=>$_POST['item'],'stockgrpid'=>$_POST['stockgrpid'],
                'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'part'=>$_POST['part'],'itemtype'=>$_POST['itemtype'],
                'wh'=>$_POST['warehouse'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'poststatus'=>$_POST['poststatus']);
                
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAnalyzeitemsaleswithprofitmarkup($params,$center); //query result
                
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'PANDATOOLS':
                        $rpt = 'reportlist/item/panda/rep_items_analyzeitemsaleswithprofitmarkup';
                    break;
                    
                    default:
                        $rpt = 'reportlist/item/rep_items_analyzeitemsaleswithprofitmarkup';
                    break;
                }//END SWITCH

                return $this->render($rpt,array('data'=>$result,'params'=>$params));
            break;    

            case 'Slow Moving Items':
            try {
               $params = array('top'=>$_POST['top'],'item'=>$_POST['item'],'stockgrpid'=>$_POST['stockgrpid'],'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'class'=>$_POST['class'],'itemtype'=>$_POST['itemtype'],'wh'=>$_POST['warehouse'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'uom'=>$_POST['uom'],'poststatus'=>$_POST['poststatus']);

                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSlowMovingItems($params,$center); //query result

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'PANDATOOLS':
                        $rpt = 'reportlist/item/panda/rep_items_slowmovingitems';
                    break;
                    
                    default:
                        $rpt = 'reportlist/item/rep_items_slowmovingitems';
                    break;
                }//END SWITCH
                
                return $this->render($rpt,array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }//ebd uf
            break;          

            case 'Sales Per Item Per Customer':
            try {
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'], 
                'option'=>$_POST['item-optionamtqty'],'ptype'=>$_POST['reporttype']);

                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSalesperitempercustomer($params,$center); //query result

                switch ($params['ptype']) {
                    case 'detailed':
                        $rpt = 'reportlist/item/rep_items_salesperitempercustomer-detailed';
                    break;
                    
                    default:
                        $rpt = 'reportlist/item/rep_items_salesperitempercustomer-summary';
                    break;
                }//end switch

                return $this->render($rpt,array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            case 'Item to Expired':
            try {
                 $params = array('asof'=>$_POST['enddate2']); 
                // $params = array('days'=>$_POST['days']);
                $center = Yii::$app->session['loggeduser']['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptInventoryexpired($params,$center); //query result

                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'PANDATOOLS':
                        $rpt = 'reportlist/item/panda/rep_items_itemexpired';
                    break;
                    
                    default:
                        $rpt = 'reportlist/item/rep_items_itemexpired';
                    break;
                }//END SWITCH

                return $this->render($rpt,array('data'=>$result));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;
            case 'Item Balance - Below Minimum': 
                //WTODO: [KIM][2019.09.05][add partid]
                $params = array('asof'=>$_POST['enddate2'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                /* 'unit'=>$_POST['item-unit'], */
                'brand'=>$_POST['repbrand'],
                'part'=>$_POST['part'],'partid'=>$_POST['partid'],
                'itemtype'=>$_POST['itemtype'],'itemstock'=>$_POST['itemstock'],'wh'=>$_POST['warehouse']
                );
                $center = Yii::$app->session['loggeduser']['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptItemminimum($params,$center); //query result
               
                return $this->render('reportlist/item/rep_item_balance_below_minimum',array('data'=>$result,'params'=>$params));
            break;
            case 'Item Balance - Above Maximum':    
            try {
                //WTODO: [KIM][2019.09.05][add partid]           
                $params = array(
                    'asof'=>$_POST['enddate2'],
                    
                    'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                    'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                    'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                    'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                    'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                    /* 'unit'=>$_POST['item-unit'], */
                    'brand'=>$_POST['repbrand'],
                    'part'=>$_POST['part'],
                    'partid'=>$_POST['partid'],
                    'wh'=>$_POST['warehouse'],
                    'itemtype'=>$_POST['itemtype']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAboveMaximum($params); //query result
                return $this->render('reportlist/item/rep_items_inventorybalance_abovemaximum',array('data'=>$result,'params'=>$params));
                
                 
             } catch (ErrorException $e) {
                 echo $e;
             } 
            break;

            //WTODO: [KIM][2019.11.11][product information sheet]
            //WTODO: [JLY][FHI][11.26.2019][unserved po-duplicate item name]
            case 'Product Information Sheet':
                $params = array('itemid'=> $_POST['itemid'],'item2'=> $_POST['item']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptProdinfoSheet($params);
                return $this->render('reportlist/production/rep_production_prodinfosheet',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.11.12][inventory checksheet]
            case 'Inventory Checksheet':
                //WTODO: [KIM][2019.10.29][add loc for filter]
                
                $strfilter = '';
                foreach ($_POST as $key => $value) {
                    if(substr($key, 0,2) == 'cb'){
                        if($strfilter == ''){
                            $strfilter .= "(" .  $value;
                        }else{
                            $strfilter .= ",".$value;
                         
                        }//end if
                    }//end if
                }//end for each

                if($strfilter != ""){
                    $strfilter .= ")";    
                }//end if

                $params = array('asof'=>$_POST['enddate2'],'wh'=>$_POST['warehouse'],
                'client'=>$_POST['client'],'loc'=>$_POST['loc'],'class'=>$strfilter);
                
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptInvCheckSheet($params);
               
                return $this->render('reportlist/item/rep_items_invchecksheet',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.10.03][unclosed job order report]
            case 'Unclosed Job Order Report':
                $params=array('client'=>$_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUnclosedJO($params);
                return $this->render('reportlist/item/mlcp/rep_items_unclosedjorep',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.10.03][partially served job order]
            case 'Partially Served Job Order':
                $params=array('client'=>$_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptPartialservedJO($params);
                
                return $this->render('reportlist/item/rep_items_partialservedjo',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.10.03][job order report]
            case 'Job Order History':
                //WTODO: [KIM][2019.11.25][add filter for date range]
                $params=array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'jobno'=>$_POST['jobnoid'],'JOtrno'=>$_POST['stockjobnoid']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptJOHistory($params);
                
                return $this->render('reportlist/item/rep_items_johistory',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.12.09][unserved job order report]
            case 'Unserved Job Order Report':
                $params=array('client'=>$_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUnservedJO($params);

                return $this->render('reportlist/item/mlcp/rep_items_unservedjorep',array('data'=>$result,'params'=>$params));
            break;

            case 'Price List':
                $params = array('pricegroup'=>$_POST['pricegroup'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                //'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVPrice_List($params);  
                
                return $this->render('reportlist/item/universe/rep_items_uvpricelist',array('data'=>$result,'params'=>$params));
            break; 
            
            case 'Supplier Price List':
                $params = array('asof'=>$_POST['effectivedate'],'supplier'=>$_POST['client'],'unit'=>$_POST['item-unit'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],'divisionid'=>$_POST['divisionid'],
                'stockdivisionid'=>$_POST['stockdivisionid']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVSUppPrice_List($params);  
                return $this->render('reportlist/item/universe/rep_items_uvsupppricelist',array('data'=>$result,'params'=>$params));
            break;

            case 'Quantity On Hand':
                $params = array('asof'=>$_POST['asof'],'unit'=>$_POST['item-unit'],'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],'wh'=>$_POST['warehouse']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVQuantityOnHand($params);   
                return $this->render('reportlist/item/universe/rep_items_uvquantityonhand',array('data'=>$result,'params'=>$params));
            break; 

            case 'Inventory Retail Market Value':
                //WTODO: [KIM][2019.09.05][add unit]
                $params = array('asof'=>$_POST['effectivedate'],
                'unit'=>$_POST['item-unit'],'principalid'=>$_POST['principalid'],
                'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'wh'=>$_POST['warehouse'],'pricegroup'=>$_POST['pricegroup']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVInvRetailMarketVal($params);   
              
                return $this->render('reportlist/item/universe/rep_items_uvinvretailmarketval',array('data'=>$result,'params'=>$params));
            break;   

            case 'Expiry Report':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'unit'=>$_POST['item-unit'],'principalid'=>$_POST['principalid'],
                'stockprincipalid'=>$_POST['stockprincipalid'],'divisionid'=>$_POST['divisionid'],
                'stockdivisionid'=>$_POST['stockdivisionid'],'wh'=>$_POST['warehouse']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVExpiryReport($params);   
                
                return $this->render('reportlist/item/universe/rep_items_uvexpiryreport',array('data'=>$result,'params'=>$params));
            break;   

            case 'Physical Inventory Sheet':
                $params = array('unit'=>$_POST['item-unit'],'wh'=>$_POST['warehouse'],
                'include'=>$_POST['customer-iteminclude'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid']);
                
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVPhysicalInvSheet($params);

                return $this->render('reportlist/item/universe/rep_items_uvphysicalinvsheet',array('data'=>$result,'params'=>$params));
            break; 

            case 'Schedule of Inventory (Average Cost)':
            try {
                $params = array('asof'=>$_POST['asof'],'unit'=>$_POST['item-unit'],'principalid'=>$_POST['principalid'],
                'stockprincipalid'=>$_POST['stockprincipalid'],'divisionid'=>$_POST['divisionid'],
                'stockdivisionid'=>$_POST['stockdivisionid'],'wh'=>$_POST['warehouse']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVSchedInvAveCost($params);   
                return $this->render('reportlist/item/universe/rep_items_uvschedinvcost',array('data'=>$result,'params'=>$params));
                
                
            } catch (\Exception $e) {
                echo $e;
            }
            break;

            case 'Schedule of Inventory (FIFO)':
                $params = array('asof'=>$_POST['enddate2'],'unit'=>$_POST['item-unit'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],'wh'=>$_POST['warehouse']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVSchedInvFIFO($params);
                return $this->render('reportlist/item/universe/rep_items_uvschedinvfifo',array('data'=>$result,'params'=>$params));
            break;

            case 'Physical Inventory Sheet':
                $params = array('class'=>$_POST['class'],'stockgrpid'=>$_POST['stockgrpid'],'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'category'=>$_POST['category'],'arrangeby'=>$_POST['customer-sortbarcodedesc'],'include'=>$_POST['customer-iteminclude'],'wh'=>$_POST['warehouse']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptPrice_List($params); //query result
                return $this->render('reportlist/item/rep_items_physicalinvsheet',array('data'=>$result,'params'=>$params));
                break; 
            case 'Schedule of Inventory':
                $params = array('asof'=>$_POST['enddate2'],'class'=>$_POST['class'],'stockgrpid'=>$_POST['stockgrpid'],'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'category'=>$_POST['category'],'arrangeby'=>$_POST['customer-sortbarcodedesc'],'include'=>$_POST['customer-iteminclude'],'wh'=>$_POST['warehouse']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptScheduleofInv($params); //query result
                return $this->render('reportlist/item/rep_items_scheduleofInv',array('data'=>$result,'params'=>$params));
                break;
                
            case 'Current Inventory Balance per Supplier':
                $params = array('client'=>$_POST['client'],'item'=>$_POST['item'],'stockgrpid'=>$_POST['stockgrpid'],'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'part'=>$_POST['part'],'itemtype'=>$_POST['itemtype'],'wh'=>$_POST['warehouse']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCurrentInventory_Balancepersupplier($params,$center); //query result
                return $this->render('reportlist/item/rep_items_currentinventorybalancepersupplier',array('data'=>$result,'params'=>$params));
                break;
            case 'Inventory Monthly':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'item'=>$_POST['item'],'stockgrpid'=>$_POST['stockgrpid'],'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'part'=>$_POST['part'],'wh'=>$_POST['warehouse']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptInventory_Monthly($params,$center); //query result
                return $this->render('reportlist/item/infinitea/rep_items_inventorymonthly',array('data'=>$result,'params'=>$params));
            break;

            case 'Customer Sales Per Collection':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'agent'=>$_POST['agent']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rpt_CustomerSalesPerCollection($params); //query result
                return $this->render('reportlist/customer/tenplus/rep_customersalespercollection',array('data'=>$result,'params'=>$params));                
            break;

            case 'Quantity on Hand (XANDA)':
                $params = array('asof'=>$_POST['enddate2'],'item'=>$_POST['item'],'stockgrpid'=>$_POST['stockgrpid'],'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'part'=>$_POST['part'],'itemtype'=>$_POST['itemtype'],'wh'=>$_POST['warehouse']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptQuantityonhand($params,$center); //query result
                return $this->render('reportlist/item/xanda/rep_items_quantityonhand',array('data'=>$result,'params'=>$params));
            break;

            case 'Inventory Movement Report':
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                        $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],'wh'=>$_POST['warehouse'],'class'=>$_POST['class'],'uvcategoryid'=>$_POST['uvcategoryid'],'stockuvcategoryid'=>$_POST['stockuvcategoryid']);
                        Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                        $result=Reports::rptUVInvMovementReport($params);   
                       
                        return $this->render('reportlist/item/universe/rep_items_uvinvmovementreport',array('data'=>$result,'params'=>$params));
                    break;

                    default:
                        $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'wh'=>$_POST['warehouse'],'group'=>$_POST['groupid'],'category'=>$_POST['category'],'part'=>$_POST['part'],'partid'=>$_POST['partid'],'stockgrpid'=>$_POST['stockgrpid'],'brand'=>$_POST['repbrand']);
                        $center = Yii::$app->session['loggeduser']['center'];
                        Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                        $result=Reports::rptInventorymovementeport($params,$center); //query result
                
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'SOUTHCENTRAL':
                                $rpt = "reportlist/item/xanda/rep_items_inventorymovementreport";
                            break;
                    
                            default:
                                $rpt = "reportlist/item/rep_items_inventorymovementreport";
                            break;
                        }
                        return $this->render($rpt,array('data'=>$result,'params'=>$params));
                    break;    
                }// end switch
            break; 

            case 'Sales Summary Per Principal/Division':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVSalesSummPrinDiv($params);   
                    
                return $this->render('reportlist/item/universe/rep_items_uvsalessummprindiv',array('data'=>$result,'params'=>$params));
            break;

            case 'Comparative Report - Sales Qty VS Qty On Hand':
                $params = array('asof'=>$_POST['enddate2'],'startdate'=>$_POST['startdate'],
                'enddate'=>$_POST['enddate'],'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],
                'stockdivisionid'=>$_POST['stockdivisionid'],
                'wh'=>$_POST['warehouse'],'include'=>$_POST['customer-salesinclude'],
                'unit'=>$_POST['item-unit'],'viewout'=>$_POST['customer-comparativeout']);

                $date1 = date_create($params['startdate']);
                $date2 = date_create($params['enddate']);
                $diff = date_diff($date1,$date2);
                
                $params['nomonths'] =  $diff->format("%R%a");
                $params['nomonths'] = floatval($params['nomonths']) / 30;

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVComparativeReportQTY($params);   
                    
                return $this->render('reportlist/item/universe/rep_items_uvcomparativereportqty',array('data'=>$result,'params'=>$params));
            break;

            case 'Comparative Report - Inventory per Location':
            try { 
                $params = array('asof'=>$_POST['enddate2'],'startdate'=>$_POST['startdate'],
                'enddate'=>$_POST['enddate'],'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],
                'stockdivisionid'=>$_POST['stockdivisionid'],
                'wh1'=>$_POST['location1'],'wh2'=>$_POST['location2'],
                'include'=>$_POST['customer-salesinclude'],
                'unit'=>$_POST['item-unit'],
                'viewout'=>$_POST['customer-comparativeout'],'viewout2'=>$_POST['customer-comparativeout2']);


                $date1 = date_create($params['startdate']);
                $date2 = date_create($params['enddate']);
                $diff = date_diff($date1,$date2);
                
                $params['nomonths'] =  $diff->format("%R%a");
                $params['nomonths'] = floatval($params['nomonths']) / 30;

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVComparativeReportperLocation($params);   
                    
                return $this->render('reportlist/item/universe/rep_items_uvcomparativereportperlocation',array('data'=>$result,'params'=>$params));
                
                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            case 'Top Performing Category':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'department'=>$_POST['uv_department'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'agent'=>$_POST['client-agent'],'agentname'=>$_POST['client-agentname'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'salesreporttype'=>$_POST['customer-salesreporttype'],
                'trnxtype' => $_POST['customer-universetrnxtype'],'salestype' => $_POST['customer-optsalestype'],
                'viewfield'=>$_POST['item-optionamtqty'],'pref'=>$_POST['pref']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVTopPerformingCategory($params);    

                return $this->render('reportlist/item/universe/rep_items_uvtopperformingcategory',array('data'=>$result,'params'=>$params));
            break;

            case 'Top Performing Classification':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'department'=>$_POST['uv_department'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'agent'=>$_POST['client-agent'],'agentname'=>$_POST['client-agentname'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'salesreporttype'=>$_POST['customer-salesreporttype'],
                'trnxtype' => $_POST['customer-universetrnxtype'],'salestype' => $_POST['customer-optsalestype'],
                'viewfield'=>$_POST['item-optionamtqty'],'pref'=>$_POST['pref']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVTopPerformingClassification($params);    
                return $this->render('reportlist/item/universe/rep_items_uvtopperformingclassification',array('data'=>$result,'params'=>$params));
            break;

            case 'Top Performing Division':
            try {
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'department'=>$_POST['uv_department'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'agent'=>$_POST['client-agent'],'agentname'=>$_POST['client-agentname'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'salesreporttype'=>$_POST['customer-salesreporttype'],
                'trnxtype' => $_POST['customer-universetrnxtype'],'salestype' => $_POST['customer-optsalestype'],
                'viewfield'=>$_POST['item-optionamtqty'],'pref'=>$_POST['pref']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVTopPerformingDivision($params);   
                return $this->render('reportlist/item/universe/rep_items_uvtopperformingdivision',array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            case 'Top Performing Principal':
            try {
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'department'=>$_POST['uv_department'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'agent'=>$_POST['client-agent'],'agentname'=>$_POST['client-agentname'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'salesreporttype'=>$_POST['customer-salesreporttype'],
                'trnxtype' => $_POST['customer-universetrnxtype'],'salestype' => $_POST['customer-optsalestype'],
                'viewfield'=>$_POST['item-optionamtqty'],'pref'=>$_POST['pref']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVTopPerformingPrincipal($params);    
                return $this->render('reportlist/item/universe/rep_items_uvtopperformingprincipal',array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            case 'Purchase Summary Per Supplier/Principal':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVPurchaseSummSuppPrin($params);    
                return $this->render('reportlist/item/universe/rep_items_uvpurchasesummsuppprin',array('data'=>$result,'params'=>$params));
            break;

            case 'Purchase Summary Per Principal/Division':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVPurchaseSummPrinDiv($params);    
                return $this->render('reportlist/item/universe/rep_items_uvpurchasesummprindiv',array('data'=>$result,'params'=>$params)); 
            break;

            case 'Purchase Summary Per Principal/Supplier':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptUVPurchaseSummPrinSupp($params);    
                return $this->render('reportlist/item/universe/rep_items_uvpurchasesummprinsupp',array('data'=>$result,'params'=>$params)); 
            break;

            case 'Item Purchase Report':
                try{
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],
                'brand'=>$_POST['repbrand'],'wh'=>$_POST['warehouse'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid']);
                
                $center = Yii::$app->session['loggeduser']['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptItempurchasereport($params,$center); //query result
                return $this->render('reportlist/item/panda/rep_items_itempurchase',array('data'=>$result,'params'=>$params));
                

                }catch(ErrorException $e){
                    echo $e;
                }
            break;


            case 'Asset Expense History':
            $acc = explode('~', $_POST['account']);
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'account'=>$acc[0],'prepared'=>$_POST['prepared'],'notedby'=>$_POST['notedby']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAssetExpense($params,$center); //query result
                return $this->render('reportlist/item/xanda/rep_items_assetexpensehistory',array('data'=>$result,'params'=>$params));
                break;

            case 'Asset Expense Summary':
            $acc = explode('~', $_POST['account']);
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'account'=>$acc[0],'prepared'=>$_POST['prepared'],'notedby'=>$_POST['notedby']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAssetExpensehistorysumm($params,$center); //query result
                return $this->render('reportlist/item/xanda/rep_items_assetexpensehistorysumm',array('data'=>$result,'params'=>$params));
                break;   

            case 'Asset Acquired Summary':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'assetcategory'=>$_POST['assetcategory'],'prepared'=>$_POST['prepared'],'notedby'=>$_POST['notedby']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAssetExpensesumm($params,$center); //query result
                return $this->render('reportlist/item/xanda/rep_items_assetaquiredsumm',array('data'=>$result,'params'=>$params));
                break;     

            case 'Asset Renewal Report':
                $params = array('asof'=>$_POST['enddate2'],'assetcategory'=>$_POST['assetcategory'],'prepared'=>$_POST['prepared'],'notedby'=>$_POST['notedby']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAssetrenewal($params,$center); //query result
                return $this->render('reportlist/item/xanda/rep_items_assetrenewal',array('data'=>$result,'params'=>$params));
            break;               

            //CUSTOMER
            case 'Customer List':
                $params = array('area'=>$_POST['area'],'region'=>$_POST['region'],'province'=>$_POST['province'],'center'=>$_POST['center'],'pricegroup'=>$_POST['pricegroup']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCustomer_List($params,$center); //query result
                return $this->render('reportlist/customer/rep_c_customerlist',array('data'=>$result,'params'=>$params));
                break;

            case 'Customer Charges':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'item'=>$_POST['item'],'paidunpaid'=>$_POST['customer-paidunpaid']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->session['reportparameters'] = $params;
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=  Reports::rptcustomer_customercharges($params,$center); //query result
                return $this->render('reportlist/customer/infinitea/rep_c_customercharges',array('data'=>$result,'params'=>$params));
            break;  

            //WTODO: [JLY][2019.08.17][KINGG CONCERNS][ADD GROUP FILTER START]
            case 'Current Customer Receivables Aging(Summary)':
                $params = array('client'=>$_POST['client'],'center'=>$_POST['center']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCOutstandingCustomerreceivables($params,$center); //query result
                $view='reportlist/customer/rep_c_outstanding_ar';
                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;

            case 'Current Customer Receivables Aging(Detailed)':
                $params = array('client'=>$_POST['client'],'center'=>$_POST['center']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCOutstandingCustomerreceivableaging($params,$center); //query result
                return $this->render('reportlist/customer/kingg/rep_c_ar_aging_d',array('data'=>$result,'params'=>$params));
            break;
            
            
            case 'Current Customer Receivables':
            try {
                //WTODO: [KIM][2019.12.09][add poststatus,reporttype]
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus'],
                'reporttype'=>$_POST['reporttype']);
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCOutstandingCustomerreceivables($params,$center); //query result
                
                //WTODO: [KIM][2019.12.09][add if else statement for detailed and summarized]
                if($params['reporttype']=='detailed'){
                    $red='reportlist/customer/rep_c_outstanding_ar';
                } else {
                    $red='reportlist/customer/rep_c_outstanding_ar_s';
                } //end

                return $this->render($red,array('data'=>$result,'params'=>$params));
                
                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;
            
            case 'Current Customer Receivables Aging':
            try{
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'center'=>$_POST['center'],'reporttype'=>$_POST['reporttype']);
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCOutstandingCustomerreceivableaging($params,$center); //query result
                
                if ($params['reporttype']=='detailed'){
                    $red='reportlist/customer/rep_c_ar_aging_d';
                }else{
                    $red='reportlist/customer/rep_c_ar_aging_s';
                }//end if            

                return $this->render($red,array('data'=>$result,'params'=>$params));
            } catch (\Exception $e) {
                echo $e;
            }
            break;
            
            case 'Analyze Customer Sales (Monthly)':
            try {
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'year'=>$_POST['year'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAnalyze_Customersales($params,$center); //query result
                return $this->render('reportlist/customer/rep_c_analyzecustomersalesmonthly',array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            case 'Customer Sales Report':
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'startdate'=>$_POST['startdate'],
                'enddate'=>$_POST['enddate'],'center'=>$_POST['center'],
                'poststatus'=>$_POST['poststatus'],'salesreporttype'=>$_POST['customer-salesreporttype'],
                'sortby'=>$_POST['customer-sortby']);
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSales_Reports($params,$center); //query result
                $reporttype=$params['salesreporttype'];

                if ($reporttype=="report") {
                    $view= 'reportlist/customer/rep_c_salesreport';
                }
                elseif($reporttype=="lessreturn") {
                    $view= 'reportlist/customer/rep_c_salesless';
                }
                else {
                    $view= 'reportlist/customer/rep_c_salesreturn';
                }

                return $this->render($view,array('data'=>$result,'params'=>$params));
            break; 

            case 'Pending Sales Orders':
                //WTODO: [KIM][2019.09.06][add stockgrpid]
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'brand'=>$_POST['repbrand'],
                'transtype'=>$_POST['transtype'],'center'=>$_POST['center']);

                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptpending_Salesorder($params,$center); //query result
                return $this->render('reportlist/customer/rep_c_pendingso',array('data'=>$result,'params'=>$params));         
            break;

            case 'Pending Sales Orders - VOID':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'client'=>$_POST['client'],'item'=>$_POST['item'],'group'=>$_POST['groupid'],'brand'=>$_POST['repbrand'],'class'=>$_POST['class'],'transtype'=>$_POST['transtype'],'center'=>$_POST['center']);
                $center = $params['center'];
                 Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptpending_Salesordervoidyulick($params,$center); //query result
                return $this->render('reportlist/customer/yulick/rep_c_pendingsovoid',array('data'=>$result,'params'=>$params));
            break;
                    
            case 'Customer Performance Report':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'center'=>$_POST['center'],'prepared'=>$_POST['prepared'],'approved'=>$_POST['approved']);
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptcustomer_performancereport($params,$center); //query result
                $result1=Reports::rptcustomer_performancereporttotal($params,$center); //query result
                return $this->render('reportlist/customer/rep_c_customerperformance',array('data'=>$result,'data1'=>$result1,'params'=>$params));
            break;               

            case 'Sales Per Customer Per Item':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'option'=>$_POST['item-optionamtqty']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSalespercustomerperitem($params,$center); //query result
                return $this->render('reportlist/customer/rep_c_salespercustomerperitem',array('data'=>$result,'params'=>$params));
            break; 

            case 'Monthly Sales Report (Graph)':
                $params = array('year'=>$_POST['year'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->session['reportparameters'] = $params;
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptChartqry($params,$center); //query result
                return $this->render('reportlist/customer/rep_c_samplechart',array('data'=>$result,'params'=>$params));
            break;

            case 'Sales Comparison (Graph)':
                $params = array('year'=>$_POST['year'],'center'=>$_POST['center']);
                $center = $params['center'];
                Yii::$app->session['reportparameters'] = $params;
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSalescomparisonChartqry($params,$center); //query result
                return $this->render('reportlist/customer/rep_c_salescomparison',array('data'=>$result,'params'=>$params));
            break;   

            case 'Customer Sales Report(RTT)':           
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'client'=>$_POST['client'],
                'agent'=>$_POST['agent'],'sortby'=>$_POST['customer-sortby'],'salestype'=>$_POST['customer-optsalestype'],'vattype'=>$_POST['customer-optvat']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rpt_SalesReportrttrading($params); //query result
                //var_dump($result);
                //return $result;
                return $this->render('reportlist/customer/rep_c_rttrading_salesreport',array('data'=>$result,'params'=>$params));
            break;

            case 'Sales Per Class':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'client'=>$_POST['client'],
                'agent'=>$_POST['agent'],'class'=>$_POST['class'],'salestype'=>$_POST['customer-optsalestype'],
                'vat'=>$_POST['customer-optvat'],'arrangeby'=>$_POST['customer-sortbarcodedesc'],'reporttype'=>$_POST['reporttype']);
                Yii::$app->session['reportparameters'] = $params;

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=  Reports::rptC_Salesperclass($params); //query result


                if ($params['reporttype']=='detailed'){
                    $red='reportlist/customer/rep_c_salesperclassdetail';
                } else {
                    $red='reportlist/customer/rep_c_salesperclasssumm';
                }

                return $this->render($red,array('data'=>$result,'params'=>$params));
            break;
                
            case 'Sales Per Customer':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'client'=>$_POST['client'],
                'agent'=>$_POST['agent'],'class'=>$_POST['class'],'salestype'=>$_POST['customer-optsalestype'],
                'vat'=>$_POST['customer-optvat'],'arrangeby'=>$_POST['customer-sortbarcodedesc'],
                'reporttype'=>$_POST['reporttype'],'area'=>$_POST['area']);
                
                Yii::$app->session['reportparameters'] = $params;
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=  Reports::rptC_Salespercustomer($params); //query result

                if ($params['reporttype']=='detailed'){
                    $red='reportlist/customer/rep_c_salespercustomerdetail';
                } else {
                    $red='reportlist/customer/rep_c_salespercustomersumm';
                }

                return $this->render($red,array('data'=>$result,'params'=>$params));
            break;
//JEAR 091916
            case 'Comparative Sales Per Customer':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'rttstartdate'=>$_POST['rttstartdate'],
                'rttenddate'=>$_POST['rttenddate'],'rttstartdate3'=>$_POST['rttstartdate3'],'rttenddate3'=>$_POST['rttenddate3'],
                'vattype'=>$_POST['customer-optvat'],'option'=>$_POST['item-optionamtqtytons'],'category'=>$_POST['category2'],
                'agent'=>$_POST['agent'],'class'=>$_POST['class'],'area'=>$_POST['area']);
                $center = Yii::$app->session['loggeduser']['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptcomparativesalespercustomer($params,$center); //query result
                return $this->render('reportlist/customer/rtt/rep_c_comparativesalespercustomer',array('data'=>$result,'params'=>$params));
            break; 

            // PANDATOOLS UPDATE
            
            case 'Sales Report File':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptcustomer_salesreportfile($params,$center); //query result
              
                return $this->render('reportlist/customer/panda/rep_c_salesreportfile',array('data'=>$result,'params'=>$params));
            break;


            case 'Sales Report By Brand':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'brand'=>$_POST['repbrand']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptsales_reportbybrand($params,$center); //query result
                return $this->render('reportlist/customer/panda/rep_c_salesreportbybrand',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.11.28][add case for job order listing]
            case 'Job Order Listing':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'reporttype'=>$_POST['reporttype']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                if($params['reporttype']=='detailed'){
                    $result=Reports::rptC_MLCPJOlisting($params); //query result
                    $jolist='reportlist/customer/mlcp/rep_c_mlcpjolisting';
                } else {
                    $result=Reports::rptC_MLCPJOlistingSum($params);
                    $jolist='reportlist/customer/mlcp/rep_c_mlcpjolistingsummary';
                }//end if

                return $this->render($jolist,array('data'=>$result,'params'=>$params));            
            break;

            //WTODO: [KIM][2019.12.09][add case for payable to customer report]
            case 'Payable to Customer Report':
                $params = array('client'=>$_POST['client'],'center'=>$_POST['center']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCPayCustRep($params,$center); //query result    
                return $this->render('reportlist/customer/mlcp/rep_c_paycustomerrep_ar',array('data'=>$result,'params'=>$params));
            break;

            case 'Top Performing Customer':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'agent'=>$_POST['client-agent'],'agentname'=>$_POST['client-agentname'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'brand'=>$_POST['repbrand'],
                'department'=>$_POST['uv_department'],
                'salesreporttype'=>$_POST['customer-salesreporttype'],
                'trnxtype' => $_POST['customer-universetrnxtype'],'salestype' => $_POST['customer-optsalestype'],
                'viewfield'=>$_POST['item-optionamtqty'],'pref'=>$_POST['pref']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptC_UVtopPerformingCustomer($params); //query result
                return $this->render('reportlist/customer/rep_c_uvtopperformingcustomer',array('data'=>$result,'params'=>$params));
            break;

            case 'Top Performing Item':
                try {
                    $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                    'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                    'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                    'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                    'model'=>$_POST['modelname'],'modelid'=>$_POST['modelid'],
                    'brand'=>$_POST['repbrand'],
                    'category'=>$_POST['part'],'partid'=>$_POST['partid'],
                    'department'=>$_POST['uv_department'],
                    //CHANGE WITH THE ONE BELOW AFTER PATCHING WITH OTHER REPORTS
                    'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                    'agent'=>$_POST['client-agent'],'agentname'=>$_POST['client-agentname'],
                    'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                    //'agent'=>$_POST['agent'],'agentname'=>$_POST['agentname'],
                    /* 'customer'=>$_POST['clientname'],'customer'=>$_POST['client'], */
                    'typeofreport'=>$_POST['customer-salesreporttype'],
                    'trnxtype' => $_POST['customer-universetrnxtype'],'salestype' => $_POST['customer-optsalestype'],
                    'viewfield'=>$_POST['item-optionamtqty'],'sales_prefix'=>$_POST['pref'], 'unit'=>$_POST['item-unit']);
                    
                    Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                    
                    $result=Reports::rptC_UVtopPerformingItem($params); //query result
                    
                    
                    return $this->render('reportlist/item/rep_item_uvtopperformingitem',array('data'=>$result,'params'=>$params));
                    
                } catch (\Exception $e) {
                    echo $e;
                }
            break;

            case 'Distribution Report (FDA)':
                try {
                    $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                    'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'], 
                    'unit'=>$_POST['item-unit'], 'wh'=>$_POST['warehouse']);
                    
                    Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                    
                    $result=Reports::rpt_DistributionDFAReport($params); //query result
                    
                    $view = 'reportlist/item/universe/rep_item_fda_distribution';
                    return $this->render($view,array('data'=>$result,'params'=>$params));
                } catch (\Exception $e) {
                    echo $e;
                }
            break;

            case 'Top Performing Sales Agent':
            try {
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'department'=>$_POST['uv_department'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'agent'=>$_POST['client-agent'],'agentname'=>$_POST['client-agentname'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'salesreporttype'=>$_POST['customer-salesreporttype'],
                'trnxtype' => $_POST['customer-universetrnxtype'],'salestype' => $_POST['customer-optsalestype'],
                'viewfield'=>$_POST['item-optionamtqty'],'pref'=>$_POST['pref'], 'unit'=>$_POST['item-unit'],
                'view-amt-field' => $_POST['view-amt-field'],
                'pricegroup'=>$_POST['pricegroup'],);
                
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSales_UVtopPerformingAgent($params); //query result

                return $this->render('reportlist/agent/rep_agent_uvtopperformingagent',array('data'=>$result,'params'=>$params));
            } catch (ErrorException $e) {
                echo $e;
            }
            break;

            //SUPPLIER
            case 'Supplier List':
                $params = array('area'=>$_POST['area'],
                'region'=>$_POST['region'],'province'=>$_POST['province'],
                'center'=>$_POST['center']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptSupplier_List($params,$center); //query result
                return $this->render('reportlist/supplier/rep_supplier_supplierlist',array('data'=>$result,'params'=>$params));
            break;    

            case 'Current Supplier Payables':
                try{

                    $params = array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                    'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus'],'reporttype'=>$_POST['reporttype']);
                    $center = $params['center'];

                    Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                    $result=Reports::rptCOutstandingSupplierpayables($params,$center); //query result

                    if($params['reporttype']=='detailed'){
                        $red='reportlist/supplier/rep_s_outstanding_ap';
                    }else{
                        $red='reportlist/supplier/rep_s_outstanding_ap_s';
                    }//end if
                    
                    return $this->render($red,array('data'=>$result,'params'=>$params));
                } catch (ErrorException $e) {
                    echo $e;
                }
            break;
            
            case 'Current Supplier Payables Aging':
            try {
                $params = array(
                'suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus'],'reporttype'=>$_POST['reporttype']
                );
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCOutstandingSupplierpayablesaging($params,$center); //query result
                
                if ($params['reporttype']=='detailed'){
                    $red='reportlist/supplier/rep_s_ap_aging_d';
                }else{
                    $red='reportlist/supplier/rep_s_ap_aging_s';
                }//end if

                return $this->render($red,array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break; 
            case 'Analyzed Supplier Purchases (Monthly)':
                $params = array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus'],'year'=>$_POST['year']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                
                $result=Reports::rptAnalyzesupplierpurchasesmonthly($params,$center); //query result
                return $this->render('reportlist/supplier/rep_s_analyzesupplierpurchasesmonthly',array('data'=>$result,'params'=>$params));
            break;

            case 'Supplier Purchase Report':
                $ptype = '';
                
                $params = array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],
                'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus'],
                'purchasereporttype'=>$_POST['customer-purchasereporttype'],'sortby'=>$_POST['customer-sortby'],
                'purchasetype'=>$ptype,'vattype'=>$_POST['customer-optvat'],
                'reporttype'=>$_POST['reporttype']);
                $center = $params['center'];


                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptPurchase_Reports($params,$center); //query result

                $reporttype=$params['purchasereporttype'];
                
                if ($reporttype=="report") {
                    $view= 'reportlist/supplier/rep_supplier_purchasereport';
                }
                elseif($reporttype=="lessreturn") {
                    $view= 'reportlist/supplier/rep_supplier_purchaseless';
                }
                else {
                    $view= 'reportlist/supplier/rep_supplier_purchasereturn';
                }
                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;  

            case 'Pending Purchase Orders':
                try {
                //WTODO: [KIM][2019.09.06][add ]
                $params = array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'category'=>$_POST['part'],'categoryid'=>$_POST['partid'],
                'generic'=>$_POST['modelname'],'genericid'=>$_POST['modelid'],
                'brand'=>$_POST['repbrand'],
                'class'=>$_POST['class'],'classid'=>$_POST['classid'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'center'=>$_POST['center']);
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptPending_Purchaseorder($params,$center); //query result
                return $this->render('reportlist/supplier/rep_s_pendingpo',array('data'=>$result,'params'=>$params));

                    
                } catch (ErrorException $e) {
                    echo $e;
                }
            break;

            case 'Supplier Performance Report':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'center'=>$_POST['center'],'prepared'=>$_POST['prepared'],'approved'=>$_POST['approved'],'center'=>$_POST['center']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptsupplier_performancereport($params,$center);    //query result
                $result1=Reports::rptsupplier_performancereporttotal($params,$center);
                return $this->render('reportlist/supplier/rep_supplier_supplierperformance',array('data'=>$result,'data1'=>$result1,'params'=>$params));
            break; 

            case 'Receiving Consignment Report':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus'],'sortby'=>$_POST['customer-sortby']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptreceivingconsignment2($params,$center);    //query result
                return $this->render('reportlist/supplier/rep_supplier_receivingconsignment',array('data'=>$result,'params'=>$params));
            break;
            
            case 'Purchase Per Supplier':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'client'=>$_POST['client'],
                                'class'=>$_POST['class'],'vat'=>$_POST['customer-optvat'],'arrangeby'=>$_POST['customer-sortbarcodedesc'],
                                'reporttype'=>$_POST['reporttype']);
                Yii::$app->session['reportparameters'] = $params;
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=  Reports::rptC_Purchasepersupplier($params); //query result
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'YULICK':
                    if ($params['reporttype']=='detailed'){
                    $red='reportlist/supplier/yulick/rep_s_purchasepersupplierdetail';
                    } else {
                        $red='reportlist/supplier/yulick/rep_s_purchasepersuppliersumm';
                    }
                        break;
                    default :
                    if ($params['reporttype']=='detailed'){
                    $red='reportlist/supplier/rep_s_purchasepersupplierdetail';
                    } else {
                        $red='reportlist/supplier/rep_s_purchasepersuppliersumm';
                    }
                        break;
                }    
                return $this->render($red,array('data'=>$result,'params'=>$params));
            break;  

            //JEAR 091916    
            case 'Purchase Summary':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'vattype'=>$_POST['customer-optvat']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptPurchaseSumm($params,$center);    //query result
                return $this->render('reportlist/supplier/rtt/rep_supplier_purchasesumm',array('data'=>$result,'params'=>$params));
            break;

            // PANDATOOLS UPDATE
            
            case 'Back Order Report':
                $params = array('client'=>$_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptBackrder_Report($params,$center); //query result
                return $this->render('reportlist/supplier/panda/rep_supplier_backorderreport',array('data'=>$result,'params'=>$params));
            break;


            case 'Purchase Report By Brand':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'brand'=>$_POST['repbrand']);
                $center = Yii::$app->session['loggeduser']['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptpurchase_reportbybrand($params,$center); //query result
                return $this->render('reportlist/supplier/panda/rep_supplier_purchasereportbybrand',array('data'=>$result,'params'=>$params));
            break;

            //AGENT
            case 'Sales Agent List':
                $params = array('area'=>$_POST['area'],'region'=>$_POST['region'],'province'=>$_POST['province'],'center'=>$_POST['center']);
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSales_Agentlist($params,$center); //query result
                return $this->render('reportlist/agent/rep_agent_agentlist',array('data'=>$result,'params'=>$params));
                break;
            
            case 'Analyzed Agent Sales (Monthly)':
                $params = array('year'=>$_POST['year'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                //$center = $params['center'];
                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAnalyze_agentsales($params,$center); //query result
                return $this->render('reportlist/agent/rep_agent_analyzeagentsalesmonthly',array('data'=>$result,'params'=>$params));
                break;
            
            case 'Sales per Salesman (XANDA)':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'agent'=>$_POST['agent']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=  Reports::rptSalesreportpersalesman($params); //query result
                return $this->render('reportlist/agent/xanda/rep_agent_salesreportpersalesman',array('data'=>$result,'params'=>$params));
            break;   

            case 'Discounted Price Report (XANDA)':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'agent'=>$_POST['agent']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=  Reports::rptDiscountedprice($params); //query result
                return $this->render('reportlist/agent/xanda/rep_agent_discountedpricereport',array('data'=>$result,'params'=>$params));
            break;

            case 'Sales Report per Staff (D SALON)':
                $params = array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'client'=>$_POST['client'],'agent'=>$_POST['agent'],'group'=>$_POST['groupid']);
                Yii::$app->session['reportparameters'] = $params;
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=  Reports::rptSalesreportperstaff($params); //query result
                return $this->render('reportlist/agent/salon/rep_agent_salesreportperstaff',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [JLY][FHI][11.26.2019][PO LIST]
            case 'PO Listing':
                $params = array('client'=> $_POST['client'],'start'=> $_POST['startdate'],'end'=> $_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptPOlisting($params);
                return $this->render('reportlist/purchase/FHI/rep_po_listing',array('data'=>$result,'params'=>$params));
            break;
            //WTODO: [JLY][FHI][11.26.2019][unserved po]
            case 'Unserved PO':
                $params = array('client'=> $_POST['client'],'start'=> $_POST['startdate'],'end'=> $_POST['enddate'],'item'=> $_POST['item']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptUnservedPO($params);
                return $this->render('reportlist/purchase/FHI/rep_po_unserved',array('data'=>$result,'params'=>$params));
            break;
            //WTODO: [JLY][FHI][11.28.2019][AgingRepPerAgent]
            case 'Aging Report Per Salesman':
                $params = array('agent'=> $_POST['agent'],'asof'=> $_POST['asof']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptAgingRepPerAgent($params);            
                return $this->render('reportlist/agent/FHI/rep_agingreportpersalesman',array('data'=>$result,'params'=>$params));
            break;
            //WTODO: [JLY][FHI][12.6.2019][SalesReportPerAgent]
            case 'Sales Report Per Agent':
                $params = array('agent'=> $_POST['agent'],'start'=> $_POST['startdate'],'end'=> $_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptSalesReportPerAgent($params);
                return $this->render('reportlist/agent/FHI/rep_salesreportperagent',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.09.17][PRODUCTION]
            //PRODUCTION
            //WTODO: [KIM][2019.09.17][product listing controller]
            case 'Product Listing':
                $params = array('client'=> $_POST['client'],'prodtypeid'=> $_POST['prodtypeid'],'stockprodtypeid'=> $_POST['stockprodtypeid']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptProductlisting($params);
                return $this->render('reportlist/production/rep_production_prodlisting',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.09.17][rate listing controller]
            case 'Rate Listing':
                $params = array('client'=> $_POST['client'],'prodtypeid'=> $_POST['prodtypeid'],'stockprodtypeid'=> $_POST['stockprodtypeid']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptRatelisting($params);
                return $this->render('reportlist/production/rep_production_ratelisting',array('data'=>$result,'params'=>$params));
            break;

            //WTODO: [KIM][2019.09.17][product listing per material controller]
            case 'Product Listing per Material':
                $params = array('prodtypeid'=> $_POST['prodtypeid'],'stockprodtypeid'=> $_POST['stockprodtypeid'],'materialid'=> $_POST['materialid'],'stockmaterialid'=> $_POST['stockmaterialid']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptProdlistperMaterial($params);
                return $this->render('reportlist/production/rep_production_prodlistpermaterial',array('data'=>$result,'params'=>$params));
            break;
            
            //OTHERS
            case 'Statement of Account':
            try {
                $params = array('asof'=>$_POST['enddate2'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'certified'=>$_POST['certified'],'attention'=> $_POST['attention'],
                'center'=>$_POST['center'],
                'soacustfilter'=>$_POST['soacustfilter'],'vatview'=>$_POST['item-vatprint']);
                
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptStatementOfAccounts($params,$center); //query result
                $rtt='reportlist/other/rtt/rep_other_statementofaccount';

                return $this->render($rtt,array('data'=>$result,'params'=>$params));

                
            } catch (ErrorException $e) {
                echo $e;
            }
            break;
                
            case 'Expenses Report':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                                'reporttype'=>$_POST['reporttype'],'center'=>$_POST['center'],
                                'poststatus'=>$_POST['poststatus']);
                
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptA_Expensesreports($params,$center); //query result
                $isdetailed = $params['reporttype'];
                
                if($isdetailed=="detailed") {
                    $view= 'reportlist/other/rep_others_expensesreportdetailed';
                }else {
                    $view= 'reportlist/other/rep_others_expensesreportsummary';
                }//end if

                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;           

            //ACCOUNTING
            case 'Cash Disbursement Book':
                $params = array('client'=>$_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'reporttype'=>$_POST['reporttype'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptA_CashDisbursement($params,$center); //query result
                $isdetailed = $params['reporttype'];
                if ($isdetailed=="detailed") {
                    $view= 'reportlist/accounting/rep_ab_cashdisbursement';
                }else {
                    $view= 'reportlist/accounting/rep_ab_cashdisbursement_sum';
                }
                return $this->render($view,array('data'=>$result,'params'=>$params));
                break;      
            case 'Cash Receipt Book':
                $params = array('agent'=>$_POST['agent'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'reporttype'=>$_POST['reporttype'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptA_CashReceipt($params,$center); //query result
                $isdetailed = $params['reporttype'];
                
                if ($isdetailed=="detailed") {
                    $view= 'reportlist/accounting/rep_ab_cashreceipt';
                }else {
                    $view= 'reportlist/accounting/rep_ab_cashreceipt_sum';
                }
                
                return $this->render($view,array('data'=>$result,'params'=>$params));
                break;          
            case 'Journal Voucher':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'reporttype'=>$_POST['reporttype'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptA_JournalVoucher($params,$center); //query result
                $isdetailed = $params['reporttype'];
                if ($isdetailed=="detailed") {
                    $view= 'reportlist/accounting/rep_ab_journalvoucher';
                }else {
                    $view= 'reportlist/accounting/rep_ab_journalvoucher_sum';
                }
                return $this->render($view,array('data'=>$result,'params'=>$params));
                break;       
            case 'Purchase Journal':
                $params = array('client'=>$_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'reporttype'=>$_POST['reporttype'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptA_PurchaseJournal($params,$center); //query result
                $isdetailed = $params['reporttype'];
                if ($isdetailed=="detailed") {
                    $view= 'reportlist/accounting/rep_ab_purchasejournal';
                }else {
                    $view= 'reportlist/accounting/rep_ab_purchasejournalsum';
                }
                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;          

            case 'Sales Journal':
                try {
                    $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                    'reporttype'=>$_POST['reporttype'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                    
                    $center = $params['center'];
                    Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                    $result=Reports::rptA_SalesJournal($params,$center); //query result
                    $isdetailed = $params['reporttype'];
                    
                    if ($isdetailed=="detailed") {
                        $view= 'reportlist/accounting/rep_ab_salesjournal';
                    }else {
                        $view= 'reportlist/accounting/rep_ab_salesjournal_sum';
                    } //end if

                    return $this->render($view,array('data'=>$result,'params'=>$params));

                    
                } catch (ErrorException $e) {
                    echo $e;
                }
            break;   

            case 'Chart of Accounts':
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rpt_COA(); //query result
                return $this->render('reportlist/accounting/rep_ab_chartofaccounts',array('data'=>$result));
            break;    
            //CHECK MONITORING

            case 'Bounced Checks':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCH_Bounced($params,$center); //query result
                return $this->render('reportlist/checkmonitoring/rep_cm_bouncedchecks',array('data'=>$result,'params'=>$params));
            break;

            case 'Issued Checks':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'reporttransaction'=>$_POST['customer-reporttransaction'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCH_Issued($params,$center); //query result
                return $this->render('reportlist/checkmonitoring/rep_cm_issuedchecks',array('data'=>$result,'params'=>$params));
            break;  

            case 'Received Checks':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'reporttransaction'=>$_POST['customer-reporttransaction'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCH_Received($params,$center); //query result
                return $this->render('reportlist/checkmonitoring/rep_cm_receivedchecks',array('data'=>$result,'params'=>$params));
            break;  

            case 'Undeposited Checks':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCH_Undeposited($params,$center); //query result
                return $this->render('reportlist/checkmonitoring/rep_cm_undepositedchecks',array('data'=>$result,'params'=>$params));
            break;      
            //FINANCIAL
            case 'Balance Sheet':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptFS_BalanceSheet($params,$center); //query result
                return $this->render('reportlist/financial/rep_fs_balancesheet',array('data'=>$result,'params'=>$params));
            break;

            case 'Income Statement':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $report = 'reportlist/financial/rep_fs_incomestatement';  

                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptFS_IncomeStatement($params,$center); //query result
                return $this->render($report,array('data'=>$result,'params'=>$params));
            break;

            case 'Subsidiary Ledger':
                if($_POST['account'] == ""){
                    $accname = "NONE";
                }else{
                    $accname = Ladetail::getacnoname('\\'.$_POST['account']);
                }///end if

                $params = array('accname'=>$accname,'paramsacct'=>$_POST['account'],'account'=>$_POST['account'],
                'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptFS_SubsidiaryLedger($params,$center); //query result
                return $this->render('reportlist/financial/rep_fs_subsidiaryledger',array('data'=>$result,'params'=>$params));
            break;

            case 'Trial Balance':
                $params = array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'center'=>$_POST['center'],'poststatus'=>$_POST['poststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptFS_TrialBalance($params,$center); //query result
                return $this->render('reportlist/financial/rep_fs_trialbalance',array('data'=>$result,'params'=>$params));
            break;

            case 'Monthly Income Statement':
                $params = array('year'=>$_POST['year'],'center'=>$_POST['center'],'viewby'=>'MONTHLY');
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);            
                $result=Reports::rptFS_MonthlyIncomeStatement($params); //query result
                return $this->render('reportlist/financial/rep_fs_incomestatementmonthly',array('data'=>$result,'params'=>$params));
            break;   

            case 'Comparative Income Statement':
                $params = array('year'=>$_POST['year'],'center'=>$_POST['center'],'viewby'=>'3YEARS');
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptFS_ComparativeIncomeStatement($params); //query result
                return $this->render('reportlist/financial/rep_fs_incomestatementcomparative',array('data'=>$result,'params'=>$params));
            break; 

            case 'Comparative Balance Sheet':
                $params = array('year'=>$_POST['year'],'center'=>$_POST['center'],'viewby'=>'3YEARS');
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptFS_ComparativeBalanceSheet($params); //query result
                return $this->render('reportlist/financial/rep_fs_balancesheetcomparative',array('data'=>$result,'params'=>$params));                                       
            break;         

            case 'Sales Summary (Universe)':
                $params=array('start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'trnxtype'=>$_POST['customer-rtttrnxtype'],
                'vattype'=>$_POST['customer-optvat'],'rttpref'=>$_POST['rttinvpref'],'format'=>$_POST['customer-rttsalessummaryformat']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptRTT_SalesSummary($params); 

                switch ($params['format']) {
                    case 'salesret':
                        $replayout = 'reportlist/item/rtt/sales_summaryret';
                        break;
                    
                    default:
                        $replayout = 'reportlist/item/rtt/sales_summary';
                        break;
                }//end switch
                return $this->render($replayout,array('data'=>$result,'params'=>$params));
            break;

            case 'Sales Summary per Vat Type':
            try{
                $params = ['start'=>$_POST['startdate'], 'end'=>$_POST['enddate'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'vattype' => $_POST['customer-vattype'],
                'salestype' => $_POST['customer-optsalestype'], 'trnxtype'=> $_POST['customer-universetrnxtype'],
                'reporttype'=>$_POST['reporttype2'], 'pref'=>$_POST['pref'],
                'sortby' => $_POST['report-sortsummvat'],
                'showtinonly' => $_POST['customer-customershowtin'],
                'pricegroup'=>$_POST['pricegroup'],
                ];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::UNIVERSE_SalesPerVattype($params);

                switch ($params['reporttype']) {
                    case 'summarized':
                        $replayout = 'reportlist/customer/universe/sales_summary_vat_summarized';
                    break;
                    
                    case 'detailed':
                        $replayout = 'reportlist/customer/universe/sales_summary_vat_detailed';
                    break;

                    case 'summarized2':
                         $replayout = 'reportlist/customer/universe/sales_summary_vat_summarized2';
                    break;
                }//end switch

                return $this->render($replayout,array('data'=>$result,'params'=>$params));
                } catch (ErrorException $e) {
        echo $e;
      }
            break;
            
            //TRANSACTION LIST
            case 'Receiving Report':
                $params=array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                    'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'sort'=>$_POST['report-sortascdesc'],
                    'reporttype'=>$_POST['reporttype']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptPurchase_ReceivingReport($params); //query result

                if($params['reporttype']=='detailed'){
                   $view='reportlist/purchase/rep_purchase_receivingreport';
                }else{
                   $view='reportlist/purchase/rep_purchase_receivingreportsumm';
                }

                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;  


            case 'Purchase Return Report':
                //WTODO: [KIM][2019.09.06][add filter for supplier]
                $params=array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                    'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptPurchase_ReturnReport($params); //query result
                return $this->render('reportlist/purchase/rep_purchase_returnreport',array('data'=>$result,'params'=>$params));
            break;            

            case 'Purchase Order Report':
            //WTODO: [KIM][2019.09.06][add filter for supplier]
                $params=array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                    'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptPurchase_OrderReport($params); //query result
                return $this->render('reportlist/purchase/rep_purchase_orderreport',array('data'=>$result,'params'=>$params));

            break;                 

            case 'Purchase Requisition Report':
            //WTODO: [KIM][2019.09.06][add filter for supplier]
                $params=array('suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                $result=Reports::rptPurchase_RequisitionReport($params); //query result

                return $this->render('reportlist/purchase/rep_purchase_requisitionreport',array('data'=>$result,'params'=>$params));
            break;  

            case 'Sales Order Report':
                $params=array('bref'=>$_POST['bref'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSales_OrderReport($params); //query result
                switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'YULICK':
                    return $this->render('reportlist/sales/yulick/rep_sales_orderreport',array('data'=>$result,'params'=>$params));
                        break;
                    default:
                    return $this->render('reportlist/sales/rep_sales_orderreport',array('data'=>$result,'params'=>$params));
                        break;
                }//end switch case
            break;  
            
            case 'Sales Journal Report':
                $params=array('bref'=>$_POST['bref'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'username'=>$_POST['user'],
                'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'poststatus'=>$_POST['poststatus'],'reporttype'=>$_POST['reporttype']);
                
                $isdetailed = $params['reporttype'];

                if ($isdetailed=="detailed") {
                    $view= 'reportlist/sales/rep_sales_journalreport';
                }else {
                    $view= 'reportlist/sales/rep_sales_journalreportsumm';
                }//end if
                
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSales_JournalReport($params); //query result
                return $this->render($view,array('data'=>$result,'params'=>$params));  
            break;  

            case 'Sales Return Report':
                $params=array('bref'=>$_POST['bref'],
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'username'=>$_POST['user'],
                            'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'poststatus'=>$_POST['poststatus2'],
                            'reporttype'=>$_POST['reporttype'],'sortby'=>$_POST['report-sortascdesc']);
                $isdetailed = $params['reporttype'];
                   
                if($isdetailed=="detailed") {
                    $view = 'reportlist/sales/rep_sales_returnreport';
                }else{
                    $view = 'reportlist/sales/rep_sales_returnreportsumm';
                }//end if

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptSales_ReturnReport($params);
                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;  
            
            case 'Inventory Setup Report':
                $params=array('warehouse'=>$_POST['warehouse'],'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptInventory_SetupReport($params); //query result
                
                return $this->render('reportlist/inventory/rep_inventory_setupreport',array('data'=>$result,'params'=>$params));
            break;   
            case 'Physical Count Report':
                $params=array('warehouse'=>$_POST['warehouse'],'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptInventory_PhysicalCountReport($params); //query result
                
                return $this->render('reportlist/inventory/rep_inventory_physicalcountreport',array('data'=>$result,'params'=>$params));
            break;   
            case 'Transfer Slip Report':
                $params=array('destination'=>$_POST['destination'],'source'=>$_POST['source'],'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptInventory_TransferSlipReport($params); //query result
                return $this->render('reportlist/inventory/rep_inventory_transferslipreport',array('data'=>$result,'params'=>$params));    
            break;
            case 'Inventory Adjustment Report':
                $params=array('warehouse'=>$_POST['warehouse'],'bref'=>$_POST['bref'],'username'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptInventory_AdjustmentReport($params); //query result
                
                return $this->render('reportlist/inventory/rep_inventory_adjustmentreport',array('data'=>$result,'params'=>$params));
            break;
                //PAYABLES MODULE
            case 'AP Setup':
                $params = array(
                'suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAPsetup_list($params); //query result
               
                return $this->render('reportlist/payable/rep_ap_apsetup',array('data'=>$result,'params'=>$params));
            break;

            case 'AP Voucher':
                $params = array(
                'suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAPVoucher_list($params); //query result
                return $this->render('reportlist/payable/rep_ap_apvoucher',array('data'=>$result,'params'=>$params));
            break;

            case 'Cash/Check Voucher':
                $params = array(
                'suppliername'=>$_POST['client-suppliername'],'supplier'=>$_POST['client-supplier'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCashCheckVoucher_list($params); //query result
                return $this->render('reportlist/payable/rep_ap_cashcheckvoucher',array('data'=>$result,'params'=>$params));
            break;

            case 'AR Setup':
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptARsetup_list($params); //query result
                return $this->render('reportlist/receivable/rep_ar_arsetup',array('data'=>$result,'params'=>$params));
            break;

            case 'Received Payment':
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptReceivedPayment_list($params); //query result
                return $this->render('reportlist/receivable/rep_ar_receivedpayment',array('data'=>$result,'params'=>$params));
            break;

            case 'Counter Receipt':
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCounterReceipt_list($params); //query result
                return $this->render('reportlist/receivable/rep_ar_counterreceipt',array('data'=>$result,'params'=>$params));
            break;
            
            //ACCOUNTING MODULE
            case 'General Journal':
                $params = array(
                'clientname'=>$_POST['client-name'],'clientcode'=>$_POST['client-code'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptGeneralJournal_list($params); //query result
                return $this->render('reportlist/account/rep_acc_generaljournal',array('data'=>$result,'params'=>$params));
            break;
            
            case'Deposit Slip':
                $params = array(
                'bankname'=>$_POST['bankname'],'bankaccount'=>$_POST['bankaccount'],
                'bref'=>$_POST['bref'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'username'=>$_POST['user']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptDepositSlip_list($params); //query result
                return $this->render('reportlist/account/rep_acc_depositslip',array('data'=>$result,'params'=>$params));
            break;                          

            case 'Analyze Customer Collection Monthly':
                $params = array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'center'=>$_POST['center'],
                'year'=>$_POST['year'],'poststatus'=>$_POST['poststatus']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptAnalyzeCustomerCollectionMonthly($params);
                return $this->render('reportlist/customer/rep_c_analyzecustomercollectionmonthly',array('data'=>$result,'params'=>$params));
            break;

            case 'Transmittal List':
                $params =array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'poststatus'=>$_POST['poststatus']);
                $result=Reports::rptTransList($params);
                return $this->render('reportlist/sales/rep_sales_translist',array('data'=>$result,'params'=>$params));
            break;

            case 'Inventory of Backload':
                $params =array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],
                'poststatus2'=>$_POST['poststatus2'],'modelid'=>$_POST['modelid'],'reporttype'=>$_POST['reporttype']);
                $isdetailed = $params['reporttype'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);

                if ($isdetailed=="detailed") {
                    $view= 'reportlist/item/canumay/rep_items_invofbackload';
                }else {
                    $view= 'reportlist/item/canumay/rep_items_invofbackloadsumm';
                }//end if
                $result=Reports::rptInvbackload($params);               
                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;

            case 'Dispatched TX List':
                $params =array('startdate'=>$_POST['startdate'],'enddate'=>$_POST['enddate'],'poststatus'=>$_POST['poststatus']);
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptDisTxLis($params);
                return $this->render('reportlist/sales/rep_sales_dispatchedtxtlist',array('data'=>$result,'params'=>$params));
            break;

            case 'Credit Customer List for Peddling':

                $routename=$_POST['route'];
                $routeid=$_POST['reportrouteid'];
                $date=Yii::$app->systemsettings->getCurrentTimeStamp();
                $date=substr($date, 0, 10);
                $date = strtotime($date .' -6 months');
                $date = date('Y-m-d', $date);

                $params['routename'] = $_POST['route'];
                $params['reportrouteid'] = $_POST['reportrouteid'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCCLPeddling($routeid,$date);
                
                return $this->render('reportlist/sales/rep_sales_cclpeddling',array('data'=>$result,'route'=>$routename));

            break;

            // WTODO JAD 06-03-2019
            case 'Receivables vs Collection':
                $params= array('year'=>$_POST['year'], 'center'=>$_POST['center'], 'type'=>$_POST['jlypoststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptRvC($params,$center);
                return $this->render('reportlist/customer/sbc/rep_c_rvc',array('data'=>$result, 'params'=>$params));
            break;
            
            case 'Commission Report';
                $params = array('client'=>$_POST['client'],'agent'=>$_POST['agent'],
                'groupby'=>$_POST['customer-customeragent'],'center'=>$_POST['center']);

                $center = $params['center'];

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptCommissionreport($params,$center); //query result
                $groupby = $params['groupby'];

                if ($groupby=="client") {
                    $view= 'reportlist/customer/sbc/rep_other_commissionreportclient';
                }else {
                    $view= 'reportlist/customer/sbc/rep_others_commissionreportagent';
                }
                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;

            case 'Sales vs Collection':
                $params= array('year'=>$_POST['year'],'center'=>$_POST['center'],'type'=>$_POST['jlypoststatus']);
                $center = $params['center'];
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result = Reports::rptSvC($params,$center);
                return $this->render('reportlist/customer/sbc/rep_c_svc',array('data'=>$result,'params'=>$params));
            break;
            
            case 'Event Listing': 
                $params = array('user'=>$_POST['user'],'client'=> $_POST['client'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'project'=>$_POST['project'],'schedtype'=>$_POST['schedtype'],'reporttype'=>$_POST['reporttype']);

                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptEventlisting($params); //query result
                if($_POST['reporttype'] == 'detailed') {
                    $view = 'reportlist/other/rep_others_eventlisting';
                } else {
                    $view = 'reportlist/other/rep_others_eventlistingsum';
                }
                return $this->render($view,array('data'=>$result,'params'=>$params));
            break;

            case 'Login Attempts Report':
                try{
                    $params = array('user'=>$_POST['user'],'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],'attempt_status'=>$_POST['attempt_status'],'user_validity'=>$_POST['user_validity']);
                    
                    if($params['start'] == "" || $params['end'] == ""){
                        echo 'Please enter a valid start date and end date. Thank you!';
                        return;
                    }//end if
                    
                    $result=Reports::rptLoginLogs($params);
                    
                    $view = 'reportlist/other/universe/rep_others_logattempts';
                    return $this->render($view,array('data'=>$result,'params'=>$params));
                } catch (ErrorException $e) {
                    echo $e;
                }
            break;

            case 'Detailed Sales - Transaction Report':
                try{
                $params=array(
                'customername'=>$_POST['client-clientname'],'customer'=>$_POST['client-client'],
                'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'poststatus'=>$_POST['poststatus'],'wh'=>$_POST['warehouse'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'trnxtype' => $_POST['customer-universetrnxtype'],
                'sort_by' => $_POST['customer-dsalesrepsortby'],
                'pricegroup'=>$_POST['pricegroup'],
                );
                
               

                if($params['wh'] == ''){
                    return 'WAREHOUSE IS EMPTY, PLEASE DOUBLE CHECK YOUR FORM PARAMETERS.';
                }//end if
                
                $view= 'sales/universe/detailed-sales-report-custom';
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptDetailedSalesReport($params); //query result
                

                return $this->render($view,array('data'=>$result,'params'=>$params));  

                } catch (ErrorException $e) {
                    echo $e;
                }
            break;  

            case 'Detailed Purchases - Transaction Report':
                try{
                $params=array(
                'customername'=>$_POST['client-suppliername'],'customer'=>$_POST['client-supplier'],
                'start'=>$_POST['startdate'],'end'=>$_POST['enddate'],
                'poststatus'=>$_POST['poststatus'],'wh'=>$_POST['warehouse'],
                'principalid'=>$_POST['principalid'],'stockprincipalid'=>$_POST['stockprincipalid'],
                'divisionid'=>$_POST['divisionid'],'stockdivisionid'=>$_POST['stockdivisionid'],
                'itemname'=>$_POST['item-itemname'],'barcode'=>$_POST['item-itemcode'],
                'sort_by' => $_POST['customer-dsalesrepsortby'],'vattype'=>$_POST['customer-optvat']);

                
                /* if($params['wh'] == ''){
                    return 'WAREHOUSE IS EMPTY, PLEASE DOUBLE CHECK YOUR FORM PARAMETERS.';
                }//end if */
                
                $view= 'purchases/universe/detailed-purchases-report-custom';
                Yii::$app->backend->generateReportLog($params,'Printed ' . $report);
                $result=Reports::rptDetailedPurchasesReport($params); //query result
                

                return $this->render($view,array('data'=>$result,'params'=>$params));  

                } catch (ErrorException $e) {
                    echo $e;
                }
            break;  

            default:
                echo "THERE IS AN ERROR , ITS NOT A REPORT";
            break;
        }//END SWITCH
    }//END ACTION PRINT REPORT


//FOR GRAPH FUNCTION

    public function actionChartdata(){
        switch (Yii::$app->session['reportname']) {
            case 'Monthly Sales Report (Graph)':
                $result=Reports::rptChartqry(Yii::$app->session['reportparameters'],Yii::$app->session['reportparameters']['center']);
                Yii::$app->session['reportparameters'] = "";
                Yii::$app->session['reportname'] = "";
                break;
            case 'Sales Comparison (Graph)':
                $result=Reports::rptSalescomparisonChartqry(Yii::$app->session['reportparameters'],Yii::$app->session['reportparameters']['center']);
                Yii::$app->session['reportparameters'] = "";
                Yii::$app->session['reportname'] = "";
                break;    
        }//end swtich

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['chartdata'=>$result];
        //echo json_encode(array('chartdata'=>$result));
    }//end    

    public function actionGetinputs(){
        switch ($_GET['rpt']) {
            case 'Daily Collection (Victory Mall)':
                $qry = "select client from client where iscustomer = 1";
                $data = Yii::$app->sbccommon->opentable($qry);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['transfilters'=>$data];
                //echo json_encode(['transfilters'=>$data]);
            break;
        }//end switch
    }//end 

    public function actionGetoutputs(){
        try {
        switch ($_GET['rpt']) {
            case 'Daily Collection (Victory Mall)':
                foreach ($_GET['params'] as $key => $value) {
                    $qry = "select CR.dateid,CR.docno,CR.doc,CR.seq,CR.client,CR.clientname,CR.yourref,
                    CR.ourref,sum(CR.db) as amt,CR.posted, CR.Tr,CR.compname,CR.ctin,CR.caddr,CR.agent,CR.project,
                    cr.checkno,cr.bank,CR.rem,CR.Users,CR.prep from (
                    select head.trno,0 as posted,head.docno,cntnum.bref as doc,cntnum.seq as seq,
                    head.client,head.clientname,head.address,head.yourref,head.project,detail.bank,detail.checkno,
                    head.ourref,head.dateid,head.cur,head.forex,head.rem,sum(detail.db) as db, 'UNPOSTED' as Tr,
                    center.name as compname,center.tin as ctin,center.addr as caddr,agent.client as agent, cntnum.users,
                    '' as prep from (CRhead as head 
                    left join CRdetail as detail on detail.trno = head.trno) 
                    LEFT join coa on coa.acno = detail.acno
                    left join client on client.client = head.client 
                    left join client as agent on agent.client = client.agent and agent.center = '004'
                    left join cntnum on cntnum.trno = head.trno 
                    left join center on center.code = cntnum.center 
                    where head.dateid between '2012-01-01' and '2012-12-31'
                    and cntnum.users = 'anna' and client.client = '".$value['client']."'
                    and head.doc in ('CR') and left(coa.alias,2)='CA' and cntnum.center = '004'
                    and cntnum.type in ('A','B','') and head.project in ('cash','cheque','') 
                    group by head.trno,head.doc,head.docno,head.client,head.clientname,head.address
                    ,head.yourref,head.ourref,head.dateid,head.cur,head.forex,head.rem
                    UNION ALL
                    select head.trno,1 as posted,head.docno,cntnum.bref as doc,cntnum.seq as seq,client.client,head.clientname, head.address,head.yourref,
                    head.project,detail.bank,detail.checkno, head.ourref,head.dateid,head.cur,head.forex,head.rem,
                    sum(detail.db) as db,'POSTED' as Tr,
                    center.name as compname,center.tin as ctin,center.addr as caddr,agent.client as agent,
                    cntnum.users,'' as prep
                    from (GLhead as head 
                    left join GLDetail as detail on detail.trno = head.trno) 
                    left join client on client.clientid=head.clientid
                    left join client as agent on agent.client = client.agent and agent.center = '004' 
                    LEFT join coa on coa.acnoid = detail.acnoid
                    left join cntnum on cntnum.trno = head.trno 
                    left join center on center.code = cntnum.center 
                    Where head.dateid between '2012-01-01' and '2012-12-31'
                    and cntnum.users = 'anna' and client.client = '".$value['client']."' 
                    and head.doc in ('CR') and left(coa.alias,2)='CA'
                    and cntnum.center = '004' and cntnum.type in ('A','B','') 
                    and head.project in ('cash','cheque','') 
                    group by head.trno,head.doc,head.docno,client.client,head.clientname,head.address,
                    head.yourref,head.ourref, head.dateid,head.cur,head.forex,head.rem) as CR
                    WHERE CR.Tr = CR.Tr  group by CR.dateid,CR.docno,CR.client,CR.clientname,CR.yourref,
                    CR.ourref,CR.posted,CR.Tr order by CR.seq";


                    $data[] = Yii::$app->sbccommon->opentable($qry);
                    return 0;
                }//end 

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['data'=>$data];
                //echo json_encode(['data'=>$data]);
            break;
        }//end switch
        
            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end 


    public function actionPosso(){   
    try {
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $qry = "select head.uv_transtype as transtype,right(head.docno,13) as docnoless,
                right(head.docno,4) as stubnum,ag.clientname as agent,head.uv_amountreceived,item.isvat,
                head.docno,head.clientname,DATE_FORMAT(left(head.dateid,10), '%m/%d/%Y') as dateid,
                item.shortname,stock.isqty,stock.isamt,stock.uom,item.sizeid as loc,
                (stock.ext/stock.isqty) as netprice,stock.ext as amt,stock.disc from sohead as head
                left join sostock as stock on stock.trno = head.trno
                left join item on item.barcode = stock.barcode
                left join client as ag on ag.client = head.agent
                where head.trno = ".$params['q']."
                UNION ALL
                select head.uv_transtype as transtype,right(head.docno,13) as docnoless,
                right(head.docno,4) as stubnum,ag.clientname as agent,head.uv_amountreceived,item.isvat,
                head.docno,head.clientname,DATE_FORMAT(left(head.dateid,10), '%m/%d/%Y') as dateid,
                item.shortname,stock.isqty,stock.isamt,stock.uom,item.sizeid as loc,
                (stock.ext/stock.isqty) as netprice,stock.ext as amt,stock.disc from hsohead as head
                left join hsostock as stock on stock.trno = head.trno
                left join item on item.barcode = stock.barcode
                left join client as ag on ag.client = head.agent
                where head.trno = ".$params['q']."";

        $data = Yii::$app->sbccommon->opentable($qry);

        //Note: Connection for Network (PC with Password) (username:password@computername/sharedprintername)
        //$connector = new WindowsPrintConnector("smb://IT:success26@Sbc/epson tmu-220");
        $connector = new WindowsPrintConnector("EPSON TM-U220 Receipt");
        Yii::$app->systemsettings->setDefaultTimeZone();
        
        $linebreaker = Yii::$app->backend->POSPrint("linebreaker");
        $newline = Yii::$app->backend->POSPrint("newline");
        $printer = new Printer($connector);
        $string = Yii::$app->backend->POSPrint("default","Sales Order #: ".$data[0]['docnoless']);
        $printer->text($string);
        $printer->text($newline);
    
        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Date:".$data[0]['dateid'],'col2'=>"Time:".date('h:i:s A')]);
        $printer->text($string);
        $printer->text($newline);
        $string = Yii::$app->backend->POSPrint("default","Name: ".$data[0]['clientname']);
        $printer->text($linebreaker);        
        $string = Yii::$app->backend->POSPrint("default","DESCRIPTION");
        $printer->text($string);
        $printer->text($newline);
        $values = ['col1'=>['txt'=>'QTY','len'=>5],
                   'col2'=>['txt'=>'UNIT','len'=>5],
                   'col3'=>['txt'=>'LOCATION','len'=>10],
                   'col4'=>['txt'=>'NET PRICE','len'=>10],
                   'col5'=>['txt'=>'AMOUNT','len'=>10]];
        $string = Yii::$app->backend->POSPrint("multicol",$values);
        $printer->text($string);
        $printer->text($linebreaker);        
        $totamt = 0;
        
        $vatsales = 0;
        $vatamt = 0;
        $vatexempt = 0;
        $zerorated = 0;
        $itemcount = 0;
        $grossamt = 0;
        $totsenior = 0;
        $seniorpercent = .20;

        $seniorlessvat = 0;

        foreach ($data as $key => $value) {
            $itemcount += 1;
            $totamt += floatval($value['amt']);
            $grossamt += (floatval($value['isamt']) * floatval($value['isqty']));

            $string = Yii::$app->backend->POSPrint("default",$value['shortname']);
            $printer->text($string);
            $printer->text($newline);

            if($value['isvat'] == 1){
                $amtstr = number_format($value['amt'],2).'V';
                $vatsales += (floatval($value['amt']) / 1.12);
                $vatamt += (floatval($value['amt']) / 1.12) * .12; 

                $seniorlessvat = ((floatval($value['amt']) / 1.12)) * floatval($seniorpercent);
            }else{
                $seniorlessvat = (floatval($value['amt'])) * floatval($seniorpercent);
                $vatexempt += floatval($value['amt']);
                $amtstr = number_format($value['amt'],2).'E';
            }//end if


            $values = ['col1'=>['txt'=>number_format($value['isqty']),'len'=>5],
                       'col2'=>['txt'=>$value['uom'],'len'=>5],
                       'col3'=>['txt'=>$value['loc'],'len'=>10],
                       'col4'=>['txt'=>number_format($value['netprice'],2),'len'=>10],
                       'col5'=>['txt'=>$amtstr,'len'=>10]];

            $string = Yii::$app->backend->POSPrint("multicol",$values);
            $printer->text($string);

            if($value['disc'] != ''){
                $discamt = Yii::$app->sbccommon->Discount($value['isamt'],$value['disc']);
                $printer->text($newline);
                $string = Yii::$app->backend->POSPrint("default","@ ".number_format($value['isamt'],2)." Disc (".$value['disc']."): ".number_format($discamt,2)."");
                $printer->text($string);

                $totseniorless = ((floatval($value['isamt']) * floatval($value['isqty'])) - floatval($discamt)) * floatval($seniorpercent);
            }else{
                $totseniorless = (floatval($value['isamt']) * floatval($value['isqty'])) * floatval($seniorpercent);
            }//end if

            // $totsenior += $totseniorless;
            $totsenior += $seniorlessvat;
            $printer->text($newline);
        }//end for each

        $printer->text($linebreaker);        
        
        if($data[0]['transtype'] == 'SENIOR'){
            $printer->text($linebreaker);        
            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"GROSS AMOUNT:",'col2'=>number_format($grossamt,2)]);
            $printer->text($string);
            $printer->text($newline);

            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Less VAT:",'col2'=>number_format($vatamt,2)]);
            $printer->text($string);
            $printer->text($newline);

            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Less Senior Disc.(20%):",'col2'=>number_format($totsenior,2)]);
            $printer->text($string);
            $printer->text($newline);

            $gtotalsenior = $totamt - $vatamt - $totsenior;
            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"TOTAL:",'col2'=>number_format($gtotalsenior,2)]);
            $printer->text($string);
            $printer->text($newline);
        }else{
            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"TOTAL:",'col2'=>number_format($totamt,2)]);
            $printer->text($string);
            $printer->text($newline);
        }//end if

        if(is_numeric($value['uv_amountreceived'])){
            $amtrec = number_format($value['uv_amountreceived'],2);
        }else{
            $amtrec = number_format(0,2);
        }//end if
        
        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"AMOUNT RECEIVED:",'col2'=>$amtrec]);
        $printer->text($string);
        $printer->text($newline);

        $printer->text($linebreaker);        

        
        if($data[0]['transtype'] == 'SENIOR'){
            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"VATable Sales    (V):",'col2'=>number_format(0,2)]);
            $printer->text($string);
            $printer->text($newline);
            
            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"VAT Amount (12%):",'col2'=>number_format(0,2)]);
            $printer->text($string);
            $printer->text($newline);
    
            $gtotalsenior = $totamt - $vatamt - $totsenior;
            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"VAT Exempt Sales (E):",'col2'=>number_format($gtotalsenior,2)]);
            $printer->text($string);
            $printer->text($newline);

            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Zero Rated Sales (Z):",'col2'=>number_format(0,2)]);
            $printer->text($string);
            $printer->text($newline);
        }else{
            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"VATable Sales    (V):",'col2'=>number_format($vatsales,2)]);
            $printer->text($string);
            $printer->text($newline);

            if($vatsales != 0){
                $vatamtstr = floatval($totamt) - floatval($vatsales);
            }else{
                $vatamtstr = 0;
            }//end if

            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"VAT Amount (12%):",'col2'=>number_format($vatamt,2)]);
            $printer->text($string);
            $printer->text($newline);

            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"VAT Exempt Sales (E):",'col2'=>number_format($vatexempt,2)]);
            $printer->text($string);
            $printer->text($newline);

            $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Zero Rated Sales (Z):",'col2'=>number_format(0,2)]);
            $printer->text($string);
            $printer->text($newline);
        }//end if

        
        $printer->text($linebreaker);        

        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"No. of Items:",'col2'=>number_format($itemcount)]);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Terminal No.:",'col2'=>"ONLINE"]);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Sales Clerk:",'col2'=>$data[0]['agent']]);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default","Picker:");
        $printer->text($string);
        $printer->text($newline);
        $string = Yii::$app->backend->POSPrint("default","        --------------------------------");
        $printer->text($string);
        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Claim Stub #:",'col2'=>$data[0]['stubnum']]);
        $printer->text($string);
        $printer->text($newline);
        $printer->text($newline);
        
        $string = Yii::$app->backend->POSPrint("default","    THIS IS NOT AN OFFICIAL RECEIPT");
        $printer->text($string);
        $printer->feed(3);

        $printer->text($linebreaker);
        $printer->feed(3);
        $string = Yii::$app->backend->POSPrint("default","           Claim Stub #: ".$data[0]['stubnum']);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Sales Order #",'col2'=>$data[0]['stubnum']]);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("col-2",['col1'=>"Date",'col2'=>$data[0]['dateid']]);
        $printer->text($string);
        $printer->text($newline);

        $printer->feed(3);
        $printer->cut();
        /* Close printer */
        $printer->close();
        
        
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end fn 


    public function actionSjpickroll(){
        Yii::$app->backend->AjaxVerification($this); 
        $params = $_GET;
        $query = "select pick.client as picker,checked.client as checker,
                item.shortname,concat(left(head.docno,2) ,right(head.docno,6)) as posdocno,head.doc, head.trno,client.client,
                client.clientname,head.docno,left(head.dateid,10) as dateid, 
                head.ourref, head.yourref,item.barcode,stock.itemname,stock.uom,stock.isqty,
                stock.disc,stock.isamt, stock.amt, stock.ext,head.rem,client.tin,head.terms,item.sizeid as bin
                from glhead as head
                left join glstock as stock on head.trno = stock.trno
                left join client on head.clientid = client.clientid
                left join client as pick on pick.client = head.pickby
                left join client as checked on checked.client = head.checkby
                left join item on stock.itemid = item.itemid
                where head.doc = 'SJ' and head.trno = ".$params['q']."
                union all
                select pick.client as picker,checked.client as checker,
                item.shortname,concat(left(head.docno,2) ,right(head.docno,6)) as posdocno,head.doc, head.trno,
                client.client,client.clientname,head.docno,head.dateid, head.ourref,   
                head.yourref,item.barcode,stock.itemname,stock.uom, stock.isqty,stock.disc,stock.isamt, 
                stock.amt, stock.ext,head.rem,client.tin,head.terms,item.sizeid as bin
                from lahead as head
                left join lastock as stock on head.trno = stock.trno
                left join client on head.client = client.client
                left join client as pick on pick.client = head.pickby
                left join client as checked on checked.client = head.checkby
                left join item on stock.barcode = item.barcode
                where head.doc = 'SJ' and head.trno = ".$params['q'];

        $result = YIi::$app->sbccommon->opentable($query);

        $connector = new WindowsPrintConnector("EPSON TM-U220 Receipt");
        Yii::$app->systemsettings->setDefaultTimeZone();

        $linebreaker = Yii::$app->backend->POSPrint("linebreaker");
        $newline = Yii::$app->backend->POSPrint("newline");
        $printer = new Printer($connector);

        $header = Yii::$app->session['loggeduser']['username']." ".Yii::$app->systemsettings->getCurrentTimeStamp()." ".Yii::$app->session['loggeduser']['center'] . " RSSC";
        $string = Yii::$app->backend->POSPrint("default",$header);
        $printer->text($string);
        $printer->text($newline);

        $header2 = "Universe Pharmacy";
        $string = Yii::$app->backend->POSPrint("default",$header2);
        $printer->text($string);
        $printer->text($newline);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default",'PICK ROLL');
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default",'Doc #:' . $result[0]['posdocno']);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default",'Date:' . $result[0]['dateid']);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default",'Customer:' . substr($result[0]['clientname'],0,30));
        $printer->text($string);
        $printer->text($newline);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default",'DESCRIPTION');
        $printer->text($string);
        $printer->text($newline);

        $values = ['col1'=>['txt'=>'QTY','len'=>10],
                   'col2'=>['txt'=>'UNIT','len'=>10],
                   'col3'=>['txt'=>'BIN','len'=>20]];

        $string = Yii::$app->backend->POSPrint("multicol",$values);
        $printer->text($string);
        $printer->text($linebreaker);        
        $printer->text($newline);

        foreach ($result as $key => $value) {
            $string = Yii::$app->backend->POSPrint("default",$value['shortname']);
            $printer->text($string);
            $printer->text($newline);

            $values = ['col1'=>['txt'=>number_format($value['isqty']),'len'=>10],
                       'col2'=>['txt'=>$value['uom'],'len'=>10],
                       'col3'=>['txt'=>$value['bin'],'len'=>20]];

            $string = Yii::$app->backend->POSPrint("multicol",$values);
            $printer->text($string);
            $printer->text($newline);
        }//end for each
        
        $printer->text($linebreaker);        
        $printer->text($newline);

        if(strlen($result[0]['rem']) <= 40){
            $string = Yii::$app->backend->POSPrint("default",'NOTE: '.$result[0]['rem']);
            $printer->text($string);
            $printer->text($newline);
        }else{
            $rowcount = round(strlen($result[0]['rem']) / 40);
            $startcounter = 0;
            $result[0]['rem'] = str_replace('/n', ' ', $result[0]['rem']);

            for ($i=0; $i < $rowcount; $i++) { 
                if($i == 0){
                    $string = Yii::$app->backend->POSPrint("default",'NOTE: '.substr($result[0]['rem'], 0,34));
                    $printer->text($string);
                    $printer->text($newline);

                    $startcounter += 34;
                }else{
                    $string = Yii::$app->backend->POSPrint("default",substr($result[0]['rem'], $startcounter,40));
                    $printer->text($string);
                    $printer->text($newline);

                    $startcounter += 40;
                }//end if
            }//end if
        }//end if
        $printer->text($newline);
        
        $string = Yii::$app->backend->POSPrint("default",'PREPARED BY: ' .Yii::$app->session['loggeduser']['username']);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default",'PICKED BY: '.$result[0]['picker']);
        $printer->text($string);
        $printer->text($newline);

        $string = Yii::$app->backend->POSPrint("default",'CHECKED BY: '.$result[0]['checker']);
        $printer->text($string);
        $printer->text($newline);



        $printer->cut();
        /* Close printer */
        $printer->close();
    }//end fn
}//END REPORT CONTROLLER

