<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\BackendAsset;
use backend\assets\DefaultThemeAsset;
use backend\assets\MacAsset;
use backend\assets\RedLightAsset;
use backend\assets\BluePandaAsset;
use backend\assets\GreyAsset;
use backend\assets\StarbucksAsset;
use backend\assets\XTwitterAsset;
use backend\assets\InstagramAsset;
use backend\assets\CoderAsset;
use yii\helpers\Html;

$asset = BackendAsset::register($this);

switch (Yii::$app->session['loggeduser']['theme']) {
    case 'MAC':
    $asset2 = MacAsset::register($this);
        break;

    case 'PANDATOOLS':
    $asset2 = BluePandaAsset::register($this);
        break;

    case 'GENLIGHT':
    $asset2 = RedLightAsset::register($this);
        break;

    case 'RTT':
    $asset2 = GreyAsset::register($this);
        break;

    case 'STARBUCKS':
    $asset2 = StarbucksAsset::register($this);
        break;

    case 'XTWITTER':
    $asset2 = XTwitterAsset::register($this);
        break;

    case 'INSTAGRAM':
    $asset2 = InstagramAsset::register($this);
        break;

    case 'CODER':
    $asset2 = CoderAsset::register($this);
        break;

    default:
    $asset2 = DefaultThemeAsset::register($this);
    break;
}//switch case

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
<!-- LIST OF THEMES
BLACK 
BLACK-LIGHT
BLUE
BLUE-LIGHT
-GREEN
GREEN-LIGHT
PURPLE
PURPLE-LIGHT
RED
RED-LIGHT
YELLOW
YELLOW
YELLOW-LIGHT
JUST CHANGE SKIN GREEN TO SKIN-"THEMENAME"
-->
<?php
if(Yii::$app->session['layoutminimized']){
    $class="sidebar-collapse";
}else{
    $class="";
}//end if 

switch (Yii::$app->session['loggeduser']['theme']) {
    case 'MAC': 
    echo '<body class="hold-transition skin-black-light sidebar-mini '.$class.'">';
        break;

    case 'RTT': 
    echo '<body class="hold-transition skin-black-light sidebar-mini '.$class.'">';
        break;

    case 'PANDATOOLS':
    echo '<body class="hold-transition skin-blue sidebar-mini '.$class.'">';
        break;

    case 'GENLIGHT':
    echo '<body class="hold-transition skin-red sidebar-mini '.$class.'">';
        break;

    case 'STARBUCKS':
    echo '<body class="hold-transition skin-green sidebar-mini '.$class.'">';
        break;

    case 'XTWITTER':
    echo '<body class="hold-transition skin-black sidebar-mini '.$class.'">';
        break;

    case 'INSTAGRAM':
    echo '<body class="hold-transition skin-purple sidebar-mini '.$class.'">';
        break;

    case 'CODER':
    echo '<body class="hold-transition skin-black sidebar-mini '.$class.'">';
        break;
                        
    default:
    echo '<body class="hold-transition skin-green sidebar-mini '.$class.'">';
        break;
}//end switch case
?>

<?php $this->beginBody() ?>

<div class="wrapper">

<?php
include_once("topbar.php");
include_once("leftside.php");
?>

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div id="overlay"></div>
        <section class="content-header">
        <?= $content ?>
        </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
/*include_once("footer.php");*/
include_once("rightside.php");
?>
</div>

<?php 
include_once("modals/module-modals/modal_calendar_anon.php");
include_once("modals/module-modals/item_lookup.php");
include_once("modals/module-modals/change_frontendlogo.php");
include_once("modals/module-modals/show_itembalance.php");

