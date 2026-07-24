<?php
use yii\helpers\Url;
$this->title = 'Finished Goods';

$script = <<< JS
    $(document).ready(function(){ 
        $('#fgcolortab').click();
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="itemid" name ="itemid" class="moduletxt" value="<?php if(isset($data)){echo $data[0]['itemid'];} ?>">
    <div class="col-md-12">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                <b><h6 class="txtitemid" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Item ID: <?php if(isset($data)){echo $data[0]['itemid'];} ?></h6></b>
                <div class="pull-right">
                    <div class="btn-group">
                        <?php if(isset($data)) { ?>
                            <button class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                            <button class="btn btn-default btn-success headbtn btnactive module-btnedit" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                            <button class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
                            <button id="<?= $moduleid.'-btnnavfirst' ?>" class="btn-navs btn btn-default btn-success btn-navfirst"><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                            <button id="<?= $moduleid.'-btn-navprev' ?>" class="btn-navs btn btn-default btn-success btn-navprev"><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                            <button id="<?= $moduleid.'-btnnavnext' ?>" class="btn-navs btn btn-default btn-success btn-navnext"><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                            <button id="<?= $moduleid.'-btnnavlast' ?>" class="btn-navs btn btn-default btn-success btn-navlast"><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                        <?php } else { ?>
                            <button class="btn btn-default btn-success headbtn module-btnsave" style="display:none;"><b><i class="save_btn fa fa-save"></i> Save</b></button>
                            <button class="btn btn-default btn-success headbtn btnactive module-btnedit" style="display:none;" ><b><i class="fa fa-pencil edit_btn"></i> Edit</b></button>
                            <button class="btn btn-default btn-success headbtn module-btncancel" style="display:none;"><b><i class="cancel_btn fa fa-times"></i> Cancel</b></button>
                            <button id="<?= $moduleid.'-btnnavfirst' ?>" class="btn-navs btn btn-default btn-success btn-navfirst" disabled><b><i class="fa fa-fast-backward page_nav_icons"></i></b></button>
                            <button id="<?= $moduleid.'-btn-navprev' ?>" class="btn-navs btn btn-default btn-success btn-navprev" disabled><b><i class="fa fa-backward page_nav_icons"></i></b></button>
                            <button id="<?= $moduleid.'-btnnavnext' ?>" class="btn-navs btn btn-default btn-success btn-navnext" disabled><b><i class="fa fa-forward page_nav_icons"></i></b></button>
                            <button id="<?= $moduleid.'-btnnavlast' ?>" class="btn-navs btn btn-default btn-success btn-navlast" disabled><b><i class="fa fa-fast-forward page_nav_icons"></i></b></button>
                        <?php } ?>
                    </div>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="pull-right" style="margin-top:-15px;"></div>
                <div class="invoice-info col-md-12" style="margin-left:-15px;">
                    <div class="row">
                        <div class="invoice-col col-md-4">
                            <h6 class="aimslabel"><b>Barcode:
                                <div class="input-group">
                                    <input type="text" name="barcode" value="<?php if(isset($data)) {echo $data[0]['barcode'];} ?>" class="moduletxt txtbarcode input-sm form-control">
                                    <div class="frmdocumentno input-group-addon"><a class="stockcardlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                </div></b>
                            </h6>
                            <h6 class="aimslabel"><b>Description:
                                <input disabled type="text" name="itemname" class="moduletxt txtitemname input-sm form-control" value="<?php if(isset($data)) {echo $data[0]['itemname'];} ?>"></b>
                            </h6>
                        </div>
                        <div class="invoice-col col-md-4">
                            <h6 class="aimslabel"><b>Revision:
                                <input disabled type="text" name="fg_revision" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_revision'];} ?>"></b>
                            </h6>
                            <h6 class="aimslabel"><b>Template No.:
                                <input disabled type="text" name="fg_templateno" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_templateno'];} ?>"></b>
                            </h6>
                        </div>
                        <div class="invoice-col col-md-4">
                            <h6 class="aimslabel"><b>Updated:  </b>
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($data)) {echo $data[0]['fg_updated'];} ?>"  class="paedit input-group date dpYears">
                            <div class="input-group-addon add-on"><a style="display:none;" class="proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            <input type="text" name = "fg_updated" readonly="" value="<?php if(isset($data)) {echo $data[0]['fg_updated'];} ?>" size="12" class="moduletxt form-control input-sm">
                            </div>
                            </h6>

                            <h6 class="aimslabel"><b>Effective:  </b>
                            <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php if(isset($data)) {echo $data[0]['fg_effective'];} ?>"  class="paedit input-group date dpYears">
                            <div class="input-group-addon add-on"><a style="display:none;" class="proplookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                            <input type="text" name="fg_effective" readonly="" value="<?php if(isset($data)) {echo $data[0]['fg_effective'];} ?>" size="12" class="moduletxt form-control input-sm">
                            </div>
                            </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="invoice-col col-md-4">
                            <h6 class="aimslabel"><b>Customer:
                                <div class="input-group">
                                    <input readonly type="text" name="fg_client" value="<?php if(isset($data)) {echo $data[0]['fg_client'];} ?>" class="txtfgcustomercode moduletxt input-sm form-control">
                                    <div class="input-group-addon"><a class="clientlookup" style="display:none;" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                                </div></b>

                                <h6 class="aimslabel"><b>Name: <input name="fg_clientname" value ="<?php if(isset($data)) {echo $data[0]['fg_clientname'];} ?>" type="text" class="moduletxt txtclientname form-control input-sm" disabled="true"></b></h6>
                            </h6>

                            <h6 class="aimslabel"><b>Product Type:
                            <div class="input-group">
                                <input readonly type="text" name="fg_prodtype" class="txtfgprodtype moduletxt form-control input-sm" value="<?php if(isset($stockcarddata)){echo $stockcarddata[0]['fg_prodtype'];} ?>"></b>
                                <div class="frmdocumentno input-group-addon">
                                  <a style="display:none;" class ="fg_prodtypelookup proplookup" href="#">
                                    <i class="fa fa-chevron-circle-down" ></i>
                                  </a>
                                </div>
                            </div>
                            </h6>

                            <h6 class="aimslabel"><b>Material Combination:
                                <input disabled type="text" name="fg_combi" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_combi'];} ?>"></b>
                            </h6>
                            
                            <h6 class="aimslabel"><b>Transformation:
                            <div class="input-group">
                                <input readonly type="text" name="fg_transform" class="txtfgtransform moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_transform'];} ?>"></b>
                                <div class="frmdocumentno input-group-addon">
                                  <a style="display:none;" class ="fg_transformlookup proplookup" href="#">
                                    <i class="fa fa-chevron-circle-down" ></i>
                                  </a>
                                </div>
                            </div>
                            </h6>

                            <!-- WTODO: [KIM][2019.10.31][add lookup for additional specs] -->
                            <h6 class="aimslabel"><b>Additional Specs:
                            <div class="input-group">
                                <input readonly type="text" name="fg_addspecs" class="txtfgaddspecs moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_addspecs'];} ?>"></b>
                                <div class="frmdocumentno input-group-addon">
                                  <a style="display:none;" class ="fg_addspecslookup proplookup" href="#">
                                    <i class="fa fa-chevron-circle-down" ></i>
                                  </a>
                                </div>
                            </div>
                            </h6>

                            <h6 class="aimslabel"><b>Punch Hole Size:
                                <input disabled type="text" name="fg_punchholesize" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_punchholesize'];} ?>"></b>
                            </h6>
                      
                            <h6 class="aimslabel"><b>Sealing:
                                <div class="input-group">
                                <input readonly type="text" name="fg_sealing" class="txtfgsealing moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_sealing'];} ?>"></b>
                                <div class="frmdocumentno input-group-addon">
                                    <a style="display:none;" class ="fg_sealinglookup proplookup" href="#">
                                        <i class="fa fa-chevron-circle-down" ></i>
                                    </a>
                                </div>
                                </div>
                            </h6>

                            <h6 class="aimslabel"><b>Plastic Color:
                                <div class="input-group">
                              <input readonly type="text" name="fg_plasticcolor" class="txtfgplasticcolor moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_plasticcolor'];} ?>"></b>
                                <div class="frmdocumentno input-group-addon">
                                    <a style="display:none;" class ="fg_plasticcolorlookup proplookup" href="#">
                                      <i class="fa fa-chevron-circle-down" ></i>
                                    </a>
                                  </div>
                                </div>
                            </h6>

                            <h6 class="aimslabel"><b>B Film Details:
                                <select disabled name="fg_bfilmdet" class="txtfgbfilmdetails moduletxt input-sm form-control">
                                  <?php if(isset($data)) {echo '<option>' . $data[0]['fg_bfilmdet'] . '</option>';} ?>
                                  </select>
                                  </b>
                            </h6>

                            <h6 class="aimslabel"><b>Treatment:
                              <select disabled name="fg_treatment" class="txtfgtreatment moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' . $data[0]['fg_treatment'] . '</option>';} ?>
                              </select>
                              </b>
                            </h6>

                        </div>
                        <div class="invoice-col col-md-4">
                            <h6 class="aimslabel"><b>JO Width:
                                <input disabled type="text" name="fg_jowidth" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_jowidth'];} ?>"></b>
                            </h6>
                            <h6 class="aimslabel"><b>JO Length:
                                <input disabled type="text" name="fg_jolength" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_jolength'];} ?>"></b>
                            </h6>
                            

                            <h6 class="aimslabel"><b>Thickness:
                                <input disabled type="text" name="fg_thickness" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_thickness'];} ?>"></b>
                            </h6>

                            <h6 class="aimslabel"><b>Actual Width:
                                <input disabled type="text" name="fg_actualwidth" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_actualwidth'];} ?>"></b>
                            </h6>
                            <h6 class="aimslabel"><b>Actual Length:
                                <input disabled type="text" name="fg_actuallength" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_actuallength'];} ?>"></b>
                            </h6>
                            <h6 class="aimslabel"><b>No. of Colors:
                                <input disabled type="text" name="fg_colornum" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_colornum'];} ?>"></b>
                            </h6>


                            <h6 class="aimslabel"><b>Grams per Piece: (From)
                                <input disabled type="text" name="fg_gramppiece1" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_gramppiece1'];} ?>"></b>
                            </h6>

                            
                            <h6 class="aimslabel"><b>No. of Outs:
                                <input disabled type="text" name="fg_outnum" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_outnum'];} ?>"></b>
                            </h6>
                            <h6 class="aimslabel"><b>B Film Width:
                                <input disabled type="text" name="fg_bfilmwidth" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_bfilmwidth'];} ?>"></b>
                            </h6>
                            <h6 class="aimslabel"><b>B Film Thickness:
                                <input disabled type="text" name="fg_thickness2" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_thickness2'];} ?>"></b>
                            </h6>

                            <h6 class="aimslabel"><b>Repeat Length:
                                <input disabled type="text" name="fg_repeatlength" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_repeatlength'];} ?>"></b>
                            </h6>

                        </div>


                        <div class="invoice-col col-md-4">
                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_jowidthuom" class="fg_jowidthuom stockcardfgunit moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' . $data[0]['fg_jowidthuom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>

                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_jolengthuom" class="fg_jolengthuom stockcardfgunit moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' .$data[0]['fg_jolengthuom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>

                            
                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_thicknessuom" class="fg_thicknessuom stockcardfgunitmic moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' .$data[0]['fg_thicknessuom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>

                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_actualwidthuom" class="fg_actualwidthuom stockcardfgunit moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' .$data[0]['fg_actualwidthuom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>
                            

                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_actuallengthuom" class="fg_actuallengthuom stockcardfgunit moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' .$data[0]['fg_actuallengthuom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>
                            
                            <h6 class="aimslabel"><b>&nbsp</b>
                            </h6>
                            <br>



                            
                            <h6 class="aimslabel"><b>Grams per Piece: (To)
                                <input disabled type="text" name="fg_gramppiece2" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['fg_gramppiece2'];} ?>"></b>
                            </h6>

                            
                            <h6 class="aimslabel"><b>&nbsp</b>
                            </h6>
                            <br>
                                
                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_bfilmwidthuom" class="stockcardfgunit fg_bfilmwidthuom moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' .$data[0]['fg_bfilmwidthuom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>

                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_thickness2uom" class="stockcardfgunitmic fg_thickness2uom moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' .$data[0]['fg_thickness2uom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>


                            <h6 class="aimslabel"><b>UNIT:
                              <select disabled name="fg_repeatlengthuom" class="stockcardfgunit fg_repeatlengthuom moduletxt input-sm form-control">
                              <?php if(isset($data)) {echo '<option>' .$data[0]['fg_repeatlengthuom']. '</option>';} ?>
                              </select>
                              </b>
                            </h6>

                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
                <li id="" class="active"><a href="#tab_1" data-toggle="tab" class="btnfgtab" aria-expanded="true" id="fgcolortab" fg="colors" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Colors</a></li>
                <li id=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" class="btnfgtab" id="fgmaterialtab" fg="material" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Material</a></li>
                <li id=""><a href="#tab_3" data-toggle="tab" aria-expanded="true" class="btnfgtab" id="fgcylindertab" fg="cylinder" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Equipment / Tool</a></li>
                <li id=""><a href="#tab_4" data-toggle="tab" aria-expanded="true" class="btnfgtab" id="fgprocesstab" fg="process" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Process</a></li>
                <?php
                if(Yii::$app->session['loggeduser']['access'][3260] == 1){
                    echo '<li id=""><a href="#tab_5" data-toggle="tab" aria-expanded="true" class="btnfgtab" id="fgpiecetab" fg="process" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Piece Rate & Qty</a></li>';
                }//end if
                ?>  
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <button class="btnaddnewfggrid1 btn btn-xs btn-flat btn-github" fg="colors">
                        <i class="fa fa-plus"></i> Add New Color</button>
                    <div class="fg_colorsdiv"></div>
                </div><!-- /.TAB PANE -->
                <div class="tab-pane" id="tab_2">
                    <button class="btnaddnewfggrid2 btn btn-xs btn-flat btn-github" fg="material">
                        <i class="fa fa-plus"></i> Add New Material</button>
                    <div class="fg_materialdiv"></div>
                </div><!-- /.TAB PANE -->
                <div class="tab-pane" id="tab_3">
                    <button class="btnaddnewfggrid3 btn btn-xs btn-flat btn-github" fg="cylinder">
                        <i class="fa fa-plus"></i> Add New Equipment/Tool</button>
                    <div class="fg_cylinderdiv"></div>
                </div><!-- /.TAB PANE -->
                <div class="tab-pane" id="tab_4">
                    <button class="btnaddnewfggrid4 btn btn-xs btn-flat btn-github" fg="process">
                        <i class="fa fa-plus"></i> Add New Process</button>
                    <div class="fg_processdiv"></div>
                </div><!-- /.TAB PANE -->

                <div class="tab-pane" id="tab_5">
                    <div class="box box-solid box-success" style="margin-bottom:-0px;">
                        <div class="box-body mod-tble">
                            <div class="invoice-col col-md-3">
                            <h6 class="aimslabel"><b>Rate:
                                <input disabled type="text" name="payrate" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['payrate'];} ?>"></b>
                            </h6>

                            <h6 class="aimslabel"><b>Quantity:
                                <input disabled type="text" name="payqty" class="moduletxt form-control input-sm" value="<?php if(isset($data)) {echo $data[0]['payqty'];} ?>"></b>
                            </h6>
                            </div>
                        </div>
                    </div>
                </div><!-- /.TAB PANE -->
            </div> <!-- END TAB CONTENT -->
        </div> <!-- END TAB CUSTOMS -->
    </div> <!-- END TAB CONTENT -->
</div> <!-- END NAV CUSTOM -->