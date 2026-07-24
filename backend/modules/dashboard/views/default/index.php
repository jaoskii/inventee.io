<?php

$this->title = 'Frontend Settings';

?>

<div class="row">
<div class="col-md-12">
    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bars"></i> &nbspItem Settings</h3>
                <div class="pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">          

                <label>Show Item Amount: </label><input style="margin-left:7px;" type="checkbox"></br>
                <label>Set Available Categories: </label></br>
                  <div class="form-group">
                    <select class="form-control itemcategories" multiple="multiple" data-placeholder="Select Available Categories" style="width: 100%;">
                      <?php
                      foreach ($categories as $categ) {
                        echo '<option>'.$categ['category'].'</option>';
                      }
                      ?>
                    </select>
                  </div><!-- /.form-group -->
                <label>Set Top Items: </label></br>
                <div class="form-group">
                    <select class="form-control topitems" multiple="multiple" data-placeholder="Select Top Items" style="width: 100%;">
                      <?php
                      foreach ($items as $iteminfo) {
                        echo '<option>'.$iteminfo['itemname'].' - '.$iteminfo['barcode'].'</option>';
                      }
                      ?>
                    </select>
                  </div><!-- /.form-group -->
                <label>Set Featured Items: </label>
                  <div class="form-group">
                    <select class="form-control featureditems" multiple="multiple" data-placeholder="Select Available Featured Items" style="width: 100%;">
                      <?php
                      foreach ($items as $iteminfo) {
                        echo '<option>'.$iteminfo['itemname'].' - '.$iteminfo['barcode'].'</option>';
                      }
                      ?>
                    </select>
                  </div><!-- /.form-group -->

                </br>
                <div class="form-group pull-right"> <button class="btn btn-success btn-flat"><i class="fa fa-cogs"></i> &nbsp Save Settings</button></div>
                </div><!-- /.box-body -->
    </div><!-- /.box -->
    <div class="box box-success box-solid collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-gear"></i> Category Settings</h3>
                <div class="pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                <div class="form-group pull-right"> <button class="btn btn-success btn-flat"><i class="fa fa-cogs"></i> &nbsp Save Settings</button></div>
                </div><!-- /.box-body -->
    </div><!-- /.box -->
    <div class="box box-success box-solid collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-gear"></i> Banner Settings</h3>
                <div class="pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  The body of the box
                </div><!-- /.box-body -->
    </div><!-- /.box -->
    <div class="box box-success box-solid collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-gear"></i> Email Alert Settings</h3>
                <div class="pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  The body of the box
                </div><!-- /.box-body -->
    </div><!-- /.box -->
        <div class="box box-success box-solid collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-gear"></i> Contact Settings</h3>
                <div class="pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <label>Set Contact #: </label>
                  <input type="text" class="form-control" placeholder = "Set Contact # for Contact us"/>
                  <label>Set Tel #: </label>
                  <input type="text" class="form-control" placeholder = "Set Tel # for Contact us"/>
                  <label>Set Fax #: </label>
                  <input type="text" class="form-control" placeholder = "SSet Fax # for Contact us"/>
                  <label>Set Email #: </label>
                  <input type="text" class="form-control" placeholder = "Set Email for Contact us"/>
                  <label>Set Address: </label>
                  <textarea class="form-control" placeholder="Set Address for Contact us" rows="5" style="resize:none;"></textarea>
                  </br>
                  <div class="form-group pull-right"> <button class="btn btn-success btn-flat"><i class="fa fa-cogs"></i> &nbsp Save Settings</button></div>
                </div><!-- /.box-body -->
    </div><!-- /.box -->
        <div class="box box-success box-solid collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-gear"></i> About Us Settings</h3>
                <div class="pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                 <div class="box-body">
                  <label>Set Contact #: </label>
                  <input type="text" class="form-control" placeholder = "Set Contact # for Contact us"/>
                  <label>Set Tel #: </label>
                  <input type="text" class="form-control" placeholder = "Set Contact # for Contact us"/>
                  <label>Set Fax #: </label>
                  <input type="text" class="form-control" placeholder = "Set Contact # for Contact us"/>
                  <label>Set Email #: </label>
                  <input type="text" class="form-control" placeholder = "Set Contact # for Contact us"/>
                  <label>Set Address: </label>
                  <input type="text" class="form-control" placeholder = "Set Contact # for Contact us"/>
                  </br>
                  <div class="form-group pull-right"> <button class="btn btn-success btn-flat"><i class="fa fa-cogs"></i> &nbsp Save Settings</button></div>
                </div><!-- /.box-body -->
    </div><!-- /.box -->

</div>
</div>


           

