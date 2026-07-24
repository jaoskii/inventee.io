<?php
$this->title = 'Transmittal Slip';

if($moduledata['head']['isinvoiced']){
  $readonlybtn = " disabled ";
}else{
  $readonlybtn = "";
}//end if
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
                      
                      <button type="button" class="btn btn-default btn-success stockbtn tx-createsj" disabled="true"><b><i class="fa fa-plus add_btn"></i> Create SJ</b></button>
                      <button type="button" class="btn btn-default btn-success stockbtn tx-addexsj" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Add External SJ</b></button>';

                    }else{
                      echo'<button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      
                      <button '.$readonlybtn.' type="button" class="btn btn-default 
                      btn-success stockbtn tx-createsj"><b><i class="fa fa-plus add_btn"></i> Create SJ
                      </b></button>

                     <button type="button" class="btn btn-default btn-success 
                      stockbtn tx-addexsj"><b><i class="fa fa-bolt quickadd_btn"></i> Add External SJ</b>
                      </button>';
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
                    <button type="button" class="btn btn-default btn-success stockbtn tx-createsj" disabled="true"><b><i class="fa fa-plus add_btn"></i> Create SJ</b></button>
                    <button type="button" class="btn btn-default btn-success stockbtn tx-addexsj" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Add External SJ</b></button>
                    
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
                <div class="invoice-col col-md-6">
                <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" style="display:none;">
                <h6 class="aimslabel"><b>Document #:  
                <div class="input-group">
                    <input name = "docno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['docno'];}?>" type="text" class="moduletxt txtdocno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="docnolookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                
                <h6 class="aimslabel rfdocnoblock"><b>Route Formation #:  
                <div class="input-group">
                    <input readonly name = "rfdocno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['rfdocno'];}?>" type="text" class="moduletxt txtroutedocno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="rfdocnolookup" href="#" style="display:none;"><i class="fa fa-chevron-circle-down"></i></a></div>
                    <input name="rftrno" value="<?php if(isset($moduledata)){echo $moduledata['head']['rftrno'];}?>" type="text" class="moduletxt txtboxrftrno form-control input-sm" style="display:none;">
                </div></h6>

                <h6 class="aimslabel"><b>Approval Code: <input readonly name = "approvalcode" value ="<?php if(isset($moduledata)){echo $moduledata['head']['approvalcode'];}?>" type="text" class="moduletxt txtapprovalcode form-control input-sm" disabled="true"></b></h6>

                <!-- DATE -->
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>"  class="paedit input-group date dpYears">
                  <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b>Date :</b>
                <input disabled="true" name="dateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdateidview form-control input-sm"></h6>
                <!-- DATE -->
                </div><!-- /.col -->
                
                <div class="invoice-col col-md-6">
                
                <h6 class="aimslabel"><b>Route: <input readonly name = "route" value ="<?php if(isset($moduledata)){echo $moduledata['head']['route'];}?>" type="text" class="moduletxt txtroute form-control input-sm" disabled="true"></b></h6>
                <input type="hidden" value="<?php if(isset($moduledata)){echo $moduledata['head']['routeid'];}?>" class="moduletxt txtrouteid" name="routeid">
                <h6 class="aimslabel"><b>Salesman: <input readonly name = "agent" value ="<?php if(isset($moduledata)){echo $moduledata['head']['agent'];}?>" type="text" class="moduletxt txtagentcode form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b>Notes: <textarea  disabled="true" name="rem" class="moduletxt txtnotes form-control" style="resize:none;"  rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['rem'];}?></textarea></b></h6>

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
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">SJ Documents</a></li>
              <li><a href="#tab_2"  class="clickrouteguide" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Route Guide</a></li>
              <li><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Other Info</a></li>
              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php /*if(isset($moduledata)){echo $moduledata['head']['grandtotal'];}*/ ?></h6></li>

              <li class="pull-right"><h6 class="txtgrandtotalcbm" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL CBM: <?php /*if(isset($moduledata)){echo $moduledata['head']['grandtotal'];}*/ ?></h6></li>

              <li class="pull-right"><h6 class="txtgrandtotaltons" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL TONS: <?php /*if(isset($moduledata)){echo $moduledata['head']['grandtotal'];}*/ ?></h6></li>

              <li class="pull-right"><h6 class="txtgrandtotalcustomer" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;"># OF CUSTOMERS: <?php /*if(isset($moduledata)){echo $moduledata['head']['grandtotal'];}*/ ?></h6></li>

              <li class="pull-right"><h6 class="txtgrandtotaltrnx" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND # OF TRNX: <?php /*if(isset($moduledata)){echo $moduledata['head']['grandtotal'];}*/ ?></h6></li>



            </ul>
              
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                             <div class="box-body mod-tble">
                             <table class="table tbl-fix  bodytable table-hover">
                              <thead>
                                  <tr>
                                      <th class="col-min aimslabel"><span class="text">Options</span></th>
                                      <th class="col-codes aimslabel"><span class="text">SJ #</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Ourref</span></th>
                                      <th class="col-min aimslabel"><span class="text">SJ Date</span></th>
                                      <th class="col-description aimslabel"><span class="text">Customer</span></th>
                                      <th class="col-description aimslabel"><span class="text">Address</span></th>
                                      <th class="col-currency aimslabel"><span class="text">Amount</span></th>
                                      <th class="col-currency aimslabel"><span class="text">Tonnage</span></th>
                                      <th class="col-currency aimslabel"><span class="text">CBM</span></th>
                                      <th class="col-description aimslabel"><span class="text">Notes</span></th>
                                  </tr>
                              </thead>

                              <tbody class="tx-modulebody">
                                    
                              </tbody>
                            </table>  
                        </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
              </div>
              </div>
              <!-- /.tab-pane -->

               <div class="tab-pane" id="tab_2">
                  <div class="row">
                    <div class="col-md-12">
                    <button style="display: none;" class="btn btn-success btn-xs tx-generaterouteguide" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Generate Route Guide</button>
                    <button style="display: none;" class="btn btn-success btn-xs tx-printout" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Print</button>
                        <div class="box box-solid box-success">
                             <div class="box-body mod-tble">
                             <table class="table tbl-fix  bodytable table-hover">
                              <thead>
                                  <tr>
                                      <th class="col-min aimslabel"><span class="text">Option</span></th>
                                      <th class="col-min aimslabel"><span class="text">No.</span></th>
                                      <th class="col-min aimslabel"><span class="text">Kilometers</span></th>
                                      <th class="col-codes aimslabel"><span class="text">Code</span></th>
                                      <th class="col-description aimslabel"><span class="text">Customer</span></th>
                                      <th class="col-description aimslabel"><span class="text">Address</span></th>
                                  </tr>
                              </thead>

                              <tbody class="tx-routeguide">
                                    
                              </tbody>
                            </table>  
                        </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
              </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_3">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                             <div class="box-body mod-tble">
                             <div class="col-md-4">
                              <h6 class="aimslabel"><b>Truck: <input name = "truck" value ="<?php if(isset($moduledata)){echo $moduledata['head']['approvalcode'];}?>" type="text" class="moduletxt txttxeditable txtruck form-control input-sm" disabled="true"></b></h6>
                              <h6 class="aimslabel"><b>Driver: <input name = "driver" value ="<?php if(isset($moduledata)){echo $moduledata['head']['approvalcode'];}?>" type="text" class="moduletxt txttxeditable txtdriver form-control input-sm" disabled="true"></b></h6>
                              <h6 class="aimslabel"><b>Checker: <input name = "checker" value ="<?php if(isset($moduledata)){echo $moduledata['head']['approvalcode'];}?>" type="text" class="moduletxt txttxeditable txtchecker form-control input-sm" disabled="true"></b></h6>
                              <!-- DATE -->
                              <h6 class="aimslabel dateidlookup" style="display:none;"><b>Dispatched Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>"  class="paedit input-group date dpYears">
                                <input type="text" name = "dispatchdate" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdispatchdate form-control input-sm" disabled="true">
                                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                              </div></b></h6>

                              <h6 class="aimslabel dateidview"><b>Dispatched Date :</b>
                              <input disabled="true" name="dispatchdateview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdispatchdateview form-control input-sm"></h6>
                              
                              <!-- DATE -->
                              <h6 class="aimslabel dateidlookup" style="display:none;"><b>Return Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>"  class="paedit input-group date dpYears">
                                <input type="text" name = "returndate" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtreturndate form-control input-sm" disabled="true">
                                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                              </div></b></h6>

                              <h6 class="aimslabel dateidview"><b>Return Date: </b>
                              <input disabled="true" name="returndateview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtreturndateview form-control input-sm"></h6>
                              </div>
                              <div class="col-md-8">
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
