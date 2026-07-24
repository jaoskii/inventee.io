<?php
$this->title = 'Collection List';
?>

<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<div class="row">
<div class="col-md-12">
        <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <!-- <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Filters</h6></b> -->
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                    <button type="button" class="btn btn-default btn-success kl-btn-new"><b><i class="fa fa-share-square-o delete_btn"></i> Create New Collection List</b></button>

                    <button style="display: none;" type="button" class="btn btn-default btn-success kl-btn-save"><b><i class="fa fa-share-square-o  delete_btn"></i> Save Collection List</b></button>

                    <button style="display: none;" type="button" class="btn btn-default btn-success kl-btn-cancel"><b><i class="fa fa-share-square-o  delete_btn"></i> Cancel Collection List</b></button>

                    <button style="display: none;" type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint"><b><i class="fa fa-print print_btn"></i> Print</b></button>
                </div>
                </div><!-- /.box-header -->
           
                <div class="box-body">
                <div class="col-md-6 col-md-push-3">
                <h6 class="agentlookup" style="display: none;"><b>Agent:  
                  <div class="input-group">
                  <input name = "agentcode" readonly="" value ="<?php if(isset($moduledata)){echo $moduledata['head']['agentcode'];}?>" type="text" class="ee txtagentcode input-sm form-control" disabled="true"><div class="frmdocumentno input-group-addon"><a class ="agentlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                  </div>
                </h6>

                <h6 class="agentlookupview"><b>Agent: <input name="agentcodeview" value ="<?php if(isset($moduledata)){echo $moduledata['head']['agentcode'];}?>" type="text" class="txtagentcodeview input-sm form-control" disabled="true"></b></h6>
                
                <h6 class="aimslabel"><b>Collection List Notes : <textarea  disabled="true" name="rem" class="moduletxt txtnotes form-control" style="resize:none;"  rows="2" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['rem'];}?></textarea></b></h6>
                </div>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->

<div class="row">
<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">AR to Collect</a></li>
              <li class=""><button style="margin-top:8%;margin-left: 5%;display: none;" class="kl-btn-addar btn btn-xs btn-flat btn-danger"><i class="fa fa-plus"></i> <b> Add AR Manually</b></button></li>
            </ul>
              
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                            <div class="box-body mod-tble">
                            <table class="table tbl-fix  bodytable table-hover">
                            <thead><tr>
                            <th class="aimslabel col-min">Option</th>
                            <th class="aimslabel col-codes">Code</th>
                            <th class="aimslabel col-description">Name</th>
                            <th class="aimslabel col-codes">Document #</th>
                            <th class="aimslabel col-min">Date</th>
                            <th class="aimslabel col-min">Due Date</th>
                            <th class="aimslabel col-currency">Debit</th>
                            <th class="aimslabel col-currency">Credit</th>
                            <th class="aimslabel col-currency">Amount</th>
                            </tr></thead>

                            <tbody class="collect-list">
                            
                            </tbody>
                            </table>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
</div>
</div>