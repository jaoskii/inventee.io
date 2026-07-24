<!-- MODAL FOR MODULE LOGS -->
<div class="modal fade" id="modal-notecomment" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Note Comments</h4>
      </div>

      <div class="modal-body">

        <div class="row">
          <div class="col-md-12">
            <input type="hidden" name="notecommentid" id="notecommentid">
            <div class="col-md-5">
            <label>Note: </label>
            <h5 class="notecomment-notebody"></h5> 
            <label>Tagged to Project: </label>
            <h5 class="notecomment-projectname"></h5>
            <br>
            <label>Enter Comment: </label>
            <textarea class="txtnotecomment form-control" rows = "9" style="resize:none;"></textarea>
            <button class="btn-xs form-control btn btn-flat btn-success noteaddcomment">Add Comment</button>
            </div>

            <!-- ADDING PROJECT FORM -->
            <div class="col-md-7">
              <label class="aimslabel">Comments</label>
              <div class="scroll-large">
              <div class='box-footer box-comments notecommentview'>
              </div>
              </div><!-- /.box-footer -->
            </div> <!-- END COL MD 9 -->

          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>