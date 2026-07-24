<?php
use yii\helpers\Url;
$this->title = 'Manage Flash Deals';
?>


<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type="hidden" class="modifyfdkey" value="">
    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
<div class="row">
<div class="col-md-4">
<label class="aimslabel">Set New Flash Deal:</label>
        <div class="box box-solid box-success">
                <div class="box-body">
                    <button style="display:inline;" class="btnnew-fd aimslabel btn btn-flat btn-primary"><i class="fa fa-file"></i>&nbsp <b>New Flash Deal</b></button>
                    <button style="display: none;" class="btnsave-fd managefdbtns aimslabel btn btn-flat btn-success"><i class="fa fa-save"></i>&nbsp <b>Save Flash Deal</b></button>
                    <button style="display: none;" class="btncancel-fd managefdbtns aimslabel btn btn-flat btn-danger"><i class="fa fa-times"></i>&nbsp <b>Cancel Flash Deal</b></button>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
<div class="col-md-8">
        <div class="box box-solid box-success">
                <div class="box-body">
                    <div class="col-md-4">
                    <label class="aimslabel">Start Date:</label>
                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="" class="paedit input-group date dpYears">
                      <div class="dateid-lookup input-group-addon add-on">
                      <a href="#" style="display: none;" class="managefdbtns"><i class="fa fa-chevron-circle-down"></i></a>
                      </div>
                      <input type="text" name = "dateid1" readonly="" value="" size="12" class="moduletxt txtdateid1 form-control input-sm" disabled="true">
                    </div>
                    </div>

                    <div class="col-md-4">
                    <label class="aimslabel">End Date:</label>
                    <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="" class="paedit input-group date dpYears">
                      <div class="dateid-lookup input-group-addon add-on">
                      <a href="#" style="display: none;" class="managefdbtns"><i class="fa fa-chevron-circle-down"></i></a>
                      </div>
                      <input type="text" name = "dateid2" readonly="" value="" size="12" class="moduletxt txtdateid2 form-control input-sm" disabled="true">
                    </div>
                    </div>

                    <div class="col-md-4">
                    <label class="aimslabel">Set Discount:</label>
                    <input type="text" class="fdtxtdiscount form-control" disabled>
                    </div>
                </div><!-- /.box-body -->
        </div><!-- /.box -->
</div>
</div>

<div class="row">
<div class="col-md-4">
        <div class="box box-solid box-success">
                <div class="box-body">  
                <label class="aimslabel">Search Flash Deal:</label>
                  <div class="input-group">
                    <input value ="" type="text" class="fsearchfd input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
                </div><!-- /-.box-body -->
        </div><!-- /.box -->
        <label class="aimslabel">Flash Deal List:</label>
        <div class="box box-solid box-success">
               <div class="box-body scroll-dodlist">

                            <table class="table tbl-fix bodytable">
                              <thead>
                                  <tr>
                                    <th class="col-min btblleft aimslabel"><span class="text">Option</span></th>
                                    <th class="col-codes aimslabel"><span class="text">Deal Start Date</span></th>
                                    <th class="col-codes aimslabel"><span class="text">Deal End Date</span></th>
                                    <th class="col-min aimslabel"><span class="text">Discount</span></th>
                                  </tr>
                              </thead>
                                <tbody class="modulebody ffdlisttbl">

                                </tbody>
                            </table>  
                </div><!-- /.box-body -->
            </div><!-- /.box -->
</div> <!-- END COL MD 3 -->



        <div class="col-md-4">
        <label class="aimslabel">Set Flash Deal Primary Picture for: <span class="fdtitle"></span></label>
            <div class="box box-solid box-success">
                    <div class="box-body">
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
        <label class="aimslabel">Set Flash Deal Banner for: <span class="fdtitle"></span></label>
            <div class="box box-solid box-success">
                   <div class="box-body">
                    <label class="aimslabel">REQUIRED: Dimension of (1155 x 465) and resolution (72)</label>
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
        <label class="aimslabel">Flash Deal Items for : <span class="fdtitle"></span></label> <button style="display:none;" class="btn btn-xs btn-success pull-right fdadditem"><i class="fa fa-plus"></i> &nbsp Add Item</button>
            <div class="box box-solid box-success">
                    <div class="box-body scroll-doditems">
                    <table class="table tbl-fix bodytable">
                      <thead>
                          <tr>
                            <th class="col-min btblleft aimslabel"><span class="text">Option</span></th>
                            <th class="col-codes aimslabel"><span class="text">Barcode</span></th>
                            <th class="col-description aimslabel"><span class="text">Itemname</span></th>
                            <th class="col-currency aimslabel"><span class="text">Sale Price</span></th>
                          </tr>
                      </thead>
                        <tbody class="modulebody fditems">
                        
                        </tbody>
                    </table>  
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
</div> <!-- END ROW -->


    <!-- ################################################ SETTINGS LAYOUT ####################################### -->
