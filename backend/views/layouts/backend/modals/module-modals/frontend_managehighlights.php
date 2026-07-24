<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-frontendmanagehighlights" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceladminpass" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="myModalLabel">Manage Highlights</h5>
      </div>

      <div class="modal-body">
      
      <div class="row">.
      <div class="col-md-12">
        <div class = "col-md-3">
            <button class="higheditinfobtn btn btn-flat btn-success btn-xs"><i class="fa fa-pencil"></i> Edit Highlight Info</button>
            <button style="display: none;" class="highupdateinfobtn btn btn-flat btn-primary btn-xs"><i class="fa fa-save"></i> Save Highlight Info</button>
            <button style="display: none;" class="highcancelinfobtn btn btn-flat btn-github btn-xs"><i class="fa fa-times"></i> Cancel</button>
        </div>
        <div class = "col-md-9">
        <div class="pull-right">
        <button class="highlightsadditembtn btn btn-flat btn-success btn-xs"><i class="fa fa-plus"></i> Add Item</button>
        <button class="highlightsdeleteselectedbtn btn btn-flat btn-danger btn-xs"><i class="fa fa-trash"></i> Delete Selected Items</button>
        </div>
        </div>
      </div>
      </div>

      <div class="row">.
      <div class="col-md-12">
          <div class = "col-md-3">
            <h6 class="aimslabel"><b>Highlight Description: <input name="highlightdesc" value ="" type="text" class="fhform fhtxthighlightdessc form-control input-sm" disabled="true"></b></h6>
            <h6 class="aimslabel dateidlookup"><b>Promo Start Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                      <input type="text" name="promomstart" readonly="" value="" size="12" class="fhtxtpromostart form-control input-sm" disabled="true">
                      <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                    </div></b></h6>
            <h6 class="aimslabel dateidlookup"><b>Promo End Date: <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                      <input type="text" name = "promoend" readonly="" value="" size="12" class="fhtxtpromoend form-control input-sm" disabled="true">
                      <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                    </div></b></h6>
            <h6 class="aimslabel"><b>Discount: <input name="discount" value ="" type="text" class="fhform fhtxtdiscount form-control input-sm" disabled="true"></b></h6>
          </div>
          <div class = "col-md-9">
            <div class ="box box-solid mod-tble">
              <table class="table-itemhighlights tbl-fix table table-hover">                             
              <thead>
                <tr>
                  <th class="col-checkbox aimslabel">&nbsp</th>
                  <th class="col-codes aimslabel">Barcode</th>
                  <th class="col-description aimslabel">Itemname</th>
                  <th class="col-currency aimslabel">Amount</th>
                  <th class="col-quantity aimslabel">H.Price</th>
                  <th class="col-quantity aimslabel">Available</th>
                </tr>
              </thead>                                
              <tbody class="tbl-itemhighlights">
              </tbody>
              </table> 
            </div> 
          </div>
      </div>
      </div>
      </div>

      <div class="modal-footer">
        <button type="button" class=" btn btn-flat btn-github" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>