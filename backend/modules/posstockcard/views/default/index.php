<?php
use yii\helpers\Url;
use yii\base\ErrorException;
$this->title = 'P.O.S. Stockcard Ledger';

try {
?>

<style type="text/css">
    #componentitemsgrid,#computepacking{
        height: 380px;
    }

</style>

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
                      <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnchangebarcode"><b><i class="new_btn fa fa-refresh"></i> Change Barcode</b></button>

                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                         <?php
                            echo'<button type="button" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>';
                         ?>
                        <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> Print</b></button>

                         <?php
                          echo'<button type="button" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>';
                         ?>

                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> Logs</b></button>


                       <button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>

                      <?php }else{ ?>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn btnactive module-btnchangebarcode"><b><i class="new_btn fa fa-refresh"></i> Change Barcode</b></button>

                        <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> New</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> Edit</b></button>
                        <button type="button" class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> Print</b></button>
                        <button disabled="true" type="button" class=" btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> Delete</b></button>
                        <button disabled="true" type="button" class="btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> Logs</b></button>


                       <button disabled="true" id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                        <button disabled="true" id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                        <button disabled="true"id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                        <button disabled="true" id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                        <!-- <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="fa fa-minus"></i></button> -->
                       <?php } ?>
                      </div>

                       </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                  <div class="box-body">
                    <div class="pull-right" style="margin-top:-15px;">
                    </div>
                    <div class="invoice-info col-md-12" style="margin-left:-15px;">

                        <div class="invoice-col col-md-3">


                            <h6 class="aimslabel"><b>Barcode:  </b>
                                <div class="input-group">
                                    <input name = "barcode" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['barcode'];}?>" type="text" class="moduletxt txtbarcode input-sm form-control"><div class="frmdocumentno input-group-addon"><a class ="stockcardlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>
                            <h6 class="aimslabel"><b>Description: <textarea  disabled="true" name="itemname" class="moduletxt txtitemname form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemname'];}?></textarea></b></h6>

                            <h6 class="aimslabel" style="display:block;">
                                <b>Item Default UOM: <input name="uom" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['uom'];}?>" type="text" class="moduletxt txtuom form-control input-sm" disabled="true"></b>
                            </h6>
                          
                                    <?php
                                    switch (Yii::$app->systemsettings->companyConfig()) {
                                        default:
                                        echo '<h6 class="aimslabel">
                                        <div class="input-group">';
                                        echo '<input readonly disabled="true" name = "invbal_uom" value ="" type="hidden" class="moduletxt txtinvbal_uom input-sm form-control">';
                                        echo '</div>
                                        </h6>';
                                        break;
                                    }//end switch
                                    ?>

                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">
                            <h6 class="aimslabel">
                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                default:
                                echo '<b>Part:  </b>';
                                break;
                            }//end switch
                            ?>
                                <div class="input-group">
                                    <input readonly="true" name = "part" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['part'];}?>" type="text" class="moduletxt txtpart input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="partlookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    <input type="hidden" name="partid" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['partid'];}?>" class="moduletxt txtpartid txthiddenids">
                                </div>
                            </h6>


                            <h6 class="aimslabel">
                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'SOUTHCENTRAL':
                                echo '<b>ABC Category:  </b>';
                                break;

                                default:
                                echo '<b>Model:  </b>';
                                break;
                            }//end switch
                            ?>
                                <div class="input-group">
                                    <input readonly="true" name = "model" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['model'];}?>" type="text" class="moduletxt txtmodel input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="modellookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    <input type="hidden" name="modelid" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['modelid'];}?>" class="txtmodelid moduletxt txthiddenids">
                                </div>
                            </h6>


                            <h6 class="aimslabel"><b>Brand:</b>  
                                <div class="input-group">
                                    <input readonly disabled="true" name = "brand" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['brand'];}?>" type="text" class="moduletxt txtbrand input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="brandlookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>
                            <?php
                            echo '<h6 class="aimslabel"><b>Color:  </b>
                                    <input  disabled="true" name = "color" value ="';
                                    if(isset($stockcarddata)){
                                        echo $stockcarddata[0]['color'];
                                    }
                            echo '" type="text" class="moduletxt txtcolor input-sm form-control">
                            </h6>';
                            ?>


                        </div><!-- /.col -->


                        <div class="invoice-col col-md-3">

                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                default:
                                    echo '<h6 class="aimslabel"><b>Size:  </b>
                                        <div class="input-group">
                                            <input readonly="true" name = "sizeid" value ="';
                                            if(isset($stockcarddata)){
                                                echo $stockcarddata[0]['sizeid'];
                                            }
                                    echo '" type="text" class="moduletxt txtsizeid input-sm form-control"><div class="frmdocumentno input-group-addon"><a  style="display:none;"  class ="sizelookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                        </div>
                                    </h6>';                               
                                break;
                            }//END SWITCH
                            ?>

                            <h6 class="aimslabel"><b>Itemrem: <textarea  disabled="true" name="itemrem" class="moduletxt txtitemrem form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemrem'];}?></textarea></b></h6>
                        
                        </div><!-- /.col -->

                        <div class="invoice-col col-md-3">

                            <?php
                            $datetoday = date("Y-m-d");
                            $date = strtotime($datetoday .' -6 months');
                            $finaldate=date('Y-m-d', $date);
                            ?> 

                            <h6 class="aimslabel viewbyfilters"><b>View by Date:  </b>
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo $finaldate; ?>"  class="paedit input-group date dpYears">
                            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            <input type="text" name = "ledgerdateid" readonly="" value="<?php echo $finaldate; ?>" size="12" class="moduletxt viewbydateid form-control input-sm" disabled="true">
                            </div>
                            </h6>

                            <h6 class="aimslabel viewbyfilters"><b>View by UOM: </b>
                            <div class="input-group">
                            <input disabled="true" name="uom" value ="<?php echo $stockcarddata[0]['uom']; ?>" type="text" class="moduletxt viewbyuom form-control input-sm">
                            <div class="frmwh input-group-addon"><a class ="selectuompop" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                            </h6>


                            <!-- <h6 class="aimslabel viewbyfilters"><b>View by UOM: </b>
                             <select id="viewbyuom" class="selectuompopup input-sm form-control"></select>
                            </h6>
 -->
                            <h6 class="aimslabel viewbyfilters"><b>View by Warehouse:</b>
                            <div class="input-group">
                            <input disabled="true" name="warehouse" value ="<?php echo Yii::$app->session['loggeduser']['whname'].'~'.Yii::$app->session['loggeduser']['whcode']; ?>" type="text" class="moduletxt viewbywh form-control input-sm">
                            <div class="frmwh input-group-addon"><a class ="whlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                            </h6>


                        </div><!-- /.col -->

                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>



