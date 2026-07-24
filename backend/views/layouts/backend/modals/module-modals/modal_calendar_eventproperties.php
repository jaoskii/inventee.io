<!-- MODAL FOR CALENDAR-->
<div class="modal fade" id="modal-calendar-eventprop" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Event Properties</h4>
      </div>

      <div class="modal-body">

      <input type ="hidden" id="sched_seq" value="">
      <input type ="hidden" id="prop_eventid" value="">
      <input type ="hidden" id="prop_keyid" value="">
      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">Title: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-title"></label>
      </div>

      <div class="col-md-2">
      <label class="aimslabel">Createdate: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-createdate"></label>
      </div>

      </div>

      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">Creator: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-creater"></label>
      </div>

      <div class="col-md-2">
      <label class="aimslabel">Username: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-username"></label>
      </div>
      </div>

      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">Customer: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-schedulefor"></label>
      </div>

      <div class="col-md-2">
      <label class="aimslabel">Scheduled: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-scheduled"></label>
      </div>
      </div>

      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">Time: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-time"></label>
      </div>

      <div class="col-md-2">
      <label class="aimslabel">Location: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-loc"></label>
      </div>
      </div>


      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">Status: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-status"></label>
      </div>

      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">JO #: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel eventprop-jo"></label>
      </div>
      </div>

      </div>

      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">Notes: </label>
      </div>
      <div class="col-md-4">
      <label class="aimslabel"><a class="clickable btncalendar-viewnotes2"></a></label>
      </div>
      </div>

      <div class="row">
      <div class="col-md-2">
      <label class="aimslabel">Comments: </label>
      </div>
      <div class="col-md-4">
      <label><a class="aimslabel eventprop-comments" href="#"></a></label>
      </div>
      </div>

      <label class="aimslabel">Add Comment: </label>
      <textarea class="aimslabel eventprop-txtcomment form-control" style="height:150px;resize:none;" row=30></textarea>
      </div>


      <div class="modal-footer">
      <button type="button" class="eventprop-addcomment btn btn-sm btn-flat btn-success">Add Comment</button>
      <button type="button" class="closeitemlookup btn btn-sm btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>