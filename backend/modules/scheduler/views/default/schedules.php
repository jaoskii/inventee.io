<?php
use yii\helpers\Url;
$this->title = 'View Schedules';
?>
 <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
            <input type="hidden" id="moduleid" value = "<?php echo $moduleid; ?>">
            <input type="hidden" id="userid" value = "<?php echo Yii::$app->session['loggeduser']['userid']; ?>">
              <div class="box box-solid box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Calendar</h3>
                </div>
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->

            
          </div><!-- /.row -->
        </section><!-- /.content -->