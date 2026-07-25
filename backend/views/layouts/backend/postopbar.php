<?php
use yii\helpers\Url;
$create = strtotime(Yii::$app->session['loggeduser']['create']);

if(Yii::$app->session['loggeduser']['pic'] == "" || Yii::$app->session['loggeduser']['pic'] == null){
    $userpic = Yii::$app->homeUrl.'fimages/inventee/png/placeholder.png';    
}else{
    $userpic = Yii::$app->session['loggeduser']['pic'];
}//end
?>
  <header class="main-header">
        <!-- Logo -->        
        <a href="<?php echo Url::to(['/admin/index']);?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?php echo Yii::$app->session['sysconfig']['topheader_mini']; ?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?php echo Yii::$app->session['sysconfig']['topheader']; ?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          
          <?php

         if (Yii::$app->session['loggeduser']['center'] != "") {
//          MENU TOGGLER <!-- Sidebar toggle button-->
          echo '
           <ul class="nav navbar-nav">
                <li href="" class="user user-menu" >
                  <a class="hidden-xs"><b>'.$this->title.'</b></a>
                </li>
           </ul>';

          //USER INFORMATION MENU
          echo '
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
            
              <li class="user user-menu">
                <a href="'. Url::to(['/admin/index']) .'" >
                  <span class="hidden-xs"><b><i class="fa fa-home"></i> Home</b></span>
                </a>
              </li>

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle usertopbarmenu" data-toggle="dropdown">
                  <span class="hidden-xs">Welcome, <b>'.Yii::$app->session['loggeduser']['name'].'</b></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header" style="height:5%;">
                    <img class="userpictopbar" src="'.$userpic.'">
                    <p class="user-info"><small><b>Name: '.Yii::$app->session['loggeduser']['name'].'</b></small></p>
                    <p class="user-info"><small><b>User Group: '.Yii::$app->session['loggeduser']['usergrp'].'</b></small>
                    <p class="user-info"><small><b>Center Code : '.Yii::$app->session['loggeduser']['center'].'</b></small></p>
                    <p class="user-info"><small><b>Center : '.Yii::$app->session['loggeduser']['centername'].'</b></small></p>
                    <p class="user-info"><small><b><a style="color:white;" class="clickable changepass">[ Change Password ]</a></b></small></p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="'. Url::to(['/scheduler/index/']) .'" class="btn btn-sm btn-github btn-flat">Scheduler</a>
                      <a href="'. Url::to(['/themer/index/']) .'" class="btn btn-sm btn-primary btn-flat">Change Theme</a>
                    </div>
                    
                    <div class="pull-right">
                      <a href="'. Url::to(['/admin/logout/']) .'" class="btn btn-sm btn-danger btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>';
           }
          //?>

            </ul>
          </div>
        </nav>
      </header>