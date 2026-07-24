<?php
use yii\helpers\Url;
$this->title = "Error!"
?>

  <section class="content-wrapper">
    <div class="container">
      <div class="std">
        <div class="page-not-found wow bounceInRight animated">
          <h2>404</h2>
          <h3><img src="<?php echo Yii::$app->homeUrl; ?>frontendassets/steamlayout/images/signal.png" alt="signal">You have cancelled your online payment. Placing of order has been cancelled.</h3>
          <div><a href="<?php echo Url::to(['/']); ?>" class="btn-home"><span>Go back to home.</span></a></div>
        </div>
      </div>
    </div>
  </section>