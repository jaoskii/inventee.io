<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$asset = BackendAsset::register($this);



$baseUrl = $asset->baseUrl;

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
</head>
<!-- LIST OF THEMES
BLACK 
BLACK-LIGHT
BLUE
BLUE-LIGHT
GREEN
GREEN-LIGHT
PURPLE
PURPLE-LIGHT
RED
RED-LIGHT
YELLOW
YELLOW
YELLOW-LIGHT
JUST CHANGE SKIN GREEN TO SKIN-"THEMENAME"
-->

<body class="hold-transition skin-green sidebar-mini">
<div class="box-header box-header-error with-border">
<center><a href="<?php echo Url::to(['/admin/index/']);?>" color="#333" class=""><i class="fa fa-home"> </i> Lets head back Home!</a></center>
</div>

    <?php $this->beginBody() ?>
          <!-- USERS LIST -->
                <!-- /.box-header -->
                <div class="box-body"><?= $content ?></div>
                <!-- /.box-body -->
          <!--/.box -->
    <?php $this->endBody() ?>

<div class="box-footer box-footer-error with-border">
</div>
</body>




</html>

<?php $this->endPage() ?>
