<?php
$this->title = 'Menu List';

$this->registerCss("
        #componentitemsgrid, #setmenuchoicesgrid {height 400px;}
        .choicemenuimgdiv {width:100%;margin-bottom:20px;}
        #manageitemsgrid {height:500px;}
    ");

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
                <div class="pull-right">
                    <div class="btn-group">
                        <button title="New" class="btn btn-default btn-success headbtn btnactive btnaddsetmenu"><b><i class="new_btn fa fa-file"></i> Add Set Menu</b></button>
                        <button title="New" class="btn btn-default btn-success headbtn btnactive btnaddmenu"><b><i class="new_btn fa fa-file"></i> Add</b></button>
                    </div>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            
            <div class="manageitemsdiv">
                
            </div>
        </div>
    </div>
</div>