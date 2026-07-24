<?php
$this->title = 'Asset Master';
$datetoday = date("Y-m-d");
$date = strtotime($datetoday .' -6 months');
$finaldate=date('Y-m-d', $date);
?>
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="clientid" name ="clientid" class="moduletxt" value="<?php echo  $assetdata['clientid']; ?>">

        <div class="col-md-12">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">

                  <b><h6 class="txtclientid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Client ID: <?php if(isset($assetdata)){echo $assetdata['clientid'];} ?></h6></b>

                  <div class="pull-right">
                      <div class="btn-group">
                      <?php if(!empty($assetdata['clientid'])){?>
                        <button type="button" data-toggle="tooltip" title="New Customer" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        <button type="button" data-toggle="tooltip" title="Save Customer" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                         <?php
                            echo'<button type="button" data-toggle="tooltip" title="Edit Customer" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>';
                         ?>
                        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> Print</b></button>

                         <?php
                          echo'<button type="button" data-toggle="tooltip" title="Delete Customer" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>';
                         ?>

                        <button type="button" data-toggle="tooltip" title="Customer Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>

                        <!-- <button type="button" data-toggle="tooltip" title="Unpaid" class="btn btn-default btn-success headbtn client-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> Unpaid</b></button>

                        <button type="button"  data-toggle="tooltip" title="Orders" class="btn btn-default btn-success headbtn client-orders"><b><i class="fa fa-tags order_btn"></i> Orders</b></button> -->


                       <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>

                      <?php }else{ ?>

                        <button type="button" data-toggle="tooltip" title="New Customer" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        <button type="button" data-toggle="tooltip" title="Save Customer" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Edit Customer" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>
                        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> Print</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Delete Customer" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Customer Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
                        <!-- <button disabled="true" type="button"  data-toggle="tooltip" title="Unpaid" class="btn btn-default btn-success headbtn client-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> Unpaid</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Orders" class="btn btn-default btn-success headbtn client-orders"><b><i class="fa fa-tags order_btn"></i> Orders</b></button> -->
                        

                       <button disabled="true" id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button disabled="true" id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button disabled="true"id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button disabled="true" id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                        <!-- <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="fa fa-minus"></i></button> -->
                       <?php } ?>
                        </div>
                       </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                  <div class="box-body">
                    <div class="pull-right" style="margin-top:-15px;">
                    </div>
                    <div class="invoice-info col-md-12" style="margin-left:-15px;">
                        <div class="invoice-col col-md-3">
                            <h6 class="aimslabel"><b>Asset Code:  
                                <div class="input-group">
                                    <input name="client" value ="<?= $assetdata['client'] ?>" type="text" class="moduletxt txtclient input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>
                            <h6 class="aimslabel" style="display:block;">
                                <b>Description: <input name="clientname" value ="<?= $assetdata['clientname'] ?>" type="text" class="moduletxt txtclientnameview form-control input-sm" disabled="true"></b>
                            </h6>
                            <h6 class="aimslabel">
                                <b>Notes: <textarea  disabled="true" name="rem" class="moduletxt txtclientnotes form-control" style="resize:none;" rows="3" cols="50"><?= $assetdata['rem'] ?></textarea></b>
                            </h6>
                            <h6 class="aimslabel"><b>Category:
                                <div class="input-group">
                                    <input name="category2" value ="<?= $assetdata['category2'] ?>" disabled='true' type="text" class="moduletxt txtclientcategory2 input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="category2lookup" style='display:none;' href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>
                        </div><!-- /.col -->
                        <div class="invoice-col col-md-3">
                            <h6 class="aimslabel"><b>Location:
                                <div class="input-group">
                                    <input name="location" value ="<?= $assetdata['location'] ?>" type="text" disabled='true' class="moduletxt txtclientloc input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="locationlookup" style='display:none;' href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>
                            <h6 class="aimslabel"><b>Acquired Date:
                                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                                    <input id="xdateid" type="text" name='acquireddate' readonly="" value="<?= $assetdata['acquireddate'] ?>" size="12" class="form-control moduletxt txtacquireddate input-sm" >
                                    <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div></b>
                            </h6>
                            <h6 class="aimslabel"><b>Warranty Expiry:
                                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                                    <input id="xdateid" type="text" name='warrantexpiry' readonly="" value="<?= $assetdata['warrantexpiry'] ?>" size="12" class="form-control moduletxt txtwarrantexpiry input-sm" >
                                    <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div></b>
                            </h6>
                            <h6 class="aimslabel"><b>In Service Date:
                                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                                    <input id="xdateid" type="text" readonly="" name='servicedate' value="<?= $assetdata['servicedate'] ?>" size="12" class="form-control moduletxt txtservicedate input-sm" >
                                    <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div></b>
                            </h6>
                            <h6 class="aimslabel"><b>Sold/Disposal Date:
                                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                                    <input id="xdateid" type="text" readonly="" name='solddisposeddate' value="<?= $assetdata['solddisposeddate'] ?>" size="12" class="form-control moduletxt txtsolddisposeddate input-sm" >
                                    <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div></b>
                            </h6>
                        </div><!-- /.col -->
                        <div class="invoice-col col-md-3">
                            <h6 class="aimslabel" style="display:block;">
                                <b>Year: <input name="year" value ="<?= $assetdata['year'] ?>" type="text" class="moduletxt txtassetyear form-control input-sm" disabled="true"></b>
                            </h6>
                            <h6 class="aimslabel" style="display:block;">
                                <b>Make: <input name="make" value ="<?= $assetdata['make'] ?>" type="text" class="moduletxt txtassetmake form-control input-sm" disabled="true"></b>
                            </h6>
                            <h6 class="aimslabel" style="display:block;">
                                <b>Model: <input name="model" value ="<?= $assetdata['model2'] ?>" type="text" class="moduletxt txtassetmodel form-control input-sm" disabled="true"></b>
                            </h6>
                            <h6 class="aimslabel" style="display:block;">
                                <b>Color: <input name="color" value ="<?= $assetdata['color'] ?>" type="text" class="moduletxt txtassetcolor form-control input-sm" disabled="true"></b>
                            </h6>
                            <h6 class="aimslabel" style="display:block;">
                                <b>Motor No.: <input name="motorno" value ="<?= $assetdata['motorno'] ?>" type="text" class="moduletxt txtassetmotorno form-control input-sm" disabled="true"></b>
                            </h6>
                        </div><!-- /.col -->
                        <div class="invoice-col col-md-3">
                            <h6 class="aimslabel" style="display:block;">
                                <b>Serial No.: <input name="serialno" value ="<?= $assetdata['serialno'] ?>" type="text" class="moduletxt txtassetserialno form-control input-sm" disabled="true"></b>
                            </h6>
                            <h6 class="aimslabel"><b>Renewal Date:
                                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                                    <input id="xdateid" type="text" name='renewaldate' readonly="" value="<?= $assetdata['renewaldate'] ?>" size="12" class="form-control moduletxt txtrenewaldate input-sm" >
                                    <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div></b>
                            </h6>
                            <h6 class="aimslabel" style="display:block;">
                                <b>Insurer: <input name="insurer" value ="<?= $assetdata['insurer'] ?>" type="text" class="moduletxt txtassetinsurer form-control input-sm" disabled="true"></b>
                            </h6>
                            <h6 class="aimslabel" style="display:block;">
                                <b>Insurance Policy: <input name="insurancepol" value ="<?= $assetdata['insurancepol'] ?>" type="text" class="moduletxt txtinsurancepol form-control input-sm" disabled="true"></b>
                            </h6>
                            <div style='display:block;'>
                                <input type="checkbox" id='chkassetinactive' class='moduletxt' disabled='true' <?php if($assetdata['IsInactive'] == 1) {echo "checked";} ?> name="inactive" style='margin-top:25px;'>
                                <label for='chkassetinactive' class='aimslabel'><b>&nbsp;&nbsp;Inactive</b></label>
                            </div>
                        </div><!-- /.col -->
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div><!-- 

    <div class="row">
        <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs bg-green">
                  <li id="" class=""><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Tab 1</a></li>
                  <li id="" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Tab 2</a></li>
                </ul>



                <div class="tab-content">
                    <div class="tab-pane" id="tab_1">
                    </div>
                    <div class="tab-pane " id="tab_2">
                    </div>
                </div>
            </div>
        </div>
    </div> -->

