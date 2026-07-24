<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR SO MODULE-->
<div class="modal fade" id="TXmod2-report" tabindex="-1" role="dialog" aria-labelledby="TXmod2-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereporttx2/']); ?>" method="POST" target="_blank">
          <div class="modal-body">
          <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                


                  <?php

                  switch(Yii::$app->systemsettings->companyConfig()){
                    case 'SOUTHCENTRAL':
                    echo '<br>


                    <div class="repobj sjreportlabel">
                    <label>Option : </label></br>
                    <input type="radio" class="reporttype" name="reporttype" value="default"> Default<br>
                    <input type="radio" class="reporttype" name="reporttype" value="postdelivery"> Post Delivery Report<br>
                    <input type="radio" class="reporttype" name="reporttype" value="dispatch"> Dispatch Confirmation<br>
                    </div>';
                    break;


                    default:
                    echo '<div class="repobj sjreportlabel">                  
                    <input id="report-type" name="reporttype" type="hidden" value="default" class="reporttype input-sm form-control">
                    </div>';
                    break;


                    }
                  ?>
                <div style="display:none;" class="modal-bodytrans">
                  <b><h6>Prepared by</h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Checked by</h6></b>
                  <input name="checked" type="text" value="" class="input-sm form-control">
                  
            
                </div>

                <div style="display:none;" class="modal-bodypatch">
                  <b><h6>Submitted by</h6></b>
                  <input name="patchsubmitted" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Approved by</h6></b>
                  <input name="patchapproved" type="text" value="" class="input-sm form-control">
                  
            
                </div>


                <div style="display:none;" class="modal-bodypostdel">
                  <b><h6>Submitted by</h6></b>
                  <input name="postdelsubmitted" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Approved by</h6></b>
                  <input name="postdelapproved" type="text" value="" class="input-sm form-control">
                  <b><h6>Attached by</h6></b>
                  <input name="attached" type="text" value="" class="input-sm form-control">
                  <b><h6>Checked by</h6></b>
                  <input name="postdelchecked" type="text" value="" class="input-sm form-control">
                  <b><h6>Noted by</h6></b>
                  <input name="noted" type="text" value="" class="input-sm form-control">
                  
            
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

