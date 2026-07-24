<?php
use yii\helpers\Url;
$this->title = 'Manage Deal of the Day ';
?>


<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type="hidden" class="modifydodkey" value="">
    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
<div class="row">
<div class="col-md-4">
<label class="aimslabel">Set New DOD (Deal of the Day):</label>
        <div class="box box-solid box-success">
                <div class="box-body">
                    <button style="display:inline;" class="btnnew-dod aimslabel btn btn-flat btn-primary"><i class="fa fa-file"></i>&nbsp <b>New DOD</b></button>
                    <button style="display: none;" class="btnsave-dod managedodbtns aimslabel btn btn-flat btn-success"><i class="fa fa-save"></i>&nbsp <b>Save DOD</b></button>
                    <button style="display: none;" class="btncancel-dod managedodbtns aimslabel btn btn-flat btn-danger"><i class="fa fa-times"></i>&nbsp <b>Cancel DOD</b></button>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
<div class="col-md-8">
        <div class="box box-solid box-success">
                <div class="box-body">
                    <label class="aimslabel">Set DOD Date:</label>
                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="" class="paedit input-group date dpYears">
                      <div class="dateid-lookup input-group-addon add-on">
                      <a href="#" style="display: none;" class="managedodbtns"><i class="fa fa-chevron-circle-down"></i></a>
                      </div>
                      <input type="text" name = "dateid" readonly="" value="" size="12" class="moduletxt txtdateid form-control input-sm" disabled="true">
                    </div>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
</div>

<div class="row">
<div class="col-md-4">
        <div class="box box-solid box-success">
                <div class="box-body">  
                <label class="aimslabel">Search DOD:</label>
                  <div class="input-group">
                    <input value ="" type="text" class="fdodsearchhighlight input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
                </div><!-- /-.box-body -->
        </div><!-- /.box -->
        <label class="aimslabel">DOD List:</label>
        <div class="box box-solid box-success">
               <div class="box-body scroll-dodlist">

                            <table class="table tbl-fix bodytable">
                              <thead>
                                  <tr>
                                    <th class="col-min btblleft aimslabel"><span class="text">Option</span></th>
                                    <th class="col-codes aimslabel"><span class="text">DOD Date</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody fdodlisttbl">

                                </tbody>
                            </table>  
                </div><!-- /.box-body -->
            </div><!-- /.box -->
</div> <!-- END COL MD 3 -->



        <div class="col-md-4">
        <label class="aimslabel">Set DOD Primary Picture for: <span class="dodtitle"></span></label>
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

                        <label class="aimslabel">REQUIRED: Dimension of (574 x 228) and resolution (72)</label>
                        <h6 style="margin-top: 26px;margin-bottom: 25px;" class="aimslabel picbox">
                            <img src ="" width="100%" height ="150px" class="thumbnail recordpicture">
                            <form id="picupload" method="POST" enctype="multipart/form-data">
                            <span id="fileselector" class="fileselector" style="display:none;">
                                <label class="btn btn-default" for="upload-file-selector" style="margin-top:-15px;width:100%;margin-left:-10px;">
                                <input id="upload-file-selector" type="file" name="image" class="uploadedpicture">
                                <i class="fa fa-upload margin-correction"></i>Browse Pic
                                </label>
                            </span>

                          <button type = "submit" id="uploadsave" class="uploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                          <button type = "button" id="uploadcancel" class="uploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                          </form>
                        </h6>

                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-4">
        <label class="aimslabel">Set DOD Banner for: <span class="dodtitle"></span></label>
            <div class="box box-solid box-success">
                   <div class="box-body">
                    <label class="aimslabel">REQUIRED: Dimension of (1155 x 465) and resolution (72)</label>
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
                          <img src ="" width="100%" height ="180px" class="thumbnail bannerpic">
                          <form class="bannerupload" id="bannerupload-1" method="POST" enctype="multipart/form-data">
                          <span style="display:none;"  class = "fileselector" id="fileselector">
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
        </div>
        <div class="col-md-8">
        <label class="aimslabel">DOD Items for : <span class="dodtitle"></span></label> <button style="display:none;" class="btn btn-xs btn-success pull-right fdodadditem"><i class="fa fa-plus"></i> &nbsp Add Item</button>
            <div class="box box-solid box-success">
                    <div class="box-body scroll-doditems">
                    <table class="table tbl-fix bodytable">
                      <thead>
                          <tr>
                            <th class="col-min btblleft aimslabel"><span class="text">Option</span></th>
                            <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                            <th class="col-description aimslabel"><span class="text">Itemname</span></th>
                            <th class="col-currency aimslabel"><span class="text">Sale Price</span></th>
                            <th class="col-quantity aimslabel"><span class="text">Qty</span></th>
                          </tr>
                      </thead>
                        <tbody class="modulebody fdoditems">
                        
                        </tbody>
                    </table>  
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
</div> <!-- END ROW -->


    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
