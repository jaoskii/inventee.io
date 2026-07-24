<div class="row">
<div class="col-md-7">
     
                  <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" class="clickable tab_showmaterials" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Material</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" class="clickable tab_showprocess" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Process</a></li>
              <li class=""><a href="#tab_4" data-toggle="tab" class="clickable tab_breakdown" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Breakdown</a></li>
              

              <?php
              switch(Yii::$app->systemsettings->companyConfig()) {
                case 'YULICK':
                  echo '<li class="pull-right"><h6 class="txttotalkilo" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL QTY: ';
                  if(isset($moduledata)){echo $moduledata['head']['totalkilo'];}
                  echo '</h6></li>';
                  break;
                
                default:
                  echo '<li style="display:none;" class="pull-right"><h6 class="txttotalkilo" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL QTY: ';
                  if(isset($moduledata)){echo $moduledata['head']['totalkilo'];}
                  echo '</h6></li>';
                  break;
              }//END SWITCH
              ?>
            </ul>
              
           <div class="tab-content">
            <h6 class="pull-right txtgrandtotal" style="display:inline;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['grandtotal'];} ?></h6>

            <h6 class="pull-right txtitemcount" style="display:inline;margin-right:15px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['itemcount'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));} ?></h6>

              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                        if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                        echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success"></div>';
                      ?>
                    </div>
                  </div>
              </div>
              <!-- /.tab-pane -->


              <div class="tab-pane" id="tab_2">
                  <div class="row">
                    <div class="col-md-12">
                      <button style= "margin-top:-50px;" class="btn btn-xs btn-flat btn-github jb_addmaterials"><i class="fa fa-plus"></i> 
                        <b>Add Item Materials</b></button>
                        <div id="jbmaterialview" class="box box-solid box-success"></div>
                    </div>
                  </div>
              </div>
              <!-- /.tab-pane -->



              <div class="tab-pane" id="tab_3">
                  <div class="row">
                    <div class="col-md-12">
                        <button style= "margin-top:-50px;" class="btn btn-xs btn-flat btn-github jb_addprocess"><i class="fa fa-plus"></i> 
                        <b>Add Item Process</b></button>
                        <div id="jbprocessview" class="box box-solid box-success"></div>
                    </div>
              </div>
              </div>
              <!-- /.tab-pane -->


              <div class="tab-pane" id="tab_4">
                  <div class="row">
                    <div class="col-md-12">
                        <button style= "margin-top:-50px;" class="btn btn-xs btn-flat btn-github jb_savebreakdown"><i class="fa fa-save"></i> 
                        <b>Save Job Order Breakdown</b></button>
                        <h6 class="aimslabel"><b>Breakdown: <textarea name="rem" class="aimslabel txtbreakdown form-control" style="resize:none;"  rows="4" cols="50"><?php if(isset($moduledata)){echo $moduledata['head']['breakdownreport'];}?></textarea></b></h6>
                    </div>
              </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
</div>


<div class="col-md-5">
     
                  <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_5" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">View FG Header</a></li>
              <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Material Guide</a></li>
              <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Color Guide</a></li>
            </ul>
              
          <div class="tab-content">
            <div class="tab-pane active" id="tab_5">
                <div class="row">
                <div class="col-md-12">        
                    <div class="box box-solid box-success">
                      <div class="box-body mod-tble">
                        <h6 class="aimslabel"><b>Barcode: <input name="barcode" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b>Description: <input name="itemname" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b>Default UOM: <input name="uom" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b>Transformation: <input name="transformation" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b>Sealing: <input name="sealing" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b>Plastic Color: <input name="plasticcolor" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <div class="col-md-6">
                        <h6 class="aimslabel"><b>JO Width: <input name="fg_jowidth" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b>JO Length: <input name="fg_jolength" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>
                        </div>

                        <div class="col-md-6">
                        <h6 class="aimslabel"><b>UOM: <input name="fg_jowidthuom" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b>UOM: <input name="fg_jolengthuom" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>
                        </div>

                        <h6 class="aimslabel"><b>Thickness: <input name="fg_thickness" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                        <h6 class="aimslabel"><b># of Colors: <input name="fg_colornum" value ="" type="text" class="fgguidetxt form-control input-sm" disabled="true"></b></h6>

                </div>
                </div>
                </div>
                </div>  
            </div>

            <div class="tab-pane" id="tab_6">
                <div class="row">
                  <div class="col-md-12">
                      <div id="jbmaterialguidegrid" class="box box-solid box-success"></div>
                  </div>
                </div>
            </div>

            <div class="tab-pane" id="tab_7">
                <div class="row">
                  <div class="col-md-12">
                      <div id="jbcolorguidegrid" class="box box-solid box-success"></div>
                  </div>
                </div>
            </div>
          </div>

          </div>
</div>

