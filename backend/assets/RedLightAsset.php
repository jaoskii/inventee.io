<?php
namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class RedLightAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'backendassets/themer/red.css'
    ];
    
    public $js = [
        
    ];
}
