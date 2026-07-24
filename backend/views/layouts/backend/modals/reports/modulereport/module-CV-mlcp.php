<?php
use yii\helpers\Url;
//WTODO: [KIM][2019.11.20][module-CV update]
?>

<!-- FOR MODAL REPORT FOR IS MODULE-->
<div class="modal fade" id="CVmod-report" tabindex="-1" role="dialog" aria-labelledby="CVmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Cash/Check Voucher</h4>
      </div>

          <div class="radio">
              <?php 
              switch (Yii::$app->systemsettings->companyConfig()) {
                case 'RTT':
                  echo '<br>
                    <div class="repobj cvreportlabel">                  
                      <label>Type of Report: </label></br>
                     
                      <label style="margin-left: 5%">
                        <input type="radio" id="cvreport" class="repsons cvreportlabel vouchera"  name="cvreportlabel" value="1">
                        <b> A VOUCHER</b>
                      </label> <br>
                      
                      <label style="margin-left: 5%">
                        <input type="radio" class="repsons cvreportlabel voucherb"  name="cvreportlabel" value="2">
                        <b> B VOUCHER</b>
                      </label> <br>
                      
                      <label style="margin-left: 5%">
                        <input type="radio" class="repsons cvreportlabel voucher"  name="cvreportlabel" value="3">
                        <b> CHECK</b>
                      </label> <br>
                     
                    </div></br>
                    ';
                  break;

                //WTODO: [KIM][2019.11.20][add option for CV printout]
                case 'MLCP':
                  echo '<br>
                    <div class="repobj aimslabel cvreportlabel">                  
                      <label>View type: </label></br>
                     
                      <label style="margin-left: 5%">
                        <input type="radio" id="cvreport" checked class="repsons optcvreport voucher " name="cvtype" value="1">
                        <b>VOUCHER</b>
                      </label> <br>
                      
                      <label style="margin-left: 5%">
                        <input type="radio" class="repsons optcvreport voucherlx" name="cvtype" value="2">
                        <b>VOUCHER (LX)</b>
                      </label> <br>
                      
                      <label style="margin-left: 5%">
                        <input type="radio" class="repsons optcvreport check" name="cvtype" value="3">
                        <b>CHECK</b>
                      </label> <br>
                     
                      <label style="margin-left: 5%">
                        <input type="radio" class="repsons optcvreport checklx" name="cvtype" value="4">
                        <b>CHECK (LX)</b>
                      </label> <br>

                    </div></br>
                    ';
                  break;

                default:
                  echo '<br>
                    <div class="repobj cvreportlabel">                  
                      <label>Type of Report: </label></br>
                     
                      <label style="margin-left: 5%">
                        <input type="radio" id="cvreport" checked class="repsons optcvreport cvreportlabel voucher"  name="cvreportlabel" value="1">
                        <b>&nbsp VOUCHER</b>
                      </label> <br>
                      
                      <label style="margin-left: 5%">
                        <input type="radio" class="repsons optcvreport cvreportlabel check"  name="cvreportlabel" value="2">
                        <b>&nbsp CHECK</b>
                      </label> <br>
                    </div></br>
                    ';
                break;
              }//END SWITCH CASE
              ?>            

              <div class="modal-footer">
                <button type="submit" class="report-btnok btn btn-success btn-success">OK</button>
              </div>
                
          </div>


          <!-- --- -->
          <div class="txtparams">
            <form action="<?php echo Url::to(['/reports/default/modulereportcv/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <?php 
                    switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'KINGGEORGE':
                        echo '
                          <b><h6>Prepared by</h6></b>
                          <input name="prepared" type="text" value="'.Yii::$app->session['loggeduser']['username'].'" class="input-sm form-control">
                          <b><h6>Certified Correct by</h6></b>
                          <input name="approved" type="text" value="" class="input-sm form-control ">
                          <b><h6>Received by</h6></b>
                          <input name="received" type="text" value="" class="input-sm form-control">
                          <b><h6>Approved by</h6></b>
                          <input name="checked" type="text" value="" class="input-sm form-control">
                          <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                          ';
                      break;
                      default:
                        echo '
                          <b><h6>Prepared by</h6></b>
                          <input name="prepared" type="text" value="'.Yii::$app->session['loggeduser']['username'].'" class="input-sm form-control">
                          <b><h6>Approved by</h6></b>
                          <input name="approved" type="text" value="" class="input-sm form-control ">
                          <b><h6>Received by</h6></b>
                          <input name="received" type="text" value="" class="input-sm form-control">
                          <b><h6>Checked by</h6></b>
                          <input name="checked" type="text" value="" class="input-sm form-control">
                          <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                          <input id="report-type" name="cvtype" type="hidden" value="1" class="input-sm form-control">
                          ';
                      break;
                    }
                  ?>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
          <!-- ---- -->

          <!-- --- -->
          <div class="txt2params">
            <form action="<?php echo Url::to(['/reports/default/modulereportcv/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <?php 
                    echo '
                          <b><h6>Prepared by</h6></b>
                          <input name="prepared" type="text" value="'.Yii::$app->session['loggeduser']['username'].'" class="input-sm form-control">
                          <b><h6>Approved by</h6></b>
                          <input name="approved" type="text" value="" class="input-sm form-control ">
                          <b><h6>Received by</h6></b>
                          <input name="received" type="text" value="" class="input-sm form-control">
                          <b><h6>Checked by</h6></b>
                          <input name="checked" type="text" value="" class="input-sm form-control">
                          <input id="report-txttrno2" name="trno" type="hidden" value="" class="input-sm form-control">
                          <input id="report-type" name="cvtype" type="hidden" value="2" class="input-sm form-control">
                          ';
                  ?>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
          <!-- ---- -->

          <!-- --- -->
          <div class='optparams'>
            <form action="<?php echo Url::to(['/reports/default/modulereportcv/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                    <label>Payee: </label></br>
                    <input type="text" class="repsons opt2paramstextbox"  name="opt2paramstextbox"><br><br>

                    <label>Bank Cheque: </label></br>
                      <input type="radio" checked class="repsons optparamslabel"  name="optparamslabel" value="1">&nbsp ChinaBank<br>
                      <input type="radio" class="repsons optparamslabel"  name="optparamslabel" value="2">&nbsp MetroBank<br>
                      <input type="radio" class="repsons optparamslabel"  name="optparamslabel" value="3">&nbsp BusinessBank<br>
                      <input id="report-txttrno3" name="trno" type="hidden" value="" class="input-sm form-control">
                      <input id="report-type" name="cvtype" type="hidden" value="3" class="input-sm form-control">
                    </br>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
          <!-- ---- -->

          <!-- --- -->
          <div class='opt2params'>
            <form action="<?php echo Url::to(['/reports/default/modulereportcv/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                    <label>Payee: </label></br>
                      <input type="text" class="repsons opt2paramstextbox"  name="opt2paramstextbox"><br><br>

                    <label>Bank Cheque: </label></br>
                      <input type="radio" checked class="repsons opt2paramslabel"  name="opt2paramslabel" value="1">&nbsp ChinaBank<br>
                      <input type="radio" class="repsons opt2paramslabel"  name="opt2paramslabel" value="2">&nbsp MetroBank<br>
                      <input type="radio" class="repsons opt2paramslabel"  name="opt2paramslabel" value="3">&nbsp BusinessBank<br>
                      <input id="report-txttrno4" name="trno" type="hidden" value="" class="input-sm form-control">
                      <input id="report-type" name="cvtype" type="hidden" value="4" class="input-sm form-control">
                    </br>
                </div>
                
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
          <!-- ---- -->

    </div>
  </div>
</div>

