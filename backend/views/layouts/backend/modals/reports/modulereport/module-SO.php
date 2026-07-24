<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR SO MODULE-->
<div class="modal fade" id="SOmod-report" tabindex="-1" role="dialog" aria-labelledby="SOmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Sales Order</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereportso/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <?php
                    switch(Yii::$app->systemsettings->companyConfig()){
                      default:
                        echo '<b><h6>Prepared by</h6></b>
                        <input name="prepared" type="text" value="'.Yii::$app->session['loggeduser']['username'].'" class="input-sm form-control">
                        <b><h6>Approved by</h6></b>
                        <input name="approved" type="text" value="" class="input-sm form-control ">
                        <b><h6>Received by</h6></b>
                        <input name="received" type="text" value="" class="input-sm form-control">
                        <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                        
                        <div class="repobj sjreportlabel">                  
                        <input id="report-type" name="reporttype" type="hidden" value="default" class="reporttype input-sm form-control">
                        </div>';
                      break;
                    }//end switch
                  ?>
                </div>
                <div class="modal-footer">
                  <?php
                  switch(Yii::$app->systemsettings->companyConfig()){
                    case 'UNIVERSE':
                      echo '<button type="button" class="pull-left report-btnprintpos btn btn-flat btn-success">Print on POS Printer</button>';
                    break;
                  }//end switch
                  ?>
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
          
    </div>
  </div>
</div>

