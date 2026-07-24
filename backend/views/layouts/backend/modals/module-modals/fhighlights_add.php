<div class="modal fade" id="modal-addnewhighlight" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Add new Highlight</h5>
      </div>

      <div class="modal-body">
      <label class="aimslabel">Enter Highlight Description</label>
      <input type="text" class="input-sm form-control txtnewhighlight" id="txtnewhighlight">
      <h6 class="aimslabel dateidlookup"><b>Promo Start Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                      <input type="text" name="promomstart" readonly="" value="" size="12" class="fhnewpromostart form-control input-sm" disabled="true">
                      <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                    </div></b></h6>
      <h6 class="aimslabel dateidlookup"><b>Promo End Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                <input type="text" name = "promoend" readonly="" value="" size="12" class="fhnewpromoend form-control input-sm" disabled="true">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
              </div></b></h6>
      <h6 class="aimslabel"><b>Discount: <input name="discount" value ="" type="text" class="fhnewdiscount form-control input-sm"></b></h6>
      </div>

      <div class="modal-footer">
      <button type="button" class="fhighlightsave btn btn-flat btn-success">Save</button>
      <button type="button" class="closeitemlookup btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>  
  </div>
</div>
