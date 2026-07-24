<?php
use backend\assets\BackendAsset;
use backend\assets\DefaultThemeAsset;
use backend\assets\MacAsset;
use backend\assets\RedLightAsset;
use backend\assets\BluePandaAsset;
use backend\assets\GreyAsset;
use yii\helpers\Html;

$asset = BackendAsset::register($this);

switch (Yii::$app->session['loggeduser']['theme']) {
    case 'MAC': $asset2 = MacAsset::register($this); break;
    case 'PANDATOOLS': $asset2 = BluePandaAsset::register($this); break;
    case 'GENLIGHT': $asset2 = RedLightAsset::register($this); break;
    case 'RTT': $asset2 = GreyAsset::register($this); break;
    default: $asset2 = DefaultThemeAsset::register($this); break;
}
$baseUrl = $asset->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
<?php
$class="sidebar-collapse"; 
switch (Yii::$app->session['loggeduser']['theme']) {
    case 'MAC':  echo '<body class="hold-transition skin-black-light sidebar-mini '.$class.'">'; break;
    case 'RTT':  echo '<body class="hold-transition skin-black-light sidebar-mini '.$class.'">'; break;
    case 'PANDATOOLS': echo '<body class="hold-transition skin-blue sidebar-mini '.$class.'">'; break;
    case 'GENLIGHT': echo '<body class="hold-transition skin-red sidebar-mini '.$class.'">'; break;
    default: echo '<body class="hold-transition skin-green sidebar-mini '.$class.'">'; break;
}
?>
<?php $this->beginBody() ?>
<div class="wrapper">
    <?php
        include_once("postopbar.php");
    ?>
    <div class="content-wrapper">
        <div id="overlay" style='z-index:99999;'></div>
        <section class="content-header">
            <?= $content ?>
        </section>
    </div>
