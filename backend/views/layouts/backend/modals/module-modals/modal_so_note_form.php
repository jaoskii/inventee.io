<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-so-note-form" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closecustomerlookup" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title" id="myModalLabel">Add SO Notes</h4>
       
      </div>
      <div class="modal-body">
        <label style="margin-top:3px;">Station: </label>
        <input name = "sonotestation" type="text" class="sonoteform input-sm form-control">

        <label style="margin-top:3px;">Serial #: </label>
        <input name="sonoteserial" ="text" class="sonoteform input-sm form-control">

        <label style="margin-top:3px;">Remarks: </label>
        <input name="sonoteremarks" type="text" class="sonoteform input-sm form-control">

        <label style="margin-top:3px;">Others: </label>
        <input name="sonoteothers" type="text" class="sonoteform input-sm form-control">
      </div>

      <div class="modal-footer">
          <button id="add-new-sonote" type="button" class="btn btn-github btn-flat">Add Note</button>
          <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>