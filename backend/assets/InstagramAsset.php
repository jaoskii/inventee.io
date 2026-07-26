<?php
namespace backend\assets;

use yii\web\AssetBundle;

class InstagramAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'backendassets/themer/instagram.css'
    ];

    public $js = [];
}
