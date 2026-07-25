<?php
$this->title = 'Agent Ledger';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<div id="dragme">
<i onclick="myFunction()" class="title fa fa-list"></i><br/>
<ul id="menu-float">
<?php if(!empty($customerdata['clientid'])){?>
  <!-- ADD CLASS (pop-btn btn-xx ) to BUTTONS added here also Remove button captions -->  
  <!-- then add (<div class="list">CAPTION</div>) after each </button>
<div class="list">CAPTION</div> -->
  
  <!-- BEGIN BTN GROUP -->
  <button type="button" title="New Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> </b></button>
<div class="list">New</div>
  <button type="button" title="Save Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> </b></button>
<div class="list">Save</div>
   <?php
      echo'<button type="button" title="Edit Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> </b></button>
<div class="list">Edit</div>';
   ?>
  <button type="button" title="Cancel" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button>
<div class="list">Cancel</div>
  <button type="button" title="Print" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> </b></button>
<div class="list">Print</div>

   <?php
    echo'<button type="button" title="Delete Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> </b></button>
<div class="list">Delete</div>';
   ?>

  <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> </b></button>
<div class="list">Logs</div>

 <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
  <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
  <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
  <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>

<?php }else{ ?>

  <button type="button" title="New Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> </b></button>
<div class="list">New</div>
  <button type="button" title="Save Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> </b></button>
<div class="list">Save</div>
  <button disabled="true" type="button" title="Edit Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> </b></button>
<div class="list">Edit</div>
  <button type="button" title="Cancel" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button>
<div class="list">Cancel</div>
  <button disabled="true" type="button" title="Print" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> </b></button>
<div class="list">Print</div>
  <button disabled="true" type="button" title="Delete Customer" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> </b></button>
<div class="list">Delete</div>
  <button disabled="true" type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> </b></button>
<div class="list">Logs</div>
  

  <button disabled="true" id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
  <button disabled="true" id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
  <button disabled="true"id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
  <button disabled="true" id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>
  <!-- <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="fa fa-minus"></i></button>
<div class="list">CAPTION</div> -->
 <?php } ?>


