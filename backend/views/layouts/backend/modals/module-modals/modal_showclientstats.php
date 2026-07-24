<!-- MODAL FOR SHOW BALANCE-->
<div class="modal fade" id="modal-showclientstats" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Stats</h4>
      </div>

      <div class="modal-body">
      <label class="pull-left aimslabel">Select YEAR:</label>
      <select style="margin-left:5px;" class="statyear pull-left aimslabel">
      <option>2017</option>
      </select>
      <input type="hidden" value="MONTHLY" id="statview">
      <a class="setstatview pull-right clickable"><label class="aimslabel">SHOW ANNUAL</label></a>
      </div>

      <div class="modal-body mod-tble">
      <table class="showclientstats table table tbl-fix table-hover">
        <thead>
            <tr>
                <th class="stat-tits col-min aimslabel"><span class="text">Month</span></th>
                <th class="col-currency aimslabel"><span class="text">Total</span></th>
            </tr>
        </thead>
        
        <tbody class="tbl-showclientstats">
          
        </tbody>
      </table>
      </div>

      </br>
      <div class="modal-footer">
      <h5 class="pull-left aimslabel"><b>Grand Total: <span class="stats_gtotal"></span></b></h5>
      <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>