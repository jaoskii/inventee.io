<?php
$this->title = 'Banner Manager';
$b1 = Yii::$app->homeUrl . "frontendassets/steamlayout/images/slide-img2.jpg";
$b2 = Yii::$app->homeUrl . "frontendassets/steamlayout/images/slide-img2.jpg";
$b3 = Yii::$app->homeUrl . "frontendassets/steamlayout/images/slide-img2.jpg";
$b4 = Yii::$app->homeUrl . "frontendassets/steamlayout/images/slide-img2.jpg";
$b5 = Yii::$app->homeUrl . "frontendassets/steamlayout/images/slide-img2.jpg";
foreach ($banners as $key => $bvalue) {
  if($bvalue['strimg'] != ''){
      switch ($bvalue['line']) {
        case '1':
          $b1 = $bvalue['strimg'];
          break;
        case '2':
          $b2 = $bvalue['strimg'];
          break;
        case '3':
          $b3 = $bvalue['strimg'];
          break;
        case '4':
          $b4 = $bvalue['strimg'];
          break;
        case '5':
          $b5 = $bvalue['strimg'];
          break;
      }//end switch
  }//end if
}//end for each banner
?>

<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="laneid" value="">
<div class="row">
<div class="col-md-12">
<div class="box box-solid box-success">
    <div class="modulehead box-header with-border">
     <h6 id="lanetitle" style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Manage Banner Images (Maximum of 5)</h6>
     <label class="aimslabel">REQUIRED: Dimension of (1155 x 461) and resolution (96)</label>
    </div>
                    
    <div class="box-body">
          <h6 class="aimslabel picbox">
                <img src ="<?php echo $b1;?>" width="100%" height ="350px" class="thumbnail bannerpic-1">
                <form class="bannerupload" id="bannerupload-1" method="POST" enctype="multipart/form-data">
                <span id="fileselector">
                    <label class="btn btn-default" for="buploadedpicture-1" style="margin-top:-15px;width:100%;margin-left:-10px;">
                        <input type="file" name="image" id="buploadedpicture-1" class="buploadedpicture">
                        <i class="fa fa-upload margin-correction"></i>Browse Pic
                    </label>
                </span>

                <button type = "submit" id="buploadsave-1" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                <button type = "button" id="buploadcancel-1" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                </form>
                </h6>

                <h6 class="aimslabel picbox">
                <img src ="<?php echo $b2;?>" width="100%" height ="350px" class="thumbnail bannerpic-2">
                <form class="bannerupload" id="bannerupload-2" method="POST" enctype="multipart/form-data">
                <span id="fileselector">
                    <label class="btn btn-default" for="buploadedpicture-2" style="margin-top:-15px;width:100%;margin-left:-10px;">
                        <input type="file" name="image" id="buploadedpicture-2" class="buploadedpicture">
                        <i class="fa fa-upload margin-correction"></i>Browse Pic
                    </label>
                </span>

                <button type = "submit" id="buploadsave-2" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                <button type = "button" id="buploadcancel-2" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                </form>
                </h6>

                <h6 class="aimslabel picbox">
                <img src ="<?php echo $b3;?>" width="100%" height ="350px" class="thumbnail bannerpic-3">
                <form class="bannerupload" id="bannerupload-3" method="POST" enctype="multipart/form-data">
                <span id="fileselector">
                    <label class="btn btn-default" for="buploadedpicture-3" style="margin-top:-15px;width:100%;margin-left:-10px;">
                        <input type="file" name="image" id="buploadedpicture-3" class="buploadedpicture">
                        <i class="fa fa-upload margin-correction"></i>Browse Pic
                    </label>
                </span>

                <button type = "submit" id="buploadsave-3" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                <button type = "button" id="buploadcancel-3" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                </form>
                </h6>

                <h6 class="aimslabel picbox">
                <img src ="<?php echo $b4;?>" width="100%" height ="350px" class="thumbnail bannerpic-4">
                <form class="bannerupload" id="bannerupload-4" method="POST" enctype="multipart/form-data">
                <span id="fileselector">
                    <label class="btn btn-default" for="buploadedpicture-4" style="margin-top:-15px;width:100%;margin-left:-10px;">
                        <input type="file" name="image" id="buploadedpicture-4" class="buploadedpicture">
                        <i class="fa fa-upload margin-correction"></i>Browse Pic
                    </label>
                </span>

                <button type = "submit" id="buploadsave-4" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                <button type = "button" id="buploadcancel-4" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                </form>
                </h6>

                <h6 class="aimslabel picbox">
                <img src ="<?php echo $b5;?>" width="100%" height ="350px" class="thumbnail bannerpic-5">
                <form class="bannerupload" id="bannerupload-5" method="POST" enctype="multipart/form-data">
                <span id="fileselector">
                    <label class="btn btn-default" for="buploadedpicture-5" style="margin-top:-15px;width:100%;margin-left:-10px;">
                        <input type="file" name="image" id="buploadedpicture-5" class="buploadedpicture">
                        <i class="fa fa-upload margin-correction"></i>Browse Pic
                    </label>
                </span>

                <button type = "submit" id="buploadsave-5" class="buploadsave btn btn-success" style="margin-top:5px;width:100%;display:none;">Save Image</button>
                <button type = "button" id="buploadcancel-5" class="buploadcancel btn btn-danger" style="margin-top:5px;width:100%;display:none;">Cancel</button>
                </form>
                </h6>


    </div>           
</div><!-- /.box -->
</div>
</div>