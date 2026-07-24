<!-- MODAL FOR CALENDAR-->
<div class="modal fade" id="modal-calendar-notes" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Event</h4>
      </div>

      <div class="modal-body">
          <div class="row">
          <div class="col-md-12 noteediting">

            <div class="col-md-5">
            <div class="addnotearea">
            <label class="aimslabel">Notes: </label>
            <textarea class="aimslabel event-txtnotes form-control" style="height:350px;resize:none;" row=30></textarea>
            </div></br>
            <button type="button" class="event-addnotebtn btn btn-sm btn-flat btn-success pull-right"><i class="fa fa-plus"></i> Add Note</button>
            </div>


            <div class="col-md-7">
            <label class="aimslabel">Notes List: </label>
            <div class="scroll-large">
            <div class='box-footer box-comments viewnotearea'>
            </div>
            </div><!-- /.box-footer -->
            </div>

          </div>

          <div class="col-md-12 noteviewing">
            <label class="aimslabel">Notes List: </label>
            <div class="scroll-large">
            <div class='box-footer box-comments noteviewingdiv'>
            </div>
            </div><!-- /.box-footer -->
          </div>

          </div>
      </div>

      <div class="modal-footer">
      <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>