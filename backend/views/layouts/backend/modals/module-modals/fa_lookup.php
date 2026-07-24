<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-itemlookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closecustomerlookup" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Item Lookup</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="item-lookuptype">
        <label>Search Item:</label>
        <div class="input-group">
          <input value ="" type="text" class="txtsearchitem input-sm form-control"><div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>
        </div>
        </br>
            <div class ="box box-solid mod-tble">
              <table class="table-lookupitem table tbl-fix">                             
              <thead>
                <tr>
                  <th class="col-min aimslabel">Options</th>
                  <th class="col-codes aimslabel">Barcode</th>
                  <th class="col-description aimslabel">Itemname</th>
                  <th class="col-med aimslabel">Group</th>
                  <th class="col-med aimslabel">Sub group</th>
                  <th class="col-currency aimslabel">Amount</th>
                </tr>
              </thead>                                
              <tbody class="tbl-itemlookup">
              </tbody>
              </table> 
            </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">OK</button>
      </div>

    </div>
  </div>
</div>