<?php
use yii\helpers\Url;
$this->title = "Sign in/Registration";
?>

 <section class="main-container col1-layout">
    <div class="main container">
      <div class="account-login">
      <div class="page-title">
        <h2>Sign in/Registration</h2>
      </div>
          
      <div class="main">

      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a href="#" class="btn btn-lg btn-steambtn btn-block shift-signup">Registration</a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a href="#" class="btn btn-lg btn-steambtn btn-block shift-signin">Sign in</a>
        </div>
      </div>

      <div class="login-or">
        <hr class="hr-or">
        <span class="span-or">or</span>
      </div>

      <div class="signinform col-md-8 col-md-offset-2">
      <form id="fcloginform" method="POST" action="<?php echo Url::to(['/frontend/verifycustomersignin']); ?>">
      <div class="form-group">
        <label for="loginemail">Email Address <span class="required">*</span></label><br>
        <input required placeholder="Enter your email address" type="text" title="Email Address" class="floginform form-control input-text" id="loginemail" value="" name="login-email">
      </div>
      <div class="form-group">
        <!-- <a class="pull-right" href="#">Forgot password?</a> -->
        <label for="loginpass">Password <span class="required">*</span></label>
        <br>
        <input required placeholder="Enter your password" type="password" title="Password" id="loginpass" class="floginform form-control input-text" name="login-password">
      </div>
      <div class="checkbox pull-right">
        <!-- <label>
          <input type="checkbox">
          Remember me 
        </label> -->
      </div>
      <p>By logging in, I confirm that i agree to <a href="#">Company’s Privacy Policy</a></p>
      <input type="submit" id="btn-frontlogin" type="button" class="btn btn-steambtn btn-lg" value="Login">
      </form>
    </div>
    

    <div style="display:none;" class="signupform  col-md-8 col-md-offset-2">
      <form id="fcloginform" method="POST" action="<?php echo Url::to(['/frontend/cregistration'])?>">
      <div class="form-group">
        <label for="regemail">Email Address <span class="required">*</span></label>
        <br>
        <input required placeholder="Enter your email address" type="text" title="Email Address" class="form-control input-text regform" id="regemail" value="" name="reg-email">
      </div>
      <div class="form-group">
        <label for="regpass">Password <span class="required">*</span></label>
        <br>
        <input required placeholder="Enter your password" type="password" title="Password" id="regpass" class="form-control input-text regform" name="reg-password">
      </div>

      <div class="form-group">
         <label for="regname">Name: <span class="required">*</span></label>
        <br>
        <input required placeholder="Enter your full name" type="text" title="Name" id="regname" class="form-control input-text regform" name="reg-name">
      </div>

      <div class="form-group">
        <label for="regname">Contact:</label>
        <br>
        <input placeholder="Enter your contact #" type="text" title="Contact" id="regcontact" class="form-control input-text regform" name="reg-contact">
      </div>

      <div class="form-group">
        <label for="regname">Address: <span class="required">*</span></label>
        <br>
        <textarea required placeholder="Enter your full address" style="resize:none;" name="reg-address" id="regaddress" title="Address" class="form-control col-md-12 regform input-text" cols="5" rows="3"></textarea>
      </div>
      
      <p class="required">* Required Fields</p>
      <p>By signing up, I confirm that i agree to <a class="forgot-word" href="#">Company's Privacy Policy</a></p>

      <input type="submit" id="btn-frontregister" class="btn btn-steambtn btn-lg" value="Register">
      <br>
      <br>
    </div>
    </form>


    </div>

    </div>
    </div>
  </section>