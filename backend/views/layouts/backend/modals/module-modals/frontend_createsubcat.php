<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-frontendaddsubcat" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceladminpass" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add new Subcategory</h4>
      </div>

      <div class="modal-body">
      <input type="hidden" id="subcatparentid" class="form-control"/>    
      <input type="hidden" id="subcatparenttype" class="form-control"/>    
      <input type="text" class="form-control txtnewsubcat"/>    
      <br>
      <input style="margin-left:7px;margin-top:6px;" class ="subcat_enable" type="checkbox">
      <label><small>Enabled</small></label>
      </div>

      <div class="modal-footer">
        <button type="button" class="btnsavesubcat btn btn-flat btn-success" data-dismiss="modal">Save</button>
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>