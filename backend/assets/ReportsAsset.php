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
class ReportsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'added/css/print.css',
        'backendassets/plugins/font-awesome/css/font-awesome.min.css',
    ];
    
    public $js = [
        'backendassets/plugins/jQuery/jQuery-2.1.4.min.js',
        'backendassets/bootstrap/js/bootstrap.min.js',
        'backendassets/plugins/jQueryUI/jquery-ui.js',
        'added/config/ajax_config.js',
        'backendassets/jao/js/ajax_reporting.js',
        'backendassets/jao/js/modal-constructor.js',//override alvin 12/27/2017
        'backendassets/jao/js/global-functions.js',//edited alvin 12/27/2017
        //FOR NOTY SCRIPT ALERTS
        'added/noty/jquery.noty.packaged.js',
        'added/noty/noty-common.js',
        //FOR CHARTJS
        'added/js/URI.js',
        'added/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'added/bootstrap-datepicker/js/datepicker-ini.js',
        'backendassets/plugins/timepicker/bootstrap-timepicker.js',
        'added/js/moment.js',
        'added/js/jquery.canvasjs.min.js',
        'added/js/chartjs_js.js',
        'added/source/canvasjs.js',
        'added/source/excanvas.js',
        'added/source/jquery.canvasjs.js',
        'added/img-watermarker/scripts/watermark.js',
        'added/img-watermarker/scripts/watermarker-init.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',        
    ];
}
