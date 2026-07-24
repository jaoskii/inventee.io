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
class BackendAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $sourcePath = '@bower/adminlte/';

    public $publishOptions = [
    'forceCopy' => true,
    ]; 

    public $css = [
        'backendassets/bootstrap/css/bootstrap.min.css',
        'backendassets/plugins/font-awesome/css/font-awesome.min.css',
        'backendassets/dist/css/AdminLTE.css',
        'backendassets/dist/css/skins/_all-skins.css',
        'added/css/scrollable-tbl.css',
        'added/css/modify_uploadbtn.css',
        'added/css/scrollable-divs.css',
        'added/css/modified-css.css',
        'added/css/treeview.css',
        //FOR NOTIFICATIONS
        'added/noty/animate.css',
        'backendassets/jao/css/backend-css.css',
        'added/bootstrap-datepicker/css/datepicker.css',
        'backendassets/plugins/fullcalendar/fullcalendar.css',
        'backendassets/plugins/timepicker/bootstrap-timepicker.css',
        'added/tooltipster/css/tooltipster.bundle.min.css',
        'added/bootstrap-horizon/bootstrap-horizon.css',
        'added/chatsupport/frontend/frontend-chat.css',

        //FOR RESPOSIVENESS / MOBILE VIEW
        'backendassets/atmedia/css/atmedia-ipad.css',
        'backendassets/atmedia/dragme/dragme.css',
    ];
    
    public $js = [
        'backendassets/plugins/jQuery/jQuery-2.1.4.min.js',
        'backendassets/bootstrap/js/bootstrap.min.js',
        'backendassets/plugins/jQueryUI/jquery-ui.js',
        'backendassets/plugins/morris/morris.min.js',
        'backendassets/plugins/knob/jquery.knob.js',
        'backendassets/plugins/raphael/raphael.js',
        'backendassets/plugins/slimScroll/jquery.slimscroll.min.js',
        'backendassets/dist/js/app.min.js',
        'backendassets/dist/js/demo.js',
        'backendassets/plugins/fastclick/fastclick.min.js',
        'added/js/treeview.js',
        'added/js/download.js',
        'added/js/jscolor.js', 
        'added/config/ajax_config.js',
        'backendassets/jao/js/backend-scripts.js',
        'backendassets/jao/js/modal-onload-scripts.js',
        
        //NEWLY ADDED SCRIPTS (TO DIVIDE BACKEND SCRIPTS FROM EVENTS AND FUNCTIONS)
        //AND TO HAVE SEVERAL FUNCTIONS NOT MIXED UP
        'backendassets/jao/js/table-constructor.js',//override alvin 12/27/2017
        'backendassets/jao/js/module-addedtab-functions.js',
        'backendassets/jao/js/combo-option-loader.js',
        'backendassets/jao/js/global-functions.js',//edited alvin 12/27/2017
        'backendassets/jao/js/debugging-functions.js',
        'backendassets/jao/js/reporting-scripts.js',
        'backendassets/jao/js/gridview-scripts.js', //override alvin 12/27/2017
        'backendassets/jao/js/modal-contructor.js', //override alvin 12/27/2017
        'backendassets/jao/js/quotation-generator.js',
        'backendassets/jao/js/modal-constructor.js',//override alvin 12/27/2017
        'backendassets/jao/js/chartgenerator.js',
        'backendassets/jao/js/quickadd-scripts.js',
        'backendassets/jao/js/automator-scripts.js',
        'backendassets/jstester/tester_script.js',

        'backendassets/jao/js/pos-scripts.js',
        'added/js/chatsupport.js',

        'added/js/extractor.js',
        //FOR NOTY SCRIPT ALERTS
        'added/noty/jquery.noty.packaged.js',
        'added/noty/noty-common.js',
        //FOR JQUERY NUMBER FORMATTING
        'added/js/jquery.number.js',
        'added/js/jquery.hotkeys.js',
        'added/js/shortcuts.js',
        //FOR DATEPICKER
        'added/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'added/bootstrap-datepicker/js/datepicker-ini.js',
        'added/js/moment.js',
        'backendassets/plugins/fullcalendar/fullcalendar.js',
        'added/js/calendar.js',
        'backendassets/plugins/timepicker/bootstrap-timepicker.js',
        'added/js/timepicker.js',
        'added/tooltipster/js/tooltipster.bundle.min.js',
        'added/js/URI.js',
        'added/tinymce/tinymce.js',
        'added/tinymce/init-tinymce.js',
        
        'added/chatsupport/floatingChatbox.js',
        'added/chatsupport/frontend/frontend-chat.js',
        
        //DRAGGABLE MENU (MOBILE VIEW)
        'backendassets/atmedia/dragme/dragme.js',
        'backendassets/atmedia/dragme/jquery.ui.touch-puch.min.js',

        //SCRIPTS FOR DASHBOARD
        //By Aa asset admin lTE
        'added/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
        'added/bower_components/chart.js/Chart.js',
        //'added/dist/js/pages/dashboard2.js',

        //WATERMARKS ENABLER
        'added/img-watermarker/scripts/watermark.js',
        'added/img-watermarker/scripts/watermarker-init.js',
        '//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js',
        'backendassets/jao/js/clipboard_init.js',

        'added/typeahead/bloodhound.js',
        'added/typeahead/typeahead.bundle.js',
        'added/typeahead/typeahead.jquery.js',        
        'added/typeahead/typehead-init.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',        
    ];
}
