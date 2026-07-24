<?php
use yii\helpers\Url;
$this->title = 'Print Log Tracer';
?>

<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="lines" value="">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">PRINT LOG FILTERS</h6></b>
      </div>
      <div class="box-body mod-tbleaudittrail">
        <div class="row label-x">
          <div class="col-md-2"><h6 class="aimslabel"><b>Start Date:</b></h6></div>
          <div class="col-md-2"><h6 class="aimslabel"><b>End Date:</b></h6></div>
          <div class="col-md-2"><h6 class="aimslabel"><b>User:</b></h6></div>
          <div class="col-md-2"><h6 class="aimslabel"><b>Type:</b></h6></div>
          <div class="col-md-3"><h6 class="aimslabel"><b>Search:</b></h6></div>
        </div>
        <div id = "auditfiltering" class="row">
          <div class="col-md-2 startdate auditfix-space">
            <h6 class="labeling"><b>Start Date:</b></h6>
            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d', strtotime("-6 months"));?>"  class="paedit input-group date dpYears">
              <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
              <input type="text" name = "dateid" readonly="" value="<?php echo date('Y-m-d', strtotime("-6 months"));?>" size="12" class="logstartdate form-control input-sm" disabled="true">
            </div>
          </div>

          <div class="col-md-2 enddate auditfix-space">
              <h6 class="labeling"><b>End Date:</b></h6>
            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
              <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
              <input type="text" name = "dateid" readonly="" value="<?php echo date('Y-m-d');?>" size="12" class="logenddate form-control input-sm" disabled="true">
            </div>
          </div>
          <div class="col-md-2 auditfix-space">
              <h6 class="labeling"><b>User</b></h6>
            <select class="selectedusers input-sm form-control">
              <?php
                foreach ($usersdata as $data) {
                  echo '<option value = "'.$data['userid'].'" id='.$data['username']. '-'.$data['accessid'].'>'.$data['username'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-md-2 auditfix-space">
              <h6 class="labeling"><b>Module: </b></h6>
            <select class="selectmodule input-sm form-control">
              <option id="ALL"></option>
              <option value="MODULE">Modules Prints</option>
              <option value="REPORTS">Report Prints</option>
            </select>
          </div>

          <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control logsearcher" placeholder="Search for Description / Title / Username">
            </div>
          </div>

          <div class="col-md-1">
            <button style="display:inline;width:100%;" class="btn btn-sm btn-success btnlogtraceOn btn-flat" id="auditok">OK</button>
          </div>
        </div>
        <div class="tbltracelogs"></div>
      </div>
    </div>
  </div>
</div>