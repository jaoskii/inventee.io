<?php
use yii\helpers\Url;
$this->title = 'General Journal';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<div  id="dragme">
<i onclick="myFunction()" class="title fa fa-list"></i><br/>
<ul id="menu-float">
<?php if($moduledata['head']['trno'] != null){?>
   <!-- ADD CLASS (pop-btn btn-xx ) to BUTTONS added here also Remove button captions -->  
    <!-- then add (<div class="list">CAPTION</div>) after each </button>
<div class="list">CAPTION</div> -->
    <!-- BEGIN BTN GROUP -->

    <button class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> </b></button>
<div class="list">New</div>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button>
<div class="list">Save</div>
    <?php
      if($moduledata['head']['isposted']) {
        echo'<button class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> </b></button>
<div class="list">Edit</div>';
      } else {
        if($moduledata['head']['islocked']) {
          echo'<button class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> </b></button>
<div class="list">Edit</div>';
        } else {
          echo'<button class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;"><b><i class="fa fa-pencil edit_btn"></i> </b></button>
<div class="list">Edit</div>';
        }
      }
    ?>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button>
<div class="list">Cancel</div>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i> </b></button>
<div class="list">Print</div>  
    <?php
      if($moduledata['head']['isposted']) {
        echo'<button class="pop-btn btn-xx headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> </b></button>
<div class="list">Delete</div>
        <button class="pop-btn btn-xx headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> </b></button>
<div class="list">Lock</div>
        <button class="pop-btn btn-xx headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button>
<div class="list">Unlock</div>
        <button class="pop-btn btn-xx headbtn btnactive module-btnunpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-history unpost_btn"></i> </b></button>
<div class="list">Unpost</div>
        <button class="pop-btn btn-xx headbtn module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> </b></button>
<div class="list">Post</div>';
      } else {
        if($moduledata['head']['islocked']) {
          echo'<button class="pop-btn btn-xx headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> </b></button>
<div class="list">Delete</div>
          <button class="pop-btn btn-xx headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> </b></button>
<div class="list">Lock</div>
          <button class="pop-btn btn-xx headbtn btnactive module-btnunlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button>
<div class="list">Unlock</div>';
        } else {
          echo'<button class="pop-btn btn-xx headbtn btnactive module-btndelete btn btn-default btn-success"><b><i class="fa fa-trash delete_btn"></i> </b></button>
<div class="list">Delete</div>
          <button class="pop-btn btn-xx headbtn btnactive module-btnlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-lock lock_btn"></i> </b></button>
<div class="list">Lock</div>
          <button class="pop-btn btn-xx headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button>
<div class="list">Unlock</div>';
        }
        echo'<button class="pop-btn btn-xx headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> </b></button>
<div class="list">Unpost</div>
        <button class="pop-btn btn-xx headbtn btnactive module-btnpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-check post_btn"></i> </b></button>
<div class="list">Post</div>';
      }
    ?>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> </b></button>
<div class="list">Logs</div>
    <?php 
      if($moduledata['head']['islocked'] || $moduledata['head']['isposted']) {
        echo'<button disabled="true" class="pop-btn btn-xx btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button>
<div class="list">Save All Entries</div>
        <button disabled="true" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnaddentries"><b><i class="fa fa-plus add_btn"></i> </b></button>
<div class="list">Add Entries</div>
        <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btngenerateending"><b><i class="fa fa-file-text coa_btn"></i> </b></button>
<div class="list">Generate Closing Entries</div>
        <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btncoalookup"><b><i class="fa fa-list-alt coa_btn"></i> </b></button>
<div class="list">Add COA</div>
        <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> </b></button>
<div class="list">Unpaid</div>
        <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnchecks"><b><i class="fa fa-folder checks_btn"></i> </b></button>
<div class="list">Checks</div>';
      } else {
        echo'<button class="pop-btn btn-xx btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button>
<div class="list">Save All Entries</div>
        <button class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnaddentries"><b><i class="fa fa-plus add_btn"></i> </b></button>
<div class="list">Add Entries</div>
        <button style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btngenerateending"><b><i class="fa fa-file-text coa_btn"></i> </b></button>
<div class="list">Generate Closing Entries</div>
        <button style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btncoalookup"><b><i class="fa fa-list-alt coa_btn"></i> </b></button>
<div class="list">Add COA</div>
        <button style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> </b></button>
<div class="list">Unpaid</div>
        <button style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnchecks"><b><i class="fa fa-folder checks_btn"></i> </b></button>
<div class="list">Checks</div>';
      }
    ?>
    <button id ="<?php echo $moduleid.'-btnnavfirst';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
    <button id ="<?php echo $moduleid.'-btn-navprev';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
    <button id ="<?php echo $moduleid.'-btnnavnext';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
    <button id ="<?php echo $moduleid.'-btnnavlast';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>
    <button style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
    <button style="margin-top:3px;" class="pop-btn btn-xx btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
<?php } else {
  echo'
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> </b></button>
<div class="list">New</div>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button>
<div class="list">Save</div>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> </b></button>
<div class="list">Edit</div>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button>
<div class="list">Cancel</div>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;"><b><i class="fa fa-print print_btn"></i> </b></button>
<div class="list">Print</div>
    <button class="pop-btn btn-xx headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> </b></button>
<div class="list">Delete</div>
    <button class="pop-btn btn-xx headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> </b></button>
<div class="list">Lock</div>
    <button class="pop-btn btn-xx headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button>
<div class="list">Unlock</div>
    <button class="pop-btn btn-xx headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> </b></button>
<div class="list">Unpost</div>
    <button class="pop-btn btn-xx headbtn btnactive module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> </b></button>
<div class="list">Post</div>
    <button class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;"><b><i class="fa fa-list logs_btn"></i> </b></button>
<div class="list">Logs</div>
    <button disabled="true" class="pop-btn btn-xx btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button>
<div class="list">Save All Entries</div>
    <button disabled="true" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnaddentries"><b><i class="fa fa-plus add_btn"></i> </b></button>
<div class="list">Add Entries</div>
    <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btngenerateending"><b><i class="fa fa-list-alt coa_btn"></i> </b></button>
<div class="list">Generate Closing Entries</div>
    <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btncoalookup"><b><i class="fa fa-list-alt coa_btn"></i> </b></button>
<div class="list">Add COA</div>
    <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> </b></button>
<div class="list">Unpaid</div>
    <button disabled="true" style="display:none;" class="pop-btn btn-xx btn btn-default btn-success stockbtn detail-btnchecks"><b><i class="fa fa-folder checks_btn"></i> </b></button>
<div class="list">Checks</div>
    <button disabled="true" id ="'.$moduleid.'-btnnavfirst" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
    <button disabled="true" id ="'.$moduleid.'-btn-navprev" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
    <button disabled="true" id ="'.$moduleid.'-btnnavnext"  class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
    <button disabled="true" id ="'.$moduleid.'-btnnavlast" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>
    <button style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
    <button style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>';
}?>

