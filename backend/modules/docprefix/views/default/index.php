<?php
use yii\helpers\Url;
$this->title = 'Document Prefix';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="savingtype" value="">
<input type = "hidden" id ="lines" value="">

  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">DOCUMENT PREFIX</h6></b>
        <div class="pull-right">
          <div class="btn-group">
            <button type="button" data-toggle="tooltip" title="Logs" class="btn btn-default btn-success btnactive btndocprefixlogs"><b><i class="fa fa-list"></i> Logs</b></button>
            <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnsavedocprefix" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
            <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncanceldocprefix" style="display: none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
          </div>
        </div>
        </div><!-- /.box-header -->
      <div class="box-body">
        <div class="docprefixdiv"></div>
      </div>
    </div><!-- /.box -->
  </div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<!-- ################################################ SETTINGS LAYOUT ####################################### -->