<!--STOCK-->
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
                <li id="clickledger"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Ledger</a></li>
                <li id="clickrv"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Receiving</a></li>
                <li class="active" id="clickproperties"><a href="#tab_6" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Properties</a></li>
                
                <li id="clickprice"><a href="#tab_7" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Price</a></li>
                
                <li class="clickable stockcarduom"><a aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">UOM</a></li>
                
                
                <li id='clickcomponents'><a href="#tab_12" data-toggle="tab" aria-expanded="true" style="font-weight:bold;text-shadow:0 1px 0 rgba(255, 255, 255, 0.5);">Components</a></li>
                
                <li id="clickpacking"><a href="#tab_11" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Packaging</a></li>
                
                <!-- <li id="clicksupplier"><a href="#tab_13" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Supplier</a></li> -->

                <!-- <li id="clickunposted"><a href="#tab_14" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Unposted</a></li>
 -->
                <li class="pull-right"><h6 class="txttotalbal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;"></h6></li>
                <li class="pull-right"><h6 class="txttotalout" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;"></h6></li>
                <li class="pull-right"><h6 class="txttotalin" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;"></h6></li>
            </ul>

      <div class="tab-content">
        <div class="tab-pane" id="tab_8">
          <div class="box box-solid box-success" style="margin-bottom:-0px;">
            <div class="box-body mod-tble">
              <div class="invoice-col col-md-3">
                <label class="aimslabel">FRONTEND SETTING</label>
                                    <br>

                                    <input disabled="true" name = "setfrontend" style="margin-right:5px;" class ="f_setfrontend itemboxes" <?php if(isset($stockcarddata)){if($stockcarddata[0]['setfrontend'] == 1){ echo 'checked';}}?> type="checkbox">&nbsp
                                    <label class="aimslabel">Set this Item for frontend </label>
                                    
                                    <br>


                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Sale Price:<input name="frontendsaleprice" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['saleprice'];}?>" type="text" class="moduletxt txtfrontendsaleprice form-control input-sm" disabled="true"></b>
                                    </h6>
                                    
                                    <h6 class="aimslabel"><b>Promo Start date: </b> 
                                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                                    <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                    <input type="text" readonly="" name="frontendpromostart" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['promostart'];}?>" size="12" class="moduletxt promostartdate form-control input-sm" disabled="true">
                                    </div>
                                    </h6>

                                    <h6 class="aimslabel"><b>Promo End date: </b>
                                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                                    <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                    <input type="text" readonly="" name="frontendpromoend" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['promoend'];}?>" size="12" class="moduletxt promoenddate form-control input-sm" disabled="true">
                                    </div>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Available QTY:<input name="frontendqty" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['fqty'];}?>" type="text" class="moduletxt txtfrontendqty form-control input-sm" disabled="true"></b>
                                    </h6>


                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Discounted %:<input name="fdiscounted" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['fdiscounted'];}?>" type="text" class="moduletxt txtfdiscounted form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <label class="aimslabel">Manage Related Items: <br>
                                    <button id="frontendrelatedtag" class="btn btn-flat btn-github">Manage Related Items</button>

                                </div><!-- /.col -->

                                <div class="invoice-col col-md-3">
                                <label class="aimslabel">PRODUCT SPECIFICATIONS</label>
                                    <?php if(isset($stockcarddata)){$it =  $stockcarddata[0]['itemid'];}else{ $it=0;} ?>
                                    <a linkto = "f_proddesc" class="wiglink" href="<?php echo Url::to(['/stockcard/wysiwyg','q'=>$it,'f'=>'f_proddesc']); ?>" target="_blank"><h6 class="clickable text-red"><i class="fa fa-edit"></i>&nbsp<b>Click to edit Product Description</b></h6></a>

                                    <a linkto = "f_notes" class="wiglink" href="<?php echo Url::to(['/stockcard/wysiwyg','q'=>$it,'f'=>'f_notes']); ?>" target="_blank"><h6 class="clickable text-red"><i class="fa fa-edit"></i>&nbsp<b>Click to edit Product Notes</b></h6></a>

                                    <a linkto = "f_highlights" class="wiglink" href="<?php echo Url::to(['/stockcard/wysiwyg','q'=>$it,'f'=>'f_highlights']); ?>" target="_blank"><h6 class="clickable text-red"><i class="fa fa-edit"></i>&nbsp<b>Click to edit Product Highlights</b></h6></a>

                                    <a linkto = "f_whatsbox" class="wiglink" href="<?php echo Url::to(['/stockcard/wysiwyg','q'=>$it,'f'=>'f_whatsbox']); ?>" target="_blank"><h6 class="clickable text-red"><i class="fa fa-edit"></i>&nbsp<b>Click to edit What's in the box</b></h6></a>

                                    <a linkto = "f_freeitems" class="wiglink" href="<?php echo Url::to(['/stockcard/wysiwyg','q'=>$it,'f'=>'f_freeitems']); ?>" target="_blank"><h6 class="clickable text-red"><i class="fa fa-edit"></i>&nbsp<b>Click to edit Free Items</b></h6></a>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Main Material: <input name="frontendmainmat" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_mainmaterial'];}?>" type="text" class="moduletxt txtfrontendmainmat form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Type: <input name="frontendtype" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_type'];}?>" type="text" class="moduletxt txtfrontendtype form-control input-sm" disabled="true"></b>
                                    </h6>


                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Video URL:<input name="frontendvideourl" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_videourl'];}?>" type="text" class="moduletxt txtfrontendvideourl form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <br>

                                    <label class="aimslabel">Currently under: <br>
                                    <span class="ftagging"><?php if(isset($stockcarddata)){echo $stockcarddata[0]['cat_desc'];}?></span></label><br>
                                    <button id="clicklanetagging" class="btn btn-flat btn-github">Manage Item Tagging</button>
                                </div><!-- /.col -->

                               
                                <div class="invoice-col col-md-3">
                                <label class="aimslabel">MEASUREMENT</label>
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Dimension (Legth x Width x Height in cm):<input name="frontenddimensions" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_dimensions'];}?>" type="text" class="moduletxt txtfrontenddimension form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Product Weight (kg):<input name="frontendprodweight" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_prodweight'];}?>" type="text" class="moduletxt txtfrontendprodweight form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Package Height (cm):<input name="frontendpackageheight" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_packheight'];}?>" type="text" class="moduletxt txtfrontendpackageheight form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Package Length (cm):<input name="frontendpackagelength" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_packlength'];}?>" type="text" class="moduletxt txtfrontendpackagelength form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Package Weight(kg) :<input name="frontendpackageweight" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_packweight'];}?>" type="text" class="moduletxt txtfrontendpackageweight form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Package Width (cm):<input name="frontendpackagewidth" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_packwidth'];}?>" type="text" class="moduletxt txtfrontendpackagewidth form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <br>
                                </div><!-- /.col -->

                                <div class="invoice-col col-md-3">
                                <label class="aimslabel">DELIVERY</label>
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Delivery Option:<input name="frontenddeliveryopt" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_delivopt'];}?>" type="text" class="moduletxt txtfrontenddeliveryopt form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Min. Shipping Time:<input name="frontenddeliveryshippingmin" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_shippingmin'];}?>" type="text" class="moduletxt txtfrontenddeliveryshippingmin form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Max. Shipping Time:<input name="frontenddeliveryshippingmax" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_shippingmax'];}?>" type="text" class="moduletxt txtfrontenddeliveryshippingmax form-control input-sm" disabled="true"></b>
                                    </h6>

                                 <label class="aimslabel">WARRANTY</label>
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Warranty Type:<!-- <input name="frontendwarrantytype" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_warrantytype'];}?>" type="text" class="moduletxt txtfrontendwarrantytype form-control input-sm" disabled="true"> -->
                                        <select class="moduletxt txtfrontendwarrantytype form-control input-sm" disabled>
                                            <?php if(isset($stockcarddata)){echo '<option>'. $stockcarddata[0]['f_warrantytype'] . '</option>';}?>
                                        </select>
                                        </b>
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Warranty Period :
                                        <div class="row">
                                            <div class="col-md-4">
                                                <?php 
                                                if(isset($stockcarddata)){
                                                    if($stockcarddata[0]['f_warrantperiod'] != 0){
                                                        $warrtyperiod = explode('~', $stockcarddata[0]['f_warrantperiod']);
                                                        $count = $warrtyperiod[0];
                                                        $ext = $warrtyperiod[1];
                                                    }else{
                                                        $count = "";
                                                        $ext = "";
                                                    }//end if
                                                }else{
                                                    $count = "";
                                                    $ext = "";
                                                }//end if
                                                ?>
                                                <input value ="<?php echo $count;?>" type="text" class="moduletxt txtfrontendwarrantyperiod-count form-control input-sm" disabled="true">
                                            </div>

                                            <div class="col-md-8">
                                                <select class="moduletxt form-control input-sm frontendwarrantyperiod-ext" disabled>
                                                <?php
                                                if($ext == ''){
                                                    echo '<option>Day(s)</option>';
                                                }else{
                                                    echo '<option>'.$ext.'</option>';
                                                }//end if
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        </b>
                                    </h6>

                                    <h6 class="aimslabel"><b>Warranty Policy: <textarea  disabled="true" name="frontendwarrantypolicy" class="moduletxt txtfrontendwarrantypolicy form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($stockcarddata)){echo $stockcarddata[0]['f_warrantpolicy'];}?></textarea></b></h6>
                                </div><!-- /.col -->
                            </div><!-- /.box-body -->
                            </div><!-- /.box -->
                </div><!-- /.TAB PANE -->


                

           <div class="tab-pane" id="tab_1">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockcardledger"></div>  
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane" id="tab_2">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockreceiving"></div>
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane" id="tab_3">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockpo"></div>
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane" id="tab_4">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockso"></div>
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane" id="tab_11">
                <button style ="margin-bottom: 10px;" type="button" class="btn btn-xs btn-flat btn-primary btn-sm btnaddpackaging"><i class="fa fa-plus"></i>  ADD PACKAGING</button>
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockpacking"></div>
                </div>
            </div>

            <div class="tab-pane" id="tab_12">
                <button style ="margin-bottom: 10px;" type="button" class="btn btn-xs btn-flat btn-primary btn-sm btnaddcomponentitem3"><i class="fa fa-plus"></i>  ADD COMPONENT</button>
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockcomponents"></div>
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane" id="tab_13">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stocksupplier"></div>
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane" id="tab_14">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockunposted"></div>
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane active" id="tab_6">
              <div class="box box-solid box-success" style="margin-bottom:-0px;">
                <div class="box-body">

                  <div class="invoice-col col-md-4">
                    <h6 class="aimslabel picbox">
                      <?php if(isset($stockcarddata))
                            {
                               if(empty($stockcarddata[0]['picture']))
                               {
                                  $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';
                               }
                               else
                               {
                                  $str = $stockcarddata[0]['picture'];
                               }
                            }
                            else
                            {
                               $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                            }
                      ?>
                      <img src ="<?php echo $str; ?>" width="260px" height ="250px" class="thumbnail recordpicture">
                      <?php
                        $url = "/". $moduleid ."/". "uploadpic/";
                      ?>
                      
                      <form id ="picupload" method="POST" enctype="multipart/form-data">
                        <span id="fileselector">
                          <label class="btn btn-default" for="upload-file-selector" >
                            <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture">
                            <i class="fa fa-upload margin-correction"></i>Upload Photo
                          </label>
                        </span>

                         <span id="fileselector">
                          <label class="btn btn-default" for="upload-file-selector" >
                            <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture">
                            <i class="fa fa-trash margin-correction"></i>Remove Photo
                          </label>
                        </span>

                        <button type = "submit" class="uploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image
                        </button>
                        <button type = "button" class="uploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel
                        </button>
                      </form>

                      
                    </h6>
                    <label class="aimslabel">This would be the primary image for Primary Lane Items.</label>
                    <label class="aimslabel">REQUIRED: Dimension of (285 x 228) and resolution (72)</label>
                  </div><!-- invoice-col col-md-4 -->


                  <div class="invoice-col col-md-4" style="display:block;margin-left: -20px">
                   
                    <h6 class="aimslabel">
                      <b>Effectivity Date:</b>
                      <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                        <input readonly="true" name="effdate" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['effectdate'];}?>" type="text" class="moduletxt txteffdate form-control input-sm">
                          <div class="dateid-lookup input-group-addon add-on">
                            <a style="display: none;"  class="proplookup" href="#">
                                <i class="fa fa-chevron-circle-down"></i>
                            </a>
                          </div>
                      </div>
                    </h6>


                    <h6 class="aimslabel"><b>Group:  </b>
                        <div class="input-group">
                            <input readonly="true" name = "groupid" value ="<?php if(isset($stockcarddata)){ echo $stockcarddata[0]['groupid']; } ?>" type="text" class="moduletxt txtgroupid input-sm form-control">
                            <div class="frmdocumentno input-group-addon">
                                <a style="display:none;" class ="grouplookup proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a>
                            </div>
                        </div>
                        <input type="hidden" class="stockgrpid moduletxt" value="<?php if(isset($stockcarddata)){ echo $stockcarddata[0]['stockgrpid']; }?>" name="stockgrpid">
                    </h6>

                    <h6 class="aimslabel">
                      <b>Packaging:</b>
                      <div class="input-group">
                        <input readonly="true" name="packaging" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['packaging'];}?>" type="text" class="moduletxt txtpackaging form-control input-sm">
                          <div class="input-group-addon">
                            <a style="display: none;" class ="packinglookup proplookup" href="#">
                              <i class="fa fa-chevron-circle-down"></i>
                            </a>
                          </div>
                        </div>
                    </h6>

                    <h6 class="aimslabel">
                      <b>Link PLU:</b>
                      <div class="input-group">
                        <input readonly="true" name="linkplu" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['linkplu'];}?>" type="text" class="moduletxt txtlinkplu form-control input-sm">
                          <div class="input-group-addon">
                            <a style="display: none;" class ="linklpulookup proplookup" href="#">
                              <i class="fa fa-chevron-circle-down"></i>
                            </a>
                          </div>
                        </div>
                    </h6>

                    
                    <h6 class="aimslabel" style="display:block;">
                      <b>Other Barcodes: 
                        <input name="otherbar" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['othcode'];}?>" type="text" class="moduletxt txtotherbar form-control input-sm" disabled="true">
                      </b>
                    </h6>

                    <h6 class="aimslabel" style="display:block;">
                      <b>Supplier Barcodes: 
                        <input name="supbar" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['suppcodes'];}?>" type="text" class="moduletxt txtsupbar form-control input-sm" disabled="true">
                      </b>
                    </h6>

                    


                    <h6 class="aimslabel">
                      <b>Date Updated:</b>
                      <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>"  class="paedit input-group date dpYears">
                        <input readonly="true" name="dateupdated" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['dateupdated'];}?>" type="text" class="moduletxt txtdateupdated form-control input-sm" disabled="true">
                          <div class="dateid-lookup input-group-addon add-on">
                            <a style="display: none;" class="proplookup" style="display:none;" href="#">
                                <i class="fa fa-chevron-circle-down"></i>
                            </a>
                          </div>
                      </div>
                    </h6>



                    <h6 class="aimslabel" style="display:block;">
                      <b>Quantity: 
                        <input name="quantity" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['qty'];}?>" type="text" class="moduletxt txtquantity form-control input-sm" disabled="true">
                      </b>
                    </h6>

                    <h6 class="aimslabel">
                      <b>Supplier:</b>
                      <div class="input-group">
                        <input readonly="true" name="supplier" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['supplier'];}?>" type="text" class="moduletxt txtsupplier form-control input-sm">
                          <div class="input-group-addon">
                            <a style="display:none;" class ="proplookup" href="#">
                              <i class="fa fa-chevron-circle-down"></i>
                            </a>
                          </div>
                        </div>
                    </h6>

                   <h6 class="aimslabel">
                      <b>Mode:</b>
                      <div class="input-group">
                        <input readonly="true" name="mode" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['mode'];}?>" type="text" class="moduletxt txtmode form-control input-sm">
                          <div class="input-group-addon">
                            <a style="display:none;" class ="proplookup" href="#">
                              <i class="fa fa-chevron-circle-down"></i>
                            </a>
                          </div>
                        </div>
                    </h6>
                  
                    <!--END-->
                    
                           
                    <input disabled="true" name = "istaxable" style="margin-left:7px;" class ="moduletxt itemtaxable" <?php if(isset($stockcarddata)){if($stockcarddata[0]['istaxable'] == 1){ echo 'checked';}}?> type="checkbox">&nbsp
                      <label>Taxable </label>

                    <input disabled="true" name = "ispostitem" style="margin-left:30px;" class ="moduletxt itempost" <?php if(isset($stockcarddata)){if($stockcarddata[0]['ispostitem'] == 1){ echo 'checked';}}?> type="checkbox" >&nbsp
                      <label>Post Item </label><br>

                    <input disabled="true" name = "isinactive" style="margin-left:7px;" class ="moduletxt iteminactive itemboxes" type="checkbox" <?php if(isset($stockcarddata)){if($stockcarddata[0]['isinactive'] == 1){ echo 'checked';}}?>>&nbsp
                      <label>Inactive </label>

                    <input disabled="true" name = "issenior" style="margin-left:29px;" class ="moduletxt itemsenior" <?php if(isset($stockcarddata)){if($stockcarddata[0]['issenior'] == 1){ echo 'checked';}}?> type="checkbox">&nbsp
                      <label>Senior </label><br>

                    <input disabled="true" name = "iszerorated" style="margin-left:7px;" class ="moduletxt itemzerorated" <?php if(isset($stockcarddata)){if($stockcarddata[0]['iszerorated'] == 1){ echo 'checked';}}?> type="checkbox" >&nbsp
                      <label>Zero-rated </label>

                    <input disabled="true" name = "isprintable" style="margin-left:13px;" class ="moduletxt itemprintable" <?php if(isset($stockcarddata)){if($stockcarddata[0]['isprintable'] == 1){ echo 'checked';}}?> type="checkbox" >&nbsp
                      <label>Printable </label><br><br><br>
                   
                  
                  </div><!-- invoice-col col-md-4 -->

                  <div class="invoice-col col-md-4">

                    <a href="">Other Specification (Image)</a>
                    
                    <h6 class="aimslabel">
                      <b>Hierarchy Parent:</b>
                      <div class="input-group">
                        <input readonly="true" name="hierparent" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['hierarchy'];}?>" type="text" class="moduletxt txthierparent form-control input-sm">
                          <div class="input-group-addon">
                            <a style="display:none;" class ="proplookup" href="#">
                              <i class="fa fa-chevron-circle-down"></i>
                            </a>
                          </div>
                        </div>
                    </h6>

                    <h6 class="aimslabel" style="display:block;">
                      <b>Link Dept: 
                        <input name="linkdept" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['linkdept'];}?>" type="text" class="moduletxt txtlinkdept form-control input-sm" disabled="true">
                      </b>
                    </h6>

                    <h6 class="aimslabel" style="display:block;">
                      <b>Points: 
                        <input name="points" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['points'];}?>" type="text" class="moduletxt txtpoints form-control input-sm" disabled="true">
                      </b>
                    </h6>


                    <h6 class="aimslabel" style="display:block;">
                      <b>Acceptable Losses %: 
                        <input name="acceptlosses" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['acceptloss'];}?>" type="text" class="moduletxt txtacceptlosses form-control input-sm" disabled="true">
                      </b>
                    </h6>

                    <h6 class="aimslabel" style="display:block;">
                      <b>Current Cost: 
                        <input name="currentcost" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['cost'];}?>" type="text" class="moduletxt txtcurrentcost form-control input-sm" disabled="true">
                      </b>
                    </h6>


                    <h6 class="aimslabel" style="display:block;">
                      <b>Cook Time (Mins): 
                        <input name="cooktime" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['cooking_time'];}?>" type="text" class="moduletxt txtcooktime form-control input-sm" disabled="true">
                      </b>
                    </h6>

                    <h6 class="aimslabel" style="display:block;">
                      <b>Prep Time (Mins): 
                        <input name="preptime" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['prep_time'];}?>" type="text" class="moduletxt txtpreptime form-control input-sm" disabled="true">
                      </b>
                    </h6>
                    <!--END -->
                  </div><!-- invoice-col col-md-4 -->

                  
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.TAB PANE -->


            <div class="tab-pane" id="tab_7">
              <div class="box box-solid box-success" style="margin-bottom:-0px;">
                <div class="box-body">
                    <h6 class="aimslabel" style="font-weight: bold;">Price Levels</h6>

                    <div class="invoice-col col-md-2">
                        <h6 class="aimslabel" style="display:block;">
                            <b>[R] Retail: <input name="amt" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt'];}?>" type="text" class="moduletxt txtamt form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>[W] Whole Sale: <input name="amt2" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt2'];}?>" type="text" class="moduletxt txtamt2 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>[A] Group 1: <input name="amt4" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt4'];}?>" type="text" class="moduletxt txtamt4 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>[B] Group 2: <input name="famt" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['famt'];}?>" type="text" class="moduletxt txtfamt form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>[C] Group 3: <input name="amt5" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt5'];}?>" type="text" class="moduletxt txtamt5 form-control input-sm" disabled="true"></b>
                        </h6>


                        <h6 class="aimslabel" style="display:block;">
                            <b>[D] Group 4: <input name="amt6" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt6'];}?>" type="text" class="moduletxt txtamt6 form-control input-sm" disabled="true"></b>
                        </h6>

                    </div>


                    <div class="invoice-col col-md-2">
                        <h6 class="aimslabel" style="display:block;">
                            <b>Discount: <input name="disc" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc'];}?>" type="text" class="moduletxt txtdisc form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Discount: <input name="disc2" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc2'];}?>" type="text" class="moduletxt txtdisc2 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Discount: <input name="disc3" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc3'];}?>" type="text" class="moduletxt txtdisc3 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Discount: <input name="disc4" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc4'];}?>" type="text" class="moduletxt txtdisc4 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Discount: <input name="disc5" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc5'];}?>" type="text" class="moduletxt txtdisc5 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Discount: <input name="disc6" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc6'];}?>" type="text" class="moduletxt txtdisc6 form-control input-sm" disabled="true"></b>
                        </h6>

                    </div>

                    <div class="invoice-col col-md-2">
                        <h6 class="aimslabel" style="display:block;">
                            <b>Mark up: <input type="" name="markup" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['markup'];}?>" class="moduletxt txtmarkup form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Mark up: <input type="" name="markup2" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['markup2'];}?>" class="moduletxt txtmarkup2 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Mark up: <input type="" name="markup3" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['markup3'];}?>" class="moduletxt txtmarkup3 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Mark up: <input type="" name="markup4" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['markup4'];}?>" class="moduletxt txtmarkup4 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Mark up: <input type="" name="markup5" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['markup5'];}?>" class="moduletxt txtmarkup5 form-control input-sm" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Mark up: <input type="" name="markup6" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['markup6'];}?>" class="moduletxt txtmarkup6 form-control input-sm" disabled="true"></b>
                        </h6>
                    </div>

                    <div class="invoice-col col-md-2">
                        <h6 class="aimslabel" style="display:block;">
                            <b>UOM:</b>
                            <div class="input-group">
                            <input type="text" name="uom1" value ="<?php echo $stockcarddata[0]['uom1']; ?>" class="moduletxt txtuom1 form-control input-sm" readonly="true">
                            <div class="frmwh input-group-addon"><a style="display:none;" class ="selectuom_pricetab proplookup" href="#" plotloc2 = "txtfactor1" plotloc= "txtuom1"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>UOM:</b>
                            <div class="input-group">
                            <input type="text" name="uom2" value ="<?php echo $stockcarddata[0]['uom2']; ?>" class="moduletxt txtuom2 form-control input-sm" readonly="true" >
                            <div class="frmwh input-group-addon"><a style="display:none;" class ="selectuom_pricetab proplookup" href="#" plotloc2 = "txtfactor2" plotloc= "txtuom2"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>UOM:</b>
                            <div class="input-group">
                            <input type="text" name="uom3" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['uom3'];}?>" class="moduletxt txtuom3 form-control input-sm" readonly="true">
                            <div class="frmwh input-group-addon"><a style="display:none;" class ="selectuom_pricetab proplookup" href="#" plotloc2 = "txtfactor3" plotloc= "txtuom3"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>UOM:</b>
                            <div class="input-group">
                            <input readonly="true" type="text" name="uom4" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['uom4'];}?>" class="moduletxt txtuom4 form-control input-sm">
                            <div class="frmwh input-group-addon"><a style="display:none;" class ="selectuom_pricetab proplookup" href="#" plotloc2 = "txtfactor4" plotloc= "txtuom4"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>UOM:</b>
                            <div class="input-group">
                            <input readonly="true" type="text" name="uom5" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['uom5'];}?>" class="moduletxt txtuom5 form-control input-sm">
                            <div class="frmwh input-group-addon"><a style="display:none;" class ="selectuom_pricetab proplookup" href="#" plotloc2 = "txtfactor5" plotloc= "txtuom5"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>UOM: </b>
                            <div class="input-group">
                            <input readonly="true" type="text" name="uom6" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['uom6'];}?>" class="moduletxt txtuom6 form-control input-sm">
                            <div class="frmwh input-group-addon"><a style="display:none;" class ="selectuom_pricetab proplookup" href="#" plotloc2 = "txtfactor6" plotloc= "txtuom6"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                        </h6>
                    </div>

                    <div class="invoice-col col-md-1">
                        <h6 class="aimslabel" style="display:block;">
                            <b>Factor: <input type="text" name="factor1" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['factor1'];}?>" class="moduletxt txtfactor1 form-control input-sm" readonly="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Factor: <input type="text" name="factor2" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['factor2'];}?>" class="moduletxt txtfactor2 form-control input-sm" readonly="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Factor: <input type="text" name="factor3" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['factor3'];}?>" class="moduletxt txtfactor3 form-control input-sm" readonly="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Factor: <input type="text" name="factor4" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['factor4'];}?>" class="moduletxt txtfactor4 form-control input-sm" readonly="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Factor: <input type="text" name="factor5" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['factor5'];}?>" class="moduletxt txtfactor5 form-control input-sm" readonly="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Factor: <input type="text" name="factor6" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['factor6'];}?>" class="moduletxt txtfactor6 form-control input-sm" readonly="true"></b>
                        </h6>
                    </div>

                    <div class="invoice-col col-md-3">
                        <h6 class="aimslabel" style="display:block;">
                            <b>Maximum: <input type="text" name="maximum" class="form-control input-sm moduletxt txtmax" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['maximum'];}?>" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Reorder: <input type="text" name="reorder" class="form-control input-sm moduletxt txtreorder" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['reorder'];}?>" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Critical: <input type="text" name="critical" class="form-control input-sm moduletxt txtcritical" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['critical'];}?>" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Minimum: <input type="text" name="minimum" class="form-control input-sm moduletxt txtmin" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['minimum'];}?>" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>Senior Disc: <input type="text" name="senior" class="form-control input-sm moduletxt txtsenior" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['senior'];}?>" disabled="true"></b>
                        </h6>

                        <h6 class="aimslabel" style="display:block;">
                            <b>P.W.D Disc: <input type="text" name="pwd" class="form-control input-sm moduletxt txtpwd" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['pwd'];}?>" disabled="true"></b>
                        </h6>
                    </div>
                </div><!--box-body-->
              </div><!--box body-solid box-success-->

              <br>
              <br>
            </div><!--tab-pane active-->




                
          </div> <!-- END TAB CONTENT -->
        </div> <!-- END TAB CUSTOMS -->
      </div> <!-- END TAB CONTENT -->
    </div> <!-- END NAV CUSTOM -->
  </div>
</div>


<?php
} catch (ErrorException $e) {
    echo $e;
}
?>