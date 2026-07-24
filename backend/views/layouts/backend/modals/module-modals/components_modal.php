<!-- MODAL FOR COMPONENT LOOK UP -->
<div class="modal fade" id="components_lookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Components</h4>
      </div>
      <div class="modal-body" style='height:450px;'>
          <label>Search Component:</label>
          <div class="input-group">
            <input value ="" type="text" class="txtsearchcomponents input-sm form-control"><div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>
          </div>
          </br>
          <div class="components_content">
            
          </div>
      </div>

      <div class="modal-footer">
        <button class='btn btn-flat btn-success btnaddcomponentitem'>Add Component</button>
        <button class=" btn btn-flat btn-danger" onClick="$('#components_lookup').modal('hide');">Cancel</button>
      </div>
    </div>
  </div>
</div>


  <!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="components_item_lookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Items Lookup</h4>
      </div>
      <div class="modal-body" style='height:450px;'>
          <label>Search Item:</label>
          <div class="input-group">
            <input value ="" type="text" class="txtsearchcompitem input-sm form-control"><div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>
          </div>
          </br>
          <div class="components_item_content">
            
          </div>
      </div>

      <div class="modal-footer">
        <button class=" btn btn-flat btn-danger" onClick="$('#components_item_lookup').modal('hide');">Cancel</button>
      </div>
    </div>
  </div>
</div>



<!-- MODAL FOR ITEM SELECT EDIT LOOK UP -->
<div class="modal fade" id="components_item_add_lookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Add Component</h4>
      </div>
      <div class="modal-body" style='height:250px;'>
        <div class="col-md-12">
          <input type="hidden" id="compitemid">
          <input type="hidden" id="compsavingtype">
          <div class="row">
            <div class="col-md-3"><h5>Barcode</h5></div>
            <div class="col-md-9"><input type="text" disabled class="form-control txtcompbarcode"></div>
          </div>
          <div class="row" style='margin-top:5px;'>
            <div class="col-md-3"><h5>Item Name</h5></div>
            <div class="col-md-9"><input type="text" disabled class="form-control txtcompitemname"></div>
          </div>
          <div class="row" style='margin-top:5px;'>
            <div class="col-md-3"><h5>QTY</h5></div>
            <div class="col-md-9"><input type="text" class="form-control txtcompitemqty"></div>
          </div>
          <div class="row" style='margin-top:5px;'>
            <div class="col-md-3"><h5>UOM</h5></div>
            <div class="col-md-9">
              <select class='form-control txtcompitemuom'>
                <!-- <option value=""></option> -->
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-flat btn-success btnsavecompitem">Save</button>
        <button class=" btn btn-flat btn-danger" onClick="$('#components_item_add_lookup').modal('hide');">Cancel</button>
      </div>
    </div>
  </div>
</div>