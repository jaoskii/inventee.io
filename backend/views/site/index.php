<?php
use yii\helpers\Html;
use yii\helpers\Url;


switch (Yii::$app->systemsettings->companyfrontendConfig()) {
	case 'BUYMORE':
		$this->title = 'Online Shopping Layout';
	break;

	case 'HOTELDEMO':
		$this->title = 'Hotel Booking';
	break;

	case 'XTZ':
		$this->title = 'XTZ';
	break;
}//end switch

?>
