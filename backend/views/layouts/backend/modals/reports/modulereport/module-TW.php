<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR IS MODULE-->
<div class="modal fade" id="TWmod-report" tabindex="-1" role="dialog" aria-labelledby="DSmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Cert. of Tax Wheld at Source</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereporttw/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Authorized Representative</h6></b>
                  <input name="authorized" type="text" value="" class="input-sm form-control ">
                  <b><h6>Position</h6></b>
                  <input name="possition" type="text" value="" class="input-sm form-control">
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

