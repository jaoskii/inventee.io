<?php
use yii\helpers\Url;
use yii\base\ErrorException;
$this->title = 'Sales Journal';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<!-- 
<button class="button" id="copy-button" data-clipboard-target="#modulestockview">Copy</button>  
<input id="post-shortlink" value="https://ac.me/qmE_jpnYXFo"> -->


<div  id="dragme">
<i onclick="myFunction()" class="title fa fa-list"></i><br/>
<ul id="menu-float">
<?php if($moduledata['head']['trno'] != null){?>
<!-- BEGIN BTN GROUP -->
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i></b></button>
<div class="list">New</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i></b></button>
<div class="list">Save</div>
 <?php
  if($moduledata['head']['isposted']){
  echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i></b></button>
  <div class="list">Edit</div>';
  }else{
    if($moduledata['head']['islocked']){
     echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i></b></button>
     <div class="list">Edit</div>';
    }else{
    echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;"><b><i class="fa fa-pencil edit_btn"></i></b></button>
    <div class="list">Edit</div>';
    }
  }
 ?>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i></b></button>
<div class="list">Cancel</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i></b></button>
<div class="list">Print</div>

<?php
  if($moduledata['head']['isposted']){
  echo'<button type="button" class="pop-btn btn-xx headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i></b></button>
    <div class="list">Delete</div>
    <button type="button" class="pop-btn btn-xx headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i></b></button>
    <div class="list">Lock</div>
    <button type="button" class="pop-btn btn-xx headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i></b></button>
    <div class="list">Unlock</div>
    <button type="button" class="pop-btn btn-xx headbtn btnactive module-btnunpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-history unpost_btn"></i></b></button>
    <div class="list">Unpost</div>
    <button type="button" class="pop-btn btn-xx headbtn module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i></b></button>
    <div class="list">Post</div>';
  }else{
    if($moduledata['head']['islocked']){
    echo'<button type="button" class="pop-btn btn-xx headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i></b></button>
    <div class="list">Delete</div>
    <button type="button" class="pop-btn btn-xx headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i></b></button>
    <div class="list">Lock</div>
    <button type="button" class="pop-btn btn-xx headbtn btnactive module-btnunlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-unlock unlock_btn"></i></b></button>
    <div class="list">Unlock</div>';
    }else{
    echo'<button type="button" class="pop-btn btn-xx headbtn btnactive module-btndelete btn btn-default btn-success"><b><i class="fa fa-trash delete_btn"></i></b></button>
    <div class="list">Delete</div>
    <button type="button" class="pop-btn btn-xx headbtn btnactive module-btnlock btn btn-default btn-success" style="display:block;"><b><i class="fa fa-lock lock_btn"></i></b></button>
    <div class="list">Lock</div>
    <button type="button" class="pop-btn btn-xx headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i></b></button>
    <div class="list">Unlock</div>';
    }
    echo'<button type="button" class="pop-btn btn-xx headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i></b></button>
    <div class="list">Unpost</div>
    <button type="button" class="pop-btn btn-xx headbtn btnactive module-btnpost btn btn-default btn-success" style="display:block;"><b><i class="fa fa-check post_btn"></i></b></button>
    <div class="list">Post</div>';
  }
 ?>

 <button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i></b></button>
 <div class="list">Logs</div>

<?php 
if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
  echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i></b></button>
  <div class="list">Save all Items</div>
  <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i></b></button>
  <div class="list">Add Item</div>
  <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i></b></button>
  <div class="list">Item Quickadd</div>
   <button  disabled="true" style="display:none;" type="button" class="pop-btn btn-xx orderbtns btn btn-default btn-success stockbtn stock-btnorderlookup"><b><i class="fa fa-tags order_btn"></i></b></button>
   <div class="list">SO</div>';
}else{
  echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i></b></button>
  <div class="list">Save all Items</div>
  <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd"><b><i class="fa fa-plus add_btn"></i></b></button>
  <div class="list">Add Item</div>
  <button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd"><b><i class="fa fa-bolt quickadd_btn"></i></b></button>
  <div class="list">Item Quickadd</div>
  <button style="display:none;" type="button" class="pop-btn btn-xx orderbtns btn btn-default btn-success stockbtn stock-btnorderlookup"><b><i class="fa fa-tags order_btn"></i></b></button>
  <div class="list">SO</div>';
}
?>

