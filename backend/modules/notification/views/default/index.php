<?php
use yii\helpers\Url;
$this->title = 'Notification';
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
    <input type = "hidden" id ="doc" value="">
    <div class="col-md-5">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Document Type</h6></b>
                <div class="pull-right">
                    <div class="btn-group"></div>
                </div>
            </div>
            <div class="box-body">
                <div class="notifdiv1"></div>
              
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                <b><h6 style="display:inline;margin-right:20px;font-size:12px;font-weight:bold;">Transaction Lists</h6></b>
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-success universefixorigqty" style="display:none;"><b><i class="fa fa-file new_btn"></i> Update Original Qty in all Invoices</b></button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="notifdiv2"></div>
               
            </div>
        </div>
    </div>
</div>

<!-- ################################################ SETTINGS LAYOUT ####################################### -->