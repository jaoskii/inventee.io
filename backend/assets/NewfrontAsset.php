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
class NewfrontAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@bower/adminlte/';

    public $publishOptions = [
    'forceCopy' => true,
    ]; 

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Varela',
        'added/sbc/styles/screen.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.svg',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
    ];
    
    public $js = [
       "added/sbc/scripts/components/jquery.js",
       "added/sbc/scripts/components/require.js",
       "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js",
       "added/sbc/scripts/components/jquery.pagenav.js",
       "added/sbc/scripts/components/navscroll.js",
       "//cdn.wordart.com/wordart.min.js",
    ];

    public $depends = [
        'yii\web\YiiAsset',
                
    ];
}
