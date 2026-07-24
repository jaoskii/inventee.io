<?php
use yii\helpers\Url;
$this->title = 'Production Update / JO Update';
?>

<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

<div class="row">
	<div class="col-md-12">
		<div class="box">
        <!-- /.box-header -->
        <div class="box-body">
        	<div class="col-md-4">
        		<h6 class="aimslabel"><b>Process 
                <div class="input-group">
                    <input readonly value ="" type="text" class="jbuprocsearch input-sm form-control"><div class="input-group-addon">
                    <a class ="jbu_procsearch" href="#">
                    	<i class="fa fa-chevron-circle-down"></i>
                    </a></div>
                </div></h6>
        	</div>

        	<div class="col-md-8">
        		<label>Enter JO #:</label>
        		<input name="enterjo" value ="" type="text" class="txtenterjo form-control input-sm">
        	</div>
        </div> <!-- END BOX BODY -->
      </div> <!-- END BOX  -->
	</div> <!-- END COL MD 12 -->

	
	<div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
          	<label class="aimslabel">List of JO without Breakdown Report</label>
          	</div>
	        <div class="box-body">
				<div id="jodocuments_grid" class="box box-solid box-success"></div>
	        </div> <!-- END BOX BODY -->
      	</div> <!-- END BOX  -->
	</div> <!-- END COL MD 4 -->

	<div class="col-md-8">
		<div class="box box-solid box-success">
        <!-- /.box-header -->
        <div class="box-header with-border">
      	<label class="aimslabel">JO Header</label>
      	</div>
        <div class="box-body">
	        	                
	                <div class="invoice-info col-md-12" style="margin-left:-15px;">
	                <div class="invoice-col col-md-3">
		                <h6 class="aimslabel"><b>Document #:  
		                <input name = "docno" value ="" type="text" readonly class="fbutxt input-sm form-control">
		                </h6>
		                
		                <h6 class="aimslabel" style="display:none;"><b>Customer Code: 
		                <input name = "client" value =""  type="text" readonly class="fbutxt form-control input-sm"></b>
		            	</h6>
		                
		                <h6 class="aimslabel"><b>Customer: 
		                <input name="clientname" value ="" type="text" readonly class="fbutxt form-control input-sm"></b>
		            	</h6>

		                <h6 class="aimslabel"><b>Ship to: 
		                <input name="shipto" value="" type="text" readonly class="fbutxt form-control input-sm"></b>
		                </h6>

		                <h6 class="aimslabel"><b>Date: 
	                  	<input type="text" name = "dateid" value="" readonly class="fbutxt form-control input-sm">
	                  	</h6>
	                </div><!-- /.col -->
	                
	                <div class="invoice-col col-md-3">
		                <h6 class="aimslabel"><b>Your Ref: 
		                <input name = "yourref" value ="" type="text" class="fbutxt form-control input-sm" readonly></b>
		            	</h6>

		                <h6 class="aimslabel"><b>Our Ref: 
		                <input name="ourref" value ="" type="text" class="fbutxt form-control input-sm" readonly></b>
		                </h6>

		                <h6 class="aimslabel"><b>Sales type:
		                <input name="salestype" readonly value ="" type="text" class="fbutxt form-control input-sm">
		                </h6>

		                <h6 class="aimslabel whcodeview"><b>Warehouse :</b>
	                	<input readonly name="whid" value ="" type="text" class="fbutxt form-control input-sm">
	            		</h6>
	                </div><!-- /.col -->
	                
	                <div class="invoice-col col-md-3">

	                <h6 class="aimslabel"><b>Trnx type:
	                  <input name="trnx_type" readonly value ="" type="text" class="fbutxt form-control input-sm">
	                </h6>

	                <h6 class="aimslabel"><b>Notes: <textarea readonly name="rem" class="fbutxt form-control input-sm" style="resize:none;"  rows="5" cols="50"></textarea></b></h6>
	                </div><!-- /.col -->

	                <div class="invoice-col col-md-3">

	                  <h6 class="aimslabel dateidview"><b>Required Date:</b>
	                  <input name="reqdate" readonly value ="" type="text" class="fbutxt form-control input-sm">
	              	  </h6>

	                  <h6 class="aimslabel"><b>Withdrawal #: 
	                  <input readonly name="withdrawnum" value ="" type="text" class="fbutxt form-control input-sm"></b>
	                  </h6>

	                  <h6 class="aimslabel"><b>Equipment Release #: 
	                  <input readonly name="equipreleasenum" value ="" type="text" class="fbutxt form-control input-sm"></b>
	                  </h6>
	                  
	                </div>
	                </div>
	    </div> <!-- END BOX BODY -->
	    </div> <!-- END BOX  -->

		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" class="clickable tab_jbu_joitems" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">JO Items</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" class="clickable tab_jbu_materials" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Materials Used</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" class="clickable tab_jbu_processes" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Processes</a></li>
            </ul>
              
           <div class="tab-content">
				<div class="tab-pane active" id="tab_1">
	                <div class="row">
	                    <div class="col-md-12">
	                      <div id="joitems_grid" class="box box-solid box-success"></div>
	                    </div>
	                </div>
	            </div> <!-- END TAB PANE 1 -->

	            <div class="tab-pane" id="tab_2">
	                <div class="row">
	                    <div class="col-md-12">
	                      <div id="materialused_grid" class="box box-solid box-success"></div>
	                    </div>
	                </div>
	            </div> <!-- END TAB PANE 2 -->

	            <div class="tab-pane" id="tab_3">
	                <div class="row">
	                    <div class="col-md-12">
	                      <div id="processes_grid" class="box box-solid box-success"></div>
	                    </div>
	                </div>
	            </div> <!-- END TAB PANE 2 -->
           </div> <!-- END TAB CONTENT -->
        </div> <!-- END NAV TAB CUSTOM -->
	</div> <!-- END COL MD 8 -->
</div>