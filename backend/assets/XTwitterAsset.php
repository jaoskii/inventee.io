<?php
namespace backend\assets;

use yii\web\AssetBundle;

class XTwitterAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'backendassets/themer/xtwitter.css'
    ];

    public $js = [];
}
