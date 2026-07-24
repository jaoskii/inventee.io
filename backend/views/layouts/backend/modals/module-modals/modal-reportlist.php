<?php
use yii\helpers\Url;
use yii\base\ErrorException;
?>

<form action="<?php echo Url::to(['/reports/default/printreport/']); ?>" method="POST" target="_blank">
<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-reportlist" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="reportlist-title">-----</h6>
      </div>

      <div class="modal-body mod-rptmodal">

            <?php include_once('report-filters.php'); ?>
      </div>
      <div class="modal-footer">
        <button style="display: none;" type="submit" class=" btn btn-flat btn-success report-printbtn">Submit</button>
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</form>