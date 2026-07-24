<?php
use yii\helpers\Url;
$this->title = 'Audit Trail';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>
<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="lines" value="">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">AUDIT TRAIL</h6></b>
      </div>
      <div class="box-body mod-tbleaudittrail">
        <div class="row label-x">
          <div class="col-md-3"><h6 class="aimslabel"><b>Start Date:</b></h6></div>
          <div class="col-md-3"><h6 class="aimslabel"><b>End Date:</b></h6></div>
          <div class="col-md-2"><h6 class="aimslabel"><b>User:</b></h6></div>
          <div class="col-md-3"><h6 class="aimslabel"><b>Module:</b></h6></div>
        </div>
        <div id = "auditfiltering" class="row">
          <div class="col-md-3 startdate auditfix-space">
            <h6 class="labeling"><b>Start Date:</b></h6>
            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                            <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
              <input id="startdate" type="text" readonly="" value="" size="12" class="form-control input-sm" >

            </div>
          </div>
          <div class="col-md-3 enddate auditfix-space">
              <h6 class="labeling"><b>End Date:</b></h6>
            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                            <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
              <input id="enddate" type="text" readonly="" value="" size="12" class="form-control input-sm" >

            </div>
          </div>
          <div class="col-md-2 auditfix-space">
              <h6 class="labeling"><b>User</b></h6>
            <select class="selectedusers input-sm form-control">
              <?php
                foreach ($usersdata as $data) {
                  echo '<option id='.$data['username']. '-'.$data['accessid'].'>'.$data['username'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-md-3 auditfix-space">
              <h6 class="labeling"><b>Module: </b></h6>
            <select class="selectmodule input-sm form-control">
              <option id="ALL"></option>
              <option id="CL">Master File</option>
              <option id="SK">Stockcard</option>
              <option id="SO">Sales Order</option>
              <option id="SJ">Sales Journal</option>
              <option id="CR">Cash Receipt</option>
              <option id="KR">Job Order</option>
              <option id="JO">Deposit Slip</option>
              <option id="DS">Sales Journal</option>
              <option id="CM">Sales Return</option>
              <option id="PO">Purchase Order</option>
              <option id="RR">Receiving Report</option>
              <option id="DM">Purchase Return</option>
              <option id="CV">Cash/Check Voucher</option>
              <option id="RC">Receiving Consignment</option>
              <option id="AP">Payable Voucher</option>
              <option id="AR">Payable Setup</option>
              <option id="AR">Receivable Setup</option>
              <option id="GJ">General Journal</option>
              <option id="PC">Physical Count</option>
              <option id="AJ">Inventory Adjustment</option>
              <option id="IS">Inventory Setup</option>
              <option id="TS">Transfer Slip</option>
            </select>
          </div>
          <div class="col-md-1">
            <button style="display:inline;width:100%;" class="btn btn-sm btn-success btnaudittrailok btn-flat" id="auditok">OK</button>
          </div>
        </div>
        <div class="audittraildiv"></div>
      </div>
    </div>
  </div>
</div>