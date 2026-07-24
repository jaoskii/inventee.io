<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR IS MODULE-->
<div class="modal fade" id="KLmod-report" tabindex="-1" role="dialog" aria-labelledby="PCmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Collection List</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereportkl/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Collection by</h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Received by</h6></b>
                  <input name="received" type="text" value="" class="input-sm form-control ">
                  <b><h6>Verified by</h6></b>
                  <input name="verified" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
          
    </div>
  </div>
</div>

