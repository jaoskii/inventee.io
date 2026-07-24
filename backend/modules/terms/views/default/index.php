<?php
use yii\helpers\Url;
$this->title = 'Terms';
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
  <input type = "hidden" id ="termsdetail" value="">
  <div class="col-md-12">
    <div class="box box-solid box-success">
			<div class="modulehead box-header with-border">
        <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">TERMS</h6></b>
        <div class="pull-right">
          <div class="btn-group">
            <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewterms"><b><i class="fa fa-file new_btn"></i> New</b></button>
          </div>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="termsdiv"></div>
      </div>
    </div><!-- /.box -->
  </div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->