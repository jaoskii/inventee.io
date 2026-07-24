<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'City';

$script = <<< JS
    $(document).ready(function(){ loadcity(); });
JS;
$this->registerJs($script);
?>


<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="savingtype" value="">
  <input type="hidden" id="cityid">

<div class="col-md-12">
    <div class="box box-solid box-success">
        <div class="modulehead box-header with-border">
            <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                <div class="btn-group">
                    <?php //$r = Url::toRoute('savemodel'); ?>
                    <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive btnnewcity"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn btnsavecity" style="display: none;" urlto="<?php //echo $r; ?>"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn btncancelcity" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div id = "citydiv" style='display: none;' class="invoice-col col-md-3">
                <h6 style="width: 230px;display: block;" class="aimslabel3" >
                <b>Code: <input name="code" value ="" required type="text" id="" class="moduletxt txtcitycode form-control input-sm" ></b>
                </h6>
                <h6 style="width: 230px;display: block;" class="aimslabel3" >
                <b>Name: <input name="name" value ="" required type="text" class="moduletxt txtcityname form-control input-sm" ></b>
                </h6>
            </div>
            <div class="citycontent">
            </div>
        </div><!-- /.box-body -->
    </div>
</div>