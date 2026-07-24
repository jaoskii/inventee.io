<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-pickorder" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closepickpo" data-dismiss="modal" aria-hidden="true">&times;</button>
        <?php  
                 switch ($module) { 
                    case 'RR':
                       echo '<h4 class="modal-title" id="myModalLabel">Pick PO</h4>'; 
                       break;
                    case 'SJ';
                       echo '<h4 class="modal-title" id="myModalLabel">Pick SO</h4>'; 
                       break;   
                     case 'DM':
                       echo '<h4 class="modal-title" id="myModalLabel">Pick RR</h4>'; 
                       break;   
                     case 'CM':
                       echo '<h4 class="modal-title" id="myModalLabel">Pick SJ</h4>'; 
                       break;   
                    case 'PO':
                       echo '<h4 class="modal-title" id="myModalLabel">Pick PR</h4>'; 
                       break; 
                    case 'TS':
                       echo '<h4 class="modal-title" id="myModalLabel">Pick TR</h4>'; 
                       break;        
                    case 'customer':
                       echo '<h4 class="modal-title" id="myModalLabel">Pending Orders</h4>'; 
                       break;                            
                 }   
        ?>
     
        <?php  
                 switch ($module) { 
                    case 'RR':
                       echo '<label>Search PO Items:</label>';
                       break;
                    case 'SJ';
                       echo '<label>Search SO Items:</label>';
                       break;   
                    case 'DM';
                       echo '<label>Search RR Items:</label>';
                       break;   
                    case 'CM';
                       echo '<label>Search SJ Items:</label>';
                       break; 
                    case 'PO';
                       echo '<label>Search PR Items:</label>';
                       break;
                    case 'TS';
                       echo '<label>Search TR Items:</label>';
                       break;      
                    case 'customer';
                       echo '<label>Search Pending Orders:</label>';
                       break;  

                 }   
         ?>


            <div class="row">
                  <div class = "col-md-3">
                    <select class="form-control input-sm pickup-po-format">
                      <option value="summary">Summarized Format</option>
                      <option value="detail">Detailed Format</option>
                    </select>
                  </div>

                  <div class = "col-md-9">
                  <div class="input-group">
                    <input value ="" type="text" class="txtorderitemslookup input-sm form-control">
                    <div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
            </div>
            </br>
         </div>

          <div class="modal-body">
          <div class ="table-pickpo-summarized box box-solid mod-tble">
          <table class="table tbl-fix">                             
            <thead>                        
              <tr>              
                <?php  
                 switch ($module) { 
                    case 'customer':
                       
                       break;
                   
                    default:
                       echo '<th class="col-min aimslabel">Pick</th>';
                       break;  

                 }   
                ?>
                <!-- <th class="col-codes aimslabel">Reference</th> -->
                <th class="col-codes aimslabel">Doc #</th>
                <th class="col-min aimslabel">Date</th>
                <th class="col-currency aimslabel">Amt</th>
                <?php  
                 switch ($module) { 
                    case 'SJ': case 'RR':
                       /*echo '<th class="col-min aimslabel">Void</th>';*/
                       break;  
                 }//end function
                ?>
              </tr>
              </tr>
            </thead>                                
            <tbody class="tbl-pickpo-summary">
            </tbody>
          </table>  
          </div>

          <div style="display: none;" class ="table-pickpo-detailed box box-solid mod-tble">
            <table class="table tbl-fix">                             
            <thead>
              <tr>
              <?php  
                 switch ($module) { 
                    case 'customer':
                       
                       break;
                   
                    default:
                       echo '<th class="col-min aimslabel">Add</th>';
                       break;  

                 }//end switch
              ?>
                
                <!-- <th class="col-codes aimslabel">Reference</th> -->
                <th class="col-codes aimslabel">Doc #</th>
                <th class="col-codes aimslabel">Barcode</th>                
                <th class="col-description aimslabel">Itemname</th>
                <th class="col-currency aimslabel">Amt</th>                
                <th class="col-min aimslabel">Discount</th>                               
                <th class="col-quantity aimslabel">Order</th>                
                <th class="col-quantity aimslabel">Pending</th>
                <th class="col-quantity aimslabel">Served</th>
                <th class="col-currency aimslabel">Ext</th>                
                <th class="col-codes aimslabel">WH</th>
              <?php  
               switch ($module) { 
                  case 'SJ': case 'RR': case 'SJ2':
                     echo '<th class="col-min aimslabel">Void</th>';
                     break;  
               }//end function
              ?>
              </tr>
            </thead>                                
            <tbody class="tbl-pickpo-detail">
            </tbody>
            </table>   
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="theorderbutton btn btn-flat btn-success">Retrieve Orders</button>
        <button type="button" data-dismiss="modal" class="btn btn-flat btn-success">Close</button>
      </div>

    </div>
  </div>
</div>