<div class="row">
<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>
              <li class=""><a class="clickable showacctg" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>
              
              <?php 
              switch (Yii::$app->systemsettings->companyConfig()) {
                case 'CANUMAY':
                  echo '<li class=""><a class="clickable showdisc" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Set Discount</a></li>';
                break;

                // WTODO JAD 03-15-2019
                case 'SBC':
                  echo '<li class="clicksonotes"><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">SBC Notes</a></li>
                        <li class="clickattachments"><a href="#tab_4" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">SBC Attachments</a></li>
                        <li class="clickcomm"><a href="#tab_5" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Commission</a></li>';
                break;
              }//end switch
              ?>

              <li class="pull-right"><h6 class="txtgrandtotal" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">GRAND TOTAL: <?php if(isset($moduledata)){echo $moduledata['head']['grandtotal'];} ?></h6></li>

              <li class="pull-right"><h6 class="txtitemcount" style="display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight: bold;">NUMBER OF ITEMS: <?php if(isset($moduledata)){echo number_format($moduledata['head']['itemcount'],Yii::$app->systemsettings->setDecimaldisplay('quantity'));} ?></h6></li>
              <?php
                if(Yii::$app->systemsettings->companyConfig() == 'SOUTHCENTRAL') {
                  if(isset($moduledata)) {$totalcbm = $moduledata['head']['totalcbm']; $totaltons = $moduledata['head']['totaltonnage'];} else {$totalcbm = '0.00'; $totaltons = '0.00';}
                  echo ("<li class='pull-right'><h6 class='txttotalcbm' style='display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight:bold;'>TOTAL CBM: $totalcbm</h6></li>
                    <li class='pull-right'><h6 class='txttotaltonnage' style='display:block;margin-top:12px;margin-right:20px;font-size:12px;font-weight:bold;'>TOTAL TONS: $totaltons</h6></li>");
                }
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
                }
              ?>
            </ul>
              
              <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <div class="col-md-12">
                      <label class="clickable viewcopyclipboard"><i class="fa fa-copy"></i> [Copy Stock Details to Clipboard]</label>
                      <?php 
                        if($moduledata['head']['isposted']){$isposted = 1;} else {$isposted = 0;}
                        if($moduledata['head']['islocked']){$islocked = 1;} else {$islocked = 0;}
                        echo '<div id="modulestockview" poststatus="'.$isposted.'" lockedstatus="'.$islocked.'" class="box box-solid box-success"></div>'
                      ?>
                    </div>
                  </div>
              </div>

              <div class="tab-pane" id="tab_2">
                <div class="row">
                  <div class="col-md-12">
                      <button class="btn btn-success btn-xs so-add-note" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Add Note</button>
                      <div class="sonotetbl"></div>
                  </div>
                </div>
              </div> <!-- and tab_2 -->

              <div class="tab-pane" id="tab_4">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box box-solid box-success">
                      <div class="box-body">
                        <div class="invoice-col col-md-3">
                          <h6 class="aimslabel picbox attachment_1">
                            <img src ="" width="160px" height ="150px" class="thumbnail attachpic attach-1">
                            <?php $url = "/". $moduleid ."/". "uploadpic/"; ?>
                            <form class="attachupload" id="attachupload-1" method="POST" enctype="multipart/form-data">
                              <span id="fileselector">
                                <label class="btn btn-default" for="attachuploadedpicture-1" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                  <input type="file" name="image" id="attachuploadedpicture-1" class="attachuploadedpicture">
                                  <i class="fa fa-upload margin-correction"></i>Browse Pic
                                </label>
                              </span>
                              <button type = "submit" id="attachuploadsave-1" class="attachuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                              <button type = "button" id="attachuploadcancel-1" class="attachuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                            </form>
                          </h6>
                        </div><!-- /.col -->
                        <div class="invoice-col col-md-3">
                          <h6 class="aimslabel picbox attachment_2">
                            <img src ="" width="160px" height ="150px" class="thumbnail attach-2"><?php $url = "/". $moduleid ."/". "uploadpic/"; ?>
                            <form class="attachupload" id="attachupload-2" method="POST" enctype="multipart/form-data">
                              <span id="fileselector">
                                <label class="btn btn-default" for="attachuploadedpicture-2" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                  <input type="file" name="image" id="attachuploadedpicture-2" class="attachuploadedpicture">
                                  <i class="fa fa-upload margin-correction"></i>Browse Pic
                                </label>
                              </span>
                              <button type = "submit" id="attachuploadsave-2" class="attachuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                              <button type = "button" id="attachuploadcancel-2" class="attachuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                            </form>
                          </h6>
                        </div><!-- /.col -->
                        <div class="invoice-col col-md-3">
                          <h6 class="aimslabel picbox attachment_3">
                            <img src ="" width="160px" height ="150px" class="thumbnail attach-3">
                            <?php $url = "/". $moduleid ."/". "uploadpic/"; ?>
                            <form class="attachupload" id="attachupload-3" method="POST" enctype="multipart/form-data">
                              <span id="fileselector">
                                <label class="btn btn-default" for="attachuploadedpicture-3" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                  <input type="file" name="image" id="attachuploadedpicture-3" class="attachuploadedpicture">
                                  <i class="fa fa-upload margin-correction"></i>Browse Pic
                                </label>
                              </span>
                              <button type = "submit" id="attachuploadsave-3" class="attachuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                              <button type = "button" id="attachuploadcancel-3" class="attachuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                            </form>
                          </h6>
                        </div><!-- /.col -->
                        <div class="invoice-col col-md-3">
                          <h6 class="aimslabel picbox attachment_4">
                            <img src ="" width="160px" height ="150px" class="thumbnail attach-4">
                            <?php $url = "/". $moduleid ."/". "uploadpic/"; ?>
                            <form class="attachupload" id="attachupload-4" method="POST" enctype="multipart/form-data">
                              <span id="fileselector">
                                <label class="btn btn-default" for="attachuploadedpicture-4" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                  <input type="file" name="image" id="attachuploadedpicture-4" class="attachuploadedpicture">
                                  <i class="fa fa-upload margin-correction"></i>Browse Pic
                                </label>
                              </span>
                              <button type = "submit" id="attachuploadsave-4" class="attachuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                              <button type = "button" id="attachuploadcancel-4" class="attachuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                            </form>
                          </h6>
                        </div><!-- /.col -->
                      </div>
                    </div><!-- /.box -->
                  </div>
                </div>
              </div> <!-- end tab_4 -->

              <div class="tab-pane" id="tab_5">
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-success btn-xs sj-add-comm" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Add Commission Data</button>
                    <b><span style="margin-left: -15%;" class="pull-right aimslabel">Total Share Amt: <span class="totalshareamt">0.00</span></span></b>
                        <div class="commtbl"></div>
                  </div><!-- /.box -->
                </div>
              </div> <!-- end tab 5 -->
              

              <div class="tab-pane" id="otherinfodiv">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                            <div class="box-body mod-tble">
                                <?php
                                  if(Yii::$app->session['loggeduser']['access'][3131]){
                                    echo '<a tabmodal="modal-sc-receivetab" id="screceivetab" class="sjtabs btn btn-block btn-social btn-github">
                                            <i class="fa fa-download"></i> <b>Received Tab</b>
                                          </a>';
                                  }//end if

                                  if(Yii::$app->session['loggeduser']['access'][3132]){
                                    echo ' <a tabmodal="modal-sc-postdeliverytab" id="scpostdevtab" class="sjtabs btn btn-block btn-social btn-github">
                                            <i class="fa fa-truck"></i> <b>Post Delivery Tab</b>
                                          </a>';
                                  }//end if

                                  if(Yii::$app->session['loggeduser']['access'][3133]){
                                    echo '<a tabmodal="modal-sc-dispatchdiscrepancytab" id="scdispatchdisctab" class="sjtabs btn btn-block btn-social btn-github">
                                          <i class="fa fa-upload"></i> <b>Dispatch Discrepancy Tab</b>
                                        </a>';
                                  }//end if

                                  if(Yii::$app->session['loggeduser']['access'][3134]){
                                    echo '<a tabmodal="modal-sc-dispatchconfirmationtab" id="scdispatchconfirmationtab" 
                                            class="sjtabs btn btn-block btn-social btn-github">
                                            <i class="fa fa-upload"></i> <b>Dispatch Confirmation Tab</b>
                                          </a>';
                                  }//end if

                                  if(Yii::$app->session['loggeduser']['access'][3135]){
                                    echo '<a tabmodal="modal-sc-settletab" id="scsettledtab" class="sjtabs btn btn-block btn-social btn-github">
                                            <i class="fa fa-check-square"></i> <b>Settled Tab</b>
                                          </a>';
                                  }//end if


                                ?>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                  </div>
              </div>
            </div>
          </div>
</div>
</div>