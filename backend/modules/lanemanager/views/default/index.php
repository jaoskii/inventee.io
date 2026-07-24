<?php
$this->title = 'Lane Manager';
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="laneid" value="">

    <div class="col-md-3">
        <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <div class="pull-right">
                  <div class="btn-group">
                  <button type="button" class="btn btn-default btn-success headbtn btnactive arrangelanes"><b><i class="fa fa-refresh new_btn"></i> Arrange</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnewlane"><b><i class="fa fa-plus new_btn"></i> Add New Lane</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btnsavelane" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btncancellane" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                  </div>
                </div><!-- /.box-tools -->
               </div><!-- /.box-header -->
              
            <div class="box-body scroll-lanes lanelist" id="lanelisting">
                <?php
                /*foreach ($usersdata as $data => $dat) {
                  echo '<button id = "acclevels-'.$dat['idno'].'" class="settings-btn acclevels btn btn-info btn-flat">
                  '.$dat['username'].'</button>';
                }//END FOR EACH*/
                ?>
            </div><!-- /.box-body -->
            <div class="box-body newlaneform" style="height:100%;width:100%;display: none;">
              <input type="text" class="form-control txtnewlane"/>    
              <br>
              <input style="margin-left:7px;margin-top:6px;" class ="lane_enabled" type="checkbox">
              <label><small>Enabled</small></label>
            </div>
        </div> <!-- /class="box box-solid box-success" -->

       
        
    </div> <!-- END COL MD 4 -->

      <div class="col-md-9" style="height:100%;">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">
                   <b><h6 id="lanetitle" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;"></h6></b>
                  
                  <div class="pull-right" style="margin-top: 5px;">
                  <div class="btn-group">
                   <!--  <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btneditaccess"><b><i class="fa fa-pencil"></i> Edit Access</b></button>
                    <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btnfinishaccess"><b><i class="fa fa-check"></i> Finish Editing</b></button> -->
                  </div>
                  </div><!-- /.box-tools -->
                  </div>

                  
                  <div class="box-body row-horizon" id="lanechildlisting" style="overflow-y: scroll;height: 770px;">
                    
                  </div>
              
                  
                  
              </div><!-- /.box -->
      </div> <!-- END COL MD 9 -->


</div>
