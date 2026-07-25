<?php
namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\Web\Session;
use app\models\Client;
use app\models\Log;

use yii\web\Controller;

use yii\helpers\Url;
use yii\base\ErrorException;

///SYSTEM SETTINGS HAVE ALL FUNCTIONS THAT GIVE DEFAULT SYSTEM SETTINGS
class syssettings extends Component{    
    
    //TO SEARCH ALL REQUIRED SETTING 
    //SEARCH FOR: 
    //** REQUIRED ** 

    //CURRENT QUOTA //** REQUIRED ** 
    public function quota(){
      $quota=11000000;
      return $quota;
    }//end if

    //PREV QUOTA //** REQUIRED ** 
    public function quota2(){
      $quota=10500000;
      return $quota;
    }//end if

    //LLYS QUOTA //** REQUIRED ** 
    public function quota3(){
      $quota=10000000;
      return $quota;
    }//end if

    //SETTING IF YOU COULD CLEAR DATABASE via defaultcontroller action on ADMIN Module
    //NEEDS TO BE FALSE BEFORE DELOYMENT
    //just access host/projectfolder/admin/cleardatabase
    public function enableClearDatabase(){
        return false;
    }//end f

    private function generateModifiedAccessList(){
    //PUT HERE ALL MODIFIED AND ACCESS OF MODULES AND REPORT

        $taxmenu_access = ["(3099,0,'Allow View Tax Menu','',0,'\\804','\\1',0,0,0)"];

        $taxwheld_access = ["(3100,0,'Tax Wheld','',0,'\\204','\\2',0,0,0)",
                            "(3101,0,'Allow View Transaction TW','TW',0,'\\20401','\\204',0,0,0)",
                            "(3102,0,'Allow Click Edit Button  TW','',0,'\\20402','\\204',0,0,0)",
                            "(3103,0,'Allow Click New Button TW','',0,'\\20403','\\204',0,0,0)",
                            "(3104,0,'Allow Click Save Button TW','',0,'\\20404','\\204',0,0,0)",
                            "(3105,0,'Allow Click Change Document# TW','',0,'\\20405','\\204',0,0,0)",
                            "(3106,0,'Allow Click Delete Button TW','',0,'\\20406','\\204',0,0,0)",
                            "(3107,0,'Allow Click Print Button TW','',0,'\\20407','\\204',0,0,0)",
                            "(3108,0,'Allow Click Lock Button TW','',0,'\\20408','\\204',0,0,0)",
                            "(3109,0,'Allow Click UnLock Button TW','',0,'\\20409','\\204',0,0,0)",
                            "(3110,0,'Allow Click Post Button TW','',0,'\\20410','\\204',0,0,0)",
                            "(3111,0,'Allow Click UnPost Button TW','',0,'\\20411','\\204',0,0,0)"];

        $pdc_access = ["(700,1,'Postdated Checks','',0,'\\305','\\3',0,0,0)",
                    "(701,1,'Allow View Transaction PDC','',0,'\\30501','\\305',0,0,0)",
                    "(702,1,'Allow Click Edit Button PDC','',0,'\\30502','\\305',0,0,0)",
                    "(703,1,'Allow Click New Button PDC','',0,'\\30503','\\305',0,0,0)",
                    "(704,1,'Allow Click Save Button PDC','',0,'\\30504','\\305',0,0,0)",
                    "(705,1,'Allow Click Delete Button PDC','',0,'\\30505','\\305',0,0,0)",
                    "(706,1,'Allow Void PDC','',0,'\\30506','\\305',0,0,0)",
                    "(707,1,'Allow Click Post Button PDC','',0,'\\30507','\\305',0,0,0)",
                    "(708,1,'Allow Click Unpost Button PDC','',0,'\\30508','\\305',0,0,0)"];
        $bankrecon_access=["(600,0,'Bank Reconcile','BR',0,'\\703','\\7',0,'0',0)",
                    "(601,0,'Allow View Bank BR','BR',0,'\\70301','\\703',0,'0',0)",
                    "(602,0,'Allow Click Print Button BR','',0,'\\70302','\\703',0,'0',0)",
                    "(603,0,'Allow Click Reconciled Button  BR','',0,'\\70303','\\703',0,'0',0)"];
        
        $principal_access = ["(3162,1,'Principal','',0,'\\113','\\1',0,0,0)"];

        $supplierpricechange_access = ["(3183,0,'Supplier Price Change','',0,'\\404','\\4',0,'0',0)",
                    "(3184,0,'Allow View Transaction SPC','SP',0,'\\40401','\\404',0,'0',0)",
                    "(3185,0,'Allow Click Edit Button SPC','',0,'\\40402','\\404',0,'0',0)",
                    "(3186,0,'Allow Click New Button SPC','',0,'\\40403','\\404',0,'0',0)",
                    "(3187,0,'Allow Click Save Button SPC','',0,'\\40404','\\404',0,'0',0)",
                    "(3188,0,'Allow Click Change Document#  SPC','',0,'\\40405','\\404',0,'0',0)",
                    "(3189,0,'Allow Click Delete Button SPC','',0,'\\40406','\\404',0,'0',0)",
                    "(3190,0,'Allow Click Print Button SPC','',0,'\\40407','\\404',0,'0',0)",
                    "(3191,0,'Allow Click Lock Button SPC','',0,'\\40408','\\404',0,'0',0)",
                    "(3192,0,'Allow Click UnLock Button SPC','',0,'\\40409','\\404',0,'0',0)",
                    "(3193,0,'Allow Change Amount SPC','',0,'\\40410','\\404',0,'0',0)",
                    "(3194,0,'Allow Click Post Button SPC','',0,'\\40411','\\404',0,'0',0)",
                    "(3195,0,'Allow Click UnPost  Button SPC','',0,'\\40412','\\404',0,'0',0)",
                    "(3196,1,'Allow Click Add Item SPC','',0,'\\40413','\\404',0,'0',0)",
                    "(3197,1,'Allow Click Edit Item SPC','',0,'\\40414','\\404',0,'0',0)",
                    "(3198,1,'Allow Click Delete Item SPC','',0,'\\40415','\\404',0,'0',0)"];

        $finishedgoods_access = ["(3200,0,'Finished Goods','',0,'\\114','\\1',0,'0',0)",
                    "(3201,0,'Allow View Finished Goods','SP',0,'\\11401','\\114',0,'0',0)",
                    "(3202,0,'Allow Click Edit Button Finished Goods','',0,'\\11402','\\114',0,'0',0)",
                    "(3203,0,'Allow Click New Button Finished Goods','',0,'\\11403','\\114',0,'0',0)",
                    "(3204,0,'Allow Click Save Button Finished Goods','',0,'\\11404','\\114',0,'0',0)",
                    "(3205,0,'Allow Click Change Document#  Finished Goods','',0,'\\11405','\\114',0,'0',0)",
                    "(3206,0,'Allow Click Delete Button Finished Goods','',0,'\\11406','\\114',0,'0',0)",
                    "(3207,0,'Allow Click Print Button Finished Goods','',0,'\\11407','\\114',0,'0',0)",
                    "(3260,0,'Allow View / Update Piece Rate and Qty','',0,'\\11408','\\114',0,'0',0)"];

        $fg_minis=["(3208,1,'Materials Master','*129',0,'\\115','\\1',0,0,0)",
                "(3209,1,'Cylinders Master','',0,'\\116','\\1',0,'0',0)",
                "(3210,1,'Process Master','',0,'\\117','\\1',0,'0',0)",
                "(3211,1,'Colors Master','*129',0,'\\118','\\1',0,'0',0)"];

        $quotation_access =["(3212,0,'Quotation','',0,'\\505','\\5',0,'0',0)",
                    "(3213,0,'Allow View Transaction Quotation','SO',0,'\\50501','\\505',0,'0',0)",
                    "(3214,0,'Allow Click Edit Button Quotation','',0,'\\50502','\\505',0,'0',0)",
                    "(3215,0,'Allow Click New  Button Quotation','',0,'\\50503','\\505',0,'0',0)",
                    "(3216,0,'Allow Click Save Button Quotation','',0,'\\50504','\\505',0,'0',0)",
                    "(3217,0,'Allow Click Change Document#  Quotation','',0,'\\50505','\\505',0,'0',0)",
                    "(3218,0,'Allow Click Delete Button Quotation','',0,'\\50506','\\505',0,'0',0)",
                    "(3219,0,'Allow Click Print Button Quotation','',0,'\\50507','\\505',0,'0',0)",
                    "(3220,0,'Allow Click Lock Button Quotation','',0,'\\50508','\\505',0,'0',0)",
                    "(3221,0,'Allow Click UnLock Button Quotation','',0,'\\50509','\\505',0,'0',0)",
                    "(3222,0,'Allow Change Amount  Quotation','',0,'\\50510','\\505',0,'0',0)",
                    "(3223,0,'Allow Check Credit Limit Quotation','',0,'\\50511','\\505',0,'0',0)",
                    "(3224,0,'Allow Click Post Button Quotation','',0,'\\50512','\\505',0,'0',0)",
                    "(3225,0,'Allow Click UnPost  Button Quotation','',0,'\\50513','\\505',0,'0',0)",
                    "(3226,1,'Allow Click Add Item Quotation','',0,'\\50514','\\505',0,'0',0)",
                    "(3227,1,'Allow Click Edit Item Quotation','',0,'\\50515','\\505',0,'0',0)",
                    "(3228,1,'Allow Click Delete Item Quotation','',0,'\\50516','\\505',0,'0',0)",];

        $suppliers_invoice =["(3274,0,'Supplier`s Invoice','',0,'\\406','\\4',0,'0',0)",
                    "(3275,0,'Allow View Transaction S. Invoice','SV',0,'\\40601','\\406',0,'0',0)",
                    "(3276,0,'Allow Click Edit Button S. Invoice','',0,'\\40602','\\406',0,'0',0)",
                    "(3277,0,'Allow Click New  Button S. Invoice','',0,'\\40603','\\406',0,'0',0)",
                    "(3278,0,'Allow Click Save Button S. Invoice','',0,'\\40604','\\406',0,'0',0)",
                    "(3279,0,'Allow Click Change Document#  S. Invoice','',0,'\\40605','\\406',0,'0',0)",
                    "(3280,0,'Allow Click Delete Button S. Invoice','',0,'\\40606','\\406',0,'0',0)",
                    "(3281,0,'Allow Click Print Button S. Invoice','',0,'\\40607','\\406',0,'0',0)",
                    "(3282,0,'Allow Click Lock Button S. Invoice','',0,'\\40608','\\406',0,'0',0)",
                    "(3283,0,'Allow Click UnLock Button S. Invoice','',0,'\\40609','\\406',0,'0',0)",
                    "(3284,0,'Allow Change Amount  S. Invoice','',0,'\\40610','\\406',0,'0',0)",
                    "(3285,0,'Allow Check Credit Limit S. Invoice','',0,'\\40611','\\406',0,'0',0)",
                    "(3286,0,'Allow Click Post Button S. Invoice','',0,'\\40612','\\406',0,'0',0)",
                    "(3287,0,'Allow Click UnPost  Button S. Invoice','',0,'\\40613','\\406',0,'0',0)",
                    "(3288,1,'Allow Click Add Item S. Invoice','',0,'\\40614','\\406',0,'0',0)",
                    "(3289,1,'Allow Click Edit Item S. Invoice','',0,'\\40615','\\406',0,'0',0)",
                    "(3290,1,'Allow Click Delete Item S. Invoice','',0,'\\40616','\\406',0,'0',0)",];

        //DASHBOARD ACCESS
        $sjtran_access = "(3229,1,'[Dashboard] View # of SJ Transactions','',0,'\\1001','\\10',0,'0',0)";
        $rrtran_access = "(3230,1,'[Dashboard] View # of RR Transactions','',0,'\\1002','\\10',0,'0',0)";
        $arout_access = "(3231,1,'[Dashboard] View total Outstanding AR','',0,'\\1003','\\10',0,'0',0)";
        $apout_access = "(3232,1,'[Dashboard] View total Outstanding AP','',0,'\\1004','\\10',0,'0',0)";

        $compsales_access = "(3233,1,'[Dashboard] View Comparative Sales Report Graph','',0,'\\1005','\\10',0,'0',0)";

        $expenses_access = "(3240,1,'[Dashboard] View Expenses Graph','',0,'\\1012','\\10',0,'0',0)";        
        $collections_access = "(3241,1,'[Dashboard] View Collections Graph','',0,'\\1013','\\10',0,'0',0)"; 
        $untran_access = "(3242,1,'[Dashboard] View Unposted Transactions','',0,'\\1014','\\10',0,'0',0)";        
        $monthtran_access = "(3243,1,'[Dashboard] Transactions for the Month','',0,'\\1015','\\10',0,'0',0)";   


        $pricechanges_access = "(3238,1,'[Dashboard] View Price Changes','',0,'\\1011','\\10',0,'0',0)";
        $unsjtran_access = "(3234,1,'[Dashboard] View Transaction Status - Unposted SJ Transactions','',0,'\\1006','\\10',0,'0',0)";
        $unrrtran_access = "(3235,1,'[Dashboard] View Transaction Status - Unposted RR Transactions','',0,'\\1007','\\10',0,'0',0)";
        $paidclearedrr_access = "(3236,1,'[Dashboard] View Transaction Status - Paid/ Cleared Amount Receivables','',0,'\\1008','\\10',0,'0',0)";
        $paidclearedap_access = "(3237,1,'[Dashboard] View Transaction Status - Paid/ Cleared Amount Payables','',0,'\\1009','\\10',0,'0',0)";
        $recentsjtran_access = "(3239,1,'[Dashboard] View Recent SJ Transactions','',0,'\\1010','\\10',0,'0',0)";             
        $sbcdaysched_access = "(3244,1,'[Dashboard] Schedules for the Day','',0,'\\1016','\\10',0,'0',0)";  
        
    
        //NOT YET IN INDEX PAGE
        $sbcunpaidsales_access = "(3245,1,'[Dashboard] SBC Unpaid Accounts','',0,'\\1017','\\10',0,'0',0)";   

        $tenplus_access=["(3246,1,'TP Shipping Fee','',0,'\\810','\\8',0,'0',0)",
                        "(3247,1,'TP Handling Fee','',0,'\\809','\\8',0,'0',0)"];


        $sbc_exclusives=["(3249,1,'SBC Reimbursement Checking','',0,'\\815','\\8',0,'0',0)",
                        "(3250,1,'SBC Reimbursement Releasing','',0,'\\816','\\8',0,'0',0)"];

        $mlcp_productype_access = ["(3255,0,'Product Type Master','',0,'\\119','\\1',0,0,0)"];
        $mlcp_transformation_access = ["(3256,0,'Transformation Master','',0,'\\120','\\1',0,0,0)"];
        $mlcp_prodspecs_access = ["(3257,0,'Product Specs Master','',0,'\\121','\\1',0,0,0)"];
        $mlcp_sealing_access = ["(3258,0,'Sealing Master','',0,'\\122','\\1',0,0,0)"];
        $mlcp_plasticcolor_access = ["(3259,0,'Plastic Color Master','',0,'\\123','\\1',0,0,0)"];
        $mlcp_inout_access = ["(3261,0,'Input/Output Master','',0,'\\124','\\1',0,0,0)"];
        $mlcp_reject_access = ["(3262,0,'Reject Master','',0,'\\125','\\1',0,0,0)"];

        $mlcp_joborder = ["(3263,0,'Job Order','',0,'\\141','\\14',0,0,0)"];
        $kingg_salesagentreport = ["(3298,0,'View Breakdown Report','',0,'\\143','\\14',0,0,0)"];
        $mlcp_productionupdate = ["(3264,0,'Production Update','',0,'\\142','\\14',0,0,0)"];
        $mlcp_mlocation = ["(3291,0,'Location Master','',0,'\\126','\\1',0,0,0)"];

        $kingg_salesagentreport = ["(3296,0,'Sales Agent Report','',0,'\\90703','\\907',0,0,0)"];
        $kingg_salesitemperreportperdr = ["(3297,0,'Sales Item Per Report Per DR','',0,'\\90413','\\904',0,0,0)"];
        $printlogtracer = ["(3307,0,'Print Log Tracer','',0,'\\857','\\8',0,0,0)"];
        $transupdater = ["(4001,0,'Transaction Update Module','',0,'\\858','\\8',0,0,0)"];


        switch (Yii::$app->systemsettings->companyConfig()){
            case 'UNIVERSE':
                $modfied_access = [$supplierpricechange_access,$bankrecon_access,$taxwheld_access,$taxmenu_access,$printlogtracer, $transupdater];
            break;

            case 'MLCP':
                $modfied_access = [$quotation_access,$finishedgoods_access,$fg_minis,
                                  $mlcp_plasticcolor_access,$mlcp_prodspecs_access,$mlcp_sealing_access,
                                  $mlcp_transformation_access,$mlcp_productype_access,
                                  $mlcp_inout_access,$mlcp_reject_access,$mlcp_joborder,$mlcp_productionupdate,
                                  $suppliers_invoice,$mlcp_mlocation,$bankrecon_access];
            break;

            case 'FHI':
                $modfied_access = [$suppliers_invoice,$bankrecon_access];
            break;

            case 'GALANG':
                $modfied_access = [$bankrecon_access];
            break;

            case 'KINGGEORGE':
                $modfied_access = [$kingg_salesitemperreportperdr,$kingg_salesagentreport];
            break;

            case 'TENPLUS':
                $modfied_access = [$tenplus_access];
            break;

            case 'SBC':
                $modfied_access = [$sbc_exclusives];
            break;

            default:
                $modfied_access = [];
            break;
        }//end switch

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'SBC':
                $dashboard_access = [$sjtran_access,$rrtran_access,$arout_access,$apout_access,$compsales_access,
                $unsjtran_access,$unrrtran_access,$paidclearedrr_access,$paidclearedap_access,
                $recentsjtran_access,$pricechanges_access,$expenses_access,$collections_access,
                $untran_access,$monthtran_access,$sbcdaysched_access,$sbcunpaidsales_access];
            break;
            
            default:
               $dashboard_access = [$sjtran_access,$rrtran_access,$arout_access,$apout_access,$compsales_access,
               $unsjtran_access,$unrrtran_access,$paidclearedrr_access,$paidclearedap_access,
               $recentsjtran_access,$pricechanges_access,$expenses_access,$collections_access,
               $untran_access,$monthtran_access];
            break;
        }//end switch

