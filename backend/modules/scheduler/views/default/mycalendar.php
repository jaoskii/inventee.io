<?php
use yii\helpers\Url;
$this->title = 'Scheduler';
?>
<input type="hidden" id="moduleid" value = "<?php echo $moduleid; ?>">
<input type="hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type="hidden" id="viewmode" value = "EDIT">
<input type="hidden" id="moduleview" value = "OWN">
<input type="hidden" id="userid" value = "<?php echo Yii::$app->session['loggeduser']['userid']; ?>">
        <!-- Main content -->
<!-- <div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-ban"></i> Alert!</h4>
  Please put notes on your schedules , just for references. For bug patchings.
</div> -->
        <section class="content" id="content_mysched">
          <div class="row">
            <div class="col-md-9">            
              <div class="box box-solid box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Calendar</h3>
                    <div class="pull-right">
                    <div class="btn-group">
                    <button type="button" data-toggle="tooltip" title="Logs" class="btn btn-default btn-success btnactive btnschedulerprojects"><b><i class="fa fa-cubes"></i> Projects</b></button>
                    <button type="button" data-toggle="tooltip" title="Logs" class="btn btn-default btn-success btnactive btnmanageanon"><b><i class="fa fa-list"></i> Announcements</b></button>
                    <button type="button" data-toggle="tooltip" title="Logs" class="btn btn-default btn-success btnactive btnschedulerlogs"><b><i class="fa fa-list"></i> Logs</b></button>
                    <button type="button" data-toggle="tooltip" title="Time In List" class="btn btn-default btn-success btnactive btntimeinlist"><b><i class="fa fa-list-alt"></i> Time IN List</b></button>
                    <?php 
                    if($hastimedin){
                     echo '<button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success btnactive schedulertimein"><b><i class="fa fa-clock-o"></i> Time IN</b></button>';
                    }//end if hastimed in
                    ?>
                    </div>
                    </div>
                </div>
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->

            <div class="col-md-3">
            <div class="box box-solid box-success">
            <button class="viewscheds btn btn-primary" style="width:100%;"><i class="fa fa-eye"></i> View Other Schedules</button>
            </div>
            <div class="box box-solid box-success" style="margin-top:-15px;">
            <button class="createnewevent btn btn-github" style="width:100%;"><i class="fa fa-plus"></i> Add Event</button>
            </div>
            <div class="box box-solid box-success" style="margin-top:-15px;">
            <button class="schedreminders btn btn-github" style="width:100%;"><i class="fa fa-sticky-note"></i> Reminders</button>
            </div>
            <div class="box box-solid box-success" style="margin-top:-15px;">
              <button class="ongoingevent btn btn-github" style="width:100%;"><i class="fa fa-calendar-check-o"></i> Ongoing Schedules</button>
            </div>
            <div class="box box-solid box-success" style="margin-top:-15px;">
              <button class="viewappreimb btn btn-github" style="width:100%;"><i class="fa fa-eye"></i> View Approved Reimbursements</button>
            </div>

              <div class="box box-solid box-success">
                <div class="box-header with-border">
                  <h4 class="box-title">Unplotted Schedules</h4>
                </div>
                <div class="box-body scroll-pendingevents">
                  <!-- the events -->
                  <div id="external-events">
                  <?php
                  $color = "";
                  foreach ($unplotted as $key => $unplot) {
                    switch ($unplotted[$key]['sched_type']) {
                      default:
                        $color = "color: #ffffff;background-color: #444444;border-color: rgba(0, 0, 0, 0.2);";
                        break;
                    }
                    echo '<div id = "'.$unplotted[$key]['sched_seq'].'" style="'.$color.'" class="pendingevent external-event fc-event">'.$unplotted[$key]['sched_desc'].'</div>';
                  }//end for each
                  ?>                  
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->

              <div class="box box-solid box-success">
                <div class="box-header with-border">
                  <h4 class="box-title">Notifications</h4>
                </div>
                <div class="box-body scroll-notifications notifyme">
                </div><!-- /.box-body -->
              </div><!-- /. box -->


            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->



        <!-- Main content -->
        <section class="content" id="content_viewsched" style="display: none;">
          <div class="row">
            <div class="col-md-9">
              <div class="box box-solid box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Calendar</h3>
                      <div class="pull-right">
                      <div class="btn-group">
                      <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success btnactive btnschedlookup"><b><i class="fa fa-search"></i> Filtered Search</b></button>
                      <button type="button" data-toggle="tooltip" title="New" class="btn btn-default btn-success btnactive btntimeinlist"><b><i class="fa fa-list-alt"></i> Time IN List</b></button>
                      </div>
                      </div>
                </div>
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendarothers"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->

            <div class="col-md-3">
            <div class="box box-solid box-success">
            <button style="display: none;width:100%;" class="personalscheds btn btn-primary"><i class="fa fa-eye"></i> Return to My Calendar</button>
            </div>


            <div class="box box-solid box-success">
                <div class="box-header with-border">
                  <h4 class="box-title">Select Member to view:</h4>
                </div>
                <div class="box-body">
                  <div class="input-group">
                  <input readonly="true" name="user" value ="" type="text" class="scheduleruser form-control input-sm">
                  <div class="input-group-addon"><a class ="scheduleuserlookup" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>
                  </div>
                </div><!-- /.box-body -->
            </div><!-- /. box -->

             <div class="box box-solid box-success">
                <div class="box-header with-border">
                  <h4 class="box-title">Notifications</h4>
                </div>
                <div style="height:480px;" class="box-body notifyme">
                </div><!-- /.box-body -->
              </div><!-- /. box -->


            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
