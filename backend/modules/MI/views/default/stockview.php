<div class="row">
<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-green">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Inventory</a></li>
              <li class=""><a class="clickable showacctg" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">Accounting</a></li>

              <!-- /*SBC EXCLUSIVE ATTACHMENT UPLOADING*/ --> 
<!--               <li class="clickattachments"><a href="#tab_4" data-toggle="tab" aria-expanded="true" style="font-weight: bold;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);">SBC Attachments</a></li>
 -->              <!-- /*SBC EXCLUSIVE ATTACHMENT UPLOADING*/ --> 

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
              }//END SWITCH
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

              <!-- /*SBC EXCLUSIVE ATTACHMENT UPLOADING*/ -->
              <!-- <div class="tab-pane" id="tab_4">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-success">
                          <div class="box-body">

                            <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox attachment_1">
                                    <img src ="" width="160px" height ="150px" class="thumbnail attach-1"> -->
                                    <?php
                                    //$url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <!-- <form class="attachupload" id="attachupload-1" method="POST" enctype="multipart/form-data">
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
                                </div> --><!-- /.col -->

<!--                                 <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox attachment_2">
                                    <img src ="" width="160px" height ="150px" class="thumbnail attach-2"> -->
                                    <?php
                                    //$url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <!-- <form class="attachupload" id="attachupload-2" method="POST" enctype="multipart/form-data">
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
                                </div> --><!-- /.col -->


                                <!-- <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox attachment_3">
                                    <img src ="" width="160px" height ="150px" class="thumbnail attach-3">
                                    <?php
                                    //$url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
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
                                </div> --><!-- /.col -->

                                <!-- <div class="invoice-col col-md-3">
                                    <h6 class="aimslabel picbox attachment_4">
                                    <img src ="" width="160px" height ="150px" class="thumbnail attach-4"> -->
                                    <?php
                                    //$url = "/". $moduleid ."/". "uploadpic/";
                                    ?>
                                    <!-- <form class="attachupload" id="attachupload-4" method="POST" enctype="multipart/form-data">
                                    <span id="fileselector">
                                        <label class="btn btn-default" for="attachuploadedpicture-4" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                            <input type="file" name="image" id="attachuploadedpicture-4" class="attachuploadedpicture">
                                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                                        </label>
                                    </span> -->

                                    <!-- <button type = "submit" id="attachuploadsave-4" class="attachuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                                    <button type = "button" id="attachuploadcancel-4" class="attachuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button> -->
                                    <!-- </form>
                                    </h6>
                                </div> --><!-- /.col -->

                          <!-- </div>
                        </div>/.box
                     </div> -->
                  <!-- </div>
              </div> -->
              <!-- /*SBC EXCLUSIVE ATTACHMENT UPLOADING*/ -->


              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
</div>
</div>