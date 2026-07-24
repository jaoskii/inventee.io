<!-- MODAL FOR CALENDAR-->
<div class="modal fade" id="modal-calendar-updateevent" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Event</h4>
      </div>

      <div class="modal-body">
      <input type ="hidden" id="sched_seq" value="">
      <label class="calendar-title">Title: </label>
      <label class="eventupdate-titleview"></label>
      <input type="hidden" class="eventupdate-title input-sm form-control">
      
      <br>
      <label style="margin-top:3px;">Select Customer: </label>
      <div class="input-group">
        <input readonly="true" name = "client" value ="" type="text" class="calendarclientcode2 input-sm form-control">
        <div class="frmdocumentno input-group-addon"><a class ="calendarclientlookup2" href="#">
        <i class="fa fa-chevron-circle-down" ></i></a>
        </div>
      </div>

      <label style="margin-top:3px;">Time: </label>
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <div class="input-group">
                              <input type = "text" class="eventupdate-time input-sm form-control timepicker" name="starttime" value="00:00" id="txttime">
                            <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                            </div>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  </div>
      <label style="margin-top:3px;">Location: </label>
      <input type="text" class="eventupdate-loc input-sm form-control">

      <br>
      <label>Tag Schedule as: </label>
      <select class="schedtagging input-sm form-control">
      </select>

      <br>
      <label style="margin-top:3px;">Tag to project: </label>
        <div class="input-group">
          <input type="hidden" id = "projectidtagupdate" value= "">
          <input readonly="true" name = "projectnametag" value ="" type="text" class="projectnametagupdate input-sm form-control">
          <div class="frmdocumentno input-group-addon">
          <a class ="projectlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a>
          </div>
        </div>
      <br>
      <label style="margin-top:3px;">JO #: </label>
      <input id="eventupdate-jo" type="text" class="input-sm form-control eventupdate-jo">
      <br>
      <label>Notes: </label></br>
      <a class="clickable btncalendar-viewnotes"></a>
      <br>
      </div>

      <div class="modal-footer">
      <button type="button" class="event-updatebtn btn btn-flat btn-success">Update</button>
      <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>