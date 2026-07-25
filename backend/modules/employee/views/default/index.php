<?php
$this->title = 'Employee Ledger';
$datetoday = date("Y-m-d");
$date = strtotime($datetoday .' -6 months');
$finaldate=date('Y-m-d', $date);
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="empid" name ="empid" class="moduletxt" value="<?php echo  $customerdata['empid']; ?>">

        <div class="col-md-12">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">

                  <b><h6 class="txtempid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Employee ID: <?php if(isset($customerdata)){echo $customerdata['empid'];} ?></h6></b>

                  <div class="pull-right">
                      <div class="btn-group">
                      <?php if(!empty($customerdata['empid'])){?>
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
                        <button disabled="true" type="button"  data-toggle="tooltip" title="Unpaid" class="btn btn-default btn-success headbtn client-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> Unpaid</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Orders" class="btn btn-default btn-success headbtn client-orders"><b><i class="fa fa-tags order_btn"></i> Orders</b></button>
                        

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

                            <div class="invoice-col col-md-2">
                                <h6 class="aimslabel picbox">
                                  <?php if(isset($customerdata)){
                                     if(empty($customerdata['picture'])){
                                       $str = Yii::$app->homeUrl.'fimages/inventee/png/placeholder.png';    
                                     }else{
                                     $str = $customerdata['picture'];
                                     }
                                   }else{
                                     $str = Yii::$app->homeUrl.'fimages/inventee/png/placeholder.png';    
                                   }
                                  ?>
                                  <img src ="<?php echo $str;?>" width="160px" height ="150px" class="thumbnail recordpicture">
                                  <?php
                                  $url = "/". $moduleid ."/". "uploadpic/";
                                  ?>
                                  <form id ="picupload" method="POST" enctype="multipart/form-data">
                                  <span id="fileselector">
                                      <label class="btn btn-default" for="upload-file-selector" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                          <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture">
                                          <i class="fa fa-upload margin-correction"></i>Browse Pic
                                      </label>
                                  </span>

                                  <button type = "submit" class="uploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                  <button type = "button" class="uploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                  </form>
                                  </h6>
                                
                            </div>

                            <div class="invoice-col col-md-3">
                                <h6 class="aimslabel"><b>Employee Code:  
                                    <div class="input-group">
                                        <input name = "empcode" value ="<?php if(isset($customerdata)){echo $customerdata['empcode'];}?>" type="text" class="moduletxt txtempcode input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="emplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    </div>
                                </h6>


                                <h6 class="aimslabel"><b>Address: <textarea  disabled="true" name="address" class="moduletxt txtempaddress form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($customerdata)){echo $customerdata['address'];}?></textarea></b>
                                </h6>

                                <h6 class="aimslabel"><b>Last Payroll Batch:
                                    <div class="input-group">
                                        <input name = "lastpayrollbatch" value ="" type="text" class="moduletxt txtlastpayrollbatch input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="lastpayrolllookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    </div>
                                </h6>

                                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Hired: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($customerdata)){echo $customerdata['hired'];}?>"  class="paedit input-group date dpYears">
                      <input type="text" name = "hired" readonly="" value="<?php if(isset($customerdata)){echo $customerdata['hired'];}?>" size="12" class="moduletxt txtemphired form-control input-sm" disabled="true">
                      <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                    </div></b></h6>

                    <h6 class="aimslabel dateidview"><b>Hired :</b>
                    <input disabled="true" name="hiredview" value ="<?php if(isset($customerdata)){echo $customerdata['hired'];}?>" type="text" class="moduletxt txtemphiredview form-control input-sm"></h6>
                    <!-- DATE -->


                            </div><!-- /.col -->

                            <div class="invoice-col col-md-3">
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Firstname: <input name="empfirst" value ="<?php if(isset($customerdata)){echo $customerdata['empfirst'];}?>" type="text" class="moduletxt txtempfirst form-control input-sm" disabled="true"></b>
                                </h6>

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Middlename: <input name="empmiddle" value ="<?php if(isset($customerdata)){echo $customerdata['empmiddle'];}?>" type="text" class="moduletxt txtempmiddle form-control input-sm" disabled="true"></b>
                                </h6>

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Lastname: <input name="emplast" value ="<?php if(isset($customerdata)){echo $customerdata['emplast'];}?>" type="text" class="moduletxt txtemplast form-control input-sm" disabled="true"></b>
                                </h6>


                    
                    <h6 class="aimslabel dateidlookup" style="display:none;"><b>Resigned: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($customerdata)){echo $customerdata['resigned'];}?>"  class="paedit input-group date dpYears">
                      <input type="text" name = "resigned" readonly="" value="<?php if(isset($customerdata)){echo $customerdata['resigned'];}?>" size="12" class="moduletxt txtempresigned form-control input-sm" disabled="true">
                      <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                    </div></b></h6>

                    <h6 class="aimslabel dateidview"><b>Resigned :</b>
                    <input disabled="true" name="resignedview" value ="<?php if(isset($customerdata)){echo $customerdata['resigned'];}?>" type="text" class="moduletxt txtempresignedview form-control input-sm"></h6>
                    <!-- DATE -->


                    <h6 class="aimslabel dateidlookup" style="display:none;"><b>Regular: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($customerdata)){echo $customerdata['regular'];}?>"  class="paedit input-group date dpYears">
                      <input type="text" name = "regular" readonly="" value="<?php if(isset($customerdata)){echo $customerdata['regular'];}?>" size="12" class="moduletxt txtempregular form-control input-sm" disabled="true">
                      <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                    </div></b></h6>

                    <h6 class="aimslabel dateidview"><b>Regular :</b>
                    <input disabled="true" name="regularview" value ="<?php if(isset($customerdata)){echo $customerdata['regular'];}?>" type="text" class="moduletxt txtempregularview form-control input-sm"></h6>
                    <!-- DATE -->
                    </div><!-- /.col -->

                            <div class="invoice-col col-md-4">
                               <h6 class="aimslabel" style="display:block;">
                                        <b>Job Title: <input name="jobtitle" value ="<?php if(isset($customerdata)){echo $customerdata['jobtitle'];}?>" type="text" class="moduletxt txtempjobtitle form-control input-sm" disabled="true"></b>
                                    </h6>

                                <h6 class="aimslabel"><b>Description: <textarea  disabled="true" name="jobdesc" class="moduletxt txtempjobdesc form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($customerdata)){echo $customerdata['jobdesc'];}?></textarea></b>
                                    </h6>

                                <label style="margin-top:10px;">Tagging</label></br>
                                <input disabled="true" name = "iscba" style="margin-left:7px;" class ="checkediscbaemploy clientboxes" type="checkbox" <?php if(isset($customerdata)){if($customerdata['iscba'] == 1){echo "checked";}}?>>
                                <label>CBA Employee</label></br>
                                <input style="margin-left:7px;" disabled="true" name = "isactive" class ="clientboxes checkedisactive" type="checkbox" <?php if(isset($customerdata)){if($customerdata['isactive'] == 1){echo "checked";}}?>>
                                <label>Active</label>
                            </div>

                    </div> <!-- end invoice col -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>



 <div class="row">
 <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
            <li id="profiletab" class="active clienttabs"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">General (Page 1)</a></li>
            <li id="profiletab" class=" clienttabs"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">General (Page 2)</a></li>
            <li id="profiletab" class=" clienttabs"><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">General (Page 3)</a></li>
            </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                        <div class="box box-solid box-success" style="margin-bottom:-0px;">
                            <div class="box-body">
                                
                                <div class="invoice-col col-md-3">
                                    <label>Emergency Contact Person 1:</label>
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Name: <input name="contact1" value ="<?php if(isset($customerdata)){echo $customerdata['contact1'];}?>" type="text" class="moduletxt txtename form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Relationship: <input name="relation1" value ="<?php if(isset($customerdata)){echo $customerdata['relation1'];}?>" type="text" class="moduletxt txtrelationship form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel"><b>Address: <textarea  disabled="true" name="addr1" class="moduletxt txteaddress form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($customerdata)){echo $customerdata['addr1'];}?></textarea></b>
                                    </h6>

                                </div><!-- /.col -->  
                                
                                <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Home #: <input name="homeno1" value ="<?php if(isset($customerdata)){echo $customerdata['homeno1'];}?>" type="text" class="moduletxt txtehome form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Mobile #: <input name="mobileno1" value ="<?php if(isset($customerdata)){echo $customerdata['mobileno1'];}?>" type="text" class="moduletxt txtemobile form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel"><b><span>Extn.</span><span style="margin-left:23px;">Office #:</span></br>
                                        <input style="display:inline;width:40px;" disabled="true" name="ext1" value="<?php if(isset($moduledata)){echo $moduledata['head']['ext1'];}?>" type="text" class="moduletxt txteextn form-control input-sm">
                                        <input style="display:inline;width:81%;" disabled="true" name="officeno1" value="<?php if(isset($moduledata)){echo $moduledata['head']['officeno1'];}?>" type="text" class="moduletxt txteoffice form-control input-sm"></b></h6>

                                     <h6 class="aimslabel" style="display:block;">
                                        <b>Notes #: <input name="notes1" value ="<?php if(isset($customerdata)){echo $customerdata['notes1'];}?>" type="text" class="moduletxt txtnotes1 form-control input-sm" disabled="true"></b>
                                    </h6>

                                </div><!-- /.col --> 

                                <div class="invoice-col col-md-3">
                                    <label>Emergency Contact Person 2:</label>
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Name: <input name="contact2" value ="<?php if(isset($customerdata)){echo $customerdata['contact2'];}?>" type="text" class="moduletxt txtename2 form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Relationship: <input name="relation2" value ="<?php if(isset($customerdata)){echo $customerdata['relation2'];}?>" type="text" class="moduletxt txterelationship2 form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel"><b>Address: <textarea  disabled="true" name="addr2" class="moduletxt txteadd2 form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($customerdata)){echo $customerdata['addr2'];}?></textarea></b>
                                    </h6>

                                </div><!-- /.col -->  
                                
                                <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Home #: <input name="homeno2" value ="<?php if(isset($customerdata)){echo $customerdata['homeno2'];}?>" type="text" class="moduletxt txtehome2 form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Mobile #: <input name="mobileno2" value ="<?php if(isset($customerdata)){echo $customerdata['mobileno2'];}?>" type="text" class="moduletxt txtemobile2 form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel"><b><span>Extn.</span><span style="margin-left:23px;">Office #:</span></br>
                                        <input style="display:inline;width:40px;" disabled="true" name="ext2" value="<?php if(isset($moduledata)){echo $moduledata['head']['ext2'];}?>" type="text" class="moduletxt txteextn2 form-control input-sm">
                                        <input style="display:inline;width:81%;" disabled="true" name="officeno2" value="<?php if(isset($moduledata)){echo $moduledata['head']['officeno2'];}?>" type="text" class="moduletxt txteoffice2 form-control input-sm"></b></h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Notes #: <input name="notes2" value ="<?php if(isset($customerdata)){echo $customerdata['notes2'];}?>" type="text" class="moduletxt txtnotes2 form-control input-sm" disabled="true"></b>
                                    </h6>

                                </div><!-- /.col --> 


                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
            </div> <!-- END TAB PANE -->
            <div class="tab-pane " id="tab_2">
                        <div class="box box-solid box-success" style="margin-bottom:-0px;">
                            <div class="box-body">
                                
                                <div class="invoice-col col-md-3">

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Age: <input name="age" value ="<?php if(isset($customerdata)){echo $customerdata['age'];}?>" type="text" class="moduletxt txtage form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel dateidlookup" style="display:none;"><b>Birth Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($customerdata)){echo $customerdata['bday'];}?>"  class="paedit input-group date dpYears">
                      <input type="text" name = "bday" readonly="" value="<?php if(isset($customerdata)){echo $customerdata['bday'];}?>" size="12" class="moduletxt txtbday form-control input-sm" disabled="true">
                      <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                    </div></b></h6>

                    <h6 class="aimslabel dateidview"><b>Birth Date :</b>
                    <input disabled="true" name="bdaydview" value ="<?php if(isset($customerdata)){echo $customerdata['bday'];}?>" type="text" class="moduletxt txtbdayview form-control input-sm"></h6>

                                    <!-- <h6 class="aimslabel" style="display:block;">
                                        <b>Birth Date: <input name="bday" value ="<?php// if(isset($customerdata)){echo $customerdata['bday'];}?>" type="text" class="moduletxt txtbday form-control input-sm" disabled="true"></b>
                                    </h6> -->

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>ID Barcode: <input name="idbarcode" value ="<?php if(isset($customerdata)){echo $customerdata['idbarcode'];}?>" type="text" class="moduletxt txtidbarcode form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <label>Employee Nos.</label>
                                     <h6 class="aimslabel"><b><span style="margin-right:0px;">T.I.N #:</span>
                                    <span style="margin-right:15px;" class="pull-right"></span></br>
                                        <input style="display:inline;width:81%;" disabled="true" name="tin" value="<?php if(isset($customerdata)){echo $customerdata['tin'];}?>" type="text" class="moduletxt txttin form-control input-sm">
                                        <input disabled="true" name = "chktin" style="margin-left:7px;" class ="checkedistin clientboxes" type="checkbox" <?php if(isset($customerdata)){if($customerdata['chktin'] == 1){echo "checked";}}?>></b></h6>

                                    <h6 class="aimslabel"><b><span style="margin-right:0px;">S.S.S #:</span>
                                    <span style="margin-right:15px;" class="pull-right"></span></br>
                                        <input style="display:inline;width:81%;" disabled="true" name="sss" value="<?php if(isset($customerdata)){echo $customerdata['sss'];}?>" type="text" class="moduletxt txtsss form-control input-sm">
                                        <input disabled="true" name = "chksss" style="margin-left:7px;" class ="checkedissss clientboxes" type="checkbox" <?php if(isset($customerdata)){if($customerdata['chksss'] == 1){echo "checked";}}?>></b></h6>

                                    <h6 class="aimslabel"><b><span style="margin-right:0px;">PhilHealth #:</span>
                                    <span style="margin-right:15px;" class="pull-right"></span></br>
                                        <input style="display:inline;width:81%;" disabled="true" name="phic" value="<?php if(isset($customerdata)){echo $customerdata['phic'];}?>" type="text" class="moduletxt txtphil form-control input-sm">
                                        <input disabled="true" name = "chkphealth" style="margin-left:7px;" class ="checkedisphil clientboxes" type="checkbox" <?php if(isset($customerdata)){if($customerdata['chkphealth'] == 1){echo "checked";}}?>></b></h6>

                                        <h6 class="aimslabel"><b><span style="margin-right:0px;">H.D.M.F #:</span>
                                    <span style="margin-right:15px;" class="pull-right"></span></br>
                                        <input style="display:inline;width:81%;" disabled="true" name="hdmf" value="<?php if(isset($customerdata)){echo $customerdata['hdmf'];}?>" type="text" class="moduletxt txthdmf form-control input-sm">
                                        <input disabled="true" name = "chkpibig" style="margin-left:7px;" class ="checkedishdmf clientboxes" type="checkbox" <?php if(isset($customerdata)){if($customerdata['chkpibig'] == 1){echo "checked";}}?>></b></h6>

                                </div><!-- /.col -->  
                                
                                <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel"><b><span style="margin-right:0px;">Bank Account #:</span>
                                    <span style="margin-right:15px;" class="pull-right">ATM.</span></br>
                                        <input style="display:inline;width:81%;" disabled="true" name="bankacct" value="<?php if(isset($customerdata)){echo $customerdata['bankacct'];}?>" type="text" class="moduletxt txtbankacct form-control input-sm">
                                        <input disabled="true" name ="atm" style="margin-left:7px;" class ="checkedisatm clientboxes" type="checkbox" <?php if(isset($customerdata)){if($customerdata['atm'] == 1){echo "checked";}}?>></b></h6>
                                    

                                    <div class="form-group">
                                    <label style="margin-top:10px;">Mode of Payment</label></br>
                                    <div class="radio">
                                      <label>
                                        <input  name="paymode" class ="empmodeofpayment" id="empmodeofpayment_w" value="W" <?php if(isset($customerdata)){if($customerdata['paymode'] == 'W'){echo "checked";}}?> type="radio">
                                        Weekly
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input  name="paymode" class ="empmodeofpayment" id="empmodeofpayment_s" value="S" <?php if(isset($customerdata)){if($customerdata['paymode'] == 'S'){echo "checked";}}?> type="radio">
                                        Semi-Monthly
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input  name="paymode" class ="empmodeofpayment" id="empmodeofpayment_m" value="M"  <?php if(isset($customerdata)){if($customerdata['paymode'] == 'M'){echo "checked";}}?> type="radio">
                                        Monthly
                                      </label>
                                    </div>
                                     <div class="radio">
                                      <label>
                                        <input  name="paymode" class ="empmodeofpayment" id="empmodeofpayment_d" value="D"  <?php if(isset($customerdata)){if($customerdata['paymode'] == 'D'){echo "checked";}}?> type="radio">
                                        Daily
                                      </label>
                                    </div>
                                  </div>

                                    <label>Organization</label>
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Company: <input name="division" value ="<?php if(isset($customerdata)){echo $customerdata['division'];}?>" type="text" class="moduletxt txtcompany form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Department: <input name="dept" value ="<?php if(isset($customerdata)){echo $customerdata['dept'];}?>" type="text" class="moduletxt txtdepartment form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Section: <input name="orgsection" value ="<?php if(isset($customerdata)){echo $customerdata['orgsection'];}?>" type="text" class="moduletxt txtsection form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Supervisor: <input name="supervisor" value ="<?php if(isset($customerdata)){echo $customerdata['supervisor'];}?>" type="text" class="moduletxt txtsupervisor form-control input-sm" disabled="true"></b>
                                    </h6>

                                </div><!-- /.col --> 

                                <div class="invoice-col col-md-3">

                                    <div class="form-group">
                                    <label style="margin-top:10px;">Tax Exemption</label></br>
                                    <div class="radio">
                                      <label>
                                        <input  name="teu" class ="checkedisteu" id="checkedisteu_m" value="M" <?php if(isset($customerdata)){if($customerdata['teu'] == 'M'){echo "checked";}}?> type="radio">
                                        Married
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input  name="teu" class ="checkedisteu" id="checkedisteu_s" value="S" <?php if(isset($customerdata)){if($customerdata['teu'] == 'S'){echo "checked";}}?> type="radio">
                                        Single
                                      </label>
                                    </div>
                                  </div>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>No of Dependents: <input name="nodeps" value ="<?php if(isset($moduledata)){echo $moduledata['head']['nodeps'];}?>" type="text" class="moduletxt txtdependents form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Class Rate: <input name="classrate" value ="<?php if(isset($moduledata)){echo $moduledata['head']['classrate'];}?>" type="text" class="moduletxt txtclassrate form-control input-sm" disabled="true"></b>
                                    </h6>

                                </div><!-- /.col --> 

                                <div class="invoice-col col-md-3">

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>COLA: <input name="ecola" value ="<?php if(isset($customerdata)){echo $customerdata['ecola'];}?>" type="text" class="moduletxt txtcola form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>SSS: <input name="sssdef" value ="<?php if(isset($customerdata)){echo $customerdata['sssdef'];}?>" type="text" class="moduletxt txtsss form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>PHILHEALTH: <input name="philhdef" value ="<?php if(isset($customerdata)){echo $customerdata['philhdef'];}?>" type="text" class="moduletxt txtphilhealth form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>PAG-IBIG: <input name="pibigdef" value ="<?php if(isset($customerdata)){echo $customerdata['pibigdef'];}?>" type="text" class="moduletxt txtpagibig form-control input-sm" disabled="true"></b>
                                    </h6>
                                    
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>W/TAX: <input name="wtaxdef" value ="<?php if(isset($customerdata)){echo $customerdata['wtaxdef'];}?>" type="text" class="moduletxt txttax form-control input-sm" disabled="true"></b>
                                    </h6>

                                </div><!-- /.col -->  

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
            </div> <!-- END TAB PANE2 -->
            <div class="tab-pane " id="tab_3">
                        <div class="box box-solid box-success" style="margin-bottom:-0px;">
                            <div class="box-body">
                                
                                <div class="invoice-col col-md-12">

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>City State: <input name="city" value ="<?php if(isset($customerdata)){echo $customerdata['city'];}?>" type="text" class="moduletxt txtcitystate form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Country: <input name="country" value ="<?php if(isset($customerdata)){echo $customerdata['country'];}?>" type="text" class="moduletxt txtcountry form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Citizenship: <input name="citizenship" value ="<?php if(isset($customerdata)){echo $customerdata['citizenship'];}?>" type="text" class="moduletxt txtcitizen form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Religion: <input name="religion" value ="<?php if(isset($customerdata)){echo $customerdata['religion'];}?>" type="text" class="moduletxt txtreligion form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Maiden Name: <input name="maidname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['maidname'];}?>" type="text" class="moduletxt txtmaiden form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Electronic Mail: <input name="email" value ="<?php if(isset($customerdata)){echo $customerdata['email'];}?>" type="text" class="moduletxt txtemail form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel"><b><span>Marital Status:</span><span style="margin-left:225px;">Home #:</span></br>
                                        <input style="display:inline;width:300px;" disabled="true" name="status" value="<?php if(isset($moduledata)){echo $moduledata['head']['status'];}?>" type="text" class="moduletxt txtmaritalstatus form-control input-sm">
                                        <input style="display:inline;width:300px;" disabled="true" name="telno" value="<?php if(isset($moduledata)){echo $moduledata['head']['telno'];}?>" type="text" class="moduletxt txttelno form-control input-sm"></b></h6>

                                    <h6 class="aimslabel"><b><span>Gender:</span><span style="margin-left:260px;">Mobile #:</span></br>
                                        <input style="display:inline;width:300px;" disabled="true" name="gender" value="<?php if(isset($moduledata)){echo $moduledata['head']['gender'];}?>" type="text" class="moduletxt txtgender form-control input-sm">
                                        <input style="display:inline;width:300px;" disabled="true" name="mobileno" value="<?php if(isset($moduledata)){echo $moduledata['head']['mobileno'];}?>" type="text" class="moduletxt txtmobile form-control input-sm"></b></h6>
                                        
                                    <h6 class="aimslabel"><b><span>Alias:</span><span style="margin-left:275px;">Zip Code #:</span></br>
                                        <input style="display:inline;width:300px;" disabled="true" name="alias" value="<?php if(isset($moduledata)){echo $moduledata['head']['alias'];}?>" type="text" class="moduletxt txtalias form-control input-sm">
                                        <input style="display:inline;width:300px;" disabled="true" name="zipcode" value="<?php if(isset($moduledata)){echo $moduledata['head']['zipcode'];}?>" type="text" class="moduletxt txtzipcode form-control input-sm"></b></h6>      

                                    <h6 class="aimslabel"><b><span>Default Shift:</span></br>
                                        <input style="display:inline;width:300px;" disabled="true" name="shiftcode" value="<?php if(isset($moduledata)){echo $moduledata['head']['shiftcode'];}?>" type="text" class="moduletxt txtshift form-control input-sm">
                                        </h6>            

                                </div><!-- /.col -->  

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
            </div> <!-- END TAB PANE3 -->
        </div> <!-- END TAB CONTENT -->
    </div> <!-- END NAV CUSTOM -->
</div>
</div>