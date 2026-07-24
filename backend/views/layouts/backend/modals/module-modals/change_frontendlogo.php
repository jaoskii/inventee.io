<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-changefrontendlogo" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closecustomerlookup" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Change Frontend Logo</h4>
      </div>
      <div class="modal-body">
        
          <label class="aimslabel">REQUIRED: Dimension of (92 x 26) and resolution (72)</label>
          <h6 style="margin-left:29%;" class="aimslabel picbox">
          <img src ="" width="60%" height ="90px" class="thumbnail recordpicture">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">OK</button>
      </div>

    </div>
  </div>
</div>