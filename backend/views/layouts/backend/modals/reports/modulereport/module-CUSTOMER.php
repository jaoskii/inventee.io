<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR IS MODULE-->
<div class="modal fade" id="CUSTOMERmod-report" tabindex="-1" role="dialog" aria-labelledby="CUSTOMERmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Customer Ledger</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereportcustomer/']); ?>" method="POST" target="_blank">
                <div class="modal-body">

      <div class="repobj reporttype">                  
            <b><h6>Type of Reports</h6></b>
            <input type="radio" id="sreport" class="repsons customer-reporttype"  name="customer-reporttype" value="ar"> &nbsp;&nbsp;&nbsp;Accounts Receivable<br>
            <input type="radio" class=" repsons customer-reporttype "  name="customer-reporttype" value="ap"> &nbsp;&nbsp;&nbsp;Accounts Payable<br>
            <input type="radio" class="repsons customer-reporttype"  name="customer-reporttype" value="pdc"> &nbsp;&nbsp;&nbsp;Postdated Checks<br>
            <input type="radio" class="repsons customer-reporttype"  name="customer-reporttype" value="rc"> &nbsp;&nbsp;&nbsp;Return Checks<br>
            <input type="radio" class="repsons customer-reporttype"  name="customer-reporttype" value="stock"> &nbsp;&nbsp;&nbsp;Inventory
       </div></br>

        <div class="repsons customer-startdate" >               
         <b><h6>Start Date</h6></b>
        <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
        <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
        <input type="text" name="startdate"  value="" size="12" class="txtstartdate form-control input-sm">
        </div>
        </br>
        </div>   
        <b><h6>Prepared by</h6></b>
        <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
        <b><h6>Approved by</h6></b>
        <input name="approved" type="text" value="" class="input-sm form-control ">
        <b><h6>Received by</h6></b>
        <input name="received" type="text" value="" class="input-sm form-control">
        <input id="report-txttrno" name="clientid" type="hidden" value="" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
          
    </div>
  </div>
</div>

