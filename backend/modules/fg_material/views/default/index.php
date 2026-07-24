<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
$this->title = 'Materials';
?>

<div class="row">
    <input type = "hidden" id ="moduleid" value="<?php echo $moduleid; ?>">
    <input type = "hidden" id ="viewmoduleid" value="<?php echo $moduleid; ?>">
    <div class="col-md-12">
        <div class="box box-solid box-success">
            <div class="modulehead box-header with-border">
                <div class="pull-right">
                    <div class="btn-group">
                        <button data-toggle="tooltip" class="btn btn-default btn-success headbtn btnactive module-btnnewmaster"><b><i class="fa fa-file new_btn"></i> New</b></button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div id="masterfilegrid"></div>
            </div>
        </div>
    </div>
</div>