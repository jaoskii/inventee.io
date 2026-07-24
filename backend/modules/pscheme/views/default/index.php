<?php
use yii\helpers\Url;
$this->title = 'Price Scheme';
?>

<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
          <b><h6 class="txttrno" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Trno: <?php if(isset($moduledata)){echo $moduledata['head']['trno'];} ?>
          </h6></b>
          <h6 id="mindocno" style="display:none;">
            <b>Docno: <?php if(isset($moduledata)){echo $moduledata['head']['docno'];} ?></b>
          </h6>
          <!-- first -->
          <div class="btn-group">
            <?php 
            //IF STATEMENT 1st
            if($moduledata['head']['isposted']) 
            { //IF POSTED SHOW POSTED FLAGS
              switch (Yii::$app->systemsettings->companyConfig()) {
                case 'SOUTHCENTRAL':
                  switch ($moduledata['head']['isapproved']) {
                    case 1:
                      echo'<a href="#" class="disapproved-flag pull-right" style="display:none;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
                      <span class="pull-right text-red"><i class="fa fa-thumbs-down" style="font-size: 15px;"></i> DISAPPROVED</span></a>';
                      echo'<a href="#" class="approved-flag pull-right" style="display:block;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
                      <span class="pull-right text-green"><i class="fa fa-thumbs-up" style="font-size: 15px;"></i> APPROVED</span></a>';
                    break;
                    case 0:
                      echo'<a href="#" class="disapproved-flag pull-right" style="display:block;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
                      <span class="pull-right text-red"><i class="fa fa-thumbs-down" style="font-size: 15px;"></i> DISAPPROVED</span></a>';
                      echo'<a href="#" class="approved-flag pull-right" style="display:none;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
                      <span class="pull-right text-green"><i class="fa fa-thumbs-up" style="font-size: 15px;"></i> APPROVED</span></a>';
                    break;
                  }//END SWITCH
                break;
              }//end if
              echo'<a href="#" class="posted-flag pull-right" style="display:block;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-yellow"><i class="fa fa-check-circle" style="font-size: 15px;"></i> POSTED</span></a>';
            } 
            else 
            {
              echo'<a href="#" class="disapproved-flag pull-right" style="display:none;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-thumbs-down" style="font-size: 15px;"></i> DISAPPROVED</span></a>';
              echo'<a href="#" class="approved-flag pull-right" style="display:none;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-green"><i class="fa fa-thumbs-up" style="font-size: 15px;"></i> APPROVED</span></a>';
              echo'<a href="#" class="posted-flag pull-right" style="display:none;font-weight: bold;padding-right:3px;  font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-yellow"><i class="fa fa-check-circle" style="font-size: 15px;"></i> POSTED</span></a>';
            }
            //end if statement 1st

            //if statement 2nd
            if($moduledata['head']['islocked'])
            { //IF LOCKED SHOW LOCKED FLAGS
              echo'<a href="#" class="locked-flag pull-right" style="display:block;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
            }
            else
            {
              echo'<a href="#" class="locked-flag pull-right" style="display:none;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
            }
          ?>
          </div><!--btn-group-->

          <!-- end first -->
          <!-- second -->
          <div class="pull-right">
             
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew">
                <b><i class="new_btn fa fa-file"></i> New</b>
              </button>
              <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;">
                <b><i class="save_btn fa fa-save"></i> Save</b>
              </button>

              <?php
                if($moduledata['head']['isposted']) {
                  echo'<button type="button" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>';
                } else {
                  if($moduledata['head']['islocked']) {
                    echo'<button type="button" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>';
                  } else {
                    echo'<button type="button" class="btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;"><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>';
                  }
                }
              ?>
                

              <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;">
                <b><i class="cancel_btn fa fa-times"></i> Cancel</b>
              </button>
              <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint">
                <b><i class="print_btn fa fa-print"></i> Print</b>
              </button>
              <?php
                if($moduledata['head']['isposted']) {
                  echo'<button type="button" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                  <button type="button" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="lock_btn fa fa-lock"></i> Lock</b></button>
                  <button type="button" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="unlock_btn fa fa-unlock"></i> Unlock</b></button>
                  <button type="button" class="headbtn btnactive module-btnunpost btn btn-default btn-success" style="display:block;"><b><i class="unpost_btn fa fa-history"></i> Unpost</b></button>
                  <button type="button" class="headbtn module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="post_btn fa fa-check"></i> Post</b></button>';
                } else {
                  if($moduledata['head']['islocked']) {
                    echo'<button type="button" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                    <button type="button" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="lock_btn fa fa-lock"></i> Lock</b></button>
                    <button type="button" class="headbtn btnactive module-btnunlock btn btn-default btn-success" style="display:block;"><b><i class="unlock_btn fa fa-unlock"></i> Unlock</b></button>';
                  } else {
                    echo'<button type="button" class="headbtn btnactive module-btndelete btn btn-default btn-success"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                    <button type="button" class="headbtn btnactive module-btnlock btn btn-default btn-success" style="display:block;"><b><i class="lock_btn fa fa-lock"></i> Lock</b></button>
                    <button type="button" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="unlock_btn fa fa-unlock"></i> Unlock</b></button>';
                  }
                  echo'<button type="button" class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="unpost_btn fa fa-history"></i> Unpost</b></button>
                  <button type="button" class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:block;"><b><i class="post_btn fa fa-check"></i> Post</b></button>';
                }
              ?>
              <!--php-->
              <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs">
                <b><i class="logs_btn fa fa-list"></i> Logs</b>
              </button>

              <?php 
                if($moduledata['head']['islocked'] || $moduledata['head']['isposted']) {
                  echo'<button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save Stock Items</b></button>
                  <button type="button" class="btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="add_btn fa fa-plus"></i> Add Item</b></button>
                  <button type="button" class="btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="quickadd_btn fa fa-bolt"></i> Quick Add</b></button>';
                } else {
                  echo'<button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save Stock Items</b></button>
                  <button type="button" class="btn btn-default btn-success stockbtn stock-btnadd"><b><i class="add_btn fa fa-plus"></i> Add Item</b></button>
                  <button type="button" class="btn btn-default btn-success stockbtn stock-btnquickadd"><b><i class="quickadd_btn fa fa-bolt"></i> Quick Add</b></button>';
                }
              ?>
              <!--php-->
              <button id ="<?php echo $moduleid.'-btnnavfirst';?>" class="btn-navs btn btn-default btn-success btn-navfirst">
                <b><i class="fa fa-fast-backward page_nav_icons"></i></b>
              </button>
              <button id ="<?php echo $moduleid.'-btn-navprev';?>" class="btn-navs btn btn-default btn-success btn-navprev">
                <b><i class="fa fa-backward page_nav_icons"></i></b>
              </button>
              <button id ="<?php echo $moduleid.'-btnnavnext';?>" class="btn-navs btn btn-default btn-success btn-navnext">
                <b><i class="fa fa-forward page_nav_icons"></i></b>
              </button>
              <button id ="<?php echo $moduleid.'-btnnavlast';?>" class="btn-navs btn btn-default btn-success btn-navlast">
                <b><i class="fa fa-fast-forward page_nav_icons"></i></b>
              </button>
              <button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button style="margin-top:3px;" class="btn btn-box-tool jaox">
                <i class="jaox_ico fa fa-minus"></i>
              </button>
          </div> <!--pull-right-->
          
      </div><!--modulehead box-header with-border-->
    </div><!--box box-solid box-success-->

      <div class="box-body">
        <div class="pull-right" style="margin-top:-15px;"></div>
          <div class="invoice-info col-md-12" style="margin-left:-15px;">
            <div class="invoice-col col-md-4">
                
              <h6 class="aimslabel"><b>Document #:  
                <div class="input-group">
                    <input name = "docno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['docno'];}?>" type="text" class="moduletxt txtdocno input-sm form-control">
                    <div class="frmdocumentno input-group-addon">
                      <a class ="psdocnolookup" href="#">
                        <i class="fa fa-chevron-circle-down"></i>
                      </a>
                    </div>
                </div>
              </h6>
              
              <h6 class="aimslabel clientcodeview" style="display:block;"><b>Branch Code: 
                <input name="clientcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="txtclientcodeview form-control input-sm" disabled="true"></b>
              </h6>

              <h6 class="aimslabel clientcodelookup" style="display:none;"><b>Branch Code: 
                <div class="input-group">
                  <input name = "client" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>"  type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true"></b>
                  <div class="clientlookupbtn input-group-addon">
                    <a class ="psclientlookup" href="#">
                      <i class="fa  fa-chevron-circle-down"></i>
                    </a>
                  </div>
                </div>
              </h6>

              <h6 class="aimslabel"><b>Branch: 
                <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b>
              </h6>

              <h6 class="aimslabel nobody"><b>Ship to: 
                <textarea disabled="true" name="shipto" class="moduletxt txtshipto form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['shipto'];}?>
                </textarea></b>
              </h6>

            </div><!--invoice-col col-md-3-->

            <div class="invoice-col col-md-4">
              <h6 class="aimslabel"><b>Your Ref: 
                <input name = "yourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['yourref'];}?>" type="text" class="moduletxt txtyourref form-control input-sm" disabled="true"></b>
              </h6>
              
              <h6 class="aimslabel"><b>Our Ref: 
                <input name="ourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['ourref'];}?>" type="text" class="moduletxt txtourref form-control input-sm" disabled="true"></b>
              </h6>
              
              <h6 class="aimslabel"><b>Address: 
                <textarea disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['address'];}?>
                </textarea></b>
              </h6>

            </div><!--invoice-col col-md-3 -->

            <!-- DATE -->
            <div class="invoice-col col-md-4">
              <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: 
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>" class="paedit input-group date dpYears">
                  <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                  <div class="dateid-lookup input-group-addon add-on">
                    <a href="#">
                      <i class="fa fa-chevron-circle-down"></i>
                    </a>
                  </div>
                </div></b>
              </h6>

              <h6 class="aimslabel dateidview"><b>Date :</b>
                <input disabled="true" name="dateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdateidview form-control input-sm">
              </h6>
              <!-- DATE -->

              <!-- WAREHOUSE -->
              <h6 class="aimslabel whcodeview"><b>Warehouse :</b>
                <input disabled="true" name="warehouseview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['wh'] . "~" . $moduledata['head']['whid'];}?>" type="text" class="moduletxt txtwarehouseview form-control input-sm">
              </h6>

              <h6 class="aimslabel whcodelookup" style="display:none;"><b>Warehouse :</b>
                <div class="input-group">
                  <input disabled="true" name="warehouse" value ="<?php if(isset($moduledata)){echo $moduledata['head']['wh'] . "~" . $moduledata['head']['whid'];}?>" type="text" class="moduletxt txtwarehouse form-control input-sm">
                  <div class="frmwh input-group-addon">
                    <a class ="whlookuphead" href="#">
                      <i class="fa fa-chevron-circle-down"></i>
                    </a>
                  </div>
                </div>
              </h6>
              <!-- WAREHOUSE -->

              <h6 class="aimslabel"><b>Notes: 
                <textarea  disabled="true" name="rem" class="moduletxt txtnotes form-control" style="resize:none;"  rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['rem'];}?>
                </textarea></b>
              </h6>
                
              <?php
                switch (Yii::$app->systemsettings->companyConfig()) 
                {
                  case 'SOUTHCENTRAL':
                    echo '<h6 class="aimslabel"><b>RF #: <input value ="';
                      if(isset($moduledata)){echo $moduledata['head']['rfdocno'];}
                      echo'" type="text" class="txtroutedocno form-control input-sm" disabled="true"></b></h6>';
                  break;
                }//END SWITCH
              ?>

            </div><!--invoice-col col-md-3-->

            <div class="invoice-col col-md-2">
              <h6 class="aimslabel nobody"><b>Due Date :</b>
                <input disabled="true" name="due" value ="<?php if(isset($moduledata)){echo $moduledata['head']['due'];}?>" type="text" class="moduletxt txtdatedue nobody form-control input-sm">
              </h6>

              <h6 class="aimslabel termslookup" style="display:none;"><b class="nobody">Terms :</b>
                <div class="input-group nobody">
                  <input readonly="" name="terms" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" class="moduletxt txtterms form-control input-sm">
                  <div class="input-group-addon">
                    <a class ="btnshowterms" href="#">
                       <i class="fa fa-chevron-circle-down"></i>
                    </a>
                  </div>
                </div>
              </h6>

              <h6 class="aimslabel nobody"><b>Forex: 
                <input disabled="true" name="forex" value="<?php if(isset($moduledata)){echo $moduledata['head']['forex'];}?>" type="text" class="moduletxt txtforex form-control input-sm"></b>
              </h6>
              <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" disabled="true" style="display:none;">
              
              
              <h6 class="aimslabel nobody"><b>Sales type:
                <select disabled = "true" id="salestype" class="salestype input-sm form-control">
                  <?php if(isset($moduledata)){echo '<option>'.$moduledata['head']['salestype'] . '</option>';}?>
                </select>
              </h6>

              <?php

                switch (Yii::$app->systemsettings->companyConfig()) 
                {
                  case 'SOUTHCENTRAL':
                    echo '<h6 class="aimslabel"><b>Trnx type:';
                        echo '<select disabled = "true" id="trnxtype" class="trnxtype input-sm form-control">';
                          if(isset($moduledata)){
                            echo '<option>'.$moduledata['head']['trnxtype'] . '</option>';
                          }//end if
                        echo '</select>';
                    echo '</h6>';

                    echo '<h6 class="aimslabel">
                          <b>Approval Code: <input value ="';
                          if(isset($moduledata)){
                            echo $moduledata['head']['approvalcode'];
                          }
                    echo '" type="text" class="txtapprovalcode form-control input-sm" disabled="true">
                          </b></h6>';
                  break;
                }//END SWITCH CASE
              ?>

            </div><!--invoice-col col-md-2-->

          </div><!--invoice-col col-md-12-->

        </div><!--pull-right-->
      </div><!--box-body-->





    
  </div><!--col-md-12-->




</div><!--row-->

<?php
require('stockview.php');

?>