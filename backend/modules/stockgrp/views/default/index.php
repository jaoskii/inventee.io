<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;

switch (Yii::$app->systemsettings->companyConfig()) {

    case 'UNIVERSE':
        $this->title = 'Division Masterfile';
    break;

    default:
        $this->title = 'Stock Group';
    break;
}//end switch case
$script = <<< JS
    $(document).ready(function(){ loadstockgrp(); });
JS;
$this->registerJs($script);
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
                    <input value ="" type="text" class="txtsearchdivision2 input-sm form-control">
                    <div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
            </div>
            <br>
            <!-- end search -->

        <div class="box-body">
            <div id="masterfilegrid"></div>
        </div><!-- /.box-body -->
    </div>
</div>