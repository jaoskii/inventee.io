<?php
namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class DefaultThemeAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'backendassets/themer/default.css'
    ];
    
    public $js = [
        
    ];
}
