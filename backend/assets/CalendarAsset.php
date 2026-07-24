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
class CalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@bower/adminlte/';

    public $css = [
    'backendassets/plugins/font-awesome/css/font-awesome.min.css',
    'backendassets/bootstrap/css/bootstrap.min.css',
    'frontendassets/css/main.css',
    'backendassets/dist/css/AdminLTE.css',
    'backendassets/plugins/fullcalendar/fullcalendar.min.css',
    
    

    ];
    
    public $js = [
    'backendassets/plugins/jQuery/jQuery-2.1.4.min.js',    
    'backendassets/bootstrap/js/bootstrap.min.js',
    'added/jquery-ui.js',    
    'added/moment.js',    
    'backendassets/plugins/fullcalendar/fullcalendar.min.js',    
    'added/calendar.js',    
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
