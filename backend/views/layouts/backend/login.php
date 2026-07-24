<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

if(isset(Yii::$app->session['signnwithoutcenter'])){
  $userwithoutcenter = Yii::$app->session['signnwithoutcenter']['username'];
  $passwithoutcenter = Yii::$app->session['signnwithoutcenter']['password'];
}

?>
<input type = "hidden" id ="viewmoduleid" value="adminsignin">

                <label>Username</label>
        				<input type="text" placeholder = "Enter Username" class="form-control" id="dashusername" value="<?php if(isset($userwithoutcenter)){echo $userwithoutcenter;}?>"></br>
        				<label>Password</label>
                <input type="password" placeholder = "Enter Password" class="form-control" value = "<?php if(isset($userwithoutcenter)){echo $passwithoutcenter;}?>" id="dashpassword"></br>
                <h5 style="color:red;display:none;" class="login-errmsg"></h5>
                <label><?php echo Yii::$app->session['sysconfig']['login_info']; ?></label>
                <!-- <input style="margin-right:7px;margin-top:8px;" type="checkbox"><label>Remember Me</label> -->
                <button class="btndashin btn btn-lg btn-success btn-block">Sign-in</button>
                <h6 class="aimslabel">Best viewed on <a href="https://www.mozilla.org/en-US/firefox/new/">Mozilla Firefox</a> and <a href="https://www.google.co.in/chrome/browser/desktop/">Google Chrome</a></h6>



<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btncancelcenter" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Available Center</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
                      <label>Centers</label>
                      <select id="centerbox" class="form-control">
                        
                      </select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btncancelcenter btn btn-flat btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btnselectcenter btn btn-flat btn-success">Select Center</button>
      </div>
    </div>
  </div>
</div>

