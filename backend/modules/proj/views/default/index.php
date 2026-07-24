<?php
$this->title = 'Cost Center Setup';
?>
<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-success headbtn btnactive module-btnnewproj">
          <b><i class="new_btn fa fa-file"></i> New</b></button>
        </div>
      </div>
      <div class="box-body scroll-divs">
        <div class="costcenterdiv"></div>
        <!-- <table class="table tbl-fix bodytable">
          <thead>
            <tr>
              <th class="col-min aimslabel"><span class="text">Options</span></th>
              <th class="col-codes aimslabel"><span class="text">Code</span></th>
              <th class="col-description aimslabel"><span class="text">Name</span></th>
            </tr>
          </thead>
          <tbody class="modulebody costcentertbl">
          </tbody>
        </table> -->
      </div>
    </div>
  </div>
</div>