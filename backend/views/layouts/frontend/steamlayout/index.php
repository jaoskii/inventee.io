<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\FrontendAsset;

FrontendAsset::register($this);

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
<link rel="shortcut icon" href="frontendassets/images/ico/favicon.ico">
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
  <?php require('headers/header.php'); ?> 
  <!--END TOP HEADER -->

  <!-- TOP NAVIGATOR -->
  <?php require('headers/navbar.php'); ?> 
  <!--END TOP NAVIGATOR -->

  <!-- TOP BANNER -->
  <?php require('headers/banner.php'); ?> 
  <!--END TOP BANNER -->

  <!-- HIGHLIGHTS AND MOST REVIEWED -->
  <?php require('contents/highlights_mostreviewed.php'); ?> 
  <!--END HIGHLIGHTS AND MOST REVIEWED -->

  <br>
  <br> 

   <!-- BRANDLIST -->
  <?php require('contents/brandlist.php'); ?> 
  <!--END BRANDLIST -->
  <br>
  <br> 
  <!-- LANES -->
  <?php require('contents/lanes.php'); ?> 
  <!--END LANES -->

  <!-- PERSONALLY PICKED -->
  <?php require('contents/personallypicked.php'); ?> 
  <!--END PERSONALLY PICKED -->

  <!-- FOOTER-->
  <?php require('footer/footer.php'); ?> 
  <!--END FOOTER-->


  <?php echo $content; ?>
</div>
  
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
