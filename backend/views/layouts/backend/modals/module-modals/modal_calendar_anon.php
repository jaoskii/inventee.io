<!-- MODAL FOR CALENDAR-->
<div class="modal fade" id="modal-calendar-anon" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Manage Announements</h4>
      </div>

      <div class="row" style="margin-top:10px;">
            <div class="col-md-12">
                  <!-- <div class="col-md-3">
                        <label>User: </label>
                        <div class="input-group">
                        <input readonly="true" name="user" value ="" type="text" class="anonuser form-control input-sm">
                        <div class="input-group-addon"><a class ="anonuserlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                        </div>
                  </div>
                  <div class="col-md-3">
                        <label>Show date from: (Until Now)</label>
                        <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                        <input type="text" name = "dateid" readonly="" value="" size="12" class="moduletxt anondateid form-control input-sm" disabled="true">
                        <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a>
                        </div>
                      </div>
                  </div>


                  <div class="col-md-2"></br>
                  <button type="button" class="btnfilteranon btn btn-flat btn-success">Refresh</button>
                  </div> -->

                  <div class="col-md-push-9 col-md-2 anondisable"></br>
                  <button type="button" class=" btnaddanon btn btn-flat btn-info">Add Announcement</button>
                  </div>

                  <div class="col-md-push-8 col-md-4 anonenable" style="display:none"></br>
                  <button type="button" class="btnsaveanon btn btn-flat btn-success">Save Announcement</button>
                  <button type="button" class="btncancelanon btn btn-flat btn-warning">Cancel</button>
                  </div>

                  
            </div>
      </div>

      <div class="modal-body anonlisting">
      <div class="box-body mod-tble">
      <table class="table tbl-fix bodytable">
          <thead>
            <tr>
                <th class="col-min aimslabel"><span class="text">OPTION</span></th>
                <th class="col-codes aimslabel"><span class="text">USER</span></th>
                <th class="col-description aimslabel"><span class="text">TITLE</span></th>
                <th class="col-description aimslabel"><span class="text">DATE</span></th>
                <th class="col-codes aimslabel"><span class="text">CREATED</span></th>
            </tr>
          </thead>
          <tbody class="anon-modulebody">
          </tbody>
      </table>
      </div>
      </div>

      <div class="modal-body anonform" style="display:none;">
      <div class="box-body">
          <label style="margin-top:3px;">From Date: </label>
          <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
            <input type="text" name = "anondateid" readonly="" value="" size="12" class="anondate1 form-control input-sm" disabled="true">
            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a>
            </div>
          </div>
          <label style="margin-top:3px;">Until Date: </label>
          <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
            <input type="text" name = "anondateid" readonly="" value="" size="12" class="anondate2 form-control input-sm" disabled="true">
            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a>
            </div>
          </div>
          <input id="anonid" type="hidden" class="form-control">
          <label style="margin-top:3px;">Enter Announcement Title: </label>
          <input id="anon-title" type="text" class="input-sm form-control" placeholder="Event Title">
          <label style="margin-top:3px;">Announcement Details: </label>
          <textarea name="desc" id="anon-desc" class="input-sm form-control" style="resize:none;"  rows="5" cols="50"></textarea>
      </div>
      </div>


      <div class="modal-footer">
      <button type="button" class="closeitemlookup btn btn-sm btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>