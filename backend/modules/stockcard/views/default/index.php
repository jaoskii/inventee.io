<?php
use yii\helpers\Url;
$this->title = 'Stockcard Ledger';

switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF

switch (Yii::$app->systemsettings->companyConfig()) {
  case 'MLCP':
    $colmd = 'col-md-2';
  break;

  default:
    $colmd = 'col-md-3';
  break;
}//END switch


switch (Yii::$app->systemsettings->companyConfig()) {
  case 'MLCP':
    $orgstyler='style="display:none;"';
  break;
  
  default:
    $orgstyler='style="display:block;"';
  break;
}//end switch

?>

<div  id="dragme">
<i onclick="myFunction()" class="title fa fa-list"></i><br/>
<ul id="menu-float">
<?php if(!empty($stockcarddata[0]['itemid'])){?>
     <!-- ADD CLASS (pop-btn btn-xx ) to BUTTONS added here also Remove button captions -->  
      <!-- then add (<div class="list">CAPTION</div>) after each </button>
<div class="list">CAPTION</div>
 -->
      <!-- BEGIN BTN GROUP -->
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnchangebarcode"><b><i class="new_btn fa fa-refresh"></i> </b></button>
<div class="list">Change Barcode</div>


<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> </b></button>
<div class="list">New</div>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> </b></button>
<div class="list">Save</div>

 <?php
    echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> </b></button>
<div class="list">Edit</div>
';
 ?>
<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> </b></button>
<div class="list">Cancel</div>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> </b></button>
<div class="list">Print</div>


 <?php
  echo'<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> </b></button>
<div class="list">Delete</div>
';
 ?>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> </b></button>
<div class="list">Logs</div>



<button id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>

<button id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>

<button id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>

<button id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>


<?php }else{ ?>
<button disabled="true" type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnchangebarcode"><b><i class="new_btn fa fa-refresh"></i> </b></button>
<div class="list">Change Barcode</div>


<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnnew"><b><i class="new_btn fa fa-file"></i> </b></button>
<div class="list">New</div>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> </b></button>
<div class="list">Save</div>

<button disabled="true" type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="edit_btn fa fa-pencil"></i> </b></button>
<div class="list">Edit</div>

<button type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> </b></button>
<div class="list">Cancel</div>

<button disabled="true" type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnprint "><b><i class="print_btn fa fa-print"></i> </b></button>
<div class="list">Print</div>

<button disabled="true" type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btndelete"><b><i class="delete_btn fa fa-trash"></i> </b></button>
<div class="list">Delete</div>

<button disabled="true" type="button" class="pop-btn btn-xx btn btn-default btn-success headbtn btnactive module-btnlogs"><b><i class="logs_btn fa fa-list"></i> </b></button>
<div class="list">Logs</div>



<button disabled="true" id ="<?php echo $moduleid.'-btnnavfirst';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
<div class="list">First</div>

<button disabled="true" id ="<?php echo $moduleid.'-btn-navprev';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
<div class="list">Previous</div>

<button disabled="true"id ="<?php echo $moduleid.'-btnnavnext';?>"  type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
<div class="list">Next</div>

<button disabled="true" id ="<?php echo $moduleid.'-btnnavlast';?>" type="button" class="pop-btn btn-xx btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
<div class="list">Last</div>

<!-- <button style="margin-top:3px;" class="btn btn-box-tool jaox"><i class="fa fa-minus"></i></button>
<div class="list">CAPTION</div>
 -->
<?php } ?>


