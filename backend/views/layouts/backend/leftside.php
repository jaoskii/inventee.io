<?php 
use yii\helpers\Url;
use yii\base\ErrorException;
if(isset(Yii::$app->session['loggeduser'])){
  $menuaccess = Yii::$app->session['loggeduser']['access'];
}else{
  $menuaccess = "";
}//end if

$utilities = array('useraccess','branchaccess','branchmasterfile','audittrail','terms','docprefix','changeitem','notification');
$moduleid = $this->params['moduleid'];



?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="leftsidemenu main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- sidebar menu: : style can be found in sidebar.less -->

<ul class="sidebar-menu">
<li class="header">MAIN NAVIGATION</li>
<?php 

try {
Yii::$app->backend->setLeftSideMenu($moduleid);
} catch (ErrorException $e) {
 echo $e; 
}
?>
</ul><!-- //end ul sidebar menu -->

</section>
<!-- /.sidebar -->
</aside>
