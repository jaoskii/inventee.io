<?php
$this->title = 'Warehouse Ledger';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>
<div  id="dragme">
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
                        <button type="button" data-toggle="tooltip" title="New Warehouse" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                        <button type="button" data-toggle="tooltip" title="Save Warehouse" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                         <?php
                            echo'<button type="button" data-toggle="tooltip" title="Edit Warehouse" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                         ?>
                        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> Print</b></button>

                         <?php
                          echo'<button type="button" data-toggle="tooltip" title="Delete Warehouse" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>';
                         ?>

                        <button type="button" data-toggle="tooltip" title="Warehouse Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>


                       <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>

                      <?php }else{ ?>

                        <button type="button" data-toggle="tooltip" title="New Warehouse" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                        <button type="button" data-toggle="tooltip" title="Save Warehouse" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Edit Warehouse" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="fa fa-print print_btn"></i> Print</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Delete Warehouse" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                        <button disabled="true" type="button" data-toggle="tooltip" title="Warehouse Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>


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
                        <div class="invoice-col col-md-6">

                            <h6 class="aimslabel"><b>Warehouse:  
                                <div class="input-group">
                                    <input name = "client" value ="<?php if(isset($customerdata)){echo $customerdata['client'];}?>" type="text" class="moduletxt txtclient input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>

                            <h6 class="aimslabel" style="display:block;">
                                <b>Name: <input name="clientname" value ="<?php if(isset($customerdata)){echo $customerdata['clientname'];}?>" type="text" class="moduletxt txtclientnameview form-control input-sm" disabled="true"></b>
                            </h6>

                            <h6 class="aimslabel"><b>Address: <textarea  disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($customerdata)){echo $customerdata['addr'];}?></textarea></b></h6>

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
                                <label>Inactive: </label></br>


                                              
                        </div>

                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
       