<?php
use yii\helpers\Url;
$this->title = "Sign in/Registration";
?>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Sign Up or Login</h4>
                    <span class="pull-right">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">Sign In</a></li>
                            <li><a href="#tab2" data-toggle="tab">Sign Up/Register</a></li>
                        </ul>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        
                        <div class="tab-pane active" id="tab1">
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
                          <br>
                          <input type="submit" id="btn-frontlogin" type="button" class="btn btn-steambtn btn-lg" value="Login">
                          </form>
                        </div>

                        <div class="tab-pane" id="tab2">
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
                                  <br>
                                  <input type="submit" id="btn-frontregister" class="btn btn-steambtn btn-lg" value="Register">
                                  <br>
                                  <br>
                                </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>

