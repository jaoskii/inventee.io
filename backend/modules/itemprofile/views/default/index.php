<?php
$this->title = 'Item Profile';
?>

<div class="row">
	<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
	<input type = "hidden" id ="itemid" name ="itemid" class="moduletxt" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemid'];} ?>">


        <div class="col-md-12">
            <div class="box box-solid box-success">
              	<div class="modulehead box-header with-border">

                  	<b><h6 class="txtitemid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Item ID: <?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemid'];} ?></h6></b>

                  	<div class="pull-right">
                      	<div class="btn-group">
	                      	<?php if(!empty($stockcarddata[0]['itemid'])){?>
	                        	<button type="button" data-toggle="tooltip" title="New Item" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
	                        	<button type="button" data-toggle="tooltip" title="Save Item" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
	                     		<?php
                            		echo'<button type="button" data-toggle="tooltip" title="Edit Item" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                         		?>
                        		<button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
                        		<button type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> Print</b></button>

                         		<?php
                          			echo'<button type="button" data-toggle="tooltip" title="Delete Item" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>';
                         		?>

                        		<button type="button" data-toggle="tooltip" title="Item Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> Logs</b></button>


                       			<button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        		<button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        		<button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        		<button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>

                      			<?php 
                      		}else{ ?>

                        		<button type="button" data-toggle="tooltip" title="New Item" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        		<button type="button" data-toggle="tooltip" title="Save Item" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                        		<button disabled="true" type="button" data-toggle="tooltip" title="Edit Item" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>
                        		<button type="button" data-toggle="tooltip" title="Cancel" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
                        		<button disabled="true" type="button" data-toggle="tooltip" title="Print" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> Print</b></button>
                        		<button disabled="true" type="button" data-toggle="tooltip" title="Delete Item" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                        		<button disabled="true" type="button" data-toggle="tooltip" title="Item Logs" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> Logs</b></button>


                       			<button disabled="true" id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        		<button disabled="true" id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        		<button disabled="true"id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        		<button disabled="true" id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                      		 	<?php 
                      		 } ?>
                      	</div>

                   	</div><!-- /.box-tools -->

            	</div><!-- /.box-header -->

                <div class="box-body">
                    <div class="pull-right" style="margin-top:-15px;">

                    </div>
                    <div class="invoice-info col-md-12" style="margin-left:-15px;">

                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Tag Code:  
                                <div class="input-group">
                                    <input name = "barcode" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['barcode'];}?>" type="text" class="moduletxt txtbarcode input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="stockcardlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>                        

							<h6 class="aimslabel"><b>Item Code:  
                                <div class="input-group">
                                    <input disabled="true" name = "bcode" id="txtbcode" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['bcode'];}?>" type="text" class="moduletxt txtbcode input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="genitemlookup proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                </div>
                            </h6>                     

                            <h6 class="aimslabel"><b>Description: <textarea  disabled="true" name="itemname" id="txtitemname" class="moduletxt txtitemname form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemname'];}?></textarea></b></h6>

   							<h6 class="aimslabel" style="display:block;">
                                <b>Shortname: <input name="shortname" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['shortname'];}?>" type="text" id="txtshortname" class="moduletxt txtshortname form-control input-sm" disabled="true"></b>
                            </h6>

                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel" style="display:block;">
                                <b>Group: <input name="groupid" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['groupid'];}?>" type="text" id="txtgroupid" class="moduletxt txtgroupid form-control input-sm" disabled="true"></b>
                            </h6>                             

                            <h6 class="aimslabel" style="display:block;">
                                <b>Sub Group:  <input name="category" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['category'];}?>" type="text" class="moduletxt txtcategory form-control input-sm" disabled="true"></b>
                            </h6>                                                         

                            <h6 class="aimslabel" style="display:block;">
                                <b>Model:  <input name="model" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['model'];}?>" type="text" id="txtmodel" class="moduletxt txtmodel form-control input-sm" disabled="true"></b>
                            </h6>         

                            <h6 class="aimslabel" style="display:block;">
                                <b>Brand:  <input name="brand" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['brand'];}?>" type="text" id="txtbrand" class="moduletxt txtbrand form-control input-sm" disabled="true"></b>
                            </h6>                                                     

                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel" style="display:block;">
                                <b>Color:  <input name="color" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['color'];}?>" type="text" id="txtcolor" class="moduletxt txtcolor form-control input-sm" disabled="true"></b>
                            </h6>                                                     

                            <h6 class="aimslabel" style="display:block;">
                                <b>Part No.: <input name="part" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['part'];}?>" type="text" id="txtpart" class="moduletxt txtpart form-control input-sm" disabled="true"></b>
                            </h6>        

                            <h6 class="aimslabel" style="display:block;">
                                <b>Classification:   <input name="class" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['class'];}?>" type="text" id="txtclass" class="moduletxt txtclass form-control input-sm" disabled="true"></b>
                            </h6>                                    

                            <h6 class="aimslabel" style="display:block;">
                                <b>Serial No.: <input name="subcode" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['subcode'];}?>" type="text" class="moduletxt txtsubcode form-control input-sm" disabled="true"></b>
                            </h6>                      

                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel" style="display:block;">
                                <b>Size: <input name="sizeid" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['sizeid'];}?>" type="text" id="txtsizeid" class="moduletxt txtsizeid form-control input-sm" disabled="true"></b>
                            </h6>                         

                            <h6 class="aimslabel"><b>Notes: <textarea  disabled="true" name="itemrem" class="moduletxt txtitemrem form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemrem'];}?></textarea></b></h6>
                            
                        </div><!-- /.col -->

                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>


