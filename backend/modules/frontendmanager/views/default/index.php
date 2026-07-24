<?php
$this->title = 'Frontend Manager';
use yii\helpers\Url;
use yii\base\ErrorException;
?>

<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

<div class="pull-right">
 
</div>
<input type = "hidden" id ="viewmoduleid" value="indexpage">
<div class="quickaccess" style="margin-top:8%;">
<div class="row">
  <div class="col-md-12 col-md-push-1">
  <a href="#" class="callchangefrontlogo">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-calendar"></i><br>
  <label style="font-size:20px;"">Change Frontend <br>Logo</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/fbmanager/index/']);?>">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-calendar"></i><br>
  <label style="font-size:20px;"">Manage Banners</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/fbrmanager/index/']);?>">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-arrow-circle-o-down"></i><br>
  <label style="font-size:20px;"">Manage Brands</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/lanemanager/index/']);?>">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-arrow-circle-o-down"></i><br>
  <label style="font-size:20px;"">Manage Lanes</label>
  </div>
  </a>
  
  </div>

</div>

<div class="row">
  <div class="col-md-12 col-md-push-1">

  <a href="<?php echo Url::to(['/ordermanager/index/']);?>">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-arrow-circle-o-down"></i><br>
  <label style="font-size:20px;"">Manage Orders</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/fhighlights/index/']);?>">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-arrow-circle-o-down"></i><br>
  <label style="font-size:20px;"">Manage Highlights</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/managedod/index/']);?>">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-edit"></i><br>
  <label style="font-size:20px;"">Manage Deals of <br> the Day</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/frontendlogs/index/']); ?>">
  <div class="col-md-4 col-md-push-1 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-edit"></i><br>
  <label style="font-size:20px;"">Frontend Logs</label>
  </div>
  </a>


  </div>
</div>

</div>