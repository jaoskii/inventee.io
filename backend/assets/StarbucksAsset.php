<?php
namespace backend\assets;

use yii\web\AssetBundle;

class StarbucksAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'backendassets/themer/starbucks.css'
    ];

    public $js = [];
}
