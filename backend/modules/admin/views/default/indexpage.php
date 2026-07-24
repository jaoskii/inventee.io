<?php
$this->title = 'AIMS - Dashboard';
use yii\helpers\Url;
use yii\base\ErrorException;
use app\models\Pohead;
use app\models\Postock;
use app\models\Common;
use app\models\Webproc;
use app\models\Cntnum;

switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF

?>
<!-- purchases,sales count-v
SJ,RR
lahead
glhead
outstanding ar,ap count -v
bal
arledger
apledger


pass values from index default
try if can use webprocess index -->


<div class="pull-right hid">
  <div id="clock" class="clock">loading Digital Clock..</div>
</div>
<input type = "hidden" id ="viewmoduleid" value="indexpage">
<!-- <input type = "hidden" id ="viewmoduleid" value="indexpage"> -->
<!-- <div class="quickaccess" style="margin-top:8%;"> -->
<?php
Yii::$app->systemsettings->systemMenuSetup();
?>
<div class="quickaccess">
  <div class="row">
    <div class="col-md-10">
    </div>

    <div class="col-md-2">
      <?php
        if(Yii::$app->session['loggeduser']['access'][3243] == 1){
          echo '<button type="button" class="btn btn-block btn-github btn-sm load-dashboarddata"><i class="fa fa-refresh"></i> Load Dashboard Data</button>';
        }//end if
      ?>
    </div>
  </div>


  <div class="row">
    <!-- Main content -->
    <section class="content">

      <?php 
      //FIRST ROW OF DASHBOARD //FIRST ROW OF DASHBOARD //FIRST ROW OF DASHBOARD //FIRST ROW OF DASHBOARD //FIRST ROW OF DASHBOARD
      $row2 = 0;
      
      if(Yii::$app->session['loggeduser']['access'][3229] == 1){
        $row2 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3230] == 1){
        $row2 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3231] == 1){
        $row2 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3232] == 1){
        $row2 += 1;
      }//end if

      if($row2 != 0){
        $colint2 = 12 / $row2;
      }//end if 

      if($row2 !=0){
        echo '<div class="row">';
        
        if(Yii::$app->session['loggeduser']['access'][3229] == 1){
        echo '<div class="col-md-'.$colint2.' col-sm-'.$colint2.' col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"># of SJ Transactions</span>
                <span class="frontindex-txttotalsales info-box-number"></span>
              </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>';
        }//end if # SJ TRANS

        
        if(Yii::$app->session['loggeduser']['access'][3230] == 1){ 
        echo '<div class="col-md-'.$colint2.' col-sm-'.$colint2.' col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-upload"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"># of RR Transactions</span>
                <span class="frontindex-txttotalpurchases info-box-number"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>';
        }//end if # RR TRANS

        if ($row2 > 2){
            echo '<div class="clearfix visible-sm-block"></div>';
        }//end if

        if(Yii::$app->session['loggeduser']['access'][3231] == 1){ 
        echo '<div class="col-md-'.$colint2.' col-sm-'.$colint2.' col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Outstanding AR</span>
              <span class="frontindex-txttotalar info-box-number"></span>
            </div>
          <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>';
        }//end if OUTSTANDING AR

        if(Yii::$app->session['loggeduser']['access'][3232] == 1){ 
        echo '<div class="col-md-'.$colint2.' col-sm-'.$colint2.' col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-institution"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Outstanding AP</span>
              <span class="frontindex-txttotalap info-box-number"></span>
            </div>
          <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>';
        }//end if OUTSTANDING AP
        echo '</div>';
      }//end if
      ?>


      <?php 
      //SECOND ROW OF DASHBOARD //SECOND ROW OF DASHBOARD //SECOND ROW OF DASHBOARD //SECOND ROW OF DASHBOARD //SECOND ROW OF DASHBOARDO
      if(Yii::$app->session['loggeduser']['access'][3233] == 1){ 
        echo '<div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                          <div class="col-md-12">
                          <p class="text-center">
                          <strong>Comparative Sales Report (<span style="color:#76797e;">2 Year Ago Sales</span> vs <span style="color:#ffe500;">Previous</span> vs <span style="color:#09b500;">Current</span>) Year</strong>
                          </p>

                            <div class="chart">
                            <!-- Sales Chart Canvas -->
                              <canvas id="salesChart" style="height: 430px;"></canvas>';
                              if(Yii::$app->systemsettings->companyConfig() == 'SBC'){
                                echo '<span class="displayofsales"><b>(Note: All Percentages are based on Quota)</b> </span>';
                              }//end if
                            echo '</div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>';
      }//end if
      ?>



      <?php
      //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD 
      $row3_1 = 0;
      $row3_2 = 0;
      $row3 = 0;

      if(Yii::$app->session['loggeduser']['access'][3240] == 1){
        $row3_1 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3241] == 1){
        $row3_1 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3242] == 1){
        $row3_2 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3243] == 1){
        $row3_2 += 1;
      }//end if

      $row3 = floatval($row3_1) + floatval($row3_2);
      
      if($row3_1 == 0 || $row3_2 == 0){
        $col_w = 12;
      }else{
        $col_w = 6;
      }//end if

      if($row3_1 < 2){
        $styler_rectang1 = 'style = "height:200px;"';
        $styler_redbox1 = 'style = "height:200px;width:200px;"';
        $styler_icon1 = 'style="margin-top:25%;font-size:2em;"';
        $styler_boxcon1 = 'style="margin-left:35%;"';
      }else{
        $styler_rectang1 = "";
        $styler_redbox1 = "";
        $styler_icon1 = "";
        $styler_boxcon1 = "";
      }//end if

      if($row3_2 < 2){
        $styler_rectang2 = 'style = "height:200px;"';
        $styler_redbox2 = 'style = "height:200px;width:200px;"';
        $styler_icon2 = 'style="margin-top:25%;font-size:2em;"';
        $styler_boxcon2 = 'style="margin-left:35%;"';
      }else{
        $styler_rectang2 = "";
        $styler_redbox2 = "";
        $styler_icon2 = "";
        $styler_boxcon2 = "";
      }//end if

      if($row3 != 0){
        echo '<div class="row">';
        if($row3_1 != 0){
          echo '<div class="col-md-'.$col_w.' col-sm-'.$col_w.' col-xs-12">';
            if(Yii::$app->session['loggeduser']['access'][3240] == 1){
              echo '<a class="alinexpns clickable" style="color:black;">
              <div class="info-box" '.$styler_rectang1.'>
                  <span class="info-box-icon bg-red" '.$styler_redbox1.'>
                  <i class="fa fa-tag" '.$styler_icon1.'></i>
                  </span>
                  <div class="info-box-content" '.$styler_boxcon1.'>
                    <span class="info-box-text">Expenses <br>(Click to Show Chart)</span>
                    <span class="frontindex-txtexpenses info-box-number"></span>
                  </div>
              <!-- /.info-box-content -->
              </div>
              </a>';
            }//end if

            if(Yii::$app->session['loggeduser']['access'][3241] == 1){
              echo '<a class="alinesls clickable"  style="color:black;">
                <div class="info-box" '.$styler_rectang1.'>
                  <span class="info-box-icon bg-green" '.$styler_redbox1.'>
                  <i class="fa fa-upload" '.$styler_icon1.'></i>
                  </span>
                  <div class="info-box-content" '.$styler_boxcon1.'>
                    <span class="info-box-text">Collections <br>(Click to Show Chart)</span>
                    <span class="frontindex-txtsalespercent info-box-number"></span>
                  </div>
                <!-- /.info-box-content -->
              </div>
              </a>';
            }//end if
          echo '</div>';
        }//end if

        if($row3_2 != 0){
          echo '<div class="col-md-'.$col_w.' col-sm-'.$col_w.' col-xs-12">';

              if(Yii::$app->session['loggeduser']['access'][3242] == 1){
                echo '<a class="trmonth clickable"  style="color:black;">
                <div class="info-box" '.$styler_rectang2.'>
                    <span class="info-box-icon bg-aqua" '.$styler_redbox2.'>
                    <i class="fa fa-money" '.$styler_icon2.'></i>
                    </span>
                    <div class="info-box-content" '.$styler_boxcon2.'>
                      <span class="pull-left" style="font-weight: bold;">CLICK HERE TO SHOW TRANSACTIONS FOR THE MONTH OF '.strtoupper(date('F')).'</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
                </a>';
              }//end if

              if(Yii::$app->session['loggeduser']['access'][3243] == 1){
                echo '<a class="untrans clickable"  style="color:black;">
                <div class="info-box" '.$styler_rectang2.'>
                    <span class="info-box-icon bg-green" '.$styler_redbox2.'>
                    <i class="fa fa-upload" '.$styler_icon2.'></i>
                    </span>
                    <div class="info-box-content" '.$styler_boxcon2.'>
                      <span class="info-box-text">UNPOSTED <br>TRANSATIONS</span> 
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
                </a>';
              }//end if
          echo '</div> <!-- /.col -->';
        }//end if

      echo '</div><!-- /.row -->';
      }//end if
      ?>



      <?php
      //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD //THIRD ROW OF DASHBOARD 
      $row4_1 = 0; //COUNTS ALL ROW 4 1ST COLUMN      
      $row4_2 = 0; //COUNTS ALL ROW 4 2ND COLUMN
      $row4_2_1 = 0; //COUNTS 2ND COLUMN TRANSACTION STATUS (4 ACCESS AVAILABLE INSIDE) AND ITS 4 ROWS
      $row4_2_2 = 0; //COUNTS 2ND COLUMN CLICKABLE MENU
      $row4 = 0; //COUNTS OVERALL ACCESS FOR ROW 4

      if(Yii::$app->session['loggeduser']['access'][3238] == 1){
        $row4_1 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3234] == 1){
        $row4_2 += 1;
        $row4_2_1 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3235] == 1){
        $row4_2 += 1;
        $row4_2_1 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3236] == 1){
        $row4_2 += 1;
        $row4_2_1 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3237] == 1){
        $row4_2 += 1;
        $row4_2_1 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3239] == 1){
        $row4_2 += 1;
        $row4_2_2 += 1;
      }//end if

      if(Yii::$app->session['loggeduser']['access'][3244] == 1){
        $row4_2 += 1;
        $row4_2_2 += 1;
      }//end if

      $row4 = floatval($row4_1) + floatval($row4_2);

      if($row4_1 == 0 || $row4_2 == 0){
        $row4_colw = 12;
      }else{
        $row4_colw = 6;
      }//end if


      if($row4_2_2 == 0 && $row4_2_1 == 0){
        $styler_tbl4 = 'style="height:415px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 2 && $row4_2_1 == 0){
        $styler_tbl4 = 'style="height:415px;overflow-y: scroll;"';
      }//end if


      if($row4_2_2 == 1 && $row4_2_1 == 1){
        $styler_tbl4 = 'style="height:165px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 2 && $row4_2_1 == 1){
        $styler_tbl4 = 'style="height:265px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 1 && $row4_2_1 == 2){
        $styler_tbl4 = 'style="height:210px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 2 && $row4_2_1 == 2){
        $styler_tbl4 = 'style="height:315px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 1 && $row4_2_1 == 3){
        $styler_tbl4 = 'style="height:260px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 2 && $row4_2_1 == 3){
        $styler_tbl4 = 'style="height:365px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 1 && $row4_2_1 == 4){
        $styler_tbl4 = 'style="height:310px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 2 && $row4_2_1 == 4){
        $styler_tbl4 = 'style="height:415px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 0 && $row4_2_1 == 1){
        $styler_tbl4 = 'style="height:200px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 0 && $row4_2_1 == 2){
        $styler_tbl4 = 'style="height:200px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 0 && $row4_2_1 == 3){
        $styler_tbl4 = 'style="height:200px;overflow-y: scroll;"';
      }//end if

      if($row4_2_2 == 0 && $row4_2_1 == 4){
        $styler_tbl4 = 'style="height:200px;overflow-y: scroll;"';
      }//end if



      if($row4 != 0){
          echo '<div class="row">';
            if($row4_1 != 0){
            echo '<div class="col-md-'.$row4_colw.'">';
                  if(Yii::$app->session['loggeduser']['access'][3238] == 1){
                  echo '<div class="box box-info">
                  <div class="box-header with-border">
                  <label>Price Changes <span style="color: red;">(Click dates to view list of items updated)</span></label>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                  <div class="table-responsive" '.$styler_tbl4.'>
                  <table class="table no-margin">
                    <thead>
                      <tr>
                        <th class="aimslabel">Dates</th>
                        <th class="aimslabel"># OF UPDATES</th>
                      </tr>
                    </thead>
                    <tbody class="tbl-changedates">
                    </tbody>
                  </table>
                  </div>
                  <!-- /.table-responsive -->
                  </div>
                  <!-- /.box-body -->
                  <!-- /.box-footer -->
                  </div>
                  <!-- /.box -->';
                  }//end if
            echo '</div>';
            }//end if
          



            if($row4_2 != 0){
            echo '<div class="col-md-'.$row4_colw.'">';
            if($row4_2_1 != 0){
            echo '<div class="box box-info">
                  <div class="box-header with-border">
                    <label>Transaction Status</span></label>
                  </div>
                
                <div class="box-body">';
                  if(Yii::$app->session['loggeduser']['access'][3234] == 1){
                  echo '<div class="progress-group">
                    <span class="progress-text">Unposted SJ Transactions</span>
                    <span class="progress-number"><b id="countunpostsj">0</b>/<span id="countallsj">0</span></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" id="progressbarunpostsj"></div>
                    </div>
                  </div>';
                  }//end if
                  
                  if(Yii::$app->session['loggeduser']['access'][3235] == 1){
                  echo '<!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Unposted RR Transactions</span>
                    <span class="progress-number"><b id="countunpostrr">0</b>/<span id="countallrr">0</span></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" id="progressbarunpostrr"></div>
                    </div>
                  </div>';
                  }//end if
                  
                  if(Yii::$app->session['loggeduser']['access'][3236] == 1){
                  echo '<!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Paid / Cleared Account Receivables</span>
                    <span class="progress-number"><b id="countpaidar">0</b>/<span id="countallar">0</span></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" id="progressbarpaidar"></div>
                    </div>
                  </div>';
                  }//end if
                  
                  if(Yii::$app->session['loggeduser']['access'][3237] == 1){
                  echo '<!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Paid / Cleared Account Payables</span>
                    <span class="progress-number"><b id="countpaidap">0</b>/<span id="countallap">0</span></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" id="progressbarpaidap"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->';
              }//end if              
              echo '</div>
              </div>';
              }//end if 4_2_1

            if($row4_2_1 == 0){
              if($row4_2_2 == 1){
                $styler_rectang4 = 'style = "height:480px;"';
                $styler_redbox4 = 'style = "height:480px;width:235px;"';
                $styler_icon4 = 'style="margin-top:75%;font-size:2em;"';
                $styler_boxcon4 = 'style="margin-left:40%;"';
              }elseif($row4_2_2 == 2){
                $styler_rectang4 = 'style = "height:235px;"';
                $styler_redbox4 = 'style = "height:235px;width:235px;"';
                $styler_icon4 = 'style="margin-top:30%;font-size:2em;"';
                $styler_boxcon4 = 'style="margin-left:40%;"';
              }//end if
            }else{              
                $styler_rectang4 = "";
                $styler_redbox4 = "";
                $styler_icon4 = "";
                $styler_boxcon4 = "";
            }//end if

           if(Yii::$app->session['loggeduser']['access'][3239] == 1){
              echo '<div class="info-box" '.$styler_rectang4.'>
                <a class="recsjtrans clickable" style="color:black;">
                  <span class="info-box-icon bg-red" '.$styler_redbox4.'>
                  <i class="fa fa-tag" '.$styler_icon4.'></i>
                  </span>
                  <div class="info-box-content" '.$styler_boxcon4.'>
                    <span class="info-box-text">Click Here to view  RECENT SJ <br>TRANSACTIONS</span>  
                  </div><!-- /.info-box-content -->
                </a>
              </div><!-- /.info-box -->';
              }//end if

              /* if(Yii::$app->session['loggeduser']['access'][3244] == 1){
              echo '<a class="totalsched clickable" style="color:black;">
              <div class="info-box" '.$styler_rectang4.'>
                  <span class="info-box-icon bg-yellow" '.$styler_redbox4.'>
                  <i class="fa fa-institution" '.$styler_icon4.'></i>
                  </span>
                  <div class="info-box-content" '.$styler_boxcon4.'>
                    <span class="info-box-text">Click Here to view SCHEDULES<br> FOR THE DAY</span>
                    <label class="aimslabel" style="color:red;font-size: 10px">[ SCHEDULED USERS:   
                      <span id ="totalscheduledusers"></span>
                    </label>
                    <label style="color: red; font-size: 10px">]</label> 
                  </div><!-- /.info-box-content -->
              </div> <!-- /.info-box -->
              </a>';
              }//end if */

              echo '</div><!-- /.end col -->';
          }//end if
      echo '</div><!-- /.row -->';
      }//end if
?>







      


      
















      















      
    </section>
    <!-- /.content -->
    <br><br>
  </div>
</div>


