<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HotelfrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@bower/adminlte/';
    
    public $css = [
    //#################### HOTEL LAYOUT CSS #################################
    'frontendassets/hoteldemo/css/style.css',
    'frontendassets/hoteldemo/css/dr-framework.css',
    'frontendassets/hoteldemo/css/navigation.css',
    'frontendassets/hoteldemo/css/revslider.css',
    'frontendassets/hoteldemo/css/jquery.bxslider.css',
    'frontendassets/hoteldemo/css/zebra.css',
    'frontendassets/hoteldemo/css/responsive.css',
    'frontendassets/hoteldemo/css/font-awesome/css/font-awesome.css',
    'http://fonts.googleapis.com/css?family=Oswald:400,300,700',
    'http://fonts.googleapis.com/css?family=Open+Sans:400,700',

    ];

    public $js = [
    'added/config/ajax_config.js',
    'frontendassets/hoteldemo/js/jquery.min.js',
    'frontendassets/hoteldemo/js/bootstrap.min.js',
    'frontendassets/hoteldemo/js/jquery.flexslider.js',
    'frontendassets/hoteldemo/js/jquery.superfish.js',
    'frontendassets/hoteldemo/js/script.js',
    'frontendassets/hoteldemo/js/accordion.js',
    'frontendassets/hoteldemo/js/jquery.bxslider.js',
    'frontendassets/hoteldemo/js/zebra_datepicker.js',
    'frontendassets/hoteldemo/js/core.js',
    'frontendassets/jao/js/frontend-scripts.js',
    'frontendassets/jao/js/hotelscripts.js',
    'added/noty/jquery.noty.packaged.js',
    'added/noty/noty-common.js',
    'added/blockui/blockui.js',
    'added/js/jquery.number.js',
    'added/tooltipster/js/tooltipster.bundle.min.js',
    'added/countdown/jquery.countdown.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
