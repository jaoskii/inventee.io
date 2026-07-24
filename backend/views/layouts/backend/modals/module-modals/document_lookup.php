<!-- MODAL FOR DOCUMENT LOOK UP -->
<div class="modal fade" id="modal-docnolookup" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceldocument" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Document Lookup</h4>
      </div>
      

      <div class="modal-body">
          <label>Search Document:</label>
          <div class="input-group">
            <input value ="" type="hidden" id="doclookuptype"/>
            <input value ="" type="text" class="txtsearchdocno input-sm form-control"><div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>
          </div>
          </br>

           <div class="box box-solid mod-tble">
            <table class="table tbl-fix table-hover">                           
            <thead>
            <tr>
              <th class="col-min aimslabel">View</th>
              <th class="col-description aimslabel">Date</th>
              <th class="col-description aimslabel">Document #</th>
              <?php  
                 switch ($module) { 
                    case 'PO': case 'RR': case 'DM':
                        echo '<th class="doclookuptitle col-description aimslabel">Supplier</th>';                    
                      break;

                    case 'PI':
                        echo '<th class="doclookuptitle col-description aimslabel">Itemname</th>';                    
                      break;

                    default:
                        echo '<th class="doclookuptitle col-description aimslabel">Customer</th>';
                      break;
                 }
                 ?>              
              <th class="col-codes aimslabel">Yourref</th>
              <th class="col-codes aimslabel">Ourref</th>
              <th class="col-description aimslabel">Postdate</th>
              <th class="col-description aimslabel">Posted by</th>
            </tr>
           </thead>                      

            <tbody class="tbl-modalsearch">
            </tbody>
            </table>  
          </div>
      </div>

          
      <div class="modal-footer">
            <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>



