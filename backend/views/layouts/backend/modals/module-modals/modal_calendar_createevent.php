<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-calendar_createevent" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closecustomerlookup" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title" id="myModalLabel">Create Event</h4>
       
      </div>
      <div class="modal-body">
        <label style="margin-top:3px;">Enter Schedule Desc: </label>
        <input id="event-type" type="hidden" class="form-control">
        <input id="new-event" type="text" class="input-sm form-control" placeholder="Event Title">
        <label style="margin-top:3px;">Select Customer: </label>
        <div class="input-group">
          <input readonly="true" name = "client" value ="" type="text" class="calendarclientcode1 input-sm form-control">
          <div class="frmdocumentno input-group-addon">
          <a class ="calendarclientlookup1" href="#"><i class="fa fa-chevron-circle-down" ></i></a>
          </div>
        </div>
        <label style="margin-top:3px;">Time: </label>
        <div class="bootstrap-timepicker">
          <div class="form-group">
              <div class="input-group">
                    <input type = "text" class="event-txttime input-sm form-control timepicker" name="starttime" value="00:00" id="txttime">
                  <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                  </div>
              </div><!-- /.input group -->
          </div><!-- /.form group -->
        </div>
        <label style="margin-top:3px;">Tag to project: </label>
        <div class="input-group">
          <input type="hidden" id = "projectidtag" value= "">
          <input readonly="true" name = "projectnametag" value ="" type="text" class="projectnametag input-sm form-control">
          <div class="frmdocumentno input-group-addon">
          <a class ="projectlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a>
          </div>
        </div>
        <label style="margin-top:3px;">Location: </label>
        <input id="event-loc" type="text" class="input-sm form-control">
        <label style="margin-top:3px;">JO #: </label>
        <input id="event-jo" type="text" class="input-sm form-control">
        <textarea style = "display:none;" name="rem" id="event-rem" class="input-sm form-control" style="resize:none;"  rows="2" cols="50"></textarea>
      </div>
      <div class="modal-footer">
          <button id="add-new-event" type="button" class="btn btn-github btn-flat">Add Event</button>
          <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>