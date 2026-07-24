<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR SO MODULE-->
<div class="modal fade" id="RFmod-report" tabindex="-1" role="dialog" aria-labelledby="RFmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereportrf/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Submitted by</h6></b>
                  <input name="submitted" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Approved by</h6></b>
                  <input name="approved" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
 

                  <div class="repobj sjreportlabel">
                    <label>Option : </label></br>
                    <input type="radio" class="reporttype" name="reporttype" checked value="default"> Default<br>
                    <input type="radio" class="reporttype" name="reporttype" value="unserved"> Unserved Sales Order<br>
                    
                    </div>
                  
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
          
    </div>
  </div>
</div>