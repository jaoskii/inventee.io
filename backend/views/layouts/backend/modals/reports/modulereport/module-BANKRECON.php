<?php
use yii\helpers\Url;
?>

<!-- FOR MODAL REPORT FOR RR MODULE-->
<div class="modal fade" id="bankreconmod-report" tabindex="-1" role="dialog" aria-labelledby="bankreconmod-report" aria-hidden="true" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closereportlogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Print Receiving Report</h4>
      </div>

          <form action="<?php echo Url::to(['/reports/default/modulereportbankrecon/']); ?>" method="POST" target="_blank">
                <div class="modal-body">
                  <div class="col-md-2 enddate">
                      <div class="input-group">
                          <input id ="contra" name="contra" value="" type="text" placeholder="Account #" class="moduletxt txtcontra form-control input-sm">
                          <div class="input-group-addon"><a class ="btnshowcontra" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                      </div>
                  </div>

                  <div class="col-md-2 startdate">
                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                        <input id="startdate" type="text" placeholder="Start Date" readonly="" value="" size="12" class="form-control input-sm" >
                        <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                      </div>
                  </div>

                  <div class="col-md-2 enddate">
                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                      <input id="enddate" type="text" placeholder="End Date" readonly="" value="" size="12" class="form-control input-sm" >
                      <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                    </div>
                  </div>

                  <div class="col-md-2 cleardate">
                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                      <input id="cleardate" type="text" placeholder="Clear Date" readonly="" value="" size="12" class="form-control input-sm" >
                      <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                    </div>
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