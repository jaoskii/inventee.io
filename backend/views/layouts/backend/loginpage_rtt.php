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
<html lang="<?= Yii::$app->language ?>"
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<style type="text/css">
body{
/*background-color:#000;*/
    background: url(<?php echo Yii::$app->session['wallpaper'];?>);
}

.form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
#jew
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
#jew2
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
margin-top: 40px;
/*padding: 40px 0px 20px 0px;*/
/*background-color: #ffffff;*/
/*-webkit-box-shadow: 8px 10px 5px -2px rgba(0,0,0,0.34);
-moz-box-shadow: 8px 10px 5px -2px rgba(0,0,0,0.34);
box-shadow: 8px 10px 5px -2px rgba(0,0,0,0.34);*/
width: 400px;
/*border: solid 1px red;*/
}

.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
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

<br/>
      <center style="width: 100%;">    
    <h2 style=" font-weight: bold;">Welcome To</h2>  
    <h1 style="font-size: 85px;font-family: trojan;  text-align: center;"><b>RT</b>&nbsp;TRADING</h1>


<br/>

    
  </center>
        <div class="col-sm-12 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <div id="my-tab-content" class="tab-content">
                    <div class="tab-pane active" id="login" style="margin-right:30px;margin-left:30px;">
                        <img class="profile-img" src="<?php echo Yii::$app->homeUrl;?>backendassets/img/aims_login.png" alt="">
                        <div id="overlay"></div>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
