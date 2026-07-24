<div class="row">
<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>
              <?php
              switch (Yii::$app->systemsettings->companyConfig()) {
                case 'INDUSTRIA':
                  echo '<li><a href="#tab_industria" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Pick up / Delivery Info</a></li>';
                break;
              }//END SWITCH
              ?>
              <!-- SBC EXCLUSIVES UPDATE -->
              <!-- <li class="clicksonotes"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">SBC Notes</a></li> -->
              <?php
              if($moduledata['head']['trno'] != null){
                if($moduledata['head']['isposted']){
                    echo '<li class=""><button style="margin-top:8%;margin-left: 5%;" class="multiplevoidbtn btn btn-xs btn-flat btn-danger"><i class="fa fa-times"></i> <b>Void Multiple Items</b></button></li>';
                }else{
                  if($moduledata['head']['islocked']){
                    echo '<li class=""><button style="margin-top:8%;margin-left: 5%;" class="multiplevoidbtn btn btn-xs btn-flat btn-danger" disabled><i class="fa fa-times"></i> <b>Void Multiple Items</b></button></li>';
                  }else{
                    echo '<li class=""><button style="margin-top:8%;margin-left: 5%;" class="multiplevoidbtn btn btn-xs btn-flat btn-danger" disabled><i class="fa fa-times"></i> <b>Void Multiple Items</b></button></li>';
                  }//end if islocked
                }//end if
              }else{
                echo '<li class=""><button disabled style="margin-top:8%;margin-left: 5%;display:none;" class="multiplevoidbtn btn btn-xs btn-flat btn-danger"><i class="fa fa-times"></i> <b>Void Multiple Items</b></button></li>';
              }//end if
              ?>
              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['grandtotal'];} ?></h6></li>

              <li class="pull-right"><h6 class="txtitemcount" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['itemcount'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));} ?></h6></li>

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

                  // XANDABELS

                  case 'SOUTHCENTRAL':
                    echo '<li class="pull-right"><h6 class="txttotalcbm" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL CBM: ';
                    if(isset($moduledata)){echo $moduledata['head']['totalcbm'];}
                    echo '</h6></li>';

                    echo '<li class="pull-right"><h6 class="txttotaltonnage" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">TOTAL TONNAGE: ';
                    if(isset($moduledata)){echo $moduledata['head']['totaltonnage'];}
                    echo '</h6></li>';
                  break;

                  // END XANDA
                  
              }//END SWITCH
              ?>
            </ul>
              
            <div class="tab-content">

              <!-- PER TAB CNTENT -->
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                        if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                        echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success">'
                      ?>
                      </div>
                    </div>
                  </div>
              </div>

              <!-- PER TAB CNTENT -->
              <div class="tab-pane" id="tab_industria">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="box box-solid box-success">
                            <div class="box-body"> <!-- mod-tble -->
                              <div class='col-md-4'>
                              <h6 class="aimslabel"><b>Receive type:
                                <select disabled="true" id="rtype" class="rtype input-sm form-control">
                                  <?php if(isset($moduledata)){echo '<option>'.$moduledata['head']['rtype'] . '</option>';}?>
                                </select>
                              </h6>
                              </div>

                              <div class='col-md-4'>
                              <h6 class="aimslabel"><b>Date: 
                              <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?php date('Y-m-d');?>"  class="paedit input-group date dpYears">
                              <input type="text" name = "rdate" readonly="" value="<?php if(isset($moduledata)){echo $moduledata['head']['rdate'];}?>" size="12" class="moduletxt txtrdateid form-control input-sm" disabled="true">
                              <div class="dateid-lookup input-group-addon add-on"><a href="#" class='jlookupbtns' style='display:none;'>
                              <i class="fa fa-chevron-circle-down"></i></a></div>
                              </div></b></h6>
                              </div>
                            </div>
                      </div>
                    </div>
                  </div>
              </div>


            </div><!-- /.tab-content -->
          </div>
</div>
</div>
