<?php
use yii\helpers\Url;
$this->title = 'Transaction Update';
?>

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
<input type = "hidden" id ="moduleid" value="transupdate">
<input type = "hidden" id ="viewmoduleid" value="transupdate">

<div class="col-md-12">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                  <div class="col-md-6 pull-right">
                    <label class="aimslabel">Search Keywords:</label>
                    <div class="input-group">
                      <input value ="" type="text" class="txtsearchupdatedocno input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="aimslabel">Select Transaction Type</label>
                    <select id="transtype" class="transtype input-sm form-control">
                      <option>SJ</option>
                      <option>CM</option>
                      <option>RR</option>
                    </select>
                  </div>
              </div><!-- /.box-header -->
           <div class="transupdatediv">
            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
