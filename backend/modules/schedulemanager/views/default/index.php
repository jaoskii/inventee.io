<?php
use yii\helpers\Url;
$this->title = 'Schedule Manager';
?>


<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

<div class="col-md-3">
      <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">LIST OF USERS</h6></b>
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                  <div class="btn-group">
                    </div>
                </div>
                </div><!-- /.box-header -->
            <div class="box-body schedmanager-userlist scroll-scheduserlist">
                <?php
                foreach ($users as $key => $value) {
                  if(!empty($users[$key]['username'])){
                    echo '<button id = "btnviewer-'.$users[$key]['userid'].'" class="schedmanager-btnviewer settings-btn btn btn-github btn-flat">'.$users[$key]['username'].'</button>';
                  }//end if
                }//end foreach
                ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->

<div class="col-md-9">
      <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <b><h6 id="schedmanager-userid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;"></h6></b>
                <div class="pull-right">
                    <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive schedmanager-editaccess"><b><i class="fa fa-pencil"></i> Edit Access</b></button>
                    <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive schedmanager-finishedit"><b><i class="fa fa-check"></i> Finish Editing</b></button>
                </div>
                </div><!-- /.box-header -->

               <div class="box-body scroll-divs" id="accesslisting">
                  <div class="col-md-6">
                    <button class="allowedall-btn btn btn-flat btn-primary settings-btn" style="width:100%;margin-top:3px;" disabled><b>ALLOWED</b></button>
                      <div id="allowed">
                        
                      </div>
                  </div><!-- /.col-md-4 -->

                  <div class="col-md-6">
                    
                    <button class="notallowedall-btn btn btn-flat btn-primary settings-btn" style="width:100%;margin-top:3px;" disabled><b>NOT ALLOWED</b></button>

                    <div id="notallowed">
                                            
                    </div>

                  </div><!-- /.col-md-4 -->
                  </div><!-- /.box-body -->

        </div><!-- /.box -->


</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<!-- ################################################ SETTINGS LAYOUT ####################################### -->
