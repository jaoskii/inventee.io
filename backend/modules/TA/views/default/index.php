<?php
use yii\helpers\Url;
$this->title = 'Transfer Asset';
?>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="lines" value="">


<div class="col-md-12">
      <div class="box box-solid box-success">
        <div class="modulehead box-header with-border">
            <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">TRANSFER ASSET</h6></b>
            <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                <div class="btn-group">
                    <!--<button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewta"><b><i class="fa fa-file new_btn"></i> New</b></button>-->
                    <button type="button" data-toggle="tooltip" title="Add Item" class="btn btn-default btn-success headbtn btnactive module-btnaddfaitem" style="display: block;"><b><i class="fa fa-plus add_btn"></i> Add Item</b></button>
                    <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnpostta" style="display: none;"><b><i class="fa fa-check post_btn"></i> Post</b></button>
                    <!--<button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancelta" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>-->
                </div><!-- end BTN GROUP -->
            </div>
        </div><!-- /.box-header -->

        <div class="box-body mod-tble">                          
            <div id = "gitemtext" class="invoice-col col-md-3 gitemtext" style = "display:block;">
                <h6 style="width: 230px;" class="aimslabel3" ><b>Reference #: <input  name="ref" value ="" type="text" class=" txtref form-control" maxlength= "20"></b></h6>
                <h6 class="aimslabel3" ><b>Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <input type="text" name = "dateid" readonly="" value="<?php echo date('Y-m-d'); ?>" size="12" class="moduletxt txtdateid form-control" disabled="true">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div></b></h6>

                <h6 style="width: 230px;" class="aimslabel3" ><b>Remarks: <input name="rem" value ="" type="text" class=" txtrem form-control input-sm" ></b></h6>
            </div>
            <div id = "gitemtext" class="invoice-col col-md-3 gitemtext" style = "display:block;">
                <h6 class="aimslabel3 clientcodelookup" ><b>Employee Code: <div class="input-group"><input name = "client" value =""  type="text" class=" aimslabel3 txtclientcode form-control input-sm" disabled="true"></b><div class="emplookup input-group-addon"><a class ="emplookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div></h6>
                <h6 style="width: 230px;" class="aimslabel3" ><b>Name: <input disabled="true" name="clientname" value ="" type="text" class=" txtclientname form-control input-sm" ></b></h6>
            </div>


            <div id = "gitemtext" class="invoice-col col-md-3 gitemtext" style = "display:block;">
                <h6 class="aimslabel3 clientcodelookup" ><b>Loc Code: <div class="input-group"><input name = "loccode" value =""  type="text" class=" aimslabel3 txtloccode form-control input-sm" disabled="true"></b></h6>
                <h6 style="width: 230px;" class="aimslabel3" ><b>Location: <input disabled="true" name="location" value ="" type="text" class=" txtlocation form-control input-sm" ></b></h6>
            </div>

            <table class="bodytable table tbl-fix table-hover">
                <thead>
                    <tr>
                        <th class="col-min aimslabel"><span class="text">Tag Code</span></th>
                        <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                        <th class="col-description aimslabel"><span class="text">Item Desc</span></th>
                        <th class="col-description aimslabel"><span class="text">Item Shortname</span></th>
                    </tr>
                </thead>
              <tbody id="faitem-modulebody" class="faitem-modulebody">

              <?php 
              if (isset($faitem)){
                foreach ($faitem as $data => $dat) {

                echo'<tr id="faitemline-'.$dat['line'].'" class="orgrow">';
                echo '<td id="faitemtagcode-'.$dat['line'].'" class="origdata col-codes aimslabel">'.$dat['barcode'].'</td>
                <td  id="faitembcode-'.$dat['line'].'" class="origdata col-description aimslabel">'.$dat['bcode'].'</td>
                <td  id="faitemname-'.$dat['line'].'" class="origdata col-description aimslabel">'.$dat['itemname'].'</td>
                <td  id="faitemshortname-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['shortname'].'</td>';
                echo '</tr>';

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
