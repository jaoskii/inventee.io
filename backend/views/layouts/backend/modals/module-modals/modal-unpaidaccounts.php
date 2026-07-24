<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-pickunpaid" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closepickpo" data-dismiss="modal" aria-hidden="true">&times;</button>

        <?php
          switch ($module) {
            case 'customer': case 'supplier': case 'KL':
              echo '<h4 class="modal-title" id="myModalLabel">Floating Balances</h4>';
            break;
                            
            default:
              echo '<h4 class="modal-title" id="myModalLabel">Pick Unpaid</h4>';
            break;
          }
        ?>
      </div>
      <div class="modal-body">
            <label>Unpaid Accounts:</label>
            <div class="row">
                  <div class = "col-md-12">
                  <div class="input-group">
                    <input value ="" type="text" class="txtunpaidsearchlookup input-sm form-control">
                    <div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
            </div>
            </br>
              <div class ="box box-solid mod-tble">
                <table class="table-unpaid table tbl-fix table-hover">                             
                    <thead>                        
                      <tr>
                        <?php
                        switch ($module) {
                          case 'customer': case 'supplier':
                            echo '<th style="display:none;" class="col-min aimslabel">Options</th>';
                            break;
                          
                          default:
                            echo '<th class="col-min aimslabel">Options</th>';
                            break;
                        }
                        ?>

                        <th class="col-min aimslabel">Date</th>
                        <th class="col-codes aimslabel">Doc #</th>
                        <th class="col-description aimslabel">Account Name</th>
                        <th class="col-currency aimslabel">AR</th>
                        <th class="col-currency aimslabel">AP</th>
                        <th class="col-currency aimslabel">Amt Due</th>
                        <th class="col-codes aimslabel">Ref</th>
                      </tr>
                    </thead>                                
                    
                    <tbody class="tbl-unpaid">
                    </tbody>
                </table>  
              </div>
      </div>

      <div class="modal-footer">
        <?php
          switch ($module) {
            case 'customer': case 'supplier': case 'KL':
              echo '<button type="button" data-dismiss="modal" class="btn btn-flat btn-success">Close</button>';
            break;
                            
            default:
              echo '<button type="button" class="theunpaidtaker btn btn-flat btn-success">Retrieve</button>';
            break;
          }
        ?>
      </div>

    </div>
  </div>
</div>