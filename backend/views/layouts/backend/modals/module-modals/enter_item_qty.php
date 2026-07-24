<!-- MODAL FOR ITEM QTY-->
<div class="modal fade" id="modal-enterqty" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Enter Qty</h4>
      </div>

      <div class="modal-body">

      <div class="row">
        <div class="col-md-4"><h6><b>Barcode:</b></h6></div>
        <div class="col-md-8"><h6 class="qtybarcode"></h6></div>
        <div class="col-md-4"><h6><b>Itemname:</b></h6></div>
        <div class="col-md-8"><h6 class="qtyitemname"></h6></div>
      
        <div class="col-md-4"><h6><b>Qty:</b></h6></div>
        <div class="col-md-8"><input class="enteredqty input-sm form-control" type="text">
        <input value="" class="qtyitemid form-control" type="hidden">
        <input value="" class="qtyeditid form-control" type="hidden">
        </div>

      </div> <!-- END ROW -->

      <div class="row qtyitemamtrow">
        <div class="col-md-4"><h6><b>Amount:</b></h6></div>
        <div class="col-md-8">
        <input class="qtyitemamt input-sm form-control" type="text">
        <input class="qtyitemcost input-sm form-control" type="hidden">
        </div>

      </div> <!-- END ROW -->

      <div class="row discountrow">
        <div class="col-md-4"><h6><b>Discount:</b></h6></div>
        <div class="col-md-8"><input class="qtydisc input-sm form-control" type="text"></div>
      </div> <!-- END ROW -->

      <div class="row itemqtywh">
        <div class="col-md-4"><h6><b>Warehouse:</b></h6></div>
        <div class="col-md-8">        
        <div class="input-group">
        <input disabled="true" value ="" type="text" class="txtwarehouseitem form-control input-sm">
        <div class="frmwh input-group-addon"><a class ="whlookupitem" href="#modal-whlookup" data-toggle="modal"><i class="fa fa-chevron-circle-down"></i></a></div>
        </div>
        </div>  
      </div><!-- END ROW -->

      <div class="row location-qtydisplay">
        <div class="col-md-4"><h6><b>Location:</b></h6></div>
        <div class="locationrow col-md-8"></div>  
      </div><!-- END ROW -->

      <div class="row location2-qtydisplay" style="display:none;">
        <div class="col-md-4"><h6><b>Location 2:</b></h6></div>
        <div class="location2row col-md-8"></div>  
      </div><!-- END ROW -->

      <div class="row expiry-qtydisplay">
        <div class="col-md-4"><h6><b>Expiry:</b></h6></div>
        <div class="expiryrow col-md-8"></div>  
      </div><!-- END ROW -->

      <div class="row">
        <div class="col-md-4"><h6><b>Uom:</b></h6></div>
        <div class="col-md-8">        
        <select class="selectuompopup input-sm form-control">
        </select>
        </div>  
      </div><!-- END ROW -->

      <input type="hidden" class="form-control" id="hiddenitemrem">

      </div> <!-- END BODY -->

      <div class="modal-footer">
      <?php
      switch($module){
        case 'SJ': case 'RR':
          echo '<button id = "pricehistory" type="button" class="pricehistory itmqty-pricehistory btn btn-flat bg-orange btn-xs">
          <i class="fa fa-tags"></i> Price History</button>';
        break;
          }//end switch case
      ?>        
      <button id = "showbalance" type="button" class="showbalance itmqty-showbalance btn btn-flat btn-github btn-xs"><i class="fa fa-eye"></i> Show Stock</button>
      <button type="button" class="itemplotbtn btn btn-flat btn-success btn-xs" data-dismiss="modal"><i class="fa fa-check"></i>  OK</button>
      </div>
    </div>
  </div>
</div>