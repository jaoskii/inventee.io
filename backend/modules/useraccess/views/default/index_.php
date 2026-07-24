<?php
$this->title = 'Useraccess';
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input name="idno" class="txtaccess" type = "hidden" id ="idno" value="">
<input type = "hidden" id ="savingtype" value="">
<input name="userid" type = "hidden" class="txtaccess" id ="userid" value="">

    <div class="col-md-4">
        <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <div class="btn-group">
                </div>
                <div class="pull-right">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnewaccess"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btnsaveaccess" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" class="btn btn-default btn-success headbtn module-btncancelaccess" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                  </div>
                </div><!-- /.box-tools -->
               </div><!-- /.box-header -->
              
            <div class="box-body scroll-mini usergrplist" id="levels">
                <?php
                foreach ($usersdata as $data => $dat) {
                  echo '<button id = "acclevels-'.$dat['idno'].'" class="settings-btn acclevels btn btn-info btn-flat">
                  '.$dat['username'].'</button>';
                }//END FOR EACH
                ?>
            </div><!-- /.box-body -->
            <div class="box-body newgrplist" style="height:50%;width:100%;display: none;">
              <input type="text" class="form-control newgrpname"/>    
            </div>
        </div> <!-- /class="box box-solid box-success" -->

        <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                  <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">USERS</h6></b>
                  <div class="pull-right">
                  <div class="btn-group">
                    <button style="display: none;" type="button" class="btn btn-default btn-success headbtn btnactive module-btnadduseraccess"><b><i class="fa fa-plus add_btn"></i> Add User</b></button>
                    <button style="display: none;" type="button" class="btn btn-default btn-success headbtn btnactive module-btnuseraccessremovegrp"><b><i class="fa fa-trash delete_btn"></i> Remove Group</b></button>
                    <button style="display: none;" type="button" class="btn btn-default btn-success headbtn btnactive module-btnuseraccesssaveuser"><b><i class="fa fa-save save_btn"></i> Save User</b></button>
                    <button style="display:none;" type="button" class="btn btn-default btn-success headbtn btnactive module-btnuseraccesscanceluser"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                  </div>
                  </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              
              <div class="box-body userlist">
                  <table class="bodytable table tableSection table-fixed">
                      <thead>
                      <tr>
                        <th class="col-xs-4 aimslabel"><span class="text">USERNAME</span></th>
                        <th class="col-xs-5 aimslabel"><span class="text">NAME</span></th>
                        <th class="col-xs-3 aimslabel"><span class="text">OPTIONS</span></th>
                      </tr>
                      </thead>
                      
                      <tbody class="users-modulebody" style="height:171px;">
                      </tbody>
                  </table>        
              </div><!-- /.box-body -->

              <div class="box-body modifyuser" style="display:none;height:50%;">
              <div class="row">
              <div class="col-md-12">
              <input style="margin-left:7px;margin-top:6px;" class ="clientboxes userisinactive" type="checkbox">
                <label><small>Tag as Inactive </small></label>
              <input style="margin-left:7px;margin-top:6px;" class ="clientboxes usertime" type="checkbox">
              <label><small>Time checking </small></label>
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <div class="input-group">
                              <input type = "text" class="txttime accmodify txtaccess input-sm form-control timepicker" name="starttime" value="00:00" id="txttime1">
                            <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                            </div>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                </div>
              </div>
              <div class="col-md-12">
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <div class="input-group">
                            <input type = "text" class="txttime accmodify txtaccess input-sm form-control timepicker" name="endtime" value="00:00" id="txttime2">
                            <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                            </div>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                </div>
              </div>
              </br>
                <div class="col-md-12">
                  <label><small>Username: </small></label>
                  <input type = "text" class="accmodify txtaccess input-sm form-control" name="username" value="" id="txtusernameaccess">
                  <label><small>Password: </small></label>
                  <input type = "password" class="accmodify txtaccess input-sm form-control" name="password" value="" id="txtpasswordaccess">
                  <label><small>Name: </small></label>
                  <input type = "text" class="accmodify txtaccess input-sm form-control" name="name" value="" id="txtnameaccess">
                  <label><small>Administrator Password: </small></label>
                  <input type = "password" class="accmodify txtaccess input-sm form-control" name="adminpass" value="" id="txtadminpassaccess">
                </div>


                <div class="col-md-12">
                  <div class="userpicbox">
                    <img style="margin-left:30%;margin-top:5px;" src ="" width="130px" height ="120px" class="thumbnail recordpicture">
                    <form id ="picupload" method="POST" enctype="multipart/form-data">
                    <span id="fileselector">
                        <label class="btn btn-xs btn-default" for="upload-file-selector" style="margin-top:-15px;width:100%;margin-left:-10px;">
                        <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture">
                        <i class="fa fa-upload margin-correction"></i>Browse Pic
                        </label>
                    </span>

                  <button type = "submit" class="uploadsave btn-xs btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                  <button type = "button" class="uploadcancel btn-xs  btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                  </form>
                  </div>
                </div>

              </div>
              </div><!-- /.box-body -->
        </div> <!-- /class="box box-solid box-success" -->
    </div> <!-- END COL MD 4 -->

      <div class="col-md-8">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">
                   <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Access List </h6></b>
                    
                    <select class="selectmoduleaccess input-sm form-control" style="width:30%;display:none;height: 30px;">
                    <?php
                      foreach ($moduledata as $data => $mdat) {
                        echo '<option id='.$mdat['attribute']. '-'.$mdat['code'].'>'.$mdat['description'].'</option>';
                      }
                    ?>
                    </select>

                    &nbsp&nbsp

                    <select class="selectsecondlevel input-sm form-control" style="width:30%;display:none;height: 30px;">
                    </select>

                  <div class="pull-right" style="margin-top: 5px;">
                  <div class="btn-group">
                    <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btneditaccess"><b><i class="fa fa-pencil"></i> Edit Access</b></button>
                    <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btnfinishaccess"><b><i class="fa fa-check"></i> Finish Editing</b></button>
                  </div>
                  </div><!-- /.box-tools -->
                  </div>
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


</div>
