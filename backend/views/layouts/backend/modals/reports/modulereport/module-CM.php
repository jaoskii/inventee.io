<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR CM MODULE-->
<div class="modal fade" id="CMmod-report" tabindex="-1" role="dialog" aria-labelledby="CMmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Sales Return</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereportcm/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                    <?php
                    switch(Yii::$app->systemsettings->companyConfig()){
                      case 'CANUMAY':
                        echo '<b><h6>Checked by</h6></b>
                              <input name="checked" type="text" value="" class="input-sm form-control ">
                              <b><h6>Customer</h6></b>
                              <input name="customer" type="text" value="" class="input-sm form-control ">';
                      break;
                      
                      default:
                        echo '<b><h6>Prepared by</h6></b>
                              <input name="prepared" type="text" value="'.Yii::$app->session['loggeduser']['username'].'" class="input-sm form-control">
                              <b><h6>Approved by</h6></b>
                              <input name="approved" type="text" value="" class="input-sm form-control ">
                              <b><h6>Received by</h6></b>
                              <input name="received" type="text" value="" class="input-sm form-control">';
                      break;
                    }//end swtich
                    ?>
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

