<?php
namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class GreyAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'backendassets/themer/grey.css'
    ];
    
    public $js = [
        
    ];
}
