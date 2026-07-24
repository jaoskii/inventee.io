<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\HotelfrontendAsset;

HotelfrontendAsset::register($this);

?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>
<?php require_once('header2.php') ?>

<!-- Container -->
<div class="wrapper dark">
<?php echo $content; ?>
<?php require_once('contents/featuredrooms.php') ?>
</div>

<!-- End Wrapper -->


<!-- Footer -->	
<?php require_once('footers/footer.php') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>