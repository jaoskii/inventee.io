<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-generalitemlookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closecustomerlookup" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">General Item Lookup</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="item-lookuptype">
        <label>Search Item:</label>
        <div class="input-group">
          <input value ="" type="text" class="txtsearchgenitem input-sm form-control"><div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>
        </div>
        </br>
            <div class ="box box-solid mod-tble">
              <table class="table-lookupgenitem table tbl-fix">                             
              <thead>
                <tr>
                  <th class="col-min aimslabel">Select</th>
                  <th class="col-codes aimslabel">Barcode</th>
                  <th class="col-description aimslabel">Itemname</th>
                  <th class="col-description aimslabel">Brand</th>
                  <th class="col-description aimslabel">Group</th>
                  <th class="col-description aimslabel">Color</th>
                  <th class="col-description aimslabel">Model</th>
                  <th class="col-description aimslabel">Classification</th>
                  <th class="col-description aimslabel">Size</th>
                </tr>
              </thead>                                
              <tbody class="tbl-itemgenlookup">
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