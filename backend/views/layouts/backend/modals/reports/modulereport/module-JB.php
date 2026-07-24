<?php
use yii\helpers\Url;
?>

<!-- WTODO: [KIM][2019.10.06] FOR MODAL REPORT FOR Job order MODULE-->
<div class="modal fade" id="JBmod-report" tabindex="-1" role="dialog" aria-labelledby="JBmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Job Order</h4>
      </div>

            
         <div class="radio">
                <label style="margin-left: 5%">
                  <input  type="radio" name="report" class="JBjo" value="JBjoborder" checked>
                    <b>Job Order</b>
                </label> <br>

                <label style="margin-left: 5%">
                  <input type="radio" name="report" class="JBblow" value="JBblowing"> 
                    <b>Blowing</b>
                </label> <br>

                 <label style="margin-left: 5%">
                  <input type="radio" name="report" class="JBmreq" value="JBmatreq"> 
                    <b>Material Request</b>
                </label> <br>

                <label style="margin-left: 5%">
                  <input type="radio" name="report" class="JBddaily" value="JBdailydel"> 
                  <b>Daily Delivery</b>
                </label> <br>

                <label style="margin-left: 5%">
                  <input type="radio" name="report" class="JBslitlam" value="JBslitlaminate"> 
                  <b>Slitting and Lamination</b>
                </label> <br>

                <label style="margin-left: 5%">
                 <input type="radio" name="report" class="JBprint" value="JBprinting"> 
                 <b>Printing</b>
                </label> <br>

                <label style="margin-left: 5%">
                  <input type="radio" name="report" class="JBcutrej" value="JBcuttingreject"> 
                  <b>Cutting and Reject</b>
                </label> <br>

                <label style="margin-left: 5%">
                  <input type="radio" name="report" class="JBins" value="JBinspect"> 
                  <b>Inspection and Cylinder Release</b>
                </label> <br>

                <div class="modal-footer">
                  <button type="submit" class="report-btnok btn btn-success btn-success">OK</button>
                </div>
                
              </div>

        
        
        <!-- --- -->
        <div class="JBjoborder">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Reviewed by : </h6></b>
                  <input name="reviewed" type="text" value="" class="input-sm form-control ">
                  <b><h6>Approved by : </h6></b>
                  <input name="approved" type="text" value="" class="input-sm form-control ">
                  <b><h6>Noted by : </h6></b>
                  <input name="noted" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBjoborder" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
        <!-- ---- -->


        <!-- --- -->
        <div class="JBblowing">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Approved by : </h6></b>
                  <input name="approved" type="text" value="" class="input-sm form-control ">
                  <b><h6>Operator : </h6></b>
                  <input name="operator" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno2" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBblowing" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
        <!-- ---- -->

        <!-- --- -->
        <div class="JBmatreq">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Received by : </h6></b>
                  <input name="received" type="text" value="" class="input-sm form-control ">
                  <b><h6>Released by : </h6></b>
                  <input name="released" type="text" value="" class="input-sm form-control">
                  <b><h6>Approved by : </h6></b>
                  <input name="approved" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno3" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBmatreq" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
        <!-- ---- -->

        <!-- --- -->
        <div class="JBdailydel">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <input id="report-txttrno4" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBdailydel" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
        <!-- ---- -->

        <!-- --- -->
        <div class="JBslitlaminate">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Operator : </h6></b>
                  <input name="operator" type="text" value="" class="input-sm form-control ">
                  <b><h6>Reported by : </h6></b>
                  <input name="reported" type="text" value="" class="input-sm form-control">
                  <b><h6>Leadman : </h6></b>
                  <!--WTODO: [KIM][2019.10.09] change approved to leadman -->
                  <input name="leadman" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno5" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBslitlaminate" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
        <!-- ---- -->

        <!-- --- -->
        <div class="JBprinting">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Operator : </h6></b>
                  <input name="operator" type="text" value="" class="input-sm form-control ">
                  <b><h6>Leadman : </h6></b>
                  <input name="leadman" type="text" value="" class="input-sm form-control">
                  <input id="report-txttrno6" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBprinting" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
        <!-- ---- -->

        <!-- --- -->
        <div class="JBcuttingreject">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Checked by : </h6></b>
                  <input name="checked" type="text" value="" class="input-sm form-control ">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <input id="report-txttrno7" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBcuttingreject" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                  <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
        <!-- ---- -->

        <!-- --- -->
        <div class="JBinspect">
          <form action="<?php echo Url::to(['/reports/default/modulereportjb/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <b><h6>Prepared by : </h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Checked by : </h6></b>
                  <input name="checked" type="text" value="" class="input-sm form-control ">
                  <b><h6>Leadman : </h6></b>
                  <input name="leadman" type="text" value="" class="input-sm form-control ">
                  <b><h6>Released by : </h6></b>
                  <input name="released" type="text" value="" class="input-sm form-control ">
                  <b><h6>Received by : </h6></b>
                  <input name="received" type="text" value="" class="input-sm form-control "> 
                  <input id="report-txttrno8" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="JBinspect" class="input-sm form-control">
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

