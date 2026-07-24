<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-pricehistory" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closecustomerlookup" data-dismiss="modal" aria-hidden="true">&times;</button>
        <?php
          switch($module){
              case 'SJ':
                echo '<h4 class="modal-title" id="myModalLabel">Customer Price History</h4>';
              break;

              case 'RR':
                echo '<h4 class="modal-title" id="myModalLabel">Supplier Price History</h4>';
              break;
          }//end switch case
        ?>        
      </div>
      <div class="modal-body">
            <div class ="box box-solid mod-tble">
              <table class="table-pricehistory table tbl-fix table-hover">                             
              <thead>
                <tr>
                  <th class="col-min aimslabel">Date</th>
                  <th class="col-currency aimslabel">Amount</th>
                  <th class="col-quantity aimslabel">Quantity</th>
                  <th class="col-quantity aimslabel">Disc</th>
                  <th class="col-currency aimslabel">Extension</th>
                  <th class="col-codes aimslabel">Doc</th>
                  <th class="col-description aimslabel">Name</th>
                  <th class="col-codes aimslabel">Location</th>
                  <th class="col-codes aimslabel">Expiry</th>
                </tr>
              </thead>                                
              <tbody class="tbl-pricehistory">
              </tbody>
              </table> 
            </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>