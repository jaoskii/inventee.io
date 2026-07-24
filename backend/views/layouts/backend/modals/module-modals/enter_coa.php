<!-- MODAL FOR ITEM QTY-->
<div class="modal fade" id="modal-entercoa" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Account</h4>
      </div>

      <div class="modal-body">
      <div class="row">
        <div class="coapostdatelbl col-md-4"><h6><b>Post Date:</b></h6></div>
        <div class="col-md-8"><input class="coapostdate input-sm form-control" type="text">
        </div>
      </div> <!-- END ROW -->

      <div class="row">
        <div class="col-md-4"><h6><b>Acnoname:</b></h6></div>
        <div class="col-md-8">
        <input class="coaacnoid input-sm form-control" type="hidden">
        <input class="coaacno input-sm form-control" type="hidden">
        <input disabled = "true" class="coaacnoname input-sm form-control" type="text">
        </div>
      </div> <!-- END ROW -->

      <div class="row">
        <div class="col-md-4"><h6><b>Debit:</b></h6></div>
        <div class="col-md-8"><input class="coadb input-sm form-control" type="text">
        </div>
       </div> <!-- END ROW -->


      <div class="row">
        <div class="col-md-4"><h6><b>Credit:</b></h6></div>
        <div class="col-md-8"><input class="coacr input-sm form-control" type="text">
        </div>
      </div> <!-- END ROW -->


      <div class="row coarowcheckno">
        <div class="col-md-4"><h6><b>Check #:</b></h6></div>
        <div class="col-md-8"><input class="coacheckno input-sm form-control" type="text">
        </div>
      </div> <!-- END ROW -->

      <div class="row">
        <div class="coaclientlabel col-md-4"><h6><b>Cstmr/Supplr:</b></h6></div>
        <div class="col-md-8">        
        <div class="input-group">
        <input disabled="true" value ="" type="text" class="coaclientnametxt form-control input-sm">
        <input disabled="true" value ="" type="hidden" class="coaclienttxt form-control input-sm nobody">
        <div class="frmwh input-group-addon"><a class ="clickable coaclientlookup"><i class="fa fa-chevron-circle-down"></i></a></div>
        </div>
        </div>  
      </div> <!-- END ROW  --> 

      <div class="row">
        <div class="col-md-4"><h6><b>Notes:</b></h6></div>
        <div class="col-md-8">
        <textarea style="resize:none;" class="coanotes form-control"></textarea>
        </div>
      </div> <!-- END ROW -->


      <div class="row coaref" style="margin-top: 5px;">
        <div class="col-md-4"><h6><b>Reference:</b></h6></div>
        <div class="col-md-8"><input class="coareference input-sm form-control" type="text">
        </div>
      </div> <!-- END ROW -->

      </div> <!-- END BODY -->

      <div class="modal-footer">
      <button type="button" class="coaplotbtn btn btn-flat btn-success">Add Account</button>
      </div>
    </div>
  </div>
</div>