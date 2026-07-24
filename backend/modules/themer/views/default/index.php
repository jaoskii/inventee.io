<?php
use yii\helpers\Url;
$this->title = 'Theme Customizer';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<div class="row">
<input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
<input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">

<div class="col-md-12">
      <div class="box box-solid box-success">
              <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold; color:#fff;">Select your Theme</h6></b>

               
                <div class="pull-right">
                <!-- BEGIN BTN GROUP -->
                 <form id ="picupload" method="POST" enctype="multipart/form-data">
				        <span id="fileselector">
				            <label class="btn btn-default" for="upload-file-selector" style="margin-right:-10px;">
				                <input id="upload-file-selector" type="file" name="image" class="moduletxt uploadedpicture">
				                <i class="fa fa-retweet margin-correction adjust_btn"></i><b>Change Login Wallpaper</b>
				            </label>
				        </span>

				     <button type = "submit" class="uploadsave btn btn-success" style="display:none;">Save Wallpaper</button>
				     <button type = "button" class="uploadcancel btn btn-danger" style="display:none;">Cancel</button>
				</form>    
                </div>
                
                </div><!-- /.box-header -->

                <div class="row">
	            <div class="box-body">
	            <?php
	            foreach ($themes as $key => $value) {
	            	switch ($themes[$key]['themecode']) {
	            		case 'MAC':
	            			$color = "bg-mac";
	            			$title = "Mac OS X ";
	            			$themeimg = Yii::$app->homeUrl.'backendassets/img/theme/mac.jpg';
	            			break;

	            		case 'PANDATOOLS':
	            			$color = "bg-panda";
	            			$title = "Blue Panda ";
	            			$themeimg = Yii::$app->homeUrl.'backendassets/img/theme/blue.jpg';
	            			break;

	            		case 'GENLIGHT':
	            			$color = "bg-genlight";
	            			$title = "Orange Light";
	            			$themeimg = Yii::$app->homeUrl.'backendassets/img/theme/orange.jpg';
	            			break;

	            		case 'RTT':
	            			$color = "bg-grey";
	            			$title = "Shades of Grey";
	            			$themeimg = Yii::$app->homeUrl.'backendassets/img/theme/gray.jpg';
	            			break;
	            		
	            		default:
	            			$color = "bg-defaulter";
	            			$title = "SBC (Default)";
	            			$themeimg = Yii::$app->homeUrl.'backendassets/img/theme/default.jpg';
	            			break;
	            	}//END SWITCH


	            	echo '<div class="col-md-3" style="margin-bottom:10px;">
				            <div class="box box-widget widget-user-2">
				                <!-- Add the bg color to the header using any of the bg-* classes -->
				                <div class="widget-user-header '.$color.'">
				                <h5 class="theme_text"><b>'.$title.'</b>   
				                <a id = "'.$themes[$key]['themecode'].'" href="#" class="themeclicker">   
				            	<button style="background: #222d32; color:#fff;" class="btn">Apply</button>
				            	</a>
				                  <div class="widget-user-image">
				                   <br>
				                    <img style="width: 95%";" class="img-box" src="'.$themeimg.'">
				                  </div>
				                </div>
				 			</div>
					</div>';

	            }//end for each
	            ?>
	            	


				</div> <!-- END BOX BODY -->
				</div> <!-- END ROW -->

            </div><!-- /.box-body -->
        </div><!-- /.box -->
</div> <!-- END COL MD 9 -->
</div>