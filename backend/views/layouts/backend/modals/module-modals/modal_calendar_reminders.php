<!-- MODAL FOR CALENDAR-->
<div class="modal fade" id="modal-calendar-reminder" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Manage Reminders</h4>
      </div>

      <div class="row" style="margin-top:10px;">
            <div class="col-md-12">

                  <div class="col-md-push-9 col-md-2 reminderdisable"></br>
                  <button type="button" class=" btnaddreminder btn btn-flat btn-info">Add Reminder</button>
                  </div>

                  <div class="col-md-push-8 col-md-4 reminderenable" style="display:none"></br>
                  <button type="button" class="btnsavereminder btn btn-flat btn-success">Save Reminder</button>
                  <button type="button" class="btncancelreminder btn btn-flat btn-warning">Cancel</button>
                  </div>

                  
            </div>
      </div>

      <div class="modal-body reminderlisting">
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
          <tbody class="reminder-modulebody">
          </tbody>
      </table>
      </div>
      </div>

      <div class="modal-body reminderform" style="display:none;">
      <div class="box-body">
          <label style="margin-top:3px;">From Date: </label>
          <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
            <input type="text" name = "reminderdateid" readonly="" value="" size="12" class="reminderdate1 form-control input-sm" disabled="true">
            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a>
            </div>
          </div>
          <label style="margin-top:3px;">Until Date: </label>
          <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
            <input type="text" name = "reminderdateid" readonly="" value="" size="12" class="reminderdate2 form-control input-sm" disabled="true">
            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a>
            </div>
          </div>
          <input id="reminderid" type="hidden" class="form-control">
          <label style="margin-top:3px;">Enter Reminder Title: </label>
          <input id="reminder-title" type="text" class="input-sm form-control" placeholder="Reminder Title">
          <label style="margin-top:3px;">Reminder Details: </label>
          <textarea name="desc" id="reminder-desc" class="input-sm form-control" style="resize:none;"  rows="5" cols="50"></textarea>
      </div>
      </div>


      <div class="modal-footer">
      <button type="button" class="closeitemlookup btn btn-sm btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>