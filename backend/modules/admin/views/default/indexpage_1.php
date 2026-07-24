<?php
$this->title = 'Home';
use yii\helpers\Url;
use yii\base\ErrorException;
?>


<?php


?>


<input type = "hidden" id ="viewmoduleid" value="indexpage">
<div class="quickaccess" style="margin-top:8%;">
  <div class="row">  
  <a href="<?php echo Url::to(['/SO/index']); ?>">
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-calendar"></i><br>
  <label style="font-size:20px;">Sales Order</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/PO/index']); ?>">
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-calendar"></i><br>
  <label style="font-size:20px;">Purchase Order</label>
  </div>
  </a>

  <?php
  switch (Yii::$app->systemsettings->companyConfig()) {
    case 'YULICK':
    echo '<a href="'.Url::to(['/SJ2/index']).'">';
    break;

    default:
    echo '<a href="'.Url::to(['/SJ/index']).'">';
    break;
  }//end switch case
  ?>
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-tags"></i><br>
  <label style="font-size:20px;">Sales Journal</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/RR/index']); ?>">
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-arrow-circle-o-down"></i><br>
  <label style="font-size:20px;">Receiving Report</label>
  </div>
  </a>
</div>

<div class="row">
  <a href="<?php echo Url::to(['/CR/index']); ?>">
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-edit"></i><br>
  <label style="font-size:20px;">Received Payment</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/CV/index']); ?>">
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-edit"></i><br>
  <label style="font-size:15px;">Cash / Check Voucher</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/GJ/index']); ?>">
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-edit"></i><br>
  <label style="font-size:20px;">General Journal</label>
  </div>
  </a>

  <a href="<?php echo Url::to(['/reportlist/index']); ?>">
  <div class="col-xs-6 btn btn-app quicka_btn" style="height:200px;width:200px;border:solid 1px;">
  <i style="margin-top:20%;font-size:60px;" class="fa fa-file"></i><br>
  <label style="font-size:20px;">Chart of Accounts</label>
  </div>
  </a>
</div>
</div>



<div class="mobile-quickaccess"">
  <div class="container">
    <div class="row">
      <a href="<?php echo Url::to(['/SO/index']); ?>">
      <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
      <i style="margin-top:20%;font-size:30px;" class="fa fa-calendar"></i><br>
      <label style="font-size:20px;">Sales Order</label>
      </div>
      </a>

      <a href="<?php echo Url::to(['/PO/index']); ?>">
      <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
      <i style="margin-top:20%;font-size:30px;" class="fa fa-calendar"></i><br>
      <label style="font-size:20px;">Purchase Order</label>
      </div>
      </a>
    </div>


    <div class="row">
      <?php
      switch (Yii::$app->systemsettings->companyConfig()) {
        case 'YULICK':
        echo '<a href="'.Url::to(['/SJ2/index']).'">';
        break;

        default:
        echo '<a href="'.Url::to(['/SJ/index']).'">';
        break;
      }//end switch case
      ?>
        <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
        <i style="margin-top:20%;font-size:30px;" class="fa fa-tags"></i><br>
        <label style="font-size:20px;">Sales Journal</label>
        </div>
        </a>

        <a href="<?php echo Url::to(['/RR/index']); ?>">
        <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
        <i style="margin-top:20%;font-size:30px;" class="fa fa-arrow-circle-o-down"></i><br>
        <label style="font-size:20px;">Receiving Report</label>
        </div>
        </a>
    </div>


    <div class="row">
      <a href="<?php echo Url::to(['/CR/index']); ?>">
      <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
      <i style="margin-top:20%;font-size:30px;" class="fa fa-edit"></i><br>
      <label style="font-size:15px;">Received Payment</label>
      </div>
      </a>

      <a href="<?php echo Url::to(['/CV/index']); ?>">
      <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
      <i style="margin-top:20%;font-size:30px;" class="fa fa-edit"></i><br>
      <label style="font-size:15px;">Cash / Check Voucher</label>
      </div>
      </a>
    </div>

    <div class="row">
      <a href="<?php echo Url::to(['/GJ/index']); ?>">
      <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
      <i style="margin-top:20%;font-size:30px;" class="fa fa-edit"></i><br>
      <label style="font-size:20px;">General Journal</label>
      </div>
      </a>

      <a href="<?php echo Url::to(['/reportlist/index']); ?>">
      <div class="col-xs-6 btn btn-app quicka_btn" style="height:180px;width:180px;border:solid 1px;">
      <i style="margin-top:20%;font-size:30px;" class="fa fa-file"></i><br>
      <label style="font-size:20px;">Chart of Accounts</label>
      </div>
      </a>
    </div>
  </div>
</div>