<div class="row">
<div class="col-md-12">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs bg-green">
          	<li class="active" id="clickprop"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Properties</a></li>

          	<li id="clickacquisition"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Acquisition</a></li>          	      	

          	<li id="clicklocation"><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Current Location</a></li>             	

          	<li id="clickvehicle"><a href="#tab_4" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Vehicle information</a></li>              	
    </div>    

	<div class="tab-content">

        <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid box-success">
                        <div class="box-body">  

                            <div class="invoice-col col-md-2">
                                <h6 class="aimslabel picbox">
                                    <?php 
                                        if(isset($stockcarddata)){
                                            if(empty($stockcarddata[0]['picture'])){
                                                $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                            }else{
                                                $str = $stockcarddata[0]['picture'];
                                            }
                                        }else{
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" class="thumbnail recordpicture">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form id ="picupload" method="POST" enctype="multipart/form-data">
                                        <span id="fileselector">
                                            <label class="btn btn-default" for="upload-file-selector" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                                <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture">
                                                <i class="fa fa-upload margin-correction"></i>Browse Pic
                                            </label>
                                        </span>

                                        <button type = "submit" class="uploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                        <button type = "button" class="uploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                </h6>
                            </div>

                            <div class="invoice-col col-md-1">
                                <h6 class="aimslabel"><b>Condtion: </b></h6>
                                
                                <input disabled="true" name = "isnew" style="margin-left:7px;" class ="itemboxes isnew" type="checkbox"
                                    <?php if(isset($stockcarddata[0]['isnew'])){
                                      if($stockcarddata[0]['isnew'] == 1){
                                        echo "checked";
                                      }
                                    }
                                    ?>>&nbsp<label>New </label></br>

                                <input disabled="true" name = "isused" style="margin-left:7px;" class ="itemboxes isused" type="checkbox"
                                    <?php if(isset($stockcarddata[0]['isused'])){
                                        if($stockcarddata[0]['isused'] == 1){
                                            echo "checked";
                                        }
                                    }
                                    ?>>&nbsp<label>Used </label></br>

                                <input disabled="true" name = "islease" style="margin-left:7px;" class ="itemboxes islease" type="checkbox"
                                    <?php if(isset($stockcarddata[0]['islease'])){
                                        if($stockcarddata[0]['islease'] == 1){
                                            echo "checked";
                                        }
                                    }
                                    ?>>&nbsp<label>Lease </label></br>    
                                                                                   
                            </div>

                            <div class="invoice-col col-md-2">   

                               <h6 class="aimslabel" style="display:block;">
                                    <b>Disposal Date: <input name="dtedisposal" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['dtedisposal'];}?>" type="text" class="moduletxt txtdtedisposal form-control input-sm" disabled="true"></b>
                                </h6> 

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Basis <input name="depamt" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['depamt'];}?>" type="text" class="moduletxt txtdepamt form-control input-sm" disabled="true"></b>
                                </h6>       

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Salvage<input name="depsalvage" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['depsalvage'];}?>" type="text" class="moduletxt txtdepsalvage form-control input-sm" disabled="true"></b>
                                </h6>    
                                                                                                                    
                            </div>

                            <div class="invoice-col col-md-2">  
                                <h6 class="aimslabel" style="display:block;">
                                    <b>day(s)<input name="daydisposal" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['daydisposal'];}?>" type="text" class="moduletxt txtdaydisposal form-control input-sm" disabled="true"></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>year(s) <input name="deplife" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['deplife'];}?>" type="text" class="moduletxt txtdeplife form-control input-sm" disabled="true"></b>
                                </h6>   
                            </div>      

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </div>  

        <div class="tab-pane" id="tab_2">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid box-success">
                        <div class="box-body">

                            <div class="invoice-col col-md-2">

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Acquisition Date: <input name="dteacq" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['dteacq'];}?>" type="text" class="moduletxt txtdteacq form-control input-sm" disabled="true"></b>
                                </h6>                               

                                <h6 class="aimslabel" style="display:block;">
                                    <b>year(s) <input name="acqyr" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['acqyr'];}?>" type="text" class="moduletxt txtacqyr form-control input-sm" disabled="true"></b>
                                </h6>                                                               
                            </div>

                            <div class="invoice-col col-md-3">  
                                <h6 class="aimslabel"><b>Supplier:  
                                    <div class="input-group">
                                        <input disabled="true" name = "supp" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['supp'];}?>" type="text" id="txtsupp" class="moduletxt txtsupp input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;"  class ="clientlookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    </div></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Supplier Name <input name="suppname" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['suppname'];}?>" type="text" id="txtsuppname" class="moduletxt txtsuppname form-control input-sm" disabled="true"></b>
                                </h6>     

                                <h6 class="aimslabel"><b>Purchaser:  
                                    <div class="input-group">
                                        <input disabled="true" name = "buyer" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['buyer'];}?>" type="text" id="txtbuyer" class="moduletxt txtbuyer input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="emplookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    </div></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Purchaser Name <input name="buyername" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['buyername'];}?>" type="text" id="txtbuyername" class="moduletxt txtbuyername form-control input-sm" disabled="true"></b>
                                </h6>                                                                                           
                            </div>

                            <div class="invoice-col col-md-2">

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Invoice Date: <input name="dteinv" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['dteinv'];}?>" type="text" class="moduletxt txtdteinv form-control input-sm" disabled="true"></b>
                                </h6>                               

                                <h6 class="aimslabel" style="display:block;">
                                    <b>PO Date: <input name="dtepo" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['dtepo'];}?>" type="text" class="moduletxt txtdtepo form-control input-sm" disabled="true"></b>
                                </h6>                               
                                  
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Warranty Date: <input name="dtewarranty" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['dtewarranty'];}?>" type="text" class="moduletxt txtdtewarranty form-control input-sm" disabled="true"></b>
                                </h6>                               
                                                                
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Lease Date:  <input name="dtelease" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['dtelease'];}?>" type="text" class="moduletxt txtdtelease form-control input-sm" disabled="true"></b>
                                </h6>                               

                            </div>      

                            <div class="invoice-col col-md-2">
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Invoice #: <input name="inv" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['inv'];}?>" type="text" class="moduletxt txtinv form-control input-sm" disabled="true"></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>PO #: <input name="po" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['po'];}?>" type="text" class="moduletxt txtpo form-control input-sm" disabled="true"></b>
                                </h6>                                                               

                                <h6 class="aimslabel" style="display:block;">
                                    <b>day(s): <input name="daywarranty" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['daywarranty'];}?>" type="text" class="moduletxt txtdaywarranty form-control input-sm" disabled="true"></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>day(s): <input name="daylease" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['daylease'];}?>" type="text" class="moduletxt txtdaylease form-control input-sm" disabled="true"></b>
                                </h6>   
                            </div> 

                            <div class="invoice-col col-md-2">
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Price: <input name="itemprice" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemprice'];}?>" type="text" class="moduletxt txtitemprice form-control input-sm" disabled="true"></b>
                                </h6>   
                            </div>                                                                              

                        </div>  
                    </div>  
                </div>  
            </div>                          
        </div>

        <div class="tab-pane" id="tab_3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid box-success">
                        <div class="box-body">
                            <div class="invoice-col col-md-4">
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Department: <input name="deptname" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['deptname'];}?>" type="text" class="moduletxt txtdeptname form-control input-sm" disabled="true"></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Employee: <input name="emp" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['emp'];}?>" type="text" class="moduletxt txtemp form-control input-sm" disabled="true"></b>
                                </h6>                               

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Building: <input name="bldg" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['bldg'];}?>" type="text" class="moduletxt txtbldg form-control input-sm" disabled="true"></b>
                                </h6>   
                            </div>  

                            <div class="invoice-col col-md-3">
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Floor: <input name="floor" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['floor'];}?>" type="text" class="moduletxt txtfloor form-control input-sm" disabled="true"></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Room: <input name="room" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['room'];}?>" type="text" class="moduletxt txtroom form-control input-sm" disabled="true"></b>
                                </h6>                               

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Region: <input name="region" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['region'];}?>" type="text" class="moduletxt txtregion form-control input-sm" disabled="true"></b>
                                </h6>   
                            </div>    

                            <div class="invoice-col col-md-2">                                                                                  
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Date: <input name="locdate" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['locdate'];}?>" type="text" class="moduletxt txtlocdate form-control input-sm" disabled="true"></b>
                                </h6>                               
                            </div>                          

                        </div>  
                    </div>  
                </div>  
            </div>                          
        </div>      

        <div class="tab-pane" id="tab_4">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid box-success">
                        <div class="box-body">  
                            <div class="invoice-col col-md-3">

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Plate #: <input name="plate" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['plate'];}?>" type="text" class="moduletxt txtplate form-control input-sm" disabled="true"></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Manufacturer: <input name="man" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['man'];}?>" type="text" class="moduletxt txtman form-control input-sm" disabled="true"></b>
                                </h6>                                   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Fuel type: <input name="fuel" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['fuel'];}?>" type="text" class="moduletxt txtfuel form-control input-sm" disabled="true"></b>
                                </h6>                                       

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Inssurance: <input name="insurance" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['insurance'];}?>" type="text" class="moduletxt txtinsurance form-control input-sm" disabled="true"></b>
                                </h6>                                   
                            </div>  

                            <div class="invoice-col col-md-3">

                                <h6 class="aimslabel" style="display:block;">
                                    <b>VIN #: <input name="vin" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['vin'];}?>" type="text" class="moduletxt txtvin form-control input-sm" disabled="true"></b>
                                </h6>   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Year: <input name="manyr" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['manyr'];}?>" type="text" class="moduletxt txtmanyr form-control input-sm" disabled="true"></b>
                                </h6>                                   

                                <h6 class="aimslabel" style="display:block;">
                                    <b>Engine: <input name="engine" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['engine'];}?>" type="text" class="moduletxt txtengine form-control input-sm" disabled="true"></b>
                                </h6>                                       
                                                                              
                                <h6 class="aimslabel" style="display:block;">
                                    <b>Expiration Date: <input name="vehicleexp" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['vehicleexp'];}?>" type="text" class="moduletxt txtvehicleexp form-control input-sm" disabled="true"></b>
                                </h6>                               
                            </div>     
                                                     
                        </div>  
                    </div>  
                </div>                      
            </div>  
        </div>  
		
	</div>	<!-- /.tab -->		
	
</div> 

</div> 

</div>