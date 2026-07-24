<?php
use yii\helpers\Url;
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'SOUTHCENTRAL':
    $this->title = 'Warehouse Locations';
  break;

  case 'UNIVERSE':
        $this->title = 'Classification List';
    break;
  default:
    $this->title = 'Class';
  break;
}
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>
<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <div class="pull-right">
          <div class="btn-group">
            <button data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewmaster"><b><i class="fa fa-file new_btn"></i> New</b></button>
            <button data-toggle="tooltip" class="btn btn-default btn-success headbtn btnactive module-btnsavemaster"><b><i class="fa fa-save save_btn"></i>Save All</b></button>
          </div>
        </div>
      </div>


            <br>
            <div class="col-md-12 pull-right">
                <label>Search : </label>
                  <div class="input-group">
                    <input value ="" type="text" class="txtsearchclass2 input-sm form-control">
                    <div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
            </div>
            <br>
            <!-- end search -->

      <div class="box-body">
        <div id="masterfilegrid"></div>
      </div>
    </div>
  </div>
</div>