</ul>
</div> <!-- dragme end -->

<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <b><h6 class="txttrno" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Trno: <?php if(isset($moduledata)){echo $moduledata['head']['trno'];} ?></h6></b>
        <h6 id="mindocno" style="display:none;"><b>Docno: <?php if(isset($moduledata)){echo $moduledata['head']['docno'];} ?></b></h6>
        <div class="btn-group" >
          <?php 
            if($moduledata['head']['isposted']) {
              echo'<a href="#" class="posted-flag pull-right" style="display:block;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-yellow"><i class="fa fa-check-circle" style="font-size: 15px;"></i> POSTED</span></a>';
            } else {
              echo'<a href="#" class="posted-flag pull-right" style="display:none;font-weight: bold;padding-right:3px;  font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-yellow"><i class="fa fa-check-circle" style="font-size: 15px;"></i> POSTED</span></a>';
            }
            if($moduledata['head']['islocked']) {
              echo'<a href="#" class="locked-flag pull-right" style="display:block;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
            } else {
              echo'<a href="#" class="locked-flag pull-right" style="display:none;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
            }
          ?>
        </div>
        <div class="btn-x pull-right">
          <?php if($moduledata['head']['trno'] != null){?>
            <div class="btn-group">
              <button class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
              <button class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
              <?php
                if($moduledata['head']['isposted']) {
                  echo'<button class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                } else {
                  if($moduledata['head']['islocked']) {
                    echo'<button class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                  } else {
                    echo'<button class="btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                  }
                }
              ?>
              <button class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
              <button class="btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i> Print</b></button>  
              <?php
                if($moduledata['head']['isposted']) {
                  echo'<button class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                  <button class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                  <button class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
                  <button class="headbtn btnactive module-btnunpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                  <button class="headbtn module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>';
                } else {
                  if($moduledata['head']['islocked']) {
                    echo'<button class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                    <button class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                    <button class="headbtn btnactive module-btnunlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>';
                  } else {
                    echo'<button class="headbtn btnactive module-btndelete btn btn-default btn-success"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
                    <button class="headbtn btnactive module-btnlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
                    <button class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>';
                  }
                  echo'<button class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
                  <button class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-check post_btn"></i> Post</b></button>';
                }
              ?>
              <button class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
              <?php 
                if($moduledata['head']['islocked'] || $moduledata['head']['isposted']) {
                  echo'<button disabled="true" class="btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save all detail Entries</b></button>
                  <button disabled="true" class="btn btn-default btn-success stockbtn detail-btnaddentries"><b><i class="fa fa-plus add_btn"></i> Add Entries</b></button>
                  <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btngenerateending"><b><i class="fa fa-file-text coa_btn"></i> Generate Closing Entries</b></button>
                  <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btncoalookup"><b><i class="fa fa-list-alt coa_btn"></i> Add COA</b></button>
                  <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> Unpaid</b></button>
                  <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btnchecks"><b><i class="fa fa-folder checks_btn"></i> Checks</b></button>';
                } else {
                  echo'<button class="btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save all detail Entries</b></button>
                  <button class="btn btn-default btn-success stockbtn detail-btnaddentries"><b><i class="fa fa-plus add_btn"></i> Add Entries</b></button>
                  <button style="display:none;" class="btn btn-default btn-success stockbtn detail-btngenerateending"><b><i class="fa fa-file-text coa_btn"></i> Generate Closing Entries</b></button>
                  <button style="display:none;" class="btn btn-default btn-success stockbtn detail-btncoalookup"><b><i class="fa fa-list-alt coa_btn"></i> Add COA</b></button>
                  <button style="display:none;" class="btn btn-default btn-success stockbtn detail-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> Unpaid</b></button>
                  <button style="display:none;" class="btn btn-default btn-success stockbtn detail-btnchecks"><b><i class="fa fa-folder checks_btn"></i> Checks</b></button>';
                }
              ?>
              <button id ="<?php echo $moduleid.'-btnnavfirst';?>" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
              <button id ="<?php echo $moduleid.'-btn-navprev';?>" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
              <button id ="<?php echo $moduleid.'-btnnavnext';?>" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
              <button id ="<?php echo $moduleid.'-btnnavlast';?>" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
              <button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
            </div>        
          <?php } else {
            echo'
            <div class="btn-group">
              <button class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
              <button class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
              <button class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
              <button class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
              <button class="btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;"><b><i class="fa fa-print print_btn"></i> Print</b></button>
              <button class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> Delete</b></button>
              <button class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
              <button class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
              <button class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
              <button class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>
              <button class="btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
              <button disabled="true" class="btn btn-default btn-success stockbtn detailsaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save all detail Entries</b></button>
              <button disabled="true" class="btn btn-default btn-success stockbtn detail-btnaddentries"><b><i class="fa fa-plus add_btn"></i> Add Entries</b></button>
              <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btngenerateending"><b><i class="fa fa-list-alt coa_btn"></i> Generate Closing Entries</b></button>
              <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btncoalookup"><b><i class="fa fa-list-alt coa_btn"></i> Add COA</b></button>
              <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btnunpaid"><b><i class="fa fa-tags unpaid_btn"></i> Unpaid</b></button>
              <button disabled="true" style="display:none;" class="btn btn-default btn-success stockbtn detail-btnchecks"><b><i class="fa fa-folder checks_btn"></i> Checks</b></button>
              <button disabled="true" id ="'.$moduleid.'-btnnavfirst" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
              <button disabled="true" id ="'.$moduleid.'-btn-navprev" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
              <button disabled="true" id ="'.$moduleid.'-btnnavnext"  class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
              <button disabled="true" id ="'.$moduleid.'-btnnavlast" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
              <button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button style="margin-top:3px;display:none;" class="btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
            </div>';
          }?>
        </div>
      </div>
      <div class="box-body">
        <div class="pull-right" style="margin-top:-15px;"></div>
        <div class="invoice-info col-md-12" style="margin-left:-15px;">
          <div class="invoice-col col-md-3">
            <h6 class="aimslabel"><b>Document #: </b> 
              <div class="input-group">
                <input name = "docno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['docno'];}?>" type="text" class="moduletxt txtdocno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="docnolookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
              </div>
            </h6>
            <h6 class="aimslabel clientcodeview" style="display:block;"><b>Customer / Supplier Code:</b>
              <input name="clientcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="txtclientcodeview form-control input-sm" disabled="true">
            </h6>
            <h6 class="aimslabel clientcodelookup" style="display:none;"><b>Customer / Supplier Code:</b>
              <div class="input-group">
                <input name = "client" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true">
                <div class="clientlookupbtn input-group-addon"><a class ="clientlookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div>
              </div>
            </h6>
            <h6 class="aimslabel"><b>Customer / Supplier: </b>
              <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true">
            </h6>
          </div>
          <div class="invoice-col col-md-3">
            <h6 class="aimslabel"><b>Your Ref: </b>
              <input name = "yourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['yourref'];}?>" type="text" class="moduletxt txtyourref form-control input-sm" disabled="true">
            </h6>
            <h6 class="aimslabel"><b>Our Ref: </b>
              <input name="ourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['ourref'];}?>" type="text" class="moduletxt txtourref form-control input-sm" disabled="true">
            </h6>
            <h6 class="aimslabel"><b>Address: </b>
              <textarea disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['address'];}?></textarea>
            </h6>
          </div>
          <div class="invoice-col col-md-4">
            <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: </b>
              <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
              </div>
            </h6>
            <h6 class="aimslabel dateidview"><b>Date :</b>
              <input disabled="true" name="dateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdateidview form-control input-sm">
            </h6>
            <h6 class="nobody aimslabel"><b>Ship to: </b>
              <input disabled="true" name="shipto" value="<?php if(isset($moduledata)){echo $moduledata['head']['shipto'];}?>" type="text" class="moduletxt txtshipto form-control input-sm">
            </h6>
            <h6 class="aimslabel"><b>Notes: </b>
              <textarea  disabled="true" name="rem" class="moduletxt txtnotes form-control" style="resize:none;"  rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['rem'];}?></textarea>
            </h6>
            <h6 class="aimslabel"><b>Cost Center: </b>
              <div class="input-group">
                <input name = "costcenter" value ="<?php if(isset($moduledata)){echo $moduledata['head']['costcenter'];}?>" readonly type="text" class="moduletxt txtcostcenter input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="jlookupbtns costcenterlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
              </div>
            </h6>
          </div>
          <div class="invoice-col col-md-2">
            <h6 class="aimslabel termsview"><b>Terms: </b>
              <input name="termview" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" disabled=true class="txttermsview moduletxt form-control input-sm">
            </h6>
            <h6 class="aimslabel termslookup" style="display:none;"><b>Terms :</b>
              <div class="input-group">
                <input readonly="" name="terms" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" class="moduletxt txtterms form-control input-sm">
                <div class="input-group-addon"><a class ="btnshowterms" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
              </div>
            </h6>
            <h6 class="aimslabel nobody"><b>Forex: </b>
              <input disabled="true" name="forex" value="<?php if(isset($moduledata)){echo $moduledata['head']['forex'];}?>" type="text" class="moduletxt txtforex form-control input-sm">
            </h6>
            <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" disabled="true" style="display:none;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs bg-green">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>
        <li class="pull-right"><h6 class="txttotalcr" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL CREDIT: <?php if(isset($moduledata)){echo number_format($moduledata['head']['totalcr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));} ?></h6></li>
        <li class="pull-right"><h6 class="txttotaldb" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL DEBIT: <?php if(isset($moduledata)){echo number_format($moduledata['head']['totaldb'],Yii::$app->systemsettings->setDecimaldisplay('currency'));} ?></h6></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="row">
            <div class="col-md-12">
              <?php 
                if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success"></div>'
              ?>
                <!-- <div class="box box-solid box-success">
                    <div class="box-body mod-tble">
                    <table class="table tbl-fix bodytable table-hover">
                      <thead>
                        <tr>
                        <th class="col-min aimslabel">Options</th>
                          <th class="col-min aimslabel">Date</th>
                          <th class="col-codes aimslabel">Check #</th>
                          <th class="col-codes aimslabel">Account #</th>
                          <th class="col-description aimslabel">Account Title</th>
                          <th class="col-codes aimslabel">Custmr/Supplr</th>
                          <th class="col-currency aimslabel">Local Debit</th>
                          <th class="col-currency aimslabel">Local Credit</th>
                          <th class="col-codes aimslabel">Cost Center</th>
                          <th class="col-description aimslabel">Notes</th>
                          <th class="col-codes aimslabel">Reference</th>
                        </tr>
                      </thead>
                      <tbody class="modulebody"> -->
                      <?php
                       // if(isset($moduledata['body']) && $moduledata['body'] != ""){
                       //    foreach ($moduledata['body'] as $itmindex => $itmdata) {
                       //    echo'<tr id="orgrow-'.$itmdata['line'].'" class="orgrow">
                          
                       //    <td id="stockbuttons-'.$itmdata['line'].'" class="origdata btnstockopt col-min aimslabelstock">';
                       //        if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
                       //        echo'<button id="stockedit-'.$itmdata['line'].'" class="stockbtn stockeditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                       //        <button id="stockdelete-'.$itmdata['line'].'" class="stockbtn stockdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;" disabled="true"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>';
                       //        }else{
                       //        echo'<button id="stockedit-'.$itmdata['line'].'" class="stockbtn stockeditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                       //        <button id="stockdelete-'.$itmdata['line'].'" class="stockbtn stockdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>';
                       //        }
                       //      echo '</td>
                       //        <td class="origdata aimslabelstock col-min" id="detailpostdate-'.$itmdata['line'].'">'.$itmdata['postdate'].'</td>
                       //        <td class="origdata aimslabelstock col-codes" id="detailcheckno-'.$itmdata['line'].'">'.$itmdata['checkno'].'</td>
                       //        <td class="origdata aimslabelstock col-codes" id="detailacno-'.$itmdata['line'].'">'.$itmdata['acno'].'</td>
                       //        <td class="origdata aimslabelstock col-description" id="detailacnoname-'.$itmdata['line'].'">'.$itmdata['acnoname'].'</td>
                       //        <td class="origdata aimslabelstock col-codes" id="detailclient-'.$itmdata['line'].'">'.$itmdata['client'].'</td>
                       //        <td class="origdata aimslabelstock col-currency" id="detaildb-'.$itmdata['line'].'">'.number_format($itmdata['db'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</td>
                       //        <td class="origdata aimslabelstock col-currency" id="detailcr-'.$itmdata['line'].'">'.number_format($itmdata['cr'],Yii::$app->systemsettings->setDecimaldisplay('currency')).'</td>
                       //        <td class="origdata aimslabelstock col-currency" id="detailcostcenter-'.$itmdata['line'].'">'.$itmdata['costcenter'].'</td>
                       //        <td class="origdata aimslabelstock col-description" id="detailrem-'.$itmdata['line'].'">'.$itmdata['rem'].'</td>
                       //        <td class="origdata aimslabelstock col-codes" id="detailref-'.$itmdata['line'].'">'.$itmdata['ref'].'</td>
                       //        <td class="origdata nobody" id="detailline-'.$itmdata['line'].'">'.$itmdata['line'].'</td>
                       //        <td class="origdata nobody" id="detailrefx-'.$itmdata['line'].'">'.$itmdata['refx'].'</td>
                       //        <td class="origdata nobody" id="detaillinex-'.$itmdata['line'].'">'.$itmdata['linex'].'</td>
                       //      </tr>';
                       //    }
                       //  }//end if moduledate is available
                      ?>
                    <!-- </tbody>
                    </table>     
                    </div>
                </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
