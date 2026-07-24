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
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@bower/adminlte/';
    
    public $publishOptions = [
    '   forceCopy' => true,
    ];     

    public $css = [
    //#################### STEAM LAYOUT CSS #################################
    'frontendassets/steamlayout/css/animate.css',
    'frontendassets/steamlayout/css/bootstrap.min.css',
    'frontendassets/steamlayout/css/style.css',
    'frontendassets/steamlayout/css/revslider.css',
    'frontendassets/steamlayout/css/owl.carousel.css',
    'frontendassets/steamlayout/css/owl.theme.css',
    'frontendassets/steamlayout/css/font-awesome.css',
    'added/bxslider/jquery.bxslider.css',
    'frontendassets/jao/css/frontend-css.css',
    'added/tooltipster/css/tooltipster.bundle.min.css',
    'https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,300,700,800,400,600',
    ];
    
    public $js = [
    'added/config/ajax_config.js',
    'frontendassets/steamlayout/js/jquery.min.js',
    'frontendassets/steamlayout/js/bootstrap.js',
    'frontendassets/steamlayout/js/parallax.js',
    'frontendassets/steamlayout/js/common.js',
    'frontendassets/steamlayout/js/revslider.js',
    'frontendassets/steamlayout/js/owl.carousel.min.js',
    'frontendassets/steamlayout/js/cloudzoom.js',
    'frontendassets/steamlayout/js/sliderinit.js',
    'frontendassets/jao/js/frontend-scripts.js',
    'added/noty/jquery.noty.packaged.js',
    'added/noty/noty-common.js',
    'added/blockui/blockui.js',
    'added/bxslider/jquery.bxslider.js',
    'added/bxslider/init.js',
    'added/js/jquery.number.js',
    'added/tooltipster/js/tooltipster.bundle.min.js',
    'added/countdown/jquery.countdown.js',

    'nodeassets/iochat/app.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
