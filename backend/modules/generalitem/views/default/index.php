<?php
use yii\helpers\Url;
$this->title = 'General Item';
?>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="lines" value="">


<div class="col-md-12">
      <div class="box box-solid box-success">
        <div class="modulehead box-header with-border">
            <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">GENERAL ITEM</h6></b>
            <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                <div class="btn-group">
                    <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewgenitem"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnsavegenitem" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                    <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancelgenitem" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div><!-- end BTN GROUP -->
            </div>
        </div><!-- /.box-header -->

        <div class="box-body mod-tble">                          
            <div id = "gitemtext" class="invoice-col col-md-2 gitemtext" style = "display:none;">
                <h6 class="aimslabel3"><b>Barcode: <input name = "bcode" value =""  type="text" class="moduletxt txtbcode form-control input-sm"></b>
                </h6>
                <h6 class="aimslabel3" ><b>Uom: <input name="itemuom" value ="" type="text" class="moduletxt txtuom form-control input-sm" ></b></h6>
                <h6 class="aimslabel3" ><b>Size: <input name="itemsize" value ="" type="text" class="moduletxt txtsize form-control input-sm" ></b></h6> 
            </div>


            <div id = "gitemtext" class="invoice-col col-md-3 gitemtext"  style = "display:none;">
                <h6 style="width: 230px;" class="aimslabel3" ><b>Item Description: <input name="itemdesc" value ="" type="text" class="moduletxt txtitemdesc form-control input-sm" ></b></h6>
                <h6 style="width: 230px;" class="aimslabel3" ><b>Item Shortname: <input name="itemshortname" value ="" type="text" class="moduletxt txtitemshortname form-control input-sm" ></b></h6>
            </div>

            <div id = "gitemtext" class="invoice-col col-md-2 gitemtext"  style = "display:none;">
                <h6 class="aimslabel3" ><b>Brand: <input name="itembrand" value ="" type="text" class="moduletxt txtbrand form-control input-sm" ></b></h6>                          
                <h6 class="aimslabel3" ><b>Color: <input name="itemcolor" value ="" type="text" class="moduletxt txtcolor form-control input-sm" ></b></h6>
            </div>

            <div id = "gitemtext" class="invoice-col col-md-2 gitemtext"  style = "display:none;">
                <h6 class="aimslabel3" ><b>Group: <input name="itemgroup" value ="" type="text" class="moduletxt txtgroup form-control input-sm" ></b></h6>                          
                <h6 class="aimslabel3" ><b>Part: <input name="itempart" value ="" type="text" class="moduletxt txtpart form-control input-sm" ></b></h6>
            </div>

            <div id = "gitemtext" class="invoice-col col-md-2 gitemtext"  style = "display:none;">
                <h6 class="aimslabel3" ><b>Model: <input name="itemmodel" value ="" type="text" class="moduletxt txtmodel form-control input-sm" ></b></h6>                          
                <h6 class="aimslabel3" ><b>Class: <input name="itemclass" value ="" type="text" class="moduletxt txtclass form-control input-sm" ></b></h6>
            </div>


                                      <table class="bodytable table tbl-fix table-hover">
                                    <thead>
                                        <tr>
                                            <th class="col-min aimslabel"><span class="text">OPTION</span></th>
                                            <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                                            <th class="col-description aimslabel"><span class="text">Item Desc</span></th>
                                            <th class="col-description aimslabel"><span class="text">Item Shortname</span></th>
                                            <th class="col-min aimslabel"><span class="text">UOM</span></th>
                                            <th class="col-min aimslabel"><span class="text">Brand</span></th>
                                            <th class="col-min aimslabel"><span class="text">Color</span></th>
                                            <th class="col-min aimslabel"><span class="text">Group</span></th>
                                            <th class="col-min aimslabel"><span class="text">Part</span></th>
                                            <th class="col-min aimslabel"><span class="text">Model</span></th>
                                            <th class="col-min aimslabel"><span class="text">Class</span></th>
                                            <th class="col-min aimslabel"><span class="text">Size</span></th>
                                        </tr>
                                    </thead>
                                      <tbody id="genitem-modulebody" class="genitem-modulebody"style="height:400px;">

                                      <?php 
                                      if (isset($generalitem)){
                                        foreach ($generalitem as $data => $dat) {

                                        echo'<tr id="genitemline-'.$dat['line'].'" class="orgrow">';
                                        echo '<td id="stockbuttons-'.$dat['line'].'"  class="origdata btnstockopt col-xs-2 aimslabelstock">';
                                    
                                      echo'<button id="genitemedit-'.$dat['line'].'" data-toggle="tooltip" title="Edit" class="btneditgenitem btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                      <button id="genitemdelete-'.$dat['line'].'"  data-toggle="tooltip" title="Delete" class="btndeletegenitem btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>';
                                        echo '<td  id="genitembcode-'.$dat['line'].'" class="origdata col-codes aimslabel">'.$dat['bcode'].'</td>
                                        <td  id="genitemdesc-'.$dat['line'].'" class="origdata col-description aimslabel">'.$dat['itemdesc'].'</td>
                                        <td  id="genitemshortname-'.$dat['line'].'" class="origdata col-description aimslabel">'.$dat['itemshortname'].'</td>
                                        <td  id="genitemuom-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itemuom'].'</td>
                                        <td id="genitembrand-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itembrand'].'</td>
                                        <td  id="genitemcolor-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itemcolor'].'</td>
                                        <td  id="genitemgroup-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itemgroup'].'</td>
                                        <td  id="genitempart-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itempart'].'</td>
                                        <td  id="genitemmodel-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itemmodel'].'</td>
                                        <td  id="genitemclass-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itemclass'].'</td>
                                        <td  id="genitemsize-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['itemsize'].'</td>';
                                        echo '</td></tr>';

                                   }

                                      }
                                      
                                        ?>
                                     
                                      </tbody>
                                  </table>        
            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<!-- ################################################ SETTINGS LAYOUT ####################################### -->
