<!-- MODAL FOR WAREHOUSE -->
<div class="modal fade" id="modal-whlookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Choose Warehouse</h4>
      </div>

      <div class="modal-body">
        <label>Search Warehouse:</label>
        <input type="hidden" id="whlookuptype" value=""></input>
        <input type="hidden" id="whlookupline" value=""></input>
        <div class="input-group">
          <input value ="" type="text" class="txtsearchwh input-sm form-control"><div class="frmwhlookup input-group-addon"><i class="fa fa-search"></i></div>
        </div>
        </br>
        <div class="box box-solid mod-tble">
            <table class="table-whlookup table tbl-fix">                             
            <thead>
              <tr>
                <th class="col-min aimslabel">Option</th>
                <th class="col-codes aimslabel">WH Code</th>
                <th class="col-description aimslabel">Warehouse Name</th>
                <th class="col-description aimslabel">Address</th>
                <th class="col-codes aimslabel">Tel #</th>
              </tr>
            </thead>                                
            <tbody class="tbl-whlookup">
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