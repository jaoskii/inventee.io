<?php
switch (Yii::$app->params['mailtype']) {
	case 'ECOMMORDERS': //SENDS ORDER INFORMATION TO CUSTOMER
		include_once("templates/itemorders.php");
		break;
	
	case 'RECEIVE_CONCERN': //SENDS CUSTOMER CONCERN ON SET RECEIVING EMAIL
		include_once("templates/receive_concern.php");
		break;

	case 'SEND_CONCERN_CONFIRM': //SEND CONFIRMATION TO SENDER THAT CONCERN IS RECEIVED 
		include_once("templates/concern_confirmation.php");
	break;

	case 'INQUIRY_REPLY': //SEND CONFIRMATION TO SENDER THAT CONCERN IS RECEIVED 
		include_once("templates/inquiry_reply.php");
	break;

	default:
		include_once("templates/concern_confirmation.php");
	break;
}

?>