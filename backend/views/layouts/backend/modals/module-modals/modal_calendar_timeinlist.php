<!-- MODAL FOR CALENDAR-->
<div class="modal fade" id="modal-calendar-timeinlist" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Time IN List</h4>
      </div>

      <div class="row" style="margin-top:10px;">
      <input type="hidden" id="timeoxd">
            <div class="col-md-12">
                  <div class="col-md-3">
                        <label>User: </label>
                        <div class="input-group">
                        <input readonly="true" name="user" value ="" type="text" class="timeinuser form-control input-sm">
                        <div class="input-group-addon"><a class ="timeinuserlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                        </div>
                  </div>
                  <div class="col-md-3">
                        <label>Show date from: (Until Now)</label>
                        <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                        <input type="text" name = "dateid" readonly="" value="" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                        <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a>
                        </div>
                      </div>
                  </div>

                  <div class="col-md-4">
                      <label>Type: </label>
                      <select style="display: inline;" class="input-sm form-control timeintype">
                      <option></option>
                      <option>APPROVED</option>
                      <option>UNAPPROVED</option>
                      </select>
                  </div>

                  <div class="col-md-2"></br>
                  <button type="button" class="btnfiltertimein btn btn-flat btn-success">Refresh</button>
                  </div>
            </div>
      </div>

      <div class="modal-body">
      <div class="box-body mod-tble">
      <table class="table tbl-fix bodytable">
          <thead>
            <tr>
                <th class="col-min aimslabel"><span class="text">APPROVE</span></th>
                <th class="col-codes aimslabel"><span class="text">USERNAME</span></th>
                <th class="col-description aimslabel"><span class="text">NAME</span></th>
                <th class="col-min aimslabel"><span class="text">TIME</span></th>
                <th class="col-min aimslabel"><span class="text">DATE</span></th>
            </tr>
          </thead>
          <tbody class="timein-modulebody">
          </tbody>
      </table>
      </div>
      </div>


      <div class="modal-footer">
      <button type="button" class="closeitemlookup btn btn-sm btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>