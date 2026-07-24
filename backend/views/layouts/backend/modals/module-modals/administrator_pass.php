<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-adminpass" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceladminpass" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Administrator Password</h4>
      </div>

      <div class="modal-body">
      <?php
        switch ($moduleid) {
          case 'SO': case 'PO': case 'SJ': case 'RR':
            echo '<input type="hidden" class="form-control txtadministrator-line"/>';
            echo '<input type="hidden" class="form-control txtadministrator-trno"/>';
            echo '<input type="hidden" class="form-control txtadministrator-void"/>';
            echo '<input type="hidden" class="form-control txtadministrator-voidstyle"/>';
          break;
        }//end fucntion
      ?>
      <label>Select User:</label>
      <select class="form-control pincode-userlist input-sm"></select>
      </br>
      <label>Input Administrator Password</label>
      <input type="password" class="form-control txtadministrator-pin"/>
      </div>

      <div class="modal-footer">
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>