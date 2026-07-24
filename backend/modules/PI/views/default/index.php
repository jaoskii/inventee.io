<?php
use yii\helpers\Url;
$this->title = 'Production Instruction';
?>
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<div class="col-md-12">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">

              <b><h6 class="txttrno" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Trno: <?php if(isset($moduledata)){echo $moduledata['head']['trno'];} ?></h6></b>
              <h6 id="mindocno" style="display:none;"><b>Docno: <?php if(isset($moduledata)){echo $moduledata['head']['docno'];} ?></b></h6>

              <div class="btn-group" > 
<!--                 <a href="#" class="pull-right" style="font-weight: bold; font-size: 11px; padding: 5px; text-shadow: 1px 0px 1px #ebebe0;">
                  <span class="pull-right text-green"><i class="fa fa-thumbs-o-up" style="font-size: 20px;"></i> APPROVED</span>
                </a> -->
               
<!--                 <a href="#" class="pull-right" style="font-weight: bold; font-size: 11px; padding: 5px; text-shadow: 1px 0px 1px #ebebe0;">
                  <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 20px;"></i> LOCKED</span>
                </a>
 -->          
              <?php 
              //IF POSTED SHOW POSTED FLAGS
              if($moduledata['head']['isposted']){
              echo'<a href="#" class="posted-flag pull-right" style="display:block;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-yellow"><i class="fa fa-check-circle" style="font-size: 15px;"></i> POSTED</span></a>';
              }else{
              echo'<a href="#" class="posted-flag pull-right" style="display:none;font-weight: bold;padding-right:3px;  font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-yellow"><i class="fa fa-check-circle" style="font-size: 15px;"></i> POSTED</span></a>';
              }
              //IF LOCKED SHOW LOCKED FLAGS
              if($moduledata['head']['islocked']){
              echo'<a href="#" class="locked-flag pull-right" style="display:block;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
              }else{
              echo'<a href="#" class="locked-flag pull-right" style="display:none;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
              }
              ?>
              </div>

                <div class="pull-right">
                  <?php if($moduledata['head']['trno'] != null){?>
                <!-- BEGIN BTN GROUP -->
                  <div class="btn-group">
                    <button type="button" data-toggle="tooltip" title="New transaction" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save Transaction Head" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                     <?php
                      if($moduledata['head']['isposted']){
                      echo'<button type="button" data-toggle="tooltip" title="Edit Transaction" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                      }else{
                        if($moduledata['head']['islocked']){
                         echo'<button type="button" data-toggle="tooltip" title="Edit Transaction" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                        }else{
                        echo'<button type="button" data-toggle="tooltip" title="Edit Transaction" class="btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                        }
                      }
                     ?>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                    <button type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i> Print</b></button>
                    
                    <?php
                      if($moduledata['head']['isposted']){
                      echo'<button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                        <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                        <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
                        <button type="button" data-toggle="tooltip" title="Unpost Transaction" class="headbtn btnactive module-btnunpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                        <button type="button" data-toggle="tooltip" title="Post Transaction" class="headbtn module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>';
                      }else{
                        if($moduledata['head']['islocked']){
                        echo'<button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                        <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                        <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn btnactive module-btnunlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>';
                        }else{
                        echo'<button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn btnactive module-btndelete btn btn-default btn-success"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                        <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn btnactive module-btnlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                        <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>';
                        }
                      echo'<button type="button" data-toggle="tooltip" title="Unpost Transaction" class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                        <button type="button" data-toggle="tooltip" title="Post Transaction" class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-check post_btn"></i> Post</b></button>';
                      }
                     ?>

                     <button type="button" data-toggle="tooltip" title="Transaction Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>

                    <?php 
                    if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
                      echo'<button type="button" data-toggle="tooltip" title="Save all stock Items" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      <button type="button"  data-toggle="tooltip" title="Add New Item" class="btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                      <button type="button"  data-toggle="tooltip" title="Quick Add" class="btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>';

                    }else{
                      echo'<button type="button" data-toggle="tooltip" title="Save all stock Items" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      <button type="button" data-toggle="tooltip" title="Add New Item" class="btn btn-default btn-success stockbtn stock-btnadd"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                      <button type="button" data-toggle="tooltip" title="Quick Add" class="btn btn-default btn-success stockbtn stock-btnquickadd"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>';
                    }
                    ?>

                    <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                    <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                    <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                    <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                    <button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
                  </div>
                  
                  <?php }else{
                    
                    echo'
                    <div class="btn-group">
                    <button type="button" data-toggle="tooltip" title="New transaction" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save Transaction Head" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Edit Transaction" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                    <button type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;"><b><i class="fa fa-print print_btn"></i> Print</b></button>
                    <button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                    <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                    <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
                    <button type="button" data-toggle="tooltip" title="Unpost Transaction" class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                    <button type="button" data-toggle="tooltip" title="Post Transaction" class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>
                    <button type="button" data-toggle="tooltip" title="Transaction Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
                    <button type="button" data-toggle="tooltip" title="Save all  stock Items" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                    <button type="button"  data-toggle="tooltip" title="Add New Item" class="btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                    <button type="button"  data-toggle="tooltip" title="Quick Add" class="btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>

                    <button disabled="true" id ="'.$moduleid.'-btnnavfirst" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                    <button disabled="true" id ="'.$moduleid.'-btn-navprev"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                    <button disabled="true" id ="'.$moduleid.'-btnnavnext"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                    <button disabled="true" id ="'.$moduleid.'-btnnavlast" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                    <button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button style="margin-top:3px;display:none;" class="btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
                    </div>';
                  }?>
                <!-- END BUTTON GROUP -->

                </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
              
              <div class="box-body">
                <div class="pull-right" style="margin-top:-15px;">
                   
                </div>
                
                <div class="invoice-info col-md-12" style="margin-left:-15px;">
                <div class="invoice-col col-md-4">
                <h6 class="aimslabel"><b>Document #:  
                <div class="input-group">
                    <input name = "docno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['docno'];}?>" type="text" class="moduletxt txtdocno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="docnolookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                
                <h6 class="aimslabel clientcodeview" style="display:block;"><b>Barcode: <input name="barcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="txtclientcodeview form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel clientcodelookup" style="display:none;"><b>Barcode: <div class="input-group"><input name = "barcode" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>"  type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true"></b><div class="clientlookupbtn input-group-addon"><a class ="clientlookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div>
                </div></h6>
                
                <h6 class="aimslabel"><b>Itemname: <input name="itemname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b></h6>

                <!-- DATE -->
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>"  class="paedit input-group date dpYears">
                  <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b>Date :</b>
                <input disabled="true" name="dateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdateidview form-control input-sm"></h6>
                <!-- DATE -->

                </div><!-- /.col -->
                
                <div class="invoice-col col-md-4">
                <h6 class="aimslabel"><b>Your Ref: <input name = "yourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['yourref'];}?>" type="text" class="moduletxt txtyourref form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b>Our Ref: <input name="ourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['ourref'];}?>" type="text" class="moduletxt txtourref form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b>Overhead: <input name="overhead" value ="<?php if(isset($moduledata)){echo $moduledata['head']['overhead'];}?>" type="text" class="moduletxt txtoverhead form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b>Labor: <input name="labor" value ="<?php if(isset($moduledata)){echo $moduledata['head']['labor'];}?>" type="text" class="moduletxt txtlabor form-control input-sm" disabled="true"></b></h6>
                
                </div><!-- /.col -->
                
                <!-- DATE -->
                <div class="invoice-col col-md-4">
                <!-- WAREHOUSE -->
                <h6 class="aimslabel whcodeview"><b>Warehouse :</b>
                <input disabled="true" name="warehouseview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['wh'] . "~" . $moduledata['head']['whid'];}?>" type="text" class="moduletxt txtwarehouseview form-control input-sm"></h6>

                <h6 class="aimslabel whcodelookup" style="display:none;"><b>Warehouse :</b>
                <div class="input-group">
                    <input disabled="true" name="warehouse" value ="<?php if(isset($moduledata)){echo $moduledata['head']['wh'] . "~" . $moduledata['head']['whid'];}?>" type="text" class="moduletxt txtwarehouse form-control input-sm">
                    <div class="frmwh input-group-addon"><a class ="whlookuphead" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                <!-- WAREHOUSE -->
                <h6 class="aimslabel"><b>Notes: <textarea  disabled="true" name="rem" class="moduletxt txtnotes form-control" style="resize:none;"  rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['rem'];}?></textarea></b></h6>
                <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" disabled="true" style="display:none;">
               
                </div><!-- /.col -->


              </div>
        </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
