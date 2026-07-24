<?php
$this->title = 'Data Extractor';
?>

<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<div class="row">
<div class="col-md-12">
        <div class="box box-solid box-success">
                <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Filters</h6></b>
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                    <button type="button" data-toggle="tooltip" class="btn btn-default btn-success extrator-btn-extractdata"><b><i class="fa fa-share-square-o  delete_btn"></i> Extract Android Data</b></button>
                    <?php
                    if(Yii::$app->session['loggeduser']['access'][3126] == 1){
                        echo '<button type="button" data-toggle="tooltip" class="btn btn-default btn-success extractor-btn-clearout"><b><i class="fa fa-truck  delete_btn"></i> Clearing Out (Truck)</b></button>';
                    }//end if
                    ?>
                </div>
                </div><!-- /.box-header -->
           
                <div class="box-body">
                
                <div class="col-md-6">
                <select style="display: inline;" class="input-sm form-control extractor-filter">
                </select>
                </div>
                
                <div class="col-md-3">
                <button class="extractor-loader col-md-12 btn btn-info btn-flat">Load Filtered Data</button>
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
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Data to Extract</a></li>
            </ul>
              
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                            <div class="box-body mod-tble">
                            <table class="table tbl-fix  bodytable table-hover">
                            <thead><tr>
                            <th class="aimslabel col-description">Tablet</th>
                            <th class="aimslabel col-min">Date</th>
                            <th class="aimslabel col-min">Postdate</th>
                            <th class="aimslabel col-codes">Reference #</th>
                            <th class="aimslabel col-codes">Client</th>
                            <th class="aimslabel col-description">Clientname</th>
                            <th class="aimslabel col-codes">Itemcode</th>
                            <th class="aimslabel col-description">Item Description</th>
                            <th class="aimslabel col-min">Qty</th>
                            <th class="aimslabel col-min">UOM</th>
                            <th class="aimslabel col-currency">Amount</th>
                            <th class="aimslabel col-currency">Ext</th>
                            </tr></thead>

                            <tbody class="extraction-body">
                            
                            </tbody>
                            </table>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
</div>
</div>