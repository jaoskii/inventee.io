<?php
$this->title = 'Wysiwyg Editor';
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="updatefield" value="<?php echo $f; ?>">

 <div class="col-md-12">
    <div class="box box-solid box-success" style="margin-bottom:-0px;">
        <div class="modulehead box-header with-border">
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-success headbtn wig-save"><b><i class="save_btn fa fa-save"></i> Update Info</b></button>
                </div>
            </div>
        </div>
    </div><!-- /.box -->
</div>
</div>

<div class="row">
 <div class="col-md-12">
        <div class="nav-tabs-custom">
           
        <div class="tab-content">
            <div class="box box-solid box-success" style="margin-bottom:-0px;">
                <div class="box-body">
                    <textarea class="wig aimslabel txtwigeditor form-control" style="resize:none;">
                        <?php if(isset($toedit)){echo $toedit;}?>
                    </textarea>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div> <!-- END TAB CONTENT -->
    </div> <!-- END NAV CUSTOM -->
</div>
</div>