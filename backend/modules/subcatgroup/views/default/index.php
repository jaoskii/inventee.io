<?php
use yii\helpers\Url;
$this->title = 'Sub Category Group';
?>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="savingtype" value="">
<input type = "hidden" id ="catid" value="">
<input type = "hidden" id ="categorydetail" value="">
<input type = "hidden" id ="cid" value="">
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
                <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnewscg"><b><i class="fa fa-file new_btn"></i> New</b></button>
                <button type="button" class="btn btn-default btn-success headbtn module-btnsavescg" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                <button type="button" class="btn btn-default btn-success headbtn module-btncancelscg" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
                </div>
                </div><!-- /.box-header -->
           <div class="box-body">
                        <div id = "classtext" class="invoice-col col-md-3">
                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Name: <input name="name" value ="" type="text" id="namefocus" class="moduletxt txtscgname form-control input-sm" ></b></h6>

                            <h6 style="width: 230px;display: none;" class="aimslabel3"><b>Category Group:  </b>
                            <div class="input-group">
                                <input  disabled="true" name = "cgid" value ="" type="text" class="moduletxt txttcgid input-sm form-control"><div class="frmdocumentno input-group-addon"><a  class ="cglookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                            </div>

                        </div>

                                      <table class="bodytable table tableSection table-fixed">
                                      <thead>
                                        <tr>
                                            <th class="col-xs-6 aimslabel"><span class="text">NAME</span></th>
                                            <th class="col-xs-4 aimslabel"><span class="text">CATEGORY GROUP</span></th>
                                            <th class="col-xs-2 aimslabel"><span class="text">OPTION</span></th>
                                        </tr>
                                    </thead>
                                      <tbody id="class-modulebody" class="class-modulebody"style="height:400px;">

                                      <?php 

                                      foreach ($classdata as $data => $dat) {
                                       echo'<tr id="catid-'.$dat['id'].'" class="orgrow">
                                       <td style="margin-bottom:-5px;" id="scgname-'.$dat['id'].'" class="origdata col-xs-6 aimslabelstock">'.$dat['scat_grp'].'</td>
                                       <td style="margin-bottom:-5px;" id="cgid-'.$dat['id'].'" class="origdata col-xs-4 aimslabelstock">'.$dat['cat_grp'].'</td>
                                       <td id="stockbuttons-'.$dat['id'].'" style="margin-bottom:-5px;" class="origdata btnstockopt col-xs-2 aimslabelstock">';
                                      echo'<button id="scgedit-'.$dat['id'].'" class="btneditscg btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                      <button id="scgdelete-'.$dat['id'].'" class="btndeletescg btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>';
                                    
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
