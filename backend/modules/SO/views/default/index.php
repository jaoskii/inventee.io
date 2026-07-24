<?php
use yii\helpers\Url;
$this->title = 'Sales Order';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<div id="dragme">
<i onclick="myFunction()" class="title fa fa-list"></i><br/>
<ul id="menu-float">
<?php if($moduledata['head']['trno'] != null){?>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew">
<b><i class="new_btn fa fa-file"></i></b></button>
<div class="list">New</div>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;">
<b><i class="save_btn fa fa-save"></i></b></button>
<div class="list">Save</div>

<?php
  if($moduledata['head']['isposted']) {
    echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;">
    <b><i class="edit_btn fa fa-pencil"></i></b></button>
    <div class="list">Edit</div>';
  } else {
    if($moduledata['head']['islocked']) {
      echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;">
      <b><i class="edit_btn fa fa-pencil"></i></b></button>
      <div class="list">Edit</div>';
    } else {
      echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;">
      <b><i class="edit_btn fa fa-pencil"></i></b></button>
      <div class="list">Edit</div>';
    }//end if lvl 2
  }//end if lvl 1
?>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;">
<b><i class="cancel_btn fa fa-times"></i></b></button>
<div class="list">Cancel</div>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint">
<b><i class="print_btn fa fa-print"></i></b></button>
<div class="list">Print</div>

<?php
  if($moduledata['head']['isposted']) {
    echo'<button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btndelete" style="display:none;">
        <b><i class="delete_btn fa fa-trash"></i></b></button>
        <div class="list">Print</div>

        <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnlock" style="display:none;">
        <b><i class="lock_btn fa fa-lock"></i></b></button>
        <div class="list">Lock</div>
        
        <button type="button" class="pop-btn btn-xx headbtn module-btnunlock btn btn-default btn-success module-btnunlock" style="display:none;">
        <b><i class="unlock_btn fa fa-unlock"></i></b></button>
        <div class="list">Unlock</div>
        
        <button type="button" class="pop-btn btn-xx headbtn btnactive btn btn-default btn-success module-btnunpost" style="display:block;">
        <b><i class="unpost_btn fa fa-history"></i></b></button>
        <div class="list">Unpost</div>

        <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnpost" style="display:none;">
        <b><i class="post_btn fa fa-check"></i></b></button>
        <div class="list">Post</div>';
  } else {
    if($moduledata['head']['islocked']) {
      echo'<button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btndelete" style="display:none;">
      <b><i class="delete_btn fa fa-trash"></i></b></button>
      <div class="list">Delete</div>

      <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnlock" style="display:none;">
      <b><i class="lock_btn fa fa-lock"></i></b></button>
      <div class="list">Lock</div>

      <button type="button" class="pop-btn btn-xx headbtn btnactive btn btn-default btn-success module-btnunlock" style="display:block;">
      <b><i class="unlock_btn fa fa-unlock"></i></b></button>
      <div class="list">Unlock</div>';

    } else {
      echo'<button type="button" class="pop-btn btn-xx headbtn btnactive btn btn-default btn-success module-btndelete">
          <b><i class="delete_btn fa fa-trash"></i></b></button>
          <div class="list">Delete</div>
          
          <button type="button" class="pop-btn btn-xx headbtn btnactive btn btn-default btn-success module-btnlock" style="display:block;">
          <b><i class="lock_btn fa fa-lock"></i></b></button>
          <div class="list">Lock</div>

          <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnunlock" style="display:none;">
          <b><i class="unlock_btn fa fa-unlock"></i></b></button>
          <div class="list">Unlock</div>';
    }//end if lvl 2
    echo'<button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnunpost" style="display:none;">
        <b><i class="unpost_btn fa fa-history"></i></b></button>
        <div class="list">Unpost</div>

        <button type="button" class="pop-btn btn-xx headbtn btnactive btn btn-default btn-success module-btnpost" style="display:block;">
        <b><i class="post_btn fa fa-check"></i></b></button>
        <div class="list">Post</div>';
  }//end if lvl 1
?>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs">
<b><i class="logs_btn fa fa-list"></i></b></button>
<div class="list">Logs</div>

<?php 
  if($moduledata['head']['islocked'] || $moduledata['head']['isposted']) {
    echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;">
        <b><i class="save_btn fa fa-save"></i></b></button>
        <div class="list">Save All Items</div>

        <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd" disabled="true">
        <b><i class="add_btn fa fa-plus"></i></b></button>
        <div class="list">Add Item</div>

        <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true">
        <b><i class="quickadd_btn fa fa-bolt"></i></b></button>
        <div class="list">Item Quickadd</div>';
  } else {
    echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;">
        <b><i class="save_btn fa fa-save"></i></b></button>
        <div class="list">Save All Items</div>

        <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd">
        <b><i class="add_btn fa fa-plus"></i></b></button>
        <div class="list">Add Item</div>

        <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd">
        <b><i class="quickadd_btn fa fa-bolt"></i></b></button>
        <div class="list">Item Quickadd</div>';
  }//end if
?>

<button type="button" id ="<?php echo $moduleid.'-btnnavfirst';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst">
<b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>

<button type="button" id ="<?php echo $moduleid.'-btn-navprev';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev">
<b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>

<button type="button" id ="<?php echo $moduleid.'-btnnavnext';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext">
<b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>

<button type="button" id ="<?php echo $moduleid.'-btnnavlast';?>" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast">
<b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>

<button type="button" style="margin-top:3px;display:none;font-size: 16px;" class="pop-btn btn-xx btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse">
<i class="fa fa-minus"></i></button>

<button type="button" style="margin-top:3px;width: 43px;" class="btn btn-box-tool jaox pop-btn btn-xx">
<i style="font-size: 16px;" class="jaox_ico fa fa-minus"></i></button>


<?php } else {
  echo'
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew">
    <b><i class="fa fa-file new_btn"></i></b></button>
    <div class="list">New</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;">
    <b><i class="fa fa-save save_btn"></i></b></button>
    <div class="list">Save</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;">
    <b><i class="fa fa-pencil edit_btn"></i></b></button>
    <div class="list">Edit</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;">
    <b><i class="cancel_btn fa fa-times"></i></b></button>
    <div class="list">Cancel</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;">
    <b><i class="print_btn fa fa-print"></i></b></button>
    <div class="list">Print</div>
    <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btndelete" style="display:none;">
    <b><i class="delete_btn fa fa-trash"></i></b></button>
    <div class="list">Delete</div>
    <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnlock" style="display:none;">
    <b><i class="fa fa-lock lock_btn"></i></b></button>
    <div class="list">Lock</div>
    <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnunlock" style="display:none;">
    <b><i class="fa fa-unlock unlock_btn"></i></b></button>
    <div class="list">Unlock</div>
    <button type="button" class="pop-btn btn-xx headbtn btn btn-default btn-success module-btnunpost" style="display:none;">
    <b><i class="fa fa-history unpost_btn"></i></b></button>
    <div class="list">Unpost</div>
    <button type="button" class="pop-btn btn-xx headbtn btnactive btn btn-default btn-success module-btnpost" style="display:none;">
    <b><i class="fa fa-check post_btn"></i></b></button>
    <div class="list">Post</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;">
    <b><i class="fa fa-list logs_btn"></i></b></button>
    <div class="list">Logs</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;">
    <b><i class="fa fa-save save_btn"></i></b></button>
    <div class="list">Save All Items</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd" disabled="true"
    ><b><i class="fa fa-plus add_btn"></i></b></button>
    <div class="list">Add Item</div>
    <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true">
    <b><i class="fa fa-bolt quickadd_btn"></i></b></button>
    <div class="list">Item Quickadd</div>
    <button type="button" disabled="true" id="'.$moduleid.'-btnnavfirst" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst">
    <b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
    <div class="list">First</div>
    <button type="button" disabled="true" id ="'.$moduleid.'-btn-navprev" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev">
    <b><i class="fa fa-backward page_nav_icons"></i></b></button>
    <div class="list">Previous</div>
    <button type="button" disabled="true" id ="'.$moduleid.'-btnnavnext" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext">
    <b><i class="fa fa-forward page_nav_icons"></i></b></button>
    <div class="list">Next</div>
    <button type="button" disabled="true" id ="'.$moduleid.'-btnnavlast" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast">
    <b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
    <div class="list">Last</div>
    <button type="button" style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse">
    <i class="fa fa-minus"></i></button>
    <button type="button" style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool jaox">
    <i class="jaox_ico fa fa-minus"></i></button>';
} ?>