</div>
<?php 
include_once("modals/module-modals/change_frontendlogo.php");
// include_once("modals/module-modals/new_pass.php");
$module = $this->params['moduleid'];
switch ($module) {
    case 'extractor':
        include_once("modals/module-modals/warehouse_lookup.php");
    break;

    case 'TX':
        include_once("modals/reports/modulereport/module-TX2.php"); 
        include_once("modals/reports/modulereport/module-TX.php");   
        include_once("modals/module-modals/document_lookup.php");   
        include_once("modals/module-modals/route_lookup.php");
        include_once("modals/module-modals/pickup_PO.php");
        include_once("modals/module-modals/module_logs.php");
    break;
    
    case 'RF':
        include_once("modals/reports/modulereport/module-RF.php");
        include_once("modals/module-modals/document_lookup.php");   
        include_once("modals/module-modals/modal_agentlookup.php");
        include_once("modals/module-modals/route_lookup.php");
        include_once("modals/module-modals/pickup_PO.php");
        include_once("modals/module-modals/module_logs.php");
    break;

    case 'KL':
        include_once("modals/module-modals/modal_agentlookup.php");
        include_once("modals/module-modals/customer_lookup.php");
        include_once("modals/module-modals/modal-unpaidaccounts.php");
        include_once("modals/reports/modulereport/module-KL.php");
    break;

    case 'coa':
        // include_once("modals/module-modals/module_accounts.php");
        // include_once("modals/module-modals/modal_alias_coa.php");
    break;

    case 'branchmasterfile':
        include_once("modals/module-modals/warehouse_lookup.php");
    break;

    case 'reportlist':
        include_once("modals/module-modals/reportroute_lookup.php");
        include_once("modals/module-modals/modal-costcenters.php");
        include_once("modals/module-modals/model_lookup.php");
        include_once("modals/module-modals/body_lookup.php");
        include_once("modals/module-modals/size_lookup.php");
        include_once("modals/module-modals/category2_lookup.php");
        include_once("modals/module-modals/bref_lookup.php");
        include_once("modals/module-modals/compgroup_lookup.php");
        include_once("modals/module-modals/yourref_lookup.php");
        include_once("modals/module-modals/yourref2_lookup.php");
        include_once("modals/module-modals/yulickourref_lookup.php");
        include_once("modals/module-modals/yulickourref_lookup2.php");
        include_once("modals/module-modals/assetcategory_lookup.php");
    break;

    case 'comprefix':
        include_once("modals/module-modals/comprefgroup_lookup.php");
    break;
    
    case 'SO':
        include_once("modals/reports/modulereport/module-SO.php");
    break;

    case 'SJ': case 'CM':
        switch($module){
            case 'SJ': include_once("modals/reports/modulereport/module-SJ.php"); include_once("modals/module-modals/administrator_pass.php"); break;
            case 'CM': include_once("modals/reports/modulereport/module-CM.php"); break;
        }
        include_once("modals/module-modals/modal_pricehistory.php");
        include_once("modals/module-modals/sc_sj_receivetab.php");
        include_once("modals/module-modals/sc_sj_postdeliverytab.php");
        include_once("modals/module-modals/sc_sj_dispatchdiscrepancytab.php");
        include_once("modals/module-modals/sc_sj_dispatchconfirmationtab.php");
        include_once("modals/module-modals/sc_sj_settledtab.php");
    break;

    case 'SOApproval':
        include_once("modals/module-modals/soa_lookup.php");    
    break;

    case 'TS':
        include_once("modals/reports/modulereport/module-TS.php");
    break;

    case 'RR': case 'DM': case 'PO': case 'PR':
        switch($module){
            case 'RR': include_once("modals/reports/modulereport/module-RR.php"); break;
            case 'DM': include_once("modals/reports/modulereport/module-DM.php"); break;
            case 'PO': include_once("modals/reports/modulereport/module-PO.php"); break;
            case 'PR': include_once("modals/reports/modulereport/module-PR.php"); break;
        }
        include_once("modals/module-modals/modal_pricehistory.php");
    break;

    case 'IS': case 'AJ':
        switch($module){
            case 'IS': include_once("modals/reports/modulereport/module-IS.php"); break;
            case 'AJ': include_once("modals/reports/modulereport/module-AJ.php"); break;
        }
        include_once("modals/reports/modulereport/module-IS.php");
    break;

    case 'PC':
        include_once("modals/reports/modulereport/module-PC.php");
    break;

    case 'GJ':  case 'AP': case 'AR':
        switch($module){
            case 'GJ': include_once("modals/reports/modulereport/module-GJ.php"); break;
            case 'AP': include_once("modals/reports/modulereport/module-AP.php"); break;
            case 'AR': include_once("modals/reports/modulereport/module-AR.php"); break;
        }
    break;

    case 'CR': case 'KR':
        switch($module){
            case 'CR': include_once("modals/reports/modulereport/module-CR.php"); break;
            case 'KR': include_once("modals/reports/modulereport/module-KR.php"); break;
        }
    break;

    case 'CK':
        include_once("modals/module-modals/customer_lookup.php");
    break;
    
  
    case 'QA':
        include_once("modals/reports/modulereport/module-QA.php");
    break;
    
    case 'MX': 
        include_once("modals/reports/modulereport/module-MI.php");
    break;
    
    case 'SP':
        include_once("modals/module-modals/pickup_PO.php");
        include_once("modals/module-modals/supplier_lookup.php");
        include_once("modals/module-modals/document_lookup.php");
        include_once("modals/module-modals/enter_item_qty.php");
        include_once("modals/module-modals/item_quickadd.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/show_terms.php");
        include_once("modals/module-modals/warehouse_lookup.php");
        include_once("modals/module-modals/module_accounts.php");
        include_once("modals/module-modals/location_lookup.php");
        include_once("modals/module-modals/modal_pricehistory.php");
        include_once("modals/module-modals/administrator_pass.php");
        include_once("modals/module-modals/modal_acctg.php");
        include_once("modals/module-modals/show_linked_documents.php");
    break;

    case 'PV':
        include_once("modals/reports/modulereport/module-PV.php");
    break;

    case 'CV': 
        include_once("modals/reports/modulereport/module-CV.php");
    break;

    case 'DS': 
        include_once("modals/reports/modulereport/module-DS.php");
    break;

    case 'TW': 
        include_once("modals/reports/modulereport/module-TW.php");
        include_once("modals/module-modals/document_lookup.php");
        include_once("modals/module-modals/taxmenu_lookup.php");
        include_once("modals/module-modals/supplier_lookup.php");
    break;    

    case 'TA': 
        include_once("modals/module-modals/employee_lookup.php");
        include_once("modals/module-modals/faitem_lookup.php");
    break;

    case 'customer':
        include_once("modals/reports/modulereport/module-CUSTOMER.php");
    break;

    case 'employee':    
        include_once("modals/module-modals/employee_lookup.php");
        include_once("modals/module-modals/module_logs.php");
    break;    

    case 'supplier':
        include_once("modals/reports/modulereport/module-SUPPLIER.php");
    break;   

    case 'agent':
        include_once("modals/reports/modulereport/module-AGENT.php");
    break;
        
    case 'warehouse':
        include_once("modals/reports/modulereport/module-WAREHOUSE.php");
    break;

    case 'location':
        include_once("modals/reports/modulereport/module-LOC.php");
        include_once("modals/module-modals/loc_lookup.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/region_lookup.php");
    break;

    case 'vendor':
        include_once("modals/reports/modulereport/module-VENDOR.php");
        include_once("modals/module-modals/vendor_lookup.php");
        include_once("modals/module-modals/show_terms.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/area_lookup.php");
        include_once("modals/module-modals/region_lookup.php");
        include_once("modals/module-modals/province_lookup.php");
    break;

    case 'stockcard':
        include_once("modals/reports/modulereport/module-STOCKCARD.php");
    break;

    case 'commission':
        include_once("modals/module-modals/commission_lookup.php");
    break;
    
    case 'frontendlogs':
        include_once("modals/module-modals/administrator_pass.php");
    break;  

    case 'scheduler':
        // include_once("modals/module-modals/modal_calendar_reminders.php");
        include_once("modals/module-modals/modal_calendar_notecomment.php");
        include_once("modals/module-modals/modal_calendar_projectlookup.php");
        include_once("modals/module-modals/modal_calendar_projects.php");
        include_once("modals/module-modals/modal_calendar_timeinlist.php");
        include_once("modals/module-modals/modal_calendar_schedulelookup.php");
        include_once("modals/module-modals/modal_calendar_viewscheds.php");
        include_once("modals/module-modals/modal_calendar_createevent.php");
        include_once("modals/module-modals/modal_calendar_eventupdate.php");
        include_once("modals/module-modals/modal_calendar_eventproperties.php");
        include_once("modals/module-modals/modal_calendar_eventcomments.php");
        include_once("modals/module-modals/modal_calendar_notes.php");
        // include_once("modals/module-modals/modal_calendar_schedlisting.php");
        // include_once("modals/module-modals/customer_lookup.php");
        // include_once("modals/module-modals/user_lookup.php");
        include_once("modals/module-modals/module_logs.php");
    break;  

    case 'docprefix':
        include_once("modals/module-modals/module_logs.php");
    break;

    case 'fbrmanager':
        include_once("modals/module-modals/fbr_addnewbrand.php");
    break;

    case 'fhighlights':
        include_once("modals/module-modals/fhighlights_add.php");
        include_once("modals/module-modals/frontend_managehighlights.php");
    break;

    case 'managefdeals':
        include_once("modals/module-modals/frontend_flashdealsaleprice.php");
    break;

    case 'PI':
        include_once("modals/reports/modulereport/module-PI.php");
        include_once("modals/module-modals/document_lookup.php");
        include_once("modals/module-modals/enter_item_qty.php");
        include_once("modals/module-modals/item_quickadd.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/warehouse_lookup.php");
    break;

    case 'PD':
        include_once("modals/reports/modulereport/module-PD.php");
        include_once("modals/module-modals/customer_lookup.php");
        include_once("modals/module-modals/document_lookup.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/warehouse_lookup.php");
        include_once("modals/module-modals/location_lookup.php");
        include_once("modals/module-modals/enter_item_qty.php");
    break;

    case 'PK':
        include_once("modals/reports/modulereport/module-PK.php");
        include_once("modals/module-modals/document_lookup.php");
        include_once("modals/module-modals/enter_item_qty.php");
        include_once("modals/module-modals/item_quickadd.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/show_terms.php");
        include_once("modals/module-modals/warehouse_lookup.php");
        include_once("modals/module-modals/module_accounts.php");
        include_once("modals/module-modals/location_lookup.php");
        include_once("modals/module-modals/modal_acctg.php");
    break;

    case 'bankrecon': 
        include_once("modals/reports/modulereport/module-DS.php");
        include_once("modals/module-modals/document_lookup.php");
        include_once("modals/module-modals/modal-unpaidaccounts.php");
        include_once("modals/module-modals/show_terms.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/module_accounts.php");
        include_once("modals/module-modals/enter_coa.php");
        include_once("modals/module-modals/modal_checks.php");
        include_once("modals/module-modals/supplier_lookup.php");
    break;

    case 'lanemanager': 
        include_once("modals/module-modals/frontend_createsubcat.php");
        include_once("modals/module-modals/frontend_managecat.php");
        include_once("modals/module-modals/frontend_managelane.php");
        include_once("modals/module-modals/arrange_lanes.php");
    break;

    case 'itemprofile':
        include_once("modals/module-modals/fa_lookup.php"); 
        include_once("modals/module-modals/generalitem_lookup.php"); 
        include_once("modals/module-modals/supplier_lookup.php");
        include_once("modals/module-modals/employee_lookup.php");
    break;

    case 'managedod':
        include_once("modals/module-modals/frontend_dodsetprice.php");
    break;

    case 'TR':
        include_once("modals/reports/modulereport/module-TR.php");
    break;

    case 'MI': 
        include_once("modals/reports/modulereport/module-MI.php");
    break;

    case 'termgroup':
        include_once("modals/module-modals/maingroup_lookup.php");
        include_once("modals/module-modals/show_terms.php");
    break;

    case 'categorygroup':
        include_once("modals/module-modals/termgroup_lookup.php");
    break;

    case 'subcatgroup':
        include_once("modals/module-modals/categorygroup_lookup.php");
    break;

    case 'assetmaster':
        include_once("modals/module-modals/customer_lookup.php");
        include_once("modals/module-modals/category_location_lookup.php");
    break;

    default:
    
    break;
}
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