$module = $this->params['moduleid'];
switch ($module) { // SWITCH CASE FOR MODALS
    
    case 'changeitem':
    include_once("modals/module-modals/brand_lookup.php");
    include_once("modals/module-modals/part_lookup.php");
    include_once("modals/module-modals/model_lookup.php");
    include_once("modals/module-modals/class_lookup.php");
    include_once("modals/module-modals/body_lookup.php");
    include_once("modals/module-modals/size_lookup.php");
    include_once("modals/module-modals/category_lookup.php");
    include_once("modals/module-modals/group_lookup.php");
    break;

    case 'coa':
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/modal_alias_coa.php");
    break;

    case 'branchmasterfile':
    include_once("modals/module-modals/warehouse_lookup.php");
    break;

    case 'reportlist':
    include_once("modals/module-modals/customer_lookup.php");
    include_once("modals/module-modals/supplier_lookup.php");
    include_once("modals/module-modals/agent_lookup.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/area_lookup.php");
    include_once("modals/module-modals/region_lookup.php");
    include_once("modals/module-modals/province_lookup.php");
    include_once("modals/module-modals/compref_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/modal-centers.php");
    include_once("modals/module-modals/brand_lookup.php");
    include_once("modals/module-modals/part_lookup.php");
    include_once("modals/module-modals/model_lookup.php");
    include_once("modals/module-modals/class_lookup.php");
    include_once("modals/module-modals/body_lookup.php");
    include_once("modals/module-modals/size_lookup.php");
    include_once("modals/module-modals/category_lookup.php");
    include_once("modals/module-modals/group_lookup.php");
    include_once("modals/module-modals/user_lookup.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/category2_lookup.php");
    include_once("modals/module-modals/bref_lookup.php");
    include_once("modals/module-modals/compgroup_lookup.php");
    include_once("modals/module-modals/yourref_lookup.php");
    include_once("modals/module-modals/yourref2_lookup.php");
    include_once("modals/module-modals/yulickourref_lookup.php");
    include_once("modals/module-modals/yulickourref_lookup2.php");
    break;

    // COMPANY GROUP
    case 'comprefix':
    include_once("modals/module-modals/comprefgroup_lookup.php");
    break;
    
    case 'SO':
    //SBC EXCLUSIVES UPDATE
    //include_once("modals/module-modals/modal_so_note_form.php");
    include_once("modals/module-modals/modal_agentlookup.php");
    include_once("modals/reports/modulereport/module-SO.php");
    include_once("modals/module-modals/multiple_void.php");
    include_once("modals/module-modals/customer_lookup.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/location_lookup.php");
    include_once("modals/module-modals/administrator_pass.php");
        break;

    case 'SJ': case 'CM':
    switch($module){
            case 'SJ':
        include_once("modals/reports/modulereport/module-SJ.php");
            break;
            case 'CM':
        include_once("modals/reports/modulereport/module-CM.php");  
            break;
        }
    include_once("modals/module-modals/modal_agentlookup.php");
    include_once("modals/module-modals/customer_lookup.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/module_accounts.php");
    switch ($module) {
        case 'SJ':
            include_once("modals/module-modals/administrator_pass.php");
            break;
    }//end switch 
    include_once("modals/module-modals/pickup_PO.php");
    include_once("modals/module-modals/location_lookup.php");
    include_once("modals/module-modals/modal_acctg.php");
    include_once("modals/module-modals/modal_pricehistory.php");
        break;


    case 'TS':
    // SALON MODIFICATION
    include_once("modals/module-modals/pickup_TR.php");
    // END SALON
    include_once("modals/reports/modulereport/module-TS.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/location_lookup.php");
        break;

    case 'RR': case 'DM': case 'PO': case 'PR':
    switch($module){
            case 'RR':
                include_once("modals/reports/modulereport/module-RR.php");
                include_once("modals/module-modals/modal_acctg.php");
            break;
            case 'DM':
                include_once("modals/reports/modulereport/module-DM.php");  
                include_once("modals/module-modals/modal_acctg.php");
            break;
            case 'PO':
                include_once("modals/module-modals/multiple_void.php");
                include_once("modals/reports/modulereport/module-PO.php");  
            break;
            case 'PR':
                include_once("modals/reports/modulereport/module-PR.php");  
            break;
        }
    include_once("modals/module-modals/pickup_PO.php");
    include_once("modals/module-modals/supplier_lookup.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/location_lookup.php");
    include_once("modals/module-modals/modal_pricehistory.php");
    include_once("modals/module-modals/administrator_pass.php");
        break;

    case 'IS': case 'AJ':
    
        switch($module){
            case 'IS':
        include_once("modals/reports/modulereport/module-IS.php");
            break;
            case 'AJ':
        include_once("modals/reports/modulereport/module-AJ.php");  
            break;
        }
        
    include_once("modals/reports/modulereport/module-IS.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/location_lookup.php");
    include_once("modals/module-modals/modal_acctg.php");
        break; 

    case 'PC':
    include_once("modals/reports/modulereport/module-PC.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/location_lookup.php");
        break;

    //########################################################## GJ UPDATE JAOSKI
    case 'GJ':  case 'AP': case 'AR':

        switch($module){
            case 'GJ':
            include_once("modals/reports/modulereport/module-GJ.php");
            break;

            case 'AP':
            include_once("modals/reports/modulereport/module-AP.php");
            break;

            case 'AR':
            include_once("modals/reports/modulereport/module-AR.php");
            break;
        }

    include_once("modals/module-modals/document_lookup.php");
    include_once("modals/module-modals/modal-unpaidaccounts.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/module_logs.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/enter_coa.php");
    include_once("modals/module-modals/modal_checks.php");
    include_once("modals/module-modals/detail_clientlookup.php");
        break;

    case 'CR': case 'KR':
    switch($module){
            case 'CR':
            include_once("modals/reports/modulereport/module-CR.php");
            break;

            case 'KR':
            include_once("modals/reports/modulereport/module-KR.php");
            break;
    }

    include_once("modals/module-modals/document_lookup.php");
    include_once("modals/module-modals/modal-unpaidaccounts.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/module_logs.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/enter_coa.php");
    include_once("modals/module-modals/modal_checks.php");
    include_once("modals/module-modals/customer_lookup.php");
    include_once("modals/module-modals/modal_pdcchecks.php");
        break;
    case 'CK':
    include_once("modals/module-modals/customer_lookup.php");

    break;
    case 'PV': 
    include_once("modals/reports/modulereport/module-PV.php");
    include_once("modals/module-modals/document_lookup.php");
    include_once("modals/module-modals/modal-unpaidaccounts.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/module_logs.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/enter_coa.php");
    include_once("modals/module-modals/modal_checks.php");
    include_once("modals/module-modals/supplier_lookup.php");
        break;

    case 'CV': 
    include_once("modals/reports/modulereport/module-CV.php");
    include_once("modals/module-modals/document_lookup.php");
    include_once("modals/module-modals/modal-unpaidaccounts.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/module_logs.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/enter_coa.php");
    include_once("modals/module-modals/modal_checks.php");
    include_once("modals/module-modals/supplier_lookup.php");
        break;

    case 'DS': 
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
    //########################################################## GJ UPDATE JAOSKI
        
    
    //########################################################## CUSTOMER UPDATE JEEEAAAARRRRRR
    case 'customer':
        include_once("modals/module-modals/modal-unpaidaccounts.php");
        include_once("modals/reports/modulereport/module-CUSTOMER.php");
        include_once("modals/module-modals/customer_lookup.php");
        include_once("modals/module-modals/show_terms.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/modal_agentlookup.php");
        include_once("modals/module-modals/area_lookup.php");
        include_once("modals/module-modals/clientgroup_lookup.php");
        include_once("modals/module-modals/clientcategory_lookup.php");
        include_once("modals/module-modals/area_lookup.php");
        include_once("modals/module-modals/region_lookup.php");
        include_once("modals/module-modals/province_lookup.php");
        include_once("modals/module-modals/pickup_PO.php");
        include_once("modals/module-modals/client_distributionarea.php");
        include_once("modals/module-modals/client_collectionarea.php");
        break;

    case 'employee':    
        include_once("modals/module-modals/employee_lookup.php");
        include_once("modals/module-modals/module_logs.php");
        break;    

    case 'supplier':
        include_once("modals/module-modals/modal-unpaidaccounts.php");
        include_once("modals/reports/modulereport/module-SUPPLIER.php");
        include_once("modals/module-modals/supplier_lookup.php");
        include_once("modals/module-modals/show_terms.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/area_lookup.php");
        include_once("modals/module-modals/clientgroup_lookup.php");
        include_once("modals/module-modals/clientcategory_lookup.php");
        include_once("modals/module-modals/region_lookup.php");
        include_once("modals/module-modals/province_lookup.php");
        break;   

    case 'agent':
        include_once("modals/reports/modulereport/module-AGENT.php");
        include_once("modals/module-modals/agent_lookup.php");
        include_once("modals/module-modals/show_terms.php");
        include_once("modals/module-modals/module_logs.php");
        include_once("modals/module-modals/area_lookup.php");
        include_once("modals/module-modals/clientgroup_lookup.php");
        include_once("modals/module-modals/clientcategory_lookup.php");
        include_once("modals/module-modals/region_lookup.php");
        include_once("modals/module-modals/province_lookup.php");
        break;
        
    case 'warehouse':
        include_once("modals/reports/modulereport/module-WAREHOUSE.php");
        include_once("modals/module-modals/clientwarehouse_lookup.php");
        include_once("modals/module-modals/module_logs.php");
        break;    

    //KEYWORD LOCATION&VENDOR 

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

//END KEYWORD LOCATION&VENDOR          

    case 'stockcard':
        include_once("modals/reports/modulereport/module-STOCKCARD.php");
        include_once("modals/module-modals/module_accounts.php");
        include_once("modals/module-modals/brand_lookup.php");
        include_once("modals/module-modals/part_lookup.php");
        include_once("modals/module-modals/model_lookup.php");
        include_once("modals/module-modals/class_lookup.php");
        include_once("modals/module-modals/body_lookup.php");
        include_once("modals/module-modals/size_lookup.php");
        include_once("modals/module-modals/category_lookup.php");
        include_once("modals/module-modals/group_lookup.php");
        include_once("modals/module-modals/clientwarehouse_lookup.php");
        include_once("modals/module-modals/module_logs.php");
        //include_once("modals/module-modals/show_itembalance.php");
        include_once("modals/module-modals/warehouse_lookup.php");
        include_once("modals/module-modals/show_stockcarduom.php");
        include_once("modals/module-modals/frontend_itemtagging.php");
        break;  

    case 'frontendlogs':
        include_once("modals/module-modals/administrator_pass.php");
    break;  

    case 'scheduler':
        include_once("modals/module-modals/modal_calendar_reminders.php");
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
        include_once("modals/module-modals/modal_calendar_schedlisting.php");
        include_once("modals/module-modals/customer_lookup.php");
        include_once("modals/module-modals/user_lookup.php");
        include_once("modals/module-modals/module_logs.php");
    break;  

    case 'docprefix':
        include_once("modals/module-modals/module_logs.php");
    break;

    case 'fbrmanager':
        include_once("modals/module-modals/fbr_addnewbrand.php");
    break;

    case 'fhighlights':
        //include_once("modals/module-modals/item_lookup.php");
        include_once("modals/module-modals/fhighlights_add.php");
        include_once("modals/module-modals/frontend_managehighlights.php");
    break;

    case 'managefdeals':
        include_once("modals/module-modals/frontend_flashdealsaleprice.php");
    break;

    case 'PI':
    include_once("modals/reports/modulereport/module-PI.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/warehouse_lookup.php");
        break; 

    case 'PD':
    include_once("modals/reports/modulereport/module-PD.php");
    include_once("modals/module-modals/customer_lookup.php");
    include_once("modals/module-modals/document_lookup.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/location_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
        break;  

    case 'PK':
    include_once("modals/reports/modulereport/module-PK.php");
    include_once("modals/module-modals/document_lookup.php");
    //include_once("modals/module-modals/item_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    //include_once("modals/module-modals/show_itembalance.php");
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
    //include_once("modals/module-modals/item_lookup.php");
        break; 

    case 'itemprofile':
        //include_once("modals/module-modals/item_lookup.php");
        include_once("modals/module-modals/fa_lookup.php"); 
        include_once("modals/module-modals/generalitem_lookup.php"); 
        include_once("modals/module-modals/supplier_lookup.php");
        include_once("modals/module-modals/employee_lookup.php");
    break;        

    case 'managedod':
        //include_once("modals/module-modals/item_lookup.php");
        include_once("modals/module-modals/frontend_dodsetprice.php");
    break;   


    // SALON MODIFICATION

    case 'TR':
    include_once("modals/reports/modulereport/module-TR.php");
    include_once("modals/module-modals/document_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/location_lookup.php");
    break;

    case 'MI': 
    include_once("modals/module-modals/clientwarehouse_lookup.php");
    include_once("modals/reports/modulereport/module-MI.php");
    include_once("modals/module-modals/modal_agentlookup.php");
    include_once("modals/module-modals/customer_lookup.php");
    include_once("modals/module-modals/document_lookup.php");
    include_once("modals/module-modals/enter_item_qty.php");
    include_once("modals/module-modals/item_quickadd.php");
    include_once("modals/module-modals/module_logs.php");
    include_once("modals/module-modals/show_terms.php");
    include_once("modals/module-modals/warehouse_lookup.php");
    include_once("modals/module-modals/module_accounts.php");
    include_once("modals/module-modals/location_lookup.php");
    include_once("modals/module-modals/modal_acctg.php");
    include_once("modals/module-modals/modal_pricehistory.php");
        break;

    // END SALON       
         

    default:
        break;
}//END SWITCH
?>


<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
