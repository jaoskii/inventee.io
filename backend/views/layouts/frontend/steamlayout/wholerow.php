<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\FrontendAsset;

FrontendAsset::register($this);
$favicon = Yii::$app->homeUrl.'frontendassets/steamlayout/favicon.ico';
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- Favicons Icon -->
<link rel="shortcut icon" href="<?php echo $favicon;?>">
<!-- Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>
<div class="page">
<div id="overlay"></div>
  <!-- TOP HEADER -->
  <!--END TOP HEADER -->

  <!-- TOP NAVIGATOR -->
  <!--END TOP NAVIGATOR -->

  <!-- BREADCRUMBS -->
  <?php //require('addons/breadcrumbs.php'); ?> 
  <!--END BREADCRUMBS -->

   <?php echo $content; ?>

  <!-- FOOTER-->

  <!--END FOOTER-->
 
</div>
  
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
