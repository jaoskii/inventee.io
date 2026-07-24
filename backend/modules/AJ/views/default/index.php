<?php
use yii\helpers\Url;
$this->title = 'Inventory Adjustment';
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
    <!-- then add (<div class="list">CAPTION</div>) after each </button> -->
    <!-- BEGIN BTN GROUP -->
    <button type="button" data-toggle="tooltip" title="New transaction" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> </b></button><div class="list">New</div>
                    <button type="button" data-toggle="tooltip" title="Save Transaction Head" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button><div class="list">Save</div>
                     <?php
                      if($moduledata['head']['isposted']){
                      echo'<button type="button" data-toggle="tooltip" title="Edit Transaction" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> </b></button><div class="list">Edit</div>';
                      }else{
                        if($moduledata['head']['islocked']){
                         echo'<button type="button" data-toggle="tooltip" title="Edit Transaction" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> </b></button><div class="list">Edit</div>';
                        }else{
                        echo'<button type="button" data-toggle="tooltip" title="Edit Transaction" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" style="display:block;"><b><i class="fa fa-pencil edit_btn"></i> </b></button><div class="list">Edit</div>';
                        }
                      }
                     ?>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button><div class="list">Cancel</div>
                    <button type="button" data-toggle="tooltip" title="Print" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i> </b></button><div class="list">Print</div>
                    
                    <?php
                      if($moduledata['head']['isposted']){
                      echo'<button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn module-btndelete pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> </b></button><div class="list">Delete</div>
                        <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn module-btnlock pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> </b></button><div class="list">Lock</div>
                        <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn module-btnunlock pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button><div class="list">Unlock</div>
                        <button type="button" data-toggle="tooltip" title="Unpost Transaction" class="headbtn btnactive module-btnunpost pop-btn btn-xx btn btn-default btn-success" style="display:block;"><b><i class="fa fa-history unpost_btn"></i> </b></button><div class="list">Unpost</div>
                        <button type="button" data-toggle="tooltip" title="Post Transaction" class="headbtn module-btnpost pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> </b></button><div class="list">Post</div>';
                      }else{
                        if($moduledata['head']['islocked']){
                        echo'<button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn module-btndelete pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> </b></button><div class="list">Delete</div>
                        <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn module-btnlock pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> </b></button><div class="list">Lock</div>
                        <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn btnactive module-btnunlock pop-btn btn-xx btn btn-default btn-success" style="display:block;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button><div class="list">Unlock</div>';
                        }else{
                        echo'<button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn btnactive module-btndelete pop-btn btn-xx btn btn-default btn-success"><b><i class="fa fa-trash delete_btn"></i> </b></button><div class="list">Delete</div>
                        <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn btnactive module-btnlock pop-btn btn-xx btn btn-default btn-success" style="display:block;"><b><i class="fa fa-lock lock_btn"></i> </b></button><div class="list">Lock</div>
                        <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn module-btnunlock pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button><div class="list">Unlock</div>';
                        }
                      echo'<button type="button" data-toggle="tooltip" title="Unpost Transaction" class="headbtn module-btnunpost pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> </b></button><div class="list">Unpost</div>
                        <button type="button" data-toggle="tooltip" title="Post Transaction" class="headbtn btnactive module-btnpost pop-btn btn-xx btn btn-default btn-success" style="display:block;"><b><i class="fa fa-check post_btn"></i> </b></button><div class="list">Post</div>';
                      }
                     ?>

                     <button type="button" data-toggle="tooltip" title="Transaction Logs" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="fa fa-list logs_btn"></i> </b></button><div class="list">Logs</div>

                    <?php 
                    if($moduledata['head']['islocked'] || $moduledata['head']['isposted']){
                      echo'<button type="button" data-toggle="tooltip" title="Save all  stock Items" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button><div class="list">Save Stock Items</div>
                      <button type="button"  data-toggle="tooltip" title="Add New Item" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> </b></button><div class="list">Add Item</div>
                      <button type="button"  data-toggle="tooltip" title="Quick Add" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i></b></button><div class="list"> Quick Add</div>';

                    }else{
                      echo'<button type="button" data-toggle="tooltip" title="Save all  stock Items" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button><div class="list">Save Stock Items</div>
                      <button type="button"  data-toggle="tooltip" title="Add New Item" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd"><b><i class="fa fa-plus add_btn"></i> </b></button><div class="list">Add Item</div>
                      <button type="button"  data-toggle="tooltip" title="Quick Add" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd"><b><i class="fa fa-bolt quickadd_btn"></i> </b></button><div class="list">Quick Add</div>';
                    }
                    ?>

                    <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                    <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                    <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                    <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                    <button style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button style="margin-top:3px;" class="pop-btn btn-xx btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
                  
                  
                  <?php }else{
                    echo'
                    
                    <button type="button" data-toggle="tooltip" title="New transaction" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="fa fa-file new_btn"></i> </b></button><div class="list">New</div>
                    <button type="button" data-toggle="tooltip" title="Save Transaction Head" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button><div class="list">Save</div>
                    <button type="button" data-toggle="tooltip" title="Edit Transaction" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnedit" style="display:none;"><b><i class="fa fa-pencil edit_btn"></i> </b></button><div class="list">Edit</div>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> </b></button><div class="list">Cancel</div>
                    <button type="button" data-toggle="tooltip" title="Print" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint" style="display:none;"><b><i class="fa fa-print print_btn"></i> </b></button><div class="list">Print</div>
                    <button type="button" data-toggle="tooltip" title="Delete Transaction" class="headbtn module-btndelete pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn"></i> </b></button><div class="list">Delete</div>
                    <button type="button" data-toggle="tooltip" title="Lock Transaction" class="headbtn module-btnlock pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-lock lock_btn"></i> </b></button><div class="list">Lock</div>
                    <button type="button" data-toggle="tooltip" title="Unlock Transaction" class="headbtn module-btnunlock pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-unlock unlock_btn"></i> </b></button><div class="list">Unlock</div>
                    <button type="button" data-toggle="tooltip" title="Unpost Transaction" class="headbtn module-btnunpost pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-history unpost_btn"></i> </b></button><div class="list">Unpost</div>
                    <button type="button" data-toggle="tooltip" title="Post Transaction" class="headbtn btnactive module-btnpost pop-btn btn-xx btn btn-default btn-success" style="display:none;"><b><i class="fa fa-check post_btn"></i> </b></button><div class="list">Post</div>
                    <button type="button" data-toggle="tooltip" title="Transaction Logs" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs" style="display:none;"><b><i class="fa fa-list logs_btn"></i> </b></button><div class="list">Logs</div>
                    <button type="button" data-toggle="tooltip" title="Save all  stock Items" class="pop-btn btn-xx btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> </b></button><div class="list">Save Stock Items</div>
                    <button type="button"  data-toggle="tooltip" title="Add New Item" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> </b></button><div class="list">Add Item</div>
                    <button type="button"  data-toggle="tooltip" title="Quick Add" class="pop-btn btn-xx btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> </b></button><div class="list">Quick Add</div>

                    <button disabled="true" id ="'.$moduleid.'-btnnavfirst" type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b>
                    <button disabled="true" id ="'.$moduleid.'-btn-navprev"  type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                    <button disabled="true" id ="'.$moduleid.'-btnnavnext"  type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                    <button disabled="true" id ="'.$moduleid.'-btnnavlast" type="button" class="btn-navs pop-btn btn-xx btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                    <button style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool module-btnheadcollapse headediting" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button style="margin-top:3px;display:none;" class="pop-btn btn-xx btn btn-box-tool jaox"><i class="jaox_ico fa fa-minus"></i></button>
                    ';
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

                <div class="btn-x pull-right">
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
                      echo'<button type="button" data-toggle="tooltip" title="Save all  stock Items" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      <button type="button"  data-toggle="tooltip" title="Add New Item" class="btn btn-default btn-success stockbtn stock-btnadd" disabled="true"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                      <button type="button"  data-toggle="tooltip" title="Quick Add" class="btn btn-default btn-success stockbtn stock-btnquickadd" disabled="true"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>';

                    }else{
                      echo'<button type="button" data-toggle="tooltip" title="Save all  stock Items" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save Stock Items</b></button>
                      <button type="button"  data-toggle="tooltip" title="Add New Item" class="btn btn-default btn-success stockbtn stock-btnadd"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                      <button type="button"  data-toggle="tooltip" title="Quick Add" class="btn btn-default btn-success stockbtn stock-btnquickadd"><b><i class="fa fa-bolt quickadd_btn"></i> Quick Add</b></button>';
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
                
                <h6 class="aimslabel clientcodeview" style="display:block;"><b>Warehouse Code: <input name="clientcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>" type="text" class="txtclientcodeview form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel clientcodelookup" style="display:none;"><b>Warehouse Code: <div class="input-group"><input name = "client" value ="<?php if(isset($moduledata)){echo $moduledata['head']['client'];}?>"  type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true"></b><div class="clientlookupbtn input-group-addon"><a class ="clientlookup whclientlookupbtn" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                
                <h6 class="aimslabel"><b>Warehouse: <input name="clientname" value ="<?php if(isset($moduledata)){echo $moduledata['head']['clientname'];}?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b></h6>

                <h6 class="aimslabel contraview"><b>Account: <input value="<?php if(isset($moduledata)){echo $moduledata['head']['contra'];}?>" type="text" disabled=true class="txtcontraview moduletxt form-control input-sm"></b></h6>

                <h6 class="aimslabel contralookup" style="display:none;"><b>Account:</b>
                <div class="input-group">
                    <input name="contra" readonly = "true" value="<?php if(isset($moduledata)){echo $moduledata['head']['contra'];}?>" type="text" class="moduletxt txtcontra form-control input-sm">
                    <div class="input-group-addon"><a class ="btnshowcontra" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></h6>
                </div><!-- /.col -->
                
                <div class="invoice-col col-md-4">

                <h6 class="aimslabel dateidlookup" style="display:none;"><b>Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                  <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                  <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                </div></b></h6>

                <h6 class="aimslabel dateidview"><b>Date :</b>
                <input disabled="true" name="dateidview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" type="text" class="moduletxt txtdateidview form-control input-sm"></h6>
                <!-- DATE -->

                 <h6 class="aimslabel"><b>Address: <textarea disabled="true" name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;font-size:13px;" rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['address'];}?></textarea></b></h6>
                </div><!-- /.col -->
                
                <!-- DATE -->
                <div class="invoice-col col-md-4">
                
                <h6 class="aimslabel"><b>Your Ref: <input name = "yourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['yourref'];}?>" type="text" class="moduletxt txtyourref form-control input-sm" disabled="true"></b></h6>
                <h6 class="aimslabel"><b>Our Ref: <input name="ourref" value ="<?php if(isset($moduledata)){echo $moduledata['head']['ourref'];}?>" type="text" class="moduletxt txtourref form-control input-sm" disabled="true"></b></h6>

                <!-- WAREHOUSE -->
                <h6 class="aimslabel" style="display:none;">
                <div class="input-group">
                    <input disabled="true" name="warehouse" value ="<?php if(isset($moduledata)){echo $moduledata['head']['wh'] . "~" . $moduledata['head']['whid'];}?>" type="text" class="moduletxt txtwarehousehidden form-control input-sm">
                </div></h6>
                <!-- WAREHOUSE -->

                <h6 <input disabled="true" name="tax" value="0" type="text" class="moduletxt txttax form-control input-sm" style="display:none;"></h6>


                <h6 class="aimslabel"><b>Notes: <textarea  disabled="true" name="rem" class="moduletxt txtnotes form-control" style="resize:none;"  rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['rem'];}?></textarea></b></h6>
                <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class="moduletxt txtboxtrno form-control input-sm" disabled="true" style="display:none;">
                </div><!-- /.col -->
                </div>
        </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
</div>


<?php
require('stockview.php');

?>