<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-clientwhlookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     
      <div class="modal-header">
        <button type="button" class="close btncancelwarehouseclient" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Warehouse Lookup</h4>
      </div>

      <div class="modal-body">
          <label>Search Warehouse:</label>
          <div class="input-group">
            <input type="hidden" id="whlookuptype" value=""></input>
            <input value ="" type="text" class="txtsearchwarehouseclient input-sm form-control"><div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>
          </div>
          </br>
            <table class="table-clookup table tableSection table-fixed table-lookup table-hover">                             
            
            <thead>
              <tr>
                <th class="col-xs-1 aimslabel">View</th>
                <th class="col-xs-2 aimslabel">Warehouse Code</th>
                <th class="col-xs-4 aimslabel">Warehouse Name</th>
                <th class="col-xs-3 aimslabel">Address</th>
                <th class="col-xs-2 aimslabel">Tel #</th>
              </tr>
            </thead>                       

            <tbody class="tbl-clientwhlookup">
            </tbody>
            </table>  
      </div>

      <div class="modal-footer">
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>