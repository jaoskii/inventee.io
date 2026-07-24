<?php
$this->title = 'Location/Department';
?>
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="clientid" name ="clientid" class="moduletxt" value="<?php echo  $customerdata['clientid']; ?>">

        <div class="col-md-12">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">

                  <b><h6 class="txtclientid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Client ID: <?php if(isset($customerdata)){echo $customerdata['clientid'];} ?></h6></b>

                  <div class="pull-right">
                      <div class="btn-group">

                       <?php if(!empty($customerdata['clientid'])){?>
                        <button type="button" data-toggle="tooltip" title="New Agent" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        <button type="button" data-toggle="tooltip" title="Save Agent" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                         <?php
                            echo'<button type="button" data-toggle="tooltip" title="Edit Agent" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                         ?>
                        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> Print</b></button>

                         <?php
                          echo'<button type="button" data-toggle="tooltip" title="Delete Agent" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>';
                         ?>

                        <button type="button" data-toggle="tooltip" title="Agent Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>


                       <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>

                      <?php }else{ ?>

                        <button type="button" data-toggle="tooltip" title="New Agent" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                        <button type="button" data-toggle="tooltip" title="Save Agent" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Edit Agent" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> Print</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Delete Agent" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Agent Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> Logs</b></button>


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

                            <h6 class="aimslabel"><b>Code:  
                                <div class="input-group">
                                    <input name = "client" value ="<?php if(isset($customerdata)){echo $customerdata['client'];}?>" type="text" class="moduletxt txtclient input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>

                            <h6 class="aimslabel" style="display:block;">
                                <b>Name: <input name="clientname" value ="<?php if(isset($customerdata)){echo $customerdata['clientname'];}?>" type="text" class="moduletxt txtclientnameview form-control input-sm" disabled="true"></b>
                            </h6>


                            </div><!-- /.col -->

                            <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Contact Person: <input name="contact" value ="<?php if(isset($customerdata)){echo $customerdata['contact'];}?>" type="text" class="moduletxt txtclientcontact form-control input-sm" disabled="true"></b></h6>

                           <h6 class="aimslabel"><b>Telephone #: <input name="tel" value ="<?php if(isset($customerdata)){echo $customerdata['tel'];}?>" type="text" class="moduletxt txtclienttel form-control input-sm" disabled="true"></b></h6>

                           
                                                   
                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Fax #: <input name="fax" value ="<?php if(isset($customerdata)){echo $customerdata['fax'];}?>" type="text" class="moduletxt txtclientfax form-control input-sm" disabled="true"></b></h6>
                            
                            <h6 class="aimslabel"><b>Mobile: <input name="tel2" value ="<?php if(isset($customerdata)){echo $customerdata['tel2'];}?>" type="text" class="moduletxt txtclienttel2 form-control input-sm" disabled="true"></b></h6>
                          
                            

                        </div><!-- /.col -->


                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Remarks: <input name="rem" value ="<?php if(isset($customerdata)){echo $customerdata['rem'];}?>" type="text" class="moduletxt txtclientrem form-control input-sm" disabled="true"></b></h6>
                          
                        </div><!-- /.col -->

                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
        <div class="row">
        <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs bg-green">
                  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Profile</a></li> 
                  </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-solid box-success">
                                    <div class="box-body">
                                          <div class="invoice-col col-md-3">

                                            <h6 class="aimslabel"><b>Building: <input disabled name="building" value ="<?php if(isset($customerdata)){echo $customerdata['building'];
                                              }?>" type="text" class="moduletxt txtclientbuilding form-control input-sm" disabled="true"></b></h6>

                                            <h6 class="aimslabel"><b>Floor: <input name="floor" value ="<?php if(isset($customerdata)){echo $customerdata['floor'];}?>" type="text" class="moduletxt txtclientfloor form-control input-sm" disabled="true"></b></h6>
                                            
                                            <h6 class="aimslabel"><b>Region: 
                                            <div class="input-group">
                                                 <input name="region" value ="<?php if(isset($customerdata)){echo $customerdata['region'];}?>" type="text" class="moduletxt txtclientregion form-control input-sm">
                                                 <div class="input-group-addon"><a style="display:none;" class ="proplookup arealookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                            </div></h6>                          
                                          </div><!-- /.col -->


                                              <div class="invoice-col col-md-2">
                                              <label style="margin-top:10px;">Tagging</label></br>
                                                <input disabled name = "iscustomer" style="margin-left:7px;" class ="clientboxes checkedislocation" type="checkbox"
                                                <?php if(isset($customerdata)){if($customerdata['isLocation'] == 1){echo "checked";}}?>>
                                                <label>Location: </label></br>
                                              </div><!-- /.col --> 

                                              <div class="invoice-col col-md-2">
                                              <h6 class="aimslabel picbox">
                                              <?php if(isset($customerdata)){
                                                if(empty($customerdata['picture'])){
                                                  $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                                }else{
                                                  $str = $customerdata['picture'];
                                                }
                                              }else{
                                                $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
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


                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
    </div>
    </div>

