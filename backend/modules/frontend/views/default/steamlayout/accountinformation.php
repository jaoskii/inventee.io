<?php
$this->title = "Account Information";
?>

<div class="my-account">
<div class="page-title">
  <h2>Account Information</h2>
</div>
<div class="dashboard">

<div class="content">
              <ul class="form-list">
                <li>
                  <label for="infoname">Name:<span class="required">*</span></label>
                  <br>
                  <input placeholder="Enter your name" type="text" title="Name" class="input-text accountinfo" id="infoname" value="<?php echo Yii::$app->session['customerdata']['customername']?>" name="infoname">
                </li>

                <li>
                  <label for="infoemail">Email Address <span class="required">*</span></label>
                  <br>
                  <input value="<?php echo Yii::$app->session['customerdata']['email']?>" placeholder="Enter your email address" type="text" title="Email" id="infoemail" class="input-text accountinfo" name="infoemail">
                </li>

                <li>
                  <label for="infocontact">Contact: <span class="required">*</span></label>
                  <br>
                  <input value="<?php echo Yii::$app->session['customerdata']['customercontact']?>" placeholder="Enter your contact #" type="text" title="Contact" id="infocontact" class="input-text accountinfo" name="infocontact">
                </li>


                <!-- <li>
                  <label for="regname">Gender: <span class="required">*</span></label>
                  <br>
                  <input id="addbook-addanother" value="NEW" type="radio" name="addbook"><label for="regname" style="margin-right: 15px;"> Male</label>
                  <input id="addbook-addanother" value="NEW" type="radio" name="addbook"><label for="regname"> Female</label>
                </li>

                <li>
                  <label for="regname">Birthday: <span class="required">*</span></label>
                  <br>
                  <input placeholder="Enter your contact #" type="text" title="Contact" id="regcontact" class="input-text regform" name="reg-contact">
                </li>

                <li>
                  <label for="regname">Interest: <span class="required">*</span></label>
                  <br>

                  <?php
                    $strhtml = "";
                    $countperline = 0;
                    foreach ($lanes as $key => $value) {
                      if($countperline != 3){
                        $strhtml = $strhtml . '<input id="addbook-addanother" value="NEW" type="checkbox" name="addbook"><label style="margin-right:10px;" for="regname"> '.$value['nav_desc'].'</label>';
                         $countperline = $countperline + 1;
                      }else{
                        $strhtml = $strhtml . '<input id="addbook-addanother" value="NEW" type="checkbox" name="addbook"><label for="regname"> Female</label><br>';
                        $countperline = 0;
                      }//end if
                     
                    }//end for each
                    echo $strhtml;
                  ?>
                </li> -->

                <li>
                  <label for="regname">Address: <span class="required">*</span></label>
                  <br>
                  <textarea placeholder="Enter your full address" style="resize:none;" name="infoaddress" id="infoaddress" title="Address" class="col-md-12 accountinfo input-text" cols="5" rows="3"><?php echo Yii::$app->session['customerdata']['customeradd']?></textarea>
                </li>
                
<!-- 
                <li>
                  <label for="regbday">Birthday <span class="required">*</span></label>
                  <br>
                  <input type="text" title="Birthday" id="regbday" class="input-text regform" name="reg-birthday">
                </li>

                <li>
                  <label for="reggender">Gender <span class="required">*</span></label>
                  <br>
                  <input type="text" title="Gender" id="reggender" class="input-text regform" name="reg-gender">
                </li> -->
              </ul>
              <p class="required">* Required Fields</p>
              <div class="buttons-set">
                <button id="btn-faccupdate" type="button" class="button"><span>Update my Profile</span></button>
              </div>
            </div>

 

</div>
</div>
<br>
<br>


          


