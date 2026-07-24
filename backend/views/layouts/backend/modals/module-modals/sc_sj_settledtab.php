<!-- MODAL FOR SJ RECEIVE TAB-->
<div class="modal fade" id="modal-sc-settletab" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Settled Tab (XANDA)</h4>
      </div>


      <div class="modal-body">
          <h6 class="aimslabel"><b>Settled Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
            <input type="text" name = "settleddateid" readonly="" value="" size="12" class="sjtabtxt txtsettleddateid form-control input-sm" disabled="true">
            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
          </div></b></h6>

          <h6 class="aimslabel"><b>Notes: <textarea name="rem" class="sjtabtxt txtsettlednotes form-control" style="resize:none;" rows="2" cols="50"></textarea></b></h6>
      </div>

      <div class="modal-footer">
      <button tabmodal="modal-sc-settletab" type="button" class="btn btn-sm btn-flat btn-success scupdatesettledtab">Update</button>
      <button type="button" class="btn-sm closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>