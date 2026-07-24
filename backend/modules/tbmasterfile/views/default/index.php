<?php
$this->title = 'Table Setup';

$script = <<< JS
    $(document).ready(function(){ 
        // loadtablesgrid();
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
    <div class="col-md-12">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                <div class="pull-right">
                    <div class="btn-group">
                        <button title="New Table" class="btn btn-default btn-success headbtn btnactive btnnewtable"><b><i class="new_btn fa fa-file"></i> New</b></button>
                    </div>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="invoice-info col-md-12" style="margin-left:-15px;">
                    <div class="tablesdiv"></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</div>