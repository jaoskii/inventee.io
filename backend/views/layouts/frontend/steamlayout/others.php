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

  <!-- BREADCRUMBS -->
  <?php //require('addons/breadcrumbs.php'); ?> 
  <!--END BREADCRUMBS -->
   <!-- main-container -->
  <div class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
        <section class="col-main col-sm-9 wow bounceInUp animated">
          <?php echo $content; ?>
        </section>

        <aside class="col-right sidebar col-sm-3 wow bounceInUp animated">
          <!-- OTHER SIDEBAR-->
          <?php require('addons/others_sidebar.php'); ?> 
          <!--END OTHER SIDEBAR-->
        </aside>
      </div>
    </div>
  </div>
  
  <br>
  <br>
  <!-- FOOTER-->
  <?php require('footer/footer.php'); ?> 
  <!--END FOOTER-->
 
</div>
  
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
