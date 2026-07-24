<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Commission Master File';

$script = <<< JS
    $(document).ready(function(){ loadcommission(); });
JS;
$this->registerJs($script);
?>


<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="savingtype" value="">
  <input type="hidden" id="comid">

<div class="col-md-12">
    <div class="box box-solid box-success">
        <div class="modulehead box-header with-border">
            <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                <div class="btn-group">
                    <?php //$r = Url::toRoute('savemodel'); ?>
                    <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive btnnewcom"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn btnsavecom" style="display: none;" urlto="<?php //echo $r; ?>"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn btncancelcom" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div id="commdiv" class='col-md-12' style='display:none;'>
                <div class="row">
                    <div class="col-md-1"><h6 class="aimslabel3">Code</h6></div>
                    <div class="col-md-3"><input type="text" class="form-control txtcomcode input-sm"></div>
                    <div class="col-md-1"><h6 class="aimslabel3">Name</h6></div>
                    <div class="col-md-3"><input type="text" class="form-control txtcomname input-sm"></div>
                </div>
                <div class="row" style='margin-top:5px;'>
                    <div class="col-md-1"><h6 class="aimslabel3">From</h6></div>
                    <div class="col-md-3"><input type="text" class="form-control txtcomfrom input-sm"></div>
                    <div class="col-md-1"><h6 class="aimslabel3">To</h6></div>
                    <div class="col-md-3"><input type="text" class="form-control txtcomto input-sm"></div>
                </div>
                <div class="row" style='margin-top:5px;'>
                    <div class="col-md-1"><h6 class="aimslabel3">Rate</h6></div>
                    <div class="col-md-3"><input type="text" class="form-control txtcomrate input-sm"></div>
                    <div class="col-md-1"><h6 class="aimslabel3">Piece</h6></div>
                    <div class="col-md-3"><input type="text" class="form-control txtcompiece input-sm"></div>
                </div>
            </div>
            <div class="commcontent">
            </div>
        </div><!-- /.box-body -->
    </div>
</div>