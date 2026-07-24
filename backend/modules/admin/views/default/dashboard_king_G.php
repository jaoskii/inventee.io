<?php
$this->title="Please Select Branch Login";
use yii\helpers\Url;
use yii\base\ErrorException;
?>

<ul class="nav navbar-nav">
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Please Select Branch Login <span class="glyphicon glyphicon-king pull-right"></span></a>
    <ul class="dropdown-menu">
      <li class="g_companyselect" company="1"><a href="<?php echo Url::to(['/admin/login','q'=>md5(1)]);?>">Housegem Construction Company<span class="glyphicon glyphicon-home pull-right"></span></a></li>
    </ul>
  </li>
</ul>


<!-- <li class="divider"></li> -->
      <!-- <li class="g_companyselect" company="2"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(2)]);?>">Iba Stalh Corporation<span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="3"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(3)]);?>">Century Ply Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="4"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(4)]);?>">Royalturn Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="5"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(5)]);?>">Tomjens Rise Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="6"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(6)]);?>">Taita Falcon Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="7"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(7)]);?>">Temple Win Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="8"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(8)]);?>">Tom Towers Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="9"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(9)]);?>">T4triump Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li>
      <li class="divider"></li>
      <li class="g_companyselect" company="10"><a href="<?php //echo Url::to(['/admin/login','q'=>md5(10)]);?>">Tonbridge Steel Corporation <span class="glyphicon glyphicon-home pull-right"></span></a></li> -->