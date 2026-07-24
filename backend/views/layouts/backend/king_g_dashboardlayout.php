<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\BackendAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;


BackendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<style type="text/css">
body {
  background:#f0f0f0;
}
.nav {
    left:50%;
    margin-left:-150px;
    top:50px;
    position:absolute;
}
.nav>li>a:hover, .nav>li>a:focus, .nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
    background:#fff;
}
.dropdown {
    background:#fff;
    border:1px solid #ccc;
    border-radius:4px;
    width:300px;    
}
.dropdown-menu>li>a {
    color:#428bca;
}
.dropdown ul.dropdown-menu {
    border-radius:4px;
    box-shadow:none;
    margin-top:20px;
    width:300px;
}
.dropdown ul.dropdown-menu:before {
    content: "";
    border-bottom: 10px solid #fff;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    top: -10px;
    right: 16px;
    z-index: 10;
}
.dropdown ul.dropdown-menu:after {
    content: "";
    border-bottom: 12px solid #ccc;
    border-right: 12px solid transparent;
    border-left: 12px solid transparent;
    position: absolute;
    top: -12px;
    right: 14px;
    z-index: 9;
}
    </style>

</head>

<?php
switch (Yii::$app->session['loggeduser']['theme']) {
    case 'MAC':
    echo '<body class="hold-transition skin-black-light sidebar-mini">';
        break;

    case 'PANDATOOLS':
    echo '<body class="hold-transition skin-green sidebar-mini">';
        break;

    case 'GENLIGHT':
    echo '<body class="hold-transition skin-green sidebar-mini">';
        break;
                        
    default:
    echo '<body class="hold-transition skin-green sidebar-mini">';
        break;
}
?>

<?php $this->beginBody() ?>
<br>
<br>

<div class="container">
    <div class="row">
        <div class="atmediafix">
                        <?= $content ?>
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
