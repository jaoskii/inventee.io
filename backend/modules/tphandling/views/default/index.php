<?php



use yii\helpers\Url;
$this->title = 'Set Invoice Handling';
?>

<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<div class="col-md-12">
    <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <!--  -->

                <div class="pull-right">
                     <input name="trno" value="<?php if(isset($moduledata)){echo $moduledata['head']['trno'];}?>" type="text" class=" txtboxtrno form-control input-sm" disabled="true" style="display:none;">
                <!-- BEGIN BTN GROUP -->
                    <button type="button" class="btn btn-default btn-success stockbtn stocksaveall" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save All Edited Data</b></button>
                    <button type="button" class="btn btn-default btn-success stockbtn stock-btnadd "><b><i class="add_btn fa fa-plus"></i> Add Invoice</b></button>
                </div>
                </div><!-- /.box-header -->
           
                <div class="box-body">
                <div class="col-md-3">
                <label class="aimslabel">Start Date:</label>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <input type="text" name = "dateid" readonly="" value="" size="12" class="moduletxt txtdateid1 form-control input-sm" disabled="true">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down clientfilterlookup"></i></a></div>
                </div>
                </div>
                
                <div class="col-md-3">
                <label class="aimslabel">End Date</label>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <input type="text" name = "dateid" readonly="" value="" size="12" class="moduletxt txtdateid2 form-control input-sm" disabled="true">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div>
                </div>
                
                <div class="col-md-3">
                
                </div>

                <div class="col-md-3">
                <br>
                <button class="col-md-12 btn btn-info btn-flat btntpsearch">Search Record</button>
                </div>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<?php
    require('invoices.php');
?>