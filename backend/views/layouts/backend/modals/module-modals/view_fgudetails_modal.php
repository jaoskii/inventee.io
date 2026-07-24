<!-- MODAL FOR SHOW TERMS-->
<div class="modal fade" id="modal_viewfguprocess_details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Process Details</h4>
      </div>

      <div class="modal-body">
          <div class="nav-tabs-custom">
              <ul class="nav nav-tabs bg-green">
                <li class="active"><a href="#tab_4" data-toggle="tab" class="clickable tab_jbu_general" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">General</a></li>
                <li class=""><a href="#tab_5" data-toggle="tab" class="clickable tab_jbu_input" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Input</a></li>
                <li class=""><a href="#tab_6" data-toggle="tab" class="clickable tab_jbu_output" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Output</a></li>
                <li class=""><a href="#tab_7" data-toggle="tab" class="clickable tab_jbu_reject" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Reject</a></li>
                <li class=""><a href="#tab_8" data-toggle="tab" class="clickable tab_jbu_ink" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Ink Consumption</a></li>
              </ul>
                
             <div class="tab-content">
                <div class="tab-pane active" id="tab_4">
                  <div class="row">
                    <div class="col-md-4">
                          <h6 class="aimslabel"><b>Process Status:</b>
                              <select id="processstatus" name = "processstatus" class="processstatus txtfbuupdate input-sm form-control">
                              </select>
                          </h6>

                          <h6 class="aimslabel dateidlookup"><b>Date: 
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            <input type="text" name = "dateid" value="" size="12" class="txtfbuupdate txtdateid form-control input-sm" readonly>
                            </div></b>
                          </h6>
  

                          <h6 class="aimslabel"><b>Machine #: 
                          <input name="machinenum" value="" type="text"  class="txtfbuupdate txtmachinenum form-control input-sm"></b>
                          </h6>

                          <h6 class="aimslabel"><b>Operator: 
                          <input name="operator" value="" type="text"  class="txtfbuupdate txtoperator form-control input-sm"></b>
                          </h6>

                          <h6 class="aimslabel"><b>QA: 
                          <input name="qa" value="" type="text"  class="txtfbuupdate txtqa form-control input-sm"></b>
                          </h6>
                    </div> <!-- end row -->

                    <div class="col-md-4">

                          <h6 class="aimslabel dateidlookup"><b>Date Started: 
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            <input type="text" name = "date_start" value="" size="12" class="txtfbuupdate txtdateidstart form-control input-sm" readonly>
                            </div></b>
                          </h6>
  

                          <h6 class="aimslabel dateidlookup"><b>Date Finished: 
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            <input type="text" name = "date_fin"  value="" size="12" class="txtfbuupdate txtdateidend form-control input-sm" readonly>
                            </div></b>
                          </h6>
  
                          
                          <h6 class="aimslabel"><b># of Hrs: 
                          <input name="numhrs" value="" type="text"  class="txtfbuupdate txthrs form-control input-sm"></b>
                          </h6>

                          <h6 class="aimslabel"><b>Notes: 
                            <textarea name="rem" class="txtfbuupdate txtnotes form-control" style="resize:none;"  rows="3" cols="50"></textarea></b></h6>
                    </div> <!-- end row -->

                    <div class="col-md-4">
                          <h6 class="aimslabel"><b>Time Started <i>(Sample Format HH:MM:SS AM/PM)</i>
                          <input name="time_started" value="" type="text" errmsg= "txttimestart_err" class="txtfbuupdate txttimesstring txttimestart form-control input-sm"></b>
                          </h6>

                          <i><label class="aimslabel" style="display:none;" id="txttimestart_err"></label></i>

                          <h6 class="aimslabel"><b>Time Finished <i>(Sample Format HH:MM:SS AM/PM)</i>
                          <input name="time_finished" value="" type="text" errmsg= "txttimefinished_err" class="txtfbuupdate txttimesstring txttimefinish form-control input-sm"></b>
                          </h6>
                          <i><label class="aimslabel" style="display:none;" id="txttimefinished_err"></label></i>


                          <label class="aimslabel"><b>Discrepancy: <span style="color:red" class="jbu_disc_kgs">--</span>&nbspKGS
                          &nbsp<span style="color:red" class="jbu_disc_m">--</span>&nbspM
                          &nbsp<span style="color:red" class="jbu_disc_mpercent">--</span>&nbsp(M%)</b></label>
                          <button class="btn btn-xs btn-flat btn-github jbu_updateprocessdetails"><i class="fa fa-save"></i> 
                          <b>Update Process Details</b></button>

                    </div> <!-- end row -->
                  </div> <!-- END TAB PANE 4 -->
                </div> <!-- END TAB PANE 5 -->

                <div class="tab-pane" id="tab_5">
                    <div class="row">
                        <div class="col-md-12">
                          <button style="margin-bottom: 5px;" class="btn btn-xs btn-flat btn-github jbu_addinput"><i class="fa fa-plus"></i> 
                          <b>Add New Input</b></button>
                          <div id="jbuprocinputgrid" class="box box-solid box-success"></div>
                        </div>
                    </div>
                </div> <!-- END TAB PANE 5 -->

                <div class="tab-pane" id="tab_6">
                    <div class="row">
                        <div class="col-md-12">
                          <button style="margin-bottom: 5px;" class="btn btn-xs btn-flat btn-github jbu_addoutput"><i class="fa fa-plus"></i> 
                          <b>Add New Output</b></button>
                          <div id="jbuprocoutputgrid" class="box box-solid box-success"></div>
                        </div>
                    </div>
                </div> <!-- END TAB PANE 6 -->

                <div class="tab-pane" id="tab_7">
                    <div class="row">
                        <div class="col-md-12">
                          <button style="margin-bottom: 5px;" class="btn btn-xs btn-flat btn-github jbu_addreject"><i class="fa fa-plus"></i> 
                          <b>Add New Reject</b></button>
                          <div id="jbuprocrejectgrid" class="box box-solid box-success"></div>
                        </div>
                    </div>
                </div> <!-- END TAB PANE 7 -->

                <div class="tab-pane" id="tab_8">
                    <div class="row">
                        <div class="col-md-12">
                          <button style="margin-bottom: 5px;" class="btn btn-xs btn-flat btn-github jbu_addink"><i class="fa fa-plus"></i> 
                          <b>Add Ink Consumption</b></button>
                          <div id="jbuprocinkgrid" class="box box-solid box-success"></div>
                        </div>
                    </div>
                </div> <!-- END TAB PANE 7 -->
             </div> <!-- END TAB CONTENT -->
          </div> <!-- END NAV TAB CUSTOM -->
      </div>

      <div class="modal-footer">
      <button type="button" class="closearea btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>