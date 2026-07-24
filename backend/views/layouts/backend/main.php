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
if(Yii::$app->session['layoutminimized']) { $class="sidebar-collapse"; } else { $class=""; }
switch (Yii::$app->session['loggeduser']['theme']) {
    case 'MAC':  echo '<body class="hold-transition skin-black-light sidebar-mini '.$class.'">'; break;
    case 'RTT':  echo '<body class="hold-transition skin-black-light sidebar-mini '.$class.'">'; break;
    case 'PANDATOOLS': echo '<body class="hold-transition skin-blue sidebar-mini '.$class.'">'; break;
    case 'GENLIGHT': echo '<body class="hold-transition skin-red sidebar-mini '.$class.'">'; break;
    default: echo '<body class="hold-transition skin-green sidebar-mini '.$class.'">'; break;
}
?>
<?php $this->beginBody() ?>
<style type="text/css">
    .panel{
    margin-bottom: 0px;
}
.chat-window{
    bottom:0;
    position:fixed;
    float:right;
    margin-left:10px;
}
.chat-window > div > .panel{
    border-radius: 5px 5px 0 0;
}
.icon_minim{
    padding:2px 10px;
}
.msg_container_base{
  background: #e5e5e5;
  margin: 0;
  padding: 0 10px 10px;
  max-height:300px;
  overflow-x:hidden;
}
.top-bar {
  background: #666;
  color: white;
  padding: 10px;
  position: relative;
  overflow: hidden;
}
.msg_receive{
    padding-left:0;
    margin-left:0;
}
.msg_sent{
    padding-bottom:20px !important;
    margin-right:0;
}
.messages {
  background: white;
  padding: 10px;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  max-width:100%;
}
.messages > p {
    font-size: 13px;
    margin: 0 0 0.2rem 0;
  }
.messages > time {
    font-size: 11px;
    color: #ccc;
}
.msg_container {
    padding: 10px;
    overflow: hidden;
    display: flex;
}
img {
    display: block;
    width: 100%;
}
.avatar {
    position: relative;
}
.base_receive > .avatar:after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border: 5px solid #FFF;
    border-left-color: rgba(0, 0, 0, 0);
    border-bottom-color: rgba(0, 0, 0, 0);
}

.base_sent {
  justify-content: flex-end;
  align-items: flex-end;
}
.base_sent > .avatar:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 0;
    border: 5px solid white;
    border-right-color: transparent;
    border-top-color: transparent;
    box-shadow: 1px 1px 2px rgba(black, 0.2); // not quite perfect but close
}

.msg_sent > time{
    float: right;
}



.msg_container_base::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

.btn-group.dropup{
    position:fixed;
    left:0px;
    bottom:0;
}
</style>
<div class="wrapper">
    <?php
        include_once("topbar.php");
        include_once("leftside.php");
    ?>
    <div class="content-wrapper">
        <div id="overlay" style='z-index:99999;'></div>
        <section class="content-header">
            <?= $content ?>
        </section>
    </div>
    <?php
    echo '<div class="container" style="display:none;">
    <div class="row chat-window col-xs-6 col-md-4" id="chat_window_1" style="margin-left:10px;">
        <div class="col-xs-12 col-md-12 pull-right ">
            <div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - Miguel</h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                        <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                    </div>
                </div>
                <div class="panel-body msg_container_base">
                    <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10">
                            <div class="messages msg_sent">
                                <p>that mongodb thing looks good, huh?
                                tiny master db, and huge document store</p>
                                <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                        <div class="col-md-10 col-xs-10">
                            <div class="messages msg_receive">
                                <p>that mongodb thing looks good, huh?
                                tiny master db, and huge document store</p>
                                <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                        <div class="col-xs-10 col-md-10">
                            <div class="messages msg_receive">
                                <p>that mongodb thing looks good, huh?
                                tiny master db, and huge document store</p>
                                <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_sent">
                        <div class="col-xs-10 col-md-10">
                            <div class="messages msg_sent">
                                <p>that mongodb thing looks good, huh?
                                tiny master db, and huge document store</p>
                                <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                        <div class="col-xs-10 col-md-10">
                            <div class="messages msg_receive">
                                <p>that mongodb thing looks good, huh?
                                tiny master db, and huge document store</p>
                                <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10 ">
                            <div class="messages msg_sent">
                                <p>that mongodb thing looks good, huh?
                                tiny master db, and huge document store</p>
                                <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>';
    ?>
