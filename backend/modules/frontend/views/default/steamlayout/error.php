<?php
use yii\helpers\Url;
$this->title = "Error!"
?>

  <section class="content-wrapper">
    <div class="container">
      <div class="std">
        <div class="page-not-found animated">
          <h2>404</h2>
          <h3><img src="<?php echo Yii::$app->homeUrl; ?>frontendassets/steamlayout/images/signal.png" alt="signal">Oops! The Page you requested was not found!</h3>
          <div><a href="<?php echo Url::to(['/']); ?>" class="btn-home"><span>Back To Home</span></a></div>
        </div>
      </div>
    </div>
  </section>