</ul>
</div> <!-- dragme end -->

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="itemid" name ="itemid" class="moduletxt" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemid'];} ?>">

        <div class="col-md-12">
            <div class="box box-solid box-success">
                  <div class="modulehead box-header with-border">

                  <b><h6 class="txtitemid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Item ID: <?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemid'];} ?></h6></b>

                  <div class="btn-x pull-right">
                      <div class="btn-group">
                      <button type="button" class="btn btn-default btn-success headbtn btnactive module-btninactivelookup"><b><i class="new_btn fa fa-ban"></i> View Inactive Items</b></button>
                      
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

                            <h6 class="aimslabel"><b>Barcode: </b>
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
                                case 'GAMELINE_POS':
                                    echo '<h6 class="aimslabel"><b>Uom Printing:</b>  
                                        <div class="input-group">
                                            <input readonly disabled="true" name = "uomprint" value ="';
                                            if(isset($stockcarddata)){echo $stockcarddata[0]['gm_printuom'];}
                                    echo '" type="text" class="moduletxt txtuomprint input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="uomprintlookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                        </div>
                                    </h6>';
                                break;

                                case 'UNIVERSE':
                                  echo '<h6 class="aimslabel"><b>Purchase UOM:</b>  
                                        <div class="input-group">
                                            <input readonly disabled="true" name = "uompurchase" value ="';
                                            if(isset($stockcarddata)){echo $stockcarddata[0]['purchase_uom'];}
                                  echo '" type="text" class="moduletxt txtuompurchase input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="uompurchaselookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                        </div>
                                    </h6>';
                                break;

                                case 'MLCP':
                                  echo '<h6 class="aimslabel"><b># of Colors / Cylinders:
                                      <input disabled type="text" name="fg_colornum" class="moduletxt txtfg_colornum form-control input-sm" value="';
                                      if(isset($stockcarddata)){echo $stockcarddata[0]['fg_colornum'];}
                                      echo '"></b>
                                  </h6>';

                                  echo '<h6 class="aimslabel"><b>Customer:</b>  
                                        <div class="input-group">
                                            <input readonly disabled="true" name = "stockcardcustomer" value ="';
                                  if(isset($stockcarddata)){echo $stockcarddata[0]['fg_client'] . '~' . $stockcarddata[0]['fg_clientname'];}
                                  echo '" type="text" class="moduletxt txtcustomerstockcard input-sm form-control">
                                  <div class="frmdocumentno input-group-addon"><a style="display:none;" class ="stockcardclientlookup proplookup" href="#">
                                  <i class="fa fa-chevron-circle-down" ></i></a></div></div></h6>';
                                break;
                            }//END SWITCH
                            ?>

                            <?php 
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'TENPLUS':
                                echo '<h6 class="aimslabel" style="display:block;">
                                <b>Commission %: <input name="itemcomm" value ="';
                                if(isset($stockcarddata)){
                                    echo $stockcarddata[0]['itemcomm'];
                                }//end if
                                echo '" type="text" class="moduletxt txtitemcomm form-control input-sm" disabled="true"></b>
                                </h6>';
                                break;

                                default:
                                echo '<h6 class="aimslabel" style="display:none;">
                                <b>Commission %: <input name="itemcomm" value ="';
                                if(isset($stockcarddata)){
                                    echo $stockcarddata[0]['itemcomm'];
                                }//end if
                                echo '" type="text" class="moduletxt txtitemcomm form-control input-sm" disabled="true"></b>
                                </h6>';
                                break;
                            }//end switch
                            ?>

                            
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

                                    <?php
                                    switch (Yii::$app->systemsettings->companyConfig()) {
                                        case 'DAVIDSALON_JOY':
                                            echo '<h6 class="aimslabel" style="display:block;">
                                                <b>Shortname: <input name="shortname" value ="';
                                                if(isset($stockcarddata)){
                                                    echo $stockcarddata[0]['shortname'];
                                                }
                                            echo '" type="text" class="moduletxt txtshortname form-control input-sm" disabled="true"></b>
                                            </h6>';
                                        break;

                                        case 'UNIVERSE':
                                            echo '<h6 class="aimslabel" style="display:block;">
                                                <b>Short Description: <input name="shortname" value ="';
                                                if(isset($stockcarddata)){
                                                    echo $stockcarddata[0]['shortname'];
                                                }
                                            echo '" type="text" class="moduletxt txtshortname form-control input-sm" disabled="true"></b>
                                            </h6>';

                                            echo '<h6 class="aimslabel"><b>Priority:</b>
                                            <div class="input-group">
                                            <input disabled="true"  name="priority" value ="';
                                            if(isset($stockcarddata)){
                                            echo $stockcarddata[0]['uv_priority'];
                                            }
                                            echo '" type="text" class="moduletxt txt_uvpriority form-control input-sm">
                                            <div class="frmpriority input-group-addon"><a style="display:none;" class ="proplookup prioritylookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                            </div>
                                            </h6>';
                                        break;
                                    }//end switch
                                    ?>
                        </div><!-- /.col -->

                        <div class="invoice-col <?php echo $colmd; ?>">
                            <h6 <?php echo $orgstyler; ?> class="aimslabel">
                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'UNIVERSE':
                                echo '<b>Category:  </b>';
                                break;

                                default:
                                echo '<b>Part:  </b>';
                                break;
                            }//end switch
                            ?>
                                <div class="input-group">
                                    <input disabled="true" name = "part" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['part'];}?>" type="text" class="moduletxt txtpart input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="partlookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    <input type="hidden" name="partid" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['partid'];}?>" class="moduletxt txtpartid">
                                </div>
                            </h6>


                            <h6 <?php echo $orgstyler; ?> class="aimslabel">
                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'UNIVERSE':
                                echo '<b>Generic:  </b>';
                                break;

                                default:
                                echo '<b>Model:  </b>';
                                break;
                            }//end switch
                            ?>
                                <div class="input-group">
                                    <input disabled="true" name = "model" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['model'];}?>" type="text" class="moduletxt txtmodel input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="modellookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    <input type="hidden" name="modelid" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['modelid'];}?>" class="txtmodelid moduletxt">
                                </div>
                            </h6>

                            <?php
                              switch (Yii::$app->systemsettings->companyConfig()) {
                                  case 'MLCP':
                                      echo '<h6 class="aimslabel"><b>Product Type:
                                          <div class="input-group">
                                          <input readonly type="text" name="fg_prodtype" class="txtfgprodtype moduletxt form-control input-sm" value="';
                                      if(isset($stockcarddata)){echo $stockcarddata[0]['fg_prodtype'];}
                                      echo '"></b>
                                          <div class="frmdocumentno input-group-addon">
                                              <a style="display:none;" class ="fg_prodtypelookup proplookup" href="#">
                                                <i class="fa fa-chevron-circle-down" ></i>
                                              </a>
                                            </div>
                                          </div>
                                      </h6>';

                                      echo '<h6 class="aimslabel"><b>Material Combination:
                                          <input disabled type="text" name="fg_combi" class="txtfgcombi moduletxt form-control input-sm" value="';
                                      if(isset($stockcarddata)){echo $stockcarddata[0]['fg_combi'];}
                                      echo '"></b>
                                      </h6>';
                                  break;
                              }//end switch
                            ?>

                            <h6 class="aimslabel">
                            <?php
                             switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'UNIVERSE':
                                    echo '<b>Classification:  </b>';
                                break;

                                default:
                                    echo '<b>Class:  </b>';
                                break;
                            }//end switch
                            ?>
                                <div class="input-group">
                                    <input  disabled="true" name = "class" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['class'];}?>" type="text" class="moduletxt txtclass input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="classlookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                    <input type="hidden" class="moduletxt txtclassid" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['classid'];} ?>" name="classid">
                                </div>
                            </h6>

                            <h6 <?php echo $orgstyler; ?> class="aimslabel">
                              <?php
                               switch (Yii::$app->systemsettings->companyConfig()) {
                                  default:
                                      echo '<b>Brand:  </b>';
                                  break;
                              }//end switch
                              ?>
                                <div class="input-group">
                                    <input readonly disabled="true" name = "brand" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['brand'];}?>" type="text" class="moduletxt txtbrand input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="brandlookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>


                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                              case 'MLCP':
                                echo '<h6 class="aimslabel"><b>Plastic Color:
                                    <div class="input-group">
                                    <input readonly type="text" name="fg_plasticcolor" class="txtfgplasticcolor moduletxt form-control input-sm" value="';
                                if(isset($stockcarddata)){echo $stockcarddata[0]['fg_plasticcolor'];}
                                echo '"></b>
                                    <div class="frmdocumentno input-group-addon">
                                        <a style="display:none;" class ="fg_plasticcolorlookup proplookup" href="#">
                                          <i class="fa fa-chevron-circle-down" ></i>
                                        </a>
                                      </div>
                                    </div>
                                </h6>';
                              break;
                            }//end swithc
                            ?>

                             <?php 
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'UNIVERSE':
                                    echo '<h6 class="aimslabel"><b>Supp Item Code:</b>
                                    <div class="input-group">
                                    <input disabled="true"  name="suppitemcode" value ="';
                                    if(isset($stockcarddata)){
                                    echo $stockcarddata[0]['uv_suppitemcode'];
                                    }
                                    echo '" type="text" class="moduletxt txt_uvsuppitemcode form-control input-sm">
                                    <div class="frmsuppitemcode input-group-addon"><a style="display:none;" class ="proplookup suppitemcodelookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                    </div>
                                    </h6>';
                                break;

                                case 'MLCP':
                                    echo '<h6 class="aimslabel"><b>Sealing:
                                          <div class="input-group">
                                          <input readonly type="text" name="fg_sealing" class="txtfgsealing moduletxt form-control input-sm" value="';
                                    if(isset($stockcarddata)){echo $stockcarddata[0]['fg_sealing'];}
                                    echo '"></b>
                                          <div class="frmdocumentno input-group-addon">
                                            <a style="display:none;" class ="fg_sealinglookup proplookup" href="#">
                                              <i class="fa fa-chevron-circle-down" ></i>
                                            </a>
                                          </div>
                                        </div>
                                    </h6>';
                                break;


                                case 'TENPLUS':
                                echo '<h6 class="aimslabel" style="display:block;">
                                <b>Handling Fee[Lazada]%: <input name="itemhandling" value ="';
                                    if(isset($stockcarddata)){
                                        echo $stockcarddata[0]['itemhandling'];
                                    }//end if
                                echo '" type="text" class="moduletxt txtitemhandling form-control input-sm" disabled="true"></b>
                                </h6>';
                                break;

                                default:
                                echo '<h6 class="aimslabel" style="display:none;">
                                <b>Handling Fee[Lazada]%: <input name="itemhandling" value ="';
                                    if(isset($stockcarddata)){
                                        echo $stockcarddata[0]['itemhandling'];
                                    }//end if
                                echo '" type="text" class="moduletxt txtitemhandling form-control input-sm" disabled="true"></b>
                                </h6>';
                                break;
                            }//end switch
                            ?>
                        </div><!-- /.col -->


                        <div class="invoice-col <?php echo $colmd; ?>">
                            <h6 <?php echo $orgstyler; ?> class="aimslabel">
                            <?php
                             switch (Yii::$app->systemsettings->companyConfig()) {
                                case 'UNIVERSE':
                                    echo '<b>Form:  </b>';
                                break;
                                
                                default:
                                    echo '<b>Body:  </b>';
                                break;
                            }//end switch
                            ?>

                                <div class="input-group">
                                    <input  disabled="true" name = "body" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['body'];}?>" type="text" class="moduletxt txtbody input-sm form-control"><div class="frmdocumentno input-group-addon"><a  style="display:none;"  class ="bodylookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                </div>
                            </h6>




                            <?php
                            switch (Yii::$app->systemsettings->companyConfig()) {
                                default:
                                    switch (Yii::$app->systemsettings->companyConfig()) {
                                        case 'UNIVERSE':
                                            $size = 'Bin:';
                                            $category = 'Principal';
                                            $catstyle = 'style="display:block;"';
                                            $group='Division:';
                                        break;

                                        default:
                                            $size = 'Size:';
                                            $category = 'Category:';
                                            $catstyle = 'style="display:none;"';
                                            $group ='Group:';
                                        break;
                                    }//end switch
                                
                                    echo '<h6 '.$orgstyler.' class="aimslabel"><b>'.$size.' </b>
                                        <div class="input-group">
                                            <input  disabled="true" name = "sizeid" value ="';
                                            if(isset($stockcarddata)){
                                                echo $stockcarddata[0]['sizeid'];
                                            }
                                    echo '" type="text" class="moduletxt txtsizeid input-sm form-control"><div class="frmdocumentno input-group-addon"><a  style="display:none;"  class ="sizelookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                        </div>
                                    </h6>';

                                    echo '<h6 '.$orgstyler.' class="aimslabel" '.$catstyle.'><b>'.$category.'  </b>
                                        <div class="input-group">
                                            <input readonly name = "principalid" value ="';
                                            if(isset($stockcarddata)){
                                                echo $stockcarddata[0]['uvprincipal'];
                                            }//endi f
                                    echo '"type="text" class="moduletxt txtprincipal input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none" class ="principallookup proplookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                                        </div>

                                        <input type="hidden" class="stockuvprincipalid moduletxt" value="';
                                            if(isset($stockcarddata)){
                                                echo $stockcarddata[0]['uvprincipalid'];
                                            }//end if
                                        echo'" name="uvprincipalid">
                                    </h6>';

                                    echo '<h6 '.$orgstyler.' class="aimslabel"><b>'.$group.'  </b>
                                        <div class="input-group">
                                            <input disabled="true" name = "groupid" value ="';
                                            if(isset($stockcarddata)){
                                                echo $stockcarddata[0]['groupid'];
                                            }
                                    echo '" type="text" class="moduletxt txtgroupid input-sm form-control"><div class="frmdocumentno input-group-addon"><a style="display:none;" class ="grouplookup proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                        </div>
                                    <input type="hidden" class="stockgrpid moduletxt" value="';
                                        if(isset($stockcarddata)){
                                            echo $stockcarddata[0]['stockgrpid'];
                                        }
                                    echo'" name="stockgrpid">
                                    </h6>';
                                break;
                            }//END SWITCH
                            ?>

                            
                            <?php
                                switch (Yii::$app->systemsettings->companyConfig()) {
                                    case 'UNIVERSE':
                                        echo '<h6 class="aimslabel"><b>Department:</b>
                                        <div class="input-group">
                                        <input disabled="true"  name="department" value ="';
                                        if(isset($stockcarddata)){
                                        echo $stockcarddata[0]['uv_department'];
                                        }
                                        echo '" type="text" class="moduletxt txt_uvdepartment form-control input-sm">
                                        <div class="frmdepartment input-group-addon"><a style="display:none;" class ="proplookup departmentlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                        </div>
                                        </h6>';
                                    break;
                                    
                                    default:
                                        //TODO CODE
                                    break;
                                }//end switch
                            ?>

                        <?php
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'UNIVERSE': case 'MLCP':
                                $style = 'style="display: none;"';
                            break;

                            default:
                                $style = 'style="display:block;"';
                            break;
                        }//END SWITCH
                        ?>


                        <h6 class="aimslabel" <?php echo $style; ?>><b>
                          
                          <?php
                           switch (Yii::$app->systemsettings->companyConfig()) {
                              default:
                                  echo '<b>Category:  </b>';
                              break;
                          }//end switch
                          ?>

                        </b>   
                          <div class="input-group">
                            <input  disabled="true" name = "category" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['category'];}?> "type="text" class="moduletxt txtcategory input-sm form-control">
                            <div class="frmdocumentno input-group-addon">
                              <a style="display:none;" class ="categorylookup proplookup" href="#">
                                <i class="fa fa-chevron-circle-down" ></i>
                              </a>
                            </div>
                          </div>
                        </h6>

                        <?php 
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            
                            case 'TENPLUS':
                            echo '<h6 class="aimslabel" style="display:block;">
                            <b>Handling Fee[Shoppee]%: <input name="itemhandling2" value ="';
                                if(isset($stockcarddata)){
                                    echo $stockcarddata[0]['itemhandling2'];
                                }//end if
                            echo '" type="text" class="moduletxt txtitemhandling2 form-control input-sm" disabled="true"></b>
                            </h6>';
                            break;

                            
                        }//end switch
                        ?>

                        <?php
                        switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'MLCP':
                              echo '<h6 class="aimslabel"><b>JO Width:
                                      <input disabled type="text" name="fg_jowidth" class="txtfgjowidth moduletxt form-control input-sm" value="';
                                if(isset($stockcarddata)){echo $stockcarddata[0]['fg_jowidth'];}
                              echo '"></b>
                              </h6>

                              <h6 class="aimslabel"><b>JO Length:
                                  <input disabled type="text" name="fg_jolength" class="txtfgjolength moduletxt form-control input-sm" value="';
                                if(isset($stockcarddata)){echo $stockcarddata[0]['fg_jolength'];}
                              echo '"></b>
                              </h6>';

                              

                              echo '<h6 class="aimslabel"><b>';
                              echo '<b>Diameter:  </b>';                                
                              echo '</b>   
                                      <input  disabled="true" name = "diameter" value ="';
                              if(isset($stockcarddata)){echo $stockcarddata[0]['fg_diameter'];}
                              echo '" type="text" class="moduletxt txtfgdiameter input-sm form-control">
                                    </h6>'; 
                              
                              echo'<h6 class="aimslabel"><b>Thickness:
                                <input disabled type="text" name="fg_thickness" class="txtfgthickness moduletxt form-control input-sm" value="';
                                if(isset($stockcarddata)){echo $stockcarddata[0]['fg_thickness'];}
                              echo '"></b>
                              </h6>';                              

                              echo '<h6 class="aimslabel"><b>Serial: 
                                <input disabled type="text" name="fg_serial" class="txtfgserial moduletxt form-control input-sm" value="';
                                if(isset($stockcarddata)){echo $stockcarddata[0]['fg_serial'];}
                              echo '"></b>
                              </h6>';

                            break;
                        }//END SWITCH
                        ?>

                        
                             
                          
                        </div><!-- /.col -->

                        <?php
                          switch (Yii::$app->systemsettings->companyConfig()) {
                            case 'MLCP':
                              //ADD ANOTHER DIV COLUMN FOR UNITS
                              echo '<div class="invoice-col col-md-2">';
                                    echo '
                                    <h6 class="aimslabel"><b>Unit:
                                      <select disabled name="fg_jowidthuom" class="stockcardfgunit fg_jowidthuom moduletxt input-sm form-control">';
                                      if(isset($stockcarddata)){echo '<option>'. $stockcarddata[0]['fg_jowidthuom'] . '</option>';}
                                      echo '</select>
                                      </b>
                                    </h6>
                                    <h6 class="aimslabel"><b>Unit:
                                      <select disabled name="fg_jolengthuom" class="stockcardfgunit fg_jolengthuom moduletxt input-sm form-control">';
                                      if(isset($stockcarddata)){echo '<option>'. $stockcarddata[0]['fg_jolengthuom'] . '</option>';}
                                      echo '</select>
                                      </b>
                                    </h6>
                                    <h6 class="aimslabel"><b>Unit:
                                      <select disabled name="fgunit_diameter" class="stockcardfgunit fgunit_diameter moduletxt input-sm form-control">';
                                      if(isset($stockcarddata)){echo '<option>'. $stockcarddata[0]['fgunit_diameter'] . '</option>';}
                                      echo '</select>
                                      </b>
                                    </h6>
                                    <h6 class="aimslabel"><b>Unit:
                                      <select disabled name="fg_thicknessuom" class="stockcardfgunit fg_thicknessuom moduletxt input-sm form-control">';
                                      if(isset($stockcarddata)){echo '<option>'. $stockcarddata[0]['fg_thicknessuom'] . '</option>';}
                                      echo '</select>
                                      </b>
                                    </h6>';   
                              echo '</div><!-- /.col -->';
                            break;
                          }//end swithc
                        ?>

                        <div class="invoice-col col-md-3">

                            <h6 class="aimslabel"><b>Itemrem: <textarea  disabled="true" name="itemrem" class="moduletxt txtitemrem form-control" style="resize:none;" rows="2" cols="50"><?php if(isset($stockcarddata)){echo $stockcarddata[0]['itemrem'];}?></textarea></b></h6>
                            

                            <?php
                            $datetoday = date("Y-m-d");
                            $date = strtotime($datetoday .' -6 months');
                            $finaldate=date('Y-m-d', $date);
                            ?> 

                            <h6 class="aimslabel viewbyfilters"><b>View by Date:  </b>
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php echo $finaldate; ?>"  class="paedit input-group date dpYears">
                            <div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            <input type="text" name = "ledgerdateid" value="<?php echo $finaldate; ?>" size="12" class="viewbydateid form-control input-sm" >
                            </div>
                            </h6>

                            <h6 class="aimslabel viewbyfilters"><b>View by UOM: </b>
                            <div class="input-group">
                            <input disabled="true" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['uom'];} ?>" type="text" class="viewbyuom form-control input-sm">
                            <div class="frmwh input-group-addon"><a class ="selectuompop" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                            </h6>


                            <!-- <h6 class="aimslabel viewbyfilters"><b>View by UOM: </b>
                             <select id="viewbyuom" class="selectuompopup input-sm form-control"></select>
                            </h6>
 -->
                            <h6 class="aimslabel viewbyfilters"><b>View by Warehouse:</b>
                            <div class="input-group">
                            <input disabled="true" name="warehouse" value ="<?php echo Yii::$app->session['loggeduser']['whname'].'~'.Yii::$app->session['loggeduser']['whcode']; ?>" type="text" class="viewbywh form-control input-sm">
                            <div class="frmwh input-group-addon"><a class ="whlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            </div>
                            </h6>


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
                  <li id="clickledger" class="stockcardtabs"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Ledger</a></li>
                  <li id="clickrv" class="stockcardtabs"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Receiving</a></li>
                  <?php  
                    switch(Yii::$app->systemsettings->companyConfig()) {
                        case 'CANUMAY':
                            echo '<li class="stockcardtabs" id="clickpo" style="display:none;"><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">PO</a></li>';
                        break;
                        default:
                            echo '<li class="stockcardtabs" id="clickpo"><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">PO</a></li>';
                        break;
                    }//end if
                  ?>
                  <li class="stockcardtabs" id="clickso"><a href="#tab_4" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">SO</a></li>
                  <!-- <li class="" id="clickwh"><a href="#tab_5" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Warehouse</a></li> -->
                  <li class="active stockcardtabs" id="clickprop"><a href="#tab_6" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Properties</a></li>
                  <li class="stockcardtabs" id="clickprice"><a href="#tab_7" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Price</a></li>
                  <li class="clickable stockcardtabs stockcarduom"><a aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">UOM</a></li>

                  <?php
                    if(Yii::$app->systemsettings->enableFrontendDetails_Backend()){
                      echo '<li class="clickable stockcardtabs" id="clickfrontenddetail"><a href="#tab_8" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Online Details</a></li>';
                    }//end if
                  ?>

                  <?php
                    if(Yii::$app->systemsettings->enableFrontendDetails_Backend()){
                      echo '<li class="clickable stockcardtabs" id="clickgallery"><a href="#tab_9" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Gallery</a></li>';
                    }//end if
                  ?>

                  <li class="stockcardtabs" id='clickcomponents'><a href="#tab_12" data-toggle="tab" aria-expanded="true" style="font-weight:bold;text-shadow:0 1px 0 rgba(255, 255, 255, 0.5);">Components</a></li>

                  <li class="stockcardtabs" id="clickwh"><a href="#tab_5" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">WH</a></li>

                  <?php  
                    switch(Yii::$app->systemsettings->companyConfig()) {
                        case 'UNIVERSE':
                            echo '<li class="stockcardtabs" id="clickspc"><a href="#tab_10" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Supp. Price Change</a></li>';
                        break;
                        default:
                          echo '<li class="stockcardtabs" id="clickspc" style="display:none;"><a href="#tab_10" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Supp. Price Change</a></li>';
                        break;
                    }//end if
                  ?>

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

                <div class="tab-pane" id="tab_12">
                    <button style ="margin-bottom: 10px;" type="button" class="btn btn-xs btn-flat btn-primary btn-sm btnaddcomponentitem3"><i class="fa fa-plus"></i>  ADD COMPONENT</button>
                    <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                        <div class="stockcomponents"></div>
                    </div><!-- /.box -->
                </div>

                <div class="tab-pane" id="tab_10">
                    <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                        <div class="stockcard-spc"></div>
                    </div><!-- /.box -->
                </div>
            
                <div class="tab-pane" id="tab_9">
                        <div class="box box-solid box-success" style="margin-bottom:-0px;">
                        <label style="margin-top:15px;margin-left: 15px;" class="aimslabel">REQUIRED: Dimension of (700 x 850) and resolution (96)</label>
                            <div class="box-body">
                                <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g1']) || is_null($stockcarddata[0]['g1'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g1'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="1" class="attachpic clickable thumbnail gallerypic-1">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-1" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-1" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-1" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-1" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-1" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                    <label class="aimslabel">This would be the primary product image.</label>

                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g2']) || is_null($stockcarddata[0]['g2'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g2'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="2" class="attachpic clickable thumbnail gallerypic-2">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-2" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-2" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-2" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-2" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-2" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                    <br>
                                </div><!-- /.col -->

                                <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g3']) || is_null($stockcarddata[0]['g3'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g3'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="3" class="attachpic clickable thumbnail gallerypic-3">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-3" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-3" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-3" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-3" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-3" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                    <br>

                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g4']) || is_null($stockcarddata[0]['g4'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g4'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="4" class="attachpic clickable thumbnail gallerypic-4">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-4" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-4" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-4" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-4" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-4" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                </div><!-- /.col -->


                                <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g5']) || is_null($stockcarddata[0]['g5'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g5'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="5" class="attachpic clickable thumbnail gallerypic-5">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-5" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-5" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-5" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-5" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-5" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                    <br>

                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g6']) || is_null($stockcarddata[0]['g6'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g6'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="6" class="attachpic clickable thumbnail gallerypic-6">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-6" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-6" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-6" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-6" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-6" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                </div><!-- /.col -->

                                <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g7']) || is_null($stockcarddata[0]['g7'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g7'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="7" class="attachpic clickable thumbnail gallerypic-7">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-7" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-7" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-7" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-7" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-7" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                    <br>
                                    <h6 class="aimslabel picbox">
                                    <?php if(isset($stockcarddata)){
                                        if(empty($stockcarddata[0]['g8']) || is_null($stockcarddata[0]['g8'])){
                                            $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                        }else{
                                            $str = $stockcarddata[0]['g8'];
                                        }
                                    }else{
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }
                                    ?>
                                    <img src ="<?php echo $str; ?>" width="160px" height ="150px" i="8" class="attachpic clickable thumbnail gallerypic-8">
                                    <?php
                                    $url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <form class="galleryupload" id="galleryupload-8" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="guploadedpicture-8" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="guploadedpicture-8" class="guploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span>

                                    <button type = "submit" id="guploadsave-8" class="guploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="guploadcancel-8" class="guploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                                    </form>
                                    </h6>
                                </div><!-- /.col -->

                                
                            </div><!-- /.box-body -->
                            </div><!-- /.box -->
                </div><!-- /.TAB PANE -->

           <div class="tab-pane" id="tab_1">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockcardledger"></div>  
                </div><!-- /.box -->
            </div><!-- /.TAB PANE -->

            <div class="tab-pane" id="tab_5">
                <div class="box box-solid box-success boxholder" style="margin-bottom:-0px;">
                    <div class="stockwh"></div>
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

                 <div class="tab-pane active" id="tab_6">
                        <div class="box box-solid box-success" style="margin-bottom:-0px;">
                            <div class="box-body">
                                <div class="invoice-col col-md-4">
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Days to Expiry: </b>
                                    <input name="daystoexpire" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['expiryday'];}?>" type="text" class="moduletxt txtdaystoexpire form-control input-sm" disabled="true">
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Maximum: </b>
                                    <input name="maximum" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['maximum'];}?>" type="text" class="moduletxt txtmax form-control input-sm" disabled="true">
                                    </h6>

                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Minimum: <input name="minimum" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['minimum'];}?>" type="text" class="moduletxt txtmin form-control input-sm" disabled="true"></b>
                                    </h6>


                                     <h6 class="aimslabel" style="display:block;">
                                        <b>Critical:<input name="critical" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['critical'];}?>" type="text" class="moduletxt txtcritical form-control input-sm" disabled="true"></b>
                                    </h6>

                                     <h6 class="aimslabel" style="display:block;">
                                        <b>Reorder: <input name="reorder" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['reorder'];}?>" type="text" class="moduletxt txtreorder form-control input-sm" disabled="true"></b>
                                    </h6>

                                    <div class="col-md-6">
                                        <input disabled="true" name = "isinactive" style="margin-left:7px;" class ="iteminactive itemboxes" type="checkbox" <?php if(isset($stockcarddata)){if($stockcarddata[0]['isinactive'] == 1){ echo 'checked';}}?>>&nbsp;<label>Inactive </label><br>
                                        <input disabled="true" name = "itemisvat" style="margin-left:7px;" class ="itemboxes itemisvat" type="checkbox" <?php if(isset($stockcarddata)){if($stockcarddata[0]['isvat'] == 1){ echo 'checked';}}?>>&nbsp;<label>Vat </label><br>
                                        <input disabled="true" name = "isimport" style="margin-left:7px;" class ="itemboxes itemimport" type="checkbox" <?php if(isset($stockcarddata)){if($stockcarddata[0]['isimport'] == 1){ echo 'checked';}}?>>&nbsp;<label>Imported </label><br>
                                    </div>
                                    <div class="col-md-6">
                                        <input disabled="true" name = "isfinishedgood" style="margin-left:7px;" class="itemisfinishedgood itemboxes" type="checkbox" <?php if(isset($stockcarddata)){if($stockcarddata[0]['fg_isfinishedgood'] == 1){ echo 'checked';}}?>>&nbsp;<label>Finished Good</label><br>
                                    </div>

                                    <div class="col-md-6">
                                        <input disabled="true" name = "isequipmenttool" style="margin-left:7px;" class="itemisequipmenttool itemboxes" type="checkbox" <?php if(isset($stockcarddata)){if($stockcarddata[0]['fg_isequipmenttool'] == 1){ echo 'checked';}}?>>&nbsp;<label>Equipment Tool</label><br>
                                    </div>
                                </div><!-- /.col -->

                                <div class="invoice-col col-md-4">
                                    <h6 class="aimslabel"><b>Assets:</b>
                                <div class="input-group">
                                    <input  disabled="true" name="asset" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['asset'];}?>" type="text" class="moduletxt txtasset form-control input-sm">
                                    <div class="input-group-addon"><a style="display:none;" class ="btnstockcardasset proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                </div></h6>

                                <h6 class="aimslabel"><b>Liabilities:</b>
                                <div class="input-group">
                                    <input  disabled="true" name="liability" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['liability'];}?>" type="text" class="moduletxt txtliability form-control input-sm">
                                    <div class="input-group-addon"><a style="display:none;" class ="btnstockcardliab proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                </div></h6>

                                <h6 class="aimslabel"><b>Revenue:</b>
                                <div class="input-group">
                                    <input  disabled="true" name="revenue" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['revenue'];}?>" type="text" class="moduletxt txtrevenue form-control input-sm">
                                    <div class="input-group-addon"><a style="display:none;" class ="btnstockcardrev proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                </div></h6>

                                <h6 class="aimslabel"><b>Expense:</b>
                                <div class="input-group">
                                    <input  disabled="true" name="expense" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['expense'];}?>" type="text" class="moduletxt txtexpense form-control input-sm">
                                    <div class="input-group-addon"><a style="display:none;" class ="btnstockexp proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                </div></h6>
                                    
                                <?php
                                    if(Yii::$app->session['loggeduser']['access'][3306] == 1){
                                        echo '<h6 class="aimslabel clickable view-movement" style="margin-top:3em;color:#595959;"><b><i class="fa fa-eye"></i> VIEW MOVEMENT</b></h6>';
                                        echo '<h6 class="aimslabel clickable item-recalc" style="margin-top:1em;color:#595959;"><b><i class="fa fa-refresh"></i> RECALC ITEM</b></h6>';
                                    }//end if
                                ?>
                                </div><!-- /.col -->
                                
                                <div class="invoice-col col-md-4">
                                <h6 class="aimslabel picbox">
                                <?php if(isset($stockcarddata)){
                                    if(empty($stockcarddata[0]['picture'])){
                                        $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                    }else{
                                        $str = $stockcarddata[0]['picture'];
                                    }
                                }else{
                                    $str = Yii::$app->homeUrl.'frontendassets/images/product-details/defaultimg.jpg';    
                                }
                                ?>
                                <img src ="<?php echo $str; ?>" width="160px" height ="150px" class="clickable thumbnail recordpicture">
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
                                <label class="aimslabel">This would be the primary image for Primary Lane Items.</label>
                                <label class="aimslabel">REQUIRED: Dimension of (285 x 228) and resolution (72)</label>
                                </div><!-- /.col -->
                            </div><!-- /.box-body -->
                            </div><!-- /.box -->
                </div><!-- /.TAB PANE -->


                <?php
                  switch (Yii::$app->systemsettings->companyConfig()) {
                    case 'KINGGEORGE':
                      $r_label = "COD";
                      $w_label = "30D";
                      $a_label = "60D";
                      $b_label = "90D";
                      $a_col = "col-md-6";
                      $b_col = "col-md-6";
                      $displayprices = "style='display:none;'";
                    break;
                    
                    default:
                      $r_label = "R";
                      $w_label = "W";
                      $a_label = "A";
                      $b_label = "B";
                      $a_col = "col-md-2";
                      $b_col = "col-md-2";
                      $displayprices = "style='display:block;'";
                    break;
                  }//END switch
                ?>
                <div class="tab-pane" id="tab_7">
                        <div class="box box-solid box-success" style="margin-bottom:-0px;">
                            <div class="box-body">
                               <div class="invoice-col col-md-6">
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>[<?php echo $r_label; ?>] Retail / (Original Price for Frontend): <input name="amt" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt'];}?>" type="text" class="moduletxt txtamt form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc'];}?>" type="text" class="moduletxt txtdisc form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-6">
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>[<?php echo $w_label; ?>] Whole Sale: <input name="amt2" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt2'];}?>" type="text" class="moduletxt txtamt2 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                        <b>Discount: <input name="disc2" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc2'];}?>" type="text" class="moduletxt txtdisc2 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col <?php echo $a_col; ?>">
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[<?php echo $a_label; ?>] Group 1 : <?php if(Yii::$app->systemsettings->companyConfig() == "TENPLUS"){ echo '(Lazada Price)'; }?><input name="amt4" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt4'];}?>" type="text" class="moduletxt txtamt4 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc3" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc3'];}?>" type="text" class="moduletxt txtdisc3 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col <?php echo $b_col; ?>">
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[<?php echo $b_label; ?>] Group 2: <?php if(Yii::$app->systemsettings->companyConfig() == "TENPLUS"){ echo '(Shopee Price)'; }?><input name="famt" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['famt'];}?>" type="text" class="moduletxt txtfamt form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc4" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc4'];}?>" type="text" class="moduletxt txtdisc4 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[C] Group 3: <input name="amt5" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt5'];}?>" type="text" class="moduletxt txtamt5 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc5" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc5'];}?>" type="text" class="moduletxt txtdisc5 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[D] Group 4: <input name="amt6" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt6'];}?>" type="text" class="moduletxt txtamt6 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc6" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc6'];}?>" type="text" class="moduletxt txtdisc6 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[E] Group 5: <input name="amt7" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt7'];}?>" type="text" class="moduletxt txtamt7 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc7" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc7'];}?>" type="text" class="moduletxt txtdisc7 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[F] Group 6: <input name="amt8" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt8'];}?>" type="text" class="moduletxt txtamt8 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc8" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc8'];}?>" type="text" class="moduletxt txtdisc8 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[G] Group 7: <input name="amt9" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt9'];}?>" type="text" class="moduletxt txtamt9 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc9" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc9'];}?>" type="text" class="moduletxt txtdisc9 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[H] Group 8: <input name="amt10" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt10'];}?>" type="text" class="moduletxt txtamt10 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc10" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc10'];}?>" type="text" class="moduletxt txtdisc10 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[I] Group 9: <input name="amt11" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt11'];}?>" type="text" class="moduletxt txtamt11 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc11" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc11'];}?>" type="text" class="moduletxt txtdisc11 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[J] Group 10: <input name="amt12" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt12'];}?>" type="text" class="moduletxt txtamt12 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc12" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc12'];}?>" type="text" class="moduletxt txtdisc12 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[K] Group 11: <input name="amt13" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt13'];}?>" type="text" class="moduletxt txtamt13 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc13" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc13'];}?>" type="text" class="moduletxt txtdisc13 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-2" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[L] Group 12: <input name="amt14" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt14'];}?>" type="text" class="moduletxt txtamt14 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc14" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc14'];}?>" type="text" class="moduletxt txtdisc14 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->

                                  <div class="invoice-col col-md-12" <?php echo $displayprices; ?>>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>[M] Group 13: <input name="amt15" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['amt15'];}?>" type="text" class="moduletxt txtamt15 form-control input-sm" disabled="true"></b>
                                    </h6>
                                    <h6 class="aimslabel" style="display:block;">
                                    <b>Discount: <input name="disc15" value ="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['disc15'];}?>" type="text" class="moduletxt txtdisc15 form-control input-sm" disabled="true"></b>
                                    </h6>
                                  </div><!-- /.col -->
                            </div><!-- /.box-body -->
                            </div><!-- /.box -->
                </div><!-- /.TAB PANE -->
                </div> <!-- END TAB CONTENT -->
            </div> <!-- END TAB CUSTOMS -->
        </div> <!-- END TAB CONTENT -->
    </div> <!-- END NAV CUSTOM -->
</div>
</div>