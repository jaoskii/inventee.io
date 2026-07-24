<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR IS MODULE-->
<div class="modal fade" id="STOCKCARDmod-report" tabindex="-1" role="dialog" aria-labelledby="STOCKCARDmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Stockcard Ledger</h4>
      </div>

       <form action="<?php echo Url::to(['/reports/default/modulereportstockcard/']); ?>" method="POST" target="_blank">
                <div class="modal-body">

        <div class="row">
            <div class="col-md-4">
                <div class="repobj reporttype">                  
                    <h6 class="aimslabel"><b>Type of Reports</b></h6>
                    <input checked type="radio" id="sreport" class="repsons customer-reporttype"  name="customer-reporttype" value="ledger"> &nbsp;&nbsp;&nbsp;Ledger<br>
                    <input type="radio" class=" repsons customer-reporttype "  name="customer-reporttype" value="receiving"> &nbsp;&nbsp;&nbsp;Receiving<br>
                    <input type="radio" class="repsons customer-reporttype"  name="customer-reporttype" value="po"> &nbsp;&nbsp;&nbsp;Purchase Order<br>
                    <input type="radio" class="repsons customer-reporttype"  name="customer-reporttype" value="so"> &nbsp;&nbsp;&nbsp;Sales Order<br>
               </div>
            </div>

            <div class="col-md-8">
                <div class="repsons customer-startdate">               
                <h6 class="aimslabel"><b>Start Date</b></h6>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                <input type="text" readonly name="startdate"  value="" size="12" class="txtstartdate form-control input-sm">
                </div>
                <h6 class="aimslabel"><b>End Date</b></h6>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                <input type="text" readonly name="enddate"  value="" size="12" class="txtenddate form-control input-sm">
                </div>
                </br>
                </div>
            </div>
        </div>

        
        <h6 class="aimslabel"><b>Warehouse :</b>
        <div class="input-group">
            <input readonly name="warehouse" value ="<?php echo Yii::$app->session['loggeduser']['whname']?>~<?php echo Yii::$app->session['loggeduser']['whcode']?>" type="text" class="stockcardwhfilter form-control input-sm">
            <div class="frmwh input-group-addon"><a class ="whlookstockcardfilter" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
        </div></h6>

        <h6 class="aimslabel"><b>Location :</b>
        <div class="input-group">
            <input readonly="true" name="loc" value ="" type="text" class="txtstockcard-reploc input-sm form-control">
            <div class="frmdocumentno input-group-addon"><a class ="stockcard-reploclookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
        </div></h6>

        <h6 class="aimslabel viewbyfilters"><b>UOM: </b>
         <select name="uom" class="selectuomfilter input-sm form-control"></select>
        </h6>

        <h6><b>Prepared by</b></h6>
        <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
        <h6><b>Approved by</b></h6>
        <input name="approved" type="text" value="" class="input-sm form-control ">
        <h6><b>Received by</b></h6>
        <input name="received" type="text" value="" class="input-sm form-control">
        <input id="report-txttrno" name="itemid" type="hidden" value="" class="input-sm form-control">
                </div>
                
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
       </div>   
    </div>
  </div>
</div>

