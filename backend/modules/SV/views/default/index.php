<?php
use yii\helpers\Url;
$this->title = 'Supplier Invoice';
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
<!--          <a href="#" class="pull-right" style="font-weight: bold; font-size: 11px; padding: 5px; text-shadow: 1px 0px 1px #ebebe0;">
                  <span class="pull-right text-green"><i class="fa fa-thumbs-o-up" style="font-size: 20px;"></i> APPROVED</span>
                </a> -->
               
<!--          <a href="#" class="pull-right" style="font-weight: bold; font-size: 11px; padding: 5px; text-shadow: 1px 0px 1px #ebebe0;">
                  <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 20px;"></i> LOCKED</span>
                </a>-->          
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
                    <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                     <?php
                      if($moduledata['head']['isposted']){
                      echo'<button type="button" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                      }else{
                        if($moduledata['head']['islocked']){
                         echo'<button type="button" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                        }else{
                        echo'<button type="button" class="btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                        }
                      }
                     ?>
                    <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i> Print</b></button>
                    <?php
                      if($moduledata['head']['isposted']){
                      echo'<button type="button" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                        <button type="button" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                        <button type="button" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
                        <button type="button" class="headbtn btnactive module-btnunpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                        <button type="button" class="headbtn module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>';
                      }else{
                        if($moduledata['head']['islocked']){
                        echo'<button type="button" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                        <button type="button" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                        <button type="button" class="headbtn btnactive module-btnunlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>';
                        }else{
                        echo'<button type="button" class="headbtn btnactive module-btndelete btn btn-default btn-success"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                        <button type="button" class="headbtn btnactive module-btnlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                        <button type="button" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>';
                        }
                      echo'<button type="button" class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                        <button type="button" class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-check post_btn"></i> Post</b></button>';
                      }
                     ?>

                     <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>

                    <?php 
                    if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
                      echo'<button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      <button type="button" class="btn btn-default btn-success stockbtn sv_addrr" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add RR</b></button>';
                    }else{
                      echo'<button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      <button type="button" class="btn btn-default 
                      btn-success stockbtn sv_addrr"><b><i class="fa fa-plus add_btn"></i> Add RR
                      </b></button>';
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
                    <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;"><b><i class="fa fa-print print_btn"></i> Print</b></button>
                    <button type="button" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                    <button type="button" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                    <button type="button" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
                    <button type="button" class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                    <button type="button" class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
                    <button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                    <button type="button" class="btn btn-default btn-success stockbtn sv_addrr" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add RR</b></button>
                    
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
                <div class="invoice-col col-md-3">
                <h6 class="aimslabel"><b>Document #:  
                <div class="input-group">
                    <input name = "docno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['docno'];}?>" type="text" class="moduletxt txtdocno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="docnolookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                
                <h6 class="aimslabel clientcodeview" style="display:block;"><b>Supplier Code: <input name="clientcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="txtclientcodeview form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel clientcodelookup" style="display:none;"><b>Supplier Code: <div class="input-group"><input name = "client" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>"  type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true"></b><div class="clientlookupbtn input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                
                <h6 class="aimslabel"><b>Supplier: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b></h6>

                <h6 class="aimslabel"><b>Invoice #: <input name = "invoiceno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['invoiceno'];}?>" type="text" class="moduletxt txtinvoiceno form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Invoice Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                  <input type="text" name = "invoicedateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['invoicedate'];}?>" size="12" class="moduletxt txtinvoicedateid form-control input-sm" disabled="true">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b>Invoice Date :</b>
                <input disabled="true" name="invoicedateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['invoicedate'];}?>" type="text" class="moduletxt txtinvoicedateidview form-control input-sm"></h6>
                </div><!-- /.col -->
                
                <div class="invoice-col col-md-3">
                <h6 class="aimslabel"><b>Your Ref: <input name = "yourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['yourref'];}?>" type="text" class="moduletxt txtyourref form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b>Our Ref: <input name="ourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['ourref'];}?>" type="text" class="moduletxt txtourref form-control input-sm" disabled="true"></b></h6>
                 <h6 class="aimslabel"><b>Address: <textarea disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['address'];}?></textarea></b></h6>
                 <h6 class="aimslabel contraview"><b>Account: <input value="<?php if(isset($moduledata)){echo $moduledata['head']['contra'];}?>" type="text" disabled=true class="txtcontraview moduletxt form-control input-sm"></b></h6>

                <h6 class="aimslabel contralookup" style="display:none;"><b>Account:</b>
                <div class="input-group">
                    <input name="contra" readonly=true value="<?php if(isset($moduledata)){echo $moduledata['head']['contra'];}?>" type="text" class="moduletxt txtcontra form-control input-sm">
                    <div class="input-group-addon"><a class ="btnshowcontra" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                </div><!-- /.col -->
                
                <!-- DATE -->
                <div class="invoice-col col-md-3">
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>"  class="paedit input-group date dpYears">
                  <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b>Date :</b>
                <input disabled="true" name="dateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdateidview form-control input-sm"></h6>
                <!-- DATE -->

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

               <h6 class="aimslabel"><b>Due Date :</b>
                <input disabled="true" name="due" value ="<?php if(isset($moduledata)){echo $moduledata['head']['due'];}?>" type="text" class="moduletxt txtdatedue form-control input-sm"></h6>
                
                </div><!-- /.col -->

                <div class="invoice-col col-md-3">
                 <h6 class="aimslabel termsview"><b>Terms: <input name="termview" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" disabled=true class="txttermsview moduletxt form-control input-sm"></b></h6>

                <h6 class="aimslabel termslookup" style="display:none;"><b>Terms :</b>
                <div class="input-group">
                    <input readonly="" name="terms" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" class="moduletxt txtterms form-control input-sm">
                    <div class="input-group-addon"><a class ="btnshowterms" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>

                <h6 class="aimslabel"><b>Forex: </br>
                <input style="display:inline;width:40px;" disabled="true" name="cur" value="<?php if(isset($moduledata)){echo $moduledata['head']['cur'];}?>" type="text" class="moduletxt txtcur form-control input-sm">
                <input style="display:inline;width:70%;" disabled="true" name="forex" value="<?php if(isset($moduledata)){echo $moduledata['head']['forex'];}?>" type="text" class="moduletxt txtforex form-control input-sm"></b></h6>

                <h6 class="aimslabel"><b>Ship to: <input disabled="true" name="shipto" value="<?php if(isset($moduledata)){echo $moduledata['head']['shipto'];}?>" type="text" class="moduletxt txtshipto form-control input-sm"></b></h6>

                <h6 class="aimslabel"><b>Tax: <input disabled="true" name="tax" value="<?php if(isset($moduledata)){echo $moduledata['head']['tax'];}?>" type="text" class="moduletxt txttax form-control input-sm"></b></h6>

                <h6 class="aimslabel"><b>Vat type:
                    <select disabled = "true" id="vattype" class="vattype input-sm form-control">
                      <?php if(isset($moduledata)){echo '<option>'.$moduledata['head']['vattype'] . '</option>';}?>
                    </select>
                </h6>
                
                <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" style="display:none;">
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
              <li class=""><a class="clickable sp_listrr" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">RR Documents</a></li>
              <li class=""><a class="clickable showacctg" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>

              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['grandtotal'];} ?></h6></li>

              <li class="pull-right"><h6 class="txtitemcount" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['itemcount'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));} ?></h6></li>
            </ul>
              
            <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="row">
                    <div class="col-md-12">
                      <label class="clickable viewcopyclipboard"><i class="fa fa-copy"></i> [Copy Stock Details to Clipboard]</label>
                      <?php 
                        if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                        if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                        echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success"></div>'
                      ?>
                    </div>
                </div>
            </div>
            <!-- /.tab-content -->
            </div>
</div>
</div>
</div>
