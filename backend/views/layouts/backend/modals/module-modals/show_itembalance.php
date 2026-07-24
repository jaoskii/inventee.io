<!-- MODAL FOR SHOW BALANCE-->
<div class="modal fade" id="modal-showbalance" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Item Balance</h4>
      </div>

      <div class="modal-body mod-tble">
      <table class="showbalance table table tbl-fix table-hover">
        <thead>
            <tr>
                <th class="col-codes aimslabel"><span class="text">Warehouse</span></th>
                <th class="col-codes aimslabel"><span class="text">Location</span></th>
                <th class="col-codes aimslabel"><span class="text">Expiration</span></th>
                <th class="col-quantity aimslabel"><span class="text">Balance</span></th>
            </tr>
        </thead>
        
        <tbody class="tbl-showbalance">

        </tbody>
      </table>
      </div>
      <div class="col-md-12">
      <h6 class="showbalance-totalitembal" style="font-weight:bold;text-align: right;">TOTAL ITEM BALANCE: 0.00 </h6>
      </div>
      <div class="col-md-6">
          <h6 class="unpostedpobal" style="font-weight:bold;">UNPOSTED PO:</h6>
          <h6 class="postedpobal" style="font-weight:bold;">POSTED PO:</h6>
      </div>
      <div class="col-md-6">
          <h6 class="unpostedsobal" style="font-weight:bold;text-align: right;">UNPOSTED SO:</h6>
          <h6 class="postedsobal" style="font-weight:bold;text-align: right;">POSTED SO:</h6>
      </div>

      <div class="modal-footer">
      <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>