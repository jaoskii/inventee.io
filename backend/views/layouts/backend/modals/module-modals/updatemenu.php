<!-- MODAL FOR CREATE/UPDATE MENU-->
<div class="modal fade" id="modal-updatemenu" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  	<div class="modal-dialog modal-lg" style="width: 80%; overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;">
    	<div class="modal-content">
	      	<div class="modal-header">
				<button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edit Menu</h4>
	      	</div>
      		<div class="modal-body">
      			<input type="hidden" name="menutype" class="txtmenutype updatemenutxt">
      			<input type="hidden" name="barcode" class="txtmenubarcode updatemenutxt">
      			<input type="hidden" name="itemid" class="txtmenuitemid updatemenutxt">
      			<div class="row">
      			<div class="col-md-12">
      				<div class="col-md-3">
      					<label class="aimslabel">Menu Name: </label>
      					<input type="text" name="itemname" class="updatemenutxt txtmenuname input-sm form-control">
      					<label class="aimslabel">Short Name: </label>
      					<input type="text" name="shortname" class="updatemenutxt txtmenushortname input-sm form-control">
      					<label class="aimslabel">Category: </label>
      					<div class="input-group">
                            <input name="category" readonly type="text" class="updatemenutxt txtmenucat input-sm form-control">
                            <div class="input-group-addon">
                            	<a class ="menucatlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a>
                            </div>
                            <div class="input-group-addon">
                            	<a href="#" class="btnquickaddcat"><i class="fa fa-bolt"></i></a>
                            </div>
                        </div>
      					<label class="aimslabel">Major Category: </label>
      					<div class="input-group">
                            <input name="majorcat" type="text" readonly class="updatemenutxt txtmenumajcat input-sm form-control">
                            <div class="input-group-addon">
                            	<a class ="majmenucatlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a>
                            </div>
                            <div class="input-group-addon">
                            	<a href="#" class="btnquickaddmajcat"><i class="fa fa-bolt"></i></a>
                            </div>
                        </div>
      					<label class="aimslabel">Groupings: </label>
      					<div class="input-group">
                            <input name="groupings" type="text" readonly class="updatemenutxt txtmenugroup input-sm form-control">
                            <div class="input-group-addon">
                            	<a class ="menugrouplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a>
                            </div>
                            <div class="input-group-addon">
                            	<a href="#" class="btnquickaddgroup"><i class="fa fa-bolt"></i></a>
                            </div>
                        </div>
      					<label class="aimslabel">Cost: </label>
      					<input type="text" name="cost" placeholder="0.000000" class="updatemenutxt txtmenucost input-sm form-control">
      					<label class="aimslabel">Amount: </label>
      					<input type="text" name="amt" placeholder="0.000000" class="updatemenutxt txtmenuamt input-sm form-control">
      					<label class="aimslabel">UOM: </label>
      					<input type="text" name="uom" class="updatemenutxt txtmenuuom input-sm form-control">
      					<label class="aimslabel">KDS Name: </label>
      					<input type="text" name="kds" class="updatemenutxt txtmenukds input-sm form-control">
      					<label class="aimslabel">Cooking Time (Insert Valid #): </label>
      					<input type="text" name="cooktime" class="updatemenutxt txtmenucooktime input-sm form-control">
      					<label class="aimslabel">Prep. Time  (Insert Valid #): </label>
      					<input type="text" name="preptime" class="updatemenutxt txtmenupreptime input-sm form-control">
      					<br>
      					<input type="checkbox" name="chkistaxable" id="chkistaxable" class="updatemenutxt chkistaxable">
	      				<label for="chkistaxable"><b>Taxable</b></label>
	      				&nbsp&nbsp
	      				<input type="checkbox" name="chkisinactive" id="chkisinactive" class="chkisinactive">
	      				<label for="chkisinactive"><b>Inactive</b></label>
      				</div>
      				<div class="col-md-9">
      					<div class="row">
      					<div class="choicemenuimgdiv">
      						<div class="col-md-6">
      							<label class="aimslabel">Printer 1: </label>
      							<div class="input-group">
		                            <input name="printer1" type="text" readonly class="updatemenutxt txtmenuprinter1 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter1lookup" name="printer1" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
		                        </div>
		                        <label class="aimslabel">Printer 2: </label>
		                        <div class="input-group">
		                            <input name="printer2" type="text" readonly class="updatemenutxt txtmenuprinter2 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter2lookup" name="printer2" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
		                        </div>
		                        <label class="aimslabel">Printer 3: </label>
		                        <div class="input-group">
		                            <input name="printer3" type="text" readonly class="updatemenutxt txtmenuprinter3 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter3lookup" name="printer3" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
		                        </div>
		                        <label class="aimslabel">Printer 4: </label>
		                       	<div class="input-group">
		                            <input name="printer4" type="text" readonly class="updatemenutxt txtmenuprinter4 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter4lookup" name="printer4" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
		                        </div>
		                        <label class="aimslabel">Printer 5: </label>
		                        <div class="input-group">
		                            <input name="printer5" type="text" readonly class="updatemenutxt txtmenuprinter5 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter5lookup" name="printer5" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
		                        </div>
      						</div>

      						<div class="col-md-6">
      							<div class="row">
      								<img style="width: 250px;" class="pull-right" id="choicemenuimg" src="<?= Yii::$app->homeUrl.'fimages/inventee/png/placeholder.png' ?>">
      							</div>
      							
      							<div class="row pull-right" style="margin-right: 10px;">
		  							<button class="btn btn-flat btn-sm btn-success btnsavemenuimg" style="display:none;">Save Photo</button>
				      				<button class="btn btn-flat btn-sm btn-success btnuploadmenuimg">Upload Photo</button>
				      				<input type="file" name="image" id="setmenuimg" style='display:none;'>
				      				<button class="btn btn-flat btn-sm btn-success btnremovemenuimg">Remove Photo</button>
			      				</div>
      						</div>
      						
		      			</div>
		      			</div>

		      			<div class="row" style="margin-top: 15px;">
	      					<label id="setmenutitle"><b></b></label>
	      					<div class="setmenudiv"></div>
	  						<div class="componentdiv"></div>
  						</div>
      				</div>
      			</div>
      			</div>
      		</div> <!-- END BODY -->
      		<div class="modal-footer">
      			<button type="button" class="btn btn-flat btn-primary btn-sm btnaddcomponentitem2"><i class="fa fa-plus"></i>  ADD COMPONENT</button>
      			<button type="button" class="btn btn-flat btn-primary btn-sm btnaddmenuchoice"><i class="fa fa-plus"></i>  ADD SET CHOICES</button>
				<button type="button" class="btn btn-flat btn-success btn-sm btnsavemenu"><i class="fa fa-check"></i>  SAVE</button>
				<button type="button" class="btn btn-flat btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-sign-out"></i>  CANCEL</button>
      		</div>
    	</div>
  	</div>
</div>