<!-- MODAL FOR WAREHOUSE -->
<div class="modal fade" id="modal-loclookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Choose Location</h4>
      </div>
      <input type="hidden" value ="" class="loctypelookup"></input>
      <div class="modal-body">
        <div class ="box box-solid mod-tble">
            <table class="table-location table tbl-fix">                             
            <thead>
              <tr>
                <th class="col-min aimslabel">Option</th>
                <th class="col-codes aimslabel">WH Code</th>
                <th class="col-description aimslabel">WH Name</th>
                <th class="col-codes aimslabel">Location</th>
                <th class="col-codes aimslabel">Expiry </th>
                <th class="col-quantity aimslabel">Balance</th>
              </tr>
            </thead>                                
            <tbody class="tbl-location">
            </tbody>
            </table>  
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>