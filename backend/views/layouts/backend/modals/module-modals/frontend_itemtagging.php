<!-- MODAL FOR CUSTOMER LOOK UP -->
<div class="modal fade" id="modal-frontenditemtagging" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncanceladminpass" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Tag Item to Category</h4>
      </div>

      <div class="modal-body">
          <div class="row">
                <div class="col-md-4">
                    <div class="box box-solid box-success">
                          <div class="modulehead box-header with-border">
                            <h6 class="aimslabel box-title">Available Lanes</h6>
                           </div><!-- /.box-header -->
                          
                        <div class="box-body scroll-lanes lanelist" id="lanelisting" style="overflow-y: scroll;height: 450px;">
                            <?php
                            /*foreach ($usersdata as $data => $dat) {
                              echo '<button id = "acclevels-'.$dat['idno'].'" class="settings-btn acclevels btn btn-info btn-flat">
                              '.$dat['username'].'</button>';
                            }//END FOR EACH*/
                            ?>
                        </div><!-- /.box-body -->
                        <div class="box-body newlaneform" style="height:100%;width:100%;display: none;">
                          <input type="text" class="form-control txtnewlane"/>    
                          <br>
                          <input style="margin-left:7px;margin-top:6px;" class ="lane_enabled" type="checkbox">
                          <label><small>Enabled</small></label>
                        </div>
                    </div> <!-- /class="box box-solid box-success" -->

                   
                    
                </div> <!-- END COL MD 4 -->

                  <div class="col-md-8" style="height:100%;">
                        <div class="box box-solid box-success">
                              <div class="modulehead box-header with-border">
                               <b><h6 id="lanetitle" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;"></h6></b>
                              
                              <div class="pull-right" style="margin-top: 5px;">
                              <div class="btn-group">
                               <!--  <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btneditaccess"><b><i class="fa fa-pencil"></i> Edit Access</b></button>
                                <button style="display:none;" type="button" data-toggle="tooltip" title="Edit Access" class="btn btn-default btn-success headbtn btnactive module-btnfinishaccess"><b><i class="fa fa-check"></i> Finish Editing</b></button> -->
                              </div>
                              </div><!-- /.box-tools -->
                              </div>

                              
                              <div class="box-body row-horizon" id="lanechildlisting" style="overflow-y: scroll;height: 450px;">
                                
                              </div>
                          
                              
                              
                          </div><!-- /.box -->
                  </div> <!-- END COL MD 9 -->
          </div>

      <div class="modal-footer">
        <button type="button" class=" btn btn-flat btn-danger" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
</div>