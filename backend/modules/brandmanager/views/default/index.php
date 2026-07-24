<?php
use yii\helpers\Url;
$this->title = "Frontend Brand Manager";
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
<div class="row">
<div class="col-md-5">
        <div class="box box-solid box-success">
               

                <div class="box-body">  
                <div class="col-md-7">
                  <div class="input-group">
                    <input value ="" type="text" class="fbrtxtsearchbrand input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
                </div>

                <div class="col-md-5">
                    <button class="addnewbrandbtn col-md-12 btn btn-flat btn-primary"><i class="fa fa-plus"></i> Add Brand</button>
                </div>

                </div><!-- /.box-body -->
        </div><!-- /.box -->

        <label class="aimslabel">NOTE: Click the brand description to show more details.</label>
        <div class="box box-solid box-success">
               <div class="box-body scroll-divs">

                            <table class="table tbl-fix bodytable">
                              <thead>
                                  <tr>
                                    <th class="col-checkbox btblcenter aimslabel"><span class="text">&nbsp</span></th>
                                    <th class="col-min btblcenter aimslabel"><span class="text">Option</span></th>
                                    <th class="col-codes aimslabel"><span class="text">Brand Description</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody fbrbrandtbl">
                                    <?php
                                        $strhtml = "";
                                        if(!empty($brandlist)){
                                          foreach ($brandlist as $key => $value) {
                                            if($value['brand'] != ''){
                                                $strhtml = $strhtml . '<tr>';
                                                $strhtml = $strhtml . '<td class="col-checkbox btblcenter aimslabel">';
                                                if($value['status']){
                                                  $strhtml = $strhtml . '<input type="checkbox" class="fbrenablefrontend" id="fbrenable-'.$value['brandid'].'" checked>';
                                                }else{
                                                  $strhtml = $strhtml . '<input type="checkbox" class="fbrenablefrontend" id="fbrenable-'.$value['brandid'].'">';
                                                }///end if
                                                $strhtml = $strhtml . '</td>';
                                                $strhtml = $strhtml . '<td style="margin-bottom:-5px;" id = "fbrbuttons-'.$value['brandid'].'" class="fbrbuttons btblcenter aimslabel col-min">';
                                                $strhtml = $strhtml . '<button id="fbredit-'.$value['brandid'].'" data-toggle="tooltip" class="fbreditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>&nbsp';
                                                $strhtml = $strhtml . '<button id="fbrdelete-'.$value['brandid'].'" data-toggle="tooltip" class="fbrdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>&nbsp';
                                                $strhtml = $strhtml . '</td>';
                                                $strhtml = $strhtml . '<td id="fbrdescription-'.$value['brandid'].'" class="clickable fbrdescription col-codes aimslabel">'.$value['brand'].'</td>';
                                                $strhtml = $strhtml . '</tr>';
                                            }//end if
                                          }//end order loop
                                        }//end if
                                        echo $strhtml;
                                    ?>
                                </tbody>
                            </table>  
                </div><!-- /.box-body -->
            </div><!-- /.box -->
</div> <!-- END COL MD 3 -->



<div class="col-brandbanner col-md-7" style="display:none;">
        <label class="aimslabel">Set Brand Primary Picture (This picture will be used for brand viewing on frontend)</label>
        <div class="box box-solid box-success">
                <div class="box-body">

<!-- 
                    <h6 style="margin-left:29%;" class="aimslabel picbox">
                       <img src ="" width="60%" height ="250px" class="brandlogo thumbnail ">
                      <form class="brandbannerupload" id="fbrbannerupload-1" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="fbrbuploadedpicture-1" style="margin-top:-15px;width:60%;margin-left:-10px;">
                              <input type="file" name="image" id="fbrbuploadedpicture-1" class="fbrbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="fbrbuploadsave-1" class="fbrbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="fbrbuploadcancel-1" class="fbrbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6>
 -->                
                    <label class="aimslabel">REQUIRED: Dimension of (130 x 50) and resolution (72)</label>
                    <h6 style="margin-left:29%;" class="aimslabel picbox">
                    <img src ="" width="60%" height ="150px" class="thumbnail recordpicture">
                    <form id ="picupload" method="POST" enctype="multipart/form-data">
                    <span id="fileselector">
                        <label class="btn btn-default" for="upload-file-selector" style="margin-top:-15px;width:60%;margin-left:-10px;">
                            <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture" style="width: 30%;">
                            <i class="fa fa-upload margin-correction"></i>Browse Pic
                        </label>
                    </span>
                    <div style="width: 60%;">
                    <button type = "submit" class="uploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                    <button type = "button" class="uploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                    </div>
                    </form>
                    </h6>

                </div><!-- /.box-body -->
        </div><!-- /.box -->

        <label class="aimslabel">Set Slider Images for: <span id="brandbannertitle"></span></label>
        <div class="box box-solid box-success">
               <div class="box-body scroll-brandinfo">
                <label class="aimslabel">REQUIRED: Dimension of (846 x 315) and resolution (72)</label>
                    <input type="hidden" id="brandmanagecode" value=""> 
                    <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="fbrbannerpic thumbnail fbrbannerpic-1">
                      <form class="brandbannerupload" id="fbrbannerupload-1" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="fbrbuploadedpicture-1" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="fbrbuploadedpicture-1" class="fbrbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="fbrbuploadsave-1" class="fbrbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="fbrbuploadcancel-1" class="fbrbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6>

                    <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="fbrbannerpic thumbnail fbrbannerpic-2">
                      <form class="brandbannerupload" id="fbrbannerupload-2" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="fbrbuploadedpicture-2" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="fbrbuploadedpicture-2" class="fbrbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="fbrbuploadsave-2" class="fbrbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="fbrbuploadcancel-2" class="fbrbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6>

                    <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="fbrbannerpic thumbnail fbrbannerpic-3">
                      <form class="brandbannerupload" id="fbrbannerupload-3" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="fbrbuploadedpicture-3" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="fbrbuploadedpicture-3" class="fbrbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="fbrbuploadsave-3" class="fbrbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="fbrbuploadcancel-3" class="fbrbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6>

                    <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="fbrbannerpic thumbnail fbrbannerpic-4">
                      <form class="brandbannerupload" id="fbrbannerupload-4" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="fbrbuploadedpicture-4" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="fbrbuploadedpicture-4" class="fbrbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="fbrbuploadsave-4" class="fbrbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="fbrbuploadcancel-4" class="fbrbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6>

                    <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="fbrbannerpic thumbnail fbrbannerpic-5">
                      <form class="brandbannerupload" id="fbrbannerupload-5" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="fbrbuploadedpicture-5" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="fbrbuploadedpicture-5" class="fbrbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="fbrbuploadsave-5" class="fbrbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="fbrbuploadcancel-5" class="fbrbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->


    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
