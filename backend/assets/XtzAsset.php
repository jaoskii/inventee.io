<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class XtzAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@bower/adminlte/';

    public $publishOptions = [
    'forceCopy' => true,
    ]; 

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Varela',
        'added/xtz/styles/xtz_atmedia.css',
    ];
    
    public $js = [
       "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js",
       'added/config/ajax_config.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
                
    ];
}
