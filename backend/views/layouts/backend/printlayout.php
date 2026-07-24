<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\ReportsAsset;
use yii\helpers\Html;

use yii\base\ErrorException;
try {

if(isset($this->params['printing_type'])){
    $printtype = $this->params['printing_type'];
}else{
    $printtype = '';
}//end if

switch (strtoupper($printtype)) {
    case 'EXCEL':
        $extits = str_replace(' ', '', $this->title);
        $filename=$extits.".xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        break;
    
    default:
        $asset = ReportsAsset::register($this);
        $baseUrl = $asset->baseUrl;
        break;
}//END IF 
} catch (ErrorException $e) {
    echo $e;
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

<div class="wrapper">

<div id="header">
    <div id="slayout_header"></div>
</div><!-- header -->

<div id="slayout_wrap">
    <div id="fade" class="dark_overlay"> </div><!--dark overlay-->
    </br>
      <?= $content ?>
    </br>
</div><!-- page -->

<?php $this->endBody() ?>
</body>


</html>
<?php $this->endPage() ?>

