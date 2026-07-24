<?php
namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class MacAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'backendassets/themer/mac.css'
    ];
    
    public $js = [
        
    ];
}
