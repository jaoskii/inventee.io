<?php
use yii\helpers\Url;
$this->title = 'Change Item';
switch (Yii::$app->systemsettings->companyConfig()) {
  case 'KINGGEORGE':
    $this->title = "[" .Yii::$app->session['loggeduser']['king_branchname'] . "] " .$this->title;
  break;
}//END IF
?>

<div class="row">
  <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
  <input type = "hidden" id ="savingtype" value="">
  <input type = "hidden" id ="lines" value="">
  <div class="col-md-12">
    <div class="box box-solid box-success">
      <div class="modulehead box-header with-border">
        <div class="col-md-6 pull-right">
          <div class="input-group">
            <input value ="" type="text" class="txtchangeitemsearch input-sm form-control"><div class="frmcontra input-group-addon"><i class="fa fa-search"></i></div>
          </div>
        </div>
      </div>
      <div class="box-body scroll-divs">
        <div id="modulestockview" class="box box-solid box-success"></div>
      </div>
    </div>
  </div>
</div>