</div>

<div class="row">
<div class="col-md-12">
     
                  <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>

              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['grandtotal'];} ?></h6></li>

              <li class="pull-right"><h6 class="txtitemcount" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['itemcount'],
              Yii::$app->systemsettings->setDecimaldisplay('quantity'));} ?></h6></li>

              <?php
              switch(Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                  echo '<li class="pull-right"><h6 class="txttotalkilo" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL QTY: ';
                  if(isset($moduledata)){echo $moduledata['head']['totalkilo'];}
                  echo '</h6></li>';
                  break;
                
                default:
                  echo '<li style="display:none;" class="pull-right"><h6 class="txttotalkilo" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL QTY: ';
                  if(isset($moduledata)){echo $moduledata['head']['totalkilo'];}
                  echo '</h6></li>';
                  break;
              }//END SWITCH
              ?>
            </ul>
              
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                            <div class="box-body mod-tble">
                             <table class="table tbl-fix bodytable table-hover">
                              <thead>
                                  <tr>
                                      <th class="col-min aimslabel"><span class="text">Options</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                                      <th class="col-quantity aimslabel"><span class="text">Qty</span></th>
                                      <th class="col-min aimslabel"><span class="text">UOM</span></th>
                                      <th class="col-description aimslabel"><span class="text">Item Name</span></th>
                                      <th class="col-currency aimslabel"><span class="text">Price</span></th>
                                      <!-- <th class="col-min aimslabel"><span class="text">Discount</span></th> -->
                                      <th class="col-currency aimslabel"><span class="text">Total Price</span></th>
                                      <th class="col-quantity aimslabel"><span class="text">Pending</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Warehouse</span></th>
                                      <!-- <th class="col-codes aimslabel"><span class="text">Location</span></th> -->
                                      <th class="col-codes aimslabel"><span class="text">Reference</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody">
                               <?php
                               if(isset($moduledata['body']) && $moduledata['body'] != ""){
                                  foreach ($moduledata['body'] as $itmindex => $itmdata) {
                                    echo'<tr id="orgrow-'.$itmdata['line'].'" class="orgrow">
                                    <td id="stockbuttons-'.$itmdata['line'].'"  class="origdata btnstockopt col-min aimslabelstock">';
                                      if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
                                      echo'<button id="stockedit-'.$itmdata['line'].'" class="stockbtn stockeditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                      <button id="stockdelete-'.$itmdata['line'].'" class="stockbtn stockdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>
                                      <button class="stockbtn stockattrbtn btn btn-social-icon btn-github" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px; margin-top:-8px;" class="fa fa-eye"></i></button>';
                                      }else{
                                      echo'<button id="stockedit-'.$itmdata['line'].'" data-toggle="tooltip" title="Edit Item" class="stockbtn stockeditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                      <button id="stockdelete-'.$itmdata['line'].'"  data-toggle="tooltip" title="Delete Item" class="stockbtn stockdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>
                                      <button id = "showbalance-'.$itmdata['itemid'].'"  data-toggle="tooltip" title="Show Balance" class="stockbtn showbalance stockattrbtn btn btn-social-icon btn-github" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px; margin-top:-8px;" class="fa fa-eye"></i></button>';
                                      }
                                    echo '</td>
                                    <td id="stockbarcode-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['barcode'].'</td>
                                    <td id="stockrrqty-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.number_format($itmdata['rrqty'],Yii::$app->systemsettings->setDecimaldisplay('quantity')).'</td>
                                    <td id="stockuom-'.$itmdata['line'].'" class="origdata col-min aimslabelstock">'.$itmdata['uom'].'</td>
                                    <td id="stockitemname-'.$itmdata['line'].'" class="origdata col-description aimslabelstock">'.$itmdata['itemname'].'</td>
                                    <td id="stockrrcost-'.$itmdata['line'].'" class="origdata col-currency aimslabelstock">'.number_format($itmdata['rrcost'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</td>
                                    <td id="stockdisc-'.$itmdata['line'].'" class="origdata nobody aimslabelstock"></td>
                                    <td id="stockext-'.$itmdata['line'].'" class="origdata col-currency aimslabelstock">'.number_format($itmdata['ext'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</td>
                                    <td id="stockqa-'.$itmdata['line'].'" class="origdata col-quantity aimslabelstock">'.number_format($itmdata['qa'],Yii::$app->systemsettings->setDecimaldisplay('quantity')).'</td>
                                    <td id="stockwhcode-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['whcode'].'</td>
                                    <td id="stockwh-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['wh'].'</td>';
                                    
                                    echo'<td id="stockloc-'.$itmdata['line'].'" class="origdata nobody aimslabelstock"></td>';

                                    echo '<td id="stockexpiry-'.$itmdata['line'].'" class="origdata nobody aimslabelstock"></td>                                    
                                    <td id="stockref-'.$itmdata['line'].'" class="origdata col-codes aimslabelstock">'.$itmdata['ref'].'</td>
                                    <td id="stockqty-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['qty'].'</td>
                                    <td id="stockcost-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['cost'].'</td>
                                    <td id="stockrem-'.$itmdata['line'].'" class="origdata nobody aimslabelstock"></td>                                    
                                    <td id="stockrefx-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['refx'].'</td>
                                    <td id="stocklinex-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['linex'].'</td>
                                    <td id="stockline-'.$itmdata['line'].'" class="origdata nobody aimslabelstock">'.$itmdata['line'].'</td>
                                  </tr>';
                                  }
                               }
                               ?>
                                </tbody>
                            </table>  
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