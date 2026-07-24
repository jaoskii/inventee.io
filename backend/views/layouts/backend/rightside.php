<?php 
use yii\helpers\Url;

if(isset(Yii::$app->session['loggeduser'])){
  $menuaccess = Yii::$app->session['loggeduser']['access'];
}else{
  $menuaccess = "";
}//end if

?>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark jaofixed-right">
        <!-- Create the tabs -->
      <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu2">
            <li class="header">UTILITIES</li>

            <li class="treeview">
              <a href="#">
                <i class="productions_ico fa fa fa-gears"></i> <span>USER CONFIGURATION</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>

              <ul class="treeview-menu">
              <?php
              if($menuaccess[362] == 1){
                echo '<li class=';
                if($moduleid == "useraccess"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/useraccess/index/']).'"><i class="fa fa-users productions_sub_ico"></i> User Access</a>
                </li>';
              }//FOR MENU ACCESS PO
               
              if($menuaccess[597] == 1){
              echo '<li class=';
                if($moduleid == "branchaccess"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/branchaccess/index/']).'"><i class="productions_sub_ico fa fa-institution"></i> 
                Branch Access</a></li>';
              }

              if(Yii::$app->session['loggeduser']['branch_access'] == 1){
                echo '<li class=';
                if($moduleid == "branchmasterfile"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/branchmasterfile/index/']).'"><i class="productions_sub_ico fa fa-institution"></i> Branch Masterfile</a></li>';
              }//FOR MENU ACCESS PO
              ?>
            </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="productions_ico fa fa-gears"></i> <span>TRANSACTION CONFIG</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>

              <ul class="treeview-menu">
                <li class="active">
                <a href="#" class="callproductinquiry"><i class="fa fa-question productions_sub_ico"></i> Product Inquiry</a>
                </li>
              <?php
              if($menuaccess[633] == 1){
                echo '<li class=';
                if($moduleid == "audittrail"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/audittrail/index/']).'"><i class="fa fa-list productions_sub_ico"></i> Audit Trail</a></li>';
              }//FOR MENU ACCESS PO

              if($menuaccess[598] == 1){
                echo '<li class=';
                if($moduleid == "terms"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/terms/index/']).'"><i class="fa fa-list productions_sub_ico"></i> Terms</a></li>';
              }//FOR MENU ACCESS PO

              if($menuaccess[599] == 1){
                echo '<li class=';
                if($moduleid == "docprefix"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/docprefix/index/']).'"><i class="fa fa-font productions_sub_ico"></i> Document Prefix</a></li>';
              }//FOR MENU ACCESS PO

              if($menuaccess[652] == 1){ //same access as audit trail
                echo '<li class=';
                if($moduleid == "notification"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/notification/index/']).'"><i class="fa fa-history productions_sub_ico"></i> Unposted Transaction</a></li>';
              }//FOR MENU ACCESS PO
               

              if(Yii::$app->systemsettings->companyConfig() == "YULICK"){ //ADDING COMPANY PREFIX UTILITY FOR PARANAQUE
                echo '<li class=';
                if($moduleid == "comprefix"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/comprefix/index/']).'"><i class="fa fa-institution productions_sub_ico"></i> Company Prefixes</a></li>';
              }//FOR MENU ACCESS PO
              ?>


            </ul>

            </li>

            <li class="treeview">
              <a href="#">
                <i class="productions_ico fa fa-gears"></i> <span>FRONTEND CONFIG</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>

              <ul class="treeview-menu">

              <li class="active">
              <a href="#" class="callchangefrontlogo"><i class="fa fa-star productions_sub_ico"></i> Change Frontend Logo</a>
              </li>

              <li class="active">
              <a href="<?php echo Url::to(['/ordermanager/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Order Manager</a>
              </li>

            <!--   <li class="active">
              <a href="<?php echo Url::to(['/fbrmanager/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Brand Manager</a>
              </li>
 -->
              <li class="active">
              <a href="<?php echo Url::to(['/fbmanager/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Banner Manager</a>
              </li>
              
              <li class="active">
              <a href="<?php echo Url::to(['/lanemanager/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Lane Manager</a>
              </li>

              <li class="active">
              <a href="<?php echo Url::to(['/fhighlights/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Highlight Manager</a>
              </li>

              <li class="active">
              <a href="<?php echo Url::to(['/managedod/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> DOD Manager</a>
              </li>

               <?php
              if($menuaccess[363] == 1){
                echo '<li class=';
                if($moduleid == "frontendlogs"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/frontendlogs/index/']).'"><i class="fa fa-list productions_sub_ico"></i> Frontend Logs</a></li>';
              }//FOR MENU ACCESS PO
              ?>
            </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="productions_ico fa fa-gears"></i> <span>MISC CONFIG</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>

              <ul class="treeview-menu">
              <?php
              if($menuaccess[632] == 1){
                echo '<li class=';
                if($moduleid == "changeitem"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/changeitem/index/']).'"><i class="fa fa-undo productions_sub_ico"></i> Change Item</a></li>';
              }//FOR MENU ACCESS PO

              if($menuaccess[363] == 1){
                echo '<li class=';
                if($moduleid == "frontendlogs"){ echo '"active"'; }
                echo'><a href="'.Url::to(['/frontendlogs/index/']).'"><i class="fa fa-list productions_sub_ico"></i> Frontend Logs</a></li>';
              }//FOR MENU ACCESS PO

              ?>

              <li class="active">
              <a href="<?php echo Url::to(['/scheduler/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Scheduler</a>
              </li>

              <li class="active">
              <a href="<?php echo Url::to(['/schedmanager/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Schedule Manager</a>
              </li>

              <li class="active">
              <a href="#" class="btnmanageanon"><i class="fa fa-bullhorn productions_sub_ico"></i> Manage Announcements</a>
              </li>
              
              <li class="active">
              <a href="<?php echo Url::to(['/themer/index/']);?>"><i class="fa fa-star productions_sub_ico"></i> Theme Customizer</a>
              </li>
            </ul>
            </li>

          </ul>
            
        </section>

      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>