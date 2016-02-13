<?php
/**
 * @copyright Copyright (c) 2016 Vladyslav Holovko (vlad.holovko@gmail.com)
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace limion\jqueryfileupload;

use yii\web\AssetBundle;

class jQueryFileUploadAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-file-upload';
    public $css = [
        'css/jquery.fileupload.css',
    ];
    public $js = [
        // <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        "js/vendor/jquery.ui.widget.js",
        // <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        "js/jquery.iframe-transport.js",
        // <!-- The basic File Upload plugin -->
        "js/jquery.fileupload.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        //'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
