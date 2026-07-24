<?php
use yii\helpers\Url;
$this->title = 'Type';
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
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">TYPE</h6></b>
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                  <div class="btn-group">
                <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewtype"><b><i class="fa fa-file new_btn"></i> New</b></button>
                <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnsavetype" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncanceltype" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
                </div>
                </div><!-- /.box-header -->
           <div class="box-body">
                        <div id = "typetext" class="invoice-col col-md-3">
                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Type: <input name="type" value ="" type="text" class="moduletxt txttype form-control input-sm" id="typefocus"  ></b></h6>
                        </div>

                                      <table class="bodytable table tableSection table-fixed">
                                      <thead>
                                        <tr>
                                            <!-- <th class="col-xs-3 aimslabel"><span class="text">LINE</span></th> -->
                                            <th class="col-xs-7 aimslabel"><span class="text">TYPE</span></th>
                                            <th class="col-xs-2 aimslabel"><span class="text">OPTION</span></th>
                                        </tr>
                                    </thead>
                                      <tbody id="type-modulebody" class="type-modulebody"style="height:400px;">

                                      <?php 

                                      foreach ($typedata as $data => $dat) {
                                       echo'<tr id="typeline-'.$dat['line'].'" class="orgrow">
                                          <td style="margin-bottom:-5px;" id="type-'.$dat['line'].'" class="origdata col-xs-7 aimslabelstock">'.$dat['type'].'</td>
                                          <td id="stockbuttons-'.$dat['line'].'" style="margin-bottom:-5px;" class="origdata btnstockopt col-xs-2 aimslabelstock">';
                                      echo'<button id="typeedit-'.$dat['line'].'" data-toggle="tooltip" title="Edit" class="btnedittype btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                      <button id="typedelete-'.$dat['line'].'"  data-toggle="tooltip" title="Delete" class="btndeletetype btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>';
                                    
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
