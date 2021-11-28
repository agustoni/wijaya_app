<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web/web';
    public $css = [
        'js/typeahead/typeahead.min.css',
        'js/typeahead/typeahead-kv.min.css',
        'css/site.css',
        'css/all.css',
        'css/dataTables.bootstrap4.min.css',
        'css/buttons.bootstrap4.min.css',
        'css/busy-load.min.css',
    ];
    public $js = [
        'js/scripts.js',
        'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap4.min.js',
        'js/dataTables.buttons.min.js',
        'js/buttons.bootstrap4.min.js',
        'js/moment.min.js',
        'js/datetime-moment.js',
        'js/typeahead/handlebars.min.js',
        'js/typeahead/typeahead.bundle.min.js',
        'js/typeahead/typeahead.jquery.min.js',
        'js/typeahead/typeahead-kv.min.js',
        'js/busy-load.min.js',
    ];
    // public $jsOptions = [
    //     'position' => \yii\web\View::POS_HEAD
    // ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
