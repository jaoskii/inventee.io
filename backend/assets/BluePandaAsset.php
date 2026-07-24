<?php
namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class BluePandaAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'backendassets/themer/blue.css'
    ];
    
    public $js = [
        
    ];
}
