<?php
//namespace frontend\assets;
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/bower_components/bootstrap/dist/css/bootstrap.min.css',
        'css/bower_components/font-awesome/css/font-awesome.min.css',
        'css/bower_components/Ionicons/css/ionicons.min.css',
        'css/dist/css/AdminLTE.min.css',
        'css/dist/css/skins/_all-skins.min.css',
        'css/bower_components/morris.js/morris.css',
        'css/bower_components/jvectormap/jquery-jvectormap.css',
        'css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'css/bower_components/bootstrap-daterangepicker/daterangepicker.css',
        'css/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
        'css/bootstrap-tokenfield.css',
        'css/drag.css',
        'css/dragula.css',
        'css/radio.css',
        'css/themes/metro/easyui.css',
        'css/themes/icon.css',
        'css/plugins/timepicker/bootstrap-timepicker.css',
        //'css/demo.css'



    ];
    public $js = [

        'js/jquery-ui/jquery-ui.min.js',
        'bower_components/raphael/raphael.min.js',
        'bower_components/morris.js/morris.min.js',
        'bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
        'css/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'css/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'css/plugins/timepicker/bootstrap-timepicker.js',
        'bower_components/jquery-knob/dist/jquery.knob.min.js',
        'bower_components/moment/min/moment.min.js',
        'bower_components/bootstrap-daterangepicker/daterangepicker.js',
        'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        'css/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
        'bower_components/fastclick/lib/fastclick.js',
        'js/adminlte.min.js',
        'js/pages/dashboard.js',
        'js/pages/dashboard2.js',
        'js/demo.js',
        'js/main.js',
        'js/bootstrap-tokenfield.js',
        'js/jquery.form.js',
        'js/jeasyui.js',
        'https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
