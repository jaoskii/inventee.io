<?php
use yii\helpers\Url;
$this->title="Change your Password";
?>

<div class="my-account">
<div class="page-title">
  <h2>Change Account Password</h2>
</div>
<div class="dashboard">
<div class="content">
<?php
if(isset(Yii::$app->session['pchangemsg'])){
  echo Yii::$app->session['pchangemsg'];
  unset(Yii::$app->session['pchangemsg']);
}//end if
?>
              <form role="form" action="<?php echo Url::to(['/frontend/changepassword']);?>" method="POST">
              <ul class="form-list">
                <li>
                  <label for="infoname">Current Password:<span class="required">*</span></label>
                  <br>
                  <input required placeholder="Enter your current password" type="password" title="Name" class="input-text accountinfo" id="pchangeold" value="" name="pchangeold">
                </li>

                <li>
                  <label for="infoname">New Password:<span class="required">*</span></label>
                  <br>
                  <input required placeholder="Enter new Password" type="password" title="Name" class="input-text accountinfo" id="pchangenew" value="" name="pchangenew">
                </li>

                <li>
                  <label for="infoname">Confirm New Password:<span class="required">*</span></label>
                  <br>
                  <input required placeholder="Confirm new password" type="password" title="Name" class="input-text accountinfo" id="pchangeconfirm" value="" name="pchangeconfirm">
                </li>
              </ul>
              <p class="required">* Required Fields</p>
              <div class="buttons-set">
                <button id="btn-faccupdate" type="submit" class="button"><span>Change my Password</span></button>
              </div>
            </div>
            </form>

 

</div>
</div>
<br>
<br>
