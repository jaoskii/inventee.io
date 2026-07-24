<?php
use yii\helpers\Url;
$this->title = 'Manage Sale Items';
?>

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
<div class="row">
<div class="col-md-12">
        <div class="box box-solid box-success">
               

                <div class="box-body">

                <div class="col-md-1">
                <label style="margin-top: 5px;" class="aimslabel">Search Filters: </label>
                </div>

                <div class="col-md-2">
                <select id="fsalestatusfilter" style="margin-top: 2px;" class="input-sm form-control">
                <option value="onsale">ON SALE</option>
                <option value="endsale">ENDED SALE</option>
                </select>
                </div>

      <div class="col-md-3">
        <div class="input-group">
          <input value ="" type="text" class="txtfsaleitemsearch input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
        </div>
      </div>

      <div class="col-md-3">
      <button class="fsaleextendbtn col-md-12 btn btn-success btn-flat"><i class="fa fa-pencil"></i> Extend Sale of Selected Items</button>
      </div>

      <div class="col-md-3">
      <button class="fsaleendbtn col-md-12 btn btn-github btn-flat"><i class="fa fa-unlink"></i> End Sale of Selected Items</button>
      </div>

                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<div class="row">
    <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

    <div class="col-md-12">
    <label class="aimslabel">NOTE: All discounts under certain highlights (highlighted in <span style="color:#EC7063;"><i class="fa fa-square"></i></span>) can only be modified on Highlight Manager.</label>
          <div class="box box-solid box-success tableendsaleitems" style="display:none;">
               <div class="box-body scroll-divs">

                      <table class="table tbl-fix bodytable">
                        <thead>
                            <tr>
                              <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                              <th class="col-description aimslabel"><span class="text">Itemname</span></th>
                              <th class="col-codes aimslabel"><span class="text">Highlight</span></th>
                              <th class="col-codes aimslabel"><span class="text">Date Started</span></th>
                              <th class="col-codes aimslabel"><span class="text">Date Ended</span></th>
                            </tr>
                        </thead>
                        
                          <tbody class="modulebody fendsalelisttbl">
                              
                          </tbody>
                      </table>  

                </div><!-- /.box-body -->
            </div><!-- /.box -->

          <div class="box box-solid box-success tablesaleitems">
               <div class="box-body scroll-divs">

                    <table class="table tbl-fix bodytable">
                      <thead>
                          <tr>
                            <th class="col-checkbox btblcenter aimslabel"><span class="text">&nbsp</span></th>
                            <th class="col-min aimslabel"><span class="text">Sale Start</span></th>
                            <th class="col-min aimslabel"><span class="text">Sale End</span></th>
                            <!-- <th class="col-codes aimslabel"><span class="text">Event</span></th> -->
                            <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                            <th class="col-description aimslabel"><span class="text">Itemname</span></th>
                            <th class="col-description aimslabel"><span class="text">Highlights</span></th>
                            <th class="col-quantity aimslabel"><span class="text">Qty</span></th>
                            <th class="col-currency aimslabel"><span class="text">Amount</span></th>
                          </tr>
                      </thead>
                      
                        <tbody class="modulebody fsalelisttbl">
                           
                        </tbody>
                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
    </div> <!-- END COL MD 9 -->
    </div> <!-- END ROW -->

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->

<!-- MODAL FOR SHOW TERMS-->
<div class="modal fade" id="modal-extenddate" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Extend Sale Date Until</h4>
      </div>

      <div class="modal-body">
      <h6 class="aimslabel extenddateid"><b>Extend Sale Date: 
      <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d'); ?>"  class="paedit input-group date dpYears">
        <input type="text" name = "extenddate" readonly="" value="<?php echo date('Y-m-d'); ?>" size="12" class="fsaleextenddate form-control input-sm" disabled="true">
        <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
      </div></b></h6>
      </div>

      <div class="modal-footer">
      <button type="button" class="fextendbtn btn btn-flat btn-primary"><i class="fa fa-tags"></i> Extend Sale</button>
      <button type="button" class="btn btn-flat btn-github" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>