</div>
<?php 
include_once("modals/module-modals/change_frontendlogo.php");
include_once("modals/module-modals/modal_unpostedtrans.php");
include_once("modals/module-modals/modal_transmonth.php");
include_once("modals/module-modals/modal_tsched.php");

$module = $this->params['moduleid'];
switch ($module) {
    case 'manageitem':
        include_once("modals/module-modals/createmenu.php");
        include_once("modals/module-modals/updatemenu.php");
        include_once("modals/module-modals/setmenuchoicesmodal.php");
    break;

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
    
    case 'SP':
          include_once("modals/reports/modulereport/module-SP.php");
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
        include_once("modals/module-modals/modal-reportlist.php");
    break;

    case 'comprefix':
        include_once("modals/module-modals/comprefgroup_lookup.php");
    break;
        
    case 'JBU':
        include_once("modals/module-modals/view_fgudetails_modal.php");
    break;
    
    case 'SO':
        include_once("modals/reports/modulereport/module-SO.php");
    break;


    case 'quotation': 
        include_once("modals/reports/modulereport/module-QT.php");
    break;
    
    //WTODO: [KIM][2019.10.06][modal for JO printout]
    case 'JB':
        include_once("modals/reports/modulereport/module-JB.php");
    break;
    
    // WTODO JAD 03-15-2019
    case 'SJ': case 'CM':
        switch($module){
            case 'SJ':
                include_once("modals/reports/modulereport/module-SJ.php");
                include_once("modals/module-modals/sj_comm_modal.php");
                include_once("modals/module-modals/administrator_pass.php");
                include_once("modals/module-modals/modal_so_note_form.php");
            break;

            case 'CM': 
                include_once("modals/reports/modulereport/module-CM.php"); 
            break;
        }//end switch
        
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
        switch (Yii::$app->systemsettings->companyConfig()) {
            case 'MLCP':
                include_once("modals/reports/modulereport/module-CV-mlcp.php");
            break;

            default:
                include_once("modals/reports/modulereport/module-CV.php");
            break;
        }//END switch
    break;

    case 'DS': 
        include_once("modals/reports/modulereport/module-DS.php");
    break;

    case 'TW': 
        include_once("modals/reports/modulereport/module-TW.php");
        include_once("modals/module-modals/taxmenu_lookup.php");
        include_once("modals/module-modals/modal-quarters.php");
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

        case 'scheduler': // WTODO JAD 06-03-2019
        // include_once("modals/module-modals/modal_calendar_reminders.php");
        include_once("modals/module-modals/modal_calendar_notecomment.php");
        include_once("modals/module-modals/modal_calendar_projectlookup.php");
        include_once("modals/module-modals/modal_calendar_projects.php");
        include_once("modals/module-modals/modal_calendar_timeinlist.php");
        include_once("modals/module-modals/modal_calendar_schedulelookup.php");
        include_once("modals/module-modals/modal_calendar_viewscheds.php");
        // include_once("modals/module-modals/modal_calendar_createevent.php");
        // include_once("modals/module-modals/modal_calendar_eventupdate.php");
        include_once("modals/module-modals/modal_calendar_eventproperties.php");
        include_once("modals/module-modals/modal_calendar_eventcomments.php");
        include_once("modals/module-modals/modal_calendar_notes.php");
        // WTODO JAD 06-03-2019
        include_once("modals/module-modals/modal_calendar_schedlisting.php");
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
}//end switch


?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
