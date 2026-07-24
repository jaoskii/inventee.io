<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-multiplevoid" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closepickpo" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Void Multiple Orders</h4>
      </div>
      <div class="modal-body">
            <label>Search Items on this Document:</label>
            <div class="row">
                  <div class = "col-md-12">
                  <div class="input-group">
                    <input value ="" type="text" class="txtmultiplevoidsearch input-sm form-control">
                    <div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
            </div>
            </br>
              <div class ="box box-solid mod-tble">
                <table class="table-multiplevoid table tbl-fix table-hover">                             
                    <thead>                        
                      <tr>
                        <th class="col-min aimslabel">Options</th>
                        <th class="col-codes aimslabel">Barcode</th>
                        <th class="col-description aimslabel">Itemname</th>
                        <th class="col-min aimslabel">UOM</th>
                        <th class="col-quantity aimslabel">Qty</th>
                        <th class="col-quantity aimslabel">Served</th>
                      </tr>
                    </thead>                                
                    
                    <tbody class="tbl-multiplevoid">
                    </tbody>
                </table>  
              </div>
      </div>

      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-flat btn-success">Close</button>
        <button type="button" class="thevoidtaker btn btn-flat btn-success">Void Selected Items</button>
      </div>

    </div>
  </div>
</div>