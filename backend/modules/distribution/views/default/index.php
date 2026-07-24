<?php
use yii\helpers\Url;
$this->title = 'Distribution Area';
?>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="savingtype" value="">
<input type = "hidden" id ="catid" value="">
<input type = "hidden" id ="categorydetail" value="">
<!-- <div class="col-md-3">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Setting Packages</h6></b>
                </div><!-- /.box-header -->
            <!-- <div class="box-body scroll-divs">
                <button class="btn btn-flat btn-info settings-btn">AIMS Settings</button>
                <button class="btn btn-flat btn-info settings-btn">Frontend Settings</button>
            </div><!-- /.box-body -->
        <!-- </div>/.box -->
<!-- </div> END COL MD 3 -->


<div class="col-md-12">
      <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <!-- <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">CATEGORIES</h6></b> -->
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                  <div class="btn-group">
                <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewdistribution"><b><i class="fa fa-file new_btn"></i> New</b></button>
                <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnsavedistribution" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncanceldistribution" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
                </div>
                </div><!-- /.box-header -->
           <div class="box-body">
                        <div id = "distributiontext" class="invoice-col col-md-3">
                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Code: <input name="code" value ="" type="text" id="distributionfocus" class="moduletxt txtdistcode form-control input-sm" ></b></h6>
                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Name: <input name="name" value ="" type="text" class="moduletxt txtdistname form-control input-sm" ></b></h6>
                        </div>

                                      <table class="bodytable table tableSection table-fixed">
                                      <thead>
                                        <tr>
                                            <th class="col-xs-3 aimslabel"><span class="text">CODE</span></th>
                                            <th class="col-xs-7 aimslabel"><span class="text">NAME</span></th>
                                            <th class="col-xs-2 aimslabel"><span class="text">OPTION</span></th>
                                        </tr>
                                    </thead>
                                      <tbody id="distribution-modulebody" class="distribution-modulebody"style="height:400px;">

                                      <?php 

                                      foreach ($distdata as $data => $dat) {
                                       echo'<tr id="catid-'.$dat['dist_id'].'" class="orgrow">
                                       <td style="margin-bottom:-5px;" id="distcode-'.$dat['dist_id'].'" class="origdata col-xs-3 aimslabelstock">'.$dat['dist_code'].'</td>
                                       <td style="margin-bottom:-5px;" id="distname-'.$dat['dist_id'].'" class="origdata col-xs-7 aimslabelstock">'.$dat['dist_name'].'</td>
                                       <td id="stockbuttons-'.$dat['dist_id'].'" style="margin-bottom:-5px;" class="origdata btnstockopt col-xs-2 aimslabelstock">';
                                      echo'<button id="distedit-'.$dat['dist_id'].'" data-toggle="tooltip" title="Edit" class="btneditdistribution btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                      <button id="distdelete-'.$dat['dist_id'].'"  data-toggle="tooltip" title="Delete" class="btndeletedistribution btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>';
                                    
                                    echo '</td>
                                  </tr>';

                                    }
                                        ?>
                                     
                                      </tbody>
                                  </table>        
            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<!-- ################################################ SETTINGS LAYOUT ####################################### -->
