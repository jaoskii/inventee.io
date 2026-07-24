<?php
use yii\helpers\Url;
?>

<div class="block block-company">
  <div class="block-title">Company </div>
  <div class="block-content">
    <ol id="recently-viewed-items">
      <li class="item odd"><a href="<?php echo Url::to(['/frontend/about/']);?>">About Us</a></li>
      
      <li class="item  odd"><a href="#">Terms of Service</a></li>
      <li class="item last"><a href="<?php echo Url::to(['/frontend/contact/']);?>">Contact Us</a></li>
    </ol>
  </div>
</div>