        array_push($modfied_access,$dashboard_access);  
        return ['accesslist'=>$modfied_access];
    }//end f

    private function generateSystemAccessAttributes($systype){
    //GENERATES / INSERTS SET OF ACCESSES ON ATTRIBUTES TABLE UPON LOGIN (MODULES ONLY)
    //NOTE: ADD ATTRIBUTES INSIDE generateGeneralAccessList(), if module access / report access
    //will be available as standard
    //ADD ATTRIBUTES ON generate-AccessList() if module access / report access
    //is a modified access per client
        $accesslist = $this->generateGeneralAccessList($systype);
        $truncator = "truncate attributes";

        Yii::$app->sbccommon->execqry($truncator);

        foreach ($accesslist['accessparents'] as $key => $value) {            
            if($value != ''){
                $nipps = explode(',', $value);
                if($nipps[0] != ""){
                    $nipps[5] = str_replace("'", "", $nipps[5]);
                    $nipps[6] = str_replace("'", "", $nipps[6]);
                    
                    $qry = "insert into `attributes` 
                            (`attribute`,`keyid`,`description`,`alias`,`allowed`,`code`,`parent`,`isexpanded`,`icon`,`parentid`) 
                            values " . $nipps[0] .",". $nipps[1] .",". $nipps[2] .",". $nipps[3] .",". $nipps[4] .",". 
                            "'\\".$nipps[5]."'" .",". "'\\".$nipps[6]."'" .",". $nipps[7] .",". $nipps[8] .",". $nipps[9];
                    Yii::$app->sbccommon->execqry($qry);
                }//end if
            }//end if
        }//end if

        foreach ($accesslist['accesslist'] as $key => $value) {
            if($value != ''){
                foreach ($value as $key2 => $value2) {
                    $nipps = explode(',', $value2);
                    if($nipps[0] != ""){
                        $nipps[5] = str_replace("'", "", $nipps[5]);
                        $nipps[6] = str_replace("'", "", $nipps[6]);

                        $qry = "insert into `attributes` 
                                (`attribute`,`keyid`,`description`,`alias`,`allowed`,`code`,`parent`,`isexpanded`,`icon`,`parentid`) 
                                values ". $nipps[0] .",". $nipps[1] .",". $nipps[2] .",". $nipps[3] .",". $nipps[4] .",". 
                                "'\\".$nipps[5]."'" .",". "'\\".$nipps[6]."'" .",". $nipps[7] .",". $nipps[8] .",". $nipps[9];
                        Yii::$app->sbccommon->execqry($qry);
                    }//end if
                }//end for each lvl 2
            }//end if
        }//end for each

        $accesslist_modified = $this->generateModifiedAccessList($systype);
        foreach ($accesslist_modified['accesslist'] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $nipps = explode(',', $value2);
                if($nipps[0] != ""){
                    $nipps[5] = str_replace("'", "", $nipps[5]);
                    $nipps[6] = str_replace("'", "", $nipps[6]);

                    $qry = "insert into `attributes` 
                            (`attribute`,`keyid`,`description`,`alias`,`allowed`,`code`,`parent`,`isexpanded`,`icon`,`parentid`) 
                            values ". $nipps[0] .",". $nipps[1] .",". $nipps[2] .",". $nipps[3] .",". $nipps[4] .",". 
                            "'\\".$nipps[5]."'" .",". "'\\".$nipps[6]."'" .",". $nipps[7] .",". $nipps[8] .",". $nipps[9];

                    Yii::$app->sbccommon->execqry($qry);
                }//end if
            }//end for each lvl 2
        }//end for each
    }//end f

    private function generateGeneralAccessList($systype){
    //LIST / SET OF ACCESSES ON ATTRIBUTES TABLE UPON LOGIN (MODULES ONLY)
        //additional access for modules
        $sj_changediscuniverse= "";
        $so_changediscuniverse= "";
        $cm_changediscuniverse= "";

        switch ($this->companyConfig()) {
            case 'UNIVERSE':
                $stockgrplabel = "Division Masterfile";
                $partlabel = "Category Masterfile";
                $modellabel = "Generic Masterfile";
                $classlabel = "Classification List";
                $sj_changediscuniverse = "(3301,0,'Allow Change Discount  SJ','',0,'\\50220','\\502',0,'0',0)";
                $so_changediscuniverse = "(3302,0,'Allow Change Discount  SJ','',0,'\\50221','\\501',0,'0',0)";
                $cm_changediscuniverse = "(3303,0,'Allow Change Discount  SJ','',0,'\\50222','\\503',0,'0',0)";
            break;

            case 'MLCP':
                $stockgrplabel = "Length Masterfile";
                $partlabel = "Category Masterfile";
                $modellabel = "Generic Masterfile";
                $classlabel = "Classification List";
            break;
            
            default:
                $stockgrplabel = "Item Group List";
                $partlabel = "Part List";
                $modellabel = "Model List";
                $classlabel = "Item Class List";
            break;
        }//end switch

        //MASTERFILES
        $stockcard_access =["(11,0,'StockCard','',0,'\\102','\\1',0,'0',0)",
                            "(12,0,'Allow View Stockcard','SK',0,'\\10201','\\102',0,'0',0)",
                            "(13,0,'Allow Click Edit Button SK','',0,'\\10202','\\102',0,'0',0)",
                            "(14,0,'Allow Click New Button SK','',0,'\\10203','\\102',0,'0',0)",
                            "(15,0,'Allow Click Save Button SK','',0,'\\10204','\\102',0,'0',0)",
                            "(16,0,'Allow Click Change Barcode SK','',0,'\\10205','\\102',0,'0',0)",
                            "(17,0,'Allow Click Delete Button SK','',0,'\\10206','\\102',0,'0',0)",
                            "(18,0,'Allow Print Button SK','',0,'\\10207','\\102',0,'0',0)",
                            "(19,0,'Allow View SRP Button SK','',0,'\\10208','\\102',0,'0',0)"];
        $customer_access = ["(21,0,'Customer Ledger','',0,'\\103','\\1',0,'0',0)",
                            "(22,0,'Allow View Customer Ledger','CUSTOMER',0,'\\10301','\\103',0,'0',0)",
                            "(23,0,'Allow Click Edit Button CL','',0,'\\10302','\\103',0,'0',0)",
                            "(24,0,'Allow Click New Button CL','',0,'\\10303','\\103',0,'0',0)",
                            "(25,0,'Allow Click Save Button CL','',0,'\\10304','\\103',0,'0',0)",
                            "(26,0,'Allow Click Change Customer  Code CL','',0,'\\10305','\\103',0,'0',0)",
                            "(27,0,'Allow Click Delete Button CL','',0,'\\10306','\\103',0,'0',0)",
                            "(28,0,'Allow Click Print Button CL','',0,'\\10307','\\103',0,'0',0)",];
        $supplier_access = ["(31,0,'Supplier Ledger','',0,'\\104','\\1',0,'0',0)",
                            "(32,0,'Allow View Supplier Ledger','SU',0,'\\10401','\\104',0,'0',0)",
                            "(33,0,'Allow Click Edit Button SL','',0,'\\10402','\\104',0,'0',0)",
                            "(34,0,'Allow Click New Button SL','',0,'\\10403','\\104',0,'0',0)",
                            "(35,0,'Allow Click Save Button SL','',0,'\\10404','\\104',0,'0',0)",
                            "(36,0,'Allow Click Change Supplier Code SL','',0,'\\10405','\\104',0,'0',0)",
                            "(37,0,'Allow Click Delete  Button SL','',0,'\\10406','\\104',0,'0',0)",
                            "(38,0,'Allow Click Print Button SL','',0,'\\10407','\\104',0,'0',0)"];
        $agent_access =["(41,0,'Agent Ledger','',0,'\\105','\\1',0,'0',0)",
                        "(42,0,'Allow View Agent Ledger','AG',0,'\\10501','\\105',0,'0',0)",
                        "(43,0,'Allow Click Edit Button AL','',0,'\\10502','\\105',0,'0',0)",
                        "(44,0,'Allow Click New Button AL','',0,'\\10503','\\105',0,'0',0)",
                        "(45,0,'Allow Click Save Button AL','',0,'\\10504','\\105',0,'0',0)",
                        "(46,0,'Allow Click Change Agent Code  AL','',0,'\\10505','\\105',0,'0',0)",
                        "(47,0,'Allow Click Delete Button AL','',0,'\\10506','\\105',0,'0',0)",
                        "(48,0,'Allow Click Print Button AL','',0,'\\10507','\\105',0,'0',0)"];
        $warehouse_access =["(51,0,'Warehouse Ledger','',0,'\\106','\\1',0,'0',0)",
                            "(52,0,'Allow View Warehouse','WH',0,'\\10601','\\106',0,'0',0)",
                            "(53,0,'Allow Click Edit Button WL','',0,'\\10602','\\106',0,'0',0)",
                            "(54,0,'Allow Click New Button WL','',0,'\\10603','\\106',0,'0',0)",
                            "(55,0,'Allow Click Save Button WL','',0,'\\10604','\\106',0,'0',0)",
                            "(56,0,'Allow Click Change Warehouse Code  WL','',0,'\\10605','\\106',0,'0',0)",
                            "(57,0,'Allow Click Delete Button WL','',0,'\\10606','\\106',0,'0',0)",
                            "(58,0,'Allow Click Print Button WL','',0,'\\10607','\\106',0,'0',0)"];
        $coa_access=["(2,0,'Chart of Accounts','',0,'\\701','\\7',0,'0',0)",
                    "(3,0,'Allow View Chart of Accounts','COA',0,'\\70101','\\701',0,'0',0)",
                    "(4,0,'Allow Click Edit Button  COA','',0,'\\70102','\\701',0,'0',0)",
                    "(5,0,'Allow Click New Button COA','',0,'\\70103','\\701',0,'0',0)",
                    "(6,0,'Allow Click Save Button COA','',0,'\\70104','\\701',0,'0',0)",
                    "(7,0,'Allow Click Delete Button COA','',0,'\\70105','\\701',0,'0',0)",
                    "(8,0,'Allow Click Print Button COA','',0,'\\70106','\\701',0,'0',0)"];
        $mini_masterfiles=["(3159,1,'Brand Manager','*129',0,'\\110','\\1',0,0,0)",
                        "(852,1,'".$modellabel."','',0,'\\839','\\1',0,'0',0)",
                        "(853,1,'".$partlabel."','',0,'\\840','\\1',0,'0',0)",
                        "(3158,1,'".$classlabel."','*129',0,'\\111','\\1',0,'0',0)",
                        "(3160,1,'".$stockgrplabel."','*129',0,'\\112','\\1',0,'0',0)",
                        "(3199,1,'Cust/Supp Categories','*129',0,'\\113','\\1',0,'0',0)"];

        //PURCHASES
        $pr_access=["(618,0,'Purchase Requisition','',0,'\\405','\\4',0,'0',0)",
                    "(619,0,'Allow View Transaction PR','PR',0,'\\40501','\\405',0,'0',0)",
                    "(620,0,'Allow Click Edit Button PR','',0,'\\40502','\\405',0,'0',0)",
                    "(621,0,'Allow Click New Button PR','',0,'\\40503','\\405',0,'0',0)",
                    "(622,0,'Allow Click Save Button PR','',0,'\\40504','\\405',0,'0',0)",
                    "(623,0,'Allow Click Change Document#  PR','',0,'\\40505','\\405',0,'0',0)",
                    "(624,0,'Allow Click Delete Button PR','',0,'\\40506','\\405',0,'0',0)",
                    "(625,0,'Allow Click Print Button PR','',0,'\\40507','\\405',0,'0',0)",
                    "(626,0,'Allow Click Lock Button PR','',0,'\\40508','\\405',0,'0',0)",
                    "(627,0,'Allow Click UnLock Button PR','',0,'\\40509','\\405',0,'0',0)",
                    "(628,0,'Allow Change Amount PR','',0,'\\40510','\\405',0,'0',0)",
                    "(630,0,'Allow Click Post Button PR','',0,'\\40512','\\405',0,'0',0)",
                    "(631,0,'Allow Click UnPost  Button PR','',0,'\\40513','\\405',0,'0',0)",
                    "(814,1,'Allow Click Add Item PR','',0,'\\40514','\\405',0,'0',0)",
                    "(815,1,'Allow Click Edit Item PR','',0,'\\40515','\\405',0,'0',0)",
                    "(816,1,'Allow Click Delete Item PR','',0,'\\40516','\\405',0,'0',0)"];
        $po_access=["(62,0,'Purchase Order','',0,'\\401','\\4',0,'0',0)",
                    "(63,0,'Allow View Transaction PO','PO',0,'\\40101','\\401',0,'0',0)",
                    "(64,0,'Allow Click Edit Button PO','',0,'\\40102','\\401',0,'0',0)",
                    "(65,0,'Allow Click New Button PO','',0,'\\40103','\\401',0,'0',0)",
                    "(66,0,'Allow Click Save Button PO','',0,'\\40104','\\401',0,'0',0)",
                    "(67,0,'Allow Click Change Document#  PO','',0,'\\40105','\\401',0,'0',0)",
                    "(68,0,'Allow Click Delete Button PO','',0,'\\40106','\\401',0,'0',0)",
                    "(69,0,'Allow Click Print Button PO','',0,'\\40107','\\401',0,'0',0)",
                    "(70,0,'Allow Click Lock Button PO','',0,'\\40108','\\401',0,'0',0)",
                    "(71,0,'Allow Click UnLock Button PO','',0,'\\40109','\\401',0,'0',0)",
                    "(72,0,'Allow Change Amount PO','',0,'\\40110','\\401',0,'0',0)",
                    "(73,0,'Allow Click Post Button PO','',0,'\\40112','\\401',0,'0',0)",
                    "(74,0,'Allow Click UnPost  Button PO','',0,'\\40113','\\401',0,'0',0)",
                    "(808,1,'Allow Click Add Item PO','',0,'\\40114','\\401',0,'0',0)",
                    "(809,1,'Allow Click Edit Item PO','',0,'\\40115','\\401',0,'0',0)",
                    "(810,1,'Allow Click Delete Item PO','',0,'\\40116','\\401',0,'0',0)"];
        $rr_access=["(78,0,'Receiving Report','',0,'\\402','\\4',0,'0',0)",
                    "(79,0,'Allow View Transaction RR','RR',0,'\\40201','\\402',0,'0',0)",
                    "(80,0,'Allow Click Edit Button RR','',0,'\\40202','\\402',0,'0',0)",
                    "(81,0,'Allow Click New Button RR','',0,'\\40203','\\402',0,'0',0)",
                    "(82,0,'Allow Click Save Button RR','',0,'\\40204','\\402',0,'0',0)",
                    "(83,0,'Allow Click Change Document# RR','',0,'\\40205','\\402',0,'0',0)",
                    "(84,0,'Allow Click Delete Button RR','',0,'\\40206','\\402',0,'0',0)",
                    "(85,0,'Allow Click Print Button RR','',0,'\\40207','\\402',0,'0',0)",
                    "(86,0,'Allow Click Lock Button RR','',0,'\\40208','\\402',0,'0',0)",
                    "(87,0,'Allow Click UnLock Button RR','',0,'\\40209','\\402',0,'0',0)",
                    "(88,0,'Allow Click Post Button RR','',0,'\\40210','\\402',0,'0',0)",
                    "(89,0,'Allow Click UnPost Button RR','',0,'\\40211','\\402',0,'0',0)",
                    "(90,0,'Allow View Transaction accounting RR','',0,'\\40212','\\402',0,'0',0)",
                    "(91,0,'Allow Change Amount RR','',0,'\\40213','\\402',0,'0',0)",
                    "(811,1,'Allow Click Add Item RR','',0,'\\40214','\\402',0,'0',0)",
                    "(812,1,'Allow Click Edit Item RR','',0,'\\40215','\\402',0,'0',0)",
                    "(813,1,'Allow Click Delete Item RR','',0,'\\40216','\\402',0,'0',0)"];
        $dm_access=["(97,0,'Purchase Return','',0,'\\403','\\4',0,'0',0)",
                    "(98,0,'Allow View Transaction DM','DM',0,'\\40301','\\403',0,'0',0)",
                    "(99,0,'Allow Click Edit Button DM','',0,'\\40302','\\403',0,'0',0)",
                    "(100,0,'Allow Click New Button DM','',0,'\\40303','\\403',0,'0',0)",
                    "(101,0,'Allow Click Save Button DM','',0,'\\40304','\\403',0,'0',0)",
                    "(102,0,'Allow Click Change Document# DM','',0,'\\40305','\\403',0,'0',0)",
                    "(103,0,'Allow Click Delete Button DM','',0,'\\40306','\\403',0,'0',0)",
                    "(104,0,'Allow Click Print Button DM','',0,'\\40307','\\403',0,'0',0)",
                    "(105,0,'Allow Click Lock Button DM','',0,'\\40308','\\403',0,'0',0)",
                    "(106,0,'Allow Click UnLock Button DM','',0,'\\40309','\\403',0,'0',0)",
                    "(107,0,'Allow Click Post Button DM','',0,'\\40310','\\403',0,'0',0)",
                    "(108,0,'Allow Click UnPost Button DM','',0,'\\40311','\\403',0,'0',0)",
                    "(109,0,'Allow View Transaction accounting DM','',0,'\\40312','\\403',0,'0',0)",
                    "(110,0,'Allow Change Amount DM','',0,'\\40313','\\403',0,'0',0)",
                    "(820,1,'Allow Click Add Item DM','',0,'\\40314','\\403',0,'0',0)",
                    "(821,1,'Allow Click Edit Item DM','',0,'\\40315','\\403',0,'0',0)",
                    "(822,1,'Allow Click Delete Item DM','',0,'\\40316','\\403',0,'0',0)"];

        //SALES
        $so_access =["(151,0,'Sales Order','',0,'\\501','\\5',0,'0',0)",
                    "(152,0,'Allow View Transaction SO','SO',0,'\\50101','\\501',0,'0',0)",
                    "(153,0,'Allow Click Edit Button SO','',0,'\\50102','\\501',0,'0',0)",
                    "(154,0,'Allow Click New  Button SO','',0,'\\50103','\\501',0,'0',0)",
                    "(155,0,'Allow Click Save Button SO','',0,'\\50104','\\501',0,'0',0)",
                    "(156,0,'Allow Click Change Document#  SO','',0,'\\50105','\\501',0,'0',0)",
                    "(157,0,'Allow Click Delete Button SO','',0,'\\50106','\\501',0,'0',0)",
                    "(158,0,'Allow Click Print Button SO','',0,'\\50107','\\501',0,'0',0)",
                    "(159,0,'Allow Click Lock Button SO','',0,'\\50108','\\501',0,'0',0)",
                    "(160,0,'Allow Click UnLock Button SO','',0,'\\50109','\\501',0,'0',0)",
                    "(161,0,'Allow Change Amount  SO','',0,'\\50110','\\501',0,'0',0)",
                    $so_changediscuniverse,
                    "(162,0,'Allow Check Credit Limit SO','',0,'\\50111','\\501',0,'0',0)",
                    "(163,0,'Allow Click Post Button SO','',0,'\\50112','\\501',0,'0',0)",
                    "(164,0,'Allow Click UnPost  Button SO','',0,'\\50113','\\501',0,'0',0)",
                    "(805,1,'Allow Click Add Item SO','',0,'\\50114','\\501',0,'0',0)",
                    "(806,1,'Allow Click Edit Item SO','',0,'\\50115','\\501',0,'0',0)",
                    "(807,1,'Allow Click Delete Item SO','',0,'\\50116','\\501',0,'0',0)",];
        $sj_access=["(168,0,'Sales Journal','',0,'\\502','\\5',0,'0',0)",
                    "(169,0,'Allow View Transaction SJ','SI',0,'\\50201','\\502',0,'0',0)",
                    "(170,0,'Allow Click Edit Button SJ','',0,'\\50202','\\502',0,'0',0)",
                    "(171,0,'Allow Click New  Button SJ','',0,'\\50203','\\502',0,'0',0)",
                    "(172,0,'Allow Click Save Button SJ','',0,'\\50204','\\502',0,'0',0)",
                    "(173,0,'Allow Click Change Document#  SJ','',0,'\\50205','\\502',0,'0',0)",
                    "(174,0,'Allow Click Delete Button SJ','',0,'\\50206','\\502',0,'0',0)",
                    "(175,0,'Allow Click Print Button SJ','',0,'\\50207','\\502',0,'0',0)",
                    "(176,0,'Allow Click Lock Button SJ','',0,'\\50208','\\502',0,'0',0)",
                    "(177,0,'Allow Click UnLock Button SJ','',0,'\\50209','\\502',0,'0',0)",
                    "(178,0,'Allow Click Post Button SJ','',0,'\\50210','\\502',0,'0',0)",
                    "(179,0,'Allow Click UnPost  Button SJ','',0,'\\50211','\\502',0,'0',0)",
                    "(180,0,'Allow Change Amount  SJ','',0,'\\50213','\\502',0,'0',0)",
                    $sj_changediscuniverse,
                    "(181,0,'Allow Check Credit Limit SJ','',0,'\\50214','\\502',0,'0',0)",
                    "(182,0,'Allow SJ Amount Auto-Compute on UOM Change','',0,'\\50215','\\502',0,'0',0)",
                    "(183,0,'Allow View Transaction Accounting SJ','',0,'\\50216','\\502',0,'0',0)",
                    "(802,1,'Allow Click Add Item SJ','',0,'\\50217','\\502',0,'0',0)",
                    "(803,1,'Allow Click Edit Item SJ','',0,'\\50218','\\502',0,'0',0)",
                    "(804,1,'Allow Click Delete Item SJ','',0,'\\50219','\\502',0,'0',0)",];
        $cm_access=["(189,0,'Sales Return','',0,'\\503','\\5',0,'0',0)",
                    "(190,0,'Allow View Transaction SR','CM',0,'\\50301','\\503',0,'0',0)",
                    "(191,0,'Allow Click Edit Button SR','',0,'\\50302','\\503',0,'0',0)",
                    "(192,0,'Allow Click New  Button SR','',0,'\\50303','\\503',0,'0',0)",
                    "(193,0,'Allow Click Save  Button SR','',0,'\\50304','\\503',0,'0',0)",
                    "(194,0,'Allow Click Change Document#  SR','',0,'\\50305','\\503',0,'0',0)",
                    "(195,0,'Allow Click Delete Button SR','',0,'\\50306','\\503',0,'0',0)",
                    "(196,0,'Allow Click Print  Button SR','',0,'\\50307','\\503',0,'0',0)",
                    "(197,0,'Allow Click Lock Button SR','',0,'\\50308','\\503',0,'0',0)",
                    "(198,0,'Allow Click UnLock Button SR','',0,'\\50309','\\503',0,'0',0)",
                    "(199,0,'Allow Click Post Button SR','',0,'\\50310','\\503',0,'0',0)",
                    "(200,0,'Allow Click UnPost  Button SR','',0,'\\50311','\\503',0,'0',0)",
                    "(201,0,'Allow View Transaction Accounting SR','',0,'\\50312','\\503',0,'0',0)",
                    "(202,0,'Allow Change Amount SR','',0,'\\50313','\\503',0,'0',0)",
                    $cm_changediscuniverse,
                    "(817,1,'Allow Click Add Item SR','',0,'\\50314','\\503',0,'0',0)",
                    "(818,1,'Allow Click Edit Item SR','',0,'\\50315','\\503',0,'0',0)",
                    "(819,1,'Allow Click Delete Item SR','',0,'\\50316','\\503',0,'0',0)"];

        $mi_access=["(768,0,'Material Issuance','',0,'\\504','\\5',0,'0',0)",
                    "(769,0,'Allow View Transaction MI','MI',0,'\\50401','\\504',0,'0',0)",
                    "(770,0,'Allow Click Edit Button MI','MI',0,'\\50402','\\504',0,'0',0)",
                    "(771,0,'Allow Click New  Button MI','MI',0,'\\50403','\\504',0,'0',0)",
                    "(772,0,'Allow Click Save Button MI','MI',0,'\\50404','\\504',0,'0',0)",
                    "(773,0,'Allow Click Change Document#  MI','MI',0,'\\50405','\\504',0,'0',0)",
                    "(774,0,'Allow Click Delete Button MI','MI',0,'\\50406','\\504',0,'0',0)",
                    "(775,0,'Allow Click Print Button MI','MI',0,'\\50407','\\504',0,'0',0)",
                    "(776,0,'Allow Click Lock Button MI','MI',0,'\\50408','\\504',0,'0',0)",
                    "(777,0,'Allow Click UnLock Button MI','MI',0,'\\50409','\\504',0,'0',0)",
                    "(778,0,'Allow Click Post Button MI','MI',0,'\\50410','\\504',0,'0',0)",
                    "(779,0,'Allow Click UnPost  Button MI','MI',0,'\\50411','\\504',0,'0',0)",
                    "(780,0,'Allow Change Amount  MI','MI',0,'\\50413','\\504',0,'0',0)",
                    "(781,0,'Allow Check Credit Limit MI','MI',0,'\\50414','\\504',0,'0',0)",
                    "(782,0,'Allow SI Amount Auto-Compute on UOM Change','MI',0,'\\50415','\\504',0,'0',0)",
                    "(783,0,'Allow View Transaction Accounting MI','MI',0,'\\50416','\\504',0,'0',0)",
                    "(3292,1,'Allow Click Add Item MI','',0,'\\50417','\\504',0,'0',0)",
                    "(3293,1,'Allow Click Edit Item MI','',0,'\\50418','\\504',0,'0',0)",
                    "(3294,1,'Allow Click Delete Item MI','',0,'\\50419','\\504',0,'0',0)"];

        //INVENTORY
        $is_access=["(257,0,'Inventory Setup','',0,'\\601','\\6',0,'0',0)",
                    "(258,0,'Allow View Transaction IS','IS',0,'\\60101','\\601',0,'0',0)",
                    "(259,0,'Allow Click Edit Button  IS','',0,'\\60102','\\601',0,'0',0)",
                    "(260,0,'Allow Click New Button IS','',0,'\\60103','\\601',0,'0',0)",
                    "(261,0,'Allow Click Save Button IS','',0,'\\60104','\\601',0,'0',0)",
                    "(262,0,'Allow Click Change Document# IS','',0,'\\60105','\\601',0,'0',0)",
                    "(263,0,'Allow Click Delete Button IS','',0,'\\60106','\\601',0,'0',0)",
                    "(264,0,'Allow Click Print Button IS','',0,'\\60107','\\601',0,'0',0)",
                    "(265,0,'Allow Click Lock Button IS','',0,'\\60108','\\601',0,'0',0)",
                    "(266,0,'Allow Click UnLock Button IS','',0,'\\60109','\\601',0,'0',0)",
                    "(267,0,'Allow Click Post Button IS','',0,'\\60110','\\601',0,'0',0)",
                    "(268,0,'Allow Click UnPost Button IS','',0,'\\60111','\\601',0,'0',0)",
                    "(269,0,'Allow View Transaction Accounting IS','',0,'\\60112','\\601',0,'0',0)",
                    "(827,1,'Allow Click Add Item IS','',0,'\\60113','\\601',0,'0',0)",
                    "(828,1,'Allow Click Edit Item IS','',0,'\\60114','\\601',0,'0',0)",
                    "(829,1,'Allow Click Delete Item IS','',0,'\\60115','\\601',0,'0',0)",
                    "(830,1,'Allow Change Amount IS','',0,'\\60116','\\601',0,'0',0)"];
        $pc_access=["(275,0,'Physical Count','',0,'\\602','\\6',0,'0',0)",
                    "(276,0,'Allow View Transaction PC','',0,'\\60201','\\602',0,'0',0)",
                    "(277,0,'Allow Click Edit Button  PC','',0,'\\60202','\\602',0,'0',0)",
                    "(278,0,'Allow Click New Button PC','',0,'\\60203','\\602',0,'0',0)",
                    "(279,0,'Allow Click Save Button PC','',0,'\\60204','\\602',0,'0',0)",
                    "(280,0,'Allow Adjust PC','',0,'\\60205','\\602',0,'0',0)",
                    "(281,0,'Allow Click Delete Button PC','',0,'\\60206','\\602',0,'0',0)",
                    "(282,0,'Allow Click Print Button PC','',0,'\\60207','\\602',0,'0',0)",
                    "(283,0,'Allow Click Lock Button PC','',0,'\\60208','\\602',0,'0',0)",
                    "(284,0,'Allow Click UnLock Button PC','',0,'\\60209','\\602',0,'0',0)",
                    "(285,0,'Allow Click Post Button PC','',0,'\\60210','\\602',0,'0',0)",
                    "(286,0,'Allow Click UnPost Button PC','',0,'\\60211','\\602',0,'0',0)",
                    "(837,1,'Allow Click Delete Item PC','',0,'\\60214','\\602',0,'0',0)",
                    "(836,1,'Allow Click Edit Item PC','',0,'\\60213','\\602',0,'0',0)",
                    "(835,1,'Allow Click Add Item PC','',0,'\\60212','\\602',0,'0',0)",
                    "(838,1,'Allow Change Amount PC','',0,'\\60215','\\602',0,'0',0)"];
        $aj_access=["(290,0,'Inventory Adjustment','',0,'\\603','\\6',0,'0',0)",
                    "(291,0,'Allow View Transaction AJ','AJ',0,'\\60301','\\603',0,'0',0)",
                    "(292,0,'Allow Click Edit Button  AJ','',0,'\\60302','\\603',0,'0',0)",
                    "(293,0,'Allow Click New Button AJ','',0,'\\60303','\\603',0,'0',0)",
                    "(294,0,'Allow Click Save Button AJ','',0,'\\60304','\\603',0,'0',0)",
                    "(295,0,'Allow Click Change Document# AJ','',0,'\\60305','\\603',0,'0',0)",
                    "(296,0,'Allow Click Delete Button AJ','',0,'\\60306','\\603',0,'0',0)",
                    "(297,0,'Allow Click Print Button AJ','',0,'\\60307','\\603',0,'0',0)",
                    "(298,0,'Allow Click Lock Button AJ','',0,'\\60308','\\603',0,'0',0)",
                    "(299,0,'Allow Click UnLock Button AJ','',0,'\\60309','\\603',0,'0',0)",
                    "(300,0,'Allow Click Post Button AJ','',0,'\\60310','\\603',0,'0',0)",
                    "(301,0,'Allow Click UnPost Button AJ','',0,'\\60311','\\603',0,'0',0)",
                    "(302,0,'Allow View Transaction Accounting AJ','',0,'\\60312','\\603',0,'0',0)",
                    "(823,1,'Allow Click Add Item AJ','',0,'\\60313','\\603',0,'0',0)",
                    "(824,1,'Allow Click Edit Item AJ','',0,'\\60314','\\603',0,'0',0)",
                    "(825,1,'Allow Click Delete Item AJ','',0,'\\60315','\\603',0,'0',0)",
                    "(826,1,'Allow Change Amount AJ','',0,'\\60316','\\603',0,'0',0)"];
        $tr_access=["(784,0,'Stock Transfer Request','',0,'\\605','\\6',0,'0',0)",
                    "(785,0,'Allow View Transaction TR','TR',0,'\\60501','\\605',0,'0',0)",
                    "(786,0,'Allow Click Edit Button  TR','',0,'\\60502','\\605',0,'0',0)",
                    "(787,0,'Allow Click New Button TR','',0,'\\60503','\\605',0,'0',0)",
                    "(788,0,'Allow Click Save Button TR','',0,'\\60504','\\605',0,'0',0)",
                    "(789,0,'Allow Click Change Document# TR','',0,'\\60505','\\605',0,'0',0)",
                    "(790,0,'Allow Click Delete Button TR','',0,'\\60506','\\605',0,'0',0)",
                    "(791,0,'Allow Click Print Button TR','',0,'\\60507','\\605',0,'0',0)",
                    "(792,0,'Allow Click Lock Button TR','',0,'\\60508','\\605',0,'0',0)",
                    "(793,0,'Allow Click UnLock Button TR','',0,'\\60509','\\605',0,'0',0)",
                    "(794,0,'Allow Click Post Button TR','',0,'\\60510','\\605',0,'0',0)",
                    "(795,0,'Allow Click UnPost Button TR','',0,'\\60511','\\605',0,'0',0)",
                    "(839,1,'Allow Click Add Item TR','',0,'\\60512','\\605',0,'0',0)",
                    "(841,1,'Allow Click Delete Item TR','',0,'\\60514','\\605',0,'0',0)",
                    "(842,1,'Allow Change Amount TR','',0,'\\60515','\\605',0,'0',0)",
                    "(840,1,'Allow Click Edit Item TR','',0,'\\60513','\\605',0,'0',0)"];
        $ts_access=["(308,0,'Transfer Slip','',0,'\\604','\\6',0,'0',0)",
                    "(309,0,'Allow View Transaction TS','TS',0,'\\60401','\\604',0,'0',0)",
                    "(310,0,'Allow Click Edit Button  TS','',0,'\\60402','\\604',0,'0',0)",
                    "(311,0,'Allow Click New Button TS','',0,'\\60403','\\604',0,'0',0)",
                    "(312,0,'Allow Click Save Button TS','',0,'\\60404','\\604',0,'0',0)",
                    "(313,0,'Allow Click Change Document# TS','',0,'\\60405','\\604',0,'0',0)",
                    "(314,0,'Allow Click Delete Button TS','',0,'\\60406','\\604',0,'0',0)",
                    "(315,0,'Allow Click Print Button TS','',0,'\\60407','\\604',0,'0',0)",
                    "(316,0,'Allow Click Lock Button TS','',0,'\\60408','\\604',0,'0',0)",
                    "(317,0,'Allow Click UnLock Button TS','',0,'\\60409','\\604',0,'0',0)",
                    "(318,0,'Allow Click Post Button TS','',0,'\\60410','\\604',0,'0',0)",
                    "(319,0,'Allow Click UnPost Button TS','',0,'\\60411','\\604',0,'0',0)",
                    "(831,1,'Allow Click Add Item TS','',0,'\\60412','\\604',0,'0',0)",
                    "(832,1,'Allow Click Edit Item TS','',0,'\\60413','\\604',0,'0',0)",
                    "(833,1,'Allow Click Delete Item TS','',0,'\\60414','\\604',0,'0',0)",
                    "(834,1,'Allow Change Amount TS','',0,'\\60415','\\604',0,'0',0)"];

        //PAYABLES
        $ap_access=["(133,0,'Payable Setup','',0,'\\201','\\2',0,'0',0)",
                    "(134,0,'Allow View Transaction AP','AP',0,'\\20101','\\201',0,'0',0)",
                    "(135,0,'Allow Click Edit Button  AP','',0,'\\20102','\\201',0,'0',0)",
                    "(136,0,'Allow Click New Button AP','',0,'\\20103','\\201',0,'0',0)",
                    "(137,0,'Allow Click Save Button AP','',0,'\\20104','\\201',0,'0',0)",
                    "(138,0,'Allow Click Change Document# AP','',0,'\\20105','\\201',0,'0',0)",
                    "(139,0,'Allow Click Delete Button AP','',0,'\\20106','\\201',0,'0',0)",
                    "(140,0,'Allow Click Print Button AP','',0,'\\20107','\\201',0,'0',0)",
                    "(141,0,'Allow Click Lock Button AP','',0,'\\20108','\\201',0,'0',0)",
                    "(142,0,'Allow Click UnLock Button AP','',0,'\\20109','\\201',0,'0',0)",
                    "(143,0,'Allow Click Post Button AP','',0,'\\20110','\\201',0,'0',0)",
                    "(144,0,'Allow Click UnPost Button AP','',0,'\\20111','\\201',0,'0',0)"];
        $pv_access=["(370,0,'Accounts Payable Voucher','',0,'\\202','\\2',0,'0',0)",
                    "(371,0,'Allow View Transaction PV','APV',0,'\\20201','\\202',0,'0',0)",
                    "(372,0,'Allow Click Edit Button  PV','',0,'\\20202','\\202',0,'0',0)",
                    "(373,0,'Allow Click New Button PV','',0,'\\20203','\\202',0,'0',0)",
                    "(374,0,'Allow Click Save Button PV','',0,'\\20204','\\202',0,'0',0)",
                    "(375,0,'Allow Click Change Document# PV','',0,'\\20205','\\202',0,'0',0)",
                    "(376,0,'Allow Click Delete Button PV','',0,'\\20206','\\202',0,'0',0)",
                    "(377,0,'Allow Click Print Button PV','',0,'\\20207','\\202',0,'0',0)",
                    "(378,0,'Allow Click Lock Button PV','',0,'\\20208','\\202',0,'0',0)",
                    "(379,0,'Allow Click UnLock Button PV','',0,'\\20209','\\202',0,'0',0)",
                    "(380,0,'Allow Click Post Button PV','',0,'\\20210','\\202',0,'0',0)",
                    "(381,0,'Allow Click UnPost Button PV','',0,'\\20211','\\202',0,'0',0)"];
        $cv_access=["(116,0,'Cash/Check Voucher','',0,'\\203','\\2',0,'0',0)",
                    "(117,0,'Allow View Transaction CV','CV',0,'\\20301','\\203',0,'0',0)",
                    "(118,0,'Allow Click Edit Button  CV','',0,'\\20302','\\203',0,'0',0)",
                    "(119,0,'Allow Click New Button CV','',0,'\\20303','\\203',0,'0',0)",
                    "(120,0,'Allow Click Save Button CV','',0,'\\20304','\\203',0,'0',0)",
                    "(121,0,'Allow Click Change Document# CV','',0,'\\20305','\\203',0,'0',0)",
                    "(122,0,'Allow Click Delete Button CV','',0,'\\20306','\\203',0,'0',0)",
                    "(123,0,'Allow Click Print Button CV','',0,'\\20307','\\203',0,'0',0)",
                    "(124,0,'Allow Click Lock Button CV','',0,'\\20308','\\203',0,'0',0)",
                    "(125,0,'Allow Click UnLock Button CV','',0,'\\20309','\\203',0,'0',0)",
                    "(126,0,'Allow Click Post Button CV','',0,'\\20310','\\203',0,'0',0)",
                    "(127,0,'Allow Click UnPost Button CV','',0,'\\20311','\\203',0,'0',0)"];

        //RECEIVABLES
        $ar_access=["(239,0,'Receivable Setup','',0,'\\301','\\3',0,'0',0)",
                    "(240,0,'Allow View Transaction RS','AR',0,'\\30101','\\301',0,'0',0)",
                    "(241,0,'Allow Click Edit Button  RS','',0,'\\30102','\\301',0,'0',0)",
                    "(242,0,'Allow Click New Button RS','',0,'\\30103','\\301',0,'0',0)",
                    "(243,0,'Allow Click Save Button RS','',0,'\\30104','\\301',0,'0',0)",
                    "(244,0,'Allow Click Change Document# RS','',0,'\\30105','\\301',0,'0',0)",
                    "(245,0,'Allow Click Delete Button RS','',0,'\\30106','\\301',0,'0',0)",
                    "(246,0,'Allow Click Print Button RS','',0,'\\30107','\\301',0,'0',0)",
                    "(247,0,'Allow Click Lock Button RS','',0,'\\30108','\\301',0,'0',0)",
                    "(248,0,'Allow Click UnLock Button RS','',0,'\\30109','\\301',0,'0',0)",
                    "(249,0,'Allow Click Post Button RS','',0,'\\30110','\\301',0,'0',0)",
                    "(250,0,'Allow Click UnPost Button RS','',0,'\\30111','\\301',0,'0',0)"];
        $kr_access=["(208,0,'Counter Receipt','',0,'\\302','\\3',0,'0',0)",
                    "(209,0,'Allow View Transaction KR ','KR',0,'\\30201','\\302',0,'0',0)",
                    "(210,0,'Allow Click Edit Button  KR ','',0,'\\30202','\\302',0,'0',0)",
                    "(211,0,'Allow Click New Button KR ','',0,'\\30203','\\302',0,'0',0)",
                    "(212,0,'Allow Click Save Button KR ','',0,'\\30204','\\302',0,'0',0)",
                    "(213,0,'Allow Click Change Document# KR ','',0,'\\30205','\\302',0,'0',0)",
                    "(214,0,'Allow Click Delete Button KR ','',0,'\\30206','\\302',0,'0',0)",
                    "(215,0,'Allow Click Print Button KR ','',0,'\\30207','\\302',0,'0',0)",
                    "(216,0,'Allow Click Lock Button KR ','',0,'\\30208','\\302',0,'0',0)",
                    "(217,0,'Allow Click UnLock Button KR ','',0,'\\30209','\\302',0,'0',0)",
                    "(218,0,'Allow Click Post Button KR ','',0,'\\30210','\\302',0,'0',0)",
                    "(219,0,'Allow Click UnPost Button KR ','',0,'\\30211','\\302',0,'0',0)"];
        $cr_access=["(223,0,'Received Payment','',0,'\\303','\\3',0,'0',0)",
                    "(224,0,'Allow View Transaction CR ','CR',0,'\\30301','\\303',0,'0',0)",
                    "(225,0,'Allow Click Edit Button  CR ','',0,'\\30302','\\303',0,'0',0)",
                    "(226,0,'Allow Click New Button CR ','',0,'\\30303','\\303',0,'0',0)",
                    "(227,0,'Allow Click Save Button CR ','',0,'\\30304','\\303',0,'0',0)",
                    "(228,0,'Allow Click Change Document# CR ','',0,'\\30305','\\303',0,'0',0)",
                    "(229,0,'Allow Click Delete Button CR ','',0,'\\30306','\\303',0,'0',0)",
                    "(230,0,'Allow Click Print Button CR ','',0,'\\30307','\\303',0,'0',0)",
                    "(231,0,'Allow Click Lock Button CR ','',0,'\\30308','\\303',0,'0',0)",
                    "(232,0,'Allow Click UnLock Button CR ','',0,'\\30309','\\303',0,'0',0)",
                    "(233,0,'Allow Click Post Button CR ','',0,'\\30310','\\303',0,'0',0)",
                    "(234,0,'Allow Click UnPost Button CR ','',0,'\\30311','\\303',0,'0',0)"];
        
        //ACCOUNTING
        $ds_access=["(326,0,'Deposit Slip','',0,'\\304','\\3',0,'0',0)",
                    "(327,0,'Allow View Transaction DS','DS',0,'\\30401','\\304',0,'0',0)",
                    "(328,0,'Allow Click Edit Button  DS','',0,'\\30402','\\304',0,'0',0)",
                    "(329,0,'Allow Click New Button DS','',0,'\\30403','\\304',0,'0',0)",
                    "(330,0,'Allow Click Save Button DS','',0,'\\30404','\\304',0,'0',0)",
                    "(331,0,'Allow Click Change Document# DS','',0,'\\30405','\\304',0,'0',0)",
                    "(332,0,'Allow Click Delete Button DS','',0,'\\30406','\\304',0,'0',0)",
                    "(333,0,'Allow Click Print Button DS','',0,'\\30407','\\304',0,'0',0)",
                    "(334,0,'Allow Click Lock Button DS','',0,'\\30408','\\304',0,'0',0)",
                    "(335,0,'Allow Click UnLock Button DS','',0,'\\30409','\\304',0,'0',0)",
                    "(336,0,'Allow Click Post Button DS','',0,'\\30410','\\304',0,'0',0)",
                    "(337,0,'Allow Click UnPost Button DS','',0,'\\30411','\\304',0,'0',0)"];
        $gj_access=["(343,0,'General Journal','',0,'\\702','\\7',0,'0',0)",
                    "(344,0,'Allow View Transaction GJ','GJ',0,'\\70201','\\702',0,'0',0)",
                    "(345,0,'Allow Click Edit Button  GJ','',0,'\\70202','\\702',0,'0',0)",
                    "(346,0,'Allow Click New Button GJ','',0,'\\70203','\\702',0,'0',0)",
                    "(347,0,'Allow Click Save Button GJ','',0,'\\70204','\\702',0,'0',0)",
                    "(348,0,'Allow Click Change Document# GJ','',0,'\\70205','\\702',0,'0',0)",
                    "(349,0,'Allow Click Delete Button GJ','',0,'\\70206','\\702',0,'0',0)",
                    "(350,0,'Allow Click Print Button GJ','',0,'\\70207','\\702',0,'0',0)",
                    "(351,0,'Allow Click Lock Button GJ','',0,'\\70208','\\702',0,'0',0)",
                    "(352,0,'Allow Click UnLock Button GJ','',0,'\\70209','\\702',0,'0',0)",
                    "(353,0,'Allow Click Post Button GJ','',0,'\\70210','\\702',0,'0',0)",
                    "(354,0,'Allow Click UnPost Button GJ','',0,'\\70211','\\702',0,'0',0)"];
        
        //UTILITIES/SYSTEM SETUPS
        $general_sysaccess=["(767,1,'Themer Customizer','',0,'\\827','\\8',0,'0',0)",
                            "(796,1,'Product Inquiry','',0,'\\805','\\8',0,'0',0)",
                            "(598,0,'Terms','',0,'\\811','\\8',0,'0',0)",
                            "(599,0,'Document Prefix','',0,'\\812','\\8',0,'0',0)",
                            "(766,1,'Manage Announcement','',0,'\\826','\\8',0,'0',0)",
                            "(764,1,'Scheduler','',0,'\\824','\\8',0,'0',0)",
                            "(3138,1,'Cost Center Setup','',0,'\\849','\\8',0,'0',0)",
                            "(898,1,'Allow View CONFI','',0,'\\830','\\8',0,'0',0)",
                            "(797,1,'Branch Access','',0,'\\806','\\8',0,'0',0)",
                            "(3152,1,'Quick Collection Utility','*129',0,'\\854','\\8',0,'0',0)",
                            "(3151,1,'Collection Type Setup','*129',0,'\\853','\\1',0,'0',0)",
                            "(632,0,'Change Item','',0,'\\813','\\8',0,'0',0)",
                            "(633,0,'Allow View Audit Trail','',0,'\\814','\\8',0,'0',0)",
                            //WTODO: [KIM][2019.12.03][add unposted transactions]
                            "(652,0,'Unposted Transactions','',0,'\\817','\\8',0,'0',0)",         
        ];
                            
        $frontrelated_sysaccess=["(361,0,'Administrator','',0,'\\801','\\8',0,'0',0)",
                            "(758,1,'Change Frontend Logo','',0,'\\818','\\8',0,'0',0)",
                            "(759,1,'Order Manager','',0,'\\819','\\8',0,'0',0)",
                            "(760,1,'Banner Manager','',0,'\\820','\\8',0,'0',0)",
                            "(761,1,'Lane Manager','',0,'\\821','\\8',0,'0',0)",
                            "(762,1,'Highlight Manager','',0,'\\822','\\8',0,'0',0)",
                            "(763,1,'DOD Manager','',0,'\\823','\\8',0,'0',0)",
                            "(3149,1,'Frontend Site Details','',0,'\\850','\\8',0,'0',0)",
                            "(363,0,'Frontend Logs','',0,'\\803','\\8',0,'0',0)"];
        $inventoryrelated_sysaccess=["(368,0,'Allow View Transaction Cost','',0,'\\808','\\8',0,'0',0)"];
        $accountingrelated_sysaccess=["(367,0,'Set System Lockdate','',0,'\\807','\\8',0,'0',0)",
                                    "(3157,1,'EWT Setup','*129',0,'\\856','\\8',0,'0',0)"];

        $reports_sysaccess=[];

        switch ($systype) {
            case 'AMS':
                 $moduleparent = [
                    //MASTERFILES ACCESS
                    "(1,0,'MASTER FILE','',0,'\\1','\\',0,'0',0)",
                    "(547,0,'PAYABLE','',0,'\\2','\\',0,'0',0)",
                    //RECEIVABLES ACCESS
                    "(546,0,'RECEIVABLES','',0,'\\3','\\',0,'0',0)",
                    //ACCOUNTING ACCESS
                    "(548,0,'ACCOUNTING','',0,'\\7','\\',0,'0',0)",
                    //SYSTEM UTILITIES
                    "(360,0,'SYSTEM','',0,'\\8','\\',0,'0',0)",
                    "(3248,0,'DASHBOARD','',0,'\\10','\\',0,'0',0)",];

                $accesslist = [$customer_access,$supplier_access,$agent_access,$coa_access,
                               $ap_access,$pv_access,$cv_access,
                               $ar_access,$cr_access,
                               $gj_access,
                               $general_sysaccess,$accountingrelated_sysaccess];
            break;
            
            case 'AIMS':
                $productionparent = "";
                
                switch ($this->companyConfig()) {
                    case 'MLCP':
                        $productionparent = "(3265,0,'PRODUCTION','',0,'\\14','\\',0,'0',0)";
                    break;
                }//end switch

                $moduleparent = [
                    //MASTERFILES ACCESS
                    "(1,0,'MASTER FILE','',0,'\\1','\\',0,'0',0)",
                    //PURCCHASES ACCESS
                    "(61,0,'PURCHASES','',0,'\\4','\\',0,'0',0)",
                    //SALES ACCESS
                    "(150,0,'SALES','',0,'\\5','\\',0,'0',0)",
                    //INVENTORY ACCESS
                    "(556,0,'INVENTORY','',0,'\\6','\\',0,'0',0)",
                    $productionparent,
                    //PAYABLES ACCESS
                    "(547,0,'PAYABLE','',0,'\\2','\\',0,'0',0)",
                    //RECEIVABLES ACCESS
                    "(546,0,'RECEIVABLES','',0,'\\3','\\',0,'0',0)",
                    //ACCOUNTING ACCESS
                    "(548,0,'ACCOUNTING','',0,'\\7','\\',0,'0',0)",
                    //SYSTEM UTILITIESo
                    "(360,0,'SYSTEM','',0,'\\8','\\',0,'0',0)",
                    "(3248,0,'DASHBOARD','',0,'\\10','\\',0,'0',0)",];

                switch ($this->companyConfig()) {
                    case 'UNIVERSE':
                        $accesslist=[$stockcard_access,$customer_access,$supplier_access,$agent_access,$warehouse_access,$coa_access,$mini_masterfiles,
                                    $pr_access,$po_access,$rr_access,$dm_access,
                                    $so_access,$sj_access,$cm_access,$mi_access,
                                    $is_access,$tr_access,$ts_access,$pc_access,$aj_access,
                                    $ar_access,$cr_access,$kr_access,
                                    $ap_access,$pv_access,$cv_access,
                                    $gj_access,$ds_access,
                                    $general_sysaccess,$inventoryrelated_sysaccess,$accountingrelated_sysaccess];
                    break;

                    case 'MLCP':
                        $accesslist=[$stockcard_access,$customer_access,$supplier_access,$agent_access,$warehouse_access,$coa_access,$mini_masterfiles,
                                    $pr_access,$po_access,$rr_access,$dm_access,
                                    $so_access,$sj_access,$mi_access,$cm_access,
                                    $is_access,$tr_access,$ts_access,$pc_access,$aj_access,
                                    $ar_access,$cr_access,$kr_access,
                                    $ap_access,$pv_access,$cv_access,
                                    $gj_access,$ds_access,
                                    $general_sysaccess,$inventoryrelated_sysaccess,$accountingrelated_sysaccess];
                    break;

                    default:
                        $accesslist=[$stockcard_access,$customer_access,$supplier_access,$agent_access,$warehouse_access,$coa_access,$mini_masterfiles,
                                    $pr_access,$po_access,$rr_access,$dm_access,
                                    $so_access,$sj_access,$cm_access,
                                    $is_access,$tr_access,$ts_access,$pc_access,$aj_access,
                                    $ar_access,$cr_access,$kr_access,
                                    $ap_access,$pv_access,$cv_access,
                                    $gj_access,$ds_access,
                                    $general_sysaccess,$inventoryrelated_sysaccess,$accountingrelated_sysaccess];
                    break;
                }//end switch
            break;

            case 'MIS':
                $moduleparent = [
                    //MASTERFILES ACCESS
                    "(1,0,'MASTER FILE','',0,'\\1','\\',0,'0',0)",
                    //PURCCHASES ACCESS
                    "(61,0,'PURCHASES','',0,'\\4','\\',0,'0',0)",
                    //SALES ACCESS
                    "(150,0,'SALES','',0,'\\5','\\',0,'0',0)",
                    //INVENTORY ACCESS
                    "(556,0,'INVENTORY','',0,'\\6','\\',0,'0',0)",
                    //SYSTEM UTILITIES
                    "(360,0,'SYSTEM','',0,'\\8','\\',0,'0',0)",
                    "(3248,0,'DASHBOARD','',0,'\\10','\\',0,'0',0)",];

                $accesslist=[$stockcard_access,$customer_access,$supplier_access,$agent_access,$warehouse_access,$coa_access,$mini_masterfiles,
                            $pr_access,$po_access,$rr_access,$dm_access,
                            $so_access,$sj_access,$cm_access,
                            $is_access,$tr_access,$ts_access,$pc_access,$aj_access,
                            $kr_access,
                            $general_sysaccess,$inventoryrelated_sysaccess];
            break;
        }//end switch

        if($this->enablePOSModules()){
            switch ($this->POSModulesSetting()) {
                case 'QSR':
                    $posrelated_masterfile=["(3153,1,'Manage Item','*129',0,'\\107','\\1',0,'0',0)",
                                            "(3155,1,'Branch Masterfile','*129',0,'\\109','\\1',0,'0',0)"];
                break;

                case 'FINEDINE':
                    $posrelated_masterfile=["(3153,1,'Manage Item','*129',0,'\\107','\\1',0,'0',0)",
                                            "(3154,1,'Table Masterfile','*129',0,'\\108','\\1',0,'0',0)",
                                            "(3155,1,'Branch Masterfile','*129',0,'\\109','\\1',0,'0',0)"];
                break;

                case 'RETAIL':
                    $posrelated_masterfile=["(3155,1,'Branch Masterfile','*129',0,'\\109','\\1',0,'0',0)"];
                break;
            }//end switch      

            array_push($accesslist,$posrelated_masterfile);  
        }//end if

        
        return ['accesslist'=>$accesslist,'accessparents'=>$moduleparent];
    }//end f

    private function generateReportList($systype){
    //GENERATES REPORT MENUS AND ATTRIBUTES GENERAL AND MODIFIED.
    //NOTE: ADD YOUR GENERAL / STANDARD REPORT ATTRIBUTES AND MENU ON 
    //ReportAccessList() and ReportsMenuList()
    //for MODIFIED REPORTS AND ITS ATTRIBUTES PLEASE ADD IT ON
    //ReportModifiedAccessList() AND ReportsModifiedMenuList()

        try {
            //REPORT PARENT MENUS
            $qryparent = "insert into `attributes` 
                        (`attribute`,`keyid`,`description`,`alias`,`allowed`,`code`,`parent`,`isexpanded`,`icon`,`parentid`) 
                        values (3000,0,'REPORTS','',0,'\\\\9','\\\\',0,'0',0)";
            Yii::$app->sbccommon->execqry($qryparent);
            $generalattr = $this->ReportAccessList($systype);
            $generalmenu = $this->ReportsMenuList($systype);

            foreach ($generalattr as $key => $value) {            
                if($value != ""){
                    $nipps = explode(',', $value);
                    $nipps[5] = str_replace("'", "", $nipps[5]);
                    $nipps[6] = str_replace("'", "", $nipps[6]);
                    
                    $qry = "insert into `attributes` 
                            (`attribute`,`keyid`,`description`,`alias`,`allowed`,`code`,`parent`,`isexpanded`,`icon`,`parentid`) 
                            values " . $nipps[0] .",". $nipps[1] .",". $nipps[2] .",". $nipps[3] .",". $nipps[4] .",". 
                            "'\\".$nipps[5]."'" .",". "'\\".$nipps[6]."'" .",". $nipps[7] .",". $nipps[8] .",". $nipps[9];

                    Yii::$app->sbccommon->execqry($qry);
                }//end if
            }//end if

            $truncator = "truncate menu";
            Yii::$app->sbccommon->execqry($truncator);
            foreach ($generalmenu as $key => $value) {      
                if($value != ""){      
                    $nipps = explode(',', $value);
                    $nipps[1] = str_replace("'", "", $nipps[1]);
                    $nipps[9] = str_replace("'", "", $nipps[9]);
                    
                    $qry = "insert into `menu` 
                            (`menu`,`parent`,`title`,`alias`,`icon`,`isexpanded`,`seq`,`isok`,`description`,`code`,`attribute`,`ismodified`) 
                            values " . $nipps[0] .",". "'\\".$nipps[1]."'" .",". $nipps[2] .",". $nipps[3] .",". $nipps[4] .",". 
                            $nipps[5] . "," . $nipps[6] . "," . $nipps[7] .",". $nipps[8] .",". "'\\".$nipps[9]."'" . "," . $nipps[10] . "," . $nipps[11];
                    Yii::$app->sbccommon->execqry($qry);
                }//end if
            }//end each

            $modattr = $this->ReportModifiedAccessList($systype);
            $modmenu = $this->ReportsModifiedMenuList($systype);
            
            if(!empty($modattr)){
                foreach ($modattr as $key => $value) {  
                    if($value != ""){                
                        $nipps = explode(',', $value);
                        $nipps[5] = str_replace("'", "", $nipps[5]);
                        $nipps[6] = str_replace("'", "", $nipps[6]);
                        
                        $qry = "insert into `attributes` 
                                (`attribute`,`keyid`,`description`,`alias`,`allowed`,`code`,`parent`,`isexpanded`,`icon`,`parentid`) 
                                values " . $nipps[0] .",". $nipps[1] .",". $nipps[2] .",". $nipps[3] .",". $nipps[4] .",". 
                                "'\\".$nipps[5]."'" .",". "'\\".$nipps[6]."'" .",". $nipps[7] .",". $nipps[8] .",". $nipps[9];

                        Yii::$app->sbccommon->execqry($qry);
                    }//end if
                }//end each
            }//end if

            if(!empty($modmenu)){
                foreach ($modmenu as $key => $value) { 
                    if($value != ""){      
                        $nipps = explode(',', $value);
                        $nipps[1] = str_replace("'", "", $nipps[1]);
                        $nipps[9] = str_replace("'", "", $nipps[9]);
                        
                        $qry = "insert into `menu` 
                                (`menu`,`parent`,`title`,`alias`,`icon`,`isexpanded`,`seq`,`isok`,`description`,`code`,`attribute`,`ismodified`) 
                                values " . $nipps[0] .",". "'\\".$nipps[1]."'" .",". $nipps[2] .",". $nipps[3] .",". $nipps[4] .",". 
                                $nipps[5] . "," . $nipps[6] . "," . $nipps[7] .",". $nipps[8] .",". "'\\".$nipps[9]."'" . "," . $nipps[10] . "," . $nipps[11];

                        /*echo $qry . '<br>';*/
                        Yii::$app->sbccommon->execqry($qry);
                    }//end if
                }//end each
            }//end if            
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end f

    private function ReportModifiedAccessList($systype){
    //NOTE: PLEASE MODIFY SYSTYPE FILTER 
    //IF THE CONTENT NEEDS TO BE FILTERED BETWEEN DIFFERENT POS PLATFORMS
    //AND DIFFERENT AIMS CLIENTS - jaoski 11/9/2018 5:37:35 PM
        switch ($this->companyConfig()) {
            case 'UNIVERSE':
                $reports_sysaccess=[
                    "(3087,1,'Price List','*129',0,'\\90413','\\904',0,'',0)",
                    "(3165,1,'Supplier Price List','',0,'\\90414','\\904',0,'',0)",
                    "(3166,1,'Quantity On Hand','',0,'\\90415','\\904',0,'',0)",
                    "(3167,1,'Inventory Retail Market Value','',0,'\\90416','\\904',0,'',0)",
                    "(3168,1,'Expiry Report','',0,'\\90417','\\904',0,'',0)",
                    "(3088,1,'Physical Inventory Sheet','*129',0,'\\90418','\\904',0,'',0)",
                    "(3169,1,'Schedule of Inventory (Average Cost)','',0,'\\90419','\\904',0,'',0)",
                    "(3170,1,'Schedule of Inventory (FIFO)','',0,'\\90420','\\904',0,'',0)",
                    "(3171,1,'Inventory Movement Report','*129',0,'\\90421','\\904',0,'',0)",
                    "(3172,1,'Sales Summary Per Principal/Division','',0,'\\90422','\\904',0,'',0)",
                    "(3173,1,'Comparative Report - Sales Qty VS Qty On Hand','',0,'\\90423','\\904',0,'',0)",
                    "(3174,1,'Top Performing Category','',0,'\\90424','\\904',0,'',0)",
                    "(3175,1,'Top Performing Classification','',0,'\\90426','\\904',0,'',0)",
                    "(3176,1,'Top Performing Division','',0,'\\90427','\\904',0,'',0)",
                    "(3177,1,'Top Performing Principal','',0,'\\90428','\\904',0,'',0)",
                    "(3178,1,'Purchase Summary Per Supplier/Principal','',0,'\\90429','\\904',0,'',0)",
                    "(3179,1,'Purchase Summary Per Principal/Division','',0,'\\90430','\\904',0,'',0)",
                    "(3180,1,'Purchase Summary Per Principal/Supplier','',0,'\\90431','\\904',0,'',0)",
                    "(3181,1,'Top Performing Customer','',0,'\\90520','\\905',0,'',0)",
                    "(3182,1,'Top Performing Sales Agent','',0,'\\90704','\\907',0,'',0)",
                    "(3304,1,'Sales Summary (Universe)','',0,'\\90432','\\904',0,'',0)",
                    "(3390,1,'Top Performing Item','',0,'\\90437','\\904',0,'',0)",
                    "(3391,1,'Sales Summary per Vat Type','',0,'\\90517','\\905',0,'',0)",
                    "(3306,1,'Allow Access View Movement','',0,'\\10209','\\102',0,'',0)",
                    "(4000,1,'Login Attempts Report','',0,'\\90802','\\908',0,'0',0)",
                    "(4002,1,'Comparative Report - Inventory per Location','',0,'\\90433','\\904',0,'0',0)",
                    "(4003,1,'Detailed Sales - Transaction Report','',0,'\\90525','\\905',0,'0',0)",
                    "(4004,1,'Detailed Purchases - Transaction Report','',0,'\\\90611','\\906',0,'0',0)",
                    "(4005,1,'Distribution Report (FDA)','',0,'\\\90439','\\904',0,'0',0)"
                ];
            break;

            case 'GALANG':
                $reports_sysaccess=[
                    "(3166,1,'Quantity On Hand','',0,'\\90415','\\904',0,'',0)",
                    "(3170,1,'Schedule of Inventory (FIFO)','',0,'\\90420','\\904',0,'',0)",                    
                    "(3171,1,'Inventory Movement Report','*129',0,'\\90421','\\904',0,'',0)",
                ];
            break;

            case 'TENPLUS':
                $reports_sysaccess=["(3181,1,'Customer Sales Per Collection','',0,'\\90516','\\905',0,'',0)"];
            break;

            case 'SBC':
                $reports_sysaccess=["(3251,1,'Receivables vs Collection','',0,'\\90521','\\905',0,'',0)",
                                    "(3252,1,'Sales vs Collection','',0,'\\90522','\\905',0,'',0)",
                                    "(3253,1,'Commission Report','',0,'\\90523','\\905',0,'',0)",
                                    "(3254,1,'Event Listing','',0,'\\90524','\\905',0,'',0)"];
            break;

            case 'FHI':
                $reports_sysaccess=["(3163,1,'PO Listing','',0,'\\9090105','\\909',0,'',0)",
                                    "(3164,1,'Unserved PO','',0,'\\9090106','\\909',0,'',0)",
                                    "(3165,1,'Aging Report Per Salesman','',0,'\\90703','\\907',0,0,0)",
                                    "(3166,1,'Sales Report Per Agent','',0,'\\90704','\\907',0,0,0)"];
            break;

            case 'MLCP':
                $reports_sysaccess=["(3267,0,'Product Listing','',0,'\\91001','\\910',0,'0',0)",
                                    "(3268,0,'Rate Listing','',0,'\\91002','\\910',0,'0',0)",
                                    "(3269,0,'Product Listing per Material','',0,'\\91003','\\910',0,'0',0)",
                                    "(3170,1,'Schedule of Inventory (FIFO)','',0,'\\90420','\\904',0,'',0)",
                                    //WTODO: [KIM][2019.09.30][add inventory checksheet attributes]
                                    "(3270,1,'Inventory Checksheet','',0,'\\90413','\\904',0,0,0)",
                                    //WTODO: [KIM][2019.10.03][add unclosed job order report]
                                    "(3271,1,'Unclosed Job Order Report','',0,'\\90414','\\904',0,0,0)",
                                     //WTODO: [KIM][2019.10.03][add partially served job order]
                                    "(3272,1,'Partially Served Job Order','',0,'\90415','\\904',0,0,0)",
                                    //WTODO: [KIM][2019.10.03][job order history]
                                    "(3273,1,'Job Order History','',0,'\90416','\\904',0,0,0)",
                                    //WTODO: [KIM][2019.11.11][product information sheet]
                                    "(3295,0,'Product Information Sheet','',0,'\\91004','\\910',0,0,0)",
                                    //WTODO: [KIM][2019.11.28][job order listing]
                                    "(3296,0,'Job Order Listing','',0,'\\90520','\\905',0,0,0)",
                                    //WTODO: [KIM][2019.12.09][unserved job order report]
                                    "(3299,1,'Unserved Job Order Report','',0,'\\90417','\\904',0,0,0)",
                                    //WTODO: [KIM][2019.12.09][payable to customer report]
                                    "(3300,1,'Payable to Customer Report','',0,'\\90521','\\905',0,0,0)"
                                ];
            break;

            default:
                $reports_sysaccess=[];
            break;
        }//end switch

        return $reports_sysaccess;
    }//end f

    private function ReportsModifiedMenuList($systype){
    //NOTE: PLEASE MODIFY SYSTYPE FILTER 
    //IF THE CONTENT NEEDS TO BE FILTERED BETWEEN DIFFERENT POS PLATFORMS
    //AND DIFFERENT AIMS CLIENTS - jaoski 11/9/2018 5:37:35 PM
        switch ($this->companyconfig()) {
            case 'UNIVERSE':
                $report_sysmenu=[
                    "('','\\904','','','',0,1,0,'Price List','\\90413',3087,'0')",
                    "('','\\904','','','',0,1,0,'Supplier Price List','\\90414',3165,'0')",
                    "('','\\904','','','',0,1,0,'Quantity On Hand','\\90415',3166,'1')",
                    "('','\\904','','','',0,1,0,'Inventory Retail Market Value','\\90416',3167,'0')",
                    "('','\\904','','','',0,1,0,'Expiry Report','\\90417',3168,'0')",
                    "('','\\904','','','',0,1,0,'Physical Inventory Sheet','\\90418',3088,'0')",
                    "('','\\904','','','',0,1,0,'Schedule of Inventory (Average Cost)','\\90419',3169,'0')",
                    "('','\\904','','','',0,1,0,'Schedule of Inventory (FIFO)','\\90420',3170,'0')",
                    "('','\\904','','','',0,1,0,'Inventory Movement Report','\\90421',3171,'0')",
                    "('','\\904','','','',0,1,0,'Sales Summary Per Principal/Division','\\90422',3172,'0')",
                    "('','\\904','','','',0,1,0,'Comparative Report - Sales Qty VS Qty On Hand','\\90423',3173,'0')",
                    "('','\\904','','','',0,1,0,'Top Performing Category','\\90424',3174,'0')",
                    "('','\\904','','','',0,1,0,'Top Performing Classification','\\90426',3175,'0')",
                    "('','\\904','','','',0,1,0,'Top Performing Division','\\90427',3176,'0')",
                    "('','\\904','','','',0,1,0,'Top Performing Principal','\\90428',3177,'0')",
                    "('','\\904','','','',0,1,0,'Purchase Summary Per Supplier/Principal','\\90429',3178,'0')",
                    "('','\\904','','','',0,1,0,'Purchase Summary Per Principal/Division','\\90430',3179,'0')",
                    "('','\\904','','','',0,1,0,'Purchase Summary Per Principal/Supplier','\\90431',3180,'0')",
                    "('','\\905','','','',0,1,0,'Top Performing Customer','\\90520',3181,'0')",
                    "('','\\907','','','',0,1,0,'Top Performing Sales Agent','\\90704',3182,'0')",
                    "('','\\904','','','',0,1,0,'Sales Summary (Universe)','\\90432',3304,'0')",
                    "('','\\904','','','',0,1,0,'Top Performing Item','\\90437',3390,'0')",
                    "('','\\905','','','',0,1,0,'Sales Summary per Vat Type','\\90438',3391,'0')",
                    "('','\\904','','','',0,1,0,'Distribution Report (FDA)','\\90439',4005,'0')",
                    "('','\\908','','','',0,1,0,'Login Attempts Report','\\90802',4000,'0')",
                    "('','\\904','','','',0,1,0,'Comparative Report - Inventory per Location','\\90433',4002,'0')",
                    "('','\\905','','','',0,1,0,'Detailed Sales - Transaction Report','\\90525',4003,'0')",
                    "('','\\906','','','',0,1,0,'Detailed Purchases - Transaction Report','\\90611',4004,'0')",
                ];
            break;

            case 'TENPLUS':
                $report_sysmenu=[
                    "('','\\905','','','',0,1,0,'Customer Sales Per Collection','\\90516',3181,'0')",
                ];
            break;

            case 'GALANG':
                $report_sysmenu=[
                    "('','\\904','','','',0,1,0,'Quantity On Hand','\\90415',3166,'1')",
                    "('','\\904','','','',0,1,0,'Schedule of Inventory (FIFO)','\\90420',3170,'0')",
                    "('','\\904','','','',0,1,0,'Inventory Movement Report','\\90421',3171,'0')",
                ];
            break;

            case 'SBC':
                $report_sysmenu=[
                    "('','\\905','','','',0,1,0,'Receivables vs Collection','\\90521',3251,'0')",
                    "('','\\905','','','',0,1,0,'Sales vs Collection','\\90522',3252,'0')",
                    "('','\\905','','','',0,1,0,'Commission Report','\\90523',3253,'0')",
                    "('','\\905','','','',0,1,0,'Event Listing','\\90524',3254,'0')",
                ];
            break;
            
            case 'KINGGEORGE':
                $report_sysmenu=[
                    "('','\\907','','','',0,1,0,'Sales Agent Report','\\\90703',3296,'')",
                    "('','\\904','','','',0,1,0,'Sales Item Per Report Per DR','\\\90413',3297,'0')",
                ];
            break;

            case 'FHI':
                $report_sysmenu=[
                    "('','\\90901','','','',0,1,0,'PO Listing','\\9090105',3163,0)",
                    "('','\\90901','','','',0,1,0,'Unserved PO','\\9090106',3164,0)",
                    "('','\\907','','','',0,1,0,'Aging Report Per Salesman','\\90703',3165,0)",
                    "('','\\907','','','',0,1,0,'Sales Report Per Agent','\\90704',3166,0)"
                ];
            break;

            case 'MLCP':
                $report_sysmenu=[
                    "('','\\910','','','',0,1,0,'Product Listing','\\91001',3267,'')",
                    "('','\\910','','','',0,1,0,'Rate Listing','\\91002',3268,'0')",
                    "('','\\910','','','',0,1,0,'Product Listing per Material','\\91003',3269,'0')",
                    "('','\\904','','','',0,1,0,'Schedule of Inventory (FIFO)','\\90420',3170,'0')",
                    //WTODO: [KIM][2019.09.30][add inventory checksheet menu]
                    "('','\\904','','','',0,1,0,'Inventory Checksheet','\\90413',3270,0)",
                    //WTODO: [KIM][2019.10.03][add unclosed job order report]
                    "('','\\904','','','',0,1,0,'Unclosed Job Order Report','\\90414',3271,0)",
                    //WTODO: [KIM][2019.10.03][add partially served job order]
                    "('','\\904','','','',0,1,0,'Partially Served Job Order','\\90415',3272,0)",
                    //WTODO: [KIM][2019.10.03][job order history]
                    "('','\\904','','','',0,1,0,'Job Order History','\\90416',3273,0)",
                    //WTODO: [KIM][2019.11.11][product information sheet]
                    "('','\\910','','','',0,1,0,'Product Information Sheet','\\91004',3295,0)",
                    //WTODO: [KIM][2019.11.28][job order listing]
                    "('','\\905','','','',0,1,0,'Job Order Listing','\\90520',3296,0)",
                    //WTODO: [KIM][2019.12.09][unclosed job order report]
                    "('','\\904','','','',0,1,0,'Unserved Job Order Report','\\90417',3299,0)",
                    //WTODO: [KIM][2019.12.09][Payable to Customer Report]
                    "('','\\905','','','',0,1,0,'Payable to Customer Report','\\90521',3300,0)",
                ];
            break;

            default:
                $report_sysmenu=[];
            break;
        }//END SWITCH
        
        return $report_sysmenu;
    }//end f

    private function ReportAccessList($systype){
    //NOTE: PLEASE MODIFY SYSTYPE FILTER 
    //IF THE CONTENT NEEDS TO BE FILTERED BETWEEN DIFFERENT POS PLATFORMS
    //AND DIFFERENT AIMS CLIENTS - jaoski 11/9/2018 5:37:35 PM
        
        switch ($this->companyConfig()) {
            case 'UNIVERSE':
                // $expenserep_access = ["(3164,1,'Expenses Report','*114',0,'\\90308','\\903',0,'0',0)"];
                $attexpense = '3164';
                $codeexpense = '90309';
                $parentexpense = '903';
            break;
            
            default:
                // $expenserep_access = ["(3052,1,'Expenses Report','*114',0,'\\90804','\\908',0,'0',0)"];
                $attexpense = '3052';
                $codeexpense = '90804';
                $parentexpense = '908';
            break;
        }//end switch

        switch ($this->companyConfig()) {
            case 'KINGGEORGE':
                $current_customer_receivable_label = 'Current Customer Receivables Aging(Summary)';
                $current_customer_receivable_aging_label = 'Current Customer Receivables Aging(Detailed)';
            break;
            
            default:
                $current_customer_receivable_label = 'Current Customer Receivables';
                $current_customer_receivable_aging_label = 'Current Customer Receivables Aging';
            break;
        }//end switch


        switch ($this->companyConfig()) {
            case 'UNIVERSE':
                $acc_checkmonitoringreports = "";
                $acc_bouncedchecks = "";
                $acc_issuedchecks = "";
                $acc_receivedchecks = "";
                $acc_undepositedchecks = "";
            break;
            
            default:
                $acc_checkmonitoringreports = "(3008,0,'Check Monitoring Reports','',0,'\\902','\\9',0,'0',0)";
                $acc_bouncedchecks = "(3009,1,'Bounced Checks','*8',0,'\\90201','\\902',0,'0',0)";
                $acc_issuedchecks = "(3010,1,'Issued Checks','*11',0,'\\90202','\\902',0,'0',0)";
                $acc_receivedchecks = "(3011,1,'Received Checks','*12',0,'\\90203','\\902',0,'0',0)";
                $acc_undepositedchecks = "(3012,1,'Undeposited Checks','*13',0,'\\90204','\\902',0,'0',0)";
            break;
        }//end switch

        $productionaccess =  "";

        switch ($this->companyconfig()) {
            case 'MLCP':
                $productionaccess = "(3266,0,'Production','',0,'\\910','\\9',0,'0',0)";
            break;
        }//end switch

        $report_sysaccess=["(3001,0,'Accounting Books','',0,'\\901','\\9',0,'0',0)",
        "(3002,1,'Cash Disbursement Book','*2',0,'\\90101','\\901',0,'0',0)",
        "(3003,1,'Cash Receipt Book','*3',0,'\\90102','\\901',0,'0',0)",
        "(3004,1,'Journal Voucher','*4',0,'\\90103','\\901',0,'0',0)",
        "(3005,1,'Purchase Journal','*5',0,'\\90104','\\901',0,'0',0)",
        "(3006,1,'Sales Journal','*6',0,'\\90105','\\901',0,'0',0)",
        "(3007,1,'Chart of Accounts','*28',0,'\\90106','\\901',0,'0',0)",
        $acc_checkmonitoringreports,
        $acc_bouncedchecks,
        $acc_issuedchecks,
        $acc_receivedchecks,
        $acc_undepositedchecks,
        "(3013,0,'Financial Statements','',0,'\\903','\\9',0,'0',0)",
        "(3014,1,'Balance Sheet','*15',0,'\\90301','\\903',0,'0',0)",
        "(3015,1,'Income Statement','*16',0,'\\90302','\\903',0,'0',0)",
        "(3016,1,'Subsidiary Ledger','*17',0,'\\90303','\\903',0,'0',0)",
        "(3017,1,'Trial Balance','*18',0,'\\90304','\\903',0,'0',0)",
        "(3085,1,'Monthly Income Statement','',0,'\\90305','\\903',0,'0',0)",
        "(3083,1,'Comparative Income Statement','',0,'\\90306','\\903',0,'0',0)",
        "(3084,1,'Comparative Balance Sheet','',0,'\\90307','\\903',0,'0',0)",

        "(3018,0,'Items','',0,'\\904','\\9',0,'0',0)",
        "(3019,1,'Inventory Balance','*22',0,'\\90401','\\904',0,'0',0)",
        "(3020,1,'Analyze Item Purchase (Monthly)','*71',0,'\\90402','\\904',0,'0',0)",
        "(3021,1,'Analyze Item Sales (Monthly)','*93',0,'\\90403','\\904',0,'0',0)",
        "(3022,0,'Item List','',0,'\\90404','\\904',0,'0',0)",
        "(3023,1,'Current Inventory Aging','*20',0,'\\9041','\\904',0,'0',0)",
        "(3024,1,'Fast Moving Items','*112',0,'\\90405','\\904',0,'0',0)",
        "(3025,1,'Analyze Item Sales with Profit Markup','*113',0,'\\90406','\\904',0,'0',0)",
        "(3027,1,'Slow Moving Items','*121',0,'\\90408','\\904',0,'0',0)",
        "(3139,1,'Item Purchase Report','*129',0,'\\90425','\\904',0,'0',0)",
        "(3028,1,'Sales Per Item Per Customer','',0,'\\90409','\\904',0,'',0)",
        "(3029,1,'Item to Expired','',0,'\\90410','\\904',0,'',0)",
        "(3030,1,'Item Balance - Below Minimum','',0,'\\90411','\\904',0,'',0)",
        "(3031,1,'Item Balance - Above Maximum','',0,'\\90412','\\904',0,'',0)",

        "(3032,0,'Customers','',0,'\\905','\\9',0,'0',0)",
        "(3033,1,'Customer List','*29',0,'\\90501','\\905',0,'0',0)",
        "(3034,1,'".$current_customer_receivable_label."','*80',0,'\\90502','\\905',0,'0',0)",
        "(3035,1,'".$current_customer_receivable_aging_label."','*82',0,'\\90503','\\905',0,'0',0)",
        "(3036,1,'Analyze Customer Sales (Monthly)','*87',0,'\\90504','\\905',0,'0',0)",
        "(3037,1,'Customer Sales Report','*89',0,'\\90505','\\905',0,'0',0)",
        "(3038,0,'Pending Sales Orders','',0,'\\90506','\\905',0,'0',0)",
        //"(3086,1,'Sales Comparison (Graph)','',0,'\\90513','\\905',0,'0',0)",
        "(3053,1,'Customer Performance Report','*121',0,'\\90509','\\905',0,'0',0)",
        "(3127,1,'Analyze Customer Collection Monthly','',0,'\\90514','\\905',0,'0',0)",
        "(3082,1,'Sales Per Customer Per Item','',0,'\\90510','\\905',0,'',0)",
        "(3039,1,'Monthly Sales Report (Graph)','',0,'\\90512','\\905',0,'0',0)",
        "(3161,1,'Daily Collection (Victory Mall)','',0,'\\90515','\\905',0,'0',0)",

        "(3040,0,'Supplier','',0,'\\906','\\9',0,'0',0)",
        "(3041,1,'Supplier List','*32',0,'\\90601','\\906',0,'0',0)",
        "(3042,1,'Current Supplier Payables','*58',0,'\\90602','\\906',0,'0',0)",
        "(3043,1,'Current Supplier Payables Aging','*60',0,'\\90603','\\906',0,'0',0)",
        "(3044,1,'Analyzed Supplier Purchases (Monthly)','*65',0,'\\90604','\\906',0,'0',0)",
        "(3045,1,'Supplier Purchase Report','*68',0,'\\90605','\\906',0,'0',0)",
        "(3046,0,'Pending Purchase Orders','',0,'\\90606','\\906',0,'0',0)",
        "(3054,1,'Supplier Performance Report','*122',0,'\\90609','\\906',0,'0',0)",

        "(3047,0,'Sales Agent','',0,'\\907','\\9',0,'0',0)",
        "(3048,1,'Sales Agent List','*31',0,'\\90701','\\907',0,'0',0)",
        "(3049,1,'Analyzed Agent Sales (Monthly)','*102',0,'\\90702','\\907',0,'0',0)",

        //PRODUCTION ACCESS (KIM)
        $productionaccess,
        //please continue here series must be \\910 + next seq - jaoski

        "(3050,0,'Other Reports','',0,'\\908','\\9',0,'0',0)",
        "(3051,1,'Statement of Account','*111',0,'\\90801','\\908',0,'0',0)",
        "('".$attexpense."',1,'Expenses Report','*114',0,'\\".$codeexpense."','\\".$parentexpense."',0,'0',0)",
        "(3055,1,'Receiving Consignment Report','*123',0,'\\90610','\\906',0,'0',0)",

        "(3056,1,'Transaction List','*129',0,'\\909','\\9',0,'0',0)",
        "(3057,1,'Purchase','',0,'\\90901','\\909',0,'',0)",
        "(3058,1,'Receiving Report','',0,'\\9090103','\\909',0,'',0)",
        "(3059,1,'Purchase Return Report','',0,'\\9090104','\\909',0,'',0)",
        "(3060,1,'Purchase Order Report','',0,'\\9090102','\\909',0,'',0)",
        "(3061,1,'Purchase Requisition Report','',0,'\\9090101','\\909',0,'',0)",
        "(3062,1,'Sales','',0,'\\90902','\\909',0,'',0)",
        "(3063,1,'Sales Order Report','',0,'\\9090201','\\909',0,'',0)",
        "(3064,1,'Sales Journal Report','',0,'\\9090202','\\909',0,'',0)",
        "(3065,1,'Sales Return Report','',0,'\\9090203','\\909',0,'',0)",
        "(3066,1,'Inventory','',0,'\\90903','\\909',0,'',0)",
        "(3067,1,'Inventory Setup Report','',0,'\\9090301','\\909',0,'',0)",
        "(3068,1,'Physical Count Report','',0,'\\9090302','\\909',0,'',0)",
        "(3069,1,'Transfer Slip Report','',0,'\\9090303','\\909',0,'',0)",
        "(3070,1,'Inventory Adjustment Report','',0,'\\9090304','\\909',0,'',0)",
        "(3071,1,'Payables','',0,'\\90904','\\909',0,'',0)",
        "(3072,1,'AP Setup','',0,'\\9090401','\\909',0,'',0)",
        "(3073,1,'AP Voucher','',0,'\\9090402','\\909',0,'',0)",
        "(3074,1,'Cash/Check Voucher','',0,'\\9090403','\\909',0,'',0)",
        "(3075,1,'Receivables','',0,'\\90905','\\909',0,'',0)",
        "(3076,1,'AR Setup','',0,'\\9090501','\\909',0,'',0)",
        "(3077,1,'Received Payment','',0,'\\9090502','\\909',0,'',0)",
        "(3078,1,'Counter Receipt','',0,'\\9090503','\\909',0,'',0)",
        "(3079,1,'Accounting','',0,'\\90906','\\909',0,'',0)",
        "(3080,1,'General Journal','',0,'\\9090601','\\909',0,'',0)",
        "(3081,1,'Deposit Slip','',0,'\\9090602','\\909',0,'',0)",];

        return $report_sysaccess;
    }//end f

    private function ReportsMenuList($systype){
    //NOTE: PLEASE MODIFY SYSTYPE FILTER 
    //IF THE CONTENT NEEDS TO BE FILTERED BETWEEN DIFFERENT POS PLATFORMS
    //AND DIFFERENT AIMS CLIENTS - jaoski 11/9/2018 5:37:35 PM
        switch ($this->companyConfig()) {
            case 'UNIVERSE':
                // $expenserep_access = ["(3164,1,'Expenses Report','*114',0,'\\90308','\\903',0,'0',0)"];
                $attexpense = '3164';
                $codeexpense = '90309';
                $parentexpense = '903';
            break;
            
            default:
                // $expenserep_access = ["(3052,1,'Expenses Report','*114',0,'\\90804','\\908',0,'0',0)"];
                $attexpense = '3052';
                $codeexpense = '90804';
                $parentexpense = '908';
            break;
        }//end switch

        switch ($this->companyConfig()) {
            case 'KINGGEORGE':
                $current_customer_receivable_label = 'Current Customer Receivables Aging(Summary)';
                $current_customer_receivable_aging_label = 'Current Customer Receivables Aging(Detailed)';
            break;
            
            default:
                $current_customer_receivable_label = 'Current Customer Receivables';
                $current_customer_receivable_aging_label = 'Current Customer Receivables Aging';
            break;
        }//end switch


        $parent_accountingbooks = "('','\\9','','','',0,0,0,'Accounting Books','\\901',3001,'0')";
        $rep_cashdisbursementbook = "('','\\901','','','',0,1,0,'Cash Disbursement Book','\\90101',3002,'0')";
        $rep_cashreceiptbook = "('','\\901','','','',0,1,0,'Cash Receipt Book','\\90102',3003,'0')";
        $rep_journalvoucher = "('','\\901','','','',0,1,0,'Journal Voucher','\\90103',3004,'0')";
        $rep_purchasejournal = "('','\\901','','','',0,1,0,'Purchase Journal','\\90104',3005,'0')";
        $rep_salesjournal = "('','\\901','','','',0,1,0,'Sales Journal','\\90105',3006,'0')";
        $rep_chartofaccounts = "('','\\901','','','',0,1,0,'Chart of Accounts','\\90106',3007,'0')";
        
        switch ($this->companyConfig()) {
            case 'UNIVERSE':
                $parent_checkmonitoringreports = "";
                $rep_bouncedchecks = "";
                $rep_issuedchecks = "";
                $rep_receivedchecks = "";
                $rep_undepositedchecks = "";
            break;
            
            default:
                $parent_checkmonitoringreports = "('','\\9','','','',0,0,0,'Check Monitoring Reports','\\902',3008,'0')";
                $rep_bouncedchecks = "('','\\902','','','',0,1,0,'Bounced Checks','\\90201',3009,'0')";
                $rep_issuedchecks = "('','\\902','','','',0,1,0,'Issued Checks','\\90202',3010,'0')";
                $rep_receivedchecks = "('','\\902','','','',0,1,0,'Received Checks','\\90203',3011,'0')";
                $rep_undepositedchecks = "('','\\902','','','',0,1,0,'Undeposited Checks','\\90204',3012,'0')";
            break;
        }//END SWITHC
        
        $parent_financialstatements = "('','\\9','','','',0,0,0,'Financial Statements','\\903',3013,'0')";
        $rep_balancesheet = "('','\\903','','','',0,1,0,'Balance Sheet','\\90301',3014,'0')";
        $rep_incomestatement = "('','\\903','','','',0,1,0,'Income Statement','\\90302',3015,'0')";
        $rep_subsidiaryledger = "('','\\903','','','',0,1,0,'Subsidiary Ledger','\\90303',3016,'0')";
        $rep_trialbalance = "('','\\903','','','',0,1,0,'Trial Balance','\\90304',3017,'0')";
        $rep_comparativeincomestatment = "('','\\903','','','',0,1,0,'Comparative Income Statement','\\90306',3083,'0')";
        $rep_comparativebalancesheet = "('','\\903','','','',0,1,0,'Comparative Balance Sheet','\\90307',3084,'0')";
        $rep_monthlyincomestatement = "('','\\903','','','',0,1,0,'Monthly Income Statement','\\90308',3085,'0')";

        $parent_items = "('','\\9','','','',0,0,0,'Items','\\904',3018,'0')";
        $rep_inventorybalance = "('','\\904','','','',0,1,0,'Inventory Balance','\\90401',3019,'0')";
        $rep_analyzeitempurchasemonthly = "('','\\904','','','',0,1,0,'Analyze Item Purchase (Monthly)','\\90402',3020,'0')";
        $rep_analyzeitemsalesmonthly = "('','\\904','','','',0,1,0,'Analyze Item Sales (Monthly)','\\90403',3021,'0')";
        $rep_itemlist = "('','\\904','','','',0,1,0,'Item List','\\90404',3022,'0')";
        $rep_currentinventoryaging = "('','\\904','','','',0,1,0,'Current Inventory Aging','\\9041',3023,'0')";
        $rep_fastmovingitems = "('','\\904','','','',0,1,0,'Fast Moving Items','\\90405',3024,'0')";
        $rep_slowmovingitems = "('','\\904','','','',0,1,0,'Slow Moving Items','\\90408',3027,'0')";
        $rep_analyzeitemsaleswithprofitmarkup = "('','\\904','','','',0,1,0,'Analyze Item Sales with Profit Markup','\\90406',3025,'0')";
        $rep_itempurchasereport = "('','\\904','','','',0,1,0,'Item Purchase Report','\\90425',3139,'1')";
        $rep_salesperitempercustomer = "('','\\904','','','',0,1,0,'Sales Per Item Per Customer','\\90409',3028,'0')";
        $rep_itemtoexpired = "('','\\904','','','',0,1,0,'Item to Expired','\\90410',3029,'0')";
        $rep_itembalance_belowminimum = "('','\\904','','','',0,1,0,'Item Balance - Below Minimum','\\90411',3030,'0')";
        $rep_itembalance_aboveminimum = "('','\\904','','','',0,1,0,'Item Balance - Above Maximum','\\90412',3031,'0')";

        $parent_customers = "('','\\9','','','',0,0,0,'Customers','\\905',3032,'0')";
        $rep_customerlist = "('','\\905','','','',0,1,0,'Customer List','\\90501',3033,'0')";
        $rep_currentcustomerreceivable = "('','\\905','','','',0,1,0,'".$current_customer_receivable_label."','\\90502',3034,'0')";
        $rep_currentcustomerreceivableaging = "('','\\905','','','',0,1,0,'".$current_customer_receivable_aging_label."','\\90503',3035,'0')";
        $rep_analyzecustomersalesmonthly = "('','\\905','','','',0,1,0,'Analyze Customer Sales (Monthly)','\\90504',3036,'0')";
        $rep_customersalesreport = "('','\\905','','','',0,1,0,'Customer Sales Report','\\90505',3037,'0')";
        $rep_pendingsalesorders = "('','\\905','','','',0,1,0,'Pending Sales Orders','\\90506',3038,'0')";
        $rep_salescomparison_graph = "('','\\905','','','',0,1,0,'Sales Comparison (Graph)','\\90512',3086,'0')";
        $rep_customerperformancereport = "('','\\905','','','',0,1,0,'Customer Performance Report','\\90509',3053,'0')";
        $rep_analyzecustomercollectionmonthly = "('','\\905','','','',0,1,0,'Analyze Customer Collection Monthly','\\90519',3127,'0')";
        $rep_salespercustomerperitem = "('','\\905','','','',0,1,0,'Sales Per Customer Per Item','\\90510',3082,'0')";
        $rep_monthlysalesreport_graphy = "('','\\905','','','',0,1,0,'Monthly Sales Report (Graph)','\\90511',3039,'0')";
        $rep_dailycollection_victorymall = "('','\\905','','','',0,1,0,'Daily Collection (Victory Mall)','\\90515',3161,'0')";

        $parent_supplier = "('','\\9','','','',0,0,0,'Supplier','\\906',3040,'0')";
        $rep_supplierlist = "('','\\906','','','',0,1,0,'Supplier List','\\90601',3041,'0')";
        $rep_currentsupplierpayables = "('','\\906','','','',0,1,0,'Current Supplier Payables','\\90602',3042,'0')";
        $rep_currentsupplierpayablesaging = "('','\\906','','','',0,1,0,'Current Supplier Payables Aging','\\90603',3043,'0')";
        $rep_analyzedsupplierpurchasesmonthly = "('','\\906','','','',0,1,0,'Analyzed Supplier Purchases (Monthly)','\\90604',3044,'0')";
        $rep_supplierpurchasereport = "('','\\906','','','',0,1,0,'Supplier Purchase Report','\\90605',3045,'0')";
        $rep_pendingpurchaseorders = "('','\\906','','','',0,1,0,'Pending Purchase Orders','\\90606',3046,'0')";
        $rep_supplierperformancereport = "('','\\906','','','',0,1,0,'Supplier Performance Report','\\90609',3054,'0')";

        $parent_salesagent = "('','\\9','','','',0,0,0,'Sales Agent','\\907',3047,'0')";
        $rep_salesagentlist = "('','\\907','','','',0,1,0,'Sales Agent List','\\90701',3048,'0')";
        $rep_analyzedagentsalesmonthly = "('','\\907','','','',0,1,0,'Analyzed Agent Sales (Monthly)','\\90702',3049,'0')";

        switch ($this->companyConfig()) {
            case 'MLCP':
                $parent_production = "('','\\9','','','',0,1,0,'Production','\\910',3266,'0')";
            break;
            
            default:
                $parent_production = "";
            break;
        }//END SWITHC

        $parent_otherreports = "('','\\9','','','',0,0,0,'Other Reports','\\908',3050,'0')";
        $rep_statementofaccount = "('','\\908','','','',0,1,0,'Statement of Account','\\90801',3051,'0')";
        $rep_expensesreport = "('','\\".$parentexpense."','','','',0,1,0,'Expenses Report','\\".$codeexpense."',".$attexpense.",'0')";
        $rep_receivingconsignmentreport = "('','\\906','','','',0,1,0,'Receiving Consignment Report','\\90610',3055,'0')";

        $parent_transactionlist = "('','\\9','','','',0,0,0,'Transaction List','\\909',3056,'0')";
        $subparent_purchases = "('','\\909','','','',0,0,0,'Purchases','\\90901',3057,'0')";
        $rep_purchaserequisitionreport = "('','\\90901','','','',0,1,0,'Purchase Requisition Report','\\9090101',3061,'0')";
        $rep_purchaseorderreport = "('','\\90901','','','',0,1,0,'Purchase Order Report','\\9090102',3060,'0')";
        $rep_receivingreport = "('','\\90901','','','',0,1,0,'Receiving Report','\\9090103',3058,'0')";
        $rep_purchasereturnreport = "('','\\90901','','','',0,1,0,'Purchase Return Report','\\9090104',3059,'0')";
        $subparent_sales = "('','\\909','','','',0,0,0,'Sales','\\90902',3062,'0')";
        $rep_salesorderreport = "('','\\90902','','','',0,1,0,'Sales Order Report','\\9090201',3063,'0')";
        $rep_salesjournalreport = "('','\\90902','','','',0,1,0,'Sales Journal Report','\\9090202',3064,'0')";
        $rep_salesreturnreport = "('','\\90902','','','',0,1,0,'Sales Return Report','\\9090203',3065,'0')";
        $subparent_inventory = "('','\\909','','','',0,0,0,'Inventory','\\90903',3066,'0')";
        $rep_inventorysetupreport = "('','\\90903','','','',0,1,0,'Inventory Setup Report','\\9090301',3067,'0')";
        $rep_physicalcountreport = "('','\\90903','','','',0,1,0,'Physical Count Report','\\9090302',3068,'0')";
        $rep_transferslipreport = "('','\\90903','','','',0,1,0,'Transfer Slip Report','\\9090303',3069,'0')";
        $rep_inventoryadjustmentreport = "('','\\90903','','','',0,1,0,'Inventory Adjustment Report','\\9090304',3070,'0')";
        $subparent_payables = "('','\\909','','','',0,0,0,'Payables','\\90904',3071,'0')";
        $rep_apsetupreport = "('','\\90904','','','',0,1,0,'AP Setup','\\9090401',3072,'0')";
        $rep_apvoucherreport = "('','\\90904','','','',0,1,0,'AP Voucher','\\9090402',3073,'0')";
        $rep_cashcheckvoucherreport = "('','\\90904','','','',0,1,0,'Cash/Check Voucher','\\9090403',3074,'0')";
        $subparent_receivables = "('','\\909','','','',0,0,0,'Receivables','\\90905',3075,'0')";
        $rep_arsetupreport = "('','\\90905','','','',0,1,0,'AR Setup','\\9090501',3076,'0')";
        $rep_receivedpaymentreport = "('','\\90905','','','',0,1,0,'Received Payment','\\9090502',3077,'0')";
        $rep_counterreceiptreport = "('','\\90905','','','',0,1,0,'Counter Receipt','\\9090503',3078,'0')";
        $subparent_accounting = "('','\\909','','','',0,0,0,'Accounting','\\90906',3079,'0')";
        $rep_generaljournalreport = "('','\\90906','','','',0,1,0,'General Journal','\\9090601',3080,'0')";
        $rep_depositslipreport = "('','\\90906','','','',0,1,0,'Deposit Slip','\\9090602',3081,'0')";

        $report_sysmenu = [
            $parent_accountingbooks,
            $rep_cashdisbursementbook,
            $rep_cashreceiptbook,
            $rep_journalvoucher,
            $rep_purchasejournal,
            $rep_salesjournal,
            $rep_chartofaccounts,

            $parent_checkmonitoringreports,
            $rep_bouncedchecks,
            $rep_issuedchecks,
            $rep_receivedchecks,
            $rep_undepositedchecks,

            $parent_financialstatements,
            $rep_balancesheet,
            $rep_incomestatement,
            $rep_subsidiaryledger,

            $rep_trialbalance,
            $rep_comparativeincomestatment,
            $rep_comparativebalancesheet,
            $rep_monthlyincomestatement,

            $parent_items,
            $rep_inventorybalance,
            $rep_analyzeitempurchasemonthly,
            $rep_analyzeitemsalesmonthly,
            $rep_itemlist,
            $rep_currentinventoryaging,
            $rep_fastmovingitems,
            $rep_analyzeitemsaleswithprofitmarkup,
            $rep_slowmovingitems,
            $rep_itempurchasereport,
            $rep_salesperitempercustomer,
            $rep_itemtoexpired,
            $rep_itembalance_belowminimum,
            $rep_itembalance_aboveminimum,

            $parent_customers,
            $rep_customerlist,
            $rep_currentcustomerreceivable,
            $rep_currentcustomerreceivableaging,
            $rep_analyzecustomersalesmonthly,
            $rep_customersalesreport,
            $rep_pendingsalesorders,
            //$rep_salescomparison_graph,
            $rep_customerperformancereport,
            $rep_analyzecustomercollectionmonthly,
            $rep_salespercustomerperitem,
            $rep_monthlysalesreport_graphy,
            //$rep_dailycollection_victorymall,

            $parent_supplier,
            $rep_supplierlist,
            $rep_currentsupplierpayables,
            $rep_currentsupplierpayablesaging,
            $rep_analyzedsupplierpurchasesmonthly,
            $rep_supplierpurchasereport,
            $rep_pendingpurchaseorders,
            $rep_supplierperformancereport,

            $parent_salesagent,
            $rep_salesagentlist,
            $rep_analyzedagentsalesmonthly,

            $parent_production,
            
            $parent_otherreports,
            $rep_statementofaccount,
            $rep_expensesreport,
            $rep_receivingconsignmentreport,

            $parent_transactionlist,
            $subparent_purchases,
            $rep_purchaserequisitionreport,
            $rep_purchaseorderreport,
            $rep_receivingreport,
            $rep_purchasereturnreport,
            $subparent_sales,
            $rep_salesorderreport,
            $rep_salesjournalreport,
            $rep_salesreturnreport,
            $subparent_inventory,
            $rep_inventorysetupreport,
            $rep_physicalcountreport,
            $rep_transferslipreport,
            $rep_inventoryadjustmentreport,
            $subparent_payables,
            $rep_apsetupreport,
            $rep_apvoucherreport,
            $rep_cashcheckvoucherreport,
            $subparent_receivables,
            $rep_arsetupreport,
            $rep_receivedpaymentreport,
            $rep_counterreceiptreport,
            $subparent_accounting,
            $rep_generaljournalreport,
            $rep_depositslipreport,];

        return $report_sysmenu;
    }//end f

    public function fixMemoryBandError(){
    //THIS FUNCTION IS USED TO FIX ERROR ON MEMORY LIMITING
    //THIS SETS THE MEMORY LIMIT FOR THAT FUNCTION TO USE UNLIMITED MEMORY RESOURCES (DEPENDS ON SERVER)
    //TO PROCESS BIG CHUNKS OF DATA
    //NOTE: THIS WILL ONLY BE USED FOR FUNCTIONS USING BIG CHUNKS OF DATA WHICH
    //PHP CANT HANDLE AS DEFAULT. 
    //DANGEROUS CODE: Please apply it to functions which needed more memory
        ini_set('memory_limit', '-1');
    }//end if

    private function POSModulesSetting(){
    //THIS FUNCTION IS TO SET WHAT POS MODULES IS TO ADD PER SETTING
    //AVAVILABLE OPT: RETAIL,FINEDINE,QSR
        return 'QSR';
    }//end f

    private function managePOSMenus($q){
        switch ($q) {
            case 'insert':
                $qryparent = "insert into left_parent(id,name,seq,class,doc) 
                              values(14,'POS UTILITIES',14,'masterfile_ico fa fa-gears',',manageitem,posstockcard,tbmasterfile,branch')";
                Yii::$app->sbccommon->execqry($qryparent);
                
                switch ($this->POSModulesSetting()) {
                    case 'RETAIL':
                        $qrychild1 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                      values(14,'branch','/branch/index','Branch Masterfile','masterfile_sub_ico fa fa-file',3155)";

                        $qrychild2 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                      values(14,'posstockcard','/posstockcard/index','POS Stockcard','masterfile_sub_ico fa fa-list-alt',11)";

                        Yii::$app->sbccommon->execqry($qrychild1);
                        Yii::$app->sbccommon->execqry($qrychild2);
                    break;
                    
                    case 'QSR':
                        $qrychild1 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                      values(14,'branch','/branch/index','Branch Masterfile','masterfile_sub_ico fa fa-file',3155)";
                        $qrychild2 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                      values(14,'manageitem','/manageitem/index','Manage Item','masterfile_sub_ico fa fa-file',3153)";

                        Yii::$app->sbccommon->execqry($qrychild1);
                        Yii::$app->sbccommon->execqry($qrychild2);
                    break;

                    case 'FINEDINE':
                        $qrychild1 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                      values(14,'branch','/branch/index','Branch Masterfile','masterfile_sub_ico fa fa-file',3155)";
                        $qrychild2 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                      values(14,'manageitem','/manageitem/index','Manage Item','masterfile_sub_ico fa fa-file',3153)";
                        $qrychild3 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                      values(14,'tbmasterfile','/tbmasterfile/index','Table Masterfile','masterfile_sub_ico fa fa-file',3154)";

                        Yii::$app->sbccommon->execqry($qrychild1);
                        Yii::$app->sbccommon->execqry($qrychild2);
                        Yii::$app->sbccommon->execqry($qrychild3);
                    break;
                }//end switch
            break;
            
            case 'remove':
                $qryparent = "delete from left_parent where id = 14";
                $qrychild = "delete from left_menu where parent_id = 14";
                Yii::$app->sbccommon->execqry($qryparent);
                Yii::$app->sbccommon->execqry($qrychild);
            break;
        }//end swtich
    }//end f

    private function enablePOSModules(){
        //this functions defines and add needed modules for the POSModulesSetting()
        if(isset($_ENV['ENABLE_POS_MODULES'])){
            $isenabled = $_ENV['ENABLE_POS_MODULES'];
        }else{
            $isenabled = false;
        }//end if

         //CHANGE VALUE OF THIS BOOLEAN TO APPLY POS MODULES
        return $isenabled;
    }//end f

    public function systemMenuSetup(){
        //THIS FUNCTION WILL AUTO SETUP MODULES FOR SPECIFIC TYPE OF SYSTEM
        //AMS   =  ACCOUNTING MODULES ONLY
        //AIMS  =  ACCTG AND INVENTORY MODULES
        //MIS   =  INVENTORY MODULES

        //set value for type of menu packages
        if(isset($_ENV['SYSTEM_TYPE'])){
            $systype = $_ENV['SYSTEM_TYPE'];
        }else{
            $systype = 'AIMS';
        }//end if
        
        // set value if menu will always reset upon login
        if(isset($_ENV['RESET_MENU_AT_LOGIN'])){
            $alwaysreset = $_ENV['RESET_MENU_AT_LOGIN'];
        }else{
            $alwaysreset = 1;
        }//end if
        

      if($alwaysreset){ //IF ALWAYSRESET IS TRUE THIS WILL ALWAYS RESET MENUS UPON LOGIN (disregards setting in database if menu was already setup)
        $this->resetMenuPackages();
        $this->setSystemMenus($systype);
        $qry = "update profile set pvalue = '1' where doc = 'SYSMEN'";
        Yii::$app->sbccommon->execqry($qry);
      }else{            
        if(!$this->checkSystemMenus()){ //IF ALWAYS RESET IS FALSE THIS WILL ALWAYS CHECK IF MENUS WAS ALREADY SETUP, WILL ADD MENUS IF ITS NOT SETUP YET
            $this->setSystemMenus($systype);
            $qry = "update profile set pvalue = '1' where doc = 'SYSMEN'";
            Yii::$app->sbccommon->execqry($qry);
        }//end if
      }//end if

      $this->generateSystemAccessAttributes($systype); 
      $this->generateReportList($systype);
    }//end funct

    private function checkSystemMenus(){
    //CHECKS ALWAYS IF SYSTEM MENUS WAS ALREADY SETUP
      $qry = "select pvalue from profile where doc = 'SYSMEN'";
      $isset = Yii::$app->sbccommon->datareader($qry);

      //returns true if system menus was already setup
      //returns false if system menus needs to be setup first
      if($isset){
        return true;
      }else{
        return false;
      }//end if
    }//end func

    private function resetMenuPackages(){
    //this function clears out parent and child menus
      //RESETS MENU
      $qryresetsys = "update profile set pvalue = '1' where doc = 'SYSMEN'";
      $qrytruncateparent = 'truncate left_parent';
      $qrytruncatemenus = 'truncate left_menu';
      Yii::$app->sbccommon->execqry($qrytruncateparent);
      Yii::$app->sbccommon->execqry($qrytruncatemenus);
      Yii::$app->sbccommon->execqry($qryresetsys);
    }//end func

    private function setSystemMenus($systype){
    //FUNCTIONS THAT AUTO INSERT MENUS AND PARENTS
        switch ($systype) {
          //################################### MENUS FOR AMS ##################################################
          case 'AMS':
            $leftparents = [
            "insert into left_parent(id,name,seq,class,doc) values(1,'MASTERFILE',1,'fa fa-list-alt masterfile_ico',',coa,customer,supplier,agent,warehouse,stockcard,stockgrp,itemclass,principal,model,part,fbrmanager,categories')",
            "insert into left_parent(id,name,seq,class,doc) values(5,'PAYABLES',5,'payables_ico fa fa-edit',',AP,PV,CV')",
            "insert into left_parent(id,name,seq,class,doc) values(6,'RECEIVABLES',6,'receivables_ico fa fa-edit',',AR,CR,KR')",
            "insert into left_parent(id,name,seq,class,doc) values(7,'ACCOUNTING',7,'accounting_ico fa fa-edit',',GJ,DS,bankrecon')",
            "insert into left_parent(id,name,seq,class,doc) values(11,'TRANSACTION UTILITIES',11,'masterfile_ico fa fa-gears',',docprefix,terms,changeitem,audittrail,notification')",
            "insert into left_parent(id,name,seq,class,doc) values(12,'ACCOUNT UTILITIES',12,'masterfile_ico fa fa-gears',',useraccess,branchaccess')",
            "insert into left_parent(id,name,seq,class,doc) values(13,'OTHER UTILITIES',13,'masterfile_ico fa fa-gears',',scheduler,schedmanager,themer')",
            ];

            $leftchilds = [
            //FOR MASTERFILE
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'coa','/coa/index','Chart of Accounts','masterfile_sub_ico fa fa-file',2)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'customer','/customer/index','Customer','masterfile_sub_ico fa fa-user',21)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'supplier','/supplier/index','Supplier','masterfile_sub_ico fa fa-user',31)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'categories','/categories/index','Cust/Supp Categories','masterfile_sub_ico fa fa-file',3199)",

            //FOR PAYABLES
            "insert into left_menu (parent_id,doc,url,module,class,access) values(5,'AP','/AP/index','AP Setup','payables_sub_ico fa fa-circle-o',133)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(5,'PV','/PV/index','AP Voucher','payables_sub_ico fa fa-circle-o',370)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(5,'CV','/CV/index','Cash/Check Voucher','payables_sub_ico fa fa-circle-o',116)",

            //FOR RECEIVABLES
            "insert into left_menu (parent_id,doc,url,module,class,access) values(6,'AR','/AR/index','AR Setup','receivables_sub_ico fa fa-circle-o',239)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(6,'CR','/CR/index','Received Payment','receivables_sub_ico fa fa-circle-o',223)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(6,'KR','/KR/index','Counter Receipt','receivables_sub_ico fa fa-circle-o',208)",
            //"insert into left_menu (parent_id,doc,url,module,class,access) values(6,'CK','/CK/index','Post Dated Checks','receivables_sub_ico fa fa-circle-o',700)",

            //FOR ACCOUNTING
            "insert into left_menu (parent_id,doc,url,module,class,access) values(7,'GJ','/GJ/index','General Journal','accounting_sub_ico fa fa-circle-o',343)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(7,'DS','/DS/index','Deposit Slip','accounting_sub_ico fa fa-circle-o',326)",

            //FOR TRANSACTION UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'docprefix','/docprefix/index','Manage Prefixes','masterfile_sub_ico fa fa-font',599)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'terms','/terms/index','Manage Terms','masterfile_sub_ico fa fa-list',598)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'changeitem','/changeitem/index','Change Item','masterfile_sub_ico fa fa-undo',632)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'audittrail','/audittrail/index','Audit Trail','masterfile_sub_ico fa fa-list',633)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'notification','/notification/index','Unposted Transactions','masterfile_sub_ico fa fa-history',652)",
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(11,'productinquiry','javascript(0);','Product Inquiry','masterfile_sub_ico fa fa-question',796,1,'callproductinquiry')",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'ewtsetup','/ewtsetup/index','EWT Setup','masterfile_sub_ico fa fa-file',3157)",

            //FOR ACCOUNT UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access) values(12,'useraccess','/useraccess/index','Manage useraccess','masterfile_sub_ico fa fa-users',362)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(12,'branchaccess','/branchaccess/index','Branch Access','masterfile_sub_ico fa fa-institution',797)",

            //FOR OTHER UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(13,'systemanon','javascript(0);','System Announcements','masterfile_sub_ico fa fa-bullhorn',766,1,'btnmanageanon')",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(13,'themer','/themer/index','Theme Customizer','masterfile_sub_ico fa fa-star',767)",
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(13,'syslock','javascript(0);','Set System Lockdate','masterfile_sub_ico fa fa-clock-o',367,1,'btnsetsyslockdate')",
            ];
          break;
          

          //################################### MENUS FOR AIMS ##################################################
          case 'AIMS':
            $productionmenu = '';

            switch ($this->companyConfig()) {
                case 'MLCP':
                    $productionmenu = "insert into left_parent(id,name,seq,class,doc) values(15,'PRODUCTION',15,'masterfile_ico fa fa-refresh',',JB,JBU')";
                break;
            }//end switch

            $leftparents = [
                "insert into left_parent(id,name,seq,class,doc) values(1,'MASTERFILE',1,'fa fa-list-alt masterfile_ico',',coa,customer,supplier,agent,warehouse,stockcard,stockgrp,itemclass,principal,model,part,fbrmanager,categories')",
                "insert into left_parent(id,name,seq,class,doc) values(2,'PURCHASES',2,'fa fa-arrow-circle-o-down purchases_ico',',PR,PO,RR,DM')", 
                "insert into left_parent(id,name,seq,class,doc) values(3,'SALES',3,'sales_ico fa fa-tags',',SO,SJ,CM,MI')",
                "insert into left_parent(id,name,seq,class,doc) values(4,'INVENTORY',4,'inventory_ico fa fa-table',',IS,PC,AJ,TS,TR')",
                $productionmenu,
                "insert into left_parent(id,name,seq,class,doc) values(5,'PAYABLES',5,'payables_ico fa fa-edit',',AP,PV,CV')",
                "insert into left_parent(id,name,seq,class,doc) values(6,'RECEIVABLES',6,'receivables_ico fa fa-edit',',AR,CR,KR')",
                "insert into left_parent(id,name,seq,class,doc) values(7,'ACCOUNTING',7,'accounting_ico fa fa-edit',',GJ,DS,bankrecon')",
                "insert into left_parent(id,name,seq,class,doc) values(11,'TRANSACTION UTILITIES',11,'masterfile_ico fa fa-gears',',docprefix,terms,changeitem,audittrail,notification')",
                "insert into left_parent(id,name,seq,class,doc) values(12,'ACCOUNT UTILITIES',12,'masterfile_ico fa fa-gears',',useraccess,branchaccess')",
                "insert into left_parent(id,name,seq,class,doc) values(13,'OTHER UTILITIES',13,'masterfile_ico fa fa-gears',',scheduler,schedmanager,themer')",
            ];

            //MODIFIED ACCESSES PLEASE LIST THEM HERE
            $principal_menu = "";
            $mi_menu = "";
            $tr_menu = "";
            $pr_menu = "";
            $bankrecon_menu = "";
            $SP_menu = "";
            
            //ADDED FOR MLCP ACCESSES
            $FG_menu = "";
            $FG_material = "";
            $FG_cylinder = "";
            $FG_process = "";
            $FG_colors = "";
            $mlcp_prodtype = "";
            $mlcp_transformation = "";
            $mlcp_prodspecs = "";
            $mlcp_sealing = "";
            $mlcp_plasticcolor = "";
            $mlcp_inputoutput = "";
            $mlcp_reject = "";
            $mlcp_joborder = "";
            $mlcp_productionupdate = "";
            $mlcp_mlocation = "";

            $qt_menu = "";
            $sbc_scheduler = "";
            $sbc_vr = "";
            $sbc_vc = "";
            $taxwheldmenu = "";
            $taxmenu = "";
            $s_invoicemenu = "";

            switch ($this->companyConfig()) {
                case 'MLCP':
                    $FG_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'FG','/FG/index','Finished Goods','masterfile_sub_ico fa fa-list-alt',3200)";
                    $FG_material = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'fg_material','/fg_material/index','Materials Master','masterfile_sub_ico fa fa-list-alt',3208)";
                    $FG_cylinder = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'fg_cylinder','/fg_cylinder/index','Cylinders Master','masterfile_sub_ico fa fa-list-alt',3209)";
                    $FG_process = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'fg_process','/fg_process/index','Process Master','masterfile_sub_ico fa fa-list-alt',3210)";
                    $FG_colors = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'fg_colors','/fg_colors/index','Colors Master','masterfile_sub_ico fa fa-list-alt',3211)";
                    $qt_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(3,'quotation','/quotation/index','Quotation','masterfile_sub_ico fa fa-list-alt',3212)";
                    
                    $mlcp_prodtype = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'prodtype','/prodtype/index','Product Type Master','masterfile_sub_ico fa fa-list-alt',3255)";
                    $mlcp_transformation = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'transform','/transform/index','Transformation Master','masterfile_sub_ico fa fa-list-alt',3256)";
                    $mlcp_prodspecs = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'prodspec','/prodspec/index','Product Specs Master','masterfile_sub_ico fa fa-list-alt',3257)";
                    $mlcp_sealing = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'sealing','/sealing/index','Sealing Master','masterfile_sub_ico fa fa-list-alt',3258)";
                    $mlcp_plasticcolor = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'plastic','/plastic/index','Plastic Color Master','masterfile_sub_ico fa fa-list-alt',3259)";

                    $mlcp_inputoutput= "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'inout','/inout/index','Input / Output Master','masterfile_sub_ico fa fa-list-alt',3261)";

                    $mlcp_reject = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(1,'reject','/reject/index','Reject Master','masterfile_sub_ico fa fa-list-alt',3261)";
                    
                    $mlcp_productionupdate = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(15,'JBU','/JBU/index','Production Update','masterfile_sub_ico fa fa-list-alt',3264)";
                    
                    $mlcp_joborder = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(15,'JB','/JB/index','Job Order','masterfile_sub_ico fa fa-list-alt',3263)";

                    $mi_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(3,'MI','/MI/index','Material Issuance','sales_sub_ico fa fa-tags',768)";
                    $s_invoicemenu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                     values(2,'SV','/SV/index','Supplier`s Invoice','sales_sub_ico fa fa-tags',3274)";
                    $mlcp_mlocation = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                     values(1,'mlocation','/mlocation/index','Location Master','sales_sub_ico fa fa-tags',3291)";
                    $bankrecon_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(7,'bankrecon','/bankrecon/index','Bank Reconciliation','accounting_sub_ico fa fa-circle-o',600)";
                break;

                case 'UNIVERSE':
                    $principal_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                    values(1,'principal','/principal/index','Principal','masterfile_sub_ico fa fa-file',3162)";
                    $pr_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(2,'PR','/PR/index','Purchase Requisition','purchases_sub_ico fa fa-arrow-circle-o-down',618)";
                    $mi_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(3,'MI','/MI/index','Material Issuance','sales_sub_ico fa fa-tags',768)";
                    $tr_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(4,'TR','/TR/index','Stock Transfer Request','inventory_sub_ico fa fa-table',784)";
                    $bankrecon_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(7,'bankrecon','/bankrecon/index','Bank Reconciliation','accounting_sub_ico fa fa-circle-o',600)";
                    $SP_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(2,'SP','/SP/index','Supplier Price Change','accounting_sub_ico fa fa-circle-o',3183)";
                    $taxwheldmenu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                    values(5,'TW','/TW/index','Tax Wheld','payables_sub_ico fa fa-circle-o',3100)";
                    $taxmenu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                    values(1,'taxmenu','/taxmenu/index','Tax Menu','masterfile_sub_ico fa fa-list-alt',3099);";

                    $printlogtracer = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                    values(13,'logtracer','/logtracer/index','Print Log Tracer','masterfile_sub_ico fa fa-print',3307)";

                    $transupdater = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                    values(11,'transupdate','/transupdate/index','Transaction Updater','masterfile_sub_ico fa fa-print',4001)";
                break;

                case 'GALANG':
                    $bankrecon_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                                values(7,'bankrecon','/bankrecon/index','Bank Reconciliation','accounting_sub_ico fa fa-circle-o',600)";
                break;

                case 'FHI':
                    $s_invoicemenu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                    values(2,'SV','/SV/index','Supplier`s Invoice','sales_sub_ico fa fa-tags',3274)";
                    $bankrecon_menu = "insert into left_menu (parent_id,doc,url,module,class,access) 
                    values(7,'bankrecon','/bankrecon/index','Bank Reconciliation','accounting_sub_ico fa fa-circle-o',600)";
                break;

                case 'SBC':
                    $sbc_scheduler = "insert into left_menu (parent_id,doc,url,module,class,access) 
                            values(13,'scheduler','/scheduler/index','Scheduler','masterfile_sub_ico fa fa-calendar',764)";
                    $sbc_vr = "insert into left_menu (parent_id,doc,url,module,class,access) 
                            values(13,'VR','/VR/index','Reimbursement Releasing','masterfile_sub_ico fa fa-calendar',3250)";
                    $sbc_vc = "insert into left_menu (parent_id,doc,url,module,class,access) 
                            values(13,'VC','/VC/index','Reimbursement Checking','masterfile_sub_ico fa fa-calendar',3249)";


                break;
            }//end switch

            switch ($this->companyConfig()) {
                case 'UNIVERSE':
                    $stockgrplabel = "Division Masterfile";
                    $partlabel = "Category Masterfile";
                    $modellabel = "Generic Masterfile";
                    $classlabel = "Classification List";
                    $transferlabel = "Stock Transfer";
                break;
                
                default:
                    $stockgrplabel = "Item Group Master";
                    $partlabel = "Part Master";
                    $modellabel = "Model Master";
                    $classlabel = "Item Class Master";
                    $transferlabel = "Transfer Slip";
                break;
            }//end switch


            $leftchilds = [
            //FOR MASTERFILE
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'coa','/coa/index','Chart of Accounts','masterfile_sub_ico fa fa-file',2)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'customer','/customer/index','Customer','masterfile_sub_ico fa fa-user',21)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'stockcard','/stockcard/index','Stockcard','masterfile_sub_ico fa fa-list-alt',11)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'supplier','/supplier/index','Supplier','masterfile_sub_ico fa fa-user',31)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'warehouse','/warehouse/index','Warehouse','masterfile_sub_ico fa fa-home',51)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'agent','/agent/index','Agent','masterfile_sub_ico fa fa-user',41)",
            $principal_menu,
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'model','/model/index','".$modellabel."','masterfile_sub_ico fa fa-list-alt',852)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'part','/part/index','".$partlabel."','masterfile_sub_ico fa fa-list-alt',853)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'stockgrp','/stockgrp/index','".$stockgrplabel."','masterfile_sub_ico fa fa-list-alt',3160)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'fbrmanager','/fbrmanager/index','Brand Master','masterfile_sub_ico fa fa-star',3159)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'itemclass','/itemclass/index','".$classlabel."','masterfile_sub_ico fa fa-file',3158)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'categories','/categories/index','Cust/Supp Categories Master','masterfile_sub_ico fa fa-file',3199)",
            $mlcp_transformation,$mlcp_plasticcolor,$mlcp_sealing,$mlcp_prodspecs,$mlcp_prodtype,$mlcp_inputoutput,$mlcp_reject,
            $FG_menu,$FG_colors,$FG_process,$FG_cylinder,$FG_material,$taxmenu,$mlcp_mlocation,

            //FOR PURCHASE
            $pr_menu,
            "insert into left_menu (parent_id,doc,url,module,class,access) values(2,'PO','/PO/index','Purchase Order','purchases_sub_ico fa fa-arrow-circle-o-down',62)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(2,'RR','/RR/index','Receiving Report','purchases_sub_ico fa fa-arrow-circle-o-down',78)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(2,'DM','/DM/index','Purchase Return','purchases_sub_ico fa fa-arrow-circle-o-down',97)",
            $SP_menu,$qt_menu,$s_invoicemenu,
            
            //FOR SALES
            "insert into left_menu (parent_id,doc,url,module,class,access) values(3,'SO','/SO/index','Sales Order','sales_sub_ico fa fa-tags',151)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(3,'SJ','/SJ/index','Sales Journal','sales_sub_ico fa fa-tags',168)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(3,'CM','/CM/index','Sales Return','sales_sub_ico fa fa-tags',189)",
            $mi_menu,

            //FOR INVENTORY
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'IS','/IS/index','Inventory Setup','inventory_sub_ico fa fa-table',257)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'PC','/PC/index','Physical Count','inventory_sub_ico fa fa-table',275)",
            $tr_menu,
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'TS','/TS/index','".$transferlabel."','inventory_sub_ico fa fa-table',308)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'AJ','/AJ/index','Inventory Adjustment','inventory_sub_ico fa fa-table',290)",
            $mlcp_joborder,$mlcp_productionupdate,
            //FOR PAYABLES
            "insert into left_menu (parent_id,doc,url,module,class,access) values(5,'AP','/AP/index','AP Setup','payables_sub_ico fa fa-circle-o',133)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(5,'PV','/PV/index','AP Voucher','payables_sub_ico fa fa-circle-o',370)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(5,'CV','/CV/index','Cash/Check Voucher','payables_sub_ico fa fa-circle-o',116)",
            $taxwheldmenu,

            //FOR RECEIVABLES
            "insert into left_menu (parent_id,doc,url,module,class,access) values(6,'AR','/AR/index','AR Setup','receivables_sub_ico fa fa-circle-o',239)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(6,'CR','/CR/index','Received Payment','receivables_sub_ico fa fa-circle-o',223)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(6,'KR','/KR/index','Counter Receipt','receivables_sub_ico fa fa-circle-o',208)",
            
            //"insert into left_menu (parent_id,doc,url,module,class,access) values(6,'CK','/CK/index','Post Dated Checks','receivables_sub_ico fa fa-circle-o',700)",

            //FOR ACCOUNTING
            "insert into left_menu (parent_id,doc,url,module,class,access) values(7,'GJ','/GJ/index','General Journal','accounting_sub_ico fa fa-circle-o',343)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(7,'DS','/DS/index','Deposit Slip','accounting_sub_ico fa fa-circle-o',326)",
            $bankrecon_menu,

            //FOR TRANSACTION UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'docprefix','/docprefix/index','Manage Prefixes','masterfile_sub_ico fa fa-font',599)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'terms','/terms/index','Manage Terms','masterfile_sub_ico fa fa-list',598)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'changeitem','/changeitem/index','Change Item','masterfile_sub_ico fa fa-undo',632)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'audittrail','/audittrail/index','Audit Trail','masterfile_sub_ico fa fa-list',633)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'notification','/notification/index','Unposted Transactions','masterfile_sub_ico fa fa-history',652)",
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(11,'productinquiry','javascript(0);','Product Inquiry','masterfile_sub_ico fa fa-question',796,1,'callproductinquiry')",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'ewtsetup','/ewtsetup/index','EWT Setup','masterfile_sub_ico fa fa-file',3157)",
            $printlogtracer, $transupdater,
            //FOR ACCOUNT UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access) values(12,'useraccess','/useraccess/index','Manage useraccess','masterfile_sub_ico fa fa-users',362)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(12,'branchaccess','/branchaccess/index','Branch Access','masterfile_sub_ico fa fa-institution',797)",

            //FOR OTHER UTILS
            $sbc_scheduler,
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(13,'systemanon','javascript(0);','System Announcements','masterfile_sub_ico fa fa-bullhorn',766,1,'btnmanageanon')",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(13,'themer','/themer/index','Theme Customizer','masterfile_sub_ico fa fa-star',767)",
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(13,'syslock','javascript(0);','Set System Lockdate','masterfile_sub_ico fa fa-clock-o',367,1,'btnsetsyslockdate')",
            ];

          break;

          //################################### MENUS FOR MIS ##################################################
          case 'MIS':
            $leftparents = [
            "insert into left_parent(id,name,seq,class,doc) values(1,'MASTERFILE',1,'fa fa-list-alt masterfile_ico',',coa,customer,supplier,agent,warehouse,stockcard,stockgrp,itemclass,principal,model,part,fbrmanager,categories')",
            "insert into left_parent(id,name,seq,class,doc) values(2,'PURCHASES',2,'fa fa-arrow-circle-o-down purchases_ico',',PR,PO,RR,DM')", 
            "insert into left_parent(id,name,seq,class,doc) values(3,'SALES',3,'sales_ico fa fa-tags',',SO,SJ,CM,MI')",
            "insert into left_parent(id,name,seq,class,doc) values(4,'INVENTORY',4,'inventory_ico fa fa-table',',IS,PC,AJ,TS,TR')",
            "insert into left_parent(id,name,seq,class,doc) values(11,'TRANSACTION UTILITIES',11,'masterfile_ico fa fa-gears',',docprefix,terms,changeitem,audittrail,notification')",
            "insert into left_parent(id,name,seq,class,doc) values(12,'ACCOUNT UTILITIES',12,'masterfile_ico fa fa-gears',',useraccess,branchaccess')",
            "insert into left_parent(id,name,seq,class,doc) values(13,'OTHER UTILITIES',13,'masterfile_ico fa fa-gears',',scheduler,schedmanager,themer')",
            ];


            $leftchilds = [
            //FOR MASTERFILE
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'customer','/customer/index','Customer','masterfile_sub_ico fa fa-user',21)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'stockcard','/stockcard/index','Stockcard','masterfile_sub_ico fa fa-list-alt',11)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'supplier','/supplier/index','Supplier','masterfile_sub_ico fa fa-user',31)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'warehouse','/warehouse/index','Warehouse','masterfile_sub_ico fa fa-home',51)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'agent','/agent/index','Agent','masterfile_sub_ico fa fa-user',41)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'model','/model/index','Model List','masterfile_sub_ico fa fa-list-alt',852)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'part','/part/index','Part List','masterfile_sub_ico fa fa-list-alt',853)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'stockgrp','/stockgrp/index','Item Group List','masterfile_sub_ico fa fa-list-alt',3160)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'fbrmanager','/fbrmanager/index','Brand Manager','masterfile_sub_ico fa fa-star',3159)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'itemclass','/itemclass/index','Item Class','masterfile_sub_ico fa fa-file',3158)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(1,'categories','/categories/index','Cust/Supp Category Master','masterfile_sub_ico fa fa-file',3199)",
            
            //FOR PURCHASE
            "insert into left_menu (parent_id,doc,url,module,class,access) values(2,'PO','/PO/index','Purchase Order','purchases_sub_ico fa fa-arrow-circle-o-down',62)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(2,'RR','/RR/index','Receiving Report','purchases_sub_ico fa fa-arrow-circle-o-down',78)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(2,'DM','/DM/index','Purchase Return','purchases_sub_ico fa fa-arrow-circle-o-down',97)",
            
            //FOR SALES
            "insert into left_menu (parent_id,doc,url,module,class,access) values(3,'SO','/SO/index','Sales Order','sales_sub_ico fa fa-tags',151)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(3,'SJ','/SJ/index','Sales Journal','sales_sub_ico fa fa-tags',168)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(3,'CM','/CM/index','Sales Return','sales_sub_ico fa fa-tags',189)",

            //FOR INVENTORY
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'IS','/IS/index','Inventory Setup','inventory_sub_ico fa fa-table',257)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'PC','/PC/index','Physical Count','inventory_sub_ico fa fa-table',275)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'TS','/TS/index','Transfer Slip','inventory_sub_ico fa fa-table',308)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(4,'AJ','/AJ/index','Inventory Adjustment','inventory_sub_ico fa fa-table',290)",
            
            //FOR TRANSACTION UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'docprefix','/docprefix/index','Manage Prefixes','masterfile_sub_ico fa fa-font',599)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'terms','/terms/index','Manage Terms','masterfile_sub_ico fa fa-list',598)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'changeitem','/changeitem/index','Change Item','masterfile_sub_ico fa fa-undo',632)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'audittrail','/audittrail/index','Audit Trail','masterfile_sub_ico fa fa-list',633)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'notification','/notification/index','Unposted Transactions','masterfile_sub_ico fa fa-history',652)",
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(11,'productinquiry','javascript(0);','Product Inquiry','masterfile_sub_ico fa fa-question',796,1,'callproductinquiry')",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(11,'ewtsetup','/ewtsetup/index','EWT Setup','masterfile_sub_ico fa fa-file',3157)",

            //FOR ACCOUNT UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access) values(12,'useraccess','/useraccess/index','Manage useraccess','masterfile_sub_ico fa fa-users',362)",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(12,'branchaccess','/branchaccess/index','Branch Access','masterfile_sub_ico fa fa-institution',797)",

            //FOR OTHER UTILS
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(13,'systemanon','javascript(0);','System Announcements','masterfile_sub_ico fa fa-bullhorn',766,1,'btnmanageanon')",
            "insert into left_menu (parent_id,doc,url,module,class,access) values(13,'themer','/themer/index','Theme Customizer','masterfile_sub_ico fa fa-star',767)",
            "insert into left_menu (parent_id,doc,url,module,class,access,ismodalmenu,modalclass) values(13,'syslock','javascript(0);','Set System Lockdate','masterfile_sub_ico fa fa-clock-o',367,1,'btnsetsyslockdate')",
            ];
          break;
        }//END SWITCH
        
        foreach ($leftparents as $key => $value) {
            if($value != ''){
                $status = Yii::$app->sbccommon->execqry($value);
            }//end if
        }//end for each

        foreach ($leftchilds as $key => $value) {
            if($value != ''){
                Yii::$app->sbccommon->execqry($value);
            }//end if
        }//end for each

        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'TENPLUS':
                $qry1 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                        values(11,'tpshipping','/tpshipping/index','TP Shipping Fees','masterfile_sub_ico fa fa-file',3246)";
                Yii::$app->sbccommon->execqry($qry1);

                $qry2 = "insert into left_menu (parent_id,doc,url,module,class,access) 
                        values(11,'tphandling','/tphandling/index','TP Handling Fees','masterfile_sub_ico fa fa-file',3247)";
                Yii::$app->sbccommon->execqry($qry2);
            break;
        }//end switch 

        switch ($systype) {
            case 'AIMS': case 'MIS':
                if($this->enablePOSModules()){
                    $this->managePOSMenus('insert');
                }else{
                    $this->managePOSMenus('remove');
                }//end if
            break;
        }//end switch
    }//end function
   
    public function getSystemLockdate(){
    //GETS SYSTEM LOCKDATE
      $qry = "select pvalue from profile where doc = 'SYSL'";
      return Yii::$app->sbccommon->datareader($qry);
    }//end if

    public function defaultSystemImage(){
    //GETS DEFAULT SYSTEM IMAGE / LOGO
        return Yii::$app->homeUrl . 'fimages/inventee/png/placeholder.png';
    }//end function

    public function defaultEditableEntries(){
        return 20;
    }//end function

    public function setDefaultTimeZone(){
      //SETS DEFAULT TIME ZONE ** REQUIRED **
      date_default_timezone_set('Asia/Singapore');
    }//end function

    public function getCurrentTimeStamp(){
      //SETS DEFAULT TIME ZONE ** REQUIRED **
      $this->setDefaultTimeZone();
      $current_timestamp = date('Y-m-d H:i:s');
      return $current_timestamp;
    }//end function

    //returns system version
    public function systemVersion(){
        if(isset($_ENV['VERSION'])){
            return $_ENV['VERSION'];
        }else{
            return 'Unverified Release';
        }//end if
    }//end function 

    //sets frontend details / fields on backend (AIMS / MIS / AMS)
    //set true to allow / show details
    //sets false to hide details
    public function enableFrontendDetails_Backend(){
        return false;
    }//end fn

    //SETS FRONTEND ONLY and disables backend = 1
    //SETS FRONTEND ONLY with enabled backend = 0
    public function setfrontendOnly(){
        return 0;
    }//end fn

    public function setFrontendBackendRedirection(){
      //0 - will directly redirect to admin/login (BACKEND)
      //1 - will still show frontpage / ecomm / or any frontend modules
      return 0;
    }//end function
    
    //sets company configuration for frontend
    public function companyfrontendConfig(){
      //CODE - CONFIG ## NOTE
      //BUYMORE - BUYMORE.COM.PH (E-COMMERCE) (FOR STEAM MARKETING)
      //SBC - (DEFAULT COMPANY WEBSITE) (FOR SBC)
      //XTZ - xtzbusiness.ph (company website)

      $companyconfig = 'SBC';
      return $companyconfig;
    }//end function 

    //sets addtional configs for companies / clients (can be connected with companyConfig())
    public function addedConfig(){
        //FHI_LOCAL = local setting for FHI
        //FHI_CLOUD = cloud setting for FHI
        return 'FHI_LOCAL';
    }///end fn

    //sets company configuration (for backend)
    public function companyConfig(){ //COMPANY SETTING
        //CODE      - CONFIGNAME ## NOTE
        //DEFAULT   - DEFAULT SETTING

        //KINGGEORGE
        //PANDATOOLS
        //UNIVERSE
        //CANUMAY
        //TENPLUS
        //INDUSTRIA
        //GAMELINE_POS
        //MEGASTEE
        //TONRENTANG
        //MLCP (MULTICENTER SETTING)
        
        if(isset($_ENV['RELEASE'])){
            $companyconfig = $_ENV['RELEASE'];
        }else{
            $companyconfig = 'DEFAULT';
        }//end if

        switch ($companyconfig) {
            case 'MLCP':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Right Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'Mandaue Libertad Flexible Packaging Incorporated',
                'report_contact' => 'Tel #: (032)345-0635/(032)345-0133 / Fax #: (032)346-1719',
                'report_address' => 'Mandaue City, Cebu'];
            break;

            case 'FHI':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'FHI',
                'login_info' => 'Right Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'Filmon Hardware',
                'report_contact' => 'Tel No 253-0093  253-1493 253-1494  234-2070',
                'report_address' => ''];
            break;

            case 'UNIVERSE':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'Universe Pharmacy',
                'topheader_mini' => 'SSSC',
                'login_info' => Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'Universe Pharmacy',
                'report_contact' => 'Tel no. (032) 253-0146, 253-4819 , 412-3250, 412-3414',
                'report_address' => '366 Magallanes St., Cebu City'];
            break;


            case 'PANDATOOLS':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'PJRegico Hardware',
                'topheader_mini' => 'PJR',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'PJRegico Hardware',
                'report_contact' => 'Tel.: 242-9357 / 254-9436 / 09175314456 / 09178358565',
                'report_address' => '24 Bituan St., Brgy Dona Imelda, Quezon City'];
            break; 

            case 'CANUMAY':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'KANUMAY METAL CORPORATION',
                'report_contact' => '+63(2)-292-21-85 / +63(2)-292-39-36 / +63(2)-292-21-80',
                'report_address' => '6 S. Donesa St. Brgy Canumay West, Valenzuela City Metro Manila, Philippines, 1443'];
            break;

            case 'KINGGEORGE':
                if(isset(Yii::$app->session['king_db_set'])){
                    switch (Yii::$app->session['king_db_set']){
                         case md5(1):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;
                        
                        case md5(2):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(3):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(4):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(5):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(6):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(7):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(8):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(9):
                            Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;

                        case md5(10):
                           Yii::$app->session['sysconfig'] = [
                            'topheader' => 'HGC2',
                            'topheader_mini' => 'House Gem Construction Elements Corporation',
                            'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                            'report_companyname' => 'HOUSE GEM',
                            'report_contact' => '0928 318 8243 / 0917 500 9162',
                            'report_address' => '173 FR Bagbaguin Road, Bagbaguin Meycauayan Bulacan'];
                        break;
                    }//end switch
                }//end 
            break;

            case 'TENPLUS':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'TENPLUS AUTO SUPPLY CORPORATION',
                'report_contact' => '(02) 716-1686 / 714-2014',
                'report_address' => '50 Kapiligan St. Brgy Doña Imelda Quezon City'];
            break;
            
            //BISMAC ACCOUNT
            case 'INDUSTRIA':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'INDUSTRIA EDITION GALLERY, INC.',
                'report_contact' => 'Mobile Nos. 0917-6281928 Globe / 0939-9361922 Smart<br>Email : gallery@industriaedition.com <br>galleryinfo@industriaedition.com',
                'report_address' => 'ML-05 G/F The Residences at Greenbelt,Ayala Center, Makati City'];
            break;

            case 'GAMELINE_POS':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'ALL WHOLE FOODS',
                'topheader_mini' => 'AWF',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'ALL DAY WHOLE FOODS CORPORATION',
                'report_contact' => 'Tel no. 635-8112 / Fax: 727-5917',
                'report_address' => '9 Campanilla Street Barangay Mariana, New Manila Quezon City'];
            break;

            case 'MEGASTEEL':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'SOLUTIONBASE CORPORATION',
                'report_contact' => '411-8881 / 785-5539',
                'report_address' => '255-B Brgy. Santol G. Araneta Quezon City, Philippines'];
            break;

            case 'TONRENTANG':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'TON REN TANG CHINESE DRUG STORE',
                'report_contact' => 'Tel. No.#  733-7835 / Fax. No # 733-7869',
                'report_address' => '800-D Grandara St., Sta.Cruz, Manila'];
            break;

            case 'SBC':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'SOLUTIONBASE CORPORATION',
                'report_contact' => '411-8881 / 785-5539',
                'report_address' => '255-B Brgy. Santol G. Araneta Quezon City, Philippines'];
            break;

            case 'GALANG':
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'GALANG',
                'topheader_mini' => 'GLG',
                'login_info' => 'Right Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'SOLUTIONBASE CORPORATION',
                'report_contact' => '411-8881 / 785-5539',
                'report_address' => '255-B Brgy. Santol G. Araneta Quezon City, Philippines'];
            break;
            
            default:
            Yii::$app->session['sysconfig'] = [
                'topheader' => 'AIMS Online',
                'topheader_mini' => 'SBC',
                'login_info' => 'Version ' . Yii::$app->systemsettings->systemVersion(),
                'report_companyname' => 'SOLUTIONBASE CORPORATION',
                'report_contact' => '411-8881 / 785-5539',
                'report_address' => '255-B Brgy. Santol G. Araneta Quezon City, Philippines'];
            break;
        }//end switch case

        return $companyconfig;
    }//end function company config

    public function resellerConfig(){
    //FOR DEFAULT => DEFAULT
    //FOR JOY / CEBU => JOYCEBU
    $reseller = 'JOYCEBU'; //<= just change this one automatic changing will apply per reseller
    
        switch ($reseller) {
            case 'BISMAC':
                Yii::$app->session['ownerconfig'] = [
                'footer_info' => '<strong><a href="#">Bismac Systems</a></strong> All rights reserved.',
                'companyname' => 'BMC'];
            break;

            case 'JOYCEBU':
                Yii::$app->session['ownerconfig'] = [
                    'footer_info' => '<strong><a href="#">Right System</a></strong> All rights reserved.',
                    'companyname' => 'RSSC'];
            break;

            default:
                Yii::$app->session['ownerconfig'] = [
                    'footer_info' => '<strong>Copyright &copy <a href="www.solutionbasecorp.com">Solutionbase Corp</a></strong> All rights reserved.',
                    'companyname' => 'SBC'];
            break;
        }//end switch case
        
    return $reseller;
    }//end function

    public function setCenterSelection(){
    //(NOTE: MUST HAVE CENTER ON CENTER TABLE WITH 001 CODE)
    // false => TURNS OFF CENTER SELECTION INSTEAD IT AUTOMATICALLY SELECTS CENTER TO 001     
    // true => TURNS ON CENTER SELECTION (NOTE: APPLIES MANUAL CENTER SELECTION PER USER)
    switch (Yii::$app->systemsettings->companyConfig()) {
        case 'MLCP': case 'GALANG':
            return true;
        break;
        
        default:
            return false;
        break;
    }//end switch case
    }//end function set center selection

    public function setDecimaldisplay($type){
        //SETS DEFAULT DECIMAL DISPLAY ON STOCK
        switch ($type) {
            //#################### BACKEND DECIMAL DISPLAY
            case 'currency':
                if(isset($_ENV['DECIMAL_CURRENCY'])){
                    return $_ENV['DECIMAL_CURRENCY'];
                }else{
                    return 2;
                }//end if
            break;

            case 'unitprice':
                if(isset($_ENV['DECIMAL_UNITPRICE'])){
                    return $_ENV['DECIMAL_UNITPRICE'];
                }else{
                    return 2;
                }//end if
            break;
            
            case 'kgs':
                if(isset($_ENV['DECIMAL_KGS'])){
                    return $_ENV['DECIMAL_KGS'];
                }else{
                    return 2;
                }//end if
            break;

            case 'quantity':
                if(isset($_ENV['DECIMAL_QUANTITY'])){
                    return $_ENV['DECIMAL_QUANTITY'];
                }else{
                    return 2;
                }//end if
            break;

            //#################### FRONTEND DECIMAL DISPLAY
            case 'fcurrency':
                if(isset($_ENV['DECIMAL_FRONTEND_CURRENCY'])){
                    return $_ENV['DECIMAL_FRONTEND_CURRENCY'];
                }else{
                    return 2;
                }//end if
            break;

            case 'fquantity':
                if(isset($_ENV['DECIMAL_FRONTEND_QUANTITY'])){
                    return $_ENV['DECIMAL_FRONTEND_QUANTITY'];
                }else{
                    return 2;
                }//end if
            break;

            case 'wholenumber':
                return 1;
            break;
        }//end switch case
    }//end function

    public function setDefaultCenterCode(){ //RETURNS DEFAULT CENTER 
        $defaultcenter = '001';
        $qry = "select code from center where code = '".$defaultcenter."'";
        $code = Yii::$app->sbccommon->datareader($qry);

        if(empty($code)){
        $error = 'ERROR J101: Error centercode not found on database, Please advice IT Personel';
        $code = '';
        }else{
        $error = '';
        }//end f

        return array('code'=>$code,'error'=>$error);
    }//end function

    //SETS DEFAULT BARCODE LENGTH OF THE SYSTEM
    public function setDefaultBarcodeLength(){
        //DEFAULT - 15
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'YULICK': // PARANAQUE
                return 13;
            break;

            case 'INFINITEA': case 'RTT': case 'SOUTHCENTRAL': case 'TENPLUS': 
            case 'PANDATOOLS': case 'UNIVERSE': case 'MLCP':
            case 'KINGGEORGE': case 'FHI':
                return 0;
            break;
            
            case 'TONRENTANG':
                return 7;
            break;

            case 'NEWTIANLE': //VALENZUELA
                return 15;
            break;
              
            default:
                return 15;
            break;
        }//end switch
    }//end function

    //SETS DEFAULT CLIENT LENGTH OF THE SYSTEM
    public function setDefaultClientLength(){
    //DEFAULT - 15
    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'YULICK': case 'RTT':
        return 13;
        break;

      case 'INFINITEA':
        return 15;
        break;

      case 'NEWTIANLE': //VALENZUELA
        return 7;
        break;
      
      default:
        return 15; //THIS IS FOR DEFAULT COUNT FOR AIMS
        //return 0; //THIS IS FOR EMPLOYEE
        break;
    }//end switch
    }//end function

    //SETS DEFAULT DOCUMENT LENGTH OF THE SYSTEM
    public function setDefaultDocumentLength(){
    //DEFAULT - 15
    //PARANAQUE [christy] = 15
    //INFINITEA = 15
    //NEWTIANLE = 15
    switch (Yii::$app->systemsettings->companyConfig()) {
      case 'YULICK': //PARANAQUE
        return 15;
        break;

      case 'INFINITEA': 
        return 15;
        break;

      case 'NEWTIANLE': //VALENZUELA
        return 15;
        break;

      case 'DAVIDSALON_JOY': case 'GAMELINE_POS'://VALENZUELA
        return 20;
        break;

      case 'SOUTHCENTRAL': //VALENZUELA
        return 15;
        break;
      
      default:
        return 15;
        break;
    }//end switch
    }//end function

    //SETS DEFAULT EMAIL WHERE A CLIENT WILL RECEIVE EMAIL FROM THIS SYSTEM
    //REQUIRED SETTINGS FOR EMAIL
    public function requestDefaultReceivingEmail(){
        return "sales@xtzbusiness.ph";
    }//end request default email

    //SETS AN EMAIL SENDER FROM SERVER YOUR CONNECTING TO (CAN BE SET TO A DEFAULT DOMAIN EMAIL OR REMOTE EMAIL ACCOUNT)
    //YOU NEED TO SET SETTING ON SWIFTMAILER FIRST BEFORE CHANGING THIS ONE 
    //BEWARE ~...~ 
    //REQUIRED SETTINGS FOR EMAIL ** REQUIRED **
    public function requestDefaultEmailSender(){ 
        switch ($this->companyfrontendConfig()) {
            case 'XTZ':
                return "xtz_no_reply@xtzbusiness.ph";
            break;

            default:
                return "sbc_no_reply@sbc.ph";
            break;
        }//end switch
    }//end request default email

    public function requestDefaultEmailSenderName(){
        switch ($this->companyfrontendConfig()) {
            case 'XTZ':
                return "XTZ Enterprises";
            break;
            
            case 'SBC':
                return "SOLUTIONBASE CORPORATION";
            break;

            default:
                return "Anonymous";
            break;
        }//end switch
    }//end request default email

    public function setBranchAccess(){ 
        //set 1 to enable branch
        //set 0 to disable branch
        if(isset($_ENV['ENABLE_BRANCHADD'])){
            return $_ENV['ENABLE_BRANCHADD'];
        }else{
            return 0;
        }//end if
    }//backendfunction

    public function invoiceItemLimit(){
        //DEFAULT = 0
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'INFINITEA':
              return 18;
            break;

            case 'RTT':
              return 13;
            break;

            default:
              return 0;
            break;
        }//end switch
    }//end function

    public function enableFixedAsset(){
      //set 1 to enable fixed asset and 0 to disable
      return 0;
    }//end function

    public function querySearchLimit(){
        //QUERY LIMITER FOR SEARCH MODALS / QUERIES WITH MANY DATA
        if(isset($_ENV['QUERY_LIMITER'])){
            return $_ENV['QUERY_LIMITER'];
        }else{
            return 100;
        }//end if
    }//end
}// COMPONENTS

?>
