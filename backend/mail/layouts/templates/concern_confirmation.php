  <h5>Hello Sir / Ma'am</h5>
  <h5>We have received your email concern, Please kindly wait for our feedback.</h5>
  <h5>we will contact you directly as soon as possible</h5>
  <h5>Thank you very much! for your patience!</h5>

  <?php
  	switch (Yii::$app->systemsettings->companyfrontendConfig()) {
  		case 'XTZ':
  			echo "<h5>You could contact us on +639778090906 / +63927966294</h5>";
  		break;
  		case 'SBC':
  			echo "<h5>You could contact us on 244-1062</h5>";
  		break;
  		default:
  			echo "";
  		break;
  	}//end switch
  ?>

  <h5>Best regards ,  <?php echo Yii::$app->systemsettings->requestDefaultEmailSenderName();?></h5>