</ul>
</div> <!-- dragme end -->


<article class="panel" id="go-top">
<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <b><h6 class="txttrno" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Trno: <?php if(isset($moduledata)){echo $moduledata['head']['trno'];} ?></h6></b>
        <h6 id="mindocno" style="display:none;"><b>Docno: <?php if(isset($moduledata)){echo $moduledata['head']['docno'];} ?></b></h6>
        <div class="btn-group">
          <?php 
            if($moduledata['head']['isposted']) { //IF POSTED SHOW POSTED FLAGS
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
            } else {
              echo'<a href="#" class="disapproved-flag pull-right" style="display:none;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-thumbs-down" style="font-size: 15px;"></i> DISAPPROVED</span></a>';
              echo'<a href="#" class="approved-flag pull-right" style="display:none;font-weight: bold; padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-green"><i class="fa fa-thumbs-up" style="font-size: 15px;"></i> APPROVED</span></a>';
              echo'<a href="#" class="posted-flag pull-right" style="display:none;font-weight: bold;padding-right:3px;  font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-yellow"><i class="fa fa-check-circle" style="font-size: 15px;"></i> POSTED</span></a>';
            }
            if($moduledata['head']['islocked']){ //IF LOCKED SHOW LOCKED FLAGS
              echo'<a href="#" class="locked-flag pull-right" style="display:block;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
            }else{
              echo'<a href="#" class="locked-flag pull-right" style="display:none;font-weight: bold;padding-right:3px; font-size: 11px; text-shadow: 1px 0px 1px #ebebe0;">
              <span class="pull-right text-red"><i class="fa fa-lock" style="font-size: 15px;"></i> LOCKED</span></a>';
            }
          ?>
        </div>
        <div class="btn-x pull-right">
          <?php if($moduledata['head']['trno'] != null){?>
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
              <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
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
              <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
              <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="print_btn fa fa-print"></i> Print</b></button>
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
              <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> Logs</b></button>
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
              <button id ="<?php echo $moduleid.'-btnnavfirst';?>" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
              <button id ="<?php echo $moduleid.'-btn-navprev';?>" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
              <button id ="<?php echo $moduleid.'-btnnavnext';?>" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
              <button id ="<?php echo $moduleid.'-btnnavlast';?>" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
              <button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
            </div>
          <?php } else {
            echo'<div class="btn-group">
              <button class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> New</b></button>
              <button class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
              <button class="btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
              <button class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
              <button class="btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;"><b><i class="print_btn fa fa-print"></i> Print</b></button>
              <button class="headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
              <button class="headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> Lock</b></button>
              <button class="headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> Unlock</b></button>
              <button class="headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> Unpost</b></button>
              <button class="headbtn btnactive module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>
              <button class="btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;"><b><i class="fa fa-list logs_btn"></i> Logs</b></button>
              <button class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
              <button class="btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
              <button class="btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>
              <button disabled="true" id="'.$moduleid.'-btnnavfirst" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
              <button disabled="true" id ="'.$moduleid.'-btn-navprev" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
              <button disabled="true" id ="'.$moduleid.'-btnnavnext" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
              <button disabled="true" id ="'.$moduleid.'-btnnavlast" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
              <button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button style="margin-top:3px;display:none;" class="btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
            </div>';
          } ?>
        </div><!-- /.box-tools -->
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="pull-right" style="margin-top:-15px;"></div>
          <div class="invoice-info col-md-12" style="margin-left:-15px;">
            <div class="invoice-col col-md-3">
              <h6 class="aimslabel"><b>Document #:  
                <div class="input-group">
                    <input name = "docno" value ="<?php if(isset($moduledata)){echo $moduledata['head']['docno'];}?>" type="text" class="moduletxt txtdocno input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="docnolookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div>
              </h6>
              <h6 class="aimslabel clientcodeview" style="display:block;"><b>Customer Code: <input name="clientcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="txtclientcodeview form-control input-sm" disabled="true"></b></h6>
              <h6 class="aimslabel clientcodelookup" style="display:none;"><b>Customer Code: 
                <div class="input-group">
                  <input name = "client" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>"  type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true"></b>
                  <div class="clientlookupbtn input-group-addon"><a class ="clientlookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div>
                </div></h6>
                <h6 class="aimslabel"><b>Customer: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b></h6>

                <h6 class="aimslabel"><b>Ship to: <textarea disabled="true" name="shipto" class="moduletxt txtshipto form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['shipto'];}?></textarea></b></h6>

                

                </div><!-- /.col -->
                
                <div class="invoice-col col-md-3">
                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'FHI':
                    $yourreflabel = "P.O #:";  
                    $ourreflabel = "DR # Series:";
                  break;
                  
                  default:
                    $yourreflabel = "Yourref:";
                    $ourreflabel = "Ourref:";
                  break;
                }//end swithc
                ?>
                <h6 class="aimslabel"><b><?php echo $yourreflabel;?><input name = "yourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['yourref'];}?>" type="text" class="moduletxt txtyourref form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b><?php echo $ourreflabel;?><input name="ourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['ourref'];}?>" type="text" class="moduletxt txtourref form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b>Address: <textarea disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['address'];}?></textarea></b></h6>

               

                <?php
                  switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'UNIVERSE':
                      $agentstr = 'Prepared:';
                      echo '<h6 class="aimslabel"><b>';
                      echo $agentstr;
                      echo '<select disabled = "true" name = "agentcode" class="moduletxt txtagentcode agentcombo input-sm form-control">';
                      if(isset($moduledata)){echo '<option>'.$moduledata['head']['agentcode'] . '</option>';}
                      echo '</select></h6>';
                    break;
                    
                    default:
                      $agentstr = 'Agent:';
                      echo '<h6 class="agentlookup" style="display: none;"><b>';
                      echo $agentstr;
                      echo '<div class="input-group">';
                      echo '<input name = "agentcode" readonly="" value ="';
                      if(isset($moduledata)){echo $moduledata['head']['agentcode'];}
                      echo '" type="text" class="moduletxt txtagentcode input-sm form-control" disabled="true">';
                      echo '<div class="frmdocumentno input-group-addon">';
                      echo '<a class ="agentlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a>';
                      echo '</div>';
                      echo '</div>';
                      echo '</h6>';

                      echo '<h6 class="agentlookupview"><b>';
                      echo $agentstr;
                      echo '<input name="agentcodeview" value ="';
                      if(isset($moduledata)){echo $moduledata['head']['agentcode'];}
                      echo '" type="text" class="moduletxt txtagentcodeview input-sm form-control" disabled="true"></b>';
                      echo '</h6>';
                    break;
                  }//END SWITCH
                ?>

                </div><!-- /.col -->
                
                <!-- DATE -->
                <div class="invoice-col col-md-4">
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                  <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
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
                
                <?php
                  switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'SOUTHCENTRAL':
                      echo '<h6 class="aimslabel"><b>RF #: <input value ="';
                      if(isset($moduledata)){echo $moduledata['head']['rfdocno'];}
                      echo'" type="text" class="txtroutedocno form-control input-sm" disabled="true"></b></h6>';
                    break;
                  }//END SWITCH
                ?>
                
                <?php 
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'UNIVERSE':
                    echo '<h6 class="aimslabel"><b>Picker';
                    echo '<select disabled = "true" name = "pickcode" class="moduletxt txtpickcode pickercombo input-sm form-control">';
                    if(isset($moduledata)){echo '<option>'.$moduledata['head']['picker'] . '</option>';}
                    echo '</select></h6>';
                    
                    echo '<h6 class="aimslabel"><b>Checker';
                    echo '<select disabled = "true" name = "checkcode" class="moduletxt txtcheckcode checkercombo input-sm form-control">';
                    if(isset($moduledata)){echo '<option>'.$moduledata['head']['checker'] . '</option>';}
                    echo '</select></h6>';
                    
                  break; 

                  
                }//end swithc
                ?>

                </div><!-- /.col -->

                <div class="invoice-col col-md-2">
                <h6 class="aimslabel"><b>Due Date :</b>
                <input disabled="true" name="due" value ="<?php if(isset($moduledata)){echo $moduledata['head']['due'];}?>" type="text" class="moduletxt txtdatedue form-control input-sm"></h6>
                
                <h6 class="aimslabel termsview"><b>Terms: <input name="termview" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" disabled=true class="txttermsview moduletxt form-control input-sm"></b></h6>

                <h6 class="aimslabel termslookup" style="display:none;"><b>Terms :</b>
                <div class="input-group">
                    <input readonly="" name="terms" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" class="moduletxt txtterms form-control input-sm">
                    <div class="input-group-addon"><a class ="btnshowterms" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>

                <h6 class="aimslabel nobody"><b>Forex: <input disabled="true" name="forex" value="<?php if(isset($moduledata)){echo $moduledata['head']['forex'];}?>" type="text" class="moduletxt txtforex form-control input-sm"></b></h6>
                <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" disabled="true" style="display:none;">

                <h6 class="aimslabel"><b>Sales type:
                    <select disabled = "true" id="salestype" class="salestype input-sm form-control">
                      <?php if(isset($moduledata)){echo '<option>'.$moduledata['head']['salestype'] . '</option>';}?>
                    </select>
                </h6>

                <?php

                switch (Yii::$app->systemsettings->companyConfig()) {
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

                <?php 
                 switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'UNIVERSE':
                  echo '<h6 class="aimslabel amtrec"><b>Amount Received: <input name="amtrec" value="';
                  if(isset($moduledata)){echo $moduledata['head']['amountreceived'];}
                  echo '"type="text" disabled=true class="txtamtrec moduletxt form-control input-sm"></b></h6>';
                  echo '<h6 class="aimslabel"><b>Trans type:';
                        echo '<select disabled = "true" id="transtype" class="transtype input-sm form-control">';
                          if(isset($moduledata)){
                            echo '<option>'.$moduledata['head']['transtype'] . '</option>';
                          }//end if
                        echo '</select>';
                    echo '</h6>';
                 break;
                 
                 default:
                  //TODO CODE HERE
                 break;
               }
               ?>
               

                </div><!-- /.col -->



              </div>
        </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
</div>
</article>

<article class="panel" id="go-down">
<?php
require('stockview.php');
//echo Yii::$app->tblgenerator->generateTable($moduleid,$moduledata);
?>
</article>