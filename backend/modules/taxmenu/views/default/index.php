<?php
use yii\helpers\Url;
$this->title = 'Tax Menu';
?>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="savingtype" value="">
<input type = "hidden" id ="lines" value="">
<input type = "hidden" id ="termsdetail" value="">

<div class="col-md-12">
      <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">TAX MENU</h6></b>
                <div class="box-tools pull-right">
                <!-- BEGIN BTN GROUP -->
                  <div class="btn-group">
                <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewtaxmenu"><b><i class="fa fa-file new_btn"></i> New</b></button>
                <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnsavetaxmenu" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncanceltaxmenu" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
                </div>
                </div><!-- /.box-header -->

            <div id = "taxmenutext" class="invoice-col col-md-3">
                <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Name: <input name="name" value ="" type="text" class="moduletxt txttname form-control input-sm" ></b></h6>
                <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Atc: <input name="atc" value ="" type="text" class="moduletxt txtatc form-control input-sm" ></b></h6>
                <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Rate: <input name="rate" value ="" type="text" class="moduletxt txtrate form-control input-sm" ></b></h6>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php 
                  echo '<div id="modulestockview" class="box box-solid box-success"></div>'
                ?>
              </div>
            </div>
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<!-- ################################################ SETTINGS LAYOUT ####################################### -->
