<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR IS MODULE-->
<div class="modal fade" id="quotemod-report" tabindex="-1" role="dialog" aria-labelledby="quotemod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Quotation</h4>
      </div>

        <div class="radio">
          <label style="margin-left: 5%">
            <input  type="radio" name="report" class="quotewo" value="quotewithout" checked>
            <b>Quotation (without company name)</b>
          </label> <br>

          <label style="margin-left: 5%">
            <input type="radio" name="report" class="quotew" value="quotewith"> 
            <b>Quotation (with company name)</b>
          </label>

          <div class="modal-footer">
            <button type="submit" class="report-btnok btn btn-success btn-success">OK</button>
          </div>
        </div>

        
        <!-- radio -->

        <div class="quotewithout">
          <!-- --- -->
          <form action="<?php echo Url::to(['/reports/default/modulereportquoteqwo/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Quoted by</h6></b>
                  <input name="quoted" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Approved by</h6></b>
                  <input name="approved" type="text" value="" class="input-sm form-control ">
                  <b><h6>Position</h6></b>
                  <input name="position" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="quotewithout" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
          <!-- ---- -->
        </div>


        <div class="quotewith">
          <!-- --- -->
          <form action="<?php echo Url::to(['/reports/default/modulereportquoteqw/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Quoted by</h6></b>
                  <input name="quoted" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Approved by</h6></b>
                  <input name="approved" type="text" value="" class="input-sm form-control ">
                  <b><h6>Position</h6></b>
                  <input name="position" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno2" name="trno" type="hidden" value="" class="input-sm form-control">
                   <input id="report-type" name="type" type="hidden" value="quotewith" class="input-sm form-control">
                  
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
          <!-- ---- -->
        </div>
          
    </div>
  </div>
</div>