<button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
<button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
<button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
<button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>
<button style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
<button style="margin-top:3px;" class="pop-btn btn-xx btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>

<?php }else{
echo'
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i></b></button>
<div class="list">New</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i></b></button>
<div class="list">Save</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i></b></button>
<div class="list">Edit</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i></b></button>
<div class="list">Cancel</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;"><b><i class="fa fa-print print_btn"></i></b></button>
<div class="list">Print</div>
<button type="button" class="pop-btn btn-xx headbtn module-btndelete btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i></b></button>
<div class="list">Delete</div>
<button type="button" class="pop-btn btn-xx headbtn module-btnlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i></b></button>
<div class="list">Lock</div>
<button type="button" class="pop-btn btn-xx headbtn module-btnunlock btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i></b></button>
<div class="list">Unlock</div>
<button type="button" class="pop-btn btn-xx headbtn module-btnunpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i></b></button>
<div class="list">Unpost</div>
<button type="button" class="pop-btn btn-xx headbtn btnactive module-btnpost btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i></b></button>
<div class="list">Post</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;"><b><i class="fa fa-list logs_btn"></i></b></button>
<div class="list">Logs</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i></b></button>
<div class="list">Save All Items</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i></b></button>
<div class="list">Add Item</div>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i></b></button>
<div class="list">Item Quickadd</div>
<button  disabled="true" style="display:none;" type="button" class="pop-btn btn-xx orderbtns btn btn-default btn-success stockbtn stock-btnorderlookup"><b><i class="fa fa-tags order_btn"></i></b></button>
<div class="list">SO</div>

<button disabled="true" id ="'.$moduleid.'-btnnavfirst" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>
<button disabled="true" id ="'.$moduleid.'-btn-navprev"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>
<button disabled="true" id ="'.$moduleid.'-btnnavnext"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>
<button disabled="true" id ="'.$moduleid.'-btnnavlast" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>
<button style="margin-top:3px;display:none;" class="btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
<button style="margin-top:3px;display:none;" class="btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>';
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

                <div class="btn-x pull-right">
                  <?php if($moduledata['head']['trno'] != null){?>
                <!-- BEGIN BTN GROUP -->
                  <div class="btn-group">
                    <?php
                    switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'UNIVERSE':
                        echo '<button type="button" class="btn btn-default btn-success headbtn btnactive module-btncopyso">
                              <b><i class="fa fa-copy new_btn"></i> Pending SO</b></button>';
                      break;
                    }//end switch
                    ?>
                    

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
                      <button type="button" class="btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                      <button type="button" class="btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>
                       <button  disabled="true" style="display:none;" type="button" class="orderbtns btn btn-default btn-success stockbtn stock-btnorderlookup"><b><i class="fa fa-tags order_btn"></i> SO</b></button>';
                    }else{
                      echo'<button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      <button type="button" class="btn btn-default btn-success stockbtn stock-btnadd"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                      <button type="button" class="btn btn-default btn-success stockbtn stock-btnquickadd"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>
                       <button style="display:none;" type="button" class="orderbtns btn btn-default btn-success stockbtn stock-btnorderlookup"><b><i class="fa fa-tags order_btn"></i> SO</b></button>';
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
                    <button type="button" class="btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                    <button type="button" class="btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>
                    <button  disabled="true" style="display:none;" type="button" class="orderbtns btn btn-default btn-success stockbtn stock-btnorderlookup"><b><i class="fa fa-tags order_btn"></i> SO</b></button>

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
                
                <h6 class="aimslabel clientcodeview" style="display:block;"><b>Customer Code: <input name="clientcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="txtclientcodeview form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel clientcodelookup" style="display:none;"><b>Customer Code: <div class="input-group"><input name = "client" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>"  type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true"></b><div class="clientlookupbtn input-group-addon"><a class ="clientlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                
                <h6 class="aimslabel"><b>Customer: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b></h6>
                
                <h6 class="aimslabel"><b>Ship to: <input disabled="true" name="shipto" value="<?php if(isset($moduledata)){echo $moduledata['head']['shipto'];}?>" type="text" class="moduletxt txtshipto form-control input-sm"></b></h6>

                <h6 class="aimslabel contraview"><b>Account: <input value="<?php if(isset($moduledata)){echo $moduledata['head']['contra'];}?>" readonly type="text" disabled=true class="txtcontraview moduletxt form-control input-sm"></b></h6>

                
                <h6 class="aimslabel contralookup" style="display:none;"><b>Account:</b>
                <div class="input-group">
                    <input name="contra" value="<?php if(isset($moduledata)){echo $moduledata['head']['contra'];}?>" type="text" readonly class="moduletxt txtcontra form-control input-sm">
                    <div class="input-group-addon"><a class ="btnshowcontra" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>

                <?php 
                // PANDATOOLS UPDATE
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'PANDATOOLS':
                   ?>
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Waybill Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($moduledata)){echo $moduledata['head']['waybilldate'];}?>"  class="paedit input-group date dpYears">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                  <input type="text" name = "waybilldate" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['waybilldate'];}?>" size="12" class="moduletxt txtwaybilldate form-control input-sm" disabled="true">
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b>Waybill Date:</b>
                <input disabled="true" name="waybilldateview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtwaybilldateview form-control input-sm"></h6>

                <?php  
                  break;
                // END PANDa
                }
                ?>

                <?php
                  if(isset($moduledata)){
                    if($moduledata['head']['salestype'] == "CHECK"){
                       echo '<h6 class="aimslabel contracheck"><b>Check #:
                        <input disabled="true" name="checkno" value="'.$moduledata['head']['checkno'].'" type="text" class="moduletxt txtcheckno form-control input-sm">
                        </h6>';
                    }else{  
                        echo '<h6 disabled="true" style="display:none;" class="aimslabel contracheck"><b>Check #:
                        <input name="checkno" value="" type="text" class="moduletxt txtcheckno form-control input-sm">
                        </h6>';
                    }//end if
                  }//end if
                ?>

                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                   case 'UNIVERSE':

                    echo '<h6 class="aimslabel"><b>Trans type:';
                        echo '<select disabled = "true" id="transtype" class="transtype input-sm form-control">';
                          if(isset($moduledata)){
                            echo '<option>'.$moduledata['head']['transtype'] . '</option>';
                          }//end if
                        echo '</select>';
                    echo '</h6>';

                  break;
                }//end switch
                ?>


                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'MEGASTEEL':
                    echo '<h6 class="aimslabel"><b>Arastre: 
                          <input disabled="true" name="arastre" value="';
                          if(isset($moduledata)){echo $moduledata['head']['arastre'];}
                    echo '" type="text" class="moduletxt txtarastre form-control input-sm"></b></h6>';
                  break;
                }//end switch
                ?>

                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'MLCP':
                    echo '<h6 class="aimslabel jonumnum"><b>JO #:';
                    echo '<div class="input-group">
                    <input readonly type="text" name="jonum" class="txtjonumber moduletxt form-control input-sm" value="';
                    if(isset($moduledata)){echo $moduledata['head']['jodocno'];}
                    echo '"></b>';
                    echo '<div class="frmdocumentno input-group-addon">
                            <a style="display:none;" class ="jonumlookup proplookup" href="#">
                              <i class="fa fa-chevron-circle-down" ></i>
                            </a>
                          </div>
                          </div>';
                    echo '</h6>';

                  break;
                }//END SWITch
                ?>
                </div><!-- /.col -->
                
                <div class="invoice-col col-md-3">

                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                   case 'UNIVERSE': 
                      echo '<h6 class="aimslabel"><b>SO #: <input name="ourref" value ="';
                    if(isset($moduledata)){echo $moduledata['head']['ourref'];}
                    echo '" type="text" readonly class="moduletxt txtourref form-control input-sm" disabled="true"></b></h6>';
                  break;

                  default: 

                    switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'MLCP':
                        $ourreflabel = 'INV #:';
                      break;
                      
                      case 'FHI':
                        $ourreflabel = "SO #:";
                      break;

                      default:
                        $ourreflabel = 'Ourref';
                      break;
                    }//END SWITCH

                    echo '<h6 class="aimslabel"><b> '.$ourreflabel.' <input name="ourref" value ="';
                    if(isset($moduledata)){echo $moduledata['head']['ourref'];}
                    echo '" type="text" class="moduletxt txtourref form-control input-sm" disabled="true"></b></h6>';
                  break;
                }//end switch
                ?>

                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'CANUMAY': case 'PANDATOOLS': case 'MLCP':
                    $yourreflabel = 'PO No.';  
                  break;
                  
                  case 'FHI':
                    $yourreflabel = "P.O #";  
                  break;

                  default:
                    $yourreflabel = 'Your Ref';
                  break;
                }//END SWITCH
                ?>

                <h6 class="aimslabel"><b><?php echo $yourreflabel;?>: <input name = "yourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['yourref'];}?>" type="text" class="moduletxt txtyourref form-control input-sm" disabled="true"></b></h6>

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

                

                <?php 
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'UNIVERSE':
                    echo '<h6 class="aimslabel"><b>Picker';
                    echo '<select disabled = "true" name = "pickcode" class="moduletxt txtpickcode pickercombo input-sm form-control">';
                    if(isset($moduledata)){echo '<option>'.$moduledata['head']['pickcode'] . '</option>';}
                    echo '</select></h6>';
                    
                    echo '<h6 class="aimslabel"><b>Checker';
                    echo '<select disabled = "true" name = "checkcode" class="moduletxt txtcheckcode checkercombo input-sm form-control">';
                    if(isset($moduledata)){echo '<option>'.$moduledata['head']['checkcode'] . '</option>';}
                    echo '</select></h6>';
                    
                  break; 

                  case 'PANDATOOLS':
                    echo '<h6 class="aimslabel"><b>Bill of Lading :</b>
                    <input disabled="true" name="billlading" value ="';
                    if(isset($moduledata)){echo $moduledata['head']['billlading'];}
                    echo '" type="text" class="moduletxt txtbilloflading form-control input-sm"></h6>';
                  break;
                }//end swithc
                ?>

                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'MEGASTEEL':
                    echo '<h6 class="aimslabel"><b>Freight: 
                          <input disabled="true" name="freight" value="';
                          if(isset($moduledata)){echo $moduledata['head']['freight'];}
                    echo '" type="text" class="moduletxt txtfreight form-control input-sm"></b></h6>';
                  break;

                  case 'MLCP':
                    echo '<h6 class="aimslabel"><b>Freight and Other Charges: 
                          <input disabled="true" name="freightcharge" value="';
                          if(isset($moduledata)){echo $moduledata['head']['mlcp_freight'];}
                    echo '" type="text" class="moduletxt txtfreightcharge form-control input-sm"></b></h6>';
                  break;
                }//end switch
                ?>

                </div><!-- /.col -->
                
                <!-- DATE -->
                <div class="invoice-col col-md-4">
                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
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

                <h6 class="aimslabel"><b>Due Date :</b>
                <input disabled="true" name="due" value ="<?php if(isset($moduledata)){echo $moduledata['head']['due'];}?>" type="text" class="moduletxt txtdatedue form-control input-sm"></h6>

                <?php 
                 switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'UNIVERSE':
                  echo '<h6 class="aimslabel amtrec"><b>Amount Received: <input name="amtrec" value="';
                  if(isset($moduledata)){echo $moduledata['head']['amountreceived'];}
                  echo '"type="text" disabled=true class="txtamtrec moduletxt form-control input-sm"></b></h6>';

                 break;
                 
                 default:
                  //TODO CODE HERE
                 break;
               }
               ?>
                <?php 
                // PANDATOOLS UPDATE
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'PANDATOOLS':
                  ?>
                <h6 class="aimslabel"><b>Voyage # :</b>
                <input disabled="true" name="voyage" value ="<?php if(isset($moduledata)){echo $moduledata['head']['voyage'];}?>" type="text" class="moduletxt txtvoyage form-control input-sm"></h6>
              
                <?php 
                  break;
                // END PANDa
                }
                ?>
                
                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'MEGASTEEL':
                    echo '<h6 class="aimslabel"><b>Wrarffage: 
                          <input disabled="true" name="wharffage" value="';
                          if(isset($moduledata)){echo $moduledata['head']['wharffage'];}
                    echo '" type="text" class="moduletxt txtwharffage form-control input-sm"></b></h6>';
                  break;

                  case 'MLCP':
                    if(isset($moduledata)){
                      $gtotal = str_replace(',','',$moduledata['head']['grandtotal']);
                      $freight = str_replace(',','',$moduledata['head']['mlcp_freight']);

                      $totalfreight = floatval($gtotal) + floatval($freight);
                    }else{
                      $totalfreight = 0.00;
                    }//end if

                    echo '<h6 class="aimslabel"><b>Total Freight and Sales:
                          <input disabled="true" value="';
                          echo number_format($totalfreight,2);
                    echo '" type="text" class="txtfreightchargetotal form-control input-sm"></b></h6>';
                  break;
                }//end switch
                ?>

                </div><!-- /.col -->

                <div class="invoice-col col-md-2">
                
                <h6 class="aimslabel termsview"><b>Terms: <input name="termview" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" disabled=true class="txttermsview moduletxt form-control input-sm"></b></h6>

                <h6 class="aimslabel termslookup" style="display:none;"><b>Terms :</b>
                <div class="input-group">
                    <input readonly="" name="terms" value="<?php if(isset($moduledata)){echo $moduledata['head']['terms'];}?>" type="text" class="moduletxt txtterms form-control input-sm">
                    <div class="input-group-addon"><a class ="btnshowterms" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>

                <h6 class="aimslabel nobody"><b>Forex: <input disabled="true" name="forex" value="<?php if(isset($moduledata)){echo $moduledata['head']['forex'];}?>" type="text" class="moduletxt txtforex form-control input-sm"></b></h6>
                <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" disabled="true" style="display:none;">

                <h6 class="aimslabel"><b>Tax: <input disabled="true" name="tax" value="<?php if(isset($moduledata)){echo $moduledata['head']['tax'];}?>" type="text" class="moduletxt txttax form-control input-sm"></b></h6>

                <?php
                    echo '<h6 class="aimslabel"><b>Vat type:
                          <select disabled = "true" id="vattype" class="vattype input-sm form-control">';
                          if(isset($moduledata)){echo '<option>'.$moduledata['head']['vattype'] . '</option>';}
                    echo '</select></h6>';
                ?>

                <h6 class="aimslabel"><b>Sales type:
                    <select disabled = "true" id="salestype" class="salestype input-sm form-control">
                      <?php if(isset($moduledata)){echo '<option>'.$moduledata['head']['salestype'] . '</option>';}?>
                    </select>
                </h6>

                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'MLCP':
                    echo '<h6 class="aimslabel"><b>Trans type:';
                    echo '<div class="input-group">
                    <input readonly type="text" name="transtype" class="transtype moduletxt form-control input-sm" value="';
                        if(isset($moduledata)){echo $moduledata['head']['transtype'];}
                    echo '"></b>';
                    echo '<div class="frmdocumentno input-group-addon">
                            <a style="display:none;" class ="fg_prodtypelookup proplookup" href="#">
                              <i class="fa fa-chevron-circle-down" ></i>
                            </a>
                          </div>
                          </div>';
                    echo '</h6>';

                  break;
                }//END SWITch
                ?>
                </div><!-- /.col -->
                </div>
        </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
</div>

<?php 
require('stockview.php');
//echo Yii::$app->tblgenerator->generateTable($moduleid,$moduledata);
?>