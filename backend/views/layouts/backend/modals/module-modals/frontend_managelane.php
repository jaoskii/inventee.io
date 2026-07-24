<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-frontendmanagelane" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceladminpass" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Manage Lane</h4>
      </div>

      <div class="modal-body">
          <div class="row">
              <div class = "col-md-6">
                  <input name="managelaneid" value ="" type="hidden" id="managelaneid" class="managelaneform form-control input-sm">
                  <h6 class="aimslabel" style="display:block;">
                      <b>Lane Title: <input name="lanetitle" value ="" id = "txtupdatelane" type="text" class="managelaneform form-control input-sm"></b>
                  </h6>
                  <input style="margin-left:7px;margin-top:6px;" class ="lane_enabled2" type="checkbox">
                  <label class="aimslabel">Enabled</label>
              </div>

                <!-- <div class="col-md-6">
                <label class="aimslabel">Set Header</label>
                  <label class="aimslabel">REQUIRED: Dimension of (1140 x 132) and resolution (76)</label>
                  <h6 class="aimslabel picbox">
                  <img src ="" width="405px" height ="100px" class="thumbnail headerpic">
                  <form class="headerupload" id="headerupload" method="POST" enctype="multipart/form-data">
                  <span id="fileselector">
                      <label class="btn btn-default" for="huploadedpicture" style="margin-top:-15px;width:100%;margin-left:-10px;">
                          <input type="file" name="image" id="huploadedpicture" class="huploadedpicture">
                          <i class="fa fa-upload margin-correction"></i>Browse Pic
                      </label>
                  </span>

                  <button type = "submit" id="huploadsave" class="huploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                  <button type = "button" id="huploadcancel" class="huploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                  </form>
                  </h6>
                </div> -->
          </div>
          <br>
          <div class="row">
                  

                  <div class = "col-md-6" style="overflow-y: scroll;height: 400px;">

                  <label class="aimslabel">Set Featured Categories</label>
                  <h6 class="aimslabel"><b>Featured Item 1:  </b>
                      <img id="fitempic-1" style="margin-top:5px;" src ="" width="160px" height ="150px" class="thumbnail">
                      <div class="input-group">
                          <input name="featured1" value ="" id="fitembarcode-1" readonly="" type="text" class="managelaneform input-sm form-control"><div class="frmdocumentno input-group-addon"><a id="fitemlookup-1" class ="clickable managelaneform fitemlookup"><i class="fa fa-chevron-circle-down" ></i></a></div>
                      </div>
                  </h6>

                   <h6 class="aimslabel"><b>Featured Item 2:  </b>
                      <img style="margin-top:5px;" src ="" width="160px" height ="150px" class="thumbnail">
                      <div class="input-group">
                          <input name="featured2" value ="" id="fitembarcode-2" readonly="" type="text" class="managelaneform input-sm form-control"><div class="frmdocumentno input-group-addon"><a id="fitemlookup-2" class ="clickable fitemlookup" href="#"><i class="fa fa-chevron-circle-down" ></i></a></div>
                      </div>
                  </h6>

                  <h6 class="aimslabel"><b>Featured Item 3:  </b>
                      <img d="fitempic-2" style="margin-top:5px;" src ="" width="160px" height ="150px" class="thumbnail">
                      <div class="input-group">
                          <input name="featured3" value ="" id="fitembarcode-3" readonly="" type="text" class="managelaneform input-sm form-control"><div class="frmdocumentno input-group-addon"><a id="fitemlookup-3" class ="clickable fitemlookup"><i class="fa fa-chevron-circle-down" ></i></a></div>
                      </div>
                  </h6>

                  <h6 class="aimslabel"><b>Featured Item 4:  </b>
                      <img d="fitempic-3" style="margin-top:5px;" src ="" width="160px" height ="150px" class="thumbnail">
                      <div class="input-group">
                          <input name="featured4" value ="" id="fitembarcode-4" readonly="" type="text" class="managelaneform input-sm form-control"><div class="frmdocumentno input-group-addon"><a id="fitemlookup-4" class ="clickable fitemlookup"><i class="fa fa-chevron-circle-down" ></i></a></div>
                      </div>
                  </h6>

                  <h6 class="aimslabel"><b>Featured Item 5:  </b>
                      <img d="fitempic-4" style="margin-top:5px;" src ="" width="160px" height ="150px" class="thumbnail">
                      <div class="input-group">
                          <input name="featured5" value ="" id="fitembarcode-5" readonly="" type="text" class="managelaneform input-sm form-control"><div class="frmdocumentno input-group-addon"><a id="fitemlookup-5" class ="clickable fitemlookup"><i class="fa fa-chevron-circle-down" ></i></a></div>
                      </div>
                  </h6>

                  <h6 class="aimslabel"><b>Featured Item 6:  </b>
                      <img d="fitempic-5" style="margin-top:5px;" src ="" width="160px" height ="150px" class="thumbnail">
                      <div class="input-group">
                          <input name="featured6" value ="" id="fitembarcode-6" readonly="" type="text" class="managelaneform input-sm form-control"><div class="frmdocumentno input-group-addon"><a id="fitemlookup-6" class ="clickable fitemlookup"><i class="fa fa-chevron-circle-down" ></i></a></div>
                      </div>
                  </h6>
                  <!-- <label class="aimslabel">Set Featured Subcategories</label>
                  <button class="fcategory btn btn-flat btn-success settings-btn" style="width:100%;margin-top:3px;"><b><i class="fa fa-plus"></i>Add Featured Item</b></button>
                  <br>
                  <button class="fcategory btn btn-flat btn-github settings-btn" style="width:100%;margin-top:3px;"><b>AAA</b></button>
                  <button class="fcategory btn btn-flat btn-github settings-btn" style="width:100%;margin-top:3px;"><b>AAA</b></button>
                  <button class="fcategory btn btn-flat btn-github settings-btn" style="width:100%;margin-top:3px;"><b>AAA</b></button>
                  <button class="fcategory btn btn-flat btn-github settings-btn" style="width:100%;margin-top:3px;"><b>AAA</b></button>
                  <button class="fcategory btn btn-flat btn-github settings-btn" style="width:100%;margin-top:3px;"><b>AAA</b></button>
                  <button class="fcategory btn btn-flat btn-github settings-btn" style="width:100%;margin-top:3px;"><b>AAA</b></button> -->
                  
                  </div>

                  <div class = "col-md-6" style="overflow-y: scroll;height: 400px;">
                  <label class="aimslabel">Set Slider Images</label>
                  <label class="aimslabel">REQUIRED: Dimension of (858 x 460) and resolution (96)</label>
                      <h6 class="aimslabel picbox">
                      <img src ="" width="405px" height ="200px" class="thumbnail bannerpic-1">
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

                      <h6 class="aimslabel picbox">
                      <img src ="" width="405px" height ="200px" class="thumbnail bannerpic-2">
                      <form class="bannerupload" id="bannerupload-2" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="buploadedpicture-2" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="buploadedpicture-2" class="buploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="buploadsave-2" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="buploadcancel-2" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>

                      <h6 class="aimslabel picbox">
                      <img src ="" width="405px" height ="200px" class="thumbnail bannerpic-3">
                      <form class="bannerupload" id="bannerupload-3" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="buploadedpicture-3" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="buploadedpicture-3" class="buploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="buploadsave-3" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="buploadcancel-3" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>

                      <h6 class="aimslabel picbox">
                      <img src ="" width="405px" height ="200px" class="thumbnail bannerpic-4">
                      <form class="bannerupload" id="bannerupload-4" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="buploadedpicture-4" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="buploadedpicture-4" class="buploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="buploadsave-4" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="buploadcancel-4" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>

                      <h6 class="aimslabel picbox">
                      <img src ="" width="405px" height ="200px" class="thumbnail bannerpic-5">
                      <form class="bannerupload" id="bannerupload-5" method="POST" enctype="multipart/form-data">
                      <span id="fileselector">
                          <label class="btn btn-default" for="buploadedpicture-5" style="margin-top:-15px;width:100%;margin-left:-10px;">
                              <input type="file" name="image" id="buploadedpicture-5" class="buploadedpicture">
                              <i class="fa fa-upload margin-correction"></i>Browse Pic
                          </label>
                      </span>

                      <button type = "submit" id="buploadsave-5" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                      <button type = "button" id="buploadcancel-5" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                      </form>
                      </h6>
                  </div>


                  

<!-- 
                  <div class = "col-md-3">
                  
                  </div>
 -->
                
                  
      </div>

      <div class="modal-footer">
        <button type="button" class="btnmanagelanesave btn btn-flat btn-success" data-dismiss="modal">Save</button>
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
</div>