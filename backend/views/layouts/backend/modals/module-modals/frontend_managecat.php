<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-frontendmanagecat" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceladminpass" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Manage Category</h4>
      </div>

      <div class="modal-body">
          <div class="row">
              <div class = "col-md-12">
                  <input name="managecatid" value ="" type="hidden" id="managecatid" class="managecatform form-control input-sm">
                  <h6 class="aimslabel" style="display:block;">
                      <b>Category Title: <input name="cattitle" value ="" id = "txtupdatecat" type="text" class="managecatform form-control input-sm"></b>
                  </h6>
                  <input style="margin-left:7px;margin-top:6px;" class ="cat_enabled2" type="checkbox">
                  <label class="aimslabel">Enabled</label>
              </div>
          </div>
          <br>
          <div class="row">
                  <div class = "col-md-12" style="overflow-y: scroll;height: 400px;">
                  <label class="aimslabel">Set Slider Images</label>
                  <label class="aimslabel">REQUIRED: Dimension of (846 x 315) and resolution (72)</label>
                      <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="thumbnail catbannerpic-1">
                      <form class="catbannerupload" id="catbannerupload-1" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="catbuploadedpicture-1" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="catbuploadedpicture-1" class="catbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="catbuploadsave-1" class="catbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="catbuploadcancel-1" class="catbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>

                      <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="thumbnail catbannerpic-2">
                      <form class="catbannerupload" id="catbannerupload-2" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="catbuploadedpicture-2" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="catbuploadedpicture-2" class="catbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="catbuploadsave-2" class="catbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="catbuploadcancel-2" class="catbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>

                      <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="thumbnail catbannerpic-3">
                      <form class="catbannerupload" id="catbannerupload-3" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="catbuploadedpicture-3" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="catbuploadedpicture-3" class="catbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="catbuploadsave-3" class="catbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="catbuploadcancel-3" class="catbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>

                      <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="thumbnail catbannerpic-4">
                      <form class="catbannerupload" id="catbannerupload-4" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="catbuploadedpicture-4" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="catbuploadedpicture-4" class="catbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="catbuploadsave-4" class="catbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="catbuploadcancel-4" class="catbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>

                      <h6 class="aimslabel picbox">
                      <img src ="" width="100%" height ="250px" class="thumbnail catbannerpic-5">
                      <form class="catbannerupload" id="catbannerupload-5" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="catbuploadedpicture-5" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="catbuploadedpicture-5" class="catbuploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="catbuploadsave-5" class="catbuploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="catbuploadcancel-5" class="catbuploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>
                  </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btnmanagelanesave btn btn-flat btn-success" data-dismiss="modal">Save</button>
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</div>