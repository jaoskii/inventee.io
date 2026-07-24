<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR PO MODULE-->
<div class="modal fade" id="POmod-report" tabindex="-1" role="dialog" aria-labelledby="POmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Purchase Order</h4>
      </div>  
          
          <?php
          switch (Yii::$app->systemsettings->companyConfig()) {
            case 'MLCP':
              $approvelabel = 'Checked by';
            break;
            
            default:
              $approvelabel = 'Approved by';
            break;
          }//end switch
          ?>
          
          <form action="<?php echo Url::to(['/reports/default/modulereportpo/']); ?>" method="POST" target="_blank">
                <div class="modal-body">

                  <b><h6>Prepared by</h6></b>
                  <input name="prepared" type="text" value="<?php echo Yii::$app->session['loggeduser']['username'];?>" class="input-sm form-control">
                  <b><h6><?php echo  $approvelabel; ?></h6></b>
                  <input name="approved" type="text" value="" class="input-sm form-control ">
                  <?php
                  switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'DAVIDSALON_JOY':
                          echo '<b><h6>Checked by</h6></b>';
                      break;

                      default:
                          echo '<b><h6>Received by</h6></b>';
                      break;
                  }//END SWITCH
                  ?>
                  <input name="received" type="text" value="" class="input-sm form-control">
                  
                  <?php
                  switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'DAVIDSALON_JOY':
                          echo '<b><h6>Checked by (2)</h6></b>
                                <input name="received2" type="text" value="" class="input-sm form-control">
                                <b><h6>Checked by (3)</h6></b>
                                <input name="received3" type="text" value="" class="input-sm form-control">
                                <b><h6>Checked by (4)</h6></b>
                                <input name="received4" type="text" value="" class="input-sm form-control">';
                      break;
                  }//END SWITCH
                  ?>

                  <?php
                  switch (Yii::$app->systemsettings->companyConfig()) {
                      case 'UNIVERSE':
                        echo '<br>
                          <div class="repobj aimslabel sjreportlabel">                  
                          <label>View type: </label></br>
                          <input type="radio" id="viewtype_default" checked class="repsons aimslabel sjreportlabel"  name="potype" value="barcode"> Pucharse Order (Default)<br>
                          <input type="radio" class="repsons aimslabel sjreportlabel"  name="potype" value="uv_suppitemcode"> Pucharse Order (Supp-Itemcode)<br>
                          </div></br>';
                      break;

                      case 'FHI':
                         echo '<br>
                          <div class="repobj aimslabel sjreportlabel">                  
                          <label>View type: </label></br>
                          <input type="radio" id="viewtype_default" checked class="repsons aimslabel sjreportlabel"  name="poopt" value="opis"> Office Copy<br>
                          <input type="radio" class="repsons aimslabel sjreportlabel"  name="poopt" value="wh"> Warehouse Copy
                          </div></br>';
                      break;
                      
                      //WTODO: [KIM][2019.11.15][add option for PO printout]
                      case 'MLCP':
                        echo '<br>
                          <div class="repobj aimslabel sjreportlabel">                  
                          <label>View type: </label></br>
                          <input type="radio" id="viewtype_default" checked class="repsons aimslabel sjreportlabel"  name="potype" value="default"> Pucharse Order (Default)<br>
                          <input type="radio" class="repsons aimslabel sjreportlabel"  name="potype" value="polx"> Pucharse Order (LX)<br>
                          <input type="radio" class="repsons aimslabel sjreportlabel"  name="potype" value="service"> Service Receiving<br>
                          <input type="radio" class="repsons aimslabel sjreportlabel"  name="potype" value="servicelx"> Service Receiving (LX)
                          </div></br>';
                      break;
                  }//END SWITCH
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

