<!-- MODAL FOR SHOW TERMS-->
<div class="modal fade" id="modal-stockcarduom" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Item UOM</h4>
      </div>


      <div class="modal-body uomform" style="display:none;">
      <label>UOM</label>
      <input type="hidden" class="input-sm form-control txtuom_looktype"></input>
      <input type="hidden" class="input-sm form-control uomform txtuomline"></input>
      <input type="hidden" class="input-sm form-control uomform txtuomprevname"></input>
      <input type="text" class="input-sm form-control uomform txtuomname"></input>
      <label>Factor</label>
      <input type="text" class="input-sm form-control uomform txtuomval"></input>
      <?php
        switch (Yii::$app->systemsettings->companyConfig()) {
          // XANDABELS
          case 'SOUTHCENTRAL':
          echo '<label class="stockcard-kilolabel">Kilos</label>
          <input type="text" class="input-sm form-control uomform txtuomkilos"></input>';

          echo '<label class="stockcard-kilolabel">CBM</label>
          <input type="text" class="input-sm form-control uomform txtuomcbm"></input>';

          break;

          case 'RTT': 
          echo '<label class="stockcard-kilolabel">Kilos</label>
          <input type="text" class="input-sm form-control uomform txtuomkilos"></input>';
          break;

          // END XANDA
          default:
          echo '<label style="display:none;" class="stockcard-kilolabel">Kilos</label>
          <input type="hidden" class="input-sm form-control uomform txtuomkilos"></input>';
          break;
        }//end switch case
      ?>
      <?php
        switch (Yii::$app->systemsettings->companyConfig()) {
          case 'NEWTIANLE':
          echo '<label class="stockcard-descriptionlabel">Packaging</label>';
          break;

          default:
          echo '<label class="stockcard-descriptionlabel">Description</label>';
          break;
        }//end switch case
      ?>
      <input type="text" class="input-sm form-control uomform txtuomdesc"></input>
      <label class="stockcard-amtlabel">Amount</label>
      <input type="text" class="input-sm form-control uomform txtuomamt"></input>
      </div>

      <div class="modal-body uomlist">
      <div class ="box box-solid mod-tble">
      <table class="table table tbl-fix table-hover">
        <thead>
            <tr>
                <th class="col-min aimslabel"><span class="text">Options</span></th>
                <th class="col-codes aimslabel"><span class="text">UOM</span></th>
                <th class="col-currency aimslabel"><span class="text">Factor</span></th>
                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  
                  // XANDABELS
                  case 'SOUTHCENTRAL':
                  echo '<th class="col-currency aimslabel"><span class="text">Kilos</span></th>';
                  echo '<th class="col-currency aimslabel"><span class="text">CBM</span></th>';
                  break;

                  case 'RTT': 
                  echo '<th class="col-currency aimslabel"><span class="text">Kilos</span></th>';
                  
                  break;
                  // END XANDA

                  default:
                  echo '<th style="display:none;" class="col-currency aimslabel"><span class="text">Kilos</span></th>';
                  break;
                }//end switch case
                ?>

                <th class="col-currency aimslabel"><span class="text">Amount</span></th>
                <?php
                switch (Yii::$app->systemsettings->companyConfig()) {
                  case 'NEWTIANLE':
                  echo '<th class="col-description aimslabel"><span class="text">Packaging</span></th>';
                  break;

                  default:
                  echo '<th class="col-description aimslabel"><span class="text">Description</span></th>';
                  break;
                }//end switch case
                ?>
            </tr>
        </thead>
        <tbody class="tbl-stockcarduom">

        </tbody>
      </table>
      </div>
      </div>

      <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-flat btn-success uomformnew uomformbtn-inactive">Add New UOM</button>
      <button type="button" class="btn btn-sm btn-flat btn-success uomformsave uomformbtn-active"  style="display:none;">Save</button>
      <button type="button" class="btn btn-sm btn-flat btn-success uomformcancel uomformbtn-active" style="display:none;">Cancel</button>
      <button type="button" class="btn-sm closeitemlookup btn btn-flat btn-success uomformbtn-inactive" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>