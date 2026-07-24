<?php
use yii\helpers\Url;
$this->title = 'Postdated Checks';
?>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="savingtype" value="">
<input type = "hidden" id ="lines" value="">
<input type = "hidden" id ="clientdetail" value="">

<div class="col-md-12">
            <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">POSTDATED CHECKS</h6></b>
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                <div class="btn-group">
                <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success headbtn btnactive module-btnnewpdc"><b><i class="fa fa-file new_btn"></i> New</b></button>
                <button type="button" data-toggle="tooltip" title="Save" class="btn btn-default btn-success headbtn module-btnsavepdc" style="display: none;"><b><i class="fa fa-save save_btn"></i> Save</b></button>
                <button type="button" data-toggle="tooltip" title="Refresh" class="btn btn-default btn-success headbtn module-btnrefreshpdc"><b><i class="fa fa-refresh refresh_btn"></i> Refresh</b></button>
                <button type="button" data-toggle="tooltip" title="Post" class="btn btn-default btn-success headbtn module-btnpostpdc"><b><i class="fa fa-check post_btn"></i> Post</b></button>
                <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancelpdc" style="display: none;"><b><i class="fa fa-times cancel_btn" ></i> Cancel</b></button>
                </div>
                </div>
                </div><!-- /.box-header -->


              <div class="box-body">
            
                        
                        <div id = "" class="invoice-col col-md-3">
                          <h6><b>From Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                          <input type="text" name = "date1" readonly="" value="<?php echo date('Y-m-d');?>" size="12" class=" txtdateid1 form-control input-sm" disabled="true">
                          <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                          </div></b></h6>

                          <h6><b>Until: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                          <input type="text" name = "date2" readonly="" value="<?php echo date('Y-m-d');?>" size="12" class=" txtdateid2 form-control input-sm" disabled="true">
                          <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                          </div></b></h6>
                        </div>

                        <div class="pdctext invoice-col col-md-3">
                          <h6 style="display:none;" class="aimslabel3"><b>Collection Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                          <input type="text" name = "dateid" readonly="" value="<?php echo date('Y-m-d');?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                          <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                          </div></b></h6>

                          <h6 class="aimslabel3 clientcodelookup" style="display:none;"><b>Customer Code: <div class="input-group"><input name = "client" value =""  type="text" class=" aimslabel3 txtclientcode form-control input-sm" disabled="true"></b><div class="clientlookupbtn input-group-addon"><a class ="clientlookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div></h6>
                        </div>


                        <div class="pdctext invoice-col col-md-3">
                            <h6 class="aimslabel3" style="display:none;"><b>Check Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                            <input type="text" name = "checkdate" readonly="" value="" size="12" class="moduletxt txtcheckdate form-control input-sm" disabled="true">
                            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div></b></h6>

                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Clientname: <input disabled="true" name="clientname" value ="" type="text" class=" txtclientname form-control input-sm" ></b></h6>
                        </div>


                        <div class="pdctext invoice-col col-md-3">                
                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Check Details: <input name="checkno" value ="" type="text" class="moduletxt txtcheckno form-control input-sm" ></b></h6>
                            
                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Amount: <input name="amount" value ="" type="text" class="moduletxt txtamount form-control input-sm" ></b></h6>
                        </div>

                        <div class="pdctext invoice-col col-md-12">                
                            <h6 style="width: 230px;display: none;" class="aimslabel3" ><b>Notes: <input name="notes" value ="" type="text" class="txtnotes moduletxt txtcheckno form-control input-sm" ></b></h6>
                            
                        </div>


              </div><!-- /.box-body -->
              </br>
            </div><!-- /.box -->


            <div class="box box-solid box-success">

              <div class="box-body mod-tble">
            
                        <table class="bodytable table tbl-fix table-hover">
                        <thead>
                            <tr>
                                <th class="col-min aimslabel"><span class="text">Option</span></th>
                                <th class="col-min aimslabel"><span class="text">Post</span></th>
                                <th class="col-codes aimslabel"><span class="text">Collection Date</span></th>
                                <th class="col-codes aimslabel"><span class="text">Code</span></th>
                                <th class="col-description aimslabel"><span class="text">Name</span></th>
                                <th class="col-min aimslabel"><span class="text">Check Date</span></th>
                                <th class="col-codes aimslabel"><span class="text">Check Details</span></th>
                                <th class="col-currency aimslabel"><span class="text">Amount</span></th>
                                <th class="col-min aimslabel"><span class="text">Create By</span></th>
                                <th class="col-description aimslabel"><span class="text">Notes</span></th>
                            </tr>
                        </thead>
                        
                        <tbody id="pdc-modulebody" class="pdc-modulebody">
                          <?php 
                          if (isset($pdcdata)){
                            foreach ($pdcdata as $data => $dat) {
                            if ($dat['void']==1){
                              $rowclass = 'voidrow';
                            }else{
                              $rowclass='';
                            }

                                       echo'<tr id="pdcline-'.$dat['line'].'" class="orgrow ' .$rowclass.'">
                                       <td id="stockbuttons-'.$dat['line'].'" style="margin-bottom:-5px;" class="origdata btnstockopt col-xs-2 aimslabelstock">';
                                       
                                       if ($dat['tr']=='P'){
                                        echo'<button id="pdcedit-'.$dat['line'].'" data-toggle="tooltip" title="Edit" class="btneditpdc btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;" disabled><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                        <button id="pdcdelete-'.$dat['line'].'"  data-toggle="tooltip" title="Delete" class="btndeletepdc btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;" disabled><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>
                                        <button id="pdcvoid-'.$dat['line'].'"  data-toggle="tooltip" title="Void" class="btnvoidpdc btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;" disabled><i style="font-size:12px;margin-top:-8px;" class="fa fa-void" ></i></button>';
                                       }else{
                                          if ($dat['void']==1){
                                               echo'<button id="pdcedit-'.$dat['line'].'" data-toggle="tooltip" title="Edit" class="btneditpdc btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;" disabled><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                              <button id="pdcdelete-'.$dat['line'].'"  data-toggle="tooltip" title="Delete" class="btndeletepdc btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;" disabled><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>
                                              <button id="pdcvoid-'.$dat['line'].'"  data-toggle="tooltip" title="Void" class="btnvoidpdc btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;" disabled><i style="font-size:12px;margin-top:-8px;" class="fa fa-ban" ></i></button>';
                                          }else{
                                              echo'<button id="pdcedit-'.$dat['line'].'" data-toggle="tooltip" title="Edit" class="btneditpdc btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>
                                              <button id="pdcdelete-'.$dat['line'].'"  data-toggle="tooltip" title="Delete" class="btndeletepdc btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>
                                              <button id="pdcvoid-'.$dat['line'].'"  data-toggle="tooltip" title="Void" class="btnvoidpdc btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-ban"></i></button>';
                                          }//end if void
                                       }//end if posted
                                       echo '</td>';

                                       if ($dat['tr']=='P'){
                                        echo '<td style="margin-bottom:-5px;"><input class="pdcselect" type ="checkbox" id="'.$dat['line'].'" disabled /></td>'; 
                                       }else{
                                          if ($dat['void']==1){
                                            echo '<td style="margin-bottom:-5px;"><input class="pdcselect" type ="checkbox" id="'.$dat['line'].'" disabled /></td>'; 
                                          }else{
                                            echo '<td style="margin-bottom:-5px;"><input class="pdcselect" type ="checkbox" id="'.$dat['line'].'" /></td>'; 
                                          }//end if
                                       }

                                    echo '<td style="margin-bottom:-5px;" id="pdcdateid-'.$dat['line'].'" class="origdata col-codes aimslabel">'.$dat['dateid'].'</td>
                                    <td style="margin-bottom:-5px;" id="pdcclient-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['client'].'</td>
                                    <td style="margin-bottom:-5px;" id="pdcclientname-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['clientname'].'</td>
                                    <td style="margin-bottom:-5px;" id="pdccheckdate-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['checkdate'].'</td>
                                    <td style="margin-bottom:-5px;" id="pdccheckno-'.$dat['line'].'" class="origdata col-codes aimslabel">'.$dat['checkno'].'</td>
                                    <td style="margin-bottom:-5px;" id="pdcamount-'.$dat['line'].'" class="origdata col-min aimslabel">'.number_format($dat['amount'],2).'</td>
                                    <td style="margin-bottom:-5px;" id="pdccreateby-'.$dat['line'].'" class="origdata col-min aimslabel">'.$dat['createby'].'</td>
                                    <td style="margin-bottom:-5px;" id="pdcnotes-'.$dat['line'].'" class="origdata col-description aimslabel">'.$dat['notes'].'</td>';
                                  echo '</tr>';

                                    }
                                      }
                                      
                                        ?>
                                     
                                      </tbody>
                                  </table>        
                

              </div><!-- /.box-body -->
              </br>
            </div><!-- /.box -->
</div> <!-- END COL MD 12 -->
</div> <!-- END ROW -->

<!-- ################################################ SETTINGS LAYOUT ####################################### -->
