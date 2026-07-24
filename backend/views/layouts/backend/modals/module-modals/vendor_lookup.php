<!-- MODAL FOR SUPPLIER LOOK UP -->
<div class="modal fade" id="modal-vendorlookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncancelvendor" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Vendor Lookup</h4>
      </div>
      <div class="modal-body">
          <label>Search Vendor:</label>
          <input type ="hidden" class="clientlookuptype">
          <div class="input-group">
            <input value ="" type="text" class="txtsearchvendor input-sm form-control"><div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>
          </div>
          </br>

          <div class="box box-solid mod-tble">
            <table class="table-vendorlookup table tbl-fix table-hover">                             
            <thead>
              <tr>
                <th class="col-min aimslabel">View</th>
                <th class="col-codes aimslabel">Vendor Code</th>
                <th class="col-description aimslabel">Vendor Name</th>
                <th class="col-description aimslabel">Address</th>
                <th class="col-description aimslabel">Contact Person</th>
                <th class="col-codes aimslabel">Tel #</th>
              </tr>
            </thead>                               
            <tbody class="tbl-vendorlookup">
            </tbody>
            </table>  
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>