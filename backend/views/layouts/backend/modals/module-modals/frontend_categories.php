<!-- MODAL FOR ITEM LOOK UP -->
<div class="modal fade" id="modal-frontendcategories" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closepickpo" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Navigation Category</h4>
      </div>

      <div class="modal-body f-addnav-form">
        <input id="fcattype" type="hidden" class="input-sm form-control" placeholder="Category Description">
        <input id="fparent" type="hidden" class="input-sm form-control" placeholder="Category Description">
        <label style="margin-top:3px;">Enter Navigation Desc: </label>
        <input id="fdescription" type="text" class="input-sm form-control" placeholder="Category Description">
        </br>

        <div class="cattxt" style="display:none;">
        <label style="margin-top:3px;">Set this Category under:</label>
        <div class="input-group">
            <input readonly="true" value ="" type="text" class="txtfparent-cat input-sm form-control">
            <div class=" input-group-addon">
            <a class ="fcatparentlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a>
            </div>
        </div>
        </br>
        </div>

        <div class="subcattxt" style="display:none;">
        <label style="margin-top:3px;">Set this Sub-Category under:</label>
        <div class="input-group">
            <input readonly="true" value ="" type="text" class="txtfparent-sub input-sm form-control">
            <div class=" input-group-addon">
            <a class ="fsubcatparentlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a>
            </div>
        </div>
        </br>
        </div>

        <label style="margin-top:3px;">Set this nav as Parent?: &nbsp</label>
        <input id="isparent" type="checkbox">
        </br>
        <label style="margin-top:3px;">Set this nav as Enabled?: &nbsp</label>
        <input id="isenabled" type="checkbox">
      </div>

      <div class="modal-footer">
        <button type="button" class="btnfsavecategory btn btn-flat btn-success">Save Category</button>
        <button type="button" class="btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>