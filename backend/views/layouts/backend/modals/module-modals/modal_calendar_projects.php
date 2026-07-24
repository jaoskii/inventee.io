<!-- MODAL FOR MODULE LOGS -->
<div class="modal fade" id="modal-schedprojects" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closemodulelogs" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Projects</h4>
      </div>

      <div class="modal-body">
      <input type="hidden" id = "projectid" value="">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4">
                <button style="margin-bottom: 3px;" class="sched-addprojectbtn col-md-12 btn btn-flat btn-success"><i class="fa fa-plus"></i> Add Project</button>
                <button style="display:none;" class="sched-editprojectbtn col-md-12 btn btn-flat btn-warning"><i class="fa fa-pencil"></i> Edit Project</button>
                <button style="display:none;" class="sched-saveprojectbtn col-md-6 btn btn-flat btn-success"><i class="fa fa-save"></i> Save</button>
                <button style="display:none;" class="sched-cancelprojectbtn col-md-push-1 col-md-5 btn btn-flat btn-warning"><i class="fa fa-times"></i> Cancel</button>

                <div style="display: block;margin-top: 25px;" class="projectlist box-footer no-padding scroll-projects col-md-12">
                </div><!-- /.footer -->
            </div>

            <!-- SCHEDULE LISTING -->
            <div class="col-md-8 schedprojlist">
            <label style="margin-bottom: 10px;">List of Tagged Schedules</label>
            <div class="mod-tble" style="height: 430px;">
             <table class="table-modulelog table table-fixed">                             
              <thead>
                <tr>
                  <th class="col-min aimslabel">View</th>
                  <th class="col-codes aimslabel">User</th>
                  <th class="col-description aimslabel">Description</th>
                  <th class="col-min aimslabel">Status</th>
                </tr>
              </thead>   

              <tbody class="tbl-taggedscheds">
             
              </tbody>
              
              </table>  
              </div>
            </div> <!-- END COL MD 9 -->

            <!-- ADDING PROJECT FORM -->
            <div style="display:none;" class="col-md-8 schedaddproj">
              <label style="margin-bottom: 10px;">Project Details</label>

              <h6 class="aimslabel3"><b>Project Title: <input name="projectname" value ="" type="text" class="projtxt txtprojectname form-control input-sm" ></b></h6>

              <h6 class="aimslabel3"><b>Project Description: 
              <textarea rows="3" cols="50" class="projtxt form-control txtprojectdesc" style="font-size:13px;resize:none;"></textarea>
              </b></h6>

              <h6 style="display:none;" class="projectstatus aimslabel"><b>Project Status:
                    <select id="projectstatus" class="projectstatus input-sm form-control">
                    </select>
              </h6>
            </div> <!-- END COL MD 9 -->
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="closeitemlookup btn btn-flat btn-success" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>