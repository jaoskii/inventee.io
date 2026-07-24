<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
$this->title = 'Routes';

$script = <<< JS
    $(document).ready(function(){ 
      $('#refreshroute').click();
    });
JS;
$this->registerJs($script);
?>


<?php $u = Url::toRoute('loadroutes'); ?>
<input type="button" name="" id='refreshroute' style='display:none;' value='hupaw' urlto="<?php echo $u; ?>">


<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="savingtype" value="">
  <input type="hidden" id="routeid">
  <input type="hidden" id="routeto">

<div class="col-md-12">
    <div class="box box-solid box-success">
        <div class="modulehead box-header with-border">
            <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                <div class="btn-group">
                    <?php $r = Url::toRoute('saveroute'); ?>
                    <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive btnnewroute"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn btnsaveroute" style="display: none;" urlto="<?php echo $r; ?>"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn btncancelroute" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div id = "routediv" style='display: none;' class="invoice-col col-md-3">
                <h6 style="width: 230px;display: block;" class="aimslabel3" >
                <b>Code: <input name="code" value ="" required type="text" id="" class="moduletxt txtroutecode form-control input-sm" ></b>
                </h6>
                <h6 style="width: 230px;display: block;" class="aimslabel3" >
                <b>Name: <input name="name" value ="" required type="text" class="moduletxt txtroutename form-control input-sm" ></b>
                </h6>
            </div>
            <div class="routecontent">
            </div>
        </div><!-- /.box-body -->
    </div>
</div>