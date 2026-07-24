<!-- MODAL FOR CREATE/UPDATE MENU-->
<div class="modal fade" id="modal-createmenu" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  	<div class="modal-dialog modal-md" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;">
    	<div class="modal-content">
	      	<div class="modal-header">
				<button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Create Menu</h4>
	      	</div>
      		<div class="modal-body">
      			<input type="hidden" name="menutype" class="txtmenutype createmenutxt">
      			<input type="hidden" name="barcode" class="txtmenubarcode createmenutxt">

      			<div class="row">
      			<div class="col-md-12">
      				<label class="aimslabel">Category: </label>
      				<div class="input-group">
                        <input name="category" readonly type="text" class="managereq createmenutxt txtmenucat input-sm form-control">
                        <div class="input-group-addon"><a class ="menucatlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                        <div class="input-group-addon"><a href="#" class="btnquickaddcat"><i class="fa fa-bolt"></i></a></div>
                    </div>

                    <label class="aimslabel">Major Category: </label>
                    <div class="input-group">
                        <input name="majorcat" type="text" readonly class="createmenutxt txtmenumajcat input-sm form-control">
                        <div class="input-group-addon"><a class ="majmenucatlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                        <div class="input-group-addon"><a href="#" class="btnquickaddmajcat"><i class="fa fa-bolt"></i></a></div>
                    </div>

                    <label class="aimslabel">Menu Name: </label>
                    <div class="input-group">
						<input type="text" name="itemname" class="managereq createmenutxt txtmenuname input-sm form-control">
						<div class="input-group-addon"><a class ="stockcardlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
					</div>

					<label class="aimslabel">Short Name: </label>
					<input type="text" name="shortname" class="managereq createmenutxt txtmenushortname input-sm form-control">

					<label class="aimslabel">Groupings: </label>
					<div class="input-group">
                        <input name="groupings" type="text" readonly class="createmenutxt txtmenugroup input-sm form-control">
                        <div class="input-group-addon"><a class ="menugrouplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                        <div class="input-group-addon"><a href="#" class="btnquickaddgroup"><i class="fa fa-bolt"></i></a></div>
                    </div>

                    <label class="aimslabel">Unit of Measurement: </label>
                    <input type="text" name="uom" class="managereq createmenutxt txtmenuitemuom input-sm form-control">

                    <label class="aimslabel">Cost: </label>
                    <input type="text" name="cost" placeholder="0.000000" class="createmenutxt txtmenucost input-sm form-control">

                    <label class="aimslabel">Amount(SRP): </label>
                    <input type="text" name="amt" placeholder="0.000000" class="createmenutxt input-sm form-control">

                    <label class="aimslabel">KDS Name: </label>
                    <input type="text" name="kds" class="createmenutxt input-sm form-control">

                    <label class="aimslabel">Cooking Time (Insert Valid #): </label>
                    <input type="text" name="cooktime" class="createmenutxt input-sm form-control">
                    
                    <label class="aimslabel">Preparation Time (Insert Valid #): </label>
                    <input type="text" name="preptime" class="createmenutxt input-sm form-control">

					<br>
                    <input class= "createmenutxt" type="checkbox" name="chkistaxable" id="chkistaxable">
                    <label for="chkistaxable" class="aimslabel"><b>Taxable</b></label>
                    <br>

                    <label class="aimslabel">Printer 1: </label>
                    <div class="input-group">
                        <input name="printer1" type="text" readonly class="createmenutxt txtmenuprinter1 input-sm form-control">
                        <div class="input-group-addon"><a class ="menuprinter1lookup" name="printer1" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                        <div class="input-group-addon"><a href="#" class="btnquickaddprinter"><i class="fa fa-bolt"></i></a></div>
                    </div>

                    <label class="aimslabel">Printer 2: </label>
                    <div class="input-group">
                        <input name="printer2" type="text" readonly class="createmenutxt txtmenuprinter2 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter2lookup" name="printer2" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                    </div>

                    <label class="aimslabel">Printer 3: </label>
                    <div class="input-group">
                        <input name="printer3" type="text" readonly class="createmenutxt txtmenuprinter3 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter3lookup" name="printer3" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                    </div>

                    <label class="aimslabel">Printer 4: </label>
                    <div class="input-group">
                        <input name="printer4" type="text" readonly class="createmenutxt txtmenuprinter4 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter4lookup" name="printer4" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                    </div>

                    <label class="aimslabel">Printer 5: </label>
                    <div class="input-group">
                        <input name="printer5" type="text" readonly class="createmenutxt txtmenuprinter5 input-sm form-control"><div class="input-group-addon"><a class ="menuprinter5lookup" name="printer5" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                    </div>
                </div>
      			</div>
      		</div> <!-- END BODY -->

      		<div class="modal-footer">        
				<button type="button" class="btn btn-flat btn-success btn-sm btnsavemenu"><i class="fa fa-check"></i>  SAVE</button>
				<button type="button" class="btn btn-flat btn-success btn-sm" data-dismiss="modal"><i class="fa fa-sign-out"></i>  CANCEL</button>
      		</div>
    	</div>
  	</div>
</div>