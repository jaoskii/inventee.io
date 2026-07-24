<?php
use yii\helpers\Url;
$this->title = 'Bank Reconciliation';
?>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="savingtype" value="">
<input type = "hidden" id ="lines" value="">
<div class="col-md-12">
  <div class="box box-solid box-success">
  <div class="modulehead box-header with-border">
    <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">BANK RECONCILATION</h6></b>
    <div class="pull-right">
    <!-- BEGIN BTN GROUP -->
      <div class= "btn-group">
        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnbaladj mainbtn"><b><i class="fa fa-university"></i> BAL. & ADJ.</b></button>
        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnbanksum mainbtn"><b><i class="fa fa-university"></i> BANK RECON SUMM.</b></button>
        <button type="button mainbtn" class="btn btn-default btn-success headbtn btnactive module-btnbankbook mainbtn"><b><i class="fa fa-university"></i> BANK B00K</b></button>

        <button type="button" class="btn btn-default btn-success headbtn module-btnrefreshbrecon" style="display: none;"><b><i class="fa fa-eye"></i> View</b></button>
        <button type="button" class="btn btn-default btn-success headbtn module-btnsavebrecon" style="display: none;"><b><i class="fa fa-save"></i> Reconcile</b></button>
        <button type="button" class="btn btn-default btn-success headbtn module-btncancelbrcon" style="display: none;"><b><i class="fa fa-times" ></i> Back</b></button>
        <!--<button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancelbrcon2" style="display: none;"><b><i class="fa fa-times" ></i> Cancel</b></button>
        <button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancelbrcon3" style="display: none;"><b><i class="fa fa-times" ></i> Cancel</b></button>-->
      </div><!-- <div class="btn-group"> -->
    </div><!-- <div class="pull-right"> -->
  </div>
  <div class="box-body">
      <h6 class="txtasof" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;"><b>Reconcile date as of:&nbsp;<input type="label" class="txtasof" value="<?php echo date('m/d/Y'); ?>" style="background-color: transparent; border: none; color: red;" readonly></b></h6>
      <h6 id="txtreconbal" style="display:inline;"><b>Ending Balance:&nbsp;<input type="label" class="txtbreconbal" value="0" style="background-color: transparent; border: none; color: red;" readonly></b></h6>
      <h6 id="txtunclear" style="display:inline;"><b>Uncleared: &nbsp;<input type="label" class="txtunclearbal" value="0" style="background-color: transparent; border: none; color: red;" readonly></b></h6>
      <hr>

      <div class="mod-clearfilter">
          <!-- CLEARING -->
            <div id = "auditfiltering" class="row">
              <div class="col-md-2 enddate">
                <b>Account:</b>
                  <div class="input-group">
                      <input id ="contra" name="contra" value="" type="text" placeholder="Account #" class="moduletxt txtcontra form-control input-sm">
                      <div class="input-group-addon"><a class ="btnshowcontra" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                  </div>
              </div>

              <div class="col-md-2 startdate">
                <b>Start date:</b>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                    <input id="startdate" name ="startdate" type="text" placeholder="Start Date" readonly="" value="" size="12" class="form-control input-sm" >
                    <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                  </div>
              </div>

              <div class="col-md-2 enddate">
                <b>End date:</b>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                  <input id="enddate" name="enddate" type="text" placeholder="End Date" readonly="" value="" size="12" class="form-control input-sm" >
                  <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                </div>
              </div>

              <div class="col-md-2 cleardate">
                <b>Clear date:</b>
                <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                  <input id="cleardate" name="cleardate" type="text" placeholder="Clear Date" readonly="" value="" size="12" class="form-control input-sm" >
                  <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
                </div>
              </div>
          <!-- END CLEARING -->

              <div class="col-md-3 btngrid">
                <button style="display: inline;" class="btn btn-success btnbreconok">REFRESH</button>
                <button style="display: inline;" class="btn btn-success btnbreconclear" >SAVE</button>
              </div><!-- end  class="col-md-3 -->
              <div class="col-md-3 divbanksum" style="display:none;">
                <button  class="btn btn-success btnbreconok2">REFRESH</button>
              </div>  
            </div><!-- <div id = "auditfiltering" class="row"> -->
        </div><!-- <div class="box-body mod-clearfilter"> -->


        <div class="mod-gridtable mod-tble mod-tbleaudittrail">
          <table id ="displayview" class="table tbl-fix bodytable">
              <thead>
                <tr>
                    <th class="col-min aimslabel"><span class="text">Option</span></th>
                    <th class="col-min aimslabel"><span class="text">Transaction Date</span></th>
                    <th class="col-codes aimslabel"><span class="text">Clear Day</span></th>
                    <th class="col-min aimslabel"><span class="text">Check Date</span></th>
                    <th class="col-codes aimslabel"><span class="text">Check #</span></th>
                    <th class="col-currency aimslabel"><span class="text">Withdrawal</span></th>                    
                    <th class="col-currency aimslabel"><span class="text">Deposit</span></th>
                    <th class="col-currency aimslabel"><span class="text">Balance</span></th>
                    <th class="col-codes aimslabel"><span class="text">Document #</span></th>
                    <th class="col-description aimslabel"><span class="text">Client Name</span></th>                    
                    <th class="col-description aimslabel"><span class="text">Remarks</span></th>                                        
                </tr>
            </thead>
              <tbody id="brecon-modulebody" class="brecon-modulebody">

              
              </tbody>
          </table>
        </div><!-- <div class="box-body mod-gridtable"> -->

        <!-- BAL&ADJ. -->
        <div id = "brecontxt" style="display: none;" class="invoice-col">
          <div class="row">
            <div class="col-md-6" >
            <b><h6 style="font-size:12px;font-weight:bold;">BASED ON PASSBOOK</h6></b>
            <h6 style="width: 230px;" class="aimslabel3" ><b>Beg. Balance: <input name="begbal" value ="" type="text" class="moduletxt baladj txtbegbal form-control input-sm" ></b></h6>

            <h6 style="width: 230px;" class="aimslabel3" ><b>Ending Balance: <input name="endbal" value ="" type="text" class="moduletxt baladj txtendbal form-control input-sm" ></b></h6><br>

            <b><h6 style="font-size:12px;font-weight:bold;">RECONCILED</h6></b>
            <h6 style="width: 230px;" class="aimslabel3" ><b>Cleared Balance: <input name="clearbal" value ="" type="text" class="moduletxt baladj txtclearbal form-control input-sm" ></b></h6>

            <h6 style="width: 230px;" class="aimslabel3" ><b>Difference: <input name="diff" value ="" type="text" class="moduletxt baladj txtdiff form-control input-sm" ></b></h6>
            </div>

            <div class="col-md-6">
            <b><h6 style="font-size:12px;font-weight:bold;">EARNED AND CHARGES</h6></b>
            <h6 style="width: 230px;" class="aimslabel3" ><b>Interest Earned: <input name="interest" value ="" type="text" class="moduletxt baladj txtinterest form-control input-sm" ></b></h6>

            <h6 style="width: 230px;" class="aimslabel3" ><b>Deduction: <input name="deductions" value ="" type="text" class="moduletxt baladj txtdeductions form-control input-sm" ></b></h6><br>

            <b><h6 style="font-size:12px;font-weight:bold;">ITEMS MARKED CLEARED</h6></b>
            <h6 style="width: 230px;" class="aimslabel3" ><b>Deposit: <input id="deposit" name="deposit" value ="" type="text" class="moduletxt baladj txtdeposit form-control input-sm" disabled></b></h6>

            <h6 style="width: 230px;" class="aimslabel3" ><b>Withdrawal: <input id="withdraw" name="withdraw" value ="" type="text" class="moduletxt baladj txtwithdraw form-control input-sm" disabled></b></h6>
            </div>
          </div>
        </div> <!-- <div id = "brecontxt" style="display: none;" class="invoice-col"> -->
        <!-- END BAL&ADJ. -->    

        <div id = "bbookfilter" style="display: none;" class="bbookfilter row">
          <!-- BANK BOOK FILTER -->
          <form action="<?php echo Url::to(['/reports/default/modulereportbankrecon/']); ?>" method="POST" target="_blank">            
            <div style="margin-top: -5px;" class="col-md-2">
              <label class="aimslabel">Gather by:</label>
              <select id="gatherby" name="gatherby" class="gatherby input-sm form-control">
                <option value="dateid">Trnx Date</option>
                <option value="checkdate">Check Date</option>
                <option value="clearday">Clear Day</option>
              </select></b>            
            </div>

            <div class="col-md-2 contra">
            <br>
                <div class="input-group">
                    <input id ="contra2" name="contra" value="" type="text" placeholder="Account #" class="moduletxt txtcontra form-control input-sm">
                    <div class="input-group-addon"><a class ="btnshowcontra" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                </div>
            </div>

            <div class="col-md-2 startdate">
            <br>
              <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <input id="startdate2" name="startdate" type="text" placeholder="Start Date" readonly="" value="" size="12" class="form-control input-sm" >
                <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
              </div>
            </div>

            <div class="col-md-2 enddate">
            <br>
              <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date=""  class="paedit input-group date dpYears">
                <input id="enddate2" name="enddate" type="text" placeholder="End Date" readonly="" value="" size="12" class="form-control input-sm" >
                <div class="dateid-lookup input-group-addon add-on" ><a href="#" ><i class="fa fa-chevron-circle-down" ></i></a></div>
              </div>
            </div>

            

        
          <div class="col-md-1">
          <br>
            <button style="display: block;" class="btn btn-sm btn-success btnprintbankrecon">PRINT DATA</button>
          </div>
        </form>
        <div class="col-md-1">
          <br>
            <button style="display: block;" class="btn btn-sm btn-success btnbreconok3" id ="auditok">REFRESH</button>
          </div>
        </div>   <!-- <div id = "bbookfilter" style="display: none;" class="row"> -->
        
        <br>
        <div id = "bbookfilter" style="display: none;" class="bbookfilter row">
          <div class="col-md-2 searching">
                <input id="searching" placeholder="Search" type="text" value="" size="12" class="form-control input-sm" >
                 
          </div>

          <div class="col-md-10">
            <button style="display: inline;" class="btn btn-sm btn-success btnsearchcheck" id ="auditok">Seach by Check No.</button>
            <button style="display: inline;" class="btn btn-sm btn-success btnsearchclient" id ="auditok">Search by client name</button>
          </div>
        </div>

        <!-- END BANK BOOK -->
        

        <div class="mod-tblbankbook mod-tble mod-tbleaudittrail" style="display:none;">
          <table id ="bankbook"  class="table tbl-fix bodytable">
            <thead>
              <tr>
                  <th class="col-min aimslabel"><span class="text">Transaction Date</span></th>
                  <th class="col-min aimslabel"><span class="text">Clear Day</span></th>
                  <th class="col-min aimslabel"><span class="text">Check Date</span></th>
                  <th class="col-codes aimslabel"><span class="text">Check #</span></th>
                  <th class="col-currency aimslabel"><span class="text">Withdrawal</span></th>
                  <th class="col-currency aimslabel"><span class="text">Deposit</span></th>
                  <th class="col-currency aimslabel"><span class="text">Balance</span></th>
                  <th class="col-codes aimslabel"><span class="text">Document #</span></th>
                  <th class="col-description aimslabel"><span class="text">Client Name</span></th>                  
                  <th class="col-description aimslabel"><span class="text">Remarks</span></th>
              </tr>
            </thead>
            <tbody id="bankbook-modulebody" class="bankbook-modulebody">

            
            </tbody>
          </table>
        </div>


        <div id = "banksumfilter" style="display:none;">
          <!--<div class="col-md-3 enddate">
            <div class="input-group">
              <input id ="contra3" name="contra" value="" type="text" placeholder="Account #" class="moduletxt txtcontra form-control input-sm">
              <div class="input-group-addon"><a class ="btnshowcontra" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
            </div>
          </div>-->

          <!--<div class="col-md-3 startdate">
            <input name = "bank" value="" type="text" disabled=true class="txtbankcontraname moduletxt form-control input-sm">
          </div>
          <div class="col-md-3">
            <button style="display: inline;" class="btn btn-success btnbreconok2" id ="auditok">REFRESH</button>
          </div>   -->     

        </div><!-- <div id = "banksumfilter" style="display:none;"class="row"> -->

        <div class="mod-tblbanksum mod-tble" style="display:none;">
          <table id="banksum"  class="table tbl-fix bodytable">
            <thead>
              <tr>
                  <th class="col-codes aimslabel"><span class="text">Date</span></th>
                  <th class="col-codes aimslabel"><span class="text">Balance</span></th>
                  <th class="col-codes aimslabel"><span class="text">Adjust</span></th>
              </tr>

            </thead>
            <tbody id="banksum-modulebody" class="banksum-modulebody">
            
            </tbody>
          </table>
        </div><!-- <div class="box-body mod-tblbanksum"> -->
  </div>
  </div>
</div>
</div>
    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
