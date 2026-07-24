<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
$this->title = 'City';

$script = <<< JS
    $(document).ready(function(){ 
      loadsccity(); loadsccityprov();
    });
JS;
$this->registerJs($script);
?>
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="savingtype" value="">
  <input type="hidden" id="cid">

<div class="col-md-12">
    <div class="box box-solid box-success">
        <div class="modulehead box-header with-border">
            <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                <div class="btn-group">
                    <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive btnnewsccity"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn btnsavesccity" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn btncancelsccity" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div id="sccitydiv" style='display:none;'>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-4"><h6 class="aimslabel">Code</h6></div>
                            <div class="col-md-8"><input type="text" class="form-control txtsccitycode input-sm"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-4"><h6 class="aimslabel3">City Name</h6></div>
                            <div class="col-md-8"><input type="text" class="form-control txtsccityname input-sm"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-4"><h6 class="aimslabel3">Province</h6></div>
                            <div class="col-md-8"><select class='form-control txtsccityprov'></select></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sccitycontent">
            </div>
        </div><!-- /.box-body -->
    </div>
</div>