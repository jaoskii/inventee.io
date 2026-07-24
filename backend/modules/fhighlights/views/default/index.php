<?php
use yii\helpers\Url;
$this->title = 'Manage Highlights';
?>


<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type="hidden" class="modifyhighkey" value="">
    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
<div class="row">
<div class="col-md-6">
        <div class="box box-solid box-success">
               

                <div class="box-body">  
                <div class="col-md-7">
                  <div class="input-group">
                    <input value ="" type="text" class="fhtxtsearchhighlight input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
                </div>

                <div class="col-md-5">
                    <button class="addnewhighlightbtn col-md-12 btn btn-flat btn-primary"><i class="fa fa-plus"></i> Create Highlights</button>
                </div>

                </div><!-- /.box-body -->
        </div><!-- /.box -->

        <label class="aimslabel">NOTE: Click the highlight description to show & edit images.</label>
        <div class="box box-solid box-success">
               <div class="box-body scroll-divs">

                            <table class="table tbl-fix bodytable">
                              <thead>
                                  <tr>
                                    <th class="col-checkbox btblleft aimslabel"><span class="text">Featured</span></th>
                                    <th class="col-min btblleft aimslabel"><span class="text">Option</span></th>
                                    <th class="col-codes aimslabel"><span class="text">Highlight Description</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody fhighlighttbl">
                                    <?php
                                        $strhtml = "";
                                        if(!empty($highlights)){
                                          foreach ($highlights as $key => $value) {
                                            if($value['high_desc'] != ''){
                                                $strhtml = $strhtml . '<tr>';
                                                $strhtml = $strhtml . '<td class="col-checkbox btblleft aimslabel">';
                                                if($value['isfeatured']){
                                                  $strhtml = $strhtml . '<input type="checkbox" class="fhenablefrontend" id="fhenable-'.$value['highkey'].'" checked>';
                                                }else{
                                                  $strhtml = $strhtml . '<input type="checkbox" class="fhenablefrontend" id="fhenable-'.$value['highkey'].'">';
                                                }///end if
                                                $strhtml = $strhtml . '</td>';
                                                $strhtml = $strhtml . '<td style="margin-bottom:-5px;" id = "fhbuttons-'.$value['highkey'].'" class="fhbuttons btblleft aimslabel col-min">';
                                                $strhtml = $strhtml . '<button id="fhedit-'.$value['highkey'].'" data-toggle="tooltip" class="fheditbtn btn btn-social-icon btn-github" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-eye"></i></button>&nbsp';
                                                $strhtml = $strhtml . '<button id="fhdelete-'.$value['highkey'].'" data-toggle="tooltip" class="fhdeletebtn btn btn-social-icon btn-google" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-trash"></i></button>&nbsp';
                                                $strhtml = $strhtml . '</td>';
                                                $strhtml = $strhtml . '<td id="fhdescription-'.$value['highkey'].'" class="clickable fhdescription col-codes aimslabel">'.$value['high_desc'].'</td>';
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



<div class="fhpicdiv col-brandbanner col-md-6" style="display:none;">
        <label class="aimslabel">Set Highlight Primary Picture for: <span class="highlighttitle"></span> <br>(This picture will be used for primary highlights on frontend)</label>
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
                    <label class="aimslabel">REQUIRED: Dimension of (381 x 370) and resolution (72)</label>
                    <h6 style="margin-left:29%;" class="aimslabel picbox">
                    <img src ="" width="60%" height ="250px" class="thumbnail recordpicture">
                    <form id ="picupload" method="POST" enctype="multipart/form-data">
                    <span id="fileselector">
                        <label class="btn btn-default" for="upload-file-selector" style="margin-top:-15px;width:60%;margin-left:-10px;">
                            <input id="upload-file-selector" type="file" name="image" class="uploadedpicture" style="width: 30%;">
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

        <label class="aimslabel">Set Highlight Banner for: <span class="highlighttitle"></span></label>
        <div class="box box-solid box-success">
               <div class="box-body">
                <label class="aimslabel">REQUIRED: Dimension of (846 x 315) and resolution (72)</label>
                    <!-- <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="fhbannerpic thumbnail">
                      <form class="highlightbannerupload" id="fhbannerupload-1" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="fhuploadedpicture" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="fhuploadedpicture" class="fhuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="fhuploadsave" class="fhuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="fhuploadcancel" class="fhuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6> -->

                    <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="thumbnail bannerpic">
                      <form class="bannerupload" id="bannerupload-1" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="buploadedpicture-1" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="buploadedpicture-1" class="buploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="buploadsave-1" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="buploadcancel-1" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                    </h6>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div> <!-- END ROW -->


    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
