<!-- MODAL FOR lockdate-->
<div class="modal fade" id="modal-lockdate" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Set up Lockdate</h4>
      </div>

      <div class="modal-body">
      <h6 class="aimslabel dateidlookup"><b>Date: <div id = "lockdatelookup" data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
        <input type="text" name = "dateid" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['dateid'];}?>" size="12" class="txtbackdate form-control input-sm" disabled="true">
        <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
      </div></b></h6>
    </div>


    <div class="modal-footer">
      <button type="button" class="btnupdatelockdate btn btn-flat btn-success">Update</button>
      <button type="button" class="closeitemlookup btn btn-flat btn-github" data-dismiss="modal">Close</button>
    </div>

    </div>
  </div>
</div>