</ul>
</div> <!-- dragme end -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="clientid" name ="clientid" class="moduletxt" value="<?php echo  $customerdata['clientid']; ?>">

        <div class="col-md-12">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">

                  <b><h6 class="txtclientid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Client ID: <?php if(isset($customerdata)){echo $customerdata['clientid'];} ?></h6></b>

                  <div class="btn-x pull-right">
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

                            <h6 class="aimslabel"><b>Agent:  
                                <div class="input-group">
                                    <input name = "client" value ="<?php if(isset($customerdata)){echo $customerdata['client'];}?>" type="text" class="moduletxt txtclient input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>

                            <h6 class="aimslabel" style="display:block;">
                                <b>Name: <input name="clientname" value ="<?php if(isset($customerdata)){echo $customerdata['clientname'];}?>" type="text" class="moduletxt txtclientnameview form-control input-sm" disabled="true"></b>
                            </h6>

                         
                            <h6 class="aimslabel"><b>Address: <textarea  disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($customerdata)){echo $customerdata['addr'];}?></textarea></b></h6>

                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                              case 'UNIVERSE':
                                echo '<h6 class="aimslabel"><b>Agent Password: <input name="pass" value ="';
                                 if(isset($customerdata)){echo $customerdata['agentpassword'];
                                 }
                                echo '" type="password" class="moduletxt txtagentpass form-control input-sm" disabled="true"></b></h6>';
                              break;
                            }//end switch case
                           ?>
                           
                            </div><!-- /.col -->

                            <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Contact Person: <input name="contact" value ="<?php if(isset($customerdata)){echo $customerdata['contact'];}?>" type="text" class="moduletxt txtclientcontact form-control input-sm" disabled="true"></b></h6>

                           <h6 class="aimslabel"><b>Telephone #: <input name="tel" value ="<?php if(isset($customerdata)){echo $customerdata['tel'];}?>" type="text" class="moduletxt txtclienttel form-control input-sm" disabled="true"></b></h6>

                           <h6 class="aimslabel"><b>Fax #: <input name="fax" value ="<?php if(isset($customerdata)){echo $customerdata['fax'];}?>" type="text" class="moduletxt txtclientfax form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Price Group:
                                 <select disabled = "true" id="pricegroup" class="pricegroup input-sm form-control"><?php if(isset($customerdata)){echo '<option>'.$customerdata['pricegroup'] . '</option>';}?></select>
                            </h6>
                            
                            <button class="btn btn-github btn-flat univ_createuseraccnt"><i class="fa fa-users"></i>&nbsp&nbspCreate User Account on Useraccess</button>
                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">
                            <h6 class="aimslabel"><b>Mobile: <input name="tel2" value ="<?php if(isset($customerdata)){echo $customerdata['tel2'];}?>" type="text" class="moduletxt txtclienttel2 form-control input-sm" disabled="true"></b></h6>
                          
                            <h6 class="aimslabel"><b>Email Address: <input name="email" value ="<?php if(isset($customerdata)){echo $customerdata['email'];}?>" type="text" class="moduletxt txtclientemail form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Group :
                            <div class="input-group">
                                 <input disabled="true" name="groupid" value ="<?php if(isset($customerdata)){echo $customerdata['groupid'];}?>" type="text" class="moduletxt txtclientgroupid form-control input-sm">
                                 <div class="input-group-addon"><a style="display:none;" class ="proplookup clientgrpidlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div></h6>
                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                              case 'SOUTHCENTRAL':
                                echo '<h6 class="aimslabel"><b>Agent Password: <input name="agpass" value ="';
                                if(isset($customerdata)){echo $customerdata['agpass'];
                                }
                                echo '" type="text" class="moduletxt txtclientagpass form-control input-sm" disabled="true"></b></h6>';
                              break;
                            }//end switch case
                            ?>                      
                        </div><!-- /.col -->


                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>T.I.N #: <input name="tin" value ="<?php if(isset($customerdata)){echo $customerdata['tin'];}?>" type="text" class="moduletxt txtclienttin form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Remarks: <input name="rem" value ="<?php if(isset($customerdata)){echo $customerdata['rem'];}?>" type="text" class="moduletxt txtclientrem form-control input-sm" disabled="true"></b></h6>

                            <h6 class="aimslabel"><b>Quota: <input name="quota" value ="<?php if(isset($customerdata)){echo $customerdata['quota'];}?>" type="text" class="moduletxt txtclientquota form-control input-sm" disabled="true"></b></h6>
                          
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

                                            <h6 class="aimslabel"><b>Started: <input placeholder="format (yyyy-mm-dd)"  disabled name="started" value ="<?php if(isset($customerdata)){echo $customerdata['start'];
                                              }?>" type="text" class="moduletxt txtclientstarted form-control input-sm" disabled="true"></b></h6>

                                            <h6 class="aimslabel"><b>Status: <input name="status" value ="<?php if(isset($customerdata)){echo $customerdata['status'];}?>" type="text" class="moduletxt txtclientstatus form-control input-sm" disabled="true"></b></h6>
                                            
                                            <h6 class="aimslabel"><b>Area: 
                                            <div class="input-group">
                                                 <input name="area" value ="<?php if(isset($customerdata)){echo $customerdata['area'];}?>" type="text" class="moduletxt txtclientarea form-control input-sm">
                                                 <div class="input-group-addon"><a style="display:none;" class ="proplookup arealookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                            </div></h6>

                                            <!-- <input name="area" value ="<?php if(isset($customerdata)){echo $customerdata['area'];}?>" type="text" class="moduletxt txtclientarea form-control input-sm" disabled="true"></b></h6> -->
                                                <!--blank-->
                                            <h6 class="aimslabel"><b>Province: 
                                            <div class="input-group">
                                                 <input name="province" value ="<?php if(isset($customerdata)){echo $customerdata['province'];}?>" type="text" class="moduletxt txtclientprovince form-control input-sm">
                                                 <div class="input-group-addon"><a style="display:none;" class ="proplookup provincelookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                            </div></h6>

                                            <!-- <h6 class="aimslabel"><b>Province: <input name="province" value ="<?php if(isset($customerdata)){echo $customerdata['province'];}?>" type="text" class="moduletxt txtclientprovince form-control input-sm" disabled="true"></b></h6> -->

                                            <h6 class="aimslabel"><b>Region: 
                                            <div class="input-group">
                                                 <input name="region" value ="<?php if(isset($customerdata)){echo $customerdata['region'];}?>" type="text" class="moduletxt txtclientregion form-control input-sm">
                                                 <div class="input-group-addon"><a style="display:none;" class ="proplookup regionlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                            </div></h6>                          
                                          </div><!-- /.col -->


                                              <div class="invoice-col col-md-2">
                                              <label style="margin-top:10px;">Tagging</label></br>
                                                <input disabled name = "iscustomer" style="margin-left:7px;" class ="clientboxes checkediscustomer" type="checkbox"
                                                <?php if(isset($customerdata)){if($customerdata['IsCustomer'] == 1){echo "checked";}}?>>
                                                <label>Customer: </label></br>
                                                <input disabled style="margin-left:7px;" class ="clientboxes checkedisagent" type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsAgent'] == 1){echo "checked";}}?>>
                                                <label>Agent: </label></br>
                                                <input disabled style="margin-left:7px;" class ="clientboxes checkedissupplier" type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsSupplier'] == 1){echo "checked";}}?>>
                                                <label>Supplier: </label></br>

                                                <input disabled style="margin-left:7px;" class ="clientboxes checkediswarehouse"type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsWarehouse'] == 1){echo "checked";}}?>>
                                                <label>Warehouse: </label></br>
                                                <input disabled style="margin-left:7px;" class ="clientboxes checkedisemployee"type="checkbox" 
                                                <?php if(isset($customerdata)){if($customerdata['IsEmployee'] == 1){echo "checked";}}?>>
                                                <label>Employee: </label></br>
                                                <input disabled style="margin-left:7px;" class ="clientboxes checkedishold" type="checkbox" <?php if(isset($customerdata)){if($customerdata['IsInactive'] == 1){echo "checked";}}?>>
                                                <label>Hold Agent: </label></br>

                                                <?php
                                                
                                                switch (Yii::$app->systemsettings->companyConfig()) {
                                                  case 'UNIVERSE':
                                                    echo'<input disabled style="margin-left:7px;" class ="clientboxes checkedispicker"type="checkbox"';
                                                    if(isset($customerdata)){if($customerdata['uv_ispicker'] == 1){echo "checked";}}
                                                    echo '><label>Picker: </label></br>
                                                    <input disabled style="margin-left:7px;" class ="clientboxes checkedischecker" type="checkbox"';
                                                    if(isset($customerdata)){if($customerdata['uv_ischecker'] == 1){echo "checked";}}
                                                    echo '><label>Checker: </label></br>';
                                                  break;
                                                  
                                                  default:
                                                    echo'<input disabled style="margin-left:7px;;display:none;" class ="clientboxes checkedispicker" type="checkbox" ';
                                                    if(isset($customerdata)){if($customerdata['uv_ispicker'] == 1){echo "checked";}}
                                                    echo '><label style="display:none;">Picker: </label></br>
                                                    <input disabled style="margin-left:7px;;display:none;" class ="clientboxes checkedischecker" type="checkbox" ';
                                                    if(isset($customerdata)){if($customerdata['uv_ischecker'] == 1){echo "checked";}}
                                                    echo '><label style="display:none;">Checker: </label></br>';
                                                  break;
                                                }//END SWITH
                                                ?>

                                              </div><!-- /.col --> 

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

