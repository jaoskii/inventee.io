<?php
use yii\helpers\Url;
$this->title = 'Principal';
?>

<div class="row">
    <input type="hidden" id="moduleid" value="<?php echo $moduleid; ?>">
    <input type="hidden" id="viewmoduleid" value="<?php echo $moduleid; ?>">
    <input type="hidden" id="savingtype" value="">
    <input type="hidden" id="lines" value="">
    <input type="hidden" id="principaldetail" value="">
    <div class="col-md-12">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
            <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Principal</h6></b>
                
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewprincipal"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    </div>
                </div>
            </div><!-- /.box-header -->

            <br>
            <div class="col-md-12 pull-right">
                <label>Search : </label>
                  <div class="input-group">
                    <input value ="" type="text" class="txtsearchprincipal2 input-sm form-control">
                    <div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
            </div>
            <br>
            <!-- end search -->
            <div class="box-body">
                <div class="principaldiv"></div>
            </div>
        </div><!-- /.box -->
    </div>
</div>


