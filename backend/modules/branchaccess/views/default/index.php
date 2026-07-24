<?php
$this->title = 'Branch Access';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
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
                  </div>
                </div><!-- /.box-tools -->
               </div><!-- /.box-header -->
              
            <div class="box-body scroll-mini usergrplist" id="levels">
                <?php
                foreach ($usersdata as $data => $dat) {
                  echo '<button id = "acclevels-'.$dat['idno'].'" class="settings-btn centerlevel btn btn-info btn-flat">
                  '.$dat['username'].'</button>';
                }//END FOR EACH
                ?>
            </div><!-- /.box-body -->
           
        </div> <!-- /class="box box-solid box-success" -->
    </div> <!-- END COL MD 4 -->

      <div class="col-md-8">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">
                   <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Branch List </h6></b>

                    &nbsp;&nbsp;

                    <select class="selectsecondlevelbranch input-sm form-control" style="width:30%;display:none;height: 30px;">
                    </select>

                  <div class="pull-right" style="margin-top: 5px;">
                  <div class="btn-group">
                    <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btneditaccessbranch"><b><i class="fa fa-pencil"></i> Edit Access</b></button>
                    <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btnfinishaccessbranch"><b><i class="fa fa-check"></i> Finish Editing</b></button>
                  </div>
                  </div><!-- /.box-tools -->
                  </div>
                  <div class="box-body scroll-divs" id="accesslisting">
                  <div class="col-md-6">
                    <button class="btn btn-flat btn-primary settings-btn" style="width:100%;margin-top:3px;" disabled><b>BRANCHES</b></button>
                      <div id="allowed">
                        
                      </div>
                  </div><!-- /.col-md-4 -->
                  <div class="col-md-6">
                    <button class="btn btn-flat btn-primary settings-btn" style="width:100%;margin-top:3px;" disabled><b>DENIED BRANCHES</b></button>
                    <div id="notallowed">
                                            
                    </div>
                  </div><!-- /.col-md-4 -->
                  </div><!-- /.box-body -->
              </div><!-- /.box -->
      </div> <!-- END COL MD 9 -->


</div>
