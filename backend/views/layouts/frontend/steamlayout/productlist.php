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
  <?php 
  switch ($_GET['type']) {
    case 'lane': case 'category':
      require('addons/breadcrumbs.php'); 
      break;
  }//end swithch
  ?> 
  <!--END BREADCRUMBS -->

  <div class="main-container col2-left-layout">
    <div class="main container">
      <div class="row">
        <section class="col-main col-sm-9 col-sm-push-3 animated">
            <?php echo $content; ?>
        </section>
        <aside class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9 animated">
              <!-- CART SIDE -->
              <?php //require('addons/cart_mini.php'); ?> 
              <!--END CART SIDE -->

              <!-- COMPARE SIDE -->
              <?php //require('addons/comparelist_mini.php'); ?> 
              <!--END COMPARE SIDE -->

              <!-- CATEGORY SIDE -->
              <?php require('addons/category_sidebar.php'); ?> 
              <!--END CATEGORY SIDE -->

              <!-- CATEGORY SIDE -->
              <?php require('addons/recentlyviewed_mini.php'); ?> 
              <!--END CATEGORY SIDE -->
        </aside>
      </div>
    </div>
  </div>

  <!-- FOOTER-->
  <?php require('footer/footer.php'); ?> 
  <!--END FOOTER-->
</div>
  
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
