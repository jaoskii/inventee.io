<?php
use yii\helpers\Url;
$this->title = 'Quick Collection Utility';
try {
?>
<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <div class="btn-group">
        </div>
        <div class="pull-right">
             <div class="btn-group">
              <button class="btn btn-default btn-success headbtn btnactive quickcollectgenerate"><b><i class="fa fa-file new_btn"></i> Generate Collection Document</b></button>
              <button class="btn btn-default btn-success headbtn btnactive quickcollectunpaid"><b><i class="fa fa-tag new_btn"></i> Retrieve Unpaid Accounts</b></button>
            </div>
        </div><!-- /.box-tools -->
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="pull-right" style="margin-top:-15px;"></div>
          <div class="invoice-info col-md-12" style="margin-left:-15px;">
            
            <div class="invoice-col col-md-4">
                <h6 class="aimslabel clientcodelookup"><b>Customer Code: 
                  <div class="input-group">
                    <input name = "client" value =""  type="text" class="moduletxt txtclientcode form-control input-sm" disabled="true"></b>
                    <div class="clientlookupbtn input-group-addon"><a class ="clientlookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div>
                  </div>
                </h6>

                <h6 class="aimslabel"><b>Customer: <input name="clientname" value ="" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b>
                </h6>

                <h6 class="aimslabel dateidlookup"><b>Date: 
                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                    <input type="text" name = "dateid" readonly="" value="<?php echo date('Y-m-d');?>" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                    <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                  </div></b>
                </h6>
            </div><!-- /.col -->
                
                <div class="invoice-col col-md-4">
                  <h6 class="aimslabel"><b>Address: 
                    <textarea name="addr" class="moduletxt txtclientaddress form-control" style="resize:none;font-size:13px;" rows="2" cols="50"></textarea></b>
                  </h6>

                  <h6 class="aimslabel"><b>Notes: 
                    <textarea name="rem" class="moduletxt txtnotes form-control" style="resize:none;"  rows="2" cols="50"></textarea></b>
                  </h6>
                </div><!-- /.col -->
                
                <!-- DATE -->
                <div class="invoice-col col-md-4">
                    <h6 class="aimslabel clientcodelookup"><b>Collection Type: 
                    <div class="input-group">
                      <input name = "collectiontype" value =""  type="text" class="moduletxt txtcollectiontype form-control input-sm" disabled="true"></b>
                      <div class="input-group-addon"><a class ="colltypelookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div>
                    </div></h6>

                    <h6 class="aimslabel clientcodelookup"><b>Payment Type: 
                    <div class="input-group">
                      <input name = "paymenttype" value =""  type="text" class="moduletxt txtpaymenttype form-control input-sm" disabled="true"></b>
                      <div class="input-group-addon"><a class ="paymenttypelookup" href="#"><i class="fa  fa-chevron-circle-down"></i></a></div>
                    </div></h6>

                    <h6 class="aimslabel"><b>Amount: <input name="amt" value ="" type="text" class="moduletxt txtquickamt form-control input-sm"></b></h6>

                    <button class="btn btn-success quickcollectaddentry" style="width: 100%;height: 40px;">Add Entries</button>
                </div><!-- /.col -->


              </div>
        </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
</div>

<?php

    
} catch (ErrorException $e) {
    echo $e;
}

?>

<div class="row">
<div class="col-md-12">
     
                  <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>

              <li class="pull-right"><h6 class="txttotalcr" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL CREDIT: <?php if(isset($moduledata)){echo number_format($moduledata['head']['totalcr'],Yii::$app->systemsettings->setDecimaldisplay('currency'));} ?></h6></li>

              <li class="pull-right"><h6 class="txttotaldb" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL DEBIT: <?php if(isset($moduledata)){echo number_format($moduledata['head']['totaldb'],Yii::$app->systemsettings->setDecimaldisplay('currency'));} ?></h6></li>

            </ul>
              
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        echo '<div id="modulestockview" class="box box-solid box-success"></div>'
                      ?>
                    </div>
                  </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
</div>
</div>
