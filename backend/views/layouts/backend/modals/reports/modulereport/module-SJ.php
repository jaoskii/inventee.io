<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR SJ MODULE-->
<div class="modal fade" id="SJmod-report" tabindex="-1" role="dialog" aria-labelledby="SJmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Sales Journal</h4>
      </div>
          <div class="DR">
          <form action="<?php echo Url::to(['/reports/default/modulereportsj/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
      <!-- //08-06-2016 jr           -->
              <?php 
              switch (Yii::$app->systemsettings->companyConfig()) {
                case 'FHI':
                   echo '
                    <div class="repobj sjreportlabel">                  
                    <label>Type of Report: </label></br>
                    <input type="radio" id="sreport" class="repsons sjreportlabel fhilayoutreport" checked name="sjreportlabel" value="1"> Cash Invoice<br>
                    <input type="radio" class="repsons sjreportlabel fhilayoutreport"  name="sjreportlabel" value="2"> Delivery Receipt <br>
                    <input type="radio" class="repsons sjreportlabel fhilayoutreport"  name="sjreportlabel" value="3"> Sales Invoice <br>
                    <input type="radio" class="repsons sjreportlabel fhilayoutreport"  name="sjreportlabel" value="4"> SS DR Format <br>
                    <input type="radio" class="repsons sjreportlabel fhilayoutreport"  name="sjreportlabel" value="5"> Bodega Out - Warehouse
                    </div></br>
                    
                    <h6 class="aimslabel fhiwhfilter" style="display:none;">Warehouse:
                    <div class="input-group">
                      <input readonly name="fhiwh" value ="" type="text" class="fhiwh form-control input-sm">
                      <div class="frmwh input-group-addon">
                      <a class ="whlookupfhi" href="#"><i class="fa fa-chevron-circle-down"></i></a>
                      </div>
                    </div>
                    </h6>';
                break;
                
                case 'RTT':
                  echo '
                    <div class="repobj sjreportlabel">                  
                    <label>Type of Report: </label></br>
                    <input type="radio" id="sreport" class="repsons sjreportlabel"  name="sjreportlabel" value="1"> Trust Report<br>
                    <input type="radio" class="repsons sjreportlabel"  name="sjreportlabel" value="2"> Non-Vat Sales Invoice<br>
                    <input type="radio" class="repsons sjreportlabel"  name="sjreportlabel" value="3"> Vat Sales Invoice
                    </div></br>';
                break;

                case 'PANDATOOLS':
                  // echo '
                  //   <div class="repobj sjreportlabel">                  
                  //   <label>Type of Report: </label></br>
                  //   <input type="radio" id="sreport" class="repsons sjreportlabel"  name="sjreportlabel" value="1"> Delivery Report<br>
                  //   <input type="radio" class="repsons sjreportlabel"  name="sjreportlabel" value="2"> Sales Invoice - A<br>
                  //   <input type="radio" class="repsons sjreportlabel"  name="sjreportlabel" value="3"> Sales Invoice - B<br>
                  //   <input type="radio" class="repsons sjreportlabel"  name="sjreportlabel" value="4"> Cash Invoice
                  //   </div></br>';
                  break;

                case 'TENPLUS':
                  echo '
                    <div class="repobj sjreportlabel">                  
                    <label>Type of Report: </label></br>
                    <input type="radio" id="sreport" class="repsons sjreportlabel" checked name="sjreportlabel" value="SALES RECEIPT"> SALES RECEIPT<br>
                    <input type="radio" class="repsons sjreportlabel"  name="sjreportlabel" value="COLLECTION RECEIPT"> COLLECTION RECEIPT<br>
                    <input type="radio" class="repsons sjreportlabel"  name="sjreportlabel" value="DELIVERY RECEIPT"> DELIVERY RECEIPT<br>
                    </div></br>';
                  break;   

                //WTODO: [KIM][2019.11.20][add option for SJ printout]
                case 'MLCP':
                  echo '<br>
                    <div class="repobj aimslabel sjreportlabel">                  
                      <label>View type: </label></br>
                      <input type="radio" id="viewtype_default" checked class="repsons aimslabel sjreportlabel"  name="sjtype" value="default"> Sales Journal (Default)<br>
                      <input type="radio" class="repsons aimslabel sjreportlabel"  name="sjtype" value="sjlx"> Sales Journal (LX)<br>
                    </div></br>';
                  break;


                default:
                  echo '<div class="repobj sjreportlabel">                  
                    <input id="report-type" name="reporttype" type="hidden" value="default" class="reporttype input-sm form-control">
                    </div>';
                    break;
                break;

              }//END SWITCH CASE
              ?>            
     <!-- //END 08-06-2016 jr -->

              <?php
              switch (Yii::$app->systemsettings->companyConfig()) {
                case 'CANUMAY':
                  echo '<b><h6>Prepared by</h6></b>
                        <input name="prepared" type="text" value="'.Yii::$app->session['loggeduser']['username'].'" class="input-sm form-control">
                        <b><h6>Approved by</h6></b>
                        <input name="approved" type="text" value="" class="input-sm form-control ">
                        <b><h6>Delivered by</h6></b>
                        <input name="delivered" type="text" value="" class="input-sm form-control">
                        <b><h6>Checked by</h6></b>
                        <input name="checked" type="text" value="" class="input-sm form-control">
                        <br>
                        <input type="radio" name="outputtype" value="items" checked>&nbspItems
                        <br>
                        <input type="radio" name="outputtype" value="withvalue">&nbspValue';
                break;

                default:
                  echo '<b><h6>Prepared by</h6></b>
                        <input name="prepared" type="text" value="'.Yii::$app->session['loggeduser']['username'].'" class="input-sm form-control">
                        <b><h6>Approved by</h6></b>
                        <input name="approved" type="text" value="" class="input-sm form-control ">
                        <b><h6>Received by</h6></b>
                        <input name="received" type="text" value="" class="input-sm form-control">';
                break;
              }//END SWITCH
              ?>

                  <input id="report-txttrno" name="trno" type="hidden" value="" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
          
        </div>
       </form>   

          <div class="univopt">
                      <div class="radio">
                        <label style="margin-left: 5%">
                          <input  type="radio" name="report" class="DRwobatch" value="wobatch" checked>
                            <b>DR without Batch</b>
                        </label> <br>

                        <label style="margin-left: 5%">
                          <input type="radio" name="report" class="DRwbatch" value="wbatch"> 
                            <b>DR with Batch</b>
                        </label><br>

                        <label style="margin-left: 5%">
                          <input type="radio" name="report" class="DRcharge" value="drcharge"> 
                            <b>Charge Sales Invoice</b>
                        </label><br>

                        <label style="margin-left: 5%">
                          <input type="radio" name="report" class="DRpickslip" value="pickslip"> 
                            <b>Pick Slip</b>
                        </label><br>

                      

                        <div class="modal-footer">
                          <button type="submit" class="report-btnok btn btn-success btn-success">Print</button>
                        </div>
                      </div>
          </div>
          <div class = "wobatch">
              <form id="uniwobatchform" class = "form_wobatch" action="<?php echo Url::to(['/reports/default/modulereportdr/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                 <!-- <b><h6>Prepared by</h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Picked by</h6></b>
                  <input name="picked" type="text" value="GELA" class="printpickedby input-sm form-control ">
                  <b><h6>Checked by</h6></b>
                  <input name="checked" type="text" value="MIRASOL" class="printcheckedby input-sm form-control">
                  
                  <input id="report-type" name="type" type="hidden" value="wobatch" class="input-sm form-control"> -->
                  <input id="report-txttrno1" name="trno" type="hidden" value="" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
              </form>
          </div>

          <div class = "wbatch">
              <form id="uniwbatchform" class = "form_wbatch" action="<?php echo Url::to(['/reports/default/modulereportwdr/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
              <!--  <b><h6>Prepared by</h6></b>
               <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
               <b><h6>Picked by</h6></b>
               <input name="picked" type="text" value="GELA" class="printpickedby input-sm form-control ">
               <b><h6>Checked by</h6></b>
               <input name="checked" type="text" value="MIRASOL" class="printcheckedby input-sm form-control">
               <input id="report-type" name="type" type="hidden" value="wbatch" class="input-sm form-control"> -->
                <input id="report-txttrno2" name="trno" type="hidden" value="" class="input-sm form-control">
                </div>  
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
              </form>
          </div>

          <div class = "drcharge">
              <form id = "unidrchargeform" class = "form_drcharge" action="<?php echo Url::to(['/reports/default/modulereportdrcharge/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                 <b><h6>Prepared by</h6></b>
                  <!-- <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Picked by</h6></b>
                  <input name="picked" type="text" value="GELA" class="printpickedby input-sm form-control ">
                  <b><h6>Checked by</h6></b>
                  <input name="checked" type="text" value="MIRASOL" class="printcheckedby input-sm form-control">
                  
                  <input id="report-type" name="type" type="hidden" value="drcharge" class="input-sm form-control"> -->
                <input id="report-txttrno3" name="trno" type="hidden" value="" class="input-sm form-control">
                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
              </form>
          </div>

          <div class = "pickslip">
              <form id = "unipickslipform" action="<?php echo Url::to(['/reports/default/modulereportdrpickslip/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                 <b><h6>Prepared by</h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6>Picked by</h6></b>
                  <input name="picked" type="text" value="GELA" class="printpickedby input-sm form-control ">
                  <b><h6>Checked by</h6></b>
                  <input name="checked" type="text" value="MIRASOL" class="printcheckedby input-sm form-control">
                  <input id="report-txttrno4" name="trno" type="hidden" value="" class="input-sm form-control">
                  <input id="report-type" name="type" type="hidden" value="pickslip" class="input-sm form-control">

                </div>
                <div class="modal-footer">
                <button type="submit" class="report-btnprint btn btn-flat btn-success">Print</button>
                <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
                </div>
              </form>
          </div>
          
    </div>
  </div>
</div>