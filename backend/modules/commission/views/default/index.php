<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Commmision Masterfile';

$script = <<< JS
    $(document).ready(function(){ });
JS;
$this->registerJs($script);
?>


<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="savingtype" value="">
  <input type="hidden" id="savingtype2">
  <input type="hidden" id="comid">
  <input type="hidden" id="comdetid">
  <input type="hidden" id="comcode">

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
                    <button type="button" data-toggle="tooltip" title="Edit" class="btn btn-default btn-success headbtn btneditcom" style="display: none;"><b><i class="fa fa-edit" ></i> Edit</b></button>

                    <button type="button" data-toggle="tooltip" title="Edit" class="btn btn-default btn-success headbtn btndeletecom" style="display: none;"><b><i class="fa fa-trash" ></i> Delete</b></button>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div id="commdiv" class='col-md-12'>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="panel panel-success" style='padding:10px;'>
                        <div class="row">
                            <div class="col-md-2"><h6 class="aimslabel">CODE</h6></div>
                            <div class="col-md-10">
                                <input type="text" class="form-control txtcomcode1" style='display:none;'>
                                <div class="input-group txtcomcodediv">
                                    <input type="text" class='form-control txtcomcode'>
                                    <span class="input-group-btn">
                                        <button class='btn btn-sm btn-success' id='btncommlookup' style='height:34px;padding:0px;padding-left:8px;padding-right:8px;'><i class='fa fa-chevron-circle-down'></i></button>
                                    </span>
                                </div>
                                <!-- <input type="text" class="form-control txtcomcode"> -->
                            </div>
                        </div>
                        <div class="row" style='margin-top:5px;'>
                            <div class="col-md-2"><h6 class="aimslabel">NAME</h6></div>
                            <div class="col-md-10"><input type="text" readonly class="form-control txtcomname"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->

        <div class="box box-solid box-success commcontent1" style='width:98%;margin-left:1%;display:none;'>
            <div class="modulehead box-header with-border">

                <div class="pull-right">
                    <button class='btn btn-md btn-success btnaddcomdetail'><i class="fa fa-plus"></i>&nbsp;Add New</button>
                </div>

            </div>
            <div class="commcontent" style='width:99%;margin-left:0.5%;margin-top:5px;'>
            </div>
        </div>
    </div>
</div>