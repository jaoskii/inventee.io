<?php
use yii\helpers\Url;
$this->title = 'Tax Wheld';
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

                <div class="box-tools pull-right">
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

                    <!--  <button type="button" data-toggle="tooltip" title="Transaction Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button> -->

                    <?php 
                    if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
                      echo'
                      <button disabled="true" type="button" class="btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save all detail Entries</b></button>
                      <button type="button"  data-toggle="tooltip" title="Add New Tax Menu" class="btn btn-default btn-success stockbtn stock-btnadd2" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add Tax Menu</b></button>';

                    }else{
                      echo'
                      <button type="button" class="btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save all detail Entries</b></button>
                      <button type="button"  data-toggle="tooltip" title="Add New Tax Menu" class="btn btn-default 
                      btn-success stockbtn stock-btnadd2"><b><i class="fa fa-plus add_btn"></i> Add Tax Menu
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
                    <button type="button" data-toggle="tooltip" title="New transaction" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save Transaction Head" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Edit Transaction" class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                    <button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                    <button  style="display:none;" type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i> Print</b></button>
                    <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                    <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
                    <button type="button" data-toggle="tooltip" title="Unpost Transaction" class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                    <button type="button" data-toggle="tooltip" title="Post Transaction" class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>
                    
                    <button disabled="true" type="button" class="btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save all detail Entries</b></button>
                    
                    <button type="button"  data-toggle="tooltip" title="Add New Item" class="btn btn-default btn-success stockbtn stock-btnadd2" disabled="true"><b><i class="fa fa-plus add_btn"></i>  Add Tax Menu</b></button>
                            
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
                
                

                </div><!-- /.col -->
                
                <div class="invoice-col col-md-3">

                <h6 class="aimslabel"><b>Supplier: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b></h6>

                <h6 class="aimslabel"><b>Address: <textarea disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['address'];}?></textarea></b></h6>
                </div><!-- /.col -->
                
                <!-- DATE -->
                <div class="invoice-col col-md-3">
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Period: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                  <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b>Period :</b>
                <input disabled="true" name="dateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdateidview form-control input-sm"></h6>
                <!-- DATE -->

               <h6 class="aimslabel dateidlookup" style="display:none;"><b><div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                  <input type="text" name = "dateid2" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid2'];}?>" size="12" class="moduletxt txtdateid2 form-control input-sm" disabled="true">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b></b>
                <input disabled="true" name="dateid2view" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid2'];}?>" type="text" class="moduletxt txtdateid2view form-control input-sm"></h6>
                <!-- DATE -->

                </div><!-- /.col -->

                <!-- //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD start -->
                <div class="invoice-col col-md-3">
<!--                   <h6 class="aimslabel viewbyquarterview"><b>View by Quarter: </b>
                  <input disabled="true" name="viewbyquarterview" value ="<?php if(isset($moduledata)){switch ($moduledata['head']['quarter']) {case '1': echo '1st Quarter'; break; case '2': echo '2nd Quarter'; break; case '3': echo '3rd Quarter'; break; case '4': echo '4th Quarter'; break;}}?>" type="text" class="moduletxt txtviewbyquarterview form-control input-sm"></h6>
 -->
                <h6 class="aimslabel"><b>View by Quarter: <div class="input-group">
                <input readonly name = "viewbyquarter" value ="<?php if(isset($moduledata)){switch ($moduledata['head']['quarter']) {case '1': echo '1st Quarter'; break; case '2': echo '2nd Quarter'; break; case '3': echo '3rd Quarter'; break; case '4': echo '4th Quarter'; break;}}?>" type="text" class="moduletxt viewbyquarter form-control input-sm" disabled="true"></b>
                <div class="quarterlookupbtn input-group-addon">
                  <a style="display:none;" class ="quarterlookup proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a>
                </div>
                </div></h6>

                <!--   <h6 class="viewbyquarter aimslabel viewbyfilters" style="display:none;"><b>View by Quarter: </b>
                    <select id="viewbyquarter" class="selectquarter moduletxt txtviewbyquarter input-sm form-control" name="viewbyquarter">
                      <option value="" selected></option>
                      <option value="1">1st Quarter</option>
                      <option value="2">2nd Quarter</option>
                      <option value="3">3rd Quarter</option>
                      <option value="4">4th Quarter</option>
                    </select>
                  </h6>
                 --></div><!-- /.col -->
                <!-- //WTODO: JLY 2019.1.22 RTT TW ADD QUARTER IN HEAD end -->





                <div class="invoice-col col-md-3">
                
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
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>
              

              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['totalcr'];} ?></h6></li>

              <li class="pull-right"><h6 class="txtitemcount" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['totaldb'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));} ?></h6></li>

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
                      <?php 
                        if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                        if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                        echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success"></div>';
                      ?>
                    </div>
              </div>
              </div>
              <!-- /.tab-pane -->
            </div>

            <!-- /.tab-content -->
          </div>
</div>
</div>
