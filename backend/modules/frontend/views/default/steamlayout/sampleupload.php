<?php
use yii\helpers\Url;
$this->title = "Select shipping address";
?>

 <form class="cmxform form-horizontal tasi-form" method="POST" action="<?php echo  Url::to(['/frontend/sampleupload']);?>" enctype="multipart/form-data">
  <div class="file fileupload fileupload-new" data-provides="fileupload">
  <span class="btn btn-success btn-file">
  <span class="fileupload-new"><i class="icon-paper-clip"></i> Change your Profile Picture</span>
  <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
  <input class = "form-file" type="file" name="imagex" required/></span>
  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
  <button type = "submit" class="fileupload-exists btn btn-primary" name="changeprof">Upload</button>
  </form>