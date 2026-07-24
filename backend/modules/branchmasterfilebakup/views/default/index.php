<?php
use yii\helpers\Url;
$this->title = 'Branch Masterfile';
?>
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="savingtype" value="">
<input type = "hidden" id ="lines" value="">



<div class="col-md-12">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">LIST OF BRANCHES</h6></b>
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                  <div class="btn-group">
                <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewbranch"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Edit" class="btn btn-default btn-success headbtn module-btneditbranch" style="display: none;"><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnsavebranch" style="display:none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancelbranch" style="display:none;"><b><i class="fa fa-times cancel_btn"></i> Cancel</b></button>
                    <button type="button" data-toggle="tooltip" title="Delete" class="headbtn module-btndeletebranch btn btn-default btn-success" style="display:none;"><b><i class="fa fa-trash delete_btn" ></i> Delete</b></button>
                    </div>
                </div>
                </div><!-- /.box-header -->

      
        <div class="box-body scroll-divs">
            
            <div class="col-md-6">        
                <div id = "centerbutton" >
                <?php 
                      foreach ($centerdata as $data => $cen) {

                            echo '<button id ="centerid-'.$cen['id'].'-'.$cen['line'].'" class=" centerclass btn btn-flat btn-info settings-btn" style="width:300px;margin-top:3px;"><b>'.$cen['name'].'</b></button><br/>';
                            }//END FOR EACH

                            //var_dump($centerdata);
                ?>
                </div><!-- /.box-body -->
            </div><!-- /.box-body -->

            <div class="col-md-6">        
                  <div class="box-body">
                        <div id = "centertext"  style="display: none;" class="invoice-col col-md-3">
                        </div><!-- /.col -->
                        </div>                                   
                </div>
        </div><!-- /.box-body -->
            
        </div><!-- /.box -->
</div> <!-- END COL MD 7 -->

</div> <!-- END ROW -->

<!-- ################################################ SETTINGS LAYOUT ####################################### -->


    