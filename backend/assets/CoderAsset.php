<?php
namespace backend\assets;

use yii\web\AssetBundle;

class CoderAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'backendassets/themer/coder.css'
    ];

    public $js = [];
}
