<?php
use yii\base\ErrorException;
$this->title = 'Branch Ledger';

$script = <<< JS
    $(document).ready(function(){ 
        $('.branchwhtab').click();
    });
JS;
$this->registerJs($script);

switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF

try {
?>
<div class="row">
    <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="clientid" name="clientid" class="moduletxt" value="<?php echo $branchdata['clientid']; ?>">
    <div class="col-md-12">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                <b><h6 class="txtclientid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Branch ID: <?php if(isset($branchdata)){echo $branchdata['clientid'];} ?></h6></b>
                <div class="pull-right">
                    <div class="btn-group">
                        <?php if(!empty($branchdata['clientid'])) { ?>
                            <button title="New Customer" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                            <button title="Save Customer" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                            <button title="Edit Customer" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>
                            <button title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                            <button title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> Print</b></button>
                            <button title="Delete Customer" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                            <button title="Customer Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
                            <button id="<?php echo $moduleid.'-btnnavfirst';?>" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                            <button id="<?php echo $moduleid.'-btn-navprev';?>" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                            <button id="<?php echo $moduleid.'-btnnavnext';?>" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                            <button id="<?php echo $moduleid.'-btnnavlast';?>" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                        <?php } else { ?>
                            <button title="New Customer" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                            <button title="Save Customer" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                            <button title="Edit Customer" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>
                            <button title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                            <button disabled="true" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> Print</b></button>
                            <button disabled="true" title="Delete Customer" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                            <button disabled="true" title="Customer Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
                            <button disabled="true" id="<?php echo $moduleid.'-btnnavfirst';?>" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                            <button disabled="true" id="<?php echo $moduleid.'-btn-navprev';?>" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                            <button disabled="true" id="<?php echo $moduleid.'-btnnavnext';?>" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                            <button disabled="true" id="<?php echo $moduleid.'-btnnavlast';?>" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                        <?php } ?>
                    </div>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="invoice-info col-md-12" style="margin-left:-15px;">
                    <div class="invoice-col col-md-4">
                        <h6 class="aimslabel"><b>Branch:
                            <div class="input-group">
                                <input name="client" value="<?php if(isset($branchdata)){echo $branchdata['client'];}?>" type="text" class="moduletxt txtclient input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                            </div>
                        </h6>

                        <h6 class="aimslabel" style="display:block;"><b>Name:
                            <input name="clientname" value ="<?php if(isset($branchdata)){echo $branchdata['clientname'];}?>" type="text" class="moduletxt txtclientnameview form-control input-sm" disabled="true"></b>
                        </h6>
                        <h6 class="aimslabel"><b>Address:
                            <textarea  disabled="true" name="addr" class="moduletxt txtclientaddress input-sm form-control" style="resize:none;" rows="1" cols="50"><?php if(isset($branchdata)){echo $branchdata['addr'];}?></textarea></b>
                        </h6>

                        <h6 class="aimslabel"><b>TIN #:
                            <input type="text" name="tin" class="moduletxt txtbranchtin form-control input-sm" disabled="true" value="<?php if(isset($branchdata)){ echo $branchdata['tin']; } ?>">
                        </h6>
                    </div><!-- /.col -->
                    <div class="invoice-col col-md-4">
                        <h6 class="aimslabel"><b>
                            <input disabled="true" name = "iscustomer" style="margin-left:7px;margin-top:20px;" class ="checkedisallitems clientboxes" type="checkbox" <?php if(isset($branchdata)){if($branchdata['isallitems'] == 1){echo "checked";}}?>>
                            <label>All Item</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input disabled="true" name = "iscustomer" style="margin-left:7px;" class ="checkedisallwh clientboxes" type="checkbox" type="checkbox" <?php if(isset($branchdata)){if($branchdata['isallwh'] == 1){echo "checked";}}?>>
                            <label>All Warehouse</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input disabled="true" name="issynctobranch" style="margin-left:7px;margin-top:20px;" class="checkedissyncbranch clientboxes" type="checkbox" <?php if(isset($branchdata)) {if($branchdata['issyncbranch'] == 1) {echo "checked";}} ?>
                            <label>Sync to branch</label>
                        </b></h6>

                        <h6 class="aimslabel"><b>Notes:
                            <textarea disabled="true" name="rem" class="moduletxt txtbranchnotes form-control" style="resize:none" rows="1" cols="50"><?php if(isset($branchdata)) { echo $branchdata['rem']; } ?></textarea>
                        </b></h6>
                        <h6 class="aimslabel"><b>Tel No.:
                            <input type="text" name="tel" class="moduletxt txtbranchtel form-control input-sm" disabled="true" value="<?php if(isset($branchdata)) { echo $branchdata['tel']; } ?>">
                        </b></h6>
                        <h6 class="aimslabel"><b>Fax No.:
                            <input type="text" name="fax" class="moduletxt txtbranchfax form-control input-sm" disabled="true" value="<?php if(isset($branchdata)) { echo $branchdata['fax']; } ?>">
                        </b></h6>
                    </div><!-- /.col -->
                    <div class="invoice-col col-md-4">
                        <h6 class="aimslabel"><b>Mobile No.:
                            <input type="text" name="mobile" class="moduletxt txtbranchmobile form-control input-sm" disabled="true" value="<?php if(isset($branchdata)){ echo $branchdata['tel2']; } ?>">
                        </b></h6>
                        <h6 class="aimslabel"><b>Email:
                            <input type="text" name="email" class="moduletxt txtbranchemail form-control input-sm" disabled="true" value="<?php if(isset($branchdata)){ echo $branchdata['email']; } ?>">
                        </b></h6>
                        <h6 class="aimslabel"><b>Contact Person:
                            <input type="text" name="contact" class="moduletxt txtbranchcontact form-control input-sm" disabled="true" value="<?php if(isset($branchdata)){ echo $branchdata['contact']; } ?>">
                        </b></h6>
                        <h6 class="aimslabel branchbank" style='display:none;'><b>Bank:
                            <div class="input-group">
                                <input name="acno" value="<?php if(isset($branchdata)){echo $branchdata['acno'];}?>" disabled="true" readonly="true" type="text" class="moduletxt txtbranchacno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="branchcontralookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                            </div>
                        </h6>
                        <h6 class="aimslabel branchbankview"><b>Bank:
                                <input type="text" name="acnoview" class="moduletxt txtbranchacnoview input-sm form-control" disabled="true" type="text" value="<?php if(isset($branchdata)){echo $branchdata['acno'];} ?>">
                            </b>
                        </h6>
                    </div><!-- /.col -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
                <li><a href="#tab_1" class="branchwhtab branchtabs" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Warehouse</a></li>
                <li><a href="#tab_2" class="branchstationtab branchtabs" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Station</a></li>
                <li><a href="#tab_3" class="branchbrandstab branchtabs" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Brands</a></li>
                <li><a href="#tab_4" class="branchagentstab branchtabs" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Agents</a></li>
                <li><a href="#tab_5" class="branchuserstab branchtabs" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Users</a></li>
                <li><a href="#tab_6" class="branchbanktab branchtabs" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Bank Terminal</a></li>
                <li><a href="#tab_7" class="tablestab tablestabs" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Tables</a></li>
            </ul>
            <div class="tab-content branchtabconts">
                <div class="tab-pane" id="tab_1">
                    <button class="btn btn-flat btn-md btn-success btnnewbranchwh">Add New</button>
                    <div class="branchwhdiv" style='margin-bottom:20px;'></div>
                </div>

                <div class="tab-pane" id="tab_2">
                    <button class="btn btn-flat btn-md btn-success btnnewbranchstation">Add New</button>
                    <div class="branchstationdiv" style='margin-bottom:20px;'></div>
                </div>

                <div class="tab-pane" id="tab_3">
                    <button class="btn btn-flat btn-md btn-success btnnewbranchbrand">Add New</button>
                    <div class="branchbrandsdiv" style='margin-bottom:20px;'></div>
                </div>

                <div class="tab-pane" id="tab_4">
                    <button class="btn btn-flat btn-md btn-success btnnewbranchagent">Add New</button>
                    <div class="branchagentsdiv" style='margin-bottom:20px;'></div>
                </div>

                <div class="tab-pane" id="tab_5">
                    <button class="btn btn-flat btn-md btn-success btnnewbranchuser">Add New</button>
                    <div class="branchusersdiv" style='margin-bottom:20px;'></div>
                </div>

                <div class="tab-pane" id="tab_6">
                    <button class="btn btn-flat btn-md btn-success btnnewbranchbank">Add New</button>
                    <div class="branchbankdiv" style='margin-bottom:20px;'></div>
                </div>

                <div class="tab-pane" id="tab_7">
                    <button class="btn btn-flat btn-md btn-success btnnewtables">Add New</button>
                    <div class="tablesdiv" style='margin-bottom:20px;'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    
} catch (ErrorException $e) {
    echo $e;
}
?>