<?php

if($status){
  echo '<div class="alert alert-danger fade in" style="margin-top:18px;">
  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
  <strong>'.$msg.'</strong>
  </div>';
}else{
  echo '<div class="alert alert-success fade in" style="margin-top:18px;">
  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
  <strong>'.$msg.'</strong>
  </div>';
}//end if
?>