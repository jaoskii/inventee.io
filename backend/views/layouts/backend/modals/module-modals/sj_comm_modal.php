<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-sj_comm" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closecustomerlookup" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4 class="modal-title" id="myModalLabel">Commission</h4>
       
      </div>
      <div class="modal-body">
        <label style="margin-top:3px;">Cutoff Date: </label>
        <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d'); ?>"  class="paedit input-group date dpYears">
          <input type="text" name = "cutoffdate" readonly="" value="<?php date('Y-m-d'); ?>" size="12" class="commcutoff form-control input-sm" disabled="true">
          <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
        </div>
        <label style="margin-top:3px;">Base Amount: </label>
        <input name = "commgrandtotal" type="hidden" class="sjcommform commgrandtotal input-sm form-control">
        <input name = "commbaseamt" type="text" id="#commbaseamt" class="commbaseamt input-sm form-control">

        
        <label style="margin-top:3px;">Standard Commission: </label>
        <div class="row">
        <div class="col-md-5"><input name="commstandardcomm" ="text" class="sjcommform commstandardcomm input-sm form-control">
        </div>
        <div class="col-md-1">
        <label>%</label>
        </div>

        <div class="col-md-1">
        <label>P</label>
        </div>
        <div class="col-md-5"><input readonly name="commstandardamt" ="text" class="commstandardamt sjcommform input-sm form-control">
        </div>
        </div>

        <label style="margin-top:3px;">Developer / Agent: </label>          
        <div class="input-group">
        <input name = "commagentcode" readonly="" value ="" type="text" class="sjcommform commagent input-sm form-control" disabled="true"><div class="frmdocumentno input-group-addon"><a class ="commagentlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
        </div>
        
        <label style="margin-top:3px;">Share Commission: </label>
        <div class="row">
        <div class="col-md-5"><input name="commsharecomm" ="text" class="sjcommform commsharecomm input-sm form-control">
        </div>
        <div class="col-md-1">
        <label>%</label>
        </div>

        <div class="col-md-1">
        <label>P</label>
        </div>
        <div class="col-md-5"><input readonly="" name="commshareamt" ="text" class="sjcommform commshareamt input-sm form-control">
        </div>
        </div>
      </div>

      <div class="modal-footer">
          <button id="add-new-sjcomm" type="button" class="btn btn-github btn-flat">Add to Commission</button>
          <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>