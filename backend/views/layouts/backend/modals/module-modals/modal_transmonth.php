
<!-- MODAL FOR DOCUMENT LOOK UP -->
<div class="modal fade" id="modal-transmonth" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceldocument" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo "Transactions for the month of ".date('F');?></h4>
      </div>
      
      <div class="modal-body">
        <div class="box-body box-solid box-success">
          <div class="pull-left">
            <b>
              <h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">List of Documents</h6>
            </b>
            <div style="width: 270px;" class="transdiv1"></div>
          </div>
          <div class="pull-left">
            <b>
              <h6 style="display:inline;margin-right:30px;font-size:12px;font-weight:bold;">Transactions</h6>
            </b>
            <div style="width: 570px;" class="transdiv2"></div>
          </div> 
        </div>
      </div>

      <div class="modal-footer">
            <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>









